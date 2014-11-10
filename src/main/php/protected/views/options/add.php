<?php
$this->pageTitle = Yii::app()->name . ' - Add Option';
?>
<div class="pageHeader">Add Option</div>

<?php echo $this->renderPartial('_form', array(
		'model' => $model,
		'surformdetailsArray' => $surformdetailsArray
	)); ?>
