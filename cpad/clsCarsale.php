<?php

class Carsale {

    public static function getPaymentInfoCarsale($id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * from carsales_payments WHERE fk_carsales = ? and `_status` != 0");
        $stmt->execute(array($id));
        return $stmt;
    }

    public static function getPaymentCount($id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT COUNT(*) from carsales_payments WHERE fk_carsales = ? and `_status` != 0");
        $stmt->execute(array($id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['COUNT(*)'];
        } else {
            return 0;
        }
    }

    public static function send_Email_InvoiceForPaymetConfamationChange_admin($Id, $oldinfoArray, $username) {
        $paymet_info = CommonBase::getById($Id, "carsales_payments");
        $paymet_info_old = $oldinfoArray;
        $carsale = CommonBase::getById($paymet_info['fk_carsales'], "carsales");
        // var_dump($paymet_info_old);
        // var_dump($paymet_info);
        if (is_array($paymet_info)) {
            $oEmail = new MailManager();
            $emailDetails = MailManager::getEmailDetails();
            $txtSMTPUserName = $emailDetails['txtSMTPUserName'];
            $txtSMTPServer = $emailDetails['txtSMTPServer'];
            $txtSMTPPassword = $emailDetails['txtSMTPPassword'];
            $txtFROMEmail = $emailDetails['txtSMTPUserName'];


            $txtemail = "email@w3ssolutions.com";

            // $email = $carsale['contactpersonemail'];
            $txtCCList = $oEmail->getAllEmails("email", "system_admin", $sql = null);
            // $txtBCCList = (CommonBase::isEmail($email)) ? $email : "";

            $txtFROMEmailName = "SL CarSales";

            $txtSUBJECT = "Car Sale Payment Changed By Admin";

            $file = fopen("../cpad/emails/carsale_to_paymet_info_changeed_invoice_admin.html", "r");
            $mailbody = fread($file, filesize("../cpad/emails/carsale_to_paymet_info_changeed_invoice_admin.html"));
            fclose($file);

            $p_price = $paymet_info_old['total_price'];
            $n_price = $paymet_info['total_price'];
            $b_price = $n_price - $p_price;

            $mailbody = preg_replace("/_adminname_/", $username, $mailbody);
            $mailbody = preg_replace("/_cname_/", $carsale['name'], $mailbody);
            $mailbody = preg_replace("/_pp_/", $p_price, $mailbody);
            $mailbody = preg_replace("/_np_/", $n_price, $mailbody);

            $mailbody = ($paymet_info_old['activate'] == 1) ? preg_replace("/Balance_to_Be_Paid_/", "Balance to Be Paid : $b_price", $mailbody) : preg_replace("/Balance_to_Be_Paid_/", "<b>Payment not received yet</b>", $mailbody);

            $mailbody = preg_replace("/def__/", CommonBase::formatMoney($paymet_info['default_price'], 2), $mailbody);
            $mailbody = preg_replace("/site_/", CommonBase::formatMoney($paymet_info['site_price'], 2), $mailbody);
            $mailbody = preg_replace("/Stock__/", CommonBase::formatMoney($paymet_info['stock_price'], 2), $mailbody);
            $mailbody = preg_replace("/Adminu__/", CommonBase::formatMoney($paymet_info['adminuser_price'], 2), $mailbody);
            $mailbody = preg_replace("/Member__/", CommonBase::formatMoney($paymet_info['reg_user_price'], 2), $mailbody);
            $mailbody = preg_replace("/Stock_loc__/", CommonBase::formatMoney($paymet_info['stock_location_price'], 2), $mailbody);
            $mailbody = preg_replace("/News__/", CommonBase::formatMoney($paymet_info['news_price'], 2), $mailbody);
            $mailbody = preg_replace("/Newsletter__/", CommonBase::formatMoney($paymet_info['newsletter_price'], 2), $mailbody);
            $mailbody = preg_replace("/Invoice__/", CommonBase::formatMoney($paymet_info['invoice_price'], 2), $mailbody);
            $mailbody = preg_replace("/Inquiry__/", CommonBase::formatMoney($paymet_info['inquiry_price'], 2), $mailbody);
            $mailbody = preg_replace("/Payment__/", CommonBase::formatMoney($paymet_info['payment_price'], 2), $mailbody);
            $mailbody = preg_replace("/Exporter__/", CommonBase::formatMoney($paymet_info['exporter_payment_price'], 2), $mailbody);
            $mailbody = preg_replace("/Employee__/", CommonBase::formatMoney($paymet_info['employee_price'], 2), $mailbody);
            $mailbody = preg_replace("/Unique__/", CommonBase::formatMoney($paymet_info['without_adv_price'], 2), $mailbody);
            $mailbody = preg_replace("/perm__/", CommonBase::formatMoney($paymet_info['monthy_price'], 2), $mailbody);
            $mailbody = preg_replace("/nm_/", $paymet_info['number_of_months'], $mailbody);
            $mailbody = preg_replace("/nd_/", $paymet_info['number_of_days'], $mailbody);
            $mailbody = preg_replace("/std_/", $paymet_info['start_date'], $mailbody);
            $mailbody = preg_replace("/enddate__/", $paymet_info['end_date'], $mailbody);
            $mailbody = preg_replace("/Tp_/", CommonBase::formatMoney($paymet_info['total_price'], 2), $mailbody);


            $mailbody = preg_replace("/_def/", CommonBase::formatMoney($paymet_info_old['default_price'], 2), $mailbody);
            $mailbody = preg_replace("/_site/", CommonBase::formatMoney($paymet_info_old['site_price'], 2), $mailbody);
            $mailbody = preg_replace("/__Stock/", CommonBase::formatMoney($paymet_info_old['stock_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Adminu/", CommonBase::formatMoney($paymet_info_old['adminuser_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Member/", CommonBase::formatMoney($paymet_info_old['reg_user_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Stock_loc/", CommonBase::formatMoney($paymet_info_old['stock_location_price'], 2), $mailbody);
            $mailbody = preg_replace("/__News/", CommonBase::formatMoney($paymet_info_old['news_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Newsletter/", CommonBase::formatMoney($paymet_info_old['newsletter_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Invoice/", CommonBase::formatMoney($paymet_info_old['invoice_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Inquiry/", CommonBase::formatMoney($paymet_info_old['inquiry_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Payment/", CommonBase::formatMoney($paymet_info_old['payment_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Exporter/", CommonBase::formatMoney($paymet_info_old['exporter_payment_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Employee/", CommonBase::formatMoney($paymet_info_old['employee_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Unique/", CommonBase::formatMoney($paymet_info_old['without_adv_price'], 2), $mailbody);
            $mailbody = preg_replace("/_perm/", CommonBase::formatMoney($paymet_info_old['monthy_price'], 2), $mailbody);
            $mailbody = preg_replace("/_nm/", $paymet_info_old['number_of_months'], $mailbody);
            $mailbody = preg_replace("/_nd/", $paymet_info_old['number_of_days'], $mailbody);
            $mailbody = preg_replace("/_std/", $paymet_info_old['start_date'], $mailbody);
            $mailbody = preg_replace("/_enddate/", $paymet_info_old['end_date'], $mailbody);
            $mailbody = preg_replace("/_Tp/", CommonBase::formatMoney($paymet_info_old['total_price'], 2), $mailbody);

            $Image['name'] = '../images/mailImg/logoM.jpg';
            $Image['Id'] = 'logoimg';
            $Imagenames[0] = $Image;

            $requestEmailed = $oEmail->sendEmail($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailbody, $txtemail, $txtFirstName, $Imagenames);
            return $requestEmailed;
        }
    }

    public static function send_Email_InvoiceForPaymetConfamationChange($Id, $oldinfoArray) {
        $paymet_info = CommonBase::getById($Id, "carsales_payments");
        $paymet_info_old = $oldinfoArray;
        $carsale = CommonBase::getById($paymet_info['fk_carsales'], "carsales");
        // var_dump($paymet_info_old);
        // var_dump($paymet_info);
        if (is_array($paymet_info)) {
            $oEmail = new MailManager();
            $emailDetails = MailManager::getEmailDetails();
            $txtSMTPUserName = $emailDetails['txtSMTPUserName'];
            $txtSMTPServer = $emailDetails['txtSMTPServer'];
            $txtSMTPPassword = $emailDetails['txtSMTPPassword'];
            $txtFROMEmail = $emailDetails['txtSMTPUserName'];


            $txtemail = "email@w3ssolutions.com";

            $email = $carsale['contactpersonemail'];
            //  $txtCCList = $oEmail->getAllEmails("email", "system_admin", $sql = null);
            $txtBCCList = (CommonBase::isEmail($email)) ? $email : "";

            $txtFROMEmailName = "SL CarSales";

            $txtSUBJECT = "Car Sale Payment Changed Invoice";


            $file = fopen("../cpad/emails/carsale_to_paymet_info_changeed_invoice.html", "r");
            $mailbody = fread($file, filesize("../cpad/emails/carsale_to_paymet_info_changeed_invoice.html"));
            fclose($file);



            $p_price = $paymet_info_old['total_price'];
            $n_price = $paymet_info['total_price'];
            $b_price = $n_price - $p_price;

            $mailbody = preg_replace("/_customerName_/", $carsale['contactperson'], $mailbody);
            $mailbody = preg_replace("/_cname_/", $carsale['name'], $mailbody);
            $mailbody = preg_replace("/_pp_/", $p_price, $mailbody);
            $mailbody = preg_replace("/_np_/", $n_price, $mailbody);

            $mailbody = ($paymet_info_old['activate'] == 1) ? preg_replace("/Balance_to_Be_Paid_/", "Balance to Be Paid : $b_price", $mailbody) : preg_replace("/Balance_to_Be_Paid_/", "<b>Payment not received yet</b>", $mailbody);

            $mailbody = preg_replace("/def__/", CommonBase::formatMoney($paymet_info['default_price'], 2), $mailbody);
            $mailbody = preg_replace("/site_/", CommonBase::formatMoney($paymet_info['site_price'], 2), $mailbody);
            $mailbody = preg_replace("/Stock__/", CommonBase::formatMoney($paymet_info['stock_price'], 2), $mailbody);
            $mailbody = preg_replace("/Adminu__/", CommonBase::formatMoney($paymet_info['adminuser_price'], 2), $mailbody);
            $mailbody = preg_replace("/Member__/", CommonBase::formatMoney($paymet_info['reg_user_price'], 2), $mailbody);
            $mailbody = preg_replace("/Stock_loc__/", CommonBase::formatMoney($paymet_info['stock_location_price'], 2), $mailbody);
            $mailbody = preg_replace("/News__/", CommonBase::formatMoney($paymet_info['news_price'], 2), $mailbody);
            $mailbody = preg_replace("/Newsletter__/", CommonBase::formatMoney($paymet_info['newsletter_price'], 2), $mailbody);
            $mailbody = preg_replace("/Invoice__/", CommonBase::formatMoney($paymet_info['invoice_price'], 2), $mailbody);
            $mailbody = preg_replace("/Inquiry__/", CommonBase::formatMoney($paymet_info['inquiry_price'], 2), $mailbody);
            $mailbody = preg_replace("/Payment__/", CommonBase::formatMoney($paymet_info['payment_price'], 2), $mailbody);
            $mailbody = preg_replace("/Exporter__/", CommonBase::formatMoney($paymet_info['exporter_payment_price'], 2), $mailbody);
            $mailbody = preg_replace("/Employee__/", CommonBase::formatMoney($paymet_info['employee_price'], 2), $mailbody);
            $mailbody = preg_replace("/Unique__/", CommonBase::formatMoney($paymet_info['without_adv_price'], 2), $mailbody);
            $mailbody = preg_replace("/perm__/", CommonBase::formatMoney($paymet_info['monthy_price'], 2), $mailbody);
            $mailbody = preg_replace("/nm_/", $paymet_info['number_of_months'], $mailbody);
            $mailbody = preg_replace("/nd_/", $paymet_info['number_of_days'], $mailbody);
            $mailbody = preg_replace("/std_/", $paymet_info['start_date'], $mailbody);
            $mailbody = preg_replace("/enddate__/", $paymet_info['end_date'], $mailbody);
            $mailbody = preg_replace("/Tp_/", CommonBase::formatMoney($paymet_info['total_price'], 2), $mailbody);


            $mailbody = preg_replace("/_def/", CommonBase::formatMoney($paymet_info_old['default_price'], 2), $mailbody);
            $mailbody = preg_replace("/_site/", CommonBase::formatMoney($paymet_info_old['site_price'], 2), $mailbody);
            $mailbody = preg_replace("/__Stock/", CommonBase::formatMoney($paymet_info_old['stock_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Adminu/", CommonBase::formatMoney($paymet_info_old['adminuser_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Member/", CommonBase::formatMoney($paymet_info_old['reg_user_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Stock_loc/", CommonBase::formatMoney($paymet_info_old['stock_location_price'], 2), $mailbody);
            $mailbody = preg_replace("/__News/", CommonBase::formatMoney($paymet_info_old['news_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Newsletter/", CommonBase::formatMoney($paymet_info_old['newsletter_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Invoice/", CommonBase::formatMoney($paymet_info_old['invoice_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Inquiry/", CommonBase::formatMoney($paymet_info_old['inquiry_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Payment/", CommonBase::formatMoney($paymet_info_old['payment_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Exporter/", CommonBase::formatMoney($paymet_info_old['exporter_payment_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Employee/", CommonBase::formatMoney($paymet_info_old['employee_price'], 2), $mailbody);
            $mailbody = preg_replace("/_Unique/", CommonBase::formatMoney($paymet_info_old['without_adv_price'], 2), $mailbody);
            $mailbody = preg_replace("/_perm/", CommonBase::formatMoney($paymet_info_old['monthy_price'], 2), $mailbody);
            $mailbody = preg_replace("/_nm/", $paymet_info_old['number_of_months'], $mailbody);
            $mailbody = preg_replace("/_nd/", $paymet_info_old['number_of_days'], $mailbody);
            $mailbody = preg_replace("/_std/", $paymet_info_old['start_date'], $mailbody);
            $mailbody = preg_replace("/_enddate/", $paymet_info_old['end_date'], $mailbody);
            $mailbody = preg_replace("/_Tp/", CommonBase::formatMoney($paymet_info_old['total_price'], 2), $mailbody);

            $Image['name'] = '../images/mailImg/logoM.jpg';
            $Image['Id'] = 'logoimg';
            $Imagenames[0] = $Image;
            $requestEmailed = $oEmail->sendEmail($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailbody, $txtemail, $txtFirstName, $Imagenames);
            return $requestEmailed;
        }
    }

    public static function send_Email_InvoiceForPaymetConfamation($Id) {
        $paymet_info = CommonBase::getById($Id, "carsales_payments");
        $carsale = CommonBase::getById($paymet_info['fk_carsales'], "carsales");

        if (is_array($paymet_info)) {
            $emailDetails = MailManager::getEmailDetails();
            $txtSMTPUserName = $emailDetails['txtSMTPUserName'];
            $txtSMTPServer = $emailDetails['txtSMTPServer'];
            $txtSMTPPassword = $emailDetails['txtSMTPPassword'];
            $txtFROMEmail = $emailDetails['txtSMTPUserName'];


            $txtemail = "email@w3ssolutions.com";

            $email = $carsale['contactpersonemail'];

            $txtBCCList = (CommonBase::isEmail($email)) ? $email : "";

            $txtFROMEmailName = "SL CarSales";

            $txtSUBJECT = "Car Sale Payment Invoice";

            $oEmail = new MailManager();
            $file = fopen("../cpad/emails/carsale_to_paymet_info_added_invoice.html", "r");
            $mailbody = fread($file, filesize("../cpad/emails/carsale_to_paymet_info_added_invoice.html"));
            fclose($file);
            CommonBase::formatMoney($number, 2);

            $mailbody = preg_replace("/_customerName_/", $carsale['contactperson'], $mailbody);
            $mailbody = preg_replace("/_cname_/", $carsale['name'], $mailbody);
            $mailbody = preg_replace("/def__/", CommonBase::formatMoney($paymet_info['default_price'], 2), $mailbody);
            $mailbody = preg_replace("/site_/", CommonBase::formatMoney($paymet_info['site_price'], 2), $mailbody);
            $mailbody = preg_replace("/Stock__/", CommonBase::formatMoney($paymet_info['stock_price'], 2), $mailbody);
            $mailbody = preg_replace("/Adminu__/", CommonBase::formatMoney($paymet_info['adminuser_price'], 2), $mailbody);
            $mailbody = preg_replace("/Member__/", CommonBase::formatMoney($paymet_info['reg_user_price'], 2), $mailbody);
            $mailbody = preg_replace("/Stock_loc__/", CommonBase::formatMoney($paymet_info['stock_location_price'], 2), $mailbody);
            $mailbody = preg_replace("/News__/", CommonBase::formatMoney($paymet_info['news_price'], 2), $mailbody);
            $mailbody = preg_replace("/Newsletter__/", CommonBase::formatMoney($paymet_info['newsletter_price'], 2), $mailbody);
            $mailbody = preg_replace("/Invoice__/", CommonBase::formatMoney($paymet_info['invoice_price'], 2), $mailbody);
            $mailbody = preg_replace("/Inquiry__/", CommonBase::formatMoney($paymet_info['inquiry_price'], 2), $mailbody);
            $mailbody = preg_replace("/Payment__/", CommonBase::formatMoney($paymet_info['payment_price'], 2), $mailbody);
            $mailbody = preg_replace("/Exporter__/", CommonBase::formatMoney($paymet_info['exporter_payment_price'], 2), $mailbody);
            $mailbody = preg_replace("/Employee__/", CommonBase::formatMoney($paymet_info['employee_price'], 2), $mailbody);
            $mailbody = preg_replace("/Unique__/", CommonBase::formatMoney($paymet_info['without_adv_price'], 2), $mailbody);
            $mailbody = preg_replace("/perm__/", CommonBase::formatMoney($paymet_info['monthy_price'], 2), $mailbody);
            $mailbody = preg_replace("/nm_/", $paymet_info['number_of_months'], $mailbody);
            $mailbody = preg_replace("/nd_/", $paymet_info['number_of_days'], $mailbody);
            $mailbody = preg_replace("/std_/", $paymet_info['start_date'], $mailbody);
            $mailbody = preg_replace("/enddate__/", $paymet_info['end_date'], $mailbody);
            $mailbody = preg_replace("/Tp_/", CommonBase::formatMoney($paymet_info['total_price'], 2), $mailbody);


            $Image['name'] = '../images/mailImg/logoM.jpg';
            $Image['Id'] = 'logoimg';
            $Imagenames[0] = $Image;
            $requestEmailed = $oEmail->sendEmail($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailbody, $txtemail, $txtFirstName, $Imagenames);
            return $requestEmailed;
        }
    }

    public static function getAvailableStartDate($Id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT end_date from carsales_payments WHERE fk_carsales = ? and free_trial != 1 ORDER BY Id desc LIMIT 1");
        $stmt->execute(array($Id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return date("Y-m-d", strtotime(date("Y-m-d", strtotime($row['end_date'])) . " +1 day"));
        } else {
            return date("Y-m-d");
        }
    }

    public static function isDatePaid($sStartDate, $sEndDate, $saleID) {
        $alldays = CommonBase::GetDaysBitweenTwoDays($sStartDate, $sEndDate);

        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * from carsales_payments WHERE  start_date <= DATE(?) and end_date >=  DATE(?) and _status !=0 and free_trial != 1 and fk_carsales = ?");
        foreach ($alldays as $day) {
            $stmt->execute(array($day, $day, $saleID));
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $days['s'] = $row['start_date'];
                $days['e'] = $row['end_date'];
                return $days;
            } else {
                return FALSE;
            }
        }
        return $stmt;
    }

    public static function removeTrial($Id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("update carsales_payments set `_status` = 0 WHERE fk_carsales = ? and free_trial = 1");
        if ($stmt->execute(array($Id))) {
            return true;
        } else {
            return FALSE;
        }
    }

    public static function IsTrialAvailable($Id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * from carsales_payments WHERE fk_carsales = ? and free_trial = 1 ");
        $stmt->execute(array($Id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public static function getPricesProperties() {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT `name`,price from carsales_component_price");
        $stmt->execute(array($Id));
        $a = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $a[$row['name']] = $row['price'];
        }

        return $a;
    }

    public static function SelectCarsaleSearch($id = 1) {
        $stmt = "";
        if ($id == 1) {
            $stmt .="<option selected=\"selected\" value='1'>Ref #</option>";
        } else {
            $stmt .="<option value='1'>Ref #</option>";
        }
        if ($id == 2) {
            $stmt .="<option selected=\"selected\" value='2'>Company Name</option>";
        } else {
            $stmt .="<option value='2'>Company Name</option>";
        }
        if ($id == 3) {
            $stmt .="<option selected=\"selected\" value='3'>Contact Person Name</option>";
        } else {
            $stmt .="<option value='3'>Contact Person Name</option>";
        }

        return $stmt;
    }

    public static function isActivated($Id) {
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT email_validation from carsales where  `Id` =  ? ");
        $stmt->execute(array($Id));
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if ($row['email_validation'] == 1) {
                return true;
            } elseif ($row['email_validation'] == 0) {
                return false;
            }
        } else {
            return False;
        }
    }

    public static function isSaleActive($sStartDate, $sEndDate, $saleID) {
        $alldays = CommonBase::GetDaysBitweenTwoDays($sStartDate, $sEndDate);
        $cdb = new ControlPadDB();
        $dbh = $cdb->dbh;
        $stmt = $dbh->prepare("SELECT * from carsales_payments WHERE  start_date <= DATE(?) and end_date >=  DATE(?) and _status !=0 and free_trial != 1 and fk_carsales = ? and activate=1");
        foreach ($alldays as $day) {
            $stmt->execute(array($day, $day, $saleID));
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $days['s'] = $row['start_date'];
                $days['e'] = $row['end_date'];
                $days['array'] = $row;
                return $days;
            } else {
                return FALSE;
            }
        }
        return $stmt;
    }

}

?>
