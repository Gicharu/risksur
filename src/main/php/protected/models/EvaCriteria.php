<?php

/**
 * This is the model class for table "evaCriteria".
 * The followings are the available columns in table 'evaCriteria':
 * @property string $criteria_id
 * @property string $criteria_name
 * The followings are the available model relations:
 * @property EvaquestionHasCriteriaAndAssessment[] $evaquestionHasCriteriaAndAssessments
 */
class EvaCriteria extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'evaCriteria';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('criteria_name', 'required'),
			array('criteria_name', 'length', 'max' => 100),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'evaquestionHasCriteriaAndAssessments' => array(self::HAS_MANY, 'EvaquestionHasCriteriaAndAssessment', 'criteria_Id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'criteria_id'   => 'Criteria',
			'criteria_name' => 'Criteria Name',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EvaCriteria the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}
