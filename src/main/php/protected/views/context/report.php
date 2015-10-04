<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 6/2/15
 * Time: 11:34 AM
 * @var $surveillanceReport array
 */
?>
<script type="text/javascript">
	$(document).ready(function() {
		var survReport = $("#surveillanceReport").dataTable({
			"sDom": '<"H"rTf>t<"F"ip>',
			"bProcessing": true,
			"aoColumns": [
				{"mDataProp": "sectionName", "bVisible": false},
				{"mDataProp": "parentLabel", "bVisible": false},
//				{"mDataProp": "parenLabelIndex", "bVisible": false},
				{"mDataProp": "field"},
				{"mDataProp": "data"}
			],
			"aaSorting": [[1,'asc']],
			bPaginate: false,
			"bJQueryUI": true,
			"aaData": <?= json_encode($surveillanceReport); ?>,
			"bLengthChange": false,
			"bFilter": false,
			"oLanguage": {
				"sZeroRecords": "No surveillance summary available"
			},
			"oTableTools": {
				"sSwfPath": "<?php echo Yii::app()->request->baseUrl; ?>/js/copy_csv_xls_pdf.swf",
				"aButtons": [
					{
						"sExtends": "print",
						"sButtonText": "<?php echo Yii::t('translation', 'Print')?>",
						"sMessage": '<p class="printHeader">Surveillance Report</p>',
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
							"mColumns": "visible",
							"sButtonText": "PDF",
							"fnClick":  function( nButton, oConfig, flash ) {
								flash.setFileName( "Surveillance_report_" + getTitle() + ".pdf" );
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
									oFlash.setFileName( "Surveillance_report_" + getTitle() + ".csv" );
									this.fnSetText( oFlash,	"" + this.fnGetTableData(oConfig)
									);
								}
							}
						]
					}
				]
			}
		}).rowGrouping({ iGroupingColumnIndex2: 1}); //

	});
</script>
<table id="surveillanceReport" cellspacing="0" cellpadding="0" border="0" width="100%" class="display">
	<thead>
	<tr>
<!--		<th></th>-->
		<th></th>
		<th></th>
		<th>Field</th>
		<th>Value</th>
	</tr>
	</thead>
	<tbody></tbody>
</table>
