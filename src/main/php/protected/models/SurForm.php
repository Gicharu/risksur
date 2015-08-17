<?php
/**
 * SurForm 
 * 
 * @uses CActiveRecord
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class SurForm extends CActiveRecord {
	/**
	 * model 
	 * 
	 * @param mixed $className 
	 * @static
	 * @access public
	 * @return static
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	/**
	 * tableName 
	 * 
	 * @access public
	 * @return string
	 */
	public function tableName() {
		return 'surForm';
	}

	/**
	 * relations 
	 * 
	 * @access public
	 * @return array
	 */
	public function relations() {
		return array(
			'surFormHead' => array( self::HAS_MANY, 'SurFormDetails', 'formId' )
		);
	}
	/**
	 * primaryKey 
	 * 
	 * @access public
	 * @return string
	 */
	public function primaryKey() {
		return 'formId';
	}
}
