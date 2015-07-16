DELETE FROM `programpages` WHERE `pageId` = '16';
INSERT INTO `programpages` (`pageName`, `parentId`) VALUES ('Manage Evaluation Tool', '8');

ALTER TABLE `evalElements`
ADD COLUMN `elementMetaData` BLOB NULL AFTER `inputType` ;

UPDATE
  `permissions`
SET
  `controller` = 'adminEva'
WHERE `id` = '62' ;

UPDATE
  `permissions`
SET
  `controller` = 'adminEva'
WHERE `id` = '63' ;

UPDATE
  `permissions`
SET
  `controller` = 'adminEva'
WHERE `id` = '64' ;

UPDATE
  `permissions`
SET
  `controller` = 'adminEva'
WHERE `id` = '65' ;

INSERT INTO `permissions` (
  `name`,
  `description`,
  `controller`,
  `action`
)
VALUES
  (
    'actionIndex',
    'C/A to introduce evaluation tool administration',
    'adminEva',
    'index'
  ),
  (
    'actionListEvaContext',
    'C/A to list available evaluation context elements',
    'adminEva',
    'listEvaContext'
  ),
  (
    'actionUpdateEvaContext',
    'C/A to update evaluation context form field',
    'adminEva',
    'updateEvaContext'
  ),
  (
    'actionDeleteEvaContext',
    'C/A to delete evaluation context form field',
    'adminEva',
    'deleteEvaContext'
  );




INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
('72', '1'),
('72', '2'),
('73', '1'),
('73', '2'),
('74', '1'),
('74', '2'),
('75', '1'),
('75', '2');

INSERT INTO `pages_has_roles` (`pageId`, `roleId`)
VALUES
  ('17', '1'),
  ('17', '2') ;
