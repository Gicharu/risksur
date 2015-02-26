<div class="form">
<?php

	echo CHtml::errorSummary($form->models);
	//print_r($form->models);
	echo $form->render();
?>
</div>
