<?php

@session_start();
require_once 'clsCommonBase.php';
require_once 'clsUser.php';
//require_once 'capcha/securimage.php';
//require_once 'mailController.php';
require_once 'common/HTTP_Upload.php';

$myCon = new ControlPadDB;

$dbh = $myCon->dbh;
extract($_POST);
$sadmin = $sadmin ?? null;


if (isset($_POST['upload_user_image'])) {
    $userID = CommonBase::decrypt($_GET['uid']);
    $fcount = FALSE;
    if (
            !is_numeric($userID)
    ) {
        $save_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Invalid Fields", $massage = '', 0);
    } else {
        $upload = new http_upload('en');
        $file = $upload->getFiles();
        $allfiles = array();
        foreach ($file as $currentFile) {
            $t = array("jpg", "png", "gif", "JPG", "JPEG");
            //$currentFile->_chmod
            $currentFile->setValidExtensions($t, $mode = 'accept');
            if (PEAR::isError($currentFile)) {
                //error of file
            } elseif ($currentFile->isValid()) {
                $currentFile->setName('real');
                //   $final_dir = $this->getDir($posision_cr);
//                if (isset($admin_side) && CommonBase::decrypt($admin_side) == "admin") {
//                    $dest_dir = '../admincontent/lc/';
//                } else {
//                    $dest_dir = 'admincontent/lc/';
//                }
                $dest_dir = 'admincontent/system_admin/';
                if (@!is_dir($dest_dir)) {
                    mkdir($dest_dir);
                }
                $dest_name = $currentFile->moveTo($dest_dir);
                if (PEAR::isError($dest_name)) {
                    //  $this->setError($dest_name->getMessage());

                    $save_msg =
                            CommonBase::createMassageDiv(
                                    $type = 'err', $headding = "Err", $massage = $dest_name->getMessage(), 0);
                } else {
                    $realname = $currentFile->getProp('real');
                    $imgfullPath = $dest_dir . $dest_name;
                    $arr_f['name'] = $dest_name;
                    $arr_f['path'] = $dest_dir;
                    array_push($allfiles, $arr_f);
                    $fcount = true;
                }
            } else {
                $save_msg =
                        CommonBase::createMassageDiv(
                                $type = 'err', $headding = "Invalid File", $massage = $currentFile->errorMsg(), 0);
            }
        }
        if (!empty($allfiles)) {

            $stmt = $dbh->prepare("Update system_admin set file_name = ? ,file_path=? WHERE `Id`=?");
            $done = $stmt->execute(array($allfiles[0]['name'], 'admincontent/system_admin/', $userID));
            if ($done) {
                $save_msg = CommonBase::createMassageDiv(
                                $type = 'suc', $headding = "Image Uploded", $massage = "Image uploaded sucsessfully", 0);
                echo CommonBase::refreshMotherwithouturlFancyTimeOut(3000);
            }
        }
    }
}
if (isset($_POST['user_upload_change'])) {
    $userID = CommonBase::decrypt($_GET['uid']);

    if (
            !is_numeric($userID)
    ) {
        $save_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Invalid Fields", $massage = '', 0);
    } else {
        $fcount = FALSE;
        $upload = new http_upload('en');
        $file = $upload->getFiles();
        $allfiles = array();
        foreach ($file as $currentFile) {
            $t = array("jpg", "png", "gif", "JPG", "JPEG");
            //$currentFile->_chmod
            $currentFile->setValidExtensions($t, $mode = 'accept');
            if (PEAR::isError($currentFile)) {
                //error of file
            } elseif ($currentFile->isValid()) {
                $currentFile->setName('real');
                //   $final_dir = $this->getDir($posision_cr);
//                if (isset($admin_side) && CommonBase::decrypt($admin_side) == "admin") {
//                    $dest_dir = '../admincontent/lc/';
//                } else {
//                    $dest_dir = 'admincontent/lc/';
//                }
                $dest_dir = '../admincontent/system_admin/';
                if (@!is_dir($dest_dir)) {
                    mkdir($dest_dir);
                }
                $dest_name = $currentFile->moveTo($dest_dir);
                if (PEAR::isError($dest_name)) {
                    //  $this->setError($dest_name->getMessage());

                    $save_msg =
                            CommonBase::createMassageDiv(
                                    $type = 'err', $headding = "Err", $massage = $dest_name->getMessage(), 0);
                } else {
                    $realname = $currentFile->getProp('real');
                    $imgfullPath = $dest_dir . $dest_name;
                    $arr_f['name'] = $dest_name;
                    $arr_f['path'] = $dest_dir;
                    array_push($allfiles, $arr_f);
                    $fcount = true;
                }
            } else {
                $save_msg =
                        CommonBase::createMassageDiv(
                                $type = 'err', $headding = "Invalid File", $massage = $currentFile->errorMsg(), 0);
            }
        }
        if (!empty($allfiles)) {
            $user = User::getUserById($userID);
            $stmt = $dbh->prepare("Update system_admin set file_name = ? , file_path=? WHERE `Id`=?");
            $done = $stmt->execute(array($allfiles[0]['name'], 'admincontent/system_admin/', $userID));
            if ($done) {
                unlink("../" . $user['file_path'] . $user['file_name']);
                $save_msg = CommonBase::createMassageDiv(
                                $type = 'suc', $headding = "Image Uplode Changed", $massage = "Image upload Changed and notify Users(s)", 0);
                echo CommonBase::refreshMotherwithouturlFancyTimeOut(3000);
            }
        }
    }
}
if (isset($_POST['user_upload_rmv'])) {
    $userID = CommonBase::decrypt($_GET['uid']);
    if (
            !is_numeric($userID)
    ) {
        $save_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Invalid Fields", $massage = '', 0);
    } else {
        $user = User::getUserById($userID);
        $stmt = $dbh->prepare("Update system_admin set file_name = null ,file_path= null WHERE `Id`=?");
        $done = $stmt->execute(array($userID));
        if ($done) {

            unlink("../" . $user['file_path'] . $user['file_name']);
            $save_msg = CommonBase::createMassageDiv(
                            $type = 'suc', $headding = "Image Uplode Removed", $massage = "Image upload Removed and notify Users(s)", 0);
           
        }
    }
}


