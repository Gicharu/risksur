<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 8/1/15
 * Time: 6:39 PM
 *
 * @var $model EvaAttributesMatrix
 * @var $this RiskController
 */
?>
<script type="text/javascript">
	var relevanceArray = ['Do not include', 'Low', 'Meduim', 'High'];
$(function() {
	$("#evaAttributeRelevance").dataTable({
			"sDom": '<"H"rlf>t<"F"ip>',
			"aaData": <?= json_encode($model); ?>,
			"aoColumns": [
				{"mDataProp": "objective.label" },
				{"mDataProp": "evaQuestionGroup","sWidth": '10%' },
				{"mDataProp": "attribute.name" },
				{"mDataProp": "relevance", "fnCreatedCell": function (cell, cellData, rowData, row, col) {
					$(cell).html(relevanceArray[cellData]);
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
				link: '<?= $this->createUrl("update"); ?>',
				table: '#evaAttributeRelevance',
				rowIdentifier: 'id'
			}, requestHandler)
			.on('click', '.bdelete', {
				operation: 'delete',
				link: '<?= $this->createUrl("delete"); ?>',
				refreshLink: '<?= $this->createUrl("index") . '/ajax/1'; ?>',
				table: '#evaAttributeRelevance',
				rowIdentifier: 'id'
			}, requestHandler);

	$('#questionGroups').dialog({
		autoOpen: false,
		width: 800,
		position: { my: "left top", at: "left top", of: window }
	});
//	$( "div.listAttributeRelevance #yw0" ).accordion();
//
	});
</script>
<div class="listAttributeRelevance">
	<table id="evaAttributeRelevance" width="100%" class="display">
		<thead>
		<tr>
			<th title = "Surveillance objective">Surveillance objective</th>
			<th title = "Question group">Question group</th>
			<th title = "Attribute">Attribute</th>
			<th title = "Relevance">Relevance</th>
			<th title = "Edit"></th>
			<th title = "Delete"></th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	<?= CHtml::ajaxLink('What are question groups?', 'getQuestionGroups',
		['update' => '#questionGroups'],
		['id' => 'questionGroups-link-'.uniqid(), 'class' => 'btn', 'onclick' => '$("#questionGroups").dialog("open")']
	);
	?>

	<div id="questionGroups" title="Question Groups"></div>
</div>