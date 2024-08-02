<div class="right_col" role="main">

    <div class="row" id="printData">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <div class="panel-body">

                            <div class="row">
                                <?php
                                $attributes = array("class" => "form-horizontal", "id" => "getResult", "name" => "getResult", 'autocomplete' => 'off');
                                echo form_open('#', $attributes);
                                ?>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <label>Case Type <span style="color: red">*</span>:</label>
                                                    <div class="form-group">
                                                            <select  name="sc_case_type[]" id="sc_case_type" class="form-control input-sm filter_select_dropdown sc_case_type multiple"  required  multiple="multiple" data-placeholder="Select Case Type.">
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
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <label>From Date</label>
                                                    <div class="form-group">
                                                     <input type="text" name="from_date" id="from_date" class="form-control">
                                                        <span id="error_from_date"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <label>To Date</label>
                                                    <div class="form-group">
                                                        <input type="text" name="to_date" id="to_date" class="form-control">
                                                        <span id="error_to_date"></span>
                                                    </div>
                                                </div>

                                </div>
                                <center>
                                <div class="form-group">
                                    <button type="button" class="btn btn-success Download"> Download</button>
                                    <div id="loader_div" class="loader_div" style="display: none;"></div>
                                    </div>
                                    <center>
                                        <?php echo form_close(); ?>
                                <div id="result"></div>
                                        <?php echo $this->session->flashdata('msg');  ?>
                            </div>
                </div>
            </div>
        </div>

    </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <div class="panel-body">
                        <div class="row">
                            <div class="msg" id="form-response"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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


    $(document).on('click','.Download',function(){
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
        //alert('fromDate='+from_date+'fromDate='+to_date);
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
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

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

