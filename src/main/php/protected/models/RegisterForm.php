<?php
/**
 * RegisterForm 
 * 
 * @uses CFormModel
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Eric Thuku <eric@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 * @SuppressWarnings checkUnusedVariables
 */
class RegisterForm extends CFormModel {
	public $username;
	public $email;
	public $password;
	public $confirmPassword;
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
				'username, email, password, confirmPassword',
				'required'
			),
		);
	}

	/**
	 * attributeLabels declares attribute labels.
	 * @return array
	 */
	public function attributeLabels() {
		return array(
			'email' => Yii::t("translation", "Email"),
			'username' => Yii::t("translation", "Username"),
			'password' => Yii::t("translation", "Password"),			
			'confirmPassword' => Yii::t("translation", "Re-Type Password"),			
		);
	}
}
