-- Stores the applicant's selected city for their chosen job opening.
ALTER TABLE `app_visa_requests`
    ADD COLUMN `selected_job_city` VARCHAR(255) NULL DEFAULT NULL AFTER `selected_job_ids`;
