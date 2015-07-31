<h3>Add new economic evaluation method</h3>
<?php
$this->menu = [['label' => 'View Economic Evaluation Methods', 'url' => ['adminEva/listEvaMethods']],];

$this->renderPartial('evaMethods/_form', array('form' => $form));