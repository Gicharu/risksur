
<script type="text/javascript">
$(function(){
	$("<?php echo '#designData'; ?>").dataTable({
		"bAutoWidth" : false,
		"bJQueryUI": true,
		"bFilter": false,
		"bSort": false,
		"bInfo": false,
		"bLengthChange": false
	});
});
</script>
<div id="designDetails" width="100%">
	
	<table id="designData" class="tableStyle"  
		width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
		<tr>
			<th title = "Name">Name</th>
			<th title = "Descripton">Descripton</th>
		</tr>
		</thead>
		<tbody>
<?php
if (!empty($dataArray['selectedDesign'])) {
	foreach ($dataArray['selectedDesign'] as $values) {
?>
<tr>
	<td>Name</td>
	<td><?php echo $values->name; ?></td>
</tr>
<tr>
	<td>Description</td>
	<td><?php echo $values->description; ?></td>
</tr>
<?php
	}
}
?>
		
		</tbody>
	</table>
</div>
