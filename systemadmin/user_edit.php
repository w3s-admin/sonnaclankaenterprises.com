<?
require_once '../cpad/userController.php';
CommonBase::IsAdminUser('super_admin');
if (isset($_GET['uid'])) {
    $userID = CommonBase::decrypt($_GET['uid']);
    if (is_numeric($userID)) {
        $row = User::getUserById($userID);
        $fname = $row['firstname'];
        $lname = $row['lastname'];
        $uname = $row['username'];
        $email_password = $row['email_password'];
        $email = $row['email'];
        $sadmin = $row['super_admin'];
        ${'contact_number'} = $row['contact_number'];
        ${'other'} = $row['other'];
    } else {
        //  exit();
    }
}
$shop_save_msg = $shop_save_msg ?? null;
$fname = $fname ?? null;
$lname = $lname ?? null;
$uname = $uname ?? null;
$email = $email ?? null;
$email_password = $email_password ?? null;
$sadmin = $sadmin ?? null;
$password = $password ?? null;
${'contact_number'} = ${'contact_number'} ?? null;
${'other'} = ${'other'} ?? null;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Edit User</title>
        <? include_once './inc/comman_head_admin.php'; ?>
        <!-- Plugin stylesheets -->


        <link href="plugins/forms/select/select2.css" type="text/css" rel="stylesheet" />
        <link href="plugins/forms/validate/validate.css" type="text/css" rel="stylesheet" />

        <link href="plugins/forms/inputlimiter/jquery.inputlimiter.css" type="text/css" rel="stylesheet" />
        <link href="plugins/forms/ibutton/jquery.ibutton.css" type="text/css" rel="stylesheet" />
        <!-- Form plugins -->
        <script type="text/javascript" src="plugins/forms/watermark/jquery.watermark.min.js"></script>
        <script type="text/javascript" src="plugins/forms/uniform/jquery.uniform.min.js"></script>
        <script type="text/javascript" src="plugins/forms/select/select2.min.js"></script>
        <script type="text/javascript" src="plugins/forms/validate/jquery.validate.min.js"></script>
        <script type="text/javascript" src="plugins/forms/inputlimiter/jquery.inputlimiter.1.3.min.js"></script>

        <script type="text/javascript" src="plugins/forms/ibutton/jquery.ibutton.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $("#form-validate_addshop").validate({
                    ignore: null,
                    ignore: 'input[type="hidden"]',
                            rules: {
                        required1: {
                            required: true,
                            minlength: 4
                        }

                    }
                });

                if ($('textarea').hasClass('limit')) {
                    $('.limit').inputlimiter({
                        limit: 250
                    });
                }


                $(".ibutton").iButton({
                    labelOn: "ON",
                    labelOff: "OFF",
                    enableDrag: false
                });
            })
        </script>

    </head>
    <body>
        <div class="row-fluid">
            <div class="span12">

                <div class="box">

                    <div class="title">

                        <h4>
                            <span>Edit User</span>
                        </h4>

                    </div>
                    <div class="content">
                        <div>
                            <?= ($shop_save_msg != NULL) ? "$shop_save_msg" : "" ?>
                        </div>
                        <form class="form-horizontal" id="form-validate_addshop" action=""  enctype="multipart/form-data"  method="post">
                            <div class="form-row row-fluid">
                                <div class="span12">
                                    <div class="row-fluid">
                                        <label class="form-label span4 red" for="name">First Name</label>
                                        <input class="span8 required" id="fname" name="fname" value="<?= htmlspecialchars($fname ?? '', ENT_QUOTES, 'UTF-8') ?>"  type="text" />
                                    </div>
                                </div>
                            </div> 
                            <div class="form-row row-fluid">
                                <div class="span12">
                                    <div class="row-fluid">
                                        <label class="form-label span4 red" for="name">Last Name</label>
                                        <input class="span8 required" id="lname" name="lname"  value="<?= htmlspecialchars($lname ?? '', ENT_QUOTES, 'UTF-8') ?>" type="text" />
                                    </div>
                                </div>
                            </div> 
                            <div class="form-row row-fluid">
                                <div class="span12">
                                    <div class="row-fluid">
                                        <label class="form-label span4 " for="name">Contacts</label>
                                        <input class="span8" id="contact_number" name="contact_number"  value="<?= htmlspecialchars(${'contact_number'} ?? '', ENT_QUOTES, 'UTF-8') ?>" type="text" />
                                    </div>
                                </div>
                            </div> 
                            <div class="form-row row-fluid">
                                <div class="span12">
                                    <div class="row-fluid">
                                        <label class="form-label span4 " for="name">Other</label>
                                        <textarea rows="3" id="textarea" name="other" class="span8 uniform"><?= htmlspecialchars(${'other'} ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                                    </div>
                                </div>
                            </div> 
                            <div class="form-row row-fluid">
                                <div class="span12">
                                    <div class="row-fluid">
                                        <label class="form-label span4 red" for="name">Email</label>
                                        <input class="span8 required" id="email" name="email"  value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>" type="text" />
                                    </div>
                                </div>
                            </div> 
                            <div class="form-row row-fluid"  style="display: none">
                                <div class="span12">
                                    <div class="row-fluid">
                                        <label class="form-label span4 red" for="name">Email Pw</label>
                                        <input class="span8 " id="email_password" name="email_password"  value="<?= htmlspecialchars($email_password ?? '', ENT_QUOTES, 'UTF-8') ?>" type="text" />
                                    </div>
                                </div>
                            </div> 
                            <div class="form-row row-fluid">
                                <div class="span12">
                                    <div class="row-fluid">
                                        <label class="form-label span4 red" for="name">User Name</label>
                                        <input class="span8 required" id="name" name="uname" value="<?= htmlspecialchars($uname ?? '', ENT_QUOTES, 'UTF-8') ?>"   type="text" />
                                    </div>
                                </div>
                            </div> 


                            <div class="form-row row-fluid">
                                <div class="span12">
                                    <div class="row-fluid">
                                        <label class="form-label span4 " for="phone">Super Admin</label>
                                        <div class="left marginR10">
                                            <input type="checkbox" id="inlineCheckbox4" value="1" name="sadmin" <?= CommonBase::checked($sadmin) ?>  class="ibutton nostyle" /> 
                                        </div>
                                    </div>
                                </div>
                            </div> 

                            <div class="form-row row-fluid">
                                <div class="span12">
                                    <div class="row-fluid">
                                        <div class="form-actions">
                                            <div class="span3"></div>
                                            <div class="span9 controls">
                                                <button type="submit" class="btn btn-warning marginR10" name="user_editbtn_btn">Edit User</button>

                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </form>
                    </div>
                </div>



            </div>

        </div>
        <div class="row-fluid">
            <div class="span12">

                <div class="box">

                    <div class="title">

                        <h4>
                            <span>Change Password</span>
                        </h4>

                    </div>
                    <div class="content">

                        <form class="form-horizontal" id="form-validate_addshop" action=""  enctype="multipart/form-data"  method="post">

                            <div class="form-row row-fluid">
                                <div class="span12">
                                    <div class="row-fluid">
                                        <label class="form-label span5 red" for="required">Password</label>
                                        <input class="span6 required" id="password" name="password" value="<?= htmlspecialchars($password ?? '', ENT_QUOTES, 'UTF-8') ?>"   type="password" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row row-fluid">
                                <div class="span12">
                                    <div class="row-fluid">
                                        <label class="form-label span5 red" for="required">Confirm Password</label>
                                        <input class="span6 required" id="cpassword" name="cpassword" value="<?= htmlspecialchars($password ?? '', ENT_QUOTES, 'UTF-8') ?>"   type="password" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-row row-fluid">
                                <div class="span12">
                                    <div class="row-fluid">
                                        <div class="form-actions">
                                            <div class="span3"></div>
                                            <div class="span6 controls">
                                                <button type="submit" class="btn btn-warning marginR10" name="user_change_password">Change Password</button>

                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </form>



                    </div>
                </div>



            </div>
        </div>
        <? include_once './inc/comman_js.php'; ?>
    </body>
</html>
