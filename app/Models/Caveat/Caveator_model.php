<?php

namespace App\Models\Caveat;
use CodeIgniter\Model;

class Caveator_model extends Model {
	protected $session;
	
    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $db      = \Config\Database::connect();
		$this->session = \Config\Services::session();
    }


//     function add_caveators($data, $petmobile, $pet_email, $cis_masters_values) {
//         if (isset($_SESSION['estab_details']['hc_code'])) {
//             $est_code = $_SESSION['estab_details']['hc_code'];
//         } else {
//             //$est_code = $_SESSION['estab_details']['est_code'];
//             $est_code = $_SESSION['estab_details']['estab_code'];

//         }
//         $curr_dt_time = date('Y-m-d H:i:s');
//         if (empty($est_code)) {
//             return FALSE;
//         }
//         $result = $this->gen_efiling_number();
//         $num_pre_fix = "EK";
//         $filing_type = E_FILING_TYPE_CAVEAT;
//         $stage_id = Draft_Stage;
//         if ($result) {
//             if ($_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
//                 $created_by = 0;
//                 $sub_created_by = $_SESSION['login']['id'];
//             } else {
//                 $created_by = $_SESSION['login']['id'];
//                 $sub_created_by = 0;
//             }

//             $efiling = sprintf("%'.05d\n", $result['efiling_num']);
//             $string = $num_pre_fix . $est_code . $efiling . $result['efiling_year'];
//             $efiling_num = preg_replace('/\s+/', '', $string);
//             $efiling_num_data = array('efiling_no' => $efiling_num,
//                 'efiling_year' => $result['efiling_year'],
//                 'efiling_for_type_id' => $_SESSION['efiling_for_details']['efiling_for_type_id'],
//                 'efiling_for_id' => $_SESSION['efiling_for_details']['efiling_for_id'],
//                 'ref_m_efiled_type_id' => $filing_type,
//                 'efiling_for_type_id'=>E_FILING_TYPE_CAVEAT,
//                 'efiling_for_id'=>1,
//                 'created_by' => $created_by,
//                 'create_on' => $curr_dt_time,
//                 'create_by_ip' => $_SERVER['REMOTE_ADDR'],
//                 'sub_created_by' => $sub_created_by
//             );
//             $result['registration_id'] = $this->add_efiling_nums($efiling_num_data);
//             if (isset($result['registration_id']) && !empty($result['registration_id'])) {
//                 $data['ref_m_efiling_nums_registration_id'] = $result['registration_id'];
//                 $result = array('registration_id' => $result['registration_id'], 'efiling_no' => $efiling_num,'stage_id'=>Draft_Stage,'ref_m_efiled_type_id'=>E_FILING_TYPE_CAVEAT);
//                 $this->session->set_userdata('efiling_details', $result);
//                 if (!empty($_SESSION['efiling_for_details']['adv_code']) && !empty($_SESSION['efiling_for_details']['adv_name'])) {
//                     $data['pet_adv_cd'] = $_SESSION['efiling_for_details']['adv_code'];
//                     $data['pet_adv'] = $_SESSION['efiling_for_details']['adv_name'];
//                     $data['pet_inperson'] = NULL;
//                 } else {
//                     $data['pet_inperson'] = 'Y';
//                 }
//                 $this->db->INSERT('tbl_efiling_caveat', $data);
//                 if ($this->db->insert_id()) {

