
INSERT INTO `permissions` (`id`, `name`, `description`, `controller`, `action`, `bizrule`) VALUES
(106, 'actionIndex', 'C/A to view economic methods / question link', 'adminevaquestiongroups', 'index', ''),
(107, 'actionCreate', 'C/A to add economic method / question link', 'adminevaquestiongroups', 'create', ''),
(108, 'actionUpdate', 'C/A to update economic method / question link', 'adminevaquestiongroups', 'update', ''),
(109, 'actionDelete', 'C/A to remove economic method / question link', 'adminevaquestiongroups', 'delete', '');

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES
  (106, 1),
  (106, 2),
  (107, 1),
  (107, 2),
  (108, 1),
  (108, 2),
  (109, 1),
  (109, 2);
