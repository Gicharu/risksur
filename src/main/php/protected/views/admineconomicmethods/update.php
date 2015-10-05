<?php
/* @var $this AdmineconomicmethodsController */
/* @var $model EconomicMethods */

$this->breadcrumbs = [
	'Economic Methods' => ['index'],
	$model->name       => ['view', 'id' => $model->id],
	'Update',
];

$this->menu = [
	['label' => 'List Economic Approaches', 'url' => ['index']],
	['label' => 'Add Economic Approach', 'url' => ['create']],
];
?>

	<h3>Update <?= $model->name; ?> economic approach </h3>

<?php $this->renderPartial('_form', ['model' => $model]); ?>