<?php

namespace App\Models\OnlineCopying;

use CodeIgniter\Model;
use Config\Database;
class AddressModel extends Model
{
    protected $db2;
    protected $table = 'user_address'; // Make sure this matches your table name
    protected $primaryKey = 'id'; // Set the primary key if necessary

    // Specify the fields allowed for mass assignment
    protected $allowedFields = [
        'mobile',
        'email',
        'first_name',
        'second_name',
        'address_type',
        'address',
        'city',
        'district',
        'state',
        'pincode',
        'country',
        'entry_time_ip',
    ];
    function __construct()
    {
        parent::__construct();
        $this->db2 = Database::connect('sci_cmis_final'); // Connect to the 'sci_cmis_final' database
        $this->db3 = Database::connect('e_services'); 

    }

    public function checkUserAddress($mobile, $email)
    {
        // Build the query
        $builder = $this->db3->table('user_address'); 
        $builder->where('mobile', $mobile)
                ->where('email', $email)
                ->where('is_active', 'Y');        
        $query = $builder->get();
        $result = $query->getResultArray();

        
        // Return the result
        return $result;
    }

    public function verifyAadhar($mobile, $email)
    {
        $db3 = \Config\Database::connect('e_services'); 
        $session = \Config\Services::session();
        $builder = $this->db3->table('uidai_offline_kyc');
        $builder->select('adhar_name AS user_name, CONCAT(careof, " ", house, " ", landmark, " ", loc, " ", po, " ", street, " ", vtc) AS address, subdist AS city, district, state, pc AS pincode');
        $builder->where('mobile', $mobile);
        $builder->where('email', $email);
        $builder->limit(1);
        $query = $builder->get();

        if ($query === false) {           
            return false;
        }else {
            $result = $query->getResult();           
        }
        return $result;
    }


    public function getListedCases($mobile, $email)
    {
        $builder = $this->db2->table('master.bar');           
        $builder->select('name AS user_name, caddress AS address, ccity AS city, ccity AS district, "" AS state, "" AS pincode');
        $builder->where('mobile', $mobile);
        $builder->where('email', $email);
        $builder->limit(1);
        $query = $builder->get();
        if ($query === false) {           
            return false;
        }else {
            $result = $query->getResult();           
        }
        return $result;
    } 


    public function getPincode($pincode)
    {
        $builder = $this->db2->table('master.post_distance_master');           
        $builder->select('taluk_name, district_name, state');
        $builder->where('pincode', $pincode);
        // $sql = $builder->getCompiledSelect();
        // echo "<pre>$sql</pre>";
        $query = $builder->get();
        if ($query === false) {           
            return false;
        }else {
            $result = $query->getRow();           
        }
        return $result;
        
    } 






   

}
