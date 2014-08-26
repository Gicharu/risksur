<?php
/**
 * GoalData 
 * 
 * @uses CActiveRecord
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class GoalData extends CActiveRecord {
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
		return 'goalMenu';
	}

	public function relations() {
		return array(
			'surveillance' => array( self::HAS_MANY, 'NewDesign', 'goalId' )
		);
	}
	/**
	 * primaryKey 
	 * 
	 * @access public
	 * @return void
	 */
	public function primaryKey() {
		return 'pageId';
	}
}
