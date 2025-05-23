<?php if(!isset($efiling_search_header)) { $this->load->view('miscellaneous_docs/misc_docs_breadcrumb'); }

$stages_array = array('', Draft_Stage, Initial_Defected_Stage,  E_REJECTED_STAGE);
if (!in_array($_SESSION['efiling_details']['stage_id'], $stages_array)) {
$hidepencilbtn='true';
}else{
$hidepencilbtn='false';
}

?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="text-right">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-right">
            <?php
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
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 visible-lg visible-md">
            <button class="btn btn-primary btn-sm openall" style="float: right">Expand All <i class="fa fa-eye"></i></button>
            <button class="btn btn-info btn-sm closeall hidden" style="float: right">Collapse All <i class="fa fa-eye-slash"></i></button>
        </div>
    </div>
    <div class="clearfix"></div>
    <!--<div class="list-group-item1" style="background: #EDEDED; padding: 8px 6px 28px 10px; color: #555;" data-toggle="collapse" data-parent="#MainMenu">
        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-6"> 
            <b>Case Details</b>
        </div>-->
        <!--<div class="col-lg-5 col-md-5 col-sm-6 col-xs-5 text-right">
            <?php
/*            if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE || $_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON) {
                if ($_SESSION['efiling_details']['stage_id'] != Draft_Stage) {
                    */?>
                    <a class="btn btn-success btn-xs" target="_blank" href="<?php /*echo base_url('acknowledgement/view'); */?>">
                        <i class="fa fa-download blink"></i> eFiling Acknowledgement
                    </a>
                    <?php
/*                }
            }
            */?>
        </div>
        <div class="col-lg-2 col-md-2 visible-lg visible-md" style="width: 22%;">
            <button class="btn btn-primary btn-xs openall" style="float: right">Expand All <i class="fa fa-eye"></i></button>
            <button class="btn btn-info btn-xs closeall hidden" style="float: right">Collapse All <i class="fa fa-eye-slash"></i></button> 
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1" style="width: 3%;">
            <a href="#demo_1" class="list-group-item1" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu">
                <i class="fa fa-minus" style="float: right;"></i> <b> </a>
        </div>
    </div>-->


    <!-- Code to change

    <div class="row">
                <div class="col-sm-11">
            <a href="#demo_7" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus" style="float: right;"></i><?php if(!isset($subordinate_court_details) || empty($subordinate_court_details)){?><font style="color:orange;"> <b>Earlier Courts</b></font><?php } else{?> <b>Earlier Courts</b><?php }?></a>
            <div class="collapse" id="demo_7">
                <?php //$this->load->view('newcase/subordinate_court_list'); ?>
            </div>
                </div>
                <div class="col-sm-1" class="list-group-item" style="background: #EDEDED;" >
                    <a href="<?php //echo base_url('newcase/subordinate_court'); ?>"><i style="color:black; padding-top:10px;" class="fa fa-pencil"></i></a>
                </div>
            </div>

            end -->
    <div class="x_panel" style="background: #EDEDED;">
        <div class="col-sm-11">
    <a href="#demo_1" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-minus" style="float: right;"></i> <b> Case Details</b></a>
    <div class="collapse in" id="demo_1">
        <div class="x_panel">
            <?php $this->load->view('case_details/case_details_view', $data); ?>
        </div>
    </div>
        </div>


        <div class="row">
            <div class="col-sm-11">
    <a href="#demo_2" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus" style="float: right;"></i><?php if(!isset($filing_for_details) || empty($filing_for_details)){?><font style="color:red;"> <b>Filing For</b></font><?php } else{?> <b> Filing For</b><?php } ?></a>
    <div class="collapse" id="demo_2">
        <div class="x_panel">

            <?php
            if($hidepencilbtn!='true'){ ?>
            <div class="text-right efiling_search"><a href="<?php echo base_url('on_behalf_of'); ?>"><i class="fa fa-pencil efiling_search"></i></a></div>
            <?php } ?>
            <?php $this->load->view('on_behalf_of/filing_for_parties_list_view'); ?>
        </div>
    </div>
            </div>
            <?php
            if($hidepencilbtn!='true'){ ?>
            <div class="col-sm-1" class="list-group-item" style="background: #EDEDED;" >
                <a href="<?php echo base_url('on_behalf_of'); ?>"><i style="color:black; padding-top:10px;" class="fa fa-pencil efiling_search"></i></a>
            </div>
            <?php } ?>
        </div>


        <div class="row">
            <div class="col-sm-11">
    <a href="#demo_9" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus" style="float: right;"></i><?php if(!isset($efiled_docs_list) || empty($efiled_docs_list)){?><font style="color:red;"> <b>Documents</b></font><?php } else{?> <b>Documents</b><?php } ?></a>
    <div class="collapse" id="demo_9"> 
        <div class="x_panel">
            <?php
            if($hidepencilbtn!='true'){ ?>
            <div class="text-right"><a href="<?php echo base_url('documentIndex'); ?>"><i class="fa fa-pencil efiling_search"></i></a></div>
            <?php } ?>
            <?php $this->load->view('documentIndex/preview_misc_doc_ia_index_doc_list'); ?>
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
    <a href="#demo_10" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus" style="float: right;"></i><?php if(!isset($payment_details) || empty($payment_details)){?><font style="color:red;"> <b>Fees Paid</b></font><?php } else{?> <b>Fees Paid</b><?php } ?></a>
    <div class="collapse" id="demo_10">
        <div class="x_panel">
            <?php
            if($hidepencilbtn!='true'){ ?>
            <div class="text-right"><a href="<?php echo base_url('miscellaneous_docs/courtFee'); ?>"><i class="fa fa-pencil efiling_search"></i></a></div>
            <?php } ?>
            <?php $this->load->view('shcilPayment/payment_list_view'); ?>
        </div>
    </div>
            </div>
            <?php
            if($hidepencilbtn!='true'){ ?>
            <div class="col-sm-1" class="list-group-item" style="background: #EDEDED;" >
                <a href="<?php echo base_url('miscellaneous_docs/courtFee'); ?>"><i style="color:black; padding-top:10px;" class="fa fa-pencil efiling_search"></i></a>
            </div>
            <?php } ?>
        </div>

        <!--//XXXXXXXXXXXXXXXXXXXXX START XXXXXXXXXXXXXXXXXXXXX-->
        <!--<div class="row">
            <div class="col-sm-11">
                <a href="#demo_12" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus" style="float: right;"></i><?php /*if(!isset($shareEmail_details) || empty($shareEmail_details)){*/?><font style="color:red;"> <b> Share Documents</b></font><?php /*} else{ */?> <b> Share Documents</b><?php /*} */?></a>
                <div class="collapse" id="demo_12">
                    <div class="x_panel">
                        <?php
