INSERT INTO `evaluationQuestion` (
  `evalQuestionId`,
  `question`,
  `parentQuestion`,
  `flag`
)
VALUES
  (
    1,
    'Assess whether one or more surveillance component(s) is/are capable of meeting a technical effectiveness target ',
    NULL,
    'final'
  ),
  (
    2,
    'Assess the costs of surveillance components (out of two or more) that achieve a defined effectiveness target',
    NULL,
    'final'
  ),
  (
    3,
    'Assess the technical effectiveness of one or more surveillance components',
    NULL,
    'final'
  ),
  (
    4,
    'Assess the technical effectiveness of one or more surveillance components and the functional aspects of surveillance that may influence effectiveness',
    NULL,
    'final'
  ),
  (
    5,
    'Assess whether a surveillance component generates a net benefit for society, industry, or animal holder(s): Benefit to be measured in monetary terms',
    NULL,
    'final'
  ),
  (
    6,
    'Assess whether a surveillance component generates a net benefit for society, industry, or animal holder(s): Benefit to be measured in non-monetary terms (effectiveness is one type of non-monetary benefit)',
    NULL,
    'final'
  ),
  (
    7,
    'Assess whether a surveillance component generates a net benefit for society, industry, or animal holder(s): Benefit to be measured in both monetary and non-monetary terms (effectiveness is one type of non-monetary benefit)',
    NULL,
    'final'
  ),
  (
    8,
    'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s): Benefit to be measured in monetary terms',
    NULL,
    'final'
  ),
  (
    9,
    'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s): Benefit to be measured in both monetary and non-monetary terms (effectiveness is one type of non-monetary benefit)',
    NULL,
    'final'
  ),
  (
    10,
    'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s) under a budget constraint Budget constraint and benefit to be measured in non-monetary terms (effectiveness is one type of non-monetary benefit)',
    NULL,
    'final'
  ),
  (
    11,
    'Assess the functional aspects of surveillance which may influence effectiveness',
    NULL,
    'final'
  ),
  (
    12,
    'Assess the functional aspects of surveillance which may influence effectiveness and the costs of changing these functional aspects ',
    NULL,
    'final'
  ),
  (
    13,
    'Assess the surveillance structure, function and processes',
    NULL,
    'final'
  ),
  (
    16,
    'Are you aiming to evaluate the effectiveness of surveillance or how well surveillance is performing or to re-design your surveillance to improve its performance',
    41,
    NULL
  ),
  (
    17,
    'Are you aiming to evaluate how well your surveillance is performing or re-design your surveillance to improve its performance',
    41,
    NULL
  ),
  (
    20,
    'Do you want to assess whether your surveillance meets a specified technical target or do you want to assess the absolute level of effectiveness',
    16,
    NULL
  ),
  (
    21,
    'What do you want to evaluate',
    16,
    NULL
  ),
  (
    22,
    'Have you evaluated the effectiveness of your surveillance',
    16,
    NULL
  ),
  (
    23,
    'Do you want to make a comparison between two or more alternative surveillance designs (e.g. risk-based vs conventional) to find out whether one is preferable to the other one or to compare a novel surveillance component to a situation in which there is no surveillance or do you want to evaluate the performance of a surveillance component without making a comparison? ',
    21,
    NULL
  ),
  (
    24,
    'Have you determined the effectiveness ',
    21,
    NULL
  ),
  (
    25,
    'Have you evaluated the effectiveness of your surveillance?',
    16,
    NULL
  ),
  (
    26,
    'What measures will be used to assess the efficiency /effectiveness of surveillance',
    23,
    NULL
  ),
  (
    27,
    'Do the components that you want to compare have the same objective',
    23,
    NULL
  ),
  (
    28,
    'What measures will be used to assess the efficiency /effectiveness of surveillance',
    27,
    NULL
  ),
  (
    29,
    'SORRY, The EVA tool does currently not provide guidance for evaluation of surveillance components with different objectives ',
    0,
    NULL
  ),
  (
    30,
    'Do the alternative components you are comparing achieve a target effectiveness',
    28,
    NULL
  ),
  (
    31,
    'Do the alternative components you are comparing achieve a target effectiveness',
    28,
    NULL
  ),
  (
    32,
    'Do you want to assess whether your surveillance meets a specified technical target \r\nor do you want to assess the absolute level of effectiveness',
    28,
    NULL
  ),
  (
    33,
    'Include functional aspects?',
    32,
    NULL
  ),
  (
    34,
    'How can you measure benefits?',
    28,
    NULL
  ),
  (
    35,
    'Is there a budget constraint?',
    34,
    NULL
  ),
  (
    36,
    'Is there a budget constraint?',
    34,
    NULL
  ),
  (
    37,
    'Is there a budget constraint?',
    34,
    NULL
  ),
  (
    38,
    'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s) under a budget constraint Budget constraint and benefit to be measured in monetary terms',
    NULL,
    'final'
  ),
  (
    39,
    'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s) under a budget constraint Budget constraint and benefit to be measured in non-monetary terms (effectiveness is one type of non-monetary benefit)',
    NULL,
    'final'
  ),
  (
    40,
    'Identify the surveillance component (out of two or more) that generates the biggest net benefit for society, industry, or animal holder(s) under a budget constraint  Budget constraint and benefit to be measured in both monetary and non-monetary terms (effectiveness is one type of non-monetary benefit)',
    NULL,
    'final'
  ),
  (
    41,
    'Evaluations can be carried out at system or component level, at what level would you like to carry out your evaluation /improvement.  ',
    NULL,
    'primary'
  ),
  (
    42,
    'What do you want to evaluate?',
    17,
    NULL
  ) ;

