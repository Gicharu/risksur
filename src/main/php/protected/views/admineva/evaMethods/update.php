<h3>Update economic evaluation method</h3>
<?php
$this->menu = array(
	array('label' => 'Add Economic Evaluation Methods', 'url' => array('adminEva/addEvaMethod')),
	array('label' => 'View Economic Evaluation Methods', 'url' => array('adminEva/listEvaMethods'))
);

$this->renderPartial('evaMethods/_form', array('form' => $form));