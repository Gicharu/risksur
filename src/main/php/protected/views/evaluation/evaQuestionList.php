<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 5/5/15
 * Time: 2:36 PM
 * @var $form CForm
 * @var $questions Array
 * @var $questionId string
 */
//var_dump($questions); die;
?>

<script type="text/javascript">
	var selectedQuestion = <?= $questionId; ?>;
	$(document).ready(function() {
		$(function() {
			$('#questionSelect').dataTable({
				"sDom": '<"H"rf>t<"F"ip>',
				"bProcessing": true,
				"aaData": <?= json_encode(array_values($questions)); ?>,
				//"bAutoWidth" : true,
				"aoColumns": [
					{
						"mData": null, "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
						//EvaluationHeader[evaAttributes][]
						var checkBox = $('<input>').attr({
							"type": 'radio',
							"name": 'EvaluationHeader[questionId]',
							"class": 'dtCheck',
							value: oData.questionId
						});
						//console.log(selectedComponents[oData.componentId]);
						var highlightClass = '';
						if(selectedQuestion == oData.questionId) {
							$(checkBox).attr('checked', 'checked');
							highlightClass = 'highlighted';
						}
						$(nTd).html(checkBox).addClass('center ' + highlightClass).parent().css('font-weight', 'bold');
					},
						"sWidth": '3%', "bSortable": false
					},
					{"mData": "questionNumber", "sWidth": '5%'},
					{"mData": "question"},
					{"mData": "criteria"},
					{"mData": "method"}
					//{"mData": "deleteButton", "bSortable": false, "bVisible": true, "sWidth": "8%" },

				],
				"bJQueryUI": true,
				//"sPaginationType": "customListbox",
				"sPaginationType": "buttons_input",
				"iDisplayLength": 50,

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


			});
			//$('.highlighted')
		});

});
</script>
<?= CHtml::tag('div', ['class' => 'form'], $form->render()); ?>
