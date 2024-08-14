<?php

namespace App\Controllers\Caveat;
use App\Controllers\BaseController;
use App\Models\Common\CommonModel;
use App\Models\NewCase\DropdownListModel;
use App\Models\Caveat\SubordinateCourtModel;

class DefaultController extends BaseController
{

    protected $session;
    protected $db;
    protected $Common_model;
    protected $Dropdown_list_model;
    protected $Subordinate_court_model;
    public function __construct()
    {
        $this->session = \Config\Services::session();

        parent::__construct();
        if (empty($this->session->get('login'))) {
            return response()->redirect(base_url('/'));
            exit(0);
        } else {
            is_user_status();
        }

        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT, USER_ADMIN, USER_ADMIN_READ_ONLY, USER_EFILING_ADMIN, SR_ADVOCATE, ARGUING_COUNSEL);
        if (!in_array($this->session->get('login')['ref_m_usertype_id'], $allowed_users_array)) {
            return response()->redirect(base_url('/'));
         //   exit(0);
        }
        $this->Dropdown_list_model = new DropdownListModel();
        $this->Subordinate_court_model = new SubordinateCourtModel();
        $this->Common_model = new CommonModel();
    }
    
   

    public function index()
    {
        
        $allowedUsers = [USER_ADVOCATE, USER_IN_PERSON, USER_CLERK];
       // pr(getSessionData('efiling_details'));
        if (!in_array(getSessionData('login')['ref_m_usertype_id'], $allowedUsers)) {
            return response()->redirect(base_url('/'));

        }

     //  pr(getSessionData('efiling_details'));

        $allowed_stages = [Draft_Stage, Initial_Defected_Stage, E_REJECTED_STAGE];
        if (!empty(getSessionData('efiling_details')['stage_id']) && !in_array(getSessionData('efiling_details')['stage_id'], $allowed_stages)) {
//            redirect('caveat/view');
            return response()->redirect(base_url('caveat/view'));
//            exit(0);
        }
        $data = [];
  
        if (!empty(getSessionData('efiling_details')['registration_id'])) {
         
            $registration_id = (int)getSessionData('efiling_details')['registration_id'];
            if (in_array(getSessionData('efiling_details')['stage_id'], [Initial_Defected_Stage, I_B_Defected_Stage, Draft_Stage])) {
                $this->Subordinate_court_model->remove_breadcrumb($registration_id, CAVEAT_BREAD_VIEW);
            }

            $arr = ['registration_id' => $registration_id, 'step' => 1];
            $response = $this->Common_model->getCaveatDataByRegistrationId($arr);
           
            $state_id = isset($response[0]['state_id']) ? (int)$response[0]['state_id'] : null;
            $data['district_list'] = $this->Dropdown_list_model->get_districts_list($state_id);
            if (!empty($response)) {
                $data['caveator_details'] = $response;
            }
        }

        $data['state_list'] = $this->Dropdown_list_model->get_states_list();
        //print_r($data['state_list']);die();
        $data['sc_case_type'] = $this->Dropdown_list_model->getSciCaseTypeOrderById();
        // print_r($data['sc_case_type']);die();
        if (!empty($response[0]['orgid']) && $response[0]['orgid'] != 'I') {
            $party_is = trim($response[0]['orgid']);
            $data['dept_list'] = $this->Dropdown_list_model->get_departments_list($party_is);
            $data['post_list'] = $this->Dropdown_list_model->get_posts_list();
        }

        $data['case_type_pet_title'] = "Caveator";
        // print_r($data);
       //  $this->render('caveat.caveat_breadcrumb', compact('data'));
        //return $this->render('caveat.caveat_view', $data);
//        pr($data);
        $this->render('caveat.caveat_view', $data);
    }
    
    public function processing($id = NULL)
    {       
        if ($id !== NULL) {
            session()->remove('estab_details');
            $id = url_decryption($id);
            $InputArray = explode('#', $id);   //0=>registration_id,1=>type,2=>stage
            if (empty($InputArray[0]) && empty($InputArray[1]) && empty($InputArray[2])) {
                return redirect()->to('login');
            }
            $registration_id = $InputArray[0];
            $efiling_details = getSessionData('efiling_details') ?? [];
            $efiling_details['registration_id'] = $registration_id;
            $session = session();
            //$session ->set('efiling_details', $result);
            $session->set('efiling_details', $efiling_details);
          //  session()->set('efiling_details.registration_id', $registration_id = $InputArray[0]);
            $this->Common_model->get_efiling_num_basic_details(trim($InputArray[0]));
            $this->Common_model->get_establishment_details();
            $allowed_stages = [Draft_Stage, Initial_Defected_Stage, E_REJECTED_STAGE];
            if (isset(getSessionData('efiling_details')['stage_id']) && !empty(getSessionData('efiling_details')['stage_id']) && !in_array(getSessionData('efiling_details')['stage_id'], $allowed_stages)) {
               //pr('hiii');
                return redirect()->to('caveat/view');
            }
        } else {
           // pr(getSessionData('efiling_for_details'));
            if (!empty(getSessionData('efiling_for_details'))) {
                $this->Common_model->get_establishment_details(getSessionData('efiling_for_details')['efiling_for_type_id'], getSessionData('efiling_for_details')['efiling_for_id']);
                return redirect()->to('caveat/caveator');
            } else {
             //   return redirect()->to('whereToFile/caveat');
                return redirect()->to('caveat/caveat');
            }
        }
     
        $allowed_admin_users = [USER_ADMIN, USER_ACTION_ADMIN, USER_ADMIN_READ_ONLY, USER_EFILING_ADMIN];
        $allowed_users = [USER_ADVOCATE, USER_IN_PERSON, USER_CLERK];
        if ((in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_admin_users) || (!empty(getSessionData('efiling_details')['stage_id']))) && (!in_array(getSessionData('efiling_details')['stage_id'], $allowed_stages))) {
         
            return redirect()->to(base_url('caveat/view'));
        } elseif (in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users) || in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_admin_users)) {
            //pr(getSessionData('efiling_details'));
          //  pr('hii');
            switch (max(explode(',', getSessionData('efiling_details')['breadcrumb_status']))) {
                case CAVEAT_BREAD_CAVEATOR:
                    return redirect()->to(base_url('caveat'));
                case CAVEAT_BREAD_CAVEATEE:
                    return redirect()->to(base_url('caveat/caveatee'));
                case CAVEAT_BREAD_EXTRA_PARTY:
                    return redirect()->to(base_url('caveat/extra_party'));
                case CAVEAT_BREAD_SUBORDINATE_COURT:
                    return redirect()->to(base_url('caveat/subordinate_court'));
                case CAVEAT_UPLOAD_DOCUMENT:
                    return redirect()->to(base_url('uploadDocuments'));
                case CAVEAT_BREAD_DOC_INDEX:
                    return redirect()->to(base_url('documentIndex'));
                case CAVEAT_BREAD_COURT_FEE:
                    return redirect()->to(base_url('newcase/courtFee'));
                case CAVEAT_BREAD_VIEW:
                    return redirect()->to(base_url('caveat/view'));
                default:
                    return redirect()->to(base_url('caveat'));
            }
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }
}
