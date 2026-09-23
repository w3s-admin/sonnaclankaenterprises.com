<?
require 'cpad/vehicleController.php';

// Always reset $cid here rather than `?? null`: vehicleController.php's
// extract($_GET) can already have set $cid straight from a "?cid=..." query
// parameter, which would otherwise skip the decrypt()/is_numeric() check
// below entirely and let a crafted link fetch/display an arbitrary vehicle
// (or a non-numeric value that breaks the FrontVehicle lookup further down).
$cid = null;

if (isset($_GET['id'])) {
    $id = CommonBase::decrypt($_GET['id']);
    if (is_numeric($id)) {
        $cid = $id;
    }
}

$row = $cid !== null ? Vehicle::getvehicleByID($cid) : null;
if (!$row) {
    CommonBase::SendRedirect('used_japanese_vehicles.php');
}
$vehicle =  new FrontVehicle($row);


?>
<!DOCTYPE html>
<html lang="zxx" class="theme-dark">

<head>
    <?php
    $pageTitle = "Vehicle Details - " . $vehicle->getLimitTitle() . " | Sonnac Lanka Enterprises";
    include_once('./includes/head.php'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <style>
        /* ==========================================================================
           Sonnac Lanka Enterprises — vehicle detail page, rebuilt.
           Premium single-listing treatment: hero header with price + CTAs,
           large gallery image, icon+label spec sheet on .brand-card tiles,
           chip-style options list, and a sticky price/CTA + inquiry sidebar.
           ========================================================================== */
        .instagram-card i {
            color: black;
        }

        /* ---- Hero header ---- */
        .vd-hero {
            background: linear-gradient(180deg, var(--surface-1) 0%, var(--surface-0) 100%);
            border-bottom: 1px solid var(--surface-border);
            padding: var(--space-8) 0;
        }
        .vd-hero .vd-category {
            margin-bottom: var(--space-3);
        }
        .vd-hero h1 {
            font-family: var(--font-display);
            font-size: clamp(1.75rem, 3.5vw, var(--text-4xl));
            font-weight: 800;
            color: var(--text-primary);
            margin: 0 0 var(--space-5);
        }
        .vd-quickmeta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: var(--space-3) var(--space-6);
            margin-bottom: var(--space-6);
        }
        .vd-quickmeta .vd-price {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: var(--text-3xl);
            color: var(--brand-gold);
        }
        .vd-quickmeta span.vd-spec {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--text-secondary);
            font-size: var(--text-sm);
        }
        .vd-quickmeta span.vd-spec i {
            color: var(--brand-silver);
            font-size: var(--text-base);
        }
        .vd-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: var(--space-3);
        }

        /* ---- Main content ---- */
        .vd-details {
            padding: var(--space-10) 0 var(--space-12);
            background: var(--surface-0);
        }
        .vd-hero-image {
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 1px solid var(--surface-border);
            box-shadow: var(--shadow-card);
            margin-bottom: var(--space-8);
        }
        .vd-hero-image img {
            width: 100%;
            height: auto;
            max-height: 520px;
            object-fit: cover;
            display: block;
        }
        .vd-section-title {
            font-family: var(--font-display);
            font-size: var(--text-2xl);
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 var(--space-5);
        }
        .vd-description {
            color: var(--text-secondary);
            line-height: 1.8;
            margin-bottom: var(--space-8);
        }

        /* ---- Spec sheet grid ---- */
        .vd-spec-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: var(--space-4);
            margin-bottom: var(--space-10);
        }
        .vd-spec-tile {
            padding: var(--space-5);
            display: flex;
            align-items: flex-start;
            gap: var(--space-3);
        }
        .vd-spec-tile i {
            width: 42px;
            height: 42px;
            flex: 0 0 auto;
            border-radius: var(--radius-md);
            background: rgba(239, 193, 46, 0.12);
            color: var(--brand-gold);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: var(--text-lg);
        }
        .vd-spec-tile .vd-spec-label {
            display: block;
            font-size: var(--text-xs);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            margin-bottom: 4px;
        }
        .vd-spec-tile .vd-spec-value {
            display: block;
            font-family: var(--font-display);
            font-weight: 600;
            font-size: var(--text-base);
            color: var(--text-primary);
        }

        /* ---- Options chips ---- */
        .vd-options {
            display: flex;
            flex-wrap: wrap;
            gap: var(--space-2);
            list-style: none;
            margin: 0 0 var(--space-10);
            padding: 0;
        }
        .vd-options li {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--surface-2);
            border: 1px solid var(--surface-border);
            border-radius: var(--radius-full);
            padding: 8px 16px;
            font-size: var(--text-sm);
            color: var(--text-secondary);
        }
        .vd-options li i {
            color: var(--brand-gold);
        }

        /* ---- Location ---- */
        .vd-map {
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 1px solid var(--surface-border);
        }
        .vd-map iframe {
            width: 100%;
            height: 320px;
            border: 0;
            display: block;
        }
        .vd-location-text {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--text-secondary);
            margin-bottom: var(--space-4);
        }
        .vd-location-text i {
            color: var(--brand-red);
        }

        /* ---- Sidebar ---- */
        .vd-sidebar > * + * {
            margin-top: var(--space-6);
        }
        .vd-price-card {
            padding: var(--space-6);
            text-align: center;
        }
        .vd-price-card .vd-price-card-label {
            font-size: var(--text-xs);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            margin-bottom: var(--space-2);
        }
        .vd-price-card .vd-price-card-value {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: var(--text-3xl);
            color: var(--brand-gold);
            margin-bottom: var(--space-5);
        }
        .vd-price-card .btn-brand {
            width: 100%;
            margin-bottom: var(--space-3);
        }
        .vd-price-card .btn-brand:last-child {
            margin-bottom: 0;
        }

        .vd-gallery-card,
        .vd-contact-card {
            background: var(--surface-2);
            border: 1px solid var(--surface-border);
            border-radius: var(--radius-lg);
            padding: var(--space-6);
        }
        .vd-widget-title {
            font-family: var(--font-display);
            font-size: var(--text-lg);
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 var(--space-5);
            padding-bottom: var(--space-4);
            border-bottom: 1px solid var(--surface-border);
        }
        .vd-gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: var(--space-2);
        }
        .vd-gallery-grid a {
            position: relative;
            display: block;
            aspect-ratio: 1 / 1;
            border-radius: var(--radius-sm);
            overflow: hidden;
            border: 1px solid var(--surface-border);
        }
        .vd-gallery-grid img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--duration-base) var(--ease-out);
        }
        .vd-gallery-grid a:hover img {
            transform: scale(1.08);
        }
        .vd-gallery-grid a span {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(10, 14, 19, 0.45);
            color: #fff;
            opacity: 0;
            transition: opacity var(--duration-fast) var(--ease-out);
        }
        .vd-gallery-grid a:hover span {
            opacity: 1;
        }

        .vd-contact-card .form-group {
            margin-bottom: var(--space-4);
        }
        .vd-contact-card input,
        .vd-contact-card textarea {
            width: 100%;
            background-color: var(--surface-1);
            border: 1px solid var(--surface-border);
            border-radius: var(--radius-md);
            color: var(--text-primary);
            padding: 14px 16px;
            font-family: var(--font-body);
            font-size: var(--text-base);
            transition: border-color var(--duration-fast) var(--ease-out);
        }
        .vd-contact-card input:hover,
        .vd-contact-card input:focus,
        .vd-contact-card textarea:hover,
        .vd-contact-card textarea:focus {
            border-color: var(--brand-gold);
            outline: none;
        }
        .vd-contact-card textarea {
            resize: vertical;
        }
        .vd-contact-card .btn-brand {
            width: 100%;
        }
    </style>
