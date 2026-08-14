<?
require_once '../cpad/loginController.php';
CommonBase::IsAdminUser();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <? include_once './inc/comman_head_admin.php'; ?>
    </head>
    <body>
        <!-- loading animation -->
        <div id="qLoverlay"></div>
        <div id="qLbar"></div>

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

                        <h3>login Out</h3>                    

                        <div class="resBtnSearch">
                            <a href="#"><span class="icon16 icomoon-icon-search-3"></span></a>
                        </div>
                        <?
                        include_once './inc/search.php';
                        ?>


                        <ul class="breadcrumb">
                            <li>You are here:</li>
                            <li>
                                <a href="#" class="tip" title="back to dashboard">
                                    <span class="icon16 icomoon-icon-screen-2"></span>
                                </a> 
                                <span class="divider">
                                    <span class="icon16 icomoon-icon-arrow-right-2"></span>
                                </span>
                            </li>
                            <li class="active">Logout Page</li>
                        </ul>

                    </div><!-- End .heading-->

                    <!-- Build page from here: -->
                    <div class="row-fluid">



                    </div><!-- End .row-fluid -->
                    <!--End page -->
                    Please Wait....... Your Currently login out 
                </div><!-- End contentwrapper -->
            </div><!-- End #content -->

        </div><!-- End #wrapper -->

        <? include_once './inc/comman_js.php'; ?>


    </body>
</html>
