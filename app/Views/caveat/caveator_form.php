<style> .input-group-addon {padding: 0px!important;}.select2-container {width: 100% !important;}
    /*added by anshu 24 jul 2023*/
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<div class="panel panel-default">
    <h4 style="text-align: center;color: #31B0D5">Caveator Information </h4>
    <div class="panel-body">
        <?php
        $attribute = array('class' => 'form-horizontal', 'name' => 'add_caveator', 'id' => 'add_caveator', 'autocomplete' => 'off', 'novalidate' => 'novalidate');
        echo form_open('#', $attribute);
        ?>
        <?=ASTERISK_RED_MANDATORY;?>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="row show_hide_base_on_org">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Case Type <span
                                    style="color: red">*</span>:</label>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <select tabindex='1' name="case_type" id="case_type"
                                    class="form-control input-sm filter_select_dropdown" style="width: 100%" required>
                                <?php
                                if (isset($sc_case_type) && !empty($sc_case_type)) {
                                    foreach ($sc_case_type as $k => $v) {
                                        if (isset($caveator_details[0]['case_type_id']) && !empty($caveator_details[0]['case_type_id'])) {
                                            if ($caveator_details[0]['case_type_id'] == $v->casecode) {
                                                echo '<option selected="selected" value="' . url_encryption($v->casecode) . '">' . strtoupper($v->casename) . '</option>';
                                            } else {
                                                echo '<option value="' . url_encryption($v->casecode) . '">' . strtoupper($v->casename) . '</option>';
                                            }
                                        } else {
                                            echo '<option value="' . url_encryption($v->casecode) . '">' . strtoupper($v->casename) . '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Caveator is <span
                                    style="color: red">*</span>:</label>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <?php
                            $selectIndividual = $caveator_details[0]['orgid'] == 'I' ? 'selected=selected' : '';
                            $selectStateDept = $caveator_details[0]['orgid'] == 'D1' ? 'selected=selected' : '';
                            $selectCentralDept = $caveator_details[0]['orgid'] == 'D2' ? 'selected=selected' : '';
                            $selectOtherDept = $caveator_details[0]['orgid'] == 'D3' ? 'selected=selected' : '';
                            $showHideIndividual = '';
                            $stateDiv ='display:block';
                            //$otherStateDiv='display:block';
                            $showHideOtherIndividual = 'display:none';
                            if (isset($selectIndividual) && !empty($selectIndividual)) {
                                $showHideIndividual = 'display:block';
                            } else if (!empty($selectStateDept) || !empty($selectCentralDept)) {
                                $showHideOtherIndividual = 'display:block';
                                $showHideIndividual = 'display:none';
                                $stateDiv ='display:block';
                               // $otherStateDiv='display:block';

                            }
                            else if(!empty($selectOtherDept)){
                                $stateDiv = 'display:none';
                                $showHideOtherIndividual = 'display:block';
                                $showHideIndividual = 'display:none';
                              //  $otherStateDiv='display:none';
                            }

                            ?>
                            <select tabindex='2' name="party_is" id="party_is" onchange="get_caveator_as(this.value)"
                                    class="form-control input-sm filter_select_dropdown" required>
                                <option value="I" <?php echo $selectIndividual; ?> >Individual</option>
                                <option value="D1" <?php echo $selectStateDept; ?>>State Department</option>
                                <option value="D2" <?php echo $selectCentralDept; ?>>Central Department</option>
                                <option value="D3" <?php echo $selectOtherDept; ?>>Other Organisation</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div id="indvidual_form" style="<?php echo $showHideIndividual; ?>">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Caveator Name
                                <span style="color: red">*</span></label>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <div class="input-group">
                                    <textarea tabindex="3" id="pet_complainant" name="pet_complainant" minlength="3"
                                              maxlength="99" class="form-control input-sm sci_validation"
                                              placeholder="First Name Middle Name Last Name"
                                              type="text"><?php echo_data($caveator_details[0]['pet_name']); ?></textarea>
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                          data-content="Caveator name should be in characters (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                        <i class="fa fa-question-circle-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row show_hide_base_on_org">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Relation <span
                                        style="color: red">*</span>:</label>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <?php
                                $selectSon = $caveator_details[0]['pet_father_flag'] == 'S' ? 'selected=selected' : '';
                                $selectDaughter = $caveator_details[0]['pet_father_flag'] == 'D' ? 'selected=selected' : '';
                                $selectWife = $caveator_details[0]['pet_father_flag'] == 'W' ? 'selected=selected' : '';
                                $selectNotAvailable = $caveator_details[0]['pet_father_flag'] == 'N' ? 'selected=selected' : '';
                                ?>
                                <select tabindex='4' name="pet_rel_flag" id="pet_rel_flag"
                                        class="form-control input-sm filter_select_dropdown" style="width: 100%">
                                    <option value="">Select Relation</option>
                                    <option <?php echo $selectSon; ?> value="S">Son Of</option>
                                    <option <?php echo $selectDaughter; ?> value="D">Daughter Of</option>
                                    <option <?php echo $selectWife; ?> value="W">Spouse Of</option>
                                    <option <?php echo $selectNotAvailable; ?> value="N">Not Available</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row show_hide_base_on_org">
                    <div class="col-sm-12 col-xs-12" id="rel_name">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">
                                Relative Name <span style="color: red">*</span>:</label>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <div class="input-group">
                                    <input tabindex="5" id="relative_name" name="relative_name" minlength="3"
                                           maxlength="99" placeholder="Name of Parent or Husband"
                                           value="<?php echo_data($caveator_details[0]['pet_father_name']); ?>"
                                           class="form-control input-sm sci_validation" type="text">
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                          data-content="Please write name of father or mother or husband or other relative. Relative Name should be in characters ( only dot[.] and space are allowed ).">
                                        <i class="fa fa-question-circle-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row show_hide_base_on_org">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Date of Birth :</label>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <div class="input-group">
                                    <input tabindex='6' class="form-control has-feedback-left" id="pet_dob"
                                           name="pet_dob"
                                           value="<?php echo_data($caveator_details[0]['pet_dob'] ? date('d/m/Y', strtotime($caveator_details[0]['pet_dob'])) : ''); ?>"
                                           maxlength="10" readonly="" placeholder="DD/MM/YYYY" type="text">
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                          data-content="Please Enter Date of Birth.">
                                        <i class="fa fa-question-circle-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row show_hide_base_on_org">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Approximate Age <span
                                        style="color: red">*</span>:</label>
                            <div class="col-sm-2 col-md-4">
                                <div class="input-group">
                                    <?php
                                    if ($caveator_details[0]['pet_age'] == 0 || $caveator_details[0]['pet_age'] == '' || $caveator_details[0]['pet_age'] == NULL) {
                                        $pet_age = '';
                                    } else {
                                        $pet_age = $caveator_details[0]['pet_age'];
                                    }
                                    ?>
                                    <input id="pet_age" tabindex='7' name="pet_age" maxlength="2"
                                           onkeyup="return isNumber(event)" placeholder="Age"
                                           value="<?php echo_data($pet_age); ?>"
                                           class="form-control input-sm age_calculate" type="text">
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                          data-content="Approx. age in years only.">
                                        <i class="fa fa-question-circle-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row show_hide_base_on_org">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-sm-5 input-sm">Gender <span
                                        style="color: red">*</span>:</label>
                            <div class="col-sm-7">
                                <?php
                                $gmchecked = $caveator_details[0]['pet_gender'] == 'M' ? 'checked="checked"' : '';
                                $gfchecked = $caveator_details[0]['pet_gender'] == 'F' ? 'checked="checked"' : '';
                                $gochecked = $caveator_details[0]['pet_gender'] == 'O' ? 'checked="checked"' : '';
                                ?>
                                <label class="radio-inline"><input tabindex='8' type="radio" name="pet_gender"
                                                                   id="pet_gender1" value="M" <?php echo $gmchecked; ?>>Male</label>
                                <label class="radio-inline"><input tabindex='9' type="radio" name="pet_gender"
                                                                   id="pet_gender2" value="F" <?php echo $gfchecked; ?>>Female</label>
                                <label class="radio-inline"><input tabindex='10' type="radio" name="pet_gender"
                                                                   id="pet_gender3" value="O" <?php echo $gochecked; ?>>Other</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="org_form" style="<?php echo $showHideOtherIndividual; ?>">
                <div class="row" id="org_state_row">
                    <?php // print_r($state_list); ?>
                    <div class="col-sm-12 col-xs-12" id="stateDivBox" style="<?php echo $stateDiv;?>">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">State Name <span
                                        style="color: red">*</span>:</label>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <select tabindex='11' name="org_state" id="org_state"
                                        class="form-control input-sm filter_select_dropdown org_state">

                                    <?php
                                    echo '<option  value="' . url_encryption(0) . '">' . strtoupper('NOT IN LIST') . '</option>';
                                    $select_organization = '';
                                    if (isset($state_list) && !empty($state_list)) {
                                        foreach ($state_list as $k => $v) {
                                            if (!empty($caveator_details[0]['org_state']) && trim($caveator_details[0]['org_state']) == $v->cmis_state_id) {
                                                $select_organization = 'selected="selected"';
                                            } else {
                                                $select_organization = '';
                                            }
                                            echo '<option ' . $select_organization . ' value="' . url_encryption($v->cmis_state_id) . '">' . strtoupper($v->agency_state) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="otherOrgState" style="display: none">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Other State Name<span
                                        style="color: red">*</span>:</label>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <div class="input-group">
                                    <textarea tabindex='12' id="org_state_name" name="org_state_name" minlength="5"
                                              maxlength="99" class="form-control input-sm"
                                              placeholder="Other State Name"
                                              type="text"><?php echo_data($caveator_details[0]['org_state_name']); ?></textarea>
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                          data-content="Other State Name should be in characters (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                        <i class="fa fa-question-circle-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <?php // print_r($dept_list); exit();?>
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Department Name <span
                                        style="color: red">*</span>:</label>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <select name="org_dept" tabindex='13' id="org_dept"
                                        class="form-control input-sm filter_select_dropdown org_dept">
                                    <?php
                                    echo '<option  value="' . url_encryption(0) . '">' . strtoupper('NOT IN LIST') . '</option>';
                                    $dept_sel = '';
                                    if (isset($dept_list) && !empty($dept_list)) {
                                        foreach ($dept_list as $k => $v) {
                                            if (!empty($caveator_details[0]['org_dept']) && trim($caveator_details[0]['org_dept']) == $v->deptcode) {
                                                $dept_sel = 'selected="selected"';
                                            } else {
                                                $dept_sel = '';
                                            }
                                             echo '<option '.$dept_sel.' value="'.url_encryption($v->deptcode).'">'.strtoupper($v->deptname).'</option>';
                                        }
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="otherOrgDept" style="display: none">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Other Department<span
                                        style="color: red">*</span>:</label>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <div class="input-group">
                                    <textarea id="org_dept_name" tabindex='14' name="org_dept_name" minlength="5"
                                              maxlength="99" class="form-control input-sm"
                                              placeholder="Other State Name"
                                              type="text"><?php echo_data($caveator_details[0]['org_state_name']); ?></textarea>
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                          data-content="Other Department Name should be in characters (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                        <i class="fa fa-question-circle-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Post Name <span
                                        style="color: red">*</span>:</label>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <select name="org_post" id="org_post" tabindex='15'
                                        class="form-control input-sm filter_select_dropdown org_post">
                                    <?php
                                    echo '<option  value="' . url_encryption(0) . '">' . strtoupper('NOT IN LIST') . '</option>';
                                    $post_sel = '';
                                    if (isset($post_list) && !empty($post_list)) {
                                        foreach ($post_list as $k => $v) {
                                            if (!empty($caveator_details[0]['org_post']) && trim($caveator_details[0]['org_post']) == $v->authcode) {
                                                $post_sel = 'selected="selected"';
                                            } else {
                                                $post_sel = '';
                                            }
                                            echo '<option ' . $post_sel . ' value="' . url_encryption($v->authcode) . '">' . strtoupper($v->authdesc) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="otherOrgPost" style="display: none">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Other Post<span
                                        style="color: red">*</span>:</label>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <div class="input-group">
                                    <textarea id="org_post_name" name="org_post_name" tabindex='16' minlength="5"
                                              maxlength="99" class="form-control input-sm" placeholder="Other Post Name"
                                              type="text"><?php echo_data($caveator_details[0]['org_state_name']); ?></textarea>
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                          data-content="Other Post Name should be in characters (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                        <i class="fa fa-question-circle-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <?php if(!is_null($_SESSION['login']['department_id'])){ ?>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Whether filed by Government? </label>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <label class="switch">
                                <input type="checkbox" name="is_govt_filing" id="is_govt_filing" <?php echo (!empty($caveator_details[0]['is_govt_filing']) && ($caveator_details[0]['is_govt_filing'] ==1)) ? 'checked' : ''  ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Email<?php echo '<span id="pet_email_req" value="1" style="color: red">*</span>'; ?>: </label>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <div class="input-group">
                                <input id="pet_email" name="pet_email" placeholder="Email" tabindex='17'
                                       value="<?php echo_data($caveator_details[0]['pet_email']); ?>"
                                       class="form-control input-sm sci_validation" type="email" minlength="6"
                                       maxlength="49" required>
                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                      data-content="Please enter caveator valid email id. (eg : abc@example.com)">
                                    <i class="fa fa-question-circle-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Mobile<?php echo '<span id="pet_mobile_req" value="1" style="color: red">*</span>'; ?> :</label>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <div class="input-group">
                                <input id="pet_mobile" name="pet_mobile" tabindex='18' onkeyup="this.value=this.value.replace(/[^0-9]/g,'');"
                                       placeholder="Mobile"
                                       value="<?php echo_data($caveator_details[0]['pet_mobile']); ?>"
                                       class="form-control input-sm" type="text" minlength="10" maxlength="10" required>
                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                      data-content="Mobile No. should be of 10 digits only.">
                                    <i class="fa fa-question-circle-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">
                            <div id="address_label_name"> Address <span style="color: red">*</span>:</div>
                        </label>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <div class="input-group">
                                <textarea tabindex='19' name="pet_address" id="pet_address"
                                          placeholder="H.No.,  Street no, Colony,  Land Mark"
                                          class="form-control input-sm sci_validation" minlength="3" maxlength="250"
                                          required><?php echo_data($caveator_details[0]['petadd']); ?></textarea>
                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                      data-content="Please enter House No, Street No, Sector, Colony and Landmarks. Please Select District and Taluka from the below mentioned field. Do not repeat District and Taluka in Address fields and District and Taluka Fields. Address can be alphanumeric (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                    <i class="fa fa-question-circle-o"></i>
                                </span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Pin Code <?php echo '<span id="pet_pincode_req" value="1" style="color: red">*</span>'; ?>:</label>
                        <div class="col-sm-7 col-sm-12 col-xs-12">
                            <div class="input-group">
                                <input id="party_pincode" name="party_pincode" tabindex='20'
                                       onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Pincode" required
                                       value="<?php echo_data($caveator_details[0]['pet_pincode']); ?>"
                                       class="form-control input-sm" type="text" minlength="6" maxlength="6">
                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                      data-content="Pincode should be 6 digits only.">
                                    <i class="fa fa-question-circle-o"></i>
                                    <a href="https://www.indiapost.gov.in/vas/pages/findpincode.aspx" target="_blank">Pin Code Locator</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">
                            <div id="address_label_name"> City <span style="color: red">*</span>:</div>
                        </label>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <div class="input-group">
                                <input id="party_city" tabindex='21' name="party_city" placeholder="City"
                                       value="<?php echo_data($caveator_details[0]['pet_city']); ?>"
                                       class="form-control input-sm sci_validation" type="text" minlength="3"
                                       maxlength="49" required>
                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                      data-content="Please enter City name.">
                                    <i class="fa fa-question-circle-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> State <span
                                    style="color: red">*</span>:</label>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <select name="party_state" id="party_state" tabindex='22'
                                    class="form-control input-sm filter_select_dropdown" required>
                                <option value="" title="Select">Select State</option>
                                <?php
                                $stateArr = array();
                                if (count($state_list)) {
                                    foreach ($state_list as $dataRes) {
                                        $sel = ($caveator_details[0]['state_id'] == $dataRes->cmis_state_id) ? "selected=selected" : '';
                                        ?>
                                        <option <?php echo $sel; ?>
                                                value="<?php echo_data(url_encryption(trim($dataRes->cmis_state_id))); ?>"><?php echo_data(strtoupper($dataRes->agency_state)); ?> </option>;
                                        <?php
                                        $tempArr = array();
                                        $tempArr['id'] = url_encryption(trim($dataRes->cmis_state_id));
                                        $tempArr['state_name'] = strtoupper($dataRes->agency_state);
                                        $stateArr[] = (object)$tempArr;
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> District <span
                                    style="color: red">*</span>:</label>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <select name="party_district" id="party_district" tabindex='23'
                                    class="form-control input-sm filter_select_dropdown party_district" required>
                                <option value="" title="Select">Select District</option>
                                <?php
                                if (!empty($district_list)) {
                                    foreach ($district_list as $dataRes) {
                                        $sel = ($caveator_details[0]['dist_code'] == $dataRes->id_no) ? 'selected=selected' : '';
                                        ?>
                                        <option <?php echo $sel; ?>
                                                value="<?php echo_data(url_encryption(trim($dataRes->id_no))); ?>"><?php echo_data(strtoupper($dataRes->name)); ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4">
                <?php if (isset($caveator_details[0]) && !empty($caveator_details[0])) { ?>
                    <input type="submit" class="btn btn-success" id="caveator_save" tabindex='26' value="UPDATE">
                    <a href="<?= base_url('caveat/caveatee') ?>" class="btn btn-primary btnNext" type="button"
                       tabindex='25'>Next</a>
                <?php } else { ?>
                    <input type="submit" class="btn btn-success" id="caveator_save" value="SAVE" tabindex='24'>
                <?php } ?>


            </div>
        </div>
        <?php echo form_close();
        ?>
    </div>
</div>
<script>
    $(".sci_validation").keyup(function () {
        var initVal = $(this).val();
        outputVal = initVal.replace(/[^a-z_,^A-Z^0-9\.@,/'()\s"\-]/g, "").replace(/^\./, "");
        //validate_alpha_numeric_single_double_quotes_bracket_with_special_characters
        if (initVal != outputVal) {
            $(this).val(outputVal);
        }
    });

</script>
<script type="text/javascript">
    var state_Arr = '<?php echo json_encode($stateArr)?>';
    //----------Get District List----------------------//
    $('#party_state').change(function () {

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $('#party_district').val('');

        var get_state_id = $(this).val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, state_id: get_state_id},
            url: "<?php echo base_url('newcase/Ajaxcalls/get_districts'); ?>",
            success: function (data) {
                $('#party_district').html(data);
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function () {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });

    });

    //---------- Hide and show Individual and Org form----------------------//
    $(document).ready(function () {
        var party_as_sel = '<?php echo $caveator_details[0]['caveator_type']; ?>';

        var OrgState_ID= '<?php echo $caveator_details[0]['org_state']; ?>';
        var OrgDept_ID='<?php echo $caveator_details[0]['org_dept']; ?>';
        var OrgPost_ID='<?php echo $caveator_details[0]['org_post']; ?>';

        if(OrgState_ID==0 && OrgState_ID!=''){
            $('#otherOrgState').show();
            var OrgState_NAME='<?php echo $caveator_details[0]['org_state_name']; ?>';
            $('#org_state_name').text(OrgState_NAME);
        }
        if(OrgDept_ID==0 && OrgDept_ID!=''){
            $('#otherOrgDept').show();
            var OrgDept_NAME='<?php echo $caveator_details[0]['org_dept_name']; ?>';
            $('#org_dept_name').text(OrgDept_NAME);
        }
        if(OrgPost_ID==0 && OrgPost_ID!=''){
            $('#otherOrgPost').show();
            var OrgPost_NAME='<?php echo $caveator_details[0]['org_post_name']; ?>';
            $('#org_post_name').text(OrgPost_NAME);
        }


        if (party_as_sel != '') {
            get_caveator_as(party_as_sel);//--call to selected
        }
    });

    function get_caveator_as(value) {
        var party_as = value;
        if (party_as == 'I') {
            $('#indvidual_form').show();
            $('#org_form').hide();
            $('#org_state_row').show();
            $('#org_state').val('');
            $('#org_dept').val('');
            $('#org_post').val('');
            $('#otherOrgState').hide();
            $('#otherOrgDept').hide();
            $('#otherOrgPost').hide();
        } else {

            get_departments(party_as);
            get_posts();
            if (party_as == 'D3') {
                $('#indvidual_form').hide();
                $('#org_form').show();
                $('#org_state_row').hide();
                $('#otherOrgState').hide();
                $('#caveator_name').val('');
                $('#relation').val('');
                $('#relative_name').val('');
                $('#caveator_dob').val('');
                $('#caveator_age').val('');
                /*$('#party_gender1').val('');
                 $('#party_gender2').val('');
                 $('#party_gender3').val('');*/
            } else {
               // alert(party_as);
                $('#indvidual_form').hide();
                $('#org_form').show();
                $('#org_state_row').show();
                $('#caveator_name').val('');
                $('#relation').val('');
                $('#relative_name').val('');
                $('#caveator_dob').val('');
                $('#caveator_age').val('');
                $("#stateDivBox").show();

                //$('#otherstateDivBox').show();

                /*$('#party_gender1').val('');
                 $('#party_gender2').val('');
                 $('#party_gender3').val('');            */
            }
        }
    }   

    //---------- Organisation State Name----------------------//
    $('#org_state').change(function () {

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

        var org_state = $(this).val();
        if (org_state == '<?php echo url_encryption(0); ?>') {
            $('#otherOrgState').show();
            $('#otherOrgDept').show();
            $('#otherOrgPost').show();
            $('#org_dept').val('<?php echo url_encryption(0); ?>');
            $('#org_dept').select2();
            $('#org_post').val('<?php echo url_encryption(0); ?>');
            $('#org_post').select2();
        } else {
            $('#otherOrgState').hide();
            $('#otherOrgDept').hide();
            $('#otherOrgPost').hide();
            $('#org_dept').val('');
            $('#org_dept').select2();
            $('#org_post').val('');
            $('#org_post').select2();
        }
    });

    //---------- Organisation Department Name----------------------//
    $('#org_dept').change(function () {

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

        var org_dept = $(this).val();
        if (org_dept == '<?php echo url_encryption(0); ?>') {
            $('#otherOrgDept').show();
            $('#otherOrgPost').show();
            $('#org_post').val('<?php echo url_encryption(0); ?>');
            $('#org_post').select2();
        } else {
            $('#otherOrgDept').hide();
            $('#otherOrgPost').hide();
            $('#org_post').val('');
            $('#org_post').select2();
        }
    });


    //---------- Organisation Post Name----------------------//
    $('#org_post').change(function () {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

        var org_post = $(this).val();
        if (org_post == '<?php echo url_encryption(0); ?>') {
            $('#otherOrgPost').show();

        } else {
            $('#otherOrgPost').hide();
        }
    });


    function get_departments(party_is) {

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

        var selected_org_st_id = '<?php echo url_encryption($caveator_details[0]['org_state_id']); ?>';
        var selected_dept_id = '<?php echo url_encryption($caveator_details[0]['org_dept_id']); ?>';

        $.ajax({
            type: "POST",
            data: {
                CSRF_TOKEN: CSRF_TOKEN_VALUE,
                party_is: party_is,
                selected_org_st_id: selected_org_st_id,
                selected_dept_id: selected_dept_id
            },
            url: "<?php echo base_url('newcase/Ajaxcalls/get_org_departments'); ?>",
            success: function (data) {
                $('.filter_select_dropdown').select2();
                var response = data.split('$$$$$');
                $('.org_state').html(response[0]);
                $('.org_dept').html(response[1]);
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function () {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
    }

    function get_posts() {

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

        var selected_post_id = '<?php echo url_encryption($caveator_details[0]['org_post_id']); ?>';

        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, selected_post_id: selected_post_id},
            url: "<?php echo base_url('newcase/Ajaxcalls/get_org_posts'); ?>",
            success: function (data) {
                $('.org_post').html(data);
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function () {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });

    }

    $(document).ready(function () {
        $('#pet_dob').datepicker({
            onSelect: function (value) {
                var parts = value.split("/");
                var day = parts[0] && parseInt(parts[0], 10);
                var month = parts[1] && parseInt(parts[1], 10);
                var year = parts[2] && parseInt(parts[2], 10);
                var str = month + '/' + day + '/' + year;
                var today = new Date(),
                    dob = new Date(str),
                    age = new Date(today - dob).getFullYear() - 1970;
                $('#pet_age').val(age);
            },
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:-1",
            dateFormat: "dd/mm/yy",
            defaultDate: '-40y'
        });
        
        $('#add_caveator').on('submit', function () {
            if ($('#add_caveator').valid()) {
                var form_data = $(this).serialize();
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('caveat/caveator/add_caveators'); ?>",
                    data: form_data,
                    async: false,
                    cache: false,
                    beforeSend: function () {
                        $('#caveator_save').val('Please wait...');
                        $('#caveator_save').prop('disabled', true);
                    },
                    success: function (data) {
                        $('#caveator_save').val('SAVE');
                        $('#caveator_save').prop('disabled', false);
                        var resArr = data.split('@@@');
                        if (resArr[0] == 1) {
                            $('#msg').show();
                            $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                        } else if (resArr[0] == 2) {
                            $(".form-response").html("<p class='message valid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                            $('#msg').show();
                            window.location.href = resArr[2];

                        } else if (resArr[0] == 3) {
                            $('#msg').show();
                            $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
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
                return false;
            } else {
                return false;
            }
        });
    });
</script>