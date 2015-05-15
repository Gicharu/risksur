<h3>Update economic evaluation method</h3>
<?php
$this->menu = array(
	array('label' => 'Add Economic Evaluation Methods', 'url' => array('admin/addEvaMethod')),
	array('label' => 'View Economic Evaluation Methods', 'url' => array('admin/listEvaMethods'))
);

$this->renderPartial('evaMethods/_form', array('form' => $form));