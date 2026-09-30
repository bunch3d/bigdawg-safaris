-- ==========================================================================
-- SCHEMA.SQL
-- Run this once against your MySQL database before using reviews.php.
--   mysql -u root -p bigdawg_safaris < sql/schema.sql
-- (create the database first: CREATE DATABASE bigdawg_safaris;)
-- ==========================================================================

CREATE TABLE IF NOT EXISTS reviews (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  name          VARCHAR(100)  NOT NULL,
  rating        TINYINT       NOT NULL,               -- 1 to 5 stars
  review_text   TEXT          NOT NULL,
  is_approved   TINYINT(1)    NOT NULL DEFAULT 0,      -- 0 = pending, 1 = approved & public
  submitted_at  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,

  CONSTRAINT chk_rating_range CHECK (rating BETWEEN 1 AND 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Optional: a couple of sample approved reviews so reviews.php has
-- something to display right away during development. Safe to delete
-- once real reviews start coming in.
INSERT INTO reviews (name, rating, review_text, is_approved) VALUES
  ('Elena R.', 5, 'Our guide matched us with a Spanish-speaking group and the whole week felt effortless.', 1),
  ('Marco T.', 5, 'Private 4x4 was worth every euro — flexible stops, incredible sightings in the Mara.', 1);
