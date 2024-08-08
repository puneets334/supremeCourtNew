<?php

namespace App\Controllers\AppearingFor;
use App\Controllers\BaseController;
use App\Models\AppearingFor\AppearingForModel;
use App\Models\MiscellaneousDocs\GetDetailsModel;

class DefaultController extends BaseController {
    protected $AppearingForModel;
    protected $GETDetailsModel;
    public function __construct() {
        parent::__construct();
        $this->AppearingForModel = new AppearingForModel();
        $this->GETDetailsModel= new GETDetailsModel();
    }

    public function index() 
    {
        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK);
        if (!in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('dashboard');
            exit(0);
        }
        $stages_array = array(Draft_Stage, Initial_Defected_Stage, I_B_Defected_Stage);
        if (!in_array(getSessionData('efiling_details')['stage_id'], $stages_array)) {
            if (getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_MISC_DOCS) {
                redirect('miscellaneous_docs/view');
                exit(0);
            } elseif (getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_IA) {
                redirect('IA/view');
                exit(0);
            }
        }

        if (isset(getSessionData('efiling_details')['registration_id']) && !empty(getSessionData('efiling_details')['registration_id'])) {

            $registration_id = getSessionData('efiling_details')['registration_id'];

            $data['parties_details'] = $this->AppearingForModel->get_case_parties_list($registration_id);
            $data['appearing_for_details'] = $this->AppearingForModel->get_appearing_for_details($registration_id, getSessionData('login')['id']);
           
            $this->render('appearing_for.appearing_for_view',compact('data'));
            
        } else {
            redirect('dashboard');
            exit(0);
        }
    }

}

?>
