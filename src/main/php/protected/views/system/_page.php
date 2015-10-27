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
		CController::widget('ImperaviRedactorWidget', [
			// You can either use it for model attribute
			//'model' => $model,
			//'attribute' => 'evaluationDescription',

			// or just for input field
//			'name' => 'survContent',
			'selector' => '#survContent',
			// Some options, see http://imperavi.com/redactor/docs/
			'options' => [
				'lang' => 'en',
				'toolbar' => true,
				'buttonSource' => true,
				'iframe' => false,
				'placeholder' => 'Enter some text...',
				'pastePlainText' => true,

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
		echo CHtml::form($submitUrl);
		echo CHtml::textArea('survContent', $content->docData);
		echo CHtml::hiddenField('pageId', $content->docId);
		echo CHtml::submitButton(Yii::t('translation', 'Save'));
		echo CHtml::endForm();
	}

}
if(!$editMode) {
	echo urldecode($content->docData);
}

