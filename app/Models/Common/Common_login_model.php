<?php

namespace App\Models\Common;
use CodeIgniter\Model;

class Common_login_model extends Model {
    protected $table = 'tbl_advocate_establishments';
    function __construct() {
        parent::__construct();
        //$this->db = $this->load->database(unserialize('efil.tbl_users'_connection), TRUE);
    }

    function check_user_id($userid) {

        $this->db->SELECT('*');
        $this->db->FROM('efil.tbl_users');
        $this->db->WHERE('userid', $userid);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function check_user_by_mobile($user_mobile) {

        $this->db->SELECT('*');
        $this->db->FROM('efil.tbl_users');
        $this->db->WHERE('moblie_number', $user_mobile);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function check_user_by_email($user_email) {

        $this->db->SELECT('*');
        $this->db->FROM('efil.tbl_users');
        $this->db->WHERE('emailid', $user_email);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function check_user_by_both($user_mobile, $user_email) {

        $this->db->SELECT('*');
        $this->db->FROM('efil.tbl_users');
        $this->db->WHERE('moblie_number', $user_mobile);
        $this->db->WHERE('emailid', $user_email);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function update_pass($id, $data) {

        //$this->db = $this->load->database(unserialize('efil.tbl_users'_connection), TRUE);
        $this->db->trans_start();
        $this->db->trans_start();
        $this->db->WHERE('id', $id);
        $this->db->UPDATE('efil.tbl_users', $data);

        if ($this->db->affected_rows() > 0) {

            $this->db->trans_complete();
            $this->db->trans_complete();
            $this->db->SELECT('*');
            $this->db->FROM('efil.tbl_users');
            $this->db->WHERE('id', $id);
            $query = $this->db->get();
            $userdata = $query->result();

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
        if ($this->db->trans_status() === FALSE || $this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_email_already_present($emailid) {

        $this->db->SELECT('*');
        $this->db->FROM('efil.tbl_users');
        $this->db->WHERE('upper(emailid)', $emailid);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    function check_mobno_already_present($moblie_number) {

        $this->db->SELECT('*');
        $this->db->FROM('efil.tbl_users');
        $this->db->WHERE('moblie_number', $moblie_number);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    function check_usrid_already_present($userid) {

        $this->db->SELECT('*');
        $this->db->FROM('efil.tbl_users');
        $this->db->WHERE('upper(userid)', $userid);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
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

}
