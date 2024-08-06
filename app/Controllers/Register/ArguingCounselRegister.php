<?php

namespace App\Controllers\Register;
use App\Controllers\BaseController;
use App\Models\Register\RegisterModel;
use App\Libraries\webservices\Efiling_webservices;
use App\Libraries\Slice;

// if (!defined('BASEPATH')) exit('No direct script access allowed');

class ArguingCounselRegister extends BaseController {

    protected $Register_model;
    protected $slice;
    protected $form_validation;
    protected $session;

    public function __construct() {
        parent::__construct();
        // $this->load->library('encrypt');
        // $this->load->model('register/Register_model');
        // $this->load->library('webservices/efiling_webservices');
        // $this->load->library('slice');
        // $this->load->helper('security');
        $this->Register_model = new RegisterModel();
        $this->slice = new Slice();
        $this->efiling_webservices = new Efiling_webservices();
        $this->session = \Config\Services::session();
        helper(['security']);
    }

    public function index(){ }

    public function addAarguingCounsel() {
        unset($_SESSION['adv_details']);
        /* $captcha_value = captcha_generate();
        $data['captcha']['image'] = $captcha_value['image'];
        $data['captcha']['word'] = $captcha_value['word'];*/
        $this->render('register.arguing_counsel_register_view');
    }

    public function senOtp() {
        unset($_SESSION['self_register_arguing_counsel']);
        unset($_SESSION['self_arguing_counsel']);
        unset($_SESSION['arguingCounselId']);
        unset($_SESSION['aor_register']);

        if ($_SESSION["captcha"] !=$_POST['userCaptcha']) {
            $this->session->set_flashdata('msg', '<div class="uk-alert-danger" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Invalid Captcha!!</p> </div>');
            redirect('arguingCounselRegister');
            exit(0);
        }$this->form_validation->set_rules('userCaptcha', 'Captcha', 'required|trim|is_required');
        $this->form_validation->set_rules('adv_mobile', 'Mobile', 'required|numeric|trim|is_required|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('adv_email', 'Email', 'required|valid_email|trim|is_required');
        $this->form_validation->set_error_delimiters('<div class="uk-alert-danger">', '</div>');
        if ($this->form_validation->run() === FALSE) {
            $captcha_value = captcha_generate();
            $data['captcha']['image'] = $captcha_value['image'];
            $data['captcha']['word'] = $captcha_value['word'];
            $this->addAarguingCounsel();
        }
        else {
            if (isset($_POST['adv_mobile']) && !empty($_POST['adv_mobile']) || isset($_POST['adv_email']) && !empty($_POST['adv_email'])) {
                $mobile_already_exist = $this->Register_model->check_already_reg_mobile($_POST['adv_mobile']);
                $email_already_exist = $this->Register_model->check_already_reg_email($_POST['adv_email']);
                $mobile_arguing_counsel_exist = $this->Register_model->check_already_reg_mobile_arguing_counsel($_POST['adv_mobile']);
                $email_arguing_counsel_exist = $this->Register_model->check_already_reg_email_arguing_counsel($_POST['adv_email']);
                if ($_POST['register_type'] == 'Advocate') {
                    if ($mobile_already_exist[0]['moblie_number'] == $_POST['adv_mobile']) {
                        $this->session->set_flashdata('msg', '<div class="uk-alert-danger flashmessage" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Mobile Number Already Registerd! Please click on forgot password and reset your password!</p> </div>');
                        redirect('arguingCounselRegister');
                    }
                    if ($email_already_exist[0]['emailid'] == $_POST['adv_email']) {
                        $this->session->set_flashdata('msg', '<div class="uk-alert-danger flashmessage" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Email ID Already Registerd! Please click on forgot password and reset your password!</p> </div>');
                        redirect('arguingCounselRegister');
                    }
                    if ($mobile_arguing_counsel_exist[0]['moblie_number'] == $_POST['adv_mobile']) {
                        $this->session->set_flashdata('msg', '<div class="uk-alert-danger flashmessage" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Mobile Number Already Registerd! Please click on forgot password and reset your password!</p> </div>');
                        redirect('arguingCounselRegister');
                    }
                    if ($email_arguing_counsel_exist[0]['emailid'] == $_POST['adv_email']) {
                        $this->session->set_flashdata('msg', '<div class="uk-alert-danger flashmessage" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Email ID Already Registerd! Please click on forgot password and reset your password!</p> </div>');
                        redirect('arguingCounselRegister');
                    }

//                    $advDetailsIcmis=$this->efiling_webservices->getBarTable($_POST['adv_mobile'],$_POST['adv_email']);
//                    if ($advDetailsIcmis[0]->moblie_number != $_POST['adv_mobile'] || $advDetailsIcmis[0]->emailid != $_POST['adv_email']) {
//                        $this->session->set_flashdata('msg', '<div class="uk-alert-danger flashmessage" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Mobile Number And Email ID Not Vailid for Bar! Please Contact SCI !</p> </div>');
//                        redirect('arguingCounselRegister');
//                    }
                }
                $mobile_otp_is = $this->generateNumericOTP();
                $email_otp_is = $this->generateNumericOTP();
                $startTime=date("H:i");
                $endTime = date("H:i", strtotime('+15 minutes', strtotime($startTime)));
                $_SESSION['adv_details'] = array('mobile_no' => $_POST['adv_mobile'],
                    'mobile_otp' => $mobile_otp_is,
                    'email_id' => $_POST['adv_email'],
                    'email_otp' => $email_otp_is,
                    'register_type' => $_POST['register_type'],
                    'start_time'=>$startTime,
                    'end_time'=>$endTime
                );
                if(!empty($_POST['adv_mobile'])){
                    $mobileNo=trim($_POST['adv_mobile']);
                    $smsText="OTP for Registration SC-EFM password is: ".$mobile_otp_is." ,Please do not share it with any one. - Supreme Court of India";
                    sendSMS(SMS_EMAIL_API_USER,$mobileNo,$smsText,SCISMS_Registration_OTP);
                }
                if(!empty($_POST['adv_email'])){
                    $to_email=trim($_POST['adv_email']);
                    $subject="SC-EFM Registration password OTP";
                    $message="OTP for Registration SC-EFM password is: ".$email_otp_is." ,Please do not share it with any one.";
                    send_mail_msg($to_email, $subject, $message);
                }
                    redirect('register/AdvOtp');
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


}