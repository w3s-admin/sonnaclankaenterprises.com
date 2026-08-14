<?php

@session_start();

require_once "ControlPadDB.php";
require_once 'paginator.class.php';

//require_once 'logController.php';
//require_once 'paginator.class.php';
//require_once 'clsMail.php';
//require_once 'clsCustomer.php';
//require_once 'clsNewsletter.php';

class CommonBase {

   
    public static function checked_value($value) {
        if (is_numeric($value)) {
            return 'checked="checked"';
        } else {
            return '';
        }
    }

 
    
    public static function getManuItems($sql = "SELECT * FROM property_type WHERE  `_status` = 1") {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public static function appendGettoURL($name, $result, $ancor = "") {
        $url = self::full_SiteUrl();
        $made = "";
        if (strpos($url, '?') !== false) {
            $made = $url . "&" . $name . "=" . $result . $ancor;
        } else {
            $made = $url . "?" . $name . "=" . $result . $ancor;
        }
        return $made;
    }
    public static function refreshMotherwithouturlFancyTimeOut($time) {
        return '   <script type="text/javascript">
        setTimeout(function(){
            parent.location.reload(true);
        },' . $time . ')
        </script>';
    }

    public static function reloadWithTimeout($time) {
        return '   <script type="text/javascript">
        setTimeout(function(){
           window.location.reload( true );
        },' . $time . ')
        </script>';
    }

    public static function url_with_out_get() {
        $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
        return self::getServer() . $uri_parts[0];
    }

    public static function getCountByFK($clumName, $tableID) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT count(*) as cnt FROM advert WHERE $clumName = ? and `status` = 1");
        $stmt->execute(array($tableID));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['cnt'];
        } else {
            return 0;
        }
    }

    public static function create_property_session($db_id = 1) {
        $_SESSION['app_pro'] = self::getProperty();
    }

    public static function getProperty() {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("select * from app_config ");
        $stmt->execute();
        $pro = array();
        $pro['server'] = self::getServer();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pro[$row['key']] = $row['val'];
        }

        return $pro;
    }

    public static function createnotify($type = 'info', $headding = '', $massage = '', $hide = true,$scroll = null) {
         $rs = (is_numeric($scroll)) ? "<script type=\"text/javascript\" > gototop($scroll)</script>" : "";
        $r = "<script>
              $(function (){
    $.pnotify({
    title: '$headding',
        text: '$massage',
        type: '$type',
        hide: $hide,
    });
      });
</script>";
        return $r.$rs;
    }

    public static function createMassageDiv($type, $headding, $massage, $scroll = null, $id = "") {
        $rs = (is_numeric($scroll)) ? "<script type=\"text/javascript\" > gototop($scroll)</script>" : "";
        if ($type == 'suc') {
            $rs .= ' <div id="' . $id . '"  class="alert alert-success" >
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                      <h4>' . $headding . ' !</h4>
                                   ' . $massage . '
                                </div>';
        }
        if ($type == 'err') {
            $rs .= ' <div id="' . $id . '"  class="alert alert-error" >
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                      <h4>' . $headding . ' !</h4>
                                   ' . $massage . '
                                </div>';
        }
        return $rs;
    }

    public static function getRealIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public static function dateDiffYMD($start_date, $end_date) {
        $date1 = new DateTime($start_date);
        $date2 = new DateTime($end_date);
        $interval = $date1->diff($date2);
        $a['y'] = $interval->y;
        $a['m'] = $interval->m;
        $a['d'] = $interval->d;
        return $a;
    }

    public static function dateDiff($start_date, $end_date) {
        $start_ts = strtotime($start_date);
        $end_ts = strtotime($end_date);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400);
    }

    public static function getById($id, $table, $field = '*') {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT $field from $table where Id = ?");
        $stmt->execute(array($id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($field = '*') {
                return $row;
            } else {
                return $row[$field];
            }
        }
    }

    public static function removeScriptTags($value) {
        return htmlspecialchars(preg_replace("@<script[^>]*>.+</script[^>]*>@i", "", trim($value)));
    }

    public static function IsAdminUser() {

        $path_parts = pathinfo($_SERVER['PHP_SELF']);
        $baseName = $path_parts["basename"];
        $session_head = isset($_SESSION['app_pro']['session_head']) ? $_SESSION['app_pro']['session_head'] : "";
        if ($baseName != "index.php") {
            $sessiochk = (isset($_SESSION[$session_head . 'Adminusername']) && $_SESSION[$session_head . 'Adminusername'] != NULL) || (isset($_SESSION[$session_head . 'AdminuserId']) && $_SESSION[$session_head . 'AdminuserId'] != NULL);
            if (!$sessiochk) {
                CommonBase::SendRedirect("index.php");
            }
            $a['name'] = $_SESSION[$session_head . 'Adminusername'];
            $a['Id'] = $_SESSION[$session_head . 'AdminuserId'];
            $a['lastlogin'] = $_SESSION[$session_head . 'Adminlastlogin'];
            $a['TYPE'] = "ADMIN";
            return $a;
        }
    }

    public static function IsSaleOwner() {
        $path_parts = pathinfo($_SERVER['PHP_SELF']);
        $baseName = $path_parts["basename"];
        if ($baseName != "ownerlogin.php") {
            $sessiochk = (isset($_SESSION['slacarsale_Ownwerusername']) && $_SESSION['slacarsale_Ownwerusername'] != NULL) || (isset($_SESSION['slacarsale_OwnweruserId']) && $_SESSION['slacarsale_OwnweruserId'] != NULL);
            if (!$sessiochk) {
                CommonBase::SendRedirect("ownerlogin.php");
            }
            $a['name'] = $_SESSION['slacarsale_Ownwerusername'];
            $a['id'] = $_SESSION['slacarsale_OwnweruserId'];
            $a['lastlogin'] = $_SESSION['slacarsale_Ownwerlastlogin'];
            $a['TYPE'] = $_SESSION['slacarsale_OwnwerType'];
            $a['USER_ID'] = $_SESSION['slacarsale_userId'];
            $a['PAYMENT'] = $_SESSION['slacarsale_paymetDetails'];
            $a['AVAILABLE_DATES'] = $_SESSION['slacarsale_OwnerAvilableDates'];
            return $a;
        }
    }

    public static function SendRedirect($page) {
        header("Location:" . $page);
    }

    public static function full_SiteUrl() {
        $s = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? "s" : "";
        $protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;
        $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" . $_SERVER["SERVER_PORT"]);
        return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
    }

    public static function getServer() {
        $s = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? "s" : "";
        $protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;
        $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" . $_SERVER["SERVER_PORT"]);
        $host = $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . "/";
        return ($host == "http://localhost/") ? "http://localhost/sonnaclankaenterprises.com/" : $host;
    }

    public static function createSelect($id, $name, $type = 1, $class = "", $title = "", $q = "", $word = "Please Select", $style = "", $plasehold = false) {

        if ($type == 1) {
            $q = "SELECT Id,dist_name as name FROM location order by dist_name asc";
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

        if (!is_numeric($id)) {
            $id = CommonBase::decrypt($id);
        }



        $stmt = "<select name=\"$name\" id=\"$name\" title=\"$title\" class=\"$class\" style=\"$style\" placeholder=\"$word\"  >  ";
        if ($plasehold)
            $stmt .="<option value=''></option>";
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $memnum = CommonBase::encrypt($row['Id']);
            $name = $row['name'];
            if ($id != null && $id == $row['Id']) {
                $stmt .="<option selected=\"selected\" value='$memnum'>$name</option>";
            } else {
                $stmt .="<option value='$memnum'>$name</option>";
            }
        }
        if (!$plasehold) {
            if ($id == null || $id == "" || $id == 0) {
                $stmt .="<option selected=\"selected\"  value='$zero'>$word</option>";
            } else {
                $stmt .="<option  value='$zero'>$word</option>";
            }
        }
        $stmt .= "</select>";
        return $stmt;
    }

    public static function createSelectAjxSearch($value, $fkValue, $sql, $columName = "", $string = "Any") {

        $r = "";

        if ($value == "") {
            $r .= '<option value="" class="any">' . $string . '</option>';
        } elseif (is_numeric(CommonBase::decrypt($value)) && is_numeric(CommonBase::decrypt($fkValue))) {

            $cdb = new ControlPadDB();
            $dbh = $cdb->dbh;
            $stmt2 = $dbh->prepare($sql);

            $stmt2->execute(array(CommonBase::decrypt($fkValue)));
            $id = CommonBase::decrypt($value);

            while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                if ($columName != NULL) {
                    $count = self::getCountByFK($columName, $row['Id']);
                    $vcount = ($count != 0) ? "  <b>(</b> $count <b>)</b>" : "";
                }
                $memnum = CommonBase::encrypt($row['Id']);
                $name = $row['name'];
                if ($id != null && $id == $row['Id']) {
                    $r .="<option selected=\"selected\" value='$memnum'>$name $vcount</option>";
                } else {
                    $r .="<option value='$memnum'>$name $vcount</option>";
                }
            }
        }
        return $r;
    }

    public static function createSelectSearch($id, $name, $type = 1, $class = "", $title = "", $q = "", $columName = "", $string = "Any", $style = "", $plasehold = false) {
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
                $count = self::getCountByFK($columName, $row['Id']);
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
            $stmt .="<option selected=\"selected\"  value=''>$string</option>";
        } else {
            $stmt .="<option  value=''  >$string</option>";
        }
        $stmt .= "</select>";
        return $stmt;
    }

    public Static function getLocationById($id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT dist_name from location where Id = ? ");
        $stmt->execute(array($id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['dist_name'];
        }
    }

    public Static function getCityById($id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT   city.Id as cid ,province.`name` as pname,city.name as cname,city.`othername`as cother   from city ,province WHERE city.Id = ?  and city.fk_province = province.Id LIMIT 1");
        $stmt->execute(array($id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pro = $row['pname'];
            $cityother = ( $row['cother'] == "") ? "" : " (" . $row['cother'] . ")";
            $city = $row['cname'] . $cityother;
            return $city . " , $pro Province";
        }
    }

    public static function getcurrenttime($time_zone = false) {
        if (!$time_zone) {
            date_default_timezone_set('Asia/Calcutta');
        } else {
            date_default_timezone_set($time_zone);
        }
        return date('Y-m-d H:i:s');
    }

    public static function getToday() {
        return date('Y-m-d');
    }

    public static function encrypt($sData, $sKey = 'encodecarsale') {
        $sResult = '';
        for ($i = 0; $i < strlen($sData); $i++) {
            $sChar = substr($sData, $i, 1);
            $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
            $sChar = chr(ord($sChar) + ord($sKeyChar));
            $sResult .= $sChar;
        }
        return self::encode_base64($sResult);
//  encode_base64();
    }

    public static function decrypt($sData, $sKey = 'encodecarsale') {
        $sResult = '';
        $sData = self::decode_base64($sData);
        for ($i = 0; $i < strlen($sData); $i++) {
            $sChar = substr($sData, $i, 1);
            $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
            $sChar = chr(ord($sChar) - ord($sKeyChar));
            $sResult .= $sChar;
        }
        return $sResult;
    }

    public static function encode_base64($sData) {
        $sBase64 = base64_encode($sData);
        return strtr($sBase64, '+/', '-_');
    }

    public static function decode_base64($sData) {
        $sBase64 = strtr($sData, '-_', '+/');
        return base64_decode($sBase64);
    }

    public static function isEmail($email) {
        if (preg_match("/^(\w+((-\w+)|(\w.\w+))*)\@(\w+((\.|-)\w+)*\.\w+$)/", $email)) {
            return true;
        } else {
            return false;
        }
    }

    public static function jsAlert($massage) {
        echo "<script type=\"text/javascript\" >alert('$massage')</script>";
    }

    public static function closeWindow() {
        echo "<script type=\"text/javascript\" >self.close()</script>";
    }

    public static function gotoMotherURL($url) {
        echo "<script type=\"text/javascript\" >opener.location=('$url')</script>";
    }

    public static function refreshMotherwithouturl() {
        echo "<script type=\"text/javascript\" >window.opener.location.reload(true)</script>";
    }

    public static function refresh() {
        echo "<script type=\"text/javascript\" > window.location.reload( true )</script>";
    }

    public static function gotopage($url) {
        echo "<script type=\"text/javascript\" > location.href='$url'</script>";
    }

    public static function gotopageSearch($page, $search, $searchtext) {
        $url = $page . "?search=" . CommonBase::encrypt($search) . '&searchtext=' . CommonBase::encrypt(str_replace("%", "*", $searchtext));
        echo "<script type=\"text/javascript\" > location.href='$url'</script>";
    }

    public static function formatMoney($number, $cents = 2, $currancy = 'LKR', $setcurrancy = false) { // cents: 0=never, 1=if needed, 2=always
        if (is_numeric($number)) { // a number
            if (!$number) { // zero
                $money = ($cents == 2 ? '0.00' : '0'); // output zero
            } else { // value
                if (floor($number) == $number) { // whole number
                    $money = number_format($number, ($cents == 2 ? 2 : 0)); // format
                } else { // cents
                    $money = number_format(round($number, 2), ($cents == 0 ? 0 : 2)); // format
                } // integer or decimal
            } // value
            if ($setcurrancy) {
                return "$currancy " . $money;
            } else {
                return $money;
            }
        } // numeric
    }

    public static function setValueBool($value) {
        if (is_bool($value) && $value) {
            return 1;
        } elseif (is_bool($value) && !$value) {
            return 0;
        } else {
            return $value;
        }
    }

    public static function chktoDB($val) {
        if ($val == "1") {
            return 1;
        } else {
            return 0;
        }
    }

    public static function yn($value,$a="", $imgpath = "images",$style="width: 11px; height: 11px;") {
        $imgok = "<img src=\"$imgpath/tick.png\" width=\"20\" height=\"20\" alt=\"tick\" style=\"$style\"/>";
        $imgreject = "<img src=\"$imgpath/cancel.png\" width=\"20\" height=\"20\" alt=\"tick\"style=\"$style\" />";
        if ($value == 0) {
            return $imgreject;
        } elseif ($value == 1) {
            return $imgok;
        }
    }
    
    public static function yn_bootsrap($value, $imgpath = "../images") {
        $imgok = '<i class="icon-ok"></i>';
        $imgreject = '<i class=" icon-remove"></i>';
        if ($value == 0) {
            return $imgreject;
        } elseif ($value == 1) {
            return $imgok;
        }
    }
    public static function createImage($url, $w, $h, $calss = "", $alt = "") {
        return "<img height=\"$h\" width=\"$w\" alt=\"$alt\" src=\"$url\" class=\"$calss\">";
    }

    public static function checked($value) {
        if ($value == 1) {
            return 'checked="checked"';
        } else {
            return '';
        }
    }

    public static function getname($id, $tblname, $field = "name") {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT $field as name from $tblname WHERE Id = ?");

        $name = null;
        $stmt->execute(array($id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $name = $row['name'];
        }

        return $name;
    }

    public static function is_date($date) {
        if (strlen($date) == 10) {
            $pattern = '/\.|\/|-/i';    // . or / or -
            preg_match($pattern, $date, $char);

            $array = preg_split($pattern, $date, -1, PREG_SPLIT_NO_EMPTY);

            if (strlen($array[2]) == 4) {
// dd.mm.yyyy || dd-mm-yyyy
                if ($char[0] == "." || $char[0] == "-") {
                    $month = $array[1];
                    $day = $array[0];
                    $year = $array[2];
                }
// mm/dd/yyyy    # Common U.S. writing
                if ($char[0] == "/") {
                    $month = $array[0];
                    $day = $array[1];
                    $year = $array[2];
                }
            }
// yyyy-mm-dd    # iso 8601
            if (strlen($array[0]) == 4 && $char[0] == "-") {
                $month = $array[1];
                $day = $array[2];
                $year = $array[0];
            }
            if (checkdate($month, $day, $year)) {    //Validate Gregorian date
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;    // more or less 10 chars
        }
    }

    public static function GetDaysBitweenTwoDays($sStartDate, $sEndDate) {
// Firstly, format the provided dates.
// This function works best with YYYY-MM-DD
// but other date formats will work thanks
// to strtotime().
        $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));
        $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));

// Start the variable off with the start date
        $aDays[] = $sStartDate;

// Set a 'temp' variable, sCurrentDate, with
// the start date - before beginning the loop
        $sCurrentDate = $sStartDate;

// While the current date is less than the end date
        while ($sCurrentDate < $sEndDate) {
// Add a day to the current date
            $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));

// Add this new day to the aDays array
            $aDays[] = $sCurrentDate;
        }

// Once the loop has finished, return the
// array of days.
        return $aDays;
    }

}

?>