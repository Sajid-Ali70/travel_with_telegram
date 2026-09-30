SET @preferred_airport_column_exists = (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'app_visa_requests'
      AND COLUMN_NAME = 'preferred_airport'
);

SET @preferred_airport_sql = IF(
    @preferred_airport_column_exists = 0,
    'ALTER TABLE `app_visa_requests` ADD COLUMN `preferred_airport` VARCHAR(10) NULL DEFAULT NULL',
    'SELECT 1'
);

PREPARE preferred_airport_statement FROM @preferred_airport_sql;
EXECUTE preferred_airport_statement;
DEALLOCATE PREPARE preferred_airport_statement;