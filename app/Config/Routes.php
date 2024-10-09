<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'DefaultController::index');
$routes->post('/login', 'DefaultController::login');
$routes->get('/logout', 'Login\Logout::index');
$routes->post('/otp', 'DefaultController::otp');
$routes->match(['GET', 'POST'], 'fetch_icmis_data', 'fetchIcmisData');
$routes->match(['GET', 'POST'], 'fetch_icmis_data/test', 'fetchIcmisData/test');
$routes->match(['GET', 'POST'], 'default_controller', 'defaultController');
$routes->get('newcase/', 'NewCase\DefaultController::index');
$routes->get('newcase/caseDetails', 'NewCase\CaseDetails::index');
$routes->get('newcase/petitioner', 'NewCase\Petitioner::index');
$routes->match(['GET', 'POST'], 'newcase/petitioner/add_petitioner', 'NewCase\Petitioner::add_petitioner');
$routes->get('newcase/defaultController/(:any)', 'NewCase\DefaultController::index/$1');
$routes->match(['GET', 'POST'], 'newcase/courtFee', 'NewCase\CourtFee::index');
$routes->match(['GET', 'POST'], 'newcase/respondent', 'NewCase\Respondent::index');
$routes->match(['GET', 'POST'], 'newcase/respondent/add_respondent', 'NewCase\Respondent::add_respondent');
$routes->match(['GET', 'POST'], 'newcase/subordinate_court', 'NewCase\SubordinateCourt::index');
$routes->post('newcase/Ajaxcalls/get_casetype_check', 'NewCase\Ajaxcalls::get_casetype_check');
$routes->post('newcase/Ajaxcalls_subordinate_court/get_high_court', 'NewCase\AjaxcallsSubordinateCourt::get_high_court');
$routes->post('newcase/Ajaxcalls_subordinate_court/get_state_list', 'NewCase\AjaxcallsSubordinateCourt::get_state_list');
$routes->post('newcase/Ajaxcalls_subordinate_court/get_icmis_state_list', 'NewCase\AjaxcallsSubordinateCourt::get_icmis_state_list');
$routes->post('newcase/Ajaxcalls_subordinate_court/get_state_agency_list', 'NewCase\AjaxcallsSubordinateCourt::get_state_agency_list');
$routes->post('newcase/Ajaxcalls_subordinate_court/get_district_list', 'NewCase\AjaxcallsSubordinateCourt::get_district_list');
$routes->post('newcase/Ajaxcalls_subordinate_court/get_hc_bench_list', 'NewCase\AjaxcallsSubordinateCourt::get_hc_bench_list');
$routes->post('newcase/caseDetails/add_case_details', 'NewCase\CaseDetails::add_case_details');
$routes->post('newcase/Ajaxcalls/get_sub_category', 'NewCase\Ajaxcalls::get_sub_category');
$routes->post('newcase/Ajaxcalls/get_sub_cat_check', 'NewCase\Ajaxcalls::get_sub_cat_check');
$routes->post('newcase/Ajaxcalls/get_org_departments', 'NewCase\Ajaxcalls::get_org_departments');
$routes->post('newcase/Ajaxcalls/get_org_posts', 'NewCase\Ajaxcalls::get_org_posts');
$routes->post('documentIndex/Ajaxcalls/get_index_type', 'DocumentIndex\Ajaxcalls::get_index_type');
$routes->post('newcase/Ajaxcalls/get_districts', 'NewCase\Ajaxcalls::get_districts');
$routes->post('csrftoken/DefaultController/updateIsDeadMinorData', 'Csrftoken\DefaultController::updateIsDeadMinorData');
$routes->match(['GET', 'POST'], 'newcase/view', 'NewCase\View::index');
$routes->match(['GET', 'POST'], 'newcase/view/(:any)', 'NewCase\View::index/$1');
$routes->match(['GET', 'POST'], 'documentIndex', 'DocumentIndex\DefaultController::index');
$routes->match(['GET', 'POST'], 'documentIndex/Ajaxcalls/load_document_index', 'DocumentIndex\Ajaxcalls::load_document_index');
$routes->match(['GET', 'POST'], 'uploadDocuments/DefaultController/upload_pdf', 'UploadDocuments\DefaultController::upload_pdf');
$routes->match(['GET', 'POST'], 'newcase/Ajaxcalls_subordinate_court/get_hc_case_type_list', 'NewCase\AjaxcallsSubordinateCourt::get_hc_case_type_list');
$routes->match(['GET', 'POST'], 'newcase/Ajaxcalls_subordinate_court/get_sci_case_type', 'NewCase\AjaxcallsSubordinateCourt::get_sci_case_type');
$routes->match(['GET', 'POST'], 'newcase/Ajaxcalls_subordinate_court/search_case_details', 'NewCase\AjaxcallsSubordinateCourt::search_case_details');
$routes->match(['GET', 'POST'], 'newcase/Ajaxcalls_subordinate_court/get_sci_case_type', 'NewCase\AjaxcallsSubordinateCourt::get_sci_case_type');
$routes->match(['GET', 'POST'], 'newcase/Ajaxcalls_subordinate_court/search_case_details', 'NewCase\AjaxcallsSubordinateCourt::search_case_details');
$routes->match(['GET', 'POST'], 'newcase/Ajaxcalls_subordinate_court/get_establishment_list', 'NewCase\AjaxcallsSubordinateCourt::get_establishment_list');
$routes->match(['GET', 'POST'], 'newcase/subordinate_court/add_subordinate_court_details', 'NewCase\SubordinateCourt::add_subordinate_court_details');
$routes->match(['GET', 'POST'], 'uploadDocuments', 'UploadDocuments\DefaultController::index');
$routes->match(['GET', 'POST'], 'documentIndex/Ajaxcalls/get_doc_type', 'DocumentIndex\Ajaxcalls::get_doc_type');
$routes->match(['GET', 'POST'], 'documentIndex/Ajaxcalls/get_sub_doc_type_check', 'DocumentIndex\Ajaxcalls::get_sub_doc_type_check');
$routes->match(['GET', 'POST'], 'documentIndex/Ajaxcalls/get_sub_doc_type', 'DocumentIndex\Ajaxcalls::get_sub_doc_type');
$routes->match(['GET', 'POST'], 'documentIndex/DefaultController/add_index_item', 'DocumentIndex\DefaultController::add_index_item');
$routes->match(['GET', 'POST'], 'documentIndex/DefaultController/add_index_items', 'DocumentIndex\DefaultController::add_index_item');
$routes->match(['GET', 'POST'], 'uploadDocuments/viewDocument/(:any)', 'UploadDocuments\ViewDocument::index/$1');
$routes->match(['GET', 'POST'], 'newcase/Ajaxcalls_subordinate_court/bypass_hc', 'NewCase\AjaxcallsSubordinateCourt::bypass_hc');
$routes->match(['GET', 'POST'], 'newcase/Ajaxcalls_subordinate_court/OpenAPIcase_type_list', 'NewCase\AjaxcallsSubordinateCourt::OpenAPIcase_type_list');
$routes->match(['GET', 'POST'], 'newcase/Ajaxcalls_subordinate_court/get_state_agency_case_types', 'NewCase\AjaxcallsSubordinateCourt::get_state_agency_case_types');
$routes->match(['GET', 'POST'], 'documentIndex/viewIndexItem/(:any)', 'DocumentIndex\ViewIndexItem::index/$1');
$routes->match(['GET', 'POST'], 'newcase/finalSubmit/valid_efil', 'NewCase\FinalSubmit::valid_efil');
$routes->match(['GET', 'POST'], 'newcase/finalSubmit', 'NewCase\FinalSubmit::index');
$routes->match(['GET', 'POST'], 'newcase/courtFee/add_court_fee_details', 'NewCase\CourtFee::add_court_fee_details');
$routes->match(['GET', 'POST'], 'shcilPayment/paymentRequest', 'ShcilPayment\PaymentRequest::index');
$routes->match(['GET', 'POST'], 'newcase/AutoDiary/valid_efil', 'NewCase\AutoDiary::valid_efil');
$routes->match(['GET', 'POST'], 'newcase/AutoDiary', 'NewCase\AutoDiary::index');
$routes->match(['GET', 'POST'], 'newcase/Ajaxcalls/getAddressByPincode', 'NewCase\Ajaxcalls::getAddressByPincode');
$routes->match(['GET', 'POST'], 'newcase/Ajaxcalls/getSelectedDistricts', 'NewCase\Ajaxcalls::getSelectedDistricts');
$routes->match(['GET', 'POST'], 'newcase/Subordinate_court/DeleteSubordinateCourt/(:any)', 'NewCase\SubordinateCourt::DeleteSubordinateCourt/$1');
$routes->match(['GET', 'POST'], 'uploadDocuments/DefaultController/deletePDF', 'UploadDocuments\DefaultController::deletePDF');
$routes->match(['GET', 'POST'], 'shcilPayment/paymentResponse', 'ShcilPayment\PaymentResponse::index');
$routes->match(['GET', 'POST'], 'newcase/AutoDiaryGeneration', 'NewCase\AutoDiaryGeneration::index');
$routes->match(['GET', 'POST'], 'acknowledgement/view', 'Acknowledgement\View::index');
$routes->match(['GET', 'POST'], 'history/efiled_case/view', 'History\EfiledCase::view');
$routes->match(['GET', 'POST'], 'newcase/Ajaxcalls/getAllFilingDetailsByRegistrationId', 'NewCase\Ajaxcalls::getAllFilingDetailsByRegistrationId');
$routes->match(['GET', 'POST'], 'newcase/Ajaxcalls/updateDiaryDetails', 'NewCase\Ajaxcalls::updateDiaryDetails');
// $routes->match(['GET', 'POST'],'404_override', 'My404');
// $routes->match(['GET', 'POST'],'translate_uri_dashes', FALSE);
$routes->get('adminDashboard', 'AdminDashboard\DefaultController::index');
$routes->add('adminDashboard/stageList/(:any)', 'AdminDashboard\StageList::index/$1');
$routes->match(['GET', 'POST'], 'superAdmin', 'SuperAdmin\DefaultController::index');
$routes->match(['GET', 'POST'], 'customDashboard', 'defaultController::customDashboard');
$routes->match(['GET', 'POST'], 'filingAdmin', 'FilingAdmin\DefaultController::index', ['as' => 'filingAdmin']);

