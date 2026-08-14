<?
require_once '../cpad/emailController.php';
CommonBase::IsAdminUser();
extract($_GET);
$name = $name ?? null;
$email = $email ?? null;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <? include_once './inc/comman_head_admin.php'; ?>

        <!-- Plugin stylesheets -->


        <link href="plugins/forms/select/select2.css" type="text/css" rel="stylesheet" />


        <link href="plugins/forms/inputlimiter/jquery.inputlimiter.css" type="text/css" rel="stylesheet" />
        <link href="plugins/forms/ibutton/jquery.ibutton.css" type="text/css" rel="stylesheet" />
        <!-- Form plugins -->
        <script type="text/javascript" src="plugins/forms/watermark/jquery.watermark.min.js"></script>
        <script type="text/javascript" src="plugins/forms/uniform/jquery.uniform.min.js"></script>
        <script type="text/javascript" src="plugins/forms/select/select2.min.js"></script>

        <script type="text/javascript" src="plugins/forms/inputlimiter/jquery.inputlimiter.1.3.min.js"></script>

        <script type="text/javascript" src="plugins/forms/ibutton/jquery.ibutton.min.js"></script>

        <script type="text/javascript" src="plugins/forms/validate/jquery.validate.min.js"></script>
        <link href="plugins/forms/validate/validate.css" type="text/css" rel="stylesheet" />

        <link href="css/supr-theme/jquery.ui.supr.css" rel="stylesheet" type="text/css"/>
        <link href="css/icons.css" rel="stylesheet" type="text/css" />


        <!-- Important Place before main.js  -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/supr-theme/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" src="js/supr-theme/jquery-ui-sliderAccess.js"></script>
        <script type="text/javascript" src="plugins/fix/touch-punch/jquery.ui.touch-punch.min.js"></script><!-- Unable touch for JQueryUI -->

        <!-- Table plugins -->
        <link href="plugins/tables/dataTables/jquery.dataTables.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="plugins/tables/dataTables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="plugins/tables/responsive-tables/responsive-tables.js"></script><!-- Make tables responsive -->
        <script type="text/javascript" src="js/datatable.js"></script><!-- Init plugins only for page -->

        <!-- fancybox -->
        <link href="plugins/gallery/fancybox/jquery.fancybox.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="plugins/gallery/fancybox/jquery.fancybox.js"></script>
        <link href="plugins/misc/pnotify/jquery.pnotify.default.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="plugins/misc/pnotify/jquery.pnotify.min.js"></script>
        <script type="text/javascript" src="plugins/forms/format-curancy/jquery.formatCurrency-1.4.0.min.js"></script>
        <script type="text/javascript" src="plugins/forms/jedit/jquery.jeditable.js"></script>
        <script type="text/javascript">
            $(function() {
                if ($('table').hasClass('dynamicTable_task')) {

                    var oTable = $('.dynamicTable_task').dataTable({"sPaginationType": "full_numbers"});

                    /* Apply the jEditable handlers to the table */
                    oTable.$("td:not(:.nonedit)").editable('../ajx/ajax_jeditable.php', {
                        "callback": function(sValue, y) {
                            var arr = jQuery.parseJSON(sValue);
                            if (arr.type == 'err') {
                                var aPos = oTable.fnGetPosition(this);
                                alert(arr.msg);
                                oTable.fnUpdate(arr.value, aPos[0], aPos[1]);
                            } else {
                                var aPos = oTable.fnGetPosition(this);
                                oTable.fnUpdate(arr.value, aPos[0], aPos[1]);
                            }

                        },
                        "submitdata": function(value, settings) {
                            //    alert(this.parentNode.getAttribute('id'));
                            return {
                                "row_id": this.parentNode.getAttribute('id'),
                                "type": this.getAttribute('class'),
                                "main": 'email_edit',
                                //    "column": oTable.fnGetPosition(this)[2]
                            };
                        },
                        "height": "20px",
                        "width": "90%"
                    });

                }

                $(".popup_img").fancybox();

                $(".popup2").fancybox({
                    'hideOnContentClick': true,
                    'type': 'iframe',
                    'padding': 10,
                    'onComplete': function() {
                        $('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
                            $('#fancybox-content').height($(this).contents().find('body').height() + 30);
                        });
                    }
                });

                $(".popup").fancybox({
                    'width': '75%',
                    'height': '85%',
                    'autoScale': 'false',
                    'transitionIn': 'none',
                    'transitionOut': 'none',
                    'type': 'iframe'
                });


            });</script>

        <?= (isset($del_msg)) ? CommonBase::decrypt($del_msg) : "" ?>
    </head>

    <body>
        <!-- loading animation -->
        <div id="qLoverlay"></div>
        <div   id="qLbar"></div>
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

                        <h3>Create Task for User(s)</h3>                    

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
                            <li class="active">Create Task</li>
                        </ul>

                    </div><!-- End .heading-->

                    <!-- Build page from here: -->
                    <div class="row-fluid">

                        <div class="span12">

                            <div class="box">

                                <div class="title">

                                    <h4>
                                        <span class="icon16 icomoon-icon-equalizer-2"></span>
                                        <span>Property Filters</span>
                                    </h4>
                                    <a class="minimize" href="#" style="display: none;">Minimize</a>
                                </div>
                                <div class="content">

                                    <?= (isset($email_msg)) ? $email_msg : "" ?>
                                   

                                    <div class="row-fluid">
                                        <form id="frmOptions" method="post" class=" form-inline span12" style="margin: 0px;">

                                            <div class="row-fluid">

                                                <div id="formCenter" class="span3">
                                                    <div class="control-group">
                                                        <label for="select2" class="control-label">Name</label>
                                                        <div class="controls ">
                                                            <input name="name" type="text" class="textbox" id="name" value="<?= $name ?>" />
                                                        </div>      
                                                    </div>    
                                                </div>
                                                <div id="formCenter" class="span3">
                                                    <div class="control-group">
                                                        <label for="select2" class="control-label">Email</label>
                                                        <div class="controls ">
                                                            <input type="text" name="email" id="fileField" class="textbox" value="<?= $email ?>" /> 
                                                        </div>      
                                                    </div>    
                                                </div>

                                                <div id="formCenter" class="span3 ">
                                                    <div class="control-group">
                                                        <label for="select2" class="control-label"></label>
                                                        <div class="controls padingT10" style="margin-top: 10px;">
                                                            <button type="submit" class="btn" name="addemails">Add Email</button>
                                                            <button type="button" onclick="window.open(window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1), '_self');"  class="btn btn-danger" >Reset</button>
                                                        </div>      
                                                    </div>    
                                                </div>
                                            </div>

                                        </form>
                                    </div>



                                </div>

                            </div><!-- End .box -->

                        </div><!-- End .span12 -->

                    </div>

                    <div class="row-fluid">

                        <div class="span12">

                            <div class="box gradient">
                                <div class="title">
                                    <h4>
                                        <span>User List</span>
                                    </h4>

                                </div>


                                <div class="content noPad clearfix">
                                    <table cellpadding="0" cellspacing="0" border="0" class="responsive dynamicTable_task display table table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Ref #</th>
                                                <th>Name</th>
                                                <th>Email</th>                                              
                                                 
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?
                                            $task_list = Emails::getallemails(3);

                                            while ($row = $task_list->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                <tr  id="<?= CommonBase::encrypt($row['Id']) ?>" >
                                                    <td class="nonedit"><?= $row['Id'] ?></td>
                                                    <td class="name"><?= $row['name'] ?></td>
                                                    <td class="email"><?= $row['email'] ?></td>
                                                  
                                                    <td  class="nonedit">
                                                        <form method="POST" action="" style="margin: 0px;"  class="delfrm" id="delfrm<?= $row['Id'] ?>">
                                                            <input type="hidden" value="<?= CommonBase::encrypt($row['Id']) ?>" name="row_id" />
                                                            <button class="btn btn-danger" type="submit" name="del_mail"   >Delete</button>
                                                        </form>

                                                    </td>
                                                </tr>
                                            <? }
                                            ?>  
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Ref #</th>
                                                <th>Name</th>
                                                <th>Email</th>                                              
                                              
                                                <th>Delete</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div><!-- End .box -->

                        </div><!-- End .span12 -->

                    </div><!-- End .row-fluid -->

                </div><!-- End .span12 -->

            </div>

            <!-- End .row-fluid -->
            <!--End page -->

        </div><!-- End contentwrapper -->
        </div><!-- End #content -->

        </div><!-- End #wrapper -->

        <? include_once './inc/comman_js.php'; ?>


    </body>
</html>
