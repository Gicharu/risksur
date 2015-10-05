<?php
/* @var $this AdmineconomicmethodsController */
/* @var $model EconomicMethods */

$this->breadcrumbs = [
	'Economic Methods' => ['index'],
	'Create',
];

$this->menu = [
	['label' => 'List Economic Approaches', 'url' => ['index']],
];
?>

	<h3>Add economic approach</h3>

<?php $this->renderPartial('_form', ['model' => $model]); ?>