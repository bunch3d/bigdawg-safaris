<?php
/**
 * reviews.php
 * ------------------------------------------------------------------
 * Submission form -> inserts into MySQL with is_approved = 0.
 * Display list -> only SELECTs rows WHERE is_approved = 1.
 * This is what actually implements the "sent for approval, then
 * appears publicly" promise the original site's copy makes.
 *
 * A basic admin.php (password-gated) to flip is_approved to 1 is the
 * natural next addition — see the project plan.
 * ------------------------------------------------------------------
 */

require_once 'includes/db.php';

$pageTitle = 'Reviews';
$activeNav = 'reviews';

$formError = '';
$formSuccess = false;

// ---- Handle a new review submission ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Honeypot spam trap: a field real visitors never see or fill in
    // (hidden via CSS in the form below). If it's filled, silently
    // pretend success without touching the database — mirrors the
    // "Don't fill this out" trap on the original site.
    $honeypot = trim($_POST['website'] ?? '');

    $name   = trim($_POST['name'] ?? '');
    $rating = (int) ($_POST['rating'] ?? 0);
    $text   = trim($_POST['review_text'] ?? '');

    if ($honeypot !== '') {
        $formSuccess = true; // bots see "success" and move on
    } elseif (!$conn) {
        // Guard against a missing/unreachable database so this fails
        // as a friendly message instead of a fatal PHP error.
        $formError = 'Reviews are temporarily unavailable — please try again shortly, or reach us on WhatsApp.';
    } elseif ($name === '' || $text === '' || $rating < 1 || $rating > 5) {
        $formError = 'Please fill in your name, a star rating, and your review.';
    } else {
        // Prepared statement — never concatenate user input into SQL.
        $stmt = mysqli_prepare($conn, 'INSERT INTO reviews (name, rating, review_text, is_approved) VALUES (?, ?, ?, 0)');
        mysqli_stmt_bind_param($stmt, 'sis', $name, $rating, $text);

        if (mysqli_stmt_execute($stmt)) {
            $formSuccess = true;
        } else {
            $formError = 'Something went wrong submitting your review — please try again.';
        }
        mysqli_stmt_close($stmt);
    }
}

include 'includes/header.php';

// ---- Fetch approved reviews for display ----
$approvedReviews = [];
$result = mysqli_query($conn, 'SELECT name, rating, review_text, submitted_at FROM reviews WHERE is_approved = 1 ORDER BY submitted_at DESC LIMIT 12');
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $approvedReviews[] = $row;
    }
}
?>

<section class="section">
  <div class="container section-head" style="text-align:center; margin-inline:auto;">
    <span class="kicker" data-i18n="reviewsKicker">TRAVELLER FEEDBACK</span>
    <h1 data-i18n="reviewsPageTitle">Reviews &amp; Star Ratings</h1>
    <p data-i18n="reviewsPageText">Tell future travellers about your Big Dawg Safaris experience.</p>
  </div>
</section>

<!-- ============================== SUBMISSION FORM ============================== -->
<section class="container" style="max-width:600px; padding-bottom: var(--space-7);">
  <?php if ($formSuccess): ?>
    <p class="build-notice" style="border-style:solid; border-color:var(--green); background:var(--sand);">
      Thank you! Your review has been sent to Big Dawg Safaris for approval and will appear here once approved.
    </p>
  <?php else: ?>

    <?php if ($formError): ?>
      <p class="build-notice" style="border-color:#b3462c; color:#b3462c;"><?php echo htmlspecialchars($formError); ?></p>
    <?php endif; ?>

    <form method="POST" action="reviews.php#leave-review" id="reviewForm">

      <!-- Honeypot field: hidden from real visitors via CSS, bots fill it in -->
      <div style="position:absolute; left:-9999px;" aria-hidden="true">
        <label for="website">Don't fill this out</label>
        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
      </div>

      <div style="margin-bottom: var(--space-3);">
        <label for="name" style="display:block; margin-bottom: var(--space-1); font-weight:600;">Your name</label>
        <input type="text" id="name" name="name" required
               style="width:100%; padding:0.7rem; border:1px solid var(--line); border-radius:var(--radius-sm);">
      </div>

      <div style="margin-bottom: var(--space-3);">
        <span style="display:block; margin-bottom: var(--space-1); font-weight:600;">Your star rating</span>
        <div id="starRating" class="star-rating">
          <?php for ($i = 5; $i >= 1; $i--): ?>
            <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" <?php echo $i === 5 ? 'checked' : ''; ?>>
            <label for="star<?php echo $i; ?>">★</label>
          <?php endfor; ?>
        </div>
      </div>

      <div style="margin-bottom: var(--space-4);">
        <label for="review_text" style="display:block; margin-bottom: var(--space-1); font-weight:600;">Your review</label>
        <textarea id="review_text" name="review_text" rows="4" required
                  style="width:100%; padding:0.7rem; border:1px solid var(--line); border-radius:var(--radius-sm);"></textarea>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Submit Review</button>

      <p style="font-size:0.8rem; color:var(--muted); margin-top:var(--space-2);">
        Your review is sent to Big Dawg Safaris for approval. Once approved, it appears publicly for future travellers to see.
      </p>
    </form>
  <?php endif; ?>
</section>

<!-- ============================== APPROVED REVIEWS ============================== -->
<section class="section" style="background: var(--sand);">
  <div class="container">
    <div class="section-head">
      <span class="kicker">WHAT TRAVELLERS SAY</span>
      <h2>Guest reviews</h2>
    </div>

    <?php if (empty($approvedReviews)): ?>
      <p class="build-notice">No approved reviews yet — be the first to leave one above.</p>
    <?php else: ?>
      <div class="cards-grid">
        <?php foreach ($approvedReviews as $review): ?>
          <div class="review-highlight">
            <p><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
            <p class="review-author">
              — <?php echo htmlspecialchars($review['name']); ?>
              &nbsp;<?php echo str_repeat('★', (int) $review['rating']); ?>
            </p>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

</main>
<?php include 'includes/footer.php'; ?>
