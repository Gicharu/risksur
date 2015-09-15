<?php

/**
 * This is the model class for table "evaAttributes".
 * The followings are the available columns in table 'evaAttributes':
 * @property integer $attributeId
 * @property string $name
 * @property string $description
 * @property string $attributeType
 */
class EvaAttributes extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'evaAttributes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['name, description, attributeType', 'required'],
			['name', 'length', 'max' => 50],
			['attributeType', 'length', 'max' => 11]
			// The following rule is used by search().

		];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
			'attributeTypes' => [self::BELONGS_TO, 'EvaAttributeTypes', 'attributeType']
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return [
			'attributeId'   => 'Attribute',
			'name'          => 'Name',
			'description'   => 'Description',
			'attributeType' => 'Attribute Type',
		];
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EvaAttributes the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	protected function afterFind() {
		$this->description = UtilModel::urlToLink($this->description);
		parent::afterFind();

	}
}
