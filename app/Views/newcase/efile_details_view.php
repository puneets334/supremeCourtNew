<?php  if(!isset($efiling_search_header)) { $this->load->view('newcase/new_case_breadcrumb'); }
    $ref_m_usertype_id = !empty($_SESSION['login']['ref_m_usertype_id']) ? $_SESSION['login']['ref_m_usertype_id'] : NULL;
    $stage_id = !empty($_SESSION['efiling_details']['stage_id']) ? $_SESSION['efiling_details']['stage_id'] : NULL;
    $filing_type = !empty($_SESSION['efiling_details']['efiling_type']) ? $_SESSION['efiling_details']['efiling_type'] : NULL;
    $collapse_class = 'collapse';
    $area_extended = false;
    $diary_generate_button ='';
    $diary ='';
    if(isset($new_case_details[0]['sc_diary_num']) && !empty($new_case_details[0]['sc_diary_num'])){
        $diary = $new_case_details[0]['sc_diary_num'];
    }
    if(isset($new_case_details[0]['sc_diary_year']) && !empty($new_case_details[0]['sc_diary_year'])){
        $diary .= ' / '.$new_case_details[0]['sc_diary_year'];
    }
    if(isset($ref_m_usertype_id) && !empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && isset($stage_id) && !empty($stage_id) && $stage_id == Transfer_to_IB_Stage) {
        $collapse_class = 'collapse in';
        $area_extended = true;
        $diary_generate_button = '<a  href="javaScript:void(0)" class="btn btn-primary" data-efilingtype="new_case" id="generateDiaryNoPop" type="button" style="float: left;margin-right: 120px;">Generate Diary No.</a>';
    }
