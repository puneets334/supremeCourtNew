<!DOCTYPE html>
<html lang="en">
<head>
    @php
        header("X-Frame-Options: DENY");
        //header("X-XSS-Protection: 1; mode=block");
        header("X-Content-Type-Options: nosniff");
        //header("Strict-Transport-Security: max-age=31536000");
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        //echo '<meta http-equiv="Content-Security-Policy" content="default-src \'self\' ' . $allow_image_url['host'] . ' http://xxxx \'unsafe-inline\' \'unsafe-eval\';  font-src \'self\' data: ">';
    //todo:do a review of it. it was commented because it was blocking loading of data:image in <img/> tag
    @endphp
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#343a40">
    <title>@yield('title') | SC-eFM @ Supreme Court of India</title>
    <base ref="{{ base_url() }}">
    <!-- added for case_status-start -->

    <link rel="stylesheet" href="<?= base_url().'assets'?>/css/case_status/bootstrap.min.css">

    <!-- added for case_status-end -->

    <link rel="stylesheet" href="{{base_url('assets/responsive_variant/templates/uikit_scutum_2/assets/css/main.min.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{base_url('assets/responsive_variant/frameworks/uikit_3-4-1/css/uikit.min.css')}}" />
    <link rel="stylesheet" href="{{base_url('assets/responsive_variant/templates/uikit_scutum_2/assets/css/fonts/mdi_fonts.css')}}" />
    <link rel="stylesheet" href="{{base_url('assets/responsive_variant/templates/uikit_scutum_2/assets/css/materialdesignicons.min.css')}}" />

	<link rel="stylesheet" href="{{base_url('assets/fonts/fonts_googleapis_family_barlow_css2.css')}}"  rel="stylesheet">
 

    <script type="text/javascript" src="{{base_url('assets/responsive_variant/js/jquery/jquery.min.js')}}"></script>

    <script type="text/javascript" src="{{base_url('assets/responsive_variant/js/angularjs/angular.min.js')}}"></script>


    <?php if($this->uri->segment(1)=='efiling_search') {?>
    <style>
        header{display: none !important;}
        .efiling_search{visibility: hidden !important;}
    </style>
    <?php } ?>

    <style type="text/css">
        *{
            font-family: 'Barlow', sans-serif !important;
            /*font-family: 'Playfair Display', serif;*/
        }
        .text-saffron{
            color:#d94d21;
        }
        .text-white{
            color:#ffffff !important;
        }
        .text-pitch-black{
            color:#000000 !important;
        }
        .bg-white{
            background-color:#ffffff;
        }
        .bg-saffron{
            background-color:#d94d21;
        }
        .bg-black{
            background-color:#222222;
        }
        .bg-pitch-black{
            background-color:#000000 !important;
        }
        .bg-dark{
            background-color: #343a40!important;
        }
        .bg-danger{
            background-color: #f0506e;
        }
        .bg-success{
            background-color: #32D296;
        }
        .bg-warning{
            background-color: #FAA05A;
        }
        .bg-danger-combo{
            background-color: #f0506e;
            color:#ffffff;
        }
        .bg-success-combo{
            background-color: #32D296;
            color:#ffffff;
        }
        .border-white{
            border-color:#ffffff;
        }
        .border-black{
            border-color:#222222;
        }
        .border{
            border: 1px solid;
        }
        .border-primary{
            border-color: #1e87f0;
        }
        .border-warning{
            border-color: #FAA05A;
        }
        .border-danger{
            border-color: #f0506e;
        }
        .border-dark{
            border-color: #343a40;
        }
        .border-pitch-black{
            border-color: #000000;
        }
        .border-muted{
            border-color: #999999;
        }
        .bg-saffron-light{
            background-color:#f7dbd2;/*#fbede8;*/
        }
        .bg-gray{
            background-color: #C0C0C0;
        }
        .form-blank{
            background-color: #ffffff !important;
            border-color: #ffffff !important;
        }
        #loading-overlay {
            position: fixed; /* Sit on top of the page content */
            display: block; /* Hidden by default */
            width: 100%; /* Full width (cover the whole page) */
            height: 100%; /* Full height (cover the whole page) */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1051; /* Specify a stack order in case you're using a different order for other elements */
        }
        .full-overlay {
            position: fixed; /* Sit on top of the page content */
            display: block; /* Hidden by default */
            width: 100%; /* Full width (cover the whole page) */
            height: 100%; /* Full height (cover the whole page) */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1051; /* Specify a stack order in case you're using a different order for other elements */
        }

        /***start-from bootstrap***/
        @media print {
            .d-print-none {
                display: none !important;
            }
            .d-print-inline {
                display: inline !important;
            }
            .d-print-inline-block {
                display: inline-block !important;
            }
            .d-print-block {
                display: block !important;
            }
            .d-print-table {
                display: table !important;
            }
            .d-print-table-row {
                display: table-row !important;
            }
            .d-print-table-cell {
                display: table-cell !important;
            }
            .d-print-flex {
                display: -webkit-box !important;
                display: -ms-flexbox !important;
                display: flex !important;
            }
            .d-print-inline-flex {
                display: -webkit-inline-box !important;
                display: -ms-inline-flexbox !important;
                display: inline-flex !important;
            }
        }
        /***end-from bootstrap***/

        /***start-modifications in scutum***/
        .uk-form-icon{
            transform: none;
            -webkit-transform: none;
        }
        .uk-notification .uk-notification-message{
            font-size:1.30rem;
        }
        /***end-modifications in scutum***/
    </style>
</head>
<body ng-app="casesApp" ng-controller="casesController"><!--todo:find a solution to enable this....coz earlier this gave an issue wherein secure gate had initialized its own app & controller.-->

