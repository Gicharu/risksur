<?php
$this->pageTitle = Yii::app()->name . ' - Add Option';
echo "<h3>Add Option</h3>";
echo $this->renderPartial('_form', array(
		'model' => $model,
		'surformdetailsArray' => $surformdetailsArray
	)); ?>
