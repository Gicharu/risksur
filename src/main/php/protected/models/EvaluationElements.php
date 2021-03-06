<?php

/**
 * EvaluationElements 
 * 
 * @uses CActiveRecord
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class EvaluationElements extends CActiveRecord {
	public $evalElemantsId;
	public $inputName;
	public $label;
	public $inputType;
	public $required;


	/**
	 * @param string $className
	 * @return static
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * tableName
	 *
	 * @access public
	 * @return string
	 */
	public function tableName() {
		return 'evalElements';
	}

	/**
	 * rules 
	 * 
	 * @access public
	 * @return array
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['inputName, label, inputType, required', 'required'],
			['evalElementsId', 'numerical', 'integerOnly' => true, 'on' => 'update'],
			['evalElementsId', 'required', 'on' => 'update'],
			['inputName, inputType', 'length', 'max' => 50],
			['label', 'length', 'max' => 100],
			['inputName', 'match', 'pattern' => '/^[a-zA-Z0-9]{1,20}$/',
				'message' => 'input name should not contain spaces or punctuation.'],
			['elementMetaData', 'safe'],
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			['evalElementsId, inputName, label, inputType, required', 'safe', 'on' => 'search'],];
	}

	/**
	 * primaryKey
	 *
	 * @access public
	 * @return string
	 */
	public function primaryKey() {
		return 'evalElementsId';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
			'options' => [self::HAS_MANY, 'Options', 'elementId'],
			'data' => [self::HAS_MANY, 'EvaluationDetails', 'evalElementsId']
		];
	}

	public static function getFormElements() {
		return [
			'showErrorSummary' => true,
			'showErrors' => true,
			'errorSummaryHeader' => Yii::app()->params['headerErrorSummary'],
			'errorSummaryFooter' => Yii::app()->params['footerErrorSummary'],
			'activeForm' => [
				'id' => 'EvaContextFields',
				'class' => 'CActiveForm',
				'enableClientValidation' => true,
				'clientOptions' => [
					'validateOnSubmit' => true,
				]
			],
			'elements' => [
				'label'     => [
					'type'      => 'textarea',
					'maxlength' => 100,
					//'required'  => 1
				],
//				'inputName' => [
//					'type'      => 'text',
//					'maxlength' => 50,
//					//'required'  => 1
//
//				],
				'elementMetaData' => [
					'type'      => 'textarea',
					//'maxlength' => 50,
					//'required'  => 1

				],
//				'inputType' => [
//					'type'      => 'dropdownlist',
//					'maxlength' => 50,
//					//'required'  => 1,
//					'items' => [
//						'text' => 'Text',
//						'dropdownlist' => 'Drop down list'
//					]
//
//				],
				'required' => [
					'type'      => 'dropdownlist',
					'maxlength' => 50,
					//'required'  => 1,
					'items' => [
						1 => 'Yes',
						0 => 'No'
					]

				]
			],
			'buttons' => [
				'save' => [
					'label' => 'Save',
					'type' => 'submit'
				]
			]
		];
	}

}
