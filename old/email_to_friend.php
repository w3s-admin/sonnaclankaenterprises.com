<?
require_once 'cpad/vehicleController.php';
require_once 'cpad/emailController.php';

if (isset($_GET['vid'])) {

    $id = CommonBase::decrypt($_GET['vid']);

    if (is_numeric($id)) {
        $cid = $id;
    } else {
        echo CommonBase::closeWindow();
    }
}
$server = CommonBase::getServer();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Emil to friend</title>

        <!-- Plugin stylesheets -->
        <link rel="stylesheet" href="<?= $server ?>js/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= $server ?>js/bootstrap/css/bootstrap-responsive.min.css">
        <script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
        <script src="<?= $server ?>js/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="plugins/forms/validation-engine/jquery.validationEngine.js"></script>
        <link href="plugins/forms/validation-engine/css/validationEngine.jquery.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="plugins/forms/validation-engine/languages/jquery.validationEngine-en.js"></script>
        <script>
            function gototop(y) {
                $("html, body").animate({scrollTop: y}, "slow");
            }
        </script>
        <script type="text/javascript">
            $(function() {


                $("#friend-form").validationEngine();

            })
        </script>

    </head>
    <body>
        <div class="row-fluid">
            <div class="span12 ">
                <div style="">
                    <?= (isset($_GET['shop_save_msg'])) ?  CommonBase::decrypt($_GET['shop_save_msg'])  : "" ?>
                    <?= (isset($shop_save_msg) && !isset($_GET['shop_save_msg']) ) ? $shop_save_msg : "" ?>
                </div>
                <? if (!$close) { ?>
                    <form class="form-horizontal" id="friend-form" method="post" action="">
                        <div class="control-group">
                            <label class="control-label" for="inputEmail">Friend's Email</label>
                            <div class="controls">
                                <input type="text" id="inputEmail" name="femail" value="<?= ${'femail'} ?>" class="validate[required,custom[email]]" placeholder="Email">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputPassword">Your Name</label>
                            <div class="controls">
                                <input type="text" id="inputEmail" name="name" value="<?= ${'name'} ?>" placeholder="Name" class="validate[required]">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputPassword">Massage</label>
                            <div class="controls">
                                <textarea rows="3" name="msg" value="<?= ${'msg'} ?>"></textarea>
                            </div>
                        </div>
                        <div class="control-group">                         
                            <div class="controls">
                                <table width="200" border="0" cellspacing="0" cellpadding="0" style="">
                                    <tr>
                                        <td style="width: 150px;" width="150" rowspan="2"><img id="siimage" style="border: 1px solid #000; margin-right: 15px" src="securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left" width="200" /></td>
                                        <td style="width: 50px;" width="50"><object type="application/x-shockwave-flash" data="flash/securimage_play.swf?bgcol=#ffffff&amp;icon_file=./images/audio_icon.png&amp;audio_file=./securimage_play.php" height="32" width="32">
                                                <param name="movie" value="./securimage_play.swf?bgcol=#ffffff&amp;icon_file=./images/audio_icon.png&amp;audio_file=./securimage_play.php" />
                                            </object></td>
                                    </tr>
                                    <tr>
                                        <td> <a tabindex="-1" style="border-style: none;" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = './securimage_show.php?sid=' + Math.random();
                            this.blur();
                            return false"><img src="./images/refresh.png" alt="Reload Image" height="20" width="35" onclick="this.blur()" align="bottom" border="0" /></a></td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputPassword">Answer Above Image</label>
                            <div class="controls">
                                <input type="text" id="inputEmail" name="answer" value="<?= ${'answer'} ?>" class="validate[required,custom[number]]" placeholder="Answer">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <input type="hidden" id="" name="vid" value="<?= $_GET['vid'] ?>" placeholder="Name" class="validate[required]">
                                <button type="submit" name="Send_email_friend" class="btn">Send Email</button>
                            </div>
                        </div>
                    </form>
                <? } ?>
            </div>
        </div>
    </body>
</html>
