<?php
/**
 * EvaluationDetails 
 * 
 * @uses CActiveRecord
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class EvaluationDetails extends CActiveRecord {


	public function rules() {
		return [
			['evalId', 'required'],
			['evalElementsId, value', 'safe']
		];
	}

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
		return 'evaluationDetails';
	}

	/**
	 * primaryKey 
	 * 
	 * @access public
	 * @return string
	 */
	public function primaryKey() {
		return 'evalDetailsId';
	}

	/**
	 * relations 
	 * 
	 * @access public
	 * @return array
	 */
	public function relations() {
		return array(
			'evaluationHead' => array( self::BELONGS_TO, 'EvaluationHeader', 'evalId' )
		);
	}
}
