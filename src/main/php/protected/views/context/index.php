<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/14/15
 * Time: 3:00 PM
 * @var $content CActiveRecord
 * @var $editAccess bool
 * @var $editMode bool
 *
 */

$this->renderPartial('_page', [
		'content' => $content,
		'editAccess' => $editAccess,
		'editMode' => $editMode
	]
);