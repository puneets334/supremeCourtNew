<?php

namespace App\Controllers\Newcase;

use App\Controllers\BaseController;
use App\Models\Common\CommonModel;
use App\Models\NewCase\GetDetailsModel;
use App\Models\NewCase\ActSectionsModel;
use App\Models\NewCase\DropdownListModel;
use App\Models\NewCase\ViewModel;
use App\Models\UploadDocuments\UploadDocsModel;

class View extends BaseController {

    protected $session;
    protected $CommonModel;
    protected $GetDetailsModel;
    protected $ActSectionsModel;
    protected $DropdownListModel;
    protected $ViewModel;
    protected $UploadDocsModel;

    public function __construct() {
        parent::__construct();
        if (empty(getSessionData('login'))) {
            return response()->redirect(base_url('/'));
        } else {
            is_user_status();
        }
        $this->CommonModel = new CommonModel();
        $this->GetDetailsModel = new GetDetailsModel();
        $this->ActSectionsModel = new ActSectionsModel();
        $this->DropdownListModel = new DropdownListModel();
        $this->ViewModel = new ViewModel();
        $this->UploadDocsModel = new UploadDocsModel();
        // unset($_SESSION['efiling_details']);
        // unset($_SESSION['estab_details']);
        // unset($_SESSION['case_table_ids']);
        // unset($_SESSION['parties_list']);
        // unset($_SESSION['efiling_type']);
        // unset($_SESSION['pg_request_payment_details']);
        // unset($_SESSION['eVerified_mobile_otp']['LITIGENT_MOB_OTP_VERIFY']);
    }