$routes->match(['GET', 'POST'], 'filingAdmin/userListing', 'FilingAdmin\DefaultController::userListing', ['as' => 'userListing']);
$routes->match(['GET', 'POST'], 'filingAdmin/userFileTransferForm', 'FilingAdmin\DefaultController::userFileTransferForm');
$routes->match(['GET', 'POST'], 'filingAdmin/getEmpDetailsByUserId', 'FilingAdmin\DefaultController::getEmpDetailsByUserId');
$routes->match(['GET', 'POST'], 'filingAdmin/updateUserRole', 'FilingAdmin\DefaultController::updateUserRole');
$routes->match(['GET', 'POST'], 'filingAdmin/DefaultController/getEmpCaseData', 'FilingAdmin\DefaultController::getEmpCaseData');
$routes->match(['GET', 'POST'], 'filingAdmin/DefaultController/fileTransferToAnOtherUser', 'FilingAdmin\DefaultController::fileTransferToAnOtherUser');

$routes->match(['GET', 'POST'], 'admin/noc_vakalatnama', 'Admin\NocVakalatnama::index');
$routes->get('admin/noc_vakalatnama/get_transferred_cases', 'Admin\NocVakalatnama::get_transferred_cases');
$routes->get('vacation/advance', 'Vacation\Advance::index');
$routes->get('vacation/advance/declinelist', 'Vacation\Advance::declinelist');
$routes->get('vacation/advance/alllist', 'Vacation\Advance::alllist');
$routes->post('vacation/advance/restoreVacationAdvanceListAOR', 'Vacation\Advance::restoreVacationAdvanceListAOR');
$routes->post('vacation/advance/declineVacationListCasesAOR', 'Vacation\Advance::declineVacationListCasesAOR');
/****start-Responsive variant routes****/
/*$routes->match(['GET', 'POST'],'add_approve_arguing_counsel','register/arguingCounsel');*/
$routes->match(['GET', 'POST'], 'dashboard', 'ResponsiveVariantRouteController::showDashboard');
$routes->match(['GET', 'POST'], 'dashboard_alt', 'ResponsiveVariantRouteController::showDashboardAlt');
$routes->match(['GET', 'POST'], 'cases', 'ResponsiveVariantRouteController::showCases');
$routes->match(['GET', 'POST'], 'causelist', 'ResponsiveVariantRouteController::showCauselist');
$routes->match(['GET', 'POST'], 'case/crud/(:any)', 'ResponsiveVariantRouteController::showCaseCrud/$1');
$routes->match(['GET', 'POST'], 'case/crud', 'ResponsiveVariantRouteController::showCaseCrud');
$routes->match(['GET', 'POST'], 'case/mentioning/crud/(:any)', 'ResponsiveVariantRouteController::showCaseMentioningCrud/$1');
$routes->match(['GET', 'POST'], 'case/mentioning/crud', 'ResponsiveVariantRouteController::showCaseMentioningCrud');
$routes->match(['GET', 'POST'], 'case/interim_application/crud/(:any)', 'ResponsiveVariantRouteController::showCaseInterimApplicationCrud/$1');
$routes->match(['GET', 'POST'], 'case/interim_application/crud', 'ResponsiveVariantRouteController::showCaseInterimApplicationCrud');
$routes->match(['GET', 'POST'], 'case/interim_application/crud_registration/(:any)', 'ResponsiveVariantRouteController::showCaseInterimApplicationCrudByRegistrationId/$1');
$routes->match(['GET', 'POST'], 'case/citation/crud/(:any)', 'ResponsiveVariantRouteController::showCaseCitationCrud/$1');
$routes->match(['GET', 'POST'], 'case/citation/crud', 'ResponsiveVariantRouteController::showCaseCitationCrud');
$routes->match(['GET', 'POST'], 'case/adjournment_letter/crud/(:any)', 'ResponsiveVariantRouteController::showCaseAdjournmentLetterCrud/$1');
$routes->match(['GET', 'POST'], 'case/adjournment_letter/crud', 'ResponsiveVariantRouteController::showCaseAdjournmentLetterCrud');
$routes->match(['GET', 'POST'], 'case/certificate/crud/(:any)', 'ResponsiveVariantRouteController::showCaseCertificateCrud/$1');
$routes->match(['GET', 'POST'], 'case/certificate/crud', 'ResponsiveVariantRouteController::showCaseCertificateCrud');
$routes->match(['GET', 'POST'], 'caveat/', 'Caveat\DefaultController::index'); //sunny
$routes->match(['GET', 'POST'], 'caveat/caveator/add_caveators', 'Caveat\Caveator::add_caveators'); //sunny
$routes->match(['GET', 'POST'], 'case/caveat/crud/(:any)', 'ResponsiveVariantRouteController::showCaseCaveatCrud/$1');
$routes->match(['GET', 'POST'], 'case/caveat/crud', 'ResponsiveVariantRouteController::showCaseCaveatCrud');
$routes->match(['GET', 'POST'], 'my/profile', 'ResponsiveVariantRouteController::showMyProfile');
$routes->match(['GET', 'POST'], 'search', 'ResponsiveVariantRouteController::showSearch');
// $routes->match(['GET', 'POST'],'support/(:any)','ResponsiveVariantRouteController::showSupport/$1');
// $routes->match(['GET', 'POST'],'support','ResponsiveVariantRouteController::showSupport');
$routes->match(['GET', 'POST'], 'clerk/crud', 'ResponsiveVariantRouteController::showClerkCrud');
$routes->match(['GET', 'POST'], 'case/interim_application/crud_registration', 'ResponsiveVariantRouteController::showCaseInterimApplicationCrudByRegistrationId');
$routes->match(['GET', 'POST'], 'utilities', 'ResponsiveVariantRouteController::showUtilities');
$routes->match(['GET', 'POST'], 'utilities/pspdfkit-playground', 'ResponsiveVariantRouteController::storePspdfkitPlaygroundUtilities');
$routes->match(['GET', 'POST'], 'Guide', 'ResponsiveVariantRouteController::showManual');
$routes->match(['GET', 'POST'], 'e-services', 'ResponsiveVariantRouteController::showMenu');
$routes->match(['GET', 'POST'], 'case/citation/(:any)', 'ResponsiveVariantRouteController::showCaseCitationListing/$1');
$routes->match(['GET', 'POST'], 'case/mentioning/(:any)', 'ResponsiveVariantRouteController::showCaseMentioningListing/$1');
$routes->match(['GET', 'POST'], 'case/certificate/(:any)', 'ResponsiveVariantRouteController::showCaseCertificateListing/$1');
$routes->match(['GET', 'POST'], 'case/advocate/(:num)', 'ResponsiveVariantRouteController::showAdvocateData/$1');
$routes->match(['GET', 'POST'], 'efiling_search', 'EfilingSearch/DefaultController/efiling_search');
$routes->match(['GET', 'POST'], 'efiling_search/identify/(:any)/(:any)/(:any)/(:any)', 'EfilingSearch/DefaultController/identify/$1/$2/$3/$4');
$routes->match(['GET', 'POST'], 'efiling_search/view/(:any)', 'EfilingSearch/DefaultController/view/$1');
// $routes->match(['GET', 'POST'], 'efiling_search/get_view_data/(:any)', 'EfilingSearch/DefaultController/get_view_data/$1');
$routes->match(['GET', 'POST'], 'efiling_search/identifyByicmis/(:any)', 'EfilingSearch/DefaultController/identifyByicmis/$1');
$routes->match(['GET', 'POST'], 'case/paper_book_viewer/(:any)', 'ResponsiveVariantRouteController::showCasePaperBookViewer/$1');
$routes->match(['GET', 'POST'], 'case/3pdf_paper_book_viewer/(:any)', 'ResponsiveVariantRouteController::showCase3PDFPaperBookViewer/$1');
$routes->match(['GET', 'POST'], 'case/ancillary/checklist', 'ResponsiveVariantRouteController::showCaseChecklist/');
// $routes->match(['GET', 'POST'], 'case/ancillary/checklist', 'supplements/DefaultController/checklist/');
$routes->match(['GET', 'POST'], 'case/ancillary/documents', 'ResponsiveVariantRouteController::auxiliary_docs');
$routes->match(['GET', 'POST'], 'case/ancillary/form', 'ResponsiveVariantRouteController::auxiliary_documents');
// $routes->match(['GET', 'POST'],'registerCounsel','register/ArguingCounsel/saveArguingCounselByAOR');
// $routes->match(['GET', 'POST'],'matchRegistrationCode', 'register/ArguingCounsel/matchRegistrationCode');
// $routes->match(['GET', 'POST'],'saveArguingCounselCompleteDetails', 'register/ArguingCounsel/saveArguingCounselCompleteDetails');
$routes->match(['GET', 'POST'], 'arguingCounselRegister', 'Register\ArguingCounselRegister::addAarguingCounsel');
$routes->match(['GET', 'POST'], 'case/arguingCounsel/(:num)', 'ResponsiveVariantRouteController::arguingCounselData/$1');
$routes->match(['GET', 'POST'], 'case/iamiscdocshare', 'ResponsiveVariantRouteController::iaMiscDocShare');
$routes->match(['GET', 'POST'], 'case/ancillary/Indexdocuments', 'ResponsiveVariantRouteController::prefilled_index_docs');
$routes->match(['GET', 'POST'], 'vakalatnama/dashboard/action(:any)', 'vakalatnama/dashboard/action/$1');

