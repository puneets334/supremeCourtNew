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
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/responsive.css" rel="stylesheet">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/black-theme.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= base_url() . 'assets/newAdmin/' ?>css/jquery.dataTables.min.css">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/fullcalendar.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery-ui.css">
<link href="<?= base_url() . 'assets' ?>/css/select2.min.css" rel="stylesheet">
<style>
    #msg {
        padding: 15px;
        color: #000;
    }
</style>

<div class="dash-card dashboard-section">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class=" dashboard-bradcrumb">
                <div class="left-dash-breadcrumb">
                    <div class="page-title">
                        <?php
                        $commonHeading = '';
                        $filing_type = '';
                        if (getSessionData('customEfil') == 'ia') {
                            // unset($_SESSION['efiling_type']);
                            $filing_type = 'ia';
                            $commonHeading = 'File An IA';
                        } elseif (getSessionData('customEfil') == 'misc') {
                            $filing_type = 'misc';
                            $commonHeading = 'File A Document';
                        } elseif (getSessionData('customEfil') == 'refile') {
                            $filing_type = 'refile';
                            $commonHeading = 'Refile old efiling cases';
                        }
                        ?>
                        <h5><i class="fa fa-file"></i> {{$commonHeading}}</h5>
                    </div>
                    <!-- Page Title End -->
                    <!-- Response End -->
                    <div class="page-breifs">
                        <ul>
                            <li>
                                <a href=""
                                    class="blue-dot"><span class="mdi mdi-record"></span> Active
                                </a>
                            </li>
                            <li>
                                <a href=""
                                    class="green-dot"> <span class="mdi mdi-record"></span> Done </a>
                            </li>
                            <li>
                                <a href=""
                                    class="yellow-dot"> <span class="mdi mdi-record"></span> Optional
                                </a>
                            </li>
                            <li>
                                <a href=""
                                    class="red-dot"> <span class="mdi mdi-record"></span> Required
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="ryt-dash-breadcrumb">
                    <div class="">
                        <?php
                        $Array = array(New_Filing_Stage, Initial_Defects_Cured_Stage, DEFICIT_COURT_FEE_PAID, HOLD, DISPOSED);
                        $ArrayHOLD = array(HOLD);
                        $ArrayDISPOSED = array(DISPOSED);
                        if ((getSessionData('login')['ref_m_usertype_id'] == USER_ADMIN || getSessionData('login')['ref_m_usertype_id'] == USER_ACTION_ADMIN) && in_array(getSessionData('efiling_details')['stage_id'], $Array)) {
                            // if ($details['details'][0]['c_status'] != 'D') {
                            if ($details[0]['c_status'] != 'D') {
                                if ((!in_array(getSessionData('efiling_details')['stage_id'], $ArrayDISPOSED))) {
                        ?>
                                    <a data-bs-toggle="modal" href="#approveModal" class="btn quick-btn success-btn btn-success btn-sm" style="background-color:#169F85;">Approve</a>
                                    <a data-bs-toggle="modal" href="#disapproveModal" class="btn quick-btn danger-btn btn-danger btn-sm" style="background-color:#C11900;">Disapprove</a>
                                    <?php
                                    if ((!in_array(getSessionData('efiling_details')['stage_id'], $ArrayHOLD))) {
                                        echo '<a data-bs-toggle="modal" href="#holdModal" class="btn quick-btn danger-btn btn-danger btn-sm" style="background-color:#C11900;">Hold</a>';
                                    }
                                    ?>
                                    <a data-bs-toggle="modal" href="#disposedModal" class="btn quick-btn success-btn btn-success btn-sm" style="background-color:#169F85;">Disposed</a>
                            <?php
                                }
                            }
                            if ((!in_array(getSessionData('efiling_details')['stage_id'], $ArrayDISPOSED))) {
                                // echo $details['details'][0]['c_status'] == 'D' ? '<a data-toggle="modal" href="#disposedModal" class="btn btn-success btn-sm" >Disposed</a>' : '';
                                echo $details[0]['c_status'] == 'D' ? '<a data-toggle="modal" href="#disposedModal" class="btn quick-btn btn-success btn-sm" style="background-color:#169F85;">Disposed</a>' : '';
                            }
                        }
                        $idle_Array = array(Draft_Stage, Initial_Defected_Stage, DEFICIT_COURT_FEE, I_B_Defected_Stage);
                        if ((getSessionData('login')['ref_m_usertype_id'] == USER_ADMIN || getSessionData('login')['ref_m_usertype_id'] == USER_MASTER_ADMIN) && in_array(getSessionData('efiling_details')['stage_id'], $idle_Array) && $segment->getSegment(3) == url_encryption('idle')) {
                            ?>
                            <a data-toggle="modal" href="#lodges_cases" class="btn quick-btn btn-success btn-sm">Make Idle</a>
                            <a data-toggle="modal" href="#delete_lodges_cases" class="btn quick-btn btn-danger btn-sm">Make Idle & Delete</a>
                        <?php
                        }
                        ?>
                        <!-- <a href="javascript:void(0)" class="quick-btn gray-btn" onclick="window.history.back()"><span class="mdi mdi-chevron-double-left pt-1"></span>Back</a> -->
                    </div>
                    <div class="btns-sec">

                        <a href="javascript:void(0)" class="quick-btn pull-right" onclick="window.history.back()"><span class="mdi mdi-chevron-double-left pt-1"></span>Back</a>
                    </div>
                </div>
            </div>

            <div style="clear:both"></div>

            <div class="row">
                <div class="col-12">
                    <div class="form-response" id="msg" role="alert" data-auto-dismiss="5000">
                        <?php
                        if (!empty(getSessionData('MSG'))) {
                            echo getSessionData('MSG');
                        }
                        ?> 
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 ">
                    <div class="crnt-page-head">
                        <div class="current-pg-title">
                            <h6>E-File Interlocutory Application</h6>
                        </div>
                        <div class="current-pg-actions">
                            <?php
                            if ((getSessionData('efiling_details')['stage_id'] == DRAFT_STAGE) || (getSessionData('efiling_details')['stage_id'] == INITIAL_DEFECTED_STAGE) ||
                                (getSessionData('efiling_details')['stage_id'] == TRASH_STAGE)
                            ) {
                                $efiling_num_label_for_display = 'DRAFT-';;
                                $efiling_num_button_background_class = 'btn-danger';
                            } else {
                                $efiling_num_label_for_display = '';
                                $efiling_num_button_background_class = 'btn-success';
                            }
                            $filing_num_label = '';
                            $final_submit_action = '';

                            if (isset(getSessionData('efiling_details')['efiling_no']) && !empty(getSessionData('efiling_details')['efiling_no'])) {
                                echo '<a href="javascript::void(0); " class="quick-btn transparent-btn btn-danger btn-danger btn-sm ' . $efiling_num_button_background_class . ' btn-sm"  style="color: #000" id="copyTarget_EfilingNumber">' . $filing_num_label . $efiling_num_label_for_display . htmlentities(efile_preview(getSessionData('efiling_details')['efiling_no']), ENT_QUOTES) . '</a> &nbsp <strong id="copyButton" class="quick-btn btn btn-danger btn-sm" style="font-size: 14px;color:greenyellow;"><span class="fa fa-copy" style="font-size:14px;color:#ffffff;"></span></strong>';
                            }

                            ?>
                            <a class="quick-btn gray-btn" href="<?php echo base_url('history/efiled_case/view'); ?>"> E-filling History</a>
                            <?php
                            if (getSessionData('efiling_details')['stage_id'] == Draft_Stage) {
                                $final_submit_continue_action = TRUE;
                            ?>
                                <a class="quick-btn gradient-btn" onclick="ActionToTrash('UAT')">Trash</a>
                            <?php
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
echo remark_preview(getSessionData('efiling_details')['registration_id'], getSessionData('efiling_details')['stage_id']);
?>
<div class="dash-card dashboard-section tabs-section">
    <div class="tabs-sec-inner">
        <!-- form--start  -->
        <form action="">
            <?php
            $StageArray = explode(',', getSessionData('efiling_details')['breadcrumb_status']);
            $disabled_status = 'pointer-events: none; cursor: default;';
            if (getSessionData('login')['ref_m_usertype_id'] == USER_ADVOCATE || getSessionData('login')['ref_m_usertype_id'] == USER_IN_PERSON) {

                $case_details_url = base_url('case_details');
                $appearing_url = base_url('appearing_for');
                $onbehlaf_url = base_url('on_behalf_of');
                $index_url = base_url('documentIndex');
                $upload_doc_url = base_url('uploadDocuments');
                $fee_url = base_url('IA/courtFee');
                //$aff_url = base_url('affirmation');
            } else {
                $case_details_url = $appearing_url  = $onbehlaf_url =  $upload_doc_url = $index_url = $fee_url = $aff_url = '#';
            }
            $reditectUrl = "";
            if (empty($this->uri->uri_string)) {
                if (in_array(IA_BREAD_CASE_DETAILS, $StageArray)) {
                    $reditectUrl = 'appearing_for';
                }
                if (in_array(IA_BREAD_APPEARING_FOR, $StageArray)) {
                    $reditectUrl = 'on_behalf_of';
                }
                if (in_array(IA_BREAD_ON_BEHALF_OF, $StageArray)) {
                    $reditectUrl = 'uploadDocuments';
                }
                if (in_array(IA_BREAD_UPLOAD_DOC, $StageArray)) {
                    $reditectUrl = 'documentIndex';
                }
                if (in_array(IA_BREAD_DOC_INDEX, $StageArray)) {
                    $reditectUrl = 'courtFee';
                }
                if (in_array(IA_BREAD_COURT_FEE, $StageArray)) {
                    //$reditectUrl='affirmation';
                    $reditectUrl = 'view';
                }
            } else {
                $reditectUrl = $this->uri->uri_string;
            }

            // $Array = array(Draft_Stage, Initial_Defected_Stage, DEFICIT_COURT_FEE, I_B_Defected_Stage, I_B_Rejected_Stage, E_REJECTED_STAGE);
            // if (getSessionData('login')['ref_m_usertype_id'] == USER_ADVOCATE || getSessionData('login')['ref_m_usertype_id'] == USER_IN_PERSON) 
            // {
            //     if (in_array(getSessionData('efiling_details')['stage_id'], $Array)) 
            //     {

            //         if (in_array(IA_BREAD_COURT_FEE, explode(',', getSessionData('efiling_details')['breadcrumb_status']))) 
            //         {
            //             $_SESSION['efiling_details']['gras_payment_status'] = 'Y';
            //             if (( isset(getSessionData('efiling_details')['gras_payment_status'] ) &&    getSessionData('efiling_details')['gras_payment_status'] != 'P') ||
            //                 (  isset(getSessionData('efiling_details')['gras_payment_status'] ) &&   getSessionData('efiling_details')['gras_payment_status'] == 'Y' && getSessionData('efiling_details')['payment_verified_by'] != NULL &&
            //                     ( isset(getSessionData('efiling_details')['gras_payment_status'] ) &&   getSessionData('efiling_details')['is_payment_defecit'] == 't' || getSessionData('efiling_details')['is_payment_defective'] == 't')
            //                 )) 
            //             {
            //                 $final_submit_action = TRUE;
            //                 echo '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#FinalSubmitModal">Submit</button>';
            //             }
            //         }

            //         if (getSessionData('efiling_details')['stage_id'] == Draft_Stage) 
            //         {
            //             $final_submit_continue_action = TRUE;
            //             
            ?>
             <!-- <a class="btn btn-danger btn-sm" onclick="ActionToTrash('UAT')">Trash</a> -->
            <?php
                //         } 
                //     }
                // }

                // if (getSessionData('login')['ref_m_usertype_id'] == USER_DEPARTMENT) 
                // {
                //     if (in_array(getSessionData('efiling_details')['stage_id'], $Array)) 
                //     {                                
                //         if (in_array(IA_BREAD_UPLOAD_DOC, explode(',', getSessionData('efiling_details')['breadcrumb_status']))) 
                //         {
                //             if ((getSessionData('efiling_details')['gras_payment_status'] != 'P') ||
                //             ( getSessionData('efiling_details')['gras_payment_status'] == 'Y' && getSessionData('efiling_details')['payment_verified_by'] != NULL &&
                //                 (getSessionData('efiling_details')['is_payment_defecit'] == 't' || getSessionData('efiling_details')['is_payment_defective'] == 't')
                //             )) 
                //             {
                //                 $final_submit_action = TRUE;
                //                 if (getSessionData('efiling_details')['stage_id'] == Draft_Stage) {
                //                     echo '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#FinalSubmitModal">Submitww</button>';
                //                 }
                //             }
                //         }                               
                //         if (getSessionData('efiling_details')['stage_id'] == Draft_Stage)
                //         {
                //             $final_submit_continue_action = TRUE;
                //             
                ?>
            <!-- <a class="btn btn-danger btn-sm" onclick="ActionToTrash('SLT')">Trash</a> -->
            <?php
            //         } 

            //     }

            // }
            if (getSessionData('login')['ref_m_usertype_id'] == USER_CLERK) {
                if (getSessionData('efiling_details')['stage_id'] == Draft_Stage) {
                    if (in_array(getSessionData('efiling_details')['stage_id'], $Array)) {
            ?>

                        <div class="col-md-12">
                            <div class="col-md-6"></div>
                            <div class="col-md-6 " style="float: right;">
                                <div class="col-md-10">
                                    <?php
                                    if (in_array(IA_BREAD_UPLOAD_DOC, explode(',', getSessionData('efiling_details')['breadcrumb_status']))) {

                                        if ((getSessionData('efiling_details')['gras_payment_status'] != 'P') ||
                                            (getSessionData('efiling_details')['gras_payment_status'] == 'Y' && getSessionData('efiling_details')['payment_verified_by'] != NULL &&
                                                (getSessionData('efiling_details')['is_payment_defecit'] == 't' || getSessionData('efiling_details')['is_payment_defective'] == 't')
                                            )
                                        ) {
                                            $action = base_url('stage_list/final_submit');
                                            $attribute = array('name' => 'submit_adv_id', 'id' => 'submit_adv_id', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data');
                                            echo form_open($action, $attribute);

                                            // $ci = & get_instance();
                                            $ci->load->model('Clerk_model');
                                            $clerk_adv = $ci->Clerk_model->get_advocate(getSessionData('login')['id']);

                                            echo '<input type="hidden" class="btn btn-primary btn-sm" name="advocate_id" value="' . htmlentities(url_encryption($clerk_adv[0]['id']), ENT_QUOTES) . '" >';
                                            echo '<input type="submit" class="btn btn-primary btn-sm" name="submit" value="Submit" >';
                                            echo form_close();
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="col-md-2 offset-md-4">
                                    <?php
                                    if (getSessionData('efiling_details')['stage_id'] == Draft_Stage) { ?>
                                        <a class="btn btn-danger btn-sm" onclick="ActionToTrash('SLT')">Trash</a>


                                    <?php
                                    }
                                    ?>
                                </div><?PHP
                                    }
                                }
                            }
                                        ?>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <?php
                            //  echo $segment->getSegment(2) ;
                            if ($segment->getSegment(1)  == 'case_details') {
                                $ColorCode = 'background-color: #01ADEF';
                                $status_color = 'first active';
                            } elseif (in_array(IA_BREAD_CASE_DETAILS, $StageArray)) {
                                $ColorCode = 'background-color: #169F85;color:#ffffff;';
                                $status_color = '';
                            } else {
                                $ColorCode = 'background-color: #C11900;color:#ffffff;';
                                $status_color = '';
                            }
                            ?>
                            <a href="<?= $case_details_url; ?>"
                                class="nav-link <?php echo $status_color; ?>"
                                id="home-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#home"
                                type="button"
                                role="tab"
                                aria-controls="home"
                                aria-selected="true"
                                style="z-index:10;">
                                <span class="tab-num" style="<?php echo $ColorCode; ?>">1</span> Case Details
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">

                            <?php
                            if ($segment->getSegment(1) == 'appearing_for') {
                                $ColorCode = 'background-color: #01ADEF';
                                $status_color = 'first active';
                            } elseif (in_array(IA_BREAD_APPEARING_FOR, $StageArray)) {
                                $ColorCode = 'background-color: #169F85;color:#ffffff;';
                                $status_color = '';
                            } else {
                                $ColorCode = 'background-color: #C11900;color:#ffffff;';
                                $status_color = '';
                            }
                            ?>
                            <a href="<?= $appearing_url; ?>"
                                class="nav-link <?php echo $status_color; ?>"
                                id="home-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#home"
                                type="button"
                                role="tab"
                                aria-controls="home"
                                aria-selected="true"
                                style="<?php if (!in_array(IA_BREAD_CASE_DETAILS, $StageArray)) {
                                            echo $disabled_status;
                                        } ?>">
                                <span class="tab-num" style="<?php echo $ColorCode; ?>">2</span> Appearing For</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <?php
                            if ($segment->getSegment(1)  == 'on_behalf_of') {
                                $ColorCode = 'background-color: #01ADEF';
                                $status_color = 'first active';
                            } elseif (in_array(IA_BREAD_ON_BEHALF_OF, $StageArray)) {
                                $ColorCode = 'background-color: #169F85;color:#ffffff;';
                                $status_color = '';
                            } else {
                                $ColorCode = 'background-color: #C11900;color:#ffffff;';
                                $status_color = '';
                            }
                            ?>
                            <a href="<?= $onbehlaf_url; ?>"
                                class="nav-link <?php echo $status_color; ?>"
                                id="home-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#home"
                                type="button"
                                role="tab"
                                aria-controls="home"
                                style="<?php if (!in_array(IA_BREAD_APPEARING_FOR, $StageArray)) {
                                            echo $disabled_status;
                                        } ?>">
                                <span style="<?php echo $ColorCode; ?>" class="tab-num">3</span>IA Applying Party</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <?php
                            if ($segment->getSegment(1)  == 'documentIndex' ||  $segment->getSegment(1)  == 'uploadDocuments') {
                                $ColorCode = 'background-color: #01ADEF';
                                $status_color = 'first active';
                            } elseif (in_array(IA_BREAD_DOC_INDEX, $StageArray)) {
                                $ColorCode = 'background-color: #169F85;color:#ffffff;';
                                $status_color = '';
                            } else {
                                $ColorCode = 'background-color: #C11900;color:#ffffff;';
                                $status_color = '';
                            }
                            ?>
                            <a href="<?= $index_url ?>"
                                class="nav-link <?php echo $status_color; ?>"
                                id="home-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#home"
                                type="button"
                                role="tab"
                                aria-controls="home"
                                style="<?php if (!in_array(IA_BREAD_UPLOAD_DOC, $StageArray)) {
                                            echo $disabled_status;
                                        } ?>">
                                <span style="<?php echo $ColorCode; ?>" class="tab-num">4</span> Upload Document / Index </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <?php
                            if ($segment->getSegment(2)  == 'courtFee') {
                                $ColorCode = 'background-color: #01ADEF';
                                $status_color = 'first active';
                            } elseif (in_array(IA_BREAD_COURT_FEE, $StageArray)) {
                                $ColorCode = 'background-color: #169F85;color:#ffffff;';
                                $status_color = '';
                            } else {

                                if (getSessionData('login')['ref_m_usertype_id'] == USER_DEPARTMENT || getSessionData('login')['ref_m_usertype_id'] == USER_CLERK) {
                                    $ColorCode = 'background-color: #f0ad4e;color:#ffffff;';
                                    $status_color = '';
                                } else {
                                    $ColorCode = 'background-color: #C11900;color:#ffffff;';
                                    $status_color = '';
                                }
                            }
                            ?>
                            <a href="<?= $fee_url; ?>"
                                class="nav-link <?php echo $status_color; ?>"
                                id="home-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#home"
                                type="button"
                                role="tab"
                                aria-controls="home"
                                style="<?php if (!in_array(IA_BREAD_DOC_INDEX, $StageArray)) {
                                            echo $disabled_status;
                                        } ?>">
                                <span style="<?php echo $ColorCode; ?>" class="tab-num">5</span> Pay Court Fee </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <?php
                            if ($segment->getSegment(2)  == 'view') {
                                $ColorCode = 'background-color: #01ADEF';
                                $status_color = 'first active';
                            } elseif (in_array(IA_BREAD_CASE_DETAILS, $StageArray) && in_array(IA_BREAD_ON_BEHALF_OF, $StageArray) && in_array(IA_BREAD_UPLOAD_DOC, $StageArray) && in_array(IA_BREAD_COURT_FEE, $StageArray)) {
                                $ColorCode = 'background-color: #169F85;color:#ffffff;';
                                $status_color = '';
                            } else {
                                $ColorCode = 'background-color: #C11900;color:#ffffff;';
                                $status_color = '';
                            }
                            ?>
                            <a href="<?= base_url('IA/view') ?>"
                                class="nav-link <?php echo $status_color; ?>"
                                id="home-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#home"
                                type="button"
                                role="tab"
                                aria-controls="home"
                                style="z-index:1;">
                                <span style="<?php echo $ColorCode; ?>" class="tab-num">6</span> View </a>
                        </li>
                    </ul>
        </form>


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

