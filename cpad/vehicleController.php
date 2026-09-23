<?php

// $stmt = $dbh->prepare("INSERT INTO paddle(paddlenumber,fk_auction,fk_customer,fk_admin) VALUES(?,?,?,?)");
//            $stmt->execute(array($Paddle,$aucid,$cid,$admin));
//            $lastID = $dbh->lastInsertId();

require_once 'clsVehicle.php';
require_once 'clsCommonBase.php';
require_once 'common/HTTP_Upload.php';
require_once 'Thumbnail.class.php';
require_once 'clsFrontVehicle.php';
require_once 'clsS3Storage.php';


$myCon = new ControlPadDB;

$dbh = $myCon->dbh;

// The site now only prices in Rs, so there's nothing for the admin to pick -
// this resolves the one active price_type row server-side instead of
// depending on a form field (see the Price Type dropdown removed from
// vehicle_add.php/vehicle_edit.php/vehicle_sell.php).
function getDefaultPriceTypeId($dbh) {
    static $id = null;
    if ($id === null) {
        $row = $dbh->query("SELECT Id FROM price_type WHERE status = 1 ORDER BY Id ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        $id = $row ? (int) $row['Id'] : null;
    }
    return $id;
}

// Every action this file handles below (add/edit/delete vehicle, image and
// document management, sale/customer assignment, internal search) is an
// admin-only mutation or admin-only internal lookup. This file is loaded
// unconditionally by public-facing pages (for the Vehicle/FrontVehicle
// classes and $dbh), so a hard authentication gate is required here -
// scoped to POST requests and the recognised admin-only GET actions only,
// so a normal anonymous page view (a GET request with none of these keys)
// is completely unaffected.
$isAdminOnlyRequest = ($_SERVER['REQUEST_METHOD'] === 'POST') || isset($_GET['carsale_search']);
if ($isAdminOnlyRequest) {
    CommonBase::IsAdminUser();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        CommonBase::requireValidCsrf();
    }
}

// These are rendered as raw, unescaped HTML by the admin pages that include
// this controller. Pre-declaring them means extract(..., EXTR_SKIP) below
// will never let a crafted query string / form field set them directly -
// they can only end up populated by this file's own trusted code further
// down (which builds them from CommonBase::createMassageDiv()/createnotify(),
// not from raw request input).
$shop_save_msg = null;
$pro_save_msg = null;
$del_msg = null;
$shop_del_msg = null;
$email_msg = null;
$errmsg = null;

extract($_POST, EXTR_SKIP);
extract($_GET, EXTR_SKIP);

// Unchecked checkboxes (so, ho, ac, ps, pw, pm, abs, tv, cd, dvd, alloy,
// airbag, r_camera, foglamp, sunroof, leather, wm, rw, sk, reg) are simply
// absent from $_POST - standard HTML form behavior, not a bug - and several
// other fields are only present on some of this file's request types. On
// PHP 8 that turns into a screenful of "Undefined variable" warnings on
// every submit (harmless to the actual save, but they were always there;
// PHP 8 just stopped staying quiet about it). `??=` fills each with null
// without ever overriding a value that WAS submitted.
$Stock ??= null;
$vtype ??= null;
$Make ??= null;
$Model ??= null;
$Modeltxt ??= null;
$BodyType ??= null;
$Chasi ??= null;
$fk_engine_capacity ??= null;
$Transmission ??= null;
$FuelType ??= null;
$BaseColur ??= null;
$ActualColour ??= null;
$Grade ??= null;
$ym ??= null;
$km ??= null;
$Price ??= null;
$Category ??= null;
$reg ??= null;
$reg_num ??= null;
$so ??= null;
$so_price ??= null;
$ho ??= null;
$ac ??= null;
$ps ??= null;
$pw ??= null;
$pm ??= null;
$abs ??= null;
$tv ??= null;
$cd ??= null;
$dvd ??= null;
$alloy ??= null;
$airbag ??= null;
$r_camera ??= null;
$foglamp ??= null;
$sunroof ??= null;
$leather ??= null;
$wm ??= null;
$rw ??= null;
$sk ??= null;
$Options ??= null;
$ref ??= null;
$price_type ??= null;
$fk_mileage ??= null;
$sellp ??= null;
$img_id ??= null;
$imgt ??= null;
$customerId ??= null;
$sp ??= null;
$invprice ??= null;
$search ??= null;
$searchtext ??= null;
$con_uncon ??= null;
$carsale ??= null;
$key ??= null;
$chasi ??= null;
$id ??= null;
$std ??= null;
$ed ??= null;
$ref_cl ??= null;
$docId ??= null;
$name ??= null;
$Id ??= null;
$adId ??= null;
$editbtn ??= null;
$vid ??= null;
$viddel ??= null;
$ys ??= null;
$ye ??= null;


