<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 8/2/15
 * Time: 11:04 AM
 * @var array $model
 */

?>

<div class="form">
	<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'attributeRelevance-form',
		'enableAjaxValidation' => true,
	));
	$this->widget('ext.widgets.tabularinput.XTabularInput', [
		'models'                => $model,
		//'inputLimit'=>10, // comment in to limit the number of input rows
		'containerTagName'      => 'table',
		'headerTagName'         => 'thead',
		'header'                => '
        <tr>
            <td>' . CHtml::activeLabelEX(EvaAttributesMatrix::model(), 'surveillanceObj') . '</td>
            <td>' . CHtml::activeLabelEX(EvaAttributesMatrix::model(), 'evaQuestionGroup') . '</td>
            <td>' . CHtml::activeLabelEX(EvaAttributesMatrix::model(), 'attributeId') . '</td>
            <td>' . CHtml::activeLabelEX(EvaAttributesMatrix::model(), 'relevance') . '</td>
            <td></td>
        </tr>
    ',
		'inputContainerTagName' => 'tbody',
		'inputTagName'          => 'tr',
		'inputView'             => '_evaMatrixAsTable',
		'inputUrl'              => $this->createUrl('addMatrixRow'),
		'addTemplate'           => '<tfoot><tr><td colspan="1">{link}</td></tr></tfoot>',
		'addLabel'              => Yii::t('ui', 'Add'),
		'addHtmlOptions'        => ['class' => 'btn'],
		'removeTemplate'        => '<td>{link}</td>',
		'removeLabel'           => Yii::t('ui', 'Delete'),
		'removeHtmlOptions'     => ['class' => 'btn'],
	]);

	echo CHtml::submitButton('Save');
	$this->endWidget();
	?>
</div>