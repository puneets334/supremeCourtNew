<?php
    $ref_m_usertype_id = !empty($_SESSION['login']['ref_m_usertype_id']) ? $_SESSION['login']['ref_m_usertype_id'] : NULL;
    $stage_id = !empty($_SESSION['efiling_details']['stage_id']) ? $_SESSION['efiling_details']['stage_id'] : NULL;
    $filing_type = !empty($_SESSION['efiling_details']['efiling_type']) ? $_SESSION['efiling_details']['efiling_type'] : NULL;
    $collapse_class = 'collapse';
    $area_extended = false;
    $diary_generate_button ='';
    if(isset($ref_m_usertype_id) && !empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && isset($stage_id) && !empty($stage_id) && $stage_id == Transfer_to_IB_Stage){
        $collapse_class = 'collapse in';
        $area_extended = true;
//        $diary_generate_button = '<div class="row"><a  data-toggle="modal" href="#generateDiaryNo" data-target="#generateDiaryNoDiv" class="btn btn-primary" id="generateDiaryNoPop" type="button" style="float: right;margin-right: 12px;">Generate Caveat No.</a></div>';
        $diary_generate_button = '<div class="row"><a  href="javascript:void(0)"class="btn btn-primary"  data-efilingtype="caveat" id="generateDiaryNoPop" type="button" style="float: right;margin-right: 12px;">Generate Caveat No.</a></div>';
    }
    //echo '<pre>'; print_r($_SESSION); exit;

    if (isset($_SESSION['efiling_for_details']['case_type_pet_title']) && !empty($_SESSION['efiling_for_details']['case_type_pet_title'])) {
        $case_type_pet_title = htmlentities($_SESSION['efiling_for_details']['case_type_pet_title'], ENT_QUOTES);
    } elseif (isset($efiling_civil_data[0]['case_type_pet_title']) && !empty($efiling_civil_data[0]['case_type_pet_title'])) {
        $case_type_pet_title = htmlentities($efiling_civil_data[0]['case_type_pet_title'], ENT_QUOTES);
    } else {
        $case_type_pet_title = htmlentities('Caveator', ENT_QUOTES);
    }


    if (isset($_SESSION['efiling_for_details']['case_type_res_title']) && !empty($_SESSION['efiling_for_details']['case_type_res_title'])) {
        $case_type_res_title = htmlentities($_SESSION['efiling_for_details']['case_type_res_title'], ENT_QUOTES);
    } elseif (isset($efiling_civil_data[0]['case_type_res_title']) && !empty($efiling_civil_data[0]['case_type_res_title'])) {
        $case_type_res_title = htmlentities($efiling_civil_data[0]['case_type_res_title'], ENT_QUOTES);
    } else {
        $case_type_res_title = htmlentities('Caveatee', ENT_QUOTES);
    }


    if ($_SESSION['breadcrumb_enable']['efiling_type'] == E_FILING_TYPE_CDE) {
        $lbl_efiling_for = 'CDE For : ';
        $lbl_efiling_details_head = 'Case Data Entry Details';
        $lbl_efiled_by = 'CDE By : ';
        $lbl_efiled_on = 'CDE On : ';
    } else {
        $lbl_efiling_for = 'eFiling For : ';
        $lbl_efiling_details_head = 'eFiling Details';
        $lbl_efiled_by = 'eFiled By : ';
        $lbl_efiled_on = 'eFiled On : ';
    }
    $font_color = '#4721c4';

    if (!empty($reg_id)) {
        echo " <script> $('#acknow').css('display', 'none'); </script>";
    } else {
        echo " <script> $('#acknow').css('display', 'block'); </script>";
    }

    if (in_array($_SESSION['login']['ref_m_usertype_id'], array(USER_ADVOCATE, USER_IN_PERSON, USER_CLERK))) {
        $display_edit = 'style="display:block"';
    } else {
        $display_edit = 'style="display:none"';
    }
    //XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
    $stages_array = array('', Draft_Stage, Initial_Defected_Stage,  E_REJECTED_STAGE);
    if (!in_array($_SESSION['efiling_details']['stage_id'], $stages_array)) {
        $hidepencilbtn='true';
    }else{
        $hidepencilbtn='false';
    }


    //XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX





    if(in_array(CAVEAT_BREAD_VIEW, explode(',', $_SESSION['efiling_details']['breadcrumb_status']))) {
        if (!empty($this->session->userdata('caveat_msg'))) {
            echo '<div class="alert alert-success text-center" id="caveat_messsage"> E-filing number ' . efile_preview($_SESSION['efiling_details']['efiling_no']) . ' submitted successfully for approval of E-filing Admin.!</div>';
        }
    }
    $caveator_name ='';
    $caveatee_name ='';

    $caveator_details ='';
    $caveatee_details ='';
