<?php
/* @var $this SurFormDetailsController */
/* @var $model SurFormDetails */

$this->breadcrumbs=array(
	'Sur Form Details'=>array('index'),
	$model->subFormId=>array('view','id'=>$model->subFormId),
	'Update',
);

$this->menu=array(
	array('label'=>'View Form Elements', 'url'=>array('index')),
	array('label'=>'Create Form Element', 'url'=>array('create')),
);
?>

<h1>Update SurFormDetails <?php echo $model->subFormId; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>