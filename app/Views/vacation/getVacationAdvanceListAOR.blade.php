@extends('layout.app')
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
                                    <h5 class="unerline-title">File A Document </h5>
                                </div>
                                {{-- Page Title End --}}

                                {{-- Main Start --}}

                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                                        <div class="radio-btns-inp mb-3">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cus-form-check" type="radio" checked
                                                    name="search_filing_type" value="diary" id="search_filing_type"
                                                    checked>
                                                <label class="form-check-label" for="Registration No"> Diary Number </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cus-form-check" type="radio"
                                                    name="search_filing_type" id="search_filing_type" value="register">
                                                <label class="form-check-label" for="Diary Number"> </span>Registration
                                                    No</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="diarySec">
                                    <div class="row" >

                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="row">
                                                <div class="row w-100 align-items-center">                                                   
                                                    <div class="col-5">
                                                        <label for="inputPassword6" class="col-form-label">Diary No</label>
                                                    </div>
                                                    <div class="col-7 pe-0">
                                                        <input class="form-control cus-form-ctrl" id="diary_no" name="diary_no"
                                                    maxlength="10" placeholder="Diary No."
                                                    onkeyup="this.value=this.value.replace(/[^0-9]/g,'');"
                                                    placeholder="Diary No" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="row">
                                                <div class="row w-100 align-items-center">                                                   
                                                    <div class="col-5">
                                                        <label for="inputPassword6" class="col-form-label"> Diary Year</label>
                                                    </div>
                                                    <div class="col-7 pe-0">
                                                        <select class="form-select cus-form-ctrl" aria-label="Default select example"
                                                    id="diary_year" name="diary_year" style="width: 100%">
                                                    <?php
                                                    $end_year = 48;
                                                    for ($i = 0; $i <= $end_year; $i++) {
                                                        $year = (int) date('Y') - $i;
                                                        $sel = $year == ((int) date('Y')) ? 'selected=selected' : '';
                                                        echo '<option ' . $sel . ' value=' . $year . '>' . $year . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="save-form-details">
                                                <div class="save-btns">                                                  
                                                    <button class="quick-btn gray-btn">Search</button>
                                                </div>
                                            </div>
                                        </div>   
                                        
                                    </div>
                                </div>

                                <div id="RegSec">

                                    <div class="row">

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="row">
                                                <div class="row w-100 align-items-center">                                                   
                                                    <div class="col-5">
                                                        <label for="inputPassword6" class="col-form-label">Case Type</label>
                                                    </div>
                                                    <div class="col-7 pe-0">
                                                        <select class="form-select cus-form-ctrl" aria-label="Default select example"
                                                    id="diary_year" name="diary_year" style="width: 100%">
                                                    <?php
                                                    $end_year = 48;
                                                    for ($i = 0; $i <= $end_year; $i++) {
                                                        $year = (int) date('Y') - $i;
                                                        $sel = $year == ((int) date('Y')) ? 'selected=selected' : '';
                                                        echo '<option ' . $sel . ' value=' . $year . '>' . $year . '</option>';
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
                                                    <div class="col-5">
                                                        <label for="inputPassword6" class="col-form-label">Case No</label>
                                                    </div>
                                                    <div class="col-7 pe-0">
                                                        <input class="form-control cus-form-ctrl" id="diary_no" name="diary_no"
                                                        maxlength="10" placeholder="Diary No."
                                                        onkeyup="this.value=this.value.replace(/[^0-9]/g,'');"
                                                        placeholder="Diary No" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="row">
                                                <div class="row w-100 align-items-center">                                                   
                                                    <div class="col-5">
                                                        <label for="inputPassword6" class="col-form-label">Case Year</label>
                                                    </div>
                                                    <div class="col-7 pe-0">
                                                        <select class="form-select cus-form-ctrl" aria-label="Default select example"
                                                        id="diary_year" name="diary_year" style="width: 100%">
                                                        <?php
                                                        $end_year = 48;
                                                        for ($i = 0; $i <= $end_year; $i++) {
                                                            $year = (int) date('Y') - $i;
                                                            $sel = $year == ((int) date('Y')) ? 'selected=selected' : '';
                                                            echo '<option ' . $sel . ' value=' . $year . '>' . $year . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="save-form-details">
                                                <div class="save-btns">                                                  
                                                    <button class="quick-btn gray-btn">Search</button>
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </div>
                                  
                                </div>

                                <div class="row">
                                    <div id="show_search_result_diary"></div>                   
                                </div>
                                <div class="row">
                                    <div id="show_search_result"></div>               
                                </div>
                                {{-- Main End --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')


<script>
    $(document).ready(function() {

       var inputValue= $('input[type="radio"]:checked').val();
       if (inputValue == 'register') {
            $('#diaryno').val('');
            $('#diary_year').val('');

            $("#show_search_result_diary").css("display", "none");
            $("#show_search_result").css("display", "block");
            $("#diarySec").css("display", "none");
            $("#RegSec").css("display", "block");
        } else if (inputValue == 'diary') {
            $('#sc_case_type').val('');
            $('#case_number').val('');
            $('#case_year').val('');
            $("#show_search_result").css("display", "none");
            $("#show_search_result_diary").css("display", "block");
            $("#RegSec").css("display", "none");
            $("#diarySec").css("display", "block");
        }
        var targetBox = $("." + inputValue);
        $(".box").not(targetBox).hide();
        $(targetBox).show();
    })

    $('input[type="radio"]').click(function () {
        var inputValue = $(this).attr("value");
        if (inputValue == 'register') {
            $('#diaryno').val('');
            $('#diary_year').val('');

            $("#show_search_result_diary").css("display", "none");
            $("#show_search_result").css("display", "block");
            $("#diarySec").css("display", "none");
            $("#RegSec").css("display", "block");
        } else if (inputValue == 'diary') {
            $('#sc_case_type').val('');
            $('#case_number').val('');
            $('#case_year').val('');
            $("#show_search_result").css("display", "none");
            $("#show_search_result_diary").css("display", "block");
            $("#RegSec").css("display", "none");
            $("#diarySec").css("display", "block");
        }
        var targetBox = $("." + inputValue);
        $(".box").not(targetBox).hide();
        $(targetBox).show();
    });
</script>
<style>
    .box{
        display: none;
        background-color: none;
    }
    div.box {
        height: 60px;
        padding: 0;
        overflow: unset;
        border:  #fff;
        background-color: #fff;
    }
</style>
<script type="text/javascript">

    $(document).ready(function () {
        $('#search_case_details').on('submit', function () {
            if ($('#search_case_details').valid()) {
                var form_data = $(this).serialize();
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                $('#show_search_result_diary').html('');
                $('#show_search_result').html('');
                $(".form-response").html('');
                $(".form-response").hide();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('case/search/search_case_details'); ?>",
                    data: form_data,
                    async: false,
                    beforeSend: function () {
                        $('#search_sc_case').val('Please wait...');
                        $('#search_sc_case').prop('disabled', true);
                    },
                    success: function (data) {
                        $('#search_sc_case').val('SEARCH');
                        $('#search_sc_case').prop('disabled', false);
                        var resArr = data.split('@@@');
                        if (resArr[0] == 1) {
                            $('#show_search_result_diary').html(resArr[1]);
                        } else if (resArr[0] == 2) {
                            $('#show_search_result').html(resArr[1]);
                        } else if (resArr[0] == 3) {
                            $(".form-response").show();
                            $('#msg').show();
                            $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                        }
                        $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                            $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                        });
                    }
                });
                return false;
            } else {
                return false;
            }
        });
    });


</script> 
@endpush
