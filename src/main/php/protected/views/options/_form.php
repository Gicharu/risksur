<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'user-form',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
)); ?>
<?php echo $form->errorSummary(array(
	$model
), Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']); ?>
	<div class="row">
		<?php echo $form->labelEx($model, 'elementId'); ?>
		<?php echo $form->dropDownList($model, 'elementId', $surformdetailsArray, array(
			'id' => 'surformId',
			)); ?>
		<?php echo $form->error($model, 'elementId'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'label'); ?>
		<?php echo $form->textField($model, 'label'); ?>
		<?php echo $form->error($model, 'label'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::htmlButton('Save Option', array(
	'id' => 'save',
	'type' => 'submit'
)); ?>
	</div>
<?php $this->endWidget(); ?>
</div>
