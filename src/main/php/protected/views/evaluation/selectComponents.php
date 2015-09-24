<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/3/15
 * Time: 4:36 PM
 * @var $form CForm
 * @var $this EvaluationController
 * @var $componentsList string
 * @var $selectedComponents array
 * @var $page array
 * @var $evaDetails array
 */
if(!$page['editMode']) {
	$this->renderPartial('_detailsTable', ['evaDetails' => $evaDetails]);
	echo CHtml::tag('p');
}
$this->renderPartial('//system/_page', [
	'content' => $page['content'],
	'editAccess' => $page['editAccess'],
	'editMode' => $page['editMode']
]);
echo CHtml::tag('div', ['class' => 'form'], $form->render());
?>
<script type="text/javascript">
	var selectedComponents = <?= json_encode(array_flip($selectedComponents)); ?>;
	$(function() {
		$('#componentsDisplay').dataTable({
			"sDom": '<"H"rlf>t<"F"ip>',
			"bProcessing": true,
			"aaData": <?= $componentsList ?>,
			//"bAutoWidth" : true,
			"aoColumns": [
				{
					"mData": null, "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
						//EvaluationHeader[evaAttributes][]
						var checkBox = $('<input>').attr({
							type: 'checkBox',
							name: 'DesignForm[components][]',
							class: 'dtCheck',
							value: oData.componentId
						});
						console.log(selectedComponents[oData.componentId]);
						if(typeof selectedComponents[oData.componentId] != 'undefined') {
							$(checkBox).attr('checked', 'checked');
						}
						$(nTd).html(checkBox).addClass('center');
					},
					"sWidth": '5%', "bSortable": false
				},
				{"mDataProp": "name"},
				{"mDataProp": "targetSpecies"},
				{"mDataProp": "dataColPoint"},
				{"mDataProp": "studyType"}
				//{"mData": "deleteButton", "bSortable": false, "bVisible": true, "sWidth": "8%" },

			],
			"bJQueryUI": true,
			//"sPaginationType": "customListbox",
			"sPaginationType": "buttons_input",
//			"oTableTools": {
//				"sSwfPath": "<?php //echo Yii::app()->request->baseUrl; ?>///js/copy_csv_xls_pdf.swf",
//				"aButtons": [
//					//"print",
//					{
//						"sExtends": "print",
//						"sButtonText": "<?php //echo Yii::t('translation', 'Print')?>//",
//						"sMessage": '<p class="printHeader">Component Listing</p>',
//						"bShowAll": false
//					},
//					{
//
//						"sExtends": "collection",
//						"sButtonText": "<?php //echo Yii::t('translation', 'Save')?>//",
//						"aButtons" : [ {
//							"sExtends": "pdf",
//							oSelectorOpts: {
//								page: 'current'
//							},
//							"sButtonText": "PDF",
//							"fnClick":  function( nButton, oConfig, flash ) {
//								flash.setFileName( "Component Listing_" + getTitle() + ".pdf" );
//								this.fnSetText( flash,
//									"title:"+ this.fnGetTitle(oConfig) +"\n"+
//									"message:"+ oConfig.sPdfMessage +"\n"+
//									"colWidth:"+ this.fnCalcColRatios(oConfig) +"\n"+
//									"orientation:"+ oConfig.sPdfOrientation +"\n"+
//									"size:"+ oConfig.sPdfSize +"\n"+
//									"--/TableToolsOpts--\n" +
//									this.fnGetTableData(oConfig)
//								);
//							}
//						},
//							{
//								"sExtends": "csv",
//								"sButtonText": "Excel (CSV)",
//								"sCharSet": "utf16le",
//								oSelectorOpts: {
//									page: 'current'
//								},
//								"fnClick": function ( nButton, oConfig, oFlash ) {
//									oFlash.setFileName( "Component Listing_" + getTitle() + ".csv" );
//									this.fnSetText( oFlash,	"" + this.fnGetTableData(oConfig)
//									);
//								}
//							}
//						],
//						"bShowAll": false
//					}
//				]
//			}

			//"iDisplayLength": 10,

		})
	})
</script>
