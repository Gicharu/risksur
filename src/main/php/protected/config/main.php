<?php
/*GET THE PATH TO THE CURRENT FILE main.php
REMOVE 17 CHARACTERS FROM RIGHT TO LEFT I.E. \protected\config
REPLACE ALL \ WITH %
REPLACE ALL / WITH %
REMOVE THE : FROM THE PATH
SET THE NEW PATH TO THE CACHE*/
$cachePath = dirname(__FILE__);
$cachePath = substr($cachePath, 0, -17);
$cachePath = str_replace("\\", "%", $cachePath);
$cachePath = str_replace("/", "%", $cachePath);
$cachePath = str_replace(":", "", $cachePath);
$cachePath = "/tmp/cache/". $cachePath;

	$iniArray =  array();
	$filePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
	if (file_exists('/classes/resources/risksur_custom.ini')) {
		// path for ini for unit tests
		$iniArray = parse_ini_file($filePath . '/classes/resources/risksur_custom.ini', true);
	} elseif (file_exists($filePath . '../resources/risksur_custom.ini')) {
		// path for ini for production
		$iniArray = parse_ini_file($filePath . '../resources/risksur_custom.ini', true);
	} elseif (file_exists($filePath . '../../resources/risksur_custom.ini')) {
		// path for ini for local
		$iniArray = parse_ini_file($filePath . '../../resources/risksur_custom.ini', true);
	}
// initialize the config array and the log setting array
$configArray = array();
$logArray = array(
	'class' => 'CFileLogRoute',
	'filter' => array(
		'class' => 'LogFilter',
		'prefixSession' => false,
		'prefixUser' => true,
		'logUser' => false,
		'logVars' => array(),
	),
);
// generate the config and log array settings from the risksur_custom.ini file
foreach ($iniArray as $key => $val) {
	foreach ($val as $id => $value) {
		if ($key == "other") {
			$keyParam = str_replace(".", "", $id);
			$configArray['params'][$key][$keyParam] = $value;
		} else if ($key == "log") {
			$keyParam = str_replace("log.", "", $id);
			$logArray[$keyParam] = $value;
		} else if ($key == "database") {
			$keyParam = str_replace(".", "", $id);
			$configArray['components']['db'][$keyParam] = $value;
		} else {
			$keyParam = str_replace($key . ".", "", $id);
			$configArray['params'][$key][$keyParam] = $value;
		}
	}
}
// add the log route settings from risksur_custom.ini
$configArray['components']['log']['routes'][] = $logArray;
return CMap::mergeArray($configArray, array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'Risksur',
	'defaultController' => 'site/login',
	'sourceLanguage' => 'en',
	// 'language' => 'bs',
	// preloading 'log' component
	'preload' => array(
		'log',
		'session'
	),
	// autoloading model and component classes
	'import' => array(
		'application.models.*',
		'application.components.*',
		'application.extensions.EActiveResource.*',
		'application.extensions.TLogResource.*',
		//'application.extensions.EpitoolsFunctions.*',
		'application.extensions.TSettingsIni.*',
		'application.extensions.TTMailer.*',
		'application.extensions.Encryption.*',
//		'application.extensions.WizardBehaviour.*',
		//'application.extensions.TKmlResource.*',
		/*'application.extensions.timeout-dialog.*',*/
		'application.controllers.*',
	),
	'modules' => array(
		// uncomment the following to enable the Gii tool
		 'gii' => array(
		 	'class' => 'system.gii.GiiModule',
		 	'password' => 'cdosh!',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
		 	'ipFilters' => array(
		 		'127.0.0.1',
		 		'::1'
		 	),
		 ),
	),
	// application components
	'components' => array(
		'errorHandler' => array(
			// use 'site/error' action to display errors
			'errorAction' => 'site/error',
		),
		'EnvCache' => array(
			'class' => 'system.caching.CFileCache',
			'cachePath' => $cachePath . '/Env',
			'hashKey' => 'false',
		),
		'session' => array(
			'sessionName' => 'risksurSession',
			'class' => 'CHttpSession',
			//'class' => 'CDbHttpSession',
			'autoStart' => true,
			//8 hrs timeout
			'timeout' => 28800,
			//'timeout' => 300,

		),
		'user' => array(
			'class' => 'WebUser',
			'loginRequiredAjaxResponse' => 'YII_LOGIN_REQUIRED',
			//8 hrs timeout
			'authTimeout' => 28800,
			// enable cookie-based authentication
			'allowAutoLogin' => true,
			//'returnUrl' => 'shipments/index',
		),
		// uncomment the following to enable URLs in path-format
		'urlManager' => array(
			'urlFormat' => 'path',
			'showScriptName' => true,
			'rules' => array(
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
			),
		),
		'rbac' => array(
			'class' => 'application.components.Rbac',
		),
		//'db'=>array(
		//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		//),
		// uncomment the following to use a MySQL database
		'db' => array(
			'emulatePrepare' => true,
			'enableParamLogging' => true,
			// 'enableProfiling' => true,
		),
		'errorHandler' => array(
			// use 'site/error' action to display errors
			'errorAction' => 'site/error',
		),
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
			)
		),
		'authManager' => array(
			'class' => 'CDbAuthManager',
			'defaultRoles' => array(
				'authenticated',
				'guest'
			),
		),
		'tsettings' => array(
			'class' => 'TSettingsIni',
			'resources' => array(),
		),
		'encryption' => array(
			'class' => 'Encryption',
		),
		//'ldapresource' => array(
			//'class' => 'TLdapResource',
			////'resources' => array(
			////),
		//),
		'mailresource' => array(
			'class' => 'TTMailer',
			'resources' => array(
			),
		),
		'clientScript' => array(
			'scriptMap' => array(
				// disable the default scripts and css
				'jquery.js' => false,
				'jquery-ui.min.js' => false,
				'jquery-ui.css' => false,
			)
		),
		//'loid' => array(
			////alias to dir, where you unpacked extension
			//'class' => 'application.extensions.lightopenid.loid',
		//),
	),
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
		'params' => array(
			// this is used in contact page
			'adminEmail' => 'info@tracetracker.com',
			// 'pngUrl' => ''
			'mainPath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR,
			'headerErrorSummary' => "<div class='ui-widget'><div class='ui-state-error ui-corner-all'><p> <strong>Error Summary: </strong>" . 
				"<span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>",
			'footerErrorSummary' => "</p></div></div>",
			'AdminUrl' => (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : exec("hostname"),
			// 'wwwPath' => $wwwPath,
		),
		//'runtimePath' => sys_get_temp_dir(),
	)
);
