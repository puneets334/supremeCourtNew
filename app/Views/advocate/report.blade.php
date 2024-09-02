@extends('layout.advocateApp')
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

<style>
    .dateSymbol {
        position: relative;float: right;top: -25px;right: 8px;
    }
</style>
<div class="mainPanel ">
    <div class="panelInner">
        <div class="middleContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 sm-12 col-md-12 col-lg-12 middleContent-left">
                            <div class="center-content-inner comn-innercontent">
                            <div class="dash-card dashboard-section">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class=" dashboard-bradcrumb">
                                            <div class="left-dash-breadcrumb">
                                                <div class="page-title">
                                                    
                                                    <h5><i class="fa fa-file"></i> Advocates Appearing</h5>
                                                </div>
                                                <div class="form-response" id="msg" role="alert" data-auto-dismiss="5000"></div>
                                            </div>
                                            <div class="ryt-dash-breadcrumb">
                                                <div class="btns-sec">

                                                    <a href="javascript:void(0)" class="quick-btn gray-btn" onclick="window.history.back()"><span class="mdi mdi-chevron-double-left"></span>Back</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 ">
                                        <div class="crnt-page-head">
                                            <div class="current-pg-title">
                                                <h6>Search </h6>
                                            </div>
                                            <div class="current-pg-actions"> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- tabs-section -start  -->
                            <div class="msg" id="msg">
                                <div style="text-align: center;">
                                    <?php
                                    if (!empty(getSessionData('MSG'))) {
                                        echo getSessionData('MSG');
                                    }
                                    if (!empty(getSessionData('msg'))) {
                                        echo getSessionData('msg');
                                    }
                                    ?>
                                    <br>
                                    
                                </div>
                            </div>

                            <div class="dash-card dashboard-section">
                                <div class="row">
                                    <div class="panel panel-default">
                                    <form class="form-horizontal" method="POST" action="<?php echo base_url('advocate/report'); ?>">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                       
                                       
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <div class="row">
                                                        <div class="row w-100 align-items-center">
                                                            <div class="col-5">
                                                                <label for="inputPassword6" class="col-form-label">List Date</label>
                                                            </div>
                                                            <div class="col-7 pe-0">
                                                            <input class="form-control cus-form-ctrl  has-feedback-left" id="cause_list_date"  name="cause_list_date" placeholder="List Date" type="text" required />
                                                             <span class="fa fa-calendar-o form-control-feedback left dateSymbol" aria-hidden="true" ></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <div class="save-form-details">
                                                        <div class="save-btns">
                                                            <button type="submit" class="quick-btn gray-btn" id="search_sc_case" value="SEARCH">Search</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  
                                        </form>
                                        @if(isset($list))
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Advocates Appearing for List Date {{$cause_list_date}}</h3>
                                                        </div>
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
                                                    </div>
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
    </div>
</div>
    @push('script')
    <script>

    $(document).ready(function() {
        // alert("SC");
        $('#cause_list_date').datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:-1",
        dateFormat: "dd/mm/yy",
        defaultDate: '-40y'
        });

        $(document).on('change','#cause_list_date', function(){
            var value = $('#cause_list_date').val();
            var parts = value.split("/");
            var day = parts[0] && parseInt(parts[0], 10);
            var month = parts[1] && parseInt(parts[1], 10);
            var year = parts[2] && parseInt(parts[2], 10);
            var str = day + '/' + month + '/' + year;
            var today = new Date(),
            dob = new Date(str),
            age = new Date(today - dob).getFullYear() - 1970;
            $('#pet_age').val(age);
        });     

    })
    </script>   
    <script src="<?=base_url();?>assets/js/sweetalert2@11.js"></script>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/sweetalert2.min.css"> 
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
    

    @endpush
@endsection