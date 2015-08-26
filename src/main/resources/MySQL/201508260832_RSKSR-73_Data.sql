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