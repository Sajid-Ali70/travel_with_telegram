-- Replace the application date with National Identity/Aadhaar Card.
-- Existing apply_date values are preserved as text during the column rename.

ALTER TABLE `app_visa_requests`
CHANGE COLUMN `apply_date` `national_identity` VARCHAR(100) NULL DEFAULT NULL AFTER `id`;