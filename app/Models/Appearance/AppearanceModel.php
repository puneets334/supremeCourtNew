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
        $builder->select('a.diary_no, a.item_no, a.court_no, a.list_date')
            ->where('a.is_submitted', '1')
            ->where('a.is_active', '1')
            ->where('a.list_date', $list_date_ymd)
            ->where('a.court_no', $court_no)
            ->orderBy('a.item_no');
        $diaryQuery = $builder->get();
        if ($diaryQuery->getNumRows() === 0) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No Records Found']);
        }
        $records = [];
        foreach ($diaryQuery->getResultArray() as $diaryRow) {
            $diary_no = $diaryRow['diary_no'];
            $item_no = $diaryRow['item_no'];
            $mainBuilder = $this->db->table('icmis.main');
            $mainBuilder->where('diary_no', $diary_no);
            $mainQuery = $mainBuilder->get();
            $diary = $mainQuery->getRowArray();
            $pet_name = $diary['pet_name'] . ($diary['pno'] > 1 ? " AND ORS." : "");
            $res_name = $diary['res_name'] . ($diary['rno'] > 1 ? " AND ORS." : "");
            // pr($res_name);
            $advocates = [];
            $advocateBuilder = $db1->table('e_services.public.appearing_in_diary a')
                ->select('e_services.public.a.aor_code, e_services.public.a.priority, master.b.title, master.b.name')
                ->join('sci_cmis_final.master.bar b', 'sci_cmis_final.master.b.aor_code = e_services.public.a.aor_code', 'inner')
                ->where('e_services.public.a.is_submitted', '1')
                ->where('e_services.public.a.is_active', '1')
                ->where('e_services.public.a.list_date', $list_date_ymd)
                ->where('e_services.public.a.court_no', $court_no)
                ->where('e_services.public.a.diary_no', $diary_no)
                ->groupBy('e_services.public.a.aor_code')
                ->orderBy('e_services.public.a.aor_code')
                ->orderBy('e_services.public.a.priority');
            // pr($advocateBuilder->getCompiledSelect());
            $advocateQuery = $advocateBuilder->get();
            foreach ($advocateQuery->getResultArray() as $advocate) {
                $advocates[] = [
                    'added_by' => ucwords(strtolower($advocate['title'] . ' ' . $advocate['name'])),
                    'advocates' => []
                ];
                $advocateDetailBuilder = $db1->table('appearing_in_diary a')
                    ->select('*')
                    ->where('a.is_submitted', '1')
                    ->where('a.is_active', '1')
                    ->where('a.list_date', $list_date_ymd)
                    ->where('a.court_no', $court_no)
                    ->where('a.diary_no', $diary_no)
                    ->where('a.aor_code', $advocate['aor_code'])
                    ->orderBy('a.priority');
                $advocateDetailQuery = $advocateDetailBuilder->get();
                foreach ($advocateDetailQuery->getResultArray() as $advocateDetail) {
                    $advocates[count($advocates) - 1]['advocates'][] = [
                        'title' => $advocateDetail['advocate_title'],
                        'name' => $advocateDetail['advocate_name'],
                        'type' => $advocateDetail['advocate_type']
                    ];
                }
            }
            $records[] = [
                'item_no' => $item_no,
                'case_no' => $diary['reg_no_display'] ?: 'Diary No. ' . $diary_no,
                'cause_title' => $pet_name . "<br>Vs.<br>" . $res_name,
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