<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/16/15
 * Time: 10:29 AM
 * @var $this AdminEvaController
 * @var $page array
 */
$this->menu = [
	['label' => 'Manage Evaluation Context Form', 'url' => ['admineva/listEvaContext']],
	['label' => 'Manage Evaluation Questions', 'url' => ['adminevaquestion/index']],
	['label' => 'Manage Evaluation Attribute Relevance', 'url' => ['adminattributerelevance/index']],
	['label' => 'Manage Evaluation Assessment Methods', 'url' => ['adminattributesassessmentmethods/index']],
	['label' => 'Manage Economic Evaluation Methods', 'url' => ['admineva/listEvaMethods']],
	['label' => 'Manage Evaluation Method & Question Link', 'url' => ['adminevaquestiongroups/index']],
	['label' => 'Manage Economic Evaluation Approaches', 'url' => ['admineconomicmethods/index']]
];

$this->renderPartial('//system/_page', [
	'content' => $page['content'],
	'editAccess' => $page['editAccess'],
	'editMode' => $page['editMode']
]);
