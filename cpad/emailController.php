<?php

require_once 'clsCommonBase.php';
require_once 'mailController.php';
require_once 'clsEmails.php';
require_once 'capcha/securimage.php';
$myCon = new ControlPadDB;
$securimage = new Securimage();
$dbh = $myCon->dbh;
$dbh_sonec = $myCon->dbh;
$time = CommonBase::getcurrenttime();
extract($_POST);

if (isset($_POST['Send_email_friend'])) {
    if ($securimage->check(${'answer'}) == false) {
        $shop_save_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Answer Incorect Please Check!", $massage = '', 100);
    } elseif (
            ${'femail'} == null ||
            !CommonBase::isEmail(${'femail'}) ||
            ${'name'} == null ||
            !is_numeric(CommonBase::decrypt(${'vid'}))
    ) {
        $shop_save_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Invalid fields", $massage = 'please check red coloured fields !', 100);
    } else {

        if (sendmails_to_friend($_POST)) {
            Emails::add_to_email(${'femail'});
            $shop_save_msg = CommonBase::createMassageDiv(
                            $type = 'suc', $headding = 'Eamil Sent', $massage = 'Thank you, your Email has been sent to ' . ${'femail'}, 0);
            CommonBase::gotopage(CommonBase::appendGettoURL("shop_save_msg=".  CommonBase::encrypt($shop_save_msg)));
             
        }
    }
}



if (isset($_POST['sendmails'])) {
    $emais = Emails::getAvailableEmails(true);
    if (sendmails_newsletter($emais, $subject)) {
        $errmsg = 'Emails send to :' . Emails::getAvailableEmails();
    }
}


if (isset($_POST['addselectedvehicle'])) {


    if ($che_all == NULL) {

        $email_msg = CommonBase:: createnotify($type = 'error', $headding = 'Please Select!', $massage = 'At leaast one record has to be select', $hide = 'true', 300);
    } else {
        $count = 1;

        foreach ($che_all as $select) {

            $id = CommonBase::decrypt($select);
            //var_dump($id); exit;
            $count++;
            if (is_numeric($id)) {
                $time = CommonBase::getcurrenttime();
                $stmt1 = $dbh_sonec->prepare("update advert set selected = 1 , selectedtime = ? WHERE `Id` = ?");
                $stmt1->execute(array($time, $id));
                // Emails::downloadImg($id);
            } else {
                $email_msg = CommonBase:: createnotify($type = 'error', $headding = 'invalid perameeter $id !', $massage = '', $hide = 'true', 300);
            }
        }
    }
}

if (isset($_POST['removeselectedvehicle'])) {


    if ($che_selcted == NULL) {

        $email_msg = CommonBase:: createnotify($type = 'error', $headding = 'Please Select!', $massage = 'At leaast one record has to be select', $hide = 'true', 300);
    } else {
        $count = 1;
        foreach ($che_selcted as $select) {

            $id = CommonBase::decrypt($select);
            //var_dump($id); exit;
            $count++;
            if (is_numeric($id)) {
                $time = CommonBase::getcurrenttime();
                $stmt1 = $dbh_sonec->prepare("update advert set selected = 0 , selectedtime = 'null' WHERE `Id` = ?");
                if ($stmt1->execute(array($id))) {
                    //      Emails::delImg($id);
                }
            } else {
                $email_msg = CommonBase:: createnotify($type = 'error', $headding = 'invalid perameeter $id !', $massage = '', $hide = 'true', 300);
            }
        }
    }
}

if (isset($_POST['addselectedvehicle_all'])) {
    $stmt1 = $dbh->prepare("update advert set selected = 1 , selectedtime = 'null' WHERE  flow=1 and status=1 and selected = 0");
    $stmt1->execute(array($time));
}
if (isset($_POST['removeselectedvehicle_all'])) {
    $stmt1 = $dbh->prepare("update advert set selected = 0 , selectedtime = 'null' WHERE  flow=1 and status=1 and selected = 1");
    $stmt1->execute(array($time));
}



//select
if (isset($_POST['addselected'])) {
    if ($che_all == NULL) {
        $email_msg = CommonBase:: createnotify($type = 'error', $headding = 'Please Select!', $massage = 'At leaast one record has to be select', $hide = 'true', 300);
    } else if (!Emails::cheksendcount()) {
        $email_msg = CommonBase:: createnotify($type = 'error', $headding = 'Limt Exceed!', $massage = 'Only 300 emais Allowed from the system at atime , please contact administrator ', $hide = 'true', 300);
    } else {
        $count = 1;
        foreach ($che_all as $select) {

            $id = CommonBase::decrypt($select);
            //var_dump($id); exit;
            $count++;
            if (is_numeric($id)) {
                $time = CommonBase::getcurrenttime();
                $stmt1 = $dbh->prepare("update emailadress set selected = 1 , selectedtime = ? WHERE `Id` = ?");
                $stmt1->execute(array($time, $id));
            } else {
                $email_msg = CommonBase:: createnotify($type = 'error', $headding = 'invalid perameeter $id !', $massage = '', $hide = 'true', 300);
            }
        }
    }
}

if (isset($_POST['addselected_all'])) {

    if (Emails::cheksendcount_all()) {
        $email_msg = CommonBase:: createnotify($type = 'error', $headding = 'Limt Exceed!', $massage = 'Only 300 emais Allowed from the system at atime , please contact administrator ', $hide = 'true', 300);
    } else {
        $stmt1 = $dbh->prepare("update emailadress set selected = 1 , selectedtime = ? WHERE status = 1 and selected = 0 ");
        $stmt1->execute(array($time));
    }
}
if (isset($_POST['removeselected_all'])) {
    $stmt1 = $dbh->prepare("update emailadress set selected = 0, selectedtime = ? WHERE status = 1 and selected = 1 ");
    $stmt1->execute(array($time));
}

