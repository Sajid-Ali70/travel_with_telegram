CREATE TABLE IF NOT EXISTS `app_services` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `eyebrow` VARCHAR(100) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `icon` VARCHAR(255) NOT NULL DEFAULT 'fas fa-plane',
    `link_label` VARCHAR(100) NOT NULL DEFAULT 'Learn more',
    `link_url` VARCHAR(500) NOT NULL DEFAULT '/contact',
    `sort_order` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `app_services` (`eyebrow`, `title`, `description`, `icon`, `link_label`, `link_url`, `sort_order`, `is_active`, `created_at`, `updated_at`)
SELECT 'WORK VISA', 'Work Visa', 'Explore employment and work visa opportunities.', 'fas fa-passport', 'Apply now', '/apply', 1, 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM `app_services` WHERE `title` = 'Work Visa');

INSERT INTO `app_services` (`eyebrow`, `title`, `description`, `icon`, `link_label`, `link_url`, `sort_order`, `is_active`, `created_at`, `updated_at`)
SELECT 'OVERSEAS JOBS', 'Overseas Jobs', 'Find a job and start your career abroad.', 'fas fa-briefcase', 'Browse jobs', '/jobs', 2, 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM `app_services` WHERE `title` = 'Overseas Jobs');

INSERT INTO `app_services` (`eyebrow`, `title`, `description`, `icon`, `link_label`, `link_url`, `sort_order`, `is_active`, `created_at`, `updated_at`)
SELECT 'VISA ASSISTANCE', 'Visa Assistance', 'Get professional support with your application.', 'fas fa-file-signature', 'Get assistance', '/apply', 3, 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM `app_services` WHERE `title` = 'Visa Assistance');

INSERT INTO `app_services` (`eyebrow`, `title`, `description`, `icon`, `link_label`, `link_url`, `sort_order`, `is_active`, `created_at`, `updated_at`)
SELECT 'TRAVEL SERVICES', 'Travel Services', 'Discover travel and holiday package options.', 'fas fa-umbrella-beach', 'Learn more', '/about', 4, 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM `app_services` WHERE `title` = 'Travel Services');

INSERT INTO `app_services` (`eyebrow`, `title`, `description`, `icon`, `link_label`, `link_url`, `sort_order`, `is_active`, `created_at`, `updated_at`)
SELECT 'CHAT WITH OUR EXPERTS', 'Chat with our Experts/Agents', 'Get in touch with our team for assistance.', 'fas fa-comments', 'Contact us', '/contact', 5, 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM `app_services` WHERE `title` = 'Chat with our Experts/Agents');
