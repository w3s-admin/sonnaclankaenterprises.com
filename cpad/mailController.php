<?php

require_once 'clsMail.php';
require_once 'clsCommonBase.php';
if (!class_exists("Vehicle")) {
    require_once 'clsVehicle.php';
}
if (!class_exists("Customer")) {
    //  require_once 'clsCustomer.php';
}

function sendmails_to_friend($arr) {
    $name = $arr['name'];
    $femail = $arr['femail'];
    $msg = $arr['msg'];
    $emailDetails = getEmailDetails();
    $txtSMTPUserName = $emailDetails['txtSMTPUserName'];
    $txtSMTPServer = $emailDetails['txtSMTPServer'];
    $txtSMTPPassword = $emailDetails['txtSMTPPassword'];
    $txtFROMEmail = $emailDetails['txtSMTPUserName'];
    //$txtemail = (isEmail($emails)) ? $emails : "";
    $txtemail = $femail;
    //$txtemail = 'sanjaya.amarasinha@gmail.com';
    // $txtCCList = $adminemailsList;
    $txtBCCList = "email@w3ssolutions.com";
    // var_dump("is ".getAvailableEmails());
    $txtFROMEmailName = "$name";
    $row = Vehicle::getvehicleByID(CommonBase::decrypt($arr['vid']));
    $txtSUBJECT =  Vehicle::createUrl($row, 1);
    

    $oEmail = new MailManager();
    $file = fopen("cpad/emails/email_to_friend.html", "r");
    $mailbody = fread($file, filesize("cpad/emails/email_to_friend.html"));
    fclose($file);
    $options = "";

    $option_arr = array("rearwiper" => "Rear Wiper", "ac" => "AC ", "pm" => "Power Mirror", "tv" => "TV", "ps" => "Power Steering", "abs" => "ABS", "cd" => "CD", "pw" => "Power Window", "dvd" => "DVD", "aw" => "Alloy Wheels", "r_camera" => "R-Camera",
        "winkermirror" => "Winker M", "skey" => "Smart Key", "airbag" => "Air bag", "foglamp" => "Foglamp", "leather" => "Leather Seat");

    foreach ($option_arr as $key => $value) {
        if ($row[$key] == 1) {
            $options .= " /" . $value;
        }
    }

    $c = 1;
    $Images = array();
    $img = 'images/Email_to_fiend_head.jpg';
    $img_a['name'] = $img;
    $img_a['Id'] = "img" . $c;
    array_push($Images, $img_a);
    $c++;
    $other_images = Vehicle::getAllimages($row['Id']);
    $imgc = "";
    foreach ($other_images as $key => $value) {
        $img_a['name'] = $value['mpath'] . $value['image_name'];
        $img_a['Id'] = "img" . $c;
        array_push($Images, $img_a);
        $c++;
        $imgc .= '<img src="' . $img_a['Id'] . '" width="580"  alt="' . $row['modeltxt'] . '" style="width:580px; border:solid 10px #333; margin-top:5px;" /><br/>';
    }
    $msg = ($msg == null) ? "" : "<br/>" . $msg;
    $mailbody = preg_replace("/_name_/", $name, $mailbody);
    $mailbody = preg_replace("/_msg_/", $msg, $mailbody);

    $mailbody = preg_replace("/_head_/", Vehicle::createUrl($row, 1), $mailbody);
    $mailbody = preg_replace("/_price_/", Vehicle::getPrprice($row), $mailbody);
    $mailbody = preg_replace("/_url_/", Vehicle::createUrl($row), $mailbody);
    $mailbody = preg_replace("/_ref_/", Vehicle::addZeroFirft($row['Id']), $mailbody);
    $mailbody = preg_replace("/_make_/", Vehicle::getname($row['fk_make'], "make"), $mailbody);
    $mailbody = preg_replace("/_fuel_/", Vehicle::getname($row['fk_fuel'], "fuel"), $mailbody);
    $mailbody = preg_replace("/_model_/", Vehicle::getname($row['fk_model'], "model") . " - " . $row['modeltxt'], $mailbody);
    $mailbody = preg_replace("/_bodytype_/", Vehicle::getname($row['fk_body_type'], "body_type"), $mailbody);
    $mailbody = preg_replace("/_type_/", CommonBase::getname($row['fk_category'], "category"), $mailbody);
    $mailbody = preg_replace("/_trans_/", Vehicle::getname($row['fk_transmission'], "transmission"), $mailbody);
    $mailbody = preg_replace("/_cc_/", $row['eng_cap'] . "CC", $mailbody);
    $mailbody = preg_replace("/_ym_/", $row['yearmonth'], $mailbody);
    $mailbody = preg_replace("/_color_/", Vehicle::getname($row['fk_color'], "colour"), $mailbody);
    $mailbody = preg_replace("/_km_/", $row['mileage'] . "KM", $mailbody);
    $mailbody = preg_replace("/_options_/", $options, $mailbody);
    $mailbody = preg_replace("/_images_/", $imgc, $mailbody);
    $requestEmailed = $oEmail->sendEmail_newsletter($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailbody, $txtemail, $txtFirstName, $Images);
    //var_dump($requestEmailed);
    // echo "<hr>";
    return $requestEmailed;
}

