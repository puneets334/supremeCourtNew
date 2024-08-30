<?php
// if ( ! defined('BASEPATH')) exit('No direct script access allowed');

namespace App\Models\PhysicalHearing;

use CodeIgniter\Model;
use Config\Database;
use Config\Services;

class ConsentVCModel extends Model
{

    protected $DBGroup = 'default';
    protected $sci_cmis_final;
    protected $physical_hearing;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $db = \Config\Database::connect();
        $this->sci_cmis_final = Database::connect('sci_cmis_final');
        $this->physical_hearing = Database::connect('physical_hearing');
    }

    function save($table=null, $data=null):bool
    {
        // $physical_hearing_db = $this->load->database('physical_hearing', TRUE);
        if($this->physical_hearing->insert('physical_hearing'.$table, $data))
            return 1;
        else
            return 0;
    }

    function update($table=null, $data=null, $condition_array=null):bool
    {
        // $physical_hearing_db = $this->load->database('physical_hearing', TRUE);
        //$physical_hearing_db->where($condition_array)->update($table, $data);
        $this->physical_hearing->where($condition_array)->update('physical_hearing'.$table, $data);
        if($this->physical_hearing->where($condition_array)->update('physical_hearing'.$table, $data))
            return 1;
        else
            return 0;
    }

    function get_master($table, $condition)
    {
        // $physical_hearing_db = $this->load->database('physical_hearing', TRUE);
        $query = $this->physical_hearing->get_where($table, $condition);
        return $query->result_array();
    }

    function dbInsert($data,$tablename)
    {
        $output = false;
        // $physical_hearing_db = $this->load->database('physical_hearing', TRUE);
        if(isset($data) && !empty($data) && isset($tablename) && !empty($tablename)){
            $this->physical_hearing->insert($tablename, $data);
            $output =  $this->physical_hearing->insertId();
        }
        return $output;
    }

    function InsertLog($tableFrom,$TableTo,$diary_no,$next_dt,$roster_id, $court_no,$advocate_id)
    {
        // $physical_hearing_db = $this->load->database('physical_hearing', TRUE);
        $sql = "insert into physical_hearing.physical_hearing_advocate_vc_consent_log (diary_no, next_dt, roster_id,  updated_on, is_deleted, updated_by, updated_from_ip, is_fixed, mainhead, consent, advocate_id, created_at, court_no, consent_for_diary_nos, case_count) (select diary_no, next_dt, roster_id,  updated_on, is_deleted, updated_by, updated_from_ip, is_fixed, mainhead, consent, advocate_id, created_at, court_no, consent_for_diary_nos, case_count from physical_hearing_advocate_vc_consent where diary_no=? and next_dt=? and roster_id=? and court_no=? and advocate_id=?)";
        $this->physical_hearing->query($sql, array($diary_no,$next_dt,$roster_id, $court_no, $advocate_id));
        // echo $this->physical_hearing->getLastQuery(); exit();
        $insert_id = $this->physical_hearing->insertID();
        // pr($insert_id);
        return $insert_id;
    }

    function getCasesForConsent($aor_id)
    {
        $sql="SELECT phcr.id,phcr.diary_no,m.reg_no_display,m.pet_name,m.res_name,phcr.consent,case when phcr.consent='N' then true else false end as if_changeable
            FROM public.physical_hearing_consent_required phcr
            inner join public.advocate a on phcr.diary_no=a.diary_no
            inner join public.main m on phcr.diary_no=m.diary_no
            where phcr.is_deleted='f' and a.advocate_id=?;";
        $query = $this->sci_cmis_final->query($sql, array($aor_id));
        // echo $this->physical_hearing->getLastQuery(); exit();
        return $query->getResultArray();
    }

    function get_advocate_last_updated_consent($diary_no,$next_dt,$roster_id,$advocate_id, $court_no)
    {
        // $physical_hearing_db = $this->load->database('physical_hearing', TRUE);
        $sql="SELECT diary_no,next_dt, roster_id, updated_on, consent, advocate_id,court_no,'A' as source
            FROM physical_hearing.physical_hearing_advocate_vc_consent phac
            where phac.is_deleted='f' and phac.diary_no=? and phac.next_dt=? and phac.roster_id=? and advocate_id=? and court_no=?";
        $query = $this->physical_hearing->query($sql, array($diary_no,$next_dt,$roster_id,$advocate_id, $court_no));
        // echo $this->physical_hearing->getLastQuery(); exit();
        return $query->getResultArray();
    }

    function getCaseDetailsByid($id){
        $sql="SELECT phcr.id,phcr.diary_no,phcr.conn_key,phcr.consent,
            case when phcr.consent='N' then true else false end as if_changeable
            FROM public.physical_hearing_consent_required phcr         
            where phcr.is_deleted=? and phcr.id=?";
        $query = $this->sci_cmis_final->query($sql, array('f',$id));
        // echo $this->physical_hearing->getLastQuery(); exit();
        return $query->getResultArray();
    }

    function getAORConsentDetails($diary_no,$next_dt,$roster_id,$advocateId, $court_no){
        // $physical_hearing_db = $this->load->database('physical_hearing', TRUE);
        // $this->physical_hearing->select('diary_no, next_dt, roster_id, updated_on, is_deleted, updated_by, updated_from_ip,  mainhead, consent, advocate_id, created_at, court_no');
        // $this->physical_hearing->from('physical_hearing_advocate_vc_consent');
        // $this->physical_hearing->where('diary_no',$diary_no);
        // $this->physical_hearing->where('next_dt',$next_dt);
        // $this->physical_hearing->where('roster_id',$roster_id);
        // $this->physical_hearing->where('advocate_id',$advocateId);
        // $this->physical_hearing->where('court_no',$court_no);
        // $query=$this->physical_hearing->get();
        $sql = "SELECT 
          diary_no, 
          next_dt, 
          roster_id, 
          updated_on, 
          is_deleted, 
          updated_by, 
          updated_from_ip, 
          mainhead, 
          consent, 
          advocate_id, 
          created_at, 
          court_no 
        FROM 
          physical_hearing.physical_hearing_advocate_vc_consent AS phavc 
        WHERE 
          cast(phavc.diary_no as BIGINT) = $diary_no 
          AND phavc.next_dt = DATE '".$next_dt."' 
          AND phavc.roster_id = $roster_id 
          AND phavc.advocate_id = $advocateId 
          AND phavc.court_no = $court_no;
        ";
        $query = $this->physical_hearing->query($sql);
        // echo $this->physical_hearing->getLastQuery(); exit();
        return $query->getResultArray();
    }

    function getAdvocateVCConsentSummary($advocate_id, $next_dt, $court_no=null){
        $next_dt=str_replace(array('\''), '',  (implode($next_dt)));
        // $physical_hearing_db = $this->load->database('physical_hearing', TRUE);
        // $sql = "select sum(case_count) as vc_count
        //     from physical_hearing.physical_hearing_advocate_vc_consent
        //     where next_dt=? and court_no = ? and advocate_id=? 
        //     and is_deleted='f' and consent='V'";
        $sql = "select sum(case_count) as vc_count from physical_hearing.physical_hearing_advocate_vc_consent where next_dt=$next_dt and court_no = $court_no and advocate_id=$advocate_id and is_deleted='f' and consent='V'";
        $query = $this->physical_hearing->query($sql, array($next_dt,$court_no,$advocate_id));
        // echo $this->physical_hearing->getLastQuery();
        return $query->getResultArray();
    }

    function getTentativeAttendeeListForMail($list_no,$list_year,$list_date=null,$daily_list_matters)
    {
        // $physical_hearing_db = $this->load->database('physical_hearing', TRUE);
        $this->physical_hearing->select('.ad.id,ad.next_dt,ad.court_no,ad.diary_no, ad.case_number,ad.list_number,ad.list_year, ref_attendee_type_id,rat.description,rat.is_seat_allocated,ad.name,ad.email_id, ad.mobile, ad.created_on,ad.created_by_advocate_id,ad.secure_gate_visit_id,ad.secure_gate_visitor_passes');
        $this->physical_hearing->from('attendee_details ad');
        $this->physical_hearing->JOIN('ref_attendee_type rat', 'ad.ref_attendee_type_id = rat.id', 'left');
        $this->physical_hearing->where('ad.list_number',$list_no);
        $this->physical_hearing->where('ad.list_year',$list_year);
        $this->physical_hearing->where('ad.display','Y');
        # $this->physical_hearing->group_by("mobile,email_id,court_no,list_number,list_year");
        $this->physical_hearing->order_by("ad.court_no,diary_no");
        if(!empty($list_date))
            $this->physical_hearing->where('ad.next_dt',$list_date);
        $this->physical_hearing->where_in('ad.diary_no', $daily_list_matters);
        $query=$this->physical_hearing->get();
        // echo $this->physical_hearing->last_query(); exit();
        return $query->getResultArray();
    }

    function copy_attendee($diary_no, $bar_id, $new_list_no, $new_list_yr, $new_court_no){
        $sql = "insert into physical_hearing.attendee_details(diary_no, case_number, list_number, list_year, ref_attendee_type_id, name, email_id, mobile, display, created_by_advocate_id, court_no) 
    (select * from(
    select ad.diary_no,  ad.case_number, $new_list_no, $new_list_yr, ad.ref_attendee_type_id,ad.name, ad.email_id,
    ad.mobile, 'Y' as display, ad.created_by_advocate_id, $new_court_no
    from physical_hearing.attendee_details ad join 
    (SELECT list_year, list_number, next_dt, created_by_advocate_id, diary_no
    FROM physical_hearing.attendee_details
    where diary_no = $diary_no and created_by_advocate_id=$bar_id and display='Y'
    AND next_dt<='".date('Y-m-d')."'
    order by list_year desc, list_number desc, next_dt desc limit 1)last_list on ad.list_year=last_list.list_year and 
    ad.list_number=last_list.list_number and ad.created_by_advocate_id=last_list.created_by_advocate_id 
    and ad.diary_no=last_list.diary_no
    where ad.diary_no = $diary_no and ad.created_by_advocate_id=$bar_id and ad.display='Y')attendee_data)";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getAorCode($advocate_id)
    {
        $this->db->from('bar b');
        $this->db->where('bar_id',$advocate_id);
        $this->db->where('if_aor','Y');
        $this->db->where('if_sen','N');
        $this->db->where('isdead','N');
        $query=$this->db->get();
        return $query->result_array();
    }

    function getFirstNMDWorkingDayOfWeek()
    {
        $sql="select working_date from sc_working_days where is_nmd=1 and is_holiday=0 and display='Y' and
              working_date>=(SELECT case when DAYOFWEEK(curdate())<=4 then DATE_ADD(CURDATE(), INTERVAL - WEEKDAY(CURDATE()) DAY) 
              else date(curdate() - interval weekday(curdate()) day + interval 1 week) end) order by working_date asc limit 1";
        $query = $this->db->query($sql);
       // echo $this->db->last_query();//exit(0);
        return $query->result_array();
    }

    function getNextMDWorkingDayOfWeek($show_next_misc_date_cases=null,$isListingWithinSummerVacation=null) {
        // $icmis_db = $this->load->database('icmis', TRUE);
        // $sci_cmis_final = \Config\Database::connect('secondary');
        if(!empty($show_next_misc_date_cases))
            $condition=' working_date > CURRENT_DATE ';
        else
            $condition=' working_date >= CURRENT_DATE ';
        // TO DO FOR VACATION LISTING DATE
        if(!empty($isListingWithinSummerVacation))
            $condition1=" 1=1 and holiday_description like '%SUMMER VACATION%' ";
        else
            $condition1=" is_nmd=0 and is_holiday=0 ";
        /*$sql="select working_date from sc_working_days where is_nmd=0 and is_holiday=0 and display='Y' and working_date>=(SELECT case when DAYOFWEEK(curdate())<=5 then DATE_ADD(CURDATE(), INTERVAL - WEEKDAY(CURDATE()) DAY) else date(curdate() - interval weekday(curdate()) day + interval 1 week) end) AND  working_date >= date(now()) order by working_date asc limit 1";*/
        $sql="select working_date from master.sc_working_days where $condition1 and display='Y' and $condition order by working_date asc limit 1";
        $query = $this->sci_cmis_final->query($sql);
        // echo $this->sci_cmis_final->getLastQuery(); exit(0);
        return $query->getResultArray();
    }

    function available_court_list($listing_days)
    {
        // $sci_cmis_final = \Config\Database::connect('secondary');
		$listing_days=implode(',',$listing_days);
        // pr($listing_days);
        $sql="select  distinct case when courtno>=60 then courtno-60  when courtno>=30 then courtno-30 else courtno end as court_no
            from public.heardt h
            left join public.cl_printed p on p.next_dt = h.next_dt AND p.m_f = h.mainhead AND p.part = h.clno AND p.roster_id = h.roster_id AND p.display = 'Y'
            inner join master.roster r on h.roster_id=r.id and r.display='Y'
            inner join master.roster_bench rb on r.bench_id=rb.id
            inner join master.master_bench mb on rb.bench_id=mb.id
            inner join public.advocate a on cast(h.diary_no as BIGINT) = cast(a.diary_no as BIGINT) and a.display='Y'
            where p.id is not null and h.next_dt IN (DATE '".$listing_days."') order by 1";
        $query = $this->sci_cmis_final->query($sql);
        // echo $this->sci_cmis_final->getLastQuery(); exit(0);
        return $query->getResultArray();
    }

    function freezed_court_list($listing_days)
    {
        // $sci_cmis_final = \Config\Database::connect('secondary');
        $listing_days=implode(',',$listing_days);
        $sql="select  distinct case when courtno>=60 then courtno-60 when courtno>=30 then courtno-30 else courtno end as court_no
            from public.heardt h 
            left join public.cl_printed p on p.next_dt = h.next_dt AND p.m_f = h.mainhead AND p.part = h.clno AND p.roster_id = h.roster_id AND p.display = 'Y'
            inner join master.roster r on h.roster_id=r.id and r.display='Y' 
            inner join master.roster_bench rb on r.bench_id=rb.id 
            inner join master.master_bench mb on rb.bench_id=mb.id
            inner join public.advocate a on cast(h.diary_no as BIGINT) = cast(a.diary_no as BIGINT) and a.display='Y'
            where p.id is not null and h.next_dt in (DATE '".$listing_days."') order by 1";
        $query = $this->sci_cmis_final->query($sql);
        // echo $this->sci_cmis_final->getLastQuery();exit(0);
        return $query->getResultArray();
    }

    function getListedAdvocateMatters($advocateId,$listingDate,$court=null,$requestFor=null){
        $listing_date_condition="";
        if(empty($requestFor))
           $listing_date_condition=" and h.next_dt IN (DATE '". implode(',',$listingDate)."')";
        $where_condition=(!empty($court))?'courtno IN ('.$court.')':'1=1';
        // pr($listing_date_condition);
//         $sql="select next_dt, (case when courtno>=60 then courtno-60 when courtno>=30 then courtno-30 else courtno end) as court_no_display, count(1) as total_cases, courtno
// from(
// select h.*,mb.board_type_mb,r.courtno 
// from 
// (select 
// h.diary_no, m.conn_key,CASE
//                   WHEN ( m.diary_no = m.conn_key
//                           OR m.conn_key = ''
//                           OR m.conn_key IS NULL
//                           OR m.conn_key = '0' ) THEN m.diary_no
//                   ELSE m.conn_key
//                 END as main_case_diary_no,case when (m.diary_no = m.conn_key OR m.conn_key = '' OR m.conn_key IS NULL OR m.conn_key = '0') then 'M' else 'C' end as main_connected,  h.next_dt, h.mainhead, h.brd_slno, h.clno, h.roster_id, h.judges, h.main_supp_flag, m.reg_no_display  ,h.board_type
// ,m.active_casetype_id,Concat(Ifnull(m.reg_no_display, ''), ' @ ', Concat(
//                 Left(m.diary_no, Length(m.diary_no) - 4), '/',
//                 Substring(m.diary_no, -4))) AS
//                 case_no,
//                 Concat(m.pet_name, ' Vs. ', m.res_name)
//                 AS cause_title from main m 
// inner join heardt h on m.diary_no = h.diary_no 
// where 
// (h.next_dt >=curdate() $listing_date_condition) and h.main_supp_flag in (1,2) 
// union 
// select 
//  h.diary_no, m.conn_key,CASE
//                   WHEN ( m.diary_no = m.conn_key
//                           OR m.conn_key = ''
//                           OR m.conn_key IS NULL
//                           OR m.conn_key = '0' ) THEN m.diary_no
//                   ELSE m.conn_key
//                 END as main_case_diary_no,case when (m.diary_no = m.conn_key OR m.conn_key = '' OR m.conn_key IS NULL OR m.conn_key = '0') then 'M' else 'C' end as main_connected, 
// h.next_dt, h.mainhead, h.brd_slno, h.clno, h.roster_id, h.judges, h.main_supp_flag, m.reg_no_display ,h.board_type
// , m.active_casetype_id,Concat(Ifnull(m.reg_no_display, ''), ' @ ', Concat(
//                 Left(m.diary_no, Length(m.diary_no) - 4), '/',
//                 Substring(m.diary_no, -4))) AS
//                 case_no,
//                 Concat(m.pet_name, ' Vs. ', m.res_name)
//                 AS cause_title from main m 
// inner join last_heardt h on m.diary_no = h.diary_no 
// where (h.next_dt >=curdate() $listing_date_condition)
// and h.main_supp_flag in (1,2) 
// and (h.bench_flag = '' or h.bench_flag is null) 
// ) h
// left join cl_printed p on p.next_dt = h.next_dt AND p.m_f = h.mainhead AND p.part = h.clno AND p.roster_id = h.roster_id AND p.display = 'Y'
//  inner join roster r on h.roster_id=r.id and r.display='Y' 
//  inner join roster_bench rb on r.bench_id=rb.id 
//  inner join master_bench mb on rb.bench_id=mb.id inner join advocate a on h.diary_no=a.diary_no and a.display='Y'
// where p.id is not null and a.advocate_id=? and $where_condition
// group by diary_no, roster_id 
// )n1
// group by next_dt, court_no_display order by next_dt, court_no_display;";
//         $condition=(!empty($court))?array($advocateId, $court,($court+30),($court+60)):array($advocateId);
//         $query = $this->sci_cmis_final->query($sql,$condition);
//         echo $this->sci_cmis_final->getLastQuery(); exit();
        $sql = "SELECT 
            next_dt, 
            CASE WHEN courtno >= 60 THEN courtno - 60 WHEN courtno >= 30 THEN courtno - 30 ELSE courtno END AS court_no_display, 
            COUNT(*) AS total_cases, 
            courtno 
            FROM 
            (
                SELECT 
                h.next_dt, 
                r.courtno 
                FROM 
                (
                    SELECT 
                    h.diary_no, 
                    m.conn_key, 
                    CASE WHEN m.diary_no = m.conn_key 
                    OR m.conn_key = '' 
                    OR m.conn_key IS NULL 
                    OR m.conn_key = '0' THEN CAST(m.diary_no as BIGINT) ELSE CAST(m.conn_key AS bigint) END AS main_case_diary_no, 
                    CASE WHEN m.diary_no = m.conn_key 
                    OR m.conn_key = '' 
                    OR m.conn_key IS NULL 
                    OR m.conn_key = '0' THEN 'M' ELSE 'C' END AS main_connected, 
                    h.next_dt, 
                    h.mainhead, 
                    h.brd_slno, 
                    h.clno, 
                    h.roster_id, 
                    h.judges, 
                    h.main_supp_flag, 
                    m.reg_no_display, 
                    CAST(h.board_type AS text) AS board_type, 
                    m.active_casetype_id, 
                    CONCAT(
                        COALESCE(m.reg_no_display, ''), 
                        ' @ ', 
                        CONCAT(
                        LEFT(
                            m.diary_no :: text, 
                            LENGTH(m.diary_no :: text) -4
                        ), 
                        '/', 
                        SUBSTRING(
                            m.diary_no :: text 
                            FROM 
                            LENGTH(m.diary_no :: text) -3 FOR 4
                        )
                        )
                    ) AS case_no, 
                    CONCAT(m.pet_name, ' Vs. ', m.res_name) AS cause_title 
                    FROM 
                    public.main m 
                    INNER JOIN public.heardt h ON m.diary_no = h.diary_no 
                    WHERE h.next_dt >= CURRENT_DATE $listing_date_condition 
                    AND h.main_supp_flag IN (1, 2) 
                    UNION 
                    SELECT 
                    cast(h.diary_no as TEXT), 
                    m.conn_key, 
                    CASE WHEN cast(m.diary_no as BIGINT) = CAST(m.conn_key AS bigint) 
                    OR m.conn_key = '' 
                    OR m.conn_key IS NULL 
                    OR m.conn_key = '0' THEN cast(m.diary_no as BIGINT) ELSE CAST(m.conn_key AS bigint) END AS main_case_diary_no, 
                    CASE WHEN cast(m.diary_no as BIGINT) = CAST(m.conn_key AS bigint) 
                    OR m.conn_key = '' 
                    OR m.conn_key IS NULL 
                    OR m.conn_key = '0' THEN 'M' ELSE 'C' END AS main_connected, 
                    h.next_dt, 
                    h.mainhead, 
                    h.brd_slno, 
                    h.clno, 
                    h.roster_id, 
                    h.judges, 
                    h.main_supp_flag, 
                    m.reg_no_display, 
                    CAST(h.board_type AS text) AS board_type, 
                    m.active_casetype_id, 
                    CONCAT(
                        COALESCE(m.reg_no_display, ''), 
                        ' @ ', 
                        CONCAT(
                        LEFT(
                            m.diary_no :: text, 
                            LENGTH(m.diary_no :: text) -4
                        ), 
                        '/', 
                        SUBSTRING(
                            m.diary_no :: text 
                            FROM 
                            LENGTH(m.diary_no :: text) -3 FOR 4
                        )
                        )
                    ) AS case_no, 
                    CONCAT(m.pet_name, ' Vs. ', m.res_name) AS cause_title 
                    FROM 
                    public.main m 
                    INNER JOIN public.last_heardt h ON cast(m.diary_no as BIGINT) = cast(h.diary_no as BIGINT) 
                    WHERE h.next_dt >= CURRENT_DATE $listing_date_condition 
                    AND h.main_supp_flag IN (1, 2) 
                    AND (
                        h.bench_flag = '' 
                        OR h.bench_flag IS NULL
                    )
                ) h 
                LEFT JOIN public.cl_printed p ON p.next_dt = h.next_dt 
                AND p.m_f = h.mainhead 
                AND p.part = h.clno 
                AND p.roster_id = h.roster_id 
                AND p.display = 'Y' 
                INNER JOIN master.roster r ON h.roster_id = r.id 
                AND r.display = 'Y' 
                INNER JOIN master.roster_bench rb ON r.bench_id = rb.id 
                INNER JOIN master.master_bench mb ON rb.bench_id = mb.id 
                INNER JOIN public.advocate a ON cast(h.diary_no as BIGINT) = cast(a.diary_no as BIGINT) 
                AND a.display = 'Y' 
                WHERE 
                p.id IS NOT NULL 
                AND a.advocate_id = $advocateId
                AND $where_condition
            ) n1 
            GROUP BY 
            next_dt, 
            court_no_display, 
            courtno 
            ORDER BY 
            next_dt, 
            court_no_display, 
            courtno;";
        $condition=(!empty($court))?array($advocateId, $court,($court+30),($court+60)):array($advocateId);
        $query = $this->sci_cmis_final->query($sql,$condition);
        // echo $this->sci_cmis_final->getLastQuery(); exit();
        return $query->getResultArray();

    }

    function getFutureListedMatters($advocateId,$listingDate,$court=null){
        $listingDate=implode(',',$listingDate);
        $where_condition=(!empty($court))?'courtno IN ('.$court.')':'1=1';
        // pr($where_condition);
//         $sql="select distinct main_case_diary_no as diary_no, group_concat(concat(case_no,' (',CAST(main_connected AS CHAR CHARACTER SET utf8) ), ')') as case_no,
// cause_title,n1.courtno as court_no,n1.brd_slno as item_no, count(1) as case_count,n1.next_dt,n1.roster_id, n1.main_connected,n1.reg_no_display as main_case_reg_no, group_concat(n1.diary_no) as consent_diaries,
// (case when courtno>=60 then courtno-60 when courtno>=30 then courtno-30 else courtno end) as court_no_display
// from(
// select h.*,mb.board_type_mb,r.courtno 
// from 
// (select 
// h.diary_no, m.conn_key,CASE
//                   WHEN ( m.diary_no = m.conn_key
//                           OR m.conn_key = ''
//                           OR m.conn_key IS NULL
//                           OR m.conn_key = '0' ) THEN m.diary_no
//                   ELSE m.conn_key
//                 END as main_case_diary_no,case when (m.diary_no = m.conn_key OR m.conn_key = '' OR m.conn_key IS NULL OR m.conn_key = '0') then 'M' else 'C' end as main_connected,  h.next_dt, h.mainhead, h.brd_slno, h.clno, h.roster_id, h.judges, h.main_supp_flag, m.reg_no_display  ,h.board_type
// ,m.active_casetype_id,Concat(Ifnull(m.reg_no_display, ''), ' @ ', Concat(
//                 Left(m.diary_no, Length(m.diary_no) - 4), '/',
//                 Substring(m.diary_no, -4))) AS
//                 case_no,
//                 Concat(m.pet_name, ' Vs. ', m.res_name)
//                 AS cause_title from main m 
// inner join heardt h on m.diary_no = h.diary_no 
// where 
// (h.next_dt >=curdate() and h.next_dt in ($listingDate)) and h.main_supp_flag in (1,2) 
// union 
// select 
//  h.diary_no, m.conn_key,CASE
//                   WHEN ( m.diary_no = m.conn_key
//                           OR m.conn_key = ''
//                           OR m.conn_key IS NULL
//                           OR m.conn_key = '0' ) THEN m.diary_no
//                   ELSE m.conn_key
//                 END as main_case_diary_no,case when (m.diary_no = m.conn_key OR m.conn_key = '' OR m.conn_key IS NULL OR m.conn_key = '0') then 'M' else 'C' end as main_connected, 
// h.next_dt, h.mainhead, h.brd_slno, h.clno, h.roster_id, h.judges, h.main_supp_flag, m.reg_no_display ,h.board_type
// , m.active_casetype_id,Concat(Ifnull(m.reg_no_display, ''), ' @ ', Concat(
//                 Left(m.diary_no, Length(m.diary_no) - 4), '/',
//                 Substring(m.diary_no, -4))) AS
//                 case_no,
//                 Concat(m.pet_name, ' Vs. ', m.res_name)
//                 AS cause_title from main m 
// inner join last_heardt h on m.diary_no = h.diary_no 
// where (h.next_dt >=curdate() and h.next_dt in ($listingDate))
// and h.main_supp_flag in (1,2) 
// and (h.bench_flag = '' or h.bench_flag is null) 
// ) h
// left join cl_printed p on p.next_dt = h.next_dt AND p.m_f = h.mainhead AND p.part = h.clno AND p.roster_id = h.roster_id AND p.display = 'Y'
//  inner join roster r on h.roster_id=r.id and r.display='Y' 
//  inner join roster_bench rb on r.bench_id=rb.id 
//  inner join master_bench mb on rb.bench_id=mb.id inner join advocate a on h.diary_no=a.diary_no and a.display='Y'
// where p.id is not null and a.advocate_id=? and $where_condition
// group by diary_no, roster_id 
// )n1
// group by main_case_diary_no
//                 ";
        $sql = "SELECT 
  DISTINCT main_case_diary_no AS diary_no, 
  STRING_AGG(
    CONCAT(
      case_no, 
      ' (', 
      main_connected, 
      ')'
    ),
    ', '
  ) AS case_no, 
          cause_title, 
          n1.courtno AS court_no, 
          n1.brd_slno AS item_no, 
          COUNT(1) AS case_count, 
          n1.next_dt, 
          n1.roster_id, 
          n1.main_connected, 
          n1.reg_no_display AS main_case_reg_no, 
          STRING_AGG(n1.diary_no, ', ') AS consent_diaries, 
          (
            CASE 
              WHEN courtno >= 60 THEN courtno - 60 
              WHEN courtno >= 30 THEN courtno - 30 
              ELSE courtno 
            END
          ) AS court_no_display 
        FROM 
          (
            SELECT 
              h.*, 
              mb.board_type_mb, 
              r.courtno 
            FROM 
              (
                SELECT 
                  h.diary_no, 
                  m.conn_key, 
                  CASE 
                    WHEN (
                      m.diary_no = m.conn_key 
                      OR m.conn_key = '' 
                      OR m.conn_key IS NULL 
                      OR m.conn_key = '0'
                    ) 
                    THEN m.diary_no 
                    ELSE m.conn_key 
                  END AS main_case_diary_no, 
                  CASE 
                    WHEN (
                      m.diary_no = m.conn_key 
                      OR m.conn_key = '' 
                      OR m.conn_key IS NULL 
                      OR m.conn_key = '0'
                    ) 
                    THEN 'M' 
                    ELSE 'C' 
                  END AS main_connected, 
                  h.next_dt, 
                  h.mainhead, 
                  h.brd_slno, 
                  h.clno, 
                  h.roster_id, 
                  h.judges, 
                  h.main_supp_flag, 
                  m.reg_no_display, 
                  h.board_type, 
                  m.active_casetype_id, 
                  CONCAT(
                    COALESCE(m.reg_no_display, ''), 
                    ' @ ', 
                    CONCAT(
                      LEFT(m.diary_no, LENGTH(m.diary_no) - 4), 
                      '/', 
                      SUBSTRING(m.diary_no, -4)
                    )
                  ) AS case_no, 
                  CONCAT(m.pet_name, ' Vs. ', m.res_name) AS cause_title 
                FROM 
                  main m 
                  INNER JOIN heardt h ON m.diary_no = h.diary_no 
                WHERE 
                  (
                    h.next_dt >= CURRENT_DATE 
                    AND h.next_dt = DATE '".$listingDate."'
                  ) 
                  AND h.main_supp_flag IN (1, 2) 
                UNION 
                SELECT 
                  h.diary_no::TEXT, 
                  m.conn_key, 
                  CASE 
                    WHEN (
                      m.diary_no = m.conn_key 
                      OR m.conn_key = '' 
                      OR m.conn_key IS NULL 
                      OR m.conn_key = '0'
                    ) 
                    THEN m.diary_no 
                    ELSE m.conn_key 
                  END AS main_case_diary_no, 
                  CASE 
                    WHEN (
                      m.diary_no = m.conn_key 
                      OR m.conn_key = '' 
                      OR m.conn_key IS NULL 
                      OR m.conn_key = '0'
                    ) 
                    THEN 'M' 
                    ELSE 'C' 
                  END AS main_connected, 
                  h.next_dt, 
                  h.mainhead, 
                  h.brd_slno, 
                  h.clno, 
                  h.roster_id, 
                  h.judges, 
                  h.main_supp_flag, 
                  m.reg_no_display, 
                  h.board_type::TEXT, 
                  m.active_casetype_id, 
                  CONCAT(
                    COALESCE(m.reg_no_display, ''), 
                    ' @ ', 
                    CONCAT(
                      LEFT(m.diary_no, LENGTH(m.diary_no) - 4), 
                      '/', 
                      SUBSTRING(m.diary_no, -4)
                    )
                  ) AS case_no, 
                  CONCAT(m.pet_name, ' Vs. ', m.res_name) AS cause_title 
                FROM 
                  main m 
                  INNER JOIN last_heardt h ON cast(m.diary_no as BIGINT) = cast(h.diary_no as BIGINT) 
                WHERE 
                  (
                    h.next_dt >= CURRENT_DATE 
                    AND h.next_dt = DATE '".$listingDate."'
                  ) 
                  AND h.main_supp_flag IN (1, 2) 
                  AND (
                    h.bench_flag = '' 
                    OR h.bench_flag IS NULL
                  )
              ) h 
              LEFT JOIN cl_printed p ON p.next_dt = h.next_dt 
              AND p.m_f = h.mainhead 
              AND p.part = h.clno 
              AND p.roster_id = h.roster_id 
              AND p.display = 'Y' 
              INNER JOIN master.roster r ON h.roster_id = r.id 
              AND r.display = 'Y' 
              INNER JOIN master.roster_bench rb ON r.bench_id = rb.id 
              INNER JOIN master.master_bench mb ON rb.bench_id = mb.id 
              INNER JOIN advocate a ON cast(h.diary_no as BIGINT) = cast(a.diary_no as BIGINT) 
              AND a.display = 'Y' 
            WHERE 
              p.id IS NOT NULL 
              AND a.advocate_id =$advocateId
              AND $where_condition 
            GROUP BY 
              h.diary_no, 
              h.conn_key,
              h.main_case_diary_no,
              h.main_connected,
              h.mainhead,
              h.brd_slno,
              h.clno,
              h.roster_id,
              h.judges,
              h.main_supp_flag,
              h.reg_no_display,
              h.board_type,
              h.active_casetype_id,
              h.case_no,
              h.cause_title,
              h.next_dt,
              mb.board_type_mb, 
              r.courtno, 
              p.roster_id
          ) n1 
        GROUP BY 
          n1.main_case_diary_no, 
          n1.cause_title, 
          n1.courtno, 
          n1.brd_slno, 
          n1.next_dt, 
          n1.roster_id, 
          n1.main_connected, 
          n1.reg_no_display";
        $condition=(!empty($court))?array($advocateId, $court,($court+30),($court+60)):array($advocateId);
        $query = $this->sci_cmis_final->query($sql,$condition);
        // echo $this->sci_cmis_final->getLastQuery(); exit();
        return $query->getResultArray();
    }

}