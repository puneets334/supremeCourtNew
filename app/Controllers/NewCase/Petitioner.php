<?php
namespace App\Controllers\Newcase;

use App\Controllers\BaseController;
use App\Models\Common\CommonModel;
use App\Models\NewCase\DropdownListModel;
use App\Models\NewCase\GetDetailsModel;
use App\Models\NewCase\NewCaseModel;

class Petitioner extends BaseController {

    protected $session;
    protected $Common_model;
    protected $New_case_model;
    protected $Dropdown_list_model;
    protected $Get_details_model;
    protected $request;
    protected $validation;

    public function __construct() {
        parent::__construct();
        $this->session = \Config\Services::session();
        if (empty($this->session->get('login'))) {
            return response()->redirect(base_url('/'));
        } else {
            is_user_status();
        }

        $this->Common_model = new CommonModel();
        $this->New_case_model = new NewCaseModel();
        $this->Dropdown_list_model = new DropdownListModel();
        $this->Get_details_model = new GetDetailsModel();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
    }

    public function index() {
        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT);

        if (getSessionData('login') != '' && !in_array($this->session->get('login')['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('admindashboard');
            exit(0);
        }
        $stages_array = array('', Draft_Stage, Initial_Defected_Stage,  E_REJECTED_STAGE);
        if (!empty(getSessionData('efiling_details')['stage_id']) && !in_array(getSessionData('efiling_details')['stage_id'], $stages_array)) {
            return response()->redirect(base_url('newcase/view'));
            exit(0);
        }
        $data['state_list'] = $this->Dropdown_list_model->get_address_state_list();
        $countryList = $this->Dropdown_list_model->getCountryList();
        $data['countryList'] = !empty($countryList) ? $countryList : NULL;
        if (isset(getSessionData('efiling_details')['registration_id']) && !empty(getSessionData('efiling_details')['registration_id'])) {
            $registration_id = getSessionData('efiling_details')['registration_id'];
            $data['party_details'] = $this->Get_details_model->get_case_parties_details($registration_id, array('p_r_type' => 'P', 'm_a_type' => 'M', 'party_id' => NULL, 'view_lr_list' => FALSE));
            if(!empty($data['party_details'])){
                $data['district_list'] = $this->Dropdown_list_model->get_districts_list($data['party_details'][0]['state_id']);
            }else{
                $data['district_list'] = [];
            }
            $this->Get_details_model->get_case_table_ids($registration_id);
        }
        if(!empty(getSessionData('efiling_details')['breadcrumb_status'])){
            $breadCrumArr = explode(',',getSessionData('efiling_details')['breadcrumb_status']);
            if(in_array(NEW_CASE_LRS,$breadCrumArr)){
                $data['is_dead_data'] = true;
            }
            else{
                $data['is_dead_data'] = false;
            }
        }
        /*start code here json api IITM*/
        if ((isset($data['party_details']) && empty($data['party_details'])) && (isset($_SESSION['casewithAI'][0]) && !empty($_SESSION['casewithAI'][0]))) {
            $gender=isset($_SESSION['casewithAI'][0]['main_petitioner']['party_age']) && $_SESSION['casewithAI'][0]['main_petitioner']['gender']!='NA' ? $_SESSION['casewithAI'][0]['main_petitioner']['gender']:null;
            if (!empty($gender) && (strtolower($gender)=='male' || strtolower($gender)=='m')) {
                $gender='M';
            } elseif (!empty($gender) && (strtolower($gender)=='female' || strtolower($gender)=='f')) {
                $gender='F';
            }
            $party_dob=isset($_SESSION['casewithAI'][0]['main_petitioner']['party_dob']) && $_SESSION['casewithAI'][0]['main_petitioner']['party_dob']!='NA' ? $_SESSION['casewithAI'][0]['main_petitioner']['party_dob']:null;
            if (!empty($party_dob)){ $party_dob=date('Y-m-d',strtotime($party_dob)); }
            $country_id=isset($_SESSION['casewithAI'][0]['main_petitioner']['country_id']) && $_SESSION['casewithAI'][0]['main_petitioner']['country_id']!='NA' ? $_SESSION['casewithAI'][0]['main_petitioner']['country_id']:null;
            $pincode=isset($_SESSION['casewithAI'][0]['main_petitioner']['pincode']) && $_SESSION['casewithAI'][0]['main_petitioner']['pincode']!='NA' ? $_SESSION['casewithAI'][0]['main_petitioner']['pincode']:null;
            if (!empty($country_id) && strtolower($country_id)=='india'){ $country_id=96;}
            $mobile_num=isset($_SESSION['casewithAI'][0]['main_petitioner']['mobile_num']) && $_SESSION['casewithAI'][0]['main_petitioner']['mobile_num']!='NA' ? $_SESSION['casewithAI'][0]['main_petitioner']['mobile_num']:null;
            $email_id=isset($_SESSION['casewithAI'][0]['main_petitioner']['email_id']) && $_SESSION['casewithAI'][0]['main_petitioner']['email_id']!='NA' ? $_SESSION['casewithAI'][0]['main_petitioner']['email_id']:null;
            if (is_array($_SESSION['casewithAI'][0]['main_petitioner']['party_name'])) {
                $party_name=$_SESSION['casewithAI'][0]['main_petitioner']['party_name'][0];
            } else{
                $party_name=isset($_SESSION['casewithAI'][0]['main_petitioner']['party_name']) ? $_SESSION['casewithAI'][0]['main_petitioner']['party_name']:null;
            }
            $relation=isset($_SESSION['casewithAI'][0]['main_petitioner']['relation']) && $_SESSION['casewithAI'][0]['main_petitioner']['relation']!='NA' ? $_SESSION['casewithAI'][0]['main_petitioner']['relation']:'N';
            if (!empty($relation)) {
                $relation=strtolower($relation);
                if ($relation=='father' || $relation=='s' || $relation=='son of') {
                    $relation='S';
                } elseif ($relation=='daughter' || $relation=='d' || $relation=='daughter of') {
                    $relation = 'D';
                } elseif ($relation=='spouse' || $relation=='wife' || $relation=='spouse of') {
                    $relation = 'W';
                }
            }
            $data['party_details'][] =[
                'p_r_type' => 'P',
                'm_a_type' => 'M',
                'party_no' => 1,
                'party_name' => !empty($party_name) ? $party_name:null,
                'relation' => $relation,
                'relative_name' => isset($_SESSION['casewithAI'][0]['main_petitioner']['relative_name']) ? $_SESSION['casewithAI'][0]['main_petitioner']['relative_name']:null,
                'party_age' => isset($_SESSION['casewithAI'][0]['main_petitioner']['party_age']) && $_SESSION['casewithAI'][0]['main_petitioner']['party_age']=!'NA' ? $_SESSION['casewithAI'][0]['main_petitioner']['party_age']:null,
                'gender' => $gender,
                'party_dob' => $party_dob,
                'address' => isset($_SESSION['casewithAI'][0]['main_petitioner']['address']) ? $_SESSION['casewithAI'][0]['main_petitioner']['address']:null,
                'city' => isset($_SESSION['casewithAI'][0]['main_petitioner']['city']) ? $_SESSION['casewithAI'][0]['main_petitioner']['city']:null,
                'pincode' => $pincode,
                'country_id' => $country_id,
                'mobile_num' => $mobile_num,
                'email_id' => $email_id,
                'id' => 0,
                'registration_id' => 0,
                'org_state_id' => NULL,
                'org_dept_id' => NULL,
                'org_dept_name' => NULL,
                'org_post_id' => NULL,
                'org_post_name' => NULL,
            ];
        }
        /*end code here json api IITM*/
        return $this->render('newcase.new_case_view', $data);
    }

    public function add_petitioner() {
        $stages_array = array('', Draft_Stage, Initial_Defected_Stage, I_B_Defected_Stage);
        if (!empty(getSessionData('efiling_details')['stage_id']) && !in_array(getSessionData('efiling_details')['stage_id'], $stages_array)) {
            echo '1@@@' . htmlentities("Update in Petitioner details can be done only at 'Draft', 'For Compliance' stages' and 'Defective' stages.", ENT_QUOTES);
            exit(0);
        }
        $validations = [];
        $country_id = !empty($_POST['country_id']) ? url_decryption($_POST['country_id']) : NULL;
        $validations = [
            "party_as" => [
                "label" => "Party As",
                "rules" => "required|in_list[I,D1,D2,D3]"
            ],
        ];
        if($_POST['is_dead_minor'] == '0'){
            $is_dead_minor = false;
            $is_dead_file_status = false;
        }
        if ($_POST['party_as'] == 'I') {
            $validations += [
                "party_name" => [
                    "label" => "Petitioner name",
                    "rules" => "required|trim|min_length[3]|max_length[99]|validateAlphaNumericSingleDoubleQuotesBracketWithSpecialCharacters"
                ],
                "relation" => [
                    "label" => "Relation",
                    "rules" => "required|in_list[S,D,W,N]"
                ],
            ];
            $rel = escape_data($_POST["relation"]);
            if($rel=='N'){
                $validations += [
                    "relative_name" => [
                        "label" => "Father/Husband name",
                        "rules" => "trim|min_length[3]|max_length[99]|validateAlphaNumericSingleDoubleQuotesBracketWithSpecialCharacters"
                    ],
                ];
            }else{
                $validations += [
                    "relative_name" => [
                        "label" => "Father/Husband name",
                        "rules" => "required|trim|min_length[3]|max_length[99]|validateAlphaNumericSingleDoubleQuotesBracketWithSpecialCharacters"
                    ],
                ];
            }
            if($_POST['is_dead_minor'] == '0'){
                $is_dead_minor = false;
                $is_dead_file_status = false;
                $validations += [
                    "party_age" => [
                        "label" => "Age",
                        "rules" => "trim|required|min_length[1]|max_length[2]|is_natural"
                    ],
                    "party_address" => [
                        "label" => "Address",
                        "rules" => "required|trim|min_length[3]|max_length[250]|validateAlphaNumericSingleDoubleQuotesBracketWithSpecialCharacters"
                    ],
                ];
                if(isset($country_id) && !empty($country_id) && $country_id == 96){
                    $validations += [
                        "party_city" => [
                            "label" => "City",
                            "rules" => "required|trim|min_length[3]|max_length[49]|validateAlphaNumericSingleDoubleQuotesBracketWithSpecialCharacters"
                        ],
                        "party_state" => [
                            "label" => "State",
                            "rules" => "required|trim|validate_encrypted_value"
                        ],
                        "party_district" => [
                            "label" => "District",
                            "rules" => "required|trim|validate_encrypted_value"
                        ],
                    ];
                }
                else  if(isset($country_id) && !empty($country_id) && $country_id != 96 && $this->request->getPost('is_dead_minor') == '1'){
                    $validations += [
                        "party_city" => [
                            "label" => "City",
                            "rules" => "trim|min_length[3]|max_length[49]|validateAlphaNumericSingleDoubleQuotesBracketWithSpecialCharacters"
                        ],
                        "party_state" => [
                            "label" => "State",
                            "rules" => "trim|validate_encrypted_value"
                        ],
                        "party_district" => [
                            "label" => "District",
                            "rules" => "trim|validate_encrypted_value"
                        ],
                    ];
                }
            }
            else{
                $is_dead_minor = true;
                $is_dead_file_status = false;
            }
            /*END OF CHANGES ON on 03/09/20.*/
            $validations += [
                "party_dob" => [
                    "label" => "D.O.B.",
                    "rules" => "trim"
                ],
                "party_gender" => [
                    "label" => "Gender",
                    "rules" => "trim|required|in_list[M,F,O]"
                ],
            ];
        } else {
            if ($_POST['party_as'] != 'D3') {
                $validations += [
                    "org_state" => [
                        "label" => "Organisation State Name",
                        "rules" => "required|trim|validate_encrypted_value"
                    ],
                ];
                if (isset($_POST['org_state']) && url_decryption($_POST['org_state']) == 0) {
                    $validations += [
                        "org_state_name" => [
                            "label" => "Organisation Other State Name",
                            "rules" => "required|trim|min_length[5]|max_length[200]|validate_alpha_numeric_space_dot_hyphen"
                        ],
                    ];
                }
            }
            $validations += [
                "org_dept" => [
                    "label" => "Organisation Department name",
                    "rules" => "required|trim|validate_encrypted_value"
                ],
            ];
            if (isset($_POST['org_dept']) && url_decryption($_POST['org_dept']) == 0) {
                $validations += [
                    "org_dept_name" => [
                        "label" => "Other Department name",
                        "rules" => "required|trim|min_length[5]|max_length[200]|validate_alpha_numeric_space_dot_hyphen"
                    ],
                ];
            }

            $validations += [
                "org_post" => [
                    "label" => "Post",
                    "rules" => "required|trim|validate_encrypted_value"
                ],
            ];
            if (isset($_POST['org_post']) && url_decryption($_POST['org_post']) == 0) {
                $validations += [
                    "org_post_name" => [
                        "label" => "Other Post",
                        "rules" => "required|trim|min_length[5]|max_length[200]|validate_alpha_numeric_space_dot_hyphen"
                    ],
                ];
            }
        }
        $validations += [
            "party_email" => [
                "label" => "Email",
                "rules" => "required|trim|min_length[6]|max_length[49]|valid_email"
            ],
            "party_mobile" => [
                "label" => "Mobile number",
                "rules" => "required|trim|exact_length[10]|is_natural"
            ],
            "party_pincode" => [
                "label" => "Pincode",
                "rules" => "required|trim|exact_length[6]|is_natural"
            ],
        ];
        // pr($validations);
        $this->validation->setRules($validations);
        // $this->form_validation->set_error_delimiters('<br/>', '');
        if ($this->validation->withRequest($this->request)->run() === FALSE) {
            echo '3@@@';
            // echo $this->validation->getError('party_as') . $this->validation->getError('party_name') . $this->validation->getError('relation') . $this->validation->getError('relative_name'). $this->validation->getError('party_age') .
            // $this->validation->getError('party_gender') . $this->validation->getError('org_state') . $this->validation->getError('org_state_name') . $this->validation->getError('org_dept') . $this->validation->getError('org_dept_name') .
            // $this->validation->getError('org_post') . $this->validation->getError('org_post_name') . $this->validation->getError('party_email') . $this->validation->getError('party_mobile') .
            // $this->validation->getError('party_address') . $this->validation->getError('party_city') . $this->validation->getError('party_state') . $this->validation->getError('party_district') . $this->validation->getError('party_pincode');
            $errors = $this->validation->getErrors();

            foreach ($errors as $field => $error) {
                if(strpos($error, '{field}')){
                    echo str_replace('{field}', $field, $error) . "<br>";
                }else{
                    echo $error . "<br>";
                }
            }
            exit(0);
        }

        $is_org = FALSE;

        $party_as = !empty($_POST["party_as"]) ? $_POST["party_as"] : '';

        $party_name = !empty($_POST["party_name"]) ? $_POST["party_name"] : '';
        $party_relation = !empty($_POST["relation"]) ? $_POST["relation"] : '';
        $relative_name = !empty($_POST["relative_name"]) ? $_POST["relative_name"] : '';

        if (isset($_POST['party_dob']) && !empty($_POST['party_dob'])) {

            // $party_dob = $_POST["party_dob"];

            $dateTime = \DateTime::createFromFormat('d/m/Y', $_POST["party_dob"]);
            if ($dateTime !== false) {
                $party_dob = $dateTime->format('Y-m-d'); // Convert to 'Y-m-d'
            } else {
                // Handle the error (invalid date format)
                $party_dob = NULL;
            }
        } else {
            $party_dob = NULL;
        }
        $party_age = (!empty($_POST["party_age"]) && $_POST["party_age"] != 'NaN') ? $_POST["party_age"] : NULL;
        $party_gender = !empty($_POST["party_gender"]) ? $_POST["party_gender"] : '';

        if ($party_as != 'I') {
            $is_org = TRUE;
            if ($party_as != 'D3') {
                $org_state = url_decryption($_POST["org_state"]);
                if ($org_state == '0') {
                    $org_state_name = $_POST["org_state_name"];
                    $org_state_not_in_list = TRUE;
                } else {
                    $org_state_name = NULL;
                    $org_state_not_in_list = FALSE;
                }
            } else {
                $org_state = 00;
                $org_state_name = NULL;
                $org_state_not_in_list = FALSE;
            }

            $org_dept = url_decryption($_POST["org_dept"]);
            if ($org_dept == '0') {
                $org_dept_name = $_POST["org_dept_name"];
                $org_dept_not_in_list = TRUE;
            } else {
                $org_dept_name = NULL;
                $org_dept_not_in_list = FALSE;
            }

            $org_post = url_decryption($_POST["org_post"]);
            if ($org_post == '0') {
                $org_post_name = $_POST["org_post_name"];
                $org_post_not_in_list = TRUE;
            } else {
                $org_post_name = NULL;
                $org_post_not_in_list = FALSE;
            }
        } else {
            $org_state = 00;
            $org_state_name = NULL;
            $org_state_not_in_list = FALSE;
            $org_dept = 0;
            $org_dept_name = NULL;
            $org_dept_not_in_list = FALSE;
            $org_post = 0;
            $org_post_name = NULL;
            $org_post_not_in_list = FALSE;
        }

        $party_email = !empty($_POST["party_email"]) ? $_POST["party_email"] : NULL;
        $party_mobile = !empty($_POST["party_mobile"]) ? $_POST["party_mobile"] : NULL;
        $party_address = !empty($_POST["party_address"]) ? $_POST["party_address"] : NULL;
        $party_city = !empty($_POST["party_city"]) ? $_POST["party_city"] : NULL;
        $party_state_id = !empty($_POST["party_state"]) ? url_decryption($_POST["party_state"]) : NULL;
        $party_district_id = !empty($_POST["party_district"]) ? url_decryption($_POST["party_district"]) : NULL;
        $party_pincode = !empty($_POST["party_pincode"]) ? $_POST["party_pincode"] : '';

        $party_address_details = array(
            'email_id' => $party_email,
            'mobile_num' => $party_mobile,
            'address' => $party_address,
            'city' => $party_city,
            'state_id' => $party_state_id,
            'district_id' => $party_district_id,
            'pincode' => $party_pincode,
            'country_id'=>$country_id
        );

        $party_organisation = array(
            'org_state_id' => $org_state,
            'org_state_name' => $org_state_name,
            'org_state_not_in_list' => $org_state_not_in_list,
            'org_dept_id' => $org_dept,
            'org_dept_name' => $org_dept_name,
            'org_dept_not_in_list' => $org_dept_not_in_list,
            'org_post_id' => $org_post,
            'org_post_name' => $org_post_name,
            'org_post_not_in_list' => $org_post_not_in_list
        );
        $party_dob = trim($party_dob); // Remove any extra whitespace

        // if ($party_dob && strtotime($party_dob) !== false) {
        //     $formatted_date = date('Y-m-d', strtotime($party_dob));
        // } else {
        //     $formatted_date = null;
        // }

        $party_individual = array(
            'party_name' => $party_name,
            'relation' => $party_relation,
            'relative_name' => $relative_name,
            'party_age' => ($party_age != 'NaN') ? $party_age : null,
            'party_dob' => $party_dob,
            'gender' => $party_gender,
            'is_dead_minor'=>$is_dead_minor,
            'is_dead_file_status'=>$is_dead_file_status
        );

        $party_type = array(
            'is_org' => $is_org,
            'party_type' => $party_as,
            'p_r_type' => 'P',
            'm_a_type' => 'M',
            'party_no' => 1,
            'party_id' => 1
        );
        $party_details = array_merge($party_type, $party_individual, $party_organisation, $party_address_details);
       // echo '<pre>'; print_r($party_details); exit;

        $registration_id = getSessionData('efiling_details')['registration_id'];
        $curr_dt_time = date('Y-m-d H:i:s');
        if (isset($registration_id) && !empty($registration_id) && !empty(getSessionData('case_table_ids')->m_petitioner_id) && isset(getSessionData('case_table_ids')->m_petitioner_id)) {
            $party_update_data = array(
                'updated_on' => $curr_dt_time,
                'updated_by' => getSessionData('login')['id'],
                'updated_by_ip' => $_SERVER['REMOTE_ADDR']
            );
            $party_details = array_merge($party_details, $party_update_data);
            $status = $this->New_case_model->add_update_case_parties($registration_id, $party_details, NEW_CASE_PETITIONER, $_SESSION['case_table_ids']['m_petitioner_id']);
            if ($status) {
                log_message('info', "Petitioner details updated successfully!");
                reset_affirmation($registration_id);
                echo '2@@@' . htmlentities('Petitioner details updated successfully!', ENT_QUOTES) . '@@@' . base_url('newcase/defaultController/' . url_encryption(trim($registration_id . '#' . E_FILING_TYPE_NEW_CASE . '#' . getSessionData('efiling_details')['stage_id'])));
            } else {
                echo '1@@@' . htmlentities('Some error ! Please Try again.', ENT_QUOTES);
            }
        } else {
            $party_create_data = array(
                'registration_id' => $registration_id,
                'created_on' => $curr_dt_time,
                'created_by' => getSessionData('login')['id'],
                'created_by_ip' => $_SERVER['REMOTE_ADDR']
            );
            $party_details = array_merge($party_details, $party_create_data);
            $inserted_party_id = $this->New_case_model->add_update_case_parties($registration_id, $party_details, NEW_CASE_PETITIONER);
            if ($inserted_party_id) {

                $_SESSION['case_table_ids']['m_petitioner_id'] = $inserted_party_id;
                echo '2@@@' . htmlentities('Petitioner details added successfully', ENT_QUOTES) . '@@@' . base_url('newcase/defaultController/' . url_encryption(trim($registration_id . '#' . E_FILING_TYPE_NEW_CASE . '#' . Draft_Stage)));
            } else {
                echo '1@@@' . htmlentities('Some error ! Please Try again.', ENT_QUOTES);
            }
        }
    }

}
