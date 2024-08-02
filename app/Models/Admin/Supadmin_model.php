<?php

namespace App\Models\Admin;
use CodeIgniter\Model;

class Supadmin_model extends Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function updateCaseStatus($registration_id, $case_status, $remark) {
        $this->db->transStart();
        $update_data = array(
            'deactivated_on' => date('Y-m-d H:i:s'),
            'is_active' => FALSE,
            'updated_by' => $_SESSION['login']['id'],
            'updated_by_ip' => $_SERVER['REMOTE_ADDR'],
            'remark' => $remark
        );
        $builder = $this->db->table('efil.tbl_efiling_num_status');
        $builder->WHERE('registration_id', $registration_id);
        $builder->WHERE('is_active', TRUE);
        $builder->UPDATE($update_data);

        // $this->db->WHERE('registration_id', $registration_id);
        // $this->db->WHERE('is_active', TRUE);
        // $this->db->UPDATE('efil.tbl_efiling_num_status', $update_data);

        $insert_data = array(
            'registration_id' => $registration_id,
            'stage_id' => $case_status,
            'activated_on' => date('Y-m-d H:i:s'),
            'is_active' => TRUE,
            'activated_by' => $_SESSION['login']['id'],
            'activated_by_ip' => $_SERVER['REMOTE_ADDR'],
            'remark' => $remark
        );

