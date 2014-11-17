<?php
	$this->widget('zii.widgets.CMenu', array(
		'activeCssClass' => 'active',
		'activateParents' => true,
		'id' => 'menu',
		'items' => $menuParams['menuArray']
	));
?>
