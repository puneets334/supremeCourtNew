<?php
namespace App\Controllers;
class DefaultController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
         $allowed_users = array(USER_ADMIN, USER_ADVOCATE, USER_IN_PERSON, USER_CLERK);
                
        if(!in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users )){
            redirect('login'); exit(0);
        }
        
        redirect('assistance/notice_circulars');
        exit(0);
    }

}
