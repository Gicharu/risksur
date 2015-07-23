CREATE TABLE IF NOT EXISTS `evaAssessmentMethods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `evaluationId` int(11) NOT NULL,
  `expertise` int(11) NOT NULL,
  `dataAvailability` enum('yes','no','data_collection_needed') NOT NULL,
  `references` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;