<div id="loading-overlay" class="uk-overlay-default uk-position-cover d-print-none">
    <div class="uk-flex uk-flex-center uk-flex-middle" uk-height-viewport uk-grid>
        <span uk-spinner="ratio: 2.2"></span>
    </div>
</div>
<div id="primary-overlay" class="full-overlay uk-overlay-primary uk-position-cover d-print-none" style="display:none;">
</div>
<script type="text/javascript">
    window.onbeforeunload = function(){
        $('#loading-overlay').show();
    };
</script>

@section('header')
<header class="efiling_search">
    <nav id="main-nav-dark" class="bgdark md-bg-grey-200" style="padding-top:0.5rem;padding-bottom:0.5rem;z-index:970 !important;height::51px;" uksticky="show-on-up: true; animation: uk-animation-slide-top; seltarget: [uk-navbar]; clsactive: uk-navbar-sticky; target-offset:true;" uk-height-match uk-navbar>
        @if(is_logged_in())
        <div class="uk-navbar-left d-print-none">
            <a href="#main-offcanvas" uk-toggle class="uk-navbar-toggle ukmargin-remove-left" style="min-height: unset;" uk-navbar-toggle-icon>
                <!--<i class="text-white" uk-icon="more-vertical"></i>-->
                <!--<img src="{{base_url('assets/responsive_variant/images/flags/india_alt.png')}}" alt="Supreme Court Emblem" style="height:2.0rem;margin-left:-0.7rem;">-->
            </a>
        </div>
        @endif

        <div class="uk-width-expand uk-flex-center uk-flex-left@s uk-flex bgdark">
            @if(!empty($_SESSION['login']['ref_m_usertype_id']))
                <a  href="{{base_url()}}" class="uk-icon-button" uk-icon="home"></a>
            @endif

            <a class="uk-navbar-item" href="{{base_url()}}" style="min-height: unset;padding-left:0.4rem;margin-top:-0.1rem;text-decoration: none;">
                <img src="{{base_url('assets/responsive_variant/images/flags/sci_logo.png')}}" alt="Supreme Court Emblem" style="height:2.9rem;">
                <span class="uk-margin-remove-vertical textwhite uk-text-muted uktext-bold uk-text-lead uk-margin-small-left" style="font-weight:500;">Supreme Court Of India</span>
            </a>
        </div>

        @if(is_logged_in())
        <div class="uk-navbar-right d-print-none">
            <ul class="uk-navbar-nav">
                <li>
                    @if(!empty($_SESSION['login']['ref_m_usertype_id']) && $_SESSION['login']['ref_m_usertype_id'] != SR_ADVOCATE && $_SESSION['login']['ref_m_usertype_id'] != AMICUS_CURIAE_USER)
                    <a href="{{base_url('search')}}" data-uk-icon="icon:search; ratio:1.2;" style="min-height: unset;"></a>
                    @endif
                </li>
                <li>
                    @if(file_exists($this->session->userdata['login']['photo_path']))
                    <a href="#" style="min-height: unset;"><img src="{{base_url($this->session->userdata['login']['photo_path'])}}"  style="height: 50px;width: 50px;border-radius: 50%;margin-top: -7px;display: inline-block;"></a>
                    @else
                    <a href="#" data-uk-icon="icon:user; ratio:1.2;" style="min-height: unset;"></a>
                    @endif
                    <div class="uk-navbar-dropdown uk-navbar-dropdown-bottom-left uk-padding-small" style="z-index:971 !important;">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                                @if($this->session->userdata['login']['aor_code']=='10017')
                                <li class="uk-nav-header1 uk-text-medium uk-text-primary">
                                    @else
                                <li class="uk-nav-header uk-text-medium uk-text-primary uk-text-capitalize">
                                @endif
                                @if(!empty($this->session->userdata['login']['impersonator_user']->id))
                                    <span class="uk-label uk-label-success" uk-tooltip="eFiling Assistant working on behalf of {{trim(ucwords(strtolower($this->session->userdata['login']['first_name'] . ' ' . $this->session->userdata['login']['last_name'])))}}">EA - {{trim(strtolower($this->session->userdata['login']['impersonator_user']->first_name . ' ' . $this->session->userdata['login']['impersonator_user']->last_name))}}</span>
                                    <br>
                                @endif
                                @if($this->session->userdata['login']['aor_code']=='10017')
                                <b>{{trim($this->session->userdata['login']['first_name'] . ' ' . $this->session->userdata['login']['last_name'])}}'s</b> ACCOUNT
                                @else
                                <b>{{trim(strtolower($this->session->userdata['login']['first_name'] . ' ' . $this->session->userdata['login']['last_name']))}}'s</b> ACCOUNT
                                @endif
                            </li>
                            <li><a href="{{base_url('my/profile')}}"><span data-uk-icon="icon: settings"></span> Profile</a></li>
                            <!--<li><a href="{{base_url('clerk/crud')}}"><span data-uk-icon="icon: users"></span> Add Clerk(s)</a></li>-->
                            <li class="uk-nav-divider"></li>
                            <li><a href="{{base_url('login/logout')}}"><span data-uk-icon="icon: sign-out"></span> Logout</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
            <!--<a href="#main-offcanvas" class="uk-navbar-toggle uk-hidden@l" uk-navbar-toggle-icon></a>-->
        </div>
        @endif
    </nav>
    @if(is_logged_in())
    <div id="main-offcanvas" class="d-print-none" uk-offcanvas="overlay:true;">
        <style type="text/css">
            /*.uk-open > .uk-offcanvas-bar-alt{
                left:0;
            }
            .uk-offcanvas-bar-alt{
                position: absolute;
                top: 0;
                bottom: 0;
                left: -270px;
                box-sizing: border-box;
                width: 270px;
                padding: 20px 20px;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }*/
            /***end-modifications in scutum***/
        </style>
        @if($this->session->userdata['login']['ref_m_usertype_id'] == SR_ADVOCATE)
            <div class="uk-offcanvas-bar md-bg-grey-50 md-color-grey-900 uk-padding-remove-horizontal uk-padding-small-top uk-width-medium">
                <button class="uk-offcanvas-close md-color-grey-900" type="button" uk-close></button>

                <div class="bgdark md-color-grey-900 uk-text-center" style="height:330px;" uk-margin>
                    <div class="uk-label uk-text-lead text-white uk-margin-medium-bottom" style="background-color:#1e87f0;padding:0.3rem 1.3rem;font-weight:500;">
                        <i class="mdi mdi-cloud-tags"></i>&nbsp;&nbsp;
                        SC-eFM
                    </div>
                    <div>
                        <img class="uk-border-circle" src="{{base_url('assets/responsive_variant/images/avatars/user-male-icon.png')}}" width="100" height="100" alt="Person Photo">
                    </div>
                    @if(!empty($this->session->userdata['login']['impersonator_user']->id))
                    <div>
                        <span class="uk-label uk-label-success" uk-tooltip="eFiling Assistant working on behalf of {{trim(ucwords(strtolower($this->session->userdata['login']['first_name'] . ' ' . $this->session->userdata['login']['last_name'])))}}">EA - {{trim(strtolower($this->session->userdata['login']['impersonator_user']->first_name . ' ' . $this->session->userdata['login']['impersonator_user']->last_name))}}</span>
                    </div>
                    @endif
                    <div class="uk-text-bold uk-text-capitalize">{{trim(strtolower($this->session->userdata['login']['first_name'] . ' ' . $this->session->userdata['login']['last_name']))}}</div>


                    <!--                @if($this->session->userdata['login']['ref_m_usertype_id']==USER_ADVOCATE)-->
    <!--                <div class="uk-article-meta md-color-grey-500">Advocate on Record (Code - {{$this->session->userdata['login']['aor_code']}})</div>-->
    <!--                @elseif($this->session->userdata['login']['ref_m_usertype_id']==USER_IN_PERSON)-->
    <!--                <div class="uk-article-meta md-color-grey-500">Party in Person</div>-->
    <!--                @endif-->
    <!--                <div class="uk-child-width-1-3" uk-grid>-->
    <!--                    <div>-->
    <!--                        <a href="{{base_url('my/profile')}}" uk-tooltip="Profile" class="uk-icon-button sc-icon-24 md-color-grey-500" style="width:42px;height:42px"><i class="mdi mdi-account-edit"></i></a>-->
    <!--                    </div>-->
    <!--                    <div>-->
    <!--                        <a href="{{base_url('cases')}}" uk-tooltip="Cases" class="uk-icon-button sc-icon-24 md-color-grey-500" style="width:42px;height:42px"><i class="mdi mdi-file-cabinet"></i></a>-->
    <!--                    </div>-->
    <!--                    <div>-->
    <!--                        <a href="{{base_url('clerk/crud')}}" uk-tooltip="Add Clerk" class="uk-icon-button sc-icon-24 md-color-grey-500" style="width:42px;height:42px"><i class="mdi mdi-account-plus"></i></a>-->
    <!--                    </div>-->
    <!--                </div>-->
                </div>
                <!--<hr class="uk-divider-icon uk-margin-remove-vertical">-->
                <div class="ukbackground-default uk-padding-small uk-child-width-1-2 ukgrid-medium" uk-grid>
                    <a href="{{base_url('dashboard')}}" style="text-decoration:none;">
                        <div class="{{current_url() == base_url('dashboard') ? 'bg-dark text-white' : ''}} md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                            <div class="uk-card-title">
                                <i class="mdi mdi-home sc-icon-36"></i>
                            </div>
                            <span>Home</span>
                        </div>
                    </a>
                    <a href="{{base_url('cases')}}" style="text-decoration:none;">
                        <div class="{{current_url() == base_url('cases') ? 'bg-dark text-white' : ''}} md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                            <div class="uk-card-title">
                                <i class="mdi mdi-file-cabinet sc-icon-36"></i>
                            </div>
                            <span>My Cases</span>
                        </div>
                    </a>
                    <a href="{{base_url('support')}}" style="text-decoration:none;">
                        <div class="{{current_url() == base_url('support') ? 'bg-dark text-white' : ''}} md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                            <div class="uk-card-title">
                                <i class="mdi mdi-help-circle-outline sc-icon-36"></i>
                            </div>
                            <span>Support</span>
                        </div>
                    </a>
                    <!--<a href="{{base_url('utilities')}}" style="text-decoration:none;">
                        <div class="{{current_url() == base_url('utilities') ? 'bg-dark text-white' : ''}} md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                            <div class="uk-card-title">
                                <i class="mdi mdi-file-document-edit-outline sc-icon-36"></i>
                            </div>
                            <span>Utilities</span>
                        </div>
                    </a>-->
                    <!--<a href="{{base_url('vakalatnama')}}" style="text-decoration:none;">
                        <div class="{{current_url() == base_url('vakalatnama') ? 'bg-dark text-white' : ''}} md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                            <div class="uk-card-title">
                                <i class="mdi mdi-file-document-edit-outline sc-icon-36"></i>
                            </div>
                            <span>vakalatnama</span>
                        </div>
                    </a>-->



    <!--                <a href="{{base_url('causelist')}}" style="text-decoration:none;">-->
    <!--                    <div class="{{current_url() == base_url('causelist') ? 'bg-dark text-white' : ''}} md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">-->
    <!--                        <div class="uk-card-title">-->
    <!--                            <i class="mdi mdi-format-list-numbered sc-icon-36"></i>-->
    <!--                        </div>-->
    <!--                        <span>Cause-List</span>-->
    <!--                    </div>-->
    <!--                </a>-->
                    <!--<a href="https://efiling.ecourts.gov.in/assets/downloads/efiling-User-manual.pdf" target="_blank" style="text-decoration:none;">-->
                    <!--<a href="{{base_url('Guide')}}"  style="text-decoration:none;">
                        <div class="md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                            <div class="uk-card-title">
                                <i class="mdi mdi-book-open-outline sc-icon-36"></i>
                            </div>
                            <span>Guides</span>
                        </div>
                    </a>-->
    <!--                <a href="{{base_url('e-services')}}"  style="text-decoration:none;">-->
    <!--                    <div class="md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">-->
    <!--                        <div class="uk-card-title">-->
    <!--                            <i class="mdi mdi-firefox sc-icon-36"></i>-->
    <!--                        </div>-->
    <!--                        <span>eFiling Services</span>-->
    <!--                    </div>-->
    <!--                </a>-->
    <!--                <a href="{{base_url('support')}}" style="text-decoration:none;">-->
    <!--                    <div class="{{current_url() == base_url('support') ? 'bg-dark text-white' : ''}} md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">-->
    <!--                        <div class="uk-card-title">-->
    <!--                            <i class="mdi mdi-help-circle-outline sc-icon-36"></i>-->
    <!--                        </div>-->
    <!--                        <span>Support</span>-->
    <!--                    </div>-->
    <!--                </a>-->
    <!--                <a href="{{base_url('utilities')}}" style="text-decoration:none;">-->
    <!--                    <div class="{{current_url() == base_url('utilities') ? 'bg-dark text-white' : ''}} md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">-->
    <!--                        <div class="uk-card-title">-->
    <!--                            <i class="mdi mdi-folder-settings-variant-outline sc-icon-36"></i>-->
    <!--                            <i class="mdi mdi-file-document-edit-outline sc-icon-36"></i>-->
    <!--                        </div>-->
    <!--                        <span>Utilities</span>-->
    <!--                    </div>-->
    <!--                </a>-->
                </div>
            </div>
        @else
        <div class="uk-offcanvas-bar md-bg-grey-50 md-color-grey-900 uk-padding-remove-horizontal uk-padding-small-top uk-width-medium">
            <button class="uk-offcanvas-close md-color-grey-900" type="button" uk-close></button>

            <div class="bgdark md-color-grey-900 uk-text-center" style="height:330px;" uk-margin>
                <div class="uk-label uk-text-lead text-white uk-margin-medium-bottom" style="background-color:#1e87f0;padding:0.3rem 1.3rem;font-weight:500;">
                    <i class="mdi mdi-cloud-tags"></i>&nbsp;&nbsp;
                    SC-eFM
                </div>
                <div>
                    <img class="uk-border-circle" src="{{base_url('assets/responsive_variant/images/avatars/user-male-icon.png')}}" width="100" height="100" alt="Person Photo">
                </div>
                @if(!empty($this->session->userdata['login']['impersonator_user']->id))
                <div>
                    <span class="uk-label uk-label-success" uk-tooltip="eFiling Assistant working on behalf of {{trim(ucwords(strtolower($this->session->userdata['login']['first_name'] . ' ' . $this->session->userdata['login']['last_name'])))}}">EA - {{trim(strtolower($this->session->userdata['login']['impersonator_user']->first_name . ' ' . $this->session->userdata['login']['impersonator_user']->last_name))}}</span>
                </div>
                @endif
                @if($this->session->userdata['login']['aor_code']=='10017')
                <div class="uk-text-bold ">{{trim($this->session->userdata['login']['first_name'] . ' ' . $this->session->userdata['login']['last_name'])}}</div>
                @else
                <div class="uk-text-bold uk-text-capitalize">{{trim(strtolower($this->session->userdata['login']['first_name'] . ' ' . $this->session->userdata['login']['last_name']))}}</div>
                @endif

                @if($this->session->userdata['login']['ref_m_usertype_id']==USER_ADVOCATE)
                <div class="uk-article-meta md-color-grey-500">Advocate on Record (Code - {{$this->session->userdata['login']['aor_code']}})</div>
                @elseif($this->session->userdata['login']['ref_m_usertype_id']==USER_IN_PERSON)
                <div class="uk-article-meta md-color-grey-500">Party in Person</div>
                @elseif($this->session->userdata['login']['ref_m_usertype_id']==AMICUS_CURIAE_USER)
                <div class="uk-article-meta md-color-grey-500">(Amicus Curiae)</div>
                @endif
                <div class="uk-child-width-1-3" uk-grid>
                    @if(!in_array($_SESSION['login']['ref_m_usertype_id'],array(AMICUS_CURIAE_USER)))
                    <div>
                        <a href="{{base_url('my/profile')}}" uk-tooltip="Profile" class="uk-icon-button sc-icon-24 md-color-grey-500" style="width:42px;height:42px"><i class="mdi mdi-account-edit"></i></a>
                    </div>
                    @endif
                    @if(!in_array($_SESSION['login']['ref_m_usertype_id'],array(ARGUING_COUNSEL,SR_ADVOCATE,AMICUS_CURIAE_USER,USER_CLERK)))
                    <div>
                        <a href="{{base_url('cases')}}" uk-tooltip="Cases" class="uk-icon-button sc-icon-24 md-color-grey-500" style="width:42px;height:42px"><i class="mdi mdi-file-cabinet"></i></a>
                    </div>
                    @endif
                    <!--<div>
                        <a href="{{base_url('clerk/crud')}}" uk-tooltip="Add Clerk" class="uk-icon-button sc-icon-24 md-color-grey-500" style="width:42px;height:42px"><i class="mdi mdi-account-plus"></i></a>
                    </div>-->
                    @if($this->session->userdata['login']['ref_m_usertype_id']==USER_ADVOCATE)
                    <div class="uk-child-width-1-3" uk-grid>
                        <div>
                            <a href="{{base_url('register/arguingCounsel')}}" uk-tooltip="Add Advocate" class="uk-icon-button sc-icon-24 md-color-grey-500" style="width:42px;height:42px"><i class="mdi mdi-account-plus"></i></a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <!--<hr class="uk-divider-icon uk-margin-remove-vertical">-->
            <div class="ukbackground-default uk-padding-small uk-child-width-1-2 ukgrid-medium" uk-grid>
                <a href="{{base_url('dashboard')}}" style="text-decoration:none;">
                    <div class="{{current_url() == base_url('dashboard') ? 'bg-dark text-white' : ''}} md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                        <div class="uk-card-title">
                            <i class="mdi mdi-home sc-icon-36"></i>
                        </div>
                        <span>Home</span>
                    </div>
                </a>
                @if(!in_array($_SESSION['login']['ref_m_usertype_id'],array(ARGUING_COUNSEL,SR_ADVOCATE,USER_CLERK)))
                <a href="{{base_url('cases')}}" style="text-decoration:none;">
                    <div class="{{current_url() == base_url('cases') ? 'bg-dark text-white' : ''}} md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                        <div class="uk-card-title">
                            <i class="mdi mdi-file-cabinet sc-icon-36"></i>
                        </div>
                        <span>Cases</span>
                    </div>
                </a>
                @endif
                <!--<a href="{{base_url('causelist')}}" style="text-decoration:none;">
                    <div class="{{current_url() == base_url('causelist') ? 'bg-dark text-white' : ''}} md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                        <div class="uk-card-title">
                            <i class="mdi mdi-format-list-numbered sc-icon-36"></i>
                        </div>
                        <span>Cause-List</span>
                    </div>
                </a>-->
                <!--<a href="https://efiling.ecourts.gov.in/assets/downloads/efiling-User-manual.pdf" target="_blank" style="text-decoration:none;">-->
                <!--<a href="{{base_url('Guide')}}"  style="text-decoration:none;">
                    <div class="md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                        <div class="uk-card-title">
                            <i class="mdi mdi-book-open-outline sc-icon-36"></i>
                        </div>
                        <span>Guides</span>
                    </div>
                </a>
                -->
                <!--@if(!in_array($_SESSION['login']['ref_m_usertype_id'],array(ARGUING_COUNSEL,SR_ADVOCATE)))
                <a href="{{base_url('e-services')}}"  style="text-decoration:none;">
                    <div class="md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                        <div class="uk-card-title">
                            <i class="mdi mdi-firefox sc-icon-36"></i>
                        </div>
                        <span>eFiling Services</span>
                    </div>
                </a>
                @endif-->
                @if(!in_array($_SESSION['login']['ref_m_usertype_id'],array(AMICUS_CURIAE_USER)))
                <a href="{{base_url('support')}}" style="text-decoration:none;">
                    <div class="{{current_url() == base_url('support') ? 'bg-dark text-white' : ''}} md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                        <div class="uk-card-title">
                            <i class="mdi mdi-help-circle-outline sc-icon-36"></i>
                        </div>
                        <span>Support</span>
                    </div>
                </a>
                @endif
                @if(!in_array($_SESSION['login']['ref_m_usertype_id'],array(ARGUING_COUNSEL,SR_ADVOCATE,AMICUS_CURIAE_USER)))
                <a href="{{base_url('e-resources')}}"  style="text-decoration:none;">
                    <div class="md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                        <div class="uk-card-title">
                            <i class="mdi mdi-book sc-icon-36"></i>
                        </div>
                        <span>Resources</span>
                    </div>
                </a>
                @endif
                @if(in_array($_SESSION['login']['ref_m_usertype_id'],array(USER_ADVOCATE)))
                <a href="{{base_url('admin/Noc_vakalatnama/get_transferred_cases')}}"  style="text-decoration:none;">
                    <div class="md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                        <div class="uk-card-title">
                            <i class="mdi mdi-book-plus sc-icon-36"></i>
                        </div>
                        <span>Transferred cases</span>
                    </div>
                </a>
                <a href="{{base_url('admin/PrepareTemplate_Controller/prepared_templates_download?case=P')}}"  style="text-decoration:none;">
                    <div class="md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                        <div class="uk-card-title">
                            <i class="mdi mdi-book-plus sc-icon-36"></i>
                        </div>
                        <span>Download Templates</span>
                    </div>
                </a>
                <?php  if(is_vacation_advance_list_duration()){ ?>
                <a href="{{base_url('vacation/advance')}}"  style="text-decoration:none;">
                    <div class="md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                        <div class="uk-card-title">
                            <i class="mdi mdi-book-plus sc-icon-36"></i>
                        </div>
                        <span>Advance Summer Vacation List</span>
                    </div>
                </a>
                <?php }?>
                <a href="{{base_url('clerks/Clerk_Controller/add_clerk')}}"  style="text-decoration:none;">
                    <div class="md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                        <div class="uk-card-title">
                            <i class="mdi mdi-account-plus"></i>
                        </div>
                        <span>Add Clerk</span>
                    </div>
                </a>
                @endif
                <a href="{{base_url('generate_template/GenerateTemplate_Controller/index')}}?case=P"  style="text-decoration:none;">
                    <div class="md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                        <div class="uk-card-title">
                            <i class="mdi mdi-book-plus sc-icon-36"></i>
                        </div>
                        <span>Generate Template</span>
                    </div>
                </a>
                <!--<a href="{{base_url('utilities')}}" style="text-decoration:none;">
                    <div class="{{current_url() == base_url('utilities') ? 'bg-dark text-white' : ''}} md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                        <div class="uk-card-title">
                            <i class="mdi mdi-file-document-edit-outline sc-icon-36"></i>
                        </div>
                        <span>Utilities</span>
                    </div>
                </a>
                <a href="{{base_url('vakalatnama')}}" style="text-decoration:none;">
                    <div class="{{current_url() == base_url('vakalatnama') ? 'bg-dark text-white' : ''}} md-color-grey-600 uk-border-rounded uk-card-hover uk-text-center uk-padding-small">
                        <div class="uk-card-title">
                            <i class="mdi mdi-file-document-edit-outline sc-icon-36"></i>
                        </div>
                        <span>Vakalatnama</span>
                    </div>
                </a>
                -->

            </div>
        </div>
        @endif

    </div>
    @endif
