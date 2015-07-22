<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 5/5/15
 * Time: 12:01 PM
 * @var $this EvaluationController
 * @var $page Array
 */

$this->renderPartial('_page', [
		'content' => $page['content'],
		'editAccess' => $page['editAccess'],
		'editMode' => $page['editMode']
	]
);
if(!$page['editMode']) {
	echo CHtml::tag('fieldset', ['class' => 'evaFieldSet'], '<legend> What would you like to do? </legend>', false);
	echo CHtml::link('Guidance to define the evaluation question',
		$this->createUrl('evaQuestionWizard'), ['class' => 'btn']);
	echo CHtml::link('Evaluation question pick list',
		$this->createUrl('evalQuestionList'), ['class' => 'btn']);
	echo CHtml::closeTag('fieldset');

}
