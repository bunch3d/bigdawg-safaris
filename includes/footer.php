<?php
/**
 * footer.php
 * ------------------------------------------------------------------
 * Shared site footer + closing scripts, included at the bottom of
 * every page. Pages must close their own </main> tag (opened in
 * header.php) before including this file. Example page skeleton:
 *
 *   <?php include 'includes/header.php'; ?>
 *     ...page content...
 *   </main>
 *   <?php include 'includes/footer.php'; ?>
 * ------------------------------------------------------------------
 */
?>

<footer class="site-footer">
  <div class="container footer-grid">

    <div>
      <p class="brand" style="color:var(--white);margin-bottom:var(--space-2);">BIG DAWG SAFARIS</p>
      <p>Kenyan-owned safari journeys, Kenya circuits and honest pricing.</p>
    </div>

    <div>
      <h4 data-i18n="footerContact">Contact</h4>
      <ul>
        <li><a href="tel:+254114202876">+254 114 202 876</a></li>
        <li><a href="tel:+254797640039">+254 797 640 039</a></li>
        <li><a href="mailto:bigdawgsaf254@gmail.com">bigdawgsaf254@gmail.com</a></li>
      </ul>
    </div>

    <div>
      <h4 data-i18n="footerDestinations">Destinations</h4>
      <ul>
        <li><a href="safaris.php#maasai-mara">Maasai Mara</a></li>
        <li><a href="safaris.php#amboseli">Amboseli</a></li>
        <li><a href="safaris.php#samburu">Samburu</a></li>
        <li><a href="safaris.php#tsavo">Tsavo</a></li>
        <li><a href="safaris.php#lake-nakuru">Lake Nakuru</a></li>
      </ul>
    </div>

    <div>
      <h4 data-i18n="footerFollow">Follow</h4>
      <ul>
        <li><a href="https://instagram.com/BigDawgSafaris254" target="_blank" rel="noopener">Instagram</a></li>
        <li><a href="https://www.tiktok.com/@BigDawgSafaris254" target="_blank" rel="noopener">TikTok</a></li>
      </ul>
    </div>

  </div>

  <div class="container footer-bottom">
    <span>&copy; <?php echo date('Y'); ?> Big Dawg Safaris. All rights reserved.</span>
    <span data-i18n="footerNote">Final itinerary and pricing are confirmed in your quotation.</span>
  </div>
</footer>

<!-- Floating WhatsApp button, present on every page -->
<div class="whatsapp-float">
  <a href="https://wa.me/254797640039?text=Hello%20Big%20Dawg%20Safaris%21%20I%20would%20like%20to%20plan%20a%20Kenya%20safari."
     target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
    💬
  </a>
</div>

<!-- Scripts loaded at the end of body so they never block page rendering -->
<script src="assets/js/main.js"></script>
<script src="assets/js/i18n.js"></script>
<?php if (($activeNav ?? '') === 'reviews'): ?>
<script src="assets/js/reviews.js"></script>
<?php endif; ?>
<?php if (($activeNav ?? '') === 'safaris'): ?>
<script src="assets/js/safaris.js"></script>
<?php endif; ?>
<?php if (($activeNav ?? '') === 'gallery'): ?>
<script src="assets/js/gallery.js"></script>
<?php endif; ?>

</body>
</html>
