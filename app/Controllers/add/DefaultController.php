<?php
namespace App\Controllers;
class DefaultController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN) {
            redirect('admin');
        } elseif ($this->session->userdata['login']['ref_m_usertype_id'] == USER_SUPER_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_MASTER_ADMIN) {
            redirect('report/progress/work_done');
        } elseif ($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE || $_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON || $_SESSION['login']['ref_m_usertype_id'] == USER_PDE || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK || $_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT) {
            redirect('dashboard');
        }
    }

}