// $routes->match(['GET', 'POST'],'e-resources/(:any)','Resources\DefaultController::index/$1');
// $routes->match(['GET', 'POST'],'e-resources','Resources\DefaultController::index');

//...........12-06-2024........//
// $routes->match(['GET', 'POST'],'resources/hand_book','Resources\Hand_book::index');
// $routes->match(['GET', 'POST'],'resources/video_tutorial/view','Resources\Video_tutorial::view');
// $routes->match(['GET', 'POST'],'resources/hand_book_old_efiling','Resources\Hand_book_old_efiling::index');
// $routes->match(['GET', 'POST'],'resources/Three_PDF_user_manual','Resources\Three_PDF_user_manual::index');
// $routes->match(['GET', 'POST'],'resources/FAQ','Resources\FAQ::index');
// $routes->match(['GET', 'POST'],'e-resources','resources/DefaultController/index');
//$routes->match(['GET', 'POST'],'e-resources','Resources/DefaultController::index');
/*...........Deepak Sharma...........*/
// $routes->match(['GET', 'POST'],'case_status/defaultController/showCaseStatus','Case_details\DefaultController::showCaseStatus');
// $routes->get('case_status/defaultController/showCaseStatus', 'Case_details\DefaultController::showCaseStatus');
// $routes->match(['GET', 'POST'], 'case_status/defaultController/showCaseStatus', 'Case_details\DefaultController::showCaseStatus');
/*................End................*/

