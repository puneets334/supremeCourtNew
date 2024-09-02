<?php declare(strict_types=1); ?>
@if(!in_array($_SESSION['login']['ref_m_usertype_id'],array(ARGUING_COUNSEL,SR_ADVOCATE)))
    @extends('layout.advocateApp')
@else
    @extends('layout.app')
@endif
@section('content')
<style>
    .fc-today-button {
        text-transform: capitalize !important;
    }
    #efiling-details {
        margin-top: 40px !important;
    }
    .blue-tile {
        height: 100% !important;
    }

    a .btn-primary {
        color: #fff;
    }
    li {
        list-style: none;
    }
    .fc .fc-toolbar-title {
        font-size: 1.6em !important;
    }
    .uk-modal{display:none;position:fixed;top:0;right:0;bottom:0;left:0;z-index:1010;overflow-y:auto;-webkit-overflow-scrolling:touch;padding:15px 15px;background:rgba(0,0,0,.6);opacity:0;transition:opacity .15s linear}@media (min-width:640px){.uk-modal{padding:50px 30px}}@media (min-width:960px){.uk-modal{padding-left:40px;padding-right:40px}}.uk-modal.uk-open{opacity:1}.uk-modal-page{overflow:hidden}.uk-modal-dialog{position:relative;box-sizing:border-box;margin:0 auto;width:600px;max-width:calc(100% - .01px)!important;background:#fff;opacity:0;transform:translateY(-100px);transition:.3s linear;transition-property:opacity,transform}.uk-open>.uk-modal-dialog{opacity:1;transform:translateY(0)}.uk-modal-container .uk-modal-dialog{width:1200px}.uk-modal-full{padding:0;background:0 0}.uk-modal-full .uk-modal-dialog{margin:0;width:100%;max-width:100%;transform:translateY(0)}.uk-modal-body{padding:30px 30px}.uk-modal-header{padding:15px 30px;background:#fff;border-bottom:1px solid #e5e5e5}.uk-modal-footer{padding:15px 30px;background:#fff;border-top:1px solid #e5e5e5}.uk-modal-body::after,.uk-modal-body::before,.uk-modal-footer::after,.uk-modal-footer::before,.uk-modal-header::after,.uk-modal-header::before{content:"";display:table}.uk-modal-body::after,.uk-modal-footer::after,.uk-modal-header::after{clear:both}.uk-modal-body>:last-child,.uk-modal-footer>:last-child,.uk-modal-header>:last-child{margin-bottom:0}.uk-modal-title{font-size:2rem;line-height:1.3}[class*=uk-modal-close-]{position:absolute;z-index:1010;top:10px;right:10px;padding:5px}[class*=uk-modal-close-]:first-child+*{margin-top:0}.uk-modal-close-outside{top:0;right:-5px;transform:translate(0,-100%);color:#fff}.uk-modal-close-outside:hover{color:#fff}@media (min-width:960px){.uk-modal-close-outside{right:0;transform:translate(100%,-100%)}}.uk-modal-close-full{top:0;right:0;padding:20px;background:#fff}

    .uk-text-uppercase {
        text-transform: uppercase !important;
    }
    .uk-text-small {
        font-size: 9px !important;
        line-height: 1.5;
    }
    .md-bg-grey-700 {
        background-color: #616161 !important;
    }
    .md-color-grey-50 {
        color: #fafafa !important;
    }
    .md-bg-red-700 {
        background-color: #d32f2f !important;
    }
</style>
<div class="mainPanel ">
    <div class="panelInner">
        <div class="middleContent">
            <div class="container-fluid">
                <div class="row">
                    @if(!in_array($_SESSION['login']['ref_m_usertype_id'],array(ARGUING_COUNSEL,SR_ADVOCATE)))
                        <div class="col-12 sm-12 col-md-9 col-lg-9 middleContent-left">
                    @else
                        <div class="col-12 sm-12 col-md-12 col-lg-12 middleContent-left">
                    @endif
                        <div class="left-content-inner comn-innercontent">
                            @if(!in_array($_SESSION['login']['ref_m_usertype_id'],array(ARGUING_COUNSEL,SR_ADVOCATE)))
                                <div class="dashboard-section dashboard-tiles-area">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="dashbord-tile pink-tile">
                                                <h6 class="tile-title">Recent Documents</h6>
                                                <p class="tile-subtitle">By other Parties</p>
                                                <!-- <button ng-click="widgets.recentDocuments.byMe.ifVisible=true;widgets.recentDocuments.byOthers.ifVisible=false;" class="btn btn-primary pull-right" style="margin: -55px 60px;">#By me</button> -->
                                                <h4 class="main-count">
                                                    <?php
                                                    if (isset($recent_documents_by_others) && !empty($recent_documents_by_others)) {
                                                        echo count($recent_documents_by_others);
                                                    } else {
                                                        echo '00';
                                                    }
                                                    ?>
                                                </h4>
                                                @include('responsive_variant.dashboard.layouts.documents', ['documents' => $recent_documents_by_others])
                                                @include('responsive_variant.dashboard.layouts.documents', ['documents' => $recent_documents_by_others_grouped_by_document_type->adjournment_requests,'type' => 'adjournment_requests'])
                                                <div class="tiles-comnts">
                                                    <div class="tile-comnt">
                                                        <h6 class="comts-no">
                                                            <?php
                                                            if (isset($recent_documents_by_others_grouped_by_document_type) && !empty($recent_documents_by_others_grouped_by_document_type)) {
                                                                echo count($recent_documents_by_others_grouped_by_document_type->rejoinder);
                                                            } else {
                                                                echo '00';
                                                            }
                                                            ?>
                                                        </h6>
                                                        <p class="comnt-name">Rejoinder</p>
                                                        @include('responsive_variant.dashboard.layouts.documents', ['documents' => $recent_documents_by_others_grouped_by_document_type->rejoinder])
                                                    </div>
                                                    <div class="tile-comnt">
                                                        <h6 class="comts-no">
                                                            <?php
                                                            if (isset($recent_documents_by_others_grouped_by_document_type) && !empty($recent_documents_by_others_grouped_by_document_type)) {
                                                                echo count($recent_documents_by_others_grouped_by_document_type->reply);
                                                            } else {
                                                                echo '00';
                                                            }
                                                            ?>
                                                        </h6>
                                                        <p class="comnt-name">Reply</p>
                                                        @include('responsive_variant.dashboard.layouts.documents', ['documents' => $recent_documents_by_others_grouped_by_document_type->reply])
                                                    </div>
                                                    <div class="tile-comnt">
                                                        <h6 class="comts-no">
                                                            <?php
                                                            if (isset($recent_documents_by_others_grouped_by_document_type) && !empty($recent_documents_by_others_grouped_by_document_type)) {
                                                                echo count($recent_documents_by_others_grouped_by_document_type->ia);
                                                            } else {
                                                                echo '00';
                                                            }
                                                            ?>
                                                        </h6>
                                                        <p class="comnt-name">IA</p>
                                                        @include('responsive_variant.dashboard.layouts.documents', ['documents' => $recent_documents_by_others_grouped_by_document_type->ia, 'type' => ''])
                                                    </div>
                                                    <div class="tile-comnt">
                                                        <h6 class="comts-no">
                                                            <?php
                                                            if (isset($recent_documents_by_others_grouped_by_document_type) && !empty($recent_documents_by_others_grouped_by_document_type)) {
                                                                echo count($recent_documents_by_others_grouped_by_document_type->other);
                                                            } else {
                                                                echo '00';
                                                            }
                                                            ?>
                                                        </h6>
                                                        <p class="comnt-name">Other</p>
                                                        @include('responsive_variant.dashboard.layouts.documents', ['documents' => $recent_documents_by_others_grouped_by_document_type->other])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="dashbord-tile purple-tile">
                                                <h6 class="tile-title">Incomplete Filings</h6>
                                                <p class="tile-subtitle">Cases/appl. Filed by you</p>
                                                <h4 class="main-count">
                                                    <?php
                                                    if (isset($incomplete_applications) && !empty($incomplete_applications)) {
                                                        echo count($incomplete_applications);
                                                    } else {
                                                        echo '00';
                                                    }
                                                    ?>
                                                </h4>
                                                @include('responsive_variant.dashboard.layouts.applications', ['applications' => $incomplete_applications])
                                                <div class="tiles-comnts">
                                                    <div class="tile-comnt">
                                                        <h6 class="comts-no">
                                                            <?php
                                                            if (isset($draft_applications) && !empty($draft_applications)) {
                                                                echo count($draft_applications);
                                                            } else {
                                                                echo '00';
                                                            }
                                                            ?>
                                                        </h6>
                                                        <p class="comnt-name">Draft</p>
                                                        @include('responsive_variant.dashboard.layouts.applications', ['applications' => $draft_applications])
                                                    </div>
                                                    <div class="tile-comnt">
                                                        <h6 class="comts-no">
                                                            <?php
                                                            if (isset($initially_defective_applications) && !empty($initially_defective_applications)) {
                                                                echo count($initially_defective_applications);
                                                            } else {
                                                                echo '00';
                                                            }
                                                            ?>
                                                        </h6>
                                                        <p class="comnt-name">For Compliance</p>
                                                        @include('responsive_variant.dashboard.layouts.applications', ['applications' => $initially_defective_applications])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="dashbord-tile blue-tile">
                                                <h6 class="tile-title">Scrutiny Status</h6>
                                                <p class="tile-subtitle">Cases/appl. Filed by you</p>
                                                <h4 class="main-count">&nbsp;&nbsp;</h4>
                                                <div class="tiles-comnts">
                                                    <div class="tile-comnt">
                                                        <h6 class="comts-no">
                                                            <?php
                                                            if (isset($defect_notified) && !empty($defect_notified)) {
                                                                echo count($defect_notified);
                                                            } else {
                                                                echo '00';
                                                            }
                                                            ?>
                                                        </h6>
                                                        <p class="comnt-name">Defect Notified</p>
                                                        @include('responsive_variant.dashboard.layouts.defects', ['applications' => $defect_notified])
                                                    </div>
                                                    <div class="tile-comnt">
                                                        <h6 class="comts-no">
                                                            <?php
                                                            if (isset($pending_scrutiny) && !empty($pending_scrutiny)) {
                                                                echo count($pending_scrutiny);
                                                            } else {
                                                                echo '00';
                                                            }
                                                            ?>
                                                        </h6>
                                                        <p class="comnt-name">Pending Scrutiny</p>
                                                        @include('responsive_variant.dashboard.layouts.defects', ['applications' => $pending_scrutiny])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="dashboard-section">
                                <div class="row">
                                    @if(!empty($scheduled_cases))
                                        <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="dash-card">
                                                <div class="title-sec">
                                                    <h5 class="unerline-title">My cases <small class="uk-text-muted">soon to be listed</small></h5>
                                                </div>
                                                <div class="table-sec">
                                                    <div class="table-responsive">
                                                        <table id="datatable-responsive-sc_cases" class="table table-striped custom-table">
                                                            <thead>
                                                                <tr class="uk-text-bold">
                                                                    <th class="uk-text-bold">Case</th>
                                                                    <th class="uk-text-bold">Date & Bench</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i=1; ?>
                                                                @foreach($scheduled_cases as $scheduled_case)
                                                                    @if(is_array($scheduled_case) || is_object($scheduled_case))
                                                                        @foreach($scheduled_case as $scheduled)
                                                                            <tr>
                                                                                <td class="uk-width-small@m">
                                                                                    <div>
                                                                                        <span class="uk-text-muted">{{$scheduled['registration_number'] ?: ('D. No.' . $scheduled['diary_number'] . '/' . $scheduled['diary_year'])}}</span>
                                                                                    </div>
                                                                                    <div><b>P: </b>{{ucwords(strtolower($scheduled['petitioner_name']))}}</div>
                                                                                    <div><b>R: </b>{{ucwords(strtolower($scheduled['respondent_name']))}}</div>
                                                                                </td>
                                                                                <td class="uk-table-expand" uk-margin>
                                                                                    <div>
                                                                                        <li>
                                                                                            <button type="button" class="btn btn-primary accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i; ?>">{{date_format(date_create($scheduled['meta']['listing']['listed_on']), 'D, jS M')}}</button>
                                                                                            <ul id="collapse<?php echo $i; ?>" class="submenu accordion-collapse collapse" aria-labelledby="heading<?php echo $i; ?>" data-bs-parent="#accordionExample">
                                                                                                @if(!empty($scheduled['office_reports']['current']['uri']))
                                                                                                    <li><a class="btn-link" href="{{$scheduled['office_reports']['current']['uri']}}" target="_blank"><span uk-icon="icon: file-pdf"></span> Office Report</a></li>
                                                                                                @endif
                                                                                                @if(!empty($scheduled['rop_judgments']['current']['uri']))
                                                                                                    <li><a class="btn-link" href="{{$scheduled['rop_judgments']['current']['uri']}}" target="_blank"><span uk-icon="icon: file-pdf"></span> Previous Order ({{$scheduled['rop_judgments']['current']['dated']}})</a></li>
                                                                                                @endif
                                                                                                <li><a style="cursor: pointer;" title="Send SMS" onClick="get_message_data(this.id)" id="<?php echo $scheduled['diary_number'] .'#'.$scheduled['diary_year'].'#'.$scheduled['registration_number'].'#'.$scheduled['petitioner_name'].'#'.$scheduled['respondent_name'].'#'.$scheduled['item_number'].'#'.$scheduled['meta']['listing']['court']['name'],'#'.date_format(date_create($scheduled['meta']['listing']['listed_on']), 'D, jS M Y'); ?>"><span uk-icon="icon: comment"></span> Send SMS</a></li>
                                                                                                <?php if($scheduled['vc_url']!=null) { ?>
                                                                                                    <li><a class="btn-link" href="{{$scheduled['vc_url']}}" target="_blank"><span uk-icon="icon: file-text"></span> Join Virtual Court</a></li>
                                                                                                <?php } ?>
                                                                                                <li>
                                                                                                    @if($scheduled['meta']['listing']['court']['number']!=1)
                                                                                                        
                                                                                                        <a href="<?php echo base_url("case/paper_book_viewer/".(string)$scheduled['diary_id'].""); ?>" target="_blank" rel="noopener">
                                                                                                            <span uk-icon="icon: bookmark"></span> Paper Book (with Indexing)
                                                                                                        </a>
                                                                                                    @endif
                                                                                                    @if($scheduled['meta']['listing']['court']['number']==1)
                                                                                                        <a href="<?php echo base_url("case/3pdf_paper_book_viewer/".(string)$scheduled['diary_id'].""); ?>" target="_blank" rel="noopener">
                                                                                                            <span uk-icon="icon: bookmark"></span>  Paper Book (3 PDF)
                                                                                                        </a>
                                                                                                    @endif
                                                                                                </li>
                                                                                            </ul>
                                                                                        </li>
                                                                                    </div>
                                                                                    <div>
                                                                                        <span class="uk-label md-bg-grey-900" uk-tooltip="{{$scheduled['meta']['listing']['court']['listing_cum_board_type'] . str_replace(':','.',$scheduled['meta']['listing']['court']['scheduled_time'])}}">{{'Item '.($scheduled['item_number_alt'] ?: $scheduled['item_number'])}} @ {{$scheduled['meta']['listing']['court']['name']}}</span>
                                                                                    </div>
                                                                                    <div>
                                                                                        <small>
                                                                                            <b>Bench:</b><br>
                                                                                            <?php echo ucwords(strtolower(implode(',<br> ', $scheduled['meta']['listing']['court']['judges']))); ?>
                                                                                        </small>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <?php $i++; ?>
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="uk-divider-vertical uk-margin-small-left uk-margin-small-right uk-visible@m">
                                        </div>
                                    @endif
                                    <!-- start sr advocate soon -->
                                    @if(!empty($sr_advocate_soon_cases))
                                        <!-- <div class="uk-width uk-width-large@l uk-margin-medium-top uk-overflow-auto uktable-responsive">
                                            <h4 class="uk-heading-bullet uk-text-bold">My cases <small class="uk-text-muted">soon to be listed</small></h4>
                                            <table class="uk-table uktable-justify uktable-striped uk-table-hover uk-table-divider" id="soon-to-be-listed-cases-table"> -->
                                        @if(!empty($sr_advocate_data))
                                            <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                                        @else
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        @endif
                                            <div class="dash-card">
                                                <div class="title-sec">
                                                    <h5 class="unerline-title">My cases <small class="uk-text-muted">soon to be listed</small></h5>
                                                </div>
                                                <div class="table-sec">
                                                    <div class="table-responsive">
                                                        <table id="datatable-responsive-srAdv" class="table table-striped custom-table">
                                                            <thead>
                                                                <tr class="uk-text-bold">
                                                                    <th class="uk-text-bold">Case</th>
                                                                    <th class="uk-text-bold">Date & Bench</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i=1; ?>
                                                                @foreach($sr_advocate_soon_cases as $sr_advocate_soon_case)
                                                                    <tr>
                                                                        <td class="uk-width-small@m">
                                                                            <div>
                                                                                <span class="uk-text-muted">{{$sr_advocate_soon_case->registration_number ?: ('D. No.' . $sr_advocate_soon_case->diary_number . '/' . $sr_advocate_soon_case->diary_year)}}</span>
                                                                            </div>
                                                                            <div><b>P: </b>{{ucwords(strtolower($sr_advocate_soon_case->petitioner_name))}}</div>
                                                                            <div><b>R: </b>{{ucwords(strtolower($sr_advocate_soon_case->respondent_name))}}</div>
                                                                            {{--<div>
                                                                                <span class="uk-label uk-background-muted uk-text-primary" style="text-transform: none;font-size:11px;">{{ucwords(strtolower(str_replace(']','',str_replace('[','',$scheduled_case->meta->listing->court->listing_sub_type))))}}</span>
                                                                            </div>--}}
                                                                        </td>
                                                                        <td class="uk-table-expand" uk-margin>
                                                                            <div>
                                                                                <li>
                                                                                    <button type="button" class="btn btn-primary accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i; ?>">{{date_format(date_create($sr_advocate_soon_case->meta->listing->listed_on), 'D, jS M')}}</button>
                                                                                    <ul id="collapse<?php echo $i; ?>" class="submenu accordion-collapse collapse" aria-labelledby="heading<?php echo $i; ?>" data-bs-parent="#accordionExample">
                                                                                        @if(!empty($sr_advocate_soon_case->office_reports->current->uri))
                                                                                            <li><a class="btn-link" href="{{$sr_advocate_soon_case->office_reports->current->uri}}" target="_blank"><span uk-icon="icon: file-pdf"></span> Office Report</a></li>
                                                                                        @endif
                                                                                        @if(!empty($sr_advocate_soon_case->rop_judgments->current->uri))
                                                                                            <li><a class="btn-link" href="{{$sr_advocate_soon_case->rop_judgments->current->uri}}" target="_blank"><span uk-icon="icon: file-pdf"></span> Previous Order ({{$sr_advocate_soon_case->rop_judgments->current->dated}})</a></li>
                                                                                        @endif
                                                                                        <li><a style="cursor: pointer;" title="Send SMS" onClick="get_message_data(this.id)" id="<?php echo $sr_advocate_soon_case->diary_number .'#'.$sr_advocate_soon_case->diary_year.'#'.$sr_advocate_soon_case->registration_number.'#'.$sr_advocate_soon_case->petitioner_name.'#'.$sr_advocate_soon_case->respondent_name.'#'.$sr_advocate_soon_case->item_number.'#'.$sr_advocate_soon_case->meta->listing->court->name,'#'.date_format(date_create($sr_advocate_soon_case->meta->listing->listed_on), 'D, jS M Y'); ?>"><span uk-icon="icon: comment"></span> Send SMS</a></li>
                                                                                        <?php if($sr_advocate_soon_case->vc_url != NULL) { ?>
                                                                                            <li><a class="btn-link" href="{{$sr_advocate_soon_case->vc_url}}" target="_blank"><span uk-icon="icon: file-text"></span> Join Virtual Court</a></li>
                                                                                        <?php } ?>
                                                                                        <li>
                                                                                            <a href="#" onclick="javascript:loadPaperBookViewer(this);" data-paper-book-viewer-url="<?php echo base_url("case/paper_book_viewer/".(string)$sr_advocate_soon_case->diary_id.""); ?>" targe="_blank" data-diary_no="@{{$sr_advocate_soon_case->diary_id}}" data-diary_year="">
                                                                                                <span uk-icon="icon: bookmark"></span> Paper Book (with Indexing)
                                                                                            </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </li>
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
                                                                    <?php $i++; ?>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="uk-divider-vertical uk-margin-small-left uk-margin-small-right uk-visible@m">
                                    @endif
                                    <!-- end sr advocate soon -->
                                    <!-- start sr advocate data -->
                                    @if(!empty($sr_advocate_data))
                                        <div class="uk-width-expand uk-margin-medium-top uk-overflow-hidden">
                                            <h4 class="uk-heading-bullet uk-text-bold">My Cases <small class="uk-text-muted">assigned by AOR</small></h4>
                                            <table class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%" id="efiled-cases-table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Case Number</th>
                                                        <th>Cause Title</th>
                                                        <th style="width: 90px;">Status</th>
                                                        <th>Engaged By/Date</th>
                                                        <th>Paper Book</th>
                                                        <!-- <th>...</th>-->
                                                    </tr>
                                                </thead>
                                                <tbody>
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
                                                                    <a href="#" onclick="javascript:loadPaperBookViewer(this);" data-paper-book-viewer-url="'.base_url("case/paper_book_viewer").'/'.$diary_no.'" target="_blank" data-diary_no="'.$diary_no.'" data-diary_year="">View</a>
                                                                </td>
                                                            </tr>';
                                                            $n++;
                                                        }
                                                    }
                                                    ?>
                                                    <!-- <a href="javaScript:void(0)" onClick="open_paper_book()" class="" data-diary_no="'.$diary_no.'" data-diary_year="">View</a>-->
                                                </tbody>
                                                <tfoot>
                                                    <tr class="uk-text-bold">
                                                        <th class="uk-text-bold d-print-none">#</th>
                                                        <th class="uk-text-bold">Case Number</th>
                                                        <th class="uk-text-bold">Cause Title</th>
                                                        <th class="uk-text-bold" style="width: 90px;">Status</th>
                                                        <th class="uk-text-bold">Engaged By/Date</th>
                                                        <th class="uk-text-bold">Paper Book</th>
                                                        <!-- <th class="uk-text-bold d-print-none">...</th>-->
                                                    </tr>
                                                </tfoot>
                                                <!--END-->
                                            </table>
                                        </div>
                                    @endif
                                    <!-- end sr advocate data -->
                                    @if(!in_array($_SESSION['login']['ref_m_usertype_id'],array(ARGUING_COUNSEL,SR_ADVOCATE)))
                                        <div class="col-12 col-sm-12 col-md-9 col-lg-9">
                                            <div class="dash-card">
                                                <div class="title-sec">
                                                    <h5 class="unerline-title">e-Filled Cases</h5>
                                                </div>
                                                <div class="table-sec">
                                                    <div class="table-responsive">
                                                        <table id="datatable-responsive" class="table table-striped custom-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Sr. No.</th>
                                                                    <th>Stage</th>
                                                                    <th>eFiling No.</th>
                                                                    <th>Type</th>
                                                                    <th>Case Detail</th>
                                                                    <th>Submitted On</th>
                                                                    <th>...</th>
                                                                    <th>Allocated To DA</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $i = 1;
                                                                $allocated = '';
                                                                if (isset($final_submitted_applications) && !empty($final_submitted_applications) && count($final_submitted_applications) > 0) {
                                                                    foreach ($final_submitted_applications as $re) {
                                                                        $stages = $re->stage_id;
                                                                        $exclude_stages_array = array(8, 9, 11, 13, 34, 35, 36, 37);
                                                                        /*if(in_array($re->stage_id, $exclude_stages_array)){
                                                                                continue;
                                                                            }*/
                                                                        $fil_no = $reg_no = $case_details = $cnr_number = $cino = '';
                                                                        $fil_ia_no = $reg_ia_no = $cause_title = $fil_case_no = $reg_case_no = $diary_no = $lbl_for_doc_no = $fil_misc_doc_ia_no = '';
                                                                        $efiling_types_array = array(E_FILING_TYPE_MISC_DOCS, E_FILING_TYPE_IA, E_FILING_TYPE_MENTIONING, OLD_CASES_REFILING);
                                                                        if (in_array($re->ref_m_efiled_type_id, $efiling_types_array)) {
                                                                            if ($re->ref_m_efiled_type_id == E_FILING_TYPE_MISC_DOCS) {
                                                                                $type = 'Misc. Docs';
                                                                                $lbl_for_doc_no = '<b>Misc. Doc. No.</b> : ';
                                                                                $redirect_url = base_url('miscellaneous_docs/DefaultController');
                                                                                $redirect_url = base_url('case/document/crud_registration');
                                                                                $recheck_url = 'case/document/crud_registration';
                                                                            } elseif ($re->ref_m_efiled_type_id == E_FILING_TYPE_IA) {
                                                                                $type = 'Interim Application';
                                                                                $lbl_for_doc_no = '<b>IA Diary No.</b> : ';
                                                                                $redirect_url = base_url('IA/DefaultController');
                                                                                $redirect_url = base_url('case/interim_application/crud_registration');
                                                                                $recheck_url = 'case/interim_application/crud_registration';
                                                                            } elseif ($re->ref_m_efiled_type_id == E_FILING_TYPE_MENTIONING) {
                                                                                $type = 'Mentioning';
                                                                                $lbl_for_doc_no = '';
                                                                                $redirect_url = base_url('case/mentioning');
                                                                            } elseif ($re->ref_m_efiled_type_id == E_FILING_TYPE_CITATION) {
                                                                                $type = 'Citation';
                                                                                $lbl_for_doc_no = '';
                                                                                $redirect_url = base_url('citation/DefaultController');
                                                                                $redirect_url = base_url('case/citation');
                                                                            } elseif ($re->ref_m_efiled_type_id == E_FILING_TYPE_CAVEAT) {
                                                                                $type = 'Caveat';
                                                                                $lbl_for_doc_no = '';
                                                                                $redirect_url = base_url('caveat');
                                                                            } elseif ($re->ref_m_efiled_type_id == OLD_CASES_REFILING) {
                                                                                $type = 'Old Case Refiling';
                                                                                $lbl_for_doc_no = '';
                                                                                $redirect_url = base_url('case/refile_old_efiling_cases/crud_registration');
                                                                            }
                                                                            if (isset($re->loose_doc_no) && $re->loose_doc_no != '' && $re->loose_doc_year != '') {
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
                                                                                $case_details = '<a onClick="open_case_statusStop()"  href=""  title="show CaseStatus"  data-diary_no="' . $re->diary_no . '" data-diary_year="' . $re->diary_year . '">' . $case_details . '</a>';
                                                                            }
                                                                        } elseif ($re->ref_m_efiled_type_id == E_FILING_TYPE_NEW_CASE) {
                                                                            $type = 'New Case';
                                                                            $cause_title = escape_data(strtoupper($re->ecase_cause_title));
                                                                            $cause_title = str_replace('VS.', '<b>Vs.</b>', $cause_title);
                                                                            if ($re->sc_diary_num != '') {
                                                                                $diary_no = '<b>Diary No.</b> : ' . escape_data($re->sc_diary_num) . '/' . escape_data($re->sc_diary_year) . '<br/> ';
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
                                                                                $case_details = '<a onClick="open_case_statusStop()"  href=""  title="show CaseStatus"  data-diary_no="' . $re->sc_diary_num . '" data-diary_year="' . $re->sc_diary_year . '">' . $case_details . '</a>';
                                                                            }
                                                                            $redirect_url = base_url('newcase/defaultController');
                                                                            $recheck_url = 'case/crud';
                                                                            $redirect_url = base_url('case/crud');
                                                                        } elseif ($re->ref_m_efiled_type_id == E_FILING_TYPE_CAVEAT) {
                                                                            $efiling_civil_data = getEfilingCivilDetails($re->registration_id);
                                                                            $type = 'Caveat';
                                                                            $caveat_no = '';
                                                                            $caveator_name = '';
                                                                            $caveatee_name = '';
                                                                            $caveator_name_vs_caveatee_name = '';
                                                                            $caveator_details = '';
                                                                            $caveatee_details = '';
                                                                            if (isset($efiling_civil_data) && !empty($efiling_civil_data)) {
                                                                                if (isset($efiling_civil_data[0]['orgid']) && !empty($efiling_civil_data[0]['orgid']) && $efiling_civil_data[0]['orgid'] != 'I') {
                                                                                    $org_dept_name = !empty($efiling_civil_data[0]['org_dept_name']) ? '<br/>Department Name : ' . $efiling_civil_data[0]['org_dept_name'] . '' : '';
                                                                                    $org_post_name = !empty($efiling_civil_data[0]['org_post_name']) ? 'Post Name : ' . $efiling_civil_data[0]['org_post_name'] . '' : '';
                                                                                    $org_state_name = !empty($efiling_civil_data[0]['org_state_name']) ? 'State Name : ' . $efiling_civil_data[0]['org_state_name'] : '';
                                                                                    $caveator_details = $org_dept_name . $org_post_name . $org_state_name;
                                                                                    if (!empty($caveator_details)) {
                                                                                        $caveator_details = ' <b>(</b>' . $caveator_details . '<b>)</b>';
                                                                                    }
                                                                                }
                                                                                if (isset($efiling_civil_data[0]['resorgid']) && !empty($efiling_civil_data[0]['resorgid']) && $efiling_civil_data[0]['resorgid'] != 'I') {
                                                                                    $res_org_dept_name = !empty($efiling_civil_data[0]['res_org_dept_name']) ? '<br/>Department Name : ' . $efiling_civil_data[0]['res_org_dept_name'] . '' : '';
                                                                                    $res_org_post_name = !empty($efiling_civil_data[0]['res_org_post_name']) ? 'Post Name : ' . $efiling_civil_data[0]['res_org_post_name'] . '' : '';
                                                                                    $res_org_state_name = !empty($efiling_civil_data[0]['res_org_state_name']) ? 'State Name : ' . $efiling_civil_data[0]['res_org_state_name'] : '';
                                                                                    $caveatee_details = $res_org_dept_name . $res_org_post_name . $res_org_state_name;
                                                                                    if (!empty($caveatee_details)) {
                                                                                        $caveatee_details = ' <b>(</b>' . $caveatee_details . '<b>)</b>';
                                                                                    }
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
                                                                                $caveator_name_vs_caveatee_name = $caveator_name . $caveator_details . '<b> Vs. </b>' . $caveatee_name . $caveatee_details . '<br/> ';
                                                                                if (
                                                                                    isset($re->caveat_num) && !empty($re->caveat_num)
                                                                                    && isset($re->caveat_num) && !empty($re->caveat_num)
                                                                                ) {
                                                                                    $caveat_no = '<b>Filed In</b><br/><b>Caveat No.</b> : ' . $re->caveat_num . ' / ' . $re->caveat_num . '<br/> ';
                                                                                }
                                                                            }
                                                                            $cause_title = escape_data(strtoupper($re->pet_name));
                                                                            $cause_title = escape_data(strtoupper($caveator_name_vs_caveatee_name));
                                                                            if ($re->sc_diary_num != '') {
                                                                                $diary_no = '<b>Diary No.</b> : ' . escape_data($re->sc_diary_num) . '/' . escape_data($re->sc_diary_year) . '<br/> ';
                                                                            } else {
                                                                                $diary_no = '';
                                                                            }
                                                                            if ($re->reg_no_display != '') {
                                                                                $reg_no = '<b>Registration No.</b> : ' . escape_data($re->sc_display_num) . '<br/> ';
                                                                            } else {
                                                                                $reg_no = '';
                                                                            }
                                                                            $case_details =  $caveat_no . $diary_no . $reg_no . $cause_title;
                                                                            if ($diary_no != '') {
                                                                                $case_details = '<a href="#">' . $case_details . '</a>';
                                                                            }
                                                                            $recheck_url = 'case/caveat/crud';
                                                                            $redirect_url = base_url('case/caveat/crud');
                                                                        } elseif ($re->ref_m_efiled_type_id == E_FILING_TYPE_CERTIFICATE_REQUEST) {
                                                                            $api_certificate_str = file_get_contents(env('API_PRISON') . '/certificate_status_efile/' . $re->efiling_no);
                                                                            $api_certificate = json_decode($api_certificate_str);
                                                                            $api_certificateData = $api_certificate->result;
                                                                            $api_certificate_efiling_no = $api_certificateData->efiling_no;
                                                                            $api_certificate_request_no = $api_certificateData->request_no;
                                                                            $type = 'Certificate';
                                                                            $lbl_for_doc_no = '';
                                                                            if (!empty($api_certificate_efiling_no)) {
                                                                                $redirect_url = '';
                                                                                $redirect_url = base_url('case/certificate/' . $re->registration_id);
                                                                            } else {
                                                                                $redirect_url = '';
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
                                                                                $case_details = '<a onClick="open_case_statusStop()"  href=""  title="show CaseStatus"  data-diary_no="' . $re->diary_no . '" data-diary_year="' . $re->diary_year . '">' . $case_details . '</a>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <tr>
                                                                            <td width="8%" class="sorting_1" tabindex="0"><?php echo $i++;
                                                                                                                            '-' . $stages; ?></td>
                                                                            <td width="5%">
                                                                                <?php
                                                                                if (!empty($api_certificate_efiling_no) && $re->ref_m_efiled_type_id == E_FILING_TYPE_CERTIFICATE_REQUEST) {
                                                                                    echo $re->user_stage_name;
                                                                                } else {
                                                                                    echo $re->user_stage_name;
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <!--------------------Pending Acceptence-------------------------->
                                                                            <?php
                                                                            $arrayStage = array(Initial_Approaval_Pending_Stage, Initial_Defects_Cured_Stage, TRASH_STAGE);
                                                                            /*if ($stages == Initial_Approaval_Pending_Stage) {*/
                                                                            $case_details = '<a onClick="open_case_statusStop()"  href="#"  title="show CaseStatus"  data-diary_no="' . $re->diary_no . '" data-diary_year="' . $re->diary_year . '">' . $case_details . '</a>';
                                                                            if (in_array($stages, $arrayStage)) { ?>
                                                                                <td width="14%">
                                                                                    <a href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . Initial_Approaval_Pending_Stage)) ?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?><?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) { echo htmlentities($re->efiling_for_name, ENT_QUOTES); } ?></a>
                                                                                </td>
                                                                                <td width="5%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                                                                                <td><?php echo $case_details; ?></td>
                                                                                <td width="10%"><?php echo htmlentities(date("d/m/Y h.i.s A", strtotime($re->activated_on, ENT_QUOTES))); ?></td>
                                                                                <td>&nbsp;</td>
                                                                            <?php } ?>
                                                                            <!--------------------Draft------------------>
                                                                            <?php if ($stages == Draft_Stage) { ?>
                                                                                <td width="14%">
                                                                                    <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?>
                                                                                    <?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) {
                                                                                        echo htmlentities($re->efiling_for_name, ENT_QUOTES) . $allocated;
                                                                                    } ?>
                                                                                </td>
                                                                                <td width="5%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                                                                                <td><?php echo $case_details; ?></td>
                                                                                <td width="5%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                                                                                <td width="12%">
                                                                                    <a class="form-control btn btn-success" href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . Draft_Stage)) ?>"> <?php echo htmlentities("View", ENT_QUOTES) ?></a>
                                                                                </td>
                                                                            <?php } ?>
                                                                            <!--------------------For Compliance------------------>
                                                                            <?php if ($stages == Initial_Defected_Stage) { ?>
                                                                                <td width="14%">
                                                                                    <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?>
                                                                                    <?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) {
                                                                                        echo htmlentities($re->efiling_for_name, ENT_QUOTES) . $allocated;
                                                                                    } ?>
                                                                                </td>
                                                                                <td width="5%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                                                                                <td><?php echo $case_details; ?></td>
                                                                                <td width="10%"><?php echo htmlentities(date("d/m/Y h.i.s A", strtotime($re->activated_on, ENT_QUOTES))); ?></td>
                                                                                <td width="12%">
                                                                                    <!--<a class="form-control btn btn-success" href="<?/*= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . Initial_Defected_Stage)) */ ?>"> <?php /*echo htmlentities("Re-Submit", ENT_QUOTES) */ ?></a>-->
                                                                                    <a class="btn btn-primary" href="<?= base_url($recheck_url . '/' . url_encryption((trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . Initial_Defected_Stage)))) ?>"> <span class="uk-label md-bg-grey-900"><?php echo htmlentities("Re-Submit", ENT_QUOTES) ?></span></a>
                                                                                </td>
                                                                            <?php } ?>
                                                                            <!--------------------Make Payment------------------>
                                                                            <?php if ($stages == Initial_Approved_Stage) { ?>
                                                                                <td width="14%">
                                                                                    <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?>
                                                                                    <?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) {
                                                                                        echo htmlentities($re->efiling_for_name, ENT_QUOTES) . $allocated;
                                                                                    } ?>
                                                                                </td>
                                                                                <td width="5%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                                                                                <td><?php echo $case_details; ?></td>
                                                                                <td width="5%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                                                                                <td width="14%">
                                                                                    <a class="form-control btn btn-success" href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . Initial_Approved_Stage)) ?>"> <?php echo htmlentities("Make Payment", ENT_QUOTES) ?></a>
                                                                                </td>
                                                                            <?php } ?>
                                                                            <!--------------------Payment Receipts------------------>
                                                                            <?php if ($stages == Pending_Payment_Acceptance) { ?>
                                                                                <td width="14%">
                                                                                    <a class="form-control btn btn-success" href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . Pending_Payment_Acceptance)) ?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?><?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) { echo htmlentities($re->efiling_for_name, ENT_QUOTES) . $allocated; } ?></a>
                                                                                </td>
                                                                                <td width="5%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                                                                                <td width="12%">
                                                                                    <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?>
                                                                                    <?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) {
                                                                                        echo htmlentities($re->efiling_for_name, ENT_QUOTES) . $allocated;
                                                                                    } ?>
                                                                                </td>
                                                                                <td><?php echo $case_details; ?></td>
                                                                                <td width="5%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                                                                            <?php } ?>
                                                                            <!--------------------Pending Scrutiny------------------>
                                                                            <?php if ($stages == I_B_Approval_Pending_Stage) { ?>
                                                                                <td width="14%">
                                                                                    <a href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . I_B_Approval_Pending_Stage)) ?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?><?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) { echo htmlentities($re->efiling_for_name, ENT_QUOTES) . $allocated; } ?></a>
                                                                                </td>
                                                                                <td width="5%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                                                                                <td><?php echo $case_details; ?></td>
                                                                                <td width="10%"><?php echo htmlentities(date("d/m/Y h.i.s A", strtotime($re->activated_on, ENT_QUOTES))); ?></td>
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
                                                                                <td width="14%">
                                                                                    <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?>
                                                                                    <?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) {
                                                                                        echo htmlentities($re->efiling_for_name, ENT_QUOTES) . $allocated;
                                                                                    } ?>
                                                                                </td>
                                                                                <td width="5%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                                                                                <td><?php echo $case_details; ?></td>
                                                                                <td width="10%"><?php echo htmlentities(date("d/m/Y h.i.s A", strtotime($re->activated_on, ENT_QUOTES))); ?></td>
                                                                                <td width="14%">
                                                                                    <a class="btn btn-primary" href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . I_B_Defected_Stage)) ?>"> <?php echo htmlentities("Cure Defects", ENT_QUOTES) ?></a>
                                                                                </td>
                                                                            <?php } ?>
                                                                            <!--------------------E-filed Cases------------------>
                                                                            <?php if ($stages == E_Filed_Stage) { ?>
                                                                                <td width="14%">
                                                                                    <a href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . E_Filed_Stage)) ?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?><?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) { echo htmlentities($re->efiling_for_name, ENT_QUOTES); } ?></a>
                                                                                </td>
                                                                                <td width="5%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                                                                                <td><?php echo $case_details; ?></td>
                                                                                <td width="10%"><?php echo htmlentities(date("d/m/Y h.i.s A", strtotime($re->activated_on, ENT_QUOTES))); ?></td>
                                                                                <td>&nbsp;</td>
                                                                            <?php } ?>
                                                                            <!--------------------E-filed Misc. Documents------------------>
                                                                            <?php if ($stages == Document_E_Filed) { ?>
                                                                                <td width="14%">
                                                                                    <a href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . Document_E_Filed)) ?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?><?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) { echo htmlentities($re->efiling_for_name, ENT_QUOTES); } ?>
                                                                                    </a>
                                                                                </td>
                                                                                <td width="5%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                                                                                <td><?php echo $case_details; ?></td>
                                                                                <td width="5%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                                                                                <td>&nbsp;</td>
                                                                            <?php } ?>
                                                                            <!--------------------E-filed Misc. Documents------------------>
                                                                            <?php if ($stages == DEFICIT_COURT_FEE_E_FILED) { ?>
                                                                                <td width="14%">
                                                                                    <a href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . I_B_Rejected_Stage)) ?>"><?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?><?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) { echo htmlentities($re->efiling_for_name, ENT_QUOTES); } ?></a>
                                                                                </td>
                                                                                <td width="5%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                                                                                <td><?php echo $case_details; ?></td>
                                                                                <td width="5%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                                                                                <td>&nbsp;</td>
                                                                            <?php } ?>
                                                                            <?php if ($stages == I_B_Rejected_Stage) { ?>
                                                                                <td width="14%">
                                                                                    <a href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . I_B_Rejected_Stage)) ?>"><?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?><?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) { echo htmlentities($re->efiling_for_name, ENT_QUOTES); } ?></a>
                                                                                </td>
                                                                                <td width="5%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                                                                                <td><?php echo $case_details; ?></td>
                                                                                <td width="5%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                                                                                <?php if ($re->stage_id == I_B_Rejected_Stage) { ?>
                                                                                    <td width="12%"><?php echo htmlentities('Filing Section', ENT_QUOTES); ?></td>
                                                                                <?php } elseif ($re->stage_id == E_REJECTED_STAGE) { ?>
                                                                                    <td width="12%"><?php echo htmlentities('eFiling Admin', ENT_QUOTES); ?></td>
                                                                                <?php
                                                                                } else {
                                                                                    echo "<td>&nbsp;</td>";
                                                                                }
                                                                            }
                                                                            if ($stages == DEFICIT_COURT_FEE) {
                                                                                ?>
                                                                                <td width="14%">
                                                                                    <?php echo efile_preview(htmlentities($re->efiling_no, ENT_QUOTES)); ?></a>
                                                                                </td>
                                                                                <td width="5%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                                                                                <td><?php echo $case_details; ?></td>
                                                                                <td width="5%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                                                                                <td width="14%">
                                                                                    <a class="form-control btn btn-success" href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . DEFICIT_COURT_FEE)) ?>"> <?php echo htmlentities("View", ENT_QUOTES) ?></a>
                                                                                </td>
                                                                            <?php
                                                                            }
                                                                            if ($stages == LODGING_STAGE) {
                                                                            ?>
                                                                                <td width="14%">
                                                                                    <a href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . LODGING_STAGE)) ?>"><?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?><?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) { echo htmlentities($re->efiling_for_name, ENT_QUOTES); } ?></a>
                                                                                </td>
                                                                                <td width="5%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
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
                                                                                <td width="10%"><?php echo htmlentities(date("d/m/Y h.i.s A", strtotime($re->activated_on, ENT_QUOTES))); ?></td>
                                                                            <?php
                                                                            }
                                                                            if ($stages == IA_E_Filed) {
                                                                            ?>
                                                                                <td width="14%">
                                                                                    <a href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . IA_E_Filed)) ?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?><?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) { echo htmlentities($re->efiling_for_name, ENT_QUOTES); } ?></a>
                                                                                </td>
                                                                                <td width="5%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                                                                                <td><?php echo $case_details; ?></td>
                                                                                <td width="5%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                                                                                <td>&nbsp;</td>
                                                                            <?php }
                                                                            if ($stages == MENTIONING_E_FILED) { ?>
                                                                                <td width="14%">
                                                                                    <a href="<?= $redirect_url . '/' . trim($re->registration_id); ?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?><?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) { echo htmlentities($re->efiling_for_name, ENT_QUOTES); } ?></a>
                                                                                </td>
                                                                                <td width="5%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                                                                                <td><?php echo $case_details; ?></td>
                                                                                <td width="5%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                                                                                <td>&nbsp;</td>
                                                                            <?php }
                                                                            if ($stages == CITATION_E_FILED) { ?>
                                                                                <td width="14%">
                                                                                    <a href="<?= $redirect_url . '/' . trim($re->registration_id); ?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?><?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) { echo htmlentities($re->efiling_for_name, ENT_QUOTES); } ?></a>
                                                                                </td>
                                                                                <td width="5%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                                                                                <td><?php echo $case_details; ?></td>
                                                                                <td width="5%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                                                                                <td>&nbsp;</td>
                                                                            <?php }
                                                                            if ($stages == CERTIFICATE_E_FILED) { ?>
                                                                                <td width="14%">
                                                                                    <!--<button class="CheckRequestCertificate btn-warning" data-scino="</?php /*echo $re->efiling_no;*/?>">Status</button>-->
                                                                                    <?php if (!empty($api_certificate_efiling_no) && $api_certificate_efiling_no == $re->efiling_no && !empty($api_certificate_request_no) && $api_certificate_request_no != null) { ?>
                                                                                        <a class="CheckRequestCertificatewwww" onClick="CheckRequestCertificate('<?php echo $api_certificate_request_no; ?>')" data-scino="<?php echo $api_certificate_efiling_no; ?>" data-request_no="<?php echo $api_certificate_request_no; ?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?><?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) { echo htmlentities($re->efiling_for_name, ENT_QUOTES); } ?></a>
                                                                                    <?php
                                                                                    } else { ?>
                                                                                        <span class="text-black" style="color:black!important;"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?><?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) { echo htmlentities($re->efiling_for_name, ENT_QUOTES); } ?></span>
                                                                                    <?php } ?>
                                                                                </td>
                                                                                <td width="5%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                                                                                <td><?php echo $case_details; ?></td>
                                                                                <td width="5%"><?php echo date("d/m/Y h.i.s A", strtotime(htmlentities($re->activated_on, ENT_QUOTES))); ?></td>
                                                                                <td>&nbsp;</td>
                                                                            <?php }
                                                                            if (in_array($stages, $exclude_stages_array)) { ?>
                                                                                <td width="14%">
                                                                                    <a href="<?= $redirect_url . '/' . url_encryption(trim($re->registration_id . '#' . $re->ref_m_efiled_type_id . '#' . I_B_Approval_Pending_Stage)) ?>"> <?php echo "<b>" . htmlentities(efile_preview($re->efiling_no, ENT_QUOTES)) . "</b>" . "<br>"; ?><?php if (isset($re->efiling_for_name) && !empty($re->efiling_for_name) && ($re->efiling_for_name) != NULL) { echo htmlentities($re->efiling_for_name, ENT_QUOTES) . $allocated; } ?></a>
                                                                                </td>
                                                                                <td width="5%"><?php echo htmlentities($type, ENT_QUOTES) ?></td>
                                                                                <td><?php echo $case_details; ?></td>
                                                                                <td width="10%"><?php echo htmlentities(date("d/m/Y h.i.s A", strtotime($re->activated_on, ENT_QUOTES))); ?></td>
                                                                                <td>&nbsp;</td>
                                                                            <?php } ?>
                                                                            <?php if ($stages != Draft_Stage || $stages != TRASH_STAGE) {
                                                                            ?>
                                                                                <td width="10%">
                                                                                    <a>
                                                                                        <?php
                                                                                        echo (!empty($re->allocated_user_first_name)) ? htmlentities($re->allocated_user_first_name, ENT_QUOTES) : '';
                                                                                        echo (!empty($re->allocated_user_last_name)) ? htmlentities($re->allocated_user_last_name, ENT_QUOTES) : '';
                                                                                        echo (!empty($re->allocated_to_user_id)) ? htmlentities($re->allocated_to_user_id, ENT_QUOTES) : ''; echo '<br>';
                                                                                        echo (!empty($re->allocated_to_da_on)) ? htmlentities(date("d/m/Y h.i.s A", strtotime($re->allocated_to_da_on, ENT_QUOTES))) : '';
                                                                                        ?>
                                                                                    </a>
                                                                                </td>
                                                                            <?php } else { ?>
                                                                                <td>&nbsp;&nbsp;</td>
                                                                            <?php } ?>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!in_array($_SESSION['login']['ref_m_usertype_id'],array(ARGUING_COUNSEL,SR_ADVOCATE)))
                        <div class="col-12 sm-12 col-md-3 col-lg-3 middleContent-right">
                            <div class="right-content-inner comn-innercontent">
                                <div class="dashboard-section">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="dash-card">
                                                <div class="title-sec">
                                                    <h5 class="unerline-title">My Cases</h5>
                                                </div>
                                                <div class="calender-sec">
                                                    <div id="calendar"></div>
                                                </div>
                                                <div id='efiling-details'>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped custom-table" style="text-align: center;">
                                                            <thead>
                                                                <tr>
                                                                    <th>eFiling No.</th>
                                                                    <th>Date & Time</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="efiling"></tbody>
                                                        </table>
                                                    </div>                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div id="mail" uk-modal>
    <div class="uk-modal-dialog" id="view_contacts_text" align="center"><h4> SMS CASE DETAILS <div id="mail_d"></div></h4>
        <!-- <input type="text" name="<?php // echo $this->security->get_csrf_token_name();?>" value="<?php // echo $this->security->get_csrf_hash();?>" placeholder="csrf token"> -->
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-body">
            To: <input type="text" class="form-control cus-form-ctrl" size="60" id="recipient_mobile_no" name="recipient_mobile_no"  maxlength="250" placeholder="Recipient's Mobile Number">
            <br>
            Message Text: <div id ='caseinfosms'></div>
        </div>
        <div class="uk-modal-footer uk-text-right" id="con_footer">
            <button class="uk-button uk-button-default uk-modal-close" type="button" >Cancel</button>
            <input type="button" id="send_sms"  value="Send SMS " class="uk-button uk-button-primary" onclick="send_sms()">
        </div>
    </div>
