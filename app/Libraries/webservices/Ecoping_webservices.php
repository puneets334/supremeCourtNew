<?php
namespace App\Libraries\webservices;

class Ecoping_webservices {

    public function webservice($est_code = '') {
        $web_response = curl_get_contents(WEB_SERVICE_BASE_URL . $est_code);
        $xml = simplexml_load_string($web_response);
        if ($xml === false) {
            return FALSE;
        } else {
            return $xml;
        }
    }

/* Prisoner Module */



   
    public function geteCopySearch($flag,$crn,$application_type,$application_no,$application_year)
    {
        //http://10.25.78.48:81/online_copying/get_copy_search?flag=ano&crn=&application_type=3&application_no=6544574&application_year=2021&_=1737095982794
        //echo ICMIS_SERVICE_URL."/online_copying/get_copy_search/?flag=$flag&crn=$crn&application_type=$application_type&application_no=$application_no&application_year=$application_year";
        /*$ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,ICMIS_SERVICE_URL."/online_copying/get_copy_search/?flag=$flag&crn=$crn&application_type=$application_type&application_no=$application_no&application_year=$application_year");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        $response=curl_exec($ch);
        echo $response;
        die;*/
        //return json_decode($response);
        //curl_setopt($ch,)
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/get_copy_search/?flag=$flag&crn=$crn&application_type=$application_type&application_no=$application_no&application_year=$application_year");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }
    }
    public function getCopySearchResult($postdata){
        
        $postdata = http_build_query(
            $postdata
        );
        
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context  = stream_context_create($opts);
        $url = ICMIS_SERVICE_URL;
        $result = file_get_contents($url.'/online_copying/getCopySearchResult/', false, $context);

        return json_decode($result,true);
    }
  public function getCopyStatusResult($postdata,$asset_type_flag){
    $postdata['asset_type_flag']=$asset_type_flag;
    $postdata = http_build_query(
        $postdata
    );
    
    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-Type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );
    $context  = stream_context_create($opts);
    $url = ICMIS_SERVICE_URL;
    $result = file_get_contents($url.'/online_copying/getCopyStatusResult/',false,$context);
    return json_decode($result,true);
  }
  public function getCopyBarcode($id){
    
    $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/getCopyBarcode/?id=$id");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }
  }
  public function getCopyApplication($id){
    $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/getCopyApplication/?id=$id");
        
    if ($data != false) {
        
        return json_decode($data,true);
    } else {
        return NULL;
    }
  }
  public function copyFormSentOn($id){
    $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/copyFormSentOn/?id=$id");
        
    if ($data != false) {
        
        return json_decode($data,true);
    } else {
        return NULL;
    }
  } 
  public function getCopyRequest($id){
    $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/getCopyRequest/?id=$id");
        
    if ($data != false) {
        
        return json_decode($data,true);
    } else {
        return NULL;
    }
  }
  public  function eCopyingGetDiaryNo($ct, $cn, $cy){
    $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/eCopyingGetDiaryNo/?ct=$ct&cn=$cn&cy=$cy");
        
    if ($data != false) {
        
        return json_decode($data,true);
    } else {
        return NULL;
    }
  }   
  public function eCopyingCheckDiaryNo($ct, $cn, $cy){
    
    
    $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/eCopyingCheckDiaryNo/?ct=$ct&cn=$cn&cy=$cy");
        
    if ($data != false) {
        
        return json_decode($data,true);
    } else {
        return NULL;
    }
  }
    public function eCopyingGetFileDetails($diary_no){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/eCopyingGetFileDetails/?diary_no=$diary_no");
        
        if ($data != false) {
            
            return json_decode($data);
        } else {
            return NULL;
        }   
    }
    public function getStatementVideo($mobile, $email){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/getStatementVideo/?email=$email&mobile=$mobile");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }
    public function getStatementImage($mobile, $email){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/getStatementImage/?email=$email&mobile=$mobile");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }
    public function getStatementIdProof($mobile, $email){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/getStatementIdProof/?email=$email&mobile=$mobile");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }
    public function eCopyingStatementCheck($mobile, $email){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/getStatementIdProof/?email=$email&mobile=$mobile");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }
    public function eCopyingCheckMaxDigitalRequest($mobile, $email){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/getStatementIdProof/?email=$email&mobile=$mobile");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }
    public function eCopyingCopyStatus($diary_no, $check_asset_type, $mobile, $email){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/getStatementIdProof/?diary_no=$diary_no&check_asset_type=$check_asset_type&mobile=$mobile&email=$email");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }
    public function eCopyingGetBar($diary_no,$mobile){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/eCopyingGetBar/?diary_no=$diary_no&mobile=$mobile");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }
    public function getBailApplied($diary_no, $mobile, $email){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/getBailApplied/?diary_no=$diary_no&mobile=$mobile&email=$email");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }
    public function eCopyingGetCopyDetails($condition, $third_party_sub_qry, $OLD_ROP){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/eCopyingGetCopyDetails/?condition=$condition&third_party_sub_qry=$third_party_sub_qry&OLD_ROP=$OLD_ROP");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }
    public function eCopyingGetGroupConcat($main_case){
        
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/eCopyingGetGroupConcat/?main_case=$main_case");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }
    public function getIsPreviuslyApplied($copy_category, $diary_no, $mobile, $email, $order_type, $order_date){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/getIsPreviuslyApplied/?copy_category=$copy_category&diary_no=$diary_no&mobile=$mobile&email=$email&order_type=$order_type&order_date=$order_date");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }
    public function speedPostTariffCalcOffline($weight,$desitnation_pincode){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/speedPostTariffCalcOffline/?weight=$weight&desitnation_pincode=$desitnation_pincode");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }
    public function eCopyingAvailableAllowedRequests($mobile,$email){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/eCopyingAvailableAllowedRequests/?mobile=$mobile&email=$email");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }
    public function eCopyingGetDocumentType($third_party_sub_qry){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/eCopyingGetDocumentType/?third_party_sub_qry=$third_party_sub_qry");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }
    public function eCopyingGetCasetoryById($id){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/eCopyingGetCasetoryById/?id=$id");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }
    public function insert_user_assets($data){
        $postdata = http_build_query(
            $data
        );
        
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context  = stream_context_create($opts);
        $url = ICMIS_SERVICE_URL;
        $result = file_get_contents($url.'/online_copying/add_user_assets/', false, $context);
        return json_decode($result,true);
    }
    public function is_certified_copy_details($ref_tbl_lower_court_details_id,$registration_id){
        
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/is_certified_copy_details/?ref_tbl_lower_court_details_id=$ref_tbl_lower_court_details_id&registration_id=$registration_id");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }    
    }
    public function getAordetailsByAORCODE($aor_code){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/getAordetailsByAORCODE/?aor_code=$aor_code");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }
    /*public function is_AORGovernment(){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/is_AORGovernment/?ct=$ct&cn=$cn&cy=$cy");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }
    public function is_clerk_aor(){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/is_clerk_aor/?ct=$ct&cn=$cn&cy=$cy");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }
    public function getAordetails_ifFiledByClerk(){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/getAordetails_ifFiledByClerk/?ct=$ct&cn=$cn&cy=$cy");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }   
    }*/
    public function articleTrackingOffline($articlenumber){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/articleTrackingOffline/?articlenumber=$articlenumber");
        
        if ($data != false) {
            
            return json_decode($data,true);
        } else {
            return NULL;
        }      
    }
    public function getCaseType()
    {
        http://10.25.78.48:81/online_copying/get_copy_search?flag=ano&crn=&application_type=3&application_no=6544574&application_year=2021&_=1737095982794

        $data = curl_get_contents(ICMIS_SERVICE_URL."/online_copying/get_case_type");
        if ($data != false) {
            return json_decode($data);
        } else {
            return NULL;
        }
    }
    public function getCategory(){
        
        $data = curl_get_contents(ICMIS_SERVICE_URL."/online_copying/get_category");
        
        
        if ($data != false) {
           
            return json_decode($data,true);
        } else {
            return NULL;
        }
    }
    public function insert_copying_application_online($postdata){
        $postdata = http_build_query(
            $postdata
        );
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context  = stream_context_create($opts);
        $url = ICMIS_SERVICE_URL;
        $result = file_get_contents($url.'/api/online_copying/save_coping_online/', false, $context);

        return json_decode($result,true);     
        
    }
    
    public function copyFaq(){
        
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/copy_faq/");
        if ($data != false) {
            return json_decode($data);
        } else {
            return NULL;
        }
    }
    public function getCatogoryForApplication($idd){
        
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/get_catogory_for_application/?idd=$idd");
        
        if ($data != false) {
            return json_decode($data);
        } else {
            return NULL;
        }   
    }
    public function insert_copying_application_documents_online($postdata){
        $postdata = http_build_query(
            array(
                'details' =>$postdata)
        );
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context  = stream_context_create($opts);
        $url = ICMIS_SERVICE_URL;
        $result = file_get_contents($url.'/online_copying/save_copying_application_documents_online', false, $context);

        return json_decode($result,true);
    }
    public function getCopyingRequestVerify($diary_no,$applicant_mobile){
        $data = curl_get_contents(ICMIS_SERVICE_URL."/online_copying/get_catogory_for_application/?diary_no=$diary_no&applicant_mobile=$applicant_mobile");
        if ($data != false) {
            return json_decode($data);
        } else {
            return NULL;
        }   
    }
    public function createCRN($service_user_id){
        $data = curl_get_contents(ICMIS_SERVICE_URL."/online_copying/createCRN/?service_user_id=$service_user_id");
        if ($data != false) {
            return json_decode($data);
        } else {
            return NULL;
        }   
    }
    public function saveSMSData($dataArr){
        $postdata = http_build_query(
            $dataArr
        );
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context  = stream_context_create($opts);
        $url = ICMIS_SERVICE_URL;
        $result = file_get_contents($url.'/api/online_copying/saveSMSData/', false, $context);
        //$data = curl_get_contents(ICMIS_SERVICE_URL."/online_copying/saveSMSData/");
        if ($result != false) {
            return json_decode($result);
        } else {
            return NULL;
        }   
    }
    public function getUserAddress($mobile_no,$email){
        //echo ICMIS_SERVICE_URL."/online_copying/getUserAddress/?mobile=$mobile_no&emailid=$email";
        //die;
        //exit;
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/getUserAddress/?mobile=$mobile_no&emailid=$email");
        if ($data != false) {
            return json_decode($data,true);
        } else {
            return NULL;
        }  
    }
    public function verifyAadhar($mobile_no,$email){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/verifyAadhar/?mobile=$mobile_no&emailid=$email");
        if ($data != false) {
            return json_decode($data);
        } else {
            return NULL;
        }  
    }
    public function getListedCases($mobile_no,$email){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/getListedCases/?mobile=$mobile_no&emailid=$email");
        if ($data != false) {
            return json_decode($data);
        } else {
            return NULL;
        }  
    }
    public function saveUserAddress($dataArr){
        $postdata = http_build_query(
            $dataArr
        );
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context  = stream_context_create($opts);
        $url = ICMIS_SERVICE_URL;
        $result = file_get_contents($url.'/online_copying/saveUserAddress/',true, $context);
        
        //$data = curl_get_contents(ICMIS_SERVICE_URL."/online_copying/saveSMSData/");
        
        
        if ($result != false) {
        return json_decode($result,true);
            
        } else {
            return NULL;
        }
             
    }
    
    public function getPincode($pincode){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/getPincode/?pincode=$pincode");
        
        if ($data != false) {
            return json_decode($data);
        } else {
            return NULL;
        }     
    }
    public function RemoveApplicantAddress($addressID, $clientIP){
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/RemoveApplicantAddress/?id=$addressID&deletedIP=$clientIP");
        
        if ($data != false) {
            return json_decode($data);
        } else {
            return NULL;
        }  
    }
    public function eCopyingOtpVerification($email){
         
        $data = file_get_contents(ICMIS_SERVICE_URL."/online_copying/eCopyingOtpVerification/?emailid=$email");
        
        if ($data != false) {
            return json_decode($data);
        } else {
            return NULL;
        }  
    }
    public function eCopyingGetBarDetails($bar_id){
        $data = curl_get_contents(ICMIS_SERVICE_URL."/online_copying/eCopyingGetBarDetails/?bar_id=$bar_id");
        if ($data != false) {
            return json_decode($data);
        } else {
            return NULL;
        }  
    }
}