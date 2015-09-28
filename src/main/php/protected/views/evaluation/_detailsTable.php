<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/22/15
 * Time: 12:38 AM
 *
 * @var $evaDetails array
 * @var $tools true
 */
//print_r($evaDetails); die;

?>
<script type="text/javascript">
	$(function(){
		$("#evaSummary").dataTable({
			"bAutoWidth" : false,
			"bInfo": false,
			"aaData": <?= json_encode($evaDetails); ?>,
			"aoColumns": [
				{ "sTitle": "" },
				{ "sTitle": "" }
			],
			"iDisplayLength": 50,
			<?php
			if(isset($tools)) {
			?>
			"sDom": '<"H"rTf>t<"F"ip>',
			"oTableTools": {
				"sSwfPath": "<?php echo Yii::app()->request->baseUrl; ?>/js/copy_csv_xls_pdf.swf",
				"aButtons": [
					{
						"sExtends": "print",
						"sButtonText": "<?php echo Yii::t('translation', 'Print')?>",
						"sMessage": '<p class="printHeader">Evaluation Summary</p>',
						"bShowAll": false
					},
					{
						"sExtends": "collection",
						"sButtonText": "<?php echo Yii::t('translation', 'Save')?>",
						"aButtons": [{
							"sExtends": "pdf",
							oSelectorOpts: {
								page: 'current'
							},
							"sButtonText": "PDF",
							"fnClick": function (nButton, oConfig, flash) {
								flash.setFileName("Evaluation_Summary_" + getTitle() + ".pdf");
								this.fnSetText(flash,
									"title:" + this.fnGetTitle(oConfig) + "\n" +
									"message:" + oConfig.sPdfMessage + "\n" +
									"colWidth:" + this.fnCalcColRatios(oConfig) + "\n" +
									"orientation:" + oConfig.sPdfOrientation + "\n" +
									"size:" + oConfig.sPdfSize + "\n" +
									"--/TableToolsOpts--\n" +
									this.fnGetTableData(oConfig)
								);
							}
						},
							{
								"sExtends": "csv",
								"sButtonText": "Excel (CSV)",
								"sCharSet": "utf16le",
								oSelectorOpts: {
									page: 'current'
								},
								"fnClick": function (nButton, oConfig, oFlash) {
									oFlash.setFileName("Evaluation_Summary_" + getTitle() + ".csv");
									this.fnSetText(oFlash, "" + this.fnGetTableData(oConfig)
									);
								}
							}
						],
						"bShowAll": false
					}
				]
			},
			<?php }	?>
			"bJQueryUI": true,
			"bFilter": false,
			"bSort": false
		});
	});
</script>


<div id="evaSummaryContainer">

	<table id="evaSummary" class="tableStyle"
	       width="100%" border="0" cellspacing="0" cellpadding="0">
	</table>
</div>