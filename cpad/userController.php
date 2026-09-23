<?php

@session_start();
require_once 'clsCommonBase.php';
require_once 'clsUser.php';
//require_once 'capcha/securimage.php';
//require_once 'mailController.php';
require_once 'common/HTTP_Upload.php';
require_once 'clsS3Storage.php';

$myCon = new ControlPadDB;

$dbh = $myCon->dbh;

// Staff-account management is admin-only and this file is directly web
// requestable (cpad/ has no deny rule), so it must gate itself rather than
// rely solely on the calling page's own check. Per docs/05-staff-accounts.md,
// "Super Admin" is the only access boundary this app currently enforces
// reliably, and creating/editing/deleting *other* staff logins (including
// granting super_admin itself) is exactly the kind of "full control" action
// that doc says should be limited to people who genuinely need it - so the
// whole User Manager module requires an existing super admin, not just any
// logged-in admin.
$currentAdmin = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentAdmin = CommonBase::IsAdminUser('super_admin');
    CommonBase::requireValidCsrf();
}

$fname = isset($_POST['fname']) ? trim($_POST['fname']) : null;
$lname = isset($_POST['lname']) ? trim($_POST['lname']) : null;
$uname = isset($_POST['uname']) ? trim($_POST['uname']) : null;
$email = isset($_POST['email']) ? trim($_POST['email']) : null;
$email_password = isset($_POST['email_password']) ? $_POST['email_password'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$cpassword = isset($_POST['cpassword']) ? $_POST['cpassword'] : null;
$other = isset($_POST['other']) ? $_POST['other'] : null;
$contact_number = isset($_POST['contact_number']) ? $_POST['contact_number'] : null;

// Only an existing super admin may grant/keep super_admin on any account -
// this used to be settable by any logged-in admin via a plain POST field.
$sadmin = isset($_POST['sadmin']) ? $_POST['sadmin'] : null;
if (empty($currentAdmin['super_admin'])) {
    $sadmin = null;
}


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
            $t = array("jpg", "png", "gif", "webp", "JPG", "JPEG");
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
                // Was 'admincontent/system_admin/' (missing the '../'), which
                // wrote new avatars to systemadmin/admincontent/system_admin/
                // instead of the site-root admincontent/ directory that
                // file_path='admincontent/system_admin/' (saved to the DB
                // right below) and every later unlink()/<img src> assumes -
                // the very first avatar a user ever uploaded 404'd on
                // display and any later change/remove couldn't find it.
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
            $fileName = $allfiles[0]['name'];
            $filePath = 'admincontent/system_admin/';
            if (S3Storage::isConfigured()) {
                $uploaded = S3Storage::uploadSplit($allfiles[0]['path'] . $allfiles[0]['name'], 'avatars', $fileName);
                if ($uploaded) {
                    @unlink($allfiles[0]['path'] . $allfiles[0]['name']);
                    $fileName = $uploaded['name'];
                    $filePath = $uploaded['path'];
                }
            }
            $stmt = $dbh->prepare("Update system_admin set file_name = ? ,file_path=? WHERE `Id`=?");
            $done = $stmt->execute(array($fileName, $filePath, $userID));
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
            $t = array("jpg", "png", "gif", "webp", "JPG", "JPEG");
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
            $fileName = $allfiles[0]['name'];
            $filePath = 'admincontent/system_admin/';
            if (S3Storage::isConfigured()) {
                $uploaded = S3Storage::uploadSplit($allfiles[0]['path'] . $allfiles[0]['name'], 'avatars', $fileName);
                if ($uploaded) {
                    @unlink($allfiles[0]['path'] . $allfiles[0]['name']);
                    $fileName = $uploaded['name'];
                    $filePath = $uploaded['path'];
                }
            }
            $stmt = $dbh->prepare("Update system_admin set file_name = ? , file_path=? WHERE `Id`=?");
            $done = $stmt->execute(array($fileName, $filePath, $userID));
            if ($done) {
                CommonBase::deleteStoredFile($user['file_path'] . $user['file_name']);
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

            CommonBase::deleteStoredFile($user['file_path'] . $user['file_name']);
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
	                VALUES (?, ?, ?, ? , ?, ?,   ?, ? , ?,?,?) ";
        $stmt = $dbh->prepare($quary);

        $done = $stmt->execute(array(
            $fname,
            $lname,
            $uname,
            password_hash($password, PASSWORD_BCRYPT),
            $email,
            1,
            CommonBase::chktoDB($sadmin),
            $currentAdmin['Id'],
            $now,
            $other,
            $contact_number
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
                            $type = 'suc', $headding = 'Successfully added', $massage = 'Now User can login to the System using User Name : ' . htmlspecialchars($uname, ENT_QUOTES, 'UTF-8') . ' and Password : ' . htmlspecialchars($password, ENT_QUOTES, 'UTF-8') . '…….. ', 200);

            // Flashed via session (not the URL query string): the message
            // above embeds a plaintext password, and this "encrypt" is a
            // trivial reversible cipher, so putting it in the URL would leak
            // the new user's password into server access logs, proxy logs
            // and browser history.
            $_SESSION['_flash_shop_save_msg'] = $shop_save_msg;
            CommonBase::SendRedirect("user_add.php");
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
            $currentAdmin['Id'],
            $now,

            $other,
            $contact_number,  $userID

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
        $stmt = $dbh->prepare("update system_admin set password = ? WHERE `Id` =? ");

        $done = $stmt->execute(array(
            password_hash($password, PASSWORD_BCRYPT), $userID
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
    $uid = isset($_POST['uid']) ? $_POST['uid'] : null;
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
