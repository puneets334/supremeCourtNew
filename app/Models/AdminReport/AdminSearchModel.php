<?php

namespace App\Models\AdminReport;
use CodeIgniter\Model;

class AdminSearchModel extends Model {
    function __construct() {
        parent::__construct();
        //$this->readOnlyDb =  $this->load->database('readOnlyDb', TRUE);
    }
    public function get_list_doc_fromDate_toDate($params=array())
    {
        $output = false;
        if (isset($params['from_date']) && !empty($params['from_date']) && isset($params['to_date']) && !empty($params['to_date']) && isset($params['sc_case_type']) && !empty($params['sc_case_type']))
        {
            $sql = "select distinct ten.efiling_no,tcd.sc_diary_num,tcd.sc_diary_year,date(tens.deactivated_on) diarized_on,ct.skey as casetype,'".DOCUMENT_CASETYPE_URL."'||tup.file_path as path,tup.file_path as ducs_path from efil.tbl_efiling_nums ten
      inner join efil.tbl_efiling_num_status tens 
        on ten.registration_id=tens.registration_id and tens.stage_id=8 and cast(tens.deactivated_on as date) between '".$params['from_date']."' and '".$params['to_date']."'
        inner join efil.tbl_case_details tcd on ten.registration_id=tcd.registration_id 
        inner join efil.tbl_uploaded_pdfs tup on ten.registration_id=tup.registration_id and tup.is_active=true
        inner join icmis.casetype ct on tcd.sc_case_type_id=ct.casecode 
        where tcd.sc_diary_num is not null and tcd.sc_case_type_id in (".implode(",",$params['sc_case_type']).") order by ten.efiling_no";
            $query = $this->db->query($sql);
            if (count($query->getResult()) >= 1) {
                $result = $query->getResultArray();
                return $result;
            } else {
                return FALSE;
            }


        }
    }
}



