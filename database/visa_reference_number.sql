-- Safe to run before or after the application adds this column.
SET @reference_column_exists = (
    SELECT COUNT(*)
    FROM `information_schema`.`columns`
    WHERE `table_schema` = DATABASE()
      AND `table_name` = 'app_visa_requests'
      AND `column_name` = 'reference_number'
);
SET @reference_column_sql = IF(
    @reference_column_exists = 0,
    'ALTER TABLE `app_visa_requests` ADD COLUMN `reference_number` VARCHAR(40) NULL DEFAULT NULL AFTER `id`',
    'SELECT 1'
);
PREPARE reference_column_statement FROM @reference_column_sql;
EXECUTE reference_column_statement;
DEALLOCATE PREPARE reference_column_statement;

UPDATE `app_visa_requests`
SET `reference_number` = CONCAT(
    'RT-',
    DATE_FORMAT(COALESCE(`created_at`, CURRENT_TIMESTAMP), '%Y%m%d%H%i%s'),
    '-',
    `id`
)
WHERE `reference_number` IS NULL OR `reference_number` = '';

SET @reference_index_exists = (
    SELECT COUNT(*)
    FROM `information_schema`.`statistics`
    WHERE `table_schema` = DATABASE()
      AND `table_name` = 'app_visa_requests'
      AND `index_name` = 'app_visa_requests_reference_number_unique'
);
SET @reference_index_sql = IF(
    @reference_index_exists = 0,
    'ALTER TABLE `app_visa_requests` ADD UNIQUE KEY `app_visa_requests_reference_number_unique` (`reference_number`)',
    'SELECT 1'
);
PREPARE reference_index_statement FROM @reference_index_sql;
EXECUTE reference_index_statement;
DEALLOCATE PREPARE reference_index_statement;
