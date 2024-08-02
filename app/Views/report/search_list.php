<style>.pointer {cursor: pointer;}</style>
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="msg">
                <?php

                if (isset($_SESSION['MSG']) && !empty($_SESSION['MSG'])) {
                    echo $_SESSION['MSG'];
                } unset($_SESSION['MSG']);
                ?></div>
        </div>
    </div>

    <div class="row">

            <div class="x_panel">

                    <div class="x_title">
                        <?php //if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADMIN) {
                        if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADMIN || $_SESSION['login']['ref_m_usertype_id'] == USER_ADMIN_READ_ONLY || $_SESSION['login']['ref_m_usertype_id']==USER_EFILING_ADMIN) { ?>
                        <h2><i class="fa fa-newspaper-o"></i>Report</h2>
                        <?php } else { ?>
                            <h2><i class="fa fa-newspaper-o"></i>Search Cases</h2>
                        <?php } ?>
                        <div class="clearfix"></div>
                    </div>

    <!------------Table--------------------->

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <div class="x_panel">
                <div class="x_title"> <h3><span style="float:right;">  <a class="btn btn-info" type="button" onclick="window.history.back()"> Back</a></span></h3> </div>
                <div class="x_content">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar dictbldata">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr class="success input-sm" role="row" >
                                <th width="6%">S.N0.</th>
                                <th width="10%">Filing No. <br> Filed On</th>
                                <th width="8%">Type</th>
                                <th width="8%">Diary No.</th>
                                <th width="25%">Causetitle</th>
                                <th width="14%">Filed By</th>
                                <th width="10%">Stages</th>
                                <th width="10%">Last Updated On</th>
                                <th width="14%">Allocated To</th>
                                <th width="14%">Pending Since Day(s)</th>
                                <th width="14%">Currently With</th>
                                <th width="14%">In Software</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $diary_no_m=''; $diary_year_m=''; $open_case_status=''; $reg_no='';
                            $length = count($report_list);
                            $redirect_url = ''; $efiling_no=''; $rd=''; $v=''; $res_name=''; $pet_name=''; $cause_title=''; $cause_details=''; $diary_no=''; $diary_year='';
                            $i= 1;
                            foreach ($report_list as $report) {
                                $stage_id=$report->stage_id;
                                if($report->cause_title!=null){$cause_title=$report->cause_title; }
                                else if($report->ecase_cause_title!=null){$cause_title=$report->ecase_cause_title; }

                                if($report->pet_name!=null){$pet_name=$report->pet_name.'Vs.';}else{ $pet_name=''; }

                                if($report->res_name!=null){$res_name=$report->res_name;} else{$res_name='';}
                                $diary_no='';$diary_year='';$reg_no='';

                                if($report->diary_no!=null){$diary_no=''.$report->diary_no.'/'; $diary_no_m=$report->diary_no;}else if($report->sc_diary_num!=null){$diary_no=''.$report->sc_diary_num.'/'; $diary_no_m=$report->sc_diary_num;}
                                if($report->diary_year!=null){$diary_year=$report->diary_year.'<br/>'; $diary_year_m=$report->diary_year;}else if($report->sc_diary_year!=null){$diary_year=$report->sc_diary_year.'<br/>'; $diary_year_m=$report->sc_diary_year;}
                                if ($report->reg_no_display != '' && $report->sc_display_num !=null) {
                                    $reg_no = '<b>Registration No.</b> : ' .$report->sc_display_num. '<br/> ';
                                } else {
                                    $reg_no = '';
                                }
                                if($diary_no_m !=null && $diary_year_m !=null){
                                    $open_case_status='href="#" onClick="open_case_status()"';
                                }else{ $open_case_status='';}
                                $case_no=$diary_no.$diary_year.$reg_no;
                                if($report->efiling_type!='CAVEAT'){
                                    $cause_details= '<a '.$open_case_status.' data-diary_no="'.$diary_no_m.'" data-diary_year="'.$diary_year_m.'">'.'<span class="sci">'.$cause_title.'<br/>'.$pet_name.$res_name.'</span>'.'</a>';
                                }
                                else{
                                    $cause_details='';
                                }


                                if($report->efiling_type !='' && $report->efiling_type=='new_case') {
                                    $rd='newcase.defaultController'; //. equal to / required
                                    $v='/'.$report->registration_id . '/' . $report->ref_m_efiled_type_id . '/' . $report->stage_id . '/' . $report->efiling_no;
                                }
                                else if($report->efiling_type !='' && $report->efiling_type=='misc_document') {
                                    $rd='miscellaneous_docs.DefaultController'; //. equal to / required
                                    $v='/'.$report->registration_id . '/' . $report->ref_m_efiled_type_id . '/' . $report->stage_id;
                                }
                                else if($report->efiling_type !='' && $report->efiling_type=='IA') {
                                    $rd='IA.DefaultController'; //. equal to / required
                                    $v='/'.$report->registration_id . '/' . $report->ref_m_efiled_type_id . '/' . $report->stage_id;
                                }
                                else if($report->efiling_type !='' && $report->efiling_type=='CAVEAT') {
                                    $rd='case.caveat.crud'; //. equal to / required
                                    $v='/'.$report->registration_id . '/' . $report->ref_m_efiled_type_id . '/' . $report->stage_id;
                                }
                                /*$redirect_url = "<//?=base_url('report/search/view/')?>".$rd.$v;
                                $efiling_no= '<a href="'.$redirect_url.'">'. $report->efiling_no . '</a> <br>'.$report->filed_on.'';*/

                                $str_efiling_type=$report->efiling_type;
                                $efiling_type=str_replace("_"," ",$str_efiling_type);
                                 $filed_by='';

                                if($report->ref_m_usertype_id==1){$filed_by=$report->first_name . '<br>(AOR Code: '. $report->aor_code . ')';}else if($report->ref_m_usertype_id==2){$filed_by=$report->first_name . '<br>(Party in person)';}

                                $allocated_to='';

                                //if($report->allocated_to_user!='' && $report->allocated_to_user!=null && $report->meant_for!='C' ){allocated_to=$report->allocated_to_user + '<br>(Emp Id: '+ $report->emp_id + ')';}
                                if($report->allocated_to_user!='' && $report->allocated_to_user!=null && $report->meant_for!='C' ){$allocated_to=$report->allocated_to_user ;}
                                // $date = $report->activated_on;
                                $date=!empty($report->activated_on) && ($report->activated_on !=null) ? date('d-m-Y h:i:s A', strtotime($report->activated_on)) : '';

                                $redirect_url = base_url('report/search/view/').$rd.$v;
                                $date_filed_on="";
                                if($report->filed_on==null){

                                }
                                else{
                                    $date_filed_on = $report->filed_on;
                                    $date_filed_on=!empty($date_filed_on) && ($date_filed_on !=null) ? date('d-m-Y h:i:s A', strtotime($date_filed_on)) : '';
                                }


                                //$filed_on = $.datepicker.formatDate("dd/mm/yy hh:ii", $.datepicker.parseDate('yy-mm-dd', $report->filed_on));
                                $efiling_no= '<a href="'.$redirect_url.'">'. $report->efiling_no . '</a> <br>'.$date_filed_on;
                                //$peding_since=$report->pending_since; // server days count with function
                                $peding_since=get_count_days_FromDate_Todate($report->activated_on,date('Y-m-d')); //php function is working perfect
                                if($peding_since>2){
                                    $peding_since="<span style='color: red;'><b>".$peding_since."</b></span>";
                                }
                                ?>
                            <tr>
                                <td width="4%" class="sorting_1" tabindex="0"><?php echo $i++; ?> </td>
                                <td ><?php echo $efiling_no; ?> </td>
                                <td ><?php echo $efiling_type; ?> </td>
                                <td ><?php echo $case_no; ?> </td>
                                <td ><?php echo $cause_details; ?> </td>
                                <td ><?php echo $filed_by; ?> </td>
                                <td ><?php echo $report->admin_stage_name; ?> </td>
                                <td ><?php echo $date; ?> </td>
                                <td ><?php echo $allocated_to; ?> </td>
                                <td ><?php echo $peding_since; ?> </td>
                                <td ><?php echo $report->meant_for; ?> </td>
                                <td ><?php echo $report->portal; ?> </td>
                            </tr>
                               <?php } ?>
                           </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>
        <!------------Table--------------------->

