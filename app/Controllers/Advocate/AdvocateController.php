<?php

namespace App\Controllers\Advocate;
use App\Controllers\BaseController;
use CodeIgniter\Database\Query;
use App\Models\Advocate\AdvocateModel;
use Config\Database;
// use App\Models\AdminDashboard\AdminDashboardModel;

class AdvocateController extends BaseController
{
    // protected $AdminReportModel;
    protected $AdvocateModel;
    protected $db;
    protected $session;

    public function __construct()
    {
        parent::__construct();
        $this->AdvocateModel = new AdvocateModel();            
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        // $model = new AdvocateModel();
        // pr($model);
    }
    public function listed_cases() {
        $pager = \Config\Services::pager();
        $aor_code='';
        if(!empty(getSessionData('login')['aor_code'])){
            $aor_code=getSessionData('login')['aor_code'];
            $list= $this->AdvocateModel->getListedCases($aor_code);
            $data['heading'] = 'CAUSE LIST';
            return $this->render('advocate.listed_cases', @compact('data','list'));
        }
        else{
            redirect('login');
            exit(0);
        }
    }











    public function reportForm()
    {

        if (empty(getSessionData('login')['ref_m_usertype_id'])) {
            redirect('login');
            exit(0);
        }
        $allowed_users_array = array(USER_EFILING_ADMIN, USER_ADMIN);
        if (!in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('filingAdmin');
            exit(0);
        }
        return $this->render('adminReport.reports');
        // $this->load->view('templates/admin_header');
        // $this->load->view('adminReport/reports');
        // $this->load->view('templates/footer');
    }

  

    public function reportFormNew()
    {
        if (empty(getSessionData('login')['ref_m_usertype_id'])) {
            redirect('login');
            exit(0);
        }
        $allowed_users_array = array(USER_EFILING_ADMIN, USER_ADMIN);
        if (!in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('filingAdmin');
            exit(0);
        }
        $data['count_efiling_data'] = $this->AdminDashboardModel->get_efilied_nums_stage_wise_count();
        $this->load->view('templates/admin_header');
        $this->load->view('adminReport/reports_new', $data);
        $this->load->view('templates/footer');
    }
 
}