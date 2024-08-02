@extends('responsive_variant.layouts.master.uikit_scutum_2.index')

@section('title', 'My Cases')
@section('heading', 'My Cases')
@section('pinned-main-offcanvas') @endsection
@section('content-container-ribbon')@endsection

@section('content')


<?php
$advocate_id = $this->session->userdata['login']['adv_sci_bar_id'];
$advocate_cases_response_str = file_get_contents(ICMIS_SERVICE_URL.'/ConsumedData/getAdvocateCases/?advocateIds[]='.$advocate_id);
//var_dump( $advocate_cases_response_str);
$adv_cases_response = json_decode($advocate_cases_response_str);
// var_dump($adv_cases_response);
$adv_Cases = $adv_cases_response->data;
    $fgc_context=array(
        'http' => array(
            'user_agent' => 'Mozilla',
        ),
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );
    if(isset($advocate_id) && !empty($advocate_id)){
        $from_date=date("Y-m-d", strtotime("-3 months"));
        $to_date=date('Y-m-d');
        $my_cases_recently_updated_str = file_get_contents(ICMIS_SERVICE_URL.'/ConsumedData/getAdvocateCases/?advocateIds[]='.$advocate_id.'&status=P&filingDateRange='.$from_date.'%20to%20'.$to_date.'');
        $my_cases_recently_response = json_decode($my_cases_recently_updated_str);
        $my_cases_recently_updated = $my_cases_recently_response->data;
        $rop_judgment_request_params = [];
        $rop_judgment_request_params['documentType'] = 'rop-judgment';
        $rop_judgment_request_params['diaryIds'] = array_column($my_cases_recently_updated, 'diaryId');
        $rop_judgment_response = json_decode(curl_get_contents(ICMIS_SERVICE_URL.'/ConsumedData/getCaseDocuments?'.http_build_query($rop_judgment_request_params)));
        $rop_judgments = $rop_judgment_response->data;
        $previousOrder = array();
        if(isset($rop_judgments) && !empty($rop_judgments)){
            foreach ($rop_judgments as  $k=>$v){
                $previousOrder[$v->diaryId] = $v->fileUri.'@@@@@'.$v->dated;
            }
        }
    }
?>

