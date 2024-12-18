<?php

namespace App\Models\Clerk;
use CodeIgniter\Model;

class ClerkModel extends Model {

    function __construct() {
        parent::__construct();
    }

    function check_email_present($email, $dep_id) {
        $builder = $this->db->table('efil.tbl_users users');
        $builder->SELECT('*');
        $builder->WHERE('users.emailid', $email);
        $builder->WHERE('users.id!=', $dep_id);
        $query = $builder->get();
        if ($query->getNumRows() >= 1) {
            return TRUE;
        } else{
            return false;
        }
    }

    function check_mobno_present($mobile, $dep_id) {
        $builder = $this->db->table('efil.tbl_users users');
        $builder->SELECT('*');
        $builder->WHERE('users.moblie_number', $mobile);
        $builder->WHERE('users.id!=', $dep_id);
        $query = $builder->get();
        if ($query->getNumRows() >= 1) {
            return TRUE;
        } else{
            return false;
        }
    }

    function get_advocate($clerk_user_id) {
        $sql = "SELECT users.id,users.first_name,users.last_name FROM " . 'efil.tbl_users users' . "  
        JOIN  efil.m_tbl_clerks cl on users.id = cl.parent_ids
        WHERE cl.clerk_id = $clerk_user_id  Order by created_datetime desc";
        $query = $this->db->query($sql);
        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return $result;
        } else{
            return FALSE;
        }
    }
    
    function update_clerk_user($clerk_id, $data, $clerk_name) {
        // $this->db = $this->load->database(unserialize('efil.tbl_users users'_connection), TRUE);
        $builder = $this->db->table('efil.tbl_users');
        $builder->WHERE('id', $clerk_id);
        $builder->UPDATE($data);
        if ($this->db->affectedRows() > 0) {
            $data_clerk = array('clerk_name' => $clerk_name);
            $builder1 = $this->db->table('efil.m_tbl_clerks');
            $builder1->WHERE('clerk_id', $clerk_id);
            $builder1->UPDATE($data_clerk);
            if ($this->db->affectedRows() > 0) {
                return TRUE;
            }
        } else{
            return FALSE;
        }
    }    

    function get_districts_list($state_id) {
        $builder = $this->db->table('icmis.state st1');
        $builder->SELECT("st2.id_no as dist_code,st2.name as dist_name");
        $builder->JOIN('icmis.state st2', 'st1.state_code = st2.state_code');
        $builder->WHERE('st1.id_no', $state_id);
        $builder->WHERE('st2.district_code !=0');
        $builder->WHERE('st2.sub_dist_code = 0');
        $builder->WHERE('st2.village_code = 0');
        $builder->WHERE('st2.display', 'Y');
        $builder->WHERE('st1.display', 'Y');
        $builder->WHERE('st2.display', 'Y');
        $builder->orderBy("st2.name", "asc");
        $query = $builder->get();
        return $query->getResult();
    }
    
    function get_clerk_details($clerk_user_id) {
        $sql = "SELECT * FROM efil.m_tbl_clerks cl 
        JOIN  " . 'efil.tbl_users users' . " on users.id = cl.clerk_id
        WHERE users.id =" . $clerk_user_id;
        $query = $this->db->query($sql);
        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return $result;
        } else{
            return FALSE;
        }
    }
    
    function add_clerk_user($data, $clerk_name) {
        $this->db->transStart();
        // $this->db = $this->load->database(unserialize('efil.tbl_users users'_connection), TRUE);
        $builder = $this->db->table('efil.tbl_users');
        $builder->INSERT($data);
        $user_id = $this->db->insertID();
        if ($user_id) {
            $parent_ids = $_SESSION['login']['id'];
            $clerk_data = array('clerk_id' => $user_id, 'parent_ids' => $parent_ids, 'clerk_name' => $clerk_name);
            $builder1 = $this->db->table('efil.m_tbl_clerks');
            $builder1->INSERT($clerk_data);
            $this->db->transComplete();
        }
        if ($this->db->transStatus() === FALSE) {
            return FALSE;
        } else{
            return TRUE;
        }
    }

    function get_states_list() {
        $builder = $this->db->table('icmis.ref_agency_state');
        $builder->SELECT("cmis_state_id as state_code,agency_state as state_name");
        $builder->WHERE('is_deleted', 'False');
        $builder->WHERE('id!=9999');
        $builder->orderBy("agency_state", "asc");
        $query = $builder->get();
        return $query->getResult();
    }

    function get_clerk_users($clerk_user_id) {
        $sql = "SELECT * FROM efil.m_tbl_clerks cl 
        JOIN efil.tbl_users users on users.id = cl.clerk_id
        WHERE parent_ids=$clerk_user_id ";
        $query = $this->db->query($sql);
        if ($query->getNumRows() >= 1) {
            $result = $query->getResultArray();
            return $result;
        } else {
            return FALSE;
        }
    }

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