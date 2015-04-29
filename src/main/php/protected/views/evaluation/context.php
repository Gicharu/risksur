<div class="contentContainer">
	<h3><?php echo $dataArray['formType']; ?> Evaluation Context</h3>
	<div class="contentLeft">
		<div class="form">
			<?php
			echo $form->render();
			?>
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
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
					"bFilter": false
				})
			})
		</script>
	</div>
	<div class="contentRight">
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