<div uk-filter="target: .js-filter">
    <table id='myTable' class="uk-table uktable-justify uktable-striped uk-table-hover uk-table-divider">
        <thead>
        <tr class="uk-text-bold">
            <th class="uk-text-bold d-print-none">#</th>
            <th class="uk-text-bold">Diary / Reg. No.</th>
            <th class="uk-text-bold">Cause Title</th>
            <th class="uk-text-bold">Status</th>
            <th class="uk-text-bold d-print-none uk-table-expand"></th>
            <th class="uk-text-bold d-print-none uk-table-expand">...</th>
        </tr>
        </thead>

        <div class="uk-grid-small uk-grid-divider uk-child-width-auto" uk-grid>
            <div>
                <ul class="uk-subnav uk-subnav-pill" uk-margin>
                    <li class="uk-active" uk-filter-control><a href="#">All Cases</a></li>
                </ul>
            </div>
            <div>
                <ul class="uk-subnav uk-subnav-pill" uk-margin>
                    <li uk-filter-control="filter: [data-color='P']; group: data-color"><a href="#">Pending</a></li>
                    <li uk-filter-control="filter: [data-color='D']; group: data-color"><a href="#">Disposed</a></li>
                </ul>
            </div>
            <div>
                <ul class="uk-subnav uk-subnav-pill" uk-margin>
                    <li uk-filter-control="filter: [data-size='P']; group: size"><a href="#">Appearing for Petitioner</a></li>
                    <li uk-filter-control="filter: [data-size='R']; group: size"><a href="#">Appearing for Respondent</a></li>
                    <li uk-filter-control="filter: [reg-st='R']; group: st"><a href="#">Registered Cases</a></li>
                    <li uk-filter-control="filter: [reg-st='U']; group: st"><a href="#">Unregistered Cases</a></li>
                    <li uk-filter-control="filter: [listed-g='L']; group: g"><a href="#">Listed Cases</a></li>
                    <!--<li uk-filter-control="filter: [listed-g='UL']; group: g"><a href="#"> Cases never Listed</a></li>-->
                    <!--  <li uk-filter-control="filter: [listed-gap='Y']; group: gp"><a href="#">Listed Cases (last 30 days)</a></li>
                     <li uk-filter-control="filter: [listed-gap='N']; group: gp"><a href="#"> Cases not listed( last 30 days)</a></li>
                    -->
                </ul>
            </div>
        </div>

        <tbody class="js-filter ">
        <?php
        $i=0;

        foreach($adv_Cases as $list){
            $i++;
            /* if($list->lastListedOn <> null)
             {
                 $curdate=new DateTime(date('Y-m-d'));
                 $lstdate=new DateTime($list->lastListedOn);
                 $interval=$date_diff($curdate,$lstdate);
                 if($interval <= 30)
                 {
                     $v='Y';
                 }
                 else
                 {
                     $v='N';
                 }*/


            ?>

            <!--<tr data-color="<?php /*echo $list->status;*/?>" data-size="<?php /*echo $list->partyDetails[0]->petRes;  */?>" reg-st="<?php /* if($list->registrationNumber =='') { echo 'U' ;} else {echo 'R';}*/?>"  listed-g="<?php /* if($list->lastListedOn ==null) { echo 'UL' ;} else {echo 'L';}*/?>"  >-->
            <tr data-color="<?php echo $list->status;?>" data-size="<?php echo $list->advocateType;  ?>" reg-st="<?php  if($list->registrationNumber =='') { echo 'U' ;} else {echo 'R';}?>"  listed-g="<?php  if($list->lastListedOn ==null) { echo 'UL' ;} else {echo 'L';}?>"  >

                <td><?php echo $i; ?></td>
                <td>
                    <span class="uk-text-muted"><?php echo $list->diaryId;?></span>
                    <br>
                    <?php echo $list->registrationNumber;?>
                </td>
                <td>
                    <?php
                    if($list->advocateType =='P')
                    {
                        ?>
                        <br>  <b class="uk-background-primary md-color-grey-50" style="padding:0.05rem 0.2rem 0.2rem 0.2rem;" uk-tooltip="">P:</b>
                        &nbsp;<?php echo $list->petitionerName; ?>
                    <?php   }
                    else
                    {?>
                        <br><b> P:</b>&nbsp;<?php echo $list->petitionerName; ?>
                    <?php } ?>
                    <?php
                    if($list->advocateType =='R' or $list->advocateType == 'I')
                    {?> <br>  <b class="uk-background-primary md-color-grey-50" style="padding:0.05rem 0.2rem 0.2rem 0.2rem;" uk-tooltip="HARIHAR PRASAD">R:</b>
                        &nbsp;<?php echo $list->respondentName; ?>
                        <?php
                    }
                    else { ?> <br><b>R:</b>&nbsp;<?php echo $list->respondentName; ?><?php  } ?>

                    <BR>
                    <span class="uk-label uk-background-muted uk-text-muted" style="text-transform: none;">Draft</span>
                    </BR>
                </td>
                <td width="10%"><?php  if($list->status == 'P') { echo "Pending" ;} else {echo "Disposed";}?></td>
                <td>

                    <a onClick="open_citation_box(this.id)" uk-icon = "icon:file-edit"  href="#" title="Add citation" id="<?php  echo $list->diaryId; ?>"></a>&nbsp;&nbsp
                    <a uk-icon = "icon:file-text" onClick="open_notes_box(this.id)"  href="#"  title="Add Notes" title="Add notes" id="<?php  echo $list->diaryId; ?>"></a>&nbsp;&nbsp
                    <a onClick="open_contact_box(this.id)" uk-icon = "icon:receiver"   href="#"  title="Add contact"  id="<?php  echo $list->diaryId; ?>"></a>&nbsp;&nbsp

                    <!--<a uk-icon = "icon:whatsapp" id="<?php /*  echo $list->diaryId.'-'.$list->registrationNumber.'-'.$list->petitionerName.'-'.$list->respondentName; */?>"   href="#" onClick="whatsapp_openWin(1,this.id)" style="color:green;font-weight: bold; font-size: 20px;"  title="Send Whatsapp Message"></a>&nbsp;&nbsp-->

                    <a uk-icon = "icon:mail"  href="#"  title="Send SMS" onClick="get_message_data(this.id,'mail')" id="<?php   echo $list->diaryId.'-'.$list->registrationNumber.'-'.$list->petitionerName.'-'.$list->respondentName; ?>" ></a>&nbsp;&nbsp

                </td>
                <td>
                    <button type="button" class="uk-icon-button" uk-icon="more-vertical"></button>
                    <div class="uk-padding-small md-bg-grey-700" uk-dropdown="pos:left-center;mode:click;">
                        <ul class="uknav-parent-icon uk-dropdown-nav" uk-nav>
                            <li class="uk-nav-divider uk-margin-remove text-white">File a new</li>
                            <li><a href="<?php echo base_url('case/interim_application/crud/'.$list->diaryId)?>" class="text-white uk-nav-divider uk-margin-remove"> IA</a></li>
                            <!--<li><a href="<?php /*echo base_url('case/mentioning/crud/'.$list->diaryId);*/?>" class="text-white uk-nav-divider uk-margin-remove"> Mentioning</a></li>-->
                            <li><a href="<?php echo base_url('case/document/crud/'.$list->diaryId);?>" class="text-white uk-nav-divider uk-margin-remove"> Misc. Docs</a></li>
                            <li class="uk-nav-divider uk-margin-remove text-white">View</li>
                            <?php
                            if(array_key_exists($list->diaryId,$previousOrder)) {
                                $pArr = explode('@@@@@', $previousOrder[$list->diaryId]);
                                echo '<li><a href="'.'https://main.sci.gov.in/'. $pArr[0] . '" target="_blank" class="text-white uk-nav-divider uk-margin-remove"> Previous Order (' . $pArr[1] . ')</a></li>';
                            }
                            ?>
                            <li><a href="#" class="text-white uk-nav-divider uk-margin-remove"> Paper Book (with Indexing)</a></li>
                        </ul>
                    </div>
                </td>


                <!-- code for adding citation -->


            </tr>
        <?php }  ?> </tbody> </table>
