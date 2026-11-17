CREATE TABLE IF NOT EXISTS `app_faqs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `question` VARCHAR(500) NOT NULL,
    `answer` TEXT NOT NULL,
    `sort_order` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `app_faqs` (`question`, `answer`, `sort_order`, `is_active`, `created_at`, `updated_at`)
SELECT 'How do I apply for a visa?', 'Choose your destination and visa type, complete the online application, and submit the required documents.', 1, 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM `app_faqs` WHERE `question` = 'How do I apply for a visa?');

INSERT INTO `app_faqs` (`question`, `answer`, `sort_order`, `is_active`, `created_at`, `updated_at`)
SELECT 'How can I check my application status?', 'Use the Check Status page and enter your application details to view the latest update.', 2, 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM `app_faqs` WHERE `question` = 'How can I check my application status?');

INSERT INTO `app_faqs` (`question`, `answer`, `sort_order`, `is_active`, `created_at`, `updated_at`)
SELECT 'Can I change my travel booking?', 'Contact our support team with your booking details so we can help you review available changes.', 3, 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM `app_faqs` WHERE `question` = 'Can I change my travel booking?');
