<?php

namespace App\Models\Caveat;
use CodeIgniter\Model;

class Extra_party_model extends Model {

    function __construct() {
        parent::__construct();
    }

    function add_extra_party($data, $registration_id, $data_extra_pet_n_res) {
        
        $this->db->trans_start();
        $this->db->INSERT('tbl_efiling_civil_extra_party', $data); 
        if ($this->db->insert_id()) {
            $this->db->WHERE('ref_m_efiling_nums_registration_id', $registration_id);
            $this->db->UPDATE('tbl_efiling_caveat', $data_extra_pet_n_res);
            if ($this->db->affected_rows()) {

                $status = $this->update_breadcrumbs($registration_id, CAVEAT_BREAD_EXTRA_PARTY);
                if ($status) {
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

    function update_extra_party($id, $data, $registration_id) {

        $this->db->WHERE('id', $id);
        $this->db->WHERE('ref_m_efiling_nums_registration_id', $registration_id);
        $this->db->UPDATE('tbl_efiling_civil_extra_party', $data);

        if ($this->db->affected_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function update_cis_master_values($registration_id, $data) {

        $this->db->WHERE('registration_id', $registration_id);
        $result = $this->db->UPDATE('tbl_cis_masters_values', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
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

    function get_extra_parties_list($registration_id) {
        $output = false;
        if(isset($registration_id) && !empty($registration_id)){
            /*$this->db->SELECT('*');
            $this->db->FROM('tbl_efiling_civil_extra_party');
            $this->db->WHERE('ref_m_efiling_nums_registration_id', $registration_id);
            $this->db->WHERE('parentid', NULL);
            $this->db->WHERE('display', 'Y');
            $this->db->ORDER_BY('type');
            $this->db->ORDER_BY('cast(party_id as float)');
            $query = $this->db->get();
            $output = $query->result();*/


            $this->db->SELECT("en.*,ec.*,
        idep.deptname as extra_party_org_dept_name,piaut.authdesc as extra_party_org_post_name,pivs.deptname as extra_party_org_state_name,
        (case when ec.orgid = 'I' then 'Individual'   
        else case when ec.orgid = 'D1' then 'State Department'
        else case when ec.orgid = 'D2' then 'Central Department'
        else case when ec.orgid = 'D3' then 'Other Organisation'
        end end end end )as extra_party_is,
        (case when ec.type = '1' then 'Caveator'   
        else case when ec.type = '2' then 'Caveatee'
        end end )as extra_party_type
        ");
            $this->db->FROM('efil.tbl_efiling_nums en');
            $this->db->JOIN('public.tbl_efiling_civil_extra_party ec', 'en.registration_id = ec.ref_m_efiling_nums_registration_id');
            $this->db->JOIN('icmis.deptt idep', "ec.extra_party_org_dept = idep.deptcode and idep.display='Y'","left");
            $this->db->JOIN('icmis.authority piaut', "ec.extra_party_org_post = piaut.authcode and piaut.display='Y'","left");
            $this->db->JOIN('icmis.view_state_in_name pivs', "ec.extra_party_org_state = pivs.deptcode","left");
            $this->db->WHERE('en.registration_id', $registration_id);
            $this->db->WHERE('en.is_active', TRUE);
            $this->db->WHERE('ec.display', 'Y');
            $this->db->WHERE('ec.parentid', NULL);
            $this->db->ORDER_BY("ec.type", "asc");
            $this->db->ORDER_BY("cast(party_id as float)", "asc");
            $query = $this->db->get();
            //echo $this->db->last_query();exit;
            if ($query->num_rows() >= 1) {
                $output = $query->result();
                return $output;
            } else {
                $output= false;
            }

        }
        return $output;
    }

    function get_extra_party_details($party_id) {
        
        /*$this->db->SELECT('*');
        $this->db->FROM('tbl_efiling_civil_extra_party');
        $this->db->WHERE('id', $party_id);
        $this->db->WHERE('ref_m_efiling_nums_registration_id', $_SESSION['efiling_details']['registration_id']);
        $query = $this->db->get();
        return $query->result_array();*/

        $this->db->SELECT("en.*,ec.*,
        idep.deptname as extra_party_org_dept_name,piaut.authdesc as extra_party_org_post_name,pivs.deptname as extra_party_org_state_name,
        (case when ec.orgid = 'I' then 'Individual'   
        else case when ec.orgid = 'D1' then 'State Department'
        else case when ec.orgid = 'D2' then 'Central Department'
        else case when ec.orgid = 'D3' then 'Other Organisation'
        end end end end )as extra_party_is,
        (case when ec.type = '1' then 'Caveator'   
        else case when ec.type = '2' then 'Caveatee'
        end end )as extra_party_type
        ");
        $this->db->FROM('efil.tbl_efiling_nums en');
        $this->db->JOIN('public.tbl_efiling_civil_extra_party ec', 'en.registration_id = ec.ref_m_efiling_nums_registration_id');
        $this->db->JOIN('icmis.deptt idep', "ec.extra_party_org_dept = idep.deptcode and idep.display='Y'","left");
        $this->db->JOIN('icmis.authority piaut', "ec.extra_party_org_post = piaut.authcode and piaut.display='Y'","left");
        $this->db->JOIN('icmis.view_state_in_name pivs', "ec.extra_party_org_state = pivs.deptcode","left");
        $this->db->WHERE('ec.id', $party_id);
        $this->db->WHERE('en.registration_id', $_SESSION['efiling_details']['registration_id']);
        $this->db->WHERE('en.is_active', TRUE);
        $this->db->WHERE('ec.display', 'Y');
        $this->db->WHERE('ec.parentid', NULL);
        $this->db->ORDER_BY("ec.type", "asc");
        $this->db->ORDER_BY("ec.party_id", "asc");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() >= 1) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

    function get_max_party_id($reg_id, $type, $lrs = NULL) {

        $this->db->SELECT('max(party_id) AS party_id');
        $this->db->WHERE('type', $type);
        if ($lrs == 0 || $lrs) {
            $this->db->WHERE('parentid', $lrs);
        } else {
            $this->db->WHERE('parentid', NULL);
        }
        $this->db->WHERE('display', 'Y');
        $this->db->WHERE('ref_m_efiling_nums_registration_id', $reg_id);
        $this->db->FROM('tbl_efiling_civil_extra_party');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    function get_max_party_no($reg_id,$type) {

        $this->db->SELECT('max(party_no) AS party_no');
        $this->db->WHERE('type', $type);
        $this->db->WHERE('ref_m_efiling_nums_registration_id', $reg_id);
        $this->db->WHERE('display', 'Y');
        $this->db->FROM('tbl_efiling_civil_extra_party');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
    }

    function get_extra_party_count($reg_id, $type) {

        $this->db->SELECT('count(CASE WHEN parentid = 0 THEN 1 END)-1 AS main_party_lrs,
                           count(CASE WHEN parentid != 0 or parentid IS NULL THEN 1 END)
                           as extry_party_lrs');
        $this->db->WHERE('display', 'Y');
        $this->db->WHERE('legal_heir', 'N');
        $this->db->WHERE('type', $type);
        $this->db->WHERE('ref_m_efiling_nums_registration_id', $reg_id);
        $this->db->FROM('tbl_efiling_civil_extra_party');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
    }

    function fetch_e_party_details($id) {
        
        $this->db->SELECT('*');
        $this->db->FROM('tbl_efiling_civil_extra_party');
        $this->db->WHERE('id', $id);
        $this->db->WHERE('ref_m_efiling_nums_registration_id', $_SESSION['efiling_details']['registration_id']);
        $query = $this->db->get();
        return $query->result_array();
    }
 
    function get_pet_n_res_count_civil($registration_id) {

        $this->db->SELECT('pet_extracount,res_extracount');
        $this->db->FROM('tbl_efiling_caveat');
        $this->db->WHERE('ref_m_efiling_nums_registration_id', $registration_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $count = $query->result_array();
            return $count;
        } else {
            return 0;
        }
    }
    
    function delete_extra_party($id, $type, $extra_party_type, $extra_party_party_no) {
        
        $update_lrs_status = array('display' => 'N');
        $this->db->WHERE('id', $id);
        $this->db->WHERE('ref_m_efiling_nums_registration_id', $_SESSION['efiling_details']['registration_id']);
        $this->db->UPDATE('tbl_efiling_civil_extra_party', $update_lrs_status);
        if ($this->db->affected_rows() > 0) {
            $extra_party_count = $this->get_pet_n_res_count_civil($_SESSION['efiling_details']['registration_id']);
            if ($type == '1') {
                $data_extra_pet_n_res = array('pet_extracount' => $extra_party_count[0]['pet_extracount'] - 1);
            } elseif ($type == '2') {
                $data_extra_pet_n_res = array('res_extracount' => $extra_party_count[0]['res_extracount'] - 1);
            }

            $this->db->WHERE('ref_m_efiling_nums_registration_id', $_SESSION['efiling_details']['registration_id']);
          //  $this->db->UPDATE('tbl_efiling_civil', $data_extra_pet_n_res);
              $this->db->UPDATE('tbl_efiling_caveat', $data_extra_pet_n_res);

            if ($this->db->affected_rows() > 0) {
                if ($extra_party_type == '1' && !empty($extra_party_party_no)) {
                    $this->db->WHERE('parentid', $extra_party_party_no);
                    $this->db->WHERE('ref_m_efiling_nums_registration_id', $_SESSION['efiling_details']['registration_id']);
                    $this->db->UPDATE('tbl_efiling_civil_extra_party', $update_lrs_status);
                    if ($this->db->affected_rows() >= 0) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                } else {
                    return TRUE;
                }
            }

            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function assign_party_no($reg_id) {

        $this->db->SELECT('max(party_no) AS party_no');
        $this->db->WHERE('ref_m_efiling_nums_registration_id', $reg_id);
        $this->db->WHERE('display', 'Y');
        $this->db->FROM('tbl_efiling_civil_extra_party');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
    }

}

?>