function sendmails_newsletter($emails, $subject) {

    // $bccList = $customer['email'];
    $emailDetails = getEmailDetails();
    // $adminemailsList = trim($emailDetails['adminEmials']);

    $txtSMTPUserName = $emailDetails['txtSMTPUserName'];
    $txtSMTPServer = $emailDetails['txtSMTPServer'];
    $txtSMTPPassword = $emailDetails['txtSMTPPassword'];
    $txtFROMEmail = $emailDetails['txtSMTPUserName'];

    //$txtemail = (isEmail($emails)) ? $emails : "";
    $txtemail = "email@w3ssolutions.com";
    //$txtemail = 'sanjaya.amarasinha@gmail.com';
    // $txtCCList = $adminemailsList;
    $txtBCCList = $emails;
    // var_dump("is ".getAvailableEmails());
    $txtFROMEmailName = "Kaduwela Enterprises";

    // The bundled PHPMailer (cpad/common/class.phpmailer.php) is a very old
    // fork whose header-encoding routine fails to treat bare CR/LF as unsafe
    // characters, so a Subject containing a literal newline can inject extra
    // SMTP headers (e.g. a forged Bcc:) straight into the outgoing message.
    // $subject here ultimately comes from an admin-submitted form field, so
    // strip CR/LF at the source rather than relying on the library.
    $txtSUBJECT = str_replace(array("\r", "\n"), '', (string) $subject);

    $cdb = new ControlPadDB();
    $dbh = $cdb->dbh;
    $stmt = $dbh->prepare("SELECT * FROM advert where selected = 1 and status != 0 ORDER BY `Id`");
    $stmt->execute();

    $count = 0;
    $c = 0;
    $st = TRUE;
    $tbl = '';
    $Images = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        //$name = 'http://www.sonnaclanka.lk/admin99447/' . $row['image1'];
        $img_f = Vehicle::getFirastimage($row['Id']);

        //$img = 'images/newslatter/dwnimg/' . $imgname;
        $img = '../' . $img_f['tpath'] . $img_f['image_name'];

        $img_a['name'] = $img;
        $img_a['Id'] = "img" . $c;

        array_push($Images, $img_a);
        $server = CommonBase::getServer();
        // $imgc = Emails::cimg("img" . $count, '130', '98', $row['model_no']);
        $imgc = Emails::cimg($img_a['Id'], '210', '135', $row['model_no'], "height: 135px;");

        $ym = explode("-", $row['yearmonth'])[0];
        $url = Vehicle::createUrl($row);

        $Chassis = $row['chasi'];
        $Fuel = CommonBase::getname($row['fk_fuel'], "fuel");
        $eacp = $row['eng_cap'] . " CC";
        $Mileage = $row['mileage'] . " KM";
        $make = CommonBase::getname($row['fk_make'], "make");
        $model = CommonBase::getname($row['fk_model'], "model");
        $Transmission = CommonBase::getname($row['fk_transmission'], "transmission");
        $Price = ($row['highestoffer'] == 1) ? "Highest offer" : Vehicle::getname($row['fk_price_type'], "price_type") . " <b>" . CommonBase::formatMoney($row['price'], 0) . "</b>";

        $tbl.= '<td width="400"><table width="400" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#666; line-height:17px;  border:solid 1px #D6D6D6">
                                                                <tr>
                                                                    <td width="225" rowspan="9" style="background:#E8E8E8" valign="middle" align="center">' . $imgc . '</td>
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
        $c++;
    }
    $tbl.='';

    $oEmail = new MailManager();
    $file = fopen("../cpad/emails/newslatter.php", "r");
    $mailbody = fread($file, filesize("../cpad/emails/newslatter.php"));
    fclose($file);

    $mailbody = preg_replace("/_sub_/", $subject, $mailbody);
    $mailbody = preg_replace("/_con_/", $tbl, $mailbody);
    $mailbody = preg_replace("/_year_/", date("Y", strtotime(CommonBase::getcurrenttime())), $mailbody);

//    echo($mailbody);
//    var_dump($Images);
//    exit();
    $requestEmailed = $oEmail->sendEmail_newsletter($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailbody, $txtemail, $txtFirstName, $Images);
    //var_dump($requestEmailed);
    // echo "<hr>";
    return $requestEmailed;
}

function getEmailDetails($id = 1) {
    $query = "SELECT * FROM email where Id = $id ";
    $con = new ControlPadDB();
    $dbh = $con->dbh;
    $stmt2 = $dbh->prepare($query);
    $stmt2->execute();
    $lastID = 0;
    if ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        return $row;
    }
}

function getImporterEmail($importerID) {
    $query = "SELECT * FROM importers where rid = $importerID ";
    $cdb = new ControlPadDB();
    $dbh = $cdb->dbh;
    $qrh = $dbh->query($query);
    //  var_dump($query);
    if ($row = $qrh->fetch_assoc()) {
        return($row);
    }
}

function getAllAminEmails() {
    $query = "SELECT contactpersonemail from carsales WHERE `status` = 1 order by Id asc Limit 400";
    $cdb = new ControlPadDB();
    $dbh = $cdb->dbh;
    $stmt1 = $dbh->prepare($query);
    $stmt1->execute();
    $emails = "";

    while ($row2 = $stmt1->fetch(PDO::FETCH_ASSOC)) {

        if (isEmail(trim($row2['contactpersonemail']))) {
            $emails .= $row2['contactpersonemail'] . ", ";
        } else {
            $emails .= "";
        }
    }

    return substr(trim($emails), 0, -1);
}

function getServer() {
    $s = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? "s" : "";
    $protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" . $_SERVER["SERVER_PORT"]);
    return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . "/";
}

function isEmail($email) {
    if (preg_match("/^(\w+((-\w+)|(\w.\w+))*)\@(\w+((\.|-)\w+)*\.\w+$)/", $email)) {
        return true;
    } else {
        return false;
    }
}

