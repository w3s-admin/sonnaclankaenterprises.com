<?
require_once '../cpad/emailController.php';
require_once '../cpad/vehicleController.php';
CommonBase::IsAdminUser();

// Newsletter tools parked for now - see newsletter_add_emails.php.
include './inc/feature_disabled.php';

// del_msg/email_msg are rendered as raw HTML below; vehicleController.php's
// extract($_GET) would otherwise let a crafted query string set these
// directly, so they may only carry a message this request itself built.
$del_msg = null;

$all_emais = Emails::getallvehicles(1);
$all_seleced = Emails::getallvehicles(2);
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

        <?= (isset($email_msg)) ? $email_msg : "" ?>
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
                                    </h4>
                                    <a class="minimize" href="#" style="display: none;">Minimize</a>
                                </div>
                                <div class="content">
                                    


                                    <div class="row-fluid">
                                        <form id="frmOptions" method="post" class=" form-inline span12" style="margin: 0px;">
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <h4>  None selected-vehicle(s)          </h4>                                 
                                                </div>                                                
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <table cellpadding="0" cellspacing="0" border="0" class="  dynamicTable_task display table table-bordered" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" id="all_emais"/></th>
                                                                <th>Ref #</th>
                                                                <th>Stock</th>
                                                                <th>Make</th>
                                                                <th>Model</th>
                                                                <th>Chasi</th>
                                                                <th>YM</th>
                                                                <th>KM</th>
                                                                <th>Price</th>
                                                                <th>Img</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?
                                                            while ($row = $all_emais->fetch(PDO::FETCH_ASSOC)) {
                                                                $img = Vehicle::getFirastimage($row['Id']);
                                                                $id_all = CommonBase::encrypt($row['Id']);
                                                                $chk_all = "<input type=\"checkbox\" name=\"che_all['" . $id_all . "']\" class=\"nostyle chkall\" value=\"$id_all\">";
                                                                ?>
                                                                <tr  >
                                                                    <td><?= $chk_all ?></td>
                                                                    <td><?= $row['Id'] ?></td>
                                                                    <td><?= Vehicle::getname($row['fk_stock'], "stock"); ?></td>
                                                                    <td><?= Vehicle::getname($row['fk_make'], "make"); ?></td>
                                                                    <td><?= Vehicle::getname($row['fk_model'], "model") . " - " . $row['modeltxt'] ?></td>
                                                                    <td><?= $row['chasi'] ?></td>
                                                                    <td><?= $row['yearmonth'] ?></td>
                                                                    <td><?= $row['mileage'] ?></td>
                                                                    <td>             <?
                                                                        if ($row['highestoffer'] == 1) {
                                                                            echo "HO";
                                                                        } else {
                                                                            echo CommonBase::formatMoney($row['price'], 0);
                                                                        }
                                                                        ?>
                                                                        <? if ($row['special_offer'] == 1) { ?>
                                                                            <div style="color:#F00 ; font-weight:bold"><?= CommonBase::formatMoney($row['special_offer_price'], 0) ?></div>
                                                                        <? } ?></td>
                                                                    <td><a href="<?= CommonBase::getServer() . $img['mpath'] . $img['image_name'] ?>" class="popup_img"><?= CommonBase::createImage(CommonBase::getServer() . $img['tpath'] . $img['image_name'], 50, 20) ?></a></td>

                                                                </tr>
                                                            <? }
                                                            ?>  
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th></th>
                                                                <th>#</th>
                                                                <th>Stock</th>
                                                                <th>Make</th>
                                                                <th>Model</th>
                                                                <th>Chasi</th>
                                                                <th>YM</th>
                                                                <th>KM</th>
                                                                <th>Price</th>
                                                                <th>Img</th>

                                                            </tr>
                                                        </tfoot>
                                                    </table>

                                                </div>                                                
                                            </div>
                                            <div class="row-fluid margin10" >
                                                <div class="span10 offset2">
                                                    <div class="row-fluid">
                                                        <div class="span2">
                                                            <button class="btn btn-success" type="submit" name="addselectedvehicle_all"  ><i class="icon-arrow-down icon-white"></i> Add ALL</button>
                                                        </div>
                                                        <div class="span3">
                                                            <button class="btn btn-success" type="submit" name="addselectedvehicle"  ><i class="icon-arrow-down icon-white"></i> Add to Newsletter</button>
                                                        </div>
                                                        <div class="span3">
                                                            <button class="btn btn-warning" type="submit" name="removeselectedvehicle" ><i class="icon-arrow-up icon-white"></i> Remove from Newsletter</button>
                                                        </div>
                                                         <div class="span3">
                                                            <button class="btn btn-warning" type="submit" name="removeselectedvehicle_all" ><i class="icon-arrow-up icon-white"></i> Remove ALL</button>
                                                        </div>
                                                    </div>                                                    
                                                </div>                                              
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <h4 class="info">Selected-vehicle(s)</h4>                                                    
                                                </div>                                                
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <table cellpadding="0" cellspacing="0" border="0" class=" dynamicTable_task display table table-bordered" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" id="all_selected"></th>
                                                                <th>Ref #</th>
                                                                <th>Stock</th>
                                                                <th>Make</th>
                                                                <th>Model</th>
                                                                <th>Chasi</th>
                                                                <th>YM</th>
                                                                <th>KM</th>
                                                                <th>Price</th>
                                                                <th>Img</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?
                                                            while ($row = $all_seleced->fetch(PDO::FETCH_ASSOC)) {
                                                                $img = Vehicle::getFirastimage($row['Id']);
                                                                $id_all = CommonBase::encrypt($row['Id']);
                                                                $chk_all = "<input type=\"checkbox\" name=\"che_selcted['" . $id_all . "']\" class=\" nostyle chkselected\" value=\"$id_all\">";
                                                                ?>
                                                                <tr  >
                                                                    <td><?= $chk_all ?></td>
                                                                    <td><?= $row['Id'] ?></td>
                                                                    <td><?= Vehicle::getname($row['fk_stock'], "stock"); ?></td>
                                                                    <td><?= Vehicle::getname($row['fk_make'], "make"); ?></td>
                                                                    <td><?= Vehicle::getname($row['fk_model'], "model") . " - " . $row['modeltxt'] ?></td>
                                                                    <td><?= $row['chasi'] ?></td>
                                                                    <td><?= $row['yearmonth'] ?></td>
                                                                    <td><?= $row['mileage'] ?></td>
                                                                    <td>             <?
                                                                        if ($row['highestoffer'] == 1) {
                                                                            echo "HO";
                                                                        } else {
                                                                            echo CommonBase::formatMoney($row['price'], 0);
                                                                        }
                                                                        ?>
                                                                        <? if ($row['special_offer'] == 1) { ?>
                                                                            <div style="color:#F00 ; font-weight:bold"><?= CommonBase::formatMoney($row['special_offer_price'], 0) ?></div>
                                                                        <? } ?></td>
                                                                    <td><a href="<?= CommonBase::getServer() . $img['mpath'] . $img['image_name'] ?>" class="popup_img"><?= CommonBase::createImage(CommonBase::getServer() . $img['tpath'] . $img['image_name'], 50, 20) ?></a></td>

                                                                </tr>
                                                            <? }
                                                            ?>  
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th></th>
                                                                <th>#</th>
                                                                <th>Stock</th>
                                                                <th>Make</th>
                                                                <th>Model</th>
                                                                <th>Chasi</th>
                                                                <th>YM</th>
                                                                <th>KM</th>
                                                                <th>Price</th>
                                                                <th>Img</th>

                                                            </tr>
                                                        </tfoot>
                                                    </table>

                                                </div>                                                
                                            </div>

                                        </form>
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