</div>
</div>


<!-- Case Status modal-start-->
<link rel="stylesheet" href="<?= base_url() ?>assets/responsive_variant/templates/uikit_scutum_2/assets/css/main.min.css" />
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/responsive_variant/frameworks/uikit_3-4-1/css/uikit.min.css" />
<link rel="stylesheet" href="<?= base_url() ?>assets/responsive_variant/templates/uikit_scutum_2/assets/css/fonts/mdi_fonts.css" />
<link rel="stylesheet" href="<?= base_url() ?>assets/responsive_variant/templates/uikit_scutum_2/assets/css/materialdesignicons.min.css" />

<?php
$this->load->view('case_status/case_status_view');
?>
<script src="<?= base_url() ?>assets/responsive_variant/frameworks/uikit_3-4-1/js/uikit.min.js"></script>
<script src="<?= base_url() ?>assets/responsive_variant/frameworks/uikit_3-4-1/js/uikit-icons.min.js"></script>
<!-- Case Status modal-end-->


<script src="<?= base_url() . 'assets' ?>/vendors/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url() . 'assets' ?>/js/jquery.min.js"></script>
<script src="<?= base_url() . 'assets' ?>/js/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery-ui.css">
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url() ?>assets/js/sha256.js"></script>
<script src="<?= base_url() ?>assets/js/daterangepicker/daterangepicker.min.js"></script>
<script src="<?= base_url() ?>assets/js/daterangepicker/moment.min.js"></script>
<script src="<?= base_url() ?>assets/js/daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/css/daterangepicker/daterangepicker.css">


