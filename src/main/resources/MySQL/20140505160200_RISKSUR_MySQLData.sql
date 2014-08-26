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
-- Dumping data for table `programpages`
--

INSERT INTO `programpages` (`pageId`, `pageName`, `path`, `parentId`, `menuOrder`, `target`, `active`) VALUES
(1,'Main','',0,1,'',1),
(2,'Surveillance Design Framework','design/index',0,2,'',1),
(3,'Evaluation Tool','',0,3,'',1),
(4,'Economic Assessment','',0,4,'',1),
(5,'Examples','',0,5,'',1),
(6,'Statistical Tools','',0,6,'',1),
(7,'Profile','',0,7,'',1),
(8,'Admin','',0,9,'',1),
(9,'noMenu','',0,14,'',1),
(10,'Change Password','changePassword.php',7,10,'',1);


insert  into `permissions`(`id`,`name`,`description`,`controller`,`action`,`bizrule`) values 
(1,'Design index','design index','design','index',''),
(2,'Design fetchComponents','design fetchComponents','design','fetchComponents','')
(3,'Design view','design view','design','showDesign','')
;


/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`description`) values (1,'ROLE_ADMIN','administrator role'),(2,'ROLE_SUPERADMIN','super administrator role');

/*Data for the table `roles_has_permissions` */

insert  into `roles_has_permissions`(`permissions_id`,`roles_id`) values (1,1),(1,2),(2,1),(2,2),(3,1),(3,2);

/*Data for the table `users` */

insert  into `users`(`userId`,`userName`,`password`,`email`,`active`,`passReset`,`cookie`,`session`,`ip`) values (7,'admin','f8892166ddb74acc4a3437e7a7e9f63b','admin@me.com',1,0,NULL,NULL,NULL),(8,'user','f8892166ddb74acc4a3437e7a7e9f63b','admin@me.com',1,0,NULL,NULL,NULL);

/*Data for the table `users_has_roles` */

insert  into `users_has_roles`(`users_id`,`roles_id`) values (8,1),(7,2);

/*Data for the table `goalMenu` */

insert  into `goalMenu`(`pageId`,`pageName`,`path`,`parentId`,`menuOrder`,`target`,`active`,`comments`) values (1,'Prevalence Estimation','',0,1,'',1,NULL),(2,'Case Detection','',0,2,'',1,NULL),(3,'Early Detection','',0,3,'',1,NULL),(4,'Disease Freedom','',0,5,'',1,NULL),(9,'noMenu','',0,14,'',0,NULL),(10,'Active','',1,10,'',1,NULL),(11,'Passive','',1,11,'',1,NULL),(12,'Sentinel','',1,12,'',1,NULL),(13,'Enhanced Passive','',1,13,'',1,NULL),(14,'Active','',2,10,'',1,NULL),(15,'Passive','',2,11,'',1,NULL),(16,'Sentinel','',2,12,'',1,NULL),(17,'Enhanced Passive','',2,13,'',1,NULL);
