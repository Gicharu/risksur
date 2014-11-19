<?php
/**
 * RegisterForm 
 * 
 * @uses CActiveRecord
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Eric Thuku <eric@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 * @SuppressWarnings checkUnusedVariables
 */
class RegisterForm extends CActiveRecord {
	public $userName;
	public $email;
	public $password;
	public $confirmPassword;

	/**
	 * model 
	 * 
	 * @param mixed $className 
	 * @static
	 * @access public
	 * @return void
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	/**
	 * tableName 
	 * 
	 * @access public
	 * @return void
	 */
	public function tableName() {
		return 'users';
	}

	/**
	 * primaryKey 
	 * 
	 * @access public
	 * @return void
	 */
	public function primaryKey() {
		return 'userId';
	}
	/**
	 * Declares the validation rules.
	 * The rules state that userName and password are required,
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
			// userName and password are required
			array(
				'userName, email, password, confirmPassword',
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
			'userName' => Yii::t("translation", "Username"),
			'password' => Yii::t("translation", "Password"),			
			'confirmPassword' => Yii::t("translation", "Re-Type Password"),			
		);
	}
}
