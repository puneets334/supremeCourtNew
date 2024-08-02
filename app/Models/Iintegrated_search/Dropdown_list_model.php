<?php

namespace App\Models\Integrated_search;
use CodeIgniter\Model;

class Dropdown_list_model extends Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_high_court_list() {
        $builder = $this->db->table('efil.m_tbl_high_courts');  
        $builder->SELECT("*");
        $builder->WHERE('is_active', TRUE);
        $builder->orderBy("hc_name", "ASC");
        $query = $builder->get();
        return $query->getResultArray();
    }
}

?>