INSERT INTO `evalQuestionAnswers` (
  `id`,
  `evalQuestionId`,
  `optionName`,
  `nextQuestion`,
  `url`
)
VALUES
  (
    2,
    1,
    'Evaluate / improve one or more distinct surveillance components',
    16,
    NULL
  ),
  (
    3,
    1,
    'Evaluate a surveillance system',
    17,
    NULL
  ),
  (
    8,
    16,
    'You know that your effectiveness needs to be improved and you wan to evaluate it (within a redesign process)',
    20,
    NULL
  ),
  (
    9,
    16,
    'Evaluate how well surveillance is performing',
    21,
    NULL
  ),
  (
    10,
    16,
    'To re-design surveillance to improve its performance',
    22,
    NULL
  ),
  (
    13,
    21,
    'Evaluate the efficiency and/or effectiveness of component',
    23,
    NULL
  ),
  (
    14,
    21,
    'To evaluate the functional aspects of the component that may influence its effectiveness',
    24,
    NULL
  ),
  (
    15,
    21,
    'To evaluate the strengths and weaknesses of the component structure, function and processes',
    13,
    NULL
  ),
  (16, 22, 'Yes', 11, NULL),
  (17, 22, 'No', 4, NULL),
  (18, 27, 'Yes', 28, NULL),
  (19, 27, 'No', 29, NULL),
  (20, 28, 'Cost only', 30, NULL),
  (
    22,
    28,
    'Effectiveness only (technical performance)',
    32,
    NULL
  ),
  (
    23,
    28,
    'Cost and effectiveness (technical performance)',
    31,
    NULL
  ),
  (24, 31, 'Yes', 2, NULL),
  (25, 31, 'No', 10, NULL),
  (
    26,
    32,
    'Assess whether surveillance meets a specified effectiveness target',
    1,
    NULL
  ),
  (
    27,
    32,
    'Assess the absolute level of effectiveness',
    33,
    NULL
  ),
  (28, 33, 'Yes', 4, NULL),
  (29, 33, 'No', 3, NULL),
  (30, 34, 'Monetary Terms?', 35, NULL),
  (
    31,
    34,
    'Non-Monetary terms?',
    36,
    NULL
  ),
  (
    32,
    34,
    'Monetary and non-monetary terms?',
    37,
    NULL
  ),
  (33, 35, 'Yes', 38, NULL),
  (35, 35, 'No', 8, NULL),
  (36, 36, 'Yes', 39, NULL),
  (37, 36, 'No', 10, NULL),
  (38, 37, 'Yes', 40, NULL),
  (39, 37, 'No', 9, NULL),
  (40, 41, 'System level', 17, NULL),
  (41, 41, 'Component level', 16, NULL),
  (
    43,
    17,
    'Re-design',
    NULL,
    'design/listComponents'
  ),
  (
    44,
    17,
    'Evaluate how well surveillance is performing',
    42,
    NULL
  ),
  (
    45,
    42,
    'Evaluate the effectiveness/performance of the system?',
    3,
    NULL
  ),
  (
    46,
    42,
    'To evaluate the strengths and weaknesses of the component structure, function and processes',
    13,
    NULL
  ) ;




INSERT INTO `permissions` (
  `id`,
	`name`,
	`description`,
	`controller`,
	`action`
)
VALUES
	(
		58,
		'Select evaluation question',
		'Select evaluation question',
		'evaluation',
		'selectEvaQuestion'
	);
INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
	('58', '1') ;

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
	('58', '2') ;

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
	('58', '3') ;

INSERT INTO `permissions` (
	`id`,
	`name`,
	`description`,
	`controller`,
	`action`
)
VALUES
	(
		59,
		'evalQuestionList',
		'Evaluation question list',
		'evaluation',
		'evalQuestionList'
	) ;

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
	('59', '1') ;
INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
	('59', '2') ;
INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`)
VALUES
	('59', '3') ;