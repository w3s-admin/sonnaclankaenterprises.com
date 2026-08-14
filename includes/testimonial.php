<?php
include 'cpad/reviewController.php';
?>
<style>
    /* ==========================================================================
       Sonnac Lanka Enterprises — testimonials, rebuilt as a card grid
       (was a single-column owl-carousel next to a permanently empty
       "client-video" column).
       ========================================================================== */
    .testimonial-section {
        padding: var(--space-12) 0;
        background: var(--surface-0);
    }
    .testimonial-head {
        max-width: 640px;
        margin: 0 auto var(--space-8);
        text-align: center;
    }
    .testimonial-head h2 {
        font-family: var(--font-display);
        font-size: clamp(1.75rem, 3vw, var(--text-4xl));
        font-weight: 800;
        color: var(--text-primary);
        margin: var(--space-2) 0 0;
    }
    .testimonial-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: var(--space-5);
    }
    @media (max-width: 991px) { .testimonial-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 700px) { .testimonial-grid { grid-template-columns: 1fr; } }

    .t-card {
        background: var(--surface-2);
        border: 1px solid var(--surface-border);
        border-radius: var(--radius-lg);
        padding: var(--space-5);
        display: flex;
        flex-direction: column;
        gap: var(--space-4);
    }
    .t-card .t-stars {
        color: var(--brand-gold);
        font-size: var(--text-sm);
        letter-spacing: 2px;
    }
    .t-card .t-quote {
        font-family: var(--font-body);
        font-size: var(--text-base);
        line-height: 1.65;
        color: var(--text-secondary);
        margin: 0;
        flex-grow: 1;
    }
    .t-card .t-person {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        padding-top: var(--space-4);
        border-top: 1px solid var(--surface-border);
    }
    .t-card .t-avatar {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }
    .t-card .t-avatar-fallback {
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
    .t-card .t-person h3 {
        font-family: var(--font-body);
        font-size: var(--text-sm);
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }
    .t-card .t-person span {
        font-size: var(--text-xs);
        color: var(--text-muted);
    }
</style>

<section class="testimonial-section">
    <div class="container">
        <div class="testimonial-head" data-motion="reveal">
            <span class="brand-eyebrow">Customer Stories</span>
            <h2>What Our Customers Say</h2>
        </div>
        <?php if (!empty($reviews)): ?>
        <div class="testimonial-grid" data-motion-group>
            <?php foreach ($reviews as $review):
                $imageName = trim($review['image_name']);
                $initial = strtoupper(substr($review['customer_name'], 0, 1));
            ?>
            <div class="t-card" data-motion="grid-item">
                <div class="t-stars">★★★★★</div>
                <p class="t-quote">&ldquo;<?php echo htmlspecialchars($review['comment']) ?>&rdquo;</p>
                <div class="t-person">
                    <?php if ($imageName): ?>
                        <img class="t-avatar" src="<?php echo htmlspecialchars('admincontent/review/' . $imageName) ?>" alt="<?php echo htmlspecialchars($review['customer_name']) ?>">
                    <?php else: ?>
                        <span class="t-avatar-fallback"><?php echo htmlspecialchars($initial) ?></span>
                    <?php endif; ?>
                    <div>
                        <h3><?php echo htmlspecialchars($review['customer_name']) ?></h3>
                        <span><?php echo htmlspecialchars($review['title']) ?>, <?php echo htmlspecialchars($review['country']) ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
