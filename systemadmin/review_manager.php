<?
require_once '../cpad/reviewController.php';
CommonBase::IsAdminUser("user_curd");
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


        <!-- fancybox -->
        <link href="plugins/gallery/fancybox/jquery.fancybox.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="plugins/gallery/fancybox/jquery.fancybox.js"></script>

        <script type="text/javascript">
            $(function() {
                if ($('table').hasClass('dynamicTable_user')) {
                    $('.dynamicTable_user').dataTable({
                        "sPaginationType": "full_numbers",
                        "bJQueryUI": false,
                        "bAutoWidth": false,
                       
                        "fnInitComplete": function(oSettings, json) {
                            $('.dataTables_filter>label>input').attr('Id', 'search');
                        }

                    });
                }


                $(".popup").fancybox({
                    'width': '65%',
                    'height': '75%',
                    'autoScale': false,
                    'transitionIn': 'none',
                    'transitionOut': 'none',
                    'type': 'iframe'
                });


            })
        </script>
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

                        <h3>Review Managment</h3>                    

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
                            <li class="active">Review Manager</li>
                        </ul>

                    </div><!-- End .heading-->

                    <!-- Build page from here: -->
                    <div class="row-fluid">
                        <?= (isset($user_delmsg)) ? $user_delmsg : "" ?>
                        <div class="span12">

                            <div class="box gradient">
                                <div class="title">
                                    <h4>
                                        <span>Review List</span>
                                    </h4>

                                </div>


                                <div class="content noPad clearfix">


                                    <table cellpadding="0" cellspacing="0" border="0" class="responsive dynamicTable_user display table table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Review Id</th>
                                                <th>Customer Name</th>
                                                <th>Title</th>
                                                <th>Country</th>
                                                <th>Comment</th>
                                                <th>Edit</th>
                                                <th>Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?
                                            $reviews = Review::getAllReviews();
                                            while ($row = $reviews->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                <tr>
                                                    <td><?= (int) $row['Id'] ?></td>
                                                    <td><?= htmlspecialchars($row['customer_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                    <td><?= htmlspecialchars($row['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                    <td><?= htmlspecialchars($row['country'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                    <td><?= htmlspecialchars($row['comment'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>

                                                    <td>
                                                        <a style="float: right;margin: 5px; margin-bottom: 0px; z-index: 999" class="btn btn-warning btn-small popup"
                                                            href="review_edit.php?rid=<?= CommonBase::encrypt($row['Id']) ?>">
                                                            Edit</a>
                                                    </td>
                                                    <td>
                                                        <form method="POST" action="" style="margin: 0px;">
                                                            <input type="hidden" value="<?= CommonBase::encrypt($row['Id']) ?>" name="rid" />
                                                            <button class="btn btn-danger" type="submit" name="review_delete_btn"  onclick="return confirm('Are you Sure to Delete ?')" >Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <? }
                                            ?>  
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Review Id</th>
                                                <th>Customer Name</th>
                                                <th>Title</th>
                                                <th>Country</th>
                                                <th>Comment</th>
                                                <th>Edit</th>
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
