<?php
//namespace App\Controllers;
namespace App\Controllers\Caveat;

use App\Controllers\BaseController;
use App\Libraries\webservices\Efiling_webservices;
use App\Models\Common\CommonModel;
use App\Models\Caveat\CaveatCommonModel;
use App\Models\Caveat\CaveatorModel;
class Caveator extends BaseController {

    protected $Common_model;
    protected $caveat_common_model;
    protected $Caveator_model;
    
    protected $request;
    protected $validation;
    protected $session;
    protected $efiling_webservices;

 public function __construct()
    {
       
        parent::__construct();

        $this->session = \Config\Services::session();
        if (empty(getSessionData('login'))) {
            return response()->redirect(base_url('/'));
        } else {
            is_user_status();
        }

        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT, USER_ADMIN, USER_ADMIN_READ_ONLY, USER_EFILING_ADMIN, SR_ADVOCATE, ARGUING_COUNSEL);
        if (getSessionData('login') != '' && !in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users_array)) {
            return response()->redirect(base_url('/'));
           
        }
        $this->caveat_common_model = new CaveatCommonModel();
        $this->Caveator_model = new CaveatorModel();
        $this->Common_model = new CommonModel();
        $this->efiling_webservices = new Efiling_webservices();
        $this->validation = \Config\Services::validation();
        $this->request = \Config\Services::request();
    }

    public function index() {

        $allowedUsers = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK);
        if (!in_array(getSessionData('login')['ref_m_usertype_id'], $allowedUsers)) {
            redirect('login');
            exit(0);
        }
        
        if (!empty(getSessionData('estab_details'))) {
                 // if (isset(getSessionData('efiling_details')) && !empty(getSessionData('efiling_details'))) {

            $estab_code = (getSessionData('estab_details')['est_code']);
            $efiling_for_type_id = getSessionData('estab_details')['efiling_for_type_id'];
            $state_code = getSessionData('estab_details')['state_code'];
        } else {
            $msg = getSessionData('MSG');
            $msg = message_show("fail", 'Invalid request !');
            redirect('whereToFile/caveat');
            exit(0);
        }

        $allowed_stages = array('', Draft_Stage, Initial_Defected_Stage, E_REJECTED_STAGE);
        if (!in_array(getSessionData('efiling_details')['stage_id'], $allowed_stages)) { echo 1; exit;
            redirect('caveat/view');
            exit(0);
        }

        if (isset(getSessionData('efiling_details')['registration_id']) && !empty(getSessionData('efiling_details')['registration_id'])) 
        {
            $registration_id = getSessionData('efiling_details')['registration_id'];
            $data['efiling_civil_data'] = $this->caveat_common_model->get_efiling_civil_details($registration_id);
            $data['efiling_civil_master_data'] = $this->caveat_common_model->get_efiling_civil_master_value($registration_id);
            $saved_state_id = $data['efiling_civil_data'][0]['state_id'];
            $saved_district_code = $data['efiling_civil_data'][0]['dist_code'];
            $saved_taluka_code = $data['efiling_civil_data'][0]['taluka_code'];
            $saved_town_code = $data['efiling_civil_data'][0]['town_code'];
            $data['org_list'] = $this->efiling_webservices->getOrgname($estab_code, $efiling_for_type_id, $state_code, $state_code);
            $data['relation_list'] = $this->efiling_webservices->getRelation($estab_code, $efiling_for_type_id, $state_code);
            $data['state_list'] = $this->efiling_webservices->getState($estab_code, $efiling_for_type_id, $state_code);
            if (isset($saved_state_id) && !empty($saved_state_id) && $saved_state_id != 0) {
                $data['distt_list'] = $this->efiling_webservices->getDistrict($estab_code, $efiling_for_type_id, $saved_state_id, $state_code);
                if (isset($saved_district_code) && !empty($saved_district_code) && $saved_district_code != 0) {
                    $data['pet_taluka_list'] = $this->efiling_webservices->getTaluka($estab_code, $saved_district_code, $efiling_for_type_id, $saved_state_id, $state_code);
                    if (isset($saved_taluka_code) && !empty($saved_taluka_code) && $saved_taluka_code != 0) {
                        $data['pet_vill_list'] = $this->efiling_webservices->getVillage($estab_code, $saved_district_code, $saved_taluka_code, $efiling_for_type_id, $saved_state_id, $state_code);
                    }
                    $data['pet_town_list'] = $this->efiling_webservices->getTown($estab_code, $saved_district_code, $efiling_for_type_id, $saved_state_id, $state_code);
                    if (isset($saved_town_code) && !empty($saved_town_code) && $saved_town_code != 0) {

                        $data['pet_ward_list'] = $this->efiling_webservices->getWard($estab_code, $saved_district_code, $saved_town_code, $efiling_for_type_id, $saved_state_id, $state_code);
                    }
                    $data['police_st_code'] = $this->efiling_webservices->get_police_st_by_district($estab_code, $efiling_for_type_id, $saved_district_code, $state_code);
                }
            }
        } 
        elseif (!empty(getSessionData('efiling_for_details'))) {
            // /isset(getSessionData('efiling_for_details')) &&
            $data['relation_list'] = $this->efiling_webservices->getRelation($estab_code, $efiling_for_type_id, $state_code);
            $data['org_list'] = $this->efiling_webservices->getOrgname($estab_code, $efiling_for_type_id, $state_code, $state_code);
            $data['state_list'] = $this->efiling_webservices->getState($estab_code, $efiling_for_type_id, $state_code);
        } else {
            redirect('dashboard');
            exit(0);
        }

       // $this->load->view('templates/header');
       $this->render('caveat.caveat_view', $data, TRUE);
        //$this->load->view('templates/footer');
    }


