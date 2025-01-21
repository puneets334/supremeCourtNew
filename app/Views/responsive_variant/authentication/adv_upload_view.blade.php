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
<div class="login-area full-loginarea-pg">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 login-banner d-none">
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


            <div class="col-12 col-sm-12 col-md-12 col-lg-12 login-section">
                <div class="login-s-inner">
                    <?php $session = session(); ?>
                    <?php if($session->getFlashData('msg') == 'Successful.'){ ?>
                        <div class="text-success">
                        <?php echo "<div style='color:green; border: 2px solid green; background-color: #d4edda; padding: 10px; margin: 10px 0; font-weight: bold;'>" . $session->getFlashData('msg') . "</div>";
 ?> 
                    </div>
                    <?php } else { ?>
                        <div class="text-danger">
                            <b><?php echo $session->getFlashData('msg'); ?></b>
                        </div>
                    <?php } ?>
                    <div class="httxt">
                        <h4>Verify Your Self</h4>
                    </div>
                    <div class="loin-form">
                        <?php
                        $attribute = array('class' => 'uk-form-horizontal uk-margin-large', 'name' => 'advocate_reg_info', 'id' => 'advocate_reg_info', 'autocomplete' => 'off', 'enctype' => "multipart/form-data");
                        echo form_open('register/AdvSignUp/upload_id_proof', $attribute);
                        ?>
                            <input type="text" class="dNone" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="mb-3">
                                        <label class="radio-inline mb-2"><input type="radio" name="optradio" checked>Upload ID Proof </label>
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                                                <input accept=".jpg, .jpeg" class="form-control cus-form-ctrl"  type="file" required id="advocate_image" name="advocate_image" onchange="validateImage()">
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                                <input type="submit" value="UPLOAD" id="info_save" class="btnSubmit btn btn-sm quick-btn btn-primary" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-8 col-lg-8 ">
                                    <div class="mb-3">
                                        <div class="veryfy-img-sec">
                                            <?php if (!empty($_SESSION['image_and_id_view']['profile_photo'])) { ?>
                                                <img src="<?php echo $_SESSION['image_and_id_view']['profile_photo']; ?>" width="250" height="250" alt="profile photo" style="border: 1px solid;">
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="mb-3">
                                        
                                    </div>
                                </div> -->
                                
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                    <!-- <div class="center-buttons mb-0"> -->
                                        <?php if (!empty($_SESSION['image_and_id_view']['profile_photo'])) { ?>
                                            <a href="<?php echo base_url('register/AdvSignUp/final_submit'); ?>" class="quick-btn"> FINAL SUBMIT </a>
                                        <?php } ?>
                                    <!-- </div> -->
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


<script>
function validateImage() {
    var fileInput = document.getElementById('advocate_image');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg)$/i;
    var maxSize = 1 * 1024 * 1024; // 2MB in bytes
    
    // Check file type
    if (!allowedExtensions.exec(filePath)) {
        alert('Please upload a file with .jpg or .jpeg extension.');
        fileInput.value = ''; // Clear the input
        return false;
    }
    
    // Check file size
    if (fileInput.files[0].size > maxSize) {
        alert('The file size should not exceed 1 MB.');
        fileInput.value = ''; // Clear the input
        return false;
    }
}
</script>