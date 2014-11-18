<?php
/*USE http_negotiate_language TO GET THE USER'S LOCALE AND USE IT FOR THE APP*/
$langs = array(
		'en',
		'en-us',
		'en-gb',
		'bs',
		'bs_BA',
);

if (function_exists('http_negotiate_language')) {
	$locale = http_negotiate_language($langs, $result);
} else {
	$locale = http\Env::negotiateLanguage($langs, $result);
	$locale = substr($locale, 0, 2);
}
Yii::app()->setLanguage($locale);
$this->pageTitle = Yii::app()->name . Yii::t("translation", " - Register New User");
//remove the trailing asteriks
CHtml::$afterRequiredLabel = '';
?>
<div id="bd">
	<div class="form">
		<?php $form = $this->beginWidget('CActiveForm', array(
			'id' => 'login-form',
			'enableClientValidation' => false,
			'clientOptions' => array(
				'validateOnSubmit' => true,
			),
		)); ?>
		<div id="j_idt12" class="ui-messages ui-widget">
			<ul id="formLogin">
				<li>
					<?php
						echo $form->labelEx($model, 'username', array(
						'id' => 'label-username',
						'inputID' => 'label-username'
						));
						echo $form->textField($model, 'username');
					?>
				</li>
				<li>
					<?php 
						if(strpos($form->error($model, 'username'), "Username cannot be blank.")) {
							echo "<b><font color='red'>" . $form->error($model, 'username') . "</font></b>"; 
						}
					?>
				</li>
				<li>
					<?php
						echo $form->labelEx($model, 'email', array(
						'id' => 'label-email',
						'inputID' => 'label-email'
						));
						echo $form->textField($model, 'email');
					?>
				</li>
				<li>
					<?php 
						if(strpos($form->error($model, 'email'), "Email cannot be blank.")) {
							echo "<b><font color='red'>" . $form->error($model, 'email') . "</font></b>"; 
						}
					?>
				</li>
				<li>
					<?php
						echo $form->labelEx($model, 'password', array(
							'id' => 'label-password',
							'inputID' => 'label-password'
						));
						echo $form->passwordField($model, 'password');
					?>
				</li>
				<li>
					<?php 
						if(strpos($form->error($model, 'password'), "Password cannot be blank.")) {
									echo "<b><font color='red'>" . $form->error($model, 'password') . "</font></b>"; 
						}
					?>
				</li>
				<li>
					<?php
						echo $form->labelEx($model, 'confirmPassword', array(
							'id' => 'label-confirmPassword',
							'inputID' => 'label-confirmPassword'
						));
						echo $form->passwordField($model, 'confirmPassword');
					?>
				</li>
				<li>
					<?php 
						if(strpos($form->error($model, 'confirmPassword'), "Confirm Password cannot be blank.")) {
							echo "<b><font color='red'>" . $form->error($model, 'confirmPassword') . "</font></b>"; 
						}
					?>
				</li>
			</ul>
		</div>
		<div class="row">
		<?php echo CHtml::Button(Yii::t("translation", "Register"), array(
				'id' => 'register',
				'onclick' => CController::createUrl('site/registerUser'),
				'type' => 'submit'
		)); ?>
		</div>


		<?php $this->endWidget(); ?>
	</div>
</div>
