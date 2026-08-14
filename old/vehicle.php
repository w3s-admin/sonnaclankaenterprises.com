<?
require_once 'cpad/vehicleController.php';



if (isset($_GET['vid'])) {

    $id = CommonBase::decrypt($_GET['vid']);

    if (is_numeric($id)) {

        $cid = $id;
    } else {

        echo CommonBase::closeWindow();
    }
}


$row = Vehicle::getvehicleByID($cid);
$server = CommonBase::getServer();
$img = Vehicle::getFirastimage($row['Id']);
$other_images = Vehicle::getAllimages($row['Id']);
?>
<!DOCTYPE  html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Kaduwela Enterprises <?= trim(explode("-", $row['yearmonth'])[0]) ?> <?= Vehicle::getname($row['fk_make'], "make"); ?> <?= Vehicle::getname($row['fk_model'], "model") ?></title>


        <?php include_once("includes/head.php"); ?>  
        <link href="plugins/gallery/fancybox/jquery.fancybox.css" type="text/css" />
        <script src="plugins/gallery/fancybox/jquery.fancybox.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(function() {
                $(".popup").fancybox({
                    'width': '40%',
                    'height': '60%',
                    'autoScale': 'false',
                    'transitionIn': 'none',
                    'transitionOut': 'none',
                    'type': 'iframe'
                });
                
                
            })
        </script>

    </head>

    <body class="home">

        <!-- HEADER -->
        <div id="header">
            <!-- wrapper-header -->
            <?php include_once("includes/logo.php"); ?>  
            <!-- ENDS wrapper-header -->					
        </div>
        <!-- ENDS HEADER -->


        <!-- Menu -->
        <div id="menu">



            <!-- ENDS menu-holder -->
            <div id="menu-holder">
                <!-- wrapper-menu -->
                <?php include_once("includes/topnavi.php"); ?>  
                <!-- wrapper-menu -->
            </div>
            <!-- ENDS menu-holder -->
        </div>
        <!-- ENDS Menu -->




        <!-- Slider -->
        <div style="padding-top:5px;">

        </div>
        <!-- ENDS Slider -->

        <!-- MAIN -->
        <div id="main">
            <!-- wrapper-main -->
            <div class="wrapper">

                <!-- content -->
                <div id="content">

                    <!-- title -->

                    <!-- ENDS title -->

                    <!-- Posts -->
                    <div id="posts">

                        <!-- post -->
                        <div class="post">
                            <img src="img/caricon.png" width="40" height="40" alt="car icon"  style="float:left"><h1><a href="single.html"><?= Vehicle::createUrl($row, 1) ?></a></h1>
                            <div class="n-comments"><?= Vehicle::getPrprice($row) ?></div>

                            <!-- shadow -->


                            <!-- post-thumb -->
                            <ul id="portfolio-list" class="gallery onecol">
                                <li class="thumbgal"><a href="<?= $server . $img['mpath'] . $img['image_name'] ?>" rel="group1" class="fancybox" title="<?= Vehicle::createUrl($row, 1) ?>"><img src="<?= $server . $img['mpath'] . $img['image_name'] ?>" style="width:566px" alt="Pic" ></a></li>

                            </ul>
                            <ul id="portfolio-list" class="gallery onecol"  style="float:none">
                                <?
                                $c = 0;
                                array_shift($other_images);
                                foreach ($other_images as $img) {
                                    ?>
                                    <li class="thumbgal"><a href="<?= $server . $img['mpath'] . $img['image_name'] ?>" rel="group1" class="fancybox" title="<?= Vehicle::createUrl($row, 1) ?>"><img src="<?= $server . $img['tpath'] . $img['image_name'] ?>" style="width:131px" alt="Pic" ></a></li>

                                    <?
                                    $c++;
                                }
                                ?>



                            </ul>    




                            <!-- ENDS post-thumb -->

                            <div class="the-excerpt" style="font-size:12px; padding-top:10px;">
                                <p>  <?= $row['other_op'] ?>  </p>

                            </div>		
                            <br/>
                            <a href="#" class="btn btn-inverse" onclick="history.go(-1);
                        return false;"><span> &laquo; &nbsp; Go Back</span></a>	


                            <!-- ENDS shadow -->
                        </div>
                        <!-- ENDS post -->

                        <!-- post -->

                        <!-- ENDS post -->

                    </div>
                    <!-- ENDS Posts -->	


                    <!-- sidebar -->
                    <ul id="sidebar">
                        <!-- init sidebar -->
                        <div>
                            <a href="<?= $server ?>email_to_friend.php?vid=<?=$_GET['vid']?>" class="btn btn-primary btn-block text-info popup" style="margin-bottom: 5px; color: white"><i class="icon-envelope icon-white"></i> Email to Friend</a>
                        </div>
                        <li>
                            <h6 style="background-color:#333; font-size:15px; color:#FFF; font-weight:bold; padding-bottom:5px; padding-top:5px; padding-left:10px;"> <img src="img/mono-icons/details.png" alt="" title=""  style="width:18px; vertical-align:top; padding-right:10px; " />Vehicle Details</h6>	
                            <ul>
                                <li class="cat-item"><a href="#"><img src="img/mono-icons/arrowright32.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />Referance No : <span class="colourdetails"><?= Vehicle::addZeroFirft($row['Id']) ?></span></a></li>
                                <li class="cat-item"><a href="#"><img src="img/mono-icons/lightbulb32.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />Make : <span class="colourdetails"><?= Vehicle::getname($row['fk_make'], "make"); ?></span> </a></li>
                                <li class="cat-item"><a href="#"><img src="img/mono-icons/glitter32.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />Model : <span class="colourdetails"><?= Vehicle::getname($row['fk_model'], "model") . " - " . $row['modeltxt'] ?></span></a></li>
                                <li class="cat-item"><a href="#"><img src="img/mono-icons/box32.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />Type : <span class="colourdetails"><?= CommonBase::getname($row['fk_category'], "category") ?></span></a></li>
                                <li class="cat-item"><a href="#"><img src="img/mono-icons/article32.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />Year & Month : <span class="colourdetails"><?= $row['yearmonth'] ?></span></a></li>
                                <li class="cat-item"><a href="#"><img src="img/mono-icons/gear32.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />Transmision : <span class="colourdetails"><?= Vehicle::getname($row['fk_transmission'], "transmission"); ?></span></a></li>
                                <li class="cat-item"><a href="#"><img src="img/mono-icons/fuel.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />Fuel : <span class="colourdetails"><?= Vehicle::getname($row['fk_fuel'], "fuel"); ?></span></a></li>
                                <li class="cat-item"><a href="#"><img src="img/mono-icons/car.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />Body Type : <span class="colourdetails"> <?= Vehicle::getname($row['fk_body_type'], "body_type"); ?></span></a></li>
                                <li class="cat-item"><a href="#"><img src="img/mono-icons/engine.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />Engine : <span class="colourdetails"><?= $row['eng_cap'] ?>CC</span></a></li>
                                <li class="cat-item"><a href="#"><img src="img/mono-icons/wand32.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />Colour : <span class="colourdetails"><?= Vehicle::getname($row['fk_color'], "colour"); ?></span></a></li>
                                <li class="cat-item"><a href="#"><img src="img/mono-icons/meter.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />Mileage : <span class="colourdetails"><?= $row['mileage'] ?>KM</span></a></li>

                            </ul>
                        </li>	

                        <li>
                            <h6 style="background-color:#333; font-size:15px; color:#FFF; font-weight:bold; padding-bottom:5px; padding-top:5px; padding-left:10px;"> <img src="img/mono-icons/w-options.png" alt="" title=""  style="width:18px; vertical-align:top; padding-right:10px; " />Vehicle Options</h6>		
                            <ul>
                                <? if ($row['rearwiper'] == 1) { ?>
                                    <li class="cat-item"><a href="#"><img src="img/mono-icons/available.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />
                                            Rear Wiper </a></li>
                                <? } ?>
                                <? if ($row['ac'] == 1) { ?>
                                    <li class="cat-item"><a href="#"><img src="img/mono-icons/available.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />
                                            AC</a></li>


                                <? } ?>
                                <? if ($row['pm'] == 1) { ?>
                                    <li class="cat-item"><a href="#"><img src="img/mono-icons/available.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />
                                            Power Mirror</a></li>


                                <? } ?>
                                <? if ($row['tv'] == 1) { ?>
                                    <li class="cat-item"><a href="#"><img src="img/mono-icons/available.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />
                                            TV</a></li>


                                <? } ?>
                                <? if ($row['ps'] == 1) { ?>
                                    <li class="cat-item"><a href="#"><img src="img/mono-icons/available.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />
                                            Power Steering</a></li>


                                <? } ?>
                                <? if ($row['abs'] == 1) { ?>
                                    <li class="cat-item"><a href="#"><img src="img/mono-icons/available.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />
                                            ABS</a></li>


                                <? } ?>
                                <? if ($row['cd'] == 1) { ?>
                                    <li class="cat-item"><a href="#"><img src="img/mono-icons/available.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />
                                            CD</a></li>


                                <? } ?>
                                <? if ($row['pw'] == 1) { ?>
                                    <li class="cat-item"><a href="#"><img src="img/mono-icons/available.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />
                                            Power Mirror</a></li>


                                <? } ?>
                                <? if ($row['dvd'] == 1) { ?>
                                    <li class="cat-item"><a href="#"><img src="img/mono-icons/available.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />
                                            DVD</a></li>


                                <? } ?>
                                <? if ($row['aw'] == 1) { ?>
                                    <li class="cat-item"><a href="#"><img src="img/mono-icons/available.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />
                                            Alloy Wheels</a></li>


                                <? } ?>
                                <? if ($row['r_camera'] == 1) { ?>
                                    <li class="cat-item"><a href="#"><img src="img/mono-icons/available.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />
                                            Reverse Camera</a></li>


                                <? } ?>
                                <? if ($row['winkermirror'] == 1) { ?>
                                    <li class="cat-item"><a href="#"><img src="img/mono-icons/available.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />
                                            Winker Mirror</a></li>


                                <? } ?>
                                <? if ($row['skey'] == 1) { ?>
                                    <li class="cat-item"><a href="#"><img src="img/mono-icons/available.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />
                                            Smart Key</a></li>


                                <? } ?>
                                <? if ($row['airbag'] == 1) { ?>
                                    <li class="cat-item"><a href="#"><img src="img/mono-icons/available.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />
                                            Air Bag</a></li>


                                <? } ?>
                                <? if ($row['foglamp'] == 1) { ?>
                                    <li class="cat-item"><a href="#"><img src="img/mono-icons/available.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />
                                            Foglamp</a></li>


                                <? } ?>
                                <? if ($row['leather'] == 1) { ?>
                                    <li class="cat-item"><a href="#"><img src="img/mono-icons/available.png" alt="" title="" class="alignleft" style="width:15px; vertical-align:middle; padding-top:3px;" />
                                            Leather Seats</a></li>


                                <? } ?>

                            </ul>
                        </li>
                        <!-- ENDS init sidebar -->
                    </ul>
                    <!-- ENDS sidebar -->

                    <!-- pagination -->	
                    <div class="clear"></div>

                    <!-- ENDS pagination -->

                </div>
                <!-- ENDS content -->

            </div>
            <!-- ENDS wrapper-main -->
        </div>
        <!-- ENDS MAIN -->

        <!-- Twitter -->
        <div id="twitter">
            <?php include_once("includes/brandlogos.php"); ?>  
        </div>
        <!-- ENDS Twitter -->


        <!-- FOOTER -->
        <div id="footer">
            <!-- wrapper-footer -->
            <div class="wrapper">
                <!-- footer-cols -->
                <?php include_once("includes/footer.php"); ?>  
                <!-- ENDS footer-cols -->
            </div>
            <!-- ENDS wrapper-footer -->
        </div>
        <!-- ENDS FOOTER -->


        <!-- Bottom -->
        <div id="bottom">
            <!-- wrapper-bottom -->
            <?php include_once("includes/w3s_solutions.php"); ?> 
            <!-- ENDS wrapper-bottom -->
        </div>
        <!-- ENDS Bottom -->

    </body>
</html>