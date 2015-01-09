-- Update the table structure for surFormDetails, add columns description, moreinfor and url
ALTER TABLE `surFormDetails` ADD COLUMN `description` TEXT AFTER `showOnComponentList`; 
ALTER TABLE `surFormDetails` ADD COLUMN `moreInfo` TEXT AFTER `description`; 
ALTER TABLE `surFormDetails` ADD COLUMN `url` TEXT AFTER `moreInfo`; 