if (isset($_POST['carsale_addvehicle'])) {

//    var_dump(CommonBase::decrypt($Category));
$EngineCapacity = CommonBase::decrypt(${'fk_engine_capacity'});
    if (!is_numeric(CommonBase::decrypt($vtype)) ||
            $Stock == null ||
            $Make == null ||
            $vtype == null ||
            $Model == null ||
            $BodyType == null ||
            $Chasi == null ||
            $EngineCapacity == null ||
            ($EngineCapacity != null && !is_numeric($EngineCapacity)) ||
            $Transmission == null ||
            $FuelType == null ||
            $BaseColur == null ||
            $ym == null ||
            $km == null ||
            $Category == null ||
            ($km != null && !is_numeric($km)) ||
          
            ($reg == "1" && $reg_num == null)
    ) {
        $pro_save_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Invalid Fields !", $massage = '', 100);
 
    } elseif (($so == 1 && $so_price == null)) {
        $pro_save_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Please Add Special Offer Amount !", $massage = '', 100);
    } elseif (($so == null && $so_price != null)) {
        $pro_save_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Please Add Special Offer Tick !", $massage = '', 100);
    } else {
        $allfiles = $allfiles ?? array();
        $img1 = $allfiles[0] ?? "na.jpg";
        $img2 = $allfiles[1] ?? "na.jpg";
        $img3 = $allfiles[2] ?? "na.jpg";
        $img4 = $allfiles[3] ?? "na.jpg";
        $imgp = "admincontent/vimg/";
        $keywd =
                Vehicle::getname(CommonBase::decrypt($vtype), "type") . ", " .
                Vehicle::getname(CommonBase::decrypt($Make), "make") . ", " .
                Vehicle::getname(CommonBase::decrypt($Model), "model") . ", " .
                Vehicle::getname(CommonBase::decrypt($BodyType), "body_type") . " ," .
                Vehicle::getname(CommonBase::decrypt($Transmission), "transmission") . ", " .
                Vehicle::getname(CommonBase::decrypt($BaseColur), "colour") . " ";

        $quary = "INSERT INTO advert (fk_carsales,fk_stock,fk_type, fk_make, fk_model, modeltxt, 
            fk_body_type, chasi, fk_engine_capacity, fk_transmission, fk_fuel, hybrid, fk_color, acolor, grade, 
            yearmonth, mileage, price, highestoffer, ac, ps, pw, pm, `abs`, tv, cd, dvd, aw, airbag, 
            r_camera, foglamp, sunroof, leather, winkermirror, rearwiper, skey, other_op, imgpath, 
            image1, image2, image3, image4, available, active, status, addu, addt, search,`ref` , fk_category,registed_number,fk_price_type,special_offer,special_offer_price,fk_mileage) 
            VALUES (?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 1, 1, ?, ?,? ,?,?,?,?,?,?,?)";
        $stmt = $dbh->prepare($quary);

        $done = $stmt->execute(array(
            0,
            CommonBase::decrypt($Stock),
            CommonBase::decrypt($vtype),
            CommonBase::decrypt($Make),
            CommonBase::decrypt($Model),
            $Modeltxt,
            CommonBase::decrypt($BodyType),
            $Chasi,
            $EngineCapacity,
            CommonBase::decrypt($Transmission),
            CommonBase::decrypt($FuelType),
            0,
            CommonBase::decrypt($BaseColur),
            $ActualColour,
            $Grade,
            $ym,
            $km,
            $Price,
            CommonBase::chktoDB($ho),
            CommonBase::chktoDB($ac),
            CommonBase::chktoDB($ps),
            CommonBase::chktoDB($pw),
            CommonBase::chktoDB($pm),
            CommonBase::chktoDB($abs),
            CommonBase::chktoDB($tv),
            CommonBase::chktoDB($cd),
            CommonBase::chktoDB($dvd),
            CommonBase::chktoDB($alloy),
            CommonBase::chktoDB($airbag),
            CommonBase::chktoDB($r_camera),
            CommonBase::chktoDB($foglamp),
            CommonBase::chktoDB($sunroof),
            CommonBase::chktoDB($leather),
            CommonBase::chktoDB($wm),
            CommonBase::chktoDB($rw),
            CommonBase::chktoDB($sk),
            $Options,
            $imgp,
            $img1,
            $img2,
            $img3,
            $img4,
            CommonBase::IsAdminUser()['Id'],
            CommonBase::getcurrenttime(),
            $keywd,
            $ref,
            CommonBase::decrypt($Category),
            $reg_num,
            getDefaultPriceTypeId($dbh),
            $so,
            $so_price,
            CommonBase::decrypt($fk_mileage),
        ));
        // var_dump($done);exit;
        if ($done) {
            $last_id = $dbh->lastInsertId();
            $pro_save_msg =
                    CommonBase::createMassageDiv(
                            $type = 'suc', $headding = "Vehicle Added", $massage = 'Please Add Images for Vehicle', 100);
        }
    }
}

if (isset($_POST['v_save_image'])) {

    $last_id = CommonBase::decrypt($adId);

    if (is_numeric($last_id)) {
        $upload = new http_upload('en');
        $file = $upload->getFiles();
        $allfiles = array();
        $fcount = FALSE;
        foreach ($file as $currentFile) {
            $t = array("jpg", "png", "gif", "webp", "JPG", "JPEG");
            //$currentFile->_chmod
            $currentFile->setValidExtensions($t, $mode = 'accept');
            if (PEAR::isError($currentFile)) {
                //error of file
            } elseif ($currentFile->isValid()) {
                $currentFile->setName('real');
                //   $final_dir = $this->getDir($posision_cr);

                $dest_dir = '../admincontent/v_img/default/';
                if (@!is_dir($dest_dir)) {
                    mkdir($dest_dir);
                }
                $dest_name = $currentFile->moveTo($dest_dir);
                if (PEAR::isError($dest_name)) {
                    //  $this->setError($dest_name->getMessage());
                    error_log('File upload error: ' . $dest_name->getMessage());
                } else {
                    $realname = $currentFile->getProp('real');
                    $imgfullPath = $dest_dir . $dest_name;
                    $arr_f['name'] = $dest_name;
                    $arr_f['path'] = $dest_dir;
                    array_push($allfiles, $arr_f);
                    $fcount = true;
                }
            } else {
                //no file
            }
        }

        if (empty($allfiles)) {
            // Previously silent: a rejected/failed upload (wrong file type,
            // nothing selected, move-to-disk failure) left $allfiles empty,
            // so the code below - which only ever reports success and only
            // runs inside a loop over $allfiles - had nothing to say, and
            // the page just re-rendered with no indication anything went
            // wrong. Surface it instead of leaving the admin guessing.
            $shop_save_msg = CommonBase::createMassageDiv(
                    $type = 'err', $headding = 'Image Not Saved',
                    $massage = 'No image was uploaded. Check that a file was selected and that it is a JPG, PNG, GIF or WEBP.', 150);
        }

        $stmt = $dbh->prepare("Insert into advert_images(fk_advert,image_name,mpath,tpath,`_status`) VALUES(?,?,?,?,1)");
        foreach ($allfiles as $key => $value) {
            if (file_exists($value['path'] . $value['name'])) {
                $tempName = $value['name'];
                $thumb = new Thumbnail($value['path'] . $value['name']);         // Contructor and set source image file
                $thumb->img_watermark = "../" . $_SESSION['app_pro']['img_watermark_thumb'];     // [OPTIONAL] set watermark source file, only PNG format [RECOMENDED ONLY WITH GD 2 ]
                $thumb->size(350, 200);                  // [OPTIONAL] set the biggest width and height for thumbnail
                $thumb->quality = 90;
                $thumb->img_watermark_Valing = 'BOTTOM';        // [OPTIONAL] set watermark vertical position, TOP | CENTER | BOTTOM
                $thumb->img_watermark_Haling = 'RIGHT';
                $thumb->process();               // generate image
                $thumbLocalPath = "../admincontent/v_img/thumb/" . $tempName;
                $status = $thumb->save($thumbLocalPath);            // save your thumbnail to file
                if ($status) {
                    $tempName = $value['name'];
                    $thumb = new Thumbnail($value['path'] . $value['name']);         // Contructor and set source image file
                    $thumb->img_watermark = "../" . $_SESSION['app_pro']['img_watermark'];       // [OPTIONAL] set watermark source file, only PNG format [RECOMENDED ONLY WITH GD 2 ]
                    $thumb->size(1140, 660);                  // [OPTIONAL] set the biggest width and height for thumbnail
                    $thumb->quality = 90;
                    $thumb->img_watermark_Valing = 'BOTTOM';        // [OPTIONAL] set watermark vertical position, TOP | CENTER | BOTTOM
                    $thumb->img_watermark_Haling = 'RIGHT';
                    $thumb->process();               // generate image
                    $mainLocalPath = "../admincontent/v_img/" . $tempName;
                    $status = $thumb->save($mainLocalPath);            // save your thumbnail to file
                }

                // S3 when configured (see cpad/clsS3Storage.php); falls back
                // to the existing local admincontent/ storage otherwise, so
                // this keeps working in environments without S3 set up.
                $mpath = "admincontent/v_img/";
                $tpath = "admincontent/v_img/thumb/";
                if (S3Storage::isConfigured() && $status) {
                    $mainUpload = S3Storage::uploadSplit($mainLocalPath, 'vehicles/main', $tempName, 'image/jpeg');
                    $thumbUpload = S3Storage::uploadSplit($thumbLocalPath, 'vehicles/thumb', $tempName, 'image/jpeg');
                    if ($mainUpload && $thumbUpload) {
                        $mpath = $mainUpload['path'];
                        $tpath = $thumbUpload['path'];
                        @unlink($mainLocalPath);
                        @unlink($thumbLocalPath);
                    }
                }

                $done = $stmt->execute(array($last_id, $tempName, $mpath, $tpath));
                if ($done) {
                    unlink('../admincontent/v_img/default/' . $tempName);
                }
            }
            if ($done) {
                $addedIdTemp = CommonBase::encrypt($dbh->lastInsertId());
                $shop_save_msg = CommonBase::createMassageDiv(
                                $type = 'suc', $headding = 'Successfully added', $massage = 'Advert published successfully ', 150);
                if (isset($editbtn)) {
                    $shop_save_msg = CommonBase::createMassageDiv(
                                    $type = 'suc', $headding = 'Successfully Add Image', $massage = 'Advert Image adding successfully finished ', 0);
                } else {
                    // Session flash, not the URL - see CommonBase::encrypt()
                    // for why a query-string-carried "encrypted" HTML blob
                    // is forgeable and must never be trusted as safe markup.
                    $_SESSION['_flash_shop_save_msg'] = $shop_save_msg;
                    CommonBase::SendRedirect("vehicle_add.php");
                }
            }
        }
    }
}

