<?php
	$this->widget('zii.widgets.CMenu', array(
		'activeCssClass' => 'activeMnu',
		'activateParents' => true,
		'id' => 'menu',
		'items' => $menuParams['menuArray']
	));
?>
