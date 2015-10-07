<?php
/* @var $this AdmineconomicmethodsController */
/* @var $model EconomicMethods */

$this->breadcrumbs = [
	'Economic Methods' => ['index'],
	$model->name       => ['view', 'id' => $model->id],
	'Update',
];

$this->menu = [
	['label' => 'List Economic Analysis Techniques', 'url' => ['index']],
	['label' => 'Add Economic Analysis Technique', 'url' => ['create']],
];
?>

	<h3>Update <?= $model->name; ?> economic analysis technique </h3>

<?php $this->renderPartial('_form', ['model' => $model]); ?>