INSERT INTO `programpages` (`pageId`, `pageName`, `path`, `parentId`, `menuOrder`, `target`, `active`, `comments`) VALUES
  (18, 'Home', 'system/index', 0, 1, NULL, 1, NULL);

INSERT INTO `pages_has_roles` (`pageId`, `roleId`) VALUES
  (18, 1),
  (18, 2),
  (18, 3);

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES
  (71, 1),
  (71, 2),
  (71, 3),
  (93, 1),
  (93, 2),
  (93, 3),
  (94, 1),
  (94, 2),
  (94, 3),
  (95, 1),
  (95, 2),
  (95, 3),
  (96, 1),
  (96, 2),
  (96, 3);


UPDATE `permissions`
SET `id` = 71,`name` = 'actionIndex',`description` = 'C/A to display intro page',`controller` = 'system',`action` = 'index',`bizrule` = '' WHERE `permissions`.`id` = 71;

INSERT IGNORE INTO `permissions` (`id`, `name`, `description`, `controller`, `action`, `bizrule`) VALUES
  (88, 'actionGetQuestionGroups', 'C/A to rerieve question groups', 'adminattributerelevance', 'getQuestionGroups', '');


TRUNCATE TABLE `evaCriteria`;
--
-- Dumping data for table `evaCriteria`
--

INSERT INTO `evaCriteria` (`criteriaId`, `name`) VALUES
  (1, 'Effectiveness'),
  (2, 'Cost'),
  (3, 'Monetary benefit'),
  (4, 'Non monetary benefit'),
  (5, 'Function'),
  (6, 'Strenth and weaknesses');

--
-- Truncate table before insert `evaMethods`
--

TRUNCATE TABLE `evaMethods`;
--
-- Dumping data for table `evaMethods`
--

INSERT INTO `evaMethods` (`evaMethodId`, `name`) VALUES
  (1, 'Effectiveness attribute assessment'),
  (2, 'Least cost assessment'),
  (3, 'Cost benefit analysis'),
  (4, 'Cost effectiveness analysis'),
  (5, 'Functional assessment'),
  (6, 'Process assessment'),
  (7, 'Structure assessment');

--
-- Truncate table before insert `evaQuestion_has_criteria_and_method`
--

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
  (4, 5, 1),
  (4, 5, 5),
  (5, 1, 3),
  (5, 2, 3),
  (5, 3, 3),
  (6, 1, 4),
  (6, 2, 4),
  (6, 4, 4),
  (7, 1, 3),
  (7, 1, 4),
  (7, 2, 3),
  (7, 2, 4),
  (7, 3, 3),
  (7, 3, 4),
  (7, 4, 3),
  (7, 4, 4),
  (8, 1, 3),
  (8, 2, 3),
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
  (10, 2, 4),
  (10, 4, 4),
  (11, 5, 5),
  (12, 1, 2),
  (12, 2, 2),
  (13, 6, 5),
  (13, 6, 6),
  (13, 6, 7),
  (14, 1, 3),
  (14, 2, 3),
  (14, 3, 3),
  (15, 1, 4),
  (15, 2, 4),
  (15, 4, 4),
  (18, 3, 3),
  (18, 3, 4),
  (18, 4, 3),
  (18, 4, 4),
  (43, 1, 1);

INSERT INTO `permissions` (
  `name`,
  `description`,
  `controller`,
  `action`
)
VALUES
  (
    'actionSelectComponents',
    'C/A to select components for evaluation',
    'evaluation',
    'selectComponents'
  ),
  ('actionUpdateEvacontext', 'C/A to update the evaluation context', 'evaluation', 'updateEvaContext'),
  ('actionPerformEvaluation', 'C/A to perform the evaluation', 'evaluation', 'performEvaluation'),
  ('actionReport', 'C/A to instruct on how to report evaluation', 'evaluation', 'report');
