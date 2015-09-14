<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/28/15
 * Time: 11:03 PM
 * @var $evaDetails array
 * @var $evaAssMethods array
 * @var $econEvaMethods array
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
				{"mData": "evaAttrAssMethods.description"},
				{
					"mData": "dataAvailable", "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
					switch (sData) {
						case '0':
							$(nTd).html('No');
							break;
						case '1':
							$(nTd).html('Yes');
							break;
						default:
							$(nTd).html('Data collection needed');

					}
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
						"sExtends": "pdf",
						"sButtonText": "<?php echo Yii::t('translation', 'Save')?>",
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

					}
				]
			}

		});
		$("#econEvaMethods").dataTable({
			"sDom": '<"H"rlTf>t<"F"ip>',
			"aaData": <?= json_encode($econEvaMethods); ?>,
			"aoColumns": [
				{"mData": "econMethodGroup.buttonName"},
				{"mData": "name"},
				{"mData": "description"},
				{"mData": "reference"},

			],
			"bJQueryUI": true,
			"sPaginationType": "buttons_input",
			"oTableTools": {
				"sSwfPath": "<?php echo Yii::app()->request->baseUrl; ?>/js/copy_csv_xls_pdf.swf",
				"aButtons": [
					{
						"sExtends": "print",
						"sButtonText": "<?php echo Yii::t('translation', 'Print')?>",
						"sMessage": '<p class="printHeader">Economic evaluation Methods</p>',
						"bShowAll": false
					},
					{
						"sExtends": "pdf",
						"sButtonText": "<?php echo Yii::t('translation', 'Save')?>",
						"fnClick":  function( nButton, oConfig, flash ) {
							flash.setFileName( "Economic_evaluation_methods_" + getTitle() + ".pdf" );
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
<p></p>
<table id="econEvaMethods" class="tableStyle" width="100%" border="0" cellspacing="0" cellpadding="0">
	<thead>
	<tr>
		<th title = "Economic method">Economic method</th>
		<th title = "Economic approach">Economic approach</th>
		<th title = "Description">Description</th>
		<th title = "Reference">Reference</th>
	</tr>
	</thead>
	<tbody>
	</tbody>
</table>