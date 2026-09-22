<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControlPadDB
 *
 * @author hp-dv6-1315tx
 */
class ControlPadDB
{

    public $dbh = NULL;
    private $magic_quotes_active;
    private $real_escape_string_exists;

    public function __construct()
    {
        if ($this->dbh == NULL) {
            $this->createconnction();
            $this->magic_quotes_active = false;
            $this->real_escape_string_exists = function_exists("mysql_real_escape_string");
        }
    }

    public function createconnction()
    {
        // global variables used to connect to MySQL server
        $mysqlHost = 'localhost';
        $mysqlPort = '3306';
        //$dbUser = "root";
        //$dbPwd = "nuwan123";
        $dbName = 'sonnaclankaenterprises';
        $dbName_beta = $dbName;

        $dbUser = "wthrsser_kaduweu";
        // $dbPwd = "8l2irBt%cug8";
        //  $dbName = 'slcarsal_w3s_kaduwela';
        $dbUser = "root";
        $dbPwd = "";
        //$dbName = 'slvehic1_slautoauction';
        // yinst set BrandedSolutionsPipeline.MYSQL_HOST=localhost
        // yinst set BrandedSolutionsPipeline.MYSQL_PORT=4306
        // check if in Beta dir
        if (isset($_SERVER)) {
            if ((isset($_SERVER['HTTP_HOST'])) && (isset($_SERVER['REQUEST_URI']))) {
                $basePath = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $startIndex = stripos($basePath, 'beta');

                if (FALSE !== $startIndex) {
                    $dbName = $dbName_beta;
                }
            }
        }
        $dbUrl = "mysql:dbname=$dbName;host=$mysqlHost;port=$mysqlPort";

        if (!defined('DB_URL')) {
            define("DB_URL", $dbUrl);
        }
        if (!defined('DB_USER')) {
            define("DB_USER", $dbUser);
        }
        if (!defined('DB_PASSWD')) {

            define("DB_PASSWD", $dbPwd);
        }



        $this->dbh = new PDO(DB_URL, DB_USER, DB_PASSWD, array(PDO::ATTR_PERSISTENT => true));
    }

    //public function createconnction($host= "mysql305.ixwebhosting.com", $username ="chirast_nuwan888", $password="Nuw.911", $database="chirast_sshauto") {
    //  public function createconnction($host= "localhost", $username ="root", $password="nuwan123", $database="chirast_sshauto") {
    //        $this->dbh = new mysqli($host, $username, $password, $database);
    //
    //        if ($this->link->connect_error != null) {
    //            die("Connect Error: " . $this->link->connect_error);
    //        }
    //    }
    //    public function sqlAffectedRows() {
    //        return @mysqli_affected_rows($dbh);
    //    }
    //
    //    public function lastInsertId() {
    //        return $this->dbh->insert_id;
    //    }
    //
    //    public function destroyConnection() {
    //        $this->dbh->kill($this->dbh->thread_id);
    //        $this->dbh->close();
    //    }

    /**
     * This method builds INSERT/UPDATE queries to allow easy query generation/maintenance for long queries.
     * @access public
     * @author Matt Ford
     * @param array $params key/value pair array of parameters for query
     * @return string resulting Query string for MySQLi
     */
    //    public function escapeString($string) {
    //        return $this->link->real_escape_string($string);
    //    }

    public function escapeString($value)
    {
        $value = strip_tags($value);
        if ($this->real_escape_string_exists) {
            if ($this->magic_quotes_active) {
                $value = stripslashes($value);
            }
            // $value = real_s($this->dbh, $value);
        } else {
            if (!$this->magic_quotes_active) {
                $value = addslashes($value);
            }
        }
        return $value;
    }

