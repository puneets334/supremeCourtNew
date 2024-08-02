@extends('responsive_variant.layouts.master.uikit_scutum_2.index')

@section('title', 'Login')
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
                <div class="uk-h3 uk-text-bold md-color-grey-600 uk-margin-remove-top uk-margin-large-bottom">Supreme Court Prison Connect Module</div>
            </div>
        </div>
    </div>
    <div class="uk-flex uk-flex-middle">
        <div class="uk-width uk-text-center">
            <div class="uk-visible@m uk-text-lead uktext-bolder ukheading-small uk-margin-small-bottom" style="font-size:2rem !important;ont-weight:500;">
                Login Here&nbsp;
                <i class="mdi mdi-arrow-down-circle-outline"></i>
            </div>
            <div class="uk-hidden@m uk-label text-white uk-margin-small-bottom" style="background-color:#1e87f0;padding:0.3rem 1.3rem;font-size:2rem;font-weight:500;">
                <i class="mdi mdi-cloud-tags sc-icon-44"></i>&nbsp;&nbsp;
                SC-EFM
            </div>
            <div class="uk-hidden@m uk-h4 uk-text-bold md-color-grey-600 uk-margin-remove-top uk-margin-large-bottom">Supreme Court eFiling Module</div>

            <div class="ukwidth-4-5@s ukwidth-3-5@m uk-width-medium@s uk-width-large@m uk-align-center" uk-margin>
                @if(!empty($this->session->flashdata('msg')))
                    <div class="uk-text-danger">
                        <b>{{$this->session->flashdata('msg')}}</b>
                    </div>
                @endif
                @if(!empty($this->session->flashdata('information')))
                    <div class="uk-text-primary">
                        <b>{{$this->session->flashdata('information')}}</b>
                    </div>
                @endif
                @if(!empty(form_error('txt_username')))
                    <div class="uk-text-danger">
                        <b>{{form_error('txt_username')}}</b>
                    </div>
                @endif
                @if(!empty(form_error('txt_password')))
                    <div class="uk-text-danger">
                        <b>{{form_error('txt_password')}}</b>
                    </div>
                @endif
                <div class="uk-grid-collapse" uk-grid>
                    <span class="uk-width-1-2 uk-text-bold uk-text-medium uktext-left">User</span>
                    <span class="uk-width-1-2 uk-text-bold uk-text-medium uktext-left">Password</span>
                </div>
                <div class="uk-card uk-card-body uk-padding-remove ukborder-rounded" style="border-radius:9px">
                    <form id="login-form" method="POST" action="{{base_url('login')}}" autocomplete="off">
                        <input type="hidden" name="ctvrg">
                        <div class="uk-grid-collapse" uk-grid>
                            <input name="txt_username" aria-label="User or Email" class="uk-input uk-width-1-2 uk-form-large uk-form-blank uk-text-bold uk-text-medium" styl="border-right: 0.001rem #ccc dashed;border-right-radius:0;" type="text" value="{{@$this->session->flashdata('user')}}" placeholder="User">
                            <input name="txt_password" aria-label="Password" class="uk-input uk-width-1-2 uk-form-large uk-form-blank uk-text-bold uk-text-medium" styl="border-left: 0.001rem #ccc dashed;border-left-radius:0;" type="password" placeholder="Password">

                            @if(!empty($this->session->flashdata('impersonated_user_authentication_mobile_otp')))
                            <input name="impersonatedUserAuthenticationMobileOtp" aria-label="Mobile OTP" class="uk-input uk-width uk-form-large uk-form-blank uk-text-bold uk-text-medium" style="border-top: 0.001rem #ccc dashed;" type="text" placeholder="Mobile OTP">
                            @endif
                        </div>
                        <button type="submit" class="sc-button uk-button-secondary uk-width uk-border-none uk-button-large" style="height:3.2rem;border-radius:0 0 9px 9px;"><b>Sign In</b></button>
                    </form>
                </div>
            </div>
            <div>
                <a href="{{base_url('register/ForgetPassword')}}" class="uk-button uk-button-link uk-text-bold uk-text-danger">Forgot Password ?</a>
            </div>
        </div>
    </div>
</div>
<div class="uk-hidden@m uk-width uk-height-small uk-background-cover uk-background-bottom-center uk-background-norepeat ukheight-1-1" style="background-image: url({{base_url('assets/responsive_variant/images/sci/building/front_clipart.jpg')}});"></div>

<script src="<?= base_url('assets/js/sha256.js'); ?>" type="text/javascript"></script>
<!--<script src='https://www.google.com/recaptcha/api.js?render=6LfE13AUAAAAACYtRe104ECi3APlECcyJfbH3VrV'></script>-->
<script type="text/javascript">
    $(function(){
        @if(empty(@$this->session->flashdata('user')))
            $('[name="txt_username"]').focus();
        @else
            $('[name="txt_password"]').focus();
        @endif

        /*grecaptcha.ready(function () {*/
            $("#login-form").one('submit', function (e) {
                var form = this;
                $('[name="txt_password"]').val(sha256($('[name="txt_password"]').val()) + '<?= $_SESSION['login_salt'] ?>');
                /*e.preventDefault();
                grecaptcha.execute('6LfE13AUAAAAACYtRe104ECi3APlECcyJfbH3VrV', {action: '{{str_replace('-','_hyphen_',uri_string())}}'})
                .then(function (token) {
                    $('[name="ctvrg"]').val(token);
                    $(form).submit();
                });*/
            });
        /*});*/
    });
</script>

@endsection
