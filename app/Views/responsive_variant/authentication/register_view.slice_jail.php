@extends('responsive_variant.layouts.master.uikit_scutum_2.index')

@section('title', 'Register')
@section('heading-container')@endsection
@section('pinned-main-offcanvas')@endsection
@section('content-container-ribbon')@endsection

@section('content')

<style type="text/css">
    @media only screen and (min-width: 960px) {
        body{
            overflow-y:hidden;
        }
    }
</style>

<div id="login-container" class="uk-child-width-1-1 uk-child-width-1-2@m uk-grid-small" uk-grid uk-height-viewport="offset-top:true">
    <div class="uk-visible@m" styl="margin-bottom:4rem;">
        <!--<div class="uk-background-contain uk-height-1-1" style="background-image: url({{base_url('assets/responsive_variant/images/illustrations/undraw_setup_obqo_alt_1.png')}});">

        </div>-->
        <div class="ukflex ukflex-middle uk-width uk-background-center-center uk-background-norepeat uk-height-1-1" style="background-image: url({{base_url('assets/responsive_variant/images/sci/building/front_clipart.jpg')}});background-size:55rem">
            <div class="uk-width uk-text-center" styl="margin-bottom:8rem;">
                <div class="uk-label text-white uk-margin-small-bottom" style="background-color:#1e87f0;padding:0.3rem 1.3rem;font-size:2rem;font-weight:500;">
                    <i class="mdi mdi-cloud-tags sc-icon-44"></i>&nbsp;&nbsp;
                    SC-eFM
                </div>
                <!--<div class="uk-h3 uk-text-bold md-color-grey-600 uk-margin-remove-top uk-margin-large-bottom">Supreme Court Prison Connect Module</div>-->
                <div class="uk-h3 uk-text-bold md-color-grey-600 uk-margin-remove-top uk-margin-large-bottom">Supreme Court eFiling Module</div>
            </div>
        </div>
    </div>
    <div class="uk-flex uk-flex-middle">
        <div class="uk-width uk-text-center">

            <div class="uk-hidden@m uk-label text-white uk-margin-small-bottom" style="background-color:#1e87f0;padding:0.3rem 1.3rem;font-size:2rem;font-weight:500;">
                <i class="mdi mdi-cloud-tags sc-icon-44"></i>&nbsp;&nbsp;
                SC-EFM
            </div>
            <div class="uk-hidden@m uk-h4 uk-text-bold md-color-grey-600 uk-margin-remove-top uk-margin-large-bottom">Supreme Court eFiling Module</div>

            <div class="ukwidth-4-5@s ukwidth-3-5@m uk-width-medium@s uk-width-large@m uk-align-center" uk-margin>
                <br><br>
                <?php
                if ($this->uri->segment(2) == 'AdvocateOnRecord') {
                    $title = 'Advocate On Record';
                } else {
                    $title = 'Party In Person';
                }
                ?>
                <h4><?php echo $title; ?><strong> (Registration)</strong></h4>

                <div id="ekyc_upload_share" style="display: none;">
                    <?php
                    $attributes = array("class" => "form-horizontal", "id" => "loginform", "name" => "loginform", 'autocomplete' => 'off', 'enctype' => 'multipart/form-data');
                    echo form_open("register/DefaultController/adv_get_otp", $attributes);
                    ?>

                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid uk-text-center">
                        <input type="hidden" name="adv_type_select" id="adv_type_select" value="<?php echo htmlentities(url_encryption('1'), ENT_QUOTES); ?>">
                        <a class="uk-button uk-button-default">
                            <label><input class="uk-radio new_advocate" type="radio" name="not_register_type_user"  id="new_advocate" onclick="HideEkycDiv('offline_proceed')" name="not_register_type_user" value="<?php echo htmlentities(url_encryption('not_register_ekyc'), ENT_QUOTES); ?>" checked> Offline</label>
                        </a>
                        <a class="uk-button uk-button-default">
                            <label><input class="uk-radio ekyc" type="radio" name="not_register_type_user" id="ekyc" onclick="showHideDiv('ekyc_upload_share')"   value="<?php echo htmlentities(url_encryption('not_register_other'), ENT_QUOTES); ?>" > Paperless KYC </label>
                        </a>
                    </div>
                    <br />

                    <input type="hidden" name="register_type" value="<?php echo $title; ?>">

                    <?php echo $this->session->flashdata('msg'); ?>
                    <input hidden id="user_login_type" name="adv_search1" value="<?php echo htmlentities(url_encryption('new_advocate_register'), ENT_QUOTES); ?>">
                    <input hidden id="user_login_type" name="adv_type1" value="<?php echo htmlentities(url_encryption('1'), ENT_QUOTES); ?>">
                    <p class="uk-margin">
                        <a style="width: 89%;" class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom"  target="_blank" href="https://resident.uidai.gov.in/offlineaadhaar">Visit to Download Offline Aadhaar Zip File  </a>
                        <span style="padding: 0px; font-size: 40px; margin-top: -10px;" class="uk-button uk-button-default" uk-tooltip="Enter ‘Aadhaar Number’ or ‘VID’ and mentioned ‘Security Code’ in screen, then click on ‘Send OTP’ or ‘Enter TOTP’. The OTP will be sent to the registered Mobile Number for the given Aadhaar number or VID. TOTP will be available on m-Aadhaar mobile Application of UIDAI. Enter the OTP received/TOTP. Enter a Share Code which be the password for the ZIP file and click on ‘Download’ button
                                               The Zip file containing the digitally signed XML will be downloaded to device wherein the above mentioned steps have been performed.">?</span>

                    </p>
                    <div class="uk-margin">
                        <span>Choose Offline Aadhaar Zip File (max size 5mb).</span>
                        <div class="uk-inline">
                            <input type="file" class="uk-button uk-button-primary" id="ekyc_zip_file" name="ekyc_zip_file" required>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <div class="uk-inline" style="display: block;">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: user"></span>
                            <input class="uk-input" type="password" name="share_code"  placeholder="Share Code" minlength="4" maxlength="6" required>
                        </div>
                    </div>



                    <div class="uk-margin">
                        <div class="uk-inline" style="display: block;">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: user"></span>
                            <input class="uk-input" type="text" name="adv_mobile" id="adv_mobile"  maxlength="10" minlength="10" placeholder="Mobile">
                        </div> <?php echo form_error('adv_mobile'); ?>
                    </div>

                    <div class="uk-margin">
                        <div class="uk-inline" style="display: block;">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                            <input class="uk-input" type="text" name="adv_email" id="adv_email"  placeholder="Email ID">

                        </div>  <?php echo form_error('adv_email'); ?>
                    </div>
                    <button class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom">SEND OTP</button>


                    <?php echo form_close(); ?>
                </div>





                <div id="offline_proceed" >
                    <?php
                    $attributes = array("class" => "form-horizontal", "id" => "loginform", "name" => "loginform", 'autocomplete' => 'off');
                    echo form_open("register/DefaultController/adv_get_otp", $attributes);
                    ?>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid uk-text-center">
                        <input type="hidden" name="adv_type_select" id="adv_type_select" value="<?php echo htmlentities(url_encryption('1'), ENT_QUOTES); ?>">
                        <a class="uk-button uk-button-default">
                            <label><input class="uk-radio" type="radio" name="not_register_type_user"  id="new_advocate" onclick="HideEkycDiv('offline_proceed')" name="not_register_type_user" value="<?php echo htmlentities(url_encryption('not_register_ekyc'), ENT_QUOTES); ?>" checked> Offline</label>
                        </a>
                        <a class="uk-button uk-button-default">
                            <label><input class="uk-radio" type="radio" name="not_register_type_user" id="ekyc" onclick="showHideDiv('ekyc_upload_share')"   value="<?php echo htmlentities(url_encryption('not_register_other'), ENT_QUOTES); ?>" > Paperless KYC </label>
                        </a>
                    </div>
                    <br />

                    <input type="hidden" name="register_type" value="<?php echo $title; ?>">
                    <div class="uk-margin">
                        <div class="uk-inline" style="display: block;">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: user"></span>
                            <input class="uk-input" type="text" name="adv_mobile" id="adv_mobile"  maxlength="10" minlength="10" placeholder="Mobile">

                        </div> <?php echo form_error('adv_mobile'); ?>
                    </div>

                    <div class="uk-margin">
                        <div class="uk-inline" style="display: block;">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                            <input class="uk-input" type="text" name="adv_email" id="adv_email" placeholder="Email ID">

                        </div> <?php echo form_error('adv_email'); ?>
                    </div>
                    <button class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom">SEND OTP</button>

                    <?php echo form_close(); ?>
                </div>






                <div>
                    <a href="{{base_url()}}" class="uk-button uk-button-link uk-text-bold uk-text-success">Login ?</a>
                </div>
                <div class="uk-margin-small-top">
                    <b class="uk-text-muted">Register as:</b><br>
                    <a href="{{base_url('register')}}" class="ukbutton ukbutton-link">Individual (Party in Person)</a>
                    &nbsp;&nbsp;&nbsp;or&nbsp;&nbsp;&nbsp;
                    <a href="{{base_url('register/AdvocateOnRecord')}}" class="ukbutton ukbutton-link">AOR</a>
                </div>
                <?php if (ENABLE_DISCLAIMER != '') { ?>
                    <br><br>
                    <div class="container-box" style="margin-top: -73px;padding: 0;background: rgba(243, 236, 236, 0.4)">
                        <p class="left-align" style="color: red; margin: 8px 0px 6px 0;"><?php echo lang('disclaimer'); ?></p>
                    </div>

                <?php } ?>
            </div><br><br>
        </div>
    </div>
    <div class="uk-hidden@m uk-width uk-height-small uk-background-cover uk-background-bottom-center uk-background-norepeat ukheight-1-1" style="background-image: url({{base_url('assets/responsive_variant/images/sci/building/front_clipart.jpg')}});"></div>

    <script src="<?= base_url('assets/js/jquery.min.js'); ?>" type="text/javascript"></script>


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
    @endsection