<script>
    $(document).ready(function() {
        $('#datatable-responsive').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'pdf',
                title: 'Report List',
                filename: 'Report_pdf_file_name',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            }, {
                extend: 'excel',
                title: 'Report List',
                filename: 'Report_excel_file_name'
            }, {
                extend: 'csv',
                filename: 'Report_csv_file_name'
            }, {
                extend: 'print',
                title: 'Report List',
                filename: 'Report_print_file_name'
            }]

        });
    });
</script>
<script>

   function open_case_status(){

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        var diary_no = $("a:focus").attr('data-diary_no');
        var diary_year = $("a:focus").attr('data-diary_year');
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE,diary_no:diary_no, diary_year:diary_year},
            beforeSend: function (xhr) {
                $("#view_case_status_data").html("<div style='margin:0 auto;margin-top:20px;width:100%;text-align: center;'><img src='<?=base_url()?>/assets/images/loading-data1.gif'></div>");
            },
            url: "<?php echo base_url('report/search/showCaseStatusReport'); ?>",
            success: function (data) {
                document.getElementById('view_case_status_data').innerHTML=data;
                $.getJSON("<?php echo base_url() . 'csrftoken'; ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function (result) {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
        UIkit.modal('#case_status').toggle();
   }
</script>
<style>
    th{font-size: 13px;color: #000;}
    td{font-size: 13px;color: #000;}
    td .sci{font-size: 13px;color: #000;}

    div.box {
        height: 109px;
        /* padding: 10px; */
        /*overflow: auto;*/
        border: 1px solid #8080FF;
        /*background-color: #E5E5FF;*/
    }
</style>

