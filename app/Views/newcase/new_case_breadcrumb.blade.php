<?php
$segment = service('uri');
$StageArray = !empty(getSessionData('breadcrumb_enable')) ? explode(',', $_SESSION['efiling_details']['breadcrumb_status']) : [];
$disabled_status1 = 'pointer-events: none; cursor: default;';
$allowed_users_array = [USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT, JAIL_SUPERINTENDENT];
$allowed_users_trash = [USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT];
?>
<style>
    .curemarked {
        font-weight: bold; text-decoration: line-through;
    }
</style>
<div class="dash-card dashboard-section">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class=" dashboard-bradcrumb">
                <div class="left-dash-breadcrumb">
                    <div class="page-title">
                        <h5><i class="fa fa-file"></i> <?php
                        $filing_num_label = 'eFiling No. : ';
                        if (!empty(getSessionData('breadcrumb_enable')['efiling_type']) && getSessionData('breadcrumb_enable')['efiling_type'] == E_FILING_TYPE_NEW_CASE) {
                            echo 'Case Filing Form';
                            $filing_num_label = 'eFiling No. : ';
                            $lbl_history = 'eFiling History';
                        } elseif (!empty(getSessionData('breadcrumb_enable')['efiling_type']) && getSessionData('breadcrumb_enable')['efiling_type'] == E_FILING_TYPE_CDE) {
                            echo 'Case Data Entry';
                            $filing_num_label = 'CDE No. : ';
                            $lbl_history = 'CDE History';
                        } elseif (!empty(getSessionData('efiling_details')['stage_id']) && getSessionData('efiling_details')['stage_id'] == I_B_Defected_Stage) {
                            echo 'ReFiling Form';
                            $lbl_history = 'eFiling History';
                        } else {
                            echo 'Case Filing Form';
                            $lbl_history = 'eFiling History';
                        }
                        
                        if (!empty(getSessionData('efiling_details')['stage_id']) && (getSessionData('efiling_details')['stage_id'] == DRAFT_STAGE || getSessionData('efiling_details')['stage_id'] == INITIAL_DEFECTED_STAGE || getSessionData('efiling_details')['stage_id'] == TRASH_STAGE)) {
                            $efiling_num_label_for_display = 'DRAFT-';
                            $efiling_num_button_background_class = 'btn-danger';
                        } else {
                            $efiling_num_label_for_display = '';
                            $efiling_num_button_background_class = 'btn-success';
                        }
                        ?></h5>
                    </div>
                    <!-- <div class="form-response"
                        id="msgs"
                        role="alert"
                        data-auto-dismiss="5000">
                        <?php
                        if (!empty(getSessionData('MSG'))) {
                            // echo getSessionData('MSG');
                        }
                        ?>
                    </div> -->
                    <div class="form-response"
                        role="alert"
                        data-auto-dismiss="5000">
                        <?php
                        if (!empty(getSessionData('msg'))) {
                            echo getSessionData('msg');
                        }
                        ?>
                    </div>
                    <?php //echo getSessionData('msg'); ?>
                    
                    
                    <?php
                    $Array = array(New_Filing_Stage, Initial_Defects_Cured_Stage);
                    if ((getSessionData('login')['ref_m_usertype_id'] == USER_ADMIN) && in_array(getSessionData('efiling_details')['stage_id'], $Array)) {
                        ?>
                    <a data-toggle="modal"
                        href="#approveModal"
                        class="btn btn-success btn-sm">Approve</a>
                    <a data-toggle="modal"
                        href="#disapproveModal"
                        class="btn btn-danger btn-sm">Disapprove</a>
                    <a data-toggle="modal"
                        href="#markAsErrorModal"
                        class="btn btn-warning btn-sm">Mark As Error</a>
                    <?php } ?>
                    <?php
                        // render('templates.user_efil_num_action_bar');
                    ?>
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
                    <div class="btns-sec">
                        <?php
                    $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT, JAIL_SUPERINTENDENT);
                    $allowed_users_trash = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT); 
                        if (!empty(getSessionData('login')) && in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users_array)) {
                            $stages_array = array(Draft_Stage);

                            if (!empty(getSessionData('efiling_details')) && in_array(getSessionData('efiling_details')['stage_id'], $stages_array)) {
                                if (!empty(getSessionData('efiling_details')) && getSessionData('efiling_details')['ref_m_efiled_type_id'] == 1) {
                                    if (in_array(NEW_CASE_COURT_FEE, explode(',', getSessionData('efiling_details')['breadcrumb_status']))) {
                         //  pr(explode(',', getSessionData('efiling_details')['breadcrumb_status']));

                                        if(count(explode(',', getSessionData('efiling_details')['breadcrumb_status'])) > 6){
                                        if (getSessionData('login')['ref_m_usertype_id'] == USER_ADVOCATE) {
                        ?>
                                            <button class="quick-btn gradient-btn btn btn-success btn-sm efilaor" id='efilaor'> SUBMIT FOR EFILING </button>
                                        <?php } else {
                                        ?>
                                            <button class="quick-btn gradient-btn btn btn-success btn-sm" id='efilpip'> SUBMIT FOR EFILING </button>
                                        <?php
                                        }
                                    }
                                    }
                                } else {
                                    if (!empty(getSessionData('efiling_details')) && in_array(JAIL_PETITION_SUBORDINATE_COURT, explode(',', getSessionData('efiling_details')['breadcrumb_status']))) {
                                        ?><a href="<?php echo base_url('jailPetition/FinalSubmit') ?>" class="quick-btn btn btn-success btn-sm" id='jail'>
                                            SUBMIT FOR EFILING</a>
                        <?php }
                                }
                            }
                        }
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
                    <h6>New Case Filing Form</h6>
                </div>
                <div class="current-pg-actions">
                    <?php
                    if (!empty(getSessionData('efiling_details')) && !strpos(getSessionData('efiling_details')['breadcrumb_status'], '8')) {
                        $s = 'CASE DATA ENTRY';
                    } else {
                        $s = 'E FILE';
                    }
                    $allowed_users_array = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT, JAIL_SUPERINTENDENT);
                    $allowed_users_trash = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK, USER_DEPARTMENT); 
                                                 
                                              
                    if (!empty(getSessionData('login')) && in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users_array)) {
                        $stages_array = array(Draft_Stage);

                        /*if (!empty(getSessionData('efiling_details')) && in_array(getSessionData('efiling_details')['stage_id'], $stages_array)) {
                            if(!empty(getSessionData('efiling_details')) && getSessionData('efiling_details')['ref_m_efiled_type_id']==1){
                                if (in_array(NEW_CASE_COURT_FEE, explode(',', getSessionData('efiling_details')['breadcrumb_status']))) {
                                    if(getSessionData('login')['ref_m_usertype_id']==USER_ADVOCATE) {
                                        ?>
                                    <button class="btn btn-success btn-sm" id='efilaor'> SUBMIT FOR EFILING </button>
                                <?php }
                                    else{
                                        ?>
                                        <button class="btn btn-success btn-sm" id='efilpip'> SUBMIT FOR EFILING </button>
                                            <?php
                                    }
                                }
                            }
                            else{
                                if (!empty(getSessionData('efiling_details')) && in_array(JAIL_PETITION_SUBORDINATE_COURT, explode(',', getSessionData('efiling_details')['breadcrumb_status']))) {
                                    ?><a href="<?php echo base_url('jailPetition/FinalSubmit') ?>" class="btn btn-success btn-sm" id='jail'>
                                        SUBMIT FOR EFILING</a>
                                <?php }
                            }
                        }*/
                        $stages_array = array(Initial_Defected_Stage, I_B_Defected_Stage);
                        if (!empty(getSessionData('efiling_details')) && in_array(getSessionData('efiling_details')['stage_id'], $stages_array)) {
                            // echo '<div class="col-md-8"><h5>Please ensure that you have cured the defects notified by admin. Then only proceed with final submit.</h5></div>';
                            if (in_array(NEW_CASE_COURT_FEE, explode(',', getSessionData('efiling_details')['breadcrumb_status']))) {
                                echo '<a href="' . base_url('newcase/finalSubmit') . '" class="btn btn-success btn-sm">SUBMIT FOR RE-FILING </a>';
                            }
                        }
                        // $stages_array = array(Draft_Stage);
                        // if (!empty(getSessionData('efiling_details')) && in_array(!empty(getSessionData('login')) && getSessionData('login')['ref_m_usertype_id'], $allowed_users_trash) && in_array(getSessionData('efiling_details')['stage_id'], $stages_array)) {
                            ?>
                            {{-- <a class="btn btn-danger btn-sm" onclick="ActionToTrash('UAT')">Trash</a> --}}
                        <?php //}
                    }

                    ?>
                    <?php
                    if (!empty(getSessionData('efiling_details')) && !empty(getSessionData('efiling_details')['efiling_no'])) {
                        echo '
                                                <a href="javascript:void(0)"
                                            class="quick-btn transparent-btn ' .
                            $efiling_num_button_background_class .
                            '" id="copyTarget_EfilingNumber">' .
                            $filing_num_label .
                            $efiling_num_label_for_display .
                            htmlentities(efile_preview(getSessionData('efiling_details')['efiling_no']), ENT_QUOTES) .
                            '</a>
                                                <strong id="copyButton" class="quick-btn btn btn-danger btn-sm"  style="font-size: 14px;color:greenyellow;"><span class="fa fa-copy" style="font-size:14px;color:#ffffff;"></span></strong>';
                        echo '&nbsp;<a href="' .
                            base_url('history/efiled_case/view') .
                            '"
                                            class="quick-btn gray-btn">' .
                            $lbl_history .
                            '</a> ';
                    }
                    ?>
                    <?php
                        $stages_array = array(Draft_Stage);
                        if (!empty(getSessionData('efiling_details')['stage_id']) && in_array(!empty(getSessionData('login')) && getSessionData('login')['ref_m_usertype_id'], $allowed_users_trash) && in_array(getSessionData('efiling_details')['stage_id'], $stages_array)) {
                        ?>
                    <a href="javascript:void(0)"
                        class="quick-btn gradient-btn"
                        onclick="ActionToTrash('UAT')">Trash</a>
                    <?php } ?>

                    <?php
                        if (!empty(getSessionData('login')) && in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users_array)) {
                            $stages_array = array(Draft_Stage);
                            if (!empty(getSessionData('efiling_details')['stage_id']) && in_array(getSessionData('efiling_details')['stage_id'], $stages_array)) {
                                if(!empty(getSessionData('efiling_details')['ref_m_efiled_type_id']) && getSessionData('efiling_details')['ref_m_efiled_type_id']==1){
                                    if (in_array(NEW_CASE_COURT_FEE, explode(',', getSessionData('efiling_details')['breadcrumb_status']))) {
                                        if(getSessionData('login')['ref_m_usertype_id']==USER_ADVOCATE) {
                                            ?>
                    <!--<a href="javascript:void(0)"
                        class="quick-btn black-btn"
                        id='efilaor'><span class="mdi mdi-file-send"></span></a>-->
                    <?php }
                                        else{
                                            ?>
                    <!-- <a href="javascript:void(0)"
                        class="quick-btn black-btn"
                        id='efilpip'><span class="mdi mdi-file-send"></span></a> -->
                    <?php
                                        }
                                        }
                                }
                                else{
                                    if (!empty(getSessionData('efiling_details')['breadcrumb_status']) && in_array(JAIL_PETITION_SUBORDINATE_COURT, explode(',', getSessionData('efiling_details')['breadcrumb_status']))) {
                                        ?>
                    <!-- <a href="<?php echo base_url('jailPetition/FinalSubmit'); ?>"
                        class="quick-btn black-btn"><span class="mdi mdi-file-send"></span></a> -->
                    <?php }
                                }
                            }
                            $stages_array = array(Initial_Defected_Stage, I_B_Defected_Stage);
                            if (!empty(getSessionData('efiling_details')['stage_id']) && in_array(getSessionData('efiling_details')['stage_id'], $stages_array)) {
                                // echo '<div class="col-md-8"><h5>Please ensure that you have cured the defects notified by admin. Then only proceed with final submit.</h5></div>';
                                if (in_array(NEW_CASE_COURT_FEE, explode(',', getSessionData('efiling_details')['breadcrumb_status']))) {
                                    // echo '<a href="'.base_url('newcase/finalSubmit').'" class="quick-btn black-btn"><span class="mdi mdi-file-send"></span></a>';
                                }
                            }
                        }
                        ?>

                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .tabs-sec-inner h5 {
        font-size: 18px;
        line-height: 26px;
        color: #0D48BE;
        padding: 20px;
    }
