INSERT INTO `permissions`(`id`,`name`,`description`,`controller`,`action`,`bizrule`) values 
(34,'Add Multiple Components','Add Multiple Components','design','addMultipleComponents','');

INSERT INTO `roles_has_permissions`(`permissions_id`,`roles_id`) values
(34,1),(34,2),(34,3);
