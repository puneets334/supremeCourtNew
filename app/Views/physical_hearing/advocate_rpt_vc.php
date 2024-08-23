<?php
$crnt_dt=date("d-m-Y");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="icon" href="<?=base_url('assets/sci_logo.png')?>" type="image/x-icon">
    <meta charset="UTF-8">
    <title>counsel Data List</title>
    <script src="<?=base_url()?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>assets/js/app.min.js"></script>
    <!--<script src="<?/*=base_url()*/?>assets/js/Reports.js"></script>-->
    <script src="<?=base_url()?>assets/jsAlert/dist/sweetalert.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/datatables/buttons.colVis.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/datatables/vfs_fonts.js"></script>
    <link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables/buttons.dataTables.min.css">
    <!--<script src="<?/*=base_url()*/?>assets/js/fontawesome.js"></script>-->
    <style>

        .table_heading{
            font-size: large;
            font-weight: bold;
            text-align: center;
            display: block;
            block; width: 100%;
            word-wrap: break-word;
            font-weight: bold;

        }
    </style>
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
                url: "<?=base_url()?>index.php/Advocate_listing/advocate_rpt_srch",
                beforeSend: function (xhr) {
                    $("#divConsentEntries").html("<div style='margin:0 auto;margin-top:20px;width:15%'><img src='<?=base_url()?>/assets/img/load.gif'></div>");
                },
                data:{CSRF_TOKEN: CSRF_TOKEN_VALUE , srch_date_data: date_chk },
            })
                .done(function (resultData) {
                    $("#divConsentEntries").html(resultData);
                })
                .fail(function () {
                    alert("ERROR, Please Contact Server Room");
                    $("#divConsentEntries").html();
                });


        }

    </script>
</head>
<body>
    <div id="show_result">
        <div class="col-sm-3" ></div>
       <div class="col-sm-3" >
            <label for="tdate">Listing Date:</label>&nbsp
            <input type="text" class="datepick" id="listing_dt" placeholder="DD-MM-YY" name="listing_dt" maxlength="10" value="<?= $crnt_dt ; ?>">
        </div>
        <div class="col-sm-3" >
            <button class="btn btn-primary" onclick="Get_result_function()">Get Data</button>
        </div>

        <section class="content col-sm-12">
            <div id="divConsentEntries" style="display: block">
            </div>
        </section>
    </div><!--END OF DIV id="show_result"-->
</body>
</html>

</body>
</html>
