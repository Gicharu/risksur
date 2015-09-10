<?php
/* @var $this AdminAttributesAssessmentMethodsController */
/* @var $model EvaAttributesAssessmentMethods */

$this->breadcrumbs = [
	'Evaluation Attributes Assessment Methods' => ['index'],
	'Create',
];

$this->menu = [
	['label' => 'List Assessment Methods', 'url' => ['index']]
];
?>

	<h3>Add Evaluation Attribute Assessment Method</h3>

<?php $this->renderPartial('_form', ['model' => $model]); ?>