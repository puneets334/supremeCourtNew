@extends('responsive_variant.layouts.master.uikit_scutum_2.index')

@section('title', 'e-Filing Login')
@section('heading-container')@endsection
@section('pinned-main-offcanvas')@endsection
@section('content-container-ribbon')@endsection

@section('content')

<style type="text/css">
    @media only screen and (min-width: 960px) {
        body{
            overflow-x:hidden;
        }
    }

</style>
<?php $star_requered = '<span style="color: red">*</span>'; ?>
<div class="uk-child-width-1-1@s uk-grid-small uk-text-center" uk-grid>
    <div>
        <div class="uk-tile uk-tile-muted uk-padding-remove">
            <p class="uk-h4">Verify Your Self </p>

        </div>
    </div>
</div>
<br>
<div class="uk-section  uk-preserve-color uk-card" style="padding: 0px!important;">
    <div class="uk-container" >

        <div class="uk-grid-match uk-child-width-expand@m" uk-grid>
            <div>
                <div class="uk-card-body uk-text-center" >
                    <span style="color:green;"> <?php echo $this->session->flashdata('msg'); ?></span>
                    <?php
                    $attribute = array('class' => 'uk-form-horizontal uk-margin-large', 'name' => 'advocate_reg_info', 'id' => 'advocate_reg_info', 'autocomplete' => 'off', 'enctype' => "multipart/form-data");
                    echo form_open('register/AdvSignUp/upload_id_proof', $attribute);
                    ?>
                    <div class="uk-inline">
                        <label class="radio-inline"><input type="radio" name="optradio" checked>Upload ID Proof </label>
                    </div>
                    <hr/>

                    <div class="uk-margin">

                        <div class="uk-form-controls">
                            <span>Upload ID Proof :</span>
                            <div class="uk-inline">
                                <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: cloud-upload"></span>
                                <input class="uk-input"  type="file" required id="advocate_image" name="advocate_image">
                            </div> <?php echo form_error('name'); ?>
                        </div>
                    </div>
                    <div class="uk-margin">

                        <div class="uk-form-controls">
                            <?php if (!empty($_SESSION['image_and_id_view']['profile_photo'])) { ?>
                                <img data-src="<?php echo $_SESSION['image_and_id_view']['profile_photo']; ?>" width="350" height="300" alt="profile photo" style="border: 1px solid;" uk-img>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="uk-margin">

                        <div class="uk-form-controls">
                            <input type="submit"  class="uk-button uk-button-primary uk-margin-small-bottom" id="info_save" value="UPLOAD">
                            <?php if (!empty($_SESSION['image_and_id_view']['profile_photo'])) { ?>
                                <a href="<?php echo base_url('register/AdvSignUp/final_submit'); ?>" class="uk-button uk-button-primary uk-margin-small-bottom"> FINAL SUBMIT </a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection


