<?php

namespace App\Models\Dashboard;

use CodeIgniter\Model;

class StageslistModel extends Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    // Function used to get stage wise list of efiling nums from dashboard 

    //     public function get_efilied_nums_stage_wise_list($stage_ids, $created_by,$notIn=0) {

    //         $this->db->SELECT(array('mtds.user_stage_name','en.efiling_for_type_id', 'en.efiling_for_id', 'en.ref_m_efiled_type_id',
    //             'en.efiling_no', 'en.efiling_year', 'en.registration_id', 'en.allocated_on', 
    //             'et.efiling_type',
    //             'cs.stage_id', 'cs.activated_on', 'en.sub_created_by',
    //             'new_case_cd.cause_title ecase_cause_title', 'new_case_cd.sc_diary_num', 'new_case_cd.sc_diary_year', 'new_case_cd.sc_diary_date', 'new_case_cd.sc_display_num', 'new_case_cd.sc_reg_date',
    //             'sc_case.diary_no', 'sc_case.diary_year', 'sc_case.reg_no_display', 'sc_case.cause_title',
    //             'ec.pet_name','ec.res_name','ec.orgid','ec.resorgid','ec.ref_m_efiling_nums_registration_id caveat_reg',
    //             'users.first_name', 'users.last_name',
    //             'allocated_users.first_name as allocated_user_first_name', 'allocated_users.last_name as allocated_user_last_name','allocated_users.id as allocayted_to_user_id',
    //             'tea.allocated_on as allocated_to_da_on',
    //             'case when en.ref_m_efiled_type_id in(1,3,5) and not(string_to_array(breadcrumb_status, \',\') && array[\'2\',\'3\']) then \'Basic Detail\' 
    //             else case when en.ref_m_efiled_type_id in(1,5) and not(string_to_array(breadcrumb_status, \',\') && array[\'6\']) then \'Act Section\' 
    // else case when en.ref_m_efiled_type_id in(1,5) and not(string_to_array(breadcrumb_status, \',\') && array[\'7\']) then \'Earlier Court\' 
    // else case when en.ref_m_efiled_type_id in(1,5) and not(string_to_array(breadcrumb_status, \',\') && array[\'9\']) then \'Index\' 
    // else case when en.ref_m_efiled_type_id in(1,5) and not(string_to_array(breadcrumb_status, \',\') && array[\'10\']) then \'Payment\'
    // else case when en.ref_m_efiled_type_id in(2,4) and not(string_to_array(breadcrumb_status, \',\') && array[\'2\']) then \'Appearing For\' 
    // else case when en.ref_m_efiled_type_id in(2,4) and not(string_to_array(breadcrumb_status, \',\') && array[\'5\']) then \'Index\' 
    // else case when en.ref_m_efiled_type_id in(2,4) and not(string_to_array(breadcrumb_status, \',\') && array[\'6\']) then \'Court Fee\' 
    // else case when en.ref_m_efiled_type_id in(2) and not(string_to_array(breadcrumb_status, \',\') && array[\'7\']) then \'Share Document\' 
    // else case when ((en.ref_m_efiled_type_id in(1,5) and not(string_to_array(breadcrumb_status, \',\') && array[\'13\'])) or (en.ref_m_efiled_type_id in(2,4) and not(string_to_array(breadcrumb_status, \',\') && array[\'9\']))) then \'Final Submit\' 

    // end end end end end end end end end end as pendingStage,ec.caveat_num,ec.caveat_year', '(select concat(department_name,\' <br>(\', ministry_name, \')\') from efil.department_filings df join efil.m_departments md on md.id = df.ref_department_id where registration_id=en.registration_id) as dept_file',
    //             '(select \'Entered by Clerk\' from efil.clerk_filings where registration_id=en.registration_id) as clerk_file'
    //             ));
    //         $this->db->FROM('efil.tbl_efiling_nums as en');
    //         $this->db->JOIN('efil.tbl_efiling_num_status as cs', 'en.registration_id = cs.registration_id');
    //         $this->db->JOIN('public.tbl_efiling_caveat as ec', 'en.registration_id = ec.ref_m_efiling_nums_registration_id','left');
    //         $this->db->JOIN('efil.m_tbl_efiling_type as et', 'en.ref_m_efiled_type_id=et.id');
    //         $this->db->JOIN('efil.tbl_case_details as new_case_cd', 'en.registration_id = new_case_cd.registration_id', 'left');
    //         $this->db->JOIN('efil.tbl_misc_docs_ia as mdia', 'en.registration_id = mdia.registration_id', 'left');
    //         $this->db->JOIN('efil.tbl_sci_cases as sc_case', 'sc_case.diary_no=mdia.diary_no AND sc_case.diary_year = mdia.diary_year', 'left');        
    //         $this->db->JOIN('efil.tbl_users users', 'en.created_by=users.id', 'LEFT');
    //         $this->db->JOIN('efil.m_tbl_dashboard_stages mtds', 'cs.stage_id = mtds.stage_id ','LEFT');
    //         //$this->db->JOIN('efil.tbl_efiling_allocation tea', 'en.registration_id = tea.registration_id', 'left');
    //         // Adding the FOLLWING conditional logic for remove the repetitive entries coming for new cases : ADDED on 04052024 by kbp
    //         $this->db->JOIN('(SELECT * FROM efil.tbl_efiling_allocation tea ORDER BY tea.allocated_on DESC LIMIT 1) tea', 'en.registration_id = tea.registration_id', 'left');
    //         $this->db->JOIN('efil.tbl_users allocated_users', 'tea.admin_id=allocated_users.id', 'LEFT');
    //         //$this->db->JOIN('m_tbl_departments dp', 'en.sub_created_by=dp.dep_user_id', 'LEFT');
    //         //$this->db->JOIN('m_tbl_clerks cl', 'en.sub_created_by=cl.clerk_id', 'LEFT');
    //         $this->db->WHERE('cs.is_active', 'TRUE');

    //         $this->db->WHERE('en.is_active', 'TRUE');
    //         $this->db->WHERE('en.is_deleted', 'FALSE');
    //         $this->db->WHERE('en.ref_m_efiled_type_id  in (1,2,4,8,9,12,13)');
    //         if($notIn==0){
    //             $this->db->WHERE_IN('cs.stage_id', $stage_ids);
    //         }
    //         else{
    //             $this->db->WHERE_NOT_IN('cs.stage_id', $stage_ids);
    //         }
    //         $this->db->group_start();
    //         if ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
    //             $this->db->WHERE("en.sub_created_by", $created_by);
    //         } else {
    //             $this->db->WHERE('en.created_by', $created_by);
    //         }
    //         if($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE && !in_array(4, $stage_ids)){
    //             $this->db->or_WHERE("en.registration_id in (select registration_id from efil.department_filings where aor_code::varchar=(select aor_code from efil.tbl_users where id='$created_by'))");
    //             $this->db->or_WHERE("en.registration_id in (select registration_id from efil.clerk_filings where aor_code::varchar=(select aor_code from efil.tbl_users where id='$created_by'))");
    //         }
    //         if($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT && !in_array(4, $stage_ids)){
    //             $this->db->or_WHERE("en.registration_id in (select registration_id from efil.department_filings where ref_department_id=".$_SESSION['login']['department_id'].")");
    //         }
    //         if($_SESSION['login']['ref_m_usertype_id'] == USER_CLERK && !in_array(4, $stage_ids)){
    //             //$this->db->or_where_in('en.created_by', [1597]);
    //             $this->db->or_where_in('en.created_by', [1597]);
    //         }
    //         $this->db->group_end();
    //         // Adding the conditional logic for remove the repetitive entries coming for new cases on 04052024 by kbp
    //         #$this->db->where('(CASE WHEN "en"."ref_m_efiled_type_id" = 1 THEN "allocated_users"."id" IS NOT NULL ELSE 1 = 1 END)', null, false);
    //         $this->db->ORDER_BY('cs.activated_on', 'DESC');
    //         //$this->db->limit(20);

    //         $query = $this->db->get();
    //         //echo $this->db->last_query(); exit;
    //         if ($query->num_rows() >= 1) {
    //             return $query->result();
    //         } else {
    //             return false;
    //         }
    //     }

    public function get_efilied_nums_stage_wise_list($stageIds, $createdBy, $notIn = 0 , $limit = null, $offset= null)
    {
        $builder = $this->db->table('efil.tbl_efiling_nums as en');

        $builder->select([
            'mtds.user_stage_name', 'en.efiling_for_type_id', 'en.efiling_for_id', 'en.ref_m_efiled_type_id',
            'en.efiling_no', 'en.efiling_year', 'en.registration_id', 'en.allocated_on',
            'et.efiling_type', 'cs.stage_id', 'cs.activated_on', 'en.sub_created_by',
            'new_case_cd.cause_title as ecase_cause_title', 'new_case_cd.sc_diary_num', 'new_case_cd.sc_diary_year',
            'new_case_cd.sc_diary_date', 'new_case_cd.sc_display_num', 'new_case_cd.sc_reg_date',
            'sc_case.diary_no', 'sc_case.diary_year', 'sc_case.reg_no_display', 'sc_case.cause_title',
            'ec.pet_name', 'ec.res_name', 'ec.orgid', 'ec.resorgid', 'ec.ref_m_efiling_nums_registration_id as caveat_reg',
            'users.first_name', 'users.last_name',
            'allocated_users.first_name as allocated_user_first_name', 'allocated_users.last_name as allocated_user_last_name',
            'allocated_users.id as allocated_to_user_id', 'tea.allocated_on as allocated_to_da_on',
            '(CASE WHEN en.ref_m_efiled_type_id IN (1,3,5) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'2\',\'3\']) THEN \'Basic Detail\' 
            WHEN en.ref_m_efiled_type_id IN (1,5) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'6\']) THEN \'Earlier Court\' 
            WHEN en.ref_m_efiled_type_id IN (1,5) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'7\']) THEN \'Earlier Court\' 
            WHEN en.ref_m_efiled_type_id IN (1,5) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'9\']) THEN \'Index\' 
            WHEN en.ref_m_efiled_type_id IN (1,5) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'10\']) THEN \'Payment\'
            WHEN en.ref_m_efiled_type_id IN (2,4) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'2\']) THEN \'Appearing For\' 
            WHEN en.ref_m_efiled_type_id IN (2,4) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'5\']) THEN \'Index\' 
            WHEN en.ref_m_efiled_type_id IN (2,4) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\''.NEW_CASE_COURT_FEE.'\']) THEN \'Court Fee\' 
            WHEN en.ref_m_efiled_type_id IN (2) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'7\']) THEN \'Share Document\' 
            WHEN ( (en.ref_m_efiled_type_id IN (1,5) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'13\'])) 
                    OR (en.ref_m_efiled_type_id IN (2,4) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'9\'])) 
            ) THEN \'Final Submit\' 
        END) as pendingStage',
            'ec.caveat_num', 'ec.caveat_year',
            '(SELECT CONCAT(department_name, \' <br>(\', ministry_name, \')\') FROM efil.department_filings df 
            JOIN efil.m_departments md ON md.id = df.ref_department_id 
            WHERE registration_id=en.registration_id) as dept_file',
            '(SELECT \'Entered by Clerk\' FROM efil.clerk_filings WHERE registration_id=en.registration_id) as clerk_file'
        ]);

        $builder->join('efil.tbl_efiling_num_status as cs', 'en.registration_id = cs.registration_id');
        $builder->join('public.tbl_efiling_caveat as ec', 'en.registration_id = ec.ref_m_efiling_nums_registration_id', 'left');
        $builder->join('efil.m_tbl_efiling_type as et', 'en.ref_m_efiled_type_id=et.id');
        $builder->join('efil.tbl_case_details as new_case_cd', 'en.registration_id = new_case_cd.registration_id', 'left');
        $builder->join('efil.tbl_misc_docs_ia as mdia', 'en.registration_id = mdia.registration_id', 'left');
        $builder->join('efil.tbl_sci_cases as sc_case', 'sc_case.diary_no=mdia.diary_no AND sc_case.diary_year = mdia.diary_year', 'left');
        $builder->join('efil.tbl_users as users', 'en.created_by=users.id', 'left');
        $builder->join('efil.m_tbl_dashboard_stages as mtds', 'cs.stage_id = mtds.stage_id ', 'left');
        $builder->join('(SELECT * FROM efil.tbl_efiling_allocation tea ORDER BY tea.allocated_on DESC LIMIT 1) as tea', 'en.registration_id = tea.registration_id', 'left');
        $builder->join('efil.tbl_users as allocated_users', 'tea.admin_id=allocated_users.id', 'left');

        $builder->where('cs.is_active', 'TRUE');
        $builder->where('en.is_active', 'TRUE');
        $builder->where('en.is_deleted', 'FALSE');
        $builder->whereIn('en.ref_m_efiled_type_id', [1, 2, 4, 8, 9, 12, 13]);
        if ($notIn == 0) {
            $builder->whereIn('cs.stage_id', $stageIds);
        } else {
            $builder->whereNotIn('cs.stage_id', $stageIds);
        }

        $builder->groupStart();
        if ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
            $builder->where('en.sub_created_by', $createdBy);
        } else {
            $builder->where('en.created_by', $createdBy);
        }

        if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE && !in_array(4, $stageIds)) {
            $builder->orWhere('en.registration_id IN (SELECT registration_id FROM efil.department_filings WHERE aor_code::varchar=(SELECT aor_code FROM efil.tbl_users WHERE id=' . $this->db->escape($createdBy) . '))');
            $builder->orWhere('en.registration_id IN (SELECT registration_id FROM efil.clerk_filings WHERE aor_code::varchar=(SELECT aor_code FROM efil.tbl_users WHERE id=' . $this->db->escape($createdBy) . '))');
        }

        if ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT && !in_array(4, $stageIds)) {
            $builder->orWhere('en.registration_id IN (SELECT registration_id FROM efil.department_filings WHERE ref_department_id=' . $this->db->escape($_SESSION['login']['department_id']) . ')');
        }

        if ($_SESSION['login']['ref_m_usertype_id'] == USER_CLERK && !in_array(4, $stageIds)) {
            $builder->orWhereIn('en.created_by', [1597]);
        }
        $builder->groupEnd();
        if ($limit !== null) {
            $builder->limit($limit,$offset);
        }
        $builder->orderBy('cs.activated_on', 'DESC');
        $query = $builder->get();

        if ($query->getNumRows() >= 1) {
            return $query->getResult();
        } else {
            return false;
        }
    }

    public function get_day_wise_case_details($stageIds, $createdBy, $start=null, $end=null, $notIn = 0)
    {
        $builder = $this->db->table('efil.tbl_efiling_nums as en');
        $builder->select([
            'mtds.user_stage_name', 'en.efiling_for_type_id', 'en.efiling_for_id', 'en.ref_m_efiled_type_id',
            'en.efiling_no', 'en.efiling_year', 'en.registration_id', 'en.allocated_on',
            'et.efiling_type', 'cs.stage_id', 'cs.activated_on', 'en.sub_created_by',
            'new_case_cd.cause_title as ecase_cause_title', 'new_case_cd.sc_diary_num', 'new_case_cd.sc_diary_year',
            'new_case_cd.sc_diary_date', 'new_case_cd.sc_display_num', 'new_case_cd.sc_reg_date',
            'sc_case.diary_no', 'sc_case.diary_year', 'sc_case.reg_no_display', 'sc_case.cause_title',
            'ec.pet_name', 'ec.res_name', 'ec.orgid', 'ec.resorgid', 'ec.ref_m_efiling_nums_registration_id as caveat_reg',
            'users.first_name', 'users.last_name',
            'allocated_users.first_name as allocated_user_first_name', 'allocated_users.last_name as allocated_user_last_name',
            'allocated_users.id as allocated_to_user_id', 'tea.allocated_on as allocated_to_da_on',
            '(CASE WHEN en.ref_m_efiled_type_id IN (1,3,5) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'2\',\'3\']) THEN \'Basic Detail\' 
            WHEN en.ref_m_efiled_type_id IN (1,5) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'6\']) THEN \'Act Section\' 
            WHEN en.ref_m_efiled_type_id IN (1,5) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'7\']) THEN \'Earlier Court\' 
            WHEN en.ref_m_efiled_type_id IN (1,5) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'9\']) THEN \'Index\' 
            WHEN en.ref_m_efiled_type_id IN (1,5) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'10\']) THEN \'Payment\'
            WHEN en.ref_m_efiled_type_id IN (2,4) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'2\']) THEN \'Appearing For\' 
            WHEN en.ref_m_efiled_type_id IN (2,4) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'5\']) THEN \'Index\' 
            WHEN en.ref_m_efiled_type_id IN (2,4) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'6\']) THEN \'Court Fee\' 
            WHEN en.ref_m_efiled_type_id IN (2) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'7\']) THEN \'Share Document\' 
            WHEN ( (en.ref_m_efiled_type_id IN (1,5) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'13\'])) 
                    OR (en.ref_m_efiled_type_id IN (2,4) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'9\'])) 
            ) THEN \'Final Submit\' 
        END) as pendingStage',
            'ec.caveat_num', 'ec.caveat_year',
            '(SELECT CONCAT(department_name, \' <br>(\', ministry_name, \')\') FROM efil.department_filings df 
            JOIN efil.m_departments md ON md.id = df.ref_department_id 
            WHERE registration_id=en.registration_id) as dept_file',
            '(SELECT \'Entered by Clerk\' FROM efil.clerk_filings WHERE registration_id=en.registration_id) as clerk_file'
        ]);
        $builder->join('efil.tbl_efiling_num_status as cs', 'en.registration_id = cs.registration_id');
        $builder->join('public.tbl_efiling_caveat as ec', 'en.registration_id = ec.ref_m_efiling_nums_registration_id', 'left');
        $builder->join('efil.m_tbl_efiling_type as et', 'en.ref_m_efiled_type_id=et.id');
        $builder->join('efil.tbl_case_details as new_case_cd', 'en.registration_id = new_case_cd.registration_id', 'left');
        $builder->join('efil.tbl_misc_docs_ia as mdia', 'en.registration_id = mdia.registration_id', 'left');
        $builder->join('efil.tbl_sci_cases as sc_case', 'sc_case.diary_no=mdia.diary_no AND sc_case.diary_year = mdia.diary_year', 'left');
        $builder->join('efil.tbl_users as users', 'en.created_by=users.id', 'left');
        $builder->join('efil.m_tbl_dashboard_stages as mtds', 'cs.stage_id = mtds.stage_id ', 'left');
        $builder->join('(SELECT * FROM efil.tbl_efiling_allocation tea ORDER BY tea.allocated_on DESC LIMIT 1) as tea', 'en.registration_id = tea.registration_id', 'left');
        $builder->join('efil.tbl_users as allocated_users', 'tea.admin_id=allocated_users.id', 'left');
        $builder->where('cs.is_active', 'TRUE');
        $builder->where('en.is_active', 'TRUE');
        $builder->where('en.is_deleted', 'FALSE');
        $builder->whereIn('en.ref_m_efiled_type_id', [1, 2, 4, 8, 9, 12, 13]);
        if(!empty($start) && !empty($end)) {
            $builder->where('cs.activated_on >=', $start);
            $builder->where('cs.activated_on <=', $end);
        }
        if ($notIn == 0) {
            $builder->whereIn('cs.stage_id', $stageIds);
        } else {
            $builder->whereNotIn('cs.stage_id', $stageIds);
        }
        $builder->groupStart();
        if ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
            $builder->where('en.sub_created_by', $createdBy);
        } else {
            $builder->where('en.created_by', $createdBy);
        }
        if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE && !in_array(4, $stageIds)) {
            $builder->orWhere('en.registration_id IN (SELECT registration_id FROM efil.department_filings WHERE aor_code::varchar=(SELECT aor_code FROM efil.tbl_users WHERE id=' . $this->db->escape($createdBy) . '))');
            $builder->orWhere('en.registration_id IN (SELECT registration_id FROM efil.clerk_filings WHERE aor_code::varchar=(SELECT aor_code FROM efil.tbl_users WHERE id=' . $this->db->escape($createdBy) . '))');
        }
        if ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT && !in_array(4, $stageIds)) {
            $builder->orWhere('en.registration_id IN (SELECT registration_id FROM efil.department_filings WHERE ref_department_id=' . $this->db->escape($_SESSION['login']['department_id']) . ')');
        }
        if ($_SESSION['login']['ref_m_usertype_id'] == USER_CLERK && !in_array(4, $stageIds)) {
            $builder->orWhereIn('en.created_by', [1597]);
        }
        $builder->groupEnd();
        $builder->orderBy('cs.activated_on', 'DESC');
        $query = $builder->get();
        // $compiledQuery = $this->db->getLastQuery();
        if ($query->getNumRows() >= 1) {
            return $query->getResult();
        } else {
            return false;
        }
    }

