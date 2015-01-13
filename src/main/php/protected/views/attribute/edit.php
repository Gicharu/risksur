<?php
	$this->pageTitle = Yii::app()->name . ' - Edit Attribute';
	echo $this->renderPartial('_form', array(
		'model' => $model,
		'dataArray' => $dataArray
	));
?>