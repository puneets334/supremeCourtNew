
<div class="col-md-12 col-sm-12 col-xs-12">
    <center><font size="6px;"> Register E-Filed IA / Misc. Documents</font></center>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Register E-Filed IA / Misc. Documents</h5>
                    <button type="button" class="close closeButton" data-dismiss="modal" data-close="1" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="customErrorMessage"></span>
                </div>
                <div class="modal-footer">
                    <button type="button"  data-close="1" class="btn btn-secondary closeButton" data-dismiss="modal">Close</button>
                    <!--                <button type="button" class="btn btn-primary">Save changes</button>-->
                </div>
            </div>
        </div>
    </div>




    <?php
    if($details['details'][0]['board_type']=='C')
        $board='Honble Chamber Court';
    elseif($details['details'][0]['board_type']=='J')
        $board='Honble Court';
    elseif($details['details'][0]['board_type']=='R')
        $board='Ld. Registrar Court';
    ?>
    <fieldset>
        <legend> Case Details</legend>
       <div class="col-md-12 col-sm-12 col-xs-12" align="center"> <label><?php if($details['details'][0]['c_status']=='P') echo '<font color=green>Case is Pending!</font>';
        elseif($details['details'][0]['c_status']=='D') echo '<font color=red>Case is Disposed!</font>';?></label>
           </div>
        <div class="col-md-12 col-sm-12 col-xs-12" align="center">
                          <label><?php if($details['details'][0]['judgment_reserved_date']!=null){
                      echo '<font color=red>Judgment is reserved for '.date('d-m-Y',strtotime($details['details'][0]['judgment_reserved_date'])) .'!</font>';?></label>
                <?php }
                elseif($details['details'][0]['next_dt']!=null && empty($case_listing_details->listed[0]->next_dt)){
                echo '<font style="color:red; font-size:14px; font-weight: bold;">Case is proposed to be listed on '.date('d-m-Y',strtotime($details['details'][0]['next_dt'])) .' in '.$board.'!</font>';?></label>
               <?php }?>
            </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-sm-1 col-md-1 col-xs-1">
                <label> Case No. :</label>
            </div>
            <div class="col-sm-4 col-md-4 col-xs-4">
        <?php if($details['details'][0]['reg_no_display']!=null){
            ?>
                <span style="color:black; font-size:14px; font-weight: bold;"> <?php echo $details['details'][0]['reg_no_display'].'@ '.$diaryno;?></span>
       <?php } else{
            $diary_number=substr($diaryno,0,-4);
            $diary_year=substr($diaryno,-4);
            ?>
                <span style="color:black; font-size:14px; font-weight: bold;"> <?php echo $diary_number.'/'.$diary_year;?></span>
    <?php  } ?>
        </div>
                <div class="col-sm-1 col-md-1 col-xs-1">
                    <label> Cause Title:</label>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-4"><span style="color:black; font-size:14px; font-weight: bold;"><?php echo $details['details'][0]['pet_name'].' Vs '.$details['details'][0]['res_name'];?> </span>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-sm-1 col-md-1 col-xs-1">
                <label> Registered On :</label>
            </div>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <?php if($details['details'][0]['active_fil_dt']!=null){
                    ?>
                    <span style="color:black; font-size:14px; font-weight: bold;"> <?php echo date('d-m-Y',strtotime($details['details'][0]['active_fil_dt']));?></span>
                <?php } ?>
            </div>
            <div class="col-sm-1 col-md-1 col-xs-1">
                <label> Alloted to:</label>
            </div>
            <div class="col-sm-4 col-md-4 col-xs-4">
            <?php if($details['details'][0]['name']!==null){?>
                <span style="color:black; font-size:14px; font-weight: bold;"><?php echo $details['details'][0]['name'].' [ '.$details['details'][0]['empid'].' ] -'.$details['details'][0]['section_name'];?> </span>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-sm-1 col-md-1 col-xs-1">
                <label> Subject Category :</label>
            </div>
            <div class="col-sm-4 col-md-4 col-xs-4">
                    <span style="color:black; font-size:14px; font-weight: bold;"> <?php echo $details['details'][0]['sub_name1'].' ('.$details['details'][0]['category_sc_old'].')';?></span>
            </div>
            <div class="col-sm-1 col-md-1 col-xs-1">
                <label> State Agency:</label>
            </div>
            <div class="col-sm-4 col-md-4 col-xs-4">
                    <span style="color:black; font-size:14px; font-weight: bold;"><?php echo $details['details'][0]['agency_state'];?> </span>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
                <?php if(isset($case_listing_details->listed[0]) && !empty($case_listing_details->listed[0])) {
                    ?>
                    <?php
                    if (strtotime($case_listing_details->listed[0]->next_dt) >= strtotime(date("Y-m-d"))) {
                        ?>
                        <span style="color:red; font-size:14px; font-weight: bold;">
                            <div class="col-sm-1 col-md-1 col-xs-1">
                                <label> Listed For :</label>
                            </div>
                            <div class="col-sm-4 col-md-4 col-xs-4">
                                <p > <?= date('d-m-Y', strtotime($case_listing_details->listed[0]->next_dt)) ?></p>
                            </div>
                        </span>
                    <?php  } else { ?>
                        <div class="col-sm-1 col-md-1 col-xs-1">
                            <label> Last Listed On :</label>
                        </div>
                        <div class="col-sm-4 col-md-4 col-xs-4">
                            <p style="color:black; font-size:14px; font-weight: bold;"> <?= date('d-m-Y', strtotime($case_listing_details->listed[0]->next_dt)) ?></p>
                        </div>
                    <?php } ?>
                <?php  } ?>
        </div>

    </fieldset>
    <?php // pr($efiling_data); die;

        //print_r($registeredDocs);
        ?>
    <fieldset>
       <legend>Documents Details</legend>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-sm-1 col-md-1 col-xs-1">
                <label> Filed By :</label>
            </div>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <span style="color:black; font-size:14px; font-weight: bold;"> <?php echo $efiling_data[0]['first_name'].'  '.$efiling_data[0]['last_name'].' ('.$efiling_data[0]['aor_code'].')';?></span>
            </div>
            <div class="col-sm-1 col-md-1 col-xs-1">
                <label> Filed On :</label>
            </div>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <span style="color:black; font-size:14px; font-weight: bold;"> <?php echo date('d-m-Y',strtotime($efiling_data[0]['uploaded_on']));?></span>
            </div>
        </div>
        <br/><br/>
        <?php //print_r($efiling_data);
        //print_r($registeredDocs);
        ?>
        <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Document Title</th>
                <th>Document No.</th>
                <th>No. of Pages</th>
                <th>View</th>
                <th>Remarks</th>
                <!--<th>Attach With</th>-->
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i=1;
            $total = count($efiling_data);
            foreach ($efiling_data as $doc){
                $doc_num ='';
                $icmis_docyear ='';
                $docnumber ='';
                //$doc_path=base_url($doc->file_path.$doc->file_name);
                $doc_path=$doc['file'];
                if(isset($doc['icmis_docnum']) && !empty($doc['icmis_docnum']) && isset($doc['icmis_docyear']) && !empty($doc['icmis_docyear'])){
                    $total--;
                    $doc_num = $doc['icmis_docnum'];
                    $icmis_docyear = $doc['icmis_docyear'];
                    $docnumber = $doc_num.' / '.$icmis_docyear;
                }
                ?>
            <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $doc['docdesc']; ?>  </td>
                <td><?php echo $docnumber; ?>  </td>
                <td><?php echo $doc['page_no']; ?>  </td>
                <td><a href="<?php echo ('https://efiling.sci.gov.in/'.$doc_path); ?>" target="_blank"> View </a></td>
                <td><textarea id="remarks_<?php echo $doc['doc_id'];?>"></textarea></td>

                <?php
                if(isset($doc_num) && !empty($doc_num)){ ?>
                    <td></td>
                    <td></td>
               <?php }
                else {

                    ?>
                    <!--<td><select id="ddlAttach_<?/*=$doc->doc_id*/?>" onchange="flipActionButton(<?/*=$doc->doc_id*/?>)">
                            <option value="" selected="selected">Select</option>
                            <?php
/*                            $attache_with_doc_title="";
                            foreach($registeredDocs as $regDoc){
                                if($doc->attached_with_doc_id==$regDoc['doc_id']){
                                    echo "<option value='".$regDoc['doc_id']."' selected='selected'>".$regDoc['docdesc']."</option>";
                                    $attache_with_doc_title=$regDoc['doc_title'];
                                }
                                else{
                                    echo "<option value='".$regDoc['doc_id']."'>".$regDoc['docdesc']."</option>";
                                }
                            }*/?>
                        </select>
                    <br><br>
                        <label class="text-danger"><?/*=$attache_with_doc_title*/?></label>
                    </td>-->
                    <td>
                        <?php
                        if(empty($doc['attached_with_doc_id'])){
                            $registerDisplay="display: block";
                            $attachDisplay="display: none";
                        }
                        else{
                            $registerDisplay="display: none";
                            $attachDisplay="display: block";
                        }
                        ?>
                        <?php
                         if(empty($doc['attached_with_doc_id'])){
                        ?>
                        <div id="divRegister_"<?=$doc['doc_id']?> sstyle="<?=$registerDisplay?>">
                        <input type="button"  id="<?php echo $doc['doc_id'];?>" value="Transfer to ICMIS" onClick="register_doc(this.id)">
                        </div>
                        <hr>
                        <div id="divAttach_"<?=$doc['doc_id']?> sstyle="<?=$attachDisplay?>">
                            <input type="button"  id="btnAttach_<?php echo $doc['doc_id'];?>" value="No Action" onClick="no_action(<?=$doc['doc_id']?>)">
                        </div>
                        <?php } else {echo "No Action";}?>
                        <!--<div id="divAttach_"<?/*=$doc->doc_id*/?> sstyle="<?/*=$attachDisplay*/?>">
                            <input type="button"  id="btnAttach_<?php /*echo $doc->doc_id;*/?>" value="Attach" onClick="attach_doc(<?/*=$doc->doc_id*/?>)">
                        </div>-->
                    </td>
                <?php
                }
                ?>

            </tr>
            <?php }?>
            </tbody>
        </table>
    <input type="hidden" name="remaining_doc" id="remaining_doc" data-remainingDoc="<?php echo $total;?>" />
    </fieldset>

</div>
      <!--start IA and MISCDUC PaymentFee by akg-->
<div class="col-sm-12">
    <a class="list-group-item" style="background: #EDEDED;" data-toggle="collapse" data-parent="#MainMenu"><?php if(!isset($payment_details) || empty($payment_details)){?><font style="color:red;"> <b>Fees Paid</b></font><?php } else{?> <b>Fees Paid</b><?php } ?></a>
     @include('shcilPayment.payment_list_view');
    </div>
      <!--end IA and MISCDUC PaymentFee-->
 
<style>
    fieldset {
        background-color: #eeeeee;
    }

    legend {
        background-color: gray;
        color: white;
        padding: 5px 10px;
    }


</style>

<script type="text/javascript">
    function flipActionButton(doc_id){
        var selected_item=$("#ddlAttach_"+doc_id).val();
        if(selected_item==""){
            /*$("#divAttach_"+doc_id).css("display", "none");
            $("#divRegister_"+doc_id).css("display", "block");*/
            $("#divAttach_"+doc_id).hide();
            $("#divRegister_"+doc_id).show();
            return false;
        }
        else {
            $("#divAttach_"+doc_id).hide();
            $("#divRegister_"+doc_id).hide();
            return false;
        }
    }
    function attach_doc(doc_id){
        diary_no='<?php echo $diaryno;?>';
        var attach_with_doc_id=$("#ddlAttach_"+doc_id).val();
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/EfilingAction/attachDoc') ?>",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE,doc_id: doc_id,diary_no:diary_no,attach_with_doc_id:attach_with_doc_id},
            cache:false,
            dataType:'json',
            ContentType: 'application/json',
            success: function(result){
                if(typeof result == 'string'){
                    result = JSON.parse(result);
                }
                $("#exampleModal").modal('show');
                if(result.status == 'SUCCESS'){
                    var message = 'Attached Successfully!';
                    $("#customErrorMessage").html('');
                    $("#customErrorMessage").html(message);
                    setTimeout(function(){
                            window.location.reload(); },
                        2000);
                }
                else{
                    var message = result.error;
                    $("#customErrorMessage").html('');
                    $("#customErrorMessage").html(message);
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
    function no_action(doc_id){
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/EfilingAction/noaction') ?>",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE,doc_id: doc_id},
            cache:false,
            dataType:'json',
            ContentType: 'application/json',
            success: function(result){
                if(typeof result == 'string'){
                    result = JSON.parse(result);
                }
                $("#exampleModal").modal('show');
                if(result.status == 'SUCCESS'){
                    var message = 'Updated Successfully!';
                    $("#customErrorMessage").html('');
                    $("#customErrorMessage").html(message);
                    setTimeout(function(){
                            window.location.reload(); },
                        2000);
                }
                else{
                    var message = result.error;
                    $("#customErrorMessage").html('');
                    $("#customErrorMessage").html(message);
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
    function register_doc(id)
    {
        diary_no='<?php echo $diaryno;?>';
        var Remarks_data=$('#remarks_'+id).val();

        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        var remaining = $("#remaining_doc").attr('data-remainingDoc');
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/EfilingAction/registerDoc') ?>",
            data: {CSRF_TOKEN: CSRF_TOKEN_VALUE,doc_id: id,diary_no:diary_no,Remarks_data:Remarks_data},
            cache:false,
            dataType:'json',
            ContentType: 'application/json',
            success: function(result){
                if(typeof result == 'string'){
                     result = JSON.parse(result);
                }

                // console.log(result);
                // return false;
                $("#exampleModal").modal('show');
                var today = new Date();
                var year = today.getFullYear();
                if(result.status == 'SUCCESS'){
                    var message = 'Document Number : '+result.doc_number+' / '+year;
                    $("#customErrorMessage").html('');
                    $("#customErrorMessage").html(message);
                    result.doc_id = id;
                    result.diary_no = diary_no;
                    result.remaining = remaining;
                    $.ajax({
                        type: "POST",
                        data: result,
                        url: "<?php echo base_url('admin/EfilingAction/updateDocumentNumber'); ?>",
                        dataType:'json',
                        ContentType: 'application/json',
                        cache:false,
                        success: function(updateData){
                            if(typeof updateData == 'string'){
                                updateData = JSON.parse(updateData);
                                var message = updateData.message;
                                if(updateData.status=='SUCCESS'){
                                    $("#customErrorMessage").html('');
                                    $("#customErrorMessage").html(message);
                                }else if(updateData.status=='ERROR'){
                                    $("#customErrorMessage").html('');
                                    $("#customErrorMessage").html(message);
                                }
                            }

                            // console.log(updateData);
                            // return false;
                             setTimeout(function(){
                                //window.location.reload();
                                     location.reload();
                                },
                                3000);
                        }
                    });
                    }
                    else{
                        var message = result.error;
                        $("#customErrorMessage").html('');
                        $("#customErrorMessage").html(message);
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
</script>