
<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type"
        content="text/html; charset=utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0" />
    <title>SC</title>
    <link rel="shortcut icon"
        href="<?= base_url() . 'assets/newAdmin/' ?>images/favicon.gif">
    <link href="<?= base_url() . 'assets/newAdmin/' ?>css/bootstrap.min.css"
        rel="stylesheet">
    <link href="<?= base_url() . 'assets/newAdmin/' ?>css/font-awesome.min.css"
        rel="stylesheet">
    <link href="<?= base_url() . 'assets/newAdmin/' ?>css/animate.css"
        rel="stylesheet">
    <link href="<?= base_url() . 'assets/newAdmin/' ?>css/material.css"
        rel="stylesheet" />
    <link href="<?= base_url() . 'assets/newAdmin/' ?>css/style.css"
        rel="stylesheet">
    <link rel="stylesheet"
        type="text/css"
        href="<?= base_url() . 'assets/newAdmin/' ?>css/jquery.dataTables.min.css">
    <link href="<?= base_url() . 'assets/newAdmin/' ?>css/fullcalendar.css"
        rel="stylesheet">
    <link rel="stylesheet"
        href="<?= base_url() ?>assets/css/bootstrap-datepicker.css">
    <link rel="stylesheet"
        href="<?= base_url() ?>assets/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet"
        href="<?= base_url() ?>assets/css/jquery-ui.css">
    <link href="<?= base_url() . 'assets' ?>/css/select2.min.css"
        rel="stylesheet">
    @stack('style')
</head>
<?php  
$area_extended = false;
$collapse_class = 'collapse in';

?>

