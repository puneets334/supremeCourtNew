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
                        if (getSessionData('customEfil') == 'ia') {
                            // unset($_SESSION['efiling_type']);
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
            // <!-- <a class="btn btn-danger btn-sm" onclick="ActionToTrash('UAT')">Trash</a> -->
            // <?php
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
            <a class="btn btn-danger btn-sm" onclick="ActionToTrash('SLT')">Trash</a>
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