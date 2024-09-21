<?php

use SebastianBergmann\Type\FalseType;

$segment = service('uri');


$StageArray = !empty(getSessionData('breadcrumb_enable')['breadcrumb_status']) ? explode(',', getSessionData('efiling_details')['breadcrumb_status']) : array();
?>
<link rel="shortcut icon" href="<?= base_url() . 'assets/newAdmin/' ?>images/favicon.gif">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/font-awesome.min.css" rel="stylesheet">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/animate.css" rel="stylesheet">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/material.css" rel="stylesheet" />
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/style.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= base_url() . 'assets/newAdmin/' ?>css/jquery.dataTables.min.css">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/fullcalendar.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery-ui.css">
<link href="<?= base_url() . 'assets' ?>/css/select2.min.css" rel="stylesheet">
<?php
$disabled_status1='pointer-events: none; cursor: default;';
$allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT, JAIL_SUPERINTENDENT);
$allowed_users_trash = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT);
if((!empty(getSessionData('efiling_details')['stage_id']) && getSessionData('efiling_details')['stage_id']==DRAFT_STAGE) || (!empty(getSessionData('efiling_details')['stage_id']) && getSessionData('efiling_details')['stage_id']==INITIAL_DEFECTED_STAGE) || (!empty(getSessionData('efiling_details')['stage_id']) && getSessionData('efiling_details')['stage_id']== TRASH_STAGE)) {
    $efiling_num_label_for_display = 'DRAFT-';;
    $efiling_num_button_background_class = 'btn-danger';
} else {
    $efiling_num_label_for_display = '';
    $efiling_num_button_background_class = 'btn-success';
}
?>
<div class="dash-card dashboard-section">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class=" dashboard-bradcrumb">
                <div class="left-dash-breadcrumb">
                    <div class="page-title">
                        <h5>
                            <i class="fa fa-file"></i>
                            <?php
                            echo "Caveat Request In A Case";
                            $filing_num_label=$lbl_history='';
                            if (!empty(getSessionData('efiling_details')['stage_id']) && ((getSessionData('efiling_details')['stage_id'] == DRAFT_STAGE) || (getSessionData('efiling_details')['stage_id'] == INITIAL_DEFECTED_STAGE) || (getSessionData('efiling_details')['stage_id'] == TRASH_STAGE))) {
                                $efiling_num_label_for_display = 'DRAFT-';
                                $efiling_num_button_background_class = 'btn-danger';
                            } else {
                                $efiling_num_label_for_display = '';
                                $efiling_num_button_background_class = 'btn-success';
                            }
                            ?>
                        </h5>
                    </div>
                    <div class="form-response" id="msg" role="alert" data-auto-dismiss="5000">
                        <?php
                        if (!empty(getSessionData('MSG'))) {
                            echo getSessionData('MSG');
                        }
                        if (!empty(getSessionData('msg'))) {
                            echo getSessionData('msg');
                        }
                        ?>
                    </div>
                    <?php
                    // echo getSessionData('msg');
                    echo !empty(getSessionData('efiling_details')['stage_id']) ? remark_preview(getSessionData('efiling_details')['registration_id'], getSessionData('efiling_details')['stage_id']) : '';
                    $Array = array(New_Filing_Stage, Initial_Defects_Cured_Stage);
                    if (((getSessionData('login')['ref_m_usertype_id'] == USER_ADMIN) || (getSessionData('login')['ref_m_usertype_id'] == USER_ACTION_ADMIN)) && in_array(getSessionData('efiling_details')['stage_id'], $Array)) {
                        if (isset($efiling_civil_data[0]['orgid']) && $efiling_civil_data[0]['orgid'] == '0' && $efiling_civil_data[0]['not_in_list_org'] == 't' || isset($efiling_civil_data[0]['resorgid']) && $efiling_civil_data[0]['resorgid'] == '0' && $efiling_civil_data[0]['res_not_in_list_org'] == 't') {
                            ?>
                            <a data-toggle="modal" href="#approveModal" class="btn btn-success btn-sm">Approve</a> 
                        <?php } else { ?>
                            <a data-toggle="modal" href="#disapproveModal" class="btn btn-danger btn-sm" >Disapprove</a>
                            <?php
                        }
                    }
                    $idle_Array = array(Draft_Stage, Initial_Defected_Stage, I_B_Defected_Stage);
                    if(!empty((getSessionData('login')['ref_m_usertype_id']) && getSessionData('login')['ref_m_usertype_id'] == USER_ADMIN || getSessionData('login')['ref_m_usertype_id'] == USER_MASTER_ADMIN) && in_array(getSessionData('efiling_details')['stage_id'], $idle_Array) && $segment->getSegment(3) == url_encryption('idle')) {
                        ?>
                        <a data-toggle="modal" href="#lodges_cases" class="btn btn-success">Make Idle</a> 
                        <a data-toggle="modal" href="#delete_lodges_cases" class="btn btn-danger" >Make Idle & Delete</a>
                        <?php
                    }
                    $allowedUsers = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK);
                    $Array = array(Draft_Stage, Initial_Defected_Stage, I_B_Defected_Stage, I_B_Rejected_Stage, E_REJECTED_STAGE);
                    ?>
                    <div class="page-breifs">
                        <ul>
                            <li><a href="" class="blue-dot"><span class="mdi mdi-record"></span> Active </a></li>
                            <li><a href="" class="green-dot"> <span class="mdi mdi-record"></span> Done </a></li>
                            <li><a href="" class="yellow-dot"> <span class="mdi mdi-record"></span> Optional </a></li>
                            <li><a href="" class="red-dot"> <span class="mdi mdi-record"></span> Required </a></li>
                        </ul>
                    </div>
                </div>
                <div class="ryt-dash-breadcrumb">
                    <div class="btns-sec">
                        <?php
                        /* if (!empty(getSessionData('efiling_details')) && !empty(getSessionData('efiling_details')['efiling_no'])) {
                            echo '<a href="javascript::void(0); " class="btn '.$efiling_num_button_background_class.' btn-sm"  style="color: #ffffff"><strong id="copyTarget_EfilingNumber">' . $filing_num_label .$efiling_num_label_for_display. htmlentities(efile_preview(getSessionData('efiling_details')['efiling_no']), ENT_QUOTES) . '</strong></a> &nbsp;<strong id="copyButton" class="btn btn-danger btn-sm"  style="font-size: 14px;color:greenyellow;"><span class="glyphicon glyphicon-copy" style="font-size:14px;color:#ffffff;"></span></strong>';
                            echo '&nbsp; <a class="btn btn-default btn-sm" href="' . base_url('history/efiled_case/view') . '">' . $lbl_history . ' </a>';
                        }*/
                        ?>
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="window.history.back()"><span class="mdi mdi-chevron-double-left"></span>Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 ">
            <div class="crnt-page-head">
                <div class="current-pg-title">
                    <h6>Caveat Filing Form</h6>
                </div>
                <div class="current-pg-actions">
                    <?php
                    if (in_array(getSessionData('login')['ref_m_usertype_id'], $allowedUsers)) {
                        if ((!empty(getSessionData('efiling_details')['stage_id']) && getSessionData('efiling_details')['stage_id'] == Initial_Defected_Stage) || (!empty(getSessionData('efiling_details')['stage_id']) && getSessionData('efiling_details')['stage_id'] == I_B_Defected_Stage)) {
                            echo '<div class="col-md-8"><h5>Please ensure that you have cured the defects notified by admin. Then only proceed with final submit.</h5></div>';
                        }
                        if (in_array(!empty(getSessionData('efiling_details')['stage_id']), $Array)) {
                            if (getSessionData('login')['ref_m_usertype_id'] != USER_CLERK) {
                                // Comment By Amit Mishra as 
                                if (in_array(CAVEAT_BREAD_COURT_FEE, explode(',', getSessionData('efiling_details')['breadcrumb_status'])) && !in_array(CAVEAT_BREAD_VIEW, explode(',', getSessionData('efiling_details')['breadcrumb_status']))) {
                                    echo '<a href="' . base_url('efilingAction/Caveat_final_submit') . '" class="btn btn-success btn-sm">Final Submit</a>';
                                }
                                // echo '<a href="' . base_url('efilingAction/Caveat_final_submit') . '" class="btn btn-success btn-sm">Final Submit</a>';                                        
                                if (getSessionData('efiling_details')['stage_id'] == Draft_Stage) { }
                            } elseif (getSessionData('login')['ref_m_usertype_id'] == USER_CLERK) {
                                if (in_array(CAVEAT_BREAD_DOC_INDEX, explode(',', getSessionData('efiling_details')['breadcrumb_status']))) {
                                    $action = base_url('efilingAction/Caveat_final_submit');
                                    $attribute = array('name' => 'submit_adv_id', 'id' => 'submit_adv_id', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data');
                                    echo form_open($action, $attribute);
                                    $clerk_adv='';                                    
                                    echo form_close();
                                }
                            }
                        }
                    }						
                    if (isset(getSessionData('efiling_details')['efiling_no']) && !empty(getSessionData('efiling_details')['efiling_no'])) {
                        echo '<a href="javascript::void(0); " class="quick-btn transparent-btn '.$efiling_num_button_background_class.'"  id="copyTarget_EfilingNumber">' . $filing_num_label . $efiling_num_label_for_display.htmlentities(efile_preview(getSessionData('efiling_details')['efiling_no']), ENT_QUOTES) . '</a><strong id="copyButton" class="quick-btn btn btn-danger btn-sm"  style="font-size: 14px;color:greenyellow;"><span class="fa fa-copy" style="font-size:14px;color:#ffffff;"></span></strong>';
                        echo '&nbsp; <a class="quick-btn gray-btn" href="' . base_url('history/efiled_case/view ') . '">eFiling History</a>';						
                    }
                  

                   $stages_array = array(Draft_Stage);
                        if (!empty(getSessionData('efiling_details')['stage_id']) && in_array(!empty(getSessionData('login')) && getSessionData('login')['ref_m_usertype_id'], $allowed_users_trash) && in_array(getSessionData('efiling_details')['stage_id'], $stages_array)) {
                        ?>
                    <a href="javascript:void(0)"
                        class="quick-btn gradient-btn"
                        onclick="ActionToTrash('UAT')">Trash</a>
                    <?php } ?>	
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- tabs-section -start  -->
<div class="dash-card dashboard-section tabs-section">
    <div class="tabs-sec-inner">
        <!-- form--start  -->
        <form action="">
            <?php 
            $final_submit_action = False;
            // pr(getSessionData('efiling_details'));
            $StageArray = !empty(getSessionData('efiling_details')['breadcrumb_status']) ? explode(',', getSessionData('efiling_details')['breadcrumb_status']) : array();
            $breadcrumb_status=count($StageArray);
            $step=11;
            $p_r_type_petitioners='P';
            $p_r_type_respondents='R';
            $registration_id = !empty(getSessionData('efiling_details')['registration_id']) ? getSessionData('efiling_details')['registration_id'] : '';
            if (!empty(getSessionData('efiling_details')['no_of_petitioners'])) {
                $total_petitioners = get_extra_party_P_or_R($p_r_type_petitioners);
            } else {
                $total_petitioners=0;
            }
            if (!empty(getSessionData('efiling_details')['no_of_respondents'])) {
                $total_respondents = get_extra_party_P_or_R($p_r_type_respondents);
            } else {
                $total_respondents=0;
            }
            if (!empty(getSessionData('login')) && in_array(getSessionData('login')['ref_m_usertype_id'], array(USER_ADVOCATE, USER_IN_PERSON, USER_PDE))) {
                $final_submit_action = TRUE;
                $final_submit_continue_action = TRUE;                
                $url_caveator = base_url('caveat/');
                $url_caveatee = base_url('caveat/caveatee');
                $url_extra_party = base_url('caveat/extra_party');
                $url_subordinate_court = base_url('caveat/subordinate_court');
                $upload_doc_url = base_url('uploadDocuments');
                $doc_index_url = base_url('documentIndex');
                $url_case_courtfee = base_url('newcase/courtFee');
            } elseif (!empty(getSessionData('efiling_details')['stage_id']) && !empty(getSessionData('login')) && (getSessionData('login')['ref_m_usertype_id'] ==  USER_CLERK && in_array(getSessionData('efiling_details')['stage_id'], array(Draft_Stage, Initial_Defected_Stage)))) {			
                $final_submit_action = False;
                $url_caveator = base_url('caveat/');
                $url_caveatee = base_url('caveat/caveatee');
                $url_extra_party = base_url('caveat/extra_party');
                $url_subordinate_court = base_url('caveat/subordinate_court');
                $upload_doc_url = base_url('uploadDocuments');
                $doc_index_url = base_url('documentIndex');
                $url_case_courtfee = base_url('newcase/courtFee');                            
            } else {					
                $url_case_detail = $url_caveator = $url_caveatee = $url_extra_party = $url_subordinate_court = $upload_doc_url = $doc_index_url = $url_case_courtfee = '#';
            }
            if (isset(getSessionData('efiling_for_details')['case_type_pet_title']) && !empty(getSessionData('efiling_for_details')['case_type_pet_title'])) {
                $case_type_pet_title = htmlentities(getSessionData('efiling_for_details')['case_type_pet_title'], ENT_QUOTES);
            } elseif (isset($efiling_civil_data[0]['case_type_pet_title']) && !empty($efiling_civil_data[0]['case_type_pet_title'])) {
                $case_type_pet_title = htmlentities($efiling_civil_data[0]['case_type_pet_title'], ENT_QUOTES);
            } else {
                $case_type_pet_title = htmlentities('Caveator', ENT_QUOTES);
            }
            if (isset(getSessionData('efiling_for_details')['case_type_res_title']) && !empty(getSessionData('efiling_for_details')['case_type_res_title'])) {
                $case_type_res_title = htmlentities(getSessionData('efiling_for_details')['case_type_res_title'], ENT_QUOTES);
            } elseif (isset($efiling_civil_data[0]['case_type_res_title']) && !empty($efiling_civil_data[0]['case_type_res_title'])) {
                $case_type_res_title = htmlentities($efiling_civil_data[0]['case_type_res_title'], ENT_QUOTES);
            } else {
                $case_type_res_title = htmlentities('Caveatee', ENT_QUOTES);
            }
            ?>
         
                <?php     
                // print_r(getSessionData('efiling_details')['breadcrumb_status']);
                // echo "<br><br><br>";         


                $breadCrumbsArray = !empty(getSessionData('efiling_details')['breadcrumb_status']) ? explode(',', getSessionData('efiling_details')['breadcrumb_status']) : array();
                
               // echo "Amit ". CAVEAT_BREAD_CAVEATOR ;
                
                ?>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <?php 
                   //  echo "Breadcum Status is = ".getSessionData('efiling_details')['breadcrumb_status'];
                    
                    ?>
                    <li class="nav-item" role="presentation">
                        <?php
                        //   echo $segment->getTotalSegments() ;    
                        //  echo $segment->getSegment(1). "<br>";                    
                        //  echo $segment->getSegment(2);                    
                        if ($segment->getTotalSegments()== '1') {
                            $ColorCode = 'background-color: #01ADEF';
                            $status_color = 'active';
                        }
                         elseif (in_array(CAVEAT_BREAD_CAVEATOR, $breadCrumbsArray)) {
                            $ColorCode = 'background-color: #169F85;color:#ffffff;';
                            $status_color = '';
                        } else {
                            $ColorCode = 'background-color: #f0ad4e;color:#ffffff;';
                            $status_color = '';
                        }
                        ?>
                        <a href="<?= $url_caveator ?>" class="nav-link <?php echo $status_color; ?> "  data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><span class="tab-num" style="<?php echo $ColorCode; ?>">1</span>Caveator</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <?php
                        if ($segment->getSegment(2) == 'caveatee') {  
                            $ColorCode = 'background-color: #01ADEF';
                            $status_color = 'active';
                            $disabled_status='';
                        } elseif (in_array(CAVEAT_BREAD_CAVEATEE, $breadCrumbsArray)) {
                            $ColorCode = 'background-color: #169F85;color:#ffffff;';
                            $status_color = '';
                            $disabled_status='';
                        } else {
                            $ColorCode = 'background-color: #C11900;color:#ffffff;';
                            $status_color = '';
                            $disabled_status='pointer-events: none; cursor: default;';
                        }
                        ?>
                        <a href="<?= $url_caveatee ?>" class="nav-link <?php echo $status_color; ?>"  style="<?php if(!in_array(NEW_CASE_CASE_DETAIL, $StageArray)){ echo $disabled_status; }?>" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false"><span class="tab-num" style="<?php echo $ColorCode; ?>">2</span>Caveatee</a>
                    </li>


                    <li> 
                        <?php
                        if ($segment->getSegment(2)  == 'extra_party') {
                            $ColorCode = 'background-color: #01ADEF';
                            $status_color = 'first active';
                        } elseif (in_array(CAVEAT_BREAD_EXTRA_PARTY, $breadCrumbsArray)) {
                            $ColorCode = 'background-color: #169F85;color:#ffffff;';
                            $status_color = '';
                        } else {
                            $ColorCode = 'background-color: #f0ad4e;color:#ffffff;';
                            $status_color = '';
                        }
                        ?>
                        <!--<a href="<?/*= $url_extra_party */?>" class="<?php /*echo $status_color; */?>" style="z-index:6;"><span style="<?php /*echo $ColorCode; */?>">3</span> Extra Party </a>-->
                    </li>      



                    <li class="nav-item" role="presentation"> 
                        <?php
                        // echo "<pre>";
                        //   print_r($breadCrumbsArray);
                        if ($segment->getSegment(2) == 'subordinate_court') {
                            $ColorCode = 'background-color: #01ADEF';
                            $status_color = 'active';
                            $disabled_status='';
                        } elseif (in_array(CAVEAT_BREAD_SUBORDINATE_COURT, $breadCrumbsArray)) {
                            $ColorCode = 'background-color: #169F85;color:#ffffff;';
                            $status_color = '';
                            $disabled_status='';
                        } else {
                            $ColorCode = 'background-color: #C11900;color:#ffffff;';
                            $status_color = '';
                            $disabled_status='pointer-events: none; cursor: default;';
                        }
                        //  
                        ?>
                        <a href="<?= $url_subordinate_court ?>" class="nav-link <?php echo $status_color; ?>"  data-bs-target="#home" type="button" role="tab" aria-controls="home" style="<?php if(!in_array(CAVEAT_BREAD_SUBORDINATE_COURT, $StageArray)) { echo $disabled_status; } ?>" aria-selected="false"><span class="tab-num" style="<?php echo $ColorCode; ?>">3</span>Earlier Courts </a>
                    </li>    

                    <li class="nav-item" role="presentation">
                        <?php               
                            // echo $segment->getSegment(1);
                        if ($segment->getSegment(1) == 'uploadDocuments' || $segment->getSegment(1) == 'documentIndex') {

                            // print_r($StageArray);
                            // echo CAVEAT_BREAD_UPLOAD_DOC; 
                            $ColorCode = 'background-color: #01ADEF';
                            $status_color = 'active';
                            $disabled_status='';
                        } elseif (in_array(CAVEAT_BREAD_UPLOAD_DOC, $StageArray)) {
                            
                            $ColorCode = 'background-color: #169F85;color:#ffffff;';
                            $status_color = '';
                            $disabled_status='';
                        } else {
                            $ColorCode = 'background-color: #C11900;color:#ffffff;';
                            $status_color = '';
                            $disabled_status='pointer-events: none; cursor: default;';
                        }
                        ?>
                        <a href="<?= $upload_doc_url ?>" class="nav-link <?php echo $status_color; ?>" type="button" style="z-index:4; <?php if(!in_array(CAVEAT_BREAD_UPLOAD_DOC, $StageArray)) { echo $disabled_status; } ?>" aria-selected="false"><span class="tab-num" style="<?php echo $ColorCode; ?> ">4</span>Upload Document / Index </a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <?php
                        if ($segment->getSegment(2) == 'courtFee') {
                            $ColorCode = 'background-color: #01ADEF';
                            $status_color = 'active';
                            $disabled_status='';
                        } elseif (in_array(CAVEAT_BREAD_COURT_FEE, $breadCrumbsArray)) {
                            
                            $bgcolor='background-color: #169F85;';
                            $ColorCode = $bgcolor . ";color:#ffffff";
                            $status_color = '';
                            $disabled_status='';
                        } else {
                            $bgcolor='background-color: #C11900;';
                            $ColorCode = $bgcolor . ";color:#ffffff";
                            $status_color = '';
                            $disabled_status='pointer-events: none; cursor: default;';
                        }
                        ?>
                        <a href="<?= $url_case_courtfee ?>" class="nav-link <?php echo $status_color; ?>"  style="<?php if(!in_array(CAVEAT_BREAD_COURT_FEE, $StageArray)) { echo $disabled_status1; } ?>" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false"><span class="tab-num" style="<?php echo $ColorCode; ?>">5</span>Pay Court Fee </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <?php
                        if ($segment->getSegment(2) == 'view') {
                            $ColorCode = 'background-color: #01ADEF';
                            $status_color = 'first active';
                            $disabled_status='';
                        } elseif (in_array(CAVEAT_BREAD_CAVEATOR, $StageArray) && in_array(CAVEAT_BREAD_CAVEATEE, $breadCrumbsArray)  && in_array(CAVEAT_BREAD_DOC_INDEX, $breadCrumbsArray)) {
                            $ColorCode = 'background-color: #169F85;color:#ffffff';
                            $status_color = '';
                            $disabled_status='';
                        } else {
                            $ColorCode = 'background-color: #C11900;color:#ffffff';
                            $status_color = '';
                            $disabled_status='pointer-events: none; cursor: default;';
                        }
                        ?>
                        <a href="<?= base_url('caveat/view') ?>" class="nav-link <?php echo $status_color; ?>"  data-bs-target="#home" type="button" role="tab" aria-controls="home" style="<?php if(!in_array(NEW_CASE_RESPONDENT, $StageArray)){ echo $disabled_status1;}?>" aria-selected="false"><span class="tab-num" style="<?php echo $ColorCode; ?>">6</span>View</a>
                    </li>
                </ul>
         
        </form>

<div class="modal fade" id="FinalSubmitModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Note :-  </h4>
            </div>
            <div class="modal-body">
                <br>
                <?php if (!empty(getSessionData('login')) && getSessionData('login')['ref_m_usertype_id'] == USER_DEPARTMENT) { ?>
                    <ul>
                        <?php if ($final_submit_action && !$final_submit_continue_action) { ?>
                            <li> Are you sure, you want to submit this case?</li>
                            <?php
                        }
                        if ($final_submit_action) {
                            ?>
                            <li> Click on <b> Submit</b> to submit this case to Selected Panel Advocate.</li>
                        <?php } ?>
                        <br>
                    </ul>
                    <div class=" text-center">
                        <?php
                        $action = base_url('stage_list/final_submit');
                        $attribute = array('name' => 'submit_adv_panel', 'id' => 'submit_adv_panel', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data');
                        echo form_open($action, $attribute);
                        ?>
                        <div class="col-md-6 col-sm-6 col-xs-10">
                            <select id="advocate_list" name="advocate_list" class="form-control filter_select_dropdown " style="width: 100%"  >
                                <option value="">Practicing On this establishment</option>
                                <?php
                                foreach ($dept_adv_panel_list as $adv_panel) {
                                    if ($advocate[0]['id'] == $adv_panel['user_id']) {
                                        $sel = 'selected=selected';
                                    } else {
                                        $sel = "";
                                    }
                                    if (!empty($adv_panel['last_name']) && $adv_panel['last_name'] != NULL && $adv_panel['last_name'] != 'NULL') {
                                        $adv_last_name = ' ' . $adv_panel['last_name'];
                                    }
                                    ?>
                                    <option value="<?php echo url_encryption($adv_panel['user_id']); ?>" <?php echo $sel; ?>><?php echo htmlentities(strtoupper($adv_panel['first_name'] . $adv_last_name), ENT_QUOTES); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-10">
                            <select id="advocate_list1" name="advocate_list1" class="form-control filter_select_dropdown" style="width: 100%"  >
                                <option value="">Select Panel Advocate</option>
                                <?php
                                foreach ($dept_all_adv_panel_list as $adv_panel1) {
                                    if ($advocate[0]['id'] == $adv_panel1['user_id']) {
                                        $sel = 'selected=selected';
                                    } else {
                                        $sel = "";
                                    }
                                    if (!empty($adv_panel1['last_name']) && $adv_panel1['last_name'] != NULL && $adv_panel1['last_name'] != 'NULL') {
                                        $adv_last_name = ' ' . $adv_panel1['last_name'];
                                    }
                                    ?>
                                    <option value="<?php echo url_encryption($adv_panel1['user_id']); ?>" <?php echo $sel; ?>><?php echo htmlentities(strtoupper($adv_panel1['first_name'] . $adv_last_name), ENT_QUOTES); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <input type="submit" class="btn btn-success" name="Submit" value="Submit">
                        <?php echo form_close(); ?>
                    </div>
                <?php } else { ?>
                    <ul>
                        <?php if ($final_submit_action && !$final_submit_continue_action) { ?>
                            <li> Are you sure, you want to submit this case?</li>
                            <?php
                        }
                        if ($final_submit_action && $final_submit_continue_action) {
                            ?>
                            <li> Click on <b> Final Submit</b> to submit this case to eFiling admin.</li>
                            <li> Click on <b> Final Submit & File IA </b> to submit this case to eFiling admin and continue with IA filing in this case.</li> 
                        <?php } ?>
                        <br>
                    </ul>
                    <div class=" text-center">
                        <?php if ($final_submit_action) { ?>
                            <a href="<?php echo base_url('stage_list/final_submit'); ?>" class="btn btn-success">Final Submit</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php } if ($final_submit_action && $final_submit_continue_action) { ?>
                            <a href="<?php echo base_url('stage_list/final_submit_with_ia'); ?>" class="btn btn-info">Final Submit & File IA</a> 
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url() . 'assets/newAdmin/' ?>js/jquery-3.3.1.min.js"></script>
<script src="<?= base_url() . 'assets/newAdmin/' ?>js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() . 'assets/newAdmin/' ?>js/general.js"></script>
<script src="<?= base_url() . 'assets/newAdmin/' ?>js/jquery-3.5.1.slim.min.js"></script>
<script src="<?= base_url() . 'assets' ?>/vendors/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url() . 'assets' ?>/js/jquery.min.js"></script>
<script src="<?= base_url() . 'assets' ?>/js/jquery-ui.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url() ?>assets/js/sha256.js"></script>
<script src="<?= base_url() ?>assets/newAdmin/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() . 'assets' ?>/js/select2.min.js"></script>
<script src="<?= base_url() . 'assets' ?>/js/select2-tab-fix.min.js"></script>
<script type="text/javascript" src="<?= base_url() . 'assets' ?>/js/jquery.validate.js"></script>    
<script src="<?=base_url();?>assets/js/sweetalert.min.js"></script>
<link rel="stylesheet" href="<?=base_url();?>assets/css/sweetalert.css"> 
<script>
    function ActionToTrash(trash_type) {       
        event.preventDefault();
        var trash_type =trash_type;
        var url="";
        if (trash_type=='') {
            swal("Cancelled", "Your imaginary file is safe :)", "error");
            return false;
        } else if (trash_type=='UAT') {
            url="<?php echo base_url('userActions/trash'); ?>";
        } else if (trash_type=='SLT') {
            url="<?php echo base_url('stage_list/trash'); ?>";
        } else if (trash_type=='EAT') {
            url="<?php echo base_url('userActions/trash'); ?>";
        } else {
            swal("Cancelled", "Your imaginary file is safe :)", "error");
            return false;
        }
        // alert('trash_type'+trash_type+'url='+url);//return false;
        swal({
            title: "Do you really want to trash this E-Filing,",
            text: "once it will be trashed you can't restore the same.",
            type: "warning",
            position: "top",
            showCancelButton: true,
            confirmButtonColor: "green",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            buttons: ["Make Changes", "Yes!"],
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function(isConfirm){
            if (isConfirm) {  // submitting the form when user press yes
                var link = document.createElement("a");
                link.href = url;
                link.target = "_self";
                link.click();
                swal({ title: "Deleted!",text: "E-Filing has been deleted.",type: "success",timer: 2000 });
            } else {
                //swal({title: "Cancelled",text: "Your imaginary file is safe.",type: "error",timer: 1300});
            }
        });
    }
</script>

<script>
            document.getElementById("copyButton").addEventListener("click", function() {
                copyToClipboardMsg(document.getElementById("copyTarget_EfilingNumber"), "copyButton");
            });

            document.getElementById("copyButton2").addEventListener("click", function() {
                copyToClipboardMsg(document.getElementById("copyTarget2"), "copyButton");
            });

            document.getElementById("pasteTarget").addEventListener("mousedown", function() {
                this.value = "";
            });


            function copyToClipboardMsg(elem, msgElem) {
                var EfilingNumber = document.getElementById('copyTarget_EfilingNumber').innerHTML;
                var succeed = copyToClipboard(elem);
                var msg;
                if (!succeed) {
                    msg = "Copy not supported or blocked.  Press Ctrl+c to copy."
                } else {
                    //msg = 'E-Filing Number: ' +EfilingNumber+' Copied.';
                    msg = 'Copied';
                }
                if (typeof msgElem === "string") {
                    msgElem = document.getElementById(msgElem);
                }
                msgElem.innerHTML = msg;
                /* setTimeout(function() {
                     msgElem.innerHTML = "";
                 }, 5000);*/
            }

            function copyToClipboard(elem) {
                // create hidden text element, if it doesn't already exist
                var targetId = "_hiddenCopyText_";
                var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA" || elem.tagName === "INPUT";
                var origSelectionStart, origSelectionEnd;
                if (isInput) {
                    // can just use the original source element for the selection and copy
                    target = elem;
                    origSelectionStart = elem.selectionStart;
                    origSelectionEnd = elem.selectionEnd;
                } else {
                    // must use a temporary form element for the selection and copy
                    target = document.getElementById(targetId);
                    if (!target) {
                        var target = document.createElement("textarea");
                        target.style.position = "absolute";
                        target.style.left = "-9999px";
                        target.style.top = "0";
                        target.id = targetId;
                        document.body.appendChild(target);
                    }
                    target.textContent = elem.textContent;
                }
                // select the content
                var currentFocus = document.activeElement;
                target.focus();
                target.setSelectionRange(0, target.value.length);

                // copy the selection
                var succeed;
                try {
                    succeed = document.execCommand("copy");
                } catch (e) {
                    succeed = false;
                }
                // restore original focus
                if (currentFocus && typeof currentFocus.focus === "function") {
                    currentFocus.focus();
                }

                if (isInput) {
                    // restore prior selection
                    elem.setSelectionRange(origSelectionStart, origSelectionEnd);
                } else {
                    // clear temporary content
                    target.textContent = "";
                }
                return succeed;
            }
        </script>