public function add_caveators() {
    //pr(getSessionData('efiling_details'));
    $this->Common_model->get_establishment_details(); // add establishment in session
    //print_r($this->request);die();
    $allowedUsers = [USER_ADVOCATE, USER_IN_PERSON, USER_CLERK];
    if (!empty(getSessionData('login')['ref_m_usertype_id']) && !in_array(getSessionData('login')['ref_m_usertype_id'], $allowedUsers)) {
        return redirect()->to('login');
    }
    $allowed_stages = ['', Draft_Stage, Initial_Defected_Stage, E_REJECTED_STAGE];

    if (!in_array(isset(getSessionData('efiling_details')['stage_id'])?getSessionData('efiling_details')['stage_id']:'', $allowed_stages)) {
        echo '1@@@' . htmlentities("Update in Caveator details can be done only at 'Draft' and 'For Compliance' stages.", ENT_QUOTES);
        log_message('CUSTOM', "Update in Caveator details can be done only at 'Draft' and 'For Compliance' stages.");
        return redirect()->to('caveat/view');
    }

    $draft_data = $this->caveat_common_model->count_efilied_nums_on_draft();
    $userTypeId = getSessionData('login')['ref_m_usertype_id'];
   // pr($userTypeId);die();
    if ($userTypeId == USER_ADVOCATE && $draft_data[0]->total_drafts > ADVOCATE_DRAFT_NO) {
        session()->setFlashdata('msg', '<div class="alert alert-danger text-center">Only ' . ADVOCATE_DRAFT_NO . ' cases are maintained in Draft Stage. For filing this case, please proceed with available case in draft, then file the case.</div>');
        log_message('CUSTOM', "Only " . ADVOCATE_DRAFT_NO . " cases are maintained in Draft Stage. For filing this case, please proceed with available case in draft, then file the case.");
        return redirect()->to('dashboard');
    } elseif ($userTypeId == USER_IN_PERSON && $draft_data[0]->total_drafts > PARTY_IN_PERSON_DRAFT_SIZE) {
        session()->setFlashdata('msg', '<div class="alert alert-danger text-center">Only ' . PARTY_IN_PERSON_DRAFT_SIZE . ' cases are maintained in Draft Stage. For filing this case, please proceed with available case in draft, then file the case.</div>');
        log_message('CUSTOM', "Only " . PARTY_IN_PERSON_DRAFT_SIZE . " cases are maintained in Draft Stage. For filing this case, please proceed with available case in draft, then file the case.");
        return redirect()->to('dashboard');
    }

   // $validation = \Config\Services::validation();
   // pr($validation);die();
    $this->validation->setRules([
        'case_type' => 'required|trim',
        'party_is' => 'required|trim',
        'pet_email' => 'required|trim|min_length[6]|max_length[49]|valid_email',
        'pet_mobile' => 'required|trim|exact_length[10]|is_natural',
        'pet_address' => 'required|trim|min_length[3]|max_length[250]',
        'party_city' => 'required|trim|min_length[3]|max_length[49]',
        //'party_state' => 'required|trim',
      //  'party_pincode' => 'required|trim|exact_length[6]|is_natural',
    ]);


    if (!$this->validation->withRequest($this->request)->run()) {
        echo '1@@@' . implode('<br>', $this->validation->getErrors());
        return;
    }
    $pet_gender =$pet_age= NULL;
    //pr($this->request);die();
    $pet_complainant = ((string) ($this->request->getPost("pet_complainant"))) ?? NULL;
    if (empty($pet_complainant)) {
        $pet_complainant = NULL;
    }
    $pet_relation = ((string) ($this->request->getPost('pet_rel_flag'))) ?? NULL;
    if (empty($pet_relation)) {
        $pet_relation = NULL;
    }
    $relative_name = ((string) ($this->request->getPost("relative_name"))) ?? NULL;
    if (empty($relative_name)) {
        $relative_name = NULL;
    }
   
   
    $pet_gender = ((string) ($this->request->getPost("pet_gender"))) ?? NULL;
    if (empty($pet_gender)) {
        $pet_gender = NULL;
    }
    $pet_age = ($this->request->getPost("pet_age")) ?? NULL;
    if (empty($pet_age)) {
        $pet_age = NULL;
    }
    $pet_dob = $this->request->getPost("pet_dob");
    if (!empty($pet_dob)) {
        $date = explode('/', $pet_dob);
        $pet_dob = $date[2] . '-' . $date[1] . '-' . $date[0];
    } else {
        $pet_dob = NULL;
    }

    $organisation_id = !empty((string) ($this->request->getPost('party_is')))?$this->request->getPost('party_is'): NULL;
    if (empty($organisation_id)) {
        $organisation_id = NULL;
    }
    if(($this->request->getPost("pet_gender"))=='undefined')
    {
        $pet_gender = NULL;
    }
    $org_state = !empty($this->request->getPost('org_state')) ? url_decryption($this->request->getPost('org_state')) : NULL;
    $org_state_name = !empty(($this->request->getPost('org_state_name')))?$this->request->getPost('org_state_name'): NULL;
    $org_dept = !empty($this->request->getPost('org_dept')) ? url_decryption($this->request->getPost('org_dept')) : NULL;
    $org_dept_name = !empty((string) ($this->request->getPost('org_dept_name')))?$this->request->getPost('org_dept_name'):NULL;
    $org_post = !empty((string) $this->request->getPost('org_post')) ? url_decryption(escape_data($this->request->getPost('org_post'))) : NULL;
    $org_post_name = !empty((string) ($this->request->getPost('org_post_name')))? $this->request->getPost('org_post_name'): NULL;
    $pet_email = !empty((string) ($this->request->getPost("pet_email"))) ? $this->request->getPost("pet_email"): NULL;
    $pet_mobile = !empty($this->request->getPost("pet_mobile"))? $this->request->getPost("pet_mobile"): NULL;
    $pet_address = !empty($this->request->getPost("pet_address"))? $this->request->getPost("pet_address"): NULL;
    $state_id = !empty($this->request->getPost('party_state')) ? url_decryption(escape_data($this->request->getPost('party_state'))) : NULL;
    $district_id = !empty($this->request->getPost('party_district')) ? url_decryption($this->request->getPost('party_district')) : NULL;
    $pet_pincode =  !empty($this->request->getPost('party_pincode')) ? $this->request->getPost('party_pincode'): NULL;
    $pet_city = !empty((string) ($this->request->getPost('party_city')))? $this->request->getPost('party_city'): NULL;
    if(empty($org_state)){$org_state=NULL;}
    if(empty($org_post_name)){$org_post_name=NULL;}
    if(empty($org_dept_name)){$org_dept_name=NULL;}
    if(empty($org_post)){$org_post=NULL;}
    if(empty($org_dept)){$org_dept=NULL;}
    if(empty($state_id)){$state_id=NULL;}
    if(empty($pet_email)){$pet_email=NULL;}
    if(empty($pet_pincode)){$pet_pincode=NULL;}
   // $id = isset(getSessionData('login')['id'])?? NULL;
   $id = getSessionData('login')['id'];
    //pr($id);
    $case_type = !empty($this->request->getPost('case_type')) ? url_decryption($this->request->getPost('case_type')) : NULL;
    $pet_extracount = (string) ($this->request->getPost('pet_extracount') ?? 1);

    $is_govt_filing =!empty($this->request->getPost("is_govt_filing"))? trim($this->request->getPost("is_govt_filing")):'';
    $is_govt_filing = !empty($is_govt_filing) ? 1 : 0;

    $data = [
        'pet_name' => isset($pet_complainant) ? strtoupper($pet_complainant) : NULL,
        'orgid' => $organisation_id,
        'pet_sex' => $pet_gender,
        'pet_gender' => $pet_gender,
        'pet_father_flag' => $pet_relation,
        'pet_father_name' => isset($relative_name) ? strtoupper($relative_name) : NULL,
        'pet_age' => $pet_age,
        'pet_dob' => $pet_dob,
        'pet_email' => isset($pet_email) ? strtoupper($pet_email) : NULL,
        'pet_mobile' => $pet_mobile,
        'petadd' => isset($pet_address) ? strtoupper($pet_address) : NULL,
        'pet_pincode' => $pet_pincode,
        'state_id' => $state_id,
        'dist_code' => $district_id,
        'org_state' => $org_state,
        'org_state_name' => $org_state_name,
        'org_dept' => $org_dept,
        'org_dept_name' => $org_dept_name,
        'org_post' => $org_post,
        'org_post_name' => $org_post_name,
        'pet_city' => $pet_city,
        'createdby' => $id,
        'case_type_id' => $case_type,
        'is_govt_filing' => $is_govt_filing,
    ];
   // pr($data);
    $cis_masters_values = [];
    // pr(getSessionData('efiling_details'));
    $registration_id = isset(getSessionData('efiling_details')['registration_id'])?getSessionData('efiling_details')['registration_id']:'';
    if (!empty($registration_id)) {
        $this->Caveator_model->update_caveators($registration_id, $data, $cis_masters_values);
        echo '2@@@' . htmlentities('Caveator updated successfully!', ENT_QUOTES) . '@@@' . base_url('caveat/defaultController/processing/' . url_encryption(trim($registration_id . '#' . E_FILING_TYPE_CAVEAT . '#' . Draft_Stage)));
    } else {
        $result = $this->Caveator_model->add_caveator($data, $pet_mobile, $pet_email, $cis_masters_values);
        if ($result) {
            echo '2@@@' . htmlentities('Caveator added successfully', ENT_QUOTES) . '@@@' . base_url('caveat/defaultController/processing/' . url_encryption(trim($result['registration_id'] . '#' . E_FILING_TYPE_CAVEAT . '#' . Draft_Stage)));
        } else {
            echo '1@@@' . htmlentities('eFiling Failed. Please Try again', ENT_QUOTES);
        }
    }
}

}
