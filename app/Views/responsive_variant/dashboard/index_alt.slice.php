@extends('responsive_variant.layouts.master.uikit_scutum_2.index')
@section('title', 'Dashboard')
@section('pinned-main-offcanvas') @endsection
@section('content-container-ribbon')@endsection

@section('content')
<script type="text/javascript">
    if(window.name.endsWith("-iframe")){
        parent.window.location.href=window.location.href;
    }
    var userTypeId = "<?php echo $_SESSION['login']['ref_m_usertype_id'];?>";
</script>
<!--<ul class="sc-list-messages">
    <li class="scmessage-unreaded">
        <div class="sc-message-card">
            <div clas="uk-flex uk-flex-middle sc-message-head uk-grid-collapse uk-grid" data-uk-grid="">
                <div class="uk-flex uk-flex-middle uk-margin-right uk-first-column">
                    <div class="sc-icheckbox"><input type="checkbox" id="mailbox-check-message_ghXOYFGJzpRo" class="sc-js-item-check sc-js-group-1" data-sc-icheck="" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;"></ins></div>
                </div>
                <div class="uk-flex-1 uk-text-truncate">
                    <h2 class="sc-message-title uk-text-truncate" title="Nej cum ozneh af bakozor ligaf fitwidvi ihove hokohu lewzefep fo jer neffaz si bozot alecus.">Nej cum ozneh af bakozor ligaf fitwidvi ihove hokohu lewzefep fo jer neffaz si bozot alecus.</h2>
                    <span class="uk-text-small uk-text-muted">feb@luminvak.ng</span>
                </div>
                <div class="uk-visible@m">
                    <div class="sc-message-date">Thu, Feb 21st 16:41</div>
                    <div class="sc-message-actions">
                        <a href="#" class="mdi mdi-delete sc-js-message-remove" data-uk-tooltip="" title="" aria-expanded="false"></a>
                        <a href="#" class="mdi mdi-archive" data-uk-tooltip="" title="" aria-expanded="false"></a>
                        <a href="#" class="mdi mdi-email-open" data-uk-tooltip="" title="" aria-expanded="false"></a>
                    </div>
                </div>
            </div>
        </div>
    </li>
</ul>--><!--Working code for gmail hover action button like functionality in scutum-->

<style type="text/css">
    /*body div, body div:not(.defects-widget) {
        filter: blur(3px);
        pointer-events: none;
    }*/
    /*#content > *:not(#widgets-container) {*/
    .sci-blur-medium {
        filter: blur(4px);
        pointer-events: none;
    }
    a:hover {
        cursor:pointer;
    }

    /*#widgets-container [uk-drop] table tr td .show-on-hover { display:none;}
        #widgets-container [uk-drop] table tr:hover td .show-on-hover { display:inline-block;}
        #widgets-container [uk-drop] table tr td .hide-on-hover { display:inline-block;}
        #widgets-container [uk-drop] table tr:hover td .hide-on-hover { display:none;}*//*made for gmail messages like functionality to show action buttons on row hover. Not used presently since it will break the functionality for mobile users.*/
</style>
@include('case_status.case_status_view')
<?php
//$this->load->view('case_status/case_status_view');
?>
<div class="uk-width">
    <h3>Dashboard </h3>
