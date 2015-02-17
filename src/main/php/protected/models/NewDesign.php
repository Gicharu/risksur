<?php
/**
 * NewDesign 
 * 
 * @uses CActiveRecord
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class NewDesign extends CActiveRecord {
	public $name;
	public $description;
	//public $goal;
	public $component;

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
		return 'frameworkHeader';
	}

	/**
	 * primaryKey 
	 * 
	 * @access public
	 * @return void
	 */
	public function primaryKey() {
		return 'frameworkId';
	}
	/**
	 * rules 
	 * 
	 * @access public
	 * @return void
	 */
	public function rules() {
		return array(
			array(
				'name, description, goalId, userId',
				'required'
			),
			array(
				'name', 'unique', 'on' => 'create'
			)
		);
	}

	/**
	 * relations 
	 * 
	 * @access public
	 * @return void
	 */
	public function relations() {
		return array(
			'goal' => array( self::BELONGS_TO, 'GoalData', 'goalId' ),
			'designHead' => array( self::HAS_MANY, 'FrameworkDetails', 'frameworkDetailsId' )
		);
	}
	/**
	 * attributeLabels 
	 * 
	 * @access public
	 * @return void
	 */
	public function attributeLabels() {
		return array(
			'name' => Yii::t('translation', 'Design Name'),
			'description' => Yii::t('translation', 'Description of design'),
			'goalId' => Yii::t('translation', 'Goal'),
			'component' => Yii::t('translation', 'Component')
		);
	}
}