</style>
<!-- tabs-section -start  -->
<div class="dash-card dashboard-section tabs-section">
    <div class="tabs-sec-inner">
        <?php
        if (!empty(getSessionData('efiling_details')) && in_array(getSessionData('efiling_details')['stage_id'], $stages_array)) {
            echo '<div class="col-md-8 "><h5>Please ensure that you have cured the defects notified by admin. Then only proceed with final submit.</h5></div>';
        }
        echo !empty(getSessionData('efiling_details')['stage_id']) ? '<div class="row">
        <div class="col-12">'.remark_preview(getSessionData('efiling_details')['registration_id'], getSessionData('efiling_details')['stage_id']).'</div></div>' : '';
        ?>
        <!-- form--start  -->

        <form action="">
            <?php
            $StageArray = !empty(getSessionData('efiling_details')['breadcrumb_status']) ? explode(',', getSessionData('efiling_details')['breadcrumb_status']) : [];
            $breadcrumb_status = count($StageArray);
            $step = 11;
            $p_r_type_petitioners = 'P';
            $p_r_type_respondents = 'R';
            $registration_id = !empty(getSessionData('efiling_details')['registration_id']) ? getSessionData('efiling_details')['registration_id'] : '';
            if (!empty(getSessionData('efiling_details')['no_of_petitioners'])) {
                $total_petitioners = get_extra_party_P_or_R($p_r_type_petitioners);
            } else {
                $total_petitioners = 0;
            }
            if (!empty(getSessionData('efiling_details')['no_of_respondents'])) {
                $total_respondents = get_extra_party_P_or_R($p_r_type_respondents);
            } else {
                $total_respondents = 0;
            }
            $final_submit_action = false;
            $final_submit_continue_action = false;
            if (!empty(getSessionData('login')) && in_array(getSessionData('login')['ref_m_usertype_id'], [USER_ADVOCATE, USER_IN_PERSON, USER_PDE])) {
                $url_case_detail = base_url('newcase/caseDetails');
                $url_petitioner = base_url('newcase/petitioner');
                $url_respondent = base_url('newcase/respondent');
                $url_extra_party = base_url('newcase/extra_party');
                $url_add_lrs = base_url('newcase/lr_party');
                $url_act_section = base_url('newcase/actSections');
                $url_subordinate_court = base_url('newcase/subordinate_court');
                $url_case_create_index = base_url('documentIndex');
                $url_case_upload_docs = base_url('uploadDocuments');
                $url_case_courtfee = base_url('newcase/courtFee');
                $url_case_affirmation = base_url('affirmation');
                $url_case_view = base_url('newcase/view');
                $final_submit_action = true;
                $final_submit_continue_action = true;
            } elseif ((!empty(getSessionData('efiling_details')['stage_id']) && !empty(getSessionData('login')) && (getSessionData('login')['ref_m_usertype_id'] == USER_DEPARTMENT && getSessionData('efiling_details')['stage_id'] == Draft_Stage)) || (getSessionData('login')['ref_m_usertype_id'] == USER_CLERK && in_array(getSessionData('efiling_details')['stage_id'], [Draft_Stage, Initial_Defected_Stage]))) {
                $url_case_affirmation = '#';
            } else {
                $url_case_detail = $url_petitioner = $url_respondent = $url_extra_info = $url_extra_party = $url_add_lrs = $url_act_section = $url_main_matter = $url_subordinate_court = $url_case_sign_method = $url_case_upload_docs = $url_case_courtfee = $url_case_affirmation = $url_case_view = '#';
            }

            ?>
            

            @if (
                !empty(getSessionData('efiling_details')['stage_id']) &&
                    (getSessionData('efiling_details')['stage_id'] == I_B_Defected_Stage ||
                        getSessionData('efiling_details')['stage_id'] == I_B_Defects_Cured_Stage))
            @else
                <ul class="nav nav-tabs"
                    id="myTab"
                    role="tablist">
                    
                    <li class="nav-item"
                        role="presentation">
                        <?php
                        if ($segment->getSegment(2) == 'caseDetails') {
                            $ColorCode = 'background-color: #01ADEF';
                            $status_color = 'active';
                        } elseif (in_array(NEW_CASE_CASE_DETAIL, $StageArray)) {
                            $ColorCode = 'background-color: #169F85;color:#ffffff;';
                            $status_color = '';
                        } else {
                            $ColorCode = 'background-color: #f0ad4e;color:#ffffff;';
                            $status_color = '';
                        }
                        ?>

                        <a href="<?= $url_case_detail ?>"
                            class="nav-link <?php echo $status_color; ?>"
                            id="home-tab"
                            ><span class="tab-num"
                                style="<?php echo $ColorCode; ?>">1</span>Case Detail</a>
                    </li>
                    
                    <li class="nav-item"
                        role="presentation">
                        <?php
                        if ($segment->getSegment(2) == 'petitioner') {
                            $ColorCode = 'background-color: #01ADEF';
                            $status_color = 'active';
                            $disabled_status = '';
                        } elseif (in_array(NEW_CASE_PETITIONER, $StageArray)) {
                            $ColorCode = 'background-color: #169F85;color:#ffffff;';
                            $status_color = '';
                            $disabled_status = '';
                        } else {
                            $ColorCode = 'background-color: #C11900;color:#ffffff;';
                            $status_color = '';
                            $disabled_status = 'pointer-events: none; cursor: default;';
                        }
                        ?>
                        <a href="<?= $url_petitioner ?>"
                            class="nav-link <?php echo $status_color; ?>"
                            style="<?php if (!in_array(NEW_CASE_CASE_DETAIL, $StageArray)) {
                                echo $disabled_status;
                            } ?>"
                            data-bs-target="#home"
                            type="button"
                            aria-selected="false"><span class="tab-num"
                                style="<?php echo $ColorCode; ?>">2</span>Petitioner</a>
                    </li>
                    <li class="nav-item"
                        role="presentation">
                        <?php
                        if ($segment->getSegment(2) == 'respondent') {
                            $ColorCode = 'background-color: #01ADEF';
                            $status_color = 'active';
                            $disabled_status = '';
                        } elseif (in_array(NEW_CASE_RESPONDENT, $StageArray)) {
                            $ColorCode = 'background-color: #169F85;color:#ffffff;';
                            $status_color = '';
                            $disabled_status = '';
                        } else {
                            $ColorCode = 'background-color: #C11900;color:#ffffff;';
                            $status_color = '';
                            $disabled_status = 'pointer-events: none; cursor: default;';
                        }
                        ?>
                        <a href="<?= $url_respondent ?>"
                            class="nav-link <?php echo $status_color; ?>"
                            type="button"
                            style="<?php if (!in_array(NEW_CASE_PETITIONER, $StageArray)) {
                                echo $disabled_status;
                            } ?>"
                            aria-selected="false"><span class="tab-num"
                                style="<?php echo $ColorCode; ?>">3</span>Respondent</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <?php
                        if ($segment->getSegment(2) == 'subordinate_court') {
                            $ColorCode = 'background-color: #01ADEF';
                            $status_color = 'first active';
                            $disabled_status = '';
                        } elseif (in_array(NEW_CASE_SUBORDINATE_COURT, $StageArray)) {
                            $ColorCode = 'background-color: #169F85;color:#ffffff;';
                            $status_color = '';
                            $disabled_status = '';
                        } else {
                            $ColorCode = 'background-color: #f0ad4e;color:#ffffff;';
                            $status_color = '';
                            $disabled_status = 'pointer-events: none; cursor: default;';
                        }
                        ?>
                        <a href="<?= $url_subordinate_court ?>" class="nav-link <?php echo $status_color; ?>" id="home-tab" type="button" style="<?php if (!in_array(NEW_CASE_RESPONDENT, $StageArray)) { echo $disabled_status1; } ?>" aria-selected="false"><span class="tab-num" style="<?php echo $ColorCode; ?>">4</span>Earlier Courts</a>
                    </li>
                    <li class="nav-item"
                        role="presentation">
                        <?php
                        if ($segment->getSegment(2) == 'upload_docs' || $segment->getSegment(1) == 'uploadDocuments' || $segment->getSegment(1) == 'documentIndex') {
                            $ColorCode = 'background-color: #01ADEF';
                            $status_color = 'first active';
                            //$disabled_status='';
                        } elseif (in_array(NEW_CASE_UPLOAD_DOCUMENT, $StageArray)) {
                            $ColorCode = 'background-color: #169F85;color:#ffffff;';
                            $status_color = '';
                            // $disabled_status='';
                        } else {
                            $ColorCode = 'background-color: #C11900;color:#ffffff;';
                            $status_color = '';
                            // $disabled_status='pointer-events: none; cursor: default;';
                        }
                        ?>
                        <a href="<?= $url_case_upload_docs ?>"
                            class="nav-link <?php echo $status_color; ?>"
                            id="home-tab"
                            type="button"
                            style="<?php if (!in_array(NEW_CASE_RESPONDENT, $StageArray)) {
                                echo $disabled_status1;
                            } ?>"
                            aria-selected="false"><span class="tab-num"
                                style="<?php echo $ColorCode; ?>">5</span>Upload Document / Index</a>
                    </li>
                    <li class="nav-item"
                        role="presentation">
                        <?php
                        if ($segment->getSegment(2) == 'courtFee') {
                            $ColorCode = 'background-color: #01ADEF';
                            $status_color = 'first active';
                            $disabled_status = '';
                        } elseif (in_array(NEW_CASE_COURT_FEE, $StageArray)) {
                            //$ColorCode = $bgcolor . ";color:#ffffff";
                            $bgcolor = 'background-color: #169F85;';
                            $ColorCode = $bgcolor . ';color:#ffffff';
                            $status_color = '';
                            $disabled_status = '';
                        } else {
                            $bgcolor = 'background-color: #C11900;';
                            $ColorCode = $bgcolor . ';color:#ffffff';
                            $status_color = '';
                            $disabled_status = 'pointer-events: none; cursor: default;';
                        }
                        ?>
                        <a href="<?= $url_case_courtfee ?>"
                            class="nav-link <?php echo $status_color; ?>"
                            id="home-tab"
                            style="<?php if (!in_array(NEW_CASE_RESPONDENT, $StageArray)) {
                                echo $disabled_status1;
                            } ?>"
                            type="button"
                            aria-selected="false"><span class="tab-num"
                                style="<?php echo $ColorCode; ?>">6</span>Pay Court Fee</a>
                    </li>
                    <li class="nav-item"
                        role="presentation">
                        <?php
                        if ($segment->getSegment(2) == 'view') {
                            $ColorCode = 'background-color: #01ADEF';
                            $status_color = 'first active';
                            $disabled_status = '';
                        } elseif (in_array(NEW_CASE_PETITIONER, $StageArray) && in_array(NEW_CASE_RESPONDENT, $StageArray) && in_array(NEW_CASE_UPLOAD_DOCUMENT, $StageArray)) {
                            $ColorCode = 'background-color: #169F85;color:#ffffff';
                            $status_color = '';
                            $disabled_status = '';
                        } else {
                            $ColorCode = 'background-color: #C11900;color:#ffffff';
                            $status_color = '';
                            $disabled_status = 'pointer-events: none; cursor: default;';
                        }
                        ?>
                        <a href="<?= base_url('newcase/view') ?>"
                            class="nav-link <?php echo $status_color; ?>"
                            id="home-tab"
                            type="button"
                            style="<?php if (!in_array(NEW_CASE_RESPONDENT, $StageArray)) {
                                echo $disabled_status1;
                            } ?>"
                            aria-selected="false"><span class="tab-num"
                                style="<?php echo $ColorCode; ?>">7</span>View</a>
                    </li>
                </ul>
            @endif
        </form>

        <div class="modal fade"
            id="FinalSubmitModal"
            role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button"
                            class="close"
                            data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Note :- </h4>
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
                            $attribute = ['name' => 'submit_adv_panel', 'id' => 'submit_adv_panel', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data'];
                            echo form_open($action, $attribute);
                            ?>
                            <div class="col-md-6 col-sm-6 col-xs-10">
                                <select id="advocate_list"
                                    name="advocate_list"
                                    class="form-control filter_select_dropdown "
                                    style="width: 100%">
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
                                    <option value="<?php echo url_encryption($adv_panel['user_id']); ?>"
                                        <?php echo $sel; ?>><?php echo htmlentities(strtoupper($adv_panel['first_name'] . $adv_last_name), ENT_QUOTES); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-10">
                                <select id="advocate_list1"
                                    name="advocate_list1"
                                    class="form-control filter_select_dropdown"
                                    style="width: 100%">
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
                                    <option value="<?php echo url_encryption($adv_panel1['user_id']); ?>"
                                        <?php echo $sel; ?>><?php echo htmlentities(strtoupper($adv_panel1['first_name'] . $adv_last_name), ENT_QUOTES); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <input type="submit"
                                class="btn btn-success"
                                name="Submit"
                                value="Submit">
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
                            <li> Click on <b> Final Submit & File IA </b> to submit this case to eFiling admin and
                                continue with IA filing in this case.</li>
                            <?php } ?>
                            <br>
                        </ul>
                        <div class=" text-center">
                            <?php if ($final_submit_action) { ?>
                            <a href="<?php echo base_url('stage_list/final_submit'); ?>"
                                class="btn btn-success">Final Submit</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php } if ($final_submit_action && $final_submit_continue_action) { ?>
                            <a href="<?php echo base_url('stage_list/final_submit_with_ia'); ?>"
                                class="btn btn-info">Final Submit & File IA</a>
                            <?php
                        }
                    }
                    ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                class="btn btn-default"
                                data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

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

            $("#checkAll").change(function(){
                if (! $('input:checkbox').is('checked')) {
                    $('input:checkbox').attr('checked','checked');
                } else {
                    $('input:checkbox').removeAttr('checked');
                }       
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                var oTable = $("#datatable-defects").dataTable();

                $("#checkAll").change(function () {
                    oTable.$("input[type=\'checkbox\']").prop("checked", $(this).prop("checked"));
                });
            });
            function setCuredDefect(id) {
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                var value = $("#" + id).is(":checked");
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url("documentIndex/Ajaxcalls/markCuredDefect"); ?>',
                    data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, objectionId: id, val:value},
                    success: function () {
                        $("#row"+id).toggleClass("curemarked");
                    },
                    error: function () {alert("failed");}
                });
            }
        </script>