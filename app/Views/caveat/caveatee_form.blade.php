
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
input,
select,
textarea {
    text-transform: uppercase;
}
</style>
<style>
    .datepicker-dropdown {
        margin-top: 260px !important; background-color: #fff;
    }
   
</style>
    <div class="center-content-inner comn-innercontent">
        <div class="tab-content">
            <div class="tab-pane Active" id="profile" role="tabpanel"
                aria-labelledby="profile-tab">
                <div class="tab-form-inner">
                    <?php
                    //echo '<pre>'; print_r($caveatee_details); exit;
                $attribute = array('class' => 'form-horizontal', 'name' => 'add_caveatee', 'id' => 'add_caveatee', 'autocomplete' => 'off');
                echo form_open('#', $attribute);
                ?>
                <div class="row">
                    <h6 class="text-center fw-bold">Caveatee Information</h6>
                </div>
                <?= ASTERISK_RED_MANDATORY ?>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Caveatee is <span style="color: red" class="astriks">*</span></label>
                                <?php
                                $selectIndividual = (isset($caveatee_details[0]['resorgid']) && $caveatee_details[0]['resorgid'] == 'I') ? 'selected=selected' : '';
                                $selectStateDept = (isset($caveatee_details[0]['resorgid']) && $caveatee_details[0]['resorgid'] == 'D1') ? 'selected=selected' : '';
                                $selectCentralDept = (isset($caveatee_details[0]['resorgid']) && $caveatee_details[0]['resorgid']  == 'D2') ? 'selected=selected' : '';
                                $selectOtherDept = (isset($caveatee_details[0]['resorgid']) && $caveatee_details[0]['resorgid'] == 'D3') ? 'selected=selected' : '';
                                $showHideIndividual = '';
                                $stateDiv ='display:block';
                                $showHideOtherIndividual = 'display:none';
                                if(isset($selectIndividual) && !empty($selectIndividual)){
                                    $showHideIndividual = 'display:block';
                                }
                                else if(!empty($selectStateDept) || !empty($selectCentralDept)){
                                    $showHideOtherIndividual = 'display:block';
                                    $showHideIndividual = 'display:none';
                                    $stateDiv ='display:block';
                                }
                                else if(!empty($selectOtherDept)){
                                    $stateDiv = 'display:none';
                                    $showHideOtherIndividual = 'display:block';
                                    $showHideIndividual = 'display:none';
                                }
                                ?>
                                    <select class="form-select cus-form-ctrl"
                                    aria-label="Default select example" name="party_is" id="party_is"   tabindex = "1"  onchange="get_caveator_as(this.value)" required>
                                    <option value="" title="Select" @required(true)>Select</option>
                                    <option value="I" <?php echo $selectIndividual; ?> >Individual</option>
                                    <option value="D1" <?php echo $selectStateDept; ?>>State Department</option>
                                    <option value="D2" <?php echo $selectCentralDept; ?>>Central Department</option>
                                    <option value="D3" <?php echo $selectOtherDept; ?>>Other Organisation</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="indvidual_form" >         
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Caveatee Name <span style="color: red" class="astriks">*</span></label>
                                <textarea  tabindex = "2" id="pet_complainant" name="pet_complainant" minlength="3" maxlength="250" class="form-control cus-form-ctrl sci_validation" placeholder="First Name Middle Name Last Name" ><?php echo isset($caveatee_details[0]['res_name'])?$caveatee_details[0]['res_name']:''; ?></textarea>
                                <span class="input-group-addon" data-placement="bottom"  data-toggle="popover" data-content="Caveator name should be in characters (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                    <i class="fa fa-question-circle-o" ></i>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Relation <span style="color: red" class="astriks">*</span></label>
                                <?php
                                $selectSon = $caveatee_details[0]['res_father_flag'] == 'S' ? 'selected=selected' : '';
                                $selectDaughter = $caveatee_details[0]['res_father_flag'] == 'D' ? 'selected=selected' : '';
                                $selectWife = $caveatee_details[0]['res_father_flag'] == 'W' ? 'selected=selected' : '';
                                $selectNotAvailable = $caveatee_details[0]['res_father_flag'] == 'N' ? 'selected=selected' : '';
                                ?>
                                
                                <select tabindex='3' name="pet_rel_flag" id="pet_rel_flag"
                                    class="form-control cus-form-ctrl" >
                                    <option value="" >Select Relation</option>
                                    <option <?php echo $selectSon; ?> value="S">Son Of</option>
                                    <option <?php echo $selectDaughter; ?> value="D">Daughter Of</option>
                                    <option <?php echo $selectWife; ?> value="W">Spouse Of</option>
                                    <option <?php echo $selectNotAvailable; ?> value="N">Not Available</option>
                                </select>

                            </div>
                        </div>


                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Relative Name <span style="color: red" class="astriks">*</span></label>

                                <input tabindex="4" id="relative_name" name="relative_name"
                                    minlength="3" maxlength="99" placeholder="Relative Name"
                                    value="<?php   echo isset($caveatee_details[0]['res_father_name'])?$caveatee_details[0]['res_father_name']:''; ?>"
                                    class="form-control cus-form-ctrl sci_validation"
                                    type="text" >
                            </div>
                        </div>
                        

                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Date of Birth  <span style="color: red" class="astriks">*</span></label>
                                <input tabindex='5' class="form-control cus-form-ctrl  has-feedback-left" id="pet_dob"  name="pet_dob"
                                value="<?php echo isset($caveatee_details[0]['res_dob']) ? date('m/d/Y', strtotime($caveatee_details[0]['res_dob'])) : ''; ?>" maxlength="10" readonly="" placeholder="DD/MM/YYYY" type="text"  >
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Please Enter Date of Birth.">
                                    <i class="fa fa-question-circle-o"></i>
                                </span>
                        
                            </div>
                        </div>  

                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Approximate Age <span style="color: red" class="astriks">*</span></label>
                                <?php
                                $res_age = '';
                                if(isset($caveatee_details[0]['res_age']))
                                {
                                if ($caveatee_details[0]['res_age'] == 0 || $caveatee_details[0]['res_age'] == '' || $caveatee_details[0]['res_age'] == NULL) {
                                    $res_age = '';
                                } else {
                                    $res_age = $caveatee_details[0]['res_age'];
                                }
                                    }
                                ?>
                                <input type="number" class="form-control cus-form-ctrl"
                                name="pet_age" id="pet_age" maxlength="2" placeholder="Age"  tabindex='6'  value="<?php echo ($res_age); ?>" >
                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Approx. age in years only.">
                                    <i class="fa fa-question-circle-o"  ></i>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Gender <span style="color: red" class="astriks">*</span></label>
                            </div>
                            <?php $gmchecked ='';
                                $gmchecked = (isset($caveatee_details[0]['res_gender']) && $caveatee_details[0]['res_gender'] == 'M') ? 'checked="checked"' : '';
                                $gfchecked = (isset($caveatee_details[0]['res_gender']) && $caveatee_details[0]['res_gender']== 'F' )? 'checked="checked"' : '';
                                $gochecked = (isset($caveatee_details[0]['res_gender']) && $caveatee_details[0]['res_gender']== 'O')? 'checked="checked"' : '';
                                ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input cus-form-check" type="radio" name="pet_gender" id="pet_gender1"  tabindex='7'  value="M" <?php echo $gmchecked; ?>>
                                    <label class="form-check-label" for="inlineRadio1">Male</span></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input cus-form-check" type="radio"  name="pet_gender" id="pet_gender2" value="F" <?php echo $gfchecked; ?>>
                                    <label class="form-check-label" for="inlineRadio2">Female</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input cus-form-check" type="radio"  name="pet_gender" id="pet_gender3" value="O" <?php echo $gochecked; ?>>
                                    <label class="form-check-label" for="inlineRadio2">Other</label>
                                </div>
                            
                        </div>
                    </div>

                    
                        <div id="org_form" style="<?php echo $showHideOtherIndividual;?>">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4" id="org_state_row">

                                <div class="col-12 col-sm-12 col-md-12 col-lg-12" id="stateDivBox" style="<?php echo $stateDiv;?>">
                                    <div class="mb-3">
                                        <label for="" class="form-label">State Name 
                                            <span style="color: red">*</span>
                                        </label>
                                        
                                        <select tabindex = '8' name="org_state" id="org_state" class="form-control cus-form-ctrl input-sm filter_select_dropdown org_state">
                                            <?php
                                                echo '<option  value="' . url_encryption(0) . '">' . strtoupper('NOT IN LIST') . '</option>';
                                                $select_organization ='';
                                                if(isset($state_list) && !empty($state_list)){
                                                    foreach ($state_list as $k=>$v){
                                                        if(!empty($caveatee_details[0]['res_state_id']) && trim($caveatee_details[0]['res_state_id']) == $v->cmis_state_id){
                                                            $select_organization = 'selected="selected"';
                                                        }
                                                        else{
                                                            $select_organization ='';
                                                        }
                                                        echo '<option '.$select_organization.' value="'.url_encryption($v->cmis_state_id).'">'.strtoupper($v->agency_state).'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>



                                <div class="col-12 col-sm-12 col-md-4 col-lg-4" id="otherOrgState" style="display: none">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Other State Name<span style="color: red">*</span></label>
                                        <textarea tabindex = '9' id="org_state_name" name="org_state_name" minlength="3" maxlength="250" class="form-control cus-form-ctrl" placeholder="Other State Name"  type="text"><?php echo isset($caveatee_details[0]['res_org_state_name'])?$caveatee_details[0]['res_org_state_name']:''; ?></textarea>
                                        <span class="input-group-addon" data-placement="bottom"  data-toggle="popover" data-content="Other State Name should be in characters (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                            <i class="fa fa-question-circle-o" ></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-4 col-lg-4" id="otherOrgState" >
                                    <div class="mb-3">
                                        <label for="" class="form-label">Department Name <span style="color: red">*</span></label>
                                        <select name="org_dept" tabindex = '10' id="org_dept" class="form-control input-sm filter_select_dropdown org_dept">
                                            <?php
                                            echo '<option  value="' . url_encryption(0) . '">' . strtoupper('NOT IN LIST') . '</option>';
                                            $dept_sel ='';
                                            if(isset($dept_list) && !empty($dept_list)){
                                                foreach ($dept_list as $k=>$v){
                                                    if(!empty($caveatee_details[0]['res_org_dept']) && trim($caveatee_details[0]['res_org_dept']) == $v->deptcode){
                                                        $dept_sel = 'selected="selected"';
                                                    }
                                                    else{
                                                        $dept_sel ='';
                                                    }
                                                    echo '<option '.$dept_sel.' value="'.url_encryption($v->deptcode).'">'.strtoupper($v->deptname).'</option>';
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-4 col-lg-4" id="otherOrgDept" style="display: none">
                                    <div class="row" id="org_state_row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12" id="stateDivBox" style="<?php echo $stateDiv;?>">

                                        <div class="mb-3">
                                            <label for="" class="form-label">Other Department<span style="color: red">*</span></label>
                                            <textarea id="org_dept_name"  tabindex = '11' name="org_dept_name" minlength="3" maxlength="250" class="form-control cus-form-ctrl" placeholder="Other State Name"  type="text"><?php echo isset($caveatee_details[0]['res_org_dept_name'])?$caveatee_details[0]['res_org_dept_name']:''; ?></textarea>
                                            <span class="input-group-addon" data-placement="bottom"  data-toggle="popover" data-content="Other Department Name should be in characters (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                                <i class="fa fa-question-circle-o" ></i>
                                            </span>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4" id="stateDivBox" style="<?php echo $stateDiv;?>">

                                    <div class="mb-3">
                                        <label for="" class="form-label">Post Name<span style="color: red">*</span></label>
                                        <select name="org_post" id="org_post" tabindex = '12' class="form-control input-sm filter_select_dropdown org_post cus-form-ctrl">
                                            <?php
                                            echo '<option  value="' . url_encryption(0) . '">' . strtoupper('NOT IN LIST') . '</option>';
                                            $post_sel ='';
                                            if(isset($post_list) && !empty($post_list)){
                                                foreach ($post_list as $k=>$v){
                                                    if(!empty($caveatee_details[0]['res_org_post']) && trim($caveatee_details[0]['res_org_post']) == $v->authcode){
                                                        $post_sel = 'selected="selected"';
                                                    }
                                                    else{
                                                        $post_sel ='';
                                                    }
                                                    echo '<option '.$post_sel.' value="'.url_encryption($v->authcode).'">'.strtoupper($v->authdesc).'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-4 col-lg-4" id="otherOrgPost" style="display: none">
                                    <div class="row" id="org_state_row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12" id="stateDivBox" style="<?php echo $stateDiv;?>">

                                        <div class="mb-3">
                                            <label for="" class="form-label">Other Post<span style="color: red">*</span></label>
                                            <textarea id="org_post_name" name="org_post_name" tabindex = '13' minlength="3" maxlength="250" class="form-control cus-form-ctrl" placeholder="Other Post Name" ><?php echo isset($caveatee_details[0]['res_org_post_name'])?$caveatee_details[0]['res_org_post_name']:''; ?></textarea>
                                            <span class="input-group-addon" data-placement="bottom"  data-toggle="popover" data-content="Other Post Name should be in characters (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                                <i class="fa fa-question-circle-o" ></i>
                                            </span>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        </div>

                        <div class="row">



                         
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Email </label>
                                <input id="pet_email" name="pet_email" placeholder="Email" placeholder="Email"
                                    tabindex='14' value="<?php echo isset($caveatee_details[0]['res_email']) ? $caveatee_details[0]['res_email'] : ''; ?>"
                                    class="form-control cus-form-ctrl sci_validation"
                                    type="email" minlength="6" maxlength="49" >
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Please enter caveatee valid email id. (eg : abc@example.com)">
                                        <i class="fa fa-question-circle-o" ></i>
                                    </span>
                            </div>
                        </div>
                        
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Mobile </label>
                                <input id="pet_mobile" name="pet_mobile" placeholder="Mobile"
                                    tabindex='15' value="<?php echo isset($caveatee_details[0]['res_mobile']) ? $caveatee_details[0]['res_mobile'] : ''; ?>"
                                    class="form-control cus-form-ctrl sci_validation"
                                    onkeyup="this.value=this.value.replace(/[^0-9]/g,'');"
                                    type="tel" minlength="10" maxlength="10" >
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Mobile No. should be of 10 digits only.">
                                        <i class="fa fa-question-circle-o"></i>
                                    </span>
                            </div>
                        </div>
                        
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Address <span style="color: red" class="astriks">*</span></label>
                                <textarea tabindex='16' name="pet_address" id="pet_address" placeholder="H.No.,  Street no, Colony,  Land Mark"
                                    class="form-control cus-form-ctrl sci_validation" minlength="3" maxlength="250" required> <?php echo isset($caveatee_details[0]['resadd']) ? $caveatee_details[0]['resadd'] : ''; ?></textarea>
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Please enter House No, Street No, Sector, Colony and Landmarks. Please Select District and Taluka from the below mentioned field. Do not repeat District and Taluka in Address fields and District and Taluka Fields. Address can be alphanumeric (<?php echo VALIDATION_PREG_MATCH_MSG; ?>).">
                                        <i class="fa fa-question-circle-o" ></i>
                                    </span>
                            </div>
                        </div>
                        
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Pin Code </label>
                                <input id="party_pincode" name="party_pincode" tabindex='17'
                                    onkeyup="this.value=this.value.replace(/[^0-9]/g,'');"
                                    placeholder="Pin code" 
                                    value="<?php echo !empty($caveatee_details[0]['res_pincode'])?$caveatee_details[0]['res_pincode']:''; ?>"
                                    class="form-control cus-form-ctrl" type="text" minlength="6" maxlength="6" >
                                    <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Pincode should be 6 digits only.">
                                        <i class="fa fa-question-circle-o"></i>
                                        <a href="https://www.indiapost.gov.in/vas/pages/findpincode.aspx" target="_blank" class="pin-code-loc" >Pin Code Locator</a>
                                    </span>
                            </div>
                        </div>
                        
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">City <span style="color: red" class="astriks">*</span></label>
                                <input id="party_city" tabindex='18' name="party_city" placeholder="City"
                                value="<?php echo isset($caveatee_details[0]['res_city'])?$caveatee_details[0]['res_city']:''; ?>"
                                class="form-control cus-form-ctrl sci_validation" type="text" minlength="3"
                                maxlength="49" required>
                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Please enter City name.">
                                    <i class="fa fa-question-circle-o" ></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">State <span style="color: red" class="astriks">*</span></label>
                                <select class="form-select cus-form-ctrl"  name="party_state" id="party_state"  tabindex='19'  required>
                                <option value="" title="Select">Select State</option>
                                <?php
                                $stateArr = array();
                                if (!empty($state_list)) 
                                {
                                if (count($state_list)>0) {
                                    foreach ($state_list as $dataRes) {
                                        $sel = (isset($caveatee_details[0]['res_state_id']) && $caveatee_details[0]['res_state_id'] == $dataRes->cmis_state_id) ? "selected=selected" : '';
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
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">District <span style="color: red" class="astriks">*</span></label>
                                    <select class="form-select cus-form-ctrl"
                                        aria-label="Default select example" name="party_district" id="party_district"  tabindex='20' >
                                        <option value="" title="Select">Select District</option>
                                        <?php
                                        if (!empty($district_list)) {
                                            foreach ($district_list as $dataRes) {
                                                $sel = (isset($caveatee_details[0]['res_dist']) && $caveatee_details[0]['res_dist'] == $dataRes->id_no) ? 'selected=selected' : '';
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
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 my-3">
                            <div class="save-btns text-center">
                                
                            <a href="<?= base_url('caveat/') ?>" class="quick-btn" id="nextButton" type="button"
                                tabindex='25'>Previous</a>
                            <?php if (isset($caveatee_details[0]['resorgid']) && !empty($caveatee_details[0]['resorgid'])) { ?>
                                
                                <input type="submit" class="quick-btn gray-btn" id="res_save" tabindex='21' value="UPDATE">
                                <a href="<?= base_url('caveat/subordinate_court') ?>" class="quick-btn" type="button" id="nextButton">Next</a>
                            <?php } else { ?>
                                <input type="submit" class="quick-btn gray-btn" id="res_save" value="SAVE" tabindex='22'>
                            <?php } ?>
                                
                            </div>
                        </div>
                        
                    </div>
                    <?php echo form_close();
                        ?>
                </div>
            </div>
        </div>
    </div>

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
                $('#indvidual_form').hide();
                $('#org_form').show();
                $('#org_state_row').show();
                $('#caveator_name').val('');
                $('#relation').val('');
                $('#relative_name').val('');
                $('#caveator_dob').val('');
                $('#caveator_age').val('');
                $("#stateDivBox").show();

                /*$('#party_gender1').val('');
                 $('#party_gender2').val('');
                 $('#party_gender3').val('');            */
            }
        }
    }
</script>


<script>
    $(document).ready(function() {
        // alert("SC");

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

    })

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
</script>







<script>
    $(".sci_validation").keyup(function(){
        var initVal = $(this).val();
        outputVal = initVal.replace(/[^a-z,^A-Z^0-9\.@,/'()\s"\-]/g,"").replace(/^\./,"");
        //validate_alpha_numeric_single_double_quotes_bracket_with_special_characters
        if (initVal != outputVal) {
            $(this).val(outputVal);
        }
    });

</script>
<script type="text/javascript">
    var state_Arr = '<?php echo json_encode($stateArr)?>';
    

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

    $(document).ready(function () {

        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        var ResState_ID= '<?php echo isset($caveatee_details[0]['res_org_state'])?$caveatee_details[0]['res_org_state']:''; ?>';
        var ResDept_ID='<?php echo isset($caveatee_details[0]['res_org_dept'])?$caveatee_details[0]['res_org_dept']:''; ?>';
        var ResPost_ID='<?php echo isset($caveatee_details[0]['res_org_post'])?$caveatee_details[0]['res_org_post']:''; ?>';


        if(ResState_ID==0 && ResState_ID!=''){
            $('#otherOrgState').show();
            var OrgState_NAME='<?php echo isset($caveatee_details[0]['res_org_state_name'])?$caveatee_details[0]['res_org_state_name']:''; ?>';
            $('#org_state_name').text(OrgState_NAME);
        }
        if(ResDept_ID==0 && ResDept_ID!=''){
            $('#otherOrgDept').show();
            var OrgDept_NAME='<?php echo isset($caveatee_details[0]['res_org_dept_name'])?$caveatee_details[0]['res_org_dept_name']:''; ?>';
            $('#org_dept_name').text(OrgDept_NAME);
        }
        if(ResPost_ID==0 && ResPost_ID!=''){
            $('#otherOrgPost').show();
            var OrgPost_NAME='<?php echo isset($caveatee_details[0]['res_org_post_name'])?$caveatee_details[0]['res_org_post_name']:''; ?>';
            $('#org_post_name').text(OrgPost_NAME);
        }
        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        $('#add_caveatee').on('submit', function () {

            if ($('#add_caveatee').valid()) {
              //  alert('hiii');
                //var form_data = $(this).serialize();
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

                var formdata = new FormData();
                formdata.append("CSRF_TOKEN", CSRF_TOKEN_VALUE);
                formdata.append("party_is", $('[name="party_is"]').val());
                formdata.append("pet_complainant", $('[name="pet_complainant"]').val());
                formdata.append("pet_rel_flag", $('[name="pet_rel_flag"]').val());
                formdata.append("relative_name", $('[name="relative_name"]').val());
                formdata.append("pet_dob", $('[name="pet_dob"]').val());
                formdata.append("pet_age", $('[name="pet_age"]').val());
                formdata.append("pet_gender", $('input[name="pet_gender"]:checked').val());
                formdata.append("org_state", $('[name="org_state"]').val());
                formdata.append("org_state_name", $('[name="org_state_name"]').val());
                formdata.append("org_dept", $('[name="org_dept"]').val());
                formdata.append("org_dept_name", $('[name="org_dept_name"]').val());
                formdata.append("org_post", $('[name="org_post"]').val());
                formdata.append("org_post_name", $('[name="org_post_name"]').val());
                formdata.append("pet_email", $('[name="pet_email"]').val());
                formdata.append("pet_mobile", $('[name="pet_mobile"]').val());
                formdata.append("pet_address", $('[name="pet_address"]').val());
                formdata.append("party_pincode", $('[name="party_pincode"]').val());
                formdata.append("party_state", $('[name="party_state"]').val());
                formdata.append("party_district", $('[name="party_district"]').val());
                formdata.append("party_city", $('[name="party_city"]').val());
                
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>caveat/caveatee/add_caveatee",
                    data: formdata,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                       $('#res_save').val('Please wait...');
                       $('#res_save').prop('disabled', true);
                    },
                    success: function (data) {
                        $('#res_save').val('SAVE');
                        $('#res_save').prop('disabled', false);
                        var resArr = data.split('@@@');
                        if (resArr[0] == 1) {
                            $('#msg').show();
                            $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                        } else if (resArr[0] == 2) {
                            $(".form-response").html("<p class='message valid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                            $('#msg').show();
                            window.location.href = resArr[2];

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
                return false;
            } else {
                return false;
            }
        });
    });

</script>
<script type="text/javascript">
    $('#res_rel_flag1').change(function () {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        var res_rel_flag = $('#res_rel_flag1').val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, relation_id: res_rel_flag},
            url: "<?php echo base_url('caveat/ajaxCalls/relative_required'); ?>",
            success: function (data)
            {
                var resArr = data.split('@@@');
                if (resArr[0] == 1) {
                    $('#msg').show();
                    $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                } else if (resArr[0] == 2) {
                    var res = resArr[1].split('#$');
                    var res_name = res[1].toUpperCase()
                    if (res[0] == '1' && res_name == 'SELF') {
                        document.getElementById('relative_label_name').innerHTML = 'Relative Name :';
                    } else {
                        document.getElementById('relative_label_name').innerHTML = 'Relative Name <span style="color: red">*</span> :';

                    }
                }
                $.getJSON("<?php echo base_url('csrf_token'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function () {
                $.getJSON("<?php echo base_url('csrf_token'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
    });
    //--------------------Get Caste-------------------------------//
    $('#res_religion').change(function () {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $('#res_cast').val('');
        var get_rel_id = $(this).val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, get_rel_id: get_rel_id},
            url: "<?php echo base_url('Webservices/get_caste_list'); ?>",
            success: function (data)
            {
                var resArr = data.split('@@@');
                if (resArr[0] == 1) {
                    $('#msg').show();
                    $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                } else if (resArr[0] == 2) {
                    $('#res_cast').html(resArr[1]);
                }

                $.getJSON("<?php echo base_url('csrf_token'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function () {
                $.getJSON("<?php echo base_url('csrf_token'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });

    });

    //----------------------end---------------------------------//
    //----------Get District List----------------------//

    
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
   

    //----------Get Taluka and Town List----------------------//

    $('.res_district').change(function () {

        $('#res_town').html('<option value="<?php echo url_encryption('0#$ $$town'); ?>"> Select Town </option>');
        $('#res_taluka').html('<option value="<?php echo url_encryption('0#$ $$taluka'); ?>"> Select Taluka </option>');
        $('#res_ward').html('<option value="<?php echo url_encryption('0#$ $$ward'); ?>"> Select Ward </option>');
        $('#res_village').html('<option value="<?php echo url_encryption('0#$ $$village'); ?>"> Select Village </option>');

        var get_state_id = $('#res_state_id').val();
        var get_distt_id = $(this).val();
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, get_state_id: get_state_id, taluka_distt_id: get_distt_id},
            url: "<?php echo base_url('Webservices/get_taluka'); ?>",
            success: function (data)
            {
                var resArr = data.split('@@@');
                if (resArr[0] == 1) {
                    $('#msg').show();
                    $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                } else if (resArr[0] == 2) {
                    $('#res_taluka').html(resArr[1]);
                }
                $.getJSON("<?php echo base_url('csrf_token'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                    $.ajax({
                        type: "POST",
                        data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, get_state_id: get_state_id, town_distt_id: get_distt_id},
                        url: "<?php echo base_url(); ?>Webservices/get_town",
                        success: function (data)
                        {
                            var resArr = data.split('@@@');
                            if (resArr[0] == 1) {
                                $('#msg').show();
                                $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                            } else if (resArr[0] == 2) {
                                $('#res_town').html(resArr[1]);
                            }

                            $.getJSON("<?php echo base_url('csrf_token'); ?>", function (result) {
                                $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                            });

                        },
                        error: function () {
                            $.getJSON("<?php echo base_url('csrf_token'); ?>", function (result) {
                                $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                            });
                        }
                    });
                });
            },
            error: function () {
                $.getJSON("<?php echo base_url('csrf_token'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });

    });

    //----------Get Village List----------------------//
    $('#res_taluka').change(function () {

        $('#res_ward').html('<option value="<?php echo url_encryption('0#$ $$ward'); ?>"> Select Ward </option>');
        $('#res_village').html('<option value="<?php echo url_encryption('0#$ $$village'); ?>"> Select Village </option>');

        var get_state_id = $('#res_state_id').val();
        var get_distt_id = $('#res_district').val();
        var get_taluka_id = $(this).val();

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, get_state_id: get_state_id, taluka_distt_id: get_distt_id, get_taluka_id: get_taluka_id},
            url: "<?php echo base_url('Webservices/get_village_list'); ?>",
            success: function (data)
            {
                var resArr = data.split('@@@');
                if (resArr[0] == 1) {
                    $('#msg').show();
                    $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                } else if (resArr[0] == 2) {
                    $('#res_village').html(resArr[1]);
                }

                $.getJSON("<?php echo base_url('csrf_token'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function () {
                $.getJSON("<?php echo base_url('csrf_token'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });

    });
    //----------Get Ward List----------------------//
    $('#res_town').change(function () {

        $('#res_ward').html('<option value="<?php echo url_encryption('0#$ $$ward'); ?>"> Select Ward </option>');

        var get_town_id = $(this).val();
        var get_state_id = $('#res_state_id').val();
        var distt_id = $('#res_district').val();

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, get_state_id: get_state_id, distt_id: distt_id, get_town_id: get_town_id},
            url: "<?php echo base_url('Webservices/get_ward_list'); ?>",
            success: function (data)
            {
                var resArr = data.split('@@@');
                if (resArr[0] == 1) {
                    $('#msg').show();
                    $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                } else if (resArr[0] == 2) {
                    $('#res_ward').html(resArr[1]);
                }

                $.getJSON("<?php echo base_url('csrf_token'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function () {
                $.getJSON("<?php echo base_url('csrf_token'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
    });

    //----------Get Organisation Details----------------------//
    $('#res_org_id').change(function () {
        $('#res_complainant').val('');
        $('#res_address').val('');
        var get_org_id = $(this).val();
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, organisation_id: get_org_id},
            url: "<?php echo base_url('caveat/ajaxCalls/get_org_details'); ?>",
            success: function (data)
            {
                if (data == '') {
                    $('#res_org_id').val('');
                }
                var resArr = data.split('@@@');
                if (resArr[0] == 1) {
                    $('#msg').show();
                    $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                } else if (resArr[0] == 2) {
                    if (resArr[1] == 'select') {
                        $('#not_in_list_org_name').hide();
                    } else if (resArr[1] == 'not_in_list') {
                        $('#not_in_list_org_name').show();
                    } else {
                        $('#not_in_list_org_name').hide();
                        $('#res_complainant').val(resArr[1]);
                        $('#res_address').val(resArr[2]);
                    }
                }

                $.getJSON("<?php echo base_url('csrf_token'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            },
            error: function () {
                $.getJSON("<?php echo base_url('csrf_token'); ?>", function (result) {
                    $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                });
            }
        });
    });

    function validateAddress(element) {
        if (element == 'Y') {
            document.getElementById('address_label_name').innerHTML = 'Address :';
        } else if (element == 'N') {
            document.getElementById('address_label_name').innerHTML = 'Address <span style="color: red">*</span> :';
        }
    }

    // $(document).ready(function () {
    //     $('#pet_dob').datepicker({
    //         onSelect: function (value) {
    //             var parts = value.split("/");
    //             var day = parts[0] && parseInt(parts[0], 10);
    //             var month = parts[1] && parseInt(parts[1], 10);
    //             var year = parts[2] && parseInt(parts[2], 10);
    //             var str = month + '/' + day + '/' + year;
    //             var today = new Date(),
    //                 dob = new Date(str),
    //                 age = new Date(today - dob).getFullYear() - 1970;
    //             $('#pet_age').val(age);
    //         },
    //         changeMonth: true,
    //         changeYear: true,
    //         yearRange: "-100:-1",
    //         dateFormat: "dd/mm/yy",
    //         defaultDate: '-40y'
    //     });
    // });
    

  











</script>


<?php if ((isset($efiling_civil_data[0]['resorgid']) && !empty($efiling_civil_data[0]['resorgid']) && $efiling_civil_data[0]['resorgid'] != '0') || (isset($efiling_civil_data[0]['res_not_in_list_org']) && !empty($efiling_civil_data[0]['res_not_in_list_org']) && $efiling_civil_data[0]['res_not_in_list_org'] == 't')) { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.show_hide_base_on_org').hide();
            $('#organisationShow').show();
            $('#res_org_id').hide();
        });
    </script>
<?php } else { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            //var title = '<?php //echo ucfirst($case_type_res_title); ?>//';
            //if (title != '') {
            //    var title_name = title;
            //} else {
            //    title_name = 'Caveatee';
            //}
            //$('.show_hide_base_on_org').show();
            //$('#organisationShow').hide();
            //document.getElementById('label_name').innerHTML = title_name + ' <span style="color: red">*</span> :';
        });
    </script>
<?php } ?>

