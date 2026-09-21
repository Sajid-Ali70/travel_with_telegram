-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2026 at 04:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alfa_mobile`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL DEFAULT 'admin',
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$03gA/M42vx1hcUIt3PnT/uSVqQuN5YTKzGj.f2VPy52R47f0mqfUK', '2026-08-30 09:53:09', '2026-08-30 05:08:34');

-- --------------------------------------------------------

--
-- Table structure for table `app_categories`
--

CREATE TABLE `app_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_categories`
--

INSERT INTO `app_categories` (`id`, `name`, `icon`, `image`, `description`, `created_at`, `updated_at`) VALUES
(2, 'Domastic Visa', 'fas fa-suitcase-rolling', '/uploads/categories/cat_1789489034.png', 'Attend essential international meetings, conferences, and grow your global business network.', '2026-09-15 11:17:14', '2026-09-15 11:17:14'),
(3, 'Hospital / Medical Jobs', 'fas fa-suitcase-rolling', '/uploads/categories/cat_1789989289.png', 'test', '2026-09-21 06:14:49', '2026-09-21 06:14:49');

-- --------------------------------------------------------

--
-- Table structure for table `app_countries`
--

CREATE TABLE `app_countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `flag` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_countries`
--

INSERT INTO `app_countries` (`id`, `name`, `flag`, `created_at`, `updated_at`) VALUES
(5, 'Oman', '/uploads/flags/flag_1789486435.jfif', '2026-09-15 10:33:55', '2026-09-15 10:33:55'),
(7, 'UK', '/uploads/flags/flag_1789486478.jfif', '2026-09-15 10:34:38', '2026-09-15 10:34:38'),
(8, 'US', '/uploads/flags/flag_1789486490.png', '2026-09-15 10:34:50', '2026-09-15 10:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `app_reviews`
--

CREATE TABLE `app_reviews` (
  `id` int(11) NOT NULL,
  `reviewer_name` varchar(255) DEFAULT NULL,
  `rating` int(1) DEFAULT 5,
  `review_date` varchar(50) DEFAULT NULL,
  `review_text` text DEFAULT NULL,
  `avatar_letter` varchar(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `app_reviews`
--

INSERT INTO `app_reviews` (`id`, `reviewer_name`, `rating`, `review_date`, `review_text`, `avatar_letter`, `created_at`, `updated_at`) VALUES
(1, 'Abdul Rehman', 5, 'August 12, 2026', 'Alfa Mobiles se mobile book karna bohat asaan hai. Easy installment plan aur without advance payment best experience diya. Highly recommended!', 'A', '2026-08-30 11:29:09', '2026-08-30 11:29:09'),
(2, 'Muhammad Usman', 5, 'August 8, 2026', 'Original phones, official warranty aur 0% markup ke saath monthly installments. Alfa Mobiles trust aur service dono mein best hai.', 'M', '2026-08-30 11:29:09', '2026-08-30 11:29:09'),
(3, 'Sana Khan', 5, 'August 1, 2026', 'Maine iPhone 15 Pro booking ki. Delivery time par mili aur condition excellent thi. Alfa Mobiles ki customer support bohat achi hai.', 'S', '2026-08-30 11:29:09', '2026-08-30 11:29:09');

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `app_name` varchar(255) NOT NULL,
  `developer` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `app_icon` varchar(255) DEFAULT NULL,
  `home_banner` varchar(255) DEFAULT NULL,
  `inner_banner` varchar(255) DEFAULT NULL,
  `rating_score` decimal(2,1) DEFAULT 4.8,
  `reviews_count` varchar(50) DEFAULT '1M reviews',
  `downloads_count` varchar(50) DEFAULT '500M+',
  `content_rating` varchar(100) DEFAULT 'Rated for 3+',
  `updated_date` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `release_notes` text DEFAULT NULL,
  `screenshots` text DEFAULT NULL,
  `apk_url` varchar(255) DEFAULT '/uploads/apk/app-release.apk',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `footer_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`id`, `app_name`, `developer`, `category`, `tags`, `app_icon`, `home_banner`, `inner_banner`, `rating_score`, `reviews_count`, `downloads_count`, `content_rating`, `updated_date`, `description`, `release_notes`, `screenshots`, `apk_url`, `created_at`, `updated_at`, `phone`, `email`, `address`, `footer_text`) VALUES
