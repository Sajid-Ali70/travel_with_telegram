SET @ticket_status_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'app_visa_requests'
      AND COLUMN_NAME = 'ticket_status'
);
SET @ticket_status_sql = IF(
    @ticket_status_exists = 0,
    'ALTER TABLE `app_visa_requests` ADD COLUMN `ticket_status` VARCHAR(50) NULL DEFAULT NULL',
    'SELECT 1'
);
PREPARE ticket_status_statement FROM @ticket_status_sql;
EXECUTE ticket_status_statement;
DEALLOCATE PREPARE ticket_status_statement;

SET @ticket_details_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'app_visa_requests'
      AND COLUMN_NAME = 'ticket_details'
);
SET @ticket_details_sql = IF(
    @ticket_details_exists = 0,
    'ALTER TABLE `app_visa_requests` ADD COLUMN `ticket_details` TEXT NULL DEFAULT NULL',
    'SELECT 1'
);
PREPARE ticket_details_statement FROM @ticket_details_sql;
EXECUTE ticket_details_statement;
DEALLOCATE PREPARE ticket_details_statement;

SET @ticket_status_updated_at_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'app_visa_requests'
      AND COLUMN_NAME = 'ticket_status_updated_at'
);
SET @ticket_status_updated_at_sql = IF(
    @ticket_status_updated_at_exists = 0,
    'ALTER TABLE `app_visa_requests` ADD COLUMN `ticket_status_updated_at` TIMESTAMP NULL DEFAULT NULL',
    'SELECT 1'
);
PREPARE ticket_status_updated_at_statement FROM @ticket_status_updated_at_sql;
EXECUTE ticket_status_updated_at_statement;
DEALLOCATE PREPARE ticket_status_updated_at_statement;