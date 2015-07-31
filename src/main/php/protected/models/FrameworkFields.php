<?php

/**
 * This is the model class for table "frameworkFields".
 * The followings are the available columns in table 'frameworkFields':
 * @property string $id
 * @property string $label
 * @property string $inputName
 * @property string $inputType
 * @property integer $required
 * @property integer $showOnContextList
 * @property string $sectionId
 * @property string $description
 * The followings are the available model relations:
 * @property SurveillanceSections $section
 * @property Options[] $options
 */
class FrameworkFields extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'frameworkFields';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('inputName, inputType, sectionId', 'required'),
			array('required, showOnContextList', 'numerical', 'integerOnly' => true),
			array('label', 'length', 'max' => 50),
			array('sectionId', 'length', 'max' => 11),
			array('description', 'safe'),

		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'section' => array(self::BELONGS_TO, 'SurveillanceSections', 'sectionId'),
			'options' => array(self::HAS_MANY, 'Options', 'frameworkFieldId'),
			'data' => array(self::HAS_MANY, 'FrameworkFieldData', 'frameworkFieldId'),
			//'dataAndOptions' => array(self::HAS_MANY, ['id' => 'frameworkFieldId'])
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'                => 'ID',
			'label'             => 'Label',
			'inputName'         => 'Input Name',
			'inputType'         => 'Input Type',
			'required'          => 'Required',
			'showOnContextList' => 'Show On Context List',
			'sectionId'         => 'Section',
			'description'       => 'Description',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FrameworkFields the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}


}
