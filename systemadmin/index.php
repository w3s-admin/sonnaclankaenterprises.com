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


       <script type="text/javascript" src="js/jquery.min1.7.js"></script>
        <script type="text/javascript" src="js/bootstrap/bootstrap.js"></script>  
        <script type="text/javascript" src="plugins/misc/touch-punch/jquery.ui.touch-punch.min.js"></script>
        <script type="text/javascript" src="plugins/misc/ios-fix/ios-orientationchange-fix.js"></script>
        <script type="text/javascript" src="plugins/forms/validate/jquery.validate.min.js"></script>
        <script type="text/javascript" src="plugins/forms/uniform/jquery.uniform.min.js"></script>

        <link href="plugins/misc/pnotify/jquery.pnotify.default.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="plugins/misc/pnotify/jquery.pnotify.min.js"></script>

    </head>

    <body class="loginPage">

        <div class="login-screen">
            <div class="login-shell">

                <aside class="login-hero" aria-hidden="true">
                    <div class="login-hero-glow"></div>

                    <div class="login-hero-top">
                        <div class="login-hero-brand">
                            <?= CommonBase::createImage($_SESSION['app_pro']['server'] . $_SESSION['app_pro']['main_admin_logo_name'], 118, 52, "login-hero-logo", $_SESSION['app_pro']['main_company_name']) ?>
                            <div>
                                <div class="login-hero-company"><?= $_SESSION['app_pro']['main_company_name'] ?></div>
                                <div class="login-hero-sys"><?= $_SESSION['app_pro']['sys_name'] ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="login-hero-copy">
                        <h1>Drive the business <em>forward.</em></h1>
                        <p>One dashboard for every vehicle, sale and customer review.</p>
                        <div class="login-hero-rule"></div>
                        <ul class="login-hero-features">
                            <li><span class="icon16 icomoon-icon-cars"></span> Vehicle &amp; stock control</li>
                            <li><span class="icon16 icomoon-icon-star"></span> Customer reviews</li>
                            <li><span class="icon16 icomoon-icon-mail"></span> Newsletter campaigns</li>
                        </ul>
                    </div>

                    <div class="login-hero-status"><span class="dot"></span> Secure staff sign-in</div>
                </aside>

                <section class="login-panel">
                    <div class="loginContainer">
                        <div class="login-formhead">
                            <h3>Welcome back</h3>
                            <p>Sign in to the admin panel</p>
                        </div>
                        <?
                        if (isset($adminlogin_msg)) {
                            echo $adminlogin_msg;
                        }
                        ?>
                        <form class="form-horizontal" action="" id="loginForm" method="post">
                            <?= CommonBase::csrfField() ?>
                            <div class="login-field">
                                <label for="username">Username</label>
                                <div class="login-input">
                                    <span class="icon16 icomoon-icon-user-3"></span>
                                    <input id="username" type="text" name="AuserName" value="" autocomplete="username" autofocus />
                                </div>
                            </div>

                            <div class="login-field">
                                <div class="login-field-top">
                                    <label for="password">Password</label>
                                    <a class="login-forgot" href="#">Forgot your password?</a>
                                </div>
                                <div class="login-input">
                                    <span class="icon16 icomoon-icon-locked"></span>
                                    <input id="password" type="password" name="Apassword" value="" autocomplete="current-password" />
                                    <button type="button" class="login-eye-toggle" id="togglePassword" aria-label="Show password" aria-pressed="false">
                                        <span class="icon16 icomoon-icon-eye"></span>
                                    </button>
                                </div>
                            </div>

                            <div class="login-field">
                                <label class="login-remember">
                                    <input type="checkbox" id="keepLoged" value="Value" class="nostyle" name="logged" /> Keep me signed in
                                </label>
                            </div>

                            <button type="submit" name="adminlogin" class="btn btn-admin-primary" id="loginBtn"><span class="icon16 icomoon-icon-enter"></span> Sign in</button>
                        </form>
                    </div>
                    <p class="login-footnote">&copy; <?= date('Y') ?> <?= $_SESSION['app_pro']['main_company_name'] ?> &mdash; internal use only.</p>
                </section>

            </div>
        </div>
        <!-- End .login-screen --->

        <? include_once './inc/comman_js.php'; ?>
        <script type="text/javascript">
            // document ready function
            $(document).ready(function() {
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

                $("#togglePassword").on("click", function () {
                    var $pw = $("#password");
                    var isHidden = $pw.attr("type") === "password";
                    $pw.attr("type", isHidden ? "text" : "password");
                    $(this)
                        .attr("aria-pressed", isHidden ? "true" : "false")
                        .attr("aria-label", isHidden ? "Hide password" : "Show password")
                        .find(".icon16")
                        .attr("class", "icon16 " + (isHidden ? "icomoon-icon-eye-2" : "icomoon-icon-eye"));
                });
            });
        </script>

    </body>
</html>
