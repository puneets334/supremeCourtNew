<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?= base_url() . 'assets/newDesign/' ?>images/logo.png" type="image/png" />
	<title>SC-eFM</title>
	<link href="<?= base_url() . 'assets/newDesign/' ?>css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?= base_url() . 'assets/newDesign/' ?>css/font-awesome.min.css" rel="stylesheet" />
	<link href="<?= base_url() . 'assets/newDesign/' ?>css/material.css" rel="stylesheet" />
	<link href="<?= base_url() . 'assets/newDesign/' ?>css/glyphicons.css" rel="stylesheet" />
	<link href="<?= base_url() . 'assets/newDesign/' ?>css/owl.carousel.min.css" rel="stylesheet" />
	<link href="<?= base_url() . 'assets/newDesign/' ?>css/owl.theme.default.css" rel="stylesheet">
	<link href="<?= base_url() . 'assets/newDesign/' ?>css/animate.css" rel="stylesheet">
	<link href="<?= base_url() . 'assets/newDesign/' ?>css/style.css" rel="stylesheet" />
</head>

<body class="login-page">
	<header>
		<!-- Top Header Section End -->
		<div class="top-header">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-3 col-lg-6 top-left-nav wow fadeInDown">

					</div>
					<div class="col-12 col-sm-12 col-md-9 col-lg-6 top-right-nav wow fadeInDown">
						<ul>
							<li><a href="javascript:void(0)" class="hide skiptomain">Skip To Main Content</a></li>
							<li><a class="hide" href="javascript:void(0)">Screen Reader Access</a></li>
							<li class="text-size">
								<img src="<?= base_url() . 'assets/newDesign/' ?>images/text-ixon.png" alt="" class="txt-icon">
							</li>
							<li>
								<a href="javascript:void(0)" class="toph-icon"><i class="fas fa-sitemap"></i></a>
							</li>
							<li class="theme-color">
								<a href="javascript:void(0)" class="whitebg">A</a>
								<a href="javascript:void(0)" class="blackbg">A</a>
							</li>
							<li>
								<select name="" id="" class="select-lang">
									<option value="">English</option>
									<option value="">Hindi</option>
								</select>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Top Header Section End -->
		<!-- Logo Section Header Start -->
		<div class="logo-sec-wraper">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-4 logo-sec wow fadeInUp">
						<a class="logo-align" href="index.html">
							<img src="<?= base_url() . 'assets/newDesign/' ?>images/logo.png" alt="emblem">
							<div class="brand-text">
								<h4>भारत का सर्वोच्च न्यायालय
									<span> Supreme Court of India </span>
									<span class="logo-sm-txt">|| यतो धर्मस्ततो जय: ||</span>
								</h4>
							</div>
						</a>
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-8 loginbtn-sec wow fadeInUp">
						<div class="nav-wraper">
							<nav class="navbar navbar-expand-lg navbar-light custom-nav  w-100 wow fadeInUp">
								<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
									<span class="navbar-toggler-icon"></span>
								</button>
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="navbar-nav mr-auto">
                                        <li class="nav-item">
                                            <!-- <a class="active" href="index.html">Handbook </a> -->
                                            <!-- <a class="active"  href="<?php echo base_url('e-resources')?>">Handbook </a> -->
                                            <a class="nav-link <?= (current_url() == base_url('e-resources')) ? 'active' : '' ?>"  href="<?= base_url('e-resources') ?>">Handbook </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?= (current_url() == base_url('e-resources/video-tutorial')) ? 'active' : '' ?>"  href="<?= base_url('e-resources/video-tutorial') ?>">Video Tutorial</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?= (current_url() == base_url('e-resources/FAQs')) ? 'active' : '' ?>"  href="<?= base_url('e-resources/FAQs') ?>">FAQs</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?= (current_url() == base_url('e-resources/hand-book-old-efiling')) ? 'active' : '' ?>"  href="<?= base_url('e-resources/hand-book-old-efiling') ?>">Stats</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?= (current_url() == base_url('e-resources/three-pdf-user-manual')) ? 'active' : '' ?>"  href="<?= base_url('e-resources/three-pdf-user-manual') ?>">3PDF User Manual</a>
                                        </li>
                                    </ul>
                                </div>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Logo Section Header End -->
	</header>
	<!-- Login Area Start  -->
	<div class="login-area">
		<div class="container">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-7 col-lg-7 login-banner">
					<div class="login-banner-inner">
						<div class="banimg-sec">
							<img src="<?= base_url() . 'assets/newDesign/' ?>images/SCI-banner.png" alt="" class="img-fluid">
						</div>
						<div class="banner-txts">
							<h5>SC-EFM </h5>
							<h6>E-Filing Module</h6>
							<h6>Supreme Court of India</h6>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-12 col-md-5 col-lg-5 login-section">
					<div class="login-s-inner">
						<div class="httxt">
							<h4>Enter the code</h4>
						</div>
						<div class="loin-form otp-form">
							<?php $session = session(); ?>
							@if($session->has('msg'))
							<div class="uk-text-danger">
								<b>{{ esc($session->get('msg')) }}</b>
							</div>
							@endif
							<?php  //echo $_SESSION["captcha"];
							$attribute = array('class' => 'form_horizontal', 'name' => 'form_horizontal', 'id' => 'login-form', 'accept-charset' => 'utf-8', 'autocomplete' => 'off');
							echo form_open(base_url('otp'), $attribute);
							?>
							<input type="text" style="display: none" name="_token" value="{{ csrf_token() }}">
							<div class="row">
								<div class="col-12 col-sm-12 col-md-12 col-lg-12">
									<div class="mb-3">
										<label for="" class="form-label">Enter the OTP code we sent to your mobile, be careful not to share the code to anyone</label>
									</div>
								</div>
							</div>
							<div class="otp-sec">
								<div class="row ">
									<div class="col-12 col-sm-12 col-md-12 col-lg-12">
										<div class="row otp-row">
											<div class="col mb-3">
												<input type="text" required class="form-control round-input" maxlength="1" placeholder="" name="otp_one" value="1">
											</div>
											<div class="col mb-3">
												<input type="text" required class="form-control round-input" maxlength="1" placeholder=" " name="otp_two" value="2">
											</div>
											<div class="col mb-3 ">
												<input type="text" required class="form-control round-input" maxlength="1" placeholder=" " name="otp_three" value="3">
											</div>
											<div class="col mb-3">
												<input type="text" required class="form-control round-input" maxlength="1" placeholder=" " name="otp_four" value="4">
											</div>
											<div class="col mb-3">
												<input type="text" required class="form-control round-input" maxlength="1" placeholder=" " name="otp_five" value="5">
											</div>
											<div class="col mb-3">
												<input type="text" required class="form-control round-input" maxlength="1" placeholder=" " name="otp_six" value="6">
											</div>
										</div>
									</div>
								</div>
								{{-- <div class="row">
										<div class="col-12 col-sm-12 col-md-12 col-lg-12">
											<div class="mb-3">
												<label for="" class="form-label">Didn’t receive the OTP? Tap <a href=""  class="yellow-txt"> Resend OTP </a> to get a new one.</label>
											</div>
										</div>
									</div> --}}
							</div>
							<div class="row">
								<div class="col-12 col-sm-12 col-md-12 col-lg-12">
									<div class="mb-3">
										<button type="submit" class="btn quick-btn ">Verify The Code</button>
									</div>
								</div>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Login Area End  -->
	<footer>
		<!-- Footer Top Section Start -->
		<div class="footer-top-sec">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-5 copyright-sec">
						<p>Content Owned by Supreme Court of India</p>
					</div>
					<div class="col-12 col-sm-12 col-md-6 col-lg-7 contact-txt">
						<p>Please email your complaint/issue(s) along with relevant screenshot(s) to – <span class="blue-txt"> efiling[at]sci[dot]nic[dot]in </span></p>
					</div>
				</div>
			</div>
		</div>
		<!-- Footer Top Section End -->
	</footer>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="<?= base_url() . 'assets/newDesign/' ?>js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url() . 'assets/newDesign/' ?>js/jquery.easy-ticker.min.js"></script>
	<script src="<?= base_url() . 'assets/newDesign/' ?>js/wow.min.js"></script>
	<script src="<?= base_url() . 'assets/newDesign/' ?>js/owl.carousel.js"></script>
	<script src="<?= base_url() . 'assets/newDesign/' ?>js/custom.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const inputs = document.querySelectorAll('.round-input');

			inputs.forEach((input, index) => {
				input.addEventListener('input', function() {
					if (input.value.length === 1 && index < inputs.length - 1) {
						inputs[index + 1].focus();
					}
				});

				input.addEventListener('keydown', function(e) {
					if (e.key === 'Backspace' && input.value.length === 0 && index > 0) {
						inputs[index - 1].focus();
					}
				});
			});
		});
	</script>
</body>

</html>