if (isset($_POST['carsale_editvehicle'])) {
    $vid_d = CommonBase::decrypt($vid);
    // Was only ever computed in the Add Vehicle block above, never here -
    // every edit-save hit "$EngineCapacity == null" in the validation below
    // and failed with "Invalid Fields !" regardless of what was actually
    // submitted, since the variable was always undefined on this code path.
    $EngineCapacity = CommonBase::decrypt($fk_engine_capacity);
    if (!is_numeric(CommonBase::decrypt($vtype)) ||
            !is_numeric($vid_d) ||
            $Stock == null ||
            $Make == null ||
            $vtype == null ||
            $Model == null ||
            $BodyType == null ||
            $Chasi == null ||
            $EngineCapacity == null ||
            ($EngineCapacity != null && !is_numeric($EngineCapacity)) ||
            $Transmission == null ||
            $FuelType == null ||
            $BaseColur == null ||
            $ym == null ||
            $km == null ||
            ($km != null && !is_numeric($km)) ||
            ($ho != "1" && $Price == null) ||
            ($reg == "1" && $reg_num == null)
    ) {
        $pro_save_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Invalid Fields !", $massage = '', 100);
//    } elseif (!is_numeric($ref) || Vehicle::isRefAvailableEdit($ref, $vid_d)) {
//        echo CommonBase::jsAlert("invalid Referance !");
    } elseif (($so == 1 && $so_price == null)) {
        $pro_save_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Please Add Special Offer Amount !", $massage = '', 100);
    } elseif (($so == null && $so_price != null)) {
        $pro_save_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Please Add Special Offer Tick !", $massage = '', 100);
    } else {


//        $useradd = CommonBase::getcarsaleIdforadd();
//        if ($utype == "admin") {
//            $useradd = CommonBase::getAdminIdforadd();
//        }
        if ($Price > 0) {
            $ho = 0;
        }

        $keywd =
                Vehicle::getname(CommonBase::decrypt($vtype), "type") . ", " .
                Vehicle::getname(CommonBase::decrypt($Make), "make") . ", " .
                Vehicle::getname(CommonBase::decrypt($Model), "model") . ", " .
                Vehicle::getname(CommonBase::decrypt($BodyType), "body_type") . " ," .
                Vehicle::getname(CommonBase::decrypt($Transmission), "transmission") . ", " .
                Vehicle::getname(CommonBase::decrypt($BaseColur), "colour") . " ";

        $quary = "update advert set fk_carsales=?, fk_stock=?,fk_type=?, fk_make=?, fk_model=?, modeltxt=?, 
            fk_body_type=?, chasi=?, fk_engine_capacity=?, fk_transmission=?, fk_fuel=?, hybrid=?, fk_color=?, acolor=?, grade=?, 
            yearmonth=?, mileage=?, price=?, highestoffer=?, ac=?, ps=?, pw=?, pm=?, `abs`=?, tv=?, cd=?, dvd=?, aw=?, airbag=?, 
            r_camera=?, foglamp=?, sunroof=?, leather=?, winkermirror=?, rearwiper=?, skey=?, other_op=?,  
            updateu=?, updatet=?, search=? , `ref` = ?,    fk_category= ?, registed_number= ?,fk_price_type = ?,
            special_offer=?,special_offer_price=?,fk_mileage=?
            Where `Id` = ?";

        $stmt = $dbh->prepare($quary);

        $done = $stmt->execute(array(
            0,
            CommonBase::decrypt($Stock),
            CommonBase::decrypt($vtype),
            CommonBase::decrypt($Make),
            CommonBase::decrypt($Model),
            $Modeltxt,
            CommonBase::decrypt($BodyType),
            $Chasi,
            $EngineCapacity,
            CommonBase::decrypt($Transmission),
            CommonBase::decrypt($FuelType),
            0,
            CommonBase::decrypt($BaseColur),
            $ActualColour,
            $Grade,
            $ym,
            $km,
            $Price,
            CommonBase::chktoDB($ho),
            CommonBase::chktoDB($ac),
            CommonBase::chktoDB($ps),
            CommonBase::chktoDB($pw),
            CommonBase::chktoDB($pm),
            CommonBase::chktoDB($abs),
            CommonBase::chktoDB($tv),
            CommonBase::chktoDB($cd),
            CommonBase::chktoDB($dvd),
            CommonBase::chktoDB($alloy),
            CommonBase::chktoDB($airbag),
            CommonBase::chktoDB($r_camera),
            CommonBase::chktoDB($foglamp),
            CommonBase::chktoDB($sunroof),
            CommonBase::chktoDB($leather),
            CommonBase::chktoDB($wm),
            CommonBase::chktoDB($rw),
            CommonBase::chktoDB($sk),
            $Options,
            CommonBase::IsAdminUser()['Id'],
            CommonBase::getcurrenttime(),
            $keywd,
            $ref,
            CommonBase::decrypt($Category),
            $reg_num,
            getDefaultPriceTypeId($dbh),
            $so,
            $so_price,
            CommonBase::decrypt($fk_mileage),
            $vid_d
        ));
        if ($done) {
            $shop_save_msg = CommonBase::createMassageDiv(
                            $type = 'suc', $headding = 'Successfully Updated', $massage = 'Advert Updated successfully ', 0);
        }
    }
}

