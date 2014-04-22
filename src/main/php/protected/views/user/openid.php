<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'openid-form',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
));
?>

	<div class="requiredNote">Required  *</div>

<?php //echo $form->errorSummary($model,Yii::app()->params['headerErrorSummary'],Yii::app()->params['footerErrorSummary']);
 ?>
 <?php echo $form->errorSummary($model); ?>	
	<ul>

		<li><?php echo $form->errorSummary($model); ?></li>
		<li><?php echo $form->labelEx($model, 'gmailaddress'); ?></li>
		<li><?php echo $form->error($model, 'gmailaddress'); ?></li>
		<li><?php echo $form->labelEx($model, 'gmailpassword'); ?></li>
		<li><?php echo $form->error($model, 'gmailpassword'); ?></li>
		</ul>
	<div class="row buttons">
		<?php //echo CHtml::submitButton('Submit');
 ?>
	  <div>
	  <ul>
	  <li><?php echo CHtml::htmlButton('Login', array(
	'id' => 'login',
	'onclick' => ';',
	'type' => 'submit'
)); ?></li>
	  <li><?php echo CHtml::htmlButton('Cancel', array(
	'id' => 'cancel',
	'onclick' => '',
	'type' => 'reset'
)); ?></li>
	  </ul>

	</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
