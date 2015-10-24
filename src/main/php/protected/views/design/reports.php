<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 8/30/15
 * Time: 4:03 PM
 *
 * @var $this DesignController
 * @var $systemDropdown array
 * @var $page array
 */
echo CHtml::tag('div', ['class' => 'form'], false, false);
$this->renderPartial('//system/_page', [
	'content' => $page['content'],
	'editAccess' => $page['editAccess'],
	'editMode' => $page['editMode']
]);
echo CHtml::tag('p');
echo CHtml::link('Download excel tool', ['design/index', 'download' => true], ['class' => 'btn', 'target' => '_blank']);
echo CHtml::closeTag('p');
echo CHtml::tag('div', ['class' => 'row'], false, false);

echo CHtml::label('Select a surveillance system', 'systemSelect');
echo CHtml::dropDownList('systemSelect', '', $systemDropdown, ['empty' => 'Select one']);
echo CHtml::closeTag('div');

?>
<script>
	var reportsTable;
	$(function() {
		$('select')
			.chosen()
			.on('change', function() {
				//console.log(this.value); return false;
				if(this.value !== '') {
					var system = this.value;
					reportsTable.fnReloadAjax('<?= $this->createUrl("reports"); ?>/system/' + system);

				}
			});

		reportsTable = $("#designToolReports").dataTable({
			"sDom": '<"H"rTf>t<"F"ip>',
			"aoColumns": [
				null,
				null,
				null
//				{"mData": null, bVisible: true}

			],
			"oTableTools": {
				"sSwfPath": "<?= Yii::app()->request->baseUrl; ?>/js/copy_csv_xls_pdf.swf",
				"aButtons": [
					{
						"sExtends": "print",
						"sButtonText": "<?= Yii::t('translation', 'Print')?>",
						"sMessage": '<p class="printHeader">Design Tool Report</p>',
						"bShowAll": true
					},
					{


						"sExtends": "pdf",
						oSelectorOpts: {
							page: 'current'
						},
						"sButtonText": "PDF",
						"mColumns": "visible",
						"fnClick": function (nButton, oConfig, flash) {
							flash.setFileName("Design Tool Report_" + getTitle() + ".pdf");
							this.fnSetText(flash,
								"title:" + this.fnGetTitle(oConfig) + "\n" +
								"message:" + oConfig.sPdfMessage + "\n" +
								"colWidth:" + this.fnCalcColRatios(oConfig) + "\n" +
								"orientation:" + oConfig.sPdfOrientation + "\n" +
								"size:" + oConfig.sPdfSize + "\n" +
								"--/TableToolsOpts--\n" +
								this.fnGetTableData(oConfig)
							);
						},
						"bShowAll": true
					}
				]
			},

			// update the buttons stying after the table data is loaded
			"bJQueryUI": true,
			"sPaginationType": "buttons_input",
			"bProcessing": true,
			"iDisplayLength": 1000,
			//"aLengthMenu": [[10, 25, 50, 75, 100], [10, 25, 50, 75, 100]],
			"bFilter": true,
			"bSort": false,
			"bInfo": true
			//"bLengthChange": true
		})
			.rowGrouping({
				iGroupingColumnIndex: 2
				//sGroupingColumnSortDirection: "asc",
				//iGroupingOrderByColumnIndex: 1
			});
	});
</script>
<div id="reports">
	<table id="designToolReports" width="100%" class="display">
		<thead>
		<tr>
			<th>Name</th>
			<th>Value</th>
			<th>Component</th>

		</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>
<?php
echo CHtml::closeTag('div');
