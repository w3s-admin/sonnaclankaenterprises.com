<?php

require_once 'clsCommonBase.php';
require_once 'clsProperty.php';
require_once 'paginator.class.php';
require_once 'Thumbnail.class.php';
require_once 'common/HTTP_Upload.php';

$myCon = new ControlPadDB;

$dbh = $myCon->dbh;
extract($_POST);
extract($_GET);

if (isset($_POST['pro_save_btn'])) {



    if (
            ${'fk_main'} == null ||
            ${'fk_property_type'} == null ||
            ${'fk_location'} == null ||
            ($ho != "1" && ${'price'} == null) ||
            ($ho != "1" && ${'fk_price_types'} == null) ||
            ($ho != "1" && ${'fk_price_per'} == null)
    ) {
        $pro_save_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Error on Data", $massage = 'Please Double check field(s) that are in red', 100);
    } else {


        $keywd = CommonBase::getname(CommonBase::decrypt($fk_main), "main") . ", " .
                CommonBase::getname(CommonBase::decrypt(${'fk_property_type'}), "property_type") . ", " .
                CommonBase::getname(CommonBase::decrypt(${'fk_location'}), "location") . ", " .
                CommonBase::getname(CommonBase::decrypt(${'fk_availability'}), "availability") . " ";

        $quary = "INSERT INTO advert (
            fk_main, 
            fk_location, 
            fk_property_type, 
            fk_land_area_length_types, 
            fk_floor_area_length_types, 
            fk_availability, 
            number_of_rooms, 
            number_of_bathrooms, 
            size_of_land_area, 
            number_of_floors, 
            size_of_floor_area, 
            price, 
            fk_price_per, 
            fk_price_types, 
            `_status`, 
            addu, 
            addt, 
            search_keyword, 
            discription, 
            ho) 
	VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);
