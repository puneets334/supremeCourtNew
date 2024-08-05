<style>
    .input-group-addon {
        padding: 0px !important;
    }

    .select2-container {
        width: 100% !important;
    }

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

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
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
    <h4 style="text-align: center;color: #31B0D5"> Case Details </h4>
    <div class="panel-body">

        <?php
        $attribute = array('class' => 'form-horizontal', 'name' => 'add_case_details', 'id' => 'add_case_details', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data');
        echo form_open('#', $attribute);
        $cause_title = !empty($new_case_details[0]['cause_title']) ? explode(' Vs. ', $new_case_details[0]['cause_title']) : '';
        ?>
        <!--start Upload Duc required="required" (Browse PDF)-->
        <?php
        // echo '<pre>'; print_r($_SESSION);exit(0);
        // echo '<pre>'; print_r( $_SESSION['efiling_details']);
        ?>


        <?php if (in_array($_SESSION['login']['ref_m_usertype_id'], [USER_CLERK,])) { // For Departmment Filing
            //var_dump($_SESSION['login']);var_dump($selected_aor);
        ?>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    <div class="form-group">
                        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12">Select AOR <span style="color: red">*</span> :</label>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <select name="impersonated_aor" id="impersonated_aor" required>
                                <option value="" title="Select">Select AOR</option>
                                <?php
                                if (count($clerk_aor)) {
                                    foreach ($clerk_aor as $dataRes) {
                                        $sel = ($selected_aor[0]->aor_code == (string) $dataRes->aor_code) ? "selected=selected" : '';
                                ?>
                                        <option <?php echo $sel; ?> value="<?= $dataRes->aor_code; ?>"><?php echo_data($dataRes->name . ' (' . $dataRes->aor_code . ')'); ?> </option>;
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <br /> <br />
        <?php } ?>


        <?php if (in_array($_SESSION['login']['ref_m_usertype_id'], [USER_ADVOCATE,]) && !empty($aor_department)) { // For Departmment Filing    var_dump($_SESSION);var_dump($department_aor);
        ?>
            <!--<div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    <div class="form-group">
                        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12">Select Department  :</label>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <select name="impersonated_department" id="impersonated_department" required>
                                <option value="" title="Select">Select Department</option>
                                <?php
                                /*                                foreach ($aor_department as $dataRes) {
                                    $sel = ($selected_department[0]->ref_department_id == (string) $dataRes->id ) ? "selected=selected" : '';
                                    */ ?>
                                    <option <?php /*echo $sel; */ ?> value="<?/*=$dataRes->id; */ ?>"><?php /*echo_data($dataRes->department_name.' ('.$dataRes->ministry_name.')'); */ ?> </option>;
                                    <?php
                                    /*                                }
                                */ ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <br/> <br/>-->
        <?php } ?>
        <!--end Upload Duc-->
        <?= ASTERISK_RED_MANDATORY; ?>
        <div id="newCaseSaveForm-Stop">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Cause Title Petitioner
                                    <span style="color: red">*</span></label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <div class="input-group">
                                        <textarea tabindex='1' id="cause_pet" name="cause_pet" minlength="3" maxlength="99" class="form-control input-sm" placeholder="Cause Title Petitioner" type="text" required><?php echo_data($cause_title[0]); ?></textarea>
                                        <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Petitioner name should be in characters (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
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
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Cause Title Respondent
                                    <span style="color: red">*</span></label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <div class="input-group">
                                        <textarea tabindex='2' id="cause_res" name="cause_res" minlength="3" maxlength="99" class="form-control input-sm" placeholder="Cause Title Respondent" type="text" required><?php echo_data($cause_title[1]); ?></textarea>
                                        <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Respondent name should be in characters (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
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
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Case Type <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select tabindex='3' name="sc_case_type" id="sc_case_type" class="form-control input-sm filter_select_dropdown sc_case_type" required>
                                        <option value="" title="Select">Select Case Type</option>
                                        <?php
                                        if (count($sc_case_type)) {
                                            foreach ($sc_case_type as $dataRes) {
                                                $sel = ($new_case_details[0]['sc_case_type_id'] == (string) $dataRes->casecode) ? "selected=selected" : '';
                                        ?>
                                                <option <?php echo $sel; ?> value="<?php echo_data(url_encryption(trim($dataRes->casecode))); ?>"><?php echo_data($dataRes->casename); ?> </option>;
                                        <?php
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
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Special Case Type <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <?php
                                    $selectNone = $new_case_details[0]['sc_sp_case_type_id'] == '1' ? 'selected=selected' : '';
                                    $selectJP = $new_case_details[0]['sc_sp_case_type_id'] == '6' ? 'selected=selected' : '';
                                    $selectPUD = $new_case_details[0]['sc_sp_case_type_id'] == '7' ? 'selected=selected' : '';
                                    ?>
                                    <select tabindex='4' name="sc_sp_case_type_id" id="sc_sp_case_type_id" class="form-control input-sm filter_select_dropdown" style="width: 100%" required onchange="getdtmodel()">
                                        <option value="" title="Select">Select Special Case Type</option>
                                        <option <?php echo $selectNone; ?> value="1" selected>NONE</option>
                                        <option <?php echo $selectJP; ?> value="6">JAIL PETITION</option>
                                        <option <?php echo $selectPUD; ?> value="7">PUD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--//XXXXXXXXXXXXXXXXXXXXXXXXXX-->


                        <!--   <div class="col-sm-12 col-xs-12" id="dtsign">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Date of signature of jail incharge :</label>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <div class="input-group">
                                    <input tabindex = '5' class="form-control has-feedback-left" id="datesignjail" name="datesignjail" value="<?php echo $new_case_details[0]['jail_signature_date']; ?>" maxlength="10" readonly="" placeholder="DD/MM/YYYY"  type="text">
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Please Enter Date of Birth.">
                                        <i class="fa fa-question-circle-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div> -->


                        <!--//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Main Category <span style="color: red">*</span>:</label>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <select tabindex='5' name="subj_cat_main" id="subj_cat_main" class="form-control input-sm filter_select_dropdown">
                                    <option value="" title="Select">Select Main Category </option>
                                    <?php
                                    if (count($main_subject_cat)) {
                                        foreach ($main_subject_cat as $dataRes) {
                                            $sel = ($new_case_details[0]['subj_main_cat'] == $dataRes->id) ? "selected=selected" : '';
                                    ?>
                                            <option <?php echo $sel; ?> value="<?php echo_data(url_encryption(trim($dataRes->id . '##' . $dataRes->subcode1))); ?>"><?php echo_data(strtoupper($dataRes->sub_name1));
                                                                                                                                                                    if (!empty($dataRes->category_sc_old)) {
                                                                                                                                                                        echo ' (' . $dataRes->category_sc_old . ')';
                                                                                                                                                                    } ?> </option>;
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Sub Category :</label>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <select tabindex='6' name="subj_sub_cat_1" id="subj_sub_cat_1" class="form-control input-sm filter_select_dropdown subj_sub_cat_1">
                                    <option value="" title="Select">Select Sub Category </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Special Category :
                                    <!--<span style="color: red">*</span>--></label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select id="special_category" name="special_category" class="form-control input-sm filter_select_dropdown" required>
                                        <!--<option value="0" selected="selected">None</option>-->
                                        <?php
                                        if (count($special_category)) {
                                            $sel = ($new_case_details[0]['special_category'] == 0) ? "selected=selected" : ''; ?>
                                            <option <?php echo $sel; ?> value="<?php echo_data(url_encryption(0)); ?>"><?php echo_data(strtoupper('None')); ?> </option>
                                            <?php
                                            foreach ($special_category as $specCat) {
                                                $sel = ($new_case_details[0]['special_category'] == $specCat->id) ? "selected=selected" : '';
                                            ?>
                                                <option <?php echo $sel; ?> value="<?php echo_data(url_encryption(trim($specCat->id))); ?>"><?php echo_data(strtoupper($specCat->category_name)); ?> </option>;
                                        <?php
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <span id="subcatLoadData"></span>

                        </div>
                    </div>
                    <div class="row" id="divResult11">

                    </div>
                    <!--<div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Sub Category 2 :</label>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <select tabindex = '7' name="subj_sub_cat_2" id="subj_sub_cat_2" class="form-control input-sm filter_select_dropdown subj_sub_cat_2">
                                <option value="" title="Select">Select Sub Category 2</option>                                    

                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Sub Category 3 :</label>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <select tabindex = '8' name="subj_sub_cat_3" id="subj_sub_cat_3" class="form-control input-sm filter_select_dropdown subj_sub_cat_3">
                                <option value="" title="Select">Select Sub Category 3</option>                                    

                            </select>
                        </div>
                    </div>
                </div>-->
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">IF SCLSC </label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <label class="switch">
                                        <input type="checkbox" name="if_sclsc" id="if_sclsc" <?php echo (!empty($new_case_details[0]['if_sclsc']) && ($new_case_details[0]['if_sclsc'] == 1)) ? 'checked' : ''  ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (!is_null($_SESSION['login']['department_id'])) { ?>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Whether filed by Government? </label>
                                    <div class="col-md-7 col-sm-12 col-xs-12">
                                        <label class="switch">
                                            <input type="checkbox" name="is_govt_filing" id="is_govt_filing" <?php echo (!empty($new_case_details[0]['is_govt_filing']) && ($new_case_details[0]['is_govt_filing'] == 1)) ? 'checked' : ''  ?>>
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
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">No of Petitioner (S)
                                    <span style="color: red">*</span></label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <div class="input-group">
                                        <input id="no_of_petitioners" name="no_of_petitioners" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $new_case_details[0]['no_of_petitioners']; ?>" minlength="1" class="form-control input-sm" placeholder="No of Petitioner" type="number">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">No of Respondent (S)
                                    <span style="color: red">*</span></label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <div class="input-group">
                                        <input id="no_of_respondents" name="no_of_respondents" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="<?php echo $new_case_details[0]['no_of_respondents']; ?>" minlength="1" class="form-control input-sm" placeholder="No of Respondent" type="number" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-8 col-sm-12 col-xs-12 input-sm">Earlier Courts Details(<span style="color: red">Order Challenged</span>)
                                    &nbsp;&nbsp;&nbsp;<input tabindex="8" type="checkbox" name="Earlier_not_court_type" id="Earlier_not_court_type" value="4" <?php echo (!empty($new_case_details[0]['court_type']) && $new_case_details[0]['court_type'] == 4) ? 'checked' : ''  ?>>No Earlier Court</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Court Type<span style="color: red">*</span></label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select id="court_name" name="court_name" class="form-control input-sm filter_select_dropdown" required>
                                        <option value="">Select Court Name</option>
                                        <?php
                                        if (isset($new_case_details[0]['court_type']) && !empty($new_case_details[0]['court_type'])) {
                                        ?>
                                            <option value="4" <?php echo (!empty($new_case_details[0]['court_type']) && $new_case_details[0]['court_type'] == 4) ? 'selected="selected"' : ''  ?>>Supreme Court</option>
                                            <option value="1" <?php echo (!empty($new_case_details[0]['court_type']) && $new_case_details[0]['court_type'] == 1) ? 'selected="selected"' : ''  ?>>High Court</option>
                                            <option value="3" <?php echo (!empty($new_case_details[0]['court_type']) && $new_case_details[0]['court_type'] == 3) ? 'selected="selected"' : ''  ?>>District Court</option>
                                            <option value="5" <?php echo (!empty($new_case_details[0]['court_type']) && $new_case_details[0]['court_type'] == 5) ? 'selected="selected"' : ''  ?>>State Agency</option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="4">Supreme Court</option>
                                            <option value="1" selected="selected">High Court</option>
                                            <option value="3">District Court</option>
                                            <option value="5">State Agency</option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- supreme_court start-->
                    <div class="row" id="supreme_court1" <?php echo (!empty($supreme_court_bench) && isset($supreme_court_bench)) ? 'style="display:block"' : 'style="display:none"'; ?>>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">State Name <span style="color: red">*</span></label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select id="supreme_state_name" name="supreme_state_name" class="form-control input-sm filter_select_dropdown" readonly="readonly">
                                        <option value="">Select State Name</option>
                                        <?php
                                        if (isset($supreme_court_state) && !empty($supreme_court_state)) {
                                            foreach ($supreme_court_state as $k => $v) {
                                                if (isset($new_case_details[0]['supreme_court_state']) && !empty($new_case_details[0]['supreme_court_state']) && $new_case_details[0]['supreme_court_state'] == $v['id']) {
                                                    echo '<option value="' . $v['id'] . '" selected="selected">' . $v['name'] . '</option>';
                                                } else {
                                                    echo '<option value="' . $v['id'] . '">' . $v['name'] . '</option>';
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="supreme_court2" class="row" <?php echo (!empty($supreme_court_bench) && isset($supreme_court_bench)) ? 'style="display:block"' : 'style="display:none"'; ?>>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Bench Name<span style="color: red">*</span></label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select id="supreme_bench_name" name="supreme_bench_name" class="form-control input-sm filter_select_dropdown" readonly="readonly">
                                        <option value="">Select Bench Name</option>
                                        <?php
                                        if (isset($supreme_court_bench) && !empty($supreme_court_bench)) {
                                            foreach ($supreme_court_bench as $k => $v) {
                                                if (isset($new_case_details[0]['supreme_court_bench']) && !empty($new_case_details[0]['supreme_court_bench']) && $new_case_details[0]['supreme_court_bench'] == $v['id']) {
                                                    echo '<option value="' . $v['id'] . '" selected="selected">' . $v['name'] . '</option>';
                                                } else {
                                                    echo '<option value="' . $v['id'] . '">' . $v['name'] . '</option>';
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- supreme_court end-->
                    <!-- high_court start-->
                    <?php
                    //  echo '<pre>'; print_r($high_court_bench); exit;
                    ?>
                    <div class="row" id="high_court_div1" <?php echo ((!empty(@$high_court_drop_down))) ? 'style="display:block"' : 'style="display:none"'; ?>>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">High Court Name
                                    <span style="color: red">*</span></label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select id="high_courtname" name="high_courtname" class="form-control input-sm filter_select_dropdown">
                                        <option value="">Select High Court</option>
                                        <?php

                                        if (!empty(@$high_court_drop_down)) {
                                            foreach (@$high_court_drop_down as $k => $v) {
                                                if ($v['hc_id'] ==  $new_case_details[0]['estab_id'])
                                                    echo '<option selected="selected" value="' . escape_data(url_encryption($v['hc_id'] . "##" . $v['name'])) . '">' . escape_data(strtoupper($v['name'])) . '</option>';
                                                else
                                                    echo '<option value="' . escape_data(url_encryption($v['hc_id'] . "##" . $v['name'])) . '">' . escape_data(strtoupper($v['name'])) . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="high_court_div2" <?php echo ((!empty($high_court_bench) && isset($high_court_bench))) ? 'style="display:block"' : 'style="display:none"'; ?>>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Bench Name
                                    <span style="color: red">*</span></label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select id="high_court_bench_name" name="high_court_bench_name" class="form-control input-sm filter_select_dropdown">
                                        <option value="">Select Bench Name</option>
                                        <?php
                                        if (isset($high_court_bench) && !empty($high_court_bench)) {
                                            foreach ($high_court_bench as $k => $bench) {
                                                if ($bench['est_code'] == $new_case_details[0]['estab_code'])
                                                    echo  '<option selected="selected" value="' . escape_data(url_encryption($bench['bench_id'] . "##" . $bench['name'] . "##" . $bench['est_code'])) . '">' . escape_data(strtoupper($bench['name'])) . '</option>';
                                                else
                                                    echo '<option value="' . escape_data(url_encryption($bench['bench_id'] . "##" . $bench['name'] . "##" . $bench['est_code'])) . '">' . escape_data(strtoupper($bench['name'])) . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- high_court end-->
                    <!-- district_court start-->
                    <div class="row" id="district_court1" <?php echo (!empty($state_list) && isset($state_list)) ? 'style="display:block"' : 'style="display:none"'; ?>>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">State Name
                                    <span style="color: red">*</span></label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select id="district_court_state_name" name="district_court_state_name" class="form-control input-sm filter_select_dropdown">
                                        <option value="">Select State</option>
                                        <?php
                                        if (isset($state_list) && !empty($state_list)) {
                                            foreach ($state_list as $k => $state) {
                                                if (isset($new_case_details[0]['state_id']) && !empty($new_case_details[0]['state_id']) && $new_case_details[0]['state_id'] == $state['state_code']) {
                                                    echo '<option selected="selected" value="' . escape_data(url_encryption($state['state_code'] . '#$' . $state['state_name'] . '#$' . $state['state_name'])) . '">' . escape_data(strtoupper($state['state_name'])) . '</option>';
                                                } else {
                                                    echo '<option  value="' . escape_data(url_encryption($state['state_code'] . '#$' . $state['state_name'] . '#$' . $state['state_name'])) . '">' . escape_data(strtoupper($state['state_name'])) . '</option>';
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="district_court2" <?php echo (!empty($state_list) && isset($state_list)) ? 'style="display:block"' : 'style="display:none"'; ?>>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">District
                                    <span style="color: red">*</span></label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select id="district_court_district_name" name="district_court_district_name" class="form-control input-sm filter_select_dropdown">
                                        <option value="">Select District</option>
                                        <?php
                                        if (isset($district_list) && !empty($district_list)) {
                                            foreach ($district_list as $k => $district) {
                                                if (isset($new_case_details[0]['district_id']) && !empty($new_case_details[0]['district_id']) && $new_case_details[0]['district_id'] == $district['district_code']) {
                                                    echo '<option selected="selected" value="' . htmlentities(url_encryption($district['district_code'] . '#$' . $district['district_name']), ENT_QUOTES) . '">' . htmlentities(strtoupper($district['district_name']), ENT_QUOTES) . '</option>';
                                                } else {
                                                    echo '<option  value="' . htmlentities(url_encryption($district['district_code'] . '#$' . $district['district_name']), ENT_QUOTES) . '">' . htmlentities(strtoupper($district['district_name']), ENT_QUOTES) . '</option>';
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- district_court end-->
                    <!-- state_agency start-->
                    <div class="row" id="state_agency_div1" <?php echo (!empty($state_agency_list) && isset($state_agency_list)) ? 'style="display:block"' : 'style="display:none"'; ?>>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">State Name
                                    <span style="color: red">*</span></label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select id="state_agency" name="state_agency" class="form-control input-sm filter_select_dropdown">
                                        <option value="">Select State</option>
                                        <?php
                                        if (isset($state_agency_list) && !empty($state_agency_list)) {
                                            foreach ($state_agency_list as $dataRes) {
                                                if (isset($new_case_details[0]['state_id']) && !empty($new_case_details[0]['state_id']) && $new_case_details[0]['state_id'] == $dataRes->cmis_state_id) {
                                                    echo '<option selected="selected" value="' . escape_data(url_encryption($dataRes->cmis_state_id . '#$' . $dataRes->agency_state)) . '">' . escape_data(strtoupper($dataRes->agency_state)) . '</option>';
                                                } else {
                                                    echo '<option value="' . escape_data(url_encryption($dataRes->cmis_state_id . '#$' . $dataRes->agency_state)) . '">' . escape_data(strtoupper($dataRes->agency_state)) . '</option>';
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="state_agency_div2" <?php echo (!empty($state_agency_list) && isset($state_agency_list)) ? 'style="display:block"' : 'style="display:none"'; ?>>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Agency Name
                                    <span style="color: red">*</span></label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select id="state_agency_name" name="state_agency_name" class="form-control input-sm filter_select_dropdown">
                                        <option value="">Select Agency</option>
                                        <?php
                                        if (isset($agencies) && !empty($agencies)) {
                                            foreach ($agencies as $agency) {
                                                if (isset($new_case_details[0]['estab_id']) && !empty($new_case_details[0]['estab_id']) && $new_case_details[0]['estab_id'] == $agency['id']) {
                                                    echo '<option selected="selected" value="' . escape_data(url_encryption($agency['id'] . "##" . $agency['agency_name'] . "##" . $agency['short_agency_name'])) . '">' . escape_data(strtoupper($agency['short_agency_name'])) . ' - ' . escape_data(strtoupper($agency['agency_name'])) . '</option>';
                                                } else {
                                                    echo '<option value="' . escape_data(url_encryption($agency['id'] . "##" . $agency['agency_name'] . "##" . $agency['short_agency_name'])) . '">' . escape_data(strtoupper($agency['short_agency_name'])) . ' - ' . escape_data(strtoupper($agency['agency_name'])) . '</option>';
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- state_agency end-->





                </div>
                <!--<div class="col-md-6 col-sm-6 col-xs-12">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Write Your Question of Law Here <span style="color: red">*</span>:</label>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <div class="input-group">
                                    <textarea tabindex = '9' name="question_of_law" id="question_of_law" placeholder="Write Your Question of Law Here" class="form-control input-sm"><?php /*echo_data($new_case_details[0]['question_of_law']); */ ?></textarea>
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Please enter House No, Street No, Sector, Colony and Landmarks. Please Select District and Taluka from the below mentioned field. Do not repeat District and Taluka in Address fields and District and Taluka Fields. Address can be alphanumeric (<?php /*echo VALIDATION_PREG_MATCH_MSG; */ ?>).">
                                        <i class="fa fa-question-circle-o" ></i>
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>  

                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Write Your Grounds Here <span style="color: red">*</span>:</label>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <div class="input-group">
                                    <textarea tabindex = '10' name="grounds" id="grounds" placeholder="Write Your Grounds Here" class="form-control input-sm"><?php /*echo_data($new_case_details[0]['grounds']); */ ?></textarea>
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Please enter House No, Street No, Sector, Colony and Landmarks. Please Select District and Taluka from the below mentioned field. Do not repeat District and Taluka in Address fields and District and Taluka Fields. Address can be alphanumeric (<?php /*echo VALIDATION_PREG_MATCH_MSG; */ ?>).">
                                        <i class="fa fa-question-circle-o" ></i>
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Write Your Interim Grounds Here <span style="color: red">*</span>:</label>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <div class="input-group">
                                    <textarea tabindex = '11' name="interim_grounds" id="interim_grounds" placeholder="Write Your Interim Grounds Here" class="form-control input-sm"><?php /*echo_data($new_case_details[0]['grounds_interim']); */ ?></textarea>
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Please enter House No, Street No, Sector, Colony and Landmarks. Please Select District and Taluka from the below mentioned field. Do not repeat District and Taluka in Address fields and District and Taluka Fields. Address can be alphanumeric (<?php /*echo VALIDATION_PREG_MATCH_MSG; */ ?>).">
                                        <i class="fa fa-question-circle-o" ></i>
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Set Out Your Main Prayer Here <span style="color: red">*</span>:</label>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <div class="input-group">
                                    <textarea tabindex = '12' name="main_prayer" id="main_prayer" placeholder="Set Out Your Main Prayer Here " class="form-control input-sm"><?php /*echo_data($new_case_details[0]['main_prayer']); */ ?></textarea>
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Please enter House No, Street No, Sector, Colony and Landmarks. Please Select District and Taluka from the below mentioned field. Do not repeat District and Taluka in Address fields and District and Taluka Fields. Address can be alphanumeric (<?php /*echo VALIDATION_PREG_MATCH_MSG; */ ?>).">
                                        <i class="fa fa-question-circle-o" ></i>
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Set Out Your Interim Relief Here <span style="color: red">*</span>:</label>
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <div class="input-group">
                                    <textarea tabindex = '13' name="interim_relief" id="interim_relief" placeholder="Set Out Your Interim Relief Here" class="form-control input-sm"><?php /*echo_data($new_case_details[0]['interim_relief']); */ ?></textarea>
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Please enter House No, Street No, Sector, Colony and Landmarks. Please Select District and Taluka from the below mentioned field. Do not repeat District and Taluka in Address fields and District and Taluka Fields. Address can be alphanumeric (<?php /*echo VALIDATION_PREG_MATCH_MSG; */ ?>).">
                                        <i class="fa fa-question-circle-o" ></i>
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">

                    <?php if (isset($_SESSION['efiling_details']['registration_id']) && !empty($_SESSION['efiling_details']['registration_id'])) { ?>
                        <input type="submit" tabindex='15' class="btn btn-success" id="pet_save" value="UPDATE">
                        <a href="<?= base_url('newcase/petitioner') ?>" class="btn btn-primary btnNext" type="button">Next</a>
                    <?php } else { ?>
                        <input tabindex='14' type="submit" tabindex='16' class="btn btn-success" id="pet_save" value="SAVE">
                    <?php } ?>
                </div>
            </div>
            <br /><br />
            <div class="row">
                <div class="progress" style="display: none">
                    <div class="progress-bar progress-bar-success myprogress" role="progressbar" value="0" max="100" style="width:0%">0%</div>
                </div>
            </div>
        </div><!--#newCaseSaveForm-->
        <?php echo form_close();
        ?>

    </div>
</div>
<?php
if (!empty($uploaded_docs)) {
    echo '<script>$("#nextButton").show();</script>';
    $this->load->view('uploadDocuments/uploaded_doc_list');
} else {
    echo '<script>$("#nextButton").hide();</script>';
}
?>

<script type="text/javascript">
    <?php if (isset($new_case_details[0]) && !empty($new_case_details[0]) && $new_case_details[0]['subj_sub_cat_1'] == 222) { ?>
        var selected_sub_cat = '<?php echo_data(url_encryption($new_case_details[0]['subj_sub_cat_1'] . '##' . $new_case_details[0]['court_fee_calculation_helper_flag'])); ?>';
        get_matrimonial(selected_sub_cat);


    <?php } ?>
    <?php if (isset($new_case_details[0]) && !empty($new_case_details[0]) && $new_case_details[0]['sc_case_type_id'] == 7) { ?>
        var selected_case_type = '<?php echo_data(url_encryption($new_case_details[0]['sc_case_type_id'] . '##' . $new_case_details[0]['court_fee_calculation_helper_flag'])); ?>';
        get_matrimonial_for_casetype(selected_case_type);
    <?php } ?>

    <?php if (isset($new_case_details[0]) && !empty($new_case_details[0])) { ?>
        var selected_sub_cat = '<?php echo_data(url_encryption($new_case_details[0]['subj_sub_cat_1'])); ?>';
        get_sub_category('subj_sub_cat_1', 'subj_cat_main', selected_sub_cat);

        /*   selected_sub_cat = '<//?php echo_data(url_encryption($new_case_details[0]['subj_sub_cat_2'])); ?>';
           get_sub_category('subj_sub_cat_2', 'subj_sub_cat_1', selected_sub_cat);

           selected_sub_cat = '<//?php echo_data(url_encryption($new_case_details[0]['subj_sub_cat_3'])); ?>';
           get_sub_category('subj_sub_cat_3', 'subj_sub_cat_2', selected_sub_cat);*/

    <?php } ?>

    $('#subj_cat_main').change(function() {
        // alert(this.value);
        var selected_sub_cat = '<?php echo_data(url_encryption($new_case_details[0]['subj_sub_cat_1'])); ?>';
        selected_sub_cat = this.value;

        get_sub_category('subj_sub_cat_1', 'subj_cat_main', selected_sub_cat);
    });

    function get_sub_category(curr_item, parent_item, selected_val) {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        var selected_sub_cat = selected_val;
        var category_code = document.getElementById(parent_item).value;
        $.ajax({
            type: "POST",
            data: {
                CSRF_TOKEN: CSRF_TOKEN_VALUE,
                selected_sub_cat: selected_sub_cat,
                category_code: category_code
            },
            url: "<?php echo base_url('newcase/Ajaxcalls/get_sub_category'); ?>",
            success: function(data) {
                $(document.getElementById(curr_item)).html(data);
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

    $('#subj_sub_cat_1').change(function() {
        // alert(this.value);
        var selected_sub_cat = this.value;
        get_matrimonial(selected_sub_cat);
    });
    $('#sc_case_type').change(function() {
        //alert(this.value);
        var selected_case_type = this.value;
        get_matrimonial_for_casetype(selected_case_type);
    });

    function get_matrimonial(selected_val, selected_val2) {

        var selected_sub_cat = selected_val;
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax({
            type: "POST",
            data: {
                CSRF_TOKEN: CSRF_TOKEN_VALUE,
                selected_sub_cat: selected_sub_cat
            },
            url: "<?php echo base_url('newcase/Ajaxcalls/get_sub_cat_check'); ?>",
            success: function(data) {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
                if (data) {
                    $('#subcatLoadData').html(data);

                } else {
                    var selected_case_type = $("#sc_case_type option:selected").val();
                    //get_matrimonial_for_casetype(selected_case_type);
                }
            },
            error: function() {
                $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
    }

    function get_matrimonial_for_casetype(selected_val) {
        var selected_casetype = selected_val;
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax({
            type: "POST",
            data: {
                CSRF_TOKEN: CSRF_TOKEN_VALUE,
                selected_casetype: selected_casetype
            },
            url: "<?php echo base_url('newcase/Ajaxcalls/get_casetype_check'); ?>",
            success: function(data) {
                $('#subcatLoadData').html(data);
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


    function getdtmodel() {
        // alert("hualalalaal");
        var spcasetype_id = $('#sc_sp_case_type_id').val();
        //alert(spcasetype_id);
        if (spcasetype_id == 6) {

            $('#dtsign').show();
            /*var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd
            }
            if (mm < 10) {
                mm = '0' + mm
            }

            today = yyyy + '-' + mm + '-' + dd;
            document.getElementById("datesignjail").setAttribute("max", today);*/



        } else {
            $('#dtsign').hide();
        }

    }

    $('#datesignjail').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd/mm/yy",
        maxDate: new Date


    });
</script>

<script type="text/javascript">
    $(document).ready(function() {

        var spcasetype_id = $('#sc_sp_case_type_id').val();

        var dateSignatureDiv = "<?php echo $new_case_details[0]['jail_signature_date']; ?>";
        //alert(dateSignatureDiv);
        if (dateSignatureDiv && spcasetype_id == 6) {
            $('#dtsign').show();
        } else {
            $('#dtsign').hide();
        }


        $("#sc_sp_case_type_id").select2().on('select2-focus', function() {
            debugger;
            $(this).data('select2-closed', true)
        });

        $('#test').mousedown(function() {
            event.preventDefault();
            $('#tableoptions').show();
        });


        /*start old addcase code*/

        /*end old addcase code*/


        // earlier court data
        //Earlier_not_court_type
        $("#Earlier_not_court_type").change(function() {
            var not_court_type = $("input[name='Earlier_not_court_type']:checked").val();
            var supremeCourtStateOptions = '';
            var supremeCourtBenchOptions = '';
            var courtTypeListOptions = '';
            if (not_court_type == 4) {
                courtTypeListOptions = '<option value="4" selected="selected">Supreme Court</option><option value="1">High Court</option><option value="3" >District Court</option><option value="5" >State Agency</option>';

                supremeCourtStateOptions = '<option selected="selected" value="490506">DELHI</option>';
                supremeCourtBenchOptions = '<option selected="selected" value="10000">DELHI</option>';
                $("#high_court_div1").hide();
                $("#high_court_div2").hide();
                $("#supreme_court1").show();
                $("#supreme_court2").show();
                $("#district_court1").hide();
                $("#district_court2").hide();
                $("#state_agency_div1").hide();
                $("#state_agency_div2").hide();
                $("#court_name").html(courtTypeListOptions);
                $("#supreme_state_name").html(supremeCourtStateOptions);
                $("#supreme_bench_name").html(supremeCourtBenchOptions);
                //$("#Earlier_not_court_type").prop("checked", true);
            } else {
                courtTypeListOptions = '<option value="4" >Supreme Court</option><option selected="selected" value="1">High Court</option><option value="3" >District Court</option><option value="5" >State Agency</option>';

                $("#high_court_div1").show();
                $("#high_court_div2").show();
                $("#supreme_court1").hide();
                $("#supreme_court2").hide();
                $("#district_court1").hide();
                $("#district_court2").hide();
                $("#state_agency_div1").hide();
                $("#state_agency_div2").hide();
                $("#court_name").html(courtTypeListOptions);
                //$("input:radio[name=Earlier_not_court_type]:checked")[0].checked = false;
                $("#Earlier_not_court_type").prop("checked", false);
            }
        });
        $(document).on('change', '#court_name', function() {
            var courtId = parseInt($.trim($(this).val()));
            var supremeCourtStateOptions = '';
            var supremeCourtBenchOptions = '';
            //alert('courtId='+courtId)
            if (courtId) {
                switch (courtId) {
                    case 4:
                        supremeCourtStateOptions = '<option selected="selected" value="490506">DELHI</option>';
                        supremeCourtBenchOptions = '<option selected="selected" value="10000">DELHI</option>';
                        $("#high_court_div1").hide();
                        $("#high_court_div2").hide();
                        $("#supreme_court1").show();
                        $("#supreme_court2").show();
                        $("#district_court1").hide();
                        $("#district_court2").hide();
                        $("#state_agency_div1").hide();
                        $("#state_agency_div2").hide();
                        $("#supreme_state_name").html(supremeCourtStateOptions);
                        $("#supreme_bench_name").html(supremeCourtBenchOptions);
                        $("#Earlier_not_court_type").prop("checked", true);
                        break;
                    case 1: //High Court
                        var CSRF_TOKEN = 'CSRF_TOKEN';
                        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                        $("#high_court_div1").show();
                        $("#high_court_div2").show();
                        $("#supreme_court1").hide();
                        $("#supreme_court2").hide();
                        $("#district_court1").hide();
                        $("#district_court2").hide();
                        $("#state_agency_div1").hide();
                        $("#state_agency_div2").hide();
                        //alert('High court courtId='+courtId);
                        var CSRF_TOKEN = 'CSRF_TOKEN';
                        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>newcase/Ajaxcalls_subordinate_court/get_high_court",
                            data: {
                                CSRF_TOKEN: CSRF_TOKEN_VALUE
                            },
                            async: false,
                            success: function(data) {
                                $("#high_courtname").html(data);
                                $("#high_courtname").select2();
                                //$("input:radio[name=Earlier_not_court_type]:checked")[0].checked = false;
                                $("#Earlier_not_court_type").prop("checked", false);
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
                        break;
                    case 3: //District court
                        var CSRF_TOKEN = 'CSRF_TOKEN';
                        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

                        $("#high_court_div1").hide();
                        $("#high_court_div2").hide();
                        $("#supreme_court1").hide();
                        $("#supreme_court2").hide();
                        $("#state_agency_div1").hide();
                        $("#state_agency_div2").hide();
                        $("#district_court1").show();
                        $("#district_court2").show();
                        //alert('District Court courtId='+courtId)
                        $.ajax({
                            type: "POST",
                            data: {
                                CSRF_TOKEN: CSRF_TOKEN_VALUE
                            },
                            url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/get_state_list'); ?>",
                            success: function(data) {
                                $('#district_court_state_name').html(data);
                                $('#district_court_state_name').select2();
                                //$("input:radio[name=Earlier_not_court_type]:checked")[0].checked = false;
                                $("#Earlier_not_court_type").prop("checked", false);
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
                        break;
                    case 5: //Agency Court
                        var CSRF_TOKEN = 'CSRF_TOKEN';
                        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

                        $("#state_agency_div1").show();
                        $("#state_agency_div2").show();
                        $("#high_court_div1").hide();
                        $("#high_court_div2").hide();
                        $("#supreme_court1").hide();
                        $("#supreme_court2").hide();
                        $("#district_court1").hide();
                        $("#district_court2").hide();
                        //alert('Agency Court courtId='+courtId)
                        $.ajax({
                            type: "POST",
                            data: {
                                CSRF_TOKEN: CSRF_TOKEN_VALUE
                            },
                            url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/get_icmis_state_list'); ?>",
                            success: function(data) {
                                $('#state_agency').html(data);
                                $('#state_agency').select2();
                                //$("input:radio[name=Earlier_not_court_type]:checked")[0].checked = false;
                                $("#Earlier_not_court_type").prop("checked", false);
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
                        break;
                    default:
                        $("#high_courtname").html('<option value="">Select High Court</option>');
                }
            }
        });
        $(document).on('change', '#supreme_state_name', function() {
            var stateId = parseInt($.trim($(this).val()));
            var supremeCourtBenchOptions = '';
            supremeCourtBenchOptions = '<option value="">Select Bench</option><option selected="selected" value="10000">DELHI</option>';
            $("#supreme_bench_name").html(supremeCourtBenchOptions);
            // $("#supreme_bench_name").select2();
        });

        $(document).on('change', '#district_court_state_name', function() {
            var stateId = $.trim($(this).val());
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $.ajax({
                type: "POST",
                data: {
                    CSRF_TOKEN: CSRF_TOKEN_VALUE,
                    state_id: stateId
                },
                url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/get_district_list'); ?>",
                success: function(data) {
                    $('#district_court_district_name').html(data);
                    $('#district_court_district_name').select2();
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

        $(document).on('change', '#state_agency', function() {
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            var agency_state_id = $(this).val();
            $.ajax({
                type: "POST",
                data: {
                    CSRF_TOKEN: CSRF_TOKEN_VALUE,
                    agency_state_id: agency_state_id,
                    court_type: '5'
                },
                url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/get_state_agency_list'); ?>",
                success: function(data) {
                    $('#state_agency_name').html(data);
                    $('#state_agency_name').select2();
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

        $(document).on('change', '#high_courtname', function() {
            var high_court_id = $.trim($(this).val());
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $.ajax({
                type: "POST",
                data: {
                    CSRF_TOKEN: CSRF_TOKEN_VALUE,
                    high_court_id: high_court_id,
                    court_type: '1'
                },
                url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/get_hc_bench_list'); ?>",
                success: function(data) {
                    $('#high_court_bench_name').html(data);
                    $('#high_court_bench_name').select2();
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


    });
</script>


<?php if (empty($_SESSION['efiling_details']['registration_id']) || !empty($_SESSION['efiling_details']['registration_id'])) { ?>
    <script>
        $("#browser").prop('required', false);
        $('#newCaseSaveForm').show();
        $('#add_case_details').on('submit', function() {
            if ($('#add_case_details').valid()) {
                var validateFlag = true;
                var form_data = $(this).serialize();
                var court_name = $.trim($("#court_name option:selected").val());
                if (court_name) {
                    court_name = parseInt(court_name);
                    switch (court_name) {
                        case 1:
                            var high_courtname = $("#high_courtname option:selected").val();
                            var high_court_bench_name = $("#high_court_bench_name option:selected").val();
                            if (high_courtname == '') {
                                alert("Please select  high court name.");
                                $("#high_courtname").focus();
                                validateFlag = false;
                                return false;
                            } else if (high_court_bench_name == '') {
                                alert("Please select  high court bench name.");
                                $("#high_court_bench_name").focus();
                                validateFlag = false;
                                return false;
                            }
                            break;
                        case 3:
                            var district_court_state_name = $("#district_court_state_name option:selected").val();
                            var district_court_district_name = $("#district_court_district_name option:selected").val();
                            if (district_court_state_name == '') {
                                alert("Please select  state name.");
                                $("#district_court_state_name").focus();
                                validateFlag = false;
                                return false;
                            } else if (district_court_district_name == '') {
                                alert("Please select  district name.");
                                $("#district_court_district_name").focus();
                                validateFlag = false;
                                return false;
                            }
                            break;
                        case 4:
                            var supreme_state_name = $("#supreme_state_name option:selected").val();
                            var supreme_bench_name = $("#supreme_bench_name option:selected").val();
                            if (supreme_state_name == '') {
                                alert("Please select  state name.");
                                $("#supreme_state_name").focus();
                                validateFlag = false;
                                return false;
                            } else if (supreme_bench_name == '') {
                                alert("Please select  bench name.");
                                $("#supreme_bench_name").focus();
                                validateFlag = false;
                                return false;
                            }
                            break;
                        case 5:
                            var state_agency = $("#state_agency option:selected").val();
                            var state_agency_name = $("#state_agency_name option:selected").val();
                            if (state_agency == '') {
                                alert("Please select  state name.");
                                $("#state_agency").focus();
                                validateFlag = false;
                                return false;
                            } else if (state_agency_name == '') {
                                alert("Please select agency name.");
                                $("#state_agency_name").focus();
                                validateFlag = false;
                                return false;
                            }
                            break;
                        default:
                            validateFlag = false;

                    }
                } else {
                    alert("Please select  court Type.");
                    $("#court_name").focus();
                    validateFlag = false;
                    return false;
                }
                if (validateFlag) {
                    var CSRF_TOKEN = 'CSRF_TOKEN';
                    var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>newcase/caseDetails/add_case_details",
                        data: form_data,
                        async: false,
                        beforeSend: function() {
                            $('#pet_save').val('Please wait...');
                            $('#pet_save').prop('disabled', true);
                        },
                        success: function(data) {
                            //   alert(data);
                            $('#pet_save').val('SAVE');
                            $('#pet_save').prop('disabled', false);
                            var resArr = data.split('@@@');
                            if (resArr[0] == 1) {
                                $('#msg').show();
                                $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                            } else if (resArr[0] == 2) {
                                $(".form-response").html("<p class='message valid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                                $('#msg').show();
                                //window.location.href = resArr[2];
                                location.reload();

                            } else if (resArr[0] == 3) {
                                $('#msg').show();
                                $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
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
                }
            } else {
                return false;
            }
        });
    </script>

<?php } else { ?>
    <script>
        $("#browser").prop('required', true);
        var myFile = "";
        $('#newCaseSaveForm').hide();
        $('#pet_save').hide();
        $('#browser').on('change', function(e) {

            myFile = $("#browser").val();
            console.log(myFile);
            var upld = myFile.split('.').pop();

            if (upld == 'pdf') {
                var draft_petition_file_browser = $.trim($("#browser").val());
                if (draft_petition_file_browser.length == 0) {
                    alert('Upload document draft petition is required*');
                    $('#draft_petition_file_browser').append('Upload document draft petition is required*');
                    //swal("Cancelled", "", "error");
                    //$("#captchacode").focus();
                    return false;
                }
                $('#pet_save').hide();
                // alert("File uploaded is pdf");
                var fileName = e.target.files[0].name;
                /*var file_data     = $("#browser").prop("files")[0];
                alert(fileName + ' is the selected file.');
                form_data.append("pdfDocFile", file_data);*/
                var file_data = updateUploadFileName('browser');
                if (file_data) {
                    $('.progress').hide();
                    var CSRF_TOKEN = 'CSRF_TOKEN';
                    var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                    var fileName = $("#browser").prop("files")[0].name;
                    var filedata = $("#browser").prop("files")[0];
                    var formdata = new FormData();
                    formdata.append("pdfDocFile", filedata);
                    //formdata.append("doc_title", 'DRAFT PETITION');
                    formdata.append("CSRF_TOKEN", CSRF_TOKEN_VALUE);
                    var doc_title = $('[name="doc_title"]').val();
                    formdata.append("doc_title", $('[name="doc_title"]').val());

                    // alert('The file "' + doc_title +  '" has been selected.');
                    $.ajax({
                        //dataType: 'script',
                        type: 'POST',
                        url: "<?php echo base_url('newcase/caseDetails/is_upload_pdf'); ?>",
                        data: formdata,
                        contentType: false,
                        processData: false,
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').html(percentComplete + '%');
                                    $('.myprogress').css('width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function(data) {
                            $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                                $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                                //alert(result.CSRF_TOKEN_VALUE + '=='+ CSRF_TOKEN_VALUE);
                            });
                            //$("#upload_doc").prop("disabled", true);
                            var resArr = data.split('@@@');
                            if (resArr[0] == 1) {
                                $('#msg').show();
                                $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                            } else if (resArr[0] == 2) {
                                $('#pet_save').show();
                                $('#newCaseSaveForm').show();
                                //$(".form-response").html("<p class='message valid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                                //$('#msg').show();
                                // location.reload();
                            } else if (resArr[0] == 3) {
                                $('#msg').show();
                                $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                            } else if (resArr[0] == 4) {
                                $('#msg').show();
                                $('.progress').hide();
                                $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                            }
                            $.getJSON("<?php echo base_url('csrftoken'); ?>", function(result) {
                                $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                            });
                        },
                        error: function(e) {
                            $("#upload").prop("disabled", false);
                        }
                    });
                }

            } else {
                $('#pet_save').hide();
                $('#newCaseSaveForm').hide();


                alert("Only PDF are allowed");
                // location.reload();
            }

        });


        $('#add_case_details').on('submit', function() {
            $("#browser").prop('required', true);
            if ($('#add_case_details').valid()) {
                var draft_petition_file_browser = $.trim($("#browser").val());
                if (draft_petition_file_browser.length == 0) {
                    alert('Upload document draft petition is required*');
                    $('#draft_petition_file_browser').append('Upload document draft petition is required*');
                    //swal("Cancelled", "", "error");
                    //$("#captchacode").focus();
                    return false;
                }
                var validateFlag = true;
                var form_data = $(this).serialize();
                var court_name = $.trim($("#court_name option:selected").val());
                if (court_name) {
                    court_name = parseInt(court_name);
                    switch (court_name) {
                        case 1:
                            var high_courtname = $("#high_courtname option:selected").val();
                            var high_court_bench_name = $("#high_court_bench_name option:selected").val();
                            if (high_courtname == '') {
                                alert("Please select  high court name.");
                                $("#high_courtname").focus();
                                validateFlag = false;
                                return false;
                            } else if (high_court_bench_name == '') {
                                alert("Please select  high court bench name.");
                                $("#high_court_bench_name").focus();
                                validateFlag = false;
                                return false;
                            }
                            break;
                        case 3:
                            var district_court_state_name = $("#district_court_state_name option:selected").val();
                            var district_court_district_name = $("#district_court_district_name option:selected").val();
                            if (district_court_state_name == '') {
                                alert("Please select  state name.");
                                $("#district_court_state_name").focus();
                                validateFlag = false;
                                return false;
                            } else if (district_court_district_name == '') {
                                alert("Please select  district name.");
                                $("#district_court_district_name").focus();
                                validateFlag = false;
                                return false;
                            }
                            break;
                        case 4:
                            var supreme_state_name = $("#supreme_state_name option:selected").val();
                            var supreme_bench_name = $("#supreme_bench_name option:selected").val();
                            if (supreme_state_name == '') {
                                alert("Please select  state name.");
                                $("#supreme_state_name").focus();
                                validateFlag = false;
                                return false;
                            } else if (supreme_bench_name == '') {
                                alert("Please select  bench name.");
                                $("#supreme_bench_name").focus();
                                validateFlag = false;
                                return false;
                            }
                            break;
                        case 5:
                            var state_agency = $("#state_agency option:selected").val();
                            var state_agency_name = $("#state_agency_name option:selected").val();
                            if (state_agency == '') {
                                alert("Please select  state name.");
                                $("#state_agency").focus();
                                validateFlag = false;
                                return false;
                            } else if (state_agency_name == '') {
                                alert("Please select agency name.");
                                $("#state_agency_name").focus();
                                validateFlag = false;
                                return false;
                            }
                            break;
                        default:
                            validateFlag = false;

                    }
                } else {
                    alert("Please select  court Type.");
                    $("#court_name").focus();
                    validateFlag = false;
                    return false;
                }
                if (validateFlag) {

                    //var CSRF_TOKEN_VALUE= '<//?php echo $this->security->get_csrf_hash();?>';
                    var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

                    // alert('CSRF_TOKEN_VALUE='+CSRF_TOKEN_VALUE);
                    $('.progress').hide();
                    /*plan-A*/
                    /*var doc_title= $('[name="doc_title"]').val();

                    var no_of_petitioners= $('[name="no_of_petitioners"]').val();
                    var no_of_respondents= $('[name="no_of_respondents"]').val();
                    var cause_pet=$('[name="cause_pet"]').val();
                    var cause_res= $('[name="cause_res"]').val();
                    var sc_case_type= $('[name="sc_case_type"]').val();
                    var sc_sp_case_type_id= $('[name="sc_sp_case_type_id"]').val();
                    var subj_cat_main= $('[name="subj_cat_main"]').val();
                    var subj_sub_cat_1= $('[name="subj_sub_cat_1"]').val();
                    var subj_sub_cat_2= $('[name="subj_sub_cat_2"]').val();
                    var subj_sub_cat_3= $('[name="subj_sub_cat_3"]').val();



                    var high_courtname= $('[name="high_courtname"]').val();
                    var high_court_bench_name= $('[name="high_court_bench_name"]').val();
                    var district_court_state_name= $('[name="district_court_state_name"]').val();
                    var district_court_district_name= $('[name="district_court_district_name"]').val();
                    var supreme_state_name= $('[name="supreme_state_name"]').val();
                    var supreme_bench_name= $('[name="supreme_bench_name"]').val();
                    var state_agency= $('[name="state_agency"]').val();
                    var state_agency_name= $('[name="state_agency_name"]').val();
                    var datesignjail= $('[name="datesignjail"]').val();
                    var court_name= $('[name="court_name"]').val();*/

                    /*var matrimonialCheck= $('[name="matrimonialCheck"]').val();
                    var matrimonial=$('[name="matrimonial"]').val();
                    var question_of_law= $('[name="question_of_law"]').val();
                    var grounds= $('[name="grounds"]').val();
                    var interim_grounds= $('[name="interim_grounds"]').val();
                    var main_prayer= $('[name="main_prayer"]').val();
                    var interim_relief= $('[name="interim_relief"]').val();*/
                    /*plan-A*/

                    var subj_sub_cat_2 = $('[name="subj_sub_cat_2"]').val();
                    //alert(subj_sub_cat_2);
                    if (typeof subj_sub_cat_2 === 'undefined') {
                        subj_sub_cat_2 = '';
                    }
                    var subj_sub_cat_3 = $('[name="subj_sub_cat_3"]').val();
                    if (typeof subj_sub_cat_3 === 'undefined') {
                        subj_sub_cat_2 = '';
                    }
                    //alert(subj_sub_cat_2);
                    var filedata = $("#browser").prop("files")[0];
                    var formdata = new FormData();
                    formdata.append("pdfDocFile", filedata);

                    /*plan-b*/

                    formdata.append("CSRF_TOKEN", CSRF_TOKEN_VALUE);
                    formdata.append("doc_title", $('[name="doc_title"]').val());
                    formdata.append("no_of_petitioners", $('[name="no_of_petitioners"]').val());
                    formdata.append("no_of_respondents", $('[name="no_of_respondents"]').val());
                    formdata.append("cause_pet", $('[name="cause_pet"]').val());
                    formdata.append("cause_res", $('[name="cause_res"]').val());
                    formdata.append("sc_case_type", $('[name="sc_case_type"]').val());
                    formdata.append("sc_sp_case_type_id", $('[name="sc_sp_case_type_id"]').val());
                    formdata.append("subj_cat_main", $('[name="subj_cat_main"]').val());
                    formdata.append("subj_sub_cat_1", $('[name="subj_sub_cat_1"]').val());
                    formdata.append("subj_sub_cat_2", subj_sub_cat_2);
                    formdata.append("subj_sub_cat_3", subj_sub_cat_3);



                    formdata.append("high_courtname", $('[name="high_courtname"]').val());
                    formdata.append("high_court_bench_name", $('[name="high_court_bench_name"]').val());
                    formdata.append("district_court_state_name", $('[name="district_court_state_name"]').val());
                    formdata.append("district_court_district_name", $('[name="district_court_district_name"]').val());
                    formdata.append("supreme_state_name", $('[name="supreme_state_name"]').val());
                    formdata.append("supreme_bench_name", $('[name="supreme_bench_name"]').val());
                    formdata.append("state_agency", $('[name="state_agency"]').val());
                    formdata.append("state_agency_name", $('[name="state_agency_name"]').val());
                    formdata.append("datesignjail", $('[name="datesignjail"]').val());
                    formdata.append("court_name", $('[name="court_name"]').val());


                    /* formdata.append("matrimonialCheck", $('[name="matrimonialCheck"]').val());
                     formdata.append("matrimonial", $('[name="matrimonial"]').val());
                     formdata.append("question_of_law", $('[name="question_of_law"]').val());
                     formdata.append("grounds", $('[name="grounds"]').val());
                     formdata.append("interim_grounds", $('[name="interim_grounds"]').val());
                     formdata.append("main_prayer", $('[name="main_prayer"]').val());
                     formdata.append("interim_relief", $('[name="interim_relief"]').val());*/
                    /*plan-b*/
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>newcase/caseDetails/add_case_details",
                        //data: form_data,
                        /* data: {
                             no_of_petitioners:no_of_petitioners,no_of_respondents:no_of_respondents,cause_pet:cause_pet,cause_res:cause_res,
                             sc_case_type:sc_case_type,sc_sp_case_type_id:sc_sp_case_type_id,subj_cat_main:subj_cat_main,subj_sub_cat_1:subj_sub_cat_1,subj_sub_cat_2:subj_sub_cat_2,subj_sub_cat_3:subj_sub_cat_3,
                             high_courtname:high_courtname,high_court_bench_name:high_court_bench_name,district_court_state_name:district_court_state_name,district_court_district_name:district_court_district_name,supreme_state_name:supreme_state_name,supreme_bench_name:supreme_bench_name,
                             state_agency:state_agency,state_agency_name:state_agency_name,datesignjail:datesignjail,court_name:court_name
                             ,CSRF_TOKEN: CSRF_TOKEN_VALUE ,doc_title:doc_title
                             //,pdfDocFile:pdfDocFile
                         },*/
                        // async: false,
                        data: formdata,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('#pet_save').val('Please wait...');
                            $('#pet_save').prop('disabled', true);
                        },
                        success: function(data) {
                            // alert(data);
                            $('#pet_save').val('SAVE');
                            $('#pet_save').prop('disabled', false);
                            var resArr = data.split('@@@');
                            if (resArr[0] == 1) {
                                $('#msg').show();
                                $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                            } else if (resArr[0] == 2) {
                                $(".form-response").html("<p class='message valid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                                $('#msg').show();
                                //window.location.href = resArr[2];
                                location.reload();
                            } else if (resArr[0] == 3) {
                                $('#msg').show();
                                $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
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
                }
            } else {
                return false;
            }
        });
    </script>

<?php } ?>