</div>
@if(!in_array($_SESSION['login']['ref_m_usertype_id'],array(ARGUING_COUNSEL,SR_ADVOCATE)))
<div id="widgets-container" ng-init="widgets.recentDocuments.byOthers.ifVisible=true;" class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@l ukchild-width-1-4@xl ukmargin-medium-top uk-grid-medium ukflex-between" uk-grid>
    <div ng-show="widgets.recentDocuments.byOthers.ifVisible">
        <div class="uk-card-default uk-box-shadow-xlarge uk-border-rounded documents-widget" style="border-top:0.15rem dashed #ccc;">
            <div class="uk-flex-middle uk-grid-medium" style="text-decoration:none;padding:0.6rem 1.5rem 1.2rem 1rem;" uk-grid>
                <!--<div>
                    <span class="uk-label uk-label-primary sc-padding sc-padding-small-ends uk-text-bold uk-text-large">19</span>
                </div>-->
                <div class="uk-width">
                    <div>
                        <span class="uk-text-bold uk-text-primary uk-text-uppercase">Recent Documents</span>
                        <span class="uk-artice-meta uk-text-small uk-text-bold">By other parties</span>
                        <button ng-click="widgets.recentDocuments.byMe.ifVisible=true;widgets.recentDocuments.byOthers.ifVisible=false;" class="uk-button uk-float-right uk-button-small uk-text-muted uk-text-small uk-text-bold uk-button-link" style="position:relative;right:0;">#By me</button>
                    </div>

                    <div class="uk-grid-collapse uk-margin-small-top" uk-grid>
                        <span class="uk-label uk-label-primary sc-padding sc-padding-medium-ends uk-text-bold uk-text-large uk-margin-small-right" style="cursor:pointer;">{{count($recent_documents_by_others)}}</span>
                        @include('responsive_variant.dashboard.layouts.documents', ['documents' => $recent_documents_by_others])
                        @include('responsive_variant.dashboard.layouts.documents', ['documents' => $recent_documents_by_others_grouped_by_document_type->adjournment_requests,'type' => 'adjournment_requests'])
                        <span class="uk-button-text uk-grid uk-grid-collapse uk-flex-center ukmargin-small-left uk-margin-small-right" style="cursor:pointer;">
                            <b>{{count($recent_documents_by_others_grouped_by_document_type->rejoinder)}}</b>
                            <div class="uk-width"></div>
                            <span class="uk-text-muted">Rejoinder</span>
                        </span>
                        @include('responsive_variant.dashboard.layouts.documents', ['documents' => $recent_documents_by_others_grouped_by_document_type->rejoinder])
                        <span class="uk-button-text uk-grid uk-grid-collapse uk-flex-center ukmargin-small-left uk-margin-small-right" style="cursor:pointer;">
                            <b>{{count($recent_documents_by_others_grouped_by_document_type->reply)}}</b>
                            <div class="uk-width"></div>
                            <span class="uk-text-muted">Reply</span>
                        </span>
                        @include('responsive_variant.dashboard.layouts.documents', ['documents' => $recent_documents_by_others_grouped_by_document_type->reply])
                        <span class="uk-button-text uk-grid uk-grid-collapse uk-flex-center ukmargin-small-left uk-margin-small-right" style="cursor:pointer;">
                            <b>{{count($recent_documents_by_others_grouped_by_document_type->ia)}}</b>
                            <div class="uk-width"></div>
                            <span class="uk-text-muted">IA</span>
                        </span>
                        @include('responsive_variant.dashboard.layouts.documents', ['documents' => $recent_documents_by_others_grouped_by_document_type->ia])
                        <span class="uk-button-text uk-grid uk-grid-collapse uk-flex-center ukmargin-small-left" style="cursor:pointer;">
                            <b>{{count($recent_documents_by_others_grouped_by_document_type->other)}}</b>
                            <div class="uk-width"></div>
                            <span class="uk-text-muted">Other</span>
                        </span>
                        @include('responsive_variant.dashboard.layouts.documents', ['documents' => $recent_documents_by_others_grouped_by_document_type->other])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Start 2nd grid-->
    <div ng-show="widgets.recentDocuments.byMe.ifVisible">
        <div class="uk-card-default uk-box-shadow-xlarge uk-border-rounded my-documents-widget" style="border-top:0.15rem dashed #ccc;">
            <div class="uk-flex-middle uk-grid-medium" style="text-decoration:none;padding:0.6rem 1.5rem 1.2rem 1rem;" uk-grid>
                <!--<div>
                    <span class="uk-label uk-label-primary sc-padding sc-padding-small-ends uk-text-bold uk-text-large">19</span>
                </div>-->
                <div class="uk-width">
                    <div>
                        <span class="uk-text-bold uk-text-muted uk-text-uppercase">Recent Documents</span>
                        <span class="uk-artice-meta uk-text-small uk-text-bold">By me</span>
                        <button ng-click="widgets.recentDocuments.byMe.ifVisible=false;widgets.recentDocuments.byOthers.ifVisible=true;" class="uk-button uk-float-right uk-button-small uk-text-primary uk-text-small uk-text-bold uk-button-link" style="position:relative;right:0;">#By others</button>
                    </div>

                    <div class="uk-grid-collapse uk-margin-small-top" uk-grid>
                        <span class="uk-label uklabel-primary md-bg-grey-500 sc-padding sc-padding-medium-ends uk-text-bold uk-text-large uk-margin-small-right" style="cursor:pointer;">{{count($recent_documents_by_me)}}</span>
                        @include('responsive_variant.dashboard.layouts.documents', ['uk_drop_boundary' => '.my-documents-widget', 'documents' => $recent_documents_by_me])

                        @include('responsive_variant.dashboard.layouts.documents', ['uk_drop_boundary' => '.my-documents-widget', 'documents' => $recent_documents_by_me_grouped_by_document_type->other])
                        <span class="uk-button-text uk-grid uk-grid-collapse uk-flex-center ukmargin-small-left uk-margin-small-right" style="cursor:pointer;">
                            <b>{{count($recent_documents_by_me_grouped_by_document_type->rejoinder)}}</b>
                            <div class="uk-width"></div>
                            <span class="uk-text-muted">Rejoinder</span>
                        </span>
                        @include('responsive_variant.dashboard.layouts.documents', ['uk_drop_boundary' => '.my-documents-widget', 'documents' => $recent_documents_by_me_grouped_by_document_type->rejoinder])

                        <span class="uk-button-text uk-grid uk-grid-collapse uk-flex-center ukmargin-small-left uk-margin-small-right" style="cursor:pointer;">
                            <b>{{count($recent_documents_by_me_grouped_by_document_type->reply)}}</b>
                            <div class="uk-width"></div>
                            <span class="uk-text-muted">Reply</span>
                        </span>
                        @include('responsive_variant.dashboard.layouts.documents', ['uk_drop_boundary' => '.my-documents-widget', 'documents' => $recent_documents_by_me_grouped_by_document_type->reply])

                        <span class="uk-button-text uk-grid uk-grid-collapse uk-flex-center ukmargin-small-left uk-margin-small-right" style="cursor:pointer;">
                            <b>{{count($recent_documents_by_me_grouped_by_document_type->ia)}}</b>
                            <div class="uk-width"></div>
                            <span class="uk-text-muted">IA</span>
                        </span>
                        @include('responsive_variant.dashboard.layouts.documents', ['uk_drop_boundary' => '.my-documents-widget', 'documents' => $recent_documents_by_me_grouped_by_document_type->ia])
                        <span class="uk-button-text uk-grid uk-grid-collapse uk-flex-center ukmargin-small-left" style="cursor:pointer;">
                            <b>{{count($recent_documents_by_me_grouped_by_document_type->other)}}</b>
                            <div class="uk-width"></div>
                            <span class="uk-text-muted">Other</span>
                        </span>
                        @include('responsive_variant.dashboard.layouts.documents', ['uk_drop_boundary' => '.my-documents-widget', 'documents' => $recent_documents_by_me_grouped_by_document_type->other])

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End 2nd grid-->

    <!--Start 3nd grid-->
    <div>
        <div class="uk-card-default uk-box-shadow-xlarge uk-border-rounded applications-widget" style="border-top:0.15rem dashed #ccc;">
            <div class="uk-flex-middle uk-grid-medium" style="text-decoration:none;padding:0.6rem 1.5rem 1.2rem 1rem;" uk-grid>

                <div>
                    <span class="uk-text-bold uk-text-warning uk-text-uppercase">Incomplete filings</span>
                    <span class="uk-artice-meta uk-text-small uk-text-bold">Cases / appl. filed by you</span>

                    <div class="uk-grid-collapse uk-margin-small-top" uk-grid>
                        <span class="uk-label uk-label-warning sc-padding sc-padding-medium-ends uk-text-bold uk-text-large uk-margin-small-right" style="cursor:pointer;">{{count($incomplete_applications)}}</span>

                        @include('responsive_variant.dashboard.layouts.applications', ['applications' => $incomplete_applications])

                        <span class="uk-button-text uk-grid uk-grid-collapse uk-flex-center ukmargin-small-left uk-margin-small-right" style="cursor:pointer;">
                            <b>{{count($draft_applications)}}</b>
                            <div class="uk-width"></div>
                            <span class="uk-text-muted">Draft</span>
                        </span>

                        @include('responsive_variant.dashboard.layouts.applications', ['applications' => $draft_applications])

                        <span class="uk-button-text uk-grid uk-grid-collapse uk-flex-center ukmargin-small-left uk-margin-small-right" style="cursor:pointer;">
                            <b>{{count($initially_defective_applications)}}</b>
                            <div class="uk-width"></div>
                            <span class="uk-text-muted">For Compliance</span>
                        </span>
                        @include('responsive_variant.dashboard.layouts.applications', ['applications' => $initially_defective_applications])

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End 3nd grid-->
    <!--Start 4nd grid-->

    <div class="defects-widget-container">
        <div class="uk-card-default uk-box-shadow-xlarge uk-border-rounded defects-widget" style="border-top:0.15rem dashed #ccc;">
            <div class="uk-flex-middle uk-grid-medium" style="text-decoration:none;padding:0.6rem 1.5rem 1.2rem 1rem;" uk-grid>
                <div>
                    <span class="uk-text-bold uk-text-danger uk-text-uppercase">Scrutiny Status</span>
                    <span class="uk-artice-meta uk-text-small uk-text-bold">Of cases / appl. filed by you</span>

                    <div class="uk-grid-collapse uk-margin-small-top" uk-grid>
                        <span class="sc-padding sc-padding-medium-ends uk-text-bold uk-text-large uk-margin-small-right" >&nbsp;</span>

                        <span class="uk-button-text uk-grid  uk-grid-collapse uk-flex-center ukmargin-small-left uk-margin-small-right" style="cursor:pointer;">
                            <b>{{count($defect_notified)}}</b>
                            <div class="uk-width"></div>
                            <span class="uk-text-muted">Defect Notified</span>
                        </span>
                        @include('responsive_variant.dashboard.layouts.defects', ['applications' => $defect_notified])

                        <span class="uk-button-text uk-grid uk-grid-collapse uk-flex-center ukmargin-small-left uk-margin-small-right" style="cursor:pointer;">
                            <b>{{count($pending_scrutiny)}}</b>
                            <div class="uk-width"></div>
                            <span class="uk-text-muted">Pending Scrutiny</span>
                        </span>
                        @include('responsive_variant.dashboard.layouts.defects', ['applications' => $pending_scrutiny])

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--End 4nd grid-->

</div>
@endif

@php echo $this->session->flashdata('msg'); @endphp
<div class="form-response" id="msg">
    @php
    if (isset($_SESSION['MSG']) && !empty($_SESSION['MSG'])) {
    echo $_SESSION['MSG'];
    }
    unset($_SESSION['MSG']);
    @endphp
</div>