function sendUserLoginDetails($email, $fname, $password) {

    $encrpt = CommonBase::encrypt("offer0001_" . $id);
    $url = CommonBase::getServer() . "/sonac_user_register.php?activate=$encrpt";


    $emailDetails = getEmailDetails();
    $txtSMTPUserName = $emailDetails['txtSMTPUserName'];
    $txtSMTPServer = $emailDetails['txtSMTPServer'];
    $txtSMTPPassword = $emailDetails['txtSMTPPassword'];
    $txtFROMEmail = $emailDetails['txtSMTPUserName'];

    // $txtemail = "sshauto@w3ssolutions.com";
    $txtemail = "email@w3ssolutions.com";
    // $txtCCList = $adminemailsList;
    $txtBCCList = (isEmail($email)) ? $email : "";
    // var_dump($bccList);
    $txtFROMEmailName = "Sonnac Bidding Centre";

    $txtSUBJECT = "User Account Created -" . $fname;

    $oEmail = new MailManager();
    $file = fopen("../cpad/emails/customer_added_by_admin.html", "r");
    $mailbody = fread($file, filesize("../cpad/emails/customer_added_by_admin.html"));
    fclose($file);
    //$Imagenames[0] = "images/mailImg/thankyou.jpg";
    $mailbody = preg_replace("/_email_/", $email, $mailbody);
    $mailbody = preg_replace("/_customerName_/", $fname, $mailbody);
    $mailbody = preg_replace("/_password_/", $password, $mailbody);

    $requestEmailed = $oEmail->sendEmail($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailbody, $txtemail, $txtFirstName, $Imagenames);

    return $requestEmailed;
    /// var_dump($requestEmailed);
}

function sendUserEmailValidation($email, $id, $fname) {
    //   $impId = 67;
    // $customer = getImporterEmail($impId);
    //$customerName = $customer['compnayname'];
    // $customerId = $mid;
    $encrpt = CommonBase::encrypt("offer0001_" . $id);
    $url = CommonBase::getServer() . "/sonac_user_register.php?activate=$encrpt";

    // $bccList = $customer['email'];
    // $adminemailsList = trim($emailDetails['adminEmials']);
    $emailDetails = getEmailDetails();
    $txtSMTPUserName = $emailDetails['txtSMTPUserName'];
    $txtSMTPServer = $emailDetails['txtSMTPServer'];
    $txtSMTPPassword = $emailDetails['txtSMTPPassword'];
    $txtFROMEmail = $emailDetails['txtSMTPUserName'];

    // $txtemail = "sshauto@w3ssolutions.com";
    $txtemail = "email@w3ssolutions.com";
    // $txtCCList = $adminemailsList;
    $txtBCCList = (isEmail($email)) ? $email : "";
    // var_dump($bccList);
    $txtFROMEmailName = "Sonnac Bidding Centre";

    $txtSUBJECT = "Activation Link";

    $oEmail = new MailManager();
    $file = fopen("cpad/emails/e-mail-thankyou.html", "r");
    $mailbody = fread($file, filesize("cpad/emails/e-mail-thankyou.html"));
    fclose($file);
    //$Imagenames[0] = "images/mailImg/thankyou.jpg";
    $mailbody = preg_replace("/_PAGE_/", $url, $mailbody);
    $mailbody = preg_replace("/_customerName_/", $fname, $mailbody);

    // $mailbody = preg_replace("/Message_/", $sender_comment, $mailbody);
    // var_dump($txtBCCList);
    $requestEmailed = $oEmail->sendEmail($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailbody, $txtemail, $txtFirstName, $Imagenames);

    return $requestEmailed;
    /// var_dump($requestEmailed);
}

function sendEmail_AdminActivateUser($emails, $id, $fname) {

    $encrpt = CommonBase::encrypt("offer0001_" . $id);
    $enc_one = CommonBase::encrypt("1");
    $url = CommonBase::getServer() . "/owner/customer_search.php?&search=ZA==&searchtext=" . CommonBase::encrypt($id);

    $emailDetails = getEmailDetails();
    $txtSMTPUserName = $emailDetails['txtSMTPUserName'];
    $txtSMTPServer = $emailDetails['txtSMTPServer'];
    $txtSMTPPassword = $emailDetails['txtSMTPPassword'];
    $txtFROMEmail = $emailDetails['txtSMTPUserName'];


    $txtemail = "email@w3ssolutions.com";

    $txtBCCList = getAllAminEmails();

    $txtFROMEmailName = "Sonnac Bidding Centre";

    $txtSUBJECT = "Activate User";

    $oEmail = new MailManager();
    $file = fopen("cpad/emails/admin_activateuser.htm", "r");
    $mailbody = fread($file, filesize("cpad/emails/admin_activateuser.htm"));
    fclose($file);

    $mailbody = preg_replace("/url_/", $url, $mailbody);
    $mailbody = preg_replace("/_customerName_/", $fname, $mailbody);
    $mailbody = preg_replace("/_email_/", $emails, $mailbody);


    $requestEmailed = $oEmail->sendEmail($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailbody, $txtemail, $txtFirstName, $Imagenames);

    return $requestEmailed;
}

function sendEmail_fogetPasswordUser($enc, $fname, $email) {

    $url = CommonBase::getServer() . "sonac_user_reset_password.php?enc=$enc";

    $emailDetails = getEmailDetails();
    $txtSMTPUserName = $emailDetails['txtSMTPUserName'];
    $txtSMTPServer = $emailDetails['txtSMTPServer'];
    $txtSMTPPassword = $emailDetails['txtSMTPPassword'];
    $txtFROMEmail = $emailDetails['txtSMTPUserName'];


    $txtemail = "email@w3ssolutions.com";

    $txtBCCList = (isEmail($email)) ? $email : "";

    $txtFROMEmailName = "Sonnac Bidding Centre";

    $txtSUBJECT = "Reset Password";

    $oEmail = new MailManager();
    $file = fopen("cpad/emails/forgotpasword.htm", "r");
    $mailbody = fread($file, filesize("cpad/emails/forgotpasword.htm"));
    fclose($file);

    $mailbody = preg_replace("/_user_/", $fname, $mailbody);
    $mailbody = preg_replace("/url_/", $url, $mailbody);
    $requestEmailed = $oEmail->sendEmail($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailbody, $txtemail, $txtFirstName, $Imagenames);
    return $requestEmailed;
}