if(isset($efiling_civil_data[0]['orgid']) && !empty($efiling_civil_data[0]['orgid']) && $efiling_civil_data[0]['orgid'] != 'I'){
    $org_dept_name=!empty($efiling_civil_data[0]['org_dept_name'])? '<br/>Department Name : '.$efiling_civil_data[0]['org_dept_name'].'<br/>':'';
    $org_post_name=!empty($efiling_civil_data[0]['org_post_name'])? 'Post Name : '.$efiling_civil_data[0]['org_post_name'].'<br/>':'';
    $org_state_name=!empty($efiling_civil_data[0]['org_state_name'])? 'State Name : '.$efiling_civil_data[0]['org_state_name']:'';
    $caveator_details =$org_dept_name.$org_post_name.$org_state_name;
}

if(isset($efiling_civil_data[0]['resorgid']) && !empty($efiling_civil_data[0]['resorgid']) && $efiling_civil_data[0]['resorgid'] != 'I'){
    $res_org_dept_name=!empty($efiling_civil_data[0]['res_org_dept_name'])? '<br/>Department Name : '.$efiling_civil_data[0]['res_org_dept_name'].'<br/>':'';
    $res_org_post_name=!empty($efiling_civil_data[0]['res_org_post_name'])? 'Post Name : '.$efiling_civil_data[0]['res_org_post_name'].'<br/>':'';
    $res_org_state_name=!empty($efiling_civil_data[0]['res_org_state_name'])? 'State Name : '.$efiling_civil_data[0]['res_org_state_name']:'';
    $caveatee_details =$res_org_dept_name.$res_org_post_name.$res_org_state_name;
}
    if(isset($efiling_civil_data[0]['pet_name']) && !empty($efiling_civil_data[0]['pet_name'])){
        //$caveator_name ='Caveator is : Individual <br/>Caveator Name : '.$efiling_civil_data[0]['pet_name'];
        $caveator_name =$efiling_civil_data[0]['pet_name'];
    }
    else if(isset($efiling_civil_data[0]['orgid']) && !empty($efiling_civil_data[0]['orgid']) && $efiling_civil_data[0]['orgid'] == 'D1'){
        $caveator_name = 'State Department';
    }
    else if(isset($efiling_civil_data[0]['orgid']) && !empty($efiling_civil_data[0]['orgid']) && $efiling_civil_data[0]['orgid'] == 'D2'){
        $caveator_name = 'Central Department';
    }
    else if(isset($efiling_civil_data[0]['orgid']) && !empty($efiling_civil_data[0]['orgid']) && $efiling_civil_data[0]['orgid'] == 'D3'){
        $caveator_name = 'Other Organisation';
    }
    if(isset($efiling_civil_data[0]['res_name']) && !empty($efiling_civil_data[0]['res_name'])){
        $caveatee_name =$efiling_civil_data[0]['res_name'];
    }
    else if(isset($efiling_civil_data[0]['resorgid']) && !empty($efiling_civil_data[0]['resorgid']) && $efiling_civil_data[0]['resorgid'] == 'D1'){
        $caveatee_name = 'State Department';
    }
    else if(isset($efiling_civil_data[0]['resorgid']) && !empty($efiling_civil_data[0]['resorgid']) && $efiling_civil_data[0]['resorgid'] == 'D2'){
        $caveatee_name = 'Central Department';
    }
    else if(isset($efiling_civil_data[0]['resorgid']) && !empty($efiling_civil_data[0]['resorgid']) && $efiling_civil_data[0]['resorgid'] == 'D3'){
        $caveatee_name = 'Other Organisation';
    }
    $caveat_no ='';
    if(isset($efiling_civil_data[0]['caveat_num']) && !empty($efiling_civil_data[0]['caveat_num'])
        && isset($efiling_civil_data[0]['caveat_year']) && !empty($efiling_civil_data[0]['caveat_year'])){
        $caveat_no = $efiling_civil_data[0]['caveat_num']. ' / '.$efiling_civil_data[0]['caveat_year'];
    }
