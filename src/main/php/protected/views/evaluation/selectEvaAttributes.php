<?php
/**
 * @var $evaDetails array
 * @var $page array
 * @var $attributes array
 * @var $this EvaluationController
 */
?>
<?php
if(!$page['editMode']) {
	$this->renderPartial('_detailsTable', ['evaDetails' => $evaDetails]);
	echo CHtml::tag('p');
}
$this->renderPartial('_page', [
	'editMode' => $page['editMode'],
	'editAccess' => $page['editAccess'],
	'content' => $page['content'],
]);
?>
<script type="text/javascript">
	$(function() {
		$("#evaAttributes").dataTable({
			//"sDom": '<"H"rlf>t<"F"ip>',
			"aaData": <?= json_encode($attributes); ?>,
			"aoColumns": [
				{"mData": null, "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
					$(nTd).html('<input class="dtCheck" type="checkbox" name="attributes[]" value="' +
					oData.attributeId + '"/>');
					$(nTd).addClass('center');
				}, "sWidth": '5%', "bSortable": false


				},
				{"mData": "attribute.name" },
				{"mData": "attribute.description" },
				{"mData": "attributeTypes.name" },
				{"mData": "relevance" },
				{
					"mData": null,
					"bSortable": false,
					"sWidth": '18%',
					"sClass": "delMethod",
					"sDefaultContent": '<button title="Delete" class="breport">Fill in assessment form</button>'
				}
			],
			// update the buttons stying after the table data is loaded
			"fnDrawCallback": function() {
				$('button.breport').button({
					icons: {primary: "ui-icon-document"}, text: true});
			},
			"bJQueryUI": true,
			"sPaginationType": "buttons_input"

		});
	});
</script>
<div id="evaSummaryContainer">

	<table id="evaSummary" class="tableStyle"
	       width="100%" border="0" cellspacing="0" cellpadding="0">
	</table>
</div>
<div id="evaAttributesContainer">
	<form id="evaAttrForm" name="evaAttrForm">
		<table id="evaAttributes" class="tableStyle" width="100%" border="0" cellspacing="0" cellpadding="0">
			<thead>
			<tr>
				<th title = ""></th>
				<th title = "Attribute Name">Attribute Name</th>
				<th title = "Attribute Description">Attribute Description</th>
				<th title = "Attribute Type">Attribute Type</th>
				<th title = "Relevance">Relevance</th>
				<th title = ""></th>
			</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</form>
</div>
<?//= CHtml::tag('p', [], $pageData['message']); ?>
<?php // CHtml::link('Next', $pageData['link'], ['class' => "btn"]); ?>
