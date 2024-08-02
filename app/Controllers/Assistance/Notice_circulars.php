<?php
namespace App\Controllers\Assistance;
use App\Controllers\BaseController;
use App\Models\Assistance\Notice_ciruclars_model;
use App\Models\newregister\Advocate_model;

class Notice_circulars extends BaseController {
    
    protected $Notice_ciruclars_model;
    protected $Advocate_model;
    protected $session;
    protected $config;
    protected $request;
    protected $validation;

    public function __construct() {
        parent::__construct();
        // $this->load->helper();
        //load the login model
        // $this->load->model('assistance/Notice_ciruclars_model');
        // $this->load->library('form_validation');
        // $this->load->helper('file');
        $this->Notice_ciruclars_model = new Notice_ciruclars_model();
        $this->Advocate_model = new Advocate_model;
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
        helper(['file']);
    }

    public function index() {
        $allowed_users = array(USER_ADMIN, USER_ADVOCATE, USER_IN_PERSON, USER_CLERK,SR_ADVOCATE);
        if (!in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users)) {
            redirect('login');
            exit(0);
        }
        $data['notice_circualrs'] = $this->Notice_ciruclars_model->notice_circulars_list();
        $data['advocate_details'] = $this->Advocate_model->get_advocate_details();
        $data['get_data'] = array();
        // $this->load->view('templates/header');
        $this->render('assistance.notice_circulars_view', $data);
        // $this->load->view('templates/footer');
    }

    public function edit($id = NULL) {
        if ((getSessionData('login')['ref_m_usertype_id'] != USER_ADMIN)) {
            redirect('login');
            exit(0);
        }
        if ($id != NULL) {
            $id = (int) url_decryption($id);
            $data['get_data'] = $this->Notice_ciruclars_model->get_news_by_id($id);
        }
        $data['notice_circualrs'] = $this->Notice_ciruclars_model->notice_circulars_list();
        // $this->load->view('templates/admin_header');
        $this->render('assistance.notice_circulars_view', $data);
        // $this->load->view('templates/footer');
    }

    public function add_notice_circurlar($edit_id = null) {
        if (getSessionData('login')['ref_m_usertype_id'] != USER_ADMIN) {
            redirect('login');
            exit(0);
        }
        $InputArray = $this->request->getPost();
        // $this->form_validation->set_rules('news_title', 'Title', 'required|trim|min_length[10]|max_length[240]|validate_alpha_numeric_space_dot_hyphen');
        //$this->form_validation->set_rules('news_doc', 'Document', 'required');
        // $this->form_validation->set_rules('pdf_is', 'Item', 'required|trim|in_list[Notice,Circular]');
        //$this->form_validation->set_rules('deactivate_date', 'Deactivate Date', 'trim|validate_date_dd_mm_yyyy');
        // if ($this->form_validation->run() == FALSE) {
        //     $error = $this->form_validation->error_array();
        //     setSessionData('news_title', '<div class="text-danger">' . $error['news_title'] . '</div>');
        //     setSessionData('news_doc', '<div class="text-danger">' . $error['news_doc'] . '</div>');
        //     setSessionData('pdf_is', '<div class="text-danger">' . $error['news_view[]'] . '</div>');
        //     setSessionData('deactivate_date', '<div class="text-danger">' . $error['deactivate_date'] . '</div>');
        //     // setSessionData('MSG', '<div class="alert alert-danger text-center">'.$error.'</div>');
        //     redirect('assistance/notice_circulars');
        //     exit(0);
        // }
        $this->validation->setRules([
            "news_title" => [
                "label" => "Title",
                "rules" => "required|trim|min_length[10]|max_length[240]|regex_match[/^[a-zA-Z0-9 .-]+$/]"
            ],
            "pdf_is" => [
                "label" => "Item",
                "rules" => "required|trim|in_list[Notice,Circular]"
            ],
        ]);
        if ($this->validation->withRequest($this->request)->run() === FALSE) {
            setSessionData('news_title', '<div class="text-danger">' . $this->validation->getError('news_title') . '</div>');
            setSessionData('news_doc', '<div class="text-danger">' . $this->validation->getError('news_doc') . '</div>');
            setSessionData('pdf_is', '<div class="text-danger">' . $this->validation->getError('news_view[]') . '</div>');
            setSessionData('deactivate_date', '<div class="text-danger">' . $this->validation->getError('deactivate_date') . '</div>');
            // setSessionData('MSG', '<div class="alert alert-danger text-center">'.$error.'</div>');
            return redirect()->to(base_url('assistance/notice_circulars'));
            exit(0);
        } else{
            $is_notice = in_array('Notice', (array) $InputArray['pdf_is']) ? TRUE : FALSE;
            $is_circular = in_array('Circular', (array) $InputArray['pdf_is']) ? TRUE : FALSE;
            $deactivate_date = ($InputArray['deactivate_date']) ? date('Y-m-d', strtotime($InputArray['deactivate_date'])) : NULL;
            if (!empty($_FILES['news_doc']['name'])) {
                if ($msg = isValidPDF('news_doc')) {
                    setSessionData('MSG', $msg);
                    return redirect()->to(base_url('assistance/notice_circulars'));
                    exit(0);
                }
                $file_name = time() . rand() . ".pdf";
                //$file_uploaded_path = base_url('news/' . $file_name);
                $file_uploaded_path = 'news/' . $file_name;
            } elseif (empty($_FILES['news_doc']['name'])) {
                setSessionData('MSG', '<center><p style="background: #f2dede;border: #f2dede;color: black;">Select Pdf File is Requerd!</p></center>');
                return redirect()->to(base_url('assistance/notice_circulars'));
            } else {
                $file_name = NULL;
                $file_uploaded_path = NULL;
            }
            if ($edit_id == NULL || $edit_id == '') {
                $insert_array = array(
                    'news_title' => strtoupper(trim($InputArray['news_title'])),
                    'file_name' => $file_name,
                    'file_uploaded_path' => $file_uploaded_path,
                    'created_by' => getSessionData('login')['id'],
                    'create_by_ip' => $_SERVER['REMOTE_ADDR'],
                    'deactive_date' => $deactivate_date,
                    'is_notice' => $is_notice,
                    'is_circular' => $is_circular
                );
                $result = $this->Notice_ciruclars_model->insert_news($insert_array, $_FILES['news_doc']['tmp_name']);
            } elseif (!empty(url_decryption($edit_id))) {
                $update_array = array(
                    'news_title' => strtoupper(trim($InputArray['news_title'])),
                    'file_name' => $file_name,
                    'file_uploaded_path' => 'news/' . $file_name,
                    'deactive_date' => $deactivate_date,
                    'is_notice' => $is_notice,
                    'is_circular' => $is_circular,
                    'updated_by' => getSessionData('login')['id'],
                    'update_date' => date('Y-m-d H:i:s'),
                    'update_by_ip' => $_SERVER['REMOTE_ADDR']
                );
                $result = $this->Notice_ciruclars_model->update_news_by_id(url_decryption($edit_id), $update_array, $_FILES['news_doc']['tmp_name']);
            } else {
                setSessionData('MSG', '<div class="alert alert-danger text-center">Invalid Request.</div>');
                return redirect()->to(base_url('assistance/notice_circulars'));
                exit(0);
            }
            if ($result) {
                if (!empty(url_decryption($edit_id))) {
                    setSessionData('MSG', '<div class="alert alert-success text-center">Updated Successfully</div>');
                } else {
                    setSessionData('MSG', '<div class="alert alert-success text-center">Added Successfully</div>');
                }
                return redirect()->to(base_url('assistance/notice_circulars'));
                exit(0);
            } else {
                setSessionData('MSG', '<div class="alert alert-danger text-center">Some error ! Please try after some time.</div>');
                return redirect()->to(base_url('assistance/notice_circulars'));
                exit(0);
            }
        }
    }

    public function action($action) {
        if (getSessionData('login')['ref_m_usertype_id'] != USER_ADMIN) {
            redirect('login');
            exit(0);
        }
        $action = explode('$$', url_decryption($action));
        if ($action[1] == 'D') {
            $update_array = array(
                'is_deleted' => TRUE,
                'deleted_by' => getSessionData('login')['id'],
                'deleted_on' => date('Y-m-d H:i:s'),
                'delete_ip' => $_SERVER['REMOTE_ADDR']
            );
        } elseif ($action[1] == 'D') {
            $update_array = array(
                'is_deleted' => TRUE,
                'deleted_by' => 0,
                'deleted_on' => NULL,
                'delete_ip' => NULL,
                'updated_by' => getSessionData('login')['id'],
                'update_date' => date('Y-m-d H:i:s'),
                'update_by_ip' => $_SERVER['REMOTE_ADDR']
            );
        } else {
            setSessionData('MSG', '<div class="alert alert-danger text-center">Invalid Request.</div>');
            return redirect()->to(base_url('assistance/notice_circulars'));
            exit(0);
        }
        $result = $this->Notice_ciruclars_model->update_news_by_id($action[0], $update_array);
        if ($result) {
            setSessionData('MSG', '<div class="alert alert-success text-center">News Status Change Successfully</div>');
            return redirect()->to(base_url('assistance/notice_circulars'));
        } else {
            setSessionData('MSG', '<div class="alert alert-danger text-center">Something Wrong Please try Again.</div>');
            return redirect()->to(base_url('assistance/notice_circulars/' . $id));
        }
    }

    function view($id) {
        $id = url_decryption($id);
        if (!$id) {
            setSessionData('MSG', '<div class="alert alert-danger text-center">Invalid Request.</div>');
            return redirect()->to(base_url('assistance/notice_circulars'));
            exit(0);
        } else {
            $result = $this->Notice_ciruclars_model->get_news_by_id($id);
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