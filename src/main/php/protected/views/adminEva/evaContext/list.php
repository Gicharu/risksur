<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/16/15
 * Time: 11:25 AM
 * @var $this AdminEvaController
 */
?>
<script type="text/javascript">
	$(function() {
		$("#evaContext").dataTable({
			"sDom": '<"H"rlf>t<"F"ip>',
			"sAjaxSource": "<?= $this->createUrl('adminEva/listEvaContext/ajax/1'); ?>",
			"aoColumns": [
				{"mDataProp": "label" },
				{"mDataProp": "inputType","sWidth": '10%' },
				{"mDataProp": "elementMetaData" },
				{"mDataProp": "required", "fnCreatedCell": function (cell, cellData, rowData, row, col) {
						$(cell).html('Yes');
						if ( parseInt(cellData) < 1 ) {
							$(cell).html('No');
						}
					}, "sWidth": '8%'
				},
				{
					"mDataProp": null,
					"bSortable": false,
					"sWidth": '5%',
					sClass: "editMethod",
					sDefaultContent: '<button title="Edit" class="bedit">Edit</button>'
				},
				{
					"mData": null,
					"bSortable": false,
					"sWidth": '5%',
					sClass: "delMethod",
					sDefaultContent: '<button title="Delete" class="bdelete">Delete</button>'
				}
			],
			// update the buttons stying after the table data is loaded
			"fnDrawCallback": function() {
				$('button.bdelete').button({
					icons: {primary: "ui-icon-trash"}, text: false});
				$('button.bedit').button({
					icons: {primary: "ui-icon-pencil"}, text: false});
			},
			"bJQueryUI": true,
			//"sPaginationType": "customListbox",
			"sPaginationType": "buttons_input",
			"iDisplayLength": 10,
			"aLengthMenu": [[10, 25, 50, 75, 100], [10, 25, 50, 75, 100]],
			"bFilter": true,
			"bSort": true,
			"bInfo": true,
			"bLengthChange": true
		})
			.on('click', '.editMethod .bedit', {
				operation: 'edit',
				link: '<?= $this->createUrl("updateEvaContext"); ?>',
				table: '#evaContext',
				rowIdentifier: 'evalElementsId'
			}, requestHandler)
			.on('click', '.bdelete', {
				operation: 'delete',
				link: '<?= $this->createUrl("deleteEvaContext"); ?>',
				refreshLink: '<?= $this->createUrl("listEvaContext"); ?>',
				table: '#evaContext',
				rowIdentifier: 'evalElementsId'
			}, requestHandler);

	});
</script>
<div id="listEvaContext">

	<table id="evaContext" width="100%" class="display">
		<thead>
		<tr>
			<th title = "Field name">Field Name</th>
			<th title = "Type of the field">Field Type</th>
			<th title = "Brief explanation of what the field captures">Field MetaData</th>
			<th title = "Is the field required?">Required</th>
			<th title = "Edit"></th>
			<th title = "Delete"></th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>