<?php
namespace App\Models\NewCaseQF;

use CodeIgniter\Model;
class New_case_support_model extends Model {

    function __construct() {
// Call the Model constructor
        parent::__construct();
    }

    function remark_preview($reg_id, $current_stage_id) {

        $result = $this->get_intials_defects_remarks($reg_id, $current_stage_id);
        //print_r($result->initial_defects_id);

        if ($result) {
            $msg .= '<div class="alert" style="border-color: #ebccd1;background-color: #f2dede;color: #a94442;">';
            $msg .= '<p><strong>Defect Raised On : </strong>' . date('d-m-Y H:i:s', strtotime($result->defect_date)) . '<p>';
            $msg .= '<p><strong>Defects :</strong><p>';
            $msg .= '<p>' . script_remove($result->defect_remark) . '<p>';

            if ($result->defect_cured_date != NULL) {
                $msg .= '<p align="right"><strong>Defect Cured On : </strong>' . htmlentities(date('d-m-Y H:i:s', strtotime($result->defect_cured_date)), ENT_QUOTES) . '<p>';
            }

            $msg .= '</div>';
            return $msg;
        } else {
            return false;
        }
    }

    function get_intials_defects_remarks($registration_id, $current_stage_id) {
        if (empty($registration_id)) {
            return FALSE;
        }
        $this->db->SELECT('*');
        $this->db->FROM('efil.tbl_initial_defects');
        $this->db->WHERE('is_approved', FALSE);
        if (in_array($current_stage_id, array(Initial_Defected_Stage, DEFICIT_COURT_FEE, I_B_Defected_Stage, I_B_Rejected_Stage, E_REJECTED_STAGE, LODGING_STAGE, DELETE_AND_LODGING_STAGE))) {
            $this->db->WHERE('is_defect_cured', FALSE);
        } elseif (in_array($current_stage_id, array(Initial_Approaval_Pending_Stage, Initial_Defects_Cured_Stage, DEFICIT_COURT_FEE_PAID,
                    I_B_Approval_Pending_Stage, I_B_Approval_Pending_Admin_Stage, I_B_Defects_Cured_Stage))) {
            $this->db->WHERE('is_defect_cured', TRUE);
        }
        $this->db->WHERE('registration_id', $registration_id);
        $this->db->ORDER_BY('initial_defects_id', 'DESC');

        $query = $this->db->get();

        if ($query->num_rows() >= 1) {
            $arr = $query->result();
            return $arr[0];
        } else {
            return false;
        }
    }

}

?>
