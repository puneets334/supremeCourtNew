<?php

namespace App\Models\IA;
use CodeIgniter\Model;

class CourtFeeModel extends Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $db      = \Config\Database::connect();  
    }

    function get_uploaded_pages_count($registration_id){
        $builder = $this->db->table('efil.tbl_uploaded_pdfs docs');
        $builder->select('SUM(docs.page_no) uploaded_pages_count');
        $builder->WHERE('docs.registration_id', $registration_id);
        $builder->WHERE('docs.is_deleted', FALSE)->where('docs.is_active',true);
        // $builder->orderBy('docs.registration_id', 'ASC');
        $builder->groupBy('docs.registration_id'); 
        $query = $builder->get();
        // $sql = $this->db->getLastQuery();
        // echo "Generated SQL Query: $sql"; 
        // die;
        if ($query->getNumRows() >= 1) {
            $result = $query->getResult();
            return $result[0]->uploaded_pages_count;
        } else {
            return 0;
        }
    }    
    
    function get_payment_details($registration_id){
        // pr($registration_id);
        $builder = $this->db->table('efil.tbl_court_fee_payment cfp');
        $builder->SELECT('*');
        $builder->WHERE('cfp.registration_id', $registration_id);
        $builder->WHERE('cfp.is_deleted', FALSE);
        $builder->orderBy('cfp.id', 'DESC');
        $query =  $builder->get();
        //echo $this->db->last_query();
        if ($query->getNumRows() >= 1) {
            $result = $query->getResult();
            return $result;
        } else {
            return FALSE;
        }
    }
    
    function insert_pg_request($data_to_save){
        $builder = $this->db->table('efil.tbl_court_fee_payment');
        $builder->INSERT($data_to_save);        
        if($this->db->insertID()){
            return TRUE;
        }else{
            return FALSE;
        }
    }

}