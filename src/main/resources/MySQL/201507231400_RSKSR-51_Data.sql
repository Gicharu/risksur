--
-- Dumping data for table `evaCriteria`
--

INSERT INTO `evaCriteria` (`criteriaId`, `name`) VALUES
(1, 'Effectiveness'),
(2, 'Cost'),
(3, 'Monetary benefit'),
(4, 'Non monetary benefit');

--
-- Dumping data for table `evaMethods`
--

INSERT INTO `evaMethods` (`evaMethodId`, `name`) VALUES
(1, 'Effectiveness attribute'),
(2, 'Least cost assessment'),
(3, 'Cost benefit assessment'),
(4, 'Cost effectiveness assessment');

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
# SET time_zone = "+00:00";

--
-- Database: `risksur`
--

--
-- Truncate table before insert `pages_has_roles`
--

TRUNCATE TABLE `pages_has_roles`;
--
-- Dumping data for table `pages_has_roles`
--

INSERT INTO `pages_has_roles` (`pageId`, `roleId`) VALUES
  (2, 1),
  (3, 1),
  (6, 1),
  (8, 1),
  (9, 1),
  (10, 1),
  (11, 1),
  (12, 1),
  (13, 1),
  (14, 1),
  (15, 1),
  (17, 1),
  (2, 2),
  (3, 2),
  (6, 2),
  (8, 2),
  (9, 2),
  (10, 2),
  (11, 2),
  (12, 2),
  (13, 2),
  (14, 2),
  (15, 2),
  (17, 2),
  (2, 3),
  (3, 3),
  (6, 3),
  (9, 3),
  (14, 3),
  (15, 3);

--
-- Truncate table before insert `permissions`
--

