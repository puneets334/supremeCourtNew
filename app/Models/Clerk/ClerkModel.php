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

    function get_clerk_aor($clerk_id,$aor_code=null,$registration_id=null) {
        $result = null;
        $builder = $this->db->table('efil.aor_clerk ac');
        $builder->select('ac.*, b.name,users.ref_department_id,users.is_active');
        $builder->join('icmis.bar b', 'b.aor_code=ac.aor_code');
        $builder->join('efil.tbl_users users', "ac.aor_code=cast(users.aor_code as int)");
        $builder->WHERE('ac.ref_user_id', $clerk_id);
        if (isset($aor_code) && !empty($aor_code)){ $builder->WHERE('ac.aor_code', $aor_code); }
        if (isset($registration_id) && !empty($registration_id)){ $builder->WHERE('ac.registration_id', $registration_id); }
        $builder->WHERE('ac.to_date is null');
        $builder->WHERE('users.is_deleted',false);
        $builder->WHERE('users.is_active','1');
        $query = $builder->get();
        if ($query->getNumRows() >= 1) {
            $result = $query->getResult();
        }
        return $result;
    }

    function selected_aor_for_case($registration_id) {
        $result = null;
        $builder = $this->db->table('efil.clerk_filings');
        $builder->WHERE('registration_id', $registration_id);
        $query = $builder->get();
        if ($query->getNumRows() >= 1) {
            $result = $query->getResult();
        }
        return $result;
    }

    function get_clerk_aor_details($registration_id) {
        $builder = $this->db->table('efil.clerk_filings cf');
        $builder->select('cf.*, users.first_name as name,users.ref_department_id,users.id as tbl_users_aor_id, users.is_active,nums.registration_id');
        $builder->join('efil.tbl_users users', "cf.aor_code=cast(users.aor_code as int)");
        $builder->join('efil.tbl_efiling_nums nums', 'cf.registration_id=nums.registration_id');
        $builder->WHERE('cf.registration_id', $registration_id);
        $builder->WHERE('nums.is_deleted',false);
        $builder->WHERE('users.is_deleted',false);
        $builder->WHERE('users.is_active','1');
        $query = $builder->get();
        return $query->getResultArray();
    }

    function clerk_filings_update($registration_id,$aor_code) {
        $clerk_filings_data_update=['aor_code'=>$aor_code];
        $builder = $this->db->table('efil.clerk_filings');
        $builder->WHERE('registration_id', $registration_id);
        if($builder->UPDATE($clerk_filings_data_update)) {
            $builder1 = $this->db->table('efil.tbl_uploaded_pdfs');
            $builder1->WHERE('registration_id', $registration_id);
            $builder1->WHERE('is_deleted', FALSE);
            $query = $builder1->get();
            if ($query->getNumRows() >= 1) {
                $aorData = getAordetailsByAORCODE($aor_code);
                if (isset($aorData) && !empty($aorData)) {
                    $uploaded_by = !empty($aorData) ? $aorData[0]->id : 0;
                }
                if (isset($uploaded_by) && !empty($uploaded_by)) {
                    $update_pdf = array('uploaded_by' => $uploaded_by, 'upload_ip_address' => $_SERVER['REMOTE_ADDR'],'updated_by' => $uploaded_by, 'update_ip_address' => $_SERVER['REMOTE_ADDR'],'updated_on' => date('Y-m-d H:i:s'));
                    $is_update_uploaded_pdfs=$this->update_uploaded_pdfs($registration_id,$update_pdf);
                    if ($is_update_uploaded_pdfs) {
                        $builder2 = $this->db->table('efil.tbl_efiled_docs');
                        $builder2->WHERE('registration_id', $registration_id);
                        $builder2->WHERE('is_deleted', FALSE);
                        $query_index = $builder2->get();
                        if ($query_index->getNumRows() >= 1) {
                            $is_update_efiled_docs=$this->update_efiled_docs($registration_id,$update_pdf);
                        }
                    }
                }
            }
            return true;
        } else{
            return false;
        }
    }

    function clerk_filings_insert($registration_id,$aor_code) {
        if (in_array($_SESSION['login']['ref_m_usertype_id'], [USER_CLERK])) {
            $clerk_filings_data_insert = [
                'registration_id' => $registration_id,
                'ref_user_id' => $_SESSION['login']['id'],
                'aor_code' => $aor_code
            ];
            $builder = $this->db->table('efil.clerk_filings');
            if($builder->INSERT($clerk_filings_data_insert)) {
                return true;
            }
        }
        return false;
    }

    /*Start Add AOR Clerk by Manoj on 24 sep 2024*/
    function getClerks() {
        $builder = $this->db->table('efil.tbl_users tu');
        $builder->select('tu.id,tu.first_name,tu.last_name,tu.moblie_number,tu.gender,tu.emailid,tu.aor_code,tu.created_on,ac.to_date');
        $builder->join('efil.aor_clerk ac', 'tu.id = ac.ref_user_id');
        $builder->where('tu.ref_m_usertype_id', USER_CLERK);
        $builder->where('ac.aor_code', getSessionData('login')['aor_code']);
        $builder->where('tu.is_deleted',false);
        $builder->where('tu.is_active','1');
        $builder->orderBy('tu.id', 'DESC');
        $query  = $builder->get();
        return $result = $query->getResult();
    }

    function total_clerk_associations($mobile_no,$email_id) {
        $builder = $this->db->table('efil.aor_clerk ac');
        $builder->select('ac.aor_code,tu.first_name,tu.last_name,aor.first_name as aor_first_name,aor.last_name as aor_last_name');
        $builder->join('efil.tbl_users tu', 'ac.ref_user_id = tu.id','left');
        $builder->join('efil.tbl_users aor', 'ac.aor_code=cast(aor.aor_code as int)','left');
        $builder->where('ac.to_date is null');
        $builder->where('tu.is_deleted',false);
        $builder->where('tu.is_active','1');
        $builder->groupStart();
        $builder->where('tu.moblie_number', $mobile_no);
        $builder->orWhere('tu.userid',$mobile_no);
        $builder->orWhere('UPPER(tu.emailid)',$email_id);
        $builder->groupEnd();
        $query  = $builder->get();
        return $result = $query->getResult();
    }

    function total_clerk_associations_by_id($ref_user_id) {
        $builder = $this->db->table('efil.aor_clerk ac');
        $builder->select('ac.aor_code,tu.first_name,tu.last_name');
        $builder->join('efil.tbl_users tu', 'ac.ref_user_id = tu.id','left');
        $builder->where('ac.ref_user_id', $ref_user_id);
        $builder->where('tu.is_deleted',false);
        $builder->where('tu.is_active','1');
        $builder->where('ac.to_date is null');
        $query  = $builder->get();
        return $result = $query->getResult();
    }

    function addClerk($data) {
        $this->db->transStart();
        $builder = $this->db->table('efil.tbl_users');
        $builder->INSERT($data);
        $user_id = $this->db->insertID();
        $builder1 = $this->db->table('efil.aor_clerk');
        $builder1->INSERT([
            'aor_code'=>getSessionData('login')['aor_code'],
            'ref_user_id'=>$user_id,
            'from_date'=>date('Y-m-d'),
            'created_by_ip'=>get_client_ip(),
        ]);
        $this->db->transComplete();
        if ($this->db->transStatus() === FALSE) {
            return false;
        } else{
            return true;
        }
    }

    function add_only_clerk($clerk_id) {
        $builder = $this->db->table('efil.aor_clerk');
        $builder->INSERT([
            'aor_code'=>getSessionData('login')['aor_code'],
            'ref_user_id'=>$clerk_id,
            'from_date'=>date('Y-m-d'),
            'created_by_ip'=>get_client_ip(),
        ]);
        if ($this->db->insertID()) {
            return true;
        } else{
            return false;
        }
    }

    function engaged_disengaged_clerk($data) {
        $builder = $this->db->table('efil.aor_clerk ac');
        $this->db->transStart();
        $builder->select('ac.*');
        $builder->where('ac.aor_code',getSessionData('login')['aor_code']);
        $builder->where('ac.ref_user_id',$data['ref_user_id']);
        $query  = $builder->get();
        $result = $query->getRow();
        $builder1 = $this->db->table('efil.aor_clerk_history');
        $builder1->INSERT([
            'aor_code'     => $result->aor_code,
            'ref_user_id'  => $result->ref_user_id,
            'from_date'    => $result->from_date,
            'to_date'      => $result->to_date,
            'created_on'   => $result->created_on,
            'created_by_ip'=> $result->created_by_ip,
            'updated_on'   => $result->updated_on,
            'updated_by_ip'=> $result->updated_by_ip,
            'event_type'   => $data['is_engaged'] ? 'Disengage':'Engage',
        ]);
        $builder2 = $this->db->table('efil.aor_clerk');
        if($data['is_engaged']){
            $builder2->set('to_date', date('Y-m-d'));
        } else{
            $builder2->set('to_date', null);
        }
        $builder2->where('aor_code', getSessionData('login')['aor_code']);
        $builder2->where('ref_user_id', $data['ref_user_id']);
        $builder2->update();
        $this->db->transComplete();
        if ($this->db->transStatus() === FALSE) {
            return false;
        } else{
            return true;
        }
    }

    function add_clerks_count() {
        $builder = $this->db->table('efil.tbl_users tu');
        $builder->select('tu.id,tu.first_name,tu.last_name,tu.moblie_number,tu.gender,tu.emailid,tu.aor_code,ac.to_date');
        $builder->join('efil.aor_clerk ac', 'tu.id = ac.ref_user_id');
        $builder->where('tu.ref_m_usertype_id', USER_CLERK);
        $builder->where('ac.aor_code', getSessionData('login')['aor_code']);
        $builder->where('ac.to_date is null');
        $builder->where('tu.is_deleted',false);
        $builder->where('tu.is_active','1');
        return $builder->countAllResults();
    }

    function check_already_reg_mobile($mobile) {
        $builder = $this->db->table('efil.tbl_users');
        $builder->SELECT('moblie_number');
        $builder->WHERE('moblie_number',$mobile);
        $builder->WHERE('is_active','1');
        $query = $builder->get();
        if ($query->getNumRows() >= 1) {
            return true;
        } else{
            return false;
        }
    }

    function check_already_reg_email($email) {
        $builder = $this->db->table('efil.tbl_users');
        $builder->SELECT('emailid');
        $builder->WHERE('UPPER(emailid)',$email);
        $builder->WHERE('is_active','1');
        $query = $builder->get();
        if ($query->getNumRows() >= 1) {
            return true;
        } else{
            return false;
        }
    }

    function check_user_already_exists($mobile,$email) {
        $builder = $this->db->table('efil.tbl_users');
        $builder->select('id,userid,moblie_number,emailid,ref_m_usertype_id');
        $builder->groupStart();
        $builder->where('moblie_number',$mobile);
        $builder->orWhere('UPPER(emailid)',$email);
        $builder->orWhere('userid',$mobile);
        $builder->groupEnd();
        $builder->where('is_active','1');
        $builder->where('is_deleted',false);
        $query = $builder->get();
        return $query->getRow();
    }

    function check_clerk_already_exists($ref_user_id) {
        $builder = $this->db->table('efil.aor_clerk');
        $builder->select('id');
        $builder->where('ref_user_id',$ref_user_id);
        $builder->where('aor_code',getSessionData('login')['aor_code']);
        $query = $builder->get();
        return $query->getRow();
    }

    /*End Add AOR Clerk by Manoj*/
    function update_uploaded_pdfs($registration_id,$data) {
        $builder = $this->db->table('efil.tbl_uploaded_pdfs');
        $builder->WHERE('registration_id', $registration_id);
        $builder->WHERE('is_deleted', FALSE);
        if ($builder->UPDATE($data)) {
            return true;
        } else{
            return false;
        }
    }

    function update_efiled_docs($registration_id,$data) {
        $builder = $this->db->table('efil.tbl_efiled_docs');
        $builder->WHERE('registration_id', $registration_id);
        $builder->WHERE('is_deleted', FALSE);
        if ($builder->UPDATE($data)) {
            return true;
        } else{
            return false;
        }
    }

}