if (isset($_POST['del_adv'])) {
    $id = CommonBase::decrypt($row_id);
    if (is_numeric($id)) {
        $stmt = $dbh->prepare("update advert set `status`= 0,delu=?,delt=? WHERE `Id` = ? ");
        $done = $stmt->execute(array(CommonBase::IsAdminUser()['Id'], CommonBase::getcurrenttime(), $id));
        $img_arr = Vehicle::getAllimages($id);

        foreach ($img_arr as $value) {
            $prv_image = Vehicle::getImageById($value['Id']);
            CommonBase::deleteStoredFile($prv_image['tpath'] . $prv_image['image_name']);
            CommonBase::deleteStoredFile($prv_image['mpath'] . $prv_image['image_name']);
        }
        $stmt = $dbh->prepare("DELETE FROM advert_images WHERE fk_advert = ? ");
        $done = $stmt->execute(array($id));
        $shop_del_msg = CommonBase:: createnotify($type = 'error', $headding = 'Deleted Successfully !', $massage = '', $hide = 'true');

        if ($done) {
            $_SESSION['_flash_del_msg'] = $shop_del_msg;
            CommonBase::SendRedirect("vehicle_manager.php");
        }
    }
}

if (isset($_POST['DelImg'])) {
    $id = CommonBase::decrypt($Id);
    if (is_numeric($id)) {
        $prv_image = Vehicle::getImageById($id);
        $stmt = $dbh->prepare("DELETE FROM advert_images WHERE `Id` = ? ");
        $done = $stmt->execute(array($id));
        if ($done) {
            CommonBase::deleteStoredFile($prv_image['tpath'] . $prv_image['image_name']);
            CommonBase::deleteStoredFile($prv_image['mpath'] . $prv_image['image_name']);
            $shop_save_msg = CommonBase::createMassageDiv(
                            $type = 'suc', $headding = 'Successfully Deleted', $massage = 'Advert Image deleted successfully ', 0);
        }
    }
}

if (isset($_POST['updateImage'])) {

    $id = CommonBase::decrypt($Id);

    if (is_numeric($id)) {
        $upload = new http_upload('en');
        $file = $upload->getFiles();
        $allfiles = array();
        $fcount = FALSE;
        foreach ($file as $currentFile) {
            $t = array("jpg", "png", "gif", "webp", "JPG", "JPEG");
            //$currentFile->_chmod
            $currentFile->setValidExtensions($t, $mode = 'accept');
            if (PEAR::isError($currentFile)) {
                //error of file
            } elseif ($currentFile->isValid()) {
                $currentFile->setName('real');
                //   $final_dir = $this->getDir($posision_cr);

                $dest_dir = '../admincontent/v_img/default/';
                if (@!is_dir($dest_dir)) {
                    mkdir($dest_dir);
                }
                $dest_name = $currentFile->moveTo($dest_dir);
                if (PEAR::isError($dest_name)) {
                    //  $this->setError($dest_name->getMessage());
                    error_log('File upload error: ' . $dest_name->getMessage());
                } else {
                    $realname = $currentFile->getProp('real');
                    $imgfullPath = $dest_dir . $dest_name;
                    $arr_f['name'] = $dest_name;
                    $arr_f['path'] = $dest_dir;
                    array_push($allfiles, $arr_f);
                    $fcount = true;
                }
            } else {
                //no file
            }
        }

        $prv_image = Vehicle::getImageById($id);

        $stmt = $dbh->prepare("Update advert_images SET image_name=? , mpath=?  ,tpath=? , `_status`=1 WHERE `Id` = ?  ");
        foreach ($allfiles as $key => $value) {
            if (file_exists($value['path'] . $value['name'])) {
                $tempName = $value['name'];
                $thumb = new Thumbnail($value['path'] . $value['name']);         // Contructor and set source image file
                $thumb->img_watermark = "../" . $_SESSION['app_pro']['img_watermark_thumb'];     // [OPTIONAL] set watermark source file, only PNG format [RECOMENDED ONLY WITH GD 2 ]
                $thumb->size(350, 200);                  // [OPTIONAL] set the biggest width and height for thumbnail
                $thumb->quality = 90;
                $thumb->img_watermark_Valing = 'BOTTOM';        // [OPTIONAL] set watermark vertical position, TOP | CENTER | BOTTOM
                $thumb->img_watermark_Haling = 'RIGHT';
                $thumb->process();               // generate image
                $thumbLocalPath = "../admincontent/v_img/thumb/" . $tempName;
                $status = $thumb->save($thumbLocalPath);            // save your thumbnail to file
                if ($status) {
                    $tempName = $value['name'];
                    $thumb = new Thumbnail($value['path'] . $value['name']);         // Contructor and set source image file
                    $thumb->img_watermark = "../" . $_SESSION['app_pro']['img_watermark'];       // [OPTIONAL] set watermark source file, only PNG format [RECOMENDED ONLY WITH GD 2 ]
                    $thumb->size(800, 600);                  // [OPTIONAL] set the biggest width and height for thumbnail
                    $thumb->quality = 90;
                    $thumb->img_watermark_Valing = 'BOTTOM';        // [OPTIONAL] set watermark vertical position, TOP | CENTER | BOTTOM
                    $thumb->img_watermark_Haling = 'RIGHT';
                    $thumb->process();               // generate image
                    $mainLocalPath = "../admincontent/v_img/" . $tempName;
                    $status = $thumb->save($mainLocalPath);            // save your thumbnail to file
                }

                $mpath = "admincontent/v_img/";
                $tpath = "admincontent/v_img/thumb/";
                if (S3Storage::isConfigured() && $status) {
                    $mainUpload = S3Storage::uploadSplit($mainLocalPath, 'vehicles/main', $tempName, 'image/jpeg');
                    $thumbUpload = S3Storage::uploadSplit($thumbLocalPath, 'vehicles/thumb', $tempName, 'image/jpeg');
                    if ($mainUpload && $thumbUpload) {
                        $mpath = $mainUpload['path'];
                        $tpath = $thumbUpload['path'];
                        @unlink($mainLocalPath);
                        @unlink($thumbLocalPath);
                    }
                }

                $done = $stmt->execute(array($tempName, $mpath, $tpath, $id));
                if ($done) {
                    unlink('../admincontent/v_img/default/' . $tempName);
                    CommonBase::deleteStoredFile($prv_image['tpath'] . $prv_image['image_name']);
                    CommonBase::deleteStoredFile($prv_image['mpath'] . $prv_image['image_name']);
                }
            }
            if ($done) {
                $shop_save_msg = CommonBase::createMassageDiv(
                                $type = 'suc', $headding = 'Successfully Changed', $massage = 'Advert Image Changed successfully ', 0);
            }
        }
    }
}

