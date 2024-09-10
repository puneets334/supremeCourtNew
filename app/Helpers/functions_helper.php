<?php

use App\Models\Affirmation\AffirmationModel;
use App\Models\AppearingFor\AppearingForModel;
use \App\Models\Common\CommonModel;
use App\Models\NewCase\GetDetailsModel;
use App\Models\Caveat\ViewModel;
use App\Models\Supplements\SupplementModel;
use App\Models\Vacation\VacationAdvanceModel;
use GuzzleHttp\Client;
use Config\Database;
helper('view');

use eftec\bladeone\BladeOne;
use GuzzleHttp\Exception\GuzzleException;

if (!function_exists('pr')) {
    function pr($request)
    {
        echo '<pre>';
        print_r($request);
        echo "<br>";
        die;
    }
}

if (!function_exists('pra')) {
    function pra($request)
    {
        pr($request->toArray());
    }
}

function setSessionData($key, $value)
{
    $session = \Config\Services::session();
    $session->set($key, $value);
}

function getSessionData($key)
{
    $session = \Config\Services::session();
    return $session->get($key);
}

function captcha_key($key = null)
{
    //$captcha = rand(1000, 999999);
    //$captcha = generateRandomString(6);
    $length = 6;
    $captcha = substr(str_shuffle(str_repeat($x = '23456789abdefghmnpqrtzABDEFGHLMNPQRSTWXYZ', ceil($length / strlen($x)))), 1, $length);

    // The captcha will be stored
    // for the session
    // $_SESSION["captcha"] = $captcha;
    setSessionData('captcha', $captcha);


    // Generate a 70x24 standard captcha image
    $im = imagecreatetruecolor(70, 30);

    // Blue color
    $bg = imagecolorallocate($im, 22, 86, 165);

    // White color
    $fg = imagecolorallocate($im, 255, 255, 255);

    // Give the image a blue background
    imagefill($im, 0, 0, $bg);

    // Print the captcha text in the image
    // with random position & size
    imagestring($im, rand(10, 7), rand(10, 7), rand(10, 7), $captcha, $fg);

    // VERY IMPORTANT: Prevent any Browser Cache!!
    header("Cache-Control: no-store,no-cache, must-revalidate");

    // The PHP-file will be rendered as image
    header('Content-type: image/png');

    // Finally output the captcha as
    // PNG image the browser
    imagepng($im);

    // Free memory
    imagedestroy($im);

    // return imagepng($im);
}

function get_new_captcha()
{
    return $_SESSION["captcha"];
    /*  $length=6;
      //$random_number = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
      $random_number = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);

      $vals = array(
          'word' => $random_number,
          'img_path' => './captcha/',
          'img_url' => base_url() . 'captcha/',
          'font_path' => './path/to/fonts/texb.ttf',
          'img_width' => '120',
          'img_height' => 30,
          'expiration' => 7200,
          'word_length' => 10,
          'font_size' => 13,
          'img_id' => 'Imageid',
          'pool' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
          // White background and border, black text and red grid
          'colors' => array(
              'background' => array(255, 255, 255),
              'border' => array(255, 255, 255),
              'text' => array(0, 0, 0),
              //'grid' => array(255, 40, 40)
          )
      );

      //$data['captcha'] = create_captcha($vals);
      $data['captcha'] =$vals;

      return $data['captcha'];*/
}

if (!function_exists('isValidPDF')) {

    function isValidPDF($doc)
    {
        $msg = '';
        $doc_signed_used = '';
        if ($_FILES[$doc]['type'] != 'application/pdf') {
            $msg = '<center><p style="background: #f2dede;border: #f2dede;color: black;">only PDF are allowed in document upload!</p></center>';
            return $msg;
        }
        if (mime_content_type($_FILES[$doc]['tmp_name']) != 'application/pdf') {
            $msg = 'only PDF are allowed in document upload!';
            return $msg;
        }
        if (substr_count($_FILES[$doc]['name'], '.') > 1) {
            $msg = '<center><p style="background: #f2dede;border: #f2dede;color: black;">No double extension allowed in pdf document!</p></center>';
            return $msg;
        }
        if (preg_match("/[^0-9a-zA-Z\s.,-_ ]/i", $_FILES[$doc]['name'])) {

            $msg = '<center><p style="background: #f2dede;border: #f2dede;color: black;">PDF file name max. length can be 45 characters only. PDF file name may contain digits, characters, spaces, hyphens and underscores.</p></center>';
            return $msg;
        }
        if (strlen($_FILES[$doc]['name']) > File_FIELD_LENGTH) {
            $msg = '<center><p style="background: #f2dede;border: #f2dede;color: black;">PDF file name max. length can be 45 characters only. PDF file name may contain digits, characters, spaces, hyphens and underscores.</p></center>';
            return $msg;
        }
        if ($_FILES[$doc]['size'] > UPLOADED_FILE_SIZE) {
            $file_size = (UPLOADED_FILE_SIZE / 1024) / 1024;
            $msg = '<center><p style="background: #f2dede;border: #f2dede;color: black;">PDF uploaded should be less than ' . $file_size . ' MB !</p></center>';
            return $msg;
        }
        if (isset(getSessionData('efiling_details')['doc_signed_used']) && !empty(getSessionData('efiling_details')['doc_signed_used'])) {
            $doc_signed_used = getSessionData('efiling_details')['doc_signed_used'];
        }
        if ($doc_signed_used == SIGNED_DIGITALLY_TOKEN) {
            $result = isDocumentSigned($_FILES[$doc]['tmp_name'], 'adbe.pkcs7.detached');
            if ($result != TRUE || $result != 1) {
                $msg = '<center><p style="background: #f2dede;border: #f2dede;color: black;">Please upload digitally signed document only!</p></center>';
                return $msg;
            }
        }
    }
}

function isDocumentSigned($file, $string)
{

    $handle = fopen($file, 'r');
    $valid = false; // init as false
    while (($buffer = fgets($handle)) !== false) {
        if (strpos($buffer, $string) !== false) {
            $valid = TRUE;
            break; // Once you find the string, you should break out the loop.
        }
    }
    fclose($handle);
    return $valid;
}

if (!function_exists('isValidImage')) {

    function isValidImage($image)
    {

        if ($_FILES[$image]['type'] != 'image/jpeg') {
            $msg = '<div class="alert alert-danger text-center">only Jpeg are allowed in photo  upload!</div>';
            return $msg;
        }
        if (mime_content_type($_FILES[$image]['tmp_name']) != 'image/jpeg') {
            $msg = '<div class="alert alert-danger text-center">only Jpeg are allowed in photo  upload!</div>';
            return $msg;
        }
        if (substr_count($_FILES[$image]['name'], '.') > 1) {
            $msg = '<div class="alert alert-danger text-center">No double extension allowed in photo  upload!</div>';
            return $msg;
        }
    }
}

if (!function_exists('script_remove')) {

    function script_remove($term)
    {

        //return trim(pg_escape_string(strip_tags($term, '<table><thead><tr><td><tbody><tfoot><th><b><i><ol><li><br><br/><a>')));
        return trim(strip_tags($term, '<table><thead><tr><td><tbody><tfoot><th><b><i><ol><li><br><br/><a>'));
    }
}
if (!function_exists('escape_data')) {

    function escape_data($post)
    {
        return trim(strip_tags($post));
    }
}

function echo_data($value)
{
    $data = htmlentities(script_remove($value), ENT_COMPAT);
    echo $value = str_replace("''", "'", $data);
}

function check_and_get_utf8($string)
{
    if (preg_match('%^(?:
      [\x09\x0A\x0D\x20-\x7E]            # ASCII
    | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
    | \xE0[\xA0-\xBF][\x80-\xBF]         # excluding overlongs
    | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
    | \xED[\x80-\x9F][\x80-\xBF]         # excluding surrogates
    | \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
    | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
    | \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
)*$%xs', $string))
        return $string;
    else
        return iconv('CP1252', 'UTF-8', $string);
}

if (!function_exists('isDate')) {

    function isDate($date)
    {
        if (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-(20([1-9][0-9]))$/", $date)) {
            return $date;
        } else {
            return false;
        }
    }
}
if (!function_exists('check_date')) {

    function check_date($date)
    {
        if (preg_match('/^((20([1-9][0-9]))-(0[1-9]|1[0-2])-0[1-9]|[1-2][0-9]|3[0-1]) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/', $date))
            return $date;
        else
            return false;
    }
}
if (!function_exists('getfiletype')) {

    function getfiletype($test)
    {
        if (testsig($test, "25 50 44 46")) {
            return "pdf";
        } else {
            return false;
        }
    }
}
if (!function_exists('count_page')) {

    function count_page($file)
    {
        $localPdfReader = new java("com.itextpdf.text.pdf.PdfReader", $file);
        $number_of_pages = $localPdfReader->getNumberOfPages();
        return $number_of_pages;
    }
}
function validate_date($posted_data, $field_profile)
{
    $err_msg = '';
    if ($field_profile['is_required'] == 't' && empty($posted_data)) {
        $err_msg = $field_profile['frm_field_label'] . " can not be blank";
        if ($field_profile['is_gen_err_msg'] == 't') {
            return $err_msg;
        } else {
            return $field_profile['err_msg'];
        }
    } elseif (!empty($posted_data)) {
        $pattern = $field_profile['preg_match'];
        if (!preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", $posted_data)) {
            return $field_profile['err_msg'];
        }
    }
}

function validate_pancard($posted_data, $field_profile)
{
    $err_msg = '';
    if ($field_profile['is_required'] == 't' && empty($posted_data)) {
        $err_msg = $field_profile['frm_field_label'] . " can not be blank";
        if ($field_profile['is_gen_err_msg'] == 't') {
            return $err_msg;
        } else {
            return $field_profile['err_msg'];
        }
    } elseif (!empty($posted_data)) {
        $pattern = $field_profile['preg_match'];
        if (!preg_match("/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/", $posted_data)) {
            return $field_profile['err_msg'];
        }
    }
}

function validate_passport($posted_data, $field_profile)
{
    $err_msg = '';
    if ($field_profile['is_required'] == 't' && empty($posted_data)) {
        $err_msg = $field_profile['frm_field_label'] . " can not be blank";
        if ($field_profile['is_gen_err_msg'] == 't') {
            return $err_msg;
        } else {
            return $field_profile['err_msg'];
        }
    } elseif (!empty($posted_data)) {
        $pattern = $field_profile['preg_match'];
        if (!preg_match("/^([a-zA-Z]){1}([0-9]){7}?$/", $posted_data)) {
            return $field_profile['err_msg'];
        }
    }
}

function validate_fax_and_phone($posted_data, $field_profile)
{
    $err_msg = '';
    if ($field_profile['is_required'] == 't' && empty($posted_data)) {
        $err_msg = $field_profile['frm_field_label'] . " can not be blank";
        if ($field_profile['is_gen_err_msg'] == 't') {
            return $err_msg;
        } else {
            return $field_profile['err_msg'];
        }
    } elseif (!empty($posted_data)) {
        $pattern = $field_profile['preg_match'];
        if (!preg_match("/^[0-9]{3}-[0-9]{8}$/", $posted_data)) {
            return $field_profile['err_msg'];
        }
    }
}

function getStringOfAmount($number)
{
    $hyphen = '-';
    $conjunction = ' and ';
    $separator = ', ';
    $negative = 'negative ';
    $decimal = ' point ';
    $dictionary = array(
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
        20 => 'twenty',
        30 => 'thirty',
        40 => 'fourty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety',
        100 => 'hundred',
        1000 => 'thousand',
        1000000 => 'million',
        1000000000 => 'billion',
        1000000000000 => 'trillion',
        1000000000000000 => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    foreach ($dictionary as $key => $dict) {
        $newdictionary[$key] = ucfirst($dict);
    }
    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'getStringOfAmount only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . getStringOfAmount(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $newdictionary[$number];
            break;
        case $number < 100:
            $tens = ((int)($number / 10)) * 10;
            $units = $number % 10;
            $string = $newdictionary[$tens];
            if ($units) {
                $string .= $hyphen . $newdictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = $number / 100;
            $remainder = $number % 100;
            $string = $newdictionary[$hundreds] . ' ' . $newdictionary[100];
            if ($remainder) {
                $string .= $conjunction . getStringOfAmount($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int)($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = getStringOfAmount($numBaseUnits) . ' ' . $newdictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= getStringOfAmount($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string)$fraction) as $number) {
            $words[] = $newdictionary[$number];
        }
        $string .= ucwords(implode(' ', $words));
    }

    return $string;
}

function send_mail_msg($to_email, $subject, $message, $to_user_name = "")
{
    /*$url=EADMINSCI_URI."/stealth-a-push-mail-gw?toIds=".rawurlencode($to_email)."&subject=".rawurlencode($subject)."&msg=".rawurlencode($message)."&typeId=".SMS_EMAIL_API_USER;
    $result=(array)json_decode(file_get_contents($url));*/
    if (!empty($to_user_name) && $to_user_name != null) {
        relay_mail_api_through_60_server(array($to_email), $subject, $message, $to_user_name);
    } else {
        relay_mail_api_through_60_server(array($to_email), $subject, $message);
    }
}

function send_petitioner_mail_msg($to_email, $subject, $message, $to_user_name)
{
    if (empty($to_email)) {
        return true;
    }
    $url = EADMINSCI_URI . "/stealth-a-push-mail-gw?toIds=" . rawurlencode($to_email) . "&subject=" . rawurlencode($subject) . "&msg=" . rawurlencode($message) . "&typeId=" . SMS_EMAIL_API_USER;
    $result = (array)json_decode(file_get_contents($url));
}

function relay_mail_api_through_60_server($to_email, $subject, $message, $to_user_name = "")
{
    $result = '';
    foreach ($to_email as $val_email) {
        $to_email = $val_email;
        // $ci = &get_instance();
        $email_message = '';
        // pr(getSessionData('adv_details'));
        if (getSessionData('citation_mail') != '' && getSessionData('citation_mail') == 'Citation') {

            $search_by = getSessionData('citation_data')[1]['search_by'];
            if ($search_by == 'J') {
                $page_no = getSessionData('citation_data')[1]['page_no'];
                $volume = getSessionData('citation_data')[1]['volume'];
                $journal_year = getSessionData('citation_data')[1]['journal_year'];
                $journal = getSessionData('citation_data')[1]['journal'];
            } else {
                $page_no = getSessionData('citation_data')[0]['page_no'];
                $volume = getSessionData('citation_data')[0]['volume'];
                $journal_year = getSessionData('citation_data')[0]['journal_year'];
                $journal = getSessionData('citation_data')[0]['journal'];
            }
            $given_by = getSessionData('login')['first_name'];
            //$this->session->userdata['login']['first_name']

            $case_data_info = array(
                'diary_no' => getSessionData('case_data')[0]['diary_no'], 'registation_no' => getSessionData('case_data')[0]['reg_no_display'], 'cause_title' => getSessionData('case_data')[0]['cause_title'], 'dairy_yr' => getSessionData('case_data')[0]['diary_year'],
                'title' => getSessionData('citation_data')[0]['title'], 'pubname' =>
                getSessionData('citation_data')[0]['pubnm'], 'pubyear' => getSessionData('citation_data')[0]['pubyr'], 'subject' => getSessionData('citation_data')[0]['sub'],
                'listing_date' => getSessionData('citation_data')[0]['listing_date'], 'page_no' => $page_no, 'volume' => $volume, 'journal_year' => $journal_year, 'journal' => $journal, 'given_by' => $given_by
            );
            /*print_r($case_data_info);
            exit();*/

            $email_message = view('templates/email/citation_mail', $case_data_info);
        } elseif (!empty(getSessionData('adv_details')) && !empty(getSessionData('adv_details')['first_name']) && !empty(getSessionData('adv_details')['last_name'])) {
            $data = array(
                'first_name' => $_SESSION['adv_details']['first_name'],
                'last_name' => getSessionData('adv_details')['last_name'],
                'message' => $message
            );
            $email_message = view('templates/email/password_reset', $data);
        } elseif ($to_user_name == 'adjournment') {
            $email_message = ($message);
        } elseif ($to_user_name == 'arguing_counsel') {
            $email_message = ($message);
        } elseif (getSessionData('login') != '' && getSessionData('login')['first_name'] != '' && getSessionData('login')['last_name']) {
            $data = array(
                'first_name' => getSessionData('login')['first_name'],
                'last_name' => getSessionData('login')['last_name'],
                'message' => $message
            );
            $email_message = view('templates/email/html_mail', $data);
        } else {
            $email_message = ($message);
        }
        $files = array();
        //$string = base64_encode(json_encode(array("allowed_key" => "DZFYAb6p9j", "sender" => "eFiling-Supreme Court | SC-eFM<noreply-efiling@sci.gov.in>", "mailTo" => $to_email, "subject" => $subject, "message" => $email_message, "files" => $files)));
        //$string = base64_encode(json_encode(array("allowed_key" => "xFgKPb9a8z", "sender" => "eService", "mailTo" => $to_email, "subject" => $subject, "message" => $email_message, "files" => $files)));
        $string = base64_encode(json_encode(array("allowed_key" => "cKLKqvPlW8", "sender" => "eService", "mailTo" => $to_email, "subject" => $subject, "message" => $email_message, "files" => $files)));
        $content = http_build_query(array('a' => $string));
        $context = stream_context_create(array('http' => array('method' => 'POST', 'content' => $content,)));
        $json_return = @file_get_contents(NEW_MAIL_SERVER_HOST, false, $context);
        $json2 = json_decode($json_return);
        //echo $json_return;
        // pr($json2);
        //$response = json2["status"];
        if (!empty($json2)) {
            $response = $json2->status;
        }
        if ($json2) {
            if ($response == 'success') {
                $result = 'success';
            } else {
                $result = 'error';
            }
        }
        return $result;
    }
}

function relay_mail_api($to_email, $subject, $message, $to_user_name = "")
{
    foreach ($to_email as $val_email) {
        $to_email = $val_email;

        // $ci = &get_instance();
        // $ci->load->library('email');
        $email = \Config\Services::email();
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.mail.gov.in',
            'smtp_port' => 465,
            'smtp_user' => 'causelists@nic.in',
            'smtp_pass' => 'eCourts*1234',
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );

        /*$config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'scieservice@gmail.com',
            'smtp_pass' => 'eService@29031990',
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );*/

        $email->initialize($config);
        // $email->mailType("html");
        $email->setNewline("\r\n");
        $email->setTo($to_email);
        $email->setFrom('causelists@nic.in', "Supreme Court of India");
        //$ci->email->from('scieservice@gmail.com', "Supreme Court of India");
        //$ci->email->bcc('info-ecommittee@aij.gov.in', "Info eCommittee");
        $email->setSubject($subject);

        if (getSessionData('citation_mail') == 'Citation') {

            $search_by = getSessionData('citation_data')[1]['search_by'];
            if ($search_by == 'J') {
                $page_no = getSessionData('citation_data')[1]['page_no'];
                $volume = getSessionData('citation_data')[1]['volume'];
                $journal_year = getSessionData('citation_data')[1]['journal_year'];
                $journal = getSessionData('citation_data')[1]['journal'];
            } else {
                $page_no = getSessionData('citation_data')[0]['page_no'];
                $volume = getSessionData('citation_data')[0]['volume'];
                $journal_year = getSessionData('citation_data')[0]['journal_year'];
                $journal = getSessionData('citation_data')[0]['journal'];
            }
            $given_by = getSessionData('login')['first_name'];
            //$this->session->userdata['login']['first_name']

            $case_data_info = array(
                'diary_no' => getSessionData('case_data')[0]['diary_no'], 'registation_no' => getSessionData('case_data')[0]['reg_no_display'], 'cause_title' => getSessionData('case_data')[0]['cause_title'], 'dairy_yr' => getSessionData('case_data')[0]['diary_year'],
                'title' => getSessionData('citation_data')[0]['title'], 'pubname' =>
                getSessionData('citation_data')[0]['pubnm'], 'pubyear' => getSessionData('citation_data')[0]['pubyr'], 'subject' => getSessionData('citation_data')[0]['sub'],
                'listing_date' => getSessionData('citation_data')[0]['listing_date'], 'page_no' => $page_no, 'volume' => $volume, 'journal_year' => $journal_year, 'journal' => $journal, 'given_by' => $given_by
            );
            /*print_r($case_data_info);
            exit();*/

            $email->setMessage(render('templates/email/citation_mail', $case_data_info, true));
        } elseif (getSessionData('adv_details') != '' && getSessionData('adv_details')['first_name'] != '' && getSessionData('adv_details')['last_name'] != '') {
            $data = array(
                'first_name' => getSessionData('adv_details')['first_name'],
                'last_name' => getSessionData('adv_details')['last_name'],
                'message' => $message
            );
            $email->setMessage(render('templates/email/password_reset', $data, true));
        } elseif ($to_user_name == 'adjournment') {
            $email->setMessage($message);
        } elseif ($to_user_name == 'arguing_counsel') {
            $email->setMessage($message);
        } elseif (getSessionData('login')['first_name'] != '' && getSessionData('login')['last_name'] != '') {
            $data = array(
                'first_name' => getSessionData('login')['first_name'],
                'last_name' => getSessionData('login')['last_name'],
                'message' => $message
            );
            $email->setMessage(render('templates/email/html_mail', $data, true));
        } else {
            $email->setMessage($message);
        }

        $response = $email->send();
        if ($response) {
            $result = 'success';
        } else {
            $result = 'error';
        }
    } //End of foreach loop..
    return $result;
}

function relay_doc_mail_api($to_email, $subject, $message)
{
    // $ci = &get_instance();
    // $ci->load->library('email');
    $email = \Config\Services::email();
    $config = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.mail.gov.in',
        'smtp_port' => 465,
        'smtp_user' => 'causelists@nic.in',
        'smtp_pass' => 'eCourts*1234',
        'mailtype' => 'html',
        'charset' => 'utf-8'
    );
    $email->initialize($config);
    $email->setMailType("text");
    $email->setNewline("\r\n");
    $email->setTo($to_email);
    $email->setFrom('causelists@nic.in', "Supreme Court of India");
    $email->setSubject($subject);
    $email->setMessage($message);
    $response = $email->send();
    if ($response) {
        $result = 'success';
    } else {
        $result = 'error';
    }
    return $result;
}

