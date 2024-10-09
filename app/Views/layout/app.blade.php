<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>SC</title>
	<link rel="shortcut icon" href="<?= base_url() . 'assets/newAdmin/' ?>images/favicon.gif">
	<link href="<?= base_url() . 'assets/newAdmin/' ?>css/bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url() . 'assets/newAdmin/' ?>css/font-awesome.min.css" rel="stylesheet">
	<link href="<?= base_url() . 'assets/newAdmin/' ?>css/animate.css" rel="stylesheet">
	<link href="<?= base_url() . 'assets/newAdmin/' ?>css/material.css" rel="stylesheet" />
	<link href="<?= base_url() . 'assets/newAdmin/' ?>css/style.css" rel="stylesheet">
	<link href="<?= base_url() . 'assets/newAdmin/' ?>css/responsive.css" rel="stylesheet">
	<link href="<?= base_url() . 'assets/newAdmin/' ?>css/black-theme.css" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery-ui.css">
	<link href="<?= base_url() . 'assets' ?>/css/select2.min.css" rel="stylesheet">
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
	</div>
	<footer class="footer-sec">Content Owned by Supreme Court of India</footer>
	<script src="<?= base_url() . 'assets' ?>/js/jquery.min.js"></script>
	<script src="<?= base_url() . 'assets' ?>/js/jquery-ui.min.js"></script>
	<script src="<?= base_url() . 'assets/newAdmin/' ?>js/jquery-3.3.1.min.js"></script>
	<script src="<?= base_url() . 'assets/newAdmin/' ?>js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url() . 'assets/newAdmin/' ?>js/general.js"></script>
	<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script>
	<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.min.js"></script>
	<script src="<?= base_url() ?>assets/js/sha256.js"></script>
	<script src="<?= base_url() ?>assets/responsive_variant/frameworks/uikit_3-4-1/js/uikit.min.js"></script>
	<script src="<?= base_url() ?>assets/responsive_variant/frameworks/uikit_3-4-1/js/uikit-icons.min.js"></script>
	<!-- Case Status modal-end-->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/daterangepicker/daterangepicker.css">
	<script src="<?= base_url() . 'assets' ?>/vendors/jquery/dist/jquery.min.js"></script>
	<script src="<?= base_url() . 'assets' ?>/js/jquery-ui.min.js"></script>
	<script src="<?= base_url() ?>assets/js/daterangepicker/daterangepicker.min.js"></script>
	<script src="<?= base_url() ?>assets/js/daterangepicker/moment.min.js"></script>
	<script src="<?= base_url() ?>assets/js/daterangepicker/daterangepicker.js"></script>
	<script src="<?= base_url() . 'assets' ?>/js/select2.min.js"></script>
	<script src="<?= base_url() . 'assets' ?>/js/select2-tab-fix.min.js"></script>
	<script type="text/javascript" src="<?= base_url() . 'assets' ?>/multiselect/bootstrap-multiselect.js"></script>
	<script src="<?= base_url() ?>assets/newAdmin/js/jquery.dataTables.min.js"></script>
	<!-- Vinit -->
	<!-- <script>
		$(document).ready(function() {
			$('#datatable-responsive').DataTable();
		});
	</script> -->

	<script>
        $(document).ready(function() {
            $('#loader-wrapper').show();
            var loaderTimeout = setTimeout(function() {
                $('#loader-wrapper').fadeOut('slow', function() {
                    $('#content').fadeIn('slow');
                });
            }, 3000);

            $(window).on('load', function() {
                clearTimeout(loaderTimeout);
                $('#loader-wrapper').fadeOut('slow', function() {
                    $('#content').fadeIn('slow');
                });
            });
        });
	</script>
	@stack('script')
</body>


</html>