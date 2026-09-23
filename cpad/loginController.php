<?php

@session_start();
require_once 'clsCommonBase.php';
require_once 'logController.php';
require_once 'clsLogin.php';

$login = new Login();

$path_parts = pathinfo($_SERVER['PHP_SELF']);
$baseName = $path_parts["basename"];

// NOTE: the legacy "userlogin" (staff, `user` table) and "ownerlogin"/"ownerlogout"
// (reseller, `carsales`/`carsale_users` tables) flows were removed from here.
// They are dead code left over from a shared multi-tenant template: this site has
// no login.php, add_customer_vehicle.php, customer_search.php, ownerlogin.php or
// owner_home.php page for them to redirect to, so they could never complete
// successfully - they only added unauthenticated attack surface (they ran on
// every POST request regardless of login state) and referenced undefined
// $cdb/$dbh variables (fatal error) in the userlogin branch. The only real,
// reachable login flow on this site is the admin panel login below.

if (isset($_POST['adminlogin'])) {
    CommonBase::requireValidCsrf();
    $AuserName = isset($_POST['AuserName']) ? $_POST['AuserName'] : '';
    $Apassword = isset($_POST['Apassword']) ? $_POST['Apassword'] : '';
    $adminlogin_msg = $login->AdminLogin($AuserName, $Apassword);
}

if ($baseName == "admin_logout.php") {
    $login->AdminLogout();
}
?>
