/* ==========================================================================
   MAIN.JS
   Small, dependency-free interactions shared by every page:
   - mobile nav toggle
   - header shadow after scrolling
   Loaded on every page via includes/footer.php.
   ========================================================================== */

document.addEventListener('DOMContentLoaded', function () {
  initMobileNav();
  initHeaderScrollShadow();
});

/**
 * initMobileNav()
 * Toggles the .is-open class on the nav list when the hamburger
 * button is clicked, and keeps aria-expanded in sync for screen
 * readers. Guarded with null checks so this never throws on a page
 * that, for some reason, doesn't have the header markup.
 */
function initMobileNav() {
  var toggle = document.getElementById('navToggle');
  var navList = document.getElementById('navList');

  if (!toggle || !navList) return;

  toggle.addEventListener('click', function () {
    var isOpen = navList.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  });

  // Close the mobile menu automatically after a link is tapped,
  // so navigating doesn't leave the menu open on the next page.
  navList.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function () {
      navList.classList.remove('is-open');
      toggle.setAttribute('aria-expanded', 'false');
    });
  });
}

/**
 * initHeaderScrollShadow()
 * Adds a subtle shadow to the sticky header once the page has
 * scrolled past a small threshold, so the header doesn't sit flat
 * against page content indefinitely.
 */
function initHeaderScrollShadow() {
  var header = document.getElementById('siteHeader');
  if (!header) return;

  var SCROLL_THRESHOLD = 12; // px

  window.addEventListener('scroll', function () {
    if (window.scrollY > SCROLL_THRESHOLD) {
      header.classList.add('is-scrolled');
    } else {
      header.classList.remove('is-scrolled');
    }
  });
}