?>
<div class="col-md-12 col-sm-12 col-xs-12">    
    <div class="clearfix"></div>
    <?php
   // $caveat_no ='';
    if(isset($diary_generate_button) && !empty($diary_generate_button) && empty($caveat_no)){
        echo $diary_generate_button;
    }
    ?>
    <div class="list-group-item" style="background: #EDEDED; padding: 8px 6px 28px 10px; color: #555;" data-toggle="collapse" data-parent="#MainMenu">
        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-6"> 
            <b><?php echo $lbl_efiling_details_head; ?></b>
        </div>

        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-5 text-right ">
            <div id="acknow">
                <?php
                if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADVOCATE || $_SESSION['login']['ref_m_usertype_id'] == USER_IN_PERSON || $_SESSION['login']['ref_m_usertype_id'] == USER_PDE) {
                    if ($_SESSION['efiling_details']['stage_id'] != Draft_Stage && $_SESSION['breadcrumb_enable']['efiling_type'] != E_FILING_TYPE_CDE) {
                        ?>
                   <!--     <button onclick="window.open('<?php // echo base_url('acknowledgement'); ?>')" id="myButton" class="btn btn-success btn-xs"><i class="fa fa-download blink"></i> Acknowledgement  </button> -->
                        <?php
                    }
                    ?>
                    <!--   <button onclick="window.open('<?php // echo base_url('case_parties'); ?>')" id="myButton" class="btn btn-dark btn-xs"><i class="fa fa-download blink"></i> Case Parties </button>
                    <button onclick="window.open('<?php // echo base_url('caveat/view/doc'); ?>')" id="myButton" class="btn btn-info btn-xs"><i class="fa fa-download blink"></i> DOC </button>-->
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 visible-lg visible-md" style="width: 22%;">
            <button class="btn btn-primary btn-xs openall" style="float: right">Expand All <i class="fa fa-eye"></i></button>
            <button class="btn btn-info btn-xs closeall hidden" style="float: right">Collapse All <i class="fa fa-eye-slash"></i></button> 
        </div>

        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1" style="width: 3%;">
            <a href="#demo_1" class="list-group-item1" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu">
                <i class="fa fa-minus" style="float: right;"></i> <b> </a>
        </div>
    </div>  
    <div class="collapse in" id="demo_1">
        <div class="panel panel-default panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 text-right" for="cnr"> <?php echo $lbl_efiling_for; ?></label>
                            <div class="col-md-8">
                                <p> <?php echo 'Caveat'; ?></div></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 text-right" for="cnr">eFiling No.:</label>
                            <div class="col-md-8">
                                <p> <?php echo htmlentities(efile_preview($_SESSION['efiling_details']['efiling_no']), ENT_QUOTES); ?></p>
                            </div>
                        </div> 
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 text-right" for="petitioner">Caveator :</label>
                            <div class="col-md-8">
                                <p>  <?php echo htmlentities($caveator_name, ENT_QUOTES); ?></p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 text-right" for="respondent_name">Caveatee :</label>
                            <div class="col-md-8">
                                <p>  <?php echo htmlentities($caveatee_name, ENT_QUOTES); ?></p>
                            </div>
                        </div> 
                    </div>
                    <?php
                    if(isset($filedByData) && !empty($filedByData)) {
                        $filedBy = '';
                        $name = !empty($filedByData['name']) ? $filedByData['name'] : '';
                        if (isset($filedByData['pp']) && !empty($filedByData['pp']) && $ref_m_usertype_id==USER_IN_PERSON) {
                            $filedBy = $name . ' ( Party In Person )';
                        } else {
                            $aor_code = !empty($filedByData['aor_code']) ? $filedByData['aor_code'] : '';
                            $filedBy = $name . ' (AOR- ' . $aor_code . ')';
                        }
                        echo '<div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4 text-right" for="filed_by">Filed By: </label>
                                            <div class="col-md-8">
                                                <p>' . $filedBy . '</p>
                                            </div>
                                        </div>
                                    </div>';
                    }
                    if(isset($caveat_no) && !empty($caveat_no)){
                        echo '<div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4 text-right" for="caveat_no">Caveat No. :</label>
                            <div class="col-md-8">
                                <p>'.$caveat_no.'</p>
                            </div>
                        </div>
                    </div>';
                    }
                    ?>

                    <div class="clearfix"></div>

                    <?php if (!($_SESSION['efiling_details']['stage_id'] == Draft_Stage)) { ?>
                        <div class="col-md-12"><hr>
<!--                            <div class="col-md-6">-->
<!--                                <div class="form-group">-->
<!--                                    <label class="control-label col-md-4 text-right"  for="reg_date">e-Filed By :</label>-->
<!--                                    <div class="col-md-8">-->
<!--                                        --><?php //$usertype_id = ($efiled_efiling_details[0]->ref_m_usertype_id == USER_ADVOCATE) ? 'Advocate' : 'Party-in-person'; ?>
<!--                                        <p  style="color :--><?php //echo $font_color; ?><!--">  --><?php
//                                            echo htmlentities(strtoupper($efiled_efiling_details[0]->first_name . ' ' . $efiled_efiling_details[0]->last_name), ENT_QUOTES);
//                                            if (!empty($efiled_efiling_details[0]->first_name)) {
//                                                echo ' ( ' . htmlentities($usertype_id, ENT_QUOTES) . ')';
//                                            }
//                                            ?><!--</p>-->
<!--                                    </div>-->
<!--                                </div> -->
<!--                            </div>-->
<!--                            <div class="col-md-6">-->
<!--                                <div class="form-group">-->
<!--                                    <label class="control-label col-md-4 text-right"  for="reg_date">e-Filed Date :</label>-->
<!--                                    <div class="col-md-8">-->
<!--                                        <p style="color :--><?php //echo $font_color; ?><!--">  --><?php //echo $efiled_efiling_details[0]->activated_on ? htmlentities(date('d-m-Y h:i:s A', strtotime($efiled_efiling_details[0]->activated_on)), ENT_QUOTES) : ''; ?><!--</p>-->
<!--                                    </div>-->
<!--                                </div> -->
<!--                            </div>-->
                        </div>
                        <?php if ($efiled_efiling_details[0]->admin_name != ' ' && !empty($efiled_efiling_details[0]->admin_name)) { ?>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 text-right" for="reg_date">Allocated To :</label>
                                        <div class="col-md-8">
                                            <p style="color :<?php echo $font_color; ?>"> <?php echo htmlentities($efiled_efiling_details[0]->admin_name, ENT_QUOTES) ?></p>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    $filing_type = !empty($_SESSION['efiling_details']['efiling_type']) ? $_SESSION['efiling_details']['efiling_type'] : NULL;
    $this->load->view('modals',array('filing_type'=>$filing_type));
    ?>
    <a href="#demo_2" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" <?php echo $area_extended;?> data-parent="#MainMenu">
<!--        <i class="fa fa-plus" style="float: right;"></i>-->
    <?php
        if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && !empty($stage_id) && $stage_id == Transfer_to_IB_Stage)
        {
            echo '<i class="fa fa-minus" style="float: right;"></i>';
        }
       else if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADVOCATE){
            echo '<i class="fa fa-plus" style="float: right;"></i>';
        }
        else {
            echo '<i class="fa fa-plus" style="float: right;"></i>';
        }
    ?>
        <b><?php echo ucwords(strtolower($case_type_pet_title)); ?></b></a>
    <div class="<?php echo $collapse_class;?>" id="demo_2">
        <div class="x_panel">
            <div class="table-responsive">
                <?php
                if($hidepencilbtn!='true'){ ?>
                <div <?php echo $display_edit; ?> class="text-right"><a href="<?php echo base_url('caveat'); ?>"><i class="fa fa-pencil efiling_search"></i></a></div>
                <?php } ?>
                <table id="caveator_table" class="table dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <th>#</th>
                    <th>Type</th>
                    <th>Caveator Name</th>
                    <th>Age/D.O.B</th>
                    <th>Gender</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <?php
                    if($hidepencilbtn!='true'){ ?>
                        <th class="efiling_search">Action</th>
                    <?php } ?>

                    </thead>
                    <tbody>
                        <?php
                        if ($efiling_civil_data[0]['pet_sex'] == 'M') {
                            $gender = 'Male';
                        } elseif ($efiling_civil_data[0]['pet_sex'] == 'F') {
                            $gender = 'Female';
                        } elseif ($efiling_civil_data[0]['pet_sex'] == 'O') {
                            $gender = 'Other';
                        } else {
                            $gender = '';
                        }
                        if ($efiling_civil_data[0]['res_sex'] == 'M') {
                            $res_gender = 'Male';
                        } elseif ($efiling_civil_data[0]['res_sex'] == 'F') {
                            $res_gender = 'Female';
                        } elseif ($efiling_civil_data[0]['res_sex'] == 'O') {
                            $res_gender = 'Other';
                        } else {
                            $res_gender = '';
                        }
                        if ($efiling_civil_data[0]['pet_age'] == 0) {
                            $pet_age = '';
                        } else {
                            $pet_age = $efiling_civil_data[0]['pet_age'];
                        }

                        if ($efiling_civil_data[0]['res_age'] == 0) {
                            $res_age = '';
                        } else {
                            $res_age = $efiling_civil_data[0]['res_age'];
                        }
                        $pet_address = strtoupper($efiling_civil_data[0]['petadd']);
                        if (isset($efiling_civil_data[0]['pet_pincode']) && !empty($efiling_civil_data[0]['pet_pincode'])) {
                            $pet_address .= ' - ' . $efiling_civil_data[0]['pet_pincode'];
                        }
                        $pet_age='';
                        if (!empty($efiling_civil_data[0]['pet_age'])){$pet_age=$efiling_civil_data[0]['pet_age'].'Yrs /' ;}
                        $pet_dob=!empty($efiling_civil_data[0]['pet_dob']) ? $pet_age.date('d-m-Y',strtotime($efiling_civil_data[0]['pet_dob'])):$pet_age;
                            echo '<tr>
                                <td>1</td>
                                <td>'.strtoupper($case_type_pet_title).'</td>
                                <td>'.strtoupper('Caveator Party :'.$caveator_name.$caveator_details).'</td>
                                <td>'.$pet_dob.'</td>
                                <td>'.strtoupper($gender).'</td>
                                <td>'.$efiling_civil_data[0]['pet_mobile'].'</td>
                                <td>'.$pet_address.'</td>';
                                if($hidepencilbtn!='true'){
                                    echo '<td class="efiling_search"><a href="'.base_url('caveat').'">Edit</a></td> ';
                                }


                            echo '</tr>';
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a href="#demo_3" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu">
        <?php
        if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && !empty($stage_id) && $stage_id == Transfer_to_IB_Stage)
        {
            echo '<i class="fa fa-minus" style="float: right;"></i>';
        }
        else if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADVOCATE){
            echo '<i class="fa fa-plus" style="float: right;"></i>';
        }
        else {
            echo '<i class="fa fa-plus" style="float: right;"></i>';
        }
        ?>
        <b><?php echo ucwords(strtolower($case_type_res_title)); ?></b></a>
    <div class="<?php echo $collapse_class;?>" id="demo_3">
        <div class="x_panel">
            <div class="table-responsive">
                <?php
                if($hidepencilbtn!='true'){ ?>
                <div <?php echo $display_edit; ?> class="text-right"><a href="<?php echo base_url('caveat/caveatee'); ?>"><i class="fa fa-pencil efiling_search"></i></a></div>
                <?php } ?>
                <table id="caveatee_table" class="table dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <th>#</th>
                        <th>Type</th>
                        <th>Caveatee Name</th>
                        <th>Age/D.O.B</th>
                        <th>Gender</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <?php
                        if($hidepencilbtn!='true'){ ?>
                            <th class="efiling_search">Action</th>
                        <?php } ?>

                    </thead>
                    <tbody>
                        <?php
                        $res_address = strtoupper($efiling_civil_data[0]['resadd']);
                        if (isset($efiling_civil_data[0]['res_pincode']) && !empty($efiling_civil_data[0]['res_pincode'])) {
                            $res_address .= ' - ' . $efiling_civil_data[0]['res_pincode'];
                        }
                        $res_age='';
                        if (!empty($efiling_civil_data[0]['res_age'])){$res_age=$efiling_civil_data[0]['res_age'].'Yrs /' ;}
                        $res_dob=!empty($efiling_civil_data[0]['res_dob']) ? $res_age.date('d-m-Y',strtotime($efiling_civil_data[0]['res_dob'])):$res_age;
                        echo '<tr>
                                <td>1</td>
                                <td>'.strtoupper($case_type_res_title).'</td>
                                <td>'.strtoupper('Caveatee Party :'.$caveatee_name.$caveatee_details).'</td>
                                <td>'.$res_dob.'</td>
                                <td>'.strtoupper($res_gender).'</td>
                                <td>'.$efiling_civil_data[0]['res_mobile'].'</td>
                                <td>'.$res_address.'</td>';
                                if($hidepencilbtn!='true'){
                                            echo '<td class="efiling_search"><a href="'.base_url('caveat/caveatee').'">Edit</a></td>';
                                        }

                                echo '</tr>';
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a href="#demo_4" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu">
        <?php
        if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && !empty($stage_id) && $stage_id == Transfer_to_IB_Stage)
        {
            echo '<i class="fa fa-minus" style="float: right;"></i>';
        }
        else if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADVOCATE){
            echo '<i class="fa fa-plus" style="float: right;"></i>';
        }
        else {
            echo '<i class="fa fa-plus" style="float: right;"></i>';
        }
        ?>
        <b>Extra Parties</b></a>
    <div class="<?php echo $collapse_class;?>" id="demo_4">
        <div class="x_panel">
            <div class="table-responsive">
                <?php
                if($hidepencilbtn!='true'){ ?>
                <div <?php echo $display_edit; ?> class="text-right"><a href="<?php echo base_url('caveat/extra_party'); ?>"><i class="fa fa-pencil efiling_search"></i></a></div>
                <?php } ?>
                <table id="extra_party_table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                            <th>#</th>
                            <th>Extra Party Is</th>
                            <th>Extra Party Name</th>
                            <th>Age/D.O.B</th>
                            <th>Gender</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <?php
                            if($hidepencilbtn!='true'){ ?>
                                <th class="efiling_search">Action</th>
                            <?php } ?>

                    </thead>
                    <tbody>
                        <?php
                        if (isset($extra_party_details) && !empty($extra_party_details)) {
                            $i = 1;
                            foreach ($extra_party_details as $exp) {
                                if ($exp->pet_sex == 'M') {
                                    $ext_gender = 'Male';
                                } elseif ($exp->pet_sex == 'F') {
                                    $ext_gender = 'Female';
                                } elseif ($exp->pet_sex == 'O') {
                                    $ext_gender = 'Other';
                                } else {
                                    $ext_gender = '';
                                }
                                $extra_party_type ='';
                                if ($exp->type == '1') {
                                    $extra_party_type = "<strong>Extra Party Type :</strong> Caveator";
                                } elseif ($exp->type == '2') {
                                    $extra_party_type = "<strong>Extra Party Type :</strong> Caveatee";
                                }
                                if ($exp->pet_age == 0) {
                                    $extra_party_age = '';
                                } else {
                                    $extra_party_age = $exp->pet_age;
                                }
                                $extra_party_address = strtoupper($exp->address);
                                if (isset($exp->pincode) && !empty($exp->pincode)) {
                                    $extra_party_address .= ' - ' . $exp->pincode;
                                }
                                $extraType =$exp->extra_party_is;
                                if (!empty($extra_party_age)){$extra_party_age=$extra_party_age.'Yrs /' ;}
                                $party_age_dob=!empty($exp->pet_dob) ? $extra_party_age.date('d-m-Y',strtotime($exp->pet_dob)):$extra_party_age;
                                if(isset($exp->orgid) && !empty($exp->orgid) && $exp->orgid != 'I'){
                                    $extra_party_org_dept_name=!empty($exp->extra_party_org_dept_name)? '<br/>Department Name : '.$exp->extra_party_org_dept_name.'<br/>':'';
                                    $extra_party_org_post_name=!empty($exp->extra_party_org_post_name)? 'Post Name : '.$exp->extra_party_org_post_name.'<br/>':'';
                                    $extra_party_org_state_name=!empty($exp->extra_party_org_state_name)? 'State Name : '.$exp->extra_party_org_state_name:'';
                                    $extra_party_type_details =$extra_party_org_dept_name.$extra_party_org_post_name.$extra_party_org_state_name;

                                }else if(isset($exp->orgid) && !empty($exp->orgid) && $exp->orgid == 'I'){
                                    $extra_party_type_details = ',Extra Party Name: '.$exp->name;
                                }
                            echo '<tr>
                                <td>'.$i.'</td>
                                <td>'.strtoupper($extraType).'</td>
                                <td>'.strtoupper($extra_party_type.$extra_party_type_details).'</td>
                                <td>'.$party_age_dob.'</td>
                                <td>'.strtoupper($ext_gender).'</td>
                                <td>'.$exp->pet_mobile.'</td>
                                <td>'.$extra_party_address.'</td>';
                                if($hidepencilbtn!='true'){
                                    echo '<td class="efiling_search"><a href="' . base_url('caveat/extra_party/' . url_encryption(trim(escape_data($exp->id)) . '$$party_id')) . '">Edit</a></td>';
                                }

                                echo '</tr>';

                            $i++;
                            }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a href="#demo_5" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><?php
        if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && !empty($stage_id) && $stage_id == Transfer_to_IB_Stage)
        {
            echo '<i class="fa fa-minus" style="float: right;"></i>';
        }
        else if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADVOCATE){
            echo '<i class="fa fa-plus" style="float: right;"></i>';
        }
        else {
            echo '<i class="fa fa-plus" style="float: right;"></i>';
        }
        ?>
        <b>Subordinate Court Details</b></a>
    <div class="<?php echo $collapse_class;?>" id="demo_5">
        <?php //$this->load->view('newcase/subordinate_court_list'); ?>
        <div class="x_panel">
            <div class="table-responsive">
                <?php
                if($hidepencilbtn!='true'){ ?>
                <div <?php echo $display_edit; ?> class="text-right"><a href="<?php echo base_url('caveat/subordinate_court'); ?>"><i class="fa fa-pencil efiling_search"></i></a></div>
                <?php } ?>
                <table id="subordinate_table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr class="success">
                        <th>#</th>
                        <th>Case Details</th>
                        <th>Cause Title</th>
                        <th>Decision Date</th>
                        <th>Order Challenged</th>
                        <th>Order Type</th>
                        <th>Caveat Details</th>
                        <?php
                        if($hidepencilbtn!='true'){ ?>
                            <th class="efiling_search">Action</th>
                        <?php } ?>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    foreach ($subordinate_court_details as $exp) {
                        if($exp['court_type']==1){

                            $court_type='Court Type:High Court'.'<br>';
                            $high_court_name='High Court Name:'.$exp['estab_name'].'<br>';
                            $high_bench_name='Bench Name:'.$exp['bench_name'].'<br>';
                            $court_type_details=$court_type.$state_name.$district_name.$high_court_name.$high_bench_name;

                        }elseif ($exp['court_type']==3){

                            $court_type='Court Type:District Court'.'<br>';
                            $state_name='State Name:'.$exp['state_name'].'<br>';
                            $district_name='Agency Name:'.$exp['estab_name'].'<br>';
                            $court_type_details=$court_type.$state_name.$district_name;


                        }elseif ($exp['court_type']==4){

                            $court_type='Court Type:Supreme Court'.'<br>';
                            $court_type_details=$court_type;

                        }elseif ($exp['court_type']==5){

                            $court_type='Court Type:Agency Court'.'<br>';
                            $state_name='State Name:'.$exp['state_name'].'<br>';
                            $agency_name='Agency Name:'.$exp['estab_name'].'<br>';
                            $court_type_details=$court_type.$state_name.$agency_name;


                        }
                        $case_type = '<b>Case Type </b> : ' . $exp['casetype_name'] . '<br/> ';
                        $fil_no = '<b>Filing No.</b> : ' . (int) $exp['case_num'] . ' / ' . $exp['case_year'] . '<br/> ';
                        if (!empty($exp['cnr_num'])) {
                            $case_details = '<b>CNR No.</b> : ' . cin_preview($exp['cnr_num']) . '<br/> ' . $case_type . $fil_no;
                        } else {
                            $case_details = $case_type . $fil_no;
                        }
                        $causeTitle = '';
                        if(isset($exp['pet_name']) && !empty($exp['pet_name']) && isset($exp['res_name']) && !empty($exp['res_name'])){
                            $causeTitle = strtoupper($exp['pet_name'] . ' Vs. ' . $exp['res_name']);
                        }
                        else  if(isset($exp['pet_name']) && !empty($exp['pet_name'])){
                            $causeTitle = strtoupper($exp['pet_name']);
                        }
                        else{
                            $causeTitle = '---';
                        }
                        ?>
                        <tr>
                            <td><?php echo_data($i++); ?></td>
                            <td><?php echo '<b>'.$court_type_details.'</b>'; echo $case_details; ?>
                                <?php $getData_earlierCourtArr=$exp['id'].'@@@'.$exp['registration_id'].'@@@'.$exp['court_type'].'@@@'.$exp['case_type_id'].'@@@'.$exp['casetype_name'];
                                $earlierCourtArr=url_encryption($getData_earlierCourtArr);
                                if($_SESSION['login']['userid']=='SC-ADMIN' && $exp['case_type_id']==0 || $exp['case_type_id'] ==null){?>
                                    <button class="efiling_search btn btn-success btn-sm" data-toggle="modal" href="#earlier_court_updateModal" onclick="getDataEarlierCourtUpdateModal(<?="'$earlierCourtArr'";?>)">Update</button>
                                <?php }?>
                            </td>
                            <td><?php echo $causeTitle;
                                if(!is_null($exp['fir_no'])) echo '<br><b>FIR No. </b>'.$exp['fir_no'].'/'.$exp['fir_year'].' ('.$exp['complete_fir_no'].')';
                                if(!is_null($exp['fir_no'])) echo '<br><b>Police Station: </b>'.$exp['police_station_name'].' ('.$exp['district_name'].', '.$exp['state_name'].')';

                                ?>
                            </td>
                            <!--<td><?php /*echo echo_data($exp['impugned_order_date']); */?></td>-->
                            <td><?php echo echo_data(!empty($exp['impugned_order_date'])?date('d-m-Y',strtotime($exp['impugned_order_date'])):''); ?></td>
                            <td><?php if($exp['is_judgment_challenged']=='t'){ echo 'Yes';}else{ echo 'No';} ?></td>
                            <td><?php if($exp['judgment_type']=='F'){ echo 'Final';}else{ echo 'Interim';} ?></td>
                            <td>
                                <?php
                                $ct_code=$exp['court_type'];
                                $l_state=$exp['cmis_state_id'];
                                $l_dist=$exp['ref_agency_code_id'];
                                $lct_dec_dt=$exp['impugned_order_date'];
                                $lct_caseno=$exp['case_num'];
                                $lct_caseyear=$exp['case_year'];
                                $json_return = file_get_contents(ICMIS_SERVICE_URL."/ConsumedData/search_caveat/?ct_code=$ct_code&l_state=$l_state&l_dist=$l_dist&lct_dec_dt='$lct_dec_dt'&lct_caseno=$lct_caseno&lct_caseyear=$lct_caseyear");
                                $caveat_response = json_decode($json_return);
                                if ($caveat_response){
                                    $caveat_cases = $caveat_response->caveats;
                                    if (!empty($caveat_cases)){
                                        $sr_no = 1;
                                        foreach ($caveat_cases as $cc) {
                                            $caveatno = substr($cc->caveat_no, 0, strlen($cc->caveat_no) - 4) . '/' . substr($cc->caveat_no, -4);
                                            echo $sr_no . ")Caveat No. " . $caveatno . '(' . $cc->caveat_status . ')<br>';
                                            //echo $cc->agency_state;
                                            echo $cc->agency_name . "<br>";
                                            echo $cc->aor_details . "<br>";
                                            $sr_no++;
                                        }

                                    }else{
                                        echo "Caveat not found";
                                    }

                                }else{
                                    echo "Caveat not found.";
                                }
                                ?>
                            </td>
                            <?php
                            if($hidepencilbtn!='true'){ ?>
                                <td class="efiling_search"><a href="<?php echo base_url('newcase/Subordinate_court/DeleteSubordinateCourt/' . url_encryption($exp['id'])); ?>">Delete</a></td>

                            <?php } ?>

                        </tr>
                    <?php } ?>
                    </tbody>
                </table>


            </div>
        </div>
    </div>

    <a href="#demo_6" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><?php
        if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && !empty($stage_id) && $stage_id == Transfer_to_IB_Stage)
        {
            echo '<i class="fa fa-minus" style="float: right;"></i>';
        }
        else if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADVOCATE){
            echo '<i class="fa fa-plus" style="float: right;"></i>';
        }
        else {
            echo '<i class="fa fa-plus" style="float: right;"></i>';
        }
        ?>
        <b>Documents</b></a>
    <div class="<?php echo $collapse_class;?>" id="demo_6">
        <div class="x_panel">
            <?php
            if($hidepencilbtn!='true'){ ?>
            <div <?php echo $display_edit; ?> class="text-right"><a href="<?php echo base_url('documentIndex'); ?>"><i class="fa fa-pencil efiling_search"></i></a></div>
            <?php } ?>
            <?php  $this->load->view('documentIndex/documentIndex_caveat_list_view'); ?>
        </div>        
    </div>

    <a href="#demo_7" class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><?php
        if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADMIN && !empty($stage_id) && $stage_id == Transfer_to_IB_Stage)
        {
            echo '<i class="fa fa-minus" style="float: right;"></i>';
        }
        else if(!empty($ref_m_usertype_id) && $ref_m_usertype_id == USER_ADVOCATE){
            echo '<i class="fa fa-plus" style="float: right;"></i>';
        }
        else {
            echo '<i class="fa fa-plus" style="float: right;"></i>';
        }
        ?>
        <b>Fees Paid</b></a>
    <div class="<?php echo $collapse_class;?>" id="demo_7">
        <div class="x_panel">
            <?php
            if($hidepencilbtn!='true'){ ?>
            <div  class="text-right"><a href="<?php echo base_url('newcase/courtFee'); ?>"><i class="fa fa-pencil efiling_search"></i></a></div>
            <?php } ?>
            <?php  $this->load->view('caveat/offline_payments_list_view'); ?>
        </div>
    </div>


