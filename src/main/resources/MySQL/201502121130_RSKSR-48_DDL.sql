-- create evaluation details table
CREATE TABLE 
`evaluationDetails`( 
	`evalDetailsId` INT(11) NOT NULL AUTO_INCREMENT, 
	`evalId` INT(11), 
	`evalElementsId` INT(11), 
	`value` VARCHAR(254), 
	`comments` BLOB, PRIMARY KEY (`evalDetailsId`),
	CONSTRAINT `fk_evaluationHeader_evalId` FOREIGN KEY (`evalId`) REFERENCES `evaluationHeader`(`evalId`) ON UPDATE CASCADE ON DELETE CASCADE 
); 

-- create evaluation elements table
CREATE TABLE 
`evalElements`( 
	`evalElementsId` INT(11) NOT NULL AUTO_INCREMENT, 
	`inputName` VARCHAR(50), 
	`label` VARCHAR(50), 
	`inputType` VARCHAR(50), 
	`required` TINYINT(1) DEFAULT 1, PRIMARY KEY (`evalElementsId`) 
); 

