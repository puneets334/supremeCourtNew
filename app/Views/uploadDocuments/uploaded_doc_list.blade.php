<div class="panel panel-default">
    <div class="panel-body">

        <?php

        use App\Models\Common\CommonModel;

        $segment = service('uri');
        ?>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="table-sec">
                <div class="table-responsive">
                    <table id="datatable-responsive" class="table table-striped custom-table datatableresponsive">
                        <!-- <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%"> -->
                        <thead>
                            <tr class="success">
                                <th>#</th>
                                <th>Uploaded Documents(s) </th>
                                <th>Uploaded On </th>
                                <th>Pages</th>
                                <?php if ($segment->getSegment(2) != 'caseDetails' and ((getSessionData('login')['ref_m_usertype_id'] == USER_ADVOCATE || getSessionData('login')['ref_m_usertype_id'] == USER_IN_PERSON)  and in_array(getSessionData('efiling_details')['stage_id'], array(Draft_Stage, Initial_Defected_Stage, I_B_Defected_Stage)))) { ?>
                                    <th>Delete</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (getSessionData('efiling_details')['stage_id'] == I_B_Defected_Stage) {
                                $Common_model = new CommonModel();
                                $result = $Common_model->max_pending_stage_date(getSessionData('efiling_details')['registration_id']);
                            }
                            $sr = 1;
                            $caveateDocNum = '';
                            foreach ($uploaded_docs as $doc) {
                                $file_name = !empty($doc['file_name']) ? $doc['file_name'] : NULL;
                                if (isset($file_name) && !empty($file_name)) {
                                    $fileNameArr = explode('_', $file_name);
                                    if (isset($fileNameArr[0]) && !empty($fileNameArr[0])) {
                                        $caveaEfilingNo = $fileNameArr[0];
                                        if (strpos($caveaEfilingNo, 'EKSCIN') !== false) {
                                            $caveateDocNum++;
                                        }
                                    }
                                }
                            ?>
                                <tr>
                                    <td><?= $sr++; ?></td>
                                    <td><a target="_blank" href="<?php echo base_url('uploadDocuments/viewDocument/' . url_encryption($doc['doc_id'])); ?>">
                                            <?php echo_data($doc['doc_title']); ?>
                                            <img src="<?= base_url('assets/images/pdf.png') ?>"> <br />
                                            <?php echo_data($doc['doc_hashed_value']); ?></a>
                                    </td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($doc['uploaded_on'])) ?></td>
                                    <td><?= htmlentities($doc['page_no'], ENT_QUOTES); ?></td>
                                    <?php if ($segment->getSegment(2) != 'caseDetails' and ((getSessionData('login')['ref_m_usertype_id'] == USER_ADVOCATE || getSessionData('login')['ref_m_usertype_id'] == USER_IN_PERSON) and in_array(getSessionData('efiling_details')['stage_id'], array(Draft_Stage, Initial_Defected_Stage, I_B_Defected_Stage)))) { ?>
                                        <td>
                                            <?php
                                            if (isset($result) && strtotime($doc['uploaded_on']) > strtotime($result[0]->max_date) || in_array(getSessionData('efiling_details')['stage_id'], array(Draft_Stage, Initial_Defected_Stage))) {
                                            ?>
                                                <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="DocDeleteAction('<?php echo htmlentities(url_encryption(trim($doc['doc_id'] . '$$' . getSessionData('efiling_details')['registration_id']), ENT_QUOTES)); ?>')"><i class="fa fa-trash"></i> </a>
                                                <?php } else { ?>-<?php } ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <input type="hidden" name="caveateDocNum" id="caveateDocNum" data-caveateDocNum="<?php echo $caveateDocNum; ?>" />

            <!-- start : To show previously submitted and deleted petition while re-filing -->
            <?php if ($segment->getSegment(2) != 'caseDetails' && !empty($uploaded_deleted_docs_while_refiling) && (getSessionData('login')['ref_m_usertype_id'] == USER_ADMIN)) { ?>
                <div class="table-sec">
                    <div class="table-responsive">
                        <table id="datatable-responsive1" class="table table-striped custom-table datatableresponsive">
                            <!-- <table id="datatable-responsive1" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%"> -->
                            <thead>
                                <tr class="danger">
                                    <th>#</th>
                                    <th>Uploaded Documents (Files deleted by AOR while re-filing)</th>
                                    <th>Uploaded On </th>
                                    <th>Deleted On </th>
                                    <th>Pages</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sr = 1;
                                $caveateDocNum = '';
                                foreach ($uploaded_deleted_docs_while_refiling as $deleted_doc) {
                                    $file_name = !empty($deleted_doc['file_name']) ? $deleted_doc['file_name'] : NULL;
                                    if (isset($file_name) && !empty($file_name)) {
                                        $fileNameArr = explode('_', $file_name);
                                        if (isset($fileNameArr[0]) && !empty($fileNameArr[0])) {
                                            $caveaEfilingNo = $fileNameArr[0];
                                            if (strpos($caveaEfilingNo, 'EKSCIN') !== false) {
                                                $caveateDocNum++;
                                            }
                                        }
                                    }
                                ?>
                                    <tr>
                                        <td><?= $sr++; ?></td>
                                        <td><a target="_blank" href="<?php echo base_url('uploadDocuments/viewDocument/showDeletedFiles/' . url_encryption($deleted_doc['doc_id'])); ?>">
                                                <?php echo_data($deleted_doc['doc_title']); ?>
                                                <img src="<?= base_url('assets/images/pdf.png') ?>"> <br />
                                                <?php echo_data($deleted_doc['doc_hashed_value']); ?></a>
                                        </td>
                                        <td><?= date('d-m-Y H:i:s', strtotime($deleted_doc['uploaded_on'])) ?></td>
                                        <td><?= date('d-m-Y H:i:s', strtotime($deleted_doc['deleted_on'])) ?></td>
                                        <td><?= htmlentities($deleted_doc['page_no'], ENT_QUOTES); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>
            <!-- end : To show previously submitted and deleted petition while re-filing -->
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#datatable-responsive').DataTable();
    });
    $('#datatable-responsive1').DataTable();
    function DocDeleteAction(value) {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        // var a = confirm("Are you sure that you really want to delete this record ?");
        var a = confirm("Once a document is deleted, index of that document will also be deleted. Do you really want to delete?");
        if (a == true) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('uploadDocuments/DefaultController/deletePDF'); ?>",
                data: {
                    CSRF_TOKEN: CSRF_TOKEN_VALUE,
                    form_submit_val: value
                },
                success: function(result) {
                    var resArr = result.split('@@@');
                    if (resArr[0] == 1) {
                        $('#msg').show();
                        $(".form-response").html("<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                    } else if (resArr[0] == 2) {
                        $(".form-response").html("<p class='message valid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>");
                        $('#msg').show();
                        location.reload();
                    }
                    $.getJSON("<?php echo base_url() . 'csrftoken'; ?>", function(result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                },
                error: function(result) {
                    $.getJSON("<?php echo base_url() . 'csrftoken'; ?>", function(result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                }
            });
        }
    }
    
</script>