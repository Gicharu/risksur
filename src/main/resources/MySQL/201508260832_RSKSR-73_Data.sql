UPDATE 
  `frameworkFields` 
SET
  `inputName` = NULL,
  `inputType` = 'label'
WHERE `id` = '57' ;

INSERT INTO `frameworkFields` (
  `sectionId`, `parentId`, `label`, `inputName`, `inputType`, `required`, `order`)
VALUES
('2', '57', 'a) Why is surveillance necessary', 'survReason', 'dropdownlist', '0', '3.1');

INSERT INTO `frameworkFields` (
  `sectionId`,
  `parentId`,
  `label`,
  `inputName`,
  `inputType`,
  `required`,
  `order`
)
VALUES
  (
    '2',
    '57',
    'b) What will it accomplish',
    'survAccomp',
    'dropdownlist',
    '0',
    '3.2'
  ) ;

INSERT INTO `permissions` (
  `name`,
  `description`,
  `controller`,
  `action`
)
VALUES
  (
    'actionEditMultipleComponents',
    'C/A to edit components in parallel',
    'design',
    'editMultipleComponents'
  ),
  (
    'actionReports',
    'C/A to generate design tool reports',
    'design',
    'reports'
  ) ;

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
  ('91', '1'),
  ('91', '2'),
  ('91', '3'),
  ('92', '1'),
  ('92', '2'),
  ('92', '3') ;

# ALTER TABLE `surFormDetails`
# CHANGE `inputName` `inputName` VARCHAR(50) CHARSET utf8 NULL,
# CHANGE `label` `label` VARCHAR(50) CHARSET utf8 NULL,
# CHANGE `inputType` `inputType` VARCHAR(50) CHARSET utf8 NULL,
# CHANGE `description` `description` TEXT CHARSET utf8 NULL,
# CHANGE `moreInfo` `moreInfo` TEXT CHARSET utf8 NULL,
# CHANGE `url` `url` TEXT CHARSET utf8 NULL,
# CHANGE `order` `order` VARCHAR(10) CHARSET utf8 NULL,
# CHARSET=utf8;

REPLACE INTO `surveillanceSections` (`sectionId`, `sectionNumber`, `sectionName`, `tool`, `description`) VALUES
  (1, 0.0, 'Hazard', 'surveillance', 'The RISKSUR tool has been developed to design and evaluate surveillance for specific systems . A system  is defined by:		\r\n<ol>\r\n<li>The hazard: the disease  for which surveillance is being designed</li>\r\n<li>The surveillance objective </li>			\r\n<li>Geographical area covered</li>			\r\n<p>Having defined your system you can also enter information that will be useful to inform the design including:<p>					\r\n<li>The susceptible population (species)</li>			\r\n<li>The risk characteristics associated with the previous 3 points</li>\r\n</ol>		'),
  (2, 0.0, 'Surveillance Objective', 'surveillance', NULL),
  (3, 0.0, 'Geographical area covered', 'surveillance', NULL),
  (4, 0.0, 'Susceptible population', 'surveillance', NULL),
  (5, 0.0, 'Risk characteristics', 'surveillance', 'The questions below are designed to encourage you to think about population (particularly geographical and temporal), herd and animal level risk characteristics associated with the hazard, susceptible population and surveillance objective you defined previously. These risk characteristics may become relevant later in the framework when considering strategies to enhance the efficiency of your surveillance system:'),
  (6, 0.0, 'Other Considerations', 'surveillance', 'You have characterized the surveillance system for this design task as: '),
  (8, 2.0, 'Add Surveillance Components', 'design', 'For each surveillance system a number of surveillance components can be included.  \r\nUse the form below to add the surveillance components that can be implemented as part of this surveillance system. Visit the Wiki if you need help deciding which activities should be relevant for your particular system.'),
  (9, 3.0, 'Objective and Target population', 'design', 'Each surveillance component is targeted at a particular susceptible population, for which conclusions will be made. In this step, you will be guided through the process of defining this population.'),
  (10, 4.0, 'Suspicion of disease', 'design', 'In this section you will be asked to think about how a suspected case of the hazard of interest is defined and reported to the relevant authorities. This is relevant to passive surveillance components where the collection of surveillance data is observer -initiated. ');

UPDATE `options` SET `optionId` = 78,`frameworkFieldId` = 62,`componentId` = NULL,`elementId` = NULL,`val` = 'scenario1',`label` = 'Achieve disease freedom after control of a disease outbreak (scenario 1)' WHERE `options`.`optionId` = 78;