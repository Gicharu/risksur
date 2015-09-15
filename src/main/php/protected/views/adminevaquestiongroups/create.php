<?php
/* @var $this AdminevaquestiongroupsController */
/* @var $model EvaQuestionGroups */

$this->breadcrumbs = [
	'Eva Question Groups' => ['index'],
	'Create',
];

$this->menu = [
	['label' => 'List Associations', 'url' => ['index']],
];
?>

	<h3>Add new association</h3>

<?php $this->renderPartial('_form', ['model' => $model]); ?>