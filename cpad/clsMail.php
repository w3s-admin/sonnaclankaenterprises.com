<?php

// +--------------------------------------------------------------------+
// | MailManager, the MailManager Extension                         |
// +--------------------------------------------------------------------+
// | Copyright (c) 2011 w3ssolutions.com                         |
// +--------------------------------------------------------------------+
/**
 * 
 * @Author Sanjaya.amarasinha@gmail.com
 * @copyright 2011
 */
include_once("clsCommonBase.php");
include_once("common/class.phpmailer.php");

class MailManager extends CommonBase {

    // }}}
    // {{{ sendEmail()
    /**
     * Send mail
     * 
     * @param string $txtCCList CC List
     * @param string $txtBCCList BCC List
     * @param string $txtFROMEmail From email address
     * @param string $txtFROMEmailName From name
     * @param string $txtSMTPServer SMTP Server
     * @param string $txtSMTPUserName SMTP Username
     * @param string $txtSMTPPassword SMTP Password
     * @param string $txtSUBJECT Subject of the message
     * @param string $mailBody Body of the message
     * @param string $toAddress To email address
     * @param string $toName To name
     * @access public 
     * @return bool true if Item is created
     */
    function sendEmail($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailBody, $toAddress, $toName, $Imagenames) {
        $mail = new PHPMailer();
        $mail->SetLanguage("en", "common/");
        $mail->IsSMTP(); // set mailer to use SMTP
        $mail->Host = $txtSMTPServer; // specify main and backup server
        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->Username = $txtSMTPUserName; // SMTP username
        $mail->Password = $txtSMTPPassword; // SMTP password
        $mail->From = $txtFROMEmail;
        $mail->FromName = $txtFROMEmailName;
        if ($toAddress) {
            $mail->AddAddress($toAddress, $toName);
        }

        $cclist = $txtCCList;
        if ($txtCCList != "") {
            if (preg_match("/,/", $txtCCList)) {
                $cclist = explode(",", $txtCCList);
            } else {
                $cclist = explode(chr(10), $txtCCList);
            }

            foreach ($cclist as $adr1) {
                $adr = trim($adr1);
                if ($adr1) {
                    $mail->AddCC($adr1);
                }
            }
        }
        if ($txtBCCList) {
            $bcclist = "";
            if (preg_match("/,/", $txtBCCList)) {
                $bcclist = explode(",", $txtBCCList);
            } else {
                $bcclist = explode(chr(10), $txtBCCList);
            }
            foreach ($bcclist as $adr) {
                $adr = trim($adr);
                if ($adr) {
                    $mail->AddBCC($adr);
                }
            }
        }
        // $mail->AddAddress("ellen@example.com");                  // name is optional
        // $mail->AddReplyTo("info@example.com", "Information");
        // $mailBody = str_replace("images/sinhala_button.gif", "cid:btn", $mailBody);
        $mailBody = str_replace("images/mailImg/logoM.jpg", "cid:fotterLogo", $mailBody);

        $mail->WordWrap = 50; // set word wrap to 50 characters 
        //  $mail->AddEmbeddedImage("images/mailImg/sinhala_button.gif", "btn"); // add attachments
        $mail->AddEmbeddedImage("images/mailImg/logoM.jpg", "fotterLogo"); // add attachments
        // $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
        $count = 1;

        
        if ($Imagenames) {
            foreach ($Imagenames as &$name) {
                $imgname = $name['name'];
                $imgId = $name['Id'];
                $mail->AddEmbeddedImage($imgname, "A$count", basename($imgname));
                $mailBody = str_replace($imgId, "cid:A$count", $mailBody);
                $count++;
            }
        }
        //echo ($mailBody);        exit();

        $mail->IsHTML(true); // set email format to HTML
        $mail->Subject = $txtSUBJECT;
        $mail->Body = stripcslashes($mailBody);
        // $mail->AltBody = "This is the body in plain text for non-HTML mail clients";
        $ok = false;
        // echo($mailBody);
        if (!$mail->Send()) {
        //    $this->setError("Message could not be sent. <br>" . $mail->ErrorInfo);
             $ok = FALSE;
        } else {
        //    $this->setSuccess("Email was sent to $toAddress.");
            $ok = true;
        }
        return $ok;
    }
    
