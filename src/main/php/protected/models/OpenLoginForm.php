<?php
/**
 * OpenLoginForm 
 * 
 * @uses CFormModel
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 * @SuppressWarnings checkUnusedVariables
 */
class OpenLoginForm extends CFormModel {
	public $gmailaddress;
	public $gmailpassword;
	/**
	 * rules 
	 * 
	 * @access public
	 * @return void
	 */
	public function rules() {
		return array(
			array(
				'gmailaddress',
				'gmailpassword',
				'required'
			),
			array(
				'gmailaddress',
				'email'
			),
			array(
				'gmailpassword',
				'authenticate'
			)
		);
	}
}
