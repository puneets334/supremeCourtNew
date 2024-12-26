<script type="text/javascript" src="<?= base_url() ?>/assets/js/case_status/common.js"></script>
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/bootstrap.min.css" rel="stylesheet"> 
<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>

<!-- Case Status modal-start-->
<style>
    /* tr.hide-table-padding td {
        padding: 0;
    }

    .expand-button {
        position: relative;
    }

    .accordion-toggle .expand-button:after
    {
        position: absolute;
        left:.75rem;
        top: 50%;
        transform: translate(0, -50%);
        content: '-';
    }
    .accordion-toggle.collapsed .expand-button:after
    {
        content: '+';
    } */

</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="dashboard-section dashboard-tiles-area"></div>
            <div class="dashboard-section">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="dash-card">
                            <div id="case_status" uk-modal class="uk-modal-full">
                                <div class="uk-modal-dialog">
                                    <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
                                    <div class="uk-modal-header">
                                        <h2 class="uk-modal-title"><div id="case_status_diary">CASE STATUS</div></h2>
                                    </div>
                                    <div class="uk-modal-body">
                                        <div id="view_case_status_data"></div>
                                    </div>
                                    <div class="uk-modal-footer uk-text-right">
                                        <button class="uk-button uk-button-default uk-modal-close" type="button" >Cancel</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Case Status modal-end-->
                            <!-- Paper book modal-start-->
                            <div id="paper_book" class="uk-modal-full" uk-modal>
                                <div class="uk-modal-dialog">
                                    <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
                                    <div class="uk-modal-header">
                                        <h2 class="uk-modal-title"><div id="paper_book_diary">CASE - PAPER BOOK</div></h2>
                                    </div>
                                    <div class="uk-modal-body">
                                        <div id="view_paper_book_data"></div>
                                    </div>
                                    <div class="uk-modal-footer uk-text-right">
                                        <button class="uk-button uk-button-default uk-modal-close" type="button" >Cancel</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Paper Book modal-end-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click','[id^=accordion] a',function (event) {
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            var according_name=$(this).attr('data-parent');
            if(typeof $(this).attr('data-parent') !== "undefined"){
                var href = this.hash;
                var according_id = href.replace("#collapse","");
                var according_name1=according_name.replace("#accordion","");
                var according_nt=according_name1*100;
                var diaryno = document.getElementById('diaryno'+according_name1).value;
                if(according_id!=(according_name+1)){
                    $.ajax({
                        type: "POST",
                        data: {CSRF_TOKEN: CSRF_TOKEN_VALUE,diaryno:diaryno,according_id:according_id,according_nt:according_nt},
                        url: "<?php echo base_url('case_status/defaultController/get_case_status_other_tab_data'); ?>",
                        success: function (data) {
                            $("#result"+according_id).html(data);

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
                }
            }
        });

    });
    function open_case_status()
    {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        var diary_no = $("a:focus").attr('data-diary_no');
        var diary_year = $("a:focus").attr('data-diary_year');
        //alert(diary_no+'#'+diary_year);
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE,diary_no:diary_no, diary_year:diary_year},
            beforeSend: function (xhr) {
                $("#view_case_status_data").html("<div style='margin:0 auto;margin-top:20px;width:100%;text-align: center;'><img src='<?=base_url()?>/assets/images/loading-data1.gif'></div>");
            },
            url: "<?php echo base_url('case_status/defaultController/showCaseStatus'); ?>",
            success: function (data) {
                // $('#view_case_status_data').innerHTML=data;
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
    function CheckRequestCertificate(request_no)
    {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE,request_no:request_no},
            beforeSend: function (xhr) {
                $("#view_case_status_data").html("<div style='margin:0 auto;margin-top:20px;width:100%;text-align: center;'><img src='<?=base_url()?>/assets/images/loading-data1.gif'></div>");
            },
            url: "<?php echo base_url('case_status/defaultController/showCaseStatusCertificate'); ?>",
            success: function (data) {
                var resArr = data.split('@@@');
                if (resArr[0] == 1) {
                    alert(resArr[1]);
                    $('#msg').show();
                    $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                } else if (resArr[0] == 2) {

                }
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
       // UIkit.modal('#case_status').toggle();
    }
    function open_paper_book()
    {
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
            url: "<?php echo base_url('case_status/defaultController/showPaperBook'); ?>",
            success: function (data) {
                // $('#view_case_status_data').innerHTML=data;
                document.getElementById('view_paper_book_data').innerHTML=data;
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
        UIkit.modal('#paper_book').toggle();
    }
</script>