<?php

namespace App\Models\Dashboard;
use CodeIgniter\Model;
class Dashboard_model extends Model {


    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    // Function used to count total efiled nums stage wise on user dashboard
    public function get_efilied_nums_stage_wise_count() {

        $created_by = $this->session->userdata['login']['id'];
        $this->db->SELECT('COUNT (CASE WHEN stage_id = ' . Draft_Stage . ' THEN 0 END) as total_drafts,
                        COUNT (CASE WHEN stage_id = ' . Initial_Approaval_Pending_Stage . ' OR stage_id =' . Initial_Defects_Cured_Stage . ' OR stage_id = ' . DEFICIT_COURT_FEE_PAID . '19 THEN 0 END) as total_pending_acceptance,
                        COUNT (CASE WHEN stage_id = ' . DEFICIT_COURT_FEE . ' THEN 0 END) as deficit_crt_fee,
                        COUNT (CASE WHEN stage_id = ' . Initial_Defected_Stage . ' THEN 0 END) as total_not_accepted,
                        COUNT (CASE WHEN stage_id = ' . I_B_Approval_Pending_Stage . ' OR stage_id = ' . Get_From_CIS_Stage . ' OR stage_id = ' . Transfer_to_IB_Stage . ' OR stage_id = ' . I_B_Approval_Pending_Admin_Stage . ' OR stage_id = ' . I_B_Defects_Cured_Stage . ' THEN 0 END) as total_pending_scrutiny,
                        COUNT (CASE WHEN stage_id = ' . I_B_Defected_Stage . ' THEN 0 END) as total_filing_section_defective,
                        COUNT (CASE WHEN stage_id = ' . I_B_Rejected_Stage . ' OR stage_id = ' . E_REJECTED_STAGE . ' OR stage_id = ' . CDE_REJECTED_STAGE . ' THEN 0 END) as total_rejected_cases,
                        COUNT (CASE WHEN stage_id = ' . LODGING_STAGE . ' OR stage_id = ' . DELETE_AND_LODGING_STAGE . ' OR stage_id = ' . TRASH_STAGE . '  THEN 0 END) as total_lodged_cases,
                        COUNT (CASE WHEN stage_id = ' . E_Filed_Stage . ' OR stage_id = ' . CDE_ACCEPTED_STAGE . ' THEN 0 END) as total_efiled_cases,
                        COUNT (CASE WHEN stage_id = ' . Document_E_Filed . ' THEN 0 END) as total_efiled_docs,
                        COUNT (CASE WHEN stage_id = ' . DEFICIT_COURT_FEE_E_FILED . ' THEN 0 END) as total_efiled_deficit,
                        COUNT (CASE WHEN stage_id = ' . MENTIONING_E_FILED . ' THEN 0 END) as total_mentioning,
                        COUNT (CASE WHEN stage_id = ' . IA_E_Filed . ' THEN 0 END) as total_efiled_ia');
        $this->db->FROM('efil.tbl_efiling_nums as en');
        $this->db->JOIN('efil.tbl_efiling_num_status as cs', 'en.registration_id = cs.registration_id', 'INNER');
        $this->db->WHERE('cs.is_active', 'TRUE');
        $this->db->WHERE('en.is_active', 'TRUE');
        $this->db->WHERE('en.ref_m_efiled_type_id!=', 9);
        if ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
            $this->db->WHERE('en.sub_created_by', $created_by);
        } else {
            $this->db->WHERE('en.created_by', $created_by);
        }

        $query = $this->db->get(); 
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }
    // Function used to count total efiled nums stage wise on user dashboard
    
    
    
    // Function used to count total submitted efiled num on user dashboard

