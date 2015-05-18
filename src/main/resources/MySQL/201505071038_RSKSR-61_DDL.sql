DROP TABLE IF EXISTS `evaluationQuestion`;

CREATE TABLE `evaluationQuestion` (
  `evalQuestionId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `parentQuestion` int(11) unsigned DEFAULT NULL,
  `flag` tinytext,
  PRIMARY KEY (`evalQuestionId`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `evalQuestionAnswers`;

CREATE TABLE `evalQuestionAnswers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `evalQuestionId` int(11) unsigned NOT NULL,
  `optionName` text NOT NULL,
  `nextQuestion` int(11) unsigned DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_evalQuestion` (`evalQuestionId`),
  KEY `fk_nextQuestion` (`nextQuestion`),
  CONSTRAINT `fk_evalQuestion` FOREIGN KEY (`evalQuestionId`) REFERENCES `evaluationQuestion` (`evalQuestionId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_nextQuestion` FOREIGN KEY (`nextQuestion`) REFERENCES `evaluationQuestion` (`evalQuestionId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

