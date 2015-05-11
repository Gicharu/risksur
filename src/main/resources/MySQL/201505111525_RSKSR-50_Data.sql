INSERT INTO `permissions` (
  `name`,
  `description`,
  `controller`,
  `action`
)
VALUES
  (
    'actionEvaMethods',
    'Evaluation methods controller action',
    'evaluation',
    'evaMethods'
  ) ;


INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
  ('61', '1'),
  ('61', '2'),
  ('61', '3') ;

