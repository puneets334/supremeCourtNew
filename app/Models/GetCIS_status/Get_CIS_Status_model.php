<?php

namespace App\Models\GetCIS_status;
use CodeIgniter\Model;

class Get_CIS_Status_model extends Model {

    function __construct() {
// Call the Model constructor
        parent::__construct();
    }

    function get_icmis_objections_list($registration_id) {

        $this->db->SELECT('*');
        $this->db->FROM('efil.tbl_icmis_objections');
        $this->db->WHERE('registration_id', $registration_id);
        $this->db->WHERE('obj_removed_date', NULL);
        $this->db->WHERE('is_deleted', FALSE);
        $query = $this->db->get();

        if ($query->num_rows()>= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_efiled_docs_list($registration_id, $ia_only) {

        $ia_doc_type = 8;

        $this->db->SELECT('ed.doc_id'); //,sub_dm.docdesc
        $this->db->FROM('efil.tbl_efiled_docs ed');
        $this->db->JOIN('icmis.docmaster dm', 'ed.doc_type_id = dm.doccode AND ed.sub_doc_type_id = dm.doccode1 and dm.display!=\'N\'');
        $this->db->WHERE('ed.registration_id', $registration_id);
        if ($ia_only) {
            $this->db->WHERE('ed.doc_type_id', $ia_doc_type);
        }
        $this->db->WHERE('ed.is_active', TRUE);
        $this->db->WHERE('ed.is_deleted', FALSE);
        $this->db->ORDER_BY('ed.index_no');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
    }

    function update_icmis_case_status($registration_id, $next_stage, $curr_dt, $case_details, $objections_insert, $objections_update, $documents_update,$efiling_type=null) {
        $this->db->trans_start();
        if(isset($case_details) && !empty($case_details)){
//            $this->db->WHERE('registration_id',$registration_id);
//            $this->db->update_batch('efil.tbl_case_details', $case_details, 'registration_id');
            if(isset($efiling_type) && !empty($efiling_type) && $efiling_type == 'new_case'){
                if(!empty($case_details)){
                    $this->db->WHERE('registration_id',$registration_id);
                    $this->db->update('efil.tbl_case_details', $case_details);
                }
                else{
                    $this->db->WHERE('registration_id',$registration_id);
                    $this->db->update_batch('efil.tbl_case_details', $case_details, 'registration_id');
                }
            }
            else if(!isset($efiling_type) && empty($efiling_type)){
                $this->db->WHERE('registration_id',$registration_id);
                $this->db->update_batch('efil.tbl_case_details', $case_details, 'registration_id');
            }
            else  if(isset($case_details) && !empty($case_details) && isset($efiling_type) && !empty($efiling_type) && $efiling_type == 'caveat'){
                $this->db->WHERE('ref_m_efiling_nums_registration_id',$registration_id);
                $this->db->update('public.tbl_efiling_caveat', $case_details);
            }
        }

        if (isset($objections_insert) && !empty($objections_insert)) {
            $this->db->insert_batch('efil.tbl_icmis_objections', $objections_insert);
        }

        if (isset($objections_update) && !empty($objections_update)) {
            $this->db->update_batch('efil.tbl_icmis_objections', $objections_update, 'id');
        }
        
        if (isset($documents_update) && !empty($documents_update)) {
            $this->db->update_batch('efil.tbl_efiled_docs', $documents_update, 'doc_id');
        }

        if ($next_stage) {
            $res = $this->update_next_stage($registration_id, $next_stage, $curr_dt);
        }

        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            $this->db->trans_complete();
            return TRUE;
        }
    }
    
    function update_misc_doc_ia_status($registration_id, $next_stage, $curr_dt, $objections_insert, $objections_update, $documents_update) {
//echo "<pre>"; print_r(func_get_args());die;
        $this->db->trans_start();       
        

        if (isset($objections_insert) && !empty($objections_insert)) {
            $this->db->insert_batch('efil.tbl_icmis_objections', $objections_insert);
        }

        if (isset($objections_update) && !empty($objections_update)) {
            $this->db->update_batch('efil.tbl_icmis_objections', $objections_update, 'id');
        }
        
        if (isset($documents_update) && !empty($documents_update)) {
            $this->db->update_batch('efil.tbl_efiled_docs', $documents_update, 'doc_id');
        }

        if ($next_stage) {
            $this->update_next_stage($registration_id, $next_stage, $curr_dt);
        }

        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            $this->db->trans_complete();
            return TRUE;
        }
    }

