INSERT INTO `risksur`.`permissions` (`name`, `description`, `controller`, `action`) VALUES ('List context', 'List surveillance context', 'context', 'list');
INSERT INTO `risksur`.`permissions` (`name`, `description`, `controller`, `action`) VALUES ('Create context', 'Create surveillance context', 'context', 'create');
INSERT INTO `risksur`.`permissions` (`name`, `description`, `controller`, `action`) VALUES ('Delete context', 'Delete surveillance context', 'context', 'delete');
INSERT INTO `risksur`.`permissions` (`name`, `description`, `controller`, `action`) VALUES ('Update context', 'Update surveillance context', 'context', 'update');
INSERT INTO `risksur`.`permissions` (`name`, `description`, `controller`, `action`) VALUES ('View context', 'View surveillance context', 'context', 'view');
INSERT INTO `risksur`.`permissions` (`name`, `description`, `controller`, `action`) VALUES ('Context index', 'Context index', 'context', 'index');


INSERT INTO `risksur`.`roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('51', '1');
INSERT INTO `risksur`.`roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('51', '2');
INSERT INTO `risksur`.`roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('52', '1');
INSERT INTO `risksur`.`roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('52', '2');
INSERT INTO `risksur`.`roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('53', '1');
INSERT INTO `risksur`.`roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('53', '2');
INSERT INTO `risksur`.`roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('54', '1');
INSERT INTO `risksur`.`roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('54', '2');
INSERT INTO `risksur`.`roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('55', '1');
INSERT INTO `risksur`.`roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('55', '2');
INSERT INTO `risksur`.`roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('56', '1');
INSERT INTO `risksur`.`roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('56', '2');