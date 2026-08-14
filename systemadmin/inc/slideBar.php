<?php
$__navGroups = array(
    array(
        'title' => 'Overview',
        'icon'  => 'icomoon-icon-dashboard-2',
        'items' => array(
            array('dashboard.php', 'icomoon-icon-dashboard-2', 'Dashboard'),
        ),
    ),
    array(
        'title' => 'Vehicles',
        'icon'  => 'icomoon-icon-cars',
        'items' => array(
            array('vehicle_add.php', 'icomoon-icon-plus-2', 'Add Vehicle'),
            array('vehicle_manager.php', 'icomoon-icon-list-view', 'Vehicle Manager'),
            array('vehicle_unsoldlist.php', 'icomoon-icon-box', 'Unsold List'),
        ),
    ),
    array(
        'title' => 'Vehicle Attributes',
        'icon'  => 'icomoon-icon-cogs',
        'items' => array(
            array('stock_manager.php', 'icomoon-icon-box-add', 'Stock'),
            array('make_manager.php', 'icomoon-icon-cars', 'Make'),
            array('model_manager.php', 'icomoon-icon-list-view', 'Model'),
            array('colour_manager.php', 'icomoon-icon-color-palette', 'Colour'),
            array('bodytype_manager.php', 'icomoon-icon-box', 'Body Type'),
            array('transmission_manager.php', 'icomoon-icon-cog', 'Transmission'),
            array('fueltype_manager.php', 'icomoon-icon-droplet', 'Fuel Type'),
            array('enginecapacity_manager.php', 'icomoon-icon-dashboard', 'Engine Capacity'),
        ),
    ),
    array(
        'title' => 'Reviews',
        'icon'  => 'icomoon-icon-comments',
        'items' => array(
            array('review_add.php', 'icomoon-icon-plus-2', 'Add Review'),
            array('review_manager.php', 'icomoon-icon-list-view', 'Review Manager'),
        ),
    ),
    array(
        'title' => 'Staff',
        'icon'  => 'icomoon-icon-people',
        'items' => array(
            array('user_add.php', 'icomoon-icon-plus-2', 'Add User'),
            array('user_manager.php', 'icomoon-icon-list-view', 'User Manager'),
        ),
    ),
);
$__currentPage = basename($_SERVER['PHP_SELF']);
?>
<!--Sidebar background-->
<div id="sidebarbg"></div>
<!--Sidebar content-->
<div id="sidebar">

    <div class="sidenav admin-nav">
        <?php foreach ($__navGroups as $group): ?>
        <div class="admin-nav-section">
            <div class="admin-nav-section-title">
                <span class="icon14 <?= $group['icon'] ?>"></span>
                <span><?= htmlspecialchars($group['title']) ?></span>
            </div>
            <ul class="admin-nav-list">
                <?php foreach ($group['items'] as $item):
                    list($href, $icon, $label) = $item;
                    $extraClass = isset($item[3]) ? ' ' . $item[3] : '';
                    $isActive = ($__currentPage === $href);
                ?>
                <li>
                    <a href="<?= $href ?>" class="admin-nav-link<?= $extraClass ?><?= $isActive ? ' is-active' : '' ?>">
                        <span class="icon16 <?= $icon ?>"></span>
                        <span class="admin-nav-label"><?= htmlspecialchars($label) ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div><!-- End .admin-nav-section -->
        <?php endforeach; ?>
    </div><!-- End sidenav -->

    <div class="admin-nav-footer">
        <?= CommonBase::createImage($_SESSION['app_pro']['server'] . $_SESSION['app_pro']['powered_logo'], 96, 42, "powered_logo") ?>
        <a href="<?= $_SESSION['app_pro']['powered_url'] ?>"><?= $_SESSION['app_pro']['powered_name'] ?></a>
    </div>

</div><!-- End #sidebar -->
