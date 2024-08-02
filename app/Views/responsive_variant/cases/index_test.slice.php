@extends('responsive_variant.layouts.master.uikit_scutum_2.index')
@section('title', 'My Cases')
@section('pinned-main-offcanvas') @endsection
@section('content-container-ribbon')@endsection

@section('content')
<script type="text/javascript">

    var userTypeId = "<?php echo $_SESSION['login']['ref_m_usertype_id'];?>";
</script>

<style type="text/css">
    .sci-blur-medium {
        filter: blur(4px);
        pointer-events: none;
    }
    a:hover {
        cursor:pointer;
    }
    .uk-table.uk-table-hover tbody tr:hover, .uk-table.uk-table-hover > tr:hover {
        background:#ffffff!important;
    }
    .scif:hover {
        background:#ffffff!important;
        color: #ffffff!important;
    }
    .scif {

        color: #ffffff;
    }
</style>
<?php
$adv_cases_response_data =array();
$adv_cases_response_data=$adv_cases_response->data;
$fgc_context=array(
    'http' => array(
        'user_agent' => 'Mozilla',
    ),
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);
if(isset($adv_cases_response_data) && !empty($adv_cases_response_data)){
    foreach ($adv_cases_response_data as $k=>$v){
        $userType = !empty($_SESSION['login']['ref_m_usertype_id']) ? $_SESSION['login']['ref_m_usertype_id'] : NULL;
        $v->userType = $userType;
        $adv_cases_response_data[$k] = $v;
    }
}
else{
    foreach ($sr_advocate_data as $k=>$v){
        $tmp = array();
        $userType = !empty($_SESSION['login']['ref_m_usertype_id']) ? $_SESSION['login']['ref_m_usertype_id'] : NULL;
        $tmp['userType'] = $userType;
        $tmp['diaryId'] = $v->diary_no;
        $tmp['status'] = $v->c_status;
        $tmp['registrationNumber'] = $v->reg_no_display;
        $tmp['petitionerName'] = $v->pet_name;
        $tmp['respondentName'] = $v->res_name;
        $tmp['filedOn'] = $v->createdAt;
        $tmp['assignedby'] = $v->assignedby;
        $adv_cases_response_data[] = $tmp;

    }
}

