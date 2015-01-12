INSERT INTO `programpages` (`pageId`, `pageName`, `path`, `parentId`, `menuOrder`, `target`, `active`) VALUES
(14,'Manage Attributes','attribute/index',8,17,'',1);

INSERT INTO `permissions`(`id`,`name`,`description`,`controller`,`action`,`bizrule`) values 
(35,'Manage Attributes','Manage Attributes','attribute','index',''),
(36,'Add Attributes','Add Attributes','attribute','createAttribute',''),
(37,'Update Attributes','Update Attributes','attribute','updateAttribute',''),
(38,'Delete Attributes','Delete Attributes','attribute','deleteAttribute','');

INSERT INTO `roles_has_permissions`(`permissions_id`,`roles_id`) values
(35,1),(35,2),(36,1),(36,2),(37,1),(37,2),(38,1),(38,2);

INSERT INTO `pages_has_roles`(`pageId`,`roleId`) VALUES
(14,1),(14,2),(14,3);