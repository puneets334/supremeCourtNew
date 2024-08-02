<?php
namespace App\Controllers\Assistance;
use App\Controllers\BaseController;

class Contact_us extends BaseController {

    public function __construct() {
        parent::__construct();        
    }

    public function index() {

        $allowed_users = array(USER_ADMIN, USER_ADVOCATE, USER_IN_PERSON, USER_CLERK,SR_ADVOCATE);
        if (!in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users)) {
            redirect('login'); exit(0);
        }
        // $this->load->view('templates/header');
        $this->render('assistance.contactus_view');
        // $this->load->view('templates/footer');
    }
}
