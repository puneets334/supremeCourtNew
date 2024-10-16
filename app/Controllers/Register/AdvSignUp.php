<?php
namespace App\Controllers\Register;

use App\Controllers\BaseController;
use App\Libraries\webservices\Efiling_webservices;
use App\Models\Register\RegisterModel;
use DateTime;

class AdvSignUp extends BaseController {
    protected $Register_model;
    protected $efiling_webservices;
    protected $request;

    public function __construct() {
        parent::__construct();
        $this->Register_model = new RegisterModel();
        $this->efiling_webservices = new Efiling_webservices();
        $this->request = \Config\Services::request();
        helper(['form']);
    }

    public function index() {
        // pr('hihihihihih');
        if (empty($_SESSION['adv_details']['mobile_no']) || empty($_SESSION['adv_details']['email_id'])) {
            redirect('register');
        }

        unset($_SESSION['image_and_id_view']);
        $data['select_state'] = $this->Register_model->get_state_list();
        // pr($data['select_state']);
        $data['advDetailsIcmis']=$this->efiling_webservices->getBarTable($_SESSION['adv_details']['mobile_no'],$_SESSION['adv_details']['email_id']);

       /* $this->load->view('login/login_header');
        $this->load->view('register/adv_signup_view', $data);
        $this->load->view('login/login_footer');*/
        // $this->slice->view('responsive_variant.authentication.adv_signup_view',$data);
        // $this->slice->view('responsive_variant.authentication.adv_signup_nav');
        $this->render('responsive_variant.authentication.adv_signup_view');
    }

    function get_dist_list() {
        $st_data = explode('#$', $_POST['state_id']);
        $st_id = $st_data[0];
        $result = $this->Register_model->get_district_list($st_id);
        echo '<option value=""> Select District </option>';
        foreach ($result as $district) {
            echo '<option  value="' . htmlentities($district['district_code'] . '#$' . $district['district_name'], ENT_QUOTES) . '">' . htmlentities(strtoupper($district['district_name']), ENT_QUOTES) . '</option>';
        }
    }

