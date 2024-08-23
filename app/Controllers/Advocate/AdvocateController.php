<?php

namespace App\Controllers\Advocate;
use App\Controllers\BaseController;
use CodeIgniter\Database\Query;
use App\Models\Advocate\AdvocateModel;
use Config\Database;
// use App\Models\AdminDashboard\AdminDashboardModel;

class AdvocateController extends BaseController
{
    // protected $AdminReportModel;
    protected $AdvocateModel;
    protected $db;
    protected $session;
    protected $request;

    public function __construct()
    {
        parent::__construct();
        $this->AdvocateModel = new AdvocateModel();            
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();


    }
    public function index()
    {
        // $model = new AdvocateModel();
        // pr($model);
    }
    public function listed_cases() {
        $pager = \Config\Services::pager();
        $aor_code='';
        if(!empty(getSessionData('login')['aor_code'])){
            $aor_code=getSessionData('login')['aor_code'];
            $list= $this->AdvocateModel->getListedCases($aor_code);
            $data['heading'] = 'CAUSE LIST';
            return $this->render('advocate.listed_cases', @compact('data','list'));
        }
        else{
            redirect('login');
            exit(0);
        }
    }

    public function modal_appearance()
    {
        $postedData = $this->request->getPost();
        //  pr($postedData);
        $data['added_data'] = $this->AdvocateModel->getAddedAdvocatesInDiary($postedData);
        $data['is_submitted'] = $this->AdvocateModel->getSubmittedAdvocatesInDiary($postedData);

        // pr($data['added_data']);
        return $this->render('advocate.modal_appearance', @compact('data'));        
    }

    public function display_appearance_slip() 
    {
        $postedData = $this->request->getPost();
     
        $data['slip_data'] = Advocate::getSubmittedAdvocatesInDiary($postedData);
        return $this->render('advocate.display_appearance_slip', @compact('data'));        

    }


    // public function modal_appearance_save()
    // {
    //      $timout_validation = $this->timeout_validation($this->request->getPost('next_dt'));  //  
    //         if($timout_validation){
    //             return response()->json(array('status' => 'timeout'));
    //             exit;
    //         }
    //     $validator = Validator::make($request->except(['advocate_title.None']), [
    //         'advocate_type' =>  ['required', Rule::in(['Adv.', 'Sr. Adv.', 'AOR', 'Attorney General for India', 'Solicitor General', 'A.S.G.', 'Sr. A.A.G.', 'A.A.G.', 'D.A.G.', 'Amicus Curiae']) ],
    //         'advocate_title' => ['required', Rule::in(['Mr.', 'Mrs.', 'Ms.', 'M/s', 'Dr.', 'None']) ],
    //         'advocate_name' => 'required|string|max:100|min:3',
    //     ]);
    //     if ($validator->passes())
    //     {
    //         $data['diary_no'] = $this->request->getPost('diary_no');
    //         $data['list_date'] = $this->request->getPost('next_dt');
    //         $data['appearing_for'] = $this->request->getPost('appearing_for');
    //         $data['item_no'] = $this->request->getPost('brd_slno');
    //         $data['court_no'] = $this->request->getPost('courtno');
    //         $data['advocate_type'] = $this->request->getPost('advocate_type');
    //         $data['advocate_title'] = $this->request->getPost('advocate_title') == 'None' ? '' : $this->request->getPost('advocate_title');
    //         $data['advocate_name'] = trim($this->request->getPost('advocate_name'));
    //         $data['aor_code'] = session('aor_code');

    //         if(Session::has('diary_no')){
    //             if(session('diary_no') == $this->request->getPost('diary_no')){
    //                 $request->session()->put('appear_priority', session('appear_priority') + 1);
    //             }
    //             else{
    //                 $request->session()->put('diary_no', $this->request->getPost('diary_no'));
    //                 $request->session()->put('appear_priority', 1);
    //             }
    //         }
    //         else{
    //             $request->session()->put('diary_no', $this->request->getPost('diary_no'));
    //             $request->session()->put('appear_priority', 1);
    //         }
    //         $data['priority'] = session('appear_priority');
    //         $value = DB::connection('eservices')->table('appearing_in_diary')->insertGetId($data);
    //         if($value){
    //             $data['entry_time'] = date('d-m-Y h:i:s A');
    //             $data['id'] = $value;
    //             return response()->json(array('status' => 'success','data' => $data));
    //         }
    //         else{
    //             return response()->json(array('status' => 'error','data' => $value));
    //         }
    //         //return response()->json(['success'=>'Added new records.']);
    //     }
    //     return response()->json(array('status' => 'error','data' => $validator->errors()->all())) ;

