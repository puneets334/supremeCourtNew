<?php

namespace App\Models\login;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $session;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }

    function get_user($usr, $pwd, $if_loggable = true, $if_match_password = true)
    {
        $userid = strtoupper($usr);

        $builder = $this->db->table('efil.tbl_users as users');
        $builder->select('users.*, est.pg_request_function, est.pg_response_function, est.estab_code');
        $builder->join('efil.m_tbl_establishments est', '1 = 1');
        $builder->where('users.userid', $userid);
        $builder->orWhere('users.moblie_number', $usr);
        $builder->orWhere('users.emailid', $usr);
        $query = $builder->get();
        $result = $query->getRow();

        if ($query->getNumRows() == 1) {
            $res_array = $query->getFirstRow();

            if (!$if_match_password || $res_array->password . $_SESSION['login_salt'] == $pwd) {
                if ($if_loggable) { //for efiling_assistant
                    $builder = $this->db->table('efil.tbl_users as users');
                    $builder->where('id', $res_array->id);
                    $builder->update(array('login_ip' => getClientIP()));
                }
                return $res_array;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function check_otp($usr, $pwd, $otp)
    {
        $userid = strtoupper($usr);

        $builder = $this->db->table('efil.tbl_users as users');
        $builder->select('users.*, est.pg_request_function, est.pg_response_function, est.estab_code');
        $builder->join('efil.m_tbl_establishments est', '1 = 1');
        $builder->where('users.userid', $userid);
        $builder->orWhere('users.moblie_number', $usr);
        $builder->orWhere('users.emailid', $usr);
        $builder->where('users.mobile_otp', $otp);
        $query = $builder->get();
        $result = $query->getRow();

        if ($query->getNumRows() == 1) {
            $res_array = $query->getFirstRow();
            if ($res_array->password . $_SESSION['login_salt'] == $pwd) {
                return $res_array;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function storeOtp($usr, $pwd, $otp)
    {
        $userid = strtoupper($usr);
        $builder = $this->db->table('efil.tbl_users as users');
        $builder->select('users.*, est.pg_request_function, est.pg_response_function, est.estab_code');
        $builder->join('efil.m_tbl_establishments est', '1 = 1');
        $builder->where('users.userid', $userid);
        $builder->orWhere('users.moblie_number', $usr);
        $builder->orWhere('users.emailid', $usr);
        $builder->where('users.mobile_otp', $otp);
        $query = $builder->get();
        $result = $query->getRow();

        if ($query->getNumRows() == 1) {
            $res_array = $query->getFirstRow();
            if ($res_array->password . $_SESSION['login_salt'] == $pwd) {
                $builder = $this->db->table('efil.tbl_users');
                $builder->where('userid', $userid);
                $builder->orWhere('moblie_number', $usr);
                $builder->orWhere('emailid', $usr);
                $builder->update(array('mobile_otp' => $otp));
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function logUser($action, $data)
    {
        if ($action == 'login') {
            $sessionData = $this->session->get('login');
            $builder = $this->db->table('efil.tbl_users_login_log');
            $builder->insert($data);
            $insert_id = $this->db->insertID();
            $sessionData['log_id'] = $insert_id;
            $sessionData['processid'] = getmypid();
            $this->session->set("login", $sessionData);
            return true;
        } elseif ($action == 'logout') {
            $builder = $this->db->table('efil.tbl_users_login_log');
            $builder->where('log_id', $data['log_id']);
            $builder->update(array('logout_time' => $data['logout_time']));
            return true;
        }
    }

    function get_state_name($state_id)
    {
        $builder = $this->db->table('m_tbl_state');
        $builder->SELECT('state');
        $builder->WHERE('state_id', $state_id);
        return $builder->get()->getRow()->state;
    }

    function check_user_mobile_number($mobile_number)
    {
        // $this->db = $this->load->database(unserialize(dynamic_users_table_connection), TRUE);
        $builder = $this->db->table('users');
        $builder->SELECT('userid, moblie_number');
        $builder->WHERE('moblie_number', $mobile_number);
        $builder->orWhere('userid ', $mobile_number);
        $query = $builder->get();
        if ($query->getNumRows() >= 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function check_user_mobile_number_user_alredy($mobile_number)
    {
        $builder = $this->db->table('users'); // Get the query builder for the 'users' table

        $builder->select('userid, moblie_number');
        $builder->where('moblie_number', $mobile_number);
        $builder->where('userid !=', $mobile_number); // Corrected the `whereNotIn` clause

        $query = $builder->get(); // Execute the query

        if ($query->getNumRows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    function get_user_login_log_details($id)
    {

        $builder = $this->db->table('efil.tbl_users_login_log');
        $builder->where('login_id', $id);
        $builder->where('ip_address', getClientIP());
        $query = $builder->get();
        $result = $query->getRowArray();

        if ($query->getNumRows() >= 1) {
            return $result;
        } else {
            return FALSE;
        }
    }

    /*  function get_user_login_log_details_with_user_agent($id) {

        $this->db->SELECT('*');
        $this->db->FROM('efil.tbl_users_login_log');
        $this->db->WHERE('login_id', $id);
        $this->db->where('logout_time is null');
        #$this->db->WHERE('ip_address', getClientIP());
        $this->db->WHERE("TO_CHAR(now()::DATE ,'dd-mm-yyyy')=TO_CHAR(login_time :: DATE, 'dd-mm-yyyy')");
        $this->db->order_by('login_time', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        //echo $this->db->last_query();exit();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return FALSE;
        }
    }*/

    /* 	 $builder = $this->db->table('efil.tbl_users as users');
        $builder->select('users.*, est.pg_request_function, est.pg_response_function, est.estab_code');
        $builder->join('efil.m_tbl_establishments est', '1 = 1');
        $builder->where('users.userid', $userid);
        $builder->orWhere('users.moblie_number', $usr);
        $builder->orWhere('users.emailid', $usr);
        $builder->where('users.mobile_otp', $otp);
        $query = $builder->get();
        $result = $query->getRow();
	 */
    public function is_user_status($id, $ref_m_usertype_id = null)
    {
        $builder = $this->db->table('efil.tbl_users_login_log'); // Get the query builder for the specified table

        $query = $builder->select('*')
            ->where('login_id', $id)
            ->where('is_successful_login', true)
            ->orderBy('log_id', 'DESC')
            ->limit(1)
            ->get();

        if ($query->getRow()) {
            return $query->getRow();
        } else {
            return false;
        }
    }

    //XXXXXXXXXXXXXXXXXXXXX work start XXXXXXXXXXXXXXXXXXXXXXXXXXXX

    function get_failure_user_details($username)
    {
        $builder = $this->db->table('efil.tbl_users');

        // Query to get user ID
        $query = $builder->select('id')
            ->where('LOWER(userid)', strtolower($username))
            ->get();

        if ($query->getNumRows() >= 1) {
            $login_id = $query->getRow()->id;

            // Query to check failure login attempts
            $builder = $this->db->table('efil.tbl_user_failure_login_log');
            $query = $builder->select('*')
                ->where('login_id', $login_id)
                ->where('is_valid', 'T')
                ->get();

            if ($query->getNumRows() >= 1) {
                $row = $query->getRow();
                $failure_attmpt = $row->failure_no_attmpt;
                $block_user = $row->block;

                $failure_attmpt++;

                if ($block_user == 'T') {
                    return 1;
                } else {
                    $data = [
                        'login_id' => $login_id,
                        'failure_no_attmpt' => $failure_attmpt,
                        'ip_address' => getClientIP(),
                        'login_time' => date('Y-m-d H:i:s'),
                        'is_valid' => 'T',
                        'block' => ($failure_attmpt == 3) ? 'T' : 'F'
                    ];

                    $builder->where('login_id', $login_id)
                        ->where('is_valid', 'T')
                        ->update($data);
                }
            } else {
                $data = [
                    'login_id' => $login_id,
                    'failure_no_attmpt' => 1,
                    'ip_address' => getClientIP(),
                    'login_time' => date('Y-m-d H:i:s'),
                    'is_valid' => 'T',
                    'block' => 'F'
                ];

                $builder->insert($data);
            }
            return $query->getResult();
        } else {
            return false;
        }
    } //End of Function get_failure_user_details..


    function get_user_block_dtl($id)
    {
        $builder = $this->db->table('efil.tbl_user_failure_login_log');
        $query = $builder->select('*')
            ->where('login_id', $id)
            ->where('is_valid', 'T')
            ->get();

        if ($query->getNumRows() >= 1) {
            return $query->getResult();
        } else {
            return false;
        }
    } //End of function get_user_block_dtl ..


    function get_user_block_dtl_update($login_id)
    {
        $builder = $this->db->table('efil.tbl_user_failure_login_log');

        $data = [
            'login_id' => $login_id,
            'failure_no_attmpt' => 0,
            'ip_address' => getClientIP(),
            'login_time' => date('Y-m-d H:i:s'),
            'is_valid' => 'F',
            'block' => 'F'
        ];

        $builder->where('login_id', $login_id)
            ->where('is_valid', 'T')
            ->update($data);
    } //End of function get_user_block_dtl ..

    //XXXXXXXXXXXXXXXXXXXXX work End XXXXXXXXXXXXXXXXXXXXXXXXXXXX


}
