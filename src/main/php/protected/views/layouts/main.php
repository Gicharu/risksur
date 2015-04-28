<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<?php
	$localeSession = isset(Yii::app()->session['locale']) ? Yii::app()->session['locale'] : 'en';
	Yii::app()->setLanguage($localeSession);

	$settings = Yii::app()->tsettings;
	$storySettings = $settings->getSettings();
	
	$baseUrl = Yii::app()->request->baseUrl;
	// array of css include paths with media types
	$cssArray = array(
		$baseUrl . "/css/print.css" => "print",
		$baseUrl . "/css/jquery.menubar.css" => "noMedia",
		$baseUrl . "/css/form.css" => "noMedia",
		$baseUrl . "/css/screen.css" => "noMedia",
		$baseUrl . "/libraries/chosen_v1.3.0/chosen.css" => "noMedia",
		$baseUrl . "/css/showLoading.css" => "noMedia",
		$baseUrl . "/css/jquery.dataTables.css" => "all",
		$baseUrl . "/libraries/DataTables-1.9.4/media/css/jquery.dataTables.css" => "all",
		$baseUrl . "/libraries/DataTables-1.9.4/extras/TableTools/media/css/TableTools.css" => "all",
		$baseUrl . "/css/jquery.selectBoxIt.css" => "all",
		$baseUrl . "/css/risksurstyle.css" => "noMedia", 

	);
	// array of javascript include paths
	$javaScriptArray = array(
		"/libraries/jquery-1.8.3/jquery-1.8.3.min.js",
		"/libraries/jquery-ui-1.9.2/jquery-ui-1.9.2.custom.min.js",
		"/libraries/jquery-menubar/jquery.menubar.js",
		"/libraries/DataTables-1.9.4/media/js/jquery.dataTables.js",
		"/libraries/jquery-datatables-third-party/jquery.dataTables.columnFilter.js",
		"/libraries/jquery-datatables-third-party/jquery.dataTables.customPagination.js",
		"/libraries/jquery-datatables-third-party/jquery.dataTables.customListbox.js",
		"/libraries/jquery-datatables-third-party/jquery.dataTables.buttons_input.js",
		//"/libraries/DataTables-1.9.4/extras/TableTools/media/js/TableTools.js",
		// TableTools version 2.1.6-dev supports exporting visible rows to PDF / CSV
		"/libraries/TableTools-2.1.6-dev/TableTools.js",
		"/libraries/DataTables-1.9.4/extras/TableTools/media/js/ZeroClipboard.js",
		"/libraries/DataTables-1.9.4/extras/Scroller/media/js/dataTables.scroller.min.js",
		//"/libraries/history.js/scripts/bundled/html4+html5/jquery.history.js",
		"/js/scripts/main_ui_functions.js",
		"/js/common.js",
		"/libraries/jquery-showloading-1.0/jquery.showLoading.js",
		"/libraries/jsTimezoneDetect-1.0.4/jstz.min.js",
		"/libraries/chosen_v1.3.0/chosen.jquery.js",

	);
	// add the theme to the cssArray
	$themePath = $baseUrl . "/css/themes/" . $storySettings->theme;
	if (substr($storySettings->theme, 0, 4) == "http") {
		$themePath = $storySettings->theme;
	}	
	$cssArray[$themePath] = "noMedia";
	?>
	<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta charset="UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $baseUrl; ?>/favicon.ico" />
<?php
	// add the css include files to the page
	$settings->processCssIncludes($cssArray);
	// add the javascript include files to the page
	$settings->processJavaScriptIncludes($javaScriptArray);
?>

	<script type="text/javascript">

