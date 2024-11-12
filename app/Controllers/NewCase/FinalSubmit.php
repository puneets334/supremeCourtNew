<?php
namespace App\Controllers\Newcase;

use App\Controllers\BaseController;
use App\Libraries\webservices\Efiling_webservices;
use App\Models\Common\CommonModel;
use App\Models\DocumentIndex\DocumentIndexModel;
use App\Models\DocumentIndex\DocumentIndexSelectModel;
use App\Models\Filehashing\PdfHashTasksModel;
use App\Models\Mentioning\ListingModel;
use App\Models\NewCase\DropdownListModel;
use App\Models\NewCase\GetDetailsModel;
use App\Models\NewCase\NewCaseModel;

class FinalSubmit extends BaseController
{

    protected $Common_model;
    protected $Listing_model;
    protected $New_case_model;
    protected $Dropdown_list_model;
    protected $Get_details_model;
    protected $DocumentIndex_Select_model;
    protected $DocumentIndex_model;
    protected $PdfHashTasks_model;
    protected $efiling_webservices;
    protected $encrypt;
    protected $autoDiaryGeneration;
    public function __construct()
    {
        parent::__construct();
        $this->Common_model = new CommonModel();
        $this->Listing_model = new ListingModel();
        $this->New_case_model = new NewCaseModel();
        $this->Dropdown_list_model = new DropdownListModel();
        $this->Get_details_model = new GetDetailsModel();
        $this->DocumentIndex_Select_model = new DocumentIndexSelectModel();
        $this->DocumentIndex_model = new DocumentIndexModel();
        $this->PdfHashTasks_model = new PdfHashTasksModel();
        $this->efiling_webservices = new Efiling_webservices();
        $this->autoDiaryGeneration = new \App\Controllers\NewCase\AutoDiaryGeneration;
        $this->encrypt = \Config\Services::encrypter();
    }


    public function resend_otp()
    {
        // $text="E-mentioning Diary No. ".$_SESSION['efiling_details']['diary_no']."/".$_SESSION['efiling_details']['diary_year'];
        $text = "Reference No " . $_SESSION['efiling_details']['efiling_no'];
        resend_otp(38, $text);
    }


    public function valid_efil()  // function added on 29.04.2020 for validation for cde 
    {
        $ans = $this->Common_model->valid_cde($_SESSION['efiling_details']['registration_id']);

        $arr_data = explode('-', $ans);
        $status = $arr_data[0];
        $status = (ltrim($status, ','));
        $ct = $arr_data[1];
        $valid_ct = array(5, 6, 7, 8);


        $final_outcome = '';
        if (($ct == $valid_ct[0]) || ($ct == $valid_ct[1]) || ($ct == $valid_ct[2]) || ($ct == $valid_ct[3])) {
            $chk_status = "1,2,3,6";
            $chk_status = "12367";
            //echo $chk_status;
            if (!in_array(1, explode(',', $status))) {
                $final_outcome = 1;
            }
            if (!in_array(2, explode(',', $status))) {
                $final_outcome = $final_outcome . ',' . '2';
            }
            if (!in_array(3, explode(',', $status))) {
                $final_outcome = $final_outcome . ',' . '3';
            }
            if (!in_array(6, explode(',', $status))) {
                $final_outcome = $final_outcome . ',' . '6';
            }
            if (!in_array(8, explode(',', $status))) {
                $final_outcome = $final_outcome . ',' . '8';
            }

        } else {

            if (!in_array(1, explode(',', $status))) {
                $final_outcome = 1;
            }
            if (!in_array(2, explode(',', $status))) {
                $final_outcome = $final_outcome . ',' . '2';
            }
            if (!in_array(3, explode(',', $status))) {
                $final_outcome = $final_outcome . ',' . '3';
            }
            if (!in_array(6, explode(',', $status))) {
                $final_outcome = $final_outcome . ',' . '6';
            }
            if (!in_array(7, explode(',', $status))) {
                $final_outcome = $final_outcome . ',' . '7';
            }
            if (!in_array(8, explode(',', $status))) {
                $final_outcome = $final_outcome . ',' . '8';
            }

        }

        if (!in_array(10, explode(',', $status))) {
            $final_outcome = $final_outcome . ',' . '10';
        }
        if (!in_array(12, explode(',', $status))) {
            $final_outcome = $final_outcome . ',' . '12';
        }
        echo $ct . '?' . $final_outcome;

    }  // end of the function


