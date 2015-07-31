UPDATE
  `frameworkFields`
SET
  `id` = 5,
  `sectionId` = 2,
  `parentId` = NULL,
  `label` = 'What is the state of the diesease in the country?',
  `inputName` = 'stateOfDisease',
  `inputType` = 'checkboxlist',
  `required` = 1,
  `order` = 1,
  `gridField` = 0,
  `description` = NULL,
  `childCount` = NULL,
  `multiple` = NULL
WHERE `frameworkFields`.`id` = 5 ;

INSERT INTO `frameworkFields` (
  `id`,
  `sectionId`,
  `parentId`,
  `label`,
  `inputName`,
  `inputType`,
  `required`,
  `order`,
  `gridField`,
  `description`,
  `childCount`,
  `multiple`
)
VALUES
  (
    56,
    2,
    NULL,
    'Based on the current disease status, what is the primary surveillance objective?',
    'survObj',
    'radiolist',
    1,
    '2',
    0,
    '(Visit the WIKI if you need help deciding)',
    NULL,
    NULL
  ) ;
INSERT INTO `frameworkFields` (`id`, `sectionId`, `parentId`, `label`, `inputName`, `inputType`, `required`, `order`, `gridField`, `description`, `childCount`, `multiple`) VALUES
  (56, 2, NULL, 'Based on the current disease status, what is the primary surveillance objective?', 'survObj', 'radiolist', 1, '2', 0, '(Visit the WIKI if you need help deciding)', NULL, NULL),
  (57, 2, NULL, 'What is the surveillance purpose?', 'survPurpose', 'textarea', 0, '3', 0, 'How will the information collected in this surveillance system be used to inform policy decision (e.g. to eradicate or manage the occurrence of disease or inform trade)', NULL, NULL),
  (59, 2, NULL, 'Risk of introduction', 'diseaseIntroRisk', 'checkboxlist', 0, '4', 0, 'Where disease is currently absent from the country please consider the <b><u>RISK OF INTRODUCTION</u></b>. The risk level may impact on the surveillance approaches used and the choice of surveillance components.', NULL, NULL),
  (61, 2, NULL, 'Also consider adding any other details relevant for disease freedom documentation, for instance, the date of the last detected case (in animals and in case of zoonotic diseases, also humans); or previous documentation about disease freedom. ', 'diseaseFreedomDoc', 'textarea', 0, '5', 0, NULL, NULL, NULL),
  (62, 2, NULL, 'What is the scenario for which disease freedom shall be demonstrated?', 'diseaseFreedomScenario', 'dropdownlist', 0, '6', 0, 'Visit https://wikispaces.com if you need help understanding the scenarios', NULL, NULL),
  (63, 2, NULL, 'Is the aim to demonstrate:', 'diseaseFreedomAim', 'dropdownlist', 0, '7', 0, NULL, NULL, NULL);


INSERT INTO `options` (`optionId`, `frameworkFieldId`, `componentId`, `elementId`, `val`, `label`) VALUES
  (62, 5, NULL, NULL, NULL, 'Believed to be absent'),
  (63, 5, NULL, NULL, NULL, 'Confirmed absent'),
  (64, 5, NULL, NULL, NULL, 'Endemic'),
  (65, 5, NULL, NULL, NULL, 'Sporadic'),
  (66, 5, NULL, NULL, NULL, 'Recently introduced'),
  (67, 56, NULL, NULL, NULL, 'Estimate prevalence'),
  (68, 56, NULL, NULL, NULL, 'Case finding'),
  (69, 56, NULL, NULL, NULL, 'Freedom from disease'),
  (70, 56, NULL, NULL, NULL, 'Early detection'),
  (71, 59, NULL, NULL, NULL, 'Negligible - Event is so rare that it does not merit to be considered '),
  (72, 59, NULL, NULL, NULL, 'Very low - Event is very rare but cannot be excluded'),
  (73, 59, NULL, NULL, NULL, 'Low - Event is rare but does occur'),
  (74, 59, NULL, NULL, NULL, 'Medium - Event occurs regularly'),
  (75, 59, NULL, NULL, NULL, 'High - Event occurs very often'),
  (76, 59, NULL, NULL, NULL, 'Very high - Event occurs almost certainly'),
  (77, 59, NULL, NULL, NULL, 'Unknown – where surveillance is being carried out '),
  (78, 62, NULL, NULL, 'scenario1', 'Achieve disease freedom after control of a disease (scenario 1)'),
  (79, 62, NULL, NULL, 'scenario2', 'Achieve disease freedom after control of an endemic disease (scenario 2)'),
  (80, 62, NULL, NULL, 'scenario3', 'Maintain disease freedom after eradication of a disease (scenario 3)'),
  (81, 62, NULL, NULL, 'scenario4', 'Maintain disease freedom when disease has not been present for a long time or has been historically absent (scenario 4)'),
  (82, 63, NULL, NULL, NULL, 'Relative freedom'),
  (83, 63, NULL, NULL, NULL, 'Absolute freedom');

