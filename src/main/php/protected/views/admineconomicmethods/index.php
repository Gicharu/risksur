<?php
/* @var $this AdmineconomicmethodsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Economic Methods',
);

$this->menu=array(
	array('label'=>'Add Economic Approach', 'url'=>array('create')),
);
?>

<script type="text/javascript">


	$(function () {
		$("#econMethods").dataTable({
			"sDom": '<"H"rlf>t<"F"ip>',
			"sAjaxSource": '<?= $this->createUrl("index", ["ajax" => 1]) ?>',
			"aoColumns": [
				{"mDataProp": "econMethodGroup.buttonName"},
				{"mDataProp": "name"},
				{"mDataProp": "description"},
				{"mDataProp": "reference"},
				{
					"mDataProp": null, "bSortable": false, sClass: "editMethod",
					sDefaultContent: '<button title="Edit" class="bedit">Edit</button>'
				},
				{
					"mData": null, "bSortable": false, sClass: "delMethod",
					sDefaultContent: '<button title="Delete" class="bdelete">Delete</button>'
				}
			],
			// update the buttons stying after the table data is loaded
			"fnDrawCallback": function () {
				$('button.bdelete').button({
					icons: {primary: "ui-icon-trash"}, text: false
				});
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
			.on('click', '.bedit', {
				operation: 'edit',
				link: '<?= $this->createUrl("update"); ?>',
				table: '#econMethods',
				rowIdentifier: 'id'
			}, requestHandler)
			.on('click', '.bdelete', {
				operation: 'delete',
				link: '<?= $this->createUrl("delete"); ?>',
				table: '#econMethods',
				refreshLink: '<?= $this->createUrl("index") . '/ajax/1'; ?>',
				rowIdentifier: 'id'
			}, requestHandler);

	});
</script>
<div id="listEconMethods">

	<table id="econMethods" width="100%" class="display">
		<thead>
		<tr>
			<th title="Economic method">Economic method</th>
			<th title="Approach name">Approach name</th>
			<th title="Description">Description</th>
			<th title="Reference">Reference</th>
			<th title="Edit"></th>
			<th title="Delete"></th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>