<?php

/**
 * This is the model class for table "evaAssessmentMethods".
 * The followings are the available columns in table 'evaAssessmentMethods':
 * @property string $id
 * @property integer $evaluationId
 * @property integer $evaAttribute
 * @property string $expertise
 * @property string $methodDescription
 * @property string $dataAvailability
 * @property string $references
 */
class EvaAssessmentMethods extends CActiveRecord {

	public $evaAttributeName;
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
			['evaluationId, evaAttribute, expertise, methodDescription, dataAvailability', 'required'],
			['evaluationId, evaAttribute', 'numerical', 'integerOnly' => true],
			['dataAvailability', 'length', 'max' => 22],
			['references', 'safe']
		];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
			'evaluationAttributes' => [self::BELONGS_TO, 'EvaAttributes', 'evaAttribute', 'select' => 'name']
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return [
			'id'                => 'ID',
			'evaluationId'      => 'Evaluation',
			'evaAttribute'      => 'Eva Attribute',
			'expertise'         => 'Expertise',
			'methodDescription' => 'Method Description',
			'dataAvailability'  => 'Data Availability',
			'references'        => 'References',
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

	/**
	 * afterFind
	 */
	protected function afterFind() {
		$expertiseArray = explode(',', $this->expertise);
		$this->expertise = $expertiseArray;
		return parent::afterFind();
	}

	/**
	 * afterValidate
	 */
	protected function afterValidate() {
		$expertiseString = implode(',', $this->expertise);
		$this->expertise = $expertiseString;
		return parent::afterValidate();
	}

	/**
	 * afterSave
	 */
	protected function afterSave() {
		$expertiseArray = explode(',', $this->expertise);
		$this->expertise = $expertiseArray;
		return parent::afterSave();
	}

}
