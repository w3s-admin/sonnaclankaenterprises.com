<?php
if (!class_exists('Vehicle')) {
    require_once('cpad/vehicleController.php');
}

$latest_vehicles = Vehicle::getLetestVehicles(8);
$totalStockCount = Vehicle::stockCount();
?>
<style>
    /* ==========================================================================
       Sonnac Lanka Enterprises — vehicle grid, rebuilt.
       Custom .vehicle-card (price badge over image, icon meta row) replacing
       the old .product-card-one template card.
       ========================================================================== */
    .vehicle-section {
        padding: var(--space-12) 0;
        background: var(--surface-0);
    }
    .vehicle-section-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: var(--space-4);
        margin-bottom: var(--space-8);
        flex-wrap: wrap;
    }
    .vehicle-section-head h2 {
        font-family: var(--font-display);
        font-size: clamp(1.75rem, 3vw, var(--text-4xl));
        font-weight: 800;
        margin: var(--space-2) 0 0;
        color: var(--text-primary);
    }
    .vehicle-section-head .view-all {
        font-family: var(--font-body);
        font-weight: 600;
        font-size: var(--text-sm);
        color: var(--text-secondary);
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
        text-decoration: none;
        white-space: nowrap;
        transition: color var(--duration-fast) var(--ease-out), gap var(--duration-fast) var(--ease-out);
    }
    .vehicle-section-head .view-all:hover {
        color: var(--brand-gold);
        gap: var(--space-3);
    }

    .vehicle-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: var(--space-5);
    }
    @media (max-width: 1199px) { .vehicle-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 860px)  { .vehicle-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px)  { .vehicle-grid { grid-template-columns: 1fr; } }

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
</style>

<section class="vehicle-section">
    <div class="container">
        <div class="vehicle-section-head" data-motion="reveal">
            <div>
                <span class="brand-eyebrow">New Arrivals</span>
                <h2>Find The Best Car For You</h2>
            </div>
            <a class="view-all" href="used_japanese_vehicles.php">View All <?php echo (int) $totalStockCount ?> Vehicles <i class="ri-arrow-right-line"></i></a>
        </div>
        <div class="vehicle-grid" data-motion-group>
            <?php while ($row = $latest_vehicles->fetch(PDO::FETCH_ASSOC)):
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
            <?php endwhile; ?>
        </div>
    </div>
</section>
