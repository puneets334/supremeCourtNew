<style>.caseno{height: 38px;} .year{padding: 0px 0px 0px 0px;background-color:#ffffff;border:none;border-radius: 0px;}</style>

<?php //print_r($sc_casetypearr); exit();
//print_r($_SESSION['efiling_details']);exit();
//print_r($sc_case_typeId_div_hide);exit();


?>
<div class="panel panel-default">
    <h4 style="text-align: center;color: #31B0D5"> Earlier Courts </h4>
    <div class="panel-body">
        <?=ASTERISK_RED_MANDATORY;?>
        <?php
        $attribute = array('class' => 'form-horizontal', 'name' => 'subordinate_court_details', 'id' => 'subordinate_court_details', 'autocomplete' => 'off');
        echo form_open('#', $attribute);
        $cause_title = explode(' Vs. ', $new_case_details[0]['cause_title']);
        ?>

        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <?php
                $noHcEntry=$subordinate_court_details[0]['is_hc_exempted']=='t'?'checked="checked"':'';
                $noHCButton=$subordinate_court_details[0]['is_hc_exempted']=='t'?'style="display:none;':'';
                $scchecked = $party_details[0]['selected_court'] == '4' ? 'checked="checked"' : '';
                $hcchecked = $party_details[0]['selected_court'] == '1' ? 'checked="checked"' : '';
                $dcchecked = $party_details[0]['selected_court'] == '3' ? 'checked="checked"' : '';
                $dcchecked = $party_details[0]['selected_court'] == '5' ? 'checked="checked"' : '';



                //$new_case_details[0]['sc_case_type_id'];
                if($sc_casetypearr!= 39 && $sc_casetypearr!= 9 && $sc_casetypearr!= 10 && $sc_casetypearr!= 19 && $sc_casetypearr!= 25 && $sc_casetypearr!= 26 && $sc_casetypearr!= 7 ){ ?>

                    <div align="center" id="nohc">
                        <input type="checkbox" <?php echo $noHcEntry;?> value="1" name="chk_nohc" id="chk_nohc" onchange="toggle_entry_div()"> I hereby confirm that there is no earlier courts cetails pertaining to this matter.      &nbsp; &nbsp;  <input type="button" class="btn btn-success" <?php echo $noHCButton; ?>id="nohc_save" value="Proceed with Next Stage">

                    </div>

                <?php } else{ ?>

                    <div align="center" id="nohc">
                        <input type="hidden" name="chk_nohc" id="chk_nohc">

                    </div>


                <?php }

                ?>
                <!--<div align="center" id="nohc">
                    <input type="checkbox" <?php /*echo $noHcEntry;*/?> value="1" name="chk_nohc" id="chk_nohc" onchange="toggle_entry_div()"> I hereby confirm that there is no Earlier Courts Details pertaining to this matter.      &nbsp; &nbsp;  <input type="button" class="btn btn-success" <?php /*echo $noHCButton; */?>id="nohc_save" value="Proceed with Next Stage">

                </div>-->
                <div id="hc_entry_div">
                    <div class="form-group">
                        <label class="control-label col-sm-4 input-sm"> Select Court <span style="color: red">*</span> :</label>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <?php
                            $court_type = !empty($caseData['court_type']) ? $caseData['court_type'] : NULL;
                            $state_id = !empty($caseData['state_id']) ? $caseData['state_id'] : NULL;
                            $district_id = !empty($caseData['district_id']) ? $caseData['district_id'] : NULL;
                            $estab_code = !empty($caseData['estab_code']) ? $caseData['estab_code'] : NULL;
                            $estab_id = !empty($caseData['estab_id']) ? $caseData['estab_id'] : NULL;

                            //echo '<pre>'; print_r($caseData['court_type']); exit;
                            ?>
                            <label class="radio-inline"><input tabindex = '1' type="radio" id="radio_selected_court1" name="radio_selected_court"onchange="get_court_as(this.value)" value="4" maxlength="2" <?php echo $scchecked; ?>> Supreme Court </label>
                            <label class="radio-inline"><input  tabindex = '2' type="radio" id="radio_selected_court2" name="radio_selected_court" onchange="get_court_as(this.value)" value="1" maxlength="2" <?php echo $hcchecked; ?>> High Court </label>
                            <label class="radio-inline"><input tabindex = '3' type="radio" id="radio_selected_court3" name="radio_selected_court" onchange="get_court_as(this.value)" value="3" maxlength="2" <?php echo $dcchecked; ?>> District Court </label>
                            <!--                        <label class="radio-inline"><input type="radio" id="radio_selected_court3" name="radio_selected_court" onchange="get_court_as(this.value)" value="2" maxlength="2" <?php echo $ochecked; ?>> Other Court </label>-->
                            <label class="radio-inline"><input tabindex = '4' type="radio" id="radio_selected_court5" name="radio_selected_court" onchange="get_court_as(this.value)" value="5" maxlength="2" <?php echo $sachecked; ?>> State Agency/Tribunal </label>
                        </div>
                    </div>
                    <!-- </div>
                 </div>-->
                    <hr>
                    <div id="supreme_court_info" style="display: block;">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Case Type <span style="color: red">*</span>:</label>
                                        <div class="col-md-7 col-sm-12 col-xs-12">
                                            <select name="sci_case_type_id" tabindex = '4' id="sci_case_type_id" class="form-control input-sm filter_select_dropdown" style="width: 100%">
                                                <option value="" title="Select">Select Case Type</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-12" >
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Case No.And Year <span style="color: red">*</span>:</label>
                                        <div class="col-md-7 col-sm-12 col-xs-12">
                                            <div class="input-group">
                                                <input id="sci_case_number" name="sci_case_number" tabindex = '5' maxlength="10" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Case No."  class="form-control input-sm age_calculate caseno" type="text">
                                                <span class="input-group-addon year" data-placement="bottom" data-toggle="popover" data-content="Related Case Year">
                                         <div class="input-group">
                                    <select tabindex = '6' class="form-control input-sm filter_select_dropdown" id="sci_case_year" name="sci_case_year" style="width: 100%">
                                        <option value="">Year</option>
                                        <?php
                                        $end_year = 47;
                                        for ($i = 0; $i <= $end_year; $i++) {
                                            $year = (int) date("Y") - $i;
                                            if (url_encryption($data_to_be_populated['year']) == url_encryption($year)) {
                                                $sel = 'selected=selected';
                                            } else {
                                                $sel = '';
                                            }
                                            echo '<option ' . $sel . ' value=' . url_encryption($year) . '>' . $year . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                    </span>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-3 col-sm-12 col-xs-12">

                                         </div>-->
                                    </div>
                                </div>
                                <!---->
                            </div>
                        </div>
                    </div>

                    <div id="high_court_info" style="display: none;">
                        <div class="row">
                            <div class="col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">CNR <span style="color: red">*</span>:</label>
                                    <div class="col-md-7 col-sm-12 col-xs-12">
                                        <div class="input-group">
                                            <input tabindex = '0'  id="cnr" name="cnr" maxlength="16" pattern="^[A-Z]{4}[0-9]{12}$" placeholder="CNR"  class="form-control input-sm age_calculate" type="text">
                                            <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Please enter CNR ">
                                <i class="fa fa-question-circle-o"  ></i>
                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-12">
                                <strong style="color: red;font-size:14px;"><b>Kindly search lower case details using CNR preferably for swift data retrieval</b></strong>
                            </div>
                        </div><center><p><h2>OR</h2></p></center>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">High Court <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select tabindex = '7' name="hc_court" id="hc_court" class="form-control input-sm filter_select_dropdown" style="width: 100%">
                                        <option value="" title="Select">Select High Court</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Bench <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select name="hc_court_bench" id="hc_court_bench" class="form-control input-sm filter_select_dropdown" style="width: 100%">
                                        <option value="" title="Select">Select High Court Bench</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Case Type <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select tabindex = '8' name="case_type_id" id="case_type_id" class="form-control input-sm filter_select_dropdown" style="width: 100%">
                                        <option value="" title="Select">Select Case Type</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12 hc_case_type_name" style="display:none;">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Case Type Name: <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <input type="text"  name="hc_case_type_name" id="hc_case_type_name" class="form-control input-sm" placeholder="Enter Case Type Name..">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Case No. And Year<span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <div class="input-group">
                                        <input tabindex = '9'  id="hc_case_number" name="hc_case_number" maxlength="10" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Case No."  class="form-control input-sm age_calculate caseno" type="text">
                                        <span class="input-group-addon year" data-placement="bottom" data-toggle="popover" data-content="Related Case Year">
                                <div class="input-group">
                            <select tabindex = '10' class="form-control input-sm filter_select_dropdown" id="hc_case_year" name="hc_case_year" style="height: 37px!important;width:75px!important;">
                                <option value="">Year</option>
                                <?php
                                $end_year = 47;
                                for ($i = 0; $i <= $end_year; $i++) {
                                    $year = (int) date("Y") - $i;
                                    if (url_encryption($data_to_be_populated['year']) == url_encryption($year)) {
                                        $sel = 'selected=selected';
                                    } else {
                                        $sel = '';
                                    }
                                    echo '<option ' . $sel . ' value=' . url_encryption($year) . '>' . $year . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="district_court_info" style="display: none;">
                        <div class="row">
                            <div class="col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">CNR <span style="color: red">*</span>:</label>
                                    <div class="col-md-7 col-sm-12 col-xs-12">
                                        <div class="input-group">
                                            <input tabindex = '0'  id="dc_cnr" name="dc_cnr" maxlength="16" pattern="^[A-Z]{4}[0-9]{12}$" placeholder="CNR"  class="form-control input-sm age_calculate" type="text">
                                            <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Please enter CNR ">
                                <i class="fa fa-question-circle-o"  ></i>
                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-12">
                                <strong style="color: red;font-size:14px;"><b>Kindly search lower case details using CNR preferably for swift data retrieval</b></strong>
                            </div>
                        </div><center><p><h2>OR</h2></p></center>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">State <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select tabindex = '11' name="state" id="state" class="form-control input-sm filter_select_dropdown" style="width: 100%">
                                        <option value="" title="Select">Select State</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">District <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select tabindex = '12' name="district" id="district" class="form-control input-sm filter_select_dropdown" style="width: 100%">
                                        <option value="" title="Select">Select District</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Establishment <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select tabindex = '13' name="establishment" id="establishment" class="form-control input-sm filter_select_dropdown" style="width: 100%">
                                        <option value="" title="Select">Select Establishment</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Case Type <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select tabindex = '14' name="dc_case_type_id" id="dc_case_type_id" class="form-control input-sm filter_select_dropdown" style="width: 100%">
                                        <option value="" title="Select">Select Case Type</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12 dc_case_type_name" style="display:none;">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Case Type Name: <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <input type="text"  name="dc_case_type_name" id="dc_case_type_name" class="form-control input-sm" placeholder="Enter Case Type Name..">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Case No. And Year <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <div class="input-group">
                                        <input tabindex = '15' id="dc_case_number" name="dc_case_number" maxlength="10" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Case No."  class="form-control input-sm age_calculate caseno" type="text">
                                        <span class="input-group-addon year" data-placement="bottom" data-toggle="popover" data-content="Related Case Year">
                                <div class="input-group">
                            <select tabindex = '16' class="form-control input-sm filter_select_dropdown" id="dc_case_year" name="dc_case_year" style="width: 100%">
                                <option value="">Year</option>
                                <?php
                                $end_year = 47;
                                for ($i = 0; $i <= $end_year; $i++) {
                                    $year = (int) date("Y") - $i;
                                    if (url_encryption($data_to_be_populated['year']) == url_encryption($year)) {
                                        $sel = 'selected=selected';
                                    } else {
                                        $sel = '';
                                    }
                                    echo '<option ' . $sel . ' value=' . url_encryption($year) . '>' . $year . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>




                    <div id="state_agency_info" style="display: none;">
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">State <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select tabindex = '7' name="agency_state" id="agency_state" class="form-control input-sm filter_select_dropdown" style="width: 100%">
                                        <option value="" title="Select">Select State</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Agency <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select name="agency" id="agency" class="form-control input-sm filter_select_dropdown" style="width: 100%">
                                        <option value="" title="Select">Select Agency</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Case Type <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <select tabindex = '8' name="agency_case_type_id" id="agency_case_type_id" class="form-control input-sm filter_select_dropdown" style="width: 100%">
                                        <option value="" title="Select">Select Case Type</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12 agency_case_type_name" style="display:none;">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Case Type Name: <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <input type="text"  name="agency_case_type_name" id="agency_case_type_name" class="form-control input-sm" placeholder="Enter Case Type Name..">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Case No. And Year <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <div class="input-group">
                                        <input tabindex = '9'  id="case_number" name="case_number" maxlength="10" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Case No."  class="form-control input-sm age_calculate caseno" type="text">
                                        <span class="input-group-addon year" data-placement="bottom" data-toggle="popover" data-content="Related Case Year">
                                <div class="input-group">
                            <select tabindex = '10' class="form-control input-sm filter_select_dropdown" id="case_year" name="case_year" style="width: 100%">
                                <option value="">Year</option>
                                <?php
                                $end_year = 47;
                                for ($i = 0; $i <= $end_year; $i++) {
                                    $year = (int) date("Y") - $i;
                                    if (url_encryption($data_to_be_populated['year']) == url_encryption($year)) {
                                        $sel = 'selected=selected';
                                    } else {
                                        $sel = '';
                                    }
                                    echo '<option ' . $sel . ' value=' . url_encryption($year) . '>' . $year . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12" id="search_button_div">
                        <div class="col-sm-4 col-xs-12 col-md-offset-5">
                            <div class="form-group">
                                <div class="col-md-offset-3">
                                    <input tabindex = '17' type="button" id="search_case_hc" name="search_case_hc" value="Search" class="info btn-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12" id="loader_div" style="display: none;">
                        <img id="loader_img" style="position: fixed;left: 50%;margin-top: -50px;margin-left: -100px;" src="<?php echo base_url(); ?>assets/images/loading-data.gif" />
                    </div>
                    <!----START : Show search Ressult---->
                    <div id="case_result"></div>
                    <!----END : Show search Ressult---->
                    <div class="clearfix"></div><br><br>
                    <input type="hidden" id="Sc_Case_TypeId" name="Sc_Case_TypeId" value="<?php echo $sc_case_typeId_div_hide; ?>"/>
                    

                    <div class="col-md-12 col-sm-12 col-xs-12" id="transfer_pet_DivBox">
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-12 col-xs-12 input-sm">Impugned Order Date <span style="color: red">*</span>:</label>
                                <div class="col-md-8 col-sm-12 col-xs-12">
                                    <div class="input-group">
                                        <input tabindex = '18' class="form-control has-feedback-left" id="order_date" name="order_date" maxlength="10" placeholder="DD/MM/YYYY"  type="text" style="width: 80%">
                                        <select id="order_dates_list" class="form-control input-md" style="width: 10%">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Impugned Order Challenged <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <?php
                                    $selectYes = $new_case_details[0]['judgement_challenged'] == '1' ? 'selected=selected' : '';
                                    $selectNo = $new_case_details[0]['judgement_challenged'] == '2' ? 'selected=selected' : '';
                                    ?>
                                    <select tabindex = '19' name="judgement_challenged" id="judgement_challenged" class="form-control input-sm filter_select_dropdown" style="width: 100%" >
                                        <option <?php echo $selectYes; ?> value="1">Yes</option>
                                        <option <?php echo $selectNo; ?> value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Impugned Order Type <span style="color: red">*</span>:</label>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <?php
                                    $selectInitial = $new_case_details[0]['judgement_type'] == 'F' ? 'selected=selected' : '';
                                    $selectInterim = $new_case_details[0]['judgement_type'] == 'I' ? 'selected=selected' : '';
                                    ?>
                                    <select tabindex = '20' name="judgement_type" id="judgement_type" class="form-control input-sm filter_select_dropdown" style="width: 100%" >
                                        <option <?php echo $selectInitial; ?> value="F">Final</option>
                                        <option <?php echo $selectInterim; ?> value="I">Interim</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FIR Details-->
                    <br>
                    <!--<div class="col-sm-12 col-xs-12">
                        <label> FIR Details</label>
                    </div>-->
                    <?php if($criminal_case==1){ ?>
                        <div class="row">
                            <label class="control-label col-xs-12" style="font-size: large; text-align: center">FIR Details</label>
                        </div>
                        <br>
                        <div id="fir_details">
                            <div class="col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">State <span style="color: red">*</span>:</label>
                                    <div class="col-md-7 col-sm-12 col-xs-12">
                                        <select tabindex = '21' name="fir_state" id="fir_state" class="form-control input-sm filter_select_dropdown" style="width: 100%">
                                            <option value="" title="Select">Select State</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">District <span style="color: red">*</span>:</label>
                                    <div class="col-md-7 col-sm-12 col-xs-12">
                                        <select tabindex = '22' name="fir_district" id="fir_district" class="form-control input-sm filter_select_dropdown" style="width: 100%">
                                            <option value="" title="Select">Select District</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm">Police Station <span style="color: red">*</span>:</label>
                                        <div class="col-md-7 col-sm-12 col-xs-12">
                                            <select tabindex = '23' name="fir_policeStation" id="fir_policeStation" class="form-control input-sm filter_select_dropdown" style="width: 100%">
                                                <option value="" title="Select">Select Police Station</option>
                                            </select>
                                        </div>
                                    </div>
                                    If Police Station not in list, please enter Police Station name and Complete FIR number below.
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> FIR No. <span style="color: red">*</span>:</label>
                                        <div class="col-md-7 col-sm-12 col-xs-12">
                                            <div class="input-group">
                                                <input tabindex = '24' id="fir_number" name="fir_number" maxlength="10" onkeyup="return isNumber(event)" placeholder="FIR Number"  class="form-control input-sm age_calculate" type="text">
                                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="FIR Number">
                                <i class="fa fa-question-circle-o"  ></i>
                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Year <span style="color: red">*</span>:</label>
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <div class="input-group">
                                                <select tabindex = '25' class="form-control input-sm filter_select_dropdown" id="fir_year" name="fir_year" style="width: 100%">
                                                    <option value="">Year</option>
                                                    <?php
                                                    $end_year = 48;
                                                    for ($i = 0; $i <= $end_year; $i++) {
                                                        $year = (int) date("Y") - $i;
                                                        if (url_encryption($data_to_be_populated['year']) == url_encryption($year)) {
                                                            $sel = 'selected=selected';
                                                        } else {
                                                            $sel = '';
                                                        }
                                                        echo '<option ' . $sel . ' value=' . url_encryption($year) . '>' . $year . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Police Station Name <span style="color: red">*</span>:</label>
                                        <div class="col-md-7 col-sm-12 col-xs-12">
                                            <div class="input-group">
                                                <input tabindex = '26' id="police_station_name" name="police_station_name" placeholder="Police Station Name"  class="form-control" type="text">
                                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="Police Station Name">
                                <i class="fa fa-question-circle-o"  ></i>
                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-12 col-xs-12 input-sm"> Complete FIR No. <span style="color: red">*</span>:</label>
                                        <div class="col-md-7 col-sm-12 col-xs-12">
                                            <div class="input-group">
                                                <input tabindex = '27' id="complete_fir_number" name="complete_fir_number" maxlength="15" onkeyup="return isNumber(event)" placeholder="FIR Number"  class="form-control input-sm age_calculate" type="text">
                                                <span class="input-group-addon" data-placement="bottom" data-toggle="popover" data-content="FIR Number">
                                <i class="fa fa-question-circle-o"  ></i>
                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- FIR Details end  -->
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                            <!--<a tabindex = '30' href="<?/*= base_url('newcase/actSections') */?>" class="btn btn-primary" type="button">Previous</a>-->
                            <a tabindex = '30' href="<?= base_url('newcase/respondent') ?>" class="btn btn-primary" type="button">Previous</a>
                            <input tabindex = '28' type="submit" class="btn btn-success" id="subcourt_save" value="SAVE">
                            <?php
                            if(isset($subordinate_court_details) && !empty($subordinate_court_details)){
                                echo ' <a  tabindex = "29" href="'.base_url('uploadDocuments').'" class="btn btn-primary btnNext" type="button">Next</a>';
                            }
                            ?>
                            <!--                <a  tabindex = '29' href="--><?//= base_url('uploadDocuments') ?><!--" class="btn btn-primary btnNext" type="button">Next</a>-->
                        </div>
                    </div>
                    <?php echo form_close();
                    ?>
                </div>

            </div>
        </div>
    </div>
</div>

<?php $this->load->view('newcase/subordinate_court_list'); ?>
<script type="text/javascript">

    $(document).ready(function () {

        //xxxxxxxxxxxxxxxxxxxxxxxx
        var divhide_sccasetype_ID='<?php echo $sc_case_typeId_div_hide; ?>';
        if(divhide_sccasetype_ID==7 || divhide_sccasetype_ID==8 ){
            $('#transfer_pet_DivBox').hide();
        }else{
            $('#transfer_pet_DivBox').show();
        }

        //xxxxxxxxxxxxxxxxxxxxxxx
        get_fir_state_list();
        toggle_entry_div();
        $('#case_type_id').on('change', function () {
            var case_type_id = $(this).val();
            var case_type_selectedText = $("#case_type_id option:selected").html();
            if(case_type_selectedText==='NOT IN LIST'){
                $('.hc_case_type_name').show();
                alert('Are you sure that it is not in list');
            }else {  $('.hc_case_type_name').hide();}
        });
        $('#dc_case_type_id').on('change', function () {
            var case_type_id = $(this).val();
            var case_type_selectedText = $("#dc_case_type_id option:selected").html();
            if(case_type_selectedText==='NOT IN LIST'){
                $('.dc_case_type_name').show();
                alert('Are you sure that it is not in list');
            }else {  $('.dc_case_type_name').hide();}
        });
        $('#agency_case_type_id').on('change', function () {
            var case_type_id = $(this).val();
            var case_type_selectedText = $("#agency_case_type_id option:selected").html();
            if(case_type_selectedText==='NOT IN LIST'){
                alert('Are you sure that it is not in list');
                $('.agency_case_type_name').show();
            }else {  $('.agency_case_type_name').hide();}
        });

        $('#order_dates_list').on('change', function () {
            var selectedText = $("#order_dates_list option:selected").html();
            var dateText = selectedText.split(" ");
            $("#order_date").val(dateText[0]);
            var ordType = dateText[1].split("-");
            $("#judgement_type").val(ordType[0]).change();
        });

        $('#cnr').on('input', function () {
            if( $.trim($('#cnr').val())=='')
                $("#hc_court, #hc_court_bench, #case_type_id, #case_number, #case_year").prop("disabled", false);
            else
                $("#hc_court, #hc_court_bench, #case_type_id, #case_number, #case_year").prop("disabled", true);
        });

        $('#dc_cnr').on('input', function () {
            if( $.trim($('#dc_cnr').val())=='')
                $("#state, #district, #establishment, #dc_case_type_id, #dc_case_number, #dc_case_year").prop("disabled", false);
            else
                $("#state, #district, #establishment, #dc_case_type_id, #dc_case_number, #dc_case_year").prop("disabled", true);
        });
        $('#police_station_name').on('input', function () {
            if( $.trim($('#police_station_name').val())=='')
                $("#fir_policeStation,#fir_number, #fir_year").prop("disabled", false);
            else
                $("#fir_policeStation,#fir_number, #fir_year").prop("disabled", true);
        });
        $('#fir_policeStation').on('change', function() {
            if( $.trim(this.value)!='')
                $("#police_station_name,#complete_fir_number").prop("disabled", true);
            else
                $("#police_station_name,#complete_fir_number").prop("disabled", false);
        });
        $('#subordinate_court_details').on('submit', function () {
            var ele = document.getElementsByName('radio_selected_court');

            for(var i = 0; i < ele.length; i++) {
                if(ele[i].checked)
                    var radio_slct_valid=ele[i].value;
            }
            if($('#case_result').is(':empty')){
                if(radio_slct_valid==1){
                    var hc_case_year= $('#hc_case_year').val();
                    if(hc_case_year==''){
                        alert("Please fill Case No. And Year.");
                        $("#hc_case_year").css('border-color', 'red');
                        return false;

                    }
                }
                else if(radio_slct_valid==4){
                    var sci_case_year= $('#sci_case_year').val();
                    if(sci_case_year==''){
                        alert("Please fill Case No. And Year.");
                        $("#sci_case_year").css('border-color', 'red');
                        return false;

                    }
                }
                else if(radio_slct_valid==3){
                    var dc_case_year=$('#dc_case_year').val();
                    if(dc_case_year==''){
                        alert("Please fill Case No. And Year.");
                        $("#dc_case_year").css('border-color', 'red');
                        return false;

                    }
                }
                else if(radio_slct_valid==5){
                    var case_year=$('#case_year').val();
                    if(case_year==''){
                        alert("Please fill Case No. And Year.");
                        $("#case_year").css('border-color', 'red');
                        return false;

                    }
                }
            }

            var Sc_Case_TypeId=$('#Sc_Case_TypeId').val();
            if(Sc_Case_TypeId==7 || Sc_Case_TypeId==8) {

            }else{
                var judgement_type = $("#judgement_type").val();

                var order_date = $("#order_date").val();
                if (judgement_type) {
                    if (order_date == '') {
                        alert("Please fill impugned order date.");
                        $("#order_date").css('border-color', 'red');
                        return false;
                    }
                }
            }

            if ($('#subordinate_court_details').valid()) {
                var form_data = $(this).serialize();
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('newcase/Subordinate_court/add_subordinate_court_details'); ?>",
                    data: form_data,
                    async: false,
                    beforeSend: function () {
                        $('#subcourt_save').val('Please wait...');
                        $('#subcourt_save').prop('disabled', true);
                    },
                    success: function (data) {
                        $('#subcourt_save').val('SAVE');
                        $('#subcourt_save').prop('disabled', false);
                        var resArr = data.split('@@@');
                        if (resArr[0] == 1) {
                            $('#msg').show();
                            $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                        } else if (resArr[0] == 2) {
                            $(".form-response").html("<p class='message valid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                            $('#msg').show();
                            location.reload();
                            //window.location.href = resArr[2];
                        } else if (resArr[0] == 3) {
                            $('#msg').show();
                            $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
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

        //----------Get High Court Bench List----------------------//
        $('#hc_court').change(function () {

            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $('#case_type_id').val('');

            var high_court_id = $(this).val();
            $.ajax({
                type: "POST",
                data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, high_court_id: high_court_id, court_type: '1'},
                url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/get_hc_bench_list'); ?>",
                success: function (data)
                {
                    $('#hc_court_bench').html(data);
                    if(hc_bench_value && court_type == 1){
                        $('#hc_court_bench').val(hc_bench_value).select2().trigger("change");
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

        });

        //----------Get Case Type List----------------------//
        $('#hc_court_bench').change(function () {

            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $('#case_type_id').val('');

            var hc_bench_id = $(this).val();
            $.ajax({
                type: "POST",
                data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, hc_bench_id: hc_bench_id, court_type: '1'},
                url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/get_hc_case_type_list'); ?>",
                success: function (data)
                {
                    $('#case_type_id').html(data);
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


        $("#search_case_hc").click(function () {
            $('#search_button_div').hide();
            $('#loader_div').show();
            var court_type = $("input[name=radio_selected_court]:checked").val();

            if (court_type == 1) { //-High Court

                var hc_court = $('#hc_court option:selected').val();
                var hc_court_bench = $('#hc_court_bench option:selected').val();
                var hc_court_name = $('#hc_court option:selected').text();
                var case_type = $('#case_type_id option:selected').val();
                var case_type_name = $('#hc_case_type_name').val();
                var case_number = $('#hc_case_number').val();
                var case_year = $('#hc_case_year option:selected').val();
                var cnr = $('#cnr').val();

            } else if (court_type == 4) {//--Supreme court

                case_type = $('#sci_case_type_id option:selected').val();
                var case_type_name = '';
                case_number = $('#sci_case_number').val();
                case_year = $('#sci_case_year option:selected').val();

            } else if (court_type == 3) {//--District court

                var estab_id = $('#establishment option:selected').val();
                case_type = $('#dc_case_type_id option:selected').val();
                var case_type_name = $('#dc_case_type_name').val();
                case_number = $('#dc_case_number').val();
                case_year = $('#dc_case_year option:selected').val();
                cnr = $('#dc_cnr').val();
            } else if (court_type == 5) {//--Agency court
                var case_type_name = $('#agency_case_type_name').val();
            }
            //alert(case_number);alert(case_year);

            $('#msg').hide();
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/search_case_details'); ?>",
                data: {cnr:cnr, selected_court: court_type, high_court_id: hc_court, hc_name: hc_court_name, hc_court_bench: hc_court_bench, estab_id: estab_id, case_type_id: case_type,case_type_name:case_type_name, case_number: case_number, case_year: case_year},
                async: true,
                success: function (data) {
                    $('#loader_div').hide();
                    $('#search_button_div').show();
                    var resArr = data.split('@@@');

                    if (resArr[0] == 1) {
                        $('#msg').show();
                        $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                        setTimeout(function () {
                            $(".form-response").hide();
                        }, 2000);
                        $("#case_result").html('');
                    } else if (resArr[0] == 2) {
                        $("#case_result").html(resArr[1]);
                        $("#order_date").val(resArr[2]);
                        $("#order_dates_list").html(resArr[3]);
                        $('#show_button').hide();

                    } else if (resArr[0] == 3) {
                        $('#msg').show();
                        $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                    }
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                },
                error: function () {
                    $('#loader_div').hide();
                    $('#search_button_div').show();
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                }
            });
        });
        //earlier courts selection
        court_type = "<?php echo $court_type;?>";
        hc_bench_value = "<?php echo $hc_bench_value;?>";
        hc_value = "<?php echo $hc_value;?>";
        state_value = "<?php echo $state_value;?>";
        district_value = "<?php echo $district_value;?>";
        agency_state_value = "<?php echo $agency_state_value;?>";
        agency_name_value = "<?php echo $agency_name_value;?>";
        court_type = parseInt(court_type);
        if(court_type){
            switch (court_type){
                case 1:
                    //high court
                    $("#radio_selected_court2").prop('checked',true).trigger('click');
                    $('#supreme_court_info').hide();
                    $('#district_court_info').hide();
                    $('#state_agency_info').hide();
                    $('#high_court_info').show();
                    $('#search_button_div').show();
                    get_high_court_list(court_type,hc_value);
                    break;
                case 3:
                    //district court
                    $("#radio_selected_court3").prop('checked',true).trigger('click');
                    $('#district_court_info').show();
                    $('#high_court_info').hide();
                    $('#state_agency_info').hide();
                    $('#supreme_court_info').hide();
                    $('#search_button_div').show();
                    get_state_list();
                    break;
                case 4:
                    //supreme court
                    $("#radio_selected_court1").prop('checked',true).trigger('click');
                    $('#high_court_info').hide();
                    $('#state_agency_info').hide();
                    $('#district_court_info').hide();
                    $('#supreme_court_info').show();
                    $('#search_button_div').show();
                    get_sci_case_type()
                    break;
                case 5:
                    //state agency
                    $("#radio_selected_court5").prop('checked',true).trigger('click');
                    $('#state_agency_info').show();
                    $('#high_court_info').hide();
                    $('#district_court_info').hide();
                    $('#supreme_court_info').hide();
                    $('#search_button_div').hide();
                    get_agency_state_list();
                    break;
                default:
            }
        }
    });



    /* Functions for fir */
    function get_fir_state_list()
    {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $('#fir_state').val('');

        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE},
            url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/get_icmis_state_list'); ?>",
            success: function (data)
            {
                $('#fir_state').html(data);
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

    $('#fir_state').change(function () {

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $('#fir_district').val('');

        var get_state_id = $(this).val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, state_id: get_state_id},
            url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/get_icmis_district_list'); ?>",
            success: function (data)
            {
                $('#fir_district').html(data);
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

    $('#fir_district').change(function () {
        $('#fir_policeStation').val('');

        var get_distt_id = $(this).val();
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        var state_id = $("#fir_state option:selected").val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, state_id: state_id, get_distt_id: get_distt_id},
            url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/get_police_station_list'); ?>",
            success: function (data) {
                $('#fir_policeStation').html(data);
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


    function get_court_as(court_as) {

        $('#select2-case_type_id-container').text('Select Case Type');
        $('#case_type_id').val('');

        if (court_as == '4') {
            $('#high_court_info').hide();
            $('#state_agency_info').hide();
            $('#district_court_info').hide();
            $('#supreme_court_info').show();
            $('#search_button_div').show();
            get_sci_case_type()
        } else if (court_as == '1') {

            $('#supreme_court_info').hide();
            $('#district_court_info').hide();
            $('#state_agency_info').hide();
            $('#high_court_info').show();
            $('#search_button_div').show();
            get_high_court_list(court_as);
        } else if (court_as == '3') {

            $('#district_court_info').show();
            $('#high_court_info').hide();
            $('#state_agency_info').hide();
            $('#supreme_court_info').hide();
            $('#search_button_div').show();
            get_state_list();

        }else if (court_as == '5') {
            $('#state_agency_info').show();
            $('#high_court_info').hide();
            $('#district_court_info').hide();
            $('#supreme_court_info').hide();
            $('#search_button_div').hide();
            get_agency_state_list();
        }
    }

    function get_high_court_list(court_as,hc_value=null) {

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, selected_post_id: court_as},
            url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/get_high_court'); ?>",
            success: function (data)
            {
                $('#hc_court').html(data);
                if(hc_value && court_as == 1){
                    $('#hc_court').val(hc_value).select2().trigger("change");
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

    function get_sci_case_type() {

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $('#sci_case_type_id').val('');

        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE},
            url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/get_sci_case_type'); ?>",
            success: function (data)
            {
                $('#sci_case_type_id').html(data);
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

    function get_state_list() {

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $('#state').val('');

        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE},
            url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/get_state_list'); ?>",
            success: function (data)
            {
                $('#state').html(data);
                if(state_value && court_type == 3){
                    $('#state').val(state_value).select2().trigger("change");
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


    //----------Get District List----------------------//
    $('#state').change(function () {

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $('#district').val('');

        var get_state_id = $(this).val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, state_id: get_state_id},
            url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/get_district_list'); ?>",
            success: function (data)
            {
                $('#district').html(data);
                if(district_value && court_type == 3){
                    $('#district').val(district_value).select2().trigger("change");
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

    });

    $('#district').change(function () {
        $('#establishment').val('');

        var get_distt_id = $(this).val();
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        var state_id = $("#state option:selected").val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, state_id: state_id, get_distt_id: get_distt_id},
            url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/get_establishment_list'); ?>",
            success: function (data)
            {
                if (data.indexOf('ERROR') != -1) {
                    $('#msg').show();
                    $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + data + " <span class='close' onclick=hideMessageDiv()>X</span></p>");
                    $('#establishment').html('<option value=""> Select Establishment </option>');
                } else {
                    $('#msg').hide();
                    $('#establishment').html(data);
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
    });

    $('#establishment').change(function () {

        var estab_id = $('#establishment').val();
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, est_code: estab_id},
            url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/OpenAPIcase_type_list'); ?>",
            success: function (data)
            {
                $('#dc_case_type_id').html(data);
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

    $('#nohc_save').click(function () {

        var hcval= $('#chk_nohc').val();
        //  alert(hcval);
        if (document.getElementById('chk_nohc').checked==false)
        {
            alert("Please Select the checkbox to proceed");
            return;
        }
        // alert("dfdsf");
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE},
            url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/bypass_hc'); ?>",
            success: function (data)
            {
                var ans=data.split('@');
                //alert(ans[1]);
                window.location="<?php echo base_url('uploadDocuments')?>";
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


    function get_agency_state_list()
    {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $('#fir_state').val('');

        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE},
            url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/get_icmis_state_list'); ?>",
            success: function (data)
            {
                $('#agency_state').html(data);
                if(agency_state_value && court_type == 5){
                    $('#agency_state').val(agency_state_value).select2().trigger("change");
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


    $('#agency_state').change(function () {

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $('#case_type_id').val('');

        var agency_state_id = $(this).val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, agency_state_id: agency_state_id, court_type: '5'},
            url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/get_state_agency_list'); ?>",
            success: function (data)
            {
                $('#agency').html(data);
                if(agency_name_value && court_type == 5){
                    $('#agency').val(agency_name_value).select2().trigger("change");
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

    });


    $('#agency').change(function () {

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $('#case_type_id').val('');

        var agency_id = $(this).val();
        $.ajax({
            type: "POST",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, agency_id: agency_id, court_type: '5'},
            url: "<?php echo base_url('newcase/Ajaxcalls_subordinate_court/get_state_agency_case_types'); ?>",
            success: function (data)
            {
                $('#agency_case_type_id').html(data);
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

    function toggle_entry_div()
    {
        if($("#chk_nohc").is(":checked"))
        {
            $("#hc_entry_div").hide();
        }
        else {
            $("#hc_entry_div").show();
        }

    }

</script>