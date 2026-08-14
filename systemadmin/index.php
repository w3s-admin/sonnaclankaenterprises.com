<?
require_once '../cpad/clsCommonBase.php';
CommonBase::create_property_session();
require_once '../cpad/loginController.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

     
        <link href="css/bootstrap/bootstrap.css" rel="stylesheet" />
        <link href="css/bootstrap/bootstrap-responsive.css" rel="stylesheet" />
        <link href="css/supr-theme/jquery.ui.supr.css" rel="stylesheet" type="text/css"/>
        <link href="css/icons.css" rel="stylesheet" type="text/css" />
        <link href="plugins/forms/uniform/uniform.default.css" type="text/css" rel="stylesheet" />

        <!-- Main stylesheets -->
        <link href="css/main.css" rel="stylesheet" type="text/css" /> 

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


       <script type="text/javascript" src="js/jquery.min1.7.js"></script>
        <script type="text/javascript" src="js/bootstrap/bootstrap.js"></script>  
        <script type="text/javascript" src="plugins/misc/touch-punch/jquery.ui.touch-punch.min.js"></script>
        <script type="text/javascript" src="plugins/misc/ios-fix/ios-orientationchange-fix.js"></script>
        <script type="text/javascript" src="plugins/forms/validate/jquery.validate.min.js"></script>
        <script type="text/javascript" src="plugins/forms/uniform/jquery.uniform.min.js"></script>

        <script type="text/javascript">
            // document ready function
            $(document).ready(function() {
                $("input, textarea, select").not('.nostyle').uniform();
                $("#loginForm").validate({
                    rules: {
                        username: {
                            required: true
                            
                        },
                        password: {
                            required: true
                            
                        }
                    },
                    messages: {
                        username: {
                            required: "Fill me please",
                            minlength: "My name is bigger"
                        },
                        password: {
                            required: "Please provide a password",
                            minlength: "My password is more that 6 chars"
                        }
                    }
                });
            });
        </script>


        <link href="plugins/misc/pnotify/jquery.pnotify.default.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="plugins/misc/pnotify/jquery.pnotify.min.js"></script>

    </head>

    <body class="loginPage">

        <div class="container-fluid">

            <div id="header">

                <div class="row-fluid">

                    <div class="navbar">
                        <div class="navbar-inner">
                            <div class="container">
                                <a class="brand" href="<?= $_SESSION['app_pro']['sys_url'] ?>"><?= CommonBase::createImage($_SESSION['app_pro']['server'] . $_SESSION['app_pro']['main_admin_logo_name'], 114, 50) ?>&nbsp;<?= $_SESSION['app_pro']['main_company_name'] ?><span class="slogan" style="padding-left: 4px;"><?= $_SESSION['app_pro']['sys_name'] ?></span></a>
                            </div>
                        </div><!-- /navbar-inner -->
                    </div><!-- /navbar -->


                </div><!-- End .row-fluid -->

            </div><!-- End #header -->

        </div><!-- End .container-fluid -->    

        <div class="container-fluid">

            <div class="loginContainer">
                <?
                if (isset($adminlogin_msg)) {
                    echo $adminlogin_msg;
                }
                ?>
                <form class="form-horizontal" action="" id="loginForm" method="post">
                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span12" for="username">
                                    Username:
                                    <span class="icon16 icomoon-icon-user-3 right gray marginR10"></span>
                                </label>
                                <input class="span12" id="username" type="text" name="AuserName" value="" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span12" for="password">
                                    Password:
                                    <span class="icon16 icomoon-icon-locked right gray marginR10"></span>
                                    <span class="forgot"><a href="#">Forgot your password?</a></span>
                                </label>
                                <input class="span12" id="password" type="password" name="Apassword" value="" />
                            </div>
                        </div>
                    </div>
                    <div class="form-row row-fluid">                       
                        <div class="span12">
                            <div class="row-fluid">
                                <div class="form-actions">
                                    <div class="span12 controls">
                                        <input type="checkbox" id="keepLoged" value="Value" class="styled" name="logged" /> Keep me logged in
                                        <button type="submit" name="adminlogin" class="btn btn-info right" id="loginBtn"><span class="icon16 icomoon-icon-enter white"></span> Login</button>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>

                </form>
            </div>

        </div>
        <!-- End .container-fluid --->

        <? include_once './inc/comman_js.php'; ?>
        <script type="text/javascript">
            // document ready function
            $(document).ready(function() {
                $("input, textarea, select").not('.nostyle').uniform();
                $("#loginForm").validate({
                    rules: {
                        username: {
                            required: true

                        },
                        password: {
                            required: true

                        }
                    },
                    messages: {
                        username: {
                            required: "Fill me please",
                            minlength: "My name is bigger"
                        },
                        password: {
                            required: "Please provide a password",
                            minlength: "My password is more that 6 chars"
                        }
                    }
                });
            });
        </script>

    </body>
</html>