if (isset($_POST['removeselected'])) {

    if ($che_selcted == NULL) {
        $email_msg = CommonBase:: createnotify($type = 'error', $headding = 'Please Select!', $massage = 'At leaast one record has to be select', $hide = 'true', 300);
    } else {
        $count = 1;
        foreach ($che_selcted as $select) {

            $id = CommonBase::decrypt($select);
            //var_dump($id); exit;
            $count++;
            if (is_numeric($id)) {
                $time = CommonBase::getcurrenttime();
                $stmt1 = $dbh->prepare("update emailadress set selected = 0 , selectedtime = 'null' WHERE `Id` = ?");
                $stmt1->execute(array($id));
            } else {
                $email_msg = CommonBase:: createnotify($type = 'error', $headding = 'invalid perameeter $id !', $massage = '', $hide = 'true', 300);
            }
        }
    }
}
//add
if (isset($_POST['del_mail'])) {
    $id = CommonBase::decrypt($row_id);
    if (is_numeric($id)) {
        $stmt = $dbh->prepare("UPDATE emailadress SET status = 0, delu=?, delt=? WHERE Id = ?");
        $done = $stmt->execute(array(CommonBase::IsAdminUser()['Id'], CommonBase::getcurrenttime(), $id));
        if ($done) {
            $shop_del_msg = CommonBase:: createnotify($type = 'error', $headding = 'Deleted Successfully !', $massage = '', $hide = 'true', 300);
            CommonBase::SendRedirect(CommonBase::appendGettoURL("del_msg=" . CommonBase::encrypt($shop_del_msg)));
        }
    }
}

if (isset($_POST['editemails'])) {
    $uvid = CommonBase::decrypt($vtid);
    if ($name == null) {
        echo CommonBase::jsAlert("Please Insert Name");
        echo CommonBase::gotopageSearch("admin_add_emaill.php", $search, $searchtext);
    } elseif ($email == null || !CommonBase::isEmail($email)) {
        echo CommonBase::jsAlert("Please Insert valid Email");
        echo CommonBase::gotopageSearch("admin_add_emaill.php", $search, $searchtext);
    } elseif (Emails::isEmialsAvailableEdit($email, $uvid)) {
        echo CommonBase::jsAlert("Email cannot Duplicate");
        echo CommonBase::gotopageSearch("admin_add_emaill.php", $search, $searchtext);
    } elseif (!is_numeric($uvid)) {
        echo CommonBase::jsAlert("Invalid ID");
        echo CommonBase::closeWindow();
        echo CommonBase::gotopageSearch("admin_add_emaill.php", $search, $searchtext);
    } else {
        $time = CommonBase::getcurrenttime();
        $stmt = $dbh->prepare("Update emailadress set  `name` = ? , email = ?  , updateu = ? , updatet=? WHERE `Id` = ?");
        $done = $stmt->execute(array($name, $email, $uId, $time, $uvid));
        var_dump($done);
        if ($done) {
            $addedIdTemp = CommonBase::encrypt($dbh->lastInsertId());
            $addedId = $addedIdTemp;
            $sucmsg1 = "Email Updated Sucssefully";
            echo CommonBase::jsAlert($sucmsg1);
            echo CommonBase::gotopageSearch("admin_add_emaill.php", $search, $searchtext);
        }
    }
}

if (isset($_POST['getemailSearch'])) {
    //$search1 = CommonBase::encrypt($search);
    // $searchtext1 = CommonBase::encrypt(str_replace("%", "*", $searchtext));
    //  echo CommonBase::gotopage("admin_get_excel.php?search=$search1&searchtext=$searchtext1");
    $searchBy = "Id";
    if ($searchtext == NULL) {
        $errmsg = "Invalid Keyword";
    } else {
        $searchtext = str_replace("*", "%", $searchtext);
        if ($search == 1) {
            $searchBy = "email";
        } elseif ($search == 2) {
            $searchBy = "name";
        } elseif ($search == 3) {
            $searchBy = "Id";
        }
        $stmt = $dbh->prepare("SELECT * FROM emailadress WHERE $searchBy LIKE ? and status = 1 ORDER BY `Id`");
        $stmt->execute(array(trim($searchtext)));
    }
}

if (isset($_POST['addemails'])) {

    if ($name == null) {
        $email_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Error on Data", $massage = 'Please Insert Name', 100);
    } elseif ($email == null || !CommonBase::isEmail($email)) {
        $email_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Error on Data", $massage = 'Please Insert valid Email', 100);
    } elseif (Emails::isemailAvailable($email)) {
        $email_msg =
                CommonBase::createMassageDiv(
                        $type = 'err', $headding = "Error on Data", $massage = 'Email cannot Duplicate', 100);
    } else {

        $time = CommonBase::getcurrenttime();
        $stmt = $dbh->prepare("INSERT INTO emailadress(`name`, email, status, addu, addt) VALUES(?,?,1,?,?)");
        $done = $stmt->execute(array($name, $email, $uId, $time));

        if ($done) {
            $email_msg =
                    CommonBase::createMassageDiv(
                            $type = 'suc', $headding = "Email Addded", $massage = '', 100);
            CommonBase::SendRedirect(CommonBase::appendGettoURL("email_msg=" . CommonBase::encrypt($email_msg)));
        }
    }
}
?>
