<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 8/2/15
 * Time: 11:21 AM
 * @var EvaAttributes $model
 * @var int $index
 */
?>
<td>
	<?php
	$survObjCriteria = new CDbCriteria();
	$survObjCriteria->with = ['options'];
	$survObjCriteria->select = 'inputName';
	$survObjCriteria->condition = "inputName='survObj' AND options.frameworkFieldId=t.id";

	$rsSurveillanceObjective = FrameworkFields::model()->find($survObjCriteria);
	$objectives = CHtml::listData($rsSurveillanceObjective->options, 'optionId', 'label');
//	/var_dump($objectives); die;

	?>
	<?php echo CHtml::activeDropDownList($model,"[$index]surveillanceObj", $objectives, ['empty' => 'Select one']); ?>
	<?php echo CHtml::error($model,"[$index]surveillanceObj"); ?>
</td>
<td><?php
	$rsQuestionGrp = EvaQuestionGroups::model()->find(['select' => 'questions']);
	$questionsArray = array_keys((array) json_decode($rsQuestionGrp->questions));
	$groups = array_combine($questionsArray, range(1, count($questionsArray)));
	$groups[6] = 'Risk based'; //Group 6
	?>
	<?php echo CHtml::activeDropDownList($model,"[$index]evaQuestionGroup", $groups, ['empty' => 'Select one']); ?>
	<?php echo CHtml::error($model,"[$index]evaQuestionGroup"); ?>
</td>
<td>
	<?php
	$attributes = CHtml::listData(EvaAttributes::model()->findAll(), 'attributeId', 'name');
	?>
	<?php echo CHtml::activeDropDownList($model,"[$index]attributeId", $attributes, ['empty' => 'Select one']); ?>
	<?php echo CHtml::error($model,"[$index]attributeId"); ?>
</td>
<td>
	<?php echo CHtml::activeDropDownList($model,"[$index]relevance", ['Do not include', 'Low', 'Medium', 'High'], ['empty' => 'Select one']); ?>
	<?php echo CHtml::error($model,"[$index]relevance"); ?>
</td>
<td></td>