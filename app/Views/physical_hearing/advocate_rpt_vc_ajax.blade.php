<link rel="shortcut icon" href="<?= base_url().'assets/newDesign/images/logo.png' ?>" type="image/png" />
<link href="<?= base_url() ?>assets/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?= base_url() ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
<style>
    .dataTables_wrapper {
        margin-top: .5rem !important;
    }
    @media (max-width: 767px){
        table#reportTable1 td:nth-child(7) {min-height: 67px;}
        table#reportTable1 td:nth-child(6) {min-height: 82px;}
        table#reportTable1 td:nth-child(5) {min-height: 58px;}
        table#reportTable1 td:nth-child(3) {min-height: 45px;}
        table#reportTable1 td:nth-child(4) {min-height: 45px;}
    }
</style>
<!-- <div class="container-fluid"> -->
    <div class="row">
        <div class="col-lg-12">
            <!-- <div class="dashboard-section dashboard-tiles-area"></div> -->
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
                                    <table id="head" class="table table-striped custom-table dNone">
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
                                                $i = 1;
                                                foreach($list as $value) {
                                                    ?>
                                                    <tr>
                                                        <td data-key="#" style="width:5%;"><?php echo $i; ?></td>
                                                        <td data-key="List Date" class="lead text-center" ><?=  date("d-m-Y", strtotime($value['next_dt'])); ?> </td>
                                                        <td data-key="Court No" class="lead text-center" ><?= $value['court_no']; ?> </td>
                                                        <td data-key="Item No" class="lead text-center"><?php isset($value['item_number']) ? $value['item_number'] : '' ;?></td>
                                                        <td data-key="Total Cases" class="lead text-center"><?= $value['case_count'] ;?></td>
                                                        <td data-key="Consent given for Cases" class="lead text-center" ><?php isset($value['consent_for_cases']) ? $value['consent_for_cases'] : '' ;?></td>
                                                        <td data-key="Mode of Hearing" class="lead text-center"><?= $value['consent'] ;?></td>
                                                        <td data-key="Updated On" class="lead text-center" ><?php echo date("d-m-Y h:i", strtotime($value['updated_on'])); ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                $i++;
                                            } else {
                                                ?>
                                                <tr>
                                                    <td data-key="#" style="width:5%;"><?php echo '&nbsp;&nbsp&nbsp;&nbsp'; ?></td>
                                                    <td data-key="List Date" class="lead text-center" ><?php echo '&nbsp;&nbsp&nbsp;&nbsp'; ?></td>
                                                    <td data-key="Court No" class="lead text-center" ><?php echo '&nbsp;&nbsp&nbsp;&nbsp'; ?></td>
                                                    <td data-key="Item No" class="lead text-center" ><?php echo '&nbsp;&nbsp&nbsp;&nbsp'; ?></td>
                                                    <td data-key="Total Cases" class="lead text-center"><?php echo '&nbsp;&nbsp&nbsp;&nbsp'; ?></td>
                                                    <td data-key="Consent given for Cases" class="lead text-center" ><?php echo '&nbsp;&nbsp&nbsp;&nbsp'; ?></td>
                                                    <td data-key="Mode of Hearing" class="lead text-center" ><?php echo '&nbsp;&nbsp&nbsp;&nbsp'; ?></td>
                                                    <td data-key="Updated On" class="lead text-center" ><?php echo '&nbsp;&nbsp&nbsp;&nbsp'; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <br>
                                </div>
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
<!-- </div> -->
@push('script')
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
@endpush