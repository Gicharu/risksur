<?php

/**
 * This is the model class for table "evaAttributesMatrix".
 * The followings are the available columns in table 'evaAttributesMatrix':
 * @property string $id
 * @property string $surveillanceObj
 * @property string $evaQuestionGroup
 * @property integer $attributeId
 * @property string $relevance
 * The followings are the available model relations:
 * @property EvaAttributes $attribute
 */
class EvaAttributesMatrix extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'evaAttributesMatrix';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['surveillanceObj, evaQuestionGroup, attributeId, relevance', 'required'],
			['attributeId', 'numerical', 'integerOnly' => true],
			['surveillanceObj, relevance', 'length', 'max' => 1],
			['evaQuestionGroup', 'length', 'max' => 11],
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
			'attribute' => [self::BELONGS_TO, 'EvaAttributes', 'attributeId'],
			'attributeTypes' => [self::BELONGS_TO, 'EvaAttributeTypes',
				['attributeType' => 'id'], 'through' => 'attribute'
			]
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return [
			'id'               => 'ID',
			'surveillanceObj'  => 'Surveillance Obj',
			'evaQuestionGroup' => 'Eva Question Group',
			'attributeId'      => 'Attribute',
			'relevance'        => 'Relevance',
		];
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EvaAttributesMatrix the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}