function send_mobile_sms($mobile_no, $sentSMS, $templateId = SCISMS_GENERIC_TEMPLATE)
{
    $result = sendSMS(SMS_EMAIL_API_USER, $mobile_no, $sentSMS, $templateId);
    return json_decode($result);
}

function send_petitioner_mobile_sms($mobile_no, $sentSMS)
{
    if (empty($mobile_no)) {
        return true;
    }
    $result = sendSMS(SMS_EMAIL_API_USER, $mobile_no, $sentSMS);
    return json_decode($result);
}

function remove_selected_tags($data, $tags_array)
{
    $tags_to_strip = $tags_array;
    foreach ($tags_to_strip as $tag) {
        $data = preg_replace("/<\\/?" . $tag . "(.|\\s)*?>/", ' ', $data);
    }
    return $data;
}

function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function validatePostedDate($posted_data)
{
    if (!preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", $posted_data)) {
        return FALSE;
    }
}

function url_encryption($url_val)
{
    $encrypt = $url_val;
    $str_len = strlen($url_val);
    if ($str_len > 1) {
        $array_value = str_split($url_val);
    } else {
        $array_value = array($url_val);
    }


    $str_value = array(
        '0' => '36', '1' => '92', '2' => '73', '3' => '32',
        '4' => '48', '5' => '43', '6' => '11', '7' => '84', '8' => '33', '9' => '17',
        'a' => '89', 'b' => '98', 'c' => '97', 'd' => '86', 'e' => '55',
        'f' => '49', 'g' => '39', 'h' => '29', 'i' => '52', 'j' => '50',
        'k' => '61', 'l' => '72', 'm' => '83', 'n' => '34', 'o' => '15',
        'p' => '60', 'q' => '70', 'r' => '78', 's' => '69', 't' => '25',
        'u' => '41', 'v' => '62', 'w' => '81', 'x' => '22', 'y' => '95',
        'z' => '76', 'A' => '44', 'B' => '26', 'C' => '23', 'D' => '35',
        'E' => '42', 'F' => '12', 'G' => '16', 'H' => '93', 'I' => '87',
        'J' => '91', 'K' => '31', 'L' => '47', 'M' => '45', 'N' => '64',
        'O' => '57', 'P' => '68', 'Q' => '51', 'R' => '20', 'S' => '59',
        'T' => '56', 'U' => '30', 'V' => '99', 'W' => '88', 'X' => '77',
        'Y' => '66', 'Z' => '79', '#' => '82', '$' => '85', '_' => '90',
        ' ' => '71', '(' => '67', ')' => '10', ':' => '74', ',' => '75',
        '/' => '27', '.' => '28', '[' => '24', ']' => '21', '@' => '37',
        '&' => '54', '-' => '38', '~' => '58'
    );
    //''=> 58 ,'63' ,65 , 13 ,14 ,18 ,19 Use for another
    $return_value = '';

    for ($i = 0; $i < count($array_value); $i++) {
        // $return_value .= $str_value[$array_value[$i]];
        $return_value .= $str_value[$array_value[$i]] ?? '';
    }
    $check_sum = getSessionData('login')['login_active_session'];

    $string = $return_value;
    //$checksum = hash_hmac('crc32b', $string, $check_sum, false); // working php7.1
    $checksum = hash_hmac('sha256', $string, $check_sum, false);
    $checksum = strtoupper($checksum);
    $result = $return_value . '.' . $checksum;

    //-----------END :ENCRYPT CHECKSUM IN URL----------------------//

    return $result;
}

function url_decryption($url_val)
{
    $check_sum_str = explode('.', $url_val);
    if (!empty($check_sum_str[1])) {
        $str_len = strlen($check_sum_str[0]);
        $array_string = str_split($check_sum_str[0]);

        // Load session library
        $session = \Config\Services::session();
        $login_id = $session->get('login')['login_active_session'];

        $res_checksum = strtoupper(hash_hmac('sha256', $check_sum_str[0], $login_id, false));
        if ($res_checksum == $check_sum_str[1]) {
            if ($str_len > 2) {
                $num_pair = $str_len / 2;
                $l_num_pair = 0;
                for ($j = 0; $j < $num_pair; $j++) {
                    if ($j != 0) {
                        $l_num_pair = $up_num_pair;
                        $up_num_pair = $l_num_pair + 2;
                    } else {
                        $up_num_pair = $j + 2;
                    }
                    $val = '';
                    for ($i = $l_num_pair; $i < $up_num_pair; $i++) {
                        $val .= $array_string[$i];
                    }
                    $arr_val[$j] = $val;
                }
                $array_value = $arr_val;
            } else {
                $array_value = array($check_sum_str[0]);
            }
            $str_value = [
                '0' =>
                '36', '1' => '92', '2' => '73', '3' => '32',
                '4' => '48', '5' => '43', '6' => '11', '7' => '84', '8' => '33', '9' => '17',
                'a' => '89', 'b' => '98', 'c' => '97', 'd' => '86', 'e' => '55',
                'f' => '49', 'g' => '39', 'h' => '29', 'i' => '52', 'j' => '50',
                'k' => '61', 'l' => '72', 'm' => '83', 'n' => '34', 'o' => '15',
                'p' => '60', 'q' => '70', 'r' => '78', 's' => '69', 't' => '25',
                'u' => '41', 'v' => '62', 'w' => '81', 'x' => '22', 'y' => '95',
                'z' => '76', 'A' => '44', 'B' => '26', 'C' => '23', 'D' => '35',
                'E' => '42', 'F' => '12', 'G' => '16', 'H' => '93', 'I' => '87',
                'J' => '91', 'K' => '31', 'L' => '47', 'M' => '45', 'N' => '64',
                'O' => '57', 'P' => '68', 'Q' => '51', 'R' => '20', 'S' => '59',
                'T' => '56', 'U' => '30', 'V' => '99', 'W' => '88', 'X' => '77',
                'Y' => '66', 'Z' => '79', '#' => '82', '$' => '85', '_' => '90',
                ' ' => '71', '(' => '67', ')' => '10', ':' => '74', ',' => '75',
                '/' => '27', '.' => '28', '[' => '24', ']' => '21', '@' => '37',
                '&' => '54', '-' => '38'
            ];

            $string_flip = array_flip($str_value);

            $return_value = '';
            foreach ($array_value as $value) {
                $return_value .= $string_flip[$value];
            }
            return $return_value;
        }
    }
    return null; // Return null if decryption fails
}

// vinit code

function custom_url_encryption($url_val)
{
    $str_len = strlen($url_val);
    $array_value = $str_len > 1 ? str_split($url_val) : [$url_val];

    $str_value = [
        '0' => '36', '1' => '92', '2' => '73', '3' => '32', '4' => '48', '5' => '43', '6' => '11', '7' => '84',
        '8' => '33', '9' => '17', 'a' => '89', 'b' => '98', 'c' => '97', 'd' => '86', 'e' => '55', 'f' => '49',
        'g' => '39', 'h' => '29', 'i' => '52', 'j' => '50', 'k' => '61', 'l' => '72', 'm' => '83', 'n' => '34',
        'o' => '15', 'p' => '60', 'q' => '70', 'r' => '78', 's' => '69', 't' => '25', 'u' => '41', 'v' => '62',
        'w' => '81', 'x' => '22', 'y' => '95', 'z' => '76', 'A' => '44', 'B' => '26', 'C' => '23', 'D' => '35',
        'E' => '42', 'F' => '12', 'G' => '16', 'H' => '93', 'I' => '87', 'J' => '91', 'K' => '31', 'L' => '47',
        'M' => '45', 'N' => '64', 'O' => '57', 'P' => '68', 'Q' => '51', 'R' => '20', 'S' => '59', 'T' => '56',
        'U' => '30', 'V' => '99', 'W' => '88', 'X' => '77', 'Y' => '66', 'Z' => '79', '#' => '82', '$' => '85',
        '_' => '90', ' ' => '71', '(' => '67', ')' => '10', ':' => '74', ',' => '75', '/' => '27', '.' => '28',
        '[' => '24', ']' => '21', '@' => '37', '&' => '54', '-' => '38'
    ];

    $return_value = '';
    foreach ($array_value as $char) {
        $return_value .= $str_value[$char];
    }

    $check_sum = getSessionData('login')['login_active_session'];
    $checksum = strtoupper(hash_hmac('sha256', $return_value, $check_sum, false));
    return $return_value . '.' . $checksum;
}

function custom_url_decryption($url_val)
{
    list($encoded, $checksum) = explode('.', $url_val, 2);

    if (empty($checksum)) {
        return false;
    }

    $login_id = getSessionData('login')['login_active_session'];
    $res_checksum = strtoupper(hash_hmac('sha256', $encoded, $login_id, false));

    if ($res_checksum !== $checksum) {
        return false;
    }

    $str_len = strlen($encoded);
    $array_string = str_split($encoded);

    $str_value = [
        '0' => '36', '1' => '92', '2' => '73', '3' => '32', '4' => '48', '5' => '43', '6' => '11', '7' => '84',
        '8' => '33', '9' => '17', 'a' => '89', 'b' => '98', 'c' => '97', 'd' => '86', 'e' => '55', 'f' => '49',
        'g' => '39', 'h' => '29', 'i' => '52', 'j' => '50', 'k' => '61', 'l' => '72', 'm' => '83', 'n' => '34',
        'o' => '15', 'p' => '60', 'q' => '70', 'r' => '78', 's' => '69', 't' => '25', 'u' => '41', 'v' => '62',
        'w' => '81', 'x' => '22', 'y' => '95', 'z' => '76', 'A' => '44', 'B' => '26', 'C' => '23', 'D' => '35',
        'E' => '42', 'F' => '12', 'G' => '16', 'H' => '93', 'I' => '87', 'J' => '91', 'K' => '31', 'L' => '47',
        'M' => '45', 'N' => '64', 'O' => '57', 'P' => '68', 'Q' => '51', 'R' => '20', 'S' => '59', 'T' => '56',
        'U' => '30', 'V' => '99', 'W' => '88', 'X' => '77', 'Y' => '66', 'Z' => '79', '#' => '82', '$' => '85',
        '_' => '90', ' ' => '71', '(' => '67', ')' => '10', ':' => '74', ',' => '75', '/' => '27', '.' => '28',
        '[' => '24', ']' => '21', '@' => '37', '&' => '54', '-' => '38'
    ];

    $string_flip = array_flip($str_value);

    if ($str_len > 2) {
        $num_pair = $str_len / 2;
        $l_num_pair = 0;
        $array_value = [];

        for ($j = 0; $j < $num_pair; $j++) {
            $up_num_pair = $j != 0 ? $l_num_pair + 2 : $j + 2;
            $val = '';
            for ($i = $l_num_pair; $i < $up_num_pair; $i++) {
                $val .= $array_string[$i];
            }
            $l_num_pair = $up_num_pair;
            $array_value[] = $val;
        }
    } else {
        $array_value = [$encoded];
    }
    $return_value = '';
    foreach ($array_value as $value) {
        $return_value .= $string_flip[$value];
    }
    return $return_value;
} // vinit code end function
function cino_decrypt($string, $secret_key)
{
    $secret_iv = 'nic@punemaharashtraindia';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = substr(hash('sha1', $secret_key), 0, 32);
    $iv = substr(hash('sha1', $secret_iv), 0, 16);
    $output = openssl_decrypt($string, $encrypt_method, $key, 0, $iv);
    return $output;
}
// Encrypt data using the public key 
function encrypt($data, $publicKey)
{ // Encrypt the data using the public key 
    openssl_public_encrypt($data, $encryptedData, $publicKey);
    // Return encrypted data return
    $encryptedData;
} // Decrypt data using the private key 
function decrypt($data, $privateKey)
{ // Decrypt the data using the private key 
    openssl_private_decrypt($data, $decryptedData, $privateKey); // Return decrypted data 
    return $decryptedData;
}
function generate_public_private_key()
{ // Set the key parameters
    $config = array(
        "digest_alg" => "sha512",
        "private_key_bits" => 512,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );

    // Create the private and public key
    $res = openssl_pkey_new($config);
    // Extract the private key from $res to $privKey
    openssl_pkey_export($res, $privKey);

    // Extract the public key from $res to $pubKey
    $pubKey = openssl_pkey_get_details($res);

    return array(
        'private' => $privKey,
        'public' => $pubKey["key"],
        'type' => $config,
    );
}