<?php
$pending_court_fee=empty(getPendingCourtFee())?0:getPendingCourtFee();
//echo "dd: ".$pending_court_fee; exit;
?>

<div class="modal fade" id="approveModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="fa fa-pencil"></span> Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure to Approve this E-filing number ? </p>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-default">No</a>
                <a href="<?php echo base_url('admin/efilingAction'); ?>" class="btn btn-success">Yes</a>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="transferModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="fa fa-pencil"></span> Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure to transfer this E-filing number to Sec-X? </p>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-default">No</a>
                <a href="<?php echo base_url('admin/EfilingAction/transferCase'); ?>" class="btn btn-success">Yes</a>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="disapproveModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">
                    <span class="fa fa-pencil"></span><?php echo $lbl = ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MENTIONING) ? "Write Orders" : "Write Reason to Disapprove"; ?> 
                </h4>
            </div>

            <?php
            $attribute = array('name' => 'disapp_case', 'id' => 'disapp_case', 'autocomplete' => 'off');
            if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MENTIONING) {
                echo form_open(base_url('admin/EfilingAction/submit_mentioning_order'), $attribute);
            } else {
                echo form_open(base_url('admin/EfilingAction/disapprove_case'), $attribute);
            }
            ?>
            <div class="modal-body">
                <div id="disapprove_alerts"></div>                
                <div class="clearfix"><br></div>


                <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor-one">

                    <div class="btn-group">
                        <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                        <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                    </div>

                    <div class="btn-group">
                        <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                        <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                    </div>

                    <div class="btn-group">
                        <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                        <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                        <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                        <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                    </div>

                    <div class="btn-group">
                        <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                        <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                    </div>
                </div>

                <div id="editor-one" class="editor-wrapper placeholderText disapprovedText" contenteditable="true"></div>
                <textarea name="remark" id="descr"  style="display:none;"></textarea>
                <span id="disapprove_count_word" style="float:right"></span>
                <div class="clearfix"><br></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-success" id="disapprove_me" >Submit</a>
            </div>
            <?php echo form_close(); ?>  
        </div>
    </div>
