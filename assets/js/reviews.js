/* ==========================================================================
   REVIEWS.JS
   Only loaded on reviews.php (see conditional include in includes/footer.php).
   The form itself works fine without JavaScript (native HTML5 validation +
   a normal POST) — this just adds a small UX guard against double-submits.
   ========================================================================== */

document.addEventListener('DOMContentLoaded', function () {
  var form = document.getElementById('reviewForm');
  if (!form) return;

  form.addEventListener('submit', function () {
    var submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.textContent = 'Sending...';
    }
    // Note: we don't preventDefault() — the form still submits normally.
    // This just stops a visitor from clicking "Submit" twice while the
    // page reloads.
  });
});
