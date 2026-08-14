<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsShop
 *
 * @author Nuza
 */
class User {

    public static function get_privilage($fk_type = NULL) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        if ($fk_type == null) {
            $stmt = $dbh->prepare("SELECT * from system_admin_privilage_type where `_status` = 1 ");
            $stmt->execute();
        } else {
            $stmt = $dbh->prepare("SELECT * from system_admin_privilage_property where `_status` = 1  and  fk_system_admin_privilage_type = ? ");
            $stmt->execute(array($fk_type));
        }

        return $stmt;
    }

    public static function getAll_privielage_by_user($user_id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * from system_admin_privilage where fk_system_admin =? ");
        $stmt->execute(array($user_id));
        return $stmt;
    }

    public static function getAll_privielage_Array_by_user($user_id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * from system_admin_privilage where fk_system_admin =? ");
        $stmt->execute(array($user_id));
        $r_arr = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $property = CommonBase::getname($row['fk_system_admin_privilage_property'], "system_admin_privilage_property", "property_name");
            array_push($r_arr, $property);
        }
        return $r_arr;
    }

    public static function getUserById($id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * from system_admin where `_status` = 1 and `Id`= ?");
        $stmt->execute(array($id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        }
    }

    public static function getAllUsers() {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * from system_admin where `_status` = 1 ");
        $stmt->execute();
        return $stmt;
    }

    public static function isUsernameAvailable($name) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT username from system_admin where `_status` = 1 and username=? ");
        $stmt->execute(array($name));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return TRUE;
        }
        return FALSE;
    }

    public static function isUsernameAvailableEdit($name, $id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT Id, username from system_admin where `_status` = 1 and `username`=? ");
        $stmt->execute(array($name));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['Id'] == $id) {
                return FALSE;
            } else {
                return true;
            }
        }
        return FALSE;
    }

}

?>
