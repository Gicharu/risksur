<?php

/**
 * UserIdentity represents the data needed to identify a user.
 * It contains the authentication method that checks if the provided
 * data can identify the user.
 */
class UserIdentity extends CUserIdentity {
	const LOG_CAT = "application.components.UserIdentity";
	private $_id;
	public $loginType;

	/**
	 * Constructor.
	 *
	 * @param string  $username  username
	 * @param string  $password  password
	 * @param int     $loginType loginType
	 *
	 */
	public function __construct( $username, $password, $loginType ) {
		$this->username = $username;
		$this->password = $password;
		$this->loginType = $loginType;
	}

	/**
	 * authenticate
	 * @return int
	 */
	public function authenticate() {
		
		$users = Users::model()->findByAttributes( array( 'userName' => $this->username ) );

		if ( $users === null ) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else if ( !$users->validatePassword( $this->password ) ) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		} else {
			$this->errorCode = self::ERROR_NONE;
			$this->_id = $users->userId;
		}
		/*SET THE PHP GARBAGE COLLECTION TIMEOUT TO THE YII TIMEOUT*/
		ini_set( 'session.gc_maxlifetime', Yii::app()->session->timeout );
		return !$this->errorCode;
	}

	/**
	 * getId
	 * @return integer
	 */
	public function getId() {
		return $this->_id;
	}

}
