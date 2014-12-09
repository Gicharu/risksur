INSERT INTO `permissions`(`id`,`name`,`description`,`controller`,`action`,`bizrule`) values 
(33,'Add Multiple Components','Add Multiple Components','design','addMultipleComponents','');

INSERT INTO `roles_has_permissions`(`permissions_id`,`roles_id`) values
(33,1),(33,2),(33,3);