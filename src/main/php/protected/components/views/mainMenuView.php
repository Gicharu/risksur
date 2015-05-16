<?php
	$this->widget('zii.widgets.CMenu', array(
		'activeCssClass' => 'ui-state-active',
		'activateParents' => true,
		'id' => 'menu',
		'items' => $menuParams['menuArray']
	));
?>
