<?php
//$form->activeForm['id'] = "[$index]" . $form->activeForm['id'];
//print_r($form->activeForm['id']); die();
//echo $form->renderBegin();
//print_r($form); die();
foreach ($form->getElements() as $key => $element) {
	// set the element name to add the row prefix
	$element->name = "[$index]" . $key;
	if ($index == 0) {
		//$element->class = " firstRow";
	}
//		print_r($element);
//		die();

	echo "<td>";
//		echo $element;
	echo $element->render();
	//echo CHtml::error($form->getModel(), $element->label);
	echo "</td>";
}
//echo $form->renderEnd();
