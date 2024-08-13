<?php

namespace App\Controllers\Register;
use App\Controllers\BaseController;
use App\Models\Register\RegisterModel;
use App\Libraries\webservices\Efiling_webservices;
use App\Libraries\Slice;
// if (!defined('BASEPATH')) exit('No direct script access allowed');

class DefaultController extends BaseController {
    protected $Register_model;
    protected $slice;
    protected $form_validation;
    protected $session;

    public function __construct() {
        parent::__construct();
        // $this->load->model('register/Register_model');
        // $this->load->library('webservices/efiling_webservices');
        // $this->load->library('slice');
        require_once APPPATH . 'ThirdParty/eSign/XMLSecEnc.php';
        require_once APPPATH . 'ThirdParty/eSign/XMLSecurityDSig.php';
        require_once APPPATH . 'ThirdParty/eSign/XMLSecurityKey.php';
        $this->Register_model = new RegisterModel();
        $this->slice = new Slice();
        $this->efiling_webservices = new Efiling_webservices();
        $this->session = \Config\Services::session();
        helper(['form']);
    }

    public function index() {
        
        unset($_SESSION['kyc_configData']);
        unset($_SESSION['adv_details']);
        unset($_SESSION['register_data']);
        /* $captcha_value = captcha_generate();
         $data['captcha']['image'] = $captcha_value['image'];
         $data['captcha']['word'] = $captcha_value['word'];*/
        $this->render('responsive_variant.authentication.register_view');
    }
    /*    function check_and_save_zip_file_temporary()
        {
            $filename = $_FILES['ekyc_zip_file']['name'];
            $source = $_FILES['ekyc_zip_file']['tmp_name'];
            $type = $_FILES['ekyc_zip_file']['type'];
            $name = explode('.', $filename);
            $target = 'uploaded_docs/ekyc/temp/';
            $accepted_types = array('application/zip','application/x-zip-compressed','multipart/x-zip','application/s-compressed');
            foreach($accepted_types as $mime_type) {
                if($mime_type == $type) {
                    $okay = true;
                    break;
                }
            }
            //Safari and Chrome don't register zip mime types. Something better could be used here.
            $okay = strtolower($name[1]) == 'zip' ? true: false;
            if(!$okay) {
                die("Please choose a zip file!!");
            }
            mkdir($target);
            $saved_file_location = $target . $filename;
            if(!(move_uploaded_file($source, $saved_file_location))) {
                die("There was a problem. Sorry!");
            }
            return $saved_file_location;
        }*/
    function inspect_files_within_zip($file_path=null)
    {
        if(!empty($file_path))
        {
            $allowable_file_formats=json_decode(OFFLINE_ADHAAR_EKYC_ZIP_ALLOWABLE_FILE_FORMAT);
            $zip = new \ZipArchive();
            $zip->open($file_path);
            $is_valid_file='';
            for( $i = 0; $i < $zip->numFiles; $i++ ){
                $filename = $zip->getNameIndex($i);
                //echo $filename.'<br>';
                $imageExtention = pathinfo($filename, PATHINFO_EXTENSION);
                if(in_array($imageExtention, $allowable_file_formats))
                {
                    $is_valid_file=true;
                    continue;
                }
                else{
                    $is_valid_file=false;
                    break;
                }
            }
            $zip->close();
        }
        return $is_valid_file;
    }
    /* function inspect_files_within_zip($fileName)
    {

        $allowable_file_formats=json_decode(OFFLINE_ADHAAR_EKYC_ZIP_ALLOWABLE_FILE_FORMAT);
        $zip = new \ZipArchive();
        $zip->open("assets/ekyc/" . $fileName);
        $is_valid_file='';
        for( $i = 0; $i < $zip->numFiles; $i++ ){

            $filename = $zip->getNameIndex($i);

            $imageExtention = pathinfo($filename, PATHINFO_EXTENSION);
            if(in_array($imageExtention, $allowable_file_formats))
            {
                $is_valid_file=true;
                continue;
            }
            else{
                $is_valid_file=false;
                break;
            }
        }
        $zip->close();
        return $is_valid_file;
    } */

