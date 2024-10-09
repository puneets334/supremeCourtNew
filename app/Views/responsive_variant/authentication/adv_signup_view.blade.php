@extends('layout.frontApp')
@section('content')
<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.min.css">
<style type="text/css">
    @media only screen and (min-width: 960px)    {
        body{
            overflow-x:hidden;
        }
    }
    .mt22 p{margin-top: -22px;}
</style>
<style>
    /* .datepicker-dropdown {
        margin-top: 300px !important;
    } */

    span.select2 {
        width: 100% !important;

    }

    .datepicker-dropdown {
        background-color: #fff;
    }

    .error {
        color: red;
    }

    .datepicker-days {
        background-color: #ffffff;
    }
</style>
<?php
// if(isset($_SESSION['kyc_configData'])) {
    $uid_data_name = isset($_SESSION['kyc_configData']) ? $_SESSION['kyc_configData']['UidData']['Poi']['@attributes']['name'] : '';
    $uid_data_dob = isset($_SESSION['kyc_configData']) ? $_SESSION['kyc_configData']['UidData']['Poi']['@attributes']['dob'] : '';
    $uid_data_dob = isset($_SESSION['kyc_configData']) ? str_replace('-', '/', $uid_data_dob) : '';
    $uid_data_email = isset($_SESSION['kyc_configData']) ? $_SESSION['kyc_configData']['UidData']['Poi']['@attributes']['e'] : '';
    $uid_data_gender = isset($_SESSION['kyc_configData']) ? $_SESSION['kyc_configData']['UidData']['Poi']['@attributes']['gender'] : '';
    $uid_data_mobile = isset($_SESSION['kyc_configData']) ? $_SESSION['kyc_configData']['UidData']['Poi']['@attributes']['m'] : '';

    $uid_data_photo = isset($_SESSION['kyc_configData']) ? $_SESSION['kyc_configData']['UidData']['Pht'] : '';
    $uid_data_son_of = isset($_SESSION['kyc_configData']) ? $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['careof'] : '';
    $uid_data_country = isset($_SESSION['kyc_configData']) ? $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['country'] : '';
    $uid_data_distt = isset($_SESSION['kyc_configData']) ? $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['dist'] : '';
    $uid_data_house_no = isset($_SESSION['kyc_configData']) ? $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['house'] : '';
    $uid_data_landmark = isset($_SESSION['kyc_configData']) ? $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['landmark'] : '';
    $uid_data_locality = isset($_SESSION['kyc_configData']) ? $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['loc'] : '';
    $uid_data_pincode = isset($_SESSION['kyc_configData']) ? $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['pc'] : '';
    $uid_data_post = isset($_SESSION['kyc_configData']) ? $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['po'] : '';
    $uid_data_state = isset($_SESSION['kyc_configData']) ? $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['state'] : '';
    $uid_data_street = isset($_SESSION['kyc_configData']) ? $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['street'] : '';
    $uid_data_village = isset($_SESSION['kyc_configData']) ? $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['vtc'] : '';
