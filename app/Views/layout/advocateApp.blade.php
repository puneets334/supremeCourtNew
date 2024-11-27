<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SC</title>
	<link rel="shortcut icon" href="<?= base_url().'assets/newDesign/images/logo.png' ?>" type="image/png" />
    <!-- <link rel="shortcut icon" href="<?= base_url() . 'assets/newAdmin/' ?>images/favicon.gif"> -->
    <link href="<?= base_url() . 'assets/newAdmin/' ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() . 'assets/newAdmin/' ?>css/font-awesome.min.css" rel="stylesheet">
    <link href="<?= base_url() . 'assets/newAdmin/' ?>css/animate.css" rel="stylesheet">
    <link href="<?= base_url() . 'assets/newAdmin/' ?>css/material.css" rel="stylesheet" />
    <link href="<?= base_url() . 'assets/newAdmin/' ?>css/style.css" rel="stylesheet">
    <link href="<?= base_url() . 'assets/newAdmin/' ?>css/responsive.css" rel="stylesheet">
    <link href="<?= base_url() . 'assets/newAdmin/' ?>css/black-theme.css" rel="stylesheet">
    <link href="<?= base_url() . 'assets/newAdmin/' ?>css/fullcalendar.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.css"> -->
    <!-- https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.min.css">
    <!-- <link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery-ui.css"> --> 
    <link rel="stylesheet" type="text/css" href="<?= base_url() . 'assets/newAdmin/' ?>css/jquery.dataTables.min.css">
    @stack('style')
    <style>
		#loader-wrapper {
			display: flex;
			justify-content: center;
			align-items: center;
			z-index: 1000; /* Ensure it's on top of other content */
		}
	</style>