</header>
@show


@section('content-container')

<!--suppress CssInvalidAtRule -->
<style type="text/css">
    @section('content-container-ribbon')
        #content-container::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 0;
            pointer-events: none;
            height: 390px;
            background-color: #343a40;
            border-bottom-left-radius: 2.5rem;
        }
    @show
    /*.uk-sticky.uk-active.new-application-btn-container{
        right:115px;
    }
    .uk-sticky.uk-active.new-application-btn-container .new-application-mini-btn{
        right:-50px !important;
    }*/
</style>
<main id="content-container" role="main" class="uk-container uk-container-expand">
    @if(is_logged_in() && !in_array($_SESSION['login']['ref_m_usertype_id'],array(ARGUING_COUNSEL,SR_ADVOCATE)))
        <div class="uk-position-fixed uk-position-small uk-position-bottom-left new-application-btn-container" style="z-index:970;margin-top:3.2rem;">
            <div>
                <button class="sc-button sc-button-large sc-button-success text-white uk-flex uk-flex-middle uk-visible@m new-application-btn" type="button" style="height:54px;">
                    <i uk-icon="plus-circle"></i>&nbsp;&nbsp;&nbsp;
                    <span class="uk-text-large">New</span>
                </button>
                <button class="sc-fab scfab-large uk-border-rounded sc-fab-success uk-hidden@m new-application-mini-btn" type="button" style="width:54px;height:54px;">
                    <i uk-icon="icon:plus-circle;ratio:2"></i>
                </button>
            </div>
            <div class="uk-padding-remove md-bg-grey-700" uk-dropdown="pos:left-bottom;">
                <ul class="uk-nav-primary uk-nav-parent-icon uk-dropdown-nav" uk-nav>
                    @if(!in_array($_SESSION['login']['ref_m_usertype_id'],array(AMICUS_CURIAE_USER)))
                    @if(in_array($_SESSION['login']['id'],AIASSISTED_USER_IN_LIST))
                    <li class="" uk-tooltip="title:File a fresh case;pos:right"><a href="{{base_url('casewithAI')}}" class="md-color-grey-50"><span class="uk-margin-small-right" ukicon="icon: location"></span> AI Assisted Case Filing</a></li>
                    @endif
                    <li class="" uk-tooltip="title:File a fresh case;pos:right"><a href="{{base_url('case/crud')}}" class="md-color-grey-50"><span class="uk-margin-small-right" ukicon="icon: location"></span> Case</a></li>
                    <!--<li class="uk-nav-divider uk-margin-remove"></li>
                    <li class="" uk-tooltip="title:Mention case for early hearing;pos:right"><a href="{{base_url('case/mentioning/crud')}}" class="md-color-grey-50"><span class="uk-margin-small-right" ukicon="icon: bookmark"></span> Mentioning</a></li>-->
                    <li class="uk-nav-divider uk-margin-remove"></li>
                    <li class="" uk-tooltip="title:File fresh interlocutory application;pos:right"><a href="{{base_url('case/interim_application/crud')}}" class="md-color-grey-50"><span class="uk-margin-small-right" ukicon="icon: bookmark"></span> IA</a></li>
                    <li class="uk-nav-divider uk-margin-remove"></li>
                    <li class="" uk-tooltip="title:File miscellaneous documents in your cases; pos:right"><a href="{{base_url('case/document/crud')}}" class="md-color-grey-50"><span class="uk-margin-small-right" ukicon="icon: bookmark"></span> Misc. Docs</a></li>
                    <!--<li class="uk-nav-divider uk-margin-remove"></li>
                    <li class="" uk-tooltip="title:Submit citations for judgements and laws;pos:right"><a href="{{base_url('case/citation/crud')}}" class="md-color-grey-50"><span class="uk-margin-small-right" ukicon="icon: bookmark"></span> Citations</a></li>-->
                    <li class="uk-nav-divider uk-margin-remove"></li>
                    <li class="" uk-tooltip="title:Raise Caveat;pos:right"><a href="{{base_url('case/caveat/crud')}}" class="md-color-grey-50"><span class="uk-margin-small-right" ukicon="icon: bookmark"></span> Caveat</a></li>
                    <!--<li class="uk-nav-divider uk-margin-remove"></li>
                    <li class="" uk-tooltip="title:Raise Request for Custody or Surrender Certificate;pos:right"><a href="{{base_url('case/certificate/crud')}}" class="md-color-grey-50"><span class="uk-margin-small-right" ukicon="icon: bookmark"></span> Certificate Request</a></li>
