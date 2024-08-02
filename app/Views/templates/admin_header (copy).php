<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $allow_image_url = parse_url($this->session->userdata['login']['photo_path']);
        header("X-Frame-Options: DENY");
        header("X-XSS-Protection: 1; mode=block");
        header("X-Content-Type-Options: nosniff");
        header("Strict-Transport-Security: max-age=31536000");
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        echo '<meta http-equiv="Content-Security-Policy" content="default-src \'self\' ' . $allow_image_url['host'] . ' http://xxxx \'unsafe-inline\' \'unsafe-eval\';  font-src \'self\' data: ">';
        ?>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>eFiling | Admin </title>
        <link href="<?= base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('assets/vendors/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('assets/vendors/nprogress/nprogress.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('assets/build/css/custom.min.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('assets/build/css/custom.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/jquery-ui.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/select2.min.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/header_css.css'); ?>" rel="stylesheet"> 

        <script type="text/javascript"> var base_url = '<?php echo base_url(); ?>';</script>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery-main.js'); ?>"></script>
        <script src="<?= base_url('assets/js/jquery-ui.min.js'); ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery_validation.js'); ?>" ></script>
        <script type="text/javascript" src="<?= base_url('assets/js/header.js'); ?>" ></script>
    </head> 
    <?php
    $bg_color = "#EDEDED;";
    $bg_border = "#EDEDED;border-right: 0.1px solid rgba(92, 80, 80, 0.3)";
    ?>
    <body class="nav-sm" style="background-color:<?php echo $bg_color; ?>">
        <div class="container body" >
            <div class="main_container">
                <div class="col-md-3 left_col" style="background-color:<?php echo $bg_border; ?>">
                    <div class="left_col scroll-view" style="background-color:<?php echo $bg_color; ?>">
                        <div class="navbar nav_title" style="background-color:<?php echo $bg_border; ?>">
                            <a href="<?= base_url('login'); ?>" class="site_title"><span class="text_color"><i class="fa fa-gavel"></i> <span>e-Filing</span></span></a>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="hr_class">

                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                            <div class="menu_section">
                                <?php
                                if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN) {
                                    $href = base_url('admin');
                                } elseif ($this->session->userdata['login']['ref_m_usertype_id'] == USER_DISTRICT_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_MASTER_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_SUPER_ADMIN) {
                                    $href = base_url('admin/work_done');
                                } elseif ($this->session->userdata['login']['ref_m_usertype_id'] == USER_BAR_COUNCIL) {
                                    $href = base_url('Bar_council');
                                }

                                if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN) {
                                    $url = base_url("admin_stages/view/" . htmlentities(url_encryption(New_Filing_Stage, ENT_QUOTES)));
                                    $title = " eFiled";
                                } if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_DISTRICT_ADMIN) {
                                    $url = base_url('district_admin/change_case_status/');
                                    $title = " Administration";
                                } if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_MASTER_ADMIN) {
                                    $url = base_url('master_admin/change_case_status/');
                                    $title = " Administration";
                                } if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_SUPER_ADMIN) {
                                    $url = base_url('supadmin/change_case_status/');
                                    $title = " Administration";
                                }
                                ?>  

                                <div class="show_md_div legend list-unstyled visible-lg visible-md center nav-md" style="display: none !important;">
                                    <div class="row">
                                        <div class="col-lg-10 col-md-10 col-md-offset-1">
                                            <?php if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_BAR_COUNCIL) { ?>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6"><a href="<?= $href; ?>" class="btn btn-info btn-xs"><i class="fa fa-home" style="font-size:15px"></i> Home</a></div>
                                                    <a href="<?= base_url() . 'Bar_council/new_register/' . url_encryption('new_request') ?>" class="btn btn-success btn-xs"><i class="fa fa-user-plus" style="font-size:15px"></i>Registration</a>
                                                </div>
                                            <?php } ?>
                                            <?php if ($this->session->userdata['login']['ref_m_usertype_id'] != USER_BAR_COUNCIL) { ?>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6"><a href="<?= $href; ?>" class="btn btn-info btn-sm"><i class="fa fa-home" style="font-size:15px"></i> Home</a></div>
                                                    <div class="col-lg-6 col-md-6"><a href="<?= base_url('admin/work_done'); ?>" class="btn btn-dark btn-sm"><i class="fa fa-database" style="font-size:15px"></i> Reports </a> <br></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6"><a href="<?= base_url('digital_copy'); ?>" class="btn btn-default btn-sm"><i class="fa fa-file" style="font-size:15px"></i> ePaper Book</a></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <?php if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_DISTRICT_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_MASTER_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_SUPER_ADMIN) { ?>
                                                            <a href="<?php echo $url; ?>" class="btn btn-primary btn-sm"><i class="fa fa-database" style="font-size:15px"></i><?php echo $title; ?></a>
                                                        <?php } if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADMIN || $_SESSION['login']['ref_m_usertype_id'] == USER_MASTER_ADMIN || $_SESSION['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN) { ?>
                                                            <a href="<?= base_url() . 'admin/new_registration/' . url_encryption('new_request') ?>" class="btn btn-success btn-sm"><i class="fa fa-user-plus" style="font-size:15px"></i>Registration</a>

                                                        <?php } ?> 
                                                        <?php if ($this->session->userdata['login']['ref_m_usertype_id'] != USER_SUPER_ADMIN) { ?>
                                                            <a href="<?= base_url('news_event/'); ?>" class="btn btn-warning btn-sm"><i class="fa fa-question-circle" style="font-size:15px"></i>Assistance</a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div> 
                                <ul class="nav side-menu" >
                                    <?php if ($this->uri->segment(1) == 'Bar_council' && $this->uri->segment(2) != 'new_register') { ?>
                                        <li class="highlight_tab"><a class="active_tab "><i class="fa fa-user-plus fa-fw" style="color:#fff;"></i><strong style="color:#fff;"> home </strong> </a></li>
                                    <?php } ?>
                                    <?php if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_ADMIN && empty($this->uri->segment(2)) && $this->uri->segment(1) == 'admin' || $this->session->userdata['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN) { ?>
                                        <li class="highlight_tab"><a  class="text_cursor active_tab text_position"><i class="fa fa-home fa-fw" style="color:#fff;"></i> <strong style="color:#fff;"> Home</strong> </a> </li>
                                    <?php } ?>

                                    <?php if ($this->uri->segment(2) == 'work_done' || $this->uri->segment(2) == 'work_done_filter' || $this->uri->segment(2) == 'court_fee_details' || $this->uri->segment(2) == 'transaction_details' || $this->uri->segment(2) == 'admin_users_list') { ?>
                                        <li class="highlight_tab"><a class="text_cursor active_tab text_position"><i class="fa fa-files-o fa-fw" style="color:#fff;"></i> <strong style="color:#fff;"> Reports</strong> </a> </li>
                                        <div class="show_md_div visible-lg visible-md" style="display: none !important;">
                                            <ul class="nav side-menu">
                                                <li class="highlight"><a href="<?= base_url('admin/work_done'); ?>"> <strong class="text_color"><i class="fa fa-check fa-fw"></i> Work Done</strong></a></li>
                                                <li class="highlight"><a href="<?= base_url('admin/work_done_filter'); ?>"> <strong class="text_color"><i class="fa fa-check fa-fw"></i> efiling Done</strong></a></li>

                                                <?php if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_SUPER_ADMIN) { ?>
                                                    <li class="highlight"><a href="<?= base_url('admin/login_logs'); ?>"><strong class="text_color"><i class="fa fa-bars fa-fw"></i> View Login Log Details </strong> </a></li>                                        
                                                <?php } ?>
                                                <?php if ($this->session->userdata['login']['ref_m_usertype_id'] != USER_SUPER_ADMIN && $this->session->userdata['login']['ref_m_usertype_id'] != USER_DISTRICT_ADMIN && $this->session->userdata['login']['ref_m_usertype_id'] != USER_MASTER_ADMIN) { ?>
                                                    <li class="highlight"><a href="<?= base_url('admin/court_fee_details') ?>"><strong class="text_color"><i class="fa fa-rupee fa-fw"></i> Fees Paid</strong></a></li>                                               

                                                    <?php
                                                    if ($this->session->userdata['login']['ref_m_usertype_id'] != USER_SUPER_ADMIN &&
                                                            $this->session->userdata['login']['ref_m_usertype_id'] != USER_DISTRICT_ADMIN && $this->session->userdata['login']['ref_m_usertype_id'] != USER_MASTER_ADMIN && ENABLE_TRANSACTION_DETAIL) {
                                                        ?>
                                                        <li class="highlight"><a href="<?= base_url('admin/transaction_details'); ?>"><strong class="text_color"><i class="fa fa-list fa-fw"></i> Transaction Details</strong></a></li>
                                                        <?php if (ENABLE_SBI_PAYMENT_GATEWAY) { ?>                                                    
                                                            <li class="highlight"><a href="<?= base_url('sbi_payment_info'); ?>"><strong class="text_color"><i class="fa fa-outdent fa-fw"></i> SBI MIS</strong></a></li>
                                                            <li class="highlight"><a href="<?= base_url('sbi_payment_info/payout_info'); ?>"><strong class="text_color"><i class="fa fa-list fa-fw"></i> SBI Payout</strong></a></li>
                                                            <li class="highlight"><a href="<?= base_url('sbi_payment_info/sbi_report'); ?>"><strong class="text_color"><i class="fa fa-chain-broken fa-fw"></i> Mismatch Report</strong></a></li>
                                                            <?php
                                                        }
                                                    }
                                                    if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_MASTER_ADMIN) {
                                                        ?>
                                                        <li class="highlight"><a href="<?= base_url('admin/login_logs'); ?>"><i class="fa fa-file fa-fw"></i>  Users' Pendency</strong></a></li>
                                                        <?php
                                                    }
                                                }
                                                ?></ul></div>

                                        <div class="side-menu_new show_sm_div visible-xs visible-sm center nav-sm" style="font-size:13px; font-weight: bold;">
                                            <ul  class="work_done"> 
                                                <a href="<?= base_url('admin/work_done'); ?>"><li style=""><div>Work Done </div>
                                                        <div class="hover_text_work_done hover_text_css">Work Done</div>
                                                        <span><i class="fa fa-check icon_font_css"></i></span></li></a>
                                            </ul> 
                                            <ul  class="work_done_filter"> 
                                                <a href="<?= base_url('admin/work_done_filter'); ?>"><li style=""><div>efiling Done </div>
                                                        <div class="hover_text_work_done_filter hover_text_css">efiling Done</div>
                                                        <span><i class="fa fa-check-circle-o icon_font_css"></i></span></li></a>
                                            </ul>

                                            <?php if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_SUPER_ADMIN) { ?>
                                                <ul  class="login_logs"> 
                                                    <a href="<?= base_url('admin/login_logs'); ?>"><li style=""><div>View LoginLog Details </div>
                                                            <div class="hover_text_login_logs hover_text_css">View LoginLog Details</div>
                                                            <span><i class="fa fa-bars icon_font_css"></i></span></li></a>
                                                </ul>
                                            <?php } ?>
                                            <?php if ($this->session->userdata['login']['ref_m_usertype_id'] != USER_SUPER_ADMIN && $this->session->userdata['login']['ref_m_usertype_id'] != USER_DISTRICT_ADMIN && $this->session->userdata['login']['ref_m_usertype_id'] != USER_MASTER_ADMIN) { ?>
                                                <ul  class="court_fee_details"> 
                                                    <a href="<?= base_url('admin/court_fee_details'); ?>"><li style=""><div>Fees Paid </div>
                                                            <div class="hover_text_court_fee_details hover_text_css">Fees Paid</div>
                                                            <span><i class="fa fa-rupee icon_font_css"></i></span></li></a>
                                                </ul>
                                                <?php
                                            }
                                            if ($this->session->userdata['login']['ref_m_usertype_id'] != USER_SUPER_ADMIN &&
                                                    $this->session->userdata['login']['ref_m_usertype_id'] != USER_DISTRICT_ADMIN && $this->session->userdata['login']['ref_m_usertype_id'] != USER_MASTER_ADMIN && ENABLE_TRANSACTION_DETAIL) {
                                                ?>
                                                <ul  class="transaction_details"> 
                                                    <a href="<?= base_url('admin/transaction_details'); ?>"><li style="font-size:12px !important;"><div>Transaction Details </div>
                                                            <div class="hover_text_transaction_details hover_text_css" style=" line-height: 1em;margin-top: -5px !important;">Transaction <br>Details</div>
                                                            <span><i class="fa fa-list icon_font_css"></i></span></li></a>
                                                </ul>
                                                <?php if (ENABLE_SBI_PAYMENT_GATEWAY) { ?>  
                                                    <ul  class="sbi_payment_info"> 
                                                        <a href="<?= base_url('sbi_payment_info'); ?>"><li><div>SBI MIS </div>
                                                                <div class="hover_text_sbi_payment_info hover_text_css" >SBI MIS</div>
                                                                <span><i class="fa fa-list icon_font_css"></i></span></li></a>
                                                    </ul>
                                                    <ul  class="payout_info"> 
                                                        <a href="<?= base_url('sbi_payment_info/payout_info'); ?>"><li ><div>SBI Payout </div>
                                                                <div class="hover_text_payout_info hover_text_css" >SBI Payout</div>
                                                                <span><i class="fa fa-list icon_font_css"></i></span></li></a>
                                                    </ul>
                                                    <ul  class="sbi_report"> 
                                                        <a href="<?= base_url('sbi_payment_info/sbi_report'); ?>"><li ><div>Mismatch Report </div>
                                                                <div class="hover_text_sbi_report hover_text_css" >Mismatch Report</div>
                                                                <span><i class="fa fa-list icon_font_css" ></i></span></li></a>
                                                    </ul>
                                                    <?php
                                                }
                                            }
                                            ?>



                                        </div>

                                                                                                                                                                                                                                                    <!--                                        <div class="main-menu"> <ul> <li> <a href="<?= base_url('admin/work_done_filter'); ?>"><i class="fa fa-check text_color fa-5x" ></i><br><span class="Work_title">Work Done&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class="nav-text" style="display: table-cell !important; "> &nbsp;&nbsp;&nbsp;Work Doned</span> </a> </li> </ul></div>
                                                                                                                                                                                                                                                                                            <div class="main-menu"> <ul> <li> <a href="<?= base_url('admin/work_done'); ?>"><i class="fa fa-check-circle-o text_color fa-5x" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i><br><span class="efiling_title">efiling Done</span><span class="nav-text efile_text" style="display: table-cell !important; "> efiling Done</span> </a> </li> </ul></div>

                                        <?php if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_SUPER_ADMIN) { ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="main-menu"> <ul><li><a href="<?= base_url('admin/login_logs'); ?>"><i class="fa fa-bars  text_color fa-5x" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i><br><span class="View_title">View <br>LoginLog Details</span> <span class="nav-text" style="display: table-cell !important;"> View Login Log Details </span> </a> </li> </ul></div>
                                        <?php } ?>
                                        <?php if ($this->session->userdata['login']['ref_m_usertype_id'] != USER_SUPER_ADMIN && $this->session->userdata['login']['ref_m_usertype_id'] != USER_DISTRICT_ADMIN && $this->session->userdata['login']['ref_m_usertype_id'] != USER_MASTER_ADMIN) { ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="main-menu"> <ul><li><a href="<?= base_url('admin/court_fee_details'); ?>"><i class="fa fa-rupee  text_color fa-5x" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i><br><span class="Fees_title">Fees Paid</span>  <span class="nav-text" style="display: table-cell !important; ">Fees Paid</span> </a> </li> </ul></div>

                                            <?php
                                        }
                                        if ($this->session->userdata['login']['ref_m_usertype_id'] != USER_SUPER_ADMIN &&
                                                $this->session->userdata['login']['ref_m_usertype_id'] != USER_DISTRICT_ADMIN && $this->session->userdata['login']['ref_m_usertype_id'] != USER_MASTER_ADMIN && ENABLE_TRANSACTION_DETAIL) {
                                            ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="main-menu"> <ul><li><a href="<?= base_url('admin/transaction_details'); ?>"><i class="fa fa-list text_color fa-5x" ></i> <span class="Transaction_title">Transaction Details</span><span class="nav-text" style="display: table-cell !important;"> Transaction Details </span> </a> </li> </ul></div>

                                            <?php if (ENABLE_SBI_PAYMENT_GATEWAY) { ?>  
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="main-menu"> <ul><li><a href="<?= base_url('sbi_payment_info'); ?>"><i class="fa fa-outdent text_color fa-5x" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i><br><span class="SBI_title">SBI MIS </span> <span class="nav-text" style="display: table-cell !important; "> SBI MIS </span> </a> </li> </ul></div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="main-menu"> <ul><li><a href="<?= base_url('sbi_payment_info/payout_info'); ?>"><i class="fa fa-list text_color fa-5x" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i><br><span class="SBI-_title">SBI- Payout</span>  <span class="nav-text" style="display: table-cell !important; "> SBI Payout </span> </a> </li> </ul></div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="main-menu"> <ul><li><a href="<?= base_url('sbi_payment_info/sbi_report'); ?>"><i class="fa fa-chain-broken text_color fa-5x" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i><br><span class="Mismatch_title">Mismatch Report</span> <span class="nav-text" style="display: table-cell !important; ">Mismatch Report</span> </a> </li> </ul></div>
                                                <?php
                                            }
                                        }
                                        ?> 
                                                            ?> -->



                                    <?php } else if ($this->uri->segment(1) == 'digital_copy' || $this->uri->segment(1) == 'doclist') {
                                        ?>
                                        <li class="highlight_tab"><a class="text_cursor active_tab text_position" ><i class="fa fa-book fa-fw" style="color:#fff;"></i> <strong style="color:#fff;">ePaper Book</strong> </a> </li>
                                        <div class="show_md_div visible-lg visible-md" style="display:none !important;">
                                            <ul class="nav side-menu">
                                                <li class="highlight"><a href="<?= base_url('doclist'); ?>"><strong class="text_color "><i class="fa fa-files-o fa-fw"></i>ePaper Book Structure</strong></a></li>
                                                <li class="highlight"><a href="<?= base_url('digital_copy'); ?>"><strong class="text_color "><i class="fa fa-book fa-fw"></i>  Create ePaper Book </strong></a></li>
                                                <li class="highlight"><a href="<?= base_url('digital_copy/view'); ?>"><strong class="text_color "><i class="fa fa-list-ul fa-fw"></i> ePaper Book List </strong></a></li>
                                            </ul>
                                        </div>

                                        <div class="side-menu_new show_sm_div visible-xs visible-sm center nav-sm" style="font-size:13px; font-weight: bold;">
                                            <ul  class="doclist_1"> 
                                                <a href="<?= base_url('doclist'); ?>"><li style=""><div>ePaper BookStructure </div>
                                                        <div class="hover_text_doclist_1 hover_text_css">ePaper Book</div>
                                                        <span><i class="fa fa-files-o icon_font_css"></i></span></li></a>
                                            </ul>
                                            <ul  class="doclist_2"> 
                                                <a href="<?= base_url('digital_copy'); ?>"><li style=""><div>Create ePaperBook </div>
                                                        <div class="hover_text_doclist_2 hover_text_css">Add ePaper</div>
                                                        <span><i class="fa fa-book icon_font_css"></i></span></li></a>
                                            </ul>
                                            <ul  class="doclist_3"> 
                                                <a href="<?= base_url('digital_copy/view'); ?>"><li style=""><div>ePaper BookList </div>
                                                        <div class="hover_text_doclist_3 hover_text_css">ePaper List</div>
                                                        <span><i class="fa fa-list-ul icon_font_css"></i></span></li></a>
                                            </ul>
                                        </div>

                                    <?php } else if ($this->uri->segment(2) == 'history') { ?>
                                        <li class="highlight_tab"><a class="text_cursor active_tab text_position" ><i class="fa fa-history fa-fw" style="color:#fff;"></i> <strong style="color:#fff;">History</strong></a></li>
                                    <?php } else if (($this->uri->segment(2) == 'view' && $this->uri->segment(1) != 'news_event' && $this->uri->segment(1) != 'notice' && $this->uri->segment(3) == '') || ($this->uri->segment(2) == 'view_data_cino' && $this->uri->segment(3) != '' )) { ?>
                                        <li class="highlight_tab"><a class="text_cursor active_tab text_position" ><i class="fa fa-files-o fa-fw" style="color:#fff;"></i> <strong style="color:#fff;">Preview</strong></a></li>
                                        <?php
                                    }
                                    if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_MASTER_ADMIN) {
                                        $CI = &get_instance();
                                        $CI->load->model('adminDashboard/AdminDashboard_model');
                                        //$total_reg = $CI->AdminDashboard_model->count_new_registered_user();
                                        //$total_adv = $CI->AdminDashboard_model->count_pending_advocate_list($_SESSION['login']['admin_for_type_id']);
                                        if ($this->uri->segment(2) == 'new_registration' || $this->uri->segment(2) == 'pending_advocate_list' || $this->uri->segment(2) == 'new_active_user' || $this->uri->segment(2) == 'rejected_list') {
                                            ?>
                                            <li class="highlight_tab"><a class="active_tab "><i class="fa fa-user-plus fa-fw" style="color:#fff;"></i><strong style="color:#fff;"> Registration </strong> </a></li>
                                            <div class="show_md_div visible-lg visible-md" style="display: none !important;">
                                                <ul class="nav side-menu">
                                                    <li class="highlight_tab"><a href="<?= base_url() . 'admin/new_registration/' . url_encryption('new_request') ?>"> <strong class="text_color"><i class="fa fa-user fa-fw"></i> New Request (<?php echo htmlentities($count_new_advocate[0]['count_new_request'], ENT_QUOTES); ?>)</strong></a></li>
                                                    <li class="highlight"><a href="<?= base_url() . 'admin/new_registration/' . url_encryption('new_updation') ?>"> <strong class="text_color"><i class="fa fa-user-secret fa-fw"></i> New Updation (<?php echo htmlentities($count_new_advocate[0]['count_new_updation'], ENT_QUOTES); ?>)</strong></a></li>
                                                    <li class="highlight"><a href="<?= base_url() . 'admin/new_registration/' . url_encryption('objection') ?>"> <strong class="text_color"><i class="fa fa-user-times fa-fw"></i> Objections (<?php echo htmlentities($count_new_advocate[0]['count_objection'], ENT_QUOTES); ?>)</strong></a></li>
                                                    <li class="highlight"><a href="<?= base_url() . 'admin/new_registration/' . url_encryption('activated') ?>"> <strong class="text_color"><i class="fa fa-users fa-fw"></i> Activated (<?php echo htmlentities($count_new_advocate[0]['count_activated'], ENT_QUOTES); ?>)</strong></a></li>
                                                    <li class="highlight"><a href="<?= base_url() . 'admin/new_registration/' . url_encryption('updated') ?>"> <strong class="text_color"><i class="fa fa-user fa-fw"></i> Updated (<?php echo htmlentities($count_new_advocate[0]['count_updated'], ENT_QUOTES); ?>)</strong></a></li>
                                                    <li class="highlight"><a href="<?= base_url() . 'admin/new_registration/' . url_encryption('rejected') ?>"> <strong class="text_color"><i class="fa fa-user-times fa-fw"></i> Rejected (<?php echo htmlentities($count_new_advocate[0]['count_reject'], ENT_QUOTES); ?>)</strong></a></li>
                                                </ul></div>
                                            <?php
                                        }
                                    }


                                    if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_BAR_COUNCIL) {
                                        if ($this->uri->segment(2) == 'new_register' || $this->uri->segment(2) == 'view_details') {
                                            ?>
                                            <li class="highlight_tab"><a class="active_tab "><i class="fa fa-user-plus fa-fw" style="color:#fff;"></i><strong style="color:#fff;"> Registration </strong> </a></li>
                                            <div class="side-menu_new show_sm_div visible-xs visible-sm center nav-sm" style="font-size:13px; font-weight: bold;">
                                                <ul  class="bar_new_request"> 
                                                    <a href="<?= base_url() . 'bar_council/new_register/' . url_encryption('new_request') ?>"><li style=""><div>New Request (<?php echo htmlentities($user_count[0]['pending'], ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_bar_new_request hover_text_css">New Request </div>
                                                            <span><i class="fa fa-user fa-fw icon_font_css"></i></span></li></a>
                                                </ul>
                                                <ul  class="bar_approved"> 
                                                    <a href="<?= base_url() . 'bar_council/new_register/' . url_encryption('approved') ?>"><li style=""><div>Approved (<?php echo htmlentities($user_count[0]['active'], ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_bar_approved hover_text_css small_text_css">Approved </div>
                                                            <span><i class="fa fa-user-secret fa-fw icon_font_css"></i></span></li></a>
                                                </ul>
                                                <ul  class="bar_rejected"> 
                                                    <a href="<?= base_url() . 'bar_council/new_register/' . url_encryption('rejected') ?>"><li style=""><div>Rejected (<?php echo htmlentities($user_count[0]['deactive'], ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_bar_rejected hover_text_css small_text_css">Rejected </div>
                                                            <span><i class="fa fa-user-times fa-fw icon_font_css"></i></span></li></a>
                                                </ul>
                                                <ul  class="bar_onhold"> 
                                                    <a href="<?= base_url() . 'bar_council/new_register/' . url_encryption('onhold') ?>"><li style=""><div>On Hold (<?php echo htmlentities($user_count[0]['onhold'], ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_bar_onhold hover_text_css small_text_css">On Hold </div>
                                                            <span><i class="fa fa-user-times fa-fw icon_font_css"></i></span></li></a>
                                                </ul>
                                                <ul  class="bar_objection"> 
                                                    <a href="<?= base_url() . 'bar_council/new_register/' . url_encryption('objection') ?>"><li style=""><div>Objection (<?php echo htmlentities($user_count[0]['objection'], ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_bar_objection hover_text_css small_text_css">Objection </div>
                                                            <span><i class="fa fa-user-times fa-fw icon_font_css"></i></span></li></a>
                                                </ul>
                                            </div> 
                                            <?php
                                        }
                                    }

                                    if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_MASTER_ADMIN) {
                                        $CI = &get_instance();
                                        $CI->load->model('adminDashboard/AdminDashboard_model');
                                        //$total_reg = $CI->AdminDashboard_model->count_new_registered_user();
                                        //$total_adv = $CI->AdminDashboard_model->count_pending_advocate_list($_SESSION['login']['admin_for_type_id']);
                                        if ($this->uri->segment(2) == 'new_registration' || $this->uri->segment(2) == 'pending_advocate_list' || $this->uri->segment(2) == 'new_active_user' || $this->uri->segment(2) == 'rejected_list') {
                                            ?>

                                            <div class="show_sm_div visible-xs visible-sm center nav-sm" style="font-size:13px; font-weight: bold;">
                                                <div class="side-menu_new">
                                                    <ul  class="new_request"> 
                                                        <a href="<?= base_url() . 'admin/new_registration/' . url_encryption('new_request'); ?>"><li style=""><div>New Request (<?php echo htmlentities($count_new_advocate[0]['count_new_request'], ENT_QUOTES); ?>)</div>
                                                                <div class="hover_text_new_request hover_text_css">New Request</div>
                                                                <span><i class="fa fa-home icon_font_css"></i></span></li></a>
                                                    </ul> 
                                                    <ul class="new_updation"> 
                                                        <a href="<?= base_url() . 'admin/new_registration/' . url_encryption('new_updation'); ?>" ><li style=""><div>New Updation (<?php echo htmlentities($count_new_advocate[0]['count_new_updation'], ENT_QUOTES); ?>)</div>
                                                                <div class="hover_text_new_updation hover_text_css small_text_css"> Updation</div>
                                                                <span><i class="fa fa-user-secret icon_font_css"></i></span></li></a>
                                                    </ul>
                                                    <ul class="objection"> 
                                                        <a href="<?= base_url() . 'admin/new_registration/' . url_encryption('objection'); ?>" ><li style=""><div>Objection (<?php echo htmlentities($count_new_advocate[0]['count_objection'], ENT_QUOTES); ?>)</div>
                                                                <div class="hover_text_objection hover_text_css small_text_css">Objection</div>
                                                                <span><i class="fa fa-user-times icon_font_css"></i></span></li></a>
                                                    </ul>
                                                    <ul class="activated"> 
                                                        <a href="<?= base_url() . 'admin/new_registration/' . url_encryption('activated'); ?>" ><li style=""><div>Activated (<?php echo htmlentities($count_new_advocate[0]['count_activated'], ENT_QUOTES); ?>) </div>
                                                            <center><div class="hover_text_activated hover_text_css small_text_css">Activated</div></center>
                                                            <span><i class="fa fa-users icon_font_css"></i></span></li></a>
                                                    </ul>
                                                    <ul class="updated"> 
                                                        <a href="<?= base_url() . 'admin/new_registration/' . url_encryption('updated'); ?>" ><li style=""><div>Updated (<?php echo htmlentities($count_new_advocate[0]['count_updated'], ENT_QUOTES); ?>) </div>
                                                                <div class="hover_text_updated hover_text_css small_text_css">Updated</div>
                                                                <span><i class="fa fa-user icon_font_css"></i></span></li></a>
                                                    </ul>
                                                    <ul class="rejected"> 
                                                        <a href="<?= base_url() . 'admin/new_registration/' . url_encryption('rejected'); ?>" ><li style=""><div>Rejected (<?php echo htmlentities($count_new_advocate[0]['count_reject'], ENT_QUOTES); ?>) </div>
                                                                <div class="hover_text_rejected hover_text_css small_text_css">Rejected</div>
                                                                <span><i class="fa fa-user-times icon_font_css"></i></span></li></a>
                                                    </ul>
                                                </div>  

                                            </div>

                                            <?php
                                        }
                                    }

                                    if ($this->session->userdata['login']['ref_m_usertype_id'] != USER_SUPER_ADMIN) {
                                        if ($this->uri->segment(1) == 'news_event' || $this->uri->segment(1) == 'notice' || $this->uri->segment(2) == 'master_admin_contact_details' || $this->uri->segment(2) == 'district_admin_contact_details' || $this->uri->segment(2) == 'super_admin_contact_details') {
                                            ?>

                                            <li class="highlight_tab"><a class="text_cursor active_tab"><i class="fa fa-user-plus fa-fw " style="color:#fff;"></i><strong style="color:#fff;"> Assistance</strong> </a></li>
                                            <div class="show_md_div visible-lg visible-md" style="display: none !important;">
                                                <ul class="nav side-menu">
                                                    <li class="highlight"><a href="<?= base_url('news_event/'); ?>"><i class="fa fa-newspaper-o text_color"></i> <strong class="text_color"> News And Events </strong> </a></li>
                                                    <li class="highlight"> <a href="https://efiling.ecourts.gov.in/adminHelp" target="_blank"><i class="fa fa-info-circle text_color"></i><strong class="text_color">  &nbsp;Admin Manual</strong> </a></li>
                                                    <?php if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN) { ?>  
                                                        <li class="highlight"><a href="<?= base_url('admin/master_admin_contact_details'); ?>"><i class="fa fa-user-secret text_color"></i>  <strong class="text_color"> Master Admin</strong></a></li>
                                                        <?php
                                                    } if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_MASTER_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_ADMIN) {
                                                        if ($this->session->userdata['login']['admin_for_type_id'] == ENTRY_TYPE_FOR_ESTABLISHMENT) {
                                                            ?> 
                                                            <li class="highlight"><a href="<?= base_url('admin/district_admin_contact_details'); ?>"><i class="fa fa-user-secret text_color"></i><strong class="text_color">  District Admin</strong></a></li>
                                                            <?php
                                                        }
                                                    }
                                                    if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_DISTRICT_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_MASTER_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_ADMIN) {
                                                        ?>  
                                                        <li class="highlight"><a href="<?= base_url('admin/super_admin_contact_details'); ?>"><i class="fa fa-user-secret text_color"></i> <strong class="text_color"> Super Admin</strong></a></li>
                                                    <?php }
                                                    ?></ul>
                                            </div>
                                            <?php
                                        }
                                    }


                                    if ($this->session->userdata['login']['ref_m_usertype_id'] != USER_SUPER_ADMIN) {
                                        if ($this->uri->segment(1) == 'news_event' || $this->uri->segment(1) == 'notice' || $this->uri->segment(2) == 'master_admin_contact_details' || $this->uri->segment(2) == 'district_admin_contact_details' || $this->uri->segment(2) == 'super_admin_contact_details') {
                                            ?> 
                                            <div class="side-menu_new">
                                                <ul  class="news_event"> 
                                                    <a href="<?= base_url('news_event/'); ?>"><li style=""><div>News & Events</div>
                                                            <div class="hover_text_news_event hover_text_css">News  Events</div>
                                                            <span><i class="fa fa-newspaper-o icon_font_css"></i></span></li></a>
                                                </ul> 
                                                <ul  class="new_request"> 
                                                    <a href="https://efiling.ecourts.gov.in/adminHelp"><li style=""><div>Admin Manual</div>
                                                            <div class="hover_text_new_request hover_text_css">AD. Manual</div>
                                                            <span><i class="fa fa-info-circle icon_font_css"></i></span></li></a>
                                                </ul>
                                                <?php if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN) { ?>  
                                                    <ul  class="master_admin_contact_details"> 
                                                        <a href="<?= base_url('admin/master_admin_contact_details'); ?>"><li style=""><div>Master Admin</div>
                                                                <div class="hover_text_master_admin_contact_details hover_text_css">Master Admin</div>
                                                                <span><i class="fa fa-info-circle icon_font_css"></i></span></li></a>
                                                    </ul>    
                                                    <?php
                                                }
                                                if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_MASTER_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_ADMIN) {
                                                    if ($this->session->userdata['login']['admin_for_type_id'] == ENTRY_TYPE_FOR_ESTABLISHMENT) {
                                                        ?> 
                                                        <ul  class="district_admin_contact_details"> 
                                                            <a href="<?= base_url('admin/district_admin_contact_details'); ?>"><li style=""><div>District Admin</div>
                                                                    <div class="hover_text_district_admin_contact_details hover_text_css">Distt Admin</div>
                                                                    <span><i class="fa fa-info-circle icon_font_css"></i></span></li></a>
                                                        </ul>
                                                        <?php
                                                    }
                                                }
                                                if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_DISTRICT_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_MASTER_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_ADMIN) {
                                                    ?>
                                                    <ul  class="super_admin_contact_details"> 
                                                        <a href="<?= base_url('admin/super_admin_contact_details'); ?>"><li style=""><div>Super Admin</div>
                                                                <div class="hover_text_super_admin_contact_details hover_text_css">Super Admin</div>
                                                                <span><i class="fa fa-info-circle icon_font_css"></i></span></li></a>
                                                    </ul>
                                                </div>


                                                <?php
                                            }
                                        }
                                    }

                                    if ($this->uri->segment(1) == 'admin_stages') {
                                        $CI = & get_instance();
                                        $CI->load->model('adminDashboard/AdminDashboard_model');
                                        //$count_efiling_data = $CI->AdminDashboard_model->get_efilied_nums_stage_wise_count();
                                        ?>


                                        <li><a style="background-color: #737373 !important;"><i class="fa fa-file-o "></i><strong style="color:#fff;">e-Filed Stages</strong></a></li>

                                        <div class="show_sm_div visible-xs visible-sm" style="margin-top: 6px;"> 
                                            <div class="side-menu_new">
                                                <ul  class="admin_stages1"> 
                                                    <a href="<?php echo ($count_efiling_data[0]->total_new_efiling == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(New_Filing_Stage, ENT_QUOTES))); ?>">
                                                        <li>
                                                            <div>New Filing (<?php echo htmlentities($count_efiling_data[0]->total_new_efiling, ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_admin_stages1 hover_text_css">New Filing</div>
                                                            <span><img class="img_css" src="<?php echo base_url('assets/images/mycases/draft.svg'); ?>"></span>
                                                        </li>
                                                    </a>
                                                </ul>
                                                <ul  class="admin_stages2"> 
                                                    <a href="<?php echo ($count_efiling_data[0]->total_not_accepted == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(Initial_Defected_Stage, ENT_QUOTES))); ?>">
                                                        <li>
                                                            <div>For Compliance (<?php echo htmlentities($count_efiling_data[0]->total_not_accepted, ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_admin_stages2 hover_text_css">Compliance</div>
                                                            <span><img class="img_css" src="<?php echo base_url('assets/images/mycases/pending_acceptance.svg'); ?>"></span>
                                                        </li>
                                                    </a>
                                                </ul>
                                                <ul  class="admin_stages3"> 
                                                    <a href="<?php echo ($count_efiling_data[0]->deficit_crt_fee == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(DEFICIT_COURT_FEE, ENT_QUOTES))); ?>">
                                                        <li>
                                                            <div>Pay Deficit Fee (<?php echo htmlentities($count_efiling_data[0]->deficit_crt_fee, ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_admin_stages3 hover_text_css">Deficit Fee</div>
                                                            <span><img class="img_css" src="<?php echo base_url('assets/images/mycases/not accepted.svg'); ?>"></span>
                                                        </li>
                                                    </a>
                                                </ul>
                                                <ul  class="admin_stages4"> 
                                                    <a href="<?php echo ($count_efiling_data[0]->total_refiled_cases == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(Initial_Defects_Cured_Stage, ENT_QUOTES))); ?>">
                                                        <li>
                                                            <div>Complied Objections (<?php echo htmlentities($count_efiling_data[0]->total_refiled_cases, ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_admin_stages4 hover_text_css">Complie Obj.</div>
                                                            <span><img class="img_css" src="<?php echo base_url('assets/images/mycases/deficit_court_fee.svg'); ?>"></span>
                                                        </li>
                                                    </a>
                                                </ul>
                                                <ul  class="admin_stages5"> 
                                                    <a href="<?php echo ($count_efiling_data[0]->total_transfer_to_efiling_sec == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(Transfer_to_IB_Stage, ENT_QUOTES))); ?>">
                                                        <li>
                                                            <div>Transfer to CIS (<?php echo htmlentities($count_efiling_data[0]->total_transfer_to_efiling_sec, ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_admin_stages5 hover_text_css">Tran. to CIS</div>
                                                            <span><img class="img_css" src="<?php echo base_url('assets/images/mycases/Pending scrutiny.svg'); ?>"></span>
                                                        </li>
                                                    </a>
                                                </ul>
                                                <ul  class="admin_stages6"> 
                                                    <a href="<?php echo ($count_efiling_data[0]->total_available_for_cis == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(Transfer_to_CIS_Stage, ENT_QUOTES))); ?>">
                                                        <li>
                                                            <div>Get CIS Status (<?php echo htmlentities($count_efiling_data[0]->total_available_for_cis, ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_admin_stages6 hover_text_css">CIS Status</div>
                                                            <span><img class="img_css" src="<?php echo base_url('assets/images/mycases/Defective.svg'); ?>"></span>
                                                        </li>
                                                    </a>
                                                </ul>
                                                <ul  class="admin_stages7"> 
                                                    <a href="<?php echo ($count_efiling_data[0]->total_pending_scrutiny == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(I_B_Approval_Pending_Admin_Stage, ENT_QUOTES))); ?>">
                                                        <li>
                                                            <div>Pending Scrutiny (<?php echo htmlentities($count_efiling_data[0]->total_pending_scrutiny, ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_admin_stages7 hover_text_css">Pending Scr..  </div>
                                                            <span><img class="img_css" src="<?php echo base_url('assets/images/mycases/documents.svg'); ?>"></span>
                                                        </li>
                                                    </a>
                                                </ul>
                                                <ul  class="admin_stages8"> 
                                                    <a href="<?php echo ($count_efiling_data[0]->total_waiting_defect_cured == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(I_B_Defected_Stage, ENT_QUOTES))); ?>">
                                                        <li>
                                                            <div>Defective (<?php echo htmlentities($count_efiling_data[0]->total_waiting_defect_cured, ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_admin_stages8 hover_text_css">Defective</div>
                                                            <span><img class="img_css" src="<?php echo base_url('assets/images/mycases/deficit_court_fee.svg'); ?>"></span>
                                                        </li>
                                                    </a>
                                                </ul>
                                                <ul  class="admin_stages9"> 
                                                    <a href="<?php echo ($count_efiling_data[0]->total_defect_cured == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(I_B_Defects_Cured_Stage, ENT_QUOTES))); ?>">
                                                        <li>
                                                            <div>Defects Cured (<?php echo htmlentities($count_efiling_data[0]->total_defect_cured, ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_admin_stages9 hover_text_css">Defects Cure</div>
                                                            <span><img class="img_css" src="<?php echo base_url('assets/images/mycases/book.svg'); ?>"></span>
                                                        </li>
                                                    </a>
                                                </ul>
                                                <ul  class="admin_stages10"> 
                                                    <a href="<?php echo ($count_efiling_data[0]->total_efiled_cases == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(E_Filed_Stage, ENT_QUOTES))); ?>">
                                                        <li>
                                                            <div>Cases (<?php echo htmlentities($count_efiling_data[0]->total_efiled_cases, ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_admin_stages10 hover_text_css">Cases</div>
                                                            <span><img class="img_css" src="<?php echo base_url('assets/images/mycases/maintenance.svg'); ?>"></span>
                                                        </li>
                                                    </a>
                                                </ul>
                                                <ul  class="admin_stages11"> 
                                                    <a href="<?php echo ($count_efiling_data[0]->total_efiled_docs == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(Document_E_Filed, ENT_QUOTES))); ?>">
                                                        <li>
                                                            <div>Documents (<?php echo htmlentities($count_efiling_data[0]->total_efiled_docs, ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_admin_stages11 hover_text_css">Documents</div>
                                                            <span><img class="img_css" src="<?php echo base_url('assets/images/mycases/rejected.svg'); ?>"></span>
                                                        </li>
                                                    </a>
                                                </ul>
                                                <ul  class="admin_stages12"> 
                                                    <a href="<?php echo ($count_efiling_data[0]->total_efiled_deficit == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(DEFICIT_COURT_FEE_E_FILED, ENT_QUOTES))); ?>">
                                                        <li>
                                                            <div>Paid Deficit Fee (<?php echo htmlentities($count_efiling_data[0]->total_efiled_deficit, ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_admin_stages12 hover_text_css">Deficit Fee</div>
                                                            <span><img class="img_css" src="<?php echo base_url('assets/images/mycases/trashed.svg'); ?>"></span>
                                                        </li>
                                                    </a>
                                                </ul>
                                                <?php if ( ENABLE_E_FILE_IA_FOR_HC ||  ENABLE_E_FILE_IA_FOR_ESTAB) { ?>
                                                    <ul  class="admin_stages13"> 
                                                        <a href="<?php echo ($count_efiling_data[0]->total_efiled_ia == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(IA_E_Filed, ENT_QUOTES))); ?>">
                                                            <li>
                                                                <div>IA (<?php echo htmlentities($count_efiling_data[0]->total_efiled_ia, ENT_QUOTES); ?>)</div>
                                                                <div class="hover_text_admin_stages13 hover_text_css">Deficit Fee</div>
                                                                <span><img class="img_css" src="<?php echo base_url('assets/images/mycases/maintenance.svg'); ?>"></span>
                                                            </li>
                                                        </a>
                                                    </ul>
                                                <?php } ?>
                                                <ul  class="admin_stages14"> 
                                                    <a href="<?php echo ($count_efiling_data[0]->total_rejected == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(I_B_Rejected_Stage, ENT_QUOTES))); ?>">
                                                        <li>
                                                            <div>Rejected (<?php echo htmlentities($count_efiling_data[0]->total_rejected, ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_admin_stages14 hover_text_css">Deficit Fee</div>
                                                            <span><img class="img_css" src="<?php echo base_url('assets/images/mycases/rejected.svg'); ?>"></span>
                                                        </li>
                                                    </a>
                                                </ul>
                                                <ul  class="admin_stages15"> 
                                                    <a href="<?php echo ($count_efiling_data[0]->total_lodged_cases == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(LODGING_STAGE, ENT_QUOTES))); ?>">
                                                        <li>
                                                            <div>Idle/Unprocess e-Filed No. (<?php echo htmlentities($count_efiling_data[0]->total_lodged_cases, ENT_QUOTES); ?>)</div>
                                                            <div class="hover_text_admin_stages15 hover_text_css">Unprocessed</div>
                                                            <span><img class="img_css" src="<?php echo base_url('assets/images/mycases/trashed.svg'); ?>"></span>
                                                        </li>
                                                    </a>
                                                </ul> 
                                            </div> 
                                        </div>
                                        <div class="show_md_div visible-lg visible-md" style="display: none !important;">
                                            <ul class="nav side-menu">        
                                                <li class="highlight"><a href="<?php echo ($count_efiling_data[0]->total_new_efiling == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(New_Filing_Stage, ENT_QUOTES))); ?>"><span class="text_color">New Filing <i class="number_css badge"> <?php echo htmlentities($count_efiling_data[0]->total_new_efiling, ENT_QUOTES); ?></i></span></a></li><div class="clearfix"></div>
                                                <li class="highlight"><a href="<?php echo ($count_efiling_data[0]->total_not_accepted == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(Initial_Defected_Stage, ENT_QUOTES))); ?>"><span class="text_color">For Compliance<i class="number_css badge"><?php echo htmlentities($count_efiling_data[0]->total_not_accepted, ENT_QUOTES); ?></i></span></a>  </li><div class="clearfix"></div>
                                                <li class="highlight"><a href="<?php echo ($count_efiling_data[0]->deficit_crt_fee == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(DEFICIT_COURT_FEE, ENT_QUOTES))); ?>"><span class="text_color">Pay Deficit Fee<i class="number_css badge"><?php echo htmlentities($count_efiling_data[0]->deficit_crt_fee, ENT_QUOTES); ?></i></span></a></li><div class="clearfix"></div>
                                                <li class="highlight"><a href="<?php echo ($count_efiling_data[0]->total_refiled_cases == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(Initial_Defects_Cured_Stage, ENT_QUOTES))); ?>"><span class="text_color">Complied Objections <i class="number_css badge"><?php echo htmlentities($count_efiling_data[0]->total_refiled_cases, ENT_QUOTES); ?></i></span></a></li><div class="clearfix"></div>
                                                <li class="highlight"><a href="<?php echo ($count_efiling_data[0]->total_transfer_to_efiling_sec == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(Transfer_to_IB_Stage, ENT_QUOTES))); ?>"><span class="text_color">Transfer to CIS<i class="number_css badge"><?php echo htmlentities($count_efiling_data[0]->total_transfer_to_efiling_sec, ENT_QUOTES); ?></i></span></a></li><div class="clearfix"></div>
                                                <li class="highlight"><a href="<?php echo ($count_efiling_data[0]->total_available_for_cis == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(Transfer_to_CIS_Stage, ENT_QUOTES))); ?>"><span class="text_color" >Get CIS Status<i class="number_css badge"><?php echo htmlentities($count_efiling_data[0]->total_available_for_cis, ENT_QUOTES); ?></i></span></a></li><div class="clearfix"></div>
                                                <li class="highlight"><a href="<?php echo ($count_efiling_data[0]->total_pending_scrutiny == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(I_B_Approval_Pending_Admin_Stage, ENT_QUOTES))); ?>"><span class="text_color">Pending Scrutiny<i class="number_css badge"><?php echo htmlentities($count_efiling_data[0]->total_pending_scrutiny, ENT_QUOTES); ?></i></span></a></li><div class="clearfix"></div>
                                                <li class="highlight"><a href="<?php echo ($count_efiling_data[0]->total_waiting_defect_cured == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(I_B_Defected_Stage, ENT_QUOTES))); ?>"><span class="text_color" >Defective<i class="number_css badge"><?php echo htmlentities($count_efiling_data[0]->total_waiting_defect_cured, ENT_QUOTES); ?></i></span></a></li><div class="clearfix"></div>
                                                <li class="highlight"><a href="<?php echo ($count_efiling_data[0]->total_defect_cured == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(I_B_Defects_Cured_Stage, ENT_QUOTES))); ?>"><span class="text_color" >Defects Cured<i class="number_css badge"><?php echo htmlentities($count_efiling_data[0]->total_defect_cured, ENT_QUOTES); ?></i></span></a></li><div class="clearfix"></div>
                                                <li class="highlight"><a href="<?php echo ($count_efiling_data[0]->total_efiled_cases == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(E_Filed_Stage, ENT_QUOTES))); ?>" ><span class="text_color" >Cases<i class="number_css badge"><?php echo htmlentities($count_efiling_data[0]->total_efiled_cases, ENT_QUOTES); ?></i></span></a></li><div class="clearfix"></div>
                                                <li class="highlight"><a href="<?php echo ($count_efiling_data[0]->total_efiled_docs == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(Document_E_Filed, ENT_QUOTES))) ?>"><span class="text_color" >Documents<i class="number_css badge"><?php echo htmlentities($count_efiling_data[0]->total_efiled_docs, ENT_QUOTES); ?></i></span></a></li><div class="clearfix"></div>
                                                <li class="highlight"><a href="<?php echo ($count_efiling_data[0]->total_efiled_deficit == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(DEFICIT_COURT_FEE_E_FILED, ENT_QUOTES))); ?>"><span class="text_color" >Paid Deficit Fee<i class="number_css badge"><?php echo htmlentities($count_efiling_data[0]->total_efiled_deficit, ENT_QUOTES); ?></i></span></a></li><div class="clearfix"></div>
                                                <li class="highlight"><a href="<?php echo ($count_efiling_data[0]->total_efiled_ia == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(IA_E_Filed, ENT_QUOTES))); ?>"><span class="text_color" >IA<i class="number_css badge"><?php echo htmlentities($count_efiling_data[0]->total_efiled_ia, ENT_QUOTES); ?></i></span></a></li>  <div class="clearfix"></div>
                                                <li class="highlight"><a href="<?php echo ($count_efiling_data[0]->total_rejected == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(I_B_Rejected_Stage, ENT_QUOTES))) ?>"><span class="text_color" >Rejected<i class="number_css badge"><?php echo htmlentities($count_efiling_data[0]->total_rejected, ENT_QUOTES); ?></i></span></a></li>  <div class="clearfix"></div>
                                                <li class="highlight"><a href="<?php echo ($count_efiling_data[0]->total_lodged_cases == '0' ) ? 'javascript:void(0)' : base_url("admin_stages/view/" . htmlentities(url_encryption(I_B_Defected_Stage, ENT_QUOTES))) ?>"><span class="text_color" >Idle/Unprocessed e-Filed No.'s<i class="number_css badge"><?php echo htmlentities($count_efiling_data[0]->total_lodged_cases, ENT_QUOTES); ?></i></span></a></li><div class="clearfix"></div>
                                            </ul>
                                        </div>
                                        <?php
                                        // Ends User Dashboard Stages list
                                    }

                                    if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_DISTRICT_ADMIN || $this->uri->segment(1) == 'district_admin') {
                                        if ($this->uri->segment(2) == 'user' || $this->uri->segment(2) == 'contact' || $this->uri->segment(2) == 'change_case_status' || $this->uri->segment(2) == 'case_type' || $this->uri->segment(2) == 'case_allocation') {
                                            ?>
                                            <li class="highlight_tab"><a class="text_cursor active_tab text_position" ><i class="fa fa-user fa-fw" style="color:#fff;"></i><strong style="color:#fff;">Administration</strong></a></li>
                                            <div class="show_md_div visible-lg visible-md" style="display:none !important;">
                                                <ul class="nav side-menu">
                                                    <li class="highlight"><a href="<?= base_url('district_admin/change_case_status/') ?>"><span class="text_color" > Change Case Status</span></a></li>
                                                    <li class="highlight"><a href="<?= base_url("district_admin/user") ?>"><span class="text_color" >Create New Admin</span></a></li>
                                                    <li class="highlight"><a href="<?= base_url("district_admin/contact") ?>"><span class="text_color" >Create Contact</span></a></li>
                                                    <li class="highlight"><a href="<?= base_url("admin/case_type") ?>"><span class="text_color">CIS Case Type for eFiling </span></a></li>
                                                    <li class="highlight"><a href="<?= base_url("district_admin/case_allocation") ?>"><span class="text_color">Efiling no.  Re-allocation </span></a></li>
                                                </ul>
                                            </div>
                                            <div class="show_sm_div visible-xs visible-sm center nav-sm" style="font-size:13px; font-weight: bold;">
                                                <div class="side-menu_new">
                                                    <ul  class="change_case_status"> 
                                                        <a href="<?= base_url('district_admin/change_case_status/') ?>">
                                                            <li>
                                                                <div>Change Case Status</div>
                                                                <div class="hover_text_change_case_status hover_text_css">Case Status</div>
                                                                <span><i class="fa fa-outdent icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                    <ul  class="dist_admin_user"> 
                                                        <a href="<?= base_url('district_admin/user') ?>">
                                                            <li>
                                                                <div>Create New Admin</div>
                                                                <div class="hover_text_dist_admin_user hover_text_css">Add Admin</div>
                                                                <span><i class="fa fa-user icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                    <ul  class="dist_admin_contact"> 
                                                        <a href="<?= base_url('district_admin/contact') ?>">
                                                            <li>
                                                                <div>Create Contact</div>
                                                                <div class="hover_text_dist_admin_contact hover_text_css">Add Contact</div>
                                                                <span><i class="fa fa-users icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                    <ul  class="dist_case_type"> 
                                                        <a href="<?= base_url('admin/case_type') ?>">
                                                            <li>
                                                                <div>CIS Case Type for eFiling</div>
                                                                <div class="hover_text_dist_case_type hover_text_css">CIS eFiling</div>
                                                                <span><i class="fa fa-users icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul> 
                                                    <ul  class="dist_case_allocation"> 
                                                        <a href="<?= base_url('district_admin/case_allocation') ?>">
                                                            <li>
                                                                <div>Efiling No.  Re-allocation</div>
                                                                <div class="hover_text_dist_case_allocation hover_text_css">Efiling no.  Re-allocation</div>
                                                                <span><i class="fa fa-exchange icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                </div> 
                                            </div>
                                            <?php
                                            // Ends User Dashboard Stages list
                                        }
                                    }
                                    if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_MASTER_ADMIN || $this->uri->segment(1) == 'master_admin') {
                                        if ($this->uri->segment(2) == 'user' || $this->uri->segment(2) == 'change_case_status' || $this->uri->segment(2) == 'reason' || $this->uri->segment(2) == 'case_allocation') {
                                            ?>
                                            <li class="highlight_tab"><a class="text_cursor active_tab text_position" ><i class="fa fa-user fa-fw" style="color:#fff;"></i><strong style="color:#fff;">Administration</strong></a></li>
                                            <div class="show_md_div visible-lg visible-md" style="display:none !important;">
                                                <ul class="nav side-menu">
                                                    <li class="highlight"><a href="<?= base_url('master_admin/change_case_status/') ?>"><span class="text_color"> Change Case Status</span></a></li>
                                                    <li class="highlight"><a href="<?= base_url("master_admin/user") ?>"><span class="text_color">Create New Admin</span></a></li>
                                                    <li class="highlight"><a href="<?= base_url("master_admin/reason") ?>"><span class="text_color">Efiling Number Allocation Reason</span></a></li>
                                                    <li class="highlight"><a href="<?= base_url("master_admin/case_allocation") ?>"><span class="text_color">Efiling no.  Re-allocation </span></a></li>
                                                </ul></div>
                                            <div class="show_sm_div visible-xs visible-sm center nav-sm" style="font-size:13px; font-weight: bold;">
                                                <div class="side-menu_new">
                                                    <ul  class="change_case_status1"> 
                                                        <a href="<?= base_url('master_admin/change_case_status/') ?>">
                                                            <li>
                                                                <div>Change Case Status</div>
                                                                <div class="hover_text_change_case_status1 hover_text_css">Case Status</div>
                                                                <span><i class="fa fa-outdent icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                    <ul  class="change_case_status2"> 
                                                        <a href="<?= base_url('master_admin/user/') ?>">
                                                            <li>
                                                                <div>Create New Admin</div>
                                                                <div class="hover_text_change_case_status2 hover_text_css">Add Admin</div>
                                                                <span><i class="fa fa-user icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                    <ul  class="change_case_status3"> 
                                                        <a href="<?= base_url('master_admin/reason/') ?>">
                                                            <li>
                                                                <div>Efiling No. Allocation Reason</div>
                                                                <div class="hover_text_change_case_status3 hover_text_css">Efile Reason</div>
                                                                <span><i class="fa fa-plus icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                    <ul  class="change_case_status4"> 
                                                        <a href="<?= base_url('master_admin/case_allocation') ?>">
                                                            <li>
                                                                <div>Efiling No.  Re-allocation</div>
                                                                <div class="hover_text_change_case_status4 hover_text_css">Efiling no.  Re-allocation</div>
                                                                <span><i class="fa fa-exchange icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                </div>
                                            </div> 
                                            <?php
                                            // Ends User Dashboard Stages list
                                        }
                                    }
                                    if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_SUPER_ADMIN || $this->uri->segment(1) == 'supadmin') {
                                        if ($this->uri->segment(2) == 'change_case_status' || $this->uri->segment(2) == 'user' || $this->uri->segment(2) == 'contact' || $this->uri->segment(2) == 'view' || $this->uri->segment(2) == 'case_type' || $this->uri->segment(2) == 'establishment' || $this->uri->segment(2) == 'check_payment' || $this->uri->segment(2) == 'check_master' || $this->uri->segment(2) == 'go_live' || $this->uri->segment(2) == 'department' || $this->uri->segment(2) == 'case_allocation') {
                                            ?>

                                            <li class="highlight_tab"><a class="text_cursor active_tab text_position" ><i class="fa fa-user fa-fw" style="color:#fff;"></i><strong style="color:#fff;">Administration</strong></a></li>
                                            <div class="show_md_div visible-lg visible-md" style="display:none !important;">
                                                <ul class="nav side-menu">
                                                    <li class="highlight"><a href="<?= base_url('supadmin/change_case_status/') ?>"><span class="text_color"> Change Case Status</span></a></li>
                                                    <li class="highlight"><a href="<?= base_url("admin/user") ?>"><span class="text_color">Create New Admin</span></a></li>
                                                    <li class="highlight"><a href="<?= base_url('supadmin/department') ?>"><span class="text_color">Create Department </span></a></li>
                                                    <li class="highlight"><a href="<?= base_url("admin/contact") ?>"><span class="text_color">Create Contact</span></a></li>
                                                    <li class="highlight"><a href="<?= base_url('news_event/view') ?>"><span class="text_color">Create News And Events</span></a></li>
                                                    <li class="highlight"><a href="<?= base_url('notice/view') ?>"><span class="text_color">Upload Notice & Forms</span></a></li>
                                                    <li class="highlight"><a href="<?= base_url('admin/case_type') ?>"><span class="text_color">CIS Case Type for eFiling </span></a></li>
                                                    <li class="highlight"><a href="<?= base_url('supadmin/establishment') ?>"><span class="text_color">Add Establishment </span></a></li>
                                                    <li class="highlight"><a href="<?= base_url('supadmin/check_payment') ?>"><span class="text_color">Test Payment Getway </span></a></li>   
                                                    <li class="highlight"><a href="<?= base_url('supadmin/check_master') ?>"><span class="text_color">Check CIS Master </span></a></li>
                                                    <li class="highlight"><a href="<?= base_url('supadmin/go_live') ?>"><span class="text_color">Go Live </span></a></li>
                                                    <li class="highlight"><a href="<?= base_url("admin/case_allocation") ?>"><span class="text_color">Efiling no.  Re-allocation </span></a></li>

                                                </ul>
                                            </div>

                                            <div class="show_sm_div visible-xs visible-sm center nav-sm" style="font-size:13px; font-weight: bold;">
                                                <div class="side-menu_new">
                                                    <ul  class="administration_status1"> 
                                                        <a href="<?= base_url('supadmin/change_case_status/') ?>">
                                                            <li>
                                                                <div>Change Case Status</div>
                                                                <div class="hover_text_administration_status1 hover_text_css">Case Status</div>
                                                                <span><i class="fa fa-outdent icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                    <ul  class="administration_status2"> 
                                                        <a href="<?= base_url('admin/user') ?>">
                                                            <li>
                                                                <div>Create New Admin</div>
                                                                <div class="hover_text_administration_status2 hover_text_css">Add Admin</div>
                                                                <span><i class="fa fa-user-secret icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                    <ul  class="administration_status3"> 
                                                        <a href="<?= base_url('supadmin/department') ?>">
                                                            <li>
                                                                <div>Create Department</div>
                                                                <div class="hover_text_administration_status3 hover_text_css">Add Depart.</div>
                                                                <span><i class="fa fa-home icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                    <ul  class="administration_status4"> 
                                                        <a href="<?= base_url('admin/contact') ?>">
                                                            <li>
                                                                <div>Create Contact</div>
                                                                <div class="hover_text_administration_status4 hover_text_css">Add Contact</div>
                                                                <span><i class="fa fa-users icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                    <ul  class="administration_status5"> 
                                                        <a href="<?= base_url('news_event/view') ?>">
                                                            <li>
                                                                <div>Create News & Events</div>
                                                                <div class="hover_text_administration_status5 hover_text_css">News-Events</div>
                                                                <span><i class="fa fa-newspaper-o icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                    <ul  class="administration_status6"> 
                                                        <a href="<?= base_url('notice/view') ?>">
                                                            <li>
                                                                <div>Upload Notice & Forms</div>
                                                                <div class="hover_text_administration_status6 hover_text_css">Notice-Form</div>
                                                                <span><i class="fa fa-files-o icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                    <ul  class="administration_status7"> 
                                                        <a href="<?= base_url('admin/case_type') ?>">
                                                            <li>
                                                                <div>CIS Case Type for eFiling</div>
                                                                <div class="hover_text_administration_status7 hover_text_css">CIS eFiling</div>
                                                                <span><i class="fa fa-files-o icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                    <ul  class="administration_status8"> 
                                                        <a href="<?= base_url('supadmin/establishment') ?>">
                                                            <li>
                                                                <div>Add Establishment</div>
                                                                <div class="hover_text_administration_status8 hover_text_css">Add Estab.</div>
                                                                <span><i class="fa fa-th icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                    <ul  class="administration_status9"> 
                                                        <a href="<?= base_url('supadmin/check_payment') ?>">
                                                            <li>
                                                                <div>Test Payment Getway</div>
                                                                <div class="hover_text_administration_status9 hover_text_css">Pay-Getway</div>
                                                                <span><i class="fa fa-credit-card icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                    <ul  class="administration_status10"> 
                                                        <a href="<?= base_url('supadmin/check_master') ?>">
                                                            <li>
                                                                <div>Check CIS Master</div>
                                                                <div class="hover_text_administration_status10 hover_text_css">CIS Master</div>
                                                                <span><i class="fa fa-check-circle-o icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                    <ul  class="administration_status11"> 
                                                        <a href="<?= base_url('supadmin/go_live') ?>">
                                                            <li>
                                                                <div>Go Live</div>
                                                                <div class="hover_text_administration_status11 hover_text_css">Go Live</div>
                                                                <span><i class="fa fa-thumbs-o-up icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                    <ul  class="administration_status12"> 
                                                        <a href="<?= base_url('admin/case_allocation') ?>">
                                                            <li>
                                                                <div>Case Allocation</div>
                                                                <div class="hover_text_administration_status12 hover_text_css">Efiling no.  Re-allocation</div>
                                                                <span><i class="fa fa-exchange icon_font_css"></i></span>
                                                            </li></a>
                                                    </ul>
                                                </div>
                                            </div> 

                                            <?php
                                            // Ends User Dashboard Stages list
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <!-- sidebar menu -->
                    </div>
                </div>
                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>
                            <ul class="nav navbar-nav navbar-right " style="margin-top: 5px">
                                <div class="col-md-4 col-sm-12 col-xs-12 top_search visible-lg visible-md visible-sm" >

                                    <?php
                                    $attribute = array('name' => 'search', 'id' => 'search', 'autocomplete' => 'off');
                                    echo form_open('admin/search', $attribute);
                                    ?>
                                    <div class="input-group" style="margin-bottom: 2px;">
                                        <input class="form-control" name="search" id="search" maxlength="30" required placeholder="Search for..." type="text">
                                        <span class="input-group-btn"><button class="btn btn-default" type="submit" value="1" name="submit"> Go!</button></span>
                                    </div>
                                    <?php echo form_close(); ?>  
                                </div>
                                <div class="col-md-5 col-md-5 col-sm-12 col-xs-12 top_search" >
                                    <!--                                    <div class="col-md-5 col-md-5 col-sm-12 col-xs-12 top_search show_sm_div visible-sm visible-xs" >-->
                                    <ul class="legend list-unstyled">
                                        <li>
                                            <a href="<?= $href; ?>" class="btn btn-info btn-xs"><i class="fa fa-home"></i> Home</a>
                                            <?php if ($this->session->userdata['login']['ref_m_usertype_id'] != USER_BAR_COUNCIL) { ?>
                                                <a href="<?= base_url('admin/work_done'); ?>" class="btn btn-dark btn-xs"><i class="fa fa-database"></i> Reports</a>
                                                <a href="<?= base_url('digital_copy'); ?>" class="btn btn-default btn-xs"><i class="fa fa-file"></i>  ePaper Book</a>

                                            <?php } if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_DISTRICT_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_MASTER_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_SUPER_ADMIN) { ?>
                                                <a href="<?php echo $url; ?>" class="btn btn-primary btn-xs"><i class="fa fa-database"></i> <?php echo $title; ?></a>                                                
                                            <?php } if ($_SESSION['login']['ref_m_usertype_id'] == USER_ADMIN || $_SESSION['login']['ref_m_usertype_id'] == USER_MASTER_ADMIN || $_SESSION['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN && $this->session->userdata['login']['ref_m_usertype_id'] != USER_BAR_COUNCIL) { ?>
                                                <a href="<?= base_url() . 'admin/new_registration/' . url_encryption('new_request') ?>" class="btn btn-success btn-xs"><i class="fa fa-user-plus"></i> Registration</a>                                        
                                            <?php } ?><?php if ($this->session->userdata['login']['ref_m_usertype_id'] != USER_SUPER_ADMIN && $this->session->userdata['login']['ref_m_usertype_id'] != USER_BAR_COUNCIL) { ?>
                                                <a href="<?= base_url('news_event/'); ?>" class="btn btn-warning btn-xs"><i class="fa fa-question-circle"></i> Assistance</a>                                               
                                            <?php } ?>
                                            <?php if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_BAR_COUNCIL) { ?>
                                                <a href="<?= base_url() . 'Bar_council/new_register/' . url_encryption('new_request') ?>" class="btn btn-success btn-xs"><i class="fa fa-user-plus"></i> Registration</a>    
                                            <?php } ?>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 top_search visible-lg visible-md visible-sm visible-xs" > 
                                    <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1" style="float: left;">
                                        <?php
                                        $get_valu = help_id_url(uri_string());
                                        $help_page = explode('.', $get_valu);
                                        ?>
                                        <a href="<?php echo site_url() . $help_page[0]; ?>" onclick="linkopen(event)"> <i class="fa fa-question-circle-o" style="font-size: 20px;"></i></a>
                                        <script>
                                            function linkopen(event) {
                                                event.preventDefault();
                                                window.open("<?php echo site_url('help/View/info/') . $get_valu; ?>", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=500,width=700,height=700");
                                            }
                                        </script>
                                    </div>

                                    <div class="col-md-11 col-lg-11 col-sm-12 col-xs-12" >
                                        <li class="">
                                            <?php
                                            $CI = & get_instance();
                                            $CI->load->model('profile/Profile_model');

                                            if ($this->session->userdata['login']['last_name'] != 'NA' && $this->session->userdata['login']['last_name'] != 'NULL') {
                                                $l_name = $this->session->userdata['login']['last_name'];
                                            } else {
                                                $l_name = '';
                                            }
                                            $last_name = strip_tags($l_name);
                                            if (strlen($last_name) > 2) {
                                                // truncate string
                                                $stringCut = substr($last_name, 0, 4);
                                                $endPoint = strrpos($stringCut, ' ');
                                                //if the string doesn't contain any space then it will cut without word basis.
                                                $last_name = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                $last_name .= '... ';
                                            }

                                            //$login_time = $CI->Profile_model->userLastLogin($this->session->userdata['login']['id']);
                                            $last_login = ($login_time[0]->login_time != '') ? date('d-m-Y h:i:s A', strtotime($login_time[0]->login_time)) : NULL;
                                            if ($this->session->userdata['login']['photo_path'] != '') {
                                                $profile_photo = str_replace('/photo/', '/' . 'thumbnail' . '/', $this->session->userdata['login']['photo_path']);
                                            } elseif (!empty($_SESSION['photo_path'])) {
                                                $profile_photo = $_SESSION['photo_path'];
                                            } else {
                                                $profile_photo = base_url('assets/images/user.png');
                                            }
                                            ?>
                                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <img src="<?= $profile_photo ?>" alt="..."><?= $this->session->userdata['login']['first_name'] . ' ' . $last_name; ?>
                                                <span class=" fa fa-angle-down" style="display: -webkit-inline-box;"></span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                                <li><a href="<?= base_url('profile'); ?>"><strong>Profile</strong></a></li>
                                                <li><a href="#"><?= '<strong>Last Login Details</strong>' . "<br>" . "Date : " . htmlentities($last_login, ENT_QUOTES) . "<br>" . "IP : " . htmlentities($login_time[0]->ip_address, ENT_QUOTES); ?></a></li>                                        
                                                <li><a href="<?= base_url('login/logout'); ?>"><i class="fa fa-sign-out pull-right"></i><strong>Log Out</strong></a></li>
                                            </ul>
                                        </li>
                                    </div>
                                </div>

                            </ul>


                        </nav>

                        <div class="col-xs-12 top_search  visible-xs center-block" style="margin-top:20px;">
                            <?php
                            if ($this->session->userdata['login']['ref_m_usertype_id'] == USER_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_MASTER_ADMIN || $this->session->userdata['login']['ref_m_usertype_id'] == USER_ACTION_ADMIN) {
                                $attribute = array('name' => 'search', 'id' => 'search', 'autocomplete' => 'off');
                                echo form_open('admin/search', $attribute);
                                ?>
                                <div class="input-group">
                                    <input class="form-control" name="search" id="search" maxlength="30" required placeholder="Search for..." type="text">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit" value="1" name="submit"> Go!</button>
                                    </span>
                                </div>
                                <?php
                                echo form_close();
                            }
                            ?>
                        </div>
                    </div>
                </div>

