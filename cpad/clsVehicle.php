<?php

class Vehicle {



 public static function getVehicle($id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * FROM advert WHERE `Id` = ?");
        $stmt->execute(array($id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        }
    }

    public static function stockCount() {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT count(*) as cnt FROM advert");
        $stmt->execute([]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return CommonBase::formatMoney($row['cnt'], 0);
        }
        return 0;
    }

    public static function getAllCatogaryFilter($q, $arr, $name = "Filter BY Catogory : ", $allKey = "All Properties") {

        $s = '<ul id="portfolio-filter" class="filter"><li>Filter</li><li><a href="#" data-filter="*" >' . $allKey . '</a></li>';
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;

        $stmt = $dbh->prepare($q);
        $stmt->execute($arr);
        $string = "";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $string .= $row['fk_type'] . ",";
        }
         
        $string = rtrim($string, ",");
        $stmt = $dbh->prepare("SELECT * FROM type WHERE `status` = 1 and `Id` in($string)");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $name = "." . $row['Id'];
            $name_2 = $row['name'];
            $s .= '<li><a href="#" data-filter="'.$name.'" >' . $name_2 . '</a></li>';
        }
        $s .= "</ul>";

        return $s;
    }

    public static function getPrprice($row, $name_n = FALSE) {
        if ($row['highestoffer'] == 1) {
            return "Highest offer";
        } else {
            if ($name_n) {
                return "<small>" . CommonBase::getname($row['fk_price_type'], "price_type") . "</small> <strong>" .
                        CommonBase::formatMoney($row['price'], 0) . "</strong> ";
            } else {
                return "<small>" . CommonBase::getname($row['fk_price_type'], "price_type") . "</small> <strong>" .
                        CommonBase::formatMoney($row['price'], 0) . "</strong> <small>" . CommonBase::getname($row['fk_price_per'], "price_per") . "</small>";
            }
        }
    }

    public static function addZeroFirft($number, $count = 5) {
        return str_pad("$number", $count, '0', STR_PAD_LEFT);
    }

    public static function createUrl($row, $name = 0) {
        $page = "used-japanese-vehicle-details.php";
        return CommonBase::getServer() . "/" . $page . "?id=" . CommonBase::encrypt($row['Id']);
        $make = trim(str_replace(" ", "-", Vehicle::getname($row['fk_make'], "make")));
        $year = trim(explode("-",  $row['yearmonth'])[0]);
        $year = $year;
        $model = trim(str_replace(" ", "-", Vehicle::getname($row['fk_model'], "model")));
        $gear = trim(str_replace(" ", "-", Vehicle::getname($row['fk_transmission'], "transmission")));
        if ($name == 1) {
            return Vehicle::getname($row['fk_make'], "make") . " " . Vehicle::getname($row['fk_model'], "model")." ".$year;
        }
        if ($name == 2) {
            return str_pad("View - $make $model", 50, ' ', STR_PAD_BOTH);
        }

        return CommonBase::getServer() . "/" . CommonBase::encrypt($row['Id']) . "/$year-$make-$model-$gear.html";
    }

    public static function getAll_vehicle_search($get_arr, $quary_ser = false) {
        $Stock = $Category = $Make = $Model = $BodyType = $Transmission = $FuelType = $BaseColur = null;
        $ys = $ye = $key = $chasi = $id = $std = $ed = null;
        extract($get_arr);

        $q = " select a.* from advert a WHERE a.status = 1 ";
        $value = array();

        if ($Stock != null) {
            $q .= "AND a.fk_stock = ? ";
            array_push($value, CommonBase::decrypt($Stock));
        }
        if ($Category != null) {
            $q .= "AND a.fk_type = ?";
            array_push($value, CommonBase::decrypt($Category));
        }
        if ($Make != null) {
            $q .= "AND a.fk_make = ?";
            array_push($value, CommonBase::decrypt($Make));
        }
        if ($Model != null) {
            $q .= "AND a.fk_model = ?";
            array_push($value, CommonBase::decrypt($Model));
        }
        if ($BodyType != null) {
            $q .= "AND a.fk_body_type = ?";
            array_push($value, CommonBase::decrypt($BodyType));
        }
        if ($Transmission != null) {
            $q .= "AND a.fk_transmission = ?";
            array_push($value, CommonBase::decrypt($Transmission));
        }
        if ($FuelType != null) {
            $q .= "AND a.fk_fuel = ?";
            array_push($value, CommonBase::decrypt($FuelType));
        }
        if ($BaseColur != null) {
            $q .= "AND a.fk_color = ?";
            array_push($value, CommonBase::decrypt($BaseColur));
        }
        if ($ys != null && $ye != null) {
            $q .= "AND  a.yearmonth BEtWEEN ? AND ?+1 ";
            array_push($value, $ys);
            array_push($value, $ye);
        }
        if ($key != null) {
            $q .= "AND (a.`search` LIKE ? OR a.`Id` = ? OR a.modeltxt LIKE ? )";
            array_push($value, "%$key%");
            array_push($value, "%$key%");
            array_push($value, "%$key%");
        }
        if ($chasi != null) {
            $chasi = str_replace("*", "%", $chasi);
            $q .= "AND  a.chasi LIKE ?  ";
            array_push($value, $chasi);
            $chasi = str_replace("%", "*", $chasi);
        }
        if ($id != null) {
            $q .= "AND a.Id =? ";
            array_push($value, $id);
        }

        if ($std != null && $ed != null) {
            $s_date = date("Y-m-d", strtotime($std));
            $e_date = date("Y-m-d", strtotime($ed));
            if ($s_date < $e_date || $s_date == $e_date) {
                $q .= "And addt BETWEEN ? AND ?";
                array_push($value, $s_date);
                array_push($value, $e_date);
            } else {
                //echo CommonBase::jsAlert("invalid Date Range");
                // exit();
            }
        }

        $q .= " ORDER BY Id desc";
        $quary = $q;
        $arr = $value;
        $myCon = new ControlPadDB;
        $dbh = $myCon->dbh;

        if ($quary_ser) {
            $return['q'] = $quary;
            $return['q_count'] = str_replace("a.*", "Count(*) as cnt", $quary);
            $return['v'] = $arr;
            return $return;
        } else {

            $stmt = $dbh->prepare($quary);
            $stmt->execute($arr);
            return $stmt;
        }
    }

    public static function getImageById($id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * from advert_images where `_status` = 1 and `Id`= ?");
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
        $row = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        }
        if (empty($row)) {
            $row['image_name'] = CommonBase::getProperty()['no_image_name'];
            $row['mpath'] = CommonBase::getProperty()['no_image_mpath'];
            $row['tpath'] = CommonBase::getProperty()['no_image_tpath'];
            return $row;
        }
    }

    public static function getAlltype() {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * FROM type WHERE status = 1");
        $stmt->execute(array($id));
        $q = "";

        $column = 0;
        $count = 1;
        $html = "";
        $html .= '<table width="650" border="0" cellspacing="0" cellpadding="5" style="margin-left:10px;" align="center">';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $count = self::getVehicleCountByFK("fk_type", $row['Id']);
            $vcount = ($count != 0) ? "  <b>(</b> $count <b>)</b>" : "";
            $name = $row['name'] . $vcount;

            $id = CommonBase::encrypt($row['Id']);
            $server = CommonBase::getServer();
            $img = $server . $row['imgpath'] . $row['imgname'];

            if ($column == 0)
                $html .= '<tr>';

            $html .= "<td><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"typeTBL\">
  <tr>
    <td  align=\"center\" valign=\"top\" ><a href=\"" . $server . '/searchResult.php?&carsale_search=+++&type=' . $id . '&carsale=' . CommonBase::encrypt(CommonBase::getcarsaleId()) . "\">
        <img src=\"$img\" width=\"42\" height=\"21\" /></a></td>
  </tr>
  <tr>
    <td align=\"center\" valign=\"top\"  ><a class=\"viewmore\" href=\"" . $server . '/searchResult.php?&carsale_search=+++&type=' . $id . '&carsale=' . CommonBase::encrypt(CommonBase::getcarsaleId()) . "\">
        $name</a></td>
  </tr>
</table></td>";

            $column++;
            if ($column >= 8) {
                $column = 0;

                $html .= '</tr>';
            }
            $count++;
        }
        $html .= "</table>";

        return $html;
    }

    public static function getOtherImgeById($id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("Select * from extra_images WHERE `Id` =? ");
        $stmt->execute(array($id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        }
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

    public static function getAllOtherImages($vid) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("Select * from extra_images WHERE `_status` = 1 and  fk_advert = ?  ");
        $stmt->execute(array($vid));
        $arr = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($arr, $row);
        }
        return $arr;
    }

    public static function getALLUNSOLD() {
        $myCon = new ControlPadDB;
        $dbh = $myCon->dbh;
        $stmt = $dbh->prepare("SELECT * FROM advert WHERE flow = 1 and status != 0 order by `Id` desc");
        $stmt->execute();
        return $stmt;
    }

    public static function getvehicleByID($id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * FROM advert WHERE `Id` = ? and status = 1");
        $stmt->execute(array($id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        }
    }
        public static function getDocumentByID($id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * FROM documents WHERE `Id` = ?");
        $stmt->execute(array($id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        }
    }

    public static function getDocumentCount($vid) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT count(*) as cnt FROM documents WHERE fk_advert = ? and `_status` = 1");
        $stmt->execute(array($vid));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['cnt'];
        } else {
            return 0;
        }
    }

    public static function getVehicleCountByFK($clumName, $tableID, $id_arr = false) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $count = 0;

        if (!is_numeric($tableID)) {
            $stmt = $dbh->prepare("SELECT count(*) as cnt FROM advert WHERE $clumName IN($tableID) and `status` = 1 and flow =1");
            $stmt->execute(array($tableID));
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $count = $row['cnt'];
            }
        } else {
            $stmt = $dbh->prepare("SELECT count(*) as cnt FROM advert WHERE $clumName = ? and `status` = 1 and flow =1");
            $stmt->execute(array($tableID));
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $count = $row['cnt'];
            }
        }


        return $count;
    }

    public static function getRecordsByVehicle($id, $type = 'd') {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        if ($type == 'd') {
            $stmt = $dbh->prepare("SELECT * from documents where fk_advert = ? and `_status` != 0 ");
        }
        $stmt->execute(array($id));
        return $stmt;
    }

    public static function createSelect($id, $name, $type = 1, $class = "", $title = "", $q = "" , $disable = false) {

        if (!is_numeric($id)) {
            $id = CommonBase::decrypt($id);
        }
        if ($type == 1) {
            $q = "SELECT Id,`name` FROM `type` WHERE status = 1 order by `Id` asc ";
        }
        if ($type == 2) {
            $q = "SELECT `Id`,`name` FROM province";
        }
        $sd ="";
        $query = $q;
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt2 = $dbh->prepare($query);
        $stmt2->execute();
        $zero = "";
        if ($disable) {
            $sd = "disabled";
        }

        $stmt = "<select name=\"$name\" id=\"$name\" title=\"$title\" class=\"$class\" $sd > ";
        if ($id == null || $id == "" || $id == 0) {
            $stmt .="<option selected=\"selected\"  value='$zero'>Select</option>";
        }
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $memnum = CommonBase::encrypt($row['Id']);
            $name = $row['name'];
            if ($id != null && $id == $row['Id']) {
                $stmt .="<option selected=\"selected\" value='$memnum'>$name</option>";
            } else {
                $stmt .="<option value='$memnum'>$name</option>";
            }
        }

        $stmt .= "</select>";
        return $stmt;
    }

    public static function createSelectSearch($id, $name, $type = 1, $class = "", $title = "", $q = "", $columName = "") {
        $id = CommonBase::decrypt($id);
        if ($type == 1) {
            $q = "SELECT Id,`name` FROM `type` WHERE status = 1 order by `Id` asc ";
        }
        if ($type == 2) {
            $q = "SELECT `Id`,`name` FROM province";
        }

        $query = $q;
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt2 = $dbh->prepare($query);
        $stmt2->execute();
        $zero = "";
        $vcount = "";
        $stmt = "<select name=\"$name\" id=\"$name\" title=\"$title\" class=\"$class\"> ";

        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            if ($columName != NULL) {
                $count = self::getVehicleCountByFK($columName, $row['Id']);
                $vcount = ($count != 0) ? "  <b>(</b> $count <b>)</b>" : "";
            }
            $memnum = CommonBase::encrypt($row['Id']);
            $name = $row['name'];

            if ($id != null && $id == $row['Id']) {

                $stmt .="<option selected=\"selected\" value='$memnum'>$name $vcount</option>";
            } else {
                $stmt .="<option value='$memnum'>$name $vcount</option>";
            }
        }
        if ($id == null || $id == "" || $id == 0) {
            $stmt .="<option selected=\"selected\"  value=''>Any</option>";
        } else {
            $stmt .="<option  value=''  >Any</option>";
        }
        $stmt .= "</select>";
        return $stmt;
    }

    public static function getmodelByIdSelect($id, $fk, $type = 1) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        if ($type == 1) {
            $query = "select Id,name from model WHERE fk_make = ? and status =1";
        }
        if ($type == 2) {
            $query = "select Id,name from chasicode WHERE fk_model = ? and status =1";
        }
        $stmt2 = $dbh->prepare($query);
        $stmt2->execute(array($fk));
        $stmt = "";
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $memnum = CommonBase::encrypt($row['Id']);
            $name = $row['name'];
            if ($id != null && $id == $row['Id']) {
                $stmt .="<option selected=\"selected\" value='$memnum'>$name</option>";
            } else {
                $stmt .="<option value='$memnum'>$name</option>";
            }
        }
        return $stmt;
    }

    public static function getname($id, $tblname, $field = "name") {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT $field as name from $tblname WHERE Id = ?");

        $lotNum = null;
        $stmt->execute(array($id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $lotNum = $row['name'];
        }

        return $lotNum;
    }

    public static function getLetestVehicles($count) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * from advert WHERE status = 1 ORder by ref desc Limit $count");
        $stmt->execute();
        return $stmt;
    }

    public static function get_filted_Vehicles($clumName, $tableID, $count = null) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $return = null;
        $limit = (is_numeric($count)) ? "LIMIT $count" : "";
        if (!is_numeric($tableID)) {
            $stmt = $dbh->prepare("SELECT * FROM advert WHERE $clumName IN($tableID) and `status` = 1 and flow =1 ORDER BY Id desc $limit");
            $stmt->execute(array($tableID));
            $return = $stmt;
        } else {
            $stmt = $dbh->prepare("SELECT * FROM advert WHERE $clumName = ? and `status` = 1 and flow =1  ORDER BY Id desc $limit");
            $stmt->execute(array($tableID));
            $return = $stmt;
        }
        return $return;
    }

}

?>
