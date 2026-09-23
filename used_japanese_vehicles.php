<?
require 'cpad/vehicleController.php';
$keyword = $keyword ?? null;
$Make = $Make ?? null;
$Model = $Model ?? null;
$BodyType = $BodyType ?? null;
$Transmission = $Transmission ?? null;
$columName = $columName ?? null;
$style = $style ?? "";
?>
<!DOCTYPE html>
<html lang="zxx" class="theme-dark">

<head>
    <?php
    $pageTitle = "Used Vehicles - Sonnac Lanka Enterprises";
    include_once('./includes/head.php'); ?>

</head>

<body>

    <?php // include_once('./includes/loader.php');
    ?>



    <!-- Header Section Start -->
    <?php include_once('./includes/navi.php'); ?>
    <!-- Header Section End -->

    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap bg-f br-1">
        <div class="container">
            <div class="breadcrumb-title" data-motion="reveal">
                <span class="brand-eyebrow">Our Inventory</span>
                <h2>Vehicle Stock</h2>
                <ul class="breadcrumb-menu list-style">
                    <li><a href="index.php">Home </a></li>
                    <li>Our Stock</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <style>
        /* ==========================================================================
           Sonnac Lanka Enterprises — stock listing page, rebuilt.
           Filter sidebar restyled with the includes/search.php dark-field pattern;
           result cards rebuilt as the exact .vehicle-card component from
           includes/product.php so every vehicle card sitewide is visually identical.
           ========================================================================== */
        .listing-section {
            padding: var(--space-10) 0 var(--space-12);
            background: var(--surface-0);
        }

        /* ---- Filter sidebar ---- */
        .filter-card {
            background: var(--surface-2);
            border: 1px solid var(--surface-border);
            border-radius: var(--radius-lg);
            padding: var(--space-6);
            box-shadow: var(--shadow-card);
        }
        .filter-card h3 {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-family: var(--font-display);
            font-size: var(--text-lg);
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 var(--space-5);
            padding-bottom: var(--space-4);
            border-bottom: 1px solid var(--surface-border);
        }
        .filter-card h3 i {
            color: var(--brand-gold);
        }
        .filter-card .form-group {
            margin-bottom: var(--space-4);
        }
        .filter-card label {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
            font-size: var(--text-xs);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-weight: 700;
            margin-bottom: var(--space-2);
        }
        .filter-card label i {
            color: var(--brand-gold);
        }
        .filter-card select {
            width: 100%;
            background-color: var(--surface-1) !important;
            border: 1px solid var(--surface-border) !important;
            border-radius: var(--radius-md) !important;
            color: var(--text-primary) !important;
            height: 50px;
            padding: 0 40px 0 16px;
            font-family: var(--font-body);
            font-size: var(--text-base);
            transition: border-color var(--duration-fast) var(--ease-out);
        }
        .filter-card select:hover,
        .filter-card select:focus {
            border-color: var(--brand-gold) !important;
        }
        .filter-card select option {
            background-color: var(--surface-1);
            color: var(--text-primary);
        }
        .filter-card .filter-submit-btn {
            width: 100%;
            margin-top: var(--space-2);
        }

        /* ---- Results toolbar ---- */
        .listing-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: var(--space-4);
            margin-bottom: var(--space-6);
            flex-wrap: wrap;
        }
        .listing-toolbar p {
            margin: 0;
            color: var(--text-secondary);
            font-size: var(--text-sm);
        }
        .listing-toolbar p b {
            color: var(--text-primary);
        }

        /* ---- Result grid — exact .vehicle-card component from includes/product.php ---- */
        .listing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: var(--space-5);
        }
        .vehicle-card {
            background: var(--surface-2);
            border: 1px solid var(--surface-border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            text-decoration: none;
            display: block;
            transition: transform var(--duration-base) var(--ease-out),
                        box-shadow var(--duration-base) var(--ease-out),
                        border-color var(--duration-base) var(--ease-out);
        }
        .vehicle-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-card-hover);
            border-color: rgba(184, 32, 46, 0.35);
        }
        .vehicle-card .vc-media {
            position: relative;
            aspect-ratio: 4 / 3;
            background: var(--surface-1);
            overflow: hidden;
        }
        .vehicle-card .vc-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--duration-slow) var(--ease-out);
        }
        .vehicle-card:hover .vc-media img {
            transform: scale(1.07);
        }
        .vehicle-card .vc-media::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(10, 14, 19, 0) 55%, rgba(10, 14, 19, 0.85) 100%);
        }
        .vehicle-card .vc-price {
            position: absolute;
            left: var(--space-3);
            bottom: var(--space-3);
            z-index: 1;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: var(--text-lg);
            color: var(--text-primary);
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.6);
        }
        .vehicle-card .vc-body {
            padding: var(--space-4) var(--space-4) var(--space-5);
        }
        .vehicle-card .vc-title {
            font-family: var(--font-body);
            font-weight: 600;
            font-size: var(--text-base);
            color: var(--text-primary);
            margin: 0 0 var(--space-3);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: color var(--duration-fast) var(--ease-out);
        }
        .vehicle-card:hover .vc-title {
            color: var(--brand-gold);
        }
        .vehicle-card .vc-meta {
            display: flex;
            align-items: center;
            gap: var(--space-4);
            padding-top: var(--space-3);
            border-top: 1px solid var(--surface-border);
        }
        .vehicle-card .vc-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: var(--text-xs);
            color: var(--text-muted);
            font-family: var(--font-body);
        }
        .vehicle-card .vc-meta i {
            color: var(--brand-silver);
            font-size: var(--text-sm);
        }

        /* ---- Empty state ---- */
        .listing-empty {
            background: var(--surface-2);
            border: 1px solid var(--surface-border);
            border-radius: var(--radius-lg);
            padding: var(--space-10) var(--space-6);
            text-align: center;
        }
        .listing-empty i {
            font-size: 2.5rem;
            color: var(--brand-red);
            margin-bottom: var(--space-4);
            display: inline-block;
        }
        .listing-empty h4 {
            font-family: var(--font-display);
            color: var(--text-primary);
            margin: 0 0 var(--space-2);
        }
        .listing-empty p {
            color: var(--text-secondary);
            margin: 0;
        }

        /* ---- Pagination ---- */
        .page-nav {
            display: flex;
            flex-wrap: wrap;
            gap: var(--space-2);
            list-style: none;
            padding: var(--space-8) 0 0;
            margin: 0;
        }
        .page-nav li a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 42px;
            height: 42px;
            padding: 0 var(--space-3);
            border-radius: var(--radius-md);
            background: var(--surface-2);
            border: 1px solid var(--surface-border);
            color: var(--text-secondary);
            font-family: var(--font-body);
            font-weight: 600;
            font-size: var(--text-sm);
            text-decoration: none;
            transition: all var(--duration-fast) var(--ease-out);
        }
        .page-nav li a:hover {
            border-color: var(--brand-gold);
            color: var(--brand-gold);
        }
        .page-nav li a.current,
        .page-nav li a.active {
            background: var(--brand-red);
            border-color: var(--brand-red);
            color: #fff;
        }
        .page-nav li a.inactive {
            opacity: 0.4;
            pointer-events: none;
        }
    </style>

    <!-- Listing Section Start -->
    <div class="listing-section">
        <div class="container">
            <div class="row">
                <div class="col-xxl-3 col-xl-4 col-lg-4 order-xl-1 order-lg-1 order-md-2 order-2">
                    <div class="filter-card" data-motion="reveal">
                        <h3><i class="ri-filter-3-line"></i> Search Filters</h3>
                        <form action="#" class="filter-search">
                            <div class="form-group">
                                <label for="Make"><i class="ri-car-line"></i> Make</label>
                                <?php echo
                                CommonBase::createSelectSearch(
                                    ${'Make'},
                                    $name = 'Make',
                                    null,
                                    $class = "",
                                    "",
                                    $q = "SELECT m.Id, m.name
                                    FROM make m
                                    WHERE m.status = 1
                                    AND EXISTS (
                                      SELECT 1
                                      FROM advert a
                                      WHERE a.fk_make = m.Id
                                      AND a.status = 1 AND a.flow = 1
                                    )
                                    ORDER BY m.Id ASC",
                                    $columName,
                                    "Any Make",
                                    $style
                                );
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="Model"><i class="ri-price-tag-3-line"></i> Model</label>
                                <!-- Shows every model currently in stock upfront (same as Make/Body
                                     Type/Transmission below), scoped down further by the #Make change
                                     handler once a specific Make is picked - previously this stayed on
                                     just "Any Model" with nothing else until Make was chosen first,
                                     which looked broken/empty next to the other filters. -->
                                <?php echo
                                    CommonBase::createSelectSearch(
                                        ${'Model'},
                                        $name = 'Model',
                                        null,
                                        $class = "",
                                        "",
                                        $q = "SELECT mo.Id, mo.name
                                    FROM model mo
                                    WHERE mo.status = 1
                                    AND EXISTS (
                                      SELECT 1
                                      FROM advert a
                                      WHERE a.fk_model = mo.Id
                                      AND a.status = 1 AND a.flow = 1
                                    )
                                    ORDER BY mo.Id ASC",
                                        $columName,
                                        "Any Model",
                                        $style
                                    ); ?>
                            </div>
                            <div class="form-group">
                                <label for="BodyType"><i class="ri-car-washing-line"></i> Body Type</label>
                                <?php echo
                                CommonBase::createSelectSearch(
                                    ${'BodyType'},
                                    $name = 'BodyType',
                                    null,
                                    $class = " ",
                                    "",
                                    $q = "SELECT bt.Id, bt.name
                                    FROM body_type bt
                                    WHERE bt.status = 1
                                    AND EXISTS (
                                      SELECT 1
                                      FROM advert a
                                      WHERE a.fk_body_type = bt.Id
                                        AND a.status = 1 AND a.flow = 1
                                    )
                                    ORDER BY bt.Id ASC;",
                                    $columName,
                                    "Any Type",
                                    $style
                                );
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="Transmission"><i class="ri-settings-3-line"></i> Transmission</label>
                                <?=
                                CommonBase::createSelectSearch(
                                    ${'Transmission'},
                                    $name = 'Transmission',
                                    null,
                                    $class = "",
                                    "",
                                    $q = "SELECT t.Id, t.name
                                    FROM transmission t
                                    WHERE t.status = 1
                                    AND EXISTS (
                                      SELECT 1
                                      FROM advert a
                                      WHERE a.fk_transmission = t.Id
                                      AND a.status = 1 AND a.flow = 1
                                    )
                                    ORDER BY t.Id ASC;",
                                    $columName,
                                    "Any Transmission",
                                    $style
                                );
                                ?>
                            </div>
                            <button class="btn-brand btn-brand-primary filter-submit-btn"><i class="ri-search-line"></i> Search</button>
                        </form>
                    </div>
                </div>

                <div class="col-xxl-9 col-xl-8 col-lg-8 order-xl-2 order-lg-1 order-md-1 order-1">
                    <?
                    $returnArray = Vehicle::getAll_vehicle_search($_GET, true, false);
                    $svcount = Vehicle::getResultCountBySearch($returnArray['q_count'], $returnArray['v']);

                    if ($svcount > 0) {
                    ?>

                        <?
                        $cdb = new ControlPadDB();
                        $dbh = $cdb->dbh;
                        $stmt_c = $dbh->prepare($returnArray['q_count']);
                        $stmt_c->execute($returnArray['v']);
                        if ($row_c = $stmt_c->fetch(PDO::FETCH_ASSOC)) {
                            $count = $row_c['cnt'];
                        }

                        $num_rows = array('0' => intval($count));
                        $pages = new Paginator();
                        $pages->items_total = $num_rows[0];
                        $pages->mid_range = 9; // Number of pages to display. Must be odd and > 3
                        $pages->default_ipp = 6;
                        $pages->paginate();
                        $query = $returnArray['q'] . $pages->limit;
                        $stmt_res = $dbh->prepare($query);
                        $stmt_res->execute($returnArray['v']);
                        $startNumber = $pages->current_page * $pages->items_per_page - $pages->items_per_page + 1;
                        $endNumber = $startNumber + $pages->default_ipp - 1;
                        ?>

                        <div class="listing-toolbar" data-motion="reveal">
                            <p>Showing <b><?php echo $startNumber . '~' . $endNumber; ?></b> of <b><?php echo CommonBase::formatMoney($count, 0); ?></b> results</p>
                        </div>

                        <div class="listing-grid" data-motion-group>
                            <?
                            while ($row = $stmt_res->fetch(PDO::FETCH_ASSOC)) {
                                $vehicle = new FrontVehicle($row);
                            ?>
                                <a href="<?php echo $vehicle->url ?>" class="vehicle-card" data-motion="grid-item">
                                    <div class="vc-media">
                                        <img src="<?php echo $vehicle->mainImage ?>" alt="<?php echo $vehicle->title ?>" loading="lazy">
                                        <span class="vc-price"><?php echo $vehicle->price ?></span>
                                    </div>
                                    <div class="vc-body">
                                        <h3 class="vc-title"><?php echo $vehicle->getLimitTitle() ?></h3>
                                        <div class="vc-meta">
                                            <span><i class="ri-settings-3-line"></i> <?php echo $vehicle->transmission ?></span>
                                            <span><i class="ri-calendar-line"></i> <?php echo $vehicle->getYearOnly() ?></span>
                                            <span><i class="ri-road-map-line"></i> <?php echo $vehicle->mileage ?></span>
                                        </div>
                                    </div>
                                </a>
                            <?
                            }
                            ?>
                        </div>

                        <?
                        echo $pages->display_pages();
                        ?>

                    <? } else { ?>
                        <div class="listing-empty" data-motion="reveal">
                            <i class="ri-search-eye-line"></i>
                            <h4>No vehicles found</h4>
                            <p>Please adjust your filters and search again.</p>
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Listing Section End -->



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
