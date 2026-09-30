CREATE TABLE IF NOT EXISTS `app_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_title` varchar(255) NOT NULL,
  `job_description` text NOT NULL,
  `salary` decimal(12,2) DEFAULT NULL,
  `working_hours` varchar(100) DEFAULT NULL,
  `paid_leave_days_after_one_year` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Example seed data
INSERT INTO `app_jobs` (`job_title`, `job_description`, `salary`, `working_hours`, `paid_leave_days_after_one_year`, `created_at`, `updated_at`) VALUES
('Hospital Nurse', 'Provide patient care, monitor vital signs, manage nursing tasks, and support medical staff in a fast-paced hospital environment.', 1200.00, '8 hours/day', 12, NOW(), NOW()),
('Medical Lab Technician', 'Perform laboratory tests, maintain equipment, and record accurate diagnostics for patient treatment plans.', 1000.00, '8 hours/day', 10, NOW(), NOW());
