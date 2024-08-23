<?php

namespace App\Controllers\PhysicalHearing;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PhysicalHearing\ConsentVC as ConsentVCModel;
// use App\Models\PutModel;

class ConsentVC extends BaseController
{
    public function __construct()
    {
        $this->session = Services::session();
         if (!$this->session->has('loginData') || empty($this->session->get('loginData'))) {
            return redirect()->to('/auth');
        } else { 
            is_user_status(); 
        }
        helper(['common', 'encryptdecrypt', 'myarray', 'curl', 'url', 'form']); 
        $this->consent_VC_model = new ConsentVCModel(); 
    }
    public function index($court=null)
    { 
            $next_misc_working_date=getNextMiscDayOfHearing(); 
            $listing_date=array("'$next_misc_working_date'");
            $isEntryAllowed=checkEntryWithinAllowDateAndTime($next_misc_working_date); 
          if(!isset($this->session->loginData)){
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Session Expired. Please login again.</div>');
            unset($this->session->loginData);
            redirect('auth');
        }


        $data['page_title']='Choose mode of Hearing';

        $unfreezed_court = $this->consent_VC_model->available_court_list($listing_date);
        $freezed_court = $this->consent_VC_model->freezed_court_list($listing_date);



        $list = array();
        foreach ($unfreezed_court as $key => $value) {
            $list[] = $value['court_no'];
        }

        $list1 = array();
        foreach ($freezed_court as $key => $value) {
            $list1[] = $value['court_no'];
        }
        $unfreezed_court_list=array_diff($list,$list1);

        $data['display_message'] = 'List awaiting for Court Numbers : '.implode(', ',$unfreezed_court_list);
        $data['display_message1'] = 'List available for Court Numbers : '.implode(', ',$list1);
        $data['freezed_court']=isset($freezed_court)?$freezed_court:null;
        $data['listing_date']=$listing_date;

        //$data['weekly_list'] = $this->hearing_model->weekly_list_number();
        $data['advocate_cases_summary'] = $this->consent_VC_model->getListedAdvocateMatters($this->session->loginData['bar_id'],$listing_date);

        //$is_valid_consent_date_and_time=$this->checkEntryWithinAllowDateAndTime($listing_date,$nextMonday);
        //if(!empty($court) && !empty($is_valid_consent_date_and_time))

        if(!empty($court)) {
            $data['cases'] = $this->consent_VC_model->getFutureListedMatters($this->session->loginData['bar_id'], $listing_date, $court);
                 }
        else
            $data['cases']=null;

        $this->load->view('physical_hearing/menu');
        $this->load->view('physical_hearing/v3/consent_VC', $data);
    }
}
