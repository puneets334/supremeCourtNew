<?php

namespace App\Models\Department;
use CodeIgniter\Model;

class Department_model extends Model {

    function __construct() {
// Call the Model constructor
        parent::__construct();
    }

    /*function add_department_user($data, $department, $catagory) {

        $this->db->trans_start();
        $this->db_2 = $this->load->database(unserialize(dynamic_users_table_connection), TRUE);
        $this->db_2->INSERT('users', $data);
        $dept_usr_id = $this->db_2->insert_id();


        if ($dept_usr_id) {
            if ($department != NULL) {
                $this->db->SELECT('id,parent_ids as parent_ids,dep_user_id,catagory');
                $this->db->FROM('m_tbl_departments');
                $this->db->WHERE('dep_user_id', $_SESSION['login']['id']);

                $query = $this->db->get();
                $parent_dept_id = '';
                if ($query->num_rows() >= 1) {
                    $result = $query->result();

                    $parent_id = substr($result[0]->parent_ids, 1, -1);
                    if (!empty($parent_id)) {

                        $parent_ids = "{" . $result[0]->id . ',' . $parent_id . "}";
                        $p_ids = explode(',', $parent_id);
                        $parent_dept_id = $p_ids[count($p_ids) - 1];
                    } else {
                        $parent_ids = "{" . $result[0]->id . "}";

                        $parent_dept_id = $result[0]->id;
                    }
                    $catag = $result[0]->catagory;
                } else {
                    $parent_ids = NULL;
                    $catag = $catagory;
                }



                $dep_data = array('department' => $department, 'parent_ids' => $parent_ids, 'dep_user_id' => $dept_usr_id, 'catagory' => $catag, 'created_by' => $_SESSION['login']['id']);
                $this->db->INSERT('m_tbl_departments', $dep_data);
                if (!empty($this->db->insert_id()) && $_SESSION['login']['ref_m_usertype_id'] == USER_SUPER_ADMIN) {
                    $this->db->trans_complete();
                } elseif (!empty($this->db->insert_id())) {

                    $curr_dept_id = $this->db->insert_id();
                    $update_query = "Update tbl_dept_advocate_panel set all_dept_ids=array_prepend($curr_dept_id, all_dept_ids) where parent_dept_id=" . $parent_dept_id;
                    $query_update = $this->db->query($update_query);
                    if ($query_update) {
                        $this->db->trans_complete();
                    } else {
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

    function get_dept_users($dep_user_id) {

        $sql = "SELECT *,users.is_active as active_user FROM m_tbl_departments dp 
                 JOIN  " . dynamic_users_table . " on users.id=dp.dep_user_id
                WHERE (select id as dept_id from m_tbl_departments where dep_user_id = " . $dep_user_id . ") =any(parent_ids)  Order by created_datetime desc";

        $query = $this->db->query($sql);

        if ($query->num_rows() >= 1) {
            $result = $query->result_array();

            return $result;
        } else {
            return FALSE;
        }
    }

    function get_dept_details($dep_user_id) {

        $sql = "SELECT * FROM m_tbl_departments dp 
                 JOIN  " . dynamic_users_table . " on users.id=dp.dep_user_id
                  WHERE users.id=" . $dep_user_id;

        $query = $this->db->query($sql);

        if ($query->num_rows() >= 1) {
            $result = $query->result_array();

            return $result;
        } else {
            return FALSE;
        }
    }

    function update_department_user($dep_id, $data, $department, $catagory) {
        $this->db_2 = $this->load->database(unserialize(dynamic_users_table_connection), TRUE);
        $this->db_2->WHERE('id', $dep_id);
        $this->db_2->UPDATE('users', $data);
        if (!empty($department)) {
            if ($_SESSION['login']['ref_m_usertype_id'] == USER_SUPER_ADMIN) {
                $dep_data = array('department' => $department, 'catagory' => $catagory);
            } else {
                $dep_data = array('department' => $department);
            }
            $this->db->WHERE('dep_user_id', $dep_id);
            $this->db->UPDATE('m_tbl_departments', $dep_data);
        }
        if ($this->db_2->affected_rows() > 0 || $this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function check_email_present($email, $dep_id) {
        $this->db->SELECT('*');
        $this->db->FROM(dynamic_users_table);
        $this->db->WHERE('users.emailid', $email);
        $this->db->WHERE('users.id!=', $dep_id);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return TRUE;
        } else {
            return false;
        }
    }

    function check_mobno_present($mobile, $dep_id) {
        $this->db->SELECT('*');
        $this->db->FROM(dynamic_users_table);
        $this->db->WHERE('users.moblie_number', $mobile);
        $this->db->WHERE('users.id!=', $dep_id);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return TRUE;
        } else {
            return false;
        }
    }

    function get_advocate_data($first_name, $last_name, $mobile, $barcode) {

        $this->db->SELECT('users.id user_id,*');
        $this->db->FROM(dynamic_users_table);
        $this->db->JOIN('m_tbl_state st', 'users.ref_m_states_id= st.state_id', 'LEFT');
        $this->db->JOIN('m_tbl_districts dist', 'users.enrolled_district_id=dist.id', 'LEFT');
        if (!empty($mobile)) {
            $this->db->OR_WHERE('users.moblie_number', $mobile);
        }
        if (!empty($first_name)) {
            $this->db->OR_LIKE('UPPER(users.first_name)', $first_name);
        }
        if (!empty($last_name)) {
            $this->db->OR_LIKE('UPPER(users.last_name)', $last_name);
        }
        if (!empty($barcode)) {
            $this->db->OR_WHERE('users.bar_reg_no', $barcode);
        }
        $this->db->WHERE('users.ref_m_usertype_id', USER_ADVOCATE);
        $this->db->WHERE('users.is_active', TRUE);
        $query = $this->db->get();

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function add_dept_advocate_data($data) {

        $this->db->INSERT_BATCH('tbl_dept_advocate_panel', $data);

        if ($this->db->insert_id()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_dep_adv_data($parents) {
        $this->db->SELECT('advocate_id');
        $this->db->FROM('tbl_dept_advocate_panel');
        $this->db->WHERE('advocate_id', $adv_id);
        $this->db->WHERE('parent_dept_id', $parents);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_dept_adv_panel($dep_user_id) {
        $sql = "SELECT *,users.id as user_id,dp.id as depid from " . dynamic_users_table . "
                   JOIN tbl_dept_advocate_panel dap  on users.id=dap.advocate_id
                   JOIN m_tbl_departments dp on dap.parent_dept_id=dp.id
                   LEFT  JOIN m_tbl_state st on users.ref_m_states_id= st.state_id
                   LEFT JOIN m_tbl_districts dist on users.enrolled_district_id=dist.id
                   WHERE (select id as dept_id from m_tbl_departments where dep_user_id =" . $dep_user_id . ")=any(all_dept_ids) Order by created_datetime desc";

        $query = $this->db->query($sql);

        if ($query->num_rows() >= 1) {
            $result = $query->result_array();

            return $result;
        } else {
            return FALSE;
        }
    }

    function get_advocate_panel($dep_user_id) {
        $sql = "SELECT DISTINCT users.id user_id, users.first_name,users.last_name  from " . dynamic_users_table . "
                    JOIN tbl_dept_advocate_panel dap  on users.id=dap.advocate_id
                    join  tbl_efiling_nums en on dap.advocate_id=en.created_by 
                    LEFT JOIN m_tbl_departments dp on dap.added_by=dp.id 
                    WHERE (select id as dept_id from m_tbl_departments where  dep_user_id =" . $dep_user_id . ")=any(all_dept_ids) and en.efiling_for_type_id = '" . $_SESSION['estab_details']['efiling_for_type_id'] . "' and en.efiling_for_id = '" . $_SESSION['estab_details']['efiling_for_id'] . "'";

        $query = $this->db->query($sql);

        if ($query->num_rows() >= 1) {
            $result = $query->result_array();

            return $result;
        } else {
            return FALSE;
        }
    }

    function get_all_advocate_panel($dep_user_id) {
        $sql = "SELECT DISTINCT users.id user_id, users.first_name,users.last_name  from " . dynamic_users_table . "
                     JOIN tbl_dept_advocate_panel dap  on users.id=dap.advocate_id
                    LEFT JOIN m_tbl_departments dp on dap.added_by=dp.id 
                     WHERE (select id as dept_id from m_tbl_departments where dep_user_id =" . $dep_user_id . ")=any(all_dept_ids)";

        $query = $this->db->query($sql);

        if ($query->num_rows() >= 1) {
            $result = $query->result_array();

            return $result;
        } else {
            return FALSE;
        }
    }

    function get_dept_incharge_data($dep_id) {

        $this->db->SELECT('users.first_name, users.last_name');
        $this->db->FROM(dynamic_users_table);
        $this->db->JOIN('m_tbl_departments dp', 'users.id=dp.dep_user_id');
        $this->db->WHERE('dp.id', $dep_id);
        $this->db->ORDER_BY('created_datetime', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function delete_department_advocate($advid, $dept_id) {
        $this->db->WHERE('advocate_id', $advid);
        $this->db->WHERE('dep_incharge_id', $dept_id);
        $this->db->DELETE('tbl_dept_advocate_panel');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_alloted_advocate($regid) {
        $this->db->SELECT('users.*');
        $this->db->FROM(dynamic_users_table);
        $this->db->JOIN('tbl_efiling_nums en', 'users.id=en.created_by');
        $this->db->WHERE('sub_created_by', $_SESSION['login']['id']);
        $this->db->WHERE('en.registration_id', $regid);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_superadmin_department() {
        $this->db->SELECT('*,users.is_active as active_user');
        $this->db->FROM('m_tbl_departments dp');
        $this->db->JOIN(dynamic_users_table, 'dp.dep_user_id=users.id');
        $this->db->WHERE('created_by', $_SESSION['login']['id']);
        
        $query = $this->db->get();
       // echo $this->db->last_query();
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_department_details($dep_user_id) {
        $this->db->SELECT('id,parent_ids, parent_ids[array_length(parent_ids,1)] as parent,array_prepend("id", "parent_ids") as all_dep');
        $this->db->FROM('m_tbl_departments dp');
        $this->db->WHERE('dep_user_id', $_SESSION['login']['id']);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }*/
    // Return list of AORs for given department
    function get_department_aor($department_id)
    {
        $result = null;
        $this->db->select('ad.*, b.name');
        $this->db->FROM('efil.aor_department ad');
        $this->db->join('icmis.bar b', 'b.aor_code=ad.aor_code');
        $this->db->WHERE('ref_department_id', $department_id);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            $result = $query->result();
        }
        return $result;
    }

    // Return list of departments for given AOR
    function get_aor_department($aor_code)
    {
        $output = null;
        $builder=$this->db->table('efil.aor_department ad');
        $builder->select('dep.*');
        $builder->join('efil.m_departments dep', 'dep.id =ad.ref_department_id');
        $builder->where('aor_code', $aor_code);
        $builder->orderBy('id','ASC');
        $query = $builder->get();
        if ($query->getNumRows() >= 1) {
            $output = $query->getResult();
        }
        return $output;
    }

    function selected_aor_for_case($registration_id)
    {
        $result = null;
        $builder = $this->db->table('efil.department_filings');
        $builder->where('registration_id', $registration_id);

        $query = $builder->get();
        $output = $query->getResult();
        if ($query->getNumRows() >= 1) {
            $result = $output;
        }
        return $result;
    }




}
