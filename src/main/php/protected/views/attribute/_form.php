<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'newAttribute',
	'enableClientValidation' => true,
	'enableAjaxValidation' => true,
));
echo $form->errorSummary(array($model), Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']);
	if (isset($dataArray['formType']) && $dataArray['formType'] == "Edit") {
		$this->menu = array(array('label' => 'View Attributes', 'url' => array('attribute/index')), array('label' => 'Add Option', 'url' => array('options/addOption')));
		$buttonText = "Edit Attribute";
	} else {
		$this->menu = array(array('label' => 'View Attributes', 'url' => array('attribute/index')));
		$buttonText = "Save Attribute";
	}
?>
	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name'); ?>
		<?php echo $form->error($model, 'name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'description'); ?>
		<?php echo $form->textArea($model, 'description'); ?>
		<?php echo $form->error($model, 'description'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::htmlButton($buttonText, array(
				'id' => 'save',
				'type' => 'submit'
			));
		?>
	</div>
<?php $this->endWidget(); ?>
</div>