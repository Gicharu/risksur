<?php
/**
 * FrameworkDetails 
 * 
 * @uses CActiveRecord
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class FrameworkDetails extends CActiveRecord {
	//public $name;
	//public $description;
	//public $goal;
	//public $component;

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
		return 'frameworkDetails';
	}

	/**
	 * primaryKey 
	 * 
	 * @access public
	 * @return void
	 */
	public function primaryKey() {
		return 'frameworkDetailsId';
	}
	/**
	 * rules 
	 * 
	 * @access public
	 * @return void
	 */
	//public function rules() {
		//return array(
			//array(
				//'name, description, goalId, userId',
				//'required'
			//),
			//array(
				//'name',
				//'unique'
			//)
		//);
	//}

	/**
	 * relations 
	 * 
	 * @access public
	 * @return void
	 */
	public function relations() {
		return array(
			'frameDetails' => array( self::BELONGS_TO, 'NewDesign', 'frameworkId' )
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
