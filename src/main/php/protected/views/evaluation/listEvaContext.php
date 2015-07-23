<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/19/15
 * Time: 2:00 PM
 * @var $this EvaluationController
 */
?>
<script type="text/javascript">
	$(function() {
		$("#evaContext").dataTable({
			"sDom": '<"H"rlf>t<"F"ip>',
			"sAjaxSource": "<?= $this->createUrl('evaluation/listEvaContext/ajax/1'); ?>",
			"aoColumns": [
				{"mDataProp": "evaluationName", "sClass": "underline setEvaContext clickable" },
				{"mDataProp": "evaluationDescription" },
				{"mDataProp": "frameworks.name" },
				{"mDataProp": "question.question", "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
					if(oData.question.question == '') {
						$(nTd).html('[No question selected for this context]').css('color', 'red');
					}
				} },
				{
					"mData": null,
					"bSortable": false,
					"sWidth": '5%',
					"sClass": "delMethod",
					"sDefaultContent": '<button title="Delete" class="bdelete">Delete</button>'
				}
			],
			// update the buttons stying after the table data is loaded
			"fnDrawCallback": function() {
			$('button.bdelete').button({
					icons: {primary: "ui-icon-trash"}, text: false});
			},
			"bJQueryUI": true,
			"sPaginationType": "buttons_input",
			"iDisplayLength": 10,
			"aLengthMenu": [[10, 25, 50, 75, 100], [10, 25, 50, 75, 100]],
//			"bFilter": true,
//			"bSort": true,
//			"bInfo": true,
			//"bLengthChange": true
		})
			.on('click', '.bdelete', {
				operation: 'delete',
				link: '<?= $this->createUrl("deleteEval"); ?>',
				refreshLink: '<?= $this->createUrl("listEvaContext") . '/ajax/1'; ?>',
				table: '#evaContext',
				rowIdentifier: 'evalId'
			}, requestHandler)
			.on('click', '.setEvaContext', function() {
				var table = $("#evaContext").dataTable();
				var row = table.fnGetPosition(this);
				var data = table.fnGetData(row[0]);
				//console.log(data);
				window.location = '<?= $this->createUrl("setEvaContext"); ?>/id/' +
				data.evalId + '/name/' + data.evaluationName;
			});

	});
</script>
<div id="listEvaContext">
	<p>
	<?= CHtml::link('New Evaluation Context', $this->createUrl('addEvaContext'), ['class' => 'btn']); ?>
	</p>
	<table id="evaContext" width="100%" class="display">
		<thead>
		<tr>
			<th title = "Evaluation name">Evaluation name</th>
			<th title = "Evaluation Description">Evaluation Description</th>
			<th title = "Surveillance System">Surveillance System</th>
			<th title = "Evaluation Question">Evaluation Question</th>
			<th title = "Delete"></th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>