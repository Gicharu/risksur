UPDATE 
  `frameworkFields` 
SET
  `inputName` = NULL,
  `inputType` = 'label'
WHERE `id` = '57' ;

INSERT INTO `frameworkFields` (
  `sectionId`, `parentId`, `label`, `inputName`, `inputType`, `required`, `order`)
VALUES
('2', '57', 'a) Why is surveillance necessary', 'survReason', 'dropdownlist', '0', '3.1');

INSERT INTO `frameworkFields` (
  `sectionId`,
  `parentId`,
  `label`,
  `inputName`,
  `inputType`,
  `required`,
  `order`
)
VALUES
  (
    '2',
    '57',
    'b) What will it accomplish',
    'survAccomp',
    'dropdownlist',
    '0',
    '3.2'
  ) ;

INSERT INTO `permissions` (
  `name`,
  `description`,
  `controller`,
  `action`
)
VALUES
  (
    'actionEditMultipleComponents',
    'C/A to edit components in parallel',
    'design',
    'editMultipleComponents'
  ) ;


INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
  ('91', '1'),
  ('91', '2'),
  ('91', '3') ;