CREATE TABLE `pages_has_roles`( `pageId` INT(11) NOT NULL, `roleId` INT(11) NOT NULL, 
	PRIMARY KEY (`pageId`, `roleId`), CONSTRAINT `fk_pages_has_roles_programpages` 
	FOREIGN KEY (`pageId`) REFERENCES `programpages`(`pageId`) ON UPDATE CASCADE ON DELETE CASCADE, 
	CONSTRAINT `fk_pages_has_roles_roles` FOREIGN KEY (`roleId`) REFERENCES `roles`(`id`) ON UPDATE CASCADE ON DELETE CASCADE ); 
