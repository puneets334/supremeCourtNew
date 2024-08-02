<?php $this->load->view('newcase/new_case_breadcrumb'); ?>
<div class="x_content">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div style="float: right">
            &nbsp;<a title="Click Here To View All Information" href="javascript:void(0);" class="btn btn-outline btn-primary openall" style="float: right">
                <span class="fa fa-eye"></span>&nbsp;&nbsp; View All
            </a>
            <a title="Click Here To Close All Information" href="javascript:void(0);" class="btn btn-outline btn-info closeall" style="float: right; ">
                <span class="fa fa-eye-slash"></span> Close All
            </a>
        </div>
        <div class="x_panel"> 

            <a href="#demo_1" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu" aria-expanded="true"><i class="fa fa-minus" style="float: right;"></i> <b>Case Details</b></a>
            <div class="collapse in" id="demo_1" aria-expanded="true">

                <div class="x_panel">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 text-right" for="filing_no">Cause Title : </label>
                            <div class="col-md-8">
                                <p> <?php echo_data($new_case_details[0]['cause_title']) ?> </p>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 text-right" for="filing_no">Main Category : </label>
                            <div class="col-md-8">
                                <p> <?php echo_data(strtoupper($main_subject_cat[0]->sub_name1)); ?> </p>
                            </div>
                        </div> 
                    </div>
                    <!--                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-4 text-right" for="filing_no">Special Case Type : </label>
                                                <div class="col-md-8">
                                                    <p> <?php echo_data(strtoupper($main_subject_cat[0]->sub_name1)); ?> </p>
                                                </div>
                                            </div> 
                                        </div>-->
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 text-right" for="filing_no">Question of Law :</label>
                            <div class="col-md-8">
                                <p> <?php echo_data($new_case_details[0]['question_of_law']) ?> </p>
                            </div>
                        </div> 
                    </div> 
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 text-right" for="filing_no">Grounds :</label>
                            <div class="col-md-8">
                                <p> <?php echo_data($new_case_details[0]['grounds']) ?> </p>
                            </div>
                        </div> 
                    </div> 
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 text-right" for="filing_no">Interim Grounds :</label>
                            <div class="col-md-8">
                                <p> <?php echo $new_case_details[0]['grounds_interim'] ?> </p>
                            </div>
                        </div> 
                    </div> 
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 text-right" for="filing_no">Interim Relief :</label>
                            <div class="col-md-8">
                                <p> <?php echo $new_case_details[0]['interim_relief'] ?> </p>
                            </div>
                        </div> 
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 text-right" for="filing_no">Main Prayer :</label>
                            <div class="col-md-8">
                                <p> <?php echo $new_case_details[0]['main_prayer'] ?> </p>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>

            <a href="#demo_2" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus" style="float: right;"></i> <b>Petitioner</b></a>
            <div class="collapse" id="demo_2">
                <?php $this->load->view('newcase/petitioner_list_view'); ?>
            </div>

            <a href="#demo_3" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus" style="float: right;"></i> <b>Respondent</b></a>
            <div class="collapse" id="demo_3">
                <?php $this->load->view('newcase/respondent_list_view'); ?>
            </div>

            <a href="#demo_16" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus" style="float: right;"></i> <b>Extra Party</b></a>
            <div class="collapse" id="demo_16">
                <?php $this->load->view('newcase/extra_party_list_view'); ?>
            </div>

            <a href="#demo_4" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus" style="float: right;"></i> <b>Legal Representative</b></a>
            <div class="collapse" id="demo_4">
                <?php $this->load->view('newcase/lr_party_list_view'); ?>
            </div>

            <a href="#demo_6" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus" style="float: right;"></i> <b>Act-Section</b></a>
            <div class="collapse" id="demo_6">
                <?php $this->load->view('newcase/act_sections_list_view'); ?>
            </div>

            <a href="#demo_7" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus" style="float: right;"></i> <b>Subordinate Courts</b></a>
            <div class="collapse" id="demo_7">
                <?php $this->load->view('newcase/subordinate_court_list'); ?>
            </div>

<!--            <a href="#demo_8" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus" style="float: right;"></i> <b>Upload Documents</b></a>
            <div class="collapse" id="demo_8">
            <?php //$this->load->view('newcase/petitioner_list_view');  ?>
            </div>-->

            <a href="#demo_9" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus" style="float: right;"></i> <b>Index</b></a>
            <div class="collapse" id="demo_9">
                <?php //$this->load->view('newcase/petitioner_list_view');  ?>
                <div class="panel panel-default">
                    <div class="panel-body">        
                        <div id ="index_data">             
                            <?php // INDEX LIST BEING POPULATED USING AJAX HERE  JAVASCRIPT FUNCTION reload_document_index  -- AJAXCALLS load_document_index METHOD   ?>
                        </div>
                    </div>
                </div>
            </div>

            <!--            <a href="#demo_10" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus" style="float: right;"></i> <b>Pay Court Fee</b></a>
            <div class="collapse" id="demo_10">
                <?php //$this->load->view('newcase/petitioner_list_view');  ?>
            </div>-->

            <a href="#demo_11" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-plus" style="float: right;"></i> <b>Affirmation</b></a>
            <div class="collapse" id="demo_11">
                <?php $this->load->view('newcase/affirmation_list_view');  ?>
            </div>
            
        </div>
    </div>
</div>
<?php $this->load->view('modals.php'); ?>
</div> </div> </div> </div> </div> </div> 
<script>
    $(document).ready(function () {

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        /*$.ajax({
            type: 'POST',
            url: "<?php echo base_url('documentIndex/Ajaxcalls/load_document_index'); ?>",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, res: 1},
            success: function (data) {
                $('#index_data').html(data);
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                });
            },
            error: function () {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });*/
    });
</script>