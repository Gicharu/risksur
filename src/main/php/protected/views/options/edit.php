<?php
$this->pageTitle = Yii::app()->name . ' - Edit Option';
echo "<h3>Edit Option</h3>";
echo $this->renderPartial('_form', array(
		'model' => $model,
		'dataArray' => $dataArray,
		'surformdetailsArray' => $surformdetailsArray
	)); ?>