if (isset($_POST['carsale_Sell'])) {

    $id = CommonBase::decrypt($_GET['vid']);
    if (
            is_numeric($id) &&
            is_numeric($sellp)
    ) {
        $stmt = $dbh->prepare("UPDATE advert set flow = 2 , selling_price = ? WHERE `Id`=? ");
        $done = $stmt->execute(array($sellp,$id));
        if ($done) {
               $shop_save_msg = CommonBase::createMassageDiv(
                            $type = 'suc', $headding = 'Successfully Updated', $massage = 'Selling price added successfully ', 0);
        }
    }
}

if (isset($_POST['carsale_Sell_remove'])) {

    $id = CommonBase::decrypt($_GET['vid']);
    if (
            is_numeric($id)  
         
    ) {
        $stmt = $dbh->prepare("UPDATE advert set flow = 1  WHERE `Id`=? ");
        $done = $stmt->execute(array($id));
        if ($done) {
               $shop_save_msg = CommonBase::createMassageDiv(
                            $type = 'err', $headding = 'Successfully Removed', $massage = 'Selling price Removed successfully ', 0);
        }
    }
}


if (isset($_POST['remove_other_img'])) {
    $vid_d = CommonBase::decrypt($img_id);
    if (!is_numeric($vid_d)
    ) {
        echo CommonBase::jsAlert("invalid Fields !");
    } else {
        $v = Vehicle::getOtherImgeById($vid_d);
        $p_imgp = $v['image_path'];
        $image = $v['image_name'];
        $img = $allfiles[0] ?? "na.jpg";
        $quary = "update extra_images set `_status` = 0 WHERE `Id`= ?";

        $del_imgurl = "../" . $p_imgp . $image;
        $stmt = $dbh->prepare($quary);
        $done = $stmt->execute(array($vid_d));
        if ($done) {
            if ($image != "na.jpg") {
                unlink($del_imgurl);
            }
            echo CommonBase::jsAlert("Image Removed.");
            echo CommonBase::gotopage(CommonBase::full_SiteUrl() . "#tabs-2");
        }
    }
}
if (isset($_POST['changimages_other'])) {
    $upload = new http_upload('en');
    $file = $upload->getFiles();
    $allfiles = array();
    $fcount = FALSE;
    foreach ($file as $currentFile) {
        $t = array("jpg", "png", "gif", "webp", "JPG", "JPEG");
        //$currentFile->_chmod
        $currentFile->setValidExtensions($t, $mode = 'accept');
        if (PEAR::isError($currentFile)) {
            //error of file
        } elseif ($currentFile->isValid()) {
            $currentFile->setName('real');
            //   $final_dir = $this->getDir($posision_cr);

            $dest_dir = '../admincontent/vimg/';
            if (@!is_dir($dest_dir)) {
                mkdir($dest_dir);
            }
            $dest_name = $currentFile->moveTo($dest_dir);
            if (PEAR::isError($dest_name)) {
                //  $this->setError($dest_name->getMessage());
                var_dump($dest_name->getMessage());
            } else {
                $realname = $currentFile->getProp('real');
                $imgfullPath = $dest_dir . $dest_name;
                array_push($allfiles, $dest_name);
                $fcount = true;
            }
        } else {
            //no file
        }
    }

    $vid_d = CommonBase::decrypt($img_id);
    if (!is_numeric($vid_d) ||
            ($allfiles[0] ?? null) == null
    ) {
        echo CommonBase::jsAlert("invalid Fields !");
    } else {
        $v = Vehicle::getOtherImgeById($vid_d);
        $p_imgp = $v['image_path'];
        $image = $v['image_name'];
        $img = $allfiles[0] ?? "na.jpg";
        $quary = "update extra_images set image_name = ? WHERE `Id`= ?";
        $del_imgurl = "../" . $p_imgp . $image;
        $stmt = $dbh->prepare($quary);
        $done = $stmt->execute(array($img, $vid_d));
        if ($done) {
            if ($image != "na.jpg") {
                unlink($del_imgurl);
            }
            echo CommonBase::jsAlert("Image Changed.");
            echo CommonBase::gotopage(CommonBase::full_SiteUrl() . "#tabs-2");
        }
    }
}
if (isset($_POST['add_otherImages'])) {

    $upload = new http_upload('en');
    $file = $upload->getFiles();
    $allfiles = array();
    $fcount = FALSE;
    foreach ($file as $currentFile) {
        $t = array("jpg", "jpeg", "webp", "JPG", "JPEG");
        //$currentFile->_chmod
        $currentFile->setValidExtensions($t, $mode = 'accept');
        if (PEAR::isError($currentFile)) {
            //error of file
        } elseif ($currentFile->isValid()) {
            $currentFile->setName('real');
            //   $final_dir = $this->getDir($posision_cr);

            $dest_dir = '../admincontent/vimg/';
            if (@!is_dir($dest_dir)) {
                mkdir($dest_dir);
            }
            $dest_name = $currentFile->moveTo($dest_dir);
            if (PEAR::isError($dest_name)) {
                //  $this->setError($dest_name->getMessage());
                var_dump($dest_name->getMessage());
            } else {
                $realname = $currentFile->getProp('real');
                $imgfullPath = $dest_dir . $dest_name;
                array_push($allfiles, $dest_name);
                $fcount = true;
            }
        } else {
            //no file
        }
    }

    $vid_d = CommonBase::decrypt($vid);
    if (!is_numeric($vid_d) ||
            ($allfiles[0] ?? null) == null
    ) {
        echo CommonBase::jsAlert("No Image Selected !");
    } else {

        $img = $allfiles[0] ?? "na.jpg";
        $quary = "insert into extra_images(image_name,`_status`,fk_advert) VALUES(?,1,?)";
        $stmt = $dbh->prepare($quary);
        foreach ($allfiles as $file) {
            $done = $stmt->execute(array($file, $vid_d));
        }
        if ($done) {
            echo CommonBase::jsAlert("Image Added.");

            echo (CommonBase::getCurrentPage('onlypage') == 'edit_vehicle.php') ? CommonBase::gotopage(CommonBase::full_SiteUrl() . "#tabs-1") : CommonBase::gotopage(CommonBase::getCurrentPage());
        }
    }
}





