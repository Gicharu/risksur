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
    public $formId;
    public $inputName;
    public $label;
    public $inputType;
    public $required;

    /**
     * model
     *
     * @param mixed $className
     * @static
     * @access public
     * @return void
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * tableName
     *
     * @access public
     * @return void
     */
    public function tableName() {
        return 'surFormDetails';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(array('formId, inputName, label, inputType, required', 'required'),
            array('formId', 'numerical', 'integerOnly' => true),
            array('inputName, label, inputType', 'length', 'max' => 50),
            array('inputName', 'match', 'pattern'=>'/^[a-zA-Z0-9]{1,20}$/',
                'message' => 'input name should not contain spaces or punctuation.'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('subFormId, formId, inputName, label, inputType, required', 'safe', 'on' => 'search'),);
    }

    /**
     * relations
     *
     * @access public
     * @return void
     */
    public function relations() {
        return array('surFormElements' => array(self::BELONGS_TO, 'SurForm', 'formId'));
    }

    /**
     * primaryKey
     *
     * @access public
     * @return void
     */
    public function primaryKey() {
        return 'subFormId';
    }

    /**
     * @return array
     */
    public function attributeLabels() {
        return array('formId' => Yii::t('translation', 'Status'),);
    }
}
