<?php
/**
 * LoginForm 
 * 
 * @uses CFormModel
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 * @SuppressWarnings checkUnusedVariables
 */
class LoginForm extends CFormModel {
	public $username;
	public $password;
	public $rememberMe;
	public $loginType;
	private $_identity;
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	/**
	 * rules 
	 * 
	 * @access public
	 * @return array
	 */
	public function rules() {
		return array(
			// username and password are required
			array(
				'username, password',
				'required'
			),
			//array('username, password, loginType', 'required'),
			// rememberMe needs to be a boolean
			array(
				'rememberMe',
				'boolean'
			),
			// password needs to be authenticated
			array(
				'password',
				'authenticate'
			),

			array('loginType', 'safe')
		);
	}

	/**
	 * attributeLabels declares attribute labels.
	 * @return array
	 */
	public function attributeLabels() {
		return array(
			'rememberMe' => Yii::t("translation", "Remember me next time"),
			'username' => Yii::t("translation", "Username"),
			'password' => Yii::t("translation", "Password"),
			//'loginType'=>'Login Type',
			
		);
	}
	/**
	 * 
	 */
	/**
	 * authenticate Authenticates the password. This is the 'authenticate' validator as declared in rules().
	 * @param $attribute 
	 * @param $params    
	 * @return void           
	 */
	public function authenticate($attribute, $params) {
		if (!$this->hasErrors()) {
			$showMsg = "Incorrect username or password";
			$this->_identity = new UserIdentity($this->username, $this->password, $this->loginType);
			if (!$this->_identity->authenticate()) {
				if (isset($this->_identity->errorMessage) && $this->_identity->errorMessage != "") {
					$showMsg = $this->_identity->errorMessage;
				}
				$this->addError('password', 'Incorrect username or password.');
				echo "<div class='login-error'>$showMsg</div>";
			}
		}
	}
	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login() {
		if ($this->_identity === null) {
			$this->_identity = new UserIdentity($this->username, $this->password, $this->loginType);
			$this->_identity->authenticate();
		}
		if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
			$duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days or the default session timeout value
			Yii::app()->user->login($this->_identity, $duration);
			return true;
		}

		return false;
	}
}
