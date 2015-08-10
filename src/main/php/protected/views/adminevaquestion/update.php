<?php
/* @var $this AdminevaquestionController */
/* @var $model EvaluationQuestion */

$this->breadcrumbs=array(
	'Evaluation Questions'=>array('index'),
	$model->evalQuestionId=>array('view','id'=>$model->evalQuestionId),
	'Update',
);

$this->menu=array(
	array('label'=>'List EvaluationQuestions', 'url'=>array('index')),

);
?>

<h3>Update EvaluationQuestion <?php echo $model->questionNumber; ?></h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>