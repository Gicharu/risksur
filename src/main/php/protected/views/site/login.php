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
	//returns bs_BA so we trim
	$locale = substr($locale, 0, 2);
}
$paginationLocaleFile = 'paginationLocales' . DIRECTORY_SEPARATOR . $locale . '.txt';
Yii::app()->setLanguage($locale);

if(file_exists($paginationLocaleFile)) {
	Yii::app()->session->add('locale', $locale);
} else {
	Yii::app()->session->add('locale', 'en');
}

$this->pageTitle = Yii::app()->name . Yii::t("translation", " - Login");
//$this->breadcrumbs = array(
	//'Login',
//);

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
		<!--<div class="login-error"><?php //echo $form->errorSummary($model);?></div>-->
		<div id="j_idt12" class="ui-messages ui-widget">
			<ul id="formLogin">
				<li>
					<?php
						echo $form->labelEx($model, 'username', array(
						'id' => 'label-username',
						'inputID' => 'label-username'
						));
						
						echo $form->textField($model, 'username', array(
						'class' => 'ui-inputfield ui-widget ui-state-default ui-corner-all'
						));
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
						echo $form->labelEx($model, 'password', array(
							'id' => 'label-password',
							'inputID' => 'label-password'
						));

						echo $form->passwordField($model, 'password', array(
							'class' => 'ui-inputfield ui-widget ui-state-default ui-corner-all'
						));
					?>
				</li>
				<li>
					<?php 
						if(strpos($form->error($model, 'password'), "Password cannot be blank.")) {
									echo "<b><font color='red'>" . $form->error($model, 'password') . "</font></b>"; 
						}
					?>
				</li>
			</ul>
			<ul id="formRemember">
				<li>
					<?php echo $form->label($model, 'rememberMe'); ?><?php echo $form->checkBox($model, 'rememberMe'); ?>
				</li>
				<li>
					<?php echo $form->error($model, 'rememberMe'); ?>
				</li>
				<li>
					<button id="login" name="login" onclick=";" type="submit"><?php echo Yii::t("translation", "Login");?></button>
				</li>
				
				<?php $url = Yii::app()->createUrl("site/forgotpassword"); ?>
				
				<li>
					<a href="<?= $url ?>" ><?php echo Yii::t("translation", "Forgot your Password"); ?></a>
				</li>
				<li>
					<a href='<?= Yii::app()->createUrl("site/registerUser"); ?>'>
						<?= Yii::t("translation", "Register");?></a>
				</li>
			</ul>
		</div>

		<?php $this->endWidget(); ?>
	</div>
</div>
