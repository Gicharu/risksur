<?php
//echo $event->sender->menu->run();
//echo '<div>Step '.$event->sender->currentStep.' of '.$event->sender->stepCount;
//echo '<h3>'.$event->sender->getStepLabel($event->step).'</h3>';
echo CHtml::link('Help', '//surveillance-evaluation.wikispaces.com/Evaluation+question+guidance+pathway',
	['class' => 'help', 'target' => '_blank']);
echo CHtml::tag('div', ['class' => 'form'], $form);
?>
<script type="text/javascript">
	$(function() {
		$('span.required').hide();
		$('a.help').button({
			icons: {primary: "ui-icon-help"},
			text: false
		});
	});
</script>