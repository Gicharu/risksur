<?php

/**
 * This is the model class for table "evaAssessmentMethods".
 * The followings are the available columns in table 'evaAssessmentMethods':
 * @property string $id
 * @property integer $evaluationId
 * @property integer $evaAttribute
 * @property string $assessmentMethod
 * @property integer $dataAvailable
 * @property string $customAssessmentMethod
 * The followings are the available model relations:
 * @property EvaAttributesAssessmentMethods $assessmentMethod0
 */
class EvaAssessmentMethods extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'evaAssessmentMethods';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['evaluationId, evaAttribute, dataAvailable', 'required', 'on' => 'default'],
			['evaluationId, evaAttribute, customAssessmentMethod', 'required', 'on' => 'customMethod'],
			['customAssessmentMethod', 'safe'],
			['evaluationId, evaAttribute, dataAvailable', 'numerical', 'integerOnly' => true],
			['assessmentMethod', 'length', 'max' => 11],

		];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
			'evaAttrAssMethods' => [self::BELONGS_TO, 'EvaAttributesAssessmentMethods', 'assessmentMethod'],
			'evaluationAttributes' => [self::BELONGS_TO, 'EvaAttributes', 'evaAttribute'],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return [
			'id'                     => 'ID',
			'evaluationId'           => 'Evaluation',
			'evaAttribute'           => 'Evaluation Attribute',
			'assessmentMethod'       => 'Assessment Method',
			'customAssessmentMethod' => 'Custom Assessment Method',
		];
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EvaAssessmentMethods the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}