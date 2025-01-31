<?php

namespace App\Controllers\AdminDashboard;

use App\Controllers\BaseController;
use App\Models\AdminDashboard\StageListModel;
use \Hermawan\DataTables\DataTable;

class StageList extends BaseController {

	protected $session;
	protected $StageList_model;
	
    public function __construct() {
        parent::__construct();
        if(empty(getSessionData('login'))){
            return response()->redirect(base_url('/')); 
        } else{
            is_user_status();
        }

		$this->session = \Config\Services::session();
		
        //$this->load->model('dashboard/Dashboard_model');
       // $this->load->model('adminDashboard/StageList_model');
		$this->StageList_model = new StageListModel();
        

        // unset($_SESSION['efiling_details']);
        // unset($_SESSION['estab_details']);
        // unset($_SESSION['case_table_ids']);
        // unset($_SESSION['search_case_data']);
        // unset($_SESSION['form_data']);
        // unset($_SESSION['efiling_user_detail']);
        // unset($_SESSION['pdf_signed_details']);
        // unset($_SESSION['matter_type']);
        // unset($_SESSION['crt_fee_and_esign_add']);
        // unset($_SESSION['mobile_no_for_updation']);
        // unset($_SESSION['email_id_for_updation']);
        // unset($_SESSION['search_key']);
    }
    
    /* public function _remap($param = NULL) {
        if ($param == 'index') {
            $this->index(NULL);
        } else {
            $this->index($param);
        }
    } */
    // protected function getdata()
    // {
    //     // Initialize web data array
    //     $data = [];
    
    //     // Retrieve parameters from the request, setting defaults if not present
    //     $data['page'] = $this->request->getVar('page') ?? 1; // Default to page 1
    //     $data['limit'] = $this->request->getVar('limit') ?? 10; // Default limit to 10 
    //     $data['sort_type'] = $this->request->getVar('sort_type') ?? 'DESC'; // Default sort type to DESC 
    // }
    
