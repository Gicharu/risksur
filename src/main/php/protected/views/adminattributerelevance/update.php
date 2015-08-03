<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 8/2/15
 * Time: 11:59 PM
 * @var $this AdminattributerelevanceController
 * @var $model EvaAttributesMatrix
 * @var $dropDownData Array
 * @var $form CActiveForm
 */
?>

<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'eva-attributes-matrix-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'surveillanceObj'); ?>
		<?php echo $form->dropDownList($model,'surveillanceObj', $dropDownData['objectives']); ?>
		<?php echo $form->error($model,'surveillanceObj'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'evaQuestionGroup'); ?>
		<?php echo $form->dropDownList($model,'evaQuestionGroup', $dropDownData['groups']); ?>
		<?php echo $form->error($model,'evaQuestionGroup'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'attributeId'); ?>
		<?php echo $form->dropDownList($model,'attributeId', $dropDownData['attributes']); ?>
		<?php echo $form->error($model,'attributeId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'relevance'); ?>
		<?php echo $form->dropDownList($model,'relevance', ['Do not include', 'Low', 'Medium', 'High']); ?>
		<?php echo $form->error($model,'relevance'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->