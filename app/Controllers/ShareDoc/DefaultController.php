<?php

namespace App\Controllers\ShareDoc;
use App\Controllers\BaseController;
use App\Models\ShareDoc\ShareDocsModel;
use App\Libraries\webservices\Efiling_webservices;



class DefaultController extends BaseController {
    protected $Share_docs_model;
    protected $efiling_webservices;

    public function __construct() {

        parent::__construct();
        $this->Share_docs_model = new ShareDocsModel();
        $this->efiling_webservices = new Efiling_webservices();
        // $this->load->library('webservices/efiling_webservices');
        // $this->load->model('shareDoc/Share_docs_model');
        
    }

    public function index() {

        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT);

        if (!in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('login');
            exit(0);
        }
        redirect('miscellaneous_docs/courtFee');
        $data['email_details'] = $this->Share_docs_model->get_email_details($_SESSION['efiling_details']['registration_id']);
        $data['case_aor_contacts'] = $this->Share_docs_model->get_case_aor_contacts($_SESSION['efiling_details']['registration_id']);
        $diaryId=$_SESSION['efiling_details']['diary_no'].$_SESSION['efiling_details']['diary_year'];
        $data['case_aor_contacts'] = $advocate_list = $this->efiling_webservices->get_advocate_list($diaryId);;
        $data['contact'] = $this->Share_docs_model->get_contact();
        $data['aor_contact'] = $this->Share_docs_model->get_aor_contact();
        //var_dump($date['case_aor_contacts']);
        return $this->render('shareDoc.share_document',$data);
    }

}
