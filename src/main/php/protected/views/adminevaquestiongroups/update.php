<?php
/* @var $this AdminevaquestiongroupsController */
/* @var $model EvaQuestionGroups */

$this->breadcrumbs = [
	'Eva Question Groups' => ['index'],
	$model->groupId       => ['view', 'id' => $model->groupId],
	'Update',
];

$this->menu = [
	['label' => 'List Associations', 'url' => ['index']],
	['label' => 'Add Association', 'url' => ['create']],
];
?>

	<h3>Update Association </h3>

<?php $this->renderPartial('_form', ['model' => $model]); ?>