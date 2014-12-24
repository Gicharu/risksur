INSERT 
	INTO 
		`perfAttributes` (`attributeId`, `name`, `description`) 
	VALUES 
		(1, 'Sensitivity', 'Sensitivity'),
		(2, 'False Alarm', 'False Alarm'),
		(3, 'Bias', 'Bias'),
		(4, 'Precision', 'Precision'),
		(5, 'Timeliness', 'Timeliness'),
		(6, 'NPV', 'NPV'),
		(7, 'PPV', 'PPV'),
		(8, 'Repeatability', 'Repeatability'),
		(9, 'Benefit', 'Benefit'),
		(10, 'Cost', 'Cost'),
		(11, 'Multiple Utility', 'Multiple Utility')
	; 

INSERT 
	INTO 
		`attributeFormRelation` (`attributeId`, `subFormId`) 
	VALUES 
		('1', '1'),
		('1', '3'),
		('1', '4'),
		('2', '1'),
		('3', '2'),
		('3', '4'),
		('4', '4'),
		('4', '5'),
		('4', '2'),
		('5', '2'),
		('5', '5'),
		('6', '1'),
		('7', '1'),
		('8', '1'),
		('8', '2'),
		('9', '7'),
		('9', '1'),
		('10', '5'),
		('10', '2'),
		('11', '4'),
		('11', '7')
	; 
