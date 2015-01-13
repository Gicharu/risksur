<?php
	$this->pageTitle = Yii::app()->name . ' - Add Attribute';
	echo $this->renderPartial('_form', array(
		'model' => $model
	));
?>
