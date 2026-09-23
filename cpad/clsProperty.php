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
class Property {

    public static function getRelatedItem($row, $count = 8) {
        $c = 0;
        $main = $row['fk_main'];
        $main_type = $row['fk_property_type'];
        $loation = $row['fk_location'];
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("select * from advert WHERE `_status` = 1 and (fk_main = ? or fk_location =? or fk_property_type = ?  )");
        $stmt->execute(array($main, $loation, $main_type));
        $arr = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($arr, $row);
            $c++;
        }
        if ($c < $count) {
            $stmt = $dbh->prepare("select * from advert WHERE `_status` = 1 ");
            $stmt->execute();
            $arr = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($arr, $row);
                $c++;
                if ($c == $count) {
                    break;
                }
            }
        }

        return $arr;
    }

    public static function getResultCountBySearch($quary, $value) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare($quary);
        $stmt->execute($value);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['cnt'];
        }
    }

    public static function getAllCatogaryFilter($q, $arr, $name = "Filter BY Catogory : ", $allKey = "All Properties") {

        $s = '<ul class="gallerynav"><li class="selected-1"><a href="#" data-value="all">' . $allKey . '<span></span></a></li>';
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;

        $stmt = $dbh->prepare($q);
        $stmt->execute($arr);
        $string = "";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $string .= $row['fk_property_type'] . ",";
        }

        $string = rtrim($string, ",");
        $stmt = $dbh->prepare("SELECT * FROM property_type WHERE `_status` = 1 and `Id` in($string)");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $name = "pro_" . $row['Id'];
            $name_2 = $row['name'];
            $s .= '<li><a href="#" data-value="' . $name . '">' . $name_2 . '<span></span></a></li>';
        }
        $s .= "</ul>";

        return $s;
    }

    public static function getPrprice($row, $name_n = FALSE) {
        if ($row['highestoffer'] == 1) {
            return "Highest offer";
        } else {
            if ($name_n) {
                  return "<small>" . CommonBase::getname($row['fk_price_types'], "price_types") . "</small> <strong>" .
                    CommonBase::formatMoney($row['price'], 0) . "</strong> " ;
            }  else {
                  return "<small>" . CommonBase::getname($row['fk_price_types'], "price_types") . "</small> <strong>" .
                    CommonBase::formatMoney($row['price'], 0) . "</strong> <small>" . CommonBase::getname($row['fk_price_per'], "price_per") . "</small>" ;
            }
            
          
        }
    }

    public static function createUrl($row, $name_n = FALSE) {

        $main_cat = trim(str_replace(" ", "-", CommonBase::getname($row['fk_location'], "location")));
        $sub_cat = trim(str_replace(" ", "-", CommonBase::getname($row['fk_property_type'], "property_type")));
        $secount_sub = trim(str_replace(" ", "-", CommonBase::getname($row['fk_main'], "main")));
        $available = trim(str_replace(" ", "-", CommonBase::getname($row['fk_availability'], "availability")));
        if ($name_n) {
            return "$sub_cat-$secount_sub-$name";
        }
        return CommonBase::getServer() . "mercantile-real-estate-property-details-srilanka/" . CommonBase::encrypt($row['Id']) . "/$main_cat-$sub_cat-$secount_sub-$available.html";
    }

    public static function getAdvertSQL($count) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * from advert WHERE _status = 1  ORder by Id desc Limit $count");
        $stmt->execute();
        return $stmt;
    }

    public static function getTitle($row) {

        return CommonBase::getname($row['fk_property_type'], "property_type") . ' for ' . CommonBase::getname($row['fk_main'], "main") . ' at ' . CommonBase::getname($row['fk_location'], "location");
    }

    public static function getPropertyImageById($id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * from advert_images where `_status` = 1 and `Id`= ?");
        $stmt->execute(array($id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        }
    }

    public static function getPropertyById($id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * from advert where `_status` = 1 and `Id`= ?");
        $stmt->execute(array($id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        }
    }

    public static function getAllimages($fk_advet) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * from advert_images where `_status` = 1 and fk_advert= ? order by Id asc");
        $stmt->execute(array($fk_advet));
        $arr = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($arr, $row);
        }
        return $arr;
    }

    public static function getFirastimage($fk_advet) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * from advert_images where `_status` = 1 and fk_advert= ? order by Id asc limit 1");
        $stmt->execute(array($fk_advet));
        $arr = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        }
    }

    public static function getImageById($id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * from advert_images where `Id` = ?");
        $stmt->execute(array($id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        }
    }

    public static function getAllProperty($get_arr, $quary_ser = false) {
        extract($get_arr);

        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $quary = "select * from advert WHERE `_status` = 1 ";
        $arr = array();



        if (isset($fk_main) && is_numeric(CommonBase::decrypt($fk_main))) {
            $quary .= " and fk_main = ?  ";
            array_push($arr, CommonBase::decrypt($fk_main));
        }

        if (isset(${'fk_property_type'}) && is_numeric(CommonBase::decrypt(${'fk_property_type'}))) {
            $quary .= " and fk_property_type = ?  ";
            array_push($arr, CommonBase::decrypt(${'fk_property_type'}));
        }

        if (isset(${'fk_location'}) && is_numeric(CommonBase::decrypt(${'fk_location'}))) {
            $quary .= " and fk_location = ?  ";
            array_push($arr, CommonBase::decrypt(${'fk_location'}));
        }

        if (isset(${'ref'}) && is_numeric(${'ref'})) {
            $quary .= " and Id = ?  ";
            array_push($arr, ${'ref'});
        }

        if (isset(${'a1'}) && isset(${'a2'}) && is_numeric(${'a1'}) && is_numeric(${'a2'})) {
            $quary .= " and Price BETWEEN ? and  ?  ";
            array_push($arr, ${'a1'});
            array_push($arr, ${'a2'});
        }

        $quary .= " order by Id desc ";
        if ($quary_ser) {
            $return['q'] = $quary;
            $return['q_count'] = str_replace("*", "Count(*) as cnt", $quary);
            $return['v'] = $arr;
            return $return;
        } else {

            $stmt = $dbh->prepare($quary);
            $stmt->execute($arr);
            return $stmt;
        }
    }

}

?>
