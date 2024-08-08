<?php

namespace App\Controllers\Register;
use App\Controllers\BaseController;
use App\Models\Register\RegisterModel;
use App\Libraries\Slice;
use App\Libraries\webservices\Efiling_webservices;

class ForgetPasswordController extends BaseController
{
    protected $Register_model;
    protected $slice;
    protected $efiling_webservices;

	public function __construct() {
        parent::__construct();       
        $this->Register_model = new RegisterModel();
        $this->slice = new Slice();
        $this->session = \Config\Services::session();
        $this->efiling_webservices = new Efiling_webservices();
        // $this->load->library('slice');
    }

    public function index() {
        return $this->render('responsive_variant.authentication.forget_password_view');
    }

    function adv_get_otp_old()
    {      
        if (empty($_POST['userCaptcha'])) {
            $this->session->setFlashdata('msg', 'Captcha is required!');
            redirect('register/ForgetPassword');
            exit(0);
        }
        // $this->form_validation->set_rules('userCaptcha', 'Captcha', 'required|trim|is_required');
    	// $this->form_validation->set_rules('adv_mobile', 'Mobile', 'numeric|trim|is_required|min_length[10]|max_length[10]');
    	// $this->form_validation->set_rules('adv_email', 'Email', 'valid_email|trim|is_required');
        // // $this->form_validation->set_rules('userCaptcha', 'Captcha', 'required|trim|is_required');
        // $this->form_validation->set_error_delimiters('<div class="uk-alert-danger">', '</div>');
        $rules = [
            "adv_email" => [
                "label" => "Email",
                "rules" => "valid_email|trim|is_required"
            ],
            "adv_mobile" => [
                "label" => "Mobile",
                "rules" => "numeric|trim|is_required|min_length[10]|max_length[10]"
            ],
            "userCaptcha" => [
                "label" => "Captcha",
                "rules" => "required|trim|is_required"
            ],
        ];
        if(empty($_POST['adv_mobile']) && empty($_POST['adv_email']) ){
            $this->session->setFlashdata('msg', 'Please Enter Mobile or Email!');
			redirect('register/ForgetPassword');
		}
        if ($this->validate($rules) === FALSE) {
            $data = [
                'validation' => $this->validator,
            ];
            return $this->render('responsive_variant.authentication.forget_password_view');
        } else {
            if (getSessionData("captcha") != $_POST['userCaptcha']) {
                $this->session->setFlashdata('msg', 'Invalid Captcha!');
                redirect('register/ForgetPassword');
                exit(0);
            }
        	if(isset($_POST['adv_mobile']) && !empty($_POST['adv_mobile']) || isset($_POST['adv_email']) && !empty($_POST['adv_email'])){				 
                $mobile_exist = $this->Register_model->check_already_reg_mobile($_POST['adv_mobile']);
                $email_exist = $this->Register_model->check_already_reg_email(strtoupper($_POST['adv_email']));                
                if($mobile_exist[0]['moblie_number'] != $_POST['adv_mobile']) {
                    $this->session->setFlashdata('msg', 'Not Registerd This Mobile Number!');
                    redirect('register/ForgetPassword');
                } else if(strtoupper($email_exist[0]['emailid']) != strtoupper($_POST['adv_email'])) {
                    $this->session->setFlashdata('msg', 'Not Registerd This Email ID!');
                    redirect('register/ForgetPassword');
                } else {
                    if(!empty($_POST['adv_mobile']))
                        $name_array = array('first_name'=>$mobile_exist[0]['first_name'], 'last_name'=>$mobile_exist[0]['last_name']);
                    if(!empty($_POST['adv_email']))
                        $name_array = array('first_name'=>$email_exist[0]['first_name'], 'last_name'=>$email_exist[0]['last_name']);
                    $mobile_otp_is = $this->generateNumericOTP();
    				$email_otp_is = $this->generateNumericOTP();
                    date_default_timezone_set('Asia/Kolkata');
                    $startTime=date("H:i");
                    $endTime = date("H:i", strtotime('+15 minutes', strtotime($startTime)));
            		$_SESSION['adv_details'] =  array_merge(array('mobile_no'=>$_POST['adv_mobile'],
            		'mobile_otp'=>$mobile_otp_is,
            		'email_id'=>$_POST['adv_email'],
            		'email_otp'=>$email_otp_is,
            		'register_type'=>$_POST['register_type'],
                    'start_time'=>$startTime,
                    'end_time'=>$endTime), $name_array);
            		if(!empty($_POST['adv_mobile'])){
                        $typeId="38";
                        $mobileNo=trim($_POST['adv_mobile']);
                        $smsText="OTP for changing SC-EFM password is: ".$mobile_otp_is." ,Please do not share it with any one. - Supreme Court of India";
                        sendSMS($typeId,$mobileNo,$smsText,SCISMS_Change_Password_OTP);
                    } else if(!empty($_POST['adv_email'])){
                        $to_email=trim($_POST['adv_email']);
                        $subject="SC-EFM forget password OTP";
                        $message="OTP for changing SC-EFM password is: ".$email_otp_is." ,Please do not share it with any one.";
                        send_mail_msg($to_email, $subject, $message);
                        //relay_mail_api($to_email, $subject, $message);
                    }
    				redirect('register/AdvOtp'); 
                }
			}
        }
    }

