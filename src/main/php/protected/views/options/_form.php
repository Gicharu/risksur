<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'enableClientValidation' => true,
)); ?>
<?php echo $form->errorSummary(array(
	$model
), Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']); ?>
	<?php
	if (isset($dataArray['formType']) && $dataArray['formType'] == "Edit") {
		$buttonText = "Update Option";
		$dataArray['elementName'];
	} else {
		$buttonText = "Save Option";
	}?>
	<div class="row">
		<?php echo $form->labelEx($model, 'elementId'); ?>
		<?php echo $form->dropDownList($model, 'elementId', $surformdetailsArray, array(
			'id' => 'elementId',
			'selected' => isset($dataArray['elementName']) ? $dataArray['elementName'] : "",
			)); ?>
		<?php echo $form->error($model, 'elementId'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'label'); ?>
		<?php echo $form->textField($model, 'label'); ?>
		<?php echo $form->error($model, 'label'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::htmlButton($buttonText, array(
	'id' => 'save',
	'type' => 'submit'
)); ?>
	</div>
<?php $this->endWidget(); ?>
</div>
