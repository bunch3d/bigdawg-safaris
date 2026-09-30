<?php
/**
 * destinations.php
 * ------------------------------------------------------------------
 * Central data source for every journey shown on the site.
 *
 * CORRECTED VERSION: the previous version of this file (5 generic
 * parks with invented round-number prices) was placeholder data
 * written before the client's real catalog was available. This
 * version uses the ACTUAL 28-journey catalog and real EUR pricing
 * pulled from the client's existing Netlify site (its client-side
 * PRODUCTS array), so prices shown here match what the business
 * actually quotes.
 *
 * safaris.php loops over getJourneys() to render cards, and
 * index.php's "Featured Journeys" pulls a handful via
 * getFeaturedJourneys() — same pattern as before, just backed by
 * real data now.
 * ------------------------------------------------------------------
 */

// ---- Human-readable labels for each journey category ----
// These match the client's own categorisation from their live site.
function getCategories(): array
{
    return [
        'all'     => 'All',
        'short'   => 'Short Safaris',
        'south'   => 'Southern Circuit',
        'rift'    => 'Rift Valley',
        'north'   => 'Northern Kenya',
        'coast'   => 'Kenyan Coast',
        'beach'   => 'Safari + Beach',
        'classic' => 'Classic Kenya',
    ];
}

// ---- Turn a journey name into a URL/DOM-safe slug ----
// e.g. "3 Days Maasai Mara" -> "3-days-maasai-mara"
function slugify(string $text): string
{
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

// ---- Pick the right real photo for a journey ----
// Mirrors the client's own photoFor() keyword-matching logic from
// their live site, so each journey card shows a photo of a place
// that's actually on its route rather than a random stock shot.
// Falls back to a Maasai Mara shot (their signature destination)
// when nothing else matches, same as the original.
function photoFor(string $name, string $route): string
{
    $n = strtolower($name . ' ' . $route);
    $base = 'assets/images/real/';

    if (str_contains($n, 'malindi'))                             return $base . 'photo-malindi.jpg';
    if (str_contains($n, 'watamu'))                              return $base . 'photo-watamu.jpg';
    if (str_contains($n, 'diani') || str_contains($n, 'coast'))  return $base . 'photo-diani.jpg';
    if (str_contains($n, 'mombasa'))                             return $base . 'photo-mombasa.jpg';
    if (str_contains($n, 'samburu') || str_contains($n, 'northern')) return $base . 'photo-samburu.jpg';
    if (str_contains($n, 'ol pejeta') || str_contains($n, 'laikipia')) return $base . 'photo-olpejeta.jpg';
    if (str_contains($n, 'nakuru'))                              return $base . 'photo-nakuru.jpg';
    if (str_contains($n, 'naivasha'))                            return $base . 'photo-naivasha.jpg';
    if (str_contains($n, 'tsavo'))                               return $base . 'photo-tsavo.jpg';
    if (str_contains($n, 'amboseli'))                            return $base . 'photo-amboseli.jpg';
    return $base . 'photo-mara.jpg';
}

// ---- The real journey catalog ----
// group/private/luxury are EUR per person, starting prices.
// null means "quote on request" (long/specialist circuits the
// client prices individually) - handled in safaris.php's display.
function getJourneys(): array
{
    $raw = [
        ['name' => '3 Days Maasai Mara',                    'cat' => 'short',   'days' => 3,  'route' => 'Nairobi → Maasai Mara → Nairobi',                                         'tag' => 'Big Five',              'group' => 590,  'private' => 795,  'luxury' => 1395],
        ['name' => '3 Days Amboseli',                        'cat' => 'short',   'days' => 3,  'route' => 'Nairobi → Amboseli → Nairobi',                                            'tag' => 'Kilimanjaro',           'group' => 550,  'private' => 695,  'luxury' => 1095],
        ['name' => '3 Days Samburu',                         'cat' => 'short',   'days' => 3,  'route' => 'Nairobi → Samburu → Nairobi',                                             'tag' => 'Northern Kenya',        'group' => 650,  'private' => 795,  'luxury' => 1195],
        ['name' => '4 Days Amboseli + Tsavo East',           'cat' => 'south',   'days' => 4,  'route' => 'Nairobi → Amboseli → Tsavo East',                                         'tag' => 'Elephants',             'group' => 695,  'private' => 895,  'luxury' => 1395],
        ['name' => '4 Days Amboseli + Tsavo East & West',    'cat' => 'south',   'days' => 4,  'route' => 'Nairobi → Amboseli → Tsavo West → Tsavo East',                            'tag' => 'Southern Wilderness',   'group' => 795,  'private' => 995,  'luxury' => 1495],
        ['name' => '4 Days Nakuru + Mara',                   'cat' => 'rift',    'days' => 4,  'route' => 'Nairobi → Nakuru → Maasai Mara',                                          'tag' => 'Rift Valley',           'group' => 690,  'private' => 895,  'luxury' => 1395],
        ['name' => '5 Days Naivasha + Nakuru + Mara',        'cat' => 'rift',    'days' => 5,  'route' => 'Nairobi → Naivasha → Nakuru → Maasai Mara',                                'tag' => 'Classic Rift Valley',   'group' => 795,  'private' => 1095, 'luxury' => 1595],
        ['name' => '5 Days Samburu + Ol Pejeta',             'cat' => 'north',   'days' => 5,  'route' => 'Nairobi → Samburu → Ol Pejeta',                                           'tag' => 'Rhino & North',         'group' => 995,  'private' => 1295, 'luxury' => 1695],
        ['name' => '5 Days Amboseli + Tsavo',                'cat' => 'south',   'days' => 5,  'route' => 'Nairobi → Amboseli → Tsavo',                                              'tag' => 'Giants of Kenya',       'group' => 895,  'private' => 1195, 'luxury' => 1695],
        ['name' => '6 Days Mara Explorer',                   'cat' => 'rift',    'days' => 6,  'route' => 'Nairobi → Maasai Mara → Nairobi',                                         'tag' => 'More Mara',             'group' => 1050, 'private' => 1395, 'luxury' => 2295],
        ['name' => '6 Days Kenya Coast Explorer',            'cat' => 'coast',   'days' => 6,  'route' => 'Mombasa → Diani → Watamu → Malindi',                                      'tag' => 'Indian Ocean',          'group' => 795,  'private' => 1095, 'luxury' => 1595],
        ['name' => '6 Days Amboseli + Tsavo + Diani',        'cat' => 'beach',   'days' => 6,  'route' => 'Nairobi → Amboseli → Tsavo → Diani',                                      'tag' => 'Safari + Beach',        'group' => 1050, 'private' => 1395, 'luxury' => 1995],
        ['name' => '7 Days Kenya Classic',                   'cat' => 'classic', 'days' => 7,  'route' => 'Nairobi → Naivasha → Nakuru → Maasai Mara → Nairobi',                     'tag' => 'First Kenya',           'group' => 1050, 'private' => 1595, 'luxury' => 2095],
        ['name' => '7 Days Rift Valley + Mara',              'cat' => 'rift',    'days' => 7,  'route' => 'Nairobi → Naivasha → Nakuru → Maasai Mara',                               'tag' => 'Wildlife & Landscapes', 'group' => 1050, 'private' => 1395, 'luxury' => 1995],
        ['name' => '7 Days Southern Wilderness',             'cat' => 'south',   'days' => 7,  'route' => 'Nairobi → Amboseli → Tsavo West → Tsavo East → Coast',                    'tag' => 'Safari to Sea',         'group' => null, 'private' => null, 'luxury' => null],
        ['name' => '7 Days Northern Frontier',               'cat' => 'north',   'days' => 7,  'route' => 'Nairobi → Ol Pejeta → Laikipia → Samburu',                                'tag' => 'Northern Kenya',        'group' => null, 'private' => null, 'luxury' => null],
        ['name' => '7 Days Diani + Mombasa + Watamu',        'cat' => 'coast',   'days' => 7,  'route' => 'Diani → Mombasa → Watamu',                                                'tag' => 'Coast Explorer',        'group' => 895,  'private' => 1295, 'luxury' => 1895],
        ['name' => '8 Days Kenya Discovery',                 'cat' => 'classic', 'days' => 8,  'route' => 'Nairobi → Amboseli → Naivasha → Nakuru → Maasai Mara → Nairobi',          'tag' => 'More Kenya',            'group' => 1250, 'private' => 1795, 'luxury' => 2395],
        ['name' => '8 Days Mara + Amboseli + Diani',         'cat' => 'beach',   'days' => 8,  'route' => 'Maasai Mara → Amboseli → Diani',                                          'tag' => 'Safari + Beach',        'group' => 1395, 'private' => null, 'luxury' => null],
        ['name' => '10 Days Safari to Sea',                  'cat' => 'beach',   'days' => 10, 'route' => 'Maasai Mara → Amboseli → Tsavo → Diani',                                  'tag' => 'Cats → Elephants → Ocean', 'group' => null, 'private' => null, 'luxury' => null],
        ['name' => '10 Days Grand Kenya',                    'cat' => 'classic', 'days' => 10, 'route' => 'Nairobi → Samburu → Ol Pejeta → Nakuru → Naivasha → Maasai Mara → Nairobi', 'tag' => 'Grand Circuit',       'group' => 1650, 'private' => 2195, 'luxury' => 2995],
        ['name' => '10 Days Kenya Classic + Diani',          'cat' => 'beach',   'days' => 10, 'route' => 'Nairobi → Amboseli → Naivasha → Nakuru → Maasai Mara → Diani',            'tag' => 'Safari + Beach',        'group' => 1695, 'private' => null, 'luxury' => null],
        ['name' => '12 Days Grand North → South',            'cat' => 'classic', 'days' => 12, 'route' => 'Nairobi → Samburu → Ol Pejeta → Nakuru → Naivasha → Maasai Mara → Amboseli → Nairobi', 'tag' => 'Signature Circuit', 'group' => null, 'private' => null, 'luxury' => null],
        ['name' => '12 Days Grand Kenya + Coast',            'cat' => 'beach',   'days' => 12, 'route' => 'Northern Kenya → Rift Valley → Maasai Mara → Amboseli → Diani',           'tag' => 'Wildlife to Ocean',     'group' => 2095, 'private' => null, 'luxury' => null],
        ['name' => '14 Days Ultimate Kenya',                 'cat' => 'classic', 'days' => 14, 'route' => 'Northern Kenya → Rift Valley → Maasai Mara → Amboseli → Tsavo → Diani',   'tag' => 'Ultimate Kenya',        'group' => null, 'private' => null, 'luxury' => null],
        ['name' => '16 Days Full Kenya Discovery',           'cat' => 'classic', 'days' => 16, 'route' => 'Nairobi → Samburu → Ol Pejeta → Nakuru → Naivasha → Maasai Mara → Amboseli → Tsavo → Diani → Watamu/Malindi', 'tag' => 'Complete Kenya', 'group' => null, 'private' => null, 'luxury' => null],
        ['name' => '3 Days Diani Beach Escape',              'cat' => 'coast',   'days' => 3,  'route' => 'Mombasa → Diani → Mombasa',                                               'tag' => 'Beach Escape',          'group' => 450,  'private' => 595,  'luxury' => 895],
        ['name' => '4 Days Diani Beach',                     'cat' => 'coast',   'days' => 4,  'route' => 'Diani Beach',                                                             'tag' => 'Indian Ocean',          'group' => 550,  'private' => 695,  'luxury' => 1095],
        ['name' => '4 Days Mombasa + Diani',                 'cat' => 'coast',   'days' => 4,  'route' => 'Mombasa → Diani',                                                         'tag' => 'Coast & Culture',       'group' => 595,  'private' => 795,  'luxury' => 1195],
        ['name' => '5 Days Watamu + Malindi',                'cat' => 'coast',   'days' => 5,  'route' => 'Watamu → Malindi',                                                        'tag' => 'Marine Coast',          'group' => 650,  'private' => 895,  'luxury' => 1295],
        ['name' => '5 Days Mombasa + Diani',                 'cat' => 'coast',   'days' => 5,  'route' => 'Mombasa → Diani',                                                         'tag' => 'Beach & History',       'group' => 695,  'private' => 895,  'luxury' => 1395],
    ];

    // ---- Enrich each raw entry with a slug, image, and structured price array ----
    return array_map(function ($j) {
        $j['slug']  = slugify($j['name']);
        $j['image'] = photoFor($j['name'], $j['route']);
        $j['price'] = [
            'group'   => $j['group'],
            'private' => $j['private'],
            'luxury'  => $j['luxury'],
        ];
        return $j;
    }, $raw);
}

/**
 * getFeaturedJourneys()
 * Small helper for the home page - the three signature short
 * safaris (Mara, Amboseli, Samburu), matching what the client's
 * own site treats as its headline journeys.
 */
function getFeaturedJourneys(int $count = 3): array
{
    $journeys = array_filter(getJourneys(), fn($j) => $j['cat'] === 'short');
    return array_slice(array_values($journeys), 0, $count);
}
