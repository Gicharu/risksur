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
