
INSERT INTO `permissions`(`id`,`name`,`description`,`controller`,`action`,`bizrule`) values 
(28,'duplicate components','duplicate components','design','duplicateComponent','');

INSERT INTO `roles_has_permissions`(`permissions_id`,`roles_id`) values
(28,1),(28,2);
