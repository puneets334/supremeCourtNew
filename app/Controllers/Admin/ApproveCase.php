<?php
namespace App\Controllers;

class ApproveCase extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('common/Common_model');

        $this->load->model('newcase/New_case_model');
        $this->load->model('newcase/Dropdown_list_model');
        $this->load->model('newcase/Get_details_model');
        $this->load->model('newcase/Admin_case_action_model');
    }

    public function index() {

        $Array = array(New_Filing_Stage, Initial_Defects_Cured_Stage);
        if (!in_array($_SESSION['efiling_details']['stage_id'], $Array)) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"> ' . htmlentities('Invalid Action', ENT_QUOTES) . ' </div>');
            redirect('admin');
            exit(0);
        }

        $allowed_users_array = array(USER_ADMIN);
        if (!in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('dashboard');
            exit(0);
        }

        if (empty($_SESSION['efiling_details']) || empty($_SESSION['estab_details'])) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"> ' . htmlentities('Invalid Action', ENT_QUOTES) . ' </div>');
            redirect('adminDashboard');
            exit(0);
        }

        $regid = $this->session->userdata['efiling_details']['registration_id'];
        $filing_type = $this->session->userdata['efiling_details']['ref_m_efiled_type_id'];

        $data = $this->Admin_case_action_model->approve_case($regid, $filing_type);

        if ($data) {
            $userdata = $this->New_case_model->get_efiled_by_user($_SESSION['efiling_details']['created_by']);
            $pet_user_name = $petitioner_details[0]['pet_name'];
            //$sentSMS = "eFiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']) . " has been approved.";
            $sentSMS = "eFiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']) . " has been initially accepted for further processing.";
            //$subject = "Approved : eFiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']);
            $subject = "Initially accepted : eFiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']);
            log_message('CUSTOM', "eFiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']) . " has been initially accepted for further processing.");

            $responseObj = send_mobile_sms($userdata[0]->moblie_number, $sentSMS,SCISMS_Efiling_Acceptance);

            $user_name = $userdata[0]->first_name . ' ' . $userdata[0]->last_name;

            send_mail_msg($userdata[0]->emailid, $subject, $sentSMS, $user_name);


            if ($userdata[0]->ref_m_usertype_id == USER_ADVOCATE) {
                $petitioner_details = $this->Common_model->get_petitioner_details($regid);
                send_petitioner_mobile_sms($petitioner_details[0]['mobile'], $sentSMS);
                send_petitioner_mail_msg($petitioner_details[0]['email'], $subject, $sentSMS, $pet_user_name);


                foreach ($petitioner_details as $efiling) {
                    $pet_exp_name = $efiling['name'];
                    send_petitioner_mobile_sms($efiling['exp_mobile'], $sentSMS);
                    send_petitioner_mail_msg($efiling['exp_email'], $subject, $sentSMS, $pet_exp_name);
                }
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">E-filing Number ' . efile_preview($_SESSION['efiling_details']['efiling_no']) . ' Approved successfully !</div>');
            log_message('CUSTOM', "E-filing Number ". efile_preview($_SESSION['efiling_details']['efiling_no'])."Approved successfully !");
            redirect('admin');
            exit(0);
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Approval Failded. Please try again!</div>');
            log_message('CUSTOM', "Approval Failded. Please try again!");
            if ($filing_type == E_FILING_TYPE_NEW_CASE) {
                $redirectURL = 'New_case/view';
            } elseif ($filing_type == E_FILING_TYPE_MISC_DOCS) {
                $redirectURL = 'MiscellaneousFiling/view';
            } elseif ($filing_type == E_FILING_TYPE_DEFICIT_COURT_FEE) {
                $redirectURL = 'Deficit_court_fee/view';
            } elseif ($filing_type == E_FILING_TYPE_IA) {
                $redirectURL = 'IA/view';
            } else {
                $redirectURL = 'admin';
            }
            redirect($redirectURL);
            exit(0);
        }
    }

}