// }
// else{
//     echo "Session data not found!";
//     exit; 
// }
$user_addar_img = 'data:image/png;base64,' . htmlentities($uid_data_photo, ENT_QUOTES);
?>
<?php $star_requered = '<span style="color: red">*</span>'; ?>
<?php $session = session(); ?>
<div class="login-area register-area">
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
                        <h4><?php echo $_SESSION['adv_details']['register_type']; ?></h4>
                    </div>
                    <div>
                        <?php if(isset($_SESSION['session_not_register_type_user']) && url_decryption($_SESSION['session_not_register_type_user']) == 'not_register_other'){ ?>
                        <div class="uk-card-body" >
                            <div class="uk-child-width-1-1@s uk-grid-small uk-text-center" style="background-color: #eeeeee;color:#29527C;padding-bottom: 13px;font-weight: 700;font-size: 13px;line-height: 1.471;font-family: 'Helvetica Neue',Roboto,Arial,'Droid Sans',sans-serif;" >

                            <div>
                                <div class="uk-tile uk-tile-mutedww uk-padding-remove" style="padding-bottom: 65px;">
                                    <p class="uk-h4">Aadhar Details </p>
                                    <hr/>
                                    <div class="uk-column-1-2@s uk-column-1-2@m uk-column-1-2@l uk-text-left">
                                        <div class="uk-column-1-1@s uk-column-1-1@m uk-column-1-1@l mt22">
                                            <p>S/O  : <?php echo htmlentities($uid_data_son_of, ENT_QUOTES); ?></p>
                                            <p>Country  : <?php echo htmlentities($uid_data_country, ENT_QUOTES); ?></p>
                                            <p>District  : <?php echo htmlentities($uid_data_distt, ENT_QUOTES); ?></p>
                                            <p>House No.  : <?php echo htmlentities($uid_data_house_no, ENT_QUOTES); ?></p>
                                            <p>Landmark  : <?php echo htmlentities($uid_data_landmark, ENT_QUOTES); ?></p>
                                            <p>Locality  : <?php echo htmlentities($uid_data_locality, ENT_QUOTES); ?></p>
                                        </div>
                                        <div class="uk-column-1-1@s uk-column-1-1@m uk-column-1-1@l mt22">
                                            <p>Pincode : <?php echo htmlentities($uid_data_pincode, ENT_QUOTES); ?></p>
                                            <p>Post  : <?php echo htmlentities($uid_data_post, ENT_QUOTES); ?></p>
                                            <p>State: <?php echo htmlentities($uid_data_state, ENT_QUOTES); ?></p>
                                            <p>Street  : <?php echo htmlentities($uid_data_street, ENT_QUOTES); ?></p>
                                            <p>Village  : <?php echo htmlentities($uid_data_village, ENT_QUOTES); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <?php } ?>
                    </div>
                    <div class="loin-form">
                        <?php
                            $attribute = array('id' => 'uploadForm', 'enctype' => "multipart/form-data");
                            echo form_open(base_url(), $attribute);
                        ?>
                            <input type="text" style="display: none" name="_token" value="{{ csrf_token() }}">

                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="mb-3" id="targetLayer">
                                        <?php if (!empty($_SESSION['profile_image']['profile_photo'])) { ?>
                                                <img  src="<?php echo $_SESSION['profile_image']['profile_photo']; ?>"  height="94" width="94" />
                                            <?php } else if (!empty($_SESSION['kyc_configData']['UidData']['Pht'])) {
                                                ?>
                                                <img  src="<?php echo $user_addar_img; ?>"  height="94" width="94" />
                                                <?php
                                            } else {
                                                echo "NO IMAGE";
                                            }
                                        ?>
                                       
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="mb-3">
                                        <p class="image-note mb-2">
                                            NOTE: Please upload only JPG or JPEG. File name maximun length can be 40 characters including digits characters, spaces, hypens and underscore. maximum file size 1MB.
                                        </p>
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-8">
                                                <input type="file" class="form-control cus-form-ctrl" value="<?php echo_data($user_addar_img) ?>" placeholder="" name="advocate_image" id="advocate_image" required>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                                                <input type="submit" value="UPLOAD" class="btnSubmit btn btn-sm quick-btn btn-primary" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="loin-form">
                        <?php
                            if (!empty($uid_data_name)) {
                                $value = $uid_data_name;
                            } else {
                                $value = set_value('name');
                            }
                        ?>
                        <?php
                            $attribute = array('class' => 'uk-form-horizontal uk-margin-large', 'name' => 'advocate_reg_info', 'id' => 'advocate_reg_info', 'autocomplete' => 'off');
                            echo form_open('register/AdvSignUp/add_advocate', $attribute);
                        ?>
                            <input type="text" style="display: none" name="_token" value="{{ csrf_token() }}">

                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Name <?php echo $star_requered; ?></label>
                                        <input class="form-control cus-form-ctrl" id="form-horizontal-text" type="text" id="name" name="name" placeholder="Name" maxlength="50" value="<?php echo $value; ?>">
                                        <?php if (isset($validation) && $validation->hasError('name')): ?>
                                            <div class="text-danger">
                                                <?= $validation->getError('name'); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Date of Birth <?php echo $star_requered; ?></label>
                                        <input class="form-control cus-form-ctrl" value="<?php
                                                if (!empty($post_datas[2])) {
                                                    echo date("d/m/Y", strtotime(htmlentities($post_datas[2], ENT_QUOTES)));
                                                } elseif (!empty($uid_data_dob)) {
                                                    echo $uid_data_dob;
                                                } else {

                                                }
                                                ?>" name="date_of_birth" id="date_of_birth" maxlength="10" placeholder="DD/MM/YYYY" value="<?php echo set_value('date_of_birth'); ?>" type="text">
                                                 <?php if (isset($validation) && $validation->hasError('date_of_birth')): ?>
                                                    <div class="text-danger">
                                                        <?= $validation->getError('date_of_birth'); ?>
                                                    </div>
                                                <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Mobile Number <?php echo $star_requered; ?></label>
                                        <input class="form-control cus-form-ctrl" id="form-horizontal-text" name='mobile' type="text" value="<?php echo $_SESSION['adv_details']['mobile_no']; ?>" placeholder="Mobile" minlength="10" maxlength="10" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Email ID <?php echo $star_requered; ?></label>
                                        <input class="form-control cus-form-ctrl" id="form-horizontal-text" value="<?php echo $_SESSION['adv_details']['email_id']; ?>" placeholder="Email ID" name='email_id' readonly>
                                    </div>
                                </div>
                                <?php
                                    $male = '';
                                    $female = '';
                                    if ($uid_data_gender == 'M') {
                                        $male = 'checked';
                                    } elseif ($uid_data_gender == 'F') {
                                        $female = 'checked';
                                    }
                                ?>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Gender <?php echo $star_requered; ?></label><br>
                                        <label class="radio-inline"><input type="radio" <?php echo_data($male) ?> id="gender" name="gender" value="<?php echo htmlentities(url_encryption(1), ENT_QUOTES); ?>" maxlength="1" checked> Male </label>
                                            <label class="radio-inline"><input type="radio" <?php echo_data($female) ?> id="gender" name="gender" value="<?php echo htmlentities(url_encryption(2), ENT_QUOTES); ?>" maxlength="1"> Female </label>
                                            <label class="radio-inline"><input type="radio" id="gender" name="gender"  value="<?php echo htmlentities(url_encryption(3), ENT_QUOTES); ?>" maxlength="1"> Other </label>
                                            <?php if (isset($validation) && $validation->hasError('gender')): ?>
                                            <div class="text-danger">
                                                <?= $validation->getError('gender'); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php $requerd = ''; $selected = '';?>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Address <?php echo $star_requered; ?></label>
                                        <textarea name="address" id="address" rows="1" placeholder="H.No.,  Street no, Colony,  Land Mark" class="form-control cus-form-ctrl" required><?php echo trim(htmlentities($uid_data_house_no, ENT_QUOTES)); ?><?php echo !empty($uid_data_landmark)?','.trim(htmlentities($uid_data_landmark, ENT_QUOTES)):''; ?><?php echo !empty($uid_data_locality)?','. trim(htmlentities($uid_data_locality, ENT_QUOTES)):''; ?>
                                            </textarea>
                                            <?php if (isset($validation) && $validation->hasError('address')): ?>
                                            <div class="text-danger">
                                                <?= $validation->getError('address'); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">State <?php echo $star_requered; ?></label>
                                        <select name="state_id" id="state_id" class="form-control cus-form-ctrl" <?php echo $requerd; ?>>
                                            <option value="" title="Select">Select State</option>
                                            <?php
                                            
                                            foreach ($select_state as $state) {
                                                echo '<option ' . $selected . ' value="' . htmlentities($state['state_code'] . '#$' . $state['state_name'], ENT_QUOTES) . '">' . htmlentities(strtoupper($state['state_name']), ENT_QUOTES) . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php if (isset($validation) && $validation->hasError('state_id')): ?>
        <div class="text-danger">
            <?= $validation->getError('state_id'); ?>
        </div>
    <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">District <?php echo $star_requered; ?></label>
                                        <select name="district_list" id="district_list" class="form-control cus-form-ctrl" required <?php echo $requerd; ?> >
                                            <option value="" title="Select">Select District</option>
                                        </select>
                                        <?php if (isset($validation) && $validation->hasError('district_list')): ?>
        <div class="text-danger">
            <?= $validation->getError('district_list'); ?>
        </div>
    <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Pin Code <?php echo $star_requered; ?></label>
                                        <input class="form-control cus-form-ctrl" id="pincode" name="pincode" <?php echo htmlentities($requerd, ENT_QUOTES); ?> value="<?php echo htmlentities($uid_data_pincode, ENT_QUOTES); ?>" placeholder="Pincode" maxlength="6" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                        <?php if (isset($validation) && $validation->hasError('pincode')): ?>
        <div class="text-danger">
            <?= $validation->getError('pincode'); ?>
        </div>
    <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                            <div class="mb-3">
                                                <button type="submit"  class="quick-btn" id="info_save" value="SUBMIT">SUBMIT</button>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                            <div class="mb-3">
                                                <a href="<?php echo base_url('register'); ?>" class="quick-btn gray-btn" >CANCEL</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





</div>

@endsection
@push('script')
<link href="<?= base_url() . 'assets' ?>/css/select2.min.css" rel="stylesheet">
<!-- form--end  -->
<!-- <script src="<?= base_url() . 'assets/newAdmin/' ?>js/jquery-3.3.1.min.js"></script> -->
<script src="<?= base_url() . 'assets/newAdmin/' ?>js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() . 'assets/newAdmin/' ?>js/general.js"></script>
<!-- <script src="<?= base_url() . 'assets/newAdmin/' ?>js/jquery-3.5.1.slim.min.js"></script> -->
<script src="<?= base_url() . 'assets' ?>/vendors/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url() . 'assets' ?>/js/jquery.min.js"></script>
<script src="<?= base_url() . 'assets' ?>/js/jquery-ui.min.js"></script>
<!-- <script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.min.js"></script> -->
<script src="<?= base_url() ?>assets/js/sha256.js"></script>
<script src="<?= base_url() ?>assets/newAdmin/js/jquery.dataTables.min.js"></script>
<!-- <script src="<?= base_url() . 'assets' ?>/js/select2.min.js"></script>
<script src="<?= base_url() . 'assets' ?>/js/select2-tab-fix.min.js"></script> -->
<!-- <script type="text/javascript" src="<?= base_url() . 'assets' ?>/js/jquery.validate.js"></script> -->

<!-- jQuery (Ensure this is included first) -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap Datepicker CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />

<!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Bootstrap Datepicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
</script>
<script>
    // $(document).ready(function () {
    //     $('.filter_select_dropdown').select2();
    // });
    $(document).ready(function () {
        var today = new Date();

    $('#date_of_birth').datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:-1",
        format: "dd/mm/yyyy",
        // defaultDate: '-40y'
        endDate: today,

        maxDate: new Date
    }); 
});

    $('#state_id').change(function () {
        $('#district_list').val('');
        $('#establishment_list').val('');
        var get_state_id = $(this).val();
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, state_id: get_state_id},
            url: "<?php echo base_url('register/AdvSignUp/get_dist_list'); ?>",
            success: function (data)
            {
                if (data.indexOf('ERROR') != -1) {
                    $('#msg').show();
                    $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + data + " <span class='close' onclick=hideMessageDiv()>X</span></p>");
                    $('#district_list').html('<option value=""> Select District </option>');

                } else {
                    $('#msg').hide();
                    $('#district_list').html(data);
                }
                $.getJSON("<?php echo base_url() . 'csrftoken'; ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function () {
                $.getJSON("<?php echo base_url() . 'csrftoken'; ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
    }); 

     
</script>


<script type="text/javascript">
$(document).ready(function (e) {

    $("#uploadForm").on('submit',(function(e) {
        e.preventDefault();

        var fileInput = document.getElementById('advocate_image');
            var file = fileInput.files[0];

            // Allowed file types
            var allowedTypes = ['image/jpeg', 'image/jpg'];
            var maxSize = 1024 * 1024; // 1MB

            if (file) {
                // Check file size
                if (file.size > maxSize) {
                    alert("File size must be maximum 1MB.");
                    fileInput.value = ''; // Clear the file input
                    return false;
                }

                // Check file type
                if (!allowedTypes.includes(file.type)) {
                    alert("Invalid file type. Please upload a JPG or JPEG file.");
                    fileInput.value = ''; // Clear the file input
                    return false;
                }
                $.ajax({
            url: "<?php echo base_url('register/AdvSignUp/upload_photo'); ?>",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data)
            {
                var resArr = data.split('@@@');
                if (resArr[0] == 1) {
                    // $('#msg').show();
                    // $(".form-response").html("<p class='text-center alert alert-danger flashmessage message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' >X</span></p>");
                    alert(resArr[1]);
                }else{
                    $("#targetLayer").html(data);
                }
            },
            error: function() 
            {
            }           
       });
            }



        
    }));
});
</script> 
@endpush

