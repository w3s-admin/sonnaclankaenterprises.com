<?php
error_reporting(0);
ini_set('display_errors', 0);

require_once __DIR__ . '/../../cpad/clsCommonBase.php';
require_once __DIR__ . '/../../cpad/clsInquiry.php';

// Honeypot - same convention as assets/php/form-process.php: a hidden field
// no real visitor can see or fill. If it arrives non-empty, a bot filled in
// every input it found - silently drop the submission.
if (!empty($_POST['gridCheck'])) {
    echo "success";
    exit;
}

$errorMSG = "";

if (empty($_POST["name"])) {
    $errorMSG .= "Name is required ";
}

if (empty($_POST["email"])) {
    $errorMSG .= "Email is required ";
} elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $errorMSG .= "Please enter a valid email address ";
}

if (empty($_POST["message"])) {
    $errorMSG .= "Message is required ";
}

$vehicleId = null;
if (!empty($_POST["vid"])) {
    $decrypted = CommonBase::decrypt($_POST["vid"]);
    if (is_numeric($decrypted)) {
        $vehicleId = (int) $decrypted;
    }
}

if ($errorMSG !== "") {
    echo $errorMSG;
    exit;
}

$done = Inquiry::add(
    $_POST["name"],
    $_POST["email"],
    $_POST["phone"] ?? '',
    $_POST["message"],
    $vehicleId,
    CommonBase::getRealIpAddr()
);

echo $done ? "success" : "Something went wrong :(";
