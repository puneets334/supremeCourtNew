<?php

namespace App\Models\Common;

use CodeIgniter\Model;

class CommonLoginModel extends Model
{
    protected $table = 'tbl_advocate_establishments';
    function __construct()
    {
        parent::__construct();
        //$this->db = $this->load->database(unserialize('efil.tbl_users'_connection), TRUE);
    }

    function check_user_id($userid)
    {
        $builder = $this->db->table('efil.tbl_users');
        $builder->SELECT('*');
        // $builder->FROM();
        $builder->WHERE('userid', $userid);
        $query = $builder->get();
        if ($query->getNumRows() == 1) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    function check_user_by_mobile($user_mobile)
    {
        $builder = $this->db->table('efil.tbl_users');
        $builder->SELECT('*');
        // $builder->FROM();
        $builder->WHERE('moblie_number', $user_mobile);
        $query = $builder->get();
        if ($query->getNumRows() == 1) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    function check_user_by_email($user_email)
    {
        $builder = $this->db->table('efil.tbl_users');
        $builder->SELECT('*');
        // $builder->FROM();
        $builder->WHERE('emailid', $user_email);
        $query = $builder->get();
        if ($query->getNumRows() == 1) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    function check_user_by_both($user_mobile, $user_email)
    {
        $builder = $this->db->table('efil.tbl_users');
        $builder->SELECT('*');
        // $builder->FROM();
        $builder->WHERE('moblie_number', $user_mobile);
        $builder->WHERE('emailid', $user_email);
        $query = $builder->get();
        if ($query->getNumRows() == 1) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    function update_pass($id, $data)
    {

        //$this->db = $this->load->database(unserialize('efil.tbl_users'_connection), TRUE);
        $this->db->transStart();
        $this->db->transStart();
        $builder = $this->db->table('efil.tbl_users');
        $builder->WHERE('id', $id);
        $builder->UPDATE($data);
        if ($this->db->affectedRows() > 0) {
            $this->db->transComplete();
            $this->db->transComplete();
            $builder = $this->db->table('efil.tbl_users');
            $builder->SELECT('*');
            // $builder->FROM();
            $builder->WHERE('id', $id);
            $query = $builder->get();
            $userdata = $query->getResult();
            if (isset($userdata) && !empty($userdata)) {
                $sentSMS = "Hi, " . $userdata[0]->first_name . ". Your Password for eFiling login has been updated succesfully";
                $responseObj = send_mobile_sms($userdata[0]->moblie_number, $sentSMS);
                $user_name = $userdata[0]->first_name . ' ' . $userdata[0]->last_name;
                $time = date('Y-m-d H:i:s', strtotime($responseObj['now']));
                /* $response_status = $responseObj['notifyList'][0]['h'];
                  $sms_details = array(
                  'sent_to' => $user_name,
                  'mobile' => $userdata[0]->moblie_number,
                  'message' => $sentSMS,
                  'sent_time' => $time,
                  'response' => $response_status
                  );
                  $this->db->insert('tbl_sms_log', $sms_details);
                  if ($this->db->insert_id()) {
                  $this->db->trans_complete();
                  $this->db->trans_complete();
                  } */
                //$establishment_details = $this->New_case_model->get_establishment_details(E_FILING_FOR_ESTABLISHMENT, $userdata[0]->enrolled_establishment_id);
                send_mail_msg($userdata[0]->emailid, 'Password Updated', $sentSMS, $user_name);
                //unset($_SESSION['estab_details']);
            }
        }
        if ($this->db->transStatus() === FALSE || $this->db->transStatus() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_email_already_present($emailid)
    {
        $builder = $this->db->table('efil.tbl_users');
        $builder->SELECT('*');
        // $builder->FROM();
        $builder->WHERE('upper(emailid)', $emailid);
        $query = $builder->get();
        if ($query->getNumRows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    function check_mobno_already_present($moblie_number)
    {
        $builder = $this->db->table('efil.tbl_users');
        $builder->SELECT('*');
        // $builder->FROM();
        $builder->WHERE('moblie_number', $moblie_number);
        $query = $builder->get();
        if ($query->getNumRows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    function check_usrid_already_present($userid)
    {
        $builder = $this->db->table('efil.tbl_users');
        $builder->SELECT('*');
        // $builder->FROM();
        $builder->WHERE('upper(userid)', $userid);
        $query = $builder->get();
        if ($query->getNumRows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function show_estab_profile($id)
    {
        $builder = $this->db->table($this->table);
        $query = $builder->select('*')
            ->where('adv_user_id', $id)
            ->orderBy('id')
            ->get();

        if ($query->getNumRows() > 0) {
            return $query->getResult(); // Returns an array of objects representing the rows
        } else {
            return null; // Return null if no rows found
        }
    }


    public function get_account_status($user_id)
    {
        $builder = $this->db->table($this->table);
        $builder->select('bar_st.acount_status_updated_on AS bar_account_status')
            ->join('bar_approval_account_status AS bar_st', 'bar_st.user_id = tbl_account_status.user_id', 'left')
            ->where('tbl_account_status.is_active', true)
            ->where('bar_st.is_active', true)
            ->where('tbl_account_status.user_id', $user_id);

        $query = $builder->get();

        if ($query->getNumRows() > 0) {
            return $query->getResult(); // Returns an array of objects representing the rows
        } else {
            return null; // Return null if no rows found
        }
    }

    //    function more_add_estab_profile($estab_data) {
    //
    //        $this->db->INSERT_BATCH('tbl_advocate_establishments', $estab_data);
    //        if ($this->db->insert_id()) {
    //            $insert_id = $this->db->insert_id();
    //            return $insert_id;
    //        } else {
    //            return FALSE;
    //        }
    //    }
    public function get_login_multi_account($usr)
    {
        $userid = strtoupper($usr);
        $sql = "SELECT users.*, est.pg_request_function, est.pg_response_function, est.estab_code,tut.user_type
                    FROM efil.tbl_users users 
                    JOIN efil.m_tbl_establishments est ON 1 = 1
                    LEFT JOIN efil.tbl_user_types tut ON tut.id=users.ref_m_usertype_id
                    WHERE (users.userid = ? OR users.moblie_number = ?  OR users.emailid ilike ?)
                    AND users.is_deleted = 'false' AND users.is_active = '1' AND tut.is_deleted = false";
        $query = $this->db->query($sql, array($userid, $usr, $usr));
        $res_array = $query->getResult();
        return $res_array;
    }
}