    // }

    // public function reportIndex() 
    // {
    //     $data['heading'] = "Advocates Appearing";
    //     return $this->render('advocate.report', @compact('data'));        

    // }

    // public function appearingReport() {
    //     $heading = "Advocates Appearing";
    //     // Commented by VEL/N/1023/2573

    //     // $request->validate(
    //     //     [
    //     //         'cause_list_date' => 'date|date_format:d-m-Y'
    //     //     ], [
    //     //     'required_if' => 'The :attribute field is required.'
    //     // ], [

    //     //         'cause_list_date' => 'Cause List Date'

    //     //     ]
    //     // );

    //     $cause_list_date = date('Y-m-d', strtotime($this->request->getPost('cause_list_date')));

    //     $cause_list_array = array();
    //     //$cause_list_array = new stdClass;
    //     $cause_list = Advocate::getAppearingDiaryNosOnly($cause_list_date);
    //     //var_dump($cause_list);
    //     foreach($cause_list as $key => $cl){
    //         $cause_list_array[$key]['diary_no'] = $cl->diary_no;
    //         $cause_list_array[$key]['list_date'] = $cl->list_date;
    //         $cause_list_array[$key]['court_no'] = $cl->court_no;
    //         $cause_list_array[$key]['item_no'] = $cl->item_no;
    //         $cause_list_array[$key]['appearing_for'] = $cl->appearing_for;

    //         $cause_list_array[$key]['diary_details'] = Advocate::getDiaryDetails($cl->diary_no);
    //         $cause_list_array[$key]['advocate_name'] = Advocate::getAppearingAdvocates($cl);
    //     }
    //     $cause_list_date = $this->request->getPost('cause_list_date');
    //     $list = $cause_list_array;
    //     return $this->render('advocate.report', @compact('heading','cause_list_date','list'));   

