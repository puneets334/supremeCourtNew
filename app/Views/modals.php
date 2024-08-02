<?php
$pending_court_fee=empty(getPendingCourtFee())?0:getPendingCourtFee();
//echo "dd: ".$pending_court_fee; exit;
?>

<div class="modal fade" id="approveModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="fa fa-pencil"></span> Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure to Approve this E-filing number ? </p>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-default">No</a>
                <a href="<?php echo base_url('admin/efilingAction'); ?>" class="btn btn-success">Yes</a>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="transferModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="fa fa-pencil"></span> Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure to transfer this E-filing number to Sec-X? </p>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-default">No</a>
                <a href="<?php echo base_url('admin/EfilingAction/transferCase'); ?>" class="btn btn-success">Yes</a>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="disapproveModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">
                    <span class="fa fa-pencil"></span><?php echo $lbl = ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MENTIONING) ? "Write Orders" : "Write Reason to Disapprove"; ?> 
                </h4>
            </div>

            <?php
            $attribute = array('name' => 'disapp_case', 'id' => 'disapp_case', 'autocomplete' => 'off');
            if ($_SESSION['efiling_details']['ref_m_efiled_type_id'] == E_FILING_TYPE_MENTIONING) {
                echo form_open(base_url('admin/EfilingAction/submit_mentioning_order'), $attribute);
            } else {
                echo form_open(base_url('admin/EfilingAction/disapprove_case'), $attribute);
            }
            ?>
            <div class="modal-body">
                <div id="disapprove_alerts"></div>                
                <div class="clearfix"><br></div>


                <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor-one">

                    <div class="btn-group">
                        <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                        <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                    </div>

                    <div class="btn-group">
                        <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                        <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                    </div>

                    <div class="btn-group">
                        <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                        <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                        <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                        <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                    </div>

                    <div class="btn-group">
                        <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                        <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                    </div>
                </div>

                <div id="editor-one" class="editor-wrapper placeholderText disapprovedText" contenteditable="true"></div>
                <textarea name="remark" id="descr"  style="display:none;"></textarea>
                <span id="disapprove_count_word" style="float:right"></span>
                <div class="clearfix"><br></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-success" id="disapprove_me" >Submit</a>
            </div>
            <?php echo form_close(); ?>  
        </div>
    </div>
</div>
<!-- mark as error start-->
<div class="modal fade" id="markAsErrorModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">
                    <span class="fa fa-pencil"></span>Write reason to mark as error.
                </h4>
            </div>

            <?php
            $attribute = array('name' => 'mark_as_error', 'id' => 'mark_as_error', 'autocomplete' => 'off');
            echo form_open(base_url('admin/EfilingAction/markAsErrorCase'), $attribute);
            ?>
            <div class="modal-body">
                <div id="disapprove_alerts"></div>
                <div class="clearfix"><br></div>
                <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor-one">
                    <div class="btn-group">
                        <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                        <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                    </div>
                    <div class="btn-group">
                        <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                        <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                    </div>
                    <div class="btn-group">
                        <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                        <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                        <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                        <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                    </div>
                    <div class="btn-group">
                        <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                        <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                    </div>
                </div>
                <div id="editor-one" class="editor-wrapper placeholderText disapprovedText" contenteditable="true"></div>
                <textarea name="remark" id="descr"  style="display:none;"></textarea>
                <span id="disapprove_count_word" style="float:right"></span>
                <div class="clearfix"><br></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-success" id="markaserror" >Submit</a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!-- mark as error end-->
<div class="modal fade" id="DeficitCourtFeeModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <span class="fa fa-pencil"></span> Deficit Fee
                </h4>

            </div>
            <div class="modal-body">
                <?php
                $attribute = array('name' => 'deficit_court_fees', 'id' => 'deficit_court_fees', 'autocomplete' => 'off');
                echo form_open('admin/deficit_court_fees', $attribute);
                ?>
                <div class="form-group">
                    <label class="control-label col-sm-4 input-sm">Deficit Fees to be paid<span style="color: red">*</span>:</label>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <input class="form-control" name="court_fees" id="court_fees" maxlength="6" required placeholder="Enter court fee" type="text">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-info" value="Submit"  name="submit">
            </div>
            <?php echo form_close(); ?>  
        </div>
    </div>
