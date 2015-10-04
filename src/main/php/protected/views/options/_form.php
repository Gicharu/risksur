<?php
/**
 * @var $form CActiveForm
 * @var $dropDownAttribute string
 * @var $model CActiveRecord
 */
?>
<script type="text/javascript">
	$(function() {
		$("#bd").attr('style', '');
	});
</script>
<div class="form">
<?php $form = $this->beginWidget('CActiveForm', [
	'enableClientValidation' => true,
	'clientOptions' => [
		'validateOnSubmit' => true
	]
]); ?>
<?php echo $form->errorSummary([
	$model
], Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']); ?>
	<?php
	$this->menu = [['label' => 'View options', 'url' => ['options/index']]];
	$this->menu = [['label' => 'Manage options home', 'url' => ['options/home']]];

	if (isset($dataArray['formType']) && $dataArray['formType'] == "Edit") {
		$this->menu[] = ['label' => 'Add option', 'url' => ['options/addOption']];
	}

	?>
	<div class="row">
		<?php echo $form->labelEx($model, $dropDownAttribute); ?>
		<?php echo $form->dropDownList($model, $dropDownAttribute, $formElements, [
			'class' => 'chozen',
			]); ?>
		<?php echo $form->error($model, $dropDownAttribute); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'label'); ?>
		<?php echo $form->textField($model, 'label'); ?>
		<?php echo $form->error($model, 'label'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::htmlButton($model->isNewRecord ? 'Save' : 'Update', [
	'id' => 'save',
	'type' => 'submit'
]); ?>
	</div>
<?php $this->endWidget(); ?>
</div>
