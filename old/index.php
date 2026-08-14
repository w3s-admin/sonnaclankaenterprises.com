<?
require 'cpad/vehicleController.php';
 
?>
<!DOCTYPE  html>
<html>
    <head>
        <meta charset="utf-8">
        <title> ♒ Welcome to Kaduwela Enterprises Official web Site - Unregisterd vehicles in Sri Lanka, Brandnew vehicles in Sri Lanka, Hybrid vehicles in Sri Lanka, </title>

        <?php include_once("includes/head.php"); ?>  


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
        <div id="slider-block">
            <?php include_once("includes/flash.php"); ?>  
        </div>
        <!-- ENDS Slider -->

        <!-- MAIN -->
        <div id="main">
            <!-- wrapper-main -->
            <div class="wrapper">

                <!-- headline -->
                <div class="clear"></div>

                <!-- ENDS headline -->

                <!-- content -->
                <div id="content">
                    <!-- toggle -->

                    <h6 class="toggle-trigger"> <a href="#">  Search Your Vehicle - <strong style="color:#09F"> Click Here to hide </strong> <img src="img/mono-icons/search.png" alt="arrowright32" title="search" class="alignleft" width="20" height="20" style="margin-top:5px; margin-left:20px" /></a></h6>
                  <div class="myaccording">
                        <div class="block">
                            <form id="frmOptions" method="get" class="" style="margin: 0px;"action="kaduwela_enterprises_search_vehicles.php" >
                                <div class="row-fluid">
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

                                </div> 

                                <div class="row-fluid">
                                    <div id="formCenter" class="span3">
                                        <div class="control-group">
                                            <label for="select2" class="control-label">Chassis #</label>
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
                                            <div class="controls padingT10" style="margin-top: 10px; padding-top:10px;">
                                                <button type="submit" class="btn">Search</button>
                                                <button type="button" onclick="window.open(window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1), '_self');"  class="btn btn-danger" >Reset</button>
                                            </div>      
                                        </div>    
                                    </div>
                                </div>

                            </form>
                        </div>

                      

                    </div>
                

                <p class="clear"></p>
                <!-- ENDS toggle -->
                <!-- TABS -->
                <!-- the tabs -->
                <div class="span8" style="margin-left:0px; width:740px;">
                <ul class="tabs">
                    <?
                    $carc = Vehicle::getVehicleCountByFK("fk_type", 1);
                    $vanc = Vehicle::getVehicleCountByFK("fk_type", 2);
                    $jeepc = Vehicle::getVehicleCountByFK("fk_type", 13);
                    $trucksc = Vehicle::getVehicleCountByFK("fk_type", "4,5,6");
                    $otherc = Vehicle::getVehicleCountByFK("fk_type", "3,7,8,9,10,11,12,14,15,16");
                    ?>
                    <? if ($carc > 0) { ?>
                        <li><a href="#"><span>Cars (<?= $carc ?>)</span></a></li>
                    <? } ?>
                    <? if ($vanc > 0) { ?>
                        <li><a href="#"><span>Vans (<?= $vanc ?>)</span></a></li>
                    <? } ?>  
                    <? if ($jeepc > 0) { ?>
                        <li><a href="#"><span>Jeeps (<?= $jeepc ?>)</span></a></li>
                    <? } ?>  
                    <? if ($trucksc > 0) { ?>
                        <li><a href="#"><span>Trucks (<?= $trucksc ?>)</span></a></li>
                    <? } ?>
                    <? if ($otherc > 0) { ?>
                        <li><a href="#"><span>Others (<?= $otherc ?>)</span></a></li>
                    <? } ?>

                </ul>

                <!-- tab "panes" -->
                <div class="panes">
                    <?
                    $car = Vehicle::get_filted_Vehicles("fk_type", 1, 9);
                    $van = Vehicle::get_filted_Vehicles("fk_type", 2, 9);
                    $jeep = Vehicle::get_filted_Vehicles("fk_type", 13, 9);
                    $trucks = Vehicle::get_filted_Vehicles("fk_type", "4,5,6", 9);
                    $other = Vehicle::get_filted_Vehicles("fk_type", "3,7,8,9,10,11,12,14,15,16", 9);
                    
                    ?>
                    <? if ($carc > 0) { ?>
                        <div >
                            <ul class="blocks-thumbs thumbs-rollover">
                                <?
                                while ($row = $car->fetch(PDO::FETCH_ASSOC)) {
                                    $img = Vehicle::getFirastimage($row['Id']);
                                    ?>
                                    <li>
                                        <a href="<?= Vehicle::createUrl($row) ?>" class="thumb" title="An image"><img src="<?= $server . $img['tpath'] . $img['image_name'] ?>" style="width:200px; height:100%;" alt="Post" /></a>
                                        <div class="excerpt">
                                            <a href="<?= Vehicle::createUrl($row) ?>" class="header"><?= Vehicle::createUrl($row, 1) ?></a>
                                            <div class="table">

                                                <div class="column first"><img src="img/mono-icons/arrowright32.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= Vehicle::addZeroFirft($row['Id']) ?></div>
                                                <div class="column" style="color:#E60005"><img src="img/mono-icons/price.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= Vehicle::getPrprice($row) ?></div>

                      
                                                <div class="column"><img src="img/mono-icons/gear32.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= CommonBase::getname($row['fk_transmission'], "transmission") ?></div>

                                                <div class="column first"><img src="img/mono-icons/spanner32.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= $row['eng_cap'] ?> CC</div>
                                                <div class="column"> <img src="img/mono-icons/meter.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;"/><?= $row['mileage'] ?> km</div>

                                          

                                                <div class="column" style="color:#0e9600"> <img src="img/mono-icons/available.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;"/>Available</div>

                                            </div>
                                        </div>
                                        <div style="padding-top:10px;" align="center"><a href="<?= Vehicle::createUrl($row) ?>" class="link-button" ><span><?= Vehicle::createUrl($row, 2) ?> &#8594;</span></a></div>
                                    </li>
                                <? } ?>
                            </ul>
                            <div style="padding-top:10px;" align="center"><a href="<?=$server ?>kaduwela_enterprises_search_vehicles.php?Category=lg%3D%3D&Make=&Model=&BaseColur=&chasi=&key=&id=" class="link-button2" ><span>View All Vehicles &#8594;</span></a></div>
                        </div>
                    <? } ?>
                    <? if ($vanc > 0) { ?>
                        <div>
                            <ul class="blocks-thumbs thumbs-rollover">
                                <?
                                while ($row = $van->fetch(PDO::FETCH_ASSOC)) {
                                    $img = Vehicle::getFirastimage($row['Id']);
                                    ?>
                                    <li>
                                        <a href="<?= Vehicle::createUrl($row) ?>" class="thumb" title="An image"><img src="<?= $server . $img['tpath'] . $img['image_name'] ?>" style="width:200px; height:100%;" alt="Post" /></a>
                                        <div class="excerpt">
                                            <a href="<?= Vehicle::createUrl($row) ?>" class="header"><?= Vehicle::createUrl($row, 1) ?></a>
                                            <div class="table">

                                                <div class="column first"><img src="img/mono-icons/arrowright32.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= Vehicle::addZeroFirft($row['Id']) ?></div>
                                                <div class="column" style="color:#E60005"><img src="img/mono-icons/price.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= Vehicle::getPrprice($row) ?></div>

                                            
                                                <div class="column"><img src="img/mono-icons/gear32.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= CommonBase::getname($row['fk_transmission'], "transmission") ?></div>

                                                <div class="column first"><img src="img/mono-icons/spanner32.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= $row['eng_cap'] ?> CC</div>
                                                <div class="column"> <img src="img/mono-icons/meter.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;"/><?= $row['mileage'] ?> km</div>

                                                

                                                <div class="column" style="color:#0e9600"> <img src="img/mono-icons/available.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;"/>Available</div>

                                            </div>
                                        </div>
                                        <div style="padding-top:10px;" align="center"><a href="<?= Vehicle::createUrl($row) ?>" class="link-button" ><span><?= Vehicle::createUrl($row, 2) ?> &#8594;</span></a></div>
                                    </li>
                                <? } ?>
                            </ul>
                            <div style="padding-top:10px;" align="center"><a href="<?=$server ?>kaduwela_enterprises_search_vehicles.php?Category=lw%3D%3D&Make=&Model=&BaseColur=&chasi=&key=&id=" class="link-button2" ><span>View All Vehicles &#8594;</span></a></div>
                        </div>
                    <? } ?>  
                    <? if ($jeepc > 0) { ?>
                        <div>
                            <ul class="blocks-thumbs thumbs-rollover">
                                <?
                                while ($row = $jeep->fetch(PDO::FETCH_ASSOC)) {
                                    $img = Vehicle::getFirastimage($row['Id']);
                                    ?>
                                    <li>
                                        <a href="<?= Vehicle::createUrl($row) ?>" class="thumb" title="An image"><img src="<?= $server . $img['tpath'] . $img['image_name'] ?>" style="width:200px; height:100%;" alt="Post" /></a>
                                        <div class="excerpt">
                                            <a href="<?= Vehicle::createUrl($row) ?>" class="header"><?= Vehicle::createUrl($row, 1) ?></a>
                                            <div class="table">

                                                <div class="column first"><img src="img/mono-icons/arrowright32.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= Vehicle::addZeroFirft($row['Id']) ?></div>
                                                <div class="column" style="color:#E60005"><img src="img/mono-icons/price.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= Vehicle::getPrprice($row) ?></div>

 
                                                <div class="column"><img src="img/mono-icons/gear32.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= CommonBase::getname($row['fk_transmission'], "transmission") ?></div>

                                                <div class="column first"><img src="img/mono-icons/spanner32.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= $row['eng_cap'] ?> CC</div>
                                                <div class="column"> <img src="img/mono-icons/meter.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;"/><?= $row['mileage'] ?> km</div>

      

                                                <div class="column" style="color:#0e9600"> <img src="img/mono-icons/available.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;"/>Available</div>

                                            </div>
                                        </div>
                                        <div style="padding-top:10px;" align="center"><a href="<?= Vehicle::createUrl($row) ?>" class="link-button" ><span><?= Vehicle::createUrl($row, 2) ?> &#8594;</span></a></div>
                                    </li>
                                <? } ?>
                            </ul>
                            <div style="padding-top:10px;" align="center"><a href="#" class="link-button2" ><span>View All Vehicles &#8594;</span></a></div>
                        </div>
                    <? } ?>  
                    <? if ($trucksc > 0) { ?>
                        <div>
                            <ul class="blocks-thumbs thumbs-rollover">
                                <?
                                while ($row = $trucks->fetch(PDO::FETCH_ASSOC)) {
                                    $img = Vehicle::getFirastimage($row['Id']);
                                    ?>
                                    <li>
                                        <a href="<?= Vehicle::createUrl($row) ?>" class="thumb" title="An image"><img src="<?= $server . $img['tpath'] . $img['image_name'] ?>" alt="Post" /></a>
                                        <div class="excerpt">
                                            <a href="<?= Vehicle::createUrl($row) ?>" class="header"><?= Vehicle::createUrl($row, 1) ?></a>
                                            <div class="table">

                                                <div class="column first"><img src="img/mono-icons/arrowright32.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= Vehicle::addZeroFirft($row['Id']) ?></div>
                                                <div class="column" style="color:#E60005"><img src="img/mono-icons/price.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= Vehicle::getPrprice($row) ?></div>

                                                
                                                <div class="column"><img src="img/mono-icons/gear32.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= CommonBase::getname($row['fk_transmission'], "transmission") ?></div>

                                                <div class="column first"><img src="img/mono-icons/spanner32.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= $row['eng_cap'] ?> CC</div>
                                                <div class="column"> <img src="img/mono-icons/meter.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;"/><?= $row['mileage'] ?> km</div>

 

                                                <div class="column" style="color:#0e9600"> <img src="img/mono-icons/available.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;"/>Available</div>

                                            </div>
                                        </div>
                                        <div style="padding-top:10px;" align="center"><a href="<?= Vehicle::createUrl($row) ?>" class="link-button" ><span><?= Vehicle::createUrl($row, 2) ?> &#8594;</span></a></div>
                                    </li>
                                <? } ?>
                            </ul>
                            <div style="padding-top:10px;" align="center"><a href="<?=$server ?>kaduwela_enterprises_search_vehicles.php?Category=mQ%3D%3D&Make=&Model=&BaseColur=&chasi=&key=&id=" class="link-button2" ><span>View All Vehicles &#8594;</span></a></div>
                        </div>
                    <? } ?>
                    <? if ($otherc > 0) { ?>
                        <div>
                            <ul class="blocks-thumbs thumbs-rollover">
                                <?
                                while ($row = $other->fetch(PDO::FETCH_ASSOC)) {
                                    $img = Vehicle::getFirastimage($row['Id']);
                                    ?>
                                    <li>
                                        <a href="<?= Vehicle::createUrl($row) ?>" class="thumb" title="An image"><img src="<?= $server . $img['tpath'] . $img['image_name'] ?>" alt="Post" /></a>
                                        <div class="excerpt">
                                            <a href="<?= Vehicle::createUrl($row) ?>" class="header"><?= Vehicle::createUrl($row, 1) ?></a>
                                            <div class="table">

                                                <div class="column first"><img src="img/mono-icons/arrowright32.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= Vehicle::addZeroFirft($row['Id']) ?></div>
                                                <div class="column" style="color:#E60005"><img src="img/mono-icons/price.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= Vehicle::getPrprice($row) ?></div>

 
                                                <div class="column"><img src="img/mono-icons/gear32.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= CommonBase::getname($row['fk_transmission'], "transmission") ?></div>

                                                <div class="column first"><img src="img/mono-icons/spanner32.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;" /><?= $row['eng_cap'] ?> CC</div>
                                                <div class="column"> <img src="img/mono-icons/meter.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;"/><?= $row['mileage'] ?> km</div>

 

                                                <div class="column" style="color:#0e9600"> <img src="img/mono-icons/available.png" alt="arrowright32" title="arrowright32.png" class="alignleft" width="12" height="12" style="width:12px;"/>Available</div>

                                            </div>
                                        </div>
                                        <div style="padding-top:10px;" align="center"><a href="<?= Vehicle::createUrl($row) ?>" class="link-button" ><span><?= Vehicle::createUrl($row, 2) ?> &#8594;</span></a></div>
                                    </li>
                                <? } ?>
                            </ul>
                            <div style="padding-top:10px;" align="center"><a href="<?=$server ?>kaduwela_enterprises_search_vehicles.php" class="link-button2" ><span>View All Vehicles &#8594;</span></a></div>
                        </div>
                    <? } ?>
                    <!-- Posts -->

                    <!-- ENDS posts -->

                    <!-- Information  -->

                    <!-- ENDS Information -->

                    <!-- Posts -->

                    <!-- ENDS posts -->




                </div>
                
                </div>
                  <?php include_once("includes/right_bar.php"); ?>  
                
                <div class="clear"></div>

                <!-- ENDS TABS -->
                <div id="page-title" align="center" style="height:30px">


                </div>

                <div class="one-third">
                    <img src="img/saleimg.png" width="284" height="229" alt="Kaduwela sale">
                </div>
                <div class="two-third last">
                    <h6 class="line-divider">Welcome to kaduwela Enterprises</h6>
                    <p style="font-size:13px; text-align:justify">In the year 2003 we stepped among the common car sales in Sri Lanka to revise the concept of the very same. Securing the core essence of car sales in Sri Lanka we go beyond that trend by adding that personal touch that the customer seek from a service provider.
                        <br><br>

                        Secured with an arsenal full of finest quality Japanese used cars that open doors for a world of fantastic automotive experiences we have now evolved from the general concept of car sales in Sri Lanka to the arena of Japanese used car auction, giving automotive lovers to experience the taste of victory of bidding and winning the vehicle that you desire.</p>
                </div>

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