function sendEmail_Inquary_for_Admin($vid, $message, $name, $company, $address, $country_id, $email, $gender, $telephone, $insertedId) {

    $url = CommonBase::getServer() . "/owner/carsale_inquary.php?&inq_id=" . CommonBase::encrypt($insertedId);
    $vdetails = Vehicle::getVehicle($vid);
    $emailDetails = getEmailDetails();
    //  var_dump($emailDetails);
    $txtSMTPUserName = $emailDetails['txtSMTPUserName'];
    $txtSMTPServer = $emailDetails['txtSMTPServer'];
    $txtSMTPPassword = $emailDetails['txtSMTPPassword'];
    $txtFROMEmail = $emailDetails['txtSMTPUserName'];
    $txtemail = "email@w3ssolutions.com";
    $txtBCCList = getAllAminEmails();
    $txtFROMEmailName = "Sonnac Bidding Centre";
    $txtSUBJECT = "User Added Inquiry ";
    $oEmail = new MailManager();
    $file = fopen("cpad/emails/inqury_for_admin.html", "r");
    $mailbody = fread($file, filesize("cpad/emails/inqury_for_admin.html"));
    fclose($file);


    $ref = $vdetails['ref'];
    $Make = CommonBase::getname($vdetails['fk_make'], "make");
    $Model = CommonBase::getname($vdetails['fk_model'], "model");
    $Modeltxt = $vdetails['modeltxt'];
    $EngineCapacity = $vdetails['eng_cap'];
    $Transmission = CommonBase::encrypt($vdetails['fk_transmission']);
    $country = CommonBase::getname($country_id, "country");
    $ym = $vdetails['yearmonth'];

    $mailbody = preg_replace("/_url_/", $url, $mailbody);
    $mailbody = preg_replace("/_ref_/", $ref, $mailbody);
    $mailbody = preg_replace("/_year_/", $ym, $mailbody);
    $mailbody = preg_replace("/_make_/", $Make, $mailbody);
    $mailbody = preg_replace("/_model_/", $Model, $mailbody);
    $mailbody = preg_replace("/_modeltxt_/", $Modeltxt, $mailbody);
    $mailbody = preg_replace("/_trans_/", $Transmission, $mailbody);
    $mailbody = preg_replace("/_msg_/", $message, $mailbody);
    $mailbody = preg_replace("/_cc_/", $EngineCapacity, $mailbody);
    $mailbody = preg_replace("/_name_/", $name, $mailbody);
    $mailbody = preg_replace("/_cname_/", $company, $mailbody);
    $mailbody = preg_replace("/_adress_/", $address, $mailbody);
    $mailbody = preg_replace("/_country_/", $country, $mailbody);
    $mailbody = preg_replace("/_phone_/", $telephone, $mailbody);
    $mailbody = preg_replace("/_email_/", $email, $mailbody);

    // echo $mailbody; exit();
    $requestEmailed = $oEmail->sendEmail($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailbody, $txtemail, $txtFirstName, $Imagenames);

    return $requestEmailed;
}

function sendEmail_Inquary_for_User($vid, $message, $name, $company, $address, $country_id, $email, $gender, $telephone, $insertedId) {


    $vdetails = Vehicle::getVehicle($vid);
    $emailDetails = getEmailDetails();
    $txtSMTPUserName = $emailDetails['txtSMTPUserName'];
    $txtSMTPServer = $emailDetails['txtSMTPServer'];
    $txtSMTPPassword = $emailDetails['txtSMTPPassword'];
    $txtFROMEmail = $emailDetails['txtSMTPUserName'];
    $txtemail = "email@w3ssolutions.com";
    $txtBCCList = (isEmail($email)) ? $email : "";
    $txtFROMEmailName = "Sonnac Bidding Centre";
    $txtSUBJECT = "Inquiry Submission - Sonnac Bidding Centre";
    $oEmail = new MailManager();
    $file = fopen("cpad/emails/inqury_for_user.html", "r");
    $mailbody = fread($file, filesize("cpad/emails/inqury_for_user.html"));
    fclose($file);

    $ref = $vdetails['ref'];
    $Make = CommonBase::getname($vdetails['fk_make'], "make");
    $Model = CommonBase::getname($vdetails['fk_model'], "model");
    $Modeltxt = $vdetails['modeltxt'];
    $EngineCapacity = $vdetails['eng_cap'];
    $Transmission = CommonBase::encrypt($vdetails['fk_transmission']);
    $country = CommonBase::getname($country_id, "country");
    $ym = $vdetails['yearmonth'];

    $mailbody = preg_replace("/_c_name_/", $name, $mailbody);
    $mailbody = preg_replace("/_inquryref_/", $insertedId, $mailbody);
    $mailbody = preg_replace("/_ref_/", $ref, $mailbody);
    $mailbody = preg_replace("/_year_/", $ym, $mailbody);
    $mailbody = preg_replace("/_make_/", $Make, $mailbody);
    $mailbody = preg_replace("/_model_/", $Model, $mailbody);
    $mailbody = preg_replace("/_modeltxt_/", $Modeltxt, $mailbody);
    $mailbody = preg_replace("/_trans_/", $Transmission, $mailbody);
    $mailbody = preg_replace("/_msg_/", $message, $mailbody);
    $mailbody = preg_replace("/_cc_/", $EngineCapacity, $mailbody);
    $mailbody = preg_replace("/_name_/", $name, $mailbody);
    $mailbody = preg_replace("/_cname_/", $company, $mailbody);
    $mailbody = preg_replace("/_adress_/", $address, $mailbody);
    $mailbody = preg_replace("/_country_/", $country, $mailbody);
    $mailbody = preg_replace("/_phone_/", $telephone, $mailbody);
    $mailbody = preg_replace("/_email_/", $email, $mailbody);

    //echo $mailbody;    exit();
    $requestEmailed = $oEmail->sendEmail($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailbody, $txtemail, $txtFirstName, $Imagenames);

    return $requestEmailed;
}

