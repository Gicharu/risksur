INSERT INTO `programpages` (`pageId`, `pageName`, `path`, `parentId`, `menuOrder`, `target`, `active`) VALUES
(14,'Manage Attributes','attribute/index',8,17,'',1);

INSERT INTO `permissions`(`id`,`name`,`description`,`controller`,`action`,`bizrule`) values 
(35,'Manage Attributes','Manage Attributes','attribute','index',''),
(36,'Add Attributes','Add Attributes','attribute','addAttribute',''),
(37,'Edit Attributes','Update Attributes','attribute','editAttribute',''),
(38,'Delete Attributes','Delete Attributes','attribute','deleteAttribute',''),
(39,'Add Relation','Add Relation','attribute','addRelation',''),
(40,'View Relations','View Relations','attribute','listRelations','');

INSERT INTO `roles_has_permissions`(`permissions_id`,`roles_id`) values
(35,1),(35,2),(36,1),(36,2),(37,1),(37,2),(38,1),(38,2),(39,1),(39,2),(40,1),(40,2);

INSERT INTO `pages_has_roles`(`pageId`,`roleId`) VALUES
(14,1),(14,2),(14,3);