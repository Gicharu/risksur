<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<?php 
		$settings = Yii::app()->tsettings;
		$storySettings = $settings->getSettings();
		$baseUrl = Yii::app()->request->baseUrl;
		// array of css include paths with media types
		$cssArray = array(
			$baseUrl . "/css/screen.css" => "screen, projection",
			$baseUrl . "/css/print.css" => "print",
			//$baseUrl . "/css/reset-fonts-grids.css" => "noMedia",
			$baseUrl . "/css/jquery.menubar.css" => "noMedia",
			$baseUrl . "/css/demo_table.css" => "noMedia",
			$baseUrl . "/css/jquery-ui-1.8.21.custom.css" => "noMedia",
			$baseUrl . "/css/risksurstyle.css" => "noMedia",
			$baseUrl . "/css/form.css" => "noMedia",
			$baseUrl . "/css/details.css" => "noMedia"
		);
		// array of javascript include paths
		$javaScriptArray = array(
			"/libraries/jquery-1.8.3/jquery-1.8.3.min.js",
			"/libraries/jquery-ui-1.9.1/jquery-ui-1.9.1.custom.min.js",
			"/libraries/jquery-menubar/jquery.menubar.js",
			"/libraries/DataTables-1.9.4/media/js/jquery.dataTables.min.js",
			"/js/scripts/main_ui_functions.js"
		);
	?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta charset="UTF-8">
	<meta name="language" content="en" />
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" type="image/x-icon">

<?php
	// add the css include files to the page
	$settings->processCssIncludes($cssArray);
	// add the javascript include files to the page
	$settings->processJavaScriptIncludes($javaScriptArray);
?>

	<script type="text/javascript">



//function to add call deletebox		
function deleteConfirm(formName,confValue){
	$('#deleteBox').html("<p>Are you sure you want to delete '" + confValue + "' </p>");

	$("#deleteBox").dialog('option', 'buttons', {
		"Confirm" : function() {
			$('form#' + formName).submit();
		},
			"Cancel" : function() {
				$(this).dialog("close");
			}
	});
}
//function to add call to sendbox
function sendConfirm(formName,confValue){
	$('#sendBox').html("<p>Are you sure you want to send password to '" + confValue + "' </p>");

	$("#sendBox").dialog('option', 'buttons', {
		"Send" : function() {
			$('form#' + formName).submit();
		},
			"Cancel" : function() {
				$(this).dialog("close");
			}
	});
}

var baseUrl = "<?php echo Yii::app()->request->baseUrl; ?>" + '/index.php/';
$(function(){

	var timeparam = {
		closeText : "Close",
			showSecond : false,
			currentText : "Now",
			timeText : "Time",
			hourText : "Hour",
			minuteText : "Minute"
	};

	//attributeValues
	//.installDatepicker({
	//dateFormat : "m/d/y"

	//});
	$( ".datepicker" ).datepicker({
		changeMonth: true,
			changeYear: true,
			dateFormat:'yy-mm-dd'
	});

	jQuery(".dateinput")
		.addClass(
			"ui-inputfield ui-widget ui-state-default ui-corner-all hasDatepicker");

	//jQuery("#ref-button")
	//.addClass("ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only")
	//.primebuttonhover();





});
</script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div id="deleteBox" title="Delete Confirmation">
	<p>Delete</p>
</div> 
<div id="sendBox" title="Send Password Confirmation">
	<p>Send</p>
</div> 
<div id="doc3">
<!--<div class="container" id="page">-->


	<div id="header" style="background-image:url(<?php echo Yii::app()->request->baseUrl;?>/<?php echo $storySettings->backgroundpath?>)">

	<div id="hd">
	   <a href='<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/Login'>
<img src="<?php echo Yii::app()->request->baseUrl; ?>/<?php echo $storySettings->logopath;?>" 
alt="link to landing page" /></a>
		<ul id="login">
			<li>
<?php
if (!Yii::app()->user->isGuest) {
	echo ucwords(Yii::app()->user->name);
}
?>
			</li>
			<li>
<?php
if (!Yii::app()->user->isGuest) {
	echo CHtml::link('Logout', array(
		'site/logout'
	));
}
?>
			</li>

		</ul>
	</div>
		<!--<div id="logo"><?php //echo CHtml::encode(Yii::app()->name);
?></div>-->
	</div><!-- header -->

	<div id="mainmenu">
	</div><!-- mainmenu -->
	<?php if (isset($this->breadcrumbs)) { ?>
<?php
	}
?>
<!-- Flash Messeage Display Area -->
<?php
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) {
	foreach ($flashMessages as $key => $message) {
		if ($key != 'error') {
			Yii::app()->clientScript->registerScript('myHideEffect', '$(".flash-' 
				. $key . '").animate({opacity: 1.0}, 5000).fadeOut("slow");', CClientScript::POS_READY);
			echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		} else {
			echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		}
	}
}
?>
<!-- End Flash Message Area -->

	<div id="bd">
	<?php echo $content; ?>
	</div>

<!--</div>--><!-- page -->

<div id="loginft">
<!-- footer -->
</div>

</div>
	<div id="footer">
		<?php echo $storySettings->name; ?>, version <?php echo $storySettings->version . ", " . date('Y'); ?>
		<?php echo Yii::t('translation', 'All rights reserved by '); ?> <a href='//www.tracetracker.com' target="_blank">
		<img src="<?php echo $baseUrl; ?>/images/tt_ft_logo.png" width="109" height="12" alt="Trace Tracker logo image" /></a> 
	</div>
</body>
</html>
