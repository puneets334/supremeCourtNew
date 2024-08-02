<?php

namespace App\Controllers\Register;
use App\Controllers\BaseController;
use App\Models\Register\Register_model;
use App\Libraries\webservices\Efiling_webservices;
use App\Libraries\Slice;

// if (!defined('BASEPATH')) exit('No direct script access allowed');

class AdvocateOnRecord extends BaseController {
    protected $Register_model;
    protected $slice;
    protected $form_validation;
    protected $session;
    
    public function __construct() {
        parent::__construct();
        // $this->load->model('register/Register_model');
        // $this->load->library('webservices/efiling_webservices');
        // $this->load->library('slice');
        $this->Register_model = new Register_model();
        $this->slice = new Slice();
        $this->efiling_webservices = new Efiling_webservices();
        $this->session = \Config\Services::session();
        helper(['form']);
    }
    
    public function index() {
        unset($_SESSION['adv_details']);
        // $captcha_value = captcha_generate();
        // print_r($captcha_value); die();
        // $data['captcha']['image'] = $captcha_value['image'];
        // $data['captcha']['word'] = $captcha_value['word'];

       /* $this->load->view('login/login_header');
        $this->load->view('register/aor_register_view', $data);
        $this->load->view('login/login_footer');*/
        $this->render('responsive_variant.authentication.aor_register_view');
    }

    function adv_get_otp() {
        /*if(!is_recaptcha_valid(@$_POST['ctvrg'])){
            $this->session->set_flashdata('msg', 'We are not able to verify you. Please try later or try with a different web browser / device.');
            redirect('register/AdvocateOnRecord');
            exit(0);
        }*/
        /*$data['captcha']['image'] = $captcha_value['image'];
        $data['captcha']['word'] = $captcha_value['word'];

        $userCaptcha = escape_data($_POST['userCaptcha']);

        if ($this->session->userdata("captchaWord") != $userCaptcha) {
            $this->session->set_flashdata('msg', '<div class="uk-alert-danger" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Invalid Captcha!</p> </div>');
            redirect('register/AdvocateOnRecord');
        }*/
        // $this->form_validation->set_rules('userCaptcha', 'Captcha', 'required|trim|is_required');
        // $this->form_validation->set_rules('adv_mobile', 'Mobile', 'required|numeric|trim|is_required|min_length[10]|max_length[10]');
        // $this->form_validation->set_rules('adv_email', 'Email', 'required|valid_email|trim|is_required');

        // $this->form_validation->set_error_delimiters('<div class="uk-alert-danger">', '</div>');

        // if ($this->form_validation->run() === FALSE) {
        //    /* $captcha_value = captcha_generate();
        //     $data['captcha']['image'] = $captcha_value['image'];
        //     $data['captcha']['word'] = $captcha_value['word'];*/
        //     /*$this->load->view('login/login_header');
        //     $this->load->view('register/aor_register_view', $data);
        //     $this->load->view('login/login_footer');*/
        //     $this->render('responsive_variant.authentication.aor_register_view');
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
            return $this->render('responsive_variant.authentication.aor_register_view', $data);
        } else{
            if ($_SESSION["captcha"] !=$_POST['userCaptcha']) {
                $this->session->set_flashdata('msg', '<div class="uk-alert-danger" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Invalid Captcha!</p> </div>');
                redirect('register/AdvocateOnRecord'); exit(0);
            }
            if (isset($_POST['adv_mobile']) && !empty($_POST['adv_mobile']) || isset($_POST['adv_email']) && !empty($_POST['adv_email'])) {

                $mobile_already_exist = $this->Register_model->check_already_reg_mobile($_POST['adv_mobile']);
                $email_already_exist = $this->Register_model->check_already_reg_email($_POST['adv_email']);
                //$mobile_already_bar = $this->Register_model->check_already_reg_mobile_bar($_POST['adv_mobile']);
                //$email_already_bar = $this->Register_model->check_already_reg_email_bar($_POST['adv_email']);

                if ($_POST['register_type'] == 'Advocate On Record') {
                    if(!empty($mobile_already_exist)) {
                        if ($mobile_already_exist[0]['moblie_number'] == $_POST['adv_mobile']) {
                            $this->session->set_flashdata('msg', '<div class="uk-alert-danger flashmessage" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Mobile Number Already Registerd! Please click on forgot password and reset your password!</p> </div>');
                            redirect('register/AdvocateOnRecord');
                        }
                    }
                    if(!empty($email_already_exist)) {
                        if ($email_already_exist[0]['emailid'] == $_POST['adv_email']) {
                            $this->session->set_flashdata('msg', '<div class="uk-alert-danger flashmessage" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Email ID Already Registerd! Please click on forgot password and reset your password!</p> </div>');
                            redirect('register/AdvocateOnRecord');
                        }
                    }
                    $advDetailsIcmis=$this->efiling_webservices->getBarTable($_POST['adv_mobile'],$_POST['adv_email']);
                    // echo '<pre>Hi'; print_r($advDetailsIcmis); die();
                    //if ($mobile_already_bar[0]['mobile'] != $_POST['adv_mobile'] || $email_already_bar[0]['email'] != $_POST['adv_email']) {
                    if (!empty($advDetailsIcmis)) {
                        if ($advDetailsIcmis[0]->moblie_number != $_POST['adv_mobile'] || $advDetailsIcmis[0]->emailid != $_POST['adv_email']) {
                            $this->session->set_flashdata('msg', '<div class="uk-alert-danger flashmessage" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Mobile Number And Email ID Not Vailid for Bar! Please Contact SCI !</p> </div>');
                            redirect('register/AdvocateOnRecord');
                        }
                    }
                }

                $mobile_otp_is = $this->generateNumericOTP();
                $email_otp_is = $this->generateNumericOTP();


                date_default_timezone_set('Asia/Kolkata');
                $startTime=date("H:i");
                $endTime = date("H:i", strtotime('+15 minutes', strtotime($startTime)));
                $_SESSION['adv_details'] = array(
                    'mobile_no' => $_POST['adv_mobile'],
                    'mobile_otp' => $mobile_otp_is,
                    'email_id' => $_POST['adv_email'],
                    'email_otp' => $email_otp_is,
                    'register_type' => $_POST['register_type'],
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'first_name' => '',
                    'last_name' => ''
                );

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
                    //relay_mail_api($to_email, $subject, $message);
                    //var_dump($test);exit;
                }

                redirect('register/AdvOtp');
            } else {
                $this->session->setFlashdata('login_salt', $this->generateRandomString());
                return $this->render('responsive_variant.authentication.aor_register_view');
            }
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
