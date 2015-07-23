<?php
/**
 * @var $form CForm
 * @var $dataArray array
 */
?>
<div class="contentContainer">
	<h3><?php echo $dataArray['formType']; ?> Evaluation Context</h3>
	<div class="contentLeft">
		<div class="form">
			<?= $form->render(); ?>
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
				$('[title!=""]').qtip({
					content: {
						title: 'Info'
					},
					style: {
						widget: true,
						def: false
					}
				});
				var surSummary = $("#surSummary").dataTable({
					"bProcessing": true,
					"sAjaxSource": "<?php echo $this->createUrl('evaluation/getSurveillanceSummary'); ?>",
					"aoColumns": [
						{ "mDataProp": "inputName" },
						{ "mDataProp": "value" }
					],
					"bJQueryUI": true,
					"sPaginationType": "buttons_input",
					"iDisplayLength": 10,
					"bLengthChange": false,
					"bFilter": false,
					"oLanguage": {
						"sZeroRecords": "No surveillance system summary available"
					}
				});
			});
		</script>
	</div>
	<div class="contentRight">
		<div class="ui-widget-header ui-widget-content ui-corner-all widgetHead">
			Summary of the surveillance system</div>
		<table id="surSummary" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th></th>
				<th></th>
			</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>
