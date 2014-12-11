<?php
$rowFields = <<<END
<tr id="newRow">
	<td><input type="text" name="txtComponentName[]"  size="10" class="codeBox"/></td>
	<td><input type="text" name="txtInitiator[]" size="10" class="codeBox"/></td>
	<td><img src="../../images/trash.gif" onclick="$(this).parent().parent().remove();" class="trashIcon" alt="Delete Row" title="Delete Row"/></td>	
</tr>
END;
	//encode the elemets of the row to json
	$rowFieldsJson = json_encode($rowFields);
	$showRows = 3;
?>
<form id="components">
<div id="row" class="tableFrame" width="100%">
	<table id="multipleComponents" width="100%" border="0" cellspacing="0" cellpadding="0">
	<thead>
		
			<th title = "Name">Component Name</th>
			<th title = "Initiator">Initiator</th>
		
	</thead>
	<tbody> 
	<?php for ($i=0;$i<$showRows;$i++) { ?>
		<tr id="<?php echo $i; ?>">
			<td>
				<input type="text" name="txtComponentName[]" <?php if (isset($_GET['txtComponentName'][$i])) { echo 'value="' . $_GET['txtComponentName'][$i] . '"';} ?>/>
			</td>
			<td>
				<input type="text" name="txtInitiator[]" <?php if (isset($_GET['txtInitiator'][$i])) { echo 'value="' . $_GET['txtInitiator'][$i] . '"'; } ?> />
			</td>
			<td>
				<img src="../../images/trash.gif" onclick="$(this).parent().parent().remove();" class="trashIcon" alt="Delete Row" title="Delete Row" />
			</td>
		</tr>
	<?php
	} ?>
		<script type="text/javascript">
			// add the json encoded elements to a javascript variable
			var jsonRow = JSON.stringify(<?php echo $rowFieldsJson ?>);
		</script>

		<tr id="buttons">
			<td colspan="5">
				<input type="button" onclick="$(JSON.parse(jsonRow)).insertBefore('#buttons');" value="New Row" class="buttons" />
			</td>
		</tr>
	</tbody>
</table>
</div>
<div class="row">
<?php echo CHtml::Button(Yii::t("translation", "Create Components"), array(
		'id' => 'createComponents',
		'submit' => array('design/addMultipleComponents'),
		'type' => 'submit'
)); ?>
</div>
</form>