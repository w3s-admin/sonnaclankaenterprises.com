<?
if (!class_exists("Customer"))
//  require_once 'cpad/customerController.php';
    $cus_id = true
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>



        <script type="text/javascript" src="js/jquery.blockUI.js"></script>   
        <script>

            $(document).ready(function() {
<? if (!is_numeric($cus_id)) { ?>
                    $.blockUI({
                        message: $('#loginDIV'),
                        css: {
                            border: 'none',
                            padding: '15px',
                            backgroundColor: '#000',
                            '-webkit-border-radius': '10px',
                            '-moz-border-radius': '10px',
                            opacity: .9,
                            color: '#fff',
                            top: ($(window).height() - 400) / 2 + 'px',
                            left: ($(window).width() - 400) / 2 + 'px',
                            width: '400px'
                        }
                    });
    <?
} else {
    
}
?>
            });

        </script>
    </head>

<? if (preg_match('/MSIE/i', $u_agent)) { ?>

    <? } else { ?>

    <? } ?>
    <style type="text/css">
        #fixedBanner {
            position: fixed; /* Obviously.. */ 
            top: 10px; 
            left: 0; 
            padding: 3px; 
            font-family: 

                Tahoma, Verdana, Arial; 

            width:190px;
            height:118px;
        } 
        #fixedBanner:hover 

        { 
            position: fixed; /* Obviously.. */ 
            top: 10px; 
            left: 0; 
            padding: 3px; 
            font-family: 

                Tahoma, Verdana, Arial; 

            width:190px;
            height:118px;
        }
    </style>
    <body style="margin: 0px; padding: 0px;">
        <div>
            <div id="header">
                <div class="wrapper">
                    <a href="<?= $server ?>index.php"><img id="logo" style="height: 80px; " src="img/logo.png" alt="Nova" /></a>
                    <!-- search -->
                    <div class="top-search">
                       
                    </div>
                    <!-- ENDS search -->
                </div>				
            </div>

        </div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td style="background:#FFF; height:600px" height="100%">
                    <iframe id="frm" width="100%" height="800" align="middle"  src="login_jpn.php" style="overflow:auto; margin: 0px;"></iframe>
                </td>
            </tr>

        </table>




    </body>

</html>

