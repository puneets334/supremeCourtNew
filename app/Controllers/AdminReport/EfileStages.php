<?php

namespace App\Controllers\AdminReport;

use App\Controllers\BaseController;
use App\Libraries\webservices\Efiling_webservices;
use App\Models\AdminDashboard\EfileStageModel;

class EfileStages extends BaseController {

    protected $EfileStage_Model;
    protected $efiling_webservices;

    public function __construct() {
        parent:: __construct();
        $this->EfileStage_Model = new EfileStageModel();
        $this->efiling_webservices = new Efiling_webservices();

        if(empty(getSessiondata('login')['ref_m_usertype_id'])){
            return redirect()->to(base_url('/'));
            exit(0);
        }
        $allowed_users_array = array(USER_ADMIN);
        if (!in_array(getSessiondata('login')['ref_m_usertype_id'], $allowed_users_array)) {
            return redirect()->to(base_url('adminDashboard'));
            exit(0);
        }
    }

    public function index() {
        return $this->render('adminReport.efile_stages_search');        
    }

    public function search() {
        $efileno  = str_replace('-','', $_GET['efileno']);
        if (empty($efileno)) {
            $this->session->setFlashdata('message', "<div class='text-danger'>Please enter E-file No.</div>");
            return redirect()->to(base_url('adminReport/EfileStages'));
            exit;
        }
        $case_details = $this->EfileStage_Model->getEfileListWithStage($efileno);
        $stage_list = $this->EfileStage_Model->getStageList();
        $data = [
            'efileno'      => $efileno,
            'case_details' => $case_details,
            'stage_list'   => $stage_list
        ];
        return $this->render('adminReport.efile_stages_search', $data);
    }

    public function updateStage() {
        $efile_no = $_POST['efileno'];
        $remarks  = $_POST['remarks'];
        $stage_id = $_POST['stage_id'];
        $errors = [];
        if(empty($stage_id) && empty($remarks)) {
            $errors = [
                'status' =>false,
                'message'=>'Please select stage and add remarks.',
                'token'  =>$this->security->get_csrf_hash()
            ];
        } elseif(is_null($stage_id) || !isset($stage_id) || empty($stage_id)) {
            $errors = [
                'status'=>false,
                'message'=>'Please select stage.',
                'token'=>$this->security->get_csrf_hash()
            ];
        } elseif(is_null($remarks) || !isset($remarks) || empty($remarks)) {
            $errors = [
                'status'=>false,
                'message'=>'Please add remarks.',
                'token'=>$this->security->get_csrf_hash()
            ];
        } elseif(!in_array($stage_id,[1,12])) {
            $errors = [
                'status'=>false,
                'message'=>'Only Draft or Case-E-Filed stages are allowed and you are choosing wrong stage.',
                'token'=>$this->security->get_csrf_hash()
            ];
        }
        if(count($errors)) {
            $this->output->set_content_type('application/json')->set_output(json_encode($errors))->_display();
            $errors = [];
            exit;
        }
        $efile_num_status_data = $this->EfileStage_Model->getEfileStageData($efile_no);
        if((in_array($efile_num_status_data->stage_id,[9,10,11]) && $stage_id=='12') || (in_array($efile_num_status_data->stage_id,[8]) && $stage_id=='1')) {            
            $efile_num_status_data->remarks        = $remarks;
            $efile_num_status_data->datetime       = date('Y-m-d H:i:s');
            $efile_num_status_data->remote_addr    = $_SERVER['REMOTE_ADDR'];
            $efile_num_status_data->loginid        = $_SESSION['login']['id'];
            $efile_num_status_data->stage_id       = $stage_id;
            $diaryno = $this->efiling_webservices->getCaseDiaryNo($efile_no);
            if($stage_id=='12' && $diaryno=='null') {
                $errors = [
                    'status' =>false,
                    'message'=>"You can't change stage because diary no is not generated yet.",
                    'token'  =>$this->security->get_csrf_hash()
                ];
            }
            if($stage_id=='1' && $diaryno!='null') {
                $errors = [
                    'status' =>false,
                    'message'=>"You can't change stage because diary no is generated.",
                    'token'  =>$this->security->get_csrf_hash()
                ];
            }
            $efile_obj_cases = $this->EfileStage_Model->getObjections($efile_num_status_data->registration_id);
            if($efile_obj_cases==false) {
                $errors = [
                    'status' =>false,
                    'message'=>"You can't change stage because no defects on SCeFM.",
                    'token'  =>$this->security->get_csrf_hash()
                ];
            }
            $obj_cases = $this->efiling_webservices->getObjectionsByDiaryNo($diaryno);
            $obj_cases = json_decode($obj_cases);
            if(!empty($obj_cases)) {
                $errors = [
                    'status' =>false,
                    'message'=>"You can't change stage because defects found on icmis.",
                    'token'  =>$this->security->get_csrf_hash()
                ];
            }          
            if(count($errors)) {
                $this->output->set_content_type('application/json')->set_output(json_encode($errors))->_display();
                exit;
            }
            die;
            $result = $this->EfileStage_Model->updateStageData($efile_num_status_data,$obj_cases,$efile_obj_cases);
            if ($result) {
                $response = [
                    'status' =>true,
                    'message'=>'Stage updated successfully.',
                    'efileno'=>$efile_no
                ];
            } else{
                $response = [
                    'status' =>false,
                    'message'=>'Unable to update stage, please contact to Computer Cell.',
                    'token'  =>$this->security->get_csrf_hash()
                ];
               
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($response))->_display();
            exit;
        } else{
            $errors = [
                'status'=>false,
                'message'=>'You are doing something wrong, please contact to Computer Cell.',
                'token'=>$this->security->get_csrf_hash()
            ];
        }
        if(count($errors)) {
            $this->output->set_content_type('application/json')->set_output(json_encode($errors))->_display();
            exit;
        }
    }

}