<?php
/* @var $this AdminevaquestionController */
/* @var $model EvaluationQuestion */

$this->breadcrumbs=array(
	'Evaluation Questions'=>array('index'),
	$model->evalQuestionId=>array('view','id'=>$model->evalQuestionId),
	'Update',
);

$this->menu=array(
	array('label'=>'List EvaluationQuestion', 'url'=>array('index')),
	array('label'=>'Create EvaluationQuestion', 'url'=>array('create')),
	array('label'=>'View EvaluationQuestion', 'url'=>array('view', 'id'=>$model->evalQuestionId)),
	array('label'=>'Manage EvaluationQuestion', 'url'=>array('admin')),
);
?>

<h1>Update EvaluationQuestion <?php echo $model->evalQuestionId; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>