<?
if (!class_exists("CommonBase")) {
    require '../cpad/clsCommonBase.php';
}
$__adminUser = CommonBase::IsAdminUser();
$__initials = 'A';
if (!empty($__adminUser['name'])) {
    $__parts = preg_split('/\s+/', trim($__adminUser['name']));
    $__initials = strtoupper(substr($__parts[0], 0, 1) . (isset($__parts[1]) ? substr($__parts[1], 0, 1) : ''));
}
?>
<div id="header" class="admin-topbar">

    <div class="navbar">
        <div class="navbar-inner">
            <div class="container-fluid admin-topbar-inner">
                <a class="brand admin-topbar-brand" href="dashboard.php">
                    <?= CommonBase::createImage($_SESSION['app_pro']['server'] . $_SESSION['app_pro']['main_admin_logo_name'], 58, 58, "logoimg") ?>
                    <span class="admin-topbar-brandtext">
                        <span class="admin-topbar-company"><?= $_SESSION['app_pro']['main_company_name'] ?></span>
                        <span class="admin-topbar-slogan"><?= $_SESSION['app_pro']['sys_name'] ?></span>
                    </span>
                </a>
                <div class="nav-no-collapse admin-topbar-right">
                    <ul class="nav pull-right usernav admin-user-menu">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle avatar admin-user-toggle" data-toggle="dropdown">
                                <span class="admin-avatar"><?= htmlspecialchars($__initials) ?></span>
                                <span class="txt admin-user-name"><?= htmlspecialchars($__adminUser['name']) ?></span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu admin-user-dropdown">
                                <li class="menu">
                                    <ul>
                                        <li class="admin-user-lastlogin">
                                            <span class="icon16 icomoon-icon-alarm"></span>
                                            Last login: <?= $__adminUser['lastlogin'] ?>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?= $_SESSION['app_pro']['server'] . $_SESSION['app_pro']['admin_path'] ?>admin_logout.php" class="admin-logout-link">
                                <span class="icon16 icomoon-icon-exit"></span> Logout
                            </a>
                        </li>
                    </ul>
                </div><!-- /.nav-collapse -->
            </div>
        </div><!-- /navbar-inner -->
    </div><!-- /navbar -->

</div><!-- End #header -->
