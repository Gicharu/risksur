<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/22/15
 * Time: 12:38 AM
 *
 * @var $evaDetails array
 */
?>
<script type="text/javascript">
	$(function(){
		$("#evaSummary").dataTable({
			"bAutoWidth" : false,
			"bJQueryUI": true,
			"bFilter": false,
			"bSort": false,
			"bInfo": false,
			"bLengthChange": false,
			"aaData": <?= json_encode($evaDetails); ?>,
			"aoColumns": [
				{ "sTitle": "" },
				{ "sTitle": "" }
			]
		});
	});
</script>


<div id="evaSummaryContainer">

	<table id="evaSummary" class="tableStyle"
	       width="100%" border="0" cellspacing="0" cellpadding="0">
	</table>
</div>