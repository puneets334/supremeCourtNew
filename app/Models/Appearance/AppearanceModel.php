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

}