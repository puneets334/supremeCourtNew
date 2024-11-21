
<link rel="shortcut icon" href="<?= base_url().'assets/newDesign/images/logo.png' ?>" type="image/png" />
<!-- <link rel="shortcut icon" href="<?= base_url() . 'assets/newAdmin/' ?>images/favicon.gif"> -->
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/font-awesome.min.css" rel="stylesheet">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/animate.css" rel="stylesheet">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/material.css" rel="stylesheet" />
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/style.css" rel="stylesheet">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/fullcalendar.css" rel="stylesheet">
<!-- <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.css"> -->
<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.min.css"> 
<!-- <link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery-ui.css"> -->
<link href="<?= base_url() . 'assets' ?>/css/select2.min.css" rel="stylesheet">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/black-theme.css" rel="stylesheet">
    <link href="<?= base_url() . 'assets/newAdmin/' ?>css/responsive.css" rel="stylesheet">
    @stack('style')
<?php

//if(!isset($efiling_search_header)) { 
   // $this->load->view('caveat/caveat_view');
// }
$ref_m_usertype_id = !empty($_SESSION['login']['ref_m_usertype_id']) ? $_SESSION['login']['ref_m_usertype_id'] : NULL;
$stage_id = !empty($_SESSION['efiling_details']['stage_id']) ? $_SESSION['efiling_details']['stage_id'] : NULL;
$filing_type = !empty($_SESSION['efiling_details']['efiling_type']) ? $_SESSION['efiling_details']['efiling_type'] : NULL;
$collapse_class = 'collapse';
$area_extended = false;
$diary_generate_button ='';
$extra_party_details=[];
//$subordinate_court_details=[];
if(isset($ref_m_usertype_id) && !empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && isset($stage_id) && !empty($stage_id) && $stage_id == Transfer_to_IB_Stage){
    $collapse_class = 'collapse in';
    $area_extended = true;
//        $diary_generate_button = '<div class="row"><a  data-toggle="modal" href="#generateDiaryNo" data-target="#generateDiaryNoDiv" class="btn btn-primary" id="generateDiaryNoPop" type="button" style="float: right;margin-right: 12px;">Generate Caveat No.</a></div>';
    $diary_generate_button = '<div class="row"><a  href="javascript:void(0)"class="btn btn-primary"  data-efilingtype="caveat" id="generateDiaryNoPop" type="button" style="float: right;margin-right: 12px;">Generate Caveat No.</a></div>';
}
    //echo '<pre>'; print_r($_SESSION); exit;

if (isset($_SESSION['efiling_for_details']['case_type_pet_title']) && !empty($_SESSION['efiling_for_details']['case_type_pet_title'])) {
    $case_type_pet_title = htmlentities($_SESSION['efiling_for_details']['case_type_pet_title'], ENT_QUOTES);
} elseif (isset($efiling_civil_data[0]['case_type_pet_title']) && !empty($efiling_civil_data[0]['case_type_pet_title'])) {
    $case_type_pet_title = htmlentities($efiling_civil_data[0]['case_type_pet_title'], ENT_QUOTES);
} else {
    $case_type_pet_title = htmlentities('Caveator', ENT_QUOTES);
}


if (isset($_SESSION['efiling_for_details']['case_type_res_title']) && !empty($_SESSION['efiling_for_details']['case_type_res_title'])) {
    $case_type_res_title = htmlentities($_SESSION['efiling_for_details']['case_type_res_title'], ENT_QUOTES);
} elseif (isset($efiling_civil_data[0]['case_type_res_title']) && !empty($efiling_civil_data[0]['case_type_res_title'])) {
    $case_type_res_title = htmlentities($efiling_civil_data[0]['case_type_res_title'], ENT_QUOTES);
} else {
    $case_type_res_title = htmlentities('Caveatee', ENT_QUOTES);
}


