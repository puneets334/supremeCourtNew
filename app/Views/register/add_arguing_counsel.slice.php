@extends('responsive_variant.layouts.master.uikit_scutum_2.index')

@section('title', 'Add/Approve Advocate(s)')
@section('heading', 'Add/Approve Advocate(s)')
@section('pinned-main-offcanvas') @endsection
@section('content-container-ribbon')@endsection
@section('content')

<div class="uk-margin-small-top uk-border-rounded">
    <?php
    if(!empty($this->session->flashdata('success'))){
        echo "<span style='color:green;margin-left: 529px;'>".$this->session->flashdata('success')."</span>";
    }
    if(!empty($this->session->flashdata('error'))){
        echo "<span style='color:red;margin-left: 529px;'>".$this->session->flashdata('error')."</span>";
    }
     if(isset($arguingCounselDetails['registration_code']) && !empty($arguingCounselDetails['registration_code'])){
        $advocate_name = !empty($arguingCounselDetails['advocate_name']) ? $arguingCounselDetails['advocate_name'] : '';
        $mobile_number = !empty($arguingCounselDetails['mobile_number']) ? $arguingCounselDetails['mobile_number'] : '';
        $emailid = !empty($arguingCounselDetails['emailid']) ? $arguingCounselDetails['emailid'] : '';
        $bar_reg_no = !empty($arguingCounselDetails['bar_reg_no']) ? $arguingCounselDetails['bar_reg_no'] : '';
        $action="saveArguingCounselCompleteDetails";
        $attribute = array('class' => 'form-horizontal form-label-left', 'enctype'=>'multipart/form-data', 'id' => 'saveArguingCounselCompleteDetails', 'name' => 'saveArguingCounselCompleteDetails', 'autocomplete' => 'off');
        echo form_open($action, $attribute);
        ?>
        <div class="uk-child-width-1-1 uk-child-width-1-2@m uk-grid-small uk-grid" uk-grid="" uk-height-viewport="offset-top:true" style="min-height: calc(100vh - 60.4062px);">
            <!-- left box start -->
            <div class="uk-visible@m uk-first-column">
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Name <span style="color: red">*</span> :</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" type="text" name="name" id="name" placeholder="Name"  value="<?php echo set_value('name'); ?>" maxlength="100" minlength="3" tabindex="1">
                    </div>
                    <?php  if(form_error('name')){
                        echo "<span style='color:red'>".form_error('name')."</span>";
                    }
                    ?>
                    <div id="error_name"></div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Mobile <span style="color: red">*</span> :</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" type="text" name="mobile" id="mobile" value="<?php echo $mobile_number;?>" placeholder="9876543XXX" maxlength="10"   tabindex="3" readonly>
                    </div>
                    <?php  if(form_error('mobile')){
                        echo "<span style='color:red'>".form_error('mobile')."</span>";
                    }
                    if(!empty($this->session->flashdata('mobileExistMessage'))){
                        echo "<span style='color:red'>".$this->session->flashdata('mobileExistMessage')."</span>";
                    }
                    ?>
                    <div id="error_mobile"></div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">Relation <span style="color: red">*</span> :</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" tabindex = '5' name="relation" id="relation"  >
                            <option value="">Select Relation</option>
                            <option value="S">Son Of</option>
                            <option value="D">Daughter Of</option>
                            <option value="W">Spouse Of</option>
                            <option value="N">Not Available</option>
                        </select>
                        <?php  if(form_error('ralation')){
                            echo "<span style='color:red'>".form_error('relation')."</span>";
                        }
                        ?>
                        <div id="error_relation"></div>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">AOR <span style="color: red">*</span> :</label>
                    <div class="uk-form-controls">
                        <select class="uk-select"  tabindex = '5' name="aor" id="aor">
                            <option value="" >Select AOR</option>
                            <?php
                            if(isset($aorList) && !empty($aorList)){
                                foreach($aorList as $k=>$v) {
                                        $name = '';
                                        $name = $v['first_name'];
                                    echo '<option value="'.$v['id'].'">'.$name.'</option>';
                                }
                            }
                            ?>
                        </select>
                        <?php  if(form_error('aor')){
                            echo "<span style='color:red'>".form_error('aor')."</span>";
                        }
                        ?>
                        <div id="error_aor"></div>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Chamber Address :</label>
                    <div class="uk-form-controls">
                        <textarea class="uk-textarea" rows="2" name="c_address" id="c_address"  placeholder="Address" maxlength="250"  tabindex="7"><?php echo set_value('c_address');?></textarea>
                    </div>
                    <?php  if(form_error('c_address')){
                        echo "<span style='color:red'>".form_error('c_address')."</span>";
                    }
                    ?>
                    <div id="error_c_address"></div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Pincode :</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" type="text"  value="<?php echo set_value('c_pincode'); ?>" name="c_pincode" onkeyup="return isNumber(event)" id="c_pincode"  placeholder="Pincode" maxlength="6"   tabindex="8" />
                    </div>
                    <?php  if(form_error('c_pincode')){
                        echo "<span style='color:red'>".form_error('c_pincode')."</span>";
                    }
                    ?>
                    <div id="error_c_pincode"></div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">City :</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" type="text" value="<?php echo set_value('c_city'); ?>" name="c_city" id="c_city"  placeholder="City" maxlength="25"  tabindex="9" />
                    </div>
                    <?php  if(form_error('c_city')){
                        echo "<span style='color:red'>".form_error('c_city')."</span>";
                    }
                    ?>
                    <div id="error_c_city"></div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">State :</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" name="c_state"  id="c_state"   tabindex="10">
                            <option value="">Select State</option>
                            <?php
                            $stateArr = array();
                            if (isset($state_list) && !empty($state_list)){
                                foreach ($state_list as $dataRes) {
                                    echo '<option value="'.url_encryption(trim($dataRes->cmis_state_id)).'">'.strtoupper($dataRes->agency_state).'</option>';
                                    $tempArr = array();
                                    $tempArr['id'] = url_encryption(trim($dataRes->cmis_state_id));
                                    $tempArr['state_name'] = strtoupper($dataRes->agency_state);
                                    $stateArr[] = (object)$tempArr;
                                }
                            }
                            ?>
                        </select>
                        <?php  if(form_error('c_state')){
                            echo "<span style='color:red'>".form_error('c_state')."</span>";
                        }
                        ?>
                        <div id="error_c_state"></div>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">District :</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" name="c_district" id="c_district"  tabindex="11">
                            <option value="">Select District</option>
                        </select>
                        <?php  if(form_error('c_district')){
                            echo "<span style='color:red'>".form_error('c_district')."</span>";
                        }
                        ?>
                        <div id="error_c_district"></div>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Registration Bar Id Card <span style="color: red">*</span>Size: (<?php echo ((BAR_ID_CARD_SIZE/1024)/1024);?>MB) Type:(pdf/jpeg/jpg):</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" type="file" accept=".pdf,.jpeg,.jpg" name="bar_id_card" id="bar_id_card"   tabindex="14" />
                    </div>
                    <?php  if(form_error('bar_id_card')){
                        echo "<span style='color:red'>".form_error('bar_id_card')."</span>";
                    }
                    if(!empty($this->session->flashdata('bar_id_card_error'))){
                        echo "<span style='color:red'>".$this->session->flashdata('bar_id_card_error')."</span>";
                    }
                    ?>
                    <div id="error_bar_id_card"></div>
                </div>
            </div>
            <!-- left box end -->
            <!-- right box start -->
            <div class="uk-visible@m uk-first-column">
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Email <span style="color: red">*</span> :</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" type="email" name="email" id="email" value="<?php echo $emailid;?>" maxlength="100" placeholder="admin@gmail.com "  tabindex="2" readonly/>
                    </div>
                    <?php  if(form_error('email')){
                        echo "<span style='color:red'>".form_error('email')."</span>";
                    }
                    ?>
                    <div id="error_email"></div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Bar Registration No. :</label>
                    <div class="uk-form-controls">
                        <?php
                        $readony = "";
                        if(isset($bar_reg_no) && !empty($bar_reg_no)){
                            $readony = "readonly";
                        }
                        ?>
                        <input class="uk-input" type="text" name="bar_reg_no"  value="<?php echo ($bar_reg_no) ?  $bar_reg_no : set_value('bar_reg_no');?>" id="bar_reg_no" maxlength="30" placeholder="abccd2314441"   tabindex="4" <?php echo $readony;?>/>
                    </div>
                    <?php  if(form_error('bar_reg_no')){
                        echo "<span style='color:red'>".form_error('bar_reg_no')."</span>";
                    }
                    ?>
                    <div id="error_bar_reg_no"></div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Relative Name <span style="color: red">*</span>:</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" type="text" value="<?php echo set_value('relation_name');?>"  name="relation_name" id="relation_name"  placeholder="Relative Name" maxlength="35" tabindex="6" />
                    </div>
                    <?php  if(form_error('relation_name')){
                        echo "<span style='color:red'>".form_error('relation_name')."</span>";
                    }
                    ?>
                    <div id="error_relation_name"></div>
                </div>
                <div class="uk-margin">
                    <label style="margin-top: 35px;margin-bottom: 9px;" class="uk-form-label"><input class="uk-checkbox" type="checkbox"  name="same_as" id="same_as"  tabindex="12" /> Same As Chamber Address :</label>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Residential Address :</label>
                    <div class="uk-form-controls">
                        <textarea class="uk-textarea" name="r_address" id="r_address"  placeholder="Address" maxlength="250" tabindex="13"><?php echo set_value('r_address');?> </textarea>
                    </div>
                    <?php  if(form_error('r_address')){
                        echo "<span style='color:red'>".form_error('r_address')."</span>";
                    }
                    ?>
                    <div id="error_r_address"></div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Pincode :</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" value="<?php echo set_value('r_pincode');?>" name="r_pincode" id="r_pincode"  placeholder="Pincode" maxlength="6"  tabindex="14" />
                    </div>
                    <?php  if(form_error('r_pincode')){
                        echo "<span style='color:red'>".form_error('r_pincode')."</span>";
                    }
                    ?>
                    <div id="error_r_pincode"></div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">City :</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" value="<?php echo set_value('r_city');?>" name="r_city" id="r_city"  placeholder="City" maxlength="25" tabindex="15" />
                    </div>
                    <?php  if(form_error('r_city')){
                        echo "<span style='color:red'>".form_error('r_city')."</span>";
                    }
                    ?>
                    <div id="error_r_city"></div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">State :</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" name="r_state"  id="r_state" tabindex="16">
                            <option value="">Select State</option>
                            <?php
                            if (isset($state_list) && !empty($state_list)){
                                foreach ($state_list as $dataRes) {
                                    echo '<option value="'.url_encryption(trim($dataRes->cmis_state_id)).'">'.strtoupper($dataRes->agency_state).'</option>';
                                }
                            }
                            ?>
                        </select>
                        <?php  if(form_error('r_state')){
                            echo "<span style='color:red'>".form_error('r_state')."</span>";
                        }
                        ?>
                        <div id="error_r_state"></div>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">District :</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" name="r_district" id="r_district"  tabindex="17">
                            <option>Select District</option>
                        </select>
                        <?php  if(form_error('r_district')){
                            echo "<span style='color:red'>".form_error('r_district')."</span>";
                        }
                        ?>
                        <div id="error_r_district"></div>
                    </div>
                </div>

            </div>
            <!-- right box end -->
            <div class="uk-margin" style="margin-left: auto;margin-right: auto;width: 130px;margin-bottom: 162px;">
                <input type="submit" class="uk-button uk-button-primary" name="register" id="register" value="Register">
            </div>
            <?php echo form_close(); ?>
        </div>
    <?php }
     else if((isset($arguingCounselDetails) && !empty($arguingCounselDetails)) &&  (!isset($arguingCounselDetails['registration_code']) && empty($arguingCounselDetails['registration_code']))){
         ?>
         <div class="table-wrapper-scroll-y my-custom-scrollbar ">
             <div class="x_content">
             </div>
         </div>
     <?php }
     else if(!empty($this->session->userdata('login')['ref_m_usertype_id'])){
         $action="registerCounsel";
         $attribute = array('class' => 'form-horizontal form-label-left',  'id' => 'add_arguing_counsel', 'name' => 'add_arguing_counsel', 'autocomplete' => 'off');
         echo form_open($action, $attribute);
         ?>
         <div class="uk-child-width-1-1 uk-child-width-1-2@m uk-grid-small uk-grid">
             <!-- left box start -->
             <div class="uk-visible@m uk-first-column">
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-text">Name <span style="color: red">*</span> :</label>
                     <div class="uk-form-controls">
                         <input class="uk-input" type="text" name="name" id="name" placeholder="Name"  value="<?php echo set_value('name'); ?>" maxlength="100" minlength="3" tabindex="1">
                     </div>
                     <?php  if(form_error('name')){
                         echo "<span style='color:red'>".form_error('name')."</span>";
                     }
                     ?>
                     <div id="error_name"></div>
                 </div>
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-text">Mobile <span style="color: red">*</span> :</label>
                     <div class="uk-form-controls">
                         <input class="uk-input" type="text" name="mobile" id="mobile" value="<?php echo $mobile_no;?>" placeholder="9876543XXX" maxlength="10"   tabindex="3">
                     </div>
                     <?php  if(form_error('mobile')){
                         echo "<span style='color:red'>".form_error('mobile')."</span>";
                     }
                     if(!empty($this->session->flashdata('mobileExistMessage'))){
                         echo "<span style='color:red'>".$this->session->flashdata('mobileExistMessage')."</span>";
                     }
                     ?>
                     <div id="error_mobile"></div>
                 </div>
             </div>
             <!-- left box end -->
             <!-- right box start -->
             <div class="uk-visible@m uk-first-column">
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-text">Email <span style="color: red">*</span> :</label>
                     <div class="uk-form-controls">
                         <input class="uk-input" type="email" name="email" id="email" value="<?php echo $email_id;?>" maxlength="100" placeholder="admin@gmail.com "  tabindex="2"/>
                     </div>
                     <?php  if(form_error('email')){
                         echo "<span style='color:red'>".form_error('email')."</span>";
                     }
                     ?>
                     <div id="error_email"></div>
                 </div>
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-text">Bar Registration No. :</label>
                     <div class="uk-form-controls">
                         <?php
                         $readony = "";
                         if(isset($bar_reg_no) && !empty($bar_reg_no)){
                             $readony = "readonly";
                         }
                         ?>
                         <input class="uk-input" type="text" name="bar_reg_no"  value="<?php echo ($bar_reg_no) ?  $bar_reg_no : set_value('bar_reg_no');?>" id="bar_reg_no" maxlength="30" placeholder="abccd2314441"   tabindex="4" <?php echo $readony;?>/>
                     </div>
                     <?php  if(form_error('bar_reg_no')){
                         echo "<span style='color:red'>".form_error('bar_reg_no')."</span>";
                     }
                     ?>
                     <div id="error_bar_reg_no"></div>
                 </div>
                 <div class="uk-margin">
                     <input type="submit" class="uk-button uk-button-primary" name="add_arguing_counsel_submit" id="add_arguing_counsel_submit" value="Register">
                 </div>
             </div>
             <!-- right box end -->

             <?php echo form_close(); ?>
         </div>
     <?php  }
     else if(!empty($this->session->userdata('self_register_arguing_counsel')) &&  (!empty($this->session->userdata('self_arguing_counsel')))){
         ?>
         <div class="table-wrapper-scroll-y my-custom-scrollbar ">
             <div class="x_content">
             </div>
         </div>
     <?php }
     else if(!empty($this->session->userdata('self_register_arguing_counsel'))){
            $action="saveArguingCounselCompleteDetails";
            $attribute = array('class' => 'form-horizontal form-label-left', 'enctype'=>'multipart/form-data', 'id' => 'saveArguingCounselCompleteDetails', 'name' => 'saveArguingCounselCompleteDetails', 'autocomplete' => 'off');
            echo form_open($action, $attribute);
            $mobile_no = !empty($_SESSION['adv_details']['mobile_no']) ? $_SESSION['adv_details']['mobile_no'] : '';
            $email_id = !empty($_SESSION['adv_details']['email_id']) ? $_SESSION['adv_details']['email_id'] : '';
        ?>
         <div class="uk-child-width-1-1 uk-child-width-1-2@m uk-grid-small uk-grid" uk-grid="" uk-height-viewport="offset-top:true" style="min-height: calc(100vh - 60.4062px);">
             <!-- left box start -->
             <div class="uk-visible@m uk-first-column">
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-text">Name <span style="color: red">*</span> :</label>
                     <div class="uk-form-controls">
                         <input class="uk-input" type="text" name="name" id="name" placeholder="Name"  value="<?php echo set_value('name'); ?>" maxlength="100" minlength="3" tabindex="1">
                     </div>
                     <?php  if(form_error('name')){
                         echo "<span style='color:red'>".form_error('name')."</span>";
                     }
                     ?>
                     <div id="error_name"></div>
                 </div>
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-text">Mobile <span style="color: red">*</span> :</label>
                     <div class="uk-form-controls">
                         <input class="uk-input" type="text" name="mobile" id="mobile" value="<?php echo $mobile_no;?>" placeholder="9876543XXX" maxlength="10"   tabindex="3" readonly>
                     </div>
                     <?php  if(form_error('mobile')){
                         echo "<span style='color:red'>".form_error('mobile')."</span>";
                     }
                     if(!empty($this->session->flashdata('mobileExistMessage'))){
                         echo "<span style='color:red'>".$this->session->flashdata('mobileExistMessage')."</span>";
                     }
                     ?>
                     <div id="error_mobile"></div>
                 </div>
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-select">Relation <span style="color: red">*</span> :</label>
                     <div class="uk-form-controls">
                         <select class="uk-select" tabindex = '5' name="relation" id="relation"  >
                             <option value="">Select Relation</option>
                             <option value="S">Son Of</option>
                             <option value="D">Daughter Of</option>
                             <option value="W">Spouse Of</option>
                             <option value="N">Not Available</option>
                         </select>
                         <?php  if(form_error('ralation')){
                             echo "<span style='color:red'>".form_error('relation')."</span>";
                         }
                         ?>
                         <div id="error_relation"></div>
                     </div>
                 </div>
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-select">AOR <span style="color: red">*</span> :</label>
                     <div class="uk-form-controls">
                         <select class="uk-select"  tabindex = '5' name="aor" id="aor">
                             <option value="" >Select AOR</option>
                             <?php
                             if(isset($aorList) && !empty($aorList)){
                                 foreach($aorList as $k=>$v) {
                                     $name = '';
                                     if (isset($v['first_name']) && !empty($v['first_name']) && isset($v['last_name']) && !empty($v['last_name'])){
                                         $name .= $v['first_name'] . ' ' . $v['last_name'];
                                     }
                                     else  if(isset($v['first_name']) && !empty($v['first_name'])){
                                         $name .= $v['first_name'];
                                     }
                                     echo '<option value="'.$v['id'].'">'.$name.'</option>';
                                 }
                             }
                             ?>
                         </select>
                         <?php  if(form_error('aor')){
                             echo "<span style='color:red'>".form_error('aor')."</span>";
                         }
                         ?>
                         <div id="error_aor"></div>
                     </div>
                 </div>
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-text">Chamber Address :</label>
                     <div class="uk-form-controls">
                         <textarea class="uk-textarea" rows="2" name="c_address" id="c_address"  placeholder="Address" maxlength="250"  tabindex="7"><?php echo set_value('c_address');?></textarea>
                     </div>
                     <?php  if(form_error('c_address')){
                         echo "<span style='color:red'>".form_error('c_address')."</span>";
                     }
                     ?>
                     <div id="error_c_address"></div>
                 </div>
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-text">Pincode :</label>
                     <div class="uk-form-controls">
                         <input class="uk-input" type="text"  value="<?php echo set_value('c_pincode'); ?>" name="c_pincode" onkeyup="return isNumber(event)" id="c_pincode"  placeholder="Pincode" maxlength="6"   tabindex="8" />
                     </div>
                     <?php  if(form_error('c_pincode')){
                         echo "<span style='color:red'>".form_error('c_pincode')."</span>";
                     }
                     ?>
                     <div id="error_c_pincode"></div>
                 </div>
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-text">City :</label>
                     <div class="uk-form-controls">
                         <input class="uk-input" type="text" value="<?php echo set_value('c_city'); ?>" name="c_city" id="c_city"  placeholder="City" maxlength="25"  tabindex="9" />
                     </div>
                     <?php  if(form_error('c_city')){
                         echo "<span style='color:red'>".form_error('c_city')."</span>";
                     }
                     ?>
                     <div id="error_c_city"></div>
                 </div>
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-select">State :</label>
                     <div class="uk-form-controls">
                         <select class="uk-select" name="c_state"  id="c_state"   tabindex="10">
                             <option value="">Select State</option>
                             <?php
                             $stateArr = array();
                             if (isset($state_list) && !empty($state_list)){
                                 foreach ($state_list as $dataRes) {
                                     echo '<option value="'.url_encryption(trim($dataRes->cmis_state_id)).'">'.strtoupper($dataRes->agency_state).'</option>';
                                     $tempArr = array();
                                     $tempArr['id'] = url_encryption(trim($dataRes->cmis_state_id));
                                     $tempArr['state_name'] = strtoupper($dataRes->agency_state);
                                     $stateArr[] = (object)$tempArr;
                                 }
                             }
                             ?>
                         </select>
                         <?php  if(form_error('c_state')){
                             echo "<span style='color:red'>".form_error('c_state')."</span>";
                         }
                         ?>
                         <div id="error_c_state"></div>
                     </div>
                 </div>
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-select">District :</label>
                     <div class="uk-form-controls">
                         <select class="uk-select" name="c_district" id="c_district"  tabindex="11">
                             <option value="">Select District</option>
                         </select>
                         <?php  if(form_error('c_district')){
                             echo "<span style='color:red'>".form_error('c_district')."</span>";
                         }
                         ?>
                         <div id="error_c_district"></div>
                     </div>
                 </div>
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-text">Registration Bar Id Card <span style="color: red">*</span>Size: (<?php echo ((BAR_ID_CARD_SIZE/1024)/1024);?>MB) Type:(pdf/jpeg/jpg):</label>
                     <div class="uk-form-controls">
                         <input class="uk-input" type="file" accept=".pdf,.jpeg,.jpg" name="bar_id_card" id="bar_id_card"   tabindex="14" />
                     </div>
                     <?php  if(form_error('bar_id_card')){
                         echo "<span style='color:red'>".form_error('bar_id_card')."</span>";
                     }
                     if(!empty($this->session->flashdata('bar_id_card_error'))){
                         echo "<span style='color:red'>".$this->session->flashdata('bar_id_card_error')."</span>";
                     }
                     ?>
                     <div id="error_bar_id_card"></div>
                 </div>
             </div>
             <!-- left box end -->
             <!-- right box start -->
             <div class="uk-visible@m uk-first-column">
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-text">Email <span style="color: red">*</span> :</label>
                     <div class="uk-form-controls">
                         <input class="uk-input" type="email" name="email" id="email" value="<?php echo $email_id;?>" maxlength="100" placeholder="admin@gmail.com "  tabindex="2" readonly/>
                     </div>
                     <?php  if(form_error('email')){
                         echo "<span style='color:red'>".form_error('email')."</span>";
                     }
                     ?>
                     <div id="error_email"></div>
                 </div>
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-text">Bar Registration No. :</label>
                     <div class="uk-form-controls">
                         <?php
                         $readony = "";
                         if(isset($bar_reg_no) && !empty($bar_reg_no)){
                             $readony = "readonly";
                         }
                         ?>
                         <input class="uk-input" type="text" name="bar_reg_no"  value="<?php echo ($bar_reg_no) ?  $bar_reg_no : set_value('bar_reg_no');?>" id="bar_reg_no" maxlength="30" placeholder="abccd2314441"   tabindex="4" <?php echo $readony;?>/>
                     </div>
                     <?php  if(form_error('bar_reg_no')){
                         echo "<span style='color:red'>".form_error('bar_reg_no')."</span>";
                     }
                     ?>
                     <div id="error_bar_reg_no"></div>
                 </div>
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-text">Relative Name <span style="color: red">*</span>:</label>
                     <div class="uk-form-controls">
                         <input class="uk-input" type="text" value="<?php echo set_value('relation_name');?>"  name="relation_name" id="relation_name"  placeholder="Relative Name" maxlength="35" tabindex="6" />
                     </div>
                     <?php  if(form_error('relation_name')){
                         echo "<span style='color:red'>".form_error('relation_name')."</span>";
                     }
                     ?>
                     <div id="error_relation_name"></div>
                 </div>
                 <div class="uk-margin">
                     <label style="margin-top: 35px;margin-bottom: 9px;" class="uk-form-label"><input class="uk-checkbox" type="checkbox"  name="same_as" id="same_as"  tabindex="12" /> Same As Chamber Address :</label>
                 </div>
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-text">Residential Address :</label>
                     <div class="uk-form-controls">
                         <textarea class="uk-textarea" name="r_address" id="r_address"  placeholder="Address" maxlength="250" tabindex="13"><?php echo set_value('r_address');?> </textarea>
                     </div>
                     <?php  if(form_error('r_address')){
                         echo "<span style='color:red'>".form_error('r_address')."</span>";
                     }
                     ?>
                     <div id="error_r_address"></div>
                 </div>
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-text">Pincode :</label>
                     <div class="uk-form-controls">
                         <input class="uk-input" value="<?php echo set_value('r_pincode');?>" name="r_pincode" id="r_pincode"  placeholder="Pincode" maxlength="6"  tabindex="14" />
                     </div>
                     <?php  if(form_error('r_pincode')){
                         echo "<span style='color:red'>".form_error('r_pincode')."</span>";
                     }
                     ?>
                     <div id="error_r_pincode"></div>
                 </div>
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-text">City :</label>
                     <div class="uk-form-controls">
                         <input class="uk-input" value="<?php echo set_value('r_city');?>" name="r_city" id="r_city"  placeholder="City" maxlength="25" tabindex="15" />
                     </div>
                     <?php  if(form_error('r_city')){
                         echo "<span style='color:red'>".form_error('r_city')."</span>";
                     }
                     ?>
                     <div id="error_r_city"></div>
                 </div>
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-select">State :</label>
                     <div class="uk-form-controls">
                         <select class="uk-select" name="r_state"  id="r_state" tabindex="16">
                             <option value="">Select State</option>
                             <?php
                             if (isset($state_list) && !empty($state_list)){
                                 foreach ($state_list as $dataRes) {
                                     echo '<option value="'.url_encryption(trim($dataRes->cmis_state_id)).'">'.strtoupper($dataRes->agency_state).'</option>';
                                 }
                             }
                             ?>
                         </select>
                         <?php  if(form_error('r_state')){
                             echo "<span style='color:red'>".form_error('r_state')."</span>";
                         }
                         ?>
                         <div id="error_r_state"></div>
                     </div>
                 </div>
                 <div class="uk-margin">
                     <label class="uk-form-label" for="form-stacked-select">District :</label>
                     <div class="uk-form-controls">
                         <select class="uk-select" name="r_district" id="r_district"  tabindex="17">
                             <option>Select District</option>
                         </select>
                         <?php  if(form_error('r_district')){
                             echo "<span style='color:red'>".form_error('r_district')."</span>";
                         }
                         ?>
                         <div id="error_r_district"></div>
                     </div>
                 </div>

             </div>
             <!-- right box end -->
                 <div class="uk-margin" style="margin-left: auto;margin-right: auto;width: 130px;margin-bottom: 162px;">
                         <input type="submit" class="uk-button uk-button-primary" name="register" id="register" value="Register">
                 </div>
             <?php echo form_close(); ?>
         </div>

         <?php
    }
    if(isset($selfArguingCounselData) && !empty($selfArguingCounselData)){
        echo '<div class="x_content">
                        <h2 class="textwhite uk-margin-remove uk-visible@m ukwidth-expand">Advocate Approval/Rejected</h2>
                        <button class="uk-button-medium uk-button-primary actionType" id="rejected" style="float: right;">Rejected</button>
                        <button class="uk-button-medium uk-button-primary actionType" id="approved" style="float: right;margin-right: 8px;margin-bottom: 12px;">Approved</button>
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr class="success input-sm" role="row" >
                                <th>S.No.</th>
                                <th>Name</th>
                                <th>Mobile No.</th>
                                <th>Email</th>
                                <th>Bar Reg.No.</th>
                                <th><label class="control-label" for="selectAll"><input type="checkbox" name="selectAll" id="selectAll">
                                <span style="margin-left: 7px; font-size: 12px;" id="selectSpan">Select All</span></label></th>
                            </tr>
                            </thead>
                            <tbody>';
        $i = 1;
        foreach ($selfArguingCounselData as $value) {
            $first_name = !empty($value['first_name']) ? $value['first_name'] : '';
            $mobile = !empty($value['moblie_number']) ? $value['moblie_number'] : '';
            $email = !empty($value['emailid']) ? $value['emailid'] : '';
            $tbl_users_id = !empty($value['tbl_users_id']) ? $value['tbl_users_id'] : '';
            $bar_reg_no = !empty($value['bar_reg_no']) ? $value['bar_reg_no'] : '';
            echo '<tr>
                                    <td width="4%">'.$i.'</td>
                                    <td width="10%">'.$first_name.'</td>
                                    <td width="20%">'.$mobile.' </td>
                                    <td width="10%">'.$email.'</td>
                                    <td width="10%">'.$bar_reg_no.'</td>
                                    <td width="10%">
                                    <input type="checkbox" id="checkbox_'.$i.'" class="selectAllcheckBox" data-userId="'.$tbl_users_id.'"/></td>
                                </tr>';
            $i++;
        }
        echo '</tbody>
                        </table>
                    </div>';
    }
    ?>

