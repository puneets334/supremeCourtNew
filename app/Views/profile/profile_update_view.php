<style>
    .tool_tip{
        z-index:10;display:none; padding:15px 10px 10px 10px;
        margin-top:-12px; margin-left:28px;
        width:300px; line-height:20px;
        position:absolute; color:#111;
        border:1px solid #fa8605; background:#ffffff;
        FONT-SIZE: 12px;
        font-family: Verdana;
        color: black;
    }
.error{color: red;}
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
            </div>
        </div>
        <!--<div class="form-response" id="msg"> </div>-->

        <?php echo $this->session->flashdata('msg'); ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-12">
                            <div class="col-md-2">
                                <h2>Profile </h2>
                            </div>
                            <?php if (isset($updatedata) && $updatedata == 'estab') { ?>
                                <div class="col-md-9">
                                    <h4>Add establishments where advocate wants to get update and add his information in Court software (CIS)</h4>
                                </div>
                                <div class="col-md-1">
                                    <a href="<?php echo base_url('profile/DefaultController'); ?>">
                                        <input type="button" class="btn btn-success right" id="" name="" value="Back" style="float:right;">
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php if (isset($updatedata) && $updatedata == 'pass') { ?>
                        <div class="x_content">
                            <div  id="msgforce" style="display:none;">
                                <div class="alert alert-danger text-center flashmessage" data-auto-dismiss="9000">The New Password must contain atleast 1 Special Character, 1 Digit, 1 lower case Character, 1 Upper Case Character and atleast 8 digit length</div>
                            </div>
                            <br />
                             <?php
                             $attribute = array('class' => 'form-horizontal form-label-left', 'name' => 'pass_update_form', 'id' => 'pass_update_form', 'autocomplete' => 'off');
                             echo form_open('profile/DefaultController/updatePass', $attribute);
                             ?>
                            <input type="hidden" name="salt" id="salt" value="<?=base64_encode(openssl_random_pseudo_bytes(32))?>">
                            <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="currentpass"><?= $this->lang->line('curr_pass'); ?> <span style="color: red">*</span> :</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="currentpass" type="password" name="currentpass" autocomplete="off" placeholder="<?= $this->lang->line('curr_pass'); ?>"  class="form-control col-md-7 col-xs-12" required>
                                    <span class="text-danger"><?php echo form_error('currentpass'); ?></span>
                                </div>
                            </div>
                                <input id="txt_password" name="txt_password" type="hidden">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="newpass"><?= $this->lang->line('new_pass'); ?> <span style="color: red">*</span> :</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group">
                                        <input id="newpass"  type="password" name="newpass" autocomplete="off" placeholder="<?= $this->lang->line('new_pass'); ?>"  class="form-control col-md-7 col-xs-12 newpassword" required>
                                        <span class="text-danger"><?php echo form_error('newpass'); ?></span>
                                        <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Password should be minimum 8 characters. It contain 1 Upper case, 1 special character and 1 number.(eg. Qwerty@123).">
                                            <i class="fa fa-question-circle-o" ></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirmpass"><?= $this->lang->line('confirm_pass'); ?> <span style="color: red">*</span> :</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="confirmpass" type="password" name="confirmpass" autocomplete="off" placeholder="<?= $this->lang->line('confirm_pass'); ?>" class="form-control col-md-7 col-xs-12" required>
                                    <span class="text-danger"><?php echo form_error('confirmpass'); ?></span>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                                    <button class="btn btn-primary" type="button" onclick="goback();">Cancel</button>
                                    <button type="submit" name="update_pass" id="update_pass" class="btn btn-success">Update</button>
                                </div>
                            </div>
                            </div>
                                <div class="col-md-4">
                                    <span id="newpass_sms"></span>
                                   <span id="d1" class="tool_tip">
                                    <span id=d12>One Upper case letter</span><br>
                                    <span id=d13>One Lower case letter</span><br>
                                    <span id=d14>One Special char</span><br>
                                    <span id=d15>One number</span><br>
                                    <span id=d16>Length 8  char</span>

                                    </span><!--<br><div id=display_box class=msg>--></div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                    <?php } elseif (isset($updatedata) && $updatedata == 'email') { ?>
                        <div class="x_content">
                            <br />
                            <?php
                            $this->session->unset_userdata('email_otp');
                            $this->session->unset_userdata('email_id_for_updation');
                            $attribute = array('class' => 'form-horizontal form-label-left', 'name' => 'email_update_form', 'id' => 'email_update_form', 'autocomplete' => 'off');
                            echo form_open('profile/DefaultController/updateEmail', $attribute);
                            ?>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="emailid"><?= $this->lang->line('new') . " " . $this->lang->line('email_id'); ?> <span style="color: red">*</span> : </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="emailid" type="email" name="emailid" maxlength="50" placeholder="<?= $this->lang->line('new') . " " . $this->lang->line('email_id') ?>" required="required" class="form-control col-md-7 col-xs-12">
                                    <span class="text-danger"><?php echo form_error('emailid'); ?></span>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-primary" type="button" onclick="goback();">Cancel</button>
                                    <button type="submit" name="update_email" class="btn btn-success">Update</button>
                                </div>
                            </div>

                            <?php echo form_close(); ?>
                        </div>
                    <?php } elseif (isset($updatedata) && $updatedata == 'contact') { ?>
                        <div class="x_content">
                            <br />
                            <?php
                            $this->session->unset_userdata('mobile_otp');
                            $this->session->unset_userdata('mobile_no_for_updation');
                            $attribute = array('class' => 'form-horizontal form-label-left', 'name' => 'contact_update_form', 'id' => 'contact_update_form', 'autocomplete' => 'off');
                            echo form_open('profile/DefaultController/updateContact', $attribute);
                            ?>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="moblie_number"><?= $this->lang->line('new') . " " . $this->lang->line('mobile_no'); ?> <span style="color: red">*</span> : </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="moblie_number" type="text" maxlength="10" name="moblie_number"  placeholder="<?= $this->lang->line('new') . " " . $this->lang->line('mobile_no'); ?>" required="required" class="form-control col-md-7 col-xs-12">
                                    <span class="text-danger"><?php echo form_error('moblie_number'); ?></span>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-primary" type="button" onclick="goback();">Cancel</button>
                                    <button type="submit" name="update_contact" class="btn btn-success">Update</button>
                                </div>
                            </div>

                            <?php echo form_close(); ?>
                        </div>
                    <?php } elseif (isset($updatedata) && $updatedata == 'address') { ?>
                        <div class="x_content">
                            <br />
                            <?php
                            $attribute = array('class' => 'form-horizontal form-label-left', 'name' => 'address_update_form', 'id' => 'address_update_form', 'autocomplete' => 'off');
                            echo form_open('profile/DefaultController/updateAddress', $attribute);
                            ?>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address1">Address1 <span style="color: red">*</span> : </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="address1" type="text" name="address1" value="<?php echo htmlentities($profile[0]->address1, ENT_QUOTES); ?>" required="required" class="form-control col-md-7 col-xs-12">
                                    <span class="text-danger"><?php echo form_error('address1'); ?></span>
                                </div>
                            </div>
                            <?php if ($profile[0]->address2 != '') { ?>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address2">Address2 : </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="address2" type="text" name="address2" value="<?php echo htmlentities($profile[0]->address2, ENT_QUOTES); ?>"  class="form-control col-md-7 col-xs-12">
                                        <span class="text-danger"><?php echo form_error('address2'); ?></span>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($profile[0]->city != 'NA' || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK || $_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT) { ?>


                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">City <span style="color: red">*</span> : </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="city" type="text" name="city" value="<?php echo htmlentities($profile[0]->city, ENT_QUOTES); ?>" required="required" class="form-control col-md-7 col-xs-12">
                                        <span class="text-danger"><?php echo form_error('city'); ?></span>
                                    </div>
                                </div>
                                <?php if ($this->session->userdata['login']['ref_m_usertype_id'] != USER_CLERK && $this->session->userdata['login']['ref_m_usertype_id'] != USER_DEPARTMENT) {
                                    ?>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">State  <span style="color: red">*</span> : </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  id="ref_m_states_id" name="ref_m_states_id" required="required" class="form-control col-md-7 col-xs-12">
                                                <option disabled="disabled" selected="selected">Select State</option>
                                                <?php
                                                $CI = & get_instance();
                                                $CI->load->model('Register_model');
                                                $states = $CI->Register_model->get_all_states();
                                                foreach ($states as $state) {
                                                    if ($state->state_id == $profile[0]->ref_m_states_id) {
                                                        $select = 'selected="Selected"';
                                                    } else {
                                                        $select = '';
                                                    }
                                                    echo '<option ' . $select . ' value="' . htmlentities(url_encryption(trim($state->state_id), ENT_QUOTES)) . '">' . htmlentities($state->state, ENT_QUOTES) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>

                            <?php if ($profile[0]->njdg_st_name != NULL && $profile[0]->njdg_dist_name != NULL || $_SESSION['login']['ref_m_usertype_id'] == USER_CLERK || $_SESSION['login']['ref_m_usertype_id'] == USER_DEPARTMENT) { ?>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">State  <span style="color: red">*</span> : </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  id="njdg_m_states_id" name="njdg_m_states_id" required="required" class="form-control col-md-7 col-xs-12">
                                            <option disabled="disabled" selected="selected">Select State</option>
                                            <?php
                                            foreach ($state_list as $dataRes) {
                                                foreach ($dataRes->state as $state) {
                                                    if ($state->state_code == $profile[0]->njdg_st_id) {
                                                        $selected = 'selected';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    echo '<option ' . $selected . ' value="' . htmlentities(url_encryption($state->state_code . '#$' . $state->state_name), ENT_QUOTES) . '">' . htmlentities(strtoupper($state->state_name), ENT_QUOTES) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">District  <span style="color: red">*</span> : </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  id="njdg_m_dist_id" name="njdg_m_dist_id" required="required" class="form-control col-md-7 col-xs-12">
                                            <option disabled="disabled" selected="selected">Select District</option>
                                            <?php
                                            foreach ($district as $dataRes) {
                                                foreach ($dataRes->district as $district) {
                                                    if ($profile[0]->njdg_dist_id == $district->dist_code) {
                                                        $sel = 'selected=selected';
                                                    } else {
                                                        $sel = "";
                                                    }
                                                    echo '<option  ' . htmlentities($sel, ENT_QUOTES) . ' value="' . htmlentities(url_encryption($district->dist_code . '#$' . $district->dist_name), ENT_QUOTES) . '">' . htmlentities($district->dist_name, ENT_QUOTES) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pincode">Pincode <span style="color: red">*</span> : </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="pincode" type="text" name="pincode" maxlength="6" value="<?php echo htmlentities($profile[0]->pincode, ENT_QUOTES); ?>" required="required" class="form-control col-md-7 col-xs-12">
                                    <span class="text-danger"><?php echo form_error('pincode'); ?></span>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-primary" type="button" onclick="goback();">Cancel</button>
                                    <button type="submit" name="update_address" class="btn btn-success">Update</button>
                                </div>
                            </div>

                            <?php echo form_close(); ?>
                        </div>

                    <?php } elseif (isset($updatedata) && $updatedata == 'estab') { ?>
                        <div class="x_content">
                            <br />
                            <?php
                            $attribute = array('class' => 'form-horizontal form-label-left', 'name' => 'adv_establishment', 'id' => 'adv_establishment', 'autocomplete' => 'off');
                            echo form_open('#', $attribute);
                            ?>
                            <input type="hidden" value="<?php url_encryption(print_r($_SESSION['data_arrays'])); ?>" id="posted_array" name="posted_array">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-12 col-xs-12 input-sm"> State <span style="color: red">*</span>:</label>
                                        <div class="col-md-5 col-sm-12 col-xs-12">
                                            <select name="a_state_id" required id="a_state_id" required class="form-control input-sm filter_select_dropdown">
                                                <option value="" title="Select">Select State</option>
                                                <?php
                                                if (count($state_list)) {
                                                    foreach ($state_list as $dataRes) {
                                                        foreach ($dataRes->state as $state) {
                                                            if (url_encryption($state->state_code . '#$' . $state->state_name) == $posted_state_id) {
                                                                $selected = 'selected';
                                                            } else {
                                                                $selected = '';
                                                            }
                                                            echo '<option ' . $selected . ' value="' . htmlentities(url_encryption($state->state_code . '#$' . $state->state_name), ENT_QUOTES) . '">' . htmlentities(strtoupper($state->state_name), ENT_QUOTES) . '</option>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-12 col-xs-12 input-sm"> District <span style="color: red">*</span> :</label>
                                        <div class="col-md-5 col-sm-12 col-xs-12">
                                            <select name="a_district" required id="a_district" required class="form-control input-sm filter_select_dropdown">
                                                <option value="" title="Select">Select District</option>
                                                <?php
                                                foreach ($district_list as $dataRes) {
                                                    foreach ($dataRes->district as $district) {
                                                        if (url_encryption($district->dist_code . '#$' . $district->dist_name) == $posted_district_id) {
                                                            $selected = 'selected';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        echo '<option ' . $selected . ' value="' . htmlentities(url_encryption($district->dist_code . '#$' . $district->dist_name), ENT_QUOTES) . '">' . htmlentities(strtoupper($district->dist_name), ENT_QUOTES) . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="hc_case_type_list">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12 input-sm" for="case-type">  Select Establishment <span style="color: red">*</span> :</label>
                                    <table>
                                        <tr>
                                            <td>
                                                <select id="mySelect1" size="10" multiple style="width:350px">
                                                    <option value="" disabled="disabled">Select</option>
                                                </select>
                                            </td>
                                            <td valign="center">
                                                <button type="button" id="toRight">►</button><br/>
                                                <button type="button" id="toLeft">◄</button>
                                            </td>
                                            <td>
                                                <select name="more_establishment[]" id="mySelect2" size="10" multiple="multiple" selected style="width:350px">
                                                    <option value="" disabled="disabled">Select</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-0">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-9 col-sm-12 col-xs-12 input-sm"></label>
                                        <div class="col-md-3 col-sm-12 col-xs-12 floatclass-r">
                                            <div class="input-group floatclass-r">
                                                <span class="captcha-img"> <?php echo $captcha['image']; ?></span>
                                                <span><img src="<?php echo base_url('assets/images/refresh.png') ?>" height="20px" width="20px"  alt="refresh" class="refresh_cap_adv_reg" /></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <div class="input-group floatclass-l">
                                                <input id="captcha" name="captcha" value="<?php echo $captcha['word']; ?>" placeholder="Captcha" maxlength="6" class="form-control input-sm" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-2 col-sm-6 col-xs-12 col-md-offset-5">
                                    <input type="submit" class="btn btn-success" id="add_more_esta" value="Add">
                                    </a>
                                </div>
                            </div>
                            <br><br>
                            <?php if (isset($_SESSION['data_arrays']) && !empty($_SESSION['data_arrays'])) { ?>
                                <h4>List of Establishments where advocate wants to be registered </h4>
                                <div role="main" style="min-height: 0px !important; width: 100%;">
                                    <div class="delete-response" id="msg_delete"> </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">


                                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr class="success input-sm" >
                                                        <th>#</th>
                                                        <th>State</th>
                                                        <th>District</th>
                                                        <th>Establishment</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
                                                        $sort_col = array();
                                                        foreach ($arr as $key => $row) {
                                                            $sort_col[$key] = $row[$col];
                                                        }
                                                        array_multisort($sort_col, $dir, $arr);
                                                    }

                                                    $print_data = $_SESSION['data_arrays'];
                                                    array_sort_by_column($print_data, 'st_name');
                                                    $increment_id = 1;
                                                    foreach ($print_data as $pd) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo htmlentities($increment_id++, ENT_QUOTES); ?> </td>
                                                            <td><?php echo htmlentities(strtoupper($pd['st_name']), ENT_QUOTES); ?></td>
                                                            <td><?php echo htmlentities(strtoupper($pd['dist_name']), ENT_QUOTES); ?></td>
                                                            <td><?php echo htmlentities(strtoupper($pd['estab_name']), ENT_QUOTES); ?> ( <?php echo htmlentities(strtoupper($pd['estab_code']), ENT_QUOTES); ?> )</td>
                                                            <td></td>
                                                            <td><button type="button" name="del_array_data" class="btn btn-danger btn-xs del_array_data" id="<?php echo $i++; ?>" value="<?php echo htmlentities($pd['st_code'], ENT_QUOTES) . htmlentities($pd['dist_code'], ENT_QUOTES) . htmlentities($pd['estab_code'], ENT_QUOTES); ?>"><i class="fa fa-trash"></i> Delete</button></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php } echo form_close(); ?>

                            <div class="col-md-12">
                                <?php
                                $attribute = array('class' => 'form-horizontal form-label-left', 'name' => 'sadv_establishment', 'id' => 'sadv_establishment', 'autocomplete' => 'off');
                                echo form_open('profile/DefaultController/add_estab_profile', $attribute);
                                ?>
                                <input type="hidden" value="<?php url_encryption(print_r($_SESSION['data_arrays'])); ?>" id="posted_array" name="posted_array">
                                <?php if (!empty($_SESSION['data_arrays']) && isset($_SESSION['data_arrays'])) { ?>
                                    <div class="form-group">
                                        <div class="col-md-2 col-sm-6 col-xs-12 col-md-offset-5">
                                            <input type="submit" class="btn btn-success" id="add_more_esta" value="Save">
                                            </a>
                                        </div>
                                    </div>
                                <?php } echo form_close(); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($email_otp)) { ?>
                        <div class="x_content">
                            <br />
                            <?php
                            $attribute = array('class' => 'form-horizontal form-label-left', 'name' => 'email_otp_form', 'id' => 'email_otp_form', 'autocomplete' => 'off');
                            echo form_open('profile/DefaultController/emailSave', $attribute);
                            ?>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email_otp"> </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php
                                    $email = explode('@', $emailid);
                                    $sub_email_id = substr($email[0], 0, 2) . "*****@" . $email[1];
                                    ?>
                                    <span class="fa fa-check-circle"> One Time Password (OTP) has been sent to your email : <b><?php echo $sub_email_id; ?> </b></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email_otp">Mail OTP <span style="color: red">*</span> : </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="email_otp" type="text" name="email_otp" maxlength="6" placeholder="Enter your six digit OTP" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-primary" type="button" onclick="goback();">Cancel</button>
                                    <button type="submit" name="email_save" class="btn btn-success">Verify OTP.</button>
                                </div>
                            </div>

                            <?php echo form_close(); ?>
                        </div>
                    <?php } elseif (isset($mobile_otp)) { ?>
                        <div class="x_content">
                            <br />
                            <?php
                            $attribute = array('class' => 'form-horizontal form-label-left', 'name' => 'mobile_otp_form', 'id' => 'mobile_otp_form', 'autocomplete' => 'off');
                            echo form_open('profile/DefaultController/mobileSave', $attribute);
                            ?>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mobile_otp"> </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <span class="fa fa-check-circle"> One Time Password (OTP) has been sent to your mobile :<b><?php echo '******' . substr($moblie_number, 6, 4); ?></b></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mobile_otp">Mobile OTP <span style="color: red">*</span> :
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="email_otp" type="text" name="mobile_otp" maxlength="6" placeholder="Enter your six digit OTP" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-primary" type="button" onclick="goback();">Cancel</button>
                                    <button type="submit" name="mobile_save" class="btn btn-success">Verify OTP</button>
                                </div>
                            </div>

                            <?php echo form_close(); ?>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<!--<script src='https://www.google.com/recaptcha/api.js?render=6LfE13AUAAAAACYtRe104ECi3APlECcyJfbH3VrV'></script>-->
<script src='<?=base_url("/assets/js/aes.js")?>'></script>
<script src='<?=base_url("/assets/js/aes-json-format.js")?>'></script>
<script type="text/javascript">
    function dataEncrypt(val,pass){
        return CryptoJS.AES.encrypt(JSON.stringify(val), pass, {format: CryptoJSAesJson}).toString();
    }
    $(function(){
        //grecaptcha.ready(function () {
            $("#pass_update_form").one('submit', function (e) {
                var form = this;
                e.preventDefault();
                var pass = $('[name="newpass"]').val();
                var salt=document.getElementById("salt").value;
                var txtpass=pass+'hgtsd12@_hjytr'+salt;
                for(var i=0;i<10;i++) {
                    txtpass = dataEncrypt(txtpass, salt);
                }
                $('#txt_password').val(txtpass);
                $('[name="currentpass"]').val(sha256($('[name="currentpass"]').val()) + '<?= $_SESSION['login_salt'] ?>');
                $('[name="newpass"]').val(sha256($('[name="newpass"]').val()) + '<?= $_SESSION['login_salt'] ?>');
                $('[name="confirmpass"]').val(sha256($('[name="confirmpass"]').val()) + '<?= $_SESSION['login_salt'] ?>');
                //grecaptcha.execute('6LfE13AUAAAAACYtRe104ECi3APlECcyJfbH3VrV', {action: '{{str_replace('-','_hyphen_',uri_string())}}'})
                /*grecaptcha.execute('6LfE13AUAAAAACYtRe104ECi3APlECcyJfbH3VrV', {action: 'profile/DefaultController/updatePass'})
                    .then(function (token) {
                        $('[name="ctvrg"]').val(token);
                        $(form).submit();
                    });*/
                $(form).submit();
            });
        //});
    });
</script>
<script>

    function goback()
    {
        history.back();
    }
    function formReset(id)
    {
        document.getElementById(id).form.reset();

    }
    $('.del_array_data').click(function ()
    {
        y = confirm("Are you sure want delete ?");
        if (y == false)
        {
            return false;
        }
        var estab_data = $(".del_array_data").val();
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Advocate/del_estab'); ?>",
            data: {arr_id: estab_data},
            success: function (data) {

                if (data == 'done') {
                    $('#msg_delete').show();
                    $(".delete-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; Data deleted successfully!  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                    setTimeout(function () {
                        $('#msg_delete').hide();
                        window.location.href = "<?= base_url('profile/DefaultController/updateProfile/estab') ?>";
                    }, 500);

                }

                $.getJSON("<?php echo base_url() . 'csrf_token'; ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function () {
                $.getJSON("<?php echo base_url() . 'csrf_token'; ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
        return false;
    });

    $('#a_state_id').change(function ()
    {
        $('#a_district').val('');

        var get_state_id = $(this).val();
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, state_id: get_state_id},
            url: "<?php echo base_url('profile/DefaultController/get_openAPI_district'); ?>",
            success: function (data)
            {
                if (data.indexOf('ERROR') != -1) {
                    $('#msg').show();
                    $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + data + " <span class='close' onclick=hideMessageDiv()>X</span></p>");
                    $('#district_list').html('<option value=""> Select District </option>');

                } else {
                    $('#msg').hide();
                    $('#a_district').html(data);
                }
                $.getJSON("<?php echo base_url() . 'csrf_token'; ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function () {
                $.getJSON("<?php echo base_url() . 'csrf_token'; ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
    });
    $('#a_district').change(function () {
        $('#mySelect1').val('');

        var get_distt_id = $(this).val();
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        var state_id = $("#a_state_id option:selected").val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, state_id: state_id, get_distt_id: get_distt_id},
            url: "<?php echo base_url('profile/DefaultController/get_openAPI_Establishment'); ?>",
            success: function (data)
            {
                if (data.indexOf('ERROR') != -1) {
                    $('#msg').show();
                    $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + data + " <span class='close' onclick=hideMessageDiv()>X</span></p>");
                    $('#establishment_list').html('<option value=""> Select Establishment </option>');
                } else {
                    $('#msg').hide();
                    $('#mySelect1').html(data);
                }
                $.getJSON("<?php echo base_url() . 'csrf_token'; ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function () {
                $.getJSON("<?php echo base_url() . 'csrf_token'; ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
    });

    $('#a_district_id').change(function () {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $('#nodal_chek').val('');
        var get_distt_id = $(this).val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, get_distt_id: get_distt_id},
            url: "<?php echo base_url('Advocate/eshtablishment_list_checkbox'); ?>",
            success: function (data)
            {
                $('#nodal_chek').html(data);
                $.getJSON("<?php echo base_url() . 'csrf_token'; ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function () {
                $.getJSON("<?php echo base_url() . 'csrf_token'; ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
    });

    $('#adv_establishment').on('submit', function () {
        $('#mySelect2 option').prop('selected', true);
        if ($('#adv_establishment').valid()) {
            var form_data = $(this).serialize();
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('profile/DefaultController/get_more_establishment'); ?>",
                data: form_data,
                async: false,
                success: function (data) {
                    $('#get_more_esta').html(data);
                    $('#mySelect2').empty();
                    window.location.href = "<?= base_url('profile/DefaultController/updateProfile/estab') ?>";
                    $.getJSON("<?php echo base_url() . 'csrf_token'; ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                },
                error: function () {
                    $.getJSON("<?php echo base_url() . 'csrf_token'; ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                }

            });
            return false;
        } else {
            return false;
        }
    });
    function moveOptionsTo(index)
    {
        $('#mySelect' + (3 - index) + ' option:selected').appendTo('#mySelect' + index);
    }
    $('#toRight').click(function () {
        moveOptionsTo(2);
    });
    $('#toLeft').click(function () {
        moveOptionsTo(1);
    });
    $('#mySelect1').dblclick(function () {
        moveOptionsTo(2);
    });
    $('#mySelect2').dblclick(function () {
        moveOptionsTo(1);
    });

    $('#njdg_m_states_id').change(function () {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $('#njdg_m_dist_id').val('');
        var get_state_id = $(this).val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, state_id: get_state_id},
            url: "<?php echo base_url(); ?>Profile/get_district_list",
            success: function (data)
            {
                $('#njdg_m_dist_id').html(data);
                $.getJSON("<?php echo base_url() . 'csrf_token'; ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function () {
                $.getJSON("<?php echo base_url() . 'csrf_token'; ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
    });


</script>








<script>
    $(document).ready(function()
    {
        

        $('#newpass').keyup(function()
        {
           
            $('#d12,#d13,#d14,#d15,#d16').css("color", "white");

            var str=$('#newpass').val();

            var upper_text= new RegExp('[A-Z]');
            var lower_text= new RegExp('[a-z]');
            var number_check=new RegExp('[0-9]');
            var special_char= new RegExp('[!/\'^�$%&*()}{@#~?><>,|=_+�-\]');

            var flag='T';

            if(str.match(upper_text)){
                $('#d12').css("background-color", "green");
            }else{$('#d12').css("background-color", "red");
                flag='F';}

            if(str.match(lower_text)){
                $('#d13').css("background-color", "green");
            }else{$('#d13').css("background-color", "red");
                flag='F';}

            if(str.match(special_char)){
                $('#d14').css("background-color", "green");
            }else{$('#d14').css("background-color", "red");
                flag='F';}

            if(str.match(number_check)){
                $('#d15').css("background-color", "green");
            }else{$('#d15').css("background-color", "red");
                flag='F';}


            if(str.length>7){
                $('#d16').css("background-color", "green");
            }else{$('#d16').css("background-color", "red");
                flag='F';}


            if(flag=='T'){
                $("#d1").fadeOut();
                $('#display_box').css("color","green");
                $('#display_box').html(str);
            }else{
                $("#d1").show();
                $('#display_box').css("color","red");
                $('#display_box').html(str);
            }
        });

        $('#newpass').blur(function(){
            $('#newpass_sms').text('  ');
            $("#d1").fadeOut();
        });
        $('#newpass').focus(function(){
            $('#newpass_sms').text('  ');
            $("#d1").show();
            $('#d12,#d13,#d14,#d15,#d16').css("color", "black");
        });
    })
</script>
<script>'undefined'=== typeof _trfq || (window._trfq = []);'undefined'=== typeof _trfd && (window._trfd=[]),_trfd.push({'tccl.baseHost':'secureserver.net'}),_trfd.push({'ap':'cpsh'},{'server':'sg2plcpnl0045'}) // Monitoring performance to make your website faster. If you want to opt-out, please contact web hosting support.</script>
