<script type="text/javascript">
	$(document).ready(function() {
		$('#geq').button({
			icons: {
				primary: 'ui-icon-clipboard'
			}
		}).click(function() {
			window.location = '<?= $this->createUrl('evaQuestionWizard') ?>';
		});
		$('#eqpl').button({
			icons: {
				primary: 'ui-icon-check'
			}
		}).click(function() {
			window.location = '<?= $this->createUrl('evalQuestionList') ?>';
		});
	});
</script>
<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 5/5/15
 * Time: 12:01 PM
 */
echo CHtml::htmlButton('Guidance to define the evaluation question', array('id' => 'geq', 'class' => 'ui-button'));
echo CHtml::htmlButton('Evaluation question pick list', array('id' => 'eqpl', 'class' => 'ui-button'));