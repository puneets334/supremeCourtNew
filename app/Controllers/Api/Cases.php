<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Api\ModelApi;

class Cases extends BaseController {

    protected $Model_api;
    protected $request;

    public function __construct() {
        parent:: __construct();
        $this->Model_api = new ModelApi();
        $this->request = \Config\Services::request();
    }

    public function get_list_doc_cases_efiled() {
        // $output = array(); $params['diary_no'] = ''; $params['efiling_no'] = '';
        // $output = array();
        // if((empty($this->request->getGet('diary_no')) && !empty($this->request->getGet('efiling_no')))) {
        //     $params['diary_no'] = $this->request->getGet('diary_no');
        //     $params['efiling_no'] = $this->request->getGet('efiling_no');
        // } else if((!empty($this->request->getGet('diary_no')) && empty($this->request->getGet('efiling_no')))) {
        //     $params['diary_no'] = $this->request->getGet('diary_no');
        //     $params['efiling_no'] = $this->request->getGet('efiling_no');
        // } else if((!empty($this->request->getGet('diary_no')) && !empty($this->request->getGet('efiling_no')))) {
        //     $params['diary_no'] = $this->request->getGet('diary_no');
        //     $params['efiling_no'] = $this->request->getGet('efiling_no');
        // } else{
        //     $output['msg'] = 'Please diary no. or efiling no. one field is required.';
        //     $output['status'] = 'error';
        //     echo "<pre>"; echo json_encode($output, JSON_PRETTY_PRINT); echo "</pre>"; exit();
        // }
        // $params['ref_m_efiled_type_id']=E_FILING_TYPE_NEW_CASE;
        // $output =   $this->Model_api->get_list_doc_cases_efiled($params);
        // if(!empty($output)) {
        //     echo "<pre>"; echo json_encode($output, JSON_PRETTY_PRINT); echo "</pre>"; exit();
        // } else{
        //     $output['status'] = 'Data not found';
        //     echo "<pre>"; echo json_encode($output, JSON_PRETTY_PRINT); echo "</pre>"; exit();
        // }
        $params['diary_no'] = '';
        $params['efiling_no'] = '';
        $output = array();
        if(!empty($this->request->getGet('diary_no'))) {
            $params['diary_no'] = $this->request->getGet('diary_no');
        }
        if(!empty($this->request->getGet('efiling_no'))) {
            $params['efiling_no'] = $this->request->getGet('efiling_no');
        }
        if(!empty($params)) {
            $params['ref_m_efiled_type_id'] = E_FILING_TYPE_NEW_CASE;
            $output = $this->Model_api->get_list_doc_cases_efiled($params);
        } else{
            $output['msg'] = 'Either Diary no or Efiling no is required';
            $output['status'] = 'error';
        }
        echo json_encode($output); exit();
    }

}