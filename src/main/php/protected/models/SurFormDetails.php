<?php

/**
 * SurFormDetails
 *
 * @uses CActiveRecord
 * @package
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com>
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class SurFormDetails extends CActiveRecord {
	public $inputName;
	public $label;
	public $inputType;
	public $required;
	public $description;
	public $showOnMultiForm;
	public $showOnComponentList;
	public $url;
	public $moreInfo;
	public $value;

	/**
	 * model
	 *
	 * @param mixed $className
	 * @static
	 * @access public
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
		return 'surFormDetails';
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
		return array(array('sectionId, inputName, label, inputType, required, showOnComponentList, showOnMultiForm', 'required'),
			array('description, moreInfo, url', 'safe'),
			array('inputName, label, inputType', 'length', 'max' => 50),
			array('inputName', 'match', 'pattern' => '/^[a-zA-Z0-9]{1,20}$/',
				'message' => 'input name should not contain spaces or punctuation.'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subFormId, formId, inputName, label, inputType, required', 'safe', 'on' => 'search'),);
	}

	/**
	 * relations
	 *
	 * @access public
	 * @return array
	 */
	public function relations() {
		return array('surFormDetails' => array(self::HAS_MANY, 'ComponentDetails', 'subFormId'));
	}

	/**
	 * primaryKey
	 *
	 * @access public
	 * @return string
	 */
	public function primaryKey() {
		return 'subFormId';
	}

	/**
	 * @return array
	 */
	public function attributeLabels() {
		return array('sectionId' => Yii::t('translation', 'Section Name'), );
	}
}