function get_court_type($efiling_for_type_id)
{
    if ($efiling_for_type_id == E_FILING_FOR_HIGHCOURT) {
        return ENABLE_WEBSERVICE_HC;
    } elseif ($efiling_for_type_id == E_FILING_FOR_ESTABLISHMENT) {
        return ENABLE_WEBSERVICE_ESTAB;
    }
}

function pingDomain($domain)
{
    $starttime = microtime(true);
    $file = fsockopen($domain, 80, $errno, $errstr, 10);
    $stoptime = microtime(true);
    $status = 0;

    if (!$file)
        $status = -1; // Site is down
    else {
        fclose($file);
        $status = ($stoptime - $starttime) * 1000;
        $status = floor($status);
    }
    return $status;
}

function cin_preview($cin)
{

    if (strlen($cin) == 16) {
        return substr($cin, 0, 6) . '-' . substr($cin, 6, 6) . '-' . substr($cin, 12, 4);
    } else {
        return efile_preview($cin);
    }
}

function efile_preview($efile_no)
{
    return substr($efile_no, 0, 2) . '-' . substr($efile_no, 2, 6) . '-' . substr($efile_no, 8, 5) . '-' .
        substr($efile_no, 13, 4);
}

function validate_number($field_value, $is_required, $field_min_length, $field_max_length, $field_label)
{

    $ci = &get_instance();
    $ci->load->library('form_validation');

    $data = array('field_name' => $field_value);

    $ci->form_validation->set_data($data);
    if ($is_required == 't') {
        $ci->form_validation->set_rules('field_name', $field_label, 'required|min_length[' . $field_min_length .
            ']|max_length[' . $field_max_length . ']|is_natural_no_zero');
    } else {
        $ci->form_validation->set_rules('field_name', $field_label, 'min_length[' . $field_min_length .
            ']|max_length[' . $field_max_length . ']|is_natural_no_zero');
    }

    if ($ci->form_validation->run() == FALSE) {
        return array('response' => false, 'msg' => $ci->form_validation->error_array('field_name'));
    } else {
        return array('response' => true);
    }
}

// function validate_names($field_value, $is_required, $field_min_length, $field_max_length, $field_label)
// {

//     $ci = &get_instance();
//     $ci->load->library('form_validation');


//     $data = array('field_name' => $field_value);
//     $ci->form_validation->set_data($data);
//     if ($is_required == 't') {
//         $ci->form_validation->set_rules('field_name', $field_label, 'required|min_length[' . $field_min_length .
//             ']|max_length[' . $field_max_length . ']|regex_match[' . VALIDATION_PREG_MATCH . ']');
//     } else {
//         $ci->form_validation->set_rules('field_name', $field_label, 'min_length[' . $field_min_length .
//             ']|max_length[' . $field_max_length . ']|regex_match[' . VALIDATION_PREG_MATCH . ']');
//     }

//     if ($ci->form_validation->run() == FALSE) {
//         return array('response' => false, 'msg' => $ci->form_validation->error_array('field_name'));
//     } else {
//         return array('response' => true);
//     }
// }

function validate_names($field_value, $is_required, $field_min_length, $field_max_length, $field_label)
{
    $validation = \Config\Services::validation();

    $rules = 'min_length[' . $field_min_length . ']|max_length[' . $field_max_length . ']|regex_match[' . VALIDATION_PREG_MATCH . ']';
    if ($is_required == 't') {
        $rules = 'required|' . $rules;
    }

    $data = ['field_name' => $field_value];
    $validation->setRules(['field_name' => [
        'label' => $field_label,
        'rules' => $rules
    ]]);

    if (!$validation->run($data)) {
        return ['response' => false, 'msg' => $validation->getErrors()];
    } else {
        return ['response' => true];
    }
}

function validate_names_for_cis_master(
    $field_value,
    $is_required,
    $field_min_length,
    $field_max_length,
    $field_label
) {

    $ci = &get_instance();
    $ci->load->library('form_validation');


    $data = array('field_name' => $field_value);
    $ci->form_validation->set_data($data);
    if ($is_required == 't') {
        $ci->form_validation->set_rules('field_name', $field_label, 'required|min_length[' . $field_min_length .
            ']|max_length[' . $field_max_length . ']|regex_match[/^[0-9a-zA-Z:,\/._\[\])@#&(; -]+$/]');
    } else {
        $ci->form_validation->set_rules('field_name', $field_label, 'min_length[' . $field_min_length .
            ']|max_length[' . $field_max_length . ']|regex_match[/^[0-9a-zA-Z:,\/._\[\])@#&(; -]+$/]');
    }

    if ($ci->form_validation->run() == FALSE) {
        return array('response' => false, 'msg' => $ci->form_validation->error_array('field_name'));
    } else {
        return array('response' => true);
    }
}

function validate_alphanumeric_with_space_n_spl_chars(
    $field_value,
    $is_required,
    $field_min_length,
    $field_max_length,
    $field_label
) {

    $ci = &get_instance();
    $ci->load->library('form_validation');

    $data = array('field_name' => $field_value);
    $ci->form_validation->set_data($data);
    if ($is_required == 't') {
        $ci->form_validation->set_rules('field_name', $field_label, 'required|min_length[' . $field_min_length .
            ']|max_length[' . $field_max_length . ']|regex_match[/^[A-z ]+$/]');
    } else {
        $ci->form_validation->set_rules('field_name', $field_label, 'min_length[' . $field_min_length .
            ']|max_length[' . $field_max_length . ']|regex_match[/^[A-z ]+$/]');
    }

    if ($ci->form_validation->run() == FALSE) {
        return array('response' => false, 'msg' => $ci->form_validation->error_array('field_name'));
    } else {
        return array('response' => true);
    }
}

function remark_preview($reg_id, $current_stage_id)
{
    // echo "Registration: ".$reg_id. 'and current stage:'. $current_stage_id;
    $Common_model = new CommonModel();
    $result_initial = $Common_model->get_intials_defects_remarks($reg_id, $current_stage_id);

    $result_icmis = $Common_model->get_cis_defects_remarks($reg_id, FALSE);

    $defects['pdfdefects'] = $Common_model->get_pdf_defects_remarks($reg_id);
    //echo "<pre>";    print_r($result_icmis); echo "</pre>";
    if (isset($result_icmis) && !empty($result_icmis)) {
        $msg = '<div class="alert table-responsive-sm"><div class="table-sec">
                    <div class="table-responsive">';
        $msg .= '<table id="datatable-defects" class="table table-striped custom-table"
                    cellspacing="0" width="100%">'
            . '<thead class="success">
                        <th>Mark Cured<br /><input type="checkbox" id="checkAll" /></th>
                        <th>#</th>
                        <th>Defect Description</th>
                        <th>Defect Remark</th>
                        <th>Prepare Dt.</th>
                        <th>Remove Dt.</th>
                        <th>Index Title</th>
                        <th>Defective Page No.</th>
                    </thead>'
            . '<tbody style="border-color: #ebccd1;background-color: #f2dede;color: #a94442;">';
        $i = 1;
        foreach ($result_icmis as $re) {
            $prep_dt = (isset($re['obj_prepare_date']) && !empty($re['obj_prepare_date'])) ? date(
                'd-M-Y H:i:s',
                strtotime($re['obj_prepare_date'])
            ) : null;
            $remove_dt = (isset($re['obj_removed_date']) && !empty($re['obj_removed_date'])) ? date('d-M-Y
                        H:i:s', strtotime($re['obj_removed_date'])) : null;
            $pspdfdocumentid = (isset($re['pspdfkit_document_id']) && !empty($re['pspdfkit_document_id'])) ?
                $re['pspdfkit_document_id'] : null;
            $aor_cured = (isset($re['aor_cured']) && !empty($re['aor_cured'])) ? $re['aor_cured'] : "f";
            $checked = "";
            $markdefectclass = "";
            if ($aor_cured == "t") {
                $checked = "checked";
                $markdefectclass = "curemarked";
            }

            $link_url = base_url('documentIndex?pspdfkitdocumentid=' . $pspdfdocumentid .
                '&tobemodifiedpagesraw=');
            $tobemodifiedpagesdisplay = (isset($re['to_be_modified_pspdfkit_document_pages_raw']) &&
                !empty($re['to_be_modified_pspdfkit_document_pages_raw'])) ?
                $re['to_be_modified_pspdfkit_document_pages_raw'] : null;
            $pdf_title = '';
            $pdf_pages_total = '';

            if ($pspdfdocumentid != null) {
                $pdf_info = $Common_model->getPdfInfo($pspdfdocumentid);
                if (!empty($pdf_info)) {
                    $pdf_title = $pdf_info->doc_title;
                    $pdf_pages_total = $pdf_info->page_no;
                }
            }
            $tobemodifiedpagesdisplaytext = '<span title="sequence no.s of (Total Pages)">' .
                $tobemodifiedpagesdisplay . ' of (' . $pdf_pages_total . '-pages)' . '</span>';
            $tobemodifiedpagesdisplaytextdisplay = (!empty($tobemodifiedpagesdisplay)) ?
                $tobemodifiedpagesdisplaytext : "";

            $msg .= '<tr id="row' . $re['id'] . '" class="' . $markdefectclass . '">';
            $msg .= '<td>' . '<input type="checkbox" ' . $checked . ' id="' . $re['id'] . '"
                                    onchange="setCuredDefect(this.id)">' . '</td>';
            $msg .= '<td>' . $i++ . '</td>';
            $msg .= '<td>' . escape_data($re['objdesc']) . '</td>';
            $msg .= '<td>' . escape_data($re['remarks']) . '</td>';
            $msg .= '<td>' . escape_data($prep_dt) . '</td>';
            $msg .= '<td>' . escape_data($remove_dt) . '</td>';
            $msg .= '<td>' . '<a href="' . $link_url . '">' . $pdf_title . '</span></a>' . '</td>';
            $msg .= '<td>' . $tobemodifiedpagesdisplaytextdisplay . '</td>';
            $msg .= '</tr>';
        }
        $msg .= '</tbody>
                </table>';
        $msg .= '</div>';

        if (!empty($defects['pdfdefects'])) {
            $connecter = '';
            $msg .= '<div>';
            $msg .= "<b>NOTE- You also have pdf defects mentioned in ";
            foreach ($defects['pdfdefects'] as $key => $val) {
                $msg .= $connecter . "1 file on pageno- " . implode(",", $val);
                $connecter = " AND ";
            }
            $msg .= '</b>';
            $msg .= '</div>';
        }
        $msg .= '</div>';
        $msg .= '</div>';
        $msg .= '<script type="text/javascript">';
        $msg .= '$(document).ready(function () {';

        $msg .= 'var oTable = $("#datatable-defects").dataTable();';

        $msg .= '$("#checkAll").change(function () {';
        $msg .= 'oTable.$("input[type=\'checkbox\']").prop("checked", $(this).prop("checked"));';
        $msg .= '});';
        $msg .= '});';
        $msg .= 'function setCuredDefect(id) {';
        $msg .= 'var CSRF_TOKEN_VALUE = $(\'[name="CSRF_TOKEN"]\').val();';
        $msg .= 'var value = $("#" + id).is(":checked"); ';
        $msg .= '$.ajax({';
        $msg .= 'type: \'POST\',';
        $msg .= 'url: \'' . base_url("documentIndex/Ajaxcalls/markCuredDefect") .
            '\',';
        $msg .= 'data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, objectionId: id, val:value},';
        $msg .= 'success: function () {';
        $msg .= '$("#row"+id).toggleClass("curemarked")';
        $msg .= '';
        $msg .= '},';
        $msg .= 'error: function () {alert("failed");}';
        $msg .= '});';
        $msg .= '}';
        $msg .= '
            </script>';
        $msg .= '<style>
            ';
        $msg .= '.curemarked {';
        $msg .= ' font-weight: bold; text-decoration: line-through;';
        $msg .= '}';
        $msg .= '
            </style>';


        return $msg;
        
    } elseif (isset($result_initial) && !empty($result_initial)) { 
        $msg = '<div class="alert" style="border-color: #ebccd1;background-color: #f2dede;color: #a94442;">';
        $msg .= '<p><strong>Defect Raised On : </strong>' . date(
            'd-m-Y H:i:s',
            strtotime($result_initial['defect_date'] ?? $result_initial['defect_date'] )
        ) . '
                <p>';
        $msg .= '
                <p><strong>Defects :</strong>
                <p>';
        $msg .= '
                <p>' . script_remove($result_initial['defect_remark'] ?? $result_initial['defect_remark']) . '
                <p>';
        if ($result_initial['defect_cured_date'] ?? $result_initial['defect_cured_date'] != NULL) {
            $msg .= '[
                <p] align="right"><strong>Defect Cured On : </strong>' . htmlentities(date(
                'd-m-Y H:i:s',
                strtotime($result_initial['defect_cured_date'])
            ), ENT_QUOTES) . '
                <p>';
        }

        $msg .= '
            </div>';
        return $msg;
    } else {
        return false;
    }
}

function encryptData($data)
{

    $iv = base64_decode('q83vmHZUMhCrze+YdlQyEA==');
    $key = base64_decode('VniUMhD97LpWeJQyEP3sug==');
    $plaintext = mcrypt_encrypt(
        MCRYPT_RIJNDAEL_128,
        $key,
        pkcs5_pad(json_encode($data), 16),
        MCRYPT_MODE_CBC,
        $iv
    );
    return base64_encode($plaintext);
}

function pkcs5_pad($text, $blocksize)
{

    $pad = $blocksize - (strlen($text) % $blocksize);
    return $text . str_repeat(chr($pad), $pad);
}

function decryptData($data)
{

    $key = pack('H*', "4133b1119985d9c3add0884d8cdd944c");
    $iv_dec = pack('H*', "3cf3cf3cf3cf3cf3cf3cf3cf3cf3cf3c");

    $ciphertext_dec = base64_decode($data);
    $plain_text = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
    $plain_text = trim($plain_text, "\0..\32");
    return $plain_text;
}

function curl_get_contents($url, $headers = [], $if_return_metadata = false)
{
    // Initiate the curl session
    $ch = curl_init();
    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $url);
    // Removes the headers from the output
    curl_setopt($ch, CURLOPT_HEADER, 0);
    // Return the output instead of displaying it directly
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // Execute the curl session
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ($headers ?: array('User-Agent: AutoBot')));

    $output = curl_exec($ch);

    if (!curl_errno($ch)) {
        $info = curl_getinfo($ch);
        $response_code = $info['http_code'];
    }
    // Close the curl session
    curl_close($ch);
    // Return the output as a variable
    if ($if_return_metadata) {
        return [$output, $response_code];
    }
    return $output;
}

function captcha_generate()
{
    // $ci = &get_instance();
    // $ci->load->library('session');
    $session = \Config\Services::session();
    $random_number = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
    $vals = array(
        'word' => $random_number,
        'img_path' => './captcha/',
        'img_url' => base_url('captcha/'),
        'font_path' => './path/to/fonts/texb.ttf',
        'img_width' => '120',
        'img_height' => 30,
        'expiration' => 7200,
        'word_length' => 20,
        'font_size' => 16,
        'img_id' => 'Imageid',
        'pool' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'colors' => array(
            'background' => array(255, 255, 255),
            'border' => array(255, 255, 255),
            'text' => array(0, 0, 0),
            // 'grid' => array(255, 40, 40)
        )
    );
    $captcha = create_captcha($vals);
    $session->set('captchaWord', $captcha['word']);
    return $captcha;
}

function captcha_generate2()
{
    // $ci = &get_instance();
    // $ci->load->library('session');
    $session = \Config\Services::session();
    $random_number = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
    $vals = array(
        'word' => $random_number,
        'img_path' => './captcha/',
        'img_url' => base_url('captcha/'),
        'font_path' => './path/to/fonts/texb.ttf',
        'img_width' => '120',
        'img_height' => 30,
        'expiration' => 7200,
        'word_length' => 20,
        'font_size' => 16,
        'img_id' => 'Imageid',
        'pool' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'colors' => array(
            'background' => array(255, 255, 255),
            'border' => array(255, 255, 255),
            'text' => array(0, 0, 0),
            //'grid' => array(255, 40, 40)
        )
    );
    $captcha2 = create_captcha($vals);
    $session->set('captchaWord2', $captcha2['word']);
    return $captcha2;
}

function epay_encrypt($data)
{

    $authKey = "0egmkz2pLIVi";

    $iv = "abcdef987654";

    if (VC_LIVESERVER == 'N') {
        $encrypt = openssl_encrypt(json_encode($data), 'AES-128-CBC', $authKey, 'OPENSSL_RAW_DATA', $iv);
    } else {
        $encrypt = openssl_encrypt(json_encode($data), 'AES-128-CBC', $authKey, OPENSSL_RAW_DATA, $iv);
    }
    $EncryptTxt = base64_encode($encrypt);

    return $EncryptTxt;
}

function help_id_url($url)
{
    return $url;
}

function nob(&$str)
{
    if (isset($str)) {
        $str = trim($str);
        if ($str == null || strtolower($str) == 'null' || $str == '')
            return true;
        else
            return false;
    } else {
        return true;
    }
}

