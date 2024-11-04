<?php

namespace App\Controllers\ShcilPayment;

use App\Controllers\BaseController;
use App\Models\ShcilPayment\PaymentModel;
use App\Models\DeficitCourtFee\DeficitCourtFeeModel;

class PaymentResponse extends BaseController {
    protected $Payment_model;
    protected $Deficit_court_fee_model;

    public function __construct() {
        parent::__construct();
        $this->Payment_model = new PaymentModel();
        if (!empty($_SESSION['efiling_details']) && $_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_DEFICIT_COURT_FEE) {
            $this->Deficit_court_fee_model = new DeficitCourtFeeModel();
        }
    }


    public function index() {
        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT);
        if (!empty($_SESSION['login']) && !in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('login');
            exit(0);
        }

        $stages_array = array('', Draft_Stage, Initial_Defected_Stage, I_B_Defected_Stage);
        if (!in_array(!empty($_SESSION['efiling_details']) && $_SESSION['efiling_details']['stage_id'], $stages_array)) {
            redirect('dashboard');
            exit(0);
        }
        //echo 'dashboard'; echo '<pre>';print_r($_SESSION['efiling_details']); echo '</pre>';exit();
        if (!empty($_SESSION['efiling_details']) && $_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_NEW_CASE) {
            //$redirection_url = 'newcase/courtFee';
            $redirection_url = 'case/crud?tab=courtFee';
        } elseif (!empty($_SESSION['efiling_details']) && $_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MISC_DOCS) {
            //$redirection_url = 'miscellaneous_docs/courtFee';
            $redirection_url = 'case/document/crud_registration/?tab=courtFee';
        } elseif (!empty($_SESSION['efiling_details']) && $_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_IA) {
            $redirection_url = 'case/interim_application/crud_registration?tab=courtFee';
        }elseif (!empty($_SESSION['efiling_details']) && $_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MENTIONING) {
            $redirection_url = 'mentioning/courtFee';
        }
        elseif (!empty($_SESSION['efiling_details']) && $_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_CAVEAT) {
            $redirection_url = 'case/caveat/crud/'.url_encryption(trim($_SESSION['efiling_details']['registration_id'] . '#' . $_SESSION['efiling_details']['ref_m_efiled_type_id'] . '#' . Draft_Stage));
        }
        elseif (!empty($_SESSION['efiling_details']) && $_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_DEFICIT_COURT_FEE) {
            //$redirection_url = 'miscellaneous_docs/courtFee';
            $redirection_url = 'deficitCourtFee/DefaultController/';
        }
        elseif (!empty($_SESSION['efiling_details']) && $_SESSION['efiling_details']['ref_m_efiled_type_id'] == OLD_CASES_REFILING) {
            $redirection_url = 'case/refile_old_efiling_cases/crud_registration/?tab=courtFee';
        }
        else {
            $_SESSION['MSG'] = message_show("fail", 'Invalid Action.');
            return redirect()->to('dashboard');
            exit(0);
        }

        //echo "<pre>";
        //print_r($_POST); die;
        
        $InputArray = $_POST;
        /*print_r($InputArray);
        exit();*/

        /*$this->form_validation->set_rules('txnid', 'txnid', 'required|trim|max_length[16]|alpha_numeric');
        $this->form_validation->set_rules('shcltxnid', 'Transation Number', 'required|trim|max_length[50]|alpha_numeric');
        $this->form_validation->set_rules('shcilpmtref', 'Payment Ref', 'required|trim|max_length[50]|alpha_numeric');
        //$this->form_validation->set_rules('pgsptxnid', 'Payment Gateway Txn', 'max_length[50]|callback_numeric_with_hyphen');
        $this->form_validation->set_rules('pgsptxnid', 'Payment Gateway Txn', 'max_length[50]|alpha_numeric');
        $this->form_validation->set_rules('banktxnid', 'Bank Txn ID', 'max_length[50]|alpha_numeric');
        //$this->form_validation->set_rules('banktxnid', 'Bank Txn ID', 'max_length[50]|callback_alpha_numeric_with_hyphen');
        $this->form_validation->set_rules('txnType', 'txnType', 'required|trim|max_length[2]|in_list[NB,DC,NA]');
        //$this->form_validation->set_rules('txnDate', 'txnDate', 'max_length[20]|match[' . date('d-M-Y H:i:s') . ']');
        $this->form_validation->set_rules('txnStatus', 'txnStatus', 'max_length[10]|in_list[OK,PENDING,FAILED,null]');
        $this->form_validation->set_rules('prodid', 'prodid', 'max_length[10]|validate_alpha_numeric_hyphen');
       // $this->form_validation->set_rules('amt', 'amt', 'max_length[6]|integer');
        $this->form_validation->set_rules('bank_name', 'bank_name', 'max_length[100]|trim|validate_alpha_numeric_space_dot_hyphen_underscore');
        $this->form_validation->set_rules('signature', 'signature', 'required|max_length[500]|alpha_numeric');
        
        $this->form_validation->set_rules('udf1', 'udf1', 'required|trim|min_length[3]|max_length[99]|validate_alpha_numeric_space_dot_hyphen_underscore');
        $this->form_validation->set_rules('udf2', 'udf2', 'required|trim|exact_length[10]|is_natural');
        $this->form_validation->set_rules('udf3', 'udf3', 'required|trim|min_length[5]|max_length[99]|valid_email');
        $this->form_validation->set_rules('udf4', 'udf4', 'required|trim|min_length[1]|max_length[5]|is_natural');
        $this->form_validation->set_rules('udf5', 'udf5', 'required|trim|min_length[1]|max_length[5]|is_natural');
        $this->form_validation->set_rules('udf6', 'udf6', 'trim|validate_alpha_numeric_space_dot_hyphen_underscore]');
        $this->form_validation->set_rules('udf7', 'udf7', 'trim|validate_alpha_numeric_space_dot_hyphen_underscore');
        $this->form_validation->set_rules('udf8', 'udf8', 'trim|validate_alpha_numeric_space_dot_hyphen_underscore');
        $this->form_validation->set_rules('udf9', 'udf9', 'trim|validate_alpha_numeric_space_dot_hyphen_underscore');
        $this->form_validation->set_rules('udf10', 'udf10', 'required|trim|min_length[1]|max_length[5]|is_natural');


        if ($this->form_validation->run() == FALSE) {
            $error_array = $this->form_validation->error_array();
            $error_json = array('response_error_msg' => json_encode($error_array));
            $this->Payment_model->updatePayment($_SESSION['efiling_details']['registration_id'], $InputArray['txnid'], $error_json);
            $_SESSION['MSG'] = message_show("fail", "Invalid data in Payment response !");
            redirect('dashboard');
        }*/

