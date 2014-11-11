<?php
/* @var $this SurFormDetailsController */
/* @var $model SurFormDetails */

$this->breadcrumbs=array(
	'Sur Form Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'View Form Elements', 'url'=>array('index')),
	//array('label'=>'Manage SurFormDetails', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>