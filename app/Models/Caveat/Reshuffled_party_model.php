<?php

namespace App\Models\Caveat;
use CodeIgniter\Model;

class Reshuffled_party_model extends Model {

    function __construct() {
        parent::__construct();
    }

    function get_extra_parties_without_lrs($registration_id, $shuffle_party_type) {

        $this->db->SELECT('id,type, party_no, name, parentid, party_id, legal_heir');
        $this->db->FROM('tbl_efiling_civil_extra_party ex');
        $this->db->WHERE('ex.ref_m_efiling_nums_registration_id', $registration_id);
        $this->db->WHERE('ex.parentid IS NULL');
        $this->db->WHERE('ex.type', $shuffle_party_type);
        $this->db->ORDER_BY('type');
        $this->db->ORDER_BY('cast(party_id as float)');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    function get_extra_parties_with_lrs($registration_id, $shuffle_party_type) {

        $this->db->SELECT('id,type, party_no, name, parentid, party_id, legal_heir');
        $this->db->FROM('tbl_efiling_civil_extra_party ex');
        $this->db->WHERE('ex.ref_m_efiling_nums_registration_id', $registration_id);
        $this->db->WHERE('ex.type', $shuffle_party_type);
        $this->db->ORDER_BY('type');
        $this->db->ORDER_BY('cast(party_id as float)');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    function update_extra_party_position($data, $parent_data) {

        $this->db->trans_start();
        $this->db->update_batch('tbl_efiling_civil_extra_party', $data, 'id');
        if ($this->db->affected_rows() > 0) {
            if (!empty($parent_data)) {
                $this->db->update_batch('tbl_efiling_civil_extra_party', $parent_data, 'id');
            }
            $this->db->trans_complete();
        }
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
