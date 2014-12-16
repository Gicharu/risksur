<?php
/**
 * TSettingsIni 
 * 
 * @uses CApplicationComponent
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 * @SuppressWarnings checkUnusedVariables
 */
class TSettingsIni extends CApplicationComponent {

	const LOG_CAT = "ext.TSettingsIni";
	public $resources = array();
	public $settings;
	
	
	/**
	 * init 
	 * 
	 * @access public
	 * @return void
	 */
	public function init() {
		$this->settings = new IniSettings();
		$this->settings->version = "local";
		$this->settings->version = "RISKSUR";
	}

	/**
	 * getSettings 
	 * 
	 * @access public
	 * @return void
	 */
	public function getSettings() {
		Yii::log("getSettings called", "trace", self::LOG_CAT);

		/*THIS PART OF CODE ENABLES USERS TO CONFIGURE WHAT LOGO THEY WANT. IT IMPLEMENTS THE CONFIG LEVELS
		AS DEFINED BY STORY-105 ON JIRA.*/
		$configParams = array();
		//$mds = Yii::app()->mdsresource;		
		/*DEFAULT VALUES*/
		$configParams['logopath'] = "images/logo_risksur.png";
		$configParams['backgroundpath'] = "images/headerBackground.png";
		$configParams['theme'] = "risksurTheme/jquery-ui-1.9.2.custom.css";
		$configParams['helpdocumentpath'] = "http://docs.tracetracker.com/story";
		$configParams['epcisNamespace'] = "http://www.globaltraceability.net/schema/epcis";
		$configParams['gtnetNamespace'] = "http://www.tracetracker.com/data";
		$configParams['legendbuttontext'] = "Legend";
		// $configParams['multipleComponentsRows'] = 5;

		// add [other] and [log] category params
		$customIniArray = self::getCustomIniParams();
		if(!empty($customIniArray['other']) && !empty($customIniArray['log'])) {
			// echo $customIniArray['other']['multipleComponentsRows'];die();
		// merge [other] and [log] categories
			$mergedIniParams = array_merge($customIniArray['other'], $customIniArray['log']);
			// add params to configParams array
			foreach ($mergedIniParams as $paramK => $paramV) {
				$configParams[$paramK] = $paramV;
			}
		} else {
			Yii::log("No [other] or [log] params set in story_custom.ini", "error", self::LOG_CAT);
		}
		$defaultThemeOnFail = "risksurTheme/jquery-ui-1.9.2.custom.css";

		/*ORGANIZATION VALUES. FIRST CHECK IF THE SESSION organization IS SET*/
		
		/*CHECK IF PATH TO THE THEME EXISTS. CHECK FOR BOTH URL AND NON-URL. SET DEFAULT TO $defaultThemeOnFail*/
		if (substr($configParams['theme'], 0, 4) == "http") {
			$file_headers = @get_headers($configParams['theme'], 1);
			
			if($file_headers[0] != 'HTTP/1.1 200 OK') {
				$configParams['theme'] = $defaultThemeOnFail;
			}
		} else {
			$rootPath = str_replace('index.php', '', Yii::app()->request->scriptFile);
			$rootPath = str_replace('snippet.php', '', $rootPath);
			$theme = $rootPath . "/css/themes/" . $configParams['theme'];
			if (file_exists($theme) === false) {
				$configParams['theme'] = $defaultThemeOnFail;
			}
		}

		//$settings = new IniSettings();
		$error = "";
		// Time To Live for cached values, 1 hour = 3600 seconds
		$ttl = 3600;

		//$iniArray = Yii::app()->EnvCache->get("storyIni" . Yii::app()->user->name);
		$iniArray = array();
		if($error == "" && is_array($iniArray) && count($iniArray) > 0) {  
			Yii::log("risksur.ini found in EnvCache", "trace", self::LOG_CAT);
		} else {
			$rootPath = str_replace('index.php', '', Yii::app()->request->scriptFile);
			$rootPath = str_replace('snippet.php', '', $rootPath);
			if (file_exists($rootPath . '/classes/resources/risksur.ini')) {
				//Yii::log("risksur.ini found for prod", "trace", self::LOG_CAT);
				$iniArray = parse_ini_file($rootPath . '/classes/resources/risksur.ini');
				//Yii::app()->EnvCache->set("storyIni" . Yii::app()->user->name, $iniArray, $ttl);
				//Yii::log("Stored to EnvCache: storyIni" . Yii::app()->user->name, "trace", self::LOG_CAT);

			} elseif (file_exists(Yii::app()->params['mainPath'] . '../resources/risksur.ini')) {
				//Yii::log("risksur.ini found for dev", "trace", self::LOG_CAT);
				$iniArray = parse_ini_file(Yii::app()->params['mainPath'] . '../resources/risksur.ini');
				// check if the values returned from risksur.ini are empty. If empty clear the iniArray to use default values
				if(!implode($iniArray)) {
					$iniArray = array();
					Yii::log("risksur.ini values are empty, default values used", "trace", self::LOG_CAT);
				} else {
					//Yii::app()->EnvCache->set("storyIni" . Yii::app()->user->name, $iniArray, $ttl);
					//Yii::log("Stored to EnvCache: storyIni" . Yii::app()->user->name, "trace", self::LOG_CAT);
				}
			} else {
				$error = "risksur.ini file not found";
				Yii::log($error, "warning", self::LOG_CAT);
			}
		}
		if ($error == "" && is_array($iniArray) && count($iniArray) > 0) {
			$this->settings->name = $iniArray['application.name'];
			$this->settings->version = $iniArray['application.version'];
			$this->settings->year = $iniArray['application.year'];
			//$this->settings->pentahoUser = $iniArray['pentaho.reportUser'];
			//$this->settings->pentahoServer = $iniArray['pentaho.server'];

			$this->settings->logopath = $configParams['logopath'];
			$this->settings->backgroundpath = $configParams['backgroundpath'];
			$this->settings->theme = $configParams['theme'];
			$this->settings->helpdocumentpath = $configParams['helpdocumentpath'];
			$this->settings->epcisNamespace = $configParams['epcisNamespace'];
			$this->settings->gtnetNamespace = $configParams['gtnetNamespace'];
			$this->settings->legendbuttontext = $configParams['legendbuttontext'];
			$this->settings->multipleComponentsRows = $configParams['multipleComponentsRows'];
			//$this->settings->pentahoServer = $iniArray['pentaho.server'];
		} else {
			$this->settings->error = $error;
			$this->settings->name = "(Unknown)";
			$this->settings->version = "(Unknown)";
			$this->settings->year = "(Unknown)";
			//$this->settings->pentahoUser = "(Unknown)";
			//$this->settings->pentahoServer = "(Unknown)";
			$this->settings->logopath = $configParams['logopath'];
			$this->settings->backgroundpath = $configParams['backgroundpath'];
			$this->settings->theme = $configParams['theme'];
			$this->settings->helpdocumentpath = $configParams['helpdocumentpath'];
			$this->settings->epcisNamespace = $configParams['epcisNamespace'];
			$this->settings->gtnetNamespace = $configParams['gtnetNamespace'];
			$this->settings->legendbuttontext = $configParams['legendbuttontext'];
			$this->settings->multipleComponentsRows = $configParams['multipleComponentsRows'];
		}
		return $this->settings;
	}
	
