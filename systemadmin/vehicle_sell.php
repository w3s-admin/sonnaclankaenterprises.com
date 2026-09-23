<?
require_once '../cpad/vehicleController.php';
CommonBase::IsAdminUser();

if (isset($_GET['vid'])) {
    $id = CommonBase::decrypt($_GET['vid']);
    if (is_numeric($id)) {
        $cid = $id;
    } else {
        echo CommonBase::closeWindow();
    }
}
require_once '../cpad/vehicleController.php';

$vdetails = Vehicle::getVehicle($id);

$Stock = $vdetails['fk_stock'];
$vtype = $vdetails['fk_type'];
$Make = $vdetails['fk_make'];
$Model = $vdetails['fk_model'];
$Modeltxt = $vdetails['modeltxt'];
$BodyType = $vdetails['fk_body_type'];
$Chasi = $vdetails['chasi'];
$fk_engine_capacity = $vdetails['fk_engine_capacity'];
$Transmission = $vdetails['fk_transmission'];
$FuelType = $vdetails['fk_fuel'];
$hyb = $vdetails['hybrid'];
$BaseColur = $vdetails['fk_color'];
$ActualColour = $vdetails['acolor'];
$Grade = $vdetails['grade'];
$ym = $vdetails['yearmonth'];
$km = $vdetails['mileage'];
$Price = $vdetails['price'];
$ho = $vdetails['highestoffer'];
$ac = $vdetails['ac'];
$ps = $vdetails['ps'];
$pw = $vdetails['pw'];
$pm = $vdetails['pm'];
$abs = $vdetails['abs'];
$tv = $vdetails['tv'];
$cd = $vdetails['cd'];
$dvd = $vdetails['dvd'];
$alloy = $vdetails['aw'];
$airbag = $vdetails['airbag'];
$r_camera = $vdetails['r_camera'];
$foglamp = $vdetails['foglamp'];
$sunroof = $vdetails['sunroof'];
$leather = $vdetails['leather'];
$wm = $vdetails['winkermirror'];
$rw = $vdetails['rearwiper'];
$sk = $vdetails['skey'];
$Options = $vdetails['other_op'];
$ref = $vdetails['ref'];
$Category = $vdetails['fk_category'];
$reg_num = $vdetails['registed_number'];
$price_type = $vdetails['fk_price_type'];
$so = $vdetails['special_offer'];
$so_price = ($vdetails['special_offer_price'] == 0) ? "" : $vdetails['special_offer_price'];
$sellp = $sellp ?? null;
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


        <script type="text/javascript">
            $(function() {
//                $("#form-validate_addshop").validate({
//                    ignore: null,
//                    ignore: 'input[type="hidden"]',
//                            rules: {
//                        required1: {
//                            required: true,
//                            minlength: 4
//                        }
//
//                    }
//                });



                $(".ibutton").iButton({
                    labelOn: "ON",
                    labelOff: "OFF",
                    enableDrag: false
                });

                $("#form_validate_sell").validationEngine();

            })
        </script>

    </head>
    <body>
        <div class="row-fluid">
            <div class="span12">
                <?= (isset($shop_save_msg)) ? $shop_save_msg : "" ?>
                <div class="tabbable "> <!-- Only required for left/right tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab0" data-toggle="tab">Selling</a></li>
                        <li><a href="#tab1" data-toggle="tab">Details</a></li>
                        <li><a href="#tab2" data-toggle="tab">Current Images</a></li>
                        <li><a href="#tab3" data-toggle="tab">Add  New Images</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab0" style="height: 600px;">
                            <form class="form-horizontal" id="form_validate_sell" action=""  enctype="multipart/form-data"  method="post">
                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <div class="span5 controls sel" >

                                            </div>   
                                        </div>
                                    </div>
                                </div> 

                                <? if ($vdetails['flow']== 1) { ?>
                                    <div class="form-row row-fluid">
                                        <div class="span12">
                                            <div class="row-fluid">
                                                <label class="form-label span3  red"  for="name">Selling Price</label>
                                                <div class="span5 controls sel" >
                                                    <input type="text" value="<?= htmlspecialchars(${'sellp'} ?? '', ENT_QUOTES, 'UTF-8') ?>" name="sellp" class="span12 validate[required,custom[number]]" />
                                                </div>   
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="form-row row-fluid">
                                        <div class="span12">
                                            <div class="row-fluid">
                                                <div class="form-actions">
                                                    <div class="span3"></div>
                                                    <div class="span9 controls">
                                                        <button type="submit" class="btn marginR10" name="carsale_Sell">Save changes</button>
                                                        <button class="btn btn-danger" type="reset">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                <? } elseif ($vdetails['flow']== 2) {
                                    ?>
                                    <div class="form-row row-fluid">
                                        <div class="span12">
                                            <div class="row-fluid">
                                                <div class="span5 controls sel " >
                                                    <h3 class="red">Vehicle Sold !</h3>
                                                </div>   
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="form-row row-fluid">
                                        <div class="span12">
                                            <div class="row-fluid">
                                                <label class="form-label span3 "  for="name">Selling Price</label>
                                                <div class="span5 controls sel" >
                                                    <strong><?= CommonBase::getname($vdetails['fk_price_type'], "price_type").' '.CommonBase::formatMoney($vdetails['selling_price'] ,0)?></strong>
                                                </div>   
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="form-row row-fluid">
                                        <div class="span12">
                                            <div class="row-fluid">
                                                <div class="form-actions">
                                                    <div class="span3"></div>
                                                    <div class="span9 controls">
                                                        <button type="submit" class="btn marginR10 btn-danger" name="carsale_Sell_remove" onclick="confirm('Are you sure this will remove payment permanently')">Remove Selling</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                <? } ?>


                            </form>
                        </div>
                        <div class="tab-pane" id="tab1">
                            <form class="form-horizontal" id="form_validate_addpro" action=""  enctype="multipart/form-data"  method="post">
                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <label class="form-label span3  red"  for="name">Stock</label>
                                            <div class="span5 controls sel" >
                                                <?= Vehicle::createSelect($Stock, "Stock", 0, "required nostyle validate[required]", "Please select Stock", "select Id , name from stock WHERE status = 1 ORDER by Id asc") ?>
                                            </div>   
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <label class="form-label span3 red" for="name">Type</label>
                                            <div class="span5 controls sel" >
                                                <?= Vehicle::createSelect($vtype, "vtype", 1, "validate[required] nostyle", "Please Select Category") ?>
                                            </div>   
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <label class="form-label span3 red" for="name">Make</label>
                                            <div class="span5 controls sel" >

                                                <?=
                                                CommonBase::createSelect(
                                                        ${'Make'}, $name = 'Make', $type = 6, $class = "nostyle  validate[required]", $title = "", $q = "select Id , name from make WHERE status = 1 ORDER by Id asc", $word = "Select Make", $style = "width:100%;", false
                                                )
                                                ?>
                                            </div>   
                                        </div>
                                    </div>
                                </div> 

                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <label class="form-label span3 red" for="validate[required]">Model</label>
                                            <div class="grid-inputs span6 controls">
                                                <div class="span6"><div class="span11 controls">
                                                        <select id="Model"  name="Model" class="validate[required] nostyle" title="Please Select Model ">
                                                            <?= CommonBase::createSelectAjxSearch(CommonBase::encrypt(${'Model'}), CommonBase::encrypt(${'Make'}), "select Id,name from model WHERE fk_make = ? and status =1", "fk_model", "Price Per") ?>

                                                        </select> </div>

                                                </div>
                                                <div class="span4">
                                                    <input type="text" name="Modeltxt" id="Modeltxt" class="validate[required]" title="Please Add Model" value="<?= htmlspecialchars($Modeltxt ?? '', ENT_QUOTES, 'UTF-8') ?>" />
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <label class="form-label span3 red" for="phone">Body Type</label>
                                            <div class="controls-textarea span5">
                                                <?= Vehicle::createSelect($BodyType, "BodyType", 0, "validate[required] nostyle", "Please select Body Type", "select Id , name from body_type WHERE status = 1 ORDER by Id asc") ?>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <label class="form-label span3 red" for="phone">Chasi Number</label>
                                            <div class="span5 controls sel" >
                                                <input type="text" name="Chasi" id="Chasi" class="validate[required]"  title="Please Select Chasi" value="<?= htmlspecialchars($Chasi ?? '', ENT_QUOTES, 'UTF-8') ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <label class="form-label span3 red" for="validate[required]">Engine Capacity</label>

                                            <div class="grid-inputs span5 ">
                                                <?= Vehicle::createSelect($fk_engine_capacity, "fk_engine_capacity", 0, "validate[required] nostyle", "Please select Engine Capacity", "select Id , name from engine_capacity WHERE `_status` = 1 ORDER by Id asc") ?>
                                            </div>


                                        </div>
                                    </div>
                                </div> 
                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <label class="form-label span3 red" for="vat">Transmission</label>
                                            <div class="grid-inputs span5">
                                                <?= Vehicle::createSelect($Transmission, "Transmission", 0, "validate[required] nostyle", "Please select Transmission", "select Id , name from transmission WHERE status = 1 ORDER by Id asc") ?>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <label class="form-label span3 red" for="phone">Fuel Type</label>
                                            <div class="left marginR10 span5">
                                                <?= Vehicle::createSelect($FuelType, "FuelType", 0, "validate[required] nostyle", "Please select Fuel Type", "select Id , name from fuel WHERE status = 1 ORDER by Id asc") ?>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <label class="form-label span3 red " for="phone">Colur</label>
                                            <div class="left marginR10 span5">
                                                <?= Vehicle::createSelect($BaseColur, "BaseColur", 0, "validate[required] nostyle", "Please select Base Colur ", "select Id , name from colour WHERE status = 1 ORDER by Id asc") ?>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <label class="form-label span3 red" for="phone">Year &amp; Month (2010 - 11)</label>
                                            <div class="left marginR10">
                                                <input type="text" name="ym" id="ym" class="validate[required]"  title="Please Select Year &amp; Month " value="<?= htmlspecialchars($ym ?? '', ENT_QUOTES, 'UTF-8') ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div> 

                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <label class="form-label span3 red" for="phone">Mileage</label>
                                            <div class="left marginR10">
                                                <div class="input-prepend">
                                                    <input type="text" name="km" id="km" class="validate[required]"  title="Please Select Mileage"  value="<?= htmlspecialchars($km ?? '', ENT_QUOTES, 'UTF-8') ?>"/>
                                                    <span class="add-on">KM</span>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <label class="form-label span3 red" for="phone">Category</label>
                                            <div class="left marginR10 span5">
                                                <?= Vehicle::createSelect($Category, "Category", 0, "validate[required] nostyle", "Please select Category", "select Id , name from category WHERE status = 1 ORDER by Id asc") ?>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <label class="form-label span3 " for="phone">Registration #</label>
                                            <div class="left marginR10 span5">
                                                <input type="text" name="reg_num" id="reg_num"   value="<?= htmlspecialchars($reg_num ?? '', ENT_QUOTES, 'UTF-8') ?>"  />
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <label class="form-label span3 " for="phone">  Highest offer      </label>
                                            <div class="left marginR10 span5">
                                                <input name="ho" id="ho" type="checkbox" value="1" class="ibutton nostyle span3" <?= CommonBase::checked(${'ho'}) ?> />

                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-row row-fluid" id="priceDIV">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <label class="form-label span3 red" for="phone">Price</label>
                                            <div class="left marginR10 grid-inputs span9">
                                                <div class="span1" style="padding-top:8px;">
                                                    <strong>Rs</strong>
                                                </div>
                                                <div class="span6" >
                                                    <input  type="text" name="Price" id="Price" class="validate[required] span11"  title="Please Add Price" value="<?= htmlspecialchars($Price ?? '', ENT_QUOTES, 'UTF-8') ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
            $(function() {
                if ($('#ho').is(':checked')) {
                    $('#priceDIV').hide();
                } else {
                    $('#priceDIV').show();
                }

                $('#ho').change(function() {
                    if ($(this).is(':checked')) {
                        $('#priceDIV').hide();
                    } else {
                        $('#priceDIV').show();
                    }
                });


            })

                                </script>
                                <div class="form-row     row-fluid" >
                                    <div class="span12">                               

                                        <div class="row-fluid">
                                            <label class="form-label span3 " for="phone">Special Offer - Amount</label>
                                            <div class="grid-inputs span8">
                                                <div class="span4" >
                                                    <input type="checkbox" name="so" value="1" id="so"  class="nostyle ibutton " <?= CommonBase::checked(${'so'}) ?>  />     
                                                </div>
                                                <div class="span4" >
                                                    <input type="text" name="so_price" class="validate[condRequired[so]]" id="so_price" value="<?= htmlspecialchars($so_price ?? '', ENT_QUOTES, 'UTF-8') ?>" />
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div> 

                                <div class="row-fluid">
                                    <div class="span12 ">
                                        <h4>Option List</h4> 
                                    </div>
                                </div>
                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">

                                            <div class="left marginR10 span12">
                                                <div class="row-fluid">
                                                    <div class="span12">
                                                        <div class="row-fluid">
                                                            <div class="span4">
                                                                <label class="form-label span6 " for="phone">Ac</label>
                                                                <input type="checkbox" name="ac" class="ibutton nostyle" value="1" <?= CommonBase::checked($ac) ?> />
                                                            </div>
                                                            <div class="span4">
                                                                <label class="form-label span6 " for="phone">PS</label>
                                                                <input type="checkbox" name="ps"  class="ibutton nostyle" value="1"  <?= CommonBase::checked($ps) ?>/>
                                                            </div>

                                                        </div>
                                                        <div class="row-fluid">

                                                            <div class="span4">
                                                                <label class="form-label span6 " for="phone">PW</label>
                                                                <div class="controls"> <input type="checkbox" name="pw"  class="ibutton nostyle" value="1" <?= CommonBase::checked($pw) ?> /></div>

                                                            </div>
                                                            <div class="span4">
                                                                <label class="form-label span6 " for="phone">PM</label>
                                                                <input type="checkbox" name="pm"  class="ibutton nostyle" value="1"  <?= CommonBase::checked($pm) ?>/>
                                                            </div>
                                                            <div class="span4">
                                                                <label class="form-label span6 " for="phone">Winker M</label>
                                                                <input type="checkbox" name="wm"  class="ibutton nostyle" value="1" <?= CommonBase::checked($wm) ?> />
                                                            </div>
                                                        </div>
                                                        <div class="row-fluid">
                                                            <div class="span4">
                                                                <label class="form-label span6 " for="phone">ABS</label>
                                                                <input type="checkbox" name="abs"  class="ibutton nostyle" value="1" <?= CommonBase::checked($abs) ?> />
                                                            </div>
                                                            <div class="span4">
                                                                <label class="form-label  span6" for="phone">Alloy Wheels </label>
                                                                <input type="checkbox" name="alloy"  class="ibutton nostyle" value="1"  <?= CommonBase::checked($alloy) ?> />
                                                            </div>
                                                            <div class="span4">
                                                                <label class="form-label span6 " for="phone">Air bag </label>
                                                                <input type="checkbox" name="airbag"  class="ibutton nostyle" value="1"  <?= CommonBase::checked($airbag) ?> />
                                                            </div>

                                                        </div>
                                                        <div class="row-fluid">
                                                            <div class="span4">
                                                                <label class="form-label span6 " for="phone">R-Camera</label>
                                                                <input type="checkbox" name="r_camera"  class="ibutton nostyle" value="1" <?= CommonBase::checked($r_camera) ?> />
                                                            </div>
                                                            <div class="span4">
                                                                <label class="form-label span6 " for="phone">Foglamp</label>
                                                                <input type="checkbox" name="foglamp"  class="ibutton nostyle" value="1"  <?= CommonBase::checked($foglamp) ?>/>
                                                            </div>
                                                            <div class="span4">
                                                                <label class="form-label span6 " for="phone">Sunroof</label>
                                                                <input type="checkbox" name="sunroof"  class="ibutton nostyle" value="1" <?= CommonBase::checked($sunroof) ?> />
                                                            </div>
                                                        </div>
                                                        <div class="row-fluid">

                                                            <div class="span4">
                                                                <label class="form-label span6 " for="phone">Leather Seat</label>
                                                                <input type="checkbox" name="leather"  class="ibutton nostyle" value="1" <?= CommonBase::checked($leather) ?> />
                                                            </div>
                                                            <div class="span4">
                                                                <label class="form-label span6 " for="phone">Smart Key</label>
                                                                <input type="checkbox" name="sk"  class="ibutton nostyle" value="1" <?= CommonBase::checked($sk) ?> />
                                                            </div>
                                                            <div class="span4">
                                                                <label class="form-label span6 " for="phone">Rear Wiper</label>
                                                                <input type="checkbox" name="rw"  class="ibutton nostyle" value="1"  <?= CommonBase::checked($rw) ?>/>
                                                            </div>
                                                        </div>
                                                        <div class="row-fluid">

                                                            <div class="span4">
                                                                <label class="form-label span6 " for="phone">TV</label>
                                                                <input type="checkbox" name="tv"  class="ibutton nostyle" value="1" <?= CommonBase::checked($tv) ?> />
                                                            </div>
                                                            <div class="span4">
                                                                <label class="form-label span6 " for="phone">CD</label>
                                                                <input type="checkbox" name="cd"  class="ibutton nostyle" value="1" <?= CommonBase::checked($cd) ?> />
                                                            </div>

                                                            <div class="span4">
                                                                <label class="form-label span6 " for="phone">DVD</label>
                                                                <input type="checkbox" name="dvd"  class="ibutton nostyle" value="1" <?= CommonBase::checked($dvd) ?>/>
                                                            </div>
                                                        </div>
                                                        <div class="row-fluid">

                                                        </div>
                                                    </div>

                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <label class="form-label span3 " for="phone">Other OPtions</label>
                                            <div class="left marginR10 span8">
                                                <textarea name="Options" id="Options" cols="" rows="5" class="span12 uniform"><?= htmlspecialchars($Options ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <div class="form-actions">
                                                <div class="span3"></div>
                                                <div class="span9 controls">
                                                    <button type="submit" class="btn marginR10" name="carsale_editvehicle">Save changes</button>
                                                    <button class="btn btn-danger" type="reset">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>




                            </form>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <?
                            $img_arr = Vehicle::getAllimages($id);
                            if (empty($img_arr)) {
                                ?>
                                <div class="form-row row-fluid">
                                    <div class="span12"><span class="label label-important">
                                            No Images Available.
                                        </span></div></div>
                            <? } else { ?>
                                <? foreach ($img_arr as $key => $value) { ?>
                                    <div class="form-row row-fluid">
                                        <div class="span12">
                                            <div class="row-fluid">
                                                <label class="form-label span3 red" for="name">
                                                    <img src="<?= CommonBase::getServer() . $value['tpath'] . $value['image_name'] ?>" class="img-polaroid">
                                                </label>
                                                <div class="grid-inputs" >
                                                    <div><strong>Update</strong></div>
                                                    <form class="form-horizontal imgfrm" id="form_validate_img" action=""  enctype="multipart/form-data"  method="post">
                                                        <input type="hidden" value="<?= CommonBase::encrypt($value['Id']) ?>" name="Id" />
                                                        <input type="file" name="fileinput" class="nostyle span4" id="file"  style="margin: 0"/>
                                                        <button class="btn btn-warning" type="submit" name="updateImage"  ><i class="icon-file icon-white"></i> Update</button>
                                                        <button class="btn btn-danger" type="submit" name="DelImg"  onclick="confirm('Are you Sure ?')" ><i class="icon-remove"></i></button>
                                                    </form>
                                                </div>   
                                            </div>
                                        </div>
                                    </div> 
                                <? } ?>
                            <? } ?>

                        </div>
                        <div class="tab-pane" id="tab3">
                            <form class="form-horizontal" id="form_validate_addpro" action=""  enctype="multipart/form-data"  method="post">
                                <a href="#" id="addScnt" class="btn btn-success"  ><span class="icomoon-icon-file-add white" ></span> Add Another Image</a>
                                <div id="p_scents">
                                    <div class="form-row row-fluid">
                                        <div class="span12">
                                            <div class="row-fluid">
                                                <label class="form-label span3" for="name">Image 1<small> (default)</small></label>
                                                <div class="grid-inputs span8" >
                                                    <input type="file" name="fileinput" class="nostyle span5" id="file"  style="margin: 0"/>


                                                </div>   
                                            </div>
                                        </div>
                                    </div> 

                                </div>
                                <script>
            $(function() {

                var scntDiv = $('#p_scents');
                var i = $('#p_scents form-row row-fluid').size() + 2;

                $('#addScnt').live('click', function() {
                    //   $('<p class="imagTxt">Image ' + i + '<label for="p_scnts"><input type="file" id="p_scnt" size="20" name="p_scnt_' + i + '" value="" placeholder="Input Value" /></label> <a href="#" id="remScnt"   ><img src="images/Delete.png" width="20" border="0"  /></a></p>').appendTo(scntDiv);
                    $('<div class="form-row row-fluid"><div class="span12"><div class="row-fluid"><label class="form-label span3" for="name">Image ' + i + '</label><div class="grid-inputs span8" ><input type="file" name="fileinput' + i + '" id="fileinput' + i + '" class="nostyle span6" style="margin: 0" /> <a id="remScnt" href="#" class="btn btn-danger" ><i class="icon-remove"></i></a>  </div></div></div></div>').appendTo(scntDiv);

                    i++;
                    //                                                        

                    return false;
                });

                $('#remScnt').live('click', function() {
                    if (i > 2) {
                        //  $(this).parents('p').remove();
                        $(this).parent().parent().parent().parent().remove();
                        i--;
                        $.uniform.update();
                    }
                    return false;
                });

                setTimeout("$('.fileIn').uniform();", 200);
            })
                                </script>
                                <div class="form-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <div class="form-actions">
                                                <div class="span3"></div>
                                                <div class="span9 controls">
                                                    <input type="hidden" name="adId" value="<?= htmlspecialchars($_GET['vid'] ?? '', ENT_QUOTES, 'UTF-8') ?>"/>
                                                    <input type="hidden" name="editbtn" value=""/>
                                                    <button type="submit" class="btn marginR10" name="v_save_image">Save Images</button>
                                                    <button class="btn btn-danger" type="reset">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <? include_once './inc/comman_js.php'; ?>
    </body>
</html>
