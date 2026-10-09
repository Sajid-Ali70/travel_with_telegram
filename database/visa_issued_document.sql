-- Adds private issued-visa document storage metadata to existing installations.
SET @issued_visa_document_exists = (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'app_visa_requests'
      AND COLUMN_NAME = 'issued_visa_document'
);

SET @issued_visa_document_sql = IF(
    @issued_visa_document_exists = 0,
    'ALTER TABLE `app_visa_requests` ADD `issued_visa_document` VARCHAR(255) NULL DEFAULT NULL',
    'SELECT 1'
);

PREPARE issued_visa_document_statement FROM @issued_visa_document_sql;
EXECUTE issued_visa_document_statement;
DEALLOCATE PREPARE issued_visa_document_statement;
