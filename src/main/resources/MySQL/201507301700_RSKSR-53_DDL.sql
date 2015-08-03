ALTER TABLE `options`
  CHANGE `label` `label` TEXT CHARSET utf8 COLLATE utf8_unicode_ci NULL;
ALTER TABLE `evaluationHeader`
DROP COLUMN `evaluationDescription`;

ALTER TABLE `evaluationQuestion`
ADD COLUMN `questionNumber` VARCHAR (5) CHARSET utf8 NULL AFTER `question` ;

ALTER TABLE `evaAttributesMatrix` CHANGE `surveillanceObj` `surveillanceObj` INT(11) NOT NULL;