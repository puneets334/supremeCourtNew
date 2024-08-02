<?php
namespace App\Controllers;

class Clerk extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('clerk/Clerk_model');
        $this->load->model('common/Common_login_model');
        $this->load->model('common/Common_model');
        $this->load->library('webservices/efiling_webservices');
    }

    public function index() {
        $this->clerk();
    }

    public function clerk() {

        if ($_SESSION['login']['ref_m_usertype_id'] != USER_ADVOCATE && $_SESSION['login']['ref_m_usertype_id'] != USER_CLERK) {
            redirect('login');
            exit(0);
        }

        $data['clerk_user_list'] = $this->Clerk_model->get_clerk_users($_SESSION['login']['id']);
        //$data['states'] = $this->efiling_webservices->getOpenAPIState();
        $data['states'] = $this->Clerk_model->get_states_list();
        $this->load->view('templates/header');
        $this->load->view('clerk/add_clerk_view', $data);
        $this->load->view('templates/footer');
    }

    public function add_Clerk() {

        if ($_SESSION['login']['ref_m_usertype_id'] != USER_ADVOCATE && $_SESSION['login']['ref_m_usertype_id'] != USER_CLERK) {
            redirect('login');
            exit(0);
        }

        $clerk_id = url_decryption($_POST['clerk_id']);
        $email_pattern = "/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/";
        $clerk_name = trim(strtoupper($_POST['clerk_name']));
        $mobile = trim($_POST['mobile_no']);
        $email = trim(strtoupper($_POST['email_id']));
        $user_id = explode('@', $email);
        $userid = strtoupper($user_id[0]);
        $ref_m_usertype_id = USER_CLERK;
        $district_id = explode("#$", url_decryption($_POST['district']));
        $random_password = 'Clerk@1234'; //time().rand('10,100');
        $login_pass = hash('sha256', $random_password);
        $address = trim($_POST['address']);
        $ref_m_states_id = explode("#$", url_decryption($_POST['states_id']));
        $city = trim(strtoupper($_POST['city']));


        if (preg_match('/[^0-9]/i', $mobile) || strlen($mobile) != 10) {
            $_SESSION['MSG'] = message_show("fail", 'Please Enter Valid Mobile Number.');
            redirect('add/clerk');
        }
        if (!preg_match($email_pattern, $email)) {
            $_SESSION['MSG'] = message_show("fail", 'Please Enter Valid Email ID.');
            redirect('add/clerk');
        }

        $check_email_already_present = $this->Common_login_model->check_email_already_present(strtoupper($email));
        $check_mobno_already_present = $this->Common_login_model->check_mobno_already_present(strtoupper($mobile));
        $check_usrid_already_present = $this->Common_login_model->check_usrid_already_present(strtoupper($userid));

        if ($check_email_already_present) {
            $_SESSION['MSG'] = message_show("fail", 'Same Email Id already Registered.');
            redirect('add/clerk');
        }
        if ($check_mobno_already_present) {
            $_SESSION['MSG'] = message_show("fail", 'Same Mobile Number already Registered.');
            redirect('add/clerk');
        }
        if ($check_usrid_already_present) {
            $_SESSION['MSG'] = message_show("fail", 'Same User ID already Registered.');
            redirect('add/clerk');
        }

        if (preg_match('/[^0-9]/i', $ref_m_states_id[0])) {
            $_SESSION['MSG'] = message_show("fail", 'State is required ');
            redirect('add/clerk');
        }
        if (preg_match('/[^0-9]/i', $district_id[0])) {
            $_SESSION['MSG'] = message_show("fail", 'District is required.');
            redirect('add/clerk');
        }
        $validate_name = validate_names($address, TRUE, 4, 150, 'Address');
        if ($validate_name['response'] == FALSE) {
            $_SESSION['MSG'] = message_show("fail", htmlentities($validate_name['msg']['field_name'], ENT_QUOTES));
            redirect('add/clerk');
        }
        if (preg_match("/[^0-9a-zA-Z\s.:,-_\/ ]/i", $city) || $city == NULL) {
            $_SESSION['MSG'] = message_show("fail", 'City  is required and can contain only characters,numbers,spaces and :,.-_/');
            redirect('add/clerk');
        }
        if ($_POST['pincode'] != NULL) {
            $pincode = $_POST['pincode'];
            if (preg_match('/[^0-9]/i', $_POST['pincode']) || (strlen($_POST['pincode']) != 6)) {
                $_SESSION['MSG'] = message_show("fail", ' Pincode is required and can have only numbers of 6 digit length.');
                redirect('add/clerk');
            }
        } else {
            $pincode = 0;
        }if ($ref_m_states_id == '') {
            $ref_m_states_id = 0;
        } else {
            $ref_m_states_id = $ref_m_states_id;
        }

        /*$data = array(
            'first_name' => $clerk_name,
            'moblie_number' => $mobile,
            'emailid' => $email,
            'userid' => $userid,
            'ref_m_usertype_id' => $ref_m_usertype_id,
            'password' => $login_pass,
            'last_name' => 'NA',
            'gender' => 0,
            'm_address1' => $address,
            'm_state_id' => $ref_m_states_id[0],
            'm_pincode' => $pincode,
            'bar_reg_no' => $_SESSION['login']['bar_reg_no'],
            'ref_m_id_proof_type' => 0,
            'create_ip' => $_SERVER['REMOTE_ADDR'],
            'dob' => '0',
            'm_city' => $city,
            'update_ip' => $_SERVER['REMOTE_ADDR'],
            'admin_role' => '0',
            'login_ip' => '0',
            'm_pincode' => '0',
            'm_district_id' => '0' 
        );*/
        $data = array(
            'first_name' => $clerk_name,
            'moblie_number' => $mobile,
            'emailid' => $email,
            'userid' => $userid,
            'ref_m_usertype_id' => $ref_m_usertype_id,
            'password' => $login_pass,
            'last_name' => 'NA',
            'gender' => 0,
            'm_address1' => $address,
            'm_state_id' => $ref_m_states_id[0],
            'm_district_id' =>$district_id[0],
            'm_pincode' => $pincode,
            'bar_reg_no' => $_SESSION['login']['bar_reg_no'],
            'ref_m_id_proof_type' => 0,
            'create_ip' => $_SERVER['REMOTE_ADDR'],
            'dob' => '0',
            'm_city' => $city,
            'update_ip' => $_SERVER['REMOTE_ADDR'],
            'admin_role' => '0',
            'login_ip' => '0',
        );


        $result = $this->Clerk_model->add_clerk_user($data, $clerk_name);
        
        if ($result) {
            $user_name = $userid;
            send_mail_msg($email, 'Your eFiling Username', 'Your eFiling  username :' . strtoupper($userid) );
            $sentSMS = 'Your eFiling Password ' . $login_pass . 'The login username has been sent to your registered email account. - Supreme Court of India';
            send_mobile_sms($mobile, $sentSMS,SCISMS_Login_Password_To_Email);
            
            $_SESSION['MSG'] = message_show("success", 'Clerk Added Successfully');
            redirect('add/clerk');
        } else {
            $_SESSION['MSG'] = message_show("fail", 'Something Wrong, Please try again later!');
            redirect('add/clerk');
        }

        $this->load->view('templates/header');
        $this->load->view('clerk/add_clerk_view', $data);
        $this->load->view('templates/footer');
    }

    public function edit($id) {

        if ($_SESSION['login']['ref_m_usertype_id'] != USER_ADVOCATE && $_SESSION['login']['ref_m_usertype_id'] != USER_CLERK) {
            redirect('login');
            exit(0);
        }
        $id = url_decryption($id);
        $data['clerk_user_list'] = $this->Clerk_model->get_clerk_users($_SESSION['login']['id']);
        //$data['states'] = $this->efiling_webservices->getOpenAPIState();
        $data['states'] = $this->Clerk_model->get_states_list();

        if ($id) {

            $data['clerkData'] = $this->Clerk_model->get_clerk_details($id);
            //$data['states'] = $this->efiling_webservices->getOpenAPIState();
            //$data['district'] = $this->efiling_webservices->getOpenAPIDistrict($data['clerkData'][0]['njdg_st_id']);
            $data['states'] = $this->Clerk_model->get_states_list();
            $data['district'] = $this->Clerk_model->get_districts_list($data['clerkData'][0]['m_state_id']);

            $this->load->view('templates/header');
            $this->load->view('clerk/add_clerk_view', $data);
            $this->load->view('templates/footer');
        }
    }

    public function action($action_id, $status) {

        if ($_SESSION['login']['ref_m_usertype_id'] != USER_ADVOCATE && $_SESSION['login']['ref_m_usertype_id'] != USER_CLERK) {
            redirect('login');
            exit(0);
        }
        if (empty($action_id) || empty($status)) {
            $_SESSION['MSG'] = message_show("fail", 'Something Wrong! Please Try again letter.');
            redirect('add/clerk');
        }
        $data['clerk_user_list'] = $this->Clerk_model->get_clerk_users($_SESSION['login']['id']);
        $action_id = url_decryption($action_id);
        $status = url_decryption(trim($status));
        if (preg_match('/[^0-9]/i', $action_id)) {
            $_SESSION['MSG'] = message_show("fail", 'Something Wrong! Please Try again letter.');
            redirect('add/clerk');
        }

        $result = $this->Common_model->action_taken($action_id, $status);
        if ($result) {
            $_SESSION['MSG'] = message_show("success", 'Status Updated Successfully.');
            redirect('add/clerk');
        } else {
            $_SESSION['MSG'] = message_show("fail", 'Something Wrong! Please Try again letter.');
            redirect('add/clerk');
        }
    }

    public function update_clerk() {

        if ($_SESSION['login']['ref_m_usertype_id'] != USER_ADVOCATE && $_SESSION['login']['ref_m_usertype_id'] != USER_CLERK) {
            redirect('login');
            exit(0);
        }
        $clerk_id = url_decryption($_POST['clerk_id']);

        $email_pattern = "/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/";
        $clerk_name = trim(strtoupper($_POST['clerk_name']));
        $mobile = trim($_POST['mobile_no']);
        $email = trim(strtoupper($_POST['email_id']));
        $address = trim($_POST['address']);
        $ref_m_states_id = explode("#$", url_decryption($_POST['states_id']));
        $city = trim(strtoupper($_POST['city']));
        $district_id = explode("#$", url_decryption($_POST['district']));

        if (preg_match('/[^0-9]/i', $mobile) || strlen($mobile) != 10) {
            $_SESSION['MSG'] = message_show("fail", 'Please Enter Valid Mobile Number.');
            redirect('add/clerk');
        }
        if (!preg_match($email_pattern, $email)) {
            $_SESSION['MSG'] = message_show("fail", 'Please Enter Valid Email ID.');
            redirect('add/clerk');
        }

        $check_email_present = $this->Clerk_model->check_email_present(strtoupper($email), $clerk_id);
        $check_mobno_present = $this->Clerk_model->check_mobno_present($mobile, $clerk_id);

        if ($check_email_present) {
            $_SESSION['MSG'] = message_show("fail", 'Same Email Id already Registered.');
            redirect('add/clerk');
        }
        if ($check_mobno_present) {
            $_SESSION['MSG'] = message_show("fail", 'Same Mobile Number already Registered.');
            redirect('add/clerk');
        }

        if (preg_match('/[^0-9]/i', $ref_m_states_id[0])) {
            $_SESSION['MSG'] = message_show("fail", 'State is required.');
            redirect('add/clerk');
        }
        if (preg_match('/[^0-9]/i', $district_id[0])) {
            $_SESSION['MSG'] = message_show("fail", 'District is required.');
            redirect('add/clerk');
        }
        $validate_name = validate_names($address, TRUE, 4, 150, 'Address');
        if ($validate_name['response'] == FALSE) {
            $_SESSION['MSG'] = message_show("fail", htmlentities($validate_name['msg']['field_name'], ENT_QUOTES));
            redirect('add/clerk');
        }
        if (preg_match("/[^0-9a-zA-Z\s.:,-_\/ ]/i", $city) || $city == NULL) {
            $_SESSION['MSG'] = message_show("fail", 'City  is required and can contain only characters,numbers,spaces and :,.-_/');
            redirect('add/clerk');
        }
        if ($_POST['pincode'] != NULL) {
            $pincode = $_POST['pincode'];
            if (preg_match('/[^0-9]/i', $_POST['pincode']) || (strlen($_POST['pincode']) != 6)) {
                $_SESSION['MSG'] = message_show("fail", 'Pincode is required and can have only numbers of 6 digit length.');
                redirect('add/clerk');
            }
        } else {
            $pincode = 0;
        } if ($ref_m_states_id == '') {
            $ref_m_states_id = 0;
        } else {
            $ref_m_states_id = $ref_m_states_id;
        }


       /* $data = array(
            'first_name' => $clerk_name,
            'moblie_number' => $mobile,
            'emailid' => $email,
            'address1' => $address,
            'pincode' => $pincode,
            'city' => $city,
            'updated_by_ip' => $_SERVER['REMOTE_ADDR'],
            'case_flag' => $_POST['case_file'],
            'doc_flag' => $_POST['doc_file'],
            'njdg_st_id' => $ref_m_states_id[0],
            'njdg_st_name' => $ref_m_states_id[1],
            'njdg_dist_id' => $district_id[0],
            'njdg_dist_name' => $district_id[1]
        );*/
        $data = array(
            'first_name' => $clerk_name,
            'moblie_number' => $mobile,
            'emailid' => $email,
            'm_address1' => $address,
            'm_pincode' => $pincode,
            'm_city' => $city,
            'update_ip' => $_SERVER['REMOTE_ADDR'],
            // 'case_flag' => $_POST['case_file'],
            //'doc_flag' => $_POST['doc_file'],
            'm_state_id' => $ref_m_states_id[0],
            'm_district_id' =>$district_id[0],
        );

        $result = $this->Clerk_model->update_clerk_user($clerk_id, $data, $clerk_name);
        if ($result) {
            $_SESSION['MSG'] = message_show("success", 'Clerk Updated Successfully.');
            redirect('add/clerk');
        } else {
            $_SESSION['MSG'] = message_show("fail", 'Something Wrong! Please Try again letter.');
            redirect('add/clerk');
        }
        $this->load->view('templates/header');
        $this->load->view('clerk/add_clerk_view', $data);
        $this->load->view('templates/footer');
    }
    public function get_district_list() {

        $state_array = explode('#$', url_decryption(escape_data($_POST['state_id'])));
        $state_id = $state_array[0];
        $result= $this->Clerk_model->get_districts_list($state_id);
        if (count($result) > 0) {
            echo '<option value=""> Select District </option>';
            foreach ($result  as $district) {
                echo '<option  value="' . htmlentities(url_encryption($district->dist_code . '#$' . $district->dist_name), ENT_QUOTES) . '">' . htmlentities(strtoupper($district->dist_name), ENT_QUOTES) . '</option>';
            }

        } else {
            echo '<option value=""> Select District </option>';
        }
    }

    /*public function get_district_list() {

        $state_array = explode('#$', url_decryption(escape_data($_POST['state_id'])));
        $state_id = $state_array[0];
        if (isset($state_id) && preg_match("/^[0-9]*$/", $state_id) && strlen($state_id) <= INTEGER_FIELD_LENGTH) {
            if (!empty($state_id)) {
                $result = $this->efiling_webservices->getOpenAPIDistrict($state_id);
                if (!empty($status->status_code)) {
                    echo 'ERROR_' . $status->status;
                    exit(0);
                } else {
                    if (count($result)) {
                        echo '<option value=""> Select District </option>';
                        foreach ($result as $dataRes) {
                            foreach ($dataRes->district as $district) {
                                echo '<option  value="' . htmlentities(url_encryption($district->dist_code . '#$' . $district->dist_name), ENT_QUOTES) . '">' . htmlentities(strtoupper($district->dist_name), ENT_QUOTES) . '</option>';
                            }
                        }
                    } else {
                        echo '<option value=""> Select District </option>';
                    }
                }
            } else {
                echo '<option value=""> Select District</option>';
            }
        } else {
            echo '<option value=""> Select District</option>';
        }
    }*/

}
