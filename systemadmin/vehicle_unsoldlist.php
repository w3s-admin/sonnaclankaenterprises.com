<?
require_once '../cpad/vehicleController.php';

CommonBase::IsAdminUser();

$stmt = Vehicle::getALLUNSOLD();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Edit User</title>
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
                        // leaveOpen: true,
                        pageTitle: 'Kaduwels Ent Unslod Vehicle List',
                        //  leaveOpen: true,
                        overrideElementCSS: [
                            'css/bootstrap/bootstrap.min.css',
                            {href: 'css/bootstrap/bootstrap.min.css', media: 'print'}]
                    });
                })
            });

        </script>   

    </head>
    <body>
        <div class="row-fluid">
            <div class="span12">             
              <button class="btn"  id="printbtn"><i class="icon-print"></i>Print</button>
            </div>
        </div>
        <hr>
        <div class="row-fluid">
            <div class="span12"  id="printdiv">             
                <?
                if ($stmt != null) {
                    ?>
                    <table width="800" cellspacing="0" cellpadding="5" style="" class="table table-striped" >
                        <thead>
                            <tr class="info">
                                <th width="56"  >ref </th>

                                <th width="69"  >Make</th>

                                <th width="72"  >Model</th>

                                <th width="69"  >Chasis</th>

                                <th width="67"  >Color</th>
                                <th width="67"  > G</th>
                                <th width="67"  >D</th>

                                <th width="67"  >F</th>
                                <th width="67"  >AC</th>
                                <th width="67"  >PS</th>

                                <th width="67"  >PW</th>
                                <th width="67"  >PM</th>
                                <th width="67"  >CC</th>

                                <th width="127"  >Mileage</th>
                                <th width="79"  >Year</th>
                                <th width="114"  >SP</th>
                                <th width="114"  >Comnt</th>
                                <th width="114"  >Reg<br /> 
                                    RegNum </th>
                                <th width="114"  >more</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?
                            while ($vehicle_details = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $img = Vehicle::getFirastimage($vehicle_details['Id']);
                               
                                ?>
                                <tr>
                                    <td ><?= $vehicle_details['Id'] ?></td>

                                    <td ><?= Vehicle::getname($vehicle_details['fk_make'], "make") ?></td>

                                    <td ><?= Vehicle::getname($vehicle_details['fk_model'], "model") ?></td>

                                    <td ><?= $vehicle_details['chasi'] ?></td>

                                    <td ><?= Vehicle::getname($vehicle_details['fk_color'], "colour") ?></td>
                                    <td > 
                                        <?= Vehicle::getname($vehicle_details['fk_transmission'], "transmission"); ?>
                                    </td>
                                    <td ><span class="vmt2">
                                            <?= Vehicle::getname($vehicle_details['fk_body_type'], "body_type"); ?>
                                        </span></td>

                                    <td ><span class="vmt2">
                                            <?= Vehicle::getname($vehicle_details['fk_fuel'], "fuel"); ?>
                                        </span></td>
                                    <td ><?= CommonBase::yn($vehicle_details['ac']) ?></td>
                                    <td ><?= CommonBase::yn($vehicle_details['ps']) ?></td>
                                    <td ><?= CommonBase::yn($vehicle_details['pw']) ?></td>
                                    <td ><?= CommonBase::yn($vehicle_details['pm']) ?></td>
                                    <td ><span class="vmt2">
                                            <?= $vehicle_details['eng_cap'] ?>
                                        </span></td>



                                    <td ><span class="vmt2">
                                            <?= CommonBase::formatMoney($vehicle_details['mileage'], 0) ?>
                                        </span>Km              </td>

                                    <td ><span class="vmt2">
                                            <?= $vehicle_details['yearmonth'] ?>
                                        </span></td>



                                    <td ><?
                                        if ($vehicle_details['highestoffer'] == 1) {

                                            echo "Highest offer";
                                        } else {

                                            echo Vehicle::getname($vehicle_details['fk_price_type'], "price_type") . " <b>" . CommonBase::formatMoney($vehicle_details['price'], 0) . "</b>";
                                        }
                                        ?></td>
                                    <td > 
                                        <?= $vehicle_details['other_op'] ?>&nbsp;
                                    </td>
                                    <td >

                                        <?= Vehicle::getname($vehicle_details['fk_category'], "category"); ?> 
                                        <br />
                                        <?= ($vehicle_details['registed_number'] != "") ? $vehicle_details['registed_number'] : "" ?>
                                    </td>
                                    <td ><a href="<?= CommonBase::getServer() ?>/vehicle/<?= CommonBase::encrypt($vehicle_details['Id']) ?>/<?
                                        $ym = explode("-", $vehicle_details['yearmonth']);

                                        echo $ym[0] . "_" . Vehicle::getname($vehicle_details['fk_make'], "make") . "_" . Vehicle::getname($vehicle_details['fk_model'], "model");
                                        ?>.html"><img height="50" width="70" src="<?= CommonBase::getServer() . $img['tpath'] . $img['image_name'] ?>"/></a></td>

                                </tr>

                            <? } ?>
                        </tbody>
                    </table>

                    <?
                }
                ?>

            </div>
        </div>
    </body>
</html>