<div class="uk-background-default uk-border-rounded uk-grid-medium" uk-grid>

    @if(!empty($scheduled_cases))
    <div class="uk-width uk-width-large@l uk-margin-medium-top uk-overflow-auto uktable-responsive">
        <h4 class="uk-heading-bullet uk-text-bold">My cases <small class="uk-text-muted">soon to be listed</small></h4>
        <table class="uk-table uktable-justify uktable-striped uk-table-hover uk-table-divider" id="soon-to-be-listed-cases-table">
            <thead>
            <tr class="uk-text-bold">
                <th class="uk-text-bold">Case</th>
                <th class="uk-text-bold">Date & Bench</th>
            </tr>
            </thead>
            <tbody>
            <?php
            //print_r($scheduled_cases);
            ?>
            @foreach($scheduled_cases as $scheduled_case)
            <tr>
                <td class="uk-width-small@m">
                    <div>
                        <span class="uk-text-muted">{{$scheduled_case->registration_number ?: ('D. No.' . $scheduled_case->diary_number . '/' . $scheduled_case->diary_year)}}</span>
                    </div>

                    <div><b>P: </b>{{ucwords(strtolower($scheduled_case->petitioner_name))}}</div>
                    <div><b>R: </b>{{ucwords(strtolower($scheduled_case->respondent_name))}}</div>

                    <!--<div>
                        <span class="uk-label uk-background-muted uk-text-primary" style="text-transform: none;font-size:11px;">{{ucwords(strtolower(str_replace(']','',str_replace('[','',$scheduled_case->meta->listing->court->listing_sub_type))))}}</span>
                    </div>-->
                </td>
                <td class="uk-table-expand" uk-margin>
                    <div>
                        <button type="button" class="sc-button uk-button-text">{{date_format(date_create($scheduled_case->meta->listing->listed_on), 'D, jS M')}}&nbsp;<i uk-icon="triangle-down"></i></button>
                        <div class="uk-padding-remove" uk-dropdown="pos:bottom-left;mode:click;">
                            <ul class="uknav-parent-icon uk-dropdown-nav" uk-nav>
                                <!--<li><a href="#"><span uk-icon="icon: file-text"></span> View in Causelist</a></li>-->

                                @if(!empty($scheduled_case->office_reports->current->uri))
                                <li class="uk-nav-divider uk-margin-remove"></li>
                                <li><a href="{{$scheduled_case->office_reports->current->uri}}" target="_blank"><span uk-icon="icon: file-pdf"></span> Office Report</a></li>
                                @endif
                                @if(!empty($scheduled_case->rop_judgments->current->uri))
                                <li class="uk-nav-divider uk-margin-remove"></li>
                                <li><a href="{{$scheduled_case->rop_judgments->current->uri}}" target="_blank"><span uk-icon="icon: file-pdf"></span> Previous Order ({{$scheduled_case->rop_judgments->current->dated}})</a></li>
                                @endif
                                <li class="uk-nav-divider uk-margin-remove"></li>
                                <li><a href="#" title="Send SMS" onClick="get_message_data(this.id)" id="<?php   echo $scheduled_case->diary_number .'#'.$scheduled_case->diary_year.'#'.$scheduled_case->registration_number.'#'.$scheduled_case->petitioner_name.'#'.$scheduled_case->respondent_name.'#'.$scheduled_case->item_number.'#'.$scheduled_case->meta->listing->court->name,'#'.date_format(date_create($scheduled_case->meta->listing->listed_on), 'D, jS M Y'); ?>"><span uk-icon="icon: comment"></span> Send SMS</a></li>
                                <?php if($scheduled_case->vc_url!=null){?><li><a href="{{$scheduled_case->vc_url}}" target="_blank"><span uk-icon="icon: file-text"></span> Join Virtual Court</a></li>
                                <?php } ?>
                                <li class="uk-nav-divider uk-margin-remove"></li>
                                <li>
                                    <!--<a href="{{base_url('case/paper_book_viewer')}}/@{{$scheduled_case->diary_id}}" target="_blank" data-diary_no="@{{$scheduled_case->diary_id}}" data-diary_year="">
                                        <span uk-icon="icon: bookmark"></span> Paper Book (with Indexing)
                                    </a>-->
                                    <!--<a href="#" onclick="javascript:loadPaperBookViewer(this);" data-paper-book-viewer-url="{{base_url("case/paper_book_viewer")}}/{{$scheduled_case->diary_id}}" target="_blank" data-diary_no="@{{$scheduled_case->diary_id}}" data-diary_year="">
                                    <span uk-icon="icon: bookmark"></span> Paper Book (with Indexing)
                                    </a>-->
                                    @if($scheduled_case->meta->listing->court->number!=1)
                                    <a href="{{base_url("case/paper_book_viewer")}}/{{$scheduled_case->diary_id}}" target="_blank" rel="noopener">
                                    <span uk-icon="icon: bookmark"></span> Paper Book (with Indexing)
                                    </a>
                                    @endif
                                    <!-- 3pdf link open for court no 1 on 19012024-- start -->
                                    @if($scheduled_case->meta->listing->court->number==1)
                                    <!--<a href="https://10.25.78.69:44434/api/digitization/case_file/{{$scheduled_case->diary_id}}/get/paper_book/categorized"  target="_blank" >
                                        <span uk-icon="icon: bookmark"></span> Paper Book (3 PDF)
                                    </a>-->
                                    <!--<a href="#" onclick="javascript:loadPaperBookViewer(this);" data-paper-book-viewer-url="{{base_url("case/3pdf_paper_book_viewer")}}/{{$scheduled_case->diary_id}}" target="_blank" data-diary_no="@{{$scheduled_case->diary_id}}" data-diary_year="">
                                    <span uk-icon="icon: bookmark"></span> Paper Book (3 PDF)
                                    </a>-->
                                    <a href="{{base_url("case/3pdf_paper_book_viewer")}}/{{$scheduled_case->diary_id}}" target="_blank" rel="noopener">
                                    <span uk-icon="icon: bookmark"></span>  Paper Book (3 PDF)
                                    </a>
                                    @endif
                                    <!-- 3pdf link open for court no 1 on 19012024-- end -->
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <span class="uk-label md-bg-grey-900" uk-tooltip="{{$scheduled_case->meta->listing->court->listing_cum_board_type . str_replace(':','.',$scheduled_case->meta->listing->court->scheduled_time)}}">{{'Item '.($scheduled_case->item_number_alt ?: $scheduled_case->item_number)}} @ {{$scheduled_case->meta->listing->court->name}}</span>
                    </div>
                    <div>
                        <small>
                            <b>Bench:</b><br>
                            {{ucwords(strtolower(implode(',<br> ', $scheduled_case->meta->listing->court->judges)))}}
                        </small>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!--<hr class="uk-divider-vertical uk-margin-small-left uk-margin-small-right uk-visible@m">-->
    @endif

    <!-- start sr advocate soon -->
    @if(!empty($sr_advocate_soon_cases))
    <div class="uk-width uk-width-large@l uk-margin-medium-top uk-overflow-auto uktable-responsive">
        <h4 class="uk-heading-bullet uk-text-bold">My cases <small class="uk-text-muted">soon to be listed</small></h4>
        <table class="uk-table uktable-justify uktable-striped uk-table-hover uk-table-divider" id="soon-to-be-listed-cases-table">
            <thead>
            <tr class="uk-text-bold">
                <th class="uk-text-bold">Case</th>
                <th class="uk-text-bold">Date & Bench</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sr_advocate_soon_cases as $sr_advocate_soon_case)
            <tr>
                <td class="uk-width-small@m">
                    <div>
                        <span class="uk-text-muted">{{$sr_advocate_soon_case->registration_number ?: ('D. No.' . $sr_advocate_soon_case->diary_number . '/' . $sr_advocate_soon_case->diary_year)}}</span>
                    </div>

                    <div><b>P: </b>{{ucwords(strtolower($sr_advocate_soon_case->petitioner_name))}}</div>
                    <div><b>R: </b>{{ucwords(strtolower($sr_advocate_soon_case->respondent_name))}}</div>

                    <!--<div>
                        <span class="uk-label uk-background-muted uk-text-primary" style="text-transform: none;font-size:11px;">{{ucwords(strtolower(str_replace(']','',str_replace('[','',$scheduled_case->meta->listing->court->listing_sub_type))))}}</span>
                    </div>-->
                </td>
                <td class="uk-table-expand" uk-margin>
                    <div>
                        <button type="button" class="sc-button uk-button-text">{{date_format(date_create($sr_advocate_soon_case->meta->listing->listed_on), 'D, jS M')}}&nbsp;<i uk-icon="triangle-down"></i></button>
                        <div class="uk-padding-remove" uk-dropdown="pos:bottom-left;mode:click;">
                            <ul class="uknav-parent-icon uk-dropdown-nav" uk-nav>
                                <!--<li><a href="#"><span uk-icon="icon: file-text"></span> View in Causelist</a></li>-->

                                @if(!empty($sr_advocate_soon_case->office_reports->current->uri))
                                <li class="uk-nav-divider uk-margin-remove"></li>
                                <li><a href="{{$sr_advocate_soon_case->office_reports->current->uri}}" target="_blank"><span uk-icon="icon: file-pdf"></span> Office Report</a></li>
                                @endif
                                @if(!empty($sr_advocate_soon_case->rop_judgments->current->uri))
                                <li class="uk-nav-divider uk-margin-remove"></li>
                                <li><a href="{{$sr_advocate_soon_case->rop_judgments->current->uri}}" target="_blank"><span uk-icon="icon: file-pdf"></span> Previous Order ({{$sr_advocate_soon_case->rop_judgments->current->dated}})</a></li>
                                @endif
                                <li class="uk-nav-divider uk-margin-remove"></li>
                                <li><a href="#" title="Send SMS" onClick="get_message_data(this.id)" id="<?php   echo $sr_advocate_soon_case->diary_number .'#'.$sr_advocate_soon_case->diary_year.'#'.$sr_advocate_soon_case->registration_number.'#'.$sr_advocate_soon_case->petitioner_name.'#'.$sr_advocate_soon_case->respondent_name.'#'.$sr_advocate_soon_case->item_number.'#'.$sr_advocate_soon_case->meta->listing->court->name,'#'.date_format(date_create($sr_advocate_soon_case->meta->listing->listed_on), 'D, jS M Y'); ?>"><span uk-icon="icon: comment"></span> Send SMS</a></li>
                                <?php if($sr_advocate_soon_case->vc_url!=null){?><li><a href="{{$sr_advocate_soon_case->vc_url}}" target="_blank"><span uk-icon="icon: file-text"></span> Join Virtual Court</a></li>
                                <?php } ?>
                                <li>
                                    <a href="#" onclick="javascript:loadPaperBookViewer(this);" data-paper-book-viewer-url="{{base_url("case/paper_book_viewer")}}/{{$sr_advocate_soon_case->diary_id}}" targe="_blank" data-diary_no="@{{$sr_advocate_soon_case->diary_id}}" data-diary_year="">
                                    <span uk-icon="icon: bookmark"></span> Paper Book (with Indexing)
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <span class="uk-label md-bg-grey-900" uk-tooltip="{{$sr_advocate_soon_case->meta->listing->court->listing_cum_board_type . str_replace(':','.',$sr_advocate_soon_case->meta->listing->court->scheduled_time)}}">{{'Item '.($sr_advocate_soon_case->item_number_alt ?: $sr_advocate_soon_case->item_number)}} @ {{$sr_advocate_soon_case->meta->listing->court->name}}</span>
                    </div>
                    <div>
                        <small>
                            <b>Bench:</b><br>
                            {{ucwords(strtolower(implode(',<br> ', $sr_advocate_soon_case->meta->listing->court->judges)))}}
                        </small>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!--<hr class="uk-divider-vertical uk-margin-small-left uk-margin-small-right uk-visible@m">-->
    @endif
    <!-- end sr advocate soon -->

    <!-- start sr advocate data -->
    @if(!empty($sr_advocate_data))
    <div class="uk-width-expand uk-margin-medium-top uk-overflow-hidden">
        <h4 class="uk-heading-bullet uk-text-bold">My Cases <small class="uk-text-muted">assigned by AOR</small></h4>
        <table class="uk-table uktable-justify uktable-striped uk-table-hover uk-table-divider" id="efiled-cases-table">
            <thead>
            <tr class="uk-text-bold">
                <th class="uk-text-bold d-print-none">#</th>
                <th class="uk-text-bold">Case Number</th>
                <th class="uk-text-bold">Cause Title</th>
                <th class="uk-text-bold" style="width: 90px;">Status</th>
                <th class="uk-text-bold">Engaged By/Date</th>
                <th class="uk-text-bold">Paper Book</th>
                <!--                <th class="uk-text-bold d-print-none">...</th>-->
            </tr>
            </thead>
            <?php
            $n=1;
            if(isset($sr_advocate_data['details']) && !empty($sr_advocate_data['details'])){
                foreach ($sr_advocate_data['details'] as $k=>$v){
                    $diary_no = !empty($v->diary_no) ? $v->diary_no : '';
                    $reg_no_display = !empty($v->reg_no_display) ? $v->reg_no_display : '';
                    $cause_title = (!empty($v->pet_name) && !empty($v->res_name))  ? ($v->pet_name.' Vs '.$v->res_name) : '';
                    $c_status = (!empty($v->c_status) && $v->c_status == 'P') ? 'Pending' : '';
                    $createdAt = !empty($v->createdAt) ? date('d/m/Y H:i:s',strtotime($v->createdAt)) : '';
                    $assignedby = !empty($v->assignedby) ? $v->assignedby : '';
                    echo '<tr>
                            <td>'.$n.'</td>
                            <td>'.$diary_no.'<br/>'.$reg_no_display.'</td>
                            <td>'.$cause_title.'</td>
                            <td>'.$c_status.'</td>
                            <td>'.$assignedby.'<br/>'.$createdAt.'</td>
                            <td>
                                       <a href="#" onclick="javascript:loadPaperBookViewer(this);" data-paper-book-viewer-url="'.base_url("case/paper_book_viewer").'/'.$diary_no.'" targe="_blank" data-diary_no="'.$diary_no.'" data-diary_year="">
                                 View
                                </a>
                            </td>
                            
                        </tr>';
                    $n++;
                }
            }
            ?>

            <!-- <a href="javaScript:void(0)" onClick="open_paper_book()" class="" data-diary_no="'.$diary_no.'" data-diary_year="">
                 View</a>-->

            </tbody>
            <tfoot>
            <tr class="uk-text-bold">
                <th class="uk-text-bold d-print-none">#</th>
                <th class="uk-text-bold">Case Number</th>
                <th class="uk-text-bold">Cause Title</th>
                <th class="uk-text-bold" style="width: 90px;">Status</th>
                <th class="uk-text-bold">Engaged By/Date</th>
                <th class="uk-text-bold">Paper Book</th>
                <!--                <th class="uk-text-bold d-print-none">...</th>-->
            </tr>
            </tfoot>
            <!--END-->
        </table>
    </div>
    @endif

    <!-- end sr advocate data -->
    <!--New-->
    @if(!in_array($_SESSION['login']['ref_m_usertype_id'],array(ARGUING_COUNSEL,SR_ADVOCATE)))
    <div class="uk-width-expand uk-margin-medium-top uk-overflow-auto">
        <h4 class="uk-heading-bullet uk-text-bold">Efiled Cases</h4>
        <table class="uk-table uktable-justify uktable-striped uk-table-hover uk-table-divider" id="efiled-cases-table">
            <!--<table class="display" style="width:100%" id="efiled-cases-table">-->
            <thead>
            <tr class="uk-text-bold">
                <th class="uk-text-bold d-print-none">S.No.</th>
                <th class="uk-text-bold ">Stage</th>
                <th class="uk-text-bold">eFiling No.</th>
                <th class="uk-text-bold">Type</th>
                <th class="uk-text-bold">Case Details</th>
                <th class="uk-text-bold">Submitted On</th>
                <th class="uk-text-bold d-print-none">...</th>
                <th class="uk-text-bold">Allocated to DA</th>
            </tr>
            </thead>
            <!--Start-->
            <?php $this->load->model('caveat/View_model');
            $i = 1; $certificate_Message='';$api_certificate_efiling_no=''; $api_certificate_request_no='';
            if(count($final_submitted_applications)>0){
                foreach ($final_submitted_applications as $re) {
                    $stages=$re->stage_id;
                    $exclude_stages_array=array(8,9,11,13,34,35,36,37);
                    /*if(in_array($re->stage_id, $exclude_stages_array)){
                        continue;
                    }*/
                    $fil_no = $reg_no = $case_details = $cnr_number = $cino = '';
                    $fil_ia_no = $reg_ia_no = $cause_title = $fil_case_no = $reg_case_no = $diary_no = $lbl_for_doc_no = $fil_misc_doc_ia_no = '';


                    $efiling_types_array = array(E_FILING_TYPE_MISC_DOCS, E_FILING_TYPE_IA,E_FILING_TYPE_MENTIONING, OLD_CASES_REFILING);
                    if ( in_array($re->ref_m_efiled_type_id, $efiling_types_array)){

                        if ($re->ref_m_efiled_type_id == E_FILING_TYPE_MISC_DOCS) {
                            $type = 'Misc. Docs';
                            $lbl_for_doc_no = '<b>Misc. Doc. No.</b> : ';
                            //$redirect_url = base_url('miscellaneous_docs/DefaultController');
                            $redirect_url = base_url('case/document/crud_registration');
                            $recheck_url = 'case/document/crud_registration';
                        } elseif($re->ref_m_efiled_type_id == E_FILING_TYPE_IA) {
                            $type = 'Interim Application';
                            $lbl_for_doc_no = '<b>IA Diary No.</b> : ';
                            //$redirect_url = base_url('IA/DefaultController');
                            $redirect_url = base_url('case/interim_application/crud_registration');
                            $recheck_url = 'case/interim_application/crud_registration';
                        }elseif($re->ref_m_efiled_type_id == E_FILING_TYPE_MENTIONING){
                            $type = 'Mentioning';
                            $lbl_for_doc_no = '';
                            $redirect_url = base_url('case/mentioning');
                        } elseif($re->ref_m_efiled_type_id == E_FILING_TYPE_CITATION){
                            $type = 'Citation';
                            $lbl_for_doc_no = '';
                            //$redirect_url = base_url('citation/DefaultController');
                            $redirect_url = base_url('case/citation');
                        }
                        elseif($re->ref_m_efiled_type_id == E_FILING_TYPE_CAVEAT){
                            $type = 'Caveat';
                            $lbl_for_doc_no = '';
                            $redirect_url = base_url('caveat');
                        }
                        elseif($re->ref_m_efiled_type_id == OLD_CASES_REFILING){
                            $type = 'Old Case Refiling';
                            $lbl_for_doc_no = '';
                            $redirect_url = base_url('case/refile_old_efiling_cases/crud_registration');
                        }

                        if ($re->loose_doc_no != '' && $re->loose_doc_year != '') {
                            $fil_misc_doc_ia_no = $lbl_for_doc_no . escape_data($re->loose_doc_no) . ' / ' . escape_data($re->loose_doc_year) . '<br/> ';
                        } else {
                            $fil_misc_doc_ia_no = '';
                        }

                        if ($re->diary_no != '' && $re->diary_year != '') {
                            $diary_no = '<b>Diary No.</b> : ' . escape_data($re->diary_no) . ' / ' . escape_data($re->diary_year) . '<br/> ';
                        } else {
                            $diary_no = '';
                        }

                        if ($re->reg_no_display != '') {
                            $reg_no = '<b>Registration No.</b> : ' . escape_data($re->reg_no_display) . '<br/> ';
                        } else {
                            $reg_no = '';
                        }

                        $case_details = $fil_ia_no . '<b>Filed In</b> <br>' . $diary_no . $reg_no . $re->cause_title;
                        if ($diary_no != '') {
                            $case_details= '<a onClick="open_case_statusStop()"  href=""  title="show CaseStatus"  data-diary_no="'.$re->diary_no.'" data-diary_year="'.$re->diary_year.'">'.$case_details.'</a>';
                        }
                    }
                    elseif ($re->ref_m_efiled_type_id == E_FILING_TYPE_NEW_CASE) {
                        $type = 'New Case';
                        $cause_title = escape_data(strtoupper($re->ecase_cause_title));
                        $cause_title = str_replace('VS.', '<b>Vs.</b>', $cause_title);
                        if ($re->sc_diary_num != '') {
                            $diary_no = '<b>Diary No.</b> : ' . escape_data($re->sc_diary_num).'/'.escape_data($re->sc_diary_year). '<br/> ';
                        } else {
                            $diary_no = '';
                        }
                        if ($re->reg_no_display != '') {
                            $reg_no = '<b>Registration No.</b> : ' . escape_data($re->sc_display_num) . '<br/> ';
                        } else {
                            $reg_no = '';
                        }
                        $case_details =  $diary_no . $reg_no . $cause_title;
                        if ($diary_no != '') {
                            $case_details= '<a onClick="open_case_statusStop()"  href=""  title="show CaseStatus"  data-diary_no="'.$re->sc_diary_num.'" data-diary_year="'.$re->sc_diary_year.'">'.$case_details.'</a>';
                        }
                        //$redirect_url = base_url('newcase/defaultController');
                        $recheck_url = 'case/crud';
                        $redirect_url = base_url('case/crud');
                    }
                    //caveat
                    elseif ($re->ref_m_efiled_type_id == E_FILING_TYPE_CAVEAT) {

                        $efiling_civil_data = $this->View_model->get_efiling_civil_details($re->registration_id);
                        $type = 'Caveat';

                        $caveat_no =''; $caveator_name =''; $caveatee_name =''; $caveator_name_vs_caveatee_name =''; $caveator_details =''; $caveatee_details ='';
                        if (!empty($efiling_civil_data)) {
                            if(isset($efiling_civil_data[0]['orgid']) && !empty($efiling_civil_data[0]['orgid']) && $efiling_civil_data[0]['orgid'] != 'I'){
                                $org_dept_name=!empty($efiling_civil_data[0]['org_dept_name'])? '<br/>Department Name : '.$efiling_civil_data[0]['org_dept_name'].'':'';
                                $org_post_name=!empty($efiling_civil_data[0]['org_post_name'])? 'Post Name : '.$efiling_civil_data[0]['org_post_name'].'':'';
                                $org_state_name=!empty($efiling_civil_data[0]['org_state_name'])? 'State Name : '.$efiling_civil_data[0]['org_state_name']:'';
                                $caveator_details =$org_dept_name.$org_post_name.$org_state_name;
                                if (!empty($caveator_details)){$caveator_details=' <b>(</b>'.$caveator_details.'<b>)</b>';}
                            }

                            if(isset($efiling_civil_data[0]['resorgid']) && !empty($efiling_civil_data[0]['resorgid']) && $efiling_civil_data[0]['resorgid'] != 'I'){
                                $res_org_dept_name=!empty($efiling_civil_data[0]['res_org_dept_name'])? '<br/>Department Name : '.$efiling_civil_data[0]['res_org_dept_name'].'':'';
                                $res_org_post_name=!empty($efiling_civil_data[0]['res_org_post_name'])? 'Post Name : '.$efiling_civil_data[0]['res_org_post_name'].'':'';
                                $res_org_state_name=!empty($efiling_civil_data[0]['res_org_state_name'])? 'State Name : '.$efiling_civil_data[0]['res_org_state_name']:'';
                                $caveatee_details =$res_org_dept_name.$res_org_post_name.$res_org_state_name;
                                if (!empty($caveatee_details)){$caveatee_details=' <b>(</b>'.$caveatee_details.'<b>)</b>';}
                            }
                            if (isset($efiling_civil_data[0]['pet_name']) && !empty($efiling_civil_data[0]['pet_name'])) {
                                $caveator_name = $efiling_civil_data[0]['pet_name'];
                            } else if (isset($efiling_civil_data[0]['orgid']) && !empty($efiling_civil_data[0]['orgid']) && $efiling_civil_data[0]['orgid'] == 'D1') {
                                $caveator_name = 'State Department';
                            } else if (isset($efiling_civil_data[0]['orgid']) && !empty($efiling_civil_data[0]['orgid']) && $efiling_civil_data[0]['orgid'] == 'D2') {
                                $caveator_name = 'Central Department';
                            } else if (isset($efiling_civil_data[0]['orgid']) && !empty($efiling_civil_data[0]['orgid']) && $efiling_civil_data[0]['orgid'] == 'D3') {
                                $caveator_name = 'Other Organisation';
                            }
                            if (isset($efiling_civil_data[0]['res_name']) && !empty($efiling_civil_data[0]['res_name'])) {
                                $caveatee_name = $efiling_civil_data[0]['res_name'];
                            } else if (isset($efiling_civil_data[0]['resorgid']) && !empty($efiling_civil_data[0]['resorgid']) && $efiling_civil_data[0]['resorgid'] == 'D1') {
                                $caveatee_name = 'State Department';
                            } else if (isset($efiling_civil_data[0]['resorgid']) && !empty($efiling_civil_data[0]['resorgid']) && $efiling_civil_data[0]['resorgid'] == 'D2') {
                                $caveatee_name = 'Central Department';
                            } else if (isset($efiling_civil_data[0]['resorgid']) && !empty($efiling_civil_data[0]['resorgid']) && $efiling_civil_data[0]['resorgid'] == 'D3') {
                                $caveatee_name = 'Other Organisation';
                            }
                            $caveator_name_vs_caveatee_name = $caveator_name .$caveator_details. '<b> Vs. </b>' . $caveatee_name .$caveatee_details. '<br/> ';
                            if (isset($re->caveat_num) && !empty($re->caveat_num)
                                && isset($re->caveat_num) && !empty($re->caveat_num)) {
                                $caveat_no = '<b>Filed In</b><br/><b>Caveat No.</b> : ' . $re->caveat_num . ' / ' . $re->caveat_num . '<br/> ';
                            }
                        }
                        //$cause_title = escape_data(strtoupper($re->pet_name));
                        $cause_title = escape_data(strtoupper($caveator_name_vs_caveatee_name));
                        if ($re->sc_diary_num != '') {
                            $diary_no = '<b>Diary No.</b> : ' . escape_data($re->sc_diary_num).'/'.escape_data($re->sc_diary_year). '<br/> ';
                        } else {
                            $diary_no = '';
                        }
                        if ($re->reg_no_display != '') {
                            $reg_no = '<b>Registration No.</b> : ' . escape_data($re->sc_display_num) . '<br/> ';
                        } else {
                            $reg_no = '';
                        }
                        $case_details =  $caveat_no.$diary_no . $reg_no . $cause_title;
//                    if ($diary_no != '') {
//                        $case_details = '<a href="#">' . $case_details . '</a>';
//                    }
                        $recheck_url = 'case/caveat/crud';
                        $redirect_url = base_url('case/caveat/crud');
                    }
                    //Certificate
                    elseif($re->ref_m_efiled_type_id == E_FILING_TYPE_CERTIFICATE_REQUEST){

                        $api_certificate_str = file_get_contents(API_PRISON . '/certificate_status_efile/'.$re->efiling_no);
                        $api_certificate = json_decode($api_certificate_str);
                        $api_certificateData=$api_certificate->result;
                        $api_certificate_efiling_no=$api_certificateData->efiling_no;
                        $api_certificate_request_no=$api_certificateData->request_no;

                        //echo '<pre>'; print_r($api_certificateData);// exit;
                        $type = 'Certificate';
                        $lbl_for_doc_no = '';
                        if (!empty($api_certificate_efiling_no)){
                            $redirect_url ='';
                            //$redirect_url = base_url('case/certificate/'.$re->registration_id);
                        }else{ $redirect_url ='';}

                        if ($re->diary_no != '' && $re->diary_year != '') {
                            $diary_no = '<b>Diary No.</b> : ' . escape_data($re->diary_no) . ' / ' . escape_data($re->diary_year) . '<br/> ';
                        } else {
                            $diary_no = '';
                        }

                        if ($re->reg_no_display != '') {
                            $reg_no = '<b>Registration No.</b> : ' . escape_data($re->reg_no_display) . '<br/> ';
                        } else {
                            $reg_no = '';
                        }

                        $case_details = $fil_ia_no . '<b>Filed In</b> <br>' . $diary_no . $reg_no . $re->cause_title;
                        if ($diary_no != '') {
                            $case_details= '<a onClick="open_case_statusStop()"  href=""  title="show CaseStatus"  data-diary_no="'.$re->diary_no.'" data-diary_year="'.$re->diary_year.'">'.$case_details.'</a>';
                        }
                    }
                    ?>

                    <tr>
                        <td width="4%" class="sorting_1" tabindex="0"><?php echo $i++;  '-'.$stages;?> </td>
                        <td><?php  if (!empty($api_certificate_efiling_no) && $re->ref_m_efiled_type_id == E_FILING_TYPE_CERTIFICATE_REQUEST){
                                echo $re->user_stage_name; //echo $certificate_Message;
                            }else{
                                echo $re->user_stage_name;
                            }

                            ?>
                        </td>

                        <!--------------------Pending Acceptence-------------------------->
                        <?php
                        $arrayStage= array(Initial_Approaval_Pending_Stage,Initial_Defects_Cured_Stage,TRASH_STAGE);
                        /*if ($stages == Initial_Approaval_Pending_Stage) {*/
                        $case_details= '<a onClick="open_case_statusStop()"  href="#"  title="show CaseStatus"  data-diary_no="'.$re->diary_no.'" data-diary_year="'.$re->diary_year.'">'.$case_details.'</a>';
                        if (in_array($stages,$arrayStage)) {
                            ?>
                            <td width="14%">
                                <a href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . Initial_Approaval_Pending_Stage)) ?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES) . $allocated ?></a></td>
                            <td  width="12%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                            <td><?php echo $case_details; ?></td>
                            <td width="12%"><?php echo htmlentities(date("d/m/Y h.i.s A", strtotime($re->activated_on, ENT_QUOTES))); ?></td>
                            <td>&nbsp;</td>
                        <?php } ?>

                        <!--------------------Draft------------------>

                        <?php
                        if ($stages == Draft_Stage) {
                            ?>

                            <td width="14%"><?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES) . $allocated; ?></td>
                            <td width="12%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                            <td><?php echo $case_details; ?></td>
                            <td width="12%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                            <td width="12%">
                                <a class="form-control btn btn-success" href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . Draft_Stage)) ?>"> <?php echo htmlentities("View", ENT_QUOTES) ?></a>
                            </td>


                        <?php } ?>

                        <!--------------------For Compliance------------------>

                        <?php
                        if ($stages == Initial_Defected_Stage) {
                            ?>
                            <td  width="14%"><?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES) . $allocated; ?></td>
                            <td  width="12%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                            <td><?php echo $case_details; ?></td>
                            <td  width="12%"><?php echo htmlentities(date("d/m/Y h.i.s A", strtotime($re->activated_on, ENT_QUOTES))); ?></td>
                            <td  width="12%">
                                <!--<a class="form-control btn btn-success" href="<?/*= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . Initial_Defected_Stage)) */?>"> <?php /*echo htmlentities("Re-Submit", ENT_QUOTES) */?></a>-->
                                <a class="form-control btn btn-success" href="<?= base_url($recheck_url.'/'.url_encryption((trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . Initial_Defected_Stage))))?>"> <span class="uk-label md-bg-grey-900"><?php echo htmlentities("Re-Submit", ENT_QUOTES) ?></span></a>

                            </td>
                            </td>

                        <?php } ?>

                        <!--------------------Make Payment------------------>
                        <?php
                        if ($stages == Initial_Approved_Stage) {
                            ?>


                            <td width="14%"><?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES) . $allocated; ?></td>
                            <td width="12%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                            <td><?php echo $case_details; ?></td>
                            <td width="12%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                            <td width="14%">
                                <a class="form-control btn btn-success" href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . Initial_Approved_Stage)) ?>"> <?php echo htmlentities("Make Payment", ENT_QUOTES) ?></a>
                            </td>

                        <?php } ?>

                        <!--------------------Payment Receipts------------------>
                        <?php
                        if ($stages == Pending_Payment_Acceptance) {
                            ?>

                            <td width="14%">
                                <a class="form-control btn btn-success" href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . Pending_Payment_Acceptance)) ?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES) . $allocated; ?></a>
                            </td>
                            <td  width="12%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                            <td width="12%"><?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES); ?></td>
                            <td><?php echo $case_details; ?></td>
                            <td width="12%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>


                        <?php } ?>

                        <!--------------------Pending Scrutiny------------------>
                        <?php
                        if ($stages == I_B_Approval_Pending_Stage) {
                            ?>
                            <td width="14%">
                                <a href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . I_B_Approval_Pending_Stage)) ?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES) . $allocated; ?></a>
                            </td>
                            <td width="12%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                            <td><?php echo $case_details; ?></td>
                            <td width="12%"><?php echo htmlentities(date("d/m/Y h.i.s A", strtotime($re->activated_on, ENT_QUOTES))); ?></td>
                            <td>&nbsp;</td>

                        <?php } ?>

                        <!--------------------Defective------------------>

                        <?php
                        if ($stages == I_B_Defected_Stage) {

                            if (isset($re->cnr_num) && !empty($re->cnr_num)) {
                                $cino = $re->cnr_num;
                            } elseif (isset($re->cino) && !empty($re->cino)) {
                                $cino = $re->cino;
                            }
                            ?>

                            <td width="14%"><?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES) . $allocated; ?></td>
                            <td width="12%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                            <td><?php echo $case_details; ?></td>
                            <td width="12%"><?php echo htmlentities(date("d/m/Y h.i.s A", strtotime($re->activated_on, ENT_QUOTES))); ?></td>
                            <td width="12%">
                                <a class="form-control btn btn-success" href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . I_B_Defected_Stage)) ?>"> <?php echo htmlentities("Cure Defects", ENT_QUOTES) ?></a>
                            </td>
                        <?php } ?>

                        <!--------------------E-filed Cases------------------>

                        <?php
                        if ($stages == E_Filed_Stage) {
                            ?>
                            <td width="14%">
                                <a href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . E_Filed_Stage)) ?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES); ?></a>
                            </td>
                            <td  width="12%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                            <td><?php echo $case_details; ?></td>
                            <td width="12%"><?php echo htmlentities(date("d/m/Y h.i.s A", strtotime($re->activated_on, ENT_QUOTES))); ?></td>
                            <td>&nbsp;</td>

                        <?php } ?>

                        <!--------------------E-filed Misc. Documents------------------>

                        <?php
                        if ($stages == Document_E_Filed) {
                            ?>
                            <td width="14%">
                                <a href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . Document_E_Filed)) ?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES); ?></a>
                            </td>
                            <td  width="12%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                            <td><?php echo $case_details; ?></td>
                            <td width="12%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                            <td>&nbsp;</td>

                        <?php } ?>

                        <!--------------------E-filed Misc. Documents------------------>

                        <?php
                        if ($stages == DEFICIT_COURT_FEE_E_FILED) {
                            ?>
                            <td width="14%">
                                <a href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . I_B_Rejected_Stage)) ?>"><?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES); ?></a>
                            </td>
                            <td  width="12%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                            <td><?php echo $case_details; ?></td>
                            <td width="12%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                            <td>&nbsp;</td>

                        <?php } ?>

                        <?php
                        if ($stages == I_B_Rejected_Stage) {
                            ?>
                            <td width="14%">
                                <a href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . I_B_Rejected_Stage)) ?>"><?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES); ?></a>
                            </td>
                            <td width="12%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                            <td><?php echo $case_details; ?></td>
                            <td width="12%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                            <?php if ($re->stage_id == I_B_Rejected_Stage) { ?>
                                <td width="12%"><?php echo htmlentities('Filing Section', ENT_QUOTES); ?></td>
                            <?php } elseif ($re->stage_id == E_REJECTED_STAGE) { ?>
                                <td width="12%"><?php echo htmlentities('eFiling Admin', ENT_QUOTES); ?></td>
                                <?php
                            }
                            else{
                                echo "<td>&nbsp;</td>";
                            }
                        }

                        if ($stages == DEFICIT_COURT_FEE) {
                            ?>


                            <td width="14%">
                                <?php echo efile_preview(htmlentities($re->efiling_no, ENT_QUOTES)); ?></a>
                            </td>
                            <td width="12%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                            <td><?php echo $case_details; ?></td>
                            <td width="12%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                            <td width="14%">
                                <a class="form-control btn btn-success" href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . DEFICIT_COURT_FEE)) ?>"> <?php echo htmlentities("View", ENT_QUOTES) ?></a>
                            </td>
                            <?php
                        }

                        if ($stages == LODGING_STAGE) {
                            ?>
                            <td width="14%">
                                <a href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . LODGING_STAGE)) ?>"><?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES); ?></a>
                            </td>
                            <td width="12%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                            <td><?php echo $case_details; ?></td>
                            <?php
                            if ($re->stage_id == LODGING_STAGE) {
                                $stages_name = 'Trashed (Admin)';
                            } elseif ($re->stage_id == DELETE_AND_LODGING_STAGE) {
                                $stages_name = 'Trashed and Deleted (Admin)';
                            } elseif ($re->stage_id == TRASH_STAGE) {
                                $stages_name = 'Trashed (Self)';
                            }
                            ?>
                            <td width="12%"><?php echo htmlentities($stages_name, ENT_QUOTES); ?></td>
                            <td width="12%"><?php echo htmlentities(date("d/m/Y h.i.s A", strtotime($re->activated_on, ENT_QUOTES))); ?></td>

                            <?php
                        }
                        if ($stages == IA_E_Filed) {
                            ?>
                            <td width="14%">
                                <a href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . IA_E_Filed)) ?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES); ?></a>
                            </td>
                            <td  width="12%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                            <td><?php echo $case_details; ?></td>
                            <td width="12%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                            <td>&nbsp;</td>

                        <?php } if ($stages == MENTIONING_E_FILED) {
                            ?>
                            <td width="14%">
                                <a href="<?= $redirect_url . '/' .trim($re->registration_id);?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES); ?></a>
                            </td>
                            <td  width="12%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                            <td><?php echo $case_details; ?></td>
                            <td width="12%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                            <td>&nbsp;</td>
                        <?php } if ($stages == CITATION_E_FILED) {
                            ?>
                            <td width="14%">
                                <a href="<?= $redirect_url . '/' . trim($re->registration_id); ?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES); ?></a>
                            </td>
                            <td  width="12%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                            <td><?php echo $case_details; ?></td>
                            <td width="12%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                            <td>&nbsp;</td>
                        <?php } if ($stages == CERTIFICATE_E_FILED) {
                            ?>
                            <td width="14%">
                                <!--<button class="CheckRequestCertificate btn-warning" data-scino="</?php /*echo $re->efiling_no;*/?>">Status</button>-->
                                <?php if (!empty($api_certificate_efiling_no) && $api_certificate_efiling_no==$re->efiling_no && !empty($api_certificate_request_no) && $api_certificate_request_no!=null){?>
                                    <a class="CheckRequestCertificatewwww" onClick="CheckRequestCertificate('<?php echo $api_certificate_request_no;?>')" data-scino="<?php echo $api_certificate_efiling_no;?>" data-request_no="<?php echo $api_certificate_request_no;?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES); ?></a>
                                <?php }else{?>
                                    <span class="text-black" style="color:black!important;"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES); ?></span>
                                <?php }?>
                            </td>
                            <td  width="12%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                            <td><?php echo $case_details; ?></td>
                            <td width="12%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                            <td>&nbsp;</td>
                        <?php } if(in_array($stages, $exclude_stages_array)) {
                            ?>
                            <td width="14%">
                                <a href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . I_B_Approval_Pending_Stage)) ?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>" . htmlentities($re->efiling_for_name, ENT_QUOTES) . $allocated; ?></a>
                            </td>
                            <td width="12%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                            <td><?php echo $case_details; ?></td>
                            <td width="12%"><?php echo htmlentities(date("d/m/Y h.i.s A", strtotime($re->activated_on, ENT_QUOTES))); ?></td>
                            <td>&nbsp;</td>



                        <?php } ?>

                        <?php  if($stages != Draft_Stage || $stages != TRASH_STAGE)  {
                            ?>
                            <td>
                                <?=  htmlentities($re->allocated_user_first_name, ENT_QUOTES) . " " . htmlentities($re->allocated_user_last_name, ENT_QUOTES)."(".htmlentities($re->allocayted_to_user_id, ENT_QUOTES).")<br/>".htmlentities(date("d/m/Y h.i.s A", strtotime($re->allocated_to_da_on, ENT_QUOTES)))?></a>
                            </td>

                        <?php } else { ?>
                            <td>&nbsp;&nbsp;</td> <?php } ?>
                    </tr>
                    <?php
                }
            }

            ?>
            </tbody>
            <tfoot>
            <tr class="uk-text-bold">
                <th class="uk-text-bold d-print-none">S.No.</th>
                <th class="uk-text-bold">Stage</th>
                <th class="uk-text-bold">eFiling No.</th>
                <th class="uk-text-bold">Type</th>
                <th class="uk-text-bold">Case Details</th>
                <th class="uk-text-bold">Submitted On</th>
                <th class="uk-text-bold d-print-none">...</th>
                <th class="uk-text-bold">Allocated to DA</th>
            </tr>
            </tfoot>
            <!--END-->
        </table>
    </div>
    @endif

    <!--END-->

    <!-- <div class="uk-width-expand uk-margin-medium-top uk-overflow-auto">
         <h4 class="uk-heading-bullet uk-text-bold">My cases <small class="uk-text-muted">recently updated</small></h4>
         <table class="uk-table uktable-justify uktable-striped uk-table-hover uk-table-divider">
             <thead>
             <tr class="uk-text-bold">
                 <th class="uk-text-bold d-print-none">#</th>
                 <th class="uk-text-bold">Diary / Reg. No.</th>
                 <th class="uk-text-bold">Case</th>
                 <th class="uk-text-bold">Status</th>
                 <th class="uk-text-bold d-print-none">...</th>
             </tr>
             </thead>
             <tbody>
             @foreach($my_cases_recently_updated as $my_case)
             <tr>
                 <td>{{++$sr_no}}</td>
                 <td>
                     <span class="uk-text-muted">D. No. {{substr($my_case->diaryId,0,-4)}}/{{substr($my_case->diaryId,-4)}}</span>
                     <br>
                     {{$my_case->registrationNumber}}
                 </td>
                 <td>
                     <div>
                         <div>
                             @if($my_case->advocateType=='P')
                                 <b class="uk-background-secondary md-color-grey-50" style="padding:0.05rem 0.2rem 0.2rem 0.2rem;" uk-tooltip="{{$my_case->petitionerName}}">{{$my_case->advocateType}}:</b>&nbsp;
                             @else
                                  <b>P:</b>&nbsp;
                             @endif
                             {{$my_case->petitionerName}}
                         </div>

                         <div>
                             @if($my_case->advocateType=='R')
                                 <b class="uk-background-primary md-color-grey-50" style="padding:0.05rem 0.2rem 0.2rem 0.2rem;" uk-tooltip="{{$my_case->respondentName}}">{{$my_case->advocateType}}:</b>
                             @else
                             <b>R:</b>&nbsp;
                             @endif
                             {{$my_case->respondentName}}
                         </div>
                     </div>
                     <div>
                         <span class="uk-label uk-background-muted uk-text-muted" style="text-transform: none;">
                             @if($my_case->isDefective!='0')
                                 Defective
                             @endif
                         </span>
                     </div>
                 </td>
                 <td>
                         @if($my_case->status=='P' && !empty($my_case->registrationNumber) && ($my_case->isDefective=='0'))
                             Registered
                         @else
                             Unregistered
                         @endif

                 </td>
                 <td>
                     <button type="button" class="uk-icon-button" uk-icon="more-vertical"></button>
                     <div class="uk-padding-small md-bg-grey-700" uk-dropdown="pos:left-center;mode:click;">
                         <ul class="uknav-parent-icon uk-dropdown-nav" uk-nav>
                             <li class="uk-nav-header uk-padding-remove-left text-white">File a new</li>
                             <li><a href="{{base_url('case/interim_application/crud')}}/{{$my_case->diaryId}}" class="text-white"> IA</a></li>
                             <li class="uk-nav-divider uk-margin-remove"></li>
                             <li><a href="{{base_url('case/mentioning/crud')}}/{{$my_case->diaryId}}" class="text-white"> Mentioning</a></li>
                             <li class="uk-nav-divider uk-margin-remove"></li>
                             <li><a href="{{base_url('case/document/crud')}}/{{$my_case->diaryId}}" class="text-white"> Misc. Docs</a></li>
                             <li class="uk-nav-header uk-padding-remove-left text-white">View</li>
                             @if(!empty($my_case->rop_judgments->current->uri))
                                 <li><a href="{{$my_case->rop_judgments->current->uri}}" target="_blank" class="text-white"> Previous Order ({{$my_case->rop_judgments->current->dated}})</a></li>
                             @endif
                             <li><a href="#" class="text-white"> Paper Book (with Indexing)</a></li>
                         </ul>
                     </div>
                 </td>
             </tr>
             @endforeach
             </tbody>
         </table>
     </div>-->

