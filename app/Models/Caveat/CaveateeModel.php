<?php

namespace App\Models\Caveat;
use CodeIgniter\Model;

class CaveateeModel extends Model {

    function __construct() {
        parent::__construct();
    }

    function add_caveatee($registration_id, $data, $cis_masters_values) {
      
        $this->db->transStart();
		$builder = $this->db->table('tbl_efiling_caveat');
        //$this->db->transStart();
        $builder->WHERE('ref_m_efiling_nums_registration_id', $registration_id);
        
        $compiledQuery = $builder->set($data)->getCompiledUpdate();
      //echo $compiledQuery;die;
        $query= $builder->UPDATE($data);
      
       
        if ($this->db->affectedRows() > 0) {
             $success = true;
                if ($success) {
                   
                    $status = $this->update_breadcrumbs($registration_id, CAVEAT_BREAD_CAVEATEE);
                  
                    if ($status) {
                       
                        $status = $this->update_breadcrumbs($registration_id, CAVEAT_BREAD_EXTRA_PARTY);
                        $this->db->transComplete();
                    }
                }
         
        }
       // pr('kii');
        if ($this->db->transStatus() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function update_cis_master_values($registration_id, $data) {
		$builder = $this->db->table('tbl_cis_masters_values');
        $builder->WHERE('registration_id', $registration_id);
        $query = $builder->get();
        if ($query->getNumRows() > 0) {
            $builder->WHERE('registration_id', $registration_id);
            $result = $builder->UPDATE($data);
            if ($this->db->affectedRows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
			$builder = $this->db->table('tbl_cis_masters_values');
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
            $result = $builder->INSERT($cis_masters_values);
            if ($this->db->insertID()) {
                return true;
            } else {
                return false;
            }
        }
    }

    function update_breadcrumbs($registration_id, $breadcrumb_step) {
        $old_breadcrumbs = getSessionData('efiling_details')['breadcrumb_status'] . ',' . $breadcrumb_step;
        $old_breadcrumbs_array = explode(',', $old_breadcrumbs);
        $new_breadcrumbs_array = array_unique($old_breadcrumbs_array);
        // $session = session();
        sort($new_breadcrumbs_array);
        $new_breadcrumbs = implode(',', $new_breadcrumbs_array);
		$builder = $this->db->table('efil.tbl_efiling_nums');
        $builder->WHERE('registration_id', $registration_id);
        $builder->UPDATE(array('breadcrumb_status' => $new_breadcrumbs));
        if ($this->db->affectedRows() > 0) {



            $_SESSION['efiling_details']['breadcrumb_status']=$new_breadcrumbs;
            // $session->set([
            //     'efiling_details' => [
            //         'breadcrumb_status' => $new_breadcrumbs
            //     ]
            // ]);
            return TRUE;
        } else {
            return FALSE;
        }
    }

}