</div>
@endsection
<script src="<?= base_url() . 'assets/newAdmin/' ?>js/jquery-3.3.1.min.js"></script>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js'></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?= base_url() ?>assets/newAdmin/js/angular.min.js"></script>
<script src="{{base_url('assets/responsive_variant/frameworks/uikit_3-4-1/js/uikit.min.js')}}"></script>
<script src="{{base_url('assets/responsive_variant/frameworks/uikit_3-4-1/js/uikit-icons.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#datatable-responsive-srAdv').DataTable();
    });
    $(document).ready(function() {
        $('#datatable-responsive-sc_cases').DataTable({
            // "bPaginate": false,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "bAutoWidth": false,
            "pageLength": 5,
            // "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
        });
    });
</script>
<script>
    $(document).ready(function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: function(fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: '<?php echo base_url(); ?>dashboard_alt/getDailyCaseCounts',
                    dataType: 'json',
                    success: function(data) {
                        var events = [];
                        data.forEach(event => {
                            var existingEvent = events.find(e => e.start === event.start);
                            if (!existingEvent) {
                                events.push({
                                    title: event.count,
                                    start: event.start
                                });
                            }
                        });
                        successCallback(events);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching events:', error);
                        failureCallback(error);
                    }
                });
            },
            eventContent: function(arg) {
                let titleEl = document.createElement('div');
                titleEl.innerText = arg.event.title;
                let arrayOfDomNodes = [ titleEl ];
                return { domNodes: arrayOfDomNodes };
            },
            eventClick: function(info) {
                var start = moment(info.event.start).format('YYYY/MM/DD');
                $.ajax({
                    url: '<?php echo base_url(); ?>dashboard_alt/getDayCaseDetails',
                    method: "POST",
                    data: {
                        start: start
                    },
                    dataType: 'json',
                    success: function(response) {
                        var Table = document.getElementById("efiling");
                        Table.innerHTML = "";
                        for (var i = 0; i < response.length; i++) {
                            $('#efiling').append('<tr><td>' + response[i]['efiling_no'] + '</td><td>' + response[i]['activated_on'] + " " + '</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        var Table = document.getElementById("efiling");
                        Table.innerHTML = "";
                        $('#efiling').append('<tr>' + error + '</tr>');
                    }
                });
            }
        });
        calendar.render();
    });
    function get_message_data(id) {
        UIkit.modal('#mail').toggle();
        var x=id.split("#");
        if(x[2]=='')
            document.getElementById('caseinfosms').innerHTML="Diary No. "+x[0] +"/"+x[1]+" - "+x[3]+" VS "+x[4]+" is to be listed on "+x[7] +" in "+x[6]+" as item "+x[5] +" subject to order for the day";
        else
            document.getElementById('caseinfosms').innerHTML="Case No."+x[2]  +" - "+x[3]+" VS "+x[4]+" is to be listed on "+x[7] +" in "+x[6]+" as item "+x[5] +" subject to order for the day";

    }
    function send_sms() {
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
                else if(resArr[0]==2) {
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
                        } else{
                            columnIndex[0] = 1;
                            columnIndex[1] = 3;
                        }
                        //console.log(this.context[0].aoColumns[this.selector.cols].sTitle);
                        if($.inArray( this.selector.cols, columnIndex )!== -1){
                            var column = this;
                            var select = $('<select class="uk-select"><option value="">'+this.context[0].aoColumns[this.selector.cols].sTitle+'</option></select>').appendTo( $(column.header()).empty() ).on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column.search( val ? '^'+val+'$' : '', true, false ).draw();
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