//     public function get_day_wise_case_details($stageIds, $createdBy, $start, $end, $notIn = 0)
//     {
//         $builder = $this->db->table('efil.tbl_efiling_nums as en');

//         $builder->select([
//             'mtds.user_stage_name', 'en.efiling_for_type_id', 'en.efiling_for_id', 'en.ref_m_efiled_type_id',
//             'en.efiling_no', 'en.efiling_year', 'en.registration_id', 'en.allocated_on',
//             'et.efiling_type', 'cs.stage_id', 'cs.activated_on', 'en.sub_created_by',
//             'new_case_cd.cause_title as ecase_cause_title', 'new_case_cd.sc_diary_num', 'new_case_cd.sc_diary_year',
//             'new_case_cd.sc_diary_date', 'new_case_cd.sc_display_num', 'new_case_cd.sc_reg_date',
//             'sc_case.diary_no', 'sc_case.diary_year', 'sc_case.reg_no_display', 'sc_case.cause_title',
//             'ec.pet_name', 'ec.res_name', 'ec.orgid', 'ec.resorgid', 'ec.ref_m_efiling_nums_registration_id as caveat_reg',
//             'users.first_name', 'users.last_name',
//             'allocated_users.first_name as allocated_user_first_name', 'allocated_users.last_name as allocated_user_last_name',
//             'allocated_users.id as allocated_to_user_id', 'tea.allocated_on as allocated_to_da_on',
//             '(CASE WHEN en.ref_m_efiled_type_id IN (1,3,5) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'2\',\'3\']) THEN \'Basic Detail\' 
//             WHEN en.ref_m_efiled_type_id IN (1,5) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'6\']) THEN \'Act Section\' 
//             WHEN en.ref_m_efiled_type_id IN (1,5) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'7\']) THEN \'Earlier Court\' 
//             WHEN en.ref_m_efiled_type_id IN (1,5) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'9\']) THEN \'Index\' 
//             WHEN en.ref_m_efiled_type_id IN (1,5) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'10\']) THEN \'Payment\'
//             WHEN en.ref_m_efiled_type_id IN (2,4) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'2\']) THEN \'Appearing For\' 
//             WHEN en.ref_m_efiled_type_id IN (2,4) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'5\']) THEN \'Index\' 
//             WHEN en.ref_m_efiled_type_id IN (2,4) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'6\']) THEN \'Court Fee\' 
//             WHEN en.ref_m_efiled_type_id IN (2) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'7\']) THEN \'Share Document\' 
//             WHEN ( (en.ref_m_efiled_type_id IN (1,5) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'13\'])) 
//                     OR (en.ref_m_efiled_type_id IN (2,4) AND NOT (string_to_array(breadcrumb_status, \',\') && array[\'9\'])) 
//             ) THEN \'Final Submit\' 
//         END) as pendingStage',
//             'ec.caveat_num', 'ec.caveat_year',
//             '(SELECT CONCAT(department_name, \' <br>(\', ministry_name, \')\') FROM efil.department_filings df 
//             JOIN efil.m_departments md ON md.id = df.ref_department_id 
//             WHERE registration_id=en.registration_id) as dept_file',
//             '(SELECT \'Entered by Clerk\' FROM efil.clerk_filings WHERE registration_id=en.registration_id) as clerk_file'
//         ]);

