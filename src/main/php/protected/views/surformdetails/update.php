<?php
	/* @var $this SurFormDetailsController */
	/* @var $model SurFormDetails */

	$this->breadcrumbs = [
		'Sur Form Details' => ['index'],
		$model->subFormId => ['view', 'id' => $model->subFormId],
		'Update',
	];

	$this->menu = [
		['label' => 'View Form Elements', 'url' => ['index']],
		['label' => 'Create Form Element', 'url' => ['create']],
	];
?>

	<h1>Update <?php echo $model->label; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>