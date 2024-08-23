<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Audit_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
		$this->load->database(); // Load default database
		$this->db = $this->load->database('physical_hearing', TRUE);
    }
	public function log($action,$user_id, $data = null) {
		// Ensure the default database is being used

		/*$this->db->SELECT('*');
		$this->db->FROM('audit_trail');
		$query = $this->db->get();
		if ($query->num_rows() >= 1) {
			$result= $query->result();
		} else {
			$result= array();
		}
		echo '<pre>';print_r($result);exit();*/
    	//echo 'ANshu Audit_model';exit();
		$from_ip=get_client_ip();
		$response=$this->db->insert('audit_trail', array(
			'action' => $action,
			'user_id' => $user_id,
			'from_ip' => $from_ip,
			'log_data' => json_encode($data)
		));
		return $response;
	}


//XXXXXXXXXXXXXXXXXXXXX work start Anshu Security Audit XXXXXXXXXXXXXXXXXXXXXXXXXXXX
//Start Same user logged in in multiple browser
	function is_user_status($id,$ref_m_usertype_id=null) {
		$this->db->SELECT('*');
		$this->db->FROM('tbl_users_login_log');
		$this->db->WHERE('login_id', $id);
		#$this->db->WHERE('ip_address', getClientIP());
		$this->db->WHERE('is_successful_login', true);
		$this->db->LIMIT(1);
		$this->db->ORDER_BY("log_id", "DESC");
		$query = $this->db->get();
		/* echo $this->db->last_query();
		 exit();*/
		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	public function logUser($action, $data) {
		if ($action == 'login') {
			$this->db->insert('tbl_users_login_log', $data);
			// $this->db->last_query();//die;
			$insert_id = $this->db->insert_id();
			$session_data = $this->session->userdata('loginData');
			$session_data['log_id'] = $insert_id;
			$this->session->set_userdata("loginData", $session_data);
			return true;
		} elseif ($action == 'logout') {
			$this->db->set('logout_time', $data['logout_time']);
			$this->db->WHERE('log_id', $data['log_id']);
			$this->db->UPDATE('tbl_users_login_log');
			return true;
		}
	}
	//End Same user logged in in multiple browser
	public function get_user_block_dtl($id) {
		$this->db->SELECT('*');
		$this->db->FROM('tbl_user_failure_login_log');
		$this->db->WHERE('login_id', $id);
		$this->db->WHERE('is_valid', 'T');
		$query = $this->db->get();
		/* echo $this->db->last_query();
		 exit();*/
		if ($query->num_rows() >= 1) {

			return $query->result();
		} else {
			return FALSE;
		}
	}//End of function get_user_block_dtl ..
	public function get_failure_user_details($username) {
		$this->db->SELECT('id');
		$this->db->FROM('users');
		$this->db->WHERE('LOWER(userid)', strtolower($username));
		$query = $this->db->get();
		//echo $this->db->last_query();exit();

		if ($query->num_rows() >= 1) {
			foreach ($query->result() as $row)
			{
				$login_id= $row->id;
			}
			// echo $login_id;
			$this->db->SELECT('*');
			$this->db->FROM('tbl_user_failure_login_log');
			$this->db->WHERE('login_id', $login_id);
			$this->db->WHERE('is_valid', 'T');
			$query = $this->db->get();
			//echo $this->db->last_query();
			if ($query->num_rows() >= 1){
				foreach ($query->result() as $row)
				{
					$failure_attmpt= $row->failure_no_attmpt;
					$block_user=$row->block;
				}
				$failure_attmpt=$failure_attmpt+1;
				if($block_user=='T'){
					return 1;

				}else{
					$data['login_id'] = $login_id;
					$data['failure_no_attmpt'] = $failure_attmpt;
					$data['ip_address'] = getClientIP();
					$data['login_time'] = date('Y-m-d H:i:s');
					$data['is_valid']='T';
					$data['block']='F';
					if($failure_attmpt==3){
						$data['block']='T';
					}

					$this->db->where('login_id', $login_id);
					$this->db->where('is_valid', 'T');
					$this->db->update('tbl_user_failure_login_log',$data);
				}
			}else{
				$data['login_id'] = $login_id;
				$data['failure_no_attmpt'] = 1;
				$data['ip_address'] = getClientIP();
				$data['login_time'] = date('Y-m-d H:i:s');
				$data['is_valid']='T';
				$data['block']='F';
				/*print_r($data);
				exit();*/
				$this->db->INSERT('tbl_user_failure_login_log', $data);

			}
			return $query->result();
		} else {
			return FALSE;
		}
	}//End of Function get_failure_user_details..
	public function get_user_block_dtl_update($login_id) {


		$data['login_id'] = $login_id;
		$data['failure_no_attmpt'] = 0;
		$data['ip_address'] = getClientIP();
		$data['login_time'] = date('Y-m-d H:i:s');
		$data['is_valid']='F';
		$data['block']='F';

		$this->db->where('login_id', $login_id);
		$this->db->WHERE('is_valid', 'T');
		$this->db->update('tbl_user_failure_login_log',$data);
	}//End of function get_user_block_dtl ..






	//Start Password History is not maintained
	public function selectPasswordCheck($userid,$password=null) {

		$this->db->SELECT('*');
		$this->db->FROM('tbl_users_password_history');
		$this->db->WHERE('userid', $userid);
		if (!empty($password) && $password !=null){
			$this->db->WHERE('password',md5($password));
		}
		$this->db->ORDER_BY('id', 'DESC');
		$this->db->LIMIT(1);
		$query = $this->db->get();//echo $this->db->last_query();exit();
		if ($query->num_rows() >= 1) {

			$res_array = $query->result();
			return $res_array;
		} else {
			return false;
		}
	}
	public function updatePasswordCheck($userid, $password) {
		$result=$this->selectPasswordCheck($userid);

		$date = new DateTime();
		$date_time= $date->format('Y-m-d H:i:s');
		$data_create = array(
			'password' => md5($password),
			'userid' => $_SESSION['login']['user_id'],
			'created_ip' => getClientIP(),
			'created_on' => $date_time,
			'status' => 1
		);
		$data_update_pre= array(
			'changed_ip' => getClientIP(),
			'changed_on' => $date_time,
			'status' =>0
		);
		$this->db->INSERT('tbl_users_password_history', $data_create);
		if (!empty($result) && $result !=null){
			$pre_id=$result->id;
			$pre_userid=$result->userid;
			$this->db->WHERE('id', $pre_id);
			$this->db->WHERE('userid', $userid);
			$result = $this->db->UPDATE('tbl_users_password_history',$data_update_pre);
			if ($result) {
				return $result;
			} else {
				return false;
			}
		}else {
			return false;
		}
	}
	//End Password History is not maintained
//SMS & EMAIL OTP FLOODING
	public function insert_efiling_sms_email_dtl($sms_details)
	{
		$this->db->INSERT('physical_hearing.otp_requests', $sms_details);
		if ($this->db->insert_id()) {
			return true;
		} else{
			return false;
		}
	}
 public function check_efiling_sms_email_log($to_email,$request_time_time_period,$ip_address)
	{
		$this->db->where('ip_address', $ip_address);
		$this->db->where('email', $to_email);
		$this->db->where('request_time >', $request_time_time_period);
		$request_count = $this->db->count_all_results('physical_hearing.otp_requests');
		return $request_count;
	}
	public	function check_efiling_sms_mobile_no_log($mobile_no,$request_time_time_period,$ip_address)
	{
		$this->db->where('ip_address', $ip_address);
		$this->db->where('mobile_no', $mobile_no);
		$this->db->where('request_time >', $request_time_time_period);
		$request_count = $this->db->count_all_results('physical_hearing.otp_requests');
		return $request_count;
	}

	//END SMS & EMAIL OTP FLOODING


	//XXXXXXXXXXXXXXXXXXXXX work End XXXXXXXXXXXXXXXXXXXXXXXXXXXX

}?>
