<?
require_once '../cpad/vehicleController.php';

CommonBase::IsAdminUser();

$stmt = Vehicle::getALLUNSOLD();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <? include_once './inc/comman_head_admin.php'; ?>
        <!-- Plugin stylesheets -->
        <link href="plugins/forms/select/select2.css" type="text/css" rel="stylesheet" />
        <link href="plugins/forms/validate/validate.css" type="text/css" rel="stylesheet" />
        <link href="plugins/forms/inputlimiter/jquery.inputlimiter.css" type="text/css" rel="stylesheet" />
        <link href="plugins/forms/ibutton/jquery.ibutton.css" type="text/css" rel="stylesheet" />
        <!-- Form plugins -->
        <script type="text/javascript" src="plugins/forms/watermark/jquery.watermark.min.js"></script>
        <script type="text/javascript" src="plugins/forms/uniform/jquery.uniform.min.js"></script>
        <script type="text/javascript" src="plugins/forms/select/select2.min.js"></script>
        <script type="text/javascript" src="plugins/forms/validate/jquery.validate.min.js"></script>
        <script type="text/javascript" src="plugins/forms/inputlimiter/jquery.inputlimiter.1.3.min.js"></script>
        <script type="text/javascript" src="plugins/forms/ibutton/jquery.ibutton.min.js"></script>
        <script type="text/javascript" src="plugins/forms/validation-engine/jquery.validationEngine.js"></script>
        <link href="plugins/forms/validation-engine/css/validationEngine.jquery.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="plugins/forms/validation-engine/languages/jquery.validationEngine-en.js"></script>

        <script type="text/javascript" src="plugins/print/printElement/jquery.printElement.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#printbtn").click(function() {
                    $("#printdiv").printElement({
                        printMode: 'popup',
                        pageTitle: 'Sonnac Lanka Enterprises - Unsold Vehicle List',
                        overrideElementCSS: [
                            'css/bootstrap/bootstrap.min.css',
                            {href: 'css/bootstrap/bootstrap.min.css', media: 'print'}]
                    });
                })
            });
        </script>
    </head>
    <body>
        <div id="qLoverlay"></div>
        <div id="qLbar"></div>

        <? include_once './inc/pagehead.php'; ?>

        <div id="wrapper">
            <div class="resBtn"><a href="#"><span class="icon16 minia-icon-list-3"></span></a></div>

            <? include_once './inc/slideBar.php'; ?>

            <div id="content" class="clearfix">
                <div class="contentwrapper">

                    <div class="heading">
                        <h3>Unsold List</h3>
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
                            <li class="active">Unsold List</li>
                        </ul>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <div class="admin-card">
                                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom: var(--admin-space-4);">
                                    <h4 style="margin:0;">Unsold Vehicles</h4>
                                    <button class="btn btn-admin-primary" id="printbtn">
                                        <span class="icon16 icomoon-icon-printer"></span> Print
                                    </button>
                                </div>

                                <div id="printdiv">
                                    <?php if ($stmt != null): ?>
                                    <table cellspacing="0" cellpadding="5" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Ref</th>
                                                <th>Make</th>
                                                <th>Model</th>
                                                <th>Chasis</th>
                                                <th>Color</th>
                                                <th>G</th>
                                                <th>D</th>
                                                <th>F</th>
                                                <th>AC</th>
                                                <th>PS</th>
                                                <th>PW</th>
                                                <th>PM</th>
                                                <th>CC</th>
                                                <th>Mileage</th>
                                                <th>Year</th>
                                                <th>SP</th>
                                                <th>Comnt</th>
                                                <th>Reg<br />RegNum</th>
                                                <th>More</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($vehicle_details = $stmt->fetch(PDO::FETCH_ASSOC)):
                                                $img = Vehicle::getFirastimage($vehicle_details['Id']);
                                            ?>
                                            <tr>
                                                <td><?= $vehicle_details['Id'] ?></td>
                                                <td><?= Vehicle::getname($vehicle_details['fk_make'], "make") ?></td>
                                                <td><?= Vehicle::getname($vehicle_details['fk_model'], "model") ?></td>
                                                <td><?= $vehicle_details['chasi'] ?></td>
                                                <td><?= Vehicle::getname($vehicle_details['fk_color'], "colour") ?></td>
                                                <td><?= Vehicle::getname($vehicle_details['fk_transmission'], "transmission"); ?></td>
                                                <td><?= Vehicle::getname($vehicle_details['fk_body_type'], "body_type"); ?></td>
                                                <td><?= Vehicle::getname($vehicle_details['fk_fuel'], "fuel"); ?></td>
                                                <td><?= CommonBase::yn($vehicle_details['ac']) ?></td>
                                                <td><?= CommonBase::yn($vehicle_details['ps']) ?></td>
                                                <td><?= CommonBase::yn($vehicle_details['pw']) ?></td>
                                                <td><?= CommonBase::yn($vehicle_details['pm']) ?></td>
                                                <td><?= $vehicle_details['eng_cap'] ?></td>
                                                <td><?= CommonBase::formatMoney($vehicle_details['mileage'], 0) ?> Km</td>
                                                <td><?= $vehicle_details['yearmonth'] ?></td>
                                                <td><?
                                                    if ($vehicle_details['highestoffer'] == 1) {
                                                        echo "Highest offer";
                                                    } else {
                                                        echo Vehicle::getname($vehicle_details['fk_price_type'], "price_type") . " <b>" . CommonBase::formatMoney($vehicle_details['price'], 0) . "</b>";
                                                    }
                                                    ?></td>
                                                <td><?= $vehicle_details['other_op'] ?>&nbsp;</td>
                                                <td>
                                                    <?= Vehicle::getname($vehicle_details['fk_category'], "category"); ?>
                                                    <br />
                                                    <?= ($vehicle_details['registed_number'] != "") ? $vehicle_details['registed_number'] : "" ?>
                                                </td>
                                                <td><a href="<?= CommonBase::getServer() ?>/vehicle/<?= CommonBase::encrypt($vehicle_details['Id']) ?>/<?
                                                    $ym = explode("-", $vehicle_details['yearmonth']);
                                                    echo $ym[0] . "_" . Vehicle::getname($vehicle_details['fk_make'], "make") . "_" . Vehicle::getname($vehicle_details['fk_model'], "model");
                                                    ?>.html"><img height="50" width="70" src="<?= CommonBase::getServer() . $img['tpath'] . $img['image_name'] ?>"/></a></td>
                                            </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                    <?php else: ?>
                                    <p style="color: var(--admin-text-secondary);">No unsold vehicles.</p>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <? include_once './inc/comman_js.php'; ?>
    </body>
</html>
