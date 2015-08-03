<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 5/12/15
 * Time: 10:33 AM
 */
$this->menu = [['label' => 'Add Economic Evaluation Method', 'url' => ['admineva/addEvaMethod']],];
?>

<script type="text/javascript">


	$(function() {
		$("#evaMethods").dataTable({
			"sDom": '<"H"rlf>t<"F"ip>',
			"sAjaxSource": "<?= $this->createUrl('adminEva/listEvaMethods/ajax/1'); ?>",
			"aoColumns": [
				{"mDataProp": "buttonName" },
				{"mDataProp": "link" },
				{"mDataProp": "description" },
				{"mDataProp": null, "bSortable": false, sClass: "editMethod", sDefaultContent: '<button title="Edit" class="bedit">Edit</button>' },
				{"mData": null, "bSortable": false, sClass: "delMethod", sDefaultContent: '<button title="Delete" class="bdelete">Delete</button>' }
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
			.on('click', '.bedit', {
				operation: 'edit',
				link: '<?= $this->createUrl("updateEvaMethod"); ?>',
				table: '#evaMethods',
				rowIdentifier: 'id'
			}, requestHandler)
			.on('click', '.bdelete', {
				operation: 'delete',
				link: '<?= $this->createUrl("deleteEvaMethod"); ?>',
				table: '#evaMethods',
				rowIdentifier: 'id'
			}, requestHandler);

	});
</script>
<div id="listEvaMethods">

	<table id="evaMethods" width="100%" class="display">
		<thead>
		<tr>
			<th title = "Label">Button Label</th>
			<th title = "Link">Method link</th>
			<th title = "Descripton">Descripton</th>
			<th title = "Edit"></th>
			<th title = "Delete"></th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>