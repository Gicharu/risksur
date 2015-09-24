<?php
//echo $event->sender->menu->run();
//echo '<div>Step '.$event->sender->currentStep.' of '.$event->sender->stepCount;
//echo '<h3>'.$event->sender->getStepLabel($event->step).'</h3>';
echo CHtml::tag('div', array('class' => 'form'), $form);
?>
<script type="text/javascript">
	$(function() {
		$('span.required').hide();
	});
</script>