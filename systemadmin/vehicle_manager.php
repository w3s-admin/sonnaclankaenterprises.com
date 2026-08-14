<?
 
require_once '../cpad/propertyController.php';
require_once '../cpad/vehicleController.php';
CommonBase::IsAdminUser();
//   unset($_SESSION['app_pro']);
// var_dump($_SESSION['app_pro']['main_company_name']);exit;

$Stock = $Stock ?? null;
$Category = $Category ?? null;
$BodyType = $BodyType ?? null;
$BaseColur = $BaseColur ?? null;
$Make = $Make ?? null;
$Model = $Model ?? null;
$Transmission = $Transmission ?? null;
$FuelType = $FuelType ?? null;
$chasi = $chasi ?? null;
$key = $key ?? null;
$id = $id ?? null;

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
        <script type="text/javascript">
            $(function() {
                if ($('table').hasClass('dynamicTable_task')) {
                    $('.dynamicTable_task').dataTable({"sPaginationType": "full_numbers"
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


            });</script>

        <?= (isset($del_msg)) ? CommonBase::decrypt($del_msg) : "" ?>
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

                        <h3>Vehicle Manager</h3>

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
                            <li class="active">Vehicle Manager</li>
                        </ul>

                    </div><!-- End .heading-->

                    <!-- Build page from here: -->
                    <div class="row-fluid">

                        <div class="span12">

                            <div class="box">

                                <div class="title">

                                    <h4>
                                        <span class="icon16 icomoon-icon-equalizer-2"></span>
                                        <span>Filter Vehicles</span>
                                    </h4>
                                    <a class="minimize" href="#" style="display: none;">Minimize</a>
                                </div>
                                <div class="content">

                                    <div class="row-fluid">
                                        <form id="frmOptions" method="get" class=" form-inline span12" style="margin: 0px;">
                                            <div class="row-fluid">
                                                <div id="formLeft" class="span3">
                                                    <div class="control-group">
                                                        <label for="select1" class="control-label ">Stock</label>
                                                        <div class="controls">
                                                            <?= Vehicle::createSelectSearch($Stock, "Stock", $type = 0, "required nostyle", "Please select Stock", "select Id , name from stock WHERE status = 1 ORDER by Id asc") ?>

                                                        </div>      
                                                    </div>
                                                </div>

                                                <div id="formCenter" class="span3">
                                                    <div class="control-group">
                                                        <label for="select2" class="control-label">Category</label>
                                                        <div class="controls ">
                                                            <?= Vehicle::createSelectSearch($Category, "Category", $type = 1, "required nostyle", "Please select Category") ?>
                                                        </div>      
                                                    </div>    
                                                </div>

                                                <div id="formCenter" class="span3">
                                                    <div class="control-group">
                                                        <label for="select2" class="control-label">Body Type </label>
                                                        <div class="controls">
                                                            <?= Vehicle::createSelectSearch($BodyType, "BodyType", $type = 0, "required nostyle", "Please select Body Type", "select Id , name from body_type WHERE status = 1 ORDER by Id asc") ?>
                                                        </div>      
                                                    </div>    
                                                </div>

                                                <div id="formCenter" class="span3 ">
                                                    <div class="control-group">
                                                        <label for="select2" class="control-label">Color</label>
                                                        <div class="controls">
                                                            <?= Vehicle::createSelectSearch($BaseColur, "BaseColur", $type = 0, "required nostyle", "Please select Base Colur ", "select Id , name from colour WHERE status = 1 ORDER by Id asc") ?>
                                                        </div>      
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="row-fluid">
                                                <div id="formCenter" class="span3">
                                                    <div class="control-group">
                                                        <label for="select2" class="control-label">Make</label>
                                                        <div class="controls">
                                                            <?= Vehicle::createSelectSearch($Make, "Make", $type = 0, "required nostyle", "Please select Make", "select Id , name from make WHERE status = 1 ORDER by Id asc") ?>
                                                        </div>      
                                                    </div>    
                                                </div>

                                                <div id="formCenter" class="span3 ">
                                                    <div class="control-group">
                                                        <label for="select2" class="control-label">Model</label>
                                                        <div class="controls">
                                                            <select id="Model"  name="Model" class="required nostyle" title="Please Select Model<br/>">
                                                                <option value="" class="any">Any</option>   
                                                            </select>
                                                        </div>      
                                                    </div>
                                                </div>

                                                <div id="formLeft" class="span3">
                                                    <div class="control-group">
                                                        <label for="select1" class="control-label">Color</label>
                                                        <div class="controls">
                                                            <?= Vehicle::createSelectSearch($BaseColur, "BaseColur", $type = 0, "required nostyle", "Please select Base Colur ", "select Id , name from colour WHERE status = 1 ORDER by Id asc") ?>

                                                        </div>      
                                                    </div>
                                                </div>

                                                <div id="formCenter" class="span3">
                                                    <div class="control-group">
                                                        <label for="select2" class="control-label">Transmission</label>
                                                        <div class="controls ">
                                                            <?= Vehicle::createSelectSearch($Transmission, "Transmission", $type = 0, "required nostyle", "Please select Transmission", "select Id , name from transmission WHERE status = 1 ORDER by Id asc") ?>
                                                        </div>      
                                                    </div>    
                                                </div>


                                            </div> 
                                            <div class="row-fluid">
                                                <div id="formCenter" class="span3">
                                                    <div class="control-group">
                                                        <label for="select2" class="control-label">Chasi</label>
                                                        <div class="controls ">
                                                            <input type="text" name="chasi" id="key2"   value="<?= $chasi ?>"  class="txtbox"  />
                                                        </div>      
                                                    </div>    
                                                </div>
                                                <div id="formCenter" class="span3">
                                                    <div class="control-group">
                                                        <label for="select2" class="control-label">Search Keywords</label>
                                                        <div class="controls ">
                                                            <input type="text" name="key" id="key"   value="<?= $key ?>" />
                                                        </div>      
                                                    </div>    
                                                </div>
                                                <div id="formCenter" class="span3">
                                                    <div class="control-group">
                                                        <label for="select2" class="control-label">Search ID# (Ref)</label>
                                                        <div class="controls ">
                                                            <input type="text" name="id" id="id"   value="<?= $id ?>" />
                                                        </div>      
                                                    </div>    
                                                </div>

                                                <div id="formCenter" class="span3 ">
                                                    <div class="control-group">
                                                        <label for="select2" class="control-label"></label>
                                                        <div class="controls padingT10" style="margin-top: 10px;">
                                                            <button type="submit" class="btn">Search</button>
                                                            <button type="button" onclick="window.open(window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1), '_self');"  class="btn btn-danger" >Reset</button>
                                                        </div>      
                                                    </div>    
                                                </div>
                                            </div>

                                        </form>
                                    </div>



                                </div>

                            </div><!-- End .box -->

                        </div><!-- End .span12 -->

                    </div>

                    <div class="row-fluid">

                        <div class="span12">

                            <div class="box gradient">
                                <div class="title">
                                    <h4>
                                        <span>User List</span>
                                    </h4>

                                </div>


                                <div class="content noPad clearfix">


                                    <table cellpadding="0" cellspacing="0" border="0" class="responsive dynamicTable_task display table table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Ref #</th>
                                                <th>Stock</th>
                                                <th>Make</th>
                                                <th>Model</th>
                                                <th>Chasi</th>
                                                <th>YM</th>
                                                <th>KM</th>
                                                <th>Price</th>
                                                <th>Img</th>
                                                <th>Sold</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?
                                            $task_list = Vehicle::getAll_vehicle_search($_GET);

                                            while ($row = $task_list->fetch(PDO::FETCH_ASSOC)) {
                                                $img = Vehicle::getFirastimage($row['Id']);
                                                ?>
                                                <tr  >
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
                                                    <td class="" style="padding: 0"> <a style="float: right;margin: 5px; margin-bottom: 0px; z-index: 999" title="<?= ($row['flow'] == 2) ? CommonBase::getname($row['fk_price_type'], "price_type") . ' ' . CommonBase::formatMoney($row['selling_price'], 0) : "" ?>" class="btn  <?= ($row['flow'] == 1) ? "btn-warning" : "btn-danger tip" ?> btn-small popup" href="vehicle_sell.php?vid=<?= CommonBase::encrypt($row['Id']) ?>">
                                                            <?= ($row['flow'] == 1) ? "sold" : "unsold" ?></a></td>
                                                    <td style="padding: 0"> <a style="float: right;margin: 5px; margin-bottom: 0px; z-index: 999" class="btn btn-success btn-small popup" href="vehicle_edit.php?vid=<?= CommonBase::encrypt($row['Id']) ?>">
                                                            View &amp; Edit</a></td>
                                                    <td style="padding: 0">
                                                        <form method="POST" action="" style="margin: 0px; margin-top: 5px;"  class="delfrm" id="delfrm<?= $row['Id'] ?>">
                                                            <input type="hidden" value="<?= CommonBase::encrypt($row['Id']) ?>" name="row_id" />
                                                            <button class="btn btn-danger btn-small" type="submit" name="del_adv"   >Delete</button>
                                                        </form>

                                                    </td>
                                                </tr>
                                            <? }
                                            ?>  
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Stock</th>
                                                <th>Make</th>
                                                <th>Model</th>
                                                <th>Chasi</th>
                                                <th>YM</th>
                                                <th>KM</th>
                                                <th>Price</th>
                                                <th>Img</th>
                                                <th>Sold</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div><!-- End .box -->

                        </div><!-- End .span12 -->

                    </div><!-- End .row-fluid -->

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
