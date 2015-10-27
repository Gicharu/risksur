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
	public $frameworkId;
	public $userId;
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
				'name, userId',
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
		return [
			//'goal' => array( self::BELONGS_TO, 'GoalData', 'goalId' ),
			'designHead' => [ self::HAS_MANY, 'FrameworkDetails', 'frameworkDetailsId' ],
			'data' => [
				self::HAS_MANY,
				'FrameworkFieldData',
				'frameworkId',
				'select' => 'frameworkFieldId, value'
			],
			'fields' => [
				self::HAS_MANY,
				'FrameworkFields',
				['frameworkFieldId' => 'id'],
				'through' => 'data',
				'select' => 'inputName, inputType',
				//'condition' => "inputName='hazardName' OR inputName='survObj'"
			],
		];
	}
	/**
	 * attributeLabels
	 *
	 * @access public
	 * @return array
	 */
	public function attributeLabels() {
		return array(
			'name' => Yii::t('translation', 'Surveillance System Name'),
			'description' => Yii::t('translation', 'Surveillance Description'),
		);
	}

}