// //                    $success = $this->update_cis_master_values($result['registration_id'], $cis_masters_values);
// //                    if ($success) {
//                         $data3 = array(
//                             'registration_id' => $result['registration_id'],
//                             'stage_id' => $stage_id,
//                             'activated_on' => $curr_dt_time,
//                             'activated_by' => $this->session->userdata['login']['id'],
//                             'activated_by_ip' => $_SERVER['REMOTE_ADDR'],
//                         );
//                         $this->db->INSERT('tbl_efiling_case_status', $data3);
//                         if ($this->db->insert_id()) {
//                             $status = $this->update_breadcrumbs($result['registration_id'], CAVEAT_BREAD_CAVEATOR);
//                             if ($status) {
//                                 // UPDATE CASE STAGE IN EFILING NUM STATUS TABLE
//                                 $this->update_efiling_num_status($result['registration_id'], $curr_dt_time, Draft_Stage);
//                                 $user_name = $_SESSION['login']['first_name'] . ' ' . $_SESSION['login']['last_name'];
//                                 $sentSMS = "eFiling No. " . efile_preview($efiling_num) . " generated from your efiling account & still pending for final submit. - Supreme Court of India";
//                                 $subject = "eFiling No. " . efile_preview($efiling_num) . " generated from your efiling account";
//                                 $Petsubject = "eFiling No. " . efile_preview($efiling_num) . " generated for your petition";
//                                 $sentPetSMS = "eFiling No. " . efile_preview($efiling_num) . "   is generated for your petition filed by your Advocate " . $user_name . " and still pending for final submission.";
//                                 if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE) {
//                                     $pet_user_name = $data['pet_name'];
//                                     if (!empty($data['pet_mobile'])) {
//                                         // comment for testing
//                                        // send_petitioner_mobile_sms($data['pet_mobile'], $sentPetSMS);
//                                     }if (!empty($data['pet_email'])) {
//                                         // comment for testing
//                                         //send_petitioner_mail_msg($data['pet_email'], $Petsubject, $sentPetSMS, $pet_user_name);
//                                     }
//                                 }
//                                 // comment for testing
//                                 send_mobile_sms($_SESSION['login']['mobile_number'], $sentSMS,SCISMS_Efiling_No_Generated);
//                                 send_mail_msg($_SESSION['login']['emailid'], $subject, $sentSMS, $user_name);

//                             }
//                         }
//                    // }
//                 }
//             }
//         }
//         if ($this->db->trans_status() === FALSE) {
//             return FALSE;
//         } else {
//             return $result;
//         }
//     }

