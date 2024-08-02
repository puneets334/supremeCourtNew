<?php
namespace App\Controllers\assistance;
use App\Controllers\BaseController;
use App\Libraries\webservices\Efiling_webservices;
use App\Models\newregister\Advocate_model;
use App\Models\FilingAdmin\FilingAdminModel;
use App\Models\Assistance\Notice_ciruclars_model;

class Notice_circularsController extends BaseController {
    // protected $Notice_ciruclars_model;
    // public function __construct() {
      
    //     parent::__construct();
    //     // $this->load->helper();
    //     // //load the login model
    //     // $this->load->model('assistance/Notice_ciruclars_model');
    //     // $this->load->library('form_validation');
    //     // $this->load->helper('file');
    //     $this->load->model('Assistance/Notice_ciruclars_model');
    //     $this->Notice_ciruclars_model = new Notice_ciruclars_model();
    // }

    protected $Advocate_model;
    public function __construct() {
      
        parent::__construct();
        // $this->load->model('newregister/Advocate_model');
        $this->Advocate_model = new Advocate_model;
    }
   

    public function index() {
      
      

   
        //$data['notice_circualrs'] = $this->Notice_ciruclars_model->notice_circulars_list();
        $data['advocate_details'] = $this->Advocate_model->get_advocate_details();


        
    
        return $this->render('assistance.notice_circulars_view',$data);


       
        // $this->load->view('templates/header');
        // $this->load->view('assistance/notice_circulars_view', $data);
        // $this->load->view('templates/footer');
    }

    public function edit($id = NULL) {
        if (($_SESSION['login']['ref_m_usertype_id'] != USER_ADMIN)) {
            redirect('login');
            exit(0);
        }
        if ($id != NULL) {

            $id = (int) url_decryption($id);
            $data['get_data'] = $this->Notice_ciruclars_model->get_news_by_id($id);
        }

        $data['notice_circualrs'] = $this->Notice_ciruclars_model->notice_circulars_list();
        $this->load->view('templates/admin_header');
        $this->load->view('assistance/notice_circulars_view', $data);
        $this->load->view('templates/footer');
    }

    public function add_notice_circurlar($edit_id = null) {
        if ($_SESSION['login']['ref_m_usertype_id'] != USER_ADMIN) {
            redirect('login');
            exit(0);
        }
        $InputArray = $this->input->post();

        $this->form_validation->set_rules('news_title', 'Title', 'required|trim|min_length[10]|max_length[240]|validate_alpha_numeric_space_dot_hyphen');
        //$this->form_validation->set_rules('news_doc', 'Document', 'required');
        $this->form_validation->set_rules('pdf_is', 'Item', 'required|trim|in_list[Notice,Circular]');
        //$this->form_validation->set_rules('deactivate_date', 'Deactivate Date', 'trim|validate_date_dd_mm_yyyy');


        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->error_array();

            $this->session->set_flashdata('news_title', '<div class="text-danger">' . $error['news_title'] . '</div>');
            $this->session->set_flashdata('news_doc', '<div class="text-danger">' . $error['news_doc'] . '</div>');
            $this->session->set_flashdata('pdf_is', '<div class="text-danger">' . $error['news_view[]'] . '</div>');
            $this->session->set_flashdata('deactivate_date', '<div class="text-danger">' . $error['deactivate_date'] . '</div>');

            // $this->session->set_flashdata('MSG', '<div class="alert alert-danger text-center">'.$error.'</div>');
            redirect('assistance/notice_circulars');
            exit(0);
        }

        $is_notice = in_array('Notice', $InputArray['pdf_is']) ? TRUE : FALSE;

        $is_circular = in_array('Circular', $InputArray['pdf_is']) ? TRUE : FALSE;

        $deactivate_date = ($InputArray['deactivate_date']) ? date('Y-m-d', strtotime($InputArray['deactivate_date'])) : NULL;

