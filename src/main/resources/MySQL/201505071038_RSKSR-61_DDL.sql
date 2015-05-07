TRUNCATE TABLE `evaluationQuestion`;
ALTER TABLE `evaluationQuestion` CHANGE `evalQuestionId` `evalQuestionId` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `evaluationQuestion`
CHANGE `question` `question` TEXT CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL ;
ALTER TABLE `evaluationQuestion` DROP COLUMN `shortName`;
ALTER TABLE `evaluationQuestion` ADD COLUMN `parentQuestion` INT(11) UNSIGNED NULL AFTER `question`;

DROP TABLE IF EXISTS `evalQuestionAnswers`;

CREATE TABLE `evalQuestionAnswers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `evalQuestionId` int(11) unsigned NOT NULL,
  `optionName` text NOT NULL,
  `nextQuestion` int(11) unsigned NOT NULL,
  `url` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_evalQuestion` (`evalQuestionId`),
  KEY `fk_nextQuestion` (`nextQuestion`),
  CONSTRAINT `fk_evalQuestion` FOREIGN KEY (`evalQuestionId`) REFERENCES `evaluationQuestion` (`evalQuestionId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_nextQuestion` FOREIGN KEY (`nextQuestion`) REFERENCES `evaluationQuestion` (`evalQuestionId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;


