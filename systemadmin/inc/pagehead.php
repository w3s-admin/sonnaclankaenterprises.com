<?
if (!class_exists("CommonBase")) {
    require '../cpad/clsCommonBase.php';
}
//$_SESSION['app_pro'] = null;
?>
<div id="header">

    <div class="navbar">
        <div class="navbar-inner">
            <div class="container-fluid"> 
                <a class="brand" href="<?= $_SESSION['app_pro']['sys_url'] ?>"><?= CommonBase::createImage($_SESSION['app_pro']['server'] . $_SESSION['app_pro']['main_admin_logo_name'], 114, 50,"logoimg") ?><span class="hidden-phone hidden-tablet">&nbsp;<?= $_SESSION['app_pro']['main_company_name'] ?></span><span class="slogan" style="padding-left: 4px;"><?= $_SESSION['app_pro']['sys_name'] ?></span></a>
                <div class="nav-no-collapse">
                    <ul class="nav">
                        <li><a href="dashboard.php"><span class="icon16 icomoon-icon-screen-2"></span> Dashboard</a></li>
                    </ul>
                    <ul class="nav pull-right usernav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle avatar" data-toggle="dropdown">
                                <img src="https://ui-avatars.com/api/?name=SA&background=ba234a&color=fff" alt="" class="image" /> 
                                <span class="txt"><?=  CommonBase::IsAdminUser()['name'] ?></span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="menu">
                                    <ul>
                                        <li style="width: 250px;">
                                            <span class="icon16 icomoon-icon-alarm"></span> 
                                            <?=  CommonBase::IsAdminUser()['lastlogin'] ?>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="<?=$_SESSION['app_pro']['server'].$_SESSION['app_pro']['admin_path'] ?>admin_logout.php"><span class="icon16 icomoon-icon-exit"></span> Logout</a></li>
                    </ul>
                </div><!-- /.nav-collapse -->
            </div>
        </div><!-- /navbar-inner -->
    </div><!-- /navbar --> 

</div><!-- End #header -->