<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'newDesignForm',
	'enableAjaxValidation' => true,
	'enableClientValidation' => true,
	'htmlOptions' => array(
	)
));
?>
<?php 
	echo $form->errorSummary(array(
	$model), Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']); 
?>

	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array(
			'id' => 'name',
		)); ?>
		<?php echo $form->error($model, 'name', array('inputID' => "name")); ?>

		<?php echo $form->hiddenField($model, 'frameworkId', array(
			'id' => 'frameworkId',
		)); ?>
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model, 'description'); ?>
		<?php echo $form->textArea($model, 'description', array(
			'id' => 'description',
			'rows' => 2,
		)); ?>
		<?php echo $form->error($model, 'description', array('inputID' => "description")); ?>
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model, 'goalId'); ?>
		<?php echo $form->dropDownList($model, 'goalId', $dataArray['goalDropDown'], array(
			'id' => 'goalId',
			//'empty' => "Choose one",
			'ajax' => array(
				'type'=>'POST', //request type
				'url'=>CController::createUrl('design/fetchComponents'), //url to call.
				'update'=>'#component', //selector to update
			)
			)); ?>
		<?php echo $form->error($model, 'goalId', array('inputID' => "goalId")); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'component'); ?>
		<?php echo $form->dropDownList($model, 'component', array(), array(
			'id' => 'component',
			//'empty' => "Choose one"
			)); ?>
		<?php echo $form->error($model, 'component', array('inputID' => "component")); ?>
	</div>
	<div class="row">
	<?php echo CHtml::Button(Yii::t("translation", $dataArray['formType']), array(
			'id' => 'load',
			//'onclick' => "addNewDesign();",
			'type' => 'submit'
	)); ?>
	</div>
<?php
	$this->endWidget(); 
?>
</div>
