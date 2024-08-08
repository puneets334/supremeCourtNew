<?php

namespace App\Controllers\Case;

use App\Controllers\BaseController;
use App\Models\Common\CommonModel;
use App\Models\MiscellaneousDocs\MiscellaneousDocsModel;
use App\Models\IA\IAModel;
use App\Models\Mentioning\MentioningModel;
use App\Models\Certificate\CertificateModel;
use App\Models\Citation\CitationModel;
use App\Models\Mentioning\ListingModel;
use App\Models\CaseSearch\CaseSearchModel;
use App\Models\AppearingFor\AppearingForModel;
use App\Models\OldCaseRefiling\OldEfilingDocsModel;
use App\Libraries\webservices\Efiling_webservices;
use App\Models\Consume\ConsumeDataModel;
use App\Models\Cron\DefaultModel;
use App\Models\FetchIcmisData\FetchDataModel;

class Search extends BaseController
{
    protected $Common_model;
    protected $MiscellaneousDocsModel;
    protected $IAModel;
    protected $MentioningModel;
    protected $CertificateModel;
    protected $CitationModel;
    protected $ListingModel;
    protected $CaseSearchModel;
    protected $AppearingForModel;
    protected $OldEfilingDocsModel;
    protected $efiling_webservices;
    protected $slice;
    protected $form_validation;
    protected $session;
    protected $config;
    protected $request;
    protected $validation;
    protected $ConsumeDataModel;
    protected $DefaultModel;
    protected $FetchDataModel;

    public function __construct()
    {
        parent::__construct();
        $this->Common_model = new CommonModel();
        $this->MiscellaneousDocsModel = new MiscellaneousDocsModel();
        $this->IAModel = new IAModel();
        $this->MentioningModel = new MentioningModel();
        $this->CertificateModel = new CertificateModel();
        $this->CitationModel = new CitationModel();
        $this->ListingModel = new ListingModel();
        $this->CaseSearchModel = new CaseSearchModel();
        $this->AppearingForModel = new AppearingForModel();
        $this->OldEfilingDocsModel = new OldEfilingDocsModel();
        $this->efiling_webservices = new Efiling_webservices();
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
        $this->ConsumeDataModel = new ConsumeDataModel();
        $this->DefaultModel = new DefaultModel();
        $this->FetchDataModel = new FetchDataModel();
    }

    // public function _remap($param = NULL)
    // {
    //     // changes_don_on_09012024_to_resolve_the_issue_as_error
    //     if ($param == 'index') {
    //         redirect('dashboard');
    //         exit(0);
    //     } elseif ($param == 'search_case_details') {
    //         $this->search_case_details();
    //     } elseif ($param == 'search_old_efiling_case_details') {
    //         $this->search_old_efiling_case_details();
    //     } elseif ($param == 'save_searched_case_result') {
    //         $this->save_searched_case_result();
    //     } elseif ($param == 'get_direct_access_page') {
    //         $this->get_direct_access_page();
    //     } else {
    //         $this->index($param);
    //     }
    // }

