<?php
/* @var $this AdminevaquestionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Evaluation Questions',
);

$this->menu=array(
	array('label'=>'Create EvaluationQuestion', 'url'=>array('create')),
	array('label'=>'Manage EvaluationQuestion', 'url'=>array('admin')),
);
?>

<h1>Evaluation Questions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
