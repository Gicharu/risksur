<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 5/11/15
 * Time: 3:45 PM
 * @var $this EvaluationController
 * @var $page Array
 */
?>
<script type="text/javascript">
	$(function(){
		$("a.buttonLink").button();
	});
</script>
<?php
$this->renderPartial('//system/_page', [
	'content' => $page['content'],
	'editAccess' => $page['editAccess'],
	'editMode' => $page['editMode']
]);

$this->widget('zii.widgets.grid.CGridView', array(
	'columns' => array(
		array(
			'class' => 'CLinkColumn',
			'labelExpression' => '$data->buttonName',
			'urlExpression' => 'isset($data->link) ? $data->link : "#"',
			'linkHtmlOptions' => array(
				'target' => '_blank',
				'class' => 'buttonLink'
			)
		),
		'description',
	),
	'dataProvider' => $dataProvider,
	'hideHeader' => true,
	'htmlOptions' => array(
		'id' => 'evaMethods',
		'style' => 'width:60%'
	),
	'selectableRows' => 0,
	'summaryText' => ''
));