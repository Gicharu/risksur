<?php
if ($event->step) {
	echo CHtml::tag('p', array(), 'Surveillance design is now complete ');
	echo CHtml::tag('p', array(), 'You have characterized the surveillance system for this design task as: ');
	echo $this->generateOverviewTable($event);
} else {
	echo '<p>The wizard did not start</p>';
}
