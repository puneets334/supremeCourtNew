<?php

namespace App\Models\Advocate;
use CodeIgniter\Model;
use Config\Database;
use Config\Services;

class AdvocateModel extends Model {
    protected $DBGroup = 'secondary'; 
    protected $db3;

    public function __construct()
    {
        parent::__construct();
        $this->db3 = Database::connect('tertiary'); // Connect to the 'tertiary' database
    }

    public function getListedCases($aor_code)
    {
        // Use the model's database connection
        $builder = $this->db->table('sci_cmis_final.main as m')
            ->join('sci_cmis_final.heardt as h', 'h.diary_no = m.diary_no')
            ->join('sci_cmis_final.cl_printed as c', 'c.next_dt = h.next_dt AND c.roster_id = h.roster_id AND c.part = h.clno')
            ->join('sci_cmis_final.roster as r', 'r.id = h.roster_id')
            ->join('sci_cmis_final.advocate as a', 'a.diary_no = m.diary_no')
            ->join('sci_cmis_final.bar as b', 'b.bar_id = a.advocate_id')
            ->select('m.diary_no, m.reg_no_display, m.pet_name, m.res_name, h.next_dt, h.brd_slno, h.main_supp_flag, a.pet_res, r.courtno, m.pno, m.rno')
            ->where('b.aor_code', $aor_code)
            ->where('m.c_status', 'P')
            ->where('c.display', 'Y')
            ->where('r.display', 'Y')
            ->where('a.display', 'Y')
            ->orderBy('h.next_dt')
            ->orderBy('r.courtno')
            ->orderBy('h.brd_slno')
            ->distinct();        
            $query = $builder->get();        
            if (!$query) {
                // Output the last query error
                return $this->db->error();
            }
            return $query->getResultArray();
    } 


    public function get_pending_reg_other_matters_data($aor_code) {
        // Subquery 1: Petitioner matters with other (neither Petitioner nor Respondent) status
            $subquery1 = $this->db->table('main m1')
            ->select('DISTINCT m1.diary_no, reg_no_display, pet_name, res_name, pno, rno')
            ->select('(CASE WHEN DATEDIFF(h1.next_dt, CURRENT_DATE()) BETWEEN 0 AND 60 THEN h1.next_dt ELSE "" END) AS next_date')
            ->join('heardt h1', 'm1.diary_no = h1.diary_no', 'left')
            ->join('advocate a1', 'm1.diary_no = a1.diary_no', 'left')
            ->where('a1.advocate_id', $aor_code)
            ->where('a1.display', 'Y')
            ->where('m1.c_status', 'P')
            ->where('a1.pet_res NOT IN', ['P', 'R'])
            ->where('m1.active_fil_no IS NOT NULL')
            ->where('m1.fil_no IS NOT NULL');
        // Union Query: Combine results from subquery
        $unionQuery = $this->db->table('temp')
            ->union($subquery1)
            ->orderBy('diary_no');
        // Final query to fetch results from union query
        $query = $this->db->table('(' . $unionQuery . ') temp')
            ->get();
        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function getDiaryDetails($diary_no)
    {
        $builder = $this->db->table('main')
            ->where('diary_no', $diary_no)
            ->get();
        return $builder->getRow(); // Return the first row (similar to Laravel's first())
    }

    public function getAddedAdvocatesInDiary($data)
    {
        $session = \Config\Services::session(); // Correct namespace for Services
        $builder = $this->db3->table('appearing_in_diary');        
        $builder->where('diary_no', $data['diary_no']);
        $builder->where('list_date', $data['next_dt']);
        $builder->where('is_active', '1');
        $builder->where('aor_code', getSessionData('login')['aor_code']); // Get session data
        $builder->orderBy('priority');        
        // $sql = $builder->getCompiledSelect();
        // echo $sql; die;
        $query = $builder->get();
        if ($query === false) {
            // Convert array error to string for logging
            $error = $this->db3->error();
            log_message('error', 'Query Error: ' . print_r($error, true)); // Use print_r to convert array to string
            return false;
        }
        $result = $query->getResult();
        return $result;
        //  pr($result);
    }




    public function getSubmittedAdvocatesInDiary($data)
    {

        $session = \Config\Services::session(); // Correct namespace for Services
        $builder = $this->db3->table('appearing_in_diary');        
        $builder ->where('diary_no', $data['diary_no']);
        $builder ->where('list_date', $data['next_dt']);
        $builder ->where('is_active', '1');
        $builder ->where('is_submitted', '1');
        $builder->where('aor_code', getSessionData('login')['aor_code']); // Get session data
        $builder ->orderBy('priority');
        $value = $builder->get()->getResult(); // Execute the query and fetch results

        return $value;
    }



}