    function update_next_stage($registration_id, $next_stage, $curr_dt) {
        $update_data = array(
            'deactivated_on' => $curr_dt,
            'is_active' => FALSE,
            'updated_by' => $_SESSION['login']['id'],
            'updated_by_ip' => $_SERVER['REMOTE_ADDR']
        );
        $this->db->WHERE('registration_id', $registration_id);
        $this->db->WHERE('is_active', TRUE);
        $this->db->UPDATE('efil.tbl_efiling_num_status', $update_data);

        $insert_data = array(
            'registration_id' => $registration_id,
            'stage_id' => $next_stage,
            'activated_on' => $curr_dt,
            'is_active' => TRUE,
            'activated_by' => $_SESSION['login']['id'],
            'activated_by_ip' => $_SERVER['REMOTE_ADDR']
        );
        $this->db->INSERT('efil.tbl_efiling_num_status', $insert_data);
        if ($this->db->insert_id()) {
            return TRUE;
        } else {
            return FALSE;
        }

    }
    
    function get_stage_update_timestamp($registration_id, $stage_id){
        $this->db->SELECT('activated_on');
        $this->db->FROM('efil.tbl_efiling_num_status');
        $this->db->WHERE('stage_id', $stage_id);        
        $this->db->WHERE("registration_id", $registration_id );
        $this->db->WHERE('is_active', TRUE);        
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
    }
    function getStageUpdateTmestampCaseCaveat($registration_id, $stage_id,$diaryStatus){
        $output =false;
        if(isset($registration_id) && !empty($registration_id) &&
            isset($stage_id) && !empty($stage_id) && isset($diaryStatus) && !empty($diaryStatus)){
            switch($diaryStatus){
                case 'new_diary' :
                    $this->db->SELECT('activated_on');
                    $this->db->FROM('efil.tbl_efiling_num_status');
                    $this->db->WHERE('stage_id', $stage_id);
                    $this->db->WHERE("registration_id", $registration_id );
                    $this->db->WHERE('is_active', TRUE);
                    $query = $this->db->get();
                    if ($query->num_rows() >= 1) {
                        $output = $query->result_array();
                    } else {
                        $output = false;
                    }
                    break;
                case 'exist_diary' :
                    $this->db->SELECT('activated_on');
                    $this->db->FROM('efil.tbl_efiling_num_status');
                    $this->db->WHERE('stage_id', Transfer_to_IB_Stage);
                    $this->db->WHERE("registration_id", $registration_id );
                    $this->db->WHERE('is_active', false);
                    $query = $this->db->get();
                    if ($query->num_rows() >= 1) {
                        $output = $query->result_array();
                    } else {
                        $this->db->SELECT('activated_on');
                        $this->db->FROM('efil.tbl_efiling_num_status');
                        $this->db->WHERE('stage_id', $stage_id);
                        $this->db->WHERE("registration_id", $registration_id );
                        $this->db->WHERE('is_active', TRUE);
                        $query = $this->db->get();
                        if ($query->num_rows() >= 1) {
                            $output = $query->result_array();
                        } else {
                            $output = false;
                        }
                    }
                    break;
                default :
                    $output =false;
            }
        }
        return $output;

    }


    function update_case_status1($registration_id, $next_stage, $current_date_n_time) {

        if (!(isset($_SESSION['login']['id']) && !empty($_SESSION['login']['id']))) {
            $approved_by = '000';
        } else {
            $approved_by = $_SESSION['login']['id'];
        }

        $update_data = array(
            'deactivated_on' => $current_date_n_time,
            'is_active' => FALSE,
            'updated_by' => $approved_by,
            'updated_by_ip' => $_SERVER['REMOTE_ADDR']
        );

        $this->db->WHERE('registration_id', $registration_id);
        $this->db->WHERE('is_active', TRUE);
        $this->db->UPDATE('efil.tbl_efiling_num_status', $update_data);

        $insert_data = array(
            'registration_id' => $registration_id,
            'stage_id' => $next_stage,
            'activated_on' => $current_date_n_time,
            'is_active' => TRUE,
            'activated_by' => $approved_by,
            'activated_by_ip' => $_SERVER['REMOTE_ADDR']
        );

        if ($this->db->affected_rows() > 0) {
            $this->db->INSERT('efil.tbl_efiling_num_status', $insert_data);
            if ($this->db->insert_id()) {
                
            }
        }
    }

