<?php
		if ($editButton) {
			echo CHtml::htmlButton(Yii::t('translation', 'Edit'), array(
				'submit' => array(
					'evaluation/evaConcept?edit=1'
				),
				'type' => 'submit',
				'style' => 'float:right;'
			));
		}
	if (!$editButton OR !$editPage) {
		echo urldecode($model->docData);
	} else {
Yii::import('ext.imperavi-redactor-widget.ImperaviRedactorWidget');

$this->widget('ImperaviRedactorWidget', array(
	// You can either use it for model attribute
	//'model' => $model,
	//'attribute' => 'evaluationDescription',

	// or just for input field
	//'name' => 'my_input_name',
	'selector' => '#redactor',
	// Some options, see http://imperavi.com/redactor/docs/
	'options' => array(
		'lang' => 'en',
		'toolbar' => true,
		'buttonSource' => true,
		'iframe' => false,
		'autosave' => 'saveEvaConcept',
		'autosaveOnChange' => true,
		'autosaveCallback' => 'js:function(json) {
			//console.log(json);
		}',
		'focus' => true,
		'imageUpload' => 'imageUpload',
		//'imageManagerJson' => '/images/images.json',
		//'css' => 'wym.css',
	),
	'plugins' => array(
		'fullscreen' => array(
			'js' => array('fullscreen.js',),
		),
		'fontsize' => array(
			'js' => array('fontsize.js',),
		),
		'table' => array(
			'js' => array('table.js',),
		),
		'imagemanager' => array(
			'js' => array('imagemanager.js',),
		),
		'fontcolor' => array(
			'js' => array('fontcolor.js',),
		),
	),

));
	echo CHtml::htmlButton(Yii::t('translation', 'View'), array(
		'submit' => array(
			'evaluation/evaConcept'
		),
		'type' => 'submit',
		'style' => 'float:right; z-index:2000'
	));

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