function sendEmail_neg_for_Admin($vid, $message, $cusId, $neg_v, $insertedId) {

    $url = CommonBase::getServer() . "/owner/carsale_negotiation.php?&neg_id=" . CommonBase::encrypt($insertedId);
    $vdetails = Vehicle::getVehicle($vid);
    $emailDetails = getEmailDetails();

    $txtSMTPUserName = $emailDetails['txtSMTPUserName'];
    $txtSMTPServer = $emailDetails['txtSMTPServer'];
    $txtSMTPPassword = $emailDetails['txtSMTPPassword'];
    $txtFROMEmail = $emailDetails['txtSMTPUserName'];
    $txtemail = "email@w3ssolutions.com";
    $txtBCCList = getAllAminEmails();

    $txtFROMEmailName = "Sonnac Bidding Centre";
    $txtSUBJECT = "User Added Negotiation ";
    $oEmail = new MailManager();

    $file = fopen("cpad/emails/neg_for_admin.html", "r");
    $mailbody = fread($file, filesize("cpad/emails/neg_for_admin.html"));
    fclose($file);


    $ref = $vdetails['ref'];
    $Make = CommonBase::getname($vdetails['fk_make'], "make");
    $Model = CommonBase::getname($vdetails['fk_model'], "model");
    $Modeltxt = $vdetails['modeltxt'];
    $EngineCapacity = $vdetails['eng_cap'];
    $Transmission = CommonBase::getname($vdetails['fk_transmission'], "transmission");
    $country = CommonBase::getname($country_id, "country");
    $ym = $vdetails['yearmonth'];

    $cus = Customer::getCustomerById($cusId);

    $name = $cus['fname'];
    $company = $cus['company'];
    $address = $cus['address'];
    $country = CommonBase::getname($cus['fk_country'], "country");
    $telephone = $cus['telephone'];
    $email = $cus['email'];

    $imgname = $vdetails['image1'];
    $img = 'admincontent/vimg/' . $imgname;

    $Images = array();
    $img_a['name'] = $img;
    $img_a['Id'] = "_imageurl_";
    array_push($Images, $img_a);
    $price = "";
    if ($vdetails['highestoffer'] == 1) {
        $price = "Highest offer";
    } else {
        $price = Vehicle::getname($vdetails['fk_price_type'], "price_type") . " <b>" . CommonBase::formatMoney($vdetails['price'], 0) . "</b>";
    }

    $mailbody = preg_replace("/_url_/", $url, $mailbody);
    $mailbody = preg_replace("/_ref_/", $ref, $mailbody);
    $mailbody = preg_replace("/_year_/", $ym, $mailbody);
    $mailbody = preg_replace("/_make_/", $Make, $mailbody);
    $mailbody = preg_replace("/_model_/", $Model, $mailbody);
    $mailbody = preg_replace("/_modeltxt_/", $Modeltxt, $mailbody);
    $mailbody = preg_replace("/_trans_/", $Transmission, $mailbody);
    $mailbody = preg_replace("/_cc_/", $EngineCapacity, $mailbody);

    // $mailbody = preg_replace("/_imageurl_/", $img, $mailbody);
    $mailbody = preg_replace("/_negamt_/", CommonBase::formatMoney($neg_v), $mailbody);
    $mailbody = preg_replace("/_msg_/", $message, $mailbody);
    $mailbody = preg_replace("/_Price_/", $price, $mailbody);

    $mailbody = preg_replace("/_name_/", $name, $mailbody);
    $mailbody = preg_replace("/_cname_/", $company, $mailbody);
    $mailbody = preg_replace("/_adress_/", $address, $mailbody);
    $mailbody = preg_replace("/_country_/", $country, $mailbody);
    $mailbody = preg_replace("/_phone_/", $telephone, $mailbody);
    $mailbody = preg_replace("/_email_/", $email, $mailbody);

    //echo $mailbody;
    //exit();
    $requestEmailed = $oEmail->sendEmail($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailbody, $txtemail, $txtFirstName, $Images);

    return $requestEmailed;
}

