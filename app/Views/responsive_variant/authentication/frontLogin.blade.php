@extends('layout.frontApp')
@section('content')
<!-- Login Area Start  -->
<div class="login-area">
    <div class="container">
        <div class="row" id="default">
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
                    @if($session->has('msg_success'))
                    <div class="text-success" style="border: 2px solid green; background-color: #e6ffe6; padding: 10px; border-radius: 5px;">
                        <b>{{ esc($session->get('msg_success')) }}</b>
                    </div>
                    @endif
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
                        <input type="text" style="display: none;" name="_token" value="{{ csrf_token() }}">

                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">User Name <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control cus-form-ctrl" id="exampleInputEmail1" name="txt_username" value="<?= session()->getFlashdata('old_username') ? session()->getFlashdata('old_username') : '' ?>" placeholder="UserId/Mobile/Email Id" maxlength="60" required>
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
                        <h6 class="htsmall">Login As :</h6>
                            <div class="regester-links">
                                    <a href="javascript:;" class="blue-txt aor-login">AUTHENTICATED BY AOR</a>
                                    <a href="javascript:;" class="blue-txt apcil-login">APPEARING COUNCIL</a>
                                </div>
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
        <div class="row" id="aor" style="display:none;">
                <div class="col-12 col-sm-12 col-md-6 col-lg-7 login-banner">
                    <div class="login-banner-inner">
                        <div class="banimg-sec">
                            <!-- <img src="<?= base_url() . 'assets/newDesign/' ?>images/SCI-banner.png" alt="" class="img-fluid"> -->
                            <img src="<?= base_url() . 'assets/newDesign/' ?>images/logo-full.png" alt="" class="img-fluid  logo-at-banner">

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
                        <!-- @if($session->has('msg'))
                        <div class="uk-text-danger">
                            <b>{{ esc($session->get('msg')) }}</b>
                        </div>
                        @endif
                        @if($session->has('information'))
                        <div class="uk-text-primary">
                            <b>{{esc($session->get('information'))}}</b>
                        </div>
                        @endif
                        @if(isset($validation) && !empty($validation->getError('txt_username')))
                        <div class="uk-text-danger">
                            <b>{{ $validation->getError('txt_username')}}</b>
                        </div>
                        @endif
                        @if(isset($validation) && !empty($validation->getError('txt_password')))
                        <div class="uk-text-danger">
                            <b>{{ $validation->getError('txt_password')}}</b>
                        </div>
                        @endif -->
                        <div class="httxt">
                            <h4>Login</h4>
                        </div>
                        <div class="loin-form">
                            <?php if (session()->getFlashdata('msg')) : ?>
                                <div class="alert alert-danger text-center flashmessage" role="alert">
                                    <div class="flas-msg-inner">
                                        <?= session()->getFlashdata('msg') ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php  //echo $_SESSION["captcha"];
                            $attribute = array('class' => 'form_horizontal', 'name' => 'form_horizontal', 'id' => 'login-form', 'accept-charset' => 'utf-8', 'autocomplete' => 'off', 'onsubmit' => 'enableSubmit();');
                            echo form_open(base_url('login'), $attribute);
                            ?>
                                <input type="text" style="display: none;" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden"  name="userType" value="" id="userType">
                                <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 row">
                                        <div class="col-5">
                                            <label for="AOR Mobile" class="form-label">AOR Mobile</label>
                                            
                                            <input type="radio" class="using"  name="using" value="AOR Mobile" <?php if((!empty($userEnteredData) && $userEnteredData['using']=='AOR Mobile')||(empty($userEnteredData) && empty($userEnteredData['using']))){ echo "checked";}?>>
                                        </div>
                                        <div class="col-4">
                                            <label for="AOR Code" class="form-label">AOR Code</label>
                                            <input type="radio" class="using"  name="using" value="AOR Code"  <?php if(!empty($userEnteredData) && $userEnteredData['using']=='AOR Code'){ echo "checked";}?>>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="mb-3" id="aorMobileBox">
                                            <label for="" class="form-label">AOR Mobile</label>
                                            <input type="text" class="form-control cus-form-ctrl" id="aor_mobile" name="aor_mobile"  placeholder="Mobile" maxlength="60" value="<?=(!empty($userEnteredData['aor_mobile'])?$userEnteredData['aor_mobile']:'')?>">
                                            @if(!empty($session->get('impersonated_user_authentication_mobile_otp'))&& !empty($userEnteredData['aor_mobile']))
                                            <input name="impersonatedUserAuthenticationMobileOtp" aria-label="Mobile OTP" class="form-control uk-input uk-width uk-form-large uk-form-blank uk-text-bold uk-text-medium" style="border-top: 0.001rem #ccc dashed;" type="text" placeholder="Mobile OTP">
                                            @endif
                                        </div>
                                        <div class="mb-3" id="aorcodeBox" style="display:none;">
                                            <label for="" class="form-label">AOR Code</label>
                                            <input type="text" class="form-control cus-form-ctrl" id="aor_code" name="aor_code"  placeholder="AOR code" maxlength="60" value="<?=(!empty($userEnteredData['aor_code'])?$userEnteredData['aor_code']:'')?>">
                                            @if(!empty($session->get('impersonated_user_authentication_mobile_otp'))&& !empty($userEnteredData['aor_code']))
                                            <input name="impersonatedUserAuthenticationMobileOtp" aria-label="Mobile OTP" class="form-control cus-form-ctrl uk-input uk-width uk-form-large uk-form-blank uk-text-bold uk-text-medium" style="border-top: 0.001rem #ccc dashed;" type="text" placeholder="Mobile OTP">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 authenticatedByAor">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Your Mobile No.</label>
                                            <input type="text" name="yr_mobile" class="form-control cus-form-ctrl" id="yr_mobile" placeholder="Enter Your Mobile No." maxlength="128" value="<?=(!empty($userEnteredData['yr_mobile'])?$userEnteredData['yr_mobile']:'')?>">
                                            
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 authenticatedByAor">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Your Email</label>
                                            <input type="email" name="you_email" class="form-control cus-form-ctrl" id="you_email" placeholder="Enter Your Email" maxlength="128" value="<?=(!empty($userEnteredData['you_email'])?$userEnteredData['you_email']:'')?>">
                                            
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
                                            <button class="btn quick-btn">LOGIN</button>
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                            <div class="regester-txts">
                            <h6 class="htsmall">Login As :</h6>
                            <div class="regester-links">
                                    <a href="javascript:;" class="blue-txt aor-login">AUTHENTICATED BY AOR</a>
                                    <a href="javascript:;" class="blue-txt apcil-login">APPEARING COUNCIL</a>
                                </div>
                                <h6 class="htsmall">Register As :</h6>
                                <div class="regester-links">
                                    <a href="{{base_url('register')}}" class="blue-txt">Individual (Party In Person)</a>
                                    <span class="gray-txt">Or</span>
                                    <a href="{{base_url('register/AdvocateOnRecord')}}" class="blue-txt">AOR</a>
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
