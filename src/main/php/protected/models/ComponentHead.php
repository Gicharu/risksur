<?php
/**
 * ComponentHead 
 * 
 * @uses CActiveRecord
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class ComponentHead extends CActiveRecord {

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
		return 'componentHead';
	}

	/**
	 * primaryKey 
	 * 
	 * @access public
	 * @return string
	 */
	public function primaryKey() {
		return 'componentId';
	}

	/**
	 * relations 
	 * 
	 * @access public
	 * @return array
	 */
	public function relations() {
		return array(
			'compDetails' => array( self::HAS_MANY, 'ComponentDetails', 'componentId' )
		);
	}
}