function Notification($h, $d, $s, $t, $c, $ms, $jl)
{
    $h = '';
    $d = '';
    $s = '';
    $t = '';
    $c = '';
    $ms = 0;
    $jl = '';
    $h = $h;
    $d = $d;
    $s = $s;
    $t = $t;
    $c = $c;
    $ms = $ms;
    $jl = $jl;
}

function pingHost($host, $port, $timeOut)
{
    $notifyList = array();
    $fp = @fsockopen($host, $port, $errNo, $errStr, $timeOut);
    if (!is_resource($fp)) {
        $notifyList = Notification(
            'Sorry!',
            'We are unable to connect to <b>' . $host . ' @ ' . $port . '</b>.
            Please contact Computer Cell. [' . $errStr . '(' . $errNo . ')]',
            Status::ERROR,
            Type::BAR,
            Closeable::YES,
            0,
            ''
        );
        return false;
    } else {
        fclose($fp);
        return true;
    }
}

function doPushSms($mobileNos, $msg, $typeId, $roleIdCsv = '', $templateId = null)
{
    $myUserId = '1111';
    $myAccessId = '2222afafafasds';
    $statusFlag = 'all';
    $mnSplit = explode(',', $mobileNos);
    $mnBatch = array();
    $mnsKey = 0;
    $mnbKey = -1;
    $mnBatch[0] = '';
    foreach ($mnSplit as $mnsKey => $value) {
        if (($mnsKey % 50) == 0) {
            $mnbKey++;
            $mnBatch[$mnbKey] = '';
        }
        if (!nob($value)) {
            $mnBatch[$mnbKey] .= trim($value) . ',';
        }
    }
    foreach ($mnBatch as $mn) {
        try {
            if (pingHost('10.25.78.96', '80', 3)) {
                $mn = rtrim($mn, ",");
                $surl = 'http://10.25.78.96/sms_api/request.php?mobileno=' . $mn . '&smstext=' . rawurlencode($msg .
                    (empty($templateId) ? ' - SUPREME COURT OF INDIA' : '')) . '&rcode=16314056735530425746246&tid=' .
                    ($templateId ?: 1107161579081748207);
                $surlResponse = @file_get_contents($surl);
                echo $surlResponse;
                exit();
                //echo 'Template Id: '.($templateId ?: 1107161243622980738).'<br>';
                //echo 'Mobile Numbers:'.$mn.'<br>';
                //echo 'Message:'.$msg.'<br>';
                //echo $surl.'<br>';
                //echo 'Response:'.$surlResponse.'<br><br>';
                if (strpos(strtolower($surlResponse), 'accepted') !== false) {
                    //if($this->startsWith($surlResponse,'200')){
                    //if (true) {
                    $query = 'insert into eadmin.t_sms_logs (type_id,mobile_nos,message,by_user_id,access_id) values
            (?,?,?,?,?)';
                    $qv = array($typeId, $mn, $msg, $myUserId, $myAccessId);
                    //$this->pushSingle(1, $qv, '', '', '', '', '');
                } else {
                    $statusFlag = 'some';
                }
            } else {
                $statusFlag = 'none';
            }
        } catch (Exception $e) {
        }
        sleep(0.5);
    }
    /*
            if($this->isNewInstance){
            $this->finish();
            }*/
    return $statusFlag;
}
function sendSMS($typeId = "38", $mobileNo = "", $smsText = "", $templateId = "")
{
    if (
        isset($_SESSION['last_sms_ip']) && $_SESSION['last_sms'] + SMS_RESEND_LIMIT > time() &&
        $_SESSION['last_sms_template'] == $templateId && $_SESSION['last_sms_ip'] == get_client_ip()
    ) {
        die('Please wait ' . SMS_RESEND_LIMIT . ' seconds and then try again.'); // code to stop sms flooding
    } else {
        $_SESSION['last_sms'] = time();
        $_SESSION['last_sms_template'] = $templateId;
        $_SESSION['last_sms_ip'] = get_client_ip();

        if (trim($mobileNo) == "") {
            return "Blank Mobile No.";
        }
        date_default_timezone_set('Asia/Kolkata');
        $sms_url = EADMINSCI_URI . '/a-push-sms-gw?mobileNos=' . $mobileNo . '&message=' . rawurlencode($smsText) .
            '&typeId=' . $typeId . '&templateId=' . $templateId .
            '&myUserId=NIC001001&myAccessId=root&authCod=sldkfjsklf126534__sdgdg-sf154ncvbvziu789asdsagd1235';
        $sms_response = @file_get_contents($sms_url);
        //print_r($sms_response);
        $json = json_decode($sms_response);
        // echo '<pre>Hello_'; print_r($json); die();
        if (!empty($json) && $json->{'responseFlag'} == "success") {
            //return "success";
            $rslt_sms = "success";
        } else {
            //return "error";
            $rslt_sms = "error";
        }
        if (!$sms_response) {
            $sms_response = NULL;
        }

        if ($rslt_sms != '') {
            if (isset($_SESSION['efiling_details']['registration_id']) && isset($_SESSION['login']['id'])) {
                $registrationId = $_SESSION['efiling_details']['registration_id'];
                $created_byId = $_SESSION['login']['id'];
            } else if (isset($_SESSION['login']['id'])) {
                $registrationId = NULL;
                $created_byId = $_SESSION['login']['id'];
            } else {
                $registrationId = NULL;
                $created_byId = NULL;
            }
            if ($rslt_sms == 'success') {
                $staus = TRUE;
            } else {
                $staus = FALSE;
            }
            $efiling_sms_details = array(
                'mobile_no' => $mobileNo,
                'msg' => $smsText,
                'type_id' => $typeId,
                'sent_on' => date('Y-m-d H:i:s'),
                'sms_get_status' => $sms_response,
                'status' => $staus,
                'registration_id' => $registrationId,
                'created_by' => $created_byId
            );
            // $ci = &get_instance();
            // $ci->load->model('common/Common_model');
            // $ci->load->library('session');
            $common_model = new \App\Models\Common\CommonModel();
            $db_response_sms = $common_model->insert_efiling_sms_dtl($efiling_sms_details);
            return $rslt_sms;
        } //end of if condition $rslt_sms..
    }
}

function send_otp($text, $type_id = 38, $send_otp_mail = 0, $control_flag = 0)
{
    // 09/11/2020
    // $otp=get_new_captcha();
    $digit = 6;
    $otp = numericOTP($digit);
    date_default_timezone_set('Asia/Kolkata');
    $time1 = date("H:i");
    $endTime = date("H:i", strtotime('+15 minutes', strtotime($time1)));
    $mobile = $_SESSION['login']['mobile_number'];
    // $smsText="OTP for ".$text." is ".$otp['word']." and is valid till ".$endTime.". Do not share the OTP with anyone.";
    $smsText = "OTP for " . $text . " is " . $otp . " and is valid till " . $endTime . ". Do not share the OTP with anyone. - Supreme Court of India";
    if ($control_flag == 1)
        sendSMS(38, $mobile, $smsText, SCISMS_Ementioning_OTP);
    else
        sendSMS($type_id, $mobile, $smsText, SCISMS_Ementioning_OTP);

    if ($send_otp_mail)
        send_mail_msg($_SESSION['login']['emailid'], $text . ' OTP', $smsText, '');
    $otp_details = array(
        'type_id' => $type_id,
        'mobile' => $mobile,
        'sms_text' => $smsText,
        'updated_on' => date('Y-m-d H:i:s'),
        'updated_by' => $_SESSION['login']['id'],
        'updated_by_ip' => $_SERVER['REMOTE_ADDR'],
        'tbl_efiling_num_id' => $_SESSION['efiling_details']['registration_id'],
        //        'captcha'=>$otp['word'],
        'captcha' => $otp,
        'start_time' => date('H:i:s'),
        'end_time' => $endTime,
        'validate_status' => 'A'
    );
    // $ci = &get_instance();
    // $ci->load->model('common/Common_model');
    // $ci->load->library('session');
    $Common_model = new CommonModel();
    $db_response = $Common_model->insert_otp($otp_details);
    if (!$db_response)
        echo "2@@@Some Error ! Please try after some time.";
    //    else
    //        echo $otp;exit;
}

function resend_otp($type_id, $text, $send_otp_mail = 0)
{
    date_default_timezone_set('Asia/Kolkata');
    $time1 = date("H:i");
    $endTime = date("H:i", strtotime('+15 minutes', strtotime($time1)));
    $updated_by = $_SESSION['login']['id'];
    $mobile = $_SESSION['login']['mobile_number'];
    $efiling_num = $_SESSION['efiling_details']['registration_id'];
    // $ci = &get_instance();
    // $ci->load->model('common/Common_model');
    // $ci->load->library('session');
    $Common_model = new CommonModel();
    $otp_data = $Common_model->get_otp_details($type_id, $updated_by, $mobile, $efiling_num);
    if ($time1 >= $otp_data[0]['end_time']) {
        $response = $Common_model->update_otp_details($type_id, $updated_by, $mobile, $efiling_num, 'E');
        if ($response)
            send_otp($type_id, $text, $send_otp_mail);
    } else {
        $sms_text = $otp_data[0]['sms_text'];
        sendSMS($type_id, $mobile, $sms_text);
    }
}

function validate_otp($type_id, $otp)
{
    $updated_by = $_SESSION['login']['id'];
    $mobile = $_SESSION['login']['mobile_number'];
    $efiling_num = $_SESSION['efiling_details']['registration_id'];
    date_default_timezone_set('Asia/Kolkata');
    $time1 = date("H:i");
    // $ci = &get_instance();
    // $ci->load->model('common/Common_model');
    // $ci->load->library('session');
    $Common_model = new CommonModel();
    $otp_data = $Common_model->get_otp_details($type_id, $updated_by, $mobile, $efiling_num);
    if ($time1 > $otp_data[0]['end_time'])
        return false;
    else {
        if ($otp_data[0]['captcha'] == $otp) {
            $response = $Common_model->update_otp_details($type_id, $updated_by, $mobile, $efiling_num, 'V');
            return true;
        } else if ($otp_data[0]['captcha'] != $otp)
            return false;
    }
}

function showEfilingData($request = [])
{ //todo:sync this function to development branch
    $diaryIds = null;
    $advocateIds = null;
    $documentTypes = null;
    $filingDateRange = null;
    $pendingFilingStages = null;
    //pendingfilingstage is breadcrumbs(1-7) value and documenttype is ia4/miscdoc2/case1/deficitcourtfee3/--not give mentioning8
    extract($request ?: $_GET);
    $data = array();
    $error = array();
    $warning = array();
    $data['errors'] = $error;
    $data['warnings'] = $warning;
    // $ci = &get_instance();
    // $ci->load->model('common/Common_model');
    $Common_model = new CommonModel();
    $details = $Common_model->showEfilingData($advocateIds, $filingDateRange, $pendingFilingStages, $documentTypes, $diaryIds);
    if (count($details)) {
        /* for($i=0;$i<count($details);$i++) {
            // echo "Status   ".$details[$i]['breadcrumb_status'];
         }*/

        $data['data'] = $details;
    }
    return json_encode($data);
}

function showEfiledDocuments($diaryNos)
{
    $data = array();
    // $ci = &get_instance();
    // $ci->load->model('common/Common_model');
    $Common_model = new CommonModel();
    $details = $Common_model->showEfilingDocuments($diaryNos);
    $data['data'] = $details;
    echo json_encode($data);
}

function mentioningRequests()
{
    $diaryIds = null;
    $advocateIds = null;
    $filingDateRange = null;
    $status = null;
    //status is approval status A:accepted R:rejected P:pending for decision
    extract($_GET);
    $data = array();
    $error = array();
    $warning = array();
    $data['errors'] = $error;
    $data['warnings'] = $warning;
    // $ci = &get_instance();
    // $ci->load->model('common/Common_model');
    $Common_model = new CommonModel();
    $details = $Common_model->mentioningRequests($advocateIds, $filingDateRange, $status, $diaryIds);
    if (count($details)) {
        $data['data'] = $details;
    }
    echo json_encode($data);
}

function converDateRangeTodmY($dateRange)
{
    $result = array();
    $dates = explode(',', str_replace(')', '', str_replace('[', '', $dateRange)));
    foreach ($dates as $date) {
        array_push($result, date("d-m-Y", strtotime($date)));
    }
    return $result;
}

function generate_qr_code($params)
{
    $fgc_context = array(
        'http' => array(
            'user_agent' => 'Mozilla',
        ),
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
        ),
    );
    return json_decode(file_get_contents((COURT_ASSIST_URI . '/qr_code/generate?' . http_build_query($params)), false, stream_context_create($fgc_context)));
}

function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function getJournalName($key)
{
    $journalMaster = '{"1":"AIR","2":"SCR","3":"SCC","4":"JT","5":"SC"}';
    $jsonArray = json_decode($journalMaster, true);
    return $jsonArray[$key];
}

function is_logged_in()
{
    return (isset($_SESSION['login']) && !empty($_SESSION['login']));
}

function is_recaptcha_valid($token)
{
    return true; //TODO:: Remove when go live
    try {
        $validation_result = @json_decode(@file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, stream_context_create(array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query(array(
                    'response' => $token,
                    'secret' => '6LfE13AUAAAAAMic08Z-XTyBFIYxMNtQ31l0Th2G'
                )),
            ),
        ))));
        if (count($validation_result) > 0) {
            if ($validation_result->success) {
                if ($validation_result->score >= 0.5) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    } catch (Exception $e) {
    }

    return false;
}

function curl_post_contents($url, $params)
{
    // Initiate the curl session
    $ch = curl_init();
    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, count($params));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    // Removes the headers from the output
    curl_setopt($ch, CURLOPT_HEADER, 0);
    // Return the output instead of displaying it directly
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // Execute the curl session
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: AutoBot',));

    $output = curl_exec($ch);
    // Close the curl session
    curl_close($ch);
    // Return the output as a variable
    return $output;
}

