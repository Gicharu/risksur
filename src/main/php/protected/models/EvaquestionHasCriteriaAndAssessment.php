<?php

/**
 * This is the model class for table "evaquestion_has_criteria_and_assessment".
 * The followings are the available columns in table 'evaquestion_has_criteria_and_assessment':
 * @property string $question_Id
 * @property string $criteria_Id
 * @property string $assessment_Id
 * The followings are the available model relations:
 * @property AssessmentMethod $assessment
 * @property EvaCriteria $criteria
 * @property EvaluationQuestion $question
 */
class EvaquestionHasCriteriaAndAssessment extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'evaquestion_has_criteria_and_assessment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('question_Id, criteria_Id, assessment_Id', 'required'),
			array('question_Id, criteria_Id, assessment_Id', 'length', 'max' => 11),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'assessment' => array(self::BELONGS_TO, 'AssessmentMethod', 'assessment_Id'),
			'criteria'   => array(self::BELONGS_TO, 'EvaCriteria', 'criteria_Id'),
			'question'   => array(self::BELONGS_TO, 'EvaluationQuestion', 'question_Id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'question_Id'   => 'Question',
			'criteria_Id'   => 'Criteria',
			'assessment_Id' => 'Assessment',
		);
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EvaquestionHasCriteriaAndAssessment the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}