    public function index($stages) {
        $users_array = array(USER_ADMIN,USER_ADMIN_READ_ONLY,USER_EFILING_ADMIN);
        if (getSessionData('login') != '' && !in_array(getSessionData('login')['ref_m_usertype_id'], $users_array)) {
            return redirect()->to(base_url('login'));
            exit(0);
        }		 
        $stages= url_decryption($stages);
        $mark_as_error = NULL;
        if(isset($stages) && !empty($stages)){
            if(preg_match("/@/i",$stages) == 1){
                $stagesArr = explode('@',$stages);
                $stages = !empty($stagesArr[0]) ? $stagesArr[0] : NULL;
                $mark_as_error = !empty($stagesArr[1]) ? $stagesArr[1] : NULL;
            }
        }
        if (!preg_match("/^[0-9]*$/", $stages)) {
            return redirect()->to(base_url('dashboard'));
            exit(0);
        }
        if ($stages != '') {    
            // Pagination setup
            $data['limit'] = $this->request->getVar('limit') ?? 10;  
            $data['page'] = $this->request->getVar('page') ?? 1;  
             $offset = ($data['page'] - 1) * $data['limit']; 
            // pr($data);       
            $data['stages'] = $stages;           
            $data['mark_as_error'] = $mark_as_error;
            if ($stages == New_Filing_Stage) {              
                $data['tabs_heading'] = "New Filing";
                $data['tab_head'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Submitted On', 'Action');
                $data['data_key'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Submitted On', 'Action');
                $diaryIdsArr= $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(New_Filing_Stage), $_SESSION['login']['admin_for_type_id'], $_SESSION['login']['admin_for_id'], $data['limit'],$offset);
                $diaryIdsArrFinal=array();
                if (isset($diaryIdsArr) && !empty($diaryIdsArr)){
                    $diaryIds="";
                    $diaryIds = implode(",",array_diff(array_column($diaryIdsArr, 'diaryid'),['']));
                    //echo (env('ICMIS_SERVICE_URL')."/ConsumedData/future_tentaive_date_cases?diaryIds[]=$diaryIds");exit();
                    $tentaive_date_data= json_decode(file_get_contents(ICMIS_SERVICE_URL."/ConsumedData/future_tentaive_date_cases?diaryIds[]=$diaryIds"));
                    if (isset($tentaive_date_data->data) && !empty($tentaive_date_data->data)) {
                        foreach ($diaryIdsArr as $row) {
                            if (!empty($row->icmis_diary_no) && $row->icmis_diary_year) {
                                $diary_no_db = $row->icmis_diary_no.$row->icmis_diary_year;
                                $is_tentaive_date_data=$this->get_tentaive_date_data($tentaive_date_data->data,$diary_no_db);
                                if (!empty($is_tentaive_date_data)){
                                    $tentaive_date=array('tentaive_date' => $is_tentaive_date_data);
                                }else{
                                    $tentaive_date=array('tentaive_date' => '');
                                }

                            }
                            else{
                                $tentaive_date=array('tentaive_date' => '');
                            }
                            // Cast the array to stdClass Object
                            $tentaive_date = (object) $tentaive_date;
                            // Convert stdClass objects to arrays
                            $array1 = (array) $row;
                            $array2 = (array) $tentaive_date;
                            // Merge arrays
                            $merged_array = array_merge($array1, $array2);
                            // Convert merged array back to stdClass object
                            $diaryIdsArrFinal[] = (object) $merged_array;
                        }
                    }else{
                        $diaryIdsArrFinal= $diaryIdsArr;
                    }
                }
                // $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(New_Filing_Stage), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id'], $data['limit'],$offset);
                $data['result'] = $diaryIdsArrFinal;
                // $data['count'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(New_Filing_Stage), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $totalRecords = isset($data['count'])  && !empty($data['count']) ? count($data['count']) : 0;
                // // pr($totalRecords);
                // $data['pages'] = ceil($totalRecords / $data['limit']);
            }
            if ($stages == DEFICIT_COURT_FEE) {                
                $data['tabs_heading'] = " Pay Deficit Fee";
                $data['tab_head'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Updated On');
                $data['data_key'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Updated On');
                $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(DEFICIT_COURT_FEE), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id'], $data['limit'],$offset);
                // $data['count'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(DEFICIT_COURT_FEE), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $totalRecords = isset($data['count']) && !empty($data['count']) ? count($data['count']) : 0;
                // // pr($totalRecords);
                // $data['pages'] = ceil($totalRecords / $data['limit']);
            }
            if ($stages == Initial_Defected_Stage) {              
                $data['tabs_heading'] = "Initially Defective";
                $data['tab_head'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Defect Raised On');
                $data['data_key']  = array('#', 'eFiling No.', 'Type', 'Case Details', 'Defect Raised On');
                // $data['count'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(Initial_Defected_Stage), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $totalRecords = isset($data['count'])  && !empty($data['count']) ? count($data['count']) : 0;
                // // pr($totalRecords);
                // $data['pages'] = ceil($totalRecords / $data['limit']);
                $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(Initial_Defected_Stage), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id'], $data['limit'],$offset);
            }
            if ($stages == Transfer_to_CIS_Stage) {               
                $data['tabs_heading'] = "Get ICMIS Status";
                $data['tab_head'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Updated On', 'Action');
                $data['data_key'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Updated On', 'Action');
                $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(Transfer_to_CIS_Stage), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id'], $data['limit'],$offset);
                // $data['count'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(Transfer_to_CIS_Stage), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $totalRecords = isset($data['count'])  && !empty($data['count']) ? count($data['count']) : 0;
                // // pr($totalRecords);
                // $data['pages'] = ceil($totalRecords / $data['limit']);
            }
            if ($stages == Get_From_CIS_Stage) {               
                $data['tabs_heading'] = "Get From ICMIS";
                $data['tab_head'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Updated On', 'Action');
                $data['data_key'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Updated On', 'Action');
                $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(Get_From_CIS_Stage), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id'], $data['limit'],$offset);
                // $data['count'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(Get_From_CIS_Stage), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $totalRecords = isset($data['count'])  && !empty($data['count']) ? count($data['count']) : 0;
                // // pr($totalRecords);
                // $data['pages'] = ceil($totalRecords / $data['limit']);
            }
            if ($stages == Initial_Defects_Cured_Stage) {                
                $data['tabs_heading'] = "Complied Objections";
                $data['tab_head'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Complied On', 'Action');
                $data['data_key'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Complied On', 'Action');
                $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(Initial_Defects_Cured_Stage, DEFICIT_COURT_FEE_PAID), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id'], $data['limit'],$offset);
                // $data['count'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(Initial_Defects_Cured_Stage, DEFICIT_COURT_FEE_PAID), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $totalRecords = isset($data['count'])  && !empty($data['count']) ? count($data['count']) : 0;
                // // pr($totalRecords);
                // $data['pages'] = ceil($totalRecords / $data['limit']);
            }
            if ($stages == Transfer_to_IB_Stage) {                
                $data['tabs_heading'] = "Transfer to ICMIS";
                $data['tab_head'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Updated On', 'Action');
                $data['data_key'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Updated On', 'Action');
                $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(Transfer_to_IB_Stage), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id'], $data['limit'],$offset);
                // $data['count'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(Transfer_to_IB_Stage), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $totalRecords = isset($data['count'])  && !empty($data['count']) ? count($data['count']) : 0;
                // // pr($totalRecords);
                // $data['pages'] = ceil($totalRecords / $data['limit']);
            }
            if ($stages == I_B_Approval_Pending_Admin_Stage) {
                $data['tabs_heading'] = "Pending Scrutiny";                
                $data['tab_head'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Updated On', 'Action');   
                $data['data_key'] =  array('#', 'eFiling No.', 'Type', 'Case Details', 'Updated On', 'Action');
                $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(I_B_Approval_Pending_Admin_Stage), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id'], $data['limit'],$offset);                
                // $data['count'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(I_B_Approval_Pending_Admin_Stage), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $totalRecords = isset($data['count'])  && !empty($data['count']) ? count($data['count']) : 0;
                // // pr($totalRecords);
                // $data['pages'] = ceil($totalRecords / $data['limit']);
            }
            if ($stages == I_B_Defected_Stage) {
                $data['tabs_heading'] = "Waiting Defects To be Cured";
                $data['tab_head'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Defect Raised On');
                $data['data_key'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Defect Raised On');
                $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(I_B_Defected_Stage), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id'], $data['limit'],$offset);
                // $data['count'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(I_B_Defected_Stage), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $totalRecords = isset($data['count'])  && !empty($data['count']) ? count($data['count']) : 0;
                // // pr($totalRecords);
                // $data['pages'] = ceil($totalRecords / $data['limit']);
            }
            if ($stages == I_B_Rejected_Stage) {
                $data['tabs_heading'] = "Rejected E-Filing No's";
                $data['tab_head'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Rejected On', 'Rejected From');
                $data['data_key'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Rejected On', 'Rejected From');
                $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(I_B_Rejected_Stage, E_REJECTED_STAGE), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id'], $data['limit'],$offset);
                // $data['count'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(I_B_Rejected_Stage, E_REJECTED_STAGE), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $totalRecords = isset($data['count'])  && !empty($data['count']) ? count($data['count']) : 0;
                // // pr($totalRecords);
                // $data['pages'] = ceil($totalRecords / $data['limit']);
            }
            if ($stages == I_B_Defects_Cured_Stage) {
                $data['tabs_heading'] = "Defects Cured";
                $data['tab_head'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Cured On', 'Check Status');
                $data['data_key'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Cured On', 'Check Status');
                $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(I_B_Defects_Cured_Stage), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id'], $data['limit'],$offset);
                // $data['count'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(I_B_Defects_Cured_Stage), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $totalRecords = isset($data['count'])  && !empty($data['count']) ? count($data['count']) : 0;
                // // pr($totalRecords);
                // $data['pages'] = ceil($totalRecords / $data['limit']);
            }
            if ($stages == E_Filed_Stage) {
                if(ENABLE_EFILING && ENABLE_CASE_DATA_ENTRY) {
                    $data['tabs_heading'] = "eFiled Cases And Accepted CDE";
                    $lbl_efiling_no = 'eFiling/CDE No.';
                } elseif (ENABLE_EFILING) {
                    $data['tabs_heading'] = "E-Filled Cases";
                    $lbl_efiling_no = 'eFiling No.';
                } elseif (ENABLE_CASE_DATA_ENTRY) {
                    $data['tabs_heading'] = "Accepted CDE";
                    $lbl_efiling_no = 'CDE No.';
                }                
                $data['tab_head'] = array('#', $lbl_efiling_no, 'Type', 'Case Details', 'Updated on');
                $data['data_key'] = array('#', $lbl_efiling_no, 'Type', 'Case Details', 'Updated on');
                $data['result'] = $this->StageList_model->get_efiled_list_admin(array(E_Filed_Stage, CDE_ACCEPTED_STAGE), array(E_FILING_TYPE_NEW_CASE, E_FILING_TYPE_CDE), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $data['count'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(Initial_Defected_Stage), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $totalRecords = isset($data['count'])  && !empty($data['count']) ? count($data['count']) : 0;
                // // pr($totalRecords);
                // $data['pages'] = ceil($totalRecords / $data['limit']);
            }
            if ($stages == Document_E_Filed) {
                $data['tabs_heading'] = "E-Filled Documents";
                $data['tab_head'] = array('#', 'eFiling No.', 'Case Details', 'Updated On');
                $data['data_key'] = array('#', 'eFiling No.', 'Case Details', 'Updated On');
                // $data['result'] = $this->StageList_model->get_efiled_list_admin(array($stages), array(E_FILING_TYPE_MISC_DOCS), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(Document_E_Filed), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id'], $data['limit'],$offset);
                // $data['count'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(Document_E_Filed), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $totalRecords = isset($data['count'])  && !empty($data['count']) ? count($data['count']) : 0;
                // // pr($totalRecords);
                // $data['pages'] = ceil($totalRecords / $data['limit']);
            }
            if ($stages == DEFICIT_COURT_FEE_E_FILED) {
                $data['tabs_heading'] = "Paid Deficit Fee";
                $data['tab_head'] = array('#', 'eFiling No.', 'Case Details', 'Updated On');
                $data['data_key'] = array('#', 'eFiling No.', 'Case Details', 'Updated On');
                // $data['result'] = $this->StageList_model->get_efiled_list_admin(array($stages), array(E_FILING_TYPE_DEFICIT_COURT_FEE), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(DEFICIT_COURT_FEE_E_FILED), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id'], $data['limit'],$offset);
                // $data['count'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(DEFICIT_COURT_FEE_E_FILED), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $totalRecords = isset($data['count'])  && !empty($data['count']) ? count($data['count']) : 0;
                // // pr($totalRecords);
                // $data['pages'] = ceil($totalRecords / $data['limit']);
            }
            /* if ($stages == DEFICIT_COURT_FEE_PAID) {
                $data['tabs_heading'] = "Paid Deficit Fee";
                $data['tab_head'] = array('#', 'eFiling No.', 'Case Details', 'Updated On');
                // $data['result'] = $this->StageList_model->get_efiled_list_admin(array($stages), array(E_FILING_TYPE_DEFICIT_COURT_FEE), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(DEFICIT_COURT_FEE_PAID), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
            }*/
            if ($stages == LODGING_STAGE || $stages == DELETE_AND_LODGING_STAGE || $mark_as_error == MARK_AS_ERROR) {
                pr('tewyr');
                $data['tabs_heading'] = "Idle/Unprocessed e-Filing";
                $data['tab_head'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'Status', 'Updated On');
                $data['data_key'] =  array('#', 'eFiling No.', 'Type', 'Case Details', 'Status', 'Updated On');
                // $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(LODGING_STAGE, DELETE_AND_LODGING_STAGE), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(LODGING_STAGE,DELETE_AND_LODGING_STAGE,MARK_AS_ERROR), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id'], $data['limit'],$offset);
                // $data['count'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(LODGING_STAGE,DELETE_AND_LODGING_STAGE,MARK_AS_ERROR), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $totalRecords = isset($data['count'])  && !empty($data['count']) ? count($data['count']) : 0;
                // // pr($totalRecords);
                // $data['pages'] = ceil($totalRecords / $data['limit']);
            }
            if ($stages == IA_E_Filed) {
                $data['tabs_heading'] = "E-Filled IA";
                $data['tab_head'] = array('#', 'eFiling No.', 'Case Details', 'Updated On');
                $data['data_key'] = array('#', 'eFiling No.', 'Case Details', 'Updated On');
                // $data['result'] = $this->StageList_model->get_efiled_list_admin(array($stages), array(E_FILING_TYPE_IA), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(IA_E_Filed), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id'], $data['limit'],$offset);
                // $data['count'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(IA_E_Filed), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $totalRecords = isset($data['count'])  && !empty($data['count']) ? count($data['count']) : 0;
                // // pr($totalRecords);
                // $data['pages'] = ceil($totalRecords / $data['limit']);
            }
            if ($stages == HOLD) {
                $data['tabs_heading'] = "Hold Cases";
                $data['tab_head'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'E-filing Type');
                $data['data_key'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'E-filing Type');
                $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(HOLD), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id'], $data['limit'],$offset);
                // $data['count'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(HOLD), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $totalRecords = isset($data['count'])  && !empty($data['count']) ? count($data['count']) : 0;
                // // pr($totalRecords);
                // $data['pages'] = ceil($totalRecords / $data['limit']);
            }
            if ($stages == DISPOSED) {
                $data['tabs_heading'] = "Disposed Cases";
                $data['tab_head'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'E-filing Type');
                $data['data_key'] = array('#', 'eFiling No.', 'Type', 'Case Details', 'E-filing Type');
                $data['result'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(DISPOSED), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id'], $data['limit'],$offset);
                // $data['count'] = $this->StageList_model->get_efilied_nums_stage_wise_list_admin(array(DISPOSED), getSessionData('login')['admin_for_type_id'], getSessionData('login')['admin_for_id']);
                // $totalRecords = isset($data['count'])  && !empty($data['count']) ? count($data['count']) : 0;
                // pr($totalRecords);
                // $data['pages'] = ceil($totalRecords / $data['limit']);
            }
            return $this->render('adminDashboard.admin_stage_list_view', $data);
            /* $this->load->view('templates/admin_header');
            $this->load->view('adminDashboard/admin_stage_list_view', $data);
            $this->load->view('templates/footer'); */
        } else {
            return redirect()->to(base_url('adminDashboard'));
            exit(0);
        }
    }

    public function get_tentaive_date_data($tentaive_date_data,$diary_no_db) {
        if (isset($tentaive_date_data) && !empty($tentaive_date_data)) {
            foreach ($tentaive_date_data as $key => $object) {
                if ($object->diary_no === $diary_no_db) {
                    return $object->next_dt;
                }
            }
        }
    }

}