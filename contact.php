<?php
$pageTitle = 'Contact';
$activeNav = 'contact';
include 'includes/header.php';

// ---- If this page was reached from a "Enquire about this trip" link on
// safaris.php, pre-fill the journey field so the visitor doesn't have to
// retype what they already picked. ----
$prefilledJourney = isset($_GET['journey']) ? trim($_GET['journey']) : '';
?>

<section class="section">
  <div class="container section-head">
    <span class="kicker">BOOKING ENQUIRY</span>
    <h1>Tell us how you want to travel</h1>
    <p>We'll use your preferred language and trip style to prepare the right Kenya journey. Submitting sends your details to us directly on WhatsApp — nothing is stored on a server.</p>
  </div>

  <div class="container" style="max-width:640px;">
    <form id="bookingForm">

      <div style="margin-bottom: var(--space-3);">
        <label for="fullName" style="display:block; margin-bottom:var(--space-1); font-weight:600;">Full name</label>
        <input type="text" id="fullName" name="fullName" required
               style="width:100%; padding:0.7rem; border:1px solid var(--line); border-radius:var(--radius-sm);">
      </div>

      <div style="margin-bottom: var(--space-3);">
        <label for="phone" style="display:block; margin-bottom:var(--space-1); font-weight:600;">WhatsApp / Phone</label>
        <input type="tel" id="phone" name="phone" required
               style="width:100%; padding:0.7rem; border:1px solid var(--line); border-radius:var(--radius-sm);">
      </div>

      <div style="margin-bottom: var(--space-3);">
        <label for="country" style="display:block; margin-bottom:var(--space-1); font-weight:600;">Country</label>
        <input type="text" id="country" name="country"
               style="width:100%; padding:0.7rem; border:1px solid var(--line); border-radius:var(--radius-sm);">
      </div>

      <div style="display:flex; gap:var(--space-3); margin-bottom: var(--space-3);">
        <div style="flex:1;">
          <label for="travelDate" style="display:block; margin-bottom:var(--space-1); font-weight:600;">Travel date</label>
          <input type="date" id="travelDate" name="travelDate"
                 style="width:100%; padding:0.7rem; border:1px solid var(--line); border-radius:var(--radius-sm);">
        </div>
        <div style="flex:1;">
          <label for="travellers" style="display:block; margin-bottom:var(--space-1); font-weight:600;">Travellers</label>
          <input type="number" id="travellers" name="travellers" min="1" value="2"
                 style="width:100%; padding:0.7rem; border:1px solid var(--line); border-radius:var(--radius-sm);">
        </div>
      </div>

      <div style="margin-bottom: var(--space-3);">
        <label for="experience" style="display:block; margin-bottom:var(--space-1); font-weight:600;">Experience</label>
        <select id="experience" name="experience"
                style="width:100%; padding:0.7rem; border:1px solid var(--line); border-radius:var(--radius-sm);">
          <option>Join a Group</option>
          <option>Private Safari</option>
          <option>Luxury Private</option>
        </select>
      </div>

      <div style="margin-bottom: var(--space-3);">
        <label for="language" style="display:block; margin-bottom:var(--space-1); font-weight:600;">Preferred language</label>
        <select id="language" name="language"
                style="width:100%; padding:0.7rem; border:1px solid var(--line); border-radius:var(--radius-sm);">
          <option>English</option>
          <option>Español</option>
          <option>Italiano</option>
          <option>Français</option>
          <option>Deutsch</option>
        </select>
      </div>

      <div style="margin-bottom: var(--space-3);">
        <label for="journey" style="display:block; margin-bottom:var(--space-1); font-weight:600;">Journey you're interested in</label>
        <input type="text" id="journey" name="journey" value="<?php echo htmlspecialchars($prefilledJourney); ?>"
               placeholder="e.g. Maasai Mara, Grand Kenya Circuit"
               style="width:100%; padding:0.7rem; border:1px solid var(--line); border-radius:var(--radius-sm);">
      </div>

      <div style="margin-bottom: var(--space-3);">
        <label for="accommodation" style="display:block; margin-bottom:var(--space-1); font-weight:600;">Accommodation preference</label>
        <select id="accommodation" name="accommodation"
                style="width:100%; padding:0.7rem; border:1px solid var(--line); border-radius:var(--radius-sm);">
          <option>Comfort / mid-range</option>
          <option>Premium</option>
          <option>Mix of comfort &amp; premium</option>
        </select>
      </div>

      <div style="margin-bottom: var(--space-4);">
        <label for="notes" style="display:block; margin-bottom:var(--space-1); font-weight:600;">Special requests</label>
        <textarea id="notes" name="notes" rows="3"
                  style="width:100%; padding:0.7rem; border:1px solid var(--line); border-radius:var(--radius-sm);"></textarea>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Send Enquiry on WhatsApp</button>
    </form>
  </div>
</section>

</main>
<script src="assets/js/contact.js"></script>
<?php include 'includes/footer.php'; ?>
