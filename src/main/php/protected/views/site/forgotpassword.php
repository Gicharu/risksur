<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'user-form',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
));
$localeSession = isset(Yii::app()->session['locale']) ? Yii::app()->session['locale'] : 'en';
Yii::app()->setLanguage($localeSession);
?>

<?php //echo $form->errorSummary($model,Yii::app()->params['headerErrorSummary'],Yii::app()->params['footerErrorSummary']);
?>

	<div class="row panel ui-panel ui-widget ui-widget-content ui-corner-all pickListContainer">
		<?php echo $form->labelEx($model, Yii::t('translation', 'email')); ?>
		<?php echo $form->textField($model, 'email'); ?>
		<?php echo $form->error($model, 'email'); ?>
	</div>
	<div class="row buttons">
<?php //echo CHtml::submitButton('Submit');
?>
<?php echo CHtml::htmlButton(Yii::t('translation', 'Reset Password'), array(
	'id' => 'save',
	'onclick' => ';',
	'type' => 'submit'
)); ?>
<?php echo CHtml::htmlButton(Yii::t('translation', 'Cancel'), array(
	'onclick' => "window.location = '$cancelLink';"
)); ?>
	</div>
					  <!-- These additional buttons will help in future please do not delete them  -->

<!--  Html::submitButton('Save',array('submit'=>'','params'=>array('redirect'=>true)));
 Html::submitButton('Apply');
 Html::resetButton('Reset');
  Html::button('Cancel',array('confirm'=>Yii::t('admin','cancel.confirm'),
 'onclick'=>'$(document.location).attr("href","'.$this->createUrl('admin').'")'));

 Html::submitButton('Delete',array('confirm'=>Yii::t('admin','delete.confirm'),'submit'=>array('delete')));-->


<?php $this->endWidget(); ?>

</div><!-- form -->
