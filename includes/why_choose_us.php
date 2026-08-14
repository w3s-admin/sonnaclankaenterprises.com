<style>
    /* ==========================================================================
       Sonnac Lanka Enterprises — trust/process section, built fresh
       (previously unused template file with lorem-ipsum placeholder content).
       ========================================================================== */
    .why-section {
        padding: var(--space-12) 0;
        background: var(--surface-1);
        border-top: 1px solid var(--surface-border);
        border-bottom: 1px solid var(--surface-border);
    }
    .why-head {
        max-width: 640px;
        margin: 0 auto var(--space-8);
        text-align: center;
    }
    .why-head h2 {
        font-family: var(--font-display);
        font-size: clamp(1.75rem, 3vw, var(--text-4xl));
        font-weight: 800;
        color: var(--text-primary);
        margin: var(--space-2) 0 0;
    }
    .why-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: var(--space-5);
    }
    @media (max-width: 991px) { .why-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 560px) { .why-grid { grid-template-columns: 1fr; } }

    .why-card {
        position: relative;
        background: var(--surface-2);
        border: 1px solid var(--surface-border);
        border-radius: var(--radius-lg);
        padding: var(--space-6) var(--space-5) var(--space-5);
        transition: transform var(--duration-base) var(--ease-out), border-color var(--duration-base) var(--ease-out);
    }
    .why-card:hover {
        transform: translateY(-6px);
        border-color: rgba(184, 32, 46, 0.35);
    }
    .why-card .why-index {
        position: absolute;
        top: var(--space-4);
        right: var(--space-5);
        font-family: var(--font-display);
        font-weight: 800;
        font-size: var(--text-2xl);
        color: var(--surface-3);
    }
    .why-card .why-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        border-radius: var(--radius-md);
        background: rgba(184, 32, 46, 0.12);
        color: var(--brand-red);
        font-size: 26px;
        margin-bottom: var(--space-4);
    }
    .why-card h3 {
        font-family: var(--font-display);
        font-size: var(--text-lg);
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 var(--space-2);
    }
    .why-card p {
        font-family: var(--font-body);
        font-size: var(--text-sm);
        line-height: 1.6;
        color: var(--text-secondary);
        margin: 0;
    }
</style>

<section class="why-section">
    <div class="container">
        <div class="why-head" data-motion="reveal">
            <span class="brand-eyebrow">Why Sonnac Lanka</span>
            <h2>Built On Trust, Backed By Process</h2>
        </div>
        <div class="why-grid" data-motion-group>
            <div class="why-card" data-motion="grid-item">
                <span class="why-index">01</span>
                <span class="why-icon"><i class="ri-search-eye-line"></i></span>
                <h3>Full Inspection</h3>
                <p>Every vehicle is checked and documented before it's ever listed — no surprises after purchase.</p>
            </div>
            <div class="why-card" data-motion="grid-item">
                <span class="why-index">02</span>
                <span class="why-icon"><i class="ri-map-pin-line"></i></span>
                <h3>Sourced Direct From Japan</h3>
                <p>We buy directly at the source, cutting out unnecessary middlemen and markups.</p>
            </div>
            <div class="why-card" data-motion="grid-item">
                <span class="why-index">03</span>
                <span class="why-icon"><i class="ri-ship-line"></i></span>
                <h3>Worldwide Shipping</h3>
                <p>Export documentation and shipping logistics handled end-to-end, wherever you are.</p>
            </div>
            <div class="why-card" data-motion="grid-item">
                <span class="why-index">04</span>
                <span class="why-icon"><i class="ri-customer-service-2-line"></i></span>
                <h3>Real Human Support</h3>
                <p>Talk to a real person about your order, not a support ticket queue.</p>
            </div>
        </div>
    </div>
</section>
