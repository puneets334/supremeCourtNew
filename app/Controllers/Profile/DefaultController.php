<?php

namespace App\Controllers\Profile;

use App\Controllers\BaseController;
use App\Models\AdjournmentLetter\AdjournmentModel;
use App\Models\AdminDashboard\StageListModel;
use App\Models\Common\CommonModel;
use App\Models\Register\RegisterModel;
use App\Models\Common\DropdownListModel;
use App\Models\Common\CommonLoginModel;
use App\Models\Profile\ProfileModel;
use App\Libraries\AutoSanitize;
use stdClass;

class DefaultController extends BaseController
{

    protected $Adjournment_model;
    protected $Stageslist_model;
    protected $Common_model;
    protected $Register_model;
    protected $Dropdown_list_model;
    protected $Common_login_model;
    protected $Profile_model;
    protected $session;
    protected $db;
    protected $slice;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->slice = [];
        parent::__construct();
        if (empty($this->session->get('login'))) {
            return response()->redirect(base_url('/'));
            exit(0);
        } else {
            is_user_status();
        }
        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT, USER_ADMIN, USER_ADMIN_READ_ONLY, USER_EFILING_ADMIN, SR_ADVOCATE, ARGUING_COUNSEL, USER_SUPER_ADMIN);
        if (!in_array($this->session->get('login')['ref_m_usertype_id'], $allowed_users_array)) {
            return response()->redirect(base_url('/'));
            exit(0);
        }
        $this->Adjournment_model = new AdjournmentModel();
        $this->Stageslist_model = new StageListModel();
        $this->Common_model = new CommonModel();
        $this->Register_model = new RegisterModel();
        $this->Dropdown_list_model = new DropdownListModel();
        $this->Common_login_model = new CommonLoginModel();
        $this->Profile_model = new ProfileModel();
        $this->db = \Config\Database::connect();
    }

    public function cryptoJsAesDecrypt($passphrase, $jsonString)
    {
        $jsondata = json_decode($jsonString, true);
        try {
            $salt = $this->hex2bin($jsondata["s"]);
            $iv  = $this->hex2bin($jsondata["iv"]);
        } catch (\Exception $e) {
            return null;
        }
        $ct = base64_decode($jsondata["ct"]);
        $concatedPassphrase = $passphrase . $salt;
        $md5 = array();
        $md5[0] = md5($concatedPassphrase, true);
        $result = $md5[0];
        for ($i = 1; $i < 3; $i++) {
            $md5[$i] = md5($md5[$i - 1] . $concatedPassphrase, true);
            $result .= $md5[$i];
        }
        $key = substr($result, 0, 32);
        $data = openssl_decrypt($ct, 'aes-256-cbc', $key, true, $iv);
        return json_decode($data, true);
    }

    private function hex2bin($hexdata)
    {
        $bindata = '';
        for ($i = 0; $i < strlen($hexdata); $i += 2) {
            $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
        }
        return $bindata;
    }

    /**
     * Encrypt value to a cryptojs compatiable json encoding string
     *
     * @param mixed $passphrase
     * @param mixed $value
     * @return string
     */
    function cryptoJsAesEncrypt($passphrase, $value)
    {
        $salt = openssl_random_pseudo_bytes(8);
        $salted = '';
        $dx = '';
        while (strlen($salted) < 48) {
            $dx = md5($dx . $passphrase . $salt, true);
            $salted .= $dx;
        }
        $key = substr($salted, 0, 32);
        $iv  = substr($salted, 32, 16);
        $encrypted_data = openssl_encrypt(json_encode($value), 'aes-256-cbc', $key, true, $iv);
        $data = array("ct" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "s" => bin2hex($salt));
        return json_encode($data);
    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function index()
    {
        $session = session();
        $session->remove('data_arrays');
        if ($session->get('login')) {
            $data = [];
            $data['AOR'] = [];
            $aor_code = (int) $session->get('login')['aor_code'];
            $session->remove('email_id_for_updation');
            $session->remove('mobile_no_for_updation');
            // pr($_SESSION);
            $data['high_court_list'] = $this->Dropdown_list_model->get_high_court_list();
            $data['profile'] = $this->Profile_model->getProfileDetail($session->get('login')['userid']);
            $user_type_id = session()->get('login.ref_m_usertype_id');
            $aor_code = session()->get('login.aor_code');
            $data['user_type_id'] = $user_type_id;
            $data['aor_code'] = $aor_code;
            $header_view = ($_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON || $_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE || $_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK || $_SESSION['login']['ref_m_usertype_id'] == SR_ADVOCATE) ? 'templates/header' : 'templates/admin_header';
            return $this->render('profile.profile_view', $data);
        } else {
            return redirect()->to('login');
        }
    }

    public function updateProfile($param)
    {
        helper('captcha_helper');
        $session = session();
        if ($session->get('login')) {
            $data['updatedata'] = $param;
            if (!in_array($param, array('email', 'contact', 'other', 'address', 'pass', 'estab'))) {
                return redirect()->to('profile');
            }
            $data['state_list'] = $this->Register_model->get_state_list();
            $data['profile'] = $this->Profile_model->getProfileDetail($session->get('login')['userid']);
            $session->set('login_salt', $this->generateRandomString());
            return $this->render('profile.profile_update_view', $data);
        } else {
            return redirect()->to('login');
        }
    }

    function valid_password($password = '')
    {
        $password = trim($password);
        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>ยง~]/';
        if (empty($password)) {
            return FALSE;
        }
        if (preg_match_all($regex_lowercase, $password) < 1) {
            return FALSE;
        }
        if (preg_match_all($regex_uppercase, $password) < 1) {
            return FALSE;
        }
        if (preg_match_all($regex_number, $password) < 1) {
            return FALSE;
        }
        if (preg_match_all($regex_special, $password) < 1) {
            return FALSE;
        }
        if (strlen($password) < 8) {
            return FALSE;
        }
        if (strlen($password) > 32) {
            return FALSE;
        }
        return TRUE;
    }

    public function decodeData($pass, $data)
    {
        for ($i = 0; $i < 10; $i++) {
            $data = $this->cryptoJsAesDecrypt($pass, $data);
        }
        $dataArray = explode('hgtsd12@_hjytr', $data);
        return $dataArray[0];
    }

    public function updatePass()
    {
        helper(['form', 'url']);
        $session = session();
        // $profileModel = new ProfileModel();
        if ($session->get('login')) {
            $currentpass = esc($this->request->getPost("currentpass"));
            $newpass = esc($this->request->getPost("newpass"));
            $confirmpass = esc($this->request->getPost("confirmpass"));
            $x = explode($session->get('login_salt'), $newpass);
            $y = explode($session->get('login_salt'), $confirmpass);
            $newpass = $x[0];
            $confirmpass = $y[0];
            $rules = [
                'currentpass' => [
                    'label' => 'Current Password',
                    'rules' => 'trim|required'
                ],
                'newpass' => [
                    'label' => 'New Password',
                    'rules' => 'trim|required'
                ],
                'confirmpass' => [
                    'label' => 'Confirm Password',
                    'rules' => 'trim|required'
                ]
            ];
            if ($this->validate($rules)) {
                $password = str_replace("'", "", $this->request->getPost('txt_password'));
                $salt = $this->request->getPost('salt');
                $decoded_password = $this->decodeData($salt, $password);
                if (!$this->valid_password($decoded_password)) {
                    $session->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible text-center flashmessage">Password policy has to be followed.</div>');
                    return redirect()->to(base_url('profile/updateProfile/pass'));
                }
                $current_password = $this->Profile_model->selectPassword($session->get('login')['userid']);
                if ($current_password[0]->password . $session->get('login_salt') == $currentpass) {
                    if ($newpass . $session->get('login_salt') != $password) {
                        if ($newpass == $confirmpass) {
                            $resultCheck = $this->Profile_model->selectPasswordCheck($session->get('login')['id'], $newpass);
                            if (!$resultCheck) {
                                $this->Profile_model->updatePasswordCheck($session->get('login')['id'], $newpass);
                                $this->Profile_model->updatePassword($session->get('login')['userid'], $newpass);
                                $session->setFlashdata('msg', '<div class="alert alert-success alert-dismissible text-center flashmessage">Password Updated!</div>');
                                return redirect()->to(base_url('logout'));
                            } else {
                                $session->setFlashdata('msg', '<div class="alert alert-danger text-center flashmessage" data-auto-dismiss="9000">Entered new password was already used earlier, please enter different password.</div>');
                                return redirect()->to(base_url('profile/updateProfile/pass'));
                            }
                        } else {
                            $session->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible text-center flashmessage">Confirm Password does not match!</div>');
                            return redirect()->to(base_url('profile/updateProfile/pass'));
                        }
                    } else {
                        $session->setFlashdata('msg', '<div class="alert alert-danger text-center flashmessage" data-auto-dismiss="9000">New password should not be same as current password!</div>');
                        return redirect()->to(base_url('profile/updateProfile/pass'));
                    }
                } else {
                    $session->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible text-center flashmessage">Invalid Current Password!</div>');
                    return redirect()->to(base_url('profile/updateProfile/pass'));
                }
            } else {
                $data['profile'] = $this->Profile_model->getProfileDetail($session->get('login')['userid']);
                $data['updatedata'] = 'pass';
                return $this->render('profile.profile_update_view', $data);
            }
        } else {
            return redirect()->to('login');
        }
    }

    public function updateEmail()
    {
        if ($this->session->userdata['login']) {
            $emailid = escape_data($this->request->getPost("emailid"));
            $email_pattern = "/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/";
            if (!preg_match($email_pattern, $emailid)) {
                $this->session->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible text-center flashmessage">Wrong email address !!</div>');
                redirect('profile/DefaultController/updateProfile/email');
            }
            $check_email = $this->Common_login_model->check_email_already_present(strtoupper($emailid));
            if ($check_email) {
                $this->session->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible text-center flashmessage">This email id already registered !</div>');
                redirect('profile/DefaultController/updateProfile/email');
            }
            //set validations
            $this->form_validation->set_rules("emailid", "Email Id", "trim|required|valid_email");
            if ($this->form_validation->run() == TRUE) {
                //validation succeeds
                if (isset($_POST['update_email'])) {
                    $previous_emailid = $this->Profile_model->selectEmail($_SESSION['login']['userid']);
                    if ($previous_emailid[0]->emailid != $emailid) {
                        $rand = rand(111111, 999999);
                        //session otp storage
                        $login = getSessionData('login');
                        $login['email_otp'] = $rand;
                        setSessionData('login', $login);
                        $data['email_otp'] = $rand;
                        $data['emailid'] = $emailid;
                        setSessionData('email_id_for_updation', $emailid);
                        $subject = 'Validate your email with eFiling application';
                        $Mail_message = 'Your OTP is ' . $rand . ' to validate new email-id with eFiling applications.';
                        $user_name = $_SESSION['login']['first_name'] . " " . $_SESSION['login']['last_name'];
                        send_mail_msg($emailid, $subject, $Mail_message, $user_name);
                        if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE || $_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON || $_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
                            $this->load->view('templates/header');
                        } else {
                            $this->load->view('templates/admin_header');
                        }
                        $this->load->view('profile/profile_update_view', $data);
                        $this->load->view('templates/footer');
                    } else {
                        $this->session->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible text-center flashmessage">Enter different email Id!</div>');
                        redirect('profile');
                    }
                }
            } else {
                $data['profile'] = $this->Profile_model->getProfileDetail($this->session->userdata['login']['userid']);
                $data['updatedata'] = 'email';
                if ($_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON || $_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE || $_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
                    $this->load->view('templates/header');
                } else {
                    $this->load->view('templates/admin_header');
                }
                $this->load->view('profile/profile_update_view', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('login');
        }
    }

    public function updateContact()
    {
        if ($this->session->userdata['login']) {
            $mobile_number = escape_data($this->request->getPost("moblie_number"));
            if (!isset($mobile_number)) {
                redirect('login');
            }
            if (!preg_match("/^[0-9]{10}$/", $mobile_number)) {
                $this->session->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible text-center flashmessage">Wrong contact number !!</div>');
                redirect('profile/DefaultController/updateProfile/contact');
            }
            $check_mobno = $this->Common_login_model->check_mobno_already_present(strtoupper($mobile_number));
            if ($check_mobno) {
                $this->session->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible text-center flashmessage">This mobile number already registered !</div>');
                redirect('profile/DefaultController/updateProfile/contact');
            }
            $this->form_validation->set_rules("moblie_number", "Contact", "trim|required|numeric|min_length[10]|max_length[10]");
            if ($this->form_validation->run() == TRUE) {
                //validation succeeds
                if (isset($_POST['moblie_number'])) {
                    $previous_mobile_number = $this->Profile_model->selectContact($_SESSION['login']['userid']);
                    if ($previous_mobile_number[0]->moblie_number != $mobile_number) {
                        $rand = rand(111111, 999999);
                        //session otp storage
                        $login = getSessionData('login');
                        $login['mobile_otp'] = $rand;
                        setSessionData('login', $login);
                        setSessionData('mobile_no_for_updation', $mobile_number);
                        $data['mobile_otp'] = $rand;
                        $data['moblie_number'] = $mobile_number;
                        $sentSMS = "OTP is " . $rand . " to validate your new mobile no. with eFiling application. - Supreme Court of India";
                        $responseObj = send_mobile_sms($mobile_number, $sentSMS, SCISMS_New_Mobile_No_Validation);
                        $user_name = $this->session->userdata['login']['first_name'] . ' ' . $this->session->userdata['login']['last_name'];
                        $this->load->view('templates/header');
                        $this->load->view('profile/profile_update_view', $data);
                        $this->load->view('templates/footer');
                    } else {
                        $this->session->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible text-center flashmessage">Enter different Contact!</div>');
                        redirect('profile');
                    }
                }
            } else {
                $data['profile'] = $this->Profile_model->getProfileDetail($this->session->userdata['login']['userid']);
                $data['updatedata'] = 'contact';
                if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE || $_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON || $_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
                    $this->load->view('templates/header');
                } else {
                    $this->load->view('templates/admin_header');
                }
                $this->load->view('profile/profile_update_view', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('login');
        }
    }

    public function updateOther()
    {
        if ($this->session->userdata['login']) {
            $other_contact_number = escape_data($this->request->getPost("other_contact_number"));
            if (!preg_match("/^[0-9]{10}$/", $other_contact_number)) {
                $this->session->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible text-center flashmessage">Other contact number should be 10 digit !</div>');
                redirect('profile/DefaultController/updateProfile/other');
            }
            $this->form_validation->set_rules("other_contact_number", "Other Contact No.", "trim|numeric|min_length[10]|max_length[10]");
            if ($this->form_validation->run() == TRUE) {
                //validation succeeds
                if (isset($_POST['update_other'])) {
                    $previous_other_contact_number = $this->Profile_model->selectOtherContact($this->session->userdata['login']['userid']);
                    if ($previous_other_contact_number[0]->other_contact_number != $other_contact_number) {
                        $this->Profile_model->updateOtherContact($this->session->userdata['login']['userid'], $other_contact_number);
                        $this->session->setFlashdata('msg', '<div class="alert alert-success alert-dismissible text-center flashmessage">Other Contact No. Updated successfully !</div>');
                        redirect('profile');
                    } else {
                        $this->session->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible text-center flashmessage">Enter different Contact!</div>');
                        redirect('profile/DefaultController/updateProfile/other');
                    }
                }
            } else {
                $data['profile'] = $this->Profile_model->getProfileDetail($this->session->userdata['login']['userid']);
                $data['updatedata'] = 'other';
                if ($_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON || $_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE || $_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
                    $this->load->view('templates/header');
                } else {
                    $this->load->view('templates/admin_header');
                }
                $this->load->view('profile/profile_update_view', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('login');
        }
    }

    public function updateAddress()
    {
        if ($this->session->userdata['login']) {
            $data['address1'] = escape_data($this->request->getPost("address1"));
            $data['address2'] = escape_data($this->request->getPost("address2"));
            $data['city'] = escape_data($this->request->getPost("city"));
            $data['pincode'] = escape_data($this->request->getPost("pincode"));
            if (!empty($this->request->getPost("ref_m_states_id"))) {
                $data['ref_m_states_id'] = escape_data(url_decryption($this->request->getPost("ref_m_states_id")));
            } else {
                $district_id = explode("#$", url_decryption($_POST['njdg_m_dist_id']));
                $ref_m_states_id = explode("#$", url_decryption($_POST['njdg_m_states_id']));
                $data['njdg_dist_id'] = $district_id[0];
                $data['njdg_dist_name'] = $district_id[1];
                $data['njdg_st_id'] = $ref_m_states_id[0];
                $data['njdg_st_name'] = $ref_m_states_id[1];
            }
            $this->form_validation->set_rules("address1", "Address1", "trim|required|max_length[101]|regex_match[/^[a-z0-9.:,-_ ]+$/]");
            $this->form_validation->set_rules("address2", "Address2", "trim|max_length[101]|regex_match[/^[a-z0-9.:,-_ ]+$/]");
            $this->form_validation->set_rules("city", "City", "trim|required|alpha_numeric_spaces|max_length[101]");
            $this->form_validation->set_rules("pincode", "Pincode", "trim|required|numeric|min_length[6]|max_length[6]");
            if ($this->form_validation->run() == TRUE) {
                $this->Profile_model->updateAddress($this->session->userdata['login']['userid'], $data);
                $this->session->setFlashdata('msg', '<div class="alert alert-success alert-dismissible text-center flashmessage">Address Updated successfully !</div>');
                redirect('profile');
            } else {
                $data['profile'] = $this->Profile_model->getProfileDetail($this->session->userdata['login']['userid']);
                $data['updatedata'] = 'address';
                if ($_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON || $_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE || $_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
                    $this->load->view('templates/header');
                } else {
                    $this->load->view('templates/admin_header');
                }
                $this->load->view('profile/profile_update_view', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('login');
        }
    }

    public function emailSave()
    {
        if ($this->session->userdata['login']) {
            if (isset($_POST['email_save'])) {
                $emailid = escape_data(getSessionData('email_id_for_updation'));
                $otp = escape_data($this->request->getPost("email_otp"));
                if (!preg_match("/^[0-9]*$/", $otp)) {
                    $this->session->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible text-center flashmessage">Wrong OTP !!</div>');
                    redirect('profile');
                }
                if ($otp == $this->session->userdata['login']['email_otp']) {
                    $this->Profile_model->updateEmail($this->session->userdata['login']['userid'], $emailid);
                    $this->session->destroy('email_otp');
                    $this->session->destroy('email_id_for_updation');
                    $this->session->setFlashdata('msg', '<div class="alert alert-success alert-dismissible text-center flashmessage">Email Updated successfully !</div>');
                    redirect('profile');
                } else {
                    $this->session->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible text-center flashmessage">Invalid OTP!</div>');
                    redirect('profile');
                }
            }
        } else {
            redirect('login');
        }
    }

    public function mobileSave()
    {
        if ($this->session->userdata['login']) {
            if (isset($_POST['mobile_save'])) {
                $mobile_number = escape_data(getSessionData('mobile_no_for_updation'));
                $otp = $this->request->getPost("mobile_otp");
                if ($otp == $this->session->userdata['login']['mobile_otp']) {
                    $result = $this->Profile_model->updateContact($this->session->userdata['login']['userid'], $mobile_number);
                    if ($result) {
                        $this->session->destroy('mobile_otp');
                        $this->session->destroy('mobile_no_for_updation');
                        $this->session->setFlashdata('msg', '<div class="alert alert-success alert-dismissible text-center flashmessage">Contact Updated successfully!</div>');
                        redirect('profile');
                    } else {
                        $this->session->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible text-center flashmessage">Updation Failed! Contact may be exist!</div>');
                        redirect('profile');
                    }
                } else {
                    $this->session->setFlashdata('msg', '<div class="alert alert-danger alert-dismissible text-center flashmessage">Invalid OTP!</div>');
                    redirect('profile');
                }
            }
        } else {
            redirect('login');
        }
    }

    function uploadPhoto()
    {
        $upload_id_bar = $_POST['edit_new_adv_idproof'];
        $update_profile = $_POST['profile_pic_upload_id'];
        ///------START : Validation For IMAGE-------//
        if ($_FILES["advocate_image"]['type'] != 'image/jpeg') {
            $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center flashmessage">Profile Image Only JPEG/JPG are allowed in document upload !</div>');
            redirect('profile');
            exit(0);
        }
        if (mime_content_type($_FILES["advocate_image"]['tmp_name']) != 'image/jpeg') {
            $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center flashmessage">Profile Image Only JPEG/JPG are allowed in document upload !</div>');
            redirect('profile');
            exit(0);
        }
        if (substr_count($_FILES["advocate_image"]['name'], '.') > 1) {

            $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center flashmessage">Profile Image No double extension allowed in JPEG/JPG !</div>');
            redirect('profile');
            exit(0);
        }
        if (preg_match("/[^0-9a-zA-Z\s.,-_ ]/i", $_FILES["advocate_image"]['name'])) {

            $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center flashmessage">Profile Image JPEG/JPG file name max. length can be 45 characters only. JPEG/JPG file name may contain digits, characters, spaces, hyphens and underscores !</div>');
            redirect('profile');
            exit(0);
        }
        if (strlen($_FILES["advocate_image"]['name']) > File_FIELD_LENGTH) {
            $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center flashmessage">Profile Image JPEG/JPG file name max. length can be 45 characters only. JPEG/JPG file name may contain digits, characters, spaces, hyphens and underscores!</div>');
            redirect('profile');
            exit(0);
        }
        if ($_FILES["advocate_image"]['size'] > UPLOADED_FILE_SIZE) {
            $file_size = (UPLOADED_FILE_SIZE / 1024) / 1024;
            $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center flashmessage">Profile Image JPEG/JPG uploaded should be less than ' . $file_size . ' MB!</div>');
            redirect('profile');
            exit(0);
        }
        $new_filename = time() . rand() . ".jpeg";
        if ($_FILES["advocate_id_prof"]['type'] == 'image/jpeg') {
            $new_pdf_extens = ".jpeg";
        }
        if ($_FILES["advocate_id_prof"]['type'] == 'application/pdf') {
            $new_pdf_extens = ".pdf";
        }
        $new_pdf_file_name = time() . rand() . $new_pdf_extens;
        if ($_FILES["advocate_id_prof"]['type'] == 'image/jpeg') {
            $new_bar_pdf_extens = ".jpeg";
        }
        if ($_FILES["advocate_id_prof"]['type'] == 'application/pdf') {
            $new_bar_pdf_extens = ".pdf";
        }
        $new_bar_reg_name = time() . rand() . $new_bar_pdf_extens;
        $this->load->library('upload');
        $photo_file_path = "uploaded_docs/user_images/photo/" . $new_filename;
        $pdf_file_path = "uploaded_docs/user_images/id_proof/" . $new_pdf_file_name;
        $photo_thums_path = "uploaded_docs/user_images/thumbnail/" . $new_filename;
        $bar_reg_certificate_path = "uploaded_docs/user_images/barReg_Certificate/" . $new_bar_reg_name;
        $data = array(
            'profile_photo' => $photo_file_path,
            'profile_thumbnail' => $photo_thums_path,
            'id_proof_photo' => $pdf_file_path,
            'bar_reg_certificate' => $bar_reg_certificate_path
        );

        $id = $_SESSION['inserted_id'];
        $thumb = $this->image_upload('advocate_image', $photo_file_path, $new_filename);
        $upload_pdf = $this->pdf_file_upload('advocate_id_prof', $pdf_file_path, $new_pdf_file_name);
        $upload_pdf_bar_reg = $this->bar_reg_certificate_upload('bar_reg_certificate', $bar_reg_certificate_path, $new_bar_reg_name);

        if (!$thumb) {
            $_SESSION['login']['photo_path'] = $photo_file_path;
            $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center flashmessage">Please Upload Image Is Requerd!</div>');
            redirect('profile');
        } else if ($thumb && $upload_pdf && $upload_pdf_bar_reg) {
            $_SESSION['login']['photo_path'] = $photo_file_path;
            $_SESSION['photo_path'] = $photo_file_path;
            $_SESSION['image_and_id_view'] = $data;
            $_SESSION['profile_photo'] = $update_profile;
            $this->Profile_model->updatePhoto($this->session->userdata['login']['userid'], $photo_file_path);
            $this->session->setFlashdata('msg', '<div class="alert alert-success text-center flashmessage">Successful!</div>');
            redirect('profile');
        } else {
            $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center flashmessage">Updation Failed !</div>');
            redirect('profile');
        }
    }

    function image_upload($images, $file_path, $file_temp_name)
    {
        $thumbnail_path = 'uploaded_docs/user_images/thumbnail/';
        if (!is_dir($thumbnail_path)) {
            $uold = umask(0);
            if (mkdir('uploaded_docs/user_images/thumbnail/', 0777, true)) {
                $html = '<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>';
                write_file($thumbnail_path . '/index.html', $html);
            }
            umask($uold);
        }
        $photo_path = 'uploaded_docs/user_images/photo/';
        if (!is_dir($photo_path)) {
            $uold = umask(0);
            if (mkdir('uploaded_docs/user_images/photo/', 0777, true)) {
                $html = '<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>';
                write_file($thumbnail_path . '/index.html', $html);
            }
            umask($uold);
        }
        $config['upload_path'] = './uploaded_docs/user_images/photo/';
        $config['allowed_types'] = 'jpg|jpeg';
        $config['overwrite'] = TRUE;
        $config['file_name'] = $file_temp_name;
        $this->load->library('upload');
        $this->upload->initialize($config);
        $this->upload->do_upload($images);
        $uploadData = $this->upload->data();
        $filename = $uploadData['file_name'];
        $data['picture'] = $filename;
        $this->_generate_thumbnail($filename);
        return $data;
    }

    function _generate_thumbnail($picture)
    {
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'uploaded_docs/user_images/photo/' . $picture;
        $config['new_image'] = 'uploaded_docs/user_images/thumbnail/' . $picture;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 150;
        $config['height'] = 150;
        $this->load->library('image_lib', $config);
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        return true;
    }

    function pdf_file_upload($images, $file_path, $new_pdf_file_name)
    {
        $id_path = 'uploaded_docs/user_images/id_proof/';
        if (!is_dir($id_path)) {
            $uold = umask(0);
            if (mkdir('uploaded_docs/user_images/id_proof/', 0777, true)) {
                $html = '<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>';
                write_file($thumbnail_path . '/index.html', $html);
            }
            umask($uold);
        }
        $config['upload_path'] = 'uploaded_docs/user_images/id_proof/';
        $config['allowed_types'] = 'jpg|jpeg';
        $config['overwrite'] = TRUE;
        $config['file_name'] = $new_pdf_file_name;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload($images);
        $uploadData = $this->upload->data();
        return $uploadData;
    }

    function bar_reg_certificate_upload($images, $file_path, $new_pdf_file_name)
    {
        $bar_cer_path = 'uploaded_docs/user_images/barReg_Certificate/';
        if (!is_dir($bar_cer_path)) {
            $uold = umask(0);
            if (mkdir('uploaded_docs/user_images/barReg_Certificate/', 0777, true)) {
                $html = '<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>';
                write_file($bar_cer_path . '/index.html', $html);
            }
            umask($uold);
        }
        $config['upload_path'] = 'uploaded_docs/user_images/barReg_Certificate/';
        $config['allowed_types'] = 'jpg|jpeg';
        $config['overwrite'] = TRUE;
        $config['file_name'] = $new_pdf_file_name;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload($images);
        $uploadData = $this->upload->data();
        return $uploadData;
    }

    function updateProfile_adv()
    {
        $user_id = $_SESSION['login']['id'];
        $profile_photo_path = url_decryption($_POST['photo_path']);
        $profile_photo = url_decryption($_POST['thumb_path']);
        $id_proof = url_decryption($_POST['id_proof_path']);
        $bar_reg_certificate = url_decryption($_POST['bar_reg_certificate']);
        $update_profile = $this->Profile_model->update_photo($user_id, $profile_photo_path, $id_proof, $bar_reg_certificate);
        if ($update_profile) {
            unset($_SESSION['image_and_id_view']);
            $_SESSION['photo_path'] = $profile_photo;
            $this->session->setFlashdata('msg_objection', '<div class="alert alert-success text-center flashmessage">Profile photo Updated Successful!</div>');
            redirect('profile');
        }
    }

    function unset_upload()
    {
        unset($_SESSION['image_and_id_view']);
        redirect('profile');
    }

    function logged_profile()
    {
        if ($this->session->userdata['login']) {
            $this->session->destroy('email_id_for_updation');
            $this->session->destroy('mobile_no_for_updation');
            $data['profile'] = $this->Profile_model->getProfileDetail($this->session->userdata['login']['userid']);
            $data['log_data'] = $this->Profile_model->getloggedDetail($this->session->userdata['login']['id']);
            // if ($_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON || $_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE || $_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
            //     $this->load->view('templates/header');
            // } else {
            //     $this->load->view('templates/admin_header');
            // }
            $this->render('profile.logged_profile', $data);
            // $this->load->view('templates/footer');
        } else {
            redirect('login');
        }
    }

    function block_user()
    {
        $ip = url_decryption($this->uri->segment(3));
        $userid = url_decryption($this->uri->segment(4));
        $status = url_decryption($this->uri->segment(5));
        if (empty($ip) || empty($userid) || empty($status)) {
            $this->session->setFlashdata('message', "<div class='alert alert-danger fade in'>Something Wrong! Please Try again letter.</div>");
            redirect('profile/logged_profile');
        }
        $result = $this->Profile_model->change_block_status($userid, $ip, $status);
        if ($result) {
            $this->session->setFlashdata('message', "<div class='alert alert-success fade in'>Status Updated Successfully .</div>");
            redirect('profile/logged_profile');
        } else {
            $this->session->setFlashdata('message', "<div class='alert alert-danger fade in'>Something Wrong! Please Try again letter.</div>");
            redirect('profile/logged_profile');
        }
    }

}