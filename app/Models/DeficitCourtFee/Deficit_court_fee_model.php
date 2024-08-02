<?php

namespace App\Models\DeficitCourtFee;
use CodeIgniter\Model;
class Deficit_court_fee_model extends Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }


    function get_deficit_num_insrt($id,$deficit_amt,$curr_dt_time,$order_no,$order_date,$DiaryNo) {

        //$this->db->trans_start();

        // GET NEXT EFILING NUMBER
        $generated_efil_num = $this->gen_efiling_number();

        if ($generated_efil_num['efiling_num']) {

            // Saving data to efiling nums
            $registration_id = $this->add_efiling_nums($generated_efil_num, $curr_dt_time);

            /*print_r($registration_id);
            exit();*/

            if (isset($registration_id) && !empty($registration_id)) {
                //$DiaryYr_gen=substr($DiaryNo,-4);
                // $DiaryNo_gen=substr($DiaryNo,0,-4);
                $Diary_No_gen1=explode(" / ",$DiaryNo);

                $DiaryNo_gen=$Diary_No_gen1[0];
                $DiaryYr_gen=$Diary_No_gen1[1];


                /*echo $DiaryNo_gen .' =/= ' .$DiaryYr_gen;
                exit();*/


                $misc_docs_ia_details = array(
                    'registration_id' => $registration_id,
                    'ref_m_efiled_type_id' => E_FILING_TYPE_DEFICIT_COURT_FEE,//E_FILING_TYPE_IA,
                    'diary_no' => $DiaryNo_gen,
                    'diary_year' => $DiaryYr_gen,
                    'adv_bar_id' => $_SESSION['login']['adv_sci_bar_id'],
                    'adv_code' => $_SESSION['login']['aor_code'],
                    'created_on' => $curr_dt_time,
                    'created_by' => $_SESSION['login']['id'],
                    'created_by_ip' => $_SERVER['REMOTE_ADDR']
                );
                /*print_r($misc_docs_ia_details);
                exit();*/
                /*$status = $this->add_misc_docs_ia_details($registration_id, $misc_docs_ia_details, IA_BREAD_CASE_DETAILS,$appearing_for);*/
                $status = $this->add_misc_docs_ia_details($registration_id, $misc_docs_ia_details);

                if ($status) {
                    // UPDATE CASE STAGE IN EFILING NUM STATUS TABLE
                    $status = $this->update_efiling_num_status($registration_id, $curr_dt_time, Draft_Stage);

                    if ($status) {
                        // GENERATE EFILING NUM BASIC DETAILS SESSION
                        $this->get_efiling_num_basic_Details($registration_id);
                        //$this->db->trans_complete();
                    }
                }

                $data_to_save = array(
                    'registration_id' => $registration_id,
                    'entry_for_type_id' => $_SESSION['estab_details']['efiling_for_type_id'],
                    'entry_for_id' => $_SESSION['estab_details']['efiling_for_id'],
                    'uploaded_pages' => 0,
                    'per_page_charges' => 0,
                    'no_of_copies' => 0,
                    'user_declared_court_fee' => $deficit_amt,
                    'printing_total' => 0,
                    'user_declared_total_amt' => $deficit_amt,
                    'received_amt' => $deficit_amt,
                    'order_no' => $order_no,
                    'order_date' => $order_date,
                    'payment_stage_id' => $_SESSION['efiling_details']['stage_id'],
                    'payment_mode' => 'online',
                    'payment_mode_name' => 'SHCIL'
                );

                $deficit_court_data_success = $this->add_deficit_data_courtFee($data_to_save);

                unset($_SESSION['pg_request_payment_details']);
                if ($deficit_court_data_success) {
                    $_SESSION['pg_request_payment_details'] = array(
                        'user_declared_court_fee' => escape_data($deficit_amt),
                        'printing_total' => '0',
                        'user_declared_total_amt' => escape_data($deficit_amt),
                        'order_no' => $order_no,
                        'order_date' => $order_date
                    );           // print_r($_SESSION['pg_request_payment_details']);
                    redirect('shcilPayment/paymentRequest');
                    exit(0);
                }
               /* print_r($data_to_save);
                exit();*/

            }//End of if condition $registration_id..

        }

    }//END OF FUNCTION get_deficit_num_insrt..

    function gen_efiling_number() {

        $this->db->SELECT('fee_efiling_no,fee_efiling_year');
        $this->db->WHERE('entry_for_type', $_SESSION['estab_details']['efiling_for_type_id']);
        $this->db->WHERE('ref_m_establishment_id', $_SESSION['estab_details']['efiling_for_id']);
        $this->db->FROM('efil.m_tbl_efiling_no');
        $query = $this->db->get();
        /*echo $this->db->last_query();
        exit();*/
        $row = $query->result_array();

        $p_efiling_num = $row[0]['fee_efiling_no'];
        $year = $row[0]['fee_efiling_year'];
        if ($year < date('Y')) {
           /* echo "sunny bhai";
            exit();*/
            $newYear = date('Y');
            $update_data = array('fee_efiling_no' => 1,
                'fee_efiling_year' => $newYear,
                'fee_updated_by' => $_SESSION['login']['id'],
                'fee_updated_on' => date('Y-m-d H:i:s'),
                'fee_update_ip' => $_SERVER['REMOTE_ADDR']);
            $this->db->WHERE('fee_efiling_no', $p_efiling_num);
            $this->db->WHERE('fee_efiling_year', $year);
            $this->db->WHERE('entry_for_type', $_SESSION['estab_details']['efiling_for_type_id']);
            $this->db->WHERE('ref_m_establishment_id', $_SESSION['estab_details']['efiling_for_id']);
            $this->db->UPDATE('efil.m_tbl_efiling_no', $update_data);

            /*echo $this->db->last_query();
            exit();*/
            if ($this->db->affected_rows() > 0) {
                $data['efiling_num'] = 1;
                $data['efiling_year'] = $newYear;
                return $data;
            } else {
                $this->gen_efiling_number();
            }
        } else {
            /*echo "oyeeeeeeee";
            exit();*/
            $gen_efiling_num = $p_efiling_num + 1;
            $efiling_num_info = array('fee_efiling_no' => $gen_efiling_num,
                'fee_updated_by' => $_SESSION['login']['id'],
                'fee_updated_on' => date('Y-m-d H:i:s'),
                'fee_update_ip' => $_SERVER['REMOTE_ADDR']);
            $this->db->WHERE('fee_efiling_no', $p_efiling_num);
            $this->db->WHERE('entry_for_type', $_SESSION['estab_details']['efiling_for_type_id']);
            $this->db->WHERE('ref_m_establishment_id', $_SESSION['estab_details']['efiling_for_id']);
            $result = $this->db->UPDATE('efil.m_tbl_efiling_no', $efiling_num_info);
            var_dump($result);

           // echo $this->db->last_query();

            if ($this->db->affected_rows() > 0) {
                $data['efiling_num'] = $gen_efiling_num;
                $data['efiling_year'] = $year;
                return $data;
            } else {
                $this->gen_efiling_number();
            }
        }
    }//END OF FUNCTION gen_efiling_number..

    function add_efiling_nums($generated_efil_num, $curr_dt_time) {

       // $num_pre_fix = "EA";
        $num_pre_fix = "EF";
        $filing_type = E_FILING_TYPE_DEFICIT_COURT_FEE;
        $stage_id = Draft_Stage;
        /*echo $stage_id;
        exit();*/

        if ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
            $created_by = 0;
            $sub_created_by = $_SESSION['login']['id'];
        } else {
            $created_by = $_SESSION['login']['id'];
            $sub_created_by = 0;
        }

        $efiling = sprintf("%'.05d\n", $generated_efil_num['efiling_num']);
        $string = $num_pre_fix . $_SESSION['estab_details']['estab_code'] . $efiling . $generated_efil_num['efiling_year'];
        $efiling_num = preg_replace('/\s+/', '', $string);

        $efiling_num_data = array('efiling_no' => $efiling_num,
            'efiling_year' => $generated_efil_num['efiling_year'],
            'efiling_for_type_id' => $_SESSION['estab_details']['efiling_for_type_id'],
            'efiling_for_id' => $_SESSION['estab_details']['efiling_for_id'],
            'ref_m_efiled_type_id' => $filing_type,
            'created_by' => $created_by,
            'create_on' => $curr_dt_time,
            'create_by_ip' => $_SERVER['REMOTE_ADDR'],
            'sub_created_by' => $sub_created_by
            /*'allocated_to' => $_SESSION['login']['id'],
            'allocated_on' => date('Y-m-d H:i:s')*/
        );

