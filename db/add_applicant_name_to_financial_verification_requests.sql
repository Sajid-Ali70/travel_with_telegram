-- Apply once after app_financial_verification_requests has been created.
-- The Laravel migration adds the same nullable field.
ALTER TABLE `app_financial_verification_requests`
    ADD COLUMN `applicant_name` VARCHAR(255) NULL AFTER `application_reference`;
