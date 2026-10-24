-- Stores the administrator-selected document checklist as a JSON-encoded array.
ALTER TABLE `app_visa_requests`
    ADD COLUMN `required_documents` TEXT NULL AFTER `agent_contact_number`;
