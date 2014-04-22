<?php
$this->pageTitle = Yii::app()->name . ' - Edit User';
$this->breadcrumbs = array(
	'User' => array(
		'index'
	),
	'Edit',
);
?>
<div class="pageHeader">Edit User</div>

<?php if (Yii::app()->user->hasFlash('user')) { ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('user'); ?>
</div>

<?php
} else { ?>
<?php echo $this->renderPartial('_form', array(
		'model' => $model,
		'listData' => $listData
	)); ?>
<?php
}; ?>