    function adv_get_otp() {
        $mobile_exist = array();
        $email_exist = array();
        $_SESSION['register_type_select'] = $_POST['adv_type_select'];
        $_SESSION['session_not_register_type_user'] = $_POST['not_register_type_user'];
        // $sess_reg_data = array(
        //     'register_type_select' => integerDecreption($_POST['adv_type_select']),
        //     'session_not_register_type_user' => stringDecreption($_POST['not_register_type_user'])
        // );
        // setSessionData('reg_details', $sess_reg_data);
        if (empty($_POST['userCaptcha'])) {
            $this->session->setFlashdata('msg', '<div class="uk-alert-danger" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Captcha is required!</p> </div>');
            return redirect()->to(base_url('register'));
            exit(0);
        }
        // $this->form_validation->set_rules('userCaptcha', 'Captcha', 'required|trim|is_required');
        // $this->form_validation->set_rules('adv_mobile', 'Mobile', 'required|numeric|trim|is_required|min_length[10]|max_length[10]');
        // $this->form_validation->set_rules('adv_email', 'Email', 'required|valid_email|trim|is_required');
        // $this->form_validation->set_error_delimiters('<div class="uk-alert-danger">', '</div>');
        // if ($this->form_validation->run() === FALSE) {
        //     /*$captcha_value = captcha_generate();
        //     $data['captcha']['image'] = $captcha_value['image'];
        //     $data['captcha']['word'] = $captcha_value['word'];*/
        //     $this->slice->view('responsive_variant.authentication.register_view');
        // } else {
        $validation =  \Config\Services::validation();
        //---Commented line are used for disable captcha----------------->
        $rules=[
            "adv_mobile" => [
                "label" => "Advocate Mobile",
                "rules" => "required|trim|numeric|min_length[10]|max_length[10]"
            ],
            "adv_email" => [
                "label" => "Advocate Email",
                "rules" => "required|trim|valid_email"
            ],
            "userCaptcha" => [
                "label" => "Captcha",
                "rules" => "required|trim"
            ],
        ];
        if ($this->validate($rules) === FALSE) {
            $data = [
                'validation' => $this->validator,
                'currentPath' => $this->slice->getSegment(1) ?? 'public',
            ];
            $this->session->set('login_salt', $this->generateRandomString());
            return $this->render('responsive_variant.authentication.register_view', $data);
        } else {
            if ($_SESSION["captcha"] !=$_POST['userCaptcha']) {
                $this->session->setFlashdata('msg', '<div class="uk-alert-danger" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Invalid Captcha!</p> </div>');
                return redirect()->to(base_url('register'));
                exit(0);
            }
            if (isset($_POST['adv_mobile']) && !empty($_POST['adv_mobile']) || isset($_POST['adv_email']) && !empty($_POST['adv_email'])) {
                $mobile_already_exist = $this->Register_model->check_already_reg_mobile($_POST['adv_mobile']);
                $email_already_exist = $this->Register_model->check_already_reg_email($_POST['adv_email']);
                //$mobile_already_bar = $this->Register_model->check_already_reg_mobile_bar($_POST['adv_mobile']);
                //$email_already_bar = $this->Register_model->check_already_reg_email_bar($_POST['adv_email']);
                if ($_POST['register_type'] == 'Party In Person') {
                    if (!empty($mobile_already_exist)) {
                        if ($mobile_already_exist[0]['moblie_number'] == $_POST['adv_mobile']) {
                            $this->session->setFlashdata('msg', '<div class="uk-alert-danger flashmessage" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Mobile Number Already Registerd! Please click on forgot password and reset your password!</p> </div>');
                            return redirect()->to(base_url('register'));
                        } elseif ($email_already_exist[0]['emailid'] == $_POST['adv_email']) {
                            $this->session->setFlashdata('msg', '<div class="uk-alert-danger flashmessage" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Email ID Already Registerd! Please click on forgot password and reset your password!</p> </div>');
                            return redirect()->to(base_url('register'));
                        }
                    }
                } else if ($_POST['register_type'] == 'Advocate On Record') {
                    if ($mobile_already_exist[0]['moblie_number'] == $_POST['adv_mobile']) {
                        $this->session->setFlashdata('msg', '<div class="uk-alert-danger flashmessage" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Mobile Number Already Registerd! Please click on forgot password and reset your password!</p> </div>');
                        return redirect()->to(base_url('register/AdvocateOnRecord'));
                    }
                    if ($email_already_exist[0]['emailid'] == $_POST['adv_email']) {
                        $this->session->setFlashdata('msg', '<div class="uk-alert-danger flashmessage" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Email ID Already Registerd! Please click on forgot password and reset your password!</p> </div>');
                        return redirect()->to(base_url('register/AdvocateOnRecord'));
                    }
                    $advDetailsIcmis=$this->efiling_webservices->getBarTable($_POST['adv_mobile'],$_POST['adv_email']);
                    if ($advDetailsIcmis[0]->moblie_number != $_POST['adv_mobile'] || $advDetailsIcmis[0]->emailid != $_POST['adv_email']) {
                        $this->session->setFlashdata('msg', '<div class="uk-alert-danger flashmessage" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Mobile Number And Email ID Not Valid for Bar! Please Contact SCI !</p> </div>');
                        return redirect()->to(base_url('register/AdvocateOnRecord'));
                    }
                }
                if (!empty($_FILES["ekyc_zip_file"]['name'])) {
                    $is_valid_files='';
                    $uploaded_file_size=$_FILES["ekyc_zip_file"]['size'];
                    if($uploaded_file_size > OFFLINE_AADHAAR_EKYC_ZIP_ALLOWABLE_FILE_SIZE) // allow  upto 50 kb size
                    {
                        $this->session->setFlashdata('msg', '<div class="uk-alert-danger" uk-alert> <a class="uk-alert-close" uk-close></a> <p style="text-align: center;">File size are beyond allowable limit.</p> </div>');
                        return redirect()->to(base_url('register'));
                    } else {
                        //$is_valid_files=$this->inspect_files_within_zip($_FILES["ekyc_zip_file"]['name']);
                        $is_valid_files=true;
                    }
                    //$DIR = 'assets/ekyc/dir';
                    //$config['upload_path'] = 'assets/ekyc/';
                    $DIR = 'uploaded_docs/ekyc/dir';
                    $config['upload_path'] = 'uploaded_docs/ekyc/';
                    $config['allowed_types'] = array('zip','application/x-zip','application/x-zip-compressed','application/zip');
                    $config['max_size'] = OFFLINE_AADHAAR_EKYC_ZIP_ALLOWABLE_FILE_SIZE; // max_size in kb (50 KB)
                    $config['file_name'] = $_FILES["ekyc_zip_file"]['name'];
                    $config['overwrite'] = TRUE;
                    // Load upload library
                    $imageExtention = pathinfo($_FILES["ekyc_zip_file"]["name"], PATHINFO_EXTENSION);
                    $this->load->library('upload', $config);
                    //only ZIP file allowed
                    if($imageExtention=='zip'){
                        // File upload
                        if ($this->upload->do_upload('ekyc_zip_file')) {
                            $file_path=$config['upload_path'].$_FILES["ekyc_zip_file"]['name'];
                            $is_valid_files = $this->inspect_files_within_zip($file_path);
                            if (!empty($is_valid_files))
                            {
                                // Get data about the file
                                $uploadData = $this->upload->data();
                                $filename = $uploadData['file_name'];
                                ## Extract the zip file ---- start
                                $_SESSION['filename'] = str_replace('.zip', '', $filename);
                                $zip = new ZipArchive;
                                //$res = $zip->open("assets/ekyc/" . $filename);
                                $res = $zip->open("uploaded_docs/ekyc/" . $filename);
                                $_SESSION['uploaded_file_name'] = $filename;
                                if ($res === TRUE) {
                                    $DIR2 = $DIR . '/' . $_SESSION['filename'] . '.xml';
                                    if ($zip->setPassword($_POST['share_code'])) {
                                        if (!$zip->extractTo($DIR)) {
                                            $this->session->setFlashdata('msg', '<div class="uk-alert-danger" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Extraction failed (wrong password?)</p> </div>');
                                            return redirect()->to(base_url('register'));
                                        }
                                    }
                                    $zip->close();
                                    $xml = simplexml_load_file($DIR2);
                                    $json = json_encode($xml);
                                    $data_config = json_decode($json, true);
                                    $_SESSION['kyc_configData'] = $data_config;
                                    $data['configData'] = $_SESSION['kyc_configData'];
                                    $data['mobile_addhar'] = $_POST['mobile'];
                                    $data['email_addhar'] = $_POST['emailid'];
                                    $this->load->library('encryption');
                                    //Check if mobile & email matched with aadhar data dated 29-12-2020
                                    $reference_id = $data_config['@attributes']['referenceId'];
                                    $get_adhar_last_digit = substr(substr($reference_id, 0 , 4),-1);
                                    if($get_adhar_last_digit == 0){
                                        $get_adhar_last_digit = 1;
                                    }
                                    $share_code = $_POST['share_code'];
                                    $mobile_sha256_hash = $_POST['adv_mobile'].$share_code;
                                    $email_sha256_hash = $_POST['adv_email'].$share_code;
                                    for($i=1;$i<=$get_adhar_last_digit;$i++){
                                        $mobile_sha256_hash = hash('sha256', $mobile_sha256_hash);
                                        $email_sha256_hash = hash('sha256', $email_sha256_hash);
                                    }
                                    $Poi = $data_config['UidData']['Poi']['@attributes'];
                                    //if($mobile_sha256_hash != $Poi['m'] || $email_sha256_hash != $Poi['e']){
                                    if($mobile_sha256_hash != $Poi['m']){
                                        $this->session->setFlashdata('msg', '<div class="uk-alert-danger" uk-alert> <a class="uk-alert-close" uk-close></a> <p style="text-align: center;">Mobile should be same as registered with Aadhar! </p> </div>');
                                        return redirect()->to(base_url('register'));
                                    } else {
                                        $responseString = file_get_contents($DIR2);
                                        $signature_match = $this->offlineKycResponse($responseString);
                                        if($signature_match != 'Signature validated') {
                                            $this->session->setFlashdata('msg', '<div class="uk-alert-danger" uk-alert> <a class="uk-alert-close" uk-close></a> <p style="text-align: center;">Aadhar file tampered, please try with fresh offline aadhar! </p> </div>');
                                            return redirect()->to(base_url('register'));
                                        }
                                    }
                                    $aadhar_no = $data['configData']['@attributes']['referenceId'];
                                    $aadhar_last_disit_no = substr($aadhar_no, -18, -17);
                                    $this->load->library('encryption');
                                    $share_code = '8976';
                                    $mob = "9582551896";
                                    $l_digit = "3";
                                    $this->session->setFlashdata('msg', '<div class="uk-alert-success" uk-alert> <a class="uk-alert-close" uk-close></a> <p style="text-align: center;">Upload & Extract successfully.</p> </div>');
                                } else {
                                    $this->session->setFlashdata('msg', '<div class="uk-alert-danger" uk-alert> <a class="uk-alert-close" uk-close></a> <p style="text-align: center;">Failed to extract.</p> </div>');
                                    return redirect()->to(base_url('register'));
                                }
                            } else {
                                unlink($file_path);
                                $this->session->setFlashdata('msg', '<div class="uk-alert-danger" uk-alert> <a class="uk-alert-close" uk-close></a> <p style="text-align: center;">Pls. upload the original offline Aadhaar eKYC Zip file.</p> </div>');
                                return redirect()->to(base_url('register'));
                            }
                        } else {
                            $this->session->setFlashdata('msg', '<div class="uk-alert-danger" uk-alert> <a class="uk-alert-close" uk-close></a> <p style="text-align: center;">Failed to upload (only zip file upload allowed). Some problem</p> </div>');
                            return redirect()->to(base_url('register'));
                        }
                    } else {
                        $this->session->setFlashdata('msg', '<div class="uk-alert-danger" uk-alert> <a class="uk-alert-close" uk-close></a> <p style="text-align: center;">Only zip file upload allowed.</p> </div>');
                        return redirect()->to(base_url('register'));
                    }
                }
                if(!empty($_POST['adv_mobile']))
                    $first_name = (!empty($mobile_exist)) ? $mobile_exist[0]['first_name'] : 'Abc';
                    $last_name = (!empty($mobile_exist)) ? $mobile_exist[0]['last_name'] : 'Xyz';
                    $name_array = array('first_name'=> $first_name, 'last_name'=> $last_name);
                if(!empty($_POST['adv_email']))
                    $first_name = (!empty($email_exist)) ? $email_exist[0]['first_name'] : 'Abc';
                    $last_name = (!empty($email_exist)) ? $email_exist[0]['last_name'] : 'Xyz';
                    $name_array = array('first_name'=> $first_name, 'last_name'=> $last_name);
                $mobile_otp_is = $this->generateNumericOTP();
                $email_otp_is = $this->generateNumericOTP();
                /* $_SESSION['adv_details'] = array(
                    'mobile_no' => $_POST['adv_mobile'],
                    'mobile_otp' => $mobile_otp_is,
                    'email_id' => $_POST['adv_email'],
                    'email_otp' => $email_otp_is,
                    'register_type' => $_POST['register_type']);*/
                /* Code Added on 13-03-2023 by Amit Tripathi for OTP expiration */
                date_default_timezone_set('Asia/Kolkata');
                $startTime=date("H:i");
                $endTime = date("H:i", strtotime('+15 minutes', strtotime($startTime)));
                $sess_data =  array_merge(array(
                    'mobile_no' => $_POST['adv_mobile'],
                    'mobile_otp' => $mobile_otp_is,
                    'email_id' => $_POST['adv_email'],
                    'email_otp' => $email_otp_is,
                    'register_type' => $_POST['register_type'],
                    'start_time' => $startTime,
                    'end_time' => $endTime), $name_array);
                setSessionData('adv_details', $sess_data);
                /* END */
                /*$_SESSION['adv_details'] =  array_merge(array(
                    'mobile_no'=>$_POST['adv_mobile'],
                    'mobile_otp'=>$mobile_otp_is,
                    'email_id'=>$_POST['adv_email'],
                    'email_otp'=>$email_otp_is,
                    'register_type'=>$_POST['register_type'],), $name_array);*/
                if(!empty($_POST['adv_mobile'])){
                    $typeId="38";
                    $mobileNo=trim($_POST['adv_mobile']);
                    $smsText="OTP for Registration SC-EFM password is: ".$mobile_otp_is." ,Please do not share it with any one. - Supreme Court of India";
                    sendSMS($typeId,$mobileNo,$smsText,SCISMS_Registration_OTP);
                }
                if(!empty($_POST['adv_email'])){
                    $to_email=trim($_POST['adv_email']);
                    $subject="SC-EFM Registration password OTP";
                    $message="OTP for Registration SC-EFM password is: ".$email_otp_is." ,Please do not share it with any one.";
                    send_mail_msg($to_email, $subject, $message);
                    // relay_mail_api($to_email, $subject, $message);
                    // var_dump($test);exit;
                }
                return redirect()->to(base_url('register/AdvOtp'));
            } else {
                $this->session->setFlashdata('login_salt', $this->generateRandomString());
                return $this->render('responsive_variant.authentication.register_view');
            }
        }
    }

