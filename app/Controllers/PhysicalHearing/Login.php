<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function index($msg=""){
        $data['page_title']='Login';
        $this->load->view('physical_hearing/error_404', $data);
    }

}
