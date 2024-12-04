@if(getSessionData('login')['ref_m_usertype_id'] == USER_ADMIN)
    @extends('layout.app')
@else
    @extends('layout.advocateApp')
@endif
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="dash-card dashboard-section">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class=" dashboard-bradcrumb">
                                <div class="left-dash-breadcrumb">
                                    <div class="page-title">
                                        <h5><i class="fa fa-file"></i> Contact Us </h5>
                                    </div>
                                    <div class="form-response" id="msg" role="alert" data-auto-dismiss="5000"></div>
                                </div>
                                <div class="ryt-dash-breadcrumb">
                                    <div class="btns-sec">
                                        <!-- <a href="javascript:void(0)" class="quick-btn pull-right mb-2" onclick="window.history.back()"><span class="mdi mdi-chevron-double-left"></span>Back</a> -->
                                        <a href="javascript:void(0)" onclick="window.history.back()" class="quick-btn pull-right"><span class="mdi mdi-chevron-double-left"></span>Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dash-card dashboard-section">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="right_col" role="main">
                                    <div class="">
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="x_panel">
                                                    <!-- <div class="x_title">
                                                        <h2> <i class="fa fa-envelope"></i> Contact Us</h2>
                                                        <div class="clearfix"></div>
                                                    </div> -->
                                                    <div class="x_content">
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="center">
                                                                    <h4>The Registrar,</h4>
                                                                    <h5>Supreme Court of India,</h5>
                                                                    <h6>Tilak Marg, New Delhi - 110001</h6>
                                                                    <p>011-23388922-24,23388942</p>
                                                                    <p>FAX : 011-23381508,23381584</p>
                                                                    <p>e-mail : efiling[at]sci[dot]nic[dot]in</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Main End --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection