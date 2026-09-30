<?php
/**
 * safaris.php
 * ------------------------------------------------------------------
 * The page the rebuild is most about fixing: the original's journeys
 * were arranged as one giant scrolling grid plus one giant pricing
 * table. Here:
 *   - Every journey is one consistent card (from data/destinations.php)
 *   - Filter chips narrow by the client's own real categories -
 *     Short Safaris, Southern Circuit, Rift Valley, Northern Kenya,
 *     Kenyan Coast, Safari + Beach - instead of scrolling everything
 *   - Pricing lives per-card as compact Group/Private/Luxury tiers;
 *     journeys the client only quotes individually show "On request"
 *     instead of a fabricated number
 *   - The longer multi-park "Classic Kenya" journeys get their own
 *     section below as named circuits, since they're a different
 *     kind of product (a full circuit, not a single stop)
 * ------------------------------------------------------------------
 */

require_once 'data/destinations.php';

$pageTitle = 'Safaris';
$activeNav = 'safaris';
include 'includes/header.php';

$allJourneys = getJourneys();
$categories  = getCategories();

// ---- Split into the main grid vs. the "Classic Kenya" circuits ----
// Classic-category journeys are the long, multi-park round trips -
// shown as their own circuits section rather than mixed into the
// main grid, same idea as the original's separate circuits section.
$mainJourneys = array_values(array_filter($allJourneys, fn($j) => $j['cat'] !== 'classic'));
$circuits     = array_values(array_filter($allJourneys, fn($j) => $j['cat'] === 'classic'));

// ---- Small helper: render one price tier, or "On request" if null ----
function renderTier(string $label, ?int $amount): string
{
    $value = $amount !== null ? '€' . (int) $amount : 'On request';
    return '<div class="tier"><span class="tier-label">' . htmlspecialchars($label) . '</span>'
         . '<span class="tier-price">' . htmlspecialchars($value) . '</span></div>';
}
?>

<!-- ============================== PAGE HEADER ============================== -->
<section class="section" style="padding-bottom: var(--space-4);">
  <div class="container section-head">
    <span class="kicker" data-i18n="safarisKicker">BIG DAWG JOURNEYS</span>
    <h1 data-i18n="safarisTitle">Safaris</h1>
    <p data-i18n="safarisText">Short safaris, regional circuits and longer journeys designed around Kenya's geography. Filter by what matters most to you.</p>
  </div>
</section>

<!-- ============================== FILTER CHIPS ============================== -->
<!-- Categories match the client's own real journey categories, not
     invented tags - so "Kenyan Coast" here is the same grouping the
     business actually quotes under. -->
<section class="container" style="padding-bottom: var(--space-4);">
  <div class="filter-bar" id="filterBar" role="group" aria-label="Filter journeys by category">
    <?php foreach ($categories as $key => $label): ?>
      <button class="filter-chip <?php echo $key === 'all' ? 'is-active' : ''; ?>" data-filter="<?php echo htmlspecialchars($key); ?>">
        <?php echo htmlspecialchars($label); ?>
      </button>
    <?php endforeach; ?>
  </div>
</section>

<!-- ============================== JOURNEY GRID ============================== -->
<section class="container" style="padding-bottom: var(--space-7);">
  <div class="cards-grid" id="destinationGrid">
    <?php foreach ($mainJourneys as $journey): ?>
      <article class="destination-card" id="<?php echo htmlspecialchars($journey['slug']); ?>"
                data-category="<?php echo htmlspecialchars($journey['cat']); ?>">
        <div class="card-image">
          <img src="<?php echo htmlspecialchars($journey['image']); ?>" alt="<?php echo htmlspecialchars($journey['name']); ?>">
        </div>
        <div class="card-body">
          <h3><?php echo htmlspecialchars($journey['name']); ?></h3>
          <p class="card-blurb" style="color:var(--muted); font-size:0.85rem; margin:0;">
            <?php echo htmlspecialchars($journey['route']); ?>
          </p>
          <div class="card-tags">
            <span class="tag-chip"><?php echo htmlspecialchars($journey['tag']); ?></span>
            <span class="tag-chip"><?php echo (int) $journey['days']; ?> days</span>
          </div>

          <div class="tier-row">
            <?php
              echo renderTier('Group', $journey['price']['group']);
              echo renderTier('Private', $journey['price']['private']);
              echo renderTier('Luxury', $journey['price']['luxury']);
            ?>
          </div>

          <a href="contact.php?journey=<?php echo urlencode($journey['name']); ?>" class="btn btn-primary btn-block card-cta">Enquire about this trip</a>
        </div>
      </article>
    <?php endforeach; ?>
  </div>

  <!-- Shown by safaris.js only if a filter matches nothing -->
  <p id="noResultsMsg" class="build-notice" style="display:none; text-align:center;">
    No journeys match that filter yet — try "All" or get in touch and we'll plan something custom.
  </p>
</section>

<!-- ============================== CIRCUITS (Classic Kenya) ============================== -->
<section class="section" style="background: var(--sand);">
  <div class="container">
    <div class="section-head">
      <span class="kicker" data-i18n="circuitsKicker">MULTI-PARK ROUTES</span>
      <h2 data-i18n="circuitsTitle">Real Circuits</h2>
      <p data-i18n="circuitsText">Longer journeys that progress across Kenya without unnecessary backtracking. Where a domestic flight saves a long repetitive transfer, the final quote can use flying instead.</p>
    </div>

    <div class="cards-grid" style="grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));">
      <?php foreach ($circuits as $circuit): ?>
        <div class="destination-card">
          <div class="card-image">
            <img src="<?php echo htmlspecialchars($circuit['image']); ?>" alt="<?php echo htmlspecialchars($circuit['name']); ?>">
          </div>
          <div class="card-body">
            <h3><?php echo htmlspecialchars($circuit['name']); ?></h3>
            <p class="card-blurb" style="color:var(--muted); font-size:0.85rem;"><?php echo htmlspecialchars($circuit['route']); ?></p>
            <div class="tier-row">
              <?php
                echo renderTier('Group', $circuit['price']['group']);
                echo renderTier('Private', $circuit['price']['private']);
                echo renderTier('Luxury', $circuit['price']['luxury']);
              ?>
            </div>
            <a href="contact.php?journey=<?php echo urlencode($circuit['name']); ?>" class="btn btn-secondary btn-block card-cta">Ask about this circuit</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

</main>
<?php include 'includes/footer.php'; ?>
