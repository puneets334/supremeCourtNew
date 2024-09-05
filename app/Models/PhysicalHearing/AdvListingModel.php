<?php
// if ( ! defined('BASEPATH')) exit('No direct script access allowed');

namespace App\Models\PhysicalHearing;

use CodeIgniter\Model;
use Config\Database;
class AdvListingModel extends Model
{
    protected $DBGroup = 'default';
    protected $sci_cmis_final;
    protected $physical_hearing;

    function __construct()
    {
        //call model constructor
        parent::__construct();
        $db = \Config\Database::connect();
        $this->sci_cmis_final = Database::connect('sci_cmis_final');
        $this->physical_hearing = Database::connect('physical_hearing');
    }

    public function list_number()
    {
        // $icmis_db = $this->load->database('icmis', TRUE);
        $query = $this->sci_cmis_final->table('hybrid_physical_hearing_consent_freeze')->where('is_active','t')->orderBy('list_year DESC, list_number DESC')->limit(1)->get();
        //echo $icmis_db->last_query();
        return $query->getRowArray();
    }

    function cases_listed_in_daily_list($current_date = null)
    {
        // $icmis_db = $this->load->database('icmis', TRUE);
        $current_date = empty($current_date) ? date("Y-m-d") : $current_date;
        $sql = "select distinct h.diary_no, h.brd_slno, r.courtno,h.next_dt
            from heardt h
            left join master.roster r on r.id=h.roster_id
            INNER JOIN cl_printed p ON p.next_dt = h.next_dt
            where r.display ='Y' and h.next_dt >= ? and p.display ='Y'";
        $query = $this->sci_cmis_final->query($sql, array($current_date));
        // echo $this->sci_cmis_final->getLastQuery(); exit();
        return $query->getResultArray();
    }

    function case_details($diary_nos)
    {
        $diary_nos=trim($diary_nos,'\'"');
        // $icmis_db = $this->load->database('icmis', TRUE);
        // $sql="select group_concat(concat(x.reg_no_display,'@',x.diary_no,'(',CAST(x.main_connected AS CHAR CHARACTER SET utf8),')') SEPARATOR ',') as consent_for_cases 
        // from
        // (select m.reg_no_display,m.diary_no,
        // case when (m.diary_no = m.conn_key OR m.conn_key = '' OR m.conn_key IS NULL OR m.conn_key = '0')
        // then 'M' else 'C' end as main_connected
        // from public.main m where diary_no in ($diary_nos)
        // and c_status='P'
        // )x";
        $sql = "SELECT 
              STRING_AGG(
                CONCAT(
                  x.reg_no_display, 
                  '@', 
                  x.diary_no, 
                  '(', 
                  x.main_connected, 
                  ')'
                ), 
                ','
              ) AS consent_for_cases 
            FROM 
              (
                SELECT 
                  m.reg_no_display, 
                  m.diary_no, 
                  CASE 
                    WHEN (
                      cast(m.diary_no as BIGINT) = cast(m.conn_key as BIGINT) 
                      OR m.conn_key = '' 
                      OR m.conn_key IS NULL 
                      OR m.conn_key = '0'
                    ) THEN 'M' 
                    ELSE 'C' 
                  END AS main_connected 
                FROM 
                  public.main m 
                WHERE 
                  diary_no IN ('".$diary_nos."') 
                  AND c_status = 'P'
              ) x";
        $query = $this->sci_cmis_final->query($sql);
        // echo $this->sci_cmis_final->getLastQuery(); exit();
        return $query->getResult();
    }

    public function adv_data()
    {
        $list = $this->list_number();
        // pr($list);
        /*$this->db->select('diary_no,court_number,item_number,case_number,name,ref_attendee_type_id,mobile,email_id,ref_attendee_type.description');
        $this->db->from('attendee_details');
        $this->db->join('ref_attendee_type', 'ref_attendee_type.id = attendee_details.ref_attendee_type_id','left');
        $this->db->where(array('list_number'=> $list['list_number'], 'list_year'=>$list['list_year'], 'created_by_advocate_id' =>$this->session->loginData['bar_id']));
        $this->db->where('attendee_details.display', 'Y');
        $query = $this->db->get();*/
        // $sql = "SELECT ad.`diary_no`,ad.`next_dt`, ad.`court_no`, `item_number`, `case_number`, `name`, `ref_attendee_type_id`, `mobile`, `email_id`, `ref_attendee_type`.`description` 
        // FROM `attendee_details` ad
        // left join physical_hearing.physical_hearing_advocate_consent pc on (pc.diary_no=ad.diary_no and pc.list_number=ad.list_number and pc.list_year=ad.list_year and  pc.is_deleted='f')
        // LEFT JOIN `ref_attendee_type` ON `ref_attendee_type`.`id` = ad.`ref_attendee_type_id` 
        // WHERE ad.`list_number` = ? AND ad.`list_year` = ? AND `created_by_advocate_id` = ? 
        // AND ad.`display` = 'Y' ";
        $sql = "SELECT 
        ad.diary_no, 
        ad.next_dt, 
        ad.court_number, 
        item_number, 
        case_number, 
        name, 
        ref_attendee_type_id, 
        mobile, 
        email_id, 
        ref_attendee_type.description 
        FROM 
        physical_hearing.attendee_details_history ad 
        left join physical_hearing.physical_hearing_advocate_consent pc on (
            pc.diary_no = ad.diary_no 
            and pc.list_number = ad.list_number 
            and pc.list_year = ad.list_year 
            and pc.is_deleted = 'f'
        ) 
        LEFT JOIN physical_hearing.ref_attendee_type ON ref_attendee_type.id = ad.ref_attendee_type_id 
        WHERE 
        ad.list_number = '".$list['list_number']."' 
        AND ad.list_year = '".$list['list_year']."' 
        AND created_by_advocate_id = '".getSessionData('login.adv_sci_bar_id')."' 
        AND ad.display = 'Y'";
        $query = $this->physical_hearing->query($sql, array($list['list_number'], $list['list_year'], getSessionData('login.adv_sci_bar_id')));
        // echo $this->physical_hearing->getLastQuery(); exit();
        return $query->getResultArray();
    }

    public function adv_data_vc($list_date)
    {

        $sql = "SELECT diary_no,consent_for_diary_nos,next_dt,court_no,roster_id,updated_on,advocate_id,consent,case_count
        FROM physical_hearing.physical_hearing_advocate_vc_consent phavc 
        where phavc.next_dt=? and is_deleted='f' and consent !='0'
        and updated_by=? ";
        $query = $this->physical_hearing->query($sql, array($list_date, getSessionData('login.adv_sci_bar_id')));
        // echo $this->physical_hearing->getLastQuery(); exit();
        return $query->getResultArray();
    }

    public function adv_data_search($srch_date)
    {
        $srchdate = date("Y-m-d", strtotime($srch_date));
        $builder = $this->db->table('attendee_details');
        $builder->select('attendee_details.id,court_no,item_number,case_number,name,ref_attendee_type_id,mobile,email_id,ref_attendee_type.description');
        $builder->join('ref_attendee_type', 'ref_attendee_type.id = attendee_details.ref_attendee_type_id','left');
        $builder->where('next_dt', $srchdate);
        $builder->where('attendee_details.display', 'Y');
        $query = $builder->get();
        //echo $this->db->last_query();
        return $query->getResultArray();
    }

}
//end of class Senior_advocate_list ..