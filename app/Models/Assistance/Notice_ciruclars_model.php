<?php

namespace App\Models\Assistance;
use CodeIgniter\Model;

class Notice_ciruclars_model extends Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        //$this->db = $this->load->database('db', TRUE);
    }

    function insert_news($array, $file_temp_name) {
        $builder = $this->db->table('efil.tbl_news');
        $query = $builder->insert($array);

        // $this->db->INSERT('efil.tbl_news', $array);
        if ($this->db->insertID()) {

            if (!empty($file_temp_name)) {
                $file_uploaded_dir = 'news/';
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

    function update_news_by_id($id, $data_update, $file_temp_name = null) {
        $builder = $this->db->table('efil.tbl_news');
        $builder->where('id', $id);
        $query = $builder->update($data_update);

        // $this->db->WHERE('id', $id);
        // $this->db->UPDATE('efil.tbl_news', $data_update);

        if ($this->db->affectedRows() > 0) {


            if (!empty($file_temp_name)) {
                $file_uploaded_dir = 'news/';
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

    function notice_circulars_list() {
        // $this->db->SELECT('*');
        // $this->db->FROM('efil.tbl_news');
        // $this->db->WHERE('is_deleted', FALSE);
        // if ($_SESSION['login']['ref_m_usertype_id'] != USER_ADMIN) {
        //     $this->db->WHERE('deactive_date >=', date('Y-m-d'));
        // }
        // $this->db->ORDER_BY('id', 'DESC');

        // $query = $this->db->get();

        // if ($query->num_rows() > 0) {
        //     $result = $query->result_array();
        //     return $result;
        // } else {
        //     return false;
        // }

        // $builder = $this->db->table('efil.tbl_news');

        // $builder->where('is_deleted', FALSE);
        // if($_SESSION['login']['ref_m_usertype_id'] != USER_ADMIN)
        // {
        //     $builder->where('deactive_date >=', date('Y-m-d'));
        // }
        // $builder->orderBy('id', 'DESC');
        // $query = $builder->get();

        // // Check the number of rows
        // $rowCount = $query->getNumRows();

        // // Get the result as an array of objects
        // $result = $query->getResult();
        // if($rowCount > 0)
        // {
        //     return $result;
        // }
        // else
        // {
        //     return false;
        // }
        $builder = $this->db->table('efil.tbl_news');
        $builder->select('*');
        $builder->where('is_deleted', FALSE);
        if(getSessionData('login')['ref_m_usertype_id'] != USER_ADMIN) {
            $builder->where('deactive_date >=', date('Y-m-d'));
        }
        $builder->orderBy('id', 'DESC');
        $query = $builder->get();
        $output = $query->getResultArray();
        return $output;
    }

    function get_news_by_id($id) {
        // $this->db->SELECT('*');
        // $this->db->FROM('efil.tbl_news');
        // $this->db->WHERE('id', $id);
        // $query = $this->db->get();
        // if ($query->num_rows() > 0) {
        //     $result = $query->result_array();
        //     return $result;
        // } else {
        //     return false;
        // }
        $builder = $this->db->table('efil.tbl_news');
        $builder->select('*');
        $builder->where('id', $id);
        $query = $builder->get();
        if(count($query->getResult()) > 0) {
            $output = $query->getResultArray();
            return $output;
        } else{
            return false;
        }
    }

}