<body>
    <div class="mainPanel ">
        <div class="panelInner">
            <div class="middleContent">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 sm-12 col-md-12 col-lg-12 middleContent-left">
                            <!-- Sec Start Here  -->
                            <?php if(isset($efiling_search_header)) {?>
                                <style>
                                    .efiling_search{visibility: hidden !important;}
                                </style>
                            <?php } ?>
                            <?php
                                if (!isset($efiling_search_header)) {
                                    render('IA.ia_breadcrumb');
                                }

                                $stages_array = array('', Draft_Stage, Initial_Defected_Stage,  E_REJECTED_STAGE);
                                if (!in_array(getSessionData('efiling_details')['stage_id'], $stages_array)) {
                                    $hidepencilbtn = 'true';
                                } else {
                                    $hidepencilbtn = 'false';
                                }

                            ?>
                            <div class="center-content-inner comn-innercontent">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="tab-form-inner">
                                            <div class="row">
                                                <div style="float: right">
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-right">
                                                        <?php
                                                        if (getSessionData('login')['ref_m_usertype_id'] == USER_ADVOCATE || getSessionData('login')['ref_m_usertype_id'] == USER_IN_PERSON) {
                                                            $allowed_users_array = array(Initial_Approaval_Pending_Stage, I_B_Defects_Cured_Stage, Initial_Defects_Cured_Stage);
                                                            if (in_array(getSessionData('efiling_details')['stage_id'], $allowed_users_array)) {
                                                        ?>
                                                                <a class="btn btn-success btn-sm" target="_blank" href="<?php echo base_url('acknowledgement/view'); ?>">
                                                                    <i class="fa fa-download blink"></i> eFiling Acknowledgement
                                                                </a>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                            
                                                    <a title="Click Here To View All Information" href="javascript:void(0);" class="btn btn-outline btn-primary btn-sm openall" style="float: right">
                                                            <span class="fa fa-eye"></span>&nbsp;&nbsp; Expand All
                                                    </a>
                                                    <a title="Click Here To Close All Information" href="javascript:void(0);" class="btn btn-outline btn-info btn-sm closeall" style="float: right; ">
                                                        <span class="fa fa-eye-slash"></span> Collapse All
                                                    </a>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="accordion" id="accordionExample">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingOne">
                                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                    Case Details
                                                                </button>
                                                            </h2>
                                                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"  data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    <div class="x_panel">
                                                                        <?php render('case_details.case_details_view', ['case_details' => $case_details]); ?>
                                                                      
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="accordion-item">
                                                            <div class="row">
                                                                <h2 class="accordion-header col-sm-11" id="headingTwo">
                                                                    <button class="accordion-button collapsed"
                                                                        type="button"
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#collapseTwo"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseTwo" <?php echo $area_extended; ?>>
                                                                        <?php 
                                                                        if(!isset($filing_for_details) || empty($filing_for_details)){?>
                                                                        <font style="color:red;"> <b>Filing For</b></font>
                                                                        <?php } else{?> <b> Filing For</b><?php } ?>
                                                                    </button>
                                                                </h2>
                                                                <?php
                                                                  if($hidepencilbtn!='true'){ ?>
                                                                <div class="col-sm-1">
                                                                    <a href="<?php echo base_url('on_behalf_of'); ?>""><i
                                                                            style="color:black; padding-top: 20px !important;"
                                                                            class="fa fa-pencil efiling_search"></i></a>
                                                                </div>
                                                                <?php } ?>   

                                                            </div>
                                                            <div id="collapseTwo"
                                                                class="accordion-collapse collapse <?php echo $collapse_class; ?>"
                                                                aria-labelledby="headingTwo"
                                                                data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    <?php render('on_behalf_of.filing_for_parties_list_view', ['filing_for_details' => $filing_for_details]); ?>                                                                 
                                                                   
                                                                </div>
                                                            </div>
                                                            
                                                        </div>

                                                        <div class="accordion-item">
                                                            <div class="row">
                                                                <h2 class="accordion-header col-sm-11" id="headingThree">
                                                                    <button class="accordion-button collapsed"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#collapseThree"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseThree" <?php echo $area_extended; ?>>
                                                                        <?php 
                                                                        if(!isset($efiled_docs_list) || empty($efiled_docs_list)){?>
                                                                        <font style="color:red;"> <b>Documents</b></font>
                                                                        <?php } else{?> <b>Documents</b><?php } ?>
                                                                    </button>
                                                                </h2>
                                                                <?php
                                                            if($hidepencilbtn!='true'){ ?>
                                                                <div class="col-sm-1">
                                                                    <a href="<?php echo base_url('documentIndex'); ?>"><i
                                                                            style="color:black; padding-top:20px;"
                                                                            class="fa fa-pencil efiling_search"></i></a>
                                                                </div>
                                                                <?php } ?>
                                                            </div>
                                                            <div id="collapseThree"
                                                                class="accordion-collapse collapse <?php echo $collapse_class; ?>"
                                                                aria-labelledby="headingThree"
                                                                data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    <?php render('documentIndex.documentIndex_misc_ia_list_view', ['efiled_docs_list' => $efiled_docs_list]); ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <div class="row">
                                                                <h2 class="accordion-header col-sm-11"
                                                                    id="headingNine">
                                                                    <button class="accordion-button collapsed"
                                                                        type="button"
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#collapseNine"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseNine"
                                                                        <?php echo $area_extended; ?>>
                                                                        <?php if (!isset($payment_details) || empty($payment_details)) { ?><span style="color:red;"> <b>Fees Paid</b></span><?php } else { ?> <b>Fees Paid</b><?php } ?>
                                                                    </button>
                                                                </h2>
                                                                <?php
                                                            if($hidepencilbtn!='true'){ ?>
                                                                <div class="col-sm-1">
                                                                    <a href="<?php echo base_url('IA/courtFee'); ?>"><i
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
                                                                    <?php render('shcilPayment.payment_list_view', ['payment_details' => $payment_details]); ?>
                                                                   
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Sec End Here  -->                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<div class="col-md-12 col-sm-12 col-xs-12">


</div>
</div>
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
    <script type="text/javascript"
        src="<?= base_url() . 'assets' ?>/js/jquery.validate.js"></script>

<script>
    $(document).ready(function() {

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('newcase/Ajaxcalls/load_document_index'); ?>",
            data: {
                CSRF_TOKEN: CSRF_TOKEN_VALUE,
                res: 1
            },
            success: function(data) {
                $('#index_data').html(data);
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                });
            },
            error: function() {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
    });
</script>