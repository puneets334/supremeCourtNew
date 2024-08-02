<?php
namespace App\Controllers;

class FinalSubmit extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('common/Common_model');
        $this->load->model('jailPetition/JailPetitionModel');
        $this->load->helper('functions_helper');
        $this->load->model('newcase/Get_details_model');
    }
    public function validate()  // function added on 29.04.2020 for validation for cde
    {
        $ans =$this->Common_model->valid_cde($_SESSION['efiling_details']['registration_id']);

        $arr_data=explode('-',$ans);
        $status=$arr_data[0];
        $status= (ltrim($status,','));
            $chk_status="13";
            if(!in_array(1, explode(',', $status))) {
                $final_outcome=1;
            }
            if(!in_array(3, explode(',', $status))) {
                $final_outcome=$final_outcome.','.'3';
            }
            echo $final_outcome;
    }     // end of function


    public function index() {
        $allowed_users_array = array(JAIL_SUPERINTENDENT);

        if (!in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('admindashboard');
            exit(0);
        }

        if (empty($_SESSION['efiling_details']) || empty($_SESSION['estab_details'])) {
           redirect('jail_dashboard');
            exit(0);
        }

       $registration_id = $_SESSION['efiling_details']['registration_id'];

        $respondent_details = $this->Get_details_model->get_case_parties_details($registration_id, array('p_r_type' => 'R', 'm_a_type' => 'M', 'party_id' => NULL, 'view_lr_list' => FALSE));
        $respondent_state=$respondent_details[0]['org_state_id'];
         if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_DEFICIT_COURT_FEE && (bool) $_SESSION['estab_details']['enable_payment_gateway']) {
            $next_stage = Transfer_to_IB_Stage;
        } elseif ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
            $next_stage = Draft_Stage;
        } elseif ($_SESSION['efiling_details']['stage_id'] == Draft_Stage) {
            $next_stage = Initial_Approaval_Pending_Stage;
        } elseif ($_SESSION['efiling_details']['stage_id'] == Initial_Defected_Stage) {
            $next_stage = Initial_Defects_Cured_Stage;
        } elseif ($_SESSION['efiling_details']['stage_id'] == DEFICIT_COURT_FEE) {
            $next_stage = DEFICIT_COURT_FEE_PAID;
        } elseif ($_SESSION['efiling_details']['stage_id'] == I_B_Defected_Stage) {
            $next_stage = I_B_Defects_Cured_Stage;
        } elseif ($_SESSION['efiling_details']['stage_id'] == I_B_Rejected_Stage || $_SESSION['efiling_details']['stage_id'] == E_REJECTED_STAGE) {
            $next_stage = Initial_Defects_Cured_Stage;
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid Action.</div>');
            redirect('jail_dashboard');
        }
            $result = $this->JailPetitionModel->updateJailPetitionStatus($registration_id, $next_stage,$respondent_state);
            if ($result) {
                //echo $_SESSION['efiling_details']['efiling_no'];
                $sentSMS = "Efiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']) . " has been submitted and is pending for initial approval with efiling admin. - Supreme Court of India";
                $subject = "Submitted : Efiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']);
                $user_name = $_SESSION['login']['first_name'] . ' ' . $_SESSION['login']['last_name'];
                send_mobile_sms($_SESSION['login']['mobile_number'], $sentSMS,SCISMS_Initial_Approval);
                send_mail_msg($_SESSION['login']['emailid'], $subject, $sentSMS, $user_name);

                 $this->session->set_flashdata("hekki");
                 
                $this->session->set_flashdata('msg', '<div class="alert alert-success text-center"> E-filing number ' . efile_preview($_SESSION['efiling_details']['efiling_no']) . ' submitted successfully for approval of E-filing Admin.!</div>');
               //echo "querFy";
               redirect('jail_dashboard');
                exit(0);
            } else {
                echo "error";
                
                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Submition failed. Please try again!</div>');
                redirect('jail_dashboard');
                exit(0);
            }
          // }   // 
         }
        


}