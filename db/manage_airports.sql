CREATE TABLE IF NOT EXISTS `app_airports` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(10) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `app_airports_code_unique` (`code`),
  UNIQUE KEY `app_airports_name_unique` (`name`)
);

INSERT IGNORE INTO `app_airports` (`code`, `name`, `created_at`, `updated_at`) VALUES
  ('DAC', 'Hazrat Shahjalal International Airport, Dhaka (DAC)', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
  ('CGP', 'Shah Amanat International Airport, Chattogram (CGP)', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
  ('ZYL', 'Osmani International Airport, Sylhet (ZYL)', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
  ('ISB', 'Islamabad International Airport (ISB)', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
  ('LHE', 'Allama Iqbal International Airport, Lahore (LHE)', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
  ('KHI', 'Jinnah International Airport, Karachi (KHI)', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);