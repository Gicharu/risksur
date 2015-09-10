ALTER TABLE `evaluationHeader`
  ADD COLUMN `components` TEXT CHARSET utf8 NULL AFTER `questionId`;

CREATE TABLE IF NOT EXISTS `evaAttributesAssessmentMethods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `evaAttribute` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `dataRequired` text NOT NULL,
  `expertiseRequired` text NOT NULL,
  `reference` text,
  PRIMARY KEY (`id`),
  KEY `fk_evaAttribute` (`evaAttribute`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Constraints for dumped tables
-- Constraints for table `evaAttributesAssessmentMethods`
--
ALTER TABLE `evaAttributesAssessmentMethods`
ADD CONSTRAINT `fk_evaAttribute` FOREIGN KEY (`evaAttribute`) REFERENCES `evaAttributes` (`attributeId`) ON DELETE CASCADE ON UPDATE CASCADE;