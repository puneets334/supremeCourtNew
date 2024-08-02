<?php

namespace App\Models\Caveat;
use CodeIgniter\Model;

class Caveat_common_model extends Model {

    function __construct() {
        parent::__construct();
    }

    function get_efiling_civil_details($registration_id) {
        $this->db->SELECT("tbl_efiling_nums.*,tbl_efiling_caveat.*,
                (CASE WHEN tbl_efiling_nums.efiling_for_type_id =" . E_FILING_FOR_ESTABLISHMENT . " 
                    THEN (SELECT concat(estname,', ',dist_name,', ',state)  
                    FROM public.m_tbl_establishments est
                LEFT JOIN efil.m_tbl_state st on est.state_code = st.state_id
                LEFT JOIN efil.m_tbl_districts dist on est.ref_m_tbl_districts_id = dist.id
                WHERE est.id = tbl_efiling_nums.efiling_for_id ) 
                ELSE (SELECT concat(hc_name,' High Court') FROM m_tbl_high_courts hc
                WHERE hc.id = tbl_efiling_nums.efiling_for_id) END ) 
                as efiling_for_name");
        $this->db->FROM('efil.tbl_efiling_nums');
        $this->db->JOIN('public.tbl_efiling_caveat', 'tbl_efiling_nums.registration_id = tbl_efiling_caveat.ref_m_efiling_nums_registration_id');
        $this->db->WHERE('efil.tbl_efiling_nums.registration_id', $registration_id);
        $this->db->WHERE('efil.tbl_efiling_nums.is_active', TRUE);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

    function get_efiling_civil_master_value($registration_id) {

        $this->db->SELECT('*');
        $this->db->FROM('tbl_cis_masters_values');
        $this->db->WHERE('registration_id', $registration_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    // public function count_efilied_nums_on_draft() {

    //     $created_by = $this->session->userdata['login']['id'];
    //     $this->db->SELECT('COUNT (CASE WHEN stage_id IN (' . Draft_Stage . ') THEN 0 END) as total_drafts');
    //     $this->db->FROM('efil.tbl_efiling_nums as en');
    //     $this->db->JOIN('tbl_efiling_case_status as cs', 'en.registration_id = cs.registration_id', 'INNER');
    //     $this->db->WHERE('cs.is_active', 'TRUE');
    //     $this->db->WHERE('en.is_active', 'TRUE');
    //     if ($_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
    //         $this->db->WHERE('en.sub_created_by', $created_by);
    //     } else {
    //         $this->db->WHERE('en.created_by', $created_by);
    //     }

    //     $query = $this->db->get();
    //     if ($query->num_rows() >= 1) {
    //         return $query->result();
    //     } else {
    //         return false;
    //     }
    // }

    public function count_efilied_nums_on_draft() {
        $created_by = session()->get('login')['id'];
        $db = \Config\Database::connect();
    
        $builder = $db->table('efil.tbl_efiling_nums as en');
        $builder->select('COUNT(CASE WHEN cs.stage_id IN (' . Draft_Stage . ') THEN 1 END) as total_drafts');
        $builder->join('tbl_efiling_case_status as cs', 'en.registration_id = cs.registration_id', 'INNER');
        $builder->where('cs.is_active', 'TRUE');
        $builder->where('en.is_active', 'TRUE');
    
        if (session()->get('login')['ref_m_usertype_id'] == USER_CLERK) {
            $builder->where('en.sub_created_by', $created_by);
        } else {
            $builder->where('en.created_by', $created_by);
        }
    
        $query = $builder->get();
    
        if ($query->getNumRows() >= 1) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    
    function case_type_id_in_array($national_code, $civil_or_criminal, $court_type, $state_code) {

        $this->db->SELECT('array_agg("cis_case_type_id")');
        $this->db->FROM('m_tbl_cis_case_type');
        $this->db->WHERE('national_code', $national_code);
        $this->db->WHERE('efiling_for_type_id', $court_type);
        $this->db->WHERE('state_code', $state_code);
        $this->db->WHERE('is_deleted', FALSE);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }

}

?>
