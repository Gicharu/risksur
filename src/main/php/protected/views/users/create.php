<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);
$this->menu=array(
	array('label'=>'View Users', 'url'=>array('index')),
);
?>
<h1>Create Users</h1>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>