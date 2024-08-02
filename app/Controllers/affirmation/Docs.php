<?php
namespace App\Controllers;

class Docs extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('common/Common_model');
        $this->load->model('newcase/New_case_model');
        $this->load->model('newcase/Dropdown_list_model');
        $this->load->model('newcase/Get_details_model');
        $this->load->model('affirmation/Affirmation_model');
        $this->load->library('TCPDF');
        $this->load->helper('file');
    }

    public function index() {

        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT,JAIL_SUPERINTENDENT);

        if (!in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('admindashboard');
            exit(0);
        }

        $stages_array = array('', Draft_Stage, Initial_Defected_Stage, I_B_Defected_Stage, E_REJECTED_STAGE);
        if (!in_array($_SESSION['efiling_details']['stage_id'], $stages_array)) {
            if($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_NEW_CASE)
            { redirect('newcase/view');
            exit(0);
            }elseif($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_JAIL_PETITION)
            { redirect('jailPetition/view');
                exit(0);
            }
        }
        $registration_id = $_SESSION['efiling_details']['registration_id'];
        $data['esigned_docs_details'] = $this->Affirmation_model->get_esign_doc_details($registration_id);

        $this->gen_advocate_affirmation();

        if (isset($_SESSION['efiling_details']['registration_id']) && !empty($_SESSION['efiling_details']['registration_id'])) {

            $registration_id = $_SESSION['efiling_details']['registration_id'];

            $this->gen_advocate_affirmation();
        }
        if($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_NEW_CASE) {
            $this->load->view('templates/header');
            $this->load->view('newcase/new_case_view', $data);
            $this->load->view('templates/footer');
        }elseif($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_JAIL_PETITION){
            $this->load->view('templates/jail_header');
            $this->load->view('jailPetition/new_case_view', $data);
            $this->load->view('templates/footer');
        }
    }

    public function view_pet_unsigned_oath($efiling_num) {

        unset($_SESSION['MOB_OTP_VERIFY_UPLOADED_DOCS']);
        if ($this->session->userdata['login']) {
            $temp = explode('.', $efiling_num);
            unset($temp[count($temp) - 1]);
            $efiling_no = implode('.', $temp);
            $efiling_no = escape_data($efiling_no);

            $est_code = $_SESSION['estab_details']['estab_code'];

            $pet_unsigned_oath_path = 'uploaded_docs/' . $est_code . '/' . $efiling_no . '/unsigned_pdf/' . $efiling_no . '_pet_affirmation.pdf';
            $pet_unsigned_oath_name = $efiling_no . '_pet_affirmation.pdf';
            //$pet_unsigned_oath_path = 'uploaded_docs/' . $est_code . '/' . $efiling_no . '/unsigned_pdf/' . $efiling_no . '_adv_oath.pdf';
            //$pet_unsigned_oath_name = $efiling_no . '_adv_oath.pdf';
            $data['pdf']['file_path'] = $pet_unsigned_oath_path;
            $data['pdf']['file_name'] = $pet_unsigned_oath_name;

            if ($efiling_no) {
                $this->load->view('affirmation/view_unsigned_docs', $data);
            } else {
                $data['msg'] = 'You are not allowed';
                $this->load->view('affirmation/view_unsigned_docs', $data);
            }
        } else {
            redirect('login');
        }
    }

    public function upload_digitally_signed_doc() {

        if (!($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE || $_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON || $_SESSION['login']['ref_m_usertype_id'] == USER_PDE || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK || $_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == JAIL_SUPERINTENDENT)) {
            redirect('login');
            exit(0);
        }

        $registration_id = $_SESSION['efiling_details']['registration_id'];
        $efiling_num = $_SESSION['efiling_details']['efiling_no'];
        $est_code = $_SESSION['estab_details']['est_code'];

        $data['esigned_docs_details'] = $this->Affirmation_model->get_esign_doc_details($registration_id);
        $redirect_url = 'affirmation';

        if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] != E_FILING_TYPE_MISC_DOCS && $_SESSION['efiling_details']['ref_m_efiled_type_id'] != E_FILING_TYPE_IA && $_SESSION['efiling_details']['ref_m_efiled_type_id'] != E_FILING_TYPE_DEFICIT_COURT_FEE) {

            if (isset($_FILES['pet_oath_esign_pdf']) && !empty($_FILES['pet_oath_esign_pdf']) && isset($registration_id)) {

                if (isset($_FILES['pet_oath_esign_pdf'])) {
                    if ($msg = isValidPDF('pet_oath_esign_pdf')) {
                        $this->session->set_flashdata('msg', $msg);
                        redirect($redirect_url);
                    }
                }
                $signed_pdf_dir = 'uploaded_docs/' . $est_code . '/' . $efiling_num . '/signed_pdfs/';
                if (!is_dir($signed_pdf_dir)) {
                    $uold = umask(0);
                    if (mkdir($signed_pdf_dir, 0777, true)) {
                        $html = '<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>';
                        write_file($signed_pdf_dir . 'index.html', $html);
                    }
                    umask($uold);
                }


                $signed_pdf_full_path = getcwd() . '/uploaded_docs/' . $est_code . '/' . $efiling_num . '/signed_pdfs/';
                $signed_pdf_partial_path = 'uploaded_docs/' . $est_code . '/' . $efiling_num . '/signed_pdfs/';
                $signed_pdf_full_path_with_file_name = $signed_pdf_full_path . $efiling_num . '_pet_affirmation.pdf';
                $signed_pdf_partial_path_with_file_name = $signed_pdf_partial_path . $efiling_num . '_pet_affirmation.pdf';
                $signed_pdf_file_name = $efiling_num . '_pet_affirmation.pdf';

                move_uploaded_file($_FILES['pet_oath_esign_pdf']['tmp_name'], $signed_pdf_dir . $efiling_num . '_pet_affirmation.pdf');

                $pet_data = array('ref_registration_id' => $registration_id,
                    'ref_efiling_no' => $efiling_num,
                    'type' => ESIGNED_DOCS_BY_ADV,
                    'signed_pdf_full_path' => $signed_pdf_full_path,
                    'signed_pdf_full_path_with_file_name' => $signed_pdf_full_path_with_file_name,
                    'signed_pdf_partial_path' => $signed_pdf_partial_path,
                    'signed_pdf_partial_path_with_file_name' => $signed_pdf_partial_path_with_file_name,
                    'signed_pdf_file_name' => $signed_pdf_file_name,
                    'is_data_valid' => TRUE,
                    'signed_type' => 1);


                if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_NEW_CASE) {
                    $breadcrumbs_to_update = NEW_CASE_AFFIRMATION;
                } elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MISC_DOCS) {
                    $breadcrumbs_to_update = MISC_BREAD_AFFIRMATION;
                } elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_IA) {
                    $breadcrumbs_to_update = IA_BREAD_AFFIRMATION;
                } elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MENTIONING) {
                    $breadcrumbs_to_update = MEN_BREAD_AFFIRMATION;
                }elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_JAIL_PETITION) {
                    $breadcrumbs_to_update = JAIL_PETITION_AFFIRMATION;
                }

                $result = $this->Affirmation_model->upload_pet_adv_esign_docs($pet_data, $registration_id, $breadcrumbs_to_update);


                if ($result) {
                    $_SESSION['MSG'] = message_show("success", 'Cerificate uploaded successfully !');
                    redirect($redirect_url);
                } else {
                    $_SESSION['MSG'] = message_show("fail", 'Fail to upload Affirmation !');
                    redirect($redirect_url);
                }
            }
        }

        if (($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE) ||
                ($_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON ||
                $_SESSION['login']['ref_m_usertype_id'] == USER_PDE ||
                $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK ||
                $_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT &&
                ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MISC_DOCS || $_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_IA || $_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_DEFICIT_COURT_FEE))) {

            if ((bool) $data['esigned_docs_adv'] == FALSE || $data['esigned_docs_adv'][0]->is_data_valid != 't') {

                if (isset($_FILES['adv_oath_esign_pdf']) && !empty($_FILES['adv_oath_esign_pdf']) && isset($registration_id)) {

                    if (isset($_FILES['adv_oath_esign_pdf'])) {

                        if ($msg = isValidPDF('adv_oath_esign_pdf')) {
                            $this->session->set_flashdata('msg', $msg);
                            redirect($redirect_url);
                        }
                    }

                    $signed_pdf_dir = 'uploaded_docs/' . $est_code . '/' . $efiling_num . '/signed_pdfs/';
                    if (!is_dir($signed_pdf_dir)) {
                        $uold = umask(0);
                        if (mkdir($signed_pdf_dir, 0777, true)) {
                            $html = '<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>';
                            write_file($signed_pdf_dir . 'index.html', $html);
                        }
                        umask($uold);
                    }

                    $signed_pdf_full_path = getcwd() . '/uploaded_docs/' . $est_code . '/' . $efiling_num . '/signed_pdfs/';
                    $signed_pdf_partial_path = 'uploaded_docs/' . $est_code . '/' . $efiling_num . '/signed_pdfs/';
                    $signed_pdf_full_path_with_file_name = $signed_pdf_full_path . $efiling_num . '_adv_oath.pdf';
                    $signed_pdf_partial_path_with_file_name = $signed_pdf_partial_path . $efiling_num . '_adv_oath.pdf';
                    $signed_pdf_file_name = $efiling_num . '_adv_oath.pdf';

                    move_uploaded_file($_FILES['adv_oath_esign_pdf']['tmp_name'], $signed_pdf_dir . $efiling_num . '_adv_oath.pdf');

                    $pet_data = array('ref_registration_id' => $registration_id,
                        'ref_efiling_no' => $efiling_num,
                        'type' => ESIGNED_DOCS_BY_ADV,
                        'signed_pdf_full_path' => $signed_pdf_full_path,
                        'signed_pdf_full_path_with_file_name' => $signed_pdf_full_path_with_file_name,
                        'signed_pdf_partial_path' => $signed_pdf_partial_path,
                        'signed_pdf_partial_path_with_file_name' => $signed_pdf_partial_path_with_file_name,
                        'signed_pdf_file_name' => $signed_pdf_file_name,
                        'is_data_valid' => TRUE,
                        'signed_type' => 1);


                    if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_NEW_CASE) {
                        $breadcrumbs_to_update = NEW_CASE_AFFIRMATION;
                    } elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MISC_DOCS) {
                        $breadcrumbs_to_update = MISC_BREAD_AFFIRMATION;
                    } elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_IA) {
                        $breadcrumbs_to_update = IA_BREAD_AFFIRMATION;
                    } elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MENTIONING) {
                        $breadcrumbs_to_update = MEN_BREAD_AFFIRMATION;
                    }elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_JAIL_PETITION) {
                        $breadcrumbs_to_update = JAIL_PETITION_AFFIRMATION;
                    }

                    $result = $this->Affirmation_model->upload_pet_adv_esign_docs($pet_data, $registration_id, $breadcrumbs_to_update);

                    if ($result) {
                        $_SESSION['MSG'] = message_show("success", 'Certificate uploaded successfully !');
                        redirect($redirect_url);
                        exit(0);
                    } else {
                        $_SESSION['MSG'] = message_show("fail", 'Fail to upload certificate !');
                        redirect($redirect_url);
                        exit(0);
                    }
                }
            }
        }
    }

    public function view_signed_certificate($doc_id) {


        if ($this->session->userdata['login']) {

            $doc_id = url_decryption(escape_data($doc_id));

            if (filter_var($doc_id, FILTER_VALIDATE_INT)) {
                $data['pdf'] = $this->Affirmation_model->view_signed_certificate($doc_id);
                if (empty($data['pdf'])) {
                    $data['msg'] = 'You are not allowed';
                    $this->load->view('affirmation/view_signed_certificate', $data);
                } else {
                    $this->load->view('affirmation/view_signed_certificate', $data);
                }
            } else {
                $data['msg'] = 'You are not allowed';
                $this->load->view('affirmation/view_signed_certificate', $data);
            }
        } else {
            redirect('login');
        }
    }

    public function reset_affirmation() {

        if (!($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE  || $_SESSION['login']['ref_m_usertype_id'] == JAIL_SUPERINTENDENT  || $_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK || $_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT)) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid Action.</div>');
        }
        $docid = url_decryption($_POST['docid']);
        $type = $_POST['type'];

        if (!isset($_POST['docid']) && !$docid) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid Input.</div>');
        }

        $type = ESIGNED_DOCS_BY_ADV;

        $Array = array(Draft_Stage, Initial_Defected_Stage, DEFICIT_COURT_FEE, I_B_Defected_Stage, I_B_Rejected_Stage, E_REJECTED_STAGE);
        if (!in_array($_SESSION['efiling_details']['stage_id'], $Array)) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid Action.</div>');
        }
        unset($_SESSION['eVerified_mobile_otp']['LITIGENT_MOB_OTP_VERIFY']);
        $update_data = array('is_data_valid' => FALSE, 'signed_type' => NULL);

        $this->Affirmation_model->reset_affirmation_model($docid, $_SESSION['efiling_details']['registration_id'], $_SESSION['efiling_details']['efiling_no'], $update_data, $type);
        return true;
    }

    public function send_adv_litigent_mobile_otp_everified_doc() {

        unset($_SESSION['MOB_OTP_VERIFY_UPLOADED_DOCS']);
        unset($_SESSION['eVerified_mobile_otp']);


        if (empty($_POST['name'])) {
            echo '1@@@' . htmlentities('Enter Litigent Name', ENT_QUOTES);
            exit(0);
        } elseif (empty($_POST['mobile'])) {
            echo '1@@@' . htmlentities('Enter Litigent Mobile Number', ENT_QUOTES);
            exit(0);
        }


        if (!empty($_POST['mobile']) && !empty($_POST['name'])) {

            $validate_nums = validate_number($_POST['mobile'], TRUE, 10, 10, 'Mobile number');
            if ($validate_nums['response'] == FALSE) {
                echo '1@@@' . htmlentities($validate_nums['msg']['field_name'], ENT_QUOTES);
                exit(0);
            }
            $validate_name = validate_names($_POST['name'], TRUE, 3, 99, 'Name');
            if ($validate_name['response'] == FALSE) {
                echo '1@@@' . htmlentities($validate_name['msg']['field_name'], ENT_QUOTES);
                exit(0);
            }
            if (empty($_SESSION['eVerified_mobile_otp']['LITIGENT_MOB_OTP_VERIFY'])) {
                $mob_otp = rand(111111, 999999);
                $_SESSION['eVerified_mobile_otp']['LITIGENT_MOB_OTP_VERIFY'] = $mob_otp;
                $_SESSION['eVerified_mobile_otp']['LITIGENT_MOBILE'] = $_POST['mobile'];
                $_SESSION['eVerified_mobile_otp']['LITIGENT_NAME'] = $_POST['name'];
                $sentSMS = "OTP is " . $mob_otp . " for eVerify uploaded document with eFiling application. - Supreme Court of India";
                $result = send_mobile_sms($_POST['mobile'], $sentSMS,SCISMS_eVerify_document);
            }
        }
        if ($result) {
            echo '2@@@' . htmlentities('done', ENT_QUOTES);
        } else {
            echo '1@@@' . htmlentities('Some things went wrong. Please Try again', ENT_QUOTES);
        }
    }

    public function verify_adv_mobile_otp() {

        unset($_SESSION['MOB_OTP_VERIFY_UPLOADED_DOCS']);
        if (!($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE || $_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON )) {
            redirect('login');
            exit(0);
        }

        if (isset($_SESSION['efiling_details']) && !empty($_SESSION['efiling_details'])) {
            $registration_id = $_SESSION['efiling_details']['registration_id'];
            $efiling_num = $_SESSION['efiling_details']['efiling_no'];
            $est_code = $_SESSION['estab_details']['estab_code'];
        } else {
            $_SESSION['MSG'] = message_show("fail", 'Invalid request !');
            redirect('affirmation');
            exit(0);
        }


        if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_NEW_CASE) {
            $redirect_url = 'new_case/affirmation';
        } elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MISC_DOCS) {
            $redirect_url = 'miscellaneousFiling/affirmation';
        } elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_DEFICIT_COURT_FEE) {
            $redirect_url = 'Deficit_court_fee/affirmation';
        } elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_IA) {
            $redirect_url = 'IA/affirmation';
        }elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_JAIL_PETITION) {
            $redirect_url = 'jailPetition/affirmation';
        }
        $litigent_flag = url_decryption($_POST['litigent_flag']);
        $advocate_flag = url_decryption($_POST['adv_flag']);


        $mobile_otp = escape_data($this->input->post("mobile_otp"));
        if (empty($mobile_otp)) {
            echo '1@@@' . htmlentities('Please Enter OTP', ENT_QUOTES);
            exit(0);
        }
        $otp = $_SESSION['eVerified_mobile_otp']['LITIGENT_MOB_OTP_VERIFY'];
        $litigent_mobile = $_SESSION['eVerified_mobile_otp']['LITIGENT_MOBILE'];
        $litigent_name = $_SESSION['eVerified_mobile_otp']['LITIGENT_NAME'];



        $validate_name = validate_number($mobile_otp, TRUE, 6, 6, 'Mobile OTP');
        if ($validate_name['response'] == FALSE) {
            echo '1@@@' . htmlentities($validate_name['msg']['field_name'], ENT_QUOTES);
            exit(0);
        }

        if ($otp != $mobile_otp) {
            echo '1@@@' . htmlentities('Wrong Mobile OTP.', ENT_QUOTES);
            exit(0);
        }

        $est_code = $_SESSION['estab_details']['est_code'];
        $registration_id = $_SESSION['efiling_details']['registration_id'];
        $efiling_num = $_SESSION['efiling_details']['efiling_no'];
        $signed_pdf_full_path = getcwd() . '/uploaded_docs/' . $est_code . '/' . $efiling_num . '/signed_pdfs/';
        $signed_pdf_partial_path = 'uploaded_docs/' . $est_code . '/' . $efiling_num . '/signed_pdfs/';

        $signed_pdf_full_path_with_file_name = $signed_pdf_full_path . $efiling_num . '_advocate_otp_everified.pdf';
        $signed_pdf_partial_path_with_file_name = $signed_pdf_partial_path . $efiling_num . '_advocate_otp_everified.pdf';
        $signed_pdf_file_name = $efiling_num . '_advocate_otp_everified.pdf';
        $this->gen_mobile_advocate_affirmation($adv_mob, $adv_name);
        $type = ESIGNED_DOCS_BY_ADV;
        $name = $litigent_name;
        $mobile = $litigent_mobile;


        $data = array('ref_registration_id' => $registration_id,
            'ref_efiling_no' => $efiling_num,
            'type' => $type,
            'otp_mobile_no' => $verified_mobile,
            'is_data_valid' => TRUE,
            'signed_pdf_full_path' => $signed_pdf_full_path,
            'signed_pdf_full_path_with_file_name' => $signed_pdf_full_path_with_file_name,
            'signed_pdf_partial_path' => $signed_pdf_partial_path,
            'signed_pdf_partial_path_with_file_name' => $signed_pdf_partial_path_with_file_name,
            'signed_pdf_file_name' => $signed_pdf_file_name,
            'name_as_on_aadhar' => $name,
            'otp_mobile_no' => $mobile,
            'signed_type' => 3);

        if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_NEW_CASE) {
            $breadcrumbs_to_update = NEW_CASE_AFFIRMATION;
        } elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MISC_DOCS) {
            $breadcrumbs_to_update = MISC_BREAD_AFFIRMATION;
        } elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_IA) {
            $breadcrumbs_to_update = IA_BREAD_AFFIRMATION;
        } elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MENTIONING) {
            $breadcrumbs_to_update = MEN_BREAD_AFFIRMATION;
        }elseif ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_JAIL_PETITION) {
            $breadcrumbs_to_update = JAIL_PETITION_AFFIRMATION;
        }


        $result = $this->Affirmation_model->upload_pet_adv_esign_docs($data, $registration_id, $breadcrumbs_to_update);

        if ($result) {
            unset($_SESSION['MOB_OTP_VERIFY_UPLOADED_DOCS']);
            echo '2@@@' . htmlentities('OTP verified successfully!', ENT_QUOTES);
            exit(0);
        } else {
            echo '1@@@' . htmlentities('Wrong Mobile OTP.', ENT_QUOTES);
            exit(0);
        }
    }

    public function gen_mobile_advocate_affirmation($adv_mobile, $adv_name) {

        $registration_id = $_SESSION['efiling_details']['registration_id'];
        $efiling_num = $_SESSION['efiling_details']['efiling_no'];
        $est_code = $_SESSION['estab_details']['est_code'];



        $result = $this->Get_details_model->get_case_parties_details($registration_id, array('p_r_type' => 'R', 'm_a_type' => 'M', 'party_id' => NULL, 'view_lr_list' => FALSE));

        $_SESSION['breadcrumb_enable']['efiling_type'] = $result['ref_m_efiled_type_id'];

        if ($result[0]['orgid'] != '' && $result[0]['orgid'] != '0') {
            $org_name = $this->New_case_model->get_org_name($registration_id);
        }
        $uploaded_docs = $this->Common_model->get_uploaded_documents($registration_id);
        /* if (!(bool) $_SESSION['estab_details']['enable_payment_gateway']) {
          // $uploaded_receipts = $this->Stageslist_model->get_payment_preview_details($registration_id);
          } else {
          $uploaded_receipts = NULL;
          } */

//----------------------------------START PDF FOR Uploaded Document Hash-------------------------------------------// 

        $up_doc_hash1 = '<tr><td colspan="2" style="font-size:11px">&nbsp;<br/><strong>Uploaded Documents :</strong></td></tr>';
        $up_doc_hash2 = '<tr><td colspan="2"><table cellspacing="0" cellpadding="1" border="1" style="font-size:11px"><thead><tr style="background-color:#FFFF00;">
                <th style="width:5%" align="center"> # </th><th style="width:20%" align="center"> Title ( Documents ) </th><th style="width:25%" align="center"> Uploaded Documents  </th><th style="width:10%" align="center"> Pages </th> <th style="width:10%" align="center"> Index </th> <th style="width:30%" align="center">hash(SHA256)</th></tr></thead><tbody>';
        $sr = 1;
        $indx = 1;
        if (isset($uploaded_docs) && !empty($uploaded_docs)) {
            foreach ($uploaded_docs as $doc) {
                $st_indx = $indx;
                $indx += $doc->page_no;
                if ($doc->page_no != 1) {
                    $end_indx = $indx - 1;
                } else {
                    $end_indx = $st_indx;
                }
                $indx_txt = $st_indx . ' - ' . $end_indx;
                $up_doc_hash3 .= '<tr><td style="width:5%" align="center">' . htmlentities($sr++, ENT_QUOTES) . '</td><td style="width:20%" align="center">' . htmlentities(strtoupper($doc->doc_title), ENT_QUOTES) . '<br> ( ' . htmlentities(strtoupper($doc->doc_type_name), ENT_QUOTES) . ' )' . '</td><td style="width:25%" align="center">' . htmlentities($doc->file_name, ENT_QUOTES) . '</td><td style="width:10%" align="center">' . htmlentities($doc->page_no, ENT_QUOTES) . '</td><td style="width:10%" align="center">' . htmlentities($indx_txt, ENT_QUOTES) . '</td><td style="width:30%" align="center">' . htmlentities($doc->doc_hashed_value, ENT_QUOTES) . '</td></tr>';
            }
        } else {
            $up_doc_hash3 .= '<tr><td align="center" colspan="2">No Documents Uploaded</td></tr>';
        }

        $up_doc_hash4 .= '</tbody></table>';
        $up_doc_hash5 = '<br/></td></tr>';

        $up_doc_hash = $up_doc_hash1 . $up_doc_hash2 . $up_doc_hash3 . $up_doc_hash4 . $up_doc_hash5 . $oath_note;

//----------------------------------End PDF FOR Uploaded Document Hash-------------------------------------------// 
//----------------------------------START PDF FOR Advocate Affirmation-------------------------------------------//                                


        if ($result[0]['org_dept_id'] != '' && $result[0]['org_dept_id'] != '0') {
            $litigant_name = $org_name[0]['org_dept_name'];
            $litigant_details = 'I have explained the contents in the pleadings to the authorized representative of <strong>' . strtoupper($result[0]['party_name']) . '</strong> '
                    . '<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
                    'Authorized representative <strong>' . strtoupper($result[0]['name']) . '</strong>  has signed and verified the correctness of pleadings and uploaded documents  on behalf of <strong>' . strtoupper($litigant_name) . '</strong> .<br>'
                    . '<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
                    'I undertake to submit signed copies of pleadings and original / certified copies of documents physically before the court within time limit prescribed  by Rules / Notification issued by High Court further, hence verified on this <strong>' . date('d') . '</strong> Day of  <strong>' . date('M Y') . '.</strong>';
        } else {
            $litigant_name = $result[0]['party_name'];
            $litigant_details = 'I have explained him the contents in the pleadings. I have seen documents uploaded in support of the pleadings. '
                    . '<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                    . 'Litigant <strong>' . strtoupper($result[0]['pet_name']) . '</strong>  has signed and verified the correctness of pleadings and uploaded documents in my presence';
        }


        $oath_part_pet_tbl1 = '<table cellspacing="0" cellpadding="1" style="font-size:13px"><tbody>';

        $oath_title1 = '<tr><td  colspan="2" style="text-align:center"><strong> Identification and Verification</strong></td></tr>';
        $oath_part_head = '<tr><td style="text-align:left"><strong>Efiling Number : ' . efile_preview($_SESSION['efiling_details']['efiling_no']) . '</strong></td>
                                                <td style="text-align:right"><strong>Litigant Name : ' . strtoupper($litigant_name) . '</strong></td></tr>';
        $oath_part_pet1 = '<tr  colspan="2"><td></td></tr>';
        $oath_part_pet2 = '<tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                . 'The above named litigant <strong>' . strtoupper($litigant_name) . '</strong>  has filed his plaint/ complaint/ petition/ Appeal/ Application through me. ' . $litigant_details . ',</td></tr><br>';
        $oath_part_pet3 = '<tr><td colspan="2" style="text-align:right" ><strong>' . strtoupper($_SESSION['login']['first_name'] . ' ' . $_SESSION['login']['last_name']) . '</strong> </td></tr>';
        $oath_part_pet4 = '<tr><td colspan="2" style="text-align:right" >Bar Reg. No. <strong>' . strtoupper($_SESSION['login']['bar_reg_no']) . '</strong> </td></tr>';
        $oath_part_pet_tbl2 = '</tbody></table><br>';
        $oath_part11 = '<tr><td colspan="2" style="text-align:justify"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I undertake to submit signed copies of pleadings and original / certified copies of documents physically before the court within time limit prescribed  by Rules / Notification issued by High Court further, hence verified on this <strong>' . date('d') . '</strong> Day of  <strong>' . date('M Y') . '.</strong><br><br></td></tr>';
        $oath_tbl_adv = $oath_part_pet_tbl1 . $oath_part_head . $oath_title1 . $oath_part_pet1 . $oath_part_pet2 . $oath_part_pet3 . $oath_part_pet4 . $up_doc_hash . $oath_part_pet_tbl2 . $oath_part11;


// -------------------------------- End of PDF for Advocate Affirmation -------------------------------------------//
//------------------------Uploaded Receipts-----------------------//

        if (!(bool) $_SESSION['estab_details']['enable_payment_gateway']) {
            $temp_table_3 = '<h4> Fee Receipts :</h4><table cellspacing="0" cellpadding="1" border="1" style="font-size:11px"><thead><tr style="background-color:#FFFF00;color:#0000FF;">
                       <th style="width:5%" align="center"> # </th><th style="width:16%" align="center"> Transaction Number</th><th style="width:17%" align="center"> Transaction Date </th><th style="width:17%" align="center"> Court Fee </th> <th style="width:15%" align="center"> Uploaded On </th><th style="width:30%" align="center"> hash(SHA256)</th></tr></thead><tbody>';
            $sr = 1;
            if (isset($uploaded_receipts) && !empty($uploaded_receipts)) {
                foreach ($uploaded_receipts as $receipts) {
                    $temp_table_3 .= '<tr><td style="width:5%" align="center">' . htmlentities($sr++, ENT_QUOTES) . '</td><td style="width:16%" align="center">' . htmlentities($receipts['transaction_num'], ENT_QUOTES) . '</td><td style="width:17%" align="center">' . htmlentities(date('d-m-Y', strtotime($receipts['txn_complete_date'])), ENT_QUOTES) . '</td><td style="width:17%" align="center">' . htmlentities($receipts['user_declared_court_fee'], ENT_QUOTES) . '</td><td style="width:15%" align="center">' . htmlentities(date('d-m-Y H:i:s A', strtotime($receipts['receipt_upload_date'])), ENT_QUOTES) . '</td><td style="width:30%" align="center">' . htmlentities($receipts['receipts_hashed_value'], ENT_QUOTES) . '</td></tr>';
                }
            } else {
                $temp_table_3 .= '<tr><td align="center" style="width:100%" colspan="5">Fee not paid</td></tr>';
            }

            $temp_table_3 .= '</tbody></table>';
        } else {
            $temp_table_3 = '';
        }

        if (!empty($adv_mobile) && !empty($adv_name)) {

            //$adv_name = 'Party-in-Person <strong>' . strtoupper($_SESSION['login']['first_name'] . ' ' . $_SESSION['login']['last_name']) . '</strong>';
            $adv_name = strtoupper($adv_name);

            $mob_last_no = str_repeat("*", strlen($adv_mobile) - 2) . substr($adv_mobile, -2) . '.';
            $temp_table_4 = '<br><br><p style="text-align:center;"><b>eVerified By : </b>' . $adv_name . ' <b>  On Date : </b>' . date("d-m-Y H:i:s A", strtotime(htmlentities(date('Y-m-d H:i:s'), ENT_QUOTES))) . '<b>  Using Mobile :</b> ' . htmlentities($mob_last_no, ENT_QUOTES) . '</p>';
        } else {
            $temp_table_4 = '';
        }
//----------------------End Uploaded receipts--------------------//
        ob_start();
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetPrintHeader(FALSE);
        $pdf->SetPrintFooter(TRUE);

        $pdf->SetAuthor('Computer Cell, SCI');
        $pdf->SetTitle('Computer Cell, SCI');
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->SetFont('helvetica', '', 8, '', true);
        $pdf->AddPage();
        ob_end_clean();

        if ((bool) $_SESSION['estab_details']['enable_payment_gateway']) {
            $pdf->writeHTML($oath_tbl_adv . $temp_table_4, true, false, false, false, '');
        } else {
            $pdf->writeHTML($oath_tbl_adv . $temp_table_3 . $temp_table_4, true, false, false, false, '');
        }

        $pdf->lastPage();


        $est_code = $_SESSION['estab_details']['est_code'];
        $signed_pdf_path = 'uploaded_docs/' . $est_code . '/' . $efiling_num . '/signed_pdfs/';
        if (!is_dir($signed_pdf_path)) {
            $uold = umask(0);
            if (mkdir('uploaded_docs/' . $est_code . '/' . $efiling_num . '/signed_pdfs/', 0777, true)) {
                $html = '<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>';
                write_file($signed_pdf_path . '/index.html', $html);
            }
            umask($uold);
        }
        $pdf->Output($signed_pdf_path . $efiling_num . '_advocate_otp_everified.pdf', 'F');
        unset($_SESSION['eVerified_mobile_otp']['ADV_MOB_OTP_VERIFY']);
        unset($_SESSION['eVerified_mobile_otp']['ADV_MOBILE']);
        unset($_SESSION['eVerified_mobile_otp']['ADV_NAME']);
    }

}