(1, 'Rainbow Travels', 'Alfa Mobile Mart Karachi', 'moible shopping', 'Your Destination. Your Visa.', '/uploads/app_icon_1789988470.png', '/uploads/home_banner_1789472460.png', '/uploads/inner_banner_1789472460.png', 4.3, '1.9K reviews', '3K+', 'Rated for 3+', 'Aug 14, 2026', 'Get your visa for multiple countries with just one click — no flight ticket required.\r\nSimple application • Secure process • Professional visa assistance\r\nApply Now & Start Your Journey →', 'New mobile booking system with easy installment plans\r\nImproved app performance and faster browsing\r\nBug fixes and overall user experience improvements\r\nEnhanced security for safe shopping', '[\"\\/uploads\\/screenshots\\/screenshot_6a940fcab2465.png\",\"\\/uploads\\/screenshots\\/screenshot_6a940fcab3125.png\",\"\\/uploads\\/screenshots\\/screenshot_6a940fcab36d7.png\",\"\\/uploads\\/screenshots\\/screenshot_6a940fcab420c.png\",\"\\/uploads\\/screenshots\\/screenshot_6a940fcab47bf.png\"]', '/uploads/apk/imo-1786723732894_1788158933.apk', '2026-08-30 10:20:56', '2026-09-21 06:01:10', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `app_settings_newdata`
--

CREATE TABLE `app_settings_newdata` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `app_name` varchar(255) NOT NULL,
  `developer` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `app_icon` varchar(255) DEFAULT NULL,
  `rating_score` decimal(2,1) DEFAULT 4.8,
  `reviews_count` varchar(50) DEFAULT '1M reviews',
  `downloads_count` varchar(50) DEFAULT '500M+',
  `content_rating` varchar(100) DEFAULT 'Rated for 3+',
  `updated_date` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `release_notes` text DEFAULT NULL,
  `screenshots` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_settings_newdata`
--

INSERT INTO `app_settings_newdata` (`id`, `app_name`, `developer`, `category`, `tags`, `app_icon`, `rating_score`, `reviews_count`, `downloads_count`, `content_rating`, `updated_date`, `description`, `release_notes`, `screenshots`, `created_at`, `updated_at`) VALUES
(1, 'imo video calls and chat', 'imo.im', 'Communication', 'Contains ads · In-app purchases', '/imo_files/imo.50ad88b6.png', 4.8, '1M reviews', '500M+', 'Rated for 3+', 'Aug 14, 2023', 'imo is a free, simple, and faster video calling & instant messaging app. Send text or voice messages or video call with your friends and family easily and quickly, even with a poor network signal.', '• Improved connection stability for HD video calls\n• Bug fixes and overall performance improvements\n• Enhanced instant message translation accuracy', '[]', '2026-08-30 09:47:30', '2026-08-30 09:47:30');

-- --------------------------------------------------------

--
-- Table structure for table `app_visa_requests`
--

CREATE TABLE `app_visa_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `apply_date` date DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(50) DEFAULT NULL,
  `dob` varchar(50) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `passport_number` varchar(100) DEFAULT NULL,
  `passport_expiry` varchar(50) DEFAULT NULL,
  `passport_photo` varchar(255) DEFAULT NULL,
  `destination_country` varchar(255) DEFAULT NULL,
  `visa_category` varchar(255) DEFAULT NULL,
  `visa_type` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `admin_remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_visa_requests`
--

INSERT INTO `app_visa_requests` (`id`, `apply_date`, `first_name`, `last_name`, `email`, `mobile_number`, `dob`, `gender`, `passport_number`, `passport_expiry`, `passport_photo`, `destination_country`, `visa_category`, `visa_type`, `status`, `created_at`, `updated_at`, `admin_remarks`) VALUES
(4, '2026-09-21', 'Sajid', 'Ali', 'sajidalilyallpur@gmail.com', '03277949105', '12/12/2000', 'male', '123234234312', '12-12-2032', '/uploads/passports/passport_1789998746.png', 'Oman', 'Hospital / Medical Jobs', 'General Medicine', 'pending', '2026-09-21 08:52:26', '2026-09-21 08:52:26', NULL),
(5, '2026-09-21', 'Sajid', 'Ali', 'sajidalilyallpur@gmail.com', '03277949105', '12/12/2000', 'male', '123234234312', '12-12-2032', '/uploads/passports/passport_1789999540.png', 'Oman', 'Hospital / Medical Jobs', 'General Medicine', 'approved', '2026-09-21 09:05:40', '2026-09-21 09:13:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `app_visa_types`
--

CREATE TABLE `app_visa_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_visa_types`
--

INSERT INTO `app_visa_types` (`id`, `category_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 3, 'General Medicine', '2026-09-21 06:15:21', '2026-09-21 06:15:21');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('B42Z9EvWnJ3EruQc4GVfuLPXB7i7pplpeB1W7MtS', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOGE5OGVuY2VlMlpWQ3NYRUNSQUV2STdWblVrcWdhUGpKUlZTWXFDMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxNToiYWRtaW5fbG9nZ2VkX2luIjtiOjE7fQ==', 1790000291);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visa_requests`
--

CREATE TABLE `visa_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `apply_date` date DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_number` varchar(50) NOT NULL,
  `dob` varchar(50) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT 'male',
  `passport_number` varchar(100) NOT NULL,
  `passport_expiry` varchar(50) DEFAULT NULL,
  `passport_photo` varchar(255) DEFAULT NULL,
  `destination_country` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `visa_type` varchar(255) DEFAULT NULL,
  `status` enum('pending','processing','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_categories`
--
ALTER TABLE `app_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_countries`
--
ALTER TABLE `app_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_reviews`
--
ALTER TABLE `app_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_settings_newdata`
--
ALTER TABLE `app_settings_newdata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_visa_requests`
--
ALTER TABLE `app_visa_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_visa_types`
--
ALTER TABLE `app_visa_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `visa_requests`
--
ALTER TABLE `visa_requests`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_categories`
--
ALTER TABLE `app_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `app_countries`
--
ALTER TABLE `app_countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `app_reviews`
--
ALTER TABLE `app_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_settings_newdata`
--
ALTER TABLE `app_settings_newdata`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_visa_requests`
--
ALTER TABLE `app_visa_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `app_visa_types`
--
ALTER TABLE `app_visa_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visa_requests`
--
ALTER TABLE `visa_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
