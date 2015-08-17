INSERT INTO `surveillanceSections` (`sectionId`, `sectionNumber`, `sectionName`, `tool`, `description`) VALUES
(8, 2.0, 'Add Surveillance Components', 'design', 'For each surveillance system a number of surveillance components can be included.  \r\nUse the form below to add the surveillance components that can be implemented as part of this surveillance system. Visit the Wiki if you need help deciding which activities should be relevant for your particular system.'),
(9, 3.0, 'Objective and Target population', 'design', 'Each surveillance component is targeted at a particular susceptible population, for which conclusions will be made. In this step, you will be guided through the process of defining this population.'),
(10, 4.0, 'Suspicion of disease', 'design', 'In this section you will be asked to think about how a suspected case of the hazard of interest is defined and reported to the relevant authorities. This is relevant to passive surveillance components where the collection of surveillance data is observer -initiated. ');

SET FOREIGN_KEY_CHECKS=0;

TRUNCATE TABLE `surFormDetails`;
--
-- Dumping data for table `surFormDetails`
--

INSERT INTO `surFormDetails` (`subFormId`, `sectionId`, `order`, `inputName`, `label`, `inputType`, `required`, `showOnMultiForm`, `showOnComponentList`, `description`, `moreInfo`, `url`) VALUES
  (1, 8, NULL, 'targetSpecies', 'Target Species', 'text', 1, 1, 1, 'Enter a name for the initiator', 'The initiator initiates the initiated', 'http://www.karlo.org'),
  (2, 8, NULL, 'targetSector', 'Target Sector', 'text', 1, 1, 1, 'Here, describe the point of capture', 'The capture point is where we capture', 'http://www.ilri.org'),
  (3, 8, NULL, 'geoArea', 'Geographical Area Covered', 'text', 1, 1, 0, 'What type of raw data you want', 'Raw data is just that, raw, not processed yet', 'http://www.icipe.org'),
  (5, 8, NULL, 'dataColPoint', 'Data Collection Point', 'dropdownlist', 1, 1, 0, 'Describe the size of the samples you will collect', 'Should be substantial', 'http://www.kari.org'),
  (6, 8, NULL, 'studyType', 'Study Type', 'dropdownlist', 1, 0, 0, 'See step #1 above', 'Same as #1', 'http://www.kefri.org'),
  (7, 8, NULL, 'diseaseType', 'Type of disease', 'dropdownlist', 1, 0, 1, 'Describe the type of threat for you data', 'Threat can be anything, terrorists, rice, rats you name it :-)', 'http://www.kemri.org'),
  (8, 8, NULL, 'sampleType', 'Tyre of sample collected', 'dropdownlist', 1, 0, 0, NULL, NULL, NULL),
  (9, 9, '3.2.1', 'otherTargetSpecies', 'Other or Details', 'textarea', 0, 0, 0, NULL, NULL, NULL),
  (10, 9, '3.3.1', 'otherTargetSector', 'Other or Details', 'textarea', 0, 0, 0, NULL, NULL, NULL),
  (11, 9, '3.1.1', 'otherSurveillanceObj', 'Other or Details', 'textarea', 0, 0, 0, NULL, NULL, NULL),
  (12, 9, '3.1.0', '', '3.1 Surveillance Objective', 'label', 0, 0, 0, NULL, NULL, NULL),
  (13, 9, '3.2.0', NULL, '3.2 Target species / animal group / material', 'label', 0, 0, 0, NULL, NULL, NULL),
  (14, 9, '3.3.0', NULL, '3.3 Sectors missed', 'label', 0, 0, 0, NULL, NULL, NULL);
SET FOREIGN_KEY_CHECKS=1;


UPDATE `options` SET `optionId` = 1,`frameworkFieldId` = NULL,`componentId` = 5,`elementId` = NULL,`val` = '',`label` = 'At the source (farm, wild life habitat, etc)' WHERE `options`.`optionId` = 1;
UPDATE `options` SET `optionId` = 2,`frameworkFieldId` = NULL,`componentId` = 5,`elementId` = NULL,`val` = '',`label` = 'Abattoir' WHERE `options`.`optionId` = 2;
UPDATE `options` SET `optionId` = 3,`frameworkFieldId` = NULL,`componentId` = 5,`elementId` = NULL,`val` = '',`label` = 'Coordination centre' WHERE `options`.`optionId` = 3;
UPDATE `options` SET `optionId` = 4,`frameworkFieldId` = NULL,`componentId` = 5,`elementId` = NULL,`val` = '',`label` = 'Artificial insemination centre' WHERE `options`.`optionId` = 4;
UPDATE `options` SET `optionId` = 5,`frameworkFieldId` = NULL,`componentId` = 5,`elementId` = NULL,`val` = '',`label` = 'Rendering plants' WHERE `options`.`optionId` = 5;
UPDATE `options` SET `optionId` = 6,`frameworkFieldId` = NULL,`componentId` = 5,`elementId` = NULL,`val` = '',`label` = 'Diagnostic laboratory' WHERE `options`.`optionId` = 6;
UPDATE `options` SET `optionId` = 7,`frameworkFieldId` = NULL,`componentId` = 5,`elementId` = NULL,`val` = '',`label` = 'Markets' WHERE `options`.`optionId` = 7;


INSERT INTO `options` (`optionId`, `frameworkFieldId`, `componentId`, `elementId`, `val`, `label`) VALUES
  (84, NULL, 5, NULL, NULL, 'Others'),
  (85, NULL, 6, NULL, NULL, 'Passive surveillance'),
  (86, NULL, 6, NULL, NULL, 'Screening'),
  (87, NULL, 6, NULL, NULL, 'Continuous data collection'),
  (88, NULL, 6, NULL, NULL, 'Sentinel'),
  (89, NULL, 6, NULL, NULL, 'Participatory'),
  (90, NULL, 6, NULL, NULL, 'Event-based'),
  (91, NULL, 6, NULL, NULL, 'Syndromic surveillance'),
  (92, NULL, 6, NULL, NULL, 'Other'),
  (93, NULL, 7, NULL, NULL, 'Antibody detection'),
  (94, NULL, 7, NULL, NULL, 'Pathogen detection'),
  (95, NULL, 7, NULL, NULL, 'Gross pathology'),
  (96, NULL, 7, NULL, NULL, 'Pathology diagnostic (microscopic)'),
  (97, NULL, 7, NULL, NULL, 'Indirect indicators'),
  (98, NULL, 7, NULL, NULL, 'Other'),
  (99, NULL, 8, NULL, NULL, 'Clinical reports'),
  (100, NULL, 8, NULL, NULL, 'Blood / Serum / Plasma'),
  (101, NULL, 8, NULL, NULL, 'Ear notch');


INSERT INTO `permissions` (`id`, `name`, `description`, `controller`, `action`, `bizrule`) VALUES
  (89, 'actionGetDesignElements', 'C/A to retrieve design tool elements', 'design', 'getDesignElements', ''),
  (90, 'actionGetDesignData', 'C/A to retrieve design tool element data', 'design', 'getDesignData', '');


INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES
  (89, 1),
  (89, 2),
  (89, 3),
  (90, 1),
  (90, 2),
  (90, 3);