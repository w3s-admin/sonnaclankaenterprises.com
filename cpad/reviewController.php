<?php
@session_start();
require_once 'clsCommonBase.php';
require_once 'clsReview.php';
require_once 'common/HTTP_Upload.php';

$myCon = new ControlPadDB;
$dbh = $myCon->dbh;

// Reviews are only ever created/edited/deleted from the admin panel (see
// docs/04-managing-reviews.md) - there is no public review-submission form.
// This file is also require()d from about.php/includes/testimonial.php just
// to read the approved review list for public display, so the gate below is
// scoped to POST only; a normal GET page view is unaffected.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CommonBase::IsAdminUser();
    CommonBase::requireValidCsrf();
}

$name = isset($_POST['name']) ? $_POST['name'] : null;
$title = isset($_POST['title']) ? $_POST['title'] : null;
$country = isset($_POST['country']) ? $_POST['country'] : null;
$comment = isset($_POST['comment']) ? $_POST['comment'] : null;

if (isset($_POST['upload_review_image'])) {
    $reviewID = CommonBase::decrypt($_GET['rid']);
    $fcount = FALSE;
    if (!is_numeric($reviewID)) {
        $save_msg = CommonBase::createMassageDiv('err', "Invalid Fields", '', 0);
    }
}

// function uploadReviewFile($post) {
//     $upload = new http_upload('en');
//     $file = $upload->getFiles();
//     $allfiles = array();

//     foreach ($file as $currentFile) {
//         $validExtensions = array("jpg", "png", "gif", "webp", "JPG", "JPEG");
//         $currentFile->setValidExtensions($validExtensions, 'accept');

//         if (PEAR::isError($currentFile)) {
//             $save_msg = CommonBase::createMassageDiv('err', "Invalid File", $currentFile->getMessage(), 0);
//         } elseif ($currentFile->isValid()) {
//             $currentFile->setName('real');
//             $dest_dir = '../admincontent/review/';
//             if (!is_dir($dest_dir)) {
//                 mkdir($dest_dir);
//             }
//             $dest_name = $currentFile->moveTo($dest_dir);
//             if (PEAR::isError($dest_name)) {
//                 $save_msg = CommonBase::createMassageDiv('err', "Error", $dest_name->getMessage(), 0);
//             } else {
//                 $arr_f['name'] = $dest_name;
//                 $arr_f['path'] = $dest_dir;
//                 array_push($allfiles, $arr_f);
//             }
//         } else {
//             $save_msg = CommonBase::createMassageDiv('err', "Invalid File", $currentFile->errorMsg(), 0);
//         }
//     }

//     if (!empty($allfiles)) {
//         return [
//             'name' => $allfiles[0]['name'],
//             'path' => 'admincontent/review/'
//         ];
//     }
// }

function uploadReviewFile($post) {
    $upload = new http_upload('en');
    $file = $upload->getFiles();
    $allfiles = array();
    $defaultImage = '../admincontent/review/default-pic.jpg';  // Path to your default image

    foreach ($file as $currentFile) {
        $validExtensions = array("jpg", "png", "gif", "webp", "JPG", "JPEG");
        $currentFile->setValidExtensions($validExtensions, 'accept');

        if (PEAR::isError($currentFile)) {
            $save_msg = CommonBase::createMassageDiv('err', "Invalid File", $currentFile->getMessage(), 0);
        } elseif ($currentFile->isValid()) {
            $currentFile->setName('real');
            $dest_dir = '../admincontent/review/';
            if (!is_dir($dest_dir)) {
                mkdir($dest_dir);
            }
            $dest_name = $currentFile->moveTo($dest_dir);
            if (PEAR::isError($dest_name)) {
                $save_msg = CommonBase::createMassageDiv('err', "Error", $dest_name->getMessage(), 0);
            } else {
                $arr_f['name'] = $dest_name;
                $arr_f['path'] = $dest_dir;
                array_push($allfiles, $arr_f);
            }
        } else {
            $save_msg = CommonBase::createMassageDiv('err', "Invalid File", $currentFile->errorMsg(), 0);
        }
    }

    if (!empty($allfiles)) {
        return [
            'name' => $allfiles[0]['name'],
            'path' => 'admincontent/review/'
        ];
    } else {
        return [
            'name' => basename($defaultImage),
            'path' => 'admincontent/review/'
        ];
    }
}


if (isset($_POST['review_save_btn'])) {
    $post_arr = $_POST;

    if (empty($name) || empty($title) || empty($country) || empty($comment)) {
        $save_msg = CommonBase::createMassageDiv('err', "Error on Data", 'Please double-check the fields in red: Name, Title, Country, Comment, Image', 200);
        $error = true;
    } else {
        $image = uploadReviewFile($_POST);
        $now = CommonBase::getcurrenttime();
        $query = "INSERT INTO review (customer_name, title, country, comment, `status`, image_name, image_path) VALUES (?, ?, ?, ?, 1, ?, ?)";
        $stmt = $dbh->prepare($query);
        $done = $stmt->execute([$name, $title, $country, $comment, $image['name'], $image['path']]);
        if ($done) {
            $save_msg = CommonBase::createMassageDiv('suc', 'Successfully added', 'Review added successfully.', 200);
            // Flashed via session, not the URL: the "encrypted" query-string
            // value is a fixed-key reversible cipher an attacker can forge
            // off-site, so anything echoed from it must never be trusted as
            // pre-built HTML (see CommonBase::encrypt()).
            $_SESSION['_flash_save_msg'] = $save_msg;
            CommonBase::SendRedirect("review_add.php");
        }
    }
}

if (isset($_POST['review_edit_btn'])) {
    $reviewID = CommonBase::decrypt($_GET['rid']);
    $error = false;

    if (empty($name) || empty($title) || empty($country) || !is_numeric($reviewID)) {
        $save_msg = CommonBase::createMassageDiv('err', "Error on Data", 'Please double-check the fields in red: Name, Title, Country, Comment', 0);
        $error = true;
    } else {
        $now = CommonBase::getcurrenttime();
        $query = "UPDATE review SET customer_name = ?, title = ?, country = ?, comment = ? WHERE Id = ?";
        $stmt = $dbh->prepare($query);
        $done = $stmt->execute([$name, $title, $country, $comment, $reviewID]);
        if ($done) {
            $save_msg = CommonBase::createMassageDiv('suc', 'Successfully Updated', 'Review updated successfully', 0);
            echo CommonBase::refreshMotherwithouturlFancyTimeOut(3000);
        }
    }
}

if (isset($_POST['review_delete_btn'])) {
    $reviewID = CommonBase::decrypt($_POST['rid']);
    if (is_numeric($reviewID)) {
        $stmt_select = $dbh->prepare("SELECT image_path FROM review WHERE Id = ?");
        $stmt_select->execute([$reviewID]);
        $image_path = $stmt_select->fetchColumn();

        if ($image_path && file_exists($image_path)) {
            unlink($image_path);
        }

        $stmt_delete = $dbh->prepare("DELETE FROM review WHERE Id = ?");
        $done = $stmt_delete->execute([$reviewID]);
        if ($done) {
            $save_msg = CommonBase::createMassageDiv('suc', 'Successfully Deleted', 'Review deleted successfully', 0);
        }
    }
}

function getAllReviews($dbh) {
    $stmt = $dbh->prepare("SELECT customer_name, title, country, comment, image_name, image_path FROM review WHERE status = 1");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$reviews = getAllReviews($dbh);

?>
