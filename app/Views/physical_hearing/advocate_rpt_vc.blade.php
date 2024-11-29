<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.min.css">
<?php $crnt_dt = date("d-m-Y"); ?>
@extends('layout.advocateApp')
@section('content')
    <style>
        .table_heading {
            font-size: large;
            font-weight: bold;
            text-align: center;
            display: block;
            width: 100%;
            word-wrap: break-word;
            font-weight: bold;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <!-- <div class="dashboard-section dashboard-tiles-area"></div> -->
                <div class="dashboard-section">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="dash-card">
                                {{-- Page Title Start --}}
                                <div class="title-sec">
                                    <h5 class="unerline-title"> Physical Hearing Reports </h5>
                                    <!-- <a href="javascript:void(0)" class="quick-btn pull-right" onclick="window.history.back()"><span class="mdi mdi-chevron-double-left"></span>Back</a> -->
                                    <a href="<?php echo isset($_SERVER['HTTP_REFERER']); ?>" class="quick-btn pull-right"><span class="mdi mdi-chevron-double-left"></span>Back</a>
                                </div>
                                {{-- Page Title End --}}
                                {{-- Main Start --}}
                                <div id="show_result">
                                    <!-- <div id="search-listing" style="display: block;"> -->
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-3" >
                                            <label for="tdate">Listing Date:</label>&nbsp
                                            <input type="text" class="form-control cus-form-ctrl datepick" id="listing_dt" placeholder="DD-MM-YY" name="listing_dt" maxlength="10" value="<?= $crnt_dt ; ?>">
                                        </div>
                                        <div class="col-sm-3" >
                                            <button class="btn btn-primary mt-3 mb-3" onclick="Get_result_function()">Get Data</button>
                                        </div>
                                    <!-- </div> -->
                                    <section class="col-sm-12">
                                        <div id="divConsentEntries" style="display: block;"></div>
                                    </section>
                                </div>
                                <!--END OF DIV id="show_result"-->
                                {{-- Main End --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
    <script src="<?= base_url() ?>assets/newAdmin/js/jquery-3.3.1.min.js"></script>
    <!-- <script src="<?=base_url()?>assets/plugins/datepicker/bootstrap-datepicker.js"></script> -->   
    <script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(function () {
            $('.datepick').datepicker({
                format: 'dd-mm-yyyy',
                todayHighlight: true,
                autoclose:true
            });
        });
        function Get_result_function(){
            var date_chk=document.getElementById("listing_dt").value;
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $.ajax({
                type: 'POST',
                url: "<?=base_url('Advocate_listing/advocate_rpt_srch')?>",
                beforeSend: function (xhr) {
                    // $("#divConsentEntries").html("<div style='margin:0 auto;margin-top:20px;width:15%'><img src='<?=base_url()?>/assets/physical_hearing/load.gif'></div>");
                    $("#divConsentEntries").html('');
                },
                data:{CSRF_TOKEN: CSRF_TOKEN_VALUE , srch_date_data: date_chk },
            })
            .done(function (resultData) {
                $("#divConsentEntries").html(resultData);
                // $("#search-listing").hide();
                // $("#divConsentEntries").show();
            })
            .fail(function () {
                alert("ERROR, Please Contact Server Room");
                $("#divConsentEntries").html();
            });
        }
    </script>
    @endpush
@endsection