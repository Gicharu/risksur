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
	 * @return static
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
				'required', 'on' => 'create, update'
			],
			[
				'evaluationDescription', 'safe'
			],
			[
				'evaAttributes', 'required', 'on' => 'selectEvaAttributes'
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
			'frameworks' => [self::BELONGS_TO, 'FrameworkContext', 'frameworkId',
				'select' => 'name'
			],
			'question' => [self::BELONGS_TO, 'EvaluationQuestion', 'questionId',
				'select' => 'question'
			],
			'evalDetails' => [self::HAS_MANY, 'EvaluationDetails', 'evalId'],
			'evaCriteriaMethods' => [self::HAS_MANY, 'EvaQuestionHasCriteriaAndMethod',
				['evalQuestionId' => 'questionId'], 'through' => 'question'],
			'evaMethods' => [self::HAS_MANY, 'EvaMethods', ['methodId' => 'evaMethodId'],
				'through' => 'evaCriteriaMethods'],
			'evaCriteria' => [self::HAS_MANY, 'EvaCriteria', ['criteriaId' => 'criteriaId'],
				'through' => 'evaCriteriaMethods']
		];
	}

	protected function afterSave() {
		if($this->scenario == 'selectEvaAttributes') {
			$evaAttribsArray = json_decode($this->evaAttributes);
			$assMethodsCriteria = new CDbCriteria();
			$assMethodsCriteria->condition = 'evaluationId=' . $this->evalId;
			$assMethodsCriteria->addNotInCondition('evaAttribute', $evaAttribsArray);
			EvaAssessmentMethods::model()->deleteAll($assMethodsCriteria);
			return parent::afterSave();


		}
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
			'evaAttributes'           => Yii::t('translation', 'Evaluation Attribute'),
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
