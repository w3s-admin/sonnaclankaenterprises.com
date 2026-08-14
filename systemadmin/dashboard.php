<?
require_once '../cpad/clsCommonBase.php';
require_once '../cpad/clsVehicle.php';

CommonBase::IsAdminUser();

$cdb = new ControlPadDB();
$dbh = $cdb->dbh;

$inStockCount = (int) $dbh->query("SELECT COUNT(*) FROM advert WHERE status = 1 AND flow = 1")->fetchColumn();
$soldCount = (int) $dbh->query("SELECT COUNT(*) FROM advert WHERE flow = 2")->fetchColumn();
$reviewCount = (int) $dbh->query("SELECT COUNT(*) FROM review WHERE status = 1")->fetchColumn();
$staffCount = (int) $dbh->query("SELECT COUNT(*) FROM system_admin WHERE _status = 1")->fetchColumn();

$recentStmt = $dbh->query("SELECT Id, modeltxt, fk_make, fk_model, price, status, flow, addt FROM advert WHERE status = 1 ORDER BY Id DESC LIMIT 6");
$recentVehicles = $recentStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <? include_once './inc/comman_head_admin.php'; ?>
        <style>
            .quick-actions { display: flex; flex-wrap: wrap; gap: 10px; }
            .quick-actions a { flex: 1 1 200px; }
        </style>
    </head>

    <body>
        <!-- loading animation -->
        <div id="qLoverlay"></div>
        <div id="qLbar"></div>

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
                        <h3>Dashboard</h3>
                        <ul class="breadcrumb">
                            <li>You are here:</li>
                            <li class="active">Dashboard</li>
                        </ul>
                    </div><!-- End .heading-->

                    <!-- Build page from here: -->
                    <div class="row-fluid">

                        <div class="kpi-row">
                            <div class="kpi-card">
                                <span class="kpi-icon"><i class="icon24 icomoon-icon-cars"></i></span>
                                <div>
                                    <div class="kpi-value"><?= $inStockCount ?></div>
                                    <div class="kpi-label">Vehicles In Stock</div>
                                </div>
                            </div>
                            <div class="kpi-card success">
                                <span class="kpi-icon"><i class="icon24 icomoon-icon-checkmark-2"></i></span>
                                <div>
                                    <div class="kpi-value"><?= $soldCount ?></div>
                                    <div class="kpi-label">Vehicles Sold</div>
                                </div>
                            </div>
                            <div class="kpi-card gold">
                                <span class="kpi-icon"><i class="icon24 icomoon-icon-star"></i></span>
                                <div>
                                    <div class="kpi-value"><?= $reviewCount ?></div>
                                    <div class="kpi-label">Active Reviews</div>
                                </div>
                            </div>
                            <div class="kpi-card warning">
                                <span class="kpi-icon"><i class="icon24 icomoon-icon-user-3"></i></span>
                                <div>
                                    <div class="kpi-value"><?= $staffCount ?></div>
                                    <div class="kpi-label">Staff Accounts</div>
                                </div>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="span8">
                                <div class="admin-card">
                                    <h4 style="margin-top:0;">Recently Added Vehicles</h4>
                                    <?php if (empty($recentVehicles)): ?>
                                        <p style="color: var(--admin-text-secondary);">No vehicles in stock yet.</p>
                                    <?php else: ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Ref</th>
                                                <th>Make</th>
                                                <th>Model</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recentVehicles as $v): ?>
                                            <tr>
                                                <td>#<?= $v['Id'] ?></td>
                                                <td><?= htmlspecialchars(CommonBase::getname($v['fk_make'], "make")) ?></td>
                                                <td><?= htmlspecialchars(CommonBase::getname($v['fk_model'], "model")) ?></td>
                                                <td><?= CommonBase::formatMoney($v['price'], 0) ?></td>
                                                <td>
                                                    <?php if ($v['flow'] == 2): ?>
                                                        <span class="status-badge inactive">Sold</span>
                                                    <?php else: ?>
                                                        <span class="status-badge active">In Stock</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="admin-card">
                                    <h4 style="margin-top:0;">Quick Actions</h4>
                                    <div class="quick-actions">
                                        <a href="vehicle_add.php" class="btn btn-admin-primary">+ Add Vehicle</a>
                                        <a href="review_add.php" class="btn btn-admin-primary">+ Add Review</a>
                                        <a href="user_add.php" class="btn btn-admin-primary">+ Add Staff User</a>
                                        <a href="vehicle_manager.php" class="btn">View Vehicle Manager</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- End .row-fluid -->
                    <!--End page -->

                </div><!-- End contentwrapper -->
            </div><!-- End #content -->

        </div><!-- End #wrapper -->

        <? include_once './inc/comman_js.php'; ?>

    </body>
</html>
