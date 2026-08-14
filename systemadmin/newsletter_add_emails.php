<?
require_once '../cpad/emailController.php';
require_once '../cpad/vehicleController.php';
CommonBase::IsAdminUser();

$all_emais = Emails::getallemails(1);
$all_seleced = Emails::getallemails(2);
$totel_emails = Emails::getallemails_count(3);
$seleced_emails = Emails::getallemails_count(2);
$none_selected_emails = Emails::getallemails_count(1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <? include_once './inc/comman_head_admin.php'; ?>

        <!-- Plugin stylesheets -->




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
                if ($('table').hasClass('dynamicTable_task')) {

                    var oTable = $('.dynamicTable_task').dataTable({
                        "sPaginationType": "full_numbers",
                        "aoColumnDefs": [
                            {"bSortable": false, "aTargets": [0]}
                        ]
                    });

                }

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



                $("#all_emais").click(function()
                {

                    var checked_status = this.checked;
                    $(".chkall").each(function()
                    {
                        this.checked = checked_status;
                    });

                });
                $("#all_selected").click(function()
                {
                    var checked_status = this.checked;
                    $(".chkselected").each(function()
                    {
                        this.checked = checked_status;
                    });
                });

            });</script>

        <?= (isset($del_msg)) ? CommonBase::decrypt($del_msg) : "" ?>
        <?= (isset($email_msg)) ? $email_msg : "" ?>
        <?= (isset($_GET['email_msg'])) ? CommonBase::decrypt($_GET['email_msg']) : "" ?>
        <style type="text/css" >
            .dataTables_wrapper .dataTables_filter{
                float: left;
                margin-left: 0px;
            }
            .dataTables_wrapper  .dataTables_length{
                float: left;
                margin-left: 0px;
            }
            .paging_full_numbers a.paginate_button {
                background: -moz-linear-gradient(center top , #FFFFFF 1%, #F3F3F3 100%) repeat scroll 0 0 transparent;
                border: 1px solid #C4C4C4;
                border-radius: 1px 1px 1px 1px;
                box-shadow: 0 1px 0 #EAEAEA, 0 1px 0 #FFFFFF inset;
                color: #717171;
                display: inline-block;
                float: left;
                font-size: 10px;
                font-weight: bold;
                line-height: 28px;
                margin-right: 1px;
                min-height: 28px;
                padding: 0 11px;
                text-decoration: none;
                font-size: 10px;
            }
            .dataTables_paginate {
                margin-right: 0px;
            }
        </style>
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
                                        <span>Property Filters</span>
                                        <span class="label label-info">Total Email(s) : <?= $totel_emails ?></span>
                                        <span class="label label-info">Selected Email(s) : <?= $seleced_emails ?></span>
                                        <span class="label label-info">Non Selected Email(s) : <?= $none_selected_emails ?></span>
                                    </h4>
                                    <a class="minimize" href="#" style="display: none;">Minimize</a>
                                </div>
                                <div class="content">
                                    <div class="row-fluid"> 
                                        <div class="span12" >

                                            <form id="frmOptions" method="post" class=" form-inline span12" style="margin: 0px;">
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="leftBox">
                                                            <div class="span12">
                                                                <h4>Non Selected Email(s) </h4>
                                                                 
                                                            </div>
                                                            <table cellpadding="0" cellspacing="0" border="0" class="dynamicTable_task display table table-bordered" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox" id="all_emais" class="nostyle" /></th>
                                                                        <th>Name</th>
                                                                        <th>Email</th>      
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?
                                                                    while ($row = $all_emais->fetch(PDO::FETCH_ASSOC)) {
                                                                        $id_all = CommonBase::encrypt($row['Id']);
                                                                        $chk_all = "<input type=\"checkbox\" name=\"che_all['" . $id_all . "']\" class=\"chkall nostyle\" value=\"$id_all\">";
                                                                        ?>
                                                                        <tr  id="<?= CommonBase::encrypt($row['Id']) ?>" >
                                                                            <td class="nonedit"><?= $chk_all ?></td>
                                                                            <td class="name"><?= $row['name'] ?></td>
                                                                            <td class="email"><?= $row['email'] ?></td>


                                                                        </tr>
                                                                    <? }
                                                                    ?>  
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th>Name</th>
                                                                        <th>Email</th>                                              

                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                        <div class="dualBtn">
                                                            <button class="btn  " type="submit" name="addselected"  ><span class="icon12 minia-icon-arrow-right-3"></span></button>
                                                            <button class="btn  " type="submit" name="addselected_all"  ><span class="icon12 iconic-icon-last"></span></button>
                                                            <button class="btn  " type="submit" name="removeselected" ><span class="icon12 minia-icon-arrow-left-3"></span></button>
                                                            <button class="btn   " type="submit" name="removeselected_all" ><span class="icon12 iconic-icon-first"></span></button>
                                                        </div>                                        
                                                        <div class="rightBox">
                                                            <div class="span12">
                                                                <h4>Selected Email(s)</h4>
                                                            </div>
                                                            <table cellpadding="0" cellspacing="0" border="0" class="dynamicTable_task display table table-bordered" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox" id="all_selected"/></th>
                                                                        <th>Name</th>
                                                                        <th>Email</th>      
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?
                                                                    while ($row = $all_seleced->fetch(PDO::FETCH_ASSOC)) {
                                                                        $id_all = CommonBase::encrypt($row['Id']);
                                                                        $chk_all = "<input type=\"checkbox\" name=\"che_selcted['" . $id_all . "']\" class=\"chkselected nostyle\" value=\"$id_all\">";
                                                                        ?>
                                                                        <tr  id="<?= CommonBase::encrypt($row['Id']) ?>" >
                                                                            <td class="nonedit"><?= $chk_all ?></td>
                                                                            <td class="name"><?= $row['name'] ?></td>
                                                                            <td class="email"><?= $row['email'] ?></td>
                                                                        </tr>
                                                                    <? }
                                                                    ?>  
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th>Name</th>
                                                                        <th>Email</th>                                              

                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>






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
