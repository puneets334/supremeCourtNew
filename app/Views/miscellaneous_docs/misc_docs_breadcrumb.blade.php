<?php

use App\Models\Department\DepartmentModel;

$segment = service('uri');
$StageArray = !empty(getSessionData('breadcrumb_enable')) ? explode(',', getSessionData('efiling_details')['breadcrumb_status']) : [];
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
<div class="dash-card dashboard-section">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class=" dashboard-bradcrumb">
                <div class="left-dash-breadcrumb">
                    <div class="page-title">
                        <?php
                        $commonHeading = '';
                        if (getSessionData('customEfil') == 'ia') {
                            unset($_SESSION['efiling_type']);
                            $_SESSION['efiling_type'] = 'ia';

                            $commonHeading = 'File An IA';
                        } elseif (getSessionData('customEfil') == 'misc') {
                            $commonHeading = 'File A Document';
                        } elseif (getSessionData('customEfil') == 'refile') {
                            $commonHeading = 'Refile old efiling cases';
                        }
                        ?>
                        <h5><i class="fa fa-file"></i> {{$commonHeading}}</h5>
                    </div>
                    <div class="form-response" id="msg" role="alert" data-auto-dismiss="5000">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-response" id="msg">
                                    <?php
                                    if (!empty(getSessionData('MSG'))) {
                                        echo getSessionData('MSG');
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-breifs">
                        <ul>
                            <li>
                                <a href="" class="blue-dot"><span class="mdi mdi-record"></span> Active
                                </a>
                            </li>
                            <li>
                                <a href="" class="green-dot"> <span class="mdi mdi-record"></span> Done </a>
                            </li>
                            <li>
                                <a href="" class="yellow-dot"> <span class="mdi mdi-record"></span> Optional
                                </a>
                            </li>
                            <li>
                                <a href="" class="red-dot"> <span class="mdi mdi-record"></span> Required
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="ryt-dash-breadcrumb">
                    <div class="btns-sec">

                        <a href="javascript:void(0)" class="quick-btn gray-btn" onclick="window.history.back()"><span class="mdi mdi-chevron-double-left"></span>Back</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 ">
                    <div class="crnt-page-head">
                        <div class="current-pg-title">
                            <h6>E-File Miscellaneous Documents</h6>
                        </div>
                        <div class="current-pg-actions">
                            <?php
                            if ((getSessionData('efiling_details')['stage_id'] == DRAFT_STAGE) || (getSessionData('efiling_details')['stage_id'] == INITIAL_DEFECTED_STAGE) ||  (getSessionData('efiling_details')['stage_id'] == TRASH_STAGE)) {
                                $efiling_num_label_for_display = 'DRAFT-';;
                                $efiling_num_button_background_class = 'btn-danger';
                            } else {
                                $efiling_num_label_for_display = '';
                                $efiling_num_button_background_class = 'btn-success';
                            }
                            $filing_num_label = '';
                            $final_submit_action = '';

                            if (isset(getSessionData('efiling_details')['efiling_no']) && !empty(getSessionData('efiling_details')['efiling_no'])) {
                                echo '<a href="javascript::void(0); " class="quick-btn transparent-btn btn-danger ' . $efiling_num_button_background_class . ' btn-sm"  id="copyTarget_EfilingNumber">' . $filing_num_label . $efiling_num_label_for_display . htmlentities(efile_preview(getSessionData('efiling_details')['efiling_no']), ENT_QUOTES) . '</a><strong id="copyButton" class="quick-btn btn btn-danger btn-sm" style="font-size: 14px;color:greenyellow;"><span class="fa fa-copy" style="font-size:14px;color:#ffffff;"></span></strong>';
                            }
                            ?>
                            <a class="quick-btn gray-btn" href="<?php echo base_url('history/efiled_case/view'); ?>"> E-filling History</a>
                            <?php if ($_SESSION['efiling_details']['stage_id'] == Draft_Stage) { ?>
                                <a href="<?php echo base_url('userActions/trash'); ?>" class="quick-btn gradient-btn" onclick="return confirm('This action is irreversible. Are you sure that you really want to trash this record?  .')">Trash</a>
                                <!-- <a class="btn btn-danger btn-sm" onclick="ActionToTrash('UAT')">Trash</a> -->
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
echo remark_preview($_SESSION['efiling_details']['registration_id'], $_SESSION['efiling_details']['stage_id']);
?>
<div class="dash-card dashboard-section tabs-section">
    <div class="tabs-sec-inner">
        <form action="">
            <?php
            $StageArray = explode(',', $_SESSION['efiling_details']['breadcrumb_status']);
            $disabled_status = 'pointer-events: none; cursor: default;';
            if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE || $_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON) {
                $cnr_url = base_url('case_details');
                $appearing_url = base_url('appearing_for');
                $onbehlaf_url = base_url('on_behalf_of');
                $upload_doc_url = base_url('uploadDocuments');
                $doc_index_url = base_url('documentIndex');
                $fee_url = base_url('miscellaneous_docs/courtFee');
                //$aff_url = base_url('affirmation');
                $shareDoc = base_url('shareDoc');
            } else {
                $cnr_url = $appearing_url = $onbehlaf_url = $sign_url = $upload_doc_url = $fee_url = $shareDoc = $aff_url = '#';
            }
            $reditectUrl = "";
            if (empty($this->uri->uri_string)) {
                if (in_array(MISC_BREAD_CASE_DETAILS, $StageArray)) {
                    $reditectUrl = 'appearing_for';
                }
            } else {
                $reditectUrl = $this->uri->uri_string;
            }
            $Array = array(New_Filing_Stage, Initial_Defects_Cured_Stage, DEFICIT_COURT_FEE_PAID, HOLD, DISPOSED);
            $ArrayHOLD = array(HOLD);
            $ArrayDISPOSED = array(DISPOSED);
            if (($_SESSION['login']['ref_m_usertype_id'] == USER_ADMIN || $_SESSION['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN) && in_array($_SESSION['efiling_details']['stage_id'], $Array)) {
                if ($details['details'][0]['c_status'] != 'D') {
                    if ((!in_array($_SESSION['efiling_details']['stage_id'], $ArrayDISPOSED))) {
                        echo '<a data-toggle="modal" href="#approveModal" class="btn btn-success btn-sm">Approve</a>
                              <a data-toggle="modal" href="#disapproveModal" class="btn btn-danger btn-sm">Disapprove</a>';
                        if ((!in_array($_SESSION['efiling_details']['stage_id'], $ArrayHOLD))) {
                            echo '<a data-toggle="modal" href="#holdModal" class="btn btn-danger btn-sm">Hold</a>';
                        }
                        echo '<a data-toggle="modal" href="#disposedModal" class="btn btn-success btn-sm">Disposed</a>';
                    }
                }
                if ((!in_array($_SESSION['efiling_details']['stage_id'], $ArrayDISPOSED))) {
                    echo $details['details'][0]['c_status'] == 'D' ? '<a data-toggle="modal" href="#disposedModal" class="btn btn-success btn-sm" >Disposed</a>' : '';
                }
            }
            ?>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <?php
                    if ($segment->getSegment(1) == 'case_details') {
                        $ColorCode = 'background-color: #01ADEF';
                        $status_color = 'first active';
                    } elseif (in_array(MISC_BREAD_CASE_DETAILS, $StageArray)) {
                        $ColorCode = 'background-color: #169F85;color:#ffffff;';
                        $status_color = '';
                    } else {
                        $ColorCode = 'background-color: #C11900;color:#ffffff;';
                        $status_color = '';
                    }
                    ?>
                    <a href="<?= $cnr_url; ?>" class="nav-link <?php echo $status_color; ?>" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true" style="z-index:10;">
                        <span class="tab-num" style="<?php echo $ColorCode; ?>">1</span> Case Details
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <?php
                    if ($segment->getSegment(1) == 'appearing_for') {
                        $ColorCode = 'background-color: #01ADEF';
                        $status_color = 'first active';
                    } elseif (in_array(MISC_BREAD_APPEARING_FOR, $StageArray)) {
                        $ColorCode = 'background-color: #169F85;color:#ffffff;';
                        $status_color = '';
                    } else {
                        $ColorCode = 'background-color: #C11900;color:#ffffff;';
                        $status_color = '';
                    }
                    ?>

                    <a href="<?= $appearing_url; ?>" class="nav-link <?php echo $status_color; ?>" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true" style="
                     <?php if (!in_array(MISC_BREAD_CASE_DETAILS, $StageArray)) {
                            echo $disabled_status;
                        } ?>"><span class="tab-num" style="<?php echo $ColorCode; ?>">2</span> Appearing for</a>
                </li>
                <li class="nav-item" role="presentation">
                    <?php
                    if ($segment->getSegment(1) == 'on_behalf_of') {
                        $ColorCode = 'background-color: #01ADEF';
                        $status_color = 'first active';
                    } elseif (in_array(MISC_BREAD_ON_BEHALF_OF, $StageArray)) {
                        $ColorCode = 'background-color: #169F85;color:#ffffff;';
                        $status_color = '';
                    } else {
                        $ColorCode = 'background-color: #C11900;color:#ffffff;';
                        $status_color = '';
                    }
                    ?>
                    <a href="<?= $onbehlaf_url; ?>" class="nav-link <?php echo $status_color; ?>" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true" style=" 
                    <?php if (!in_array(MISC_BREAD_APPEARING_FOR, $StageArray)) {
                        echo $disabled_status;
                    } ?>"><span class="tab-num" style="<?php echo $ColorCode; ?>">3</span> Filing For</a>
                </li>
                <li class="nav-item" role="presentation">

                    <?php
                    if ($segment->getSegment(1) == 'uploadDocuments' || $segment->getSegment(1) == 'documentIndex') {
                        $ColorCode = 'background-color: #01ADEF';
                        $status_color = 'first active';
                    } elseif (in_array(MISC_BREAD_UPLOAD_DOC, $StageArray)) {
                        $ColorCode = 'background-color: #169F85;color:#ffffff;';
                        $status_color = '';
                    } else {

                        $ColorCode = 'background-color: #C11900;color:#ffffff;';
                        $status_color = '';
                    }
                    ?>
                    <a href="<?= $doc_index_url ?? '' ?>" class="nav-link <?php echo $status_color; ?>" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true" style=" 
                    <?php if (!in_array(MISC_BREAD_ON_BEHALF_OF, $StageArray)) {
                        echo $disabled_status;
                    } ?>"><span class="tab-num" style="<?php echo $ColorCode; ?>">4</span> Upload Document / Index</a>

                </li>
                <li class="nav-item" role="presentation">

                    <?php
                    if ($segment->getSegment(2) == 'courtFee') {
                        $ColorCode = 'background-color: #01ADEF';
                        $status_color = 'first active';
                    } elseif (in_array(MISC_BREAD_COURT_FEE, $StageArray)) {
                        $ColorCode = 'background-color: #169F85;color:#ffffff;';
                        $status_color = '';
                    } else {
                        if ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
                            $ColorCode = 'background-color: #f0ad4e;color:#ffffff;';
                            $status_color = '';
                        } else {
                            $ColorCode = 'background-color: #C11900;color:#ffffff;';
                            $status_color = '';
                        }
                    }
                    ?>
                    <a href="<?= $fee_url; ?>" class="nav-link <?php echo $status_color; ?>" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true" style="  
                    <?php if (!in_array(MISC_BREAD_DOC_INDEX, $StageArray)) {
                        echo $disabled_status;
                    } ?>"><span class="tab-num" style="<?php echo $ColorCode; ?>">5</span> Court Fee </a>
                </li>
                <li class="nav-item" role="presentation">
                    <?php
                    if ($segment->getSegment(2) == 'view') {
                        $ColorCode = 'background-color: #01ADEF';
                        $status_color = 'first active';
                    } elseif (in_array(MISC_BREAD_CASE_DETAILS, $StageArray) && in_array(MISC_BREAD_ON_BEHALF_OF, $StageArray) && in_array(MISC_BREAD_UPLOAD_DOC, $StageArray) && in_array(MISC_BREAD_SHARE_DOC, $StageArray)) {
                        $ColorCode = 'background-color: #169F85;color:#ffffff;';
                        $status_color = '';
                    } else {
                        $ColorCode = 'background-color: #C11900;color:#ffffff;';
                        $status_color = '';
                    }
                    ?>
                    <a href="<?= base_url('miscellaneous_docs/view') ?>" class="nav-link <?php echo $status_color; ?>" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true" style="z-index:1;"><span class="tab-num" style="<?php echo $ColorCode; ?>">7</span> View </a>
                </li>
            </ul>
            <div class="row m-3 ">
                <div class="col-md-12 text-end">

                    <?php 
                   /*  $Array = array(Draft_Stage, Initial_Defected_Stage, DEFICIT_COURT_FEE, I_B_Defected_Stage, I_B_Rejected_Stage, E_REJECTED_STAGE);
                    $_SESSION['efiling_details']['gras_payment_status'] = 'Y';
                    if($segment->getSegment(2) == 'view'){
                    if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE || $_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON) {
                        if (in_array($_SESSION['efiling_details']['stage_id'], $Array)) {
                            if (in_array(MISC_BREAD_COURT_FEE, explode(',', $_SESSION['efiling_details']['breadcrumb_status']))) {

                                if ((isset($_SESSION['efiling_details']['gras_payment_status']) && $_SESSION['efiling_details']['gras_payment_status'] != 'P') ||
                                    (isset($_SESSION['efiling_details']['gras_payment_status']) && $_SESSION['efiling_details']['gras_payment_status'] == 'Y' && $_SESSION['efiling_details']['payment_verified_by'] != NULL &&
                                        (isset($_SESSION['efiling_details']['is_payment_defecit']) && $_SESSION['efiling_details']['is_payment_defecit'] == 't' || isset($_SESSION['efiling_details']['is_payment_defective']) && $_SESSION['efiling_details']['is_payment_defective'] == 't')
                                    )
                                ) {

                                    echo '<a href="' . base_url('miscellaneous_docs/FinalSubmit') . '" class="btn btn-success btn-sm">Final Submit</a>';
                                    // $finalButton = '<a href="' . base_url('miscellaneous_docs/FinalSubmit') . '" class="btn btn-success btn-sm">Final Submit</a>';
                                } else {
                                    
                                }
                            }
                            if ($_SESSION['efiling_details']['stage_id'] == Draft_Stage) { ?>
                                <!-- <a class="btn btn-danger btn-sm" onclick="ActionToTrash('UAT')">Trash</a> -->
                                <!-- <a href="javascript:void(0)" class="quick-btn gradient-btn" onclick="ActionToTrash('UAT')">Trash</a> -->
                    <?php }
                        }
                    }
                } */
                    ?>
                </div>
            </div>
        </form>
        <div class="modal fade" id="FinalSubmitModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Note :- </h4>
                    </div>
                    <div class="modal-body">
                        <div class=" text-center">
                            <?php
                            /* $ci = & get_instance();
                                                  $ci->load->model('Department_model');
                                                  $dept_all_adv_panel_list = $ci->Department_model->get_all_advocate_panel($_SESSION['login']['id']);

                                                  $dept_adv_panel_list = $ci->Department_model->get_advocate_panel($_SESSION['login']['id']);
                                                  $advocate = $ci->Department_model->get_alloted_advocate($_SESSION['efiling_details']['registration_id']); */

                            $action = base_url('miscellaneous_docs/FinalSubmit');
                            $attribute = array('name' => 'submit_adv_panel', 'id' => 'submit_adv_panel', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data');
                            echo form_open($action, $attribute);
                            ?>

                            <div class="col-md-5 col-sm-6 col-xs-10">

                                <select id="advocate_list" name="advocate_list" class="form-control " style="width: 100%">
                                    <option value="">Practicing On this establishment</option>
                                    <?php
                                    if (isset($dept_adv_panel_list)) {
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
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-10">

                                <select id="advocate_list1" name="advocate_list1" class="form-control" style="width: 100%">
                                    <option value="">Select Panel Advocate</option>
                                    <?php
                                    if (isset($dept_all_adv_panel_list)) {
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
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                            <input type="submit" class="btn btn-success btn-sm" name="Submit" value="Submit">
                            <?php echo form_close(); ?>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- </div>
</div> -->

        <div class="right_col" role="main">
            <?php
            if (($_SESSION['efiling_details']['stage_id'] == DRAFT_STAGE) || ($_SESSION['efiling_details']['stage_id'] == INITIAL_DEFECTED_STAGE) || ($_SESSION['efiling_details']['stage_id'] == TRASH_STAGE)) {
                $efiling_num_label_for_display = 'DRAFT-';;
                $efiling_num_button_background_class = 'btn-danger';
            } else {
                $efiling_num_label_for_display = '';
                $efiling_num_button_background_class = 'btn-success';
            }
            $uris = service('uri');
            $filing_num_label = '';
            ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-response" id="msg"><?php
                                                            if (isset($_SESSION['MSG']) && !empty($_SESSION['MSG'])) {
                                                                echo $_SESSION['MSG'];
                                                            }
                                                            unset($_SESSION['MSG']);
                                                            ?>
                        </div>
                        <?php echo getSessionData('msg'); ?>
                        <div class="view_data">
                            <!-- <div id="modal_loader">
                        <img id="loader_img" style="margin-top: 30px;margin-left: 30px;display:block;" src="<?php echo base_url('assets/images/loading-data.gif'); ?>" />
                    </div> -->
                            <div class="clearfix"></div>
                            <?php
                            //echo remark_preview($_SESSION['efiling_details']['registration_id'], $_SESSION['efiling_details']['stage_id']);
                            ?>
                            <div class="x_panel x-panel_height">
                                <!-- <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-left">
                            <ul class="text-left1">
                                <li style="float: left;list-style-type: none;"><i class="badge" style="background-color: #01ADEF; color:#01ADEF; ">A</i> Active &nbsp;</li>
                                <li style="float: left;list-style-type: none;"><i class="badge" style="background-color: #169F85; color:#169F85;">D</i> Done &nbsp;</li>
                                <li style="float: left;list-style-type: none;"><i class="badge" style="background-color: #f0ad4e; color:#f0ad4e;">O</i> Optional &nbsp;</li>
                                <li style="float: left;list-style-type: none;"><i class="badge" style="background-color: #C11900; color:#C11900;">R</i> Required &nbsp;</li>
                            </ul>
                        </div> -->

                                <div class=" col-lg-8 col-md-8 col-sm-6 col-xs-12 text-right">
                                    <?php

                                    // $Array = array(New_Filing_Stage, Initial_Defects_Cured_Stage, DEFICIT_COURT_FEE_PAID, HOLD, DISPOSED);
                                    // $ArrayHOLD = array(HOLD);
                                    // $ArrayDISPOSED = array(DISPOSED);<strong id="copyButton" class="btn btn-danger btn-sm"  style="font-size: 14px;color:greenyellow;"><span class="glyphicon glyphicon-copy" style="font-size:14px;color:#ffffff;"></span></strong>
                                    // if (($_SESSION['login']['ref_m_usertype_id'] == USER_ADMIN || $_SESSION['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN) && in_array($_SESSION['efiling_details']['stage_id'], $Array)) {
                                    ?>
                                    <?php
                                    // if ($details['details'][0]['c_status'] != 'D') {
                                    ?>
                                    <?php
                                    // if ((!in_array($_SESSION['efiling_details']['stage_id'], $ArrayDISPOSED))) { 
                                    ?>
                                    <!-- <a data-toggle="modal" href="#approveModal" class="btn btn-success btn-sm">Approve</a>
                                    //     <a data-toggle="modal" href="#disapproveModal" class="btn btn-danger btn-sm">Disapprove</a> -->
                                    <?php
                                    //     if ((!in_array($_SESSION['efiling_details']['stage_id'], $ArrayHOLD))) {
                                    //         echo '<a data-toggle="modal" href="#holdModal" class="btn btn-danger btn-sm">Hold</a>';
                                    //     } 
                                    ?>
                                    <!-- <a data-toggle="modal" href="#disposedModal" class="btn btn-success btn-sm">Disposed</a> -->
                                    <?php //} 
                                    ?>

                                    <?php //} 
                                    ?>

                                    <?php

                                    // if ((!in_array($_SESSION['efiling_details']['stage_id'], $ArrayDISPOSED))) {<strong id="copyButton" class="btn btn-danger btn-sm"  style="font-size: 14px;color:greenyellow;"><span class="glyphicon glyphicon-copy" style="font-size:14px;color:#ffffff;"></span></strong>
                                    //     echo $details['details'][0]['c_status'] == 'D' ? '<a data-toggle="modal" href="#disposedModal" class="btn btn-success btn-sm" >Disposed</a>' : '';
                                    // } 
                                    ?>

                                    <?php //} 
                                    ?>

                                    <?php
                                    // $Array = array(Draft_Stage, Initial_Defected_Stage, DEFICIT_COURT_FEE, I_B_Defected_Stage, I_B_Rejected_Stage, E_REJECTED_STAGE);
                                    // if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE || $_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON) {
                                    //     if (in_array($_SESSION['efiling_details']['stage_id'], $Array)) {
                                    //         // if (in_array(MISC_BREAD_AFFIRMATION, explode(',', $_SESSION['efiling_details']['breadcrumb_status']))) {
                                    //         if (in_array(MISC_BREAD_COURT_FEE, explode(',', $_SESSION['efiling_details']['breadcrumb_status']))) {

                                    //             if (($_SESSION['efiling_details']['gras_payment_status'] != 'P') ||<strong id="copyButton" class="btn btn-danger btn-sm"  style="font-size: 14px;color:greenyellow;"><span class="glyphicon glyphicon-copy" style="font-size:14px;color:#ffffff;"></span></strong>
                                    //                 ($_SESSION['efiling_details']['gras_payment_status'] == 'Y' && $_SESSION['efiling_details']['payment_verified_by'] != NULL &&
                                    //                     ($_SESSION['efiling_details']['is_payment_defecit'] == 't' || $_SESSION['efiling_details']['is_payment_defective'] == 't')
                                    //                 )
                                    //             ) {
                                    //                 echo '<a href="' . base_url('miscellaneous_docs/FinalSubmit') . '" class="btn btn-success btn-sm">Final Submit</a>';
                                    //             }
                                    //         }
                                    ?>
                                    <?php // if ($_SESSION['efiling_details']['stage_id'] == Draft_Stage) { 
                                    ?>
                                    <!--<a href="<?php /*echo base_url('userActions/trash'); */ ?>" class="btn btn-danger btn-sm" onclick="return confirm('This action is irreversible. Are you sure that you really want to trash this record?  .')" >Trash</a>-->
                                    <!-- <a class="btn btn-danger btn-sm" onclick="ActionToTrash('UAT')">Trash</a> -->
                                    <?php
                                    //         }
                                    //     }
                                    // }
                                    ?>
                                </div>
                            </div>
                            <div class="x_panel">
                                <div class="x_title">
                                    <!-- <div class="registration-process" style="float: left; border: none;">
                                <h2><i class="glyphicon glyphicon-book"></i> E-File Miscellaneous Documents </h2>
                                <div class="clearfix"></div>
                            </div> -->
                                    <!-- <div style="float: right">
                                <?php
                                // if (isset($_SESSION['efiling_details']['efiling_no']) && !empty($_SESSION['efiling_details']['efiling_no'])) {
                                //     echo '<a href="javascript::void(0); " class="btn ' . $efiling_num_button_background_class . ' btn-sm"  style="color: #ffffff"><strong id="copyTarget_EfilingNumber">' . $filing_num_label . $efiling_num_label_for_display . htmlentities(efile_preview($_SESSION['efiling_details']['efiling_no']), ENT_QUOTES) . '</strong></a> &nbsp;<strong id="copyButton" class="btn btn-danger btn-sm"  style="font-size: 14px;color:greenyellow;"><span class="glyphicon glyphicon-copy" style="font-size:14px;color:#ffffff;"></span></strong>';
                                // }

                                ?>
                                &nbsp; <a class="btn btn-default btn-sm" href="<?php echo base_url('history/efiled_case/view'); ?>"> eFiling History</a>
                                &nbsp; <a class="btn btn-info btn-sm" type="button" onclick="window.history.back()"> Back</a>
                            </div> -->
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <?php
                                    // $StageArray = explode(',', $_SESSION['efiling_details']['breadcrumb_status']);
                                    // $disabled_status = 'pointer-events: none; cursor: default;';
                                    // if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE || $_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON) {
                                    //     $cnr_url = base_url('case_details');
                                    //     $appearing_url = base_url('appearing_for');
                                    //     $onbehlaf_url = base_url('on_behalf_of');
                                    //     $upload_doc_url = base_url('uploadDocuments');
                                    //     $doc_index_url = base_url('documentIndex');
                                    //     $fee_url = base_url('miscellaneous_docs/courtFee');
                                    //     //$aff_url = base_url('affirmation');
                                    //     $shareDoc = base_url('shareDoc');
                                    // } else {
                                    //     $cnr_url = $appearing_url = $onbehlaf_url = $sign_url = $upload_doc_url = $fee_url = $shareDoc = $aff_url = '#';
                                    // }

                                    ?>
                                    <!-- <ul class="nav-breadcrumb">
                                <li>

                                    <?php
                                    // if ($uris->getSegment(1) == 'case_details') {
                                    //     $ColorCode = 'background-color: #01ADEF';
                                    //     $status_color = 'first active';
                                    // } elseif (in_array(MISC_BREAD_CASE_DETAILS, $StageArray)) {
                                    //     $ColorCode = 'background-color: #169F85;color:#ffffff;';
                                    //     $status_color = '';
                                    // } else {
                                    //     $ColorCode = 'background-color: #C11900;color:#ffffff;';
                                    //     $status_color = '';
                                    // }
                                    ?>
                                    <a href="<?php // $cnr_url; 
                                                ?>" class="<?php // echo $status_color; 
                                                            ?>" style="z-index:9;"><span style="<?php // echo $ColorCode; 
                                                                                                ?>">1</span> Case Details </a>

                                </li>
                                <li>

                                    <?php
                                    // if ($uris->getSegment(1) == 'appearing_for') {
                                    //     $ColorCode = 'background-color: #01ADEF';
                                    //     $status_color = 'first active';
                                    // } elseif (in_array(MISC_BREAD_APPEARING_FOR, $StageArray)) {
                                    //     $ColorCode = 'background-color: #169F85;color:#ffffff;';
                                    //     $status_color = '';
                                    // } else {
                                    //     $ColorCode = 'background-color: #C11900;color:#ffffff;';
                                    //     $status_color = '';
                                    // }
                                    ?>
                                    <a href="<?php // $appearing_url; 
                                                ?>" class="<?php  // echo $status_color; 
                                                            ?>" style="z-index:8; <?php // if (!in_array(MISC_BREAD_CASE_DETAILS, $StageArray)) {
                                                                                    // echo $disabled_status;
                                                                                    //  } 
                                                                                    ?>"><span style="<?php // echo $ColorCode; 
                                                                                                        ?>">2</span> Appearing for</a>

                                </li>
                                <li>

                                    <?php
                                    // if ($uris->getSegment(1) == 'on_behalf_of') {
                                    //     $ColorCode = 'background-color: #01ADEF';
                                    //     $status_color = 'first active';
                                    // } elseif (in_array(MISC_BREAD_ON_BEHALF_OF, $StageArray)) {
                                    //     $ColorCode = 'background-color: #169F85;color:#ffffff;';
                                    //     $status_color = '';
                                    // } else {
                                    //     $ColorCode = 'background-color: #C11900;color:#ffffff;';
                                    //     $status_color = '';
                                    // }
                                    ?>
                                    <a href="<?php // $onbehlaf_url; 
                                                ?>" class="<?php // echo $status_color; 
                                                            ?>" style="z-index:7; <?php // if (!in_array(MISC_BREAD_APPEARING_FOR, $StageArray)) {
                                                                                    //  echo $disabled_status;
                                                                                    // } 
                                                                                    ?>"><span style="<?php //  echo $ColorCode; 
                                                                                                        ?>">3</span> Filing For</a>

                                </li>



                                <li>

                                    <?php
                                    // if ($uris->getSegment(1) == 'uploadDocuments' || $uris->getSegment(1) == 'documentIndex') {
                                    //     $ColorCode = 'background-color: #01ADEF';
                                    //     $status_color = 'first active';
                                    // } elseif (in_array(MISC_BREAD_UPLOAD_DOC, $StageArray)) {
                                    //     $ColorCode = 'background-color: #169F85;color:#ffffff;';
                                    //     $status_color = '';
                                    // } else {

                                    //     $ColorCode = 'background-color: #C11900;color:#ffffff;';
                                    //     $status_color = '';
                                    // }
                                    ?>
                                    <a href="<?php // $doc_index_url ?? '' 
                                                ?>" class="<?php // echo $status_color; 
                                                            ?>" style="z-index:6; <?php //if (!in_array(MISC_BREAD_ON_BEHALF_OF, $StageArray)) {
                                                                                    //     echo $disabled_status;
                                                                                    // } 
                                                                                    ?>"><span style="<?php // echo $ColorCode; 
                                                                                                        ?>">4</span> Upload Document / Index</a>

                                </li> -->

                                    <!--<li>
                                <?php
                                /*                                    if ($uris->getSegment(1) == 'documentIndex') {
                                        $ColorCode = 'background-color: #01ADEF';
                                        $status_color = 'first active';
                                    } elseif (in_array(MISC_BREAD_DOC_INDEX, $StageArray)) {
                                        $ColorCode = 'background-color: #169F85;color:#ffffff;';
                                        $status_color = '';
                                    } else {
                                        $ColorCode = 'background-color: #C11900;color:#ffffff;';
                                        $status_color = '';
                                    }
                                    */ ?>
                                    <a href="<?/*= $doc_index_url */ ?>" class="<?php /*echo $status_color; */ ?>" style="z-index:5; <?php /*if(!in_array(MISC_BREAD_UPLOAD_DOC, $StageArray)){ echo $disabled_status;} */ ?>"><span style="<?php /*echo $ColorCode; */ ?>">5</span> Index  </a>
                                </li>-->

                                    <!-- <li> -->

                                    <?php
                                    // if ($uris->getSegment(2) == 'courtFee') {
                                    //     $ColorCode = 'background-color: #01ADEF';
                                    //     $status_color = 'first active';
                                    // } elseif (in_array(MISC_BREAD_COURT_FEE, $StageArray)) {
                                    //     $ColorCode = 'background-color: #169F85;color:#ffffff;';
                                    //     $status_color = '';
                                    // } else {
                                    //     if ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
                                    //         $ColorCode = 'background-color: #f0ad4e;color:#ffffff;';
                                    //         $status_color = '';
                                    //     } else {
                                    //         $ColorCode = 'background-color: #C11900;color:#ffffff;';
                                    //         $status_color = '';
                                    //     }
                                    // }
                                    ?>
                                    <!-- <a href="<?php // $fee_url; 
                                                    ?>" class="<?php // echo $status_color; 
                                                                ?>" style="z-index:4; <?php // if (!in_array(MISC_BREAD_DOC_INDEX, $StageArray)) {
                                                                                        //     echo $disabled_status;
                                                                                        // } 
                                                                                        ?>"><span style="<?php //echo $ColorCode; 
                                                                                                            ?>">5</span> Court Fee </a> -->

                                    <!-- </li> -->
                                    <!--<li>

                                    <?php
                                    /*
                                    if ($uris->getSegment(1) == 'shareDoc') { //Modify the code on 1 feb 21 to show tab selected on its click
                                        $ColorCode = 'background-color: #01ADEF';
                                        $status_color = 'first active';
                                    } elseif (in_array(MISC_BREAD_SHARE_DOC, $StageArray)) {
                                        $ColorCode = 'background-color: #169F85;color:#ffffff;';
                                        $status_color = '';
                                    } else {
                                        $ColorCode = 'background-color: #f0ad4e;color:#ffffff;';
                                        $status_color = '';
                                    }
                                    */ ?>
                                    <a href="<?/*= $shareDoc; */ ?>" class="<?php /*echo $status_color; */ ?>" style="z-index:3; <?php /*if(!in_array(MISC_BREAD_COURT_FEE, $StageArray)){ echo $disabled_status;} */ ?>"><span style="<?php /*echo $ColorCode; */ ?>">6</span> Share Document  </a>

                                </li>-->
                                    <!-- <li>
                                    <?php
                                    /*                                    if ($uris->getSegment(1) == 'affirmation') {
                                        $ColorCode = 'background-color: #01ADEF';
                                        $status_color = 'first active';
                                    } elseif (in_array(MISC_BREAD_AFFIRMATION, $StageArray)) {

                                        $ColorCode = 'background-color: #169F85;color:#ffffff;';
                                        $status_color = '';
                                    } else {
                                        if ($_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
                                            $ColorCode = 'background-color: #f0ad4e;color:#ffffff;';
                                            $status_color = '';
                                        } else {
                                            $ColorCode = 'background-color: #C11900;color:#ffffff;';
                                            $status_color = '';
                                        }
                                    }
                                    */ ?>
                                    <a href="<?/*= $aff_url; */ ?>" class="<?php /*echo $status_color; */ ?>" style="z-index:2; <?php /*if(!in_array(MISC_BREAD_COURT_FEE, $StageArray)){ echo $disabled_status;} */ ?>"><span style="<?php /*echo $ColorCode; */ ?>">8</span> Affirmation </a>
                                </li>-->
                                    <!-- <li> -->
                                    <?php
                                    // if ($uris->getSegment(2) == 'view') {
                                    //     $ColorCode = 'background-color: #01ADEF';
                                    //     $status_color = 'first active';
                                    //     //} elseif (in_array(MISC_BREAD_CASE_DETAILS, $StageArray) && in_array(MISC_BREAD_ON_BEHALF_OF, $StageArray) && in_array(MISC_BREAD_UPLOAD_DOC, $StageArray) && in_array(MISC_BREAD_AFFIRMATION, $StageArray)) {
                                    // } elseif (in_array(MISC_BREAD_CASE_DETAILS, $StageArray) && in_array(MISC_BREAD_ON_BEHALF_OF, $StageArray) && in_array(MISC_BREAD_UPLOAD_DOC, $StageArray) && in_array(MISC_BREAD_SHARE_DOC, $StageArray)) {
                                    //     $ColorCode = 'background-color: #169F85;color:#ffffff;';
                                    //     $status_color = '';
                                    // } else {
                                    //     $ColorCode = 'background-color: #C11900;color:#ffffff;';
                                    //     $status_color = '';
                                    // }
                                    ?>
                                    <!-- <a href="<?php // base_url('miscellaneous_docs/view') 
                                                    ?>" class="<?php //echo $status_color; 
                                                                ?>" style="z-index:1;"><span style="<?php // echo $ColorCode; 
                                                                                                    ?>">7</span> View </a> -->
                                    <!-- </li> -->
                                    </ul>
                                    <div class="clearfix"></div>
                                    <br />
                                    <div class="modal fade" id="FinalSubmitModal" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Note :- </h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class=" text-center">
                                                        <?php
                                                        /* $ci = & get_instance();
                                                  $ci->load->model('Department_model');
                                                  $dept_all_adv_panel_list = $ci->Department_model->get_all_advocate_panel($_SESSION['login']['id']);

                                                  $dept_adv_panel_list = $ci->Department_model->get_advocate_panel($_SESSION['login']['id']);
                                                  $advocate = $ci->Department_model->get_alloted_advocate($_SESSION['efiling_details']['registration_id']); */

                                                        $action = base_url('miscellaneous_docs/FinalSubmit');
                                                        $attribute = array('name' => 'submit_adv_panel', 'id' => 'submit_adv_panel', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data');
                                                        echo form_open($action, $attribute);
                                                        ?>

                                                        <div class="col-md-5 col-sm-6 col-xs-10">

                                                            <select id="advocate_list" name="advocate_list" class="form-control " style="width: 100%">
                                                                <option value="">Practicing On this establishment</option>
                                                                <?php
                                                                if (isset($dept_adv_panel_list)) {
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
                                                                <?php }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6 col-xs-10">

                                                            <select id="advocate_list1" name="advocate_list1" class="form-control" style="width: 100%">
                                                                <option value="">Select Panel Advocate</option>
                                                                <?php
                                                                if (isset($dept_all_adv_panel_list)) {
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
                                                                <?php }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <input type="submit" class="btn btn-success btn-sm" name="Submit" value="Submit">
                                                        <?php echo form_close(); ?>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>