    function add_defect_message($data) {

        $this->db->INSERT('tbl_initial_defects', $data);
        if ($this->db->insert_id()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function update_multi_records_CIS_Status($new_case_records, $efiling_nums_new_case, $current_date_n_time, $is_cron) {
//echo "<pre>"; print_r(func_get_args());die;        
//return true;
        $case_data_to_update = $new_case_records['case_data_to_update'];
        $defects_to_update = $new_case_records['defects_to_update'];
        $defects_to_insert = $new_case_records['defects_to_insert'];
        $stage_to_update = $new_case_records['stage_to_update'];

        $this->db->trans_start();

// CASE DATA

        if (!empty($case_data_to_update)) {
            $this->db->update_batch('efil.tbl_case_details', $case_data_to_update, 'registration_id');
        }
        if (!empty($defects_to_update)) {
            $this->db->update_batch('efil.tbl_initial_defects', $defects_to_update, 'initial_defects_id');
        }
        if (!empty($defects_to_insert)) {
            $this->db->insert_batch('efil.tbl_initial_defects', $defects_to_insert);
        }
        if (!empty($stage_to_update)) {
            foreach ($stage_to_update as $stage) {
                $this->update_case_status($stage['registration_id'], $stage['stage_id'], $current_date_n_time);
            }
        }

        if ($is_cron) {

            $status_detail = array(
                'new_case_efiling_nums' => $efiling_nums_new_case,
                'new_case_records_status' => $new_case_records['new_case_records_count'],
                'case_data_to_update' => $case_data_to_update,
                'defects_to_update' => $defects_to_update,
                'defects_to_insert' => $defects_to_insert,
                'stage_to_update' => $stage_to_update,
                'current_date_n_time' => $current_date_n_time
            );
            $this->save_cron_status(array('responce' => json_encode($status_detail), 'cron_date' => $current_date_n_time, 'cron_type' => 'eFiling CIS Status', 'remote_ip' => $_SERVER['REMOTE_ADDR']));
        }

        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            $this->db->trans_complete();
            return TRUE;
        }
    }

    function update_case_details_from_CIS($registration_id, $case_details, $next_stage, $defect) {

        $this->db->trans_start();
        $this->db->WHERE('ref_m_efiling_nums_registration_id', $registration_id);
        $this->db->UPDATE("tbl_efiling_civil", $case_details);
        if ($this->db->affected_rows() > 0) {

            $stage_update = $this->Efiled_cases_model->update_case_status($registration_id, $next_stage);

            if ($stage_update) {
                if (!empty($defect) && $defect != NULL) {
                    $update_defects = $this->Efiled_cases_model->add_defect_message($defect);
                    if ($update_defects) {
                        $this->db->trans_complete();
                    }
                } else {
                    $this->db->trans_complete();
                }
            }
        }
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

//On the Basis of Local and Remote status
    public function update_case_status_on_cino($registration_id, $curr_stage, $next_stage, $scrutiny_date, $obj_rej = NULL) {

        $this->db->trans_start();
        if (isset($registration_id) && !empty($registration_id)) {

            if ($registration_id != '') {
                $update_data = array(
                    'deactivated_on' => date('Y-m-d H:i:s'),
                    'is_active' => FALSE,
                    'updated_by' => $_SESSION['login']['id'],
                    'updated_by_ip' => $_SERVER['REMOTE_ADDR']
                );

                $this->db->WHERE('registration_id', $registration_id);
                $this->db->WHERE('is_active', TRUE);
                $this->db->UPDATE('efil.tbl_efiling_num_status', $update_data);
                $insert_data = array(
                    'registration_id' => $registration_id,
                    'stage_id' => $next_stage,
                    'activated_on' => date('Y-m-d H:i:s'),
                    'is_active' => TRUE,
                    'activated_by' => $_SESSION['login']['id'],
                    'activated_by_ip' => $_SERVER['REMOTE_ADDR']
                );
                if ($this->db->affected_rows() > 0) {
                    $this->db->INSERT('efil.tbl_efiling_num_status', $insert_data);
                    if ($this->db->insert_id()) {
                        if ($curr_stage == I_B_Defects_Cured_Stage) {

                            $initial_defect_exits = FALSE;
                            $initial_defects_update_status = FALSE;

                            $this->db->SELECT('max(initial_defects_id) max_id');
                            $this->db->FROM('tbl_initial_defects');
                            $this->db->WHERE('registration_id', $registration_id);
                            $this->db->WHERE('is_defect_cured', TRUE);
                            $this->db->WHERE('is_approved', FALSE);
                            $query = $this->db->get();
                            $query_result = $query->result();
                            $initial_defect_max_id = $query_result[0]->max_id;

                            if ($initial_defect_max_id != '' && $initial_defect_max_id > 0) {

                                $initial_defect_exits = TRUE;

                                if ($next_stage == E_Filed_Stage) {
                                    $update_defect_data = array(
                                        'is_approved' => TRUE,
                                        'scrutiny_date' => $scrutiny_date,
                                        'approve_date' => date('Y-m-d H:i:s'),
                                        'approved_by' => $_SESSION['login']['id']
                                    );
                                } elseif ($next_stage == I_B_Defected_Stage || $next_stage == I_B_Rejected_Stage) {
                                    $update_defect_data = array(
                                        'is_approved' => TRUE,
                                        'scrutiny_date' => $scrutiny_date,
                                        'still_defective' => TRUE,
                                        'approve_date' => date('Y-m-d H:i:s'),
                                        'approved_by' => $_SESSION['login']['id']
                                    );
                                }

                                $this->db->WHERE('registration_id', $registration_id);
                                $this->db->WHERE('is_defect_cured', TRUE);
                                $this->db->WHERE('is_approved', FALSE);
                                $this->db->WHERE('initial_defects_id', $initial_defect_max_id);
                                $this->db->UPDATE('tbl_initial_defects', $update_defect_data);
                                if ($this->db->affected_rows() > 0) {
                                    $initial_defects_update_status = TRUE;
                                }
                            }
                        }
                        if ($curr_stage == I_B_Defects_Cured_Stage && $initial_defect_exits && $initial_defects_update_status) {
                            if ($obj_rej != NULL) {
                                $obj_rej['registration_id'] = $registration_id;
                                $this->db->INSERT('tbl_initial_defects', $obj_rej);
                                if ($this->db->insert_id()) {
                                    $this->db->trans_complete();
                                    return TRUE;
                                }
                            } else {
                                $this->db->trans_complete();
                                return TRUE;
                            }
                        } elseif ($curr_stage == I_B_Approval_Pending_Admin_Stage) {
                            if ($obj_rej != NULL) {
                                $obj_rej['registration_id'] = $registration_id;
                                $this->db->INSERT('tbl_initial_defects', $obj_rej);
                                if ($this->db->insert_id()) {
                                    $this->db->trans_complete();
                                    return TRUE;
                                }
                            } else {
                                $this->db->trans_complete();
                                return TRUE;
                            }
                        } else {
                            return FALSE;
                        }
                    }
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

// END : Function used to change  efiled nums stage on admin dashboard  for Pending scrutiny,Defective and E-filied Cases 

    public function save_cron_status($data) {

        $this->db->INSERT('cron_for_cis_log', $data);
        if ($this->db->insert_id()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // cron for stage update
    public function countPendingScrutiny($total= null,$stage_ids, $admin_for_type_id=null, $admin_for_id=null) {
        if(isset($total) && !empty($total)){
            $this->db->SELECT('count(en.efiling_no) as total');
        }
        else{
            $this->db->SELECT(array('en.allocated_to','en.efiling_for_type_id', 'en.efiling_for_id', 'en.ref_m_efiled_type_id',
                'en.efiling_no', 'en.efiling_year', 'en.registration_id', 'en.allocated_on',
                'et.efiling_type','cs.stage_id', 'sc_case.diary_no', 'sc_case.diary_year'
            ));
        }
        $this->db->FROM('efil.tbl_efiling_nums as en');
        $this->db->JOIN('efil.tbl_efiling_num_status as cs', 'en.registration_id = cs.registration_id');
        $this->db->JOIN('public.tbl_efiling_caveat as ec', 'en.registration_id = ec.ref_m_efiling_nums_registration_id','left');
        $this->db->JOIN('efil.m_tbl_efiling_type as et', 'en.ref_m_efiled_type_id=et.id');
        $this->db->JOIN('efil.tbl_case_details as new_case_cd', 'en.registration_id = new_case_cd.registration_id', 'left');
        $this->db->JOIN('efil.tbl_misc_docs_ia as mdia', 'en.registration_id = mdia.registration_id', 'left');
        $this->db->JOIN('efil.tbl_sci_cases as sc_case', 'sc_case.diary_no=mdia.diary_no AND sc_case.diary_year = mdia.diary_year', 'left');
        $this->db->JOIN('efil.tbl_users users', 'users.id=en.created_by', 'left');
        $this->db->WHERE('cs.is_active', 'TRUE');
        $this->db->WHERE('en.is_active', 'TRUE');
        $where = '(en.efiling_for_type_id='.$admin_for_type_id .' or en.efiling_for_type_id = '.E_FILING_TYPE_CAVEAT.')';
        $this->db->WHERE($where);
        $this->db->WHERE('en.efiling_for_id', $admin_for_id);
        $this->db->WHERE_IN('cs.stage_id', $stage_ids);
        $this->db->WHERE('en.allocated_to !=', 0);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }


}
