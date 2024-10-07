<link rel="shortcut icon" href="<?= base_url() ?>assets/newAdmin/images/favicon.gif">
<link href="<?= base_url() ?>assets/newAdmin/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= base_url() ?>assets/newAdmin/css/font-awesome.min.css" rel="stylesheet">
<link href="<?= base_url() ?>assets/newAdmin/css/animate.css" rel="stylesheet">
<link href="<?= base_url() ?>assets/newAdmin/css/material.css" rel="stylesheet" />
<link href="<?= base_url() ?>assets/newAdmin/css/style.css" rel="stylesheet">
<link href="<?= base_url() ?>assets/newAdmin/css/responsive.css" rel="stylesheet">
<link href="<?= base_url() ?>assets/newAdmin/css/black-theme.css" rel="stylesheet">
<link href="<?= base_url() ?>assets/newAdmin/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="<?= base_url() ?>assets/newAdmin/css/fullcalendar.css" rel="stylesheet">
<link href="<?= base_url() ?>assets/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?= base_url() ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="<?= base_url() ?>assets/css/jquery-ui.css" rel="stylesheet">
<link href="<?= base_url() ?>assets/css/select2.min.css" rel="stylesheet">
    <style>
        /* .dataTables_wrapper {
            margin-top: .5rem !important;
        }
        div .dataTables_wrapper ~ .dataTables_info {
            display: none !important;
        }
        .title-sec {
            display: none !important;
        }
        .mngmntHeader {
            display: none !important;
        } */
        .dataTables_wrapper {
            margin-top: .5rem !important;
        }
        /* div .dataTables_wrapper ~ .dataTables_info, .dataTables_length, .dataTables_filter {
            display: none !important;
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
                                {{-- Page Title Start --}}
                                <!-- <div class="title-sec">
                                    <h5 class="unerline-title"> Physical Hearing reports </h5>
                                </div> -->
                                {{-- Page Title End --}}
                                {{-- Main Start --}}
                                <?php if(is_array($list)) { ?>
                                    <div id="show_result" >
                                        <hr>
                                        <?php if(!empty($list)) { ?>
                                            <p class="table_heading"><u>Consent for Dated : <?= $date_of_hearing; ?>,  Total Entries : <?= $case_count; ?></u></p>
                                        <?php } ?>
                                        <table id="head" class="table table-striped custom-table" style="display: none !important;">
                                            <caption> </caption>
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Search by List Date</th>
                                                    <th>Search by Court No</th>
                                                    <th>Search by Item No</th>
                                                    <th>Search by Total cases</th>
                                                    <th>Search by Cases</th>
                                                    <th>Search by Consent</th>
                                                    <th>Search by Updated On</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table id="reportTable1" class="table table-striped custom-table">
                                            <thead>
                                                <tr>
                                                    <th style="width:2%;">#</th>
                                                    <th style="width:5%;" class="lead text-center">List Date</th>
                                                    <th style="width:5%;" class="lead text-center">Court No</th>
                                                    <th style="width:5%;" class="lead text-center">Item No</th>
                                                    <th style="width:10%;" class="lead text-center">Total Cases</th>
                                                    <th style="width:40%;" class="lead text-center">Consent given for Cases</th>
                                                    <th style="width:5%;" class="lead text-center">Mode of Hearing</th>
                                                    <th style="width:5%;" class="lead text-center">Updated On</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($list) && !empty($list)) {
                                                    // pr($list);
                                                    $i = 1;
                                                    foreach($list as $value) {
                                                        // pr($value); ?>
                                                        <tr>
                                                            <td style="width:5%;"><?php echo $i; ?></td>
                                                            <td class="lead text-center" data-key="List Date"><?=  date("d-m-Y", strtotime($value['next_dt'])); ?> </td>
                                                            <td class="lead text-center" data-key="Court No"><?= $value['court_no']; ?> </td>
                                                            <td class="lead text-center" data-key="Item No"><?php isset($value['item_number']) ? $value['item_number'] : '' ;?></td>
                                                            <td class="lead text-center" data-key="Total Cases"><?= $value['case_count'] ;?></td>
                                                            <td class="lead text-center" data-key="Consent given for Cases"><?php isset($value['consent_for_cases']) ? $value['consent_for_cases'] : '' ;?></td>
                                                            <th class="lead text-center" data-key="Mode of Hearing"><?= $value['consent'] ;?></th>
                                                            <td class="lead text-center" data-key="Updated On"><?php echo date("d-m-Y h:i", strtotime($value['updated_on'])); ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    $i++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <br>
                                    </div><!--END OF DIV id="show_result"-->
                                    <?php
                                } else {
                                    echo "Data Not Found! ";
                                }
                                ?>
                                {{-- Main End --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function () {
        // $('#reportTable1').DataTable();
        // $('.menu-sec').eq(1).hide();
        // $('.dataTables_paginate').eq(1).hide();
        // $('#head thead tr').clone(true).prependTo('#reportTable1 thead');
        $('#reportTable1 thead tr:eq(0) th').each(function (i) {
            if (i != 0 && i != 8) {
                var title = $(this).text();
                var width = $(this).width();
                if (width > 200) {
                    width = width - 100;
                } else if (width < 100) {
                    width = width + 20;
                }
                // $(this).html('<input class="form-control cus-form-ctrl" type="text" style="width: ' + width + 'px" placeholder="' + title + '" />');
                $('input', this).on('keyup change', function () {
                    if (t.column(i).search() !== this.value) {
                        t
                        .column(i)
                        .search(this.value)
                        .draw();
                    }
                });
            }
        });
        var t = $('#reportTable1').DataTable({
            "order": [[1, 'asc']],
            // "ordering": false,
            // "lengthMenu": [5],
            // fixedHeader: true,
            // scrollX: true,
            // autoFill: true,
            // dom: 'Brtip',
            buttons: [{
                extend: 'print',
                exportOptions: {
                    // columns: ':visible',
                    columns: [0, 1, 2, 3, 4, 5, 6],
                    stripHtml: false
                }
            }]
        });
        t.on('order.dt search.dt', function () {
            t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
                t.cell(cell).invalidate('dom');
            });
        }).draw();
    });
</script>
<!-- form--end  -->
<script src="<?= base_url() ?>assets/newAdmin/js/jquery-3.3.1.min.js"></script>
<script src="<?= base_url() ?>assets/newAdmin/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>assets/newAdmin/js/general.js"></script>
<script src="<?= base_url() ?>assets/newAdmin/js/jquery-3.5.1.slim.min.js"></script>
<script src="<?= base_url() ?>assets/vendors/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery-ui.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url() ?>assets/js/sha256.js"></script>
<script src="<?= base_url() ?>assets/newAdmin/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/js/select2.min.js"></script>
<script src="<?= base_url() ?>assets/js/select2-tab-fix.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>