/****start-Responsive variant routes****/
/****start-Responsive variant routes Quick E-Filing****/
$routes->match(['GET', 'POST'], 'caseQF/crud/(:any)', 'newcaseQF/ResponsiveVariantRouteController::showCaseCrud/$1');
$routes->match(['GET', 'POST'], 'caseQF/crud', 'newcaseQF/ResponsiveVariantRouteController::showCaseCrud');
/****End-Responsive variant routes Quick E-Filing****/
$routes->match(['GET', 'POST'], 'superAdmin/DefaultController/registrationForm', 'SuperAdmin\DefaultController::registrationForm');
$routes->match(['GET', 'POST'], 'superAdmin/DefaultController', 'SuperAdmin\DefaultController::index');
$routes->match(['GET', 'POST'], 'superAdmin/DefaultController/getEmpDetails', 'SuperAdmin\DefaultController::getEmpDetails');
$routes->match(['GET', 'POST'], 'csrftoken', 'Csrftoken\DefaultController::index');
$routes->match(['GET', 'POST'], 'report/search', 'Report\Search::index');


/* Start Vinit Garg Routes*/
$routes->match(['GET', 'POST'], 'NewRegister/Advocate', 'NewRegister\AdvocateController::index');
$routes->match(['GET', 'POST'], 'NewRegister/Advocate/view/(:any)', 'NewRegister\AdvocateController::view/$1');
$routes->match(['GET', 'POST'], 'NewRegister/Advocate/activate/(:any)', 'NewRegister\AdvocateController::activate/$1');
$routes->match(['GET', 'POST'], 'NewRegister/Advocate/deactivate/(:any)', 'NewRegister\AdvocateController::deactivate/$1');
$routes->match(['GET', 'POST'], 'Admin/Supadmin/change_case_status', 'Admin\SupadminController::change_case_status');
// $routes->match(['GET', 'POST'], 'assistance/Notice_circulars', 'assistance\Notice_circularsController::index');
// Profile and change password
$routes->match(['GET', 'POST'], 'profile', 'Profile\DefaultController::index');
$routes->match(['GET', 'POST'], 'profile/updateProfile/(:any)', 'Profile\DefaultController::updateProfile/$1');
$routes->match(['GET', 'POST'], 'profile/updatePass', 'Profile\DefaultController::updatePass');
// $routes->match(['GET', 'POST'], 'mycases/add_case_contact', 'App\Controllers\Mycases\CitationNotes::add_case_contact');
$routes->post('mycases/delete_contacts', 'Mycases\CitationNotes::delete_contacts');
$routes->post('newcase/assignSrAdvocate', 'NewCase\Ajaxcalls::assignSrAdvocate');
$routes->post('newcase/deleteSrAdvocate', 'NewCase\Ajaxcalls::deleteSrAdvocate');
/* End Vinit Garg Routes */

