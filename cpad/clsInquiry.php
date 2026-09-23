<?php

class Inquiry {

    public static function add($name, $email, $phone, $message, $fk_advert = null, $ip = null) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("INSERT INTO inquiries (fk_advert, name, email, phone, message, status, ip, addt) VALUES (?, ?, ?, ?, ?, 0, ?, ?)");
        return $stmt->execute(array($fk_advert, $name, $email, $phone, $message, $ip, CommonBase::getcurrenttime()));
    }

    public static function getAll() {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT i.*, a.modeltxt, a.chasi FROM inquiries i LEFT JOIN advert a ON a.Id = i.fk_advert ORDER BY i.Id DESC");
        $stmt->execute();
        return $stmt;
    }

    public static function getById($id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT i.*, a.modeltxt, a.chasi FROM inquiries i LEFT JOIN advert a ON a.Id = i.fk_advert WHERE i.Id = ?");
        $stmt->execute(array($id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        }
    }

    public static function getUnreadCount() {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        return (int) $dbh->query("SELECT COUNT(*) FROM inquiries WHERE status = 0")->fetchColumn();
    }

    public static function getRecent($count = 5) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $count = (int) $count;
        $stmt = $dbh->prepare("SELECT i.*, a.modeltxt, a.chasi FROM inquiries i LEFT JOIN advert a ON a.Id = i.fk_advert ORDER BY i.Id DESC LIMIT $count");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function markRead($id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("UPDATE inquiries SET status = 1 WHERE Id = ?");
        return $stmt->execute(array($id));
    }

    public static function delete($id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("DELETE FROM inquiries WHERE Id = ?");
        return $stmt->execute(array($id));
    }

}

?>