        if (!empty($_SESSION['efiling_details']) && isset($_SESSION['efiling_details']['registration_id']) && !empty($_SESSION['efiling_details']['registration_id'])) {
            if (isset($InputArray['txnid']) && !empty($InputArray['txnid']) && isset($InputArray['txnStatus']) && !empty($InputArray['txnStatus'])) {

                $registration_id = $_SESSION['efiling_details']['registration_id'];
                
                $curr_dt_time = date('Y-m-d H:i:s');

                $order_num = $InputArray['txnid'];
                $transaction_num = $InputArray['shcltxnid'];
                $transaction_date = $InputArray['txnDate'];
                $received_amount = $InputArray['amt'];
                $shciltxnstatus = strtolower($InputArray['txnStatus']);

                $save_payment_response_1 = array(
                    'transaction_num' => $transaction_num,
                    'transaction_date' => $transaction_date,
                    'txn_status_update_method' => 'D',
                    'txn_status_updated_on' => $curr_dt_time,
                    'shcilpmtref' => $InputArray['shcilpmtref'],
                    'shciltxnstatus' => $shciltxnstatus,
                    'received_amt' => $received_amount,
                    'shcildesc' => $InputArray['desc'],
                    'pg_response' => json_encode($InputArray)
                );

                $save_payment_response_2 = array(
                    'pgsptxnid' => $InputArray['pgsptxnid'],
                    'banktxnid' => $InputArray['banktxnid'],
                    'bank_name' => $InputArray['bank_name']                    
                );

                //$payment_status = P,F, C, Y
                $grn_number = '';
                if ($shciltxnstatus == 'ok') {
                    unset($_SESSION['pg_request_payment_details']);
                    $payment_status = 'Y';
                    $save_payment_response_3 = array('payment_status' => $payment_status);                    
                    $save_payment_response = array_merge($save_payment_response_1, $save_payment_response_2, $save_payment_response_3);
                    $this->session->setFlashdata('success', 'Fee payment received successfully !');
                    //$_SESSION['MSG'] = message_show("success", 'Fee payment received successfully !');
                    $sentSMS = "Fee received successfully for Efiling No. " . efile_preview($_SESSION['efiling_details']['efiling_no']) . " with 
                                Receipt No. " . $transaction_num . ", of amount Rs. " . $received_amount . "/-. - Supreme Court of India";
                    // send_whatsapp_message($_SESSION['efiling_details']['registration_id'],$_SESSION['efiling_details']['efiling_no']," Transaction Number: " . $transaction_num . ", Amount Rs. " . $received_amount . "/-. SUCCESSFULLY RECEIVED");

                    $smsTemplate=SCISMS_Payment_Success;
                    $subject = "Payment Success : Efiling No. " . efile_preview($_SESSION['efiling_details']['efiling_no']);
                } elseif ($shciltxnstatus == 'pending') {
                    $payment_status = 'P';
                    $save_payment_response = array_merge($save_payment_response_1);
                    $this->session->setFlashdata('fail', 'Fee payment status received still pending !');
                    
                    // $_SESSION['MSG'] = message_show("fail", 'Fee payment status received still pending !');
                    $sentSMS = "Fee payment for Efiling No. " . efile_preview($_SESSION['efiling_details']['efiling_no']) . " with 
                                Receipt No. " . $grn_number . " still pending. - Supreme Court of India";

                    // send_whatsapp_message($_SESSION['efiling_details']['registration_id'],$_SESSION['efiling_details']['efiling_no']," Transaction Number: " . $transaction_num . ", Amount Rs. " . $received_amount . "/-. PENDING");
                    $smsTemplate=SCISMS_Payment_pending;
                    $subject = "Payment Pending : Efiling No. " . efile_preview($_SESSION['efiling_details']['efiling_no']);
                } elseif ($shciltxnstatus == 'failed') {
                    $payment_status = 'F';
                    $save_payment_response_3 = array('payment_status' => $payment_status);                    
                    $save_payment_response = array_merge($save_payment_response_1, $save_payment_response_3);                    
                    $this->session->setFlashdata('fail', 'Fee payment failed !');
                    
                    // $_SESSION['MSG'] = message_show("fail", 'Fee payment failed !');
                    $sentSMS = "Fee payment for Efiling No. " . efile_preview($_SESSION['efiling_details']['efiling_no']) . " with 
                               Receipt No. " . $grn_number . ",  of amount Rs. " . $received_amount . " failed due to some technical reason. If amount is deducted from your bank account, please check with your bank before retry. - Supreme Court of India";
                    // send_whatsapp_message($_SESSION['efiling_details']['registration_id'],$_SESSION['efiling_details']['efiling_no']," Transaction Number: " . $transaction_num . ", Amount Rs. " . $received_amount . "/-.  FAILED. Please check your bank account for any deduction before retrying to make payment");

                    $smsTemplate=SCISMS_Payment_failed;
                    $subject = "Payment Failed : Efiling No. " . efile_preview($_SESSION['efiling_details']['efiling_no']);
                } elseif ($shciltxnstatus == 'null' || $shciltxnstatus == null) {
                    $payment_status = 'C';
                    $save_payment_response_3 = array('payment_status' => $payment_status);                    
                    $save_payment_response = array_merge($save_payment_response_1, $save_payment_response_3);                    
                    $this->session->setFlashdata('fail', 'Fee payment cancelled !');
                    
                    // $_SESSION['MSG'] = message_show("fail", 'Fee payment cancelled !');
                    $sentSMS = "Fee payment for Efiling No. " . efile_preview($_SESSION['efiling_details']['efiling_no']) . " with 
                                Receipt No. " . $grn_number . " cancelled. - Supreme Court of India";

                    // send_whatsapp_message($_SESSION['efiling_details']['registration_id'],$_SESSION['efiling_details']['efiling_no']," Transaction Number: " . $transaction_num . ", Amount Rs. " . $received_amount . "/-. CANCELLED");

                    $smsTemplate=SCISMS_Payment_Cancelled;
                    $subject = "Payment Cancelled : Efiling No. " . efile_preview($_SESSION['efiling_details']['efiling_no']);
                }

                /*if ($InputArray['pgsptxnid'] == 0 && $InputArray['banktxnid'] == 'NA') {
                    $payment_status = 'C';
                } elseif ($InputArray['pgsptxnid'] != 0 && $InputArray['banktxnid'] == '-') {
                    $payment_status = 'C';
                } elseif ($InputArray['pgsptxnid'] != 0 && $InputArray['banktxnid'] == NULL) {
                    $payment_status = 'C';
                }*/
                if (!empty($_SESSION['efiling_details']) && $_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_DEFICIT_COURT_FEE) {
                    //$this->load->model('deficitCourtFee/Deficit_court_fee_model');
                    /*$Efiling_num_status_update = $this->Deficit_court_fee_model->updatePayment_Efiling_num_status($registration_id, DEFICIT_COURT_FEE_PAID,$_SESSION['efiling_details']['stage_id']);*/
                    $Efiling_num_status_update = $this->Deficit_court_fee_model->updatePayment_Efiling_num_status($registration_id, DEFICIT_COURT_FEE_E_FILED,$_SESSION['efiling_details']['stage_id']);

                    if($Efiling_num_status_update){
                        $result = $this->Payment_model->updatePayment($registration_id, $order_num, $save_payment_response);
                    }
                }else{
                    $result = $this->Payment_model->updatePayment($registration_id, $order_num, $save_payment_response);
                }




                if ($result) {

                    $user_name = $_SESSION['login']['first_name'] . ' ' . $_SESSION['login']['last_name'];
                    send_mobile_sms($_SESSION['login']['mobile_number'], $sentSMS,$smsTemplate);
                    send_mail_msg($_SESSION['login']['emailid'], $subject, $sentSMS, $user_name);
                    reset_affirmation($_SESSION['efiling_details']['registration_id']);
                    return redirect()->to(base_url($redirection_url));
                    exit(0);
                } else {
                    $_SESSION['MSG'] = message_show("fail", 'Payment status update failed due to some technical reason. Please check your bank message before retry !');
                    return redirect()->to(base_url($redirection_url));
                    exit(0);
                }
            } else {
                return redirect()->to(base_url('dashboard'));
                exit(0);
            }
        } else {
            return redirect()->to(base_url('dashboard'));
            exit(0);
        }
    }

}
