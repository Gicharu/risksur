<?php
/* @var $this AdminAttributesAssessmentMethodsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = [
	'Eva Attributes Assessment Methods',
];

$this->menu = [
	['label' => 'Add Assessment Method', 'url' => ['create']],
];
?>

<h3>Evaluation Attributes Assessment Methods</h3>

<script type="text/javascript">


	$(function () {
		$("#evaAssMethods").dataTable({
			"sDom": '<"H"rlf>t<"F"ip>',
			"sAjaxSource": '<?= $this->createUrl("index", ["ajax" => 1]) ?>',
			"aoColumns": [
				{"mDataProp": "evaAttributes.name"},
				{"mDataProp": "name"},
				{"mDataProp": "description"},
				{"mDataProp": "dataRequired"},
				{"mDataProp": "expertiseRequired"},
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
				table: '#evaAssMethods',
				rowIdentifier: 'id'
			}, requestHandler)
			.on('click', '.bdelete', {
				operation: 'delete',
				link: '<?= $this->createUrl("delete"); ?>',
				table: '#evaAssMethods',
				refreshLink: '<?= $this->createUrl("index") . '/ajax/1'; ?>',
				rowIdentifier: 'id'
			}, requestHandler);

	});
</script>
<div id="listEvaAssMethods">

	<table id="evaAssMethods" width="100%" class="display">
		<thead>
		<tr>
			<th title="Evaluation attribute">Evaluation attribute</th>
			<th title="Method name">Method name</th>
			<th title="Description">Description</th>
			<th title="Data required">Data required</th>
			<th title="Expertise required">Expertise required</th>
			<th title="Reference">Reference</th>
			<th title="Edit"></th>
			<th title="Delete"></th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>