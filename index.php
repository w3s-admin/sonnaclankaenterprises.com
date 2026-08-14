<?
require 'cpad/vehicleController.php';
?>
<!DOCTYPE html>
<html lang="zxx" class="theme-dark">

<head>
    <?php
    $pageTitle = "Sonnac Lanka Enterprises - Your Trusted Japanese Car Dealer in Japan";
    include_once('./includes/head.php'); ?>
</head>

<body>

    <?php // include_once('./includes/loader.php');
    ?>


    <!-- Header Section Start -->
    <?php include_once('./includes/navi.php'); ?>
    <!-- Header Section End -->

    <!-- Hero Section Start -->
    <?php include_once('./includes/slider.php'); ?>
    <!-- Hero Section End -->

    <!-- Filter Product Section Start -->
    <?php include_once('./includes/search.php'); ?>
    <!-- Filter Product Section End -->

    <!-- Product Section Start -->
    <?php include_once('./includes/product.php'); ?>
    <!-- Product Section End -->

    <!-- Why Choose Us Section Start -->
    <?php include_once('./includes/why_choose_us.php'); ?>
    <!-- Why Choose Us Section End -->

    <!-- Call To Action Section Start -->
    <?php include_once('./includes/call_to_action.php'); ?>
    <!-- Call To Action Section End -->

    <!-- Category Section Start -->
    <?php // include_once('./includes/category_section.php');
    ?>
    <!-- Category Section End -->



    <!-- Why Choose us Section Start -->

    <!-- Why Choose us Section End -->

    <!-- Testimonial Section Start -->
    <?php include_once('./includes/testimonial.php'); ?>
    <!-- Testimonial Section End -->

    <!-- Blog Section Start -->
    <?php  //include_once('./includes/blog.php');
    ?>
    <!-- Blog Section End -->

    <!-- App Section Start -->
    <?php // include_once('./includes/app.php');
    ?>
    <!-- App Section End -->

    <!-- Footer Section Start -->
    <?php include_once('./includes/footer.php'); ?>
    <!-- Footer Section End -->

    <?php include_once('./includes/script.php'); ?>
    <script type="text/javascript">
        $(function() {

            $("#Make").change(function() {
                $.post("ajx/ajax_select_contraller.php", {
                        id: $(this).val(),
                        data: 'main',
                        search: 'search'
                    },
                    function(data) {
                        $('#Model').find('option').remove();
                        $("#Model").append('<option value="" class="any">Select Car Model</option>' + data);
                    }
                );

            });


        });
    </script>
</body>

</html>