</div>

<!-- code for notes-->


<div id="notes" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title"><div id="notes_diary"></div></h2>
            <input type="hidden" id="notes_d">
        </div>
        <div class="uk-modal-body">
            <div id="add_notes_alerts"></div>

            <p><textarea id= "notes_text" rows="5" cols="80" placeholder="write your Notes here "></textarea> </p>
        </div>

        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button" >Cancel</button>
            <!-- <button class="uk-button uk-button-primary" type="button" id="save_citation">Save Citation</button>-->
            <input type="button " id="save_notes"  value="Save Notes " class="uk-button uk-button-primary" onclick="save_notes()">

        </div>
        <div id="view_notes_text"></div>

        <div id="view_notes_data"></div>

    </div>
</div>

<!-- end of code for writing notes -->
<!-- for contacts-->
<div id="contacts" uk-modal>
    <div class="uk-modal-dialog" id="view_contacts_text" align="center"><h2S> Case Contacts for Diary No. <div id="con_d"></div></h2S>
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title"> </h2><div id="con_d"></div>
            <input type="hidden" id="con_diary">
            <input type="hidden" id="contact_type">
        </div>
        <div class="uk-modal-body">
            <div id="add_contacts_alert"></div>



            <label class="radio-inline"><input type="radio" name="contact" id="new" value="1" onclick="show_contact_list(1)" checked="">New</label>
            <label class="radio-inline"><input type="radio" name="contact" id="aor" value="3" onclick="show_contact_list(2)">AOR</label>
            <div id="aor_contact" style="display:none;">
                <div>
                    <div>
                        <select name="aor_name" id="aor_name"  style="width: 50%">
                            <option>Select Contact</option>
                        </select>
                    </div>
                </div>
            </div>
            <div  align="center" id="new_contact">
                <br> <div><input type="text" placeholder="NAME" title="NAME" maxlength="30" id="name" size="50"></div>

                <br> <div><input type="text" size="50" placeholder="EMAIL ID" maxlength="30" title="EMAIL ID" id="email"></div>
                <br> <div><input type="text" size="50" placeholder="MOBILE"  maxlength="10" title="mobile" maxlength="30" id="mobile"></div>
                <br> <div><input type="text" size="50" placeholder="OTHER CONTACT" maxlength="30" title="OTHER CONTACT" id="other"></div>
                <br>  <div><input type="text" size="50" maxlength="30" placeholder="PETITONER RESPONDENT WITNESS OTHER" title="PETITONER RESPONDENT WITNESS OTHER" id="remark"></div>


            </div>

        </div><!-- end of new contact div-->
        <div id="edit_contact"></div>
        <div id="aor_contact"> </div>

        <div class="uk-modal-footer uk-text-right" id="con_footer">
            <button class="uk-button uk-button-default uk-modal-close" type="button" >Cancel</button>


            <!-- <button class="uk-button uk-button-primary" type="button" id="save_citation">Save Citation</button>-->
            <input type="button " id="add_case_contact"  value="Save Contact " class="uk-button uk-button-primary" onclick="add_case_contact()">
            <div id="contact_list"></div>
        </div>

    </div>

