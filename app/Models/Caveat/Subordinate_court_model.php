<?php

namespace App\Models\Caveat;
use CodeIgniter\Model;

class Subordinate_court_model extends Model {

    function __construct() {
        parent::__construct();
    }

    function get_main_matter_details($registration_id) {

        $this->db->SELECT('registration_id,main_matter_cnr_num,main_matter_case_type_name ,main_matter_case_num,main_matter_case_year,main_matter_pet_name,main_matter_res_name,main_matter_court_name');
        $this->db->FROM('tbl_cis_masters_values');
        $this->db->WHERE('registration_id', $registration_id);
        $this->db->ORDER_BY("id", "asc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    function get_efiling_civil_details($registration_id) {

        $this->db->SELECT("tbl_efiling_nums.*,tbl_efiling_caveat.*,
                (CASE WHEN tbl_efiling_nums.efiling_for_type_id =" . E_FILING_FOR_ESTABLISHMENT . " THEN 
                    (SELECT concat(estname,', ',dist_name,', ',state)  
                    FROM m_tbl_establishments est
                        LEFT JOIN m_tbl_state st on est.state_code = st.state_id
                        LEFT JOIN m_tbl_districts dist on est.ref_m_tbl_districts_id = dist.id
                        WHERE est.id = tbl_efiling_nums.efiling_for_id ) 
                ELSE (SELECT concat(hc_name,' High Court')
                FROM m_tbl_high_courts hc
                WHERE hc.id = tbl_efiling_nums.efiling_for_id) END ) 
                as efiling_for_name");
        $this->db->FROM('tbl_efiling_nums');
        $this->db->JOIN('tbl_efiling_caveat', 'tbl_efiling_nums.registration_id = tbl_efiling_caveat.ref_m_efiling_nums_registration_id');
        $this->db->WHERE('tbl_efiling_nums.registration_id', $registration_id);
        $this->db->WHERE('tbl_efiling_nums.is_active', TRUE);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

    function update_breadcrumbs($registration_id, $breadcrumb_step) {

        $old_breadcrumbs = $_SESSION['efiling_details']['breadcrumb_status'] . ',' . $breadcrumb_step;
        $old_breadcrumbs_array = explode(',', $old_breadcrumbs);
        $new_breadcrumbs_array = array_unique($old_breadcrumbs_array);

        sort($new_breadcrumbs_array);
        $new_breadcrumbs = implode(',', $new_breadcrumbs_array);

        $this->db->WHERE('registration_id', $registration_id);
        $this->db->UPDATE('efil.tbl_efiling_nums', array('breadcrumb_status' => $new_breadcrumbs));

        if ($this->db->affected_rows() > 0) {
            $_SESSION['efiling_details']['breadcrumb_status'] = $new_breadcrumbs;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function add_subordinate_court_info($registration_id, $data, $cis_masters_values)
    {
        $this->db->INSERT('etrial_lower_court', $data);
        if ($this->db->insert_id()) {
            $status = $this->update_breadcrumbs($registration_id, CAVEAT_BREAD_SUBORDINATE_COURT);
//            if ($status) {
//                if (!empty($cis_masters_values)) {
//                    $success = $this->update_cis_master_values($registration_id, $cis_masters_values);
//                    if ($success) {
//                        $this->db->trans_complete();
//                    }
//                } else {
//                    $this->db->trans_complete();
//                }
//
//                if (!empty($trial_cis_masters_values)) {
//                    $success = $this->update_cis_master_values($registration_id, $trial_cis_masters_values);
//                    if ($success) {
//                        $this->db->trans_complete();
//                    }
//                } else {
//                    $this->db->trans_complete();
//                }
//            }
        }
        if (empty($status)) {
            return FALSE;
        } else {
            return $this->db->insert_id();
        }
    }

    function update_subordinate_court_info($id, $registration_id, $data, $cis_masters_values) {

        $this->db->trans_start();

        $this->db->WHERE('registration_id', $registration_id);
        $this->db->WHERE('id', $id);
        $this->db->UPDATE('etrial_lower_court', $data);

        if ($this->db->affected_rows() > 0) {

            $status = $this->update_breadcrumbs($registration_id, CAVEAT_BREAD_SUBORDINATE_COURT);
            if ($status) {
                if (!empty($cis_masters_values)) {
                    $success = $this->update_cis_master_values($registration_id, $cis_masters_values);
                    if ($success) {
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

    function add_subordinate($registration_id, $data, $cis_masters_values) {

        $this->db->trans_start();
        $this->db->WHERE('ref_m_efiling_nums_registration_id', $registration_id);
        $this->db->UPDATE('tbl_efiling_caveat', $data);
        if ($this->db->affected_rows() > 0) {

            $status = $this->update_breadcrumbs($registration_id, CAVEAT_BREAD_SUBORDINATE_COURT);
            if ($status) {
                if (!empty($cis_masters_values)) {
                    $success = $this->update_cis_master_values($registration_id, $cis_masters_values);
                    if ($success) {
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

    function update_cis_master_values($registration_id, $data) {

        $this->db->WHERE('registration_id', $registration_id);
        $query = $this->db->get('tbl_cis_masters_values');
        if ($query->num_rows() > 0) {
            $this->db->WHERE('registration_id', $registration_id);
            $result = $this->db->UPDATE('tbl_cis_masters_values', $data);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            $cis_masters_values = array(
                'registration_id' => $registration_id,
                'pet_org_name' => $data['pet_org_name'],
                'filcase_type_name' => $data['filcase_type_name'],
                'pet_caste_name' => $data['pet_caste_name'],
                'pet_state_name' => $data['pet_state_name'],
                'pet_distt_name' => $data['pet_distt_name'],
                'pet_taluka_name' => $data['pet_taluka_name'],
                'pet_town_name' => $data['pet_town_name'],
                'pet_ward_name' => $data['pet_ward_name'],
                'pet_village_name' => $data['pet_village_name'],
                'pet_ps_name' => $data['pet_ps_name'],
                'police_st_state_name' => $data['police_state_name'],
                'police_st_dist_name' => $data['police_distt_name'],
                'police_station_name' => $data['police_station_name'],
                'fir_type_name' => $data['fir_type_name'],
                'investigation_agency' => $data['investigation_agency'],
                'trials_name' => $data['trials_name'],
                'ia_case_type_name' => $data['ia_case_type_name'],
                'ia_act_name' => $data['ia_act_name'],
                'ia_classification_name' => $data['ia_classification_name'],
                'ia_prayer_name' => $data['ia_prayer_name'],
                'ia_purpose_name' => $data['ia_purpose_name'],
                'bench_name' => $data['bench_name'],
                'high_court_case_type' => $data['high_court_case_type'],
                'pet_relation' => $data['pet_relation']
            );
            $result = $this->db->INSERT('tbl_cis_masters_values', $cis_masters_values);
            if ($this->db->insert_id()) {
                return true;
            } else {
                return false;
            }
        }
    }

    function get_subordinate_court_details($registration_id) {

        $this->db->SELECT('elc.*,cmv.app_court_state_name,cmv.app_court_distt_name,cmv.app_court_sub_court_name,
                cmv.trial_court_state_name,cmv.trial_court_distt_name,cmv.trial_court_sub_court_name,cmv.trial_court_case_type');
        $this->db->FROM('etrial_lower_court elc');
        $this->db->JOIN('tbl_cis_masters_values cmv', 'cmv.registration_id = elc.registration_id');
        $this->db->WHERE('cmv.registration_id', $registration_id);
        $this->db->WHERE('is_deleted', FALSE);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }
    function get_subordinate_court_without_cis_master($registration_id) {
        $output = false;
        if(isset($registration_id) && !empty($registration_id)){
            $this->db->distinct('st.state_name');
            $this->db->SELECT('elc.*,st.state_name,mtdce.estab_name,mtdce.district_name,hcb.name bench_name,hcb.cmis_state_id,hcb.ref_agency_code_id,thcb.name high_court_name,
                               ras.agency_state,concat(rac.short_agency_name, rac.agency_name) agency_name ,lhc.type_sname case_name,fir.state_name fir_state_name,
                                fir.district_name fir_district_name, fir.police_station_name fir_police_station_name,fir.complete_fir_no fir_complete_fir_no');
            $this->db->FROM('etrial_lower_court elc');
            $this->db->JOIN('efil.m_tbl_district_courts_establishments st', 'elc.lower_state_id = st.state_code','left');
            $this->db->JOIN('efil.m_tbl_district_courts_establishments mtdce', 'elc.lower_court_code = mtdce.estab_code','left');
            $this->db->JOIN('efil.m_tbl_high_courts_bench hcb', 'elc.bench_code = hcb.est_code','left');
            $this->db->JOIN('efil.m_tbl_high_courts_bench thcb','elc.court_id = thcb.hc_id AND thcb.est_code is NULL','left');
            $this->db->JOIN('icmis.ref_agency_state ras','elc.lower_state_id = ras.cmis_state_id ','left');
            $this->db->JOIN('icmis.ref_agency_code rac','elc.lower_dist_code = rac.id ','left');
            $this->db->JOIN('icmis.lc_hc_casetype lhc','elc.case_type = lhc.lccasecode ','left');
            $this->db->JOIN('efil.tbl_fir_details fir','elc.id = fir.ref_tbl_lower_court_details_id ','left');
            $this->db->WHERE('elc.registration_id', $registration_id);
            $this->db->WHERE('elc.is_deleted', FALSE);
            $query = $this->db->get();
            $output = $query->result_array();
            }
        return $output ;
    }
    function get_district($state_code,$district_code=null)
    {
        $this->db->distinct('mtdce.district_name');
        $this->db->select('mtdce.district_name,mtdce.district_code');
        $this->db->from('efil.m_tbl_district_courts_establishments mtdce');
        if (!empty($state_code) && $state_code !=null) {
            $this->db->where('mtdce.state_code', $state_code);
        }
        if (!empty($district_code) && $district_code !=null) {
            $this->db->where('mtdce.district_code', $district_code);
        }
        $this->db->order_by('mtdce.district_name', 'ASC');
        $query = $this->db->get();
        return $output = $query->result_array();
    }
    function subordinate_court_details_for_dc($registration_id) {

        $this->db->SELECT('lower_court_state, lower_court_district, lower_court_code, lower_cino, lower_court, filing_case, lower_judge_name, lower_court_dec_dt , lcc_applied_date , lcc_received_date,  ');
        $this->db->FROM('tbl_efiling_caveat');
        $this->db->WHERE('ref_m_efiling_nums_registration_id', $registration_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }
    

    function already_added_sub_court_info($registration_id, $appellate_trial) {

        $this->db->SELECT('appellate_trial,sub_qj_high');
        $this->db->FROM('etrial_lower_court');
        $this->db->WHERE('etrial_lower_court.registration_id', $registration_id);
        $this->db->WHERE('etrial_lower_court.appellate_trial', $appellate_trial);
        $this->db->WHERE('is_deleted', FALSE);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

    function check_subordinate_entry($registration_id, $ids) {

        $this->db->SELECT('appellate_trial,sub_qj_high');
        $this->db->FROM('etrial_lower_court');
        $this->db->WHERE('etrial_lower_court.registration_id', $registration_id);
        $this->db->WHERE_IN('etrial_lower_court.sub_qj_high', $ids);
        $this->db->WHERE('is_deleted', FALSE);
        $query = $this->db->get();
       // echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

    function reset_subordinate_court_data($registration_id) {
        $data = array('is_deleted' => TRUE);
        $this->db->WHERE('id', $registration_id);
        $this->db->WHERE('is_deleted', FALSE);
        $this->db->UPDATE('etrial_lower_court', $data);
        if ($this->db->affected_rows() > 0) {
            $cis_masters_values = array(
                'app_court_state_name' => NULL,
                'app_court_distt_name' => NULL,
                'app_court_sub_court_name' => NULL,
                'app_court_sub_case_type' => NULL,
                'trial_court_state_name' => NULL,
                'trial_court_distt_name' => NULL,
                'trial_court_sub_court_name' => NULL,
                'trial_court_case_type' => NULL,
                'high_court_case_type' => NULL
            );
            // comment cis_master_values for no use
           // $success = $this->update_cis_master_values($registration_id, $cis_masters_values);
            $success = true;
            if ($success) {
                $status = $this->remove_breadcrumb($registration_id, CAVEAT_BREAD_SUBORDINATE_COURT);
                if ($status) {
                    return TRUE;
                }
                else {
                    return TRUE;
                }
            }
        }
    }

    function remove_breadcrumb($registration_id, $breadcrumb_to_remove) {

        $breadcrumbs_array = explode(',', $_SESSION['efiling_details']['breadcrumb_status']);

        if (in_array($breadcrumb_to_remove, $breadcrumbs_array)) {


            $index = array_search($breadcrumb_to_remove, $breadcrumbs_array);
            if ($index !== false) {
                unset($breadcrumbs_array[$index]);
            }

            $new_breadcrumbs = implode(',', $breadcrumbs_array);

            $this->db->WHERE('registration_id', $registration_id);
            $this->db->UPDATE('efil.tbl_efiling_nums', array('breadcrumb_status' => $new_breadcrumbs));

            if ($this->db->affected_rows() > 0) {
                $_SESSION['efiling_details']['breadcrumb_status'] = $new_breadcrumbs;
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

}

?>
