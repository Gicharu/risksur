<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 8/14/15
 * Time: 8:50 AM
 *
 * @var $form CForm
 * @var $this DesignController
 * @var $randomIds array
 */
?>
<script type="text/javascript">
//	var displayItems = <?//= json_encode($displayItems); ?>//;
	$(function() {
		$('.accStyle').accordion({
			heightStyle: 'content'
		});
		$('.componentList').on('change', function() {
			if(this.value !== '') {
				$.ajax({
					context: this,
					url: '<?= $this->createUrl('getDesignData'); ?>',
					data: {
						componentId: this.value,
						componentName: this.name
					},
					dataType: "json",
					success: function (data) {
						console.log($(this).parents('div')[0], $(this).parent().parent()[0])
						$(this).not('p .btn').parents('div.row').siblings().remove();
						$(this).parents('fieldset div:first-child').after(data.formData);

					}
				});

			}
		});
	});
</script>
<?php
echo CHtml::tag('div', ['class' => 'form'], $form);
//echo $form;
foreach($randomIds as $id) {
	$this->widget('ext.jqrelcopy.JQRelcopy',
		[
			'id'                => 'copyLink-' . $id,
			'removeHtmlOptions' => [
				'class' => 'btn '
			],
			'removeText'        => '<span class="ui-icon ui-icon-trash">Remove</span>', //uncomment to add remove link
			//'tableLayout' => true,
			//'options' => ['limit' => 5]
		]
	);
}
