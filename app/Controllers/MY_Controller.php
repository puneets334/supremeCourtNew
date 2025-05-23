<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_Controller extends CI_Controller {

    public function __construct() {

        parent::__construct();

        date_default_timezone_set('Asia/Kolkata');
        /* Authorization Check */
        if (!isset($this->session->userdata['login'])) {
            redirect("login");
            exit(0);
        }

        $ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $refData = isset($ref) ? parse_url($ref) : '';
        $allowed_hosts = array($_SERVER['SERVER_NAME'], 'test.sbiepay.com', 'nic-esigngateway.nic.in', 'efiling.ecourts.gov.in', 'egrashry.nic.in', 'www.shcileservices.com', 'dr.shcileservices.com', 'gras.mahakosh.gov.in');

        if ($refData['host'] != $_SERVER['SERVER_NAME'] && $refData['host'] != NULL) {

            if (!empty($refData['host']) && !in_array($refData['host'], $allowed_hosts) && $refData['host'] != NULL) {

                echo header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
                echo ' 400 BAD REQUEST ';
                exit(0);
            }
            if (count($_POST) > 0) {
                array_shift($allowed_hosts);
                if (!empty($refData['host']) && in_array($refData['host'], $allowed_hosts) && $refData['host'] != NULL) {
                    
                } elseif ($_POST['CSRF_TOKEN'] != $_SESSION['csrf_to_be_checked']) {

                    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Error</title><style type="text/css"> ::selection { background-color: #E13300; color: white; } ::-moz-selection { background-color: #E13300; color: white; } body {  background-color: #fff;  margin: 40px;  font: 13px/20px normal Helvetica, Arial, sans-serif;  color: #4F5155;}a {  color: #003399;  background-color: transparent;  font-weight: normal;}h1 {  color: #444;  background-color: transparent;  border-bottom: 1px solid #D0D0D0;  font-size: 19px;  font-weight: normal;  margin: 0 0 14px 0;  padding: 14px 15px 10px 15px;}code {  font-family: Consolas, Monaco, Courier New, Courier, monospace;  font-size: 12px;  background-color: #f9f9f9;  border: 1px solid #D0D0D0;  color: #002166;  display: block;  margin: 14px 0 14px 0;  padding: 12px 10px 12px 10px;}#container {  margin: 10px;  border: 1px solid #D0D0D0;  box-shadow: 0 0 8px #D0D0D0;}p {  margin: 12px 15px 12px 15px;}</style></head><body>  <div id="container">    <h1>An Error Was Encountered</h1>    <p>The action you have requested is not allowed.</p>  </div></body></html>';
                    exit(0);
                }
            }

            $_SESSION['csrf_to_be_checked'] = $this->security->get_csrf_hash();
        }
    }

}