</head>
<body>
    <div id="loader-wrapper">
        <div id="loader"></div>
        <div id="loader-text">Loading ...</div>
    </div>
    <div class="wrapper">
        <!--header section-->
        @include('layout.header')
        <!--header sec   end-->
        <div class="content">
            <!-- Side Panel Starts -->
            @include('layout.sidebar')
            <!-- Side Panel Ends -->
            <!-- Main Panel Starts -->
            <div class="mainPanel ">
                <div class="panelInner">
                    <div class="middleContent">
                        @yield('content')
                    </div>
                </div>
            </div>
            <!-- Main Panel Ends -->
        </div>
        <footer class="footer-sec">Content Owned by Supreme Court of India</footer>
    </div>
    @if(in_array($_SESSION['login']['ref_m_usertype_id'],array(USER_ADVOCATE,USER_IN_PERSON)))
        
        <div class="add-new-area" tabindex="0" role="button">
            <a href="javascript:void(0)" class="add-btn"><span class="mdi mdi-plus-circle-outline"></span> NEW</a>
            <div class="add-new-options">
                <ul>
                    <li>
                        <a href="{{base_url('case/crud')}}" class="add-lnk">Case</a>
                    </li>
                    <li>
                        <a href="{{base_url('case/interim_application/crud')}}" class="add-lnk">IA</a>
                    </li>
                    <li>
                        <a href="{{base_url('case/document/crud')}}" class="add-lnk">Misc. Docs</a>
                    </li>
                    <li>
                        <a href="{{base_url('case/caveat/crud')}}" class="add-lnk">Caveat</a>
                    </li>
                    <li>
                        <a href="{{base_url('case/refile_old_efiling_cases/crud')}}" class="add-lnk">Refile old e-filing cases</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- <div class="add-new-area">
            <a href="javascript:void(0)" class="add-btn"><span class="mdi mdi-plus-circle-outline"></span> NEW</a>
            <div class="add-new-options">
                <ul>
                    <li>
                        <a href="{{base_url('case/crud')}}" class="add-lnk">Case</a>
                    </li>
                    <li>
                        <a href="{{base_url('case/interim_application/crud')}}" class="add-lnk">IA</a>
                    </li>
                    <li>
                        <a href="{{base_url('case/document/crud')}}" class="add-lnk">Misc. Docs</a>
                    </li>
                    <li>
                        <a href="{{base_url('case/caveat/crud')}}" class="add-lnk">Caveat</a>
                    </li>
                    <li>
                        <a href="{{base_url('case/refile_old_efiling_cases/crud')}}" class="add-lnk">Refile old e-filing cases</a>
                    </li>
                </ul>
            </div>
        </div> -->
    @endif
    <!-- <script src="<?= base_url() . 'assets/newAdmin/' ?>js/jquery-3.3.1.min.js"></script> -->
    <script src="<?= base_url() . 'assets/newAdmin/' ?>js/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url() . 'assets/newAdmin/' ?>js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() . 'assets/newAdmin/' ?>js/general.js"></script>
    <script src="<?= base_url() . 'assets' ?>/vendors/jquery/dist/jquery.min.js"></script>
    <!-- <script src="<?= base_url() . 'assets' ?>/js/jquery.min.js"></script>
    <script src="<?= base_url() . 'assets' ?>/js/jquery-ui.min.js"></script> -->
    <!-- <script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script>-->
    <script src="<?= base_url() ?>assets/js/bootstrap-datepicker.min.js"></script>  
    <script src="<?= base_url() ?>assets/js/sha256.js"></script>
    <script src="<?= base_url() ?>assets/newAdmin/js/angular.min.js"></script>
    <!-- scutum JS -->
    <script type="text/javascript" src="{{base_url('assets/responsive_variant/templates/uikit_scutum_2/assets/js/vendor.min.js')}}"></script>
    <script type="text/javascript" src="{{base_url('assets/responsive_variant/templates/uikit_scutum_2/assets/js/vendor/loadjs.js')}}"></script>
    <script type="text/javascript" src="{{base_url('/assets/responsive_variant/templates/uikit_scutum_2/assets/js/scutum_common.js')}}"></script>
    @stack('script')
    <script>
        $(document).ready(function() {
            $('#datatable-responsive').DataTable();
        });
    </script>
    <script src="<?= base_url() ?>assets/newAdmin/js/moment.min.js"></script>
    <script src="<?= base_url() ?>assets/newAdmin/js/fullcalendar.min.js"></script>
    <script src="<?= base_url() ?>assets/newAdmin/js/jquery.validate.min.js"></script>
    <script src="<?= base_url() ?>assets/newAdmin/js/jquery.dataTables.min.js"></script>
    <script>
        // $(document).ready(function() {
        //     var calendar = $('#calendar').fullCalendar({
        //         editable: true,
        //         header: {
        //             // left:'prev,next today',
        //             // center:'title',
        //             //right:'month,agendaWeek,agendaDay'
        //         },
        //         events: "<?php // echo base_url(); ?>fullcalendar/load",
        //         selectable: true,
        //         selectHelper: true,
        //         select: function(start, end, allDay) {
        //             var title = prompt("Enter Event Title");
        //             if (title) {
        //                 var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
        //                 var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
        //                 $.ajax({
        //                     url: "<?php // echo base_url(); ?>fullcalendar/insert",
        //                     type: "POST",
        //                     data: {
        //                         title: title,
        //                         start: start,
        //                         end: end
        //                     },
        //                     success: function() {
        //                         calendar.fullCalendar('refetchEvents');
        //                         alert("Added Successfully");
        //                     }
        //                 })
        //             }
        //         },
        //         editable: true,
        //         eventResize: function(event) {
        //             var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
        //             var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
        //             var title = event.title;
        //             var id = event.id;
        //             $.ajax({
        //                 url: "<?php // echo base_url(); ?>fullcalendar/update",
        //                 type: "POST",
        //                 data: {
        //                     title: title,
        //                     start: start,
        //                     end: end,
        //                     id: id
        //                 },
        //                 success: function() {
        //                     calendar.fullCalendar('refetchEvents');
        //                     alert("Event Update");
        //                 }
        //             })
        //         },
        //         eventDrop: function(event) {
        //             var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
        //             //alert(start);
        //             var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
        //             //alert(end);
        //             var title = event.title;
        //             var id = event.id;
        //             $.ajax({
        //                 url: "<?php // echo base_url(); ?>fullcalendar/update",
        //                 type: "POST",
        //                 data: {
        //                     title: title,
        //                     start: start,
        //                     end: end,
        //                     id: id
        //                 },
        //                 success: function() {
        //                     calendar.fullCalendar('refetchEvents');
        //                     alert("Event Updated");
        //                 }
        //             })
        //         },
        //         eventClick: function(event) {
        //             if (confirm("Are you sure you want to remove it?")) {
        //                 var id = event.id;
        //                 $.ajax({
        //                     url: "<?php // echo base_url(); ?>fullcalendar/delete",
        //                     type: "POST",
        //                     data: {
        //                         id: id
        //                     },
        //                     success: function() {
        //                         calendar.fullCalendar('refetchEvents');
        //                         alert('Event Removed');
        //                     }
        //                 })
        //             }
        //         }
        //     });
        // });
        function isNumber(value) {
            return typeof value === 'number';
        }
        $(document).ready(function() {
            $('#loader-wrapper').show();
            var loaderTimeout = setTimeout(function() {
                $('#loader-wrapper').fadeOut('slow', function() {
                    $('#content').fadeIn('slow');
                });
            }, 1000);
            $(window).on('load', function() {
                clearTimeout(loaderTimeout);
                $('#loader-wrapper').fadeOut('slow', function() {
                    $('#content').fadeIn('slow');
                });
            });
        });
	</script>
</body>
</html>