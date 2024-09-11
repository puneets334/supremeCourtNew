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
        $_SESSION['is_token_matched'] = 'Yes';
        $_SESSION['applicant_email'] = getSessionData('login')['emailid'];
        $_SESSION['applicant_mobile'] = getSessionData('login')['mobile_number'];
        $checkUserAddress = getUserAddress(getSessionData('login')['mobile_number'], getSessionData('login')['emailid']);
        if (count($checkUserAddress) > 0){
            $address_array = array();
            $_SESSION['is_user_address_found'] = 'YES';
            $address_data = $checkUserAddress;
            foreach($address_data as $r) {
                $address_array[] = $r;   
            }
            $_SESSION['user_address'] = $address_array;
        }
        else{
            $_SESSION['is_user_address_found'] = 'NO';
        }
        $dOtp = eCopyingOtpVerification($_SESSION['applicant_email']);
        if($dOtp){
            $_SESSION['session_verify_otp'] = '000000';
            $_SESSION['session_otp_id'] = '999999';
            $_SESSION['applicant_mobile'] = $dOtp->mobile;
            $_SESSION['applicant_email'] = $dOtp->email;
            $_SESSION['is_email_send'] = 'Yes';
            $_SESSION['email_token'] = $dOtp->otp;
            $_SESSION['is_token_matched'] = 'Yes';
            
            $_SESSION["session_filed"] = $dOtp->filed_by;
            
            if($dOtp->filed_by == 6){
                $_SESSION['session_authorized_bar_id'] = $dOtp->authorized_bar_id;            
                $aor_data = eCopyingGetBarDetails($dOtp->authorized_bar_id);
                if (count($aor_data) == 1){
                    $aor_mobile = $aor_data->mobile;
                    $_SESSION["aor_mobile"] = $aor_data->mobile; 
                }
            }
        }
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
    public function getCaseDetails()
    {
        return $this->render('onlineCopying.get_case_details');
    }
    public function getAppCharge()
    {
        $r_sql = $this->Common_model->getCatogoryForApplication($_REQUEST['idd']);
        $app_rule='';
        if($r_sql->urgent_fee!=0)
        {
            $app_rule=$app_rule.$r_sql->urgent_fee.'/- urgency fees + ';
        }
        if($r_sql->per_certification_fee!=0)
        {
            $app_rule=$app_rule.$r_sql->per_certification_fee.'/- per certification + ';
        }
        if($_SESSION["session_filed"] == 4 && $_REQUEST['idd'] != 5){
            $app_rule=$app_rule.'5/- (third party charges) + ';
        }
        $app_rule=$app_rule.$r_sql->per_page.'/- per page';
        $app='';
        if($r_sql->id==5)
        {
            $app= " <span class='font-weight-bold text-info'>First copy free of cost, thereafter - </span>";
        }
        return $app."Rs. ".$app_rule;
    }
    public function getTotCopy()
    {
        return $this->render('onlineCopying.get_tot_copy');
    }
}
