<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->userId=>array('view','id'=>$model->userId),
	'Update',
);
$this->menu=array(
	array('label'=>'View Users', 'url'=>array('index')),
	array('label'=>'Add User', 'url'=>array('createUser')),
);
?>
<h1>Update Users <?php echo $model->userId; ?></h1>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>