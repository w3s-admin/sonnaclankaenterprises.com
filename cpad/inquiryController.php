<?php

require_once 'clsCommonBase.php';
require_once 'clsInquiry.php';

// Admin-only (viewing/managing customer inquiries) - the public submission
// path is assets/php/inquiry-process.php, a separate, unauthenticated
// endpoint; this file never handles the public form.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CommonBase::IsAdminUser();
    CommonBase::requireValidCsrf();
}

if (isset($_POST['inquiry_read_btn'])) {
    $id = CommonBase::decrypt($_POST['iid'] ?? '');
    if (is_numeric($id)) {
        Inquiry::markRead($id);
    }
    CommonBase::SendRedirect('inquiry_manager.php');
}

if (isset($_POST['inquiry_delete_btn'])) {
    $id = CommonBase::decrypt($_POST['iid'] ?? '');
    if (is_numeric($id)) {
        Inquiry::delete($id);
    }
    CommonBase::SendRedirect('inquiry_manager.php');
}

?>
