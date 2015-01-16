<?php $this->pageTitle = Yii::app()->name . ' - Add Relation'; ?>
<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'newRelation',
	'enableClientValidation' => true,
	'enableAjaxValidation' => true,
));
echo $form->errorSummary(array($formRelationModel), Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']);
	if (isset($dataArray['formType']) && $dataArray['formType'] == "Edit") {
		$this->menu = array(array('label' => 'View Relations', 'url' => array('attribute/listRelations')));
		$buttonText = "Edit Relation";
	} else {
		$this->menu = array(array('label' => 'View Relations', 'url' => array('attribute/listRelations')), array('label' => 'Add Attribute', 'url' => array('attribute/addAttribute')));
		$buttonText = "Save Relation";
	}
?>
	<div class="row">
		<?php echo $form->labelEx($formRelationModel, 'name'); ?>
		<?php echo $form->dropDownList($formRelationModel, 'attributeId', $attributesArray, array(
			'id' => 'attributeId',
			'selected' => isset($attributesArray['name']) ? $attributesArray['name'] : "",
			)); ?>
		<?php echo $form->error($formRelationModel, 'subFormId'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($formRelationModel, 'inputName'); ?>
		<?php echo $form->dropDownList($formRelationModel, 'subFormId', $surformDetailsArray, array(
			'id' => 'subFormId',
			'selected' => isset($surformDetailsArray['inputName']) ? $surformDetailsArray['inputName'] : "",
			)); ?>
		<?php echo $form->error($formRelationModel, 'subFormId'); ?>
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