/*print_r($efiling_num_data);
exit();*/
        $this->db->INSERT('efil.tbl_efiling_nums', $efiling_num_data);

        if ($this->db->insert_id()) {

            $registration_id = $this->db->insert_id();
            return $registration_id;
        } else {
            return FALSE;
        }
    }//END OF FUNCTION add_efiling_nums..

    function get_establishment_details() {

        $this->db->SELECT("id,estab_name, estab_code, access_ip,
                    enable_payment_gateway, is_charging_printing_cost, printing_cost,payment_gateway_params,pg_request_function,pg_response_function,
                      is_pet_state_required, is_pet_district_required, is_res_state_required, is_res_district_required, 
                      is_pet_mobile_required, is_pet_email_required, is_res_mobile_required, is_res_email_required,
                      is_extra_pet_state_required, is_extra_pet_district_required, is_extra_res_state_required, is_extra_res_district_required,
                      is_extra_pet_mobile_required, is_extra_pet_email_required, is_extra_res_mobile_required, is_extra_res_email_required,state_code");

        $this->db->FROM('efil.m_tbl_establishments');
        $this->db->WHERE('display', 'Y');
        $this->db->ORDER_BY("estab_name", "asc");

        $query = $this->db->get();

        if ($query->num_rows() >= 1) {

            $estab_details = $query->result_array();

            $this->session->set_userdata(array('estab_details' => $estab_details[0]));

            $_SESSION['estab_details']['efiling_for_type_id'] = E_FILING_FOR_SUPREMECOURT;
            $_SESSION['estab_details']['efiling_for_id'] = escape_data($estab_details[0]['id']);
            return TRUE;
        } else {
            return FALSE;
        }
    }//End of function get_establishment_details()..


    function add_deficit_data_courtFee($data_to_save){
        /*print_r($data_to_save);
        exit();*/
        $this->db->INSERT('efil.tbl_court_fee_payment', $data_to_save);

        if($this->db->insert_id()){
            return TRUE;
        }else{
            return FALSE;
        }
       // exit();


    }//END of function add_deficit_data_courtFee()..


    public function get_efiling_num_basic_Details($registration_id) {
// defined in common model, ia_model also
        $this->db->SELECT("en.registration_id, en.efiling_no, en.efiling_year, en.ref_m_efiled_type_id, et.efiling_type,
                en.efiling_for_type_id, en.efiling_for_id, 
                en.breadcrumb_status, en.signed_method, en.allocated_to,
                en.created_by, en.sub_created_by,
                misc_ia.diary_no, misc_ia.diary_year,
                cs.stage_id, cs.activated_on,
                (select payment_status from efil.tbl_court_fee_payment where registration_id = en.registration_id order by id desc limit 1 )");

        $this->db->FROM('efil.tbl_efiling_nums as en');
        $this->db->JOIN('efil"."tbl_misc_docs_ia as misc_ia', 'en.registration_id = misc_ia.registration_id', 'left');
        $this->db->JOIN('efil.tbl_efiling_num_status as cs', 'en.registration_id = cs.registration_id');
        $this->db->JOIN('efil.m_tbl_efiling_type as et', 'en.ref_m_efiled_type_id = et.id');
        $this->db->WHERE('cs.is_active', 'TRUE');
        $this->db->WHERE('cs.is_deleted', 'FALSE');
        $this->db->WHERE('en.is_active', 'TRUE');
        $this->db->WHERE('en.is_deleted', 'FALSE');
        $this->db->WHERE('en.registration_id', $registration_id);
        $query = $this->db->get();
        /*echo $this->db->last_query();
        exit();*/
       // $_SESSION['efiling_details']['allocated_to'];
        if ($query->num_rows() >= 1) {

            $efiling_details = $query->result_array();

            $this->session->set_userdata(array('efiling_details' => $efiling_details[0]));

            return TRUE;
        } else {
            return false;
        }
    }//END of function get_efiling_num_basic_Details()..


    function update_efiling_num_status($registration_id, $curr_dt_time, $next_stage, $curr_stage = NULL) {

        /*echo $registration_id . '/ ' . $curr_dt_time .'/ ' . $next_stage . '/ ' . $curr_stage;
        exit();*/

        $deactivate_curr_stage = array(
            'stage_id' => $curr_stage,
            'deactivated_on' => $curr_dt_time,
            'is_active' => FALSE,
            'updated_by' => $_SESSION['login']['id'],
            'updated_by_ip' => $_SERVER['REMOTE_ADDR'],
        );

        $activate_next_stage = array(
            'registration_id' => $registration_id,
            'stage_id' => $next_stage,
            'is_active' => TRUE,
            'activated_on' => $curr_dt_time,
            'activated_by' => $_SESSION['login']['id'],
            'activated_by_ip' => $_SERVER['REMOTE_ADDR'],
        );

        if ($curr_stage != NULL) {

            $this->db->WHERE('registration_id', $registration_id);
            $this->db->WHERE('is_active', TRUE);
            $this->db->UPDATE('efil.tbl_efiling_num_status', $deactivate_curr_stage);
            if ($this->db->affected_rows() > 0) {

                $this->db->INSERT('efil.tbl_efiling_num_status', $activate_next_stage);
                if ($this->db->insert_id()) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            $this->db->INSERT('efil.tbl_efiling_num_status', $activate_next_stage);
            if ($this->db->insert_id()) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }//END of function update_efiling_num_status()..

    /*function add_misc_docs_ia_details($registration_id, $case_details, $breadcrumb_step,$appearing_for="") {*/
    function add_misc_docs_ia_details($registration_id, $case_details) {

        $this->db->INSERT('efil.tbl_misc_docs_ia', $case_details);
        if ($this->db->insert_id()) {
            return TRUE;
        } else {
            return FALSE;
        }

    }//END of function add_misc_docs_ia_details..


    function updatePayment_Efiling_num_status($registration_id, $next_stage, $curr_stage = NULL) {
        $curr_dt_time = date('Y-m-d H:i:s');

        /*echo $registration_id . '/ ' . $curr_dt_time .'/ ' . $next_stage . '/ ' . $curr_stage;
        exit();*/

        $deactivate_curr_stage_payment = array(
            'stage_id' => $curr_stage,
            'deactivated_on' => $curr_dt_time,
            'is_active' => FALSE,
            'updated_by' => $_SESSION['login']['id'],
            'updated_by_ip' => $_SERVER['REMOTE_ADDR'],
        );

        $activate_next_stage_payment = array(
            'registration_id' => $registration_id,
            'stage_id' => $next_stage,
            'is_active' => TRUE,
            'activated_on' => $curr_dt_time,
            'activated_by' => $_SESSION['login']['id'],
            'activated_by_ip' => $_SERVER['REMOTE_ADDR'],
        );


        if ($curr_stage != NULL) {

            $this->db->WHERE('registration_id', $registration_id);
            $this->db->WHERE('is_active', TRUE);
            $this->db->UPDATE('efil.tbl_efiling_num_status', $deactivate_curr_stage_payment);
            if ($this->db->affected_rows() > 0) {

                $this->db->INSERT('efil.tbl_efiling_num_status', $activate_next_stage_payment);
                if ($this->db->insert_id()) {
                    $assign_to = $this->assign_efiling_number($_SESSION['estab_details']['efiling_for_type_id'], $_SESSION['estab_details']['efiling_for_id']);

                    $nums_data_update = array(
                        'allocated_to' => $assign_to[0]['id'],
                        'allocated_on' => date('Y-m-d H:i:s'));

                    $this->db->WHERE('registration_id', $registration_id);
                    $this->db->WHERE('is_active', TRUE);
                    $this->db->UPDATE('efil.tbl_efiling_nums', $nums_data_update);
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
                return FALSE;
        }

    }//END of function updatePayment_Efiling_num_status()..


    function get_already_paid_courtFee(){

        //$this->db->SELECT("en.*,misc_ia.* ,cs.*,cfp.* ");
        $this->db->SELECT("en.efiling_no,misc_ia.diary_no,misc_ia.registration_id,misc_ia.diary_year,misc_ia.created_on,cfp.received_amt,cfp.shcilpmtref");

        $this->db->FROM('efil.tbl_efiling_nums as en');
        $this->db->JOIN('efil"."tbl_misc_docs_ia as misc_ia', 'en.registration_id = misc_ia.registration_id');
        $this->db->JOIN('efil.tbl_efiling_num_status as cs', 'en.registration_id = cs.registration_id');
        $this->db->JOIN('efil.tbl_court_fee_payment as cfp', 'en.registration_id = cfp.registration_id');
        $this->db->WHERE('cs.is_active', 'TRUE');
        $this->db->WHERE('cs.is_deleted', 'FALSE');
        $this->db->WHERE('en.is_active', 'TRUE');
        $this->db->WHERE('en.is_deleted', 'FALSE');
        $this->db->WHERE('cfp.payment_status', 'Y');
        $this->db->WHERE('en.ref_m_efiled_type_id', 3);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit();

        if ($query->num_rows() >= 1) {

            /*$efiling_details = $query->result_array();

            $this->session->set_userdata(array('efiling_details' => $efiling_details[0]));*/

            return $query->result_array();
        } else {
            return false;
        }

       // $this->db->JOIN('efil.m_tbl_efiling_type as et', 'en.ref_m_efiled_type_id = et.id');
    }//END of function get_already_paid_courtFee()..


    function get_already_paid_confirmation($DiaryNo){

        //echo $DiaryNo;
       // exit();
        $this->db->SELECT("en.efiling_no,misc_ia.diary_no,misc_ia.registration_id,misc_ia.id,misc_ia.diary_year,misc_ia.created_on,cfp.received_amt,cfp.shcilpmtref");

        $this->db->FROM('efil.tbl_efiling_nums as en');
        $this->db->JOIN('efil"."tbl_misc_docs_ia as misc_ia', 'en.registration_id = misc_ia.registration_id');
        $this->db->JOIN('efil.tbl_efiling_num_status as cs', 'en.registration_id = cs.registration_id');
        $this->db->JOIN('efil.tbl_court_fee_payment as cfp', 'en.registration_id = cfp.registration_id');
        $this->db->WHERE('cs.is_active', 'TRUE');
        $this->db->WHERE('cs.is_deleted', 'FALSE');
        $this->db->WHERE('en.is_active', 'TRUE');
        $this->db->WHERE('en.is_deleted', 'FALSE');
        $this->db->WHERE('cfp.payment_status', 'Y');
        $this->db->WHERE('en.ref_m_efiled_type_id', 3);
        $this->db->WHERE('misc_ia.diary_no', $DiaryNo);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit();

        if ($query->num_rows() >= 1) {

            return $query->result_array();
        } else {
            return false;
        }


    }//END of function get_already_paid_confirmation()..

    //XXXXXXXXXXXXXXX Tbl Sci Casses Start XXXXXXXXXXXXXXXXX

    function get_diary_details($diary_no, $diary_year) {
        $this->db->SELECT("*");
        $this->db->FROM('efil.tbl_sci_cases');
        $this->db->WHERE('diary_no', $diary_no);
        $this->db->WHERE('diary_year', $diary_year);
        $this->db->WHERE('is_deleted', FALSE);

        $query = $this->db->get();

        return $query->result();
    }//End of function get_diary_details ()..

    function add_update_sci_cases_details($sc_case_details, $diary_data = NULL) {

        if ($diary_data == NULL) {
            $this->db->INSERT('efil.tbl_sci_cases', $sc_case_details);
            if ($this->db->insert_id()) {
                $_SESSION['tbl_sci_case_id']=$this->db->insert_id();
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $this->db->WHERE('diary_no', $diary_data['diary_no']);
            $this->db->WHERE('diary_year', $diary_data['diary_year']);
            $this->db->update('efil.tbl_sci_cases',$sc_case_details);
            if($this->db->affected_rows() > 0){
                return TRUE;
            }else{
                return FALSE;
            }
        }
    }//End of function add_update_sci_cases_details ()..

    //XXXXXXXXXXXXXXX Tbl Sci Casses End XXXXXXXXXXXXXXXXX

    function get_payment_details_deficitCourt($registration_id){
        $this->db->SELECT('cfp.*,
        case when en.ref_m_efiled_type_id=1 then tcd.sc_diary_num else misc_ia.diary_no end as sc_diary_num,
        case when en.ref_m_efiled_type_id=1 then tcd.sc_diary_year else misc_ia.diary_year end as sc_diary_year',false);
        $this->db->FROM('efil.tbl_court_fee_payment cfp');
        $this->db->JOIN('efil.tbl_efiling_nums as en', 'cfp.registration_id = en.registration_id', 'left');
        $this->db->JOIN('efil"."tbl_misc_docs_ia as misc_ia', 'cfp.registration_id = misc_ia.registration_id', 'left');
        $this->db->JOIN('efil.tbl_case_details tcd','cfp.registration_id=tcd.registration_id','left');
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

    }//End of function get_payment_details_deficitCourt()..


    function get_case_details_deficit_court($registration_id) {

        $this->db->SELECT("en.*,misc_ia.*,sc.reg_no_display,sc.cause_title,sc.c_status,sc.p_no,sc.r_no");
        $this->db->FROM('efil.tbl_efiling_nums en');
        $this->db->JOIN('efil.tbl_misc_docs_ia misc_ia', 'en.registration_id = misc_ia.registration_id');
        $this->db->JOIN('efil.tbl_sci_cases sc', 'misc_ia.diary_no = sc.diary_no AND misc_ia.diary_year = sc.diary_year');
        $this->db->WHERE('en.registration_id', $registration_id);
        $this->db->WHERE('en.is_deleted', FALSE);
        $this->db->WHERE('misc_ia.is_deleted', FALSE);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
    }//End of function get_case_details_deficit_court()..





    function assign_efiling_number($efiling_for_type_id, $efiling_for_id) {

        $query = "SELECT users.id,  users.ref_m_usertype_id, users.admin_for_type_id, users.admin_for_id, count(allocated_on) efiling_num_count
                FROM efil.tbl_users users
                LEFT JOIN efil.tbl_efiling_nums en ON en.allocated_to = users.id AND to_char(en.allocated_on,'YYYY-MM-DD')::date ='" . date('Y-m-d') . "'
                WHERE users.admin_for_type_id ='" . $efiling_for_type_id . "' AND users.admin_for_id ='" . $efiling_for_id . "' AND
                users.is_deleted IS FALSE AND users.id not in(2656,2657,2658,2659,2660) and
                users.ref_m_usertype_id IN(" . USER_ADMIN . "," . USER_ACTION_ADMIN . ")                  
                GROUP BY users.id,users.ref_m_usertype_id,users.admin_for_type_id,users.admin_for_id ORDER BY efiling_num_count";


        $query = $this->db->query($query);
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }//End of function assign_efiling_number()..









}//END OF CLASS Deficit_court_fee_model..




