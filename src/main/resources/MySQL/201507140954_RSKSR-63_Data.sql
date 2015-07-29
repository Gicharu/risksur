INSERT INTO `permissions` (
  `id`,
  `name`,
  `description`,
  `controller`,
  `action`
)
VALUES
  (
    70,
    'actionSavePage',
    'Dummy C/A to save surveillance introduction page',
    'context',
    'savePage'
  ),
  (
    71,
    'actionIntro',
    'C/A to diplay intro page',
    'context',
    'intro'
  ) ;

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
  ('70', '1'),
  ('70', '2');

UPDATE
  `programpages`
SET
  `path` = 'context/index'
WHERE `pageId` = '15' ;

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
  ('71', '1'),
  ('71', '2'),
  ('71', '3');

UPDATE
  `programpages`
SET
  `path` = 'evaluation/evaPage'
WHERE `pageId` = '3' ;

UPDATE
  `programpages`
SET
  `path` = 'stage.tracetracker.com/epitools'
WHERE `pageId` = '6' ;

UPDATE
  `programpages`
SET
  `path` = 'design/index'
WHERE `pageId` = '2' ;


CREATE TABLE IF NOT EXISTS `docPages` (
  `docId` int(11) NOT NULL AUTO_INCREMENT,
  `docName` varchar(50) DEFAULT NULL,
  `docData` blob,
  PRIMARY KEY (`docId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `docPages`
--

INSERT INTO `docPages` (`docId`, `docName`, `docData`) VALUES
  (3, 'survIndex', 0x3c703e3c7374726f6e673e53797374656d20496e74726f64756374696f6e20506167653c2f7374726f6e673e3c6272202f3e3c2f703e3c703e4c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e736574657475722073616469707363696e6720656c6974722c20736564206469616d206e6f6e756d79206569726d6f642074656d706f7220696e766964756e74207574206c61626f726520657420646f6c6f7265206d61676e6120616c69717579616d20657261742c20736564206469616d20766f6c75707475612e204174207665726f20656f73206574206163637573616d206574206a7573746f2064756f20646f6c6f72657320657420656120726562756d2e205374657420636c697461206b6173642067756265726772656e2c206e6f207365612074616b696d6174612073616e6374757320657374204c6f72656d20697073756d20646f6c6f722073697420616d65742e204c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e736574657475722073616469707363696e6720656c6974722c20736564206469616d206e6f6e756d79206569726d6f642074656d706f7220696e766964756e74207574206c61626f726520657420646f6c6f7265206d61676e6120616c69717579616d20657261742c20736564206469616d20766f6c75707475612e204174207665726f20656f73206574206163637573616d206574206a7573746f2064756f20646f6c6f72657320657420656120726562756d2e205374657420636c697461206b6173642067756265726772656e2c206e6f207365612074616b696d6174612073616e6374757320657374204c6f72656d20697073756d20646f6c6f722073697420616d65742e204c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e736574657475722073616469707363696e6720656c6974722c20736564206469616d206e6f6e756d79206569726d6f642074656d706f7220696e766964756e74207574206c61626f726520657420646f6c6f7265206d61676e6120616c69717579616d20657261742c20736564206469616d20766f6c75707475612e204174207665726f20656f73206574206163637573616d206574206a7573746f2064756f20646f6c6f72657320657420656120726562756d2e205374657420636c697461206b6173642067756265726772656e2c206e6f207365612074616b696d6174612073616e6374757320657374204c6f72656d20697073756d20646f6c6f722073697420616d65742e3c6272202f3e3c6272202f3e4475697320617574656d2076656c2065756d2069726975726520646f6c6f7220696e2068656e64726572697420696e2076756c7075746174652076656c69742065737365206d6f6c657374696520636f6e7365717561742c2076656c20696c6c756d20646f6c6f72652065752066657567696174206e756c6c6120666163696c69736973206174207665726f2065726f7320657420616363756d73616e20657420697573746f206f64696f206469676e697373696d2071756920626c616e646974207072616573656e74206c7570746174756d207a7a72696c2064656c656e6974206175677565206475697320646f6c6f72652074652066657567616974206e756c6c6120666163696c6973692e204c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e7365637465747565722061646970697363696e6720656c69742c20736564206469616d206e6f6e756d6d79206e69626820657569736d6f642074696e636964756e74207574206c616f7265657420646f6c6f7265206d61676e6120616c697175616d206572617420766f6c75747061742e3c6272202f3e3c6272202f3e5574207769736920656e696d206164206d696e696d2076656e69616d2c2071756973206e6f73747275642065786572636920746174696f6e20756c6c616d636f72706572207375736369706974206c6f626f72746973206e69736c20757420616c697175697020657820656120636f6d6d6f646f20636f6e7365717561742e204475697320617574656d2076656c2065756d2069726975726520646f6c6f7220696e2068656e64726572697420696e2076756c7075746174652076656c69742065737365206d6f6c657374696520636f6e7365717561742c2076656c20696c6c756d20646f6c6f72652065752066657567696174206e756c6c6120666163696c69736973206174207665726f2065726f7320657420616363756d73616e20657420697573746f206f64696f206469676e697373696d2071756920626c616e646974207072616573656e74206c7570746174756d207a7a72696c2064656c656e6974206175677565206475697320646f6c6f72652074652066657567616974206e756c6c6120666163696c6973693d2e3c2f703e),
  (4, 'survIntro', 0x3c703e3c7374726f6e673e5249534b53555220496e726f64756374696f6e20506167653c2f7374726f6e673e3c2f703e3c703e4c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e736574657475722073616469707363696e6720656c6974722c20736564206469616d206e6f6e756d79206569726d6f642074656d706f7220696e766964756e74207574206c61626f726520657420646f6c6f7265206d61676e6120616c69717579616d20657261742c20736564206469616d20766f6c75707475612e204174207665726f20656f73206574206163637573616d206574206a7573746f2064756f20646f6c6f72657320657420656120726562756d2e205374657420636c697461206b6173642067756265726772656e2c206e6f207365612074616b696d6174612073616e6374757320657374204c6f72656d20697073756d20646f6c6f722073697420616d65742e204c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e736574657475722073616469707363696e6720656c6974722c20736564206469616d206e6f6e756d79206569726d6f642074656d706f7220696e766964756e74207574206c61626f726520657420646f6c6f7265206d61676e6120616c69717579616d20657261742c20736564206469616d20766f6c75707475612e204174207665726f20656f73206574206163637573616d206574206a7573746f2064756f20646f6c6f72657320657420656120726562756d2e205374657420636c697461206b6173642067756265726772656e2c206e6f207365612074616b696d6174612073616e6374757320657374204c6f72656d20697073756d20646f6c6f722073697420616d65742e204c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e736574657475722073616469707363696e6720656c6974722c20736564206469616d206e6f6e756d79206569726d6f642074656d706f7220696e766964756e74207574206c61626f726520657420646f6c6f7265206d61676e6120616c69717579616d20657261742c20736564206469616d20766f6c75707475612e204174207665726f20656f73206574206163637573616d206574206a7573746f2064756f20646f6c6f72657320657420656120726562756d2e205374657420636c697461206b6173642067756265726772656e2c206e6f207365612074616b696d6174612073616e6374757320657374204c6f72656d20697073756d20646f6c6f722073697420616d65742e3c6272202f3e3c6272202f3e4475697320617574656d2076656c2065756d2069726975726520646f6c6f7220696e2068656e64726572697420696e2076756c7075746174652076656c69742065737365206d6f6c657374696520636f6e7365717561742c2076656c20696c6c756d20646f6c6f72652065752066657567696174206e756c6c6120666163696c69736973206174207665726f2065726f7320657420616363756d73616e20657420697573746f206f64696f206469676e697373696d2071756920626c616e646974207072616573656e74206c7570746174756d207a7a72696c2064656c656e6974206175677565206475697320646f6c6f72652074652066657567616974206e756c6c6120666163696c6973692e204c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e7365637465747565722061646970697363696e6720656c69742c20736564206469616d206e6f6e756d6d79206e69626820657569736d6f642074696e636964756e74207574206c616f7265657420646f6c6f7265206d61676e6120616c697175616d206572617420766f6c75747061742e3c6272202f3e3c6272202f3e5574207769736920656e696d206164206d696e696d2076656e69616d2c2071756973206e6f73747275642065786572636920746174696f6e20756c6c616d636f72706572207375736369706974206c6f626f72746973206e69736c20757420616c697175697020657820656120636f6d6d6f646f20636f6e7365717561742e204475697320617574656d2076656c2065756d2069726975726520646f6c6f7220696e2068656e64726572697420696e2076756c7075746174652076656c69742065737365206d6f6c657374696520636f6e7365717561742c2076656c20696c6c756d20646f6c6f72652065752066657567696174206e756c6c6120666163696c69736973206174207665726f2065726f7320657420616363756d73616e20657420697573746f206f64696f206469676e697373696d2071756920626c616e646974207072616573656e74206c7570746174756d207a7a72696c2064656c656e6974206175677565206475697320646f6c6f72652074652066657567616974206e756c6c6120666163696c6973692e3c6272202f3e3c6272202f3e4e616d206c696265722074656d706f722063756d20736f6c757461206e6f62697320656c656966656e64206f7074696f6e20636f6e677565206e6968696c20696d7065726469657420646f6d696e672069642071756f64206d617a696d20706c61636572617420666163657220706f7373696d20617373756d2e204c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e7365637465747565722061646970697363696e6720656c69742c20736564206469616d206e6f6e756d6d79206e69626820657569736d6f642074696e636964756e74207574206c616f7265657420646f6c6f7265206d61676e6120616c697175616d206572617420766f6c75747061742e205574207769736920656e696d206164206d696e696d2076656e69616d2c2071756973206e6f73747275642065786572636920746174696f6e20756c6c616d636f72706572207375736369706974206c6f626f72746973206e69736c20757420616c697175697020657820656120636f6d6d6f646f20636f6e7365717561742e3c6272202f3e3c6272202f3e4475697320617574656d2076656c2065756d2069726975726520646f6c6f7220696e2068656e64726572697420696e2076756c7075746174652076656c69742065737365206d6f6c657374696520636f6e7365717561742c2076656c20696c6c756d20646f6c6f72652065752066657567696174206e756c6c6120666163696c697369732e3c6272202f3e3c2f703e),
  (5, 'desIndex', 0x3c703e44657369676e20546f6f6c20496e74726f64756374696f6e3c2f703e);

--
-- Table structure for table `surveillanceSections`
--

CREATE TABLE IF NOT EXISTS `surveillanceSections` (
  `sectionId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sectionName` varchar(50) CHARACTER SET latin1 NOT NULL,
  `tool` enum('surveillance','design','evaluation') CHARACTER SET latin1 DEFAULT NULL,
  `description` text CHARACTER SET latin1,
  PRIMARY KEY (`sectionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;




SET FOREIGN_KEY_CHECKS=0;
DROP TABLE `frameworkFields`;
SET FOREIGN_KEY_CHECKS=1;


CREATE TABLE IF NOT EXISTS `frameworkFields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sectionId` int(11) unsigned NOT NULL,
  `parentId` int(11) unsigned DEFAULT NULL,
  `label` text COLLATE utf8_unicode_ci,
  `inputName` text CHARACTER SET latin1 NOT NULL,
  `inputType` text CHARACTER SET latin1 NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '1',
  `order` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gridField` tinyint(1) DEFAULT '0',
  `description` text CHARACTER SET latin1,
  `childCount` int(2) unsigned DEFAULT NULL,
  `multiple` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sectionId` (`sectionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=55 ;

ALTER TABLE `frameworkFields`
ADD CONSTRAINT `fk_sectionId` FOREIGN KEY (`sectionId`) REFERENCES `surveillanceSections` (`sectionId`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Dumping data for table `surveillanceSections`
--
INSERT INTO `surveillanceSections` (`sectionId`, `sectionName`, `tool`, `description`) VALUES
  (1, 'Hazard', 'surveillance', 'The RISKSUR tool has been developed to design and evaluate surveillance for specific systems . A system  is defined by:		\r\n<ol>\r\n<li>The hazard: the disease  for which surveillance is being designed</li>\r\n<li>The surveillance objective </li>			\r\n<li>Geographical area covered</li>			\r\n<p>Having defined your system you can also enter information that will be useful to inform the design including:<p>					\r\n<li>The susceptible population (species)</li>			\r\n<li>The risk characteristics associated with the previous 3 points</li>\r\n</ol>		'),
  (2, 'Surveillance Objective', 'surveillance', NULL),
  (3, 'Geographical area covered', 'surveillance', NULL),
  (4, 'Susceptible population (species)', 'surveillance', NULL),
  (5, 'Risk characteristics', 'surveillance', 'The questions below are designed to encourage you to think about population (particularly geographical and temporal), herd and animal level risk characteristics associated with the hazard, susceptible population and surveillance objective you defined previously. These risk characteristics may become relevant later in the framework when considering strategies to enhance the efficiency of your surveillance system:'),
  (6, 'Other Considerations', 'surveillance', 'You have characterized the surveillance system for this design task as: ');

-- Dumping data for table `frameworkFields`
--

INSERT INTO `frameworkFields` (`id`, `sectionId`, `parentId`, `label`, `inputName`, `inputType`, `required`, `order`, `gridField`, `description`, `childCount`, `multiple`) VALUES
  (4, 1, NULL, NULL, 'hazardName', 'text', 1, NULL, 0, NULL, NULL, NULL),
  (5, 2, NULL, 'What is the state of the diesease in the country?', 'stateOfDisease', 'text', 1, NULL, 0, 'What is the state of the diesease in the country?', NULL, NULL),
  (6, 3, NULL, NULL, 'geographicalArea', 'text', 1, NULL, 0, NULL, NULL, NULL),
  (9, 6, NULL, 'Legal requirements', 'legalReq', 'textarea', 0, '2', 0, 'Are there any legal requirements (e.g. EU regulations)  which specify that surveillance should be carried out for this hazard. If so, do they specify how the surveillance should be carried out (e.g. type and number of samples to be taken). Use the text box to describe.', NULL, NULL),
  (10, 6, NULL, 'Economic impact', 'econImpact', 'textarea', 0, '3', 0, 'In what ways does this disease have an economic impact (e.g. trade within or between countries, public health, animal welfare, animal productivity, wider economy).', NULL, NULL),
  (12, 4, 0, 'Food Producing (Domestic)', '', 'label', 0, '1', 0, NULL, 4, NULL),
  (13, 4, 12, 'Ruminants', 'ruminants', 'checkboxlist', 0, '1.1', 0, NULL, NULL, NULL),
  (14, 4, 12, 'Swine', 'swine', 'checkboxlist', 0, '1.2', 0, NULL, NULL, NULL),
  (18, 4, 12, 'Aquaculture', 'aquaculture', 'checkboxlist', 0, '1.3', 0, NULL, NULL, NULL),
  (19, 4, NULL, 'Other Domestics', 'otherDomestics', 'checkboxlist', 0, '2', 0, NULL, NULL, NULL),
  (20, 4, NULL, 'Wildlife', 'wildlife', 'checkboxlist', 0, '3', 0, NULL, NULL, NULL),
  (24, 4, NULL, 'Vectors', 'vectors', 'checkboxlist', 0, '4', 0, NULL, NULL, NULL),
  (25, 4, NULL, 'Others', 'others', 'checkboxlist', 0, '5', 0, NULL, NULL, NULL),
  (26, 5, NULL, 'Population level risk factors', '', 'label', 1, '1', 0, NULL, 2, NULL),
  (27, 5, 26, 'Geographical factors', 'geographicalFactors', 'grid', 0, '1.1', 0, NULL, 3, NULL),
  (29, 5, 27, 'Specify risk factor', 'riskfactor', 'text', 0, '1.1.1', 1, NULL, NULL, NULL),
  (31, 5, 27, 'Associated with risk of', 'associatedRisk', 'dropdownlist', 0, '1.1.2', 1, NULL, NULL, 1),
  (32, 5, 27, 'Describe details', 'details', 'text', 0, '1.1.3', 1, NULL, NULL, NULL),
  (33, 5, 26, 'Temporal factors', 'temporalFactors', 'grid', 0, '1.2', 0, NULL, 3, NULL),
  (34, 5, 33, 'Describe details', 'details', 'text', 0, '1.2.3', 1, NULL, NULL, NULL),
  (35, 5, 33, 'Associated with risk of', 'associatedRisk', 'dropdownlist', 0, '1.2.2', 1, NULL, NULL, 1),
  (36, 5, 33, 'Specify risk factor', 'riskfactor', 'text', 0, '1.2.1', 1, NULL, NULL, NULL),
  (37, 5, NULL, 'Herd level risk factors', '', 'grid', 0, '2', 0, NULL, NULL, NULL),
  (38, 5, NULL, 'Animal level risk factors', '', 'grid', 0, '3', 0, NULL, NULL, NULL),
  (39, 5, 37, 'Specify risk factor', 'riskfactor', 'text', 0, '2.1', 1, NULL, NULL, NULL),
  (40, 5, 38, 'Specify risk factor', 'riskfactor', 'text', 0, '3.1', 1, NULL, NULL, NULL),
  (41, 5, 37, 'Associated with risk of', 'associatedRisk', 'dropdownlist', 0, '2.2', 1, NULL, NULL, 1),
  (42, 5, 38, 'Associated with risk of', 'associatedRisk', 'dropdownlist', 0, '3.2', 1, NULL, NULL, 1),
  (43, 5, 37, 'Describe details', 'details', 'text', 0, '2.3', 1, NULL, NULL, NULL),
  (44, 5, 38, 'Describe details', 'details', 'text', 0, '3.3', 1, NULL, NULL, NULL),
  (46, 6, NULL, 'Disease control action', 'diseaseCtrlAction', 'textarea', 0, '4', 0, 'What disease control action will be taken based on the results of this surveillance (e.g. stamping out, vaccination)? Use the text box to describe.', NULL, NULL),
  (48, 6, NULL, 'What change in surveillance results is required to trigger these actions?', 'changeTrigger', 'textarea', 0, '5', 0, NULL, NULL, NULL),
  (50, 6, NULL, 'Who is responsible', 'responsible', 'textarea', 0, '6', 0, 'Who(i.e. scientific and technical committees) is <b>responsible</b> for development and maintenance of the surveillance system? Use the text box to describe.', NULL, NULL),
  (51, 6, NULL, 'Institutions involved', 'instInvolved', 'textarea', 0, '7', 0, 'Describe what are the institutions involved and their role (for example: which institutions design the surveillance, carry out surveillance activities, and which help financing, etc).\r\n', NULL, NULL),
  (52, 6, NULL, 'Frequency of meetings', 'freqOfMeetings', 'textarea', 0, '8', 0, 'Plan/describe the frequency of meetings of the central coordination group for review of the adequacy or need for protocol update.\r\n', NULL, NULL),
  (54, 6, NULL, 'Please document any other information relevant information about the system.\r\n', 'moreInfo', 'textarea', 0, '9', 0, NULL, NULL, NULL),
  (55, 4, 12, 'Poultry', 'poultry', 'checkboxlist', 0, '1.4', 0, NULL, NULL, NULL);


TRUNCATE TABLE `options`;
--
-- Dumping data for table `options`
--

INSERT INTO `options` (`optionId`, `elementId`, `frameworkFieldId`, `val`, `label`) VALUES
  (1, 2, NULL, 'source', 'At Source'),
  (2, 2, NULL, 'coordPoint', 'At Coordination point'),
  (3, 3, NULL, 'bioSample', 'Biological samples'),
  (4, 3, NULL, 'obs', 'Observations'),
  (5, 3, NULL, 'hid', 'Health indicator data'),
  (6, 4, NULL, 'animal', 'Animal'),
  (7, 4, NULL, 'herd', 'Herd'),
  (8, NULL, 13, NULL, 'Cattle'),
  (9, NULL, 13, NULL, 'Sheep'),
  (10, NULL, 13, NULL, 'Goats'),
  (11, NULL, 13, NULL, 'Other farmed ruminants'),
  (12, NULL, 14, NULL, 'Domestic pigs'),
  (13, NULL, 14, NULL, 'Farmed wild boar'),
  (14, NULL, 18, NULL, 'Fish'),
  (15, NULL, NULL, NULL, 'Other aquatic'),
  (16, NULL, 55, NULL, 'Chicken'),
  (17, NULL, 55, NULL, 'Turkey'),
  (18, NULL, 55, NULL, 'Ducks'),
  (19, NULL, 55, NULL, 'Geese'),
  (20, NULL, 55, NULL, 'Game Birds'),
  (21, NULL, 55, NULL, 'Other captive poultry'),
  (22, NULL, 19, NULL, 'Horses'),
  (23, NULL, 19, NULL, 'Pets'),
  (24, NULL, 19, NULL, 'Ornamental birds'),
  (25, NULL, 19, NULL, 'Farmed / Captive deer'),
  (26, NULL, 20, NULL, 'Wildboar'),
  (27, NULL, 20, NULL, 'Waterfowl'),
  (28, NULL, 20, NULL, 'Birds (other than waterfowl)'),
  (29, NULL, 20, NULL, 'Equidae (wild)'),
  (30, NULL, 20, NULL, 'Deer'),
  (31, NULL, 20, NULL, 'Other wild ruminants'),
  (32, NULL, 20, NULL, 'Wild carniovore'),
  (33, NULL, 20, NULL, 'Bats'),
  (34, NULL, 20, NULL, 'Other wildlife'),
  (35, NULL, 24, NULL, 'Midges / Mosquitos'),
  (36, NULL, 24, NULL, 'Rodent vectors'),
  (37, NULL, 24, NULL, 'Ticks'),
  (38, NULL, 24, NULL, 'Other vectors'),
  (39, NULL, 25, NULL, 'Bees'),
  (40, NULL, 25, NULL, 'Zoo animals'),
  (41, NULL, 31, NULL, 'Introduction'),
  (42, NULL, 31, NULL, 'Infection'),
  (43, NULL, 31, NULL, 'Detection'),
  (44, NULL, 31, NULL, 'Consequences'),
  (45, NULL, 31, NULL, 'Undefined'),
  (46, NULL, 35, NULL, 'Introduction'),
  (47, NULL, 41, NULL, 'Introduction'),
  (48, NULL, 42, NULL, 'Introduction'),
  (49, NULL, 35, NULL, 'Infection'),
  (50, NULL, 41, NULL, 'Infection'),
  (51, NULL, 42, NULL, 'Infection'),
  (52, NULL, 35, NULL, 'Detection'),
  (53, NULL, 42, NULL, 'Detection'),
  (54, NULL, 41, NULL, 'Detection'),
  (56, NULL, 35, NULL, 'Consequences'),
  (57, NULL, 41, NULL, 'Consequences'),
  (58, NULL, 42, NULL, 'Consequences'),
  (59, NULL, 35, NULL, 'Undefined'),
  (60, NULL, 41, NULL, 'Undefined'),
  (61, NULL, 42, NULL, 'Undefined');
