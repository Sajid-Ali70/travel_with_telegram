ALTER TABLE `app_visa_requests`
  ADD COLUMN `driving_license_available` VARCHAR(10) NULL DEFAULT NULL AFTER `visa_type`;

-- Example data update:
-- UPDATE `app_visa_requests` SET `driving_license_available` = 'yes' WHERE `visa_type` LIKE '%driver%';