</head>

<body>


    <!--Preloader starts-->

    <!--Preloader ends-->

    <!-- Theme Switcher Start -->

    <!-- Theme Switcher End -->

    <!-- Header Section Start -->
    <?php include_once('./includes/navi.php'); ?>
    <!-- Header Section End -->

    <!-- Listing Details Start -->
    <div class="vd-hero">
        <div class="container">
            <div class="row" data-motion="reveal">
                <div class="col-xl-8 col-lg-8">
                    <span class="badge-gold vd-category"><i class="ri-car-line"></i> <?php echo $vehicle->body; ?></span>
                    <h1><?php echo $vehicle->title; ?></h1>
                    <div class="vd-quickmeta">
                        <span class="vd-price"><?php echo $vehicle->price; ?></span>
                        <span class="vd-spec"><i class="ri-calendar-line"></i> <?php echo $vehicle->getYearOnly(); ?></span>
                        <span class="vd-spec"><i class="ri-settings-3-line"></i> <?php echo $vehicle->transmission; ?></span>
                        <span class="vd-spec"><i class="ri-road-map-line"></i> <?php echo $vehicle->mileage; ?></span>
                        <span class="vd-spec"><i class="ri-gas-station-line"></i> <?php echo $vehicle->fuel; ?></span>
                    </div>
                    <div class="vd-hero-actions">
                        <a href="tel:+94112339311" class="btn-brand btn-brand-primary"><i class="ri-phone-fill"></i> +94 11 233 9311</a>
                        <a href="https://wa.me/94777366463?text=Hello%20Sonnac%20Lanka%20Enterprises%2C%20I'm%20interested%20in%20the%20<?php echo urlencode($vehicle->getLimitTitle()); ?>" target="_blank" class="btn-brand btn-brand-outline"><i class="ri-whatsapp-line"></i> WhatsApp Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="vd-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="vd-hero-image" data-motion="reveal">
                        <img src="<?php echo    $vehicle->images[0]['main']  ?>" alt="<?php echo $vehicle->title; ?>">
                    </div>

                    <h2 class="vd-section-title">Description</h2>
                    <div class="vd-description"><?php echo  $vehicle->description ?></div>

                    <h2 class="vd-section-title">Specification</h2>
                    <div class="vd-spec-grid" data-motion-group>
                        <div class="brand-card vd-spec-tile" data-motion="grid-item">
                            <i class="ri-palette-line"></i>
                            <div>
                                <span class="vd-spec-label">Color</span>
                                <span class="vd-spec-value"><?php echo  $vehicle->color; ?></span>
                            </div>
                        </div>
                        <div class="brand-card vd-spec-tile" data-motion="grid-item">
                            <i class="ri-car-line"></i>
                            <div>
                                <span class="vd-spec-label">Make &amp; Model</span>
                                <span class="vd-spec-value"><?php echo  $vehicle->title; ?></span>
                            </div>
                        </div>
                        <div class="brand-card vd-spec-tile" data-motion="grid-item">
                            <i class="ri-calendar-line"></i>
                            <div>
                                <span class="vd-spec-label">Year</span>
                                <span class="vd-spec-value"><?php echo  $vehicle->year; ?></span>
                            </div>
                        </div>
                        <div class="brand-card vd-spec-tile" data-motion="grid-item">
                            <i class="ri-speed-up-line"></i>
                            <div>
                                <span class="vd-spec-label">Engine</span>
                                <span class="vd-spec-value"><?php echo  $vehicle->cc; ?></span>
                            </div>
                        </div>
                        <div class="brand-card vd-spec-tile" data-motion="grid-item">
                            <i class="ri-road-map-line"></i>
                            <div>
                                <span class="vd-spec-label">Mileage</span>
                                <span class="vd-spec-value"><?php echo  $vehicle->mileage; ?></span>
                            </div>
                        </div>
                        <div class="brand-card vd-spec-tile" data-motion="grid-item">
                            <i class="ri-settings-3-line"></i>
                            <div>
                                <span class="vd-spec-label">Transmission</span>
                                <span class="vd-spec-value"><?php echo  $vehicle->transmission; ?></span>
                            </div>
                        </div>
                        <div class="brand-card vd-spec-tile" data-motion="grid-item">
                            <i class="ri-gas-station-line"></i>
                            <div>
                                <span class="vd-spec-label">Fuel Type</span>
                                <span class="vd-spec-value"><?php echo  $vehicle->fuel; ?></span>
                            </div>
                        </div>
                        <div class="brand-card vd-spec-tile" data-motion="grid-item">
                            <i class="ri-car-washing-line"></i>
                            <div>
                                <span class="vd-spec-label">Body Type</span>
                                <span class="vd-spec-value"><?php echo  $vehicle->body; ?></span>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($vehicle->options)): ?>
                        <h2 class="vd-section-title">Vehicle Options</h2>
                        <ul class="vd-options">
                            <?php foreach ($vehicle->options as $key => $value) : ?>
                                <li><i class="ri-checkbox-circle-fill"></i> <?php echo $value; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <h2 class="vd-section-title">Location</h2>
                    <div class="vd-location-text"><i class="ri-map-pin-line"></i> No 25, 11/6, Galle Road, Colombo 06, Sri Lanka</div>
                    <div class="vd-map">
                        <iframe src="https://www.google.com/maps?q=No+25,+11%2F6,+Galle+Road,+Colombo+06,+Sri+Lanka&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="vd-sidebar">
                        <div class="brand-card vd-price-card" data-motion="reveal">
                            <div class="vd-price-card-label">Price</div>
                            <div class="vd-price-card-value"><?php echo  $vehicle->price; ?></div>
                            <a href="tel:+94112339311" class="btn-brand btn-brand-primary"><i class="ri-phone-fill"></i> Call Now</a>
                            <a href="https://wa.me/94777366463?text=Hello%20Sonnac%20Lanka%20Enterprises%2C%20I'm%20interested%20in%20the%20<?php echo urlencode($vehicle->getLimitTitle()); ?>" target="_blank" class="btn-brand btn-brand-outline"><i class="ri-whatsapp-line"></i> Chat on WhatsApp</a>
                        </div>

                        <div class="vd-gallery-card" data-motion="reveal">
                            <h3 class="vd-widget-title">Image Gallery</h3>
                            <div class="vd-gallery-grid">

                                <?php
                                foreach ($vehicle->images as $key => $value) {
                                    echo "<a class='instagram-card' href='$value[main]' target='blank'  data-fancybox='gallery' >
                                    <img src='$value[main]' alt='" . $vehicle->title . "'>
                                    <span><i class='fas fa-search'></i></span>
                                </a>";
                                } ?>

                            </div>
                        </div>
                        <div class="vd-contact-card" data-motion="reveal">
                            <h3 class="vd-widget-title">Enquire About This Vehicle</h3>
                            <form id="inquiryForm">
                                <input type="hidden" name="vid" value="<?= htmlspecialchars($_GET['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                <!-- Honeypot: real visitors never see or fill this; a bot that fills every field it finds gets silently ignored server-side. -->
                                <div style="position:absolute; left:-9999px; top:-9999px;" aria-hidden="true">
                                    <label for="inquiryGridCheck">Leave this field empty</label>
                                    <input type="text" name="gridCheck" id="inquiryGridCheck" tabindex="-1" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Name" id="inquiryName" required data-error="Please enter your name">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" id="inquiryEmail" required placeholder="Email" data-error="Please enter your email">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="phone" id="inquiryPhone" placeholder="Phone (optional)">
                                </div>
                                <div class="form-group v1">
                                    <textarea name="message" id="inquiryMessage" placeholder="Your Messages.." cols="30" rows="6" required data-error="Please enter your message"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <button type="submit" class="btn-brand btn-brand-primary">Send Enquiry</button>
                                <br><br>
                                <div id="inquiryMsgSubmit" class="h3 text-center hidden  "></div>
                                <div class="clearfix"></div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Listing Details End -->





    <!-- Footer Section Start -->
    <?php include_once('./includes/footer.php'); ?>

    <!-- Footer Section End -->

    <?php include_once('./includes/script.php'); ?>
    <script src="assets/js/inquiry-form-script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        $('[data-fancybox="gallery"]').fancybox({
            // Options will go here
        });
    </script>

</body>

</html>
