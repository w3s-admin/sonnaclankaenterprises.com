
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $_SESSION['app_pro']['sys_title'] ?></title>

<meta name="robots" content="noindex">
<meta name="googlebot" content="noindex">

<!-- Mobile Specific Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<!-- Le styles -->
<!-- Use new way for google web fonts 
http://www.smashingmagazine.com/2012/07/11/avoiding-faux-weights-styles-google-web-fonts -->
<!-- Headings -->
<!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css' />  -->
<!-- Text -->
<!-- <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css' /> --> 
<!--[if lt IE 9]>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400" rel="stylesheet" type="text/css" />
<link href="http://fonts.googleapis.com/css?family=Open+Sans:700" rel="stylesheet" type="text/css" />
<link href="http://fonts.googleapis.com/css?family=Droid+Sans:400" rel="stylesheet" type="text/css" />
<link href="http://fonts.googleapis.com/css?family=Droid+Sans:700" rel="stylesheet" type="text/css" />
<![endif]-->

<!-- Core stylesheets do not remove -->
<link href="css/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
<link href="css/supr-theme/jquery.ui.supr.css" rel="stylesheet" type="text/css"/>
<link href="css/icons.css" rel="stylesheet" type="text/css" />

<!-- Plugins stylesheets -->
<link href="plugins/misc/qtip/jquery.qtip.css" rel="stylesheet" type="text/css" />
<link href="plugins/misc/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />


<link href="plugins/forms/uniform/uniform.default.css" type="text/css" rel="stylesheet" />

<!-- Main stylesheets -->
<link href="css/main.css" rel="stylesheet" type="text/css" /> 

<!-- Custom stylesheets ( Put your own changes here ) -->
<link href="css/custom.css" rel="stylesheet" type="text/css" /> 

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Le fav and touch icons -->
<link rel="shortcut icon" href="images/favicon.ico" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/apple-touch-icon-144-precomposed.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon-114-precomposed.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72-precomposed.png" />
<link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-57-precomposed.png" />

<script type="text/javascript">
    //adding load class to body and hide page
    document.documentElement.className += 'loadstate';
</script>


<!-- Le javascript
================================================== -->
<!-- Important plugins put in all pages -->
<script type="text/javascript" src="js/jquery.min1.7.js"></script>
<script type="text/javascript" src="js/bootstrap/bootstrap.js"></script>  
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.js"></script>

<!-- Charts plugins -->
<script type="text/javascript" src="plugins/charts/flot/jquery.flot.js"></script>
<script type="text/javascript" src="plugins/charts/flot/jquery.flot.grow.js"></script>
<script type="text/javascript" src="plugins/charts/flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="plugins/charts/flot/jquery.flot.resize.js"></script>
<script type="text/javascript" src="plugins/charts/flot/jquery.flot.tooltip_0.4.4.js"></script>
<script type="text/javascript" src="plugins/charts/flot/jquery.flot.orderBars.js"></script>
<script type="text/javascript" src="plugins/charts/sparkline/jquery.sparkline.min.js"></script><!-- Sparkline plugin -->
<script type="text/javascript" src="plugins/charts/knob/jquery.knob.js"></script><!-- Circular sliders and stats -->

<!-- Misc plugins -->
<script type="text/javascript" src="plugins/misc/fullcalendar/fullcalendar.min.js"></script><!-- Calendar plugin -->
<script type="text/javascript" src="plugins/misc/qtip/jquery.qtip.min.js"></script><!-- Custom tooltip plugin -->
<script type="text/javascript" src="plugins/misc/totop/jquery.ui.totop.min.js"></script> <!-- Back to top plugin -->


<!-- Form plugins -->
<script type="text/javascript" src="plugins/forms/watermark/jquery.watermark.min.js"></script>
<script type="text/javascript" src="plugins/forms/uniform/jquery.uniform.min.js"></script>

<!-- Fix plugins -->
<script type="text/javascript" src="plugins/fix/ios-fix/ios-orientationchange-fix.js"></script>

<!-- Important Place before main.js  -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
<script type="text/javascript" src="plugins/fix/touch-punch/jquery.ui.touch-punch.min.js"></script><!-- Unable touch for JQueryUI -->

<!-- Init plugins -->
<script type="text/javascript" src="js/main.js"></script><!-- Core js functions -->
<script type="text/javascript" src="js/dashboard.js"></script><!-- Init plugins only for page -->

<script>
    function gototop(y) {
        $("html, body").animate({scrollTop: y}, "slow");
    }
</script>
<link href="plugins/gallery/fancybox/jquery.fancybox.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="plugins/gallery/fancybox/jquery.fancybox.js"></script>
<script>
    $(function() {
        $(".popup").fancybox({
            'width': '75%',
            'height': '85%',
            'autoScale': 'false',
            'transitionIn': 'none',
            'transitionOut': 'none',
            'type': 'iframe'
        });
        
        $(".popup_img").fancybox();
    })
</script>