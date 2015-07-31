ALTER TABLE `options`
  CHANGE `label` `label` TEXT CHARSET utf8 COLLATE utf8_unicode_ci NULL;
ALTER TABLE `evaluationHeader`
DROP COLUMN `evaluationDescription`;