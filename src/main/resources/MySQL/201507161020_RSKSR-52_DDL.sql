ALTER TABLE `options` CHANGE `elementId` `componentId` INT(11) NULL;

ALTER TABLE `options`
CHANGE `frameworkFieldId` `frameworkFieldId` INT (11) UNSIGNED NULL AFTER `optionId`,
ADD COLUMN `elementId` INT (11) NULL AFTER `componentId` ;

ALTER TABLE `options`
ADD CONSTRAINT `fk_componentId` FOREIGN KEY (`componentId`) REFERENCES `componentDetails` (`componentDetailId`)
  ON UPDATE CASCADE ON DELETE CASCADE ;

ALTER TABLE `options`
ADD CONSTRAINT `fk_elementId` FOREIGN KEY (`elementId`) REFERENCES `evalElements` (`evalElementsId`)
  ON UPDATE CASCADE ON DELETE CASCADE ;

ALTER TABLE `evaluationHeader` ADD COLUMN `questionId` INT(11) UNSIGNED NULL AFTER `frameworkId`;


ALTER TABLE `evaluationHeader`
CHANGE `evaluationName` `evaluationName` VARCHAR (50) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL,
CHANGE `frameworkId` `frameworkId` INT (11) NOT NULL,
CHANGE `userId` `userId` INT (11) NOT NULL,
CHANGE `evaluationDescription` `evaluationDescription` BLOB NOT NULL,
CHANGE `questionId` `questionId` INT (11) UNSIGNED DEFAULT NULL NULL ;


ALTER TABLE `evaluationHeader` CHARSET=utf8, COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `evaQuestionGroups` (
  `groupId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `section` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `questions` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`groupId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `evaQuestion_has_criteria_and_method`(
  `questionId` INT(11) UNSIGNED NOT NULL,
  `criteriaId` INT(11) UNSIGNED NOT NULL,
  `methodId` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`questionId`, `criteriaId`, `methodId`)
);
ALTER TABLE `evaQuestion_has_criteria_and_method`
ADD CONSTRAINT `fk_questionId` FOREIGN KEY (`questionId`) REFERENCES `evaluationQuestion`(`evalQuestionId`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `fk_evaMethodId` FOREIGN KEY (`methodId`) REFERENCES `evaMethods`(`evaMethodId`) ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `fk_evaCriteriaId` FOREIGN KEY (`criteriaId`) REFERENCES `evaCriteria`(`criteriaId`) ON UPDATE CASCADE ON DELETE CASCADE;

CREATE TABLE `evaCriteria`(
  `criteriaId` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(80) NOT NULL,
  PRIMARY KEY (`criteriaId`)
);

RENAME TABLE `evaMethods` TO `econEvaMethods`;

CREATE TABLE `evaMethods` (
  `evaMethodId` INT (11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR (80) NOT NULL,
  PRIMARY KEY (`evaMethodId`)
) ;

CREATE TABLE `evaAttributesMatrix`(
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `surveillanceObj` ENUM('1','2','3','4') NOT NULL,
  `evaQuestionGroup` INT(11) UNSIGNED NOT NULL,
  `attributeId` INT(11) UNSIGNED NOT NULL,
  `relevance` ENUM('0','1','2','3') NOT NULL COMMENT '0-Hide, 1-Low, 2-Medium,3-High',
  PRIMARY KEY (`id`)
);

ALTER TABLE `evaAttributesMatrix`
CHANGE `attributeId` `attributeId` INT (11) NOT NULL,
ADD CONSTRAINT `fk_attributeId` FOREIGN KEY (`attributeId`) REFERENCES `evaAttributes` (`attributeId`) ON UPDATE CASCADE ON DELETE CASCADE ;