<?php

/**
 * This is the model class for table "surveillanceSections".
 * The followings are the available columns in table 'surveillanceSections':
 * @property string $sectionId
 * @property string $sectionName
 * @property string $description
 * The followings are the available model relations:
 * @property FrameworkFields[] $frameworkFields
 */
 class SurveillanceSections extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'surveillanceSections';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['sectionName', 'required'],
			['sectionName', 'length', 'max' => 30],
			['description', 'safe'],
		];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'frameworkFields' => array(self::HAS_MANY, 'FrameworkFields', 'sectionId'),
			'survData' => array(self::HAS_MANY, 'FrameworkFieldData', array('id' => 'frameworkFieldId'),
				'through' => 'frameworkFields'),
			'designFields' => array(self::HAS_MANY, 'SurFormDetails', 'sectionId',
				'order' => '`sectionNumber` ASC, `order` ASC'),
			'designData' => array(self::HAS_MANY, 'ComponentDetails', array('subFormId' => 'subFormId'),
				'through' => 'designFields'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'sectionId'   => 'Section',
			'sectionName' => 'Section Name',
		);
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SurveillanceSections the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function __sleep() {
		die('poop');
		return $this->attributes;
	}
}
