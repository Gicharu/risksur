<?php

/**
 * UserIdentity represents the data needed to identify a user.
 * It contains the authentication method that checks if the provided
 * data can identify the user.
 */
class UserIdentity extends CUserIdentity {
	const LOG_CAT = "application.components.UserIdentity";
	const GNSERROR = 'GNS';
	const LDAPERROR = 'LDAPERROR';
	public $loginType;

	/**
	 * Constructor.
	 * @param string $username username
	 * @param string $password password
	 * @param int $loginType loginType
	 * 
	 */
	public function __construct($username, $password, $loginType) {
		$this->username = $username;
		$this->password = $password;
		$this->loginType = $loginType;
	}

	/**
	 * authenticate 
	 * @return boolean
	 */
	public function authenticate() {
		Yii::log("authenticate function called", "trace", self::LOG_CAT);

		$localeSession = isset(Yii::app()->session['locale']) ? Yii::app()->session['locale'] : 'en';
		Yii::app()->setLanguage($localeSession);
		$configuration = Yii::app()->tsettings;
		//$newDn = array();
		$tixUrl = array();

		/*CHECK IF WE ARE ABLE TO CONNECT TO LDAP. IF NOT THEN DISPLAY AN ERROR AND LOG*/
		/*IF LOGIN IS NORMAL (logintype == 0) THEN HASH THE PASSWORD*/
		$hashedPassword = $this->password;
			$userArray = array(
				"admin" => "admin",
				"demo" => "demo"
			);
				//$hashedPassword = $configuration->generate($this->username, $this->password);
				if (isset($username[$this->username]) && $username[$this->username] == $this->password) {
					Yii::log("Login successful for  " . $this->username, "trace", self::LOG_CAT);
				} else {
					Yii::log("invalid credentials for  " . $this->username, "error", self::LOG_CAT);
					$this->errorMessage = Yii::t('translation', 'Incorrect username or password');
				}


		//Yii::app()->session->add('newDn', $dnValue);
		Yii::app()->session->add('username', $this->username);
		//$displayName = empty($searchUser[0]["displayname"][0]) ? $searchUser[0]["uid"][0] : $searchUser[0]["displayname"][0];
		//Yii::app()->session->add('displayName', $displayName);
		//Yii::app()->session->add('mail', $searchUser[0]['mail'][0]);

		/*LOOP THROUGH THE ROLES THAT THE USER HAS AND STORE THEM IN A SESSION userGroups*/
		//foreach ($searchUser[0]['memberof'] as $key => $groups) {
			//if (is_numeric($key)) {
				//$group = explode(",", $groups);
				//$userGroups[] = str_replace("cn=", "", $group[0]);
			//}
		//}
		//Yii::app()->session->add('userGroups', $userGroups);



		/*QUERY FOR THE ROLES FROM THE MDS*/
		//$queryRoles = $mds->mdsQueryString('vocabularyName=urn:tracetracker:story:rolemanagement&orderBy=name', 'true', 'false', 'none');
		//$rolesResult = $mds->elementListMdsQuery($queryRoles, "mds");

		///*IF MDS RETURNS AN ERROR THEN LOG IT, DISPLAY AN ERROR AND FAIL LOGIN*/
		//if (isset($rolesResult->error)) {
			//Yii::log("Error while getting roles from MDS: " . $rolesResult->error, "error", self::LOG_CAT);
			////Yii::app()->user->setFlash('error', "An error occured while fetching roles from the MDS. Reload the page or contact the administrator.");
			//$this->errorMessage = 'Configuration settings error, Please contact your administrator.';
			//return;
		//}

		//$rsRoles = isset($rolesResult->result[1]) ? $rolesResult->result[1] : array(); //all roles in mds
		//$rsBizRules = isset($rolesResult->result[0]) ? $rolesResult->result[0] : array(); //roles assigned to user
		
		///*IF THE ROLES ARRAY IS EMPTY, LOG AND ABORT LOGIN*/
		//if (count($rsRoles) < 1) {
			//Yii::log("No records were found in vocabulary element roles", "error", self::LOG_CAT);
			////Yii::app()->user->setFlash('error', "A configuration error occured. Contact the administrator.");
			//$this->errorMessage = Yii::t('translation', 'Configuration settings error, Please contact your administrator.');
			//return;
		//}
		//Yii::app()->session->add('roleManage', $rsRoles); //add the roles to a session variable

		///*IF THE USER ASSIGNED ROLES ARRAY IS EMPTY JUST LOG AND CONTINUE WITH LOGIN*/
		//if (count($rsBizRules) < 1) {
			//Yii::log("No records were found in vocabulary element businessRules", "error", self::LOG_CAT);
		//} else {
			//Yii::app()->session->add('businessRules', $rsBizRules);
		//}

		/*THE CURRENT USER'S ROLES ARE STORED IN $userGroups. THE MINIMUM ROLE REQUIRED FOR LOGIN IS ROLE_WORKER. CHECK IF THE CURRENT USER HAS THIS ROLE.
		IF NOT, DO NOT ALLOW THEM LOGIN AND INFORM THEM OF THIS. CREATE A SESSION roleWorker THAT IS TO BE USED ON THE LOGIN PAGE TO DIFFERENTIATE BETWEEN
		ERROR CAUSED AS A RESULT OF MINIMUM ROLES MISSING OR ERROR CAUSED BY A NETWORK PROBLEM*/
		//if (!in_array("ROLE_WORKER", $userGroups)) {
			////Yii::app()->user->setFlash('error', "You do not have the minimum roles required for login");
			//Yii::app()->session->add('roleWorker', 'noRole');
			//$this->errorMessage = Yii::t('translation', 'You do not have the minimum roles required for login, Please contact your administrator');
			//Yii::log("ROLE_WORKER missing in users account $this->username", "warn", self::LOG_CAT);
			//return;
		//}


	
		/*QUERY FOR THE WIDGETS THAT THE USER HAS AS DEFAULT. AND DO SOME ERROR CHECKING*/
		// Add default date format from ini file into session
		Yii::app()->session->add('dateFormat', 'Y-m-d H:i:s');
		Yii::app()->session['dateFormat'] = Yii::app()->params->other['dateformat'];
		Yii::app()->session->add('timeFormat', 'H');
		Yii::app()->session['timeFormat'] = Yii::app()->params->other['timeformat'];
		$this->errorCode = self::ERROR_NONE;
		/*SET THE PHP GARBAGE COLLECTION TIMEOUT TO THE YII TIMEOUT*/
		ini_set('session.gc_maxlifetime', Yii::app()->session->timeout);					
		return !$this->errorCode;
	}

}
