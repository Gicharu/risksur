<?php
$this->pageTitle = Yii::app()->name . ' - Edit Option';
echo $this->renderPartial('_form', array(
		'model' => $model,
		'dataArray' => $dataArray,
		'surformdetailsArray' => $surformdetailsArray
	)); ?>