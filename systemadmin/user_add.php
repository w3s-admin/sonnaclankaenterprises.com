<?
require_once '../cpad/userController.php';
CommonBase::IsAdminUser("user_curd");
$shop_save_msg = $shop_save_msg ?? null;
$fname = $fname ?? null;
$lname = $lname ?? null;
$uname = $uname ?? null;
$email = $email ?? null;
$email_password = $email_password ?? null;
$password = $password ?? null;
$sadmin = $sadmin ?? null;
${'contact_number'} = ${'contact_number'} ?? null;
${'other'} = ${'other'} ?? null;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

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


        <script type="text/javascript" src="plugins/files/ajaxupload.3.5.js"></script>
        <script type="text/javascript">
            $(function() {
                $("#form-validate_addUser").validate({
                    ignore: null,
                    ignore: 'input[type="hidden"]',
                            rules: {
                        email: {
                            required: true,
                            email: true
                        }

                    }
                });

                if ($('textarea').hasClass('limit')) {
                    $('.limit').inputlimiter({
                        limit: 250
                    });
                }

                $(".zone_select").select2();
                $(".ibutton").iButton({
                    labelOn: "ON",
                    labelOff: "OFF",
                    enableDrag: false
                });
            });
        </script>
        <script type="text/javascript" src="js/ajxupload_quary.js" ></script>

    </head>

    <body>

        <!-- loading animation -->
        <div id="qLoverlay"></div>
        <div   id="qLbar"></div>


        <?   include_once './inc/pagehead.php'; ?>

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

                        <h3>Add User</h3>                    

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
                            <li class="active">Add User</li>
                        </ul>

                    </div><!-- End .heading-->

                    <!-- Build page from here: -->
                    <form class="form-horizontal" id="form-validate_addUser" action=""  enctype="multipart/form-data"  method="post">
                        <div class="row-fluid">

                            <div class="span12">

                                <div class="box">

                                    <div class="title">

                                        <h4> 
                                            <span>Main Details</span>
                                        </h4>

                                    </div>
                                    <div class="content">
                                                                               
                                        <div class="span12">
                                            
                                            <?= ($shop_save_msg != NULL) ? "$shop_save_msg" : "" ?>
                                            <?= (isset($_GET['shop_save_msg'])) ? CommonBase::decrypt($_GET['shop_save_msg']) : "" ?></div>
                                        <div class="row-fluid">
                                           <div class="span6">   
                                            <div>

                                            </div><div class="form-row row-fluid">
                                                <div class="span12">
                                                    <div class="row-fluid">
                                                        <label class="form-label span4 red" for="name">First Name</label>
                                                        <input class="span6 required" id="fname" name="fname" value="<?= $fname ?>"  type="text" />
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="form-row row-fluid">
                                                <div class="span12">
                                                    <div class="row-fluid">
                                                        <label class="form-label span4 red" for="name">Last Name</label>
                                                        <input class="span6 required" id="lname" name="lname"  value="<?= $lname ?>" type="text" />
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="form-row row-fluid">
                                                <div class="span12">
                                                    <div class="row-fluid">
                                                        <label class="form-label span4 " for="name">Contacts</label>
                                                        <input class="span6" id="contact_number" name="contact_number"  value="<?= ${'contact_number'} ?>" type="text" />
                                                    </div>
                                                </div>
                                            </div> 
                                             <div class="form-row row-fluid">
                                                <div class="span12">
                                                    <div class="row-fluid">
                                                        <label class="form-label span4 " for="name">Other</label>
                                                       <textarea rows="3" id="textarea" name="other" class="span6 uniform"><?= ${'other'} ?></textarea>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="form-row row-fluid">
                                                <div class="span12">
                                                    <div class="row-fluid">
                                                        <label class="form-label span4 red" for="name">Email</label>
                                                        <input class="span6 required" id="email" name="email"  value="<?= $email ?>" type="text" />
                                                    </div>
                                                </div>
                                            </div> 
                                               <div class="form-row row-fluid " style="display: none">
                                                <div class="span12">
                                                    <div class="row-fluid">
                                                        <label class="form-label span4 red" for="name">Email Password</label>
                                                        <input class="span6 " id="email_password" name="email_password"  value="<?= $email_password ?>" type="text" />
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="form-row row-fluid">
                                                <div class="span12">
                                                    <div class="row-fluid">
                                                        <label class="form-label span4 red" for="name">User Name</label>
                                                        <input class="span6 required" id="name" name="uname" value="<?= $uname ?>"   type="text" />
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="form-row row-fluid">
                                                <div class="span12">
                                                    <div class="row-fluid">
                                                        <label class="form-label span4 red" for="required">Password</label>
                                                        <input class="span6 required" id="password" name="password" value="<?= $password ?>"   type="text" />
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
                                            </div> </div>
                                        <div class="span6 permissions-panel">
                                            <?
                                            $privelage_type = User::get_privilage();
                                            
                                            while ($row = $privelage_type->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                <div class="span12">
                                                    <h4> <?= $row['name'] ?> </h4>
                                                </div>
                                                <?
                                                $privelage_pro = User::get_privilage($row['Id']);
                                                while ($row = $privelage_pro->fetch(PDO::FETCH_ASSOC)) {
                                                    ?>
                                                    <div class="form-row row-fluid">
                                                        <div class="span12">
                                                            <div class="row-fluid">
                                                                <label class="form-label span5 " for="phone"><?= $row['name'] ?></label>
                                                                <div class="left marginR10">
                                                                    <input type="checkbox" id="<?= "pro_" . $row['Id'] ?>" value="<?= $row['Id'] ?>" name="<?= "pro_" . $row['Id'] ?>" <?= CommonBase::checked_value(${"pro_" . $row['Id']} ?? null) ?>  class="ibutton nostyle" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <? } ?>
                                            <? } ?>
                                        </div>
                                            
                                        </div>
                                        
                                        
                                        <div class="row-fluid">
                                            <div class="span12">
                                                <div class="row-fluid">
                                                    <div class="form-actions">
                                                        <div class="span3"></div>
                                                        <div class="span9 controls">
                                                            <button type="submit" class="btn marginR10 btn-info" name="user_save_btn">Save changes</button>
                                                            <button class="btn btn-danger" type="reset">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>




                                    </div>
                                </div></div>

                        </div>
                    </form>
                    <!-- End .row-fluid -->
                    <!--End page -->

                </div><!-- End contentwrapper -->
            </div><!-- End #content -->

        </div><!-- End #wrapper -->

        <? include_once './inc/comman_js.php'; ?>


    </body>
</html>
