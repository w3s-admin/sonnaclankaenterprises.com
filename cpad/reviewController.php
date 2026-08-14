<?php
@session_start();
require_once 'clsCommonBase.php';
require_once 'clsReview.php';
require_once 'common/HTTP_Upload.php';

$myCon = new ControlPadDB;
$dbh = $myCon->dbh;
extract($_POST);

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
//         $validExtensions = array("jpg", "png", "gif", "JPG", "JPEG");
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
        $validExtensions = array("jpg", "png", "gif", "JPG", "JPEG");
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
            CommonBase::SendRedirect(CommonBase::appendGettoURL("save_msg", CommonBase::encrypt($save_msg)));
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
        $query = "UPDATE review SET fullname = ?, title = ?, country = ?, comment = ?, image_path = ? WHERE Id = ?";
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