	/**
	 * generate 
	 * 
	 * @param mixed $userName 
	 * @param mixed $password 
	 * @access public
	 * @return void
	 */
	public function generate($userName, $password) {
		$hashsalt = "{" . $userName . "}";
		$hashPassword = $password;
		$ssha = hash('sha256', $hashPassword . $hashsalt);
		return $ssha;
	}

	/**
	 * getConfigXmlFile 
	 * 
	 * @access public
	 * @return void
	 */
	public function getConfigXmlFile() {
		$error = "";
		$rootPath = str_replace('index.php', '', Yii::app()->request->scriptFile);
		$rootPath = str_replace('snippet.php', '', $rootPath);
		$configVariables = new IniSettings();
		$xmlPaths = array();
		
		if (file_exists($rootPath . '/classes/resources/baseline_MDD_config.xml')) {
			$configVariables->mddConfigXml = file($rootPath . '/classes/resources/baseline_MDD_config.xml');
			Yii::log("Found baseline_MDD_config.xml in DEV", "trace", self::LOG_CAT);
		} elseif (file_exists(Yii::app()->params['mainPath'] . '../resources/baseline_MDD_config.xml')) {
			$configVariables->mddConfigXml = file(Yii::app()->params['mainPath'] . '../resources/baseline_MDD_config.xml');
			Yii::log("Found baseline_MDD_config.xml in PROD", "trace", self::LOG_CAT);
		} elseif (file_exists(Yii::app()->params['mainPath'] . '../../resources/baseline_MDD_config.xml')) {
			$configVariables->mddConfigXml = file(Yii::app()->params['mainPath'] . '../../resources/baseline_MDD_config.xml');
			Yii::log("Found baseline_MDD_config.xml in LOCAL", "trace", self::LOG_CAT);
		} else {
			$configVariables->mddConfigXml = "";
			$error = "FATAL: Did not find baseline_MDD_config.xml";
			Yii::log($error, "error", self::LOG_CAT);
		}


		if (file_exists($rootPath . '/classes/resources/baseline_config.xml')) {
			$configVariables->baselineConfigXml = file($rootPath . '/classes/resources/baseline_config.xml');
			Yii::log("Found baseline_config.xml in DEV", "trace", self::LOG_CAT);
		} elseif (file_exists(Yii::app()->params['mainPath'] . '../resources/baseline_config.xml')) {
			$configVariables->baselineConfigXml = file(Yii::app()->params['mainPath'] . '../resources/baseline_config.xml');
			Yii::log("Found baseline_config.xml in PROD", "trace", self::LOG_CAT);
		} elseif (file_exists(Yii::app()->params['mainPath'] . '../../resources/baseline_config.xml')) {
			$configVariables->baselineConfigXml = file(Yii::app()->params['mainPath'] . '../../resources/baseline_config.xml');
			Yii::log("Found baseline_config.xml in LOCAL", "trace", self::LOG_CAT);
		} else {
			$configVariables->baselineConfigXml = "";
			$error = "FATAL: Did not find baseline_config.xml";
			Yii::log($error, "error", self::LOG_CAT);
		}


		if (file_exists($rootPath . '/classes/resources/baseline_org_config.xml')) {
			$configVariables->baselineOrgConfigXml = file($rootPath . '/classes/resources/baseline_org_config.xml');
			Yii::log("Found baseline_org_config.xml in DEV", "trace", self::LOG_CAT);
		} elseif (file_exists(Yii::app()->params['mainPath'] . '../resources/baseline_org_config.xml')) {
			$configVariables->baselineOrgConfigXml = file(Yii::app()->params['mainPath'] . '../resources/baseline_org_config.xml');
			Yii::log("Found baseline_org_config.xml in PROD", "trace", self::LOG_CAT);
		} elseif (file_exists(Yii::app()->params['mainPath'] . '../../resources/baseline_org_config.xml')) {
			$configVariables->baselineOrgConfigXml = file(Yii::app()->params['mainPath'] . '../../resources/baseline_org_config.xml');
			Yii::log("Found baseline_org_config.xml in LOCAL", "trace", self::LOG_CAT);
		} else {
			$configVariables->baselineOrgConfigXml = "";
			$error = "FATAL: Did not find baseline_org_config.xml";
			Yii::log($error, "error", self::LOG_CAT);
		}


		if (file_exists($rootPath . '/classes/resources/deleted_config.xml')) {
			$configVariables->deletedConfigXml = file($rootPath . '/classes/resources/deleted_config.xml');
			Yii::log("Found deleted_config.xml in DEV", "trace", self::LOG_CAT);
		} elseif (file_exists(Yii::app()->params['mainPath'] . '../resources/deleted_config.xml')) {
			$configVariables->deletedConfigXml = file(Yii::app()->params['mainPath'] . '../resources/deleted_config.xml');
			Yii::log("Found deleted_config.xml in PROD", "trace", self::LOG_CAT);
		} elseif (file_exists(Yii::app()->params['mainPath'] . '../../resources/deleted_config.xml')) {
			$configVariables->deletedConfigXml = file(Yii::app()->params['mainPath'] . '../../resources/deleted_config.xml');
			Yii::log("Found deleted_config.xml in LOCAL", "trace", self::LOG_CAT);
		} else {
			$configVariables->deletedConfigXml = "";
			$error = "FATAL: Did not find deleted_config.xml";
			Yii::log($error, "error", self::LOG_CAT);
		}


		if (file_exists($rootPath . '/classes/resources/deleted_org_config.xml')) {
			$configVariables->deletedOrgConfigXml = file($rootPath . '/classes/resources/deleted_org_config.xml');
			Yii::log("Found deleted_org_config.xml in DEV", "trace", self::LOG_CAT);
		} elseif (file_exists(Yii::app()->params['mainPath'] . '../resources/deleted_org_config.xml')) {
			$configVariables->deletedOrgConfigXml = file(Yii::app()->params['mainPath'] . '../resources/deleted_org_config.xml');
			Yii::log("Found deleted_org_config.xml in PROD", "trace", self::LOG_CAT);
		} elseif (file_exists(Yii::app()->params['mainPath'] . '../../resources/deleted_org_config.xml')) {
			$configVariables->deletedOrgConfigXml = file(Yii::app()->params['mainPath'] . '../../resources/deleted_org_config.xml');
			Yii::log("Found deleted_org_config.xml in LOCAL", "trace", self::LOG_CAT);
		} else {
			$configVariables->deletedOrgConfigXml = "";
			$error = "FATAL: Did not find deleted_org_config.xml";
			Yii::log($error, "error", self::LOG_CAT);
		}


		if (file_exists($rootPath . '/classes/resources/deleted_node_config.xml')) {
			$configVariables->deletedNodeConfigXml = file($rootPath . '/classes/resources/deleted_node_config.xml');
			Yii::log("Found deleted_node_config.xml in DEV", "trace", self::LOG_CAT);
		} elseif (file_exists(Yii::app()->params['mainPath'] . '../resources/deleted_node_config.xml')) {
			$configVariables->deletedNodeConfigXml = file(Yii::app()->params['mainPath'] . '../resources/deleted_node_config.xml');
			Yii::log("Found deleted_node_config.xml in PROD", "trace", self::LOG_CAT);
		} elseif (file_exists(Yii::app()->params['mainPath'] . '../../resources/deleted_node_config.xml')) {
			$configVariables->deletedNodeConfigXml = file(Yii::app()->params['mainPath'] . '../../resources/deleted_node_config.xml');
			Yii::log("Found deleted_node_config.xml in LOCAL", "trace", self::LOG_CAT);
		} else {
			$configVariables->deletedNodeConfigXml = "";
			$error = "FATAL: Did not find deleted_node_config.xml";
			Yii::log($error, "error", self::LOG_CAT);
		}


		if (file_exists($rootPath . '/classes/resources/baseline_node_config.xml')) {
			$configVariables->baselineNodeConfigXml = file($rootPath . '/classes/resources/baseline_node_config.xml');
			Yii::log("Found baseline_node_config.xml in DEV", "trace", self::LOG_CAT);
		} elseif (file_exists(Yii::app()->params['mainPath'] . '../resources/baseline_node_config.xml')) {
			$configVariables->baselineNodeConfigXml = file(Yii::app()->params['mainPath'] . '../resources/baseline_node_config.xml');
			Yii::log("Found baseline_node_config.xml in PROD", "trace", self::LOG_CAT);
		} elseif (file_exists(Yii::app()->params['mainPath'] . '../../resources/baseline_node_config.xml')) {
			$configVariables->baselineNodeConfigXml = file(Yii::app()->params['mainPath'] . '../../resources/baseline_node_config.xml');
			Yii::log("Found baseline_node_config.xml in LOCAL", "trace", self::LOG_CAT);
		} else {
			$configVariables->baselineNodeConfigXml = "";
			$error = "FATAL: Did not find baseline_node_config.xml";
			Yii::log($error, "error", self::LOG_CAT);
		}

		$xmlPaths['mdd'] = $configVariables->mddConfigXml;
		$xmlPaths['baseline'] = $configVariables->baselineConfigXml;
		$xmlPaths['baselineOrg'] = $configVariables->baselineOrgConfigXml;
		$xmlPaths['deleted'] = $configVariables->deletedConfigXml;
		$xmlPaths['deletedOrg'] = $configVariables->deletedOrgConfigXml;
		$xmlPaths['deletedNodeConfig'] = $configVariables->deletedNodeConfigXml;
		$xmlPaths['baselineNode'] = $configVariables->baselineNodeConfigXml;
		$xmlPaths['temporaryFilePath'] = $configVariables->temporaryFilePath;

	return $xmlPaths;

	}
	/**
	 * processJavaScriptIncludes 
	 * 
	 * @param mixed $pathArray 
	 * @access public
	 * @return void
	 */
	public function processJavaScriptIncludes($pathArray) {
		// add the javascript include files to the page
		$versionValue = "?v=" . trim($this->settings->version);
		echo '<!-- Include javascript files-->' . "\n";
		$baseUrl = Yii::app()->request->baseUrl;
		foreach ($pathArray as $jsPath) {
			$jsPath = $baseUrl . $jsPath . $versionValue;
			echo '<script type="text/javascript" src="' . $jsPath . '"></script>' . "\n";
		}
	}

