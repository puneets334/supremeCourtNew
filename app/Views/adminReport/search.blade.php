@extends('layout.advocateApp')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="dashboard-section dashboard-tiles-area"></div>
            <div class="dashboard-section">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="dash-card">
                            {{-- Page Title Start --}}
                            <div class="title-sec">
                                <h5 class="unerline-title"> Download Efiled Cases </h5>
                            </div>
                            {{-- Page Title End --}}
                            {{-- Main Start --}}
                            <div class="right_col" role="main">
                                <?php
                                $attributes = array("class" => "form-horizontal", "id" => "getResult", "name" => "getResult", 'autocomplete' => 'off');
                                echo form_open(base_url('adminReport/search/#'), $attributes);
                                ?>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="row" id="printData">
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="row">
                                                <div class="row w-100 align-items-center">
                                                    <div class="col-5">
                                                    <label class="col-form-label" for="sc_case_type">Case Type <span style="color: red">*</span>:</label>
                                                    </div>
                                                    <div class="col-7 pe-0">
                                                        <select name="sc_case_type[]" id="sc_case_type" class="form-control cus-form-ctrl" aria-label="Default select example" required multiple="multiple" data-placeholder="Select Case Type.">
                                                            <!--<option value="" title="Select">Select Case Type</option>-->
                                                            <?php
                                                            if (!empty($sc_case_type)) {
                                                                foreach ($sc_case_type as $dataRes) {
                                                                    //$sel = ($new_case_details[0]['sc_case_type_id'] == (string) $dataRes->casecode ) ? "selected=selected" : ''; echo $sel;
                                                                    ?>
                                                                    <option  value="<?php echo_data(trim($dataRes->casecode)); ?>"><?php echo_data($dataRes->casename); ?> </option>;
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="row">
                                                <div class="row w-100 align-items-center">
                                                    <div class="col-5"><label class="col-form-label" for="from_date">From Date</label></div>
                                                    <div class="col-7 pe-0">
                                                        <input type="text" name="from_date" id="from_date" class="form-control cus-form-ctrl">
                                                        <span id="error_from_date"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="row">
                                                <div class="row w-100 align-items-center">
                                                    <div class="col-5"><label class="col-form-label" for="to_date">To Date</label></div>
                                                    <div class="col-7 pe-0">
                                                        <input type="text" name="to_date" id="to_date" class="form-control cus-form-ctrl">
                                                        <span id="error_to_date"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="save-btns" style="text-align: center;">
                                        <button type="submit" class="quick-btn gray-btn"> Download</button>
                                        <div id="loader_div" class="loader_div" style="display: none;"></div>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        {{-- Main End --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
<script>
    $(document).ready(function(){
        $('#from_date').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy",
            maxDate: new Date
            //defaultDate: '-6d'
        });
        $('#to_date').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy",
            maxDate: new Date
        });
        var d = new Date();
        //d.setDate(d.getDate()-6);
        d.setDate(d.getDate());
        d= d.toLocaleString();
        if(d){
            d= d.split(',')[0];
            $("#from_date").val(d);
        }
        var newdate = new Date();
        newdate.setDate(newdate.getDate());
        newdate = newdate.toLocaleString();
        if(newdate){
            newdate = newdate.split(',')[0];
            $("#to_date").val(newdate);
        }
        // $(document).on('click','.Download',function(){
        $('#getResult').on('submit', function() {
            var validationError = true;
            var selected=[];
            var sc_case_type = $("#sc_case_type").val();
            selected=sc_case_type;
            //alert("selected="+selected.length);
            if (selected.length==0){
                alert("Please select case type.");
                $("#sc_case_type").focus();
                validationError = false;
                return false;
            }
            var from_date = $("#from_date").val();
            var to_date = $("#to_date").val();
            var date1 = new Date(from_date.split('/')[0], from_date.split('/')[1] - 1, from_date.split('/')[2]);
            var date2 = new Date(to_date.split('/')[0], to_date.split('/')[1] - 1, to_date.split('/')[2]);
            if (date1 > date2) {
                // $('#result_load').hide();
                alert("To Date must be greater than From date");
                $("#to_date").focus();
                validationError = false;
                return false;
            } else{
                if(from_date.length == 0){
                    alert("Please select from date.");
                    $("#from_date").focus();
                    validationError = false;
                    return false;
                }
                else  if(to_date.length == 0){
                    alert("Please select to date.");
                    $("#to_date").focus();
                    validationError = false;
                    return false;
                }
            }
            if(validationError){
                //alert("Ready to ZIP Archive created");//return false;
                $('.Download').hide();
                $('.loader_div').show();
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var CSRF_TOKEN_VALUE = $('[name="_token"]').val();
                // alert(CSRF_TOKEN_VALUE);
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('adminReport/Search/get_list_doc_fromDate_toDate'); ?>",
                    data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, from_date: from_date,to_date:to_date,sc_case_type:sc_case_type},
                    beforeSend: function() {
                        $("#loader_div").html("<table widht='100%' align='center'><tr><td><img src='<?php echo base_url('images/load.gif');?>'></td></tr></table>");
                    },
                    success: function (data) {
                        $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                            $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                        });
                        var resArr = data.split('@@@');
                        if (resArr[0] == 1) {
                            $('.msg').show();
                            $("#form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                            $('.loader_div').hide();
                            $('.Download').show();
                        } else if (resArr[0] == 200) {
                            setTimeout(function(){
                                /*$("#form-response").html("<p class='message valid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                                $('.msg').show();*/
                                /* $("<a>").prop({target: "_blank",href: "<//?php echo base_url('adminReport/search/download'); ?>"})[0].click();*/
                                /*var url = "<//?php echo base_url('adminReport/search/download'); ?>";  window.open(url, '_blank');*/
                                window.location.href = '<?php echo base_url('adminReport/search/download'); ?>';
                            }, 3000);
                        } else if (resArr[0] == 3) {
                            $('.msg').show();
                            $("#form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                            $('.loader_div').hide();
                            $('.Download').show();
                        } else if (resArr[0] == 4) {
                            $('.msg').show();
                            $("#form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                            $('.loader_div').hide();
                            $('.Download').show();
                        }
                        if (resArr[0] == 200) {
                            setTimeout(function () {
                                $("#form-response").html("<p class='message valid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                                $('.msg').show();
                            }, 13000);
                            setTimeout(function () {
                                $('.msg').hide();
                                $('.loader_div').hide();
                                $('.Download').show();
                            }, 23000);
                        }else{
                            setTimeout(function () {
                                $('.msg').hide();
                            }, 5000);
                        }
                        $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                            $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                        });
                    },
                    error: function (e) {
                        $(".Download").prop("disabled", false);
                    }
                });
            }
        });
    });
</script>