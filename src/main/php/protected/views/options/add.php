<?php
$this->pageTitle = Yii::app()->name . ' - Add Option';
echo $this->renderPartial('_form', array(
		'model' => $model,
		'surformdetailsArray' => $surformdetailsArray
	)); ?>
