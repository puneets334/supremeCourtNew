<?php

namespace App\Controllers\Captcha;

use App\Controllers\BaseController;
// namespace App\Controllers;

class DefaultController extends BaseController {

    public function index() {
        captcha_key();
    }

    public function get_code()
    {
        $captcha_code=$_SESSION['captcha'];
        if ($captcha_code && !empty($captcha_code) && $captcha_code !=null && strlen($captcha_code) !=0) {
            echo '1@@@'.$captcha_code; exit();
        }else{
            echo '0@@@Captcha is not found';exit();
        }

    }

}

?>
