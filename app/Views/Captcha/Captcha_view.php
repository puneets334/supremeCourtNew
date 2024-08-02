<!--start Captcha Resource-->
<!-- <p> -->
<div class="row">
<div class="col-4 col-sm-4 col-md-4 col-lg-4">
    <img src="<?=base_url('captcha/DefaultController');?>" id='captcha_image' style="height: 45px !important;">
</div>
    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
    <img src="<?=base_url('CaptchaResource/images');?>/speaker.png" class="img-rounded pointer" onclick="playAudio();" alt="speaker" style="width: 42px;cursor: pointer;">

    <img src="<?=base_url('CaptchaResource/images');?>/refresh.png" class="img-circle pointer" onclick="refreshCaptcha();" alt="captcha Refresh" style="width:32px;border-radius: 50%;cursor: pointer;">
</div>
    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
    <input type="text" class="form-control uk-input" name="userCaptcha" id="captchacode" placeholder="Enter captcha" minlength="6" maxlength="6" style="width: 30%;margin-left: 20px;" required>
    </div>
    </div>
<!-- </p> -->
<script src="<?=base_url('CaptchaResource/js/Captcha.js');?>"></script>
<!--end Captcha Resource-->