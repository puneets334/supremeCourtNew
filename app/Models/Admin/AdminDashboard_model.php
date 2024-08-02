<?php

namespace App\Models\Admin;
use CodeIgniter\Model;

class AdminDashboard_model extends Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function get_efilied_nums_stage_wise_count($stage_ids) {
        // START : Function used to count total efiled nums stage wise on admin dashboard 
        $created_by = $this->session->userdata['login']['id'];
        $this->db->SELECT('COUNT (CASE WHEN stage_id = ' . New_Filing_Stage . ' THEN 0 END) as total_new_efiling,
                        COUNT (CASE WHEN stage_id = ' . DEFICIT_COURT_FEE . ' THEN 0 END) as deficit_crt_fee,
                        COUNT (CASE WHEN stage_id = ' . Initial_Defected_Stage . ' THEN 0 END) as total_not_accepted,
                        COUNT (CASE WHEN stage_id = ' . Transfer_to_CIS_Stage . ' THEN 0 END) as total_available_for_cis,
                        COUNT (CASE WHEN stage_id = ' . Get_From_CIS_Stage . ' THEN 0 END) as total_get_from_cis,
                        COUNT (CASE WHEN stage_id = ' . Initial_Defects_Cured_Stage . ' OR stage_id = ' . DEFICIT_COURT_FEE_PAID . ' THEN 0 END) as total_refiled_cases,
                        COUNT (CASE WHEN stage_id = ' . Transfer_to_IB_Stage . ' THEN 0 END) as total_transfer_to_efiling_sec,
                        COUNT (CASE WHEN stage_id = ' . I_B_Approval_Pending_Admin_Stage . ' THEN 0 END) as total_pending_scrutiny,
                        COUNT (CASE WHEN stage_id = ' . I_B_Defected_Stage . ' THEN 0 END) as total_waiting_defect_cured,
                        COUNT (CASE WHEN stage_id = ' . I_B_Rejected_Stage . ' OR stage_id = ' . E_REJECTED_STAGE . ' THEN 0 END) as total_rejected,
                        COUNT (CASE WHEN stage_id = ' . I_B_Defects_Cured_Stage . ' THEN 0 END) as total_defect_cured,
                        COUNT (CASE WHEN stage_id = ' . LODGING_STAGE . '  OR stage_id =' . DELETE_AND_LODGING_STAGE . ' THEN 0 END) as total_lodged_cases,
                        COUNT (CASE WHEN (stage_id = ' . E_Filed_Stage . ' AND en.ref_m_efiled_type_id = ' . E_FILING_TYPE_NEW_CASE . ') OR ( stage_id = ' . CDE_ACCEPTED_STAGE . ' AND ref_m_efiled_type_id = ' . E_FILING_TYPE_CDE . ' ) THEN 0 END) as total_efiled_cases,
                        COUNT (CASE WHEN (stage_id = ' . Document_E_Filed . ' AND en.ref_m_efiled_type_id =' . E_FILING_TYPE_MISC_DOCS . ') THEN 0 END) as total_efiled_docs,
                        COUNT (CASE WHEN stage_id = ' . DEFICIT_COURT_FEE_E_FILED . ' AND en.ref_m_efiled_type_id =' . E_FILING_TYPE_DEFICIT_COURT_FEE . ' THEN 0 END) as total_efiled_deficit,
                        COUNT (CASE WHEN stage_id = ' . IA_E_Filed . ' AND en.ref_m_efiled_type_id = ' . E_FILING_TYPE_IA . ' THEN 0 END) as total_efiled_ia');
        $this->db->FROM('tbl_efiling_nums as en');
        $this->db->JOIN('tbl_efiling_case_status as cs', 'en.registration_id = cs.registration_id', 'INNER');
        $this->db->WHERE('cs.is_active', 'TRUE');
        $this->db->WHERE('en.is_active', 'TRUE');
        $this->db->WHERE('en.efiling_for_type_id', $_SESSION['login']['admin_for_type_id']);
        $this->db->WHERE('en.efiling_for_id', $_SESSION['login']['admin_for_id']);
        if (!in_array(LODGING_STAGE, $stage_ids) && !in_array(DELETE_AND_LODGING_STAGE, $stage_ids)) {
            $this->db->WHERE('en.allocated_to', $created_by);
        }

        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    // END : Function used to count total efiled nums stage wise on admin dashboard 
    // START : Function used to count total efiled type wise on admin dashboard
    public function get_efiled_count($stage_ids, $efiled_type, $admin_for_type_id, $admin_for_id) {
        $this->db->SELECT('COUNT(en.registration_id) as count');
        $this->db->FROM('tbl_efiling_nums as en');
        $this->db->JOIN('tbl_efiling_case_status as cs', 'en.registration_id=cs.registration_id');
        $this->db->JOIN(dynamic_users_table, 'users.id=en.created_by', 'left');
        $this->db->WHERE('cs.is_active', 'TRUE');
        $this->db->WHERE_IN('cs.stage_id', $stage_ids);
        $this->db->WHERE('en.efiling_for_type_id', $admin_for_type_id);
        $this->db->WHERE('en.efiling_for_id', $admin_for_id);
        $this->db->WHERE_IN('en.ref_m_efiled_type_id', $efiled_type);
        $this->db->WHERE('en.allocated_to', $_SESSION['login']['id']);
        $query = $this->db->get();

        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    // END :Function used to count total efiled type wise on admin dashboard
    // START : Function used to view list of login session detail from admin side bar
    function login_logs_details($frm1 = '', $frm2 = '') {
        $this->db_2 = $this->load->database(unserialize(dynamic_users_table_connection), TRUE);
        $this->db_2->SELECT(array('log.*', 'users.id', 'users.first_name', 'users.last_name', 'users.ref_m_usertype_id'));
        $this->db_2->FROM('users_login_log as log');
        $this->db_2->JOIN(dynamic_users_table, 'log.login_id=users.id', 'INNER');

        $this->db_2->WHERE("to_char(login_time,'YYYY-MM-DD')::date >= '" . $frm1 . "'");
        $this->db_2->WHERE("to_char(login_time,'YYYY-MM-DD')::date <= '" . $frm2 . "'");
        $this->db_2->ORDER_BY('log.login_time DESC');
        $query = $this->db_2->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else {
            return false;
        }
    }

// END : Function used to view list of login session from admin side bar


    function add_user($data) {


        $this->db_2 = $this->load->database(unserialize(dynamic_users_table_connection), TRUE);
        $this->db_2->trans_start();
        $this->db_2->INSERT('users', $data);
        if ($data['ref_m_usertype_id'] == USER_MASTER_ADMIN) {
            $data_update = array('ref_m_usertype_id' => USER_ACTION_ADMIN);
            $this->db_2->WHERE('ref_m_usertype_id', USER_ADMIN);
            $this->db_2->WHERE('admin_for_id', $data['admin_for_id']);
            $this->db_2->WHERE('admin_for_type_id', $data['admin_for_type_id']);
            $this->db_2->UPDATE('users', $data_update);
        }
        $this->db_2->trans_complete();

        if ($this->db_2->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function update_user($data, $id) {

        $this->db_2 = $this->load->database(unserialize(dynamic_users_table_connection), TRUE);
        $this->db_2->WHERE('id', $id);
        $this->db_2->UPDATE('users', $data);
        if ($this->db_2->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_state_list() {

        $this->db->SELECT('admin_for_id');
        $this->db->FROM(dynamic_users_table);
        $this->db->WHERE('admin_for_id IS NOT NULL');
        $query = $this->db->get();
        $query1_result = $query->result();

        $admin_for_id = array();
        foreach ($query1_result as $row) {
            $admin_for_id[] = $row->admin_for_id;
        }
        $state_id = implode(",", $admin_for_id);
        $ids = explode(",", $state_id);
        $this->db->SELECT("state_id,state");
        $this->db->FROM('efil.m_tbl_state');
        $this->db->WHERE_NOT_IN('state_id', $ids);
        $this->db->ORDER_BY("state", "asc");
        $query = $this->db->get();
        return $query->result();
    }

    function get_state_list_edit() {

        $this->db->SELECT('state_id,state');
        $this->db->FROM('efil.m_tbl_state');
        $this->db->ORDER_BY("state", "asc");
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_user_list1() {

        $this->db->SELECT('users.*,hc.hc_name,estab.estab_name,state.state');
        $this->db->FROM(dynamic_users_table);
        $this->db->JOIN('efil.m_tbl_high_courts hc', 'hc.id=users.admin_for_id', 'left');
        $this->db->JOIN('efil.m_tbl_establishments estab', 'estab.id=users.admin_for_id', 'left');
        $this->db->JOIN('efil.m_tbl_state state', 'state.state_id =estab.state_code', 'left');
        $this->db->WHERE('users.ref_m_usertype_id', USER_ADMIN);
        $this->db->WHERE('( hc.state_code = ' . $_SESSION['login']['admin_for_id'] . ' OR estab.state_code = ' . $_SESSION['login']['admin_for_id'] . ')');
        $this->db->ORDER_BY("users.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    function get_user_list() {



        // Main Query
        $this->db->SELECT("users.admin_for_type_id, hc.id, hc.hc_name hc_name, hc.state_code state_code, state.state, '' estab_distt, users.* 
            FROM efil.m_tbl_high_courts hc 
            LEFT JOIN efil.m_tbl_state state ON state.state_id = hc.state_code
            LEFT JOIN " . dynamic_users_table . " ON hc.id = users.admin_for_id WHERE hc.is_active is true AND (hc.state_code = " . $_SESSION['login']['admin_for_id'] . ") AND users.admin_for_type_id = 1  AND users.ref_m_usertype_id IN( " . USER_ADMIN . ", " . USER_MASTER_ADMIN . ", " . USER_ACTION_ADMIN . "  )
            
            UNION 
            
            SELECT users.admin_for_type_id, estab.id, estab.estab_name estab_name, estab.state_code state_code, state.state,district1.dist_name estab_distt, users.* 
            FROM efil.m_tbl_establishments estab              
            LEFT JOIN efil.m_tbl_districts district1 ON estab.ref_m_tbl_districts_id = district1.id
            LEFT JOIN efil.m_tbl_state state ON state.state_id = district1.ref_m_tbl_states_id
            LEFT JOIN " . dynamic_users_table . " ON estab.id = users.admin_for_id WHERE estab.display = 'Y' AND users.ref_m_usertype_id IN( " . USER_ADMIN . ", " . USER_MASTER_ADMIN . ", " . USER_ACTION_ADMIN . "  ) AND users.admin_for_type_id = 2 AND (estab.state_code = " . $_SESSION['login']['admin_for_id'] . ")
            
            UNION 
            
            SELECT users.admin_for_type_id, district.id, district.dist_name, district.dist_code state_code, state.state,'' estab_distt, users.* 
            FROM efil.m_tbl_districts district  
            LEFT JOIN efil.m_tbl_state state ON state.state_id = district.ref_m_tbl_states_id
            LEFT JOIN " . dynamic_users_table . " ON district.id = users.admin_for_id WHERE district.display = 'Y' AND users.ref_m_usertype_id =" . USER_DISTRICT_ADMIN . " AND users.admin_for_type_id = " . USER_DISTRICT_ADMIN . " AND (district.ref_m_tbl_states_id = " . $_SESSION['login']['admin_for_id'] . ")");


        $subQuery = $this->db->get_compiled_select();
        $this->db->SELECT('*');
        // Sub Query  
        $this->db->FROM("($subQuery ) a");
        $query = $this->db->get();
        return $query->result();
    }

    function get_district_admin_list() {

        $this->db->SELECT("users.admin_for_type_id, estab.id, estab.estab_name estab_name, estab.state_code state_code,district.dist_name estab_distt,  users.*");
        $this->db->FROM(dynamic_users_table);
        $this->db->JOIN('efil.m_tbl_establishments estab ', 'estab.id = users.admin_for_id');
        $this->db->JOIN('efil.m_tbl_districts district ', 'estab.ref_m_tbl_districts_id = district.id', 'LEFT');
        $this->db->WHERE('estab.display', 'Y');
        $this->db->WHERE('users.admin_for_type_id', ENTRY_TYPE_FOR_ESTABLISHMENT);
        $this->db->WHERE('estab.ref_m_tbl_districts_id', $_SESSION['login']['admin_for_id']);
        $this->db->WHERE_IN('users.ref_m_usertype_id', USER_ADMIN . ", " . USER_MASTER_ADMIN . ", " . USER_ACTION_ADMIN, FALSE);
        $this->db->ORDER_BY('estab.estab_name', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_admin_list_master_admin() {

        $this->db->SELECT("users.admin_for_type_id, estab.id, estab.estab_name estab_name, estab.state_code state_code,district.dist_name estab_distt,  users.*");
        $this->db->FROM(dynamic_users_table);
        $this->db->JOIN('efil.m_tbl_establishments estab ', 'estab.id = users.admin_for_id');
        $this->db->JOIN('efil.m_tbl_districts district ', 'estab.ref_m_tbl_districts_id = district.id', 'LEFT');
        $this->db->WHERE('estab.display', 'Y');
        $this->db->WHERE('users.admin_for_type_id', ENTRY_TYPE_FOR_ESTABLISHMENT);
        $this->db->WHERE('estab.id', $_SESSION['login']['admin_for_id']);
        $this->db->WHERE_IN('users.ref_m_usertype_id', USER_ACTION_ADMIN, FALSE);
        $this->db->ORDER_BY('estab.estab_name', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_user_details($id) {

        $this->db->WHERE('id', $id);
        $query = $this->db->get(dynamic_users_table, 1);
        return $query->result();
    }

    function action_taken($action_id, $status) {

        $this->db_2 = $this->load->database(unserialize(dynamic_users_table_connection), TRUE);

        if ($status == 'Active') {
            $data = array('is_active' => TRUE);
            $this->db_2->WHERE('id', $action_id);
            $query = $this->db_2->UPDATE('users', $data);
            return true;
        } if ($status == 'Deactive') {
            $data = array('is_active' => FALSE);
            $this->db_2->WHERE('id', $action_id);
            $query = $this->db_2->UPDATE('users', $data);
            return true;
        }
    }

    function get_payment_receipt($id, $admin_for_type_id, $admin_for_id) {

        if (is_numeric($id)) {
            $sql = "select * from tbl_court_fee_payment where id = " . $id . " and entry_for_type_id = " . $admin_for_type_id . " and entry_for_id = " . $admin_for_id;
            $query = $this->db->query($sql);
            if ($query->num_rows() == 1) {
                return $query->result_array();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function get_admin_users1($admin_for_typeid, $admin_for_id) {

        $this->db->SELECT("id,userid, concat(first_name,' ',last_name) f_l_name, COUNT(userid) as count,ref_m_usertype_id ");
        $this->db->FROM(dynamic_users_table);
        $this->db->JOIN('tbl_efiling_nums ', 'tbl_efiling_nums.created_by=users.id');
        $this->db->where("tbl_efiling_nums.efiling_for_type_id", $admin_for_typeid);
        $this->db->where("tbl_efiling_nums.efiling_for_id", $admin_for_id);
        $this->db->where("users.is_active", TRUE);
        $this->db->group_by('userid');
        $this->db->group_by('first_name');
        $this->db->group_by('id');
        $this->db->group_by('last_name');
        $this->db->group_by('ref_m_usertype_id');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_admin_users($admin_for_typeid, $admin_for_id) {

        $sql = "select uid, userid,name,ref_m_usertype_id, string_agg(distinct (CASE WHEN stage_id = " . Draft_Stage . " THEN count::varchar END),',') as draft,  
                string_agg(distinct (CASE WHEN stage_id = " . Initial_Defected_Stage . " THEN count::varchar END),',') as Not_Accepted,
                string_agg(distinct (CASE WHEN stage_id = " . DEFICIT_COURT_FEE . " THEN count::varchar END),',') as Deficit,
                string_agg(distinct (CASE WHEN stage_id =  " . I_B_Defected_Stage . " THEN count::varchar END),',') as Defective
                 from 
                (select uid,userid,name,stage_id,ref_m_usertype_id,count(registration_id) 
                from 
                (select users.id as uid,users.ref_m_usertype_id,en.registration_id,en.created_by,users.userid,ec.stage_id,ec.activated_on,users.first_name||' '||users.last_name as name from tbl_efiling_nums en
                join " . dynamic_users_table . " on users.id=en.created_by
                join tbl_efiling_case_status ec on ec.registration_id=en.registration_id 
                where ec.is_active is true and ec.stage_id in (" . Draft_Stage . "," . Initial_Defected_Stage . "," . DEFICIT_COURT_FEE . "," . I_B_Defected_Stage . ") and users.is_active is true and en.efiling_for_type_id=" . $admin_for_typeid . " and en.efiling_for_id=" . $admin_for_id . ")a
                group by userid,stage_id,ref_m_usertype_id,name,uid order by userid,stage_id)b
                group by userid,name,ref_m_usertype_id,uid order by draft DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_efiling_details($id, $admin_for_typeid, $admin_for_id, $stageid) {

        $this->db->SELECT(array('en.efiling_no', 'users.first_name', 'users.last_name', 'en.ref_m_efiled_type_id', 'en.efiling_year', 'en.registration_id', 'et.efiling_type', 'cs.stage_id',
            'cs.activated_on', 'ec.pet_name', 'cs.activated_on', 'ms.case_type_name', 'ms.cnr_num', 'res_name', 'ms.cause_title', 'ec.cino'));
        $this->db->FROM('tbl_efiling_nums as en');
        $this->db->JOIN('tbl_efiling_case_status as cs', 'en.registration_id = cs.registration_id');
        $this->db->JOIN('m_tbl_efiling_type as et', 'en.ref_m_efiled_type_id=et.id');
        $this->db->JOIN('tbl_efiling_civil as ec', 'en.registration_id = ec.ref_m_efiling_nums_registration_id', 'left');
        $this->db->JOIN('tbl_misc_doc_filing as ms', 'ms.ref_m_efiling_nums_registration_id=en.registration_id ', 'left');
        $this->db->JOIN(dynamic_users_table, 'users.id=en.created_by ', 'left');
        $this->db->WHERE('cs.is_active', 'TRUE');
        $this->db->WHERE('en.is_active', 'TRUE');
        $this->db->WHERE('en.efiling_for_type_id', $admin_for_typeid);
        $this->db->WHERE('en.efiling_for_id', $admin_for_id);
        $this->db->WHERE('en.created_by', $id);
        $this->db->WHERE('cs.stage_id', $stageid);
        $this->db->ORDER_BY('cs.activated_on', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function deactive_admin_userlist($admin_for_typeid, $admin_for_id) {

        $this->db->SELECT("distinct(first_name),users.*");
        $this->db->FROM(dynamic_users_table);
        $this->db->JOIN('tbl_efiling_nums ', 'tbl_efiling_nums.created_by=users.id');
        $this->db->where("tbl_efiling_nums.efiling_for_type_id", $admin_for_typeid);
        $this->db->where("tbl_efiling_nums.efiling_for_id", $admin_for_id);
        $this->db->where("users.is_active", FALSE);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function check_if_admin_already_exist($data2) {

        if (!empty($data2['id'])) {
            $user_id = "and id != '" . $data2['id'] . "'";
        } else {
            $user_id = "";
        }

        if ($data2['ref_m_usertype_id'] != USER_ACTION_ADMIN) { //admin already exists
            $sql_query = "SELECT 'admin' as exists, * FROM " . dynamic_users_table . " WHERE ref_m_usertype_id  = '" . $data2['ref_m_usertype_id'] . "' and admin_for_type_id = '" . $data2['admin_for_type_id'] . "' and admin_for_id = '" . $data2['admin_for_id'] . "' AND is_active IS TRUE " . $user_id;
        }
        if ($data2['ref_m_usertype_id'] == USER_ADMIN) { // multiple admin enabled then do not allow to add USER ADMIN
            $sql_query = "SELECT 'multiple_admin' as exists, * FROM " . dynamic_users_table . " WHERE ref_m_usertype_id  IN('" . USER_MASTER_ADMIN . "','" . USER_ACTION_ADMIN . "') and admin_for_type_id = '" . $data2['admin_for_type_id'] . "' and admin_for_id = '" . $data2['admin_for_id'] . "' AND is_active IS TRUE ";
        }
        if ($data2['ref_m_usertype_id'] == USER_ACTION_ADMIN) { // check when action admin is being added if master admin exists or not
            $sql_query = "SELECT 'no_masteradmin' as exists, * FROM " . dynamic_users_table . " WHERE ref_m_usertype_id  IN('" . USER_MASTER_ADMIN . "') and admin_for_type_id = '" . $data2['admin_for_type_id'] . "' and admin_for_id = '" . $data2['admin_for_id'] . "' AND is_active IS TRUE ";
        }
        $sql_query .= " UNION SELECT 'loginid' as exists, * FROM " . dynamic_users_table . " WHERE userid = '" . $data2['userid'] . "' $user_id";
        $sql_query .= " UNION SELECT 'mobile' as exists, * FROM " . dynamic_users_table . " WHERE moblie_number = '" . $data2['moblie_number'] . "' $user_id";
        $sql_query .= " UNION SELECT 'email' as exists, * FROM " . dynamic_users_table . " WHERE emailid = '" . $data2['emailid'] . "' $user_id";

        $query = $this->db->query($sql_query);
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function check_if_master_admin_exist($data2) {
        // When an Action Admin is being created then to check whether Master Admin exists or not.

        $this->db->SELECT("*");
        $this->db->FROM(dynamic_users_table);
        $this->db->WHERE("is_active", TRUE);
        $this->db->WHERE("ref_m_usertype_id", USER_MASTER_ADMIN);
        $this->db->WHERE("admin_for_type_id", $data2['admin_for_type_id']);
        $this->db->WHERE("admin_for_id", $data2['admin_for_id']);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    function pending_advocate_list($admin_for_type_id) {

        // Sub Query        
        $this->db->SELECT('users.id,users.ref_m_usertype_id, tbl_advocate_register.id row_id ,login_id,add_date,efiling_for_type_id,is_register,users.first_name,users.last_name,users.moblie_number,users.bar_reg_no,users.enrolled_state_id,users.enrolled_district_id,users.enrolled_establishment_id, users.high_court_id');
        $this->db->FROM('tbl_advocate_register');
        $this->db->JOIN(dynamic_users_table, 'users.id=tbl_advocate_register.login_id', 'left');
        $this->db->WHERE('tbl_advocate_register.is_active', TRUE);
        $this->db->WHERE('tbl_advocate_register.high_court_id', $_SESSION['login']['admin_for_id']);
        $this->db->WHERE('tbl_advocate_register.efiling_for_type_id', $_SESSION['login']['admin_for_type_id']);
        $this->db->ORDER_BY("tbl_advocate_register.is_register");
        $this->db->ORDER_BY("tbl_advocate_register.id", "desc");

        $subQuery = $this->db->get_compiled_select();

        // Main Query
        $this->db->SELECT('a.*, case when (a.enrolled_state_id is null OR a.enrolled_state_id = 0) then (select hc_name from efil.m_tbl_high_courts where id = a.high_court_id ) else 
            (SELECT concat(estab_name, \',\', dist_name ,\',\',state )  
            FROM efil.m_tbl_state st 
            LEFT JOIN efil.m_tbl_districts dist ON st.state_id = dist.ref_m_tbl_states_id
            LEFT JOIN efil.m_tbl_establishments estab ON dist.id = estab.ref_m_tbl_districts_id
            where estab.id = a.enrolled_establishment_id ) end as enrolled_for', FALSE);
        $this->db->FROM("($subQuery ) a");
        $query = $this->db->get();
        return $query->result();
    }

    function advocate_info($user_id) {
        // Sub Query    
        $this->db->SELECT('users.*');
        $this->db->FROM(dynamic_users_table);
        $this->db->WHERE('id', $user_id);
        $this->db->WHERE('is_active', TRUE);

        $subQuery = $this->db->get_compiled_select();

        // Main Query
        $this->db->SELECT('a.*, case when (a.enrolled_state_id is null OR a.enrolled_state_id = 0) then (select hc_name from efil.m_tbl_high_courts where id = a.high_court_id ) else 
            (SELECT concat(estab_name, \',\', dist_name ,\',\',state )  
            FROM efil.m_tbl_state st 
            LEFT JOIN efil.m_tbl_districts dist ON st.state_id = dist.ref_m_tbl_states_id
            LEFT JOIN efil.m_tbl_establishments estab ON dist.id = estab.ref_m_tbl_districts_id
            where estab.id = a.enrolled_establishment_id ) end as enrolled_for', FALSE);
        $this->db->FROM("($subQuery ) a");
        $query = $this->db->get();
        return $query->result();
    }

    public function user_inperson_info($user_id) {

        $this->db->SELECT('*');
        $this->db->FROM(dynamic_users_table);
        $this->db->WHERE('users.is_account_active', TRUE);
        $this->db->WHERE('users.id', $user_id);
        $this->db->LIMIT(1);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    public function count_new_registered_user($newORrejected = FALSE) {

        $admin_for_id = $_SESSION['login']['admin_for_id'];
        $this->db->SELECT('COUNT(id)  as count');
        $this->db->FROM(dynamic_users_table);
        $this->db->WHERE('users.is_active', FALSE);
        $this->db->WHERE('users.is_account_active', TRUE);
        if ($newORrejected == 'rejected') {

            $this->db->like('users.moblie_number', 'NULL');
        } else {

            $this->db->not_like('users.moblie_number', 'NULL');
        }
        if ($_SESSION['login']['admin_for_type_id'] == ENTRY_TYPE_FOR_HIGHCOURT) {
            $this->db->WHERE("(users.high_court_id= '$admin_for_id' OR users.bench_court = '$admin_for_id')");
        } else {
            $this->db->WHERE('users.enrolled_establishment_id', $admin_for_id);
        }
        $this->db->WHERE('users.ref_m_usertype_id NOT IN (' . USER_ADMIN . ',' . USER_SUPER_ADMIN . ',' . USER_MASTER_ADMIN . ',' . USER_ACTION_ADMIN . ')');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->count;
        } else {
            return 0;
        }
    }

    function count_pending_advocate_list($admin_for_type_id) {

        if ($admin_for_type_id == E_FILING_FOR_HIGHCOURT) {
            $this->db->SELECT('COUNT(tbl_advocate_register.id)  as count');
            $this->db->FROM('tbl_advocate_register');
            $this->db->JOIN(dynamic_users_table, 'users.id=tbl_advocate_register.login_id');
            $this->db->WHERE('tbl_advocate_register.is_active', TRUE);
            $this->db->WHERE('tbl_advocate_register.high_court_id', $_SESSION['login']['admin_for_id']);
            $this->db->WHERE('tbl_advocate_register.efiling_for_type_id', $_SESSION['login']['admin_for_type_id']);
        } elseif ($admin_for_type_id == E_FILING_FOR_ESTABLISHMENT) {
            $this->db->SELECT('COUNT(tbl_advocate_register.id)  as count');
            $this->db->FROM('tbl_advocate_register');
            $this->db->JOIN(dynamic_users_table, 'users.id=tbl_advocate_register.login_id');
            $this->db->WHERE('tbl_advocate_register.is_active', TRUE);
            $this->db->WHERE('tbl_advocate_register.high_court_id', $_SESSION['login']['admin_for_id']);
            $this->db->WHERE('tbl_advocate_register.efiling_for_type_id', $_SESSION['login']['admin_for_type_id']);
        }

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->count;
        } else {
            return 0;
        }
    }

    function advocate_details($row_id, $admin_for_type_id) {

        if ($admin_for_type_id == E_FILING_FOR_HIGHCOURT) {

            $this->db->SELECT('tbl_advocate_register.login_id,' . E_FILING_FOR_HIGHCOURT . ' efiling_for_type_id,tbl_advocate_register.high_court_id,users.bar_reg_no,hc.hc_code national_code,hc.state_code');
            $this->db->FROM('tbl_advocate_register');
            $this->db->JOIN(dynamic_users_table, 'users.id=tbl_advocate_register.login_id');
            $this->db->JOIN('efil.m_tbl_high_courts hc', 'hc.id=tbl_advocate_register.high_court_id', 'left');
        } elseif ($admin_for_type_id == E_FILING_FOR_ESTABLISHMENT) {

            $this->db->SELECT('tbl_advocate_register.login_id,' . E_FILING_FOR_ESTABLISHMENT . ' efiling_for_type_id,tbl_advocate_register.high_court_id,users.bar_reg_no,estab.est_code national_code,estab.state_code');
            $this->db->FROM('tbl_advocate_register');
            $this->db->JOIN(dynamic_users_table, 'users.id=tbl_advocate_register.login_id');
            $this->db->JOIN('efil.m_tbl_establishments estab', 'estab.id=tbl_advocate_register.high_court_id', 'left');
        }

        $this->db->WHERE('tbl_advocate_register.is_active', TRUE);
        $this->db->WHERE('tbl_advocate_register.id', $row_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function advocate_status_update($user_id, $efiling_for_type_id, $adv_name, $adv_code, $row_id) {

        $this->db->trans_start();
        $data = array('is_register' => 'Y');
        $this->db->WHERE('id', $row_id);
        $this->db->WHERE('efiling_for_type_id', $efiling_for_type_id);
        $this->db->WHERE('is_active ', TRUE);
        $this->db->UPDATE('tbl_advocate_register', $data);
        if ($this->db->affected_rows() > 0) {

            $this->db->SELECT('registration_id, efiling_for_type_id, efiling_for_id,ref_m_efiled_type_id');
            $this->db->FROM('tbl_efiling_nums');
            $this->db->WHERE('created_by', $user_id);
            $this->db->WHERE('efiling_for_type_id', $efiling_for_type_id);
            $this->db->WHERE('is_active', TRUE);
            $query = $this->db->get();
            $result = $query->result_array();

            foreach ($result as $value) {
                if ($value['ref_m_efiled_type_id'] == E_FILING_TYPE_NEW_CASE) {
                    $update_efiling_civil_data[] = array(
                        'ref_m_efiling_nums_registration_id' => $value['registration_id'],
                        'pet_adv' => $adv_name,
                        'pet_adv_cd' => $adv_code
                    );
                }
                if ($value['ref_m_efiled_type_id'] == E_FILING_TYPE_MISC_DOCS || $value['ref_m_efiled_type_id'] == E_FILING_TYPE_DEFICIT_COURT_FEE || $value['ref_m_efiled_type_id'] == E_FILING_TYPE_IA) {
                    $update_misc_doc_data[] = array(
                        'ref_m_efiling_nums_registration_id' => $value['registration_id'],
                        'advocate_name' => $adv_name,
                        'advocate_code' => $adv_code
                    );
                }
            }

            if (!empty($update_efiling_civil_data)) {
                $this->db->update_batch('tbl_efiling_civil', $update_efiling_civil_data, 'ref_m_efiling_nums_registration_id');
            } if (!empty($update_misc_doc_data)) {
                $this->db->update_batch('tbl_misc_doc_filing', $update_misc_doc_data, 'ref_m_efiling_nums_registration_id');
            }

            if ($this->db->trans_status() === FALSE) {
                return FALSE;
            } else {
                $this->db->trans_complete();
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

    function action_to_active_user($action_id, $status) {

        $this->db_2 = $this->load->database(unserialize(dynamic_users_table_connection), TRUE);
        if ($status == 'Active') {
            $data = array('is_active' => TRUE, 'is_account_active' => TRUE);
            $this->db_2->WHERE('id', $action_id);
            $query = $this->db_2->UPDATE('users', $data);
            return true;
        } if ($status == 'Deactive') {
            $data = array('is_active' => FALSE, 'is_account_active' => FALSE);
            $this->db_2->WHERE('id', $action_id);
            $query = $this->db_2->UPDATE('users', $data);
            return true;
        }
    }

    function get_transaction_details($order_id) {

        $this->db->SELECT('*');
        $this->db->FROM('tbl_court_fee_payment');
        $this->db->WHERE('order_no', $order_id);
        $this->db->WHERE('is_active', TRUE);
        $this->db->LIMIT(1);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_contact_list() {

        $this->db->SELECT('users.*');
        $this->db->FROM('efil.tbl_admin_contact users');
        $this->db->WHERE('is_active', TRUE);
        $this->db->WHERE('updated_by', $_SESSION['login']['id']);
        $subQuery = $this->db->get_compiled_select();

        // Main Query
        $this->db->SELECT('a.*, case WHEN (a.admin_for_type_id = ' . E_FILING_FOR_HIGHCOURT . ' ) 
            THEN (SELECT hc_name from efil.m_tbl_high_courts WHERE id = a.admin_for_id) 
            ELSE 
            (SELECT concat( estab_name, \'@@@\', dist_name ,\'@@@\',state )
            FROM efil.m_tbl_state st 
            LEFT JOIN efil.m_tbl_districts dist ON st.state_id = dist.ref_m_tbl_states_id
            LEFT JOIN efil.m_tbl_establishments estab ON dist.id = estab.ref_m_tbl_districts_id
            WHERE estab.id = a.admin_for_id ORDER BY dist_name ,estab_name) END as estab_details', FALSE);
        $this->db->FROM("($subQuery ) a");

        $subQuery2 = $this->db->get_compiled_select();

        $this->db->SELECT('email_id');
        $this->db->SELECT("string_agg(id::varchar(101), '||||') as id", FALSE);
        $this->db->SELECT("string_agg(estab_details,'||||') as estab_name", FALSE);
        $this->db->FROM("($subQuery2 ) b");
        $this->db->GROUP_BY("email_id");
        $query = $this->db->get();
        return $query->result();
    }

    function add_contact($data) { 
        $this->db->INSERT('efil.tbl_admin_contact', $data);
        if ($this->db->insert_id()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function add_contact_batch($data) {
        print_r($data);die;
        $this->db->INSERT_BATCH('efil.tbl_admin_contact', $data);
        if ($this->db->insert_id()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_contact_details($id) {

        $this->db->WHERE('id', $id);
        $query = $this->db->get('efil.tbl_admin_contact', 1);
        return $query->result();
    }

    function update_contact($data, $id, $frm_ref_id, $court_type) {

        if ($court_type == E_FILING_FOR_ESTABLISHMENT) {
            $this->db->WHERE('frm_ref_id', $frm_ref_id);
            $query = $this->db->DELETE('efil.tbl_admin_contact');
            if ($query) {
                $this->db->INSERT_BATCH('efil.tbl_admin_contact', $data);
                return true;
            } else {
                return false;
            }
        } elseif ($court_type == E_FILING_FOR_HIGHCOURT) {
            $this->db->WHERE('frm_ref_id', $frm_ref_id);
            $query = $this->db->UPDATE('efil.tbl_admin_contact', $data);
            if ($query) {

                return true;
            } else {
                return false;
            }
        }
    }

    function update_user_detail($user_id, $data) {

        $this->db_2 = $this->load->database(unserialize(dynamic_users_table_connection), TRUE);
        $this->db_2->set($data);
        $this->db_2->WHERE('id', $user_id);
        $result = $this->db_2->UPDATE('users');
        if ($this->db_2->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    function court_details($id, $fetch_details_for) {

        if ($fetch_details_for == E_FILING_FOR_HIGHCOURT) {
            $this->db->SELECT("hc.hc_name as location");
            $this->db->FROM('efil.m_tbl_high_courts hc');
            $this->db->WHERE('id', $id);
            $query = $this->db->get();
            return $query->result_array();
        }

        if ($fetch_details_for == USER_DISTRICT_ADMIN) {
            $this->db->SELECT("CONCAT(dist.dist_name,', ',state.state,', ',hc.hc_name) as location");
            $this->db->FROM('efil.m_tbl_districts dist');
            $this->db->JOIN('efil.m_tbl_state state', 'dist.ref_m_tbl_states_id = state.state_id');
            $this->db->JOIN('efil.m_tbl_high_courts hc', 'hc.id = state.ref_efil.m_tbl_high_courts_id');
            $this->db->WHERE('dist.id', $id);
            $query = $this->db->get();
            return $query->result_array();
        }

        if ($fetch_details_for == ENTRY_TYPE_FOR_ESTABLISHMENT) {
            $this->db->SELECT("CONCAT(estab.estab_name,', ',dist.dist_name,', ',state.state,', ',hc.hc_name) as location");
            $this->db->FROM('efil.m_tbl_establishments estab');
            $this->db->JOIN('efil.m_tbl_districts dist', 'estab.ref_m_tbl_districts_id = dist.id');
            $this->db->JOIN('efil.m_tbl_state state', 'dist.ref_m_tbl_states_id = state.state_id');
            $this->db->JOIN('efil.m_tbl_high_courts hc', 'hc.id = state.ref_efil.m_tbl_high_courts_id');
            $this->db->WHERE('estab.id', $id);
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    /* -----------------------REASON------------------ */

    function add_reason($data) {

        $this->db->INSERT('m_tbl_allocation_reason', $data);
        if ($this->db->insert_id()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_reason() {

        $this->db->SELECT('*');
        $this->db->FROM('m_tbl_allocation_reason');
        $this->db->WHERE('created_by', $_SESSION['login']['id']);
        $this->db->ORDER_BY('created_on', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_reason_id($id) {

        $this->db->SELECT('*');
        $this->db->FROM('m_tbl_allocation_reason');
        $this->db->WHERE('id', $id);
        $this->db->WHERE('created_by', $_SESSION['login']['id']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function update_reason($data, $id) {

        $this->db->WHERE('id', $id);
        $this->db->WHERE('created_by', $_SESSION['login']['id']);
        $this->db->UPDATE('m_tbl_allocation_reason', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function update_reason_status($action_id, $data) {

        $this->db->WHERE('id', $action_id);
        $this->db->WHERE('created_by', $_SESSION['login']['id']);
        $this->db->UPDATE('m_tbl_allocation_reason', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* -------------------END REASON--------------------- */

    function get_admin_list_hc_master_admin() {

        $this->db->SELECT("users.admin_for_type_id, hc.*,  users.*");
        $this->db->FROM(dynamic_users_table);
        $this->db->JOIN('efil.m_tbl_high_courts hc ', 'hc.id = users.admin_for_id');
        $this->db->WHERE('users.admin_for_type_id', ENTRY_TYPE_FOR_HIGHCOURT);
        $this->db->WHERE('hc.id', $_SESSION['login']['admin_for_id']);
        $this->db->WHERE_IN('users.ref_m_usertype_id', USER_ACTION_ADMIN);
        $this->db->ORDER_BY('hc.hc_name', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function add_case_type_master($data) {

        $this->db->INSERT('m_tbl_cis_case_type', $data);
        if ($this->db->insert_id()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_case_type_list() {

        $this->db->SELECT('cct.id,cct.state_code,cct.national_code,cct.efiling_for_type_id,cct.efiling_for_id,cct.civil_or_criminal,cct.cis_case_type_id,
                cct.cis_case_type_name ,cct.created_by,cct.created_on,cct.created_by_ip,
                cct.updated_by,cct.updated_on,cct.updated_by_ip,cct.is_deleted, CASE WHEN (cct.efiling_for_type_id = ' . E_FILING_FOR_HIGHCOURT . ' ) 
            THEN (SELECT hc_name from efil.m_tbl_high_courts WHERE id = cct.efiling_for_id) 
            ELSE 
            (SELECT concat( estab_name, \'@@@\', dist_name ,\'@@@\',state )
            FROM efil.m_tbl_state st 
            LEFT JOIN efil.m_tbl_districts dist ON st.state_id = dist.ref_m_tbl_states_id
            LEFT JOIN efil.m_tbl_establishments estab ON dist.id = estab.ref_m_tbl_districts_id
            WHERE estab.id = cct.efiling_for_id ORDER BY dist_name ,estab_name) END as estab_details');
        $this->db->FROM('m_tbl_cis_case_type cct');
        $this->db->WHERE('cct.created_by', $_SESSION['login']['id']);
        $this->db->WHERE('cct.is_deleted', FALSE);
        $this->db->ORDER_BY('cct.civil_or_criminal', 'ASC');
        $this->db->ORDER_BY('cct.cis_case_type_id', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_enable_case_type_list($national_code, $civil_or_criminal, $court_type, $state_code) {

        $this->db->SELECT("*");
        $this->db->FROM('m_tbl_cis_case_type');
        $this->db->WHERE('national_code', $national_code);
        $this->db->WHERE('civil_or_criminal', $civil_or_criminal);
        $this->db->WHERE('efiling_for_type_id', $court_type);
        $this->db->WHERE('state_code', $state_code);
        $this->db->WHERE('is_deleted', FALSE);
        $this->db->ORDER_BY('cis_case_type_id', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function delete_case_type_master($id) {

        $data = array('is_deleted' => TRUE);
        $this->db->WHERE('id', $id);
        $this->db->WHERE('created_by', $_SESSION['login']['id']);
        $this->db->UPDATE('m_tbl_cis_case_type', $data);

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function case_type_id_in_array($national_code, $civil_or_criminal, $court_type, $state_code) {

        $this->db->SELECT('array_agg("cis_case_type_id")');
        $this->db->FROM('m_tbl_cis_case_type');
        $this->db->WHERE('national_code', $national_code);
        //$this->db->WHERE('civil_or_criminal', $civil_or_criminal);
        $this->db->WHERE('efiling_for_type_id', $court_type);
        $this->db->WHERE('state_code', $state_code);
        $this->db->WHERE('is_deleted', FALSE);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }

    function decode_cron_status($date = null) {

        $this->db->SELECT('id,responce,cron_date');
        $this->db->FROM('cron_for_cis_log');
        if (!empty($date)) {
            $this->db->WHERE('cron_date', $date);
        }
        $this->db->ORDER_BY('cron_date', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_est_masteradmin_type($state_id, $dist_id, $estab_id) {

        $this->db->SELECT('*');
        $this->db->FROM(dynamic_users_table);
        $this->db->WHERE('users.enrolled_state_id', $state_id);
        $this->db->WHERE('users.enrolled_district_id', $dist_id);
        $this->db->WHERE('users.admin_for_id', $estab_id);
        $this->db->WHERE('users.ref_m_usertype_id', USER_MASTER_ADMIN);
        $this->db->WHERE('users.admin_for_type_id', E_FILING_FOR_ESTABLISHMENT);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_est_admin_type($state_id, $dist_id, $estab_id) {

        $this->db->SELECT('*');
        $this->db->FROM(dynamic_users_table);
        $this->db->WHERE('users.enrolled_state_id', $state_id);
        $this->db->WHERE('users.enrolled_district_id', $dist_id);
        $this->db->WHERE('users.admin_for_id', $estab_id);
        $this->db->WHERE('users.admin_for_type_id', E_FILING_FOR_ESTABLISHMENT);
        $this->db->WHERE_IN('users.ref_m_usertype_id', array(USER_ADMIN, USER_MASTER_ADMIN, USER_ACTION_ADMIN));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_hc_masteradmin_type($state_id) {

        $this->db->SELECT('*');
        $this->db->FROM(dynamic_users_table);
        $this->db->WHERE('users.admin_for_id', $state_id);
        $this->db->WHERE('users.admin_for_type_id', E_FILING_FOR_HIGHCOURT);
        $this->db->WHERE('users.ref_m_usertype_id', USER_MASTER_ADMIN);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_hc_admin_type($state_id) {

        $this->db->SELECT('*');
        $this->db->FROM(dynamic_users_table);
        $this->db->WHERE('users.admin_for_id', $state_id);
        $this->db->WHERE('users.admin_for_type_id', E_FILING_FOR_HIGHCOURT);
        $this->db->WHERE_IN('users.ref_m_usertype_id', array(USER_ADMIN, USER_MASTER_ADMIN, USER_ACTION_ADMIN));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function admin_allocated_efiling_nums($id) {

        $this->db->SELECT('registration_id, efiling_no');
        $this->db->FROM('tbl_efiling_nums');
        $this->db->WHERE('allocated_to', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return false;
        }
    }

    function get_action_admins_list($id) {

        $this->db_2 = $this->load->database(unserialize(dynamic_users_table_connection), TRUE);
        $this->db_2->SELECT('u1.userid');
        $this->db_2->FROM('users u1');
        $this->db_2->JOIN('users u2', 'u1.admin_for_type_id = u2.admin_for_type_id and u1.admin_for_id = u2.admin_for_id');
        $this->db_2->WHERE('u1.ref_m_usertype_id', USER_ACTION_ADMIN);
        $this->db_2->WHERE('u2.id', $id);
        $this->db_2->WHERE('u1.is_active', true);
        $this->db_2->WHERE('u2.is_active', true);
        $query = $this->db_2->get();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return false;
        }
    }

    function get_master_action_admin($estab_id) {

        $this->db->SELECT('*');
        $this->db->FROM(dynamic_users_table);
        $this->db->WHERE('users.ref_m_usertype_id', USER_ACTION_ADMIN);
        $this->db->WHERE('admin_for_id', $estab_id);
        $this->db->WHERE('admin_for_type_id', $_SESSION['login']['admin_for_type_id']);
        $this->db->WHERE('users.is_active', true);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function district_action_admin($estab_id) {

        $this->db->SELECT("users.admin_for_type_id, estab.id, estab.estab_name estab_name, estab.state_code state_code,district.dist_name estab_distt,  users.*");
        $this->db->FROM(dynamic_users_table);
        $this->db->JOIN('efil.m_tbl_establishments estab ', 'estab.id = users.admin_for_id');
        $this->db->JOIN('efil.m_tbl_districts district ', 'estab.ref_m_tbl_districts_id = district.id', 'LEFT');
        $this->db->WHERE('estab.display', 'Y');
        $this->db->WHERE('users.admin_for_type_id', ENTRY_TYPE_FOR_ESTABLISHMENT);
        $this->db->WHERE('estab.ref_m_tbl_districts_id', $_SESSION['login']['admin_for_id']);
        $this->db->WHERE('users.admin_for_id', $estab_id);
        $this->db->WHERE_IN('users.ref_m_usertype_id', USER_ACTION_ADMIN);
        $this->db->ORDER_BY('estab.estab_name', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_efiling_num_list($id) {

        $this->db->SELECT('registration_id, efiling_no');
        $this->db->FROM('tbl_efiling_nums');
        $this->db->WHERE('allocated_to', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function update_allocation($efil_no, $to_id, $from_id) {

        $data = array('allocated_to' => $to_id);
        $this->db->where('allocated_to', $from_id);
        $this->db->where_in('registration_id', $efil_no);
        $this->db->update('tbl_efiling_nums', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_high_court_user($estab_id) {

        $this->db->SELECT('users.*');
        $this->db->FROM('efil.m_tbl_high_courts hc ');
        $this->db->JOIN(dynamic_users_table, 'hc.id = users.admin_for_id');
        $this->db->where('hc.is_active', TRUE);
        $this->db->where('hc.state_code', $_SESSION['login']['admin_for_id']);
        $this->db->where('users.admin_for_type_id ', ENTRY_TYPE_FOR_HIGHCOURT);
        $this->db->where('users.ref_m_usertype_id ', USER_ACTION_ADMIN);
        $this->db->where('users.admin_for_id ', $estab_id);
        $this->db->where('users.is_active', TRUE);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function estab_action_admin($state_id, $dist_id, $estab_id) {

        $this->db->SELECT(" users.*");
        $this->db->FROM(dynamic_users_table);
        $this->db->WHERE('users.admin_for_type_id', ENTRY_TYPE_FOR_ESTABLISHMENT);
        $this->db->WHERE('users.enrolled_state_id', $state_id);
        $this->db->WHERE('users.enrolled_district_id', $dist_id);
        $this->db->WHERE('users.admin_for_id', $estab_id);
        $this->db->WHERE('users.ref_m_usertype_id', USER_ACTION_ADMIN);

        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

}

?>