//         $builder->join('efil.tbl_efiling_num_status as cs', 'en.registration_id = cs.registration_id');
//         $builder->join('public.tbl_efiling_caveat as ec', 'en.registration_id = ec.ref_m_efiling_nums_registration_id', 'left');
//         $builder->join('efil.m_tbl_efiling_type as et', 'en.ref_m_efiled_type_id=et.id');
//         $builder->join('efil.tbl_case_details as new_case_cd', 'en.registration_id = new_case_cd.registration_id', 'left');
//         $builder->join('efil.tbl_misc_docs_ia as mdia', 'en.registration_id = mdia.registration_id', 'left');
//         $builder->join('efil.tbl_sci_cases as sc_case', 'sc_case.diary_no=mdia.diary_no AND sc_case.diary_year = mdia.diary_year', 'left');
//         $builder->join('efil.tbl_users as users', 'en.created_by=users.id', 'left');
//         $builder->join('efil.m_tbl_dashboard_stages as mtds', 'cs.stage_id = mtds.stage_id ', 'left');
//         $builder->join('(SELECT * FROM efil.tbl_efiling_allocation tea ORDER BY tea.allocated_on DESC LIMIT 1) as tea', 'en.registration_id = tea.registration_id', 'left');
//         $builder->join('efil.tbl_users as allocated_users', 'tea.admin_id=allocated_users.id', 'left');

