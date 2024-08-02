@extends('responsive_variant.layouts.master.uikit_scutum_2.index')

@section('title', 'e-Filing Login')
@section('heading-container')@endsection
@section('pinned-main-offcanvas')@endsection
@section('content-container-ribbon')@endsection

@section('content')

<style type="text/css">
    @media only screen and (min-width: 960px)    {
        body{
            overflow-x:hidden;
        }
    }
    .mt22 p{margin-top: -22px;}
</style>
<?php
$uid_data_name = $_SESSION['kyc_configData']['UidData']['Poi']['@attributes']['name'];
$uid_data_dob = $_SESSION['kyc_configData']['UidData']['Poi']['@attributes']['dob'];
$uid_data_dob = str_replace('-', '/', $uid_data_dob);
$uid_data_email = $_SESSION['kyc_configData']['UidData']['Poi']['@attributes']['e'];
$uid_data_gender = $_SESSION['kyc_configData']['UidData']['Poi']['@attributes']['gender'];
$uid_data_mobile = $_SESSION['kyc_configData']['UidData']['Poi']['@attributes']['m'];

$uid_data_photo = $_SESSION['kyc_configData']['UidData']['Pht'];
$uid_data_son_of = $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['careof'];
$uid_data_country = $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['country'];
$uid_data_distt = $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['dist'];
$uid_data_house_no = $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['house'];
$uid_data_landmark = $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['landmark'];
$uid_data_locality = $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['loc'];
$uid_data_pincode = $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['pc'];
$uid_data_post = $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['po'];
$uid_data_state = $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['state'];
$uid_data_street = $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['street'];
$uid_data_village = $_SESSION['kyc_configData']['UidData']['Poa']['@attributes']['vtc'];

$user_addar_img = 'data:image/png;base64,' . htmlentities($uid_data_photo, ENT_QUOTES);
?>
<div class="uk-child-width-1-1@s uk-grid-small uk-text-center" uk-grid>
    <div>
        <div class="uk-tile uk-tile-muted uk-padding-remove">
            <!--  <p class="uk-h4">Party In Person</p> -->
            <?php $star_requered = '<span style="color: red">*</span>'; ?>
            <center><h3><?php echo $_SESSION['adv_details']['register_type']; ?></h3> </center>
            <div class="form-response">

            </div>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
    </div>
