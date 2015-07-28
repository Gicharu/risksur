<script type="text/javascript">
	$(function() {
		$('.tabular-input-container, .tabular-input-add, .tabular-input-remove').remove();
	});
</script>
<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/27/15
 * Time: 11:43 AM
 * @var $assessModel EvaAssessmentMethods
 */
echo CHtml::tag('div', ['class' => 'form'], false, false);
//echo CHtml::beginForm();
$form = $this->beginWidget('CActiveForm', array(
	'id' => 'assessMethod-form',
	'enableAjaxValidation' => true,
));

$this->widget('ext.widgets.tabularinput.XTabularInput',array(
	'models'=> $assessModel,
	//'inputLimit'=>10, // comment in to limit the number of input rows
	'containerTagName'=>'table',
	'headerTagName'=>'thead',
	'header'=>'
        <tr>
            <td>'.CHtml::activeLabelEX(EvaAssessmentMethods::model(),'evaAttribute').'</td>
            <td>'.CHtml::activeLabelEX(EvaAssessmentMethods::model(),'methodDescription').'</td>
            <td>'.CHtml::activeLabelEX(EvaAssessmentMethods::model(),'expertise').'</td>
            <td>'.CHtml::activeLabelEX(EvaAssessmentMethods::model(),'dataAvailability').'</td>
            <td>'.CHtml::activeLabelEX(EvaAssessmentMethods::model(),'references').'</td>
            <td></td>
        </tr>
    ',
	//'inputContainerTagName'=>'tbody',
	'inputTagName'=>'tr',
	'inputView'=>'_assessmentMethodAsTable',
	//'inputUrl'=>$this->createUrl('request/addTabularInputsAsTable'),
	//'addTemplate'=>'<tbody><tr><td colspan="3">{link}</td></tr></tbody>',
	//'addLabel'=>Yii::t('ui','Add new row'),
	//'addHtmlOptions'=>array('class'=>'blue pill full-width'),
	//'removeTemplate'=>'<td>{link}</td>',
	//'removeLabel'=>Yii::t('ui','Delete'),
	//'removeHtmlOptions'=>array('class'=>'red pill'),
));
echo CHtml::submitButton('Next');
//echo CHtml::endForm();
$this->endWidget();
echo CHtml::closeTag('div');