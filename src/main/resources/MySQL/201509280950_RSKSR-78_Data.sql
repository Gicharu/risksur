INSERT INTO `docPages` (`docName`, `docData`) VALUES ('evaMethods', 'Text here...');

UPDATE `evalElements` SET `inputType` = 'textarea' WHERE `evalElementsId` = '1';
UPDATE `evalElements` SET `inputType` = 'textarea' WHERE `evalElementsId` = '3';
UPDATE `evalElements` SET `inputType` = 'textarea' WHERE `evalElementsId` = '4';


INSERT INTO `evaQuestion_has_criteria_and_method` (`questionId`, `criteriaId`, `methodId`) VALUES
  (18, 1, 3),
  (18, 1, 4),
  (18, 2, 3),
  (18, 2, 4);

DELETE FROM `evaQuestion_has_criteria_and_method` WHERE `questionId` = '10' AND `criteriaId` = '1' AND `methodId` = '3';

UPDATE
  `evaQuestionGroups`
SET
  `questions` = '{\"1\":[1,12,3,6,7,15,18,10,9,4,5,14,8,43],\"2\":[11,4],\"3\":[2,12,6,7,15,18,10,9,5,14,8],\"4\":[5,6,7,14,15,18,8,10,9],\"5\":[13], \"6\": [11,4]}'
WHERE `groupId` = '1' ;


INSERT INTO `docPages` (`docId`, `docName`, `docData`) VALUES
  (14, 'evaMethods', 0x3c703e5465787420686572652e2e2e2e2e2e2e2e2e2e2e2e3c2f703e),
  (15, 'listEvaContext', 0x3c703e5465787420686572653c2f703e),
  (16, 'addEvaContext', 0x3c703e426c6120626c61626c613c2f703e);