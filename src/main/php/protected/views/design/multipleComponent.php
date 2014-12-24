<?php

	$showRows = $multipleRowsToShow;
?>
<form id="components">
<div id="row" class="tableFrame" width="100%">
	<table id="multipleComponents" width="100%" border="0" cellspacing="0" cellpadding="0">
	<thead>
		
			<th title = "Name">Component Name <span style="color:red">*</span></th>
			<th title = "Initiator">Initiator <span style="color:red">*</span></th>
		
	</thead>
	<tbody> 
	<?php for ($i=0;$i<$showRows;$i++) {
$lineNo = $showRows + 1;
$rowFields = <<<END
<tr id="newRow">
	<td><input type="text" id="txtComponentName$lineNo" name="txtComponentName[]"  size="10" class="codeBox"/></td>
	<td><input type="text" id="txtInitiator$lineNo" name="txtInitiator" size="10" class="codeBox"/></td>
	<td><img src="../../images/trash.gif" onclick="$(this).parent().parent().remove();" class="trashIcon" alt="Delete Row" title="Delete Row"/></td>	
</tr>
END;

		//encode the elements of the row to json
		$rowFieldsJson = json_encode($rowFields);?>
			<script>
			$(document).ready(function(){
				$("#cmdCopy").click(function() {
					for (var j=0; j < <?php echo $showRows;?>; j++) {
						var txtComponentName = document.getElementById('txtComponentName0');
						var txtComponentNameIterate = document.getElementById('txtComponentName'+j);
						txtComponentNameIterate.value = txtComponentName.value;
						var txtInitiator = document.getElementById('txtInitiator0');
						var txtInitiatorIterate = document.getElementById('txtInitiator'+j);
						txtInitiatorIterate.value = txtInitiator.value;
					}
				});
			});
			</script>
		<tr id="<?php echo $i; ?>">
			<td>
				<input type="text" id="txtComponentName<?php echo $i;?>" name="txtComponentName[]" <?php if (isset($_GET['txtComponentName'][$i])) { echo 'value="' . $_GET['txtComponentName'][$i] . '"';} ?>/>
			</td>
			<td>
				<input type="text" id="txtInitiator<?php echo $i;?>" name="txtInitiator[]" <?php if (isset($_GET['txtInitiator'][$i])) { echo 'value="' . $_GET['txtInitiator'][$i] . '"'; } ?> />
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
				<input type="button" id="cmdCopy" onclick="" value="Copy Data" class="buttons" />
			</td>
		</tr>
		<tr>
			<td>
				Sample Size <input type="text" id="txtSampleSize" name="txtSampleSize" <?php if (isset($_GET['txtSampleSize'])) { echo 'value="' . $_GET['txtSampleSize'] . '"';} ?>/>
			</td>
		</tr>
		<tr>
			<td>
				Threat <input type="text" id="txtThreat" name="txtThreat" <?php if (isset($_GET['txtThreat'])) { echo 'value="' . $_GET['txtThreat'] . '"';} ?>/>
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