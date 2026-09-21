-- Table structure for table `visa_requests`
CREATE TABLE `visa_requests` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `apply_date` date DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_number` varchar(50) NOT NULL,
  `dob` varchar(50) DEFAULT NULL,
  `gender` enum('male', 'female', 'other') DEFAULT 'male',
  `passport_number` varchar(100) NOT NULL,
  `passport_expiry` varchar(50) DEFAULT NULL,
  `passport_photo` varchar(255) DEFAULT NULL,
  `destination_country` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `visa_type` varchar(255) DEFAULT NULL,
  `status` enum('pending', 'processing', 'approved', 'rejected') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
