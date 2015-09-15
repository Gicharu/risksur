<?php

/**
 * This is the model class for table "evaQuestionGroups".
 * The followings are the available columns in table 'evaQuestionGroups':
 * @property string $groupId
 * @property string $section
 * @property string $questions
 */
class EvaQuestionGroups extends CActiveRecord {

	public $method;
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'evaQuestionGroups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['section, questions, method', 'required'],
			['section', 'length', 'max' => 80],
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
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return [
			'groupId'   => 'Group',
			'section'   => 'Section',
			'questions' => 'Questions',
			'method' => 'Economic method',
		];
	}

	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EvaQuestionGroups the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return bool
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			$rsMethods = $this->find('section=:section', [':section' => 'econEvaMethods']);
			$this->groupId = $rsMethods->groupId;
			$currentQuestions = json_decode($rsMethods->questions, true);
			//if(isset($currentQuestions[$this->method])) {
			$currentQuestions[$this->method] = $this->questions;
			if($this->scenario == 'delete') {
				unset($currentQuestions[$this->method]);
			}
			$this->questions = json_encode($currentQuestions);

			return true;

		}


	}
}
