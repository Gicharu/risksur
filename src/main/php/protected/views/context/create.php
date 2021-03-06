<?php
/**
 * @var $event WizardBehavior
 * @var $form CForm
 * @var $sectionInfo CActiveRecord
 */
?>
	<div class="ui-widget">
		<div class="ui-widget-header">
			<h3 style="color:#ffffff">Surveillance System</h3>
		</div>
		<div class="ui-widget-content">
			<?= $event->sender->menu->run(); ?>
			<?php
			if($event->sender->getCurrentStep() != 1) {
			?>
			<p></p>
			<div class="surHeading">
			<?= '1.' . $event->sender->getCurrentStep() . ' ' .  $event->sender->getStepLabel(); ?>
			</div>
				<?php } ?>
			<br/>
			<?= $sectionInfo->description; ?>

			<?php
			echo $this->renderPartial('_form', array('form' => $form, 'event' => $event));
			?>
		</div>
	</div>
<?php
if(!empty($gridFieldIds)) {
	foreach($gridFieldIds as $fieldId) {
		$this->widget('ext.jqrelcopy.JQRelcopy',
			array(
				'id' => 'copyLink-' . $fieldId,
				'removeHtmlOptions' => [
					'class' => 'btn',
				],
				'options' => [
//					'removeText' => '<span class="ui-icon ui-icon-trash"></span>remove', //uncomment to add remove link
					'append' => '<td><a class="remove ui-icon ui-icon-trash" href="#" onclick="$(this).parent().parent().remove(); return false">remove</a>',
					'limit' => 5
				]
			)
		);
	}
}