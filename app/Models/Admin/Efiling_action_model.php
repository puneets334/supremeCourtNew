<?php

namespace App\Models\Admin;
use CodeIgniter\Model;

class Efiling_action_model extends Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    function transferCase($registration_id)
    {
        $this->db->trans_start();
        $nums_data_update = array(
            'allocated_to' => 2660,
            'allocated_on' => date('Y-m-d H:i:s'));

        $this->db->WHERE('registration_id', $registration_id);
        $this->db->WHERE('is_active', TRUE);
        $this->db->UPDATE('efil.tbl_efiling_nums', $nums_data_update);
        if ($this->db->affected_rows() > 0) {

            $data = array('registration_id' => $registration_id,
                'admin_id' => 2660,
                'allocated_on' => date('Y-m-d H:i:s'),
                'updated_by' => $_SESSION['login']['id'],
                'updated_on' => date('Y-m-d H:i:s'),
                'update_ip' => getClientIP(),
                'reason_to_allocate' => NULL);

            $this->db->INSERT('efil.tbl_efiling_allocation', $data);
            $this->db->trans_complete();
        }
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function approve_case($registration_id, $filing_type) {
        $this->db->trans_start();
        $update_data = array(
            'deactivated_on' => date('Y-m-d H:i:s'),
            'is_active' => FALSE,
            'updated_by' => $_SESSION['login']['id'],
            'updated_by_ip' => getClientIP()
        );

        $this->db->WHERE('registration_id', $registration_id);
        $this->db->WHERE('is_active', TRUE);
        $this->db->UPDATE('efil.tbl_efiling_num_status', $update_data);
        if ($this->db->affected_rows() > 0) {
            $checked_data = array('is_admin_checked' => TRUE);
            $this->db->WHERE('registration_id', $registration_id);
            $this->db->UPDATE('efil.tbl_efiled_docs', $checked_data);

//if ($this->db->affected_rows() > 0) {

            $next_stage = '';
            if ($filing_type == E_FILING_TYPE_NEW_CASE || $filing_type == E_FILING_TYPE_CDE || $filing_type == E_FILING_TYPE_JAIL_PETITION) {
                $next_stage = Transfer_to_IB_Stage;
            } elseif ($filing_type == E_FILING_TYPE_MISC_DOCS) {
                $next_stage = Transfer_to_IB_Stage;
            } elseif ($filing_type == E_FILING_TYPE_DEFICIT_COURT_FEE) {
                $next_stage = Transfer_to_IB_Stage;
            } elseif ($filing_type == E_FILING_TYPE_IA) {
                $next_stage = Transfer_to_IB_Stage;
            } elseif ($filing_type == E_FILING_TYPE_CAVEAT) {
                $next_stage = Transfer_to_IB_Stage;
            }
            $insert_data = array(
                'registration_id' => $registration_id,
                'stage_id' => $next_stage,
                'activated_on' => date('Y-m-d H:i:s'),
                'is_active' => TRUE,
                'activated_by' => $_SESSION['login']['id'],
                'activated_by_ip' => getClientIP()
            );
            $this->db->INSERT('efil.tbl_efiling_num_status', $insert_data);
            if ($this->db->insert_id()) {

                $initial_defect_exits = FALSE;
                $initial_defects_update_status = FALSE;

                $this->db->SELECT('max(initial_defects_id) max_id');
                $this->db->FROM('efil.tbl_initial_defects');
                $this->db->WHERE('registration_id', $registration_id);
                $this->db->WHERE('is_defect_cured', TRUE);
                $this->db->WHERE('is_approved', FALSE);
                $query = $this->db->get();
                $query_result = $query->result();
                $initial_defect_max_id = $query_result[0]->max_id;

                if ($initial_defect_max_id != '' && $initial_defect_max_id > 0) {

                    $initial_defect_exits = TRUE;

                    $update_defect_data = array(
                        'is_approved' => TRUE,
                        'approve_date' => date('Y-m-d H:i:s'),
                        'approved_by' => $_SESSION['login']['id']
                    );
                    $this->db->WHERE('registration_id', $registration_id);
                    $this->db->WHERE('is_defect_cured', TRUE);
                    $this->db->WHERE('is_approved', FALSE);
                    $this->db->WHERE('initial_defects_id', $initial_defect_max_id);
                    $this->db->UPDATE('efil.tbl_initial_defects', $update_defect_data);
                    if ($this->db->affected_rows() > 0) {
                        $initial_defects_update_status = TRUE;
                    }
                }

                $this->db->SELECT('count(id) cnt');
                $this->db->FROM('efil.tbl_court_fee_payment');
                $this->db->WHERE('registration_id', $registration_id);
                $this->db->WHERE('is_deleted', FALSE);
                $this->db->WHERE('payment_verified_date', NULL);
                $this->db->WHERE('payment_verified_by', NULL);
                $query = $this->db->get();

                $query_result = $query->result();
                $crt_fee_payment_cnt = $query_result[0]->cnt;

                $crt_fee_payment_exits = FALSE;
                $crt_fee_payment_update_status = FALSE;

                if ($crt_fee_payment_cnt > 0) {
                    $crt_fee_payment_exits = TRUE;
                    $fee_data = array(
                        'payment_verified_date' => date('Y-m-d H:i:s'),
                        'payment_verified_by' => $_SESSION['login']['id']
                    );
                    $this->db->WHERE('registration_id', $registration_id);
                    $this->db->WHERE('payment_verified_by', NULL);
                    $this->db->WHERE('payment_verified_date', NULL);
                    $this->db->WHERE('is_deleted', FALSE);
                    $this->db->UPDATE('efil.tbl_court_fee_payment', $fee_data);
                    if ($this->db->affected_rows() > 0) {
                        $crt_fee_payment_update_status = TRUE;
                    }
                }
                if ($crt_fee_payment_exits && $crt_fee_payment_update_status && $initial_defect_exits && $initial_defects_update_status) {
                    $this->db->trans_complete();
                } elseif (!$crt_fee_payment_exits && !$crt_fee_payment_update_status && $initial_defect_exits && $initial_defects_update_status) {
                    $this->db->trans_complete();
                } elseif ($crt_fee_payment_exits && $crt_fee_payment_update_status) {
                    $this->db->trans_complete();
                } elseif (!$crt_fee_payment_exits && !$crt_fee_payment_update_status && !$initial_defect_exits && !$initial_defects_update_status) {
                    $this->db->trans_complete();
                }
            }
// }
        }
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function disapprove_case($registration_id, $remark) {
        if ($crt_fee_status == 3) {
            $remark .= "<br/><br/><br/>Court Fee Deficited By : " . $def_crt_fee . " Rs.";
        }
        $this->db->trans_start();
        $update_data = array(
            'deactivated_on' => date('Y-m-d H:i:s'),
            'is_active' => FALSE,
            'updated_by' => $_SESSION['login']['id'],
            'updated_by_ip' => getClientIP()
        );

        $this->db->WHERE('registration_id', $registration_id);
        $this->db->WHERE('is_active', TRUE);
        $this->db->UPDATE('efil.tbl_efiling_num_status', $update_data);

        if ($this->db->affected_rows() > 0) {

            $checked_data = array('is_admin_checked' => TRUE);
            $this->db->WHERE('registration_id', $registration_id);
            $this->db->UPDATE('efil.tbl_efiled_docs', $checked_data);

//if ($this->db->affected_rows() > 0) {

            $insert_data = array(
                'registration_id' => $registration_id,
                'stage_id' => Initial_Defected_Stage,
                'activated_on' => date('Y-m-d H:i:s'),
                'is_active' => TRUE,
                'activated_by' => $_SESSION['login']['id'],
                'activated_by_ip' => getClientIP()
            );
            $this->db->INSERT('efil.tbl_efiling_num_status', $insert_data);

            if ($this->db->insert_id()) {

                $initial_defect_exits = FALSE;
                $initial_defects_update_status = FALSE;

                $this->db->SELECT('max(initial_defects_id) max_id');
                $this->db->FROM('efil.tbl_initial_defects');
                $this->db->WHERE('registration_id', $registration_id);
                $this->db->WHERE('is_defect_cured', TRUE);
                $this->db->WHERE('is_approved', FALSE);

                $query = $this->db->get();
                //echo  $this->db->last_query(); die;
                $query_result = $query->result();
                $initial_defect_max_id = $query_result[0]->max_id;

                if ($initial_defect_max_id != '' && $initial_defect_max_id > 0) {

                    $initial_defect_exits = TRUE;

                    $update_defect_data = array(
                        'is_approved' => TRUE,
                        'still_defective' => TRUE,
                        'approve_date' => date('Y-m-d H:i:s'),
                        'approved_by' => $_SESSION['login']['id']
                    );
                    $this->db->WHERE('registration_id', $registration_id);
                    $this->db->WHERE('is_defect_cured', TRUE);
                    $this->db->WHERE('is_approved', FALSE);
                    $this->db->WHERE('initial_defects_id', $initial_defect_max_id);
                    $this->db->UPDATE('efil.tbl_initial_defects', $update_defect_data);
                    if ($this->db->affected_rows() > 0) {
                        $initial_defects_update_status = TRUE;
                    }
                }

                $initial_defects_insert_status = FALSE;
                if (($initial_defect_exits && $initial_defects_update_status) || (!$initial_defect_exits && !$initial_defects_update_status)) {

                    $insert = array(
                        'registration_id' => $registration_id,
                        'defect_remark' => $remark,
                        'defect_date' => date('Y-m-d H:i:s'),
                        'is_active' => TRUE,
                        'updated_by' => $_SESSION['login']['id'],
                        'ip_address' => getClientIP()
                    );
                    $this->db->INSERT('efil.tbl_initial_defects', $insert);
                    //echo $this->db->last_query();die;
                    if ($this->db->insert_id()) {

                        $initial_defects_insert_status = TRUE;
                    }
                    $this->db->SELECT('max(id) max_id');
                    $this->db->FROM('efil.tbl_court_fee_payment');
                    $this->db->WHERE('registration_id', $registration_id);
                    $this->db->WHERE('is_deleted', FALSE);
                    $query = $this->db->get();
                    $query_result = $query->result();
                    $crt_fee_payment_max_id = $query_result[0]->max_id;

                    $crt_fee_payment_exits = FALSE;
                    $crt_fee_payment_update_status = FALSE;
                    if ($crt_fee_payment_max_id != '' && $crt_fee_payment_max_id > 0) {

                        $crt_fee_payment_exits = TRUE;

                        if ($crt_fee_status == 1 || $crt_fee_status == '') {
                            $fee_data = array(
                                'payment_verified_date' => date('Y-m-d H:i:s'),
                                'payment_verified_by' => $_SESSION['login']['id']
                                
                            );
                            $this->db->WHERE('registration_id', $registration_id);
                            $this->db->WHERE('id', $crt_fee_payment_max_id);
                            $this->db->WHERE('is_deleted', FALSE);
                            $this->db->UPDATE('efil.tbl_court_fee_payment', $fee_data);
                            if ($this->db->affected_rows() > 0) {
                                $crt_fee_payment_update_status = TRUE;
                            }
                            $crt_fee_payment_update_status = TRUE;
                        } elseif ($crt_fee_status == 2) {

                            if (!(bool) $_SESSION['estab_details']['enable_payment_gateway']) {
                                $fee_data = array(                                    
                                    'payment_verified_date' => date('Y-m-d H:i:s'),
                                    'payment_verified_by' => $_SESSION['login']['id']
                                );
                                $this->db->WHERE('registration_id', $registration_id);

                                $this->db->WHERE('id', $crt_fee_payment_max_id);
                                $this->db->WHERE('is_deleted', FALSE);
                                $this->db->UPDATE('efil.tbl_court_fee_payment', $fee_data);
                                if ($this->db->affected_rows() > 0) {
                                    $crt_fee_payment_update_status = TRUE;
                                }
                            }
                        } elseif ($crt_fee_status == 3) {

                            $fee_data = array(
                                'is_payment_defecit' => TRUE,
                                'defecit_court_fee' => $def_crt_fee,
                                'payment_verified_date' => date('Y-m-d H:i:s'),
                                'payment_verified_by' => $_SESSION['login']['id']
                            );
                            $this->db->WHERE('registration_id', $registration_id);
                            $this->db->WHERE('is_deleted', FALSE);

                            $this->db->WHERE('id', $crt_fee_payment_max_id);
                            $this->db->UPDATE('efil.tbl_court_fee_payment', $fee_data);

                            if ($this->db->affected_rows() > 0) {
                                $crt_fee_payment_update_status = TRUE;
                            }
                        }
                    }
                    if ($crt_fee_payment_exits && $crt_fee_payment_update_status && $initial_defect_exits && $initial_defects_update_status && $initial_defects_insert_status) {
                        $this->db->trans_complete();
                    } elseif (!$crt_fee_payment_exits && !$crt_fee_payment_update_status && $initial_defect_exits && $initial_defects_update_status && $initial_defects_insert_status) {
                        $this->db->trans_complete();
                    } elseif ($crt_fee_payment_exits && $crt_fee_payment_update_status && !$initial_defect_exits && !$initial_defects_update_status && $initial_defects_insert_status) {
                        $this->db->trans_complete();
                    } elseif (!$crt_fee_payment_exits && !$crt_fee_payment_update_status && !$initial_defect_exits && !$initial_defects_update_status && $initial_defects_insert_status) {
                        $this->db->trans_complete();
                    }
                }
            }
        }
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    function markAsErrorCaseByAdmin($registration_id, $remark) {
        $output = false;
        if(isset($registration_id) && !empty($registration_id) && isset($remark) && !empty($remark)){
            $update_data = array(
                'deactivated_on' => date('Y-m-d H:i:s'),
                'is_active' => FALSE,
                'updated_by' => $_SESSION['login']['id'],
                'updated_by_ip' => getClientIP()
            );
            $this->db->WHERE('registration_id', $registration_id);
            $this->db->WHERE('is_active', TRUE);
            $this->db->UPDATE('efil.tbl_efiling_num_status', $update_data);
            $insert_data = array(
                'registration_id' => $registration_id,
                'stage_id' => MARK_AS_ERROR,
                'activated_on' => date('Y-m-d H:i:s'),
                'is_active' => TRUE,
                'activated_by' => $_SESSION['login']['id'],
                'activated_by_ip' => getClientIP()
            );
            $this->db->INSERT('efil.tbl_efiling_num_status', $insert_data);
            $insert = array(
                'registration_id' => $registration_id,
                'defect_remark' => $remark,
                'defect_date' => date('Y-m-d H:i:s'),
                'is_active' => TRUE,
                'updated_by' => $_SESSION['login']['id'],
                'ip_address' => getClientIP()
            );
             $this->db->INSERT('efil.tbl_initial_defects', $insert);
            if ($this->db->insert_id()) {
                $output = TRUE;
            }
            else{
                $output =  FALSE;
            }
        }
        return $output;
    }

    function submit_mentioning_order($regid, $remark) {

        $insert_data = array(
            'registration_id' => $regid,
            'order_text' => $remark,
            'uploaded_by' => $_SESSION['login']['id'],
            'uploaded_on' => date('Y-m-d H:i:s'),
            'upload_ip_address' => getClientIP()
        );

        $this->db->trans_start();
        $this->db->INSERT('efil.tbl_mentioning_orders', $insert_data);

        if ($this->db->insert_id()) {

            $status = $this->updateCaseStatus($regid, MENTIONING_E_FILED);
            if ($status) {
                $this->db->trans_complete();
            }
        }

        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function transfer_to_section($registration_id, $stage_id) {
        $this->db->trans_start();
        $update_data = array(
            'deactivated_on' => date('Y-m-d H:i:s'),
            'is_active' => FALSE,
            'updated_by' => $_SESSION['login']['id'],
            'updated_by_ip' => getClientIP()
        );

        $this->db->WHERE('registration_id', $registration_id);
        $this->db->WHERE('is_active', TRUE);
        $this->db->UPDATE('efil.tbl_efiling_num_status', $update_data);
        $insert_data = array(
            'registration_id' => $registration_id,
            'stage_id' => $stage_id,
            'activated_on' => date('Y-m-d H:i:s'),
            'is_active' => TRUE,
            'activated_by' => $_SESSION['login']['id'],
            'activated_by_ip' => getClientIP()
        );

        if ($this->db->affected_rows() > 0) {
            $this->db->INSERT('efil.tbl_efiling_num_status', $insert_data);
            if ($this->db->insert_id()) {
                $this->db->trans_complete();
            }
        }

        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function updateCaseStatus($registration_id, $next_stage) {

        $update_data = array(
            'deactivated_on' => date('Y-m-d H:i:s'),
            'is_active' => FALSE,
            'updated_by' => $_SESSION['login']['id'],
            'updated_by_ip' => getClientIP()
        );

        $this->db->WHERE('registration_id', $registration_id);
        $this->db->WHERE('is_active', TRUE);
        $this->db->UPDATE('efil.tbl_efiling_num_status', $update_data);
        if ($this->db->affected_rows() > 0) {

            $insert_data = array(
                'registration_id' => $registration_id,
                'stage_id' => $next_stage,
                'activated_on' => date('Y-m-d H:i:s'),
                'is_active' => TRUE,
                'activated_by' => $_SESSION['login']['id'],
                'activated_by_ip' => getClientIP()
            );
            $this->db->INSERT('efil.tbl_efiling_num_status', $insert_data);
            if ($this->db->insert_id()) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    function get_efiled_by_user($user_id) {
        
        $this->db->SELECT('id,ref_m_usertype_id,first_name, last_name, moblie_number, emailid');
        $this->db->FROM('efil.tbl_users');
        $this->db->WHERE('id', $user_id);
        $query = $this->db->get();
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }

    function get_current_stage($registration_id) {
        $this->db->SELECT('registration_id, efil.tbl_efiling_num_status.stage_id, m_tbl_dashboard_stages.user_stage_name, m_tbl_dashboard_stages.admin_stage_name');
        $this->db->FROM('efil.tbl_efiling_num_status');
        $this->db->JOIN('efil.m_tbl_dashboard_stages', 'm_tbl_dashboard_stages.stage_id =  efil.tbl_efiling_num_status.stage_id');
        $this->db->WHERE('efil.tbl_efiling_num_status.registration_id', $registration_id);
        $this->db->WHERE(' efil.tbl_efiling_num_status.is_active', TRUE);
        $this->db->ORDER_BY(' efil.tbl_efiling_num_status.status_id', 'DESC');
        $this->db->LIMIT(1);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    function attach_doc($diary_no,$doc_id,$attach_with_doc_id){
        $nums_data_update = array(
            'attached_with_doc_id' => $attach_with_doc_id,
            'attached_on' => date('Y-m-d H:i:s'));

        $this->db->where('doc_id',$doc_id);
        $this->db->WHERE('is_active', TRUE);
        $this->db->UPDATE('efil.tbl_efiled_docs', $nums_data_update);
        if ($this->db->affected_rows() > 0) {
            return $this->db->affected_rows();
        }
        else{
            return false;
        }
    }
    function hold_case($registration_id, $filing_type) {
        $this->db->trans_start();
        $update_data = array(
            'deactivated_on' => date('Y-m-d H:i:s'),
            'is_active' => FALSE,
            'updated_by' => $_SESSION['login']['id'],
            'updated_by_ip' => getClientIP()
        );

        $this->db->WHERE('registration_id', $registration_id);
        $this->db->WHERE('is_active', TRUE);
        $this->db->UPDATE('efil.tbl_efiling_num_status', $update_data);
        if ($this->db->affected_rows() > 0) {
            $checked_data = array('is_admin_checked' => TRUE);
            $this->db->WHERE('registration_id', $registration_id);
            $this->db->UPDATE('efil.tbl_efiled_docs', $checked_data);

//if ($this->db->affected_rows() > 0) {

            $next_stage = '';
            if ($filing_type == E_FILING_TYPE_NEW_CASE || $filing_type == E_FILING_TYPE_CDE || $filing_type == E_FILING_TYPE_JAIL_PETITION) {
                $next_stage = HOLD;
            } elseif ($filing_type == E_FILING_TYPE_MISC_DOCS) {
                $next_stage = HOLD;
            } elseif ($filing_type == E_FILING_TYPE_DEFICIT_COURT_FEE) {
                $next_stage = HOLD;
            } elseif ($filing_type == E_FILING_TYPE_IA) {
                $next_stage = HOLD;
            } elseif ($filing_type == E_FILING_TYPE_CAVEAT) {
                $next_stage = HOLD;
            }
            $insert_data = array(
                'registration_id' => $registration_id,
                'stage_id' => $next_stage,
                'activated_on' => date('Y-m-d H:i:s'),
                'is_active' => TRUE,
                'activated_by' => $_SESSION['login']['id'],
                'activated_by_ip' => getClientIP()
            );
            $this->db->INSERT('efil.tbl_efiling_num_status', $insert_data);
            if ($this->db->insert_id()) {

                   $this->db->trans_complete();
            }
// }
        }
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    function disposed_case($registration_id, $filing_type) {
        $this->db->trans_start();
        $update_data = array(
            'deactivated_on' => date('Y-m-d H:i:s'),
            'is_active' => FALSE,
            'updated_by' => $_SESSION['login']['id'],
            'updated_by_ip' => getClientIP()
        );

        $this->db->WHERE('registration_id', $registration_id);
        $this->db->WHERE('is_active', TRUE);
        $this->db->UPDATE('efil.tbl_efiling_num_status', $update_data);
        if ($this->db->affected_rows() > 0) {
            $checked_data = array('is_admin_checked' => TRUE);
            $this->db->WHERE('registration_id', $registration_id);
            $this->db->UPDATE('efil.tbl_efiled_docs', $checked_data);

//if ($this->db->affected_rows() > 0) {

            $next_stage = '';
            if ($filing_type == E_FILING_TYPE_NEW_CASE || $filing_type == E_FILING_TYPE_CDE || $filing_type == E_FILING_TYPE_JAIL_PETITION) {
                $next_stage = DISPOSED;
            } elseif ($filing_type == E_FILING_TYPE_MISC_DOCS) {
                $next_stage = DISPOSED;
            } elseif ($filing_type == E_FILING_TYPE_DEFICIT_COURT_FEE) {
                $next_stage = DISPOSED;
            } elseif ($filing_type == E_FILING_TYPE_IA) {
                $next_stage = DISPOSED;
            } elseif ($filing_type == E_FILING_TYPE_CAVEAT) {
                $next_stage = DISPOSED;
            }
            $insert_data = array(
                'registration_id' => $registration_id,
                'stage_id' => $next_stage,
                'activated_on' => date('Y-m-d H:i:s'),
                'is_active' => TRUE,
                'activated_by' => $_SESSION['login']['id'],
                'activated_by_ip' => getClientIP()
            );
            $this->db->INSERT('efil.tbl_efiling_num_status', $insert_data);
            if ($this->db->insert_id()) {

                $this->db->trans_complete();
            }
// }
        }
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    function no_action($doc_id){
        $nums_data_update = array(
            'attached_with_doc_id' => $doc_id,
            'attached_on' => date('Y-m-d H:i:s'));

        $this->db->where('doc_id',$doc_id);
        $this->db->WHERE('is_active', TRUE);
        $this->db->UPDATE('efil.tbl_efiled_docs', $nums_data_update);
        if ($this->db->affected_rows() > 0) {
            return $this->db->affected_rows();
        }
        else{
            return false;
        }
    }
}

?>
