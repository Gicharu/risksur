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
 * @var $setEvaAttribute mixed
 */
//var_dump($setEvaAttribute);
?>
<script type="text/javascript">
	function initTable() {

		return $("#evaAssessmentMethods").dataTable({
			//"sDom": '<"H"rlf>t<"F"ip>',
			"aoColumns": [
				{"mData": null, "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
					//EvaluationHeader[evaAttributes][]
					var checkBox = $('<input>').attr({
						"type": 'checkBox',
						"name": 'EvaAssessmentMethods[' + iRow + '][assessmentMethod]',
						"class": 'dtCheck',
						"value": oData.id
					});
					if(typeof oData.evaAssessmentMethods != 'undefined') {
						oData.evaAssessmentMethods.forEach(function(method) {
							console.log(method);
							if(method.evaAttribute == oData.evaAttribute) {
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
				{"mData": "name" },
				{"mData": "description" },
				{"mData": null, "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
					var radiolist = '<input class="dtCheck" type="radio" name="EvaAssessmentMethods[' + iRow +
						'][dataAvailable]" value="1">Yes' +
						'<br /><input class="dtCheck" type="radio" name="EvaAssessmentMethods[' + iRow +
						'][dataAvailable]" value="0">No' +
						'<br /> <input class="dtCheck" type="radio" name="EvaAssessmentMethods[' + iRow +
						'][dataAvailable]" value="2">Data collection needed';
					$(nTd).html(radiolist);
				} },
				{"mData": "reference" }
			],
//			"aaSorting": [[0,'desc']],
			"bJQueryUI": true,
			"sPaginationType": "buttons_input",
			"bRetrieve": true

		});
	}
	function loadMethods() {
		var element = $('#evaAttribute').val();
		if(element != '') {
			var evaMethodsTable = initTable();
			evaMethodsTable.fnReloadAjax('<?= $this->createUrl("selectEvaAssMethod"); ?>/id/' + element);
		}
	}
	//var evaMethodsTable;
	$(function() {
		initTable();
		$('#evaAttribute').on('change', loadMethods);
		loadMethods();
	});
</script>
<?php
echo CHtml::tag('div', ['class' => 'form'], false, false);
//echo CHtml::beginForm();
echo CHtml::label('Evaluation Attribute', 'evaAttribute');
echo Chtml::dropDownList('evaAttribute', $assessModel->evaAttribute, $evaAttributeMap, [
	'id' => 'evaAttribute',
	'class' => 'chozen',
	'data-placeholder' => 'Select attribute',
	'empty' => ''
]);
$form = $this->beginWidget('CActiveForm', array(
	'id' => 'assessMethod-form',
	'enableAjaxValidation' => true,
));
?>
<p>
	<?php
	echo $form->errorSummary(array($assessModel),
	Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']);
	?>
</p>
<table id="evaAssessmentMethods" class="tableStyle" width="100%" border="0" cellspacing="0" cellpadding="0">
	<thead>
	<tr>
		<th title = ""></th>
		<th title = "Method Name">Method Name</th>
		<th title = "Description, data and expertise required">Description, data and expertise required</th>
		<th title = "Data available">Data available</th>
		<th title = "References">References</th>
	</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<?php
echo CHtml::submitButton('Save', ['name' => 'save']);
//echo CHtml::endForm();
$this->endWidget();
echo CHtml::closeTag('div');