    public function index($efiling_type = null)
    {
        $efiling_type =getSessionData('efiling_type');        
        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK);
        if (!in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users_array)) {
            return response()->redirect(base_url('login'));
        }
        // $_SESSION['efiling_type'] = $efiling_type = url_decryption($efiling_type);
        if (!($efiling_type == 'misc' || $efiling_type == 'ia' || $efiling_type == 'mentioning' || $efiling_type == 'citation' || $efiling_type == 'certificate' || $efiling_type == 'adjournment_letter' || $efiling_type == 'refile_old_efiling_cases')) {
            unset($_SESSION['efiling_type']);
            return response()->redirect(base_url('dashboard'));
        } 
        $data['estab_details'] =  $this->Common_model->get_establishment_details(); //for responsive__variant
        $data['sc_case_type'] = $this->CaseSearchModel->get_sci_case_type();
        if ($efiling_type == 'refile_old_efiling_cases') {
            $this->render('casesearchForOldEfilingCases.case_search_view', $data, TRUE);
        } else {
            $this->render('casesearch.case_search_view', $data, TRUE);
        }
    }

    public function search_case_details()
    {
        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK);
        if (!in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('login');
            exit(0);
        }
        $diary_type = $this->request->getGet('search_filing_type');
        if ($diary_type == 'diary') {
            $this->validation->setRules([
                "search_filing_type" => [
                    "label" => "Case Type",
                    "rules" => "required|trim"
                ],
                "diaryno" => [
                    "label" => "Diary Number",
                    "rules" => "required|trim|min_length[1]|max_length[10]|numeric"
                ],
                "diary_year" => [
                    "label" => "Diary Year",
                    "rules" => "required|trim|min_length[4]|max_length[4]|numeric"
                ],
            ]);
        } elseif ($diary_type == 'register') {
            $this->validation->setRules([
                "search_filing_type" => [
                    "label" => "Case Type",
                    "rules" => "required|trim"
                ],
                "sc_case_type" => [
                    "label" => "Case Type",
                    "rules" => "required|trim"
                ],
                "case_number" => [
                    "label" => "Case Number",
                    "rules" => "required|trim|min_length[1]|max_length[10]|numeric"
                ],
                "case_year" => [
                    "label" => "Case Year",
                    "rules" => "required|trim|min_length[4]|max_length[4]|numeric"
                ],
            ]);
        }
        if ($this->validation->withRequest($this->request)->run() === FALSE) {
            $data = [
                'validation' => $this->validator,
            ];
        } else {
            if ($diary_type == 'diary') {
                $this->Common_model->get_establishment_details();
                $web_service_result = $this->efiling_webservices->get_case_diary_details_from_SCIS(escape_data($this->request->getGet('diaryno')), escape_data($this->request->getGet('diary_year')));
            } else if ($diary_type == 'register') {
                $web_service_result = $this->efiling_webservices->get_case_details_from_SCIS(url_decryption(escape_data($this->request->getGet('sc_case_type'))), escape_data($this->request->getGet('case_number')), escape_data($this->request->getGet('case_year')));
                // pr($web_service_result);
            }
            if (!empty($web_service_result->message)) {
                echo '3@@@ No Record found!';
                exit(0);
            } elseif (!empty($web_service_result->case_details[0])) {
                // pr($web_service_result);
                $diary_no = $web_service_result->case_details[0]->diary_no;
                $diary_year = $web_service_result->case_details[0]->diary_year;
                if (!empty($diary_no) && !empty($diary_year)) {
                    $listing_data = $this->efiling_webservices->get_last_listed_details($diary_no, $diary_year);
                    pr($listing_data);
                    // $data['listing_details'] = $listing_data->listed[0];
                    // $data['listing_details'] = $listing_data->listed[0];
                    if (isset($listing_data->listed) && is_array($listing_data->listed) && isset($listing_data->listed[0])) {
                        $data['listing_details'] = $listing_data->listed[0];
                    } else {
                        // Handle the case where $listing_data->listed is not set or not as expected
                        $data['listing_details'] = null;
                        echo "Error: 'listed' is not set or is not an array.";
                    }
                    $_SESSION['listing_details'] = $data['listing_details'];
                    $data['mentioning_request_details'] = $this->ListingModel->get_mentioning_request_details($diary_no, $diary_year);
                    $data['case_uncured_defects_details'] = $this->efiling_webservices->getCaseDefectDetails($diary_no, $diary_year); // add by kbpujari : To restrict AOR to file Misc.Document(s)/IA(s) in any of the defective matters, whether the case is filed  through efiling, new filing or filed physically
                    // $data['case_uncured_defects_details']->defects='';
                    if (empty($data['case_uncured_defects_details']->defects)) {
                        //start check Mark All Defects Cured
                        $registration_id = $this->ConsumeDataModel->getRegistrationIdByDiaryNo($diary_no . $diary_year);
                        if (!empty($registration_id)) {
                            $current_stage = $this->DefaultModel->get_current_stage($registration_id);
                            // pr($current_stage);
                            $allowed_case_types = array('39', '9', '10', '25', '26', '19', '20');
                            //var_dump($web_service_result->case_details[0]);exit();
                            if ($current_stage &&  !(in_array($web_service_result->case_details[0]->active_casetype_id, $allowed_case_types) || in_array($web_service_result->case_details[0]->casetype_id, $allowed_case_types))) {
                                if ($current_stage[0]->stage_id != E_Filed_Stage) {
                                    echo '3@@@ Please note, this case is defective. Kindly, cure all defects notified by the Registry through Refiling option.';
                                    exit(0);
                                }
                            }
                        }
                        //end check Mark All Defects Cured
                    } else {
                        echo '3@@@   1111111    Please note, this case is defective. Kindly, cure all defects notified by the Registry through Refiling option.';
                        exit(0);
                    }
                    $data['searched_case_details'] = $web_service_result->case_details[0];
                    if ($diary_type == 'diary') {
                        // if ((isset($_POST['is_direct_access']) && $_POST['is_direct_access'])) {
                        //     echo $result;
                        // } else{
                        //     echo '1@@@' . $result;
                        // }
                        echo '1@@@';
                        echo $this->render('casesearch.search_result_view', $data);
                    } else if ($diary_type == 'register') {
                        echo '2@@@';
                        echo $this->render('casesearch.search_result_view', $data, TRUE);
                    }
                } else {
                    $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center">You are not appearing in this case. Please Select "Want to represent new litigant." option and proceed..</p></div>');
                    echo '3@@@ No Record found!';
                    exit(0);
                }
            } else {
                echo '3@@@ Some error!';
                exit(0);
            }
        }
    }

    function save_searched_case_result()
    {
        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK);
        
        if (!in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users_array)) {
            // pr($allowed_users_array);
            redirect('login');
            exit(0);
        }
        $this->validation->setRules([
            'confirm_response' => [
                'label' => 'Confirmation',
                'rules' => 'required|trim|in_list[yes,no]'
            ]
        ]);
        $searched_details = url_decryption(escape_data($_POST['searched_details']));
        $searched_details = explode('$$$', $searched_details);
        if (count($searched_details) != 8) {
            $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center">Data tempered !.</div>');
            redirect('case/search/' . url_encryption($_SESSION['efiling_type']));
            exit(0);
        }
        // pr($searched_details);
        $parties_list = '';
        $diary_no = $searched_details[0];
        $diary_year = $searched_details[1];
        $order_date = $searched_details[2];
        $cause_title = $searched_details[3];
        $reg_no_display = $searched_details[4];
        $c_status = $searched_details[5];
        $pno = $searched_details[6];
        $rno = $searched_details[7];

        if (isset($_SESSION['parties_list'])) {
            $parties_list = $_SESSION['parties_list'];
        }
