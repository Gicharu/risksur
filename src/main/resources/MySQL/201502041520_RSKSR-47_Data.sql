INSERT INTO `permissions`(`id`,`name`,`description`,`controller`,`action`,`bizrule`) values 
(43,'Evaluation Page','Evaluation Page','evaluation','evaPage','')
(44,'Save Evaluation Page','Save Evaluation Page','evaluation','saveEvaPage','')
(45,'upload image Page','upload image Page','evaluation','imageUpload','')
;

INSERT INTO `roles_has_permissions`(`permissions_id`,`roles_id`) values
(43,1),(43,2),(43,3),
(44,1),(44,2),(44,3),
(45,1),(45,2),(45,3)
;