TRUNCATE TABLE `permissions`;
--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `description`, `controller`, `action`, `bizrule`) VALUES
  (1, 'Design index', 'design index', 'design', 'index', ''),
  (2, 'Design fetchComponents', 'design fetchComponents', 'design', 'fetchComponents', ''),
  (3, 'Design view', 'design view', 'design', 'showDesign', ''),
  (4, 'Add components', 'Add components', 'design', 'addComponent', ''),
  (5, 'List Components', 'List Components', 'design', 'listComponents', ''),
  (6, 'Create design', 'Create Design', 'design', 'createDesign', ''),
  (7, 'Edit components', 'Edit components', 'design', 'editComponent', ''),
  (8, 'Show components', 'Show components', 'design', 'showComponent', ''),
  (9, 'Delete components', 'Delete components', 'design', 'deleteComponent', ''),
  (10, 'Delete design', 'Delete design', 'design', 'deleteDesign', ''),
  (11, 'Edit design', 'Edit design', 'design', 'editDesign', ''),
  (12, 'List goals', 'List goals', 'admin', 'listGoals', ''),
  (13, 'Add goals', 'Add goals', 'admin', 'addGoal', ''),
  (14, 'Edit goals', 'Edit goals', 'admin', 'editGoal', ''),
  (15, 'Delete goals', 'Delete goals', 'admin', 'deleteGoal', ''),
  (16, 'List Component forms', 'List Component forms', 'surFormDetails', 'index', ''),
  (19, 'Add Component forms', 'Add Component forms', 'surFormDetails', 'create', ''),
  (20, 'Edit Component forms', 'Edit Component forms', 'surFormDetails', 'update', ''),
  (21, 'DeleteComponent forms', 'Delete Component forms', 'surFormDetails', 'delete', ''),
  (22, 'Get form input options', 'Get options for form components of type selec', 'surFormDetails', 'getInputTypeOpts', ''),
  (23, 'Manage Options', 'Manage Options', 'options', 'index', ''),
  (24, 'Add Options', 'Add Options', 'options', 'addOption', ''),
  (25, 'Edit Options', 'Edit Options', 'options', 'editOption', ''),
  (26, 'Delete Options', 'Delete Options', 'options', 'deleteOption', ''),
  (27, 'Register Users', 'Register Users', 'site', 'registerUser', ''),
  (28, 'duplicate components', 'duplicate components', 'design', 'duplicateComponent', ''),
  (29, 'Manage Users', 'Manage Users', 'users', 'index', ''),
  (30, 'Add Users', 'Add Users', 'users', 'createUser', ''),
  (31, 'Update User', 'Update User', 'users', 'updateUser', ''),
  (32, 'Delete User', 'Delete User', 'users', 'deleteUser', ''),
  (33, 'Select Attribute', 'Select Attribute', 'attribute', 'selectAttribute', ''),
  (34, 'Add Multiple Components', 'Add Multiple Components', 'design', 'addMultipleComponents', ''),
  (35, 'Manage Attributes', 'Manage Attributes', 'attribute', 'index', ''),
  (36, 'Add Attributes', 'Add Attributes', 'attribute', 'addAttribute', ''),
  (37, 'Edit Attributes', 'Update Attributes', 'attribute', 'editAttribute', ''),
  (38, 'Delete Attributes', 'Delete Attributes', 'attribute', 'deleteAttribute', ''),
  (39, 'Add Relation', 'Add Relation', 'attribute', 'addRelation', ''),
  (40, 'View Relations', 'View Relations', 'attribute', 'listRelations', ''),
  (41, 'Delete Relation', 'Delete Relation', 'attribute', 'deleteRelation', ''),
  (42, 'Evaluation Index', 'Evaluation Index', 'evaluation', 'index', ''),
  (43, 'Evaluation Page', 'Evaluation Page', 'evaluation', 'evaPage', ''),
  (44, 'Save Evaluation Page', 'Save Evaluation Page', 'evaluation', 'saveEvaPage', ''),
  (45, 'upload image Page', 'upload image Page', 'evaluation', 'imageUpload', ''),
  (46, 'Eva Concepts', 'Eva Concepts', 'evaluation', 'evaConcept', ''),
  (47, 'Save Evaluation Concept', 'Save Evaluation Concept', 'evaluation', 'saveEvaConcept', ''),
  (48, 'Evaluation context', 'Evaluation context', 'evaluation', 'addEvaContext', ''),
  (49, 'actionSelectCriteriaMethod', 'C/A to select evaluation criteria & method', 'evaluation', 'selectCriteriaMethod', ''),
  (50, 'Delete Evaluation context', 'Delete Evaluation context', 'evaluation', 'deleteEval', ''),
  (51, 'List context', 'List surveillance context', 'context', 'list', ''),
  (52, 'Create context', 'Create surveillance context', 'context', 'create', ''),
  (53, 'Delete context', 'Delete surveillance context', 'context', 'delete', ''),
  (54, 'Update context', 'Update surveillance context', 'context', 'update', ''),
  (55, 'View context', 'View surveillance context', 'context', 'view', ''),
  (56, 'Context index', 'Context index', 'context', 'index', ''),
  (57, 'Get surveillance summary', 'Get a list of attributes of a certain surveil', 'evaluation', 'getSurveillanceSummary', ''),
  (58, 'Select evaluation question', 'Select evaluation question', 'evaluation', 'selectEvaQuestion', ''),
  (59, 'evalQuestionList', 'Evaluation question list', 'evaluation', 'evalQuestionList', ''),
  (60, 'actionEvaQuestionWizard', 'Surveillance question guided wizard', 'evaluation', 'evaQuestionWizard', ''),
  (61, 'actionEvaMethods', 'Evaluation methods controller action', 'evaluation', 'evaMethods', ''),
  (62, 'actionListEvaMethods', 'C/A to view and manage economic evaluation me', 'adminEva', 'listEvaMethods', ''),
  (63, 'actionAddEvaMethod', 'C/A to add new evaluation methos', 'adminEva', 'addEvaMethod', ''),
  (64, 'actionUpdateEvaMethod', 'C/A to update the economic evaluation methods', 'adminEva', 'updateEvaMethod', ''),
  (65, 'actionDeleteEvaMethod', 'C/A to delete an economic evaluation method', 'adminEva', 'deleteEvaMethod', ''),
  (66, 'actionEvaAttributes', 'C/A to retrieve economic evaluation attribute', 'evaluation', 'evaAttributes', ''),
  (70, 'actionSavePage', 'Dummy C/A to save surveillance introduction p', 'context', 'savePage', ''),
  (71, 'actionIntro', 'C/A to diplay intro page', 'context', 'intro', ''),
  (72, 'actionIndex', 'C/A to introduce evaluation tool administrati', 'adminEva', 'index', ''),
  (73, 'actionListEvaContext', 'C/A to list available evaluation context elem', 'adminEva', 'listEvaContext', ''),
  (74, 'actionUpdateEvaContext', 'C/A to update evaluation context form field', 'adminEva', 'updateEvaContext', ''),
  (75, 'actionDeleteEvaContext', 'C/A to delete evaluation context form field', 'adminEva', 'deleteEvaContext', ''),
  (76, 'actionListEvaContext', 'C/A to list evaluation contexts', 'evaluation', 'listEvaContext', ''),
  (77, 'actionSetEvaContext', 'C/A to set the evaluation context', 'evaluation', 'setEvaContext', ''),
  (78, 'actionSelectEvaAttributes', 'C/A to select evaluation attributes', 'evaluation', 'selectEvaAttributes', '');

--
-- Truncate table before insert `programpages`
--

TRUNCATE TABLE `programpages`;
--
-- Dumping data for table `programpages`
--