// pr($_SESSION);
        // $parties_list = $_SESSION['parties_list'];
        unset($_SESSION['parties_list']);
        $confirm_response = escape_data($_POST['confirm_response']);
        if ($confirm_response == 'yes') {
            $_SESSION['efiling_details'] = '';
            if (isset($_POST['radio_appearing_for'])) {
                $intervenorName = "";
                $radio_appearing_for = $_POST['radio_appearing_for'];
                

                if ($radio_appearing_for == 'E') {
                    $this->session->set('radio_appearing_for', $radio_appearing_for);
                    $appearance_exists = $this->MiscellaneousDocsModel->check_existence_of_appearing_for($diary_no, $diary_year);
                    // pr($appearance_exists);

                    if (!$appearance_exists) {
                        $diary_number = $diary_no . $diary_year;

                        $advPartyDetails = $this->efiling_webservices->getAdvPartyMappingBydiaryNo($diary_number);
                        // pr($advPartyDetails);
                        foreach ($advPartyDetails as $index => $detail) {
                            $result = $this->FetchDataModel->updateAdvocatePartyDetails($detail);
                        }
                        $appearance_exists = $this->MiscellaneousDocsModel->check_existence_of_appearing_for($diary_no, $diary_year);
                        if (!$appearance_exists) {
                            $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center">You are not appearing in this case. Please Select "Want to represent new litigant." option and proceed..</p></div>');
                        }
                    }
                }
                // CaseSearchModel
                // 12/11/2020 check for advocate exist
                else if ($radio_appearing_for == 'N') {
                    $this->session->setFlashdata('radio_appearing_for', $radio_appearing_for);
                    if ($_SESSION['efiling_type'] == 'ia') {
                        $advocate_exists = $this->MiscellaneousDocsModel->check_existence_of_appearing_for($diary_no, $diary_year);
                        if (!$advocate_exists) {
                            $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center">You are not appearing in this case. Please select intervenor/other.</p></div>');
                            redirect('case/search/' . url_encryption($_SESSION['efiling_type']));
                        } else {
                            $this->session->set('radio_appearing_for', $radio_appearing_for);
                        }
                    }
                }
                // 12/11/2020
                else if ($radio_appearing_for == 'I') {
                    $this->session->setFlashdata('radio_appearing_for', $radio_appearing_for);
                    $intervenorName = !empty($_POST['txtIntervenorName']) ? $_POST['txtIntervenorName'] : NULL;
                }
            }

            //END
            $pet_sr_no_array = array();
            $pet_sr_no_show_array = array();
            $pet_party_name_array = array();
            $res_sr_no_array = array();
            $res_sr_no_show_array = array();
            $res_party_name_array = array();

            foreach ($parties_list as $party_list) {
                if ($party_list->pet_res == 'P') {
                    $pet_sr_no_array[] = $party_list->sr_no;
                    $pet_sr_no_show_array[] = $party_list->sr_no_show;
                    $pet_party_name_array[] = $party_list->partyname;
                } elseif ($party_list->pet_res == 'R') {
                    $res_sr_no_array[] = $party_list->sr_no;
                    $res_sr_no_show_array[] = $party_list->sr_no_show;
                    $res_party_name_array[] = $party_list->partyname;
                }
            }

            //--PETITIONER PARTY DETAILS---//
            $pet_sr_no = implode("##", $pet_sr_no_array);
            $pet_sr_no_show = implode("##", $pet_sr_no_show_array);
            $pet_party_name = implode("##", $pet_party_name_array);

            //--RESPONDENT PARTY DETAILS---//
            $res_sr_no = implode("##", $res_sr_no_array);
            $res_sr_no_show = implode("##", $res_sr_no_show_array);
            $res_party_name = implode("##", $res_party_name_array);
            $sci_cases_details = array(
                'reg_no_display' => $reg_no_display,
                'cause_title' => $cause_title,
                'c_status' => $c_status,
                'p_no' => $pno,
                'r_no' => $rno,
                'p_sr_no' => $pet_sr_no,
                'p_sr_no_show' => $pet_sr_no_show,
                'p_partyname' => $pet_party_name,
                'r_sr_no' => $res_sr_no,
                'r_sr_no_show' => $res_sr_no_show,
                'r_partyname' => $res_party_name
            );

            $curr_dt_time = date('Y-m-d H:i:s');
            $diary_saved = FALSE;
            $diary_already_exists = $this->CaseSearchModel->get_diary_details($diary_no, $diary_year);
            if (isset($diary_already_exists) && !empty($diary_already_exists)) {
                $_SESSION['tbl_sci_case_id'] = $diary_already_exists[0]->id;
                // echo  $_SESSION['tbl_sci_case_id'];

                if ($diary_already_exists[0]->reg_no_display != $reg_no_display || $diary_already_exists[0]->cause_title != $cause_title || $diary_already_exists[0]->c_status != $c_status || $diary_already_exists[0]->p_no != $pno || $diary_already_exists[0]->r_no != $rno || $diary_already_exists[0]->p_sr_no != $pet_sr_no || $diary_already_exists[0]->p_sr_no_show != $pet_sr_no_show || $diary_already_exists[0]->p_partyname != $pet_party_name || $diary_already_exists[0]->r_sr_no != $res_sr_no || $diary_already_exists[0]->r_sr_no_show != $res_sr_no_show || $diary_already_exists[0]->r_partyname != $res_party_name) {
                    $sci_cases_details1 = array(
                        'updated_on' => $curr_dt_time,
                        'updated_by' => session()->get('login')['id'],
                        'updated_by_ip' => getClientIP()
                    );
                    $sci_cases_details = array_merge($sci_cases_details1, $sci_cases_details);
                    $diary_saved = $this->CaseSearchModel->add_update_sci_cases_details($sci_cases_details, array('diary_no' => $diary_no, 'diary_year' => $diary_year));
                    //echo $diary_saved;die;
                } else {
                    $diary_saved = TRUE;
                }
            } else {
                $sci_cases_details1 = array(
                    'diary_no' => $diary_no,
                    'diary_year' => $diary_year,
                    'created_on' => $curr_dt_time,
                    'created_by' => session()->get('login')['id'],
                    'created_by_ip' => getClientIP()
                );
                $sci_cases_details = array_merge($sci_cases_details1, $sci_cases_details);
                $diary_saved = $this->CaseSearchModel->add_update_sci_cases_details($sci_cases_details, NULL);
            }
            // Flow Come to this point 200624

            if (!$diary_saved) {
                $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center">Some error ! Please try after some time.</div>');
                redirect('dashboard');
                exit(0);
            } else {
                $diary_details = array('diary_no' => $diary_no, 'diary_year' => $diary_year);
                if (isset($_SESSION['efiling_type']) && $_SESSION['efiling_type'] == 'misc') {
                    $registration_id = $this->MiscellaneousDocsModel->generate_efil_num_n_add_case_details($diary_details, $curr_dt_time, $radio_appearing_for);
                    $redirectURL = 'miscellaneous_docs/defaultController/' . url_encryption($registration_id . '#' . E_FILING_TYPE_MISC_DOCS . '#' . Draft_Stage);
                    $type = 'Efiled Misc. docs No. ';

                    if (isset($_POST['radio_appearing_for']) && ($_POST['radio_appearing_for'] == 'E') && !empty($registration_id) && !empty(session()->get('login')['id'])) {
                        $data['appearing_for_details'] = $this->AppearingForModel->get_appearing_for_details($registration_id, session()->get('login')['id']);

                        if (!empty($data['appearing_for_details'][0]['partytype']) && ($data['appearing_for_details'][0]['partytype'] == 'P') || ($data['appearing_for_details'][0]['partytype'] == 'R') || ($data['appearing_for_details'][0]['partytype'] == 'I') || ($data['appearing_for_details'][0]['partytype'] == 'N')) {
                            if (($data['appearing_for_details'][0]['partytype'] == 'I') || ($data['appearing_for_details'][0]['partytype'] == 'N')) {
                                $redirectURL = 'uploadDocuments';
                            }
                        } else {
                            $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center">You are not appearing in this case. Please Select "Want to represent new litigant." option and proceed..</p></div>');
                            $_SESSION['MSG'] = '<div class="alert alert-danger text-center">You are not appearing in this case. Please Select "Want to represent new litigant." option and proceed..</p></div>';
                            //echo '<pre>';print_r($data['appearing_for_details']);exit();
                            //echo $_SESSION['MSG'];exit();
                            redirect()->to(base_url('case/document/crud/' . $diary_no . $diary_year));
                        }
                    }
                } elseif (isset($_SESSION['efiling_type']) && $_SESSION['efiling_type'] == 'ia') {
                    // pr("Debugging 1");
                    $intervenorNameString = NULL;
                    if (isset($intervenorName) && !empty($intervenorName) && count($intervenorName) > 0) {
                        $intervenorNameString = implode(',', $intervenorName);
                    }
                    $registration_id = $this->IAModel->generate_efil_num_n_add_case_details($diary_details, $curr_dt_time, $radio_appearing_for, '');

                    $redirectURL = 'IA/defaultController/' . url_encryption($registration_id . '#' . E_FILING_TYPE_IA . '#' . Draft_Stage);
                    $type = 'Efiled IA No. ';
                    if (isset($_POST['radio_appearing_for']) && ($_POST['radio_appearing_for'] == 'E') && !empty($registration_id) && !empty(getSessionData('login')['id'])) {


                        $data['appearing_for_details'] = $this->AppearingForModel->get_appearing_for_details($registration_id, getSessionData('login')['id']);

                        //  echo $registration_id;  echo '<pre>';print_r($data);exit();
                        /*  if (!empty($data['appearing_for_details'][0]['partytype']) && ($data['appearing_for_details'][0]['partytype'] == 'P') || ($data['appearing_for_details'][0]['partytype'] == 'R') || ($data['appearing_for_details'][0]['partytype'] == 'I') || ($data['appearing_for_details'][0]['partytype'] == 'N'))
                        {

                            // echo $_POST['radio_appearing_for'];
                            // echo "<br>";
                            //  pr("Debugging 3");

                            if (($data['appearing_for_details'][0]['partytype'] == 'I') || ($data['appearing_for_details'][0]['partytype'] == 'N')) {

                                $redirectURL = 'uploadDocuments';
                            }

                        } else {
                            // pr("Debugging 4");
                            $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center">You are not appearing in this case. Please Select "Want to represent new litigant." option and proceed..</p></div>');
                            $_SESSION['MSG'] = '<div class="alert alert-danger text-center">You are not appearing in this case. Please Select "Want to represent new litigant." option and proceed..</p></div>';
                            redirect()->to(base_url('case/interim_application/crud/' . $diary_no . $diary_year));
                        } */
                    }
                } elseif (isset($_SESSION['efiling_type']) && $_SESSION['efiling_type'] == 'mentioning') {

                    $registration_id = $this->MentioningModel->generate_efil_num_n_add_case_details($diary_details, $curr_dt_time);
                    $redirectURL = 'mentioning/defaultController/' . url_encryption($registration_id . '#' . E_FILING_TYPE_MENTIONING . '#' . Draft_Stage);
                    $type = 'Efiled Mentioning request No. ';
                } elseif (isset($_SESSION['efiling_type']) && $_SESSION['efiling_type'] == 'certificate') {

                    $registration_id = $this->CertificateModel->generate_efil_num_n_add_case_details($diary_details, $curr_dt_time);
                    $redirectURL = 'certificate/DefaultController/' . url_encryption($registration_id . '#' . E_FILING_TYPE_CERTIFICATE_REQUEST . '#' . Draft_Stage);
                    $type = 'Efiled certificate request No. ';
                } elseif (isset($_SESSION['efiling_type']) && $_SESSION['efiling_type'] == 'citation') {

                    $registration_id = $this->CitationModel->generate_efil_num_n_add_case_details($diary_details, $curr_dt_time);
                    $redirectURL = 'citation/defaultController/' . url_encryption($registration_id . '#' . E_FILING_TYPE_CITATION . '#' . Draft_Stage);
                    $type = 'Efiled citation No. ';
                } elseif (isset($_SESSION['efiling_type']) && $_SESSION['efiling_type'] == 'refile_old_efiling_cases') {

                    $registration_id = $this->OldEfilingDocsModel->generate_efil_num_n_add_case_details($diary_details, $curr_dt_time);

                    $redirectURL = 'oldCaseRefiling/defaultController/' . url_encryption($registration_id . '#' . OLD_CASES_REFILING . '#' . Draft_Stage);
                    //$redirectURL = 'case/refile_old_efiling_cases/crud_registration/' . url_encryption($registration_id . '#' . OLD_CASES_REFILING . '#' . Draft_Stage);
                    $type = 'E-filing No. ';
                }
                // pr("Come Here");
                if (isset($registration_id)  && !empty($registration_id)) {
                    //add intervenor data
                    if (isset($intervenorName) && !empty($intervenorName) && count($intervenorName) > 0) {
                        for ($i = 0; $i < count($intervenorName); $i++) {
                            $interVentionArr = array();
                            $interVentionArr['registration_id'] = !empty($registration_id) ? $registration_id : NULL;
                            $interVentionArr['p_r_type'] = 'I';
                            $interVentionArr['party_name'] = !empty($intervenorName[$i]) ?  $intervenorName[$i] : NULL;
                            $interVentionArr['created_by'] = !empty(getSessionData('login')['id']) ? getSessionData('login')['id'] : NULL;
                            $interVentionArr['created_on'] = date('Y-m-d H:i:s');
                            $interVentionArr['created_by_ip'] = getClientIP();
                            $interVentionArr['updated_by'] = NULL;
                            $interVentionArr['updated_on'] = NULL;
                            $interVentionArr['updated_by_ip'] = NULL;
                            $interVentionArr['is_deleted'] = FALSE;
                            $interVentionArr['deleted_by'] = NULL;
                            $interVentionArr['deleted_on'] = NULL;
                            $interVentionArr['deleted_by_ip'] = NULL;
                            $this->CaseSearchModel->addInterVention($interVentionArr);
                        }
                    }
                    //efiling num generated and being redirected to case details page to proceed further.
                    $user_name = getSessionData('login')['first_name'] . ' ' . getSessionData('login')['last_name'];
                    if (!empty($_SESSION['efiling_details'])) {
                        $efiling_num = $_SESSION['efiling_details']['efiling_no'];
                    } else {
                        $efiling_num = '';
                    }
                    $sentSMS = $type . efile_preview($efiling_num) . " generated from your efiling account & still pending for final submit. - Supreme Court of India";
                    $subject = $type . efile_preview($efiling_num) . " generated from your efiling account";
                    send_mobile_sms($_SESSION['login']['mobile_number'], $sentSMS, SCISMS_Submit_Pending);
                    send_mail_msg($_SESSION['login']['emailid'], $subject, $sentSMS, $user_name);
                    //  pr($redirectURL);
                    // echo $redirectURL; 
                    return response()->redirect(base_url($redirectURL));

                    // return redirect()->to(base_url($redirectURL));

                } else {

                    $this->session->setFlashdata('msg', '<div class="alert alert-danger text-center">There are Some  Error ! Please try after some time.</div>');
                    return response()->redirect('dashboard');
                }
            }
        } else {
            if ($confirm_response == 'no' && $_SESSION['efiling_type'] == 'misc') {
                //redirect('miscellaneous_docs/defaultController/'); exit(0);
                return redirect()->to(base_url('case/document/crud'));
            } elseif ($confirm_response == 'no' && $_SESSION['efiling_type'] == 'ia') {
                return redirect()->to(base_url('case/interim_application/crud/'));
            } elseif ($confirm_response == 'no' && $_SESSION['efiling_type'] == 'mentioning') {
                //redirect('mentioning/defaultController/'); exit(0);
                return redirect()->to(base_url('case/mentioning/crud/'));
            } elseif ($confirm_response == 'no' && $_SESSION['efiling_type'] == 'certificate') {
                //redirect('certificate/DefaultController/'); exit(0);
                return redirect()->to(base_url('case/certificate/crud/'));
            } elseif ($confirm_response == 'no' && $_SESSION['efiling_type'] == 'citation') {
                return redirect()->to(base_url('case/citation/crud/'));
            }
            return redirect()->to(base_url('dashboard'));
        }
    }

    function get_direct_access_page()
    {
        $this->load->view('templates/header');
        $this->load->view('casesearch/direct_access_view');
        $this->load->view('templates/footer');
    }

    /* code written for old efiling cases : start */
    public function search_old_efiling_case_details()
    {
        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK);

        if (!in_array($_SESSION['login']['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('login');
            exit(0);
        }

        // $diary_type = $_POST['search_filing_type'];
        $diary_type = $_REQUEST['search_filing_type'];

        $this->validation->setRules([
            "search_filing_type" => [
                "label" => "case type",
                "rules" => "required|trim|in_list[diary,register]"
            ]
        ]);
        if ($diary_type == 'diary') {
            $this->validation->setRules([
                "diaryno" => [
                    "label" => "Diary Number",
                    "rules" => "required|trim|min_length[1]|max_length[10]|numeric|is_required"
                ],
                "diary_year" => [
                    "label" => "Diary Year",
                    "rules" => "required|trim|min_length[4]|max_length[4]|numeric|is_required"
                ]
            ]);
        } elseif ($diary_type == 'register') {
            $this->validation->setRules([
                "sc_case_type" => [
                    "label" => "Case Type",
                    "rules" => "required|trim|is_required|encrypt_check"
                ],
                "case_number" => [
                    "label" => "Case Number",
                    "rules" => "required|trim|min_length[1]|max_length[10]|numeric|is_required"
                ],
                "case_year" => [
                    "label" => "Case Year",
                    "rules" => "required|trim|min_length[4]|max_length[4]|numeric|is_required"
                ]
            ]);
        }
        // $this->form_validation->set_error_delimiters('<br/>', '');
        if ($diary_type == 'diary') {

            // $web_service_result = $this->efiling_webservices->get_case_diary_details_from_SCIS(escape_data($_POST['diaryno']), escape_data($_POST['diary_year']));

            $web_service_result = $this->efiling_webservices->get_case_diary_details_from_SCIS(escape_data($this->request->getGet('diaryno')), escape_data($this->request->getGet('diary_year')));
            // pr($web_service_result);
        } else if ($diary_type == 'register') {

            $web_service_result = $this->efiling_webservices->get_case_details_from_SCIS(url_decryption(escape_data($_POST['sc_case_type'])), escape_data($_POST['case_number']), escape_data($_POST['case_year']));
        }
        if (!empty($web_service_result->message)) {
            echo '3@@@ No Record found!';
            exit(0);
        } elseif (!empty($web_service_result->case_details[0])) {
            $diary_no = $web_service_result->case_details[0]->diary_no;
            $diary_year = $web_service_result->case_details[0]->diary_year;
            if (!empty($diary_no) && !empty($diary_year)) {
                $listing_data = $this->efiling_webservices->get_last_listed_details($diary_no, $diary_year);
                $data['listing_details'] = $listing_data->listed[0];
                $_SESSION['listing_details'] = $data['listing_details'];

                $data['old_efiling_cases'] = $this->Common_model->get_old_efiling_cases($diary_no . $diary_year, $_SESSION['login']['aor_code']);
                if (empty($data['old_efiling_cases'])) {
                    echo '3@@@ Cases which are filed by you through old e-filing, Such cases can be re-filed with this option.';
                    exit(0);
                } else {
                    // logic written for aor can only refile the already file old efilinf case after 3 days
                    $data['case_last_refiled_details'] = $this->efiling_webservices->checkInTheOldEfilingCasesList($diary_no, $diary_year);
                    if (!empty($data['case_last_refiled_details'])) {
                        $last_refiled_on = ($data['case_last_refiled_details']->case_refiling_status[0]->created_at);
                        $last_refiled_on = date('d-m-Y', strtotime($last_refiled_on));
                        $curDate = date('d-m-Y');

                        $datediff = strtotime($curDate) - strtotime($last_refiled_on);
                        $date_diff_in_no_of_days = round($datediff / (60 * 60 * 24));
                        if ($date_diff_in_no_of_days <= 3) {
                            echo '3@@@ Please note, You can re-filed this case again after 3 days from the last refiling date i.e.' . $last_refiled_on;
                            exit(0);
                        }
                    }
                }
                $data['case_uncured_defects_details'] = $this->efiling_webservices->getCaseDefectDetails($diary_no, $diary_year); // add by kbpujari : To restrict AOR to file Misc.Document(s)/IA(s) in any of the defective matters, whether the case is filed  through efiling, new filing or filed physically
                if (empty($data['case_uncured_defects_details']->defects)) {
                    echo '3@@@ Please note, All the notified defects of this case,filed through old -efiling application has been already cured.';
                    exit(0);
                }
                //print_r($data['mentioning_request_details']);
                $data['searched_case_details'] = $web_service_result->case_details[0];
                $result = $this->load->view('casesearchForOldEfilingCases/search_result_view', $data, TRUE);
                if ($diary_type == 'diary') {
                    if ((isset($_POST['is_direct_access']) && $_POST['is_direct_access'])) {
                        $this->load->view('templates/header');
                        echo $result;
                        $this->Common_model->get_establishment_details();
                        $this->load->view('templates/footer');
                    } else {
                        echo '1@@@' . $result;
                    }
                } else if ($diary_type == 'register') {
                    echo '2@@@' . $result;
                }
            } else {
                echo '3@@@ No Record found!';
                exit(0);
            }
        } else {
            echo '3@@@ Some error!';
            exit(0);
        }
    }
}
