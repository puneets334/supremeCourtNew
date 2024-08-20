<?php
namespace App\Controllers\UserActions;
use App\Controllers\BaseController;
use App\Models\UserActions\UserActionsModel;



class Trash extends BaseController {

    protected $UserActionsModel;
    public function __construct() {
        parent::__construct();
        $this->UserActions_model = new UserActionsModel();
      
    }

    public function index() {

        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK);

        if (!in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('login');
            exit(0);
        }

        if (empty($_SESSION['efiling_details']) || empty($_SESSION['estab_details'])) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid Action.</div>');
            redirect('dashboard');
            exit(0);
        }
        $registration_id = $_SESSION['efiling_details']['registration_id'];

        $trash_button_stages = array(Draft_Stage, Initial_Defected_Stage);

        if (in_array($_SESSION['efiling_details']['stage_id'], $trash_button_stages)) {
            $next_stage = TRASH_STAGE;
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid Action.</div>');
            redirect('dashboard');
            exit(0);
        }

        $result = $this->UserActions_model->trashSubmit($registration_id, $next_stage);

        if ($result) {
            
            $subject = "Trashed : Efiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']);
            $sentSMS = "Efiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']) . " has been sent to trash from your account. - Supreme Court of India";
            
            $user_name = $_SESSION['login']['first_name'] . ' ' . $_SESSION['login']['last_name'];

            send_mobile_sms($_SESSION['login']['mobile_number'], $sentSMS,SCISMS_Efiling_Trashed);
            send_mail_msg($_SESSION['login']['emailid'], $subject, $sentSMS, $user_name);

            $this->session->set_flashdata('msg', '<div class="alert alert-success text-center"> E-filing number ' . efile_preview($_SESSION['efiling_details']['efiling_no']) . ' trashed successfully.</div>');
            $_SESSION['efiling_details']['stage_id']=TRASH_STAGE;


            switch ($_SESSION['efiling_details']['ref_m_efiled_type_id']){
                case E_FILING_TYPE_NEW_CASE:
                    redirect('newcase/view');
                    break;
                case E_FILING_TYPE_MISC_DOCS:
                    redirect('miscellaneous_docs/view');
                    break;
                case E_FILING_TYPE_DEFICIT_COURT_FEE:
                    //
                    break;
                case E_FILING_TYPE_IA:
                    redirect('IA/view');
                    break;
                case E_FILING_TYPE_CDE:
                    redirect('newcase/view');
                    break;
                case E_FILING_TYPE_MENTIONING:
                    redirect('mentioning/view');
                    break;
                case E_FILING_TYPE_CITATION:
                    redirect('citation/view');
                    break;
                case E_FILING_TYPE_CAVEAT :
                    redirect('caveat/view');
                    break;
                default:
                    redirect('dashboard');
                    break;
            }
            //redirect('dashboard');
            exit(0);
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Trashing failed. Please try again!</div>');
            redirect('dashboard');
            exit(0);
        }
    }

}
