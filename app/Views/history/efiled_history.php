<?php
$filing_type = $_SESSION['efiling_details']['ref_m_efiled_type_id'];
if ($filing_type == E_FILING_TYPE_MISC_DOCS || $filing_type == E_FILING_TYPE_IA || $filing_type == E_FILING_TYPE_DEFICIT_COURT_FEE) {
    if(empty($case_details[0]['reg_no_display']))
     $cause_title = htmlentities('D. No.:  '.$case_details[0]['diary_no'].'/'.$case_details[0]['diary_year'], ENT_QUOTES)."<br>".htmlentities($case_details[0]['cause_title'], ENT_QUOTES);
    else
        $cause_title = htmlentities($case_details[0]['reg_no_display'], ENT_QUOTES)."<br>".htmlentities($case_details[0]['cause_title'], ENT_QUOTES);
    $lbl_efiling_no = 'eFiling No.';
    $lbl_history = 'eFiling History';
    if ($filing_type == E_FILING_TYPE_MISC_DOCS) {
        $type = 'Misc Document';
    } elseif ($filing_type == E_FILING_TYPE_DEFICIT_COURT_FEE) {
        $type = 'Deficit Fee';
    } elseif ($filing_type == E_FILING_TYPE_IA) {
        $type = 'Interim Application';
    }
} elseif ($filing_type == E_FILING_TYPE_NEW_CASE || $filing_type == E_FILING_TYPE_CDE) {
    $lbl_history = 'eFiling History';
    $lbl_efiling_no = 'eFiling No.';
    if ($filing_type == E_FILING_TYPE_NEW_CASE) {
        $type = 'New Case';
    } elseif ($filing_type == E_FILING_TYPE_CDE) {
        $type = 'Case Data Entry';
        $lbl_history = 'Case Data Entry Hisotry';
        $lbl_efiling_no = 'CDE No.';
    }
    $cause_title = htmlentities(@$result[0]['cause_title'], ENT_QUOTES);
}
$efiled_by = strtoupper($efiled_by_user[0]->first_name . ' ' . $efiled_by_user[0]->last_name);
?>
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <a class="btn btn-info" type="button" onclick="window.history.back()"> Back</a>
                </div>
                <h3 style="text-align: center"> <strong><?php echo $lbl_history; ?></strong> </h3>
                <div class="x_content">
                    <table id="example_ef" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead> 
                            <tr class="success">
                                <th><?php echo $lbl_efiling_no; ?> </th>
                                <th>Case No.& Cause Title</th>
                                <th>Type</th>
                                <th>Submitted By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td  width="14%"><?php echo htmlentities(efile_preview($_SESSION['efiling_details']['efiling_no']), ENT_QUOTES); ?></td>
                                <td><?php echo $cause_title ?></td>                                    
                                <td width="14%"><?php echo htmlentities($type, ENT_QUOTES); ?></td>
                                <!--<td width="14%"><a href="<?/*= base_url() */?>history/efiled_case/user_info/<?php /*echo htmlentities(url_encryption(trim($efiled_by_user[0]->id)), ENT_QUOTES) . '/' . htmlentities(url_encryption(trim($efiled_by_user[0]->ref_m_usertype_id)), ENT_QUOTES); */?>"><?php /*echo htmlentities(strtoupper($efiled_by), ENT_QUOTES); */?></a></td>-->
                                <td width="14%"><?php echo htmlentities(strtoupper($efiled_by), ENT_QUOTES); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-6">
                    <h5>
                        <strong>Progress through various Stages</strong>
                    </h5>
                    <table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead> 
                            <tr class="success">
                                <th>#</th>
                                <th>Stage</th>
                                <th>Active from</th>
                                <th>Active Upto</th>
                            </tr>                                                
                        </thead>
                        <tbody>

                            <?php
                            $i = 1;

                            foreach ($stage as $stg) {
                                $stage_name = ($_SESSION['login']['ref_m_usertype_id'] == USER_ADMIN || $_SESSION['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN) ? $stg['admin_stage_name'] : $stg['user_stage_name'];

                                if ($stage_name == $stage[$i]['user_stage_name'] && strtotime($stg['deactivated_on']) == strtotime($stage[$i]['activated_on'])) {
                                    $activate_from_array[$stage_name][] = $stg['activated_on'];
                                    continue;
                                } else {
                                    $activate_from = $stg['activated_on'];
                                }

                                $activate_from_result = ($activate_from_array[$stage_name] != '') ? $activate_from_array[$stage_name][0] : $activate_from;
                                $activate_from_array = array();
                                ?>
                                <tr>
                                    <td width="10%"><?php echo htmlentities($i++, ENT_QUOTES); ?></td>
                                    <td width="30%"><?php echo htmlentities($stage_name, ENT_QUOTES); ?></td>
                                    <td width="30%"><?php echo htmlentities(date('d-m-Y h:i:s A', strtotime($activate_from_result)), ENT_QUOTES); ?></td>
                                    <td width="30%"><?php if ($stg['deactivated_on'] != '') echo htmlentities(date('d-m-Y h:i:s A', strtotime($stg['deactivated_on'])), ENT_QUOTES); ?></td>

                                </tr>
                            <?php } ?>   

                        </tbody>
                    </table>
                </div>
                <?php if ($filing_type != E_FILING_TYPE_CDE) { ?>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <h5>
                            <strong>Uploaded Documents</strong>
                        </h5>
                        <table id="example_up" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr class="success">
                                    <th>#</th>
                                    <th>Document</th>
                                    <th>Pages</th>
                                    <th>Upload date</th>

                                </tr>                                                
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($uploaded_docs as $updoc) {
                                    ?>
                                    <tr>
                                        <td width="1%" class="sorting_1" tabindex="0"><?php echo htmlentities($i++, ENT_QUOTES); ?></td>
                                        <td width="4%" class="sorting_1" tabindex="0"> <a href="<?= base_url('documentIndex/viewIndexItem/' . url_encryption($updoc->doc_id)); ?>" target="_blank"><?php echo htmlentities($updoc->doc_title, ENT_QUOTES); ?><br>(<?php echo htmlentities($updoc->file_type, ENT_QUOTES); ?>)</a></td>
                                        <td width="2%" class="sorting_1" tabindex="0"><?php echo htmlentities($updoc->page_no, ENT_QUOTES); ?></td>
                                        <td width="4%" class="sorting_1" tabindex="0"><?php echo htmlentities(date('d-m-Y h:i:s A', strtotime($updoc->uploaded_on)), ENT_QUOTES); ?></td>
                                    </tr>

                                <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <?php
                if ($payment_details != "") {
                    ?>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-response" id="msg"></div>
                        <div id="modal_loader">
                            <img id="loader_img" style="margin-top: 30px;margin-left: 30px;display:block;" src="<?php echo base_url('assets/images/loading-data.gif'); ?>" />
                        </div>
                        <h5><strong>Payment History</strong></h5>
                        <?php $this->load->view('shcilPayment/payment_list_view'); ?>

                    </div>
                <?php } ?>

                <?php if ($remark > 0) { ?>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h5>
                            <strong>Defects</strong>
                        </h5>
                        <table id="example_up" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr class="success">
                                    <th>#</th>
                                    <th>Defects Date</th>
                                    <th>Defects </th>
                                    <th>Defects Cure Date</th>
                                </tr>                                                
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($remark as $re) {
                                    $msg = $re->defect_remark;
                                    $cure_date = ($re->defect_cured_date != NULL) ? date("d-m-Y h:i:s A", strtotime($re->defect_cured_date)) : NULL;
                                    ?>
                                    <tr>
                                        <td width="5%"><?php echo htmlentities($i++, ENT_QUOTES); ?></td>
                                        <td width="15%"><?php echo htmlentities(date("d-m-Y h:i:s A", strtotime($re->defect_date)), ENT_QUOTES); ?> </td>
                                        <td><?php echo script_remove($msg); ?></td>
                                        <td width="15%"><?php echo htmlentities($cure_date); ?> </td>

                                    </tr>
                                <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <?php if ($allocation_details > 0) { ?>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h5><strong>Allocation Details</strong></h5>
                        <table id="example_up" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr class="success">
                                    <th>#</th>
                                    <th>Allocated to</th>
                                    <th>Allocated On </th>
                                    <th>Reason</th>
                                    <th>IP</th>
                                </tr>                                                
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($allocation_details as $result) {
                                    ?>
                                    <tr>
                                        <td width="5%"><?php echo htmlentities($i++, ENT_QUOTES); ?></td>
                                        <td width="25%"><?php echo htmlentities(strtoupper($result->admin_name), ENT_QUOTES); ?> </td>
                                        <td width="15%"><?php echo htmlentities(date("d-m-Y h:i:s A", strtotime($result->allocated_on)), ENT_QUOTES); ?> </td>
                                        <td><?php echo htmlentities($result->reason_to_allocate, ENT_QUOTES); ?> </td>
                                        <td width="15%"><?php echo htmlentities($result->update_ip, ENT_QUOTES); ?> </td>

                                    </tr>
                                <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                <?php } ?> 
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <a class="btn btn-info" type="button" onclick="window.history.back()"> Back</a> 
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    th{font-size: 13px;color: #000;} 
    td{font-size: 13px;color: #000;} 
</style> 

<script>
    $(document).ready(function () {
        $('#example,#example_st,#example_up,#example_ef').DataTable({
            "paging": false,
            "ordering": false,
            "searching": false,
            "info": false
        });
    });
</script>