if (isset($_POST['user_save_btn'])) {

    $post_arr = $_POST;

    $chk_arr = array();
    foreach ($post_arr as $key => $value) {
        if (strpos($key, 'pro_') !== false) {
            array_push($chk_arr, $value);
        }
    }

    $error = false;
    if (
            $fname == null ||
            $lname == null ||
            $uname == null ||
            $email == null ||           
            $password == null
    ) {
        $shop_save_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Error on Data", $massage = 'Please Double check field(s) that are in red First Name, Last Name, User Name, Password and Password', 200);
        $error = true;
    } elseif (User::isUsernameAvailable($uname)) {
        $shop_save_msg = CommonBase::createMassageDiv(
                        $type = 'err', $headding = "User Name Available", $massage = 'User exists in this name please use different User Name', 200);
        $error = true;
         
    } elseif (!$error) {
     
//        
        $now = CommonBase::getcurrenttime();
        $quary = "INSERT INTO system_admin (firstname, lastname, username, `password`, email, `_status`, super_admin,  addu, addt,other,contact_number ) 
	                VALUES (?, ?, ?, CONCAT('*', UPPER(SHA1(UNHEX(SHA1(?))))) , ?, ?,   ?, ? , ?,?,?) ";
        $stmt = $dbh->prepare($quary);    
      
        $done = $stmt->execute(array(
            $fname,
            $lname,
            $uname,
            $password,
            $email,            
            1,
            CommonBase::chktoDB($sadmin),
            CommonBase::IsAdminUser()['Id'],
            $now,
            ${'other'},
            ${'contact_number'}
        ));
      
        if ($done) {
            $addedIdTemp = $dbh->lastInsertId();

            $stmt = $dbh->prepare("insert into system_admin_privilage(fk_system_admin,fk_system_admin_privilage_property) VALUES(?,?)");
            foreach ($chk_arr as $value) {
                $done = $stmt->execute(array($addedIdTemp, $value));
            }
            if ($done) {
                
            }
            $shop_save_msg = CommonBase::createMassageDiv(
                            $type = 'suc', $headding = 'Successfully added', $massage = 'Now User can login to the System using User Name : ' . $uname . ' and Password : ' . $password . '…….. ', 200);
                           
           CommonBase::SendRedirect(CommonBase::appendGettoURL("shop_save_msg", CommonBase::encrypt($shop_save_msg)));
        }
    }
}

