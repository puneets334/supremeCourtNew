<?php
namespace App\Controllers;
use App\Libraries\Slice;
use App\Libraries\webservices\Efiling_webservices;
use App\Models\Login\LoginModel;
use stdClass;

class DefaultController extends BaseController {

    protected $session;
    protected $load;
    protected $security;
    protected $agent;
    protected $form_validation;
    protected $slice;
    protected $Login_model;
    protected $Login_device;
    protected $efiling_webservices;

    public function __construct() {
        parent::__construct();
        $this->Login_model = new LoginModel();
        $this->efiling_webservices = new Efiling_webservices();
        $this->agent = \Config\Services::request()->getUserAgent();
        $this->session = \Config\Services::session();
        $this->slice = new Slice();
        helper(['form']);
    }
    function checkBrowserCompatibility(){
        //Check browser version
        $browser_version=array('Firefox'=>84,'Chrome'=>87,'Safari'=>604,'Edg'=>89);
        if ($this->agent->isBrowser())
        {
            $version=$this->agent->getVersion();
            $agentb = $this->agent->getBrowser();
            if (array_key_exists($agentb, $browser_version)) {
                if((int)$version<$browser_version[$agentb]){
                    $data['agent']=$agentb;
                    $this->load->view('browser_version_error',$data);
                }
                else{
                    return true;
                }
            }
            else{

            }
        }
        elseif ($this->agent->isRobot())
        {
            $this->Login_device = $this->agent->getRobot();
        }
        elseif ($this->agent->isMobile())
        {
            $this->Login_device = $this->agent->getMobile();
        }
        else
        {
            $this->Login_device = 'Unidentified User Agent';
        }

        //echo $agent;

        /*echo $this->agent->platform();
        $this->load->view('error404');
        exit;*/
        //END
    }
    public function index(){
        $data = [];
        $this->session->set('login_salt', $this->generateRandomString());
        return $this->render('responsive_variant.authentication.frontLogin', $data);
    }
    public function login() {
        $this->checkBrowserCompatibility();
        //check user already logged in or not


        if (!empty($this->session->getFlashdata('login'))) {
            $this->redirect_on_login();
        }
        $validation =  \Config\Services::validation();
        //---Commented line are used for disable captcha----------------->

        $rules=[
            "txt_username" => [
                "label" => "User ID",
                "rules" => "required|trim"
            ],
            "txt_password" => [
                "label" => "Password",
                "rules" => "required|trim"
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
            return $this->render('responsive_variant.authentication.frontLogin', $data);
        }else{
            if (isset($_POST['txt_username']) && !empty($_POST['txt_username']) && isset($_POST['txt_password']) && !empty($_POST['txt_password']) && isset($_POST['userCaptcha']) && !empty($_POST['userCaptcha'])) {
                $username = $_POST['txt_username'];
                $password = $_POST['txt_password'];
                $userCaptcha = $_POST['userCaptcha'];
                if ($username == NULL  || $password == NULL || preg_match('/[^A-Za-z0-9!@#$]/i', $password) || $userCaptcha == NULL || preg_match('/[^A-Za-z0-9]/i', $userCaptcha)) {
                    $this->session->setFlashdata('msg', '<div class="danger" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Invalid username or password or Captcha!</p> </div>');
                    return response()->redirect(base_url('/'));
                }
                elseif ($this->session->get('captcha') != $userCaptcha) {
                    // pr($this->session->getFlashdata('captcha'));
                    $this->session->setFlashdata('msg', '<div class="danger" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Invalid Captcha!</p> </div>');
                    return response()->redirect(base_url('/'));
                }
                else {
                    /*****start-for efiling_assistant*****/
                    $impersonator_user = new stdClass();
                    $impersonated_user = new stdClass();
                    $mobile='';$email='';
                    $user_parts = explode('#', $username);
                    if(count($user_parts) == 2){
                        $impersonator_user = @$this->Login_model->get_user($user_parts[0], $password, false)[0];
                        if((!empty($impersonator_user)) or (strcasecmp($user_parts[0],'jail')==0)){
                            if($impersonator_user->ref_m_usertype_id == 18 or (strcasecmp($user_parts[0],'jail')==0)) {
                                $impersonated_user = @$this->Login_model->get_user($user_parts[1], $password, false, false)[0];
                                if(@$impersonated_user->ref_m_usertype_id==17)
                                {
                                    $result=$this->efiling_webservices->jailAuthorityDetails($user_parts[1]);
                                    $mobile=$result[0]['spmobile'];
                                    $email=$result[0]['spemail'];
                                }
                                if (!empty($impersonated_user)) {
                                    if (empty($impersonatedUserAuthenticationMobileOtp)) {
                                        if ((!empty(@$impersonated_user->moblie_number)) or (!empty($mobile))) {
                                            $impersonated_user_authentication_mobile_otp = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
                                            $_SESSION['impersonated_user_authentication_mobile_otp.'.$impersonated_user->id] = $impersonated_user_authentication_mobile_otp;

                                            if($impersonated_user->ref_m_usertype_id==17)
                                            {
                                                $message='Authentication OTP for eFiling is: ' . $impersonated_user_authentication_mobile_otp.'. - Supreme Court of India';
                                                @sendSMS(38, $mobile, $message,SCISMS_efiling_OTP);
                                                send_mail_msg($email,'Authentication OTP for eFiling' ,$message, $user_parts[1]);
                                                $this->session->setFlashdata('information', 'Please enter the authentication OTP sent to intended user on her/his Mobile No. - ' . $mobile);
                                                log_message('CUSTOM', "Please enter the authentication OTP sent to intended user on her/his Mobile No. - " . $mobile);
                                            }
                                            else {
                                                @sendSMS(38, $impersonated_user->moblie_number, 'Authentication OTP for eFiling via eFiling Assistant is: ' . $impersonated_user_authentication_mobile_otp.'. - Supreme Court of India',SCISMS_Efiling_OTP_Via_Assistant);
                                                $this->session->setFlashdata('information', 'Please enter the authentication OTP sent to intended user on her/his Mobile No. - ' . $impersonated_user->moblie_number);
                                            }

                                            $this->session->setFlashdata('user', $username);
                                            $this->session->setFlashdata('impersonated_user_authentication_mobile_otp', $impersonated_user_authentication_mobile_otp);
                                            redirect('login');
                                            exit(0);
                                        } else {
                                            $this->session->setFlashdata('msg', 'Impersonated user has no registered mobile number');
                                            return response()->redirect(base_url('/'));
                                            exit(0);
                                        }
                                    } else if ($impersonatedUserAuthenticationMobileOtp == @$_SESSION['impersonated_user_authentication_mobile_otp.'.$impersonated_user->id]) {
                                        unset($_SESSION['impersonated_user_authentication_mobile_otp.'.$impersonated_user->id]);

                                        $row = $this->Login_model->get_user($user_parts[1], null, true, false);
                                    } else {
                                        $this->session->setFlashdata('msg', 'Invalid authentication OTP');
                                        return response()->redirect(base_url('/'));
                                        exit(0);
                                    }
                                } else {
                                    $this->session->setFlashdata('msg', 'Invalid impersonated user');
                                    return response()->redirect(base_url('/'));
                                    exit(0);
                                }
                            }
                            else{
                                $row = $this->Login_model->get_user($username, $password);
                            }
                        }
                        else{
                            $this->session->setFlashdata('msg', 'Invalid user or password.');
                            return response()->redirect(base_url('/'));
                            exit(0);
                        }
                    }
                    else{
                        $row = $this->Login_model->get_user($username, $password);
                    }
                    if ($row) {
                            $otp = '123456';
                            $this->Login_model->storeOtp($username, $password, $otp);
                            $sessiondata['login_cred'] = array(
                                'user_name' => $username,
                                'password' => $password
                            );
                            $this->session->set($sessiondata);
                            return $this->render('responsive_variant.authentication.loginOtp');
                    } else {
                        $this->session->setFlashdata('msg', '<div class="danger" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Invalid username or password !</p> </div>');
                        return response()->redirect(base_url('/'));
                        exit(0);
                    }
                }
            } else {
                $this->session->setFlashdata('login_salt', $this->generateRandomString());
                return $this->render('responsive_variant.authentication.frontLogin');
            }
        }


    }

    public function otp(){
        $username = $this->session->get('login_cred')['user_name'];
        $password = $this->session->get('login_cred')['password'];
        $otp = $this->request->getPost('otp_one').$this->request->getPost('otp_two').$this->request->getPost('otp_three').$this->request->getPost('otp_four').$this->request->getPost('otp_five').$this->request->getPost('otp_six');
        // print_r($otp);die;
        $checkotp = $this->Login_model->check_otp($username, $password, $otp);
        if($checkotp){
            $row = $this->Login_model->get_user($username, $password); 
            $impersonator_user = new stdClass();
            if ($row) {
                $impersonator_user = $row;
                $usr_block = $this->Login_model->get_user_block_dtl($row->id);
                // print_r($usr_block);
                // die;
                if(!empty($usr_block)){
                    foreach ($usr_block as $user_val) {
                        $logintime = $user_val->login_time;
                        $failure_no_attmpt=$user_val->failure_no_attmpt;
                    }
                    $currenttime = date("Y-m-d H:i:s");
                    $fullHours = 0;
                    $diff = strtotime($currenttime) - strtotime($logintime);
                    $fullDays = floor($diff / (60 * 60 * 24));
                    $fullMinutes = floor(($diff - ($fullDays * 60 * 60 * 24) - ($fullHours * 60 * 60)) / 60);

                    if ($fullDays == 0 && $fullMinutes <= 5 && $failure_no_attmpt==3) {
                        $this->session->setFlashdata('msg', 'You are Blocked Try After 5 min');
                        return response()->redirect(base_url('/'));
                        exit(0);

                    }
                }
                $user_name = ucwords($row->first_name . ' ' . $row->last_name);
                //Check user role
                if(logged_in_check_user_type($row->ref_m_usertype_id)){
                    $this->session->setFlashdata('msg', 'You are not authorized !!');
                    return response()->redirect(base_url('/'));
                    exit(0);
                }
                $usr_block_update = $this->Login_model->get_user_block_dtl_update($row->id);
                $log_data = $this->Login_model->get_user_login_log_details($row->id);
                // print_r(count($log_data));die;
                if ($log_data) {
                    foreach ($log_data as $resdata) {
                        $unauthorized_access = array_keys(array_column($log_data, 'block'), 't');
                        $new_login_agent = array_keys(array_column($log_data, 'user_agent'), $_SERVER['HTTP_USER_AGENT']);
                        if(isset($unauthorized_access[0]) && !empty($unauthorized_access[0])){
                            $this->session->setFlashdata('msg', 'Unauthorized Access.');
                            return response()->redirect(base_url('/'));
                            exit(0);
                        }
                        if(isset($new_login_agent) && empty($new_login_agent)){
                            $subject = 'New Login Detection on eFiling application';
                            $Mail_message = 'We detected a login into your account from a new device on ' . date('d-m-Y') . ' at ' . date("h:i:s A") . "<br>Device: <b>" . $this->Login_device . '</b><br>IP Address: <b>' . getClientIP() . '</b><br>User Agent: <b>' . $_SERVER['HTTP_USER_AGENT'] . '</b><br>If you think that somebody logged in to your account against your will, you can block it from your profile on  efiling portal.';
                        }
                    }
                } else {
                    $subject = 'New Login Detection on eFiling application';
                    $Mail_message = 'We detected a login into your account from a new device on ' . date('d-m-Y') . ' at ' . date("h:i:s A") . "<br>Device: <b>" . $this->Login_device . '</b><br>IP Address: <b>' . getClientIP() . '</b><br>User Agent: <b>' . $_SERVER['HTTP_USER_AGENT'] . '</b><br>If you think that somebody logged in to your account against your will, you blocked it from your profile on  efiling portal.';
                    // send_mail_msg($row->emailid, $subject, $Mail_message, $user_name);
                }
                $pg_request_function = $row->pg_request_function;
                $pg_response_function = $row->pg_response_function;
                $admin_estab_code = $row->estab_code;
                $logindata = array(
                    'id' => $row->id,
                    'userid' => $row->userid,
                    'ref_m_usertype_id' => $row->ref_m_usertype_id,
                    'first_name' => $row->first_name,
                    'last_name' => $row->last_name,
                    'mobile_number' => $row->moblie_number,
                    'emailid' => $row->emailid,
                    'adv_sci_bar_id' => $row->adv_sci_bar_id,
                    'aor_code' => $row->aor_code,
                    'bar_reg_no' => $row->bar_reg_no,
                    'gender' => $row->gender,
                    'pg_request_fun' => $pg_request_function,
                    'pg_response_fun' => $pg_response_function,
                    'photo_path' => $row->photo_path,
                    'login_active_session' => substr(number_format(time() * rand(), 0, '', ''), 0, 6),
                    'admin_for_type_id'=>$row->admin_for_type_id,
                    'admin_for_id' =>$row->admin_for_id,
                    'account_status' => $row->account_status,
                    'refresh_token' => $row->refresh_token,
                    //'dep_flag' => $row->dep_flag,
                    //'case_flag' => $row->case_flag,
                    //'doc_flag' => $row->doc_flag,
                    //'efiling_flag' => $row->efiling_flag,
                    //'dep_adv_flag' => $row->dep_adv_flag,
                    'impersonator_user' => $impersonator_user,//for efiling_assistant
                    'processid' => getmypid(),
                    'department_id' => $row->ref_department_id
                );
                $sessiondata = array(
                    'login' => $logindata
                );
                // pr($sessiondata);
                $this->session->set($sessiondata);
                $this->logUser('login', $logindata);
                $this->redirect_on_login();
            } else {
                $this->session->setFlashdata('msg', '<div class="uk-alert-danger" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">Invalid username or password !</p> </div>');
                return response()->redirect(base_url('/'));
                exit(0);
            }
        }else{
            $this->session->setFlashdata('msg', '<div class="uk-alert-danger" uk-alert> <a class="uk-alert-close" uk-close></a > <p style="text-align: center;">OTP Not matched !</p> </div>');
            return response()->redirect(base_url('/'));
            exit(0);
        }
    }

    function redirect_on_login() {
        // print_r($this->session->get('login')['ref_m_usertype_id']);die;
        if ($this->session->get('login')['ref_m_usertype_id'] == USER_SUPER_ADMIN) {
            return response()->redirect("superAdmin");
            exit();
        } elseif ($this->session->get('login')['ref_m_usertype_id'] == USER_DISTRICT_ADMIN) {
            return response()->redirect("adminDashboard/work_done");
            exit();
        } elseif ($this->session->get('login')['ref_m_usertype_id'] == USER_MASTER_ADMIN) {
            return response()->redirect("adminDashboard/work_done");
            exit();
        } elseif ($this->session->get('login')['ref_m_usertype_id'] == USER_ADMIN || $this->session->get('login')['ref_m_usertype_id'] == USER_ACTION_ADMIN) {
            return response()->redirect("adminDashboard");
            exit();
        } elseif ($this->session->get('login')['ref_m_usertype_id'] == USER_DEPARTMENT) {
            return response()->redirect('mycases/updation');
            exit(0);
        } elseif ($this->session->get('login')['ref_m_usertype_id'] == USER_CLERK) {
            return response()->redirect('mycases/updation');
            exit(0);
        } elseif ($this->session->get('login')['ref_m_usertype_id'] == USER_BAR_COUNCIL) {
            return response()->redirect('Bar_council');
            exit(0);
        }
        elseif ($this->session->get('login')['ref_m_usertype_id'] == JAIL_SUPERINTENDENT) {
            return response()->redirect('jail_dashboard');
            exit(0);
        }else if ($this->session->get('login')['ref_m_usertype_id'] == USER_EFILING_ADMIN) {
            return response()->redirect("filingAdmin");
            exit();
        }else if ($this->session->get('login')['ref_m_usertype_id'] == USER_ADVOCATE) {
            return response()->redirect("dashboard_alt");
            exit();
        } /* elseif ($this->session->userdata['login']['account_status'] == ACCOUNT_STATUS_PENDING_APPROVAL || $this->session->userdata['login']['account_status'] == ACCOUNT_STATUS_OBJECTION || $this->session->userdata['login']['account_status'] == ACCOUNT_STATUS_REJECTED || $this->session->userdata['login']['account_status'] == ACCOUNT_STATUS_DEACTIVE || $this->session->userdata['login']['bar_approval_status'] == BAR_APPROVAL_STATUS_ON_HOLD || $this->session->userdata['login']['bar_approval_status'] == BAR_APPROVAL_STATUS_DEACTIVATED) {
          redirect('profile');
          exit(0);
          } */ else {
            return response()->redirect("dashboard");
            exit();
        }
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


    private function logUser($action) {
        if ($action == 'login') {
            $data['login_id'] = getSessionData('login')['id'];
            $data['is_successful_login'] = 'true';
            $data['ip_address'] = getClientIP();
            $data['login_time'] = date('Y-m-d H:i:s');
            //$data['session_detail'] = serialize($this->session->userdata());
            //$data['referrer'] = $_SERVER['HTTP_REFERER'];
            $data['referrer'] = getSessionData('login')['ref_m_usertype_id'];
            $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            //$data['url'] = $_SERVER['REQUEST_URI'];
            $data['processid'] = getSessionData('login')['processid'];
            $data['impersonator_user'] = json_encode(getSessionData('login')['impersonator_user']);//for efiling_assistant
        } elseif ($action == 'logout') {
            $data['log_id'] = getSessionData('login')['log_id'];
            $data['logout_time'] = date('Y-m-d H:i:s');
        }
        $this->Login_model->logUser($action, $data);
    }

    public function isMobileDevice() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    public function customDashboard () {

        return $this->render('layout.adminApp');

        //  echo "Welcome To Dashboard";
    }
}





?>