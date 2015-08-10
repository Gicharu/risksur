<?php
/* @var $this AdminevaquestionController */
/* @var $dataProviderJson string */

$this->breadcrumbs=array(
	'Evaluation Questions',
);

?>

<h1>Evaluation Questions</h1>

<script type="text/javascript">


	$(function() {
		$("#evaQuestions").dataTable({
			"sDom": '<"H"rlf>t<"F"ip>',
			"sAjaxSource": "<?= $this->createUrl('adminevaquestion/index/ajax/1'); ?>",
			"aoColumns": [
				{"mDataProp": "questionNumber", "sWidth": '14%' },
				{"mDataProp": "question" },
				//{"mDataProp": "description" },
				{
					"mDataProp": null,
					"bSortable": false,
					sClass: "editMethod",
					sDefaultContent: '<button title="Edit" class="bedit">Edit</button>',
					sWidth: '5%'
				},
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
				table: '#evaQuestions',
				rowIdentifier: 'evalQuestionId'
			}, requestHandler);
//			.on('click', '.bdelete', {
//				operation: 'delete',
//				link: '<?//= $this->createUrl("delete"); ?>//',
//				table: '#evaQuestions',
//				rowIdentifier: 'evalQuestionId'
//			}, requestHandler);

	});
</script>
<div id="listEvaQuestions">

	<table id="evaQuestions" width="100%" class="display">
		<thead>
		<tr>
			<th title = "Question Number">Question Number</th>
			<th title = "Question">Question</th>
<!--			<th title = "Descripton">Descripton</th>-->
			<th title = "Edit"></th>
<!--			<th title = "Delete"></th>-->
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>
