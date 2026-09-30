ALTER TABLE `app_visa_requests`
  ADD COLUMN `payment_receipt` VARCHAR(255) NULL DEFAULT NULL,
  ADD COLUMN `payment_receipt_uploaded_at` TIMESTAMP NULL DEFAULT NULL,
  ADD COLUMN `preferred_date_start` DATE NULL DEFAULT NULL,
  ADD COLUMN `preferred_date_end` DATE NULL DEFAULT NULL,
  ADD COLUMN `preferred_airport` VARCHAR(10) NULL DEFAULT NULL,
  ADD COLUMN `flight_ticket_requested_at` TIMESTAMP NULL DEFAULT NULL;
