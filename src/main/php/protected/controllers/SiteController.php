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
			$users = Users::model()->findByAttributes( array( 'email' => $email ) );
			//if message was sent issue appropriate flash maeesage and log
			if (empty($users)) {
				Yii::log("No uid or mail attribute for $email", "error", self::LOG_CAT);
				Yii::app()->user->setFlash('error', Yii::t("translation", "Unable to fetch information, please try again or contact your administrator if " . 
					"this problem persists"));
				$this->redirect(array(
					'site/login'
				));
				return;
			}
			$toMailName = $users->userName;
			$email = $users->email;
			// construct data and set expiry to 24 hrs
			$resetEncrypt = base64_encode($email . ",resetTrue,". (strtotime(date("H:i:s")) + 86400));
			$passwordUrl = "http://" . $_SERVER["HTTP_HOST"] . Yii::app()->request->baseUrl . "/index.php/site/changepassword?data=$resetEncrypt" . 
				"&redirect_uri=" . $cancelLink;
			$mail = new TTMailer();
			$subject = Yii::t("translation", "User password request");
			$altBody = Yii::t("translation", "To view the message, please use an HTML compatible email viewer!");
			$message = Yii::t('translation', 'Dear ') . $toMailName . ',<br /><br />' .
			Yii::t('translation', 'Your password has been reset, please visit ') . '<a href="' . 
					$passwordUrl . '">' . $passwordUrl . '</a>' . Yii::t('translation', ' to change it. ') .
					'<p></p>' . Yii::t('translation', 'This message was automatically generated.') . '<br />' . 
					Yii::t('translation', ' If you think it was sent incorrectly, ') . 
					Yii::t('translation', 'please contact your administrator');
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
		$cancelLink = $this->createUrl('site/login');
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
		$data = base64_decode($resetParams);
		$dataValues = explode(",", $data);
		//check if 24 hours has elapsed
		if (strtotime(date("H:i:s")) > $dataValues[2]) {
			$this->redirect(array(
				'site/login?LinkerrorMsg=true'
			));
			Yii::app()->user->setFlash('error', Yii::t("translation", "Password reset link has expired"));
			return;
		}
		if(!empty($dataValues[0])) {
			$model->email = $dataValues[0];
		}
		if ($dataValues[1] == "resetTrue") {
			$userName = $dataValues[0];
			Yii::app()->user->setName($userName);
		}
		if (isset($_POST['ChangepasswordForm'])) {
			$model->attributes = $_POST['ChangepasswordForm'];
			Yii::app()->user->setName($userName);
			if ($model->validate()) {
				$password = $model->newPassword;
				$userToUpdate = Users::model()->findByAttributes( array( 'email' => $userName ) );
				$userToUpdate->password = $userToUpdate->hashPassword($password, $userToUpdate->salt);
				$updateData = $userToUpdate-> saveAttributes(array('password'));
				$displayName = $userToUpdate->userName;
				Yii::app()->session->add('displayName', $displayName);
				Yii::app()->user->setFlash('success', Yii::t("translation", "Password changed succesfully"));
				unset(Yii::app()->session['changePassword']);
				$mail = new TTMailer();
				$subject = Yii::t('translation', 'User password updated');
				$altBody = Yii::t('translation', 'To view the message, please use an HTML compatible email viewer!');
				$message = Yii::t('translation', 'Dear ') . $displayName . ',<br /><br />' .
				Yii::t('translation', 'Your password has been updated, ') . '<br/>' .
						Yii::t('translation', 'your login id is: ') . $displayName .
						'<p></p>' . Yii::t('translation', 'This message was automatically generated.') . '<br />' .
						Yii::t('translation', ' If you think it was sent incorrectly, ') .
						Yii::t('translation', 'or you have not changed your password, ') .
						Yii::t('translation', 'please contact your administrator');
				//if mail is not sent successfully add a log message
				if (!$mail->ttSendMail($subject, $altBody, $message, $userName, $displayName)) {
					$errorMessage = "Failed to send an informational email to the user $userName";
					Yii::log($errorMessage, "warning", self::LOG_CAT);
				}
				if (!empty($_GET['redirect_uri'])) {
					$redirectUri = urldecode($_GET['redirect_uri']);
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
		$encryption = Yii::app()->encryption;
		if (isset($_GET['usd']) && isset($_GET['risksur'])) { // Check if incoming url has these values. i.e. user has clicked on confirmation link.
			$password = $_GET['risksur']; // Get the user password
			$decryptData = $encryption->decrypt($_GET['usd'], self::FORGOT_SALT); // Decrypt the user details
			$userDetails = explode(",", $decryptData);

			// if the link has expired or not valid give error message to user
			if ($encryption->isExpired() || !isset($userDetails[0]) || !isset($userDetails[2]) || $userDetails[2] != "newUser") {
				Yii::app()->user->setFlash('error', 'The account activation data is either expired or invalid. Kindly register again.');
				Yii::log("Expired link or invalid parameters in link sent by confirmationUrl", "error", self::LOG_CAT);
				$this->redirect(array('site/login'));
				return;
			}

			// Arrange data to be saved to the db i.e. creating the user.
			$model->userName = $userDetails[0];
			$model->email = $userDetails[1];
			$model->password = $password;
			$model->confirmPassword = $password;
			$model->active = "1"; // Set status to active
			// $model->save(); // Save the user details
			if (!$model->save()) { // If the user hasn't been saved to users yable then show an error
				Yii::app()->user->setFlash('error', 'There was a problem activating your account. Please contact the RiskSur admin on info@tracetracker.com');
				$this->redirect(array('site/login'));
				return;
			}

			$rolesModel->users_id = $model->userId; // Get the last inserted userId in users table
			$rolesModel->roles_id = "3"; // Insert roleId 3 i.e. normal user as defined in roles table
			// $rolesModel->save(); // Save to users_has_roles table
			if (!$rolesModel->save()) { // If the user roles haven't been save then show an error
				Yii::app()->user->setFlash('error', 'There was a problem activating your account. Please contact the RiskSur admin on info@tracetracker.com');
				$this->redirect(array('site/login'));
				return;
			}
			// Else if all data was saved show a success message.
			Yii::app()->user->setFlash('success', 'Thank you for registering on Risksur, please login to continue.');
			$this->redirect(array('site/login'));
			return;
		}
		if (isset($_POST['RegisterForm'])) { // Check if there is a post i.e. user has entered data
			$model->attributes = $_POST['RegisterForm'];
			if ($model->userName == "" || $model->email == "" || $model->password == "") { // Check for blanks
				Yii::app()->user->setFlash('error', 'All fields must be filled in!');
				Yii::log("Blank fields posted", "error", self::LOG_CAT);
				$this->render('register', array(
					'model' => $model
				));
				return;
			}
			if (!filter_var($model->email, FILTER_VALIDATE_EMAIL)) { // Check for invalid email address
				Yii::app()->user->setFlash('error', 'Enter a valid email address!');
				Yii::log("Invalid format of email address provided", "error", self::LOG_CAT);
				$this->render('register', array(
					'model' => $model
				));
				return;
			}
			if ($model->confirmPassword !== $model->password) { // Check for password mismatch
				Yii::app()->user->setFlash('error', 'Password mismatch! Re-type the password');
				Yii::log("Password mis-match", "error", self::LOG_CAT);
				$this->render('register', array(
					'model' => $model
				));
				return;
			}
			// Query for the email address provided
			$queryUserEmail = Yii::app()->db->createCommand()
				->select('*')
				->from('users')
				->where('email = "' . $model->email . '" ')
				->queryAll();

			if (count($queryUserEmail) > 0) { // If the email address already exists shown an error message
				Yii::app()->user->setFlash('error', 'The email is already registered. Enter a different email address.');
				Yii::log("Email already registered", "error", self::LOG_CAT);
				$this->render('register', array(
					'model' => $model
				));
				return;
			}
			// Query for the username provided
			$queryUserName = Yii::app()->db->createCommand()
				->select('*')
				->from('users')
				->where('userName = "' . $model->userName . '" ')
				->queryAll();

			if (count($queryUserName) > 0) { // If the username already exists show an error message
				Yii::app()->user->setFlash('error', 'The username is already registered. Enter a different username.');
				Yii::log("Username already registered", "error", self::LOG_CAT);
				$this->render('register', array(
					'model' => $model
				));
				return;
			}
			$model->password = md5($this->salt . $_POST['RegisterForm']['password']); // MD5 and Salt the password b4 saving
			$mail = new TTMailer(); // Initiate mailer
			$originUrl = Yii::app()->createAbsoluteUrl("site/login");
			$cancelLink = $this->createUrl('site/login'); // Not sure what this is for but wth, just leave it there
			$encryptUserData = urlencode($encryption->encrypt($model->userName . "," . $model->email . ",newUser", 86400, self::FORGOT_SALT));
			$confirmationUrl = "http://" . $_SERVER["HTTP_HOST"] . Yii::app()->request->baseUrl . "/index.php/site/registerUser?usd=$encryptUserData" . 
				"&redirect_uri=" . $cancelLink . "&risksur=" . $model->password;
			$subject = 'User Registration';
			$altBody = 'To view the message, please use an HTML compatible email viewer!';
			$message = 'Dear ' . $model->userName . ',<br><br>';
			$message .= 'You have successfully registered at ' . $originUrl . '. Click on the link below to activate your account:<br><br>';
			$message .= '<a href="' . $confirmationUrl . '">' . $confirmationUrl . '</a><br><br>';
			$message .= '<b>Best Regards,</b><br><br>';
			$message .= '<b>Team RiskSur</b>';
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
		$this->render('register', array(
			'model' => $model
		));
	}
}
