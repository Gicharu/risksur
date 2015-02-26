UPDATE `programpages` SET `pageName` = 'Design' , `path` = 'design/listComponents' WHERE `pageId` = '2';
INSERT INTO `programpages` (`pageName`, `path`, `parentId`, `menuOrder`) VALUES ('Surveillance Context', 'context/list', '0', '1');
UPDATE `programpages` SET `menuOrder` = '2' WHERE `pageId` = '1';
INSERT INTO `pages_has_roles` (`pageId`, `roleId`) VALUES ('15', '1');
INSERT INTO `pages_has_roles` (`pageId`, `roleId`) VALUES ('15', '2');
INSERT INTO `pages_has_roles` (`pageId`, `roleId`) VALUES ('15', '3');

INSERT INTO `permissions` (`name`, `description`, `controller`, `action`) VALUES ('List context', 'List surveillance context', 'context', 'list');
INSERT INTO `permissions` (`name`, `description`, `controller`, `action`) VALUES ('Create context', 'Create surveillance context', 'context', 'create');
INSERT INTO `permissions` (`name`, `description`, `controller`, `action`) VALUES ('Delete context', 'Delete surveillance context', 'context', 'delete');
INSERT INTO `permissions` (`name`, `description`, `controller`, `action`) VALUES ('Update context', 'Update surveillance context', 'context', 'update');
INSERT INTO `permissions` (`name`, `description`, `controller`, `action`) VALUES ('View context', 'View surveillance context', 'context', 'view');
INSERT INTO `permissions` (`name`, `description`, `controller`, `action`) VALUES ('Context index', 'Context index', 'context', 'index');


INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('51', '1');
INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('51', '2');
INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('52', '1');
INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('52', '2');
INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('53', '1');
INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('53', '2');
INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('54', '1');
INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('54', '2');
INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('55', '1');
INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('55', '2');
INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('56', '1');
INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES ('56', '2');


INSERT INTO `frameworkFields` (`id`, `label`, `inputName`, `inputType`, `required`, `showOnContextList`, `description`) VALUES
  (4,  NULL, 'hazardName', 'text', 1, 0, NULL),
  (5, NULL, 'surveillanceObjectiv', 'text', 1, 0, NULL),
  (6, NULL, 'geographicalArea', 'text', 1, 0, NULL),
  (7, NULL, 'susceptibleSpecies', 'text', 1, 0, NULL),
  (8, NULL, 'riskCharacteristics', 'text', 1, 0, NULL),
  (9, NULL, 'legalRequirements', 'text', 1, 0, NULL),
  (10, NULL, 'actionsTaken', 'text', 1, 0, NULL);
