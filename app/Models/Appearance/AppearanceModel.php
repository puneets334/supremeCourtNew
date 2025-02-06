<?php

namespace App\Models\Appearance;
use CodeIgniter\Model;
use Config\Database;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppearanceModel extends Model {
    

    public function __construct() {
        parent::__construct();
        
    }

    public function getTotalAppearings($cause_list_from_date, $cause_list_to_date = '') {
        $db1 = Database::connect('e_services');
        $builder = $db1->table('appearing_in_diary');
        $builder->where('is_active', 1);
        $builder->where('is_submitted', 1);
        if(!empty($cause_list_to_date)){
            $builder->whereIn('list_date', [$cause_list_from_date, $cause_list_to_date]);
        } else {
            $builder->where('list_date', $cause_list_from_date);
        }
        $builder->get();
        $total = $builder->countAll();
        return $total;
    }

    public static function currentWeekLastWeekSubmissions() {
        $db1 = Database::connect('e_services');
        $days = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
        ];        
        foreach($days as $key=>$value) {
            if($key==0) {
                $current_week_date = Carbon::now()->startOfWeek()->format('Y-m-d');
                $last_week_date = Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d');
            } else {
                $current_week_date = Carbon::now()->startOfWeek()->addDay($key)->format('Y-m-d');
                $last_week_date = Carbon::now()->subWeek()->startOfWeek()->addDay($key)->format('Y-m-d');
            }
            $builder1 = $db1->table('appearing_in_diary');
            $builder1->where('is_active', 1);
            $builder1->where('is_submitted', 1);
            $builder1->where('list_date', $current_week_date);
            $builder1->get();
            $current_week_daywise_total_reords = $builder1->countAll();
            $builder2 = $db1->table('appearing_in_diary');
            $builder2->where('is_active', 1);
            $builder2->where('is_submitted', 1);
            $builder2->where('list_date', $last_week_date);
            $builder2->get();
            $last_week_daywise_total_reords = $builder2->countAll();
            $weeklySubmissions[$value] = [$current_week_daywise_total_reords,$last_week_daywise_total_reords];
        }
        return $weeklySubmissions;
    }

    public function getAdvocateDiaryDetails($list_date_ymd, $court_no) {
        $db1 = Database::connect('e_services');
        $db2 = Database::connect('sci_cmis_final');
        $builder = $db1->table('appearing_in_diary a');
        $builder->distinct();
        $builder->select('a.diary_no, a.item_no, a.court_no, a.list_date, a.aor_code')
            ->where('a.is_submitted', '1')
            ->where('a.is_active', '1')
            ->where('a.list_date', $list_date_ymd)
            ->where('a.court_no', $court_no)
            ->orderBy('a.item_no');
        $diaryQuery = $builder->get();
        if ($diaryQuery->getNumRows() === 0) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No Records Found']);
        }
        $dData = $diaryQuery->getResultArray();
        $records = [];
        foreach ($dData as $dKey => $diaryRow) {
            $diary_no = $diaryRow['diary_no'];
            $item_no = $diaryRow['item_no'];
            $mainBuilder = $this->db->table('icmis.main');
            $mainBuilder->where('diary_no', $diary_no);
            $mainQuery = $mainBuilder->get();
            $diary = $mainQuery->getRowArray();
            $advocates = [];
            if($diary['pno'] == 2) {
                $pet_name = $diary['pet_name']." AND ANR.";
            } else if($diary['pno'] > 2) {
                $pet_name = $diary['pet_name']." AND ORS.";
            } else {
                $pet_name = $diary['pet_name'];
            }
            if($diary['rno'] == 2) {
                $res_name = $diary['res_name']." AND ANR.";
            } else if($diary['rno'] > 2) {
                $res_name = $diary['res_name']." AND ORS.";
            } else {
                $res_name = $diary['res_name'];
            }
            $barBuilder = $db2->table('bar b')
                ->select('b.title, b.name')
                ->where('b.aor_code', $diaryRow['aor_code']);
            $barQuery = $barBuilder->get();
            $barRes = $barQuery->getRowArray();
            $ddData = getAdvocatesFroApearenceAPI($list_date_ymd, $court_no, $diary_no, $diaryRow['aor_code'], $dKey);
            $advocates[] = [
                'added_by' => ucwords(strtolower($barRes['title'] . ' ' . $barRes['name'])),
                'added_for' => $ddData['added_for'],
                'advocates' => $ddData['advocates'],
            ];            
            $records[] = [
                'item_no' => $item_no,
                'case_no' => $diary['reg_no_display'] ?: 'Diary No. ' . $diary_no,
                'cause_title' => $pet_name . " Vs. " . $res_name,
                'advocates' => $advocates
            ];
        }
        return $records;
	}

    public function getAdvocateAppearanceDetails($diary_no, $adv_for, $list_date_ymd, $aor_code) {
        $db1 = Database::connect('e_services');
        $builder = $db1->table('appearing_in_diary as a');
        $builder->distinct();
        $builder->select('advocate_type, advocate_title, advocate_name, priority')
            ->where('a.is_active', '1')
            ->where('a.is_submitted', '1')
            ->whereIn('a.diary_no', (array) $diary_no)
            ->where('a.list_date', date('Y-m-d', strtotime($list_date_ymd)))
            ->where('a.aor_code', $aor_code);
        if ($adv_for == 'P') {
            $builder->where('a.appearing_for', 'P');
        } else {
            $builder->whereIn('a.appearing_for', ['R', 'I', 'N']);
        }
        $builder->orderBy('priority');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getAdvocateAppearanceAORIncludeORExclude($diary_no, $adv_for, $list_date_ymd, $aor_code) {
        $db1 = Database::connect('e_services');
        $builder = $db1->table('appearing_in_diary as a');
        $builder->select('id')
            ->where('a.is_active', '1')
            ->where('a.is_submitted', '1')
            ->where('a.advocate_type', 'AOR')
            ->whereIn('a.diary_no', (array) $diary_no)
            ->where('a.list_date', date('Y-m-d', strtotime($list_date_ymd)))
            ->where('a.aor_code', $aor_code);
        if ($adv_for == 'P') {
            $builder->where('a.appearing_for', 'P');
        } else {
            $builder->whereIn('a.appearing_for', ['R', 'I', 'N']);
        }
        $builder->limit(1);
        $query = $builder->get();
        return $query->getResultArray();
    }

}