
<div class="right_col" role="main">
    <div id="page-wrapper">
        <div class="clearfix"></div>
        <?php echo $this->session->flashdata('msg'); ?>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title" >
                        <div class="col-md-7 col-xs-6"><h2>
                                <?= $this->lang->line('profile'); ?>
                                <?php
                                if (!empty($profile[0])) {
                                    if ($profile[0]->ref_m_usertype_id == USER_ADVOCATE) {
                                        $user_type = '(' . $this->lang->line('advocate') . ')';
                                    } elseif ($profile[0]->ref_m_usertype_id == USER_IN_PERSON) {
                                        $user_type = '(' . $this->lang->line('party_in_person') . ')';
                                    }
                                    echo htmlentities($user_type, ENT_QUOTES);
                                }
                                ?>
                            </h2>
                        </div> 

                        <div class="col-md-1 col-xs-6" style="float:right;"><a class="btn btn-default btn-xs"  href="<?= base_url(); ?>profile/DefaultController/updateProfile/pass" style="float:right;"><?= $this->lang->line('change_password'); ?></a></div>
                        <div class="clearfix"></div>

                    </div>


                    <div class="x_content panel panel-default" style="padding-top: 5px;">

                        <?php //Start AOR only
                        if ($this->session->userdata['login']['ref_m_usertype_id']==USER_ADVOCATE && !empty($this->session->userdata['login']['aor_code']) && $this->session->userdata['login']['aor_code'] !=null) {?>

                            <div class="row">

                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-4 col-xs-6"><?= $this->lang->line('name'); ?>  :</label>
                                        <div class="col-md-8 col-xs-6">
                                            <?php
                                            //var_dump($AOR);
                                            if ($AOR['name'] == 'NULL' || $AOR['name'] == 'NA') {
                                                echo '';
                                            } else {
                                                echo htmlentities($AOR['title'].$AOR['name'], ENT_QUOTES);
                                            }
                                            ?></div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-4 col-xs-6">AOR Code :</label>
                                        <div class="col-md-8 col-xs-6"><?php
                                            if ($AOR['aor_code'] == 'NULL' || $AOR['aor_code'] == '0' || $AOR['aor_code'] == '') {
                                                echo '';
                                            } else {
                                                echo htmlentities($AOR['aor_code'], ENT_QUOTES);
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-4 col-xs-6"><?= $this->lang->line('gender'); ?> :</label>
                                        <div class="col-md-8 col-xs-6"><?php
                                            if ($AOR['sex']==1){$gender='Male';}elseif ($AOR['sex']==2){$gender='Female';}elseif ($AOR['sex']==3){$gender='Other';}elseif ($AOR['sex']=='M'){$gender='Male';}elseif ($AOR['sex']=='F'){$gender='Female';}elseif ($AOR['sex']=='O'){$gender='Other';}
                                            else{$gender='';}
                                            echo $gender;//htmlentities($profile[0]->gender, ENT_QUOTES);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-4 col-xs-6"><?= $this->lang->line('dob'); ?> :</label>
                                        <div class="col-md-8 col-xs-6"><?php
                                            if ($AOR['dob'] !=null && !empty($AOR['dob']) && $AOR['dob']!='0000-00-00') {
                                                $profiledob = str_replace('/', '-', $AOR['dob']);
                                                $date = new DateTime($profiledob);
                                                echo $date_of_birth= $date->format('d-m-Y');
                                            } else {
                                                echo 'N/A';
                                            }
                                           ?></div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-4 col-xs-6"><?= $this->lang->line('mobile'); ?> :</label>
                                        <div class="col-md-8 col-xs-6"><?php
                                            if ($AOR['mobile'] == '') {
                                                $mobile = '<span style="color:red;">' . htmlentities('Update Your Mobile No.', ENT_QUOTES) . '</span>';
                                            } else {
                                                $mobile = htmlentities($AOR['mobile'], ENT_QUOTES);
                                            } echo $mobile;
                                            ?>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-4 col-xs-6"><?= $this->lang->line('email'); ?> :</label>
                                        <div class="col-md-8 col-xs-6"><?php
                                            if (strpos($AOR['email'], '@')) {
                                                $email = htmlentities($AOR['email'], ENT_QUOTES);
                                            } else {
                                                $email = '<span style="color:red;">' . htmlentities('Update Your Email ID ', ENT_QUOTES) . '</span>';
                                            }
                                            echo $email;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-4 col-xs-6"><?= $this->lang->line('bar_reg_no'); ?> :</label>
                                        <div class="col-md-8 col-xs-6"><?php echo strtoupper(htmlentities($AOR['enroll_no'], ENT_QUOTES)); ?></div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-4 col-xs-6">Enroll. Date:</label>
                                        <div class="col-md-8 col-xs-6"><?php
                                            if ($AOR['enroll_date'] !=null && !empty($AOR['enroll_date']) && $AOR['enroll_date']!='0000-00-00') {
                                                echo ucwords(htmlentities(date("d-m-Y", strtotime($AOR['enroll_date'])), ENT_QUOTES));
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?></div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-4 col-xs-6">Permanent Address :</label>
                                        <div class="col-md-8 col-xs-6">
                                            <?php echo htmlentities($AOR['paddress'], ENT_QUOTES);?>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-4 col-xs-6">Chamber Address :</label>
                                        <div class="col-md-8 col-xs-6">
                                            <?php echo htmlentities($AOR['caddress'], ENT_QUOTES);?>
                                        </div>
                                    </div>

                                </div>
                            </div>



                        <?php   //End AOR only
                        }else{?>

                        <?php
                        $attribute = array('class' => 'form-horizontal form-label-left', 'name' => 'photo-form', 'id' => 'photo-form', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data');
                        echo form_open('profile/updatePhoto', $attribute);
                        ?> 

                        <div class="row"> 
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <img class="img-thumbnail img-responsive" src="<?php echo base_url() .htmlentities($profile[0]->photo_path, ENT_QUOTES); ?>" style="max-width: 100%; min-height: 100%;">

                                <div style="width: 80%;border: 1px solid #ddd;"> 
                                    <a class="" id="show_profile_pic"  maxlength="1" style="margin: 20px; color: green;"> <?= $this->lang->line('change_profile_pic'); ?> </a>
                                </div>
                            </div> 

                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="col-md-4 col-xs-6"><?= $this->lang->line('name'); ?>  :</label>
                                    <div class="col-md-8 col-xs-6"><?php echo htmlentities($profile[0]->first_name, ENT_QUOTES); ?> <?php
                                        if ($profile[0]->last_name == 'NULL' || $profile[0]->last_name == 'NA') {
                                            echo '';
                                        } else {
                                            echo htmlentities($profile[0]->last_name, ENT_QUOTES);
                                        }
                                        ?></div>
                                </div> 
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="col-md-4 col-xs-6"><?= $this->lang->line('gender'); ?> :</label>
                                    <div class="col-md-8 col-xs-6"><?php
                                        if ($profile[0]->gender==1){$gender='Male';}elseif ($profile[0]->gender==2){$gender='Female';}elseif ($profile[0]->gender==3){$gender='Other';}elseif ($profile[0]->gender=='M'){$gender='Male';}elseif ($profile[0]->gender=='F'){$gender='Female';}elseif ($profile[0]->gender=='O'){$gender='Other';}
                                        else{$gender='';}
                                        echo $gender;//htmlentities($profile[0]->gender, ENT_QUOTES);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="col-md-4 col-xs-6"><?= $this->lang->line('dob'); ?> :</label>
                                    <div class="col-md-8 col-xs-6"><?php
                                        if ($profile[0]->dob !=0) {
                                             $profiledob = str_replace('/', '-', $profile[0]->dob);
                                            $date = new DateTime($profiledob);
                                             echo $date_of_birth= $date->format('d-m-Y');
                                        }

                                     htmlentities(date("d-m-Y", strtotime($profile[0]->dob)), ENT_QUOTES); ?></div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="col-md-4 col-xs-6"><?= $this->lang->line('mobile'); ?> :</label>
                                    <div class="col-md-8 col-xs-6"><?php
                                        if ($profile[0]->moblie_number == '') {
                                            $mobile = '<span style="color:red;">' . htmlentities('Update Your Mobile No.', ENT_QUOTES) . '</span>';
                                        } else {
                                            $mobile = htmlentities($profile[0]->moblie_number, ENT_QUOTES);
                                        } echo $mobile;
                                        ?> 
                                        <a href="<?= base_url(); ?>profile/DefaultController/updateProfile/contact"><i class="fa fa-edit"></i></a>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="col-md-4 col-xs-6"><?= $this->lang->line('email'); ?> :</label>
                                    <div class="col-md-8 col-xs-6"><?php
                                        if (strpos($profile[0]->emailid, '@')) {
                                            $email = htmlentities($profile[0]->emailid, ENT_QUOTES);
                                        } else {
                                            $email = '<span style="color:red;">' . htmlentities('Update Your Email ID ', ENT_QUOTES) . '</span>';
                                        }
                                        echo $email;
                                        ?> 
                                        <a href="<?= base_url(); ?>profile/DefaultController/updateProfile/email"><i class="fa fa-edit"></i></a>
                                    </div>
                                </div> 
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12"> 
                                <?php //if ($profile[0]->ref_m_usertype_id != USER_IN_PERSON) { ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-4 col-xs-6"><?= $this->lang->line('bar_reg_no'); ?> :</label>
                                        <div class="col-md-8 col-xs-6"><?php echo strtoupper(htmlentities($profile[0]->bar_reg_no, ENT_QUOTES)); ?></div>
                                    </div>  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-4 col-xs-6"><?= $this->lang->line('office_address'); ?> :</label>
                                        <div class="col-md-8 col-xs-6"><?php
                                            if ($profile[0]->m_address1 != '') {
                                                $address1 = ', ' . $profile[0]->m_address1;
                                            }
                                            if ($profile[0]->office_distt_name != '') {
                                                $dist_name = ', ' . $profile[0]->office_distt_name;
                                            }
                                            if ($profile[0]->alt_city != '') {
                                                $state_name = ', ' . $profile[0]->alt_city;
                                            }
                                            if ($profile[0]->alt_pincode != '') {
                                                $pincode = '- ' . $profile[0]->alt_pincode;
                                            } else {
                                                $pincode = ', N/A';
                                            }

                                            echo htmlentities(ucwords($profile[0]->m_address1 . $dist_name . $state_name . $pincode), ENT_QUOTES);
                                            ?></div>
                                    </div>
                                <?php //} ?>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="col-md-4 col-xs-6"><?= $this->lang->line('res_address') ?> :</label>
                                    <div class="col-md-8 col-xs-6"><?php
                                        if ($profile[0]->ref_m_usertype_id == USER_ADVOCATE) {
                                            if ($profile[0]->m_address1 != '') {
                                                $address = $profile[0]->m_address1;
                                            } else {
                                                $address = ' N/A';
                                            }
                                        }
                                        if ($profile[0]->ref_m_usertype_id == USER_IN_PERSON) {
                                            if ($profile[0]->m_address2 != '') {
                                                $address = $profile[0]->m_address2;
                                            } else {
                                                $address = ' N/A';
                                            }
                                        }
                                        if ($profile[0]->resi_distt_name != '' || $profile[0]->resi_distt_name != NULL) {
                                            $dist_name = ', ' . $profile[0]->resi_distt_name;
                                        } else {
                                            $dist_name = ', N/A';
                                        }
                                        if ($profile[0]->m_city != NULL) {
                                            $state_name = ', ' . $profile[0]->m_city;
                                        } else {
                                            $state_name = ', N/A';
                                        }
                                        if ($profile[0]->m_pincode != '' && $profile[0]->m_pincode != 0) {
                                            $pincode = ',' . $profile[0]->m_pincode;
                                        } else {
                                            $pincode = ', N/A';
                                        }
                                        if (!empty($profile[0]->resi_distt_name != '')) {
                                            echo htmlentities(ucwords(strtoupper($address . $dist_name . $state_name . $pincode)), ENT_QUOTES);
                                        } else {
                                            echo htmlentities('N/A', ENT_QUOTES);
                                        }
                                        ?></div>
                                </div>
                                <?php if ($profile[0]->ref_m_usertype_id == USER_ADVOCATE || $profile[0]->ref_m_usertype_id == USER_IN_PERSON) { ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-4 col-xs-6"><?= $this->lang->line('request_on'); ?>:</label>
                                        <div class="col-md-8 col-xs-6"><?php
                                            if ($profile[0]->created_datetime) {
                                                echo ucwords(htmlentities(date("d-m-Y h:i:s A", strtotime($profile[0]->created_datetime)), ENT_QUOTES));
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?></div>
                                    </div>  
                                <?php } ?>
                            </div>   
                        </div>                      

                        <?php echo form_close(); ?>

                        <?php }?>
                        <div class="clearfix"></div>

                        <?php if (!empty($_SESSION['image_and_id_view'])) { ?> 
                            <?php if ($_SESSION['profile_photo'] == 'UPDATE PHOTO') { ?>
                                <div class="col-md-12 col-sm-12 col-xs-12 text-center"> 
                                <?php } ?>
                                <?php if ($_SESSION['profile_photo'] != 'UPDATE PHOTO') { ?>
                                    <div class="col-md-4 col-sm-4 col-xs-12 text-center ">
                                    <?php } ?> 
                                    <?php
                                    $img = $_SESSION['image_and_id_view'];
                                    if ($img != '') {
                                        ?>
                                        <?php if ($_SESSION['profile_photo'] == 'UPDATE PHOTO') { ?>
                                            <img src="<?php echo htmlentities($img['profile_photo'], ENT_QUOTES); ?>" alt="..." class="img-thumbnail expand-img" style="width: 20%; height: 40%;">
                                        <?php } ?>

                                        <?php if ($_SESSION['profile_photo'] != 'UPDATE PHOTO') { ?>
                                            <img src="<?php echo htmlentities($img['profile_photo'], ENT_QUOTES); ?>" alt="..." class="img-thumbnail expand-img" style="width: 80%; height: 40%;">
                                        <?php } ?>
                                        <h4><i class="fa fa-image "></i> Profile Image </h4>        
                                    <?php } ?>
                                </div>


                            </div>
                            <!-- update profile-->
                            <?php if ($account_status[0]->account_status != ACCOUNT_STATUS_OBJECTION && $account_status[0]->account_status != ACCOUNT_STATUS_ACTIVE_BUT_OBJ) { ?>
                                <?php
                                $attribute = array('class' => 'form-horizontal form-label-left', 'name' => 'advocate_login_uploads', 'id' => 'advocate_login_uploads', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data');
                                echo form_open('profile/DefaultController/updateProfile_adv', $attribute);
                                ?>
                                <input type="hidden" id="photo_path" name="photo_path" value="<?php echo url_encryption($img['profile_photo']); ?>">
                                <input type="hidden" id="thumb_path" name="thumb_path" value="<?php echo url_encryption($img['profile_thumbnail']); ?>">
                                <input type="hidden" id="id_proof_path" name="id_proof_path" value="<?php echo url_encryption($img['id_proof_photo']); ?>">
                                <input type="hidden" id="bar_reg_certificate" name="bar_reg_certificate" value="<?php echo url_encryption($img['bar_reg_certificate']); ?>">
                                <br><br><br><?php if ($_SESSION['image_and_id_view']) { ?>
                                    <center>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <button type="submit" id="upload" class="btn btn-success btn-xs">FINAL UPLOAD</button>
                                            <a  id="upload" href="<?php echo base_url('profile/DefaultController/unset_upload') ?>" class="btn btn-danger btn-xs ">CANCEL</a>
                                        </div>
                                    </center>
                                <?php } ?>
                                <?php echo form_close(); ?> 
                            <?php } ?>
                            <!--end update profile-->

                            <!--  cure objection update profile-->
                            <?php if ($account_status[0]->account_status == ACCOUNT_STATUS_OBJECTION || $account_status[0]->account_status == ACCOUNT_STATUS_ACTIVE_BUT_OBJ) { ?>
                                <?php
                                $attribute = array('class' => 'form-horizontal form-label-left', 'name' => 'advocate_login_uploads', 'id' => 'advocate_login_uploads', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data');
                                echo form_open('profile/DefaultController/updateProfile_adv', $attribute);
                                ?>
                                <input type="hidden" name="account_status_remarks" value="<?php echo htmlentities(url_encryption($account_status[0]->status_update_remark), ENT_QUOTES); ?>">
                                <?php
                                foreach ($show_estab as $value) {
                                    if ($value->request_type == ACCOUNT_REQUEST_PRACTICE_PLACE ||
                                            ($value->request_type == ACCOUNT_REQUEST_EXISTS_BUT_UPDATE && $value->request_status == ACCOUNT_REQUEST_STATUS_ACTIVE_BUT_OBJ)) {
                                        echo '<input type="hidden" name="estab_code" value="' . htmlentities(url_encryption($value->estab_code), ENT_QUOTES) . '">';
                                    }
                                }
                                ?>
                                <input type="hidden" id="thumb_path" name="thumb_path" value="<?php echo htmlentities(url_encryption($img['profile_thumbnail']), ENT_QUOTES); ?>">
                                <input type="hidden" id="id_proof_path" name="id_proof_path" value="<?php echo htmlentities(url_encryption($img['id_proof_photo']), ENT_QUOTES); ?>">
                                <input type="hidden" id="bar_reg_certificate" name="bar_reg_certificate" value="<?php echo htmlentities(url_encryption($img['bar_reg_certificate']), ENT_QUOTES); ?>">
                                <br><br><br><?php if ($_SESSION['image_and_id_view']) { ?>
                                    <center>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <?php if ($account_status[0]->account_status == ACCOUNT_STATUS_OBJECTION) { ?>
                                                <button type="submit" id="upload" name="cure_objection" class="btn btn-success btn-xs" value="cure_objection">FINAL UPLOAD</button>
                                            <?php } ?>
                                            <?php if ($account_status[0]->account_status == ACCOUNT_STATUS_ACTIVE_BUT_OBJ) { ?>
                                                <button type="submit" id="upload" name="cure_objection_but_update" class="btn btn-success btn-xs" value="cure_objection_but_update">FINAL UPLOAD</button>
                                            <?php } ?>
                                            <a  id="upload" href="<?php echo base_url('profile/DefaultController/unset_upload') ?>" class="btn btn-danger btn-xs ">CANCEL</a>
                                        </div>
                                    </center>
                                <?php } ?>
                                <?php echo form_close(); ?>  
                                <?php
                            }
                        }
                        ?>

                    </div>

                    <div id="profile_pic" style="display:none;">
                        <div style="color:#f3441c" class="col-md-offset-1"> 
                            <center><p>NOTE : Please upload only JPG or JPEG. File name maximun length can be 40 characters including digits characters, spaces, hypens and underscore. maximum file size 1MB.</p></center>
                        </div><hr>
                        <?php
                        $attribute = array('class' => 'form-horizontal form-label-left', 'name' => 'advocate_login_uploads', 'id' => 'advocate_login_uploads', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data');
                        echo form_open('profile/DefaultController/uploadPhoto', $attribute);
                        ?>
                        <center>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?= $this->lang->line('choose_profile_pic'); ?>  <br><br>
                                    <div class="input-group">   
                                        <input id="advocate_image" required name="advocate_image" placeholder="Profile Image" maxlength="50" class="form-control input-sm" type="file">
                                        <span style="color: red;"><?php echo form_error('advocate_image'); ?></span>
                                    </div> 
                                </div>
                            </div>  
                            <input class="btn btn-success btn-xs" name="profile_pic_upload_id" type="submit" value="UPDATE PHOTO">
                            <a class="btn btn-danger btn-xs" id="profile_pic_hide">Cancel </a>
                        </center>
                        <?php echo form_close(); ?> 
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<script>
    $(document).ready(function () {
        $("#hide").click(function () {
            $("#update_new_adv_id").hide();
            $("#updating").show();
        });
        $("#reset").click(function () {
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
        $("#show").click(function () {
            $("#update_new_adv_id").show();
            $("#updating").hide();
        });
        $("#show_profile_pic").click(function () {
            $("#profile_pic").show();
            $("#updating").hide();
        });
        $("#profile_pic_hide").click(function () {
            $("#profile_pic").hide();
            $("#updating").show();
        });
    });

</script> 