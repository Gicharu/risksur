INSERT INTO `programpages` (`pageId`, `pageName`, `path`, `parentId`, `menuOrder`, `target`, `active`) VALUES
(12,'Manage Select Options','options/index',8,15,'',1);


INSERT INTO `permissions`(`id`,`name`,`description`,`controller`,`action`,`bizrule`) values 
(23,'Manage Options','Manage Options','options','index',''),
(24,'Add Options','Add Options','options','addOption',''),
(25,'Edit Options','Edit Options','options','editOption',''),
(26,'Delete Options','Delete Options','options','deleteOption','');

INSERT INTO `roles_has_permissions`(`permissions_id`,`roles_id`) values
(23,1),(23,2),
(24,1),(24,2),
(25,1),(25,2),
(26,1),(26,2);

INSERT INTO `roles`(`id`,`name`,`description`) values 
(3,'ROLE_USER','Normal User');