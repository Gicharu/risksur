<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'enableClientValidation' => true,
));
?>
<?php echo $form->errorSummary(array(
	$model
), Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']); ?>
	<div class="row">
		<?php echo $form->labelEx($model, 'userName'); ?>
		<?php echo $form->textField($model, 'userName'); ?>
		<?php echo $form->error($model, 'userName'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'email'); ?>
		<?php echo $form->textField($model, 'email'); ?>
		<?php echo $form->error($model, 'email'); ?>
	</div>
	<div class="row" style="width:17%">
		<?php echo $form->labelEx($model, 'password'); ?>
		<?php
		$this->widget('ext.EStrongPassword.EStrongPassword', array(
			'form' => $form,
			'model' => $model,
			'attribute' => 'password'
		));
		echo $form->passwordField($model, 'password', array('autocomplete' => 'off')); ?>
		<?php echo $form->error($model, 'password'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'confirmPassword'); ?>
		<?php echo $form->passwordField($model, 'confirmPassword', array('autocomplete' => 'off')); ?>
		<?php echo $form->error($model, 'confirmPassword'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::htmlButton('Register', array(
			'id' => 'register',
			'onclick' => CController::createUrl('site/registerUser'),
			'type' => 'submit'
		)); ?>
	</div>
<?php $this->endWidget(); ?>
</div>
