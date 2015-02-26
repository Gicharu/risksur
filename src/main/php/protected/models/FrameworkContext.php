<?php
/**
 * FrameworkContext
 * 
 * @uses CActiveRecord
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 * @SuppressWarnings checkUnusedVariables
 */
class FrameworkContext extends CActiveRecord {
	public $name;
	public $description;
	//public $goal;
	//public $component;


	/**
	 * @param string $className
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
		return 'frameworkHeader';
	}

	/**
	 * primaryKey 
	 * 
	 * @access public
	 * @return string
	 */
	public function primaryKey() {
		return 'frameworkId';
	}
	/**
	 * rules 
	 * 
	 * @access public
	 * @return array
	 */
	public function rules() {
		return array(
			array(
				'name, description, userId',
				'required'
			),
			array(
				'name', 'unique', 'on' => 'insert'
			)
		);
	}

	/**
	 * relations 
	 * 
	 * @access public
	 * @return array
	 */
	public function relations() {
		return array(
			//'goal' => array( self::BELONGS_TO, 'GoalData', 'goalId' ),
			'designHead' => array( self::HAS_MANY, 'FrameworkDetails', 'frameworkDetailsId' )
		);
	}
	/**
	 * attributeLabels
	 *
	 * @access public
	 * @return array
	 */
	public function attributeLabels() {
		return array(
			'name' => Yii::t('translation', 'Context Name'),
			'description' => Yii::t('translation', 'Description of context'),
		);
	}
}
