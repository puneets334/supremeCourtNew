<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Appearance\AppearanceModel;

class Api extends BaseController {

	protected $Appearance_model;

    public function __construct() {
        parent::__construct();
        helper(['common', 'encryptdecrypt']);
		$this->Appearance_model = new AppearanceModel();
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

	public function diaries($list_date = null, $court_no = null) {
		extract($_REQUEST);
		if(!empty($list_date) && !empty($court_no)) {
			$list_date_ymd = date("Y-m-d", strtotime($list_date));
			$result_data = $this->Appearance_model->getAdvocateDiaryDetails($list_date_ymd, $court_no);
			if($result_data) {
				echo json_encode(array('status' => true, 'data' => $result_data));
			} else {
				$response = 'No records found for the given date and court number.';
				echo json_encode(array('status' => 'error', 'data' => $response));
			}
		} else {
			$response = 'Invalid query parameters. Ensure list_date and court_no are provided.';
			echo json_encode(array('status' => 'error', 'data' => $response));
		}
	}

	public function getAdvocateAppearanceDetails($diary_no = null, $adv_for = null, $list_date = null, $aor_code = null) {
		extract($_REQUEST);
		if(!empty($diary_no) && !empty($list_date) && !empty($aor_code)) {
			$list_date_ymd = date("Y-m-d", strtotime($list_date));
			$result_data = $this->Appearance_model->getAdvocateAppearanceDetails($diary_no, $adv_for, $list_date_ymd, $aor_code);
			if($result_data) {
				echo json_encode(array('status' => true, 'data' => $result_data));
			} else {
				$response = 'No records found for the given diary_no, adv_for, list_date, aor_code.';
				echo json_encode(array('status' => 'error', 'data' => $response));
			}
		} else {
			$response = 'Invalid query parameters. Ensure diary_no, adv_for, list_date, aor_code are provided.';
			echo json_encode(array('status' => 'error', 'data' => $response));
		}
	}

	public function getAdvocateAppearanceAORIncludeORExclude($diary_no = null, $adv_for = null, $list_date = null, $aor_code = null) {
		extract($_REQUEST);
		if(!empty($diary_no) && !empty($list_date) && !empty($aor_code)) {
			$list_date_ymd = date("Y-m-d", strtotime($list_date));
			$result_data = $this->Appearance_model->getAdvocateAppearanceAORIncludeORExclude($diary_no, $adv_for, $list_date_ymd, $aor_code);
			if($result_data) {
				echo json_encode(array('status' => true, 'data' => $result_data));
			} else {
				$response = 'No records found for the given diary_no, adv_for, list_date, aor_code.';
				echo json_encode(array('status' => 'error', 'data' => $response));
			}
		} else {
			$response = 'Invalid query parameters. Ensure diary_no, adv_for, list_date, aor_code are provided.';
			echo json_encode(array('status' => 'error', 'data' => $response));
		}
	}

}