if (isset($_POST['user_editbtn_btn'])) {
    $userID = CommonBase::decrypt($_GET['uid']);
    $error = false;
    
    if (
            $fname == null ||
            $lname == null ||
            $uname == null ||
            $email == null ||
          // $email_password == null ||
            !is_numeric($userID)
    ) {
        $shop_save_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Error on Data", $massage = 'Please Double check field(s) that are in red First Name, Last Name, User Name, Password and Password', 0);
        $error = true;
    } elseif (User::isUsernameAvailableEdit($uname, $userID)) {
        $shop_save_msg = CommonBase::createMassageDiv(
                        $type = 'err', $headding = "User Name Available", $massage = 'User exists in this name please use different User Name', 0);

        $error = true;
    } elseif (!$error) {

//        
        $now = CommonBase::getcurrenttime();
        $quary = "update system_admin SET firstname = ?, lastname = ?, username = ?,email=?,email_password=?, `_status` = ?, super_admin = ?, updateu= ?, updatet = ?,other=?,contact_number=? WHERE `Id`=?
	 ;
";
        $stmt = $dbh->prepare($quary);

        $done = $stmt->execute(array(
            $fname,
            $lname,
            $uname,
            $email,
            $email_password,
            1,
            CommonBase::chktoDB($sadmin),
            CommonBase::IsAdminUser()['Id'],
            $now,
          
            ${'other'},
            ${'contact_number'},  $userID
                    
        ));
        if ($done) {

            $addedIdTemp = CommonBase::encrypt($dbh->lastInsertId());
            $shop_save_msg = CommonBase::createMassageDiv(
                            $type = 'suc', $headding = 'Successfully Updated', $massage = 'User updated successfully', 0);
            echo CommonBase::refreshMotherwithouturlFancyTimeOut(3000);
            $fname = "";
            $lname = "";
            $uname = "";

            $email = "";
            $sadmin = "";
            $op = "";
            $usr = "";
            $admin = "";
        }
    }
}

if (isset($_POST['user_change_password'])) {
    $userID = CommonBase::decrypt($_GET['uid']);
    if (
            $cpassword == null ||
            $password == null ||
            !($cpassword == $password) ||
            !is_numeric($userID)
    ) {
        $shop_save_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Error on Data", $massage = 'Password does not match or invalid password type', 0);
        $error = true;
    } else {
        $stmt = $dbh->prepare("update system_admin set password = password(?) WHERE `Id` =? ");

        $done = $stmt->execute(array(
            $password, $userID
        ));
        if ($done) {
            // $addedIdTemp = CommonBase::encrypt($dbh->lastInsertId());
            $shop_save_msg = CommonBase::createMassageDiv(
                            $type = 'suc', $headding = 'Successfully Changed', $massage = 'Password  successfully changed......', 0);
            echo CommonBase::refreshMotherwithouturlFancyTimeOut(3000);
            $password = "";
            $cpassword = "";
        }
    }
}

if (isset($_POST['user_change_privilages'])) {
    $userID = CommonBase::decrypt($_GET['uid']);
    $post_arr = $_POST;
    $chk_arr = array();
    foreach ($post_arr as $key => $value) {
        if (strpos($key, 'pro_') !== false) {
            array_push($chk_arr, $value);
        }
    }

    if (is_numeric($userID) && !empty($chk_arr)) {
        $stmt = $dbh->prepare("Delete from system_admin_privilage WHERE fk_system_admin = ? ");
        $done = $stmt->execute(array(
            $userID
        ));
        if ($done) {

            $stmt = $dbh->prepare("insert into system_admin_privilage(fk_system_admin,fk_system_admin_privilage_property) VALUES(?,?)");
            foreach ($chk_arr as $value) {
                $done = $stmt->execute(array($userID, $value));
            }

            if ($done) {
                $shop_save_msg = CommonBase::createMassageDiv(
                                $type = 'suc', $headding = 'Successfully Changed', $massage = 'Password  successfully changed......', 0);
                echo CommonBase::refreshMotherwithouturlFancyTimeOut(3000);
            }
        }
    }
}

if (isset($_POST['del_user'])) {
    $del_userID = CommonBase::decrypt($uid);
    if (is_numeric($del_userID)) {
        $stmt = $dbh->prepare("Delete from system_admin_privilage WHERE fk_system_admin = ? ");
        $done = $stmt->execute(array(
            $del_userID
        ));
        if ($done) {
            $stmt = $dbh->prepare("update system_admin set `_status` = 0 WHERE `Id` =? ");
            $done = $stmt->execute(array(
                $del_userID
            ));
            if ($done) {
                $user_delmsg = CommonBase:: createnotify($type = 'error', $headding = 'Deleted !', $massage = 'User account successfully deleted', $hide = 'true');
            }
        }
    }
}
?>
