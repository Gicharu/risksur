<?php
/**
 * ComponentDetails 
 * 
 * @uses CActiveRecord
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class ComponentDetails extends CActiveRecord {

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
		return 'componentDetails';
	}

	/**
	 * primaryKey 
	 * 
	 * @access public
	 * @return string
	 */
	public function primaryKey() {
		return 'componentDetailId';
	}

	/**
	 * relations 
	 * 
	 * @access public
	 * @return array
	 */
	public function relations() {
		return array(
			'compHeader' => array( self::BELONGS_TO, 'ComponentHead', 'componentId' ),
		);
	}
}
