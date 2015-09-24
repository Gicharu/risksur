<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/12/15
 * Time: 1:57 PM
 * @var $this EvaluationController
 * @var $evaModel EvaluationHeader
 * @var $page array
 * @var $econMethods array
 * @var $form CActiveForm
 */

$this->renderPartial('_page', [
	'editMode'   => $page['editMode'],
	'editAccess' => $page['editAccess'],
	'content'    => $page['content'],
]);
?>
<script type="text/javascript">
	var selectedEconMethods = <?= isset($evaModel->econEvaMethods) ? $evaModel->econEvaMethods : '[]'; ?>;
	$(function() {
		$("#econEvaMethods").dataTable({
			"aaData": <?= $econMethods; ?>,
			"aoColumns": [
				{
					"mData": null, "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
					//EvaluationHeader[evaAttributes][]
					var checkBox = $('<input>').attr({
						"type": 'checkBox',
						"name": 'EvaluationHeader[' + iRow + '][econEvaMethods]',
						"class": 'dtCheck',
						"value": oData.id
					});
					if (selectedEconMethods.length > 0) {
						selectedEconMethods.forEach(function (method) {
							if (method == oData.id) {
								$(checkBox).attr('checked', 'checked');
							}
						});
					}
					$(nTd).html(checkBox);
				}, "sWidth": '5%', "bSortable": false


				},
				{"mData": "econMethodGroup.buttonName"},
				{"mData": "name"},
				{"mData": "description"},
				{"mData": "reference"}
			],
			"bJQueryUI": true,
			"sPaginationType": "buttons_input",
			"bRetrieve": true

		});
	})
</script>
<?php
echo CHtml::tag('div', ['class' => 'form'], false, false);

$form = $this->beginWidget('CActiveForm', [
	'id'                   => 'econEvaMethods-form',
	'enableAjaxValidation' => false,
	'enableClientValidation' => true,
	'clientOptions' => [
		'validateOnSubmit' => true,
	]
]);
?>
	<p>
		<?php
		echo $form->errorSummary([$evaModel],
			Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']);
		?>
	</p>
	<table id="econEvaMethods" class="tableStyle" width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
		<tr>
			<th title=""></th>
			<th title="Economic Method">Economic Method</th>
			<th title="Economic approach">Economic approach</th>
			<th title="Description">Description</th>
			<th title="References">References</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>

<?php
echo CHtml::tag('div', ['class' => 'row buttons'],
	CHtml::submitButton('Save', ['name' => 'save']) . CHtml::submitButton('Next', ['name' => 'next']));
//echo CHtml::endForm();
$this->endWidget();
echo CHtml::closeTag('div');