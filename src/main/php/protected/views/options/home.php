<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 10/4/15
 * Time: 10:33 PM
 *
 * @var $page array
 */
$this->menu = [
	['label' => 'Manage Surveillance Drop downs', 'url' => ['options/index/id/1']],
	['label' => 'Manage Component Drop downs', 'url' => ['options/index/id/2']],
	['label' => 'Manage Evaluation Drop downs', 'url' => ['options/index/id/3']],
];

$this->renderPartial('//system/_page', [
	'content' => $page['content'],
	'editAccess' => $page['editAccess'],
	'editMode' => $page['editMode']
]);