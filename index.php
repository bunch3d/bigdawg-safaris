<?php
/**
 * index.php — Home page
 * ------------------------------------------------------------------
 * Fixes the original home page's "hero then empty space" problem by
 * pulling content forward: hero -> trust badges -> featured journeys
 * -> a review highlight -> condensed why-us -> CTA banner -> footer.
 * Nothing here is left as a mostly-empty placeholder tab.
 * ------------------------------------------------------------------
 */

require_once 'data/destinations.php';

$pageTitle = 'Home';
$activeNav = 'home';
include 'includes/header.php';

// ---- Pull 3 destinations for the "Featured Journeys" section ----
$featured = getFeaturedJourneys(3);
?>

<!-- ============================== HERO ============================== -->
<section class="hero">
  <div class="container">

    <div class="hero-copy">
      <span class="kicker" data-i18n="heroKicker">KENYAN-OWNED · LOCAL EXPERTISE · EUROPEAN-FRIENDLY SERVICE</span>
      <h1>
        <span data-i18n="heroLine1">Your Kenya.</span><br>
        <span class="line-accent" data-i18n="heroLine2">Your Language.</span><br>
        <span data-i18n="heroLine3">Your Safari.</span>
      </h1>
      <p class="hero-text" data-i18n="heroText">
        Thoughtfully routed Kenya journeys with local safari expertise, language-aware group matching and private 4x4 options.
      </p>

      <div class="hero-actions">
        <a href="safaris.php" class="btn btn-primary" data-i18n="ctaExplore">Explore Safaris</a>
        <a href="contact.php" class="btn btn-secondary" data-i18n="ctaPlan">Plan My Safari</a>
      </div>

      <p class="hero-contact">
        📞 +254 114 202 876 &nbsp;•&nbsp; +254 797 640 039 &nbsp;•&nbsp;
        ✉️ bigdawgsaf254@gmail.com
      </p>
    </div>

    <div class="hero-media">
      <div class="hero-photo">
        <!-- Placeholder path — Kish to add the real hero photo here -->
        <img src="assets/images/real/maasai-mara-lion.jpg" alt="Zebras and wildlife on a Kenyan safari">
      </div>
    </div>

  </div>
</section>

<!-- ============================== TRUST BADGES ============================== -->
<section class="badges-strip">
  <div class="container">
    <div class="badge-item"><span class="badge-icon">🇰🇪</span><span data-i18n="badgeOwned">Kenyan-Owned</span></div>
    <div class="badge-item"><span class="badge-icon">🌍</span><span data-i18n="badgeLanguages">5 Website Languages</span></div>
    <div class="badge-item"><span class="badge-icon">🚙</span><span data-i18n="badgePrivate">Private 4x4 Options</span></div>
    <div class="badge-item"><span class="badge-icon">✈️</span><span data-i18n="badgeTransfer">Airport Transfer Included</span></div>
    <div class="badge-item"><span class="badge-icon">🦁</span><span data-i18n="badgeGuides">Local Safari Guides</span></div>
  </div>
</section>

