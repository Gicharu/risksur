-- updated the evaluation menu to evaluation/Index
UPDATE `programpages` SET `path` = 'evaluation/index' WHERE `PageId` = '3'; 
UPDATE `programpages` SET `pageName` = 'Evaluation' WHERE `PageId` = '3'; 

-- remove economic assessment menu and examples menu
DELETE FROM programpages WHERE pageId = 4;
DELETE FROM programpages WHERE pageId = 5;

INSERT INTO `permissions`(`id`,`name`,`description`,`controller`,`action`,`bizrule`) values 
(42,'Evaluation Index','Evaluation Index','evaluation','index','')
;

INSERT INTO `roles_has_permissions`(`permissions_id`,`roles_id`) values
(42,1),(42,2);
