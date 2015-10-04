<?php
/**
 * @var $this OptionsController
 * @var $dataArray array
 */
$this->menu = [
	['label' => 'Add option', 'url' => ['options/addOption/id/' . $id]],
	['label' => 'Manage options home', 'url' => ['options/home']]
];
?>
<script type="text/javascript">
	$(function(){
		$("#bd").attr('style', '');
		$("#optionsList").dataTable({
			"sDom": '<"H"rlf>t<"F"ip>',
			"bProcessing": true,
			"aaData": <?= $dataArray['optionsList']; ?>,
			"aoColumns": [
				{"mDataProp": '<?= $dataArray["firstColumn"]; ?>.label' },
				{"mDataProp": "label" },
				{"mDataProp": null, "bSortable": false, "sDefaultContent": '<button class="bedit">Edit</button>'},
				{"mData": null, "bSortable": false, "sDefaultContent": '<button class="bdelete">Delete</button>'}
			],
			// update the buttons stying after the table data is loaded
			"fnDrawCallback": function() {
				$('button.bdelete').button({
					icons: {primary: "ui-icon-trash"}, text: false});
				$('button.bedit').button({
					icons: {primary: "ui-icon-pencil"}, text: false
				});
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
			.rowGrouping()
			.on('click', '.bedit', {
				operation: 'edit',
				link: '<?= $this->createUrl("options/editOption/type/" . $dataArray["firstColumn"]); ?>',
				table: '#optionsList',
				rowIdentifier: 'optionId'
			}, requestHandler)
			.on('click', '.bdelete', {
				operation: 'delete',
				link: '<?= $this->createUrl("deleteOption"); ?>',
				refreshLink: '<?= $this->createUrl("index", ["id" => $_GET['id'], 'ajax' => true]); ?>',
				table: '#optionsList',
				rowIdentifier: 'optionId'
			}, requestHandler);
	});

</script>
<div id="listOptions">
	
	<table id="optionsList" width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
		<tr>
			<th title = "Field Name">Field Name</th>
			<th title = "Option Name">Option Name</th>
			<th title = "Edit">Edit</th>
			<th title = "Delete">Delete</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>