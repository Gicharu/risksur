
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `risksur`
--


-- --------------------------------------------------------


--
-- Table structure for table `groupaccess`
--

CREATE TABLE `groupaccess` (
  `groupAccessId` int(11) NOT NULL auto_increment,
  `groupId` int(11) default NULL,
  `pageId` int(11) default NULL,
  PRIMARY KEY  (`groupAccessId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=467 ;

-- --------------------------------------------------------


--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `groupId` int(11) NOT NULL auto_increment,
  `groupName` varchar(20) default NULL,
  PRIMARY KEY  (`groupId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=199 ;

-- --------------------------------------------------------

--
-- Table structure for table `usergroup`
--

CREATE TABLE `usergroup` (
  `userGroupId` int(11) NOT NULL auto_increment,
  `userId` int(11) default NULL,
  `groupId` int(11) default NULL,
  PRIMARY KEY  (`userGroupId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL auto_increment,
  `userName` varchar(20) default NULL,
  `password` varchar(40) default NULL,
  `email` varchar(40) default NULL,
  `active` tinyint(1) default NULL,
  `passReset` tinyint(1) default 0,
  `cookie` char(32) default NULL,
  `session` char(32) default NULL,
  `ip` varchar(15) default NULL,
  PRIMARY KEY  (`userId`),
  UNIQUE KEY `userName` (`userName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

-- --------------------------------------------------------

/*Table structure for table `frameworkDetails` */


CREATE TABLE `frameworkDetails` (
  `frameworkDetailId` int(11) NOT NULL AUTO_INCREMENT,
  `frameworkId` int(11) DEFAULT NULL,
  `subFormId` int(11) DEFAULT NULL,
  `value` varchar(254) DEFAULT NULL,
  `comments` blob,
  PRIMARY KEY (`frameworkDetailId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `frameworkHeader` */


CREATE TABLE `frameworkHeader` (
  `frameworkId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `formId` int(11) DEFAULT NULL,
  `comments` blob,
  PRIMARY KEY (`frameworkId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;


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
  `description` blob,
  PRIMARY KEY (`subFormId`),
  KEY `formId` (`formId`),
  CONSTRAINT `surFormDetails_ibfk_1` FOREIGN KEY (`formId`) REFERENCES `surForm` (`formId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