function sendEmail_neg_for_user($vid, $message, $cusId, $neg_v, $insertedId) {

    $url = CommonBase::getServer() . "/owner/carsale_negotiation.php?&neg_id=" . CommonBase::encrypt($insertedId);
    $vdetails = Vehicle::getVehicle($vid);
    $emailDetails = getEmailDetails();

    $txtSMTPUserName = $emailDetails['txtSMTPUserName'];
    $txtSMTPServer = $emailDetails['txtSMTPServer'];
    $txtSMTPPassword = $emailDetails['txtSMTPPassword'];
    $txtFROMEmail = $emailDetails['txtSMTPUserName'];
    $txtemail = "email@w3ssolutions.com";
//     $txtBCCList = getAllAminEmails();

    $txtFROMEmailName = "Sonnac Bidding Centre";
    $txtSUBJECT = "Negotiation Details";
    $oEmail = new MailManager();

    $file = fopen("cpad/emails/neg_for_user.html", "r");
    $mailbody = fread($file, filesize("cpad/emails/neg_for_user.html"));
    fclose($file);


    $ref = $vdetails['ref'];
    $Make = CommonBase::getname($vdetails['fk_make'], "make");
    $Model = CommonBase::getname($vdetails['fk_model'], "model");
    $Modeltxt = $vdetails['modeltxt'];
    $EngineCapacity = $vdetails['eng_cap'];
    $Transmission = CommonBase::getname($vdetails['fk_transmission'], "transmission");
    $country = CommonBase::getname($country_id, "country");
    $ym = $vdetails['yearmonth'];

    $cus = Customer::getCustomerById($cusId);

    $name = $cus['fname'];
    $company = $cus['company'];
    $address = $cus['address'];
    $country = CommonBase::getname($cus['fk_country'], "country");
    $telephone = $cus['telephone'];
    $email = $cus['email'];

    $imgname = $vdetails['image1'];
    $img = 'admincontent/vimg/' . $imgname;

    $Images = array();
    $img_a['name'] = $img;
    $img_a['Id'] = "_imageurl_";
    array_push($Images, $img_a);
    $price = "";
    if ($vdetails['highestoffer'] == 1) {
        $price = "Highest offer";
    } else {
        $price = Vehicle::getname($vdetails['fk_price_type'], "price_type") . " <b>" . CommonBase::formatMoney($vdetails['price'], 0) . "</b>";
    }




    $mailbody = preg_replace("/_c_name_/", $name, $mailbody);
    $mailbody = preg_replace("/_inquryref_/", $insertedId, $mailbody);
    $mailbody = preg_replace("/_ref_/", $ref, $mailbody);
    $mailbody = preg_replace("/_year_/", $ym, $mailbody);
    $mailbody = preg_replace("/_make_/", $Make, $mailbody);
    $mailbody = preg_replace("/_model_/", $Model, $mailbody);
    $mailbody = preg_replace("/_modeltxt_/", $Modeltxt, $mailbody);
    $mailbody = preg_replace("/_trans_/", $Transmission, $mailbody);
    $mailbody = preg_replace("/_cc_/", $EngineCapacity, $mailbody);

    // $mailbody = preg_replace("/_imageurl_/", $img, $mailbody);
    $mailbody = preg_replace("/_negamt_/", CommonBase::formatMoney($neg_v), $mailbody);
    $mailbody = preg_replace("/_msg_/", $message, $mailbody);
    $mailbody = preg_replace("/_Price_/", $price, $mailbody);

    $mailbody = preg_replace("/_name_/", $name, $mailbody);
    $mailbody = preg_replace("/_cname_/", $company, $mailbody);
    $mailbody = preg_replace("/_adress_/", $address, $mailbody);
    $mailbody = preg_replace("/_country_/", $country, $mailbody);
    $mailbody = preg_replace("/_phone_/", $telephone, $mailbody);
    $mailbody = preg_replace("/_email_/", $email, $mailbody);

//    echo $mailbody;
//    exit();
    $txtBCCList = $email;
    $requestEmailed = $oEmail->sendEmail($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailbody, $txtemail, $txtFirstName, $Images);

    return $requestEmailed;
}

