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
    protected $db3;

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
        $this->db3 = Database::connect('sci_cmis_final'); // Connect to the 'sci_cmis_final' database
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
            $_SESSION['session_authorized_bar_id'] = $dOtp->authorized_bar_id;
            if($dOtp->filed_by == 6){
                // $_SESSION['session_authorized_bar_id'] = $dOtp->authorized_bar_id;            
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
    public function unavailableRequest()
    {
        return $this->render('onlineCopying.unavailable_request');
    }
    public function requestedDocumentsSave()
    {
        $doc_array = array();
        if(!empty($_POST['document_type'])){
            for($i = 0; $i < count($_POST['document_type']); $i++){
                if(!empty($_POST['document_type'][$i])){


                    if($_POST['mandate_date_of_order_type'][$i] == 'Y' && empty($_POST['order_date'][$i])){
                        $array = array('status' => $_POST['document_type_text'][$i].' - Empty Order Date Not Allowed.');
                        echo json_encode($array);
                        exit();
                    }
                    else if($_POST['mandate_date_of_order_type'][$i] == 'Y' && !empty($_POST['order_date'][$i]) && date('Y-m-d', strtotime($_POST['order_date'][$i])) > date('Y-m-d')){
                        $array = array('status' => $_POST['document_type_text'][$i].' - Wrong Order Date Not Allowed.');
                        echo json_encode($array);
                        exit();
                    }
                    else if($_POST['mandate_remark_of_order_type'][$i] == 'Y' && empty($_POST['doc_detail'][$i])){
                        $array = array('status' => $_POST['document_type_text'][$i].' - Empty Document detail Not Allowed.');
                        echo json_encode($array);
                        exit();
                    }
                    else {
                        $doc_array[] = array("document_type" => $_POST['document_type'][$i], "order_date" => $_POST['order_date'][$i], "doc_detail" => $_POST['doc_detail'][$i]);
                    }
                }
            }
        }
        if($_SESSION['max_unavailable_copy_request_per_day'] >=10){
            $array = array('status' => 'Max 10 unavailable document request reached per day.');
            exit();
        }
        if (!empty($_POST) && $_SESSION['is_token_matched'] == 'Yes' && isset($_SESSION["applicant_email"]) && isset($_SESSION["applicant_mobile"])) {
            $diary_no=$_SESSION['session_d_no'].$_SESSION['session_d_year'];
            //VERIFICATION OF CASE ALREADY APPLIED
            $builder = $this->db2->table('copying_request_verify');
            $builder->select('diary');
            $builder->where('allowed_request', 'request_to_available');
            $builder->where('mobile', $_SESSION["applicant_mobile"]);
            $builder->where('diary', $diary_no);
            $builder->where('application_status', 'P');

            $query = $builder->get();
            $result = $query->getResult();
            if (count($result) > 0 || $_SESSION['unavailable_copy_requested_diary_no'] == $diary_no) {
                $array = array('status' => 'Please wait till completion of your previous request.');
            }
            else {
                if (isset($_SESSION['user_address'])) {
                    foreach ($_SESSION['user_address'] as $data_address) {
                        $address_id = $data_address['address_id'];
                        $first_name = $data_address['first_name'];
                        $second_name = $data_address['second_name'];
                        $postal_add = $data_address['address'];
                        $city = $data_address['city'];
                        $district = $data_address['district'];
                        $state = $data_address['state'];
                        $country = $data_address['country'];
                        $pincode = $data_address['pincode'];
                        break;
                    }
                }

                $allowed_request = "request_to_available";
                $scipay = 10002;
                $create_crn = createCRN($scipay);//for unavailable document request
                $json_crn = json_decode($create_crn);
                if ($json_crn->{'Status'} == "success") {
                    $crn = $json_crn->{'CRN'};

                    $dataArray = array(
                        "diary" => $_SESSION['session_d_no'] . $_SESSION['session_d_year'],
                        "copy_category" => '0',
                        "application_reg_number" => '0',
                        "application_reg_year" => '0',
                        "application_receipt" => date('Y-m-d H:i:s'),
                        "advocate_or_party" => '0',
                        "court_fee" => '0',

                        "delivery_mode" => "1",
                        "postal_fee" => '0',
                        "ready_date" => '',
                        "dispatch_delivery_date" => '',
                        "adm_updated_by" => '1',
                        "updated_on" => date('Y-m-d H:i:s'),
                        "is_deleted" => "0",
                        "is_id_checked" => '',

                        "purpose" => '',
                        "application_status" => 'P',
                        "defect_code" => '',
                        "defect_description" => '',
                        "notification_date" => '',
                        "filed_by" => $_SESSION["session_filed"],
                        "name" => $first_name . ' ' . $second_name,
                        "mobile" => $_SESSION["applicant_mobile"],
                        "address" => $postal_add . ', ' . $city . ', ' . $district . ', ' . $state . ', ' . $country . ' - ' . $pincode,

                        "application_number_display" => '',
                        "temp_id" => '',
                        "remarks" => '',
                        "source" => '6',
                        "send_to_section" => 'f',
                        "crn" => $crn,
                        "email" => $_SESSION["applicant_email"],
                        "authorized_by_aor" => $_SESSION['session_authorized_bar_id'] > 0 ? $_SESSION['session_authorized_bar_id'] : '0',
                        "allowed_request" => $allowed_request,

                        "token_id" => '',
                        "address_id" => $address_id
                    );

                    $insert_application = insert_copying_application_online($dataArray); //insert application
                    $json_insert_application = json_decode($insert_application);
                    if ($json_insert_application->{'Status'} == "success") {
                        $last_application_id = $json_insert_application->{'last_application_id'};
                        for ($var = 0; $var < count($doc_array); $var++) {
                            $document_type = $doc_array[$var]['document_type'];
                            $ordate_date = $doc_array[$var]['order_date'];
                            $doc_details = $doc_array[$var]['doc_detail'];
                            $document_array = array();
                            $document_array = array(
                                'order_type' => $document_type,
                                'order_date' => date('Y-m-d', strtotime($ordate_date)),
                                'copying_order_issuing_application_id' => $last_application_id,
                                'number_of_copies' => '1',
                                'number_of_pages_in_pdf' => '0',
                                'path' => null,
                                'from_page' => null,
                                'to_page' => null,
                                'order_type_remark' => $doc_details,
                                'is_bail_order' => 'N'
                            );
                            $insert_application_documents = insert_copying_application_documents_online($document_array); //insert user assets
                            $json_insert_application_documents = json_decode($insert_application_documents);
                            if ($json_insert_application_documents->{'Status'} == "success") {

                            } else {
                                $array = array('status' => 'Unable to insert records');
                            }
                        }

                        $sms = "Your request successfully submitted with CRN $crn for reference - Supreme Court Of India";
                        //Your request successfully submitted with CRN {#var#} for reference - Supreme Court Of India
                        $mobile = $_SESSION["applicant_mobile"];

                        $sms_response = sci_send_sms($mobile, $sms, 'ecop', SCISMS_e_copying_crn_created);
                        $json = json_decode($sms_response);
                        if ($json->{'Status'} == "success") {
                            $_SESSION['max_unavailable_copy_request_per_day'] = $_SESSION['max_unavailable_copy_request_per_day'] + 1;
                            $_SESSION['unavailable_copy_requested_diary_no'] = $diary_no;
                            $array = array('status' => 'success');
                        }

                    } else {
                        $array = array('status' => 'Unable to insert records');
                    }
                } else {
                    $array = array('status' => 'Permission Denied');
                }
            }
            echo json_encode($array);
        }
    }

    public function caseRelationVerification(){
        return $this->render('onlineCopying.case_relation_verification');
    }
    public function sciRequest(){
        return $this->render('onlineCopying.sci_request');
    }
    public function sciRequestPayment(){
        return $this->render('onlineCopying.sci_request_payment');
    }

}


