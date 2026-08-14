<?php

require 'clsCommonBase.php';
require 'clsCarsale.php';
require_once 'capcha/securimage.php';
require 'mailController.php';

$myCon = new ControlPadDB;
$securimage = new Securimage();
$dbh = $myCon->dbh;
extract($_POST);


if (isset($_POST['update_paymrnt_notification'])) {
    $payment_id = CommonBase::decrypt($paymentid);
    $old_payinfo = CommonBase::getById($payment_id, 'carsales_payments');
    if ($old_payinfo['monthy_price'] >  $monthly_charge) {
        CommonBase::jsAlert("Only Component Can BE increase (current monthly payment is lower than previous payment) !");
    } elseif (is_numeric($payment_id)) {
        $price = Carsale::getPricesProperties();

        $default_price = $price['DEFAULT'];
        $site_price = ($site == 1) ? $price['SITE'] : 0;
        $stock_price = ($stock == 1) ? $price['STOCK'] : 0;
        $adminuser_price = ($adminuser == 1) ? $price['ADMINUSER'] : 0;
        $reg_user_price = ( $reg_user == 1) ? $price['REG_USER'] : 0;
        $stock_location_price = ($stock_location == 1) ? $price['STOCK_LOCATION'] : 0;
        $news_price = ($news == 1) ? $price['NEWS'] : 0;
        $newsletter_price = ($newsletter == 1) ? $price['NEWSLETTER'] : 0;
        $invoice_price = ($invoice == 1) ? $price['INVOICE'] : 0;
        $inquiry_price = ($inquiry == 1) ? $price['INQUIRY'] : 0;
        $payment_price = ($payment == 1) ? $price['PAYMENT'] : 0;
        $exporter_payment_price = ($exporter == 1) ? $price['EXPORTER_PAYMENTS'] : 0;
        $employee_price = ($employee == 1) ? $price['EMPLOYEE'] : 0;
        $without_adv_price = ($without_adv == 1) ? $price['WITHOUT_ADV'] : 0;

        $user = CommonBase::IsAdminUser();
        $userId = $user['id'];
        $username = $user['name'];
        $now = CommonBase::getcurrenttime();
      
         
        $stmt = $dbh->prepare("update carsales_payments SET 
             previous_monthy_price=?,
             monthy_price =?,
             total_price =?, 
             `default`=?, 
             site=?, 
             stock=?,
             adminuser=?, 
             reg_user=?,
             stock_location=?, 
             news=?, 
             newsletter=?, 
             invoice=?, 
             inquiry=?, 
             payment=?, 
             exporter_payment=?, 
             employee=?, 
             without_adv=?,  
             default_price=?, 
             site_price=?, 
             stock_price=?, 
             adminuser_price=?, 
             reg_user_price=?, 
             stock_location_price=?, 
             news_price=?, 
             newsletter_price=?, 
             invoice_price=?,
             inquiry_price=?, 
             payment_price=?, 
             exporter_payment_price=?, 
             employee_price=?, 
             without_adv_price=?,
             activate=0,infoupdated_user=?,infoupdated_time=?   WHERE `Id`= ? ");
        $done = $stmt->execute(array(
            $old_payinfo['monthy_price'],
            $monthly_charge,
            $totelprice,
            1,
            CommonBase::chktoDB($site),
            CommonBase::chktoDB($stock),
            CommonBase::chktoDB($adminuser),
            CommonBase::chktoDB($reg_user),
            CommonBase::chktoDB($stock_location),
            CommonBase::chktoDB($news),
            CommonBase::chktoDB($newsletter),
            CommonBase::chktoDB($invoice),
            CommonBase::chktoDB($inquiry),
            CommonBase::chktoDB($payment),
            CommonBase::chktoDB($exporter_payment),
            CommonBase::chktoDB($employee),
            CommonBase::chktoDB($without_adv),
            $default_price,
            $site_price,
            $stock_price,
            $adminuser_price,
            $reg_user_price,
            $stock_location_price,
            $news_price,
            $newsletter_price,
            $invoice_price,
            $inquiry_price,
            $payment_price,
            $exporter_payment_price,
            $employee_price,
            $without_adv_price,
            $userId, $now, $payment_id
                ));

        if ($done) {
                Carsale::send_Email_InvoiceForPaymetConfamationChange_admin($payment_id, $old_payinfo, $username);
            if ($sendinvice_customer == 1) {
                Carsale::send_Email_InvoiceForPaymetConfamationChange($payment_id, $old_payinfo);
                CommonBase::jsAlert("Car Sale payment info change Sucsesfully and Invoice send To Customer ! And Admin(s)");
            } else {
                CommonBase::jsAlert("Car Sale payment info change Sucsesfully !");
            }
        }
    }
}


if (isset($_POST['addpayemt_activate'])) {
    $pay_ID = CommonBase::decrypt($_POST['payID']);
    $paymenttype = CommonBase::decrypt($paymenttype);
    $payinfo = CommonBase::getById($pay_ID, "carsales_payments", "total_price");
    $tprice = $payinfo["total_price"];
    if (
            !is_numeric($pay_ID) ||
            $paymenttype == 0 ||
            $pay_remarks == null
    ) {
        CommonBase::jsAlert("Invalid Entry(s)");
    } elseif ($tprice > $payvalue) {
        CommonBase::jsAlert("Invalid Peyment Need to Pay RS : $tprice");
    } else {
        $user = CommonBase::IsAdminUser();
        $userId = $user['id'];
        $usertype = $user['TYPE'];
        $now = CommonBase::getcurrenttime();
        $stmt = $dbh->prepare("update carsales_payments SET fk_payment_method = ? ,payment_value = ?,payment_remark = ?,activate =1 ,activateted_user= ?,activateted_time = ?  WHERE `Id`= ? ");
        $done = $stmt->execute(array($paymenttype, $payvalue, $pay_remarks, $userId, $now, $pay_ID));

        if ($done) {
            CommonBase::jsAlert("Car Sale Payment Confomation complited Sucsesfully !");
            $search = $_GET['search'];
            $searchtext = $_GET['searchtext'];
            CommonBase::gotoMotherURL("admin_search_carsale.php?&search=$search&searchtext=$searchtext");
        }
    }
}

if (isset($_POST['add_paymrnt_notification'])) {
    $carsale_id = CommonBase::decrypt($sale);
    $ed = $end_date;
    $st = $start_date;

    if (is_numeric($carsale_id)) {
        if (
                ($ed == null && !CommonBase::is_date($ed)) ||
                ($st == null && !CommonBase::is_date($st))
        ) {
            CommonBase::jsAlert("Invalid Date(s)");
        } elseif (
                $monthly_charge == null ||
                $numberofmonth == null ||
                $totelprice == null
        ) {
            CommonBase::jsAlert("Invalid Entry(s)");
        } else {
            $price = Carsale::getPricesProperties();

            $default_price = $price['DEFAULT'];
            $site_price = ($site == 1) ? $price['SITE'] : 0;
            $stock_price = ($stock == 1) ? $price['STOCK'] : 0;
            $adminuser_price = ($adminuser == 1) ? $price['ADMINUSER'] : 0;
            $reg_user_price = ( $reg_user == 1) ? $price['REG_USER'] : 0;
            $stock_location_price = ($stock_location == 1) ? $price['STOCK_LOCATION'] : 0;
            $news_price = ($news == 1) ? $price['NEWS'] : 0;
            $newsletter_price = ($newsletter == 1) ? $price['NEWSLETTER'] : 0;
            $invoice_price = ($invoice == 1) ? $price['INVOICE'] : 0;
            $inquiry_price = ($inquiry == 1) ? $price['INQUIRY'] : 0;
            $payment_price = ($payment == 1) ? $price['PAYMENT'] : 0;
            $exporter_payment_price = ($exporter == 1) ? $price['EXPORTER_PAYMENTS'] : 0;
            $employee_price = ($employee == 1) ? $price['EMPLOYEE'] : 0;
            $without_adv_price = ($without_adv == 1) ? $price['WITHOUT_ADV'] : 0;

            $s_date = date("Y-m-d", strtotime($st));
            $e_date = date("Y-m-d", strtotime($ed));
            if ($s_date < $e_date) {
                $d = Carsale::isDatePaid($s_date, $e_date, $carsale_id);
                if ($d) {
                    $ds = $d['s'];
                    $de = $d['e'];
                    echo CommonBase::jsAlert("Cannot Continue, Date(s) Are Included in the Paid Date Range (S:$ds AND $de)");
                } else {
                    $number_of_days = 0;

                    if ($numberofmonth == 0) {
                        $dif = CommonBase::dateDiffYMD($start_date, $end_date);
                        $y = intval($dif['y']);
                        $m = intval($dif['m']);
                        $d = intval($dif['d']);
                        $totelprice = ($monthly_charge * (($y * 12) + $m)) + ($monthly_charge / 30 ) * $d;
                        $numberofmonth = $m;
                        $number_of_days = $d;
                    }

                    $user = CommonBase::IsAdminUser();
                    $userId = $user['id'];
                    $usertype = $user['TYPE'];
                    $now = CommonBase::getcurrenttime();
                    $stmt = $dbh->prepare("INSERT INTO carsales_payments (fk_carsales, start_date, end_date, free_trial,  monthy_price, total_price, `_status`, `default`, site, stock, adminuser, reg_user,stock_location, news, newsletter, invoice, inquiry, payment, exporter_payment, employee, without_adv,  default_price, site_price, stock_price, adminuser_price, reg_user_price, stock_location_price, news_price, newsletter_price, invoice_price,inquiry_price, payment_price, exporter_payment_price, employee_price, without_adv_price,  `number_of_months`,infoadded_user,infoadded_time,number_of_days,send_customer_invoice) 
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,? ,? ,?,?,? )");
                    $done = $stmt->execute(array(
                        $carsale_id,
                        $s_date,
                        $e_date,
                        0,
                        $monthly_charge,
                        $totelprice,
                        1,
                        1,
                        CommonBase::chktoDB($site),
                        CommonBase::chktoDB($stock),
                        CommonBase::chktoDB($adminuser),
                        CommonBase::chktoDB($reg_user),
                        CommonBase::chktoDB($stock_location),
                        CommonBase::chktoDB($news),
                        CommonBase::chktoDB($newsletter),
                        CommonBase::chktoDB($invoice),
                        CommonBase::chktoDB($inquiry),
                        CommonBase::chktoDB($payment),
                        CommonBase::chktoDB($exporter_payment),
                        CommonBase::chktoDB($employee),
                        CommonBase::chktoDB($without_adv),
                        $default_price,
                        $site_price,
                        $stock_price,
                        $adminuser_price,
                        $reg_user_price,
                        $stock_location_price,
                        $news_price,
                        $newsletter_price,
                        $invoice_price,
                        $inquiry_price,
                        $payment_price,
                        $exporter_payment_price,
                        $employee_price,
                        $without_adv_price,
                        $numberofmonth,
                        $userId,
                        $now,
                        $number_of_days,
                        CommonBase::chktoDB($sendinvice_customer)
                            ));
                    $addedIdTemp = $dbh->lastInsertId();
                    if ($done) {
                        Carsale::removeTrial($carsale_id);
                        if ($sendinvice_customer == 1) {
                            Carsale::send_Email_InvoiceForPaymetConfamation($addedIdTemp);
                            CommonBase::jsAlert("Car Sale payment info Added Sucsesfully and Invoice send To Customer !");
                        } else {
                            CommonBase::jsAlert("Car Sale payment info Added Sucsesfully !");
                        }
                        //CommonBase::gotopage(CommonBase::full_SiteUrl());
                    }
                }
            }
        }
    }
}

if (isset($_POST['carsale_addtrial'])) {
    $carsale_id = CommonBase::decrypt($saleId);

    if (is_numeric($carsale_id)) {
        if (
                ($ed == null && !CommonBase::is_date($ed)) ||
                ($std == null && !CommonBase::is_date($std))
        ) {
            CommonBase::jsAlert("Invalid Date(s)");
        } else {
            $s_date = date("Y-m-d", strtotime($std));
            $e_date = date("Y-m-d", strtotime($ed));
            if ($s_date < $e_date) {
                $user = CommonBase::IsAdminUser();
                $userId = $user['id'];
                $usertype = $user['TYPE'];
                $now = CommonBase::getcurrenttime();
                $stmt = $dbh->prepare("INSERT INTO carsales_payments(fk_carsales, start_date,end_date,free_trial,activateted_user,activateted_time,`_status`) VALUES(?,?,?,?,?,?,1) ");
                $done = $stmt->execute(array($carsale_id, $s_date, $e_date, 1, $userId, $now));
                if ($done) {
                    CommonBase::jsAlert("Car Sale Trial Period Activated Sucsesfully !");
                    CommonBase::gotopage(CommonBase::full_SiteUrl());
                }
            }
        }
    }
}


if (isset($_POST['addcarsale'])) {

    if ($Name == NULL) {
        CommonBase::jsAlert("Invalid Name");
    } else if ($c1 == NULL) {
        echo CommonBase::jsAlert("Invalid Contact Number 1");
    } else if ($c2 == NULL) {
        echo CommonBase::jsAlert("Invalid Contact Number 2");
    } else if ($Fax == NULL) {
        echo CommonBase::jsAlert("Invalid FAX");
    } else if ($Address == NULL) {
        echo CommonBase::jsAlert("Invalid Adress");
    } else if ($cp == NULL) {
        echo CommonBase::jsAlert("Invalid Contact Parson");
    } else if ($cpm == NULL) {
        echo CommonBase::jsAlert("Invalid Contact Parson Mobile");
    } else if ($cpe == NULL || !CommonBase::isEmail($cpe)) {
        echo CommonBase::jsAlert("Invalid Contact Parson Emial");
    } else if ($cpp == NULL) {
        echo CommonBase::jsAlert("Invalid Password !");
    } else if ($cityid == NULL || !is_numeric($cityid)) {
        echo CommonBase::jsAlert("Invalid City");
    } else if (!is_numeric(CommonBase::decrypt($location)) || CommonBase::decrypt($location) == 0) {
        echo CommonBase::jsAlert("Invalid Location");
    } else if ($securimage->check($code) == false) {
        CommonBase::jsAlert("Incorrect security code Entered");
    } else if ($domain == NULL) {
        CommonBase::jsAlert("Incorrect Domain Name");
    } else {

        $now = CommonBase::getcurrenttime();
        $stmt = $dbh->prepare("INSERT INTO carsales (
            `name`, 
            contactnumber1, 
            contactnumber2, 
            fax, 
            address, 
            contactperson, 
            contactpersonmobile, 
            contactpersonemail, 
            fk_location, 
            `_status`, 
            password, 
            fk_city,
            site,
            stock, 
            adminuser, 
            reg_user, 
            news, 
            newsletter, 
            invoice, 
            inquiry,
            payment, 
            exporter_payment, 
            employee,
            without_adv, 
            stock_location, 
            subdomain, 
            fulldomain,
            addt) 
            VALUES 
            (?,?,?,?,?,?,?,?,?,1,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $done = $stmt->execute(array(
            $myCon->escapeString($Name),
            $myCon->escapeString($c1),
            $myCon->escapeString($c2),
            $myCon->escapeString($Fax),
            $myCon->escapeString($Address),
            $myCon->escapeString($cp),
            $myCon->escapeString($cpm),
            $myCon->escapeString($cpe),
            CommonBase::decrypt($location),
            $myCon->escapeString($cpp),
            $myCon->escapeString($cityid),
            CommonBase::chktoDB($site),
            CommonBase::chktoDB($stock),
            CommonBase::chktoDB($adminuser),
            CommonBase::chktoDB($reg_user),
            CommonBase::chktoDB($stock_location),
            CommonBase::chktoDB($news),
            CommonBase::chktoDB($newsletter),
            CommonBase::chktoDB($invoice),
            CommonBase::chktoDB($inquiry),
            CommonBase::chktoDB($payment),
            CommonBase::chktoDB($exporter_payment),
            CommonBase::chktoDB($employee),
            CommonBase::chktoDB($without_adv),
            $myCon->escapeString($domain),
            "http://www.$domain.slcarsales.com",
            $now
                ));
        if ($done) {
            $addedIdTemp = CommonBase::encrypt($dbh->lastInsertId());
            if (sendCarsaleEmailValidation($cpe, $addedIdTemp, $cp, $Name))
                $sucmsg = "<h2>Your data has been added to the registration process, Please check your email( <font> $cpe </font> ) to activate your account</h2>";
            // CommonBase::gotopage(CommonBase::full_SiteUrl());
        }
    }
}

if (isset($_POST['carsalesearch'])) {
    $searchBy = "Id";
    if ($searchtext == NULL) {
        $errmsg = "Invalid Keyword";
    } else {
        $searchtext = str_replace("*", "%", $searchtext);
        if ($search == 1) {
            $searchBy = "Id";
        } elseif ($search == 2) {
            $searchBy = "name";
        } elseif ($search == 3) {
            $searchBy = "contactperson";
        }
        $myCon = new ControlPadDB;
        $dbh = $myCon->dbh;
        $stmt_carsale = $dbh->prepare("SELECT * FROM carsales WHERE $searchBy LIKE ? and _status = 1 ORDER BY `Id`");
        $stmt_carsale->execute(array($searchtext));
    }
}

if (isset($_POST['editcarsale'])) {

    if (is_numeric(CommonBase::decrypt($eid))) {
        if ($Name == NULL) {
            CommonBase::jsAlert("Invalid Name");
        } else if ($c1 == NULL) {
            CommonBase::jsAlert("Invalid Contact Number 1");
        } else if ($c2 == NULL) {
            CommonBase::jsAlert("Invalid Contact Number 2");
        } else if ($Fax == NULL) {
            CommonBase::jsAlert("Invalid FAX");
        } else if ($Address == NULL) {
            CommonBase::jsAlert("Invalid Adress");
        } else if ($cp == NULL) {
            CommonBase::jsAlert("Invalid Contact Parson");
        } else if ($cpm == NULL) {
            CommonBase::jsAlert("Invalid Contact Parson Mobile");
        } else if ($cpe == NULL || !CommonBase::isEmail($cpe)) {
            CommonBase::jsAlert("Invalid Contact Parson Emial");
        } else if (!is_numeric(CommonBase::decrypt($location)) || CommonBase::decrypt($location) == 0) {
            CommonBase::jsAlert("Invalid Location");
        } else if ($cityid == NULL || !is_numeric($cityid)) {
            CommonBase::jsAlert("Invalid City");
        } else if ($cpp == NULL) {
            CommonBase::jsAlert("Invalid Password !");
        } else {

            $user = CommonBase::IsAdminUser();
            $userId = $user['id'];
            $usertype = $user['TYPE'];

            $now = CommonBase::getcurrenttime();
            $stmt = $dbh->prepare("Update  carsales set `name` =?, contactnumber1=?, contactnumber2=?, fax=?, address=?, contactperson=?, contactpersonmobile=?, contactpersonemail=?, fk_location=?,password =? , fk_city=?, `_status` = 1, updateu=?, updatet=?,updateu_type=? WHERE `Id`=?");
            $done = $stmt->execute(array($Name, $c1, $c2, $Fax, $Address, $cp, $cpm, $cpe, CommonBase::decrypt($location), $cpp, $cityid, $userId, $now, $usertype, CommonBase::decrypt($eid)));
            if ($done) {
                CommonBase::jsAlert("Car Sale Edited Sucsesfully !");
                CommonBase::gotopage(CommonBase::full_SiteUrl());
            }
        }
    } else {
        CommonBase::jsAlert("invalid Entry");
    }
}


if (isset($_POST['editcarsaleinfo'])) {

    if (!is_numeric(CommonBase::decrypt($eid))) {
        CommonBase::jsAlert("invalid Entry");
    } else {
        $user = CommonBase::IsAdminUser();
        $userId = $user['id'];
        $usertype = $user['TYPE'];
        $now = CommonBase::getcurrenttime();
        $stmt = $dbh->prepare("Update  carsales  set site=?,stock=?,adminuser=?,reg_user=? ,stock_location=?,news=?,newsletter=?,invoice=?,inquiry=?,payment=?,exporter_payment=?,employee=?,without_adv=?, updateu=?, updatet=?,updateu_type='ADMIN' WHERE `Id`=?");
        $done = $stmt->execute(array(
            CommonBase::chktoDB($site),
            CommonBase::chktoDB($stock),
            CommonBase::chktoDB($adminuser),
            CommonBase::chktoDB($reg_user),
            CommonBase::chktoDB($stock_location),
            CommonBase::chktoDB($news),
            CommonBase::chktoDB($newsletter),
            CommonBase::chktoDB($invoice),
            CommonBase::chktoDB($inquiry),
            CommonBase::chktoDB($payment),
            CommonBase::chktoDB($exporter_payment),
            CommonBase::chktoDB($employee),
            CommonBase::chktoDB($without_adv),
            $userId,
            $now,
            CommonBase::decrypt($eid)));
        if ($done) {
            CommonBase::jsAlert("Car Sale info Edited Sucsesfully !");
            CommonBase::gotopage(CommonBase::full_SiteUrl());
        }
    }
}
?>