function sendEmail_quotation_user($insertedId) {

    $url = CommonBase::getServer() . "/owner/carsale_negotiation.php?&neg_id=" . CommonBase::encrypt($insertedId);
    $vdetails = Vehicle::getVehicle($vid);
    $emailDetails = getEmailDetails();

    $txtSMTPUserName = $emailDetails['txtSMTPUserName'];
    $txtSMTPServer = $emailDetails['txtSMTPServer'];
    $txtSMTPPassword = $emailDetails['txtSMTPPassword'];
    $txtFROMEmail = $emailDetails['txtSMTPUserName'];
    $txtemail = "email@w3ssolutions.com";
//  $txtBCCList = getAllAminEmails();

    $txtFROMEmailName = "Sonnac Bidding Centre";
    $txtSUBJECT = "Quotation Details";
    $oEmail = new MailManager();

    $file = fopen("../cpad/emails/qtation_for_user.html", "r");
    $mailbody = fread($file, filesize("../cpad/emails/qtation_for_user.html"));
    fclose($file);


    $server = CommonBase::getServer();
    $qut = Customer::get_qtation_and_profoma_byId($insertedId);

    $vdetails = Vehicle::getVehicle($qut['fk_advert']);

//    $logoimg = CommonBase::getServer() . "images/logo.jpg";
//    $vthumb = CommonBase::getthumbURL() . $vdetails['image1'];
//    $qr = CommonBase::getServer() . "images/qr.png";
//
//    $mailbody = preg_replace("/_logoIMG_/", $logoimg, $mailbody);
//    $mailbody = preg_replace("/_vimgthumb_/", $vthumb, $mailbody);
//    $mailbody = preg_replace("/_qrimg_/", $qr, $mailbody);

    $Images = array();
    $img_a['name'] = "../images/logo.jpg";
    $img_a['Id'] = "_logoIMG_";
    array_push($Images, $img_a);
    $img_a['name'] = "../images/vthumbs/" . $vdetails['image1'];
    $img_a['Id'] = "_vimgthumb_";
    array_push($Images, $img_a);
    $img_a['name'] = "../images/qr.png";
    $img_a['Id'] = "_qrimg_";
    array_push($Images, $img_a);

    $date = new DateTime($qut['adddate']);

    $qdate = $date->format('d.m.Y');
    $qnumber = CommonBase::formatNumberwithzeros($qut['Id']);

    if (is_numeric($qut['fk_customer']) && $qut['fk_customer'] != 0) {
        $customer = Customer::getCustomerById($qut['fk_customer']);
        $name = ($customer['company'] != null) ? $customer['company'] : $customer['fname'];
        $address = ($customer['cadddress'] != null) ? $customer['cadddress'] : $customer['address'];
        $tel = $customer['telephone'] . "&nbsp;<br/>" . $customer['mobile'];
        $country = CommonBase::getname($customer['fk_country'], "country");
    }

    $pd = CommonBase::getname($qut['fk_ports'], "ports");
    $pm = CommonBase::getname($qut['fk_pay_mode'], "pay_mode");

    $ref = CommonBase::formatNumberwithzeros($vdetails['ref']);
    $Make = CommonBase::getname($vdetails['fk_make'], "make");
    $Model = CommonBase::getname($vdetails['fk_model'], "model");
    $Modeltxt = $vdetails['modeltxt'];
    $chasis = $vdetails['chasi'];
    $yearm = $vdetails['yearmonth'];
    $otherop = $vdetails['other_op'];

    $price = Vehicle::getname($qut['fk_price_type'], "price_type") . " <b>" . CommonBase::formatMoney($qut['price'], 0) . "</b>";

    $f = Vehicle::getname($qut['fk_price_type'], "price_type") . " <b>" . CommonBase::formatMoney($qut['freight_p'], 0) . "</b>";
    $i = Vehicle::getname($qut['fk_price_type'], "price_type") . " <b>" . CommonBase::formatMoney($qut['insurance_p'], 0) . "</b>";
    $total = Vehicle::getname($qut['fk_price_type'], "price_type") . " <b>" . CommonBase::formatMoney($qut['total_price'], 0) . "</b>";


    $ym = explode("-", $yearm);
    $u = $ym[0] . "_" . CommonBase::getname($vdetails['fk_make'], "make") . "_" . CommonBase::getname($vdetails['fk_model'], "model");
    $url = $server . 'vehicle/' . CommonBase::encrypt($vdetails['Id']) . '/' . $u . '.html';



    $stock = $vdetails['fk_stock'];

    $insufrt = ' <tr>
					  <td bgcolor="671797" width="200" height="30" align="center">
		           <font color="#FFFFFF" style="font-size:10px;font-weight:bold" face="Verdana, Arial, Helvetica, sans-serif">INSURANCE</font></td>
				   <td width="1" bgcolor="#000000"></td>
				   <td align="right" width="45%">
		           <font color="#000000" style="font-size:10px;" face="Verdana, Arial, Helvetica, sans-serif">_insu_&nbsp;</font></td>
				   </tr><tr><td colspan="3" height="1" bgcolor="#000000"></td></tr>
                   <tr>
					  <td bgcolor="671797" width="200" height="30" align="center">
		           <font color="#FFFFFF" style="font-size:10px;font-weight:bold" face="Verdana, Arial, Helvetica, sans-serif">FREIGHT</font></td>
				   <td width="1" bgcolor="#000000"></td>
				   <td align="right" width="45%">
		           <font color="#000000" style="font-size:10px;" face="Verdana, Arial, Helvetica, sans-serif">_frt_&nbsp;</font></td>
				   </tr><tr><td colspan="3" height="1" bgcolor="#000000"></td></tr>
                    <tr>';
    if ($stock == 2) {
        $mailbody = preg_replace("/_frtinsu_/", $insufrt, $mailbody);
        $mailbody = preg_replace("/_cif_/", "(C.I.F)", $mailbody);
        $mailbody = preg_replace("/_pd_/", $pd, $mailbody);
        $mailbody = preg_replace("/_pm_/", $pm, $mailbody);
    }
    if ($stock == 1) {
        $mailbody = preg_replace("/_frtinsu_/", "", $mailbody);
        $mailbody = preg_replace("/_cif_/", "", $mailbody);
        $mailbody = preg_replace("/_pd_/", "", $mailbody);
        $mailbody = preg_replace("/_pm_/", "", $mailbody);
    }


    $mailbody = preg_replace("/_ref_/", $ref, $mailbody);
    $mailbody = preg_replace("/_make_/", $Make, $mailbody);
    $mailbody = preg_replace("/_model_/", $Model, $mailbody);
    $mailbody = preg_replace("/_chasis_/", $chasis, $mailbody);
    $mailbody = preg_replace("/_ym_/", $yearm, $mailbody);
    $mailbody = preg_replace("/_otherop_/", $otherop, $mailbody);
    $mailbody = preg_replace("/_price_/", $price, $mailbody);

    $mailbody = preg_replace("/_insu_/", $i, $mailbody);
    $mailbody = preg_replace("/_frt_/", $f, $mailbody);
    $mailbody = preg_replace("/_total_/", $total, $mailbody);

    $mailbody = preg_replace("/_refurl_/", $url, $mailbody);
    $mailbody = preg_replace("/_qdate_/", $qdate, $mailbody);
    $mailbody = preg_replace("/_qnumber_/", $qnumber, $mailbody);
    $mailbody = preg_replace("/_name_/", $name, $mailbody);
    $mailbody = preg_replace("/_adress_/", $address, $mailbody);
    $mailbody = preg_replace("/_contry_/", $country, $mailbody);
    $mailbody = preg_replace("/_tel_/", $tel, $mailbody);

//    echo $mailbody;
//    exit();
    $email = $customer['email'];
    $txtBCCList = $email;
    $requestEmailed = $oEmail->sendEmail_doc($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailbody, $txtemail, $txtFirstName, $Images);
    return $requestEmailed;
}

