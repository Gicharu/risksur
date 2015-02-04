<h4>Eva page</h4>

<?php
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
		'autosave' => 'saveEvaPage',
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

?>
<form action="" id="formID" method="post">
<textarea id="redactor" name="redactor">
<?php
	echo urldecode($model->docData);
?>
</textarea>
</form>
