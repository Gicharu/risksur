CREATE DATABASE /*!32312 IF NOT EXISTS*/`risksur` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `risksur`;

/*Table structure for table `frameworkFields` */

DROP TABLE IF EXISTS `frameworkFields`;

CREATE TABLE `frameworkFields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `frameworkId` int(11) NOT NULL,
  `inputName` text CHARACTER SET latin1 NOT NULL,
  `inputType` text CHARACTER SET latin1 NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '1',
  `value` text COLLATE utf8_unicode_ci,
  `showOnContextList` tinyint(1) DEFAULT '0',
  `description` text CHARACTER SET latin1,
  PRIMARY KEY (`id`),
  KEY `fk_framework_id` (`frameworkId`),
  CONSTRAINT `fk_framework_id` FOREIGN KEY (`frameworkId`) REFERENCES `frameworkHeader` (`frameworkId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `frameworkHeader` */

ALTER TABLE `risksur`.`frameworkHeader` DROP COLUMN `goalId`, DROP INDEX `goal foreign Key`, DROP FOREIGN KEY `goal foreign Key`;
Alter table `risksur`.`options`
add column `frameworkFieldId` int(11) UNSIGNED NULL after `label`,
add constraint `idx_frameworkfieldid` foreign key (`frameworkFieldId`) references `risksur`.`frameworkFields`(`id`) on update Cascade on delete Cascade