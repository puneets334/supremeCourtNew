<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LanguageSwitcher extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function switchLang($language = "") {
        
        $language = ($language != "") ? $language : "english";
        $this->session->set_userdata('site_lang', $language);

        redirect(isset($_SERVER['HTTP_REFERER']));
    }

}
