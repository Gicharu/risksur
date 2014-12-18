-- update the table structure for surFormDetails, add column showOnComponentList
ALTER TABLE `surFormDetails` ADD COLUMN `showOnComponentList` TINYINT(1) DEFAULT 0 NULL AFTER `required`; 

