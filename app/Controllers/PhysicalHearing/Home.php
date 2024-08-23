<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
		if (!isset($_SESSION['loginData']) && empty($_SESSION['loginData'])) {
			redirect('auth');
		}else{
			is_user_status();
		}
        $this->load->helper('common');
        $this->load->helper('encryptdecrypt');
        $this->load->helper('myarray');
        $this->load->helper('curl');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->database('icmis');
        $this->load->model('consent_VC_model');
       // $this->getTodayData(); exit;
    }

    public function index(){

        if(!isset($this->session->loginData)){
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Session Expired. Please login again.</div>');
            unset($this->session->loginData);
            redirect('auth');
        }
        else{


			$type = !empty($this->session->userdata('loginData')['dec_type']) ? (int)$this->session->userdata('loginData')['dec_type']  : NULL;
			if(!empty($type)){

				switch ($type){
					case 1:
							$data['page_title']='Case List';
							if(isset($_POST['list_date']))
								$data['case_list']=$this->appearance_model->getFutureListedMatters($this->session->loginData['bar_id'], null, $_POST['list_date']);
							else
								$data['case_list']=$this->appearance_model->getFutureListedMatters($this->session->loginData['bar_id'], null);

                            $this->load->view('physical_hearing/menu');
							$this->load->view('physical_hearing/case_list', $data);

					break;
					case 2:
						if(!empty($this->session->userdata('loginData')['post_mobile'])){
							$params = array();
							$params['current_date'] = date('Y-m-d');
							$params['mobile'] = (int)$this->session->userdata('loginData')['post_mobile'];
							$this->load->model('auth_model');
							//today exist data
							$todayData = $this->auth_model->getSelfDeclarationTodayData($params);
							$data['todayData'] = !empty($todayData) ? $todayData: NULL;
						}
						$data['page_title']='Supreme Court Of India Self Declaration Form (For Entrants In the High Security Zone)';
						//$this->load->view('physical_hearing/menu');
						$this->load->view('physical_hearing/emp_self_details', $data);
						break;
						default;
				}

			}
			else{
				redirect('auth');
			}
        }
    }
    public function selfDeclarationForm()
	{
		if(!isset($this->session->loginData)){
			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Session Expired. Please login again.</div>');
			unset($this->session->loginData);
			redirect('auth');
		}
		else {
			//echo '<pre>'; print_r($this->session->loginData); exit;
			if(!empty($this->session->userdata('loginData')['mobile'])){
				$params = array();
				$params['current_date'] = date('Y-m-d');
				$params['mobile'] = (int)$this->session->userdata('loginData')['mobile'];
				$this->load->model('auth_model');
				//today exist data
				$todayData = $this->auth_model->getSelfDeclarationTodayData($params);
				$data['todayData'] = !empty($todayData) ? $todayData: NULL;
			}
			$data['page_title'] = 'Supreme Court Of India Self Declaration Form (For Entrants In the High Security Zone)';
			$this->load->view('physical_hearing/menu');
			$this->load->view('physical_hearing/emp_self_details', $data);
		}
	}
    public function getAttendeeList(){
    	$this->load->model('hearing_model');
		$result=$this->hearing_model->getAttendee();
		$attendeeArr = array();
		if(isset($result) && !empty($result)){
			foreach ($result as $k=>$v){
				$tmp =array();
				$tmp['id'] = $v['id'];
				$tmp['description'] = $v['description'];
				array_push($attendeeArr,(object)$tmp);
			}
		}
		echo json_encode(array('attendee'=>$attendeeArr));
		exit;
	}
	public function empSelfDeclarationData()
	{
		$data['page_title'] = 'Supreme Court Of India Self Declaration Form (For Entrants In the High Security Zone)';
		$this->load->view('physical_hearing/menu');
		$this->load->view('physical_hearing/emp_self_details_data', $data);

//		if(!isset($this->session->loginData)){
//		$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Session Expired. Please login again.</div>');
//		unset($this->session->loginData);
//		redirect('auth');
//	}
//	else {
//			$data['page_title'] = 'Supreme Court Of India Self Declaration Form (For Entrants In the High Security Zone)';
//			$this->load->view('physical_hearing/menu');
//			$this->load->view('physical_hearing/emp_self_details_data', $data);
//		}
	}
	public function getEmpSelfDeclarationData(){
		$this->load->model('auth_model');
		$params =array();
		$params['current_date'] = date('Y-m-d');
		$res = $this->auth_model->getSelfDeclarationTodayData($params);
		if(isset($res) && !empty($res)){
			echo json_encode(array('status'=>true,'empSelfData'=>$res));
			exit;
		}
		else{
			echo json_encode(array('status'=>false,'empSelfData'=>''));
			exit;
		}
	}
	public function getSearchEmpSelfDeclarationData(){
		$postData = json_decode(file_get_contents('php://input'), true);
		$params =array();
		if(isset($postData['fromDate']) && !empty($postData['fromDate'])){
			$params['fromDate'] = trim($postData['fromDate']);
		}
		if(isset($postData['toDate']) && !empty($postData['toDate'])){
			$params['toDate'] = trim($postData['toDate']);
		}
		$this->load->model('auth_model');
		$res ='';
		$res = $this->auth_model->getSelfDeclarationTodayData($params);
		if(isset($res) && !empty($res)){
			echo json_encode(array('status'=>true,'empSelfData'=>$res));
			exit;
		}
		else{
			echo json_encode(array('status'=>false,'empSelfData'=>''));
			exit;
		}
	}
	public function getTodayData(){
		if(!empty($this->session->userdata('loginData')['post_mobile'])){
			$params = array();
			$params['current_date'] = date('Y-m-d');
			$params['mobile'] = (int)$this->session->userdata('loginData')['post_mobile'];
			$this->load->model('auth_model');
			$todayData = $this->auth_model->getSelfDeclarationTodayData($params);
			$todayUserData = !empty($todayData) ? $todayData[0] : null;
			echo json_encode(array('success'=>true,'todayData'=>$todayUserData));
		}
		else if(!empty($this->session->userdata('loginData')['mobile'])){
			$params = array();
			$params['current_date'] = date('Y-m-d');
			$params['mobile'] = (int)$this->session->userdata('loginData')['mobile'];
			$this->load->model('auth_model');
			$todayData = $this->auth_model->getSelfDeclarationTodayData($params);
			$todayUserData = !empty($todayData) ? $todayData[0] : null;
			echo json_encode(array('success'=>true,'todayData'=>$todayUserData));
		}
	}
    public function welcomePage()
	{
		if(!isset($this->session->loginData)){
			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Session Expired. Please login again.</div>');
			unset($this->session->loginData);
			redirect('auth');
		}
		else {
		$data = array();
		$data['page_title'] = "Dashboard";
		if (!empty($this->session->userdata('loginData')['post_mobile'])) {
			$params = array();
			$params['current_date'] = date('Y-m-d');
			$params['mobile'] = (int)$this->session->userdata('loginData')['post_mobile'];
			$this->load->model('auth_model');
			$res = $this->auth_model->getSelfDeclarationTodayData($params);
			$data['empData'] = !empty($res) ? $res[0] : NULL;
		}
		$this->load->view('physical_hearing/dashboard', $data);
	}
	}
}
