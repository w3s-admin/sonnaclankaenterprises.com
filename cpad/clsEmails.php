<?php

require_once 'clsVehicle.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsPriceList
 *
 * @author hp-dv6-1315tx
 */
class Emails {

    static $Email_count_max = 300;

    public static function add_to_email($email) {

        if (!Emails::isemailAvailable($email)) {
            $cdb = new ControlPadDB();
            $dbh = $cdb->dbh;
            $time = CommonBase::getcurrenttime();
            $stmt = $dbh->prepare("INSERT INTO emailadress( email, status) VALUES(?,1)");
            $done = $stmt->execute(array($email));
            return $done;
        }
        return false;
    }

    public static function cheksendcount() {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT COUNT(*) as c  from `emailadress`  WHERE selected = '1'");
        $stmt->execute();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cnt = $row['c'];
            if ($cnt <= self::$Email_count_max) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public static function cheksendcount_all() {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT COUNT(*) as c  from `emailadress`  WHERE selected = '1'");
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $scnt = $row['c'];
        }
        $stmt = $dbh->prepare("SELECT COUNT(*) as c  from `emailadress`  WHERE selected = '1'");
        $stmt->execute();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $noncnt = $row['c'];
        }
        $cnt = $noncnt + $scnt;
        if ($cnt > self::$Email_count_max) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function SelectSearch($id = 1) {
        $stmt = "";
        if ($id == 1) {
            $stmt .="<option selected=\"selected\" value='1'>Email</option>";
        } else {
            $stmt .="<option value='1'>Email</option>";
        }
        if ($id == 2) {
            $stmt .="<option selected=\"selected\" value='2'>Name</option>";
        } else {
            $stmt .="<option value='2'>Name</option>";
        }
        if ($id == 3) {
            $stmt .="<option selected=\"selected\" value='3'>#Id</option>";
        } else {
            $stmt .="<option value='3'>#Id</option>";
        }

        return $stmt;
    }

