<?php
/* @var $this AdmineconomicmethodsController */
/* @var $model EconomicMethods */

$this->breadcrumbs = [
	'Economic Methods' => ['index'],
	'Create',
];

$this->menu = [
	['label' => 'List Economic Analysis Techniques', 'url' => ['index']],
];
?>

	<h3>Add economic analysis technique</h3>

<?php $this->renderPartial('_form', ['model' => $model]); ?>