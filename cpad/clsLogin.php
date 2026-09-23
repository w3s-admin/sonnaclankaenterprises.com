<?php

require_once 'clsCarsale.php';
require_once 'clsCommonBase.php';

class Login {

    var $dbh;
    var $cdb;

    public function __construct() {
        $this->cdb = new ControlPadDB();
        $this->dbh = $this->cdb->dbh;
    }

    function ownwerLogin($u, $p) {
        $u = $this->cdb->escapeString($u);
        $p = $this->cdb->escapeString($p);
        $stmt = $this->dbh->prepare("SELECT Id,name,lastLogin from carsales where contactpersonemail = ? and password= CONCAT('*', UPPER(SHA1(UNHEX(SHA1(?))))) AND _status = '1'");
        $stmt->execute(array($u, $p));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $today = CommonBase::getToday();
            $payment_confirm = Carsale::isSaleActive($today, $today, $row['Id']);
            if (is_array($payment_confirm)) {
                $id = $row['Id'];
                $name = $row['name'];
                $lastLogin = $row['lastLogin'];
                $errmsg = "";
                $_SESSION['slacarsale_Ownwerusername'] = $name;
                $_SESSION['slacarsale_OwnweruserId'] = $id;
                $_SESSION['slacarsale_OwnwerPaymentConfirm'] = $id;
                $_SESSION['slacarsale_OwnerStartDate'] = $payment_confirm['s'];
                $_SESSION['slacarsale_OwnerEndDate'] = $payment_confirm['e'];
                $_SESSION['slacarsale_OwnerAvilableDates'] = CommonBase::dateDiffYMD($today, $payment_confirm['e']);
                $_SESSION['slacarsale_paymetDetails'] = $payment_confirm['array'];
                $_SESSION['slacarsale_Ownwerlastlogin'] = date('l jS \of F Y h:i:s A', strtotime($lastLogin));
                $_SESSION['slacarsale_OwnwerType'] = "ADMIN";
                $_SESSION['slacarsale_userId'] = $id;
                $ip = $_SERVER['REMOTE_ADDR']; //Get there ip address.
                $agent = $_SERVER['HTTP_USER_AGENT']; //Get there user agent, Firefox etc, and some other info about it.
                $logadmin = new Logging();
                $logadmin->log_file = "../logs/login/owner/owner";
                $logadmin->lwrite("ip : $ip ,  Browser : $agent, User Name : $name , User ID : $id");
                $time = CommonBase::getcurrenttime();
                $stmt = $this->dbh->prepare("UPDATE carsales set lastLogin=?,lastIp=? where Id = ?");
                $stmt->execute(array($time, $ip, $id));
                CommonBase::SendRedirect("owner_home.php");
            } else {
                return "* Sorry Your Payment is not Confirm by Admin, please contact Site Administrator";
            }
        } else {
            $userlogin = $this->Userlogin($u, $p);
            if ($userlogin['value']) {
                CommonBase::SendRedirect("owner_home.php");
            } else {
                return $userlogin['txt'];
            }
        }
    }

    function Userlogin($u, $p) {
        $u = $this->cdb->escapeString($u);
        $p = $this->cdb->escapeString($p);
        $stmt = $this->dbh->prepare("SELECT Id,name,lastLogin,fk_carsales from carsale_users where email = ? and password= ? AND _status = '1'");
        $stmt->execute(array($u, $p));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $today = CommonBase::getToday();
            $payment_confirm = Carsale::isSaleActive($today, $today, $row['fk_carsales']);
            if (is_array($payment_confirm)) {
                $id = $row['fk_carsales'];
                $name = $row['name'];
                $lastLogin = $row['lastLogin'];
                $errmsg = "";
                $userID = $row['Id'];
                $username = $row['name'];
                $_SESSION['slacarsale_Ownwerusername'] = $name;
                $_SESSION['slacarsale_OwnweruserId'] = $id;
                $_SESSION['slacarsale_OwnwerPaymentConfirm'] = $id;
                $_SESSION['slacarsale_OwnerStartDate'] = $payment_confirm['s'];
                $_SESSION['slacarsale_OwnerEndDate'] = $payment_confirm['e'];
                $_SESSION['slacarsale_OwnerAvilableDates'] = CommonBase::dateDiffYMD($today, $payment_confirm['e']);
                $_SESSION['slacarsale_paymetDetails'] = $payment_confirm['array'];
                $_SESSION['slacarsale_Ownwerlastlogin'] = date('l jS \of F Y h:i:s A', strtotime($lastLogin));
                $_SESSION['slacarsale_OwnwerType'] = "USER";
                $_SESSION['slacarsale_userId'] = $userID;

                $ip = $_SERVER['REMOTE_ADDR']; //Get there ip address.
                $agent = $_SERVER['HTTP_USER_AGENT']; //Get there user agent, Firefox etc, and some other info about it.
                $logadmin = new Logging();
                $logadmin->log_file = "../logs/login/owner/owner";
                $logadmin->lwrite("ip : $ip ,  Browser : $agent, User Name : $name , User ID : $id Uername :$username  User ID : $userID ");
                $time = CommonBase::getcurrenttime();
                $stmt = $this->dbh->prepare("UPDATE carsale_users set lastLogin=?,lastIp=? where Id = ?");
                $stmt->execute(array($time, $ip, $userID));
                $a['value'] = true;
                $a['txt'] = "";
                return $a;
            } else {
                $a['value'] = FALSE;
                $a['txt'] = "* Sorry Your Payment is not Confirm by Admin, please contact Site Administrator";
                return $a;
            }
        } else {
            $a['value'] = FALSE;
            $a['txt'] = "* incorect Username or Password";
            return $a;
        }
    }

    function ownwerLogout() {
        $time = CommonBase::getcurrenttime();
        $ip = $_SERVER['REMOTE_ADDR']; //Get there ip address.
        $agent = $_SERVER['HTTP_USER_AGENT']; //Get there user agent, Firefox etc, and some other info about it.

        $aName = $_SESSION['slacarsale_Ownwerusername'];
        $aId = $_SESSION['slacarsale_OwnweruserId'];
        $llt = $_SESSION['slacarsale_Ownwerlastlogin'];

        $logadmin = new Logging();
        $logadmin->log_file = "../logs/login/owner/owner";
        $logadmin->lwrite("LOG OUT OWNER ( LOGIN:$llt  LOGOUT:$time  ip : $ip ,  Browser : $agent, Admin ID : $aId Admin Name : $aName )");

        $_SESSION['slacarsale_Ownwerusername'] = NULL;
        $_SESSION['slacarsale_OwnweruserId'] = NULL;
        $_SESSION['slacarsale_OwnwerPaymentConfirm'] = NULL;
        $_SESSION['slacarsale_OwnerStartDate'] = NULL;
        $_SESSION['slacarsale_OwnerEndDate'] = NULL;
        $_SESSION['slacarsale_OwnerAvilableDates'] = NULL;
        $_SESSION['slacarsale_paymetDetails'] = NULL;
        $_SESSION['slacarsale_Ownwerlastlogin'] = NULL;
        $_SESSION['slacarsale_OwnwerType'] = NULL;

        unset($_SESSION['slacarsale_Ownwerusername']);
        unset($_SESSION['slacarsale_OwnweruserId']);
        unset($_SESSION['slacarsale_OwnwerPaymentConfirm']);
        unset($_SESSION['slacarsale_OwnerStartDate']);
        unset($_SESSION['slacarsale_OwnerEndDate']);
        unset($_SESSION['slacarsale_OwnerAvilableDates']);
        unset($_SESSION['slacarsale_paymetDetails']);
        unset($_SESSION['slacarsale_Ownwerlastlogin']);
        unset($_SESSION['slacarsale_OwnwerType']);

        CommonBase::SendRedirect("ownerlogin.php");
    }

    /**
     * Verifies a plaintext password against the legacy MySQL PASSWORD()-style
     * hash this app historically stored: '*' + UPPER(SHA1(UNHEX(SHA1(password)))).
     * Kept only so existing accounts can still log in; successful legacy
     * verification triggers a transparent upgrade to password_hash()/bcrypt.
     */
    private function verifyLegacyHash($password, $storedHash) {
        $inner = sha1($password, false);
        $innerBin = hex2bin($inner);
        $legacyHash = '*' . strtoupper(sha1($innerBin, false));
        return hash_equals((string) $storedHash, $legacyHash);
    }

    function AdminLogin($u, $p) {
        $u = trim((string) $u);

        $stmt = $this->dbh->prepare("SELECT Id, username, password, lastLogin, super_admin from system_admin where username = ? AND _status = '1'");
        $stmt->execute(array($u));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $valid = false;
        if ($row) {
            $stored = (string) $row['password'];
            if (password_get_info($stored)['algo'] !== null) {
                // modern hash (bcrypt/argon2)
                $valid = password_verify($p, $stored);
            } else {
                // legacy hash - verify, then transparently migrate to bcrypt
                $valid = $this->verifyLegacyHash($p, $stored);
                if ($valid) {
                    $newHash = password_hash($p, PASSWORD_BCRYPT);
                    $upd = $this->dbh->prepare("UPDATE system_admin SET password = ? WHERE Id = ?");
                    $upd->execute(array($newHash, $row['Id']));
                }
            }
        }

        if ($valid) {
            $session_head = isset($_SESSION['app_pro']['session_head']) ? $_SESSION['app_pro']['session_head'] : "";
            $id = $row['Id'];
            $name = $row['username'];
            $lastLogin = $row['lastLogin'];
            $errmsg = "";
            session_regenerate_id(true);
            $_SESSION[$session_head . 'Adminusername'] = $name;
            $_SESSION[$session_head . 'AdminuserId'] = $id;
            $_SESSION[$session_head . 'Adminlastlogin'] = date('l jS \of F Y h:i:s A', strtotime($lastLogin));
            $_SESSION[$session_head . 'AdminSuperAdmin'] = (int) $row['super_admin'];

            $ip = $_SERVER['REMOTE_ADDR']; //Get there ip address.
            $agent = $_SERVER['HTTP_USER_AGENT']; //Get there user agent, Firefox etc, and some other info about it.

            $logadmin = new Logging();
            $logadmin->log_file = "../logs/login/admin/admin";
            $logadmin->lwrite("ip : $ip ,  Browser : $agent, User Name : $name , User ID : $id");

            $time = CommonBase::getcurrenttime();
            $stmt = $this->dbh->prepare("UPDATE system_admin set lastLogin=?, `lastIp`=?  where Id = ?");
            $stmt->execute(array($time, $ip, $id));
            CommonBase::SendRedirect("dashboard.php");
        } else {
            return CommonBase::createnotify($type = "error", $headding = "Login Failed !", $massage = "Incorrect username or password, Please Contact System Administrator", true);
        }
    }

    function AdminLogout() {
        $time = CommonBase::getcurrenttime();
        $ip = $_SERVER['REMOTE_ADDR']; //Get there ip address.
        $agent = $_SERVER['HTTP_USER_AGENT']; //Get there user agent, Firefox etc, and some other info about it.
        $session_head = isset($_SESSION['app_pro']['session_head']) ? $_SESSION['app_pro']['session_head'] : "";
       
        $aName = $_SESSION[$session_head.'Adminusername'];
        $aId = $_SESSION[$session_head.'AdminuserId'];
        $llt = $_SESSION[$session_head.'Adminlastlogin'];

        $logadmin = new Logging();
        $logadmin->log_file = "../logs/login/admin/admin";
        $logadmin->lwrite("LOG OUT Admin ( LOGIN:$llt  LOGOUT:$time  ip : $ip ,  Browser : $agent, Admin ID : $aId Admin Name : $aName )");

        $_SESSION[$session_head.'Adminusername'] = NULL;
        $_SESSION[$session_head.'AdminuserId'] = NULL;
        $_SESSION[$session_head.'Adminlastlogin'] = NULL;
        unset($_SESSION[$session_head.'Adminusername']);
        unset($_SESSION[$session_head.'AdminuserId']);
        unset($_SESSION[$session_head.'Adminlastlogin']);
        CommonBase::SendRedirect("index.php");
    }

}

?>