INSERT INTO `programpages` (`pageId`, `pageName`, `path`, `parentId`, `menuOrder`, `target`, `active`, `comments`) VALUES
  (2, 'Design Tool', 'design/index', 0, 2, '', 1, NULL),
  (3, 'Evaluation Tool', 'evaluation/evaPage', 0, 3, '', 1, NULL),
  (6, 'Statistical Tools', 'stage.tracetracker.com/epitools', 0, 6, '_blank', 1, NULL),
  (8, 'Admin', '', 0, 9, '', 1, NULL),
  (9, 'noMenu', '', 0, 14, '', 1, NULL),
  (10, 'Manage Goals', 'admin/listGoals', 8, 15, '', 1, NULL),
  (11, 'Manage Component Forms', 'surFormDetails/index', 8, 16, NULL, 1, NULL),
  (12, 'Manage Select Options', 'options/index', 8, 15, '', 1, NULL),
  (13, 'Manage Users', 'users/index', 8, 16, '', 1, NULL),
  (14, 'Manage Attributes', 'attribute/index', 8, 17, '', 1, NULL),
  (15, 'Surveillance System', 'context/index', 0, 1, NULL, 1, NULL),
  (17, 'Manage Evaluation Tool', 'adminEva/index', 8, 18, NULL, 1, NULL);

--
-- Truncate table before insert `roles_has_permissions`
--

TRUNCATE TABLE `roles_has_permissions`;
--
-- Dumping data for table `roles_has_permissions`
--

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES
  (1, 1),
  (1, 2),
  (1, 3),
  (2, 1),
  (2, 2),
  (2, 3),
  (3, 1),
  (3, 2),
  (3, 3),
  (4, 1),
  (4, 2),
  (4, 3),
  (5, 1),
  (5, 2),
  (5, 3),
  (6, 1),
  (6, 2),
  (6, 3),
  (7, 1),
  (7, 2),
  (7, 3),
  (8, 1),
  (8, 2),
  (8, 3),
  (9, 1),
  (9, 2),
  (10, 1),
  (10, 2),
  (11, 1),
  (11, 2),
  (11, 3),
  (12, 1),
  (12, 2),
  (13, 1),
  (13, 2),
  (14, 1),
  (14, 2),
  (15, 1),
  (15, 2),
  (16, 1),
  (16, 2),
  (19, 1),
  (19, 2),
  (20, 1),
  (20, 2),
  (21, 1),
  (21, 2),
  (22, 1),
  (22, 2),
  (23, 1),
  (23, 2),
  (24, 1),
  (24, 2),
  (25, 1),
  (25, 2),
  (26, 1),
  (26, 2),
  (28, 1),
  (28, 2),
  (29, 1),
  (29, 2),
  (30, 1),
  (30, 2),
  (31, 1),
  (31, 2),
  (32, 1),
  (32, 2),
  (33, 1),
  (33, 2),
  (33, 3),
  (34, 1),
  (34, 2),
  (34, 3),
  (35, 1),
  (35, 2),
  (36, 1),
  (36, 2),
  (37, 1),
  (37, 2),
  (38, 1),
  (38, 2),
  (39, 1),
  (39, 2),
  (40, 1),
  (40, 2),
  (41, 1),
  (41, 2),
  (42, 1),
  (42, 2),
  (42, 3),
  (43, 1),
  (43, 2),
  (43, 3),
  (44, 1),
  (44, 2),
  (45, 1),
  (45, 2),
  (46, 1),
  (46, 2),
  (46, 3),
  (47, 1),
  (47, 2),
  (48, 1),
  (48, 2),
  (48, 3),
  (49, 1),
  (49, 2),
  (49, 3),
  (50, 1),
  (50, 2),
  (50, 3),
  (51, 1),
  (51, 2),
  (52, 1),
  (52, 2),
  (53, 1),
  (53, 2),
  (54, 1),
  (54, 2),
  (55, 1),
  (55, 2),
  (56, 1),
  (56, 2),
  (57, 1),
  (57, 2),
  (57, 3),
  (58, 1),
  (58, 2),
  (58, 3),
  (59, 1),
  (59, 2),
  (59, 3),
  (60, 1),
  (60, 2),
  (60, 3),
  (61, 1),
  (61, 2),
  (61, 3),
  (62, 1),
  (62, 2),
  (63, 1),
  (63, 2),
  (64, 1),
  (64, 2),
  (65, 1),
  (65, 2),
  (66, 1),
  (66, 2),
  (70, 1),
  (70, 2),
  (71, 1),
  (71, 2),
  (71, 3),
  (72, 1),
  (72, 2),
  (73, 1),
  (73, 2),
  (74, 1),
  (74, 2),
  (75, 1),
  (75, 2),
  (76, 1),
  (76, 2),
  (76, 3),
  (77, 1),
  (77, 2),
  (77, 3),
  (78, 1),
  (78, 2),
  (78, 3);
SET FOREIGN_KEY_CHECKS=1;

