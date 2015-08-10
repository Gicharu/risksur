
INSERT INTO `permissions` (`id`, `name`, `description`, `controller`, `action`, `bizrule`) VALUES
  (88, 'actionGetQuestionGroups', 'C/A to rerieve question groups', 'adminattributerelevance', 'getQuestionGroups', '');

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES
  (88, 1),
  (88, 2);
