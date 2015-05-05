INSERT INTO `permissions` (
  `name`,
  `description`,
  `controller`,
  `action`
) 
VALUES
  (
    'Get surveillance summary',
    'Get a list of attributes of a certain surveillance system',
    'evaluation',
    'getSurveillanceSummary'
  ) ;

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
  ('57', '1');

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('57', '2');
INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('57', '3');

TRUNCATE TABLE `evaluationQuestion`;
ALTER TABLE `evaluationQuestion` CHANGE `evalQuestionId` `evalQuestionId` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `evaluationQuestion`
CHANGE `question` `question` TEXT CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL ;
INSERT INTO `evaluationQuestion` (`question`)
VALUES
  (
    'Assess whether one or more surveillance component(s) is/are capable of meeting a technical effectiveness target?'
  ) ;

INSERT INTO `evaluationQuestion` (`question`)
VALUES
  (
    'Assess the costs of surveillance components (out of two or more) that achieve a defined effectiveness target?'
  ) ;

INSERT INTO `evaluationQuestion` (`question`)
VALUES
  (
    'Assess the technical effectiveness of one or more surveillance components?'
  ) ;

INSERT INTO `evaluationQuestion` (`question`)
VALUES
  (
    'Assess the technical effectiveness of one or more surveillance components and the functional aspects of surveillance that may influence effectiveness?'
  ) ;

INSERT INTO `evaluationQuestion` (`question`)
VALUES
  (
    'Assess whether a surveillance component generates a net benefit for society, industry, or animal holder(s): Benefit to be measured in monetary terms?'
  ) ;

INSERT INTO `evaluationQuestion` (`question`)
VALUES
  (
    'Assess whether a surveillance component generates a net benefit for society, industry, or animal holder(s): Benefit to be measured in non-monetary terms (effectiveness is one type of non-monetary benefit)?'
  ) ;

INSERT INTO `evaluationQuestion` (`question`)
VALUES
  (
    'Assess whether a surveillance component generates a net benefit for society, industry, or animal holder(s): Benefit to be measured in both monetary and non-monetary terms (effectiveness is one type of non-monetary benefit)?'
  ) ;

INSERT INTO`evaluationQuestion` (`question`)
VALUES
  (
    'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s): Benefit to be measured in monetary terms?'
  ) ;

INSERT INTO `evaluationQuestion` (`question`)
VALUES
  (
    'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s): Benefit to be measured in both monetary and non-monetary terms (effectiveness is one type of non-monetary benefit)?'
  ) ;

INSERT INTO `evaluationQuestion` (`question`)
VALUES
  (
    'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s) under a budget constraint Budget constraint and benefit to be measured in non-monetary terms (effectiveness is one type of non-monetary benefit)?'
  ) ;

INSERT INTO `evaluationQuestion` (`question`)
VALUES
  (
    'Assess the functional aspects of surveillance which may influence effectiveness?'
  ) ;

INSERT INTO `evaluationQuestion` (`question`)
VALUES
  (
    'Assess the functional aspects of surveillance which may influence effectiveness and the costs of changing these functional aspects?'
  ) ;

INSERT INTO `evaluationQuestion` (`question`)
VALUES
  (
    'Assess the surveillance structure, function and processes?'
  ) ;
ALTER TABLE `evaluationQuestion` DROP COLUMN `shortName`;
ALTER TABLE `evaluationQuestion` ADD COLUMN `parentQuestion` INT(11) UNSIGNED NULL AFTER `question`;
INSERT INTO `permissions` (
  `name`,
  `description`,
  `controller`,
  `action`
)
VALUES
  (
    'Select evaluation question',
    'Select evaluation question',
    'evaluation',
    'selectEvaQuestion'
  );

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
  ('58', '1') ;

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
  ('58', '2') ;

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
  ('58', '3') ;

CREATE TABLE `evalQuestionOptions` (
  `id` INT (11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `evalQuestionId` INT (11) UNSIGNED NOT NULL,
  `optionName` TEXT NOT NULL,
  PRIMARY KEY (`id`)
) ;
ALTER TABLE `evalQuestionOptions`
ADD CONSTRAINT `fk_evalQuestion` FOREIGN KEY (`evalQuestionId`) REFERENCES `evaluationQuestion` (`evalQuestionId`) ON UPDATE CASCADE ON DELETE CASCADE ;
INSERT INTO `permissions` (
  `id`,
  `name`,
  `description`,
  `controller`,
  `action`
)
VALUES
  (
    '',
    'evalQuestionList',
    'Evaluation question list',
    'evaluation',
    'evalQuestionList'
  ) ;

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
  ('59', '1') ;
INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
  ('59', '2') ;
INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
  ('59', '3') ;