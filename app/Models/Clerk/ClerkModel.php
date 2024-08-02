<?php

namespace App\Models\Clerk;
use CodeIgniter\Model;

class ClerkModel extends Model {

    function __construct() {
        parent::__construct();
    }

    /*function add_clerk_user($data, $clerk_name) {
        $this->db->trans_start();
        //$this->db = $this->load->database(unserialize('efil.tbl_users users'_connection), TRUE);
        $this->db->INSERT('efil.tbl_users', $data);
        $user_id = $this->db->insert_id();
        if ($user_id) {
            $parent_ids = $_SESSION['login']['id'];
            $clerk_data = array('clerk_id' => $user_id, 'parent_ids' => $parent_ids, 'clerk_name' => $clerk_name);
            $this->db->INSERT('efil.m_tbl_clerks', $clerk_data);
            $this->db->trans_complete();
        }
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function get_clerk_users($clerk_user_id) {
        $sql = "SELECT * FROM efil.m_tbl_clerks cl 
        JOIN efil.tbl_users users on users.id = cl.clerk_id
        WHERE parent_ids=$clerk_user_id ";
        $query = $this->db->query($sql);
        if ($query->num_rows() >= 1) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
    }

    function get_clerk_details($clerk_user_id) {
        $sql = "SELECT * FROM efil.m_tbl_clerks cl 
        JOIN  " . 'efil.tbl_users users' . " on users.id = cl.clerk_id
        WHERE users.id =" . $clerk_user_id;
        $query = $this->db->query($sql);
        if ($query->num_rows() >= 1) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
    }

    function update_clerk_user($clerk_id, $data, $clerk_name) {
        //$this->db = $this->load->database(unserialize('efil.tbl_users users'_connection), TRUE);
        $this->db->WHERE('id', $clerk_id);
        $this->db->UPDATE('efil.tbl_users', $data);
        if ($this->db->affected_rows() > 0) {
            $data_clerk = array('clerk_name' => $clerk_name);
            $this->db->WHERE('clerk_id', $clerk_id);
            $this->db->UPDATE('efil.m_tbl_clerks', $data_clerk);
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

    function check_email_present($email, $dep_id) {
        $this->db->SELECT('*');
        $this->db->FROM('efil.tbl_users users');
        $this->db->WHERE('users.emailid', $email);
        $this->db->WHERE('users.id!=', $dep_id);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return TRUE;
        } else {
            return false;
        }
    }

    function check_mobno_present($mobile, $dep_id) {
        $this->db->SELECT('*');
        $this->db->FROM('efil.tbl_users users');
        $this->db->WHERE('users.moblie_number', $mobile);
        $this->db->WHERE('users.id!=', $dep_id);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return TRUE;
        } else {
            return false;
        }
    }

    function get_advocate($clerk_user_id) {
        $sql = "SELECT users.id,users.first_name,users.last_name FROM " . 'efil.tbl_users users' . "  
        JOIN  efil.m_tbl_clerks cl on users.id = cl.parent_ids
        WHERE cl.clerk_id = $clerk_user_id  Order by created_datetime desc";
        $query = $this->db->query($sql);
        if ($query->num_rows() >= 1) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
    }
    function get_states_list() {
        $this->db->SELECT("cmis_state_id as state_code,agency_state as state_name");
        $this->db->FROM('icmis.ref_agency_state');
        $this->db->WHERE('is_deleted', 'False');
        $this->db->where('id!=9999');
        $this->db->ORDER_BY("agency_state", "asc");
        $query = $this->db->get();
        return $query->result();
    }

    function get_districts_list($state_id) {
        $this->db->SELECT("st2.id_no as dist_code,st2.name as dist_name");
        $this->db->FROM('icmis.state st1');
        $this->db->JOIN('icmis.state st2', 'st1.state_code = st2.state_code');
        $this->db->WHERE('st1.id_no', $state_id);
        $this->db->WHERE('st2.district_code !=0');
        $this->db->WHERE('st2.sub_dist_code = 0');
        $this->db->WHERE('st2.village_code = 0');
        $this->db->WHERE('st2.display', 'Y');
        $this->db->WHERE('st1.display', 'Y');
        $this->db->WHERE('st2.display', 'Y');
        $this->db->ORDER_BY("st2.name", "asc");
        $query = $this->db->get();
        return $query->result();
    }*/

    function get_clerk_aor($clerk_id) {
        $result = null;
        $builder = $this->db->table('efil.aor_clerk ac');
        $builder->select('ac.*, b.name');
        $builder->join('icmis.bar b', 'b.aor_code=ac.aor_code');
        $builder->WHERE('ref_user_id', $clerk_id);
        $query = $builder->get();
        // echo $this->db->last_query(); exit;
        if ($query->getNumRows() >= 1) {
            $result = $query->getResult();
        }
        return $result;
    }

    function selected_aor_for_case($registration_id) {
        $result = null;
        $builder = $this->db->table('efil.department_filings');
        $builder->where('registration_id', $registration_id);
        $query = $builder->get();
        $output = $query->getResult();
        if ($query->getNumRows() >= 1) {
            $result = $output;
        }
        return $result;
    }

}