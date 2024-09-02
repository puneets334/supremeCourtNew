<?php

namespace App\Models\OnlineCopying;

use CodeIgniter\Model;
use Config\Database;
class CommonModel extends Model
{
    protected $db2;
    function __construct()
    {
        parent::__construct();
        $this->db2 = Database::connect('sci_cmis_final'); // Connect to the 'sci_cmis_final' database
    }

    function getCategory(){
        $builder = $this->db2->table('master.copy_category');
        $builder->select('id, code');
        $builder->orderBy('id');
        $query = $builder->get();
        if ($query === false) {
            // Convert array error to string for logging
            $error = $this->db2->error();
            log_message('error', 'Query Error: ' . print_r($error, true)); // Use print_r to convert array to string
            return false;
        }
        $result = $query->getResult();
        return $result;
    }

    function copyFaq(){
        $builder = $this->db2->table('master.icmis_faqs');
        $builder->where('main_menu', 'ecopying');
        $builder->orderBy('created_on');
        $query = $builder->get();
        if ($query === false) {
            $error = $this->db2->error();
            log_message('error', 'Query Error: ' . print_r($error, true)); // Use print_r to convert array to string
            return false;
        }
        $result = $query->getResult();
        return $result;
    }

}
