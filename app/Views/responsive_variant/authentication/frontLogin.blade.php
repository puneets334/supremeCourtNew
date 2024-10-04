@extends('layout.frontApp')
@section('content')
<!-- Login Area Start  -->
<div class="login-area">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-7 login-banner">
                <div class="login-banner-inner">
                    <div class="banimg-sec">
                        <!-- <img src="<?= base_url() . 'assets/newDesign/' ?>images/SCI-banner.png" alt="" class="img-fluid"> -->
                        <img src="<?= base_url() . 'assets/newDesign/' ?>images/logo-full.png" alt="" class="img-fluid logo-at-banner">
                    </div>
                    <div class="banner-txts">
                        <h5>SC-EFM </h5>
                        <h6>E-Filing Module</h6>
                        <h6>Supreme Court of India</h6>
                    </div>
                </div>
            </div>



            <div class="col-12 col-sm-12 col-md-6 col-lg-5 login-section">
                <div class="login-s-inner">
                    <?php $session = session(); ?>
                    @if($session->has('msg'))
                    <div class="text-danger">
                        <b>{{ esc($session->get('msg')) }}</b>
                    </div>
                    @endif
                    @if($session->has('information'))
                    <div class="text-primary">
                        <b>{{esc($session->get('information'))}}</b>
                    </div>
                    @endif
                    @if(isset($validation) && !empty($validation->getError('txt_username')))
                    <div class="text-danger">
                        <b>{{ $validation->getError('txt_username')}}</b>
                    </div>
                    @endif
                    @if(isset($validation) && !empty($validation->getError('txt_password')))
                    <div class="text-danger">
                        <b>{{ $validation->getError('txt_password')}}</b>
                    </div>
                    @endif


                    <div class="httxt">
                        <h4>Login</h4>
                    </div>
                    <div class="loin-form">
                        <?php  //echo $_SESSION["captcha"];
                        $attribute = array('class' => 'form_horizontal', 'name' => 'form_horizontal', 'id' => 'login-form', 'accept-charset' => 'utf-8', 'autocomplete' => 'off', 'onsubmit' => 'enableSubmit();');
                        echo form_open(base_url('login'), $attribute);
                        ?>
                        <input type="text" style="display: none" name="_token" value="{{ csrf_token() }}">

                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">User Name <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control cus-form-ctrl" id="exampleInputEmail1" name="txt_username" value="{{@$session->get('user')}}" placeholder="UserId/Mobile/Email Id" maxlength="60" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Password <span style="color: red;">*</span></label>
                                    <input type="password" name="txt_password" class="form-control cus-form-ctrl" id="password" placeholder="Password" maxlength="128" value="" required>
                                    @if(!empty($session->get('impersonated_user_authentication_mobile_otp')))
                                    <input name="impersonatedUserAuthenticationMobileOtp" aria-label="Mobile OTP" class="uk-input uk-width uk-form-large uk-form-blank uk-text-bold uk-text-medium" style="border-top: 0.001rem #ccc dashed;" type="text" placeholder="Mobile OTP">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="captchaimage">
                                    <div class="mb-3">
                                        @include('Captcha.Captcha_view')

                                        {{-- <input type="text" value="" placeholder="HrT5709KL"
                                                id="" name="" class="form-control cus-form-ctrl"> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label gray-txt" for="exampleCheck1">Remember
                                            Me</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 text-right">
                                <div class="mb-3">
                                    <label class="form-label gray-txt">Forgot Password ? <a href="<?php echo base_url('Register/ForgetPassword'); ?>" class="blue-txt"> Click Here</a></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="mb-3">
                                    <button class="btn quick-btn ">LOGIN</button>
                                </div>
                            </div>
                        </div>
                        </form>
                        <div class="regester-txts">
                            <h6 class="htsmall">Register As :</h6>
                            <div class="regester-links">
                                <a href="{{base_url('register')}}" class="blue-txt">Individual (Party In Person)</a>
                                <span class="gray-txt">Or</span>
                                <a href="{{base_url('register/AdvocateOnRecord')}}" class="blue-txt"> AOR</a>
                                <span class="gray-txt">Or</span>
                                <a href="{{base_url('arguingCounselRegister')}}" class="blue-txt">Advocate</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login Area End  -->
@endsection