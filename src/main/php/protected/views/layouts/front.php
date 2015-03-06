<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<?php 
		$settings = Yii::app()->tsettings;
		$baseUrl = Yii::app()->request->baseUrl;
		// array of css include paths with media types
		$cssArray = array(
			$baseUrl . "/css/reset-fonts-grids.css" => "noMedia",
			$baseUrl . "/css/themes/risksurTheme/jquery-ui-1.9.2.custom.min.css" => "all",
			$baseUrl . "/css/ttstylelogin.css" => "noMedia",
		);
		// add the theme to the cssArray
		$storySettings = $settings->getSettings();
		//$themeSettings = $storySettings->theme;
		//$themePath = $baseUrl . "/css/themes/" . $themeSettings;
		//if (substr($themeSettings, 0, 4) == "http") {
		//$themePath = $themeSettings;
		//}
		//$cssArray[$themePath] = "noMedia";
		// array of javascript include paths
		$javaScriptArray = array(
			"/libraries/jquery-1.8.3/jquery-1.8.3.min.js",
			"/libraries/jquery-ui-1.9.1/jquery-ui-1.9.1.custom.min.js",
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
<script>
$(function() {
	$( 'button').button();

});
</script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div id="doc3">
<div class="container" id="page">

<!-- header -->

	<div id="mainmenu">
<?php
// if not logged in, dont show the menu.
if (!Yii::app()->user->isGuest) {
	$this->widget('zii.widgets.CMenu', array(
		'items' => array(
			array(
				'label' => 'Home',
				'url' => array(
					'/site/index'
				)
			),
			array(
				'label' => 'About',
				'url' => array(
					'/site/page',
					'view' => 'about'
				)
			),
			array(
				'label' => 'Contact',
				'url' => array(
					'/site/contact'
				)
			),
			array(
				'label' => Yii::t('translation', 'Login'),
				'url' => array(
					'/site/login'
				),
				'visible' => Yii::app()->user->isGuest
			),
			array(
				'label' => 'Logout (' . Yii::app()->session['displayName'] . ')',
				'url' => array(
					'/site/logout'
				),
				'visible' => !Yii::app()->user->isGuest
			)
		),
	));
}
?>
	<!-- Flash Messeage Display Area -->
<?php
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) {
	foreach ($flashMessages as $key => $message) {
		if ($key != 'error') {
			Yii::app()->clientScript->registerScript('myHideEffect', '$(".flash-' . 
				$key . '").animate({opacity: 1.0}, 5000).fadeOut("slow");', CClientScript::POS_READY);
			echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		} else {
			echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		}
	}
}
if (isset($_GET['inactive']) && Yii::app()->user->isGuest) {
	echo "<div class='flash-notice'>You have been logged out due to a period of inactivity</div>\n";
	//
}
?>
<!-- End Flash Message Area -->
	</div><!-- mainmenu -->
	<?php echo $content; ?>

</div><!-- page -->
</div>
<div id="loginft">
	<div id="footer">
		<!-- <?php //echo $storySettings->name; ?>, <?php //echo Yii::t('translation', 'version ') . $storySettings->version . ", " . date('Y'); ?> -->
		<?php echo Yii::t('translation', 'Risksur, version '. $storySettings->version . ", " . date('Y').', Powered by '); ?> <a href='//www.tracetracker.com' target="_blank">
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/tt_ft_logo.png" width="109" height="12" alt="Trace Tracker logo image" /></a>
	</div><!-- footer -->
</div>

</body>
</html>