    public function adv_get_otp()
    {
        helper(['form', 'url']);    
        // Check if captcha is empty
        if (empty($this->request->getPost('userCaptcha'))) {
            $this->session->setFlashdata('msg', 'Captcha is required!');    
            return redirect()->to(base_url('Register/ForgetPassword'));
        }
        $rules = [
            "adv_email" => [
                "label" => "Email",
                "rules" => "valid_email"
            ],
            "adv_mobile" => [
                "label" => "Mobile",
                "rules" => "numeric|trim|min_length[10]|max_length[10]"
            ],
            "userCaptcha" => [
                "label" => "Captcha",
                "rules" => "required|trim"
            ],
        ];
        if ($this->validate($rules) === FALSE) {
            $data = [
                'validation' => $this->validator,
            ];
            return $this->render('responsive_variant.authentication.forget_password_view', $data);
        }    
        // Get input data
        $adv_mobile = $this->request->getPost('adv_mobile');
        $adv_email = $this->request->getPost('adv_email');    
        // Check if either mobile or email is empty
        if (empty($adv_mobile) && empty($adv_email)) {
            $this->session->setFlashdata('msg', 'Please Enter Mobile or Email!');    
            return redirect()->to(base_url('Register/ForgetPassword'));
        }    
        // Check captcha validity
        if (getSessionData("captcha") != $this->request->getPost('userCaptcha')) {
            $this->session->setFlashdata('msg', 'Invalid Captcha!');    
            return redirect()->to(base_url('Register/ForgetPassword'));
        }    
        // Check if mobile and email exist
        $mobile_exist = $this->Register_model->check_already_reg_mobile($adv_mobile);
        $email_exist = $this->Register_model->check_already_reg_email(strtoupper($adv_email));    
        if (!$mobile_exist || !$email_exist) {
            $this->session->setFlashdata('msg', 'Not Registered With This Mobile Number or Email ID!');    
            return redirect()->to(base_url('Register/ForgetPassword'));
        }    
        // Set name array based on input
        $name_array = [];
        if (!empty($adv_mobile)) {
            $name_array = ['first_name' => $mobile_exist[0]['first_name'], 'last_name' => $mobile_exist[0]['last_name']];
        } elseif (!empty($adv_email)) {
            $name_array = ['first_name' => $email_exist[0]['first_name'], 'last_name' => $email_exist[0]['last_name']];
        }    
        // Generate OTPs and set session data
        //$mobile_otp_is = $this->generateNumericOTP();
        //$email_otp_is = $this->generateNumericOTP();
        $mobile_otp_is ='123456';
        $email_otp_is ='123456';    
        date_default_timezone_set('Asia/Kolkata');
        $startTime = date("H:i");
        $endTime = date("H:i", strtotime('+15 minutes', strtotime($startTime)));    
        $_SESSION['adv_details'] = array_merge([
            'mobile_no' => $adv_mobile,
            'mobile_otp' => $mobile_otp_is,
            'email_id' => $adv_email,
            'email_otp' => $email_otp_is,
            'register_type' => $this->request->getPost('register_type'),
            'start_time' => $startTime,
            'end_time' => $endTime
        ], $name_array);    
        // Send OTP via SMS or email
        if (!empty($adv_mobile)) {
            // Send SMS
        } elseif (!empty($adv_email)) {
            // Send email
        }    
        return redirect()->to(base_url('Register/AdvOtp'));
    }
    