-->
                    <!--<li class="uk-nav-divider uk-margin-remove"></li>
                    <li class="" uk-tooltip="title:Raise Caveat;pos:right"><a href="{{base_url('case/caveat/crud')}}" class="md-color-grey-50"><span class="uk-margin-small-right" ukicon="icon: bookmark"></span> Caveat</a></li>-->
                    <!--<li class="uk-nav-divider uk-margin-remove"></li>
                    <li class="" uk-tooltip="title:Mention case for early hearing;pos:right"><a href="{{base_url('case/mentioning/crud')}}" class="md-color-grey-50"><span class="uk-margin-small-right" ukicon="icon: bookmark"></span> Mentioning</a></li>-->
                    @if(!in_array($_SESSION['login']['ref_m_usertype_id'],array(USER_CLERK)))
                    <li class="uk-nav-divider uk-margin-remove"></li>
                    <li class="" uk-tooltip="title:Refile old e-filing cases ;pos:right"><a href="{{base_url('case/refile_old_efiling_cases/crud')}}" class="md-color-grey-50"><span class="uk-margin-small-right" ukicon="icon: bookmark"></span> Refile old e-filing cases</a></li>
                    @endif
                    @endif
                    @if(in_array($_SESSION['login']['ref_m_usertype_id'],array(AMICUS_CURIAE_USER)))
                    <li class="uk-nav-divider uk-margin-remove"></li>
                    <li class="" uk-tooltip="title:File fresh interlocutory application;pos:right"><a href="{{base_url('case/interim_application/crud')}}" class="md-color-grey-50"><span class="uk-margin-small-right" ukicon="icon: bookmark"></span> IA</a></li>
                    <li class="uk-nav-divider uk-margin-remove"></li>
                    <li class="" uk-tooltip="title:File miscellaneous documents in your cases; pos:right"><a href="{{base_url('case/document/crud')}}" class="md-color-grey-50"><span class="uk-margin-small-right" ukicon="icon: bookmark"></span> Misc. Docs</a></li>
                    @endif

                </ul>
            </div>
        </div>
    @endif

    <div class="ukgrid-collapse uk-position-relative uk-margin-small-top" style="z-index:2;" uk-grid>
        @section('pinned-main-offcanvas')
        <div class="uk-width-1-5 uk-visible@l" uk-margin>
            @include('responsive_variant.layouts.master.uikit_scutum_2.pinned_main_offcanvas')
        </div>
        @show
        <div id="content" class="uk-width-expand">
            @section('heading-container')
                @if(is_logged_in())
                    <div id="heading-container" class="bgdark textwhite uk-margin-small-bottom">
                        <div class="uk-flex uk-flex-between@m uk-flex-right" ukgrid>
                            <h2 class="textwhite uk-margin-remove uk-visible@m ukwidth-expand"><a href="{{current_url()}}" class="uk-button-text uk-text-capitalize">@yield('heading')</a></h2>
                            <!--<div class="uk-inline ukwidth-auto new-application-btn-container" uk-sticky="offset:15;top: #heading-container">
                                <div>
                                    <button class="sc-button sc-button-large sc-button-success text-white uk-flex uk-flex-middle uk-visible@m new-application-btn" type="button">
                                        <i uk-icon="plus-circle"></i>&nbsp;&nbsp;&nbsp;
                                        <span class="uk-text-large">New</span>
                                    </button>
                                    <button class="sc-fab scfab-large uk-border-rounded sc-fab-success uk-hidden@m new-application-mini-btn" type="button">
                                        <i uk-icon="icon:plus-circle;ratio:2"></i>
                                    </button>
                                </div>
                                <div class="uk-padding-remove" uk-dropdown="pos:left-bottom;">
                                    <ul class="uk-nav-primary uk-nav-parent-icon uk-dropdown-nav" uk-nav>
                                        <li class=""><a href="{{base_url('case/crud')}}"><span class="uk-margin-small-right" ukicon="icon: location"></span> Case</a></li>
                                        <li class="uk-nav-divider uk-margin-remove"></li>
                                        <li class=""><a href="{{base_url('case/mentioning/crud')}}"><span class="uk-margin-small-right" ukicon="icon: bookmark"></span> Mentioning</a></li>
                                        <li class="uk-nav-divider uk-margin-remove"></li>
                                        <li class=""><a href="{{base_url('case/interim_application/crud')}}"><span class="uk-margin-small-right" ukicon="icon: bookmark"></span> IA</a></li>
                                        <li class="uk-nav-divider uk-margin-remove"></li>
                                        <li class=""><a href="{{base_url('case/document/crud')}}"><span class="uk-margin-small-right" ukicon="icon: bookmark"></span> Misc. Docs</a></li>
                                    </ul>
                                </div>
                            </div>-->
                        </div>
                        <!--<div>
                            <span class="uk-label uk-label-danger">Covid-19</span>&nbsp;&nbsp;Please stay home and stay safe. Wish you a healthy life.
                        </div>-->
                    </div>
                    <!--<hr>-->
                @endif
            @show

            @yield('content_prefix')
            @yield('content')
            @yield('content_suffix')
        </div>
    </div>
