<?php

/**
 * EvaluationHeader
 * @uses CActiveRecord
 * @package
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com>
 * @license Tracetracker {@link http://www.tracetracker.com}
 * @SuppressWarnings checkUnusedVariables
 */
class EvaluationHeader extends CActiveRecord {
	//public $evaluationName, $evaluationDescription, $frameworkId, $userId, $evalId;

	/**
	 * model
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
	 * @access public
	 * @return string
	 */
	public function tableName() {
		return 'evaluationHeader';
	}

	/**
	 * primaryKey
	 * @access public
	 * @return string
	 */
	public function primaryKey() {
		return 'evalId';
	}

	/**
	 * rules
	 * @access public
	 * @return array
	 */
	public function rules() {
		return [
			[
				'evaluationName, frameworkId, userId',
				'required'
			],
			[
				'evaluationDescription', 'safe'
			],
			[
				'evaluationName', 'unique', 'on' => 'create'
			]
		];
	}

	/**
	 * relations
	 * @access public
	 * @return array
	 */
	public function relations() {
		return [
			'designFrameworks' => [self::BELONGS_TO, 'FrameworkContext', 'frameworkId'],
			'evalDetails'      => [self::HAS_MANY, 'EvaluationDetails', 'evalId']
		];
	}

	/**
	 * attributeLabels
	 * @access public
	 * @return array
	 */
	public function attributeLabels() {
		return [
			'evaluationName'        => Yii::t('translation', 'Evaluation Name'),
			'evaluationDescription' => Yii::t('translation', 'Description of Evaluation'),
			'frameworkId'           => Yii::t('translation', 'Design Context'),
		];
	}

	public static function getElements() {
		return [
			'evaluationHeader' => [
				'type'     => 'form',
				'elements' => [
					'evaluationName'        => [
						'type'     => 'text',
						'required' => true
					],
					'evaluationDescription' => [
						'type'     => 'text',
						'required' => true
					]
				]

			]
		];
	}
}
