<?php
/**
 * UserPreferencesForm
 * 
 * @uses CFormModel
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author James Njoroge <james@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 * @SuppressWarnings checkUnusedVariables
 */
class UserPreferencesForm extends CFormModel {
	public $dateFormat;
	public $selectLocale;
	public $timeFormat;

	
	/**
	 * rules
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array("dateFormat, timeFormat", "required")
		);
	}
	
}