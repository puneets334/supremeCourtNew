<?php

namespace App\Models\Common;
use CodeIgniter\Model;
class Common_model extends Model {

    function __construct() {
// Call the Model constructor
        parent::__construct();
    }

    function get_establishment_details() {

        $this->db->SELECT("id,estab_name, estab_code, access_ip,
                    enable_payment_gateway, is_charging_printing_cost, printing_cost,payment_gateway_params,pg_request_function,pg_response_function,
                      is_pet_state_required, is_pet_district_required, is_res_state_required, is_res_district_required, 
                      is_pet_mobile_required, is_pet_email_required, is_res_mobile_required, is_res_email_required,
                      is_extra_pet_state_required, is_extra_pet_district_required, is_extra_res_state_required, is_extra_res_district_required,
                      is_extra_pet_mobile_required, is_extra_pet_email_required, is_extra_res_mobile_required, is_extra_res_email_required");

        $this->db->FROM('efil.m_tbl_establishments');
        $this->db->WHERE('display', 'Y');
        $this->db->ORDER_BY("estab_name", "asc");

        $query = $this->db->get();

        if ($query->num_rows() >= 1) {

            $estab_details = $query->result_array();

            $this->session->set_userdata(array('estab_details' => $estab_details[0]));

            $_SESSION['estab_details']['efiling_for_type_id'] = E_FILING_FOR_SUPREMECOURT;
            $_SESSION['estab_details']['efiling_for_id'] = escape_data($estab_details[0]['id']);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_efiling_num_basic_Details($registration_id) {

        $this->db->SELECT("en.registration_id, en.efiling_no, en.efiling_year, en.ref_m_efiled_type_id, et.efiling_type,
                en.efiling_for_type_id, en.efiling_for_id, 
                en.breadcrumb_status, en.signed_method, en.allocated_to,
                en.created_by, en.sub_created_by,                
                cs.stage_id, cs.activated_on,
                (select gras_payment_status payment_status from efil.tbl_court_fee_payment where registration_id = en.registration_id order by id desc limit 1 )");

        $this->db->FROM('efil.tbl_efiling_nums as en');
        $this->db->JOIN('efil.tbl_efiling_num_status as cs', 'en.registration_id = cs.registration_id');
        $this->db->JOIN('efil.m_tbl_efiling_type as et', 'en.ref_m_efiled_type_id = et.id');
        $this->db->WHERE('cs.is_active', 'TRUE');
        $this->db->WHERE('cs.is_deleted', 'FALSE');
        $this->db->WHERE('en.is_active', 'TRUE');
        $this->db->WHERE('en.is_deleted', 'FALSE');
        $this->db->WHERE('en.registration_id', $registration_id);
        $query = $this->db->get();

        if ($query->num_rows() >= 1) {

            $efiling_details = $query->result_array();

            $this->session->set_userdata(array('efiling_details' => $efiling_details[0]));

            return TRUE;
        } else {
            return false;
        }
    }

    function get_intials_defects_remarks($registration_id, $current_stage_id) {
        if (empty($registration_id)) {
            return FALSE;
        }
        $this->db->SELECT('*');
        $this->db->FROM('efil.tbl_initial_defects');
        $this->db->WHERE('is_approved', FALSE);
        if (in_array($current_stage_id, array(Initial_Defected_Stage, DEFICIT_COURT_FEE, I_B_Defected_Stage, I_B_Rejected_Stage, E_REJECTED_STAGE, LODGING_STAGE, DELETE_AND_LODGING_STAGE))) {
            $this->db->WHERE('is_defect_cured', FALSE);
        } elseif (in_array($current_stage_id, array(Initial_Approaval_Pending_Stage, Initial_Defects_Cured_Stage, DEFICIT_COURT_FEE_PAID,
                    I_B_Approval_Pending_Stage, I_B_Approval_Pending_Admin_Stage, I_B_Defects_Cured_Stage))) {
            $this->db->WHERE('is_defect_cured', TRUE);
        }
        $this->db->WHERE('registration_id', $registration_id);
        $this->db->ORDER_BY('initial_defects_id', 'DESC');

        $query = $this->db->get();

        if ($query->num_rows() >= 1) {
            $arr = $query->result();
            return $arr[0];
        } else {
            return false;
        }
    }
    
    function updateCaseStatus($registration_id, $next_stage) {
        $this->db->trans_start();
         
            $update_data = array(
                'deactivated_on' => date('Y-m-d H:i:s'),
                'is_active' => FALSE,
                'updated_by' => $_SESSION['login']['id'],
                'updated_by_ip' => getClientIP()
            );
      
        $this->db->WHERE('registration_id', $registration_id);
        $this->db->WHERE('is_active', TRUE);
        $this->db->UPDATE('efil.tbl_efiling_num_status', $update_data);
        if ($this->db->affected_rows() > 0) {

            if ($next_stage == Initial_Approaval_Pending_Stage) {
                $assign_to = $this->assign_efiling_number($_SESSION['estab_details']['efiling_for_type_id'], $_SESSION['estab_details']['efiling_for_id']);
                $nums_data_update = array(
                    'allocated_to' => $assign_to[0]['id'],
                    'allocated_on' => date('Y-m-d H:i:s'));

                $this->db->WHERE('registration_id', $registration_id);
                $this->db->WHERE('is_active', TRUE);
                $this->db->UPDATE('efil.tbl_efiling_nums', $nums_data_update);


                if ($this->db->affected_rows() > 0) {

                    $data = array('registration_id' => $registration_id,
                        'admin_id' => $assign_to[0]['id'],
                        'allocated_on' => date('Y-m-d H:i:s'),
                        'updated_by' => $_SESSION['login']['id'],
                        'updated_on' => date('Y-m-d H:i:s'),
                        'update_ip' => getClientIP(),
                        'reason_to_allocate' => NULL);

                    $this->db->INSERT('efil.tbl_efiling_allocation', $data);
                    if ($this->db->insert_id()) {
                        $action_res = TRUE;
                    } else {
                        $action_res = FALSE;
                    }
                } else {
                    $action_res = FALSE;
                }
            } else {
                $action_res = TRUE;
            }

            if ($action_res) {
                $proceed = false;
                if ($next_stage == Initial_Defects_Cured_Stage || $next_stage == DEFICIT_COURT_FEE_PAID || $next_stage == I_B_Defects_Cured_Stage) {
                    $update_def = array(
                        'is_active' => FALSE,
                        'is_defect_cured' => TRUE,
                        'defect_cured_date' => date('Y-m-d H:i:s'),
                        'updated_by' => $_SESSION['login']['id'],
                        'ip_address' => getClientIP()
                    );

                    $this->db->WHERE('registration_id', $registration_id);
                    $this->db->WHERE('is_active', TRUE);
                    $this->db->UPDATE('efil.tbl_initial_defects', $update_def);
                    if ($this->db->affected_rows() > 0) {
                        $proceed = TRUE;
                    }
                } else {
                    $proceed = TRUE;
                }
                if ($proceed) {
                    $insert_data = array(
                        'registration_id' => $registration_id,
                        'stage_id' => $next_stage,
                        'activated_on' => date('Y-m-d H:i:s'),
                        'is_active' => TRUE,
                        'activated_by' => $_SESSION['login']['id'],
                        'activated_by_ip' => getClientIP()
                    );
                    $this->db->INSERT('efil.tbl_efiling_num_status', $insert_data);
                    if ($this->db->insert_id()) {
                        $this->db->trans_complete();
                    }
                }
            }
        }
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function assign_efiling_number($efiling_for_type_id, $efiling_for_id) {

        $query = "SELECT users.id,  users.ref_m_usertype_id, users.admin_for_type_id, users.admin_for_id, count(allocated_on) efiling_num_count
                FROM efil.tbl_users users
                LEFT JOIN efil.tbl_efiling_nums en ON en.allocated_to = users.id AND to_char(en.allocated_on,'YYYY-MM-DD')::date ='" . date('Y-m-d') . "'
                WHERE users.admin_for_type_id ='" . $efiling_for_type_id . "' AND users.admin_for_id ='" . $efiling_for_id . "' AND
                users.is_deleted IS TRUE AND
                users.ref_m_usertype_id IN(" . USER_ADMIN . "," . USER_ACTION_ADMIN . ")                  
                GROUP BY users.id,users.ref_m_usertype_id,users.admin_for_type_id,users.admin_for_id ORDER BY efiling_num_count";


        $query = $this->db->query($query);

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    

}

?>
