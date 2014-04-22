<?php
/**
 * ChangepasswordForm 
 * 
 * @uses CFormModel
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 * @SuppressWarnings checkUnusedVariables
 */
class ChangepasswordForm extends CFormModel {
	public $newPassword;
	public $verifyPassword;
	//public $username;
	public $email;
	/**
	 * rules 
	 * 
	 * @access public
	 * @return void
	 */
	public function rules() {
		return array(
			array(
				'email,newPassword,verifyPassword',
				'required'
			),
			array(
				'email', 'email'
			),
			array(
				'newPassword',
				'length',
				'max' => 64,
				'min' => 6
			),
			array(
				'newPassword',
				'compare',
				'compareAttribute' => 'verifyPassword'
			),
		);
	}

	/**
	 * attributeLabels 
	 * 
	 * @access public
	 * @return void
	 */
	public function attributeLabels() {
		return array(
			'email' => Yii::t('translation', 'Email'),
			'newPassword' => Yii::t('translation', 'New Password'),
			'verifyPassword' => Yii::t('translation', 'Verify Password')
		);
	}
}
