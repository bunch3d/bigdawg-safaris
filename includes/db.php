<?php
/**
 * db.php
 * ------------------------------------------------------------------
 * Single MySQLi connection, reused anywhere the site needs the
 * database (currently: reviews.php for reading/writing reviews).
 *
 * TODO before deploying:
 *   - Update the constants below with real credentials for your
 *     environment (local dev vs. live hosting will differ).
 *   - Never commit real production credentials into version control —
 *     consider moving these into environment variables once this
 *     project goes live.
 * ------------------------------------------------------------------
 */

// ---- Connection settings ----
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'bigdawg_safaris');

// ---- Open the connection ----
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// ---- Fail loudly in development, fail quietly (log only) in production ----
if (!$conn) {
    // While building: uncomment the line below to see the real error.
    // die('Database connection failed: ' . mysqli_connect_error());

    // In production this should log to a file instead of dying with
    // a raw error message on-screen.
    error_log('DB connection failed: ' . mysqli_connect_error());
}

// ---- Force UTF-8 so names/reviews with accents (é, ñ, etc.) store correctly ----
mysqli_set_charset($conn, 'utf8mb4');