</main>

<!--<div id="paper-book-viewer-modal" class="uk-modal-full uk-modal uk-open" uk-modal="bg-close:false;esc-close:false;" style="display: block;">
    <div class="uk-modal-dialog uk-height-1-1 ukoverflow-auto" ukoverflow-auto="" uk-height-viewport="offset-top: 200;">
        <button type="button" onclick="UIkit.modal('#paper-book-viewer-modal').hide()" class="uk-button bg-danger">Close</button>
    </div>
</div>-->
<!--<a class="uk-button uk-button-default" href="#paper-book-viewer-modal" uk-toggle>Open</a>-->

<div id="paper-book-viewer-modal" class="uk-modal-full" uk-modal="bg-close:false;esc-close:false;">
    <div class="uk-modal-dialog" uk-overflow-auto>
        <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>

        <iframe src="" height="100%" width="100%" scrolling frameborder="no" uk-height-viewport></iframe>
    </div>
</div>
@show


@section('footer')
<footer class="uk-margin-medium-top d-print-none">

</footer>
@show


<script src="{{base_url('assets/responsive_variant/frameworks/uikit_3-4-1/js/uikit.min.js')}}"></script>
<script src="{{base_url('assets/responsive_variant/frameworks/uikit_3-4-1/js/uikit-icons.min.js')}}"></script>

