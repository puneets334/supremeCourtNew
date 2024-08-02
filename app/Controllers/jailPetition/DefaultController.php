<?php
namespace App\Controllers;

class DefaultController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('jailPetition/JailPetitionModel');
        $this->load->model('common/Common_model');
        $this->load->model('newcase/Dropdown_list_model');
        unset($_SESSION['efiling_details']);
        unset($_SESSION['estab_details']);
        unset($_SESSION['case_table_ids']);
        unset($_SESSION['parties_list']);
        unset($_SESSION['efiling_type']);
        unset($_SESSION['pg_request_payment_details']);
        unset($_SESSION['eVerified_mobile_otp']['LITIGENT_MOB_OTP_VERIFY']);
    }

    public function _remap($param = NULL) {

        if ($param == 'index') {
            $this->index(NULL);
        } else {
            $this->index($param);
        }
    }


    public function index($id = NULL) {

        $allowed_users_array = array(JAIL_SUPERINTENDENT, USER_ADMIN);

        if (!in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('login');
            exit(0);
        }
        if ($id) {

            $id = url_decryption($id);
            $InputArrray = explode('#', $id);   //0=>registration_id,1=>type,2=>stage

            if (!is_numeric($InputArrray[0]) || $InputArrray[1] != E_FILING_TYPE_JAIL_PETITION || !is_numeric($InputArrray[2])) {
                redirect('login');
                exit(0);
            }
            $registration_id = $InputArrray[0];
            $_SESSION['regid'] = $InputArrray[0];

            // SETS $_SESSION['estab_details']

            $estab_details = $this->Common_model->get_establishment_details();//print_r($_SESSION);die;

            if ($estab_details) {
                //SET $_SESSION['efiling_details']
                $efiling_num_details = $this->Common_model->get_efiling_num_basic_Details($registration_id);
            } else {
                redirect('login');
                exit(0);
            }
        } else {

            // SETS $_SESSION['estab_details']
            $estab_details = $this->Common_model->get_establishment_details();
            /*var_dump($estab_details);
            exit(0);*/
            if ($estab_details) {
                //redirect('jailPetition/BasicDetails');
                redirect('jail_dashboard');
                exit(0);
            }
        }
        if (isset($_SESSION['efiling_details']) && !empty($_SESSION['efiling_details'])) {

            $stages_array = array(Draft_Stage, Initial_Defected_Stage, I_B_Defected_Stage);

            $allowed_users = array(JAIL_SUPERINTENDENT);

            if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADMIN || !in_array($_SESSION['efiling_details']['stage_id'], $stages_array)) {

                redirect('jailPetition/view');
                exit(0);
            } elseif ((in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users) && in_array($_SESSION['efiling_details']['stage_id'], $stages_array)) ) {

                switch (max(explode(',', $_SESSION['efiling_details']['breadcrumb_status']))) {

                    case JAIL_PETITION_CASE_DETAILS: {
                        redirect('jailPetition/BasicDetails');
                        exit(0);
                    }

                    case JAIL_PETITION_EXTRA_PETITIONER: {
                        redirect('jailPetition/Extra_petitioner');
                        exit(0);
                    }
                    case JAIL_PETITION_SUBORDINATE_COURT: {
                        redirect('jailPetition/Subordinate_court');
                        exit(0);
                    }
                    case JAIL_PETITION_SIGN_METHOD: {
                        redirect('jailPetition/sign_method');
                        exit(0);
                    }
                    case JAIL_PETITION_UPLOAD_DOCUMENT: {
                        redirect('uploadDocuments');
                        exit(0);
                    }

                    case JAIL_PETITION_AFFIRMATION; {
                        redirect('affirmation');
                        exit(0);
                    }
                    case JAIL_PETITION_VIEW: {
                        redirect('jailPetition/view');
                        exit(0);
                    }
                    default: {
                        redirect('jailPetition/BasicDetails');
                        exit(0);
                    }
                }
            } else {
                redirect('login');
                exit(0);
            }
        } else {
            redirect('login');
            exit(0);
        }
    }


}

?>