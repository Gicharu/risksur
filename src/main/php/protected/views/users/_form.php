<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	'enableClientValidation' => true,
)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'userName'); ?>
		<?php
		if ($model->scenario == 'update') {
			echo $form->textField($model,'userName',array('size'=>40,'maxlength'=>40, 'readOnly'=>"readonly")); 
		 } else {
		 	echo $form->textField($model,'userName',array('size'=>40,'maxlength'=>40)); 
		 }
		?>
		<?php echo $form->error($model,'userName'); ?>
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
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php
		if ($model->scenario == 'update') {
			echo $form->textField($model,'email',array('size'=>40,'maxlength'=>40, 'readOnly'=>"readonly")); 
		 } else {
		 	echo $form->textField($model,'email',array('size'=>40,'maxlength'=>40)); 
		 }
		?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
<?php $this->endWidget(); ?>
</div>