//         $builder->where('cs.is_active', 'TRUE');
//         $builder->where('en.is_active', 'TRUE');
//         $builder->where('en.is_deleted', 'FALSE');
//         $builder->whereIn('en.ref_m_efiled_type_id', [1, 2, 4, 8, 9, 12, 13]);
//         $builder->where('en.allocated_on >=', $start);
//         $builder->where('en.allocated_on <=', $end);
//         if ($notIn == 0) {
//             $builder->whereIn('cs.stage_id', $stageIds);
//         } else {
//             $builder->whereNotIn('cs.stage_id', $stageIds);
//         }

//         $builder->groupStart();
//         if ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
//             $builder->where('en.sub_created_by', $createdBy);
//         } else {
//             $builder->where('en.created_by', $createdBy);
//         }

//         if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE && !in_array(4, $stageIds)) {
//             $builder->orWhere('en.registration_id IN (SELECT registration_id FROM efil.department_filings WHERE aor_code::varchar=(SELECT aor_code FROM efil.tbl_users WHERE id=' . $this->db->escape($createdBy) . '))');
//             $builder->orWhere('en.registration_id IN (SELECT registration_id FROM efil.clerk_filings WHERE aor_code::varchar=(SELECT aor_code FROM efil.tbl_users WHERE id=' . $this->db->escape($createdBy) . '))');
//         }

