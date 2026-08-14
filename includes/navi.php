<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name

function isPageActive($page_name)
{
    global $current_page;
    return ($current_page == $page_name) ? 'active' : '';
}
?>
<style>
    /* ==========================================================================
       Sonnac Lanka Enterprises — header / nav rebrand overrides
       Layered on top of header.css using the shared brand.css design tokens.
       Scoped to this file only; no other stylesheet is edited.
       ========================================================================== */

    /* Bug fix: theme's sticky state falls back to a plain white background
       (header.css: .header-wrap.sticky { background: var(--whiteColor); }).
       This site is dark-only, so force the sticky bar onto the surface scale
       and keep nav text readable against it. */
    .header-wrap.sticky {
        background: var(--surface-0) !important;
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.4);
    }
    .header-wrap.sticky.header-one .header-bottom {
        background-color: var(--surface-0) !important;
        backdrop-filter: none;
    }
    .header-wrap.sticky .navbar-nav .nav-item > a {
        color: var(--text-primary);
    }

    /* ---- Header rebuilt as a single unified bar (was a cluttered two-tier
       info-strip + navbar). Essential info folds into one row and the
       sidebar popup covers the rest. ---- */
    .header-wrap.header-one .header-bottom {
        background-color: rgba(10, 14, 19, 0.7);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid var(--surface-border);
        padding: var(--space-3) 0;
    }
    .header-wrap .navbar-brand img {
        height: 56px;
        width: auto;
        object-fit: contain;
    }
    .header-wrap.header-one .navbar-nav {
        gap: var(--space-6);
        margin-left: var(--space-8);
    }
    .header-wrap.header-one .navbar-nav .nav-item > a {
        color: var(--text-primary) !important;
        font-family: var(--font-display);
        font-weight: 500;
        font-size: var(--text-base);
        letter-spacing: 0.01em;
        padding: var(--space-2) 0 !important;
        position: relative;
    }
    .header-wrap.header-one .navbar-nav .nav-item > a:hover,
    .header-wrap.header-one .navbar-nav .nav-item > a:focus,
    .header-wrap.header-one .navbar-nav .nav-item > a.active {
        color: var(--brand-gold) !important;
    }
    .header-wrap.header-one .navbar-nav .nav-item > a:after {
        background-color: var(--brand-gold) !important;
    }

    /* Right-side utility cluster: phone pill + CTA + map/sidebar toggle */
    .header-wrap .other-options {
        display: flex;
        align-items: center;
        gap: var(--space-4);
    }
    .header-wrap .other-options .header-phone {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        color: var(--text-secondary);
        font-family: var(--font-body);
        font-size: var(--text-sm);
        text-decoration: none;
        transition: color var(--duration-fast) var(--ease-out);
    }
    .header-wrap .other-options .header-phone:hover {
        color: var(--brand-gold);
    }
    .header-wrap .other-options .header-phone i {
        color: var(--brand-red);
        font-size: var(--text-lg);
    }
    .header-wrap .other-options .option-item .btn-brand-primary {
        padding: 12px 28px;
    }
    .header-wrap .sidebar-btn,
    .mobile-bar-wrap .sidebar-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: var(--radius-full);
        background-color: var(--surface-2);
        border: 1px solid var(--surface-border);
        color: var(--text-primary);
        font-size: var(--text-lg);
        transition: all var(--duration-fast) var(--ease-out);
    }
    .header-wrap .sidebar-btn:hover,
    .mobile-bar-wrap .sidebar-btn:hover {
        background-color: var(--brand-navy);
        border-color: var(--brand-navy);
        color: var(--text-primary);
    }
    .mobile-bar-wrap .mobile-menu a {
        color: var(--text-primary);
    }

    /* Mobile off-canvas sidebar popup — navy accent differentiates it from the
       near-black header/page surface */
    .sidebar-popup .sidebar-popup-wrap {
        background: linear-gradient(180deg, var(--brand-navy) 0%, var(--surface-0) 60%);
        border-left: 1px solid var(--surface-border);
    }
    .sidebar-popup .close-popup {
        background-color: rgba(245, 247, 250, 0.1);
        border-radius: var(--radius-full);
        color: var(--text-primary);
        transition: all var(--duration-fast) var(--ease-out);
    }
    .sidebar-popup .close-popup:hover {
        background-color: var(--brand-red);
    }
    .sidebar-popup .close-popup:hover i {
        color: var(--text-primary);
    }
    .sidebar-popup .sidebar-popup-wrap .comp-logo img {
        border-radius: var(--radius-full);
        background: var(--surface-1);
    }
    .sidebar-popup .sidebar-popup-wrap h3 {
        font-family: var(--font-display);
        color: var(--text-primary);
    }
    .sidebar-popup .sidebar-popup-wrap .comp-desc {
        color: var(--text-secondary);
        font-family: var(--font-body);
    }
    .sidebar-popup .sidebar-popup-wrap .contact-box li b {
        color: var(--brand-gold);
        font-family: var(--font-body);
    }
    .sidebar-popup .sidebar-popup-wrap .contact-box li p,
    .sidebar-popup .sidebar-popup-wrap .contact-box li a {
        color: var(--text-secondary);
    }
    .sidebar-popup .sidebar-popup-wrap .contact-box li a:hover {
        color: var(--brand-gold);
    }
    .sidebar-popup .sidebar-popup-wrap .social-profile li a i {
        background-color: var(--surface-2);
        color: var(--text-secondary);
        border-radius: var(--radius-full);
        transition: all var(--duration-fast) var(--ease-out);
    }
    .sidebar-popup .sidebar-popup-wrap .social-profile li a:hover i {
        background-color: var(--brand-red);
        color: var(--text-primary);
    }
    .sidebar-popup .sidebar-popup-wrap .comp-map iframe {
        border-radius: var(--radius-md);
        border: 1px solid var(--surface-border);
    }

    /* WhatsApp widgets */
    .whatsapp-button {
        background-color: var(--brand-red) !important;
        box-shadow: var(--shadow-card);
    }
    .whatsapp-popup {
        background-color: var(--surface-2);
        border: 1px solid var(--surface-border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card-hover);
        overflow: hidden;
    }
    .whatsapp-header {
        background: linear-gradient(135deg, var(--brand-navy), var(--brand-navy-light));
    }
    .whatsapp-header h2 {
        font-family: var(--font-display);
        color: var(--text-primary);
    }
    .whatsapp-header p {
        color: rgba(245, 247, 250, 0.8);
    }
    .whatsapp-body .wp-contact-box {
        background-color: var(--surface-3);
        border-radius: var(--radius-md);
        transition: transform var(--duration-fast) var(--ease-out);
    }
    .whatsapp-body a:hover .wp-contact-box {
        transform: translateY(-2px);
    }
    .whatsapp-body .wp-contact-info h3 {
        color: var(--text-primary);
        font-family: var(--font-display);
    }
    .whatsapp-body .wp-contact-info p {
        color: var(--text-muted);
    }