    public function get_efilied_nums_submitted_count($stages) {

        $created_by = $this->session->userdata['login']['id'];

        $this->db->SELECT('COUNT(en.registration_id) as count');
        $this->db->FROM('tbl_efiling_nums as en');
        $this->db->JOIN('tbl_efiling_case_status as cs', 'en.registration_id=cs.registration_id');
        $this->db->WHERE('cs.is_active', 'TRUE');
        $this->db->WHERE_NOT_IN('cs.stage_id', $stages);
        $this->db->WHERE('en.created_by', $created_by);

        $query = $this->db->get();

        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    // Function used to count total submitted efiled num on user dashboard
    // Function used to count total efiled type wise on user dashboard

    public function getSearchResults($created_by, $search) {
         //  echo $created_by."__".$search;die;
        $search = trim($search);
        $condition = '';
        if (isset($search) && !empty($search)) {
             if ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
                 $condition = "
                         (cs.is_active = TRUE AND en.sub_created_by ='$created_by' AND en.efiling_no ILIKE '%" . $search . "%')
                      OR 
                         (cs.is_active = TRUE AND en.sub_created_by ='$created_by' AND cast(en.efiling_year as char) ILIKE'" . $search . "')
                      OR
                         (cs.is_active = TRUE AND en.sub_created_by ='$created_by' AND ec.pet_name ILIKE '%" . $search . "%')
                      OR
                         (cs.is_active = TRUE AND en.sub_created_by ='$created_by' AND ec.res_name ILIKE '%" . $search . "%')
                      OR
                         (cs.is_active = TRUE AND en.sub_created_by ='$created_by' AND ms.cause_title ILIKE '%" . $search . "%')";
             }else{
            $condition = "
                         (cs.is_active = TRUE AND en.created_by ='$created_by' AND en.efiling_no ILIKE '%" . $search . "%')
                      OR 
                         (cs.is_active = TRUE AND en.created_by ='$created_by' AND cast(en.efiling_year as char) ILIKE'" . $search . "')
                      OR
                         (cs.is_active = TRUE AND en.created_by ='$created_by' AND ec.pet_name ILIKE '%" . $search . "%')
                      OR
                         (cs.is_active = TRUE AND en.created_by ='$created_by' AND ec.res_name ILIKE '%" . $search . "%')
                      OR
                         (cs.is_active = TRUE AND en.created_by ='$created_by' AND ms.cause_title ILIKE '%" . $search . "%')";
             }
        }
        $this->db->SELECT(array('en.efiling_for_type_id', 'en.efiling_for_id', 'en.registration_id', 'en.efiling_no', 'en.efiling_year', 'en.ref_m_efiled_type_id',
            'en.created_by',
            'et.efiling_type', 'cs.stage_id', 'cs.activated_on', 'ds.user_stage_name',
            'ec.cino', 'ec.pet_name', 'ec.res_name', 'ec.fil_case_type_name', 'ec.fil_no', 'ec.fil_year',
            'ec.reg_case_type_name', 'ec.reg_no', 'ec.reg_year',
            'ia.ia_fil_case_type_name', 'ia.ia_filno', 'ia.ia_filyear', 'ia.ia_reg_case_type_name', 'ia.ia_regno', 'ia.ia_regyear', 'ia.cino ia_cnr_num',
            'ms.case_type_name', 'ms.cnr_num', 'ms.fil_no misc_fil_no', 'ms.fil_year misc_fil_year', 'ms.reg_no misc_reg_no', 'ms.reg_year misc_reg_year',
            'ms.cause_title', 'ms.efiling_case_reg_id'));

        $this->db->FROM('tbl_efiling_nums as en');
        $this->db->JOIN('tbl_efiling_case_status as cs', 'en.registration_id=cs.registration_id', 'LEFT');
        $this->db->JOIN('m_tbl_efiling_type as et', 'en.ref_m_efiled_type_id=et.id', 'LEFT');
        $this->db->JOIN('tbl_efiling_civil as ec', 'en.registration_id=ec.ref_m_efiling_nums_registration_id', 'LEFT');
        $this->db->JOIN('tbl_misc_doc_filing as ms', 'en.registration_id=ms.ref_m_efiling_nums_registration_id', 'LEFT');
        $this->db->JOIN('eia_filing as ia', 'ia.registration_id = en.registration_id ', 'left');
        $this->db->JOIN('m_tbl_dashboard_stages as ds', 'cs.stage_id = ds.stage_id', 'LEFT');
        $this->db->JOIN(dynamic_users_table, 'users.id=en.created_by', 'left');
        $this->db->WHERE('en.is_active', 'TRUE');
        if ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
            $this->db->WHERE('en.sub_created_by', $created_by);
        } else {
            $this->db->WHERE('en.created_by', $created_by);
        }
        $this->db->WHERE($condition);
        $this->db->ORDER_BY('cs.activated_on', 'ASC');

        $query = $this->db->get();
       
        return $query->result();
    }

}
