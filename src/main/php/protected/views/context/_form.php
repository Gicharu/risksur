<?php
/**
 * @var $form CForm
 */
?>
<div class="form">
<?php
	//echo $event->sender->menu->run();

	echo CHtml::errorSummary($form->models);
	//print_r($form->models);
	echo $form->render();
?>
</div>
