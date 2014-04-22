<?php
$form = $this->beginWidget('CActiveForm', array(
	'id' => 'user-form',
	'enableClientValidation' => false,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
		));
echo $form->errorSummary(array($model), Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']);
$localeSession = isset(Yii::app()->session['locale']) ? Yii::app()->session['locale'] : 'en';
Yii::app()->setLanguage($localeSession);
?>
<script type="text/javascript">
$(document).ready(function() {
	$('.upgradeButtons').click(function() {
	    var buttonId = $(this).attr("id");
	    $('#performFunction').val(buttonId);
	    $('#user-form').submit();
	});
var configTable = "#configDataTable";
	$(configTable).dataTable({
		"sDom": '<"H"<"info">>t<"F"ip>',
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"bSort": true,
		"bInfo": true,
		"iDisplayLength": 15,
		"oLanguage": {
			"sInfo": "_TOTAL_ <?php echo Yii::t('translation', 'Organizations')?>",
			"sInfoEmpty": "<?php echo Yii::t('translation', 'No organizations to upgrade')?>",
			"sZeroRecords": "<?php echo Yii::t('translation', 'No organizations to upgrade')?>"
		}
	});
	$(".info").html('<?php echo CHtml::label(Yii::t("translation", "The following organizations config settings will be upgraded :"), "");?>');
});
</script>
<?php
$theButton = CHtml::htmlButton(Yii::t("translation", "Upload the MDD"), array(
				'id' => 'uploadMdd',
				'name' => 'uploadMdd',
				'type' => 'button',
				'class' => 'upgradeButtons'
			));
if (isset($message) && $message != "" && !empty($message)) {
	if (substr($message, 0, 8) == "xmlError") {
		if (strpos($message, "Error_IllegalVocabulary")) {
			$theError = str_replace("Error_IllegalVocabulary", "<br>Error_IllegalVocabulary", substr($message, 8));
			Yii::app()->user->setFlash("error", Yii::t('translation', 'Invalid Data XML.') . "<br>" . $theError . "<br><br>" . 
				Yii::t('translation', 'Fix the errors listed above (if any), then') . $theButton . Yii::t('translation', 'and re-validate'));
		} else {
			Yii::app()->user->setFlash("error", Yii::t('translation', 'Invalid Data XML.') . "<br>" . substr($message, 8));
		}
	} elseif (substr($message, 0, 11) == "mddXmlError") {
		Yii::app()->user->setFlash('error', Yii::t("translation", "Invalid MDD XML.") . '<br>' . substr($message, 11));
	} elseif ($message == "xmlSuccess") {
		Yii::app()->user->setFlash('success', Yii::t("translation", "The MDD and Data XMLs are valid."));
	} elseif ($message == "mddError") {
		Yii::app()->user->setFlash('error', Yii::t("translation", "Upload of MDD Failed...miserably! Kindly contact the administrator."));
	} elseif (substr($message, 0, 5) == "Error" || substr($message, 0, 7) == "Failure") {
		$message = strstr($message, "ERROR");
		Yii::app()->user->setFlash('error', Yii::t("translation", "Upgrade Failed. Kindly contact the administrator.") . " " . $message);
	} else {
		Yii::app()->user->setFlash('success', Yii::t("translation", "Upgrade Successful."));
	}
}
?>
<div id="main_section">
	 <table id="configDataTable" width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr align="left">
				<th width="35%"><?php echo Yii::t('translation', 'ORGANIZATION NAME');?></th>
				<th width="65%"><?php echo Yii::t('translation', 'ORGANIZATION ID');?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($gnsData as $key => $value) {?>
			<tr>
				<td><?php echo $value;?></td>
				<td><?php echo $key;?></td>
			</tr>
			<?php }	?>
		</tbody>
</table>
</div>
<br>
<div class="row buttons">
	<?php
	echo CHtml::htmlButton(Yii::t('translation', 'Perform Upgrade'), array(
		'id' => 'uploadXml',
		'name' => 'uploadXml',
		'type' => 'button',
		'class' => 'upgradeButtons'
	));
	
	echo CHtml::htmlButton(Yii::t('translation', 'Dry Run Upgrade'), array(
		'id' => 'validateXml',
		'name' => 'validateXml',
		'type' => 'button',
		'class' => 'upgradeButtons'
	));

	echo CHtml::hiddenField('performFunction', '', array(
		'id' => 'performFunction',
		'name' => 'performFunction',
		'type' => 'hidden'
	));
	$this->endWidget();?>
</div>