$stages_array = array('', Draft_Stage, Initial_Defected_Stage,  E_REJECTED_STAGE);
if (!in_array($_SESSION['efiling_details']['stage_id'], $stages_array)) {
    $hidepencilbtn='true';
}else{
    $hidepencilbtn='false';
}
?>
<?php if(isset($efiling_search_header)) {?>
    <style>
        .efiling_search{visibility: hidden !important;}
    </style>
<?php } ?>
<div class="x_content">
    <div class="col-md-12 col-sm-12 col-xs-12">

        <div style="float: right">
            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-5 text-right">
                <?php
                //print_r($new_case_details);
                if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE || $_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON) {
                    //if ($_SESSION['efiling_details']['stage_id'] != Draft_Stage) {
                    $allowed_users_array = array(Initial_Approaval_Pending_Stage,I_B_Defects_Cured_Stage,Initial_Defects_Cured_Stage);
                    if (in_array($_SESSION['efiling_details']['stage_id'], $allowed_users_array)) {
                        ?>
                        <a class="btn btn-success btn-sm" target="_blank" href="<?php echo base_url('acknowledgement/view'); ?>"> 
                            <i class="fa fa-download blink"></i> eFiling Acknowledgement
                        </a>
                        <?php
                    }
                }
                ?>
            </div>
            <?php  //$diary = false;
            if(isset($diary_generate_button) && !empty($diary_generate_button) && empty($diary)){
                echo $diary_generate_button;
            }
            if(isset($ref_m_usertype_id) && !empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && isset($stage_id) && !empty($stage_id) && $stage_id == I_B_Defects_Cured_Stage) {
                if(!empty($_SESSION['efiling_details']['stage_id']) && $_SESSION['efiling_details']['stage_id'] == I_B_Defects_Cured_Stage){
                    echo '<a  href="javaScript:void(0)" class="btn btn-primary" data-efilingtype="new_case" data-registration_id="'.$_SESSION['efiling_details']['registration_id'].'" id="transferToScrutiny" type="button" style="float: left;margin-right: 92px;">Transfer To Scrutiny</a>';
                }
            }
            ?>

            <a title="Click Here To View All Information" href="javascript:void(0);" class="btn btn-outline btn-primary btn-sm openall" style="float: right">
                <span class="fa fa-eye"></span>&nbsp;&nbsp; View All
            </a>
            <a title="Click Here To Close All Information" href="javascript:void(0);" class="btn btn-outline btn-info btn-sm closeall" style="float: right; ">
                <span class="fa fa-eye-slash"></span> Close All
            </a>
        </div>

        <div class="x_panel" style="background: #EDEDED;">
            <div class="col-sm-11">
            <a href="#demo_1" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu" aria-expanded="true"><i class="fa fa-minus" style="float: right;"></i> <b>Case Details</b></a>
            <div class="collapse in" id="demo_1" aria-expanded="true">

                <div class="x_panel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4 text-right" for="filing_no">Cause Title : </label>
                                <div class="col-md-8">
                                    <p> <?php
                                        //echo_data($filedByData);
                                        echo_data($new_case_details[0]['cause_title']) ?> </p>
                                </div>
                            </div> 
                        </div>   
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4 text-right" for="filing_no">Case Type : </label>
                                <div class="col-md-8">
                                    <p> <?php echo_data(strtoupper($sc_case_type[0]->casename)) ?> </p>
                                </div>
                            </div> 
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4 text-right" for="filing_no">Subject Category : </label>
                                <div class="col-md-8">
                                    <p> <?php
                                        echo_data(strtoupper($main_subject_cat[0]->sub_name1));
                                        echo_data(!empty($sub_subject_cat[0]->sub_name4)?"(".$sub_subject_cat[0]->sub_name4.")":'');
                                       ?> </p>
                                </div>
                            </div> 
                        </div>
                        <?php
                        if(isset($diary) && !empty($diary)){
                            echo '<div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4 text-right" for="diary_no">Diary No. : </label>
                                            <div class="col-md-8">
                                                <p>'.$diary.'</p>
                                            </div>
                                        </div>
                                    </div>';
                        }
                        if(isset($filedByData) && !empty($filedByData)){
                            $vakalat_advocate='';
                            if(isset($vakalat_filedByData) && !is_null($vakalat_filedByData)){
                                $vakalat_advocate = '<p><b>Transfered to : </b>'.$vakalat_filedByData.'</p><p>'.$vakalat_filedByData_contact_emailid.'</p>';
                            }
                            $filed = '<div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4 text-right" for="filed_by">Filed By: </label>
                                            <div class="col-md-8">
                                                <p>'.$filedByData.'</p>
                                                <p>'.$filedByData_contact_emailid.'</p>'.$vakalat_advocate.'
                                            </div>
                                        </div>
                                    </div>';
                            echo $filed;
                        }
                        ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4 text-right" for="filing_no">No. of Petitioner : </label>
                                <div class="col-md-8">
                                    <p><?php echo_data($new_case_details[0]['no_of_petitioners'])?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4 text-right" for="filing_no">No. of Respondent : </label>
                                <div class="col-md-8">
                                    <p><?php echo_data($new_case_details[0]['no_of_respondents'])?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4 text-right" for="filing_no">IF SCLSC : </label>
                                <div class="col-md-8">
                                    <p><?php echo (!empty($new_case_details[0]['if_sclsc']) && ($new_case_details[0]['if_sclsc'] ==1)) ? 'Yes' : 'No'  ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4 text-right" for="filing_no">Special Category : </label>
                                <div class="col-md-8">
                                    <p><?php echo (!empty($new_case_details[0]['category_name']) ) ? $new_case_details[0]['category_name'] : 'None'  ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-sm-11">
            <a href="#demo_2" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" <?php echo $area_extended;?> data-parent="#MainMenu">
                <?php
                if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && !empty($stage_id) && $stage_id == Transfer_to_IB_Stage)
                {
                    echo '<i class="fa fa-minus" style="float: right;"></i>';
                }
               else if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADVOCATE){
                    echo '<i class="fa fa-plus" style="float: right;"></i>';
                }
                else {
                    echo '<i class="fa fa-plus" style="float: right;"></i>';
                }
                if(!isset($petitioner_details) || empty($petitioner_details)){?>
                    <font style="color:red;"> <b>Petitioner</b></font><?php } else{?><b>Petitioner</b><?php }?></a>
            <div class="<?php echo $collapse_class;?>" id="demo_2">
                <?php $this->load->view('newcase/petitioner_list_view'); ?>
            </div>
            </div>
                <?php
                if($hidepencilbtn!='true'){ ?>
                    <div class="col-sm-1" class="list-group-item" style="background: #EDEDED;" >
                        <a href="<?php echo base_url('newcase/petitioner'); ?>"><i style="color:black; padding-top:10px;" class="fa fa-pencil efiling_search"></i></a>
                    </div>

                <?php } ?>
            </div>

            <div class="row">
                <div class="col-sm-11">
            <a href="#demo_3" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" <?php echo $area_extended;?> data-parent="#MainMenu">
                <?php
                if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && !empty($stage_id) && $stage_id == Transfer_to_IB_Stage)
                {
                    echo '<i class="fa fa-minus" style="float: right;"></i>';
                }
                else if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADVOCATE){
                    echo '<i class="fa fa-plus" style="float: right;"></i>';
                }
                else {
                    echo '<i class="fa fa-plus" style="float: right;"></i>';
                }
                    if(!isset($respondent_details) || empty($respondent_details)){?><font style="color:red;"> <b>Respondent</b></font><?php } else{?> <b>Respondent</b><?php }?></a>
            <div class="<?php echo $collapse_class;?>" id="demo_3">
                <?php $this->load->view('newcase/respondent_list_view'); ?>
            </div>
                </div>
                <?php
                if($hidepencilbtn!='true'){ ?>
                <div class="col-sm-1" class="list-group-item" style="background: #EDEDED;" >
                    <a href="<?php echo base_url('newcase/respondent'); ?>"><i style="color:black; padding-top:10px;" class="fa fa-pencil efiling_search"></i></a>
                </div>
                <?php } ?>
            </div>

            <div class="row" style="display: none;">
                <div class="col-sm-11">
            <a href="#demo_16" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" <?php echo $area_extended;?> data-parent="#MainMenu">
                <?php
                if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && !empty($stage_id) && $stage_id == Transfer_to_IB_Stage)
                {
                    echo '<i class="fa fa-minus" style="float: right;"></i>';
                }
               else if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADVOCATE){
                    echo '<i class="fa fa-plus" style="float: right;"></i>';
                }
                else {
                    echo '<i class="fa fa-plus" style="float: right;"></i>';
                }
                    if(!isset($extra_parties_list) || empty($extra_parties_list)){?><font style="color:orange;"> <b>Extra Party</b></font><?php } else{?> <b>Extra Party</b><?php }?></a>
            <div class="<?php echo $collapse_class;?>" id="demo_16">
                <?php $this->load->view('newcase/extra_party_list_view'); ?>
            </div>
                </div>

                <?php
                if($hidepencilbtn!='true'){ ?>
                <div class="col-sm-1" class="list-group-item" style="background: #EDEDED;" >
                    <a href="<?php echo base_url('newcase/extra_party'); ?>"><i style="color:black; padding-top:10px;" class="fa fa-pencil efiling_search"></i></a>
                </div>
                <?php } ?>
            </div>

            <div class="row" style="display: none;">
                <div class="col-sm-11">
            <a href="#demo_4" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" <?php echo $area_extended;?> data-parent="#MainMenu">
                <?php
                if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && !empty($stage_id) && $stage_id == Transfer_to_IB_Stage)
                {
                    echo '<i class="fa fa-minus" style="float: right;"></i>';
                }
               else if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADVOCATE){
                    echo '<i class="fa fa-plus" style="float: right;"></i>';
                }
                else {
                    echo '<i class="fa fa-plus" style="float: right;"></i>';
                }
                    if(!isset($lr_parties_list) || empty($lr_parties_list)){?><font style="color:orange;"> <b>Legal Representative</b></font><?php } else{?> <b>Legal Representative</b><?php }?></a>
            <div class="<?php echo $collapse_class;?>" id="demo_4">
                <?php $this->load->view('newcase/lr_party_list_view'); ?>
            </div>
                </div>
                <?php
                if($hidepencilbtn!='true'){ ?>
                <div class="col-sm-1" class="list-group-item" style="background: #EDEDED;" >
                    <a href="<?php echo base_url('newcase/lr_party'); ?>"><i style="color:black; padding-top:10px;" class="fa fa-pencil efiling_search"></i></a>
                </div>
                <?php } ?>
            </div>

            <div class="row" style="display: none;">
                <div class="col-sm-11">
            <a href="#demo_6" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" <?php echo $area_extended;?> data-parent="#MainMenu">
                <?php
                if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && !empty($stage_id) && $stage_id == Transfer_to_IB_Stage)
                {
                    echo '<i class="fa fa-minus" style="float: right;"></i>';
                }
             else if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADVOCATE){
                    echo '<i class="fa fa-plus" style="float: right;"></i>';
                }
                else {
                    echo '<i class="fa fa-plus" style="float: right;"></i>';
                }

                    if(!isset($act_sections_list) || empty($act_sections_list)){?><font style="color:red;"> <b>Act-Section</b></font><?php } else{?> <b>Act-Section</b><?php }?></a>
            <div class="<?php echo $collapse_class;?>" id="demo_6">
                <?php $this->load->view('newcase/act_sections_list_view'); ?>
            </div>
                </div>
                <?php
                if($hidepencilbtn!='true'){ ?>
                <div class="col-sm-1" class="list-group-item" style="background: #EDEDED;" >
                    <a href="<?php echo base_url('newcase/actSections'); ?>"><i style="color:black; padding-top:10px;" class="fa fa-pencil efiling_search"></i></a>
                </div>
                <?php } ?>
            </div>

            <div class="row">
                <div class="col-sm-11">
            <a href="#demo_7" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" <?php echo $area_extended;?> data-parent="#MainMenu">
                <?php
                if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && !empty($stage_id) && $stage_id == Transfer_to_IB_Stage)
                {
                    echo '<i class="fa fa-minus" style="float: right;"></i>';
                }
               else  if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADVOCATE){
                    echo '<i class="fa fa-plus" style="float: right;"></i>';
                }
                else {
                    echo '<i class="fa fa-plus" style="float: right;"></i>';
                }

                if(!isset($subordinate_court_details) || empty($subordinate_court_details)){?><font style="color:orange;"> <b>Earlier Courts</b></font><?php } else{?> <b>Earlier Courts</b><?php }?></a>
            <div class="<?php echo $collapse_class;?>" id="demo_7">
                <?php $this->load->view('newcase/subordinate_court_list'); ?>
            </div>
                </div>
                <?php
                if($hidepencilbtn!='true'){ ?>
                <div class="col-sm-1" class="list-group-item" style="background: #EDEDED;" >
                    <a href="<?php echo base_url('newcase/subordinate_court'); ?>"><i style="color:black; padding-top:10px;" class="fa fa-pencil efiling_search"></i></a>
                </div>
                <?php } ?>
            </div>

            <div class="row">
                <div class="col-sm-11">
            <a href="#demo_9" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" <?php echo $area_extended;?> data-parent="#MainMenu">
                    <?php
                    if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && !empty($stage_id) && $stage_id == Transfer_to_IB_Stage)
                    {
                        echo '<i class="fa fa-minus" style="float: right;"></i>';
                    }
                   else if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADVOCATE){
                        echo '<i class="fa fa-plus" style="float: right;"></i>';
                    }
                    else {
                        echo '<i class="changeScruitinyStagefa fa-plus" style="float: right;"></i>';
                    }

                if(!isset($efiled_docs_list) || empty($efiled_docs_list)){?><font style="color:red;"> <b>Index</b></font><?php } else{?> <b>Index</b><?php }?></a>
            <div class="<?php echo $collapse_class;?>" id="demo_9">
                <div class="x_panel">
                    <?php
                    if($hidepencilbtn!='true'){ ?>
                    <div class="text-right"><a href="<?php echo base_url('documentIndex'); ?>"><i class="fa fa-pencil efiling_search"></i></a></div>
                    <?php } ?>
                    <?php $this->load->view('documentIndex/preview_newcase_index_doc_list'); ?>
                </div>

            </div>
                </div>
                <?php
                if($hidepencilbtn!='true'){ ?>
                <div class="col-sm-1" class="list-group-item" style="background: #EDEDED;" >
                    <a href="<?php echo base_url('documentIndex'); ?>"><i style="color:black; padding-top:10px;" class="fa fa-pencil efiling_search"></i></a>
                </div>
                <?php } ?>
            </div>

            <div class="row">
                <div class="col-sm-11">
            <a href="#demo_10" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" <?php echo $area_extended;?> data-parent="#MainMenu">
                <?php
                if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && !empty($stage_id) && $stage_id == Transfer_to_IB_Stage)
                {
                    echo '<i class="fa fa-minus" style="float: right;"></i>';
                }
               else if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADVOCATE){
                    echo '<i class="fa fa-plus" style="float: right;"></i>';
                }
                else {
                    echo '<i class="fa fa-plus" style="float: right;"></i>';
                }
                $pending_court_fee=getPendingCourtFee();
                if((!isset($payment_details) || empty($payment_details)) && ($pending_court_fee>0)){?><font style="color:red;"> <b>Court Fee</b></font><?php } else{?> <b>Court Fee</b><?php }?></a>
            <div class="<?php echo $collapse_class;?>" id="demo_10">
                <?php
                if($hidepencilbtn!='true'){ ?>
                <div class="text-right"><a href="<?php echo base_url('newcase/courtFee'); ?>"><i class="fa fa-pencil efiling_search"></i></a></div>
                <?php } ?>
                <?php $this->load->view('shcilPayment/payment_list_view'); ?>
            </div>
                </div>
                <?php
                if($hidepencilbtn!='true'){ ?>
                <div class="col-sm-1" class="list-group-item" style="background: #EDEDED;" >
                    <a href="<?php echo base_url('newcase/courtFee'); ?>"><i style="color:black; padding-top:10px;" class="fa fa-pencil efiling_search"></i></a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php $this->load->view('modals.php',array('filing_type'=>$filing_type)); ?>





</div> </div> </div> </div> </div> </div> 
