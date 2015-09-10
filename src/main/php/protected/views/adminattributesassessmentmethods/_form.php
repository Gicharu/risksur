<?php
/* @var $this AdminAttributesAssessmentMethodsController */
/* @var $model EvaAttributesAssessmentMethods */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'eva-attributes-assessment-methods-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
	'enableAjaxValidation' => false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model, Yii::app()->params['headerErrorSummary'],
		Yii::app()->params['footerErrorSummary']); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'evaAttribute'); ?>
		<?php echo $form->dropDownList($model,'evaAttribute',
			AdminAttributesAssessmentMethodsController::getEvaAttributes(), ['class' => 'chozen']); ?>
		<?php echo $form->error($model,'evaAttribute'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dataRequired'); ?>
		<?php echo $form->textArea($model,'dataRequired',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'dataRequired'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'expertiseRequired'); ?>
		<?php echo $form->textArea($model,'expertiseRequired',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'expertiseRequired'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reference'); ?>
		<?php echo $form->textArea($model,'reference',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'reference'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->