INSERT INTO `permissions` (
  `id`,
  `name`,
  `description`,
  `controller`,
  `action`
)
VALUES
  (
    '57',
    'Get surveillance summary',
    'Get a list of attributes of a certain surveillance system',
    'evaluation',
    'getSurveillanceSummary'
  ),
  (
    '60',
    'actionEvaQuestionWizard',
    'Surveillance question guided wizard',
    'evaluation',
    'evaQuestionWizard'
  ) ;

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
  ('57', '1'),
  ('57', '2'),
  ('57', '3'),
  ('60', '1'),
  ('60', '2'),
  ('60', '3');