function sendEmail_profoma_user($insertedId) {

    $url = CommonBase::getServer() . "/owner/carsale_negotiation.php?&neg_id=" . CommonBase::encrypt($insertedId);
    $vdetails = Vehicle::getVehicle($vid);
    $emailDetails = getEmailDetails();

    $txtSMTPUserName = $emailDetails['txtSMTPUserName'];
    $txtSMTPServer = $emailDetails['txtSMTPServer'];
    $txtSMTPPassword = $emailDetails['txtSMTPPassword'];
    $txtFROMEmail = $emailDetails['txtSMTPUserName'];
    $txtemail = "email@w3ssolutions.com";
//  $txtBCCList = getAllAminEmails();

    $txtFROMEmailName = "Sonnac Bidding Centre";
    $txtSUBJECT = "Profoma Details";
    $oEmail = new MailManager();

    $file = fopen("../cpad/emails/profoma_for_user.html", "r");
    $mailbody = fread($file, filesize("../cpad/emails/profoma_for_user.html"));
    fclose($file);


    $server = CommonBase::getServer();
    $qut = Customer::get_qtation_and_profoma_byId($insertedId, TRUE);

    $vdetails = Vehicle::getVehicle($qut['fk_advert']);

    $Images = array();
    $img_a['name'] = "../images/logo.jpg";
    $img_a['Id'] = "_logoIMG_";
    array_push($Images, $img_a);
    $img_a['name'] = "../images/qr.png";
    $img_a['Id'] = "_qrimg_";
    array_push($Images, $img_a);

    $date = new DateTime($qut['adddate']);

    $qdate = $date->format('l jS \of F Y');
    $qnumber = CommonBase::formatNumberwithzeros($qut['Id']);

    if (is_numeric($qut['fk_customer']) && $qut['fk_customer'] != 0) {
        $customer = Customer::getCustomerById($qut['fk_customer']);
        $name = ($customer['company'] != null) ? $customer['company'] : $customer['fname'];
        $address = ($customer['cadddress'] != null) ? $customer['cadddress'] : $customer['address'];
        $tel = $customer['telephone'] . "&nbsp;<br/>" . $customer['mobile'];
        $country = CommonBase::getname($customer['fk_country'], "country");
    }

    $pd = CommonBase::getname($qut['fk_ports'], "ports");
    $pm = CommonBase::getname($qut['fk_pay_mode'], "pay_mode");

    $ref = CommonBase::formatNumberwithzeros($vdetails['ref']);
    $Make = CommonBase::getname($vdetails['fk_make'], "make");
    $Model = CommonBase::getname($vdetails['fk_model'], "model");
    $Modeltxt = $vdetails['modeltxt'];
    $chasis = $vdetails['chasi'];
    $yearm = $vdetails['yearmonth'];
    $otherop = $vdetails['other_op'];
    $fuel = CommonBase::getname($vdetails['fk_fuel'], "fuel");
    $price = Vehicle::getname($qut['fk_price_type'], "price_type") . " <b>" . CommonBase::formatMoney($qut['price'], 0) . "</b>";

    $f = Vehicle::getname($qut['fk_price_type'], "price_type") . " <b>" . CommonBase::formatMoney($qut['freight_p'], 0) . "</b>";
    $i = Vehicle::getname($qut['fk_price_type'], "price_type") . " <b>" . CommonBase::formatMoney($qut['insurance_p'], 0) . "</b>";
    $total = Vehicle::getname($qut['fk_price_type'], "price_type") . " <b>" . CommonBase::formatMoney($qut['total_price'], 0) . "</b>";

    $ym = explode("-", $yearm);
    $u = $ym[0] . "_" . CommonBase::getname($vdetails['fk_make'], "make") . "_" . CommonBase::getname($vdetails['fk_model'], "model");
    $url = $server . 'vehicle/' . CommonBase::encrypt($vdetails['Id']) . '/' . $u . '.html';


    $stock = $vdetails['fk_stock'];

    $insufrt = '<tr><td bgcolor="#ffffff" height="20">
    <font color="#000000" style="font-size:11px;" face="Verdana, Arial, Helvetica, sans-serif"><strong>INSURANCE</strong></font></td>
				   <td bgcolor="#ffffff"></td>
				   <td align="right" bgcolor="#ffffff" style="font-size:11px;font-family:Verdana, Arial, Helvetica, sans-serif;font-color:#000000"><font color="#000000" style="font-size:10px;" face="Verdana, Arial, Helvetica, sans-serif">_insu_</font>&nbsp; </td>
				   </tr> 
                   			<tr><td bgcolor="#ffffff" height="20">
    <font color="#000000" style="font-size:11px;" face="Verdana, Arial, Helvetica, sans-serif"><strong>FREIGHT</strong></font></td>
				   <td bgcolor="#ffffff"></td>
				   <td align="right" bgcolor="#ffffff" style="font-size:11px;font-family:Verdana, Arial, Helvetica, sans-serif;font-color:#000000"><font color="#000000" style="font-size:10px;" face="Verdana, Arial, Helvetica, sans-serif">_frt_</font>&nbsp; </td>
				   </tr> ';

    if ($stock == 2) {
        $mailbody = preg_replace("/_frtinsu_/", $insufrt, $mailbody);
        $mailbody = preg_replace("/_cif_/", "(C.I.F)", $mailbody);
        $mailbody = preg_replace("/_pd_/", $pd, $mailbody);
        $mailbody = preg_replace("/_pm_/", $pm, $mailbody);
    }
    if ($stock == 1) {
        $mailbody = preg_replace("/_frtinsu_/", "", $mailbody);
        $mailbody = preg_replace("/_cif_/", "", $mailbody);
        $mailbody = preg_replace("/_pd_/", "", $mailbody);
        $mailbody = preg_replace("/_pm_/", "", $mailbody);
    }





    $mailbody = preg_replace("/_pd_/", $pd, $mailbody);
    $mailbody = preg_replace("/_pm_/", $pm, $mailbody);
    $mailbody = preg_replace("/_ref_/", $ref, $mailbody);
    $mailbody = preg_replace("/_make_/", $Make, $mailbody);
    $mailbody = preg_replace("/_model_/", $Model, $mailbody);
    $mailbody = preg_replace("/_chasis_/", $chasis, $mailbody);
    $mailbody = preg_replace("/_ym_/", $yearm, $mailbody);
    $mailbody = preg_replace("/_otherop_/", $otherop, $mailbody);
    $mailbody = preg_replace("/_price_/", $price, $mailbody);

    $mailbody = preg_replace("/_insu_/", $i, $mailbody);
    $mailbody = preg_replace("/_frt_/", $f, $mailbody);
    $mailbody = preg_replace("/_total_/", $total, $mailbody);

    $mailbody = preg_replace("/_refurl_/", $url, $mailbody);
    $mailbody = preg_replace("/_qdate_/", $qdate, $mailbody);
    $mailbody = preg_replace("/_qnumber_/", $qnumber, $mailbody);
    $mailbody = preg_replace("/_name_/", $name, $mailbody);
    $mailbody = preg_replace("/_adress_/", $address, $mailbody);
    $mailbody = preg_replace("/_contry_/", $country, $mailbody);
    $mailbody = preg_replace("/_tel_/", $tel, $mailbody);
    $mailbody = preg_replace("/_fuel_/", $fuel, $mailbody);
//    echo $mailbody;
//    exit();
    $email = $customer['email'];
    $txtBCCList = $email;
    $requestEmailed = $oEmail->sendEmail_doc($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailbody, $txtemail, $txtFirstName, $Images);
    return $requestEmailed;
}

?>
