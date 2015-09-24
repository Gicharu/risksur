<?php
/**
 * AttributeFormRelation 
 * 
 * @uses CActiveRecord
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class AttributeFormRelation extends CActiveRecord {

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
		return 'attributeFormRelation';
	}

	public function relations() {
		return [
			'attributes' => [self::BELONGS_TO, 'EvaAttributes', 'attributeId'],
			'subForm' => [self::BELONGS_TO, 'SurFormDetails', 'subFormId']

		];
	}
	/**
	 * rules 
	 * 
	 * @access public
	 * @return array
	 */
	public function rules() {
		return array(
			array(
				'attributeId, subFormId',
				'required'
			)
		);
	}

	/**
	 * attributeLabels 
	 * 
	 * @access public
	 * @return array
	 */
	public function attributeLabels() {
		return array(
			'attributeId' => Yii::t('translation', 'Attribute'),
			'subFormId' => Yii::t('translation', 'Form Element')
		);
	}

}