<!-- ============================== FEATURED JOURNEYS ============================== -->
<section class="section">
  <div class="container">
    <div class="section-head">
      <span class="kicker" data-i18n="featuredKicker">SIGNATURE JOURNEYS</span>
      <h2 data-i18n="featuredTitle">A few favourite places to start</h2>
      <p data-i18n="featuredText">Short safaris, regional circuits and longer journeys designed around Kenya's geography.</p>
    </div>

    <div class="cards-grid">
      <?php foreach ($featured as $dest): ?>
        <!-- One card per journey in data/destinations.php — same markup, so
             cards can never drift out of alignment with each other. -->
        <article class="destination-card" id="<?php echo htmlspecialchars($dest['slug']); ?>">
          <div class="card-image">
            <img src="<?php echo htmlspecialchars($dest['image']); ?>" alt="<?php echo htmlspecialchars($dest['name']); ?>">
          </div>
          <div class="card-body">
            <h3><?php echo htmlspecialchars($dest['name']); ?></h3>
            <div class="card-tags">
              <span class="tag-chip"><?php echo htmlspecialchars($dest['tag']); ?></span>
              <span class="tag-chip"><?php echo (int) $dest['days']; ?> days</span>
            </div>
            <p class="card-blurb"><?php echo htmlspecialchars($dest['route']); ?></p>

            <!-- Group / Private / Luxury tier row, kept as requested -->
            <div class="tier-row">
              <div class="tier">
                <span class="tier-label">Group</span>
                <span class="tier-price"><?php echo $dest['price']['group'] !== null ? '€' . (int) $dest['price']['group'] : 'On request'; ?></span>
              </div>
              <div class="tier">
                <span class="tier-label">Private</span>
                <span class="tier-price"><?php echo $dest['price']['private'] !== null ? '€' . (int) $dest['price']['private'] : 'On request'; ?></span>
              </div>
              <div class="tier">
                <span class="tier-label">Luxury</span>
                <span class="tier-price"><?php echo $dest['price']['luxury'] !== null ? '€' . (int) $dest['price']['luxury'] : 'On request'; ?></span>
              </div>
            </div>

            <a href="safaris.php#<?php echo htmlspecialchars($dest['slug']); ?>" class="btn btn-secondary btn-block card-cta">View journey</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <div style="text-align:center; margin-top: var(--space-5);">
      <a href="safaris.php" class="btn btn-primary" data-i18n="viewAllSafaris">View all safaris</a>
    </div>
  </div>
</section>

<!-- ============================== REVIEW HIGHLIGHT ============================== -->
<section class="section" style="background: var(--sand);">
  <div class="container">
    <div class="section-head" style="margin-inline:auto; text-align:center;">
      <span class="kicker" data-i18n="reviewsKicker">TRAVELLER FEEDBACK</span>
      <h2 data-i18n="reviewsTitle">What travellers say</h2>
    </div>

    <!--
      Placeholder testimonial. Once reviews.php + the MySQL table are wired
      up, replace this with a query for the most recent approved review
      (see sql/schema.sql) instead of hardcoding one here.
    -->
    <div class="review-highlight" style="max-width:700px; margin-inline:auto;">
      <p>"Our guide matched us with a Spanish-speaking group and the whole week felt easy — incredible sightings in the Mara too."</p>
      <p class="review-author">— Example placeholder review, pending live data</p>
    </div>
  </div>
</section>

<!-- ============================== WHY BIG DAWG (condensed) ============================== -->
<section class="section">
  <div class="container">
    <div class="section-head">
      <span class="kicker" data-i18n="whyKicker">WHY BIG DAWG</span>
      <h2 data-i18n="whyTitle">Practical reasons to travel with us</h2>
    </div>

    <div class="cards-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
      <div class="why-point">
        <span class="why-number">1</span>
        <div>
          <h3 data-i18n="whyPoint1Title">Your Language, Your Comfort</h3>
          <p data-i18n="whyPoint1Text">Matched by language where possible, for easier communication and a better group fit.</p>
        </div>
      </div>
      <div class="why-point">
        <span class="why-number">2</span>
        <div>
          <h3 data-i18n="whyPoint2Title">Private 4x4 Land Cruiser</h3>
          <p data-i18n="whyPoint2Text">Pop-up roof vehicle with your own driver-guide, for group or private trips.</p>
        </div>
      </div>
      <div class="why-point">
        <span class="why-number">3</span>
        <div>
          <h3 data-i18n="whyPoint3Title">Honest Pricing</h3>
          <p data-i18n="whyPoint3Text">Group, Private or Luxury — no hidden fees, clear starting prices.</p>
        </div>
      </div>
    </div>

    <div style="text-align:center; margin-top: var(--space-5);">
      <a href="why-big-dawg.php" data-i18n="seeWhyLink">See why travellers choose us →</a>
    </div>
  </div>
</section>

<!-- ============================== CTA BANNER ============================== -->
<section class="cta-banner">
  <div class="container">
    <h2 data-i18n="ctaBannerTitle">Let's plan your Kenya</h2>
    <p data-i18n="ctaBannerText">For availability, language matching and final pricing, tell us how you want to travel.</p>
    <a href="contact.php" class="btn btn-primary" data-i18n="ctaBannerButton">Plan My Safari</a>
  </div>
</section>

</main>
<?php include 'includes/footer.php'; ?>
