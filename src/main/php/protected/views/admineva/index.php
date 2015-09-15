<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/16/15
 * Time: 10:29 AM
 * @var $this AdminEvaController
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
?>

<h3> Manage Evaluation Tool</h3>
<p>
	This section allows you to view, add, update and delete various components of the evaluation tool. Select
	a section form the left to begin.
</p>