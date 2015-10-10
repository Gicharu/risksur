<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/14/15
 * Time: 9:58 AM
 * @var $editAccess bool
 * @var $editMode bool
 * @var $content DocPages
 * @var $this ContextController
 */
if ($editAccess) {

	$submitUrl = $this->createUrl($this->action->id);
	if(isset($_GET['id'])) {
		$submitUrl = $this->createUrl($this->action->id, ['id' => $_GET['id']]);
	}
	if(!$editMode) {
	echo CHtml::htmlButton(Yii::t('translation', 'Edit'), array(
		'submit' => $submitUrl,
		'params' => ['page' => $content->docId],
		'type' => 'submit',
		'style' => 'float:right;'
	));

	}

	if($editMode) {
		Yii::import('ext.imperavi-redactor-widget.ImperaviRedactorWidget');
		$this->widget('ImperaviRedactorWidget', array(
			// You can either use it for model attribute
			//'model' => $model,
			//'attribute' => 'evaluationDescription',

			// or just for input field
			//'name' => 'my_input_name',
			'selector' => '#survContent',
			// Some options, see http://imperavi.com/redactor/docs/
			'options' => array(
				'lang' => 'en',
				'toolbar' => true,
				'buttonSource' => true,
				'iframe' => false,
				'linkNofollow' => true,
				'allowedAttr' =>  [
					['p', 'id'], ['a', ['name', 'target']], ['img', ['src', 'alt']]
				],
				'placeholder' => 'Enter some text...',
				'pastePlainText' => true,
				//'autosaveOnChange' => true,
//				'autosaveFields' => [
//					'pageId' => $content->docId,
//					'ajax' => 1
//				],
//				'autosaveCallback' => 'js:function(json) {
//					//console.log(json);
//				}',
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
		echo CHtml::form($submitUrl);
		echo CHtml::textArea('survContent', $content->docData, ['id' => 'survContent']);
		echo CHtml::hiddenField('pageId', $content->docId);
		echo CHtml::submitButton(Yii::t('translation', 'Save'));
		echo CHtml::endForm();
	}

}
if(!$editMode) {
	echo urldecode($content->docData);
}

