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
@stack('style')
<style>

    html {overflow-x: hidden; }
    
.overlay{
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 999;
    background: rgba(255,255,255,0.8) url("loader.gif") center no-repeat;
}

/* Turn off scrollbar when body element has the loading class */
body.loading{
    overflow: hidden;   
}
/* Make spinner image visible when body element has the loading class */
body.loading .overlay{
    display: block;
}
.error {
    color:red !important;
}
input,
select,
textarea {
    text-transform: uppercase;
}
.datepicker-dropdown {
    margin-top: 260px; !important;background-color: #fff;
}



</style>

<div class="center-content-inner comn-innercontent">
    <div class="tab-content">
        <div class="tab-pane Active " id="home" role="tabpanel" aria-labelledby="home-tab">
            <?php
                $attribute = array('class' => 'form-horizontal', 'name' => 'add_caveator', 'id' => 'add_caveator', 'autocomplete' => 'off', 'novalidate' => 'novalidate');
                echo form_open('#', $attribute);
               
            ?>
            <div id="msg"></div>

            <div class="tab-form-inner">
            <div class="row">
                    <h6 class="text-center fw-bold">Caveator Information</h6>
            </div>
                <?= ASTERISK_RED_MANDATORY ?>
               
                <div class="row">
                    <!-- I Field Start-->
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Case Type <span style="color: red" class="astriks">*</span></label>
                            <select class="form-select cus-form-ctrl filter_select_dropdown" name="case_type" id="case_type" required>
                                <option selected>Select</option>
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
                    <!-- II  Field Start -->  
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Caveator is <span style="color: red" class="astriks">*</span></label>
                            <?php
                                $showHideIndividual =$showHideOtherIndividual=$stateDiv=$selectIndividual=$selectStateDept=$selectCentralDept=$selectOtherDept= '';
                                $showHideOtherIndividual = 'display:none';
                                if (isset($caveator_details) && !empty($caveator_details)) {
                                    $selectIndividual = $caveator_details[0]['orgid'] == 'I' ? 'selected=selected' : '';
                                    $selectStateDept = $caveator_details[0]['orgid'] == 'D1' ? 'selected=selected' : '';
                                    $selectCentralDept = $caveator_details[0]['orgid'] == 'D2' ? 'selected=selected' : '';
                                    $selectOtherDept = $caveator_details[0]['orgid'] == 'D3' ? 'selected=selected' : '';
                                    $stateDiv = 'display:block';
                                    $showHideOtherIndividual = 'display:none';
                                    if (isset($selectIndividual) && !empty($selectIndividual)) {
                                        $showHideIndividual = 'display:block';
                                    } elseif (!empty($selectStateDept) || !empty($selectCentralDept)) {
                                        $showHideOtherIndividual = 'display:block';
                                        $showHideIndividual = 'display:none';
                                        $stateDiv = 'display:block';
                                    } elseif (!empty($selectOtherDept)) {
                                        $stateDiv = 'display:none';
                                        $showHideOtherIndividual = 'display:block';
                                        $showHideIndividual = 'display:none';
                                    }
                                }
                            ?>
                            <select tabindex='2' name="party_is" id="party_is" onchange="get_caveator_as(this.value)" class="form-select cus-form-ctrl" required>
                                <option value="I" <?php echo isset($selectIndividual) ? $selectIndividual : ''; ?>>Individual
                                </option>
                                <option value="D1" <?php echo isset($selectStateDept) ? $selectStateDept : ''; ?>>State Department
                                </option>
                                <option value="D2" <?php echo isset($selectCentralDept) ? $selectCentralDept : ''; ?>>Central
                                    Department</option>
                                <option value="D3" <?php echo isset($selectOtherDept) ? $selectOtherDept : ''; ?>>Other
                                    Organisation</option>
                            </select>
                        </div>
                    </div>

                    <!-- III  Field Start -->  
                    <div class="row" id="indvidual_form" >
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                    
                        <div class="container">
                            <div class="row">   </div>
                            </div>
                        </div>    
                        <div style="clear:both"></div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4">

                                <div class="mb-3">
                                    <label for="" class="form-label">Caveator Name <span style="color: red" class="astriks">*</span></label>
                                    <textarea id="pet_complainant" name="pet_complainant" placeholder="First Name Middle Name Last Name" tabindex='3'
                                        class="form-control cus-form-ctrl sci_validation" 
                                        minlength="3" maxlength="250" ><?php if(isset($caveator_details)){ echo $caveator_details[0]['pet_name']; }?></textarea>
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover" title="Caveator name should be in characters (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                        <i class="fa fa-question-circle-o"></i>
                                    </span>                                           
                                            
                                </div>


                            </div>


                        
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 show_hide_base_on_org">
                            <div class="mb-3">
                                <label for="" class="form-label">Relation</label>
                                <?php
                                    $selectSon = isset($caveator_details[0]) && $caveator_details[0]['pet_father_flag'] == 'S' ? 'selected=selected' : '';
                                    $selectDaughter = isset($caveator_details[0]) && $caveator_details[0]['pet_father_flag'] == 'D' ? 'selected=selected' : '';
                                    $selectWife = isset($caveator_details[0]) && $caveator_details[0]['pet_father_flag'] == 'W' ? 'selected=selected' : '';
                                    $selectNotAvailable =isset($caveator_details[0]) &&  $caveator_details[0]['pet_father_flag'] == 'N' ? 'selected=selected' : '';
                                ?>
                                <select tabindex='4' name="pet_rel_flag" id="pet_rel_flag"
                                    class="form-control cus-form-ctrl filter_select_dropdown" >
                                    <option value="">Select Relation</option>
                                    <option <?php echo $selectSon; ?> value="S">Son Of</option>
                                    <option <?php echo $selectDaughter; ?> value="D">Daughter Of</option>
                                    <option <?php echo $selectWife; ?> value="W">Spouse Of</option>
                                    <option <?php echo $selectNotAvailable; ?> value="N">Not Available</option>
                                </select>

                            </div>
                        </div>                    
                        <!-- V  Field Start -->  
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 show_hide_base_on_org">
                            <div class="mb-3">
                                <label for="" class="form-label">Relative Name <span style="color: red" class="astriks">*</span></label>

                                <input tabindex="5" id="relative_name" name="relative_name"
                                    minlength="3" maxlength="99" placeholder="Relative Name"
                                    value="<?php   echo isset($caveator_details[0]['relative_name'])?$caveator_details[0]['relative_name']:''; ?>"
                                    class="form-control cus-form-ctrl sci_validation"
                                    type="text" >
                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                    title="Please write name of father or mother or husband or other relative. Relative Name should be in characters ( only dot[.] and space are allowed ).">
                                    <i class="fa fa-question-circle-o"></i>
                                </span>    
                            </div>
                        </div>                    
                        <!-- VI  Field Start -->  
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 show_hide_base_on_org">
                            <div class="mb-3">
                                <label for="" class="form-label">Date of Birth <span style="color: red" class="astriks">*</span></label>
                                <input tabindex='6' class="form-control cus-form-ctrl  has-feedback-left" id="pet_dob"  name="pet_dob"
                                value="<?php echo isset($caveator_details[0]['party_dob']) ? date('m/d/Y', strtotime($caveator_details[0]['party_dob'])) : ''; ?>" maxlength="10" readonly="" placeholder="DD/MM/YYYY" type="text">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                        title="Please Enter Date of Birth.">
                                    <i class="fa fa-question-circle-o"></i>
                                </span>
                            </div>
                        </div>
                        <!-- VII  Field Start -->  
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 show_hide_base_on_org">
                            <div class="mb-3">
                                <label for="" class="form-label">Approximate Age <span style="color: red" class="astriks">*</span></label>
                                <?php
                                $pet_age = '';
                                if(isset($caveator_details[0]['party_age']))
                                {
                                if ($caveator_details[0]['party_age'] == 0 || $caveator_details[0]['party_age'] == '' || $caveator_details[0]['party_age'] == NULL) {
                                    $pet_age = '';
                                } else {
                                    $pet_age = $caveator_details[0]['party_age'];
                                }
                                    }
                                ?>
                                <input type="number" tabindex='7'  class="form-control cus-form-ctrl age_calculate" disabled
                                name="pet_age" id="pet_age" maxlength="2" onkeyup="return isNumber(event)" placeholder="Age" value="<?php echo ($pet_age); ?>">
                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                title="Approx. age in years only.">
                                <i class="fa fa-question-circle-o"></i>
                            </span>
                            </div>
                        </div>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 show_hide_base_on_org">
                                <div class="mb-3">
                                    <label for="" class="form-label">Gender <span style="color: red" class="astriks">*</span></label>
                                </div>
                                <?php $gmchecked ='';
                                    $gmchecked = (isset($caveator_details[0]['pet_gender']) && $caveator_details[0]['pet_gender'] == 'M') ? 'checked="checked"' : '';
                                    $gfchecked = (isset($caveator_details[0]['pet_gender']) && $caveator_details[0]['pet_gender']== 'F' )? 'checked="checked"' : '';
                                    $gochecked = (isset($caveator_details[0]['pet_gender']) && $caveator_details[0]['pet_gender']== 'O')? 'checked="checked"' : '';
                                    ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input cus-form-check" tabindex='8' type="radio"  name="pet_gender" id="pet_gender1" value="M" <?php echo $gmchecked; ?>>
                                        <label class="form-check-label" for="inlineRadio1">Male</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input cus-form-check" tabindex='9' type="radio"  name="pet_gender" id="pet_gender2" value="F" <?php echo $gfchecked; ?>>
                                        <label class="form-check-label" for="inlineRadio2">Female</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input cus-form-check" tabindex='10' type="radio"  name="pet_gender" id="pet_gender3" value="O" <?php echo $gochecked; ?>>
                                        <label class="form-check-label" for="inlineRadio2">Other</label>
                                    </div>                        
                            </div>
                        </div>
                    </div>
                    <div class="row" id="org_form" style="<?php echo $showHideOtherIndividual; ?>">                    
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4" id="org_state_row" style="<?php echo $stateDiv;?>">
                                    <div class="row" >
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12" id="stateDivBox" >
                                            <div class="mb-3">
                                                <label for="" class="form-label">State Name <span style="color: red">*</span> </label>
                                                <select  style="width:100% !important;" tabindex='11' name="org_state" id="org_state" class="form-control cus-form-ctrl filter_select_dropdown org_state ">
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

                                <div class="col-12 col-sm-12 col-md-4 col-lg-4" id="otherOrgState" style="display: none">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Other State Name<span
                                            style="color: red">*</span> </label>
                                            <textarea tabindex='12' id="org_state_name" name="org_state_name" 
                                            minlength="3" maxlength="250" class="form-control cus-form-ctrl"
                                            placeholder="Other State Name"
                                            type="text"><?php echo isset($caveator_details[0]['org_state_name'])?$caveator_details[0]['org_state_name']:''; ?></textarea>
                                            <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                                    title="Other State Name should be in characters (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                                <i class="fa fa-question-circle-o"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Department Name 
                                                <span  style="color: red">*</span> 
                                            </label><br>
                                            <select style="width:100% !important;"  name="org_dept" tabindex='13' id="org_dept" class="form-control input-sm filter_select_dropdown org_dept cus-form-ctrl" >
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

                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4" id="otherOrgDept" style="display: none">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Other Department<span
                                                style="color: red">*</span> </label>
                                                <textarea id="org_dept_name" tabindex='14' name="org_dept_name" 
                                                minlength="3" maxlength="250" class="form-control cus-form-ctrl" placeholder="Other Dept Name"><?php echo isset($caveator_details[0]['org_dept_name'])?$caveator_details[0]['org_dept_name']:''; ?></textarea>
                                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                                title="Other Department Name should be in characters (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                                <i class="fa fa-question-circle-o"></i>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">                        
                                        <div class="mb-3">
                                            <label for="" class="form-label">Post Name
                                                <span style="color: red">*</span>
                                             </label><br>
                                            <select  style="width:100% !important;"  tabindex='15' name="org_post" id="org_post" class="form-control cus-form-ctrl filter_select_dropdown org_post" required>
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
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4" id="otherOrgPost" style="display: none">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Other Post
                                                <span style="color: red">*</span> 
                                            </label>
                                            <textarea id="org_post_name" name="org_post_name" tabindex='16' minlength="3"
                                                maxlength="250" class="form-control cus-form-ctrl" placeholder="Other Post Name"><?php echo isset($caveator_details[0]['org_post_name'])?$caveator_details[0]['org_post_name']:''; ?></textarea>
                                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover" title="Other Post Name should be in characters (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                                    <i class="fa fa-question-circle-o"></i>
                                                </span>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>        
                        <?php if(!is_null($_SESSION['login']['department_id']))
                        { ?>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Whether filed by Government? </label>
                                    <input type="checkbox" name="is_govt_filing" id="is_govt_filing" <?php echo (!empty($caveator_details[0]['is_govt_filing']) && ($caveator_details[0]['is_govt_filing'] ==1)) ? 'checked' : ''  ?>>
                                    <span class="slider round"></span>
                                </div>
                            </div>
                            <?php
                        } ?>
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Email <span style="color: red" class="astriks">*</span></label>
                                <input id="pet_email" name="pet_email" placeholder="Email"
                                    tabindex='17' value="<?php echo isset($caveator_details[0]['pet_email']) ? $caveator_details[0]['pet_email'] : ''; ?>"
                                    class="form-control cus-form-ctrl sci_validation"
                                    type="email" minlength="6" maxlength="49" required>
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                    title="Please enter caveator valid email id. (eg : abc@example.com)">
                                    <i class="fa fa-question-circle-o"></i>
                                </span>
                            </div>
                        </div>
                    
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Mobile 
                                    <span style="color: red" class="astriks">*</span>
                                </label>
                                <input id="pet_mobile" name="pet_mobile" placeholder="Mobile" tabindex='18' value="<?php echo isset($caveator_details[0]['pet_mobile']) ? $caveator_details[0]['pet_mobile'] : ''; ?>" class="form-control cus-form-ctrl sci_validation" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" type="tel" maxlength="10" required>
                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover" title="Mobile No. should be of 10 digits only.">
                                    <i class="fa fa-question-circle-o"></i>
                                </span>
                            </div>
                        </div>                    
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Address <span style="color: red" class="astriks">*</span></label>
                                <textarea tabindex='19' name="pet_address" id="pet_address" placeholder="H.No.,  Street no, Colony,  Land Mark"
                                    class="form-control cus-form-ctrl sci_validation" minlength="3" maxlength="99" required><?php echo isset($caveator_details[0]['petadd']) ? $caveator_details[0]['petadd'] : ''; ?></textarea>
                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                    title="Please enter House No, Street No, Sector, Colony and Landmarks. Please Select District and Taluka from the below mentioned field. Do not repeat District and Taluka in Address fields and District and Taluka Fields. Address can be alphanumeric (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                    <i class="fa fa-question-circle-o"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Pin Code 
                                    <span style="color: red" class="astriks">*</span>
                                </label>
                                <input id="party_pincode" name="party_pincode" tabindex='20' onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Pin code" required 
                                    value="<?php echo isset($caveator_details[0]['pet_pincode'])?$caveator_details[0]['pet_pincode']:''; ?>"
                                    class="form-control cus-form-ctrl" type="text" minlength="6" maxlength="6">
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover"
                                    title="Pincode should be 6 digits only.">
                                    <i class="fa fa-question-circle-o"></i>
                                    <a href="https://www.indiapost.gov.in/vas/pages/findpincode.aspx" target="_blank" class="pin-code-loc">Pin Code Locator</a>
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">City 
                                    <span style="color: red" class="astriks">*</span>
                                </label>
                                <input id="party_city" tabindex='21' name="party_city" placeholder="City" value="<?php echo isset($caveator_details[0]['pet_city'])?$caveator_details[0]['pet_city']:''; ?>"
                                class="form-control cus-form-ctrl sci_validation" type="text" minlength="3" maxlength="49" required>
                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover" title="Please enter City name.">
                                    <i class="fa fa-question-circle-o"></i>
                                </span>
                            </div>
                        </div>                    
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">State 
                                    <span style="color: red" class="astriks">*</span>
                                </label>
                                <select class="form-select cus-form-ctrl filter_select_dropdown" name="party_state" id="party_state">
                                    <option value="" title="Select">Select State</option>
                                    <?php
                                        $stateArr = array();
                                        if (!empty($state_list)) 
                                        {
                                            if (count($state_list)) {
                                                foreach ($state_list as $dataRes) {
                                                    $sel = (isset($caveator_details[0]['state_id']) && $caveator_details[0]['state_id'] == $dataRes->cmis_state_id) ? "selected=selected" : '';
                                                    ?>
                                                    <option <?php echo $sel; ?>
                                                            value="<?php echo_data(url_encryption(trim($dataRes->cmis_state_id))); ?>"><?php echo_data(strtoupper($dataRes->agency_state)); ?> 
                                                    </option>;
                                                    <?php
                                                    $tempArr = array();
                                                    $tempArr['id'] = url_encryption(trim($dataRes->cmis_state_id));
                                                    $tempArr['state_name'] = strtoupper($dataRes->agency_state);
                                                    $stateArr[] = (object)$tempArr;
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">District 
                                    <span style="color: red" class="astriks">*</span>
                                </label>
                                <select class="form-select cus-form-ctrl filter_select_dropdown party_district" 
                                    aria-label="Default select example" name="party_district" id="party_district">
                                    <option value="" title="Select">Select District</option>
                                    <?php
                                    if (!empty($district_list)) {
                                        foreach ($district_list as $dataRes) {
                                            $sel = (isset($caveator_details[0]['dist_code']) && $caveator_details[0]['dist_code'] == $dataRes->id_no) ? 'selected=selected' : '';
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
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 my-3">                    
                        <div class="row">
                            <div class="progress" style="display: none">
                                <div class="progress-bar progress-bar-success myprogress" role="progressbar"  value="0" max="100" style="width:0%">0%</div>
                            </div>
                        </div>
                        <div class="save-btns text-center">
                            
                            <?php 
                           
                            
                            
                            if (isset($caveator_details[0]) && !empty($caveator_details[0])) { 
                               
                                
                                ?>
                                <input type="submit" class="quick-btn" id="caveator_save" tabindex='26' value="UPDATE">
                                <a href="<?= base_url('caveat/caveatee') ?>" class="quick-btn" type="button" id="nextButton">Next</a>
                            <?php } else { ?>
                                <input type="submit" class="quick-btn" id="caveator_save" value="SAVE" tabindex='24'>
                            <?php } ?>                                
                            
                        </div>
                    </div>
                </div>
            </div>
            
          
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<div class="overlay"></div>
@push('script')
<!-- form--end  -->
<script src="<?= base_url() . 'assets/newAdmin/' ?>js/jquery-3.3.1.min.js"></script>
<script src="<?= base_url() . 'assets/newAdmin/' ?>js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() . 'assets/newAdmin/' ?>js/general.js"></script>
<script src="<?= base_url() . 'assets/newAdmin/' ?>js/jquery-3.5.1.slim.min.js"></script>
<script src="<?= base_url() . 'assets' ?>/vendors/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url() . 'assets' ?>/js/jquery.min.js"></script>
<script src="<?= base_url() . 'assets' ?>/js/jquery-ui.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url() ?>assets/js/sha256.js"></script>
<script src="<?= base_url() ?>assets/newAdmin/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() . 'assets' ?>/js/select2.min.js"></script>
<script src="<?= base_url() . 'assets' ?>/js/select2-tab-fix.min.js"></script>
<script type="text/javascript" src="<?= base_url() . 'assets' ?>/js/jquery.validate.js"></script>
<script>
   $(document).ready(function() {
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
    })

    function get_departments(party_is) {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

        var selected_org_st_id = '<?php echo url_encryption(isset($caveator_details[0]['org_state_id'])?$caveator_details[0]['org_state_id']:''); ?>';
        var selected_dept_id = '<?php echo url_encryption(isset($caveator_details[0]['org_dept_id'])?$caveator_details[0]['org_dept_id']:''); ?>';

        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, party_is: party_is, selected_org_st_id: selected_org_st_id, selected_dept_id: selected_dept_id},
            url: "<?php echo base_url('newcase/Ajaxcalls/get_org_departments'); ?>",
            success: function (data)
            {
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

        var selected_post_id = '<?php echo url_encryption(isset($caveator_details[0]['org_post_id'])?$caveator_details[0]['org_post_id']:''); ?>';

        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, selected_post_id: selected_post_id},
            url: "<?php echo base_url('newcase/Ajaxcalls/get_org_posts'); ?>",
            success: function (data)
            {
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












    $(document).ready(function() {
        $('#pet_complainant').attr('required', true);
        $(".filter_select_dropdown").select2().on('select2-focus', function() {
            // debugger;
            $(this).data('select2-closed', true)
        });
        
        var party_as = $('select#party_is option:selected').val();
        if (party_as == 'I') {          
        $('#pet_complainant').attr('required', true);
            $('#indvidual_form').show(); 
            $('#org_form').hide();
            $('#org_state_row').show();
            $('#org_state').val('');
            $('#org_dept').val('');
            $('#org_post').val('');
            $('#otherOrgState').hide();
            $('#otherOrgDept').hide();
            $('#otherOrgPost').hide();
        }else {
            if (party_as == 'D3') {
               
        $('#pet_complainant').attr('required', false);
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
                
        $('#pet_complainant').attr('required', false);
        $('#indvidual_form').hide(); 
                $('#org_form').show();
                $('#org_state_row').show();
                $('#caveator_name').val('');
                $('#relation').val('');
                $('#relative_name').val('');
                $('#caveator_dob').val('');
                $('#caveator_age').val('');
                $("#stateDivBox").show();
            }
        }
    });


    function get_caveator_as(value) {
        var party_as = value;
        if (party_as == 'I') {
        $('#pet_complainant').attr('required', true);
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
        $('#pet_complainant').attr('required', false);
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
        $('#pet_complainant').attr('required', false);
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
                 $('#party_gender3').val('');          
                */
            }
        }
    }
</script>



<script>


    var state_Arr = '<?php echo json_encode($stateArr); ?>';
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
     


      $(document).ready(function () {   
        var today = new Date();
        $('#pet_dob').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:-1",
            dateFormat: "dd/mm/yy",
            defaultDate: '-40y',
            endDate: today 
            
        });

        $(document).on('change','#pet_dob', function(){
            var value = $('#pet_dob').val();
            var parts = value.split("/");
            var day = parts[0] && parseInt(parts[0], 10);
            var month = parts[1] && parseInt(parts[1], 10);
            var year = parts[2] && parseInt(parts[2], 10);
            var str = day + '/' + month + '/' + year;
            var today = new Date(),
            dob = new Date(str),
            age = new Date(today - dob).getFullYear() - 1970;
            $('#pet_age').val(age);
        });

        $('#party_pincode').blur(function(){
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            var pincode = $("#party_pincode").val();
            if(pincode){
                var stateObj = JSON.parse(state_Arr);
                var options = '';
                options +='<option value="">Select State</option>';
                stateObj.forEach((response)=>
                options +='<option value="'+response.id+'">'+response.state_name+'</option>');
                $('#party_state').html(options).select2().trigger("change");
                $.ajax({
                    type: "POST",
                    data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, pincode : pincode},
                    url: "<?php echo base_url('newcase/Ajaxcalls/getAddressByPincode'); ?>",
                    success: function (response)
                    {
                        var taluk_name;
                        var district_name;
                        var state;
                        if(response){
                            var resData = JSON.parse(response);
                            if(resData){
                                taluk_name = resData[0]['taluk_name'].trim().toUpperCase();
                                district_name = resData[0]['district_name'].trim().toUpperCase();
                                state = resData[0]['state'].trim().toUpperCase();
                            }
                            if(taluk_name){
                                $("#party_city").val('');
                                $("#party_city").val(taluk_name);
                            }
                            else{
                                $("#party_city").val('');
                            }
                            if(state){
                                var stateObj = JSON.parse(state_Arr);
                                if(stateObj){
                                    var singleObj = stateObj.find(
                                        item => item['state_name'] === state
                                    );
                                }
                                if(singleObj){
                                    $('#party_state').val('');
                                    $('#party_state').val(singleObj.id).select2().trigger("change");
                                }
                                else{
                                    $('#party_state').val('');
                                }
                                if(district_name){
                                    var stateId = $('#party_state').val();
                                    setSelectedDistrict(stateId,district_name);
                                }
                            }
                            else{
                                $('#party_state').val('');
                            }
                        }
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
        });
        $('#add_caveator').on('submit', function () {
            // alert("TESTTSGDSGDSFGDSG");
            if ($('#add_caveator').valid()){
                if ($('#add_caveator')) {                      
                    //var form_data = $(this).serialize();
                    var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                    var formdata = new FormData();
                    formdata.append("CSRF_TOKEN", CSRF_TOKEN_VALUE);
                    formdata.append("case_type", $('[name="case_type"]').val());
                    formdata.append("party_is", $('[name="party_is"]').val());
                    formdata.append("pet_complainant", $('[name="pet_complainant"]').val());
                    formdata.append("pet_rel_flag", $('[name="pet_rel_flag"]').val());
                    formdata.append("relative_name", $('[name="relative_name"]').val());
                    formdata.append("pet_dob", $('[name="pet_dob"]').val());
                    formdata.append("pet_age", $('[name="pet_age"]').val());
                    formdata.append("pet_gender", $('input[name="pet_gender"]:checked').val());
                    formdata.append("pet_email", $('[name="pet_email"]').val());
                    formdata.append("pet_mobile", $('[name="pet_mobile"]').val());
                    formdata.append("pet_address", $('[name="pet_address"]').val());
                    formdata.append("party_pincode", $('[name="party_pincode"]').val());
                    formdata.append("party_city", $('[name="party_city"]').val());
                    formdata.append("party_state", $('[name="party_state"]').val());
                    formdata.append("party_district", $('[name="party_district"]').val());
                    formdata.append("org_state", $('[name="org_state"]').val());
                    formdata.append("org_state_name", $('[name="org_state_name"]').val());
                    formdata.append("org_dept", $('[name="org_dept"]').val());
                    formdata.append("org_dept_name", $('[name="org_dept_name"]').val());
                    formdata.append("org_post", $('[name="org_post"]').val());
                    formdata.append("org_post_name", $('[name="org_post_name"]').val());   
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>caveat/caveator/add_caveators",
                        data: formdata,
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            $('#caveator_save').val('Please wait...');
                            $('#caveator_save').prop('disabled', true);
                        },
                        success: function (data) {
                            $('#caveator_save').val('SAVE');
                            $('#caveator_save').prop('disabled', false);
                            var resArr = data.split('@@@');
                            alert(resArr[1]);
                            if (resArr[0] == 1) {
                                $('#msg').show();


                                //   alert('hello');
                                $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                            } else if (resArr[0] == 2) {
                                $(".form-response").html("<p class='message valid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                                $('#msg').show();
                                // alert(resArr[2]);
                                window.location.href = resArr[2];
                                // location.reload();
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
            }else {
                return false;
            }
        });     

    });


    /* Need to check js error in below code  */



</script>
<script type="text/javascript">
    $(".sci_validation").keyup(function () {
        var initVal = $(this).val();
        outputVal = initVal.replace(/[^a-z_,^A-Z^0-9\.@,/'()\s"\-]/g, "").replace(/^\./, "");
        //validate_alpha_numeric_single_double_quotes_bracket_with_special_characters
        if (initVal != outputVal) {
            $(this).val(outputVal);
        }
    });

   
   
    //---------- Hide and show Individual and Org form----------------------//
    $(document).ready(function () {
        var party_as_sel = '<?php echo isset($caveator_details[0]['caveator_type'])?$caveator_details[0]['caveator_type']:''; ?>';

        var OrgState_ID= '<?php echo isset($caveator_details[0]['org_state'])?$caveator_details[0]['org_state']:''; ?>';
        var OrgDept_ID='<?php echo isset($caveator_details[0]['org_dept'])?$caveator_details[0]['org_dept']:''; ?>';
        var OrgPost_ID='<?php echo isset($caveator_details[0]['org_post'])?$caveator_details[0]['org_post']:''; ?>';
        //alert(OrgDept_ID);
        if(OrgState_ID==0 && OrgState_ID!=''){
            $('#otherOrgState').show();
            var OrgState_NAME='<?php echo isset($caveator_details[0]['org_state_name'])?$caveator_details[0]['org_state_name']:''; ?>';
            $('#org_state_name').text(OrgState_NAME);
        }
        if(OrgDept_ID==0 || OrgDept_ID==''){
            $('#otherOrgDept').show();
            var OrgDept_NAME='<?php echo isset($caveator_details[0]['org_dept_name'])?$caveator_details[0]['org_dept_name']:''; ?>';
            $('#org_dept_name').text(OrgDept_NAME);
        }
        if(OrgPost_ID==0 || OrgPost_ID==''){
            $('#otherOrgPost').show();
            var OrgPost_NAME='<?php echo isset($caveator_details[0]['org_post_name'])?$caveator_details[0]['org_post_name']:''; ?>';
            $('#org_post_name').text(OrgPost_NAME);
        }
        if (party_as_sel != '') {
            get_caveator_as(party_as_sel);//--call to selected
        }
    });
    
  
    //---------- Organisation State Name----------------------//
    

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

    <?php  pr("Step ffffff"); ?>   
    

   

 
    

</script>
@endpush