</div>
<div class="modal fade" id="generateDiaryNoDiv" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="fa fa-pencil"></span> Check All Details </h4>

            </div>
            <div class="modal-body" id="checkAllSections">
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12" id="loader_div" style="">
            </div>
            <a data-efilingType="<?php echo strtolower($filing_type);?>" class="btn btn-primary" id="createDiaryNo" type="button" style="margin-left: 224px;margin-bottom: 23px;">Generate Diary No.</a>
        </div>

    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="padding-right: 15px;margin-left:-257px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 927px;height: 300px;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Diary Details</h5>
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


<div class="modal fade" id="holdModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="fa fa-pencil"></span> Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure to Hold this E-filing number ? </p>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-default">No</a>
                <a href="<?php echo base_url('admin/efilingAction/hold'); ?>" class="btn btn-success">Yes</a>
            </div>
        </div>

    </div>
</div>


<div class="modal fade" id="disposedModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="fa fa-pencil"></span> Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure to Disposed this E-filing number ? </p>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-default">No</a>
                <a href="<?php echo base_url('admin/efilingAction/disposed'); ?>" class="btn btn-success">Yes</a>
            </div>
        </div>

    </div>
</div>


<script>
    function get_objection(obj_id, obj_checked) {
        if (obj_checked.is(':checked')) {
            var obj = $("#obj_" + obj_id).text();
        }
        if (obj_checked.is(':unchecked')) {
            var uncheck = $("#obj_" + obj_id).text() + "<br><br>";
        }
        $('#objection_value').append(obj + "<br><br>");
        var objection = $('#objection_value').html();
        if (objection.indexOf(uncheck) != -1) {
            objection = objection.replace(uncheck, '');
            $('#objection_value').html(objection);
        } else {
            $('#objection_value').html(objection);
        }
    }
    $(document).ready(function () {
        // $(document).on("click", "#generateDiaryNoPop", function () {
        //     var sectionDetails ='';
        //     var sectionData ='';
        //     $("#checkAllSections").html('');
        //     $('ul.nav-breadcrumb li').each(function(i){
        //         i= i+1;
        //         var sectionDetails = $(this).text().trim();
        //         var sectionArr = sectionDetails.split(i);
        //         var name = sectionArr[1].trim().replace(/[-' ']/g,'_').toLowerCase();
        //         if(name == 'extra_party' || name == 'legal_representative'){
        //             sectionData +='<div class="row"><div class="col-sm-4">'+sectionDetails+'</div>' +
        //                 '<div class="col-sm-4"><input class="checkSection" type="radio" id="'+name+'" name="'+name+'" value="1"> <label for="'+name+'"> YES</label><span id="error_'+name+'"></span></div> ' +
        //                 '<div class="col-sm-2"><input  class="checkSection" type="radio" id="'+name+'1" name="'+name+'" value="0"> <label for="'+name+'1"> NO</label></div>' +
        //                 '<div class="col-sm-2"><input class="checkSection" type="radio" id="'+name+'2" name="'+name+'" value="2"> <label for="'+name+'2"> N/A</label></div></div>';
        //         }
        //         else{
        //             sectionData +='<div class="row"><div class="col-sm-4">'+sectionDetails+'</div>' +
        //                 '<div class="col-sm-4"><input class="checkSection" type="radio" id="'+name+'" name="'+name+'" value="1"> <label for="'+name+'"> YES</label><span id="error_'+name+'"></span></div> ' +
        //                 '<div class="col-sm-4"><input class="checkSection" type="radio" id="'+name+'1" name="'+name+'" value="0"> <label for="'+name+'1"> NO</label></div></div>';
        //         }
        //
        //          if(name == 'view' || name =='affirmation'){
        //          }
        //          else{
        //              $("#checkAllSections").append(sectionData);
        //          }
        //         sectionData = '';
        //     });
        // });
        // $(document).on('click','#createDiaryNo',function(){
        $(document).on('click','#generateDiaryNoPop',function(){
            var pending_court_fee='<?=$pending_court_fee?>';
            if(pending_court_fee>0){
                var court_fee_payment_details = $('#is_verified').val();
                var result = court_fee_payment_details.split('#');

                if ((result[0] ==='f' && result[1]>0 && pending_court_fee > 0)){
                    alert('Please verify court fee before generating diary number.');
                    return false;
                }
            }
            /*var court_fee_payment_details = $('#is_verified').val();
            var result = court_fee_payment_details.split('#');

            if ((result[0] ==='f' && result[1]>0 && pending_court_fee > 0)){
                alert('Please verify court fee before generating diary number.');
                return false;
            }*/
            var noError = true;
            var arr = [];
            var stepValue =[];
            var filteredData = [];
            var typeGeneration ='';
            var file_type = $(this).attr('data-efilingtype');
            // $('.checkSection').each(function(){
            //     var name = $(this).attr('name');
            //     var fieldValue =  $('input[name="'+name+'"]:checked').val();
            //     if(typeof fieldValue == 'undefined'){
            //         noError = false;
            //         arr.push(name);
            //     }
            //     else{
            //         if(fieldValue =='0'){
            //             $("#error_"+name).text('Select this field');
            //             $("#error_"+name).css( { "margin-left" : "6px", "color": "red"} );
            //             noError = false;
            //         }
            //         else{
            //             $("#error_"+name).text('');
            //             var checkObject = {};
            //             checkObject.field_name = name;
            //             checkObject.field_value=fieldValue;
            //             stepValue.push(checkObject);
            //             checkObject = {};
            //         }
            //     }
            // });
           // var arr = arr.filter(uniqueArr);
           // const  keys = ['field_name'];
           //  const  filteredData = stepValue.filter((s => o =>(k => !s.has(k) && s.add(k))
           //             (keys.map(k => o[k]).join('|')))
           //          (new Set)
           //      );
           //  if(arr){
           //      for(var i=0;i<arr.length;i++){
           //          $("#error_"+arr[i]).text('Select this field');
           //          $("#error_"+arr[i]).css( { "margin-left" : "6px", "color": "red"} );
           //          noError = false;
           //      }
           //  }

            if(file_type == 'new_case'){
                filteredData.push({field_name: "case_detail", field_value: "1"});
                filteredData.push({field_name: "petitioner", field_value: "1"});
                filteredData.push({field_name: "respondent", field_value: "1"});
                filteredData.push({field_name: "extra_party", field_value: "1"});
                filteredData.push({field_name: "legal_representative", field_value: "1"});
                filteredData.push({field_name: "act_section", field_value: "1"});
                filteredData.push({field_name: "earlier_courts", field_value: "1"});
                filteredData.push({field_name: "upload_document", field_value: "1"});
                filteredData.push({field_name: "index", field_value: "1"});
                filteredData.push({field_name: "pay_court_fee", field_value: "1"});
                typeGeneration ='diary no.';
            }
            else if(file_type == 'caveat'){
                filteredData.push({field_name: "caveator", field_value: "1"});
                filteredData.push({field_name: "caveatee", field_value: "1"});
                filteredData.push({field_name: "extra_party", field_value: "1"});
                filteredData.push({field_name: "subordinate_court", field_value: "1"});
                filteredData.push({field_name: "upload_document", field_value: "1"});
                filteredData.push({field_name: "index", field_value: "1"});
                filteredData.push({field_name: "pay_court_fee", field_value: "1"});
                typeGeneration ='caveat no.';
            }
            var conformRes =  confirm("Are you sure want to generate "+typeGeneration+" ?");
            if(noError && file_type && conformRes){
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            var postData = {CSRF_TOKEN: CSRF_TOKEN_VALUE, file_type: file_type};
            $.ajax({
                type: "POST",
                data: JSON.stringify(postData),
                url: "<?php echo base_url('newcase/Ajaxcalls/getAllFilingDetailsByRegistrationId'); ?>",
                dataType:'json',
                ContentType: 'application/json',
                cache:false,
                async: false,
                beforeSend: function() {
                    $("#loader_div").html('<img id="loader_img" style="position: fixed; left: 63%;margin-top: -164px;  margin-left: -100px;" src="<?php echo base_url('assets/images/loading-data.gif');?>">');
                    $('#createDiaryNo').append('<i class="status_refresh fa fa-refresh fa-spin"></i>');
                },
                success: function (data){
                    if(typeof data == 'string'){
                        data = JSON.parse(data);
                    }
                    // console.log(data);
                    // return false;
                    if(data){
                        $("#exampleModal").modal('show');
                        $('#generateDiaryNoDiv').modal('hide');
                        var diaryStatus ='';
                        var diaryNo = '';
                        var insertData = {};
                        var status = '';
                        var diaryData ='';
                        var alloted_to ='';
                        var insertedDocNums ='';
                        if(data.status == 'SUCCESS') {
                            diaryStatus = 'new_diary';
                            if (data.diary_no) {
                                diaryNo = data.diary_no;
                            }
                            if (data.alloted_to) {
                                alloted_to = data.alloted_to;
                            }
                            if (data.insertedDocNums) {
                                insertedDocNums = data.insertedDocNums;
                            }
                            if (data.status) {
                                status = data.status;
                            }
                            if (data.records_inserted) {
                                insertData.records_inserted = data.records_inserted;
                            }
                                insertData.diaryNo = diaryNo;
                                insertData.alloted_to = alloted_to;
                                insertData.insertedDocNums = insertedDocNums;
                                insertData.status = status;
                                insertData.selectedcheckBox = filteredData;
                                insertData.diaryStatus = diaryStatus;
                            }
                            else  if(data.status == 'ERROR_ALREADY_IN_ICMIS') {
                                var errorMessage = data.error.split(" ");
                                diaryData = errorMessage.pop();
                                diaryStatus = 'exist_diary';
                                insertData.records_inserted = {};
                                if(data.status) {
                                    status = data.status;
                                }
                                if(data.records_inserted) {
                                    insertData.records_inserted = data.records_inserted;
                                }
                                insertData.diaryNo = diaryData;
                                insertData.status = status;
                                insertData.selectedcheckBox = filteredData;
                                insertData.diaryStatus = diaryStatus;
                            }
                            else  if(data.status == 'ERROR_MAIN') {
                                $("#customErrorMessage").html('');
                                $("#customErrorMessage").html(data.error);
                                $("#customErrorMessage").css('color','green');
                                $("#customErrorMessage").css({ 'font-size': '30px' });
                                return false;
                            }
                            else if(data.status == 'ERROR_CAVEAT'){
                                $("#customErrorMessage").html('');
                                $("#customErrorMessage").html(data.error);
                                $("#customErrorMessage").css('color','green');
                                $("#customErrorMessage").css({ 'font-size': '30px' });
                                return false;
                             }
                            if(insertData){
                                if(file_type == 'new_case'){
                                    $('#createDiaryNo').html('Generate Diary No.');
                                    var errorMessage ='Diary no. generation has been successfully!';
                                }
                                else{
                                    $('#createDiaryNo').html('Generate Caveat No.');
                                    var errorMessage ='Caveat no. generation has been successfully!';
                                }
                                $("#customErrorMessage").html('');
                                $("#customErrorMessage").html(errorMessage);
                                $("#customErrorMessage").css('color','green');
                                $("#customErrorMessage").css({ 'font-size': '30px' });
                                    $.ajax({
                                        type: "POST",
                                        data: JSON.stringify(insertData),
                                        url: "<?php echo base_url('newcase/Ajaxcalls/updateDiaryDetails'); ?>",
                                        dataType:'json',
                                        ContentType: 'application/json',
                                        cache:false,
                                        beforeSend: function() {
                                            $('#createDiaryNo').append('<i class="status_refresh fa fa-refresh fa-spin"></i>');
                                        },
                                        success: function(updateData){
                                            // console.log(updateData);
                                            // return false;
                                            $("#loader_div").html('');
                                            if(updateData.success == 'success'){
                                                $("#customErrorMessage").html('');
                                                $("#customErrorMessage").html(updateData.message);
                                            }
                                            else  if(updateData.success == 'error'){
                                                $("#customErrorMessage").html('');
                                                $("#customErrorMessage").html(updateData.message);
                                            }
                                            else{
                                                $("#customErrorMessage").html('');
                                                $("#customErrorMessage").html(updateData.message);
                                            }
                                        }
                                    });
                            }

                        // else {
                        //         var errorMessage = data.error;
                        //         $("#customErrorMessage").html('');
                        //         $("#customErrorMessage").html(errorMessage);
                        //         $("#customErrorMessage").css('color','red');
                        //         $("#customErrorMessage").css({'font-size': '15px'});
                        //         $('#createDiaryNo').html('Generate Diary No.');
                        // }
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

        $(document).on('click','.closeButton',function(){
            var closeButtonAttr = $(this).attr('data-close');
            if(closeButtonAttr == 1){
                window.location.reload();
            }
        });

        $('#disapp_case input').on('change', function () {
            var checkedValue = $('input[name=crt_fee_status]:checked', '#disapp_case').val();
            $('#disapprove_alerts').hide();
            $('.change_div_color').css('background-color', '');
            if (checkedValue == '<?php echo url_encryption(3); ?>') {
                $('#def_crt_fee').focus();
                $('#def_crt_fee').attr('required', true);
                $('#def_crt_fee').attr('disabled', false);

            } else {
                $('#def_crt_fee').attr('required', false);
                $('#def_crt_fee').attr('disabled', true);
                $('#def_crt_fee').val('');
            }

        });


        $('#disapprove_me').click(function () {

            var temp = $('.disapprovedText').text();
            temp = $.trim(temp);
            var efiling_type_id = '<?php echo $_SESSION['efiling_details']['ref_m_efiled_type_id']; ?>';

            
            if (efiling_type_id  !="") {
                $('#disapprove_alerts').show();

                if (temp.length > 500) {
                    $('#disapprove_alerts').show();
                    $('#disapprove_alerts').html("<p class='message invalid' id='msgdiv'>Maximum length 500 allowed. <span class='close' onclick=hideMessageDiv()>X</span></p>");
                } else {
                    if ($('#objection_value').html() != '') {
                        $('#obj_remarks').val($('#objection_value').html());
                    }
                    $('#descr').val($('#editor-one').html());
                    $('#disapp_case').submit();
                }


            }
        });

        $('#markaserror').click(function () {
            var temp = $('.disapprovedText').text();
            temp = $.trim(temp);
            var efiling_type_id = '<?php echo $_SESSION['efiling_details']['ref_m_efiled_type_id']; ?>';
            if (efiling_type_id  !="") {
                if(temp.length == 0){
                    alert("Please fill error note.");
                    $('.disapprovedText').focus();
                    return false;
                }
                else{
                    $('#disapprove_alerts').show();
                    if (temp.length > 500) {
                        $('#disapprove_alerts').show();
                        $('#disapprove_alerts').html("<p class='message invalid' id='msgdiv'>Maximum length 500 allowed. <span class='close' onclick=hideMessageDiv()>X</span></p>");
                    } else {
                        $('textarea#descr').text($('.disapprovedText').text());
                        $('#mark_as_error').submit();
                    }
                }
            }
        });
        //update fee and send to icmis
        $(document).on('click','#transferToScrutiny',function(){
            var registration_id = $(this).attr('data-registration_id');
            if(registration_id){
                var CSRF_TOKEN = 'CSRF_TOKEN';
                var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                var postData = {CSRF_TOKEN: CSRF_TOKEN_VALUE, registration_id: registration_id};
                $.ajax({
                    type: "POST",
                    data: JSON.stringify(postData),
                    url: "<?php echo base_url('admin/EfilingAction/updateRefiledCase'); ?>",
                    dataType:'json',
                    ContentType: 'application/json',
                    cache:false,
                    beforeSend: function() {
                        $("#loader_div").html('<img id="loader_img" style="position: fixed; left: 63%;margin-top: -164px;  margin-left: -100px;" src="<?php echo base_url('assets/images/loading-data.gif');?>">');
                        $('#createDiaryNo').append('<i class="status_refresh fa fa-refresh fa-spin"></i>');
                    },
                    success: function (res){
                        if(typeof res == 'string'){
                            res = JSON.parse(res);
                        }
                        if(res.status == 'success'){
                            alert(res.message);
                            window.location.reload();
                        }
                        else{
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
    $('#disapproveModal').on('hidden.bs.modal', function (e) {
        $(this).find('form').trigger('reset');
        $('#disapprove_alerts').hide();
        $('.change_div_color').css('background-color', '');
        $('.error-tip').hide();
    });
    $('#markAsErrorModal').on('hidden.bs.modal', function (e) {
        $(this).find('form').trigger('reset');
        $('#disapprove_alerts').hide();
        $('.change_div_color').css('background-color', '');
        $('.error-tip').hide();
    });
    function uniqueArr(value, index, self) {
        return self.indexOf(value) === index;
    }
    function getAmtValue(amt)
    {
        //var regex = /^[0-9]*\.?[0-9]*$/;
        var regex = /^[0-9]*$/;
        if (regex.test(amt)) {
            return true;
        } else {
            $('#def_crt_fee').val('');
            return false;
        }
    }
</script>
<style>
    .obj_wrapper{
        min-height: 140px;
        max-height: 180px;
        background-color: #fff;
        border-collapse: separate;
        border: 1px solid #ccc;
        padding: 4px;
        box-sizing: content-box;
        box-shadow: rgba(0,0,0,.07451) 0 1px 1px 0 inset;
        overflow-y: scroll;
        outline: 0;
        border-radius: 3px;

    }

    .editor-wrapper {
        min-height: 200px !important;
        max-height: 250px;
    }
</style>