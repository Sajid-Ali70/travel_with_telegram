ALTER TABLE `app_countries`
  ADD COLUMN `visa_fee` DECIMAL(12,2) NULL DEFAULT NULL AFTER `name`;

-- Optional sample data
-- UPDATE `app_countries` SET `visa_fee` = 1200.00 WHERE `name` = 'United Arab Emirates';
-- UPDATE `app_countries` SET `visa_fee` = 800.00 WHERE `name` = 'Saudi Arabia';
