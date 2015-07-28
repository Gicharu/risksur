<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/28/15
 * Time: 11:03 PM
 * @var $evaDetails array
 * @var $evaAssMethods array
 * @var $this EvaluationController
 */
$this->renderPartial('_detailsTable', ['evaDetails' => $evaDetails, 'tools' => true]);
?>
<script type="text/javascript">
	var dataAvailabilityMap = <?= json_encode([
	'yes' => 'Yes',
	'no' => 'No',
	'data_collection_needed' => 'Data collection needed'
	]); ?>;
	$(function() {
		$("#evaAssMethods").dataTable({
			"sDom": '<"H"rlTf>t<"F"ip>',
			"aaData": <?= json_encode($evaAssMethods); ?>,
			"aoColumns": [
				{"mData": "evaluationAttributes.name"},
				{"mData": "methodDescription"},
				{
					"mData": "dataAvailability", "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
							$(nTd).html(dataAvailabilityMap[sData]);
					}

				}

			],
			"bJQueryUI": true,
			"sPaginationType": "buttons_input",
			"oTableTools": {
				"sSwfPath": "<?php echo Yii::app()->request->baseUrl; ?>/js/copy_csv_xls_pdf.swf",
				"aButtons": [
					{
						"sExtends": "print",
						"sButtonText": "<?php echo Yii::t('translation', 'Print')?>",
						"sMessage": '<p class="printHeader">Evaluation Assessment Methods</p>',
						"bShowAll": false
					},
					{
						"sExtends": "collection",
						"sButtonText": "<?php echo Yii::t('translation', 'Save')?>",
						"aButtons" : [ {
							"sExtends": "pdf",
							oSelectorOpts: {
								page: 'current'
							},
							"sButtonText": "PDF",
							"fnClick":  function( nButton, oConfig, flash ) {
								flash.setFileName( "Evaluation_Assessment_Methods_" + getTitle() + ".pdf" );
								this.fnSetText( flash,
									"title:"+ this.fnGetTitle(oConfig) +"\n"+
									"message:"+ oConfig.sPdfMessage +"\n"+
									"colWidth:"+ this.fnCalcColRatios(oConfig) +"\n"+
									"orientation:"+ oConfig.sPdfOrientation +"\n"+
									"size:"+ oConfig.sPdfSize +"\n"+
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
								"fnClick": function ( nButton, oConfig, oFlash ) {
									oFlash.setFileName( "Evaluation_Assessment_Methods_" + getTitle() + ".csv" );
									this.fnSetText( oFlash,	"" + this.fnGetTableData(oConfig)
									);
								},
							}
						],
						"bShowAll": false
					}
				]
			}

		});

	});
</script>
<table id="evaAssMethods" class="tableStyle" width="100%" border="0" cellspacing="0" cellpadding="0">
	<thead>
	<tr>
		<th title = "Attribute Name">Attribute Name</th>
		<th title = "Assessment Method">Assessment Method</th>
		<th title = "Data collection needed">Data collection needed</th>
	</tr>
	</thead>
	<tbody>
	</tbody>
</table>