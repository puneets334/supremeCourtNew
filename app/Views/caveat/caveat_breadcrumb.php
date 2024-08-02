<div class="right_col" role="main">
    <?php
    if (($_SESSION['efiling_details']['stage_id'] == DRAFT_STAGE) || ($_SESSION['efiling_details']['stage_id'] == INITIAL_DEFECTED_STAGE) || ($_SESSION['efiling_details']['stage_id'] == TRASH_STAGE)) {
        $efiling_num_label_for_display = 'DRAFT-';;
        $efiling_num_button_background_class = 'btn-danger';
    } else {
        $efiling_num_label_for_display = '';
        $efiling_num_button_background_class = 'btn-success';
    }
    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-response" id="msg" role="alert" data-auto-dismiss="5000"></div>
                <?php
               // echo '<pre>'; print_r($_SESSION['efiling_details']['ref_m_efiled_type_id']); exit;
                   if (isset($_SESSION['MSG']) && !empty($_SESSION['MSG'])) { echo $_SESSION['MSG']; } unset($_SESSION['MSG']);
                   echo $this->session->flashdata('msg');
                ?>
                <div class="view_data">
                    <div id="modal_loader">
                        <img id="loader_img" style="margin-top: 30px;margin-left: 30px;display:block;" src="<?php echo base_url('assets/images/loading-data.gif'); ?>" />
                    </div>
                    <div class="clearfix"></div> 
                    <?php echo remark_preview($_SESSION['efiling_details']['registration_id'], $_SESSION['efiling_details']['stage_id']); ?>
                    <div class="x_panel x-panel_height">
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-left">                        
                            <ul class="text-left1">
                                <li style="float: left;list-style-type: none;"><i class="badge" style="background-color: #01ADEF; color:#01ADEF; ">A</i> Active &nbsp;</li>
                                <li style="float: left;list-style-type: none;"><i class="badge" style="background-color: #169F85; color:#169F85;">D</i> Done &nbsp;</li> 
                                <li style="float: left;list-style-type: none;"><i class="badge" style="background-color: #f0ad4e; color:#f0ad4e;">O</i> Optional &nbsp;</li>
                                <li style="float: left;list-style-type: none;"><i class="badge" style="background-color: #C11900; color:#C11900;">R</i> Required &nbsp;</li>
                            </ul>                        
                        </div>

                        <div class=" col-lg-8 col-md-8 col-sm-6 col-xs-12 text-right">
                            <?php
                            $Array = array(New_Filing_Stage, Initial_Defects_Cured_Stage);
                            if (($_SESSION['login']['ref_m_usertype_id'] == USER_ADMIN || $_SESSION['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN) && in_array($_SESSION['efiling_details']['stage_id'], $Array)) {

                                if ($efiling_civil_data[0]['orgid'] == '0' && $efiling_civil_data[0]['not_in_list_org'] == 't' || $efiling_civil_data[0]['resorgid'] == '0' && $efiling_civil_data[0]['res_not_in_list_org'] == 't') {
                                    ?>
                                    <a class="btn btn-success" data-toggle="popover"  data-placement="bottom" data-content="Caveator organisation not added. OR Caveatee organisation not added. OR Extra Party organisation not added.">Approve  
                                       <i class="fa fa-question-circle-o"></i></a>
                                <?php } else { ?>
                                    <a data-toggle="modal" href="#approveModal" class="btn btn-success btn-sm">Approve</a>
                                <?php } ?>
                                <a data-toggle="modal" href="#disapproveModal" class="btn btn-danger btn-sm" >Disapprove</a>
                            <?php } ?>

                            <?php
                            $idle_Array = array(Draft_Stage, Initial_Defected_Stage, I_B_Defected_Stage);
                            if (($_SESSION['login']['ref_m_usertype_id'] == USER_ADMIN || $_SESSION['login']['ref_m_usertype_id'] == USER_MASTER_ADMIN) && in_array($_SESSION['efiling_details']['stage_id'], $idle_Array) && $this->uri->segment(3) == url_encryption('idle')) {
                                ?>
                                <a data-toggle="modal" href="#lodges_cases" class="btn btn-success">Make Idle</a> 
                                <a data-toggle="modal" href="#delete_lodges_cases" class="btn btn-danger" >Make Idle & Delete</a>
                            <?php } ?>

                            <?php
                            $allowedUsers = array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK);
                            $Array = array(Draft_Stage, Initial_Defected_Stage, I_B_Defected_Stage, I_B_Rejected_Stage, E_REJECTED_STAGE);

                            if (in_array($_SESSION['login']['ref_m_usertype_id'], $allowedUsers)) {

                                if ($_SESSION['efiling_details']['stage_id'] == Initial_Defected_Stage || $_SESSION['efiling_details']['stage_id'] == I_B_Defected_Stage) {
                                    echo '<div class="col-md-8"><h5>Please ensure that you have cured the defects notified by admin. Then only proceed with final submit.</h5></div>';
                                }
                               // echo '<pre>'; print_r($_SESSION['efiling_details']); exit;
                                if (in_array($_SESSION['efiling_details']['stage_id'], $Array)) {  

                                    if ($_SESSION['login']['ref_m_usertype_id'] != USER_CLERK) {
                                        if (in_array(CAVEAT_BREAD_COURT_FEE, explode(',', $_SESSION['efiling_details']['breadcrumb_status'])) && !in_array(CAVEAT_BREAD_VIEW, explode(',', $_SESSION['efiling_details']['breadcrumb_status']))) {
                                            echo '<a href="' . base_url('efilingAction/Caveat_final_submit') . '" class="btn btn-success btn-sm">Final Submit</a>';
                                        }
                                        if ($_SESSION['efiling_details']['stage_id'] == Draft_Stage) {
                                            ?>
<!--                                            <a href="--><?php //echo base_url('efilingAction/trashed'); ?><!--" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure that you really want to trash this record?')" >Trash</a>-->
                                            <a class="btn btn-danger btn-sm" onclick="ActionToTrash('EAT')">Trash</a>
                                            <?php
                                        }
                                    } elseif ($_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
                                        if (in_array(CAVEAT_BREAD_DOC_INDEX, explode(',', $_SESSION['efiling_details']['breadcrumb_status']))) {

                                            $action = base_url('efilingAction/Caveat_final_submit');
                                            $attribute = array('name' => 'submit_adv_id', 'id' => 'submit_adv_id', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data');
                                            echo form_open($action, $attribute);

                                            $ci = & get_instance();
                                            $ci->load->model('clerk/Clerk_model');
                                            $clerk_adv = $ci->Clerk_model->get_advocate($_SESSION['login']['id']);
                                            echo '<input type="hidden" class="btn btn-primary btn-sm" name="advocate_id" value="' . htmlentities(url_encryption($clerk_adv[0]['id']), ENT_QUOTES) . '" >';

                                            echo '<input type="submit" class="btn btn-primary btn-sm" name="submit" value="Submit" >';
                                            echo form_close();
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="x_panel">
                        <div class="x_title">
                            <div class="registration-process" style="float: left; border: none;">
                                <h2><i class="fa fa-file"></i> Caveat Filing Form</h2>
                                <div class="clearfix"></div>                               
                            </div>
                            <div style="float: right">
                                <?php
                                if (isset($_SESSION['efiling_details']['efiling_no']) && !empty($_SESSION['efiling_details']['efiling_no'])) {
                                    echo '<a href="javascript::void(0); " class="btn '.$efiling_num_button_background_class.' btn-sm"  style="color: #ffffff"><strong id="copyTarget_EfilingNumber">' . $filing_num_label . $efiling_num_label_for_display.htmlentities(efile_preview($_SESSION['efiling_details']['efiling_no']), ENT_QUOTES) . '</strong></a> &nbsp;<strong id="copyButton" class="btn btn-danger btn-sm"  style="font-size: 14px;color:greenyellow;"><span class="glyphicon glyphicon-copy" style="font-size:14px;color:#ffffff;"></span></strong>';
                                    echo '&nbsp; <a class="btn btn-default btn-sm" href="' . base_url('history/efiled_case/view ') . '">eFiling History</a>';
                                }
                                ?>
                                &nbsp; <a class="btn btn-info btn-sm" type="button" onclick="window.history.back()"> Back</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <?php
                        $StageArray = explode(',', $_SESSION['efiling_details']['breadcrumb_status']);
                        if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE || $_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON) {
//                            $url_caveator = base_url('caveat/caveator');
                            $url_caveator = base_url('caveat');
                            $url_caveatee = base_url('caveat/caveatee');
                            $url_extra_party = base_url('caveat/extra_party');
                            $url_subordinate_court = base_url('caveat/subordinate_court');
                            $upload_doc_url = base_url('uploadDocuments');
                            $doc_index_url = base_url('documentIndex');
                            $url_case_courtfee = base_url('newcase/courtFee');
                        } elseif ($_SESSION['login']['ref_m_usertype_id'] == USER_CLERK) {
                            if ($_SESSION['efiling_details']['stage_id'] == Draft_Stage || $_SESSION['efiling_details']['stage_id'] == Initial_Defected_Stage) {
                                $url_caveator = base_url('caveat/caveator');
                                $url_caveatee = base_url('caveat/caveatee');
                                $url_extra_party = base_url('caveat/extra_party');
                                $url_subordinate_court = base_url('caveat/subordinate_court');
                                $upload_doc_url = base_url('uploadDocuments');
                                $doc_index_url = base_url('documentIndex');
                                $url_case_courtfee = base_url('courtFee');
                            }
                        } else {
                            $url_case_detail = $url_caveator = $url_caveatee = $url_extra_party = $url_subordinate_court = $upload_doc_url = $doc_index_url = $url_case_courtfee = '#';
                        }


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

                        include 'breadcrumbs_ribbon.php';
                        ?>