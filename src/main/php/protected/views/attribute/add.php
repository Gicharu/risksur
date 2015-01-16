<?php
	$this->pageTitle = Yii::app()->name . ' - Add Attribute';
	echo "<h3>Add Performance Attribute</h3>";
	echo $this->renderPartial('_form', array(
		'model' => $model
	));
?>
