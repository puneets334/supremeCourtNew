<?php 
if(isset($_SESSION['login'])){
    $ex = 'layout.advocateApp';
}else{
    $ex = 'layout.frontApp';
}
?>
@extends($ex)
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="dashboard-section dashboard-tiles-area"></div>
                <div class="dashboard-section">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="dash-card">
                                {{-- Page Title Start --}}
                                <?php if(isset($_SESSION['login'])) { ?>
                                    <div class="title-sec">
                                        <h5 class="unerline-title">Resources</h5>
                                        <a href="javascript:void(0)" class="quick-btn pull-right" onclick="window.history.back()"><span class="mdi mdi-chevron-double-left"></span>Back</a>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a href="{{base_url('resources/hand_book')}}" aria-current="page" class="nav-link {{(current_url() == base_url('support') || current_url() == base_url('resources/hand_book')) ? 'active' : ''}}">Hand Book</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{base_url('resources/video_tutorial/view')}}" aria-current="page" class="nav-link {{current_url() == base_url('resources/video_tutorial/view') ? 'active' : ''}}">Video Tutorial</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{base_url('resources/FAQ')}}" aria-current="page" class="nav-link {{current_url() == base_url('resources/FAQ') ? 'active' : ''}}">FAQ</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{base_url('resources/hand_book_old_efiling')}}" aria-current="page" class="nav-link {{current_url() == base_url('resources/hand_book_old_efiling') ? 'active' : ''}}">Refile Old Efiling Cases</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{base_url('resources/Three_PDF_user_manual')}}" aria-current="page" class="nav-link {{current_url() == base_url('resources/Three_PDF_user_manual') ? 'active' : ''}}">3PDF User Manual</a>
                                        </li>
                                    </ul>
                                <?php } ?>
                                {{-- Page Title End --}}
                                {{-- Main Start --}}
                                <div class="right_col" role="main">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div id="msg">
                                                <?php echo getSessionData('MSG'); ?>
                                            </div> 
                                        </div>
                                    </div>    
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">            
                                            <div class="x_panel">                
                                                <?php if (getSessionData('login') != '' && getSessionData('login')['ref_m_usertype_id'] == USER_ADMIN) { ?>
                                                    <div class="x_title">
                                                        <h2><i class="fa  fa-newspaper-o"></i>3PDF User Manual</h2>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content"></div>
                                                <?php } else { ?> 
                                                    <h2><i class="fa  fa-newspaper-o"></i>3PDF User Manual</h2>
                                                    <div class="clearfix"></div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>        
                                    <!------------Table--------------------->
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="x_panel">
                                                <div class="x_content">
                                                    <div>3PDF User Manual</div>
                                                    <embed src="<?php echo base_url('/uploaded_docs/user_manual/3pdf_user_manual.pdf'); ?>" type="application/pdf" width="100%" height="800">
                                                </div>
                                            </div>
                                        </div>
                                        <!------------Table--------------------->
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