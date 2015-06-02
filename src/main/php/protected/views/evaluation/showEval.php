
<script type="text/javascript">
$(function(){
	$("#evalTable").dataTable({
		"bAutoWidth" : false,
		"bJQueryUI": true,
		"bFilter": false,
		"bSort": false,
		"bInfo": false,
		"bLengthChange": false
	});
});
</script>
<div id="componentDetails" width="100%">
	
	<table id="evalTable" class="tableStyle"  
		width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
		<tr>
			<th title = "Name">Name</th>
			<th title = "Descripton">Descripton</th>
		</tr>
		</thead>
		<tbody>
<?php
if (!empty($dataArray['selectedEval'])) {
	foreach ($dataArray['selectedEval'] as  $key => $values) {
?>
<tr>
	<td><?php echo $key; ?></td>
	<td><?php echo $values; ?></td>
</tr>
<?php
	}
}
?>
		
		</tbody>
	</table>
</div>
