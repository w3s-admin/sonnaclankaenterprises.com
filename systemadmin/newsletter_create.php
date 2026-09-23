<?
require_once '../cpad/emailController.php';
CommonBase::IsAdminUser();

// Newsletter tools parked for now - see newsletter_add_emails.php.
include './inc/feature_disabled.php';

extract($_GET);
// del_msg/email_msg are rendered as raw HTML below; they must only ever come
// from a message this app built itself, never straight from the query
// string (extract($_GET) would otherwise hand a crafted link full control).
if (!empty($_SESSION['_flash_email_msg'])) {
    $email_msg = $_SESSION['_flash_email_msg'];
    unset($_SESSION['_flash_email_msg']);
} else {
    $email_msg = null;
}
$del_msg = null;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <? include_once './inc/comman_head_admin.php'; ?>

        <!-- Plugin stylesheets -->


        <link href="plugins/forms/select/select2.css" type="text/css" rel="stylesheet" />


        <link href="plugins/forms/inputlimiter/jquery.inputlimiter.css" type="text/css" rel="stylesheet" />
        <link href="plugins/forms/ibutton/jquery.ibutton.css" type="text/css" rel="stylesheet" />
        <!-- Form plugins -->
        <script type="text/javascript" src="plugins/forms/watermark/jquery.watermark.min.js"></script>
        <script type="text/javascript" src="plugins/forms/uniform/jquery.uniform.min.js"></script>
        <script type="text/javascript" src="plugins/forms/select/select2.min.js"></script>

        <script type="text/javascript" src="plugins/forms/inputlimiter/jquery.inputlimiter.1.3.min.js"></script>

        <script type="text/javascript" src="plugins/forms/ibutton/jquery.ibutton.min.js"></script>

        <script type="text/javascript" src="plugins/forms/validate/jquery.validate.min.js"></script>
        <link href="plugins/forms/validate/validate.css" type="text/css" rel="stylesheet" />

        <link href="css/supr-theme/jquery.ui.supr.css" rel="stylesheet" type="text/css"/>
        <link href="css/icons.css" rel="stylesheet" type="text/css" />


        <!-- Important Place before main.js  -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/supr-theme/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" src="js/supr-theme/jquery-ui-sliderAccess.js"></script>
        <script type="text/javascript" src="plugins/fix/touch-punch/jquery.ui.touch-punch.min.js"></script><!-- Unable touch for JQueryUI -->

        <!-- Table plugins -->
        <link href="plugins/tables/dataTables/jquery.dataTables.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="plugins/tables/dataTables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="plugins/tables/responsive-tables/responsive-tables.js"></script><!-- Make tables responsive -->
        <script type="text/javascript" src="js/datatable.js"></script><!-- Init plugins only for page -->

        <!-- fancybox -->
        <link href="plugins/gallery/fancybox/jquery.fancybox.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="plugins/gallery/fancybox/jquery.fancybox.js"></script>
        <link href="plugins/misc/pnotify/jquery.pnotify.default.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="plugins/misc/pnotify/jquery.pnotify.min.js"></script>
        <script type="text/javascript" src="plugins/forms/format-curancy/jquery.formatCurrency-1.4.0.min.js"></script>
        <script type="text/javascript" src="plugins/forms/jedit/jquery.jeditable.js"></script>
        <script type="text/javascript">
            $(function() {


                $(".popup_img").fancybox();

                $(".popup2").fancybox({
                    'hideOnContentClick': true,
                    'type': 'iframe',
                    'padding': 10,
                    'onComplete': function() {
                        $('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
                            $('#fancybox-content').height($(this).contents().find('body').height() + 30);
                        });
                    }
                });

                $(".popup").fancybox({
                    'width': '75%',
                    'height': '85%',
                    'autoScale': 'false',
                    'transitionIn': 'none',
                    'transitionOut': 'none',
                    'type': 'iframe'
                });


            });</script>

    </head>

    <body>
        <!-- loading animation -->
        <div id="qLoverlay"></div>
        <div   id="qLbar"></div>
        <? include_once './inc/pagehead.php'; ?>
        <div id="wrapper">

            <!--Responsive navigation button-->  
            <div class="resBtn">
                <a href="#"><span class="icon16 minia-icon-list-3"></span></a>
            </div>

            <? include_once './inc/slideBar.php'; ?>

            <!--Body content-->
            <div id="content" class="clearfix">
                <div class="contentwrapper"><!--Content wrapper-->

                    <div class="heading">

                        <h3>Create Task for User(s)</h3>                    

                        <div class="resBtnSearch">
                            <a href="#"><span class="icon16 icomoon-icon-search-3"></span></a>
                        </div>

                        <?
                        include_once './inc/search.php';
                        ?>

                        <ul class="breadcrumb">
                            <li>You are here:</li>
                            <li>
                                <a href="dashboard.php" class="tip" title="back to dashboard">
                                    <span class="icon16 icomoon-icon-screen-2"></span>
                                </a> 
                                <span class="divider">
                                    <span class="icon16 icomoon-icon-arrow-right-2"></span>
                                </span>
                            </li>
                            <li class="active">Create Task</li>
                        </ul>

                    </div><!-- End .heading-->

                    <!-- Build page from here: -->
                    <div class="row-fluid">

                        <div class="span12">

                            <div class="box">

                                <div class="title">

                                    <h4>
                                        <span class="icon16 icomoon-icon-equalizer-2"></span>
                                        <span>Selected Email(s)</span>
                                    </h4>
                                    <a class="minimize" href="#" style="display: none;">Minimize</a>
                                </div>
                                <div class="content ">
                                    <?= (isset($email_msg)) ? $email_msg : "" ?>
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <?= Emails::getAvailableEmails() ?>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End .box -->
                        </div><!-- End .span12 -->
                    </div>
                    <div class="row-fluid">

                        <div class="span12">

                            <div class="box">

                                <div class="title">

                                    <h4>
                                        <span class="icon16 icomoon-icon-equalizer-2"></span>
                                        <span>Email Preview</span>
                                    </h4>
                                    <a class="minimize" href="#" style="display: none;">Minimize</a>
                                </div>
                                <div class="content ">
                                    <div class="row-fluid">
                                        <div class="span12" style="height:400px; overflow:auto; ">


                                            <table width="800" border="0" cellpadding="0" cellspacing="0" align="center" style="background-color:#F9F9F9">
                                                <tr>
                                                    <td colspan="2"><img src="images/newsletter/kaduwela_head.jpg" width="800" height="175" alt="Kaduwela Enterprises" /></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" align="center" style="background:#09F; padding:0px">
                                                        <h3 style="font-family:Arial, Helvetica, sans-serif; font-size:20px; font-weight:bold; color:#FFF">
                                                            Vehicle Stock List Update <?= date("F j, Y, g:i a", strtotime(CommonBase::getcurrenttime())) ?>
                                                        </h3></td>
                                                </tr>
                                                <tr>

                                                    <?= Emails::viewNewslatter(); ?>


                                                </tr>

                                                <tr>
                                                    <td colspan="2" align="center" style="background:#09F; padding:10px"><spam style="font-family:Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold; color:#FFF">&copy; <?= date("Y") ?>. All Rights Reserved. Solution provided by <a href="https://www.facebook.com/w3ssolutions" target="_blank" style="text-decoration:none; color:#333; font-size:11px">W3S Solutions</a></spam></td>
                                                </tr>
                                            </table>


                                        </div>
                                    </div>
                                </div>
                            </div><!-- End .box -->
                        </div><!-- End .span12 -->
                    </div>
                    <div class="row-fluid">

                        <div class="span12">

                            <div class="box">

                                <div class="title">

                                    <h4>
                                        <span class="icon16 icomoon-icon-equalizer-2"></span>
                                        <span>Selected Email(s)</span>
                                    </h4>
                                    <a class="minimize" href="#" style="display: none;">Minimize</a>
                                </div>
                                <div class="content ">
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <?= (isset($errmsg)) ? $errmsg : "" ?>
                                        </div>
                                    </div>
                                    <form action="" class="form-horizontal" method="post">
                                        <div class="form-row row-fluid">
                                            <div class="span12">
                                                <div class="row-fluid">
                                                    <label for="normal" class="form-label span2">Custom Subject</label>
                                                    <input class="span4"  name="subject" type="text" value="Vehicle Stock List Update <?= date("F j, Y, g:i a", strtotime(CommonBase::getcurrenttime())) ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row row-fluid">
                                            <div class="span12">
                                                <div class="row-fluid">
                                                    <button type="submit" name="sendmails" class="btn btn-warning " onclick="return confirm('Are you Sure ?')">Send Newsletter</button>
                                                    <div class="span2">                                                       

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>

                                </form>
                            </div>
                        </div><!-- End .box -->
                    </div><!-- End .span12 -->
                </div>
            </div><!-- End .span12 -->

        </div>

        <!-- End .row-fluid -->
        <!--End page -->

        </div><!-- End contentwrapper -->
        </div><!-- End #content -->

        </div><!-- End #wrapper -->

        <? include_once './inc/comman_js.php'; ?>


    </body>
</html>