/* Ashutosh Gupta Routes */
$routes->get('register', 'Register\DefaultController::index');
$routes->post('register/DefaultController/adv_get_otp', 'Register\DefaultController::adv_get_otp');
$routes->get('register/AdvocateOnRecord', 'Register\AdvocateOnRecord::index');
$routes->post('register/AdvocateOnRecord/adv_get_otp', 'Register\AdvocateOnRecord::adv_get_otp');
$routes->get('register/AdvOtp', 'Register\AdvOtp::index');
$routes->get('register/AdvOtp/verify', 'Register\AdvOtp::verify');
$routes->get('register/arguingCounsel', 'Register\ArguingCounsel::index');
$routes->post('registerCounsel', 'Register\ArguingCounsel::saveArguingCounselByAOR');
$routes->get('matchRegistrationCode', 'Register\ArguingCounsel::matchRegistrationCode');
$routes->match(['GET', 'POST'], 'saveArguingCounselCompleteDetails', 'Register\ArguingCounsel::saveArguingCounselCompleteDetails');
$routes->match(['GET', 'POST'], 'arguingCounselCompleteDetails', 'Register\ArguingCounsel::arguingCounselCompleteDetails');
$routes->post('register/ArguingCounsel/approveRejectedArguingCounsel', 'Register\ArguingCounsel::approveRejectedArguingCounsel');
$routes->post('register/arguingCounsel/landArguingCounsel/(:any)', 'Register\ArguingCounsel::landArguingCounsel/$1');
// Forgot password
$routes->match(['GET', 'POST'], 'Register/ForgetPassword', 'Register\ForgetPasswordController::index');
$routes->match(['GET', 'POST'], 'Register/ForgetPassword/adv_get_otp', 'Register\ForgetPasswordController::adv_get_otp');
$routes->match(['GET', 'POST'], 'Register/AdvOtp', 'Register\ForgetPasswordController::AdvOtp');
$routes->match(['GET', 'POST'], 'Register/verify', 'Register\ForgetPasswordController::verify');
$routes->match(['GET', 'POST'], 'Register/AdvSignUp', 'Register\ForgetPasswordController::AdvSignUp');
$routes->match(['GET', 'POST'], 'register/AdvSignUp', 'Register\ForgetPasswordController::AdvSignUp');
$routes->match(['GET', 'POST'], 'register/ForgetPassword/update_user_password', 'Register\ForgetPasswordController::update_user_password');
// $routes->get('support/(:any)', 'ResponsiveVariantRouteController::showSupport/$1');
// $routes->get('support', 'ResponsiveVariantRouteController::showSupport');
$routes->get('assistance/notice_circulars', 'Assistance\NoticeCirculars::index');
$routes->post('assistance/notice_circulars/add_notice_circurlar', 'Assistance\NoticeCirculars::add_notice_circurlar');
$routes->post('assistance/notice_circulars/add_notice_circurlar/(:any)', 'Assistance\NoticeCirculars::add_notice_circurlar/$1');
$routes->get('assistance/notice_circulars/view/(:any)', 'Assistance\NoticeCirculars::view/$1');
$routes->match(['GET', 'POST'], 'assistance/notice_circulars/edit/(:any)', 'Assistance\NoticeCirculars::edit/$1');
$routes->match(['GET', 'POST'], 'assistance/notice_circulars/action/(:any)', 'Assistance\NoticeCirculars::action/$1');
$routes->get('assistance/performas', 'Assistance\Performas::index');
$routes->post('assistance/performas/add_notice_circurlar', 'Assistance\Performas::add_notice_circurlar');
$routes->post('assistance/performas/add_notice_circurlar/(:any)', 'Assistance\Performas::add_notice_circurlar/$1');
$routes->get('assistance/performas/view/(:any)', 'Assistance\Performas::view/$1');
$routes->match(['GET', 'POST'], 'assistance/performas/edit/(:any)', 'Assistance\Performas::edit/$1');
$routes->match(['GET', 'POST'], 'assistance/performas/action/(:any)', 'Assistance\Performas::action/$1');
$routes->match(['GET', 'POST'], 'contact_us', 'Assistance\Contact_us::index');
// $routes->get('e-resources', 'Resources\DefaultController::index');
// $routes->get('e-resources/(:any)', 'Resources\DefaultController::index/$1');
$routes->get('resources/hand_book', 'Resources\HandBook::index');
$routes->get('resources/video_tutorial/view', 'Resources\VideoTutorial::view');
$routes->get('resources/FAQ', 'Resources\FAQ::index');
$routes->get('resources/hand_book_old_efiling', 'Resources\HandBookOldEfiling::index');
$routes->get('resources/Three_PDF_user_manual', 'Resources\ThreePDFUserManual::index');
// $routes->get('resources/Three_PDF_user_manual', 'Resources\ThreePDFUserManual::index');
// $routes->get('resources/Three_PDF_user_manual', 'Resources\ThreePDFUserManual::index');
$routes->match(['GET', 'POST'], 'miscellaneous_docs/defaultController/(:any)', 'MiscellaneousDocs\DefaultController::index/$1');
$routes->match(['GET', 'POST'], 'case/document/crud', 'ResponsiveVariantRouteController::showCaseDocumentCrud');
$routes->match(['GET', 'POST'], 'case/document/crud/(:any)', 'ResponsiveVariantRouteController::showCaseDocumentCrud/$1');
$routes->match(['GET', 'POST'], 'case/document/crud_registration', 'ResponsiveVariantRouteController::showCaseDocumentCrudByRegistrationId');
$routes->match(['GET', 'POST'], 'case/document/crud_registration/(:any)', 'ResponsiveVariantRouteController::showCaseDocumentCrudByRegistrationId/$1');
$routes->get('adminReport/search', 'AdminReport\Search::index');
$routes->match(['GET', 'POST'], 'adminReport/Search/get_list_doc_fromDate_toDate', 'AdminReport\Search::get_list_doc_fromDate_toDate');
$routes->match(['GET', 'POST'], 'efiling_search', 'EfilingSearch\DefaultController::efiling_search');
$routes->match(['GET', 'POST'], 'efiling_search/identify/(:any)/(:any)/(:any)/(:any)', 'EfilingSearch\DefaultController::identify/$1/$2/$3/$4');
$routes->match(['GET', 'POST'], 'efiling_search/view/(:any)', 'EfilingSearch\DefaultController::view/$1');
$routes->match(['GET', 'POST'], 'efiling_search/get_view_data/(:any)', 'EfilingSearch\DefaultController::get_view_data/$1');
$routes->match(['GET', 'POST'], 'efiling_search/identifyByicmis/(:any)', 'EfilingSearch\DefaultController::identifyByicmis/$1');
$routes->match(['GET', 'POST'], 'cronJobScrutinyStatus', 'EfilingSearch\DefaultController::cronJobForScrutinyStatus');
$routes->match(['GET', 'POST'], 'dashboard_alt/getDailyCaseCounts', 'ResponsiveVariantRouteController::getDailyCaseCounts');
$routes->match(['GET', 'POST'], 'dashboard_alt/getDayCaseDetails', 'ResponsiveVariantRouteController::getDayCaseDetails');
$routes->match(['GET', 'POST'], 'caveat/defaultController/processing/(:any)', 'Caveat\DefaultController::processing/$1');
$routes->match(['GET', 'POST'], 'caveat/view', 'Caveat\View::index');
$routes->match(['GET', 'POST'], 'caveat/extra_party', 'Caveat\Extra_party::index');
$routes->match(['GET', 'POST'], 'caveat/subordinate_court', 'Caveat\Subordinate_court::index');
$routes->match(['GET', 'POST'], 'case/search/search_old_efiling_case_details', 'Case\Search::search_old_efiling_case_details');
/****start-Responsive variant routes refile old efiling cases ****/
$routes->match(['GET', 'POST'], 'case/refile_old_efiling_cases/crud/(:any)', 'ResponsiveVariantRouteController::showOldEfilingCasesCrud/$1');
$routes->match(['GET', 'POST'], 'case/refile_old_efiling_cases/crud', 'ResponsiveVariantRouteController::showOldEfilingCasesCrud');
$routes->match(['GET', 'POST'], 'case/refile_old_efiling_cases/crud_registration/(:any)', 'ResponsiveVariantRouteController::showOldEfilingCasesCrudByRegistrationId/$1');
$routes->match(['GET', 'POST'], 'case/refile_old_efiling_cases/crud_registration', 'ResponsiveVariantRouteController::showOldEfilingCasesCrudByRegistrationId');
$routes->match(['GET', 'POST'], 'mycases/update_case_contacts', 'Mycases\CitationNotes::update_case_contacts');
$routes->match(['GET', 'POST'], 'mycases/aor_contact_list', 'Mycases\CitationNotes::aor_contact_list');
$routes->match(['GET', 'POST'], 'mycases/case_contact', 'Mycases\CitationNotes::case_contact');
$routes->match(['GET', 'POST'], 'mycases/get_contact_list', 'Mycases\CitationNotes::get_contact_list');
$routes->match(['GET', 'POST'], 'mycases/add_case_contact', 'Mycases\CitationNotes::add_case_contact');
$routes->match(['GET', 'POST'], 'mycases/citation_notes/send_sms_and_mail', 'Mycases\CitationNotes::send_sms_and_mail');
$routes->match(['GET', 'POST'], 'mycases/citation_notes/add_notes_mycases', 'Mycases\CitationNotes::add_notes_mycases');
$routes->match(['GET', 'POST'], 'mycases/citation_notes/update_notes_mycases', 'Mycases\CitationNotes::update_notes_mycases');
$routes->match(['GET', 'POST'], 'mycases/citation_notes/view_contact_list', 'Mycases\CitationNotes::view_contact_list');
$routes->match(['GET', 'POST'], 'mycases/citation_notes/add_citation_mycases', 'Mycases\CitationNotes::add_citation_mycases');
$routes->match(['GET', 'POST'], 'mycases/citation_notes/update_citation_mycases', 'Mycases\CitationNotes::update_citation_mycases');
$routes->match(['GET', 'POST'], 'mycases/citation_notes/get_citation_and_notes_list', 'Mycases\CitationNotes::get_citation_and_notes_list');
$routes->match(['GET', 'POST'], 'mycases/citation_notes/delete_citation_n_notes', 'Mycases\CitationNotes::delete_citation_n_notes');
$routes->match(['GET', 'POST'], 'mycases/citation_notes/get_recipients_mail', 'Mycases\CitationNotes::get_recipients_mail');
$routes->match(['GET', 'POST'], 'mycases/citation_notes/send_sms', 'Mycases\CitationNotes::send_sms');
$routes->match(['GET', 'POST'], 'case_status/defaultController/get_case_status_other_tab_data', 'CaseStatus\DefaultController::get_case_status_other_tab_data');
$routes->match(['GET', 'POST'], 'case_status/defaultController/showCaseStatus', 'CaseStatus\DefaultController::showCaseStatus');
$routes->match(['GET', 'POST'], 'case_status/defaultController/showCaseStatusCertificate', 'CaseStatus\DefaultController::showCaseStatusCertificate');
$routes->match(['GET', 'POST'], 'case_status/defaultController/showPaperBook', 'CaseStatus\DefaultController::showPaperBook');
$routes->match(['GET', 'POST'], 'register/ArguingCounselRegister/senOtp', 'Register\ArguingCounselRegister::senOtp');
$routes->match(['GET', 'POST'], 'captcha/index', 'Captcha\DefaultController::index');
$routes->match(['GET', 'POST'], 'captcha_refresh', 'Captcha\DefaultController::index');
$routes->match(['GET', 'POST'], 'captcha/DefaultController/get_code', 'Captcha\DefaultController::get_code');

