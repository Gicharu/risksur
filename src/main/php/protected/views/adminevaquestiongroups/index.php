<?php
/* @var $this AdminevaquestiongroupsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = [
	'Eva Question Groups',
];

$this->menu = [
	['label' => 'Add Association', 'url' => ['create']],
];
?>

<h3>Evaluation question - economic method association</h3>
<p> This section allows you to associate existing economic methods with evaluation question i.e link evaluation
	questions to economic methods</p>

<script type="text/javascript">


	$(function () {
		$("#evaQuestionGroups").dataTable({
			"sDom": '<"H"rlf>t<"F"ip>',
			"sAjaxSource": '<?= $this->createUrl("index", ["ajax" => 1]) ?>',
			"aoColumns": [
				{"mData": "methodName"},
				{"mData": "questions"},
				{
					"mData": null, "bSortable": false, sClass: "editMethod",
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
				table: '#evaQuestionGroups',
				rowIdentifier: 'methodId'
			}, requestHandler)
			.on('click', '.bdelete', {
				operation: 'delete',
				link: '<?= $this->createUrl("delete"); ?>',
				table: '#evaQuestionGroups',
				refreshLink: '<?= $this->createUrl("index") . '/ajax/1'; ?>',
				rowIdentifier: 'methodId'
			}, requestHandler);

	});
</script>
<div id="listEvaQuestionGroups">

	<table id="evaQuestionGroups" width="100%" class="display">
		<thead>
		<tr>
			<th title="Economic method">Economic method</th>
			<th title="Link">Evaluation questions</th>
			<th title="Edit"></th>
			<th title="Delete"></th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>