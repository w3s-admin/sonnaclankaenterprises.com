<?php
if (!class_exists('Vehicle')) {
    require_once('cpad/vehicleController.php');
}

$latest_vehicles = Vehicle::getLetestVehicles(1)->fetchAll();
$server = CommonBase::getServer();
$stockCount = Vehicle::stockCount();

$featured = null;
if (!empty($latest_vehicles)) {
    $v = $latest_vehicles[0];
    $img = Vehicle::getFirastimage($v['Id']);
    $featured = [
        'title' => Vehicle::getname($v['fk_make'], "make") . ' ' . Vehicle::getname($v['fk_model'], "model"),
        'price' => Vehicle::getPrprice($v),
        'img'   => $server . $img['tpath'] . $img['image_name'],
        'link'  => Vehicle::createUrl($v),
    ];
}
?>
<style>
    /* ==========================================================================
       Sonnac Lanka Enterprises — hero, rebuilt (not re-themed).
       Full-bleed dark hero with a dominant car cutout instead of the old
       three-slide carousel + tiny promo-card pattern.
       ========================================================================== */
    .hero-modern {
        position: relative;
        overflow: hidden;
        background: radial-gradient(120% 100% at 78% 20%, rgba(18, 58, 92, 0.55) 0%, transparent 55%),
                    linear-gradient(180deg, var(--surface-0) 0%, #060809 100%);
        padding: 150px 0 90px;
    }
    .hero-modern::before {
        content: "";
        position: absolute;
        top: -20%;
        right: 8%;
        width: 620px;
        height: 620px;
        background: radial-gradient(circle, rgba(184, 32, 46, 0.28) 0%, rgba(184, 32, 46, 0) 70%);
        pointer-events: none;
        z-index: 0;
    }
    .hero-modern .container {
        position: relative;
        z-index: 1;
    }
    .hero-modern-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.05fr) minmax(0, 1fr);
        align-items: center;
        gap: var(--space-8);
    }
    @media (max-width: 991px) {
        .hero-modern-grid {
            grid-template-columns: 1fr;
            text-align: center;
        }
        .hero-modern-grid .hero-modern-btns {
            justify-content: center;
        }
        .hero-modern-grid .hero-modern-stats {
            justify-content: center;
        }
    }

    .hero-modern-copy h1 {
        font-family: var(--font-display);
        font-weight: 800;
        font-size: clamp(2.6rem, 5vw, 4.25rem);
        line-height: 1.05;
        letter-spacing: -0.02em;
        color: var(--text-primary);
        margin: var(--space-4) 0 var(--space-5);
    }
    .hero-modern-copy p {
        font-size: var(--text-lg);
        line-height: 1.65;
        color: var(--text-secondary);
        max-width: 480px;
        margin: 0 0 var(--space-6);
    }
    @media (max-width: 991px) {
        .hero-modern-copy p { margin-left: auto; margin-right: auto; }
    }

    .hero-modern-btns {
        display: flex;
        flex-wrap: wrap;
        gap: var(--space-4);
        margin-bottom: var(--space-8);
    }

    .hero-modern-stats {
        display: flex;
        flex-wrap: wrap;
        gap: var(--space-8);
        padding-top: var(--space-6);
        border-top: 1px solid var(--surface-border);
    }
    .hero-modern-stats .stat b {
        display: block;
        font-family: var(--font-display);
        font-size: var(--text-3xl);
        font-weight: 800;
        color: var(--text-primary);
        line-height: 1;
    }
    .hero-modern-stats .stat span {
        font-size: var(--text-sm);
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .hero-modern-visual {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 420px;
    }
    .hero-modern-visual .car-glow {
        position: absolute;
        width: 92%;
        height: 55%;
        bottom: 6%;
        border-radius: 50%;
        background: radial-gradient(ellipse, rgba(184, 32, 46, 0.35) 0%, rgba(184, 32, 46, 0) 70%);
        filter: blur(4px);
        z-index: 0;
    }
    .hero-modern-visual img.car-shot {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 640px;
        filter: drop-shadow(0 30px 40px rgba(0, 0, 0, 0.55));
    }
    .hero-modern-visual .ring-badge {
        position: absolute;
        top: 6%;
        left: 2%;
        width: 108px;
        height: 108px;
        border-radius: 50%;
        border: 1px dashed var(--surface-border);
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-family: var(--font-display);
        font-size: var(--text-xs);
        font-weight: 700;
        color: var(--brand-gold);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        z-index: 2;
        background: rgba(10, 14, 19, 0.6);
        backdrop-filter: blur(6px);
    }
    .hero-modern-visual .featured-card {
        position: absolute;
        left: -4%;
        bottom: 4%;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: var(--space-3);
        padding: var(--space-3) var(--space-4);
        background: var(--surface-2);
        border: 1px solid var(--surface-border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card-hover);
        text-decoration: none;
        max-width: 280px;
        transition: transform var(--duration-base) var(--ease-out);
    }
    .hero-modern-visual .featured-card:hover {
        transform: translateY(-4px);
    }
    .hero-modern-visual .featured-card img {
        width: 56px;
        height: 56px;
        object-fit: cover;
        border-radius: var(--radius-md);
        flex-shrink: 0;
    }
    .hero-modern-visual .featured-card .fc-title {
        display: block;
        font-family: var(--font-body);
        font-weight: 600;
        font-size: var(--text-sm);
        color: var(--text-primary);
        line-height: 1.3;
    }
    .hero-modern-visual .featured-card .fc-price {
        display: block;
        font-family: var(--font-display);
        font-weight: 700;
        font-size: var(--text-sm);
        color: var(--brand-gold);
    }
    @media (max-width: 991px) {
        .hero-modern-visual { min-height: 320px; margin-top: var(--space-8); }
        .hero-modern-visual .ring-badge { display: none; }
        .hero-modern-visual .featured-card { left: 50%; transform: translateX(-50%); bottom: -8%; }
        .hero-modern-visual .featured-card:hover { transform: translateX(-50%) translateY(-4px); }
    }
</style>

<section class="hero-modern">
    <div class="container">
        <div class="hero-modern-grid">
            <div class="hero-modern-copy">
                <span class="brand-eyebrow" data-motion="hero">Japanese Vehicle Exporter</span>
                <h1 data-motion="split-reveal" data-motion-onload><span class="split-word">Own</span> <span class="split-word">The</span> <span class="split-word">Road</span> <span class="split-word">With</span> <span class="split-word">A</span> <span class="split-word" style="color:var(--brand-red)">Genuine</span> <span class="split-word" style="color:var(--brand-red)">Japanese</span> <span class="split-word">Import</span></h1>
                <p data-motion="hero">Sonnac Lanka Enterprises sources fully-inspected, quality used vehicles direct from Japan and ships them worldwide — no middlemen, no guesswork.</p>
                <div class="hero-modern-btns" data-motion="hero">
                    <a href="used_japanese_vehicles.php" class="btn-brand btn-brand-primary">Browse Vehicles</a>
                    <a href="contact.php" class="btn-brand btn-brand-outline">Talk To Us</a>
                </div>
                <div class="hero-modern-stats" data-motion="hero">
                    <div class="stat">
                        <b><?php echo (int) $stockCount ?>+</b>
                        <span>Cars In Stock</span>
                    </div>
                    <div class="stat">
                        <b>100%</b>
                        <span>Inspected</span>
                    </div>
                    <div class="stat">
                        <b>Worldwide</b>
                        <span>Shipping</span>
                    </div>
                </div>
            </div>
            <div class="hero-modern-visual" data-motion="hero">
                <div class="car-glow" data-motion="parallax" data-parallax-speed="0.35"></div>
                <span class="ring-badge">Direct From Japan</span>
                <img class="car-shot" src="assets/img/hero/hero-img-1.webp" alt="Featured vehicle">
                <?php if ($featured): ?>
                <a class="featured-card" href="<?php echo $featured['link'] ?>">
                    <img src="<?php echo $featured['img'] ?>" alt="<?php echo $featured['title'] ?>">
                    <span>
                        <span class="fc-title"><?php echo $featured['title'] ?></span>
                        <span class="fc-price"><?php echo $featured['price'] ?></span>
                    </span>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