</div>

<!-- end of code -->
<!-- code for sending mail-->

<div id="mail" uk-modal>
    <div class="uk-modal-dialog" id="view_contacts_text" align="center"><h4> SMS CASE DETAILS <div id="mail_d"></div></h4>

        <button class="uk-modal-close-default" type="button" uk-close></button>

        <div class="uk-modal-header">
            <h2 class="uk-modal-title"><div id="contact_diary"></div></h2>
        </div>
        <div class="uk-modal-body">
            <div id="mail_msg" ></div>

            <div class="mail-response" id="mail_msg" ></div>
            <div id="emailids" style="display: none;"></div>

            <div  id="recipient_mail1"></div>
            To: <input type="text" size="60" id="recipient_mail" name="recipient_mail"  maxlength="250" placeholder="Recipient's mail">
            <!--  <p>( For more than one recipient, type comma after each email(Max 5 email ID) )</p>-->

            <div>
                Subject: <input type="text"  size =50 id="mail_subject" name="mail_subject" class="form-control" maxlength="100" placeholder="eMail Subject">

            </div>
            <br>
            Body:<div id ='caseinfomsg'></div>

            <div id ='caseinfosms'></div>



            <div class="col-md-12 col-sm-12 col-xs-12" id="recipient_mob1"></div>

            <div id="mail_message"></div>


        </div><!-- end of new contact div-->

        <div class="uk-modal-footer uk-text-right" id="con_footer">
            <button class="uk-button uk-button-default uk-modal-close" type="button" >Cancel</button>


            <!-- <button class="uk-button uk-button-primary" type="button" id="save_citation">Save Citation</button>-->
            <input type="button " id="send_mail"  value="Send SMS " class="uk-button uk-button-primary" onclick="send_mail()">
            <div id="m_contact_list"></div>
        </div>

    </div>




    <!-- end of code for sending mail-->

    <!-- code for citation-->




    <div id="citations" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title"><div id="cit_diary"></div></h2>
                <input type="hidden" id="citdiary">
            </div>
            <div class="uk-modal-body">
                <div id="add_citation_alerts"></div>

                <p><textarea id= "citation_text" rows="5" cols="80" placeholder="write your citation here "></textarea> </p>
            </div>


            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button" >Cancel</button>
                <!-- <button class="uk-button uk-button-primary" type="button" id="save_citation">Save Citation</button>-->
                <input type="button " id="save_citation"  value="Save Citation " class="uk-button uk-button-primary" onclick="save_citation()">

            </div>
            <div id="view_citation_text"></div>

            <div   id="view_citation_data"></div>

        </div>
    </div>

    <!-- end of code for writing citation -->

    <script type="text/javascript">


        /*   function updateTextArea(id,email_checked) {
       alert("this is inbulitsdh");
            var email='';
            if (email_checked.checked==true)) {
            alert('checked');
             var  email = $('#email_' + id).val();
             alert(email);
            }
            if(email_checked.checked==false) {
              var uncheck =$('#email_' + id).val();
            }
             $('#emailids').append(email + ',');
               var em = $('#emailids').html();

              var emailid = $('#emailids').html();
              $('#recipient_mail').val(emailid);

            }*/
        function send_mail()
        {
            var caseinfomsg=document.getElementById('caseinfosms').innerHTML;
            var recipient_mail=$('#recipient_mail').val();
            var mail_subject=$('#mail_subject').val();
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('mycases/citation_notes/send_sms_and_mail'); ?>",
                data: {recipient_mail:recipient_mail,case_details_mail:caseinfomsg,mail_subject:mail_subject},
                beforeSend: function () {
                },
                success: function (data) {
                    var resArr = data.split('@@@');
                    if (resArr[0] == 1) {
                        $('#mail_msg').show();
                        document.getElementById('mail_msg').innerHTML="<p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p>";
                    } else if (resArr[0] == 2) {

                        $('#mail_msg').show();
                        document.getElementById('mail_msg').innerHTML="<h4><p class='message invalid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + "  <span class='close' onclick=hideMessageDiv()>X</span></p></h4>";

                        //  $('#mail_response').show();
                        //$('#mail_div_hide').hide();
                        setTimeout(function () {
                            $('#mail_msg').hide();
                            UIkit.modal('#mail').toggle();
                            //    window.location.href = '<?php echo current_url(); ?>';
                        }, 5000);
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
        }

        function get_message_data(id, type)

        {
            document.getElementById('emailids').innerHTML='';
            UIkit.modal('#mail').toggle();
            //alert(id);
            var x=id.split("-");
            var diary=x[0];
            var caseno=x[1];
            var pet_name=x[2];
            var res_name=x[3];
            //alert(diary);
            if(caseno=='')
            {
                caseno='UNREGISTERED';
            }
            var type = type;
            //   var data = $('#case_details_' + id).val();
            // var subject = $('#subject_case_details_' + id).val();
            // var data = 'dfd';
            //  document.getElementById('mail_diary').value=diary;
            document.getElementById('mail_subject').value="Case Details of Diary No. "+diary;
            //    document.getElementById('caseinfosms').hide();

            $('#caseinfosms').hide();
            document.getElementById('caseinfomsg').innerHTML="<b>Diary No. </b>"+diary +"<br><b> Registration No.</b>"+ caseno +"<br><b>Cause Title. </b>"+pet_name+" VS "+res_name;
            document.getElementById('caseinfosms').innerHTML="Diary No. "+diary +" Registration No."+ caseno +"Cause Title. "+pet_name+" VS "+res_name;
            var subject = diary;
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

            $.ajax({
                type: 'POST',
                data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, subject: subject, type: type},
                url: '<?php echo base_url('mycases/citation_notes/get_recipients_mail'); ?>',
                success: function (data) {

                    var resArr = data.split('@@@');
                    $('#recipient_mail1').html(resArr[0]);
                    // $('#recipient_mob1').html(resArr[1]);

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
            if (type == 'mail') {
                $('#mail_subject').val("Case Details of Diary No " + diary);
                $('.msg_text').html(data);
                $('#case_details_mail').val(data);
            } else if (type == 'sms') {
                $('.msg_text').html(data);
                $('#case_details_sms').val(data);
            }

        }

        $('#aor_name').change(function () {

            var aor_name = $(this).val();
            var resArr = aor_name.split('#$');
            $('#name').val(resArr[0]);
            $('#mobile').val(resArr[1]);
            $('#email').val(resArr[2]);
            $('#remark').val('ADVOCATE');

        });
        function update_case_contacts(contact_id) {
            var dno=$('#con_diary').val();
            var cid=contact_id;
            var name=$('#p_name').val();
            var email_id=$('#p_email_id').val();
            var mobile_no=$('#p_mobile_no').val();
            var o_contact=$('#p_o_contact').val();
            var contact_type=$('#p_contact_type').val();

            $.ajax({
                type: "POST",
                url: '<?php echo base_url('mycases/citation_notes/update_case_contacts'); ?>',
                data: {contact_id:cid,diary_no:dno,name:name,email_id:email_id,mobile_no:mobile_no,o_contact:o_contact,contact_type:contact_type},
                success: function (data) {

                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                        var resArr = data.split('@@@');

                        if (resArr[0] == 2) {
                            alert(resArr[1]);
                            $('#edit_contact').hide();
                            $('#new_contact').show();
                            $('#con_footer').show();
                            $('#contact_list').show();
                            get_contact_details(dno);

                            //  $('#edit_contact').show();
                            //  document.getElementById('edit_contact').innerHTML=resArr[1];
                        } else if (resArr[0] == 1) {
                            alert(resArr[1]);    }
                    });
                },
                error: function (result) {
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                }
            });
        }
        function get_aor_contact_list() {

            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

            $.ajax({
                type: "POST",
                url: '<?php echo base_url('mycases/citation_notes/aor_contact_list'); ?>',
                data: {CSRF_TOKEN: CSRF_TOKEN_VALUE},
                success: function (data) {
                    // $('#aor_name').show();
                    $('#aor_name').html(data);


                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                },
                error: function (result) {
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                }
            });
        }
        function get_contacts(contact_id) {

            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

            $.ajax({
                type: "POST",
                url: '<?php echo base_url('mycases/citation_notes/case_contact'); ?>',
                data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, id: contact_id},
                success: function (data) {

                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                        var resArr = data.split('@@@');

                        if (resArr[0] == 2) {

                            $('#new_contact').hide();
                            $('#con_footer').hide();
                            $('#contact_list').show();
                            $('#edit_contact').show();
                            document.getElementById('edit_contact').innerHTML=resArr[1];
                        } else if (resArr[0] == 1) {
                            alert(resArr[1]);    }
                    });
                },
                error: function (result) {
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                }
            });
        }

        function get_contact_details(cnr_number) {

            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $("#getCodeModal").remove();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('mycases/citation_notes/get_contact_list'); ?>',
                data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, cnr_number: cnr_number},
                success: function (data) {

                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                        var resArr = data.split('@@@');

                        if (resArr[0] == 2) {

                            document.getElementById('contact_list').innerHTML=resArr[1];
                            $('#contact_list').show();

                        } else if (resArr[0] == 1) {
                            alert(resArr[1]);     }
                    });
                },
                error: function (result) {
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                }
            });
        }

        function add_case_contact()
        {



            var diary_no=$('#con_diary').val();
            var name=$('#name').val();
            var email_id=$('#email').val();
            var mobile_no=$('#mobile').val();
            var o_contact=$('#other').val();
            var contact_type=$('#remark').val();

            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

            $.ajax({
                type: "POST",
                data: {diary_no:diary_no,name:name,email_id:email_id,mobile_no:mobile_no,o_contact:o_contact,contact_type:contact_type},
                url: "<?php echo base_url('mycases/citation_notes/add_case_contact'); ?>",
                success: function (data) {
                    //$("#add_contact_model").modal("hide");
                    var resArr = data.split('@@@');
                    if (resArr[0] == 2) {


                        alert(resArr[1]);

                        $('#name').val('');
                        $('#email').val('');
                        $('#mobile').val('');
                        $('#other').val('');
                        $('#remark').val('');
                        get_contact_details(diary_no);

                    } else if (resArr[0] == 1) {
                        alert(resArr[1]);

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


        function show_contact_list(element) {
            if (element == 1) {
                $('#aor_contact').hide();
                document.getElementById('contact_type').value=element;
                $('#new_contact').show();
            } else if (element == 2) {
                document.getElementById('contact_type').value=element;

                $('#aor_contact').show();
                get_aor_contact_list();
            }

        }

        function save_notes() {

            var temp = document.getElementById('notes_text').value;
            var diary_no = $('#notes_d').val();
            //  alert(diary_no);

            if (temp) {
                if (temp.length > 500) {
                    $('#add_notes_alerts').html('<div class="alert alert-danger">Maximum length 500 allowed.</div>');
                } else {
                    $('#notes_description').val($('.editor-notes').html());
                    var form_data = $(this).serialize();
                    var CSRF_TOKEN = 'CSRF_TOKEN';
                    var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();

                    $.ajax({
                        type: "POST",
                        data:{dno:diary_no,temp:temp},
                        url: "<?php echo base_url('mycases/citation_notes/add_notes_mycases'); ?>",
                        success: function (data) {
                            var resArr = data.split('@@@');
                            getCitation_n_NotesDetails(diary_no, 2);
                            if (resArr[0] == 2) {
                                //  $("#add_notes_modal").modal("hide");
                                alert("Notes Added Successully");
                                getCitation_n_NotesDetails(diary_no, 2);


                            } else if (resArr[0] == 1) {
                                alert(resArr[0]);   }

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
            } else {
                $('#add_notes_alerts').html('<div class="alert alert-danger">Write Notes Details.</div>');
            }
        } // end of save notes function

        function open_citation_box(id)
        {
            //  alert(id);
            document.getElementById('cit_diary').innerHTML="Write Citation Details for Diary no "+id;
            document.getElementById('citdiary').value=id;
            document.getElementById('view_citation_text').innerHTML='';
            document.getElementById('view_citation_data').innerHTML='';

            UIkit.modal('#citations').toggle();
        }
        function open_mail_box(id)
        {
            //alert(id);
            /*document.getElementById('cit_diary').innerHTML="Write Citation Details for Diary no "+id;
            document.getElementById('citdiary').value=id;
            document.getElementById('view_citation_text').innerHTML='';
            document.getElementById('view_citation_data').innerHTML='';*/
            document.getElementById('mail_d').innerHTML=id;
            UIkit.modal('#mail').toggle();
        }

        function open_contact_box(id)
        {
            document.getElementById('con_diary').value=id;
            document.getElementById('con_d').innerHTML=id;
            $('#new_contact').show();
            $('#edit_contact').hide();
            $('#aor_contact').hide();
            //  alert(id);
            /* document.getElementById('cit_diary').innerHTML="Write Citation Details for Diary no "+id;
             document.getElementById('citdiary').value=id;
             document.getElementById('view_citation_text').innerHTML='';
             document.getElementById('view_citation_data').innerHTML='';*/

            UIkit.modal('#contacts').toggle();
        }
        function open_notes_box(id)
        {
            // alert(id);

            document.getElementById('notes_diary').innerHTML="Write Notes Details for Diary no "+id;
            document.getElementById('notes_d').value=id;
            document.getElementById('view_notes_text').innerHTML='';
            document.getElementById('view_notes_data').innerHTML='';

            UIkit.modal('#notes').toggle();
        }
        function whatsapp_openWin(id,val) {
            var x=val.split("-");
            var diary=x[0];
            var caseno=x[1];
            var pet_name=x[2];
            var res_name=x[3];
            //alert(diary);
            if(caseno=='')
            {
                caseno='unregistered';
            }
            var whatsapp_message ="Diary No. "+diary +" Registration No."+ caseno +"Cause Title. "+pet_name+" VS "+res_name;

            //  alert("wsthaapp function");
            var api_url = 'https://api.whatsapp.com/send?phone=&text=';
            //   var whatsapp_message = document.getElementById("whats_msgid_" + id).value;


            myWindow = window.open(api_url + whatsapp_message, "_blank", "width=800,height=600");
        }
        function closeWin() {
            myWindow.close();
        }

        function view_contact_details(diary_no) {

            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $('#add_contact_model').modal("show");
            $('.view_contact_list').html("");

            $('#diary_number').val(diary_no);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('mycases/citation_notes/view_contact_list'); ?>',
                data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, diary_no: diary_no},
                success: function (data) {

                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                        var resArr = data.split('@@@');

                        if (resArr[0] == 2) {
                            $('.view_contact_list').html(resArr[1]);
                            $('.add_diary_contact_form').hide();
                        } else if (resArr[0] == 1) {
                            $('.add_diary_contact_form').show();
                        }
                    });
                },
                error: function (result) {
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                }
            });
        }

        function save_citation()
        {
            //alert("thsdfhdks");
            // alert(document.getElementById('citdiary').value);
            var temp = document.getElementById('citation_text').value;

            //  alert(" value added is "+temp);

            if (temp) {
                if (temp.length > 500) {
                    $('#add_citation_alerts').html('<div class="alert alert-danger">Maximum length 500 allowed.</div>');
                } else {
                    // $('#citation_description').val($('.editor-citation').html());
                    var form_data = $(this).serialize();
                    var CSRF_TOKEN = 'CSRF_TOKEN';
                    var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                    //var diary_no = $('#citation_cnr_no').val();
                    var diary_no = $('#citdiary').val();
                    // alert( "diary no is "+diary_no);

                    $.ajax({
                        type: "POST",
                        data:{dno:diary_no,temp:temp},
                        url: "<?php echo base_url('mycases/citation_notes/add_citation_mycases'); ?>",
                        success: function (data) {

                            var resArr = data.split('@@@');
                            //alert(data);
                            if (resArr[0] == 2) {

                                alert(resArr[1]);
                                getCitation_n_NotesDetails(diary_no, 1);

                                //     UIkit.modal('#citations').toggle();
                                // $(".form-response").html("<p class='message valid' id='msgdiv'>&nbsp;&nbsp;&nbsp; " + resArr[1] + " <span class='close' onclick=hideMessageDiv()>X</span></p>");


                            } else if (resArr[0] == 1) {
                                alert(resArr[1]);

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
            } else {
                $('#add_citation_alerts').html('<div class="alert alert-danger">Write Citation Details.</div>');
            }
        } //  end of function
        function getCitation_n_NotesDetails(cnr_number, desc_type) {

            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $("#getCodeModal").remove();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('mycases/citation_notes/get_citation_and_notes_list'); ?>',
                data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, type: desc_type, cnr_number: cnr_number},
                success: function (data) {
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
                        var resArr = data.split('@@@');

                        //  alert(resArr[1]);
                        //  $(".view_citation_data").html(resArr[1]);

                        document.getElementById('view_citation_text').innerHTML="<b><font color ='red'>Already Added Citation</font></b>";
                        document.getElementById('view_notes_text').innerHTML="<b><font color ='red'>Already Added Notes</font></b>";

                        document.getElementById('view_citation_data').innerHTML=resArr[1];
                        document.getElementById('view_notes_data').innerHTML=resArr[1];


                    });
                },
                error: function (result) {
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                }
            });
        }
        function updateTextArea(id,email_checked) {


            // alert('hello. tis isfhdkj');
            var email='';
            if (email_checked.checked=true) {
                // alert("true");
                var  email = $('#email_' + id).val();

            }
            //  alert("email addres"+email);

            if(email_checked.checked=false) {
                alert("unchecked");
                var uncheck =$('#email_' + id).val();
            }
            $('#emailids').append(email + ',');
            var em = $('#emailids').html();


            if (em.indexOf(uncheck) != -1) {
                em = em.replace(uncheck+',', '');
                $('#emailids').html(em);
            }
            else{
                $('#emailids').html(em);
            }
            var emailid = $('#emailids').html();
            $('#recipient_mail').val(emailid);

        }
        function updatemobArea(id,mob_checked) {
            var mob='';
            if (mob_checked.is(':checked')) {
                mob = $('#mob_' + id).val();
            }
            if (mob_checked.is(':unchecked')) {
                var uncheck =$('#mob_' + id).val();

            }
            $('#mobids').append(mob + ',');
            var em = $('#mobids').html();
            if (em.indexOf(uncheck) != -1) {
                em = em.replace(uncheck+',', '');

                $('#mobids').html(em);
            }
            else{
                $('#mobids').html(em);
            }
            var mobno = $('#mobids').html();
            $('#recipient_no').val(mobno);

        }

        function delete_citation_n_notes(cino, date, type) {

            y = confirm("Are you sure want to delete ?");
            if (y == false)
            {
                return false;
            }
            //   alert(type);
            if(type=='1')
            {
                var diary_no = $('#citdiary').val();
            }
            if(type=='2')
            {
                var diary_no = $('#notes_d').val();
            }
            // alert(diary_no);
            var CSRF_TOKEN = 'CSRF_TOKEN';
            var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
            $('.modal').remove();
            $('.modal-backdrop').remove();
            $('.body').removeClass("modal-open");
            $.ajax({
                type: 'POST',
                data: {CSRF_TOKEN: CSRF_TOKEN_VALUE, cino: cino, date: date, type: type,diary_no:diary_no},
                url: '<?php echo base_url('mycases/citation_notes/delete_citation_n_notes'); ?>',
                success: function (data) {

                    $("#getCodeModal").remove();
                    var resArr = data.split('@@@');
                    if (resArr[0] == 1) {
                        $('#msg_modal').show();
                        alert( resArr[1]);
                        setTimeout(function () {
                            $('#msg_modal').hide();
                        }, 3000);
                    } else if (resArr[0] == 2) {
                        //$('#msg_modal').show();
                        alert(resArr[1]);
                        getCitation_n_NotesDetails(diary_no, 1);
                    }
                },
                error: function () {
                    $.getJSON("<?php echo base_url('csrftoken'); ?>", function (result) {
                        $('[name="CSRF_TOKEN"]').val(result.CSRF_TOKEN_VALUE);
                    });
                }
            });
        }

        $(function () {
            $('#loading-overlay').hide();
            scutum.require(['datatables','datatables-buttons'], function () {
                //    $('#myTable').DataTable();
                $('#myTable').DataTable({
                    "pageLength": 100
                });
            });

        });








    </script>
    @endsection