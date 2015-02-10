-- create evaluation header table
CREATE 
TABLE `evaluationHeader`( 
	`evalId` INT(11) NOT NULL AUTO_INCREMENT, 
	`evaluationName` VARCHAR(50),
	`frameworkId` INT(11),
	`userId` INT(11),
	`evaluationDescription` BLOB, PRIMARY KEY (`evalId`)
); 

-- create document pages table
CREATE 
TABLE `docPages`( 
	`docId` INT(11) NOT NULL AUTO_INCREMENT, 
	`docName` VARCHAR(50), 
	`docData` BLOB, PRIMARY KEY (`docId`) 
); 
