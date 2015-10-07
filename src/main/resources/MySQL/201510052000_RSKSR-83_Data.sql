INSERT INTO `docPages` (`docName`, `docData`) VALUES
('optionsHome', 0x3c703e6f707420686f6d6520343c2f703e),
('adminEvaHome', 0x3c68333e204d616e616765204576616c756174696f6e20546f6f6c3c2f68333e3c703e0a09546869732073656374696f6e20616c6c6f777320796f7520746f20766965772c206164642c2075706461746520616e642064656c65746520766172696f757320636f6d706f6e656e7473206f6620746865206576616c756174696f6e20746f6f6c2e2053656c6563740a09612073656374696f6e20666f726d20746865206c65667420746f20626567696e2e0a3c2f703e),
('evalQuestionList', 0x3c703e436f6e74656e7420686572653c2f703e),
('evaSummary', 0x3c703e436f6e74656e7420686572653c2f703e);



-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 07, 2015 at 09:17 AM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.13

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `risksur`
--

--
-- Truncate table before insert `evalQuestionAnswers`
--

TRUNCATE TABLE `evalQuestionAnswers`;
--
-- Dumping data for table `evalQuestionAnswers`
--

INSERT INTO `evalQuestionAnswers` (`id`, `evalQuestionId`, `optionName`, `nextQuestion`, `flashQuestion`, `url`) VALUES
  (2, 1, 'Evaluate / improve one or more distinct surveillance components', 16, NULL, NULL),
  (3, 1, 'Evaluate a surveillance system', 17, NULL, NULL),
  (9, 16, 'To evaluate the component', 21, NULL, NULL),
  (10, 16, 'To redesign surveillance to improve its performance?', 22, NULL, NULL),
  (13, 21, 'Evaluate the efficiency and/or effectiveness of component', 23, NULL, NULL),
  (14, 48, 'Evaluate functional aspects', 11, NULL, NULL),
  (15, 21, 'To evaluate the strengths and weaknesses of the structure, function and processes of the component', 13, NULL, NULL),
  (16, 22, 'Yes, effectiveness has been evaluated', 47, NULL, NULL),
  (17, 22, 'No, effectiveness has not been evaluated', 49, NULL, NULL),
  (18, 32, 'YES, functional aspects will be assessed', 4, NULL, NULL),
  (19, 32, 'No functional aspects will not be assessed', 3, NULL, NULL),
  (20, 28, 'Cost only', 30, NULL, NULL),
  (22, 28, 'Effectiveness only (technical performance)', 32, NULL, NULL),
  (23, 28, 'Cost and effectiveness (technical performance)', 31, NULL, NULL),
  (26, 45, 'Assess whether surveillance meets a specified minimum technical effectiveness target', 1, NULL, NULL),
  (27, 45, 'Assess the absolute level of effectiveness', 32, NULL, NULL),
  (29, 27, 'NO the components to be compared do not have the same objective', 23, NULL, NULL),
  (30, 34, 'Monetary Terms?', 35, NULL, NULL),
  (31, 34, 'Non-Monetary terms?', 36, NULL, NULL),
  (32, 34, 'Monetary and non-monetary terms?', 37, NULL, NULL),
  (33, 35, 'YES there is a cost ceiling', 10, NULL, NULL),
  (35, 35, 'No, there is no budget constraint', 15, NULL, NULL),
  (36, 30, 'YES, the components achieve a specified technical effectiveness target', 2, NULL, NULL),
  (37, 30, 'NO, there is no specified technical effectiveness target or the effectiveness of components has not been assessed', 52, NULL, NULL),
  (38, 37, 'YES there is a cost ceiling', 9, NULL, NULL),
  (39, 37, 'No, there is no budget constraint', 18, NULL, NULL),
  (40, 41, 'System level', 17, NULL, NULL),
  (41, 41, 'Component level', 16, NULL, NULL),
  (43, 48, 'Re-design surveillance', NULL, NULL, 'design/listComponents'),
  (44, 17, 'To evaluate the system', 42, NULL, NULL),
  (45, 42, 'Evaluate the effectiveness of the system', 43, NULL, NULL),
  (46, 42, 'To evaluate the strengths and weaknesses of the structure, function and processes of the system', 13, NULL, NULL),
  (47, 23, 'I want to compare alternative designs or compare a surveillance design to a situation with no surveillance', 27, NULL, NULL),
  (48, 23, 'I just want to evaluate a single component', 53, NULL, NULL),
  (49, 44, 'Cost and effectiveness', 31, NULL, NULL),
  (50, 44, 'Cost only', 30, NULL, NULL),
  (51, 44, 'Effectiveness only', 45, NULL, NULL),
  (52, 48, 'Use the surveillance design tool to re-design surveillance using results of the evaluations carried out', NULL, NULL, 'design/listComponents'),
  (53, 49, 'Re-design surveillance', NULL, NULL, 'design/listComponents'),
  (54, 49, 'Carry out an evaluation', 57, 'The EVA tool does currently  not provide guidance for evaluation of surveillance components with different objectives you can either evaluate each single component separately or compare each component to a situation with no surveillance', NULL),
  (55, 27, 'YES the components to be compared have the same objective', 44, NULL, NULL),
  (56, 44, 'Cost and benefits', 34, NULL, NULL),
  (59, 31, 'Assess whether components achieve a specified technical effectiveness', 24, NULL, NULL),
  (60, 31, 'NO, technical effectiveness target will not be specified.', 35, NULL, NULL),
  (61, 24, 'Effectiveness of components is known', 2, NULL, NULL),
  (62, 24, 'Effectiveness of components has not yet been assessed', 12, NULL, NULL),
  (64, 52, 'Assess costs', NULL, NULL, 'epitools'),
  (65, 52, 'Evaluation cost and effectiveness', 44, NULL, NULL),
  (66, 36, 'YES there is a cost ceiling', 10, NULL, NULL),
  (68, 36, 'No, there is no budget constraint', 15, NULL, NULL),
  (69, 53, 'Cost only', NULL, NULL, 'epitools'),
  (70, 53, 'Effectiveness only', 54, NULL, NULL),
  (71, 53, 'Cost and effectiveness or economic efficiency', 23, 'Note:If you want to evaluate cost effectiveness or economic efficiency you need to compare alternative designs or compare surveillance to a situation with no surveillance  ', NULL),
  (74, 54, 'Yes, there is a specified target effectiveness', 1, NULL, NULL),
  (75, 54, 'NO, there is no specified target effectiveness', 55, NULL, NULL),
  (77, 55, 'YES, functional aspects will be assessed', 4, NULL, NULL),
  (78, 55, 'No functional aspects will not be assessed', 3, NULL, NULL),
  (80, 21, 'To evaluate the functional aspects of the component that may influence its effectiveness.', 56, NULL, NULL),
  (82, 56, 'Yes effectiveness has been assessed', 11, NULL, NULL),
  (83, 56, 'No effectiveness has not been assessed', 57, NULL, NULL),
  (85, 57, 'Evaluate only functional aspects', 11, NULL, NULL),
  (86, 57, 'Evaluate effectiveness before functional aspects', 3, NULL, NULL),
  (87, 57, 'Evaluate effectiveness and functional aspects at the same time', 4, NULL, NULL),
  (88, 17, 'Re-design surveillance to improve its performance', 58, NULL, NULL),
  (89, 58, 'Yes, the system has been evaluated', NULL, NULL, 'design/listComponents'),
  (91, 58, 'No, the system has not been evaluated', 59, NULL, NULL),
  (92, 59, 'Re-design surveillance system', NULL, NULL, 'design/listComponents'),
  (93, 59, 'Carry out an evaluation', 42, NULL, ''),
  (94, 47, 'Yes, functional aspects have been evaluated', NULL, NULL, 'design/listcomponents'),
  (95, 47, 'No, functional aspects have not been evaluated', 48, NULL, ''),
  (96, 30, 'YES, the components achieve a specified technical effectiveness target', 2, NULL, NULL),
  (97, 27, 'The comparison will be to a situation in which there is no surveillance', 60, NULL, NULL),
  (99, 60, 'Cost and effectiveness ', 6, NULL, NULL),
  (100, 60, 'Costs and benefits', 61, NULL, NULL),
  (101, 61, 'Monetary terms', 5, NULL, NULL),
  (102, 61, 'Non -Monetary terms', 6, NULL, NULL),
  (103, 61, 'Monetary and non-monetary terms', 7, NULL, NULL);