if (isset($_POST['confirmPayment'])) {

    $vdetails = Vehicle::getVehicle(CommonBase::decrypt($vid));

    if (
            ($vid == NULL && !is_numeric(CommonBase::decrypt($vid)))
    ) {
        echo CommonBase::jsAlert("Invalid Entry !");
    } else {
//        var_dump($con_uncon."-update advert set balance_paid = '1'  WHERE `Id` = ? ".$vid);
//        exit();
        $time = CommonBase::getcurrenttime();
        $id = CommonBase::getcarsaleId();
        if ($con_uncon == "CONFIRM") {
            $stmt = $dbh->prepare(" update advert set balance_paid = '1'  WHERE `Id` = ?");
        }
        if ($con_uncon == "UNCONFIRM") {
            $stmt = $dbh->prepare(" update advert set balance_paid = '0'  WHERE `Id` = ?");
        }
        $done = $stmt->execute(array($vdetails['Id']));
        if ($done) {
            echo CommonBase::jsAlert("Payment Details Updated Susesfully");
            echo CommonBase::refreshMother("customer_search.php?&search=$search&searchtext=$searchtext");
            echo CommonBase::closeWindow();
        }
    }
}
if (isset($_POST['carsale_getVehicle'])) {

    if (!is_numeric($ref_cl)) {
        echo CommonBase::jsAlert("invalid Ref Please Add Ref !");
    } else {
        $veh = Vehicle::getVehicle_cl($ref_cl);
        // var_dump($veh);
    }
}
if (isset($_POST['r_doc'])) {

    $id = CommonBase::decrypt($docId);
    if (!is_numeric($id)) {
        echo CommonBase::jsAlert("invalid Fields !");
    } else {
        $stmt = $dbh->prepare("update documents set `_status` = '0' WHERE `Id` = ?");
        $done = $stmt->execute(array($id));
        if ($done) {
            $doc = Vehicle::getDocumentByID($id);
            unlink('../admincontent/uploded_docs/' . $doc['filename']);
            echo CommonBase::jsAlert("File Removed");
            echo CommonBase::gotopage(CommonBase::full_SiteUrl());
        }
    }
}
if (isset($_POST['adddoc'])) {
    $upload = new http_upload('en');
    $file = $upload->getFiles();
    $allfiles = array();
    $fcount = FALSE;
    foreach ($file as $currentFile) {
        $t = array("jpg", "png", "gif", "webp", "zip", "doc", "docx", "xls", "xlsx", "pdf", "xps");
        //$currentFile->_chmod
        $currentFile->setValidExtensions($t, $mode = 'accept');
        if (PEAR::isError($currentFile)) {
            // echo CommonBase::jsAlert(PEAR::isError($currentFile));
            //error of file
        } elseif ($currentFile->isValid()) {
            $currentFile->setName('real');
            //   $final_dir = $this->getDir($posision_cr);

            $dest_dir = '../admincontent/uploded_docs/';
            if (@!is_dir($dest_dir)) {
                mkdir($dest_dir);
            }
            $dest_name = $currentFile->moveTo($dest_dir);
            if (PEAR::isError($dest_name)) {
                //  $this->setError($dest_name->getMessage());
                var_dump($dest_name->getMessage());
            } else {
                $realname = $currentFile->getProp('real');
                $imgfullPath = $dest_dir . $dest_name;
                array_push($allfiles, $dest_name);
                $fcount = true;
            }
        } else {
            //no file
        }
    }

    if ($fcount) {
        $vid_d = CommonBase::decrypt($vid);
        if (!is_numeric($vid_d) ||
                $name == "" ||
                ($allfiles[0] ?? null) == null
        ) {
            echo CommonBase::jsAlert("invalid Fields !");
        } else {
            $time = CommonBase::getcurrenttime();
            $id = CommonBase::getcarsaleId();
            $stmt = $dbh->prepare("Insert into documents(fk_advert,`name`, filepath,filename,`_status`,addu,addt ) VALUES(?,?,?,?,1,?,? )");
            $done = $stmt->execute(array($vid_d, $name, "admincontent/uploded_docs/", $allfiles[0], $id, $time));
            if ($done) {
                echo CommonBase::jsAlert("File Added ");
                echo CommonBase::gotopage(CommonBase::full_SiteUrl());
            }
        }
    }
}
if (isset($_POST['changecustomer'])) {
    $vdetails = Vehicle::getVehicle(CommonBase::decrypt($vid));
    $pp = $vdetails['purchase_price'];
    if (
            ($customerId == NULL && !is_numeric(CommonBase::decrypt($customerId)) ) ||
            ($vid == NULL && !is_numeric(CommonBase::decrypt($vid)) ) ||
            ($sp == NULL && !is_numeric($sp) ) || $sp <= 0 ||
            ($invprice == NULL && !is_numeric($invprice) ) || $invprice <= 0
    ) {
        echo CommonBase::jsAlert("Invalid Entry !");
    } elseif (FALSE) {
        echo CommonBase::jsAlert("Selling Price cannot be lower than purchase price !");
    } else {
        $time = CommonBase::getcurrenttime();
        $id = CommonBase::getcarsaleId();
        $stmt = $dbh->prepare(" update advert set flow = '2' ,fk_customer = ? ,selling_price=?,invoice_price=?,fk_admin_customeradded=?,fk_admin_customeraddedtime=? WHERE `Id` = ?");
        $done = $stmt->execute(array(CommonBase::decrypt($customerId), $sp, $invprice, $id, $time, CommonBase::decrypt($vid)));
        if ($done) {
            echo CommonBase::jsAlert("Customer Change Susesfully");
            echo CommonBase::refreshMother("customer_search.php?&search=$search&searchtext=$searchtext");
            echo CommonBase::closeWindow();
        }
    }
}
if (isset($_POST['r_cus'])) {
    $vdetails = Vehicle::getVehicle(CommonBase::decrypt($vid));
    $pp = $vdetails['purchase_price'];
    if (
            ($vid == NULL && !is_numeric(CommonBase::decrypt($vid)))
    ) {
        echo CommonBase::jsAlert("Invalid Entry !");
    } else {
        $time = CommonBase::getcurrenttime();
        $id = CommonBase::getcarsaleId();

        $stmt = $dbh->prepare(" update advert set flow = '1' ,fk_customer = NULL WHERE `Id` = ?");
        $done = $stmt->execute(array(CommonBase::decrypt($vid)));
        if ($done) {
            echo CommonBase::jsAlert("Customer Removed Susesfully");
            echo CommonBase::refreshMother("customer_search.php?&search=$search&searchtext=$searchtext");
            echo CommonBase::closeWindow();
        }
    }
}
if (isset($_POST['addcustomer'])) {

    $vdetails = Vehicle::getVehicle(CommonBase::decrypt($vid));

    $pp = $vdetails['purchase_price'];
    if (
            ($customerId == NULL && !is_numeric(CommonBase::decrypt($customerId)) ) ||
            ($vid == NULL && !is_numeric(CommonBase::decrypt($vid)) ) ||
            ($sp == NULL && !is_numeric($sp) ) || $sp <= 0 ||
            ($invprice == NULL && !is_numeric($invprice) ) || $invprice <= 0
    ) {
        echo CommonBase::jsAlert("Invalid Entry !");
    } elseif (FALSE) {
        echo CommonBase::jsAlert("Selling Price cannot be lower than purchase price !");
    } else {
        $time = CommonBase::getcurrenttime();
        $id = CommonBase::getcarsaleId();
        $stmt = $dbh->prepare(" update advert set flow = '2' ,fk_customer = ? ,selling_price=?,invoice_price=?,fk_admin_customeradded=?,fk_admin_customeraddedtime=? WHERE `Id` = ?");
        $done = $stmt->execute(array(CommonBase::decrypt($customerId), $sp, $invprice, $id, $time, CommonBase::decrypt($vid)));
        if ($done) {
            echo CommonBase::jsAlert("Added ");
            echo CommonBase::refreshMotherwithout();
            echo CommonBase::closeWindow();
        }
    }
}
if (isset($_POST['sold']) || isset($_POST['unsold'])) {

    if ($viddel != NULL) {
        $q = "";
        $smsg = "";
        $delid = CommonBase::decrypt($viddel);
        if (is_numeric($delid)) {
            $myCon = new ControlPadDB;
            $dbh = $myCon->dbh;
            if (false) {
                echo CommonBase::jsAlert("Cannot Remove Vehicle Payment Added !");
            } else {
                $time = CommonBase::getcurrenttime();
                $uId = CommonBase::getcarsaleIdforadd();
                if (isset($_POST['sold'])) {
                    $q = "UPDATE advert SET available = 0 WHERE `Id` = ?";
                    $smsg = "Vehicle Status Changed to Sold";
                }
                if (isset($_POST['unsold'])) {
                    $q = "UPDATE advert SET available = 1 WHERE `Id` = ?";
                    $smsg = "Vehicle Status Changed to Unsold";
                }
                $stmt = $dbh->prepare($q);
                $stmt->execute(array($delid));
                echo CommonBase::jsAlert($smsg);
            }
        }
    }
}
if (isset($_POST['vdel'])) {

    if ($viddel != NULL) {

        $delid = CommonBase::decrypt($viddel);
        if (is_numeric($delid)) {
            $myCon = new ControlPadDB;
            $dbh = $myCon->dbh;
            if (false) {
                echo CommonBase::jsAlert("Cannot Remove Vehicle Payment Added !");
            } else {
                $vehicle = Vehicle::getVehicle($delid);
                $time = CommonBase::getcurrenttime();
                $uId = CommonBase::getcarsaleIdforadd();
                $stmt = $dbh->prepare("UPDATE advert SET status = 0, delu = ? , delt=? WHERE `Id` = ?");

                if ($stmt->execute(array($uId, $time, $delid))) {
                    $img1 = $vehicle['image1'];
                    $img2 = $vehicle['image2'];
                    $img3 = $vehicle['image3'];
                    $img4 = $vehicle['image4'];
                    $p_imgp = $vehicle['imgpath'];
                    if ($img1 != "na.jpg") {
                        unlink("../" . $p_imgp . $img1);
                        unlink("../" . "images/vthumbs/" . $img1);
                    }
                    if ($img2 != "na.jpg") {
                        unlink("../" . $p_imgp . $img2);
                    }
                    if ($img3 != "na.jpg") {
                        unlink("../" . $p_imgp . $img3);
                    }
                    if ($img4 != "na.jpg") {
                        unlink("../" . $p_imgp . $img4);
                    }
                    echo CommonBase::jsAlert("Vehicle Deleted");
                }
            }
        }
    }
}
if (isset($_POST['changimages'])) {
    $upload = new http_upload('en');
    $file = $upload->getFiles();
    $allfiles = array();
    $fcount = FALSE;
    foreach ($file as $currentFile) {
        $t = array("jpg", "png", "gif", "webp", "JPG", "JPEG");
        //$currentFile->_chmod
        $currentFile->setValidExtensions($t, $mode = 'accept');
        if (PEAR::isError($currentFile)) {
            //error of file
        } elseif ($currentFile->isValid()) {
            $currentFile->setName('real');
            //   $final_dir = $this->getDir($posision_cr);

            $dest_dir = '../admincontent/vimg/';
            if (@!is_dir($dest_dir)) {
                mkdir($dest_dir);
            }
            $dest_name = $currentFile->moveTo($dest_dir);
            if (PEAR::isError($dest_name)) {
                //  $this->setError($dest_name->getMessage());
                var_dump($dest_name->getMessage());
            } else {
                $realname = $currentFile->getProp('real');
                $imgfullPath = $dest_dir . $dest_name;
                array_push($allfiles, $dest_name);
                $fcount = true;
            }
        } else {
            //no file
        }
    }

    $vid_d = CommonBase::decrypt($vid);
    if (!is_numeric($vid_d) ||
            $imgt == null ||
            ($allfiles[0] ?? null) == null
    ) {
        echo CommonBase::jsAlert("invalid Fields !");
    } else {
        $v = Vehicle::getVehicle($vid_d);
        $p_imgp = $v['imgpath'];
        $p_image = "";
        $img = $allfiles[0] ?? "na.jpg";
        $quary = "";
        if ($imgt == 1) {
            $quary = "update advert set image1 =? WHERE `Id`= ?";
            $image = $v['image1'];
        }
        if ($imgt == 2) {
            $quary = "update advert set image2 =? WHERE `Id`= ?";
            $image = $v['image2'];
        }
        if ($imgt == 3) {
            $quary = "update advert set image3 =? WHERE `Id`= ?";
            $image = $v['image2'];
        }
        if ($imgt == 4) {
            $quary = "update advert set image4 =? WHERE `Id`= ?";
            $image = $v['image4'];
        }
        $del_imgurl = "../" . $p_imgp . $image;
        $stmt = $dbh->prepare($quary);
        $done = $stmt->execute(array($img, $vid_d));
        $del_thumb = "../" . "images/vthumbs/" . $image;
        if ($done) {
            if ($image != "na.jpg") {
                unlink($del_imgurl);
                if ($imgt == 1) {
                    unlink($del_thumb);
                }
            }
            echo CommonBase::jsAlert("Image Changed.");
            echo CommonBase::gotopage(CommonBase::full_SiteUrl());
        }
    }
}







