<?php

namespace App\Models\Admin;
use CodeIgniter\Model;

class EfilingActionModel extends Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function transferCase($registration_id)
    {
        $this->db->transStart();
        $nums_data_update = array(
            'allocated_to' => 2660,
            'allocated_on' => date('Y-m-d H:i:s')
        );
        $builder = $this->db->table('efil.tbl_efiling_nums');
        $builder->WHERE('registration_id', $registration_id);
        $builder->WHERE('is_active', TRUE);
        $builder->UPDATE($nums_data_update);
        if ($this->db->affectedRows() > 0) {
            $data = array(
                'registration_id' => $registration_id,
                'admin_id' => 2660,
                'allocated_on' => date('Y-m-d H:i:s'),
                'updated_by' => $_SESSION['login']['id'],
                'updated_on' => date('Y-m-d H:i:s'),
                'update_ip' => getClientIP(),
                'reason_to_allocate' => NULL
            );
            $builder = $this->db->table('efil.tbl_efiling_allocation');
            $builder->INSERT($data);
            $this->db->transComplete();
        }
        if ($this->db->transStatus() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function approve_case($registration_id, $filing_type) {
        $this->db->transStart();
        $update_data = array(
            'deactivated_on' => date('Y-m-d H:i:s'),
            'is_active' => FALSE,
            'updated_by' => $_SESSION['login']['id'],
            'updated_by_ip' => getClientIP()
        );
        $builder = $this->db->table('efil.tbl_efiling_num_status');
        $builder->WHERE('registration_id', $registration_id);
        $builder->WHERE('is_active', TRUE);
        $builder->UPDATE($update_data);
        if ($this->db->affectedRows() > 0) {
            $checked_data = array('is_admin_checked' => TRUE);
            $builder1 = $this->db->table('efil.tbl_efiled_docs');
            $builder1->WHERE('registration_id', $registration_id);
            $builder1->UPDATE($checked_data);
            // if ($this->db->affectedRows() > 0) {
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
                $builder2 = $this->db->table('efil.tbl_efiling_num_status');
                $builder2->INSERT($insert_data);
                if ($this->db->insertID()) {
                    $initial_defect_exits = FALSE;
                    $initial_defects_update_status = FALSE;
                    $builder3 = $this->db->table('efil.tbl_initial_defects');
                    $builder3->SELECT('max(initial_defects_id) max_id');
                    $builder3->WHERE('registration_id', $registration_id);
                    $builder3->WHERE('is_defect_cured', TRUE);
                    $builder3->WHERE('is_approved', FALSE);
                    $query = $builder3->get();
                    $query_result = $query->getResult();
                    $initial_defect_max_id = $query_result[0]->max_id;
                    if ($initial_defect_max_id != '' && $initial_defect_max_id > 0) {
                        $initial_defect_exits = TRUE;
                        $update_defect_data = array(
                            'is_approved' => TRUE,
                            'approve_date' => date('Y-m-d H:i:s'),
                            'approved_by' => $_SESSION['login']['id']
                        );
                        $builder4 = $this->db->table('efil.tbl_initial_defects');
                        $builder4->WHERE('registration_id', $registration_id);
                        $builder4->WHERE('is_defect_cured', TRUE);
                        $builder4->WHERE('is_approved', FALSE);
                        $builder4->WHERE('initial_defects_id', $initial_defect_max_id);
                        $builder4->UPDATE($update_defect_data);
                        if ($this->db->affectedRows() > 0) {
                            $initial_defects_update_status = TRUE;
                        }
                    }
                    $builder5 = $this->db->table('efil.tbl_court_fee_payment');
                    $builder5->SELECT('count(id) cnt');
                    $builder5->WHERE('registration_id', $registration_id);
                    $builder5->WHERE('is_deleted', FALSE);
                    $builder5->WHERE('payment_verified_date', NULL);
                    $builder5->WHERE('payment_verified_by', NULL);
                    $query = $builder5->get();
                    $query_result = $query->getResult();
                    $crt_fee_payment_cnt = $query_result[0]->cnt;
                    $crt_fee_payment_exits = FALSE;
                    $crt_fee_payment_update_status = FALSE;
                    if ($crt_fee_payment_cnt > 0) {
                        $crt_fee_payment_exits = TRUE;
                        $fee_data = array(
                            'payment_verified_date' => date('Y-m-d H:i:s'),
                            'payment_verified_by' => $_SESSION['login']['id']
                        );
                        $builder6 = $this->db->table('efil.tbl_court_fee_payment');
                        $builder6->WHERE('registration_id', $registration_id);
                        $builder6->WHERE('payment_verified_by', NULL);
                        $builder6->WHERE('payment_verified_date', NULL);
                        $builder6->WHERE('is_deleted', FALSE);
                        $builder6->UPDATE($fee_data);
                        if ($this->db->affectedRows() > 0) {
                            $crt_fee_payment_update_status = TRUE;
                        }
                    }
                    if ($crt_fee_payment_exits && $crt_fee_payment_update_status && $initial_defect_exits && $initial_defects_update_status) {
                        $this->db->transComplete();
                    } elseif (!$crt_fee_payment_exits && !$crt_fee_payment_update_status && $initial_defect_exits && $initial_defects_update_status) {
                        $this->db->transComplete();
                    } elseif ($crt_fee_payment_exits && $crt_fee_payment_update_status) {
                        $this->db->transComplete();
                    } elseif (!$crt_fee_payment_exits && !$crt_fee_payment_update_status && !$initial_defect_exits && !$initial_defects_update_status) {
                        $this->db->transComplete();
                    }
                }
            // }
        }
        if ($this->db->transStatus() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function disapprove_case($registration_id, $remark) {
        $crt_fee_status = NULL;
        $def_crt_fee = NULL;
        if ($crt_fee_status == 3) {
            $remark .= "<br/><br/><br/>Court Fee Deficited By : " . $def_crt_fee . " Rs.";
        }
        $this->db->transStart();
        $update_data = array(
            'deactivated_on' => date('Y-m-d H:i:s'),
            'is_active' => FALSE,
            'updated_by' => $_SESSION['login']['id'],
            'updated_by_ip' => getClientIP()
        );
        $builder = $this->db->table('efil.tbl_efiling_num_status');
        $builder->WHERE('registration_id', $registration_id);
        $builder->WHERE('is_active', TRUE);
        $builder->UPDATE($update_data);
        if ($this->db->affectedRows() > 0) {
            $checked_data = array('is_admin_checked' => TRUE);
            $builder1 = $this->db->table('efil.tbl_efiled_docs');
            $builder1->WHERE('registration_id', $registration_id);
            $builder1->UPDATE($checked_data);
            // if ($this->db->affectedRows() > 0) {
            $insert_data = array(
                'registration_id' => $registration_id,
                'stage_id' => Initial_Defected_Stage,
                'activated_on' => date('Y-m-d H:i:s'),
                'is_active' => TRUE,
                'activated_by' => $_SESSION['login']['id'],
                'activated_by_ip' => getClientIP()
            );
            $builder2 = $this->db->table('efil.tbl_efiling_num_status');
            $builder2->INSERT($insert_data);
            if ($this->db->insertID()) {
                $initial_defect_exits = FALSE;
                $initial_defects_update_status = FALSE;
                $builder3 = $this->db->table('efil.tbl_initial_defects');
                $builder3->SELECT('max(initial_defects_id) max_id');
                $builder3->WHERE('registration_id', $registration_id);
                $builder3->WHERE('is_defect_cured', TRUE);
                $builder3->WHERE('is_approved', FALSE);
                $query = $builder3->get();
                // echo $this->db->last_query(); die;
                $query_result = $query->getResult();
                $initial_defect_max_id = $query_result[0]->max_id;
                if ($initial_defect_max_id != '' && $initial_defect_max_id > 0) {
                    $initial_defect_exits = TRUE;
                    $update_defect_data = array(
                        'is_approved' => TRUE,
                        'still_defective' => TRUE,
                        'approve_date' => date('Y-m-d H:i:s'),
                        'approved_by' => $_SESSION['login']['id']
                    );
                    $builder4 = $this->db->table('efil.tbl_initial_defects');
                    $builder4->WHERE('registration_id', $registration_id);
                    $builder4->WHERE('is_defect_cured', TRUE);
                    $builder4->WHERE('is_approved', FALSE);
                    $builder4->WHERE('initial_defects_id', $initial_defect_max_id);
                    $builder4->UPDATE($update_defect_data);
                    if ($this->db->affectedRows() > 0) {
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
                    $builder5 = $this->db->table('efil.tbl_initial_defects');
                    $builder5->INSERT($insert);
                    // echo $this->db->last_query(); die;
                    if ($this->db->insertID()) {
                        $initial_defects_insert_status = TRUE;
                    }
                    $builder6 = $this->db->table('efil.tbl_court_fee_payment');
                    $builder6->SELECT('max(id) max_id');
                    $builder6->WHERE('registration_id', $registration_id);
                    $builder6->WHERE('is_deleted', FALSE);
                    $query = $builder6->get();
                    $query_result = $query->getResult();
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
                            $builder7 = $this->db->table('efil.tbl_court_fee_payment');
                            $builder7->WHERE('registration_id', $registration_id);
                            $builder7->WHERE('id', $crt_fee_payment_max_id);
                            $builder7->WHERE('is_deleted', FALSE);
                            $builder7->UPDATE($fee_data);
                            if ($this->db->affectedRows() > 0) {
                                $crt_fee_payment_update_status = TRUE;
                            }
                            $crt_fee_payment_update_status = TRUE;
                        } elseif ($crt_fee_status == 2) {
                            if (!(bool) $_SESSION['estab_details']['enable_payment_gateway']) {
                                $fee_data = array(                                    
                                    'payment_verified_date' => date('Y-m-d H:i:s'),
                                    'payment_verified_by' => $_SESSION['login']['id']
                                );
                                $builder8 = $this->db->table('efil.tbl_court_fee_payment');
                                $builder8->WHERE('registration_id', $registration_id);
                                $builder8->WHERE('id', $crt_fee_payment_max_id);
                                $builder8->WHERE('is_deleted', FALSE);
                                $builder8->UPDATE($fee_data);
                                if ($this->db->affectedRows() > 0) {
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
                            $builder9 = $this->db->table('efil.tbl_court_fee_payment');
                            $builder9->WHERE('registration_id', $registration_id);
                            $builder9->WHERE('is_deleted', FALSE);
                            $builder9->WHERE('id', $crt_fee_payment_max_id);
                            $builder9->UPDATE($fee_data);
                            if ($this->db->affectedRows() > 0) {
                                $crt_fee_payment_update_status = TRUE;
                            }
                        }
                    }
                    if ($crt_fee_payment_exits && $crt_fee_payment_update_status && $initial_defect_exits && $initial_defects_update_status && $initial_defects_insert_status) {
                        $this->db->transComplete();
                    } elseif (!$crt_fee_payment_exits && !$crt_fee_payment_update_status && $initial_defect_exits && $initial_defects_update_status && $initial_defects_insert_status) {
                        $this->db->transComplete();
                    } elseif ($crt_fee_payment_exits && $crt_fee_payment_update_status && !$initial_defect_exits && !$initial_defects_update_status && $initial_defects_insert_status) {
                        $this->db->transComplete();
                    } elseif (!$crt_fee_payment_exits && !$crt_fee_payment_update_status && !$initial_defect_exits && !$initial_defects_update_status && $initial_defects_insert_status) {
                        $this->db->transComplete();
                    }
                }
            }
        }
        if ($this->db->transStatus() === FALSE) {
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
            $builder = $this->db->table('efil.tbl_efiling_num_status');
            $builder->WHERE('registration_id', $registration_id);
            $builder->WHERE('is_active', TRUE);
            $builder->UPDATE($update_data);
            $insert_data = array(
                'registration_id' => $registration_id,
                'stage_id' => MARK_AS_ERROR,
                'activated_on' => date('Y-m-d H:i:s'),
                'is_active' => TRUE,
                'activated_by' => $_SESSION['login']['id'],
                'activated_by_ip' => getClientIP()
            );
            $builder->INSERT($insert_data);
            $insert = array(
                'registration_id' => $registration_id,
                'defect_remark' => $remark,
                'defect_date' => date('Y-m-d H:i:s'),
                'is_active' => TRUE,
                'updated_by' => $_SESSION['login']['id'],
                'ip_address' => getClientIP()
            );
            $builder1 = $this->db->table('efil.tbl_initial_defects');
            $builder1->INSERT($insert);
            if ($this->db->insertID()) {
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
        $this->db->transStart();
        $builder = $this->db->table('efil.tbl_mentioning_orders');
        $builder->INSERT($insert_data);
        if ($this->db->insertID()) {
            $status = $this->updateCaseStatus($regid, MENTIONING_E_FILED);
            if ($status) {
                $this->db->transComplete();
            }
        }
        if ($this->db->transStatus() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function transfer_to_section($registration_id, $stage_id) {
        $this->db->transStart();
        $update_data = array(
            'deactivated_on' => date('Y-m-d H:i:s'),
            'is_active' => FALSE,
            'updated_by' => $_SESSION['login']['id'],
            'updated_by_ip' => getClientIP()
        );
        $builder = $this->db->table('efil.tbl_efiling_num_status');
        $builder->WHERE('registration_id', $registration_id);
        $builder->WHERE('is_active', TRUE);
        $builder->UPDATE($update_data);
        $insert_data = array(
            'registration_id' => $registration_id,
            'stage_id' => $stage_id,
            'activated_on' => date('Y-m-d H:i:s'),
            'is_active' => TRUE,
            'activated_by' => $_SESSION['login']['id'],
            'activated_by_ip' => getClientIP()
        );
        if ($this->db->affectedRows() > 0) {
            $builder = $this->db->table('efil.tbl_efiling_num_status');
            $builder->INSERT($insert_data);
            if ($this->db->insertID()) {
                $this->db->transComplete();
            }
        }
        if ($this->db->transStatus() === FALSE) {
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
        $builder = $this->db->table('efil.tbl_efiling_num_status');
        $builder->WHERE('registration_id', $registration_id);
        $builder->WHERE('is_active', TRUE);
        $builder->UPDATE($update_data);
        if ($this->db->affectedRows() > 0) {
            $insert_data = array(
                'registration_id' => $registration_id,
                'stage_id' => $next_stage,
                'activated_on' => date('Y-m-d H:i:s'),
                'is_active' => TRUE,
                'activated_by' => $_SESSION['login']['id'],
                'activated_by_ip' => getClientIP()
            );
            $builder = $this->db->table('efil.tbl_efiling_num_status');
            $builder->INSERT($insert_data);
            if ($this->db->insertID()) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    function get_efiled_by_user($user_id) {
        $builder = $this->db->table('efil.tbl_users');
        $builder->SELECT('id,ref_m_usertype_id,first_name, last_name, moblie_number, emailid');
        $builder->WHERE('id', $user_id);
        $query = $builder->get();
        if ($query->getNumRows()) {
            $result = $query->getResult();
            return $result;
        } else {
            return false;
        }
    }

    function get_current_stage($registration_id) {
        $builder = $this->db->table('efil.tbl_efiling_num_status');
        $builder->SELECT('registration_id, efil.tbl_efiling_num_status.stage_id, m_tbl_dashboard_stages.user_stage_name, m_tbl_dashboard_stages.admin_stage_name');
        $builder->JOIN('efil.m_tbl_dashboard_stages', 'm_tbl_dashboard_stages.stage_id =  efil.tbl_efiling_num_status.stage_id');
        $builder->WHERE('efil.tbl_efiling_num_status.registration_id', $registration_id);
        $builder->WHERE(' efil.tbl_efiling_num_status.is_active', TRUE);
        $builder->orderBy(' efil.tbl_efiling_num_status.status_id', 'DESC');
        $builder->LIMIT(1);
        $query = $builder->get();
        if ($query->getNumRows() >= 1) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    function attach_doc($diary_no,$doc_id,$attach_with_doc_id) {
        $nums_data_update = array(
            'attached_with_doc_id' => $attach_with_doc_id,
            'attached_on' => date('Y-m-d H:i:s')
        );
        $builder = $this->db->table('efil.tbl_efiled_docs');
        $builder->where('doc_id',$doc_id);
        $builder->WHERE('is_active', TRUE);
        $builder->UPDATE($nums_data_update);
        if ($this->db->affectedRows() > 0) {
            return $this->db->affectedRows();
        }
        else{
            return false;
        }
    }

    function hold_case($registration_id, $filing_type) {
        $this->db->transStart();
        $update_data = array(
            'deactivated_on' => date('Y-m-d H:i:s'),
            'is_active' => FALSE,
            'updated_by' => $_SESSION['login']['id'],
            'updated_by_ip' => getClientIP()
        );
        $builder = $this->db->table('efil.tbl_efiling_num_status');
        $builder->WHERE('registration_id', $registration_id);
        $builder->WHERE('is_active', TRUE);
        $builder->UPDATE($update_data);
        if ($this->db->affectedRows() > 0) {
            $checked_data = array('is_admin_checked' => TRUE);
            $builder = $this->db->table('efil.tbl_efiled_docs');
            $builder->WHERE('registration_id', $registration_id);
            $builder->UPDATE($checked_data);
            // if ($this->db->affectedRows() > 0) {
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
                $builder1 = $this->db->table('efil.tbl_efiling_num_status');
                $builder1->INSERT($insert_data);
                if ($this->db->insertID()) {
                    $this->db->transComplete();
                }
            // }
        }
        if ($this->db->transStatus() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function disposed_case($registration_id, $filing_type) {
        $this->db->transStart();
        $update_data = array(
            'deactivated_on' => date('Y-m-d H:i:s'),
            'is_active' => FALSE,
            'updated_by' => $_SESSION['login']['id'],
            'updated_by_ip' => getClientIP()
        );
        $builder = $this->db->table('efil.tbl_efiling_num_status');
        $builder->WHERE('registration_id', $registration_id);
        $builder->WHERE('is_active', TRUE);
        $builder->UPDATE($update_data);
        if ($this->db->affectedRows() > 0) {
            $checked_data = array('is_admin_checked' => TRUE);
            $builder = $this->db->table('efil.tbl_efiled_docs');
            $builder->WHERE('registration_id', $registration_id);
            $builder->UPDATE($checked_data);
            // if ($this->db->affectedRows() > 0) {
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
                $builder1 = $this->db->table('efil.tbl_efiling_num_status');
                $builder1->INSERT($insert_data);
                if ($this->db->insertID()) {
                    $this->db->transComplete();
                }
            // }
        }
        if ($this->db->transStatus() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function no_action($doc_id) {
        $nums_data_update = array(
            'attached_with_doc_id' => $doc_id,
            'attached_on' => date('Y-m-d H:i:s')
        );
        $builder = $this->db->table('efil.tbl_efiled_docs');
        $builder->where('doc_id',$doc_id);
        $builder->WHERE('is_active', TRUE);
        $builder->UPDATE($nums_data_update);
        if ($this->db->affectedRows() > 0) {
            return $this->db->affectedRows();
        } else {
            return false;
        }
    }

}