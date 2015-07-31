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