// Physical Hearing Routes
$routes->match(['GET', 'POST'], 'physical_hearing', 'PhysicalHearing\ConsentVC::index');
$routes->match(['GET', 'POST'], 'Consent_VC', 'PhysicalHearing\ConsentVC::index');
$routes->match(['GET', 'POST'], 'Consent_VC/index/(:any)', 'PhysicalHearing\ConsentVC::index/$1');
$routes->match(['GET', 'POST'], 'consent_VC/save', 'PhysicalHearing\ConsentVC::save');
$routes->match(['GET', 'POST'], 'consent/case_listed_in_daily_status/(:any)', 'PhysicalHearing\Consent::case_listed_in_daily_status/$1');
$routes->match(['GET', 'POST'], 'physical_hearing/reports', 'PhysicalHearing\AdvocateListing::advocate_rpt_srch');
$routes->match(['GET', 'POST'], 'Advocate_listing/advocate_rpt_srch', 'PhysicalHearing\AdvocateListing::advocate_rpt_srch');

// $routes->match(['GET', 'POST'], 'auth', 'PhysicalHearing\Auth::index');

/****end-Responsive variant routes refile old efiling cases ****/


// Pushpendra
$routes->match(['GET', 'POST'], 'case/search/search_case_details', 'Case\Search::search_case_details');
$routes->match(['GET', 'POST'], 'adminReport/Reports/search', 'AdminReport\Reports::search');
$routes->match(['GET', 'POST'], 'adminReport/Reports', 'AdminReport\Reports::index');
$routes->match(['GET', 'POST'], 'admin/supadmin/search_case_status', 'Admin\SupadminController::search_case_status');
$routes->match(['GET', 'POST'], 'admin/supadmin/change_case_status_main', 'Admin\SupadminController::change_case_status_main');
$routes->match(['GET', 'POST'], 'admin/supadmin/final_case_status_change', 'Admin\SupadminController::final_case_status_change');
$routes->match(['GET', 'POST'], 'superAdmin/DefaultController/addSciUser', 'SuperAdmin\DefaultController::addSciUser');
$routes->match(['GET', 'POST'], 'adminReport/DefaultController/reportForm', 'AdminReport\DefaultController::reportForm');
$routes->match(['GET', 'POST'], 'adminReport/DefaultController/getReportData', 'AdminReport\DefaultController::getReportData');
$routes->match(['GET', 'POST'], 'adminReport/DefaultController/getFilingStageTypeData', 'AdminReport\DefaultController::getFilingStageTypeData');
$routes->match(['GET', 'POST'], 'efiling_search/DefaultController/identify/(:any)/(:any)/(:any)/(:any)', 'EfilingSearch\DefaultController::identify/$1/$2/$3/$4');
$routes->match(['GET', 'POST'], 'efiling_search/DefaultController/get_view_data/(:any)', 'EfilingSearch\DefaultController::get_view_data/$1');
$routes->match(['GET', 'POST'], 'case/search/save_searched_case_result', 'Case\Search::save_searched_case_result');
$routes->match(['GET', 'POST'], 'caveat/caveatee/add_caveatee', 'Caveat\Caveatee::add_caveatee');
$routes->match(['GET', 'POST'], 'IA/defaultController/(:any)', 'IA\DefaultController::index/$1');
$routes->match(['GET', 'POST'], 'IA/view', 'IA\View::index');
$routes->match(['GET', 'POST'], 'IA/courtFee', 'IA\CourtFee::index');
$routes->get('on_behalf_of', 'OnBehalfOf\DefaultController::index');
$routes->get('appearing_for', 'AppearingFor\DefaultController::index');
$routes->get('case_details', 'CaseDetails\DefaultController::index');
$routes->get('shareDoc', 'ShareDoc\DefaultController::index');
$routes->match(['GET', 'POST'],'on_behalf_of/DefaultController/save_filing_for', 'OnBehalfOf\DefaultController::save_filing_for');
$routes->match(['GET', 'POST'], 'report/search', 'Report\Search::index');
$routes->match(['GET', 'POST'], 'report/search/actionFiledon', 'Report\Search::actionFiledon');
$routes->match(['GET', 'POST'], 'report/search/Get_search_case_details_rpt', 'Report\Search::Get_search_case_details_rpt');
$routes->match(['GET', 'POST'], 'report/search/view/(:any)/(:any)/(:any)/(:any)/(:any)', 'Report\Search::view/$1/$2/$3/$4/$5');
$routes->match(['GET', 'POST'], 'report/search/view/(:any)/(:any)/(:any)/(:any)', 'Report\Search::view/$1/$2/$3/$4');
$routes->match(['GET', 'POST'], 'case/search/(:any)', 'Case\Search::index');
$routes->match(['GET', 'POST'], 'miscellaneous_docs/view', 'MiscellaneousDocs\View::index');
$routes->match(['GET', 'POST'], 'miscellaneous_docs/courtFee', 'MiscellaneousDocs\CourtFee::index');
$routes->match(['GET', 'POST'], 'miscellaneous_docs/courtFee/add_court_fee_details', 'MiscellaneousDocs\CourtFee::add_court_fee_details');
$routes->match(['GET', 'POST'], 'caveat/caveatee', 'Caveat\Caveatee::index');
$routes->match(['GET', 'POST'], 'efilingAction/Caveat_final_submit', 'EfilingAction\CaveatFinalSubmit::index');
$routes->match(['GET', 'POST'], 'newcase/Ajaxcalls_subordinate_court/get_icmis_district_list', 'NewCase\AjaxcallsSubordinateCourt::get_icmis_district_list');
$routes->match(['GET', 'POST'], 'newcase/Ajaxcalls_subordinate_court/get_police_station_list', 'NewCase\AjaxcallsSubordinateCourt::get_police_station_list');
$routes->match(['GET', 'POST'], 'redirect_on_login', 'DefaultController::redirect_on_login');

