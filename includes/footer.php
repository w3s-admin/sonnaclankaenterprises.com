<style>
    /* ==========================================================================
       Sonnac Lanka Enterprises — footer, rebuilt.
       Newsletter promoted to its own top band; icons standardized on
       Remix Icon (ri-*) instead of mixing in ion-icon; 3-column layout
       with clearer hierarchy.
       ========================================================================== */
    .footer-modern {
        background: var(--surface-1);
        border-top: 1px solid var(--surface-border);
    }
    .footer-newsletter-band {
        border-bottom: 1px solid var(--surface-border);
        padding: var(--space-6) 0;
    }
    .footer-newsletter-band .fn-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: var(--space-5);
        flex-wrap: wrap;
    }
    .footer-newsletter-band h3 {
        font-family: var(--font-display);
        font-weight: 700;
        font-size: var(--text-xl);
        color: var(--text-primary);
        margin: 0 0 4px;
    }
    .footer-newsletter-band p {
        margin: 0;
        color: var(--text-secondary);
        font-size: var(--text-sm);
    }
    .footer-newsletter-form {
        display: flex;
        gap: var(--space-2);
        flex: 0 0 auto;
    }
    .footer-newsletter-form input {
        background: var(--surface-2);
        border: 1px solid var(--surface-border);
        border-radius: var(--radius-md);
        color: var(--text-primary);
        padding: 0 var(--space-4);
        height: 48px;
        width: 280px;
        max-width: 60vw;
        font-family: var(--font-body);
    }
    .footer-newsletter-form button {
        height: 48px;
        width: 48px;
        border-radius: var(--radius-md);
        background: var(--brand-red);
        border: none;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: var(--text-lg);
        transition: background var(--duration-fast) var(--ease-out);
    }
    .footer-newsletter-form button:hover {
        background: var(--brand-red-light);
    }

    .footer-columns {
        padding: var(--space-10) 0 var(--space-6);
        display: grid;
        grid-template-columns: 1.3fr 1fr 1fr;
        gap: var(--space-8);
    }
    @media (max-width: 860px) { .footer-columns { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 560px) { .footer-columns { grid-template-columns: 1fr; } }

    .footer-brand-col img { height: 60px; width: auto; margin-bottom: var(--space-4); }
    .footer-brand-col p {
        color: var(--text-secondary);
        font-size: var(--text-sm);
        line-height: 1.6;
        max-width: 320px;
        margin: 0 0 var(--space-4);
    }
    .footer-social {
        display: flex;
        gap: var(--space-2);
    }
    .footer-social a {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--surface-2);
        border: 1px solid var(--surface-border);
        color: var(--text-secondary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all var(--duration-fast) var(--ease-out);
    }
    .footer-social a:hover {
        background: var(--brand-red);
        color: #fff;
        border-color: var(--brand-red);
    }

    .footer-col h4 {
        font-family: var(--font-display);
        font-size: var(--text-base);
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 var(--space-4);
    }
    .footer-col ul { list-style: none; margin: 0; padding: 0; }
    .footer-col ul li + li { margin-top: var(--space-3); }
    .footer-col ul a,
    .footer-col ul span {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        color: var(--text-secondary);
        font-size: var(--text-sm);
        text-decoration: none;
        transition: color var(--duration-fast) var(--ease-out);
        line-height: 1.5;
    }
    .footer-col ul a:hover { color: var(--brand-gold); }
    .footer-col ul i { color: var(--brand-red); margin-top: 2px; }

    .footer-bottom-bar {
        border-top: 1px solid var(--surface-border);
        padding: var(--space-4) 0;
        text-align: center;
        color: var(--text-muted);
        font-size: var(--text-xs);
    }
    .footer-bottom-bar a { color: var(--text-secondary); }
</style>

<footer class="footer-modern">
    <div class="footer-newsletter-band">
        <div class="container">
            <div class="fn-inner" data-motion="reveal">
                <div>
                    <h3>Stay In The Loop</h3>
                    <p>New arrivals and offers, straight to your inbox.</p>
                </div>
                <form action="#" class="footer-newsletter-form" id="newsletter-form">
                    <input type="email" placeholder="Enter your email" name="email" id="newsletter-email" required>
                    <button type="submit" id="newsletter-btn"><i class="ri-send-plane-fill"></i></button>
                </form>
            </div>
            <div id="newsletter-error" class="text-danger"></div>
            <div id="newsletter-success" class="text-success"></div>
        </div>
    </div>

    <div class="container">
        <div class="footer-columns" data-motion="reveal">
            <div class="footer-brand-col">
                <a href="index.php"><img src="assets/img/logo/sonnac-lanka-logo-nav.webp" alt="Sonnac Lanka Enterprises"></a>
                <p>Trusted exporter of quality Japanese vehicles — fully inspected, transparently priced, shipped worldwide.</p>
                <div class="footer-social">
                    <a href="https://www.facebook.com/sonnacbidding" target="_blank" aria-label="Facebook"><i class="ri-facebook-fill"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.php"><i class="ri-arrow-right-s-line"></i> Home</a></li>
                    <li><a href="used_japanese_vehicles.php"><i class="ri-arrow-right-s-line"></i> Stock</a></li>
                    <li><a href="about.php"><i class="ri-arrow-right-s-line"></i> About Us</a></li>
                    <li><a href="contact.php"><i class="ri-arrow-right-s-line"></i> Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Get In Touch</h4>
                <ul>
                    <li><span><i class="ri-map-pin-line"></i> No 25, 11/6, Galle Road, Colombo 06, Sri Lanka</span></li>
                    <li><a href="mailto:info@sonnaclankaenterprises.com"><i class="ri-mail-line"></i> info@sonnaclankaenterprises.com</a></li>
                    <li><a href="tel:+94112339311"><i class="ri-phone-line"></i> +94 11 233 9311</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="footer-bottom-bar">
        <div class="container">
            Copyright <?php echo date('Y') ?> Sonnac Lanka Enterprises. All rights reserved. Web Design &amp; Development by <a href="https://w3ssolutions.com/">W3S Solutions</a>
        </div>
    </div>
</footer>
