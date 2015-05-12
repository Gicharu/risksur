INSERT INTO `permissions` (
  `id`,
  `name`,
  `description`,
  `controller`,
  `action`
)
VALUES
  (
    '61',
    'actionEvaMethods',
    'Evaluation methods controller action',
    'evaluation',
    'evaMethods'
  ),
  (
    '62',
    'actionListEvaMethods',
    'C/A to view and manage economic evaluation methhods ',
    'admin',
    'listEvaMethods'
  ),
  (
    '63',
    'actionAddEvaMethod',
    'C/A to add new evaluation methos',
    'admin',
    'addEvaMethod'
  ),
  (
    '64',
    'actionUpdateEvaMethod',
    'C/A to update the economic evaluation methods',
    'admin',
    'updateEvaMethod'
  ),
  (
    '65',
    'actionDeleteEvaMethod',
    'C/A to delete an economic evaluation method',
    'admin',
    'deleteEvaMethod'
  ) ;


INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
  ('61', '1'),
  ('61', '2'),
  ('61', '3'),
  ('62', '1'),
  ('62', '2'),
  ('63', '1'),
  ('63', '2'),
  ('64', '1'),
  ('64', '2'),
  ('65', '1'),
  ('65', '2');

INSERT INTO `programpages` (
  `pageName`,
  `path`,
  `parentId`,
  `menuOrder`
)
VALUES
  (
    'Manage Economic Evaluation Methods',
    'admin/listEvaMethods',
    '8',
    '18'
  );

INSERT INTO `pages_has_roles` (`pageId`, `roleId`)
VALUES
  ('16', '1'),
  ('16', '2');

