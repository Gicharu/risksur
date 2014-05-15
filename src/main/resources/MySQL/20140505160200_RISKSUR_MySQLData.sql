-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 07, 2011 at 03:40 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `risksur`
--

--
-- Dumping data for table `groupaccess`
--

INSERT INTO `groupaccess` (`groupAccessId`, `groupId`, `pageId`) VALUES
(1,1,1),
(2,1,2),
(3,1,3),
(4,1,4),
(5,1,5),
(6,1,6),
(7,1,7),
(8,1,8),
(9,1,9),
(10,1,10),
(11,2,1),
(12,2,2),
(13,2,3),
(14,2,4),
(15,2,5),
(16,2,6),
(17,2,7),
(18,2,8),
(19,2,9),
(20,2,10),
(21,2,1),
(22,2,2),
(23,2,3),
(24,2,4),
(25,2,5),
(26,2,6),
(27,2,7),
(29,2,9),
(30,2,10);




--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`groupId`, `groupName`) VALUES
(1, 'Super Admin'),
(2, 'Admin'),
(3, 'User');

--
-- Dumping data for table `programpages`
--

INSERT INTO `programpages` (`pageId`, `pageName`, `path`, `parentId`, `menuOrder`, `target`, `active`) VALUES
(1,'Main','',0,1,'',1),
(2,'Surveillance Design Framework','',0,2,'',1),
(3,'Evaluation Tool','',0,3,'',1),
(4,'Economic Assessment','',0,4,'',1),
(5,'Examples','',0,5,'',1),
(6,'Statistical Tools','',0,6,'',1),
(7,'Profile','',0,7,'',1),
(8,'Admin','',0,9,'',1),
(9,'noMenu','',0,14,'',1),
(10,'Change Password','changePassword.php',7,10,'',1);

--
-- Dumping data for table `usergroup`
--

INSERT INTO `usergroup` (`userGroupId`, `userId`, `groupId`) VALUES
(1,1,1),
(2,1,2),
(3,1,3),
(5,2,2),
(6,2,3),
(7,3,3);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userName`, `password`, `active`, `cookie`, `session`, `ip`) VALUES
(1,'tracetracker','04a75036e9d520bb983c5ed03b8d0182',1,NULL,NULL,NULL),
(2,'admin','21232f297a57a5a743894a0e4a801fc3',1,NULL,NULL,NULL),
(3,'user','21232f297a57a5a743894a0e4a801fc3',1,NULL,NULL,NULL);

/*Data for the table `goalMenu` */

insert  into `goalMenu`(`pageId`,`pageName`,`path`,`parentId`,`menuOrder`,`target`,`active`,`comments`) values (1,'Prevalence Estimation','',0,1,'',1,NULL),(2,'Case Detection','',0,2,'',1,NULL),(3,'Early Detection','',0,3,'',1,NULL),(4,'Disease Freedom','',0,5,'',1,NULL),(9,'noMenu','',0,14,'',0,NULL),(10,'Active','',1,10,'',1,NULL),(11,'Passive','',1,11,'',1,NULL),(12,'Sentinel','',1,12,'',1,NULL),(13,'Enhanced Passive','',1,13,'',1,NULL),(14,'Active','',2,10,'',1,NULL),(15,'Passive','',2,11,'',1,NULL),(16,'Sentinel','',2,12,'',1,NULL),(17,'Enhanced Passive','',2,13,'',1,NULL);
