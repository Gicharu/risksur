<?php $this->beginContent('//layouts/main'); ?>
<!--<div class="container">-->
<div class="span-5 last">
	<div id="sidebar">
		<?php
//        $this->beginWidget('zii.widgets.CPortlet', array(
//            'title' => 'Operations',
//        ));
		$this->beginWidget('zii.widgets.CMenu', array(
			'items' => $this->menu,
			'itemCssClass' => 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only',
			'htmlOptions' => array(
				'class' => 'operations'
			),
		));
		$this->endWidget();
		?>
	</div><!-- sidebar -->
</div>
	<div class="span-19">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
<!--</div>-->
<!--</div>-->
<?php $this->endContent(); ?>