//function to add call deletebox 
//function deleteConfirm(formName,confValue){
//	$('#deleteBox').html("<p><?php //echo Yii::t('translation', 'Are you sure you want to delete')?>// '" + confValue + "' </p>");
//
//	$("#deleteBox").dialog('option', 'buttons', {
//		"Confirm" : function() {
//			$('form#' + formName).submit();
//		},
//			"Cancel" : function() {
//				$(this).dialog("close");
//			}
//	});
//}
//function disableConfirm(formName,confValue){
//	$('#deleteBox').html("<p><?php //echo Yii::t('translation', 'Are you sure you want to delete')?>// '" + confValue + "' </p>");
//
//	$("#deleteBox").dialog('option', 'buttons', {
//		"Confirm" : function() {
//			$('form#' + formName).submit();
//		},
//			"Cancel" : function() {
//				$(this).dialog("close");
//			}
//	});
//}
// new design function
function addNewDesign() {
	var data=$("#newDesignForm").serialize();
	$.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->createAbsoluteUrl("context/create"); ?>',
		data:data,
		success:function(data){
				// reset the form if success
				var checkSuccess = /successfully/i;
				if (checkSuccess.test(data)) {
				// add process message
				$("#msgsNewDesign").html(data).attr('class', 'flash-success');
					$("form#newDesignForm")[0].reset();
					$("#newDesignDialog").dialog("close");
				}

		},
		error: function(data) { // if error occured
		console.log("Error occured.please try again");
		console.log(data);
		},
		dataType:'html'
	});
}
var baseUrl = "<?php echo $baseUrl; ?>" + '/index.php/';
$(function(){
	$("#menu").menu({
		position: {at: "left bottom"}
	});
 
	var timeparam = {
		closeText : "Close",
			showSecond : false,
			currentText : "Now",
			timeText : "Time",
			hourText : "Hour",
			minuteText : "Minute"
	};

	$( ".datepicker" ).datepicker({
		changeMonth: true,
			changeYear: true,
			dateFormat:'mm-dd-yy'
	});


	$(".dateinput")
		.addClass(
			"ui-inputfield ui-widget ui-state-default ui-corner-all hasDatepicker");

<?php
	//print_r(Yii::app()->user->isGuest);
	//print_r(Yii::app()->components);
	//print_r(Yii::app()->components['user']);
	//logout when session expires in ajax call
	if (Yii::app()->user->loginRequiredAjaxResponse) {
		Yii::app()->clientScript->registerScript('ajaxLoginRequired', '
		jQuery("body").ajaxComplete(
			function(event, request, options) {
				if (request.responseText == "'.Yii::app()->user->loginRequiredAjaxResponse.'") {
					//window.location.href = options.url;
					window.location.href = "'.Yii::app()->createUrl('/site/login?inactive=1').'"
				}
			}
		);
		');
	}
?>
	
	


	// Tabs
	$('#tabs').tabs();
	//hover states on the static widgets
	$('#dialog_link, ul#icons li').hover(
		function() { $(this).addClass('ui-state-hover'); },
		function() { $(this).removeClass('ui-state-hover'); }
	);

});
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
<style type="text/css">
  /* css to overide some styles */
	.ui-tabs .ui-tabs-panel { 
		padding : 2px;
	}
</style>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div id="deleteBox" title="Delete Confirmation" style="display:none">
	<p><?php echo Yii::t("translation", "Delete")?></p>
</div>
<div id="sendBox" title="Confirm Status Change">
	<p><?php echo Yii::t("translation", "Disable")?></p>
</div>

<div id="doc3">
<!--<div class="container" id="page">-->
<?php
if (!Yii::app()->user->isGuest) {
?>
	<div id="top_header">
		<ul id="login">
			<li id="ttlogo"><a href='//www.tracetracker.com' target="_blank">
			<img src="<?php echo $baseUrl; ?>/images/tt_logo.png" 
				width="129" height="16" alt="trace tracker logo" />
			</a></li>
			<li>
<?php
	echo CHtml::htmlButton(Yii::t('translation', 'Logout'), array(
		'submit' => array(
			'site/logout'
		),
		'type' => 'submit'
	));
?>
			</li>



			<li id="userName">
				<div title="<?php echo Yii::app()->user->name;?>"><?php echo Yii::app()->user->name;?></div>
			</li>
		</ul>
	</div>
	<?php
	}
	?>

	<div id="header">
		<div id="logo">
			<a href='<?php echo $baseUrl; ?>/index.php/context/list'>
				<img src="<?php echo $baseUrl; ?>/<?php echo $storySettings->logopath;?>"
					 alt="link to landing page" />
			</a>
		</div>
	<div id="designName">
	<?php
		$activeDesignAction = 'Select';
		$activeDesignName = '';
		if (!empty(Yii::app()->session['surDesign'])) {
			$activeDesignName = Yii::app()->session['surDesign']['name'] . ' - ';
			$activeDesignAction = 'Change';
		}
		echo "Selected Surveillance System: $activeDesignName <a href='" . Yii::app()->createUrl("context/list") . "'>$activeDesignAction</a>";
	?>
	</div>
	<div id="evalName">
	<?php
		if (!empty(Yii::app()->session['evaContext']) && Yii::app()->controller->id == 'evaluation') {
			echo "Selected Evaluation Context: " . Yii::app()->session['evaContext']['name'];
		}
	?>
	</div>
	<div id="attributeSelected">
	<?php
		if (Yii::app()->controller->id <> 'evaluation') {
			$activeAttributeName = '';
			$activeAttributeAction = 'Select';
			if (!empty(Yii::app()->session['performanceAttribute'])) {
				$activeAttributeName = Yii::app()->session['performanceAttribute']['name'] . ' - ';
				$activeAttributeAction = 'Change';
			}
			echo "Selected Performance Attribute: $activeAttributeName <a href='" . Yii::app()->createUrl("attribute/selectAttribute") . "'>$activeAttributeAction</a>";
		}
	?>
	</div>
	</div><!-- header -->

<?php
if (!Yii::app()->user->isGuest) {
?>
	<div id="mainmenu">
	<?php 
		$this->widget('application.components.MainMenu', array(
		'parentId' => 0
	)); 
	?>
	</div>
	<?php
}
	?>
	<!-- mainmenu -->
<!-- Flash Messeage Display Area -->
<?php
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) {
	foreach ($flashMessages as $key => $message) {
		//if ($key == 'error') {
			//Yii::app()->clientScript->registerScript(
				//'myHideEffect', 
				//'$(".flash-' . $key . '").animate({opacity: 1.0}, 180000).fadeOut("slow");',
				//CClientScript::POS_READY
				//);
			//echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		//} else {
			echo '<div id="flashMsgWrapper" class="flash-' . $key . '">' . $message . 
				'<input id = "closeButtonFlash" class="ui-icon ui-icon-closethick" type="button" value="close" />'."</div>\n";
				//}
	}
}
?>
<div id="ajaxFlashMsgWrapper" class="flash-error" style="display:none">
	<span id="ajaxFlashMsg"></span><input id = "closeButtonAjax" class="ui-icon ui-icon-closethick" type="button" value="close" />
</div>
<!-- End Flash Message Area -->
	<div id="bd" >
	<?php echo $content; ?>
	</div>

<!--</div>--><!-- page -->

<div id="loginft">
<!-- footer -->
</div>

</div>
	<div id="footer" style="width:100%; float:right;">
		<!-- <?php //echo $storySettings->name; ?>, <?php //echo Yii::t('translation', 'version ') . $storySettings->version . ", " . date('Y'); ?> -->
		<?php echo Yii::t('translation', 'Risksur, version '. $storySettings->version . ", " . date('Y') .', Powered by '); ?> <a href='//www.tracetracker.com'
		 target="_blank">
<img src="<?php echo $baseUrl; ?>/images/tt_ft_logo.png" width="109" 
	height="12" alt="Trace Tracker logo image" />
</a>  
	</div>

</body>
</html>
