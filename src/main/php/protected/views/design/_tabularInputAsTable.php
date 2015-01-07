<?php
	//print_r($form->activeForm['id']); die();
	//print_r($form); die();
	foreach ($form->getElements() as $key => $element) {
		// set the element name to add the row prefix
		$element->name = "[$index]" . $key;
		//print_r($element);
		//die();

		echo "<td>";
		echo $element;
		echo "</td>";
	}
?>
