--  Evaluation form elements
INSERT INTO `evalElements` (`inputName`, `label`, `inputType`) VALUES ('StrengthsWeakness', 'Strengths and weaknesses of current approach', 'text'); 
INSERT INTO `evalElements` (`inputName`, `label`, `inputType`) VALUES ('concerns', 'Any concerns about current approach', 'text'); 
INSERT INTO `evalElements` (`inputName`, `label`, `inputType`) VALUES ('stakeholderConcerns', 'Stakeholder concerns about current approach', 'text'); 
INSERT INTO `evalElements` (`inputName`, `label`, `inputType`) VALUES ('altStrategies', 'Alternative strategies to consider', 'text'); 
INSERT INTO `evalElements` (`inputName`, `label`, `inputType`) VALUES ('currentCost', 'Current cost estimate', 'text'); 
INSERT INTO `evalElements` (`inputName`, `label`, `inputType`) VALUES ('budgetChange', 'Proposed change to budget', 'text'); 
INSERT INTO `evalElements` (`inputName`, `label`, `inputType`) VALUES ('budgetLimit', 'Budget limit', 'text'); 

INSERT INTO `permissions`(`id`,`name`,`description`,`controller`,`action`,`bizrule`) values 
(48,'Evaluation context','Evaluation context','evaluation','addEvaContext',''),
(49,'Show Evaluation context','Show Evaluation context','evaluation','showEval',''),
(50,'Delete Evaluation context','Delete Evaluation context','evaluation','deleteEval','')
;

INSERT INTO `roles_has_permissions`(`permissions_id`,`roles_id`) values
(48,1),(48,2),(48,3),
(49,1),(49,2),(49,3),
(50,1),(50,2),(50,3)
;

/*Data for the table `evaluationQuestion` */

insert  into `evaluationQuestion`(`evalQuestionId`,`question`,`shortName`) values (1,'Ascertain if one or more surveillance component(s) or system(s) is/are capable of meeting\r\na technical objective or target',NULL);
insert  into `evaluationQuestion`(`evalQuestionId`,`question`,`shortName`) values (2,'Assess the costs of surveillance component(s) or system(s) (out of two or more) that\r\nachieve(s) a defined objective and rank them according to costs to identify the least-cost option(s)',NULL);
insert  into `evaluationQuestion`(`evalQuestionId`,`question`,`shortName`) values (3,'Assess the effectiveness of 2 or more surveillance component(s) or system(s) in relation\r\nto a surveillance objective and rank the options accordingly',NULL);
insert  into `evaluationQuestion`(`evalQuestionId`,`question`,`shortName`) values (4,'Assess if there is/ are (a) surveillance component(s) or system(s) that achieve a higher\r\neffectiveness than another one at the same cost',NULL);
insert  into `evaluationQuestion`(`evalQuestionId`,`question`,`shortName`) values (5,'Ascertain if a surveillance component or system generates a net benefit in monetary terms\r\nfor society, industry, animal holder',NULL);
insert  into `evaluationQuestion`(`evalQuestionId`,`question`,`shortName`) values (6,'Ascertain if a surveillance component or system generates a net benefit in non-monetary\r\nterms for society, industry, animal holder',NULL);
insert  into `evaluationQuestion`(`evalQuestionId`,`question`,`shortName`) values (7,'Identify the surveillance system (out of two or more) that generates the biggest net benefit\r\nin monetary terms for society, industry, animal holder',NULL);
insert  into `evaluationQuestion`(`evalQuestionId`,`question`,`shortName`) values (8,'Identify the surveillance system (out of two or more) that generates the biggest net benefit\r\nin non-monetary terms for society, industry, animal holder',NULL);
insert  into `evaluationQuestion`(`evalQuestionId`,`question`,`shortName`) values (9,'Identify how surveillance attributes could be improved',NULL);
insert  into `evaluationQuestion`(`evalQuestionId`,`question`,`shortName`) values (10,'Identify how surveillance attributes could be improved and the priority for corrective action\r\nin terms of costs',NULL);

