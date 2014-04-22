<div class="form">
	<?php
	// print_r($dateFormatDropDown); die();
	$userPreferencesForm = $this->beginWidget('CActiveForm', array(
			'id' => 'user-preferences-form',
			'enableClientValidation' => false,
			'clientOptions' => array(
				'validateOnSubmit' => true,
			)
		)
	);
	echo $userPreferencesForm->errorSummary(array(
		$model
			), Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']);
	$localeSession = isset(Yii::app()->session['locale']) ? Yii::app()->session['locale'] : 'en';
	Yii::app()->setLanguage($localeSession);
	?>

	<script type="text/javascript">
	$(document).ready(function() {
		$('.preferencesButtons').click(function() {
		    var buttonId = $(this).attr("name");
		    $('#setPreference').val(buttonId);
		    $('#user-preferences-form').submit();
		});
		// $('select option').removeAttr('selected');
		$('select').chosen({
			disable_search : true
		});
	});
	</script>

	<fieldset class="preferences-container">
		<legend class="orgLegend"><?php echo Yii::t('translation', 'User Preferences');?></legend>
		<fieldset class="preferences">
			<legend class="orgLegend"><?php echo Yii::t('translation', 'Date Format Settings');?></legend>
			<div class="row">
				<span class="userpreferences-dropdown">
				<?php echo $userPreferencesForm->labelEx($model, Yii::t('translation', 'dateFormat')); ?>
				<?php echo $userPreferencesForm->dropDownList($model, 'dateFormat', $dateFormatDropDown,  array(
					'id' => 'dateFormat'
					// 'empty' => "Choose one"
					));
				echo $userPreferencesForm->error( $model, 'dateFormat', array('inputID' => "dateFormat") );
				?>
				</span>
				<span class="userpreferences-dropdown inline-dropdown">
					<?php 
					echo $userPreferencesForm->labelEx($model, Yii::t('translation', 'timeFormat'));
					
					echo $userPreferencesForm->dropDownList($model, 'timeFormat', $timeFormatDropDown,  array(
					'id' => 'timeFormat',
					// 'data-placeholder' => 'Choose one'
					));
					echo $userPreferencesForm->error( $model, 'timeFormat', array('inputID' => "timeFormat") ); 
					?>
				</span>
			</div>
			<div style="clear:both"></div>
			<div class="row" style="float:left;">
			<?php echo CHtml::htmlButton(Yii::t('translation', 'Save'), array(
				'id' => 'preferences-submit',
				'name' => 'preferencesSubmit',
				'type' => 'Submit',
				'class' => 'preferencesButtons'
				)
			); 
			?>
			</div>
		</fieldset>
	</fieldset>

	<?php
	echo CHtml::hiddenField('setPreference', '', array(
		'id' => 'setPreference',
		'name' => 'setPreference',
		'type' => 'hidden'
	));

	$this->endWidget();
	?>
</div>