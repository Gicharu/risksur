
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `risksur`
--

-- --------------------------------------------------------
-- Table structure for table `programpages`
--

CREATE TABLE `programpages` (
  `pageId` int(11) NOT NULL auto_increment,
  `pageName` varchar(50) default NULL,
  `path` varchar(254) default NULL,
  `parentId` int(11) default NULL,
  `menuOrder` int(11) default NULL,
  `target` varchar(20) default NULL,
  `active` tinyint(1) default '1',
`comments` varchar(254) default NULL,
  PRIMARY KEY  (`pageId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userName` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `password` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `passReset` tinyint(1) DEFAULT '0',
  `cookie` char(32) CHARACTER SET latin1 DEFAULT NULL,
  `session` char(32) CHARACTER SET latin1 DEFAULT NULL,
  `ip` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `userName` (`userName`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

/*Table structure for table `goalMenu` */


CREATE TABLE `goalMenu` (
  `pageId` int(11) NOT NULL AUTO_INCREMENT,
  `pageName` varchar(50) DEFAULT NULL,
  `path` varchar(254) DEFAULT NULL,
  `parentId` int(11) DEFAULT NULL,
  `menuOrder` int(11) DEFAULT NULL,
  `target` varchar(20) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `comments` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`pageId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `frameworkHeader` */


CREATE TABLE `frameworkHeader` (
  `frameworkId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `goalId` int(11) DEFAULT NULL,
  `description` blob,
  PRIMARY KEY (`frameworkId`),
  CONSTRAINT `goal foreign Key` FOREIGN KEY (`goalId`) REFERENCES `goalMenu`(`pageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `componentHead` */
CREATE TABLE `componentHead` (
  `componentId` int(11) NOT NULL AUTO_INCREMENT,
  `frameworkId` int(11) DEFAULT NULL,
  `componentName` varchar(254) DEFAULT NULL,
  `comments` blob,
  PRIMARY KEY (`componentId`),
  KEY `frameworkId` (`frameworkId`),
  CONSTRAINT `componenthead_fk` FOREIGN KEY (`frameworkId`) REFERENCES `frameworkHeader` (`frameworkId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*Table structure for table `componentDetails` */


CREATE TABLE `componentDetails` (
  `componentDetailId` int(11) NOT NULL AUTO_INCREMENT,
  `componentId` int(11) DEFAULT NULL,
  `subFormId` int(11) DEFAULT NULL,
  `value` varchar(254) DEFAULT NULL,
  `comments` blob,
  PRIMARY KEY (`componentDetailId`),
  KEY `fk_componentId` (`componentId`),
  CONSTRAINT `fk_componentHead_componentId` FOREIGN KEY (`componentId`) REFERENCES `componentHead`(`componentId`) ON UPDATE CASCADE ON DELETE CASCADE 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;





/*Table structure for table `surForm` */


CREATE TABLE `surForm` (
  `formId` int(11) NOT NULL AUTO_INCREMENT,
  `formName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`formId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `surFormDetails` */


CREATE TABLE `surFormDetails` (
  `subFormId` int(11) NOT NULL AUTO_INCREMENT,
  `formId` int(11) DEFAULT NULL,
  `inputName` varchar(50) DEFAULT NULL,
  `label` varchar(50) DEFAULT NULL,
  `inputType` varchar(50) DEFAULT NULL,
  `required` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`subFormId`),
  KEY `formId` (`formId`),
  CONSTRAINT `surFormDetails_ibfk_1` FOREIGN KEY (`formId`) REFERENCES `surForm` (`formId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `options` */

CREATE TABLE `options` (
  `optionId` INT(11) NOT NULL AUTO_INCREMENT,
  `elementId` INT(11) DEFAULT NULL,
  `val` VARCHAR(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` VARCHAR(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`optionId`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET latin1 NOT NULL,
  `description` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `controller` varchar(45) CHARACTER SET latin1 NOT NULL,
  `action` varchar(45) CHARACTER SET latin1 NOT NULL,
  `bizrule` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_access_rule` (`controller`,`action`,`bizrule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET latin1 NOT NULL,
  `description` varchar(45) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `roles_has_permissions` (
  `permissions_id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL,
  PRIMARY KEY (`permissions_id`,`roles_id`),
  KEY `fk_permissions_has_roles_permissions` (`permissions_id`),
  KEY `fk_permissions_has_roles_roles` (`roles_id`),
  CONSTRAINT `fk_permissions_has_roles_permissions` FOREIGN KEY (`permissions_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_permissions_has_roles_roles` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `users_has_roles` (
  `users_id` int(10) unsigned NOT NULL,
  `roles_id` int(11) NOT NULL,
  PRIMARY KEY (`users_id`,`roles_id`),
  KEY `fk_users_has_roles_roles` (`roles_id`) USING BTREE,
  KEY `fk_users_has_roles_users` (`users_id`),
  CONSTRAINT `fk_users_has_roles_roles` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_users_has_roles_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


