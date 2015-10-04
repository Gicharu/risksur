<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 10/1/15
 * Time: 11:24 AM
 */

$this->menu= [
	['label'=>'Manage surveillance tool', 'url'=> ['home']],
];

?>

<h3>Surveillance tool wizard information</h3>

<script type="text/javascript">


	$(function() {
		$("#surveillanceWiz").dataTable({
			"sDom": '<"H"rlf>t<"F"ip>',
			"sAjaxSource": "<?= $this->createUrl('adminsurveillancesections/index/ajax/1'); ?>",
			"aoColumns": [
				{"mDataProp": "sectionName", "sWidth": '14%' },
				{"mDataProp": "description" },
				//{"mDataProp": "description" },
				{
					"mDataProp": null,
					"bSortable": false,
					sClass: "editMethod",
					sDefaultContent: '<button title="Edit" class="bedit">Edit</button>',
					sWidth: '5%'
				}
				//{"mData": null, "bSortable": false, sClass: "delMethod", sDefaultContent: '<button title="Delete" class="bdelete">Delete</button>' }
			],
			// update the buttons stying after the table data is loaded
			"fnDrawCallback": function() {
//				$('button.bdelete').button({
//					icons: {primary: "ui-icon-trash"}, text: false});
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
				link: '<?= $this->createUrl("update"); ?>',
				table: '#surveillanceWiz',
				rowIdentifier: 'sectionId'
			}, requestHandler);
//			.on('click', '.bdelete', {
//				operation: 'delete',
//				link: '<?//= $this->createUrl("delete"); ?>//',
//				table: '#evaQuestions',
//				rowIdentifier: 'evalQuestionId'
//			}, requestHandler);

	});
</script>
<div id="listSurveillanceWiz">

	<table id="surveillanceWiz" width="100%" class="display">
		<thead>
		<tr>
			<th title = "Section Name">Section Name</th>
			<th title = "Description">Description</th>
			<th title = "Edit"></th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>
