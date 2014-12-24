/* set user to role ROLE_USER */

UPDATE `users_has_roles` SET `roles_id` = '3' WHERE `users_id` = '8' AND `roles_id` = '1';

/* add permission for program pages */
INSERT INTO `pages_has_roles`(`pageId`,`roleId`) values
(2,1), (2,2), (2,3),
(3,1), (3,2), (3,3),
(4,1), (4,2), (4,3),
(5,1), (5,2), (5,3),
(6,1), (6,2), (6,3),
(8,1), (8,2),
(9,1), (9,2), (9,3),
(10,1), (10,2),
(11,1), (11,2),
(12,1), (12,2),
(13,1), (13,2) 
;
