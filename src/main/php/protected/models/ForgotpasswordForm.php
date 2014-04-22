<?php
/**
 * ForgotpasswordForm 
 * 
 * @uses CFormModel
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 * @SuppressWarnings checkUnusedVariables
 */
class ForgotpasswordForm extends CFormModel {
	public $username;
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
				'email',
				'email'
			),
			array(
				'email',
				'required'
			),
		);
	}
}