function curl_request($url, $data, $isJson = 'false', $method = "POST", $token = '')
{
    $curl = curl_init();
    if ($isJson)
        $content = 'Content-Type:application/json';
    else
        $content = "Content-Type: text/plain";

    if (!empty($token))
        $token = "Authorization: Bearer $token";

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => array($content, $token),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function get_challanged_sc_base_case_details($registration_id)
{
    // get the lower court diary no of the base case

    $Get_details_model = new GetDetailsModel();

    $base_disposed_cases = $Get_details_model->get_subordinate_court_details($registration_id);
    $lower_court_type = $base_disposed_cases[0]['court_type'];
    $subject_category = null;
    $subcode1 = null;
    if ($lower_court_type == 4)  //court type=4 belongs to supreme court
    {
        $case_type_id = $base_disposed_cases[0]['case_type_id'];
        $case_no = $base_disposed_cases[0]['case_num'];
        $case_year = $base_disposed_cases[0]['case_year'];
        $case_data = json_decode(curl_get_contents(ICMIS_SERVICE_URL . "/ConsumedData/caseDetails/?searchBy=C&caseTypeId=$case_type_id&caseNo=$case_no&caseYear=$case_year"));
        $case_data = $case_data->case_details[0];
        $base_disposed_case_diary_no = $case_data->diary_no . $case_data->diary_year;

        // get the submaster id of the base case
        $base_case_subject_category_details = json_decode(file_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/getCaseDetails?diaryNo=' . $base_disposed_case_diary_no))->details;
        //var_dump($base_case_subject_category_details);

        $subject_category = $base_case_subject_category_details[0]->submaster_id;
        $subcode1 = $base_case_subject_category_details[0]->subcode1;
        $sc_case_type_id = $case_type_id;
    }
    return array('subject_category' => $subject_category, 'subcode1' => $subcode1, 'case_type_id' => $sc_case_type_id, 'lower_court_type' => $lower_court_type);
}

function calculate_court_fee($registration_id = null, $request_type = null, $within_or_outside_delhi_status_for_affidavit = null, $subject_category_1802_status = null, $is_affidavit_in_form_of_reply_flag = null)
{
    $Common_model = new CommonModel();
    $Get_details_model = new GetDetailsModel();

    $total_court_fee = 0;

    $if_sclsc = (!empty(getSessionData('efiling_details')['if_sclsc']) && (getSessionData('efiling_details')['if_sclsc'] == 1)) ? getSessionData('efiling_details')['if_sclsc'] : 0; //Code added for to make 0 court fee for SCLSC cases on 25072023 by Anshu and KBP
    if (!empty(getSessionData('efiling_details')['if_sclsc']) && (getSessionData('efiling_details')['if_sclsc'] == 1)) {
        $total_court_fee = 0;
        return $total_court_fee;
    } else {
        if (empty($registration_id))
            $registration_id = getSessionData('efiling_details')['registration_id'];
        else
            $registration_id = $registration_id;

        //echo $registration_id;


        if (!empty($registration_id)) {
            $court_fee_calculation_param1 = $Common_model->get_subject_category_casetype_court_fee($registration_id);
            $court_fee_calculation_param3 = $Common_model->get_ia_or_misc_doc_court_fee($registration_id, null, null);
            if (!empty($court_fee_calculation_param3)) {
                $all_added_docs_and_ias = array_column($court_fee_calculation_param3, 'doccode');
            } else {
                $all_added_docs_and_ias = array('doccode');
            }

            if (in_array(getSessionData('efiling_details')['ref_m_efiled_type_id'], array(E_FILING_TYPE_NEW_CASE, E_FILING_TYPE_CAVEAT))) {
                $base_disposed_cases = $Get_details_model->get_subordinate_court_details($registration_id);
                $lower_court_type = !empty($base_disposed_cases) ? $base_disposed_cases[0]['court_type'] : '';
                $lower_court_case_type_id = !empty($base_disposed_cases) ? $base_disposed_cases[0]['case_type_id'] : '';
                $establishment_code = !empty($base_disposed_cases) ? $base_disposed_cases[0]['estab_code'] : '';
            } else {
                $base_disposed_cases = '';
                $lower_court_type = 0;
                $lower_court_case_type_id = 0;
                $establishment_code = 0;
            }
            
            $sc_case_type_id = $court_fee_calculation_param1[0]['sc_case_type_id'] ?? '';
            $case_nature = $court_fee_calculation_param1[0]['nature'] ?? '';
            if ($request_type == '1') {
                if ($sc_case_type_id == 19) {
                    $case_nature = 'R'; //if the contempt petition casetype is selected then it can be treated as criminal matters thus no doc fees will be applicable
                }
                //var_dump($court_fee_calculation_param1);
                if (!empty($court_fee_calculation_param1)) {
                    $no_of_lower_court_order_challanged = $court_fee_calculation_param1[0]['order_challanged'];

                    if ($case_nature == 'C') // court fee only applicable for civil matters and 0 for criminal matter based on its casetype
                    {
                        if ($court_fee_calculation_param1[0]['sc_case_type_id'] == '9' || $court_fee_calculation_param1[0]['sc_case_type_id'] == '25') // MA removed from the above condition on 17-07-2023 by KBPUJARI
                        // for Review Petition , Curative Petition and MA : Court Fee is to be paid same as having paid in the Main/base Matter
                        {
                            //|| ($court_fee_calculation_param1[0]['sc_case_type_id']=='19' && $lower_court_type!=4)
                            $base_case_subject_category_details = get_challanged_sc_base_case_details($registration_id);

                            $subject_category = $base_case_subject_category_details['submaster_id'];
                            $subcode1 = $base_case_subject_category_details['subcode1'];
                            $sc_case_type_id = $base_case_subject_category_details['case_type_id'];
                        } else {
                            $subject_category = $court_fee_calculation_param1[0]['subject_cat']; //submaster id
                            $subcode1 = $court_fee_calculation_param1[0]['subcode1'];
                            $sc_case_type_id = $court_fee_calculation_param1[0]['sc_case_type_id'];
                        }

                        //echo $subject_category.'#'.$subcode1.'#'.$sc_case_type_id;
                        $court_fee_helper_flag = $court_fee_calculation_param1[0]['court_fee_calculation_helper_flag'];
                        $case_total_petitioners = $court_fee_calculation_param1[0]['total_petitioners'];

                        //subject category condition:start
                        //var_dump($court_fee_calculation_param1);
                        if ($subcode1 == '8' && $sc_case_type_id != '7' && $sc_case_type_id != '23' && $sc_case_type_id != '24' && $sc_case_type_id != '1' && $sc_case_type_id != '3') // for Letter Petition & Pil Matters:130(except submaster id:133) court fee will fixed as 500 * no of petitioners filing the matters. changed on 26/04/2021
                        {
                            if ($subject_category != '133') {
                                $total_court_fee = 500 * (int)$case_total_petitioners;
                            } else
                                $total_court_fee = (int)$total_court_fee + 1500;
                        } elseif ($sc_case_type_id == '1') //SLP
                        {
                            if ($subcode1 == '8' || $lower_court_case_type_id == '5' || $lower_court_case_type_id == '7' || $establishment_code == 'NCDRC') {
                                $total_court_fee = 1500 * (int)$no_of_lower_court_order_challanged;
                            } elseif ($establishment_code == 'NCDRC') {
                                $total_court_fee = 5000;
                            } elseif ($lower_court_case_type_id == '19' && $lower_court_type == 4) // if lowercourt casetype is contempt petition and lowercourt is supreme court then 0 court fee will be charged
                            {
                                $total_court_fee = 0;
                            } else {
                                $total_court_fee = (int)$total_court_fee + $court_fee_calculation_param1[0]['court_fee'];
                            }
                        } elseif ($sc_case_type_id == '3') //civil appeal
                        {

                            if ($establishment_code == 'NGTD' || $establishment_code == 'AFT') //490506=Natioan green tribunal , 226817=Armed force tribunal
                            {
                                $total_court_fee = 1500;
                            } elseif ($establishment_code == 'NCDRC') {
                                $total_court_fee = 5000;
                            } else {
                                $total_court_fee = (int)$total_court_fee + 5000;
                            }
                        } elseif ($sc_case_type_id == '23') // election petition
                        {
                            $total_court_fee = (int)$total_court_fee + 20000;
                        } elseif ($sc_case_type_id == '24') // arbitration petition
                        {
                            $total_court_fee = (int)$total_court_fee + 5000;
                        } elseif ($sc_case_type_id == '5') // writ petition
                        {
                            $total_court_fee = 500 * (int)$case_total_petitioners;
                        } elseif ($sc_case_type_id == '7') // for the casetype-Transfer Petition - if matrimonial then 500 else 2500 court fee will be charged . subject category court fee will not be applicable in the above case as well as for the subject category 1802. Changes done on 16/06/2021.
                        {
                            if ($court_fee_helper_flag == 'Y')
                                $total_court_fee = (int)$total_court_fee + 500; // 500 for matrimonial case
                            else
                                $total_court_fee = (int)$total_court_fee + 2500;
                        } elseif ($sc_case_type_id == '19')  // 0 court fee will be applicable for the Contempt petition (Civil) nature cases - self case of supreme court
                        {
                            //if($lower_court_type=='4')
                            $total_court_fee = 0;
                        } elseif ($sc_case_type_id == '39')  // 100 court fee will be applicable for the MA added by kbp on 17072023
                        {
                            $total_court_fee = 100;
                        } else {
                            switch ($subject_category) {
                                case '133': {
                                        $total_court_fee = (int)$total_court_fee + 1500;
                                        break;
                                    } //letter petition special category: SLPs filed against judgments / orders passed by the High Courts in Writ Petitions filed as PIL
                                case '134': {
                                        $total_court_fee = (int)$total_court_fee + 20000;
                                        break;
                                    } // eletion matter :Matters challenging election of President & Vice-President of India
                                case '144': {
                                        $total_court_fee = (int)$total_court_fee + 20000;
                                        break;
                                    } // election matter : Appeals u/s 116 A of Representation of People Act, 1951.
                                case '222': { // Ordinary Civil Matters : T.P. Under Section 25 of the C.P.C.
                                        if ($court_fee_helper_flag == 'Y')
                                            $total_court_fee = (int)$total_court_fee + 500; // 500 for matrimonial case
                                        else
                                            $total_court_fee = (int)$total_court_fee + 2500;
                                        break;
                                    }
                                case '164': { //for the subject category "HABEAS CORPUS MATTERS" : Nature of the Matter will be Criminal Only so the court fee will be 0.if it is file as civil then the court fee will be calculated as:( changes done on 26/04/21)
                                        if ($sc_case_type_id == '5')
                                            $total_court_fee = (int)$total_court_fee + 500;
                                        else
                                            $total_court_fee = (int)$total_court_fee + 1500;
                                        break;
                                    }
                                case '200': {
                                        $total_court_fee = (int)$total_court_fee + 5000;
                                        break;
                                    } //Appeal Against Orders Of Statutory Bodies:Bar Council of India
                                case '224': {
                                        $total_court_fee = (int)$total_court_fee + 2500;
                                        break;
                                    } //Ordinary Civil Matters:Original Civil Suit under Article 131 of the Constitution of India
                                case '298': {
                                        $total_court_fee = (int)$total_court_fee + 5000;
                                        break;
                                    } //Matters Relating To Consumer Protection
                                default: {
                                        $total_court_fee = (int)$total_court_fee + $court_fee_calculation_param1[0]['court_fee'];
                                        break;
                                    }
                            }
                        }

                        // no_of_lower_court_order_challanged
                        if ($no_of_lower_court_order_challanged > 0 && $sc_case_type_id != '5' && $subcode1 != '8') {
                            $total_court_fee = (int)$total_court_fee * (int)$no_of_lower_court_order_challanged;
                        }

                        // vakalatnama condition - start
                        //if vakalatnama added from indexing then defualt one will not applicable
                        if (!in_array('12', $all_added_docs_and_ias) && !in_array('13', $all_added_docs_and_ias)) {
                            if ($sc_case_type_id != 39) {
                                $court_fee_calculation_param2 = $Common_model->get_ia_or_misc_doc_court_fee(null, 12, 0);
                                if ($case_nature == 'C') {
                                    if ($sc_case_type_id == '5')  // for writ petition
                                    {
                                        $total_court_fee = (int)$total_court_fee + (int)$court_fee_calculation_param2[0]['docfee'] * (int)$case_total_petitioners;
                                    } else {
                                        if ($no_of_lower_court_order_challanged > 0) {
                                            $total_court_fee = (int)$total_court_fee + (int)$court_fee_calculation_param2[0]['docfee'] * (int)$no_of_lower_court_order_challanged;
                                        } else {
                                            $total_court_fee = $total_court_fee + (int)$court_fee_calculation_param2[0]['docfee'];
                                        }
                                    }
                                }
                            }
                        }
                        //vakalatnama condition - end
                    }
                }
            }

            if ($request_type == '2') // IA & Misc. doc fees
            {
                $court_fee_calculation_param3 = $Common_model->get_ia_or_misc_doc_court_fee($registration_id, null, null); // retrieve the court fee
                $diary_no = !empty($court_fee_calculation_param3) ? (int)$court_fee_calculation_param3[0]['diary_no'] . (int)$court_fee_calculation_param3[0]['diary_year'] : '';
                //uncheck the following line:when we further check the case nature based on ICMIS -main table case:case_group
                /*if (empty($diary_no) || $diary_no == 00) {
                    $diary_no = (int)$court_fee_calculation_param3[0]['sc_diary_num'] . (int)$court_fee_calculation_param3[0]['sc_diary_year'];
                }*/

                if (empty($case_nature)) {
                    $case_nature = $court_fee_calculation_param1[0]['nature'] ?? '';
                }
                if (empty($case_nature)) {
                    $case_nature = file_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/caseNature?diaryNo=' . $diary_no);
                }

                //uncheck the following line:when we require to further check the case nature based on ICMIS -main table case:case_group
                /*$case_nature_from_icmis = file_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/caseNature?diaryNo=' . $diary_no);
                echo 'For Diary : ' . $diary_no . ', From efiling' . $case_nature . ' from ICMIS:' . $case_nature_from_icmis;
                if ($case_nature_from_icmis == 'R') {
                    $case_nature = 'R';
                }*/
                //Code added by kbpujari as on 08052024 for checking the case nature based on selected subject category
                $case_nature_from_icmis = getCaseDetailsWithNatureBasedOnSubjectCategory($registration_id);
                if ($case_nature_from_icmis == 'R') {
                    $case_nature = 'R';
                }

                //TODO code for getting details of SC case nature which entry is done as lower court case if :done by kbp on 08122023
                if ($case_nature == 'C' || empty($case_nature)) {
                    //echo ICMIS_SERVICE_URL . '/ConsumedData/getCaseLowerCtDetailsWithCaseNature?diary_no'.$diary_no;exit();
                    $case_lct_details = file_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/getCaseLowerCtDetailsWithCaseNature?diary_no=' . $diary_no);
                    $case_lct_details = $case_lct_details ? json_decode($case_lct_details) : null;
                    if (!empty($case_lct_details[0]->base_case_catetype_id)) {
                        if ($case_lct_details[0]->base_case_catetype_id == 39); // Condition will be checked only for MA cases(i.e casetype id : 39)
                        {
                            $ma_lower_case_case_group = ($case_lct_details[0]->lct_case_case_grp) ? $case_lct_details[0]->lct_case_case_grp : null;
                            if ($ma_lower_case_case_group == 'R')
                                $case_nature = 'R';
                        }
                    }
                }
                if ($sc_case_type_id == 19) {
                    $case_nature = 'R'; //if the contempt petition casetype is selected then it can be treated as criminal matters thus no doc fees will be applicable
                }


                //echo $case_nature.'#'.getSessionData('efiling_details')['ref_m_efiled_type_id'];

                if (!empty($court_fee_calculation_param1) || getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_IA || getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_MISC_DOCS || getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_CAVEAT || getSessionData('efiling_details')['ref_m_efiled_type_id'] == OLD_CASES_REFILING) {
                    if (getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_CAVEAT) {
                        $arr = array();
                        $arr['registration_id'] = $registration_id;
                        $arr['step'] = 6;
                        $caveat_details = $Common_model->getCaveatDataByRegistrationId($arr);
                        if (!empty($caveat_details[0]))
                            $case_nature = $caveat_details[0]['nature'];
                    }

                    if (($case_nature == 'C' && getSessionData('efiling_details')['ref_m_efiled_type_id'] != E_FILING_TYPE_CAVEAT && getSessionData('efiling_details')['ref_m_efiled_type_id'] != E_FILING_TYPE_IA) || ($case_nature == 'C' && getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_IA) || ($case_nature == 'C' && getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_CAVEAT) || ($case_nature == 'C' && getSessionData('efiling_details')['ref_m_efiled_type_id'] == OLD_CASES_REFILING) && $sc_case_type_id != '19') // CHNAGE BY KBPUJARI ON 28062023 TO MAKE 0 COURT FEE FOR THE CAVEAT FILING IF THE CASE TYPE IS SELECTED AS CRIMINAL
                    //if($case_nature == 'C' || getSessionData('efiling_details')['ref_m_efiled_type_id']==4 || getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_CAVEAT && $sc_case_type_id!='19') // court fee only applicable for civil matters and 0 for criminal matter based on its casetype
                    {
                        $no_of_lower_court_order_challanged_for_caveat = !empty($court_fee_calculation_param3) ? $court_fee_calculation_param3[0]['trial_court_order_challanged_for_caveat'] : '';
                        //var_dump($court_fee_calculation_param3);
                        if (is_array($court_fee_calculation_param3)) {
                            foreach ($court_fee_calculation_param3 as $row) {
                                $doc = (int)$row['doccode'] . (int)$row['doccode1'];
                                $no_of_affidavit_copies = $row['no_of_affidavit_copies'];
                                $doc_list_with_letter_of_inspection_file = array(150); // Doc:letter
                                $doc_list_no_of_non_party_appellant = array(895);
                                $doc_list_with_affidavit = array(20, 50, 190); //Doc:REPLY,REPORT and ADDITIONAL DOCUMENT
                                $doc_list_of_affidavit_attested_place = array(30, 60, 90, 110, 170, 220); //REJOINDER AFFIDAVIT,COUNTER AFFIDAVIT,ADDITIONAL AFFIDAVIT,AFFIDAVIT,AFFIDAVIT OF SERVICE and AFFIDAVIT OF UNDERTAKING
                                $doc_list_for_per_petition_calculation = array(84); //Doc:LEGAL HEIRS TO BE BROUGHT ON RECORD
                                $doc_list_for_per_lower_court_order_challanged_number = array(85, 86, 87, 817, 120, 827, 828, 829, 830, 831, 835, 8328, 130); //Doc:INTERVENTION APPLICATION,ADDITION / DELETION / MODIFICATION  PARTIES,AMENDMENT IN RECORD,EXEMPTION FROM FILING C/C OF THE IMPUGNED JUDGMENT,VAKALATNAMA,STAY APPLICATION,CONDONATION OF DELAY IN FILING,APPLICATION FOR SUBSTITUTION,SETTING ASIDE AN ABATEMENT,COMPROMISE R.3 O.23,DISPENSING WITH SERVICE OF notice,PERMISSION TO FILE PETITION (SLP/TP/WP/..),EXEMPTION FROM FILING TRIAL COURT order and VAKALATNAMA AND MEMO OF APPEARANCE
                                $doc_list_of_zero_doc_fee_for_criminal_matter = array(842, 8120, 8137, 8144, 8152, 8153, 8160, 8252, 8271, 8302, 8324, 8346, 8368, 8385);

                                if (in_array((int)$doc, $doc_list_with_affidavit, TRUE)) {
                                    if ($row['court_fee_calculation_helper_flag'] == 'Y') //DOC submit with Affidavit flag updated from
                                        $total_court_fee = (int)$total_court_fee + (int)$row['docfee'];
                                    else
                                        $total_court_fee = (int)$total_court_fee + 0;
                                } elseif (in_array((int)$doc, $doc_list_of_affidavit_attested_place, TRUE)) {
                                    /*if($row['court_fee_calculation_helper_flag']=='Y') //DOC submit with Affidavit attested within Delhi
                                        $total_court_fee=(int)$total_court_fee+(int)$row['docfee'];
                                    else
                                        $total_court_fee=(int)$total_court_fee+0;*/

                                    if ($doc == '11' && $sc_case_type_id == '19')  //For Affidavit 0 court fee will be applicable for the Affidavit id - Contempt petition (Civil) nature cases                            {
                                        $total_court_fee = 0;
                                    else {
                                        if ($no_of_affidavit_copies > 0) {
                                            $total_court_fee = (int)$total_court_fee + (int)$row['docfee'] * $no_of_affidavit_copies;
                                        } else {
                                            $total_court_fee = $total_court_fee + (int)$row['docfee'];
                                        }
                                    }
                                } elseif (in_array((int)$doc, $doc_list_with_letter_of_inspection_file, TRUE)) {
                                    if ($row['court_fee_calculation_helper_flag'] == 'Y') //DOC submit with Affidavit flag updated from
                                        $total_court_fee = (int)$total_court_fee + (int)$row['docfee'];
                                    else
                                        $total_court_fee = (int)$total_court_fee + 0;
                                } elseif (in_array((int)$doc, $doc_list_for_per_petition_calculation, TRUE)) {
                                    $total_court_fee = $total_court_fee + (int)$row['docfee'] * (int)$row['total_petitioners'];
                                } elseif (in_array((int)$doc, $doc_list_for_per_lower_court_order_challanged_number, TRUE)) {
                                    if ($row['order_challanged'] > 0) {
                                        $total_court_fee = (int)$total_court_fee + (int)$row['docfee'] * (int)$row['order_challanged'];
                                    } else {
                                        $total_court_fee = (int)$total_court_fee + (int)$row['docfee'];
                                    }
                                } elseif (in_array((int)$doc, $doc_list_of_zero_doc_fee_for_criminal_matter, TRUE)) {
                                    if ($case_nature == 'C') //these documents fee only applicable for civil matters
                                        $total_court_fee = (int)$total_court_fee + (int)$row['docfee'];
                                    else
                                        $total_court_fee = (int)$total_court_fee + 0;
                                } elseif (in_array((int)$doc, $doc_list_no_of_non_party_appellant, TRUE)) {
                                    if ($case_nature == 'C') {
                                        if ((int)$row['no_of_petitioner_appellant'] > 0) {
                                            $total_court_fee = (int)$total_court_fee + (int)$row['docfee'] * (int)$row['no_of_petitioner_appellant'];
                                        } else {
                                            $total_court_fee = (int)$total_court_fee + (int)$row['docfee'];
                                        }
                                    } else
                                        $total_court_fee = (int)$total_court_fee + 0;
                                } else {

                                    $total_court_fee = (int)$total_court_fee + (int)$row['docfee'];
                                }
                            }
                        }

                        if (getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_CAVEAT) {
                            $court_fee_calculation_param2 = $Common_model->get_ia_or_misc_doc_court_fee(null, 12, 0); //vakalatnama will be automatically added with caveat and multiple of each lower court order challanged
                            if ($no_of_lower_court_order_challanged_for_caveat > 0) {
                                $total_court_fee = (int)$total_court_fee + (int)$court_fee_calculation_param2[0]['docfee'] * (int)$no_of_lower_court_order_challanged_for_caveat;
                            } else {
                                $total_court_fee = $total_court_fee + (int)$court_fee_calculation_param2[0]['docfee'];
                            }
                        }

                        $case_if_sclsc_status = file_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/checkCaseIfSCLSCStatus?diaryNo=' . $diary_no);
                        if ($case_if_sclsc_status == 1) // code added on 19082023 by kbp for making court fee 0 : when any document/is filed in the if_sclsc case
                        {
                            $total_court_fee = 0;
                        }
                        //add affidavit bydefault if not added from indexing as docs code committed by kbpujari on 14022023
                        /*
                            if(!(in_array('11', $all_added_docs_and_ias)))
                            {
                                $court_fee_calculation_param4=$ci->Common_model->get_ia_or_misc_doc_court_fee(null,11,0); // retrieve the court fee for affidavit(court:fee-Rs.20) mandatory by default except  0 for the contempt petition and Criminal cases

                                if ($case_nature == 'C') {
                                    if ((int)$no_of_affidavit_copies > 0) {
                                        $total_court_fee = $total_court_fee + (int)$court_fee_calculation_param4[0]['docfee'] * $no_of_affidavit_copies;
                                    }
                                    else
                                    {
                                        $total_court_fee = $total_court_fee + (int)$court_fee_calculation_param4[0]['docfee'];
                                    }

                                }
                            }*/
                    }
                }
            }
        }
    }


    return $total_court_fee;
}

function getCaseDetailsWithNatureBasedOnSubjectCategory($registration_id)
{
    $case_nature = '';
    // $ci = &get_instance();
    // $ci->load->model('newcase/Common_model');

    $Common_model = new CommonModel();
    $case_details_with_subject_category = $Common_model->get_case_details_with_selected_subject_category($registration_id);
    if (!empty($case_details_with_subject_category)) {
        $selected_subject_category = $case_details_with_subject_category[0]['subcode1'];
        if ($selected_subject_category == 14) // is the subcode
            $case_nature = 'R';
    }
    return $case_nature;
}

function get_pspdfkit_jwt($document_id, $permissions = ['read-document'])
{
    //$ci = &get_instance();
    //$ci->load->library('FirebasePhpJwt');

    $payload = array(
        "exp" => 2454838399,
        "document_id" => $document_id,
        'permissions' => $permissions
    );

    return \Firebase\JWT\JWT::encode($payload, file_get_contents('assets/keys/oauth-private.key'), 'RS256');
}

if (!function_exists("numericOTP")) {
    function numericOTP($n = null)
    {
        $generator = "1357902468";
        $result = "";
        if (isset($n) && !empty($n)) {
            for ($i = 1; $i <= $n; $i++) {
                $result .= substr($generator, (rand() % (strlen($generator))), 1);
            }
        }
        return $result;
    }
}
function uploadDocumentToPSPDFKit($content)
{
    $pspdfkit_document = [];
    try {
        $client = new Client();
        $response = $client->post(
            //  PSPDFKIT_SERVER_URI . '/api/documents',
            PSPDFKIT_SERVER_URI . '/api/documents',
            [
                'headers' => [
                    'Authorization' => 'Token token="secret"',
                    'Content-Length' => 0,
                    'Content-Type' => 'application/pdf',
                    'Transfer-Encoding' => 'chunked',
                    'cache-control' => 'no-cache',
                ],
                'http_errors' => false,
                'body' => $content
            ]
        );
        if ($response->getStatusCode() == 200) {
            $pspdfkit_document = json_decode($response->getBody()->getContents(), true)['data'];
        }
    } catch (GuzzleException $e) {
        //$if_save_case_file_paper_book = false;
    }
    return $pspdfkit_document;
}

function uploadDocumentToPSPDFKitAlt($contents, $document_id = null, $if_overwrite_existing_document = null)
{
    $pspdfkit_document = [];
    $params = [];
    if (!empty($document_id)) {
        $params[] = ['name' => 'document_id', 'contents' => $document_id];
    }
    if ($if_overwrite_existing_document !== null) {
        $params[] = ['name' => 'overwrite_existing_document', 'contents' => $if_overwrite_existing_document];
    }
    try {
        $client = new Client();
        $response = $client->post(
            //  PSPDFKIT_SERVER_URI . '/api/documents',
            PSPDFKIT_SERVER_URI . '/api/documents',
            [
                'headers' => [
                    'Authorization' => 'Token token="secret"',
                    'Content-Length' => 0,
                    'accept: application/json',
                ],
                'http_errors' => false,
                'multipart' => array_merge(
                    [
                        ['name' => 'file', 'contents' => $contents, 'filename' => 'file'],
                    ],
                    $params
                )
            ]
        );
        if ($response->getStatusCode() == 200) {
            $pspdfkit_document = json_decode($response->getBody()->getContents(), true)['data'];
        }
    } catch (GuzzleException $e) {
        //$if_save_case_file_paper_book = false;
    }
    return $pspdfkit_document;
}

function copyDocument($document_id)
{
    $pspdfkit_document = [];
    try {
        $client = new Client();
        $response = $client->post(
            //PSPDFKIT_SERVER_URI . '/api/documents/'.$document_id,
            PSPDFKIT_SERVER_URI . '/api/copy_document/',
            [
                'headers' => [
                    'Authorization' => 'Token token="secret"',
                ],
                'http_errors' => false,
                GuzzleHttp\RequestOptions::JSON => ['document_id' => $document_id]
            ]
        );
        if ($response->getStatusCode() == 200) {
            $pspdfkit_document = json_decode($response->getBody()->getContents(), true)['data'];
        }
    } catch (GuzzleException $e) {
        //$if_save_case_file_paper_book = false;
    }
    return $pspdfkit_document;
}

function get_extra_party_P_or_R($type_id)
{
    $registration_id = getSessionData('efiling_details')['registration_id'];
    $Get_details_model = new GetDetailsModel();
    return $Get_details_model->get_no_of_extra_party($registration_id, $type_id);
}

function check_party($type_id = null)
{
    return true;
    $registration_id = $_SESSION['efiling_details']['registration_id'];
    // $ci = &get_instance();
    // $ci->load->model('newcase/Get_details_model');
    // $ci->load->library('session');
    $Get_details_model = new GetDetailsModel();
    $StageArray = explode(',', $_SESSION['efiling_details']['breadcrumb_status']);
    $total_petitioners = 0;
    $total_respondents = 0;
    $breadcrumb_status = count($StageArray);
    $step = 11;

    $total_petitioners = $Get_details_model->get_no_of_extra_party($registration_id, 'P');

    $total_respondents = $Get_details_model->get_no_of_extra_party($registration_id, 'R');
    if (!empty($type_id) && $type_id != null && $type_id = 'P') {
        return $total_petitioners;
    } else if (!empty($type_id) && $type_id != null && $type_id = 'R') {
        return $total_respondents;
    }
    if ($_SESSION['efiling_details']['no_of_petitioners'] <= $total_petitioners && $_SESSION['efiling_details']['no_of_respondents'] <= $total_respondents) {
        return true;
    } else {
        return false;
    }


    return $Get_details_model->get_no_of_extra_party($registration_id, $type_id);
}

function compare_multi_Arrays($array1, $array2)
{
    $result = array("more" => array(), "less" => array(), "diff" => array());
    foreach ($array1 as $k => $v) {
        if (is_array($v) && isset($array2[$k]) && is_array($array2[$k])) {
            $sub_result = compare_multi_Arrays($v, $array2[$k]);
            //merge results
            foreach (array_keys($sub_result) as $key) {
                if (!empty($sub_result[$key])) {
                    $result[$key] = array_merge_recursive($result[$key], array($k => $sub_result[$key]));
                }
            }
        } else {
            if (isset($array2[$k])) {
                if ($v !== $array2[$k]) {
                    $result["diff"][$k] = array("from" => $v, "to" => $array2[$k]);
                }
            } else {
                $result["more"][$k] = $v;
            }
        }
    }
    foreach ($array2 as $k => $v) {
        if (!isset($array1[$k])) {
            $result["less"][$k] = $v;
        }
    }
    return $result;
}

function multi_diff($arr1, $arr2)
{
    $result = array();
    foreach ($arr1 as $k => $v) {
        if (!isset($arr2[$k])) {
            $result[$k] = $v;
        } else {
            if (is_array($v) && is_array($arr2[$k])) {
                $diff = multi_diff($v, $arr2[$k]);
                if (!empty($diff))
                    $result[$k] = $diff;
            }
        }
    }
    return $result;
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getPspdfkitPagesCount($pspdfkit_document_id)
{
    $info_contents = file_get_contents(PSPDFKIT_SERVER_URI . "/api/documents/$pspdfkit_document_id/document_info", false, stream_context_create([
        'http' => [
            'header' => "Authorization: Token token=\"secret\"",
        ],
    ]));
    $info_contents_obj = json_decode($info_contents);
    $pages = $info_contents_obj->data->pageCount;
    return (int)$pages;
}

function showOCRAlert($pspdfkit_document_id)
{
    //$pspdfkit_document_id = '7KRV51P0HWHNMW52GFTQ11ZWMK';
    $pagescount = getPspdfkitPagesCount($pspdfkit_document_id);
    if ($pagescount <= MIN_PAGES_FOR_OCR_CHECK) {
        return false;
    }
    $pageindexarr = getPageIndexesNeedingOCR($pspdfkit_document_id, $pagescount);
    $pages_needing_ocr_count = count($pageindexarr);
    $pages_needing_ocr_PERCENT = (int)(($pages_needing_ocr_count / $pagescount) * 100);
    if ($pages_needing_ocr_PERCENT > PERCENT_MIN_PAGES_FOR_OCR) {
        return true;
    } else {
        return false;
    }
}

function getPageIndexesNeedingOCR($pspdfkit_document_id, $no_of_pages)
{
    $page_index_needing_ocr_arr = array();
    for ($i = 0; $i < (int)$no_of_pages; $i++) {
        $page_needs_ocr = true;
        $page_contents_json = getPspdfkitPageContentsJson($pspdfkit_document_id, $i);
        $obj = json_decode($page_contents_json);
        if (!empty($obj->textLines)) {
            foreach (@$obj->textLines as $line) {
                if (@$line->contents == '' || @$line->contents == null) {
                    continue;
                } else {
                    $page_needs_ocr = false;
                    break;
                }
            }
        }
        if ($page_needs_ocr == true) {
            array_push($page_index_needing_ocr_arr, $i);
        }
    }
    return $page_index_needing_ocr_arr;
}

function getPspdfkitPageContentsJson($pspdfkit_document_id, $page_index)
{
    $page_contents_json = file_get_contents(PSPDFKIT_SERVER_URI . "/api/documents/$pspdfkit_document_id/pages/$page_index/text", false, stream_context_create([
        'http' => [
            'header' => "Authorization: Token token=\"secret\"",
        ],
    ]));
    return $page_contents_json;
}

//Anshu on 28 May 21
function get_affidavit_pdf_details($sc_case_type_id)
{
    // $ci = &get_instance();
    // $ci->load->model('newcase/Get_details_model');
    // $ci->load->model('appearing_for/Appearing_for_model');
    // $ci->load->library('session');
    $Appearing_for_model = new AppearingForModel();
    $supplement_model = new SupplementModel();
    $session = \Config\Services::session();
    $registration_id = $_SESSION['efiling_details']['registration_id'];
    $parties = $supplement_model->get_signers_list($registration_id);
    $data = array();
    if (!empty($sc_case_type_id)) {
        if ($_SESSION['efiling_details']['database_type'] == 'E') {
            if ($sc_case_type_id == 12 || $sc_case_type_id == 13) {
                //echo 'area parties IA';
                $parties = $Appearing_for_model->get_case_parties_list($registration_id);
                $data = array([
                    'petitioner_name' => $parties[0]['p_partyname'],
                    'respondent_name' => $parties[0]['r_partyname'],
                ]);
            } else {
                //echo 'area parties new case';
                $relation = '';
                if (!empty($parties[0]['relation'])) {
                    $relation = $parties[0]['relation'] . '/o';
                }
                $data = array([
                    'petitioner_name' => $parties[0]['party_name'],
                    'relation' => $relation,
                    'relative_name' => $parties[0]['relative_name'],
                    'party_age' => $parties[0]['party_age'],
                    'petitioner_address' => $parties[0]['party_address'],
                ]);
            }
        } else if ($_SESSION['efiling_details']['database_type'] == 'I') {
            $data = array([
                'petitioner_name' => $_SESSION['efiling_details']['pet_name'],
                'respondent_name' => $_SESSION['efiling_details']['res_name'],
                'case_num' => $_SESSION['efiling_details']['case_num'],
                'case_year' => $_SESSION['efiling_details']['case_year'],
                'relation' => '',
                'relative_name' => '',
                'party_age' => '',
                'petitioner_address' => '',
            ]);
        }
        return $data;
    } else {
        echo 'required sc case type id';
        exit();
    }
}

function shareDocToEmail($params = array())
{
    $result = false;
    if (
        isset($params['email']) && !empty($params['email']) && isset($params['file_url']) && !empty($params['file_url']) &&
        isset($params['subject']) && !empty($params['subject']) && isset($params['message']) && !empty($params['message'])
    ) {
        $to_email = $params['email'];
        $file_url = $params['file_url'];
        $subject = $params['subject'];
        $message = $params['message'];
        // $ci = &get_instance();
        // $ci->load->library('email');
        $email = \Config\Services::email();
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.mail.gov.in',
            'smtp_port' => 465,
            'smtp_user' => 'causelists@nic.in',
            'smtp_pass' => 'eCourts*1234',
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );
        $email->initialize($config);
        $email->setMailType("html");
        $email->setNewline("\r\n");
        $email->setTo($to_email);
        $email->setFrom('causelists@nic.in', "Supreme Court of India");
        $email->setSubject($subject);
        $email->setMessage($message);
        $response = $email->send();
        if ($response) {
            $result = 'success';
        } else {
            $result = 'error';
        }
    }
    return $result;
}

function reset_affirmation($registration_id = null)
{
    $Affirmation_model = new AffirmationModel();

    $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, JAIL_SUPERINTENDENT);
    if (!in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users_array)) {
        return $response = 'Unauthorised Access !';
    }

    $stages_array = array(Draft_Stage, Initial_Defected_Stage, I_B_Defected_Stage);
    if (!in_array(getSessionData('efiling_details')['stage_id'], $stages_array)) {
        return $response = 'Invalid Stage.';
    }

    if (!empty($registration_id) && $registration_id != null) {
        $registration_id = $registration_id;
    } else {
        $registration_id = getSessionData('efiling_details')['registration_id'];
    }
    $docid = '';
    $esigned_docs_details = $Affirmation_model->get_esign_doc_details($registration_id);
    if (!empty($esigned_docs_details) && $esigned_docs_details != FALSE) {
        $docid = $esigned_docs_details[0]->id;
    }
    if (empty($docid)) {
        return $response = 'Invalid Input !';
    }
    //$type = ESIGNED_DOCS_BY_ADV;

    $update_data = array('is_data_valid' => FALSE);
    if (getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_NEW_CASE) {
        $breadcrumb_to_remove = NEW_CASE_AFFIRMATION;
    } elseif (getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_MISC_DOCS) {
        $breadcrumb_to_remove = MISC_BREAD_AFFIRMATION;
    } elseif (getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_IA) {
        $breadcrumb_to_remove = IA_BREAD_AFFIRMATION;
    } elseif (getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_MENTIONING) {
        $breadcrumb_to_remove = MEN_BREAD_AFFIRMATION;
    } elseif (getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_JAIL_PETITION) {
        $breadcrumb_to_remove = JAIL_PETITION_AFFIRMATION;
    }

    $response = $Affirmation_model->reset_affirmation($docid, $registration_id, $update_data, $breadcrumb_to_remove);
    return true;
}

