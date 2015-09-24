<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 6/2/15
 * Time: 11:34 AM
 */
?>
<script type="text/javascript">
	$(document).ready(function() {
		var evaSummary = $("#evaSummary").dataTable({
			"bProcessing": true,
			"aoColumns": [
				{ "sClass": 'bold' },
				null
			],
//			bDestroy: true,
			bPaginate: false,
			"bJQueryUI": true,
//			"sPaginationType": "buttons_input",
			"bLengthChange": false,
			"bFilter": false,
			"oLanguage": {
				"sZeroRecords": "No evaluation summary available"
			},
			"oTableTools": {
				"sSwfPath": "<?php echo Yii::app()->request->baseUrl; ?>/js/copy_csv_xls_pdf.swf",
				"aButtons": [
					{
						"sExtends": "print",
						"sButtonText": "<?php echo Yii::t('translation', 'Print')?>",
						"sMessage": '<p class="printHeader">Evaluation summarys</p>',
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
								flash.setFileName( "Evaluation_summary_" + getTitle() + ".pdf" );
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
		$.ajax({
			url: "<?= $this->createUrl('evaluation/getEvaSummary'); ?>",
			dataType: 'json',
			success: function(data) {
				var rowData = [];
				var propNames = Object.keys(data);
				for(var name in propNames) {
					rowData[name] = [propNames[name], data[propNames[name]]];
				}
				evaSummary.fnAddData(rowData);
			}

		});
	});
</script>
<table id="evaSummary" cellspacing="0" width="100%">
	<thead>
	<tr>
		<th></th>
		<th></th>
	</tr>
	</thead>
	<tbody></tbody>
</table>
