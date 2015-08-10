<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 8/10/15
 * Time: 11:17 AM
 * @var array $panels
 */
$this->widget('zii.widgets.jui.CJuiAccordion',[
	'panels'=> $panels,
	// additional javascript options for the accordion plugin
	'options'=>[
		//'animate'=>'easeInBounce',
		//'collapsible' => true
	],
	'htmlOptions' => ['id' => 'grpAccordion']
]);
