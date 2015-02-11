<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'users-form',
	'enableClientValidation' => true,
)); ?>
	<?php
		/*REMOVE THE TEXT role_ FROM THE ROLES.*/
		$roleArray = array();
		foreach ($model->getRoles() as $key => $value) {
			$roleArray[$key] = str_replace("ROLE_", "", $value);
		}
	?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary(array(
	$model
), Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']); ?>
	<div class="row">
		<?php echo $form->labelEx($model, 'userName'); ?>
		<?php
		if ($model->scenario == 'update') {
			echo $form->textField($model, 'userName' , array('size' => 40, 'maxlength' => 40, 'readOnly' => "readonly"));
		 } else {
			echo $form->textField($model, 'userName' , array('size' => 40, 'maxlength' => 40));
		 }?>
		<?php echo $form->error($model, 'userName'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'email'); ?>
		<?php
		if ($model->scenario == 'update') {
			echo $form->textField($model, 'email', array('size' => 40, 'maxlength' => 40, 'readOnly' => "readonly"));
		 } else {
			echo $form->textField($model, 'email', array('size' => 40, 'maxlength' => 40));
		 }?>
		<?php echo $form->error($model, 'email'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'roles'); ?>
		<?php echo $form->radioButtonList($model, 'roles', $roleArray,
			array(
				'class' => 'checkBoxes',
				'separator' => ' ',
				'template' => '<div>{input}&nbsp; {label}</div>',
				'labelOptions' => array('style' => 'display:inline')
			));
		?>
		<?php echo $form->error($model, 'roles'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
<?php $this->endWidget(); ?>
</div>
