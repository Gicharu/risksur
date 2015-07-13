<script type="text/javascript">
	$(function() {
		$('#wzdfinishBtn').on('click', function() {
			window.location = '<?= Yii::app()->createUrl("context/list"); ?>';
		})
	});
</script>
<?php
if ($event->step) {
	echo '<div class="overViewTable">';
	echo CHtml::tag('p', array(), 'Surveillance design is now complete ');
	echo CHtml::tag('p', array(), 'You have characterized the surveillance system for this design task as: ');
	echo $this->generateOverviewTable($event);
	echo '</div>';
	echo CHtml::htmlButton('Finished', ['id' => 'wzdfinishBtn']);
	//die;
} else {
	echo '<p>The wizard did not start</p>';
}