    function add_advocate() {
        


        if (!empty($_SESSION['profile_image']['profile_photo'])) {
        }else if (!empty($_SESSION['kyc_configData']['UidData']['Pht'])) {
        }else {
            if (empty($_SESSION['profile_image']['profile_photo'])) {
                $this->session->setFlashdata('msg', 'Please Choose profile Photo.');
                return redirect()->to(base_url('register/AdvSignUp'));
            }
        }
        if (!empty($_POST['mobile']) || !empty($_POST['email_id'])) {
            if ($_SESSION['adv_details']['mobile_no'] != $_POST['mobile']) {
                $this->session->setFlashdata('msg', 'Invalid Mobile number.');
                return redirect()->to(base_url('register'));
            } elseif ($_SESSION['adv_details']['email_id'] != $_POST['email_id']) {
                $this->session->setFlashdata('msg', 'Invalid Emai ID.');

                return redirect()->to(base_url('register'));
            }
        } else {
            return redirect()->to(base_url('register'));
        }
        $rules=[
            "name" => [
                "label" => "Name",
                "rules" => "required|trim|min_length[2]|max_length[26]"
            ],
            "date_of_birth" => [
                "label" => "Date Of Birth",
                "rules" => "required|trim"
            ],
            "gender" => [
                "label" => "Gender",
                "rules" => "required|trim"
            ],
            "address" => [
                "label" => "Address",
                "rules" => "required|trim"
            ],
            "state_id" => [
                "label" => "State",
                "rules" => "required|trim"
            ],
            "district_list" => [
                "label" => "District",
                "rules" => "required|trim"
            ],
            "pincode" => [
                "label" => "Pincode",
                "rules" => "required|trim|numeric|min_length[6]|max_length[6]"
            ],
        ];
        if ($this->validate($rules) === FALSE) {
            $data['validation'] = $this->validator; 
            $data['select_state'] = $this->Register_model->get_state_list();

            /*$this->load->view('login/login_header');
            $this->load->view('register/adv_signup_view', $data);
            $this->load->view('login/login_footer');*/
            $this->render('responsive_variant.authentication.adv_signup_view', $data);
        } else {
            $aor_code=0;
            $adv_sci_bar_id=0;
            $bar_reg_no='';
            if($_SESSION['adv_details']['register_type'] == 'Advocate On Record'){$_SESSION['register_type_select']=url_encryption(USER_ADVOCATE);} //added by anshu
            if(url_decryption($_SESSION['register_type_select'])==USER_ADVOCATE){
                //Get Advocate Details from ICMIS
                // $advDetailsIcmis=$this->efiling_webservices->getBarTable($_POST['adv_mobile'],$_POST['adv_email']);//commented by anshu
                $advDetailsIcmis=$this->efiling_webservices->getBarTable($_SESSION['adv_details']['mobile_no'],$_SESSION['adv_details']['email_id']); //added by anshu
                if(count($advDetailsIcmis)>0){
                    $aor_code=$advDetailsIcmis[0]->userid;
                    $adv_sci_bar_id=$advDetailsIcmis[0]->adv_sci_bar_id;
                    $bar_reg_no=$advDetailsIcmis[0]->bar_reg_no;
                }
                //END
            }


            $st_data = explode('#$', $_POST['state_id']);
            $st_id = $st_data[0];

            $dist_data = explode('#$', $_POST['district_list']);
            $dist_id = $st_data[0];

            $date_of_birth_post=str_replace('/','-',$_POST['date_of_birth']);
            $date = new DateTime($date_of_birth_post);
            $date_of_birth= $date->format('d-m-Y');
            $one_time_password= $this->generateRandomString();
            $_SESSION['user_created_password']= $one_time_password;
            $data = array(
                'userid' => strtoupper($_SESSION['adv_details']['mobile_no']),
                'password' => hash('sha256', $one_time_password),
                'ref_m_usertype_id' => url_decryption($_SESSION['register_type_select']),
                'first_name' => strtoupper($_POST['name']),
                'last_name' => NULL,
                'moblie_number' => $_SESSION['adv_details']['mobile_no'],
                'emailid' => strtoupper($_SESSION['adv_details']['email_id']),
                'adv_sci_bar_id' => $adv_sci_bar_id,
                'aor_code' => $aor_code,
                'bar_reg_no' => strtoupper($bar_reg_no),
                'gender' => url_decryption($_POST['gender']),
                'photo_path' => '',
                'admin_for_type_id' => 1,
                'admin_for_id' => 1,
                'account_status' => 0,
                'is_active' => 1,
                'refresh_token' => NULL,
                'dob' => $date_of_birth,
                'm_address1' => strtoupper($_POST['address']),
                'm_city' => $st_data[1],
                'm_state_id' => $st_id,
                'm_district_id' => $dist_id,
                'm_pincode' => $_POST['pincode'],
                'create_ip' => get_client_ip()
            );

            if ($_SESSION['adv_details']['register_type'] == 'Advocate On Record') {

                if (!empty($_SESSION['profile_image']['profile_photo'])) {
                    $profie_photo = array('photo_path' => $_SESSION['profile_image']['profile_photo']);
                    $final_data = array_merge($data, $profie_photo);
                }else{
                    $final_data =$data;
                }
                $already_exist = $this->Register_model->check_already_reg_email($final_data['emailid']);

                if (!empty($already_exist)) {
                    $this->session->setFlashdata('msg', 'Already Registerd Email.');
                    return redirect()->to(base_url('register/AdvSignUp'));
                } else {
                    $add_adv = $this->Register_model->add_new_advocate_details($final_data);
                    if (!empty($add_adv)) {
                        //TODO:: Send Username and Password on email
                        $to_email=trim($_SESSION['adv_details']['email_id']);
                        $subject="SC-EFM Registration Details";
                        $message="Registered Successfully with user id: ".$_SESSION['adv_details']['mobile_no']." and one time password is: ".$one_time_password." ,Please do not share it with any one.";
                        send_mail_msg($to_email, $subject, $message);
                        //END
                        $this->session->setFlashdata('msg_success', 'Registration Successful');
                        return redirect()->to(base_url(''));
                    } else {
                        $this->session->setFlashdata('msg', 'Registration Failed');
                        return redirect()->to(base_url('register/AdvSignUp'));
                    }
                }
            } else {
                $_SESSION['register_data'] = $data;
                return redirect()->to(base_url('register/AdvSignUp/upload'));
            }
        }
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

    function upload() {
        return render('responsive_variant.authentication.adv_upload_view');
        /*$this->load->view('login/login_header');
        $this->load->view('register/adv_upload_view');
        $this->load->view('login/login_footer');*/
    }

    function upload_photo() {
        if ($_FILES["advocate_image"]['type'] != 'image/jpeg') {
            echo "1@@@" . 'Profile Image Only JPEG/JPG are allowed in document upload .';
            exit(0);
        }
        if (mime_content_type($_FILES["advocate_image"]['tmp_name']) != 'image/jpeg') {
            echo "1@@@" . 'Profile Image Only JPEG/JPG are allowed in document upload .';
            exit(0);
        }
        if (substr_count($_FILES["advocate_image"]['name'], '.') > 1) {
            echo "1@@@" . 'Profile Image No double extension allowed in JPEG/JPG .';
            exit(0);
        }
        if (preg_match("/[^0-9a-zA-Z\s.,-_ ]/i", $_FILES["advocate_image"]['name'])) {
            echo "1@@@" . 'Profile Image JPEG/JPG file name max. length can be 45 characters only. JPEG/JPG file name may contain digits, characters, spaces, hyphens and underscores .';
            exit(0);
        }
        if (strlen($_FILES["advocate_image"]['name']) > File_FIELD_LENGTH) {
            echo "1@@@" . 'Profile Image JPEG/JPG file name max. length can be 45 characters only. JPEG/JPG file name may contain digits, characters, spaces, hyphens and underscores.';
            exit(0);
        }
        if ($_FILES["advocate_image"]['size'] > UPLOADED_FILE_SIZE) {

            $file_size = (UPLOADED_FILE_SIZE / 1024) / 1024;
            echo "1@@@" . 'Profile Image JPEG/JPG uploaded should be less than ' . $file_size . ' MB.';
            exit(0);
        }

        $new_filename = time() . rand() . ".jpeg";
        if (isset($_FILES["advocate_id_prof"]) && $_FILES["advocate_id_prof"]['type'] == 'image/jpeg') {
            $new_pdf_extens = ".jpeg";
        }

        $photo_file_path = "user_images/photo/" . $new_filename;

        $data = array(
            'profile_photo' => base_url() . $photo_file_path
        );

        $_SESSION['profile_image'] = $data;
        $thumb = $this->image_upload('advocate_image', $photo_file_path, $new_filename);
        $file_path_thumbs = '';
        if (!$thumb) {
            $_SESSION['login']['photo_path'] = $file_path_thumbs;
            echo "1@@@" . 'Please Upload Image Is Requerd.';
        }

        if ($thumb) {
            echo '<img class="image-preview" src="' . $_SESSION['profile_image']['profile_photo'] . ' " class="upload-preview" height="94" width="94" />';
        }
    }

    function upload_id_proof() {
        $file = $this->request->getFile('advocate_image');
        // pr($file);
        // echo $fileName = $file->getName().'<br>';
        // echo 'file size       '. $fileSize = $file->getSize().'<br>';
        // die;
        if ($_FILES["advocate_image"]['type'] != 'image/jpeg') {
            $this->session->setFlashdata('msg', 'Only JPEG/JPG are allowed in ID proof');
            redirect('register/AdvSignUp/upload');
            exit(0);
        }
        if (mime_content_type($_FILES["advocate_image"]['tmp_name']) != 'image/jpeg') {
            $this->session->setFlashdata('msg', 'Only JPEG/JPG are allowed in ID proof');
            redirect('register/AdvSignUp/upload');
            exit(0);
        }
        if (substr_count($_FILES["advocate_image"]['name'], '.') > 1) {

            $this->session->setFlashdata('msg', 'Only JPEG/JPG are allowed in ID proof');
            redirect('register/AdvSignUp/upload');
            exit(0);
        }
        if (preg_match("/[^0-9a-zA-Z\s.,-_ ]/i", $_FILES["advocate_image"]['name'])) {

            $this->session->setFlashdata('msg', 'ID proof Image JPEG/JPG file name max. length can be 45 characters only. JPEG/JPG file name may contain digits, characters, spaces, hyphens and underscores');
            redirect('register/AdvSignUp/upload');
            exit(0);
        }
        if (strlen($_FILES["advocate_image"]['name']) > File_FIELD_LENGTH) {
            $this->session->setFlashdata('msg', 'ID proof Image JPEG/JPG file name max. length can be 45 characters only. JPEG/JPG file name may contain digits, characters, spaces, hyphens and underscores');
            redirect('register/AdvSignUp/upload');
            exit(0);
        }
        if ($_FILES["advocate_image"]['size'] > UPLOADED_FILE_SIZE) {
            $file_size = (UPLOADED_FILE_SIZE / 1024) / 1024;
            $this->session->setFlashdata('msg', 'ID proof Image JPEG/JPG uploaded should be less than ' . $file_size . ' MB');
            redirect('register/AdvSignUp/upload');
            exit(0);
        }

        $new_filename = time() . rand() . ".jpeg";
        if ($_FILES["advocate_image"]['type'] == 'image/jpeg') {
            $new_pdf_extens = ".jpeg";
        }

        $photo_file_path = "user_images/photo/" . $new_filename;

        $data = array(
            'profile_photo' => base_url() . $photo_file_path
        );

        $_SESSION['image_and_id_view'] = $data;
        $_SESSION['profile_image'] = $data;
        $thumb = $this->image_upload('advocate_image', $photo_file_path, $new_filename);

        $file_path_thumbs = '';
        if (!$thumb) {
            $_SESSION['login']['photo_path'] = $file_path_thumbs;
            $this->session->setFlashdata('msg', 'Please Upload Image.');
            return redirect()->to('register/AdvSignUp/upload');
        } else {
            $this->session->setFlashdata('msg', 'Successful.');
            return redirect()->to('register/AdvSignUp/upload');
        }
    }

    function image_upload($images, $file_path, $file_temp_name) {
        $thumbnail_path = 'user_images/thumbnail/';
        $photo_path = 'user_images/photo/';
        $this->create_directory($thumbnail_path);
        $this->create_directory($photo_path);

        $config['upload_path'] = $photo_path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['overwrite'] = true;
        $config['file_name'] = $file_temp_name;

        $file = $this->request->getFile($images);
        if ($file && $file->isValid() && !$file->hasMoved()) { 
            $file->move($photo_path, $file_temp_name);  
            $data['picture'] = $file_temp_name; 
            $sourcePath = $photo_path . $file_temp_name;   
            $destinationPath = WRITEPATH . 'uploads/thumbnails/' . $file_temp_name; 
            return $data;
        } else {
            return ['error' => 'File upload failed: ' . $file->getErrorString()];
        }
    }
    
    function create_thumbnail($filename, $thumbnail_path) {
        $config['source_image'] = 'user_images/photo/' . $filename;
        $config['new_image'] = $thumbnail_path . $filename;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 150; // Set your desired thumbnail width
        $config['height'] = 150; // Set your desired thumbnail height
    
        // Load the image library
        $image_lib = \Config\Services::image();
        $image_lib->initialize($config);
    
        // Create the thumbnail
        if (!$image_lib->resize(150, 150)) {
            return ['error' => $image_lib->display_errors()];
        }
    }

    function create_directory($path) {
        if (!is_dir($path)) {
            $uold = umask(0);

            if (!mkdir($path, 0777, true)) {
                die('Failed to create directory: ' . $path . ' - Error: ' . error_get_last()['message']);
            }
            umask($uold);
        }
    }

    function final_submit() {


        $adv_data = $_SESSION['register_data'];
       // echo $adv_data['password'];
        $profie_photo = array('photo_path' => $_SESSION['profile_image']['profile_photo']);

        $id_proof = array('id_proof_path' => $_SESSION['image_and_id_view']['profile_photo']);

        $adv_data1 = array_merge($adv_data, $profie_photo);
        $final_data = array_merge($adv_data1, $id_proof);


        $already_exist = $this->Register_model->check_already_reg_email($final_data['emailid']);

        if (!empty($already_exist)) {
            $this->session->setFlashdata('msg', 'Already Registerd Email.');
            redirect('register/AdvSignUp');
        } else {
            $one_time_password= $_SESSION['user_created_password']; //$this->generateRandomString();
            $add_adv = $this->Register_model->add_new_advocate_details($final_data);
            if (!empty($add_adv)) {
                $to_email=trim($_SESSION['adv_details']['email_id']);
                $subject="SC-EFM Registration Details";
                $message="Registered Successfully with user id: ".$_SESSION['adv_details']['mobile_no']." and one time password is: ".$one_time_password." , Please do not share it with any one.";
                send_mail_msg($to_email, $subject, $message);
                //END
                $this->session->setFlashdata('msg', 'Registration Successful');
                return redirect()->to(base_url('/'));
            } else {
                $this->session->setFlashdata('msg', 'Registration Failed');
                return redirect()->to(base_url('register/AdvSignUp'));
            }
        }
    }

}



?>
