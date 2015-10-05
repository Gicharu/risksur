<?php

/**
 * This is the model class for table "evaAttributesAssessmentMethods".
 * The followings are the available columns in table 'evaAttributesAssessmentMethods':
 * @property string $id
 * @property integer $evaAttribute
 * @property string $name
 * @property string $description
 * @property string $dataRequired
 * @property string $expertiseRequired
 * @property string $reference
 * The followings are the available model relations:
 * @property EvaAssessmentMethods[] $evaAssessmentMethods
 * @property EvaAttributes $evaAttribute0
 */
class EvaAttributesAssessmentMethods extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'evaAttributesAssessmentMethods';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['evaAttribute, name, description, dataRequired, expertiseRequired', 'required'],
			['evaAttribute', 'numerical', 'integerOnly' => true],
			['name', 'length', 'max' => 30],
			['reference', 'safe'],
		];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
			'evaAssessmentMethods' => [self::HAS_MANY, 'EvaAssessmentMethods', 'assessmentMethod'],
			'evaAttributes'        => [self::BELONGS_TO, 'EvaAttributes', 'evaAttribute'],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return [
			'id'                => 'ID',
			'evaAttribute'      => 'Evaluation Attribute',
			'name'              => 'Name',
			'description'       => 'Description',
			'dataRequired'      => 'Data Required',
			'expertiseRequired' => 'Expertise Required',
			'reference'         => 'References',
		];
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EvaAttributesAssessmentMethods the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * afterFind
	 */
	protected function afterFind() {
		$this->description = UtilModel::urlToLink($this->description);
		$this->dataRequired = UtilModel::urlToLink($this->dataRequired);
		$this->expertiseRequired = UtilModel::urlToLink($this->expertiseRequired);
		parent::afterFind();

	}
}