$routes->match(['GET', 'POST'], 'appearing_for/appearing_for/save_appearing_details', 'AppearingFor\Appearing_for::save_appearing_details');
$routes->match(['GET', 'POST'], 'miscellaneous_docs/FinalSubmit', 'MiscellaneousDocs\FinalSubmit::index');
$routes->match(['GET', 'POST'], '/IA/FinalSubmit', 'IA\FinalSubmit::index');
$routes->match(['GET', 'POST'], 'documentIndex/Ajaxcalls/delete_index', 'DocumentIndex\Ajaxcalls::delete_index');
$routes->match(['GET', 'POST'], 'documentIndex/Ajaxcalls/markCuredDefect', 'DocumentIndex\Ajaxcalls::markCuredDefect');
$routes->match(['GET', 'POST'], 'oldCaseRefiling/defaultController/(:any)', 'OldCaseRefiling\DefaultController::index/$1');
$routes->match(['GET', 'POST'], 'oldCaseRefiling/courtFee', 'OldCaseRefiling\CourtFee::index');
$routes->match(['GET', 'POST'], 'oldCaseRefiling/view', 'OldCaseRefiling\View::index');

$routes->match(['GET', 'POST'], 'oldCaseRefiling/FinalSubmit', 'OldCaseRefiling\FinalSubmit::index');
$routes->match(['GET', 'POST'], 'userActions/trash', 'UserActions\Trash::index');
$routes->match(['GET', 'POST'], 'admin/efilingAction', 'Admin\EfilingAction::index');
$routes->match(['GET', 'POST'], 'admin/efilingAction/hold', 'Admin\EfilingAction::hold');
$routes->match(['GET', 'POST'], 'admin/EfilingAction/disapprove_case', 'Admin\EfilingAction::disapprove_case');

