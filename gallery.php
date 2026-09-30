<?php
/**
 * gallery.php
 * ------------------------------------------------------------------
 * Photo groups defined as data below rather than hand-placed <img>
 * tags, so every group renders through the same grid markup.
 * Most images now point to real photos migrated from the client's
 * existing site (assets/images/real/) - Samburu and Tsavo currently
 * only have one generic shot each, so add more variety there when
 * you have additional photos for those two parks.
 * ------------------------------------------------------------------
 */

$pageTitle = 'Gallery';
$activeNav = 'gallery';
include 'includes/header.php';

// ---- Gallery groups: one section per park/theme ----
// Mara, Amboseli and Nakuru use real photos already in
// assets/images/real/ (migrated from the client's existing site).
// Samburu and Tsavo only have one generic real photo each so far -
// good enough to avoid a broken image, but worth adding more
// variety once you have additional photos for those two parks.
$galleryGroups = [
    [
        'title'  => 'Maasai Mara — Big Cats & Great Migration',
        'photos' => [
            ['src' => 'assets/images/real/maasai-mara-lion-hd.jpg', 'caption' => 'Lion, Maasai Mara'],
            ['src' => 'assets/images/real/maasai-mara-elephant-hd.jpg', 'caption' => 'Elephant, Maasai Mara'],
            ['src' => 'assets/images/real/maasai-mara-buffalo-hd.jpg', 'caption' => 'Buffalo, Maasai Mara'],
            ['src' => 'assets/images/real/maasai-mara-cheetah-hd.jpg', 'caption' => 'Cheetah, Maasai Mara'],
            ['src' => 'assets/images/real/mara-river-wildebeest-hd.jpg', 'caption' => 'Great Migration, Mara River'],
            ['src' => 'assets/images/real/maasai-mara-zebras-wildebeest-hd.jpg', 'caption' => 'Zebras & Wildebeest, Maasai Mara'],
        ],
    ],
    [
        'title'  => 'Amboseli — Kilimanjaro Views',
        'photos' => [
            ['src' => 'assets/images/real/amboseli-elephants-kilimanjaro-hd.jpg', 'caption' => 'Elephants, Mt Kilimanjaro'],
            ['src' => 'assets/images/real/amboseli-giraffe-kilimanjaro.jpg', 'caption' => 'Maasai giraffe, Amboseli'],
        ],
    ],
    [
        'title'  => 'Samburu — Northern Kenya',
        'photos' => [
            ['src' => 'assets/images/real/photo-samburu.jpg', 'caption' => 'Samburu National Reserve'],
        ],
    ],
    [
        'title'  => 'Tsavo — Red Earth & Wildlife',
        'photos' => [
            ['src' => 'assets/images/real/photo-tsavo.jpg', 'caption' => 'Tsavo National Park'],
        ],
    ],
    [
        'title'  => 'Lake Nakuru — Rhino, Flamingos & Birds',
        'photos' => [
            ['src' => 'assets/images/real/lake-nakuru-rhino.jpg', 'caption' => 'Rhinos, Lake Nakuru'],
            ['src' => 'assets/images/real/lake-nakuru-flamingos.jpg', 'caption' => 'Flamingos, Lake Nakuru'],
        ],
    ],
    [
        'title'  => 'Big Dawg on Safari',
        'photos' => [
            ['src' => 'assets/images/real/big-dawg-safari-vehicle-lion.jpg', 'caption' => 'Big Dawg safari vehicle, Kenya'],
        ],
    ],
];
?>

<section class="section" style="padding-bottom: var(--space-4);">
  <div class="container section-head">
    <span class="kicker">REAL KENYA · WILDLIFE · WILD PLACES</span>
    <h1>Safari Gallery</h1>
    <p>A visual taste of the landscapes and wildlife your Kenya journey can include. Tap any photo to enlarge it.</p>
  </div>
</section>

<?php foreach ($galleryGroups as $group): ?>
  <section class="container" style="padding-bottom: var(--space-6);">
    <h2 style="margin-bottom: var(--space-3); font-size:1.4rem;"><?php echo htmlspecialchars($group['title']); ?></h2>
    <div class="gallery-grid">
      <?php foreach ($group['photos'] as $photo): ?>
        <!-- data-full is what the lightbox (assets/js/gallery.js) opens -->
        <button class="gallery-thumb" data-full="<?php echo htmlspecialchars($photo['src']); ?>" data-caption="<?php echo htmlspecialchars($photo['caption']); ?>">
          <img src="<?php echo htmlspecialchars($photo['src']); ?>" alt="<?php echo htmlspecialchars($photo['caption']); ?>">
        </button>
      <?php endforeach; ?>
    </div>
  </section>
<?php endforeach; ?>

<!-- Lightbox overlay, hidden by default — populated by assets/js/gallery.js -->
<div class="lightbox" id="lightbox" aria-hidden="true">
  <button class="lightbox-close" id="lightboxClose" aria-label="Close">✕</button>
  <img id="lightboxImage" src="" alt="">
  <p id="lightboxCaption"></p>
</div>

</main>
<?php include 'includes/footer.php'; ?>
