<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 10/1/15
 * Time: 11:45 AM
 * @var $form CForm
 */


$this->menu= [
	['label'=>'List surveillance wizard sections', 'url'=> ['index']],

];
echo CHtml::tag('div', ['class' => 'form'], $form->render());