UPDATE
  `programpages`
SET
  `pageId` = 11,
  `pageName` = 'Manage Component Forms',
  `path` = 'surformdetails/index',
  `parentId` = 8,
  `menuOrder` = 16,
  `target` = NULL,
  `active` = 1,
  `comments` = NULL
WHERE `programpages`.`pageId` = 11 ;

UPDATE
  `programpages`
SET
  `pageId` = 17,
  `pageName` = 'Manage Evaluation Tool',
  `path` = 'admineva/index',
  `parentId` = 8,
  `menuOrder` = 18,
  `target` = NULL,
  `active` = 1,
  `comments` = NULL
WHERE `programpages`.`pageId` = 17 ;

UPDATE `permissions` SET `id` = 16,`name` = 'List Component forms',`description` = 'List Component forms',`controller` = 'surformdetails',`action` = 'index',`bizrule` = '' WHERE `permissions`.`id` = 16;
UPDATE `permissions` SET `id` = 19,`name` = 'Add Component forms',`description` = 'Add Component forms',`controller` = 'surformdetails',`action` = 'create',`bizrule` = '' WHERE `permissions`.`id` = 19;
UPDATE `permissions` SET `id` = 20,`name` = 'Edit Component forms',`description` = 'Edit Component forms',`controller` = 'surformdetails',`action` = 'update',`bizrule` = '' WHERE `permissions`.`id` = 20;
UPDATE `permissions` SET `id` = 21,`name` = 'DeleteComponent forms',`description` = 'Delete Component forms',`controller` = 'surformdetails',`action` = 'delete',`bizrule` = '' WHERE `permissions`.`id` = 21;
UPDATE `permissions` SET `id` = 62,`name` = 'actionListEvaMethods',`description` = 'C/A to view and manage economic evaluation me',`controller` = 'admineva',`action` = 'listEvaMethods',`bizrule` = '' WHERE `permissions`.`id` = 62;
UPDATE `permissions` SET `id` = 63,`name` = 'actionAddEvaMethod',`description` = 'C/A to add new evaluation methos',`controller` = 'admineva',`action` = 'addEvaMethod',`bizrule` = '' WHERE `permissions`.`id` = 63;
UPDATE `permissions` SET `id` = 64,`name` = 'actionUpdateEvaMethod',`description` = 'C/A to update the economic evaluation methods',`controller` = 'admineva',`action` = 'updateEvaMethod',`bizrule` = '' WHERE `permissions`.`id` = 64;
UPDATE `permissions` SET `id` = 65,`name` = 'actionDeleteEvaMethod',`description` = 'C/A to delete an economic evaluation method',`controller` = 'admineva',`action` = 'deleteEvaMethod',`bizrule` = '' WHERE `permissions`.`id` = 65;

INSERT INTO `evaMethods` (`evaMethodId`, `name`) VALUES
  (5, 'Functional assessment'),
  (6, 'Process assessment');

TRUNCATE TABLE `evaluationQuestion`;
--
-- Dumping data for table `evaluationQuestion`
--

