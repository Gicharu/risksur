<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/27/15
 * Time: 11:55 AM
 * @var $model CActiveRecord
 * @var $index int
 */
?>
<td>
	<?php echo CHtml::activeTextField($model,"[$index]evaAttributeName", ['readOnly' => true]); ?>
	<?php echo CHtml::activeHiddenField($model,"[$index]evaAttribute"); ?>
</td>
<td>
	<?php echo CHtml::activeTextArea($model, "[$index]methodDescription") ?>
	<?php echo CHtml::error($model, "[$index]methodDescription"); ?>
</td>
<td>
	<?php echo CHtml::activeDropDownList($model, "[$index]expertise",
		['logistic_modelling' => 'Logistic Modelling', 'r_software' => 'R software'], ['multiple' => true]) ?>
	<?php echo CHtml::error($model,"[$index]expertise"); ?>
</td>
<td>
	<?php echo CHtml::activeDropDownList($model, "[$index]dataAvailability",
		['yes' => 'Yes', 'no' => 'No', 'data_collection_needed' => 'Data collection needed']) ?>
	<?php echo CHtml::error($model, "[$index]dataAvailability"); ?>
</td>
<td>
	<?php echo CHtml::activeTextArea($model, "[$index]references") ?>
	<?php echo CHtml::error($model, "[$index]references"); ?>
</td>