if ($_SESSION['breadcrumb_enable']['efiling_type'] == E_FILING_TYPE_CDE) {
    $lbl_efiling_for = 'CDE For : ';
    $lbl_efiling_details_head = 'Case Data Entry Details';
    $lbl_efiled_by = 'CDE By : ';
    $lbl_efiled_on = 'CDE On : ';
} else {
    $lbl_efiling_for = 'eFiling For : ';
    $lbl_efiling_details_head = 'eFiling Details';
    $lbl_efiled_by = 'eFiled By : ';
    $lbl_efiled_on = 'eFiled On : ';
}
$font_color = '#4721c4';

if (!empty($reg_id)) {
    echo " <script> $('#acknow').css('display', 'none'); </script>";
} else {
    echo " <script> $('#acknow').css('display', 'block'); </script>";
}

if (in_array($_SESSION['login']['ref_m_usertype_id'], array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK))) {
    $display_edit = 'style="display:block"';
} else {
    $display_edit = 'style="display:none"';
}
    //XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
$stages_array = array('', Draft_Stage, Initial_Defected_Stage,  E_REJECTED_STAGE);
if (!in_array($_SESSION['efiling_details']['stage_id'], $stages_array)) {
    $hidepencilbtn='true';
}else{
    $hidepencilbtn='false';
}



    //XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX


if(in_array(CAVEAT_BREAD_VIEW, explode(',', $_SESSION['efiling_details']['breadcrumb_status']))) {
    if (!empty(getSessionData('caveat_msg'))) {
        echo '<div class="alert alert-success text-center" id="caveat_messsage"> E-filing number ' . efile_preview($_SESSION['efiling_details']['efiling_no']) . ' submitted successfully for approval of E-filing Admin.!</div>';
    }
}
$caveator_name ='';
$caveatee_name ='';

$caveator_details ='';
$caveatee_details ='';
//$efiled_docs_list=[];
if(isset($efiling_civil_data[0]['orgid']) && !empty($efiling_civil_data[0]['orgid']) && $efiling_civil_data[0]['orgid'] != 'I'){
    $org_dept_name=!empty($efiling_civil_data[0]['org_dept_name'])? '<br/>Department Name : '.$efiling_civil_data[0]['org_dept_name'].'<br/>':'';
    $org_post_name=!empty($efiling_civil_data[0]['org_post_name'])? 'Post Name : '.$efiling_civil_data[0]['org_post_name'].'<br/>':'';
    $org_state_name=!empty($efiling_civil_data[0]['org_state_name'])? 'State Name : '.$efiling_civil_data[0]['org_state_name']:'';
    $caveator_details =$org_dept_name.$org_post_name.$org_state_name;
}

