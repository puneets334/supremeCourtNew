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
<?php
$segment = service('uri');
$session = service('session');
?>
<body class="login-page">
    <header>
        <!-- Top Header Section End -->
        <div class="top-header">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-3 col-lg-6 top-left-nav wow fadeInDown"></div>
                    <div class="col-12 col-sm-12 col-md-9 col-lg-6 top-right-nav wow fadeInDown">
                        <ul>
                            <li><a href="#SkipContent" class="hide skiptomain" aria-label="Skip to main content" title="Skip to main content">Skip To Main Content</a></li>
                            <li><a class="hide" href="javascript:void(0)">Screen Reader Access</a></li>
                            <li class="text-size">
                                <img src="<?= base_url() . 'assets/newDesign/' ?>images/text-ixon.png" alt=""
                                    class="txt-icon">
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
        <div id="SkipContent" tabindex="-1"></div>
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
                                <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarSupportedContent">
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
                            <img src="<?= base_url() . 'assets/newDesign/' ?>images/SCI-banner.png" alt=""
                                class="img-fluid">
                        </div>
                        <div class="banner-txts">
                            <?php
                            if ($segment->getSegment(2) == 'AdvocateOnRecord') {
                                $title = 'Advocate On Record';
                                $adv_type_select=USER_ADVOCATE;
                            } else {
                                $title = 'Party In Person';
                                $adv_type_select=USER_IN_PERSON;
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-5 col-lg-5 login-section">
                    <div class="login-s-inner">
                        <?php $session = session(); ?>
                        @if($session->has('msg'))
                            <div class="alert alert-dismissible text-center flashmessage">
                                <b>{{ esc($session->get('msg')) }}</b>
                            </div>
                        @endif
                        @if($session->has('information'))
                            <div class="alert alert-dismissible text-center flashmessage">
                                <b>{{esc($session->get('information'))}}</b>
                            </div>
                        @endif
                        @if(isset($validation) && !empty($validation->getError('adv_mobile')))
                            <div class="alert alert-dismissible text-center flashmessage">
                                <b>{{ $validation->getError('adv_mobile')}}</b>
                            </div>
                        @endif
                        @if(isset($validation) && !empty($validation->getError('adv_email')))
                            <div class="alert alert-dismissible text-center flashmessage">
                                <b>{{ $validation->getError('adv_email')}}</b>
                            </div>
                        @endif
                        <div class="httxt">
                            <h4><?php echo $title; ?><strong> (Registration)</strong></h4>
                        </div>
                        <div id="ekyc_upload_share" style="display: none;">
                            <?php
                            $attributes = array("class" => "form-horizontal", "id" => "loginform", "name" => "loginform", 'autocomplete' => 'off', 'enctype' => 'multipart/form-data');
                            echo form_open("register/DefaultController/adv_get_otp", $attributes);
                            ?>
                                <input type="text" style="display: none" name="_token" value="{{ csrf_token() }}">
                                <input type="text" name="adv_type_select" style="display: none;" id="adv_type_select" value="<?php echo integerEncreption($adv_type_select); ?>">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label"></label>
                                            <input type="hidden" name="adv_type_select" id="adv_type_select" value="<?php echo integerEncreption($adv_type_select); ?>">
                                            <a class="">
                                                <label><input class="form-check-input" type="radio" name="not_register_type_user"  id="new_advocate" onclick="HideEkycDiv('offline_proceed')" name="not_register_type_user" value="<?php echo stringEncreption('not_register_ekyc'); ?>" checked> Offline</label>
                                            </a>
                                            <a class="">
                                                <label><input class="form-check-input" type="radio" name="not_register_type_user" id="ekyc" onclick="showHideDiv('ekyc_upload_share')" value="<?php echo htmlentities(stringEncreption('not_register_other'), ENT_QUOTES); ?>" > Paperless KYC </label>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <input type="hidden" name="register_type" value="<?php echo $title; ?>">
                                <input type="hidden" name="ctvrg">
                                <?php echo $session->setFlashdata('msg'); ?>
                                <input hidden id="user_login_type" name="adv_search1" value="<?php echo htmlentities(stringEncreption('new_advocate_register'), ENT_QUOTES); ?>">
                                <!--<input hidden id="user_login_type" name="adv_type1" value="<?php /*echo htmlentities(stringEncreption('1'), ENT_QUOTES); */?>">-->
                                <input hidden id="user_login_type" name="adv_type1" value="<?php echo integerEncreption($adv_type_select); ?>">
                                <p class="">
                                    <a style="width: 100%;" class="btn quick-btn" target="_blank" href="https://resident.uidai.gov.in/offlineaadhaar">Visit to Download Offline Aadhaar Zip File</a>
                                    <!-- <span style="padding: 0px; font-size: 40px; margin-top: -10px;" class="uk-button uk-button-default" uk-tooltip="Enter ‘Aadhaar Number’ or ‘VID’ and mentioned ‘Security Code’ in screen, then click on ‘Send OTP’ or ‘Enter TOTP’. The OTP will be sent to the registered Mobile Number for the given Aadhaar number or VID. TOTP will be available on m-Aadhaar mobile Application of UIDAI. Enter the OTP received/TOTP. Enter a Share Code which be the password for the ZIP file and click on ‘Download’ button
                                    The Zip file containing the digitally signed XML will be downloaded to device wherein the above mentioned steps have been performed.">?</span> -->
                                </p>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Choose Offline Aadhaar Zip File (max size 5mb).</label>
                                            <input type="file" class="form-control cus-form-ctrl" id="ekyc_zip_file" name="ekyc_zip_file" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label"></label>
                                            <input class="form-control cus-form-ctrl" type="password" name="share_code"  placeholder="Share Code" minlength="4" maxlength="6" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label"></label>
                                            <input class="form-control cus-form-ctrl" type="text" name="adv_mobile" id="adv_mobile"  maxlength="10" minlength="10" placeholder="Mobile" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label"></label>
                                            <input class="form-control cus-form-ctrl" type="text" name="adv_email" id="adv_email"  placeholder="Email ID">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="captchaimage">
                                            <div class="mb-3">
                                                @include('Captcha.Captcha_view')
                                                <!-- <input type="text" value="" placeholder="HrT5709KL" id="" name="" class="form-control cus-form-ctrl"> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <button class="btn quick-btn">SEND OTP</button>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div id="offline_proceed">
                            <?php
                            $attributes = array("class" => "form-horizontal loginform", "id" => "loginform", "name" => "loginform", 'autocomplete' => 'off');
                            echo form_open("register/DefaultController/adv_get_otp", $attributes);
                                echo $session->setFlashdata('msg');
                                ?>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label"></label>
                                            <input type="hidden" name="adv_type_select" id="adv_type_select" value="<?php echo integerEncreption($adv_type_select); ?>">
                                            <a class="">
                                                <label><input class="form-check-input" type="radio" name="not_register_type_user"  id="new_advocate" onclick="HideEkycDiv('offline_proceed')" name="not_register_type_user" value="<?php echo htmlentities(stringEncreption('not_register_ekyc'), ENT_QUOTES); ?>" checked> Offline</label>
                                            </a>
                                            <a class="">
                                                <label><input class="form-check-input" type="radio" name="not_register_type_user" id="ekyc" onclick="showHideDiv('ekyc_upload_share')" value="<?php echo htmlentities(stringEncreption('not_register_other'), ENT_QUOTES); ?>" > Paperless KYC </label>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <input type="hidden" name="register_type" value="<?php echo $title; ?>">
                                <input type="hidden" name="ctvrg">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label"></label>
                                            <input class="form-control cus-form-ctrl" type="text" name="adv_mobile" id="adv_mobile"  maxlength="10" minlength="10" placeholder="Mobile" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label"></label>
                                            <input class="form-control cus-form-ctrl" type="text" name="adv_email" id="adv_email" placeholder="Email ID">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="captchaimage">
                                            <div class="mb-3">
                                                @include('Captcha.Captcha_view')
                                                <!-- <input type="text" value="" placeholder="HrT5709KL" id="" name="" class="form-control cus-form-ctrl"> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <button class="btn quick-btn">SEND OTP</button>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <center><a href="{{base_url()}}" class="col-sm-3 col-md-3 btn quick-btn">LOGIN</a></center>
                        <div class="regester-txts">
                            <h6 class="htsmall">Register As :</h6>
                            <div class="regester-links">
                                <a href="{{base_url('register')}}" class="blue-txt">Individual (Party In Person)</a>
                                <span class="gray-txt">Or</span>
                                <a href="{{base_url('register/AdvocateOnRecord')}}" class="blue-txt"> AOR</a>
                                <!-- <span class="gray-txt">Or</span>
                                <a href="{{base_url('arguingCounselRegister')}}" class="blue-txt">Advocate</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Area End  -->
    <script src="<?= base_url('assets/js/jquery.min.js'); ?>" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?=base_url('CaptchaResource/js/Captcha.js');?>"></script>
    <script type="text/javascript">
        function showHideDiv(ele) {
            var srcElement = document.getElementById(ele);
            var srcElement2 = document.getElementById('offline_proceed');
            if (srcElement != null) {
                if (srcElement.style.display == "block") {
                } else {
                    srcElement.style.display = 'block';
                    srcElement2.style.display = 'none';
                    document.getElementById("new_advocate").checked = false;
                    document.getElementById("ekyc").checked = true;
                    //window.scrollBy(0, 60);
                }
                return false;
            }
        }
        function HideEkycDiv(ele) {
            var srcElement = document.getElementById(ele);
            var srcElement2 = document.getElementById('ekyc_upload_share');
            if (srcElement != null) {
                if (srcElement.style.display == "block") {
                } else {
                    // alert(srcElement2);
                    srcElement.style.display = 'block';
                    srcElement2.style.display = 'none';
                    document.getElementById("ekyc").checked = false;
                    document.getElementById("new_advocate").checked = true;
                    //window.scrollBy(0, 60);
                }
                return false;
            }
        }
    </script>   
</body>
</html>