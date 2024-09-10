<?php
namespace App\Controllers\OnlineCopying;

use App\Controllers\BaseController;
use App\Models\OnlineCopying\CommonModel;
use Config\Database;
class DefaultController extends BaseController
{

    protected $session;
    protected $Common_model;
    protected $db2;

    public function __construct()
    {
        parent::__construct();
        $this->session = \Config\Services::session();
        if (empty($this->session->get('login'))) {
            return response()->redirect(base_url('/'));
        } else {
            is_user_status();
        }
        $this->db2 = Database::connect('sci_cmis_final'); // Connect to the 'sci_cmis_final' database
        $this->Common_model = new CommonModel();

        unset($_SESSION['MSG']);
        unset($_SESSION['msg']);
    }

    public function copySearch()
    {
        $category = $this->Common_model->getCategory();
        return $this->render('onlineCopying.copy_search', compact('category'));
    }
    
    
    public function getCopySearch()
    {
        $track_horizonal_timeline = array();
        $disposed_flag = array('F', 'R', 'D', 'C', 'W');
        $preparedArray = [];
        $flag = $this->request->getVar('flag');
        $builder = $this->db2->table('public.copying_order_issuing_application_new a')
            ->select("'application' application_request, m.reg_no_display, m.c_status, a.id, a.application_number_display, a.diary, a.crn, a.application_receipt, a.updated_on, 
                      a.name, a.mobile, a.email, a.allowed_request, a.dispatch_delivery_date, a.application_status, a.filed_by, a.court_fee, a.postal_fee, a.delivery_mode, 
                      r.description, s.status_description")
            ->join('public.main m', 'CAST(m.diary_no AS BIGINT) = CAST(a.diary AS BIGINT)', 'left')
            ->join('master.ref_copying_source r', 'r.id = a.source', 'left')
            ->join('master.ref_copying_status s', 's.status_code = a.application_status', 'left');

        if ($flag == 'ano') {
            $builder->where('copy_category', $this->request->getVar('application_type'))
                          ->where('application_reg_number', $this->request->getVar('application_no'))
                          ->where('application_reg_year', $this->request->getVar('application_year'))
                          ->limit(1);
            $preparedArray = [
                'application_type' => $this->request->getVar('application_type'),
                'application_no' => $this->request->getVar('application_no'),
                'application_year' => $this->request->getVar('application_year')
            ];
        } else {
            $builder->where('crn', $this->request->getVar('crn'))
                          ->where('crn !=', '0')
                          ->unionAll(function($builder) {
                              $builder->select("'request' application_request, m.reg_no_display, m.c_status, a.id, a.application_number_display, a.diary, a.crn, a.application_receipt, a.updated_on, 
                                                a.name, a.mobile, a.email, a.allowed_request, a.dispatch_delivery_date, a.application_status, a.filed_by, a.court_fee, a.postal_fee, a.delivery_mode, 
                                                r.description, s.status_description")
                                      ->from('public.copying_request_verify a')
                                      ->join('public.main m', 'CAST(m.diary_no AS BIGINT) = CAST(a.diary AS BIGINT)', 'left')
                                      ->join('master.ref_copying_source r', 'r.id = a.source', 'left')
                                      ->join('master.ref_copying_status s', 's.status_code = a.application_status', 'left')
                                      ->where('crn', $this->request->getVar('crn'))
                                      ->where('crn !=', '0')
                                      ->limit(1);
                          });
            $preparedArray = ['crn' => $this->request->getVar('crn')];
        }

        $query = $builder->getCompiledSelect();
        // Execute the query
        $results = $this->db2->query($query, $preparedArray)->getRowArray();
        return $this->render('onlineCopying.get_copy_search', compact('results'));
    }

    public function trackConsignment()
    {
        return $this->render('onlineCopying.track');
    }
    public function getConsignmentStatus()
    {
        return $this->render('onlineCopying.get_consignment_status');
    }
    public function faq()
    {
        $faqs = $this->Common_model->copyFaq();
        return $this->render('onlineCopying.faq', compact('faqs'));
    }
    public function screenReader()
    {
        return $this->render('onlineCopying.screen_reader');
    }
    public function contactUs()
    {
        return $this->render('onlineCopying.contact_us');
    }
    public function caseSearch()
    {
        $caseType = $this->Common_model->getCaseType();
        return $this->render('onlineCopying.case_search', compact('caseType'));
    }
    
}
