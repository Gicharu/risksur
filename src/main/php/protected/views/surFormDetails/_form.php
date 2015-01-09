<?php
/* @var $this SurFormDetailsController */
/* @var $model SurFormDetails */
/* @var $form CActiveForm */
?>
<script type="text/javascript">
	$(function() {
		$("#bd").attr('style', '');
		$("#cancelForm").on("click", function() {
			window.location = '<?php echo $this->createUrl("surFormDetails/index"); ?>';
		});
		$(".inputTypeSelect").on('change', function() {
			if(this.value == 'select') {
				$("#optsContainer").show();
				optsTable.fnReloadAjax('<?php echo $this->createUrl("surFormDetails/getInputTypeOpts", array("subFormId" => $model->subFormId)); ?>');
			} else {
				$("#optsContainer").hide();
			}
		});
		var optsTable = $("#optsTable").dataTable({
			bJQueryUI: true,
			"sDom": '<"H"rlf>t<"F"ip>',
			"sPaginationType": "buttons_input",
			"iDisplayLength": 5,
			"bProcessing": true,
			"aoColumns": [
				{"mData": "label", "sTitle": "Label"},
				{"mData": "val", "sTitle": "Value"}
			],
			"oLanguage": {
				"sEmptyTable": "There are no options for this form element"
			},
			"aLengthMenu": [[5, 10, 25, 50, 75], [5, 10, 25, 50, 75]]

		});
		if($(".inputTypeSelect").val() == 'select') {
			optsTable.fnReloadAjax('<?php echo $this->createUrl("surFormDetails/getInputTypeOpts", array("subFormId" => $model->subFormId)); ?>');
			$("#optsContainer").show();
			optsTable.fnDraw();
		}
		$("#optsTable_filter label").attr('style', '');
		$("#optsTable_filter img").attr({
			style: 'position:absolute;right:0.5em;top:0.5em'
		});
	});
</script>
<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'sur-form-details-form',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary($model, Yii::app()->params['headerErrorSummary'],
		Yii::app()->params['footerErrorSummary']); ?>
		<!-- status is active by default -->
	<!-- <div class="row">
		<?php //echo $form->labelEx($model, 'formId'); ?>
		<?php //echo $form->dropDownList($model, 'formId', CHtml::listData(SurForm::model()->findAll(), 'formId', 'formName')); ?>
		<?php //echo $form->error($model, 'formId'); ?>
	</div>
 -->
	<div class="row">
		<?php echo $form->labelEx($model, 'inputName'); ?>
		<?php echo $form->textField($model, 'inputName',array('size' => 50,'maxlength' => 50)); ?>
		<?php echo $form->error($model, 'inputName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'label'); ?>
		<?php echo $form->textField($model, 'label',array('size' => 50,'maxlength' => 50)); ?>
		<?php echo $form->error($model,'label'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inputType'); ?>
		<?php echo $form->dropDownList($model,'inputType',array('text' => 'Text', 'select' => 'Drop down', 'int' => 'Integer'),
			array('class' => 'inputTypeSelect')); ?>
		<?php echo $form->error($model,'inputType'); ?>
		<div id="optsContainer" style="width: 40%; display: none">
			<table id="optsTable" cellpadding="0" cellspacing="0" border="0" class="display">
<!--                <thead><tr><th>Label</th><th>Value</th></tr></thead>-->
<!--                <tbody></tbody>-->
			</table>
		</div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'required'); ?>
		<?php echo $form->dropDownList($model, 'required', array('No', 'Yes')); ?>
		<?php echo $form->error($model, 'required'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'showOnComponentList'); ?>
		<?php echo $form->dropDownList($model, 'showOnComponentList', array('No', 'Yes')); ?>
		<?php echo $form->error($model, 'showOnComponentList'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'showOnMultiForm'); ?>
		<?php echo $form->dropDownList($model, 'showOnMultiForm', array('No', 'Yes')); ?>
		<?php echo $form->error($model, 'showOnMultiForm'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'moreInfo'); ?>
		<?php echo $form->textArea($model, 'moreInfo',array('size' => 50,'maxlength' => 50)); ?>
		<?php echo $form->error($model, 'moreInfo'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'url'); ?>
		<?php echo $form->textField($model, 'url'); ?>
		<?php echo $form->error($model, 'url'); ?>
	</div

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		<?php //echo CHtml::htmlButton("Cancel", array('id' => 'cancelForm')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