    function offlineKycResponse($responseXML)
    {
        $doc = new DOMDocument('1.0', 'utf-8');
//foreach ($arTests AS $testName=>$testFile) {
        $doc->encoding = 'utf-8';
        $doc->formatOutput = false;
        $doc->preserveWhiteSpace = true;
        $doc->loadXML($responseXML);

        //$doc->load("$responseXML");


        $objXMLSecDSig = new XMLSecurityDSig();

        $objDSig = $objXMLSecDSig->locateSignature($doc);

        if (! $objDSig) {
            throw new Exception("Cannot locate Signature Node");
        }

        $objXMLSecDSig->canonicalizeSignedInfo();
        $objXMLSecDSig->idKeys = array('wsu:Id');
        $objXMLSecDSig->idNS = array('wsu'=>'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd');


        $retVal = $objXMLSecDSig->validateReference();

        if (! $retVal) {
            throw new Exception("Reference Validation Failed");
        }
        $objKey = $objXMLSecDSig->locateKey();
        if (! $objKey ) {
            throw new Exception("We have no idea about the key");
        }
        $key = NULL;

        $objKeyInfo = XMLSecEnc::staticLocateKeyInfo($objKey, $objDSig);

        if (! $objKeyInfo->key && empty($key)) {
            $address_pem=base_url()."assets/ekyc/adhar_offline_kyc_public_key.pem";
            //$address_pem = $_SERVER['DOCUMENT_ROOT']."/bharatkosh/adhar_offline_kyc_public_key.pem";
            //$address_pem = "adhar_offline_kyc_public_key.pem";
            //$address_pem = "http://10.25.78.29/bharatkosh/adhar_offline_kyc_public_key.pem";
            $objKey->loadKey($address_pem, TRUE);
        }
//var_dump($objXMLSecDSig);
        //print $testName.": ";
        if ($objXMLSecDSig->verify($objKey) === 1) {
            return "Signature validated";
        } else {
            return "Failure";
        }
    }

    function generateNumericOTP($n = 6) {
        $generator = "1357902468";
        $result = "";
        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }
        return $result;
    }

    private function generateRandomString($length = 10) {

        // generates random string for login salt

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}

?>

