<?php

namespace App\Models\Caveat;
use CodeIgniter\Model;

class View_model extends Model {

    function __construct() {
        parent::__construct();
    }

    function get_efiling_civil_details($registration_id) {
        $this->db->SELECT("en.*,ec.*,
        idep.deptname as org_dept_name,piaut.authdesc as org_post_name,pivs.deptname as org_state_name,
        ridep.deptname as res_org_dept_name,riaut.authdesc as res_org_post_name,rivs.deptname as res_org_state_name,
        (case when ec.orgid = 'I' then 'Individual'   
        else case when ec.orgid = 'D1' then 'State Department'
        else case when ec.orgid = 'D2' then 'Central Department'
        else case when ec.orgid = 'D3' then 'Other Organisation'
        end end end end )as pet_party_is,
        (case when ec.resorgid = 'I' then 'Individual'   
        else case when ec.resorgid = 'D1' then 'State Department'
        else case when ec.resorgid = 'D2' then 'Central Department'
        else case when ec.resorgid = 'D3' then 'Other Organisation'
        end end end end )as res_party_is
        ");
        $this->db->FROM('efil.tbl_efiling_nums en');
        $this->db->JOIN('public.tbl_efiling_caveat ec', 'en.registration_id = ec.ref_m_efiling_nums_registration_id');
        $this->db->JOIN('icmis.deptt idep', "ec.org_dept = idep.deptcode and idep.display='Y'","left");
        $this->db->JOIN('icmis.deptt ridep', "ec.res_org_dept = ridep.deptcode and ridep.display='Y'","left");
        $this->db->JOIN('icmis.authority piaut', "ec.org_post = piaut.authcode and piaut.display='Y'","left");
        $this->db->JOIN('icmis.authority riaut', "ec.res_org_post = riaut.authcode and riaut.display='Y'","left");

        $this->db->JOIN('icmis.view_state_in_name pivs', "ec.org_state = pivs.deptcode","left");
        $this->db->JOIN('icmis.view_state_in_name rivs', "ec.res_org_state = rivs.deptcode","left");
        $this->db->WHERE('en.registration_id', $registration_id);
        $this->db->WHERE('en.is_active', TRUE);
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() >= 1) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

    function get_efiling_civil_master_value($registration_id) {

        $this->db->SELECT('*');
        $this->db->FROM('tbl_cis_masters_values');
        $this->db->WHERE('registration_id', $registration_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    function get_uploaded_documents($registration_id) {

        $this->db->SELECT('*');
        $this->db->FROM('tbl_efiled_docs docs');
        $this->db->WHERE('docs.registration_id', $registration_id);
        $this->db->ORDER_BY('docs.doc_id');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    public function get_extra_party_preview_details($regid) {       
        $this->db->SELECT("en.*,ec.*,
        idep.deptname as extra_party_org_dept_name,piaut.authdesc as extra_party_org_post_name,pivs.deptname as extra_party_org_state_name,
        (case when ec.orgid = 'I' then 'Individual'   
        else case when ec.orgid = 'D1' then 'State Department'
        else case when ec.orgid = 'D2' then 'Central Department'
        else case when ec.orgid = 'D3' then 'Other Organisation'
        end end end end )as extra_party_is,
        (case when ec.type = '1' then 'Caveator'   
        else case when ec.type = '2' then 'Caveatee'
        end end )as extra_party_type
        ");
        $this->db->FROM('efil.tbl_efiling_nums en');
        $this->db->JOIN('public.tbl_efiling_civil_extra_party ec', 'en.registration_id = ec.ref_m_efiling_nums_registration_id');
        $this->db->JOIN('icmis.deptt idep', "ec.extra_party_org_dept = idep.deptcode and idep.display='Y'","left");
        $this->db->JOIN('icmis.authority piaut', "ec.extra_party_org_post = piaut.authcode and piaut.display='Y'","left");
        $this->db->JOIN('icmis.view_state_in_name pivs', "ec.extra_party_org_state = pivs.deptcode","left");
        $this->db->WHERE('en.registration_id', $regid);
        $this->db->WHERE('en.is_active', TRUE);
        $this->db->WHERE('ec.display', 'Y');
        $this->db->WHERE('ec.parentid', NULL);
        $this->db->ORDER_BY("ec.type", "asc");
        $this->db->ORDER_BY("ec.party_id", "asc");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() >= 1) {
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }

    function get_sub_qj_hc_court_details($registration_id,$id=null) {
        $this->db->distinct('mdce.state_name');
        $this->db->SELECT("case when elc.sub_qj_high=3 then '1'  when elc.sub_qj_high=1 then '3' when elc.sub_qj_high=5 then '5' else '1'  end as court_type, 
         elc.*,mdce.state_name,mdce.district_name,mdce.estab_name,hcb.cmis_state_id,hcb.ref_agency_code_id , 
         ras.agency_state,concat(rac.short_agency_name,rac.agency_name) agency_name ,lhc.type_sname case_name ");
        $this->db->FROM('public.etrial_lower_court elc');
        $this->db->join('efil.m_tbl_district_courts_establishments mce','elc.lower_state_id = mce.state_code AND elc.lower_dist_code = mce.district_code','left');
        $this->db->join('efil.m_tbl_district_courts_establishments mdce','elc.lower_court_code = mdce.estab_code','left' );
        $this->db->join('efil.m_tbl_high_courts_bench hcb','elc.bench_code = hcb.est_code','left');
        $this->db->JOIN('icmis.ref_agency_state ras','elc.lower_state_id = ras.cmis_state_id ','left');
        $this->db->JOIN('icmis.ref_agency_code rac','elc.lower_dist_code = rac.id ','left');
        $this->db->JOIN('icmis.lc_hc_casetype lhc','elc.case_type = lhc.lccasecode ','left');
        $this->db->WHERE('elc.registration_id', $registration_id);
       if (!empty($id) && $id !=null){ $this->db->WHERE('elc.id', $id); }
        $this->db->WHERE('elc.is_deleted', FALSE);
        $this->db->ORDER_BY("elc.id", "asc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

    function getSubCourtDetails($registration_id) {
        $this->db->SELECT("case when elc.sub_qj_high=3 then '1'  when elc.sub_qj_high=1 then '3' when elc.sub_qj_high=5 then '5' else '1'  end as court_type,
          elc.*,mdce.state_name,mdce.district_name,mdce.estab_name,
           (case when elc.sub_qj_high = '3' then hcb.cmis_state_id   
            else case when elc.sub_qj_high = '1' then mdce.cmis_id_no
              else case when elc.sub_qj_high = '5' then rac.cmis_state_id
            end end end)as cmis_state_id,
            (case when elc.sub_qj_high = '3' then hcb.ref_agency_code_id   
            else case when elc.sub_qj_high = '1' then mdce.id
            else case when elc.sub_qj_high = '5' then rac.id
            end end end)as ref_agency_code_id             
          ");
        $this->db->FROM('public.etrial_lower_court elc');
        $this->db->join('efil.m_tbl_district_courts_establishments mce','elc.lower_state_id = mce.state_code AND elc.lower_dist_code = mce.district_code','left');
        $this->db->join('efil.m_tbl_district_courts_establishments mdce','elc.lower_court_code = mdce.estab_code','left' );
        $this->db->join('efil.m_tbl_high_courts_bench hcb','elc.bench_code = hcb.est_code','left');
        $this->db->join('icmis.ref_agency_code rac','elc.lower_state_id = rac.cmis_state_id and elc.lower_dist_code = rac.id','left');
        $this->db->WHERE('elc.registration_id', $registration_id);
        $this->db->WHERE('elc.is_deleted', FALSE);
        $this->db->ORDER_BY("elc.id", "asc");
        $query = $this->db->get();
      //  echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }




    function get_index_items_list($registration_id) {

        $this->db->SELECT('ed.*');
       // $this->db->FROM('tbl_efiled_docs ed');
        $this->db->FROM('efil.tbl_uploaded_pdfs ed');
        $this->db->WHERE('ed.registration_id', $registration_id);
        $this->db->WHERE('ed.is_active', TRUE);
        $this->db->WHERE('ed.is_deleted', FALSE);
        $this->db->ORDER_BY('ed.doc_id');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
    }

    public function get_index_item_file($doc_id) {
        // used to show index pdf file on click of index item list
        $this->db->SELECT('ed.file_path, ed.file_name, ed.doc_title');
        $this->db->FROM('tbl_efiled_docs ed');
        $this->db->WHERE('ed.doc_id', $doc_id);
        $this->db->WHERE('ed.is_active', TRUE);
        $this->db->WHERE('ed.is_deleted', FALSE);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
    }
    function get_caveat_index_items_list($registration_id,$re_filed=0) {
        $this->db->SELECT('DISTINCT ed.*,dm.docdesc',FALSE); //,sub_dm.docdesc
        $this->db->FROM('efil.tbl_efiled_docs ed');
        $this->db->JOIN('icmis.docmaster dm', 'ed.doc_type_id = dm.doccode AND ed.sub_doc_type_id = dm.doccode1 and dm.display!=\'N\'');
        //$this->db->JOIN('icmis.docmaster sub_dm', 'ed.sub_doc_type_id = sub_dm.doccode1', 'LEFT');
        $this->db->WHERE('ed.registration_id', $registration_id);
        $this->db->WHERE('ed.is_active', TRUE);
        $this->db->WHERE('ed.is_deleted', FALSE);
        if($re_filed!=0){
            //icmis_docnum is null and icmis_docyear is null and doc_type_id =8
            $this->db->where('ed.icmis_docnum IS NULL', null, false);
            $this->db->where('ed.icmis_docyear IS NULL', null, false);
            $this->db->where('ed.doc_type_id',8);
        }
        $this->db->ORDER_BY('ed.index_no');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
    }


    function get_payment_details($registration_id) {

        $this->db->SELECT('cfp.*,ed.caveat_year,ed.caveat_num,ed.caveat_num_date');
        $this->db->FROM('efil.tbl_court_fee_payment cfp');
        $this->db->JOIN('public.tbl_efiling_caveat ed', 'cfp.registration_id=ed.ref_m_efiling_nums_registration_id','LEFT');
        $this->db->WHERE('cfp.registration_id', $registration_id);
        $this->db->WHERE('cfp.is_deleted', FALSE);
        $this->db->ORDER_BY('cfp.id', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
    }

    function get_efiled_efiling_details($registration_id) {
        $array = array(Draft_Stage);
        $this->db->SELECT("en.*,cs.*,efiled_by.id,efiled_by.ref_m_usertype_id,efiled_by.first_name, efiled_by.last_name, efiled_by.moblie_number, efiled_by.emailid,
                concat(users.first_name,' ',users.last_name) as admin_name,
                (CASE WHEN en.efiling_for_type_id =" . E_FILING_FOR_ESTABLISHMENT . " THEN (SELECT concat(estname,', ',dist_name,', ',state)  
                    FROM m_tbl_establishments est
                      LEFT JOIN m_tbl_state st on est.state_code = st.state_id
                      LEFT JOIN m_tbl_districts dist on est.ref_m_tbl_districts_id = dist.id
                WHERE est.id = en.efiling_for_id ) 
                ELSE (SELECT concat(hc_name,' High Court') FROM m_tbl_high_courts hc
                WHERE hc.id = en.efiling_for_id) END ) 
                as efiling_for_name");
        $this->db->FROM('tbl_efiling_nums en');
        $this->db->JOIN('users', 'users.id = en.allocated_to', 'LEFT');
        $this->db->JOIN('users efiled_by', 'efiled_by.id = en.created_by', 'LEFT');
        $this->db->JOIN('tbl_efiling_case_status cs', 'en.registration_id = cs.registration_id', 'LEFT');
        $this->db->WHERE_NOT_IN('cs.stage_id', $array);
        $this->db->WHERE('en.registration_id', $registration_id);
        $this->db->WHERE('en.is_active', TRUE);
        $this->db->ORDER_BY('cs.status_id', 'DESC');
        $this->db->LIMIT(1, 0);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }
    public function getCourtDetails($params =array()){
        $output = false;
        if(isset($params['type']) && !empty($params['type'])){
            $type = (int)$params['type'];
            switch($type){
                case 1: //for high court name
                    $this->db->select('mhcb.hc_id,mhcb.name');
                    $this->db->from('efil.m_tbl_high_courts_bench mhcb');
                    if(isset($params['hc_id']) && !empty($params['hc_id'])){
                        $this->db->where('mhcb.hc_id',$params['hc_id']);
                        $this->db->where('mhcb.bench_id IS NULL');
                        $this->db->where('mhcb.est_code IS NULL');
                    }
                    $query = $this->db->get();
                    $output = $query->result_array();
                    break;
                case 2: //for bench name
                    $this->db->select('mhcb.hc_id,mhcb.name');
                    $this->db->from('efil.m_tbl_high_courts_bench mhcb');
                    if(isset($params['hc_id']) && !empty($params['hc_id'])){
                        $this->db->where('mhcb.hc_id',$params['hc_id']);
                    }
                    if(isset($params['est_code']) && !empty($params['est_code'])){
                        $this->db->where('mhcb.est_code',$params['est_code']);
                    }
                    $query = $this->db->get();
                    $output = $query->result_array();
                    break;
                case 3: //for case name
                    $this->db->select('mthcc.id,mthcc.type_name');
                    $this->db->from('efil.m_tbl_high_courts_case_types mthcc');
                    if(isset($params['id']) && !empty($params['id'])){
                        $this->db->where('mthcc.id',$params['id']);
                    }
                    if(isset($params['est_code']) && !empty($params['est_code'])){
                        $this->db->where('mthcc.est_code',$params['est_code']);
                    }
                    $query = $this->db->get();
                    $output = $query->result_array();
                    break;
                default:
                    $output= false;
            }
        }
        return $output;
    }
}