//         if ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT && !in_array(4, $stageIds)) {
//             $builder->orWhere('en.registration_id IN (SELECT registration_id FROM efil.department_filings WHERE ref_department_id=' . $this->db->escape($_SESSION['login']['department_id']) . ')');
//         }

//         if ($_SESSION['login']['ref_m_usertype_id'] == USER_CLERK && !in_array(4, $stageIds)) {
//             $builder->orWhereIn('en.created_by', [1597]);
//         }
//         $builder->groupEnd();

//         $builder->orderBy('cs.activated_on', 'DESC');

//         $query = $builder->get();
// //         $compiledQuery = $this->db->getLastQuery();

//         if ($query->getNumRows() >= 1) {
//             return $query->getResult();
//         } else {
//             return false;
//         }
//     }

    // Function used to get stage wise list of efiling nums from dashboard
    // Function used to get Finally Submitted list of efiling nums from dashboard

    // public function get_efilied_nums_submitted_list($stages, $created_by) {

    //     $this->db->SELECT(array('en.efiling_for_type_id', 'en.efiling_no', 'en.ref_m_efiled_type_id', 'en.efiling_year', 'en.registration_id', 'et.efiling_type', 'cs.stage_id',
    //         'cs.activated_on', 
    //         'new_case_cd.cause_title ecase_cause_title', 'new_case_cd.sc_diary_num', 'new_case_cd.sc_diary_date', 'new_case_cd.sc_display_num', 'new_case_cd.sc_reg_date',
    //         'sc_case.diary_no', 'sc_case.diary_year', 'sc_case.reg_no_display', 'sc_case.cause_title'//,  
    //         //'ec.pet_name', 'ms.case_type_name', 'res_name', 'ms.petitioner_name', 'ms.respondent_name'
    //         ));
    //     $this->db->FROM('tbl_efiling_nums as en');
    //     $this->db->JOIN('tbl_efiling_case_status as cs', 'en.registration_id = cs.registration_id');
    //     $this->db->JOIN('m_tbl_efiling_type as et', 'en.ref_m_efiled_type_id=et.id');
    //     $this->db->JOIN('tbl_efiling_civil as ec', 'en.registration_id = ec.ref_m_efiling_nums_registration_id', 'left');
    //     $this->db->JOIN('tbl_misc_doc_filing as ms', 'ms.ref_m_efiling_nums_registration_id=en.registration_id ', 'left');
    //     $this->db->WHERE('cs.is_active', 'TRUE');
    //     $this->db->WHERE('en.is_active', 'TRUE');
    //     $this->db->WHERE_NOT_IN('cs.stage_id', $stages);

    //     if ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
    //         $this->db->WHERE('en.sub_created_by', $created_by);
    //     } else {
    //         $this->db->WHERE('en.created_by', $created_by);
    //     }
    //     $this->db->ORDER_BY('cs.activated_on', 'DESC');

    //     $query = $this->db->get();

    //     if ($query->num_rows() >= 1) {
    //         return $query->result();
    //     } else {
    //         return false;
    //     }
    // }

    public function get_efilied_nums_submitted_list($stages, $createdBy)
    {
        $builder = $this->db->table('tbl_efiling_nums as en');

        $builder->select([
            'en.efiling_for_type_id', 'en.efiling_no', 'en.ref_m_efiled_type_id', 'en.efiling_year',
            'en.registration_id', 'et.efiling_type', 'cs.stage_id', 'cs.activated_on',
            'new_case_cd.cause_title as ecase_cause_title', 'new_case_cd.sc_diary_num', 'new_case_cd.sc_diary_date',
            'new_case_cd.sc_display_num', 'new_case_cd.sc_reg_date', 'sc_case.diary_no',
            'sc_case.diary_year', 'sc_case.reg_no_display', 'sc_case.cause_title'
        ]);

        $builder->join('tbl_efiling_case_status as cs', 'en.registration_id = cs.registration_id');
        $builder->join('m_tbl_efiling_type as et', 'en.ref_m_efiled_type_id = et.id');
        $builder->join('tbl_efiling_civil as ec', 'en.registration_id = ec.ref_m_efiling_nums_registration_id', 'left');
        $builder->join('tbl_misc_doc_filing as ms', 'ms.ref_m_efiling_nums_registration_id = en.registration_id', 'left');

        $builder->where('cs.is_active', 'TRUE');
        $builder->where('en.is_active', 'TRUE');
        $builder->whereNotIn('cs.stage_id', $stages);

        if ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
            $builder->where('en.sub_created_by', $createdBy);
        } else {
            $builder->where('en.created_by', $createdBy);
        }

        $builder->orderBy('cs.activated_on', 'DESC');

        $query = $builder->get();

        if ($query->getNumRows() >= 1) {
            return $query->getResult();
        } else {
            return false;
        }
    }


    // Function used to get Finally Submitted list of efiling nums from dashboard



}
