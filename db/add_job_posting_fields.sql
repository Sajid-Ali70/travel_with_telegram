-- Add the fields required by the admin job-posting form to existing installations.
-- Run after app_jobs has been created by jobs_table.sql.
ALTER TABLE `app_jobs`
    ADD COLUMN `category_visa_type` VARCHAR(255) NULL DEFAULT NULL,
    ADD COLUMN `country_location` VARCHAR(255) NULL DEFAULT NULL,
    ADD COLUMN `number_of_vacancies` INT UNSIGNED NOT NULL DEFAULT 1,
    ADD COLUMN `requirements` TEXT NULL DEFAULT NULL,
    ADD COLUMN `salary_currency` VARCHAR(10) NOT NULL DEFAULT 'SAR',
    ADD COLUMN `salary_period` VARCHAR(20) NOT NULL DEFAULT 'month',
    ADD COLUMN `working_days` TEXT NULL DEFAULT NULL,
    ADD COLUMN `overtime_policy` TEXT NULL DEFAULT NULL,
    ADD COLUMN `contract_duration` VARCHAR(255) NULL DEFAULT NULL,
    ADD COLUMN `accommodation_provided` TINYINT(1) NOT NULL DEFAULT 0,
    ADD COLUMN `food_allowance_provided` TINYINT(1) NOT NULL DEFAULT 0,
    ADD COLUMN `medical_insurance` TINYINT(1) NOT NULL DEFAULT 0,
    ADD COLUMN `ticket_provided` TINYINT(1) NOT NULL DEFAULT 0,
    ADD COLUMN `status` VARCHAR(20) NOT NULL DEFAULT 'Active';