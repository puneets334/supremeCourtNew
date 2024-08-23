@extends('layout.advocateApp')
@section('content')



<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
                                    <h5 class="unerline-title">CAUSE LIST</h5>
                                </div>
                                <div class="table-sec">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table first-th-left dt-responsive nowrap" id="datatable-responsive">
                                    
                                            <thead>
                                                <tr>
                                                    <th>SNo.</th>
                                                    <th>Listed On</th>
                                                    <th>Court No.</th>
                                                    <th>Item No.</th>
                                                    <th>Case No.</th>
                                                    <th>Cause Title</th>
                                                    <th>For Appearance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $sno = 1;
                                                @endphp
                                                @foreach($list as $key => $advocate)

                                                    @if($advocate['pno'] == 2)
                                                        @php $pet_name = $advocate['pet_name']." AND ANR."; @endphp
                                                    @elseif($advocate['pno'] > 2)
                                                        @php $pet_name = $advocate['pet_name']." AND ORS."; @endphp
                                                    @else
                                                        @php $pet_name = $advocate['pet_name']; @endphp
                                                    @endif

                                                    @if($advocate['rno'] == 2)
                                                        @php $res_name = $advocate['res_name']." AND ANR."; @endphp
                                                    @elseif($advocate['rno'] > 2)
                                                        @php $res_name = $advocate['res_name']." AND ORS."; @endphp
                                                    @else
                                                        @php $res_name = $advocate['res_name']; @endphp
                                                    @endif

                                                <tr>
                                                    <td><?php  echo $sno; ?></td>
                                                    <td>{{ date('d-m-Y', strtotime($advocate['next_dt'])) }}</td>
                                                    <td>{{ $advocate['courtno'] }}</td>
                                                    <td>{{ $advocate['brd_slno'] }}</td>
                                                    <td>{{ $advocate['reg_no_display'] ? $advocate['diary_no']:'' }}</td>
                                                    <td> {{ $pet_name }}<br>
                                                        Vs.
                                                        <br>
                                                        {{ $res_name }}
                                                    </td>
                                                    <td>

                                                        @if($advocate['next_dt'] == config("constants.CURRENT_DATE") && date('H:i:s') > config("constants.APPEARANCE_ALLOW_TIME"))
                                                            <span data-courtno="{{$advocate['courtno']}}" data-toggle="modal" data-target="#modal-lg" class="badge badge-danger time_out_msg">{{config("constants.MSG_TIME_OUT")}}</span>
                                                        @else
                                                            <button data-toggle="modal" data-target="#modal-lg"
                                                                    type="button"
                                                                    data-diary_no="{{$advocate['diary_no']}}"
                                                                    data-next_dt="{{$advocate['next_dt']}}"
                                                                    data-appearing_for="{{$advocate['pet_res']}}"
                                                                    data-pet_name="{{$advocate['pet_name']}}"
                                                                    data-res_name="{{$advocate['res_name']}}"
                                                                    data-courtno="{{$advocate['courtno']}}"
                                                                    data-brd_slno="{{$advocate['brd_slno']}}"
                                                                    data-reg_no_display="{{$advocate['reg_no_display']}}"
                                                                    name="btn_click" class="btn_click btn btn-success">Click</button>


                                                                   


                                                        @endif
                                                    </td> 
                                                </tr>
                                                @endforeach
                                            </tbody>                                   
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content myModal_content">

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <script src="<?= base_url() . 'assets/newAdmin/' ?>js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url() . 'assets/newAdmin/' ?>js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() . 'assets/newAdmin/' ?>js/general.js"></script>
    <script src="<?= base_url() . 'assets/newAdmin/' ?>js/jquery-3.5.1.slim.min.js"></script>
    <script src="<?= base_url() . 'assets' ?>/vendors/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url() . 'assets' ?>/js/jquery.min.js"></script>
    <script src="<?= base_url() . 'assets' ?>/js/jquery-ui.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap-datepicker.min.js"></script>
    <script src="<?= base_url() ?>assets/js/sha256.js"></script>
    <script src="<?= base_url() ?>assets/newAdmin/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() . 'assets' ?>/js/select2.min.js"></script>
    <script src="<?= base_url() . 'assets' ?>/js/select2-tab-fix.min.js"></script>
    <script type="text/javascript" src="<?= base_url() . 'assets' ?>/js/jquery.validate.js"></script>    
    <script src="<?=base_url();?>assets/js/sweetalert.min.js"></script>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/sweetalert.css"> 
    <script>

        // var token = $("meta[name='csrf-token']").attr("content");
        // $(function() {
        //     $('.table-sortable tbody').sortable({
        //         handle: 'span'
        //     });
        // });
        // var Toast = Swal.mixin({
        //     toast: true,
        //     position: 'top-end',
        //     showConfirmButton: false,
        //     timer: 3000
        // });

        $(document).on("click", ".btn_click", function () {
           
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $(".myModal_content").html("");
            var diary_no = $(this).data('diary_no');
            var next_dt = $(this).data('next_dt');
            var appearing_for = $(this).data('appearing_for');
            var pet_name = $(this).data('pet_name');
            var res_name = $(this).data('res_name');
            var brd_slno = $(this).data('brd_slno');
            var courtno = $(this).data('courtno');
            var reg_no_display = $(this).data('reg_no_display');
          
            // $("#modal-lg").modal({backdrop: true});
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('advocate/modal_appearance'); ?>",
                data: {CSRF_TOKEN: CSRF_TOKEN_VALUE,diary_no: diary_no,next_dt: next_dt,appearing_for: appearing_for,pet_name: pet_name,res_name: res_name,brd_slno: brd_slno, courtno: courtno, reg_no_display:reg_no_display},
                success: function (data) {
                //    alert("Respose "+data);
                    $(".myModal_content").html(data);
                }
            });
        });



    </script>






@endsection