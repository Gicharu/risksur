<?php
/**
 * @var $form CForm
 * @var $index int
 * @var $key int
 * @var $element CFormInputElement
 */
//$form->renderBegin();
foreach ($form->getElements() as $key => $element) {
	// set the element name to add the row prefix
	$element->name = "[$index]" . $key;
	//$parent = $element->getParent();
	//var_dump($parent->getActiveFormWidget()); die;
	//var_dump($element instanceof CFormInputElement);
//		print_r($element);
//		die();

	echo "<td>";
//		echo $element;
	echo $element->renderInput();
	//echo $element->renderError();
	//echo CHtml::error($form->getModel(), $element->label);
//	echo "</td>";
}
	//die;
//$form->renderEnd();
