<?php

namespace App\Models\Caveat;
use CodeIgniter\Model;

class Caveatee_model extends Model {

    function __construct() {
        parent::__construct();
    }

    function add_caveatee($registration_id, $data, $cis_masters_values) {
        $this->db->trans_start();
        $this->db->WHERE('ref_m_efiling_nums_registration_id', $registration_id);
        $this->db->UPDATE('tbl_efiling_caveat', $data);
        if ($this->db->affected_rows() > 0) {
//            if ($cis_masters_values != NULL) {
                //cis master feature remove
               // $success = $this->update_cis_master_values($registration_id, $cis_masters_values);
                $success = true;
                if ($success) {
                    $status = $this->update_breadcrumbs($registration_id, CAVEAT_BREAD_CAVEATEE);
                    if ($status) {
                        $status = $this->update_breadcrumbs($registration_id, CAVEAT_BREAD_EXTRA_PARTY);
                        $this->db->trans_complete();
                    }
                }
//            } else {
//                $this->db->trans_complete();
//            }
        }

        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
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

    function update_breadcrumbs($registration_id, $breadcrumb_step) {

        $old_breadcrumbs = $_SESSION['efiling_details']['breadcrumb_status'] . ',' . $breadcrumb_step;
        $old_breadcrumbs_array = explode(',', $old_breadcrumbs);
        $new_breadcrumbs_array = array_unique($old_breadcrumbs_array);

        sort($new_breadcrumbs_array);
        $new_breadcrumbs = implode(',', $new_breadcrumbs_array);

        $this->db->WHERE('registration_id', $registration_id);
        $this->db->UPDATE('efil.tbl_efiling_nums', array('breadcrumb_status' => $new_breadcrumbs));

        if ($this->db->affected_rows() > 0) {
            $_SESSION['efiling_details']['breadcrumb_status'] = $new_breadcrumbs;
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>
