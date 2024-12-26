<style>
table {border: 0;border-collapse: separate;border-spacing: 1px 0;table-layout: fixed;word-wrap: break-word;}
.innertable {border: 0;border-collapse: separate;border-spacing: 1px 0;table-layout: auto !important;word-wrap: !important normal;white-space: nowrap}
.panel-heading {padding: 0;}
.panel-title a {display: block;padding: 10px 15px;}
b {font-weight: normal;}
.accordion-option {width: 100%;float: left;clear: both;margin: 15px 0;}
.accordion-option .title {font-size: 20px;font-weight: bold;float: left;padding: 0;margin: 0;}
.accordion-option .toggle-accordion {float: right;font-size: 16px;color: #6a6c6f;}
.accordion-option .toggle-accordion:before {content: "Expand All";}
.accordion-option .toggle-accordion.active:before {content: "Collapse All";}
</style>
<div class="right_col" role="main">
    <div class="row" id="printData">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <div class="panel-body">
                    <div class="accordion-option">
                        <h3 class="title">Compare Uploaded PDF JSON Data</h3>
                        <a href="javascript:void(0)" class="toggle-accordion active" accordion-id="#accordionjson"></a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="panel-group" id="accordionjson" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordionjson" href="#collapseOne"
                                            aria-expanded="true" aria-controls="collapseOne">
                                            <b>Case Details</b><i class="fa fa-minus" style="float: right;"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                    aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table maintable">
                                                <thead>
                                                    <tr class="success">
                                                        <th scope="col">#</th>
                                                        <th scope="col">IITM JSON</th>
                                                        <th scope="col">EFILING JSON</th>
                                                        <th scope="col">ICMIS JSON</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="4">
                                                            <table class="table">
                                                                <?php
                                                                $srno = 1;
                                                                foreach($case_details_array_column as $column){ 
                                                                    if(in_array($column,['subj_main_cat'])){
                                                                        continue;
                                                                    }
                                                                    ?>
                                                                <tr>
                                                                    <td><?php echo $srno.'. '.$column; $srno++;?></td>
                                                                    <td>
                                                                        <?php 
                                                                        if(is_array($iitm_api_array['case_details'][$column])){
                                                                            echo implode(',',$iitm_api_array['case_details'][$column]);
                                                                        }else{
                                                                            echo $iitm_api_array['case_details'][$column];
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php 
                                                                        if($column=='court_type'){
                                                                            if($efiling_array['case_details'][0][$column]==1){
                                                                                $court_type = 'High Court';
                                                                            }elseif($efiling_array['case_details'][0][$column]==3){
                                                                                $court_type = 'District Court';
                                                                            }elseif($efiling_array['case_details'][0][$column]==4){
                                                                                $court_type = 'Supreme Court';
                                                                            }elseif($efiling_array['case_details'][0][$column]==5){
                                                                                $court_type = 'State Agency';
                                                                            }
                                                                            echo $court_type;
                                                                        }elseif($column=='casetype_id'){
                                                                            $this->load->model('newcase/Dropdown_list_model');
                                                                            $sc_case_type = $this->Dropdown_list_model->getSciCaseTypeOrderById();
                                                                            foreach($sc_case_type as $value){
                                                                                if($value->casecode==$efiling_array['case_details'][0][$column]){
                                                                                    echo $value->casename;
                                                                                }
                                                                            }
                                                                        }elseif($column=='sc_sp_case_type_id'){
                                                                            if($efiling_array['case_details'][0][$column]==1){
                                                                                $scspcasetype_id = 'NONE';
                                                                            }elseif($efiling_array['case_details'][0][$column]==6){
                                                                                $scspcasetype_id = 'JAIL PETITION';
                                                                            }elseif($efiling_array['case_details'][0][$column]==7){
                                                                                $scspcasetype_id = 'PUD';
                                                                            }
                                                                            echo $scspcasetype_id;
                                                                        }
                                                                        else{
                                                                            echo $efiling_array['case_details'][0][$column];
                                                                        }
                                                                    ?>
                                                                    </td>
                                                                    <td><?php echo $icmis_array['case_details'][$column];?>
                                                                    </td>
                                                                </tr>
                                                                <?php } ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordionjson"
                                            href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <b>Main Petitioner</b><i class="fa fa-plus" style="float: right;"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr class="success">
                                                        <th scope="col">#</th>
                                                        <th scope="col">IITM JSON</th>
                                                        <th scope="col">EFILING JSON</th>
                                                        <th scope="col">ICMIS JSON</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="4">
                                                            <table class="table">
                                                                <?php
                                                                $srno = 1;
                                                                foreach($main_petitioner_array_column as $column){ 
                                                                    if(in_array($column,['id','registration_id','subj_main_cat','state_name'])){
                                                                        continue;
                                                                    }
                                                                    ?>
                                                                <tr>
                                                                <td><?php echo $srno.'. '.$column; $srno++;?></td>
                                                                    <td>
                                                                        <?php 
                                                                            if(is_array($iitm_api_array['main_petitioner'][$column])){
                                                                                echo implode(',',$iitm_api_array['main_petitioner'][$column]);
                                                                            }else{
                                                                                echo $iitm_api_array['main_petitioner'][$column];
                                                                            }
                                                                            ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php 
                                                                            if($column=='state_id'){
                                                                                echo $efiling_array['main_petitioner'][0]['state_name'];
                                                                            }elseif($column=='district_id'){
                                                                                echo $efiling_array['main_petitioner'][0]['addr_dist_name'];
                                                                            }elseif($column=='party_type'){
                                                                                if($efiling_array['main_petitioner'][0][$column]=='I'){
                                                                                    echo 'Individual';
                                                                                }elseif($efiling_array['main_petitioner'][0][$column]=='D1'){
                                                                                    echo 'State Department';
                                                                                }elseif($efiling_array['main_petitioner'][0][$column]=='D2'){
                                                                                    echo 'Central Department';
                                                                                }elseif($efiling_array['main_petitioner'][0][$column]=='D3'){
                                                                                    echo 'Other Organisation';
                                                                                }
                                                                                
                                                                            }
                                                                            else{
                                                                                echo $efiling_array['main_petitioner'][0][$column];
                                                                            }
                                                                            ?>
                                                                    </td>
                                                                    <td><?php echo $icmis_array['main_petitioner'][$column];?>
                                                                    </td>
                                                                </tr>
                                                                <?php } ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                            data-parent="#accordionjson" href="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            <b>Main Reposndent</b><i class="fa fa-plus" style="float: right;"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingThree">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="thead-dark">
                                                    <tr class="success">
                                                        <th scope="col">#</th>
                                                        <th scope="col">IITM JSON</th>
                                                        <th scope="col">EFILING JSON</th>
                                                        <th scope="col">ICMIS JSON</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="4">
                                                            <table class="table">
                                                                <?php
                                                                $srno=1;
                                                                foreach($main_reposndent_array_column as $column){ 
                                                                    if(in_array($column,['id','registration_id','state_name'])){
                                                                        continue;
                                                                    }
                                                                    ?>
                                                                <tr>
                                                                <td><?php echo $srno.'. '.$column; $srno++;?></td>
                                                                    <td>
                                                                        <?php 
                                                                            if(is_array($iitm_api_array['main_reposndent'][$column])){
                                                                                echo implode(',',$iitm_api_array['main_reposndent'][$column]);
                                                                            }else{
                                                                                echo $iitm_api_array['main_reposndent'][$column];
                                                                            }
                                                                            ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php 
                                                                            if($column=='state_id'){
                                                                                echo $efiling_array['main_petitioner'][0]['state_name'];
                                                                            }elseif($column=='district_id'){
                                                                                echo $efiling_array['main_petitioner'][0]['addr_dist_name'];
                                                                            }elseif($column=='party_type'){
                                                                                if($efiling_array['main_petitioner'][0][$column]=='I'){
                                                                                    echo 'Individual';
                                                                                }elseif($efiling_array['main_petitioner'][0][$column]=='D1'){
                                                                                    echo 'State Department';
                                                                                }elseif($efiling_array['main_petitioner'][0][$column]=='D2'){
                                                                                    echo 'Central Department';
                                                                                }elseif($efiling_array['main_petitioner'][0][$column]=='D3'){
                                                                                    echo 'Other Organisation';
                                                                                }
                                                                                
                                                                            }else{
                                                                                echo $efiling_array['main_petitioner'][0][$column];
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                    <td><?php echo $icmis_array['main_respondent'][$column];?>
                                                                    </td>
                                                                </tr>
                                                                <?php } ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingFour">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                            data-parent="#accordionjson" href="#collapseFour" aria-expanded="false"
                                            aria-controls="collapseFour">
                                            <b>Extra Party</b><i class="fa fa-plus" style="float: right;"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingFour">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="thead-dark">
                                                    <tr class="success">
                                                        <th scope="col">IITM JSON</th>
                                                        <th scope="col">EFILING JSON</th>
                                                        <th scope="col">ICMIS JSON</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="table-responsive">
                                                                <table class="table innertable">
                                                                    <thead>
                                                                        <tr class="alert alert-info">
                                                                            <?php
                                                                            foreach($iitm_extra_party_columns as $column){ ?>
                                                                            <th><?php echo $column; ?></th>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                            <?php
                                                                            foreach($iitm_api_array['extra_party'] as $iitm_api_data){?>
                                                                            <tr>
                                                                                <?php
                                                                                foreach($iitm_api_data as $key=>$value){
                                                                                    ?>
                                                                                    <td><?php echo $value;?></td>
                                                                                    <?php } ?>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="table-responsive">
                                                                <table class="table innertable">
                                                                    <thead>
                                                                        <tr class="alert alert-info">
                                                                            <?php
                                                                            foreach($efiling_extra_party_columns as $column){ 
                                                                                if(in_array($column,['id','registration_id'])){
                                                                                    continue;
                                                                                }
                                                                            ?>
                                                                            <th><?php echo $column; ?></th>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                            <?php
                                                                            foreach($efiling_array['extra_party'] as $efiling_data){?>
                                                                            <tr>
                                                                                <?php
                                                                                foreach($efiling_data as $key=>$value){
                                                                                    if(in_array($key,['id','registration_id','subj_main_cat','state_name'])){
                                                                                        continue;
                                                                                    }
                                                                                    ?>
                                                                                    <td><?php echo $value;?></td>
                                                                                    <?php } ?>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="table-responsive">
                                                                <table class="table innertable">
                                                                    <thead>
                                                                        <tr class="alert alert-info">
                                                                            <?php
                                                                            foreach($icmis_extra_party_columns as $column){?>
                                                                            <th><?php echo $column; ?></th>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <?php
                                                                            foreach($icmis_array['extra_party'] as $icmis_data){?>
                                                                            <tr>
                                                                                <?php
                                                                                foreach($icmis_data as $key=>$value){?>
                                                                                    <td><?php echo $value;?></td>
                                                                                    <?php } ?>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingFive">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                            data-parent="#accordionjson" href="#collapseFive" aria-expanded="false"
                                            aria-controls="collapseFive">
                                            <b>Earlier Courts</b><i class="fa fa-plus" style="float: right;"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseFive" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingFour">
                                    <div class="panel-body">
                                    <div class="table-responsive">
                                            <table class="table">
                                                <thead class="thead-dark">
                                                    <tr class="success">
                                                        <th scope="col">IITM JSON</th>
                                                        <th scope="col">EFILING JSON</th>
                                                        <th scope="col">ICMIS JSON</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="table-responsive">
                                                                <table class="table innertable">
                                                                    <thead>
                                                                        <tr class="alert alert-info">
                                                                            <?php
                                                                            foreach($iitm_earlier_courts_columns as $column){ ?>
                                                                            <th><?php echo $column; ?></th>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                            <?php
                                                                            $iitm_api_earlier_courts[] = $iitm_api_array['earlier_courts'];
                                                                            foreach($iitm_api_earlier_courts as $iitm_api_data){?>
                                                                            <tr>
                                                                                <?php
                                                                                foreach($iitm_api_data as $key=>$value){
                                                                                    ?>
                                                                                    <td><?php echo $value;?></td>
                                                                                    <?php } ?>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="table-responsive">
                                                                <table class="table innertable">
                                                                    <thead>
                                                                        <tr class="alert alert-info">
                                                                            <?php
                                                                            foreach($efiling_earlier_courts_columns as $column){ 
                                                                                if(in_array($column,['id','registration_id','fir_details'])){
                                                                                    continue;
                                                                                }
                                                                            ?>
                                                                            <th><?php echo $column; ?></th>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                            <?php
                                                                            foreach($efiling_array['earlier_courts'] as $efiling_data){?>
                                                                            <tr>
                                                                                <?php
                                                                                foreach($efiling_data as $key=>$value){
                                                                                    if(in_array($key,['id','registration_id','fir_details'])){
                                                                                        continue;
                                                                                    }
                                                                                    ?>
                                                                                    <td><?php echo $value;?></td>
                                                                                    <?php } ?>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="table-responsive">
                                                                <table class="table innertable">
                                                                    <thead>
                                                                        <tr class="alert alert-info">
                                                                            <?php
                                                                            foreach($icmis_earlier_courts_columns as $column){?>
                                                                            <th><?php echo $column; ?></th>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <?php
                                                                            foreach($icmis_array['earlier_courts'] as $icmis_data){?>
                                                                            <tr>
                                                                                <?php
                                                                                foreach($icmis_data as $key=>$value){?>
                                                                                    <td>
                                                                                        <?php 
                                                                                        if(is_array($value)){
                                                                                            echo implode(',',$value);
                                                                                        }else{
                                                                                            echo $value;
                                                                                        }
                                                                                        ?>
                                                                                    </td>
                                                                                    <?php } ?>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
$(document).ready(function() {
    $(".toggle-accordion").on("click", function() {
        var accordionId  = $(this).attr("accordion-id"),
        numPanelOpen = $(accordionId + ' .collapse.in').length;
        $(this).toggleClass("active");
        if (numPanelOpen == 0) {
            openAllPanels(accordionId);
            $('.toggle-accordion').innerHTML('Collapse All');
        } else {
            closeAllPanels(accordionId);
            $('.toggle-accordion').innerHTML('Expand All');
        }
    })
    openAllPanels = function(aId) {
        $(aId + ' .panel-collapse:not(".in")').collapse('show');
    }
    closeAllPanels = function(aId) {
        $(aId + ' .panel-collapse.in').collapse('hide');
    }
});
</script>