        // $this->db->INSERT('efil.tbl_efiling_num_status', $insert_data);
        $builder = $this->db->table('efil.tbl_efiling_num_status');
            $builder->INSERT($insert_data);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function get_status_that_can_be_changed() {
        $sql = "  select cs.*,en.*,

        cs2.stage_id as last_stage_to_be_updated

        from

        (select * from efil.tbl_efiling_num_status where is_active = 'true') cs

        left join efil.tbl_efiling_nums en on en.registration_id = cs.registration_id

        left join ( select * from (select *,dense_rank() over (partition by registration_id order by activated_on desc) as row_num from efil.tbl_efiling_num_status  ) z where row_num = 2 ) cs2 on cs2.registration_id = cs.registration_id

        order by en.efiling_no ";

        $query = $this->db->query($sql);

        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function search_status_that_can_be_changed($efil_no) {

        $sql_1 = "SELECT efiling_for_type_id FROM efil.tbl_efiling_nums WHERE efiling_no = '" . trim(strtoupper($efil_no)) . "' OR efiling_no = '" . trim(strtolower($efil_no)) . "' ";

        $query = $this->db->query($sql_1);
        $query_1 = $query->getResult();
        // if ($query_1->num_rows() > 0) {
        if (count($query_1) > 0) {
            // $res = $query_1->result_array();
            $res = $query->getResultArray();
            $efiling_for_type_id = $res[0]['efiling_for_type_id'];
        }
        if ($efiling_for_type_id == E_FILING_FOR_HIGHCOURT) {
            $join = 'LEFT JOIN efil.m_tbl_high_courts hc on hc.id = en.efiling_for_id and en.efiling_for_type_id =' . $efiling_for_type_id . '';
            $where_cond = " WHERE en.efiling_no = '" . trim(strtoupper($efil_no)) . "' OR en.efiling_no = '" . trim(strtolower($efil_no)) . "'";
        } else if ($efiling_for_type_id == E_FILING_FOR_ESTABLISHMENT && $_SESSION['login']['ref_m_usertype_id'] == USER_DISTRICT_ADMIN) {
            $join = 'LEFT JOIN efil.m_tbl_establishments estab on estab.id = en.efiling_for_id and en.efiling_for_type_id =' . $efiling_for_type_id . '
            LEFT JOIN efil.m_tbl_districts district on district.id = estab.ref_m_tbl_districts_id';
            $where_cond = " WHERE  district.id = " . $_SESSION['login']['admin_for_id'] . " AND (en.efiling_no = '" . trim(strtoupper($efil_no)) . "' OR en.efiling_no = '" . trim(strtolower($efil_no)) . "')";
        } else if ($efiling_for_type_id == E_FILING_FOR_ESTABLISHMENT && $_SESSION['login']['ref_m_usertype_id'] == USER_MASTER_ADMIN) {
           $join = 'LEFT JOIN efil.m_tbl_establishments estab on estab.id = en.efiling_for_id and en.efiling_for_type_id =' . $efiling_for_type_id;
            $where_cond = " WHERE  estab.id = " . $_SESSION['login']['admin_for_id'] . " AND (en.efiling_no = '" . trim(strtoupper($efil_no)) . "' OR en.efiling_no = '" . trim(strtolower($efil_no)) . "')";
        } else if ($efiling_for_type_id == E_FILING_FOR_ESTABLISHMENT) {
            $join = 'LEFT JOIN efil.m_tbl_establishments estab on estab.id = en.efiling_for_id and en.efiling_for_type_id =' . $efiling_for_type_id;
            $where_cond = " WHERE en.efiling_no = '" . trim(strtoupper($efil_no)) . "' OR en.efiling_no = '" . trim(strtolower($efil_no)) . "'";
        }
        else if($efiling_for_type_id == E_FILING_FOR_SUPREMECOURT){
            $join = 'LEFT JOIN efil.m_tbl_establishments estab on estab.id = en.efiling_for_id and en.efiling_for_type_id =' . $efiling_for_type_id;
            $where_cond = " WHERE en.efiling_no = '" . trim(strtoupper($efil_no)) . "' OR en.efiling_no = '" . trim(strtolower($efil_no)) . "'";
        } else {
            $join = '';
            $where_cond = '';
        }
        $sql = "  SELECT cs.*,en.*,
        cs2.stage_id as last_stage_to_be_updated
        FROM
        (SELECT * FROM efil.tbl_efiling_num_status where is_active = 'true') cs
        LEFT JOIN efil.tbl_efiling_nums en on en.registration_id = cs.registration_id
        LEFT JOIN ( SELECT * FROM (select *,dense_rank() over (partition by registration_id order by activated_on desc) as row_num from efil.tbl_efiling_num_status  ) z WHERE row_num = 2 ) cs2 on cs2.registration_id = cs.registration_id

        $join  $where_cond

        ORDER BY en.efiling_no";

        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;

        
        $query_1 = $query->getResult();
        // pr($query_1);
        // if ($query->num_rows() == 1) {
        if (count($query_1) == 1) {
            // return $query->result();
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    function get_establishment_code($estab_id) {
        $this->db->SELECT('est_code');
        $this->db->FROM('m_tbl_establishments');
        $this->db->WHERE('est_code', $estab_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    function add_establishment_detail($state_id, $dist, $distdata, $estabdata) {
        $this->db->SELECT('*');
        $this->db->FROM('m_tbl_districts dt');
        $this->db->JOIN('m_tbl_state st', 'dt.ref_m_tbl_states_id=st.state_id');
        $this->db->WHERE('dt.dist_code', $dist);
        $this->db->WHERE('dt.ref_m_tbl_states_id', $state_id);
        $sqlquery = $this->db->get();
        $this->db->trans_start();
        if ($sqlquery->num_rows() >= 1) {
            $result = $sqlquery->result();
            $dist_id = $result[0]->id;
        } else {
            $this->db->INSERT('m_tbl_districts', $distdata);
            $dist_id = $this->db->insert_id();
        }
        if (!empty($dist_id)) {

            $distid = array('ref_m_tbl_districts_id' => $dist_id);
            $dist_data = array_merge($estabdata, $distid);
            $this->db->INSERT('m_tbl_establishments', $dist_data);
            $estid = $this->db->insert_id();
            if ($this->db->insert_id()) {
                $p_efiling_num = 0;
                $doc_efiling_no = 0;
                $fee_efiling_no = 0;
                $ia_efiling_no = 0;
                $case_data_entry_no = 0;
                $esign_appli_num = 0;

                $newYear = date('Y');
                $efiling_data = array('efiling_no' => $p_efiling_num,
                    'entry_for_type' => E_FILING_FOR_ESTABLISHMENT,
                    'efiling_year' => $newYear,
                    'ref_m_establishment_id' => $estid,
                    'updated_by' => $this->session->userdata['login']['id'],
                    'updated_on' => date('Y-m-d H:i:s'),
                    'updated_by_ip' => $_SERVER['REMOTE_ADDR'],
                    'doc_efiling_no' => $doc_efiling_no,
                    'fee_efiling_no' => $fee_efiling_no,
                    'ia_efiling_no' => $ia_efiling_no,
                    'case_data_entry_no' => $case_data_entry_no,
                    'doc_efiling_year' => $newYear,
                    'doc_updated_by' => $this->session->userdata['login']['id'],
                    'doc_updated_on' => date('Y-m-d H:i:s'),
                    'doc_updated_by_ip' => $_SERVER['REMOTE_ADDR'],
                    'fee_efiling_year' => $newYear,
                    'fee_updated_by' => $this->session->userdata['login']['id'],
                    'fee_updated_on' => date('Y-m-d H:i:s'),
                    'fee_updated_by_ip' => $_SERVER['REMOTE_ADDR'],
                    'esign_appli_num' => $esign_appli_num,
                    'esign_appli_date' => date('Y-m-d'),
                    'ia_efiling_year' => $newYear,
                    'ia_updated_by' => $this->session->userdata['login']['id'],
                    'ia_updated_on' => date('Y-m-d H:i:s'),
                    'ia_updated_by_ip' => $_SERVER['REMOTE_ADDR'],
                    'case_data_entry_year' => $newYear,
                    'case_data_entry_updated_by' => $this->session->userdata['login']['id'],
                    'case_data_entry_updated_on' => date('Y-m-d H:i:s'),
                    'case_data_entry_updated_by_ip' => $_SERVER['REMOTE_ADDR'],
                );
                $efiling_data = $this->db->INSERT('m_tbl_efiling_no', $efiling_data);
                $this->db->trans_complete();
            } if ($this->db->trans_status() === FALSE) {
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    function get_estab_details() {
        $this->db->SELECT('est.id estid,*,est.display est_display');
        $this->db->FROM('m_tbl_establishments est');
        $this->db->JOIN('m_tbl_state st', 'est.state_code=st.state_id');
        $this->db->JOIN('m_tbl_districts dist', 'dist.id=est.ref_m_tbl_districts_id');
        $this->db->WHERE('created_by', $_SESSION['login']['id']);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_estabid_details($estid) {
        $this->db->SELECT('est.id estid,*,est.display est_display');
        $this->db->FROM('m_tbl_establishments est');
        $this->db->JOIN('m_tbl_state st', 'est.state_code=st.state_id');
        $this->db->JOIN('m_tbl_districts dist', 'dist.id=est.ref_m_tbl_districts_id');
        $this->db->WHERE('created_by', $_SESSION['login']['id']);
        $this->db->WHERE('est.id', $estid);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function update_establishment_detail($estid, $estabdata) {
        $this->db->WHERE('id', $estid);
        $this->db->UPDATE('m_tbl_establishments', $estabdata);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_hc_detail($hcid, $hcdata) {
        $this->db->trans_start();
        $this->db->WHERE('id', $hcid);
        $this->db->UPDATE('m_tbl_high_courts', $hcdata);

        if ($this->db->affected_rows() > 0) {
            $p_efiling_num = 0;
            $doc_efiling_no = 0;
            $fee_efiling_no = 0;
            $ia_efiling_no = 0;
            $case_data_entry_no = 0;
            $esign_appli_num = 0;

            $newYear = date('Y');
            $efiling_data = array('efiling_no' => $p_efiling_num,
                'entry_for_type' => E_FILING_FOR_ESTABLISHMENT,
                'efiling_year' => $newYear,
                'ref_m_establishment_id' => $hcid,
                'updated_by' => $this->session->userdata['login']['id'],
                'updated_on' => date('Y-m-d H:i:s'),
                'updated_by_ip' => $_SERVER['REMOTE_ADDR'],
                'doc_efiling_no' => $doc_efiling_no,
                'fee_efiling_no' => $fee_efiling_no,
                'ia_efiling_no' => $ia_efiling_no,
                'case_data_entry_no' => $case_data_entry_no,
                'doc_efiling_year' => $newYear,
                'doc_updated_by' => $this->session->userdata['login']['id'],
                'doc_updated_on' => date('Y-m-d H:i:s'),
                'doc_updated_by_ip' => $_SERVER['REMOTE_ADDR'],
                'fee_efiling_year' => $newYear,
                'fee_updated_by' => $this->session->userdata['login']['id'],
                'fee_updated_on' => date('Y-m-d H:i:s'),
                'fee_updated_by_ip' => $_SERVER['REMOTE_ADDR'],
                'esign_appli_num' => $esign_appli_num,
                'esign_appli_date' => date('Y-m-d'),
                'ia_efiling_year' => $newYear,
                'ia_updated_by' => $this->session->userdata['login']['id'],
                'ia_updated_on' => date('Y-m-d H:i:s'),
                'ia_updated_by_ip' => $_SERVER['REMOTE_ADDR'],
                'case_data_entry_year' => $newYear,
                'case_data_entry_updated_by' => $this->session->userdata['login']['id'],
                'case_data_entry_updated_on' => date('Y-m-d H:i:s'),
                'case_data_entry_updated_by_ip' => $_SERVER['REMOTE_ADDR'],
            );
            $efiling_data = $this->db->INSERT('m_tbl_efiling_no', $efiling_data);
            $this->db->trans_complete();
        } if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function action_taken($action_id, $status) {
        if ($status == 'Active') {
            $data = array('display' => 'Y');
            $this->db->WHERE('id', $action_id);
            $this->db->UPDATE('m_tbl_establishments', $data);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } if ($status == 'Deactive') {
            $data = array('display' => 'N');
            $this->db->WHERE('id', $action_id);
            $this->db->UPDATE('m_tbl_establishments', $data);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
        if ($status == 'Revoke') {
            $data = array('is_live' => FALSE, 'revoked_by' => $_SESSION['login']['id'], 'revoked_by_ip' => $_SERVER['REMOTE_ADDR'], 'revoked_on' => date("Y-m-d H:i:s"));
            $this->db->WHERE('id', $action_id);
            $this->db->UPDATE('m_tbl_establishments', $data);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } if ($status == 'Revoke_HC') {
            $data = array('is_live' => FALSE, 'revoked_by' => $_SESSION['login']['id'], 'revoked_by_ip' => $_SERVER['REMOTE_ADDR'], 'revoked_on' => date("Y-m-d H:i:s"));
            $this->db->WHERE('id', $action_id);
            $this->db->UPDATE('m_tbl_high_courts', $data);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }if ($status == 'Deactive_HC') {
            $data = array('is_active' => FALSE);
            $this->db->WHERE('id', $action_id);
            $this->db->UPDATE('m_tbl_high_courts', $data);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }if ($status == 'Active_HC') {
            $data = array('is_active' => TRUE);
            $this->db->WHERE('id', $action_id);
            $this->db->UPDATE('m_tbl_high_courts', $data);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    function get_admin_states() {
        $this->db->SELECT('*');
        $this->db->FROM('m_tbl_state');
        $this->db->WHERE('state_id', $_SESSION['login']['admin_for_id']);
        $this->db->order_by('state');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_payment_detail($entry_for_type_id, $entry_for_id) {
        $this->db->SELECT("cfp.*,
            (CASE when cfp.entry_for_type_id = " . E_FILING_FOR_ESTABLISHMENT . " THEN (SELECT concat(estname,', ',dist_name,', ',state) 
            FROM m_tbl_establishments est LEFT JOIN m_tbl_state st on est.state_code= st.state_id 
            LEFT JOIN m_tbl_districts dist on est.ref_m_tbl_districts_id = dist.id WHERE est.id = cfp.entry_for_id) 
            ELSE (SELECT concat(hc_name,' High Court') FROM m_tbl_high_courts hc WHERE hc.id = cfp.entry_for_id) end ) AS estab_detail");
        $this->db->FROM('tbl_court_fee_payment cfp');
        $this->db->WHERE('cfp.receipt_uploaded_by', $_SESSION['login']['id']);
        $this->db->WHERE('cfp.entry_for_type_id', $entry_for_type_id);
        $this->db->WHERE('cfp.entry_for_id', $entry_for_id);
        $this->db->ORDER_BY('cfp.id', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_live_high_court_list() {

        $this->db->SELECT("hc.id,hc_name,hc_code");
        $this->db->FROM('m_tbl_high_courts hc');
        $this->db->JOIN('efil.tbl_users', 'hc.id=users.admin_for_id AND users.ref_m_usertype_id IN (' . USER_ADMIN . ',' . USER_ACTION_ADMIN . ')');
        $this->db->WHERE('hc.is_active', 'TRUE');
        $this->db->WHERE('hc.is_live', 'FALSE');
        $this->db->WHERE('hc.parent_hc_id', NULL);
        $this->db->WHERE('users.is_active', 'TRUE');
        $this->db->WHERE('hc.state_code', $_SESSION['login']['admin_for_id']);
        $this->db->ORDER_BY("hc.hc_name", "asc");

        $query = $this->db->get();
        return $query->result_array();
    }

    function get_eshtablishment_list_live($ref_m_distt_id) {
        $this->db->SELECT("*");
        $this->db->FROM('m_tbl_establishments est');
        $this->db->JOIN('efil.tbl_users', 'est.id=users.admin_for_id AND users.ref_m_usertype_id IN (' . USER_ADMIN . ',' . USER_ACTION_ADMIN . ')');
        $this->db->WHERE('ref_m_tbl_districts_id', $ref_m_distt_id);
        $this->db->WHERE('display', 'Y');
        $this->db->WHERE('users.is_active', 'TRUE');
        $this->db->WHERE('is_live', FALSE);

        $this->db->ORDER_BY("estname", "asc");

        $query = $this->db->get();

        return $query->result();
    }

    function update_hc_live_status($hc_id) {
        $data = array('is_live' => TRUE, 'go_live_by' => $_SESSION['login']['id'], 'go_live_by_ip' => $_SERVER['REMOTE_ADDR'], 'go_live_on' => date("Y-m-d H:i:s"));
        $this->db->WHERE('id', $hc_id);
        $this->db->UPDATE('m_tbl_high_courts', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_establishment_live_status($establishment) {
        $data = array('is_live' => TRUE, 'go_live_by' => $_SESSION['login']['id'], 'go_live_by_ip' => $_SERVER['REMOTE_ADDR'], 'go_live_on' => date("Y-m-d H:i:s"));
        $this->db->WHERE('est_code', $establishment);
        $this->db->UPDATE('m_tbl_establishments', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_establishment_payment_method_detail($est_code) {
        $this->db->SELECT("*");
        $this->db->FROM('m_tbl_establishments');
        $this->db->WHERE('est_code', $est_code);
        $this->db->WHERE('display', 'Y');

        $this->db->WHERE('is_live', FALSE);

        $this->db->ORDER_BY("estname", "asc");

        $query = $this->db->get();
        return $query->result();
    }

    function get_hc_payment_method_detail($hc_id) {
        $this->db->SELECT("*");
        $this->db->FROM('m_tbl_high_courts');
        $this->db->WHERE('id', $hc_id);
        $this->db->WHERE('is_active', 'TRUE');
        $this->db->WHERE('parent_hc_id', NULL);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_superadmin_high_court_list() {
        $this->db->SELECT("*");
        $this->db->FROM('m_tbl_high_courts');
        $this->db->WHERE('parent_hc_id', NULL);
        $this->db->WHERE('state_code', $_SESSION['login']['admin_for_id']);
        $this->db->ORDER_BY("hc_name", "asc");

        $query = $this->db->get();
        return $query->result_array();
    }

    function get_admin_users($account_status, $request_type) {
        $user_state_id = $_SESSION['login']['njdg_st_id'];
        $request_type = array(ACCOUNT_REQUEST_EXISTS_BUT_UPDATE, ACCOUNT_REQUEST_PRACTICE_PLACE);
        $account_status = array(ACCOUNT_STATUS_ACTIVE, ACCOUNT_STATUS_UPDATED);
        $request_status = array(ACCOUNT_REQUEST_PRACTICE_PLACE, ACCOUNT_REQUEST_EXISTS_BUT_NEW);
        $this->db_2->SELECT('u.id,u.ref_m_usertype_id,u.first_name,u.njdg_st_id,u.userid,u.emailid,u.created_datetime,
            u.moblie_number, adv_estab.adv_user_id,adv_estab.state_code ,
            adv_estab.state_name, adv_estab.dist_name,adv_estab.estab_name,adv_estab.estab_code,adv_estab.court_type');
        $this->db_2->FROM('users u');
        $this->db_2->JOIN('tbl_advocate_establishments adv_estab', 'adv_estab.state_code = ' . $user_state_id . ' and adv_estab.adv_user_id=u.id');
        $this->db_2->WHERE_IN('u.account_status', $account_status);
        //$this->db_2->WHERE('adv_estab.adv_user_id', $adv_user_id);
        $this->db_2->WHERE_IN('adv_estab.request_type', $request_type);
        $this->db_2->WHERE_IN('adv_estab.request_status', $request_status);
        $query = $this->db_2->get();
        return $query->result();
    }

    function deactivate_account($account_status, $user_id) {
        $this->db_2->SELECT('*');
        $this->db_2->WHERE('id', $user_id);
        $this->db_2->UPDATE('users', $account_status);
        if ($this->db_2->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

}
