<?php

namespace App\Models\History;
use CodeIgniter\Model;

class History_model extends Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function get_new_case_details($registration_id) {

        $this->db->SELECT("*");
        $this->db->FROM('efil.tbl_case_details cd');
        $this->db->WHERE('cd.registration_id', $registration_id);
        $this->db->WHERE('cd.is_deleted', FALSE);

        $query = $this->db->get();

        if ($query->num_rows() >= 1) {

            $new_case_details = $query->result_array();
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    function get_efiled_by_user($user_id) {
        $this->db->SELECT('id,ref_m_usertype_id,first_name, last_name, moblie_number, emailid');
        $this->db->FROM('efil.tbl_users');
        $this->db->WHERE('id', $user_id);
        $query = $this->db->get();
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }

    function get_stages($registration_id) {
        
        $this->db->SELECT('*');
        $this->db->FROM('efil.tbl_efiling_num_status');
        $this->db->JOIN('efil.m_tbl_dashboard_stages as ds', 'efil.tbl_efiling_num_status.stage_id=ds.stage_id', 'LEFT');
        $this->db->WHERE('efil.tbl_efiling_num_status.registration_id', $registration_id);
        $this->db->ORDER_BY('efil.tbl_efiling_num_status.activated_on', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_court_fee_payment_history($regid) {
        $this->db->SELECT('*');
        $this->db->FROM('efil.tbl_court_fee_payment');
        $this->db->WHERE('efil.tbl_court_fee_payment.registration_id', $regid);
        $this->db->WHERE('efil.tbl_court_fee_payment.is_deleted', FALSE);
        $this->db->ORDER_BY('id', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows()) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

    function get_allocated_history($registration_id) {
        $this->db->SELECT("ea.*,concat(users.first_name,' ',users.last_name) as admin_name");
        $this->db->FROM('efil.tbl_efiling_allocation ea');
        $this->db->JOIN('efil.tbl_users users', 'users.id = ea.admin_id', 'LEFT');
        $this->db->WHERE('registration_id', $registration_id);
        $this->db->ORDER_BY('id', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_intials_defects_for_history($regid) {

        if (!(isset($regid) && !empty($regid))) {
            return FALSE;
        }
        $this->db->SELECT('*');
        $this->db->FROM('efil.tbl_initial_defects');
        $this->db->WHERE('registration_id', $regid);
        $this->db->ORDER_BY('defect_date', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    function getPdfDoc($pdf_id, $uploaded_by) {
        
        $this->db->SELECT('tbl_efiled_docs.*');
        $this->db->FROM('efil.tbl_efiled_docs');
        $this->db->WHERE('tbl_efiled_docs.doc_id', $pdf_id);
        $this->db->WHERE('tbl_efiled_docs.uploaded_by', $uploaded_by);
        $query = $this->db->get();
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }

// Get PDF files for Admin

    function get_pdf_for_admin($pdf_id) {
        $this->db->SELECT('tbl_efiled_docs.file_name,tbl_efiled_docs.file_uploaded_path');
        $this->db->FROM('efil.tbl_efiled_docs');
        $this->db->WHERE('tbl_efiled_docs.doc_id', $pdf_id);
        $query = $this->db->get();
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }

}

?>
