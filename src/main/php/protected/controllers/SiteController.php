<?php

/**
 * SiteController
 *
 * @package  
 * @author    Chirag Doshi <chirag@tracetracker.com>
 * @copyright Tracetracker
 * @version   $id$
 * @uses      Controller
 * @license   Tracetracker {@link http://www.tracetracker.com}
 */
class SiteController extends Controller {
	const LOG_CAT = "ctrl.SiteController";
	const LDAPERROR = 'LDAP';
	const FORGOT_SALT = 'Re$etTrackerS@lt';

	/**
	 * Declares class-based actions.
	 */
	public $loggedName;

	/**
	 * Declares the salt.
	 */
	private $salt = "#fxdHJ&^%DS";

	/**
	 * init 
	 * 
	 * @access public
	 * @return void
	 */
	public function init() {
		//$this->ldap = Yii::app()->ldapresource;
		//$this->configuration = Yii::app()->tsettings;
		//$this->dashboard = Yii::app()->dashboardresource;
		//$this->mds = Yii::app()->mdsresource;

	}

	/**
	 * actions
	 *
	 * @access public
	 * @return void
	 */
	public function actions() {
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page' => array(
				'class' => 'CViewAction',
			),
		);
	}

	/*
	public function actionIndex() {
		Yii::log("actionIndex called", "trace", self::LOG_CAT);
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}
	*/
	/**
	 * actionKeepAlive 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionKeepAlive() {
		Yii::log("actionKeepAlive called", "trace", self::LOG_CAT);
		// Yii::app()->session->setTimeout(30);
		// Yii::app()->session->open();
		//throw new Exception(400);
		echo 'OK';
		Yii::app()->end();


	}

	/**
	 * actionError 
	 * 
	 * This is the action to handle external exceptions.
	 *
	 * @access public
	 * @return void
	 */
	public function actionError() {
		Yii::log("actionError called", "trace", self::LOG_CAT);
		$error = "";
		if (Yii::app()->errorHandler->error) {
			$error = Yii::app()->errorHandler->error;
			if (Yii::app()->request->isAjaxRequest) {
				echo $error['message'];
			} else {
				$this->render('error', $error);
			}
		}
	}

	public function actionIndex() {
		$this->render('index', array(
			//'model' => $model
		));
	}

	/**
	 * performAjaxValidation
	 *
	 * @param mixed $model
	 * @access protected
	 * @return void
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'usersForm') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	 * actionContact 
	 * 
	 * Displays the contact page
	 *
	 * @access public
	 * @return void
	 */
	public function actionContact() {
		$model = new ContactForm;
		$localeSession = isset(Yii::app()->session['locale']) ? Yii::app()->session['locale'] : 'en';
		Yii::app()->setLanguage($localeSession);
		if (isset($_POST['ContactForm'])) {
			$model->attributes = $_POST['ContactForm'];
			if ($model->validate()) {
				$headers = "From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'], $model->subject, $model->body, $headers);
				Yii::app()->user->setFlash('contact', Yii::t("translation", "Thank you for contacting us. We will respond to you as soon as possible."));
				$this->refresh();
			}
		}
		$this->render('contact', array(
			'model' => $model
		));
	}

	/**
	 * actionLogin 
	 * 
	 * Displays the login page
	 *
	 * @access public
	 * @return void
	 */
	public function actionLogin() {
		Yii::log("actionLogin called", "trace", self::LOG_CAT);
		$this->layout = 'front';
		$localeSession = isset(Yii::app()->session['locale']) ? Yii::app()->session['locale'] : 'en';
		Yii::app()->setLanguage($localeSession);
		//unset user Timezone on login, if previously set
		unset(Yii::app()->session['userTimezone']);
		
		//print_r(Yii::app()->session); die();
		// check if the MDS server error is set and display it
		if (isset($_GET['LinkerrorMsg'])) {
			Yii::app()->user->setFlash('error', Yii::t("translation", "Your password reset link has expired,please reset your password again"));
		}
		if(isset($_GET['err']) && $_GET['err'] == 'mds') {
			//echo "set"; die();
			Yii::app()->user->setFlash('error', Yii::t("translation", "Failed to connect to server (1), please contact your administrator"));
		}
		if (!Yii::app()->user->isGuest) {
			$this->redirect(array(
				'design/index'
			));
		}
		$model = new LoginForm;
		//$logpasswd = Yii::app()->tsettings;
		$loginType = array(
			'0' => 'Ldap Login',
			'1' => 'Standard Login'
		);
		// if it is ajax validation request
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if (isset($_POST['LoginForm']) || isset($_GET['ssoObject']) || isset($_GET['usr']) || isset($_GET['openId'])) {
			if(isset($_POST['LoginForm']['username'])) {
				Yii::app()->user->setName($_POST['LoginForm']['username']); 
			}
			//$ldap = Yii::app()->ldapresource;
			//$configuration = Yii::app()->tsettings;
			//$ldapConnection = $ldap->ldapConnect();
			//$defaultDn = Yii::app()->params->ldap['dn'];
			//$ldapOu = Yii::app()->params->ldap['ou'];
			//$loid = Yii::app()->loid->load();

			// if it is ajax validation request
			if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
			// collect user input data
			if (!empty($_POST['LoginForm'])) {
				$model->attributes = $_POST['LoginForm'];
			}		

			//$newLdpaOu = explode(",", $ldapOu);
			//$newDn = array();
			//foreach ($newLdpaOu as $key => $value) {
				//$newDn["ou=" . $value . " , " . $defaultDn] = "ou=" . $value . " , " . $defaultDn;
			//}
			//validate user input and redirect to the previous page if valid
			if ($model->validate() && $model->login()) { // || Yii::app()->user->login($identity)) {
				// if nodeId provided set the selectedTix session variable to skip the select node page
				$this->redirect(array(
					'design/index'
				));
				return;
			}
		}
		$model->username = "";
		$model->password = "";
		// display the login form
		$this->render('login', array(
			'model' => $model,
			'loginType' => $loginType
		));
	}

	/**
	 * actionLogout 
	 * 
	 * Logs out the current user and redirect to homepage.
	 *
	 * @access public
	 * @return void
	 */
	public function actionLogout() {
		Yii::app()->user->setName(Yii::app()->user->name);
		Yii::log("actionLogout called", "trace", self::LOG_CAT);
		$url = Yii::app()->homeUrl;
		if(isset($_GET['inactive'])) {
			Yii::log("User has been logged out due to inactivity time: " . 
				Yii::app()->getSession()->getTimeout() . "Mins", "trace", self::LOG_CAT);
			$url .= "?inactive=1";
		}
		Yii::app()->user->logout();
		$this->redirect($url);
	}

	/**
	 * actionForgotpassword 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionForgotpassword() {
		Yii::log("actionForgotpassword called", "trace", self::LOG_CAT);
		$this->layout = 'mainNoMenu';
		$localeSession = isset(Yii::app()->session['locale']) ? Yii::app()->session['locale'] : 'en';
		Yii::app()->setLanguage($localeSession);
		// check if rederect_uri parameter is given
		$cancelLink = $this->createUrl('site/login');
		if(!empty($_GET['redirect_uri'])) {
			$cancelLink = urldecode($_GET['redirect_uri']);
		}
		//error_reporting (E_ALL ^ E_NOTICE);
		Yii::import('application.extensions.phpmailer.JPhpMailer');
		$model = new ForgotpasswordForm;
		//Capture the email address from forgotpassword.php.
		if (isset($_POST['ForgotpasswordForm'])) {
			$model->attributes = $_POST['ForgotpasswordForm'];
			if ($model->validate()) {
				$email = $model->email;
			}
			$encryption = Yii::app()->tixencryption;
			$ldapConnection = $this->ldap->ldapConnect();
			$defaultDn = Yii::app()->params->ldap['dn'];
			$ldapOu = Yii::app()->params->ldap['ou'];
			$individualOu = explode(",", $ldapOu); //Get all OUs from the ini file
			//$gnsEnvironment = $configuration->getConfigSettings()->gnsEnvironment;
			//search in LDAP for email captured from variable $email.
			//$newLdpaOu = explode(",", $ldapOu);
			//$newDn = array();
			//foreach ($newLdpaOu as $key => $value) {
				//$newDn[] = "ou=" . $value . " , " . $defaultDn;
			//}

			//$ou = "$ldapOu";
			$filter = "(mail=$email)";
			//$filter ="(cn=*)";
			//$attr = array("*");
			$filterOus = "(|";
			foreach ($individualOu as $ouParams) {
				$filterOus .= "(ou=$ouParams)";
			}
			$filterOus .= ")";
			$filter = "(&" . $filterOus . $filter . ")";
			$attribute = array(
				"*"
			);

				$start = round(microtime(true) * 1000);
				$queryLdap = $this->ldap->ldapSearch($ldapConnection, $defaultDn, $filter, $attribute);
				$stop = round(microtime(true) * 1000);
				$msTotal = $stop - $start;

			if ($queryLdap['count'] == 0) {
				Yii::app()->user->setFlash('success', Yii::t("translation", "A reset password link has been sent to your email"));
				Yii::log("Spent $msTotal ms to fail sending password reset mail to user $filter", "info", self::LOG_CAT);
				$this->redirect(array(
					'site/login'
				));
				return;
			} 
			$info = array();
			if (is_string($queryLdap) && substr($queryLdap, 0, 5) == "Error") {
				$errorMessage = "Error No:" . ldap_errno($ldapConnection) . "Error:" . ldap_error($ldapConnection);
				Yii::log($errorMessage, "warning", self::LOG_CAT);
				Yii::app()->user->setFlash('error', Yii::t("translation", "Unable to retrieve information (") . self::LDAPERROR . 
					ldap_errno($ldapConnection) . Yii::t("translation", "), please try again or contact your administrator"));
				$this->redirect(array(
					'site/login'
				));
				return;
			} 
			$info = $queryLdap;

			$groups = array();
			
			foreach ($info as $datadrop) {
				if (is_array($datadrop)) {
					$groups['mail'] = $datadrop['mail'][0];
					$groups['cn'] = $datadrop['cn'][0];
					$groups["organization"] = $datadrop['o'][0];
					$groups['uid'] = $datadrop['uid'][0];
					$groups['givenname'] = $datadrop['givenname'][0];
					$groups['ou'] = $datadrop['ou'][0];
				}
			}

			//if message was sent issue appropriate flash maeesage and log
			if (empty($groups['uid']) && empty($groups['mail'])) {
				Yii::log("No uid or mail attribute for $email", "error", self::LOG_CAT);
				Yii::app()->user->setFlash('error', Yii::t("translation", "Unable to fetch information, please try again or contact your administrator if " . 
					"this problem persists"));
				$this->redirect(array(
					'site/login'
				));
				return;
			}
			$toMailName = $groups['givenname'];
			$email = $groups['mail'];
			// construct data encryption and set expiry to 24 hrs
			$resetEncrypt = urlencode($encryption->encrypt($groups['uid'] . "," . $email . ",resetTrue", 86400, self::FORGOT_SALT));
			$passwordUrl = "http://" . $_SERVER["HTTP_HOST"] . Yii::app()->request->baseUrl . "/index.php/site/changepassword?data=$resetEncrypt" . 
				"&redirect_uri=" . $cancelLink;
			$mail = new TTMailer();
			$subject = Yii::t("translation", "GTNet user password request");
			$altBody = Yii::t("translation", "To view the message, please use an HTML compatible email viewer!");
			$message = Yii::t('translation', 'Dear ') . $groups['givenname'] . ',<br /><br />' . 
			Yii::t('translation', 'Your password has been reset, please visit ') . '<a href="' . 
					$passwordUrl . '">' . $passwordUrl . '</a>' . Yii::t('translation', ' to change it. ') .
					'<p></p>' . Yii::t('translation', 'This message was automatically generated.') . '<br />' . 
					Yii::t('translation', ' If you think it was sent incorrectly, ') . 
					Yii::t('translation', 'please contact your GTNet administrator');
			//$mail->SMTPDebug = 1;
			//$mail->Send();
			//if mail is not sent successfully issue appropriate flash message
			if (!$mail->ttSendMail($subject, $altBody, $message, $email, $toMailName)) {
				if(!Yii::app()->user->hasFlash('error')) {
					$mailErrorMsg = Yii::t("translation", "Unable to send reset password link, please try again or contact your administrator" . 
					" if the problem persists");
					Yii::app()->user->setFlash('error', $mailErrorMsg);
				}
				$this->redirect(array(
					'site/login'
				));
				return;
				
			} 
			// update the passwordChanged param on ldap
			// NOTE! We do not need this see STORY-794
			// $start = round(microtime(true) * 1000);
			// $authorize = $this->ldap->ldapBindAdmin($ldapConnection);
			// $stop = round(microtime(true) * 1000);
			// $msTotal = $start - $stop;
			// if (!$authorize) {
			// 	Yii::log("Spent $msTotal ms to fail to authorize user $userLogged", "info", self::LOG_CAT);
			// 	$errorMessage = "Error No:" . ldap_errno($ldapConnection) . "Error:" . ldap_error($ldapConnection);
			// 	Yii::log($errorMessage, "warning", self::LOG_CAT);
			// }
			// $data = array();
			// $data["passwordChanged"] = "TRUE";
			// $cn = $this->ldap->ldapEscape($groups['uid']);
			// $start = round(microtime(TRUE) * 1000);
			// $ou = $groups['ou'];
			// $dn = "ou=$ou , $defaultDn";
			// $updateData = $this->ldap->ldapModify($ldapConnection, "uid= $cn, $dn", $data);
			// $stop = round(microtime(TRUE) * 1000);
			// $msTotal = $start - $stop;
			// if (is_string($updateData) && substr($updateData, 0, 5) == "Error") {
			// 	$errorMessage = "Failed Updating passwordChanged param. Error No:" . ldap_errno($ldapConnection) . "Error:" . ldap_error($ldapConnection);
			// 	Yii::log($errorMessage, "warning", self::LOG_CAT);
			// }
			Yii::log("Reset password link successfully sent to $email", "trace", self::LOG_CAT);
			Yii::app()->user->setFlash('success', Yii::t("translation", "A reset password link has been sent to your email"));
			$this->redirect(array(
				'site/login'
			));
			return;

		}
		$this->render('forgotpassword', array(
			'model' => $model,
			'cancelLink' => $cancelLink
		));
	}

	/**
	 * actionChangepassword 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionChangepassword() {
		Yii::log("actionChangepassword called", "trace", self::LOG_CAT);
		// logout any logged in user but only if the form is empty
		if (empty($_POST['ChangepasswordForm'])) {
			Yii::app()->user->logout();
		}
		$this->layout = 'mainNoMenu';
		$model = new ChangepasswordForm;
		$encryption = Yii::app()->tixencryption;
		$cancelLink = $this->createUrl('site/login');
		$defaultDn = Yii::app()->params->ldap['dn'];
		$ldapOu = Yii::app()->params->ldap['ou'];
		$individualOu = explode(",", $ldapOu); //Get all OUs from the ini file
		$localeSession = isset(Yii::app()->session['locale']) ? Yii::app()->session['locale'] : 'en';
		Yii::app()->setLanguage($localeSession);
		if(!empty($_GET['redirect_uri'])) {
			$cancelLink = urldecode($_GET['redirect_uri']);
		}
		if (empty($_GET['data'])) { // if data is not found redirect to login page
			$this->redirect(array(
				'site/login'
			));
			return;
		}
		$resetParams = $_GET['data'];
		// $passChanged = "FALSE";
		$resetDecrypt = $encryption->decrypt($resetParams, self::FORGOT_SALT); // decrypt  and extract the data variables
		$dataValues = explode(",", $resetDecrypt);
		if(!empty($dataValues[1])) {
			$model->email = $dataValues[1]; //rawurldecode($_GET['mail']);
		}
		if (count($dataValues) == 3 && $dataValues[2] == "resetTrue") {
			$userName = $dataValues[0]; //$this->loggedName;
			Yii::app()->user->setName($userName);
			$ldapConnection = $this->ldap->ldapConnect();//LDAP connection
			$filter = "(uid=" . $this->ldap->ldapEscape($userName) . ")";//search for and confirm logged_names's password was oldpassword
			$filterOus = "(|";
			foreach ($individualOu as $ouParams) {
				$filterOus .= "(ou=$ouParams)";
			}
			$filterOus .= ")";
			$filter = "(&" . $filterOus . $filter . ")";
			$attribute = array(
				"givenName",
				"mail",
				"cn",
				"uid",
				"ou",
				"passwordChanged",
				"memberOf",
				"o"
			);
			$showName = $userName;
			$queryLdap = $this->ldap->ldapSearch($ldapConnection, $defaultDn, $filter, $attribute);
			if ($queryLdap['count'] == 1) {
				if (empty($queryLdap[0]['ou'][0]) || !isset($queryLdap[0]['ou'][0])) {
					Yii::log("No ou parameter found for user: " . $this->username, "error", self::LOG_CAT);
					Yii::app()->user->setFlash('error', Yii::t("translation", "Error in user properties, Please contact the administrator."));
					return;
				}
				$ou = $queryLdap[0]['ou'][0];
				$showName = isset($queryLdap[0]['givenname'][0]) ? $queryLdap[0]['givenname'][0] : $userName;
				if (is_string($queryLdap) && substr($queryLdap, 0, 5) == "Error") {
					Yii::log("User not found in LDAP", "warn", self::LOG_CAT);
					Yii::app()->user->setFlash('error', Yii::t("translation", "Unable to store data (") . self::LDAPERROR . ldap_errno($ldapConnection) . 
						Yii::t("translation", "), please contact your administrator if this problem persists"));
					$this->redirect(array(
						'site/login'
					));
					return;
				}
				// if($queryLdap[0]['passwordchanged'][0] == "TRUE") { // check if the passwordChanged param is set
				// 	$passChanged = "TRUE";
				// }
			}
		}
		// if the link has expired or not valid give error message to user
		if ($encryption->isExpired() || !isset($dataValues[0]) || !isset($dataValues[2]) || $dataValues[2] != "resetTrue") { // || $passChanged == "FALSE") {
			$this->render('changepassword', array(
				'model' => $model,
				'cancelLink' => $cancelLink,
				'expiredLink' => true
			));
			return;
		}
		if (isset($_POST['ChangepasswordForm'])) {
			$model->attributes = $_POST['ChangepasswordForm'];
			Yii::app()->user->setName($userName);
			if ($model->validate()) {
				$verifyPassword = $this->configuration->generate($userName, $model->verifyPassword);
				$userLogged = $queryLdap[0]['uid'][0]; //compare the password to be changed and the password in LDAP
				$email = $queryLdap[0]['mail'][0]; //$logged_in_password = $queryLdap[0]['userpassword'][0];
				if ($this->ldap->ldapEscape($userName) == $userLogged || $userName == $userLogged) {
					$start = round(microtime(true) * 1000);
					$authorize = $this->ldap->ldapBindAdmin($ldapConnection);
					$stop = round(microtime(true) * 1000);
					$msTotal = $start - $stop;
					if (!$authorize) {
						Yii::log("Spent $msTotal ms to fail to authorize user $userLogged", "info", self::LOG_CAT);
						$errorMessage = "Error No:" . ldap_errno($ldapConnection) . "Error:" . ldap_error($ldapConnection);
						Yii::log($errorMessage, "warning", self::LOG_CAT);
					}
					//write the new (verified password)to LDAP for user.
					$data = array();
					$data["userPassword"] = $verifyPassword;
					$data["passwordChanged"] = "FALSE";
					$data["passwordTimestamp"] = time();
					$cn = $this->ldap->ldapEscape($userName);
					$start = round(microtime(TRUE) * 1000);
					$dn = "ou=$ou , $defaultDn";
					$updateData = $this->ldap->ldapModify($ldapConnection, "uid= $cn, $dn", $data);
					$stop = round(microtime(TRUE) * 1000);
					$msTotal = $start - $stop;
					if ($updateData) {
						Yii::log("Spent $msTotal ms to change password for $userLogged", "info", self::LOG_CAT);
						$loginTime = date('c');
						$loginTime = new DateTime($loginTime);
						Yii::app()->session->add('loginTime', $loginTime);
						foreach ($queryLdap[0]['memberof'] as $key => $groups) {
							if (is_numeric($key)) {
								$group = explode(",", $groups);
								$userGroups[] = str_replace("cn=", "", $group[0]);
							}
						}
						$displayName = empty($queryLdap[0]["displayname"][0]) ? $queryLdap[0]["uid"][0] : $queryLdap[0]["displayname"][0];
						Yii::app()->session->add('displayName', $displayName);
						Yii::app()->session->add('userGroups', $userGroups);
						Yii::app()->session->add('mail', $queryLdap[0]['mail'][0]);
						Yii::app()->session->add('organization', $queryLdap[0]["o"][0]);
						$gnsEnvironment = Yii::app()->params->gns['environment'];
						// get users organization name
						$organizations = $this->dashboard->getOrg( 'organization' );
						Yii::app()->session->add('organizationName', $organizations[Yii::app()->session['organization']]);
						Yii::app()->user->setFlash('success', Yii::t("translation", "Password changed succesfully"));
						unset(Yii::app()->session['changePassword']);
						if(!empty(Yii::app()->params->constants['userActivityNode'])) {
							$userActivityQuery = $this->mds->mdsQueryString("vocabularyName=" . Yii::app()->params->gns['nodeVocabulary'] . 
								'&EQATTR_NID=' . Yii::app()->params->constants['userActivityNode'] . "&EQATTR_ENV=$gnsEnvironment");
							$rsUserActivity = $this->mds->elementListMdsQuery($userActivityQuery);
							$recordPasswordChange = false;
							if(!empty($rsUserActivity->error)) {
								Yii::log('Error retrieving node details for ' . Yii::app()->params->constants['userActivityNode'] . ' : ' . 
									$rsUserActivity->error, 'error', self::LOG_CAT);
							} else {
								$userActivityUrl = preg_replace('/\/tix\/.*/', '/tix', $rsUserActivity->result[0]['AA']);
								Yii::app()->session->add('userActivityNodeUrl', $userActivityUrl);
								$loginTime = date('c');
								$loginTime = new DateTime($loginTime);
								Yii::app()->session->add('loginTime', $loginTime);
								$recordPasswordChange = $this->dashboard->saveUserActivity('passwordChange');
							}
							if(!$recordPasswordChange) {
								Yii::log('There was an error when trying to upload user activity info', 'warning', self::LOG_CAT);
							}
						} else {
							Yii::log('The node required to save user activity is not configured in story_custom.ini', 'warning', self::LOG_CAT);
						}
						// inform the user by email that thier password was changed
						$mail = new TTMailer();
						$subject = Yii::t('translation', 'GTNet user password updated');
						$altBody = Yii::t('translation', 'To view the message, please use an HTML compatible email viewer!');
						$message = Yii::t('translation', 'Dear ') . $showName . ',<br /><br />' . 
						Yii::t('translation', 'Your password has been updated, ') . '<br/>' . 
								Yii::t('translation', 'your login id is: ') . $userName .
								'<p></p>' . Yii::t('translation', 'This message was automatically generated.') . '<br />' . 
								Yii::t('translation', ' If you think it was sent incorrectly, ') . 
								Yii::t('translation', 'or you have not changed your password, ') .
								Yii::t('translation', 'please contact your GTNet administrator');
						$toAddress = $email;
						//if mail is not sent successfully add a log message 
						if (!$mail->ttSendMail($subject, $altBody, $message, $toAddress, $showName)) {
							$errorMessage = "Failed to send an informational email to the user $userName";
							Yii::log($errorMessage, "warning", self::LOG_CAT);
						}
						if (!empty($_GET['redirect_uri'])) {
							$redirectUri = urldecode($_GET['redirect_uri']);
							// Yii::app()->user->logout();
							$this->redirect($redirectUri);
							return;
						} 
						
						$controllerAction = 'site/login';
						$identity = new UserIdentity($userLogged, $verifyPassword, 1);
						if($identity->authenticate()) {

							Yii::app()->user->login($identity, Yii::app()->session->timeout);
							$controllerAction = 'dashboard/setNode';
						}
						
						$this->redirect(array(
							$controllerAction
						));
						return;

					} elseif (is_string($updateData) && substr($updateData, 0, 5) == "Error") {
						$errorMessage = "Failed Updating. Error No:" . ldap_errno($ldapConnection) . "Error:" . ldap_error($ldapConnection);
						Yii::log($errorMessage, "warning", self::LOG_CAT);
						Yii::app()->user->setFlash('error', Yii::t("translation", "Failed to change password, please contact your administrator"));
					}
				} else {
					Yii::app()->user->setFlash('error', Yii::t("translation", "Failed to change password, please contact your administrator"));
				}
			}
		}
		$this->render('changepassword', array(
			'model' => $model,
			'cancelLink' => $cancelLink,
			'expiredLink' => false
		));
		return;
	}
	
	/**
	 * SetUserTimezone
	 *
	 * @access public
	 * @return void
	 */
	public function actionSetUserTimezone() {
		if (Yii::app()->request->isPostRequest && isset($_POST['userTz'])) {
			if (empty(Yii::app()->session['userTimezone'])) {
				Yii::app()->session->add("userTimezone", $_POST['userTz']);
				$response = 'Timezone Updated to: '. Yii::app()->session['userTimezone'];
			} else {
				$response = "Timezone Not Updated.";
			}
			Yii::log($response, "trace", self::LOG_CAT);
			echo $response;
		}
		
	}

	/**
	 * actionRegisterUser 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionRegisterUser() {
		Yii::log("actionRegisterUser called", "trace", self::LOG_CAT);
		$model = new RegisterForm; // Form to add users
		$rolesModel = new Roles; // Form to add roles to users_has_roles table
		if (isset($_POST['RegisterForm'])) { // Check if there is a post
			$model->attributes = $_POST['RegisterForm'];
			if ($model->userName == "" || $model->email == "" || $model->password == "") { // Check for blanks
				Yii::app()->user->setFlash('error', 'All fields must be filled in!');
				$this->render('register', array(
					'model' => $model
				));
				return;
			}
			if (!filter_var($model->email, FILTER_VALIDATE_EMAIL)) { // Check fo rinvalid email address
				Yii::app()->user->setFlash('error', 'Enter a valid email address!');
				$this->render('register', array(
					'model' => $model
				));
				return;
			}
			if ($model->confirmPassword !== $model->password) { // Check for password mismatch
				Yii::app()->user->setFlash('error', 'Password mismatch! Re-type the password');
				$this->render('register', array(
					'model' => $model
				));
				return;
			}
			if ($model->validate()) {
			$model->password = md5($this->salt . $_POST['RegisterForm']['password']); // MD5 and Salt the password b4 saving
				try {
					if ($model->save()) // Save to users table
						$rolesModel->users_id = $model->userId; // Get the last inserted userId in users table
						$rolesModel->roles_id = "3"; // Insert roleId 3 i.e. normal user as defined in roles table
						$rolesModel->save(); // Save to users_has_roles table
						$mail = new TTMailer();
						$originUrl = Yii::app()->createAbsoluteUrl("site/login");
						$subject = 'User Registration';
						$altBody = 'To view the message, please use an HTML compatible email viewer!';
						$message = 'Dear ' . $model->userName . ',<br><br>';
						$message .= 'You have successfully registered at ' . $originUrl . '. Below are your login details:<br><br>';
						$message .= '<b>Username : ' . $model->userName . '</b><br>';
						$message .= '<b>Email : </b>' . $model->email . '<br>';
						$message .= '<b>Password : ' . $_POST['RegisterForm']['password'] . '</b><br><br>';
						$message .= 'You can now login using the username and password and enjoy the experience of RiskSur.';
						$toAddress = $model->email;
						$toName = $model->userName;

						/*IF EMAIL IS NOT SENT THEN LOG THE ERROR*/
						if (!$mail->ttSendMail($subject, $altBody, $message, $toAddress, $toName)) {
							Yii::log("Error in sending user registration email to " . $model->email, "error", self::LOG_CAT);
							return;
						}
						Yii::app()->user->setFlash('success', "User Created Successfully");
						$this->redirect( array( 'site/login' ) );
						return;
					}
				catch(CDbException $e) {
			        Yii::app()->user->setFlash('error', "Username already exists!");
				}
			} else {
				// echo CActiveForm::validate($model);
				Yii::app()->end();
			}
		}
		$this->render('register', array(
			'model' => $model
		));
	}
}
