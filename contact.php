<!DOCTYPE html>
<html lang="zxx" class="theme-dark">

<head>
    <?php
    $pageTitle = "Contact Us - Sonnac Lanka Enterprises | Trusted Quality Vehicle Dealer";
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
           Sonnac Lanka Enterprises — Contact page, rebuilt (not re-themed).
           Old light "breadcrumb-wrap" strip + four duplicated legacy-client
           bank-detail cards replaced with a dark hero, a 4-card contact-detail
           grid, and a single form + map layout using the shared brand tokens.
           ========================================================================== */
        .contact-hero {
            position: relative;
            overflow: hidden;
            padding: 130px 0 70px;
            background: radial-gradient(120% 100% at 15% 10%, rgba(184, 32, 46, 0.22) 0%, transparent 55%),
                        linear-gradient(180deg, var(--surface-0) 0%, #060809 100%);
            border-bottom: 1px solid var(--surface-border);
            text-align: center;
        }
        .contact-hero::before {
            content: "";
            position: absolute;
            top: -25%;
            left: 60%;
            width: 520px;
            height: 520px;
            background: radial-gradient(circle, rgba(18, 58, 92, 0.4) 0%, rgba(18, 58, 92, 0) 70%);
            pointer-events: none;
        }
        .contact-hero .container {
            position: relative;
            z-index: 1;
        }
        .contact-hero h1 {
            font-weight: 800;
            font-size: clamp(2.2rem, 4vw, 3.25rem);
            color: var(--text-primary);
            margin: var(--space-3) 0 var(--space-4);
        }
        .contact-hero-crumbs {
            display: flex;
            justify-content: center;
            gap: var(--space-2);
            list-style: none;
            margin: 0;
            padding: 0;
            font-size: var(--text-sm);
            color: var(--text-muted);
        }
        .contact-hero-crumbs a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color var(--duration-fast) var(--ease-out);
        }
        .contact-hero-crumbs a:hover {
            color: var(--brand-gold);
        }
        .contact-hero-crumbs li {
            display: flex;
            gap: var(--space-2);
        }
        .contact-hero-crumbs li + li::before {
            content: "/";
            margin-right: var(--space-2);
            color: var(--text-muted);
        }

        .contact-section {
            padding: var(--space-12) 0;
            background: var(--surface-0);
        }

        .contact-cards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: var(--space-5);
            margin-bottom: var(--space-10);
        }
        @media (max-width: 991px) {
            .contact-cards-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 560px) {
            .contact-cards-grid { grid-template-columns: 1fr; }
        }

        .contact-detail-card {
            padding: var(--space-6) var(--space-5);
            text-align: left;
        }
        .contact-detail-card .cd-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            border-radius: var(--radius-md);
            background: rgba(239, 193, 46, 0.12);
            color: var(--brand-gold);
            font-size: 24px;
            margin-bottom: var(--space-4);
        }
        .contact-detail-card h3 {
            font-size: var(--text-base);
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 var(--space-2);
        }
        .contact-detail-card p,
        .contact-detail-card a {
            font-family: var(--font-body);
            font-size: var(--text-sm);
            line-height: 1.6;
            color: var(--text-secondary);
            margin: 0;
            text-decoration: none;
            display: block;
        }
        .contact-detail-card a:hover {
            color: var(--brand-gold);
        }

        .contact-main-grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: var(--space-6);
            align-items: stretch;
        }
        @media (max-width: 991px) {
            .contact-main-grid { grid-template-columns: 1fr; }
        }

        .contact-form-card {
            padding: var(--space-7, 40px);
        }
        .contact-form-card h3 {
            font-size: var(--text-xl);
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 var(--space-5);
        }
        .contact-form-card .form-group {
            margin-bottom: var(--space-4);
        }
        .contact-form-card .form-group input,
        .contact-form-card .form-group textarea {
            width: 100%;
            background-color: var(--surface-2) !important;
            border: 1px solid var(--surface-border) !important;
            border-radius: var(--radius-md) !important;
            color: var(--text-primary) !important;
            padding: 14px 18px;
            font-family: var(--font-body);
            font-size: var(--text-base);
            transition: border-color var(--duration-fast) var(--ease-out);
        }
        .contact-form-card .form-group input::placeholder,
        .contact-form-card .form-group textarea::placeholder {
            color: var(--text-muted);
        }
        .contact-form-card .form-group input:hover,
        .contact-form-card .form-group input:focus,
        .contact-form-card .form-group textarea:hover,
        .contact-form-card .form-group textarea:focus {
            border-color: var(--brand-gold) !important;
            outline: none;
        }
        .contact-form-card textarea {
            resize: vertical;
            min-height: 140px;
        }
        .contact-form-card #msgSubmit {
            margin-top: var(--space-3);
            font-family: var(--font-body);
        }
        .contact-form-card #msgSubmit.text-success {
            color: var(--brand-gold);
        }
        .contact-form-card #msgSubmit.text-danger {
            color: var(--brand-red-light);
        }

        .contact-side {
            display: flex;
            flex-direction: column;
            gap: var(--space-6);
        }
        .contact-map-card {
            padding: 0;
            overflow: hidden;
            min-height: 240px;
        }
        .contact-map-card iframe {
            width: 100%;
            height: 100%;
            min-height: 240px;
            border: 0;
            display: block;
        }
        .contact-social-card {
            padding: var(--space-6);
            text-align: center;
        }
        .contact-social-card h4 {
            font-size: var(--text-base);
            color: var(--text-primary);
            margin: 0 0 var(--space-3);
        }
        .contact-social-card .contact-social-links {
            display: flex;
            justify-content: center;
            gap: var(--space-2);
        }
        .contact-social-card .contact-social-links a {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--surface-2);
            border: 1px solid var(--surface-border);
            color: var(--text-secondary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all var(--duration-fast) var(--ease-out);
        }
        .contact-social-card .contact-social-links a:hover {
            background: var(--brand-red);
            color: #fff;
            border-color: var(--brand-red);
        }
    </style>

    <!-- Contact Hero Start -->
    <section class="contact-hero" data-motion="parallax" data-parallax-speed="0.15">
        <div class="container">
            <span class="brand-eyebrow" data-motion="reveal">Contact Us</span>
            <h1 data-motion="reveal">Let's Get You Behind The Wheel</h1>
            <ul class="contact-hero-crumbs" data-motion="reveal">
                <li><a href="index.php">Home</a></li>
                <li>Contact</li>
            </ul>
        </div>
    </section>
    <!-- Contact Hero End -->

    <!-- Contact Details + Form Start -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-cards-grid" data-motion-group>
                <div class="contact-detail-card brand-card" data-motion="grid-item">
                    <span class="cd-icon"><i class="ri-map-pin-line"></i></span>
                    <h3>Our Location</h3>
                    <p>No 25, 11/6, Galle Road,<br>Colombo 06, Sri Lanka</p>
                </div>
                <div class="contact-detail-card brand-card" data-motion="grid-item">
                    <span class="cd-icon"><i class="ri-phone-line"></i></span>
                    <h3>Call Us</h3>
                    <a href="tel:+94112339311">Hotline: +94 11 233 9311</a>
                    <a href="tel:+94777366463">Mobile: +94 777 366 463</a>
                </div>
                <div class="contact-detail-card brand-card" data-motion="grid-item">
                    <span class="cd-icon"><i class="ri-mail-line"></i></span>
                    <h3>Email Us</h3>
                    <a href="mailto:info@sonnaclankaenterprises.com">info@sonnaclankaenterprises.com</a>
                </div>
                <div class="contact-detail-card brand-card" data-motion="grid-item">
                    <span class="cd-icon"><i class="ri-time-line"></i></span>
                    <h3>Working Hours</h3>
                    <p>Monday - Friday<br>9:00 AM - 5.00 PM</p>
                </div>
            </div>

            <div class="contact-main-grid">
                <div class="contact-form-card brand-card" data-motion="reveal">
                    <h3>Send Us A Message</h3>
                    <form class="form-wrap" id="contactForm">
                        <!-- Honeypot: real visitors never see or fill this (hidden off-screen);
                             spam bots that blindly fill every field will, and get silently rejected server-side. -->
                        <div style="position:absolute; left:-9999px; top:-9999px;" aria-hidden="true">
                            <label for="gridCheck">Leave this field empty</label>
                            <input type="text" name="gridCheck" id="gridCheck" tabindex="-1" autocomplete="off">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Name*" id="name" required data-error="Please enter your name">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" name="email" id="email" required placeholder="Email*" data-error="Please enter your email">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="number" name="phone_number" id="phone_number" required placeholder="Phone Number*" data-error="Please enter your phone number">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="msg_subject" placeholder="Subject*" id="msg_subject" required data-error="Please enter your subject">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group v1">
                                    <textarea name="message" id="message" placeholder="Your Message.." cols="30" rows="8" required data-error="Please enter your message"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn-brand btn-brand-primary">Send Message</button>
                                <div id="msgSubmit" class="h3 text-center hidden"></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="contact-side">
                    <div class="contact-map-card brand-card" data-motion="reveal">
                        <iframe src="https://www.google.com/maps?q=No+25,+11%2F6,+Galle+Road,+Colombo+06,+Sri+Lanka&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="contact-social-card brand-card" data-motion="reveal">
                        <h4>Follow Us</h4>
                        <div class="contact-social-links">
                            <a href="https://www.facebook.com/sonnacbidding" target="_blank" aria-label="Facebook"><i class="ri-facebook-fill"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Details + Form End -->

    <!-- Footer Section Start -->
    <?php include_once('./includes/footer.php'); ?>
    <!-- Footer Section End -->

    <?php include_once('./includes/script.php'); ?>
</body>

</html>
