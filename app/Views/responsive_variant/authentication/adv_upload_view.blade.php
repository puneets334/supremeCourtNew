@extends('layout.frontApp')
@section('content')

<style type="text/css">
    @media only screen and (min-width: 960px) {
        body{
            overflow-x:hidden;
        }
    }

</style>

<?php
//var_dump($_SESSION);
//echo $_SESSION['register_data']['password'];
$star_requered = '<span style="color: red">*</span>'; ?>
<?php $session = session(); ?>
<div class="login-area">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 login-banner">
                <div class="login-banner-inner">
                    <div class="banimg-sec">
                        <!-- <img src="<?= base_url() . 'assets/newDesign/' ?>images/SCI-banner.png" alt="Banner Image" title="Supreme Court of India" class="img-fluid"> -->
                        <img src="<?= base_url() . 'assets/newDesign/' ?>images/logo-full.png" alt="" class="img-fluid  logo-at-banner">

                    </div>
                    <div class="banner-txts">
                        <h5>SC-EFM </h5>
                        <h6>E-Filing Module</h6>
                        <h6>Supreme Court Of India</h6>
                    </div>
                </div>
            </div>


            <div class="col-12 col-sm-12 col-md-5 col-lg-5 login-section">
                <div class="login-s-inner">
                    <?php $session = session(); ?>
                    <div class="text-danger">
                        <b><?php echo $session->getFlashData('msg'); ?></b>
                    </div>
                    <div class="httxt">
                        <h4>Verify Your Self</h4>
                    </div>
                    <div class="loin-form">
                        <?php
                            $attribute = array('class' => 'uk-form-horizontal uk-margin-large', 'name' => 'advocate_reg_info', 'id' => 'advocate_reg_info', 'autocomplete' => 'off', 'enctype' => "multipart/form-data");
                            echo form_open('register/AdvSignUp/upload_id_proof', $attribute);
                        ?>
                            <input type="text" style="display: none" name="_token" value="{{ csrf_token() }}">

                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="mb-3">
                                        <label class="radio-inline"><input type="radio" name="optradio" checked>Upload ID Proof </label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="mb-3">
                                        <?php if (!empty($_SESSION['image_and_id_view']['profile_photo'])) { ?>
                                            <img src="<?php echo $_SESSION['image_and_id_view']['profile_photo']; ?>" width="250" height="250" alt="profile photo" style="border: 1px solid;">
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-8">
                                                <input class="form-control cus-form-ctrl"  type="file" required id="advocate_image" name="advocate_image">
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                                                <input type="submit" value="UPLOAD" id="info_save" class="btnSubmit btn btn-sm quick-btn btn-primary" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <?php if (!empty($_SESSION['image_and_id_view']['profile_photo'])) { ?>
                                        <a href="<?php echo base_url('register/AdvSignUp/final_submit'); ?>" class="btn btn-sm quick-btn btn-primary"> FINAL SUBMIT </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


