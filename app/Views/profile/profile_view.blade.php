<?php declare(strict_types=1); ?>
@if(!in_array($_SESSION['login']['ref_m_usertype_id'],array(ARGUING_COUNSEL,SR_ADVOCATE)))
    @extends('layout.advocateApp')
@else
    @extends('layout.app')
@endif
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="dashboard-section dashboard-tiles-area"></div>
            <div class="dashboard-section">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="dash-card">
                            {{-- Page Title Start --}}
                            <div class="title-sec">
                                <h5 class="unerline-title">My Profile </h5>
                                <div class="end-buttons my-0">
                                    <a class="quick-btn gray-btn" href="<?= base_url(); ?>profile/updateProfile/pass">Change Password</a>
                                    <!-- <a href="javascript:void(0)" class="quick-btn pull-right mb-2" onclick="window.history.back()"><span class="mdi mdi-chevron-double-left"></span>Back</a> -->
                                    <a href="<?php echo isset($_SERVER['HTTP_REFERER']); ?>" class="quick-btn pull-right"><span class="mdi mdi-chevron-double-left"></span>Back</a>
                                </div>
                            </div>
                            {{-- Page Title End --}}
                            {{-- Main Start --}}
                            <div class="profile-details">
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="col-md-7 col-xs-6">
                                            <h2> Profile (
                                                <?php
                                                if (!empty($profile)) {
                                                    if ($profile->ref_m_usertype_id == USER_ADVOCATE) {
                                                        $user_type = 'Advocate';
                                                    } elseif ($profile->ref_m_usertype_id == USER_IN_PERSON) {
                                                        $user_type = 'Party in Person';
                                                    } elseif ($profile->ref_m_usertype_id == SR_ADVOCATE) {
                                                        $user_type = 'SR Advocate';
                                                    } elseif ($profile->ref_m_usertype_id == USER_ADMIN) {
                                                        $user_type = 'User Admin';
                                                    } elseif ($profile->ref_m_usertype_id == USER_EFILING_ADMIN) {
                                                        $user_type = 'Filing Admin';
                                                    } elseif ($profile->ref_m_usertype_id == USER_SUPER_ADMIN) {
                                                        $user_type = 'Super Admin';
                                                    }
                                                    echo htmlentities($user_type, ENT_QUOTES);
                                                }
                                                ?>
                                                )
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-10 col-lg-12">
                                        <div class="usrprofile-details">
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                                            <label class="prof-label">Name :</label>
                                                        </div>
                                                        <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                                            <div class="prof-outp">
                                                                <?= $profile->first_name ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                                            <label class="prof-label">Bar Reg No :</label>
                                                        </div>
                                                        <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                                            <div class="prof-outp">
                                                                <?= $profile->bar_reg_no ?> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                                            <label class="prof-label">AOR Code :</label>
                                                        </div>
                                                        <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                                            <div class="prof-outp">
                                                                <?= $profile->aor_code ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                                            <label class="prof-label">Enroll. Date :</label>
                                                        </div>
                                                        <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                                            <div class="prof-outp">
                                                                <?php
                                                                // if ($profile['enroll_date'] !=null && !empty($profile->enroll_date) && $profile->enroll_date!='0000-00-00') {
                                                                //     echo ucwords(htmlentities(date("d-m-Y", strtotime($profile->enroll_date)), ENT_QUOTES));
                                                                // } else {
                                                                //     echo 'N/A';
                                                                // }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                                            <label class="prof-label">Gender :</label>
                                                        </div>
                                                        <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                                            <div class="prof-outp">
                                                                <?php
                                                                $gender = '';
                                                                if ($profile->gender == 1 || $profile->gender == 'M') {
                                                                    $gender = 'Male';
                                                                } elseif ($profile->gender == 2 || $profile->gender == 'F') {
                                                                    $gender = 'Female';
                                                                } elseif ($profile->gender == 3 || $profile->gender == 'O') {
                                                                    $gender = 'Other';
                                                                }
                                                                echo $gender;
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                                            <label class="prof-label">Permanent Address :</label>
                                                        </div>
                                                        <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                                            <div class="prof-outp">
                                                                <?php echo htmlentities((string)$profile->m_address1, ENT_QUOTES); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-21 col-sm-12 col-md-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                                            <label class="prof-label">Date of Birth :</label>
                                                        </div>
                                                        <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                                            <div class="prof-outp">
                                                                <?php
                                                                if ($profile->dob != null && !empty($profile->dob) && $profile->dob != '0000-00-00') {
                                                                    $profiledob = str_replace('/', '-', $profile->dob);
                                                                    $date = new DateTime($profiledob);
                                                                    echo $date_of_birth = $date->format('d-m-Y');
                                                                } else {
                                                                    echo 'N/A';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                                            <label class="prof-label">Chamber Address :</label>
                                                        </div>
                                                        <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                                            <div class="prof-outp">
                                                                <?php echo htmlentities((string)$profile->m_address2, ENT_QUOTES); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                                            <label class="prof-label">Mobile No. :</label>
                                                        </div>
                                                        <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                                            <div class="prof-outp">
                                                                <?php
                                                                if ($profile->moblie_number == '') {
                                                                    $moblie_number = '<span style="color:red;">' . htmlentities('Update Your Mobile No.', ENT_QUOTES) . '</span>';
                                                                } else {
                                                                    $moblie_number = htmlentities($profile->moblie_number, ENT_QUOTES);
                                                                }
                                                                echo $moblie_number;
                                                                ?>
                                                                <a href="<?= base_url('profile/updateProfile/contact'); ?>"><i class="fa fa-edit"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                                            <label class="prof-label">Email :</label>
                                                        </div>
                                                        <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                                                            <div class="prof-outp">
                                                                <?php
                                                                if (strpos($profile->emailid, '@')) {
                                                                    $emailid = htmlentities($profile->emailid, ENT_QUOTES);
                                                                } else {
                                                                    $emailid = '<span style="color:red;">' . htmlentities('Update Your Email ID ', ENT_QUOTES) . '</span>';
                                                                }
                                                                echo $emailid;
                                                                ?> 
                                                                <a href="<?= base_url('profile/updateProfile/email'); ?>"><i class="fa fa-edit"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Main End --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="<?= base_url() . 'assets/newAdmin/' ?>js/jquery-3.3.1.min.js"></script>
<script>
    $(document).ready(function() {
        $("#hide").click(function() {
            $("#update_new_adv_id").hide();
            $("#updating").show();
        });
        $("#reset").click(function() {
            $('#select2-hc_name-container').text('Select');
            $('#select2-hc_name-container').attr('title', 'Select');
            $('#hc_name').prop('selectedIndex', 0);
            $('#estab_list').val('');
            $('#select2-estab_list-container').text('Select');
            $('#select2-estab_list-container').attr('title', 'Select');
            $('#select2-st_id-container').text('Select State');
            $('#select2-st_id-container').attr('title', 'Select State');
            $('#st_id').prop('selectedIndex', 0);
            $('#select2-dt_district-container').text('Select District');
            $('#select2-dt_district-container').attr('title', 'Select District');
            $('#dt_district').prop('selectedIndex', 0);
            $('#hc_div_hide').show();
            $('#dt_div_hide').hide();
        });
        $("#show").click(function() {
            $("#update_new_adv_id").show();
            $("#updating").hide();
        });
        $("#show_profile_pic").click(function() {
            $("#profile_pic").show();
            $("#updating").hide();
        });
        $("#profile_pic_hide").click(function() {
            $("#profile_pic").hide();
            $("#updating").show();
        });
    });
</script>