<?php

/**
 * This is the model class for table "assessmentMethod".
 * The followings are the available columns in table 'assessmentMethod':
 * @property string $assessment_id
 * @property string $assessment_name
 * The followings are the available model relations:
 * @property EvaquestionHasCriteriaAndAssessment[] $evaquestionHasCriteriaAndAssessments
 */
class AssessmentMethod extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'assessmentMethod';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('assessment_name', 'required'),
			array('assessment_name', 'length', 'max' => 100),

		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'evaquestionHasCriteriaAndAssessments' => array(
				self::HAS_MANY, 'EvaquestionHasCriteriaAndAssessment', 'assessment_Id'
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'assessment_id'   => 'Assessment',
			'assessment_name' => 'Assessment Name',
		);
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AssessmentMethod the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}