<!-- scutum JS -->
<script type="text/javascript" src="{{base_url('assets/responsive_variant/templates/uikit_scutum_2/assets/js/vendor.min.js')}}"></script>
<script type="text/javascript" src="{{base_url('assets/responsive_variant/templates/uikit_scutum_2/assets/js/vendor/loadjs.js')}}"></script>
<script type="text/javascript" src="{{base_url('/assets/responsive_variant/templates/uikit_scutum_2/assets/js/scutum_common.js')}}"></script>

<script type="text/javascript" src="<?= base_url().'assets'?>/js/case_status/common.js"></script>



<script type="text/javascript" src="<?= base_url().'assets'?>/js/case_status/bootstrap.min.js"></script>

<!--<script src="/assets/clusterize/js/clusterize.min.js"></script>-->
<!--<script src="{{base_url('assets/responsive_variant/js/lodash_4-17-15/lodash.js')}}"></script>-->
<!--<script type="text/javascript" src="/js/sweetalert.min.js" defer></script>-->
<!--<script type="text/javascript" src="/js/common.js"></script>-->
<!--@stack('scripts')-->
<script type="text/javascript" src="<?=base_url()?>assets/js/aes.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/aes-json-format.js"></script>
<script type="text/javascript">
    function loadPaperBookViewer(obj){
        $('#paper-book-viewer-modal iframe').attr('src', $(obj).data('paper-book-viewer-url'));
        UIkit.modal('#paper-book-viewer-modal').show();
    }
    $(function () {
        $('#loading-overlay').hide();
        /*****start-code to adjust height of iframes*****/
        try {
            if ($.browser.safari || $.browser.opera) {
                $('.internal-content-iframe').on('load', function () {
                    setTimeout(function () {
                        $('.internal-content-iframe')[0].style.height = ($('.internal-content-iframe')[0].contentWindow.document.body.offsetHeight + 100) + 'px';
                    }, 100);
                });

                var iSource = $('.internal-content-iframe')[0].src;
                $('.internal-content-iframe')[0].src = '';
                $('.internal-content-iframe')[0].src = iSource;
            } else {
                $('.internal-content-iframe').on('load', function () {
                    setTimeout(function () {
                        $('.internal-content-iframe')[0].style.height = ($('.internal-content-iframe')[0].contentWindow.document.body.offsetHeight + 100) + 'px';
                    }, 500);
                });
            }
            setInterval(function () {
                try {
                    $('.internal-content-iframe')[0].style.height = $('.internal-content-iframe')[0].contentWindow.document.body.offsetHeight + 'px';
                }
                catch(e){}
            }, 3000);
        } catch(e){}
        /*****start-code to adjust height of iframes*****/
    });

    /*****start-$.browser feature extract, which has been removed in new jQuery version*****/
    var matched, browser;

    jQuery.uaMatch = function( ua ) {
        ua = ua.toLowerCase();

        var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
            /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
            /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
            /(msie) ([\w.]+)/.exec( ua ) ||
            ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
            [];

        return {
            browser: match[ 1 ] || "",
            version: match[ 2 ] || "0"
        };
    };

    matched = jQuery.uaMatch( navigator.userAgent );
    browser = {};

    if ( matched.browser ) {
        browser[ matched.browser ] = true;
        browser.version = matched.version;
    }

    // Chrome is Webkit, but Webkit is also Safari.
    if ( browser.chrome ) {
        browser.webkit = true;
    } else if ( browser.webkit ) {
        browser.safari = true;
    }

    jQuery.browser = browser;
    /*****end-$.browser feature extract, which has been removed in new jQuery version*****/