</div>

<!-- code for sending mail-->
<!-- Code added by Preeti Agrawal on 2 jan 2021 for sending SMS -->
<div id="mail" uk-modal>

    <div class="uk-modal-dialog" id="view_contacts_text" align="center"><h4> SMS CASE DETAILS <div id="mail_d"></div></h4>
        <input type="text" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" placeholder="csrf token">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-body">
            To: <input type="text" size="60" id="recipient_mobile_no" name="recipient_mobile_no"  maxlength="250" placeholder="Recipient's Mobile Number">
            <br>
            Message Text: <div id ='caseinfosms'></div>
        </div>
        <div class="uk-modal-footer uk-text-right" id="con_footer">
            <button class="uk-button uk-button-default uk-modal-close" type="button" >Cancel</button>
            <input type="button" id="send_sms"  value="Send SMS " class="uk-button uk-button-primary" onclick="send_sms()">
        </div>

    </div>
</div>
<!-- end of code for sending mail-->
<!-- end -->

<script type="text/javascript">

    /*Code added by Preeti Agrawal on 2 jan 2021*/

    function get_message_data(id)

    {
        UIkit.modal('#mail').toggle();
        var x=id.split("#");
        if(x[2]=='')
            document.getElementById('caseinfosms').innerHTML="Diary No. "+x[0] +"/"+x[1]+" - "+x[3]+" VS "+x[4]+" is to be listed on "+x[7] +" in "+x[6]+" as item "+x[5] +" subject to order for the day";
        else
            document.getElementById('caseinfosms').innerHTML="Case No."+x[2]  +" - "+x[3]+" VS "+x[4]+" is to be listed on "+x[7] +" in "+x[6]+" as item "+x[5] +" subject to order for the day";

    }

    function send_sms()
    {
        var CSRF_TOKEN = 'CSRF_TOKEN';
        var CSRF_TOKEN_VALUE = $('[name="CSRF_TOKEN"]').val();
        var message=document.getElementById("caseinfosms").innerHTML;
        var mobile_no=$("#recipient_mobile_no").val();
        $.ajax({
            type: "POST",
            data: {message:message, mobile_no:mobile_no,CSRF_TOKEN: CSRF_TOKEN_VALUE,},
            url: "<?php echo base_url('mycases/citation_notes/send_sms'); ?>",
            success: function (data) {

                var resArr = data.split('@@@');
                if(resArr[0]==1)
                    alert(resArr[1]);
                else if(resArr[0]==2)
                {
                    alert(resArr[1]);
                    $('#recipient_mobile_no').val('');
                    document.getElementById("caseinfosms").innerHTML='';
                    UIkit.modal('#mail').toggle();
                }
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

    /*Code end*/

    $('body').attr('ng-app','dashboardApp').attr('ng-controller','dashboardController');

    var mainApp = angular.module("dashboardApp", []);
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
    mainApp.controller('dashboardController', function ($scope, $http, $filter, $interval, $compile) {

    });
    $(function () {
        ngScope = angular.element($('[ng-app="dashboardApp"]')).scope();

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
                            columnIndex[0] = 3;
                        }
                        else{
                            columnIndex[0] = 1;
                            columnIndex[1] = 3;
                        }
                        //console.log(this.context[0].aoColumns[this.selector.cols].sTitle);

                        if($.inArray( this.selector.cols, columnIndex )!== -1){
                            var column = this;
                            var select = $('<select class="uk-select"><option value="">'+this.context[0].aoColumns[this.selector.cols].sTitle+'</option></select>')
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

@endsection