$routes->match(['GET', 'POST'], 'shcilPayment/ViewPaymentChallan/(:any)', 'ShcilPayment\ViewPaymentChallan::index/$1');
$routes->match(['GET', 'POST'], 'shcilPayment/paymentCheckStatus', 'ShcilPayment\PaymentCheckStatus::index');
// $routes->match(['GET', 'POST'], 'report/search/view/miscellaneous_docs/defaultController/(:any)/(:any)/(:any)', 'MiscellaneousDocs\DefaultController::view/$1/$1/$1');







// Appearance Routes  
$routes->match(['GET', 'POST'], 'advocate/listed_cases', 'Advocate\AdvocateController::listed_cases');
$routes->match(['GET', 'POST'], 'advocate/modal_appearance', 'Advocate\AdvocateController::modal_appearance');
$routes->match(['GET', 'POST'], 'advocate/modal_appearance_save', 'Advocate\AdvocateController::modal_appearance_save');
$routes->match(['GET', 'POST'], 'advocate/confirm_final_submit', 'Advocate\AdvocateController::confirm_final_submit');
$routes->match(['GET', 'POST'], 'advocate/add_from_case_advocate_master_list', 'Advocate\AdvocateController::add_from_case_advocate_master_list');
$routes->match(['GET', 'POST'], 'advocate/master_list_submit', 'Advocate\AdvocateController::master_list_submit');
$routes->match(['GET', 'POST'], 'advocate/remove_advocate', 'Advocate\AdvocateController::remove_advocate');
$routes->match(['GET', 'POST'], 'advocate/display_appearance_slip', 'Advocate\AdvocateController::display_appearance_slip');
$routes->match(['GET', 'POST'], 'advocate', 'Advocate\AdvocateController::index');
$routes->get('advocate/report', 'Advocate\AdvocateController::reportIndex');
$routes->post('advocate/report', 'Advocate\AdvocateController::appearingReport');

// cron routes
$routes->match(['GET', 'POST'], 'cron/bar/', 'Cron\Bar::index');  
$routes->match(['GET', 'POST'], 'cron/scrutiny_status', 'Cron\DefaultController::index'); 
$routes->match(['GET', 'POST'], 'cron/fee_lock', 'Cron\FeelockController::index'); //  -- In progress 
$routes->match(['GET', 'POST'], 'cron/replication_check', 'Cron\ReplicationCheck::index');// -- In progress 
$routes->match(['GET', 'POST'], 'cron/stage_check', 'Cron\StageController::index');

// online copying
$routes->match(['GET', 'POST'], 'online_copying/copy_search', 'OnlineCopying\DefaultController::copySearch');
$routes->match(['GET', 'POST'], 'online_copying/get_copy_search', 'OnlineCopying\DefaultController::getCopySearch');
$routes->match(['GET', 'POST'], 'online_copying/track_consignment', 'OnlineCopying\DefaultController::trackConsignment');
$routes->match(['GET', 'POST'], 'online_copying/get_consignment_status', 'OnlineCopying\DefaultController::getConsignmentStatus');
$routes->match(['GET', 'POST'], 'online_copying/faq', 'OnlineCopying\DefaultController::faq');
$routes->match(['GET', 'POST'], 'online_copying/screen_reader', 'OnlineCopying\DefaultController::screenReader');
$routes->match(['GET', 'POST'], 'online_copying/contact_us', 'OnlineCopying\DefaultController::contactUs');
$routes->match(['GET', 'POST'], 'online_copying/case_search', 'OnlineCopying\DefaultController::caseSearch');
$routes->match(['GET', 'POST'], 'online_copying/get_case_details', 'OnlineCopying\DefaultController::getCaseDetails');
$routes->match(['GET', 'POST'], 'online_copying/applicant_address', 'OnlineCopying\AddressController::applicantAddress');
$routes->match(['GET', 'POST'], 'online_copying/get_app_charge', 'OnlineCopying\DefaultController::getAppCharge');
$routes->match(['GET', 'POST'], 'online_copying/get_tot_copy', 'OnlineCopying\DefaultController::getTotCopy');
$routes->match(['GET', 'POST'], 'online_copying/get_pincode_details', 'OnlineCopying\AddressController::getPincodeDetails');
$routes->match(['GET', 'POST'], 'online_copying/user_address_save', 'OnlineCopying\AddressController::saveApplicantAddress');
$routes->match(['GET', 'POST'], 'online_copying/user_address_remove', 'OnlineCopying\AddressController::RemoveApplicantAddress');
$routes->match(['GET', 'POST'], 'online_copying/unavailable_request', 'OnlineCopying\DefaultController::unavailableRequest');
$routes->match(['GET', 'POST'], 'online_copying/requested_documents_save', 'OnlineCopying\DefaultController::requestedDocumentsSave');
$routes->match(['GET', 'POST'], 'online_copying/case_relation_verification', 'OnlineCopying\DefaultController::caseRelationVerification');
$routes->match(['GET', 'POST'], 'online_copying/user_address_edit', 'OnlineCopying\AddressController::editApplicantAddress');
$routes->match(['GET', 'POST'], 'online_copying/user_address_update', 'OnlineCopying\AddressController::updateApplicantAddress');
$routes->match(['GET', 'POST'], 'online_copying/sci_request', 'OnlineCopying\DefaultController::sciRequest');
$routes->match(['GET', 'POST'], 'online_copying/sci_request_payment', 'OnlineCopying\DefaultController::sciRequestPayment');
$routes->match(['GET', 'POST'], 'register/AdvSignUp/get_dist_list', 'Register\AdvSignUp::get_dist_list');
$routes->match(['GET', 'POST'], 'register/AdvSignUp/upload_photo', 'Register\AdvSignUp::upload_photo');
$routes->match(['GET', 'POST'], 'register/AdvSignUp/add_advocate', 'Register\AdvSignUp::add_advocate');
$routes->match(['GET', 'POST'], 'register/AdvSignUp/upload', 'Register\AdvSignUp::upload');
$routes->match(['GET', 'POST'], 'register/AdvSignUp/upload_id_proof', 'Register\AdvSignUp::upload_id_proof');
$routes->match(['GET', 'POST'], 'register/AdvSignUp/final_submit', 'Register\AdvSignUp::final_submit');

