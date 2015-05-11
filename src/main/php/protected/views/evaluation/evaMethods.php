<script type="text/javascript">
	$(function(){
		$("table tr td a.buttonLink").button().css('width', '14em');
	});
</script>
<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 5/11/15
 * Time: 3:45 PM
 */

$this->widget('zii.widgets.grid.CGridView', array(
	'columns' => array(
		array(
			'class' => 'CLinkColumn',
			'labelExpression' => '$data->buttonName',
			'urlExpression' => '$data->link',
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
		'style' => 'width:60%'
	),
	'selectableRows' => 0,
	'summaryText' => ''
));