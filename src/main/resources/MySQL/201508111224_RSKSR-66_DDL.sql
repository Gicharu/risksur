ALTER TABLE `surveillanceSections`
ADD COLUMN `sectionNumber` FLOAT(2,1) NOT NULL AFTER `sectionId`;

ALTER TABLE `options` DROP FOREIGN KEY `fk_componentId`;

ALTER TABLE `options` ADD CONSTRAINT `fk_componentId` FOREIGN KEY (`componentId`)
REFERENCES `surFormDetails`(`subFormId`)
  ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE `surFormDetails`
DROP FOREIGN KEY `surFormDetails_ibfk_1`;

ALTER TABLE `surFormDetails`
CHANGE `formId` `sectionId` INT(11) NULL;

ALTER TABLE `surFormDetails`
ADD COLUMN `parentId` INT(11) NULL AFTER `sectionId`;

ALTER TABLE `attributeFormRelation`
DROP FOREIGN KEY `fk_attributeFormRelation_surFormDetails`;

ALTER TABLE `surFormDetails`
ADD COLUMN `order` VARCHAR(10) NULL;