$this->load->view('case_status/case_status_view');
?>
<!-- sci start data-table List-->
<div class="uk-background-default uk-border-rounded uk-grid-medium" uk-grid>

    <div class="uk-width-expand uk-margin-medium-top uk-overflow-auto-stop">
        <h4 class="uk-heading-bullet uk-text-bold">My Cases</h4>
        <table class="uk-table uktable-justify uktable-striped uk-table-hover uk-table-divider" id="efiled-cases-table">
            <!--<table class="display" style="width:100%" id="efiled-cases-table">-->
            <thead>
            <tr class="uk-text-bold">
                <th class="uk-text-bold d-print-none">S.N.</th>
                <th class="uk-text-bold d-print-none">Appearing</th>
                <th class="uk-text-bold">Diary / Reg. No</th>
                <th class="uk-text-bold">Cause Title</th>
                <th class="uk-text-bold">Status</th>
                <th class="uk-text-bold">AssignedBy</th>
                <th class="uk-text-bold">Submitted On</th>
                <th class="uk-text-bold d-print-none">...</th>
            </tr>
            </thead>
            <?php $i=1; foreach ($adv_cases_list as $case){?>
                <tr>
                    <td width="4%"><?php echo $i++;?></td>
                    <td width="12%"><?php if($case->advocateType=='P'){ echo '<b>Petitioner</b>';}
                        if($case->advocateType=='R' || $case->advocateType=='I'){ echo '<b>Respondent</b>';}?>
                    </td>
                    <td  width="12%">
                        <a onClick="open_case_status()" title="show CaseStatus"  data-diary_no="<?php echo $case->diaryId;?>" data-diary_year="">
                            <?php echo $case->diaryId;?> <br/> <?php echo $case->registrationNumber;?>
                        </a>

                    </td>
                    <td width="14%">
                        <div>
                            <div>
                                <?php if($case->advocateType!='P'){ echo '<b>P:</b>';}?>
                                <?php if($case->advocateType=='P'){ echo '<b class="uk-background-secondary md-color-grey-50" style="padding:0.05rem 0.2rem 0.2rem 0.2rem;" uktooltip="'.$case->petitionerName.'">P:</b>';}?>
                                &nbsp; <span><?php echo $case->petitionerName;?></span>
                            </div>
                            <div>
                                <?php if($case->advocateType!='R' && $case->advocateType!='I'){ echo '<b>R:</b>';}?>
                                <?php if($case->advocateType=='R' || $case->advocateType=='I'){ echo '<b class="uk-background-primary md-color-grey-50" style="padding:0.05rem 0.2rem 0.2rem 0.2rem;" uktooltip="'.$case->respondentName.'">R:</b>';}?>
                                &nbsp;&nbsp; <span><?php echo $case->respondentName;?></span>
                                <br>
                                <?php echo $case->diaryId;?> <br> <?php echo $case->registrationNumber;?>
                            </div>
                        </div>
                    </td>
                    <td  width="12%"><?php if($case->advocateType=='P'){ echo 'Pending';}else{ echo 'Disposed';}?></td>
                    <td  width="12%"><?php if(!empty($case->assignedby)){?>
                            <span class="uk-text-muted"><?php echo $case->assignedby;?></span>
                            <br/>
                            <span class="uk-text-emphasis"><?php echo $case->filedOn;?></span>
                        <?php }?>
                    </td>
                    <td width="12%">
                        <?php if($case->userType!=19){?>
                            <a onclick="open_citation_box(this.id)" ng-click="open_citation_box(this.id)" ukicon = "icon:file-edit"   title="Add citation for advocate" id="<?php echo $case->diaryId;?>"><i class="mdi mdi-bookmark-plus sc-icon-22"></i></a>&nbsp;&nbsp;
                            <a onclick="open_notes_box(this.id)" ng-click="open_notes_box(this.id)" ukicon = "icon:file-text"  title="Add Notes" title="Add notes" id="@{{case.diaryId}}"><i class="mdi mdi-script-text sc-icon-20"></i></a>&nbsp;&nbsp;
                            <a onclick="open_contact_box(this.id)" ng-click="open_contact_box(this.id)" ukicon = "icon:receiver"    title="Add contact"  id="<?php echo $case->diaryId;?>"><i class="mdi mdi-account-plus sc-icon-22"></i></a>&nbsp;&nbsp;

                            <a onclick="whatsapp_openWin(1,this.id)" ukicon = "icon:whatsapp" id="send-whatsapp-<?php echo $case->diaryId.'-'.$case->registrationNumber.'-'.$case->petitionerName.'-'.$case->respondentName;?>"  style="color:green;font-weight: bold; font-size: 20px;"  title="Send Whatsapp Message"><i class="mdi mdi-whatsapp"></i></a>&nbsp;&nbsp;

                            <a onclick="get_message_data(this.id,'mail')" ng-click="get_message_data(this.id,'mail')" ukicon = "icon:mail"   title="Send SMS"  id="<?php echo $case->diaryId.'-'.$case->registrationNumber.'-'.$case->petitionerName.'-'.$case->respondentName.'-'.$case->status;?>" ><i class="mdi mdi-android-messages sc-icon-20"></i></a>&nbsp;&nbsp;
                                                                                                                                                                                                                                                                                                                                                             <!--mandatory background hidden area search click top header (Listed Cases)-->
                            <b class="scif"><?php if($case->lastListed==null){echo 'UL';}else{ echo 'L-C';}?></b>
                        <?php }?>

                    </td>
                    <td>
                        <?php if($case->status=='P'){?>
                            <button type="button" class="uk-icon-button" uk-icon="more-vertical"></button>
                            <div class="uk-padding-small md-bg-grey-700" uk-dropdown="pos:left-center;mode:click;">
                                <ul class="uknav-parent-icon uk-dropdown-nav"  uk-nav>
                                    <?php if($case->userType!=19){?>
                                        <li class="uk-nav-header uk-padding-remove-left text-white">File a new</li>
                                        <li><a href="<?php echo base_url('case/interim_application/crud/').$case->diaryId;?>" class="text-white uknav-divider ukmargin-remove"> IA</a></li>
                                        <li><a href="<?php echo base_url('case/mentioning/crud/').$case->diaryId;?>" class="text-white uknav-divider ukmargin-remove"> Mentioning</a></li>
                                        <li><a href="<?php echo base_url('case/document/crud/').$case->diaryId;?>" class="text-white uknav-divider ukmargin-remove"> Misc. Docs</a></li>
                                    <?php }?>
                                    <?php if($case->userType=='1'){?><li ng-if="case.userType =='1'"><a href="<?php echo base_url('case/advocate/').$case->diaryId;?>" class="text-white uknav-divider ukmargin-remove">Engage Sr. Advocate</a></li> <?php }?>
                                    <?php if($case->case_grp=='R'){?><li ng-if="case.case_grp=='R'"><a href="<?php echo base_url('case/certificate/crud/').$case->diaryId;?>" class="text-white uknav-divider ukmargin-remove"> Certificate Request</a></li> <?php }?>
                                    <li class="uk-nav-divider uk-margin-remove"></li>
                                    <li class="uk-nav-header uk-padding-remove-left uk-margin-remove-top text-white">View</li>
                                    <li><a href="" onClick="open_paper_book()" class="text-white uknav-divider ukmargin-remove" data-diary_no="<?php echo $case->diaryId;?>" data-diary_year="">
                                            Paper Book (with Indexing)</a>
                                    </li>
                                </ul>
                            </div>
                        <?php }?>
                        <!--mandatory background hidden area search click top header (Registered Cases,Unregistered Cases)-->
                        <b class="scif" ng-if="case.registrationNumber==''" >Unr</b><b class="scif" ng-if="case.registrationNumber!=''" >Reg</b>

                    </td>
                </tr>
            <?php }?>

            </tbody>
            <tfoot>
            <tr class="uk-text-bold">
                <th class="uk-text-bold d-print-none">#</th>
                <th class="uk-text-bold d-print-none">Appearing</th>
                <th class="uk-text-bold">Diary / Reg. No</th>
                <th class="uk-text-bold">Cause Title</th>
                <th class="uk-text-bold">Status</th>
                <th class="uk-text-bold">Case Details</th>
                <th class="uk-text-bold">Submitted On</th>
                <th class="uk-text-bold d-print-none">...</th>
            </tr>
            </tfoot>

        </table>
    </div>
