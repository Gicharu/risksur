<?php

/**
 * This is the model class for table "economicMethods".
 * The followings are the available columns in table 'economicMethods':
 * @property string $id
 * @property string $econMethod
 * @property string $name
 * @property string $description
 * @property string $reference
 */
class EconomicMethods extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'economicMethods';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['econMethod, name, description', 'required'],
			['econMethod', 'length', 'max' => 11],
			['name', 'length', 'max' => 30],
			['reference', 'safe']
		];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
			'econMethodGroup' => [self::BELONGS_TO, 'EconEvaMethods', 'econMethod']
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return [
			'id'          => 'ID',
			'econMethod'  => 'Economic Method',
			'name'        => 'Name',
			'description' => 'Description',
			'reference'   => 'Reference',
		];
	}

	/**
	 *
	 */
	protected function afterFind() {
		$this->description = UtilModel::urlToLink($this->description);
		parent::afterFind();

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EconomicMethods the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}
