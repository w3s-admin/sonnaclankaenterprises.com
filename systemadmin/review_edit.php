<?
require_once '../cpad/reviewController.php';
CommonBase::IsAdminUser("user_curd");

$reviewID = CommonBase::decrypt($_GET['rid'] ?? '');
$review = is_numeric($reviewID) ? Review::getReviewById($reviewID) : null;

if (!isset($save_msg) && !empty($_SESSION['_flash_save_msg'])) {
    $save_msg = $_SESSION['_flash_save_msg'];
    unset($_SESSION['_flash_save_msg']);
}
$save_msg = $save_msg ?? null;

// $name/$title/$country/$comment come from reviewController.php's extract()
// of $_POST on a failed submit (so the admin's edits aren't lost); on a
// plain page load (no submit yet) fall back to the existing review's data.
$name = $name ?? ($review['customer_name'] ?? null);
$title = $title ?? ($review['title'] ?? null);
$country = $country ?? ($review['country'] ?? null);
$comment = $comment ?? ($review['comment'] ?? null);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <? include_once './inc/comman_head_admin.php'; ?>

        <!-- Plugin stylesheets -->
        <link href="plugins/forms/select/select2.css" type="text/css" rel="stylesheet" />
        <link href="plugins/forms/validate/validate.css" type="text/css" rel="stylesheet" />

        <link href="plugins/forms/inputlimiter/jquery.inputlimiter.css" type="text/css" rel="stylesheet" />
        <link href="plugins/forms/ibutton/jquery.ibutton.css" type="text/css" rel="stylesheet" />
        <!-- Form plugins -->
        <script type="text/javascript" src="plugins/forms/watermark/jquery.watermark.min.js"></script>
        <script type="text/javascript" src="plugins/forms/uniform/jquery.uniform.min.js"></script>
        <script type="text/javascript" src="plugins/forms/select/select2.min.js"></script>
        <script type="text/javascript" src="plugins/forms/validate/jquery.validate.min.js"></script>
        <script type="text/javascript" src="plugins/forms/inputlimiter/jquery.inputlimiter.1.3.min.js"></script>

        <script type="text/javascript" src="plugins/forms/ibutton/jquery.ibutton.min.js"></script>

        <script type="text/javascript">
            $(function() {
                $("#form-validate_editReview").validate({
                    ignore: null,
                    ignore: 'input[type="hidden"]'
                });

                if ($('textarea').hasClass('limit')) {
                    $('.limit').inputlimiter({
                        limit: 250
                    });
                }
            });
        </script>

        <!-- This page is only ever opened inside the Review Manager popup
             (fancybox iframe) - the full page chrome (logo bar, sidebar,
             breadcrumb) is already visible behind it, so this is deliberately
             just the form, not another copy of the whole admin layout. -->
        <style>
            body { padding: 20px; background: #fff; }
        </style>
    </head>

    <body>
        <? if (!$review) { ?>
            <div class="alert alert-error">Review not found.</div>
        <? } else { ?>
        <form class="form-horizontal" id="form-validate_editReview" action="review_edit.php?rid=<?= htmlspecialchars($_GET['rid'], ENT_QUOTES, 'UTF-8') ?>" method="post">
            <h3 style="margin-top:0;">Edit Review</h3>
            <?= ($save_msg != NULL) ? "$save_msg" : "" ?>

            <div class="form-row row-fluid">
                <div class="span12">
                    <div class="row-fluid">
                        <label class="form-label span3 red" for="name">Name</label>
                        <input class="span6 required" id="name" name="name" value="<?= htmlspecialchars($name ?? '', ENT_QUOTES, 'UTF-8') ?>"  type="text" />
                    </div>
                </div>
            </div>

            <div class="form-row row-fluid">
                <div class="span12">
                    <div class="row-fluid">
                        <label class="form-label span3 red" for="title">Title</label>
                        <input class="span6 required" id="title" name="title"  value="<?= htmlspecialchars($title ?? '', ENT_QUOTES, 'UTF-8') ?>" type="text" />
                    </div>
                </div>
            </div>

            <div class="form-row row-fluid">
                <div class="span12">
                    <div class="row-fluid">
                        <label class="form-label span3 red" for="country">Country</label>
                        <input class="span6" id="country" name="country"  value="<?= htmlspecialchars($country ?? '', ENT_QUOTES, 'UTF-8') ?>" type="text" />
                    </div>
                </div>
            </div>

            <div class="form-row row-fluid">
                <div class="span12">
                    <div class="row-fluid">
                        <label class="form-label span3 red" for="comment">Comment</label>
                        <textarea rows="5" id="comment" name="comment" class="span6 uniform"><?= htmlspecialchars($comment ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>
                </div>
            </div>

            <div class="form-actions" style="margin-top:15px;">
                <button type="submit" class="btn marginR10 btn-info" name="review_edit_btn">Save changes</button>
                <button class="btn btn-danger" type="reset">Cancel</button>
            </div>
        </form>
        <? } ?>

        <? include_once './inc/comman_js.php'; ?>
    </body>
</html>