/*                        if($hidepencilbtn!='true'){ */?>
                        <div class="text-right"><a href="<?php /*echo base_url('shareDoc'); */?>"><i class="fa fa-pencil efiling_search"></i></a></div>
                        <?php /*} */?>
                        <?php /*$this->load->view('documentIndex/preview_misc_doc_index_sharedoc_list'); */?>
                    </div>
                </div>
            </div>
            <?php
/*            if($hidepencilbtn!='true'){ */?>
            <div class="col-sm-1" class="list-group-item" style="background: #EDEDED;" >
                <a href="<?php /*echo base_url('shareDoc'); */?>"><i style="color:black; padding-top:10px;" class="fa fa-pencil efiling_search"></i></a>
            </div>
            <?php /*} */?>
        </div>-->


        <!--//XXXXXXXXXXXXXXXXXXXXXX END XXXXXXXXXXXXXXXXXXXXXXXX-->




        <!--<div class="row">
            <div class="col-sm-11">
    <a href="#demo_11" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu">
        <i class="fa fa-plus" style="float: right;"></i><?php /*if(!isset($esigned_docs_details) || empty($esigned_docs_details)){*/?><font style="color:red;"> <b>Affirmation</b></font><?php /*} else{*/?> <b>Affirmation</b><?php /*} */?></a>
    <div class="collapse" id="demo_11">
        <div class="x_panel">
            <?php
/*            if($hidepencilbtn!='true'){ */?>
            <div class="text-right"><a href="<?php /*echo base_url('affirmation'); */?>"><i class="fa fa-pencil efiling_search"></i></a></div>
            <?php /*} */?>
                    <?php /*$this->load->view('affirmation/preview_certificate_view'); */?>
        </div>
    </div>
            </div>
            <?php
/*            if($hidepencilbtn!='true'){ */?>
            <div class="col-sm-1" class="list-group-item" style="background: #EDEDED;" >
                <a href="<?php /*echo base_url('affirmation'); */?>"><i style="color:black; padding-top:10px;" class="fa fa-pencil efiling_search"></i></a>
            </div>
            <?php /*} */?>
        </div>-->



</div>
<?php $this->load->view('modals.php'); ?>



