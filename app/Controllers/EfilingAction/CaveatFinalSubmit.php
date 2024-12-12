<?php
namespace App\Controllers\EfilingAction;
use App\Controllers\BaseController;
use App\Models\Caveat\ViewModel;
use App\Models\EfilingAction\CaveatFinalSubmitModel;
use App\Models\Caveat\CaveateeModel;
use App\Models\Common\CommonModel;

class CaveatFinalSubmit extends BaseController {
    protected $View_model;
    protected $Caveat_final_submit_model;
    protected $Caveatee_model;
    protected $CommonModel;
    public function __construct() {
        parent::__construct();
        $this->View_model = new ViewModel();
        $this->Caveat_final_submit_model = new CaveatFinalSubmitModel();
        $this->Caveatee_model = new CaveateeModel();
        $this->CommonModel = new CommonModel();        
    }

    public function index() {
        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK);
        if (!in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('dashboard');
            exit(0);
        }
        if (empty($_SESSION['efiling_details']) || empty($_SESSION['estab_details'])) {
            redirect('dashboard');
            exit(0);
        }
        $registration_id = $_SESSION['efiling_details']['registration_id'];
        $this->CommonModel->get_efiling_num_basic_Details($registration_id);
        // if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_DEFICIT_COURT_FEE && (bool) $_SESSION['estab_details']['enable_payment_gateway']) {
        //     $next_stage = Transfer_to_IB_Stage;
        // }
        if(in_array(CAVEAT_BREAD_COURT_FEE, explode(',', $_SESSION['efiling_details']['breadcrumb_status'])) && (bool) $_SESSION['estab_details']['enable_payment_gateway'] && ($_SESSION['efiling_details']['stage_id'] == Draft_Stage)){
            $next_stage = Initial_Approaval_Pending_Stage;
        } elseif ($_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
            $next_stage = Draft_Stage;
        } elseif ($_SESSION['efiling_details']['stage_id'] == Draft_Stage) {
            $next_stage = Initial_Approaval_Pending_Stage;
        } elseif ($_SESSION['efiling_details']['stage_id'] == Initial_Defected_Stage) {
            $next_stage = Initial_Defects_Cured_Stage;
        }  elseif ($_SESSION['efiling_details']['stage_id'] == I_B_Defected_Stage) {
            $next_stage = I_B_Defects_Cured_Stage;
        } elseif ($_SESSION['efiling_details']['stage_id'] == I_B_Rejected_Stage || $_SESSION['efiling_details']['stage_id'] == E_REJECTED_STAGE) {
            $next_stage = Initial_Defects_Cured_Stage;
        } else {
            $this->session->setFlashData('msg', '<div class="alert alert-danger text-center">Invalid Action.</div>');
            redirect('dashboard');
        }
        $final_submit = TRUE;
        if ($final_submit) {
            if ($_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
                if (empty($_POST['advocate_id'])) {
                    echo $_SESSION['MSG'] = message_show("fail", "Please Select Advocate!");
                    redirect('dashboard');
                }
                $_SESSION['dept_adv_panel']['id'] = url_decryption($_POST['advocate_id']);
            }
            $result = $this->Caveat_final_submit_model->updateCaseStatus($registration_id, $next_stage);
            if ($result) {
                $session_bredcrumbs = $_SESSION['efiling_details']['breadcrumb_status'].','.CAVEAT_BREAD_VIEW ;
                $_SESSION['efiling_details']['breadcrumb_status'] = $session_bredcrumbs;
                $this->Caveatee_model->update_breadcrumbs($registration_id,CAVEAT_BREAD_VIEW);
                // $sentSMS = "Efiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']) . " has been submitted and is pending for initial approval with efiling admin.";
                // comment for work
                //   $sms_data = get_sms_text(1);
                //   $sms_text = $sms_data['sms'];
                //   $sms_text = str_replace('{#var#}', efile_preview($_SESSION['efiling_details']['efiling_no']), $sms_text);
                //   $subject = "Submitted : Efiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']);
                //   $user_name = $_SESSION['login']['first_name'] . ' ' . $_SESSION['login']['last_name'];
                //   send_mobile_sms($_SESSION['login']['mobile_number'], $sms_text, $sms_data);
                //   send_mail_msg($_SESSION['login']['emailid'], $subject, $sms_text, $user_name);
                getSessionData('caveat_msg',true);
                $this->session->setFlashData('msg', '<div class="alert alert-success text-center"> E-filing number ' . efile_preview($_SESSION['efiling_details']['efiling_no']) . ' submitted successfully for approval of E-filing Admin.!</div>');
                // log_message('CUSTOM', " E-filing number ". efile_preview($_SESSION['efiling_details']['efiling_no']) . "submitted successfully for approval of E-filing Admin.!");
                // redirect('dashboard');
            } else {
                $this->session->setFlashData('msg', '<div class="alert alert-danger text-center">Submition failed. Please try again!</div>');
                // redirect('dashboard');
            }             
            return redirect()->to(base_url('caveat/defaultController/processing/' . url_encryption(trim($registration_id . '#' . E_FILING_TYPE_CAVEAT . '#2'))));
            // redirect('caveat/defaultController/processing/' . url_encryption(trim($registration_id . '#' . E_FILING_TYPE_CAVEAT . '#2')));
        }
    }

}