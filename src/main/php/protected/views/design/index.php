<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/14/15
 * Time: 16:08
 * @var $editAccess bool
 * @var $editMode bool
 * @var $content DocPages
 * @var $this DesignController
 */
if ($editAccess) {


	echo CHtml::htmlButton(Yii::t('translation', 'Edit'), [
		'submit' => $this->createUrl($this->action->id),
		'params' => ['page' => $content->docId],
		'type' => 'submit',
		'style' => 'float:right;'
	]);

	if($editMode) {
		Yii::import('ext.imperavi-redactor-widget.ImperaviRedactorWidget');
		$this->widget('ImperaviRedactorWidget', array(
			// You can either use it for model attribute
			//'model' => $model,
			//'attribute' => 'evaluationDescription',

			// or just for input field
			//'name' => 'my_input_name',
			'selector' => '#desContent',
			// Some options, see http://imperavi.com/redactor/docs/
			'options' => array(
				'lang' => 'en',
				'toolbar' => true,
				'buttonSource' => true,
				'iframe' => false,
				//'autosave' => $this->createUrl('savePage'),
				//'autosaveOnChange' => true,
//				'autosaveFields' => [
//					'pageId' => $content->docId,
//					'ajax' => 1
//				],
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
		echo CHtml::form($this->createUrl($this->action->id));
		echo CHtml::textArea('desContent', $content->docData, ['id' => 'desContent']);
		echo CHtml::hiddenField('pageId', $content->docId);
		echo CHtml::submitButton(Yii::t('translation', 'Save'));
		echo CHtml::endForm();
	}

}
if(!$editMode) {
	echo urldecode($content->docData);
}