    function index() {
        $uri = service('uri');
        $InputArrray = array();
        if ($uri->getTotalSegments() >= 3) {
            $id = $uri->getSegment(3);
            $id = url_decryption($id);
            $InputArrray = explode('#', $id);
        }
        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT, USER_ADMIN, USER_ADMIN_READ_ONLY, USER_EFILING_ADMIN);
        if (!in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users_array)) {
            return redirect()->to(base_url('login'));
            // exit(0);
        }
        if(is_array($InputArrray) && count($InputArrray) > 0){
            $reg_id = $InputArrray[0];
        }
        $efiling_details = getSessionData('efiling_details');     
        // $params['registration_id'] = isset($efiling_details['registration_id']) ? $efiling_details['registration_id'] : NULL;
        $params['registration_id'] = !empty($_SESSION['efiling_details']['registration_id']) ? $_SESSION['efiling_details']['registration_id'] : NULL;
        $params['is_dead_minor'] = true;
        $params['is_deleted'] = 'false';
        $params['is_dead_file_status'] = 'false';
        $params['total'] = 1;
        $isdeaddata = $this->GetDetailsModel->getTotalIsDeadMinor($params);
        if (isset($isdeaddata[0]->total) && !empty($isdeaddata[0]->total)) {
            $total = $isdeaddata[0]->total;
            $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center">Please fill ' . $total . ' remaining dead/minor party details</div>');
            return redirect()->to(base_url('newcase/lr_party'));
        }
        $registration_id = isset($efiling_details['registration_id']) ? $efiling_details['registration_id'] : null;
        // $registration_id = $InputArrray[0];
        $data['new_case_details'] = $this->GetDetailsModel->get_new_case_details($registration_id);
        // pr($data['new_case_details']);
        $data['sc_case_type'] = (!empty($data['new_case_details'][0])) ? $this->DropdownListModel->get_sci_case_type_name($data['new_case_details'][0]->sc_case_type_id) : NULL;
        $data['main_subject_cat'] = (!empty($data['new_case_details'][0])) ? $this->DropdownListModel->get_main_subject_category_name($data['new_case_details'][0]->subj_main_cat) : NULL;
        if (!empty($data['new_case_details'][0]->subj_sub_cat_1)) {
            $data['sub_subject_cat'] = $this->DropdownListModel->get_main_subject_category_name($data['new_case_details'][0]->subj_sub_cat_1);
        }
        $data['petitioner_details'] = $this->GetDetailsModel->get_case_parties_details($registration_id, array('p_r_type' => 'P', 'm_a_type' => 'M', 'party_id' => NULL, 'view_lr_list' => FALSE));
        $data['respondent_details'] = $this->GetDetailsModel->get_case_parties_details($registration_id, array('p_r_type' => 'R', 'm_a_type' => 'M', 'party_id' => NULL, 'view_lr_list' => FALSE));
        $data['extra_parties_list'] = $this->GetDetailsModel->get_case_parties_details($registration_id, array('p_r_type' => NULL, 'm_a_type' => 'A', 'party_id' => NULL, 'view_lr_list' => FALSE));
        $data['lr_parties_list'] = $this->GetDetailsModel->get_case_parties_details($registration_id, array('p_r_type' => NULL, 'm_a_type' => NULL, 'party_id' => NULL, 'view_lr_list' => TRUE));
        $data['act_sections_list'] = $this->ActSectionsModel->get_act_sections_list($registration_id);
        $data['party_details'] = $this->GetDetailsModel->get_case_parties_details($registration_id, array('p_r_type' => 'P', 'm_a_type' => 'M', 'party_id' => NULL, 'view_lr_list' => FALSE));
        $data['subordinate_court_details'] = $this->GetDetailsModel->get_subordinate_court_details($registration_id);
        $data['payment_details'] = $this->ViewModel->get_payment_details($registration_id);
        $data['efiled_docs_list'] = $this->ViewModel->get_index_items_list($registration_id);
        // pr($data['efiled_docs_list']);

        // $data['esigned_docs_details'] = $this->Affirmation_model->get_esign_doc_details($registration_id);
        $creaedBy = !empty($data['new_case_details'][0]->created_by) ? $data['new_case_details'][0]->created_by : NULL;
        $data['uploaded_docs'] = $this->UploadDocsModel->get_uploaded_pdfs($registration_id);
        $data['uploaded_deleted_docs_while_refiling'] = $this->UploadDocsModel->get_deleted_uploaded_pdfs_while_refiling($registration_id);
        if (isset($creaedBy) && !empty($creaedBy)) {
            $params = array();
            $params['table_name'] = 'efil.tbl_users';
            $params['whereFieldName'] = 'id';
            $params['whereFieldValue'] = (int)$creaedBy;
            // $params['is_active'] ='1';
            $userData = $this->CommonModel->getData($params);
            if (isset($userData) && !empty($userData)) {
                if ($userData[0]['ref_m_usertype_id'] == USER_ADVOCATE) {
                    $data['filedByData'] = $userData[0]['first_name'] . ' (AOR Code: ' . $userData[0]['aor_code'] . ')';
                    $data['filedByData_contact_emailid'] = 'Contact no: ' . $userData[0]['moblie_number'] . '<br> Email-Id: ' . $userData[0]['emailid'];
                    $nocVakalatnamaData = $this->CommonModel->getData(['table_name' => 'efil.tbl_efiling_nums', 'whereFieldName' => 'registration_id', 'whereFieldValue' => $registration_id]);
                    if (trim($nocVakalatnamaData[0]['created_by']) != trim($userData[0]['id'])) {
                        $nocVakalatnamaUserData = $this->CommonModel->getData(['table_name' => 'efil.tbl_users', 'whereFieldName' => 'id', 'whereFieldValue' => (int)$nocVakalatnamaData[0]['created_by']]);
                        $data['vakalat_filedByData'] = $nocVakalatnamaUserData[0]['first_name'] . ' (AOR Code: ' . $nocVakalatnamaUserData[0]['aor_code'] . ')';
                        $data['vakalat_filedByData_contact_emailid'] = 'Contact no: ' . $nocVakalatnamaUserData[0]['moblie_number'] . '<br> Email-Id: ' . $nocVakalatnamaUserData[0]['emailid'];
                    }
                } else if ($userData[0]['ref_m_usertype_id'] == USER_IN_PERSON) {
                    $data['filedByData'] = $userData[0]['first_name'] . ' (Party in person)';
                    $data['filedByData_contact_emailid'] = 'Contact no: ' . $userData[0]['moblie_number'] . '<br> Email-Id: ' . $userData[0]['emailid'];
                }
                /*$adv_sci_bar_id = !empty($userData[0]->adv_sci_bar_id) ? (int)$userData[0]->adv_sci_bar_id : NULL;
                if(isset($adv_sci_bar_id) && !empty($adv_sci_bar_id)){
                    $getBarData = $this->CommonModel->getBarDetailsById($adv_sci_bar_id);
                    $data['filedByData'] = !empty($getBarData) ?  $getBarData[0] : NULL;
                }*/
            }
        }
        // $this->load->view('templates/header');
        // $this->load->view('newcase/efile_details_view', $data);
        // $this->load->view('templates/footer');
        return $this->render('newcase.efile_details_view', $data);
    }

}