	/**
	 * processCssIncludes 
	 * 
	 * @param mixed $pathArray 
	 * @access public
	 * @return void
	 */
	public function processCssIncludes($pathArray) {

		// add the css include files to the page
		$versionValue = "?v=" . trim($this->settings->version);
			echo '<!-- Include css files-->' . "\n";
		foreach($pathArray as $cssPath => $media) {
			$cssPath = $cssPath . $versionValue;
			if ($media != "noMedia") {
				$mediaValue = 'media="' . $media . '"';
			} else {
				$mediaValue = "";
			}
			echo '<link rel="stylesheet" type="text/css" href="' . $cssPath . '" ' . $mediaValue . '/>' . "\n";
		}
	}
	/**
	 * getCustomIniParams 
	 * @return array
	 */
	private function getCustomIniParams() {
		Yii::log("getCustomIniParams called", "trace", self::LOG_CAT);
		$iniArray = array();
		$ttl = 3600;
		$error = '';
		$iniArray = Yii::app()->EnvCache->get("risksurCustomIni" . Yii::app()->user->name);
		if(is_array($iniArray) && count($iniArray) > 0) {  
			Yii::log("risksur_custom.ini found in EnvCache", "trace", self::LOG_CAT);
		} else {
			$rootPath = str_replace('index.php', '', Yii::app()->request->scriptFile);
			$rootPath = str_replace('snippet.php', '', $rootPath);
			if (file_exists($rootPath . '/classes/resources/risksur_custom.ini')) {
				$iniArray = parse_ini_file($rootPath . '/classes/resources/risksur_custom.ini', true);
				Yii::app()->EnvCache->set("risksurCustomIni" . Yii::app()->user->name, $iniArray, $ttl);
				Yii::log("Stored to EnvCache: risksurCustomIni" . Yii::app()->user->name, "trace", self::LOG_CAT);
				
			} elseif (file_exists(Yii::app()->params['mainPath'] . '../resources/risksur_custom.ini')) {
				$iniArray = parse_ini_file(Yii::app()->params['mainPath'] . '../resources/risksur_custom.ini', true);
				// check if the values returned from risksur_custom.ini are empty. If empty clear the iniArray to use default values
				if(count($iniArray) > 0) {
					Yii::app()->EnvCache->set("risksurCustomIni" . Yii::app()->user->name, $iniArray, $ttl);
					Yii::log("Stored to EnvCache: risksurCustomIni" . Yii::app()->user->name, "trace", self::LOG_CAT);
				} else {
					$iniArray = array();
					Yii::log("risksur_custom.ini values are empty", "warning", self::LOG_CAT);
				}
			} elseif (file_exists(Yii::app()->params['mainPath'] . '../../resources/risksur_custom.ini')) {
				$iniArray = parse_ini_file(Yii::app()->params['mainPath'] . '../../resources/risksur_custom.ini', true);
				// check if the values returned from risksur_custom.ini are empty. If empty clear the iniArray to use default values
				if(count($iniArray) > 0) {
					Yii::app()->EnvCache->set("risksurCustomIni" . Yii::app()->user->name, $iniArray, $ttl);
					Yii::log("Stored to EnvCache: risksurCustomIni" . Yii::app()->user->name, "trace", self::LOG_CAT);
				} else {
					$iniArray = array();
					Yii::log("risksur_custom.ini values are empty", "warning", self::LOG_CAT);
				}
			} else {
				$error = "risksur_custom.ini file not found";
				Yii::log($error, "error", self::LOG_CAT);
			}
		}		
		
		return $iniArray;
	}
}
/**
 * IniSettings 
 * 
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class IniSettings {
	public $error;
	public $appName;
	public $appVersion;
	public $appYear;
	//public $pentahoUser;

	public $logopath;
	public $backgroundpath;
	public $theme;
	public $helpdocumentpath;
	public $epcisNamespace;
	public $gtnetNamespace;
	public $legendbuttontext;

	public $mddConfigXml;
	public $baselineConfigXml;
	public $baselineOrgConfigXml;
	public $deletedConfigXml;
	public $deletedOrgConfigXml;
	public $deletedNodeConfigXml;
	public $baselineNodeConfigXml;
	public $xmlPaths;
	public $temporaryFilePath;

	public $maxPageSizeObjectQuery;
}
?>
