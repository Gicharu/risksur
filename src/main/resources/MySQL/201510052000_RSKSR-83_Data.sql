INSERT INTO `docPages` (`docId`, `docName`, `docData`) VALUES
(17, 'optionsHome', 0x3c703e6f707420686f6d6520343c2f703e),
(18, 'adminEvaHome', 0x3c68333e204d616e616765204576616c756174696f6e20546f6f6c3c2f68333e3c703e0a09546869732073656374696f6e20616c6c6f777320796f7520746f20766965772c206164642c2075706461746520616e642064656c65746520766172696f757320636f6d706f6e656e7473206f6620746865206576616c756174696f6e20746f6f6c2e2053656c6563740a09612073656374696f6e20666f726d20746865206c65667420746f20626567696e2e0a3c2f703e),
(19, 'evalQuestionList', 0x3c703e436f6e74656e7420686572653c2f703e),
(20, 'evaSummary', 0x3c703e436f6e74656e7420686572653c2f703e);

INSERT INTO `permissions` (
  `name`,
  `description`,
  `controller`,
  `action`
)
VALUES
  (
    'actionAddEvaContext',
    'C/A to add evaluation context form field',
    'admineva',
    'addEvaContext'
  ) ;

INSERT INTO `roles_has_permissions` (`permissions_id`, `roles_id`) VALUES
  (115, 1),
  (115, 2);

UPDATE
  `evaluationQuestion`
SET
  `question` = 'You can use the surveillance design tool to re-design surveillance but carrying out an evaluation to assess the effectiveness of surveillance or the functional aspects that may influence effectiveness may help to inform the re-design process <br /> Do you want to re-design surveillance or carry out an evaluation?'
WHERE `evalQuestionId` = '49' ;

UPDATE
  `evalQuestionAnswers`
SET
  `flashQuestion` = 'Note:If you want to evaluate cost effectiveness or economic efficiency you need to compare alternative designs or compare surveillance to a situation with no surveillance  '
WHERE `id` = '71' ;
UPDATE
  `evalQuestionAnswers`
SET
  `optionName` = 'To evaluate the strengths and weaknesses of the structure, function and processes of the component'
WHERE `id` = '15' ;

UPDATE
  `evalQuestionAnswers`
SET
  `optionName` = 'To evaluate the strengths and weaknesses of the structure, function and processes of the system'
WHERE `id` = '46' ;

UPDATE
  `evalQuestionAnswers`
SET
  `optionName` = 'Evaluate the effectiveness of the system'
WHERE `id` = '45' ;