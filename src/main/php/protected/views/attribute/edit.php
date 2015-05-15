<?php
	$this->pageTitle = Yii::app()->name . ' - Edit Attribute';
	echo "<h3>Edit Performance Attribute</h3>";
	echo $this->renderPartial('_form', array(
		'model' => $model
	));
?>
