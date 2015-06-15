<div class="ui-widget">
	<div class="ui-widget-header">
		<p>Surveillance System</p>
	</div>
	<div class="ui-widget-content">
		<p></p>
		<?= $event->sender->menu->run(); ?>
		<?= $sectionInfo->description; ?>

		<?php
		echo $this->renderPartial('_form', array('form' => $form, 'event' => $event));
		?>
	</div>
</div>
		<?php print_r($_SESSION); ?>
