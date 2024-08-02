<?php

namespace App\Models\Assistance;
use CodeIgniter\Model;

class Notice_model extends Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function insert_notice($array, $file_temp_name) {


        $this->db->INSERT('efil.tbl_news', $array);
        if ($this->db->insert_id()) {

            if (!empty($file_temp_name)) {
                $file_uploaded_dir = 'Notice/';
                $filename = $array['file_name'];
                if (!is_dir($file_uploaded_dir)) {
                    $uold = umask(0);
                    if (mkdir($file_uploaded_dir, 0777, true)) {
                        $html = '<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>';
                        write_file($file_uploaded_dir . '/index.html', $html);
                    }
                    umask($uold);
                }

                $result = $this->upload_file($file_uploaded_dir, $filename, $file_temp_name);
                if ($result) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

    function update_notice_by_id($id, $created_by, $data_update, $file_temp_name) {

        $this->db->WHERE('created_by', $created_by);
        $this->db->WHERE('id', $id);
        $this->db->WHERE('is_notice', TRUE);
        $this->db->UPDATE('efil.tbl_news', $data_update);

        if ($this->db->affected_rows() > 0) {

            if (!empty($file_temp_name)) {
                $file_uploaded_dir = 'Notice/';
                $filename = $data_update['file_name'];
                if (!is_dir($file_uploaded_dir)) {
                    $uold = umask(0);
                    if (mkdir($file_uploaded_dir, 0777, true)) {
                        $html = '<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>';
                        write_file($file_uploaded_dir . '/index.html', $html);
                    }
                    umask($uold);
                }

                $result = $this->upload_file($file_uploaded_dir, $filename, $file_temp_name);
                if ($result) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

    function upload_file($file_uploaded_dir, $filename, $file) {
        $uploaded = move_uploaded_file($file, "$file_uploaded_dir/$filename");
        if ($uploaded) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function notice_list() {
        $this->db->SELECT('*');
        $this->db->FROM('efil.tbl_news');
        $this->db->WHERE('created_by', $_SESSION['login']['id']);
        $this->db->WHERE('is_notice', TRUE);
        $this->db->ORDER_BY('id', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

    function get_notice_by_id($id, $created_by) {
        $this->db->SELECT('*');
        $this->db->FROM('efil.tbl_news');
        $this->db->WHERE('created_by', $created_by);
        $this->db->WHERE('id', $id);
        $this->db->WHERE('is_notice', TRUE);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

    function update_status_notice_by_id($id, $created_by, $data_update) {


        $this->db->WHERE('created_by', $created_by);
        $this->db->WHERE('id', $id);
        $this->db->UPDATE('efil.tbl_news', $data_update);

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function view_notice_pdf($id) {
        $this->db->SELECT('file_name,file_uploaded_path');
        $this->db->FROM('efil.tbl_news');
        $this->db->WHERE('id', $id);
        $this->db->WHERE('is_notice', TRUE);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

    function notice_list_by_category() {
        if (!empty($_SESSION['login']['state_code'])) {
            $state_code = $_SESSION['login']['m_state_id'];
        } else {
            $state_code = $_SESSION['login']['m_state_id'];
        }
        $this->db->SELECT('*');                                                                                                                                                                                 
        $this->db->FROM('efil.tbl_news');
        $this->db->WHERE('is_deleted', TRUE);
        //$this->db->WHERE('for_state_id', $state_code);
        $this->db->WHERE('is_notice', TRUE);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

}
