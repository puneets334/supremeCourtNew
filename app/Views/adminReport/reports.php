<div class="right_col" role="main">
    <div id="loader_div"></div>
    <div class="row" id="printData">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-md-3 col-sm-3 col-xs-3">
                                                <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                <div class="form-group">
                                                    <label>Select Dates</label>
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
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                    <div class="form-group">
                                                        <button type="button" name="getResult" id="getResult" class="btn btn-primary"> Get Reports</button>
                                                    </div>
                                                </div>
                                </div>
                                <div id="result"></div>
                            </div>
                </div>
            </div>
        </div>

    </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <input style="display: none"  id="printButton" type="button" onclick="PrintDiv();" value="Print" />
                    <div class="panel-body" id="tableData" style="display: none; overflow: scroll;">
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
            maxDate: new Date,
            defaultDate: '-6d'
        });
        $('#to_date').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy",
            maxDate: new Date
        });
        var d = new Date();
        d.setDate(d.getDate()-6);
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
    $(document).on('click','#getResult',function(){
        var from_date = $("#from_date").val();
        var to_date = $("#to_date").val();
        var validationError = true;
        if(from_date == ''){
            alert("Please select from date.")
            $("#from_date").focus();
            validationError = false;
            return fasle;
        }
        else  if(to_date == ''){
            alert("Please select to date.")
            $("#to_date").focus();
            validationError = false;
            return fasle;
        }
        if(validationError){
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            var postData = {CSRF_TOKEN: CSRF_TOKEN_VALUE, from_date: from_date,to_date:to_date};
            $.ajax({
                type: "POST",
                data: JSON.stringify(postData),
                url: "<?php echo base_url('adminReport/DefaultController/getReportData'); ?>",
                dataType:'json',
                ContentType: 'application/json',
                cache:false,
                async:false,
                beforeSend: function() {
                    $("#loader_div").html('<img id="loader_img" style="position: fixed; left: 63%;margin-top: 130px;  margin-left: -100px;z-index: 99999;opacity: 1;" src="<?php echo base_url('assets/images/loading-data.gif');?>">');
                    $('#getResult').append('<i class="status_refresh fa fa-refresh fa-spin"></i>');
                },
                success: function (res){
                    if(typeof res == 'string'){
                        res = JSON.parse(res);
                    }
                    if(res.status == 'error'){
                        $("#tableData").show();
                        $("#"+res.id).focus();
                        $("#error_"+res.id).html('');
                        $("#error_"+res.id).html(res.msg);
                        $("#error_"+res.id).css({"color":"red"});
                        return false;
                    }
                   else if(res.status == 'success'){
                        $("#tableData").show();
                        $("#loader_div").html('');
                        $('#getResult').html('Get Reports');
                        $("#"+res.id).html('');
                        $("#"+res.id).html(res.msg);
                        $("#"+res.id).css({"color":"red"});
                        $("#"+res.id).css({"text-align":"center"});
                        $("#tableData").html(res.table);
                        $("#printButton").show();
                        return false;
                    }
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                },
                error: function () {
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                }
            });
        }
    });
    });



    $(document).ready(function() {
        $('#datatable-responsive').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'pdf',
                title: 'Admin Report List',
                filename: 'Report_pdf_file_name'
            }, {
                extend: 'excel',
                title: 'Admin Report List',
                filename: 'Report_excel_file_name'
            }, {
                extend: 'csv',
                title: 'Admin Report List',
                filename: 'Report_csv_file_name'
            }, {
                extend: 'print',
                title: 'Admin Report List',
                filename: 'Report_print_file_name'
            }]

        });
    });
        function PrintDiv() {
            var divContents = document.getElementById("tableData").innerHTML;
            var printWindow = window.open('', '', 'height=1000,width=1200');
            printWindow.document.write('<html><body >');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }


</script>

