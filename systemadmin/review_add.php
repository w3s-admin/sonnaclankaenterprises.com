<?
require_once '../cpad/reviewController.php';
CommonBase::IsAdminUser("user_curd");
$save_msg = $save_msg ?? null;
$name = $name ?? null;
$title = $title ?? null;
$country = $country ?? null;
$comment = $comment ?? null;
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
                $("#form-validate_addReview").validate({
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

                        <h3>Add Review</h3>                    

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
                            <li class="active">Add Review</li>
                        </ul>

                    </div><!-- End .heading-->

                    <!-- Build page from here: -->
                    <form class="form-horizontal" id="form-validate_addReview" action=""  enctype="multipart/form-data"  method="post">
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
                                            <?= ($save_msg != NULL) ? "$save_msg" : "" ?>
                                            <?= (isset($_GET['save_msg'])) ? CommonBase::decrypt($_GET['save_msg']) : "" ?>
                                        </div>

                                        <div class="row-fluid">
                                            <div class="span6">   
                                                    
                                                <div class="form-row row-fluid">
                                                    <div class="span12">
                                                        <div class="row-fluid">
                                                            <label class="form-label span4 red" for="name">Name</label>
                                                            <input class="span6 required" id="name" name="name" value="<?= $name ?>"  type="text" />
                                                        </div>
                                                    </div>
                                                </div> 

                                                <div class="form-row row-fluid">
                                                    <div class="span12">
                                                        <div class="row-fluid">
                                                            <label class="form-label span4 red" for="name">Title</label>
                                                            <input class="span6 required" id="title" name="title"  value="<?= $title ?>" type="text" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-row row-fluid">
                                                    <div class="span12">
                                                        <div class="row-fluid">
                                                            <label class="form-label span4 red" for="name">Country</label>
                                                            <input class="span6" id="country" name="country"  value="<?= ${'country'} ?>" type="text" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-row row-fluid">
                                                    <div class="span12">
                                                        <div class="row-fluid">
                                                            <label class="form-label span4 red" for="name">Comment</label>
                                                            <textarea rows="5" id="textarea" name="comment" class="span6 uniform"><?= ${'comment'} ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-row row-fluid">
                                                    <div class="span12">
                                                        <div class="row-fluid">
                                                            <label class="form-label span4 red" for="name">Image</label>
                                                            <input type="file" name="fileinput" class="nostyle span5" id="file"  style="margin: 0"/>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row-fluid">
                                            <div class="span12">
                                                <div class="row-fluid">
                                                    <div class="form-actions">
                                                        <div class="span3"></div>
                                                        <div class="span9 controls">
                                                            <button type="submit" class="btn marginR10 btn-info" name="review_save_btn">Save changes</button>
                                                            <button class="btn btn-danger" type="reset">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>

                                    </div>
                                </div>
                            </div>
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
