<?php

// if (!defined('BASEPATH')) exit('No direct script access allowed');

namespace App\Controllers\Assistance;
use App\Controllers\BaseController;
use App\Models\Assistance\Performas_model;

class Performas extends BaseController {

    protected $Performas_model;
    protected $session;
    protected $config;
    protected $request;
    protected $validation;

    public function __construct() {
        parent::__construct();
        // $this->load->helper();
        // $this->load->model('assistance/Performas_model');
        // $this->load->library('form_validation');
        // $this->load->helper('file');
        $this->Performas_model = new Performas_model();
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
        helper(['file']);
        if(empty(getSessionData('login'))){
            return response()->redirect(base_url('/')); 
        } else{
            is_user_status();
        }
        $allowed_users = array(USER_ADMIN, USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, SR_ADVOCATE);
        if (getSessionData('login') != '' && !in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users)) {
            return response()->redirect(base_url('/'));
            exit(0);
        }
    }

    public function index() {
        $allowed_users = array(USER_ADMIN, USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, SR_ADVOCATE);
        if (getSessionData('login') != '' && !in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users)) {
            return response()->redirect(base_url('/'));
            exit(0);
        }
        $data['notice_circualrs'] = $this->Performas_model->notice_circulars_list();
        $data['get_data'] = array();
        // $this->load->view('templates/header');
        $this->render('assistance.performas_view', $data);
        // $this->load->view('templates/footer');
    }

    public function edit($id = NULL) {
        if (getSessionData('login') != '' && (getSessionData('login')['ref_m_usertype_id'] != USER_ADMIN)) {
            return response()->redirect(base_url('/'));
            exit(0);
        }
        if ($id != NULL) {
            $id = (int) url_decryption($id);
            $data['get_data'] = $this->Performas_model->get_news_by_id($id);
        }
        $data['notice_circualrs'] = $this->Performas_model->notice_circulars_list();
        // $this->load->view('templates/admin_header');
        $this->render('assistance.performas_view', $data);
        // $this->load->view('templates/footer');
    }

    public function add_notice_circurlar($edit_id = null) {
        if (getSessionData('login') != '' && getSessionData('login')['ref_m_usertype_id'] != USER_ADMIN) {
            return response()->redirect(base_url('/'));
            exit(0);
        }
        $InputArray = $this->request->getPost();
        // $this->form_validation->set_rules('performa_title', 'Title', 'required|trim|min_length[5]|max_length[240]|validate_alpha_numeric_space_dot_hyphen');
        // if ($this->form_validation->run() == FALSE) {
        //     $error = $this->form_validation->error_array();
        //     setSessionData('performa_title', '<div class="text-danger">' . $error['performa_title'] . '</div>');
        //     setSessionData('pdf_is', '<div class="text-danger">' . $error['news_view[]'] . '</div>');
        //     redirect('assistance/performas');
        //     exit(0);
        // }
        $this->validation->setRules([
            "performa_title" => [
                "label" => "Title",
                "rules" => "required|trim|min_length[5]|max_length[240]|regex_match[/^[a-zA-Z0-9 .-]+$/]"
            ],
            // "news_doc" => [
            //     "label" => "PDF",
            //     "rules" => "required"
            // ],
        ]);
        if ($this->validation->withRequest($this->request)->run() === FALSE) {
            $this->session->setFlashdata('performa_title', '<div class="text-danger">' . $this->validation->getError('performa_title') . '</div>');
            $this->session->setFlashdata('pdf_is', '<div class="text-danger">' . $this->validation->getError('news_view[]') . '</div>');
            return redirect()->to(base_url('assistance/performas'));
            exit(0);
        } else{
            $deactivate_date = 'NULL';
            if (!empty($_FILES['news_doc']['name'])) {
                if ($msg = isValidPDF('news_doc')) {
                    $this->session->setFlashdata('MSG', $msg);
                    return redirect()->to(base_url('assistance/performas'));
                    exit(0);
                }
                $file_name = time() . rand() . ".pdf";
                //$file_uploaded_path = base_url('news/' . $file_name);
                $file_uploaded_path = 'news/' . $file_name;
            } elseif (empty($_FILES['news_doc']['name'])) {
                $this->session->setFlashdata('MSG', '<center><p style="background: #f2dede;border: #f2dede;color: black;">Select Pdf File is Requerd!</p></center>');
                return redirect()->to(base_url('assistance/performas'));
            } else{
                $file_name = NULL;
                $file_uploaded_path = NULL;
            }
            if ($edit_id == NULL || $edit_id == '') {
                $insert_array = array(
                    'performa_title' => strtoupper(trim($InputArray['performa_title'])),
                    'file_name' => $file_name,
                    'file_uploaded_path' => $file_uploaded_path,
                    'created_by' => getSessionData('login')['id'],
                    'create_by_ip' => getClientIP()
                );
                $result = $this->Performas_model->insert_news($insert_array, $_FILES['news_doc']['tmp_name']);
            } elseif (!empty(url_decryption($edit_id))) {
                $update_array = array(
                    'performa_title' => strtoupper(trim($InputArray['performa_title'])),
                    'file_name' => $file_name,
                    'file_uploaded_path' => 'news/' . $file_name,
                    'updated_by' => getSessionData('login')['id'],
                    'update_date' => date('Y-m-d H:i:s'),
                    'update_by_ip' => getClientIP()
                );
                $result = $this->Performas_model->update_news_by_id(url_decryption($edit_id), $update_array, $_FILES['news_doc']['tmp_name']);
            } else{
                $this->session->setFlashdata('MSG', '<div class="alert alert-danger text-center">Invalid Request!</div>');
                return redirect()->to(base_url('assistance/performas'));
                exit(0);
            }
            if ($result) {
                if (!empty(url_decryption($edit_id))) {
                    $this->session->setFlashdata('MSG', '<div class="alert alert-success text-center">Updated Successfully.</div>');
                } else{
                    $this->session->setFlashdata('MSG', '<div class="alert alert-success text-center">Added Successfully.</div>');
                }
                return redirect()->to(base_url('assistance/performas'));
                exit(0);
            } else{
                $this->session->setFlashdata('MSG', '<div class="alert alert-danger text-center">Some error ! Please try after some time.</div>');
                return redirect()->to(base_url('assistance/performas'));
                exit(0);
            }
        }
    }

    public function action($action) {
        if (getSessionData('login') != '' && getSessionData('login')['ref_m_usertype_id'] != USER_ADMIN) {
            return response()->redirect(base_url('/'));
            exit(0);
        }
        $action = explode('$$', url_decryption($action));
        if ($action[1] == 'D') {
            $update_array = array(
                'is_deleted' => TRUE,
                'deleted_by' => getSessionData('login')['id'],
                'deleted_on' => date('Y-m-d H:i:s'),
                'delete_ip' => getClientIP()
            );
        } elseif ($action[1] == 'D') {
            $update_array = array(
                'is_deleted' => TRUE,
                'deleted_by' => 0,
                'deleted_on' => NULL,
                'delete_ip' => NULL,
                'updated_by' => getSessionData('login')['id'],
                'update_date' => date('Y-m-d H:i:s'),
                'update_by_ip' => getClientIP()
            );
        } else{
            $this->session->setFlashdata('MSG', '<div class="alert alert-danger text-center">Invalid Request!</div>');
            return redirect()->to(base_url('assistance/performas'));
            exit(0);
        }
        $result = $this->Performas_model->update_news_by_id($action[0], $update_array);
        if ($result) {
            $this->session->setFlashdata('MSG', '<div class="alert alert-success text-center">News Status Changed Successfully.</div>');
            return redirect()->to(base_url('assistance/performas'));
        } else{
            $this->session->setFlashdata('MSG', '<div class="alert alert-danger text-center">Something Went Wrong! Please try Again.</div>');
            return redirect('assistance/notice_circulars/' . $id);
        }
    }

    function view($id) {
        $id = url_decryption($id);
        if (!$id) {
            $this->session->setFlashdata('MSG', '<div class="alert alert-danger text-center">Invalid Request.</div>');
            return redirect()->to(base_url('assistance/performas'));
            exit(0);
        } else{
            $result = $this->Performas_model->get_news_by_id($id);
            // pr($result);
            if (isset($result) && !empty($result)) {
                $file_name = $result[0]['file_name'];
                $file_uploaded_path = base_url($result[0]['file_uploaded_path']);
                header("Content-Type: application/pdf");
                header("Content-Disposition:inline;filename=$file_name" . '.pdf');
                header('Content-Transfer-Encoding: binary');
                header('Accept-Ranges: bytes');
                ob_get_clean();
                readfile($file_uploaded_path);
                ob_end_flush();
            }
        }
    }

}