<?php
namespace App\Controllers;

class DefaultController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->helper('functions');
        $this->load->model('consume/Consume_data_model');
        require_once APPPATH . 'third_party/SBI/Crypt/AES.php';
        require_once APPPATH . 'third_party/cg/AesCipher.php';

        $ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $refData = parse_url($ref);
        if ($refData['host'] != $_SERVER['SERVER_NAME'] && $refData['host'] != NULL) {

            redirect("login");
            exit(0);
        }
        if (count($_POST) > 0) {
            if ($_POST['CSRF_TOKEN'] != $_SESSION['csrf_to_be_checked']) {
                echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Error</title><style type="text/css"> ::selection { background-color: #E13300; color: white; } ::-moz-selection { background-color: #E13300; color: white; } body {  background-color: #fff;  margin: 40px;  font: 13px/20px normal Helvetica, Arial, sans-serif;  color: #4F5155;}a {  color: #003399;  background-color: transparent;  font-weight: normal;}h1 {  color: #444;  background-color: transparent;  border-bottom: 1px solid #D0D0D0;  font-size: 19px;  font-weight: normal;  margin: 0 0 14px 0;  padding: 14px 15px 10px 15px;}code {  font-family: Consolas, Monaco, Courier New, Courier, monospace;  font-size: 12px;  background-color: #f9f9f9;  border: 1px solid #D0D0D0;  color: #002166;  display: block;  margin: 14px 0 14px 0;  padding: 12px 10px 12px 10px;}#container {  margin: 10px;  border: 1px solid #D0D0D0;  box-shadow: 0 0 8px #D0D0D0;}p {  margin: 12px 15px 12px 15px;}</style></head><body>  <div id="container">    <h1>An Error Was Encountered</h1>    <p>The action you have requested is not allowed.</p>  </div></body></html>';
                exit(0);
            }
        }
        $_SESSION['csrf_to_be_checked'] = $this->security->get_csrf_hash();
    }

    public function index() {
        
    }   

}
