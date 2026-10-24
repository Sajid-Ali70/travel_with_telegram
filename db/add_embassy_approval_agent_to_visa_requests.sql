-- Keeps the embassy-approval contact separate from the document-verification agent.
ALTER TABLE `app_visa_requests`
    ADD COLUMN `approval_agent_name` VARCHAR(255) NULL DEFAULT NULL,
    ADD COLUMN `approval_agent_contact_number` VARCHAR(50) NULL DEFAULT NULL;

-- Preserve the existing approval contacts before the shared fields become verification-only.
UPDATE `app_visa_requests`
SET
    `approval_agent_name` = `agent_name`,
    `approval_agent_contact_number` = `agent_contact_number`
WHERE `status` IN ('Visa Approved from Embassy', 'Visa Approved', 'approved');
