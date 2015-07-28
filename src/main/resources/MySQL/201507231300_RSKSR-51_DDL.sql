CREATE TABLE IF NOT EXISTS `evaAssessmentMethods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `evaluationId` int(11) NOT NULL,
  `evaAttribute` int(11) NOT NULL,
  `expertise` set('logistic_modelling','r_software') COLLATE utf8_unicode_ci NOT NULL,
  `methodDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `dataAvailability` enum('yes','no','data_collection_needed') CHARACTER SET utf8 NOT NULL,
  `references` text CHARACTER SET utf8,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

ALTER TABLE `evaluationHeader`
ADD COLUMN `evaAttributes` TEXT CHARSET utf8 COLLATE utf8_unicode_ci NULL AFTER `questionId` ;