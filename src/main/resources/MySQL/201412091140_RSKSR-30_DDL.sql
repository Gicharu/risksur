-- update the table structure for surFormDetails, add column showOnMultiForm
ALTER TABLE `surFormDetails` ADD COLUMN `showOnMultiForm` TINYINT(1) DEFAULT 0 NULL AFTER `required`; 
