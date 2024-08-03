<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Common\CommonModel;
use App\Models\AdjournmentLetter\AdjournmentModel;
use App\Models\Dashboard\StageslistModel;
use App\Models\Report\ReportModel;
use App\Models\Certificate\CertificateModel;
use App\Models\Mentioning\MentioningModel;
use App\Models\Citation\CitationModel;
use App\Libraries\webservices\Efiling_webservices;
use Exception;
use stdClass;

class ResponsiveVariantRouteController extends BaseController
{

    protected $CommonModel;
    protected $AdjournmentModel;
    protected $StageslistModel;
    protected $db;
    protected $ReportModel;
    protected $CertificateModel;
    protected $MentioningModel;
    protected $CitationModel;
    protected $efiling_webservices;

    public function __construct()
    {
        parent::__construct();
        $dbs = \Config\Database::connect();
        $this->db = $dbs->connect();
        $this->CommonModel = new CommonModel();
        $this->AdjournmentModel = new AdjournmentModel();
        $this->StageslistModel = new StageslistModel();
        $this->ReportModel = new ReportModel(); 
        $this->CertificateModel = new CertificateModel();
        $this->MentioningModel = new MentioningModel();
        $this->CitationModel = new CitationModel();
        $this->efiling_webservices = new Efiling_webservices();
        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT, USER_ADMIN, USER_ADMIN_READ_ONLY, USER_EFILING_ADMIN, SR_ADVOCATE, ARGUING_COUNSEL);
        if (!in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users_array)) {
            return response()->redirect(base_url('adminDashboard'));
            exit(0);
        }
    }

    public function showDashboard()
    {
        $data = []; 
        $this->render('responsive_variant.dashboard.index', $data);
    }

    public function showDashboardAlt()
    {
        $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT, USER_ADMIN, SR_ADVOCATE, ARGUING_COUNSEL);
        if (!in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users_array)) {
            return response()->redirect(base_url('/'));
            exit(0);
        }
        // return $this->render('responsive_variant.dashboard.index_alt');
        $advocate_id = getSessionData('login')['adv_sci_bar_id'];
        $sr_advocate_data = '';
        if (getSessionData('login')['ref_m_usertype_id'] == SR_ADVOCATE || getSessionData('login')['ref_m_usertype_id']  == ARGUING_COUNSEL) {
            $params = array();
            switch (getSessionData('login')['ref_m_usertype_id']) {
                case SR_ADVOCATE:
                    $params['table_name'] = 'efil.tbl_sr_advocate_engage';
                    $params['whereFieldName'] = 'sr_advocate_id';
                    $params['whereFieldValue'] = (int)$advocate_id;
                    $params['is_active'] = true;
                    $srAdvocateData = $this->CommonModel->getData($params);
                    $diaryIdsArr = array();
                    if (isset($srAdvocateData) && !empty($srAdvocateData)) {
                        $diaryIdsArr = array_column($srAdvocateData, 'diary_no');
                    }
                    $fgc_context = array(
                        'http' => array(
                            'user_agent' => 'Mozilla',
                        ),
                        "ssl" => array(
                            "verify_peer" => false,
                            "verify_peer_name" => false,
                        ),
                    );
                    $schedule_request_params = ['responseFormat' => 'CASE_WISE_FLATTENED_WITH_ALL_INFO', 'diaryIds' => $diaryIdsArr, 'fromDate' => date('Y-m-d'), 'forDate' => 'all', 'ifSkipDigitizedCasesStageComputation' => true];
                    list($sr_advocate_soon_cases) = (array)@json_decode(@file_get_contents(API_CAUSELIST_URI . '?' . http_build_query($schedule_request_params), false, stream_context_create($fgc_context)));
                    $or_request_params = [];
                    $or_request_params['documentType'] = 'or';
                    $or_request_params['diaryIds'] = array_column($sr_advocate_soon_cases, 'diary_id');
                    $or_response = json_decode(curl_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/getCaseDocuments?' . http_build_query($or_request_params)));
                    $office_reports = (isset($or_response) && !empty($or_response)) ? $or_response->data : array();
                    $rop_judgment_request_params = [];
                    $rop_judgment_request_params['documentType'] = 'rop-judgment';
                    $rop_judgment_request_params['diaryIds'] = array_column($sr_advocate_soon_cases, 'diary_id');
                    $rop_judgment_response = json_decode(curl_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/getCaseDocuments?' . http_build_query($rop_judgment_request_params)));
                    $rop_judgments = (isset($rop_judgment_response) && !empty($rop_judgment_response)) ? $rop_judgment_response->data : array();
                    foreach ($office_reports as $office_report) {
                        foreach ($sr_advocate_soon_cases as &$sr_advocate_soon_case) {
                            if ($sr_advocate_soon_case->diary_id == $office_report->diaryId && $sr_advocate_soon_case->meta->listing->listed_on == $office_report->dated) {
                                $sr_advocate_soon_case->office_reports = new stdClass();
                                $sr_advocate_soon_case->office_reports->current = new stdClass();
                                $path = substr($office_report->diaryId, strlen($office_report->diaryId) - 4) . '/' . substr($office_report->diaryId, 0, -4) . '/';
                                $sr_advocate_soon_case->office_reports->current->uri = 'https://main.sci.gov.in/officereport/' . $path . $office_report->fileUri;
                            }
                        }
                    }
                    foreach ($rop_judgments as $rop_judgment) {
                        foreach ($sr_advocate_soon_cases as &$sr_advocate_soon_case) {
                            if ($sr_advocate_soon_case->diary_id == $rop_judgment->diaryId) {
                                $sr_advocate_soon_case->rop_judgments = new stdClass();
                                $sr_advocate_soon_case->rop_judgments->current = new stdClass();
                                $sr_advocate_soon_case->rop_judgments->current->dated = $rop_judgment->dated;
                                $sr_advocate_soon_case->rop_judgments->current->uri = 'https://main.sci.gov.in/' . $rop_judgment->fileUri;
                            }
                        }
                    }
                    // data for my cases
                    $schedule_request_params = ['responseFormat' => 'CASE_WISE_FLATTENED_WITH_ALL_INFO', 'diaryNo' => $diaryIdsArr, 'forDate' => 'all', 'ifSkipDigitizedCasesStageComputation' => true];
                    $sr_advocate_data = (array)@json_decode(@file_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/getCaseDetails/?' . http_build_query($schedule_request_params), false, stream_context_create($fgc_context)));
                    if (isset($sr_advocate_data) && !empty($sr_advocate_data)) {
                        $arr = array();
                        $arr['sr_advocate_id'] = $advocate_id;
                        $arr['diary_no'] = $diaryIdsArr;
                        $arr['sr_advocate_arguing_type'] = SR_ADVOCATE;
                        $tmpArr = array();
                        $srAdvocateEngageData = $this->CommonModel->getSrAdvocateDataByDiaryNo($arr);
                        if (isset($srAdvocateEngageData) && !empty($srAdvocateEngageData)) {
                            foreach ($srAdvocateEngageData as $k => $v) {
                                $tmpArr[$v->diary_no] = $v->createdAt . '@' . $v->assignedby;
                            }
                        }
                        foreach ($sr_advocate_data['details'] as $key => $val) {
                            if (array_key_exists($val->diary_no, $tmpArr)) {
                                $arr = explode('@', $tmpArr[$val->diary_no]);
                                $createdAt = !empty($arr[0]) ? $arr[0] : '';
                                $assignedby = !empty($arr[1]) ? $arr[1] : '';
                                $sr_advocate_data['details'][$key]->createdAt = $createdAt;
                                $sr_advocate_data['details'][$key]->assignedby = $assignedby;
                            }
                        }
                    }
                    break;
                case ARGUING_COUNSEL:
                    $advocate_id = (int)getSessionData('login')['id'];
                    $params['login_id'] = $advocate_id;
                    $arguingCounselDiaryDetails = $this->CommonModel->getArguingCounselDiaryNo($params);
                    $diaryIdsArr = array();
                    if (isset($arguingCounselDiaryDetails[0]) && !empty($arguingCounselDiaryDetails[0])) {
                        $diaryIdsArr = explode(',', $arguingCounselDiaryDetails[0]['diary_no']);
                    }
                    $fgc_context = array(
                        'http' => array(
                            'user_agent' => 'Mozilla',
                        ),
                        "ssl" => array(
                            "verify_peer" => false,
                            "verify_peer_name" => false,
                        ),
                    );
                    $schedule_request_params = ['responseFormat' => 'CASE_WISE_FLATTENED_WITH_ALL_INFO', 'diaryIds' => $diaryIdsArr, 'fromDate' => date('Y-m-d'), 'forDate' => 'all', 'ifSkipDigitizedCasesStageComputation' => true];
                    list($sr_advocate_soon_cases) = (array)@json_decode(@file_get_contents(API_CAUSELIST_URI . '?' . http_build_query($schedule_request_params), false, stream_context_create($fgc_context)));
                    $or_request_params = [];
                    $or_request_params['documentType'] = 'or';
                    $or_request_params['diaryIds'] = array_column($sr_advocate_soon_cases, 'diary_id');
                    $or_response = json_decode(curl_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/getCaseDocuments?' . http_build_query($or_request_params)));
                    $office_reports = $or_response->data;
                    $rop_judgment_request_params = [];
                    $rop_judgment_request_params['documentType'] = 'rop-judgment';
                    $rop_judgment_request_params['diaryIds'] = array_column($sr_advocate_soon_cases, 'diary_id');
                    $rop_judgment_response = json_decode(curl_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/getCaseDocuments?' . http_build_query($rop_judgment_request_params)));
                    $rop_judgments = $rop_judgment_response->data;
                    foreach ($office_reports as $office_report) {
                        foreach ($sr_advocate_soon_cases as &$sr_advocate_soon_case) {
                            if ($sr_advocate_soon_case->diary_id == $office_report->diaryId && $sr_advocate_soon_case->meta->listing->listed_on == $office_report->dated) {
                                $sr_advocate_soon_case->office_reports = new stdClass();
                                $sr_advocate_soon_case->office_reports->current = new stdClass();
                                $path = substr($office_report->diaryId, strlen($office_report->diaryId) - 4) . '/' . substr($office_report->diaryId, 0, -4) . '/';
                                $sr_advocate_soon_case->office_reports->current->uri = 'https://main.sci.gov.in/officereport/' . $path . $office_report->fileUri;
                            }
                        }
                    }
                    foreach ($rop_judgments as $rop_judgment) {
                        foreach ($sr_advocate_soon_cases as &$sr_advocate_soon_case) {
                            if ($sr_advocate_soon_case->diary_id == $rop_judgment->diaryId) {
                                $sr_advocate_soon_case->rop_judgments = new stdClass();
                                $sr_advocate_soon_case->rop_judgments->current = new stdClass();
                                $sr_advocate_soon_case->rop_judgments->current->dated = $rop_judgment->dated;
                                $sr_advocate_soon_case->rop_judgments->current->uri = 'https://main.sci.gov.in/' . $rop_judgment->fileUri;
                            }
                        }
                    }
                    // data for my cases
                    $schedule_request_params = ['responseFormat' => 'CASE_WISE_FLATTENED_WITH_ALL_INFO', 'diaryNo' => $diaryIdsArr, 'forDate' => 'all', 'ifSkipDigitizedCasesStageComputation' => true];
                    $sr_advocate_data = (array)@json_decode(@file_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/getCaseDetails/?' . http_build_query($schedule_request_params), false, stream_context_create($fgc_context)));
                    if (isset($sr_advocate_data) && !empty($sr_advocate_data)) {
                        $arr = array();
                        $arr['sr_advocate_id'] = $advocate_id;
                        $arr['diary_no'] = $diaryIdsArr;
                        $arr['sr_advocate_arguing_type'] = ARGUING_COUNSEL;
                        $tmpArr = array();
                        $srAdvocateEngageData = $this->CommonModel->getSrAdvocateDataByDiaryNo($arr);
                        if (isset($srAdvocateEngageData) && !empty($srAdvocateEngageData)) {
                            foreach ($srAdvocateEngageData as $k => $v) {
                                $tmpArr[$v->diary_no] = $v->createdAt . '@' . $v->assignedby;
                            }
                        }
                        foreach ($sr_advocate_data['details'] as $key => $val) {
                            if (array_key_exists($val->diary_no, $tmpArr)) {
                                $arr = explode('@', $tmpArr[$val->diary_no]);
                                $createdAt = !empty($arr[0]) ? $arr[0] : '';
                                $assignedby = !empty($arr[1]) ? $arr[1] : '';
                                $sr_advocate_data['details'][$key]->createdAt = $createdAt;
                                $sr_advocate_data['details'][$key]->assignedby = $assignedby;
                            }
                        }
                    }
                    break;
                default:
            }
        } else {
            //echo "AOR id is: ".getSessionData('login')['adv_sci_bar_id'];
            $from_date = date("Y-m-d", strtotime("-3 months"));
            $to_date = date('Y-m-d');
            $incomplete_applications = [];
            $recent_documents_by_me = [];
            $recent_documents_by_me_grouped_by_document_type = [];
            $recent_documents_by_me_grouped_by_document_type['ia'] = [];
            $recent_documents_by_me_grouped_by_document_type['reply'] = [];
            $recent_documents_by_me_grouped_by_document_type['rejoinder'] = [];
            $recent_documents_by_me_grouped_by_document_type['other'] = [];
            $recent_documents_by_others = [];
            $recent_documents_by_others_grouped_by_document_type = [];
            $recent_documents_by_others_grouped_by_document_type['ia'] = [];
            $recent_documents_by_others_grouped_by_document_type['reply'] = [];
            $recent_documents_by_others_grouped_by_document_type['rejoinder'] = [];
            //$recent_documents_by_others_grouped_by_document_type = [];
            $recent_documents_by_others_grouped_by_document_type['adjournment_requests'] = [];
            $recent_documents_by_others_grouped_by_document_type['other'] = [];
            //echo "Recent Document Start:".date('H:i:s').'<br/>';
            $serviceUrl = ICMIS_SERVICE_URL;
            $from_date_encoded = $from_date;
            $to_date_encoded = $to_date;
            // Construct the URL
            $url = $serviceUrl . '/ConsumedData/getAdvocateDocuments/?advocateIds[]=' . $advocate_id . '&status=P&filingDateRange=' . $from_date_encoded . '%20to%20' . $to_date_encoded;
            // Fetch the data from the external service
            $recent_documents_str = file_get_contents($url);
            // Handle the response (convert to JSON, process it, etc.)
            $recent_documents = json_decode($recent_documents_str, true);
            // $recent_documents_str = file_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/getAdvocateDocuments/?advocateIds[]=' . $advocate_id . '&status=P&filingDateRange=' . $from_date . '%20to%20' . $to_date . '');
            // $recent_documents = json_decode($recent_documents_str);
            if (!empty($recent_documents) && count($recent_documents) > 0) {
                foreach ($recent_documents['data'] as $index => $data) {
                    //echo $index." Record<br/>";
                    if ($data['advocateId'] == $advocate_id) {
                        //$recent_documents_by_me[] = $data; //old comments by anshu
                        if ($data['isIA'] && $data['status'] == 'PENDING') {
                            //echo $index." its IA<br/>";
                            $recent_documents_by_me[] = $data;
                            $recent_documents_by_me_grouped_by_document_type['ia'][] = $data;
                        } else {
                            if ($data['status'] == 'PENDING') {
                                //echo $index." its non-IA<br/>";
                                switch ($data['typeName']) {
                                    case 'REPLY':
                                        $recent_documents_by_me_grouped_by_document_type['reply'][] = $data;
                                        $recent_documents_by_me[] = $data;
                                        break;
                                    case 'REJOINDER AFFIDAVIT':
                                        $recent_documents_by_me_grouped_by_document_type['rejoinder'][] = $data;
                                        $recent_documents_by_me[] = $data;
                                        break;
                                    default:
                                        $recent_documents_by_me_grouped_by_document_type['other'][] = $data;
                                        $recent_documents_by_me[] = $data;
                                        break;
                                }
                            }
                        }
                    } else {
                        //$recent_documents_by_others[] = $data; //old comments by anshu
                        if ($data['status'] == 'PENDING') {
                            //echo $index." its IA<br/>";
                            $recent_documents_by_others[] = $data;
                            $recent_documents_by_others_grouped_by_document_type['ia'][] = $data;
                        } else {
                            if ($data['status'] == 'PENDING') {
                                //echo $index." its non-IA<br/>";
                                switch ($data['typeName']) {
                                    case 'REPLY':
                                        $recent_documents_by_others_grouped_by_document_type['reply'][] = $data;
                                        $recent_documents_by_others[] = $data;
                                        break;
                                    case 'REJOINDER AFFIDAVIT':
                                        $recent_documents_by_others_grouped_by_document_type['rejoinder'][] = $data;
                                        $recent_documents_by_others[] = $data;
                                        break;
                                    default:
                                        $recent_documents_by_others_grouped_by_document_type['other'][] = $data;
                                        $recent_documents_by_others[] = $data;
                                        break;
                                }
                            }
                        }
                    }
                }
            }
            //Adjournment Request Started
            $recent_documents_str_advocate_others = file_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/getAdvocateAllCases/?advocateId=' . $advocate_id . '&onlyDiary=true');
            $recent_documents_advocate_others = json_decode($recent_documents_str_advocate_others);
            $adjournment_by_others_data = (isset($recent_documents_advocate_others)) ? $recent_documents_advocate_others->data : '';
            $others_all_diaryId_data = array_column((array)$adjournment_by_others_data, 'diaryId');
            $adjournment_by_others = array();
            if (count($others_all_diaryId_data) > 0 && $others_all_diaryId_data != null && !empty($others_all_diaryId_data)) {
                $adjournment_by_others = $this->AdjournmentModel->getAdjournmentRequests(getSessionData('login')['id'], $others_all_diaryId_data, "", true);
            }
            $adjournment_by_me = $this->AdjournmentModel->getAdjournmentRequests(getSessionData('login')['id']);
            //$recent_documents_by_others_grouped_by_document_type['adjournment_requests']=$adjournment_by_others;
            //$recent_documents_by_me_grouped_by_document_type['adjournment_requests']=$adjournment_by_me;
            $recent_documents_by_me = json_decode(json_encode($recent_documents_by_me));
            $recent_documents_by_me_grouped_by_document_type = json_decode(json_encode($recent_documents_by_me_grouped_by_document_type));
            $recent_documents_by_others = json_decode(json_encode($recent_documents_by_others));
            $recent_documents_by_others_grouped_by_document_type = json_decode(json_encode($recent_documents_by_others_grouped_by_document_type));
            //echo "Recent Document End:".date('H:i:s').'<br/>';
            //echo "Defect Start:".date('H:i:s').'<br/>';
            $open_defects_response_str = file_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/get_defect_details/?advocateIds[]=' . $advocate_id . '&isCured=false');
            $open_defects_response = json_decode($open_defects_response_str);
            $open_defects = !empty($open_defects_response) ? $open_defects_response->data : '';
            $open_defects_diary_ids_csv_defult = "";
            $open_defects_diary_ids_csv = !empty($open_defects) ?  "'" . implode("','", array_unique(array_map(function ($open_defect) {
                return $open_defect->diaryId;
            }, $open_defects))) . "'" : $open_defects_diary_ids_csv_defult;
            $db = \Config\Database::connect();
            $builder = $db->table('efil.tbl_efiling_nums en');
            $builder->join('efil.tbl_case_details cd', 'en.registration_id=cd.registration_id');
            if ($open_defects_diary_ids_csv != '') {
                $builder->whereIn('concat(cd.sc_diary_num,cd.sc_diary_year)', $open_defects_diary_ids_csv);
            }
            $query = $builder->get();
            $open_defect_applications = $query->getResult();
            // $open_defect_applications = $this->db->query($open_defect_applications_query)->result();
            $open_defects_grouped_by_days_left_to_due_date = [];
            $open_defects_grouped_by_days_left_to_due_date['days-left-10'] = [];
            $open_defects_grouped_by_days_left_to_due_date['days-left-20'] = [];
            $open_defects_grouped_by_days_left_to_due_date['days-left-30'] = [];
            $open_defects_grouped_by_days_left_to_due_date['over-due'] = [];
            $open_defect_combined = [];
            if (!empty($open_defects) && count($open_defects) > 0) {
                foreach ($open_defects as $open_defect) {
                    $open_defect_application = array_filter($open_defect_applications, function ($open_defect_application) use ($open_defect) {
                        return $open_defect_application->diaryid == $open_defect->diaryId;
                    });
                    if (count($open_defect_application) > 0) {
                        foreach ($open_defect_application as $key => $value) {
                            if (@$open_defect_application[$key]->diaryid != null) {
                                $open_defect->registration_id = @$open_defect_application[$key]->registration_id;
                                $open_defect->ref_m_efiled_type_id = @$open_defect_application[$key]->ref_m_efiled_type_id;
                                break;
                            }
                        }
                    }
                    $days_to_due_date = (int)$open_defect->daysToDueDate;
                    //if($days_to_due_date>=0 && $days_to_due_date<=$open_defect->totalDaysToDueDate){
                    if ($days_to_due_date >= 0 && $days_to_due_date <= $open_defect->totalDaysToDueDate) {
                        if ($days_to_due_date <= 10) {
                            $open_defects_grouped_by_days_left_to_due_date['days-left-10'][] = $open_defect;
                            $open_defect_combined[] = $open_defect;
                        } elseif ($days_to_due_date <= 20) {
                            $open_defects_grouped_by_days_left_to_due_date['days-left-20'][] = $open_defect;
                            $open_defect_combined[] = $open_defect;
                        } elseif ($days_to_due_date <= 30) {
                            $open_defects_grouped_by_days_left_to_due_date['days-left-30'][] = $open_defect;
                            $open_defect_combined[] = $open_defect;
                        } else {
                            $open_defects_grouped_by_days_left_to_due_date['over-due'][] = $open_defect;
                        }
                    } else {
                        $open_defects_grouped_by_days_left_to_due_date['over-due'][] = $open_defect;
                    }
                }
            }
            $open_defects = [];
            $open_defects = $open_defect_combined;
            //echo "Defect End:".date('H:i:s').'<br/>';
            //echo "Listed Case Start:".date('H:i:s').'<br/>';
            $fgc_context = array(
                'http' => array(
                    'user_agent' => 'Mozilla',
                ),
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );
            //$schedule_request_params = ['responseFormat' => 'CASE_WISE_FLATTENED_WITH_ALL_INFO', 'advocates'=> [7,1207,9147,2505,1373000,1222000,920], 'fromDat' => '2020-05-05', 'forDate' => 'all'];
            $scheduled_cases = array();
            if (!empty($advocate_id) && $advocate_id != null) {
                // $schedule_request_params = ['responseFormat' => 'CASE_WISE_FLATTENED_WITH_ALL_INFO', 'advocates' => [$advocate_id], 'forDate' => 'all', 'ifSkipDigitizedCasesStageComputation' => true];
                // list($scheduled_cases) = (array)@json_decode(@file_get_contents(API_CAUSELIST_URI . '?' . http_build_query($schedule_request_params), false, stream_context_create($fgc_context)));
                $schedule_request_params = [
                    'responseFormat' => 'CASE_WISE_FLATTENED_WITH_ALL_INFO',
                    'advocates' => [$advocate_id],
                    'forDate' => 'all',
                    'ifSkipDigitizedCasesStageComputation' => true
                ];
                // Fetching the JSON response
                $json_response = @file_get_contents(API_CAUSELIST_URI . '?' . http_build_query($schedule_request_params), false, stream_context_create($fgc_context));
                $decoded_response = @json_decode($json_response, true); // Use true to get an associative array
                // Assign the first element to $scheduled_cases
                $scheduled_cases = (!empty($decoded_response) && count($decoded_response) > 0) ? $decoded_response : [];
            }
            $or_request_params = [];
            $or_request_params['documentType'] = 'or';
            $or_request_params['diaryIds'] = array_column($scheduled_cases, 'diary_id');
            $or_response = json_decode(curl_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/getCaseDocuments?' . http_build_query($or_request_params)));
            $office_reports = (!empty($or_response)) ? $or_response->data : [];
            $rop_judgment_request_params = [];
            $rop_judgment_request_params['documentType'] = 'rop-judgment';
            $rop_judgment_request_params['diaryIds'] = array_column($scheduled_cases, 'diary_id');
            $rop_judgment_response = json_decode(curl_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/getCaseDocuments?' . http_build_query($rop_judgment_request_params)));
            $rop_judgments = (!empty($rop_judgment_response)) ? $rop_judgment_response->data : [];
            if (!empty($office_reports) && count($office_reports) > 0) {
                foreach ($office_reports as $office_report) {
                    foreach ($scheduled_cases as &$scheduled_case) {
                        if ($scheduled_case->diary_id == $office_report->diaryId && $scheduled_case->meta->listing->listed_on == $office_report->dated) {
                            $scheduled_case->office_reports = new stdClass();
                            $scheduled_case->office_reports->current = new stdClass();
                            $path = substr($office_report->diaryId, strlen($office_report->diaryId) - 4) . '/' . substr($office_report->diaryId, 0, -4) . '/';
                            //officereport/2020/13581/13581_2020_2020-09-11_1307.html
                            $scheduled_case->office_reports->current->uri = 'https://main.sci.gov.in/officereport/' . $path . $office_report->fileUri;
                        }
                    }
                }
            }
            if (!empty($rop_judgments) && count($rop_judgments) > 0) {
                foreach ($rop_judgments as $rop_judgment) {
                    foreach ($scheduled_cases as &$scheduled_case) {
                        if ($scheduled_case->diary_id == $rop_judgment->diaryId) {
                            $scheduled_case->rop_judgments = new stdClass();
                            $scheduled_case->rop_judgments->current = new stdClass();
                            $scheduled_case->rop_judgments->current->dated = $rop_judgment->dated;
                            $scheduled_case->rop_judgments->current->uri = 'https://main.sci.gov.in/' . $rop_judgment->fileUri;
                        }
                    }
                }
            }
            //echo "Listed Case End:".date('H:i:s').'<br/>';
            //echo "Draft Case Start:".date('H:i:s').'<br/>';
            $draft_applications = ($this->StageslistModel->get_efilied_nums_stage_wise_list(array(1), getSessionData('login')['id']));
            if ($draft_applications == false) {
                $draft_applications = array();
            }
            $initially_defective_applications = ($this->StageslistModel->get_efilied_nums_stage_wise_list(array(4), getSessionData('login')['id']));
            if ($initially_defective_applications == false) {
                $initially_defective_applications = array();
            }
            $incomplete_applications = array_merge($draft_applications, $initially_defective_applications);
            usort($incomplete_applications, function ($item_1, $item_2) {
                $datetime1 = strtotime($item_1->activated_on);
                $datetime2 = strtotime($item_2->activated_on);
                return $datetime2 - $datetime1;
            });
            $defect_notified = ($this->StageslistModel->get_efilied_nums_stage_wise_list(array(10), getSessionData('login')['id']));
            if ($defect_notified == false) {
                $defect_notified = array();
            }
            $pending_scrutiny = ($this->StageslistModel->get_efilied_nums_stage_wise_list(array(8, 9, 11), getSessionData('login')['id']));
            if ($pending_scrutiny == false) {
                $pending_scrutiny = array();
            }
            //echo "Draft Case End:".date('H:i:s').'<br/>';
            //echo "Efiled Case Start:".date('H:i:s').'<br/>';
            $final_submitted_applications = ($this->StageslistModel->get_efilied_nums_stage_wise_list(array(1), getSessionData('login')['id'], 1));
            if ($final_submitted_applications == false) {
                $final_submitted_applications = array();
            }
            //echo "Efiled Case Start:".date('H:i:s').'<br/>';
            $my_cases_recently_updated = [];
        }
        return $this->render('responsive_variant.dashboard.index_alt', @compact('open_defects', 'open_defects_grouped_by_days_left_to_due_date', 'draft_applications', 'initially_defective_applications', 'incomplete_applications', 'scheduled_cases', 'recent_documents_by_me', 'recent_documents_by_me_grouped_by_document_type', 'recent_documents_by_others', 'recent_documents_by_others_grouped_by_document_type', 'my_cases_recently_updated', 'final_submitted_applications', 'sr_advocate_soon_cases', 'sr_advocate_data', 'defect_notified', 'pending_scrutiny'));
    }

    public function showCases()
    {
       
        log_message('info', 'My cases access on ' . date('d-m-Y') . ' at ' . date("h:i:s A") . getClientIP() . '</b><br>User Agent: <b>' . $_SERVER['HTTP_USER_AGENT']);
        // $advocate_id = $this->session->userdata['login']['adv_sci_bar_id'];
        $advocate_id = getSessionData('login')['adv_sci_bar_id'];
        if (getSessionData('login')['ref_m_usertype_id'] == SR_ADVOCATE) {
            
            // $this->load->model('common/CommonModel');
            $params = array();
            $params['table_name'] = 'efil.tbl_sr_advocate_engage';
            $params['whereFieldName'] = 'sr_advocate_id';
            $params['whereFieldValue'] = (int)$advocate_id;
            $srAdvocateData = $this->CommonModel->getData($params);
            if (isset($srAdvocateData) && is_array($srAdvocateData) && count($srAdvocateData) > 0) {
                $diaryIdsArr = array_column($srAdvocateData, 'diary_no');
                $fgc_context = array(
                    'http' => array(
                        'user_agent' => 'Mozilla',
                    ),
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ),
                );
                // $this->load->model('common/CommonModel');
                $params = array();
                $params['table_name'] = 'efil.tbl_sr_advocate_engage';
                $params['whereFieldName'] = 'sr_advocate_id';
                $params['whereFieldValue'] = (int)$advocate_id;
                $params['is_active'] = true;
                $srAdvocateData = $this->CommonModel->getData($params);
                $diaryIdsArr = array();
                if (isset($srAdvocateData) && !empty($srAdvocateData)) {
                    $diaryIdsArr = array_column($srAdvocateData, 'diary_no');
                }
                $schedule_request_params = ['responseFormat' => 'CASE_WISE_FLATTENED_WITH_ALL_INFO', 'diaryNo' => $diaryIdsArr, 'forDate' => 'all', 'ifSkipDigitizedCasesStageComputation' => true];
                // $sr_advocate_data = (array)@json_decode(@file_get_contents(env('ICMIS_SERVICE_URL').'/ConsumedData/getCaseDetails/?'.http_build_query($schedule_request_params), false, stream_context_create($fgc_context)));
                $sr_advocate_data = (array)@json_decode(@file_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/getCaseDetails/?' . http_build_query($schedule_request_params), false, stream_context_create($fgc_context)));
                if (isset($sr_advocate_data) && !empty($sr_advocate_data)) {
                    $arr = array();
                    $arr['sr_advocate_id'] = $advocate_id;
                    $arr['diary_no'] = $diaryIdsArr;
                    $arr['sr_advocate_arguing_type'] = getSessionData('login')['ref_m_usertype_id'];
                    $tmpArr = array();
                    $srAdvocateEngageData = $this->CommonModel->getSrAdvocateDataByDiaryNo($arr);
                    if (isset($srAdvocateEngageData) && !empty($srAdvocateEngageData) && count($srAdvocateEngageData) > 0) {
                        foreach ($srAdvocateEngageData as $k => $v) {
                            $tmpArr[$v->diary_no] = $v->createdAt . '@' . $v->assignedby;
                        }
                    }
                    foreach ($sr_advocate_data['details'] as $key => $val) {
                        if (array_key_exists($val->diary_no, $tmpArr)) {
                            $arr = explode('@', $tmpArr[$val->diary_no]);
                            $createdAt = !empty($arr[0]) ? $arr[0] : '';
                            $assignedby = !empty($arr[1]) ? $arr[1] : '';
                            $sr_advocate_data['details'][$key]->createdAt = date('d/m/Y H:i:s', strtotime($createdAt));
                            $sr_advocate_data['details'][$key]->assignedby = $assignedby;
                        }
                    }
                }
            }
        } else {
            
            //$advocate_cases_response_str = file_get_contents(env('ICMIS_SERVICE_URL').'/ConsumedData/getAdvocateCases/?advocateIds[]=50&diaryIds[]=43532020');
            //$advocate_cases_response_str = file_get_contents(env('ICMIS_SERVICE_URL').'/ConsumedData/getAdvocateCases/?advocateIds[]='.$advocate_id);
            $adv_Cases = array();
            if (!empty($advocate_id) && $advocate_id != null) {
                 $advocate_cases_response_str = file_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/getAdvocateAllCases/?advocateId=' . $advocate_id);
                $adv_cases_response = json_decode($advocate_cases_response_str, true);
                $adv_Cases = !empty($adv_cases_response) ? $adv_cases_response['data'] : [];
            }
            // $adv_Cases = [];
            /*if(!empty($advocate_id)){
                $from_date=date("Y-m-d", strtotime("-3 months"));
                $to_date=date('Y-m-d');
                $my_cases_recently_updated_str = file_get_contents(env('ICMIS_SERVICE_URL').'/ConsumedData/getAdvocateCases/?advocateIds[]='.$advocate_id.'&status=P&filingDateRange='.$from_date.'%20to%20'.$to_date.'');
                $my_cases_recently_response = json_decode($my_cases_recently_updated_str);
                $my_cases_recently_updated = $my_cases_recently_response->data;
                $rop_judgment_request_params = [];
                $rop_judgment_request_params['documentType'] = 'rop-judgment';
                $rop_judgment_reques0t_params['diaryIds'] = array_column($my_cases_recently_updated, 'diaryId');
                $rop_judgment_response = json_decode(curl_get_contents(env('ICMIS_SERVICE_URL').'/ConsumedData/getCaseDocuments?'.http_build_query($rop_judgment_request_params)));
                $rop_judgments = $rop_judgment_response->data;
                $previousOrder = array();
                if(isset($rop_judgments) && !empty($rop_judgments)){
                    foreach ($rop_judgments as  $k=>$v){
                        $previousOrder[$v->diaryId] = ['path' => $v->fileUri, 'dated' => $v->dated];
                    }
                }
            }*/
        }
        $engageCounsel = array();
        $engageCounsel['is_active'] = true;
        // $this->load->model('common/CommonModel');
        $engagedDiaryCounselData = $this->CommonModel->getEngagedDiaryIds($engageCounsel);
       
        
       
        //$diaryEngaged = !empty($engagedDiaryCounselData) ? $engagedDiaryCounselData : NULL;
        $diaryEngaged = !empty($engagedDiaryCounselData) ? array_column($engagedDiaryCounselData, 'diary_no') : NULL;
      
         // $meta_data=array(
        //     'adv_cases_list' =>$adv_Cases,
        //     'adv_cases_response' =>$adv_cases_response,
        //     'sr_advocate_data'=>$sr_advocate_data['details'],
        //     'diaryEngaged'=>$diaryEngaged
        // );
        $meta_data = array(
            'adv_cases_list' => !empty($adv_Cases) ? $adv_Cases : [],
            'adv_cases_response' => !empty($adv_cases_response) ? $adv_cases_response : [],
            'sr_advocate_data' => !empty($sr_advocate_data['details']) ? $sr_advocate_data['details'] : [],
            'diaryEngaged' => $diaryEngaged,
            
        );
       // pr( $meta_data);

        // pr($meta_data);
        
       
        // $this->slice->view('responsive_variant.cases.index_1',$meta_data);
        $this->render('responsive_variant.cases.index_1', compact('meta_data'));
    }

    public function showCauselist()
    {
        $this->render('responsive_variant.causelist.index');
    }

    public function showCaseCrud($registration_id = null)
    {
        //newcase/defaultController/48733382928292.EC81A34D
        //428#1#1
        $registration_id = str_replace('_', '#', @$registration_id);
        $tab = @$_REQUEST['tab'];

        return $this->render('responsive_variant.case.crud', @compact('registration_id', 'tab'));
    }

    //Start
    public function showCaseDocumentCrudByRegistrationId($registration_id = null)
    {
        $registration_id = str_replace('_', '#', @$registration_id);
        $tab = @$_REQUEST['tab'];
    }

    public function showCaseInterimApplicationCrudByRegistrationId($registration_id = null)
    {
        $registration_id = str_replace('_', '#', @$registration_id);
        $tab = @$_REQUEST['tab'];
        $this->render('responsive_variant.case.interim_application.crud_registration', @compact('registration_id', 'tab'));
    }
    //END

    public function showCaseCertificateCrud($diary_id = null)
    {
        if (!empty(@$diary_id)) {
            $_SESSION['efiling_type'] = 'certificate';
            $direct_access_params = [
                'search_filing_type' => 'diary',
                'is_direct_access' => true,
                'diaryno' => substr($diary_id, 0, -4),
                'diary_year' => substr($diary_id, -4),
            ];
        }
        $this->render('responsive_variant.case.certificate.crud', compact('direct_access_params'));
    }

    public function showCaseCertificateListing($registration_id = null)
    {
        if (!empty($registration_id)) {
            // $this->load->model('certificate/CertificateModel');
            $estab_details = $this->CertificateModel->get_establishment_details();
            if ($estab_details) {
                $efiling_num_details = $this->CertificateModel->get_efiling_num_basic_Details($registration_id);
                $this->render('responsive_variant.case.certificate.listing');
            } else {
                redirect('login');
                exit(0);
            }
        } else {
            redirect('login');
            exit(0);
        }
    }

    public function showCaseCaveatCrud($registration_id = null)
    {
        if (!empty($_SESSION['efiling_details'])) {
            unset($_SESSION['efiling_details']);
        }
        $registration_id = str_replace('_', '#', @$registration_id);
        $tab = @$_REQUEST['tab'];
        $data['tab'] = $tab;
        $data['registration_id'] = $registration_id;
        return $this->render('responsive_variant.caveat.crud', $data);
    }

    public function showCaseMentioningCrud($diary_id = null)
    {
        if (!empty(@$diary_id)) {
            $_SESSION['efiling_type'] = 'mentioning';
            $direct_access_params = [
                'search_filing_type' => 'diary',
                'is_direct_access' => true,
                'diaryno' => substr($diary_id, 0, -4),
                'diary_year' => substr($diary_id, -4),
            ];
        }
        $this->render('responsive_variant.case.mentioning.crud', compact('direct_access_params'));
    }

    public function showCaseMentioningListing($registration_id = null)
    {
        if (!empty(@$registration_id)) {
            $estab_details = $this->MentioningModel->get_establishment_details();
            if ($estab_details) {
                // SET $_SESSION['efiling_details']
                $efiling_num_details = $this->MentioningModel->get_efiling_num_basic_Details($registration_id);
            } else {
                redirect('login');
                exit(0);
            }
        }
        $this->render('responsive_variant.case.mentioning.listing');
    }

    // public function showCaseDocumentCrud($diary_id = null)
    // {
    //     if (!empty(@$diary_id)) {
    //         setSessionData('efiling_type', 'misc');
    //         $direct_access_params = [
    //             'search_filing_type' => 'diary',
    //             'is_direct_access' => true,
    //             'diaryno' => substr($diary_id, 0, -4),
    //             'diary_year' => substr($diary_id, -4),

    //         ];
    //     }
    //     $data['sc_case_type'] = $this->ReportModel->get_sci_case_type();
    //     $this->render('responsive_variant.case.document.crud', $data);
    // }

    public function showCaseDocumentCrud($diary_id = null)
    {
        
        $direct_access_params = [];
        setSessionData('customEfil', 'misc');  // Use session service to set data
        setSessionData('efiling_type', 'misc');
        if (!empty(@$diary_id)) {
            $_SESSION['efiling_type'] = 'misc';
            $direct_access_params = [
                'search_filing_type' => 'diary',
                'is_direct_access' => true,
                'diaryno' => substr($diary_id, 0, -4),
                'diary_year' => substr($diary_id, -4),

            ];
        }
        $data['sc_case_type'] = $this->ReportModel->get_sci_case_type();
        $this->render('responsive_variant.case.document.crud', compact('direct_access_params', 'data'));
    }

    // public function showCaseInterimApplicationCrud($diary_id = null)
    // {
    //     $data['direct_access_params'] = [];
    //     if (!empty(@$diary_id)) {
    //         $_SESSION['efiling_type'] = 'ia';
    //         $data['direct_access_params'] = [
    //             'search_filing_type' => 'diary',
    //             'is_direct_access' => true,
    //             'diaryno' => substr($diary_id, 0, -4),
    //             'diary_year' => substr($diary_id, -4),
    //         ];
    //     }
    //     $data['sc_case_type'] = $this->ReportModel->get_sci_case_type();
    //     return $this->render('responsive_variant.case.interim_application.crud', $data);
    //     // $this->slice->view('responsive_variant.case.interim_application.crud', compact('direct_access_params'));
    // }



    public function showCaseInterimApplicationCrud($diary_id = null)
    {

        $direct_access_params = [];
        // Use session service to set data
        setSessionData('customEfil', 'ia');  // Use session service to set data
        setSessionData('efiling_type', 'ia');

        if (!empty($diary_id)) {
            $_SESSION['efiling_type'] = 'ia';
            $direct_access_params = [
                'search_filing_type' => 'diary',
                'is_direct_access' => true,
                'diaryno' => substr($diary_id, 0, -4),
                'diary_year' => substr($diary_id, -4),
            ];
        }
        $data['sc_case_type'] = $this->ReportModel->get_sci_case_type();
        return $this->render('responsive_variant.case.interim_application.crud', compact('direct_access_params', 'data'));
    }




    public function showCaseCitationCrud($diary_id = null)
    {
        if (!empty(@$diary_id)) {
            $_SESSION['efiling_type'] = 'citation';
            $direct_access_params = [
                'search_filing_type' => 'diary',
                'is_direct_access' => true,
                'diaryno' => substr($diary_id, 0, -4),
                'diary_year' => substr($diary_id, -4),
            ];
        }
        $this->render('responsive_variant.case.citation.crud', compact('direct_access_params'));
    }

    public function showCaseCitationListing($registration_id = null)
    {
        // SETS $_SESSION['estab_details']
        $estab_details = $this->CitationModel->get_establishment_details();
        if ($estab_details) {
            // SET $_SESSION['efiling_details']
            $efiling_num_details = $this->CitationModel->get_efiling_num_basic_Details($registration_id);
            $this->render('responsive_variant.case.citation.listing');
        } else {
            redirect('login');
            exit(0);
        }
    }

    public function showMyProfile()
    {
        $this->render('responsive_variant.my.profile');
    }

    public function showSearch()
    {
        $this->render('responsive_variant.search.index');
    }

    public function showSupport($tab = null)
    {
        $this->render('responsive_variant.support.index', compact('tab'));
    }

    public function showClerkCrud()
    {
        $this->render('responsive_variant.clerk.crud.index', compact('tab'));
    }

    /*public function showUtilities(){
        $this->slice->view('responsive_variant.utilities.index');
    }

    public function storePspdfkitPlaygroundUtilities(){
        //$this->load->library('guzzle');
        $file_contents = file_get_contents($_FILES['pspdfkit']['tmp_name']);
        $pspdfkit_document = uploadDocumentToPSPDFKitAlt($file_contents,'scefm-pspdfkit-playground-document-for-user-id-'.$_SESSION['login']['id'], true);
        if(!empty($pspdfkit_document)) {
            $pspdfkit_document_id = $pspdfkit_document['document_id'];
            if (empty($pspdfkit_document_id)) {
                //flash
            }
        }
        else{
            //flash
        }

        redirect('utilities');
    }*/

    public function showManual()
    {
        $this->render('usermanual_forms.Userguide_forms');
    }

    public function showMenu()
    {
        $this->render('responsive_variant.menu.index');
    }

    /*public function showCaseAdjournmentLetterCrud($diary_id=null){
        if(!empty(@$diary_id)) {
            $_SESSION['efiling_type']='adjournment_letter';
            $direct_access_params = [
                'search_filing_type' => 'diary',
                'is_direct_access' => true,
                'diaryno' => substr($diary_id, 0, -4),
                'diary_year' => substr($diary_id, -4),
            ];
        }
        $this->slice->view('responsive_variant.case.adjournment_letter.crud', compact('direct_access_params'));
    }*/

    public function showAdvocateData($diaryId)
    {
        $ref_m_usertype_id = !empty($_SESSION['login']['ref_m_usertype_id']) ? (int)$_SESSION['login']['ref_m_usertype_id'] : NULL;
        if (isset($ref_m_usertype_id) && !empty($ref_m_usertype_id) && $ref_m_usertype_id != USER_ADVOCATE) {
            redirect('cases');
        }
        $diaryNo = NULL;
        $diaryYear = NULL;
        $data = array();
        if (isset($diaryId) && !empty($diaryId)) {
            $diaryNo = substr($diaryId, 0, -4);
            $diaryYear = substr($diaryId, -4);
        }
        if (isset($diaryNo) && !empty($diaryNo) && isset($diaryYear) && !empty($diaryYear)) {
            // $this->load->library('webservices/efiling_webservices');
            $diaryData = $this->efiling_webservices->get_case_diary_details_from_SCIS($diaryNo, $diaryYear);
            unset($diaryData->case_details[0]->parties);
            $data['diaryDetails'] = !empty($diaryData->case_details[0]) ? $diaryData->case_details[0] : NULL;
            setSessionData('diaryDetails', $diaryData->case_details[0]);
        }
        // $this->load->model('common/CommonModel');
        $srAdvocate = $this->CommonModel->getSrAdvocateData();
        $params = array();
        $params['advocateId'] = !empty($_SESSION['login']['adv_sci_bar_id']) ? (int)$_SESSION['login']['adv_sci_bar_id'] : NULL;
        $params['diary_no'] = !empty($diaryId) ? (int)$diaryId : NULL;
        $params['user_type'] = 'sr_advocate';
        $srAssignedList = $this->CommonModel->getAssignedSrAdvocate($params);
        $data['srAssignedList'] =  !empty($srAssignedList) ? $srAssignedList : NULL;
        $srassingedId = array_column($srAssignedList, 'id');
        $data['srAssignedListId'] = !empty(array_column($srAssignedList, 'id')) ? $srassingedId : NULL;
        if (isset($srassingedId) && !empty($srassingedId)) {
            foreach ($srAdvocate as $k => $v) {
                $arr = $this->removeElementWithValue($srAdvocate, 'id', $srassingedId[$k]);
                $srAdvocate = $arr;
            }
        }
        $data['srAdvocate'] = !empty($srAdvocate) ? $srAdvocate : NULL;
        $data['sr_advocate'] = "sr_advocate";
        $this->render('responsive_variant.cases.crud', $data);
    }

    public function removeElementWithValue($array, $key, $value)
    {
        foreach ($array as $subKey => $subArray) {
            if ($subArray[$key] == $value) {
                unset($array[$subKey]);
            }
        }
        return $array;
    }

    public function arguingCounselData($diaryId)
    {
        $ref_m_usertype_id = !empty($_SESSION['login']['ref_m_usertype_id']) ? (int)$_SESSION['login']['ref_m_usertype_id'] : NULL;
        if (isset($ref_m_usertype_id) && !empty($ref_m_usertype_id) && $ref_m_usertype_id != USER_ADVOCATE) {
            redirect('cases');
        }
        $diaryNo = NULL;
        $diaryYear = NULL;
        $data = array();
        if (isset($diaryId) && !empty($diaryId)) {
            $diaryNo = substr($diaryId, 0, -4);
            $diaryYear = substr($diaryId, -4);
        }
        if (isset($diaryNo) && !empty($diaryNo) && isset($diaryYear) && !empty($diaryYear)) {
            // $this->load->library('webservices/efiling_webservices');
            $diaryData = $this->efiling_webservices->get_case_diary_details_from_SCIS($diaryNo, $diaryYear);
            unset($diaryData->case_details[0]->parties);
            $data['diaryDetails'] = !empty($diaryData->case_details[0]) ? $diaryData->case_details[0] : NULL;
            setSessionData('diaryDetails', $diaryData->case_details[0]);
        }
        // $this->load->model('common/CommonModel');
        $arguingCounsel = $this->CommonModel->getArguingCounselData();
        $params = array();
        $params['advocateId'] = !empty($_SESSION['login']['adv_sci_bar_id']) ? (int)$_SESSION['login']['adv_sci_bar_id'] : NULL;
        $params['diary_no'] = !empty($diaryId) ? (int)$diaryId : NULL;
        $params['user_type'] = 'arguing_counsel';
        $arguingCounselList = $this->CommonModel->getAssignedSrAdvocate($params);
        $data['arguingCounselList'] =  !empty($arguingCounselList) ? $arguingCounselList : NULL;
        $arguingCounselId = array_column($arguingCounselList, 'id');
        $data['srAssignedListId'] = !empty(array_column($arguingCounselList, 'id')) ? $arguingCounselId : NULL;
        if (isset($arguingCounselId) && !empty($arguingCounselId)) {
            foreach ($arguingCounsel as $k => $v) {
                $arr = $this->removeElementWithValue($arguingCounsel, 'id', $arguingCounselId[$k]);
                $arguingCounsel = $arr;
            }
        }
        $data['arguingCounsel'] = !empty($arguingCounsel) ? $arguingCounsel : NULL;
        $data['arguing_counsel'] = "arguing_counsel";
        $this->render('responsive_variant.cases.crud', $data);
    }

    public function showCasePaperBookViewer($diary_id)
    {
        $filename = $diary_id . "_" . date('d-m-Y_H_i_s') . ".pdf";
        list($case_file_paper_books, $response_code) = (curl_get_contents(env('API_SCI_INTERACT_PAPERBOOK_PDF') . $diary_id . "/get/paper_book?taskStage=live", array(), true));
        if ($response_code == 417) {
            echo $case_file_paper_books;
        } else {
            $filesize = strlen($case_file_paper_books);
            header('Content-Description: Consolidated Paperbook - Diary No. ' . $diary_id);
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . $filesize);
            echo $case_file_paper_books;
        }
        //status 403
    }

    /*public function showCasePaperBookViewer($diary_id){
	    $case_file_paper_books = (curl_get_contents(env(API_SCI_INTERACT_PAPERBOOK_PDF).$diary_id."/get/paper_book?taskStage=live"));
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/pdf');
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        echo $case_file_paper_books;

    }*/

    public function showCase3PDFPaperBookViewerupto04052024($diary_id = null)
    {
        $file_name = "Casefile_of_DNo_" . $diary_id . "_" . date('d-m-Y_H:i:s') . ".zip";
        // list($case_file_paper_books, $response_code) = (curl_get_contents(env(API_SCI_INTERACT_PAPERBOOK_PDF).$diary_id."/get/paper_book/categorized",array(),true));
        // parameter added in the exiting API on 02042023 as per API given by SCI-Interact team
        list($case_file_paper_books, $response_code) = (curl_get_contents(env('API_SCI_INTERACT_PAPERBOOK_PDF') . $diary_id . "/get/paper_book/categorized?taskStage=live", array(), true));
        if ($response_code == 417) {
            echo $case_file_paper_books;
        } else {
            $filesize = strlen($case_file_paper_books);
            header('Content-Description: Consolidated Paperbook - Diary No. ' . $diary_id);
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename=' . $file_name);
            header('Content-Transfer-Encoding: binary');
            header("Cache-Control: no-cache");
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . $filesize);
            echo $case_file_paper_books;
        }
        //status 403
    }

    public function showCase3PDFPaperBookViewer($diary_id = null)
    {
        $file_name = "Casefile_of_DNo_" . $diary_id . "_" . date('d-m-Y_H:i:s') . ".zip";
        $requestedBy = @ucfirst(@trim(@strtolower($this->session->userdata['login']['first_name']))) . ' ' . @ucfirst(@trim(@strtolower($this->session->userdata['login']['last_name'])));
        $requestedBy = ucwords($requestedBy);
        $designation = "";
        if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_ADVOCATE) {
            $designation = "(AOR - " . $this->session->userdata['login']['aor_code'] . ")";
        } else if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_IN_PERSON) {
            $designation = "(PIP)";
        }
        $requestedBy = $requestedBy . ' ' . $designation;
        if (!empty($requestedBy))
            $requestedBy = str_replace([' ', '(', ')'], ['%20', '%28', '%29'], $requestedBy);

        list($case_file_paper_books, $response_code) = (curl_get_contents(env('API_SCI_INTERACT_PAPERBOOK_PDF') . $diary_id . "/get/paper_book/categorized?taskStage=live&requestedBy=" . $requestedBy, array('Authorization: Bearer Bdjdgejshdv16484_svsg123134'), true));
        if ($response_code == 417) {
            echo $case_file_paper_books;
        } else {
            $filesize = strlen($case_file_paper_books);
            header('Content-Description: Consolidated Paperbook - Diary No. ' . $diary_id);
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename=' . $file_name);
            header('Content-Transfer-Encoding: binary');
            header("Cache-Control: no-cache");
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . $filesize);
            echo $case_file_paper_books;
        }
        //status 403
    }

    public function showCase3PDFPaperBookViewerOld($diary_id = null)
    {
        $file_name = "Casefile_of_DNo_" . $diary_id . "_" . date('d-m-Y_H:i:s') . ".zip";
        // echo $diary_id.'/'.$court_no;exit();
        // https://10.25.78.69:44434/api/digitization/case_file/{{$scheduled_case->diary_id}}/get/paper_book/categorized
        // $case_file_paper_books = (curl_get_contents(env(API_SCI_INTERACT_PAPERBOOK_PDF).$diary_id."/get/paper_book/categorized"));
        // parameter added in the exiting API on 02042023 as per API given by SCI-Interact team
        $case_file_paper_books = (curl_get_contents(env('API_SCI_INTERACT_PAPERBOOK_PDF') . $diary_id . "/get/paper_book/categorized?taskStage=live"));
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/zip');
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        echo $case_file_paper_books;
    }

    public function showCaseChecklist($registration_id = null)
    {
        $tab = 'Checklist';
        $method = "checklist";
        $this->render('responsive_variant.supplements.index', @compact('tab', 'method'));
    }

    public function auxiliary_docs()
    {
        $tab = 'Auxiliary Documents';
        $method = "pdfDocHome";
        $this->render('responsive_variant.supplements.index', @compact('tab', 'method'));
    }

    public function iaMiscDocShare()
    {
        $this->render('documentSharingWithProof.ia_misc_doc_share', []);
    }

    public function auxiliary_documents()
    {
        $tab = 'Auxiliary Documents Homepage';
        $method = "index";
        $this->render('responsive_variant.supplements.index', @compact('tab', 'method'));
    }

    /*public function prefilled_index_docs(){
        $tab = 'INDEX Documents';
        $method="indexDocHome";
        $this->slice->view('responsive_variant.prefilled_index.index', @compact('tab', 'method'));
    }*/

    public function prefilled_index_docs()
    {
        $tab = 'INDEX Documents';
        $method = "home_page_docs";
        $this->render('responsive_variant.prefilled_index.index', @compact('tab', 'method'));
    }

    /* start:function written for file a case of old e-filing */
    public function showOldEfilingCasesCrudByRegistrationId($registration_id = null)
    {
        // $registration_id=str_replace('_','#',@$registration_id);
        $tab = @$_REQUEST['tab'];
        $this->render('responsive_variant.case.refile_old_efiling_cases.crud_registration', @compact('registration_id', 'tab'));
    }

    public function showOldEfilingCasesCrud($diary_id = null)
    {
       
        // $direct_access_params = [];
        // $data['direct_access_params'] = [];
        // setSessionData('customEfil', 'refile');
        // if (!empty(@$diary_id)) {
        //     $_SESSION['efiling_type'] = 'misc';
        //     $data['direct_access_params'] = [
        //         'search_filing_type' => 'diary',
        //         'searchBy' => 'D',
        //         'is_direct_access' => true,
        //         'diaryNo' => substr($diary_id, 0, -4),
        //         'diaryYear' => substr($diary_id, -4),
        //     ];
        // }
        // $data['sc_case_type'] = $this->ReportModel->get_sci_case_type();
        // $this->render('responsive_variant.case.refile_old_efiling_cases.crud', compact('direct_access_params', 'data'));
        $direct_access_params = [];
        $data['direct_access_params'] = [];
        setSessionData('customEfil', 'refile');
        // setSessionData('efiling_type', 'refile_old_efiling_cases');
        if (!empty(@$diary_id)) {
            // $_SESSION['efiling_type'] = 'misc';
            $_SESSION['efiling_type'] = 'refile_old_efiling_cases';
            $data['direct_access_params'] = [
                'search_filing_type' => 'diary',
                'is_direct_access' => true,
                'diaryNo' => substr($diary_id, 0, -4),
                'diaryYear' => substr($diary_id, -4),
            ];
        }
        $data['sc_case_type'] = $this->ReportModel->get_sci_case_type();
        // pr($data);
        $this->render('responsive_variant.case.refile_old_efiling_cases.crud', compact('direct_access_params', 'data'));


    }
    /* end:function written for file a case of old e-filing */

    public function showCaseMisDocCrud($diary_id = null)
    {
        if (!empty(@$diary_id)) {
            $_SESSION['efiling_type'] = 'ia';
            $direct_access_params = [
                'search_filing_type' => 'diary',
                'is_direct_access' => true,
                'diaryno' => substr($diary_id, 0, -4),
                'diary_year' => substr($diary_id, -4),
            ];
        }
        $data['sc_case_type'] = $this->ReportModel->get_sci_case_type();
        return $this->render('responsive_variant.case.document.crud', $data);
        // $this->slice->view('responsive_variant.case.interim_application.crud', compact('direct_access_params'));
    }

    public function getDailyCaseCounts() {
        if (getSessionData('login')['ref_m_usertype_id'] != SR_ADVOCATE || getSessionData('login')['ref_m_usertype_id']  != ARGUING_COUNSEL) {
            $final_submitted_applications = ($this->StageslistModel->get_efilied_nums_stage_wise_list(array(1), getSessionData('login')['id'], 1));
            if ($final_submitted_applications == false) {
                $final_submitted_applications = array();
                header('Content-Type: application/json');
                http_response_code(400);
                return json_encode($final_submitted_applications);
            } else {
                $dateCounts = []; 
                foreach ($final_submitted_applications as $obj) {
                    $activatedDate = (isset($obj->activated_on) && !empty($obj->activated_on)) ? substr($obj->activated_on, 0, 10) : '';  
                    if (isset($dateCounts[$activatedDate]) && !empty($dateCounts[$activatedDate])) {
                        $dateCounts[$activatedDate]++;
                    } else {
                        $dateCounts[$activatedDate] = 1;
                    }
                }
                $passedArray = json_encode($dateCounts);
                header('Content-Type: application/json');
                foreach ($dateCounts as $date => $count) {
                    $jayParsedAry[] = array(
                        'start' => $date,
                        'count' => $count
                    );
                }
                return json_encode($jayParsedAry);              
            }
        }
    }

    public function getDayCaseDetails()
    {
        $cases = array();
        $start = date('Y-m-d 00:00:00', strtotime((string)$this->request->getPost('start')));
        $end = date('Y-m-d 23:59:59', strtotime((string)$this->request->getPost('start')));
        if (getSessionData('login')['ref_m_usertype_id'] != SR_ADVOCATE || getSessionData('login')['ref_m_usertype_id']  != ARGUING_COUNSEL) {
            $day_wise_cases = ($this->StageslistModel->get_day_wise_case_details(array(1), getSessionData('login')['id'], $start, $end, 1));
            if ($day_wise_cases == false) {
                header('Content-Type: application/json');
                http_response_code(400);
                return json_encode(array('error' => 'No Data Found!'));
            } else {
                foreach ($day_wise_cases as $case) {
                    $activated_date = date('Y-m-d h:i:s', strtotime($case->activated_on));
                    if ($activated_date >= $start && $activated_date <= $end) {
                        $cases[] = array(
                            'efiling_no' => $case->efiling_no,
                            'activated_on' => date("d/m/Y h.i.s A", strtotime($case->activated_on))
                        );
                    }
                }
                header('Content-Type: application/json');
                return json_encode($cases);
            }
        }
    }

}