--
-- Truncate table before insert `evaluationQuestion`
--

TRUNCATE TABLE `evaluationQuestion`;
--
-- Dumping data for table `evaluationQuestion`
--

INSERT INTO `evaluationQuestion` (`evalQuestionId`, `question`, `questionNumber`, `parentQuestion`, `flag`) VALUES
  (1, 'Assess whether one or more surveillance component(s) is/are capable of meeting a technical effectiveness target ', '1', NULL, 'final'),
  (2, 'Assess the costs of surveillance components (out of two or more) that achieve a defined effectiveness target', '2', NULL, 'final'),
  (3, 'Assess the technical effectiveness of one or more surveillance components', '4', NULL, 'final'),
  (4, 'Assess the technical effectiveness of one or more surveillance components and the functional aspects of surveillance that may influence effectiveness', '9', NULL, 'final'),
  (5, 'Assess whether a surveillance component generates a net benefit for society, industry, or animal holder(s): Benefit to be measured in monetary terms', '5(a)', NULL, 'final'),
  (6, 'Assess whether a surveillance component generates a net benefit for society, industry, or animal holder(s): Benefit to be measured in non-monetary terms (effectiveness is one type of non-monetary benefit)', '5(b)', NULL, 'final'),
  (7, 'Assess whether a surveillance component generates a net benefit for society, industry, or animal holder(s): Benefit to be measured in both monetary and non-monetary terms (effectiveness is one type of non-monetary benefit)', '5(c)', NULL, 'final'),
  (8, 'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s): Benefit to be measured in monetary terms', '7(a)', NULL, 'final'),
  (9, 'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s): Benefit to be measured in both monetary and non-monetary terms (effectiveness is one type of non-monetary benefit)', '7(c)', NULL, 'final'),
  (10, 'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s) under a budget constraint Budget constraint and benefit to be measured in non-monetary terms (effectiveness is one type of non-monetary benefit)', '7(b)', NULL, 'final'),
  (11, 'Assess the functional aspects of surveillance which may influence effectiveness', '8', NULL, 'final'),
  (12, 'Assess the costs and effectiveness of surveillance components (out of two or more) to determine which  achieves a defined effectiveness target at least cost, the effectiveness needs to be determined\r\n', '3', NULL, 'final'),
  (13, 'Assess the surveillance structure, function and processes', '11', NULL, 'final'),
  (14, 'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s) and benefit to be measured in monetary terms', '6(a)', NULL, 'final'),
  (15, 'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s) and benefit to be measured in non-monetary terms or to be expressed as an effectiveness measure', '6(b)', NULL, 'final'),
  (16, 'Are you aiming to evaluate or to re-design surveillance to improve its performance?', NULL, 41, NULL),
  (17, 'Are you aiming to evaluate or to re-design surveillance to improve its performance?', NULL, 41, NULL),
  (18, 'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s) and benefit to be measured in both monetary and non-monetary terms (or to be expressesed as an effectiveness measure)', '6(c)', NULL, 'final'),
  (20, 'Do you want to assess whether your surveillance meets a specified technical target or do you want to assess the absolute level of effectiveness', NULL, 16, NULL),
  (21, 'What do you want to evaluate', NULL, 16, NULL),
  (22, 'Have you evaluated the effectiveness of your surveillance', NULL, 16, NULL),
  (23, 'Do you want to make a comparison between two or more alternative surveillance designs (e.g. risk-based vs conventional) to find out whether one is preferable to the other one or to compare a novel surveillance component to a situation in which there is no surveillance or do you want to evaluate the performance of a surveillance component without making a comparison? ', NULL, 21, NULL),
  (24, 'Has the effectiveness of components been assessed or is the effectiveness determined by the surveillance protocol specified in the legal requirements to carry out surveillance?', NULL, 31, NULL),
  (25, 'Have you evaluated the effectiveness of your surveillance?', NULL, 16, NULL),
  (26, 'What measures will be used to assess the efficiency /effectiveness of surveillance', NULL, 23, NULL),
  (27, 'Do the components that you want to compare have the same objective', NULL, 23, NULL),
  (28, 'What measures will be used to assess the efficiency /effectiveness of surveillance', NULL, 27, NULL),
  (29, 'The EVA tool does currently  not provide guidance for evaluation of surveillance components with different objectives you can either evaluate each single component separately or compare each component to a situation with no surveillance                                                                             ', NULL, 0, 'end'),
  (30, 'Do the alternative components you are comparing achieve a specified technical effectiveness target?', NULL, 28, NULL),
  (31, 'Do you want to assess and compare the cost of components that achieve specified technical effectiveness target or assess the cost and effectiveness of components without specifying a technical effectiveness target?', NULL, 28, NULL),
  (32, 'Will an assessment of functional aspects that may influence the performance of surveillance be included together with the assessment of effectiveness?', NULL, 28, NULL),
  (33, 'Include functional aspects?', NULL, 32, NULL),
  (34, 'How can you measure benefits?', NULL, 28, NULL),
  (35, 'Is there a budget constraint?', NULL, 34, NULL),
  (36, 'Is there a budget constraint?', NULL, 34, NULL),
  (37, 'Is there a budget constraint?', NULL, 34, NULL),
  (41, 'Evaluations can be carried out at system or component level, at what level would you like to carry out your evaluation /improvement.  ', NULL, NULL, 'primary'),
  (42, 'What do you want to evaluate?', NULL, 17, NULL),
  (43, 'Assess the technical effectiveness of the surveillance system', '10', NULL, 'final'),
  (44, 'What criteria would you like to include in your evaluation?', NULL, 27, NULL),
  (45, 'Do you want to assess whether the components you are comparing meet a specified technical effectiveness target or do you want to assess the absolute level of effectiveness?', NULL, 44, NULL),
  (46, 'Note:If you want to evaluate cost effectiveness or economic efficiency you need to compare alternative designs or compare surveillance to a situation with no surveillance.', NULL, 44, 'end'),
  (47, 'Have you evaluated the functional aspects of surveillance?', NULL, 22, NULL),
  (48, '<b>You can use the surveillance design tool to re-design surveillance but carrying out an evaluation of the functional aspects of surveillance that may influence effectiveness may help to inform the re-design process </b>\r\n<br />\r\nDo you want to re-design surveillance or evaluate the functional aspects?', NULL, 47, NULL),
  (49, 'You can use the surveillance design tool to re-design surveillance but carrying out an evaluation to assess the effectiveness of surveillance or the functional aspects that may influence effectiveness may help to inform the re-design process <br /> Do you want to re-design surveillance or carry out an evaluation?', NULL, 25, NULL),
  (51, 'What criteria would you like to include in your evaluation?', NULL, 27, NULL),
  (52, 'You can use the cost calculation tool to estimate the cost of your surveillance but if you are interested in knowing whether you get value for money you should consider including effectiveness as well as costs.\r\n<br />\r\nDo you want to assess costs or include an asessment of effectiveness?', NULL, 30, NULL),
  (53, 'What criteria would you like to include in your evaluation?', NULL, 23, NULL),
  (54, 'Do you want to assess whether the component achieves a specified target effectiveness', NULL, 53, NULL),
  (55, 'Will an assessment of functional aspects that may influence the performance of surveillance be included together with the assessment of effectiveness?', NULL, 54, NULL),
  (56, 'Have you determined the effectiveness  of your component', NULL, 42, NULL),
  (57, 'It may be useful to evaluate the effectiveness of your component before evaluating functional aspects of surveillance that may influence effectiveness\r\n<br />\r\nDo you want to evaluate functional aspects without evaluating effectiveness, evaluate effectiveness before evaluating functional aspects or evaluate effectiveness and functional aspects at the same time', NULL, 56, NULL),
  (58, 'Have you evaluated the system', NULL, 17, NULL),
  (59, 'You can use the re-design tool but carrying out an evaluation first may help to identify how best to improve your system \r\n<br />\r\nDo you want to use the re-design tool or carry out an evaluation?', NULL, 58, NULL),
  (60, 'What criteria would you like to include in your evaluation', NULL, 27, NULL),
  (61, 'How can you measure benefits', NULL, 60, NULL);