function logged_in_check_user_type($user_type)
{
    //$allowed_users_array = array(USER_ADMIN, USER_EFILING_ADMIN,USER_SUPER_ADMIN, USER_ADMIN_READ_ONLY); //For Admin Portal
    //$allowed_users_array = array(USER_ADVOCATE,USER_IN_PERSON,ARGUING_COUNSEL,SR_ADVOCATE); //For Advocate Portal
    $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, ARGUING_COUNSEL, SR_ADVOCATE, USER_ADMIN, USER_EFILING_ADMIN, USER_SUPER_ADMIN, USER_DEPARTMENT, USER_CLERK, USER_ADMIN_READ_ONLY); //For Advocate Portal and Admin Portal
    if (!in_array($user_type, $allowed_users_array)) {
        return true;
    }
    return false;
}

function is_user_status($loginid = null)
{
    $time1 = date("H:i");
    /*   $ci = &get_instance();
    $ci->load->model('login/Login_model');
    $ci->load->library('session'); */
    if (!empty($loginid) && $loginid != null) {
        $loginid = $loginid;
    } else {
        $loginid = getSessionData('login')['id'];
    }
    $login_model = new \App\Models\Login\LoginModel();
    $result = $login_model->is_user_status($loginid, getSessionData('login')['ref_m_usertype_id']);
    if (!empty($result) && $result != FALSE) {
        if ($result->referrer == getSessionData('login')['ref_m_usertype_id'] && $result->processid != getSessionData('login')['processid']) {
            return response()->redirect(base_url('logout'));
        } else {
            return false;
        }
    }
}