</div>

<script>
    $(document).ready(function(){
        var state_Arr = '<?php echo json_encode($stateArr)?>';
        $(document).on('click','#add_arguing_counsel_submit',function(e){
            e.preventDefault();
            var nameRegPattern = /^[a-zA-Z‘_ ]+$/i;
            var emailPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            var mobilePattern = /^\d{10}$/;
            var alphanumPattern = /^[a-zA-Z0-9]+$/i;
            var validation = true;
            var name =  $.trim($("#name").val());
            var email =  $.trim($("#email").val());
            var mobile = $.trim($("#mobile").val());
            var bar_reg_no = $.trim($("#bar_reg_no").val());
            if(name == ''){
                $("#name").focus();
                $("#error_name").text("Please fill name.");
                $("#error_name").css({'color':'red'});
                alert("Please fill name.");
                validation = false;
                return false;
            }
            else if(!nameRegPattern.test(name)){
                $("#name").focus();
                $("#error_name").text("Please fill name only characters.");
                $("#error_name").css({'color':'red'});
                alert("Please fill name only characters.");
                validation = false;
                return false;
            }
            else if(name.length < 3 || name.length >100){
                $("#name").focus();
                $("#error_name").text("Please fill name between minimum 3 and maximum 100 characters.");
                $("#error_name").css({'color':'red'});
                alert("Please fill name between minimum 3 and maximum 100 characters.");
                validation = false;
                return false;
            }
            else if(email == ''){
                $("#email").focus();
                $("#error_email").text("Please fill email.");
                $("#error_email").css({'color':'red'});
                alert("Please fill email.");
                validation = false;
                return false;
            }
            else if(email && !emailPattern.test(email)){
                $("#email").focus();
                $("#error_email").text("Please fill valid  email");
                $("#error_email").css({'color':'red'});
                alert("Please fill valid email");
                validation = false;
                return false;
            }
            else if(mobile == ''){
                $("#mobile").focus();
                $("#error_mobile").text("Please fill mobile.");
                $("#error_mobile").css({'color':'red'});
                alert("Please fill mobile.");
                validation = false;
                return false;
            }
            else if(mobile && !mobilePattern.test(mobile)){
                $("#mobile").focus();
                $("#error_mobile").text("Please fill valid  mobile No.");
                $("#error_mobile").css({'color':'red'});
                alert("Please fill valid mobile No.");
                validation = false;
                return false;
            }
            else if(bar_reg_no && !alphanumPattern.test(bar_reg_no)){
                $("#bar_reg_no").focus();
                $("#error_bar_reg_no").text("Please fill valid  bar reg. no.");
                $("#error_bar_reg_no").css({'color':'red'});
                alert("Please fill valid bar reg no.");
                validation = false;
                return false;
            }
            else if(validation){
                $("#add_arguing_counsel").submit();
            }
        });
        $(document).on('click','#register',function(e){
            e.preventDefault();
            var nameRegPattern = /^[a-zA-Z‘_ ]+$/i;
            var emailPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            var mobilePattern = /^\d{10}$/;
            var pincodePattern = /^\d{6}$/;
            var alphanumPattern = /^[a-zA-Z0-9 ]+$/i;
            var addressPattern = /^[a-zA-Z0-9\s,'-.]*$/i;
            var validation = true;
            var name =  $.trim($("#name").val());
            var email =  $.trim($("#email").val());
            var mobile = $.trim($("#mobile").val());
            var bar_reg_no = $.trim($("#bar_reg_no").val());
            var bar_id_card =  $("#bar_id_card").val();
            var fileReg = /(.*?)\.(pdf|jpeg|jpg)$/;
            var relation = $("#relation option:selected").val();
            var relation_name = $("#relation_name").val();
            var bar_card_size = "<?php echo BAR_ID_CARD_SIZE;?>";
            var c_address = $.trim($("textarea#c_address").val());
            var r_address = $.trim($("textarea#r_address").val());
            var c_pincode = $("#c_pincode").val();
            var c_city = $("#c_city").val();
            var c_state = $("#c_state option:selected").val();
            var c_district = $("#c_district").val();
            var r_pincode = $("#r_pincode").val();
            var r_city = $("#r_city").val();
            var r_state = $("#r_state option:selected").val();
            var r_district = $("#r_district").val();
            var bar_id_card_size ='';
          //  $("#r_district").prop('disabled', false);
           // $("#r_state").prop('disabled', false);
            if(bar_id_card){
                bar_id_card_size =  document.getElementById('bar_id_card').files[0]['size'];
            }
            if(name == ''){
                $("#name").focus();
                $("#error_name").text("Please fill name.");
                $("#error_name").css({'color':'red'});
                alert("Please fill name.");
                validation = false;
                return false;
            }
            else if(!nameRegPattern.test(name)){
                $("#name").focus();
                $("#error_name").text("Please fill name only characters.");
                $("#error_name").css({'color':'red'});
                alert("Please fill name only characters.");
                validation = false;
                return false;
            }
            else if(name.length < 3 || name.length >100){
                $("#name").focus();
                $("#error_name").text("Please fill name between minimum 3 and maximum 100 characters.");
                $("#error_name").css({'color':'red'});
                alert("Please fill name between minimum 3 and maximum 100 characters.");
                validation = false;
                return false;
            }
            else if(email == ''){
                $("#email").focus();
                $("#error_email").text("Please fill email.");
                $("#error_email").css({'color':'red'});
                alert("Please fill email.");
                validation = false;
                return false;
            }
            else if(email && !emailPattern.test(email)){
                $("#email").focus();
                $("#error_email").text("Please fill valid  email");
                $("#error_email").css({'color':'red'});
                alert("Please fill valid email");
                validation = false;
                return false;
            }
            else if(mobile == ''){
                $("#mobile").focus();
                $("#error_mobile").text("Please fill mobile.");
                $("#error_mobile").css({'color':'red'});
                alert("Please fill mobile.");
                validation = false;
                return false;
            }
            else if(mobile && !mobilePattern.test(mobile)){
                $("#mobile").focus();
                $("#error_mobile").text("Please fill valid  mobile No.");
                $("#error_mobile").css({'color':'red'});
                alert("Please fill valid mobile No.");
                validation = false;
                return false;
            }
            else if(bar_reg_no && !alphanumPattern.test(bar_reg_no)){
                $("#bar_reg_no").focus();
                $("#error_bar_reg_no").text("Please fill valid  bar reg. no.");
                $("#error_bar_reg_no").css({'color':'red'});
                alert("Please fill valid bar reg no.");
                validation = false;
                return false;
            }
            else if(relation == ''){
                $("#relation").focus();
                $("#error_relation").text("Please select relation.");
                $("#error_relation").css({'color':'red'});
                alert("Please select relation.");
                validation = false;
                return false;
            }
            else if(relation_name == ''){
                $("#relation_name").focus();
                $("#error_relation_name").text("Please fill relative name.");
                $("#error_relation_name").css({'color':'red'});
                alert("Please fill relative name.");
                validation = false;
                return false;
            }
            else if(relation_name && !nameRegPattern.test(relation_name)){
                $("#relation_name").focus();
                $("#error_relation_name").text("Please fill relative name only characters.");
                $("#error_relation_name").css({'color':'red'});
                alert("Please fill relative name only characters.");
                validation = false;
                return false;
            }
            else if($("#aor").length >0 && $("#aor option:selected").val() == ''){
                    $("#aor").focus();
                    $("#error_aor").text("Please fill aor name.");
                    $("#error_aor").css({'color': 'red'});
                    alert("Please fill aor name.");
                    validation = false;
                    return false;
            }
            else if(c_address == '' && r_address == ''){
                $("#c_address").focus();
                $("#error_c_addresse").text("Please fill at least one address.");
                $("#error_c_addresse").css({'color':'red'});
                alert("Please fill at least one address.");
                validation = false;
                return false;
            }
            else if(c_address && !addressPattern.test(c_address)){
                $("#c_address").focus();
                $("#error_c_address").text("Please fill address alphanumeric with space and comma.");
                $("#error_c_address").css({'color':'red'});
                alert("Please fill address alphanumeric with space and comma.");
                validation = false;
                return false;
            }
            else if(c_address && c_pincode == ''){
                $("#c_pincode").focus();
                $("#error_c_pincode").text("Please fill pincode.");
                $("#error_c_pincode").css({'color':'red'});
                alert("Please fill pincode.");
                validation = false;
                return false;
            }
            else if(c_address && !pincodePattern.test(c_pincode)){
                $("#c_pincode").focus();
                $("#error_c_pincode").text("Please fill pincode numeric.");
                $("#error_c_pincode").css({'color':'red'});
                alert("Please fill pincode numeric.");
                validation = false;
                return false;
            }
            else if(c_address && c_city == ''){
                $("#c_city").focus();
                $("#error_c_city").text("Please fill city.");
                $("#error_cc_city").css({'color':'red'});
                alert("Please fill city.");
                validation = false;
                return false;
            }
            else if(c_address && !alphanumPattern.test(c_city)){
                $("#c_city").focus();
                $("#error_c_city").text("Please fill city alphanumeric.");
                $("#error_cc_city").css({'color':'red'});
                alert("Please fill city alphanumeric.");
                validation = false;
                return false;
            }
            else if(c_address && c_state == ''){
                $("#c_state").focus();
                $("#error_c_state").text("Please select state.");
                $("#error_c_state").css({'color':'red'});
                alert("Please select state.");
                validation = false;
                return false;
            }
            else if(c_address && c_district == ''){
                $("#c_district").focus();
                $("#error_c_district").text("Please select district.");
                $("#error_c_district").css({'color':'red'});
                alert("Please select district.");
                validation = false;
                return false;
            }
            else if(r_address && !addressPattern.test(r_address)){
                $("#r_address").focus();
                $("#error_r_address").text("Please fill address alphanumeric with space dot comma.");
                $("#error_r_address").css({'color':'red'});
                alert("Please fill address alphanumeric with space dot comma.");
                validation = false;
                return false;
            }
            else if(r_address && r_pincode == ''){
                $("#r_pincode").focus();
                $("#error_r_pincode").text("Please fill pincode.");
                $("#error_r_pincode").css({'color':'red'});
                alert("Please fill pincode.");
                validation = false;
                return false;
            }
            else if(r_address && !pincodePattern.test(r_pincode)){
                $("#r_pincode").focus();
                $("#error_r_pincode").text("Please fill pincode numeric.");
                $("#error_r_pincode").css({'color':'red'});
                alert("Please fill pincode numeric.");
                validation = false;
                return false;
            }
            else if(r_address && r_city == ''){
                $("#r_city").focus();
                $("#error_r_city").text("Please fill city.");
                $("#error_r_city").css({'color':'red'});
                alert("Please fill city.");
                validation = false;
                return false;
            }
            else if(r_address && !alphanumPattern.test(r_city)){
                $("#r_city").focus();
                $("#error_r_city").text("Please fill city alphanumric.");
                $("#error_r_city").css({'color':'red'});
                alert("Please fill city alphanumric.");
                validation = false;
                return false;
            }
            else if(r_address && r_state == ''){
                $("#r_state").focus();
                $("#error_r_state").text("Please select state.");
                $("#error_r_state").css({'color':'red'});
                alert("Please select state.");
                validation = false;
                return false;
            }
            else if(r_district && r_district == ''){
                $("#r_district").focus();
                $("#error_r_district").text("Please select district.");
                $("#error_r_district").css({'color':'red'});
                alert("Please select district.");
                validation = false;
                return false;
            }
            else  if(bar_id_card == ''){
                $("#bar_id_card").focus();
                $("#error_bar_id_card").text("Please select bar registration id card.");
                $("#error_bar_id_card").css({'color':'red'});
                alert("Please select bar registration id card.");
                validation = false;
                return false;
            }
            else if(!fileReg.test(bar_id_card)){
                $("#bar_id_card").focus();
                $("#error_bar_id_card").text("Please select bar registration id card type(pdf/jpeg)");
                $("#error_bar_id_card").css({'color':'red'});
                alert("Please select bar registration id card type(pdf/jpeg)");
                validation = false;
                return false;
            }
            else if(bar_id_card_size > bar_card_size){
                var filesizeMb = ((bar_card_size)/1024)/1024;
                $("#bar_id_card").focus();
                $("#error_bar_id_card").text("Please select bar registration id card less than "+filesizeMb +"MB");
                $("#error_bar_id_card").css({'color':'red'});
                alert("Please select bar registration id card less than "+filesizeMb+"MB");
                validation = false;
                return false;
            }
            else if(validation){
                $("#saveArguingCounselCompleteDetails").submit();
            }
        });
        $('input[name="same_as"]').click(function(){
            if($(this).is(":checked")){
                var c_address = $("#c_address").val();
                var c_pincode = $("#c_pincode").val();
                var c_city = $("#c_city").val();
                var c_state = $("#c_state option:selected").val();
                var c_district = $("#c_district").val();
                if(c_address && c_pincode &&  c_city && c_state && c_district){
                    $("#r_address").val(c_address);
                    $("#r_address").prop('readonly', true);
                    $("#r_pincode").val(c_pincode).trigger( 'blur' );
                    $("#r_pincode").prop('readonly', true);
                    $("#r_city").prop('readonly', true);
                    $("#r_state").prop('readonly', true);
                    setTimeout(function(){
                            if($("#r_district").val()){
                                $("#r_district").prop('readonly', true);
                            }
                            else{
                                $("#r_district").val($("#c_district").val());
                                $("#r_district").prop('readonly', true);
                            }
                    }
                     ,1000);
                }
                else{
                    $('#same_as').prop('checked', false);
                    alert("Please fill all fields of chamber address.");
                }
            }
            else if($(this).is(":not(:checked)")){
                $("#r_address").val('');
                $("#r_address").prop('readonly', false);
                $("#r_pincode").val('');
                $("#r_pincode").prop('readonly', false);
                $("#r_city").val('');
                $("#r_city").prop('readonly', false);
                $("#r_state").val('');
                $("#r_state").prop('readonly', false);
                $("#r_district").val('');
                $("#r_district").prop('readonly', false);
            }
        });
        $(document).on('change','#c_state',function() {
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $('#c_district').val('');
            var get_state_id = $(this).val();
            $.ajax({
                type: "POST",
                data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, state_id: get_state_id},
                url: "<?php echo base_url('newcase/Ajaxcalls/get_districts'); ?>",
                success: function (data)
                {
                    $('#c_district').html(data);
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
        $(document).on('change','#r_state',function() {
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $('#r_district').val('');
            var get_state_id = $(this).val();
            $.ajax({
                type: "POST",
                data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, state_id: get_state_id},
                url: "<?php echo base_url('newcase/Ajaxcalls/get_districts'); ?>",
                success: function (data)
                {
                    $('#r_district').html(data);
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
        $('#c_pincode').blur(function(){
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            var pincode = $("#c_pincode").val();
            if(pincode){
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
                                $("#c_city").val('');
                                $("#c_city").val(taluk_name);
                            }
                            else{
                                $("#c_city").val('');
                            }
                            if(state){
                                if(state_Arr){
                                    var stateObj = JSON.parse(state_Arr);
                                }
                                if(stateObj){
                                    var singleObj = stateObj.find(
                                        item => item['state_name'] === state
                                    );
                                }
                                if(singleObj){
                                    $('#c_state').val('');
                                   // $('#c_state').val(singleObj.id).select2().trigger("change");
                                    $('#c_state').val(singleObj.id);
                                }
                                else{
                                    $('#c_state').val('');
                                }
                                if(district_name){
                                    var stateId = $('#c_state').val();
                                    setDistrictUser(stateId,district_name);
                                }
                            }
                            else{
                                $('#c_state').val('');
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
        $('#r_pincode').blur(function(){
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            var pincode = $("#r_pincode").val();
            if(pincode){
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
                                $("#r_city").val('');
                                $("#r_city").val(taluk_name);
                            }
                            else{
                                $("#r_city").val('');
                            }
                            if(state){
                                if(state_Arr){
                                    var stateObj = JSON.parse(state_Arr);
                                }
                                if(stateObj){
                                    var singleObj = stateObj.find(
                                        item => item['state_name'] === state
                                    );
                                }
                                if(singleObj){
                                    $('#r_state').val('');
                                    // $('#r_state').val(singleObj.id).select2().trigger("change");
                                    $('#r_state').val(singleObj.id);
                                }
                                else{
                                    $('#r_state').val('');
                                }
                                if(district_name){
                                    var stateId = $('#r_state').val();
                                    setDistrictUser1(stateId,district_name);
                                }
                            }
                            else{
                                $('#r_state').val('');
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
        $(document).on('click','#selectAll',function (){
            $('.selectAllcheckBox').each(function (index, obj) {
                if (this.checked === true) {
                    $(this).attr('checked',false);
                    $("#selectSpan").text("Select All");
                }
                else{
                    $(this).attr('checked',true);
                    $("#selectSpan").text("Deselect All");
                }
            });

        });
        $(document).on('click','.actionType',function(){
            var type = $.trim($(this).attr('id'));
            var userIdArr = [];
            $('.selectAllcheckBox').each(function (index, obj) {
                if(this.checked === true){
                    userIdArr.push($(this).attr('data-userid'));
                }
            });
            if(userIdArr.length === 0){
                alert("Please select checkbox.");
                $("#checkbox_1").focus();
                $("#checkbox_1").css({'border-color':'red'});
                return false;
            }
            else if(confirm("Are you sure to advocate "+type+ ' ?' )== true) {
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                //var postData = {CSRF_TOKEN: CSRF_TOKEN_VALUE,userIdArr:userIdArr,type:type };
                $.ajax({
                    type: "POST",
                    //data: JSON.stringify(postData),
                    data: {CSRF_TOKEN: CSRF_TOKEN_VALUE,userIdArr:userIdArr,type:type},
                    url: "<?php echo base_url('register/ArguingCounsel/approveRejectedArguingCounsel'); ?>",
                    //async:false,
                    //cache:false,
                    //dataType:'json',
                    //ContentType: 'application/json',
                    success: function(res)
                    {
                        if(res && typeof res == 'string'){
                            res = JSON.parse(res);
                        }
                        if(res.success = 'success'){
                            alert(res.message);
                            window.location.reload();
                        }
                        else  if(res.error = 'error'){
                            alert(res.message);
                            window.location.reload();
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


    });

    function setDistrictUser(stateId,district_name){
        if(stateId && district_name){
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $.ajax({
                type: "POST",
                data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, state_id: stateId},
                url: "<?php echo base_url('newcase/Ajaxcalls/getSelectedDistricts'); ?>",
                success: function (resData)
                {
                    if(resData){
                        var districtObj = JSON.parse(resData);
                        var singleObj = districtObj.find(
                            item => item['district_name'] === district_name
                        );
                        var dist ='<option value="">Select District</option>';
                        districtObj.forEach(function(ele){
                            dist +='<option value="'+ele.id+'">'+ele.district_name+'</option>';
                        });
                        $('#c_district').html(dist);
                        if(singleObj){
                           // $('#c_district').val('');
                            // $('#c_district').val(singleObj.id).select2().trigger("change");
                            $('#c_district').val(singleObj.id);
                        }
                        else{
                            $('#c_district').val('');
                        }
                    }
                    else{
                        $('#c_district').val('');
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
    }
    function setDistrictUser1(stateId,district_name){
        if(stateId && district_name){
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $.ajax({
                type: "POST",
                data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, state_id: stateId},
                url: "<?php echo base_url('newcase/Ajaxcalls/getSelectedDistricts'); ?>",
                success: function (resData)
                {
                    if(resData){
                        var districtObj = JSON.parse(resData);
                        var singleObj = districtObj.find(
                            item => item['district_name'] === district_name
                        );
                        var dist ='<option value="">Select District</option>';
                        districtObj.forEach(function(ele){
                            dist +='<option value="'+ele.id+'">'+ele.district_name+'</option>';
                        });
                        $('#r_district').html(dist);
                        if(singleObj){
                            // $('#c_district').val('');
                            // $('#c_district').val(singleObj.id).select2().trigger("change");
                            $('#r_district').val(singleObj.id);
                        }
                        else{
                            $('#r_district').val('');
                        }
                    }
                    else{
                        $('#r_district').val('');
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
    }
    function isNumber(evt){
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

</script>


@endsection