        if (!empty($_FILES['news_doc']['name'])) {
            if ($msg = isValidPDF('news_doc')) {
                $this->session->set_flashdata('MSG', $msg);
                redirect('assistance/notice_circulars');
                exit(0);
            }

            $file_name = time() . rand() . ".pdf";
            //$file_uploaded_path = base_url('news/' . $file_name);
            $file_uploaded_path = 'news/' . $file_name;
        } elseif (empty($_FILES['news_doc']['name'])) {
            $_SESSION['MSG'] = '<center><p style="background: #f2dede;border: #f2dede;color: black;">Select Pdf File is Requerd!</p></center>';
            redirect('assistance/notice_circulars');
        } else {
            $file_name = NULL;
            $file_uploaded_path = NULL;
        }
        //echo url_decryption($edit_id); die;   
        if ($edit_id == NULL || $edit_id == '') {

            $insert_array = array(
                'news_title' => strtoupper(trim($InputArray['news_title'])),
                'file_name' => $file_name,
                'file_uploaded_path' => $file_uploaded_path,
                'created_by' => $_SESSION['login']['id'],
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
                'updated_by' => $_SESSION['login']['id'],
                'update_date' => date('Y-m-d H:i:s'),
                'update_by_ip' => $_SERVER['REMOTE_ADDR']
            );

            $result = $this->Notice_ciruclars_model->update_news_by_id(url_decryption($edit_id), $update_array, $_FILES['news_doc']['tmp_name']);
        } else {
            $this->session->set_flashdata('MSG', '<div class="alert alert-danger text-center">Invalid Request.</div>');
            redirect('assistance/notice_circulars');
            exit(0);
        }

        if ($result) {
            if (!empty(url_decryption($edit_id))) {
                $this->session->set_flashdata('MSG', '<div class="alert alert-success text-center">Updated Successfully</div>');
            } else {
                $this->session->set_flashdata('MSG', '<div class="alert alert-success text-center">Added Successfully</div>');
            }
            redirect('assistance/notice_circulars');
            exit(0);
        } else {
            $this->session->set_flashdata('MSG', '<div class="alert alert-danger text-center">Some error ! Please try after some time.</div>');
            redirect('assistance/notice_circulars');
            exit(0);
        }
    }

    public function action($action) {
        if ($_SESSION['login']['ref_m_usertype_id'] != USER_ADMIN) {
            redirect('login');
            exit(0);
        }

        $action = explode('$$', url_decryption($action));

        if ($action[1] == 'D') {
            $update_array = array(
                'is_deleted' => TRUE,
                'deleted_by' => $_SESSION['login']['id'],
                'deleted_on' => date('Y-m-d H:i:s'),
                'delete_ip' => $_SERVER['REMOTE_ADDR']
            );
        } elseif ($action[1] == 'D') {
            $update_array = array(
                'is_deleted' => TRUE,
                'deleted_by' => 0,
                'deleted_on' => NULL,
                'delete_ip' => NULL,
                'updated_by' => $_SESSION['login']['id'],
                'update_date' => date('Y-m-d H:i:s'),
                'update_by_ip' => $_SERVER['REMOTE_ADDR']
            );
        } else {
            $this->session->set_flashdata('MSG', '<div class="alert alert-danger text-center">Invalid Request.</div>');
            redirect('assistance/notice_circulars');
            exit(0);
        }
        $result = $this->Notice_ciruclars_model->update_news_by_id($action[0], $update_array);
        if ($result) {
            $this->session->set_flashdata('MSG', '<div class="alert alert-success text-center">News Status Change Successfully</div>');
            redirect('assistance/notice_circulars');
        } else {
            $this->session->set_flashdata('MSG', '<div class="alert alert-danger text-center">Something Wrong Please try Again.</div>');
            redirect('assistance/notice_circulars/' . $id);
        }
    }

    function view($id) {
        $id = url_decryption($id);

        if (!$id) {
            $this->session->set_flashdata('MSG', '<div class="alert alert-danger text-center">Invalid Request.</div>');
            redirect('assistance/notice_circulars');
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
                @readfile($file_uploaded_path);
            }
        }
    }

}