";
        $stmt = $dbh->prepare($quary);

        $done = $stmt->execute(array(
            CommonBase::decrypt($fk_main),
            CommonBase::decrypt(${'fk_location'}),
            CommonBase::decrypt(${'fk_property_type'}),
            CommonBase::decrypt(${'fk_land_area_length_types'}),
            CommonBase::decrypt(${'fk_floor_area_length_types'}),
            CommonBase::decrypt(${'fk_availability'}),
            ${'number_of_rooms'},
            ${'number_of_bathrooms'},
            ${'size_of_land_area'},
            ${'number_of_floors'},
            ${'size_of_floor_area'},
            ${'price'},
            CommonBase::decrypt(${'fk_price_per'}),
            CommonBase::decrypt(${'fk_price_types'}),
            1,
            CommonBase::IsAdminUser()['Id'],
            CommonBase::getcurrenttime(),
            $keywd,
            preg_replace('#<script(.*?)>(.*?)</script>#is', '', $info),
            $ho
        ));
       
        if ($done) {

            $addedIdTemp = CommonBase::encrypt($dbh->lastInsertId());
//            $shop_save_msg = CommonBase::createMassageDiv(
//                            $type = 'suc', $headding = 'Successfully added', $massage = 'Advert published successfully ', 150);
//            CommonBase::SendRedirect(CommonBase::url_with_out_get() . "?shop_save_msg=" . CommonBase::encrypt($shop_save_msg));
            $last_id = $dbh->lastInsertId();
 
        }
    }
}
if (isset($_POST['pro_edit_btn'])) {

    $edit_id = CommonBase::decrypt($_GET['pid']);

    if (
            ${'fk_main'} == null ||
            ${'fk_property_type'} == null ||
            ${'fk_location'} == null ||
            ($ho != "1" && ${'price'} == null) ||
            ($ho != "1" && ${'fk_price_types'} == null) ||
            ($ho != "1" && ${'fk_price_per'} == null) ||
            !is_numeric($edit_id)
    ) {
        $pro_save_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Error on Data", $massage = 'Please Double check field(s) that are in red', 100);
    } else {


        $keywd = CommonBase::getname(CommonBase::decrypt($fk_main), "main") . ", " .
                CommonBase::getname(CommonBase::decrypt(${'fk_property_type'}), "property_type") . ", " .
                CommonBase::getname(CommonBase::decrypt(${'fk_location'}), "location") . ", " .
                CommonBase::getname(CommonBase::decrypt(${'fk_availability'}), "availability") . " ";

        $quary = "Update advert set 
            fk_main=?, 
            fk_location=?, 
            fk_property_type=?, 
            fk_land_area_length_types=?, 
            fk_floor_area_length_types=?, 
            fk_availability=?, 
            number_of_rooms=?, 
            number_of_bathrooms=?, 
            size_of_land_area=?, 
            number_of_floors=?, 
            size_of_floor_area=?, 
            price=?, 
            fk_price_per=?, 
            fk_price_types=?, 
            `_status`=?, 
            updateu=?, 
            updatet=?, 
            search_keyword=?, 
            discription=?, 
            ho =?
	WHERE `Id` = ?;
";
        $stmt = $dbh->prepare($quary);

        $done = $stmt->execute(array(
            CommonBase::decrypt($fk_main),
            CommonBase::decrypt(${'fk_location'}),
            CommonBase::decrypt(${'fk_property_type'}),
            CommonBase::decrypt(${'fk_land_area_length_types'}),
            CommonBase::decrypt(${'fk_floor_area_length_types'}),
            CommonBase::decrypt(${'fk_availability'}),
            ${'number_of_rooms'},
            ${'number_of_bathrooms'},
            ${'size_of_land_area'},
            ${'number_of_floors'},
            ${'size_of_floor_area'},
            ${'price'},
            CommonBase::decrypt(${'fk_price_per'}),
            CommonBase::decrypt(${'fk_price_types'}),
            1,
            CommonBase::IsAdminUser()['Id'],
            CommonBase::getcurrenttime(),
            $keywd,
            preg_replace('#<script(.*?)>(.*?)</script>#is', '', $info),
            $ho,
            $edit_id
        ));
        if ($done) {
            $addedIdTemp = CommonBase::encrypt($dbh->lastInsertId());
            $shop_save_msg = CommonBase::createMassageDiv(
                            $type = 'suc', $headding = 'Successfully Updated', $massage = 'Advert Updated successfully ', 0);
//            CommonBase::SendRedirect(CommonBase::url_with_out_get() . "?shop_save_msg=" . CommonBase::encrypt($shop_save_msg));
            $last_id = $dbh->lastInsertId();
        }
    }
}
if (isset($_POST['del_pro'])) {
    $id = CommonBase::decrypt($row_id);
    if (is_numeric($id)) {
        $stmt = $dbh->prepare("update advert set `_status`= 0,delu=?,delt=? WHERE `Id` = ? ");
        $done = $stmt->execute(array(CommonBase::IsAdminUser()['Id'], CommonBase::getcurrenttime(), $id));
        $img_arr = Property::getAllimages($id);

        foreach ($img_arr as $value) {
            $prv_image = Property::getPropertyImageById($value['Id']);
            $thumb_IMG = "../" . $prv_image['tpath'] . $prv_image['image_name'];
            $main_IMG = "../" . $prv_image['mpath'] . $prv_image['image_name'];
            unlink($thumb_IMG);
            unlink($main_IMG);
        }
        $stmt = $dbh->prepare("DELETE FROM advert_images WHERE fk_advert = ? ");
        $done = $stmt->execute(array($id));
        $shop_del_msg = CommonBase:: createnotify($type = 'error', $headding = 'Deleted Successfully !', $massage = '', $hide = 'true');

        if ($done) {
            CommonBase::SendRedirect(CommonBase::appendGettoURL("del_msg=" . CommonBase::encrypt($shop_del_msg)));
        }
    }
}