</div>
<!--END-->

<!-- sci end data-table List-->
<section>



</section>
</div>


<!--end datatable-->


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
            SMS To: <input type="text" size="60" id="recipient_mail" name="recipient_mail"  maxlength="250" placeholder="Select Contacts or Enter Mobile No. e.g 9999999999,8888888888">
            <!--  <p>( For more than one recipient, type comma after each email(Max 5 email ID) )</p>-->

            <div>
                SMS Message: <input type="text"  size =50 id="mail_subject" name="mail_subject" class="form-control" maxlength="100" placeholder="SMS Message">

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







<!--sci start js-->
<script type="text/javascript">


    $('body').attr('ng-app','casesApp').attr('ng-controller','casesController');

    var mainApp = angular.module("casesApp", []);
    mainApp.directive('onFinishRender', function ($timeout) {
        return {
            restrict: 'A',
            link: function (scope, element, attr) {
                if (scope.$last === true) {
                    $timeout(function () {
                        scope.$emit(attr.onFinishRender);
                    });
                }
            }
        }
    });
    mainApp.directive('ngFocusModel',function($timeout){
        return {
            link:  function(scope, element, attrs){
                element.bind('click',function(){
                    $timeout(function () {
                        jQuery('[ng-model="'+attrs.ngFocusModel+'"]').focus();
                    });
                })
            }
        }
    });
    mainApp.directive('ngFocus',function($timeout){
        return {
            link:  function(scope, element, attrs){
                element.bind('click',function(){
                    $timeout(function () {
                        jQuery(attrs.setFocus).focus();
                    });
                })
            }
        }
    });
    mainApp.controller('casesController', function ($scope, $http, $filter, $interval, $compile) {

    });
    $(function () {
        ngScope = angular.element($('[ng-app="casesApp"]')).scope();

        $('.documents-widget,.my-documents-widget,.applications-widget,.defects-widget [uk-drop]').on('shown', function(){
            $('#content > *:not(#widgets-container)').addClass('sci-blur-medium');
        }).on('hidden', function(){
            $('#content > *:not(#widgets-container)').removeClass('sci-blur-medium');
        });
        scutum.require(['datatables','datatables-buttons'], function () {
            //    $('#myTable').DataTable();
            /*$('#soon-to-be-listed-cases-table').DataTable({
                "pageLength": 100
            });*/
            $('#efiled-cases-table').DataTable( {
                "bSort" : false,
                initComplete: function () {
                    this.api().columns().every( function (indexCol,thisCol) {
                        var columnIndex= [];
                        if(userTypeId && userTypeId == 19){
                            columnIndex[0] = 4;
                        }
                        else{
                            columnIndex[0] = 1;
                            columnIndex[1] = 4;
                        }
                        //console.log(this.context[0].aoColumns[this.selector.cols].sTitle);

                        if($.inArray( this.selector.cols, columnIndex )!== -1){
                            var column = this;
                            var select = $('<select class="uk-select"><option value="">'+this.context[0].aoColumns[this.selector.cols].sTitle+'?</option></select>')
                                .appendTo( $(column.header()).empty() )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search( val ? '^'+val+'$' : '', true, false )
                                        .draw();
                                } );
                            column.data().unique().sort().each( function ( d, j ) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                        }
                    } );
                }
            } );
        });
    });
</script>

<!--sci end js-->
@endsection