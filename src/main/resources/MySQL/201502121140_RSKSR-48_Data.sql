--  Evaluation form elements
INSERT INTO `evalElements` (`inputName`, `label`, `inputType`) VALUES ('StrengthsWeakness', 'Strengths and weaknesses of current approach', 'text'); 
INSERT INTO `evalElements` (`inputName`, `label`, `inputType`) VALUES ('concerns', 'Any concerns about current approach', 'text'); 
INSERT INTO `evalElements` (`inputName`, `label`, `inputType`) VALUES ('stakeholderConcerns', 'Stakeholder concerns about current approach', 'text'); 
INSERT INTO `evalElements` (`inputName`, `label`, `inputType`) VALUES ('altStrategies', 'Alternative strategies to consider', 'text'); 
INSERT INTO `evalElements` (`inputName`, `label`, `inputType`) VALUES ('currentCost', 'Current cost estimate', 'text'); 
INSERT INTO `evalElements` (`inputName`, `label`, `inputType`) VALUES ('budgetChange', 'Proposed change to budget', 'text'); 
INSERT INTO `evalElements` (`inputName`, `label`, `inputType`) VALUES ('budgetLimit', 'Budget limit', 'text'); 

INSERT INTO `permissions`(`id`,`name`,`description`,`controller`,`action`,`bizrule`) values 
(48,'Evaluation context','Evaluation context','evaluation','addEvaContext','')
;

INSERT INTO `roles_has_permissions`(`permissions_id`,`roles_id`) values
(48,1),(48,2),(48,3)
;