function getPendingCourtFee_old_working_till_101072023()
{
    // $ci = &get_instance();
    // $ci->load->model('common/Common_model');
    $Common_model = new CommonModel();
    $court_fee_part1 = calculate_court_fee(null, 1, null, 'O');
    $court_fee_part2 = calculate_court_fee(null, 2, null, null);

    $total_court_fee = (int)$court_fee_part1 + (int)$court_fee_part2;

    $already_paid_payment = $Common_model->get_already_paid_court_fee($_SESSION['efiling_details']['registration_id']);

    if (!empty($already_paid_payment[0]['court_fee_already_paid']))
        $total_pending_court_fee = $total_court_fee - (int)$already_paid_payment[0]['court_fee_already_paid'];
    else
        $total_pending_court_fee = $total_court_fee;

    return $total_pending_court_fee;
}

function getPendingCourtFee()
{
    $Common_model = new CommonModel();
    $registration_id = getSessionData('efiling_details')['registration_id'];
    $total_pending_court_fee = 0;
    if (!empty($registration_id))
    {
        $if_sclsc = (!empty(getSessionData('efiling_details')['if_sclsc']) && (getSessionData('efiling_details')['if_sclsc'] == 1)) ? getSessionData('efiling_details')['if_sclsc'] : 0; //Code added for to make 0 court fee for SCLSC cases on 25072023 by Anshu and KBP
        if (!empty(getSessionData('efiling_details')['if_sclsc']) && (getSessionData('efiling_details')['if_sclsc'] == 1))
        {
            $total_pending_court_fee = 0;
        }
        else
        {
            if (getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_CAVEAT) 
            {
                $arr = array();
                $arr['registration_id'] = $registration_id;
                $arr['step'] = 6;
                $caveat_details = $Common_model->getCaveatDataByRegistrationId($arr);
                if (!empty($caveat_details[0]))
                    $case_nature = $caveat_details[0]['nature'];
                // pr($case_nature);
                 } else if (getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_IA || getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_MISC_DOCS || getSessionData('efiling_details')['ref_m_efiled_type_id'] == OLD_CASES_REFILING)
                 {
                $court_fee_calculation_param3 = $Common_model->get_ia_or_misc_doc_court_fee($registration_id, null, null); // retrieve the court fee
                // pr($court_fee_calculation_param3);
                $case_nature = (!empty($court_fee_calculation_param3)) ? $court_fee_calculation_param3[0]['nature'] : null;
                if (isset($case_nature)&& empty($case_nature)) {
                    // pr($case_nature);
                    $diary_no = (int)$court_fee_calculation_param3[0]['diary_no'] . (int)$court_fee_calculation_param3[0]['diary_year'];
                    $case_nature = file_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/caseNature?diaryNo=' . $diary_no);
                }
            } else {
                $court_fee_calculation_param1 = $Common_model->get_subject_category_casetype_court_fee($registration_id);
                $case_nature = !empty($court_fee_calculation_param1) ? $court_fee_calculation_param1[0]['nature'] : '';
            }
            // echo "Case Nature is ";
            // pr($case_nature);
          
            if (( isset($case_nature)  &&  $case_nature == 'C' && getSessionData('efiling_details')['ref_m_efiled_type_id'] != E_FILING_TYPE_CAVEAT && getSessionData('efiling_details')['ref_m_efiled_type_id'] != E_FILING_TYPE_IA) || ( isset($case_nature)  &&    $case_nature == 'C' && getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_IA) || ( isset($case_nature)  &&      $case_nature == 'C' && getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_CAVEAT) || ( isset($case_nature)  &&  $case_nature == 'C' && getSessionData('efiling_details')['ref_m_efiled_type_id'] == OLD_CASES_REFILING)) // CHNAGE BY KBPUJARI ON 10072023 TO MAKE 0 COURT FEE FOR THE CAVEAT FILING IF THE CASE TYPE IS SELECTED AS CRIMINAL
            {

               



                $court_fee_part1 = calculate_court_fee(null, 1, null, 'O');
                $court_fee_part2 = calculate_court_fee(null, 2, null, null);

                $total_court_fee = (int)$court_fee_part1 + (int)$court_fee_part2;

                $already_paid_payment = $Common_model->get_already_paid_court_fee(getSessionData('efiling_details')['registration_id']);

                if (!empty($already_paid_payment[0]['court_fee_already_paid']))
                    $total_pending_court_fee = $total_court_fee - (int)$already_paid_payment[0]['court_fee_already_paid'];
                else
                    $total_pending_court_fee = $total_court_fee;
            } else
                $total_pending_court_fee = 0;
        }
    }
    return $total_pending_court_fee;
}

function send_mail_cron($data)
{

    if (!empty($data)) {
        foreach ($data['to_email'] as $val_email) {
            $to_email = $val_email;
            $subject = $data['subject'];
            //$message = $data['message'];
            // $ci = &get_instance();
            // $ci->load->library('email');

            $email = \Config\Services::email();

            //allowed_key=nTcPhj123h for ip=10.25.78.8
            //allowed_key=tNuI321stu for ip=10.40.186.150
            $email_message = (render('templates.email.reports', $data));
            // $email_message = ($this->render('templates.email.reports', $data, true));
            $files = array();
            //$string = base64_encode(json_encode(array("allowed_key" => "tNuI321stu", "sender" => "eService", "mailTo" => $to_email, "subject" => $subject, "message" => $email_message, "files" => $files)));
            $string = base64_encode(json_encode(array("allowed_key" => LIVE_EMAIL_KEY, "sender" => "SCeFM", "mailTo" => $to_email, "subject" => $subject, "message" => $email_message, "files" => $files)));
            $content = http_build_query(array('a' => $string));
            $context = stream_context_create(array('http' => array('method' => 'POST', 'content' => $content,)));
            $json_return = file_get_contents(NEW_MAIL_SERVER_HOST, false, $context);
            $json2 = json_decode($json_return);
            if ($json2) {
                $response = $json2->status;

                if ($response == 'success') {
                    $result = 'success';
                } else {
                    $result = 'error';
                }
            }
        }
        return $result;
    } //End of foreach loop..
    $result = 'Data not found';
    return $result;
}

function get_count_days_FromDate_Todate($from_date, $to_date)
{
    //Assign a date in 'Y-m-d' format
    //$from_date = date('2023-06-20');
    //$to_date = date('2023-07-19');
    $from_date = date('Y-m-d', strtotime($from_date));
    $to_date = date('Y-m-d', strtotime($to_date));
    //Calculate the date difference based on timestamp values
    $difference = strtotime($to_date) - strtotime($from_date);
    //Calculate difference in days
    return $days = abs($difference / (60 * 60) / 24);
    //Print the date difference in days
    //echo "<br/><h3>The difference between ".$from_date." and ".$to_date." is ".$days." days.</h3>";

}

function isRefilingCompulsoryIADefect($reg_id, $current_stage_id)
{
    // echo "Registration: ".$reg_id. 'and current stage:'. $current_stage_id;
    // $ci = &get_instance();
    // $ci->load->model('common/Common_model');
    // $ci->load->library('session');
    $Common_model = new CommonModel();
    $session = \Config\Services::session();
    $result_initial = $Common_model->get_intials_defects_remarks($reg_id, $current_stage_id);
    $result_icmis = $Common_model->get_cis_defects_remarks($reg_id, FALSE);
    $defects['pdfdefects'] = $Common_model->get_pdf_defects_remarks($reg_id);


    foreach ($result_icmis as $re) {
        $prep_dt = (isset($re->obj_prepare_date) && !empty($re->obj_prepare_date)) ? date('Y-m-d', strtotime($re->obj_prepare_date)) : null;
        $remove_dt = (isset($re->obj_removed_date) && !empty($re->obj_removed_date)) ? date('Y-m-d', strtotime($re->obj_removed_date)) : null;
        $pspdfdocumentid = (isset($re->pspdfkit_document_id) && !empty($re->pspdfkit_document_id)) ? $re->pspdfkit_document_id : null;
        $aor_cured = (isset($re->aor_cured) && !empty($re->aor_cured)) ? $re->aor_cured : "f";
        $checked = "";
        $markdefectclass = "";
        if ($aor_cured == "t") {
            $checked = "checked";
            $markdefectclass = "curemarked";
        }
        $from_date = $prep_dt;
        $defect_date_was_more_than28days = 28;
        // New logic for defect cure is written by kbpujari on 30/10/2023 as per defect removal logic provided by Vandana :start
        $defect_removal_max_date = date('Y-m-d', strtotime($from_date . ' + ' . $defect_date_was_more_than28days . ' days'));
        $max_allowable_defect_cured_date = file_get_contents(ICMIS_SERVICE_URL . '/ConsumedData/checkAndGetMaxDateForCuringDefectWhileRefilingTheCase/?allow_defect_remove_max_date=' . $defect_removal_max_date);
        $today_date = date('Y-m-d');
        if ($max_allowable_defect_cured_date >= $today_date) {
            //echo "allow to refile the case- $max_allowable_defect_cured_date";exit();
            return true;
        } else {
            //echo "beyond > 28 days  than .$max_allowable_defect_cured_date";exit();
            $result = $Common_model->isRefilingCompulsoryIADefect($reg_id, FALSE);
            if ($result != FALSE && !empty($result)) {
                return true;
            } else {
                $session->setFlashdata('msg', '<div class="alert alert-danger text-center">This case is defective since more than 28 days so filing of IA i.e. Condonation of delay in refiling application is compulsory.</div>');
                redirect('documentIndex');
                exit();
            }
        }
        // New logic for defect cure is written by kbpujari on 30/10/2023 as per defect removal logic provided by Vandana :end

        //The following old logic for curing defect code commented on 30/11/2023 by kbpujari which is checking only 28 days count
        /*$get_total_days=get_count_days_FromDate_Todate($from_date,$to_date);

        if($get_total_days > $defect_date_was_more_than28days){
            $result = $Common_model->isRefilingCompulsoryIADefect($reg_id, FALSE);
            if($result !=FALSE && !empty($result)){
                return true;
            }else{
                $ci->session->set_flashdata('msg', '<div class="alert alert-danger text-center">This case is defective since more than 28 days so filing of IA i.e. Condonation of delay in refiling application is compulsory.</div>');
                redirect('documentIndex');exit();
            }

        }else{
            return true;
        }*/
    }
}

function addPrefixIfAbsent($number)
{
    if (substr($number, 0, 2) !== '91') {
        return '91' . $number;
    }
    return $number;
}

function send_whatsapp_message($registration_id = null, $efiling_number = null, $sms_text = null)
{
    // $ci = &get_instance();
    // $ci->load->model('common/Common_model');
    $Common_model = new CommonModel();
    $efiling_num_details = null;
    if (!empty($registration_id)) {
        $efiling_num_details = $Common_model->get_case_details_for_whatsapp_messages($registration_id);
    }
    if (!empty($efiling_num_details)) {
        $cause_title = (!empty($efiling_num_details[0]->cause_title)) ? $efiling_num_details[0]->cause_title : null;
        $date = (!empty($efiling_num_details[0]->filing_date)) ? $efiling_num_details[0]->filing_date : null;
        $aor_mobile_number = (!empty($efiling_num_details[0]->aor_mobile_number)) ? $efiling_num_details[0]->aor_mobile_number : null;
        $user_first_name = (!empty($efiling_num_details[0]->first_name)) ? $efiling_num_details[0]->first_name : null;
        $user_login_id = (!empty($efiling_num_details[0]->login_id)) ? $efiling_num_details[0]->login_id : null;
        $user_employee_code = (!empty($efiling_num_details[0]->employee_code)) ? $efiling_num_details[0]->employee_code : null;
    }
    //echo $cause_title.'#'.$date.'#'.$aor_mobile_number.'#'.$user_first_name.'#'.$user_login_id.'#'.$user_employee_code;exit();
    //var_dump($efiling_num_details);
    /*
    The status of eFiled case "#CAUSE TITLE" with "#eFiling No" dated  "#Date"  is "#Status"; (to be checked)
    Examples:-
    Status - Pending for submission in your account
    Status - Diary Number 1921/2024
    Status - Caveat Number 225/2024
    Status- Transaction Number: _____, Amount_____, FAILED. Please check your bank account for any deduction before retrying to make payment.
    Status- Transaction Number: _____, Amount_____, GRN____ CANCELLED.
    Status- Transaction Number: _____, Amount_____, GRN____ PENDING.
    Status- Transaction Number: _____, Amount_____, GRN____ SUCCESSFULLY RECEIVED.
    Status - REFILED
    */


    $efiling_no = 'Efiling no.' . $efiling_number;
    $status = $sms_text;

    $sms_params = array($cause_title, $efiling_no, $date, $status);
    $purpose = 'Registration';
    $module = 'SCeFM';
    $templateCode = "sc_efm::case::status";
    $purpose = 'Registration';
    $module = 'SCeFM';
    $templateCode = "sc_efm::case::status";
    //$wh_mobileno = array("919871922703","919810003580","919540028941","919881397172","918763332660","919630100950","919987508833","919341218677","918813888057");
    $wh_mobileno = array("919711475023", "918586850444", "919891713636", "919525555516");

    //un-comment the following two lines in the production on the event of go-live!!!!
    /*
        $extra_mobile_number_with_prefix = (!empty($aor_mobile_number)) ? addPrefixIfAbsent($aor_mobile_number) : null;
        $wh_mobileno[] = $extra_mobile_number_with_prefix;
    */

    $created_by_user = array(
        "name" => (!empty($_SESSION['login']['first_name'])) ? $_SESSION['login']['first_name'] : $user_first_name,
        "id" => (!empty($_SESSION['login']['id'])) ? $_SESSION['login']['id'] : $user_login_id,
        "employeeCode" => (!empty($_SESSION['login']['userid'])) ? $_SESSION['login']['userid'] : $user_employee_code,
        "organizationName" => 'AOR'
    );
    $response = send_sms_whatsapp_through_uni_notify(1, $wh_mobileno, $templateCode, $sms_params, null, $purpose, $created_by_user, $module, 'SCeFM', null, null);
}