</style>
<header class="header-wrap header-one">
    <div class="header-bottom">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-dark">
                <a class="navbar-brand" href="index.php">
                    <img class="logo-light" src="assets/img/logo/sonnac-lanka-logo-nav.webp" alt="Sonnac Lanka Enterprises">
                    <img class="logo-dark" src="assets/img/logo/sonnac-lanka-logo-nav.webp" alt="Sonnac Lanka Enterprises">
                </a>
                <div class="collapse navbar-collapse main-menu-wrap" id="navbarSupportedContent">
                    <div class="menu-close d-lg-none">
                        <a href="javascript:void(0)"> <i class="ri-close-line"></i></a>
                    </div>
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link <?php echo isPageActive('index.php');
                                                                echo isPageActive(''); ?>">
                                Home
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="used_japanese_vehicles.php" class="nav-link <?php echo isPageActive('used_japanese_vehicles.php'); ?>">
                                Stock
                            </a>
                        </li>
                        <!-- <li class="nav-item ">
                            <a href="new_vehicles.php" class="nav-link <?php echo isPageActive('new_vehicles.php'); ?>">
                                New Vehicles
                            </a>
                        </li> -->
                        <li class="nav-item ">
                            <a href="about.php" class="nav-link <?php echo isPageActive('about.php'); ?>">
                                About Us
                            </a>

                        </li>

                        <li class="nav-item">
                            <a href="contact.php" class="nav-link <?php echo isPageActive('contact.php'); ?>">Contact</a>
                        </li>

                    </ul>
                    <div class="other-options md-none">
                        <a href="tel:+94112339311" class="header-phone">
                            <i class="ri-phone-fill"></i> +94 11 233 9311
                        </a>
                        <div class="option-item">
                            <a href="used_japanese_vehicles.php" class="btn-brand btn-brand-primary">Our Listing</a>
                        </div>
                        <div class="option-item">
                            <button class="sidebar-btn"><i class="ri-road-map-line"></i></button>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="mobile-bar-wrap">

                <button class="sidebar-btn  d-lg-none"><i class="ri-road-map-line"></i></button>
                <div class="mobile-menu d-lg-none">
                    <a href="javascript:void(0)"><i class="ri-menu-line"></i></a>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="sidebar-popup">
    <div class="sidebar-popup-wrap">
        <button type="button" class="close-popup"> <i class="ri-close-fill"></i> </button>
        <div class="comp-logo" data-motion="reveal">
            <a href="index.php">
                <img src="assets/img/logo/sonnac-lanka-logo-nav.webp" alt="Sonnac Lanka Enterprises">
            </a>
        </div>
        <h3 data-motion="reveal">Sonnac Lanka Enterprises</h3>
        <p class="comp-desc" data-motion="reveal">
            Established in 2003, Sonnac Lanka Enterprises has proudly served as a trusted Japanese used-vehicle importer and exporter, supplying over 1,500 vehicles to customers across Sri Lanka and beyond.
        </p>
        <ul class="contact-box list-style" data-motion="reveal">
            <li>
                <b>Address:</b>
                <p>No 25, 11/6, Galle Road, Colombo 06, Sri Lanka</p>
            </li>
            <li>
                <b>Hotline:</b>
                <a href="tel:+94112339311">+94 11 233 9311</a>
            </li>
            <li>
                <b>Mobile:</b>
                <a href="tel:+94777366463">+94 777 366 463</a>
            </li>
            <li>
                <b>Hours:</b>
                <p>Mon - Fri, 9.00 AM - 5.00 PM</p>
            </li>
            <li>
                <b>Email:</b>
                <a href="mailto:info@sonnaclankaenterprises.com">info@sonnaclankaenterprises.com</a>
            </li>
        </ul>
        <ul class="social-profile list-style" data-motion="reveal">
            <li>
                <a href="https://www.facebook.com/sonnacbidding" target="_blank">
                    <i class="flaticon-facebook"></i>
                </a>
            </li>
        </ul>
        <div class="comp-map" data-motion="reveal">
            <iframe src="https://www.google.com/maps?q=No+25,+11%2F6,+Galle+Road,+Colombo+06,+Sri+Lanka&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>