    public function AdvOtp()
    {
        $session = session();        
        if ($session->get('adv_details')['register_type'] != 'Forget Password') {
            if (empty($session->get('adv_details')['mobile_no']) || empty($session->get('adv_details')['email_id'])) {               
               return redirect()->to(base_url('Register/ForgetPassword'));
            }
        }
        $session->remove('profile_image');        
        return $this->render('responsive_variant.authentication.adv_otp_view');
    }
   
    public function verify()
    {
        $request = \Config\Services::request();
        //pr($request);       
        $session = session();
        if (!$session->has('adv_details')) {
            return redirect()->to('Register');
        }
        $registerType = $session->get('adv_details')['register_type'];      
        $currentTime = date("H:i");
        $validationRules = [
            'adv_mobile_otp' => 'required|numeric|trim|min_length[6]|max_length[6]',
            'adv_email_otp' => 'required|numeric|trim|min_length[6]|max_length[6]',
        ];
        if ($registerType == 'Forget Password') {
            $validationRules['adv_mobile_otp'] = 'numeric|trim|min_length[6]|max_length[6]';
            $this->session->setFlashdata('msg', 'Mobile OTP And Email OTP Required');
        }       
        if (!$this->validate($validationRules)) {           
            $captcha_value = captcha_generate();
            $data['captcha']['image'] = $captcha_value['image'];
            $data['captcha']['word'] = $captcha_value['word'];           
            return $this->render('responsive_variant.authentication.adv_otp_view',$data);
        } else {            
            // Check OTP expiration and verification
            if ($registerType != 'Forget Password') {              
                $mobile_status = $this->verifyOTP($currentTime, 'adv_mobile_otp', 'mobile_otp');
                $email_status = $this->verifyOTP($currentTime, 'adv_email_otp', 'email_otp');
            } else {
                $mobile_status = $this->verifyOTP($currentTime, 'adv_mobile_otp', 'mobile_otp');
                $email_status = $this->verifyOTP($currentTime, 'adv_email_otp', 'email_otp');
            }
            $session->set('verify_details', ['mobile_verified' => $mobile_status, 'email_verified' => $email_status]);
            if ($mobile_status == 'done' && $email_status == 'done') {
                if ($registerType == 'Advocate') {               
                    $session->set('self_register_arguing_counsel', true);                    
                    return redirect()->to(base_url('saveArguingCounselCompleteDetails'));
                } else {                   
                    $session->set('self_register_arguing_counsel', false);
                    return redirect()->to(base_url('Register/AdvSignUp'));
                }
            } else {
                // $captcha_value = captcha_generate_test();
                // $data['captcha']['image'] = $captcha_value['image'];
                // $data['captcha']['word'] = $captcha_value['word'];               
                $this->session->setFlashdata('msg', 'OTP Verification Failed');                
                return $this->render('responsive_variant.authentication.adv_otp_view');
            }
        }
    }

