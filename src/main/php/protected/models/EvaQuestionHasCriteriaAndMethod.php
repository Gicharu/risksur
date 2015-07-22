<?php

/**
 * This is the model class for table "evaQuestion_has_criteria_and_method".
 *
 * The followings are the available columns in table 'evaQuestion_has_criteria_and_method':
 * @property string $questionId
 * @property string $criteriaId
 * @property string $methodId
 *
 * The followings are the available model relations:
 * @property EvaluationQuestion $question
 * @property EvaMethods $method
 * @property EvaCriteria $criteria
 */
class EvaQuestionHasCriteriaAndMethod extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'evaQuestion_has_criteria_and_method';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('questionId, criteriaId, methodId', 'required'),
			array('questionId, criteriaId, methodId', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('questionId, criteriaId, methodId', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'question' => array(self::BELONGS_TO, 'EvaluationQuestion', 'questionId'),
			'method' => array(self::BELONGS_TO, 'EvaMethods', 'methodId'),
			'criteria' => array(self::BELONGS_TO, 'EvaCriteria', 'criteriaId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'questionId' => 'Question',
			'criteriaId' => 'Criteria',
			'methodId' => 'Method',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('questionId',$this->questionId,true);
		$criteria->compare('criteriaId',$this->criteriaId,true);
		$criteria->compare('methodId',$this->methodId,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EvaQuestionHasCriteriaAndMethod the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
