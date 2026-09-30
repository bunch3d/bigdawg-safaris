/* ==========================================================================
   GALLERY.JS
   Simple click-to-enlarge lightbox for gallery.php. Only loaded on that
   page (see conditional include in includes/footer.php).
   ========================================================================== */

document.addEventListener('DOMContentLoaded', function () {
  var lightbox = document.getElementById('lightbox');
  var lightboxImage = document.getElementById('lightboxImage');
  var lightboxCaption = document.getElementById('lightboxCaption');
  var closeBtn = document.getElementById('lightboxClose');
  var thumbs = document.querySelectorAll('.gallery-thumb');

  if (!lightbox || !lightboxImage) return;

  // ---- Open lightbox when any thumbnail is clicked ----
  thumbs.forEach(function (thumb) {
    thumb.addEventListener('click', function () {
      openLightbox(thumb.getAttribute('data-full'), thumb.getAttribute('data-caption'));
    });
  });

  // ---- Close via the close button, clicking the dark backdrop, or Escape ----
  closeBtn.addEventListener('click', closeLightbox);
  lightbox.addEventListener('click', function (e) {
    if (e.target === lightbox) closeLightbox();
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeLightbox();
  });

  /**
   * openLightbox(src, caption)
   * Fills in the overlay's image/caption and reveals it.
   */
  function openLightbox(src, caption) {
    lightboxImage.src = src;
    lightboxImage.alt = caption || '';
    lightboxCaption.textContent = caption || '';
    lightbox.classList.add('is-open');
    lightbox.setAttribute('aria-hidden', 'false');
  }

  /**
   * closeLightbox()
   * Hides the overlay and clears the image src so a large photo isn't
   * left loaded in the background.
   */
  function closeLightbox() {
    lightbox.classList.remove('is-open');
    lightbox.setAttribute('aria-hidden', 'true');
    lightboxImage.src = '';
  }
});
