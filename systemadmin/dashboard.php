<?
require_once '../cpad/clsCommonBase.php';
require_once '../cpad/clsVehicle.php';
require_once '../cpad/clsInquiry.php';

CommonBase::IsAdminUser();

$cdb = new ControlPadDB();
$dbh = $cdb->dbh;

$inStockCount = (int) $dbh->query("SELECT COUNT(*) FROM advert WHERE status = 1 AND flow = 1")->fetchColumn();
$soldCount = (int) $dbh->query("SELECT COUNT(*) FROM advert WHERE flow = 2")->fetchColumn();
$reviewCount = (int) $dbh->query("SELECT COUNT(*) FROM review WHERE status = 1")->fetchColumn();
$staffCount = (int) $dbh->query("SELECT COUNT(*) FROM system_admin WHERE _status = 1")->fetchColumn();
$inquiryUnreadCount = Inquiry::getUnreadCount();
$recentInquiries = Inquiry::getRecent(5);

$recentStmt = $dbh->query("SELECT Id, modeltxt, fk_make, fk_model, price, status, flow, addt FROM advert WHERE status = 1 ORDER BY Id DESC LIMIT 6");
$recentVehicles = $recentStmt->fetchAll(PDO::FETCH_ASSOC);

// Vehicles added per month, last 6 months (chronological, zero-filled so a quiet month still shows).
$monthlyStmt = $dbh->query("SELECT DATE_FORMAT(addt, '%Y-%m') AS ym, COUNT(*) AS cnt FROM advert WHERE status = 1 AND addt >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) GROUP BY ym");
$monthlyRows = $monthlyStmt ? $monthlyStmt->fetchAll(PDO::FETCH_ASSOC) : array();
$monthlyByYm = array();
foreach ($monthlyRows as $r) {
    $monthlyByYm[$r['ym']] = (int) $r['cnt'];
}
$monthLabels = array();
$monthValues = array();
for ($i = 5; $i >= 0; $i--) {
    $ym = date('Y-m', strtotime("-$i months"));
    $monthLabels[] = date('M', strtotime("-$i months"));
    $monthValues[] = isset($monthlyByYm[$ym]) ? $monthlyByYm[$ym] : 0;
}
$monthTicks = array();
foreach ($monthLabels as $i => $lbl) {
    $monthTicks[] = array($i, $lbl);
}
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
                            <a href="inquiry_manager.php" class="kpi-card<?= $inquiryUnreadCount > 0 ? ' gold' : '' ?>" style="text-decoration:none;">
                                <span class="kpi-icon"><i class="icon24 icomoon-icon-mail"></i></span>
                                <div>
                                    <div class="kpi-value"><?= $inquiryUnreadCount ?></div>
                                    <div class="kpi-label">New Inquiries</div>
                                </div>
                            </a>
                        </div>

                        <div class="row-fluid">
                            <div class="span8">
                                <div class="admin-card chart-card">
                                    <div class="chart-card-head">
                                        <h4>Vehicles Added</h4>
                                        <span class="chart-card-meta">Last 6 months</span>
                                    </div>
                                    <div id="monthlyTrendChart" class="chart-canvas" style="height:220px;"></div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="admin-card chart-card">
                                    <div class="chart-card-head">
                                        <h4>Inventory Split</h4>
                                    </div>
                                    <div id="stockSplitChart" class="chart-canvas" style="height:180px; min-height:180px;"></div>
                                    <div style="display:flex; justify-content:center; gap:16px; margin-top:10px; font-size:12.5px; color:var(--admin-text-secondary);">
                                        <span><span class="chart-legend-dot" style="background:var(--admin-primary)"></span>In Stock</span>
                                        <span><span class="chart-legend-dot" style="background:var(--admin-success)"></span>Sold</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="span8">
                                <div class="admin-card">
                                    <h4 style="margin-top:0;">Recently Added Vehicles</h4>
                                    <?php if (empty($recentVehicles)): ?>
                                        <div class="table-empty-state">
                                            <span class="icon24 icomoon-icon-cars"></span>
                                            <strong>No vehicles in stock yet</strong>
                                            <span>New listings will show up here as soon as they're added.</span>
                                        </div>
                                    <?php else: ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Ref</th>
                                                <th>Vehicle</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recentVehicles as $v):
                                                $vImg = Vehicle::getFirastimage($v['Id']);
                                            ?>
                                            <tr>
                                                <td>#<?= $v['Id'] ?></td>
                                                <td>
                                                    <div class="recent-vehicle-thumb">
                                                        <?= CommonBase::createImage(CommonBase::getServer() . $vImg['tpath'] . $vImg['image_name'], 52, 38) ?>
                                                        <div>
                                                            <div class="rv-title"><?= htmlspecialchars(CommonBase::getname($v['fk_make'], "make")) ?> <?= htmlspecialchars(CommonBase::getname($v['fk_model'], "model")) ?></div>
                                                            <div class="rv-sub"><?= htmlspecialchars($v['modeltxt']) ?></div>
                                                        </div>
                                                    </div>
                                                </td>
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

                        <div class="row-fluid">
                            <div class="span12">
                                <div class="admin-card">
                                    <h4 style="margin-top:0;">Recent Inquiries <a href="inquiry_manager.php" style="float:right; font-size:12.5px;">View All</a></h4>
                                    <?php if (empty($recentInquiries)): ?>
                                        <div class="table-empty-state">
                                            <span class="icon24 icomoon-icon-mail"></span>
                                            <strong>No inquiries yet</strong>
                                            <span>Customer inquiries from the public site will show up here.</span>
                                        </div>
                                    <?php else: ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Name</th>
                                                <th>Vehicle</th>
                                                <th>Message</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recentInquiries as $iq):
                                                $isUnread = ((int) $iq['status'] === 0);
                                                $vehicleLabel = $iq['fk_advert']
                                                    ? trim(($iq['modeltxt'] ?? '') . ' (' . ($iq['chasi'] ?? '') . ')')
                                                    : 'General';
                                            ?>
                                            <tr<?= $isUnread ? ' style="font-weight:bold;"' : '' ?>>
                                                <td><?= htmlspecialchars($iq['addt'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($iq['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($vehicleLabel, ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars(mb_strimwidth($iq['message'] ?? '', 0, 60, '...'), ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= $isUnread ? '<span class="status-badge inactive">New</span>' : '<span class="status-badge active">Read</span>' ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </div><!-- End .row-fluid -->
                    <!--End page -->

                </div><!-- End contentwrapper -->
            </div><!-- End #content -->

        </div><!-- End #wrapper -->

        <? include_once './inc/comman_js.php'; ?>
        <script type="text/javascript">
            $(function () {
                if (!$.plot) { return; }

                var monthTicks = <?= json_encode($monthTicks) ?>;
                var monthValues = <?= json_encode($monthValues) ?>;
                var barData = [];
                for (var i = 0; i < monthValues.length; i++) { barData.push([i, monthValues[i]]); }

                $.plot("#monthlyTrendChart", [{
                    data: barData,
                    bars: { show: true, barWidth: 0.55, align: "center", fillColor: "#123A5C", lineWidth: 0 },
                    color: "#123A5C"
                }], {
                    grid: { borderWidth: 0, hoverable: true, clickable: false, margin: { top: 12, right: 12, bottom: 4, left: 4 } },
                    xaxis: { ticks: monthTicks, tickLength: 0 },
                    yaxis: { min: 0, tickDecimals: 0 },
                    tooltip: true,
                    tooltipOpts: { content: "%y vehicle(s)", shifts: { x: -30, y: -40 } }
                });

                <?php if (($inStockCount + $soldCount) > 0): ?>
                $.plot("#stockSplitChart", [
                    { label: "In Stock", data: <?= (int) $inStockCount ?>, color: "#123A5C" },
                    { label: "Sold", data: <?= (int) $soldCount ?>, color: "#16A34A" }
                ], {
                    series: {
                        pie: {
                            show: true,
                            radius: 0.9,
                            innerRadius: 0.6,
                            stroke: { color: "#fff", width: 2 },
                            label: { show: false }
                        }
                    },
                    grid: { hoverable: true },
                    tooltip: true,
                    tooltipOpts: { content: "%s: %y", shifts: { x: -30, y: -40 } }
                });
                <?php else: ?>
                $("#stockSplitChart").html('<div class="table-empty-state" style="padding:24px 8px;"><span class="icon24 icomoon-icon-cars"></span><strong>No inventory data yet</strong></div>');
                <?php endif; ?>
            });
        </script>

    </body>
</html>
