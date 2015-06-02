INSERT INTO `permissions` (
  `id`,
  `name`,
  `description`,
  `controller`,
  `action`
)
VALUES
  (
    67,
    'actionEconEval',
    'C/A to economic evaluation page',
    'evaluation',
    'econEval'
  ),
  (
    68,
    'actionGetEvaSummary',
    'C/A to retrieve evaluation summary',
    'evaluation',
    'getEvaSummary'
  ) ;

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
  ('67', '1'),
  ('67', '2'),
  ('67', '3'),
  ('68', '1'),
  ('68', '2'),
  ('68', '3') ;