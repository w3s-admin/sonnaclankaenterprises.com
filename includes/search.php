<?php
if (!class_exists('Vehicle')) {
    require_once('cpad/vehicleController.php');
}

$Make = $Make ?? null;
$Model = $Model ?? null;
$BodyType = $BodyType ?? null;
$columName = $columName ?? null;
$style = $style ?? "";
?>
<style>
    /* ==========================================================================
       Sonnac Lanka Enterprises — search bar, rebuilt as a floating card that
       overlaps the hero's bottom edge (modern marketplace pattern) instead of
       sitting in its own flat full-width strip.
       ========================================================================== */
    .search-float-wrap {
        position: relative;
        z-index: 3;
        margin-top: -60px;
        padding-bottom: var(--space-10);
    }
    .search-float-card {
        background: var(--surface-2);
        border: 1px solid var(--surface-border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card-hover);
        padding: var(--space-6);
        display: grid;
        grid-template-columns: repeat(3, 1fr) auto;
        gap: var(--space-4);
        align-items: end;
    }
    @media (max-width: 991px) {
        .search-float-card {
            grid-template-columns: 1fr 1fr;
        }
    }
    @media (max-width: 575px) {
        .search-float-card {
            grid-template-columns: 1fr;
        }
    }
    .search-field label {
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
    .search-field label i {
        color: var(--brand-gold);
    }
    .search-field select {
        width: 100%;
        background-color: var(--surface-1) !important;
        border: 1px solid var(--surface-border) !important;
        border-radius: var(--radius-md) !important;
        color: var(--text-primary) !important;
        height: 52px;
        padding: 0 40px 0 16px;
        font-family: var(--font-body);
        font-size: var(--text-base);
        transition: border-color var(--duration-fast) var(--ease-out);
    }
    .search-field select:hover,
    .search-field select:focus {
        border-color: var(--brand-gold) !important;
    }
    .search-field select option {
        background-color: var(--surface-1);
        color: var(--text-primary);
    }
    .search-float-card .filter-search-btn {
        height: 52px;
        padding: 0 var(--space-6);
        white-space: nowrap;
    }
    @media (max-width: 991px) {
        .search-float-card .filter-search-btn { grid-column: 1 / -1; width: 100%; }
    }
</style>

<div class="search-float-wrap">
    <div class="container">
        <form action="used_japanese_vehicles.php" class="search-float-card" data-motion="reveal">
            <div class="search-field">
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
                          AND a.status = 1
                        )
                        ORDER BY m.Id ASC",
                        $columName,
                        "Any Make",
                        $style
                    );
                ?>
            </div>
            <div class="search-field">
                <label for="Model"><i class="ri-price-tag-3-line"></i> Model</label>
                <select id="Model" name="Model" title="Please Select Model">
                    <?php echo
                     CommonBase::createSelectAjxSearch(${'Model'}, ${'Make'},
                     "SELECT m.Id, m.name
                     FROM model m
                     WHERE m.fk_make = ?
                     AND m.status = 1
                     AND EXISTS (
                       SELECT 1
                       FROM advert a
                       WHERE a.fk_model = m.Id
                         AND a.status = 1
                     )", "fk_model", "Any Model"); ?>
                </select>
            </div>
            <div class="search-field">
                <label for="BodyType"><i class="ri-car-washing-line"></i> Body Type</label>
                <?php echo
                    CommonBase::createSelectSearch(
                        ${'BodyType'},
                        $name = 'BodyType',
                        null,
                        $class = "",
                        "",
                        $q = "SELECT bt.Id, bt.name
                        FROM body_type bt
                        WHERE bt.status = 1
                        AND EXISTS (
                          SELECT 1
                          FROM advert a
                          WHERE a.fk_body_type = bt.Id
                            AND a.status = 1
                        )
                        ORDER BY bt.Id ASC;",
                        $columName,
                        "Any Type",
                        $style
                    );
                ?>
            </div>
            <button type="submit" class="btn-brand btn-brand-primary filter-search-btn"><i class="ri-search-line"></i> Search</button>
        </form>
    </div>
</div>
