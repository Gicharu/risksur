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
echo CHtml::tag('table', ['class' => 'tabular-container', 'width' => '50%'], false, false);
echo CHtml::tag('thead', ['class' => 'tabular-header'], false, false);
echo CHtml::tag('tr', [], $tableHeader);
echo CHtml::closeTag('thead');
echo CHtml::tag('tbody', ['class' => 'tabular-input-container'], false, false);

foreach($modelArray as $modelIndex => $model) {
	echo CHtml::tag('tr', [], false, false);
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
