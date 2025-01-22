<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Api extends BaseController {

    public function __construct() {
        parent::__construct();
        helper(['common', 'encryptdecrypt']);
    }

	public function getAdvocateConsent($token = null, $date = null) {
		extract($_REQUEST);
		$date = !empty($date) ? $date : null;
		$token = !empty($token) ? $token : null;
		$token_existed = '11873d07510c2c3348f58a04f63bc9a632961187';
		if ($token_existed == $token) {
			// $date = '2022-04-04'; // for testing
			$result_data = getAdvocateConsentDetails($date);
			echo json_encode(array('status' => true, 'data' => $result_data));
		} else {
			$response = 'You are not Authorized';
			echo json_encode(array('status' => $response, 'data' => array()));
		}
		exit();
	}

}