INSERT INTO `evaluationQuestion` (`evalQuestionId`, `question`, `questionNumber`, `parentQuestion`, `flag`) VALUES
  (1, 'Assess whether one or more surveillance component(s) is/are capable of meeting a technical effectiveness target ', NULL, NULL, 'final'),
  (2, 'Assess the costs of surveillance components (out of two or more) that achieve a defined effectiveness target', NULL, NULL, 'final'),
  (3, 'Assess the technical effectiveness of one or more surveillance components', NULL, NULL, 'final'),
  (4, 'Assess the technical effectiveness of one or more surveillance components and the functional aspects of surveillance that may influence effectiveness', NULL, NULL, 'final'),
  (5, 'Assess whether a surveillance component generates a net benefit for society, industry, or animal holder(s): Benefit to be measured in monetary terms', NULL, NULL, 'final'),
  (6, 'Assess whether a surveillance component generates a net benefit for society, industry, or animal holder(s): Benefit to be measured in non-monetary terms (effectiveness is one type of non-monetary benefit)', NULL, NULL, 'final'),
  (7, 'Assess whether a surveillance component generates a net benefit for society, industry, or animal holder(s): Benefit to be measured in both monetary and non-monetary terms (effectiveness is one type of non-monetary benefit)', NULL, NULL, 'final'),
  (8, 'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s): Benefit to be measured in monetary terms', NULL, NULL, 'final'),
  (9, 'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s): Benefit to be measured in both monetary and non-monetary terms (effectiveness is one type of non-monetary benefit)', NULL, NULL, 'final'),
  (10, 'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s) under a budget constraint Budget constraint and benefit to be measured in non-monetary terms (effectiveness is one type of non-monetary benefit)', NULL, NULL, 'final'),
  (11, 'Assess the functional aspects of surveillance which may influence effectiveness', NULL, NULL, 'final'),
  (12, 'Assess the costs and effectiveness of surveillance components (out of two or more) to determine which  achieves a defined effectiveness target at least cost, the effectiveness needs to be determined\r\n', NULL, NULL, 'final'),
  (13, 'Assess the surveillance structure, function and processes', NULL, NULL, 'final'),
  (14, 'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s) and benefit to be measured in monetary terms', NULL, NULL, 'final'),
  (15, 'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s) and benefit to be measured in non-monetary terms or to be expressed as an effectiveness measure', NULL, NULL, 'final'),
  (16, 'Are you aiming to evaluate the effectiveness of surveillance or how well surveillance is performing or to re-design your surveillance to improve its performance', NULL, 41, NULL),
  (17, 'Are you aiming to evaluate how well your surveillance is performing or re-design your surveillance to improve its performance', NULL, 41, NULL),
  (18, 'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s) and benefit to be measured in both monetary and non-monetary terms (or to be expressesed as an effectiveness measure)', NULL, NULL, 'final'),
  (20, 'Do you want to assess whether your surveillance meets a specified technical target or do you want to assess the absolute level of effectiveness', NULL, 16, NULL),
  (21, 'What do you want to evaluate', NULL, 16, NULL),
  (22, 'Have you evaluated the effectiveness of your surveillance', NULL, 16, NULL),
  (23, 'Do you want to make a comparison between two or more alternative surveillance designs (e.g. risk-based vs conventional) to find out whether one is preferable to the other one or to compare a novel surveillance component to a situation in which there is no surveillance or do you want to evaluate the performance of a surveillance component without making a comparison? ', NULL, 21, NULL),
  (24, 'Have you determined the effectiveness ', NULL, 21, NULL),
  (25, 'Have you evaluated the effectiveness of your surveillance?', NULL, 16, NULL),
  (26, 'What measures will be used to assess the efficiency /effectiveness of surveillance', NULL, 23, NULL),
  (27, 'Do the components that you want to compare have the same objective', NULL, 23, NULL),
  (28, 'What measures will be used to assess the efficiency /effectiveness of surveillance', NULL, 27, NULL),
  (29, 'SORRY, The EVA tool does currently not provide guidance for evaluation of surveillance components with different objectives ', NULL, 0, NULL),
  (30, 'Do the alternative components you are comparing achieve a target effectiveness', NULL, 28, NULL),
  (31, 'Do the alternative components you are comparing achieve a target effectiveness', NULL, 28, NULL),
  (32, 'Do you want to assess whether your surveillance meets a specified technical target \r\nor do you want to assess the absolute level of effectiveness', NULL, 28, NULL),
  (33, 'Include functional aspects?', NULL, 32, NULL),
  (34, 'How can you measure benefits?', NULL, 28, NULL),
  (35, 'Is there a budget constraint?', NULL, 34, NULL),
  (36, 'Is there a budget constraint?', NULL, 34, NULL),
  (37, 'Is there a budget constraint?', NULL, 34, NULL),
  (41, 'Evaluations can be carried out at system or component level, at what level would you like to carry out your evaluation /improvement.  ', NULL, NULL, 'primary'),
  (42, 'What do you want to evaluate?', NULL, 17, NULL),
  (43, 'Assess the technical effectiveness of the surveillance system', NULL, NULL, 'final');

TRUNCATE TABLE `evaQuestion_has_criteria_and_method`;
--
-- Dumping data for table `evaQuestion_has_criteria_and_method`
--

INSERT INTO `evaQuestion_has_criteria_and_method` (`questionId`, `criteriaId`, `methodId`) VALUES
  (1, 1, 1),
  (2, 1, 2),
  (2, 2, 2),
  (3, 1, 1),
  (4, 1, 1),
  (4, 1, 5),
  (5, 1, 3),
  (5, 3, 3),
  (6, 1, 3),
  (6, 2, 3),
  (6, 4, 3),
  (7, 1, 3),
  (7, 1, 4),
  (7, 2, 3),
  (7, 2, 4),
  (7, 3, 3),
  (7, 3, 4),
  (7, 4, 3),
  (7, 4, 4),
  (8, 1, 3),
  (8, 3, 3),
  (9, 1, 3),
  (9, 1, 4),
  (9, 2, 3),
  (9, 2, 4),
  (9, 3, 3),
  (9, 3, 4),
  (9, 4, 3),
  (9, 4, 4),
  (10, 1, 3),
  (10, 2, 3),
  (10, 4, 3),
  (11, 1, 5),
  (12, 1, 2),
  (12, 2, 2),
  (13, 0, 6),
  (14, 1, 3),
  (14, 3, 3),
  (15, 1, 3),
  (15, 4, 3),
  (18, 3, 4),
  (18, 4, 4),
  (43, 1, 1);