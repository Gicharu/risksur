<?php
/**
 * EvaluationHeader 
 * 
 * @uses CActiveRecord
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class EvaluationHeader extends CActiveRecord {

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
		return 'evaluationHeader';
	}

	/**
	 * primaryKey 
	 * 
	 * @access public
	 * @return void
	 */
	public function primaryKey() {
		return 'evalId';
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
				'evaluationName, evaluationDescription, frameworkId, userId',
				'required'
			),
			array(
				'evaluationName', 'unique', 'on' => 'create'
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
			'designFrameworks' => array( self::HAS_MANY, 'NewDesign', 'frameworkId' )
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
			'evaluationName' => Yii::t('translation', 'Evaluation Name'),
			'evaluationDescription' => Yii::t('translation', 'Description of Evaluation'),
			'frameworkId' => Yii::t('translation', 'Design Context'),
		);
	}
}