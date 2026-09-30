/* ==========================================================================
   SAFARIS.JS
   Powers the filter chips on safaris.php. Only loaded on that page
   (see the conditional include in includes/footer.php).

   Filtering happens entirely client-side against the data-category
   attribute already rendered on each card by safaris.php — no page
   reload, no extra request. Categories match the client's own real
   journey categories (short, south, rift, north, coast, beach).
   ========================================================================== */

document.addEventListener('DOMContentLoaded', function () {
  var filterBar = document.getElementById('filterBar');
  var grid = document.getElementById('destinationGrid');
  var noResultsMsg = document.getElementById('noResultsMsg');

  if (!filterBar || !grid) return;

  var chips = filterBar.querySelectorAll('.filter-chip');
  var cards = grid.querySelectorAll('.destination-card');

  chips.forEach(function (chip) {
    chip.addEventListener('click', function () {
      var selectedTag = chip.getAttribute('data-filter');

      // ---- Update active chip styling ----
      chips.forEach(function (c) { c.classList.remove('is-active'); });
      chip.classList.add('is-active');

      // ---- Show/hide cards based on the selected tag ----
      var visibleCount = filterCards(cards, selectedTag);

      // ---- Let the visitor know if a filter genuinely has nothing yet,
      // rather than showing a silently empty grid. ----
      noResultsMsg.style.display = visibleCount === 0 ? 'block' : 'none';
    });
  });
});

/**
 * filterCards(cards, category)
 * Shows every card if category is "all", otherwise only cards whose
 * data-category matches the selected one. Returns how many cards
 * ended up visible, so the caller can show a "no results" message.
 */
function filterCards(cards, category) {
  var visibleCount = 0;

  cards.forEach(function (card) {
    var cardCategory = card.getAttribute('data-category') || '';
    var matches = category === 'all' || cardCategory === category;

    card.style.display = matches ? '' : 'none';
    if (matches) visibleCount++;
  });

  return visibleCount;
}
