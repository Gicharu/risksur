<?php
//error_reporting(E_ALL);
/**
 * AdminController 
 * 
 * @uses Controller
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class AdminController extends Controller {
	public $page;
	private $mds;
	private $dashboard;
	private	$configuration;
	//private $ldap;
	const LOG_CAT = "ctrl.AdminController";
	/**
	 * @return array action filters
	 */
	public function filters() {
		//return array(
		//'accessControl', // perform access control
		//);
		return array(
			array(
				'application.filters.RbacFilter',
			),
		);
	}
	/**
	 * init 
	 * 
	 * @access public
	 * @return void
	 */
	public function init() {
		$this->dashboard = Yii::app()->dashboardresource;
		$this->mds = Yii::app()->mdsresource;
		$this->configuration = Yii::app()->tsettings;

	}
	/**
	 * actionPreferences
	 * @return void
	 */
	public function actionPreferences() {
		$model = new UserPreferencesForm;
		$this->pageTitle = Yii::app()->name . " - User Preferences";
		$localeSession = isset(Yii::app()->session['locale']) ? Yii::app()->session['locale'] : 'en';
		Yii::app()->setLanguage($localeSession);
		$model->dateFormat = Yii::app()->session['dateFormat'];
		$model->timeFormat = Yii::app()->session['timeFormat'];
		$dateFormatDropDown = array();
		// $dateFormatDropDown[''] = '';
		$dateFormatDropDown["Y-m-d H:i:s"] = "yyyy-mm-dd hh:mm:ss";
		$dateFormatDropDown["d-m-Y H:i:s"] = "dd-mm-yyyy hh:mm:ss";
		$dateFormatDropDown["m/d/Y H:i:s"] = "mm/dd/yyyy hh:mm:ss";
		$dateFormatDropDown["Y-m-d H:i:s O"] = "yyyy-mm-dd hh:mm:ss TZ";
		
		$timeFormatDropDown = array();
		// $timeFormatDropDown[''] = '';
		$timeFormatDropDown['H'] = '24 hour';
		$timeFormatDropDown['h'] = '12 hour';

		
		// print_r(Yii::app()->session['dateFormat']); die();
		if(!empty($_POST['setPreference'])) {

			$model->attributes = $_POST["UserPreferencesForm"];
			if(!isset($dateFormatDropDown[$model->dateFormat])) {
				Yii::app()->user->setFlash('error', Yii::t("translation", "Incorect date format "));
				return;
			}
			if(!isset($timeFormatDropDown[$model->timeFormat])) {
				Yii::app()->user->setFlash('error', Yii::t("translation", "Incorect time format "));
				return;
			}
			if ($model->timeFormat == 'h') {
				$twelveHourTime = str_replace(array('H', 'O'), array('h', 'A O'), $model->dateFormat);
				if(false === strstr($model->dateFormat, 'O')) {
					$twelveHourTime .= ' A';
				}
				$model->dateFormat = $twelveHourTime;
			}
			$xml = '<Vocabulary type="' . Yii::app()->session["usersMdsVocabulary"] . '">
<VocabularyElementList>';
			$xml .= '<VocabularyElement id="' . Yii::app()->session["usersMdsElement"] . '">';
			$xml .= '<attribute id="dateFormat"><![CDATA[' . $model->dateFormat . ']]></attribute>';
			$xml .= '<attribute id="timeFormat"><![CDATA[' . $model->timeFormat . ']]></attribute>';

			$xml .= '</VocabularyElement>';
			$xml .= '</VocabularyElementList>
</Vocabulary>';
			$result = $this->mds->mdsCapture($xml);
			// print_r($result); die();
			if (substr($result, 0, 5) == "ERROR") {
				Yii::log("Error saving user preferences: $result", "error", self::LOG_CAT);
				Yii::app()->user->setFlash('error', Yii::t("translation", "There was a problem saving your settings, please contact your administrator"));
			} else {
				Yii::app()->session['dateFormat'] = $model->dateFormat;
				Yii::app()->session['timeFormat'] = $model->timeFormat;
				Yii::log("Settings successfully saved for "  . Yii::app()->user->name, "info", self::LOG_CAT);
				Yii::app()->user->setFlash('success', Yii::t("translation", "Your settings were successfully saved"));
			}
		}
		if($model->timeFormat == 'h') {
			$twelveHourTime = str_replace(array('h', ' A'), array('H', ''), $model->dateFormat);
			$model->dateFormat = $twelveHourTime;
		}

		$this->render('userpreferences', array(
			'model' => $model,
			'dateFormatDropDown' => $dateFormatDropDown,
			'timeFormatDropDown' => $timeFormatDropDown
		));

	}
	/**
	 * actionVerify 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionVerify() {
		$this->page = 'verifyInfo';
		$model = new UserForm;
		if(isset($_POST['clearMDScache'])) {
			Yii::app()->MDSCache->flush();
			Yii::app()->user->setFlash('success', Yii::t("translation", "MDS cache successfully cleared"));
			Yii::log("MDS cache cleared based on user request", "info", self::LOG_CAT);
		}
		if(isset($_POST['clearTRDcache'])) {
			Yii::app()->TRDCache->flush();
			Yii::app()->user->setFlash('success', Yii::t("translation", "TRD cache successfully cleared"));
			Yii::log("TRD cache cleared based on user request", "info", self::LOG_CAT);
		}
		if(isset($_POST['clearTPcache'])) {
			Yii::app()->TradingPartnersCache->flush();
			Yii::app()->user->setFlash('success', Yii::t("translation", "Trading partners cache successfully cleared"));
			Yii::log("Trading partners cache cleared based on user request", "info", self::LOG_CAT);
		}
		if(isset($_POST['clearENVcache'])) {
			Yii::app()->EnvCache->flush();
			Yii::app()->user->setFlash('success', Yii::t("translation", "ENV cache successfully cleared"));
			Yii::log("ENV cache cleared based on user request", "info", self::LOG_CAT);
		}
		//$configuration = new TSettingsIni();
		$currentTix = Yii::app()->session['currentTix'];
		$configDetailsArray = array();
		$configDetailsArray["mdsUrl"] = Yii::app()->params->mds['url'];
		$configDetailsArray["ldapUrl"] = Yii::app()->params->ldap['url'];
		$configDetailsArray["ldapAdminUser"] = Yii::app()->params->ldap['adminuser'];
		$configDetailsArray["ldapPort"] = Yii::app()->params->ldap['port'];
		$configDetailsArray["ldapOu"] = Yii::app()->params->ldap['ou'];
		$configDetailsArray["ldapDn"] = Yii::app()->params->ldap['dn'];
		$configDetailsArray["appName"] = $this->configuration->getSettings()->name;
		$configDetailsArray["appVersion"] = $this->configuration->getSettings()->version;
		$configDetailsArray["pentahoServer"] = $this->configuration->getSettings()->pentahoServer;

		if(!empty($currentTix)) {
			foreach ($currentTix as $key => $value) {
				$configDetailsArray["nodeId"] = $key;
				$configDetailsArray["tixUrl"] = $value;
			}
		} else {
			$configDetailsArray["nodeId"] = "Node not selected";
			$configDetailsArray["tixUrl"] = "Node not selected";
		}
		
	
		//SEND THE DATA ARRAY TO THE VERIFY MODULES PAGE
		$this->render('verifyInfo', array(
			'model' => $model,
			'configDetails' => $configDetailsArray
		));
	}
	/**
	 * actionUpgrade 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionUpgrade() {
		$this->page = 'upgradeConfig';
		$model = new UpgradeForm;
		//$mds = new TMdsResource();
		//$mds = Yii::app()->mdsresource;
		$message = "";
		$nodes = array();
		$orgs = array();
		$configuration = Yii::app()->tsettings;
		$theFile = $configuration->getConfigXmlFile();
		//$dashboard = Yii::app()->dashboardresource;
		if (empty($theFile)) {
			Yii::log("Could not get values from the function getConfigXmlFile()", "error", self::LOG_CAT);
		}

		/*QUERY THE MDS TO FETCH ALL VOCABULARIES RELATED TO STORY. THE QUERY SEARCHES FOR ALL VOCABULARIES
		THAT HAVE AN EQ_name HAVING THE TEXT urn:tracetracker:*:story:config:widgets. THE * REPRESENTS THE
		ORGANIZATION ID*/
		$queryGNS = $this->mds->mdsQueryString('EQ_name=urn:tracetracker:*:story:config:widgets', 'false', 'false', 'none');
		$rsGNSdata = $this->mds->elementListMdsQuery($queryGNS, 'mds');
		
		/*LOOP THROUGH THE RESULTS, FILTER OUT AND ONLY PICK THE ORGANIZATION ID. $value CONTAINS THE
		ENTIRE VOCABULARY NAME. $exploadedValue CONTAINS JUST THE ORGANIZATION ID PART OF TEH VOCABULARY NAME.
		THEN PUT THE IDs IN AN ARRAY $nodeS*/
		if(!empty($rsGNSdata->error)) {
			Yii::log("No nodes avalable", "error", self::LOG_CAT);
		} else {
			foreach ($rsGNSdata->result as $key => $value) {
				if (isset($value['id']) && !empty($value['id'])) {
					$explodedValue = explode(":", $value['id']);
					$nodes[$explodedValue[2]] = $explodedValue[2];
				}
			}
			/*PASS THE ARRAY $nodes TO THE FUNCTION getOrg() TO GET BACK THE NAMES OF ORGANIZATIONS GOTTEN FROM
			THE QUERY $queryGNS ABOVE. THIS IS FOR DISPLAY PURPOSES.*/
			$orgs = $this->dashboard->getOrg('organization', 0, 0, $nodes);
		}


		/*READ THE baseline_MDD_config.xml FILE. LOOP THROUGH THE ORGANIZATIONS IN $orgs QUERY FOR THE NODE IDS
		EACH OF THEM HAS. HOLD THE NODE IDS IN AN ARRAY. DECLARE A VARIABLE $formattedXml WHICH WILL HOLD THE FINAL XML TO BE UPLOADED.
		SINCE EACH LINE IN THE FILE IS SEEN AS AN ARRAY ELEMENT, LOOP THROUGH EACH LINE/ELEMENT LOOKING FOR
		THE TEXT <Vocabulary. FOR EACH LINE WHERE THIS TEXT IS FOUND, LOOP THROUGH THE ORGANIZATIONS ARRAY
		GOTTEN FROM THE QUERY $queryGNS AND REPLACE THE TEXT _node_ WITH THE NODE ID. ITERATE THIS FOR
		EACH LINE FOR EACH ORGANIZATION. FINALLY APPEND EACH LINE TO THE VARIABLE $formattedXml TO FINALLY END
		UP WITH ONE XML TO UPLOAD*/
		$arrayOfNodeIds = array();
		$nodeIdsArray = array();
		$xmlToRead = $theFile['baselineNode'];
		$originalFormattedXml = implode("\n", $xmlToRead);
		$mddXmlToRead = $theFile['mdd'];
		$fullNodeXml = "";
		$formattedMddXml = "";
		$mdd = "";
		foreach ($orgs as $keyOrgId => $valueOrgName) {
			$queryGns = $this->mds->mdsQueryString('organization' . '&EQATTR_OID='.$keyOrgId, 'true', 'false', 'urn:tracetracker:mds:gns:');
			$rsGnsCheck = $this->mds->elementListMdsQuery($queryGns);
			
			if(isset($rsGnsCheck->result[0]['NODES'])) {
				$arrayOfNodeIds = explode(",", $rsGnsCheck->result[0]['NODES']);
			}

			foreach ($arrayOfNodeIds as $value) {
				$formattedXml = str_replace('_NODE_', $value, $originalFormattedXml);
				$formattedXml = str_replace(array("\r\n", "\r", "\n", "\t"), "", $formattedXml);
				preg_match("/<VocabularyList>(.*?)<\/VocabularyList>/", $formattedXml, $xmlToUpload);
				$fullNodeXml .= $xmlToUpload[1];
			}
		}

		foreach ($mddXmlToRead as $lineKey => $line) {
			if (strpos($line, "<Vocabulary")) {
				if (strpos($line, "_NODE_")) {
					foreach ($orgs as $key => $value) {
						$queryGns = $this->mds->mdsQueryString('organization' . '&EQATTR_OID='.$key, 'true', 'false', 'urn:tracetracker:mds:gns:');
						$rsGnsCheck = $this->mds->elementListMdsQuery($queryGns);
						
						if(isset($rsGnsCheck->result[0]['NODES'])) {
							$nodeIdsArray = explode(",", $rsGnsCheck->result[0]['NODES']);
						}

						foreach ($nodeIdsArray as $value) {
							$formattedMddXml .= str_replace('_NODE_', $value, $line);
						}
					}
					//} else {
					//$formattedMddXml .= $line; THIS LINE APPENDS THE LINES WITH _org_ TO THE FINAL XML
				}
			}
		}

		$mdd .= $formattedMddXml;

		/*READ THE deleted_node_config.xml FILE. LOOP THROUGH THE ORGANIZATIONS IN $orgs QUERY FOR THE NODE IDS
		EACH OF THEM HAS. HOLD THE NODE IDS IN AN ARRAY. LOOP THROUGH THE NODE IDS ARRAY AND WITH EACH ITERATION
		CREATE AN XML FILE*/
		$arrayOfNodeIds = array();
		$xmlToRead = $theFile['deletedNodeConfig'];
		$originalFormattedXml = implode("\n", $xmlToRead);
		$fullNodeDeleteXml = "";

		foreach ($orgs as $keyOrgId => $valueOrgName) {
			$queryGns = $this->mds->mdsQueryString('organization' . '&EQATTR_OID='.$keyOrgId, 'true', 'false', 'urn:tracetracker:mds:gns:');
			$rsGnsCheck = $this->mds->elementListMdsQuery($queryGns);
			
			if(isset($rsGnsCheck->result[0]['NODES'])) {
				$arrayOfNodeIds = explode(",", $rsGnsCheck->result[0]['NODES']);
			}

			foreach ($arrayOfNodeIds as $value) {
				$formattedXml = str_replace('_NODE_', $value, $originalFormattedXml);
				$formattedXml = str_replace(array("\r\n", "\r", "\n", "\t"), "", $formattedXml);
				preg_match("/<VocabularyList>(.*?)<\/VocabularyList>/", $formattedXml, $xmlToUpload);
				$fullNodeDeleteXml .= $xmlToUpload[1];
			}
		}

		/*READ THE MDD FILE. DECLARE A VARIABLE $formattedXml WHICH WILL HOLD THE FINAL XML TO BE UPLOADED.
		SINCE EACH LINE IN THE FILE IS SEEN AS AN ARRAY ELEMENT, LOOP THROUGH EACH LINE/ELEMENT LOOKING FOR
		THE TEXT <Vocabulary. FOR EACH LINE WHERE THIS TEXT IS FOUND, LOOP THROUGH THE ORGANIZATIONS ARRAY
		GOTTEN FROM THE QUERY $queryGNS AND REPLACE THE TEXT _org_ WITH THE ORGANIZATION ID. ITERATE THIS FOR
		EACH LINE FOR EACH ORGANIZATION. FINALLY APPEND EACH LINE TO THE VARIABLE $formattedXml TO FINALLY END
		UP WITH ONE XML TO UPLOAD*/
		//$xmlToRead = '../../resources/baseline_MDD_config.xml';
		//echo $mdd;die();
		$xmlToRead = $theFile['mdd'];
		$formattedXml = "";
		foreach ($xmlToRead as $lineKey => $line) {
			if (strpos($line, "<Vocabulary")) {
				if (strpos($line, "_ORG_")) {
					foreach ($orgs as $key => $value) {
						$formattedXml .= str_replace('_ORG_', $key, $line);
					}
				} elseif(!strpos($line, "_NODE_")) {
					$formattedXml .= $line; //THIS LINE APPENDS THE LINES NOT ORG/NODE SPECIFIC TO THE FINAL XML
				}
			}
		}

		$mdd .= $formattedXml;
		/*DECLARE VARIABLE $fullXml TO HOLD THE FINAL XML TO BE UPLOADED*/
		$fullXml = "";

		/*READ THE COMMON CONFIG XML, FORMAT IT INTO READABLE XML LINES, REMOVE ALL SPACES, TABS AND 
		RETURN CHARACTERS TO READY IT FOR UPLOAD. USE pregmatch TO REMOVE THE HEADER AND FOOTER OF 
		OF THE XML.*/
		//$xmlToRead = '../../resources/baseline_config.xml';
		$xmlToRead = $theFile['baseline'];
		$formattedXml = implode("\n", $xmlToRead);
		$formattedXml = str_replace(array("\r\n", "\r", "\n", "\t"), "", $formattedXml);
		preg_match("/<VocabularyList>(.*?)<\/VocabularyList>/", $formattedXml, $xmlToUpload);
		$fullXml .= $xmlToUpload[1];

		/*READ THE ORG CONFIG XML. LOOP THROUGH THE ORGANIZATIONS GOTTEN FROM THE QUERY $queryGNS.
		WITH EACH ITERATION FOR EACH ORGANIZATION, REPLACE THE TEXT _org_ WITH ORGANIZATION ID.
		REMOVE THE HEADER AND FOOTER OF THE XML AND APPEND IT TO THE VARIABLE $fullXml, TO MAKE
		ONE HUGE XML TO BE UPLOADED*/
		//$xmlToRead = '../../resources/baseline_org_config.xml';
		$xmlToRead = $theFile['baselineOrg'];
		$originalFormattedXml = implode("\n", $xmlToRead);
		
		foreach ($orgs as $key => $value) {
			$formattedXml = str_replace('_ORG_', $key, $originalFormattedXml);
			$formattedXml = str_replace(array("\r\n", "\r", "\n", "\t"), "", $formattedXml);
			preg_match("/<VocabularyList>(.*?)<\/VocabularyList>/", $formattedXml, $xmlToUpload);
			$fullXml .= $xmlToUpload[1];
		}

		/*FOR THE DELETES, THE SAME CONCEPT APPLIES AS FOR THE ADDS*/
		$fullXmlToDelete = "";
		/*READ THE COMMON DELETE CONFIG*/
		//$xmlToRead = '../../resources/deleted_config.xml';
		$xmlToRead = $theFile['deleted'];
		$formattedXml = implode("\n", $xmlToRead);
		$formattedXml = str_replace(array("\r\n", "\r", "\n", "\t"), "", $formattedXml);
		preg_match("/<VocabularyList>(.*?)<\/VocabularyList>/", $formattedXml, $xmlToUpload);
		$fullXmlToDelete .= $xmlToUpload[1];

		/*READ THE ORG DELETE CONFIG*/
		//$xmlToRead = '../../resources/deleted_org_config.xml';
		$xmlToRead = $theFile['deletedOrg'];
		$originalFormattedXml = implode("\n", $xmlToRead);
		
		foreach ($orgs as $key => $value) {
			$formattedXml = str_replace('_ORG_', $key, $originalFormattedXml);
			$formattedXml = str_replace(array("\r\n", "\r", "\n", "\t"), "", $formattedXml);
			preg_match("/<VocabularyList>(.*?)<\/VocabularyList>/", $formattedXml, $xmlToUpload);
			$fullXmlToDelete .= $xmlToUpload[1];
		}

		/*Now we've created all the XML, time to upload to MDS and do error handling*/
		if (!empty($_POST['performFunction'])) {
			/*Write the xml to a temporary file*/
			$filePath = sys_get_temp_dir();
			$filesToUpload = "MDD \n" . $mdd . "\n ADD \n" . $fullXml . "\n NODES \n" . $fullNodeXml . 
				"\n DELETE \n" . $fullXmlToDelete . "\n NODE DELETE \n" . $fullNodeDeleteXml;
			$fileName = "Upgrade - " . date("d-m-y h:i:s");
			$temporaryMddFile = tempnam($filePath, $fileName);
			$handle = fopen($temporaryMddFile, "w");
			fwrite($handle, $filesToUpload);
			fclose($handle);
			//unlink($temporaryMddFile); THIS LINE DELETES THE FILE
			/*dataXml WILL HOLD THE FULL XML OF THE DATA. THIS IS PASSED ONTO $dataResult SO AS TO VALIDATE
			THE DATA. $mdd CONTAINS THE MDD XML. THIS IS PASSED ONTO $mddResult SO AS TO VALIDATE THE
			MDD.*/
			$dataXml = $fullXml . $fullNodeXml . $fullXmlToDelete . $fullNodeDeleteXml;
			$mddResult = $this->mds->mdsValidate($mdd, "mdd");

			/*FIRST VALIDATE THE MDD. IF INVALID THEN SHOW A MESSAGE AND ABORT THE ENTIRE PROCESS.*/
			if (!isset($mddResult) || substr($mddResult, 0, 5) == "ERROR") {
				$message = "mddXmlError". "MDD: " . $mddResult;
				//SEND THE DATA ARRAY TO THE UPGRADEs PAGE
				$this->render('upgradeConfig', array(
					'gnsData' => $orgs,
					'model' => $model,
					'message' => $message
				));
				return;
			}
			/*CHECK IF USER CLICKED ON perform upgrade OR upload mdd. IF SO THEN UPLOAD MDD. IF INVALID THEN SHOW ERROR MESSAGE AND ABORT PROCESS.*/
			if (isset($_POST['performFunction']) && ($_POST['performFunction'] == "uploadXml" || $_POST['performFunction'] == "uploadMdd")) {
				$result = $this->mds->mdsCapture( $mdd, "mdd", true );

				if (!isset($result) || substr($result, 0, 5) == "ERROR") {
					$message = "mddError";
					Yii::log("Upload of MDD failed : $result", "error", self::LOG_CAT);
					//SEND THE DATA ARRAY TO THE UPGRADEs PAGE
					$this->render('upgradeConfig', array(
						'gnsData' => $orgs,
						'model' => $model,
						'message' => $message
					));
					return;
				}
				Yii::log("Upload of MDD succeeded.", "trace", self::LOG_CAT);
			}

			/*VALIDATE THE DATA XML. IF INVALID ABORT THE ENTIRE PROCESS*/
			$dataResult = $this->mds->mdsValidate($dataXml, "data");
			if (!isset($dataResult) || substr($dataResult, 0, 5) == "ERROR") {
				$message = "xmlError". "DATA: " . $dataResult;
				//SEND THE DATA ARRAY TO THE UPGRADEs PAGE
				$this->render('upgradeConfig', array(
					'gnsData' => $orgs,
					'model' => $model,
					'message' => $message
				));
				return;
			}

			/*IF BOTH DATA AND MDD XMLs ARE VALID AND THE USER CLICKED ON dry run upgrade THEN SHOW A MESSAGE*/
			if(isset($mddResult) && substr($mddResult, 0, 5) != "ERROR" && isset($dataResult) && 
				substr($dataResult, 0, 5) != "ERROR" && $_POST['performFunction'] == "validateXml") {
				$message = "xmlSuccess";
				//SEND THE DATA ARRAY TO THE UPGRADEs PAGE
				$this->render('upgradeConfig', array(
					'gnsData' => $orgs,
					'model' => $model,
					'message' => $message
				));
				return;
			}

			/*IF THE USER CLICKED ON perform upgrade.*/
			if($_POST['performFunction'] == "uploadXml") {
				$result = $this->mds->mdsCapture( $fullXml, 'vocab', true );
				/*Handle error situations*/
				if ( !isset($result) || substr($result, 0, 5) == "ERROR") {
					if (isset($result)) {
						$message = "Error" . $result . ". Upload of full XML failed.";
						Yii::log("Upgrade of XML failed : $result", "error", self::LOG_CAT);
					} else {
						$message = "Failure" . $result . ". The MDS returned no value when trying to upload full XML.";
						Yii::log("The function mdsCapture returned no value when trying to upload full XML", "error", self::LOG_CAT);
					}
				} else {
					/*So far, so good...*/
					Yii::log("Upgrade of XML succeeded.", "trace", self::LOG_CAT);
					
					$result = $this->mds->mdsDelete( $fullXmlToDelete );
					/*Handle error situations*/
					if ( !isset($result) || substr($result, 0, 5) == "ERROR") {
						if (isset($result)) {
							$message = "Error" . $result . " . Upload of delete XML failed.";
							Yii::log("Upload of delete XML to MDS failed : $result", "error", self::LOG_CAT);
						} else {
							$message = "Failure" . $result . ". The MDS returned no value when trying to upload delete XML.";
							Yii::log("The function mdsCapture returned no value when trying to upload delete XML", "error", self::LOG_CAT);
						}
					} else {
						Yii::log("Upload of delete XML succeeded.", "trace", self::LOG_CAT);
						$result = $this->mds->mdsCapture( $fullNodeXml );
						/*Handle error situations*/
						if ( !isset($result) || substr($result, 0, 5) == "ERROR") {
							if (isset($result)) {
								$message = "Error" . $result . ". Upload of node XML failed";
								Yii::log("Upload of node XML to MDS failed : $result", "error", self::LOG_CAT);
							} else {
								$message = "Failure" . $result . ". The MDS returned no value when trying to upload node config XML.";
								Yii::log("The function mdsCapture returned no value when trying to upload node config XML", "error", self::LOG_CAT);
							}
						} else {
							Yii::log("Upload of node XML succeeded.", "trace", self::LOG_CAT);
							$result = $this->mds->mdsCapture( $fullNodeDeleteXml );
							/*Handle error situations*/
							if ( !isset($result) || substr($result, 0, 5) == "ERROR") {
								if (isset($result)) {
									$message = "Error" . $result . ". Upload of node delete XML to MDS failed.";
									Yii::log("Upload of node delete XML to MDS failed : $result", "error", self::LOG_CAT);
								} else {
									$message = "Failure" . $result . ". The MDS returned no value when trying to upload node delete config XML";
									Yii::log("The function mdsCapture returned no value when trying to upload node delete config XML", "error", self::LOG_CAT);
								}
							} else {
								/*ALL GOOD :-)*/
								Yii::log("Upload of node delete XML succeeded.", "info", self::LOG_CAT);
								$message = "Success";
								Yii::log("Config upgrade succeeded.", "info", self::LOG_CAT);
							}
						}
					}
				}
			}
		}
		//SEND THE DATA ARRAY TO THE UPGRADEs PAGE
		$this->render('upgradeConfig', array(
			'gnsData' => $orgs,
			'model' => $model,
			'message' => $message
		));
	}
	
	
}
?>