</div>

</div>
<?php // $this->load->view('efilingAction/approve_disapprove_modals/approve_modal.php'); ?>
<?php // $this->load->view('efilingAction/approve_disapprove_modals/disapprove_modal.php'); ?>

</div>
</div>
</div>
</div>
</div>
</div>
</div>


<!--start modal-->

<div class="modal fade" id="earlier_court_updateModal" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" style="width: 90%;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="fa fa-pencil"></span> Update Earlier Courts information.</h4>


            </div>
            <div class="modal-body">
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <div id="BindEarlierCourt"></div>
                </div>

                <div class="modal-footer">
                </div>
            </div>

        </div>
    </div>

    <!--end modal-->
    <script>
        function getDataEarlierCourtUpdateModal(earlierCourtArr) {
            //alert('akg');
           // alert(earlierCourtArr);
            var act_null='';
            $('#EarlierCourt').val(act_null);
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('caveat/subordinate_court/update_subordinate_court_details'); ?>",
                data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, earlierCourtArr:earlierCourtArr},
                success: function (data) {

                    $('#BindEarlierCourt').html(data);

                    $.getJSON("<?php echo base_url() . 'csrftoken'; ?>", function (result) {
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
    </script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#extra_party_table').dataTable({});
        $('#caveatee_table').dataTable({});
        $('#caveator_table').dataTable({});
        $('#subordinate_table').dataTable({});
        $('#add_org_not_listed,.extra_party_org_not_listed').on('submit', function () {
            if ($('#add_org_not_listed,.extra_party_org_not_listed').valid()) {
                var form_data = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('efilingAction/org_not_listed/add_organisation'); ?>",
                    data: form_data,
                    success: function (data) {
                        var resArr = data.split('@@@');
                        if (resArr[0] == 1) {
                            $('#msg').show();
                            $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                        } else if (resArr[0] == 2) {
                            $('#msg').show();
                            $(".form-response").html("<p class='message valid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                            setTimeout(function () {
                                $('#msg').hide();
                                window.location.href = '<?php echo base_url('caveat/view'); ?>';
                            }, 3000);
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
                return false;
            } else {
                return false;
            }
        });
    });
</script>
<style>
    .blinking{
        animation:blinkingText 0.9s infinite;

    }
    @keyframes blinkingText{
        0%{     color: red;    }
        49%{    color: transparent; }
        50%{    color: transparent; }
        99%{    color:transparent;  }
        100%{   color: #000;    }
    }

</style>

