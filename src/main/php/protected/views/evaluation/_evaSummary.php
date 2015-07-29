<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 6/2/15
 * Time: 11:34 AM
 */
?>
<script type="text/javascript">
	$(document).ready(function() {
		var evaSummary = $("#evaSummary").dataTable({
			"bProcessing": true,
			"aoColumns": [
				{ "sClass": 'bold' },
				null
			],
//			bDestroy: true,
			bPaginate: false,
			"bJQueryUI": true,
//			"sPaginationType": "buttons_input",
			"bLengthChange": false,
			"bFilter": false,
			"oLanguage": {
				"sZeroRecords": "No evaluation summary available"
			}
		});
		$.ajax({
			url: "<?= $this->createUrl('evaluation/getEvaSummary'); ?>",
			dataType: 'json',
			success: function(data) {
				var rowData = [];
				var propNames = Object.keys(data);
				for(var name in propNames) {
					rowData[name] = [propNames[name], data[propNames[name]]];
				}
				evaSummary.fnAddData(rowData);
			}

		});
	});
</script>
<table id="evaSummary" cellspacing="0" width="100%">
	<thead>
	<tr>
		<th></th>
		<th></th>
	</tr>
	</thead>
	<tbody></tbody>
</table>
