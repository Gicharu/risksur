<?php
/**
 * SurFormDetails 
 * 
 * @uses CActiveRecord
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class SurFormDetails extends CActiveRecord {
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
		return 'surFormDetails';
	}

	/**
	 * relations 
	 * 
	 * @access public
	 * @return void
	 */
	public function relations() {
		return array(
			'surFormElements' => array( self::BELONGS_TO, 'SurFormHead', 'formId' )
		);
	}
	/**
	 * primaryKey 
	 * 
	 * @access public
	 * @return void
	 */
	public function primaryKey() {
		return 'formSubId';
	}
}