</div>
<!-- mark as error start-->
<div class="modal fade" id="markAsErrorModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">
                    <span class="fa fa-pencil"></span>Write reason to mark as error.
                </h4>
            </div>

            <?php
            $attribute = array('name' => 'mark_as_error', 'id' => 'mark_as_error', 'autocomplete' => 'off');
            echo form_open(base_url('admin/EfilingAction/markAsErrorCase'), $attribute);
            ?>
            <div class="modal-body">
                <div id="disapprove_alerts"></div>
                <div class="clearfix"><br></div>
                <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor-one">
                    <div class="btn-group">
                        <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                        <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                    </div>
                    <div class="btn-group">
                        <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                        <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                    </div>
                    <div class="btn-group">
                        <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                        <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                        <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                        <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                    </div>
                    <div class="btn-group">
                        <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                        <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                    </div>
                </div>
                <div id="editor-one" class="editor-wrapper placeholderText disapprovedText" contenteditable="true"></div>
                <textarea name="remark" id="descr"  style="display:none;"></textarea>
                <span id="disapprove_count_word" style="float:right"></span>
                <div class="clearfix"><br></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-success" id="markaserror" >Submit</a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!-- mark as error end-->
<div class="modal fade" id="DeficitCourtFeeModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <span class="fa fa-pencil"></span> Deficit Fee
                </h4>

            </div>
            <div class="modal-body">
                <?php
                $attribute = array('name' => 'deficit_court_fees', 'id' => 'deficit_court_fees', 'autocomplete' => 'off');
                echo form_open('admin/deficit_court_fees', $attribute);
                ?>
                <div class="form-group">
                    <label class="control-label col-sm-4 input-sm">Deficit Fees to be paid<span style="color: red">*</span>:</label>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <input class="form-control" name="court_fees" id="court_fees" maxlength="6" required placeholder="Enter court fee" type="text">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-info" value="Submit"  name="submit">
            </div>
            <?php echo form_close(); ?>  
        </div>
    </div>
