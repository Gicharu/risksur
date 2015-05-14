<?php
$this->menu = array(
	array('label' => 'View Attributes', 'url' => array('attribute/index')),
	array('label' => 'View Relations', 'url' => array('attribute/listRelations'))
);
$buttonText = "Save Attribute";
if ($model->scenario == 'update') {
	$this->menu = array(array('label' => 'View Attributes', 'url' => array('attribute/index')), array('label' => 'Add Attribute', 'url' => array('attribute/addAttribute')));
	$buttonText = "Update Attribute";
}
?>
<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'newAttribute',
	'enableClientValidation' => true,
	'enableAjaxValidation' => true,
));
echo $form->errorSummary(array($model), Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']);
?>
	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name'); ?>
		<?php echo $form->error($model, 'name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'attributeType'); ?>
		<?php echo $form->dropDownList($model, 'attributeType',
			CHtml::listData(EvaAttributeTypes::model()->findAll(), 'id', 'name')); ?>
		<?php echo $form->error($model, 'attributeType'); ?>
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