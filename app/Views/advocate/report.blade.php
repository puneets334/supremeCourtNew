@extends('layout.app')
@section('content')


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="shortcut icon" href="<?= base_url() . 'assets/newAdmin/' ?>images/favicon.gif">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/font-awesome.min.css" rel="stylesheet">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/animate.css" rel="stylesheet">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/material.css" rel="stylesheet" />
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/style.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= base_url() . 'assets/newAdmin/' ?>css/jquery.dataTables.min.css">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/fullcalendar.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery-ui.css">
<link href="<?= base_url() . 'assets' ?>/css/select2.min.css" rel="stylesheet">
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
                                    <h5 class="unerline-title"> Advocates Appearing </h5>
                                </div>
                                <div class="page-title">
                                    <h5>Search</h5>
                                </div>

                                <div class="table-sec">
                                <div class='row '>
                                    <!-- Message -->
                                    @if (session('status'))
                                        <div class="col-12 alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>{{ session('status') }}</strong></div>
                                    @elseif(session('failed'))
                                        <div class="col-12 alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>{{ session('failed') }}</strong></div>
                                    @endif
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Search</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form class="form-horizontal" method="POST" action="<?php echo base_url('advocate/report'); ?>">
                                @csrf
                                <div class="card-body">
                                    <div class="row">


                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label">List Date (dd-mm-yyyy)</label>
                                                <div class="input-group date" id="cause_list_date" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input @error('cause_list_date') is-invalid @enderror" value="{{old('cause_list_date')}}" name="cause_list_date" data-target="#cause_list_date"/>
                                                    <div class="input-group-append" data-target="#cause_list_date" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                                    </div>
                                                    @error('cause_list_date')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" name="search" class="btn btn-primary">Search</button>

                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>
                        <!-- /.card -->

@if(isset($list))
                        <div class="row">

                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Advocates Appearing for List Date {{$cause_list_date}}</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover table-striped ">
                                                <thead>
                                                <tr>
                                                    <th>SNo.</th>
                                                    <th>Listed On</th>
                                                    <th>Court No.</th>
                                                    <th>Item No.</th>
                                                    <th>Case No.</th>
                                                    <th>Cause Title</th>
                                                    <th>Name of Advocates</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                               
                                                </tbody>
                                            </table>

                                        </div>
                                        <!-- /.card-footer -->

                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>
@endif

                    </div>


                </div>
                                </div>




                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
   
    <script src="<?=base_url();?>assets/js/sweetalert2@11.js"></script>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/sweetalert2.min.css"> 
    <script>

  









    </script>

    @endpush
@endsection