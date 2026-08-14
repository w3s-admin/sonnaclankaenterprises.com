<?
require_once '../cpad/vehicleController.php';
$Stock = 1;
$fk_mileage = 1;
$price_type = 1;
CommonBase::IsAdminUser();

$pro_save_msg = $pro_save_msg ?? null;
$last_id = $last_id ?? null;
$vtype = $vtype ?? null;
$Make = $Make ?? null;
$Model = $Model ?? null;
$Modeltxt = $Modeltxt ?? null;
$BodyType = $BodyType ?? null;
$Chasi = $Chasi ?? null;
$fk_engine_capacity = $fk_engine_capacity ?? null;
$Transmission = $Transmission ?? null;
$FuelType = $FuelType ?? null;
$BaseColur = $BaseColur ?? null;
$ym = $ym ?? null;
$km = $km ?? null;
$Category = $Category ?? null;
$reg_num = $reg_num ?? null;
$ho = $ho ?? null;
$Price = $Price ?? null;
$so = $so ?? null;
$so_price = $so_price ?? null;
$ac = $ac ?? null;
$ps = $ps ?? null;
$pw = $pw ?? null;
$pm = $pm ?? null;
$wm = $wm ?? null;
$abs = $abs ?? null;
$alloy = $alloy ?? null;
$airbag = $airbag ?? null;
$r_camera = $r_camera ?? null;
$foglamp = $foglamp ?? null;
$sunroof = $sunroof ?? null;
$leather = $leather ?? null;
$sk = $sk ?? null;
$rw = $rw ?? null;
$tv = $tv ?? null;
$cd = $cd ?? null;
$dvd = $dvd ?? null;
$Options = $Options ?? null;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <? include_once './inc/comman_head_admin.php'; ?>

        <!-- Plugin stylesheets -->


        <link href="plugins/forms/select/select2.css" type="text/css" rel="stylesheet" />
        <link href="plugins/forms/validate/validate.css" type="text/css" rel="stylesheet" />

        <link href="plugins/forms/inputlimiter/jquery.inputlimiter.css" type="text/css" rel="stylesheet" />

        <!-- Form plugins -->
        <script type="text/javascript" src="plugins/forms/watermark/jquery.watermark.min.js"></script>
        <script type="text/javascript" src="plugins/forms/uniform/jquery.uniform.min.js"></script>
        <script type="text/javascript" src="plugins/forms/select/select2.min.js"></script>
        <script type="text/javascript" src="plugins/forms/validate/jquery.validate.min.js"></script>
        <script type="text/javascript" src="plugins/forms/inputlimiter/jquery.inputlimiter.1.3.min.js"></script>

        <script type="text/javascript" src="plugins/forms/ibutton/jquery.ibutton.min.js"></script>
        <link href="plugins/forms/ibutton/jquery.ibutton.css" type="text/css" rel="stylesheet" />

        <script type="text/javascript" src="plugins/forms/validation-engine/jquery.validationEngine.js"></script>
        <link href="plugins/forms/validation-engine/css/validationEngine.jquery.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="plugins/forms/validation-engine/languages/jquery.validationEngine-en.js"></script>

        <script type="text/javascript">
            $(function() {
//                $("#form_validate_addpro").validate({
//                    ignore: null,
//                    ignore: 'input[type="hidden"]',
//                            rules: {
//                        validate[required]1: {
//                            validate[required]: true,
//                            minlength: 4
//                        },
//                        email: {
//                            validate[required]: true,
//                            email: true
//                        }
//                    }
//                });



                $("#form_validate_addpro").validationEngine({
                });

                if ($('textarea').hasClass('limit')) {
                    $('.limit').inputlimiter({
                        limit: 250
                    });
                }


                $(".ibutton").iButton({
                    duration: 200                           // the speed of the animation 
                            , easing: "swing"                         // the easing animation to use 
                            , labelOn: "YES"                           // the text to show when toggled on 
                            , labelOff: "NO"                         // the text to show when toggled off 
                            , resizeHandle: "off"                    // determines if handle should be resized 
                            , resizeContainer: "auto"                 // determines if container should be resized 
                            , enableDrag: true                        // determines if we allow dragging 
                            , enableFx: true                          // determines if we show animation 
                            , allowRadioUncheck: false                // determine if a radio button should be able to 
                            // be unchecked 
                            , clickOffset: 120                        // if millseconds between a mousedown & mouseup event this 
                            // value, then considered a mouse click 

                });

                $("#Make").change(function() {

                    $.post("../ajx/ajax_select_contraller.php", {id: $(this).val(), data: 'main'},
                    function(data) {
                        $('#Model').find('option').remove();
                        $("#Model").append(data);
                    }
                    );

                });

                $(".select_2_select").select2();

            });
        </script>
        <script type="text/javascript" src="js/ajxupload_quary.js" ></script>
        <style>
            .stock_select{
                  user-select: none;
            }
        </style>
    </head>

    <body>

        <!-- loading animation -->
        <div id="qLoverlay"></div>
        <div   id="qLbar"></div>


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

                        <h3>Add Property</h3>                    

                        <div class="resBtnSearch">
                            <a href="#"><span class="icon16 icomoon-icon-search-3"></span></a>
                        </div>

                        <?
                        include_once './inc/search.php';
                        ?>

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
                            <li class="active">Property Adding</li>
                        </ul>

                    </div><!-- End .heading-->

                    <!-- Build page from here: -->
                    <div class="row-fluid">

                        <div class="span10">

                            <div class="box">

                                <div class="title">

                                    <h4> 
                                        <span>Complete below fields</span>
                                    </h4>

                                </div>
                                <div class="content">
                                    <div>
                                        <?= ($pro_save_msg != NULL) ? "$pro_save_msg" : "" ?>
                                        <?= (isset($_GET['shop_save_msg'])) ? CommonBase::decrypt($_GET['shop_save_msg']) : "" ?>
                                    </div>
                                    <?
                                    if (!is_numeric($last_id)) {
                                        ?>
                                        <form class="form-horizontal" id="form_validate_addpro" action=""  enctype="multipart/form-data"  method="post">
                                            <div class="form-row row-fluid">
                                                <div class="span12">
                                                    <div class="row-fluid">
                                                        <label class="form-label span3  red"  for="name">Stock</label>
                                                        <div class="span5 controls sel" >
                                                            <?= Vehicle::createSelect($Stock, "Stock", 0, "required nostyle validate[required] stock_select", "Please select Stock", 
                                                            "select Id , name from stock WHERE status = 1 ORDER by Id asc" , false) ?>
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
                                                                    ${'Make'}, $name = 'Make', $type = 6, $class = "validate[required]", $title = "", $q = "select Id , name from make WHERE status = 1 ORDER by Id asc", $word = "Select Make", $style = "width:100%;", false
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
                                                                        <?= CommonBase::createSelectAjxSearch(${'Model'}, ${'Make'}, "select Id,name from model WHERE fk_make = ? and status =1", "fk_model", "Price Per") ?>

                                                                    </select> </div>

                                                            </div>
                                                            <div class="span4">
                                                                <input type="text" name="Modeltxt" id="Modeltxt" class="validate[required]" title="Please Add Model" value="<?= $Modeltxt ?>" />
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
                                                            <input type="text" name="Chasi" id="Chasi" class="validate[required]"  title="Please Select Chasi" value="<?= $Chasi ?>"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="form-row row-fluid">
                                                <div class="span12">
                                                    <div class="row-fluid">
                                                        <label class="form-label span3 red" for="validate[required]">Engine Capacity</label>

                                                        <div class="grid-inputs span5 ">
                                                        <?= Vehicle::createSelect($fk_engine_capacity, "fk_engine_capacity", 0, "validate[required] nostyle", "Please select Body Type", "select Id , name from engine_capacity WHERE `_status` = 1 ORDER by Id asc") ?>

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
                                                            <input type="text" name="ym" id="ym" class="validate[required]"  title="Please Select Year &amp; Month " value="<?= $ym ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="form-row row-fluid">
                                                <div class="span12">
                                                    <div class="row-fluid">
                                                        <label class="form-label span3 red" for="phone">Mileage</label>
                                                        <div class="grid-inputs span6 controls">
                                                            <div class="span6"><div class="span11 controls">
                                                                    <input type="text" name="km" id="km" class="validate[required]"  title="Please Select Mileage"  value="<?= $km ?>"/> </div>

                                                            </div>
                                                            <div class="span4">
                                                                <?= Vehicle::createSelect($fk_mileage, "fk_mileage", 0, "validate[required] nostyle", "Please select mileage ", "select Id , name from mileage WHERE status = 1 ORDER by Id asc", true) ?>
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
                                            <!-- <div class="form-row row-fluid">
                                                <div class="span12">
                                                    <div class="row-fluid">
                                                        <label class="form-label span3 " for="phone">Registration #</label>
                                                        <div class="left marginR10 span5">
                                                            <input type="text" name="reg_num" id="reg_num"   value="<?= $reg_num ?>"  />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  -->
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
                                                            <div class="span3"  >
                                                                <div class="controls span11"> 
                                        <?= Vehicle::createSelect($price_type, "price_type", 0, "validate[required] nostyle", "Please select Price Type", "select Id , name from price_type WHERE status = 1 ORDER by Id asc", true ) ?></div>
                                                            </div>
                                                            <div class="span4" >
                                                                <input  type="text" name="Price" id="Price" class="validate[required] span11"  title="Please Add Price" value="<?= $Price ?>"/>     
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
                                                                <input type="text" name="so_price" class="validate[condRequired[so]]" id="so_price" value="<?= $so_price ?>" />
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
                                                                            <input type="checkbox" name="ac" class="ibutton nostyle" value="1" <?= CommonBase::checked($ac) ?> checked/>
                                                                        </div>
                                                                        <div class="span4">
                                                                            <label class="form-label span6 " for="phone">PS</label>
                                                                            <input type="checkbox" name="ps"  class="ibutton nostyle" value="1"  <?= CommonBase::checked($ps) ?> checked/>
                                                                        </div>

                                                                    </div>
                                                                    <div class="row-fluid">

                                                                        <div class="span4">
                                                                            <label class="form-label span6 " for="phone">PW</label>
                                                                            <div class="controls"> <input type="checkbox" name="pw"  class="ibutton nostyle" value="1" <?= CommonBase::checked($pw) ?> checked/>
                                                                        </div>

                                                                        </div>
                                                                        <div class="span4">
                                                                            <label class="form-label span6 " for="phone">PM</label>
                                                                            <input type="checkbox" name="pm"  class="ibutton nostyle" value="1"  <?= CommonBase::checked($pm) ?> checked/>
                                                                        </div>
                                                                        <div class="span4">
                                                                            <label class="form-label span6 " for="phone">Winker M</label>
                                                                            <input type="checkbox" name="wm"  class="ibutton nostyle" value="1" <?= CommonBase::checked($wm) ?> checked/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row-fluid">
                                                                        <div class="span4">
                                                                            <label class="form-label span6 " for="phone">ABS</label>
                                                                            <input type="checkbox" name="abs"  class="ibutton nostyle" value="1" <?= CommonBase::checked($abs) ?> checked/>
                                                                        </div>
                                                                        <div class="span4">
                                                                            <label class="form-label  span6" for="phone">Alloy Wheels </label>
                                                                            <input type="checkbox" name="alloy"  class="ibutton nostyle" value="1"  <?= CommonBase::checked($alloy) ?> checked/>
                                                                        </div>
                                                                        <div class="span4">
                                                                            <label class="form-label span6 " for="phone">Air bag </label>
                                                                            <input type="checkbox" name="airbag"  class="ibutton nostyle" value="1"  <?= CommonBase::checked($airbag) ?> checked/>
                                                                        </div>

                                                                    </div>
                                                                    <div class="row-fluid">
                                                                        <div class="span4">
                                                                            <label class="form-label span6 " for="phone">R-Camera</label>
                                                                            <input type="checkbox" name="r_camera"  class="ibutton nostyle" value="1" <?= CommonBase::checked($r_camera) ?> checked/>
                                                                        </div>
                                                                        <div class="span4">
                                                                            <label class="form-label span6 " for="phone">Foglamp</label>
                                                                            <input type="checkbox" name="foglamp"  class="ibutton nostyle" value="1"  <?= CommonBase::checked($foglamp) ?> checked/>
                                                                        </div>
                                                                        <div class="span4">
                                                                            <label class="form-label span6 " for="phone">Sunroof</label>
                                                                            <input type="checkbox" name="sunroof"  class="ibutton nostyle" value="1" <?= CommonBase::checked($sunroof) ?> checked/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row-fluid">

                                                                        <div class="span4">
                                                                            <label class="form-label span6 " for="phone">Leather Seat</label>
                                                                            <input type="checkbox" name="leather"  class="ibutton nostyle" value="1" <?= CommonBase::checked($leather) ?> checked/>
                                                                        </div>
                                                                        <div class="span4">
                                                                            <label class="form-label span6 " for="phone">Smart Key</label>
                                                                            <input type="checkbox" name="sk"  class="ibutton nostyle" value="1" <?= CommonBase::checked($sk) ?> checked/>
                                                                        </div>
                                                                        <div class="span4">
                                                                            <label class="form-label span6 " for="phone">Rear Wiper</label>
                                                                            <input type="checkbox" name="rw"  class="ibutton nostyle" value="1"  <?= CommonBase::checked($rw) ?> checked/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row-fluid">

                                                                        <div class="span4">
                                                                            <label class="form-label span6 " for="phone">TV</label>
                                                                            <input type="checkbox" name="tv"  class="ibutton nostyle" value="1" <?= CommonBase::checked($tv) ?> checked/>
                                                                        </div>
                                                                        <div class="span4">
                                                                            <label class="form-label span6 " for="phone">CD</label>
                                                                            <input type="checkbox" name="cd"  class="ibutton nostyle" value="1" <?= CommonBase::checked($cd) ?> checked/>
                                                                        </div>

                                                                        <div class="span4">
                                                                            <label class="form-label span6 " for="phone">DVD</label>
                                                                            <input type="checkbox" name="dvd"  class="ibutton nostyle" value="1" <?= CommonBase::checked($dvd) ?> checked/>
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
                                                            <textarea name="Options" id="Options" cols="" rows="5" class="span12 uniform"><?= $Options ?></textarea>
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
                                                                <button type="submit" class="btn marginR10" name="carsale_addvehicle">Save changes</button>
                                                                <button class="btn btn-danger" type="reset">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>




                                        </form>
                                    </div> 
                                <? } else { ?>
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
                                                    $('<div class="form-row row-fluid"><div class="span12"><div class="row-fluid"><label class="form-label span3" for="name">Image ' + i + '</label><div class="grid-inputs span8" ><input type="file" name="fileinput' + i + '" id="fileinput' + i + '" class="nostyle span5" style="margin: 0" /> <a id="remScnt" href="#" class="btn btn-danger" ><i class="icon-remove"></i></a>  </div></div></div></div>').appendTo(scntDiv);

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
                                                            <input type="hidden" name="adId" value="<?= CommonBase::encrypt($last_id) ?>"/>
                                                            <button type="submit" class="btn marginR10" name="v_save_image">Save Images</button>
                                                            <button class="btn btn-danger" type="reset">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    </form>
                                <? } ?>
                            </div>
                        </div></div>
                </div><!-- End .row-fluid -->
                <!--End page -->

            </div><!-- End contentwrapper -->
        </div><!-- End #content -->

        </div><!-- End #wrapper -->

        <? include_once './inc/comman_js.php'; ?>


    </body>
</html>
