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

    public function user_address_save() 
    {
        pr("Welcome");

    }



    
}
