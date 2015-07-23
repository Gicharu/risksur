<?php
/**
 * @var $evaDetails array
 * @var $pageData array
 * @var $this EvaluationController
 */
?>
<?php $this->renderPartial('_detailsTable', ['evaDetails' => $evaDetails]); ?>
<?= CHtml::tag('p', [], $pageData['message']); ?>
<?= CHtml::link('Next', $pageData['link'], ['class' => 'btn']); ?>
