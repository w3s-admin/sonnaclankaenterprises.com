<!DOCTYPE html>
<html lang="zxx" class="theme-dark">

<head>
    <?php
    $pageTitle = "About Sonnac Lanka Enterprises - Trusted Quality Vehicle Exporter Since 2003";
    $sleYearsInBusiness = date('Y') - 2003;
    include_once('./includes/head.php'); ?>
</head>

<body>

    <?php // include_once('./includes/loader.php');
    ?>

    <!-- Header Section Start -->
    <?php include_once('./includes/navi.php'); ?>
    <!-- Header Section End -->

    <style>
        /* ==========================================================================
           Sonnac Lanka Enterprises — About page, rebuilt (not re-themed).
           Replaces the old breadcrumb-header + Bootstrap card/progress-bar/
           owl-carousel layout with a dark, card-based, generously-spaced
           layout matching the homepage design system (brand.css tokens).
           ========================================================================== */

        /* ---- Page header (was .breadcrumb-wrap) ---- */
        .about-hero {
            position: relative;
            overflow: hidden;
            padding: 150px 0 80px;
            background: radial-gradient(110% 100% at 20% 10%, rgba(184, 32, 46, 0.16) 0%, transparent 55%),
                        linear-gradient(180deg, var(--surface-0) 0%, #060809 100%);
            border-bottom: 1px solid var(--surface-border);
        }
        .about-hero-shape {
            position: absolute;
            top: -25%;
            right: -6%;
            width: 520px;
            height: 520px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(18, 58, 92, 0.5) 0%, rgba(18, 58, 92, 0) 70%);
            pointer-events: none;
            z-index: 0;
        }
        .about-hero .container { position: relative; z-index: 1; }
        .about-crumbs {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            list-style: none;
            margin: 0 0 var(--space-4);
            padding: 0;
            font-family: var(--font-body);
            font-size: var(--text-sm);
            color: var(--text-muted);
        }
        .about-crumbs a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color var(--duration-fast) var(--ease-out);
        }
        .about-crumbs a:hover { color: var(--brand-gold); }
        .about-crumbs i { font-size: var(--text-base); }
        .about-hero h1 {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: clamp(2.1rem, 4.2vw, 3.25rem);
            line-height: 1.1;
            letter-spacing: -0.02em;
            color: var(--text-primary);
            margin: var(--space-3) 0 0;
            max-width: 720px;
        }

        /* ---- Story section (was .about-wrap / bootstrap row) ---- */
        .about-story {
            padding: var(--space-12) 0;
            background: var(--surface-0);
        }
        .about-story-grid {
            display: grid;
            grid-template-columns: minmax(0, 0.9fr) minmax(0, 1.1fr);
            gap: var(--space-10);
            align-items: center;
        }
        @media (max-width: 991px) {
            .about-story-grid { grid-template-columns: 1fr; }
        }

        .about-gallery {
            position: relative;
            min-height: 420px;
        }
        .about-gallery-shape {
            position: absolute;
            top: -6%;
            left: -8%;
            width: 90%;
            opacity: 0.5;
            z-index: 0;
        }
        .about-gallery-img {
            position: absolute;
            border-radius: var(--radius-lg);
            border: 1px solid var(--surface-border);
            box-shadow: var(--shadow-card);
            object-fit: cover;
        }
        .about-gallery-img-1 {
            top: 0;
            left: 6%;
            width: 72%;
            height: 380px;
            z-index: 1;
        }
        .about-gallery-img-2 {
            bottom: -4%;
            right: 0;
            width: 46%;
            height: 220px;
            z-index: 2;
            box-shadow: var(--shadow-card-hover);
        }
        .about-gallery-badge {
            position: absolute;
            left: -2%;
            bottom: 8%;
            z-index: 3;
            display: flex;
            align-items: center;
            gap: var(--space-3);
            background: var(--surface-2);
            border: 1px solid var(--surface-border);
            border-radius: var(--radius-lg);
            padding: var(--space-4) var(--space-5);
            box-shadow: var(--shadow-card-hover);
        }
        .about-gallery-badge i {
            font-size: 28px;
            color: var(--brand-gold);
        }
        .about-gallery-badge b {
            display: block;
            font-family: var(--font-display);
            font-size: var(--text-2xl);
            font-weight: 800;
            color: var(--text-primary);
            line-height: 1;
        }
        .about-gallery-badge span {
            font-size: var(--text-xs);
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        @media (max-width: 560px) {
            .about-gallery { min-height: 320px; }
            .about-gallery-img-1 { height: 280px; }
            .about-gallery-img-2 { height: 160px; }
        }

        .about-copy p {
            font-family: var(--font-body);
            font-size: var(--text-base);
            line-height: 1.75;
            color: var(--text-secondary);
            margin: 0 0 var(--space-4);
        }
        .about-copy h2 {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: clamp(1.6rem, 2.6vw, var(--text-4xl));
            color: var(--text-primary);
            margin: var(--space-2) 0 var(--space-5);
            line-height: 1.2;
        }

        .about-feature-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--space-4);
            margin-top: var(--space-6);
        }
        @media (max-width: 480px) { .about-feature-list { grid-template-columns: 1fr; } }
        .about-feature-item {
            display: flex;
            align-items: flex-start;
            gap: var(--space-3);
            padding: var(--space-4);
            background: var(--surface-2);
            border: 1px solid var(--surface-border);
            border-radius: var(--radius-md);
            transition: border-color var(--duration-base) var(--ease-out), transform var(--duration-base) var(--ease-out);
        }
        .about-feature-item:hover {
            transform: translateY(-4px);
            border-color: rgba(184, 32, 46, 0.35);
        }
        .about-feature-item i {
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-md);
            background: rgba(184, 32, 46, 0.12);
            color: var(--brand-red);
            font-size: var(--text-lg);
        }
        .about-feature-item h4 {
            font-family: var(--font-display);
            font-size: var(--text-sm);
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 2px;
        }
        .about-feature-item p {
            font-family: var(--font-body);
            font-size: var(--text-xs);
            color: var(--text-muted);
            margin: 0;
            line-height: 1.5;
        }

        /* ---- Quick facts strip (was hardcoded old-brand footer contact info) ---- */
        .about-quick-facts {
            padding: var(--space-8) 0;
            background: var(--surface-1);
            border-top: 1px solid var(--surface-border);
            border-bottom: 1px solid var(--surface-border);
        }
        .qf-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: var(--space-5);
        }
        @media (max-width: 860px) { .qf-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 480px) { .qf-grid { grid-template-columns: 1fr; } }
        .qf-item {
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }
        .qf-item i {
            flex-shrink: 0;
            width: 46px;
            height: 46px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-full);
            background: var(--surface-2);
            border: 1px solid var(--surface-border);
            color: var(--brand-gold);
            font-size: var(--text-lg);
        }
        .qf-item h5 {
            font-family: var(--font-display);
            font-size: var(--text-xs);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin: 0 0 2px;
        }
        .qf-item a,
        .qf-item p {
            font-family: var(--font-body);
            font-size: var(--text-sm);
            color: var(--text-primary);
            margin: 0;
            text-decoration: none;
        }
        .qf-item a:hover { color: var(--brand-gold); }

        /* ---- Stats / counter section (was .counter-wrap) ---- */
        .about-stats {
            padding: var(--space-12) 0;
            background: var(--surface-0);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: var(--space-5);
        }
        @media (max-width: 860px) { .stats-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 480px) { .stats-grid { grid-template-columns: 1fr; } }
        .stat-card {
            text-align: center;
            padding: var(--space-6) var(--space-4);
        }
        .stat-card i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            border-radius: var(--radius-md);
            background: rgba(239, 193, 46, 0.12);
            color: var(--brand-gold);
            font-size: 26px;
            margin-bottom: var(--space-4);
        }
        .stat-card .stat-num {
            display: block;
            font-family: var(--font-display);
            font-weight: 800;
            font-size: var(--text-3xl);
            color: var(--text-primary);
            line-height: 1;
        }
        .stat-card .stat-label {
            display: block;
            margin-top: var(--space-2);
            font-family: var(--font-body);
            font-size: var(--text-sm);
            color: var(--text-secondary);
        }

        /* ---- Testimonials (was owl-carousel .testimonial-wrap) ---- */
        .about-testimonials {
            padding: var(--space-12) 0;
            background: var(--surface-1);
            border-top: 1px solid var(--surface-border);
        }
        .about-testi-head {
            max-width: 640px;
            margin: 0 auto var(--space-8);
            text-align: center;
        }
        .about-testi-head h2 {
            font-family: var(--font-display);
            font-size: clamp(1.75rem, 3vw, var(--text-4xl));
            font-weight: 800;
            color: var(--text-primary);
            margin: var(--space-2) 0 0;
        }
        .about-testi-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: var(--space-5);
        }
        @media (max-width: 991px) { .about-testi-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 700px) { .about-testi-grid { grid-template-columns: 1fr; } }
        .at-card {
            padding: var(--space-5);
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
        }
        .at-card .at-stars {
            color: var(--brand-gold);
            font-size: var(--text-sm);
            letter-spacing: 2px;
        }
        .at-card .at-quote {
            font-family: var(--font-body);
            font-size: var(--text-base);
            line-height: 1.65;
            color: var(--text-secondary);
            margin: 0;
            flex-grow: 1;
        }
        .at-card .at-person {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding-top: var(--space-4);
            border-top: 1px solid var(--surface-border);
        }
        .at-card .at-avatar {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }
        .at-card .at-avatar-fallback {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: var(--brand-navy);
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-weight: 700;
            flex-shrink: 0;
        }
        .at-card .at-person h3 {
            font-family: var(--font-body);
            font-size: var(--text-sm);
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }
        .at-card .at-person span {
            font-size: var(--text-xs);
            color: var(--text-muted);
        }
        .about-testi-empty {
            text-align: center;
            color: var(--text-muted);
            font-family: var(--font-body);
        }
    </style>

    <!-- About Hero / Page Header Start -->
    <section class="about-hero">
        <div class="about-hero-shape" data-motion="parallax" data-parallax-speed="0.2"></div>
        <div class="container">
            <ul class="about-crumbs">
                <li><a href="index.php">Home</a></li>
                <li><i class="ri-arrow-right-s-line"></i></li>
                <li>About Us</li>
            </ul>
            <h1 data-motion="split-reveal"><span class="split-word">About</span> <span class="split-word" style="color:var(--brand-red)">Sonnac</span> <span class="split-word" style="color:var(--brand-red)">Lanka</span> <span class="split-word">Enterprises</span></h1>
        </div>
    </section>
    <!-- About Hero / Page Header End -->

    <!-- Story Section Start -->
    <section class="about-story">
        <div class="container">
            <div class="about-story-grid">
                <div class="about-gallery" data-motion="reveal">
                    <img src="assets/img/about/about-shape-1.webp" alt="" class="about-gallery-shape" data-motion="parallax" data-parallax-speed="0.12">
                    <img src="assets/img/about/about-img-1.webp" alt="Inspected import vehicle" class="about-gallery-img about-gallery-img-1">
                    <img src="assets/img/about/about-img-2.webp" alt="Vehicle prepared for export" class="about-gallery-img about-gallery-img-2">
                    <div class="about-gallery-badge">
                        <i class="ri-award-fill"></i>
                        <div>
                            <b><span data-motion="counter" data-count-to="<?php echo (int) $sleYearsInBusiness ?>" data-count-suffix="+">0+</span></b>
                            <span>Years Established</span>
                        </div>
                    </div>
                </div>
                <div class="about-copy" data-motion="reveal">
                    <span class="brand-eyebrow">Who We Are</span>
                    <h2>A Trusted Name In Quality Vehicle Imports Since 2003</h2>
                    <p>Sonnac Lanka Enterprises was established in 2003 as a used-vehicle importer, exporter, and auction-bidding support coordinator. Over the years we've built a strong reputation among customers who value straight answers and vehicles that arrive exactly as described.</p>
                    <p>We stay closely tuned to both the Sri Lankan and international automobile markets, working directly with overseas auction houses so we're able to source, purchase, and move a vehicle within hours when the right one comes up — no unnecessary delays, no unnecessary middlemen.</p>
                    <p>Today we operate from our office on Galle Road in Colombo, and to date we've supplied more than 1,500 vehicles to customers across Sri Lanka and beyond. Every purchase is backed by our team directly — real people you can call, not a support ticket queue.</p>
                    <div class="about-feature-list" data-motion-group>
                        <div class="about-feature-item" data-motion="grid-item">
                            <i class="ri-auction-line"></i>
                            <div>
                                <h4>Direct Auction Access</h4>
                                <p>We bid and buy directly at overseas vehicle auctions.</p>
                            </div>
                        </div>
                        <div class="about-feature-item" data-motion="grid-item">
                            <i class="ri-map-2-line"></i>
                            <div>
                                <h4>Local Market Expertise</h4>
                                <p>Well conversant with the Sri Lankan automobile market.</p>
                            </div>
                        </div>
                        <div class="about-feature-item" data-motion="grid-item">
                            <i class="ri-flashlight-line"></i>
                            <div>
                                <h4>Fast Turnaround</h4>
                                <p>Capable of purchasing and moving a vehicle within hours.</p>
                            </div>
                        </div>
                        <div class="about-feature-item" data-motion="grid-item">
                            <i class="ri-customer-service-2-line"></i>
                            <div>
                                <h4>Direct Support</h4>
                                <p>Reach our team by phone, mobile, or WhatsApp — no queues.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Story Section End -->

    <!-- Quick Facts Strip Start -->
    <section class="about-quick-facts">
        <div class="container">
            <div class="qf-grid" data-motion-group>
                <div class="qf-item" data-motion="grid-item">
                    <i class="ri-map-pin-line"></i>
                    <div>
                        <h5>Address</h5>
                        <p>No 25, 11/6, Galle Road, Colombo 06</p>
                    </div>
                </div>
                <div class="qf-item" data-motion="grid-item">
                    <i class="ri-phone-line"></i>
                    <div>
                        <h5>Hotline</h5>
                        <a href="tel:+94112339311">+94 11 233 9311</a>
                    </div>
                </div>
                <div class="qf-item" data-motion="grid-item">
                    <i class="ri-mail-line"></i>
                    <div>
                        <h5>Email</h5>
                        <a href="mailto:info@sonnaclankaenterprises.com">info@sonnaclankaenterprises.com</a>
                    </div>
                </div>
                <div class="qf-item" data-motion="grid-item">
                    <i class="ri-time-line"></i>
                    <div>
                        <h5>Hours</h5>
                        <p>Mon - Fri, 9.00 AM - 5.00 PM</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Quick Facts Strip End -->

    <!-- Stats Section Start -->
    <section class="about-stats">
        <div class="container">
            <div class="stats-grid" data-motion-group>
                <div class="stat-card brand-card" data-motion="grid-item">
                    <i class="ri-car-line"></i>
                    <span class="stat-num"><span data-motion="counter" data-count-to="1500" data-count-suffix="+">0+</span></span>
                    <span class="stat-label">Vehicles Supplied</span>
                </div>
                <div class="stat-card brand-card" data-motion="grid-item">
                    <i class="ri-calendar-check-line"></i>
                    <span class="stat-num"><span data-motion="counter" data-count-to="<?php echo (int) $sleYearsInBusiness ?>" data-count-suffix="+">0+</span></span>
                    <span class="stat-label">Years In Business</span>
                </div>
                <div class="stat-card brand-card" data-motion="grid-item">
                    <i class="ri-flag-2-line"></i>
                    <span class="stat-num"><span data-motion="counter" data-count-to="2003">0</span></span>
                    <span class="stat-label">Established</span>
                </div>
                <div class="stat-card brand-card" data-motion="grid-item">
                    <i class="ri-shield-check-line"></i>
                    <span class="stat-num"><span data-motion="counter" data-count-to="100" data-count-suffix="%">0%</span></span>
                    <span class="stat-label">Vehicles Inspected</span>
                </div>
            </div>
        </div>
    </section>
    <!-- Stats Section End -->

    <!-- Dealer Section Start -->
    <?php  //include_once('./includes/about/dealer_section.php');
    ?>
    <!-- Dealer Section End -->

    <!-- Testimonial Section Start -->
    <section class="about-testimonials">
        <div class="container">
            <div class="about-testi-head" data-motion="reveal">
                <span class="brand-eyebrow">Testimonials</span>
                <h2>What Our Customers Say</h2>
            </div>
            <?php
            include 'cpad/reviewController.php';
            ?>
            <?php if (!empty($reviews)): ?>
            <div class="about-testi-grid" data-motion-group>
                <?php foreach ($reviews as $review):
                    $imageName = trim($review['image_name']);
                    $initial = strtoupper(substr($review['customer_name'], 0, 1));
                ?>
                <div class="at-card brand-card" data-motion="grid-item">
                    <div class="at-stars">★★★★★</div>
                    <p class="at-quote">&ldquo;<?php echo htmlspecialchars($review['comment']) ?>&rdquo;</p>
                    <div class="at-person">
                        <?php if ($imageName): ?>
                            <img class="at-avatar" src="<?php echo htmlspecialchars('admincontent/review/' . $imageName) ?>" alt="<?php echo htmlspecialchars($review['customer_name']) ?>">
                        <?php else: ?>
                            <span class="at-avatar-fallback"><?php echo htmlspecialchars($initial) ?></span>
                        <?php endif; ?>
                        <div>
                            <h3><?php echo htmlspecialchars($review['customer_name']) ?></h3>
                            <span><?php echo htmlspecialchars($review['title']) ?>, <?php echo htmlspecialchars($review['country']) ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p class="about-testi-empty">Customer reviews will appear here soon.</p>
            <?php endif; ?>
        </div>
    </section>
    <!-- Testimonial Section End -->

    <!-- FAQ Section start -->
    <?php  // include_once('./includes/about/faq.php');
    ?>
    <!-- FAQ Section End -->

    <!-- App Section Start -->
    <?php // include_once('./includes/app.php');
    ?>
    <!-- App Section End -->

    <!-- Footer Section Start -->
    <?php include_once('./includes/footer.php'); ?>
    <!-- Footer Section End -->

    <?php include_once('./includes/script.php'); ?>
</body>

</html>
