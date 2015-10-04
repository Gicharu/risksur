<?php
/**
 * @var $form CForm
 */
?>
<script>
	$(function() {
//		$('select').chosen({
//			create_option: function(term){
//				var chosen = this;
//				var options = {
//					label: term,
//					frameworkFieldId: $(chosen.form_field).data('field'),
//					scenario: 'addFrameworkField'
//				};
//				$.post('<?//= $this->createUrl("options/addOption"); ?>//', {options}, function(data){
//					if(data.optionId != '') {
//						chosen.append_option({
//							value: data.optionId,
//							text: data.label
//						});
//
//					}
//				}, 'json');
//			},
//			skip_no_results: true
//		});
	});
</script>
<div class="form">
<?php
	//echo $event->sender->menu->run();

	echo CHtml::errorSummary($form->models);
	//print_r($form->models);
	echo $form->render();
?>
</div>
