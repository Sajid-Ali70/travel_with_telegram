-- SQL to fix the app_visa_requests table by adding missing columns

ALTER TABLE `app_visa_requests`
ADD COLUMN `apply_date` DATE NULL DEFAULT NULL AFTER `id`,
ADD COLUMN `mobile_number` VARCHAR(50) NULL DEFAULT NULL AFTER `email`,
ADD COLUMN `dob` VARCHAR(50) NULL DEFAULT NULL AFTER `mobile_number`,
ADD COLUMN `gender` VARCHAR(50) NULL DEFAULT NULL AFTER `dob`,
ADD COLUMN `passport_number` VARCHAR(100) NULL DEFAULT NULL AFTER `gender`,
ADD COLUMN `passport_expiry` VARCHAR(50) NULL DEFAULT NULL AFTER `passport_number`,
ADD COLUMN `passport_photo` VARCHAR(255) NULL DEFAULT NULL AFTER `passport_expiry`,
ADD COLUMN `destination_country` VARCHAR(255) NULL DEFAULT NULL AFTER `passport_photo`,
ADD COLUMN `visa_category` VARCHAR(255) NULL DEFAULT NULL AFTER `destination_country`,
ADD COLUMN `visa_type` VARCHAR(255) NULL DEFAULT NULL AFTER `visa_category`;
