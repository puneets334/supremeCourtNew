<?php

namespace App\Models\AdminDashboard;
use CodeIgniter\Model;

class AdminDashboard_model extends Model {

	protected $session;
    function __construct() {
        // Call the Model constructor
        parent::__construct();
		$this->session = \Config\Services::session();
    }

    // Function used to count total efiled nums stage wise on user dashboard
    public function get_efilied_nums_stage_wise_count($stage_ids=array()) {
		 
        // START : Function used to count total efiled nums stage wise on admin dashboard 
        $created_by = $this->session->get('login')['id'];
		 $builder =  $this->db->table('efil.tbl_efiling_nums as en');
		 
			$builder->SELECT('COUNT (CASE WHEN stage_id = ' . New_Filing_Stage . ' THEN 0 END) as total_new_efiling,
                        COUNT (CASE WHEN stage_id = ' . DEFICIT_COURT_FEE . ' THEN 0 END) as deficit_crt_fee,
                        COUNT (CASE WHEN stage_id = ' . Initial_Defected_Stage . ' THEN 0 END) as total_not_accepted,
                        COUNT (CASE WHEN stage_id = ' . Transfer_to_CIS_Stage . ' THEN 0 END) as total_available_for_cis,
                        COUNT (CASE WHEN stage_id = ' . Get_From_CIS_Stage . ' THEN 0 END) as total_get_from_cis,
                        COUNT (CASE WHEN stage_id = ' . Initial_Defects_Cured_Stage . ' OR stage_id = ' . DEFICIT_COURT_FEE_PAID . ' THEN 0 END) as total_refiled_cases,
                        COUNT (CASE WHEN stage_id = ' . Transfer_to_IB_Stage . ' THEN 0 END) as total_transfer_to_efiling_sec,
                        COUNT (CASE WHEN stage_id = ' . I_B_Approval_Pending_Admin_Stage . ' THEN 0 END) as total_pending_scrutiny,
                        COUNT (CASE WHEN stage_id = ' . I_B_Defected_Stage . ' THEN 0 END) as total_waiting_defect_cured,
                        COUNT (CASE WHEN stage_id = ' . I_B_Rejected_Stage . ' OR stage_id = ' . E_REJECTED_STAGE . ' THEN 0 END) as total_rejected,
                        COUNT (CASE WHEN stage_id = ' . I_B_Defects_Cured_Stage . ' THEN 0 END) as total_defect_cured,
                        COUNT (CASE WHEN stage_id = ' . LODGING_STAGE . '  OR stage_id =' . DELETE_AND_LODGING_STAGE . ' OR stage_id =' . MARK_AS_ERROR . ' THEN 0 END) as total_lodged_cases,
                        COUNT (CASE WHEN (stage_id = ' . E_Filed_Stage . ' AND en.ref_m_efiled_type_id = ' . E_FILING_TYPE_NEW_CASE . ') OR ( stage_id = ' . CDE_ACCEPTED_STAGE . ' AND ref_m_efiled_type_id = ' . E_FILING_TYPE_CDE . ' ) THEN 0 END) as total_efiled_cases,
                        COUNT (CASE WHEN (stage_id = ' . Document_E_Filed . ' AND en.ref_m_efiled_type_id =' . E_FILING_TYPE_MISC_DOCS . ') THEN 0 END) as total_efiled_docs,
                        COUNT (CASE WHEN stage_id = ' . DEFICIT_COURT_FEE_E_FILED . ' AND en.ref_m_efiled_type_id =' . E_FILING_TYPE_DEFICIT_COURT_FEE . ' THEN 0 END) as total_efiled_deficit,
                        COUNT (CASE WHEN stage_id = ' . HOLD . ' THEN 0 END) as total_hold_cases,
                        COUNT (CASE WHEN stage_id = ' . DISPOSED . ' THEN 0 END) as total_hold_disposed_cases,
                        COUNT (CASE WHEN stage_id = ' . DEFICIT_COURT_FEE . ' THEN 0 END) as deficit_crt_fee,
                        COUNT (CASE WHEN stage_id = ' . IA_E_Filed . ' AND en.ref_m_efiled_type_id = ' . E_FILING_TYPE_IA . ' THEN 0 END) as total_efiled_ia'
                       );
        //$this->db->FROM('efil.tbl_efiling_nums as en');
			 $builder->JOIN('efil.tbl_efiling_num_status as cs', 'en.registration_id = cs.registration_id', 'INNER');
			 $builder->WHERE('cs.is_active', 'TRUE');
			 $builder->WHERE('en.is_active', 'TRUE');
			 
        if($this->session->get('login')['AllUserCount']!=1) {
            //22/01/2021
            // $this->db->WHERE('en.efiling_for_type_id', $this->session->get('login')['admin_for_type_id'] );

            //for caveat 22/01/2021
            $where = '(en.efiling_for_type_id=' . $this->session->get('login')['admin_for_type_id'] . ' or en.efiling_for_type_id = ' . E_FILING_TYPE_CAVEAT . ')';
           $builder->WHERE($where);

            $builder->WHERE('en.efiling_for_id', $this->session->get('login')['admin_for_id']);
            if (!empty($stage_ids)){
                if (!in_array(LODGING_STAGE, $stage_ids) && !in_array(DELETE_AND_LODGING_STAGE, $stage_ids)) {
                    $builder->WHERE('en.allocated_to', $this->session->get('login')['id']);
                }
            }else{
                if (!in_array(LODGING_STAGE, $stage_ids) && !in_array(DELETE_AND_LODGING_STAGE, $stage_ids) && $this->session->get('login')['userid'] != SC_ADMIN) {
                    $builder->WHERE('en.allocated_to', $this->session->get('login')['id']);
                }
            }
        }
        $query = $builder->get(); //echo $this->db->last_query();die;
		 
        if ($query->getNumRows() >= 1) {
            /*$result= $query->result();
            echo '<pre>';print_r($_SESSION);//exit();
            echo '<pre>';print_r($result);exit();*/
            return $query->getRow();
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
             if ($this->session->get('login')['ref_m_usertype_id'] == USER_DEPARTMENT || $this->session->get('login')['ref_m_usertype_id'] == USER_CLERK) {
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
        if ($this->session->get('login')['ref_m_usertype_id'] == USER_DEPARTMENT || $this->session->get('login')['ref_m_usertype_id'] == USER_CLERK) {
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
