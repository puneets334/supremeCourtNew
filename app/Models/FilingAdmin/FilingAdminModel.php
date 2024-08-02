<?php

namespace App\Models\FilingAdmin;

use CodeIgniter\Model;


class FilingAdminModel extends Model
{   
    protected $table = 'efil.tbl_users';
    protected $primaryKey = 'id';

    function __construct()
    {
        parent::__construct();
        $db      = \Config\Database::connect();    
    
    }
  


   
    public function getAssignedUser($params = array())
{
    $output = false;

    if (isset($params['user_type']) && !empty($params['user_type']) && isset($params['not_in_user_id']) && !empty($params['not_in_user_id'])) {
        $builder = $this->db->table('efil.tbl_users as users');
        $builder->select('users.*, trim(array_agg(tfaaf.file_type_id)::text, \'{}\') as file_type_id, 
            tfaaf.user_id, trim(array_agg(mtet.efiling_type)::text, \'{}\') as efiling_type');
        $builder->join('efil.tbl_filing_admin_assigned_file as tfaaf', 'users.id = tfaaf.user_id', 'left');
        $builder->join('efil.m_tbl_efiling_type as mtet', 'tfaaf.file_type_id = mtet.id', 'left');
        $builder->where('users.is_active', '1');
        $builder->where('tfaaf.is_active', '1');
        $builder->where('users.ref_m_usertype_id', $params['user_type']);
        $builder->whereNotIn('users.id', $params['not_in_user_id']);
        $builder->groupBy('users.id, users.first_name, users.emp_id, users.attend, users.moblie_number, users.emailid, users.pp_a, tfaaf.user_id');
        $builder->orderBy('tfaaf.user_id', 'DESC');
        $query = $builder->get();
        $output = $query->getResult();
    }

    return $output;
}
    

   

    
    public function getAssignedCaseByUserId($params = array())
    {
        $output = false;
        if (isset($params['type']) && !empty($params['type']) && $params['type'] == 1) {
            if (isset($params['allocated_to']) && !empty($params['allocated_to'])) {                
                $builder = $this->db->table('efil.tbl_efiling_nums en');
                $builder->SELECT("en.allocated_to,en.registration_id,en.efiling_no,met.efiling_type,
                    (case when SUBSTRING(en.efiling_no,1,2) = 'EC' then tcd.cause_title 
                    else case when SUBSTRING(en.efiling_no,1,2) = 'EK' then ec.pet_name
                    else case when SUBSTRING(en.efiling_no,1,2) = '' then NULL 
                    end end end)as cause_title ,
                 (case when SUBSTRING(en.efiling_no,1,2) = 'EA' then CONCAT(mia.diary_no,'/',mia.diary_year)
                        else case when SUBSTRING(en.efiling_no,1,2) = 'ED' then CONCAT(mia.diary_no,'/',mia.diary_year)
                        else case when SUBSTRING(en.efiling_no,1,2) = '' then NULL 
                        end end end)as diaryDetails ");
                // $this->db->FROM('efil.tbl_efiling_nums en');
                $builder->JOIN('efil.tbl_efiling_num_status ens', 'en.registration_id=ens.registration_id');
                $builder->JOIN('efil.tbl_case_details tcd', 'en.registration_id = tcd.registration_id', 'left');
                $builder->JOIN('public.tbl_efiling_caveat ec', 'en.registration_id = ec.ref_m_efiling_nums_registration_id', 'left');
                $builder->JOIN('efil.tbl_misc_docs_ia mia', 'en.registration_id = mia.registration_id', 'left');
                $builder->JOIN('efil.m_tbl_efiling_type met', 'en.ref_m_efiled_type_id = met.id');
                $builder->WHERE('en.is_active', '1');
                $builder->WHERE('ens.is_active', '1');
                if (isset($params['stage_id']) && !empty($params['stage_id'])) {
                    $builder->whereIn('ens.stage_id', $params['stage_id']);
                }
                $builder->WHERE('en.allocated_to', (int)$params['allocated_to']);
                $builder->orderBy('tcd.id ', 'ASC');
                $query = $builder->get();
                $output = $query->getResult();
            }
        } else   if (isset($params['type']) && !empty($params['type']) && $params['type'] == 2) {
            $builder = $this->db->table('efil.tbl_efiling_nums en');
            $builder->SELECT("en.allocated_to,en.registration_id,en.efiling_no,met.efiling_type,
                    (case when SUBSTRING(en.efiling_no,1,2) = 'EC' then tcd.cause_title 
                    else case when SUBSTRING(en.efiling_no,1,2) = 'EK' then ec.pet_name
                    else case when SUBSTRING(en.efiling_no,1,2) = '' then NULL 
                    end end end)as cause_title ,
                 (case when SUBSTRING(en.efiling_no,1,2) = 'EA' then CONCAT(mia.diary_no,'/',mia.diary_year)
                        else case when SUBSTRING(en.efiling_no,1,2) = 'ED' then CONCAT(mia.diary_no,'/',mia.diary_year)
                        else case when SUBSTRING(en.efiling_no,1,2) = '' then NULL 
                        end end end)as diaryDetails
            ");
            // $builder->FROM('efil.tbl_efiling_nums en');
            $builder->join('efil.tbl_efiling_num_status ens', 'en.registration_id=ens.registration_id');
            $builder->join('efil.tbl_case_details tcd', 'en.registration_id = tcd.registration_id', 'left');
            $builder->join('public.tbl_efiling_caveat ec', 'en.registration_id = ec.ref_m_efiling_nums_registration_id', 'left');
            $builder->join('efil.tbl_misc_docs_ia mia', 'en.registration_id = mia.registration_id', 'left');
            $builder->join('efil.m_tbl_efiling_type met', 'en.ref_m_efiled_type_id = met.id');
            $builder->where('en.is_active', '1');
            $builder->where('ens.is_active', '1');
            if (isset($params['stage_id']) && !empty($params['stage_id'])) {
                $builder->whereIn('ens.stage_id', $params['stage_id']);
            }
            $builder->where('en.allocated_to', (int)$params['allocated_to']);
            $builder->orderBy('tcd.id ', 'ASC');

            $query = $builder->get();
            $output = $query->getResult();
        }

        return $output;
    }

    // public function getAssignedUserByUserId($params = array())
    // {
    //     $output = false;
    //     $type = (!empty($params['type'])) ? (int)$params['type'] : NULL;
    //     if (isset($type) && !empty($type)) {
    //         switch ($type) {
    //             case 1:
    //                 if (isset($params['user_type']) && !empty($params['user_type']) && isset($params['not_in_user_id']) && !empty($params['not_in_user_id'])) {
    //                     $builder = $this->db->table('efil.tbl_users tu');
                       
    //                     $builder->SELECT('tu.first_name,tu.emp_id,tu.attend,tu.pp_a,trim(array_agg(tfaaf.file_type_id)::text, \'{}\') file_type_id ,
    //                           trim(array_agg(mtet.efiling_type)::text, \'{}\') efiling_type');
    //                     // $builder->FROM('efil.tbl_users tu');
    //                     $builder->JOIN('efil.tbl_filing_admin_assigned_file tfaaf', 'tu.id=tfaaf.user_id', 'left');
    //                     $builder->JOIN('efil.m_tbl_efiling_type mtet', 'tfaaf.file_type_id=mtet.id', 'left');
    //                     $builder->WHERE('tu.is_active', '1');
    //                     $builder->WHERE('tfaaf.is_active', '1');
    //                     $builder->WHERE('tfaaf.user_id', (int)$params['userId']);
    //                     $builder->WHERE('tu.ref_m_usertype_id', $params['user_type']);
    //                     $builder->whereNotIn('tu.id', $params['not_in_user_id']);
    //                     $builder->groupBy('tu.first_name,tu.emp_id,tu.attend,tu.moblie_number,tu.emailid,tu.pp_a,tfaaf.user_id');
    //                     $builder->orderBy('tfaaf.user_id', 'DESC');
    //                     $sql = $builder->getCompiledSelect();
    //                     echo $sql;

    //                     $query = $builder->get();
    //                     $output = $query->getResult();
    //                 }
    //                 break;
    //             case 2:
                    
    //                 if (isset($params['user_type']) && !empty($params['user_type']) && isset($params['not_in_user_id']) && !empty($params['not_in_user_id'])) {
    //                     $builder = $this->db->table('efil.tbl_users tu');
    //                     $builder->SELECT('tu.first_name,tu.first_name,tu.emp_id,tu.attend,tu.pp_a,tfaaf.user_id,trim(array_agg(tfaaf.file_type_id)::text, \'{}\') file_type_id ,
    //                           trim(array_agg(mtet.efiling_type)::text, \'{}\') efiling_type');
    //                     // $builder->FROM('efil.tbl_users tu');
    //                     $builder->join('efil.tbl_filing_admin_assigned_file tfaaf', 'tu.id=tfaaf.user_id', 'left');
    //                     $builder->join('efil.m_tbl_efiling_type mtet', 'tfaaf.file_type_id=mtet.id', 'left');
    //                     $builder->where('tu.is_active', '1');
    //                     $builder->where('tu.attend', 'P');
    //                     $builder->where('tfaaf.is_active', '1');
    //                     $builder->where('tfaaf.user_id', (int)$params['userId']);
    //                     $builder->where('tu.ref_m_usertype_id', $params['user_type']);
    //                     $builder->whereNotIn('tu.id', $params['not_in_user_id']);
    //                     $builder->groupBy('tu.first_name,tu.emp_id,tu.attend,tu.moblie_number,tu.emailid,tu.pp_a,tfaaf.user_id');
    //                     $builder->orderBy('tfaaf.user_id', 'DESC');
    //                     $sql = $builder->getCompiledSelect();
    //                     // echo $sql;
    //                     $query = $builder->get();
    //                     $output = $query->getResult();
    //                 }
    //                 break;
    //             default:
    //                 $output = false;
    //         }
    //     }

    //    return $output;
    // }

    
 
    public function getAssignedUserByUserId($params = []) {
        $output = false;
        $type = $params['type'] ? $params['type'] : null;
        if ($type) {
            if ($type == 1) {
                if (!empty($params['user_type']) && !empty($params['not_in_user_id'])) {
                    $builder = $this->db->table('efil.tbl_users tu');
                    $builder->select('tu.first_name,tu.emp_id,tu.attend,tu.pp_a,trim(array_agg(tfaaf.file_type_id)::text, \'{}\') file_type_id , trim(array_agg(mtet.efiling_type)::text, \'{}\') efiling_type');
                    $builder->join('efil.tbl_filing_admin_assigned_file tfaaf','tu.id=tfaaf.user_id','left');
                    $builder->join('efil.m_tbl_efiling_type mtet','tfaaf.file_type_id=mtet.id','left');
                    $builder->where('tu.is_active', '1');
                    $builder->where('tfaaf.is_active', '1');
                    $builder->where('tfaaf.user_id', (int)$params['userId']);
                    $builder->where('tu.ref_m_usertype_id', $params['user_type']);
                    $builder->whereNotIn('tu.id', $params['not_in_user_id']);
                    $builder->groupBy('tu.first_name,tu.emp_id,tu.attend,tu.moblie_number,tu.emailid,tu.pp_a,tfaaf.user_id');
                    $builder->orderBy('tfaaf.user_id','DESC');
                    $query = $builder->get();
                    $output = $query->getResultArray();
                       
                }
            } elseif ($type == 2)
            {
                if (!empty($params['user_type']) && !empty($params['not_in_user_id'])) {
                            $builder = $this->db->table('efil.tbl_users tu');
                            $builder->select('tu.first_name,tu.emp_id,tu.attend,tu.pp_a,trim(array_agg(tfaaf.file_type_id)::text, \'{}\') file_type_id , trim(array_agg(mtet.efiling_type)::text, \'{}\') efiling_type');
                            $builder->join('efil.tbl_filing_admin_assigned_file tfaaf','tu.id=tfaaf.user_id','left');
                            $builder->join('efil.m_tbl_efiling_type mtet','tfaaf.file_type_id=mtet.id','left');
                            $builder->where('tu.is_active', '1');
                            $builder->where('tu.attend','P');
                            $builder->where('tfaaf.is_active', '1');
                            $builder->where('tfaaf.user_id', (int)$params['userId']);
                            $builder->where('tu.ref_m_usertype_id', $params['user_type']);
                            $builder->whereNotIn('tu.id', $params['not_in_user_id']);
                            $builder->groupBy('tu.first_name,tu.emp_id,tu.attend,tu.moblie_number,tu.emailid,tu.pp_a,tfaaf.user_id');
                            $builder->orderBy('tfaaf.user_id','DESC');
                            $query = $builder->get();
                            $output = $query->getResultArray();
                }
            }
        }

        return $output;
    }
  
    


    // public function getAssignedUserByUserId($params = [])
    // {
    //    // pr($params);
    //     $output = false;
    //     $type = $params['type'] ?? null;

    //     if ($type) {
    //         $builder = $this->db->table('efil.tbl_users tu');

    //         // Common parts for both type 1 and type 2 queries
    //         $builder->select('tu.first_name, tu.emp_id, tu.attend, tu.pp_a, 
    //                 TRIM(BOTH \'{}\' FROM ARRAY_AGG(tfaaf.file_type_id)::TEXT) AS file_type_id, 
    //                 TRIM(BOTH \'{}\' FROM ARRAY_AGG(mtet.efiling_type)::TEXT) AS efiling_type')
    //             ->join('efil.tbl_filing_admin_assigned_file tfaaf', 'tu.id = tfaaf.user_id', 'left')
    //             ->join('efil.m_tbl_efiling_type mtet', 'tfaaf.file_type_id = mtet.id', 'left')
    //             ->where('tu.is_active', '1')
    //             ->where('tfaaf.is_active', '1')
    //             // ->where('tu.ref_m_usertype_id', $params['user_type'])
    //             // ->whereNotIn('tu.id', $params['not_in_user_id'])
    //             ->groupBy('tu.first_name, tu.emp_id, tu.attend, tu.pp_a, tfaaf.user_id')
    //             ->orderBy('tfaaf.user_id', 'DESC');

    //         // Add specific conditions for each type
    //         if ($type == 1) {
    //             $builder->where('tfaaf.user_id', (int)$params['userId']);
    //         } elseif ($type == 2) {
    //             $builder->where('tu.attend', 'P')
    //                 ->where('tfaaf.user_id', (int)$params['userId']);
    //         }

    //         $sql = $builder->getCompiledSelect();
    //         log_message('debug', 'Generated SQL: ' . $sql);

    //         $query = $builder->get();
    //         $output = $query->getRow(); // Assuming you expect a single row

    //         // Optionally, log the generated SQL for debugging
    //         log_message('debug', 'Generated SQL: ' . $sql);
    //     }

    //     return $output;
    // }

    public function getUserRoleByUserId($params = array())
    {
        $output = false;
        if (isset($params['userId']) && !empty($params['userId'])) {
            $builder = $this->db->table('efil.tbl_filing_admin_assigned_file tfaaf');
            $builder->select('user_id,trim(array_agg(file_type_id)::text, \'{}\') file_type_id');
            $builder->where('tfaaf.user_id', $params['userId']);
            $builder->where('tfaaf.is_active', '1');
            $builder->groupBy('tfaaf.user_id');
            $sql = $builder->getCompiledSelect();
            $query = $builder->get();
            $output = $query->getResult();
        }
        return $output;
    }

    public function getFileTypeByRegistrationId($params = array())
    {
        $output = false;
        if (isset($params['registration_id']) && !empty($params['registration_id'])) {
            $builder = $this->db->table('efil.tbl_efiling_nums en');
            $builder->select('en.registration_id,en.ref_m_efiled_type_id,en.efiling_no');
            $builder->whereIn('en.registration_id', $params['registration_id']);
            $builder->where('en.is_active', '1');
            $builder->where('en.is_deleted', false);
            $query =  $builder->get();
            $output = $query->getResult();
        }
        return $output;
    } 
    // public function updateTableData($params = array())
    // {
    //     $output = false;
    //     if (
    //         isset($params['table_name']) && !empty($params['table_name'])
    //         && !empty($params['whereFieldName']) && isset($params['whereFieldName'])
    //         && isset($params['whereFieldValue']) && !empty($params['whereFieldValue'])
    //         && isset($params['updateArr']) && !empty($params['updateArr'])
    //     )
    //     {
          
    //         $builder = $this->db->table($params['table_name']);
    //         $builder->where($params['whereFieldName'], $params['whereFieldValue']);                
    //         if($builder->update($params['updateArr'])) {
    //             $output = true;
    //         }



    //     }
    //     return $output;
    // }
    public function updateTableData($tableName, $whereFieldName, $whereFieldValue, $updateArr)
{
    $output = false;
    if (
        isset($tableName) && !empty($tableName) &&
        isset($whereFieldName) && !empty($whereFieldName) &&
        isset($whereFieldValue) && !empty($whereFieldValue) &&
        isset($updateArr) && !empty($updateArr)
    ) {
        $builder = $this->db->table($tableName);
        $builder->where($whereFieldName, $whereFieldValue);
        
        if ($builder->update($updateArr)) {
            $output = true;
        }
    }
    return $output;
}

public function getAllRecordFromTable(array $params = [])
{
    $output = false;

    if (isset($params['table_name']) && !empty($params['table_name'])) {
        $builder = $this->db->table($params['table_name']);
        $builder->select('*');

        if (isset($params['is_active']) && !empty($params['is_active'])) {
            $builder->where('is_active', $params['is_active']);
        }

        if (isset($params['id']) && !empty($params['id'])) {
            $builder->whereIn('id', $params['id']);
        }

        $query = $builder->get();
        $output = $query->getResult();
    }

    return $output;
}













public function insertData($tableName, $data)
{
    $output = false;
    if (isset($tableName) && !empty($tableName) && isset($data) && !empty($data)) {
        $builder = $this->db->table($tableName);
        $builder->insert($data);

        $output = $this->db->insertID();
    }
    return $output;
}

public function insertBatchData($tableName, $data)
{
    $output = false;
    if (isset($tableName) && !empty($tableName) && isset($data) && !empty($data)) {
        $builder = $this->db->table($tableName);
        $builder->insertBatch($data);
        $output = true; 
    }
    return $output;
}


/* 
    public function insertData($tableName, $data)
    {
        $output = false;
        if (isset($tableName) && !empty($tableName) && isset($data) && !empty($data)) {
            $this->db->insert($tableName, $data);
            $output = $this->db->insert_id();
        }
        return $output;
    }
    public function insertBatchData($tableName, $data)
    {
        $output = false;
        if (isset($tableName) && !empty($tableName) && isset($data) && !empty($data)) {
            $this->db->INSERT_BATCH($tableName, $data);
            $output = $this->db->insert_id();
        }
        return $output;
    }
    public function getData($params = array())
    {
        $output = false;
        if (
            isset($params['table_name']) && !empty($params['table_name'])
            && !empty($params['whereFieldName']) && isset($params['whereFieldName'])
            && isset($params['whereFieldValue']) && !empty($params['whereFieldValue'])
        ) {
            $this->db->SELECT('*');
            $this->db->FROM($params['table_name']);
            $this->db->WHERE($params['whereFieldName'], $params['whereFieldValue']);
            if (isset($params['is_active']) && !empty($params['is_active'])) {
                $this->db->WHERE('is_active', $params['is_active']);
            }
            $query = $this->db->get();
            $output = $query->result();
        }
        return $output;
    }
    
    
   
    
   
    
   */
}
