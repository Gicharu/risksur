<?php
/**
 * @var $editButton bool
 * @var $editPage bool
 * @var $this EvaluationController
 */
	if (!$editButton OR !$editPage) {

		if ($editButton) {
			echo CHtml::htmlButton(Yii::t('translation', 'Edit'), [
				'submit' => [
					'evaluation/evaPage?edit=1'
				],
				'type' => 'submit',
				'style' => 'float:right;'
			]);
		}
		echo urldecode($model->docData);

		echo CHtml::link('Create New Evaluation Protocol', $this->createUrl('addEvaContext'),
			['class' => 'btn']);
		echo CHtml::link('Update Existing Evaluation Protocol', $this->createUrl('listEvaContext'),
			['class' => 'btn']);
	} else {
Yii::import('ext.imperavi-redactor-widget.ImperaviRedactorWidget');

$this->widget('ImperaviRedactorWidget', [
	// You can either use it for model attribute
	//'model' => $model,
	//'attribute' => 'evaluationDescription',

	// or just for input field
	//'name' => 'my_input_name',
	'selector' => '#redactor',
	// Some options, see http://imperavi.com/redactor/docs/
	'options' => [
		'lang' => 'en',
		'toolbar' => true,
		'buttonSource' => true,
		'iframe' => false,
		'autosave' => 'saveEvaPage',
		'autosaveOnChange' => true,
		'autosaveCallback' => 'js:function(json) {
			//console.log(json);
		}',
		'focus' => true,
		'imageUpload' => 'imageUpload',
		//'imageManagerJson' => '/images/images.json',
		//'css' => 'wym.css',
	],
	'plugins' => [
		'fullscreen' => [
			'js' => ['fullscreen.js',],
		],
		'fontsize' => [
			'js' => ['fontsize.js',],
		],
		'table' => [
			'js' => ['table.js',],
		],
		'imagemanager' => [
			'js' => ['imagemanager.js',],
		],
		'fontcolor' => [
			'js' => ['fontcolor.js',],
		],
	],

]);

	echo CHtml::htmlButton(Yii::t('translation', 'View'), [
		'submit' => [
			'evaluation/evaPage'
		],
		'type' => 'submit',
		'style' => 'float:right; z-index:2000'
	]);
?>
<form action="" id="formID" method="post">
<textarea id="redactor" name="redactor">
<?php
	echo urldecode($model->docData);
?>
</textarea>
</form>
<?php
	}
?>
