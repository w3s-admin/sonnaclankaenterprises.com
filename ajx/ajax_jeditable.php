<?php

@session_start();

require '../cpad/emailController.php';
$myCon = new ControlPadDB;
$dbh = $myCon->dbh;
extract($_POST);


if (isset($main) && $main = "email_edit") {
    $id = CommonBase::decrypt($row_id);
    $emails = Emails::getEmailById($id);
    $arr = array();
    if (trim($type) == "email") {
        $pname = $emails['email'];
    }
    if (trim($type) == "name") {
        $pname = $emails['name'];
    }
    if (
            trim($type) == "email" && !CommonBase::isEmail($value) ||
            trim($type) == "name" && $value == NULL ||
            !is_numeric($id)
    ) {
        $arr['type'] = 'err';
        $arr['value'] = $pname;
        $arr['msg'] = "Invalid Data !";
        echo json_encode($arr);
    } elseif (trim($type) == "email" && Emails::isEmialsAvailableEdit($value, $id)) {
        $arr['type'] = 'err';
        $arr['value'] = $pname;
        $arr['msg'] = "Duplicate Email !";
        echo json_encode($arr);
    } else {
        $time = CommonBase::getcurrenttime();
        if (trim($type) == "email") {
            $Q = "Update emailadress set  email = ?  , updateu = ? , updatet=? WHERE `Id` = ?";
        }
        if (trim($type) == "name") {
            $Q = "Update emailadress set  `name` = ? ,  updateu = ? , updatet=? WHERE `Id` = ?";
        }
        $stmt = $dbh->prepare($Q);
        $done = $stmt->execute(array($value, CommonBase::IsAdminUser()['Id'], $time, $id));
        if ($done) {
            $arr['type'] = 'suc';
            $arr['value'] = $value;
            $arr['msg'] = "done !";
            echo json_encode($arr);
        }
    }



//    
//     array (size=6)
//  'value' => string 'basith2003@yahoo.com' (length=20)
//  'id' => string '' (length=0)
//  'row_id' => string 'lw==' (length=4)
//  'type' => string 'email ' (length=6)
//  'secound_sub_exsits' => string '' (length=0)
//  'column' => string '2' (length=1)
}
?>
