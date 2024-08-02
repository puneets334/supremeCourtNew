<?php
namespace App\Controllers;

class Extra_petitioner extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('common/Common_model');
        $this->load->model('common/Form_validation_model');
        $this->load->model('jailPetition/JailPetitionModel');
        $this->load->model('newcase/Dropdown_list_model');
        $this->load->model('newcase/Get_details_model');
    }

    public function _remap($param = NULL) {
        
        if($this->uri->total_segments()== 4){             
             $this->add_extra_party($this->uri->segment(4));
        }elseif ($param == 'index') {
            $this->index(NULL);
        } elseif ($param == 'add_extra_party') {
            $this->add_extra_party();
        } else {
            $this->index($param);
        }
    }

    public function index($party_id = NULL) {
        if (isset($party_id) && !empty($party_id)) {
            $party_id = url_decryption($party_id);
            if (!$party_id) {
                $_SESSION['MSG'] = message_show("fail", "Invalid ID.");
                redirect('jailPetition/Extra_petitioner');
                exit(0);
            }
        }

        $allowed_users_array = array(JAIL_SUPERINTENDENT);

        if (!in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('admindashboard');
            exit(0);
        }

        $stages_array = array('', Draft_Stage, Initial_Defected_Stage, I_B_Defected_Stage, E_REJECTED_STAGE);
        if (!in_array($_SESSION['efiling_details']['stage_id'], $stages_array)) {
            redirect('jailPetition/view');
            exit(0);
        }

        $data['state_list'] = $this->Dropdown_list_model->get_states_list();

        if (isset($_SESSION['efiling_details']['registration_id']) && !empty($_SESSION['efiling_details']['registration_id'])) {

            $registration_id = $_SESSION['efiling_details']['registration_id'];
            $data['extra_parties_list'] = $this->Get_details_model->get_case_parties_details($registration_id, array('p_r_type' => NULL, 'm_a_type' => 'A', 'party_id' => NULL, 'view_lr_list'=> FALSE));
           /* var_dump($data['extra_parties_list']);
            exit(0);*/
            if (isset($party_id) && !empty($party_id)) {
                
                $data['party_id'] = $party_id;

                $data['petitioner_details'] = $this->Get_details_model->get_case_parties_details($registration_id, array('p_r_type' => NULL, 'm_a_type' => NULL, 'party_id' => $party_id, 'view_lr_list'=> FALSE));

                $data['district_list'] = $this->Dropdown_list_model->get_districts_list($data['petitioner_details'][0]['state_id']);
            }
           // echo "<pre>"; print_r($data['petitioner_details']); die;
        }

        $this->load->view('templates/jail_header');
        $this->load->view('jailPetition/new_case_view', $data);
        $this->load->view('templates/footer');
    }

    public function add_extra_party($party_id = NULL) {
        
        if (isset($party_id) && !empty($party_id)) {
            $party_id = url_decryption($party_id);
            if (!$party_id) {
                $_SESSION['MSG'] = message_show("fail", "Invalid ID.");
                redirect('jailPetition/Extra_petitioner');
                exit(0);
            }
        }
        
        $stages_array = array('', Draft_Stage, Initial_Defected_Stage, I_B_Defected_Stage);

        if (!in_array($_SESSION['efiling_details']['stage_id'], $stages_array)) {
            echo '1@@@' . htmlentities("Update in Party details can be done only at 'Draft', 'For Compliance' stages' and 'Defective' stages.", ENT_QUOTES);
            exit(0);
        }
            $this->form_validation->set_rules('petitioner_name', 'Petitioner name', 'required|trim|min_length[3]|max_length[99]|validate_alpha_numeric_space_dot_hyphen_apostrophe_atrateof');
            $this->form_validation->set_rules('relation', 'Relation', 'required|in_list[S,D,W]');
            $this->form_validation->set_rules('relative_name', 'Father/Husband name', 'required|trim|min_length[3]|max_length[99]|validate_alpha_numeric_space_dot_hyphen_apostrophe_atrateof');
            $this->form_validation->set_rules('petitioner_dob', 'D.O.B.', 'trim|exact_length[10]|validate_date_dd_mm_yyyy');
            $this->form_validation->set_rules('petitioner_age', 'Age', 'trim|required|min_length[1]|max_length[2]|is_natural');
            $this->form_validation->set_rules('petitioner_gender', 'Gender', 'trim|required|in_list[M,F,O]');
            $this->form_validation->set_rules('petitioner_address', 'Address', 'required|trim|min_length[10]|max_length[250]|validate_alpha_numeric_space_dot_hyphen_comma_slash');
            $this->form_validation->set_rules('petitioner_state', 'State', 'required|trim|validate_encrypted_value');
            $this->form_validation->set_rules('petitioner_district', 'District', 'required|trim|validate_encrypted_value');
            $this->form_validation->set_rules('petitioner_pincode', 'Pincode', 'trim|exact_length[6]|is_natural');

        $this->form_validation->set_error_delimiters('<br/>', '');
        if (!$this->form_validation->run()) {
            echo '3@@@';
            echo  form_error('petitioner_name') . form_error('relation') . form_error('relative_name') . form_error('petitioner_dob') .
                  form_error('petitioner_age') .  form_error('petitioner_gender') . form_error('petitioner_address') .
                  form_error('petitioner_state') . form_error('petitioner_district') . form_error('petitioner_pincode');
            exit(0);
        }

        $registration_id = $_SESSION['efiling_details']['registration_id'];
        
        $party_max = $this->Get_details_model->get_max_party_num_n_id($registration_id, 'P');
        $party_name = strtoupper(escape_data($this->input->post("petitioner_name")));
        $party_relation = escape_data($this->input->post("relation"));
        $relative_name = strtoupper(escape_data($this->input->post("relative_name")));
        $party_dob = escape_data($this->input->post("petitioner_dob"));
        $party_dob_array = explode('/', $party_dob);
        $party_dob = $party_dob_array[2] . '-' . $party_dob_array[1] . '-' . $party_dob_array[0];
        $party_age = escape_data($this->input->post("petitioner_age"));
        $party_gender = escape_data($this->input->post("petitioner_gender"));
        $party_email = strtoupper(escape_data($this->input->post("petitioner_email")));
        $party_mobile = escape_data($this->input->post("petitioner_mobile"));
        $party_address = strtoupper(escape_data($this->input->post("petitioner_address")));
        $party_city = strtoupper(escape_data($this->input->post("petitioner_city")));
        $party_state_id = escape_data(url_decryption($this->input->post("petitioner_state")));
        $party_district_id = escape_data(url_decryption($this->input->post("petitioner_district")));
        $party_pincode = escape_data($this->input->post("petitioner_pincode"));

        $curr_dt_time = date('Y-m-d H:i:s');

        $party_individual = array(
            'party_name' => $party_name,
            'relation' => $party_relation,
            'relative_name' => $relative_name,
            'party_age' => $party_age,
            'party_dob' => $party_dob,
            'gender' => $party_gender,
            'email_id' => $party_email,
            'mobile_num' => $party_mobile,
            'address' => $party_address,
            'city' => $party_city,
            'state_id' => $party_state_id,
            'district_id' => $party_district_id,
            'pincode' => $party_pincode
        );

        
        
        $party_type = array(
            'is_org' => false,
            'party_type' => 'I',
            'p_r_type' => 'P',
            'm_a_type' => 'A',
            'party_no' => $party_max[0]['max_party_no']+1,            
            'party_id' => $party_max[0]['max_party_id']+1
        );

        //echo '<pre>';print_r($_SESSION['efiling_details']);die;
        $party_details = array_merge($party_type, $party_individual);

        

        if (isset($registration_id) && !empty($registration_id) && isset($party_id) && !empty($party_id)) {

            $party_update_data = array(
                'updated_on' => $curr_dt_time,
                'updated_by' => $this->session->userdata['login']['id'],
                'updated_by_ip' => getClientIP()
            );

            $party_details = array_merge($party_details, $party_update_data);

            //UPDATE EXTRA PARTY DETAILS            

            $status = $this->JailPetitionModel->add_update_case_parties($registration_id, $party_details, JAIL_PETITION_EXTRA_PETITIONER, $party_id);

            if ($status) {
                echo '2@@@' . htmlentities('Party details updated successfully !', ENT_QUOTES) . '@@@' . base_url('jailPetition/defaultController/' . url_encryption(trim($registration_id . '#' . E_FILING_TYPE_JAIL_PETITION . '#' . $_SESSION['efiling_details']['stage_id'])));
            } else {
                echo '1@@@' . htmlentities('Some error occurred ! Please Try again.', ENT_QUOTES);
            }
        } else {

            $party_create_data = array(
                'registration_id' => $registration_id,
                'created_on' => $curr_dt_time,
                'created_by' => $this->session->userdata['login']['id'],
                'created_by_ip' => getClientIP()
            );
            $party_details = array_merge($party_details, $party_create_data);
            $inserted_party_id = $this->JailPetitionModel->add_update_case_parties($registration_id, $party_details, JAIL_PETITION_EXTRA_PETITIONER);

            if ($inserted_party_id) {
                echo '2@@@' . htmlentities('Party details added successfully !', ENT_QUOTES) . '@@@' . base_url('jailPetition/defaultController/' . url_encryption(trim($registration_id . '#' . E_FILING_TYPE_JAIL_PETITION . '#' . Draft_Stage)));
            } else {
                echo '1@@@' . htmlentities('Some error occurred ! Please Try again.', ENT_QUOTES);
            }
        }
    }

}
