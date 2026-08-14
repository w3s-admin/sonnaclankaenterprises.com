<!--Sidebar collapse button-->  
<div class="collapseBtn leftbar">
    <a href="#" class="tipR" title="Hide sidebar"><span class="icon12 minia-icon-layout"></span></a>
</div>

<!--Sidebar background-->
<div id="sidebarbg"></div>
<!--Sidebar content-->
<div id="sidebar">

    <div class="shortcuts">
        <ul>
            <li><a href="#" title="" class="tip2"><span class="icon24 icomoon-icon-support"></span></a></li>
            <li><a href="#" title="" class="tip3"><span class="icon24 icomoon-icon-database"></span></a></li>
            <li><a href="#" title="" class="tip4"><span class="icon24 icomoon-icon-pie-2"></span></a></li>
            <li><a href="#" title="" class="tip5"><span class="icon24 icomoon-icon-pencil"></span></a></li>
        </ul>
    </div><!-- End search -->            

    <div class="sidenav">
        
        <div class="sidebar-widget"  style="margin: -1px 0 0 0;">
            <h5 class="title" style="margin-bottom:0">User</h5>
        </div><!-- End .sidenav-widget -->
        <div class="mainnav">
            <ul>
                <li><a href="user_add.php"><span class="icon16 icomoon-icon-stats-up"></span>Add User</a></li>
                <li><a href="user_manager.php"><span class="icon16 icomoon-icon-stats-up"></span>User Manager</a></li>
            </ul>
        </div>

        <div class="sidebar-widget" style="margin: -1px 0 0 0;">
            <h5 class="title" style="margin-bottom:0">Vehicle</h5>
        </div><!-- End .sidenav-widget -->

        <div class="mainnav">
            <ul>
                <li><a href="vehicle_add.php"><span class="icon16 icomoon-icon-stats-up"></span>Add Vehicle</a></li>
                <li><a href="vehicle_manager.php"><span class="icon16 icomoon-icon-stats-up"></span>Vehicle Manager</a></li>
                <li><a href="vehicle_unsoldlist.php" class="popup" ><span class="icon16 icomoon-icon-stats-up"></span>Unslod List</a></li>
            </ul>
        </div>

        <div class="sidebar-widget"  style="margin: -1px 0 0 0;">
            <h5 class="title" style="margin-bottom:0">Review</h5>
        </div><!-- End .sidenav-widget -->
        <div class="mainnav">
            <ul>
                <li><a href="review_add.php"><span class="icon16 icomoon-icon-stats-up"></span>Add Review</a></li>
                <li><a href="review_manager.php"><span class="icon16 icomoon-icon-stats-up"></span>Review Manager</a></li>
            </ul>
        </div>
        
    </div><!-- End sidenav -->

    <div class="sidebar-widget">
        <h5 class="title">Powerd By</h5>
        <div class="content">
            <div class="rightnow">
                <ul class="unstyled " style="margin-bottom: -20px;">
                    <li><?= CommonBase::createImage($_SESSION['app_pro']['server'] . $_SESSION['app_pro']['powered_logo'], 114, 50, "powered_logo") ?></li>
                    <li><a href="<?= $_SESSION['app_pro']['powered_url'] ?>"><?= $_SESSION['app_pro']['powered_name'] ?></a></li>
                </ul>
            </div>
        </div>

    </div>



</div><!-- End #sidebar -->