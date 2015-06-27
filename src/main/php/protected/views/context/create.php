
<div class="ui-widget">
	<div class="ui-widget-header">
		<p>Surveillance System</p>
	</div>
	<div class="ui-widget-content">
		<p></p>
		<?= $event->sender->menu->run(); ?>
		<p></p>
		<?= $event->sender->getStepLabel(); ?>
		<p></p>
		<?= $sectionInfo->description; ?>

		<?php
		echo $this->renderPartial('_form', array('form' => $form, 'event' => $event));
		?>
	</div>
</div>
		<?php print_r($_SESSION); ?>
<?php
if(!empty($gridFieldIds)) {
	foreach($gridFieldIds as $fieldId) {
		$this->widget('ext.jqrelcopy.JQRelcopy',
			array(
				'id' => 'copyLink-' . $fieldId,
				'removeHtmlOptions' => [
					'class' => 'btn'
				],
				'removeText' => '<span class="ui-icon ui-icon-trash"></span>remove', //uncomment to add remove link
				'tableLayout' => true,
				'options' => ['limit' => 5]
			)
		);
	}
}