/*Table structure for table `frameworkFields` */

DROP TABLE IF EXISTS `frameworkFields`;

CREATE TABLE `frameworkFields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `frameworkId` int(11) NOT NULL,
  `inputName` text CHARACTER SET latin1 NOT NULL,
  `inputType` text CHARACTER SET latin1 NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '1',
  `showOnContextList` tinyint(1) DEFAULT '0',
  `description` text CHARACTER SET latin1,
  PRIMARY KEY (`id`),
  KEY `fk_framework_id` (`frameworkId`),
  CONSTRAINT `fk_framework_id` FOREIGN KEY (`frameworkId`) REFERENCES `frameworkHeader` (`frameworkId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `frameworkFieldData` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `frameworkId` int(11) NOT NULL,
  `frameworkFieldId` int(11) unsigned NOT NULL,
  `value` varchar(254) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comments` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `fk_frameworkId` (`frameworkId`),
  KEY `fk_frameworkFieldId` (`frameworkFieldId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=36 ;
-- Constraints for table `frameworkFieldData`
--
ALTER TABLE `frameworkFieldData`
ADD CONSTRAINT `fk_frameworkFieldId` FOREIGN KEY (`frameworkFieldId`) REFERENCES `frameworkFields` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_frameworkId` FOREIGN KEY (`frameworkId`) REFERENCES `frameworkHeader` (`frameworkId`) ON DELETE CASCADE ON UPDATE CASCADE;

/*Table structure for table `frameworkHeader` */

ALTER TABLE `frameworkHeader` DROP COLUMN `goalId`, DROP INDEX `goal foreign Key`, DROP FOREIGN KEY `goal foreign Key`;
Alter table `options`
add column `frameworkFieldId` int(11) UNSIGNED NULL after `label`,
add constraint `fk_frameworkfieldid` foreign key (`frameworkFieldId`) references `frameworkFields`(`id`) on update Cascade on delete Cascade