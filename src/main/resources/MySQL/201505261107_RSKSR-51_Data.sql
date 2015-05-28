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
  ) ;

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
  ('67', '1'),
  ('67', '2'),
  ('67', '3') ;