if (isset($_GET['carsale_search'])) {

    if (!is_numeric(CommonBase::decrypt($carsale))) {
        echo CommonBase::jsAlert("Invalid Entry !");
    } else {

        $q = " select a.* from advert a WHERE a.status = 1 AND a.fk_carsales = ? ";
        $value = array();
        array_push($value, CommonBase::decrypt($carsale));
        if ($Stock != null) {
            $q .= "AND a.fk_stock = ? ";
            array_push($value, CommonBase::decrypt($Stock));
        }
        if ($Category != null) {
            $q .= "AND a.fk_type = ?";
            array_push($value, CommonBase::decrypt($Category));
        }
        if ($Make != null) {
            $q .= "AND a.fk_make = ?";
            array_push($value, CommonBase::decrypt($Make));
        }
        if ($Model != null) {
            $q .= "AND a.fk_model = ?";
            array_push($value, CommonBase::decrypt($Model));
        }
        if ($BodyType != null) {
            $q .= "AND a.fk_body_type = ?";
            array_push($value, CommonBase::decrypt($BodyType));
        }
        if ($Transmission != null) {
            $q .= "AND a.fk_transmission = ?";
            array_push($value, CommonBase::decrypt($Transmission));
        }
        if ($FuelType != null) {
            $q .= "AND a.fk_fuel = ?";
            array_push($value, CommonBase::decrypt($FuelType));
        }
        if ($BaseColur != null) {
            $q .= "AND a.fk_color = ?";
            array_push($value, CommonBase::decrypt($BaseColur));
        }
        if ($ys != null && $ye != null) {
            $q .= "AND  a.yearmonth BEtWEEN ? AND ?+1 ";
            array_push($value, $ys);
            array_push($value, $ye);
        }
        if ($key != null) {
            $q .= "AND (a.`search` LIKE ? OR a.`Id` = ? OR a.modeltxt LIKE ? )";
            array_push($value, "%$key%");
            array_push($value, "%$key%");
            array_push($value, "%$key%");
        }
        if ($chasi != null) {
            $chasi = str_replace("*", "%", $chasi);
            $q .= "AND  a.chasi LIKE ?  ";
            array_push($value, $chasi);
            $chasi = str_replace("%", "*", $chasi);
        }
        if ($id != null) {
            $q .= "AND a.ref =? ";
            array_push($value, $id);
        }

        if ($std != null && $ed != null) {
            $s_date = date("Y-m-d", strtotime($std));
            $e_date = date("Y-m-d", strtotime($ed));
            if ($s_date < $e_date || $s_date == $e_date) {
                $q .= "And addt BETWEEN ? AND ?";
                array_push($value, $s_date);
                array_push($value, $e_date);
            } else {
                //echo CommonBase::jsAlert("invalid Date Range");
                // exit();
            }
        }

        $q .= " ORDER BY Id desc";
        $myCon = new ControlPadDB;
        $dbh = $myCon->dbh;

        $stmt_search = $dbh->prepare($q);
        $stmt_search->execute($value);
    }
}





