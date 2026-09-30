<?php
/**
 * header.php
 * ------------------------------------------------------------------
 * Shared <head> + site header, included at the top of every page.
 * This is the direct fix for the original site's inconsistent navbars:
 * there is now exactly one copy of this markup, so every page's nav
 * is guaranteed identical.
 *
 * Each page sets two variables BEFORE including this file:
 *   $pageTitle  (string) — used in <title> and the browser tab
 *   $activeNav  (string) — one of: home | safaris | gallery | reviews | why | contact
 *                          used to highlight the current nav item
 *
 * Example, at the top of a page file:
 *   <?php
 *   $pageTitle = 'Safaris';
 *   $activeNav = 'safaris';
 *   include 'includes/header.php';
 *   ?>
 * ------------------------------------------------------------------
 */

// ---- Fallbacks so header.php never breaks if a page forgets to set these ----
$pageTitle = $pageTitle ?? 'Big Dawg Safaris';
$activeNav = $activeNav ?? '';

/**
 * navClass()
 * Small helper: returns "is-active" when this nav item matches the
 * current page, so we're not repeating if/else ternaries five times
 * in the markup below.
 */
function navClass(string $key, string $activeNav): string
{
    return $key === $activeNav ? 'is-active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($pageTitle); ?> | Big Dawg Safaris</title>
  <meta name="description" content="Kenyan-owned safari journeys with language-aware group matching and private 4x4 safaris.">

  <!-- Google Fonts: Fraunces (headings) + Work Sans (body) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@500;600;700&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Stylesheets, loaded in dependency order: tokens -> reset -> layout -> components -->
  <link rel="stylesheet" href="assets/css/variables.css">
  <link rel="stylesheet" href="assets/css/base.css">
  <link rel="stylesheet" href="assets/css/layout.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>
<body>

<header class="site-header" id="siteHeader">
  <div class="container">

    <!-- Brand / logo -->
    <a href="index.php" class="brand">
      <img src="assets/images/real/big-dawg-logo.jpg" alt="Big Dawg Safaris logo">
      BIG DAWG <span>SAFARIS</span>
    </a>

    <!-- Primary navigation -->
    <nav aria-label="Primary">
      <ul class="nav-list" id="navList">
        <li><a href="index.php" data-i18n="navHome" class="<?php echo navClass('home', $activeNav); ?>">Home</a></li>
        <li><a href="safaris.php" data-i18n="navSafaris" class="<?php echo navClass('safaris', $activeNav); ?>">Safaris</a></li>
        <li><a href="gallery.php" data-i18n="navGallery" class="<?php echo navClass('gallery', $activeNav); ?>">Gallery</a></li>
        <li><a href="reviews.php" data-i18n="navReviews" class="<?php echo navClass('reviews', $activeNav); ?>">Reviews</a></li>
        <li><a href="why-big-dawg.php" data-i18n="navWhy" class="<?php echo navClass('why', $activeNav); ?>">Why Big Dawg</a></li>
        <li><a href="contact.php" class="btn btn-primary" data-i18n="navPlan">Plan My Safari</a></li>
      </ul>
    </nav>

    <div class="header-actions">
      <!-- Language switcher — comfort feature only (see i18n.js), swaps
           on-page text client-side and remembers the choice. -->
      <select class="lang-select" id="langSelect" aria-label="Choose language">
        <option value="en">🇬🇧 English</option>
        <option value="es">🇪🇸 Español</option>
        <option value="it">🇮🇹 Italiano</option>
        <option value="fr">🇫🇷 Français</option>
        <option value="de">🇩🇪 Deutsch</option>
      </select>

      <!-- Mobile nav toggle, hidden on desktop via CSS, wired up in main.js -->
      <button class="nav-toggle" id="navToggle" aria-label="Toggle menu" aria-expanded="false" aria-controls="navList">
        ☰
      </button>
    </div>

  </div>
</header>

<main id="main">
<!-- Page content is written after this include, and closed with </main> before footer.php is included -->
