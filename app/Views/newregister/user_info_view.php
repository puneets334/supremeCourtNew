<?php

?>
<div class="right_col" role="main">
    <div id="page-wrapper">
        <div class="clearfix"></div>
        <?php echo $this->session->flashdata('msg'); ?>
        <div id="msg">
            <?php
            if (isset($_SESSION['MSG']) && !empty($_SESSION['MSG'])) {
                echo $_SESSION['MSG'];
            } unset($_SESSION['MSG']);
            ?>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title" >
                        <div class="col-md-7 col-xs-6"><h2><?= $this->lang->line('profile'); ?>  <?php
                                if (!empty($profile[0])) {
                                    if ($profile[0]->ref_m_usertype_id == USER_ADVOCATE) {
                                        $user_type = '(' . $this->lang->line('advocate') . ')';
                                    } elseif ($profile[0]->ref_m_usertype_id == USER_IN_PERSON) {
                                        $user_type = '(' . $this->lang->line('party_in_person') . ')';
                                    }
                                    echo htmlentities($user_type, ENT_QUOTES);
                                }
                                ?></h2>
                        </div> 


                        <div class="clearfix"></div>

                    </div>


                    <div class="x_content panel panel-default" style="padding-top: 5px;">
                        <?php
                        $attribute = array('class' => 'form-horizontal form-label-left', 'name' => 'photo-form', 'id' => 'photo-form', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data');
                        echo form_open('profile/updateProfile_adv', $attribute);
                        ?>  
                        <div class="row"> 
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <img class="img-thumbnail img-responsive" src="<?php echo htmlentities($profile[0]->photo_path, ENT_QUOTES); ?>" style="max-width: 100%; min-height: 100%;">


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
                                    <div class="col-md-8 col-xs-6"><?php echo htmlentities($profile[0]->gender, ENT_QUOTES); ?></div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="col-md-4 col-xs-6"><?= $this->lang->line('dob'); ?> :</label>
                                    <div class="col-md-8 col-xs-6"><?php echo ucwords(htmlentities(date("d-m-Y", strtotime($profile[0]->dob)), ENT_QUOTES)); ?></div>
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
                                        if ($profile[0]->m_pincode != '') {
                                            $pincode = '- ' . $profile[0]->m_pincode;
                                        } else {
                                            $pincode = ', N/A';
                                        }

                                        echo strtoupper(htmlentities(ucwords($profile[0]->m_address1 . ' , ' . $profile[0]->m_city . $pincode), ENT_QUOTES));
                                        ?></div>
                                </div>
                                <?php //} ?>

                                <?php if ($profile[0]->ref_m_usertype_id == USER_ADVOCATE || $profile[0]->ref_m_usertype_id == USER_IN_PERSON) { ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-4 col-xs-6"><?= $this->lang->line('request_on'); ?>:</label>
                                        <div class="col-md-8 col-xs-6"><?php
                                            if ($profile[0]->created_on) {
                                                echo ucwords(htmlentities(date("d-m-Y h:i:s A", strtotime($profile[0]->created_on)), ENT_QUOTES));
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?></div>
                                    </div>  
                                <?php } ?>
                            </div>   
                        </div>                      

                        <?php echo form_close(); ?>

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
                                            <img src="<?php echo htmlentities($img['profile_thumbnail'], ENT_QUOTES); ?>" alt="..." class="img-thumbnail expand-img" style="width: 20%; height: 40%;">
                                        <?php } ?>

                                        <?php if ($_SESSION['profile_photo'] != 'UPDATE PHOTO') { ?>
                                            <img src="<?php echo htmlentities($img['profile_thumbnail'], ENT_QUOTES); ?>" alt="..." class="img-thumbnail expand-img" style="width: 80%; height: 40%;">
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

                    <div class="clearfix"></div>
                    <center>
                        <?php
                        if ($profile[0]->is_active == 0) { ?>
                            <div class="alert alert-danger" style="background: #f2dede;border: #f2dede;color: black;">DEACTIVATED</div>
                        <?php } ?>
                        <?php if ($profile[0]->is_active == 1) { ?>
                            <div class="alert alert-success" style="background: rgba(176, 241, 227, 0.88);border: #f2dede;color: black;">ACTIVATED</div>

                        <?php } ?>
                    </center>
                    <center>
                        <a href="<?= base_url('newRegister/Advocate/activate/') ?><?php echo htmlentities(trim($this->uri->segment(4)), ENT_QUOTES); ?>" class="btn btn-success">APPROVE</a>
                        <a href="<?= base_url('newRegister/Advocate/deactivate/') ?><?php echo htmlentities(trim($this->uri->segment(4)), ENT_QUOTES); ?>" class="btn btn-danger">DEACTIVATE</a>
                    </center>

                </div>
            </div>
        </div>
    </div>
</div> 