    function sendEmail_doc($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailBody, $toAddress, $toName, $Imagenames) {
        $mail = new PHPMailer();
        $mail->SetLanguage("en", "common/");
        $mail->IsSMTP(); // set mailer to use SMTP
        $mail->Host = $txtSMTPServer; // specify main and backup server
        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->Username = $txtSMTPUserName; // SMTP username
        $mail->Password = $txtSMTPPassword; // SMTP password
        $mail->From = $txtFROMEmail;
        $mail->FromName = $txtFROMEmailName;
        if ($toAddress) {
            $mail->AddAddress($toAddress, $toName);
        }

        $cclist = $txtCCList;
        if ($txtCCList != "") {
            if (preg_match("/,/", $txtCCList)) {
                $cclist = explode(",", $txtCCList);
            } else {
                $cclist = explode(chr(10), $txtCCList);
            }

            foreach ($cclist as $adr1) {
                $adr = trim($adr1);
                if ($adr1) {
                    $mail->AddCC($adr1);
                }
            }
        }
        if ($txtBCCList) {
            $bcclist = "";
            if (preg_match("/,/", $txtBCCList)) {
                $bcclist = explode(",", $txtBCCList);
            } else {
                $bcclist = explode(chr(10), $txtBCCList);
            }
            foreach ($bcclist as $adr) {
                $adr = trim($adr);
                if ($adr) {
                    $mail->AddBCC($adr);
                }
            }
        }
        // $mail->AddAddress("ellen@example.com");                  // name is optional
        // $mail->AddReplyTo("info@example.com", "Information");
        // $mailBody = str_replace("images/sinhala_button.gif", "cid:btn", $mailBody);
      //  $mailBody = str_replace("images/mailImg/logoM.jpg", "cid:fotterLogo", $mailBody);

        $mail->WordWrap = 50; // set word wrap to 50 characters 
        //  $mail->AddEmbeddedImage("images/mailImg/sinhala_button.gif", "btn"); // add attachments
       // $mail->AddEmbeddedImage("images/mailImg/logoM.jpg", "fotterLogo"); // add attachments
        // $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
        $count = 1;

        
        if ($Imagenames) {
            foreach ($Imagenames as &$name) {
                $imgname = $name['name'];
                $imgId = $name['Id'];
                $mail->AddEmbeddedImage($imgname, "A$count", basename($imgname));
                $mailBody = str_replace($imgId, "cid:A$count", $mailBody);
                $count++;
            }
        }
        //echo ($mailBody);        exit();

        $mail->IsHTML(true); // set email format to HTML
        $mail->Subject = $txtSUBJECT;
        $mail->Body = stripcslashes($mailBody);
        // $mail->AltBody = "This is the body in plain text for non-HTML mail clients";
        $ok = false;
        // echo($mailBody);
        if (!$mail->Send()) {
            $this->setError("Message could not be sent. <br>" . $mail->ErrorInfo);
        } else {
            $this->setSuccess("Email was sent to $toAddress.");
            $ok = true;
        }
        return $ok;
    }
    
