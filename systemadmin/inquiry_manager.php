<?
require_once '../cpad/inquiryController.php';
CommonBase::IsAdminUser();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <? include_once './inc/comman_head_admin.php'; ?>
        <link href="plugins/tables/dataTables/jquery.dataTables.css" type="text/css" rel="stylesheet" />

        <!-- Table plugins -->
        <script type="text/javascript" src="plugins/tables/dataTables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="plugins/tables/responsive-tables/responsive-tables.js"></script><!-- Make tables responsive -->
        <script type="text/javascript" src="js/datatable.js"></script><!-- Init plugins only for page -->

        <link href="plugins/misc/pnotify/jquery.pnotify.default.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="plugins/misc/pnotify/jquery.pnotify.min.js"></script>

        <script type="text/javascript">
            $(function() {
                if ($('table').hasClass('dynamicTable_user')) {
                    $('.dynamicTable_user').dataTable({
                        "sPaginationType": "full_numbers",
                        "bJQueryUI": false,
                        "bAutoWidth": false,
                        "aaSorting": [[0, 'desc']],
                        "fnInitComplete": function(oSettings, json) {
                            $('.dataTables_filter>label>input').attr('Id', 'search');
                        }
                    });
                }
            })
        </script>
        <style>
            tr.inquiry-unread { font-weight: bold; background: #FFF9E6; }
            .inquiry-message { max-width: 320px; white-space: normal; }
        </style>
    </head>

    <body>
        <!-- loading animation -->
        <div id="qLoverlay"></div>
        <div id="qLbar"></div>


        <? include_once './inc/pagehead.php'; ?>

        <div id="wrapper">

            <!--Responsive navigation button-->
            <div class="resBtn">
                <a href="#"><span class="icon16 minia-icon-list-3"></span></a>
            </div>

            <? include_once './inc/slideBar.php'; ?>

            <!--Body content-->
            <div id="content" class="clearfix">
                <div class="contentwrapper"><!--Content wrapper-->

                    <div class="heading">

                        <h3>Inquiry Manager</h3>

                        <div class="resBtnSearch">
                            <a href="#"><span class="icon16 icomoon-icon-search-3"></span></a>
                        </div>

                        <?
                        include_once './inc/search.php';
                        ?>

                        <ul class="breadcrumb">
                            <li>You are here:</li>
                            <li>
                                <a href="dashboard.php" class="tip" title="back to dashboard">
                                    <span class="icon16 icomoon-icon-screen-2"></span>
                                </a>
                                <span class="divider">
                                    <span class="icon16 icomoon-icon-arrow-right-2"></span>
                                </span>
                            </li>
                            <li class="active">Inquiry Manager</li>
                        </ul>

                    </div><!-- End .heading-->

                    <!-- Build page from here: -->
                    <div class="row-fluid">
                        <div class="span12">

                            <div class="box gradient">
                                <div class="title">
                                    <h4>
                                        <span>Customer Inquiries</span>
                                    </h4>
                                </div>

                                <div class="content noPad clearfix">

                                    <table cellpadding="0" cellspacing="0" border="0" class="responsive dynamicTable_user display table table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Vehicle</th>
                                                <th>Message</th>
                                                <th>Status</th>
                                                <th>Mark Read</th>
                                                <th>Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?
                                            $inquiries = Inquiry::getAll();
                                            while ($row = $inquiries->fetch(PDO::FETCH_ASSOC)) {
                                                $isUnread = ((int) $row['status'] === 0);
                                                $vehicleLabel = $row['fk_advert']
                                                    ? trim(($row['modeltxt'] ?? '') . ' (' . ($row['chasi'] ?? '') . ')')
                                                    : 'General enquiry';
                                                ?>
                                                <tr<?= $isUnread ? ' class="inquiry-unread"' : '' ?>>
                                                    <td><?= htmlspecialchars($row['addt'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                    <td><?= htmlspecialchars($row['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                    <td><a href="mailto:<?= htmlspecialchars($row['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></a></td>
                                                    <td><?= htmlspecialchars($row['phone'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                    <td><?= htmlspecialchars($vehicleLabel, ENT_QUOTES, 'UTF-8') ?></td>
                                                    <td class="inquiry-message"><?= nl2br(htmlspecialchars($row['message'] ?? '', ENT_QUOTES, 'UTF-8')) ?></td>
                                                    <td><?= $isUnread ? '<span class="status-badge inactive">New</span>' : '<span class="status-badge active">Read</span>' ?></td>
                                                    <td>
                                                        <?php if ($isUnread): ?>
                                                        <form method="POST" action="" style="margin: 0px;">
                                                            <input type="hidden" value="<?= CommonBase::encrypt($row['Id']) ?>" name="iid" />
                                                            <button class="btn btn-small btn-warning" type="submit" name="inquiry_read_btn">Mark Read</button>
                                                        </form>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <form method="POST" action="" style="margin: 0px;">
                                                            <input type="hidden" value="<?= CommonBase::encrypt($row['Id']) ?>" name="iid" />
                                                            <button class="btn btn-small btn-danger" type="submit" name="inquiry_delete_btn" onclick="return confirm('Are you Sure to Delete ?')">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <? } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Date</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Vehicle</th>
                                                <th>Message</th>
                                                <th>Status</th>
                                                <th>Mark Read</th>
                                                <th>Remove</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div><!-- End .box -->

                        </div><!-- End .span12 -->

                    </div><!-- End .row-fluid -->
                    <!--End page -->

                </div><!-- End contentwrapper -->
            </div><!-- End #content -->

        </div><!-- End #wrapper -->

        <? include_once './inc/comman_js.php'; ?>


    </body>
</html>