    // public function escapeString($dirty){
    //  $dirty = strip_tags($dirty);
    //	if (get_magic_quotes_gpc()) {
    //		$clean = mysql_real_escape_string(stripslashes($dirty));
    //	}else{
    //		$clean = mysql_real_escape_string($dirty);
    //	}
    //	return $clean;
    //}
    public function buildSQL($params)
    {
        /*
          Usage

          #INSERT Statements

          $params = array (
          "type" 		=> "insert",
          "table" 	=> "eventCal_events",
          "doNotQuote"	=> array(),
          "data"		=> array (
          "eventName" 			=> $data->request["eventName"],
          "eventText" 			=> $data->request["eventText"],
          "eventLocation" 		=> $data->request["eventLocation"],
          "eventStartDate_month" 		=> $start["month"],
          "eventStartDate_day" 		=> $start["day"],
          "eventStartDate_year"		=> $start["year"],
          "eventStartDate_time" 		=> $start["time"],
          "eventStartDate_timestamp" 	=> $timestampStart,
          "eventEndDate_month" 		=> $end["month"],
          "eventEndDate_day" 		=> $end["day"],
          "eventEndDate_year" 		=> $end["year"],
          "eventEndDate_time" 		=> $end["time"],
          "eventEndDate_timestamp" 	=> $timestampEnd,
          "occursMonthly" 		=> $occursMonthly,
          "occursYearly" 			=> $occursYearly,
          "dynamicEvent" 			=> $dynamicEvent,
          "dynNthDay" 			=> $data->request["dynOccurrence_freq"],
          "dynDayName"			=> $data->request["dynOccurrence_day"],
          "dynMonth" 			=> $data->request["dynOccurrence_month"]
          )
          );
          $sql = $database->buildSQL($params);



          #UPDATE Statements

          $params = array (
          "type" 		=> "update",
          "table" 	=> "eventCal_events",
          "doNotQuote"	=> array(),
          "data" 		=> array (
          "eventName" 			=> $data->request["eventName"],
          "eventText" 			=> $data->request["eventText"],
          "eventLocation" 		=> $data->request["eventLocation"],
          "eventStartDate_month" 		=> $start["month"],
          "eventStartDate_day" 		=> $start["day"],
          "eventStartDate_year"		=> $start["year"],
          "eventStartDate_time" 		=> $start["time"],
          "eventStartDate_timestamp" 	=> $timestampStart,
          "eventEndDate_month" 		=> $end["month"],
          "eventEndDate_day" 		=> $end["day"],
          "eventEndDate_year" 		=> $end["year"],
          "eventEndDate_time" 		=> $end["time"],
          "eventEndDate_timestamp" 	=> $timestampEnd,
          "occursMonthly" 		=> $occursMonthly,
          "occursYearly" 			=> $occursYearly,
          "dynamicEvent" 			=> $dynamicEvent,
          "dynNthDay" 			=> $data->request["dynOccurrence_freq"],
          "dynDayName"			=> $data->request["dynOccurrence_day"],
          "dynMonth" 			=> $data->request["dynOccurrence_month"]
          ),
          "where" 	=> array (
          "eventID" 			=> $data->request["eventID"],
          "eventCreator" 			=> $my->userID
          )
          );
          $sql = $database->buildSQL($params);
         */
        $sql = "";
        $fieldQuantifier = "`";
        $valueQuantifier = '"';

        $params["type"] = strtolower($params["type"]);
        $params["doNotQuote"] = (is_array($params["doNotQuote"]) === true) ? $params["doNotQuote"] : array();

        foreach ($params["data"] as $k => $v) {
            $value = stripslashes($v);
            $params["data"][$k] = $this->escapeString($value);
        }

        switch ($params["type"]) {
            case "insert":
                $sql .= "INSERT INTO " . $fieldQuantifier . $params["table"] . $fieldQuantifier . " ";
                $sql .= "(" . $fieldQuantifier . implode($fieldQuantifier . ", " . $fieldQuantifier, array_keys($params["data"])) . $fieldQuantifier . ") ";
                $sql .= "VALUES(";

                $vars = array();
                foreach ($params["data"] as $k => $v) {
                    $v = (in_array($k, $params["doNotQuote"])) ? $v : $valueQuantifier . $v . $valueQuantifier;
                    $vars[] = $v;
                }

                $sql .= implode(", ", $vars);
                $sql .= ");";
                break;

            case "update":
                $sql .= "UPDATE " . $fieldQuantifier . $params["table"] . $fieldQuantifier . " SET ";

                $vars = array();
                foreach ($params["data"] as $k => $v) {
                    $v = (in_array($k, $params["doNotQuote"])) ? $v : $valueQuantifier . $v . $valueQuantifier;
                    $vars[] = $fieldQuantifier . $k . $fieldQuantifier . " = " . $v;
                }

                $sql .= implode(", ", $vars);
                $vars = array();
                if ($params["where"]) {
                    $sql .= " WHERE ";
                    foreach ($params["where"] as $k => $v) {
                        $vars[] = $fieldQuantifier . $k . $fieldQuantifier . " = " . $valueQuantifier . $v . $valueQuantifier;
                    }
                    $sql .= implode(" AND ", $vars);
                } else {
                }
                $sql .= ";";
                break;
        }

        return $sql;
    }
}