    public static function getEmailById($id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * FROM emailadress where `Id` = ?");
        $stmt->execute(array($id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        } else {
            return FALSE;
        }
    }

    public static function isemailAvailable($email) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * FROM emailadress where status = 1 and email = ? ORDER BY `Id`");
        $stmt->execute(array($email));
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function isEmialsAvailableEdit($email, $Id) {

        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * FROM emailadress where status = 1 and email = ? ORDER BY `Id`");
        $stmt->execute(array($email));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['Id'] == $Id) {
                return false;
            } else {
                return true;
            }
        }
    }

    public static function getallemails($type = 1) {
        $q = "";
        if ($type == 1) {
            $q = "SELECT * FROM  emailadress where status = 1 and selected = 0 ORDER BY `Id`";
        }
        if ($type == 2) {
            $q = "SELECT * FROM  emailadress where status = 1 and selected = 1 ORDER BY `selectedtime` DESC";
        }
        if ($type == 3) {
            $q = "SELECT * FROM  emailadress where status = 1 ORDER BY `Id` ASC";
        }
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare($q);
        $stmt->execute();
        return $stmt;
    }

    public static function getallemails_count($type = 1) {
        $q = "";
        if ($type == 1) {
            $q = "SELECT count(*) as cnt FROM  emailadress where status = 1 and selected = 0 ORDER BY `Id`";
        }
        if ($type == 2) {
            $q = "SELECT count(*) as cnt FROM  emailadress where status = 1 and selected = 1 ORDER BY `selectedtime` DESC";
        }
        if ($type == 3) {
            $q = "SELECT count(*) as cnt FROM  emailadress where status = 1 ORDER BY `selectedtime` DESC";
        }
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare($q);
        $stmt->execute();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['cnt'];
        }
    }

    public static function getallvehicles($type = 1) {
        $q = "";
        if ($type == 1) {

            $q = "SELECT * FROM  advert where selected = 0 and status = 1 and flow = 1  ORDER BY `ref` Desc";
        }
        if ($type == 2) {
            $q = "SELECT * FROM  advert where selected = 1 and status = 1 and flow = 1 ORDER BY `selectedtime` DESC";
        }
        $cdb = new ControlPadDB();
        // $dbh_sonec = $cdb->dbh;
        $dbh_sonec = $cdb->dbh;
        $stmt = $dbh_sonec->prepare($q);
        $stmt->execute();
        return $stmt;
    }

    public static function downloadImg($Id) {
        $q = "SELECT image1 FROM  advert where `Id` = ?";
        $cdb = new ControlPadDB();
        $dbh_sonec = $cdb->dbh;
        $stmt = $dbh_sonec->prepare($q);
        $stmt->execute(array($Id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //    $name = 'http://www.sonnaclanka.lk/admin99447/' . $row['image1'];
            $name = CommonBase::getServer() . '/admincontent/vimg/' . $row['image1'];
            var_dump($name);
            $imgname = basename($name);
            $img = 'images/newslatter/dwnimg/' . $imgname;
            //file_put_contents($img, file_get_contents($name));
            $ch = curl_init($name);
            $fp = fopen($img, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            return true;
        }
    }

    public static function delImg($Id) {
        $q = "SELECT image1 FROM  advert where `Id` = ?";
        $cdb = new ControlPadDB();
        $dbh_sonec = $cdb->dbh;
        $stmt = $dbh_sonec->prepare($q);
        $stmt->execute(array($Id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //  $name = 'http://www.sonnaclanka.lk/admin99447/' . $row['image1'];
            //  $imgname = basename($name);
            $img = 'images/newslatter/dwnimg/' . $row['image1'];
            unlink($img);
            return true;
        }
    }

    public static function getAvailableEmails($plain = FALSE) {

        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT email,Id from emailadress WHERE selected = 1 and status = 1 order by Id asc Limit 400");
        $stmt->execute();

        $emails = '';
        while ($row2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($plain) {
                $emails .= $row2['email'] . ",";
            } else {
                $emails .= "<span class=\"badge badge-info \">" . $row2['email'] . "</span>&nbsp;";
            }
        }

        return substr(trim($emails), 0, -1);
    }

    public static function viewNewslatter() {

        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        //$stmt = $dbh->prepare("SELECT model_no,fuel,eng_cap,mileage,trans,price,aid,image1 FROM advert where selected = 1 ORDER BY `Id`");
        $stmt = $dbh->prepare("SELECT * FROM advert where selected = 1 and status != 0 ORDER BY `Id`");
        $stmt->execute();

        $count = 0;
        $st = TRUE;
        $tbl = '';
        $Images = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            //$name = 'http://www.sonnaclanka.lk/admin99447/' . $row['image1'];
            $imgname = $row['image1'];
            $img = 'images/newslatter/dwnimg/' . $imgname;

            array_push($Images, $img);
            $server = CommonBase::getServer();
            $img = Vehicle::getFirastimage($row['Id']);
            $img = Emails::cimg($server . $img['tpath'] . $img['image_name'], '210', '135', $row['modeltxt'], "height: 135px;");

            $ym = explode("-", $row['yearmonth'])[0];

            $url = Vehicle::createUrl($row);

            $Chassis = $row['chasi'];
            $Fuel = CommonBase::getname($row['fk_fuel'], "fuel");
            $eacp = $row['eng_cap'] . " CC";
            $Mileage = $row['mileage'] . " KM";
            $make = CommonBase::getname($row['fk_make'], "make");
            $model = CommonBase::getname($row['fk_model'], "model");
            $Transmission = CommonBase::getname($row['fk_transmission'], "transmission");
            $Price = ($row['highestoffer'] == 1) ? "Highest offer" : Vehicle::getname($row['fk_price_type'], "price_type") . " " . CommonBase::formatMoney($row['price'], 0) . "";


            $tbl.= '<td width="400"><table width="400" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#666; line-height:17px;  border:solid 1px #D6D6D6">
                                                                <tr>
                                                                    <td width="225" rowspan="9" style="background:#E8E8E8" valign="middle" align="center">' . $img . '</td>
                                                                    <td width="79" style="background:#FFF; font-weight:bold;padding-left:5px;">Make</td>
                                                                    <td width="10">&nbsp;</td>
                                                                    <td width="86" style="background:#FFF">' . $make . '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-weight:bold; padding-left:5px;">Model</td>
                                                                    <td>&nbsp;</td>
                                                                    <td>' . $model . '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="background:#FFF; font-weight:bold;padding-left:5px;">Chassis No</td>
                                                                    <td>&nbsp;</td>
                                                                    <td style="background:#FFF">' . $row['modeltxt'] . '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-weight:bold; padding-left:5px;">Fuel Type</td>
                                                                    <td>&nbsp;</td>
                                                                    <td>' . $Fuel . '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="background:#FFF; font-weight:bold;padding-left:5px;">Engine </td>
                                                                    <td>&nbsp;</td>
                                                                    <td style="background:#FFF">' . $eacp . '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-weight:bold; padding-left:5px;">Mileage</td>
                                                                    <td>&nbsp;</td>
                                                                    <td>' . $Mileage . '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="background:#FFF; font-weight:bold;padding-left:5px;">Transmission</td>
                                                                    <td>&nbsp;</td>
                                                                    <td style="background:#FFF">' . $Transmission . '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="background:#FFF; font-weight:bold;padding-left:5px;">Price</td>
                                                                    <td>&nbsp;</td>
                                                                    <td style="color:#F00; font-weight:bold;">' . $Price . '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="background:#FFF; font-weight:bold;padding-left:5px;">Status</td>
                                                                    <td>&nbsp;</td>
                                                                    <td style="color:#0C3; font-weight:bold; background:#FFF">Available</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" style="background:#FFF; padding-left:7px;"><a href="' . $url . '" style="text-decoration:none; color:#09F; font-weight:bold; font-size:12px;">Click Here to View More Details &gt;&gt;&gt;</a></td>
                                                                </tr>
                                                            </table></td>';

            $count++;
            if ($count == 2) {
                $count = 0;
                $tbl.='</tr><tr>';
            }
        }

        $tbl.='';

        return $tbl;
    }

    //old

    public static function getallvtypes($type = 1) {
        $q = "";
        if ($type == 1) {
            $q = "SELECT * FROM vtype where status = 1 ORDER BY `Id`";
        }
        if ($type == 2) {
            $q = "SELECT * FROM types where status = 1 ORDER BY `Id`";
        }
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare($q);
        $stmt->execute();
        return $stmt;
    }

    public static function getallvprices($type = 1) {
        $q = "";
        if ($type == 1) {
            $q = "SELECT * FROM prices where status = 1 ORDER BY `Id`";
        }
        if ($type == 2) {
            $q = "SELECT * FROM prices where status = 1 ORDER BY lastlapcif asc";
        }
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare($q);
        $stmt->execute();
        return $stmt;
    }

    public static function getYenRate() {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT yenrate FROM yenrate where `Id` = 1");
        $stmt->execute();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['yenrate'];
        } else {
            return 0;
        }
    }

    public static function getVtypeByID($Id, $type = 1) {
        $q = "";
        if ($type == 1) {
            $q = "SELECT imagepath,`name`  FROM vtype where `Id` = ?";
        }
        if ($type == 2) {
            $q = "SELECT imagepath,`name`  FROM types where `Id` = ?";
        }
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare($q);
        $stmt->execute(array($Id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        } else {
            return NULL;
        }
    }

    public static function getImageName($type = 1, $Id = null) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $quary = "";
        if ($type == 1) {
            $quary = "SELECT imagename FROM vtype where `Id` = ?";
        }
        if ($type == 2) {
            $quary = "SELECT  imagename FROM prices where `Id` = ?";
        }
        if ($type == 3) {
            $quary = "SELECT  imagename FROM types where `Id` = ?";
        }
        $stmt = $dbh->prepare($quary);
        $stmt->execute(array($Id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['imagename'];
        } else {
            return 0;
        }
    }

    public static function getVtypeList($id, $name, $type = 1) {
        $q = "";
        if ($type == 1) {
            $q = "SELECT * FROM vtype WHERE status = 1";
        }
        if ($type == 2) {
            $q = "SELECT * FROM types WHERE status = 1";
        }

        $query = $q;
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt2 = $dbh->prepare($query);
        $stmt2->execute();
        $zero = CommonBase::encrypt("0");
        $stmt = "<select name=\"$name\" id=\"$name\">";

        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $memnum = CommonBase::encrypt($row['Id']);
            $name = $row['name'];
            if ($id != null && $id == $row['Id']) {
                $stmt .="<option selected=\"selected\" value='$memnum'>$name</option>";
            } else {
                $stmt .="<option value='$memnum'>$name</option>";
            }
        }
        if ($id == null || $id == "" || $id == 0) {
            $stmt .="<option selected=\"selected\"  value='$zero'>select</option>";
        }
        $stmt .= "</select>";
        return $stmt;
    }

    public static function cimg($url, $w = '80', $h = '60', $alt = "", $style = "") {
        return "<img src=\"$url\" width=\"$w\" height=\"$h\" alt=\"$alt\" style=\"$style\" /> ";
    }

}

?>
