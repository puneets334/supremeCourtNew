<?php

class DefaultController extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
         $allowed_users = array(USER_ADMIN,USER_ADMIN_READ_ONLY,USER_EFILING_ADMIN, USER_ADVOCATE, USER_IN_PERSON, USER_CLERK);
                
        if(!in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users )){
            redirect('login'); exit(0);
        }
        
        redirect('report/search');
        exit(0);
    }

}
