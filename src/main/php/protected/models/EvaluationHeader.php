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
	public $evaluationName, $evaluationDescription, $frameworkId, $userId, $evalId;
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
	 * @return string
	 */
	public function tableName() {
		return 'evaluationHeader';
	}

	/**
	 * primaryKey 
	 * 
	 * @access public
	 * @return string
	 */
	public function primaryKey() {
		return 'evalId';
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
				'evaluationName, frameworkId, userId',
				'required'
			),
			array(
				'evaluationDescription', 'safe'
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
	 * @return array
	 */
	public function relations() {
		return array(
			'designFrameworks' => array(self::BELONGS_TO, 'FrameworkContext', 'frameworkId'),
			'evalDetails' => array(self::HAS_MANY, 'EvaluationDetails', 'evalId')
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