</div>
<div class="modal fade" id="generateDiaryNoDiv" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="fa fa-pencil"></span> Check All Details </h4>

            </div>
            <div class="modal-body" id="checkAllSections">
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12" id="loader_div" style="">
            </div>
            <a data-efilingType="<?php echo strtolower($filing_type);?>" class="btn btn-primary" id="createDiaryNo" type="button" style="margin-left: 224px;margin-bottom: 23px;">Generate Diary No.</a>
        </div>

    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="padding-right: 15px;margin-left:-257px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 927px;height: 300px;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Diary Details</h5>
                <button type="button" class="close closeButton" data-dismiss="modal" data-close="1" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="customErrorMessage"></span>
            </div>
            <div class="modal-footer">
                <button type="button"  data-close="1" class="btn btn-secondary closeButton" data-dismiss="modal">Close</button>
<!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="holdModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="fa fa-pencil"></span> Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure to Hold this E-filing number ? </p>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-default">No</a>
                <a href="<?php echo base_url('admin/efilingAction/hold'); ?>" class="btn btn-success">Yes</a>
            </div>
        </div>

    </div>
</div>


<div class="modal fade" id="disposedModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="fa fa-pencil"></span> Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure to Disposed this E-filing number ? </p>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-default">No</a>
                <a href="<?php echo base_url('admin/efilingAction/disposed'); ?>" class="btn btn-success">Yes</a>
            </div>
        </div>

    </div>
