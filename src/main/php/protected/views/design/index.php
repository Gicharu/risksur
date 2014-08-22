
	<script type="text/javascript">
$(function(){
	$("#newDesignDialog").dialog({
		autoOpen: false,
		height: 450,
		width: 450,
		show: "slide",
		title: "<?php echo Yii::t('translation', 'Create New Surveillance Design')?>",
		hide: "explode",
		buttons: { "<?php echo Yii::t('translation', 'Close')?>": function() {
				$(this).dialog("close");
			}
		}
	});
});
	</script>

<div id="newDesignDialog" style="display:none" >
	<div id="manageDashProcess" class="loading" style="display:none;">
			<p><?php echo Yii::t("translation", "Processing...")?></p>
	</div>
	<div id="msgManageWidgets"></div>
<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'goadDesignForm',
	//'enableAjaxValidation' => true,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		// make sure that script is not executed if errors on the form
		'afterValidate' => "js:function(form, data, hasError) {
			if(hasError) {
				return false;
				} else {
					//'#configSubmit' - id for the submit button
					processConfig('#objectDetailsWidget-form_es_');
					return true;
				}
			}"
		//'afterValidate'=>'js:processConfig(this)'
		
	)
	//'htmlOptions' => array(
		//// disable default submit method
		//'onsubmit' => "return false;",
		//// add class on the form for the scripts it must be 'configForm'
		//'class' => 'configForm',
	//)
));
?>
<?php 
	echo $form->errorSummary(array(
	$model), Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']); 
?>

	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array(
			'id' => 'name'
		)); ?>
		<?php echo $form->error($model, 'name', array('inputID' => "name")); ?>
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model, 'description'); ?>
		<?php echo $form->textArea($model, 'description', array(
			'id' => 'description',
			'rows' => 2
		)); ?>
		<?php echo $form->error($model, 'description', array('inputID' => "description")); ?>
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model, 'goal'); ?>
		<?php echo $form->dropDownList($model, 'goal', $dataArray['goalDropDown'], array(
			'id' => 'goal',
			//'empty' => "Choose one",
			'ajax' => array(
				'type'=>'POST', //request type
				'url'=>CController::createUrl('design/fetchComponents'), //url to call.
				'update'=>'#component', //selector to update
			)
			)); ?>
		<?php echo $form->error($model, 'goal', array('inputID' => "goal")); ?>
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
	<?php echo CHtml::htmlButton(Yii::t("translation", "Create"), array(
			'id' => 'load',
			//'onclick' => "openAddWidget();",
			'type' => 'button'
	)); ?>
	</div>
<?php
	$this->endWidget(); 
?>
</div>
</div>