<!-- Whatsapp Chat Button -->
<div class="whatsapp-button" id="whatsappButton">
    <i class="fa-brands fa-whatsapp wp-icon" alt="WhatsApp"></i>
</div>
<div class="whatsapp-popup" id="whatsappPopup">
    <div class="whatsapp-header">
        <h2>Start a Conversation</h2>
        <p>Hi! Click one of our members below to chat on WhatsApp</p>
    </div>
    <div class="whatsapp-body">

        <!-- Officer 1 -->
        <a href="https://wa.me/94777366463?text=Hello%20Sonnac%20Lanka%20Enterprises,%20I'm%20" target="_blank">
            <div class="wp-contact-box">
                <div class="whatsapp-contact">
                    <img src="assets/img/customer-officer-2.jpg" alt="WhatsApp">
                    <div class="wp-contact-info">
                        <h3>Sonnac Lanka Enterprises</h3>
                        <p>Customer Support</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- Officer 2 -->
        <!-- <a href="https://wa.me/-?text=sonnaclanka.com" target=”_blank”>
			<div class="wp-contact-box">
				<div class="whatsapp-contact">
					<img src="assets/img/customer-officer-2.jpg" alt="WhatsApp">
					<div class="wp-contact-info">
						<h3>Officer 2</h3>
						<p>Customer Support</p>
					</div>
				</div>
			</div>
		</a> -->

    </div>
</div>
