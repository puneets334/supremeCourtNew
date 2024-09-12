<?php
namespace App\Controllers\OnlineCopying;

use App\Controllers\BaseController;
use App\Models\OnlineCopying\CommonModel;
use App\Models\OnlineCopying\AddressModel;
use Config\Database;
class AddressController extends BaseController
{

    protected $session;
    protected $Common_model;
    protected $AddressModel;
    protected $db2;

    public function __construct()
    {
        parent::__construct();
        $this->session = \Config\Services::session();
        $_SESSION['is_token_matched'] = 'Yes';
        if (empty($this->session->get('login'))) {
            return response()->redirect(base_url('/'));
        } else {
            is_user_status();
        }
        $this->db2 = Database::connect('sci_cmis_final'); // Connect to the 'sci_cmis_final' database
        $this->Common_model = new CommonModel();
        $this->AddressModel = new AddressModel();
    

        unset($_SESSION['MSG']);
        unset($_SESSION['msg']);
    }

    public function applicantAddress()
    {
        $mobile_number=$emailid='';
        if(!empty(getSessionData('login')['mobile_number'])){
            $mobile_number=getSessionData('login')['mobile_number'];
        }

        if(!empty(getSessionData('login')['emailid'])){
            $emailid=getSessionData('login')['emailid'];
        }
        $verifyAadhar=$userAddress=$userBarAddress=[];
        $userAddress= $this->AddressModel->checkUserAddress($mobile_number,$emailid );
        $userAdharVerify= $this->AddressModel->verifyAadhar($mobile_number,$emailid );
        $userBarAddress= $this->AddressModel->getListedCases($mobile_number,$emailid );
        
         
        return $this->render('onlineCopying.applicant_address', @compact('userAddress','userAdharVerify','userBarAddress'));
    }

    function getClientIP(){
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
    
        return $ipaddress;
    }

    public function saveApplicantAddress() 
    {
       
        if ($_SESSION['is_token_matched'] == 'Yes' && getSessionData('login')['emailid'] && getSessionData('login')['mobile_number'])
        {   
            $request = service('request');  
            $clientIP = $this->getClientIP(); 
            $applicantMobile=$applicantEmail='';
            if(!empty(getSessionData('login')['mobile_number'])){
                $applicantMobile=getSessionData('login')['mobile_number'];
            }
            if(!empty(getSessionData('login')['emailid'])){
                $applicantEmail=getSessionData('login')['emailid'];
            }

            
            // $userAddress= $this->AddressModel->checkUserAddress($mobile_number,$emailid );
            $db3 = \Config\Database::connect('e_services'); 
            $session = \Config\Services::session();
            
            $builder = $db3->table('user_address');
            $address = $builder->where('mobile', $applicantMobile)
            ->where('email', $applicantEmail)
            ->where('is_active', 'Y')
            ->get()
            ->getResultArray();



            if(count($address)==3)
            {
                $response = ['status' => 'Max 3 Addresses Already Added'];
            }
            else 
            {
                $validatedName = '';


                if (count($address) > 0) {
                    $rowCheck = $address[0];
                    if (strtoupper($rowCheck['first_name']) == strtoupper($request->getPost('first_name')) &&
                        strtoupper($rowCheck['second_name']) == strtoupper($request->getPost('second_name'))) {
                        $validatedName = 'YES'; //ok
                    } else {
                        $response = ['status' => 'First Name and Second Name can not be change'];
                    }
                }
                if ($validatedName == 'YES' || count($address) == 0) {

                    
                    $data = [
                        'mobile' => $applicantMobile,
                        'email' => $applicantEmail,
                        'first_name' => $request->getPost('first_name'),
                        'second_name' => $request->getPost('second_name'),
                        'address_type' => $request->getPost('address_type'),
                        'address' => $request->getPost('postal_add'),
                        'city' => $request->getPost('city'),
                        'district' => $request->getPost('district'),
                        'state' => $request->getPost('state'),
                        'pincode' => $request->getPost('pincode'),
                        'country' => $request->getPost('country'),
                        'entry_time_ip' => $clientIP,
                    ];

                    $builder = $db3->table('user_address');
                    $insertData= $builder->insert($data); 
                  

                    if ($insertData) {
                        $response = ['status' => 'success'];

                        $builder = $db3->table('user_address');
                        $builder->where('mobile', $applicantMobile);
                        $builder->where('email', $applicantEmail);
                        $builder->where('is_active', 'Y');
                        $address = $builder->get()->getResult();
                        if (count($address) > 0) {
                            $session->set('is_user_address_found', 'YES');
                            $session->set('user_address', $address);
                        } else {
                            $session->set('is_user_address_found', 'NO');
                        }
                    } else {
                        $response = ['status' => 'Error:Record Not Inserted'];
                    }
                }
            }        
        }
        else 
        {
            $response = ['status' => 'Session Expired'];
        }
        return $this->response->setJSON($response);

    }
    public function getPincodeDetails () 
    {
        $request = service('request');
        $pincode= $request->getPost('pincode');
        // pr($pincode);
        $pincodeDetails= $this->AddressModel->getPincode($pincode);
        // pr($pincodeDetails);
        if ($pincodeDetails) {
            return $this->response->setJSON([
                'status' => 'success',
                'taluk_name' => $pincodeDetails->taluk_name,
                'district_name' => $pincodeDetails->district_name,
                'state_name' => $pincodeDetails->state,
            ]);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }

    
}