function send_whatsapp_message_test($registration_id = null, $efiling_number = null, $sms_text = null)
{
    $Common_model = new CommonModel();
    if (!empty($registration_id)) {
        $efiling_num_details = $Common_model->get_case_details_for_whatsapp_messages($registration_id);
    }


    $cause_title = (!empty($efiling_num_details[0]['cause_title'])) ? $efiling_num_details[0]['cause_title'] : null;
    $efiling_no = 'Efiling no.' . $efiling_number;
    $date = (!empty($efiling_num_details[0]['filing_date'])) ? $efiling_num_details[0]['filing_date'] : null;
    $status = $sms_text;

    $sms_params = array($cause_title, $efiling_no, $date, $status);
    $purpose = 'Registration';
    $module = 'SCeFM';
    $templateCode = "sc_efm::case::status";
    $purpose = 'Registration';
    $module = 'SCeFM';
    $templateCode = "sc_efm::case::status";
    //$wh_mobileno = array("919871922703","919810003580","919540028941","919881397172","918763332660","919630100950","919987508833","919341218677","918813888057");
    $wh_mobileno = array("919711475023", "918586850444", "919891713636", "919525555516");
    $created_by_user = array("name" => "Admin", "id" => '99', "employeeCode" => '999', "organizationName" => 'AOR');
    $response = send_sms_whatsapp_through_uni_notify(1, $wh_mobileno, $templateCode, $sms_params, null, $purpose, $created_by_user, $module, 'SCeFM', null, null);
}

function send_sms_whatsapp_through_uni_notify($api_type = null, $mobile_nos = [], $templateCode = null, $sms_params = [], $scheduledAt = null, $purpose = null, $created_by_user = [], $module = null, $project = null, $file_name = null, $file_url = null)
{
    $sms_request_filters = [
        "providerCode" => "wa",
        "recipients" => [
            "mobileNumbers" => $mobile_nos
        ],
        "templateCode" => $templateCode,
        "templateVariables" => $sms_params,
        "scheduledAt" => $scheduledAt,
        "purpose" => $purpose,
        "createdByUser" => $created_by_user,
        "module" => $module,
        "project" => $project
    ];

    if ($api_type == 2) {
        $fileArray = [
            "files" => [
                [
                    "name" => $file_name,
                    "url" => $file_url
                ]
            ]
        ];
        array_push($sms_request_filters, $fileArray);
    }
    //echo json_encode($sms_request_filters);
    $curl = curl_init();

    curl_setopt_array($curl, array(
        //CURLOPT_URL => 'http://10.25.78.111:36521/api/v1/send', //production
        CURLOPT_URL => 'http://10.25.78.70:36521/api/v1/send',  //for staging
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('data' => json_encode($sms_request_filters)),
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer 65fd91a2fc44c5e6eec78e03'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function is_vacation_advance_list_duration()
{
    /*  $ci = &get_instance();
    $ci->load->model('vacation/Vacation_advance_model');
    $ci->load->library('session'); */

    if (!empty($loginid) && $loginid != null) {
        $loginid = $loginid;
    } else {

        $loginid = getSessionData('login')['id'];
    }

    $Vacation_advance_model = new \App\Models\Vacation\VacationAdvanceModel();
    $is_vacation_advance_list_duration = $Vacation_advance_model->is_vacation_advance_list_duration();
    return $is_vacation_advance_list_duration;
}
function is_vacation_advance_list_duration_m()
{
    // $ci = &get_instance();
    // $ci->load->model('vacation/Vacation_advance_model_m');
    // $ci->load->library('session');
    $Vacation_advance_model_m = new VacationAdvanceModel();
    $is_vacation_advance_list_duration = $Vacation_advance_model_m->is_vacation_advance_list_duration();
    return $is_vacation_advance_list_duration;
}

function getClientIP()
{
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

// function idEncryptionCustom($id) {
//     $key = openssl_random_pseudo_bytes(32); // Generate a 256-bit key for AES-256 encryption
//     $key = bin2hex($key);
//     $method = "AES-256-CBC";
//     $key = "supremeCourtCI4KeyForEncryption";
//     $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
//     $encryptedID = openssl_encrypt($id, $method, $key, 0, $iv);
//    /*  $decryptedID1 = openssl_decrypt($encryptedID, $method, $key, 0, $iv);
//     echo $decryptedID1; die; */
//     return $encryptedID;
// }

// function idDecryptionCustom($encryptedID) {
//     $key2 = openssl_random_pseudo_bytes(32); // Generate a 256-bit key for AES-256 encryption
//     $key2 = bin2hex($key2);
//     $method = "AES-256-CBC";
//     //$key2 = "supremeCourtCI4KeyForDecryption"; // Don't hardcode, use the generated key
//     $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
//     $decrypted = openssl_decrypt($encryptedID, $method, $key2, 0, $iv);
//     //echo $decrypted; die;
//     return $decrypted;
// }

function integerEncreption($id)
{
    $encrypter = \Config\Services::encrypter();
    $userIDString = (string) $id;
    $encryptedID = $encrypter->encrypt($userIDString);
    return $encryptedID;
}

function integerDecreption($id)
{
    $encrypter = \Config\Services::encrypter();
    $decryptedID = $encrypter->decrypt($id);
    $decryptedID = (int) $decryptedID;
    return $decryptedID;
}

function stringEncreption($id)
{
    $encrypter = \Config\Services::encrypter();
    $encryptedID = $encrypter->encrypt($id);
    return $encryptedID;
}

function stringDecreption($id)
{
    $encrypter = \Config\Services::encrypter();
    $decryptedID = $encrypter->decrypt($id);
    $decryptedID = $decryptedID;
    return $decryptedID;
}

function render($view, $data = [])
{
    $views = APPPATH . 'Views';
    $cache = WRITEPATH . 'cache';

    if (ENVIRONMENT === 'production') {
        $templateEngine = new BladeOne(
            $views,
            $cache,
            BladeOne::MODE_AUTO
        );
    } else {
        $templateEngine = new BladeOne(
            $views,
            $cache,
            BladeOne::MODE_DEBUG
        );
    }

    $templateEngine->pipeEnable = true;
    $templateEngine->setBaseUrl(base_url());
    $views = APPPATH . 'Views'; // Path to your views directory
    $cache = WRITEPATH . 'cache'; // Path to your cache directory

    $blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);

    echo $blade->run($view, $data);
}

if (!function_exists('getEfilingCivilDetails')) {
    function getEfilingCivilDetails($registration_id)
    {
        $ViewModel = new ViewModel();
        $efiling_civil_data = $ViewModel->get_efiling_civil_details($registration_id);
        // pr($efiling_civil_data);
        return $efiling_civil_data;
    }
}

function message_show($type, $msg) {
    if ($type == 'fail') {
        $preTable = "<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp;$msg    <span class='close' onclick=hideMessageDiv()>X</span></p>";
    } elseif ($type == 'success') {
        $preTable = "<p class='message valid' id='msgdiv'>&nbsp;&nbsp;&nbsp;$msg  <span class='close' onclick=hideMessageDiv()>X</span></p>";
    }
    return $preTable;
}

function article_tracking_offline($articlenumber){
    $db2 = Database::connect('e_services'); // Connect to the 'e_services' database
    $builder = $db2->table('post_tracking');
    $builder->select('office, event_type, event_date, event_time');
    $builder->where('barcode', $articlenumber);
    $builder->orderBy('event_date','asc');
    $builder->orderBy('event_time','asc');
    $query = $builder->get();
    if ($query->getNumRows() > 0){
        $status = 'success';
        $rows = array();
        $selected_data = $query->getResultArray();
        foreach($selected_data as $r) {
            $rows[] = $r;   
        }
    }
    else{
        $status = 'Consignment Number Not Found.';
        $rows = array();
    }
    //return $rate;
    return json_encode(array("Status" => $status, "DataValue" => $rows));
}

function getCopySearchResult($row){
    $db2 = Database::connect('e_services'); // Connect to the 'e_services' database
    $builder = $db2->table('user_assets');

    $subQuery1 = $builder
        ->select('u.verify_remark, u.id, u.asset_type, a.asset_name, u.id_proof_type, i.id_name, u.file_path, u.verify_status, u.verify_on, u.video_random_text')
        ->join('user_asset_type_master a', 'a.id = u.asset_type')
        ->join('id_proof_master i', 'i.id = u.id_proof_type AND i.display = "Y"', 'left')
        ->where('u.mobile', $row['mobile'])
        ->where('u.email', $row['email'])
        ->where('u.asset_type', 1)
        ->where('u.diary_no', 0)
        ->orderBy('u.ent_time', 'desc')
        ->limit(1)
        ->getCompiledSelect(); 

    $subQuery2 = $builder
        ->select('u.verify_remark, u.id, u.asset_type, a.asset_name, u.id_proof_type, i.id_name, u.file_path, u.verify_status, u.verify_on, u.video_random_text')
        ->join('user_asset_type_master a', 'a.id = u.asset_type')
        ->join('id_proof_master i', 'i.id = u.id_proof_type AND i.display = "Y"', 'left')
        ->where('u.mobile', $row['mobile'])
        ->where('u.email', $row['email'])
        ->where('u.asset_type', 2)
        ->where('u.diary_no', 0)
        ->orderBy('u.ent_time', 'desc')
        ->limit(1)
        ->getCompiledSelect(); 

    $subQuery3 = $builder
        ->select('u.verify_remark, u.id, u.asset_type, a.asset_name, u.id_proof_type, i.id_name, u.file_path, u.verify_status, u.verify_on, u.video_random_text')
        ->join('user_asset_type_master a', 'a.id = u.asset_type')
        ->join('id_proof_master i', 'i.id = u.id_proof_type AND i.display = "Y"', 'left')
        ->where('u.mobile', $row['mobile'])
        ->where('u.email', $row['email'])
        ->where('u.asset_type', 3)
        ->where('u.diary_no', 0)
        ->orderBy('u.ent_time', 'desc')
        ->limit(1)
        ->getCompiledSelect(); 

    $finalQuery = $db2->query("
        ($subQuery1)
        UNION
        ($subQuery2)
        UNION
        ($subQuery3)
    ");

    try {
        $query = $db2->query($finalQuery);
        if ($query) {
            $result = $query->getResultArray();
        } else {
            throw new \Exception('Query failed to execute.');
        }
    } catch (\Exception $e) {
        // echo "<pre>Error: " . $e->getMessage() . "</pre>";
        $result = [];
    }

    return $result;
}

function getCopyStatusResult($row, $asset_type_flag){
    $db2 = \Config\Database::connect('e_services'); 
    $builder = $db2->table('user_assets u');
    try {
        $builder->select('u.verify_remark, u.id, u.asset_type, a.asset_name, u.id_proof_type, i.id_name, u.file_path, u.verify_status, u.verify_on, u.video_random_text')
                ->join('user_asset_type_master a', 'a.id = u.asset_type', 'inner')
                ->join('id_proof_master i', 'i.id = u.id_proof_type AND i.display = "Y"', 'left')
                ->where('u.mobile', $row['mobile'])
                ->where('u.email', $row['email'])
                ->where('u.asset_type', $asset_type_flag)
                ->where('u.diary_no', $row['diary'])
                ->orderBy('u.ent_time', 'desc')
                ->limit(1);
        $query = $builder->get();
        if ($query === false) {
            $error = $db2->error();
            throw new \Exception('Database query error: ' . $error['message']);
        }
        $result = $query->getRowArray();
    } catch (\Exception $e) {
        // echo "<pre>Error: " . $e->getMessage() . "</pre>";
        $result = [];
    }

    return $result;
}

function getCopyBarcode($row){
    $db2 = Database::connect('e_services'); // Connect to the 'e_services' database
    $builder = $db2->table('post_bar_code_mapping');

    $builder->select('GROUP_CONCAT(barcode) as barcode')
            ->where('copying_application_id', $row['id'])
            ->groupBy('copying_application_id')
            ->having('barcode IS NOT NULL');

    $query = $builder->get();

    return $result = $query->getRowArray();
}

function getCopyApplication($row){
    $db2 = Database::connect('e_services'); // Connect to the 'e_services' database
    $builder = $db2->table('copying_application_documents b');

    try {
        $builder->select('b.sent_to_applicant_on, b.pdf_embed_on, b.pdf_digital_signature_on, r.order_type AS order_name, "" AS reject_cause, b.*')
                ->join('ref_order_type r', 'b.order_type = r.id', 'left')
                ->where('b.copying_order_issuing_application_id', $row['id']);
        $query = $builder->get();
        if ($query === false) {
            $error = $db2->error();
            throw new \Exception('Database query error: ' . $error['message']);
        }
        $result = $query->getResultArray();
    } catch (\Exception $e) {
        // echo "<pre>Error: " . $e->getMessage() . "</pre>";
        $result = [];
    }
    return $result;
}

function getCopyRequest($row){
    $db2 = Database::connect('e_services'); // Connect to the 'e_services' database
    $builder = $db2->table('copying_request_verify_documents b');

    $builder->select('b.path, r.order_type AS order_name, b.reject_cause, b.*')
            ->join('ref_order_type r', 'b.order_type = r.id', 'left')
            ->where('b.copying_order_issuing_application_id', $row['id']);
    $query = $builder->get();
    if ($query === false) {
        $error = $db2->error();
        // echo "<pre>Error: " . $error['message'] . "</pre>";
        $result = [];
    } else {
        $result = $query->getResultArray();
    }
    return $result;

}

function copyFormSentOn($row1){
    $db2 = Database::connect('e_services'); // Connect to the 'e_services' database
    $builder = $db2->table('copying_request_movement c');
    $builder->select('c.from_section_sent_on, us.section_name AS from_section1, us2.section_name AS to_section1')
            ->join('usersection us', 'us.id = c.from_section', 'left')
            ->join('usersection us2', 'us2.id = c.to_section', 'left')
            ->where('c.copying_request_verify_documents_id', $row1['id']) // Ensure $row['id'] contains a valid ID
            ->where('c.display', 'Y')
            ->where('c.from_section_sent_by !=', 0)
            ->orderBy('c.from_section_sent_on');
    $query = $builder->get();
    if ($query === false) {
        $error = $db2->error();
        // echo "<pre>Error: " . $error['message'] . "</pre>";
        $result = [];
    } else {
        $result = $query->getResultArray();
    }
    return $result;
}

function eCopyingGetDiaryNo($ct, $cn, $cy){
    $db2 = Database::connect('sci_cmis_final'); // Connect to the 'sci_cmis_final' database
    $builder = $db2->table('public.main');

    $results = $builder->select("SUBSTRING(diary_no, 1, LENGTH(diary_no) - 4) AS dn, SUBSTRING(diary_no, -4) AS dy")
        ->where("SUBSTRING_INDEX(fil_no, '-', 1) =", $ct)
        ->where("CAST({$cn} AS UNSIGNED) BETWEEN SUBSTRING_INDEX(SUBSTRING_INDEX(fil_no, '-', 2), '-', -1) AND SUBSTRING_INDEX(fil_no, '-', -1)")
        ->where("(IF(reg_year_mh = 0 OR DATE(fil_dt) > DATE('2017-05-10'), 
                    YEAR(fil_dt) = {$cy}, 
                    reg_year_mh = {$cy}))")
        ->get()
        ->getResult();
        return $results;
}

function eCopyingCheckDiaryNo($ct, $cn, $cy){
    $db2 = Database::connect('sci_cmis_final'); // Connect to the 'sci_cmis_final' database
    $builder = $db2->table('public.main_casetype_history h');


    $results = $builder->select("SUBSTRING(h.diary_no, 1, LENGTH(h.diary_no) - 4) AS dn, SUBSTRING(h.diary_no, -4) AS dy, IF(h.new_registration_number != '',  SUBSTRING_INDEX(h.new_registration_number, '-', 1), '') AS ct1, IF(h.new_registration_number != '', SUBSTRING_INDEX(SUBSTRING_INDEX(h.new_registration_number, '-', 2), '-', -1), '') AS crf1, IF(h.new_registration_number != '', SUBSTRING_INDEX(h.new_registration_number, '-', -1), '') AS crl1")
        ->groupStart()
            ->where("SUBSTRING_INDEX(h.new_registration_number, '-', 1) =", $ct)
            ->where("CAST({$cn} AS UNSIGNED) BETWEEN SUBSTRING_INDEX(SUBSTRING_INDEX(h.new_registration_number, '-', 2), '-', -1) AND SUBSTRING_INDEX(h.new_registration_number, '-', -1)")
            ->where("h.new_registration_year", $cy)
        ->groupEnd()
        ->groupStart()
            ->where("SUBSTRING_INDEX(h.old_registration_number, '-', 1) =", $ct)
            ->where("CAST({$cn} AS UNSIGNED) BETWEEN SUBSTRING_INDEX(SUBSTRING_INDEX(h.old_registration_number, '-', 2), '-', -1) AND SUBSTRING_INDEX(h.old_registration_number, '-', -1)")
            ->where("h.old_registration_year", $cy)
            ->where("h.is_deleted", 't')
        ->groupEnd()
        ->where("h.is_deleted", 'f')
        ->get()
        ->getResult();
        return $results;
}

function eCopyingGetFileDetails($diary_no){
    $db2 = Database::connect('sci_cmis_final'); // Connect to the 'sci_cmis_final' database
    $builder = $db2->table('public.main a');

    $results = $builder->select('a.diary_no, reg_no_display, pet_name, res_name, pno, rno, c_status, a.conn_key AS main_case')
        ->where('diary_no', $diary_no)
        ->where('diary_no >', 0)
        ->get()
        ->getResult();

    return $results;
}