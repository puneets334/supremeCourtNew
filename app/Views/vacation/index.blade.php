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
                                <div class="title-sec">
                                    <h5 class="unerline-title">Advance Summer Vacation List </h5>
                                    <!-- <a href="javascript:void(0)" class="quick-btn pull-right" onclick="window.history.back()"><span class="mdi mdi-chevron-double-left"></span>Back</a> -->
                                    <a href="<?php echo isset($_SERVER['HTTP_REFERER']); ?>" class="quick-btn pull-right"><span class="mdi mdi-chevron-double-left"></span>Back</a>
                                </div>

                                {{-- Main Start --}}
                                <div class="dash-card dashboard-section tabs-section">
                                    <div class="tabs-sec-inner">
                                        <!-- form--start  -->
                                        <form action="">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">

                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                                                        data-bs-target="#profile" type="button" role="tab"
                                                        aria-controls="profile" aria-selected="false">Advance Summer
                                                        Vacation List (All Matters) - For Conent</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="messages-tab" data-bs-toggle="tab"
                                                        data-bs-target="#messages" type="button" role="tab"
                                                        aria-controls="messages" aria-selected="false">Advance Summer
                                                        Vacation List (Declined Matters)</button>
                                                </li>
                                            </ul>

                                            <div class="tab-content">
                                                <div class="tab-pane active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                    <div class="tab-form-inner">
                                                        <div class="row">
                                                            <div class="col-12 col-md-8 col-lg-9">
                                                                <h6 class="text-center"> Advance Summer Vacation List @php echo date("Y") @endphp</h6>
                                                            </div>
                                                            <div class="col-12 col-md-4 col-lg-3">
                                                                <button id="declineButton" type="button" class="btn btn-primary btn-success text-center pull-right" onclick="javascript:confirmBeforeDecline();"><strong>Decline Selected Case(s)</strong></button>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="table-sec">
                                                                <div class="table-responsive">
                                                                    <table class="table table-striped custom-table text-left" id="datatable-responsive">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Case Details</th>
                                                                                <th>Cause Title</th>
                                                                                <th>Advocate</th>
                                                                                <th>Decline/Listed</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @if (isset($vacation_advance_list) && is_array($vacation_advance_list) && count($vacation_advance_list) > 0)
                                                                                @foreach ($vacation_advance_list as $k => $r)
                                                                                    @php
                                                                                        $psrno = $print_brdslno = $print_srno ='';
                                                                                        if (  $r->diary_no == $r->conn_key or $r->conn_key == 0  ) {
                                                                                            // $print_brdslno = $row['brd_slno'];
                                                                                            $print_brdslno = $psrno;
                                                                                            $print_srno = $psrno;
                                                                                            $con_no = '0';
                                                                                            $is_connected = '';
                                                                                        } elseif ( $r->main_or_connected == 1  ) {
                                                                                            $print_brdslno =
                                                                                                '&nbsp;' .
                                                                                                $print_srno .
                                                                                                '.' .
                                                                                                ++$con_no;
                                                                                            $is_connected =
                                                                                                "<span style='color:red;'>Connected</span><br/>";
                                                                                        }
                                                                                        if ($is_connected != '') {
                                                                                        } else {
                                                                                            $print_srno = $print_srno;
                                                                                            $psrno++;
                                                                                        }
                                                                                    @endphp
                                                                                    <tr style="line-height: 100px;">
                                                                                        <td data-key="#">{{ $k + 1 }}</td>
                                                                                        <td data-key="Case Details">{{ isset($r->case_no) ? $r->case_no : '' }}

                                                                                            <br>
                                                                                            <?php if ($r->main_or_connected == 1) {
                                                                                                echo "<span style='color:red;'>Connected</span><br/>";
                                                                                            }
                                                                                            ?>
                                                                                        </td>
                                                                                        <td data-key="Cause Title">{{ isset($r->cause_title) ? $r->cause_title : '' }}
                                                                                        </td>

                                                                                        <td data-key="Advocate"><?php echo $r->advocate; ?> </td>
                                                                                        <td data-key="Decline/Listed" style="text-align: center">
                                                                                            <?php
                                                                                                if (!empty($r->declined_by_aor) && $r->declined_by_aor === 't') { $diary_no=$r->diary_no;
                                                                                                    echo "<a class='btn btn-sm quick-btn text-center'   title=\"List\"  onclick=\"javascript:confirmBeforeList($diary_no);\">Restore</a><br/>";

                                                                                                    ?>
                                                                                                                                <span
                                                                                                                                    style="color: red; text-align:center; display:block; margin-top:5px;font-weight:bold;">Declined</span>
                                                                                                                                <?php
                                                                                                } else {
                                                                                                    if($r->is_fixed!='Y') {
                                                                                                        echo "<input type='checkbox' class='vacationList' name='vacationList' id='vacationList' value='".$r->diary_no. "'>";
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        echo "<span style='color:green;'>Fixed For <br> Vacation</span><br/>";
                                                                                                    }

                                                                                                }

                                                                                            ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @else
                                                                                <tr>
                                                                                    <td colspan="5"><span
                                                                                            class="text-center text-danger fw-bold">No
                                                                                            Records Found</span></td>
                                                                                </tr>
                                                                            @endif
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="messages" role="tabpanel"
                                                    aria-labelledby="messages-tab">
                                                    <div class="row">
                                                        <h6 class="text-center"> List of Matters Declined By Self
                                                            @php echo date("Y") @endphp</h6>
                                                    </div>
                                                    <div class="row">
                                                        <div class="table-sec">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped custom-table"
                                                                    id="datatable-decline">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Case No @ Diary No.</th>
                                                                            <th>Cause Title</th>
                                                                            <th>Advocate</th>
                                                                            <th>Decline/Listed</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @if (isset($matters_declined_by_counter) &&
                                                                                is_array($matters_declined_by_counter) &&
                                                                                count($matters_declined_by_counter) > 0)
                                                                            @foreach ($matters_declined_by_counter as $k => $decline)
                                                                                <tr>
                                                                                    <td data-key="#">{{ $k + 1 }}</td>
                                                                                    <td data-key="Case No @ Diary No.">{{ isset($decline->diary_no) ? $decline->diary_no : '' }}
                                                                                    </td>
                                                                                    <td data-key="Cause Title">{{ isset($decline->cause_title) ? $decline->cause_title : '' }}
                                                                                    </td>

                                                                                    <td data-key="Advocate">{{ isset($decline->decline_by_advocate) ? $decline->decline_by_advocate : '' }}
                                                                                    </td>

                                                                                    <td data-key="Decline/Listed">{{ isset($decline->aor_code) ? $decline->aor_code : '' }}
                                                                                    </td>

                                                                                </tr>
                                                                            @endforeach
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </form>
                                    </div>
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
            $('#datatable-decline').DataTable();
            $('#datatable-responsive').DataTable();
        });
    </script>

    <script>
        function confirmBeforeDecline() {

            var allVals = [];
            var noOfCases;
            $("input:checkbox[name=vacationList]:checked").each(function() {
                allVals.push($(this).val());
            });
            console.log(allVals);
            noOfCases = allVals.length;
            if (noOfCases < 1) {
                alert('Please select atleast one Case which need to be Decline');
                return false;
            } else {

                var choice = confirm(
                    "I hereby agree with the Notice dated..... and matter so declined are after serving a copy there of on other side for Not Listing the matter before Vacation Bench during the Summer Vacation, <?= $current_year = date('Y') ?> \n\n Do you really want to decline the case.....?"
                );
                if (choice === true) {
                    declineVacationCase(allVals);
                } else
                    return false;

            }
        }

        function confirmBeforeList(diary_no) {
            var choice = confirm('Do you really want to List the Selected Case.....?');
            if (choice === true) {
                ListVacationCase(diary_no);
            }

        }

        function declineVacationCase(allVals) {
            var userIP = $('#fromIP').val();
            // var userID=$('#user_mid').val();
            var userID = '<?php echo getSessionData('login')['id']; ?>';


            var aorCode = $('#aorCode').val();

            //alert(userIP);
            //alert(userID);
            //alert(aorCode);
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $('#msg').hide();
            $(".form-response").html('');
            $.ajax({
                url: "<?= base_url('vacation/advance/declineVacationListCasesAOR') ?>",
                type: "POST",
                data: {
                    diary_no: allVals,
                    userIP: userIP,
                    userID: userID,
                    aorCode: aorCode,
                    CSRF_TOKEN: CSRF_TOKEN_VALUE
                },
                cache: false,
                success: function(data) {
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });

                    var resArr = data.split('@@@');
                    if (resArr[0] == 1) {
                        alert(resArr[1]);
                        $('#msg').show();
                        $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " +
                            resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                    } else if (resArr[0] == 2) {
                        alert('Selected Case with Diary No:(' + allVals + ') Successfully Declined');
                        location.reload();
                    }



                    //getVacationAdvanceListAOR();

                },
                error: function() {
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                    alert('Selected Case with Diary No:(' + allVals + ') Successfully Declined');
                }
            });
        }

        function ListVacationCase(diary_no) {
            var userIP = $('#fromIP').val();
            var userID = $('#user_mid').val();
            var aorCode = $('#aorCode').val();


            userIP = $('#fromIP').val();
            // var userID=$('#user_mid').val();
            var userID = '<?php echo getSessionData('login')['id']; ?>';



            aorCode = $('#aorCode').val();
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $('#msg').hide();
            $(".form-response").html('');
            $.ajax({
                url: "<?= base_url('vacation/advance/restoreVacationAdvanceListAOR') ?>",
                type: "POST",
                data: {
                    diary_no: diary_no,
                    userIP: userIP,
                    userID: userID,
                    aorCode: aorCode,
                    CSRF_TOKEN: CSRF_TOKEN_VALUE
                },
                cache: false,
                success: function(data) {
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });

                    var resArr = data.split('@@@');
                    if (resArr[0] == 1) {
                        alert(resArr[1]);
                        $('#msg').show();
                        $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " +
                            resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                    } else if (resArr[0] == 2) {
                        alert('Selected Case with Diary NO:' + diary_no + ' Successfully Restore');
                        location.reload();
                    }


                    //getVacationAdvanceListAOR();

                },
                error: function() {
                    alert('ERROR');
                }
            });
        }
    </script>
@endpush
