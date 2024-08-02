@extends('responsive_variant.layouts.master.uikit_scutum_2.index')

@section('title', 'Forget Password')
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

            <div class="uk-visible@m uk-text-lead uktext-bolder ukheading-small uk-margin-small-bottom" style="font-size:2rem !important;ont-weight:500;display: none;">
                Forget Password
            </div>
            <div class="uk-hidden@m uk-label text-white uk-margin-small-bottom" style="background-color:#1e87f0;padding:0.3rem 1.3rem;font-size:2rem;font-weight:500;">
                <i class="mdi mdi-cloud-tags sc-icon-44"></i>&nbsp;&nbsp;
                SC-EFM
            </div>
            <div class="uk-hidden@m uk-h4 uk-text-bold md-color-grey-600 uk-margin-remove-top uk-margin-large-bottom">Supreme Court eFiling Module</div>

            <div class="ukwidth-4-5@s ukwidth-3-5@m uk-width-medium@s uk-width-large@m uk-align-center" uk-margin>

                <?php
                $attributes = array("class" => "form-horizontal", "id" => "loginform", "name" => "loginform", 'autocomplete' => 'off');
                echo form_open("register/ForgetPassword/adv_get_otp", $attributes);
                ?>

                <?php
                if ($this->uri->segment(2) == 'AdvocateOnRecord') {
                    $title = 'Advocate On Record';
                } elseif ($this->uri->segment(2) == 'ForgetPassword') {
                    $title = 'Forget Password';
                } else {
                    $title = 'Party In Person';
                }
                ?>

                <h4> <strong><?php echo $title; ?> </strong></h4>

                <input type="hidden" name="register_type" value="<?php echo $title; ?>">

                <?php echo $this->session->flashdata('msg'); ?>
                <div class="uk-margin">
                    <div class="uk-inline" style="display: block;">
                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: user"></span>
                        <input class="uk-input" type="text" name="adv_mobile"  minlength="10" maxlength="10" placeholder="Mobile">
                        <?php echo form_error('adv_mobile'); ?>
                    </div>
                </div>
                <span class="ui-text-center">OR</span>
                <div class="uk-margin">
                    <div class="uk-inline" style="display: block;">
                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                        <input class="uk-input" type="text" name="adv_email" id="adv_email" placeholder="Email ID">
                        <?php echo form_error('adv_email'); ?>
                    </div>
                </div>
                <button type="submit" name="btn_login" value="register" class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom">SEND OTP</button>


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
<div class="uk-hidden@m uk-width uk-height-small uk-background-cover uk-background-bottom-center uk-background-norepeat ukheight-1-1" style="background-image: url({{base_url('assets/responsive_variant/images/sci/building/front_clipart.jpg')}});"></div>

@endsection
<script src="<?= base_url('assets/js/jquery.min.js'); ?>" type="text/javascript"></script>