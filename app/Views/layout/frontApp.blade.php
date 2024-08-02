<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= base_url() . 'assets/newDesign/' ?>images/logo.png" type="image/png" />
    <title>SC-eFM</title>
    <link href="<?= base_url() . 'assets/newDesign/' ?>css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url() . 'assets/newDesign/' ?>css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?= base_url() . 'assets/newDesign/' ?>css/material.css" rel="stylesheet" />
    <link href="<?= base_url() . 'assets/newDesign/' ?>css/glyphicons.css" rel="stylesheet" />
    <link href="<?= base_url() . 'assets/newDesign/' ?>css/owl.carousel.min.css" rel="stylesheet" />
    <link href="<?= base_url() . 'assets/newDesign/' ?>css/owl.theme.default.css" rel="stylesheet">
    <link href="<?= base_url() . 'assets/newDesign/' ?>css/animate.css" rel="stylesheet">
    <link href="<?= base_url() . 'assets/newDesign/' ?>css/style.css" rel="stylesheet" />
</head>
<?php $session = session(); ?>
<body class="login-page">
    @include('layout.frontHeader')
    @yield('content')
    @include('layout.frontFooter')
    <script src="<?= base_url() . 'assets/newDesign/' ?>js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url() . 'assets/newDesign/' ?>js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() . 'assets/newDesign/' ?>js/jquery.easy-ticker.min.js"></script>
    <script src="<?= base_url() . 'assets/newDesign/' ?>js/wow.min.js"></script>
    <script src="<?= base_url() . 'assets/newDesign/' ?>js/owl.carousel.js"></script>
    <script src="<?= base_url() . 'assets/newDesign/' ?>js/custom.js"></script>
    <script></script>
    <script type="text/javascript" src="{{base_url('assets/responsive_variant/js/jquery/jquery-3.5.0.min.js')}}"></script>

<script src="{{base_url('assets/responsive_variant/frameworks/uikit_3-4-1/js/uikit.min.js')}}"></script>
<script src="{{base_url('assets/responsive_variant/frameworks/uikit_3-4-1/js/uikit-icons.min.js')}}"></script>

<!-- scutum JS -->
<script type="text/javascript" src="{{base_url('assets/responsive_variant/templates/uikit_scutum_2/assets/js/vendor.min.js')}}"></script>
<script type="text/javascript" src="{{base_url('assets/responsive_variant/templates/uikit_scutum_2/assets/js/vendor/loadjs.js')}}"></script>
<script type="text/javascript" src="{{base_url('/assets/responsive_variant/templates/uikit_scutum_2/assets/js/scutum_common.js')}}"></script>



<script type="text/javascript" src="<?= base_url().'assets'?>/js/case_status/bootstrap.min.js"></script>

<script type="text/javascript" src="<?=base_url()?>assets/js/aes.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/aes-json-format.js"></script>
<script src="<?=base_url('CaptchaResource/js/Captcha.js');?>"></script>
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
<script src="<?= base_url('assets/js/sha256.js'); ?>" type="text/javascript"></script>
    <script src="<?=base_url('CaptchaResource/js/Captcha.js');?>"></script>
    <script type="text/javascript">
        $(function(){
            @if(empty(@$session->get('user')))
                $('[name="txt_username"]').focus();
            @else
                $('[name="txt_password"]').focus();
            @endif
    
        });
    </script>
    <script>
        function enableSubmit() {
            var form = this;
            var password= $('[name="txt_password"]').val(); //$('#txt_password').val();
            $('[name="txt_password"]').val(sha256($('[name="txt_password"]').val()) + '<?= $_SESSION['login_salt'] ?>');
            if (password !='') {
                var pwd=sha256(password);
                var pwd2=pwd+'<?=$_SESSION['login_salt'] ?>';
            }
        }
        var base_url = '{{ base_url() }}';
    </script>
    <?php if (isset($_SESSION['adv_details']['ForgetPasswordDone']) && ($_SESSION['adv_details']['ForgetPasswordDone']=='ForgetPasswordDone')){?>
        <script>
            setTimeout(function () { window.location.href="<?php echo base_url('login/logout')?>";  }, 2000);
        </script>
    <?php }?>   
    @stack('script')
</body>

</html>
