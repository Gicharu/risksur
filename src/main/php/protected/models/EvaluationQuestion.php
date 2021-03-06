<?php

/**
 * This is the model class for table "evaluationQuestion".
 * The followings are the available columns in table 'evaluationQuestion':
 * @property string $evalQuestionId
 * @property string $question
 * @property string $parentQuestion
 * The followings are the available model relations:
 * @property EvalQuestionOptions[] $evalQuestionOptions
 */
class EvaluationQuestion extends CActiveRecord {

	public $answer;
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'evaluationQuestion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['question, questionNumber', 'required'],
			['parentQuestion', 'length', 'max' => 11],
			['answer', 'required', 'on' => 'wizard']
			// The following rule is used by search().
			//array('evalQuestionId, question, parentQuestion', 'safe', 'on'=>'search'),
		];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'evalQuestionAnswers' => [self::HAS_MANY, 'EvalQuestionAnswers', 'evalQuestionId'],
			'evaCriteriaMethod' => [self::HAS_MANY, 'EvaQuestionHasCriteriaAndMethod', 'questionId'],
			'methods' => [self::HAS_MANY, 'EvaMethods', ['methodId' => 'evaMethodId'],
				'through' => 'evaCriteriaMethod'],
			'criteria' => [self::HAS_MANY, 'EvaCriteria', ['criteriaId' => 'criteriaId'],
				'through' => 'evaCriteriaMethod']
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'evalQuestionId' => 'Evaluation Question Id',
			'question'       => 'Question',
			'parentQuestion' => 'Parent Question',
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

		$criteria->compare('evalQuestionId', $this->evalQuestionId, true);
		$criteria->compare('question', $this->question, true);
		$criteria->compare('parentQuestion', $this->parentQuestion, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EvaluationQuestion the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @param $model
	 * @return array
	 */
	public function getItems($model) {
		$items = array();
		foreach($model as $item) {
			if(empty($item->url)) {
				$items[$item->id] = $item->optionName;
			}
		}
		//print_r($items); die;
		return $items;
	}
}