    public function valid_cde()  // function added on 29.04.2020 for validation for cde 
    {
        $ans = $this->Common_model->valid_cde($_SESSION['efiling_details']['registration_id']);

        $arr_data = explode('-', $ans);
        $status = $arr_data[0];
        $status = (ltrim($status, ','));
        // $status= str_replace(',','',$arr_data[0][0]);
        $ct = $arr_data[1];
        $valid_ct = array(5, 6, 7, 8);


        $final_outcome = '';
        //  $status=($status);
        //  echo count($valid_ct);
        //echo $status;
        if (($ct == $valid_ct[0]) || ($ct == $valid_ct[1]) || ($ct == $valid_ct[2]) || ($ct == $valid_ct[3])) {
            $chk_status = "1,2,3,6";
            $chk_status = "12367";
            //echo $chk_status;
            if (!in_array(1, explode(',', $status))) {
                $final_outcome = 1;

            }
            if (!in_array(2, explode(',', $status))) {
                $final_outcome = $final_outcome . ',' . '2';

            }
            if (!in_array(3, explode(',', $status))) {
                $final_outcome = $final_outcome . ',' . '3';

            }
            if (!in_array(6, explode(',', $status))) {
                $final_outcome = $final_outcome . ',' . '6';

            }

            echo $ct . '?' . $final_outcome;
        } else {


            $chk_status = "12367";
            //echo $chk_status;
            if (!in_array(1, explode(',', $status))) {
                $final_outcome = 1;

            }
            if (!in_array(2, explode(',', $status))) {
                $final_outcome = $final_outcome . ',' . '2';

            }
            if (!in_array(3, explode(',', $status))) {
                $final_outcome = $final_outcome . ',' . '3';

            }
            if (!in_array(6, explode(',', $status))) {
                $final_outcome = $final_outcome . ',' . '6';

            }
            if (!in_array(7, explode(',', $status))) {
                $final_outcome = $final_outcome . ',' . '7';

            }
            echo $ct . "?" . $final_outcome;


        }

    }     // end of function

