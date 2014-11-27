INSERT INTO `programpages` (`pageId`, `pageName`, `path`, `parentId`, `menuOrder`, `target`, `active`) VALUES
(13,'Manage Users','users/index',8,16,'',1);

INSERT INTO `permissions`(`id`,`name`,`description`,`controller`,`action`,`bizrule`) values 
(29,'Manage Users','Manage Users','users','index',''),
(30,'Add Users','Add Users','users','createUser',''),
(31,'Update User','Update User','users','updateUser',''),
(32,'Delete User','Delete User','users','deleteUser','');

INSERT INTO `roles_has_permissions`(`permissions_id`,`roles_id`) values
(29,1),(29,2),(30,1),(30,2),(31,1),(31,2),(32,1),(32,2);