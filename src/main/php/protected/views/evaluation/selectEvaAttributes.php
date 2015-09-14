<?php
/**
 * @var $evaDetails array
 * @var $page array
 * @var $attributes array
 * @var $this EvaluationController
 * @var $evaluationModel EvaluationHeader
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
	var selectedAttributes = <?= is_null($evaluationModel->evaAttributes) ?
	json_encode(['0']) : json_encode($evaluationModel->evaAttributes); ?>;
	$(function() {
		$("#evaAttributes").dataTable({
			//"sDom": '<"H"rlf>t<"F"ip>',
			"aaData": <?= json_encode($attributes); ?>,
			"aoColumns": [
				{"mData": "relevance", "bVisible": false },
				{"mData": null, "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
					//EvaluationHeader[evaAttributes][]
					var checkBox = $('<input>').attr({
						type: 'checkBox',
						name: 'EvaluationHeader[evaAttributes][]',
						class: 'dtCheck',
						value: oData.attributeId
					});
					if(-1 != $.inArray(oData.attributeId, selectedAttributes)) {
						$(checkBox).attr('checked', 'checked');
					}
					$(nTd).html(checkBox).addClass('center');
				}, "sWidth": '5%', "bSortable": false


				},
				{"mData": "attribute.name" },
				{"mData": "attribute.description" },
				{"mData": "attributeTypes.name" },
				{"mData": "relevance", "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
					switch(sData) {
						case '1':
							$(nTd).html('Low');
							break;
						case '2':
							$(nTd).html('Medium');
							break;
						default:
							$(nTd).html('High');
					}

				}
				}
			],
			// update the buttons stying after the table data is loaded
			"fnDrawCallback": function() {
				$('button.assButton').button();
			},
			"aaSorting": [[0,'desc']],
			"bJQueryUI": true,
			"sPaginationType": "buttons_input"

		})
			.on('click', '.assButtonContainer', function() {
				var table = $("#evaAttributes").dataTable();
				var row = table.fnGetPosition(this);
				var data = table.fnGetData(row[0]);

				//console.log(data);
			});
	});
</script>
<div id="evaSummaryContainer">

	<table id="evaSummary" class="tableStyle"
	       width="100%" border="0" cellspacing="0" cellpadding="0">
	</table>
</div>
<div id="evaAttributesContainer">
	<?php
	$form = $this->beginWidget('CActiveForm', [
		'id' => 'evaAttributes-form',
		'enableClientValidation' => true,
		'clientOptions' => [
			'validateOnSubmit' => true,
		],
	]);
	echo $form->errorSummary(array($evaluationModel),
		Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']);
		//echo CHtml::activeCheckBoxList($evaluationModel, 'evaAttributes', ['1' => 'one']);
	?>
	<table id="evaAttributes" class="tableStyle" width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
		<tr>
			<th title = ""></th>
			<th title = ""></th>
			<th title = "Attribute Name">Attribute Name</th>
			<th title = "Attribute Description">Attribute Description</th>
			<th title = "Attribute Type">Attribute Type</th>
			<th title = "Relevance">Relevance</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	<?php //echo $form->error($evaluationModel, 'evaAttributes'); ?>

	<div class="row buttons">
		<?= CHtml::submitButton('Save', ['name' => 'saveEvaAttr']); ?>
		<?= CHtml::submitButton('Next', ['name' => 'saveEvaAttr']); ?>

	</div>
	<?php $this->endWidget(); ?>
</div>
<?php // CHtml::tag('p', [], $pageData['message']); ?>
<?php // CHtml::link('Next', $pageData['link'], ['class' => "btn"]); ?>
