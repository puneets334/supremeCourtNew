<?php
namespace App\Controllers;
use App\Libraries\Slice;
use App\Libraries\webservices\Efiling_webservices;
use App\Models\Login\LoginModel;
use stdClass;
use App\Libraries\webservices\Ecoping_webservices;
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
    protected $ecoping_webservices;
    public function __construct() {
        parent::__construct();
        $this->Login_model = new LoginModel();
        $this->efiling_webservices = new Efiling_webservices();
        $this->ecoping_webservices=new Ecoping_webservices();
        $this->agent = \Config\Services::request()->getUserAgent();
        $this->session = \Config\Services::session();
        $this->slice = new Slice();
        helper(['form']);
    }

    function checkBrowserCompatibility() {
        //Check browser version
        $browser_version=array('Firefox'=>84,'Chrome'=>87,'Safari'=>604,'Edg'=>89);
        if ($this->agent->isBrowser()) {
            $version=$this->agent->getVersion();
            $agentb = $this->agent->getBrowser();
            if (array_key_exists($agentb, $browser_version)) {
                if((int)$version<$browser_version[$agentb]){
                    $data['agent']=$agentb;
                    $this->load->view('browser_version_error',$data);
                } else{
                    return true;
                }
            } else{

            }
        } elseif ($this->agent->isRobot()) {
            $this->Login_device = $this->agent->getRobot();
        } elseif ($this->agent->isMobile()) {
            $this->Login_device = $this->agent->getMobile();
        } else{
            $this->Login_device = 'Unidentified User Agent';
        }
        //echo $agent;
        /*echo $this->agent->platform();
        $this->load->view('error404');
        exit;*/
        //END
    }

    public function index() {
        $data = [];
        $this->session->set('login_salt', $this->generateRandomString());
        return $this->render('responsive_variant.authentication.frontLogin', $data);
    }

    function isNewUser($userId) {
        $result =  $this->Login_model->isNewUser($userId);
        return $result;
    }

    public function login() {
        $this->checkBrowserCompatibility();
        //check user already logged in or not
        if (isset($_SESSION['login']) && !empty($_SESSION['login'])) {
            $this->redirect_on_login();
        }        
        // if (!empty($this->session->getFlashdata('login'))) {
        //     $this->redirect_on_login();
        // }
        $validation =  \Config\Services::validation();
        //---Commented line are used for disable captcha----------------->
        if(empty($this->request->getPost('userType'))){
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
        } else{
            if($this->isNewUser($_POST['txt_username']) == 1){ 
                $userCaptcha = $_POST['userCaptcha'];
                if ($this->session->get('captcha') != $userCaptcha) {
                    $this->session->setFlashdata('msg', 'Invalid Captcha!');
                    $this->session->setFlashdata('old_username', $_POST['txt_username']);
                    return response()->redirect(base_url('/'));
                }
                return redirect()->to(base_url('Register/ForgetPassword')); 
                //return $this->render('responsive_variant.authentication.update_password_view');
            } 
            if (isset($_POST['txt_username']) && !empty($_POST['txt_username']) && isset($_POST['txt_password']) && !empty($_POST['txt_password']) && isset($_POST['userCaptcha']) && !empty($_POST['userCaptcha'])) {
                $username = $_POST['txt_username'];
                $password = $_POST['txt_password'];
                $userCaptcha = $_POST['userCaptcha'];
                if ($username == NULL  || $password == NULL || preg_match('/[^A-Za-z0-9!@#$]/i', $password) || $userCaptcha == NULL || preg_match('/[^A-Za-z0-9]/i', $userCaptcha)) { 
                    $this->session->setFlashdata('msg', 'Invalid username or password or Captcha!');
                    return response()->redirect(base_url('/'));
                } elseif ($this->session->get('captcha') != $userCaptcha) {
                    $this->session->setFlashdata('msg', 'Invalid Captcha!');
                    $this->session->setFlashdata('old_username', $username);
                    return response()->redirect(base_url('/'));
                } else {            
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
                                if(@$impersonated_user->ref_m_usertype_id==17) {
                                    $result=$this->efiling_webservices->jailAuthorityDetails($user_parts[1]);
                                    $mobile=$result[0]['spmobile'];
                                    $email=$result[0]['spemail'];
                                }
                                if (!empty($impersonated_user)) {
                                    if (empty($impersonatedUserAuthenticationMobileOtp)) {
                                        if ((!empty(@$impersonated_user->moblie_number)) or (!empty($mobile))) {
                                            $impersonated_user_authentication_mobile_otp = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
                                            $_SESSION['impersonated_user_authentication_mobile_otp.'.$impersonated_user->id] = $impersonated_user_authentication_mobile_otp;
                                            if($impersonated_user->ref_m_usertype_id==17) {
                                                $message='Authentication OTP for eFiling is: ' . $impersonated_user_authentication_mobile_otp.'. - Supreme Court of India';
                                                @sendSMS(38, $mobile, $message,SCISMS_efiling_OTP);
                                                send_mail_msg($email,'Authentication OTP for eFiling' ,$message, $user_parts[1]);
                                                $this->session->setFlashdata('information', 'Please enter the authentication OTP sent to intended user on her/his Mobile No. - ' . $mobile);
                                                log_message('CUSTOM', "Please enter the authentication OTP sent to intended user on her/his Mobile No. - " . $mobile);
                                            } else{
                                                @sendSMS(38, $impersonated_user->moblie_number, 'Authentication OTP for eFiling via eFiling Assistant is: ' . $impersonated_user_authentication_mobile_otp.'. - Supreme Court of India',SCISMS_Efiling_OTP_Via_Assistant);
                                                $this->session->setFlashdata('information', 'Please enter the authentication OTP sent to intended user on her/his Mobile No. - ' . $impersonated_user->moblie_number);
                                            }
                                            $this->session->setFlashdata('user', $username);
                                            $this->session->setFlashdata('impersonated_user_authentication_mobile_otp', $impersonated_user_authentication_mobile_otp);
                                            redirect('login');
                                            exit(0);
                                        } else{
                                            $this->session->setFlashdata('msg', 'Impersonated user has no registered mobile number');
                                            return response()->redirect(base_url('/'));
                                            exit(0);
                                        }
                                    } else if ($impersonatedUserAuthenticationMobileOtp == @$_SESSION['impersonated_user_authentication_mobile_otp.'.$impersonated_user->id]) {
                                        unset($_SESSION['impersonated_user_authentication_mobile_otp.'.$impersonated_user->id]);
                                        $row = $this->Login_model->get_user($user_parts[1], null, true, false);
                                    } else{
                                        $this->session->setFlashdata('msg', 'Invalid authentication OTP');
                                        return response()->redirect(base_url('/'));
                                        exit(0);
                                    }
                                } else{
                                    $this->session->setFlashdata('msg', 'Invalid impersonated user');
                                    return response()->redirect(base_url('/'));
                                    exit(0);
                                }
                            } else{
                                $row = $this->Login_model->get_user($username, $password);
                            }
                        } else{
                            $this->session->setFlashdata('msg', 'Invalid user or password.');
                            return response()->redirect(base_url('/'));
                            exit(0);
                        }
                    } else{
                        $row = $this->Login_model->get_user($username, $password);
                     
                    }
                    if ($row) {
                        // $otp = '123456';
                        // $this->Login_model->storeOtp($username, $password, $otp);
                        // $sessiondata['login_cred'] = array(
                        //     'user_name' => $username,
                        //     'password' => $password
                        // );
                        // $this->session->set($sessiondata);
                        // return $this->render('responsive_variant.authentication.loginOtp');
                        $row = $this->Login_model->get_user($username, $password); 
                        $impersonator_user = new stdClass();
                        if ($row) {
                            // $alreadyLoggedInStatus=$this->Login_model->get_user_login_log_details_with_user_agent($row->id);
                            // if ($alreadyLoggedInStatus) {
                            //     if($alreadyLoggedInStatus[0]->logout_time == '' || $alreadyLoggedInStatus[0]->logout_time == null ){
                            //             // Set a flashdata message
                            //             $this->session->setFlashdata('msg', 
                            //             'You are already logged in'
                            //             );
                            //             return redirect()->to('/');
                            //     } 
                            // }
                            $impersonator_user = $row[0];
                            $usr_block = $this->Login_model->get_user_block_dtl($row[0]->id);
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
                            $user_name = ucwords($row[0]->first_name . ' ' . $row[0]->last_name);
                            //Check user role
                            if(logged_in_check_user_type($row[0]->ref_m_usertype_id)){
                                $this->session->setFlashdata('msg', 'You are not authorized !!');
                                return response()->redirect(base_url('/'));
                                exit(0);
                            }
                            $usr_block_update = $this->Login_model->get_user_block_dtl_update($row[0]->id);
                            $log_data = $this->Login_model->get_user_login_log_details($row[0]->id);
                            if ($log_data) {
                                foreach ($log_data as $resdata) {
                                    $unauthorized_access = array_keys(array_column($log_data, 'block'), 't');
                                    $new_login_agent = array_keys(array_column($log_data, 'user_agent'), $_SERVER['HTTP_USER_AGENT']);
                                    if(isset($unauthorized_access[0]) && !empty($unauthorized_access[0])) {
                                        $this->session->setFlashdata('msg', 'Unauthorized Access.');
                                        return response()->redirect(base_url('/'));
                                        exit(0);
                                    }
                                    if(isset($new_login_agent) && empty($new_login_agent)) {
                                        $subject = 'New Login Detection on eFiling application';
                                        $Mail_message = 'We detected a login into your account from a new device on ' . date('d-m-Y') . ' at ' . date("h:i:s A") . "<br>Device: <b>" . $this->Login_device . '</b><br>IP Address: <b>' . getClientIP() . '</b><br>User Agent: <b>' . $_SERVER['HTTP_USER_AGENT'] . '</b><br>If you think that somebody logged in to your account against your will, you can block it from your profile on  efiling portal.';
                                    }
                                }
                            } else{
                                $subject = 'New Login Detection on eFiling application';
                                $Mail_message = 'We detected a login into your account from a new device on ' . date('d-m-Y') . ' at ' . date("h:i:s A") . "<br>Device: <b>" . $this->Login_device . '</b><br>IP Address: <b>' . getClientIP() . '</b><br>User Agent: <b>' . $_SERVER['HTTP_USER_AGENT'] . '</b><br>If you think that somebody logged in to your account against your will, you blocked it from your profile on  efiling portal.';
                                // send_mail_msg($row[0]->emailid, $subject, $Mail_message, $user_name);
                            }
                            $pg_request_function = $row[0]->pg_request_function;
                            $pg_response_function = $row[0]->pg_response_function;
                            $admin_estab_code = $row[0]->estab_code;
                            $logindata = array(
                                'id' => $row[0]->id,
                                'userid' => $row[0]->userid,
                                'ref_m_usertype_id' => $row[0]->ref_m_usertype_id,
                                'first_name' => $row[0]->first_name,
                                'last_name' => $row[0]->last_name,
                                'mobile_number' => $row[0]->moblie_number,
                                'emailid' => $row[0]->emailid,
                                'adv_sci_bar_id' => $row[0]->adv_sci_bar_id,
                                'aor_code' => $row[0]->aor_code,
                                'bar_reg_no' => $row[0]->bar_reg_no,
                                'gender' => $row[0]->gender,
                                'pg_request_fun' => $pg_request_function,
                                'pg_response_fun' => $pg_response_function,
                                'photo_path' => $row[0]->photo_path,
                                'login_active_session' => substr(number_format(time() * rand(), 0, '', ''), 0, 6),
                                'admin_for_type_id'=>$row[0]->admin_for_type_id,
                                'admin_for_id' =>$row[0]->admin_for_id,
                                'account_status' => $row[0]->account_status,
                                'refresh_token' => $row[0]->refresh_token,
                                //'dep_flag' => $row[0]->dep_flag,
                                //'case_flag' => $row[0]->case_flag,
                                //'doc_flag' => $row[0]->doc_flag,
                                //'efiling_flag' => $row[0]->efiling_flag,
                                //'dep_adv_flag' => $row[0]->dep_adv_flag,
                                'impersonator_user' => $impersonator_user,//for efiling_assistant
                                'processid' => getmypid(),
                                'department_id' => $row[0]->ref_department_id,
                                'icmis_usercode' => $row[0]->icmis_usercode
                            );
                            $sessiondata = array(
                                'login' => $logindata
                            );
                            $this->session->set($sessiondata);
                            $this->logUser('login', $logindata);
                            $this->redirect_on_login();
                        } else{
                            $this->session->setFlashdata('msg', 'Invalid username or password !');
                            return response()->redirect(base_url('/'));
                            exit(0);
                        }
                    } else{
                        $this->session->setFlashdata('msg', 'Invalid username or password !');
                        return response()->redirect(base_url('/'));
                        exit(0);
                    }
                }
            } else{
                $this->session->setFlashdata('login_salt', $this->generateRandomString());
                return $this->render('responsive_variant.authentication.frontLogin');
            }
        }
    }else{
        $rules=[
            "using" => [
                "label" => "Aor Code and Aor Mobile",
                "rules" => "required|trim"
            ],
            "you_email" => [
                "label" => "your Email",
                "rules" => "required|trim"
            ],
            "yr_mobile" => [
                "label" => "Your Mobile No.",
                "rules" => "required|trim"
            ],
            
            
        ];
        $data['userEnteredData']=array('using'=>$this->request->getPost('using'),'you_email'=>$this->request->getPost('you_email'),'yr_mobile'=>$this->request->getPost('yr_mobile'));
        if($this->request->getPost('using')=='AOR Mobile'){
           $rules['aor_mobile']=[
                "label" => "AOR Mobile",
                "rules" => "required|trim"
                 ];
                 $data['userEnteredData']['aor_mobile']=$this->request->getPost('aor_mobile');
        }else{
            $rules['aor_code']=[
                "label" => "AOR Code",
                "rules" => "required|trim"
            ];
            $data['userEnteredData']['aor_code']=$this->request->getPost('aor_code');
        }
        
        if ($this->validate($rules) === FALSE) {
            $data = [
                'validation' => $this->validator,
                'currentPath' => $this->slice->getSegment(1) ?? 'public',
            ];
            $this->session->set('login_salt', $this->generateRandomString());
            $data['using']=$this->request->getPost('using');
            $data['aor_flag']='yes';
            return $this->render('responsive_variant.authentication.frontLogin', $data);
        }else{
            $userCaptcha=$this->request->getPost('userCaptcha');
            $result=$this->ecoping_webservices->getCopyBarcodeBymobileOrAorCOde($this->request->getPost('aor_code'),$this->request->getPost('aor_mobile'));
            $authorizedByAorAdvocateVerification=$this->ecoping_webservices->eCopyingOtpVerification($this->request->getPost('you_email'));
            if ($this->request->getPost('impersonatedUserAuthenticationMobileOtp')){
                
                if ($this->request->getPost('impersonatedUserAuthenticationMobileOtp')== @$_SESSION['impersonated_user_authentication_mobile_otp.'.$result->bar_id]) {
                    unset($_SESSION['impersonated_user_authentication_mobile_otp.'.$result->bar_id]);
                    unset($_SESSION['impersonated_user_authentication_mobile_otp']);
                    // echo "verify Otp";
                    // die;

                    $row = $this->Login_model->get_user_for_ecopy($this->request->getPost('aor_code'),$this->request->getPost('aor_mobile'));
                    if(is_array($row) && !empty($row)){
                        $impersonator_user = $row[0];
                        $logindata = array(
                            'id' => $row[0]->id,
                            'userid' => $row[0]->userid,
                            'ref_m_usertype_id' => AUTHENTICATED_BY_AOR,
                            'first_name' => $row[0]->first_name,
                            'last_name' => $row[0]->last_name,
                            'mobile_number' => $row[0]->moblie_number,
                            'emailid' => $row[0]->emailid,
                            'adv_sci_bar_id' => $row[0]->adv_sci_bar_id,
                            'aor_code' => $row[0]->aor_code,
                            'bar_reg_no' => $row[0]->bar_reg_no,
                            'gender' => $row[0]->gender,
                            'pg_request_fun' => null,
                            'pg_response_fun' => null,
                            'photo_path' => $row[0]->photo_path,
                            'login_active_session' => substr(number_format(time() * rand(), 0, '', ''), 0, 6),
                            'admin_for_type_id'=>$row[0]->admin_for_type_id,
                            'admin_for_id' =>$row[0]->admin_for_id,
                            'account_status' => $row[0]->account_status,
                            'refresh_token' => $row[0]->refresh_token,
                            'impersonator_user' => $impersonator_user,//for efiling_assistant
                            'processid' => getmypid(),
                            'department_id' => $row[0]->ref_department_id,
                            'icmis_usercode' => $row[0]->icmis_usercode
                        );
                    } else {
                        $logindata = array(
                            'id' => null,
                            'userid' => $this->request->getPost('aor_code'),
                            'ref_m_usertype_id' => AUTHENTICATED_BY_AOR,
                            'first_name' => $result->name,
                            'last_name' => null,
                            'mobile_number' => $result->mobile,
                            'emailid' => $result->email,
                            'adv_sci_bar_id' => $result->bar_id,
                            'aor_code' => $this->request->getPost('aor_code'),
                            'bar_reg_no' => $result->bar_id,
                            'gender' => $result->sex,
                            'pg_request_fun' => null,
                            'pg_response_fun' => null,
                            'photo_path' => null,
                            'login_active_session' => substr(number_format(time() * rand(), 0, '', ''), 0, 6),
                            'admin_for_type_id'=>null,
                            'admin_for_id' =>null,
                            'account_status' => null,
                            'refresh_token' => null,
                            'impersonator_user' => [],
                            'processid' => getmypid(),
                            'department_id' => null,
                            'icmis_usercode' => $result->bar_id
                        );
                    }
                    $sessiondata = array(
                        'login' => $logindata
                    );
                    $this->session->set($sessiondata);
                    $this->logUser('login', $logindata);
                    $this->redirect_on_login();
                    //$row = $this->Login_model->get_user($user_parts[1], null, true, false);
                }else{
                    $data['using']=$this->request->getPost('using');
                    $data['aor_flag']='yes';
                    $this->session->setFlashdata('msg', 'OTP Not Matched');
                    return $this->render('responsive_variant.authentication.frontLogin', $data);
                }
                
                //$row = $this->Login_model->get_user($user_parts[1], null, true, false);
            }elseif(!empty($result)){
                $data['aor_flag']='yes';
                $this->session->setFlashdata('msg', 'OTP has been Sent on Your Registered Mobile No.');
                $data['aor_flag']='yes';
                $data['bar_id']=$result->bar_id;
                $data['using']=$this->request->getPost('using');
                if ($this->session->get('captcha') != $userCaptcha) {
                    $this->session->setFlashdata('msg', 'Invalid Captcha!');
                    
                }else{
                    if($authorizedByAorAdvocateVerification->email==$this->request->getPost('you_email') && $authorizedByAorAdvocateVerification->mobile==$this->request->getPost('yr_mobile')){
                       //$impersonated_user_authentication_mobile_otp = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
                    $impersonated_user_authentication_mobile_otp =123456;
                    //@sendSMS(38, $result['mobile'],"Advocate ON Record",SCISMS_e_copying_login);
                    $_SESSION['impersonated_user_authentication_mobile_otp.'.$result->bar_id] = $impersonated_user_authentication_mobile_otp;
                    $message='Authentication OTP for AOR is: ' . $impersonated_user_authentication_mobile_otp.'. - Supreme Court of India';
                    $_SESSION['impersonated_user_authentication_mobile_otp'] = $impersonated_user_authentication_mobile_otp;
                    $this->session->setFlashdata('msg', 'OTP has been Sent on Your Registered Mobile No.');
                    }else{
                        $this->session->setFlashdata('msg', 'Wrong your Email and Mobile');   
                    }
                     
                    
                }
                return $this->render('responsive_variant.authentication.frontLogin', $data);
                //send_mail_msg($email,'Authentication OTP for eFiling' ,$message, $user_parts[1]);
                //$result=$this->ecoping_webservices->getUserAddress($this->request->getPost('yr_mobile'),$this->request->getPost('you_email'));
            }else{
                $this->session->setFlashdata('msg', 'AOR Mobile No. OR AOR code Does Not Match');
                $data['aor_flag']='no';
                $data['using']=$this->request->getPost('using');
                return $this->render('responsive_variant.authentication.frontLogin', $data);
            }
        }    
    }
    }

    public function otp() {
        $username = $this->session->get('login_cred')['user_name'];
        $password = $this->session->get('login_cred')['password'];
        $otp = $this->request->getPost('otp_one').$this->request->getPost('otp_two').$this->request->getPost('otp_three').$this->request->getPost('otp_four').$this->request->getPost('otp_five').$this->request->getPost('otp_six');
        $checkotp = $this->Login_model->check_otp($username, $password, $otp);
        if($checkotp){
            $row = $this->Login_model->get_user($username, $password); 
            $impersonator_user = new stdClass();
            if ($row) {
                $impersonator_user = $row[0];
                $usr_block = $this->Login_model->get_user_block_dtl($row[0]->id);
                if(!empty($usr_block)) {
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
                $user_name = ucwords($row[0]->first_name . ' ' . $row[0]->last_name);
                //Check user role
                if(logged_in_check_user_type($row[0]->ref_m_usertype_id)){
                    $this->session->setFlashdata('msg', 'You are not authorized !!');
                    return response()->redirect(base_url('/'));
                    exit(0);
                }
                $usr_block_update = $this->Login_model->get_user_block_dtl_update($row[0]->id);
                $log_data = $this->Login_model->get_user_login_log_details($row[0]->id);
                if ($log_data) {
                    foreach ($log_data as $resdata) {
                        $unauthorized_access = array_keys(array_column($log_data, 'block'), 't');
                        $new_login_agent = array_keys(array_column($log_data, 'user_agent'), $_SERVER['HTTP_USER_AGENT']);
                        if(isset($unauthorized_access[0]) && !empty($unauthorized_access[0])) {
                            $this->session->setFlashdata('msg', 'Unauthorized Access.');
                            return response()->redirect(base_url('/'));
                            exit(0);
                        }
                        if(isset($new_login_agent) && empty($new_login_agent)) {
                            $subject = 'New Login Detection on eFiling application';
                            $Mail_message = 'We detected a login into your account from a new device on ' . date('d-m-Y') . ' at ' . date("h:i:s A") . "<br>Device: <b>" . $this->Login_device . '</b><br>IP Address: <b>' . getClientIP() . '</b><br>User Agent: <b>' . $_SERVER['HTTP_USER_AGENT'] . '</b><br>If you think that somebody logged in to your account against your will, you can block it from your profile on  efiling portal.';
                        }
                    }
                } else{
                    $subject = 'New Login Detection on eFiling application';
                    $Mail_message = 'We detected a login into your account from a new device on ' . date('d-m-Y') . ' at ' . date("h:i:s A") . "<br>Device: <b>" . $this->Login_device . '</b><br>IP Address: <b>' . getClientIP() . '</b><br>User Agent: <b>' . $_SERVER['HTTP_USER_AGENT'] . '</b><br>If you think that somebody logged in to your account against your will, you blocked it from your profile on  efiling portal.';
                    // send_mail_msg($row[0]->emailid, $subject, $Mail_message, $user_name);
                }
                $pg_request_function = $row[0]->pg_request_function;
                $pg_response_function = $row[0]->pg_response_function;
                $admin_estab_code = $row[0]->estab_code;
                $logindata = array(
                    'id' => $row[0]->id,
                    'userid' => $row[0]->userid,
                    'ref_m_usertype_id' => $row[0]->ref_m_usertype_id,
                    'first_name' => $row[0]->first_name,
                    'last_name' => $row[0]->last_name,
                    'mobile_number' => $row[0]->moblie_number,
                    'emailid' => $row[0]->emailid,
                    'adv_sci_bar_id' => $row[0]->adv_sci_bar_id,
                    'aor_code' => $row[0]->aor_code,
                    'bar_reg_no' => $row[0]->bar_reg_no,
                    'gender' => $row[0]->gender,
                    'pg_request_fun' => $pg_request_function,
                    'pg_response_fun' => $pg_response_function,
                    'photo_path' => $row[0]->photo_path,
                    'login_active_session' => substr(number_format(time() * rand(), 0, '', ''), 0, 6),
                    'admin_for_type_id'=>$row[0]->admin_for_type_id,
                    'admin_for_id' =>$row[0]->admin_for_id,
                    'account_status' => $row[0]->account_status,
                    'refresh_token' => $row[0]->refresh_token,
                    //'dep_flag' => $row[0]->dep_flag,
                    //'case_flag' => $row[0]->case_flag,
                    //'doc_flag' => $row[0]->doc_flag,
                    //'efiling_flag' => $row[0]->efiling_flag,
                    //'dep_adv_flag' => $row[0]->dep_adv_flag,
                    'impersonator_user' => $impersonator_user,//for efiling_assistant
                    'processid' => getmypid(),
                    'department_id' => $row[0]->ref_department_id
                );
                $sessiondata = array(
                    'login' => $logindata
                );
                $this->session->set($sessiondata);
                $this->logUser('login', $logindata);
                $this->redirect_on_login();
            } else{
                $this->session->setFlashdata('msg', 'Invalid username or password !');
                return response()->redirect(base_url('/'));
                exit(0);
            }
        } else{
            $this->session->setFlashdata('msg', 'OTP Not matched !');
            return response()->redirect(base_url('/'));
            exit(0);
        }
    }

    function redirect_on_login() {
        if (!empty($this->session->get('login')) && $this->session->get('login')['ref_m_usertype_id'] == USER_SUPER_ADMIN) {
            return response()->redirect("superAdmin");
            exit();
        } elseif (!empty($this->session->get('login')) && $this->session->get('login')['ref_m_usertype_id'] == USER_DISTRICT_ADMIN) {
            return response()->redirect("adminDashboard/work_done");
            exit();
        } elseif (!empty($this->session->get('login')) && $this->session->get('login')['ref_m_usertype_id'] == USER_MASTER_ADMIN) {
            return response()->redirect("adminDashboard/work_done");
            exit();
        } elseif ((!empty($this->session->get('login')) && $this->session->get('login')['ref_m_usertype_id'] == USER_ADMIN) || (!empty($this->session->get('login')) && $this->session->get('login')['ref_m_usertype_id'] == USER_ACTION_ADMIN)) {
            return response()->redirect("adminDashboard");
            exit();
        } elseif (!empty($this->session->get('login')) && $this->session->get('login')['ref_m_usertype_id'] == USER_DEPARTMENT) {
            return response()->redirect('mycases/updation');
            exit(0);
        } elseif (!empty($this->session->get('login')) && $this->session->get('login')['ref_m_usertype_id'] == USER_CLERK) {
            return response()->redirect('dashboard_alt');
            exit(0);
        } elseif (!empty($this->session->get('login')) && $this->session->get('login')['ref_m_usertype_id'] == USER_BAR_COUNCIL) {
            return response()->redirect('Bar_council');
            exit(0);
        } elseif (!empty($this->session->get('login')) && $this->session->get('login')['ref_m_usertype_id'] == JAIL_SUPERINTENDENT) {
            return response()->redirect('jail_dashboard');
            exit(0);
        } else if (!empty($this->session->get('login')) && $this->session->get('login')['ref_m_usertype_id'] == USER_EFILING_ADMIN) {
            return response()->redirect("filingAdmin");
            exit();
        } else if (!empty($this->session->get('login')) && $this->session->get('login')['ref_m_usertype_id'] == USER_ADVOCATE) {
            return response()->redirect("dashboard_alt");
            exit();
        }
        else if (!empty($this->session->get('login')) && $this->session->get('login')['ref_m_usertype_id'] == AUTHENTICATED_BY_AOR) {
            return response()->redirect("ecopying_dashboard");
            exit();
        }
        /* elseif ($this->session->userdata['login']['account_status'] == ACCOUNT_STATUS_PENDING_APPROVAL || $this->session->userdata['login']['account_status'] == ACCOUNT_STATUS_OBJECTION || $this->session->userdata['login']['account_status'] == ACCOUNT_STATUS_REJECTED || $this->session->userdata['login']['account_status'] == ACCOUNT_STATUS_DEACTIVE || $this->session->userdata['login']['bar_approval_status'] == BAR_APPROVAL_STATUS_ON_HOLD || $this->session->userdata['login']['bar_approval_status'] == BAR_APPROVAL_STATUS_DEACTIVATED) {
            redirect('profile');
            exit(0);
        } */
        else{
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

    public function notFound() {
        return view('errors/html/error_404');
    }
    
    public function internalServerError() {
        return view('errors/html/error_500');
    }

}