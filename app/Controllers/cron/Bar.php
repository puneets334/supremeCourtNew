<?php
namespace App\Controllers;

class Bar extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('cron/Default_model');
        $this->load->library('webservices/efiling_webservices');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper('functions'); // loading custom functions
        $this->load->database();
    }

    public function index() {
        $aor_code='';
        $AORDetails_data = file_get_contents(ICMIS_SERVICE_URL.'/ConsumedData/getAORDetails/?aor_code='.$aor_code);
        if (!empty($AORDetails_data)){
            $AORDetails = json_decode($AORDetails_data);
            $AORData=$AORDetails->data;
            if (!empty($AORData)){
                $response= $this->Default_model->get_aor_code_check_after_insert($AORData);
                echo $response;
            }
        }
    }
}