if(isset($efiling_civil_data[0]['resorgid']) && !empty($efiling_civil_data[0]['resorgid']) && $efiling_civil_data[0]['resorgid'] != 'I'){
    $res_org_dept_name=!empty($efiling_civil_data[0]['res_org_dept_name'])? '<br/>Department Name : '.$efiling_civil_data[0]['res_org_dept_name'].'<br/>':'';
    $res_org_post_name=!empty($efiling_civil_data[0]['res_org_post_name'])? 'Post Name : '.$efiling_civil_data[0]['res_org_post_name'].'<br/>':'';
    $res_org_state_name=!empty($efiling_civil_data[0]['res_org_state_name'])? 'State Name : '.$efiling_civil_data[0]['res_org_state_name']:'';
    $caveatee_details =$res_org_dept_name.$res_org_post_name.$res_org_state_name;
}
if(isset($efiling_civil_data[0]['pet_name']) && !empty($efiling_civil_data[0]['pet_name'])){
        //$caveator_name ='Caveator is : Individual <br/>Caveator Name : '.$efiling_civil_data[0]['pet_name'];
    $caveator_name =$efiling_civil_data[0]['pet_name'];
}
else if(isset($efiling_civil_data[0]['orgid']) && !empty($efiling_civil_data[0]['orgid']) && $efiling_civil_data[0]['orgid'] == 'D1'){
    $caveator_name = 'State Department';
}
else if(isset($efiling_civil_data[0]['orgid']) && !empty($efiling_civil_data[0]['orgid']) && $efiling_civil_data[0]['orgid'] == 'D2'){
    $caveator_name = 'Central Department';
}
else if(isset($efiling_civil_data[0]['orgid']) && !empty($efiling_civil_data[0]['orgid']) && $efiling_civil_data[0]['orgid'] == 'D3'){
    $caveator_name = 'Other Organisation';
}
if(isset($efiling_civil_data[0]['res_name']) && !empty($efiling_civil_data[0]['res_name'])){
    $caveatee_name =$efiling_civil_data[0]['res_name'];
}
else if(isset($efiling_civil_data[0]['resorgid']) && !empty($efiling_civil_data[0]['resorgid']) && $efiling_civil_data[0]['resorgid'] == 'D1'){
    $caveatee_name = 'State Department';
}
else if(isset($efiling_civil_data[0]['resorgid']) && !empty($efiling_civil_data[0]['resorgid']) && $efiling_civil_data[0]['resorgid'] == 'D2'){
    $caveatee_name = 'Central Department';
}
else if(isset($efiling_civil_data[0]['resorgid']) && !empty($efiling_civil_data[0]['resorgid']) && $efiling_civil_data[0]['resorgid'] == 'D3'){
    $caveatee_name = 'Other Organisation';
}
$caveat_no ='';
if(isset($efiling_civil_data[0]['caveat_num']) && !empty($efiling_civil_data[0]['caveat_num'])
    && isset($efiling_civil_data[0]['caveat_year']) && !empty($efiling_civil_data[0]['caveat_year'])){
    $caveat_no = $efiling_civil_data[0]['caveat_num']. ' / '.$efiling_civil_data[0]['caveat_year'];
}
?>
<div class="center-content-inner comn-innercontent">
    <div class="tab-content">
        <div class="tab-pane active"
            id="home"
            role="tabpanel"
            aria-labelledby="home-tab">
            <div class="tab-form-inner">
                <div class="row">
                    <div style="float: right">
                        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-5 text-right">
                            <?php
                            if (getSessionData('login')['ref_m_usertype_id'] == USER_ADVOCATE || getSessionData('login')['ref_m_usertype_id'] == USER_IN_PERSON) {
                                $allowed_users_array = array(Initial_Approaval_Pending_Stage,I_B_Defects_Cured_Stage,Initial_Defects_Cured_Stage);
                                if (in_array(getSessionData('efiling_details')['stage_id'], $allowed_users_array)) {
                                    ?>
                            <!-- <a class="btn btn-success btn-sm"
                                target="_blank"
                                href="<?php echo base_url('acknowledgement/view'); ?>">
                                <i class="fa fa-download blink"></i> eFiling Acknowledgement 
                            </a> -->
                            <?php
                                }
                            }
                            ?>
                        </div>
                        <?php //$diary = false;
                        if (isset($diary_generate_button) && !empty($diary_generate_button) && empty($diary)) {
                            echo $diary_generate_button;
                        }
                        if (isset($ref_m_usertype_id) && !empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && isset($stage_id) && !empty($stage_id) && $stage_id == I_B_Defects_Cured_Stage) {
                            if (!empty(getSessionData('efiling_details')['stage_id']) && getSessionData('efiling_details')['stage_id'] == I_B_Defects_Cured_Stage) {
                                echo '<a  href="javaScript:void(0)" class="btn btn-primary" data-efilingtype="new_case" data-registration_id="' . getSessionData('efiling_details')['registration_id'] . '" id="transferToScrutiny" type="button" style="float: left;margin-right: 92px;">Transfer To Scrutiny</a>';
                            }
                        }
                        ?>
                        <button id="collapseAll" onclick="toggleAllAccordions()" class="btn btn-primary pull-right mb-3"> Collapse All </button>
                        <!-- <a title="Click Here To View All Information"
                            href="javascript:void(0);"
                            class="btn btn-outline btn-primary btn-sm openall"
                            style="float: right">
                            <span class="fa fa-eye"></span>&nbsp;&nbsp; View All
                        </a>
                        <a title="Click Here To Close All Information"
                            href="javascript:void(0);"
                            class="btn btn-outline btn-info btn-sm closeall"
                            style="float: right; ">
                            <span class="fa fa-eye-slash"></span> Close All
                        </a> -->
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="accordion"
                            id="accordionExample">
                            <div class="accordion-item custom-table">
                                <h2 class="accordion-header"
                                    id="headingOne">
                                    <button class="accordion-button"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne"
                                        aria-expanded="true"
                                        aria-controls="collapseOne">
                                        eFiling  Details
                                    </button>
                                </h2>
                                <div id="collapseOne"
                                    class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="x_panel">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label col-md-4 text-right"
                                                            for="filing_no">eFiling For :
                                                        </label>
                                                        <div class="col-md-8">
                                                            <p> <?php echo 'Caveat'; ?> </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label col-md-4 text-right"
                                                            for="filing_no">eFiling No :
                                                        </label>
                                                        <div class="col-md-8">
                                                            <p> <?php echo htmlentities(efile_preview($_SESSION['efiling_details']['efiling_no']), ENT_QUOTES); ?> </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label col-md-4 text-right"
                                                            for="filing_no">Caveator :
                                                        </label>
                                                        <div class="col-md-8">
                                                            <p>  <?php echo htmlentities($caveator_name, ENT_QUOTES); ?> </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label col-md-4 text-right"
                                                            for="filing_no">Caveatee :
                                                        </label>
                                                        <div class="col-md-8">
                                                            <p>  <?php echo htmlentities($caveatee_name, ENT_QUOTES); ?> </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                    <?php
                                                if(isset($filedByData) && !empty($filedByData)) {
                                                    $filedBy = '';
                                                    $name = !empty($filedByData['name']) ? $filedByData['name'] : '';
                                                    if (isset($filedByData['pp']) && !empty($filedByData['pp']) && $ref_m_usertype_id==USER_IN_PERSON) {
                                                        $filedBy = $name . ' ( Party In Person )';
                                                    } else {
                                                        $aor_code = !empty($filedByData['aor_code']) ? $filedByData['aor_code'] : '';
                                                        $filedBy = $name . ' (AOR- ' . $aor_code . ')';
                                                    }
                                                    echo '<div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label col-md-4 text-right"
                                                            for="filing_no">Filied By.:
                                                        </label>
                                                        <div class="col-md-8">
                                                            <p>'.$filedBy.'</p>
                                                        </div>
                                                    </div>
                                                </div>';
                                                }
                                                
                                                if(isset($caveat_no) && !empty($caveat_no))
                                                {
                                                    echo '<div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label col-md-4 text-right"
                                                            for="filing_no">Caveat No.:
                                                        </label>
                                                        <div class="col-md-8">
                                                            <p>'.$caveat_no.'</p>
                                                        </div>
                                                    </div>
                                                </div>';
                                                }
                                                ?>                

                                                

                                            </div>
                                            <div class="row">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item custom-table">
                                <div class="row">
                                    <h2 class="accordion-header <?php if(isset($hidepencilbtn) && $hidepencilbtn != 'true') { ?> col-sm-11 <?php } else { ?> col-sm-12 <?php } ?>" 
                                        id="headingTwo">
                                        <button class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo"
                                            aria-expanded="false"
                                            aria-controls="collapseTwo" <?php echo $area_extended; ?>>
                                            <?php
                                    if(!isset($case_type_pet_title) || empty($case_type_pet_title)){?><font style="color:red;">
                                                <b>Caveator</b>
                                            </font><?php } else{?>
                                            <b>Caveator</b><?php }?>
                                        </button>
                                    </h2>
                                    <?php
                                if($hidepencilbtn!='true'){ ?>
                                    <div class="col-sm-1">
                                        <a href="<?php echo base_url('caveat/subordinate_court'); ?>"><i
                                                style="color:black; padding-top:20px;"
                                                class="fa fa-pencil efiling_search"></i></a>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div id="collapseTwo"
                                    class="accordion-collapse collapse <?php echo $collapse_class; ?>"
                                    aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php render('caveat.caveator_list_view', ['efiling_civil_data' => $efiling_civil_data]); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item custom-table">
                                <div class="row">
                                    <h2 class="accordion-header <?php if(isset($hidepencilbtn) && $hidepencilbtn != 'true') { ?> col-sm-11 <?php } else { ?> col-sm-12 <?php } ?>" 
                                        id="headingThree">
                                        <button class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree"
                                            aria-expanded="false"
                                            aria-controls="collapseThree" <?php echo $area_extended; ?>>
                                            <?php
                                    if(!isset($case_type_res_title) || empty($case_type_res_title)){?>
                                            <font style="color:red;"> <b>Caveatee</b>
                                            </font>
                                            <?php } else{?><b>Caveatee</b><?php }?>
                                        </button>
                                    </h2>
                                    <?php
                                if($hidepencilbtn!='true'){ ?>
                                    <div class="col-sm-1">
                                        <a href="<?php echo base_url('caveat/caveatee'); ?>"><i
                                                style="color:black; padding-top: 20px !important;"
                                                class="fa fa-pencil efiling_search"></i></a>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div id="collapseThree"
                                    class="accordion-collapse collapse <?php echo $collapse_class; ?>"
                                    aria-labelledby="headingThree"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php render('caveat.caveatee_list_view', ['efiling_civil_data' => $efiling_civil_data]); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item custom-table">
                                <div class="row">
                                    <h2 class="accordion-header <?php if(isset($hidepencilbtn) && $hidepencilbtn != 'true') { ?> col-sm-11 <?php } else { ?> col-sm-12 <?php } ?>" 
                                        id="headingFour">
                                        <button class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapseFour"
                                            aria-expanded="false"
                                            aria-controls="collapseFour" <?php echo $area_extended; ?>>
                                            <?php
                                    if(!isset($case_type_pet_title) || empty($case_type_pet_title)){?><font style="color:red;">
                                                <b>Extra Parties</b>
                                            </font><?php } else{?>
                                            <b>Extra Parties</b><?php }?>
                                        </button>
                                    </h2>
                                    <?php
                                if($hidepencilbtn!='true'){ ?>
                                    <div class="col-sm-1">
                                        <a href="<?php echo base_url('caveat/subordinate_court'); ?>"><i
                                                style="color:black; padding-top:20px;"
                                                class="fa fa-pencil efiling_search"></i></a>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div id="collapseFour"
                                    class="accordion-collapse collapse <?php echo $collapse_class; ?>"
                                    aria-labelledby="headingFour"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php render('caveat.extraparty_list_view', ['extra_party_details' => $extra_party_details]); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item custom-table">
                                <div class="row">
                                    <h2 class="accordion-header <?php if(isset($hidepencilbtn) && $hidepencilbtn != 'true') { ?> col-sm-11 <?php } else { ?> col-sm-12 <?php } ?>" 
                                        id="headingFive">
                                        <button class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapseFive"
                                            aria-expanded="false"
                                            aria-controls="collapseFive" <?php echo $area_extended; ?>>
                                            <?php
                                            // pr($subordinate_court_details);
                                    if(!isset($case_type_pet_title) || empty($case_type_pet_title)){?><font style="color:red;">
                                                <b>Subordinate Court Details</b>
                                            </font><?php } else{?>
                                            <b>Subordinate Court Details</b><?php }?>
                                        </button>
                                    </h2>
                                    <?php
                                if($hidepencilbtn!='true'){ ?>
                                    <div class="col-sm-1">
                                        <a href="<?php echo base_url('caveat/subordinate_court'); ?>"><i
                                                style="color:black; padding-top:20px;"
                                                class="fa fa-pencil efiling_search"></i></a>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div id="collapseFive"
                                    class="accordion-collapse collapse <?php echo $collapse_class; ?>"
                                    aria-labelledby="headingFive"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php render('caveat.subordinate_listing_view',  ['subordinate_court_details' => $subordinate_court_details]); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item custom-table">
                                <div class="row">
                                    <h2 class="accordion-header <?php if(isset($hidepencilbtn) && $hidepencilbtn != 'true') { ?> col-sm-11 <?php } else { ?> col-sm-12 <?php } ?>" 
                                        id="headingSix">
                                        <button class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapseSix"
                                            aria-expanded="false"
                                            aria-controls="collapseSix" <?php echo $area_extended; ?>>
                                            <?php
                                    if(!isset($case_type_pet_title) || empty($case_type_pet_title)){?><font style="color:red;">
                                                <b>Documents</b>
                                            </font><?php } else{?>
                                            <b>Documents</b><?php }?>
                                        </button>
                                    </h2>
                                    <?php
                                if($hidepencilbtn!='true'){ ?>
                                    <div class="col-sm-1">
                                        <a href="<?php echo base_url('uploadDocuments'); ?>"><i
                                                style="color:black; padding-top:20px;"
                                                class="fa fa-pencil efiling_search"></i></a>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div id="collapseSix"
                                    class="accordion-collapse collapse <?php echo $collapse_class; ?>"
                                    aria-labelledby="headingSix"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php render('documentIndex.documentIndex_caveat_list_view',  ['efiled_docs_list' => $efiled_docs_list]); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item custom-table">
                                <div class="row">
                                    <h2 class="accordion-header <?php if(isset($hidepencilbtn) && $hidepencilbtn != 'true') { ?> col-sm-11 <?php } else { ?> col-sm-12 <?php } ?>" 
                                        id="headingNine">
                                        <button class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapseNine"
                                            aria-expanded="false"
                                            aria-controls="collapseNine"
                                            <?php echo $area_extended; ?>>
                                            <?php
                                        $pending_court_fee=getPendingCourtFee();
                                        if((!isset($payment_details) || empty($payment_details)) && ($pending_court_fee>0)){?>
                                            <font style="color:red;">
                                                <b>Court Fee</b>
                                            </font><?php } else{?>
                                            <b>Court Fee</b><?php }?>
                                        </button>
                                    </h2>
                                    <?php
                                if($hidepencilbtn!='true'){ ?>
                                    <div class="col-sm-1">
                                        <a href="<?php echo base_url('newcase/courtFee'); ?>"><i
                                                style="color:black; padding-top:10px;"
                                                class="fa fa-pencil efiling_search"></i></a>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div id="collapseNine"
                                    class="accordion-collapse collapse <?php echo $collapse_class; ?>"
                                    aria-labelledby="headingNine"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php //render('courtFee.document_listing_view', ['efiling_civil_data' => $efiling_civil_data]); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-12 my-3">
                    <div class="row">
                        <div class="progress"
                            style="display: none">
                            <div class="progress-bar progress-bar-success myprogress"
                                role="progressbar"
                                value="0"
                                max="100"
                                style="width:0%">0%</div>
                        </div>
                    </div>
                    <div class="save-btns text-center">
                        <?php
                        if (getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_NEW_CASE) {
                            $prev_url = base_url('documentIndex');
                            //$next_url = base_url('affirmation');
                            $next_url = base_url('newcase/view');
                        } elseif (getSessionData('efiling_details')['ref_m_efiled_type_id'] == E_FILING_TYPE_CAVEAT) {
                            $prev_url = base_url('documentIndex');
                            $next_url = base_url('caveat/view');
                        } else {
                            $prev_url = '#';
                            $next_url = '#';
                        }
                        ?>
                        <!--<a href="<?= $prev_url ?>"
                            class="btn btn-primary btnPrevious"
                            type="button">Previous</a>-->
                        <input type="submit"
                            class="btn btn-success pay_fee"
                            id="pay_fee"
                            name="submit"
                            value="PAY"
                            style="display: none;">
                        <?php
                            if((isset($payment_details['0']->payment_status) && !empty($payment_details['0']->payment_status) && $payment_details['0']->payment_status == 'Y') || ($pending_court_fee==0)) { ?>
                        <!--<a href="<?= $next_url ?>"
                            class="btn btn-primary btnNext pay_fee_next"
                            type="button">Next</a>-->
                        <?php } ?>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 my-3">
                    <?php
                    if (isset($payment_details) && !empty($payment_details)) {
                        render('shcilPayment.payment_list_view', ['payment_details' => $payment_details]);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    @if(getSessionData('login')['ref_m_usertype_id'] == USER_ADMIN)
    </div>
    </div>
    </div>
    </div>
 
    <footer class="footer-sec">Content Owned by Supreme Court of India</footer>

    @endif
                             
    <script src="<?= base_url() . 'assets/newAdmin/' ?>js/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url() . 'assets/newAdmin/' ?>js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() . 'assets/newAdmin/' ?>js/general.js"></script>
    <!-- <script src="<?= base_url() . 'assets/newAdmin/' ?>js/jquery-3.5.1.slim.min.js"></script> -->
    <script src="<?= base_url() . 'assets' ?>/vendors/jquery/dist/jquery.min.js"></script>
    <!-- <script src="<?= base_url() . 'assets' ?>/js/jquery.min.js"></script> -->
    <!-- <script src="<?= base_url() . 'assets' ?>/js/jquery-ui.min.js"></script> -->
    <!-- <script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script> -->
    <script src="<?= base_url() ?>assets/js/bootstrap-datepicker.min.js"></script>
    <script src="<?= base_url() ?>assets/js/sha256.js"></script>
    <script src="<?= base_url() ?>assets/newAdmin/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() . 'assets' ?>/js/select2.min.js"></script>
    <!-- <script src="<?= base_url() . 'assets' ?>/js/select2-tab-fix.min.js"></script> -->
    <script src="<?= base_url() . 'assets' ?>/js/jquery.validate.js"></script>
      
 
    <script>
        function toggleAllAccordions() {
            var button = document.getElementById("collapseAll");
            var accordionHeaders = document.querySelectorAll(".accordion-header button");
            var accordionCollapses = document.querySelectorAll(".accordion-collapse");
            var isCollapsed = Array.from(accordionHeaders).some(function (header) {
                return !header.classList.contains("collapsed");
            });
            if (isCollapsed) {
                button.innerHTML = "Expand all";
                accordionHeaders.forEach(function (header) {
                    header.classList.add("collapsed");
                });
                accordionCollapses.forEach(function (collapse) {
                    collapse.classList.remove("show");
                });
            } else {
                button.innerHTML = "Collapse all";
                accordionHeaders.forEach(function (header) {
                    header.classList.remove("collapsed");
                });
                accordionCollapses.forEach(function (collapse) {
                    collapse.classList.add("show");
                });
            }
        }
    </script>
<!-- <script>
    $(document).ready(function () {
        $('.closeall').click(function () {
            $('.collapse.in').collapse('hide');
            $('.closeall').hide();
            $('.openall').show();
        });
        $('.openall').click(function () {
            $('.collapse:not(".in")').collapse('show');
            $('.closeall').show();
            $('.openall').hide();
        });
    });
</script> -->
<script type="text/javascript">
    $("#cde").click(function () {
        $.ajax({
            url: "<?php echo base_url('newcase/finalSubmit/valid_cde'); ?>",
            success: function (data) {
                var dataas = data.split('?');
                var ct = dataas[0];
                var dataarr = dataas[1].slice(1).split(',');
                if ((dataarr[0] != 2) && (dataarr[0] != 3) && (dataarr[0] != 6) && (dataarr[0] != 7)) {
                    window.location.href = "<?php echo base_url('newcase/finalSubmit/forcde')?>";
                }
                if ((dataarr[0]) == 2) {
                    alert("Petitioner details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/petitioner')?>";
                }

                if ((dataarr[0]) == 3) {
                    alert("Respondent details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/respondent')?>";
                }

                if (((dataarr[0]) == 7) && (ct != 5) && (ct != 6) && (ct != 7) && (ct != 8)) {
                    alert("Subordinate_courts details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/subordinate_court')?>";
                }

            },
            error: function () {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }


        });
        return false;
    });
    $("#efilaor").click(function () {
        $.ajax({
            url: "<?php echo base_url('newcase/AutoDiary/valid_efil'); ?>", // enabled this for auto diary generation
            success: function (data) {
                console.log(data);
                var dataas = data.split('?');
                var ct = dataas[0];
                var dataarr = dataas[1].slice(1).split(',');
                if ((dataarr[0] != 2) && (dataarr[0] != 3) && (dataarr[0] != 7) && (dataarr[0]) != 8 && (dataarr[0]) != 10) {
                     alert("all completed");
                    window.location.href = "<?php echo base_url('newcase/AutoDiary')?>"; //ENABLED THIS FOR AUTO DIARY
                }
                if ((dataarr[0]) == 2) {
                    alert("Petitioner details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/petitioner')?>";
                }
                if ((dataarr[0]) == 3) {
                    alert("Respondent details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/respondent')?>";
                }
                if (((dataarr[0]) == 7) && (ct != 5) && (ct != 6) && (ct != 7) && (ct != 8)) {
                    alert("Subordinate_courts details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/subordinate_court')?>";
                }
                if (((dataarr[0]) == 8)) {
                    alert("Documents are not uploaded. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/uploadDocuments')?>";
                }
                if (((dataarr[0]) == 10)) {
                    alert("Court Fees not paid. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/courtFee')?>";
                }
            },
            error: function () {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
        return false;
    });
    $("#efilpip").click(function () {
        $.ajax({
            url: "<?php echo base_url('newcase/finalSubmit/valid_efil'); ?>",
            success: function (data) {
                console.log(data);
                var dataas = data.split('?');
                var ct = dataas[0];
                var dataarr = dataas[1].slice(1).split(',');
                if ((dataarr[0] != 2) && (dataarr[0] != 3) && (dataarr[0] != 7) && (dataarr[0]) != 8 && (dataarr[0]) != 10) {
                    alert("all completed");
                    window.location.href = "<?php echo base_url('newcase/finalSubmit')?>";
                }
                if ((dataarr[0]) == 2) {
                    alert("Petitioner details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/petitioner')?>";
                }
                if ((dataarr[0]) == 3) {
                    alert("Respondent details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/respondent')?>";
                }
                if (((dataarr[0]) == 7) && (ct != 5) && (ct != 6) && (ct != 7) && (ct != 8)) {
                    alert("Subordinate_courts details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/subordinate_court')?>";
                }
                if (((dataarr[0]) == 8)) {
                    alert("Documents are not uploaded. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/uploadDocuments')?>";
                }
                if (((dataarr[0]) == 10)) {
                    alert("Court Fees not paid. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('newcase/courtFee')?>";
                }
            },
            error: function () {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
        return false;
    });
    $("#jail").click(function () {
        $.ajax({
            url: "<?php echo base_url('jailPetition/FinalSubmit/validate'); ?>",
            success: function (data) {
                var dataarr = data.slice(1).split(',');
                if ((dataarr[0] != 1) && (dataarr[0] != 3)) {
                    window.location.href = "<?php echo base_url('jailPetition/FinalSubmit')?>";
                }
                if ((dataarr[0]) == 1) {
                    alert("Basic Case details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('jailPetition/BasicDetails')?>";
                }
                if ((dataarr[0]) == 3) {
                    alert("Earlier Court Details are mandatory to fill. Redirecting to page !!");
                    window.location.href = "<?php echo base_url('jailPetition/Subordinate_court')?>";
                }
            },
            error: function () {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
        return false;
    });

    $('#disapprove_me').click(function () { 
        var temp = $('.disapprovedText').text(); 
        temp = $.trim(temp); 
        var efiling_type_id = '<?php echo isset($_SESSION['efiling_details']) ? $_SESSION['efiling_details']['ref_m_efiled_type_id'] : ''; ?>';            
        if (efiling_type_id  !="") {
            $('#disapprove_alerts').show();
            if (temp.length > 500) {
                $('#disapprove_alerts').show();
                $('#disapprove_alerts').html("<p class='message invalid' id='msgdiv'>Maximum length 500 allowed. <span class='close' onclick=hideMessageDiv()>X</span></p>");
            } else {
                if ($('#objection_value').html() != '') {
                    $('#obj_remarks').val($('#objection_value').html());
                }
                $('#descr').val($('#editor-one').html());
                $('#disapp_case').submit();
            }
        }
    });
</script>

 
<script>
<?php  pr("Step ffffff"); ?>   
</script>