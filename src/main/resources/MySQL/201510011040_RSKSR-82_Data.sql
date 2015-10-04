INSERT INTO `permissions` (`id`, `name`, `description`, `controller`, `action`, `bizrule`) VALUES
  (111, 'actionIndex', 'C/A to list surveillance sections', 'adminsurveillancesections', 'index', ''),
  (112, 'actionHome', 'C/A to surveillance sections ADMIN home page', 'adminsurveillancesections', 'home', ''),
  (113, 'actionUpdate', 'C/A to update surveillance sections descripti', 'adminsurveillancesections', 'update', ''),
  (114, 'actionHome', 'C/A to options home page', 'options', 'home', '');

INSERT INTO `programpages` (
  `pageName`,
  `path`,
  `parentId`,
  `menuOrder`
)
VALUES
  (
    'Manage Surveillance Tool',
    'adminsurveillancesections/home',
    '8',
    '19'
  ) ;

INSERT INTO `pages_has_roles` (`pageId`, `roleId`)
VALUES
  ('19', '1'),
  ('19', '2');


INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES
  (111, 1),
  (111, 2),
  (112, 1),
  (112, 2),
  (113, 1),
  (113, 2),
  (114, 1),
  (114, 2);


INSERT INTO `frameworkFields` (`id`, `sectionId`, `parentId`, `label`, `inputName`, `inputType`, `required`, `order`, `gridField`, `description`, `childCount`, `multiple`) VALUES
  (74, 2, 59, 'Other reason for surveillance', 'otherSurvReason', 'textarea', 0, '3.2', 0, NULL, NULL, NULL);

UPDATE `programpages` SET `path` = 'options/home' WHERE `pageId` = '12';
INSERT INTO `docPages` (`docName`) VALUES ('optionsHome');