if (isset($_POST['DelImg'])) {
    $id = CommonBase::decrypt($Id);
    if (is_numeric($id)) {
        $prv_image = Property::getPropertyImageById($id);
        $thumb_IMG = "../" . $prv_image['tpath'] . $prv_image['image_name'];
        $main_IMG = "../" . $prv_image['mpath'] . $prv_image['image_name'];
        $stmt = $dbh->prepare("DELETE FROM advert_images WHERE `Id` = ? ");
        $done = $stmt->execute(array($id));
        if ($done) {
            unlink($thumb_IMG);
            unlink($main_IMG);
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
            $t = array("jpg", "png", "gif", "JPG", "JPEG");
            //$currentFile->_chmod
            $currentFile->setValidExtensions($t, $mode = 'accept');
            if (PEAR::isError($currentFile)) {
                //error of file
            } elseif ($currentFile->isValid()) {
                $currentFile->setName('real');
                //   $final_dir = $this->getDir($posision_cr);

                $dest_dir = '../admincontent/pro_img/default/';
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
                    $arr_f['name'] = $dest_name;
                    $arr_f['path'] = $dest_dir;
                    array_push($allfiles, $arr_f);
                    $fcount = true;
                }
            } else {
                //no file
            }
        }

        $prv_image = Property::getPropertyImageById($id);

        $thumb_IMG = "../" . $prv_image['tpath'] . $prv_image['image_name'];
        $main_IMG = "../" . $prv_image['mpath'] . $prv_image['image_name'];
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
                $status = $thumb->save("../admincontent/pro_img/thumb/" . $tempName);            // save your thumbnail to file
                if ($status) {
                    $tempName = $value['name'];
                    $thumb = new Thumbnail($value['path'] . $value['name']);         // Contructor and set source image file
                    $thumb->img_watermark = "../" . $_SESSION['app_pro']['img_watermark'];       // [OPTIONAL] set watermark source file, only PNG format [RECOMENDED ONLY WITH GD 2 ]
                    $thumb->size(800, 600);                  // [OPTIONAL] set the biggest width and height for thumbnail
                    $thumb->quality = 90;
                    $thumb->img_watermark_Valing = 'BOTTOM';        // [OPTIONAL] set watermark vertical position, TOP | CENTER | BOTTOM
                    $thumb->img_watermark_Haling = 'RIGHT';
                    $thumb->process();               // generate image
                    $status = $thumb->save("../admincontent/pro_img/" . $tempName);            // save your thumbnail to file
                }
                $done = $stmt->execute(array($tempName, "admincontent/pro_img/", "admincontent/pro_img/thumb/", $id));
                if ($done) {
                    unlink('../admincontent/pro_img/default/' . $tempName);
                    unlink($thumb_IMG);
                    unlink($main_IMG);
                }
            }
            if ($done) {
                $shop_save_msg = CommonBase::createMassageDiv(
                                $type = 'suc', $headding = 'Successfully Changed', $massage = 'Advert Image Changed successfully ', 0);
            }
        }
    }
}
if (isset($_POST['pro_save_image'])) {

    $last_id = CommonBase::decrypt($adId);

    if (is_numeric($last_id)) {
        $upload = new http_upload('en');
        $file = $upload->getFiles();
        $allfiles = array();
        $fcount = FALSE;
        foreach ($file as $currentFile) {
            $t = array("jpg", "png", "gif", "JPG", "JPEG");
            //$currentFile->_chmod
            $currentFile->setValidExtensions($t, $mode = 'accept');
            if (PEAR::isError($currentFile)) {
                //error of file
            } elseif ($currentFile->isValid()) {
                $currentFile->setName('real');
                //   $final_dir = $this->getDir($posision_cr);

                $dest_dir = '../admincontent/pro_img/default/';
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
                    $arr_f['name'] = $dest_name;
                    $arr_f['path'] = $dest_dir;
                    array_push($allfiles, $arr_f);
                    $fcount = true;
                }
            } else {
                //no file
            }
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
                $status = $thumb->save("../admincontent/pro_img/thumb/" . $tempName);            // save your thumbnail to file
                if ($status) {
                    $tempName = $value['name'];
                    $thumb = new Thumbnail($value['path'] . $value['name']);         // Contructor and set source image file
                    $thumb->img_watermark = "../" . $_SESSION['app_pro']['img_watermark'];       // [OPTIONAL] set watermark source file, only PNG format [RECOMENDED ONLY WITH GD 2 ]
                    $thumb->size(800, 600);                  // [OPTIONAL] set the biggest width and height for thumbnail
                    $thumb->quality = 90;
                    $thumb->img_watermark_Valing = 'BOTTOM';        // [OPTIONAL] set watermark vertical position, TOP | CENTER | BOTTOM
                    $thumb->img_watermark_Haling = 'RIGHT';
                    $thumb->process();               // generate image
                    $status = $thumb->save("../admincontent/pro_img/" . $tempName);            // save your thumbnail to file
                }
                $done = $stmt->execute(array($last_id, $tempName, "admincontent/pro_img/", "admincontent/pro_img/thumb/"));
                if ($done) {
                    unlink('../admincontent/pro_img/default/' . $tempName);
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
                    CommonBase::SendRedirect("property_add.php?shop_save_msg=" . CommonBase::encrypt($shop_save_msg));
                }
            }
        }
    }
}
?>
