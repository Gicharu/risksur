<?php

/**
 * This is the model class for table "evalQuestionAnswers".
 * The followings are the available columns in table 'evalQuestionAnswers':
 * @property string $id
 * @property string $evalQuestionId
 * @property string $optionName
 * The followings are the available model relations:
 * @property EvaluationQuestion $evalQuestion
 */
class EvalQuestionAnswers extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'evalQuestionAnswers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('evalQuestionId, optionName', 'required'),
			array('evalQuestionId', 'length', 'max' => 11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, evalQuestionId, optionName', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'evalQuestion' => array(self::BELONGS_TO, 'EvaluationQuestion', 'evalQuestionId'),
			'nextQuestion' => array(self::BELONGS_TO, 'EvaluationQuestion', 'nextQuestion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'             => 'ID',
			'evalQuestionId' => 'Eval Question',
			'optionName'     => 'Option Name',
			'nextQuestion'     => 'Next Question',
			'url'     => 'URL',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search() {
		// Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('evalQuestionId', $this->evalQuestionId, true);
		$criteria->compare('optionName', $this->optionName, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EvalQuestionOptions the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}