public function add_caveator($data, $petmobile, $pet_email, $cis_masters_values)
{
    if ($this->session->has('estab_details') && $this->session->has('estab_details.hc_code')) {
        $est_code = $this->session->get('estab_details.hc_code');
    } else {
        $est_code = $this->session->get('estab_details.estab_code');
    }

    $curr_dt_time = date('Y-m-d H:i:s');
    if (empty($est_code)) {
        return FALSE;
    }

    $result = $this->gen_efiling_number();//print_r($result);die();
    $num_pre_fix = "EK";
    $filing_type = E_FILING_TYPE_CAVEAT;
    $stage_id = Draft_Stage;

    if ($result) {
        if ($this->session->get('login.ref_m_usertype_id') == USER_CLERK) {
            $created_by = 0;
            $sub_created_by = $this->session->get('login.id');
        } else {
            $created_by = $this->session->get('login.id');
            $sub_created_by = 0;
        }

        $efiling = sprintf("%'.05d\n", $result['efiling_num']);
        $string = $num_pre_fix . $est_code . $efiling . $result['efiling_year'];
        $efiling_num = preg_replace('/\s+/', '', $string);

        // $efiling_num_data = [
        //     'efiling_no' => $efiling_num,
        //     'efiling_year' => $result['efiling_year'],
        //     'efiling_for_type_id' => $this->session->get('efiling_for_details.efiling_for_type_id'),
        //     'efiling_for_id' => $this->session->get('efiling_for_details.efiling_for_id'),
        //     'ref_m_efiled_type_id' => $filing_type,
        //     'efiling_for_type_id' => E_FILING_TYPE_CAVEAT,
        //     'efiling_for_id' => 1,
        //     'created_by' => $created_by,
        //     'create_on' => $curr_dt_time,
        //     'create_by_ip' => $_SERVER['REMOTE_ADDR'],
        //     'sub_created_by' => $sub_created_by
        // ];

        // $result['registration_id'] = $this->add_efiling_nums($efiling_num_data);

        // if (!empty($result['registration_id'])) {
        //     $data['ref_m_efiling_nums_registration_id'] = $result['registration_id'];

        //     $result = [
        //         'registration_id' => $result['registration_id'],
        //         'efiling_no' => $efiling_num,
        //         'stage_id' => Draft_Stage,
        //         'ref_m_efiled_type_id' => E_FILING_TYPE_CAVEAT
        //     ];

        //     $this->session->set('efiling_details', $result);

        //     if (!empty($this->session->get('efiling_for_details.adv_code')) && !empty($this->session->get('efiling_for_details.adv_name'))) {
        //         $data['pet_adv_cd'] = $this->session->get('efiling_for_details.adv_code');
        //         $data['pet_adv'] = $this->session->get('efiling_for_details.adv_name');
        //         $data['pet_inperson'] = NULL;
        //     } else {
        //         $data['pet_inperson'] = 'Y';
        //     }

            $builder = $this->db->table('tbl_efiling_caveat');
            $builder->insert($data);
            if ($this->db->insertID()) {
                $data3 = [
                    'registration_id' => $result['registration_id'],
                    'stage_id' => $stage_id,
                    'activated_on' => $curr_dt_time,
                    'activated_by' => $this->session->get('login.id'),
                    'activated_by_ip' => $_SERVER['REMOTE_ADDR']
                ];

                $builder = $this->db->table('tbl_efiling_case_status');
                $builder->insert($data3);
                if ($this->db->insertID()) {
                    $status = $this->update_breadcrumbs($result['registration_id'], CAVEAT_BREAD_CAVEATOR);

                    if ($status) {
                        $this->update_efiling_num_status($result['registration_id'], $curr_dt_time, Draft_Stage);
                        $user_name = $this->session->get('login.first_name') . ' ' . $this->session->get('login.last_name');
                        $sentSMS = "eFiling No. " . efile_preview($efiling_num) . " generated from your efiling account & still pending for final submit. - Supreme Court of India";
                        $subject = "eFiling No. " . efile_preview($efiling_num) . " generated from your efiling account";
                        $Petsubject = "eFiling No. " . efile_preview($efiling_num) . " generated for your petition";
                        $sentPetSMS = "eFiling No. " . efile_preview($efiling_num) . " is generated for your petition filed by your Advocate " . $user_name . " and still pending for final submission.";

                        if ($this->session->get('login.ref_m_usertype_id') == USER_ADVOCATE) {
                            $pet_user_name = $data['pet_name'];
                            if (!empty($data['pet_mobile'])) {
                                // send_petitioner_mobile_sms($data['pet_mobile'], $sentPetSMS);
                            }
                            if (!empty($data['pet_email'])) {
                                // send_petitioner_mail_msg($data['pet_email'], $Petsubject, $sentPetSMS, $pet_user_name);
                            }
                        }

                        // send_mobile_sms($this->session->get('login.mobile_number'), $sentSMS, SCISMS_Efiling_No_Generated);
                        // send_mail_msg($this->session->get('login.emailid'), $subject, $sentSMS, $user_name);
                    }
                }
            }
        }
    }

    // if ($this->db->transStatus() === FALSE) {
    //     return FALSE;
    // } else {
    //     return $result;
    // }
}


    // function update_efiling_num_status($registration_id, $curr_dt_time, $next_stage, $curr_stage = NULL) {

    //     $deactivate_curr_stage = array(
    //         'stage_id' => $curr_stage,
    //         'deactivated_on' => $curr_dt_time,
    //         'is_active' => FALSE,
    //         'updated_by' => $this->session->userdata['login']['id'],
    //         'updated_by_ip' => $_SERVER['REMOTE_ADDR'],
    //     );

    //     $activate_next_stage = array(
    //         'registration_id' => $registration_id,
    //         'stage_id' => $next_stage,
    //         'is_active' => TRUE,
    //         'activated_on' => $curr_dt_time,
    //         'activated_by' => $this->session->userdata['login']['id'],
    //         'activated_by_ip' => $_SERVER['REMOTE_ADDR'],
    //     );

    //     if ($curr_stage != NULL) {

    //         $this->db->WHERE('registration_id', $registration_id);
    //         $this->db->WHERE('is_active', TRUE);
    //         $this->db->UPDATE('efil.tbl_efiling_num_status', $deactivate_curr_stage);
    //         if ($this->db->affected_rows() > 0) {

    //             $this->db->INSERT('efil.tbl_efiling_num_status', $activate_next_stage);
    //             if ($this->db->insert_id()) {
    //                 return TRUE;
    //             } else {
    //                 return FALSE;
    //             }
    //         } else {
    //             return FALSE;
    //         }
    //     } else {
    //         $this->db->INSERT('efil.tbl_efiling_num_status', $activate_next_stage);
    //         if ($this->db->insert_id()) {
    //             return TRUE;
    //         } else {
    //             return FALSE;
    //         }
    //     }
    // }

    function update_efiling_num_status($registration_id, $curr_dt_time, $next_stage, $curr_stage = NULL)
    {
    $deactivate_curr_stage = [
        'stage_id' => $curr_stage,
        'deactivated_on' => $curr_dt_time,
        'is_active' => FALSE,
        'updated_by' => $this->session->userdata('login')['id'],
        'updated_by_ip' => $_SERVER['REMOTE_ADDR'],
    ];

    $activate_next_stage = [
        'registration_id' => $registration_id,
        'stage_id' => $next_stage,
        'is_active' => TRUE,
        'activated_on' => $curr_dt_time,
        'activated_by' => $this->session->userdata('login')['id'],
        'activated_by_ip' => $_SERVER['REMOTE_ADDR'],
    ];

    $builder = $this->db->table('efil.tbl_efiling_num_status');

    if ($curr_stage !== NULL) {
        $builder->where('registration_id', $registration_id);
        $builder->where('is_active', TRUE);
        $builder->update($deactivate_curr_stage);
        if ($builder->affectedRows() > 0) {
            $builder->insert($activate_next_stage);
            if ($builder->get()->resultID) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    } else {
        $builder->insert($activate_next_stage);
        if ($builder->get()->resultID) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
   }

    // function gen_efiling_number() {

    //     $this->db->SELECT('caveat_efiling_no,caveat_efiling_year');
    //     $this->db->WHERE('entry_for_type', $_SESSION['estab_details']['efiling_for_type_id']);
    //     $this->db->WHERE('ref_m_establishment_id', $_SESSION['estab_details']['efiling_for_id']);
    //     $this->db->FROM('efil.m_tbl_efiling_no');
    //     $query = $this->db->get();
    //     $row = $query->result_array();

    //     $p_efiling_num = $row[0]['caveat_efiling_no'];
    //     $year = $row[0]['caveat_efiling_year'];
    //     if ($year < date('Y')) {
    //         $newYear = date('Y');
    //         $update_data = array('caveat_efiling_no' => 1,
    //             'caveat_efiling_year' => $newYear,
    //             'caveat_updated_by' => $_SESSION['login']['id'],
    //             'caveat_updated_on' => date('Y-m-d H:i:s'),
    //             'caveat_updated_by_ip' => $_SERVER['REMOTE_ADDR']);
    //         $this->db->WHERE('caveat_efiling_no', $p_efiling_num);
    //         $this->db->WHERE('caveat_efiling_year', $year);
    //         $this->db->WHERE('entry_for_type', $_SESSION['estab_details']['efiling_for_type_id']);
    //         $this->db->WHERE('ref_m_establishment_id', $_SESSION['estab_details']['efiling_for_id']);
    //         $this->db->UPDATE('efil.m_tbl_efiling_no', $update_data);
    //         if ($this->db->affected_rows() > 0) {
    //             $data['efiling_num'] = 1;
    //             $data['efiling_year'] = $newYear;
    //             return $data;
    //         } else {
    //             $this->gen_efiling_number();
    //         }
    //     } else {
    //         $gen_efiling_num = $p_efiling_num + 1;
    //         $efiling_num_info = array('caveat_efiling_no' => $gen_efiling_num,
    //             'caveat_updated_by' => $_SESSION['login']['id'],
    //             'caveat_updated_on' => date('Y-m-d H:i:s'),
    //             'caveat_updated_by_ip' => $_SERVER['REMOTE_ADDR']);
    //         $this->db->WHERE('caveat_efiling_no', $p_efiling_num);
    //         $this->db->WHERE('entry_for_type', $_SESSION['estab_details']['efiling_for_type_id']);
    //         $this->db->WHERE('ref_m_establishment_id', $_SESSION['estab_details']['efiling_for_id']);
    //         $result = $this->db->UPDATE('efil.m_tbl_efiling_no', $efiling_num_info);
    //         if ($this->db->affected_rows() > 0) {
    //             $data['efiling_num'] = $gen_efiling_num;
    //             $data['efiling_year'] = $year;
    //             return $data;
    //         } else {
    //             $this->gen_efiling_number();
    //         }
    //     }
    // }

     function gen_efiling_number() {
        $builder = $this->db->table('efil.m_tbl_efiling_no')
                            ->select('caveat_efiling_no, caveat_efiling_year')
                            ->where('entry_for_type', $_SESSION['estab_details']['efiling_for_type_id'])
                            ->where('ref_m_establishment_id', $_SESSION['estab_details']['efiling_for_id']);
    
        $row = $builder->get()->getRowArray();
        $p_efiling_num = $row['caveat_efiling_no'];
        $year = $row['caveat_efiling_year'];
        
        if ($year < date('Y')) {
            $newYear = date('Y');
            $update_data = [
                'caveat_efiling_no' => 1,
                'caveat_efiling_year' => $newYear,
                'caveat_updated_by' => $_SESSION['login']['id'],
                'caveat_updated_on' => date('Y-m-d H:i:s'),
                'caveat_updated_by_ip' => $_SERVER['REMOTE_ADDR']
            ];
            
            $builder->where('caveat_efiling_no', $p_efiling_num)
                    ->where('caveat_efiling_year', $year)
                    ->update($update_data);
            
            if ($this->db->affectedRows() > 0) {
                return [
                    'efiling_num' => 1,
                    'efiling_year' => $newYear
                ];
            } else {
                return $this->gen_efiling_number();
            }
        } else {
            $gen_efiling_num = $p_efiling_num + 1;
            $efiling_num_info = [
                'caveat_efiling_no' => $gen_efiling_num,
                'caveat_updated_by' => $_SESSION['login']['id'],
                'caveat_updated_on' => date('Y-m-d H:i:s'),
                'caveat_updated_by_ip' => $_SERVER['REMOTE_ADDR']
            ];
            
            $builder->where('caveat_efiling_no', $p_efiling_num)
                    ->update($efiling_num_info);
            
            if ($this->db->affectedRows() > 0) {
                return [
                    'efiling_num' => $gen_efiling_num,
                    'efiling_year' => $year
                ];
            } else {
                return $this->gen_efiling_number();
            }
        }
    }
    // function add_efiling_nums($data) {

    //     $this->db->INSERT('efil.tbl_efiling_nums', $data);
    //     if ($this->db->insert_id()) {
    //         return $this->db->insert_id();
    //     } else {
    //         return false;
    //     }
    // }

    function add_efiling_nums($data) {
        $builder = $this->db->table('efil.tbl_users_login_log');
        $builder->insert($data);
    
        $insertID = $this->db->insertID(); 
    
        return $insertID ? $insertID : false;
    }
    
    // public function update_caveators($registration_id, $data, $cis_masters_values)
    // {
    //     $this->db->transStart();
    //     $this->db->where('ref_m_efiling_nums_registration_id', $registration_id);
    //     $this->db->update('tbl_efiling_caveat', $data);
    //     $this->db->transComplete();
    
    //     if ($this->db->transStatus() === false) {
    //         return false;
    //     } else {
    //         return true;
    //     }
    // }
     function update_caveators($registration_id, $data, $cis_masters_values)
    {
        $this->db->transStart();
    
        try {
            $builder = $this->db->table('tbl_efiling_caveat');
            $builder->where('ref_m_efiling_nums_registration_id', $registration_id);
            $builder->update($data);
    
            $this->db->transCommit();
            return true;
        } catch (\Exception $e) {
            $this->db->transRollback();
            return false;
        }
    }
    
    function update_cis_master_values($registration_id, $data) {

        $this->db->WHERE('registration_id', $registration_id);
        $query = $this->db->get('tbl_cis_masters_values');
        if ($query->num_rows() > 0) {
            $this->db->WHERE('registration_id', $registration_id);
            $result = $this->db->UPDATE('tbl_cis_masters_values', $data);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            $cis_masters_values = array(
                'registration_id' => $registration_id,
                'pet_org_name' => $data['pet_org_name'],
                'pet_relation' => $data['pet_relation'],
                'pet_state_name' => $data['pet_state_name'],
                'pet_distt_name' => $data['pet_distt_name'],
                'pet_taluka_name' => $data['pet_taluka_name'],
                'pet_town_name' => $data['pet_town_name'],
                'pet_ward_name' => $data['pet_ward_name'],
                'pet_village_name' => $data['pet_village_name'],
            );
            $result = $this->db->INSERT('tbl_cis_masters_values', $cis_masters_values);
            if ($this->db->insert_id()) {
                return true;
            } else {
                return false;
            }
        }
    }

    // function update_breadcrumbs($registration_id, $breadcrumb_step) {

    //     $old_breadcrumbs = $_SESSION['efiling_details']['breadcrumb_status'] . ',' . $breadcrumb_step;
    //     $old_breadcrumbs_array = explode(',', $old_breadcrumbs);
    //     $new_breadcrumbs_array = array_unique($old_breadcrumbs_array);

    //     sort($new_breadcrumbs_array);
    //     $new_breadcrumbs = implode(',', $new_breadcrumbs_array);

    //     $this->db->WHERE('registration_id', $registration_id);
    //     $this->db->UPDATE('efil.tbl_efiling_nums', array('breadcrumb_status' => $new_breadcrumbs));

    //     if ($this->db->affected_rows() > 0) {
    //         $_SESSION['efiling_details']['breadcrumb_status'] = $new_breadcrumbs;
    //         return TRUE;
    //     } else {
    //         return FALSE;
    //     }
    // }

     function update_breadcrumbs($registration_id, $breadcrumb_step)
    {
        $old_breadcrumbs = $_SESSION['efiling_details']['breadcrumb_status'] . ',' . $breadcrumb_step;
        $old_breadcrumbs_array = explode(',', $old_breadcrumbs);
        $new_breadcrumbs_array = array_unique($old_breadcrumbs_array);
    
        sort($new_breadcrumbs_array);
        $new_breadcrumbs = implode(',', $new_breadcrumbs_array);
    
        $builder = $this->db->table('efil.tbl_efiling_nums');
        $builder->where('registration_id', $registration_id)
                ->update(['breadcrumb_status' => $new_breadcrumbs]);
    
        if ($builder->affectedRows() > 0) {
            $_SESSION['efiling_details']['breadcrumb_status'] = $new_breadcrumbs;
            return TRUE;
        } else {
            return FALSE;
        }
    }
    

?>
