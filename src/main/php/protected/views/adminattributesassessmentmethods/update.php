<?php
/* @var $this AdminAttributesAssessmentMethodsController */
/* @var $model EvaAttributesAssessmentMethods */

$this->breadcrumbs = [
	'Eva Attributes Assessment Methods' => ['index'],
	$model->name                        => ['view', 'id' => $model->id],
	'Update',
];

$this->menu = [
	['label' => 'List Assessment Methods', 'url' => ['index']],
	['label' => 'Add Assessment Method', 'url' => ['create']]
];
?>

	<h3>Update Evaluation Attribute Assessment Method <?= $model->name; ?></h3>

<?php $this->renderPartial('_form', ['model' => $model]); ?>