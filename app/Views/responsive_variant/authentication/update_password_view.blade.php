@extends('responsive_variant.layouts.master.uikit_scutum_2.index')
@section('title', 'e-Filinf Forgot Password Update')
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
<a href="{{base_url('/')}}" class="uk-float-right uk-hidden"><span uk-icon="home"></span>&nbsp; Back To Home</a>

<div id="login-container" class="uk-child-width-1-1 uk-child-width-1-2@m uk-grid-small" uk-grid uk-height-viewport="offset-top:true">
    <div class="uk-visible@m" styl="margin-bottom:4rem;">
        <!--<div class="uk-background-contain uk-height-1-1" style="background-image: url({{base_url('assets/responsive_variant/images/illustrations/undraw_setup_obqo_alt_1.png')}});"></div>-->
        <div class="ukflex ukflex-middle uk-width uk-background-center-center uk-background-norepeat uk-height-1-1" style="background-image: url(<?= base_url('assets/responsive_variant/images/sci/building/front_clipart.jpg'); ?>); background-size: 55rem;">
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
            <div class="uk-visible@m uk-text-lead uktext-bolder ukheading-small uk-margin-small-bottom" style="font-size:2rem !important; font-weight: 500;display: none;">
                Forgot Password
            </div>
            <div class="uk-hidden@m uk-label text-white uk-margin-small-bottom" style="background-color:#1e87f0;padding:0.3rem 1.3rem;font-size:2rem;font-weight:500;">
                <i class="mdi mdi-cloud-tags sc-icon-44"></i>&nbsp;&nbsp;
                SC-EFM
            </div>
            <div class="uk-hidden@m uk-h4 uk-text-bold md-color-grey-600 uk-margin-remove-top uk-margin-large-bottom">Supreme Court eFiling Module</div>
            <div class="ukwidth-4-5@s ukwidth-3-5@m uk-width-medium@s uk-width-large@m uk-align-center" uk-margin>
                <?php
                $attributes = array("class" => "form-horizontal", "id" => "loginform", "name" => "loginform", 'autocomplete' => 'off');
                echo form_open("register/ForgetPassword/update_user_password", $attributes);
                    if ($this->uri->segment(2) == 'AdvocateOnRecord') {
                        $title = 'Advocate On Record';
                    } elseif ($this->uri->segment(3) == 'update_password') {
                        $title = 'Update Password';
                    } else {
                        $title = 'Party In Person';
                    }
                    ?>
                    <h4> <strong><?php echo $title; ?> </strong></h4>
                    <input type="hidden" name="register_type" value="<?php echo $title; ?>">
                    <?php echo $this->session->flashdata('msg'); ?>
                    <input type="hidden" name="salt" id="salt" value="<?=base64_encode(openssl_random_pseudo_bytes(32))?>">
                    <div class="uk-margin">
                        <div class="uk-inline" style="display: block;text-align: left!important;">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                            <input class="uk-input" type="password" name="password" id="password" maxlength="20" autocomplete="off"  placeholder="Password" onchange="changeData(this)">
                            <?php echo form_error('password'); ?>
                        </div>
                        <input id="txt_password" name="txt_password" type="hidden">
                    </div>
                    <div class="uk-margin">
                        <div class="uk-inline" style="display: block;text-align: left!important;">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                            <input class="uk-input" type="password" name="confirm_password" id="confirm_password" autocomplete="off" maxlength="20"  placeholder="Confirm Password" onchange="changeData(this)" >
                            <?php echo form_error('confirm_password'); ?>
                        </div>
                    </div>
                    <button type="submit" name="btn_login" value="register" class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom">UPDATE PASSWORD</button>
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
        </div>
    </div>
</div>
<div class="uk-hidden@m uk-width uk-height-small uk-background-cover uk-background-bottom-center uk-background-norepeat ukheight-1-1" style="background-image: url(<?= base_url('assets/responsive_variant/images/sci/building/front_clipart.jpg'); ?>);"></div>
<?php if (ENABLE_DISCLAIMER != '') { ?>
   <br><br>
    <div class="container-box" style="margin-top: -73px;padding: 0;background: rgba(243, 236, 236, 0.4)">
        <p class="left-align" style="color: red; margin: 8px 0px 6px 0;"><?php echo lang('disclaimer'); ?></p>
    </div>
<?php } ?>
@endsection
<script src="<?= base_url('assets/js/jquery.min.js'); ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sha256.js'); ?>" type="text/javascript"></script>
<script>
    /*$("#loginform").submit(function () {
        alert('sdfsdf');
        var password = $('#password').val();
        if (password != '') {
            $(this).find('#password').val(sha256($(this).find('#password').val()) + '<?= $_SESSION['login_salt'] ?>');
        }
        var confirm_password = $('#confirm_password').val();
        if (confirm_password != '') {
            $(this).find('#confirm_password').val(sha256($(this).find('#confirm_password').val()) + '<?= $_SESSION['login_salt'] ?>');
        }
    });*/
    function dataEncrypt(val,pass){
        return CryptoJS.AES.encrypt(JSON.stringify(val), pass, {format: CryptoJSAesJson}).toString();
    }
    function changeData() {
        var domElement=changeData.caller.arguments[0].target.id;
        var salt=document.getElementById("salt").value;
        var txtpass=$('#'+domElement).val()+'hgtsd12@_hjytr'+salt;
        var newpass=sha256($('#'+domElement).val());
        $('#'+domElement).val(newpass);
        for(var i=0;i<10;i++) {
            txtpass = dataEncrypt(txtpass, salt);
        }
        $('#txt_password').val(txtpass);
    }
</script>