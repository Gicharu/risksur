SET foreign_key_checks = 0;
DROP TABLE `perfAttributes`;
SET foreign_key_checks = 1;
CREATE TABLE IF NOT EXISTS `evaAttributes` (
  `attributeId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `description` blob NOT NULL,
  `attributeType` int(11) unsigned NOT NULL,
  PRIMARY KEY (`attributeId`),
  UNIQUE KEY `unique_name` (`name`),
  KEY `fk_attriuteType` (`attributeType`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

CREATE TABLE IF NOT EXISTS `evaAttributeTypes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;


CREATE TABLE IF NOT EXISTS `evaMethods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `buttonName` text COLLATE utf8_unicode_ci NOT NULL,
  `link` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;
