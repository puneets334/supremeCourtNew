<?php 

$rules1 = 'required|trim|is_required|encrypt_check';
$rules2 = 'required|trim|is_required|valid_email';

$rules3 = 'required|trim|is_required|user_name_pattern';
$rules4 = 'required|trim|is_required|password_pattern';
$rules5 = 'required|trim|is_required|captcha_pattern';
$rules6 = 'required|trim|is_required';

$court_type_validate = array('field' => 'court_type',
    'label' => 'Court Type', 'rules' => $rules1);

$state_id = array('field' => 'state_id',
    'label' => 'State', 'rules' => $rules1);

$distt_court_list = array('field' => 'distt_court_list',
    'label' => 'District', 'rules' => $rules1);

$district_list = array('field' => 'district_list',
    'label' => 'District', 'rules' => $rules1);

$establishment_list = array('field' => 'establishment_list',
    'label' => 'Establishment', 'rules' => $rules1);

//start admin add_case_type 
$config = array(
    'login_validation' => array(
        array(
            'field' => 'txt_username',
            'label' => 'Username',
            'rules' => $rules3
        ), array(
            'field' => 'txt_password',
            'label' => 'Password',
            'rules' => $rules4
        ), array(
            'field' => 'userCaptcha',
            'label' => 'Captcha',
            'rules' => $rules5
        )
    ),
    'court_type_validation' => array(
        'field' => 'court_type',
        'label' => 'Court Type',
        'rules' => $rules1
    ),
    'add_case_type_validation_add_high_court' => array(
        $court_type_validate
        , array(
            'field' => 'high_court_id',
            'label' => 'High Court',
            'rules' => $rules1
        ), array(
            'field' => 'civil_or_criminal_high',
            'label' => 'Civil Or Criminal',
            'rules' => $rules1
        ), array(
            'field' => 'hc_case_type[]',
            'label' => 'Case type',
            'rules' => $rules1
        )
    ),
    'add_case_type_validation_add_establishment' => array(
        $court_type_validate, $state_id, $distt_court_list, $establishment_list
        , array(
            'field' => 'civil_or_criminal_lower',
            'label' => 'Civil Or Criminal',
            'rules' => $rules1
        ), array(
            'field' => 'case_type_id[]',
            'label' => 'Case type',
            'rules' => $rules1
        )
    ),
    //start admin add_case_type 
// start admin add_contact 
    'add_contact_validation_high_court' => array(
        $court_type_validate
        , array(
            'field' => 'email_id',
            'label' => 'Email id',
            'rules' => $rules2
        ), array(
            'field' => 'high_court_id',
            'label' => 'High Court',
            'rules' => $rules1
        )
    ),
    'add_contact_validation_lower_court' => array(
        $court_type_validate, $state_id, $distt_court_list
        , array(
            'field' => 'email_id',
            'label' => 'Email id',
            'rules' => $rules2
        ), array(
            'field' => 'reg_court_complex_id',
            'label' => 'Court Establishment choose atleast one',
            'rules' => $rules1
        )
    ),
    //end admin add_contact
//start mapping case type, district, village, taluka validation
    $CI->uri->segment(2) . '_validation_high_court' => array(
        $court_type_validate
        , array(
            'field' => 'high_court_id',
            'label' => 'High Court',
            'rules' => $rules1
        )
    ),
    $CI->uri->segment(2) . '_validation_lower_court' => array(
        $court_type_validate, $state_id, $distt_court_list, $establishment_list
    ),
    //end mapping case type, district, village, taluka validation
//start search_case_data, validation
    'search_case_data_validation_E_FILING_FOR_HIGHCOURT_reg_type_1' => array(
        $court_type_validate, array(
            'field' => 'high_court_id',
            'label' => 'High court',
            'rules' => $rules1
        ), array(
            'field' => 'search_filing_type_hc',
            'label' => 'CNR No. OR Reg No',
            'rules' => $rules1
        ), array(
            'field' => 'cino_high_court',
            'label' => 'CNR No',
            'rules' => 'required'
        )
    ),
    'search_case_data_validation_E_FILING_FOR_HIGHCOURT_reg_type_2' => array(
        $court_type_validate, array(
            'field' => 'case_number_hc',
            'label' => 'Register No.',
            'rules' => $rules6
        ), array(
            'field' => 'case_year_hc',
            'label' => 'Case Year',
            'rules' => $rules6
        )
    ),
    'search_case_data_validation_E_FILING_FOR_ESTABLISHMENT_reg_type_lw_3' => array(
        $court_type_validate, $state_id, $district_list, $establishment_list
        , array(
            'field' => 'cino_lower_court',
            'label' => 'CNR No',
            'rules' => $rules6
        ),
    ),
    'search_case_data_validation_E_FILING_FOR_ESTABLISHMENT_reg_type_lw_4' => array(
        $court_type_validate, $state_id, $district_list, $establishment_list
        , array(
            'field' => 'case_type_id',
            'label' => 'Case Type',
            'rules' => $rules6
        ), array(
            'field' => 'case_number',
            'label' => 'Register No.',
            'rules' => $rules6
        ), array(
            'field' => 'case_year',
            'label' => 'Case Year',
            'rules' => $rules6
        )
    ),
    'search_case_data_validation_E_FILING_FOR_ESTABLISHMENT_reg_type_lw_5' => array(
        $court_type_validate, $state_id, $district_list, $establishment_list
        , array(
            'field' => 'case_type_id_fil',
            'label' => 'Case Type',
            'rules' => $rules6
        ), array(
            'field' => 'fil_number',
            'label' => 'Efiling No.',
            'rules' => $rules6
        ), array(
            'field' => 'fil_year',
            'label' => 'Case Year',
            'rules' => $rules6
        )
    )
//end search_case_data, validation
);