    function sendEmail_newsletter($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailBody, $toAddress, $toName, $Imagenames) {
        $mail = new PHPMailer();
        $mail->SetLanguage("en", "common/");
        $mail->IsSMTP(); // set mailer to use SMTP
        $mail->Host = $txtSMTPServer; // specify main and backup server
        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->Username = $txtSMTPUserName; // SMTP username
        $mail->Password = $txtSMTPPassword; // SMTP password
        $mail->From = $txtFROMEmail;
        $mail->FromName = $txtFROMEmailName;
        if ($toAddress) {
            $mail->AddAddress($toAddress, $toName);
        }

        $cclist = $txtCCList;
        if ($txtCCList != "") {
            if (preg_match("/,/", $txtCCList)) {
                $cclist = explode(",", $txtCCList);
            } else {
                $cclist = explode(chr(10), $txtCCList);
            }

            foreach ($cclist as $adr1) {
                $adr = trim($adr1);
                if ($adr1) {
                    $mail->AddCC($adr1);
                }
            }
        }
        if ($txtBCCList) {
            $bcclist = "";
            if (preg_match("/,/", $txtBCCList)) {
                $bcclist = explode(",", $txtBCCList);
            } else {
                $bcclist = explode(chr(10), $txtBCCList);
            }
            foreach ($bcclist as $adr) {
                $adr = trim($adr);
                if ($adr) {
                    $mail->AddBCC($adr);
                }
            }
        }
        // $mail->AddAddress("ellen@example.com");                  // name is optional
        // $mail->AddReplyTo("info@example.com", "Information");
        // $mailBody = str_replace("images/sinhala_button.gif", "cid:btn", $mailBody);
        $mailBody = str_replace("kaduwela_head.jpg", "cid:head", $mailBody);
        $mail->WordWrap = 50; // set word wrap to 50 characters 
        //  $mail->AddEmbeddedImage("images/mailImg/sinhala_button.gif", "btn"); // add attachments
        $mail->AddEmbeddedImage("images/newsletter/kaduwela_head.jpg", "head"); // add attachments
        // $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
        $count = 1;
        //  print_r($Imagenames);



        foreach ($Imagenames as &$name) {
            $imgname = $name['name'];
            $imgId = $name['Id'];

            $mail->AddEmbeddedImage($imgname, "A$count", basename($imgname));
            // var_dump($imgId);
            $mailBody = str_replace($imgId, "cid:A$count", $mailBody);

            $count++;
        }




        $mail->IsHTML(true); // set email format to HTML
        $mail->Subject = $txtSUBJECT;
        $mail->Body = stripcslashes($mailBody);
        // $mail->AltBody = "This is the body in plain text for non-HTML mail clients";
        $ok = false;
        // echo($mailBody);
        if (!$mail->Send()) {
         //   $this->setError("Message could not be sent. <br>" . $mail->ErrorInfo);
              $ok = false;
        } else {
           // $this->setSuccess("Email was sent to $toAddress.");
            $ok = true;
        }
        return $ok;
    }

    function sendEmailWithImage($txtCCList, $txtBCCList, $txtFROMEmail, $txtFROMEmailName, $txtSMTPServer, $txtSMTPUserName, $txtSMTPPassword, $txtSUBJECT, $mailBody, $toAddress, $toName, $imageName, $imagePath) {
        $mail = new PHPMailer();
        $mail->SetLanguage("en", "common/");
        $mail->IsSMTP(); // set mailer to use SMTP
        $mail->Host = $txtSMTPServer; // specify main and backup server
        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->Username = $txtSMTPUserName; // SMTP username
        $mail->Password = $txtSMTPPassword; // SMTP password
        $mail->From = $txtFROMEmail;
        $mail->FromName = $txtFROMEmailName;
        if ($toAddress) {
            $mail->AddAddress($toAddress, $toName);
        }

        $cclist = $txtCCList;
        if ($txtCCList != "") {
            if (preg_match("/,/", $txtCCList)) {
                $cclist = explode(",", $txtCCList);
            } else {
                $cclist = explode(chr(10), $txtCCList);
            }

            foreach ($cclist as $adr1) {
                $adr = trim($adr1);
                if ($adr1) {
                    $mail->AddCC($adr1);
                }
            }
        }
        if ($txtBCCList) {
            $bcclist = "";
            if (preg_match("/,/", $txtBCCList)) {
                $bcclist = explode(",", $txtBCCList);
            } else {
                $bcclist = explode(chr(10), $txtBCCList);
            }
            foreach ($bcclist as $adr) {
                $adr = trim($adr);
                if ($adr) {
                    $mail->AddBCC($adr);
                }
            }
        }
        $mailBody = str_replace($imageName, "cid:img1", $mailBody);
        $mail->WordWrap = 50; // set word wrap to 50 characters 
        $mail->AddEmbeddedImage($imagePath, "img1", "", "base64", "image/gif"); // add attachments
        // $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
        $mail->IsHTML(true); // set email format to HTML
        $mail->Subject = $txtSUBJECT;
        $mail->Body = stripcslashes($mailBody);
        // $mail->AltBody = "This is the body in plain text for non-HTML mail clients";
        $ok = false;
        if (!$mail->Send()) {
            $this->setError("Message could not be sent. <br>" . $mail->ErrorInfo);
        } else {
            $this->setSuccess("Email was sent to $toAddress.");
            $ok = true;
        }
        return $ok;
    }

}

?>