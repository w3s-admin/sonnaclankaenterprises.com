<?php

class Review {

    public static function getAllReviews() {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * FROM review");
        $stmt->execute();
        return $stmt;
    }

    public static function getReviewById($id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * FROM review WHERE Id = ?");
        $stmt->execute(array($id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        }
    }

    public static function addReview($customer_name, $title, $country, $comment, $image_path, $image_name) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $now = CommonBase::getcurrenttime();
        $query = "INSERT INTO review (customer_name, title, country, comment, image_path, image_name) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $dbh->prepare($query);
        $done = $stmt->execute(array(
            $customer_name,
            $title,
            $country,
            $comment,
            $image_path,
            $image_name
        ));
        return $done;
    }

    public static function updateReview($reviewID, $customer_name, $title, $country, $comment) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $now = CommonBase::getcurrenttime();
        $query = "UPDATE review SET customer_name = ?, title = ?, country = ?, comment = ? WHERE Id = ?";
        $stmt = $dbh->prepare($query);
        $done = $stmt->execute(array(
            $customer_name,
            $title,
            $country,
            $comment,
            $reviewID
        ));
        return $done;
    }

    public static function deleteReview($reviewID) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("DELETE FROM review WHERE Id = ?");
        $done = $stmt->execute(array($reviewID));
        return $done;
    }

}

?>