SET FOREIGN_KEY_CHECKS=1;


INSERT IGNORE INTO `permissions` (`id`, `name`, `description`, `controller`, `action`, `bizrule`) VALUES
  (110, 'actionReport', 'C/A to generate surveillance system report', 'context', 'report', ''),
  (111, 'actionIndex', 'C/A to list surveillance sections', 'adminsurveillancesections', 'index', ''),
  (112, 'actionHome', 'C/A to surveillance sections ADMIN home page', 'adminsurveillancesections', 'home', ''),
  (113, 'actionUpdate', 'C/A to update surveillance sections description', 'adminsurveillancesections', 'update', ''),
  (114, 'actionHome', 'C/A to options home page', 'options', 'home', ''),
  (115, 'actionAddEvaContext', 'C/A to add evaluation context form field', 'admineva', 'addEvaContext', '');


INSERT IGNORE INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES
  (110, 2),
  (110, 3),
  (111, 1),
  (111, 2),
  (112, 1),
  (112, 2),
  (113, 1),
  (113, 2),
  (114, 1),
  (114, 2),
  (115, 1),
  (115, 2);

INSERT IGNORE INTO `programpages` (`pageId`, `pageName`, `path`, `parentId`, `menuOrder`, `target`, `active`, `comments`) VALUES
  (20, 'Manage Surveillance Tool', 'adminsurveillancesections/home', 8, 19, NULL, 1, NULL);