<?php

class Contactus_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function get_contactus_results() {

        $this->db->SELECT('users.*');
        $this->db->FROM('efil.tbl_admin_contact users');
        $this->db->WHERE('is_active', TRUE);
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
//        $this->db->SELECT('a.*, case WHEN (a.admin_for_type_id = ' . E_FILING_FOR_HIGHCOURT . ' ) 
//            THEN (SELECT hc_name from efil.m_tbl_high_courts WHERE id = a.admin_for_id) 
//            ELSE 
//            (SELECT *
//            FROM efil.m_tbl_state st 
//            LEFT JOIN efil.m_tbl_districts dist ON st.state_id = dist.ref_m_tbl_states_id 
//            WHERE estab.id = a.admin_for_id ORDER BY dist_name ,estab_name) END as estab_details', FALSE);
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

    function get_district_admin_contact_results() {

        $this->db->SELECT('*');
        $this->db->FROM(dynamic_users_table);
        $this->db->JOIN('efil.m_tbl_districts dist', 'users.admin_for_id = dist.id', 'LEFT');
        $this->db->JOIN('efil.m_tbl_establishments estab', 'estab.ref_m_tbl_districts_id = dist.id', 'LEFT');
        $this->db->WHERE('users.is_active', TRUE);
        $this->db->WHERE('users.ref_m_usertype_id', USER_DISTRICT_ADMIN);
        $this->db->WHERE('estab.id', $_SESSION['login']['admin_for_id']);
        $query = $this->db->get();
        return $query->result();
    }

    function get_super_admin_contact_details() {

        if ($_SESSION['login']['admin_for_type_id'] == ENTRY_TYPE_FOR_HIGHCOURT) {
            $this->db->SELECT('*');
            $this->db->FROM(dynamic_users_table);
            $this->db->JOIN('efil.m_tbl_high_courts estab', 'estab.state_code = users.admin_for_id');
            $this->db->WHERE('users.is_active', TRUE);
            $this->db->WHERE('users.ref_m_usertype_id', USER_SUPER_ADMIN);
            $this->db->WHERE('estab.id', $_SESSION['login']['admin_for_id']);
        } elseif ($_SESSION['login']['admin_for_type_id'] == ENTRY_TYPE_FOR_ESTABLISHMENT) {
            $this->db->SELECT('*');
            $this->db->FROM(dynamic_users_table);
            $this->db->JOIN('efil.m_tbl_establishments estab', 'estab.state_code = users.admin_for_id');
            $this->db->WHERE('users.is_active', TRUE);
            $this->db->WHERE('users.ref_m_usertype_id', USER_SUPER_ADMIN);
            $this->db->WHERE('estab.id', $_SESSION['login']['admin_for_id']);
        } elseif ($_SESSION['login']['admin_for_type_id'] == USER_DISTRICT_ADMIN) {
            $this->db->SELECT('*');
            $this->db->FROM(dynamic_users_table);
            $this->db->JOIN('efil.m_tbl_districts estab', 'estab.ref_m_tbl_states_id = users.admin_for_id');
            $this->db->WHERE('users.is_active', TRUE);
            $this->db->WHERE('users.ref_m_usertype_id', USER_SUPER_ADMIN);
            $this->db->WHERE('estab.id', $_SESSION['login']['admin_for_id']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_master_admin_contact_details() {

        if ($_SESSION['login']['admin_for_type_id'] == ENTRY_TYPE_FOR_HIGHCOURT) {
            $this->db->SELECT('*');
            $this->db->FROM(dynamic_users_table);
            $this->db->JOIN('efil.m_tbl_high_courts estab', 'estab.id = users.admin_for_id');
            $this->db->WHERE('users.is_active', TRUE);
            $this->db->WHERE('users.admin_for_type_id', ENTRY_TYPE_FOR_HIGHCOURT);
            $this->db->WHERE('users.ref_m_usertype_id', USER_MASTER_ADMIN);
            $this->db->WHERE('estab.id', $_SESSION['login']['admin_for_id']);
        } elseif ($_SESSION['login']['admin_for_type_id'] == ENTRY_TYPE_FOR_ESTABLISHMENT) {
            $this->db->SELECT('*');
            $this->db->FROM(dynamic_users_table);
            $this->db->JOIN('efil.m_tbl_establishments estab', 'estab.id = users.admin_for_id');
            $this->db->WHERE('users.is_active', TRUE);
            $this->db->WHERE('users.admin_for_type_id', ENTRY_TYPE_FOR_ESTABLISHMENT);
            $this->db->WHERE('users.ref_m_usertype_id', USER_MASTER_ADMIN);
            $this->db->WHERE('estab.id', $_SESSION['login']['admin_for_id']);
        }
        $query = $this->db->get();
        return $query->result();
    }

}
