<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 8/28/15
 * Time: 12:26 PM
 */
//print_r($elements); die;
if(isset($modelArray[0]) && isset($elements['elements'][0])) {
	$formHead = new CForm(array_merge($elements['elements'][0], ContextController::getDefaultElements()), $modelArray[0]);
	echo $formHead->renderBegin();
}
echo CHtml::tag('div', ['class' => 'form'], false, false);
echo CHtml::tag('table', ['class' => 'tabular-container'], false, false);
echo CHtml::tag('thead', ['class' => 'tabular-header'], false, false);
echo CHtml::tag('tr', [], $tableHeader);
echo CHtml::closeTag('thead');
echo CHtml::tag('tbody', ['class' => 'tabular-input-container'], false, false);

foreach($modelArray as $modelIndex => $model) {
	echo CHtml::tag('tr', ['class' => 'tabular-input'], false, false);
	$form = new CForm($elements['elements'][$modelIndex], $model);
	foreach($form->getElements() as $element) {
		$element->name = "[$modelIndex]$element->name";
		echo CHtml::tag('td', [], $element->renderInput());
	}
	echo CHtml::closeTag('tr');

	//$form[$modelIndex] = $model;
}
echo CHtml::closeTag('tbody');
echo CHtml::closeTag('table');
echo CHtml::submitButton('Update');
echo CHtml::closeTag('div');
echo $formHead->renderEnd();
?>
<script>
	$(function() {
		$('select')
			.on('chosen:ready', function(chosen) {
				//console.log($(chosen.currentTarget).attr('oldtitle'));
				//console.log(chosen);
				$(chosen.currentTarget.nextSibling).attr('title', $(chosen.currentTarget).attr('title'));
				$('form [title!=""]').qtip({
					overwrite: true,
					content: {
						title: {
							text: 'Info'
//							button: 'Close'
						}
					},
					style: {
						widget: true,
						def: false
					}

				});
			})
			.chosen({
				create_option: function(term){
					var chosen = this;
					var options = {
						label: term,
						componentId: $(chosen.form_field).data('field'),
						scenario: 'addComponentField'
					};
					console.log(options);
					//return;
					$.post('<?= $this->createUrl("options/addOption"); ?>', {options}, function(data){
						if(data.optionId != '') {
							chosen.append_option({
								value: data.optionId,
								text: data.label
							});

						}
					}, 'json');
				},
				skip_no_results: true
			});
	})
</script>