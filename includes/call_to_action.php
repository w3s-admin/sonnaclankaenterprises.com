<style>
    /* ==========================================================================
       Sonnac Lanka Enterprises — CTA band, rebuilt.
       Full-bleed navy gradient with a parallax-drifting oversized watermark
       instead of a plain centered text block.
       ========================================================================== */
    .cta-modern {
        position: relative;
        overflow: hidden;
        padding: var(--space-12) 0;
        background: linear-gradient(135deg, var(--brand-navy) 0%, #0c2540 100%);
    }
    .cta-modern .cta-watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-family: var(--font-display);
        font-weight: 800;
        font-size: clamp(6rem, 22vw, 16rem);
        color: rgba(255, 255, 255, 0.035);
        white-space: nowrap;
        letter-spacing: 0.02em;
        pointer-events: none;
        z-index: 0;
    }
    .cta-modern-inner {
        position: relative;
        z-index: 1;
        max-width: 720px;
        margin: 0 auto;
        text-align: center;
    }
    .cta-modern-inner .brand-eyebrow {
        justify-content: center;
    }
    .cta-modern-inner h2 {
        font-family: var(--font-display);
        font-weight: 800;
        font-size: clamp(1.9rem, 4vw, var(--text-4xl));
        line-height: 1.15;
        color: var(--text-primary);
        margin: var(--space-3) 0 var(--space-4);
    }
    .cta-modern-inner p {
        font-size: var(--text-lg);
        line-height: 1.6;
        color: rgba(245, 247, 250, 0.75);
        margin: 0 0 var(--space-6);
    }
    .cta-modern-btns {
        display: flex;
        justify-content: center;
        gap: var(--space-4);
        flex-wrap: wrap;
    }
</style>

<section class="cta-modern">
    <span class="cta-watermark" data-motion="parallax" data-parallax-speed="0.15">SONNAC LANKA</span>
    <div class="container">
        <div class="cta-modern-inner" data-motion="reveal">
            <span class="brand-eyebrow">Trusted Exporter</span>
            <h2>Your Trusted Source For Quality Cars</h2>
            <p>One of the region's leading vehicle exporters — full inspection reports, transparent pricing, and worldwide shipping handled end-to-end.</p>
            <div class="cta-modern-btns">
                <a href="./contact.php" class="btn-brand btn-brand-primary">Contact Us</a>
                <a href="./used_japanese_vehicles.php" class="btn-brand btn-brand-outline">Browse Stock</a>
            </div>
        </div>
    </div>
</section>