    private function verifyOTP($currentTime, $postOtpKey, $sessionOtpKey)
    {
        if (isset(getSessionData('adv_details')[$sessionOtpKey]) && getSessionData('adv_details')[$sessionOtpKey] == $this->request->getPost($postOtpKey)) {
            if ($currentTime <= strtotime(getSessionData('adv_details')['end_time'])) {
                return true;
            }
        }
        return false;
    }
    
    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    function generateNumericOTP($n = 6) {
        $generator = "1357902468";
        $result = "";
        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }
        return $result;
    }    

	function update_password(){
		$captcha_value = captcha_generate();
        $data['captcha']['image'] = $captcha_value['image'];
        $data['captcha']['word'] = $captcha_value['word'];
        return $this->render('responsive_variant.authentication.update_password_view',$data);
	}

    function valid_password($password = '')
    {
        $password = trim($password);
        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>ยง~]/';
        if (empty($password))
        {
            return FALSE;
        }
        if (preg_match_all($regex_lowercase, $password) < 1)
        {
            return FALSE;
        }
        if (preg_match_all($regex_uppercase, $password) < 1)
        {
            return FALSE;
        }
        if (preg_match_all($regex_number, $password) < 1)
        {
            return FALSE;
        }
        if (preg_match_all($regex_special, $password) < 1)
        {
            return FALSE;
        }
        if (strlen($password) <= 8)
        {
            return FALSE;
        }
        if (strlen($password) > 32)
        {
            return FALSE;
        }
        return TRUE;
    }

    function decodeData($pass,$data){
        $sanitize = new Auto_Sanitize();
        for($i=0;$i<10;$i++){
            $data=$sanitize->cryptoJsAesDecrypt($pass, $data);
        }
        $dataArray= explode('hgtsd12@_hjytr',$data);
        return $dataArray[0];
    }

	function update_user_password(){
        // $this->form_validation->set_rules('password', 'New Passwrod', 'required|trim|is_required');
        // $this->form_validation->set_rules('confirm_password', 'Confirm Passwrod', 'required|trim|is_required');
        // $this->form_validation->set_error_delimiters('<div class="uk-alert-danger">', '</div>');
        $rules = [
            "password" => [
                "label" => "New Passwrod",
                "rules" => "required|trim|is_required"
            ],
            "confirm_password" => [
                "label" => "Confirm Passwrod",
                "rules" => "required|trim|is_required"
            ],
        ];
        $password = $_POST['txt_password'];
        $password = str_replace("'","",$password);
        $salt=$_POST['salt'];
        $decoded_password=$this->decodeData($salt,$password);
        // echo $decoded_password; exit(0);
        if ($this->validate($rules) === FALSE) {
            $data = [
                'validation' => $this->validator,
            ];
            $captcha_value = captcha_generate();
            $data['captcha']['image'] = $captcha_value['image'];
        	$data['captcha']['word'] = $captcha_value['word'];
            /* $this->load->view('login/login_header');
        	$this->load->view('register/update_password_view',$data);
			$this->load->view('login/login_footer');*/
            $this->render('responsive_variant.authentication.update_password_view', $data);
        } else if(!$this->valid_password($decoded_password)) {
            $this->session->setFlashdata('msg', 'Password policy has to be followed.');
            redirect('register/ForgetPassword/update_user_password');
        } else {
            /* $data['captcha']['image'] = $captcha_value['image'];
            $data['captcha']['word'] = $captcha_value['word'];
            $userCaptcha = escape_data($_POST['userCaptcha']);
            if ($this->session->userdata("captchaWord") != $userCaptcha) {
                setSessionData('msg', 'Invalid Captcha!');
                redirect('register/ForgetPassword/update_password');
            } */
            if($_POST['password'] != $_POST['confirm_password']){
                $this->session->setFlashdata('msg', 'Confirm Passwrod not matched!');
                redirect('register/ForgetPassword/update_user_password');
            }
            if(!empty(getSessionData('adv_details')['mobile_no'])){
                $forget_mobile = getSessionData('adv_details')['mobile_no'];
            }
            if(!empty(getSessionData('adv_details')['email_id'])){
                $forget_email = getSessionData('adv_details')['email_id'];
            }
            // $data = array('password' => hash('sha256',$_POST['confirm_password']));
            $data = array('password' => $_POST['confirm_password']);
            $passUpdate = $this->Register_model->update_user_password($data,$forget_mobile,$forget_email);
            if($passUpdate){
                $_SESSION['adv_details']['ForgetPasswordDone']='ForgetPasswordDone';
                $this->session->setFlashdata('msg', 'Passwrod Update Successful!');
                redirect('login');
            } else{
                $this->session->setFlashdata('msg', 'Failed Passwrod update!');
                redirect('register/ForgetPassword/update_user_password');
            }
        }
	}

    public function AdvSignUp()
    {
        $session = session();
        // Check if mobile_no and email_id are set in session
        if (empty(getSessionData('adv_details')['mobile_no']) || empty(getSessionData('adv_details')['email_id'])) {
            return redirect()->to('register');
        }
        // Unset image_and_id_view from session
        $session->remove('image_and_id_view');
        // Get state list and advocate details
        $data['select_state'] = $this->Register_model->getStateList();
        $mobileNo = getSessionData('adv_details')['mobile_no'];
        $emailId = getSessionData('adv_details')['email_id'];
        $data['advDetailsIcmis'] = $this->efiling_webservices->getBarTable($mobileNo, $emailId);
        // Load views
        // echo view('responsive_variant/authentication/adv_signup_view', $data);
        // echo view('responsive_variant/authentication/adv_signup_nav');
        return $this->render('responsive_variant.authentication.adv_signup_view',$data);
        return $this->render('responsive_variant.authentication.adv_signup_nav',$data);
    }

}