</div>


<script>
    function get_objection(obj_id, obj_checked) {
        if (obj_checked.is(':checked')) {
            var obj = $("#obj_" + obj_id).text();
        }
        if (obj_checked.is(':unchecked')) {
            var uncheck = $("#obj_" + obj_id).text() + "<br><br>";
        }
        $('#objection_value').append(obj + "<br><br>");
        var objection = $('#objection_value').html();
        if (objection.indexOf(uncheck) != -1) {
            objection = objection.replace(uncheck, '');
            $('#objection_value').html(objection);
        } else {
            $('#objection_value').html(objection);
        }
    }
    $(document).ready(function () {
        // $(document).on("click", "#generateDiaryNoPop", function () {
        //     var sectionDetails ='';
        //     var sectionData ='';
        //     $("#checkAllSections").html('');
        //     $('ul.nav-breadcrumb li').each(function(i){
        //         i= i+1;
        //         var sectionDetails = $(this).text().trim();
        //         var sectionArr = sectionDetails.split(i);
        //         var name = sectionArr[1].trim().replace(/[-' ']/g,'_').toLowerCase();
        //         if(name == 'extra_party' || name == 'legal_representative'){
        //             sectionData +='<div class="row"><div class="col-sm-4">'+sectionDetails+'</div>' +
        //                 '<div class="col-sm-4"><input class="checkSection" type="radio" id="'+name+'" name="'+name+'" value="1"> <label for="'+name+'"> YES</label><span id="error_'+name+'"></span></div> ' +
        //                 '<div class="col-sm-2"><input  class="checkSection" type="radio" id="'+name+'1" name="'+name+'" value="0"> <label for="'+name+'1"> NO</label></div>' +
        //                 '<div class="col-sm-2"><input class="checkSection" type="radio" id="'+name+'2" name="'+name+'" value="2"> <label for="'+name+'2"> N/A</label></div></div>';
        //         }
        //         else{
        //             sectionData +='<div class="row"><div class="col-sm-4">'+sectionDetails+'</div>' +
        //                 '<div class="col-sm-4"><input class="checkSection" type="radio" id="'+name+'" name="'+name+'" value="1"> <label for="'+name+'"> YES</label><span id="error_'+name+'"></span></div> ' +
        //                 '<div class="col-sm-4"><input class="checkSection" type="radio" id="'+name+'1" name="'+name+'" value="0"> <label for="'+name+'1"> NO</label></div></div>';
        //         }
        //
        //          if(name == 'view' || name =='affirmation'){
        //          }
        //          else{
        //              $("#checkAllSections").append(sectionData);
        //          }
        //         sectionData = '';
        //     });
        // });
        // $(document).on('click','#createDiaryNo',function(){
        $(document).on('click','#generateDiaryNoPop',function(){
            var pending_court_fee='<?=$pending_court_fee?>';
            if(pending_court_fee>0){
                var court_fee_payment_details = $('#is_verified').val();
                var result = court_fee_payment_details.split('#');

                if ((result[0] ==='f' && result[1]>0 && pending_court_fee > 0)){
                    alert('Please verify court fee before generating diary number.');
                    return false;
                }
            }
            /*var court_fee_payment_details = $('#is_verified').val();
            var result = court_fee_payment_details.split('#');

            if ((result[0] ==='f' && result[1]>0 && pending_court_fee > 0)){
                alert('Please verify court fee before generating diary number.');
                return false;
            }*/
            var noError = true;
            var arr = [];
            var stepValue =[];
            var filteredData = [];
            var typeGeneration ='';
            var file_type = $(this).attr('data-efilingtype');
            // $('.checkSection').each(function(){
            //     var name = $(this).attr('name');
            //     var fieldValue =  $('input[name="'+name+'"]:checked').val();
            //     if(typeof fieldValue == 'undefined'){
            //         noError = false;
            //         arr.push(name);
            //     }
            //     else{
            //         if(fieldValue =='0'){
            //             $("#error_"+name).text('Select this field');
            //             $("#error_"+name).css( { "margin-left" : "6px", "color": "red"} );
            //             noError = false;
            //         }
            //         else{
            //             $("#error_"+name).text('');
            //             var checkObject = {};
            //             checkObject.field_name = name;
            //             checkObject.field_value=fieldValue;
            //             stepValue.push(checkObject);
            //             checkObject = {};
            //         }
            //     }
            // });
           // var arr = arr.filter(uniqueArr);
           // const  keys = ['field_name'];
           //  const  filteredData = stepValue.filter((s => o =>(k => !s.has(k) && s.add(k))
           //             (keys.map(k => o[k]).join('|')))
           //          (new Set)
           //      );
           //  if(arr){
           //      for(var i=0;i<arr.length;i++){
           //          $("#error_"+arr[i]).text('Select this field');
           //          $("#error_"+arr[i]).css( { "margin-left" : "6px", "color": "red"} );
           //          noError = false;
           //      }
           //  }

            if(file_type == 'new_case'){
                filteredData.push({field_name: "case_detail", field_value: "1"});
                filteredData.push({field_name: "petitioner", field_value: "1"});
                filteredData.push({field_name: "respondent", field_value: "1"});
                filteredData.push({field_name: "extra_party", field_value: "1"});
                filteredData.push({field_name: "legal_representative", field_value: "1"});
                filteredData.push({field_name: "act_section", field_value: "1"});
                filteredData.push({field_name: "earlier_courts", field_value: "1"});
                filteredData.push({field_name: "upload_document", field_value: "1"});
                filteredData.push({field_name: "index", field_value: "1"});
                filteredData.push({field_name: "pay_court_fee", field_value: "1"});
                typeGeneration ='diary no.';
            }
            else if(file_type == 'caveat'){
                filteredData.push({field_name: "caveator", field_value: "1"});
                filteredData.push({field_name: "caveatee", field_value: "1"});
                filteredData.push({field_name: "extra_party", field_value: "1"});
                filteredData.push({field_name: "subordinate_court", field_value: "1"});
                filteredData.push({field_name: "upload_document", field_value: "1"});
                filteredData.push({field_name: "index", field_value: "1"});
                filteredData.push({field_name: "pay_court_fee", field_value: "1"});
                typeGeneration ='caveat no.';
            }
            var conformRes =  confirm("Are you sure want to generate "+typeGeneration+" ?");
            if(noError && file_type && conformRes){
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            var postData = {CSRF_TOKEN: CSRF_TOKEN_VALUE, file_type: file_type};
            $.ajax({
                type: "POST",
                data: JSON.stringify(postData),
                url: "<?php echo base_url('newcase/Ajaxcalls/getAllFilingDetailsByRegistrationId'); ?>",
                dataType:'json',
                ContentType: 'application/json',
                cache:false,
                async: false,
                beforeSend: function() {
                    $("#loader_div").html('<img id="loader_img" style="position: fixed; left: 63%;margin-top: -164px;  margin-left: -100px;" src="<?php echo base_url('assets/images/loading-data.gif');?>">');
                    $('#createDiaryNo').append('<i class="status_refresh fa fa-refresh fa-spin"></i>');
                },
                success: function (data){
                    if(typeof data == 'string'){
                        data = JSON.parse(data);
                    }
                    // console.log(data);
                    // return false;
                    if(data){
                        $("#exampleModal").modal('show');
                        $('#generateDiaryNoDiv').modal('hide');
                        var diaryStatus ='';
                        var diaryNo = '';
                        var insertData = {};
                        var status = '';
                        var diaryData ='';
                        var alloted_to ='';
                        var insertedDocNums ='';
                        if(data.status == 'SUCCESS') {
                            diaryStatus = 'new_diary';
                            if (data.diary_no) {
                                diaryNo = data.diary_no;
                            }
                            if (data.alloted_to) {
                                alloted_to = data.alloted_to;
                            }
                            if (data.insertedDocNums) {
                                insertedDocNums = data.insertedDocNums;
                            }
                            if (data.status) {
                                status = data.status;
                            }
                            if (data.records_inserted) {
                                insertData.records_inserted = data.records_inserted;
                            }
                                insertData.diaryNo = diaryNo;
                                insertData.alloted_to = alloted_to;
                                insertData.insertedDocNums = insertedDocNums;
                                insertData.status = status;
                                insertData.selectedcheckBox = filteredData;
                                insertData.diaryStatus = diaryStatus;
                            }
                            else  if(data.status == 'ERROR_ALREADY_IN_ICMIS') {
                                var errorMessage = data.error.split(" ");
                                diaryData = errorMessage.pop();
                                diaryStatus = 'exist_diary';
                                insertData.records_inserted = {};
                                if(data.status) {
                                    status = data.status;
                                }
                                if(data.records_inserted) {
                                    insertData.records_inserted = data.records_inserted;
                                }
                                insertData.diaryNo = diaryData;
                                insertData.status = status;
                                insertData.selectedcheckBox = filteredData;
                                insertData.diaryStatus = diaryStatus;
                            }
                            else  if(data.status == 'ERROR_MAIN') {
                                $("#customErrorMessage").html('');
                                $("#customErrorMessage").html(data.error);
                                $("#customErrorMessage").css('color','green');
                                $("#customErrorMessage").css({ 'font-size': '30px' });
                                return false;
                            }
                            else if(data.status == 'ERROR_CAVEAT'){
                                $("#customErrorMessage").html('');
                                $("#customErrorMessage").html(data.error);
                                $("#customErrorMessage").css('color','green');
                                $("#customErrorMessage").css({ 'font-size': '30px' });
                                return false;
                             }
                            if(insertData){
                                if(file_type == 'new_case'){
                                    $('#createDiaryNo').html('Generate Diary No.');
                                    var errorMessage ='Diary no. generation has been successfully!';
                                }
                                else{
                                    $('#createDiaryNo').html('Generate Caveat No.');
                                    var errorMessage ='Caveat no. generation has been successfully!';
                                }
                                $("#customErrorMessage").html('');
                                $("#customErrorMessage").html(errorMessage);
                                $("#customErrorMessage").css('color','green');
                                $("#customErrorMessage").css({ 'font-size': '30px' });
                                    $.ajax({
                                        type: "POST",
                                        data: JSON.stringify(insertData),
                                        url: "<?php echo base_url('newcase/Ajaxcalls/updateDiaryDetails'); ?>",
                                        dataType:'json',
                                        ContentType: 'application/json',
                                        cache:false,
                                        beforeSend: function() {
                                            $('#createDiaryNo').append('<i class="status_refresh fa fa-refresh fa-spin"></i>');
                                        },
                                        success: function(updateData){
                                            // console.log(updateData);
                                            // return false;
                                            $("#loader_div").html('');
                                            if(updateData.success == 'success'){
                                                $("#customErrorMessage").html('');
                                                $("#customErrorMessage").html(updateData.message);
                                            }
                                            else  if(updateData.success == 'error'){
                                                $("#customErrorMessage").html('');
                                                $("#customErrorMessage").html(updateData.message);
                                            }
                                            else{
                                                $("#customErrorMessage").html('');
                                                $("#customErrorMessage").html(updateData.message);
                                            }
                                        }
                                    });
                            }

                        // else {
                        //         var errorMessage = data.error;
                        //         $("#customErrorMessage").html('');
                        //         $("#customErrorMessage").html(errorMessage);
                        //         $("#customErrorMessage").css('color','red');
                        //         $("#customErrorMessage").css({'font-size': '15px'});
                        //         $('#createDiaryNo').html('Generate Diary No.');
                        // }
                    }
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                },
                error: function () {
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                }
            });
        }

        });

        $(document).on('click','.closeButton',function(){
            var closeButtonAttr = $(this).attr('data-close');
            if(closeButtonAttr == 1){
                window.location.reload();
            }
        });

        $('#disapp_case input').on('change', function () {
            var checkedValue = $('input[name=crt_fee_status]:checked', '#disapp_case').val();
            $('#disapprove_alerts').hide();
            $('.change_div_color').css('background-color', '');
            if (checkedValue == '<?php echo url_encryption(3); ?>') {
                $('#def_crt_fee').focus();
                $('#def_crt_fee').attr('required', true);
                $('#def_crt_fee').attr('disabled', false);

            } else {
                $('#def_crt_fee').attr('required', false);
                $('#def_crt_fee').attr('disabled', true);
                $('#def_crt_fee').val('');
            }

        });


        $('#disapprove_me').click(function () {

            var temp = $('.disapprovedText').text();
            temp = $.trim(temp);
            var efiling_type_id = '<?php echo $_SESSION['efiling_details']['ref_m_efiled_type_id']; ?>';

            
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

        $('#markaserror').click(function () {
            var temp = $('.disapprovedText').text();
            temp = $.trim(temp);
            var efiling_type_id = '<?php echo $_SESSION['efiling_details']['ref_m_efiled_type_id']; ?>';
            if (efiling_type_id  !="") {
                if(temp.length == 0){
                    alert("Please fill error note.");
                    $('.disapprovedText').focus();
                    return false;
                }
                else{
                    $('#disapprove_alerts').show();
                    if (temp.length > 500) {
                        $('#disapprove_alerts').show();
                        $('#disapprove_alerts').html("<p class='message invalid' id='msgdiv'>Maximum length 500 allowed. <span class='close' onclick=hideMessageDiv()>X</span></p>");
                    } else {
                        $('textarea#descr').text($('.disapprovedText').text());
                        $('#mark_as_error').submit();
                    }
                }
            }
        });
        //update fee and send to icmis
        $(document).on('click','#transferToScrutiny',function(){
            var registration_id = $(this).attr('data-registration_id');
            if(registration_id){
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                var postData = {CSRF_TOKEN: CSRF_TOKEN_VALUE, registration_id: registration_id};
                $.ajax({
                    type: "POST",
                    data: JSON.stringify(postData),
                    url: "<?php echo base_url('admin/EfilingAction/updateRefiledCase'); ?>",
                    dataType:'json',
                    ContentType: 'application/json',
                    cache:false,
                    beforeSend: function() {
                        $("#loader_div").html('<img id="loader_img" style="position: fixed; left: 63%;margin-top: -164px;  margin-left: -100px;" src="<?php echo base_url('assets/images/loading-data.gif');?>">');
                        $('#createDiaryNo').append('<i class="status_refresh fa fa-refresh fa-spin"></i>');
                    },
                    success: function (res){
                        if(typeof res == 'string'){
                            res = JSON.parse(res);
                        }
                        if(res.status == 'success'){
                            alert(res.message);
                            window.location.reload();
                        }
                        else{
                            alert(res.message);
                            window.location.reload();
                        }
                        $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                            $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                        });
                    },
                    error: function () {
                        $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                            $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                        });
                    }
                });
            }
        });

    });
    $('#disapproveModal').on('hidden.bs.modal', function (e) {
        $(this).find('form').trigger('reset');
        $('#disapprove_alerts').hide();
        $('.change_div_color').css('background-color', '');
        $('.error-tip').hide();
    });
    $('#markAsErrorModal').on('hidden.bs.modal', function (e) {
        $(this).find('form').trigger('reset');
        $('#disapprove_alerts').hide();
        $('.change_div_color').css('background-color', '');
        $('.error-tip').hide();
    });
    function uniqueArr(value, index, self) {
        return self.indexOf(value) === index;
    }
    function getAmtValue(amt)
    {
        //var regex = /^[0-9]*\.?[0-9]*$/;
        var regex = /^[0-9]*$/;
        if (regex.test(amt)) {
            return true;
        } else {
            $('#def_crt_fee').val('');
            return false;
        }
    }
</script>
<style>
    .obj_wrapper{
        min-height: 140px;
        max-height: 180px;
        background-color: #fff;
        border-collapse: separate;
        border: 1px solid #ccc;
        padding: 4px;
        box-sizing: content-box;
        box-shadow: rgba(0,0,0,.07451) 0 1px 1px 0 inset;
        overflow-y: scroll;
        outline: 0;
        border-radius: 3px;

    }

    .editor-wrapper {
        min-height: 200px !important;
        max-height: 250px;
    }
</style>