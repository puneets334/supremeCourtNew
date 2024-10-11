<link rel="shortcut icon" href="<?= base_url() . 'assets/newAdmin/' ?>images/favicon.gif">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/font-awesome.min.css" rel="stylesheet">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/animate.css" rel="stylesheet">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/material.css" rel="stylesheet" />
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/style.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= base_url() . 'assets/newAdmin/' ?>css/jquery.dataTables.min.css">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/fullcalendar.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery-ui.css">
<link href="<?= base_url() . 'assets' ?>/css/select2.min.css" rel="stylesheet">
<link href="<?= base_url() . 'assets/newAdmin/' ?>css/black-theme.css" rel="stylesheet">
    <link href="<?= base_url() . 'assets/newAdmin/' ?>css/responsive.css" rel="stylesheet">
@stack('style')
<style>
    .datepicker-dropdown {
        margin-top: 231px !important;
    }

    .datepicker-dropdown {
        background-color: #fff;
    }
    label .error{
        color: red !important;
    }

    .error{
        color: red !important;
    }

    .col-12 label.error{
        color: red !important;
    }
</style>
<div class="center-content-inner comn-innercontent">
    <div class="tab-content">
        <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <?php
            $attribute = ['class' => 'form-horizontal', 'name' => 'add_respondent', 'id' => 'add_respondent', 'autocomplete' => 'off'];
            echo form_open('#', $attribute);
            ?>
            <div class="tab-form-inner">
                <div class="row">
                    <h6 class="text-center fw-bold">Respondent Information</h6>
                </div>
                <?= ASTERISK_RED_MANDATORY ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-2">
                        <div class="form-group mb-3">
                            <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 form-label">Respondent
                                Is <span style="color: red" class="astriks">*</span> :</label>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-4 pe-3">
                                <?php
                                $selectIndividual = @$party_details[0]['party_type'] == 'I' ? 'selected' : '';
                                $selectStateDept = @$party_details[0]['party_type'] == 'D1' ? 'selected' : '';
                                $selectCentralDept = @$party_details[0]['party_type'] == 'D2' ? 'selected' : '';
                                $selectOtherDept = @$party_details[0]['party_type'] == 'D3' ? 'selected' : '';
                                ?>
                                <select tabindex='1' name="party_as" id="party_as" onchange="get_party_as(this.value)" class="form-control cus-form-ctrl filter_select_dropdown">
                                    <option value="I" <?php echo $selectIndividual; ?>>Individual</option>
                                    <option value="D1" <?php echo $selectStateDept; ?>>State Department</option>
                                    <option value="D2" <?php echo $selectCentralDept; ?>>Central Department</option>
                                    <option value="D3" <?php echo $selectOtherDept; ?>>Other Organisation</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="indvidual_form">
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Main Respondent Name
                                <span style="color: red" class="astriks">*</span></label>
                            <textarea oninput="validateInput(event)"  tabindex='2' id="party_name"  style="text-transform: uppercase"  name="party_name" minlength="3" maxlength="99" class="form-control cus-form-ctrl sci_validation party_name" placeholder="First Name Middle Name Last Name" type="text"><?php echo (@$party_details[0]['party_name']); ?></textarea>
                            <span class="input-group-addon" data-placement="bottom" data-toggle="popover" title="Respondent name should be in characters (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                <i class="fa fa-question-circle-o"></i>
                            </span>
                            {{-- <input type="text" class="form-control cus-form-ctrl" id="exampleInputEmail1" placeholder=""> --}}
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 show_hide_base_on_org">
                        <div class="mb-3">
                            <label for="" class="form-label">Relation <span style="color: red" class="astriks">*</span></label>
                            <?php
                            $selectSon = @$party_details[0]['relation'] == 'S' ? 'selected=selected' : '';
                            $selectDaughter = @$party_details[0]['relation'] == 'D' ? 'selected=selected' : '';
                            $selectWife = @$party_details[0]['relation'] == 'W' ? 'selected=selected' : '';
                            $selectNotAvailable = @$party_details[0]['relation'] == 'N' ? 'selected=selected' : '';
                            ?>
                            <select tabindex='3' name="relation" id="relation" class="form-control cus-form-ctrl filter_select_dropdown relation" style="width: 100%">
                                <option value="" title="Select">Select Relation</option>
                                <option <?php echo $selectSon; ?> value="S">Son Of</option>
                                <option <?php echo $selectDaughter; ?> value="D">Daughter Of</option>
                                <option <?php echo $selectWife; ?> value="W">Spouse Of</option>
                                <option <?php echo $selectNotAvailable; ?> value="N">Not Available</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 show_hide_base_on_org">
                        <div class="mb-3" id="rel_name">
                            <label for="" class="form-label">Parent/Spouse Name <span style="color: red" class="astriks">*</span></label>
                            <input oninput="validateInput(event)"  tabindex='4' id="relative_name" name="relative_name" minlength="3"  style="text-transform: uppercase" maxlength="99" placeholder="Name of Parent or Husband" value="<?php echo (@$party_details[0]['relative_name']); ?>" class="form-control cus-form-ctrl sci_validation relative_name" type="text">
                            <span class="input-group-addon" data-placement="bottom" data-toggle="popover" title="Please write name of father or mother or husband or other relative. Relative Name should be in characters ( only dot[.] and space are allowed ).">
                                <i class="fa fa-question-circle-o"></i>
                            </span>
                            {{-- <input type="text"
                                                        class="form-control cus-form-ctrl"
                                                        id=""
                                                        placeholder=""> --}}
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 show_hide_base_on_org">
                        <div class="mb-3">
                            <label for="" class="form-label">Is Dead/Minor?</label>
                            <div class="">
                                <?php
                                if (!empty(@$party_details[0]['is_dead_minor']) && (@$party_details[0]['is_dead_minor'] == 't' || @$party_details[0]['is_dead_minor'] == 'f')) {
                                ?>
                                    <label class="radio-inline is_dead_class"><input <?php echo @$party_details[0]['is_dead_minor'] && @$party_details[0]['is_dead_minor'] == 't' ? 'checked="checked" ' : ''; ?> type="radio" id="is_dead_minor_1" value="1" name="is_dead_minor">Yes</label>
                                    <label class="radio-inline is_dead_class"><input type="radio" id="is_dead_minor_2" value="0" name="is_dead_minor" <?php echo @$party_details[0]['is_dead_minor'] && @$party_details[0]['is_dead_minor'] == 'f' ? 'checked="checked" ' : ''; ?>>No</label>
                                <?php
                                } else {
                                ?>
                                    <label class="radio-inline is_dead_class"><input type="radio" id="is_dead_minor_1" value="1" name="is_dead_minor">Yes</label>
                                    <label class="radio-inline is_dead_class"><input type="radio" id="is_dead_minor_2" value="0" name="is_dead_minor" checked>No</label>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 show_hide_base_on_org">
                        <div class="mb-3 icon-input">
                            <label for="" class="form-label">Date of Birth </label>
                            <input tabindex='5' class="form-control cus-form-ctrl" id="party_dob" name="party_dob" value="<?php echo !empty(@$party_details[0]['party_dob']) ? date('d/m/Y', strtotime(@$party_details[0]['party_dob'])) : ''; ?>" maxlength="10" readonly="" placeholder="DD/MM/YYYY" type="text">
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            <span class="input-group-addon" data-placement="bottom" data-toggle="popover" title="Please Enter Date of Birth.">
                                <i class="fa fa-question-circle-o"></i>
                            </span>
                        </div>
                        <div class="form-group">
                            <span id="subcatLoadData"></span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 show_hide_base_on_org">
                        <div class="mb-3">
                            <?php
                            $style = '';
                            $astrik = '';
                            if (@$party_details[0]['is_dead_minor'] == 'f' && !empty(@$party_details[0]['country_id']) && @$party_details[0]['country_id'] != 96) {
                                $style = '';
                                $astrik = '';
                            } elseif (!empty(@$party_details[0]['is_dead_minor']) && @$party_details[0]['is_dead_minor'] == 'f') {
                                $style = 'style="color: red"';
                                $astrik = '*';
                            } elseif (!empty(@$party_details[0]['is_dead_minor']) && @$party_details[0]['is_dead_minor'] == 't') {
                                $style = '';
                                $astrik = '';
                            } else {
                                $style = 'style="color: red"';
                                $astrik = '*';
                            }
                            ?>
                            <label for="" class="form-label">Approximate Age <span id="party_age_span" <?php echo $style; ?>><?php echo $astrik; ?></span></label>
                            <?php
                            if (@$party_details[0]['party_age'] == 0 || @$party_details[0]['party_age'] == '' || @$party_details[0]['party_age'] == null) {
                                $party_age = '';
                            } else {
                                $party_age = @$party_details[0]['party_age'];
                            }
                            ?>
                            <input id="party_age" tabindex='6' name="party_age" min="0" maxlength="2" onkeyup="return isNumber(event)" placeholder="Age" value="<?php echo ($party_age); ?>" class="form-control cus-form-ctrl age_calculate" type="text"  >
                            <span class="input-group-addon" data-placement="bottom" data-toggle="popover" title="Approx. age in years only.">
                                <i class="fa fa-question-circle-o"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 show_hide_base_on_org">
                        <label for="" class="form-label">Gender <span style="color: red" class="astriks">*</span></label>
                        <div class="mb-3">
                            <?php
                            $gmchecked = @$party_details[0]['gender'] == 'M' ? 'checked="checked"' : '';
                            $gfchecked = @$party_details[0]['gender'] == 'F' ? 'checked="checked"' : '';
                            $gochecked = @$party_details[0]['gender'] == 'O' ? 'checked="checked"' : '';
                            ?>
                            <label class="radio-inline"><input tabindex='7' type="radio" name="party_gender" id="party_gender1" value="M" <?php echo $gmchecked; ?>  >Male</label>
                            <label class="radio-inline"><input tabindex='8' type="radio" name="party_gender" id="party_gender2" value="F" <?php echo $gfchecked; ?>  >Female</label>
                            <label class="radio-inline"><input tabindex='9' type="radio" name="party_gender" id="party_gender3" value="O" <?php echo $gochecked; ?>  >Other</label>
                        </div>
                    </div>
                </div>
                <div class="row" id="org_form" style="display: none">
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4" id="org_state_row">
                        <div class="mb-3">
                            <label for="" class="form-label">State Name <span style="color: red" class="astriks">*</span></label>
                            <select tabindex='10' name="org_state" id="org_state" class="form-control cus-form-ctrl filter_select_dropdown org_state">
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4" id="otherOrgState" style="display: none">
                        <div class="mb-3">
                            <label class="form-label">Other State Name <span style="color: red" class="astriks">*</span></label>
                            <textarea tabindex='11' id="org_state_name" name="org_state_name" minlength="5" maxlength="99" class="form-control cus-form-ctrl org_state_name" placeholder="Other State Name" type="text"><?php echo (@$party_details[0]['org_state_name']); ?></textarea>
                            <span class="input-group-addon" data-placement="bottom" data-toggle="popover" title="Other State Name should be in characters (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                <i class="fa fa-question-circle-o"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Department Name <span style="color: red" class="astriks">*</span></label>
                            <select name="org_dept" tabindex='12' id="org_dept" class="form-control cus-form-ctrl filter_select_dropdown org_dept org_dept">
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4" id="otherOrgDept" style="display: none">
                        <div class="mb-3">
                            <label for="" class="form-label">Other Department <span style="color: red" class="astriks">*</span></label>
                            <textarea id="org_dept_name" tabindex='13' name="org_dept_name" minlength="5" maxlength="99" class="form-control cus-form-ctrl org_dept_name" placeholder="Other State Name" type="text"><?php echo (@$party_details[0]['org_state_name']); ?></textarea>
                            <span class="input-group-addon" data-placement="bottom" data-toggle="popover" title="Other Department Name should be in characters (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                <i class="fa fa-question-circle-o"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Post Name <span style="color: red" class="astriks">*</span></label>
                            <select name="org_post" id="org_post" tabindex='14' class="form-control cus-form-ctrl filter_select_dropdown org_post">
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4" id="otherOrgPost" style="display: none">
                        <div class="mb-3">
                            <label class="form-label">Other Post <span style="color: red" class="astriks">*</span></label>
                            <textarea id="org_post_name" name="org_post_name" tabindex='15' minlength="5" maxlength="99" class="form-control cus-form-ctrl" placeholder="Other Post Name" type="text"><?php echo (@$party_details[0]['org_state_name']); ?></textarea>
                            <span class="input-group-addon" data-placement="bottom" data-toggle="popover" title="Other Post Name should be in characters (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                <i class="fa fa-question-circle-o"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Email </label>
                            <input id="party_email"  style="text-transform: uppercase" name="party_email" placeholder="Email" tabindex='16' value="<?php echo (@$party_details[0]['email_id']); ?>" class="form-control cus-form-ctrl" type="email" minlength="6" maxlength="49">
                            <span class="input-group-addon" data-placement="bottom" data-toggle="popover" title="Please enter Petitioner valid email id. (eg : abc@example.com)">
                                <i class="fa fa-question-circle-o"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Mobile </label>
                            <input id="party_mobile" name="party_mobile" tabindex='17' onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Mobile" value="<?php echo (@$party_details[0]['mobile_num']); ?>" class="form-control cus-form-ctrl" type="text" minlength="10" maxlength="10">
                            <span class="input-group-addon" data-placement="bottom" data-toggle="popover" title="Mobile No. should be of 10 digits only.">
                                <i class="fa fa-question-circle-o"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Address <span id="address_span" <?php echo $style; ?> class="astriks"><?php echo $astrik; ?></span></label>
                            <textarea tabindex='18' name="party_address" id="party_address" style="text-transform: uppercase"  placeholder="H.No.,  Street no, Colony,  Land Mark" class="form-control cus-form-ctrl sci_validation" minlength="3"><?php echo (@$party_details[0]['address']); ?></textarea>
                            <span class="input-group-addon" data-placement="bottom" data-toggle="popover" title="Please enter House No, Street No, Sector, Colony and Landmarks. Please Select District and Taluka from the below mentioned field. Do not repeat District and Taluka in Address fields and District and Taluka Fields. Address can be alphanumeric (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                <i class="fa fa-question-circle-o"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Country <span id="country_span"></span></label>
                            <select name="country_id" id="country_id" tabindex='19' class="form-control cus-form-ctrl filter_select_dropdown">
                                <option value="">Select Country</option>
                                <?php
                                if (isset($countryList) && !empty($countryList)) {
                                    foreach ($countryList as $val) {
                                        if (!empty(@$party_details[0]['country_id'])) {
                                            $sel = url_encryption($val->id) == url_encryption(@$party_details[0]['country_id']) ? 'selected=selected' : '';
                                        } else {
                                            $sel = $val->id == 96 ? 'selected=selected' : '';
                                        }
                                        echo '<option ' . $sel . ' value="' . url_encryption(trim($val->id)) . '">' . strtoupper($val->country_name) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Pin Code<span style="color: red" class="astriks">*</span></label>
                            <input id="party_pincode" name="party_pincode" tabindex='20' onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Pincode" value="<?php echo (@$party_details[0]['pincode']); ?>" class="form-control cus-form-ctrl" type="text" minlength="6" maxlength="6" required>
                            <span class="input-group-addon" data-placement="bottom" data-toggle="popover" title="Pincode should be 6 digits only." >
                                <i class="fa fa-question-circle-o"></i>
                                <a href="https://www.indiapost.gov.in/vas/pages/findpincode.aspx" target="_blank" class="pin-code-loc">Pin Code Locator</a>
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">City <span id="city_span" class="astriks" <?php echo $style; ?>><?php echo $astrik; ?></span></label>
                            <input id="party_city" tabindex='21' style="text-transform: uppercase"  name="party_city" placeholder="City" value="<?php echo (@$party_details[0]['city']); ?>" class="form-control cus-form-ctrl sci_validation" type="text" minlength="3" maxlength="49" required>
                            <span class="input-group-addon" data-placement="bottom" data-toggle="popover" title="Please enter City name.">
                                <i class="fa fa-question-circle-o"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">State <span id="state_span" class="astriks" <?php echo $style; ?>><?php echo $astrik; ?></span></label>
                            <select name="party_state" id="party_state" tabindex='22' class="form-control cus-form-ctrl filter_select_dropdown" required>
                                <option value="" title="Select">Select State</option>
                                <?php
                                $sel = '';
                                $stateArr = array();
                                if (!empty($state_list)) {
                                    foreach (@$state_list as $dataRes) {
                                        if (!empty(@$party_details[0]['state_id'])) {
                                            $sel = (@$party_details[0]['state_id'] == $dataRes->cmis_state_id) ? "selected=selected" : '';
                                        }
                                ?>
                                        <option <?php echo $sel; ?> value="<?php echo (url_encryption(trim($dataRes->cmis_state_id))); ?>"><?php echo (strtoupper($dataRes->agency_state)); ?>
                                        </option>
                                <?php
                                        $tempArr = array();
                                        $tempArr['id'] = url_encryption(trim($dataRes->cmis_state_id));
                                        $tempArr['state_name'] = strtoupper(trim($dataRes->agency_state));
                                        $stateArr[] = (object)$tempArr;
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">District <span id="district_span" class="astriks" <?php echo $style; ?>><?php echo $astrik; ?></span></label>
                            <select name="party_district" id="party_district" tabindex='23' class="form-control cus-form-ctrl filter_select_dropdown party_district" required>
                                <option value="" title="Select">Select District</option>
                                <?php
                                if (!empty($district_list)) {
                                    foreach ($district_list as $dataRes) {
                                        $sel = (@$party_details[0]['district_id'] == $dataRes->id_no) ? 'selected=selected' : '';
                                ?>
                                        <option <?php echo $sel; ?> value="<?php echo (url_encryption(trim($dataRes->id_no))); ?>"><?php echo (strtoupper($dataRes->name)); ?>
                                        </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 my-3">
                        <div class="row">
                            <div class="progress" style="display: none">
                                <div class="progress-bar progress-bar-success myprogress" role="progressbar" value="0" max="100" style="width:0%">0%</div>
                            </div>
                        </div>
                        <div class="save-btns text-center">
                            <a href="<?= base_url('newcase/petitioner') ?>" class="quick-btn gray-btn" type="button" tabindex='27'>Previous</a>
                            <?php if (!empty(getSessionData('case_table_ids')) && !empty(getSessionData('case_table_ids')->m_respondent_id)) { ?>
                                <input type="submit" class="btn btn-success" id="pet_save" tabindex='25' value="UPDATE">
                                <?php if (isset($IsDeadMinor) && !empty($IsDeadMinor) && $IsDeadMinor == 'Y') { ?>
                                    <a tabindex='27' href="<?= base_url('newcase/subordinate_court') ?>" class="btn btn-primary" type="button">Next</a>
                                <?php } else { ?>
                                    <a tabindex='27' href="<?= base_url('newcase/subordinate_court') ?>" class="btn quick-btn" type="button">Next</a>
                                <?php } ?>
                            <?php } else { ?>
                                <input type="submit" class="quick-btn gray-btn" id="pet_save" value="SAVE" tabindex='24'>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                    $isdead_data = '';
                    if (isset($is_dead_data) && !empty($is_dead_data)) {
                        $isdead_data = $is_dead_data;
                    }
                    $partyid = !empty(@$party_details[0]['party_id']) ? (int) @$party_details[0]['party_id'] : null;
                    ?>
                    <input type="hidden" name="partyid" id="partyid" value="<?php echo $partyid; ?>" />
                    <input type="hidden" name="is_dead_data" id="is_dead_data" value="<?php echo $isdead_data; ?>" />
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
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
<script src="<?= base_url(); ?>assets/js/sweetalert.min.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/sweetalert.css">

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


<script>
    $(".sci_validation").keyup(function() {
        var initVal = $(this).val();
        outputVal = initVal.replace(/[^a-z,^A-Z^0-9\.@,/'()\s"\-]/g, "").replace(/^\./, "");
        //validate_alpha_numeric_single_double_quotes_bracket_with_special_characters
        if (initVal != outputVal) {
            $(this).val(outputVal);
        }
    });
</script>
<script type="text/javascript">
    var state_Arr = '<?php echo json_encode($stateArr); ?>';
    //----------Get District List----------------------//
    $('#party_state').change(function() {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $('#party_district').val('');
        var get_state_id = $(this).val();
        $.ajax({
            type: "POST",
            data: {
                CSRF_TOKEN: CSRF_TOKEN_VALUE,
                state_id: get_state_id
            },
            url: "<?php echo base_url('newcase/Ajaxcalls/get_districts'); ?>",
            success: function(data) {
                $('.party_district').html(data);
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function() {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
    });

    function validateInput(event) {
        const input = event.target.value;
        const regex = /^[a-zA-Z@_ ]*$/;
        if (!regex.test(input)) {
            event.target.value = input.replace(/[^a-zA-Z@_ ]+/g, '');
        }
    }
    $(document).ready(function() {
        

        // $('.party_name').bind('keyup blur', function() {
        //     var node = $(this);
        //     node.val(node.val().replace(/[^a-z]/g, ''));
        // })
        // $('.relative_name').bind('keyup blur', function() {
        //     var node = $(this);
        //     node.val(node.val().replace(/[^a-z]/g, ''));
        // })
    });
    //---------- Hide and show Individual and Org form----------------------//
    $(document).ready(function() {
        <?php $party_id = !empty($party_details) ? $party_details[0]['party_type'] : ''; ?>
        var party_as_sel = '{{ $party_id }}';
        if (party_as_sel != '') {
            get_party_as(party_as_sel); //--call to selected
        }
    });
    $('.party_name').attr('required', 'required');
    $('.relation').attr('required', 'required');
    $('.relative_name').attr('required', 'required');
    $('input[name="party_gender"]').attr('required', 'required');
    $('#party_age').attr('required', 'required');

    function get_party_as(value) {
        var party_as = value;
        if (party_as == 'I') {
            $('#indvidual_form').show();
            $('#org_form').hide();
            $('#org_state_row').show();
            // $('#org_state').val('');
            // $('#org_dept').val('');
            // $('#org_post').val('');
            $('#otherOrgState').hide();
            $('#otherOrgDept').hide();
            $('#otherOrgPost').hide();
            $('#party_age').attr('required', 'required');
            $('input[name="party_gender"]').attr('required', 'required');

            $('.party_name').attr('required', 'required');
            $('.relation').attr('required', 'required');
            $('.relative_name').attr('required', 'required');
            // $('#party_dob').attr('required', 'required');
            $('.org_state_name').removeAttr('required', 'required');
            $('.org_post').removeAttr('required', 'required');
        } else {
            $('#party_age').attr('required', false);
            $('input[name="party_gender"]').attr('required', false);

            get_departments(party_as);
            get_posts();
            if (party_as == 'D3') {
                $('#indvidual_form').hide();
                $('#org_form').show();
                $('#org_state_row').hide();
                $('#otherOrgState').hide();
                $('.org_state_name').removeAttr('required', 'required');
                $('.org_post').attr('required', 'required');
                $('.party_name').removeAttr('required', 'required');
                $('.relation').removeAttr('required', 'required');
                $('.relative_name').removeAttr('required', 'required');
                // $('#party_name').val('');
                // $('#relation').val('');
                // $('#relative_name').val('');
                // $('#party_dob').val('');
                // $('#party_age').val('');
            } else {
                $('#indvidual_form').hide();
                $('#org_form').show();
                $('#org_state_row').show();
                $('.org_post').attr('required', 'required');
                $('.party_name').removeAttr('required', 'required');
                $('.relation').removeAttr('required', 'required');
                $('.relative_name').removeAttr('required', 'required');
                // $('.org_state_name').attr('required', 'required');
                // $('#party_name').val('');
                // $('#relation').val('');
                // $('#relative_name').val('');
                // $('#party_dob').val('');
                // $('#party_age').val('');
            }
        }
    }
    // $(document).ready(function() {
    //     $("input[name='party_name']").on('input', function(e) {
    //         $(this).val($(this).val().replace(/[^0-9]/g, ''));
    //     });
    //     $("input[name='relative_name']").on('input', function(e) {
    //         $(this).val($(this).val().replace(/[^0-9]/g, ''));
    //     });
    // });
    //---------- Organisation State Name----------------------//
    $('#org_state').change(function() {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        var org_state = $(this).val();
        if (org_state == '<?php echo url_encryption(0); ?>') {
            $('#otherOrgState').show();
            $('#otherOrgDept').show();
            $('#otherOrgPost').show();
            $('#org_dept').val('<?php echo url_encryption(0); ?>');
            $('#org_post').val('<?php echo url_encryption(0); ?>');
        } else {
            $('#otherOrgState').hide();
            $('#otherOrgDept').hide();
            $('#otherOrgPost').hide();
            // $('#org_dept').val('');
            // $('#org_post').val('');
        }
    });
    //---------- Organisation Department Name----------------------//
    $('#org_dept').change(function() {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        var org_dept = $(this).val();
        if (org_dept == '<?php echo url_encryption(0); ?>') {
            $('#otherOrgDept').show();
            $('#otherOrgPost').show();
            $('#org_post').val('<?php echo url_encryption(0); ?>');
        } else {
            $('#otherOrgDept').hide();
            $('#otherOrgPost').hide();
            // $('#org_post').val('');
        }
    });
    //---------- Organisation Post Name----------------------//
    $('#org_post').change(function() {
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
        <?php $st_id = !empty(@$party_details[0]->org_state_id) ? url_encryption(@$party_details[0]->org_state_id) : ''; ?>
        var selected_org_st_id = '<?php echo $st_id; ?>';
        <?php $dpt_id = !empty(@$party_details[0]->org_dept_id) ? url_encryption(@$party_details[0]->org_dept_id) : ''; ?>
        var selected_dept_id = '<?php echo $dpt_id; ?>';
        $.ajax({
            type: "POST",
            data: {
                CSRF_TOKEN: CSRF_TOKEN_VALUE,
                party_is: party_is,
                selected_org_st_id: selected_org_st_id,
                selected_dept_id: selected_dept_id
            },
            url: "<?php echo base_url('newcase/Ajaxcalls/get_org_departments'); ?>",
            success: function(data) {
                $('.filter_select_dropdown').select2();
                var response = data.split('$$$$$');
                $('.org_state').html(response[0]);
                $('.org_dept').html(response[1]);
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function() {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
    }

    function get_posts() {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        <?php $pos_id = !empty(@$party_details[0]->org_post_id) ? url_encryption(@$party_details[0]->org_post_id) : ''; ?>
        var selected_post_id = '';
        $.ajax({
            type: "POST",
            data: {
                CSRF_TOKEN: CSRF_TOKEN_VALUE,
                selected_post_id: selected_post_id
            },
            url: "<?php echo base_url('newcase/Ajaxcalls/get_org_posts'); ?>",
            success: function(data) {
                $('.org_post').html(data);
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function() {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.is_dead_class', function() {
            var is_dead_minor = $('input[name="is_dead_minor"]:checked').val();
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            var country_id = $("#country_id option:selected").val();
            if (country_id) {
                $.ajax({
                    type: "POST",
                    data: {
                        CSRF_TOKEN: CSRF_TOKEN_VALUE,
                        doc_type_code: country_id
                    },
                    url: "<?php echo base_url('documentIndex/Ajaxcalls/get_index_type'); ?>",
                    success: function(res) {
                        if ((is_dead_minor) && is_dead_minor == '1' && (res == 96 || res !=
                                96)) {
                            $("#party_dob").attr('required', false);
                            $("#party_age").attr('required', false);
                            $("#party_age_span").html('');
                            $("#party_age_span").css({
                                'color': ''
                            });
                            $("#address_span").html('');
                            $("#address_span").css({
                                'color': ''
                            });
                            $("#party_address").attr('required', false);
                            $("#city_span").html('');
                            $("#city_span").css({
                                'color': ''
                            });
                            $("#party_city").attr('required', false);
                            $("#state_span").html('');
                            $("#state_span").css({
                                'color': ''
                            });
                            $("#party_state").attr('required', false);
                            $("#district_span").html('');
                            $("#district_span").css({
                                'color': ''
                            });
                            $("#party_district").attr('required', false);
                        } else if ((is_dead_minor) && is_dead_minor == '0' && (res != 96)) {
                            $("#party_dob").attr('required', false);
                            $("#party_age").attr('required', false);
                            $("#party_age_span").html('');
                            $("#party_age_span").css({
                                'color': ''
                            });
                            $("#address_span").html('');
                            $("#address_span").css({
                                'color': ''
                            });
                            $("#party_address").attr('required', false);
                            $("#city_span").html('');
                            $("#city_span").css({
                                'color': ''
                            });
                            $("#party_city").attr('required', false);
                            $("#state_span").html('');
                            $("#state_span").css({
                                'color': ''
                            });
                            $("#party_state").attr('required', false);
                            $("#district_span").html('');
                            $("#district_span").css({
                                'color': ''
                            });
                            $("#party_district").attr('required', false);
                        } else if ((is_dead_minor) && is_dead_minor == '0' && (res == 96)) {
                            $("#party_age_span").html('*');
                            $("#party_age_span").css({
                                'color': 'red'
                            });
                            $("#address_span").html('*');
                            $("#address_span").css({
                                'color': 'red'
                            });
                            $("#party_age").attr('required', true);
                            $("#party_address").attr('required', true);
                            $("#city_span").html('*');
                            $("#city_span").css({
                                'color': 'red'
                            });
                            $("#party_city").attr('required', true);
                            $("#state_span").html('*');
                            $("#state_span").css({
                                'color': 'red'
                            });
                            $("#party_state").attr('required', true);
                            $("#district_span").html('*');
                            $("#district_span").css({
                                'color': 'red'
                            });
                            $("#party_district").attr('required', true);
                            var partyid = $("#partyid").val();
                            var is_dead_data = $("#is_dead_data").val();
                            var form_data = {};
                            form_data.current_party_id = partyid;
                            if (partyid && is_dead_data) {
                                var confirmData = confirm(
                                    "You changed isdead/minor to live, legal representative data automatic removed."
                                );
                                if (confirmData == true) {
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url('csrftoken/DefaultController/updateIsDeadMinorData'); ?>",
                                        data: JSON.stringify(form_data),
                                        async: false,
                                        dataType: 'json',
                                        ContentType: 'application/json',
                                        success: function(result) {
                                            result = JSON.parse(result);
                                            if (result.status) {
                                                window.location.reload();
                                            }
                                            $.getJSON("<?php echo base_url() . 'csrftoken'; ?>",
                                                function(result) {
                                                    $('[name="CSRF_TOKEN"]')
                                                        .val(result
                                                            .CSRF_TOKEN_VALUE
                                                        );
                                                });
                                        },
                                        error: function() {
                                            $.getJSON("<?php echo base_url() . 'csrftoken'; ?>",
                                                function(result) {
                                                    $('[name="CSRF_TOKEN"]')
                                                        .val(result
                                                            .CSRF_TOKEN_VALUE
                                                        );
                                                });
                                        }
                                    });
                                } else {
                                    $("#party_dob").attr('required', false);
                                    $("#party_age").attr('required', false);
                                    $("#party_age_span").html('');
                                    $("#party_age_span").css({
                                        'color': ''
                                    });
                                    $("#address_span").html('');
                                    $("#address_span").css({
                                        'color': ''
                                    });
                                    $("#party_address").attr('required', false);
                                    $("#city_span").html('');
                                    $("#city_span").css({
                                        'color': ''
                                    });
                                    $("#party_city").attr('required', false);
                                    $("#state_span").html('');
                                    $("#state_span").css({
                                        'color': ''
                                    });
                                    $("#party_state").attr('required', false);
                                    $("#district_span").html('');
                                    $("#district_span").css({
                                        'color': ''
                                    });
                                    $("#party_district").attr('required', false);
                                    $("#is_dead_minor_1").attr('checked', true);
                                }
                            }
                        }
                    }
                });
            } else {
                if ((is_dead_minor) && is_dead_minor == '1') {
                    $("#party_dob").attr('required', false);
                    $("#party_age").attr('required', false);
                    $("#party_age_span").html('');
                    $("#party_age_span").css({
                        'color': ''
                    });
                    $("#address_span").html('');
                    $("#address_span").css({
                        'color': ''
                    });
                    $("#party_address").attr('required', false);
                    $("#city_span").html('');
                    $("#city_span").css({
                        'color': ''
                    });
                    $("#party_city").attr('required', false);
                    $("#state_span").html('');
                    $("#state_span").css({
                        'color': ''
                    });
                    $("#party_state").attr('required', false);
                    $("#district_span").html('');
                    $("#district_span").css({
                        'color': ''
                    });
                    $("#party_district").attr('required', false);
                } else {
                    $("#party_age_span").html('*');
                    $("#party_age_span").css({
                        'color': 'red'
                    });
                    $("#address_span").html('*');
                    $("#address_span").css({
                        'color': 'red'
                    });
                    $("#party_age").attr('required', true);
                    $("#party_address").attr('required', true);
                    $("#city_span").html('*');
                    $("#city_span").css({
                        'color': 'red'
                    });
                    $("#party_city").attr('required', true);
                    $("#state_span").html('*');
                    $("#state_span").css({
                        'color': 'red'
                    });
                    $("#party_state").attr('required', true);
                    $("#district_span").html('*');
                    $("#district_span").css({
                        'color': 'red'
                    });
                    $("#party_district").attr('required', true);
                    var partyid = $("#partyid").val();
                    var is_dead_data = $("#is_dead_data").val();
                    var form_data = {};
                    form_data.current_party_id = partyid;
                    if (partyid && is_dead_data) {
                        var confirmData = confirm(
                            "You changed isdead/minor to live, legal representative data automatic removed."
                        );
                        if (confirmData == true) {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url('csrftoken/DefaultController/updateIsDeadMinorData'); ?>",
                                data: JSON.stringify(form_data),
                                async: false,
                                dataType: 'json',
                                ContentType: 'application/json',
                                success: function(result) {
                                    result = JSON.parse(result);
                                    if (result.status) {
                                        window.location.reload();
                                    }
                                    $.getJSON("<?php echo base_url() . 'csrftoken'; ?>", function(result) {
                                        $('[name="CSRF_TOKEN"]').val(result
                                            .CSRF_TOKEN_VALUE);
                                    });
                                },
                                error: function() {
                                    $.getJSON("<?php echo base_url() . 'csrftoken'; ?>", function(result) {
                                        $('[name="CSRF_TOKEN"]').val(result
                                            .CSRF_TOKEN_VALUE);
                                    });
                                }
                            });
                        } else {
                            $("#party_dob").attr('required', false);
                            $("#party_age").attr('required', false);
                            $("#party_age_span").html('');
                            $("#party_age_span").css({
                                'color': ''
                            });
                            $("#address_span").html('');
                            $("#address_span").css({
                                'color': ''
                            });
                            $("#party_address").attr('required', false);
                            $("#city_span").html('');
                            $("#city_span").css({
                                'color': ''
                            });
                            $("#party_city").attr('required', false);
                            $("#state_span").html('');
                            $("#state_span").css({
                                'color': ''
                            });
                            $("#party_state").attr('required', false);
                            $("#district_span").html('');
                            $("#district_span").css({
                                'color': ''
                            });
                            $("#party_district").attr('required', false);
                            $("#is_dead_minor_1").attr('checked', true);
                        }

                    }
                }
            }
        });
        $('#add_respondent').on('submit', function() {
            // if ($('#add_respondent').valid()) {
                var is_dead_minor = $('input[name="is_dead_minor"]:checked').val();
                var form_data = $(this).serialize();
                form_data += '&is_dead_minor=' + is_dead_minor;
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>newcase/respondent/add_respondent",
                    data: form_data,
                    async: false,
                    beforeSend: function() {
                        $('#pet_save').val('Please wait...');
                        $('#pet_save').prop('disabled', true);
                    },
                    success: function(data) {
                        $('#pet_save').val('SAVE');
                        $('#pet_save').prop('disabled', false);
                        var resArr = data.split('@@@');
                        if (resArr[0] == 1) {
                            alert(resArr[1]);
                        } else if (resArr[0] == 2) {
                            alert(resArr[1]);
                            window.location.href = resArr[2];

                        } else if (resArr[0] == 3) {
                            alert(resArr[1]);
                        }
                        $.getJSON("<?php echo base_url() . 'csrftoken'; ?>", function(result) {
                            $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                        });
                    },
                    error: function() {
                        $.getJSON("<?php echo base_url() . 'csrftoken'; ?>", function(result) {
                            $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                        });
                    }

                });
                return false;
            // } else {
            //     return false;
            // }
        });
    });

    function isNumber(value) {
        return typeof value === 'number';
    }

    $('#party_pincode').blur(function() {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        var pincode = $("#party_pincode").val();
        if (pincode) {
            var stateObj = JSON.parse(state_Arr);
            var options = '';
            options += '<option value="">Select State</option>';
            stateObj.forEach((response) =>
                options += '<option value="' + response.id + '">' + response.state_name + '</option>');
            $('#party_state').html(options).select2().trigger("change");
            $.ajax({
                type: "POST",
                data: {
                    CSRF_TOKEN: CSRF_TOKEN_VALUE,
                    pincode: pincode
                },
                url: "<?php echo base_url('newcase/Ajaxcalls/getAddressByPincode'); ?>",
                success: function(response) {
                    var taluk_name;
                    var district_name;
                    var state;
                    if (response) {
                        var resData = JSON.parse(response);
                        if (resData) {
                            taluk_name = resData[0]['taluk_name'].trim().toUpperCase();
                            district_name = resData[0]['district_name'].trim().toUpperCase();
                            state = resData[0]['state'].trim().toUpperCase();
                        }
                        if (taluk_name) {
                            $("#party_city").val('');
                            $("#party_city").val(taluk_name);
                        } else {
                            $("#party_city").val('');
                        }
                        if (state) {
                            var stateObj = JSON.parse(state_Arr);
                            if (stateObj) {
                                var singleObj = stateObj.find(
                                    item => item['state_name'] === state
                                );
                            }
                            if (singleObj) {
                                $('#party_state').val('');
                                $('#party_state').val(singleObj.id).select2().trigger("change");
                            } else {
                                $('#party_state').val('');
                            }
                            if (district_name) {
                                var stateId = $('#party_state').val();
                                setSelectedDistrict(stateId, district_name);
                            }
                        } else {
                            $('#party_state').val('');
                        }
                    }
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                },
                error: function() {
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                }
            });
        }
    });
    var today = new Date();
    var startYear = 1984;
    var startDate = new Date(startYear, 1, 1);
    $('#party_dob').datepicker({
        format: "dd/mm/yyyy",
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        changeYear: true,
        endDate: today,
        autoclose: true
    });
    $(document).on('change', '#party_dob', function() {
        var value = $('#party_dob').val();
        var parts = value.split("/");
        var day = parts[0] && parseInt(parts[0], 10);
        var month = parts[1] && parseInt(parts[1], 10);
        var year = parts[2] && parseInt(parts[2], 10);
        var str = day + '/' + month + '/' + year;

        var today = new Date();
        var dob = new Date(str);
        // var age = new Date(today - dob).getFullYear() - 1970;
        var age = today.getFullYear() - year;
        $('#party_age').val(age);
    });

    function setSelectedDistrict(stateId, district_name) {
        if (stateId && district_name) {
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $.ajax({
                type: "POST",
                data: {
                    CSRF_TOKEN: CSRF_TOKEN_VALUE,
                    state_id: stateId
                },
                url: "<?php echo base_url('newcase/Ajaxcalls/getSelectedDistricts'); ?>",
                success: function(resData) {
                    if (resData) {
                        var districtObj = JSON.parse(resData);
                        var singleObj = districtObj.find(
                            item => item['district_name'] === district_name
                        );
                        if (singleObj) {
                            $('#party_district').val('');
                            $('#party_district').val(singleObj.id).select2().trigger("change");
                        } else {
                            $('#party_district').val('');
                        }
                    } else {
                        $('#party_district').val('');
                    }
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                },
                error: function() {
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                }
            });
        }
    }

    function ActionToTrash(trash_type) {
        event.preventDefault();
        var trash_type = trash_type;
        var url = "";
        if (trash_type == '') {
            swal("Cancelled", "Your imaginary file is safe :)", "error");
            return false;
        } else if (trash_type == 'UAT') {
            url = "<?php echo base_url('userActions/trash'); ?>";
        } else if (trash_type == 'SLT') {
            url = "<?php echo base_url('stage_list/trash'); ?>";
        } else if (trash_type == 'EAT') {
            url = "<?php echo base_url('userActions/trash'); ?>";
        } else {
            swal("Cancelled", "Your imaginary file is safe :)", "error");
            return false;
        }
        //    alert('trash_type'+trash_type+'url='+url);//return false;
        swal({
                title: "Do you really want to trash this E-Filing,",
                text: "once it will be trashed you can't restore the same.",
                type: "warning",
                position: "top",
                showCancelButton: true,
                confirmButtonColor: "green",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                buttons: ["Make Changes", "Yes!"],
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm) {
                if (isConfirm) { // submitting the form when user press yes
                    var link = document.createElement("a");
                    link.href = url;
                    link.target = "_self";
                    link.click();
                    swal({
                        title: "Deleted!",
                        text: "E-Filing has been deleted.",
                        type: "success",
                        timer: 2000
                    });

                } else {
                    //swal({title: "Cancelled",text: "Your imaginary file is safe.",type: "error",timer: 1300});
                }

            });
    }
</script>