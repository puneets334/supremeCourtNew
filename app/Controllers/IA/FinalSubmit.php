<?php
namespace App\Controllers\IA;
use App\Controllers\BaseController;
use App\Models\Common\CommonModel;
use App\Models\NewCase\NewCaseModel;
use App\Models\NewCase\DropdownListModel;
use App\Models\NewCase\GetDetailsModel;

class FinalSubmit extends BaseController {
    protected $Common_model;

    public function __construct() {
        parent::__construct();
        // $this->load->model('common/Common_model');
        $this->Common_model = new CommonModel();
        // $this->load->model('newcase/New_case_model');
        // $this->load->model('newcase/Dropdown_list_model');
        // $this->load->model('newcase/Get_details_model');
        // $this->Common_model = new CommonModel();
        // $this->Share_docs_model = new ShareDocsModel();
    }

    public function index() {

        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK,AMICUS_CURIAE_USER);

        if (!in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('dashboard');
            exit(0);
        }

        if (empty($_SESSION['efiling_details']) || empty($_SESSION['estab_details'])) {
            redirect('dashboard');
            exit(0);
        }

        $registration_id = $_SESSION['efiling_details']['registration_id'];
        $next_stage = 0;
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
            getSessionData('msg', '<div class="alert alert-danger text-center">Invalid Action.</div>');
            redirect('dashboard');
        }

        $final_submit = TRUE;
        if ($final_submit) {
            $result = $this->Common_model->updateCaseStatus($registration_id, $next_stage);
            if ($result) {

                $sentSMS = "Efiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']) . " has been submitted and is pending for initial approval with efiling admin. - Supreme Court of India";
                // log_message('CUSTOM', "Efiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']) . " has been submitted and is pending for initial approval with efiling admin. - Supreme Court of India");
                $subject = "Submitted : Efiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']);

                $user_name = $_SESSION['login']['first_name'] . ' ' . $_SESSION['login']['last_name'];

                send_mobile_sms($_SESSION['login']['mobile_number'], $sentSMS,SCISMS_Initial_Approval);
                send_mail_msg($_SESSION['login']['emailid'], $subject, $sentSMS, $user_name);

                //getSessionData('msg', '<div class="alert alert-success text-center"> E-filing number ' . efile_preview($_SESSION['efiling_details']['efiling_no']) . ' submitted successfully for approval of E-filing Admin.!</div>');
                // log_message('CUSTOM', "E-filing number ". efile_preview($_SESSION['efiling_details']['efiling_no'])." submitted successfully for approval of E-filing Admin.!");
                $_SESSION['efiling_details']['stage_id']=Initial_Approaval_Pending_Stage;
                getSessionData('msg', '<div class="alert alert-success text-center"> E-filing number ' . efile_preview($_SESSION['efiling_details']['efiling_no']) . ' submitted successfully for approval of E-filing Admin.!</div>');
                $this->session->setFlashdata('msg','<div class="alert alert-success text-center"> E-filing number ' . efile_preview($_SESSION['efiling_details']['efiling_no']) . ' submitted successfully for approval of E-filing Admin.!</div>');
                 return redirect('IA/view');
                //redirect('dashboard');
                // exit(0);

            } else {
                getSessionData('msg', '<div class="alert alert-danger text-center">Submition failed. Please try again!</div>');
                // log_message('CUSTOM', "Submition failed. Please try again!");
                return redirect('IA/view');
                //redirect('dashboard');
            }
        }
    }

}
