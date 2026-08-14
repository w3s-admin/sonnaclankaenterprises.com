<?php

@session_start();
require_once 'clsCommonBase.php';
require_once 'logController.php';
require_once 'clsLogin.php';

$login = new Login();

extract($_POST);
$path_parts = pathinfo($_SERVER['PHP_SELF']);
$baseName = $path_parts["basename"];

// <editor-fold defaultstate="collapsed" desc="userlogin">

if (isset($_POST['userlogin'])) {

    $userName = $cdb->escapeString($userName);
    $password = $cdb->escapeString($password);




    $stmt = $dbh->prepare("SELECT * from user where username = ? and password = ? AND status = 1");
    $stmt->execute(array($userName, $password));






    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $id = $row['Id'];
        $name = $row['username'];
        $lastLogin = $row['lastLogin'];


        $sales = $row['sales'];
        $bidding = $row['bidding'];
        $account = $row['account'];
        $lc = $row['lc'];
        $uv = $row['uv'];
        $admin = $row['admin'];
        // var_dump($row);
        $errmsg = "";

        if ($sales == 1) {
            $_SESSION['sales'] = 1;
        }
        if ($bidding == 1) {
            $_SESSION['bidding'] = 1;
        }
        if ($account == 1) {
            $_SESSION['account'] = 1;
        }
        if ($lc == 1) {
            $_SESSION['lc'] = 1;
        }
        if ($uv == 1) {
            $_SESSION['uv'] = 1;
        }
        if ($admin == 1) {
            $_SESSION['admin'] = 1;
        }


        $_SESSION['username'] = $name;
        $_SESSION['userid'] = $id;


        $_SESSION['userlastlogin'] = date('l jS \of F Y h:i:s A', strtotime($lastLogin));

        $ip = $_SERVER['REMOTE_ADDR']; //Get there ip address.
        $agent = $_SERVER['HTTP_USER_AGENT']; //Get there user agent, Firefox etc, and some other info about it.

        $loguser = new Logging();
        $loguser->log_file = "logs/login/user/user";
        $loguser->lwrite("ip : $ip ,  Browser : $agent, User Name : $name , User ID : $id type : $type");

        $time = CommonBase::getcurrenttime();
        $stmt = $dbh->prepare("UPDATE user set lastLogin='$time' where Id = ?");
        $stmt->execute(array($id));

        if (User::firstLogincheck($id)) {
            $stmt = $dbh->prepare("Insert INTO login(fk_user,firtlogedintime) VALUES(?,?)");
            $stmt->execute(array($id, $time));
        }


        if ($sales == 1) {
            CommonBase::SendRedirect("add_customer_vehicle.php");
        }
        if ($bidding == 1) {
            CommonBase::SendRedirect("customer_search.php");
        }
        if ($account == 1) {
            CommonBase::SendRedirect("customer_search.php");
        }
        if ($lc == 1) {
            CommonBase::SendRedirect("customer_search.php");
        }
        if ($uv == 1) {
            CommonBase::SendRedirect("customer_search.php");
        }
        if ($admin == 1) {
            CommonBase::SendRedirect("customer_search.php");
        }
    } else {
        $errmsg = "* incorect Username or Password";
    }
}// </editor-fold>

if (isset($_POST['ownerlogin'])) {
    
     $errmsg = $login->ownwerLogin($AuserName, $Apassword);
          
}

if (isset($_POST['adminlogin'])) {
     $adminlogin_msg = $login->AdminLogin($AuserName, $Apassword);
}


if ($baseName == "ownerlogout.php") {
   $login->ownwerLogout();
}

if ($baseName == "admin_logout.php") {
    $login->AdminLogout();
}

if ($baseName == "userLogout.php") {
    $timenow = CommonBase::getcurrenttime();
    if (User::updatelastlogOut($timenow, $_SESSION['userid'])) {
        $_SESSION['sales'] = NULL;
        $_SESSION['bidding'] = NULL;
        $_SESSION['account'] = NULL;
        $_SESSION['lc'] = NULL;
        $_SESSION['admin'] = NULL;
        $_SESSION['uv'] = NULL;

        $_SESSION['username'] = NULL;
        $_SESSION['userid'] = NULL;
        $_SESSION['userlastlogin'] = NULL;
        $_SESSION['utype'] = NULL;
        unset($_SESSION['username']);
        unset($_SESSION['userid']);
        unset($_SESSION['userlastlogin']);
        unset($_SESSION['utype']);

        unset($_SESSION['sales']);
        unset($_SESSION['bidding']);
        unset($_SESSION['account']);
        unset($_SESSION['lc']);
        unset($_SESSION['admin']);
        unset($_SESSION['uv']);

        CommonBase::SendRedirect("login.php");
    }
}
?>