if (isset($_POST['addins2'])) {
    //
    $upload = new http_upload('en');
    $file = $upload->getFiles();

    $myCon = new ControlPadDB;
    $dbh = $myCon->dbh;
    $count = FALSE;
    foreach ($file as $currentFile) {
        //var_dump($currentFile->size);
        if (!$currentFile->isValid()) {
            $count = true;
        }
    }

    if ($count) {
        $errmsg = "NO File Selected ! ";
    } else {

        foreach ($file as $currentFile) {
            $t = array("jpg", "png", "gif", "webp");
            //$currentFile->_chmod
            $currentFile->setValidExtensions($t, $mode = 'accept');
            if (PEAR::isError($currentFile)) {
                //error of file
            } elseif ($currentFile->isValid()) {
                $currentFile->setName('real');
                //   $final_dir = $this->getDir($posision_cr);

                $dest_dir = 'admincontent/insp/';
                if (@!is_dir($dest_dir)) {
                    mkdir($dest_dir);
                }
                $dest_name = $currentFile->moveTo($dest_dir);
                if (PEAR::isError($dest_name)) {
                    //  $this->setError($dest_name->getMessage());
                    error_log('File upload error: ' . $dest_name->getMessage());
                } else {
                    $realname = $currentFile->getProp('real');
                    $vid = $myCon->escapeString(CommonBase::decrypt($vid));

                    $stmt = $dbh->prepare("Update vehicle SET ins2 = ? WHERE Id = ?");
                    $imgfullPath = $dest_dir . $dest_name;
                    $done = $stmt->execute(array($imgfullPath, $vid));
                    // $stmt->execute();
                    if ($done) {
                        $addedIdTemp = CommonBase::encrypt($dbh->lastInsertId());
                        $addedId = $addedIdTemp;
                        echo CommonBase::jsAlert("IMG Added Sucssefully ,this window will automaticaly close.");
                        echo "<script type=\"text/javascript\" >opener.location=('searchVehicles.php?&search=$search&searchtext=$searchtext')</script>";
                        echo "<script type=\"text/javascript\" >self.close()</script>";
                    }
                }
            } else {
                //nofile
            }
        }
    }
}


if (isset($_POST['vSearch'])) {
    $searchBy = "Id";
    if ($searchtext == NULL) {
        $errmsg = "Invalid Keyword";
    } else {
        $searchtext = str_replace("*", "%", $searchtext);
        if ($search == 1) {
            $searchBy = "regNo";
        } elseif ($search == 2) {
            $searchBy = "fk_seller";
        } elseif ($search == 3) {
            $searchBy = "fk_buyer";
        }
        $myCon = new ControlPadDB;
        $dbh = $myCon->dbh;
        $stmt = $dbh->prepare("SELECT * FROM vehicle WHERE $searchBy LIKE ? and status != 0");
        $stmt->execute(array($searchtext));
    }
}
?>
