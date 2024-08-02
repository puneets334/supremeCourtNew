<?php

namespace App\Models\Filehashing;
use CodeIgniter\Model;

class PdfHashTasks_model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function save_pdf_hash_task($registration_id,$efiling_no,$mapped_pspdfkit_document_id, $pspdfkit_document_id, $max_submit_count, $title) {
        $data = array('registration_id'=>$registration_id,'efiling_no'=>$efiling_no,'mapped_pspdfkit_document_id'=>$mapped_pspdfkit_document_id,'pspdfkit_document_id'=>$pspdfkit_document_id, 'submit_count'=>$max_submit_count, 'doc_title'=>$title);
        $this->db->INSERT('efil.tbl_pdf_hash_tasks', $data);
        if ($this->db->insert_id()) {
            return true;
        }else{
            return false;
        }
    }
    public function get_max_submit_count($efiling_no){

        $this->db->SELECT('MAX(tasks.submit_count) as submit_count');
        $this->db->FROM('efil.tbl_pdf_hash_tasks tasks');
        $this->db->WHERE('tasks.efiling_no',$efiling_no);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            $result = $query->result_array();
            return (int)$result[0]['submit_count'];
        } else {
            return 0;
        }
    }
//
//    public function get_unprocessed_pdf_hash_tasks(){
//        $this->db->SELECT('tasks.*');
//        $this->db->FROM('efil.tbl_pdf_hash_tasks tasks');
//        $this->db->WHERE('tasks.is_hash_created',false);
//        $query = $this->db->get();
//        if ($query->num_rows() >= 1) {
//            $result = $query->result_array();
//            return $result;
//        } else {
//            return FALSE;
//        }
//    }
}
