CREATE TABLE 
`perfAttributes`( 
	`attributeId` INT(11) NOT NULL AUTO_INCREMENT, 
	`name` VARCHAR(50), 
	`description` BLOB, 
	PRIMARY KEY (`attributeId`) ); 

CREATE TABLE 
`attributeFormRelation`( 
	`attributeId` INT(11) NOT NULL, 
	`subFormId` INT(11) NOT NULL, 
	PRIMARY KEY (`attributeId`, `subFormId`), 
	CONSTRAINT `fk_attributeFormRelation_perfAttributes` FOREIGN KEY (`attributeId`) REFERENCES `perfAttributes`(`attributeId`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `fk_attributeFormRelation_surFormDetails` FOREIGN KEY (`subFormId`) REFERENCES `surFormDetails`(`subFormId`) ON UPDATE CASCADE ON DELETE CASCADE ); 