    public function submitforcde()
    {
        if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_DEFICIT_COURT_FEE && (bool)$_SESSION['estab_details']['enable_payment_gateway']) {
            $next_stage = Transfer_to_IB_Stage;
        } elseif ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
            $next_stage = Draft_Stage;
        } elseif ($_SESSION['efiling_details']['stage_id'] == Draft_Stage) {
            $next_stage = Initial_Approaval_Pending_Stage;
        } elseif ($_SESSION['efiling_details']['stage_id'] == Initial_Defected_Stage) {
            $next_stage = Initial_Defects_Cured_Stage;
        } elseif ($_SESSION['efiling_details']['stage_id'] == DEFICIT_COURT_FEE) {
            $next_stage = DEFICIT_COURT_FEE_PAID;
        } elseif ($_SESSION['efiling_details']['stage_id'] == I_B_Defected_Stage) {
            $next_stage = I_B_Defects_Cured_Stage;
        } elseif ($_SESSION['efiling_details']['stage_id'] == I_B_Rejected_Stage || $_SESSION['efiling_details']['stage_id'] == E_REJECTED_STAGE) {
            $next_stage = Initial_Defects_Cured_Stage;
        } else {
            $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center">Invalid Action.</div>');
            redirect('dashboard');
        }

        //echo "next_st=".$next_stage;
        $qrtext = $_SESSION['qrtext'];
        //$qrtext = $this->input->post('qrcode_text');
        //echo "qrtext is".$qrtext;
        $s = explode('-', $qrtext);
        $registration_id = $s[0];
        $efil_num = $s[1];
        $sc = $s[2];

        $val['reg_id'] = $s[0];
        $val['sc'] = $s[2];


        if (isset($qrtext)) {

            $ans = $this->Common_model->upd_efil_num_sc($registration_id, $sc, $next_stage);


            if ($ans) {
                $sentSMS = "Efiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']) . " has been submitted and is pending for initial approval with efiling admin. - Supreme Court of India";
                log_message('CUSTOM', "Efiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']) . " has been submitted and is pending for initial approval with efiling admin. - Supreme Court of India");
                $subject = "Submitted : Efiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']);
                $user_name = $_SESSION['login']['first_name'] . ' ' . $_SESSION['login']['last_name'];

                send_mobile_sms($_SESSION['login']['mobile_number'], $sentSMS, SCISMS_Initial_Approval);
                send_mail_msg($_SESSION['login']['emailid'], $subject, $sentSMS, $user_name);
                $this->session->setFlashdata('msg', '<div class="alert alert-success text-center"> E-filing number ' . efile_preview($_SESSION['efiling_details']['efiling_no']) . ' submitted successfully for CASE DATA ENTRY .kindly show QR code along at filing counter.</div>');

                redirect('dashboard');
                exit(0);
            } else {
                echo "error";
                // redirect('dashboard');

                $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center">Submition failed. Please try again!</div>');
                log_message('CUSTOM', "Submition failed. Please try again!");
                redirect('dashboard');

                exit(0);
            }


        }


    } // end of code

    function sendotp_cde()
    {
        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT);
        if (!in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users_array)) {
            echo '2@@@' . htmlentities('Unauthorised Access!', ENT_QUOTES);
            exit(0);
        }

        date_default_timezone_set('Asia/Kolkata');
        $time1 = date("H:i");
        $endTime = date("H:i", strtotime('+15 minutes', strtotime($time1)));
        $mobile = $_SESSION['login']['mobile_number']; // query to retreive mobile no of the advocate regitered with efiling
        $num = rand(100000, 999999);

        $smsText = $num . " is one time password for you case submission for CDE for Efiling Reference no" . $_SESSION['efiling_details']['efiling_no'] . " and is valid for 5 minutes. - Supreme Court of India";

        $_SESSION['efiling_details']['registration_id'];
        //exit();
        $otp_details = array(
            'type_id' => 38,
            'mobile' => $mobile,
            'sms_text' => $smsText,
            'updated_on' => date('Y-m-d H:i:s'),
            'updated_by' => $_SESSION['login']['id'],
            'updated_by_ip' => getClientIP(),
            // 'tbl_efiling_num_id'=>313,

            'tbl_efiling_num_id' => $_SESSION['efiling_details']['registration_id'],
            'captcha' => $num,
            'start_time' => date('H:i:s'),
            'end_time' => $endTime,
            'validate_status' => 'A'
        );

        $response = sendSMS(38, $mobile, $smsText, SCISMS_OTP_CDE);  // to be uncommented while deploying

        $db_response = $this->Listing_model->insert_otp($otp_details);


        if (!$db_response) {
            echo "2@@@Some Error ! Please try after some time.";
            return 1;
        } else {
            echo "1@@@OTP Successfully sent and is valid for 5 minutes.";
            return 0;
        }
    }

    function verify_otp()
    {
        $otp = $_POST['s'];
        $otp_validate_response = validate_otp(38, $otp);
        if ($otp_validate_response == false) {
            echo '2@@@';
            echo "Invalid OTP";
            exit(0);
        } else {
            echo '1@@@OTP Verified';

        }
    }

    public function forcde()
    {

        //$this->load->view('newcase/cdeview',$d)
        $a = $_SESSION['efiling_details']['registration_id'];
        /* code to display qr on load of cde view */
        $length = rand(10, 15);
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUWXYZ';
        $str = substr(str_shuffle($characters), 0, 15);
        $out = $a . '-' . $_SESSION['efiling_details']['efiling_no'] . '-' . $str;

        $d['out'] = $out;

        $this->load->view('newcase/cdeview', $d);


    } // end of function 


    public function chk_ifcde($registration_id)
    {
        $chk_cde = $this->Common_model->chkifcde($registration_id);
        // this is the patch for cde or for efiling  , created on 16 april
        //if((strpos($chk_cde,'8') && ($final_submit)))
        if (!strpos($chk_cde, '8')) {

            $efil = 'false';
        } else {
            $efil = 'true';
        }
        return $efil;
    }

    public function index()
    {

        //var_dump($_SESSION);
        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT);

        if (!in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('admindashboard');
            exit(0);
        }

        if (empty($_SESSION['efiling_details']) || empty($_SESSION['estab_details'])) {
            redirect('dashboard');
            exit(0);
        }
        $registration_id = $_SESSION['efiling_details']['registration_id'];

        //Add Final Submit Validations for mark defect cured checkbox
        $marked_defect_tobe_shown_stages = array(I_B_Defected_Stage, I_B_Rejected_Stage);
        if (in_array($_SESSION['efiling_details']['stage_id'], $marked_defect_tobe_shown_stages)) {
            $result_icmis = $this->Common_model->get_cis_defects_remarks($registration_id, FALSE);
            //var_dump($result_icmis);
            if (isset($result_icmis) && !empty($result_icmis)) {
                foreach ($result_icmis as $re) {
                    $aor_cured = (isset($re['aor_cured']) && !empty($re['aor_cured'])) ? $re['aor_cured'] : "f";
                    if ($aor_cured == 'f') {
                        $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center"> Please Mark All Defects Cured Before Final Submit.</div>');
                        return redirect()->to(base_url('documentIndex'));
                        // redirect('documentIndex');exit();
                    }
                }
                isRefilingCompulsoryIADefect($_SESSION['efiling_details']['registration_id'], $_SESSION['efiling_details']['stage_id']);
            }
        }
        ////////////////////////////
        $next_stage = '';
        if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_DEFICIT_COURT_FEE && (bool)$_SESSION['estab_details']['enable_payment_gateway']) {
            $next_stage = Transfer_to_IB_Stage;
        } elseif ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
            $next_stage = Draft_Stage;
        } elseif ($_SESSION['efiling_details']['stage_id'] == Draft_Stage) {
            $next_stage = Initial_Approaval_Pending_Stage;
        } elseif ($_SESSION['efiling_details']['stage_id'] == Initial_Defected_Stage) {
            $next_stage = Initial_Defects_Cured_Stage;
        } elseif ($_SESSION['efiling_details']['stage_id'] == DEFICIT_COURT_FEE) {
            $next_stage = DEFICIT_COURT_FEE_PAID;
        } elseif ($_SESSION['efiling_details']['stage_id'] == I_B_Defected_Stage) {
            $next_stage = I_B_Defects_Cured_Stage;
        } elseif ($_SESSION['efiling_details']['stage_id'] == I_B_Rejected_Stage || $_SESSION['efiling_details']['stage_id'] == E_REJECTED_STAGE) {
            $next_stage = Initial_Defects_Cured_Stage;
        } else {
            $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center">Invalid Action.</div>');
            redirect('dashboard');
        }
        $result = $this->Common_model->updateCaseStatus($registration_id, $next_stage);
        if ($result) {
            if(!empty($_SESSION['efiling_details']['registration_id']))
            {
                //$this->updatecrontableforhashing($registration_id, $_SESSION['efiling_details']['efiling_no']);
                $diary_id = $_SESSION['efiling_details']['diary_no'] . $_SESSION['efiling_details']['diary_year'];
                $efiling_no = $_SESSION['efiling_details']['efiling_no'];

                $this->autoTransferToScrutiny($registration_id,$_SESSION['efiling_details']['diary_no'],$_SESSION['efiling_details']['diary_year'],$_SESSION['efiling_details']['efiling_no']); //comment this line to disable auto scrutiny - kbp 02082023
            }

           // $this->setReturnedByAdvocate($diary_id, $efiling_no);  // go to clerk


            //echo $_SESSION['efiling_details']['efiling_no'];
            $sentSMS = "Efiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']) . " has been submitted and is pending for initial approval with efiling admin. - Supreme Court of India";
            $subject = "Submitted : Efiling no. " . efile_preview($_SESSION['efiling_details']['efiling_no']);
            $user_name = $_SESSION['login']['first_name'] . ' ' . $_SESSION['login']['last_name'];

            send_mobile_sms($_SESSION['login']['mobile_number'], $sentSMS, SCISMS_Initial_Approval);
            send_mail_msg($_SESSION['login']['emailid'], $subject, $sentSMS, $user_name);

            //$this->session->set_flashdata("hekki");

            $this->session->setFlashdata('msg', '<div class="alert alert-success text-center"> E-filing number ' . efile_preview($_SESSION['efiling_details']['efiling_no']) . ' submitted successfully for approval of E-filing Admin.!</div>');
            //echo "querFy";
            $_SESSION['efiling_details']['stage_id'] = Initial_Approaval_Pending_Stage;
            redirect('newcase/view');
            //redirect('dashboard');
            exit(0);
        } else {
            echo "error";

            $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center">Submition failed. Please try again!</div>');
            redirect('dashboard');
            exit(0);
        }
        // }   //
    }


    function updatecrontableforhashing($registration_id, $efiling_no)
    {
        $max_submit_count = $this->PdfHashTasks_model->get_max_submit_count($efiling_no);
        $current_submit_count = $max_submit_count+1;
        $result = $this->DocumentIndex_Select_model->get_index_items_list($registration_id);
        foreach ($result as $res) {
            $registration_id = $res['registration_id'];
            $pspdfkit_document_id = $res['pspdfkit_document_id'];
            $title = $res['doc_title'];
            $pspdfkit_document = copyDocument($pspdfkit_document_id);
            $copied_pspdfkit_document_id = $pspdfkit_document['document_id'];
            $issaved = $this->PdfHashTasks_model->save_pdf_hash_task($registration_id, $efiling_no, $copied_pspdfkit_document_id, $pspdfkit_document_id, $current_submit_count, $title);
            if($issaved){
                $this->DocumentIndex_model->setDuplicatePSPdfKitDocument($registration_id, $pspdfkit_document_id, $copied_pspdfkit_document_id);
            }
        }
    }
    function setReturnedByAdvocate($diary_id, $efiling_no)
    {
        $assoc_arr = array('diary_id' => $diary_id, 'efiling_no' => $efiling_no);
        $assoc_json = json_encode($assoc_arr);
        // $key = $this->config->item('encryption_key');
        $key = config('Encryption')->key;
        $encrypted_string = $this->encrypt->encrypt($assoc_json, $key);
        $this->efiling_webservices->setReturnedByAdvocate($encrypted_string);
    }

    // Auto Transfer to scrutiny changes : start
    public function autoTransferToScrutiny($registration_id=null,$diary_no=null,$diary_year=null,$efiling_no=null)
    {
        //echo $registration_id.'#'.$diary_no.'#'.$diary_year.'#'.$efiling_no;exit();
        if(empty($registration_id))
        {
            return NULL;
        }
        else{
            //echo ADMIN_SERVER_URL.'newcase/AutoDiaryGeneration/updateRefiledCase'.$registration_id;exit();
            // $curl = curl_init();
            // curl_setopt_array($curl, array(
            //     CURLOPT_URL => ADMIN_SERVER_URL.'newcase/AutoDiaryGeneration/updateRefiledCase',
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => '',
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => 'POST',
            //     CURLOPT_POSTFIELDS => array('registration_id' => $registration_id,'diary_no'=>$diary_no,'diary_year'=>$diary_year,'efiling_no'=>$efiling_no),
            //     CURLOPT_HTTPHEADER => array(
            //       'Cookie: ci_session_efiling=c7508392f41ce91fc65fb33f9054a43d4446fcb4'
            //     ),
            // ));
            // $response = curl_exec($curl);
            // curl_close($curl);
            // $response = (array)json_decode($response,true);
            $autoGeneratedNo = $this->autoDiaryGeneration->updateRefiledCaseRefile($registration_id,$diary_no,$diary_year,$efiling_no); //function written for Auto diarization in the last week
            // if(isset($response) && !empty($response) && $response['status'] == 'success')
            if(isset($autoGeneratedNo) && !empty($autoGeneratedNo) && $autoGeneratedNo['status'] == 'success')
            {
                $this->session->setFlashdata('msg', ' E-filing number ' . $efiling_no. ' has been re-filed successfully.');
                $_SESSION['efiling_details']['stage_id'] = Initial_Approaval_Pending_Stage;
            }
            else
            {
                $this->session->setFlashdata('msg', $autoGeneratedNo['message']);

            }
            redirect('newcase/view');
        }
    }
    // Auto Transfer to scrutiny changes: end
}