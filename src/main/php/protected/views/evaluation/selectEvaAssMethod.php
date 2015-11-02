<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/27/15
 * Time: 11:43 AM
 * @var $assessModel EvaAssessmentMethods
 * @var $evaAttributeMap Array
 * @var $form CActiveForm
 * @var $this EvaluationController
 * @var $page array
 */
//var_dump($setEvaAttribute);
?>
	<script type="text/javascript">
		function initTable() {

			return $("#evaAssessmentMethods").dataTable({
				//"sDom": '<"H"rlf>t<"F"ip>',
				"aoColumns": [
					{
						"mData": null, "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
						//EvaluationHeader[evaAttributes][]
						var checkBox = $('<input>').attr({
							"type": 'checkBox',
							"name": 'EvaAssessmentMethods[' + iRow + '][assessmentMethod]',
							"class": 'dtCheck',
							"value": oData.id
						});
						if (typeof oData.evaAssessmentMethods != 'undefined') {
							oData.evaAssessmentMethods.forEach(function (method) {
								if (method.evaAttribute == oData.evaAttribute &&
									method.evaluationId == <?= $assessModel->evaluationId ?>) {
									$(checkBox).attr('checked', 'checked');
								}
							});
						}
						$(nTd)
							.html(checkBox)
							.addClass('center')
							.append($('<input>').attr({
								"type": 'hidden',
								"name": 'EvaAssessmentMethods[' + iRow + '][evaAttribute]',
								"value": oData.evaAttribute
							}))
							.append($('<input>').attr({
								"type": 'hidden',
								"name": 'EvaAssessmentMethods[' + iRow + '][evaluationId]',
								"value": '<?= $assessModel->evaluationId; ?>'
							}));
					}, "sWidth": '5%', "bSortable": false


					},
					{"mData": "name", "sWidth": '5%'},
					{
						"mData": null, "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
						var description = '<ul><li><b> Description: </b>' + oData.description +
							'</li><li><b> Data required: </b>' + oData.dataRequired +
							'</li><li><b> Expertise required: </b>' + oData.expertiseRequired + '</li></ul>';
						$(nTd).html(description)
					}, "sWidth": '50%'
					},
					{
						"mData": null, "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
						var radiolist = '<input class="dtCheck" type="radio" name="EvaAssessmentMethods[' + iRow +
							'][dataAvailable]" value="1" id="dataAv1">Yes' +
							'<br /><input class="dtCheck" type="radio" name="EvaAssessmentMethods[' + iRow +
							'][dataAvailable]" value="0" id="dataAv0">No' +
							'<br /> <input class="dtCheck" type="radio" name="EvaAssessmentMethods[' + iRow +
							'][dataAvailable]" value="2" id="dataAv2">Data collection needed';
						$(nTd).html(radiolist);
						if(typeof oData.evaAssessmentMethods != 'undefined') {
							oData.evaAssessmentMethods.forEach(function(method) {
								console.log(method.dataAvailable);
								if(method.dataAvailable !== null &&
									method.evaluationId == <?= $assessModel->evaluationId ?>) {

									$(nTd).children().each(function() {
										console.log($(this).attr('type'));
										if($(this).attr('type') == 'radio' && $(this).val() == method.dataAvailable) {
											$(this).attr('checked', true);
										}
									});

								}
							})
						}
					}
					},
					{"mData": "reference", "sWidth": '5%'}
				],
//			"aaSorting": [[0,'desc']],
				"bJQueryUI": true,
				"sPaginationType": "buttons_input",
				"bRetrieve": true,
				"fnInitComplete": function() {
					this.fnAdjustColumnSizing(true);
				}

			});
		}
		function loadMethods() {
			var element = $('#evaAttribute').val();
			if (element != '') {
				var evaMethodsTable = initTable();
				evaMethodsTable.fnReloadAjax('<?= $this->createUrl("selectEvaAssMethod"); ?>/id/' + element, customAssData);
//				evaMethodsTable.fnAdjustColumnSizing();
				//$('.row').toggle();
			}
			//$('.row').toggle();
		}
		function customAssData(data) {
			console.log(data);
			//console.log(data.customMethod.isEmptyObject());
			if(data.customMethod !== null && typeof data.customMethod.customAssessmentMethod != 'undefined') {
				$('#EvaAssessmentMethods_customAssessmentMethod').val(data.customMethod.customAssessmentMethod);
			}
			if(data.aaData.length == 0) {
				$('.row').hide();
			} else {
				$('.row').show();
			}
		}
		//var evaMethodsTable;
		$(function () {
			initTable();
			$('#evaAttribute').on('change', loadMethods);
			loadMethods();
		});
	</script>
<?php
$this->renderPartial('_page', [
	'editMode'   => $page['editMode'],
	'editAccess' => $page['editAccess'],
	'content'    => $page['content'],
]);
echo CHtml::tag('div', ['class' => 'form'], false, false);
//echo CHtml::beginForm();
echo CHtml::label('Evaluation Attribute', 'evaAttribute');
echo Chtml::dropDownList('evaAttribute', $assessModel->evaAttribute, $evaAttributeMap, [
	'id'               => 'evaAttribute',
	'class'            => 'chozen',
	'data-placeholder' => 'Select attribute',
	'empty'            => ''
]);
$form = $this->beginWidget('CActiveForm', [
	'id'                   => 'assessMethod-form',
	'enableAjaxValidation' => false,
	'enableClientValidation' => true,
	'clientOptions' => [
		'validateOnSubmit' => true,
	]
]);
?>
	<p>
		<?php
		echo $form->errorSummary([$assessModel],
			Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']);
		?>
	</p>
	<table id="evaAssessmentMethods" class="tableStyle" width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
		<tr>
			<th title=""></th>
			<th title="Method Name">Method Name</th>
			<th title="Description, data and expertise required">Description, data and expertise required</th>
			<th title="Data available">Data available</th>
			<th title="References">References</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>

<?php
echo CHtml::tag('div', ['class' => 'row', 'style' => 'display:none'], $form->labelEx($assessModel, 'customAssessmentMethod') .
	$form->textArea($assessModel, 'customAssessmentMethod'));
echo CHtml::tag('div', ['class' => 'row buttons', 'style' => 'display:none'],
	CHtml::submitButton('Save', ['name' => 'save']) . CHtml::submitButton('Next', ['name' => 'next']));
//echo CHtml::endForm();
$this->endWidget();
echo CHtml::closeTag('div');