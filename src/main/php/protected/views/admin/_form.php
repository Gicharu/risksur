
<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'user-form',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
)); ?>

	<div class="requiredNote">Required  *</div>

<?php echo $form->errorSummary(array(
	$model
), Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']); ?>
	<div class="row">
	<?php if ($this->page == 'add') { ?>
		<?php echo $form->labelEx($model, 'username'); ?>
		<?php echo $form->textField($model, 'username'); ?>
		<?php echo $form->error($model, 'username'); ?>
	<?php
} else { ?>
		<?php echo $form->hiddenField($model, 'username'); ?>
		<?php echo " User Name: " . $model->username . ""; ?>
		<?php
} ?>
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model, 'fullname'); ?>
		<?php echo $form->textField($model, 'fullname'); ?>
		<?php echo $form->error($model, 'fullname'); ?>
	</div>	
	<div class="row">
	<?php if ($this->page == 'add') { ?>
		<?php echo $form->labelEx($model, 'password'); ?>
<?php
	$this->widget('ext.EStrongPassword.EStrongPassword', array(
		'form' => $form,
		'model' => $model,
		'attribute' => 'password'
	));
	echo $form->passwordField($model, 'password'); ?>
		<?php echo $form->error($model, 'password'); ?>
		<?php
} else { ?>
		<?php echo $form->hiddenField($model, 'password'); ?>
		<?php
} ?>
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model, 'organization'); ?>
<?php echo $form->dropDownList($model, 'organization', $listData['orgs'], array(
	'ajax' => array(
		'type' => 'POST',
		'url' => CController::createUrl('admin/nodes'),
		'update' => '#from_UserForm_ldapDescription',
	),
	'onchange' => "$('#UserForm_ldapDescription option').remove()",
)); ?>
		<?php echo $form->error($model, 'organization'); ?>
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model, 'email'); ?>
		<?php echo $form->textField($model, 'email'); ?>
		<?php echo $form->error($model, 'email'); ?>
	</div>	
	<div class="row panel ui-panel ui-widget ui-widget-content ui-corner-all">
		<?php echo $form->labelEx($model, 'userType'); ?> 

		<?php if ($this->page == 'add') { ?>
		<?php echo $form->listbox($model, 'userType', $listData['groups'], array(
		'multiple' => 'multiple',
		'class' => 'pickList'
	)); ?>
		<?php
} else { ?>

		<?php echo $form->listbox($model, 'userType', $listData['groups'], array(
		'multiple' => 'multiple',
		'class' => 'pickList',
		'options' => $listData['userBelongGroups']
	)); ?>	
		<?php
} ?>
		<?php echo $form->error($model, 'userType'); ?>
	</div>	
	<div class="row panel ui-panel ui-widget ui-widget-content ui-corner-all">
		<?php echo $form->labelEx($model, "ldapDescription"); ?>
		<?php if ($this->page == 'add') { ?>
<?php //echo $form->listbox($model,"ldapDescription", 
//array('item1'=>'item 1','item2'=>'item 2','item3'=>'item 3'),array('multiple'=>'multiple','class'=>'pickList'));
?>
		<?php echo $form->listbox($model, "ldapDescription", array(), array(
		'multiple' => 'multiple',
		'class' => 'pickList'
	)); ?>
		<?php
} else { ?>
		<?php echo $form->listbox($model, "ldapDescription", $listData['nodeAvailable'], array(
		'multiple' => 'multiple',
		'class' => 'pickList',
		'options' => $listData['nodeAssigned']
	)); ?>
		<?php
} ?>
<?php echo $form->error($model, "ldapDescription");
//print_r($listData['nodeAssigned']);
//die();

?>

	</div>

	<div class="row buttons">
		<?php echo CHtml::htmlButton('Save', array(
	'id' => 'save',
	'onclick' => ';',
	'type' => 'submit'
)); ?>
		<!--<button id="Save" name="Save" onclick=";" type="submit">Save</button> -->
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
