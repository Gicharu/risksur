<?php
/**
 * @var $form CForm
 * @var $index int
 */
foreach ($form->getElements() as $key => $element) {
	// set the element name to add the row prefix
	$element->name = "[$index]" . $key;
	//print_r($element);
	//var_dump($element instanceof CFormInputElement);
//		print_r($element);
//		die();

	echo "<td>";
//		echo $element;
	echo $element->renderInput();
	//echo CHtml::error($form->getModel(), $element->label);
	echo "</td>";
}
	//die;
//echo $form->renderEnd();