</script>

@if(is_logged_in())
    <!-- Start of Rocket.Chat Livechat Script -->
    <!--<script type="text/javascript">
        (function(w, d, s, u) {
            w.RocketChat = function(c) { w.RocketChat._.push(c) }; w.RocketChat._ = []; w.RocketChat.url = u;
            var h = d.getElementsByTagName(s)[0], j = d.createElement(s);
            j.async = true; j.src = 'https://registry.sci.gov.in/rocket_chat/livechat/rocketchat-livechat.min.js?_=201903270000';
            h.parentNode.insertBefore(j, h);
        })(window, document, 'script', 'https://registry.sci.gov.in/rocket_chat/livechat');
        RocketChat(function() {
            this.setDepartment('eFiling');
            this.setGuestName('{{ucwords(strtolower($this->session->userdata['login']['first_name'] . ' ' . $this->session->userdata['login']['last_name'])) . ' (AOR - ' .$_SESSION['login']['aor_code']. ')'}}');
            this.setGuestEmail('{{$_SESSION['login']['emailid']}}');
            this.setCustomField('aorCode', '{{@$_SESSION['login']['aor_code']}}');//todo:customize this as per user type
            //todo:make provision for an authenticationJwt, which will then be analyzed by a cron on server every few seconds. Only valid logged in users will be allowed to be assigned to agents. No chat will directly be able to be forwarded to an agent in future.
        });
    </script>-->
    <!-- End of Rocket.Chat Livechat Script -->
@endif

</body>
</html>
