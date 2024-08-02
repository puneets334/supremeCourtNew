<?php
namespace App\Controllers;

class View extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('newcase/Get_details_model');
        $this->load->model('newcase/Act_sections_model');
        $this->load->model('newcase/Dropdown_list_model');
        $this->load->model('newcase/View_model');
        $this->load->model('affirmation/Affirmation_model');
    }

    function index() {
        
        $allowed_users_array = array(JAIL_SUPERINTENDENT, USER_ADMIN);

        if (!in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('login');
            exit(0);
        }
              
        $registration_id = $_SESSION['efiling_details']['registration_id'];

        $data['new_case_details'] = $this->Get_details_model->get_new_case_details($registration_id);
        $data['sc_case_type'] = $this->Dropdown_list_model->get_sci_case_type_name($data['new_case_details'][0]['sc_case_type_id']);
        //$data['main_subject_cat'] = $this->Dropdown_list_model->get_main_subject_category($data['new_case_details'][0]['subject_cat']);
        $data['petitioner_details'] = $this->Get_details_model->get_case_parties_details($registration_id, array('p_r_type' => 'P', 'm_a_type' => 'M', 'party_id' => NULL, 'view_lr_list' => FALSE));
        $data['respondent_details'] = $this->Get_details_model->get_case_parties_details($registration_id, array('p_r_type' => 'R', 'm_a_type' => 'M', 'party_id' => NULL, 'view_lr_list' => FALSE));
        $data['extra_parties_list'] = $this->Get_details_model->get_case_parties_details($registration_id, array('p_r_type' => NULL, 'm_a_type' => 'A', 'party_id' => NULL, 'view_lr_list' => FALSE));
        $data['party_details'] = $this->Get_details_model->get_case_parties_details($registration_id, array('p_r_type' => 'P', 'm_a_type' => 'M', 'party_id' => NULL, 'view_lr_list' => FALSE));
        $data['subordinate_court_details'] = $this->Get_details_model->get_subordinate_court_details($registration_id);

        $data['efiled_docs_list'] = $this->View_model->get_index_items_list($registration_id);
        $data['esigned_docs_details'] = $this->Affirmation_model->get_esign_doc_details($registration_id);

        $this->load->view('templates/jail_header');
        $this->load->view('jailPetition/efile_details_view', $data);
        $this->load->view('templates/footer');
    }

}
