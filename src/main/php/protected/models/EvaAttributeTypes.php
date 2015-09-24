<?php

/**
 * This is the model class for table "evaAttributeTypes".
 * The followings are the available columns in table 'evaAttributeTypes':
 * @property string $id
 * @property string $name
 * The followings are the available model relations:
 * @property EvaAttributes[] $evaAttributes
 */
class EvaAttributeTypes extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'evaAttributeTypes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['name', 'required'],
			['name', 'length', 'max' => 20],
		];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
			'evaAttributes' => [self::HAS_MANY, 'Attributes', 'attributeType'],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return [
			'id'   => 'ID',
			'name' => 'Name',
		];
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EvaAttributeTypes the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}
