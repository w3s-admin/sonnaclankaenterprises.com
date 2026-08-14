<?
require 'cpad/vehicleController.php';
?>
<!DOCTYPE  html>
<html>
    <head>
        <meta charset="utf-8">
        <title>★ Vehucles at Kaduwela Enterprises - Unregisterd vehicles in Sri Lanka, Brandnew vehicles in Sri Lanka, Hybrid vehicles in Sri Lanka, </title>

        <?php include_once("includes/head.php"); ?>  

        <style type="text/css">
            #content .gallery li .isotope-hidden{
                display: none;
            }
            .isotope-hidden{display: none;
            }
            #content .gallery li{
                

            }
        </style>
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
                    <h6 class="toggle-trigger"> <a href="#">  Search Your Vehicle - <strong style="color:#09F"> Click Here to hide </strong> <img src="img/mono-icons/search.png" alt="arrowright32" title="search" class="alignleft" width="20" height="20" style="margin-top:5px; margin-left:20px" /></a></h6>
                    <div class="myaccording" >
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


                    <p class="clear"></p>
                    <!-- ENDS title -->
                    <?
                    $returnArray = Vehicle::getAll_vehicle_search($_GET, true);
                    $svcount = Vehicle::getResultCountBySearch($returnArray['q_count'], $returnArray['v']);

                    if ($svcount > 0) {
                        ?>

                        <?
                        $cdb = new ControlPadDB();
                        $dbh = $cdb->dbh;
                        $stmt_c = $dbh->prepare($returnArray['q_count']);
                        $stmt_c->execute($returnArray['v']);
                        if ($row_c = $stmt_c->fetch(PDO::FETCH_ASSOC)) {
                            $count = $row_c['cnt'];
                        }

                        $num_rows = array('0' => intval($count));
                        $pages = new Paginator();
                        $pages->items_total = $num_rows[0];
                        $pages->mid_range = 9; // Number of pages to display. Must be odd and > 3
                        $pages->default_ipp = 10;
                        $pages->paginate();
                        //   echo $pages->display_pages();
                        //   echo "<span class=\"\">" . $pages->display_jump_menu() . $pages->display_items_per_page() . "</span>";
                        $query = $returnArray['q'] . $pages->limit;
                        $stmt_res = $dbh->prepare($query);
                        $stmt_res->execute($returnArray['v']);
                        ?>

                        <?= Vehicle::getAllCatogaryFilter($query, $returnArray['v']); ?>


                        <?
                        echo $pages->display_pages() . "<span class=\"\">" . $pages->display_items_per_page() . $pages->display_jump_menu() . "</span>";
                        ?>
                        <div align="right" style="font-size:12px; margin-top:10px; margin-bottom:15px; text-align:left ">
                            <? if ($count > 0) { ?>
                                About  <b><?= CommonBase::formatMoney($count, 0) ?></b> vehicle results found  
                            <? } ?>
                        </div>

                        <!-- Begin Portfolio Elements -->
                        <ul id="portfolio-list" class="gallery">
                            <?
                            $cnt = 1;
                            $column = 0;
                            while ($row = $stmt_res->fetch(PDO::FETCH_ASSOC)) {
                                $main_cat = CommonBase::getname($row['fk_property_type'], "property_type");
                                $img = Vehicle::getFirastimage($row['Id']);
                                ?> 

                                <li class="<?= $row['fk_type'] ?>"><a href="<?= Vehicle::createUrl($row) ?>" rel="group1" class="" title="Click To More Details"> 
                                        <div class="vnameall"><?= Vehicle::createUrl($row, true) ?></div>
                                        <img src="<?= $server . $img['mpath'] . $img['image_name'] ?>" alt="Pic" width="204" style="height:140px;"> 
                                        <div class="vnameall2" align="left"> 

                                            <? if ($row['flow'] == 1) { ?>
                                                <span class="badge badge-success" type="button" style="margin-right:10px; margin-left:5px;">Available</span>
                                            <? } else { ?>
                                                <span class="badge badge-important" type="button" style="margin-right:10px; margin-left:5px;">Sold</span>
                                            <? } ?>

                                            <?= Vehicle::getPrprice($row) ?></div> </a></li>

                                <?
                                $cnt++;
                            }
                            ?>
                        </ul>
                        <!-- Start 4 column portfolio -->

                        <!-- End 4 column portfolio -->


                        <?
                        echo $pages->display_pages();
                        echo "<p class=\"paginate\">Page: $pages->current_page of $pages->num_pages</p>\n";
                        ?>

                    <? } else { ?>
                        <div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <h4>Sorry !</h4>
                            No result found, please Search again...
                        </div>
                    <? } ?>

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