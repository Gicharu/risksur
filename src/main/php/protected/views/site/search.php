<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'search-form',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
)); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<th><?php echo $form->labelEx($model, 'tradeUnitTypes'); ?> 
</th>
<th><?php echo $form->labelEx($model, 'tradeUnitProperties'); ?></th>
<th>Filter</th>
</tr>
<tr>
<td>

<?php echo $form->listbox($model, 'tradeUnitTypes', $model->tradeUnitTypes, array(
	'multiple' => 'multiple',
	'class' => 'pickList'
)); ?>

	<!-- <select multiple="multiple" class="picklist"> 
<?php
//print_r($model); die();
//foreach ($model->tradeUnitTypes as $tradeUnit) {

?>
	<option value="<?php // echo $tradeUnit;
?>"><?php // echo $tradeUnit;
?></option>
<?php
//;//print_r($tradeUnitsnProperties); die();
//}

?>

	<option value="exporterincomingcoffeeshipment">exporterincomingcoffeeshipment</option>
	<option value="exporteroutgoingcoffeeshipment" disabled="disabled">exporteroutgoingcoffeeshipment</option>
	<option value="exporterreceivedlots">exporterreceivedlots</option>
	<option value="exportershipmentlots">exportershipmentlots</option>
	<option value="incomingcoffeeshipment">incomingcoffeeshipment</option>
	<option value="outgoingcoffeeshipment" disabled="disabled">outgoingcoffeeshipment</option>
	<option value="receipts">receipts</option>
	<option value="storagewarranty">storagewarranty</option>

</select>--></td>
<td>	
<?php echo $form->listbox($model, 'tradeUnitProperties', $model->tradeUnitProperties, array(
	'multiple' => 'multiple',
	'class' => 'pickList'
)); ?>

<?php
//foreach ($model->tradeUnitProperties as $tradeUnit => $tradeUnitProperties) {
//foreach($tradeUnitProperties as $propertyKey => $propertyVal){

?>
	<!-- <option id="<?php //echo $tradeUnit
	?>" value="<?php //echo $propertyVal;
?>"><?php //echo $propertyVal
?></option>-->
<?php
	//}}

?>	
	<!--
<option value="exporterincomingcoffeeshipment">exporterincomingcoffeeshipment</option>
<option value="exporteroutgoingcoffeeshipment" disabled="disabled">exporteroutgoingcoffeeshipment</option>
<option value="exporterreceivedlots">exporterreceivedlots</option>

</select>-->
</td>
<td><ul><li><label><?php echo $form->labelEx($model, 'id'); ?></label><?php echo $form->textField($model, 'id'); ?></li>
<li><label><?php echo $form->labelEx($model, 'dateFrom'); ?>

<?php echo $form->error($model, 'Form_issue_date'); ?></label><?php
	$this->widget('zii.widgets.jui.CJuiDatePicker', array(
		'attribute' => 'dateFrom',
		'model' => $model,
		'options' => array(
			'mode' => 'focus',
			'dateFormat' => 'd MM, yy',
			'showAnim' => 'slideDown',
		),
		'htmlOptions' => array(
			'size' => 30,
			'class' => 'date'
		),
	));
?>
</li>
<li><label>To date</label><input name="Id" class="dateinput" type="text"/></li>
</ul></td>
</tr>
</table>
</div>
<div class="panelSearch">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<th>Property</th>
<th>Data type</th>
<th>Value/From value</th>
<th>To value</th>
<th>Exact value</th>
<th>Search in log</th>
<th>Not equal</th>
</tr>
<tr>
<td><input name="" type="text" /></td>
<td><input name="" type="text" /></td>
<td><input name="" type="text" /></td>
<td><input name="" type="text" /></td>
<td><input name="" type="text" /></td>
<td><input name="" type="text" /></td>
<td><input name="" type="text" /></td>
</tr>
</table>
</div>
<?php $this->endWidget(); ?>
</div>
