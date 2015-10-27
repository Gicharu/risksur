<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/14/15
 * Time: 16:08
 * @var $page array
 * @var $this DesignController
 */
$this->renderPartial('//system/_page', [
	'content' => $page['content'],
	'editAccess' => $page['editAccess'],
	'editMode' => $page['editMode']
]);

