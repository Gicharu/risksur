<?php
/**
 * AttributeFormRelation 
 * 
 * @uses CActiveRecord
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class AttributeFormRelation extends CActiveRecord {

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
		return 'attributeFormRelation';
	}

}