</div>
<br/>
<div class="uk-section  uk-preserve-color uk-card" style="padding: 0px!important;margin-top: -20px;">
    <div class="uk-container" >

        <div class="uk-grid-match uk-child-width-expand@m" uk-grid>
            <div>
                <?php if(url_decryption($_SESSION['session_not_register_type_user']) == 'not_register_other'){ ?>
                <div class="uk-card-body" >
                    <div class="uk-child-width-1-1@s uk-grid-small uk-text-center" style="background-color: #eeeeee;color:#29527C;padding-bottom: 13px;font-weight: 700;font-size: 13px;line-height: 1.471;font-family: "Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif;" >

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
        </div>


        <div>
            <div class="uk-card-body" style="padding: 0px;">
                <div class="uk-child-width-1-1@s uk-grid-small uk-text-center">
                    <div>
                        <!--<form id="uploadForm" method="post">-->
                            <?php
                            $attribute = array('id' => 'uploadForm');
                            echo form_open(base_url(), $attribute);
                            ?>

                            <div class="uk-text-center" style="margin-top: 20px;background-color: #eeeeee;color:#29527C; font-weight: 700;font-size: 10px;line-height: 1.471;font-family: "Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif;"  uk-grid>

                            <div class="uk-width-1-3@m" >
                                <div class="uk-card uk-card-default uk-card-body" style="background-color: #f7f1dc;padding: 36px;">
                                    <div id="targetLayer">
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
                            </div>
                            <div class="uk-width-expand@m">
                                <div class="uk-card-body uk-text-danger">
                                    <div id="uploadFormLayer">
                                        NOTE : Please upload only JPG or JPEG. File name maximun length can be 40 characters including digits characters, spaces, hypens and underscore. maximum file size 1MB.
                                        <input name="advocate_image" id="advocate_image" required type="file" value="<?php echo_data($user_addar_img) ?>" class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom">
                                        <input type="submit" value="UPLOAD" class="btnSubmit uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom" >
                                    </div>
                                </div>
                                <?php echo form_error('advocate_image'); ?>
                            </div>
                    </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


</div>


</div>


<?php
$attribute = array('class' => 'uk-form-horizontal uk-margin-large', 'name' => 'advocate_reg_info', 'id' => 'advocate_reg_info', 'autocomplete' => 'off');
echo form_open('register/AdvSignUp/add_advocate', $attribute);
?>


<div class="uk-container" style="margin-top: -70px;">

    <div class="uk-grid-match uk-child-width-expand@m" uk-grid>
        <div>
            <div class="uk-card-body" style="padding: 0px;">



                <?php
                if (!empty($uid_data_name)) {
                    $value = $uid_data_name;
                } else {
                    $value = set_value('name');
                }
                ?>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text"><span>Name <span class="uk-text-danger">*</span> :</span></label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: question"></span>
                            <input class="uk-input" id="form-horizontal-text" type="text" id="name" name="name" placeholder="Name" maxlength="50" value="<?php echo $value; ?>">
                        </div> <?php echo form_error('name'); ?>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text"><span>Date of Birth <span class="uk-text-danger">*</span> :</span></label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: question"></span>
                            <input class="uk-input" value="<?php
                            if (!empty($post_datas[2])) {
                                echo date("d/m/Y", strtotime(htmlentities($post_datas[2], ENT_QUOTES)));
                            } elseif (!empty($uid_data_dob)) {
                                echo $uid_data_dob;
                            } else {

                            }
                            ?>" name="date_of_birth" id="date_of_birth" maxlength="10" readonly="" placeholder="DD/MM/YYYY" value="<?php echo set_value('date_of_birth'); ?>" type="text">

                        </div>
                        <?php echo form_error('date_of_birth'); ?>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text"><span>Mobile :</span></label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: question"></span>
                            <input class="uk-input" id="form-horizontal-text" name='mobile' type="text" value="<?php echo $_SESSION['adv_details']['mobile_no']; ?>" placeholder="Mobile" minlength="10" maxlength="10" readonly>
                        </div>
                        <?php echo form_error('mobile'); ?>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text"><span>Email ID  :</span></label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: question"></span>
                            <input class="uk-input" id="form-horizontal-text" value="<?php echo $_SESSION['adv_details']['email_id']; ?>" placeholder="Email ID" name='email_id' readonly>
                        </div>
                        <?php echo form_error('email_id'); ?>
                    </div>
                </div>
                <?php
                if ($uid_data_gender == 'M') {
                    $male = 'checked';
                } elseif ($uid_data_gender == 'F') {
                    $female = 'checked';
                }
                ?>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text"><span>Gender <span class="uk-text-danger">*</span> :</span></label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <label class="radio-inline"><input type="radio" <?php echo_data($male) ?> id="gender" name="gender" value="<?php echo htmlentities(url_encryption(1), ENT_QUOTES); ?>" maxlength="1"> Male </label>
                            <label class="radio-inline"><input type="radio" <?php echo_data($female) ?> id="gender" name="gender" value="<?php echo htmlentities(url_encryption(2), ENT_QUOTES); ?>" maxlength="1"> Female </label>
                            <label class="radio-inline"><input type="radio" id="gender" name="gender"  value="<?php echo htmlentities(url_encryption(3), ENT_QUOTES); ?>" maxlength="1"> Other </label>
                        </div>
                        <?php echo form_error('gender'); ?>
                    </div>
                </div>






            </div>
        </div>
        <div>





            <div class="uk-card-body" style="padding: 0px;">

                <div class="uk-form-horizontal uk-margin-large">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-horizontal-text"><span>Address <?php echo $star_requered; ?></span></label>
                        <div class="uk-form-controls">
                            <div class="uk-inline">
                                <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: question"></span>
                                <textarea name="address" id="address" rows="3" placeholder="H.No.,  Street no, Colony,  Land Mark" class="form-control input-sm"><?php echo trim(htmlentities($uid_data_house_no, ENT_QUOTES)); ?><?php echo !empty($uid_data_landmark)?','.trim(htmlentities($uid_data_landmark, ENT_QUOTES)):''; ?><?php echo !empty($uid_data_locality)?','. trim(htmlentities($uid_data_locality, ENT_QUOTES)):''; ?>
                                </textarea>

                            </div>
                            <?php echo form_error('address'); ?>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-horizontal-text"><span>State <?php echo $star_requered; ?></span></label>
                        <div class="uk-form-controls">
                            <div class="uk-inline">
                                <select name="state_id" id="state_id" class="uk-select filter_select_dropdown" <?php echo $requerd; ?>>
                                    <option value="" title="Select">Select State</option>
                                    <?php
                                    foreach ($select_state as $state) {
                                        echo '<option ' . $selected . ' value="' . htmlentities($state['state_code'] . '#$' . $state['state_name'], ENT_QUOTES) . '">' . htmlentities(strtoupper($state['state_name']), ENT_QUOTES) . '</option>';
                                    }
                                    ?>
                                </select>

                            </div>
                            <?php echo form_error('state_id'); ?>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-horizontal-text"><span>District <?php echo $star_requered; ?></span></label>
                        <div class="uk-form-controls">
                            <div class="uk-inline">
                                <select name="district_list" id="district_list" class="uk-select filter_select_dropdown" <?php echo $requerd; ?> >
                                    <option value="" title="Select">Select District</option>
                                </select>

                            </div>
                            <?php echo form_error('district_list'); ?>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-horizontal-text"><span>Pin Code <?php echo $star_requered; ?></span></label>
                        <div class="uk-form-controls">
                            <div class="uk-inline">
                                <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: question"></span>
                                <input class="uk-input" id="pincode" name="pincode" <?php echo htmlentities($requerd, ENT_QUOTES); ?> value="<?php echo htmlentities($uid_data_pincode, ENT_QUOTES); ?>" placeholder="Pincode" maxlength="6">


                            </div>
                            <?php echo form_error('pincode'); ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <div class="uk-margin uk-text-center">
        <input type="submit"  class="uk-button uk-button-primary uk-margin-small-bottom" id="info_save" value="SUBMIT">
        <a href="<?php echo base_url('register'); ?>" class="uk-button uk-button-danger uk-margin-small-bottom" >CANCEL</a>
    </div>

</div>

<?php echo form_close(); ?>


</div>


@endsection


