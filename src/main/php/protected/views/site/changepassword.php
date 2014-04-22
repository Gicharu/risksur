<?php
$localeSession = isset(Yii::app()->session['locale']) ? Yii::app()->session['locale'] : 'en';
Yii::app()->setLanguage($localeSession);

$this->pageTitle = Yii::app()->name . Yii::t('translation', ' - Change password'); ?>

<h3><?php echo Yii::t('translation', 'Change password')?></h3>
<?php
if ($expiredLink == true) {
?>
<h4><?php echo Yii::t('translation', 'The account recovery information has expired and is no longer valid.')?> <h4> 
<p><?php echo Yii::t('translation', 'Please try the forgot password process again')?></p>
<a href="<?php echo $cancelLink; ?>"><?php echo Yii::t('translation', 'Login Page')?></a>
<?php
} else {
?>

<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'user-form',
	'enableClientValidation' => false,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
));
?>
<?php echo $form->errorSummary($model, Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']); ?>
<div class="row panel ui-panel ui-widget ui-widget-content ui-corner-all pickListContainer">
	<div class="row">
		<?php echo $form->labelEx($model, 'email'); ?>
		<?php echo $form->textField($model, 'email', array('readonly' => true)); ?>
		<?php echo $form->error($model, 'email'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'newPassword'); ?>
		<?php
		$this->widget('ext.EStrongPassword.EStrongPassword', array(
			'form' => $form,
			'model' => $model,
			'attribute' => 'newPassword'
		));
		echo $form->passwordField($model, 'newPassword', array('autocomplete' => 'off')); ?>
		<?php echo $form->error($model, 'newPassword'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'verifyPassword'); ?>
		<?php echo $form->passwordField($model, 'verifyPassword', array('autocomplete' => 'off'));?>
		<?php echo $form->error($model, 'verifyPassword'); ?>
	</div>
</div>
<div class="row buttons">
	<?php //echo CHtml::submitButton('Submit');
	?>
	<?php echo CHtml::htmlButton(Yii::t('translation', 'Save'), array(
		'id' => 'save',
		'onclick' => ';',
		'type' => 'submit',
		'autocomplete' => 'off'
	)); ?>

	<?php echo CHtml::htmlButton(Yii::t('translation', 'Cancel'), array(
		'id' => 'cancel',
		'onclick' => "window.location = '$cancelLink';",
		'type' => 'button'
	)); ?>

</div>

<?php $this->endWidget(); ?>
<?php
}
?>

</div><!-- form -->