    // }



//     public function confirm_final_submit() {
//         $box = $this->request->getPost();
//         // $box = $request->all();
//         //	echo "<pre>"; print_r($box); die;
//             $timout_validation = $this->timeout_validation($box['next_dt']);
//             if ($timout_validation) {
//                 return response()->json(array('status' => 'timeout'));
//                 exit;
//             }

//             $myValue = array();
//             parse_str($box['array_id'], $myValue);
//             $total_updated = 0;
//             foreach ($myValue['sortable_id'] as $key => $value) {
//                 $update['priority'] = $key;
//                 $update['is_submitted'] = 1;
//                 $result = DB::connection('eservices')->table('appearing_in_diary')
//                     ->where('id', $value)->where('is_active', 1)
//                     ->update($update);
//                 unset($update);
//                 if ($result) {
//                     $total_updated += 1;
//                 }
//             }

//             if ($total_updated > 0) {
//                 if(session('mobile')){
//                 $case_no_exploded_in = explode("IN", strtoupper($box['case_no']));
//                     $sms_data['sms_content'] = "The appearance slip for case no. ".$case_no_exploded_in[0]." submitted by you on ".date('d-m-Y')." time ".date('h:i:s a')." is forwarded to court master of court room no. ".$box['courtno'].". -Supreme Court of India.";
//                     $sms_data['mobile_no'] = session('mobile');
//                     $sms_data['template_id'] = config("constants.SMS_TEMPLATE_APPEARANCE_SLIP_SUBMITTED");
//                     //var_dump($sms_data);
// 			$newUserAuth = new UserAuth();
// 			$newUserAuth->sendSMS($sms_data);
// //                    UserAuth::sendSMS($sms_data);    
//                 }
//                 return response()->json(array('status' => 'success',  'case_no' => $box['case_no'],  'cause_title' => $box['cause_title'], 'diary_no' => $box['diary_no'], 'next_dt' => $box['next_dt'], 'appearing_for' => $box['appearing_for'], 'brd_slno' => $box['brd_slno'], 'courtno' => $box['courtno']));
//             } else {
//                 return response()->json(array('status' => 'error'));
//             }
//     }

//     public function add_from_case_advocate_master_list(Request $request) {
//         $data = $request->all();
//         $previous_list_date = Advocate::getPreviousListingDate($data);
//         if($previous_list_date){
//             $previous_list_advocates = Advocate::getPreviousListAdvocates($data, $previous_list_date);
//         }
//         else{
//             $previous_list_advocates = "";
//         }
//         return $this->render('advocate.master_advocates_page', @compact('data','previous_list_advocates'));
//     }

//     public function master_list_submit(Request $request) {
//         $timout_validation = $this->timeout_validation($this->request->getPost('next_dt'));
//         if($timout_validation){
//             return response()->json( 'timeout');
//             exit;
//         }
//   //      $request->session()->regenerate();
//         $data = $this->request->getPost('array');
//         $a = Advocate::getAdvocateMasterList($data);
//         $display = array();
//         foreach($a as $a_value){
//             $insert['diary_no'] = $this->request->getPost('diary_no');
//             $insert['list_date'] = $this->request->getPost('next_dt');
//             $insert['appearing_for'] = $this->request->getPost('appearing_for');
//             $insert['item_no'] = $this->request->getPost('brd_slno');
//             $insert['court_no'] = $this->request->getPost('courtno');
//             $insert['advocate_type'] = $a_value->advocate_type;
//             $insert['advocate_title'] = $a_value->advocate_title;
//             $insert['advocate_name'] = $a_value->advocate_name;
//             $insert['aor_code'] = session('aor_code');

//             if(Session::has('diary_no')){
//                 if(session('diary_no') == $this->request->getPost('diary_no')){
//                     $request->session()->put('appear_priority', session('appear_priority') + 1);
//                 }
//                 else{
//                     $request->session()->put('diary_no', $this->request->getPost('diary_no'));
//                     $request->session()->put('appear_priority', 1);
//                 }
//             }
//             else{
//                 $request->session()->put('diary_no', $this->request->getPost('diary_no'));
//                 $request->session()->put('appear_priority', 1);
//             }
//             $insert['priority'] = session('appear_priority');
//             $value = DB::connection('eservices')->table('appearing_in_diary')->insertGetId($insert);
//             /*$display['id'] = $value;
//             $display['advocate_type'] = $a_value->advocate_type;
//             $display['advocate_title'] = $a_value->advocate_title;
//             $display['advocate_name'] = $a_value->advocate_name;*/

//             array_push($display, array('id' =>$value,
//                 'next_dt' => $this->request->getPost('next_dt'),
//                 'advocate_type' => $a_value->advocate_type,
//                 'advocate_title' => $a_value->advocate_title,
//                 'advocate_name' => $a_value->advocate_name,
//                 'entry_time' => date('d-m-Y h:i:s A') ));


//             unset($insert);
//         }

//         return response()->json($display);

//     }



//     public function remove_advocate(Request $request) {
//         $timout_validation = $this->timeout_validation($this->request->getPost('next_dt'));
//         if($timout_validation){
//             return response()->json(array('status' => 'timeout'));
//             exit;
//         }
//      /*   if($this->request->getPost('is_active') == 1){*/
//             $data['is_active'] = 0;
//             $fas = "fa-trash-restore";
//             $btn_color = "btn-warning";
//             $msg = "Removed Successfully.";
//         /*}*/
//    /*     else{
//             $data['is_active'] = 1;
//             $fas = "fa-trash";
//             $btn_color = "btn-danger";
//             $msg = "Restored Successfully.";
//         }*/
//         $value = DB::connection('eservices')->table('appearing_in_diary')
//             ->where('id', $this->request->getPost('id'))->update($data);

//         if($value){
//             return response()->json(array('status' => 'success', 'next_dt' => $this->request->getPost('next_dt'),'id' => $this->request->getPost('id'),'is_active' => $data['is_active'],'fas' => $fas,'btn_color' => $btn_color,'msg' => $msg));
//         }
//         else{
//             return response()->json(array('status' => 'error', 'next_dt' => $this->request->getPost('next_dt'), 'id' => $this->request->getPost('id'),'is_active' => $data['is_active'],'fas' => $fas,'btn_color' => $btn_color));
//         }
//     }


//     public function timeout_validation($list_date) {
//         //echo config("constants.CURRENT_DATE");
//         if($list_date == config("constants.CURRENT_DATE") && date('H:i:s') > config("constants.APPEARANCE_ALLOW_TIME")){
//             return true;
//         }
//         else{
//             return false;
//         }
//     }
  












  

   
 
}